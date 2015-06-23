class UserMailer < ActionMailer::Base
	include ApplicationHelper

	def generic_send(user, to_type, subject, options = {})
		@user = user
		@name = user.real_name if user.present?
		@main_editor = main_editor_link_clear
		@url = ActionMailer::Base.default_url_options[:host]
		to = case to_type
			     when :editors
				create_editor_list
			     when :editors_and_user
				create_to_list_with_editors(user)
				when :user
				user.email
				when :master
				MASTER_EDITOR_EMAIL
				when :editors_and_board
				create_to_list_with_editors_and_board(user.email, options[:classification])
			     else
				raise "Unexpected to: #{to_type}"
		     end

		mail(to: to, from: MASTER_EDITOR_EMAIL, subject: "[#{PROGRAM_NAME}] #{subject}")
	end

	def new_submission(user, collection)
		@project_info = project_info_with_notes(collection)
		generic_send(user, :editors_and_user, "New Submission Received")
	end

	def resubmit(user, collection)
		@project_info = project_info_with_notes(collection)
		generic_send(user, :editors_and_user, "Project Resubmitted")
	end

	def denied(user, collection, comment)
		@contributor = user.real_name
		@email = user.email
		@project_info = project_info(collection)
		@comment = comment
		generic_send(user, :master, "Submission Denied")
	end

	def in_progress(user, collection)
		@project_info = project_info_with_notes(collection)
		generic_send(user, :user, "Submission review in progress")
	end

	def in_peer_review(user, collection)
		@project_info = project_info_with_notes(collection)
		@classification = Collection.to_classification_string(collection.classification)
		generic_send(user, :editors_and_board, "Submission now in peer review", { classification: collection.classification })
	end

	def is_staged(user, collection)
		@project_info = project_info_with_notes(collection)
		generic_send(user, :editors_and_user, "Submission is staged")
	end

	def in_production(user, collection)
		@project_info = project_info_with_notes(collection)
		@classification = Collection.to_classification_string(collection.classification)
		generic_send(user, :user, "Submission is now in production")
	end

	def editor_deletes(user, collection)
		@project_info = project_info_with_notes(collection)
		generic_send(user, :user, "Submission deleted by editor")
	end

	def editor_changed_note(user, collection)
		@project_info = project_info_with_notes(collection)
		generic_send(user, :user, "Editor changed note")
	end

	def contributor_deletes(collection)
		@project_info = project_info_with_notes(collection)
		generic_send(nil, :editors, "Submission deleted by contributor")
	end

	def contributor_changed_note(collection)
		@project_info = project_info_with_notes(collection)
		generic_send(nil, :editors, "Contributor changed note")
	end

	#def user_account_changed(user, old_real_name, old_email, old_institution)
	#	if user.email == old_email
	#		recipients user.email
	#	else
	#		recipients [old_email, user.email]
	#	end
	#	from MASTER_EDITOR_EMAIL
	#	subject "[#{PROGRAM_NAME}] Account information on record has changed"
	#	body :name => user.real_name, :old_email => old_email, :new_email => user.email, :main_editor => main_editor_link_clear, :old_real_name => old_real_name,
	#		:new_real_name => user.real_name, :old_institution => old_institution, :new_institution => user.institution
	#end
	#
	#def new_password(user, new_password)
	#	recipients user.email
	#	from MASTER_EDITOR_EMAIL
	#	subject "[#{PROGRAM_NAME}] Account Password Changed"
	#	body :name => user.real_name, :main_editor => main_editor_link_clear, :password => new_password
	#end
	#
	def account_deleted(user)
		generic_send(user, :editors_and_user, "Account Disabled")
	end

	def signup_notification(user, password)
		@password = password

		generic_send(user, :user, "Account Created")
	end

	private
	def create_to_list_with_editors_and_board(user_email, classification_int)
		to_list = create_to_list_with_editors(user_email)
		board_list = EditorialBoardMember.where("classification = ?", classification_int).all
		board_list.each { |member|
			to_list.insert(-1, member.email)
		}
		return to_list
	end

	def create_to_list_with_editors(user_email)
		to_list = create_editor_list
		to_list.insert(0, user_email) unless user_email == ""
		return to_list
	end

	def create_editor_list
		editor_list = User.where("role = ?", User.to_role_int("Editor")).all
		to_list = Array.new
		editor_list.each { |user|
			to_list.insert(-1, user.email)
		}
		return to_list
	end

	def project_info(collection)
		"Project name: #{collection.project_name}\n" +
			"Project URL: #{collection.project_url}\n" +
			"Default Thumbnail: #{collection.default_thumbnail}\n" +
			"Filename: #{collection.get_orig_filename()}\n" +
			"Uploaded Path: #{collection.get_new_filename()}"
	end

	def project_info_with_notes(collection)
		str = project_info(collection)
		str += "\n\nNotes:\n\n#{collection.notes}"
		return str
	end


	# def activation(user)
	#   setup_email(user)
	#   @subject    += 'Your account has been activated!'
	#   @body[:url]  = "http://YOURSITE/"
	# end

	#protected
	#def setup_email(user)
	#	@recipients  = "#{user.email}"
	#	@from        = "ADMINEMAIL"
	#	@subject     = "[YOURSITE] "
	#	@sent_on     = Time.now
	#	@body[:user] = user
	#end
end
