<?php
include("system/boot.php");
?>

<!DOCTYPE html>
<html>
  <head>
    <title>NetBrowse</title>
    <link href="system/style.css" rel="stylesheet">
    <script src="system/script.js"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#006080">
  </head>
<body>

<div class="headerZone">
  <h2>
    <a href="index.php"><span class="material-icons folderIcon">folder_special</span> NetBrowse v1.0</a>
    <?php
    if ($SystemState == "authenticated")
      {
        echo("<span style='float:right;display:inline-block'><a href='index.php?logout'><span class='material-icons'>logout</span></a></span>");
      }
    ?>
  </h2>
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