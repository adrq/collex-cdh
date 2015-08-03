<?php
/**
 * @file rdf.php
 * Prints rdf for a given record
 */
$title = "View RDF";
$loginRequired = true;
require "includes/header.php";
require "includes/rdf-generator.php";
?>


<div class="container">
  <div class="row">
    <div class="col-xs-12">
      <h1 class="pull-left">View RDF</h1>
    </div>
    <div class="col-xs-12">
      
      <?php if (isset($_GET["id"])) :?>
      	<pre>
      	  <?php print htmlspecialchars(generateRDF($_GET["id"]));?>
      	</pre>
      <?php else:?>
        <p>Invalid ID. <a href="submissions">View submissions</a>
      <?php endif?>
      
    </div>
  </div>
</div>




<?php require "includes/footer.php";?>