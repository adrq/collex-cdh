<?php
/**
 * @file rdf.php
 * Prints rdf for a given record
 */

require "includes/rdf-generator.php";
require_once "includes/config.php";
if (isset($_GET["id"])) :
  $id = $_GET["id"];
  if (isset($_GET["download"]) && $_GET["download"]=="true"){ //download the rdf file instead of displaying it
	header("Content-Description: File Transfer");
	header("Content-Disposition: attachment; filename=$id.rdf");
    print generateRDF($_GET["id"]);
    exit();
  }


$title = "View RDF";
$loginRequired = true;
require "includes/header.php";
?>


<div class="container">
  <div class="row">
    <div class="col-xs-12">
      <h1 class="pull-left">View RDF</h1>
      <h3 class="pull-right"><a href="view?id=<?php print $id?>">Return to submission</a></h3>
    </div>
    <div class="col-xs-12">
      <pre>
        <?php print htmlspecialchars(generateRDF($id));?>
      </pre>      
    </div>
  </div>
</div>
<?php else:?>
<div class="container">
  <div class="row">
    <div class="col-xs-12">
      <h1 class="pull-left">View RDF</h1>
    </div>
    <div class="col-xs-12">
      <p>Invalid ID. <a href="submissions">View submissions</a>
    </div>
  </div>
</div>
<?php endif?>



<?php require "includes/footer.php";?>