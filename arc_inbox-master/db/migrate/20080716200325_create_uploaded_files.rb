class CreateUploadedFiles < ActiveRecord::Migration
  def self.up
    create_table :uploaded_files do |t|
      t.string :original_name
      t.string :received_name
      t.datetime :created_at
      t.datetime :updated_at

      t.timestamps
    end
  end

  def self.down
    drop_table :uploaded_files
  end
end
