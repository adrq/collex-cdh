#encoding: utf-8
module CollectionsHelper
  def format_notes_for_html(notes_str)
    str = h(notes_str)
    str = str.gsub(" ", '&nbsp;')
    str = str.gsub("\n", '<br />')
    str = str.gsub("\t", '&nbsp;&nbsp;&nbsp;&nbsp;')
    return raw(str)
  end
  
  def sort_by(collection_arr, field_str, direction_str)
    collection_arr.sort! {|a,b|
      case get_field(field_str)
      when "Project"
        lhs = a.project_name
        rhs = b.project_name
    	when "Creation Time"
        lhs = a.created_at
        rhs = b.created_at
    	when "Last Activity Time"
        lhs = a.updated_at
        rhs = b.updated_at
    	when "Contributor"
        lhs = a.contributor.format_name_for_screen
        rhs = b.contributor.format_name_for_screen
    	when "Status"
        lhs = Collection.to_status_string(a.current_status)
        rhs = Collection.to_status_string(b.current_status)
    	when "Public Notes"
        lhs = a.notes
        rhs = b.notes
    	when "Admin Notes"
        lhs = a.admin_notes
        rhs = b.admin_notes
      else
        lhs = a.project_name
        rhs = b.project_name
      end
       
      if get_direction(direction_str) == 'down'
        lhs <=> rhs
      else
        rhs <=> lhs
      end
    }
    
  end

  def create_header(fieldname, params, is_editor)
    page = is_editor ? 'editor' : 'contributor'
    if get_field(params[:field]) == fieldname
      direction = (get_direction(params[:direction]) == 'down') ? 'up' : 'down'
      triangle = direction == 'down' ?  '&nbsp;▲' : '&nbsp;▼'
    else
      direction = 'down'
      triangle = ''
    end
    raw "<a href='/#{page}?direction=#{direction}&amp;field=#{fieldname}' class='collections'>#{fieldname}</a>#{triangle}"
  end
  
  private
  def get_field(field_str)
    if field_str == nil
      return "Project"
    end
    return field_str
  end
  
  def get_direction(direction_str)
    if direction_str == nil
      return "down"
    end
    return params[:direction]
  end
  
end
