<?php
//TODO: decide if we will verify if user is logged in for ajax calls
if (isset($_GET['form-element'])){
	if ($_GET['form-element'] == 'role') :?>
<div>
<label>Role:</label>
<select name="role[]">
<option>Author</option>
<option>Editor</option>
<option>Publisher</option>
<option>Translator</option>
<option>Creator</option>
<option>Etcher</option>
<option>Engraver</option>
<option>Owner</option>
<option>Artist</option>
<option>Architect</option>
<option>Binder</option>
<option>Book designer</option>
<option>Book producer</option>
<option>Calligrapher</option>
<option>Cartographer</option>
<option>Collector</option>
<option>Colorist</option>
<option>Commentator for written text</option>
<option>Compiler</option>
<option>Compositor</option>
<option>Creator</option>
<option>Dubious author</option>
<option>Facsimilist</option>
<option>Illuminator</option>
<option>Illustrator</option>
<option>Lithographer</option>
<option>Printer</option>
<option>Printer of plates</option>
<option>Printmaker</option>
<option>Repository</option>
<option>Rubricator</option>
<option>Scribe</option>
<option>Sculptor</option>
<option>Type designer</option>
<option>Typographer</option>
<option>Visual Artist</option>
<option>Wood engraver</option>
<option>Wood cutter</option>
</select>
<br>
<label>Value:</label><input type="text" class="text-input" name="role-value[]">
<a href="#" class="remove_field">Remove</a>
</div>
	<?php 
	endif;
}
?>