require 'test_helper'

class EditorialBoardMembersControllerTest < ActionController::TestCase
  def test_should_get_index
    login_as(:quentin)
    get :index
    assert_response :success
    assert_not_nil assigns(:editorial_board_members)
  end

  def test_should_get_new
    login_as(:quentin)
    get :new
    assert_response :success
  end

  def test_should_create_editorial_board_member
    login_as(:quentin)
    assert_difference('EditorialBoardMember.count') do
      post :create, :editorial_board_member => { }
    end

    assert_redirected_to editorial_board_member_path(assigns(:editorial_board_member))
  end

  def test_should_show_editorial_board_member
    login_as(:quentin)
    get :show, :id => editorial_board_members(:one).id
    assert_response :success
  end

  def test_should_get_edit
    login_as(:quentin)
    get :edit, :id => editorial_board_members(:one).id
    assert_response :success
  end

  def test_should_update_editorial_board_member
    login_as(:quentin)
    put :update, :id => editorial_board_members(:one).id, :editorial_board_member => { }
    assert_redirected_to editorial_board_member_path(assigns(:editorial_board_member))
  end

  def test_should_destroy_editorial_board_member
    login_as(:quentin)
    assert_difference('EditorialBoardMember.count', -1) do
      delete :destroy, :id => editorial_board_members(:one).id
    end

    assert_redirected_to editorial_board_members_path
  end
end
