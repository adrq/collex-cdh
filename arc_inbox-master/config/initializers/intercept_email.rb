# If the site.yml is set up to intercept mail, the MailInterceptor will be set up.
# Then it will intercept any mail and send it to the specified email.

class MailInterceptor
	def self.delivering_email(message)
		# We want all the emails to appear like they are coming from this address.
		message.from = SITE_SPECIFIC['smtp_settings']['from'] if message.from.blank?

		# Check to see if we want to intercept the email.
		return if SITE_SPECIFIC['mail_intercept']['deliver_email']

		# Intercept the email
		message.subject = "INTERCEPTED: #{message.to} #{message.subject}"
		message.to = SITE_SPECIFIC['mail_intercept']['email_list']
	end
end

ActionMailer::Base.register_interceptor(MailInterceptor)

