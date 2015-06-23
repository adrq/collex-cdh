class EditorialBoardMember < ActiveRecord::Base
	attr_accessible :name, :email, :classification
end
