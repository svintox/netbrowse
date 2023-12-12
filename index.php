<?php
include("system/boot.php");
?>

<html>
<head>
<title>NetBrowse</title>
</head>
<link href="system/style.css" rel="stylesheet">
<script src="system/script.js"></script>
<body>

<div class="contentZone">
  <h2>NetBrowse v1.0</h2>
  <?php
    if ($SystemState == "setup")
      {
        include("system/setup.php");
      }
    if ($SystemState == "login")
      {
        include("system/login.php");
      }
    if ($SystemState == "authenticated")
      {
        include("system/browse.php");
      }
  ?>
</div>

</body>
</html>