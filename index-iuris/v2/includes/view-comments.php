<?php
/**
 * @file view-comments.php
 * Renders all comments for users.
 */
require "config.php";

if (isset($_GET["comments"])) {
  global $mysqli;
  session_start();

  $commentName = $_GET["comments"];
  if ($commentName == "genre"){
  		$statement = $mysqli->query("select user_id,genre_required_available,genre_controled_available,suggested_terms_genre from comments");
  	}elseif($commentName == "type_available" || $commentName == "role_available" || $commentName == "date"){
  		$statement = $mysqli->query("select user_id,type_available,role_available,date_available,suggested_terms_type,suggested_terms_role,comments_date from comments");
  	}else{
  		$statement = $mysqli->query("select user_id,$commentName from comments");
  	}
  ?>
  <table class="table table-striped table-hover dt">
    <thead>
      <tr>
        <th>Username</th>
	<?php	
		if ($commentName == "genre"){
				  	print '<th> Required/Optional </th>';
				  	print '<th> Controlled/Free-form </th>';
				  	print '<th> Suggested term </th>';
				  	print '</tr>';
		}elseif($commentName == "type_available" || $commentName == "role_available" || $commentName == "date"){
				  print '<th> Decision </th>';
				  print '<th> Comments </th>';
		}elseif( ($commentName == "custom_namespace_available") || ($commentName == "url_available")){
				  print '<th> Decision </th>';
		}else{
				print '<th> Comments </th>';
		}
	?>			  
      </tr>
    </thead>
    <tbody>
      <?php
      while ($row=$statement->fetch_assoc()):
        $temp = $mysqli->prepare("SELECT username FROM users WHERE id = ?");
        $temp->bind_param("s", $row["user_id"]);
        $temp->execute();
        $temp->store_result();
        $temp->bind_result($username);
        $temp->fetch();
        ?>
        <tr>
          <td><?php print $username; ?></td>
		  <?php if($commentName == "genre"){ ?>
			  <td> <?php printf ("%s",$row["genre_required_available"]);?></td>
			  <td> <?php printf ("%s",$row["genre_controled_available"]);?></td>
			  <td> <?php printf ("%s",$row["suggested_terms_genre"]);?></td>
			  <?php } elseif($commentName == "type_available") { ?>	
			  <td> <?php printf ("%s",$row["type_available"]);?></td>
			  <td> <?php printf ("%s",$row["suggested_terms_type"]);?></td>
			  <?php } elseif($commentName == "role_available") { ?>	
			  <td> <?php printf ("%s",$row["role_available"]);?></td>
			  <td> <?php printf ("%s",$row["suggested_terms_role"]);?></td>
			  <?php } elseif($commentName == "date") { ?>	
			  <td> <?php printf ("%s",$row["date_available"]);?></td>
			  <td> <?php printf ("%s",$row["comments_date"]);?></td>
			  <?php }else{ ?>
			   <td> <?php printf ("%s",$row[$commentName]);?></td>
		  <?php } ?>
        </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
  <?php

  exit();
} else {
  header("Location: ./");
}
