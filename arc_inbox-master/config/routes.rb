ArcInbox::Application.routes.draw do
  devise_for :users

	resources :editorial_board_members
	resources :uploaded_files
	resources :collections do
		member do
			get 'details'
			get 'resubmit'
		end
		collection do
			post 'new_submission'
			post 'resubmit_submission'
			post 'resubmit'
			post 'denial_comment_submitted'
			post 'textarea_changed'
			post 'classification_changed'
			post 'status_changed'
			post 'cancel_submission'
		end
	end
#	resource :session

	post 'users/delete', controller: 'users', action: 'delete'
  put 'suspend', :controller => 'users', :action => 'update_account'
  put 'unsuspend', :controller => 'users', :action => 'update_account'
  delete 'purge', :controller => 'users', :action => 'update_account'
	get '/confirm_submission', :controller => 'collections', :action => 'confirm_submission'
	get '/activate/:activation_code', :controller => 'users', :action => 'activate', :activation_code => nil
	get '/signup', :controller => 'users', :action => 'new'
	post '/signup', controller: 'users', action: 'create'
	#get '/login', :controller => 'sessions', :action => 'new'
	#get '/logout', :controller => 'sessions', :action => 'destroy'
	get '/contributor', :controller => 'collections', :action => 'contributor'
	get '/editor', :controller => 'collections', :action => 'editor'
	#get '/resubmit', :controller => 'collections', :action => 'resubmit'
	#get '/forgot_password', :controller => 'users', :action => 'forgot_password'
	get '/update_account', :controller => 'users', :action => 'update_account'
	get '/delete_account', :controller => 'users', :action => 'delete_account'
	get '/maintain_editorial_board', :controller => 'editorial_board_members', :action => 'index'
	get '/added_user_confirmation', :controller => 'users', :action => 'added_user_confirmation'

	root :to => "home#index"
	get "/test_exception_notifier" => "home#test_exception_notifier"

	# The priority is based upon order of creation:
	# first created -> highest priority.

	# Sample of regular route:
	#   match 'products/:id' => 'catalog#view'
	# Keep in mind you can assign values other than :controller and :action

	# Sample of named route:
	#   match 'products/:id/purchase' => 'catalog#purchase', :as => :purchase
	# This route can be invoked with purchase_url(:id => product.id)

	# Sample resource route (maps HTTP verbs to controller actions automatically):
	#   resources :products

	# Sample resource route with options:
	#   resources :products do
	#     member do
	#       get 'short'
	#       post 'toggle'
	#     end
	#
	#     collection do
	#       get 'sold'
	#     end
	#   end

	# Sample resource route with sub-resources:
	#   resources :products do
	#     resources :comments, :sales
	#     resource :seller
	#   end

	# Sample resource route with more complex sub-resources
	#   resources :products do
	#     resources :comments
	#     resources :sales do
	#       get 'recent', :on => :collection
	#     end
	#   end

	# Sample resource route within a namespace:
	#   namespace :admin do
	#     # Directs /admin/products/* to Admin::ProductsController
	#     # (app/controllers/admin/products_controller.rb)
	#     resources :products
	#   end

	# You can have the root of your site routed with "root"
	# just remember to delete public/index.html.
	# root :to => "welcome#index"

	# See how all your routes lay out with "rake routes"

	# This is a legacy wild controller route that's not recommended for RESTful applications.
	# Note: This route will make all actions in every controller accessible via GET requests.
	# match ':controller(/:action(/:id(.:format)))'
end
