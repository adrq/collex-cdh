<?php $pageTitle="Index Iuris - Metadata Submission Form" //require php v5.5?>
<?php include("header.php")?>
<?php if($_SESSION['logged-in']!=true): ?>
<div id="login-container">
<script type="text/javascript">
<!--
window.location = "../index-iuris/login.php"
//-->
</script>
<h2>Please click <a href="login.php">here</a> to login</h2>
</div>
</body>
</html>
<?php die();?>
<?php endif;?>

<?php if (!isset($_POST['submitted'])) : ?>
<div>
<p><span class="bold-text">Dear PI or Project Manager,</span></p>
<p>As we develop <span class="monospace">Index Iuris</span>, we seek to understand the needs and preferences of potential members of the federation.  We would be very grateful if you could take a little time to review this form, experiment with filling it out, and offer your views in the comment boxes provided.  In the end, membership in Index Iuris should not be a burden!</p>
<p>Thanks so much!</p>
<p>The Index Iuris team.</p>
<hr>
<p>The following form, once finalized, will be the fundamental mechanism for integrating the content of member projects into the <span class="monospace">Index Iuris</span> portal to all projects.  The metadata supplied in this form makes possible effective searching, and meaningful display of search results.  Not all the information in this form will be required or displayed, but some of the fields are necessary if we are to conform to best practices and technical requirements.</p>

</div>

<form action="rdf-form.php" method="post">


<div class="form-item">
<div class="form-metadata-item">
<h3 class="form-item-label">Custom namespace</h3>
<div class="form-item-description">
<p>
This field is required, and its format is predetermined for technical reasons. Custom namespace is a short code to identify the project. It is formatted as two pieces of text separated by a colon. The text before the colon identifies the main project or collection; the text after the colon identifies the collection or subcollection.
</p>
<p>Examples:</p>
<p class="form-item-example">
CarolingianCanonLawProject:transcription<br>
AmesFoundation:book<br>
VirtualCanonLawLibrary:commentary<br>
VirtualCanonLawLibrary:book<br>
Pennington:consilia
</p>
</div>
<div class="form-item-question">
<label>Custom namespace:</label><input type="text" class="text-input" name="custom-namespace">
</div>
</div>
<div class="form-poll-item">
<div class="form-item-question">
Would you be able to decide what goes after the colon? <br>
<label>Yes</label><input type="radio" name="custom-namespace-available" value="true">
<label>No</label><input type="radio" name="custom-namespace-available" value="false">
</div>
</div>
</div>


<div class="form-item">
<div class="form-metadata-item">
<h3 class="form-item-label">rdf:about</h3>
<div class="form-item-description">
<p>
<span class="monospace">rdf:about</span> is a required attribute of <span class="monospace">custom namespace</span>, and its format is predetermined for technical reasons . <span class="monospace">rdf:about</span> is a URI or a URL that uniquely identifies the record to be indexed.
</p>
<p>Examples:</p>
<p class="form-item-example">
&lt;pennington:medieval_legal_texts rdf:about="http://faculty.cua.edu/pennington/edit301.htm"&gt;<br>
&lt;CCL:manuscripts rdf:about="http://ccl.rch.uky.edu/aboutBod718"&gt; 
</p>
</div>
<div class="form-item-question">
<label>rdf:about</label><input type="text" class="text-input" name="rdf:about">
</div>
</div>
<div class="form-poll-item">
<div class="form-item-question">
<label>Comments: </label><textarea name="comments-rdf-about" rows="4" cols="50"></textarea>
</div>
</div>
</div>


<div class="form-item">
<div class="form-metadata-item">
<h3 class="form-item-label">Archive</h3>
<div class="form-item-description">
<p>
<span class="monospace">archive</span> is required.  It should be a clear, short version of the name or identity of the member project.  It must be a single word or string of characters, with no spaces.
</p>
<p>Examples:</p>
<p class="form-item-example">
AMES  (for Ames Foundation, Harvard Law School project)<br>
CCL (for the Carolingian Canon Law project)<br>
VirtualCanonLawLibrary (for the Virtual Library of Medieval Canon Law at Colby)<br>
PENNINGTON  (for Kenneth Pennington’s website)
</p>
</div>
<div class="form-item-question">
<label>Archive name:</label><input type="text" class="text-input" name="archive">
</div>
</div>
</div>



<div class="form-item">
<div class="form-metadata-item">
<h3 class="form-item-label">Title</h3>
<div class="form-item-description">
<p>
<span class="monospace">title</span> is required.  Each item to be integrated in Index Iuris must have a title.  It is expected that some titles will occur more than once (several items may have the title “Summa”), but each item can have only one title (you can not give both “Corpus iuris civilis” and “Digest” as title for the same item).
</p>
<p>Examples:</p>
<p class="form-item-example">
Collectio Dacheriana<br>
Consilia<br>
De Legibus et Consuetudinibus Angliae<br>
Summa “Animal est substantia”
</p>
</div>
<div class="form-item-question">
<label>Title:</label><input type="text" class="text-input" name="title">
</div>
</div>
</div>


<div class="form-item">
<div class="form-metadata-item">
<h3 class="form-item-label">Type</h3>
<div class="form-item-description">
<p>
<span class="monospace">type</span> is required. It describes the type of medium or artefact of the item to be integrated into Index Iuris.  This term will be selected from a pre-determined list (controlled vocabulary).
</p>
</div>
<div class="form-item-question">
<label>Type:</label>
<select name="type">
<option>Critical edition</option>
<option>Digital image</option>
<option>Drawing</option>
<option>Facsimile</option>
<option>Fragment</option>
<option>Illustration</option>
<option>Interactive Resource</option>
<option>Manuscript Codex</option>
<option>Map</option>
<option>Microfilm</option>
<option>Image (b/w)</option>
<option>Online images (for manuscripts online)</option>
<option>Online transcription of printed book (html, XML)</option>
<option>Physical Object [such as a stone tablet, monumental arch, seal]</option>
<option>Printed book</option>
<option>Roll</option>
<option>Scanned image of printed book (pdf)</option>
<option>Sheet</option>
<option>Typescript</option>
</select>
</div>
</div>
<div class="form-poll-item">
<div class="form-item-question">
Would you be able to use the terms in the dropdown to complete the form for the items in your project that you would want integrated into Index Iuris?  If not, please identify additional terms that should be added to this list.<br>
<label>Yes</label><input type="radio" name="type-available" value="true">
<label>No</label><input type="radio" name="type-available" value="false">
</div>
<div class="form-item-question">
<label>Please add terms here, separated by commas:</label><input type="text" class="text-input" name="suggested-terms-type">
</div>
</div>
</div>


<div class="form-item">
<div class="form-metadata-item">
<h3 class="form-item-label">Role</h3>
<div class="form-item-description">
<p>
<span class="monospace">role</span> is an optional field, but if used, the terms will be selected from a pre-determined list (controlled vocabulary)
</p>
<p>This field can appear multiple times. Final form will have an option to enter more than one <span class="monospace">role</span> field.
</p>
</div>
<div class="form-item-question">
<label>Role:</label>
<select name="role">
<option>Visual Artist</option>
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
<option>Wood engraver</option>
<option>Wood cutter</option>
</select>
</div>
<div class="form-item-question">
<label>Value:</label><input type="text" class="text-input" name="role-value">
</div>
</div>
<div class="form-poll-item">
<div class="form-item-question">
Would you be able to use the these terms to complete the form for the items in your project that you would want integrated into Index Iuris?  If not, please identify additional terms that should be added to this list.<br>
<label>Yes</label><input type="radio" name="role-available" value="true">
<label>No</label><input type="radio" name="role-available" value="false">
</div>
<div class="form-item-question">
<label>Please add terms here, separated by commas:</label><input type="text" class="text-input" name="suggested-terms-role">
</div>
</div>
</div>


<div class="form-item">
<div class="form-metadata-item">
<h3 class="form-item-label">Genre</h3>
<div class="form-item-description">
<p>
<span class="monospace">genre</span> differs from “type” in that it describes the textual form, rather than the physical medium or artefact.  
</p>
</div>
<div class="form-item-question">
<label>Genre:</label>
<select name="genre">
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
</div>
</div>
<div class="form-poll-item">
<div class="form-item-question">
<p>Should this field be required or optional?</p>
<label>Required</label><input type="radio" name="genre-required" value="true">
<label>Optional</label><input type="radio" name="genre-required" value="false">
</div>
<div class="form-item-question">
<p>Should this field have controlled vocabulary, or be free-form?  Controlled vocabulary supports check-box searches for all indexed items of a particular genre (if you want to look only at imperial edicts); free-form allows a wider range of description. Note: we can split the difference, and have auto-suggestions as you type.</p>
<label>Controlled</label><input type="radio" name="genre-controled" value="true">
<label>Free-form</label><input type="radio" name="genre-controlled" value="false">
</div>
<div class="form-item-question">
<label>Please add terms here, separated by commas:</label><input type="text" class="text-input" name="suggested-terms-genre">
</div>
</div>
</div>


<div class="form-item">
<div class="form-metadata-item">
<h3 class="form-item-label">Date</h3>
<div class="form-item-description">
<p>
<span class="monospace">date</span> refers to the date of original composition, to the extent that it is known. This field is required. Index Iuris will use both human
readable expressions in its displays, and also machine readable formats to facilitate searching by date range.
</p>
<p>Examples of human readable dates:</p>
<p class="form-item-example">
14th century<br>
not before 1475<br>
saec. IXin-med<br>
0850; 1122<br>
c. 1100<br>
1300-1350<br>
1st part of manuscript 9th century; 2nd part early 12th century<br>
</p>
<p>Machine-readable dates must be one of the following: a four-digit year, e.g. “1425” or “0850”
two four-digit years, separated by a hypen, indicating a span of time e.g. “1425-1450”. The conventions for “beginning, middle, third-quarter, end, etc.” of centuries are converted to 25 year increments: 0800, 0825, 0850, 0875
two four-digit year separated by a semi-colon indicate that the text or object was composed or created at two dates. Both should be searchable.</p>
</div>
<div class="form-item-question">
<label>Human readable date:</label><input type="text" class="text-input" name="date-human">
</div>
<div class="form-item-question">
<label>Mahcine readable date:</label><input type="text" class="text-input" name="date-machine">
</div>
</div>
<div class="form-poll-item">
<div class="form-item-question">
<p>Would you be able to complete this field for items in your project to be integrated in Index Iuris, following these models?</p>
<label>Yes</label><input type="radio" name="date-available" value="true">
<label>No</label><input type="radio" name="date-available" value="false">
</div>
<div class="form-item-question">
<label>Comments: </label><textarea name="comments-date" rows="4" cols="50"></textarea>
</div>
</div>
</div>



<div class="form-item">
<div class="form-metadata-item">
<h3 class="form-item-label">Link to digital item</h3>
<div class="form-item-description">
<p>
<span class="monospace"></span>This field is completed with a URL or URI that is the address for the specific item to be displayed, such as a manuscript image, or a page of a transcription, or a document.  It is required!
</p>
<p>Examples:</p>
<p class="form-item-example">
http://pds.lib.harvard.edu/pds/view/14856910?n=3384<br>
http://ccl.rch.uky.edu/node/1419<br>
http://ccl.rch.uky.edu/node/3908<br>
http://faculty.cua.edu/Pennington/edit323.htm
</p>
</div>
<div class="form-item-question">
<label>URL:</label><input type="text" class="text-input" name="seeAlso"> <!-- rdfs:seeAlso -->
</div>
</div>
<div class="form-poll-item">
<div class="form-item-question">
<p>Would you be able to supply a URL or URI for each item to be integrated into Index Iuris?  (for compound objects, please contact the Index Iuris team)</p>
<label>Yes</label><input type="radio" name="url-available" value="true">
<label>No</label><input type="radio" name="url-available" value="false">
</div>
</div>
</div>


<div class="form-item">
<div class="form-metadata-item">
<h3 class="form-item-label">Provenance</h3>
<div class="form-item-description">
<p>
<span class="monospace">provenance</span> is actually two fields, both optional (although we recommend completing at least one).  The first field is <span class="monospace">origin</span>, which can be used for the place where a manuscript written, or a work published.  The second field is <span class="monospace">provenance</span>, which can be used for ownership information, or likely area of use or circulation, or the earliest known information about an items whereabouts.  NOTE: see below for <span class="monospace">place of composition</span>
</p>
<p>Examples:</p>
<p class="form-item-example">
Origin: Bologna<br>
Origin: Northeast France<br>
Provenance: St. Gall<br>
Provenance: Durham Cathedral Priory (suppressed 1540); Thomas Allen (d. 1632); George Henry Lee, 3rd Earl of Lichfield (d. 1772); Reverend Thomas Phillips, S.J. (d. 1774); Stonyhurst College; British Library
</p>
<p>
If there is nothing in the <span class="monospace">origin</span> field, the <span class="monospace">provenance</span> information is displayed in the basic metadata; if there is information in the <span class="monospace">origin</span> field, that is what is displayed in the basic metadata.
</p>
</div>
<div class="form-item-question">
<label>Origin:</label><input type="text" class="text-input" name="origin">
</div>
<div class="form-item-question">
<label>Provenance:</label><input type="text" class="text-input" name="provenance">
</div>
</div>
<div class="form-poll-item">
<div class="form-item-question">
<label>Comments: </label><textarea name="comments-provenance" rows="4" cols="50"></textarea>
</div>
</div>
</div>


<div class="form-item">
<div class="form-metadata-item">
<h3 class="form-item-label">Place of composition</h3>
<div class="form-item-description">
<p>
<span class="monospace">place of composition</span> is used for the place where a text was composed, if known.  This field is optional. 
</p>
<p>Examples:</p>
<p class="form-item-example">
place of composition: Rome<br>
place of composition: University of Paris<br>
</p>
</div>
<div class="form-item-question">
<label>Place of composition:</label><input type="text" class="text-input" name="place-of-composition">
</div>
</div>
<div class="form-poll-item">
<div class="form-item-question">
<label>Comments: </label><textarea name="comments-place-of-composition" rows="4" cols="50"></textarea>
</div>
</div>
</div>


<div class="form-item">
<div class="form-metadata-item">
<h3 class="form-item-label">Shelfmark</h3>
<div class="form-item-description">
<p>
<span class="monospace">shelfmark</span> is required for items that are manuscripts. This is the unique, internationally known identifier for a manuscript.  Consists of City, Repository (library), fond (internal library collection), number.  For incunabula or other rare printings, this field may be used for library identifications of the physical artefact, as well.  This field is optional for all other publications or editions.
</p>
<p>Examples:</p>
<p class="form-item-example">
Admont en Styrie, Bibliothèque du monastère, 162<br>
Berlin, Staatsbibliothek Preussischer Kulturbesitz, Lat. fol. 626<br>
Vaticano, Città del, Biblioteca Apostolica Vaticana, Ottobon. lat. 3295<br>
Würzburg, Universitätsbibliothek, M.p.th.f.72<br>
Lexington, University of Kentucky, Margaret I. King Library, Special Collections, KBR197.6 .C36 1525
</p>
</div>
<div class="form-item-question">
<label>Shelfmark:</label><input type="text" class="text-input" name="shelfmark">
</div>
</div>
</div>

<!-- 
<div class="form-item">
<div class="form-metadata-item">
<h3>freeculture?</h3>
</div>
</div>


<div class="form-item">
<div class="form-metadata-item">
<h3>Full text goes here</h3>
</div>
</div>


<div class="form-item">
<div class="form-metadata-item">
<h3>Image goes here</h3>
</div>
</div>
-->

<div class="form-item">
<div class="form-metadata-item">
<h3 class="form-item-label">Alternative title</h3>
<div class="form-item-description">
<p>
<span class="monospace">alternative title</span> is an optional field that can be used for common, “pet” names of a text or manuscripts.
</p>
<p>The final form will include the option to submit more than one <span class="monospace">alternative title</span>.</p>
<p>Examples:</p>
<p class="form-item-example">
“The Florence Codex”<br>
“X”<br>
“Concordia Discordantium Canonum”
</p>
</div>
<div class="form-item-question">
<label>Alternative title:</label><input type="text" class="text-input" name="alternative-title">
</div>
</div>
</div>
<!-- Need to add possibility for multiple alternative titles. -->


<div class="form-item">
<div class="form-metadata-item">
<h3 class="form-item-label">Source</h3>
<div class="form-item-description">
<p>
<span class="monospace"></span> This field should not be confused with Provenance, Place of origin of object, Place of composition, or IsPartOf! <span class="monospace">source</span> is used for the title of the larger work, resource, or collection of which the present object is a part. Can be used for the title of a journal, anthology, book, online collection, etc.
</p>
<p>Examples:</p>
<p class="form-item-example">
The Spoils of the Pope and the Pirates, 1357: the complete legal dossier from the Vatican Archives<br>
The Common and Piepowder Courts of Southampton, 1426-1483<br>
CEEC: Codices Electronici Ecclesiae Coloniensis
</p>
</div>
<div class="form-item-question">
<label>Source:</label><input type="text" class="text-input" name="source">
</div>
</div>
</div>


<div class="form-item">
<div class="form-metadata-item">
<h3 class="form-item-label">Is part of</h3>
<div class="form-item-description">
<p>
<span class="monospace">isPartOf</span> is a useful field for legal texts, which often are compilations of many texts. This field is optional.
</p>
<p>Examples:</p>
<p class="form-item-example">
For the Bulla “Rex Pacificus”, one could have <span class="bold-text">IsPartOf</span> Liber extravagantium decretalium<br>
For a particular transcription of the Council of Arles, on could have <span class="bold-text">IsPartOf</span> Collectio Hispana<br>
For a particular Novel of Justinian, one could have <span class="bold-text">IsPartOf</span> Corpus iuris civilis<br>
</p>
</div>
<div class="form-item-question">
<label>Is part of:</label><input type="text" class="text-input" name="is-part-of">
</div>
</div>
<div class="form-poll-item">
<div class="form-item-question">
<label>Comments:</label><textarea name="is-part-of-comments" rows="4" cols="50"></textarea>
</div>
</div>
</div>


<div class="form-item">
<div class="form-metadata-item">
<h3 class="form-item-label">Has part</h3>
<div class="form-item-description">
<p>
<span class="monospace">hasPart</span> is the obverse of <span class="monospace">isPartOf</span>. This field is optional. For texts that contain many other texts, this field can be used to list one or more items included in the larger work.
</p>
<p>The final form will have the option to add multilple <span class="monospace">hasPart</span> fields.</p>
<p>Examples:</p>
<p class="form-item-example">
Collectio Dacheriana <span class="bold-text">HasPart</span> Book I, Book II, Book III
Collectio Dionysiana <span class="bold-text">HasPart</span> Canones Apostolorum, Conc. Nicea, Conc. Ancyra, Conc. Neocaesarea, Conc. Constantinople, Conc. Gangra, Conc. Sardica, etc.
</p>
</div>
<div class="form-item-question">
<label>Has part:</label><input type="text" class="text-input" name="has-part">
</div>
</div>
<div class="form-poll-item">
<div class="form-item-question">
<label>Comments:</label><textarea name="has-part-comments" rows="4" cols="50"></textarea>
</div>
</div>
</div>
<?php //TODO - add multiple hasPart?>


<div class="form-item">
<div class="form-metadata-item">
<h3 class="form-item-label">Divisions of the text</h3>
<div class="form-item-description">
<p>
<span class="monospace"></span>Divisions of the text is an optional field that is purely for information (that is, it does not affect digital display or processing).  Here it is possible to give useful descriptions of how a compilation is structured, organized, divided.
</p>
<p>Examples:</p>
<p class="form-item-example">
The Collection in 74 Titles is divided into “titles”, each of which is divided into “canons”<br>
The Dionysiana is divided into councils, each of which is preceded by a tabula titulorum and followed by a subscription list.  The body of the conciliar text is divided into canons.<br>
The Decretum is divided into three parts.  The first part has 101 distinctiones; the second part has 36 causae, the third part, entitled “De consecration” contains 5 distinctiones.  Each causa is divided into quaestiones… etc.
</p>
</div>
<div class="form-item-question">
<label>Divisions of the text:</label><textarea name="text-divisions" rows="4" cols="50"></textarea>
</div>
</div>
<div class="form-poll-item">
<div class="form-item-question">
<label>Comments: </label><textarea name="comments-text-divisions" rows="4" cols="50"></textarea>
</div>
</div>
</div>


<div class="form-item">
<div class="form-metadata-item">
<h3 class="form-item-label">Language</h3>
<div class="form-item-description">
<p>
<span class="monospace">Language</span> identifies the language of the object using language codes from the <a href="https://www.loc.gov/standards/iso639-2/php/code_list.php" target="_blank">ISO 639-2 Language Code List</a>.
</p>
</div>
<div class="form-item-question">
<label>Language:</label><input type="text" class="text-input" name="language">
</div>
</div>
</div>


<div class="form-item">
<div class="form-metadata-item">
<h3 class="form-item-label">Metadata source code</h3>
<div class="form-item-description">
<p>
<span class="monospace">metadata source code</span> is an optional field. If your project has metadata that does not duplicate the descriptions in the fields above that should be included in Index Iuris, you may use this field for the URL or URI for the web-accessible XML or HTML metadata.
</p>
</div>
<div class="form-item-question">
<label>URL of source code:</label><input type="text" class="text-input" name="url-source-code">
</div>
</div>
</div>


<div class="form-item">
<div class="form-metadata-item">
<h3 class="form-item-label">OCR</h3>
<div class="form-item-description">
<p>
<span class="monospace">OCR</span> is an optional field for recording whether the text was generated using OCR.  The possible answers are yes or no.
</p>
</div>
<div class="form-item-question">
Was the document generated with OCR?
<label>Yes</label><input type="radio" name="ocr" value="true">
<label>No</label><input type="radio" name="ocr" value="false">
</div>
</div>
</div>


<div class="form-item">
<div class="form-metadata-item">
<h3 class="form-item-label">Notes</h3>
<div class="form-item-description">
<p>
<span class="monospace">notes</span> is an option, free-form field for recording information about the item that the contributor deems important.
</p>
<p>Examples:</p>
<p class="form-item-example">
This set of images is missing fol. 54v, 55r, and 74r.<br>
Images of the manuscript from which this transcription was made are available at http://reader.digitale-sammlungen.de/de/fs1/object/display/bsb10181604_00005.html<br>
There is another edition of this text at http://ancientrome.ru/ius/library/gaius/gai.htm<br>
This edition retains the orthography of the medieval manuscript.
</p>
</div>
<div class="form-item-question">
<label>Notes:</label><textarea name="notes" rows="4" cols="50"></textarea>
</div>
</div>
<div class="form-poll-item">
<div class="form-item-question">
<label>Comments: </label><textarea name="comments-notes" rows="4" cols="50"></textarea>
</div>
</div>
</div>


<div class="form-item">
<div class="form-metadata-item">
<h3 class="form-item-label">File format</h3>
<div class="form-item-description">
<p>
<span class="monospace"></span>File Format is a required field for each item, so that we can implement full-text searching whenever possible.
</p>
<p>Examples:</p>
<p class="form-item-example">
.pdf files<br>
.xml files (TEI P5)<br>
.html files<br>
.jpg files<br>
</p>
</div>
<div class="form-item-question">
<label>File format:</label><input type="text" class="text-input" name="file-format">
</div>
</div>
</div>
<input type="hidden" name="submitted" value="true">
<div class="form-item">
	<div class="form-metadata-item">
		<span ><input type="submit" id="submit-form-button"></span>
	</div>
</div>


<div class="form-item">
	<div class="form-metadata-item">
	</div>
	<div class="form-poll-item">
	</div>
</div>


</form>

<?php else: ?>

<?php 
include 'rdf-generator.php';

$submission = [];
foreach ($_POST as $key => $item){
	echo '<span class="bold-text">'.$key.'</span> : '.$item.'<br>';
	$submission[$key] = $item;
}

$jsonString = json_encode($submission, JSON_PRETTY_PRINT);

echo '<pre>'.$jsonString.'</pre>';

$dbCon = mysqli_connect($database_host,$database_username,$database_password,$database_database);
if (!$dbCon) {
	die('Could not connect: ' . mysql_error());
}
$query = "INSERT INTO submissions (data,data_format,rdf_version,date_submitted,user) VALUES ('".mysqli_real_escape_string($dbCon,$jsonString)."','json','0.1',NOW(),'".$_SESSION['username']."');";

echo $query;

$rdf = generateRDF($submission);
echo '<pre>'.htmlspecialchars($rdf).'</pre>';
/*
if (mysqli_query($dbCon, $query)){
	echo 'Updated database';
}
else {
	echo "Error: " . $query . "<br>" . mysqli_error($dbCon);
}*/




?>
<div><a href="rdf-form.php">Submit a new form</a>
</div>
<?php endif;
include("footer.php");
?>
