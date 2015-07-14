<?php session_start();
include("config.php");
?>
<html>
<head>
<title><?php echo $pageTitle?></title>
<meta charset="UTF-8">

<link rel="stylesheet" type="text/css" href="style.css">

</head>

<body>
<div id="main-container">
<div id="header-container">
<a href="index.php">Home</a> - <a href="rdf-form.php">RDF form</a> - 
<?php if ($_SESSION['logged-in']==true) :?>
<p>Welcome, <?php echo $_SESSION['username']?> - <a href="logout.php">logout</a></p>
<?php else:?>
<a href="login.php">login</a>
<?php endif;?>
</div>
