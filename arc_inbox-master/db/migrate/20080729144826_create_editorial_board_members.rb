class CreateEditorialBoardMembers < ActiveRecord::Migration
  def self.up
    create_table :editorial_board_members do |t|
      t.string :name
      t.string :email
      t.decimal :classification
      t.datetime :created_at
      t.datetime :updated_at

      t.timestamps
    end
  end

  def self.down
    drop_table :editorial_board_members
  end
end
