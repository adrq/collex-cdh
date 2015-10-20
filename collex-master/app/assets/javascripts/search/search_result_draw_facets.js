



jQuery(document).ready(function($) {
"use strict";

window.collex.create_facet_button = function(label, value, action, key) {
return window.pss.createHtmlTag("button", { 'class': 'select-facet nav_link', 'data-action': action, 'data-key': key, 'data-value': value }, label);
};

window.collex.number_with_delimiter = function(number) {
var delimiter = ',';
var separator = '.';
var parts = (""+number).split('.');
parts[0] = parts[0].replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1" + delimiter);
return parts.join(separator);
};
function createFacetRow(name, count, dataKey, isSelected, label,facet_name) {
if (!label) label = name;
if (isSelected) {
var remove = window.collex.create_facet_button('[X]', name, "remove", dataKey);
return window.pss.createHtmlTag("tr", { 'class': facet_name }, 
window.pss.createHtmlTag("td", { 'class': "limit_to_lvl1" },  label + "&nbsp;&nbsp;" + remove) +  
window.pss.createHtmlTag("td", { 'class': "num_objects" }, window.collex.number_with_delimiter(count)));
} else {
var button = window.collex.create_facet_button(label, name, "add", dataKey);
return window.pss.createHtmlTag("tr", { 'class': facet_name },
window.pss.createHtmlTag("td", { 'class': "limit_to_lvl1" }, button) +
window.pss.createHtmlTag("td", { 'class': "num_objects" }, window.collex.number_with_delimiter(count)));
}
}

function createFacetBlock(facet_class, hash, dataKey, selected, labels,facet_name) {
	var html = "";
	if (typeof selected === 'string') selected = [ selected ];
		for (var key in hash) {
			if (hash.hasOwnProperty(key)) {
				var selectedIndex = $.inArray(key, selected);
				var label = key;
				if (labels) label = labels[key];
				html += createFacetRow(key, hash[key], dataKey, selectedIndex !== -1, label,facet_name);
			}
		}

		var block = $("."+facet_class);
		var header = window.pss.createHtmlTag("tr", {}, block.find("tr:first-of-type").html());
		block.html(header + html);
}

function createResourceNode(id, level, label, total, childClass) {
var open = window.pss.createHtmlTag("button", { 'class': 'nav_link  limit_to_arrow', 'data-action': "open" },
window.pss.createHtmlTag("img", { 'alt': 'Arrow Open', src: window.collex.images.arrow_open }));
var close = window.pss.createHtmlTag("button", { 'class': 'nav_link  limit_to_arrow', 'data-action': "close" },
window.pss.createHtmlTag("img", { 'alt': 'Arrow Close', src: window.collex.images.arrow_close }));
var name = window.pss.createHtmlTag("button", { 'class': 'nav_link limit_to_category', 'data-action': "toggle" }, label);

var left = window.pss.createHtmlTag("td", { 'class': 'resource-tree-node limit_to_lvl'+level, 'data-id': id }, open+close+name);
var right = window.pss.createHtmlTag("td", { 'class': 'num_objects' }, window.collex.number_with_delimiter(total));
var trClass = "resource_node " + childClass;
return window.pss.createHtmlTag("tr", { id: 'resource_'+id, 'class': trClass }, left+right);
}

function createResourceLeaf(id, level, label, total, handle, childClass, isSelected) {
var trClass = childClass;
var left;
if (isSelected) {
trClass += ' limit_to_selected';
left = window.pss.createHtmlTag("td", { 'class': 'limit_to_lvl'+level }, label + '&nbsp;&nbsp;' + window.collex.create_facet_button('[X]', handle, 'remove', 'a'));
} else {
left = window.pss.createHtmlTag("td", { 'class': 'limit_to_lvl'+level }, window.collex.create_facet_button(label, handle, 'replace', 'a'));
}
var right = window.pss.createHtmlTag("td", { 'class': 'num_objects' }, window.collex.number_with_delimiter(total));
return window.pss.createHtmlTag("tr", { id: 'resource_'+id, 'class': trClass }, left+right);
}

function createResourceSection(resources, hash, level, childClass, handleOfSelected) {
var html = "";
var total = 0;
for (var i = 0; i < resources.length; i++) {
var archive = resources[i];
if (archive.children) {
var section = createResourceSection(archive.children, hash, level + 1, 'child_of_'+archive.id, handleOfSelected);
total += section.total;
if (section.total > 0) {
var thisNode = createResourceNode(archive.id, level, archive.name, window.collex.number_with_delimiter(section.total), childClass);
html += thisNode + section.html;
}
} else {
if (hash[archive.handle]) { // If there are no results, then we don't show that archive.
html += createResourceLeaf(archive.id, level, archive.name, hash[archive.handle], archive.handle, childClass, archive.handle === handleOfSelected);
total += parseInt(hash[archive.handle], 10);
}
}
}
return { html: html, total: total };
}

function cascadeHiding(parent, id) {
var hiddenChildNodes = parent.find('.resource_node.child_of_'+id);
for (var i = 0; i < hiddenChildNodes.length; i++) {
var node = hiddenChildNodes[i];
var nodeId = node.id.split("_")[1];
parent.find(".child_of_"+nodeId).hide();
cascadeHiding(parent, nodeId);
}
}

window.collex.setResourceToggle = function(block, resources) {
for (var i = 0; i < resources.length; i++) {
var archive = resources[i];
if (archive.children) {
if (archive.toggle === 'open') {
block.find("#resource_" + archive.id + ' button[data-action="open"]').hide();
} else {
block.find("#resource_" + archive.id + ' button[data-action="close"]').hide();
block.find('.child_of_'+archive.id).hide();
// Also hide any grandchildren of nodes that would be open.
cascadeHiding(block,archive.id);
}
window.collex.setResourceToggle(block, archive.children);
}
}
};

function createResourceBlock(hash, handleOfSelected) {

var html = createResourceSection(window.collex.facetNames.archives, hash, 1, '', handleOfSelected).html;

var block = $(".facet-archive");
var header = window.pss.createHtmlTag("tr", {}, block.find("tr:first-of-type").html());
block.html(header + html);
// Now close the items that need to be closed.
window.collex.setResourceToggle(block, window.collex.facetNames.archives);
}
var idelement_access;
var idelement_genre;
var idelement_format;
var idelement_origin;
var idelement_language;
var idelement_composition;
var idelement_provenance;
 
 
window.collex.createFacets = function(obj,number) {
	if(window.collex.access_value == true){
		createFacetBlock('facet-access', obj.facets.access, 'o', obj.query.o, window.collex.facetNames.access,'access');
		createResourceBlock(obj.facets.archive, obj.query.a);
		idelement_access = document.getElementsByClassName('access');
		for(var i=0;i<idelement_access.length;i++){
			if(number%2 != 0){
				idelement_access[i].style.display = 'block';
			}else{
				idelement_access[i].style.display = 'none';
			}
		}	
	} else if(window.collex.genre_value == true){
		createFacetBlock('facet-genre', obj.facets.genre, 'g', obj.query.g,'genre','genre');
		createResourceBlock(obj.facets.archive, obj.query.a);
		idelement_genre = document.getElementsByClassName('genre');
		for(var i=0;i<idelement_genre.length;i++){
			console.log(idelement_genre[i]);
			if(number%2 != 0){
				idelement_genre[i].style.display = 'block';
			}else{
				idelement_genre[i].style.display = 'none';
			}
		}
	} else if(window.collex.format_value == true){
		createFacetBlock('facet-format', obj.facets.doc_type, 'doc_type', obj.query.doc_type,'format','format');
		createResourceBlock(obj.facets.archive, obj.query.a);
		idelement_format = document.getElementsByClassName('format');
		for(var i=0;i<idelement_format.length;i++){
			if(number%2 != 0){
				idelement_format[i].style.display = 'block';
			}else{
				idelement_format[i].style.display = 'none';
			}
		}
	} else if(window.collex.origin_value == true){
		createFacetBlock('facet-origin', obj.facets.origin, 'origin', obj.query.origin,'origin','origin');
		createResourceBlock(obj.facets.archive, obj.query.a);
		idelement_origin = document.getElementsByClassName('origin');
		for(var i=0;i<idelement_origin.length;i++){
			if(number%2 != 0){
				idelement_origin[i].style.display = 'block';
			}else{
				idelement_origin[i].style.display = 'none';
			}
		}
	} else if(window.collex.composition_value == true){
		createFacetBlock('facet-composition', obj.facets.composition, 'composition', obj.query.composition,'composition','composition');
		createResourceBlock(obj.facets.archive, obj.query.a);
		idelement_composition = document.getElementsByClassName('composition');
		for(var i=0;i<idelement_composition.length;i++){
			if(number%2 != 0){
				idelement_composition[i].style.display = 'block';
			}else{
				idelement_composition[i].style.display = 'none';
			}
		}
	} else if(window.collex.provenance_value == true){
		createFacetBlock('facet-provenance', obj.facets.provenance, 'provenance', obj.query.provenance,'provenance','provenance');
		createResourceBlock(obj.facets.archive, obj.query.a);
		idelement_provenance = document.getElementsByClassName('provenance');
		for(var i=0;i<idelement_provenance.length;i++){
			if(number%2 != 0){
				idelement_provenance[i].style.display = 'block';
			}else{
				idelement_provenance[i].style.display = 'none';
			}
		}
	}else if(window.collex.language_value == true){
		console.log("hey into the language display",obj.query.language);

		createFacetBlock('facet-language', obj.facets.language, 'lang', obj.query.lang,'language','language');
		createResourceBlock(obj.facets.archive, obj.query.a);
		idelement_language = document.getElementsByClassName('language');
		for(var i=0;i<idelement_language.length;i++){
			if(number%2 != 0){
				idelement_language[i].style.display = 'block';
			}else{
				idelement_language[i].style.display = 'none';
			}
		}
	}else{

	}
};


/*window.collex.createFacets_genre =function(obj){
createFacetBlock('facet-genre', obj.facets.genre, 'g', obj.query.g,'genre');
createResourceBlock(obj.facets.archive, obj.query.a);
}
window.collex.createFacets_discipline =function(obj){
createFacetBlock('facet-discipline', obj.facets.discipline, 'discipline', obj.query.discipline,'discipline');
createResourceBlock(obj.facets.archive, obj.query.a);
}
window.collex.createFacets_format =function(obj){
createFacetBlock('facet-format', obj.facets.doc_type, 'doc_type', obj.query.doc_type,'format');
createResourceBlock(obj.facets.archive, obj.query.a);
}
window.collex.createFacets_access =function(obj){
//console.log(access_number);
createFacetBlock('facet-access', obj.facets.access, 'o', obj.query.o, window.collex.facetNames.access,'access');
createResourceBlock(obj.facets.archive, obj.query.a);
idelement = document.getElementById('access');
if(window.collex.access_number%1 != 0){
idelement.style.display = 'block';
}else{
idelement.style.display = 'none';
}
//access_number= access_number+1;
}
window.collex.createFacets_origin =function(obj){
createFacetBlock('facet-origin', obj.facets.origin, 'origin', obj.query.origin,'origin');
createResourceBlock(obj.facets.archive, obj.query.a);
}*/
});












