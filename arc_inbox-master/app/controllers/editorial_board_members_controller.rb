class EditorialBoardMembersController < ApplicationController
  before_filter :must_be_editor
  
  # GET /editorial_board_members
  # GET /editorial_board_members.xml
  def index
    @editorial_board_members = EditorialBoardMember.all

    respond_to do |format|
      format.html # index.html.erb
      format.xml  { render :xml => @editorial_board_members }
    end
  end

  # GET /editorial_board_members/1
  # GET /editorial_board_members/1.xml
  def show
    @editorial_board_member = EditorialBoardMember.find(params[:id])

    respond_to do |format|
      format.html # show.html.erb
      format.xml  { render :xml => @editorial_board_member }
    end
  end

  # GET /editorial_board_members/new
  # GET /editorial_board_members/new.xml
  def new
    @editorial_board_member = EditorialBoardMember.new

    respond_to do |format|
      format.html # new.html.erb
      format.xml  { render :xml => @editorial_board_member }
    end
  end

  # GET /editorial_board_members/1/edit
  def edit
    @editorial_board_member = EditorialBoardMember.find(params[:id])
  end

  # POST /editorial_board_members
  # POST /editorial_board_members.xml
  def create
    @editorial_board_member = EditorialBoardMember.new(params[:editorial_board_member])

    respond_to do |format|
      if @editorial_board_member.save
        flash[:notice] = 'EditorialBoardMember was successfully created.'
        format.html { redirect_to(@editorial_board_member) }
        format.xml  { render :xml => @editorial_board_member, :status => :created, :location => @editorial_board_member }
      else
        format.html { render :action => "new" }
        format.xml  { render :xml => @editorial_board_member.errors, :status => :unprocessable_entity }
      end
    end
  end

  # PUT /editorial_board_members/1
  # PUT /editorial_board_members/1.xml
  def update
    @editorial_board_member = EditorialBoardMember.find(params[:id])

    respond_to do |format|
      if @editorial_board_member.update_attributes(params[:editorial_board_member])
        flash[:notice] = 'EditorialBoardMember was successfully updated.'
        format.html { redirect_to(@editorial_board_member) }
        format.xml  { head :ok }
      else
        format.html { render :action => "edit" }
        format.xml  { render :xml => @editorial_board_member.errors, :status => :unprocessable_entity }
      end
    end
  end

  # DELETE /editorial_board_members/1
  # DELETE /editorial_board_members/1.xml
  def destroy
    @editorial_board_member = EditorialBoardMember.find(params[:id])
    @editorial_board_member.destroy

    respond_to do |format|
      format.html { redirect_to(editorial_board_members_url) }
      format.xml  { head :ok }
    end
  end
end
