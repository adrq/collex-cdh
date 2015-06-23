require 'test_helper'

class UploadedFilesControllerTest < ActionController::TestCase
  def test_should_get_index
    login_as(:quentin)
    get :index
    assert_response :success
    assert_not_nil assigns(:uploaded_files)
  end

  def test_should_get_new
    login_as(:quentin)
    get :new
    assert_response :success
  end

  def test_should_create_uploaded_file
    login_as(:quentin)
    assert_difference('UploadedFile.count') do
      post :create, :uploaded_file => { }
    end

    assert_redirected_to uploaded_file_path(assigns(:uploaded_file))
  end

  def test_should_show_uploaded_file
    login_as(:quentin)
    get :show, :id => uploaded_files(:one).id
    assert_response :success
  end

  def test_should_get_edit
    login_as(:quentin)
    get :edit, :id => uploaded_files(:one).id
    assert_response :success
  end

  def test_should_update_uploaded_file
    login_as(:quentin)
    put :update, :id => uploaded_files(:one).id, :uploaded_file => { }
    assert_redirected_to uploaded_file_path(assigns(:uploaded_file))
  end

  def test_should_destroy_uploaded_file
    login_as(:quentin)
    assert_difference('UploadedFile.count', -1) do
      delete :destroy, :id => uploaded_files(:one).id
    end

    assert_redirected_to uploaded_files_path
  end
end
