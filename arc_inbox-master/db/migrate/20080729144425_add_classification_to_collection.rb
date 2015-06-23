class AddClassificationToCollection < ActiveRecord::Migration
  def self.up
    add_column :collections, :classification, :decimal
  end

  def self.down
    remove_column :collections, :classification
  end
end
