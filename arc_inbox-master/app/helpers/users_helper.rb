module UsersHelper
  def generate_password
    # This generates a random string of six lower case characters.
    pass = ""
    6.times {|i|
      ch = 10 + rand(26)
      pass += ch.to_s(36)
      }
    return pass
  end
  
end