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
  					<?php if (isset($_SESSION["user_role"]) && $_SESSION["user_role"]=="superuser" ) :?>
  					<th>User</th>
  					<?php endif;?>
  					<th></th>
  				</tr>
  			</thead>
  			<tbody>
  				<?php
  				global $mysqli;
  				if (isset($_SESSION["user_role"]) && $_SESSION["user_role"]=="superuser"){
  					$statement = $mysqli->prepare("SELECT id, url, title, archive, type, user_id FROM objects");
  					$statement->execute();
  					$statement->store_result();
  					$statement->bind_result($id, $url, $title, $archive, $type, $user_id);
  				}
  				else{
  					$statement = $mysqli->prepare("SELECT id, url, title, archive, type FROM objects WHERE user_id = ?");
  					$statement->bind_param("s", $_SESSION["user_id"]);
  					$statement->execute();
  					$statement->store_result();
  					$statement->bind_result($id, $url, $title, $archive, $type);
  				}

  				while ($statement->fetch()): ?>
  				<tr>
  					<td><?php print $title; ?></td>
  					<td><?php print $url; ?></td>
  					<td><?php print $archive; ?></td>
  					<td><?php print $type; ?></td>
  					<td><?php print $id; ?></td>
  					<?php if (isset($_SESSION["user_role"]) && $_SESSION["user_role"]=="superuser") :?>
  					<td><?php
  					$statement2 = $mysqli->prepare("SELECT username FROM users WHERE id=? LIMIT 1");
  					$statement2->bind_param("s", $user_id);
  					$statement2->execute();
  					$statement2->store_result();
  					$statement2->bind_result($objectUserName);
  					$statement2->fetch();
  					print $objectUserName;
  					?></td>
  					<?php endif;?>
  					<td class="text-center">
						  <a href="view?id=<?php print $id; ?>" class="btn btn-primary">View</a>
						  <a href="edit?id=<?php print $id; ?>" class="btn btn-success">Edit</a>
  					</td>
  				</tr>
  				<?php endwhile; ?>
  			</tbody>
  		</table>
		</div>
  </div>
</div>

<?php require "includes/footer.php"; ?>
