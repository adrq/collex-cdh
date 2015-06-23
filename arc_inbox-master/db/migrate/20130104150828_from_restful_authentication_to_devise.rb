class FromRestfulAuthenticationToDevise < ActiveRecord::Migration

	def self.up

		#encrypting passwords and authentication related fields
		rename_column :users, "crypted_password", "encrypted_password"
		change_column :users, "encrypted_password", :string, :limit => 128, :default => "", :null => false
		rename_column :users, "salt", "password_salt"
		change_column :users, "password_salt", :string, :default => "", :null => false

		#confirmation related fields
		rename_column :users, "activation_code", "confirmation_token"
		rename_column :users, "activated_at", "confirmed_at"
		change_column :users, "confirmation_token", :string
		add_column :users, "confirmation_sent_at", :datetime

		#reset password related fields
		#rename_column :users, "password_reset_code", "reset_password_token"
		add_column :users, "reset_password_token", :string
		add_column :users, :reset_password_sent_at, :datetime

		#rememberme related fields
		add_column :users, "remember_created_at", :datetime #additional field required for devise.

		## Trackable
		add_column :users, :sign_in_count, :integer, :default => 0
		add_column :users, :current_sign_in_at, :datetime
		add_column :users, :last_sign_in_at, :datetime
		add_column :users, :current_sign_in_ip, :string
		add_column :users, :last_sign_in_ip, :string

		add_index :users, :email,                :unique => true
		add_index :users, :reset_password_token, :unique => true
	end

	def self.down

		#rememberme related fields
		remove_column :users, "remember_created_at"

		#reset password related fields
		#rename_column :users, "reset_password_token", "password_reset_code"
		remove_column :users, "reset_password_token"
		remove_column :users, :reset_password_sent_at

		#confirmation related fields
		rename_column :users, "confirmation_token", "activation_code"
		rename_column :users, "confirmed_at", "activated_at"
		change_column :users, "activation_code", :string
		remove_column :users, "confirmation_sent_at"

		#encrypting passwords and authentication related fields
		rename_column :users, "encrypted_password", "crypted_password"
		change_column :users, "crypted_password", :string, :limit => 40
		rename_column :users, "password_salt", "salt"
		change_column :users, "salt", :string, :limit => 40

		## Trackable
		remove_column :users, :sign_in_count
		remove_column :users, :current_sign_in_at
		remove_column :users, :last_sign_in_at
		remove_column :users, :current_sign_in_ip
		remove_column :users, :last_sign_in_ip

	end
end