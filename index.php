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

<div class="headerZone">
  <h2><span class="material-icons">cloud_circle</span> NetBrowse v1.0</h2>
</div>

<div class="contentZone">
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