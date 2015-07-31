/**
 * collex.js
 *
 * Author: Center for Digital Humanities - University of South Carolina.
 * Version: Alpha.
 * Copyright: 2015. All Rights Reserved.
 */

/**
 * Executed when the DOM is ready.
 */
$(document).ready(function() {
  // Internet Explorer v9 and below detection.
  if (platform.name == "IE" && parseInt(platform.version, 10) < 10) {
    $("#alerter").show();
  } else {
    $("#alerter").remove();
  }

  // Initialize all tooltips.
  $("[data-toggle='tooltip']").tooltip();

  // Initialize all DataTables.
  $(".dt").dataTable();

  // Render all times.
  renderTimes();

  // Detect pushState()
  if (window.location.pathname.indexOf("comments") > -1 && window.location.hash !== "") {
    $(".viewer").each(function () {
      if (window.location.hash.substring(1) == $(this).data("value")) {
        renderComments($(this).text(), $(this).data("value"));
        $(this).addClass("viewer-active");
        return false;
      }
    });
  }
});

/**
 * Executed when a user goes back in their history.
 */
window.onpopstate = function () {
  // Detect pushState()
  if (window.location.pathname.indexOf("comments") > -1 && window.location.hash !== "") {
    $(".viewer").each(function () {
      if (window.location.hash.substring(1) == $(this).data("value")) {
        renderComments($(this).text(), $(this).data("value"));
        $(".viewer.viewer-active").removeClass("viewer-active");
        $(this).addClass("viewer-active");
        return false;
      }
    });
  }
};

/**
 * Add another role to the role section within the RDF creation or edit form.
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
  group.show();

  group = section.find("input[name='role_value[]']").last().parent().parent().clone();
  newID = increaseID(group, "input");

  group.find("input").prop("id", newID).val("");
  group.find("label").attr("for", newID);

  $(group).insertBefore($(this).parent().parent());
  group.show();

  section.find(".close.hide").removeClass("hide");

  e.target.blur();
});

/**
 * Add another genre to the genre section within the RDF creation or edit form.
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
  group.show();

  section.find(".close.hide").removeClass("hide");

  e.target.blur();
});

/**
 * Add another alternative title to the alternative title section within the RDF creation or edit form.
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
  group.show();

  section.find(".close.hide").removeClass("hide");

  e.target.blur();
});

/**
 * Add another hasPart to the hasPart section within the RDF creation or edit form.
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
  group.show();

  section.find(".close.hide").removeClass("hide");

  e.target.blur();
});

/**
 * Add another isPartOf to the isPartOf section within the RDF creation or edit form.
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
  group.show();

  section.find(".close.hide").removeClass("hide");

  e.target.blur();
});

/**
 * Remove a form group within the RDF creation or edit form.
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
 * Visually duplicate a user selection inside add modal on edit.
 *
 * @param {HTML DOM Event} e: The event happening.
 */
$(".list-part > button").click(function (e) {
  var section  = $(this).parentsUntil("section").parent();
  var modal    = $(this).parentsUntil("[role='dialog']").parent().prop("id");
  var oldGroup = modal == "isPartOfModal" ? section.find("input[name='is_part_of[]']").last().parent().parent() : section.find("input[name='has_part[]']").last().parent().parent();
  var group    = oldGroup.clone();
  var newID    = increaseID(group, "input");

  group.find("input").prop("id", newID).val($(this).val());
  group.find("label").attr("for", newID);
  group.find("a").attr("href", "view?id=" + $(this).val()).text($(this).attr("title"));

  $(group).insertAfter(oldGroup);
  group.show();

  section.find(".close.hide").removeClass("hide");

  $("#" + modal).modal("hide");

  e.target.blur();
});

/**
 * Visually slide the user down to add a new comment.
 *
 * @param {HTML DOM Event} e: The event happening.
 */
$("#newCommentButton").click(function (e) {
  $("html, body").animate({
    scrollTop: $("#new").position().top
  }, 1200);

  e.target.blur();
});

/**
 * Renders all comments for super users.
 */
$(".viewer").click(function () {
  $(".viewer.viewer-active").removeClass("viewer-active");
  $(this).addClass("viewer-active");

  renderComments($(this).text(), $(this).data("value"));
});

/**
 * Displays a textbox for a user wanting to reply.
 */
$("#results").on("click", ".reply", function () {
  var group = $(this).parentsUntil("div").parent();
  var reply = $("<div class='col-xs-9' style='padding-left: 0; padding-right: 0; margin-bottom: 1%;'><textarea placeholder='Reply to the comment...'></textarea><a class='btn btn-default pull-right' style='margin-top: 1%;'>Submit</a></div>");
  reply.hide().css("margin-left", group.css("margin-left")).find("textarea").addClass("form-control").parent().insertAfter(group).slideDown();
});

/**
 * Submits a reply comment.
 */
$("#results").on("click", "a.btn-default", function (e) {
  alert("Submitting comment. Except not really.");

  e.target.blur();
});

/**
 * Render the comments produced by users.
 *
 * @param {String} title: The title of the page.
 * @param {String} value: The value of the item.
 */
function renderComments(title, value) {
  title += " - Comments and Suggested Items - Index Iuris";
  $.ajax({
    url: "comments",
    type: "GET",
    data: "comments=" + value,
    success: function (result) {
      $("#results").empty().html(result).find("table.dt").dataTable();

      $("title").text(title);

      window.history.pushState({
        title : "#" + value
      }, title, "#" + value);
    },
    error: function (result) {
      console.error("Error connecting to the server. Message: " + result.responseText);
    }
  });
}

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

/**
 * Render all <time> tags from YYYY-MM-DD HH:MM:SS format to Month DD, YYYY HH:MM<am/pm> format.
 */
function renderTimes() {
  $("time").each(function () {
    var text  = $.trim($(this).text());
    var hour = parseInt(text.substring(11, 13), 10);

    if (hour.toString().substring(0, 1) === 0) {
      hour = hour.toString().substring(1);
    }

    var meridiem = hour < 13 ? "am" : "pm";

    if (hour > 12) {
      hour = hour - 12;
    }

    $(this).text(convertMonth(parseInt(text.substring(5, 7), 10)) + " " + parseInt(text.substring(8, 10), 10) + ", " + parseInt(text.substring(0, 4), 10) + " - " + hour + ":" + text.substring(14, 16) + meridiem);
  });
}

/**
 * Converts a month from number format to word format.
 *
 * @param {int} number: The number of the year the month is.
 * @return {String}
 */
function convertMonth(number) {
  switch (number) {
    case 1:
      return "January";
    case 2:
      return "February";
    case 3:
      return "March";
    case 4:
      return "April";
    case 5:
      return "May";
    case 6:
      return "June";
    case 7:
      return "July";
    case 8:
      return "August";
    case 9:
      return "September";
    case 10:
      return "October";
    case 11:
      return "November";
    case 12:
      return "December";
  }
}