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
});

/**
 * Add another role to the role section within the RDF form.
 */
$("#addRoleButton").click(function () {
  $($("select[name='role[]']").first().parent().parent().clone()).insertBefore($("input[name='role-value[]']").parent().parent());

  $(this).parentsUntil("section").parent().find(".close.hide").removeClass("hide");
});

/**
 * Add another genre to the genre section within the RDF form.
 */
$("#addGenreButton").click(function () {
  $($("select[name='genre[]']").first().parent().parent().clone()).insertAfter($("select[name='genre[]']").last().parent().parent());

  $(this).parentsUntil("section").parent().find(".close.hide").removeClass("hide");
});

/**
 * Add another alternative title to the alternative title section within the RDF form.
 */
$("#addAltTitleButton").click(function () {
  $($("input[name='alternative-title[]']").first().parent().parent().clone()).insertBefore($(this).parent().parent());

  $(this).parentsUntil("section").parent().find(".close.hide").removeClass("hide");
});

/**
 * Add another has part to the has part section within the RDF form.
 */
$("#addHasPartButton").click(function () {
  $($("input[name='has-part[]']").first().parent().parent().clone()).insertBefore($(this).parent().parent());

  $(this).parentsUntil("section").parent().find(".close.hide").removeClass("hide");
});

/**
 * Remove a duplicate within the RDF form.
 *
 * @param e: The event happening.
 */
$("section.form-group").on("click", ".control-label > .close", function (e) {
  $(this).parentsUntil(".form-group").parent().fadeOut(function () {
    $(this).remove();
  });

  if ($(this).parentsUntil("section.form-group").parent().find(".close").length == 2) {
    $(this).parentsUntil("section.form-group").parent().find(".close").addClass("hide");
  }

  e.target.blur();
});
