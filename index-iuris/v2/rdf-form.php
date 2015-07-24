<?php
/**
 * @file rdf-form.php
 * Prints the Metdata Submission Form.
 */
$title = "Metadata Submission Form";
$loginRequired = true;
require "includes/header.php";
<<<<<<< Updated upstream
=======
?>
<?php if($_SESSION['logged-in']!=true): ?>
<div id="login-container">
<script type="text/javascript">
<!--
//window.location = "../index-iuris/v2/login.php"
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
<option selected></option>
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
<p>This field can appear multiple times.
</p>
</div>
<div class="form-item-question">
<div id="role_fields_wrap">
<div>
<label>Role:</label>
<select name="role[]">
<option selected></option>
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
</div>
</div>
<div><button type="button" id="add-role-button" >Add another role</button>
</div>
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
<div id="genre-fields-wrap">
<div>
<label>Genre:</label>
<select name="genre[]">
<option selected></option>
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
<div><button type="button" id="add-genre-button" >Add another genre</button>
</div>
</div>

</div>

<div class="form-poll-item">
<div class="form-item-question">
<p>Should this field be required or optional?</p>
<label>Required</label><input type="radio" name="genre-required-available" value="true">
<label>Optional</label><input type="radio" name="genre-required-available" value="false">
</div>
<div class="form-item-question">
<p>Should this field have controlled vocabulary, or be free-form?  Controlled vocabulary supports check-box searches for all indexed items of a particular genre (if you want to look only at imperial edicts); free-form allows a wider range of description. Note: we can split the difference, and have auto-suggestions as you type.</p>
<label>Controlled</label><input type="radio" name="genre-controled-available" value="true">
<label>Free-form</label><input type="radio" name="genre-controlled-available" value="false">
</div>
<div class="form-item-question">
<label>Please add terms here, separated by commas:</label><input type="text" class="text-input" name="suggested-terms-genre">
</div>
</div>
</div>


<div class="form-item">
<div class="form-metadata-item">
<h3 class="form-item-label">Date</h3><?php //TODO: discuss possibility of entering multiple dates?>
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
<div id="alt-title-fields-wrap">
<div>
<label>Alternative title:</label><input type="text" class="text-input" name="alternative-title[]">
</div>

</div>
<div><button type="button" id="add-alt-title-button">Add another alternative title</button>
</div>
>>>>>>> Stashed changes

if (!isset($_POST['submitted'])): ?>
<div class="container">
  <div class="row page-header">
    <div class="col-xs-12 text-justify">
      <p class="lead"><strong>Dear PI or Project Manager,</strong></p>
      <p>As we develop <span class="monospace">Index Iuris</span>, we seek to understand the needs and preferences of potential members of the federation.  We would be very grateful if you could take a little time to review this form, experiment with filling it out, and offer your views in the comment boxes provided.  In the end, membership in Index Iuris should not be a burden!</p>
      <p>Thanks so much!</p>
      <p>The Index Iuris team</p>

      <hr>

      <p>The following form, once finalized, will be the fundamental mechanism for integrating the content of member projects into the <span class="monospace">Index Iuris</span> portal to all projects.  The metadata supplied in this form makes possible effective searching, and meaningful display of search results.  Not all the information in this form will be required or displayed, but some of the fields are necessary if we are to conform to best practices and technical requirements.</p>
    </div>
  </div>

  <div class="row">
    <div class="col-xs-12">
      <form class="form-horizontal" action="rdf-form" method="POST">
        <fieldset>

          <legend>Custom Namespace</legend>
          <section class="form-group">
            <div class="col-xs-8 text-justify">
              <p>This field is required, and its format is predetermined for technical reasons. Custom namespace is a short code to identify the project. It is formatted as two pieces of text separated by a colon. The text before the colon identifies the main project or collection; the text after teh colon identifies the collection or subcollection.</p>
              <p>Examples:</p>
              <ul class="list-unstyled form-item-example">
                <li>CarolingianCanonLawProject:transcript</li>
                <li>AmesFoundation:book</li>
                <li>VirtualCanonLawLibrary:commentary</li>
                <li>VirtualCanonLawLibrary:book</li>
                <li>Pennington:consilia</li>
              </ul>

              <div class="form-group">
                <label for="customNamespace" class="control-label col-xs-2">Namespace</label>
                <div class="col-xs-10">
                  <input type="text" class="form-control" name="custom-namespace" id="customNamespace" required="">
                </div>
              </div>
            </div>

            <div class="col-xs-4">
              <label class="control-label col-xs-6">Would you be able to decide what goes after the column?</label>
              <div class="col-xs-6">
                <div class="radio">
                  <label>
                    <input type="radio" name="custom-namespace-available" value="true">Yes
                  </label>
                </div>
                <div class="radio">
                  <label>
                    <input type="radio" name="custom-namespace-available" value="false">No
                  </label>
                </div>
              </div>
            </div>
          </section>

          <legend>rdf:about</legend>
          <section class="form-group">
            <div class="col-xs-8 text-justify">
              <p><samp>rdf:about</samp> is a required attribute of <samp>custom namespace</samp>, and its format is predetermined for technical reasons. <samp>rdf:about</samp> is a URI or a URL that uniquely identifies the record to be index.</p>
              <p>Examples:</p>
              <ul class="list-unstyled form-item-example">
                <li>&lt;pennington:medieval_legal_texts rdf:about="http://faculty.cua.edu/pennington/edit301.html"&gt;</li>
                <li>&lt;CCL:manuscripts rdf:about="http://ccl.rch.uky.edu/aboutBod718"&gt;</li>
              </ul>

              <div class="form-group">
                <label for="rdfAbout" class="control-label col-xs-2">rdf:about</label>
                <div class="col-xs-10">
                  <input type="text" class="form-control" name="rdf-about" id="rdfAbout" required="">
                </div>
              </div>
            </div>

            <div class="col-xs-4">
              <label for="rdfComments" class="control-label col-xs-3">Comments:</label>
              <div class="col-xs-12">
                <textarea class="form-control" name="comments-rdf-about" rows="4"></textarea>
              </div>
            </div>
          </section>

          <legend>Archive</legend>
          <section class="form-group">
            <div class="col-xs-8 text-justify">
              <p><samp>Archive</samp> is required. It should be a clear, short version of the name or identity of the member project. It must be a single word or a string of characters, with no spaces.</p>
              <p>Examples:</p>
              <ul class="list-unstyled form-item-example">
                <li>AMES (for Ames Foundation, Harvard Law School project)</li>
                <li>CCL (for the Carolingian Canon Law Project)</li>
                <li>VirtualCanonLawLibrary (for the Virtual Library of Medieval Canon Law at Colby)</li>
                <li>PENNINGTON (for Kenneth Pennington's website)</li>
              </ul>

              <div class="form-group">
                <label for="archive" class="control-label col-xs-2">Archive</label>
                <div class="col-xs-10">
                  <input type="text" class="form-control" name="archive" id="archive" required="">
                </div>
              </div>
            </div>
          </section>

          <legend>Title</legend>
          <section class="form-group">
            <div class="col-xs-8 text-justify">
              <p><samp>Title</samp> is required. Each item to be integrated in Index Iuris must have a title. It is expected that some titles will occur more than once (several items may have the title "Summa"), however, each item can have only one title (you cannot give both "Corpus iuris civilis" and "Digest" as the title for the same item.)</p>
              <p>Examples:</p>
              <ul class="list-unstyled form-item-example">
                <li>Collectio Dacheriana</li>
                <li>Consilia</li>
                <li>De Legibus et Consuetudinibus Angliae</li>
                <li>Summa "Animal est substantia"</li>
              </ul>

              <div class="form-group">
                <label for="title" class="control-label col-xs-2">Title</label>
                <div class="col-xs-10">
                  <input type="text" class="form-control" name="title" id="title" required="">
                </div>
              </div>
            </div>
          </section>

          <legend>Type</legend>
          <section class="form-group">
            <div class="col-xs-8 text-justify">
              <p><samp>Type</samp> is required. It describes the type of medium or artifact of the the item to be integrated into Index Iuris. This term will be selected from a pre-determined list (controlled vocabulary).</p>

              <div class="form-group">
                <label for="type" class="control-label col-xs-2">Type</label>
                <div class="col-xs-10">
                  <select class="form-control" id="type" name="type" required="">
                    <option selected=""></option>
                    <?php foreach (array("Critical edition", "Digital image", "Drawing", "Facsimile", "Fragment", "Illustration", "Interactive Resource", "Manuscript Codex", "Map", "Microfilm", "Image (b/w)", "Online images (for manuscripts online)", "Online transcription of printed book (html, XML)", "Physical Object [such as a stone tablet, monumental arch, seal]", "Printed book", "Roll", "Scanned image of printed book (pdf)", "Sheet", "Typescript") as $type): ?>
                      <option><?php print $type; ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
              </div>
            </div>

            <div class="col-xs-4">
              <div class="form-group">
                <label class="control-label col-xs-10">Would you be able to use the terms in the dropdown to complete the form for the items in your project that you would integrated into Index Iuris? If not, please identify additional terms that should be added to this list.</label>
                <div class="col-xs-2">
                  <div class="radio">
                    <label><input type="radio" name="type-available" value="true">Yes</label>
                  </div>
                  <div class="radio">
                    <label><input type="radio" name="type-available" value="false">No</label>
                  </div>
                </div>
              </div>

              <div class="form-group">
                <label for="suggestedTypeTerms" class="control-label col-xs-12">Please add terms here, separated by commas:</label>
                <div class="col-xs-12">
                  <input type="text" class="form-control" name="suggested-terms-type" id="suggestedTypeTerms">
                </div>
              </div>
            </div>
          </section>

          <legend>Role</legend>
          <section class="form-group">
            <div class="col-xs-8 text-justify">
              <p><samp>Role</samp> is an optional field, however if used, the terms will be selected from a per-determined list (controlled vocabulary).</p>
              <p>This field can appear multiple times.</p>

              <div class="form-group">
                <label for="role" class="control-label col-xs-2"><button type="button" class="close hide pull-left">x</button>Role</label>
                <div class="col-xs-10">
                  <select class="form-control" id="role" name="role[]">
                    <option selected=""></option>
                    <?php foreach (array("Author", "Editor", "Publisher", "Translator", "Creator", "Etcher", "Engraver", "Owner", "Artist", "Architect", "Binder", "Book designer", "Book producer", "Calligrapher", "Cartographer", "Collector", "Colorist", "Commentator for written text", "Compiler", "Compositor", "Creator", "Dubious author", "Facsimilist", "Illuminator", "Illustrator", "Lithographer", "Printer", "Printer of plates", "Printmaker", "Repository", "Rubricator", "Scribe", "Sculptor", "Type designer", "Typographer", "Visual Artist", "Wood engraver", "Wood cutter") as $role): ?>
                      <option><?php print $role; ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
              </div>

              <div class="form-group">
                <label for="value" class="control-label col-xs-2">Value</label>
                <div class="col-xs-10">
                  <input type="text" class="form-control" id="value" name="role-value[]">
                </div>
              </div>

              <div class="form-group">
                <div class="col-xs-3 pull-right">
                  <button type="button" class="btn btn-default col-xs-12" id="addRoleButton">Add Another Role</button>
                </div>
              </div>
            </div>
            <div class="col-xs-4">
              <div class="form-group">
                <label class="control-label col-xs-10">Would you be able to use these terms to complete the form for the items in your project that you would want integrated into Index Iuris? If not, please identify additional terms that should be added to this list.</label>
                <div class="col-xs-2">
                  <div class="radio">
                    <label><input type="radio" name="role-available" value="true">Yes</label>
                  </div>
                  <div class="radio">
                    <label><input type="radio" name="role-available" value="false">No</label>
                  </div>
                </div>
              </div>

              <div class="form-group">
                <label for="suggestedRoleTerms" class="control-label col-xs-12">Please add terms here, separated by commas:</label>
                <div class="col-xs-12">
                  <input type="text" class="form-control" name="suggested-terms-role" id="suggestedRoleTerms">
                </div>
              </div>
            </div>
          </section>

          <legend>Genre</legend>
          <section class="form-group">
            <div class="col-xs-8 text-justify">
              <p><samp>Genre</samp> differs from "type" in that it describes the textual form, rather than the physical medium or artifact.</p>

              <div class="form-group">
                <label for="genre" class="control-label col-xs-2"><button type="button" class="close hide pull-left">x</button>Genre</label>
                <div class="col-xs-10">
                  <select class="form-control" id="genre" name="genre[]">
                    <option selected=""></option>
                    <?php foreach (array("Account", "Accusation", "Aide", "Amercement", "Appeal", "Assize", "Benefice", "Brief", "Canon", "Casus", "Causa", "Census", "Certificate", "Challenge", "Charge", "Code of laws", "Collection", "Commentary", "Consilium", "Consistory", "Contract", "Corpus", "Council", "Covenant", "Damages", "Defense", "Decretal", "Deposition", "Dicta", "Dispensation", "Distinction", "Edict", "Enfeoffement", "Evidence", "Formula", "Gloss", "Handbook", "Immunity", "Imperial constitution", "Inquest", "Inquisition", "Investigation", "Judgment", "Manumission", "Narrative", "Oath", "Opinion", "Petition", "Plea", "Prescription", "Privilege", "Process", "Proof", "Receipt", "Regulation", "Rescript", "Response", "Statute", "Summa", "Summation", "Synod", "Testament", "Testimony", "Treatise", "Trial", "Textbook", "Verdict", "Voucher", "Will", "Writ") as $genre): ?>
                      <option><?php print $genre; ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
              </div>

              <div class="form-group">
                <div class="col-xs-3 pull-right">
                  <button type="button" class="btn btn-default col-xs-12" id="addGenreButton">Add Another Genre</button>
                </div>
              </div>
            </div>
            <div class="col-xs-4">
              <div class="form-group">
                <label class="control-label col-xs-8">Should this field be required or optional?</label>
                <div class="col-xs-4">
                  <div class="radio">
                    <label><input type="radio" name="genre-required" value="true">Required</label>
                  </div>
                  <div class="radio">
                    <label><input type="radio" name="genre-required" value="false">Optional</label>
                  </div>
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-xs-8">Should this field have controlled vocabulary, or be free-form?</label>
                <div class="col-xs-4" data-toggle="tooltip" data-placement="top" title="Controlled vocabulary supports check-box searches for all index items of a particular genre (if you want to look only at imperial edicts); free-form allows a wider range of description. Note: we can split the difference, and have auto-suggestions as you type.">
                  <div class="radio">
                    <label><input type="radio" name="genre-controlled" value="true">Controlled</label>
                  </div>
                  <div class="radio">
                    <label><input type="radio" name="genre-controlled" value="false">Free-form</label>
                  </div>
                </div>
              </div>

              <div class="form-group">
                <label for="suggestedGenreTerms" class="control-label col-xs-12">Please add terms here, separated by commas:</label>
                <div class="col-xs-12">
                  <input type="text" class="form-control" name="suggested-terms-genre" id="suggestedGenreTerms">
                </div>
              </div>
            </div>
          </section>

          <?php // TODO: Discuss possibility of entering multiple dates. ?>
          <legend>Date</legend>
          <section class="form-group">
            <div class="col-xs-8 text-justify">
              <p><samp>Date</samp> refers to the date of original composition, to the extent that it is know. This field is required. Index Iuris will use both human readable expressions in its displays, and also machine readable formats to facilitate searching by date range.</p>

              <p>Human-readable dates example:</p>
              <ul class="list-unstyled form-item-example">
                <?php foreach (array("14th century", "not before 1475", "saec. IXin-med", "0850; 1122", "c. 1100", "1300-1350", "1st part of manuscript 9th century; 2nd part early 12th century") as $date): ?>
                  <li><?php print $date; ?></li>
                <?php endforeach; ?>
              </ul>
              <div class="form-group">
                <label for="humanDate" class="control-label col-xs-2">Human Date</label>
                <div class="col-xs-10" style="margin-bottom: 20px;">
                  <input type="text" class="form-control" name="date-human" id="humanDate" required="">
                </div>
              </div>

              <p>Machine-readable dates example:</p>
              <ul class="list-unstyled form-item-example">
                <?php foreach (array("four-digital year, e.g. \"1425\" or \"0850\"", "two four-digit years, separated by a hyphen, indicating a span of time e.g. \"1425-1450\". The conventions for \"beginning, middle, third-quarter, end, etc.\" of centuries are converted to 25 year increments: 0800, 0825, 0850, 0875", "two four-digit year separated by a semi-colon indicate that the text or object was composed or created at two dates. Both should be searchable.") as $date): ?>
                  <li><?php print $date; ?></li>
                <?php endforeach; ?>
              </ul>
              <div class="form-group">
                <label for="machineDate" class="control-label col-xs-2">Machine Date</label>
                <div class="col-xs-10">
                  <input type="text" class="form-control" name="date-machine" id="machineDate" required="">
                </div>
              </div>
            </div>

            <div class="col-xs-4">
              <div class="form-group">
                <label class="control-label col-xs-10">Would you be able to complete this field for items in your project to be integrated in Index Iuris, following these models?</label>
                <div class="col-xs-2">
                  <div class="radio">
                    <label><input type="radio" name="date-available" value="true">Yes</label>
                  </div>
                  <div class="radio">
                    <label><input type="radio" name="date-available" value="false">No</label>
                  </div>
                </div>
              </div>

              <div class="form-group">
                <label for="dateComments" class="control-label col-xs-3">Comments:</label>
                <div class="col-xs-12">
                  <textarea class="form-control" name="comments-date" id="dateComments" rows="4"></textarea>
                </div>
              </div>
            </div>
          </section>

          <legend>Link to Digital Items</legend>
          <section class="form-group">
            <div class="col-xs-8 text-justify">
              <p>This required field is completed with a URI or URL that is the address for the specific item to be displayed, such as a manuscript image, a page of a transcription, or a document.</p>
              <p>Examples:</p>
              <ul class="list-unstyled form-item-example">
                <li>http://pds.lib.harvard.edu/pds/view/14856910?n=3384</li>
                <li>http://ccl.rch.uky.edu/node/1419</li>
                <li>http://ccl.rch.uky.edu/node/3908</li>
                <li>http://faculty.cua.edu/Pennington/edit323.htm</li>
              </ul>

              <div class="form-group">
                <label for="seeAlso" class="control-label col-xs-2">URL</label>
                <div class="col-xs-10">
                  <input type="text" class="form-control" name="seeAlso" id="seeAlso" required="">
                </div>
              </div>
            </div>

            <div class="col-xs-4">
              <label class="control-label col-xs-10">Would you be able to supply a URI or URL for each item to be integrated into Index Iuris?</label>
              <div class="col-xs-2">
                <div class="radio">
                  <label><input type="radio" name="url-available" value="true">Yes</label>
                </div>
                <div class="radio">
                  <label><input type="radio" name="url-available" value="false">No</label>
                </div>
              </div>
            </div>
          </section>

          <legend>Provenance</legend>
          <section class="form-group">
            <div class="col-xs-8 text-justify">
              <p><samp>Provenance</samp> is actually two fields, both optional (although we recommend completing at least one).</p>
              <p>The first field is <samp>origin</samp>, which can be used for the place where a manuscript written, or a work published. The second field is <samp>provenance</samp>, which can be used for ownership information, or likely area of use or circulation, or the earliest known information about an items whereabouts. Note: See below for <samp>place of composition</samp>.</p>
              <p>Examples:</p>
              <ul class="list-unstyled form-item-example">
                <li>Origin: Bologna</li><?php // Today I learned that Bologna is a providence in Italy... ?>
                <li>Origin: Northeast France</li>
                <li>Provenance: St. Gall</li>
                <li>Provenance: Durham Cathedral Priory (suppressed 1540); Thomas Allen (d. 1632); George Henry Lee, 3rd Earl of Lichfield (d. 1772); Reverend Thomas Phillips, S.J. (d. 1774); Stonyhurst College; British Library</li>
              </ul>
              <p>If there is nothing in the <samp>origin</samp> field, the <samp>provenance</samp> information is displayed in the basic metadata; if there is information in the <samp>origin</samp> field, that is what is displayed in the basic metadata.</p>

              <div class="form-group">
                <label for="origin" class="control-label col-xs-2">Origin</label>
                <div class="col-xs-10">
                  <input type="text" class="form-control" name="origin" id="origin">
                </div>
              </div>

              <div class="form-group">
                <label for="provenance" class="control-label col-xs-2">Provenance</label>
                <div class="col-xs-10">
                  <input type="text" class="form-control" name="provenance" id="provenance">
                </div>
              </div>
            </div>

            <div class="col-xs-4">
              <label for="provenanceComments" class="control-label col-xs-3">Comments:</label>
              <div class="col-xs-12">
                <textarea class="form-control" name="comments-provenance" id="provenanceComments" rows="4"></textarea>
              </div>
            </div>
          </section>

          <legend>Place of composition</legend>
          <section class="form-group">
            <div class="col-xs-8 text-justify">
              <p><samp>Place of composition</samp> is used for the place where a text was composed, if known. This field is optional.</p>
              <p>Examples:</p>
              <ul class="list-unstyled form-item-example">
                <li>place of composition: Rome</li>
                <li>place of composition: University of Paris</li>
              </ul>

              <div class="form-group">
                <label for="placeComposition" class="control-label col-xs-2">Composition</label>
                <div class="col-xs-10">
                  <input type="text" class="form-control" name="place-of-composition" id="placeComposition">
                </div>
              </div>
            </div>

            <div class="col-xs-4">
              <label for="compositionComments" class="control-label col-xs-3">Comments:</label>
              <div class="col-xs-12">
                <textarea class="form-control" name="comments-place-of-composition" rows="4"></textarea>
              </div>
            </div>
          </section>


          <legend>Shelfmark</legend>
          <section class="form-group">
            <div class="col-xs-8 text-justify">
              <p><samp>Shelfmark</samp> is required for items that are manuscripts. This is the unique, internationally known identifier for a manuscript. Consists of City, Repository (library), fond (internal library collection), number. For incunabula or other rare printings, this field may be used for library identifications of the physical artefcat, as well. This field is optional for all other publications or editions.</p>
              <p>Examples:</p>
              <ul class="list-unstyled form-item-example">
                <?php foreach (array("Admont en Styrie, Bibliothèque du monastère, 162", "Berlin, Staatsbibliothek Preussischer Kulturbesitz, Lat. fol. 626", "Vaticano, Città del, Biblioteca Apostolica Vaticana, Ottobon. lat. 3295", "Würzburg, Universitätsbibliothek, M.p.th.f.72", "Lexington, University of Kentucky, Margaret I. King Library, Special Collections, KBR197.6 .C36 1525") as $example): ?>
                  <li><?php print $example; ?></li>
                <?php endforeach; ?>
              </ul>

              <div class="form-group">
                <label for="shelfmark" class="control-label col-xs-2">Shelfmark</label>
                <div class="col-xs-10">
                  <input type="text" class="form-control" name="shelfmark" id="shelfmark">
                </div>
              </div>
            </div>
          </section>

          <?php /*
          <section class="form-group">
            <div class="form-metadata-item">
              <h3>freeculture?</h3>
            </div>
          </section>

          <section class="form-group">
            <div class="form-metadata-item">
              <h3>Full text goes here</h3>
            </div>
          </section>

          <section class="form-group">
            <div class="form-metadata-item">
              <h3>Image goes here</h3>
            </div>
          </section>
          */ ?>

          <legend>Alternative title</legend>
          <section class="form-group">
            <div class="col-xs-8 text-justify">
              <p><samp>Alternative title</samp> is an optional field that can be used for common, "pet" names of a text or manuscript. The final form will include the option to submit more than one <samp>alternative title</samp>.</p>
              <p>Examples:</p>
              <ul class="list-unstyled form-item-example">
                <li>"The Florence Codex"</li>
                <li>"X"</li>
                <li>"Concordia Discordantium Canonum"</li>
              </ul>

              <div class="form-group">
                <label for="altTitle" class="control-label col-xs-2"><button type="button" class="close hide pull-left">x</button>Alt Title</label>
                <div class="col-xs-10">
                  <input type="text" class="form-control" name="alternative-title[]" id="altTitle">
                </div>
              </div>

              <div class="form-group">
                <div class="col-xs-4 pull-right">
                  <button type="button" class="btn btn-default col-xs-12" id="addAltTitleButton">Add Another Alternative Title</button>
                </div>
              </div>
            </div>
          </section>

          <legend>Source</legend>
          <section class="form-group">
            <div class="col-xs-8 text-justify">
              <p>This field should not be confused with provenance, place of origin of object, place of composition or isPartOf. <samp>Source</samp> is used for the title of the larger work, resource, or collection of which the present object is a part. Can be used for the title of a journal, anthology, book, online collection, etc.</p>
              <p>Examples:</p>
              <ul class="list-unstyled form-item-example">
                <li>The Spoils of the Pope and the Pirates, 1357: the complete legal dossier form the Vatican Archives</li>
                <li>The Common and Piepowder Courts of Southampton, 1426-1483</li>
                <li>CEEC: Codices Electronici Ecclesiae Coloniensis</li>
              </ul>

              <div class="form-group">
                <label for="source" class="control-label col-xs-2">Source</label>
                <div class="col-xs-10">
                  <input type="text" class="form-control" name="source" id="source">
                </div>
              </div>
            </div>
          </section>

          <legend>Is part of</legend>
          <section class="form-group">
            <div class="col-xs-8 text-justify">
              <p><samp>IsPartOf</samp> is a useful field for legal texts, which often are compilations of many texts. This field is optional.</p>
              <?php /*
              <p>Examples:</p>
              <ul class="list-unstyled form-item-example">
                <li>For the Bulla “Rex Pacificus”, one could have <strong>IsPartOf</strong> Liber extravagantium decretalium</li>
                <li>For a particular transcription of the Council of Arles, on could have <strong>IsPartOf</strong> Collectio Hispana</li>
                <li>For a particular Novel of Justinian, one could have <strong>IsPartOf</strong> Corpus iuris civilis</li>
              </ul>
              */ ?>

              <div class="form-group">
                <label for="isPartOf" class="control-label col-xs-2">Is part of</label>
                <div class="col-xs-10">
                  <input type="text" class="form-control col-xs-10" name="is-part-of[]" id="isPartOf">
                </div>
              </div>
            </div>

            <div class="col-xs-4">
              <label for="isPartOfComments" class="control-label col-xs-3">Comments:</label>
              <div class="col-xs-12">
                <textarea class="form-control" name="comments-is-part-of" id="isPartOfComments" rows="4"></textarea>
              </div>
            </div>
          </section>

          <legend>Has part</legend>
          <section class="form-group">
            <div class="col-xs-8 text-justify">
              <p><samp>hasPart</samp> is the obverse of <samp>isPartOf</samp>. This field is optional. For texts that contain many other texts, this field can be used to list one or more items included in the larger work.</p>
              <?php /*
              <p>Examples:</p>
              <ul class="list-unstyled form-item-example">
                <li>Collectio Dacheriana <strong>HasPart</strong> Book I, Book II, Book III</li>
                <li>Collectio Dionysiana <strong>HasPart</strong> Canones Apostolorum, Conc. Nicea, Conc. Ancyra, Conc. Neocaesarea, Conc. Constantinople, Conc. Gangra, Conc. Sardica, etc.</li>
              </ul>
              */ ?>

              <div class="form-group">
                <label for="hasPart" class="control-label col-xs-2"><button type="button" class="close hide pull-left">x</button>Has Part</label>
                <div class="col-xs-10">
                  <input type="text" class="form-control" name="has-part[]" id="hasPart">
                </div>
              </div>

              <div class="form-group">
                <div class="col-xs-3 pull-right">
                  <button type="button" class="btn btn-default col-xs-12" id="addHasPartButton">Add Another Part</button>
                </div>
              </div>
            </div>
            <div class="col-xs-4">
              <label for="hasPartComments" class="control-label col-xs-3">Comments</label>
              <div class="col-xs-12">
                <textarea class="form-control" name="comments-has-part" id="hasPartComments" rows="4"></textarea>
              </div>
            </div>
          </section>

          <legend>Divisions of the text</legend>
          <section class="form-group">
            <div class="col-xs-8 text-justify">
              <p>Divisions of the text is an optional field that is purely for information (that is, it does not affect digital display or processing). Here it is possible to give useful descriptions of how a compilation is structured, organized, or divided.</p>
              <p>Examples:</p>
              <ul class="list-unstyled form-item-example">
                <li>The Collection in 74 Titles is divided into “titles”, each of which is divided into “canons”</li>
                <li>The Dionysiana is divided into councils, each of which is preceded by a tabula titulorum and followed by a subscription list.  The body of the conciliar text is divided into canons.</li>
                <li>The Decretum is divided into three parts.  The first part has 101 distinctiones; the second part has 36 causae, the third part, entitled “De consecration” contains 5 distinctiones.  Each causa is divided into quaestiones… etc.</li>
              </ul>

              <div class="form-group">
                <label for="textDivisions" class="control-label col-xs-2">Divisions</label>
                <div class="col-xs-10">
                  <textarea class="form-control" name="text-divisions" id="textDivisions" rows="4"></textarea>
                </div>
              </div>
            </div>
            <div class="col-xs-4">
              <label for="textDivisionsComments" class="control-label col-xs-3">Comments:</label>
              <div class="col-xs-12">
                <textarea class="form-control" name="comments-text-divisions" id="textDivisionsComments" rows="4"></textarea>
              </div>
            </div>
          </section>

          <legend>Language</legend>
          <section class="form-group">
            <div class="col-xs-8 text-justify">
              <p><samp>Language</samp> identifies the language of the object using language codes from the <a href="https://www.loc.gov/standards/iso639-2/php/code_list.php" target="_blank">ISO 639-2 Language Code List</a>.</p>

              <div class="form-group">
                <label for="language" class="control-label col-xs-2">Language</label>
                <div class="col-xs-10">
                  <input type="text" class="form-control" name="language" id="language">
                </div>
              </div>
            </div>
          </section>

          <legend>Metadata source code</legend>
          <section class="form-group">
            <div class="col-xs-8 text-justify">
              <p><samp>Metadata source code</samp> is an optional field. If your project has metadata that does not duplicate the descriptions in the fields above that should be included in Index Iuris, you may use this field for the URL or URI for the web-accessible XML or HTML metadata.</p>

              <div class="form-group">
                <label for="metadataSourceCode" class="control-label col-xs-2">URL</label>
                <div class="col-xs-10">
                  <input type="text" class="form-control" name="url-source-code" id="metadataSourceCode">
                </div>
              </div>
            </div>
          </section>

          <legend>OCR</legend>
          <section class="form-group">
            <div class="col-xs-8 text-justify">
              <p><samp>OCR</samp> is an optional field for recording whether the text was generated using OCR. The possible answers are yes or no.</p>

              <div class="form-group">
                <label class="control-label col-xs-5">Was this document generated with OCR?</label>
                <div class="col-xs-2">
                  <div class="radio">
                    <label><input type="radio" name="ocr" value="true">Yes</label>
                  </div>
                  <div class="radio">
                    <label><input type="radio" name="ocr" value="false">No</label>
                  </div>
                </div>
              </div>
            </div>
          </section>

          <legend>Notes</legend>
          <section class="form-group">
            <div class="col-xs-8">
              <p><samp>Notes</samp> is an option, free-form field for recording information about the item that the contributor deems important.</p>
              <p>Examples:</p>
              <ul class="list-unstyled form-item-example">
                <li>This set of images is missing fol. 54v, 55r, and 74r.</li>
                <li>Images of the manuscript from which this transcription was made are available at http://reader.digitale-sammlungen.de/de/fs1/object/display/bsb10181604_00005.html</li>
                <li>There is another edition of this text at http://ancientrome.ru/ius/library/gaius/gai.htm</li>
                <li>This edition retains the orthography of the medieval manuscript.</li>
              </ul>

              <div class="form-group">
                <label for="notes" class="control-label col-xs-2">Notes</label>
                <div class="col-xs-10">
                  <textarea class="form-control" name="notes" id="notes" rows="4"></textarea>
                </div>
              </div>
            </div>
            <div class="col-xs-4">
              <label for="noteComments" class="control-label col-xs-3">Comments:</label>
              <div class="col-xs-12">
                <textarea class="form-control" name="comments-notes" id="noteComments" rows="4"></textarea>
              </div>
            </div>
          </section>

          <legend>File format</legend>
          <section class="form-group">
            <div class="col-xs-8 text-justify">
              <p>File Format is a required field for each item, so that we can implement full-text searching whenever possible.</p>
              <p>Examples:</p>
              <ul class="list-unstyled form-item-example">
                <?php foreach (array(".pdf files", ".xml files (TEI P5)", ".html files", ".jpg files") as $example): ?>
                  <li><?php print $example; ?></li>
                <?php endforeach; ?>
              </ul>

              <div class="form-group">
                <label for="fileFormat" class="control-label col-xs-2">Format</label>
                <div class="col-xs-10">
                  <input type="text" class="form-control" name="file-format" id="fileFormat" required="">
                </div>
              </div>
            </div>
          </section>

          <input type="hidden" class="hide" name="submitted" value="true">

          <section class="form-group" style="margin-top: 5%; margin-bottom: 15%;">
            <div class="col-xs-3 pull-left">
              <button type="submit" class="btn btn-success col-xs-12">Submit</button>
            </div>
          </section>

          <section class="form-group">
            <div class="form-metadata-item"></div>
            <div class="form-poll-item"></div>
          </section>

        </fieldset>
      </form>

    </div>
  </div>
</div>
<?php
else:
  include "includes/rdf-generator.php";

  $mysqli  = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_BASE);
  $json    = json_encode($_POST, JSON_PRETTY_PRINT); //removed escape function to save plain json in db
  $userID  = $_SESSION['user_id'];
  $format  = "json";
  $version = "0.1";

  print "<h3>Submitted:</h3><pre>" . print_r($_POST, true) . "</pre>";
  print "<h3>Being Stored:</h3><pre>" . print_r($json, true) . "</pre>";

  if ($mysqli->connect_error) {
    exit("<h2 class='text-danger'>Database connection error. (" . $mysqli->connect_errno . ")</h2>");
  }

  $statement = $mysqli->prepare("SELECT id FROM objects WHERE url = ?");
  $statement->bind_param("s", $_POST['seeAlso']);
  $statement->execute();
  $statement->store_result();
  $statement->bind_result($id);
  
  if ($statement->num_rows > 0) {
  	//TODO: record already exists - redirect user to view submissions page
  	echo "record already exists";
  }
  
  
  //store in metadata tables
  $query = "INSERT INTO objects (
      		custom_namespace,
rdf_about,
archive,
title,
type,
url,
origin,
provenance,
place_of_composition,
shelfmark,
freeculture,
full_text_url,
full_text_plain,
is_full_text,
image_url,
source,
metadata_xml_url,
metadata_html_url,
text_divisions,
language,
ocr,
thumbnail_url,
notes,
file_format,
date_created,
date_updated,
user_id)
      		VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,NOW(),NOW(),?)";
  $statement = $mysqli->prepare($query);
  $custom_namespace = $_POST['custom-namespace'];
$rdf_about = $_POST['rdf-about']; 
$archive = $_POST['archive'];
$title = $_POST['title'];
$type = $_POST['type'];
$url = $_POST['seeAlso'];
$origin = $_POST['origin'];
$provenance = $_POST['provenance'];
$place_of_composition = $_POST['place-of-composition'];
$shelfmark = $_POST['shelfmark'];
$freeculture = 'true'; //TODO add this field to form, pending approval from Colin and Abigail
$full_text_url = '';//TODO add this field to form, pending approval from Colin and Abigail
$full_text_plain = '';//TODO add this field to form, pending approval from Colin and Abigail
$is_full_text = '';//TODO add this field to form, pending approval from Colin and Abigail
$image_url = '';//TODO add this field to form, pending approval from Colin and Abigail
$source = $_POST['source'];
$metadata_xml_url = $_POST['url-source-code']; //TODO: determine format from input and add to appropriate variable
$metadata_html_url = $_POST['url-source-code'];
$text_divisions = $_POST['text-divisions'];
$language = $_POST['language'];
$ocr = $_POST['ocr'];
$thumbnail_url = '';//TODO add this field to form, pending approval from Colin and Abigail
$notes = $_POST['notes'];
$file_format = $_POST['file-format'];
  
  $statement->bind_param("sssssssssssssssssssssssss", 
  		$custom_namespace,
  		$rdf_about,
  		$archive,
  		$title,
  		$type,
  		$url,
  		$origin,
  		$provenance,
  		$place_of_composition,
  		$shelfmark,
  		$freeculture,
  		$full_text_url,
  		$full_text_plain,
  		$is_full_text,
  		$image_url,
  		$source,
  		$metadata_xml_url,
  		$metadata_html_url,
  		$text_divisions,
  		$language,
  		$ocr,
  		$thumbnail_url,
  		$notes,
  		$file_format,
  		$userID
  		);
  $statement->execute();
  
  $last_id = $mysqli->insert_id;
  
  //loop through and add alternative titles to table
  $alt_titles = $_POST['alternative-title'];
  foreach ($alt_titles as $alt_title){
  	$statement = $mysqli->prepare("INSERT INTO alt_titles (object_id,alt_title) VALUES (?,?)");
  	$statement->bind_param("is",$last_id,$alt_title);
  	$statement->execute();
  }
  
  //loop through and add genres to table
  $genres = $_POST['genre'];
  foreach ($genres as $genre){
  	$statement = $mysqli->prepare("INSERT INTO genres (object_id,genre) VALUES (?,?)");
  	$statement->bind_param("is",$last_id,$genre);
  	$statement->execute();
  }

  //add date to table
  $statement = $mysqli->prepare("INSERT INTO dates (object_id,type,machine_date,human_date) VALUES (?,?,?,?)");
  $machine_date = $_POST['date-machine'];
  $human_date = $_POST['date-human'];
  $date_type = 'text';
  $statement->bind_param("isss",$last_id,$date_type,$machine_date,$human_date);
  $statement->execute();
  
  //loop through and add isPart to table
  $isPartOf_parts = $_POST['is-part-of'];
  $part_type = 'isPartOf';
  foreach ($isPartOf_parts as $part_id){
  	$statement = $mysqli->prepare("INSERT INTO parts (object_id,type,part_id) VALUES (?,?,?)");
  	$statement->bind_param("isi",$last_id,$part_type,$part_id);
  	$statement->execute();
  }
  
  //loop through and add isPart to table
  $hasPart_parts = $_POST['has-part'];
  $part_type = 'hasPart';
  foreach ($hasPart_parts as $part_id){
  	$statement = $mysqli->prepare("INSERT INTO parts (object_id,type,part_id) VALUES (?,?,?)");
  	$statement->bind_param("isi",$last_id,$part_type,$part_id);
  	$statement->execute();
  }
  

  //TODO: role, subject, discipline

  
  
  $statement = $mysqli->prepare("INSERT INTO submissions (data, data_format, rdf_version, date_submitted, user_id) VALUES (?,?,?,NOW(),?)");
  $statement->bind_param("ssss", $json, $format, $version, $userID);
  $statement->execute();
  $statement->store_result();

  if ($statement->affected_rows === 0): ?>
  <div class="container">
    <div class="row page-header">
      <h1 class="text-danger text-center">Form Submission Failed</h1>
    </div>

    <div class="row">
      <div class="col-xs-12">
        <p>This isn't good. INSERT shouldn't fail.</p>
        <p>Unless the server is down. No, that can't be it, you're reading this.</p>
        <p>Maybe the MySQL Database is disconnected. No, that can't be it either, we'd get a database connection error earlier...</p>
      </div>
    </div>
  </div>
  <?php else: ?>
  <div class="container">
    <div class="row page-header">
      <div class="col-xs-12">
        <h1 class="text-center">Form Submitted Successfully!</h1>
      </div>
    </div>

    <div class="row">
      <div class="col-xs-3 center-block">
        <a href="rdf-form" class="btn btn-primary col-xs-8 center-block">Submit a New Form</a>
        <?php //TODO: add a link to view-submissions page ?>
      </div>
    </div>
  </div>
<<<<<<< Updated upstream
  <?php
  endif;
endif;
=======
</section>

</fieldset>
</form>

<?php else: ?>

<<<<<<< Updated upstream
  <?php
  include 'includes/rdf-generator.php';

  $submission = [];
  foreach ($_POST as $key => $item){
   $submission[$key] = $item;
 }

 $jsonString = json_encode($submission, JSON_PRETTY_PRINT);

 echo '<pre>'.$jsonString.'</pre>';
=======
<?php 
include 'includes/rdf-generator.php';
$comments = [];
$submission = [];
foreach ($_POST as $key => $item){
	if(preg_match("/^comments/", $key) || preg_match("/^suggested/", $key) || preg_match("/available$/", $key)){
			$comments[$key]=$item;
		}else{ 
			$submission[$key] = $item;
		}
}

$jsonString = json_encode($submission, JSON_PRETTY_PRINT);
$jsonString_comments = json_encode($comments, JSON_PRETTY_PRINT);

echo '<pre>'.$jsonString.'</pre>';
echo '<pre>'.$jsonString_comments.'</pre>';
>>>>>>> Stashed changes

 $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_BASE);

 if ($mysqli->connect_error) {
   exit("<h2 class='text-danger'>Database connection error. (" . $mysqli->connect_errno . ")</h2>");
 }

<<<<<<< Updated upstream
 $statement = $mysqli->prepare("INSERT INTO submissions (data,data_format,rdf_version,date_submitted,user_id) VALUES (?,?,?,NOW(),?)");
 $data_format = 'json';
 $rdf_version = '0.1';
 $user_id = $_SESSION['user_id'];
 $escaped_json = "'".$mysqli->real_escape_string($jsonString)."'";
 $statement->bind_param("ssss", $escaped_json,$data_format,$rdf_version,$user_id);
 $statement->execute();
=======
$statement = $mysqli->prepare("INSERT INTO submissions (data,data_format,rdf_version,date_submitted,user_id) VALUES (?,?,?,NOW(),?)");
$data_format = 'json';
//$date = date("Y-m-d H:i:s");
$rdf_version = '0.1';
$user_id = $_SESSION['user_id'];
$escaped_json = "'".$mysqli->real_escape_string($jsonString)."'";
$statement->bind_param("ssss", $escaped_json,$data_format,$rdf_version,$user_id);
$statement->execute();
>>>>>>> Stashed changes

// below lines of code will store all the comments into the comments table

$statement_comments = $mysqli->prepare(" INSERT INTO comments (comments_rdf_about,comments_date,comments_provenance,comments_place_of_composition,comments_is_part_of,comments_has_part,comments_text_divisions,comments_notes,custom_namespace_available,type_available,role_available,genre_required_available,genre_controled_available,date_available,url_available,suggested_terms_type,suggested_terms_role,suggested_terms_genre,user_id) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
$comments_rdf_about= $comments['comments-rdf-about'];
$comments_date= $comments['comments-date'];
$comments_provenance= $comments['comments-provenance'];
$comments_place_of_composition= $comments['comments-place-of-composition'];
$comments_is_part_of= $comments['comments-is-part-of'];
$comments_has_part= $comments['comments-has-part'];
$comments_text_divisions= $comments['comments-text-divisions'];
$comments_notes= $comments['comments-notes'];
$custom_namespace_available = $comments['custom-namespace-available'];
$type_available = $comments['type-available'];
$role_available = $comments['role-available'];
$genre_required_available = $comments['genre-required-available'];
$genre_controled_available  = $comments['genre-controled-available'];
$date_available = $comments['date-available'];
$url_available  = $comments['url-available'];
$suggested_terms_type = $comments['suggested-terms-type'];
$suggested_terms_role = $comments['suggested-terms-role'];
$suggested_terms_genre = $comments['suggested-terms-genre'];
$user_id=$_SESSION['user_id'];
$statement_comments->bind_param("sssssssssssssssssss", $comments_rdf_about,$comments_date,$comments_provenance,$comments_place_of_composition,$comments_is_part_of,$comments_has_part,$comments_text_divisions,$comments_notes,$custom_namespace_available,$type_available,$role_available,$genre_required_available,$genre_controled_available,$date_available,$url_available,$suggested_terms_type,$suggested_terms_role,$suggested_terms_genre,$user_id);
$statement_comments->execute();
	


>>>>>>> Stashed changes

require "includes/footer.php";
