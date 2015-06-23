$(document).ready(function() {
	  $('.textarea-cell').click(doTextAreaEnterEditMode);
	});

var oldVal = "";
var curCell = null;
var inTextAreaSelect = false;

function onTextAreaChange () {
	var ta = $(document).find('#textarea');
	var val = ta[0].value;
    //var field = $(document).find('input[@name=selected_submission]');
    //$(field).attr('value', val);
	if (val != oldVal)
		$('#textarea-form').submit();
	else
	{
		val = val.replace(/&/, '&amp;');
		val = val.replace(/</, '&lt;');
		val = val.replace(/>/, '&gt;');
		curCell.html(val);
		inTextAreaSelect = false;
	}
};

function trim(str) {
	return str.replace(/^\s\s*/, '').replace(/\s\s*$/, '');
}

function doTextAreaEnterEditMode() {
	if (inTextAreaSelect == true)
		return;
	inTextAreaSelect = true;

    // initialize the combo to the current value
    oldVal = $(this).text();
    oldVal = trim(oldVal);

    // Set the textarea where it needs to go
    var cell = $(this);
	curCell = cell;
    //var combo = '<%= Collection.create_status_combo("status") %>';
	var mytextarea = textarea.replace('$(STARTING_TEXT)', oldVal);
	mytextarea = textarea_form_tag + mytextarea + '</form>';
	mytextarea = mytextarea.replace('10101010', this.id)
    cell.html(mytextarea);
	var ta = $(document).find('#textarea');
	ta.focus();
}
