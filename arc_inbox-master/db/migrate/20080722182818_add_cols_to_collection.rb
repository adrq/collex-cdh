class AddColsToCollection < ActiveRecord::Migration
  def self.up
    add_column :collections, :admin_notes, :text
    add_column :collections, :project_name, :string
    add_column :collections, :project_url, :string
    add_column :collections, :default_thumbnail, :string
  end

  def self.down
    remove_column :collections, :admin_notes
    remove_column :collections, :project_name
    remove_column :collections, :project_url
    remove_column :collections, :default_thumbnail
  end
end
