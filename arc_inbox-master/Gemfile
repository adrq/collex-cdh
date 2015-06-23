source 'https://rubygems.org'

gem 'rails', '3.2.12'

# Bundle edge Rails instead:
# gem 'rails', :git => 'git://github.com/rails/rails.git'

gem 'mysql2'

# Gems used only for assets and not required
# in production environments by default.
group :assets do
  gem 'sass-rails',   '~> 3.2.3'
  gem 'coffee-rails', '~> 3.2.1'

  # See https://github.com/sstephenson/execjs#readme for more supported runtimes
  gem 'therubyracer', '~> 0.10.0'

  gem 'uglifier', '>= 1.0.3'
end

gem 'jquery-rails'

# These were the plugins in vendor plugins
#gem "restful_authentication"
gem 'devise'
gem 'devise-encryptable'
gem "exception_notification"
gem 'pothoven-attachment_fu'
#gem "paperclip"
gem "acts_as_state_machine"

# Bundle gems for the local environment. Make sure to
# put test-only gems in this group so their generators
# and rake tasks are available in development mode:
group :development, :test do

	# To debug
	#gem 'debugger'

	# For better test results feedback in CLI
	#gem "turn", "~> 0.9.2"
	#
	## For better test results feedback in CLI
	#gem 'minitest'  #, '2.9.1'
	#
	## Additional testing tools
	#gem 'shoulda'  #, '2.11.3'
	#gem "shoulda-matchers" #, "~> 1.0.0"
	#gem 'cucumber-rails', :require => false
	#gem 'rspec-rails'
	#gem 'factory_girl_rails'  #, 1.5.0
	#gem 'simplecov'  #, '0.5.4'
	#
	#gem 'capybara'
	#gem 'launchy'
	#gem 'database_cleaner'

	gem "letter_opener" #NOTE-PER: If this is removed, be sure that you have some trap for emails so they don't accidentally go out.
	#	gem 'rack-mini-profiler'
end

# To use ActiveModel has_secure_password
# gem 'bcrypt-ruby', '~> 3.0.0'

# To use Jbuilder templates for JSON
# gem 'jbuilder'

# Use unicorn as the app server
# gem 'unicorn'

# Deploy with Capistrano
gem 'capistrano'
gem 'rvm-capistrano'

# To use debugger
# gem 'debugger'
