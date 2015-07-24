<?php
/**
 * @file comments.php
 * Prints all comments for super users.
 */
$title = "Comments";
$loginRequired = true;
require "includes/header.php";
?>
<div class="container">
  <div class="row page-header">
    <div class="col-xs-12">
      <h1>Comment Viewer</h1>
    </div>
  </div>

  <div class="row">
    <div class="col-xs-6">
      <form class="form-horizontal">
        <fieldset>
          <div class="form-group">
            <label for="comment" class="control-label col-xs-3">Comment Type</label>
            <div class="col-xs-9">
              <select class="form-control" id="comment" name="comment">
                <option selected=""></option>
                <option value="comments_rdf_about">RDF: About</option>
                <option value="comments_date">Date</option>
                <option value="comments_provenance">Provenance</option>
                <option value="comments_place_of_composition">Place of composition</option>
                <option value="comments_is_part_of">Is-Part-Of</option>
                <option value="comments_has_part">Has-Part</option>
                <option value="comments_text_divisions">Text-division</option>
                <option value="comments_notes">Notes</option>
              </select>
            </div>
          </div>
        </fieldset>
      </form>

      <section id="commentResults"></section>
    </div>

    <div class="col-xs-6">
      <?php // TODO: Insert other area. ?>
    </div>
  </div>
</div>


<?php require "includes/footer.php"; ?>