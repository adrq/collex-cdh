<?php
/**
 * @file footer.php
 * Prints the closing of the HTML structure.
 */
$scripts = array("jquery.min.js", "bootstrap.min.js", "dataTables.min.js", "dataTables.bootstrap.js", "collex.js");

foreach ($scripts as $script): ?>
  <script src="js/<?php print $script; ?>"></script>
<?php endforeach; ?>

</body>
</html>
