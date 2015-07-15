<?php
$pageTitle="Index Iuris - Governance";
include("header.php")
?>
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

<h2>Proposed framework for governance, Index Iuris</h2>

DRAFT   DRAFT  DRAFT!!!

<h2>I.  Entity, Purpose, Membership</h2>
<p><span class="monospace">Index Iuris</span> is a federation of digital projects and archives that offer open-access primary source materials for the study of legal history in western Europe, from Roman law to early modern civil codes, encompassing both secular and ecclesiastical legal materials.  Each project or archive in the federation retains its own form, purpose, data structure, and full autonomy; membership in <span class="monospace">Index Iuris</span> brings enhanced access to and awareness of the content of member projects, and in time will support investigation of legal history across centuries and places, so that the materials of each project can be better contextualised in the larger sweep of legal history.  For example, a scholar could use the <span class="monospace">Index Iuris</span> site to find and assemble a collection of texts that form a sequence of legal thought on standards of proof, or could generate a visualization of the geographical and temporal concentrations of the term “spolia”, or could trace the quotation of a legal maxim in a range of texts.</p>  
<p>[Note: to get a sense of how this works, look at the NINES project (nines.org).  In the main page search box, type “Justice”.  To limit the 37,000+ results, go to the facetted search feature, and check “collections”.  There will be 10 hits, most from the Ruskin and Livingston projects.  If you click on one of those results, you will be taken to the text in those projects that has the word “Justice” in it.  So, the project “Ruskin at Walkely: Reconstructing the St. George Museum” has a description of an artefact “the Virtues”: one of those virtues is Justice, described by Ruskin in his “Seven Lamps of Architecture”.  David Livingston’s 1871 Diary has two references (one to justice and one to injustice) in his observations about African tribes.  There are, of course, many options from which to choose among the facetted search functions.]</p>
<p>Projects or archives seeking to have some or all of their primary source materials indexed in <span class="monospace">Index Iuris</span> may apply for membership; such applications will be reviewed by the Governing Council (see below) of <span class="monospace">Index Iuris</span>.  Projects must be scholarly, suitable in content, sustainable, curated, and have data structures that meet international standards.  In some instances, the Governing Council may recommend assistance from <span class="monospace">Index Iuris</span> technical staff to facilitate integration into <span class="monospace">Index Iuris</span>, if time and funding permit.</p>
<p>The technical infrastructure for <span class="monospace">Index Iuris</span> is an installation of Collex, in conjunction with Solr and Blacklight software, hosted pro tem at the Center for Digital Humanities at the University of South Carolina.  For projects to contribute data to <span class="monospace">Index Iuris</span>, they must provide appropriate metadata in RDF for all objects they wish to have accessible through <span class="monospace">Index Iuris</span>.</p>
<h2>II.  Governance</h2>
<h3>A.  Governing Council.</h3>
	<ol>
	<li>Decisions about development, technical support, system administration, curation, and expansion or revision of content are made by a Governing Council.  The Governing Council also considers and makes recommendations to the federation as a whole regarding matters that have an impact on the presentation of data or the contextualization of existing data.  Similarly, the Governing Council will consider and present recommendations to the federation as a whole regarding the integration of new projects, or opportunities to advance the technological capabilities of <span class="monospace">Index Iuris</span>.</li>
	<li>The Governing Council consists of five Principal Investigators, representing five  projects or archives in the federation.</li>
	<li>Members of the Governing Council are elected by the Principal Investigators of all member projects (one project, one vote; projects with more than one PI must decide which PI will vote in any given election).</li>
	<li>The normal term of office on the Governing Council is two years.  Should a representative to the Council be unable to complete a term, there will be a special election.</li>
	<li>Representatives to the Governing Council may serve for more than one term, but not consecutively.</li>
	<li>A project must have been a member of <span class="monospace">Index Iuris</span> for one full year before the PI is eligible to serve on the Governing Council.</li>
	<li>The elected members of the Governing Council will select by majority vote a Chair, who will be responsible for convening virtual meetings, maintaining communication, documenting issues and decisions and posting the documentation in the <span class="monospace">Index Iuris</span> record (available to all member projects) in a timely manner.  The Chair may request assistance from other members of the Council for execution of these tasks.</li>
	</ol>	
<h3>B.  Decisions by all member projects</h3>
	<ol>
	<li>Any matter that affects the presentation of data, the contextualization of data, the design of the <span class="monospace">Index Iuris</span> site, the format for search results, the incorporation of data in new tools or visualizations, or anything that a reasonable person would consider as having a significant impact on all members of the federation will be brought to the full membership of <span class="monospace">Index Iuris</span> for a vote.</li>
	<li>Any member project or archive may propose a change, innovation, or ballot measure for a vote.  Such proposals will go directly to the full membership, without intervention or recommendation from the Governing Council.</li>
	</ol>
<h3>C.  Review of Membership applications or status</h3>
	<ol>
	<li>Up to six new projects or archives may be admitted in a calendar year.</li>
	<li>Depending upon resources, integration into <span class="monospace">Index Iuris</span> may commence immediately upon approval, or may be deferred until resources are secured either by <span class="monospace">Index Iuris</span> or the approved project to prepare the RDF metadata necessary for integration.</li>
	<li>Membership applications will be reviewed by the Governing Council once a year, in June.  Applications will be ranked by vote of the entire Council.  The Chair of the Council will communicate decisions promptly to applicants.  The Council may recommend that a project not admitted to the federation in the current round apply in the following year.</li>
	</ol>
<h3>D.  Funding and Grant Applications</h3>
	<ol>
	<li>The Governing Council may recommend, delegate, or undertake, either as a body or by a smaller committee, applications to funding agencies for development of <span class="monospace">Index Iuris</span> as a whole.</li>
	<li>Member projects are free to pursue whatever grant applications they wish for their own development, without consultation of either the Governing Council or full membership of <span class="monospace">Index Iuris</span>.</li>
	<li>Member projects may propose collaborative projects with each other without consultation of either the Governing Council or full membership of <span class="monospace">Index Iuris</span>.</li>
	<li>Member projects may propose collaborative projects with <span class="monospace">Index Iuris</span> as a whole.  Such proposals will be reviewed by the Governing Council before any funding applications are initiated.  The Governing Council will make a recommendation to the membership as a whole, for a vote.</li>
	</ol>
<h3>E.  Responsibilities of Member Projects</h3>
	<ol>
	<li>Members of <span class="monospace">Index Iuris</span> must notify the Governing Council of any significant changes in the location, URLs or URIs, data structures, technical redesign, or curation plans for their projects.</li>
	<li>Members of <span class="monospace">Index Iuris</span> should strive to attain accuracy in metadata, transcriptions, encoding, and all other aspects of their projects.  <span class="monospace">Index Iuris</span> is a scholarly research environment, and its value depends upon the quality of the data and metadata.</li>
	</ol>

<?php 
include("footer.php");
?>