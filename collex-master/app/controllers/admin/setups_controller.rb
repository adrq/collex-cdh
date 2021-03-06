# ------------------------------------------------------------------------
#     Copyright 2011 Applied Research in Patacriticism and the University of
# Virginia
#
#     Licensed under the Apache License, Version 2.0 (the "License");
#     you may not use this file except in compliance with the License.
#     You may obtain a copy of the License at
#
#         http://www.apache.org/licenses/LICENSE-2.0
#
#     Unless required by applicable law or agreed to in writing, software
#     distributed under the License is distributed on an "AS IS" BASIS,
#     WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
#     See the License for the specific language governing permissions and
#     limitations under the License.
# ----------------------------------------------------------------------------
class Admin::SetupsController < Admin::BaseController
   # GET /setups
   # GET /setups.xml
   def index
      setups = Setup.all
      @setups = {}
      feds = []
      setups.each { |setup| @setups[setup.key] = setup.value }
      solr = Catalog.factory_create(session[:use_test_index] == "true")
	  begin
      solr.get_federations().each do |fed|
         # format: [fed, {data}]
         # see if a setup exists for this fed
         next if fed[0]== @setups['site_default_federation']
         found = false
         fed_key = "federation_#{fed[0]}"
         feds << fed_key
         @setups.each do |key,val|
            if key==fed_key
               found = true
               break
            end
         end
         if !found
            @setups[fed_key] = "true"
         end
	  end
	  rescue Catalog::Error => e
		  puts "*** Error in connecting to catalog: #{e.message}"
		  @solr_error = e.message
	  end
      @federations = feds.join(",")
   end

   # PUT /setups/1
   # PUT /setups/1.xml
   def update
      msg = ""
      act = params['commit']
      default_federation = nil
      fed_str = params['setups']['federations']
      params['setups'].delete('federations')
      feds = fed_str.split(",")

      checkbox_keys = ['enable_community_tab', 'enable_publications_tab', 'enable_classroom_tab', 'enable_news_tab']
      checkbox_keys.each { |key,value|
         rec = Setup.find_by_key(key)
         if rec
            rec.value = 'false'
         rec.save!
         end
      }

      params['setups'].each do |key,value|
         if !(key =~ /^federation_/).nil?
            feds.delete(key)
            value = "true" if value == "on"
         end
         rec = Setup.find_by_key(key)
         if rec
            default_federation = value if key == 'site_default_federation'
            if checkbox_keys.include? rec.key
               rec.value = 'true'
            else
               if value.strip == ''
                  rec.value = get_default_value(key)
               else
               rec.value = value
               end
            end
            rec.save!
         else
            Setup.create({ key: key, value: value })
         end
      end

      # mark any remaining federations as disabled
      feds.each do |fed|
         rec = Setup.find_by_key(fed)
         if rec
            rec.value = 'false'
            rec.save!
         else
            Setup.create({ key: fed, value: 'false' })
         end
      end

      Setup.reload()
      refill_session_cache()

      if act == 'Send Me A Test Email'
         user = current_user
         GenericMailer.generic(Setup.site_name(), Setup.return_email(), user[:fullname], user[:email], "Test Email From Collex",
         "If you are reading this, then the email settings are correct in Collex. ",
         url_for(:controller => '/home', :action => 'index', :only_path => false),
         "\n--------------\nAutomatic Email from Collex").deliver
         msg = "An email should have been sent to the email address on your account."
      elsif act == 'Simulate Error Email'
         raise("This is a test of the error notification system. An administrator pushed the Simulate Error button. If you are reading this, then the error notification system is working correctly.")
      elsif act == 'Test Catalog Connection'
         begin
            solr = Catalog.factory_create(session[:use_test_index] == "true")
            federations = solr.get_federations()
            found = false
            federations.each { |key,val| found = true if default_federation == key }
            if found == true
               msg = "The connection to the Catalog is good."
            else
               msg = "The connection to the Catalog is good, but the federation \"#{default_federation}\" was not found." +
               " The possible federations are: #{federations.map {|key,val| key }.to_s }"
            end
         rescue Catalog::Error => e
            msg = "There is a problem with the connection to the Catalog. Is the URL you've specified correct?"
         end
      else
         warnings = verify_setup_values()
         if warnings.length == 0
            msg = "Parameters successfully updated."
         else
            msg = "Warning:"
         end
      end
      flash[:notice] = msg
      flash[:warnings] = warnings
      redirect_to :back
   end

   private

   def get_default_value(key)
      value = ''
      case key
         when 'facet_display_name_discipline'
            value = "Discipline"
         when 'facet_display_name_format'
            value = "Format"
         when 'facet_display_name_genre'
            value = "Genre"
         when 'facet_display_name_access'
            value = "Access"
         when 'facet_display_name_origin'  #added for origin field -- akhil
            value = "Origin"  #added for origin field -- akhil
         when 'facet_display_name_language' #added for language field -- akhil
            value = "Language"  #added for language field -- akhil
         when 'facet_display_name_composition' #added for composition field -- akhil
            value = "Composition"  #added for composition field -- akhil
        when 'facet_display_name_type_digital_artifact' #added for type_digital_artifact field -- akhil
            value = "type_digital_artifact"  #added for type_digital_artifact field -- akhil
        when 'facet_display_name_type_original_artifact' #added for type_original_artifact field -- akhil
            value = "type_original_artifact"  #added for type_original_artifact field -- akhil
         when 'facet_display_name_provenance' #added for provenance field -- akhil
            value = "Provenance"  #added for provenance field -- akhil
      else 
         value = value
      end
      return value
   end

   def verify_setup_values()
      warnings = []

      order = {}
      rec = Setup.find_by_key('facet_order_format')
      order['facet_order_format'] = rec.value
      rec = Setup.find_by_key('facet_order_access')
      order['facet_order_access'] = rec.value
      rec = Setup.find_by_key('facet_order_discipline')
      order['facet_order_discipline'] = rec.value
      rec = Setup.find_by_key('facet_order_genre')
      order['facet_order_genre'] = rec.value
      rec = Setup.find_by_key('facet_order_origin')  #added for origin field -- akhil
      order['facet_order_origin'] = rec.value  #added for origin field -- akhil
      rec = Setup.find_by_key('facet_order_language') #added for language field -- akhil
      order['facet_order_language'] = rec.value #added for language field -- akhil
      rec = Setup.find_by_key('facet_order_composition') #added for composition field -- akhil
      order['facet_order_composition'] = rec.value #added for language field -- akhil
      rec = Setup.find_by_key('facet_order_type_original_artifact') #added for type_original_artifact field -- akhil
      order['facet_order_type_original_artifact'] = rec.value #added for type_original_artifact field -- akhil
      rec = Setup.find_by_key('facet_order_type_digital_artifact') #added for type_digital_artifact field -- akhil
      order['facet_order_type_digital_artifact'] = rec.value #added for type_digital_artifact field -- akhil
      rec = Setup.find_by_key('facet_order_provenance') #added for provenance field -- akhil
      order['facet_order_provenance'] = rec.value #added for provenance field -- akhil

      # Check for duplicate values
      if order.values.count != order.values.uniq.count
         warnings.push 'Facet Display Order contains duplicate numbers. Facets may not display correctly.'
         if order.values.count(order['facet_order_genre']) > 1
            warnings.push " Genre Facet Order: #{order['facet_order_genre']}"
         end
         if order.values.count(order['facet_order_discipline']) > 1
            warnings.push " Discipline Facet Order: #{order['facet_order_discipline']}"
         end
         if order.values.count(order['facet_order_access']) > 1
            warnings.push " Access Facet Order: #{order['facet_order_access']}"
         end
         if order.values.count(order['facet_order_format']) > 1
            warnings.push " Format Facet Order: #{order['facet_order_format']}"  
         end 
         if order.values.count(order['facet_order_origin']) > 1    #added for origin field -- akhil
            warnings.push " Origin Facet Order: #{order['facet_order_origin']}" #added for origin field -- akhil
         end
         if order.values.count(order['facet_order_language']) > 1    #added for language field -- akhil
            warnings.push " Language Facet Order: #{order['facet_order_language']}" #added for language field -- akhil
         end
         if order.values.count(order['facet_order_composition']) > 1    #added for composition field -- akhil
            warnings.push " Language Facet Order: #{order['facet_order_composition']}" #added for composition field -- akhil
         end
         if order.values.count(order['facet_order_type_digital_artifact']) > 1    #added for type_digital_artifact field -- akhil
            warnings.push " Language Facet Order: #{order['facet_order_type_digital_artifact']}" #added for type_digital_artifact field -- akhil
         end
         if order.values.count(order['facet_order_type_original_artifact']) > 1    #added for type_original_artifact field -- akhil
            warnings.push " Language Facet Order: #{order['facet_order_type_original_artifact']}" #added for type_original_artifact field -- akhil
         end
         if order.values.count(order['facet_order_provenance']) > 1    #added for provenance field -- akhil
            warnings.push " Provenance Facet Order: #{order['facet_order_provenance']}" #added for provenance field -- akhil
         end
      end

      # Check for non-numeric values
      type_original_artifact_order,type_digital_artifact_order,provenance_order,composition_order,origin_order,access_order, genre_order, discipline_order, format_order, language_order = nil, nil, nil, nil,nil,nil,nil,nil,nil,nil #added composition_order,provenance_order and origin_order --akhil
      begin
         access_order = Integer(order['facet_order_access']) if order['facet_order_access'].length > 0
      rescue
         warnings.push( "NonNumeric Display Order detected. \"Access Facet Order: #{order['facet_order_access']}\" Facets may not display correctly.")
      end
      begin
         genre_order = Integer(order['facet_order_genre']) if order['facet_order_genre'].length > 0
      rescue
         warnings.push( "NonNumeric Display Order detected. \"Genre Facet Order: #{order['facet_order_genre']}\" Facets may not display correctly.")
      end
      begin
         discipline_order = Integer(order['facet_order_discipline']) if order['facet_order_discipline'].length > 0
      rescue
         warnings.push( "NonNumeric Display Order detected. \"Discipline Facet Order: #{order['facet_order_discipline']}\" Facets may not display correctly.")
      end
      begin
         format_order = Integer(order['facet_order_format']) if order['facet_order_format'].length > 0
      rescue
         warnings.push( "Non Numeric Display Order detected. \"Format Facet Order: #{order['facet_order_format']}\" Facets may not display correctly.")
      end
      
      #added for origin field -- akhil
      begin
         origin_order = Integer(order['facet_order_origin']) if order['facet_order_origin'].length > 0
      rescue
         warnings.push( "Non Numeric Display Order detected. \"Origin Facet Order: #{order['facet_order_origin']}\" Facets may not display correctly.")
      end
      
      #added for language field -- akhil
      begin
         language_order = Integer(order['facet_order_language']) if order['facet_order_language'].length > 0
      rescue
         warnings.push( "Non Numeric Display Order detected. \"Language Facet Order: #{order['facet_order_language']}\" Facets may not display correctly.")
      end
      
      #added for composition field -- akhil
      begin
         composition_order = Integer(order['facet_order_composition']) if order['facet_order_composition'].length > 0
      rescue
         warnings.push( "Non Numeric Display Order detected. \"Composition Facet Order: #{order['facet_order_composition']}\" Facets may not display correctly.")
      end
      #added for type_digital_artifact field -- akhil
      begin
         type_digital_artifact_order = Integer(order['facet_order_type_digital_artifact']) if order['facet_order_type_digital_artifact'].length > 0
      rescue
         warnings.push( "Non Numeric Display Order detected. \"Composition Facet Order: #{order['facet_order_type_digital_artifact']}\" Facets may not display correctly.")
      end
      #added for type_original_artifact field -- akhil
      begin
         type_original_artifact_order = Integer(order['facet_order_type_original_artifact']) if order['facet_order_type_original_artifact'].length > 0
      rescue
         warnings.push( "Non Numeric Display Order detected. \"Composition Facet Order: #{order['facet_order_composition']}\" Facets may not display correctly.")
      end
      #added for provenance field -- akhil
      begin
         provenance_order = Integer(order['facet_order_provenance']) if order['facet_order_provenance'].length > 0
      rescue
         warnings.push( "Non Numeric Display Order detected. \"Provenance Facet Order: #{order['facet_order_provenance']}\" Facets may not display correctly.")
      end
      
      if !access_order.nil? and access_order > 10
         warnings.push("Large value detected. \"Access Facet Order: #{order['facet_order_access']}\"  Facets may not display correctly.")
      end
      if !genre_order.nil? and genre_order > 10
         warnings.push("Large value detected. \"Genre Facet Order: #{order['facet_order_genre']}\" Facets may not display correctly.")
      end
      if !discipline_order.nil? and discipline_order > 10
         warnings.push("Large value detected. \"Discipline Facet Order: #{order['facet_order_discipline']}\" Facets may not display correctly.")
      end
      if !format_order.nil? and format_order > 10
         warnings.push("Large value detected. \"Format Facet Order: #{order['facet_order_format']}\" Facets may not display correctly.")
      end
      
      #added for origin field -- akhil
      
      if !origin_order.nil? and origin_order > 10
         warnings.push("Large value detected. \"Origin Facet Order: #{order['facet_order_origin']}\" Facets may not display correctly.")
      end
      
      #added for language field -- akhil
      
      if !language_order.nil? and language_order > 10
         warnings.push("Large value detected. \"Language Facet Order: #{order['facet_order_language']}\" Facets may not display correctly.")
      end

      #added for composition field -- akhil
      
      if !composition_order.nil? and composition_order > 10
         warnings.push("Large value detected. \"Composition Facet Order: #{order['facet_order_composition']}\" Facets may not display correctly.")
      end
      
      #added for type_original_artifact field -- akhil
      
      if !type_original_artifact_order.nil? and type_original_artifact_order > 10
         warnings.push("Large value detected. \"type_original_artifact Facet Order: #{order['facet_order_type_original_artifact']}\" Facets may not display correctly.")
      end
      
      #added for type_digital_artifact field -- akhil
      
      if !type_digital_artifact_order.nil? and type_digital_artifact_order > 10
         warnings.push("Large value detected. \"type_digital_artifact Facet Order: #{order['facet_order_type_digital_artifact']}\" Facets may not display correctly.")
      end
      
      #added for provenance field -- akhil
      
      if !provenance_order.nil? and provenance_order > 10
         warnings.push("Large value detected. \"Provenance Facet Order: #{order['facet_order_provenance']}\" Facets may not display correctly.")
      end
      
      if !access_order.nil? and access_order < 0
         warnings.push("Negative value detected. \"Access Facet Order: #{order['facet_order_access']}\"  Facets may not display correctly.")
      end
      if !genre_order.nil? and genre_order < 0
         warnings.push("Negative value detected. \"Genre Facet Order: #{order['facet_order_genre']}\" Facets may not display correctly.")
      end
      if !discipline_order.nil? and discipline_order < 0
         warnings.push("Negative value detected. \"Discipline Facet Order: #{order['facet_order_discipline']}\" Facets may not display correctly.")
      end
      if !format_order.nil? and format_order < 0
         warnings.push("Negative value detected. \"Format Facet Order: #{order['facet_order_format']}\" Facets may not display correctly.")
      end
      
      #added for origin field -- akhil
      
      if !origin_order.nil? and origin_order < 0
         warnings.push("Negative value detected. \"Origin Facet Order: #{order['facet_order_origin']}\" Facets may not display correctly.")
      end
      
      #added for language field -- akhil
      
      if !language_order.nil? and language_order < 0
         warnings.push("Negative value detected. \"Language Facet Order: #{order['facet_order_language']}\" Facets may not display correctly.")
      end
      
      #added for composition field -- akhil
      
      if !composition_order.nil? and composition_order < 0
         warnings.push("Negative value detected. \"Composition Facet Order: #{order['facet_order_composition']}\" Facets may not display correctly.")
      end
      
      #added for type_digital_artifact field -- akhil
      
      if !type_digital_artifact_order.nil? and type_digital_artifact_order < 0
         warnings.push("Negative value detected. \"type_digital_artifact Facet Order: #{order['facet_order_type_digital_artifact']}\" Facets may not display correctly.")
      end
      
      #added for type_original_artifact field -- akhil
      
      if !type_original_artifact_order.nil? and type_original_artifact_order < 0
         warnings.push("Negative value detected. \"type_original_artifact Facet Order: #{order['facet_order_type_original_artifact']}\" Facets may not display correctly.")
      end
      
      #added for provenance field -- akhil
      
      if !provenance_order.nil? and provenance_order < 0
         warnings.push("Negative value detected. \"Provenance Facet Order: #{order['facet_order_provenance']}\" Facets may not display correctly.")
      end
      
      return warnings

   end

end
