# encoding: UTF-8
# This file is auto-generated from the current state of the database. Instead
# of editing this file, please use the migrations feature of Active Record to
# incrementally modify your database, and then regenerate this schema definition.
#
# Note that this schema.rb definition is the authoritative source for your
# database schema. If you need to create the application database on another
# system, you should be using db:schema:load, not running all the migrations
# from scratch. The latter is a flawed and unsustainable approach (the more migrations
# you'll amass, the slower it'll run and the greater likelihood for issues).
#
# It's strongly recommended to check this file into your version control system.

ActiveRecord::Schema.define(:version => 20130104150828) do

  create_table "collections", :force => true do |t|
    t.integer  "contributor_id"
    t.integer  "last_editor_id"
    t.integer  "latest_file_id"
    t.integer  "current_status"
    t.text     "notes"
    t.datetime "created_at"
    t.datetime "updated_at"
    t.text     "admin_notes"
    t.string   "project_name"
    t.string   "project_url"
    t.string   "default_thumbnail"
    t.decimal  "classification",    :precision => 10, :scale => 0
  end

  create_table "editorial_board_members", :force => true do |t|
    t.string   "name"
    t.string   "email"
    t.decimal  "classification", :precision => 10, :scale => 0
    t.datetime "created_at"
    t.datetime "updated_at"
  end

  create_table "uploaded_files", :force => true do |t|
    t.string   "original_name"
    t.string   "received_name"
    t.datetime "created_at"
    t.datetime "updated_at"
  end

  create_table "users", :force => true do |t|
    t.string   "login"
    t.string   "email"
    t.string   "encrypted_password",        :limit => 128,                                :default => "",        :null => false
    t.string   "password_salt",                                                           :default => "",        :null => false
    t.datetime "created_at"
    t.datetime "updated_at"
    t.string   "remember_token"
    t.datetime "remember_token_expires_at"
    t.string   "confirmation_token"
    t.datetime "confirmed_at"
    t.string   "state",                                                                   :default => "passive"
    t.datetime "deleted_at"
    t.string   "real_name"
    t.string   "institution"
    t.integer  "role"
    t.decimal  "disabled",                                 :precision => 10, :scale => 0
    t.datetime "confirmation_sent_at"
    t.string   "reset_password_token"
    t.datetime "reset_password_sent_at"
    t.datetime "remember_created_at"
    t.integer  "sign_in_count",                                                           :default => 0
    t.datetime "current_sign_in_at"
    t.datetime "last_sign_in_at"
    t.string   "current_sign_in_ip"
    t.string   "last_sign_in_ip"
  end

  add_index "users", ["email"], :name => "index_users_on_email", :unique => true
  add_index "users", ["reset_password_token"], :name => "index_users_on_reset_password_token", :unique => true

end
