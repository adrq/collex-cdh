$(document).ready(function() {
	  $('.classification-cell').click(doEnterClassificationEditMode);
	});

function onClassificationComboChange () {
	var cntl = $(this);
	var val = cntl.value;
    var field = $(document).find('input[@name=selected_submission]');
    $(field).attr('value', val);
	$('#classification-form').submit();
};

var inClassificationSelect = false;
var oldClassificationComboValue = "";
var curClassificationComboCell = null;

function onClassificationComboCancel () {
	curClassificationComboCell.html(oldClassificationComboValue);
	inClassificationSelect = false;
};

function trim(str) {
	return str.replace(/^\s\s*/, '').replace(/\s\s*$/, '');
}

function doEnterClassificationEditMode() {
	if (inClassificationSelect == true)
		return;
	inClassificationSelect = true;

    // initialize the combo to the current value
    var currVal = $(this).text();
    currVal = trim(currVal);
	oldClassificationComboValue = currVal;

    // Set the combo where it needs to go
    var cell = $(this);
	curClassificationComboCell = cell;
	var mycombo = classification_combo.replace('>' + currVal + '</option>', ' selected="selected">' + currVal + '</option>');
	mycombo = classification_form_tag + mycombo + '</form>';
	mycombo = mycombo.replace('10101010', this.id)
    cell.html(mycombo);
	var ta = $(document).find('select[@name=classification]');
	ta.focus();
}
