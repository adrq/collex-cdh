<?php session_start();
include("config.php");
?>
<html>
<head>
<title><?php echo $pageTitle?></title>
<meta charset="UTF-8">

<link rel="stylesheet" type="text/css" href="style.css">
<script src="js/jquery-1.11.3.js"></script>

<script> <?php //TODO: add this to head only on rdf-form page?>
$(document).ready(function() {
    var max_fields      = 10; //maximum input boxes allowed
    var role_wrapper         = $("#role_fields_wrap"); //Fields wrapper
    var genre_wrapper         = $("#genre_fields_wrap"); //Fields wrapper
    var add_role_button      = $("#add_role_button"); //Add button ID
    
    var x = 1; //initlal text box count
    $(add_role_button).click(function(e){ //on add input button click
        var inputFields;
    	$.ajax({
    		  url: "/index-iuris/form-include.php",
    		  data: {
    		    "form-element" : "role"
    		  },
    		  success: function( data ) {
    		    inputFields = data;
    		    $(role_wrapper).append(inputFields);
    		  }
    		});
        e.preventDefault();

    });

    $(add_genre_button).click(function(e){ //on add input button click
        var inputFields;
    	$.ajax({
    		  url: "/index-iuris/form-include.php",
    		  data: {
    		    "form-element" : "genre"
    		  },
    		  success: function( data ) {
    		    inputFields = data;
    		    $(genre_wrapper).append(inputFields);
    		  }
    		});
        e.preventDefault();

    });
    
    $(genre_wrapper).on("click",".remove_field", function(e){ //user click on remove text
        e.preventDefault(); $(this).parent('div').remove(); x--;
    })
    $(role_wrapper).on("click",".remove_field", function(e){ //user click on remove text
        e.preventDefault(); $(this).parent('div').remove(); x--;
    })
});
</script>

</head>

<body>
<div id="main-container">
<div id="header-container">
<div id="header-banner">
<div id="logo-div">
<a href="index.php"><img src="iilogo8.jpg" alt="Index Iuris Logo" height="120px"></a>
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
<div class="nav-item"><a href="view-submissions.php">View submissions</a></div>
<div class="nav-item">Welcome, <?php echo $_SESSION['username']?> - <a href="logout.php">Log out</a></div>
<?php else:?>
<div class="nav-item"><a href="login.php">Log in</a></div>
<?php endif;?>
</div>
</div>
