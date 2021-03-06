require 'spec_helper'

# This spec was generated by rspec-rails when you ran the scaffold generator.
# It demonstrates how one might use RSpec to specify the controller code that
# was generated by the Rails when you ran the scaffold generator.

describe GenresController do

  def mock_genre(stubs={})
    @mock_genre ||= mock_model(Genre, stubs).as_null_object
  end

  describe "GET index" do
    it "assigns all genres as @genres" do
      Genre.stub(:all) { [mock_genre] }
      get :index
      assigns(:genres).should eq([mock_genre])
    end
  end

  describe "GET show" do
    it "assigns the requested genre as @genre" do
      Genre.stub(:find).with("37") { mock_genre }
      get :show, :id => "37"
      assigns(:genre).should be(mock_genre)
    end
  end

  describe "GET new" do
    it "assigns a new genre as @genre" do
      Genre.stub(:new) { mock_genre }
      get :new
      assigns(:genre).should be(mock_genre)
    end
  end

  describe "GET edit" do
    it "assigns the requested genre as @genre" do
      Genre.stub(:find).with("37") { mock_genre }
      get :edit, :id => "37"
      assigns(:genre).should be(mock_genre)
    end
  end

  describe "POST create" do
    describe "with valid params" do
      it "assigns a newly created genre as @genre" do
        Genre.stub(:new).with({'these' => 'params'}) { mock_genre(:save => true) }
        post :create, :genre => {'these' => 'params'}
        assigns(:genre).should be(mock_genre)
      end

      it "redirects to the created genre" do
        Genre.stub(:new) { mock_genre(:save => true) }
        post :create, :genre => {}
        response.should redirect_to(genre_url(mock_genre))
      end
    end

    describe "with invalid params" do
      it "assigns a newly created but unsaved genre as @genre" do
        Genre.stub(:new).with({'these' => 'params'}) { mock_genre(:save => false) }
        post :create, :genre => {'these' => 'params'}
        assigns(:genre).should be(mock_genre)
      end

      it "re-renders the 'new' template" do
        Genre.stub(:new) { mock_genre(:save => false) }
        post :create, :genre => {}
        response.should render_template("new")
      end
    end
  end

  describe "PUT update" do
    describe "with valid params" do
      it "updates the requested genre" do
        Genre.stub(:find).with("37") { mock_genre }
        mock_genre.should_receive(:update_attributes).with({'these' => 'params'})
        put :update, :id => "37", :genre => {'these' => 'params'}
      end

      it "assigns the requested genre as @genre" do
        Genre.stub(:find) { mock_genre(:update_attributes => true) }
        put :update, :id => "1"
        assigns(:genre).should be(mock_genre)
      end

      it "redirects to the genre" do
        Genre.stub(:find) { mock_genre(:update_attributes => true) }
        put :update, :id => "1"
        response.should redirect_to(genre_url(mock_genre))
      end
    end

    describe "with invalid params" do
      it "assigns the genre as @genre" do
        Genre.stub(:find) { mock_genre(:update_attributes => false) }
        put :update, :id => "1"
        assigns(:genre).should be(mock_genre)
      end

      it "re-renders the 'edit' template" do
        Genre.stub(:find) { mock_genre(:update_attributes => false) }
        put :update, :id => "1"
        response.should render_template("edit")
      end
    end
  end

  describe "DELETE destroy" do
    it "destroys the requested genre" do
      Genre.stub(:find).with("37") { mock_genre }
      mock_genre.should_receive(:destroy)
      delete :destroy, :id => "37"
    end

    it "redirects to the genres list" do
      Genre.stub(:find) { mock_genre }
      delete :destroy, :id => "1"
      response.should redirect_to(genres_url)
    end
  end

end
