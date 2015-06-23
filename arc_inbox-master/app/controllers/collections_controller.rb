class CollectionsController < ApplicationController
  before_filter :has_permission?

  def editor
    if !current_user.is_editor
      redirect_to ('/')
    end
  end
  
  def contributor
    #return unless is_role("contributor")
  end
  
  def new_submission
    #return unless is_role("contributor")
    flash[:notice] = nil
      
    # This creates a record in the collections table, a record in the uploaded_files table, and uploads a file.
    file_name = params[:file_name]
    notes = params[:notes]
    project_name = params[:project_name]
    project_url = params[:project_url]
    default_thumbnail = params[:default_thumbnail]
    err_msg = submission_error_check(project_name, project_url, file_name)
    if err_msg != ""
      flash[:notice] = err_msg
      redirect_to :action => 'contributor', :project_name => project_name, :project_url => project_url, :default_thumbnail => default_thumbnail, 
        :notes => notes, :file_name => file_name
      return
    end
    
    # create a new record in both the file table and the collection table
    uploaded_file = save_file(file_name, project_name)

    rec = { :contributor_id => current_user.id, :last_editor_id => nil, :latest_file_id => uploaded_file.id, 
      :current_status => Collection.to_status_int("New"), :classification => Collection.to_classification_int("[Not Classified]"), :notes => notes,
      :admin_notes => "", :project_name => project_name, :project_url => project_url, :default_thumbnail => default_thumbnail }
    collection = Collection.new(rec)
    collection.save
    append_to_users_log(collection)

    begin
      UserMailer.new_submission(current_user, collection).deliver
    rescue Exception => msg
      logger.error("**** ERROR: Can't send email: " + msg.to_s)
    end
    redirect_to :action => 'confirm_submission', :id => collection.id, :controller => 'collections' #confirm_submission_path
  end

  def resubmit_submission
    logger.info("------ resubmit_submission")
    id = params[:id]
    file_name = params[:file_name]
    notes = params[:notes]
    project_name = Collection.find(id).project_name
    project_url = params[:project_url]
    default_thumbnail = params[:default_thumbnail]

    err_msg = submission_error_check(project_name, project_url, file_name)
    if err_msg != ""
      flash[:notice] = err_msg
      redirect_to :action => 'resubmit', :id => id
      return
    end
    uploaded_file = save_file(file_name, project_name)
    resubmit_file(id, uploaded_file, project_name, project_url, default_thumbnail, notes)
    begin
      UserMailer.resubmit(current_user, Collection.find(id)).deliver
    rescue Exception => msg
      logger.error("**** ERROR: Can't send email: " + msg.to_s)
    end
    redirect_to :action => 'confirm_submission', :id => id, :controller => 'collections' #confirm_submission_path
  end
  
  def resubmit
  end
  
  def denial_comment_submitted
    id = params[:id]
    notes = params[:notes]
    collection = Collection.find(id)
    change_status(id, Collection.to_status_int("Denied"), current_user.id)
    change_notes(id, collection.notes + "\n" + notes)
    UserMailer.denied(collection.contributor, collection, notes).deliver
    redirect_to :action => 'editor'
  end
  
  def textarea_changed
    id = params[:id]
    astr = id.split('-')
    notes_str = params[:textarea]
    if astr[2] == "editor"
      ed_id = current_user.id
      redirect_action = 'editor'
    else
      ed_id = -1
      redirect_action = 'contributor'
    end
    if astr[1] == "notes"
      change_notes(astr[0], notes_str, ed_id)
    else
      change_admin_notes(astr[0], notes_str, ed_id)
    end
    
    if astr[1] == "notes" # only send email if the notes field changed. If the admin field changed, don't send
      begin
        # the message is different when the editor changes the note or the user changes the note.
        if astr[2] == "editor"
          UserMailer.editor_changed_note(get_contributor(id), Collection.find(id)).deliver
        else
          UserMailer.contributor_changed_note(Collection.find(id)).deliver
        end
      rescue Exception => msg
        logger.error("**** ERROR: Can't send email: " + msg.to_s)
      end
    end
    redirect_to :action => redirect_action
  end
  
  def classification_changed
    id = params[:id]
    astr = id.split('-')
    classification_str = params[:classification]
    logger.info(">>>>>>>>>>> classification_changed: #{id} -- #{classification_str}")

    change_classification(astr[0], classification_str, current_user.id)
    
    redirect_to :action => 'editor'
  end
  
  def status_changed
    id = params[:id]
    status = params[:status]
    collection = Collection.find(id)
    logger.info("----> status_changed(#{Collection.to_status_string(status.to_i)})")
    if Collection.to_status_string(status.to_i) == "Denied"
      redirect_to :action => 'denial_comment', :id => id
      return
    end

    change_status(id, status, current_user.id)

    begin    
      case Collection.to_status_string(status.to_i)
      when "In Progress" then UserMailer.in_progress(get_contributor(id), collection).deliver
      when "In Peer Review" then UserMailer.in_peer_review(get_contributor(id), collection).deliver
      when "Is Staged" then UserMailer.is_staged(get_contributor(id), collection).deliver
      when "In Production" then UserMailer.in_production(get_contributor(id), collection).deliver
      when "Deleted" then UserMailer.editor_deletes(get_contributor(id), collection).deliver
      else logger.info("status changed to something that doesn't have a confirmation message: #{status}")
      end
    rescue Exception => msg
      logger.error("**** ERROR: Can't send email: " + msg.to_s)
    end
    redirect_to :action => 'editor'
  end
  
  # def update_memo
  #   id = params[:id]
  #   notes = params[:notes]
  #   # TODO: update record
  #   # TODO: recreate current page (so that this can be used in both contributor and editor pages)
  #   begin
  #     UserMailer.editor_changes_note(current_user, "").deliver
  #   rescue Exception => msg
  #     logger.error("**** ERROR: Can't send email: " + msg)
  #   end
  #   redirect_to :action => 'contributor'
  # end

  def cancel_submission
    id = params[:id]
    change_status(id, Collection.to_status_int("Deleted"))
    append_to_users_log(Collection.find(id))
    begin
      UserMailer.contributor_deletes(Collection.find(id)).deliver
    rescue Exception => msg
      logger.error("**** ERROR: Can't send email: " + msg.to_s)
    end
    redirect_to :action => 'contributor'
  end

  #def logout
  #  current_user = nil
  #  redirect_to :controller => 'home', :action => 'index'
  #end
  
  def confirm_submission
  end
  
  private
  
  def submission_error_check(project_name, project_url, file_name)
    if project_name == "" && project_url == "" && file_name.blank?
      return "The Project Name, Project URL, and File Name fields must not be blank"
    elsif project_url == "" && file_name.blank?
      return "The Project URL and File Name fields must not be blank"
    elsif project_name == "" && file_name.blank?
      return "The Project Name and File Name fields must not be blank"
    elsif project_name == "" && project_url == ""
      return "The Project Name and Project URL fields must not be blank"
    elsif project_name == ""
      return "The Project Name field must not be blank"
    elsif project_url == ""
      return "The Project URL field must not be blank"
    elsif file_name.blank?
      return "The File Name field must not be blank"
    end
    return ""
  end
  
  def get_contributor(collection_id)
    collection = Collection.find(collection_id)
    return collection.contributor
  end
  
  def change_status (id, status_int, editor_id = -1)
    collection = Collection.find(id)
    collection.update_attribute(:current_status, status_int)
    if editor_id >= 0
      collection.update_attribute(:last_editor_id, editor_id)
    end
  end
  
  def change_notes (id, notes_str, editor_id = -1)
    collection = Collection.find(id)
    collection.update_attribute(:notes, notes_str)
    if editor_id >= 0
      collection.update_attribute(:last_editor_id, editor_id)
    end
  end
  
  def change_classification(id, classification_str, editor_id = -1)
    collection = Collection.find(id)
    collection.update_attribute(:classification, classification_str)
    if editor_id >= 0
      collection.update_attribute(:last_editor_id, editor_id)
    end
  end
  
  def change_admin_notes (id, notes_str, editor_id = -1)
    collection = Collection.find(id)
    collection.update_attribute(:admin_notes, notes_str)
    if editor_id >= 0
      collection.update_attribute(:last_editor_id, editor_id)
    end
  end
  
  def resubmit_file(id, uploaded_file, project_name, project_url, default_thumbnail, notes)
    collection = Collection.find(id)
    collection.update_attribute(:latest_file_id, uploaded_file.id)
    collection.update_attribute(:notes, notes)
    collection.update_attribute(:project_name, project_name)
    collection.update_attribute(:project_url, project_url)
    collection.update_attribute(:default_thumbnail, default_thumbnail)
    collection.update_attribute(:current_status, Collection.to_status_int("New"))
    append_to_users_log(collection)
  end
  
  def save_file(file_name, project_name)
    base_path = "uploads"
    orig_path = file_name.original_filename
    recv_path = UploadedFile.make_received_filename(base_path, orig_path, current_user, project_name)
    real_path = "#{base_path}/#{recv_path}"
    make_all_folders(real_path)
    #Dir.mkdir(base_path) unless File.exists?(base_path)
    #Dir.mkdir(File.dirname(real_path)) unless File.exists?(File.dirname(real_path))
    File.open(real_path, "wb") { |f| f.write(file_name.read) }
    rec = { :original_name => orig_path, :received_name => recv_path }
    uploaded_file = UploadedFile.new(rec)
    uploaded_file.save
    return uploaded_file
  end

  def make_all_folders(path)
    astr = File.dirname(path).split("/")
    folder = ""
    astr.each {|f|
      folder += f  + "/"
      Dir.mkdir(folder) unless File.exists?(folder)
    }
  end
  
  def append_to_users_log(collection)
    real_path = collection.latest_file.received_name
    log_entry = "------------------------------------\n"
    log_entry += "DELETED: " unless collection.current_status != Collection.to_status_int("Deleted")
    log_entry += "#{collection.updated_at} File name: #{real_path}\n"
    log_entry += "    Project Name: #{collection.project_name}\n    URL: #{collection.project_url}\n    Thumbnail: #{collection.default_thumbnail}\n"
    log_entry += "#{collection.notes}\n"
    
    # We write the log entry in two places: the project folder and also one level up in the user's folder
    log_path = "uploads/" + File.dirname(real_path) + "/upload_history.log"
    File.open(log_path, "a") do |file|
      file.puts(log_entry)
    end

    log_path = "uploads/" + File.dirname(File.dirname(real_path)) + "/upload_history.log"
    File.open(log_path, "a") do |file|
      file.puts(log_entry)
    end
  end

  public
  
  ###################################################################################################
  # GET /collections
  # GET /collections.xml
  def index
    if !current_user.is_editor
      redirect_to ('/')
      return
    end

    @collections = Collection.all

    respond_to do |format|
      format.html # index.html.erb
      format.xml  { render :xml => @collections }
    end
  end

  # GET /collections/1
  # GET /collections/1.xml
  def show
    if !current_user.is_editor
      redirect_to ('/')
      return
    end

    @collection = Collection.find(params[:id])

    respond_to do |format|
      format.html # show.html.erb
      format.xml  { render :xml => @collection }
    end
  end

  # GET /collections/new
  # GET /collections/new.xml
  def new
    if !current_user.is_editor
      redirect_to ('/')
      return
    end

    @collection = Collection.new

    respond_to do |format|
      format.html # new.html.erb
      format.xml  { render :xml => @collection }
    end
  end

  # GET /collections/1/edit
  def edit
    if !current_user.is_editor
      redirect_to ('/')
      return
    end

    @collection = Collection.find(params[:id])
  end

  # POST /collections
  # POST /collections.xml
  def create
    if !current_user.is_editor
      redirect_to ('/')
      return
    end

    @collection = Collection.new(params[:collection])

    respond_to do |format|
      if @collection.save
        flash[:notice] = 'Collection was successfully created.'
        format.html { redirect_to(@collection) }
        format.xml  { render :xml => @collection, :status => :created, :location => @collection }
      else
        format.html { render :action => "new" }
        format.xml  { render :xml => @collection.errors, :status => :unprocessable_entity }
      end
    end
  end

  # PUT /collections/1
  # PUT /collections/1.xml
  def update
    if !current_user.is_editor
      redirect_to ('/')
      return
    end

    @collection = Collection.find(params[:id])

    respond_to do |format|
      if @collection.update_attributes(params[:collection])
        flash[:notice] = 'Collection was successfully updated.'
        format.html { redirect_to(@collection) }
        format.xml  { head :ok }
      else
        format.html { render :action => "edit" }
        format.xml  { render :xml => @collection.errors, :status => :unprocessable_entity }
      end
    end
  end

  # DELETE /collections/1
  # DELETE /collections/1.xml
  def destroy
    if !current_user.is_editor
      redirect_to ('/')
      return
    end

    @collection = Collection.find(params[:id])
    @collection.destroy

    respond_to do |format|
      format.html { redirect_to(collections_url) }
      format.xml  { head :ok }
    end
  end
end
