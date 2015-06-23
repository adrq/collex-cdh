class CreateCollections < ActiveRecord::Migration
  def self.up
    create_table :collections do |t|
      t.integer :contributor_id
      t.integer :last_editor_id
      t.integer :latest_file_id
      t.integer :current_status
      t.text :notes
      t.datetime :created_at
      t.datetime :updated_at

      t.timestamps
    end
  end

  def self.down
    drop_table :collections
  end
end
