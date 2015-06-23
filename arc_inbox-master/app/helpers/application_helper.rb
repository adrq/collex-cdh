#encoding: utf-8
# Methods added to this helper will be available to all templates in the application.
module ApplicationHelper
  def title(text)
    content_for(:title) { text }
  end
  def extra_button(text)
    content_for(:extra_button) { text }
  end
  def instructions(text)
    content_for(:instructions) { raw(text) }
  end
  def main_header(text)
    content_for(:main_header) { text }
  end
  
  def login_msg(text)
    content_for(:login_msg) { raw(text) }
  end
  def link_myaccount(text)
    content_for(:link_myaccount) { text }
  end
  
  def goto_editor_link
    if current_user.is_editor
   		link_to "Everybody's contributions", editor_path
   	end
  end
  
  def goto_contributor_link
	  if current_user.is_editor
		  link_to "My Contributions", contributor_path
	  end
  end
  
  def main_editor_link_clear
    return "ARC Project Manager #{MASTER_EDITOR_NAME} <#{MASTER_EDITOR_EMAIL}>"
  end
  
  def main_editor_link
    #logger.info("main_editor_link: #{MASTER_EDITOR_NAME} #{MASTER_EDITOR_EMAIL}")
    "#{js_antispam_email_link(MASTER_EDITOR_NAME, MASTER_EDITOR_EMAIL, 'ARC Project Manager')}"
  end
  
  def webmaster_link
    raw("#{js_antispam_email_link('Arc Inbox Webmaster', WEBMASTER_EMAIL, 'Webmaster')}")
  end
  
  def link_divider
    raw("&nbsp;•&nbsp;")
  end

  def errors_for(object, message=nil)
	  html = ""
	  unless object.blank? || object.errors.blank?
		  html << "<div class='formErrors #{object.class.name.humanize.downcase}Errors'>\n"
		  if message.blank?
			  if object.new_record?
				  html << "\t\t<h5>There was a problem creating the #{object.class.name.humanize.downcase}</h5>\n"
			  else
				  html << "\t\t<h5>There was a problem updating the #{object.class.name.humanize.downcase}</h5>\n"
			  end
		  else
			  html << "<h5>#{message}</h5>"
		  end
		  html << "\t\t<ul>\n"
		  object.errors.full_messages.each do |error|
			  html << "\t\t\t<li>#{error}</li>\n"
		  end
		  html << "\t\t</ul>\n"
		  html << "\t</div>\n"
	  end
	  raw(html)
  end

  private
  #
  # The following was cribbed from http://unixmonkey.net/?p=20
  #
  # Rot13 encodes a string
  def rot13(string)
    string.tr "A-Za-z", "N-ZA-Mn-za-m"
  end

  # HTML encodes ASCII chars a-z, useful for obfuscating
  # an email address from spiders and spammers
  def html_obfuscate(string)
    output_array = []
    lower = %w(a b c d e f g h i j k l m n o p q r s t u v w x y z)
    upper = %w(A B C D E F G H I J K L M N O P Q R S T U V W X Y Z)
    char_array = string.split('')
    char_array.each do |char|
	    output = nil
      output = lower.index(char) + 97 if lower.include?(char)
      output = upper.index(char) + 65 if upper.include?(char)
      if output
        output_array << "&##{output};"
      else 
        output_array << char
      end
    end
    return output_array.join
  end

  # Takes in an email address and (optionally) anchor text,
  # its purpose is to obfuscate email addresses so spiders and
  # spammers can't harvest them.
  def js_antispam_email_link(name, email, linktext=email)
    user, domain = email.split('@')
    user   = html_obfuscate(user)
    domain = html_obfuscate(domain)
    name = name.gsub(" ", "%20")
    # if linktext wasn't specified, throw encoded email address builder into js document.write statement
    linktext = "'+'#{user}'+'@'+'#{domain}'+'" if linktext == email 
    rot13_encoded_email = rot13(email) # obfuscate email address as rot13
    out =  "<noscript>#{linktext}<br/><small>#{user}(at)#{domain}</small></noscript>\n" # js disabled browsers see this
    out += "<script language='javascript'>\n"
    out += "  <!--\n"
    out += "    string = '#{rot13_encoded_email}'.replace(/[a-zA-Z]/g, function(c){ return String.fromCharCode((c <= 'Z' ? 90 : 122) >= (c = c.charCodeAt(0) + 13) ? c : c - 26);});\n"
    out += "    document.write('<a href='+'ma'+'il'+'to:#{name}&lt;' + string +'&gt;>#{linktext}</a>'); \n"
    out += "  //-->\n"
    out += "</script>\n"
    return out
  end
end
