class HomeController < ApplicationController
	def index
		if user_signed_in? && current_user.is_editor
			redirect_to '/editor'
		else
			redirect_to '/contributor'
		end
	end
  def test_exception_notifier
	  raise "This is only a test of the automatic notification system."
	  end
end
