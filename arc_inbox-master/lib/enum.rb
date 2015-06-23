class Enum
  public
  def initialize(str_arr)
    @values_astr = str_arr
  end
  
  def values_astr
    return @values_astr
  end

  def to_string(type_int)
    if type_int == nil
      return "error"
    end
    len = @values_astr.length
    if type_int >= 0 && type_int < len
      return @values_astr[type_int]
    else
      return "error"
    end
  end 

  def to_int(type_str)
    (0..@values_astr.length-1).each { |i|
      if type_str == @values_astr[i]
        return i;
      end
    }
    return "-1"
  end 

  def create_combo_on_form(f, type)
    astr = Array.new
    (0..@values_astr.length-1).each { |i|
      astr.insert(-1, [ @values_astr[i], i])
    }
    f.select(type, astr)
  end
  
  def create_combo(id_str)
    # This is the one to use if there is no available form
    str = "<select name=\"#{id_str}\" onchange=\"onComboChange()\" onblur=\"onComboCancel()\" >"
    (0..@values_astr.length-1).each { |i|
      str += "<option value=\"#{i}\">#{@values_astr[i]}</option>"
    }
    str += "</select>"
    return str
  end
end
