	$(document).ready(function() {
		  $('.status-cell').click(doEnterEditMode);
		});

	function onComboChange () {
		var cntl = $(this);
		var val = cntl.value;
	    var field = $(document).find('input[@name=selected_submission]');
	    $(field).attr('value', val);
		$('#status-form').submit();
	};

	var inSelect = false;
	var oldComboValue = "";
	var curComboCell = null;

	function onComboCancel () {
		curComboCell.html(oldComboValue);
		inSelect = false;
	};
	
	function trim(str) {
		return str.replace(/^\s\s*/, '').replace(/\s\s*$/, '');
	}

	function doEnterEditMode() {
		if (inSelect == true)
			return;
		inSelect = true;

	    // initialize the combo to the current value
	    var currVal = $(this).text();
	    currVal = trim(currVal);
		oldComboValue = currVal;

	    // Set the combo where it needs to go
	    var cell = $(this);
		curComboCell = cell;
		var mycombo = combo.replace('>' + currVal + '</option>', ' selected="selected">' + currVal + '</option>');
		mycombo = form_tag + mycombo + '</form>';
		mycombo = mycombo.replace('10101010', this.id)
	    cell.html(mycombo);
		var ta = $(document).find('select[@name=status]');
		ta.focus();
	}
