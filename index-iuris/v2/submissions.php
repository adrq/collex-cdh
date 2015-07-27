<?php
/**
 * @file submissions.php
 * Prints the User's Submissions page.
 */
$title = "View Submissions";
$loginRequired = true;
require "includes/header.php";
?>

<div class="container">
	<div class="row page-header">
		<div class="row">
			<div class="col-xs-12">
				<h1>View Submissions</h1>
			</div>
		</div>
	</div>

  <div class="row">
  	<div class="col-xs-12">
  		<table class="table table-striped table-hover dt">
  			<thead>
  				<tr>
  					<th>Title</th>
  					<th>URL</th>
  					<th>Archive</th>
  					<th>Type</th>
  					<th>Object ID</th>
  					<th></th>
  				</tr>
  			</thead>
  			<tbody>
  				<?php
  				global $mysqli;
  				$statement = $mysqli->prepare("SELECT id, url, title, archive, type FROM objects WHERE user_id = ?");
  				$statement->bind_param("s", $_SESSION["user_id"]);
  				$statement->execute();
  				$statement->store_result();
  				$statement->bind_result($id, $url, $title, $archive, $type);

  				while ($statement->fetch()): ?>
  				<tr>
  					<td><?php print $title; ?></td>
  					<td><?php print $url; ?></td>
  					<td><?php print $archive; ?></td>
  					<td><?php print $type; ?></td>
  					<td><?php print $id; ?></td>
  					<td class="text-center">
						  <a href="view?id=<?php print $id; ?>" class="btn btn-primary">View</a>
						  <a href="#" class="btn btn-success">Edit</a>
  					</td>
  				</tr>
  				<?php endwhile; ?>
  			</tbody>
  		</table>
		</div>
  </div>
</div>

<?php require "includes/footer.php"; ?>
