<?php

$SystemState = "setup";

if (file_exists("config.php") == true)
  {
    $SystemState = "login";
  }

?>