<?php
session_start();

$SystemState = "setup";

if (file_exists("system/config.php"))
  {
    include("config.php");
    $SystemState = "login";
  }
else
  {
    if (isset($_POST["username"]) && isset($_POST["password"]))
      {
        $ConfigFile = fopen("system/config.php", "w") or die("Unable to create config file!");
        $ConfigData = "<?php\n\n";
        $ConfigData .= "\$netBrowseAdmin = \"" . $_POST["username"] . "\";\n";
        $ConfigData .= "\$netBrowsePass = \"" . $_POST["password"] . "\";\n\n\n";
        $ConfigData .= "?>";
        fwrite($ConfigFile, $ConfigData);
        fclose($ConfigFile);
        $ConsoleLog .= $ConfigData . "\n\n";
      }
  }


// Check login and save session data

if (isset($_POST["username"]) && isset($_POST["password"]))
  {
    if (($_POST["username"] == $netBrowseAdmin) && ($_POST["password"] == $netBrowsePass))
      {
        $_SESSION["netBrowseAdmin"] = $_POST["username"];
        $_SESSION["netBrowsePass"] = $_POST["password"];
      }
  }


// Check session, confirm username and password

if (isset($_SESSION["netBrowseAdmin"]) && isset($_SESSION["netBrowsePass"]))
  {
    if (($_SESSION["netBrowseAdmin"] == $netBrowseAdmin) && ($_SESSION["netBrowsePass"] == $netBrowsePass))
      {
        $SystemState = "authenticated";
      }
    else
      {
        session_unset();
      }
  }


// Logout

if (isset($_GET["logout"]))
  {
    session_unset();
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