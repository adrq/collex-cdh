MASTER_EDITOR_NAME = SITE_SPECIFIC['master_editor']['name']
MASTER_EDITOR_EMAIL = SITE_SPECIFIC['master_editor']['email']
WEBMASTER_EMAIL = SITE_SPECIFIC['webmaster']['email']

ActionMailer::Base.delivery_method = :smtp if Rails.env == 'production'
ActionMailer::Base.smtp_settings = { 
  :address => "localhost", 
  :port => 25, 
  :domain => "nines.org", 
}
# config/initializers/setup_mail.rb

ActionMailer::Base.smtp_settings = {
	:delivery_method => :smtp,
	:address => SITE_SPECIFIC['smtp_settings']['address'],
	:port => SITE_SPECIFIC['smtp_settings']['port'],
	:domain => SITE_SPECIFIC['smtp_settings']['domain'],
	:user_name => SITE_SPECIFIC['smtp_settings']['user_name'],
	:password => SITE_SPECIFIC['smtp_settings']['password'],
	:authentication => SITE_SPECIFIC['smtp_settings']['authentication'],
	:enable_starttls_auto => SITE_SPECIFIC['smtp_settings']['enable_starttls_auto']
}

ActionMailer::Base.default_url_options[:host] = SITE_SPECIFIC['smtp_settings']['return_path']
#Mail.register_interceptor(DevelopmentMailInterceptor) if Rails.env.development?
