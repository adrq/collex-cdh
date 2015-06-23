class UploadedFile < ActiveRecord::Base
  has_one :latest_file
  attr_accessible :original_name, :received_name

  def self.make_received_filename(base_path, orig_path, contributor_rec, project_name)
    folder = "#{sanitize_filename(contributor_rec.real_name)}_#{contributor_rec.id}/#{sanitize_filename(project_name)}"
    # create the file path
    path = File.join(folder, sanitize_filename(orig_path))
    logger.info(">>>> make_received_filename path=#{path}")
    derived_path = path
    count = 1 # this is the number added to the path. We suppress the number if it is one, but if there is a file match, then it is incremented and added to the path.
    while File.exists?(base_path+'/'+derived_path)
      count += 1
      derived_path = increment_pathname(path, count)
    end
    return derived_path
  end

  private
    # To generate a new path, we look for the last dot so we can insert our number just before that. If there isn't a dot then we append to the
    # end. If the dot is in the folder name, then we append to the end, also. We insert "_2", "_3", etc. to the file name, so it will look like this: "path/filename_2.zip"
  def self.increment_pathname(path, count)
    last_dot = path.rindex('.')
    last_slash = path.rindex('/')
    if last_dot == nil || last_dot < last_slash
      last_dot = path.length
    end
    new_path = path + ""
    new_path = new_path.insert(last_dot, '_'+count.to_s)
    return new_path
  end
  
  def self.sanitize_filename(file_name)
    # get only the filename, not the whole path (from IE)
    just_filename = file_name #.gsub(/^.*(\\|\/)/, '')
    # NOTE: File.basename doesn't work right with Windows paths on Unix
    # INCORRECT: just_filename = File.basename(value.gsub('\\\\', '/')) 

    # to lower case
    just_filename = just_filename.downcase
    
    # Finally, replace all non alphanumeric, underscore or periods with underscore
    return just_filename.gsub(/[^\w\.\-]/,'_')
  end
end
