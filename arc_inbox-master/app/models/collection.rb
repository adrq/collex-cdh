require 'enum'
class Collection < ActiveRecord::Base
	attr_accessible :contributor_id, :last_editor_id, :latest_file_id, :current_status, :classification, :notes, :admin_notes, :project_name, :project_url, :default_thumbnail
  belongs_to :contributor, :class_name => "User"
  belongs_to :last_editor, :class_name => "User"
  belongs_to :latest_file, :class_name => "UploadedFile"
  
  @@statuses = nil
  def self.statuses
    if @@statuses == nil
      @@statuses = Enum.new([ "New", "In Progress", "Is Staged", "In Peer Review", "In Production", "Denied", "Deleted" ])
    end
    return @@statuses
  end

  def self.to_status_string(type_int)
    statuses.to_string(type_int)
  end 

  def self.to_status_int(type_str)
    statuses.to_int(type_str)
  end 

  def self.create_status_combo(id_str)
    str = statuses.create_combo(id_str)
    return str
  end
  
  @@classifications = nil
  def self.classifications
    if @@classifications == nil
      @@classifications = Enum.new([ "[Not Classified]", "American", "Romantic", "Victorian", "MESA", "Literature", "Technical" ])
    end
    return @@classifications
  end

  def self.to_classification_string(type_int)
    classifications.to_string(type_int)
  end 

  def self.to_classification_int(type_str)
    classifications.to_int(type_str)
  end 

  def self.create_classification_combo(id_str)
    str = classifications.create_combo(id_str)
    str = str.gsub('onComboChange', 'onClassificationComboChange')
    str = str.gsub('onComboCancel', 'onClassificationComboCancel')
    return str
  end
  
  def self.create_classification_combo_on_form(f, curr_selection)
    ctrl = classifications.create_combo_on_form(f, :classification)
    return ctrl.gsub(">#{curr_selection}</option>", " selected=\"selected\">#{curr_selection}</option>")
  end
  
  def self.get_all
    Collection.where("current_status <> ?", Collection.to_status_int("Deleted")).all
  end
  
  def self.get_all_for_contributor(contributor_int)
    Collection.where("contributor_id = ? AND current_status <> ?", contributor_int, Collection.to_status_int("Deleted")).all
  end
  
  def get_orig_filename
    return latest_file.original_name unless latest_file == nil
    return nil
  end
  
  def get_new_filename
    return latest_file.received_name unless latest_file == nil
    return nil
  end
end
