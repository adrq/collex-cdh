class ApplicationController < ActionController::Base
	before_filter :authenticate_user!
  protect_from_forgery

  #include AuthenticatedSystem
  #include ExceptionNotifiable

  helper :all # include all helpers, all the time

  def has_permission?
    if current_user == nil
      redirect_to ('/')
    end
  end

  def must_be_editor
    if current_user == nil || !current_user.is_editor
      redirect_to ('/')
      return false
    end
    return true
  end

#private
#  def local_request?
#    false
#  end
end
