namespace :users do
	desc "For bootstrapping, create first editor (file=path)"
	task :create_first_editor  => :environment do
		user = User.new({ email: 'editor@example.com', role: 0, real_name: 'First Editor', institution: 'None', password: 'password', password_confirmation: 'password' })
		user.state = 'active'
		user.save!
	end
end
