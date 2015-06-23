require 'test_helper'

class HomeControllerTest < ActionController::TestCase
  include ApplicationHelper
  # def test_editor_link
  #   login_as(:quentin) 
  #   assert_equal(goto_editor_link, "")
  #   login_as(:aaron) 
  #   assert_equal(goto_editor_link, "editor")
  # end
  # 
  # def test_contributor_link
  #   login_as(:quentin) 
  #   assert_equal(goto_editor_link, "")
  #   login_as(:aaron) 
  #   assert_equal(goto_editor_link, "contributor_path")
  # end
  
  def test_main_editor_link_clear
    assert_equal(main_editor_link_clear, "Project Manager Eddie East <edward@performantsoftware.com>")
  end
  
  def test_main_editor_link
    assert_equal(main_editor_link, "<noscript>Project Manager<br/><small>&#101;&#100;&#119;&#97;&#114;&#100;(at)&#112;&#101;&#114;&#102;&#111;&#114;&#109;&#97;&#110;&#116;&#115;&#111;&#102;&#116;&#119;&#97;&#114;&#101;.&#99;&#111;&#109;</small></noscript>\n<script language='javascript'>\n  <!--\n    string = 'rqjneq@cresbeznagfbsgjner.pbz'.replace(/[a-zA-Z]/g, function(c){ return String.fromCharCode((c <= 'Z' ? 90 : 122) >= (c = c.charCodeAt(0) + 13) ? c : c - 26);});\n    document.write('<a href='+'ma'+'il'+'to:Eddie%20East&lt;' + string +'&gt;>Project Manager</a>'); \n  //-->\n</script>\n")
  end
  
  def test_webmaster_link
    assert_equal(webmaster_link, "<noscript>Webmaster<br/><small>&#110;&#105;&#99;&#107;(at)&#112;&#101;&#114;&#102;&#111;&#114;&#109;&#97;&#110;&#116;&#115;&#111;&#102;&#116;&#119;&#97;&#114;&#101;.&#99;&#111;&#109;</small></noscript>\n<script language='javascript'>\n  <!--\n    string = 'avpx@cresbeznagfbsgjner.pbz'.replace(/[a-zA-Z]/g, function(c){ return String.fromCharCode((c <= 'Z' ? 90 : 122) >= (c = c.charCodeAt(0) + 13) ? c : c - 26);});\n    document.write('<a href='+'ma'+'il'+'to:NINES%20Webmaster&lt;' + string +'&gt;>Webmaster</a>'); \n  //-->\n</script>\n")
  end
  
end
