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
<img src="" alt="logo goes here">
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
