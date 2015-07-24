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
 */
$("#addRoleButton").click(function () {
  var section = $(this).parentsUntil("section").parent();
  var group   = section.find("select[name='role[]']").last().parent().parent().clone();
  var newID   = increaseID(group, "select");

  group.find("select").prop("id", newID);
  group.find("label").attr("for", newID);

  $(group).insertBefore($(this).parent().parent());

  group = section.find("input[name='role-value[]']").last().parent().parent().clone();
  newID = increaseID(group, "input");

  group.find("input").prop("id", newID);
  group.find("label").attr("for", newID);

  $(group).insertBefore($(this).parent().parent());

  section.find(".close.hide").removeClass("hide");
});

/**
 * Add another genre to the genre section within the RDF form.
 */
$("#addGenreButton").click(function () {
  var section = $(this).parentsUntil("section").parent();
  var group   = section.find("select[name='genre']").last().parent().parent().clone();
  var newID   = increaseID(group, "select");

  group.find("select").prop("id", newID);
  group.find("label").attr("for", newID);

  $(group).insertBefore($(this).parent().parent());

  section.find(".close.hide").removeClass("hide");
});

/**
 * Add another alternative title to the alternative title section within the RDF form.
 */
$("#addAltTitleButton").click(function () {
  var section = $(this).parentsUntil("section").parent();
  var group   = section.find("input[name='alternative-title[]']").last().parent().parent().clone();
  var newID   = increaseID(group, "input");

  group.find("input").prop("id", newID);
  group.find("label").attr("for", newID);

  $(group).insertBefore($(this).parent().parent());

  section.find(".close.hide").removeClass("hide");
});

/**
 * Add another has part to the has part section within the RDF form.
 */
$("#addHasPartButton").click(function () {
  var section = $(this).parentsUntil("section").parent();
  var group   = section.find("input[name='has-part[]']").last().parent().parent().clone();
  var newID   = increaseID(group, "input");

  group.find("input").prop("id", newID);
  group.find("label").attr("for", newID);

  $(group).insertBefore($(this).parent().parent());

  section.find(".close.hide").removeClass("hide");
});

/**
 * Remove a duplicate within the RDF form.
 *
 * @param e: The event happening.
 */
$("section.form-group").on("click", ".control-label > .close", function (e) {
  var group   = $(this).parentsUntil("div.form-group").parent();
  var section = $(this).parentsUntil("section.form-group").parent();

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
 * Increase a ID on a <input> or <select> for better user experience when
 * a user clicks the corresponding <label>.
 *
 * @param {HTML Element} group: The .form-group of the <input>/<select> and <label>
 * @param {String} search: The form field to be looked for (can be input or select).
 * @return {String}
 */
function increaseID(group, search) {
  var id = group.find(search).prop("id");

  if (!(/^\d+$/).test(id.substring(id.length - 1, id.length))) {
    return id + "1";
  } else {
    var idLength = id.length;

    var idReplace = id.replace(/\D/g, "");

    var number = parseInt(id.substring(idLength - idReplace.length, idLength), 10);

    var newNumb = number + 1;

    var newID = id.substring(0, idLength - number.toString().length);

    return newID + newNumb;

    // var oldNumb = parseInt(id.substring(id.length - id.replace(/\D/g, "").length), id.length, 10);
    // return id.substring(0, id.length - 1) + parseInt(id.substring(id.length - id.replace(/\D/g, "").length, id.length), 10) + 1;
    // return id.substring(0, id.length - oldNumb.toString().length) + (oldNumb + 1);
  }
}
