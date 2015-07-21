<?php
/**
 * @file footer.php
 */
$scripts = array("jquery.min.js", "bootstrap.min.js");

foreach ($scripts as $script): ?>
  <script src="js/<?php print $script; ?>"></script>
<?php endforeach; ?>

</body>
</html>
