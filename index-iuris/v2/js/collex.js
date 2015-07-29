/**
 * collex.js
 *
 * Author: Center for Digital Humanities - University of South Carolina.
 * Version: 1.0.
 * Copyright: 2015. All Rights Reserved.
 */

/**
 * Executed when the DOM is ready.
 */
$(document).ready(function() {
  // Initialize all tooltips.
  $("[data-toggle='tooltip']").tooltip();

  // Initialize all DataTables.
  $(".dt").dataTable();
});

/**
 * Add another role to the role section within the RDF form.
 *
 * @param {HTML DOM Event} e: The event happening.
 */
$("#addRoleButton").click(function (e) {
  var section = $(this).parentsUntil("section").parent();
  var group   = section.find("select[name='role[]']").last().parent().parent().clone();
  var newID   = increaseID(group, "select");

  group.find("select").prop("id", newID).find("> option:selected").removeAttr("selected").parent().find("> option:first-child").prop("selected", "true");
  group.find("label").attr("for", newID);

  $(group).insertBefore($(this).parent().parent());
  $(group).css('display','inline');

  group = section.find("input[name='role_value[]']").last().parent().parent().clone();
  newID = increaseID(group, "input");

  group.find("input").prop("id", newID).val("");
  group.find("label").attr("for", newID);

  $(group).insertBefore($(this).parent().parent());
  $(group).css('display','inline');

  section.find(".close.hide").removeClass("hide");

  e.target.blur();
});

/**
 * Add another genre to the genre section within the RDF form.
 *
 * @param {HTML DOM Event} e: The event happening.
 */
$("#addGenreButton").click(function (e) {
  var section = $(this).parentsUntil("section").parent();
  var group   = section.find("select[name='genre[]']").last().parent().parent().clone();
  var newID   = increaseID(group, "select");

  group.find("select").prop("id", newID).find("> option:selected").removeAttr("selected").parent().find("> option:first-child").prop("selected", "true");
  group.find("label").attr("for", newID);

  $(group).insertBefore($(this).parent().parent());

  section.find(".close.hide").removeClass("hide");

  e.target.blur();
});

/**
 * Add another alternative title to the alternative title section within the RDF form.
 *
 * @param {HTML DOM Event} e: The event happening.
 */
$("#addAltTitleButton").click(function (e) {
  var section = $(this).parentsUntil("section").parent();
  var group   = section.find("input[name='alternative_title[]']").last().parent().parent().clone();
  var newID   = increaseID(group, "input");

  group.find("input").prop("id", newID).val("");
  group.find("label").attr("for", newID);

  $(group).insertBefore($(this).parent().parent());
  $(group).css('display','inline');

  section.find(".close.hide").removeClass("hide");

  e.target.blur();
});

/**
 * Add another has part to the has part section within the RDF form.
 *
 * @param {HTML DOM Event} e: The event happening.
 */
$("#addHasPartButton").click(function (e) {
  var section = $(this).parentsUntil("section").parent();
  var group   = section.find("input[name='has_part[]']").last().parent().parent().clone();
  var newID   = increaseID(group, "input");

  group.find("input").prop("id", newID).val("");
  group.find("label").attr("for", newID);

  $(group).insertBefore($(this).parent().parent());
  $(group).css('display','inline');

  section.find(".close.hide").removeClass("hide");

  e.target.blur();
});

/**
 * Add another isPartOf to the has part section within the RDF form.
 *
 * @param {HTML DOM Event} e: The event happening.
 */
$("#addIsPartOfButton").click(function (e) {
  var section = $(this).parentsUntil("section").parent();
  var group   = section.find("input[name='is_part_of[]']").last().parent().parent().clone();
  var newID   = increaseID(group, "input");

  group.find("input").prop("id", newID).val("");
  group.find("label").attr("for", newID);

  $(group).insertBefore($(this).parent().parent());
  $(group).css('display','inline');

  section.find(".close.hide").removeClass("hide");

  e.target.blur();
});

/**
 * Remove a duplicate within the RDF form.
 *
 * @param {HTML DOM Event} e: The event happening.
 */
$("section").on("click", ".control-label > .close", function (e) {
  var group   = $(this).parentsUntil("div.form-group").parent();
  var section = $(this).parentsUntil("section").parent();

  // fadeOut for visuals, then remove from the DOM.
  if (section.prev().get(0).innerText == "Role" && $(this).parent().text().substring(1) == "Role") {
    group.next().fadeOut(function () {
      $(this).remove();
    });
  } else if (section.prev().get(0).innerText == "Role" && $(this).parent().text().substring(1) == "Value") {
    group.prev().fadeOut(function () {
      $(this).remove();
    });
  }

  group.fadeOut(function () {
    $(this).remove();
  });

  // Determine if users need visual access to this functionality again.
  if ((section.prev().get(0).innerText == "Role" && section.find(".close").length == 4) || (section.prev().get(0).innerText != "Role" && section.find(".close").length == 2)) {
    section.find(".close").addClass("hide");
  }

  e.target.blur();
});

/**
 * Visually slide the user down to add a new comment.
 *
 * @param {HTML DOM Event} e: The event happening.
 */
$("#newCommentButton").click(function (e) {
  $("html, body").animate({
    scrollTop: $("#newComment").position().top
  }, 1200);

  e.target.blur();
});

/**
 * Renders all comments for super users.
 */
$("select#comment").on("change", function () {
  var value = $(this).val();
  $.ajax({
    url: "comments",
    type: "GET",
    data: "comments=" + value,
    beforeSend: function () {
      console.info("Attempting to grab comments. - " + value);
    },
    success: function (result) {
      $("#commentResults").html(result).find("table.dt").dataTable();
    },
    error: function (result) {
      console.error("Error connecting to the server. Message: " + result.responseText);
    }
  });
});

/**
 * Increase a ID on a <input> or <select> for better user experience when
 * a user clicks the corresponding <label>.
 *
 * @param {HTML Element} group: The .form-group of the <input>/<select> and <label>
 * @param {String} search: The form field to be looked for (can be input or select).
 * @return {String}
 */
function increaseID(group, search) {
  var id = group.find(search).prop("id");

  if ((/^\d+$/).test(id.substring(id.length - id.replace(/\D/g, ""), id.length))) {
    var number = parseInt(id.substring(id.length - id.replace(/\D/g, "").length, id.length), 10);

    return id.substring(0, id.length - number.toString().length) + (number + 1);
  } else {
    return id + "1";
  }
}
