class UsersController < ApplicationController
  include UsersHelper
  # Protect these actions behind an admin login
  # before_filter :admin_required, :only => [:suspend, :unsuspend, :destroy, :purge]
  before_filter :find_user, :only => [:suspend, :unsuspend, :destroy, :purge]
  
  # render new.rhtml
  def new
	  @user = User.new
    return unless must_be_editor
  end

  def delete_account
    return unless must_be_editor
  end

  #def reset_password
  #  email = params[:email]
  #  user = User.find(:first, :conditions => [ "email = ?", params[:email] ] )
  #  if user == nil
  #    logger.info(">>>>> A user attempted to reset a password for the email: #{email}, but that account doesn't exist, so the request is being ignored.")
  #  else
  #    new_password = generate_password()
  #    begin
  #      UserMailer.new_password(user, new_password).deliver
  #    rescue Exception => msg
  #      logger.error("**** ERROR: Can't send email: " + msg)
  #    end
  #    user.password = new_password
  #    user.update_attribute(:crypted_password, user.encrypt(new_password))
  #
  #    flash[:notice] = "Your new password has been sent to you by email. Please wait for that message, then try to log in again"
  #  end
  #  redirect_to :controller => 'home', :action => 'index'
  #end
  
  def delete
    return unless must_be_editor

    acct = params[:account]
    user = User.find(acct)
    begin
      UserMailer.account_deleted(user).deliver
    rescue Exception => msg
      logger.error("**** ERROR: Can't send email: " + msg.to_s)
    end
    user.update_attribute(:disabled, "1")
    #user.destroy
    redirect_to :controller => 'collections', :action => 'editor'
  end
  
  #def edit
  #  if params[:password] != "" || params[:password_confirm] != ""
  #    if params[:password] == params[:password_confirm]
  #      current_user.password = params[:password]
  #      current_user.update_attribute(:crypted_password, current_user.encrypt(params[:password]))
  #    else
  #      flash[:notice] = "Passwords don't match. Please try again."
  #      redirect_to update_account_path
  #      return
  #    end
  #  end
  #
  #  curr_email = current_user.email
  #  curr_real_name = current_user.real_name
  #  curr_institution = current_user.institution
  #  changed = false
  #  email_changed = false
  #  if curr_email != params[:email]
  #    current_user.update_attribute(:email, params[:email])
  #    changed = true
  #    email_changed = true
  #  end
  #  if curr_real_name != params[:real_name]
  #    current_user.update_attribute(:real_name, params[:real_name])
  #    changed = true
  #  end
  #  if curr_institution != params[:institution]
  #    current_user.update_attribute(:institution, params[:institution])
  #    changed = true
  #  end
  #
  #  if changed
  #    begin
  #      UserMailer.user_account_changed(current_user, curr_real_name, curr_email, curr_institution).deliver
  #    rescue Exception => msg
  #      logger.error("**** ERROR: Can't send email: " + msg)
  #    end
  #  end
  #
  #  redirect_to :controller => 'collections', :action => 'contributor'
  #end
  
  #def create
  #  cookies.delete :auth_token
  #  # protects against session fixation attacks, wreaks havoc with
  #  # request forgery protection.
  #  # uncomment at your own risk
  #  # reset_session
  #  @user = User.new(params[:user])
  #  @user.register! if @user.valid?
  #  if @user.errors.empty?
  #    #self.current_user = @user
  #    #redirect_back_or_default('/')
  #    #redirect_to :controller => 'collections', :action => 'editor'
  #    redirect_to :action => 'added_user_confirmation'
  #    #flash[:notice] = "Thanks for signing up!"
  #  else
  #    render :action => 'new'
  #  end
  #end

	def create
		@user = User.new(params[:user])
		new_pass = generate_password()
		@user.password = new_pass
		@user.password_confirmation = new_pass

		if @user.save
			flash[:notice] = 'User was successfully created.'
			UserMailer.signup_notification(@user, new_pass).deliver
				redirect_to '/added_user_confirmation'
		else
			render :action => "new"
		end
	end

  def activate
    self.current_user = params[:activation_code].blank? ? false : User.find_by_activation_code(params[:activation_code])
    if logged_in? && !current_user.active?
      current_user.activate!
      flash[:notice] = "Signup complete!"
    end
    redirect_back_or_default('/')
  end

  def suspend
    @user.suspend! 
    redirect_to users_path
  end

  def unsuspend
    @user.unsuspend! 
    redirect_to users_path
  end

  def destroy
    @user.delete!
    redirect_to users_path
  end

  def purge
    @user.destroy
    redirect_to users_path
  end

protected
  def find_user
    @user = User.find(params[:id])
  end

end
