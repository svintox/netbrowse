<?php

$SystemState = "setup";

if (file_exists("config.php"))
  {
    $SystemState = "login";
  }


// Load folder

chdir("../");
$currentDir=".";

if (isset($_GET['f']) && $SystemState == "authenticated")
  {
    $currentDir="{$_GET['f']}";
  }


// Take care of uploaded file

if (isset($_FILES['fileToUpload']) && $SystemState == "authenticated")
  {
    $target_path = $currentDir . "/" . basename($_FILES['fileToUpload']['name']);
    move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $target_path);
  }


// Deletes file

if (isset($_GET['deletefile']) && $SystemState == "authenticated")
  {
    if (file_exists($currentDir . "/" . $_GET['deletefile']))
      {
        unlink($currentDir . "/" . $_GET['deletefile']);
      }
  }


// Deletes folder

if (isset($_GET['deletefolder']) && $SystemState == "authenticated")
  {
    $dirToDel = $currentDir . "/" . $_GET['deletefolder'];
    $q = count(glob("$dirToDel/*")) == 0;
    if ($q)
      {
        rmdir($currentDir . "/" . $_GET['deletefolder']);
      }
    else
      {
      echo("<script language='javascript'> alert('Folder is not empty!'); </script>");
      }
  }


// Creates folder

if (isset($_POST['newFolder']) && $SystemState == "authenticated")
  {
    if (!file_exists($currentDir . "/" . $_POST['newFolder']))
      {
        mkdir($currentDir . "/" . $_POST['newFolder']);
      }
    else
      {
        echo("<script language='javascript'> alert('Folder already exist!'); </script>");
      }
  }


// Konvertere bytes

function formatBytes($bytes, $precision = 2)
  { 
    $units = array('B', 'KB', 'MB', 'GB', 'TB'); 
    $bytes = max($bytes, 0); 
    $pow = floor(($bytes ? log($bytes) : 0) / log(1024)); 
    $pow = min($pow, count($units) - 1); 

    // Uncomment one of the following alternatives
    $bytes /= pow(1024, $pow);
    // $bytes /= (1 << (10 * $pow)); 
    return round($bytes, $precision) . ' ' . $units[$pow]; 
  } 


?>