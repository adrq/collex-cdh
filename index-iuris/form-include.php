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
	elseif ($_GET['form-element'] == 'genre') :?>
<div>
<label>Genre:</label>
<select name="genre[]">
<option>Account</option>
<option>Accusation</option>
<option>Aide</option>
<option>Amercement</option>
<option>Appeal</option>
<option>Assize</option>
<option>Benefice</option>
<option>Brief</option>
<option>Canon</option>
<option>Casus</option>
<option>Causa</option>
<option>Census</option>
<option>Certificate</option>
<option>Challenge</option>
<option>Charge</option>
<option>Code of laws</option>
<option>Collection</option>
<option>Commentary</option>
<option>Consilium</option>
<option>Consistory</option>
<option>Contract</option>
<option>Corpus</option>
<option>Council</option>
<option>Covenant</option>
<option>Damages</option>
<option>Defense</option>
<option>Decretal</option>
<option>Deposition</option>
<option>Dicta</option>
<option>Dispensation</option>
<option>Distinction</option>
<option>Edict</option>
<option>Enfeoffement</option>
<option>Evidence</option>
<option>Formula</option>
<option>Gloss</option>
<option>Handbook</option>
<option>Immunity</option>
<option>Imperial constitution</option>
<option>Inquest</option>
<option>Inquisition</option>
<option>Investigation</option>
<option>Judgment</option>
<option>Manumission</option>
<option>Narrative</option>
<option>Oath</option>
<option>Opinion</option>
<option>Petition</option>
<option>Plea</option>
<option>Prescription</option>
<option>Privilege</option>
<option>Process</option>
<option>Proof</option>
<option>Receipt</option>
<option>Regulation</option>
<option>Rescript</option>
<option>Response</option>
<option>Statute</option>
<option>Summa</option>
<option>Summation</option>
<option>Synod</option>
<option>Testament</option>
<option>Testimony</option>
<option>Treatise</option>
<option>Trial</option>
<option>Textbook</option>
<option>Verdict</option>
<option>Voucher</option>
<option>Will</option>
<option>Writ</option>
</select>
<br>
<a href="#" class="remove_field">Remove</a>
</div>

<?php elseif ($_GET['form-element'] == 'alt-title') :?>
<div><label>Alternative title:</label><input type="text" class="text-input" name="alternative-title[]">
<br>
<a href="#" class="remove_field">Remove</a>
</div>
<?php 
	
	endif;
}
?>