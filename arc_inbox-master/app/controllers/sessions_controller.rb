# This controller handles the login/logout function of the site.  
class SessionsController < ApplicationController
  #layout "main"
  #include ApplicationHelper
  ## render new.rhtml
  #def new
  #end
  #
  #def create
  #  self.current_user = User.authenticate(params[:email], params[:password])
  #  if self.current_user != nil && self.current_user.disabled == 1
  #    current_user = nil
  #    self.current_user = nil
  #    flash[:notice] = "Your account has been disabled. Please contact the #{main_editor_link} for more information."
  #    redirect_back_or_default('/')
  #    return
  #  end
  #
  #  if logged_in?
  #    if params[:remember_me] == "1"
  #      current_user.remember_me unless current_user.remember_token?
  #      cookies[:auth_token] = { :value => self.current_user.remember_token , :expires => self.current_user.remember_token_expires_at }
  #    end
  #    if self.current_user.is_editor
  #      redirect_to editor_path
  #    else
  #      redirect_to contributor_path
  #    end
  #    #redirect_back_or_default('/')
  #    #flash[:notice] = "Logged in successfully"
  #  else
  #    flash[:notice] = "The account information entered is invalid. Please try again."
  #    redirect_back_or_default('/')
  #  end
  #end
  #
  #def destroy
  #  self.current_user.forget_me if logged_in?
  #  cookies.delete :auth_token
  #  reset_session
  #  flash[:notice] = "You have been logged out."
  #  redirect_back_or_default('/')
  #end
end
