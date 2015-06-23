class AddDisabledToUser < ActiveRecord::Migration
  def self.up
    add_column :users, :disabled, :decimal
  end

  def self.down
    remove_column :users, :disabled
  end
end
