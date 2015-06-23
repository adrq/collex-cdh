require 'test_helper'

class CollectionsControllerTest < ActionController::TestCase
  def test_should_show_editor
    login_as(:quentin)
    get :editor
    assert_response :success
  end
  
  def test_should_not_show_editor
    login_as(:aaron)
    get :editor
    assert_redirected_to :action => "index", :controller => "home"
  end

  def test_should_show_contributor
    login_as(:aaron)
    get :contributor
    assert_response :success
  end
  
  def test_should_show_contributor_while_editor
    login_as(:quentin)
    get :contributor
    assert_response :success
  end
  
  class FileName
    attr_accessor :original_filename, :read
  end
  
  def test_new_submission
    login_as(:quentin)
    f = FileName.new
    f.original_filename = "test.txt"
    f.read = "now is the time"
    get :new_submission, :file_name => f, :notes => "blah, blah", :project_name => "proj", 
      :project_url => "url", :default_thumbnail => "thumb"
    assert_redirected_to :action => "confirm_submission"
  end
  
  def test_resubmit_submission
    login_as(:quentin)
    f = FileName.new
    f.original_filename = "test.txt"
    f.read = "now is the time"
    get :resubmit_submission, :id => get_first_collection().id, :file_name => f, :notes => "blah, blah", :project_name => "proj", 
      :project_url => "url", :default_thumbnail => "thumb"
    assert_redirected_to :action => "confirm_submission"
  end
  
  def test_resubmit
    login_as(:quentin)
    get :resubmit, :id => get_first_collection().id
    assert_response :success
  end
  
  def test_denial_comment_submitted
    login_as(:quentin)
    get :denial_comment_submitted, :id => get_first_collection().id, :notes => "denial comment"
    assert_redirected_to :action => "editor"
  end
  
  def test_denial_comment
    login_as(:quentin)
    get :denial_comment, :id => get_first_collection().id
    assert_response :success
  end
  
  def test_textarea_changed1
    login_as(:quentin)
    id_str = "#{get_first_collection().id}-notes-editor"
    post :textarea_changed, :id => id_str, :textarea => "new text"
    assert_redirected_to :action => "editor"
  end
  
  def test_textarea_changed2
    login_as(:quentin)
    id_str = "#{get_first_collection().id}-admin-editor"
    post :textarea_changed, :id => id_str, :textarea => "new text"
    assert_redirected_to :action => "editor"
  end
  
  def test_textarea_changed3
    login_as(:quentin)
    id_str = "#{get_first_collection().id}-notes-contributor"
    post :textarea_changed, :id => id_str, :textarea => "new text"
    assert_redirected_to :action => "contributor"
  end
  
  def test_classification_changed
    login_as(:quentin)
    id_str = "#{get_first_collection().id}-classification"
    get :classification_changed, :id => id_str
    assert_redirected_to :action => "editor"
  end
  
  def test_status_changed
    login_as(:quentin)
    get :status_changed, :id => get_first_collection().id, :status => "1"
    assert_redirected_to :action => "editor"
  end
  
  def test_status_changed_to_denied
    login_as(:quentin)
    get :status_changed, :id => get_first_collection().id, :status => "5"
    assert_redirected_to :action => "denial_comment"
  end
  
  def test_cancel_submission
    login_as(:quentin)
    get :cancel_submission, :id => get_first_collection().id
    assert_redirected_to :action => "contributor"
  end
  
  def test_logout
    login_as(:quentin)
    get :logout
    assert_redirected_to :action => "index", :controller => "home"
  end
  
  def test_confirm_submission
    login_as(:quentin)
    get :confirm_submission, :id => get_first_collection().id
    assert_response :success
  end
  
  def test_details_editor
    login_as(:quentin)
    get :details, :id => get_first_collection().id, :role => 'editor'
    assert_response :success
  end

  def test_details_contributor
    login_as(:quentin)
    get :details, :id => get_first_collection().id, :role => 'contributor'
    assert_response :success
  end
  
  private
  def get_first_collection
    coll = Collection.find(:all)
    return coll[0]
  end
  
  ################################ original tests ##################################
  
  public
  def test_should_get_index
    login_as(:quentin)
    get :index
    assert_response :success
    assert_not_nil assigns(:collections)
  end

  def test_should_get_new
    login_as(:quentin)
    get :new
    assert_response :success
  end

  def test_should_create_collection
    login_as(:quentin)
    assert_difference('Collection.count') do
      post :create, :collection => { }
    end

    assert_redirected_to collection_path(assigns(:collection))
  end

  def test_should_show_collection
    login_as(:quentin)
    get :show, :id => collections(:one).id
    assert_response :success
  end

  def test_should_get_edit
    login_as(:quentin)
    get :edit, :id => collections(:one).id
    assert_response :success
  end

  def test_should_update_collection
    login_as(:quentin)
    put :update, :id => collections(:one).id, :collection => { }
    assert_redirected_to collection_path(assigns(:collection))
  end

  def test_should_destroy_collection
    login_as(:quentin)
    assert_difference('Collection.count', -1) do
      delete :destroy, :id => collections(:one).id
    end

    assert_redirected_to collections_path
  end
end
