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
<div id="header-banner">
<div id="logo-div">
<img src="iilogo8.jpg" alt="Index Iuris Logo" height="120px">
</div>
<div id="contact-div">
<p>Contact us:
<p><a href="mailto:WILDERCF@mailbox.sc.edu">Colin Wilder (University of South Carolina)</a></p>
<p><a href="mailto:afire2@uky.edu">Abigail Firey (University of Kentucky)</a></p>
</div>
</div>
<div id="navigation-container">
<hr>
<div class="nav-item"><a href="index.php">Home</a></div>
<?php if ($_SESSION['logged-in']==true) :?>
<div class="nav-item"><a href="rdf-form.php">Metadata submission form</a></div>
<div class="nav-item"><a href="governance.php">Governance</a></div>
<div class="nav-item">Welcome, <?php echo $_SESSION['username']?> - <a href="logout.php">Log out</a></div>
<?php else:?>
<div class="nav-item"><a href="login.php">Log in</a></div>
<?php endif;?>
</div>
</div>
