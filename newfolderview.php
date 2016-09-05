<?php

// Load folder

$currentDir=".";

if (isset($_GET['f']))
  {
  $currentDir="{$_GET['f']}";
  }


// Take care of uploaded file

if (isset($_FILES['fileToUpload']))
  {
  $target_path = $currentDir . "/" . basename($_FILES['fileToUpload']['name']);
  move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $target_path);
  }


// Deletes file

if (isset($_GET['deletefile']))
  {
  if (file_exists($currentDir . "/" . $_GET['deletefile']))
    {
    unlink($currentDir . "/" . $_GET['deletefile']);
    }
  }


// Deletes folder

if (isset($_GET['deletefolder']))
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

if (isset($_POST['newFolder']))
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

function formatBytes($bytes, $precision = 2) { 
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

<html>
<head>
<title>New FolderView</title>
</head>
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Roboto+Condensed" rel="stylesheet">
<style>
a {color:#006080;text-decoration:none}
a:hover {color:#00a0c0;text-decoration:none}
body {font-family:'Open Sans', sans-serif;font-size:12.5px;color:#404040;background-color:#ffffff}
table {font-size:inherit}
input {font-family:inherit;font-size:inherit;color:inherit}
ul li ul {display:none}
h1, h2, h3, h4, h5, h6 {font-family:'Roboto Condensed', 'Arial Narrow';font-weight:normal}

.foldericon {font-size:inherit;color:#ffe090;vertical-align:middle;margin-right:5px}
.fileicon {font-size:inherit;color:#c0c0c0;vertical-align:middle;margin-right:5px}
.deleteicon {font-size:inherit;color:#ff6060;vertical-align:middle;margin-right:5px}
</style>
<body>

<table border=0 cellspacing=0 cellpadding=10 width="800px">
<tr valign='middle'>

<td>

<h1><i class="material-icons foldericon">&#xE2C8;</i>

<?php

// Mappelinje

$mappesamling=split("/",$currentDir);
$mappestring="";
foreach ($mappesamling as $mappebit)
  {
  if ($mappestring=="")
    {
    $mappestring="{$mappebit}";
    }
  else
    {
    $mappestring="{$mappestring}/{$mappebit}";
    }

  if ($mappebit==".")
    {
    echo("<a href='?f={$mappestring}'>Root</a> / ");
    }
  else
    {
    echo("<a href='?f={$mappestring}'>{$mappebit}</a> / ");
    }
  }
?>


</h1>

</td>

<?php

echo("<form action='?f={$currentDir}' method='post' id='createFolderForm'>");
echo("<td width=80 align='right'>");
echo("<input type='button' value='Add Folder..' onclick='createFolder()' class='cmsButton'>");
echo("<input type='hidden' name='f' value='{$currentDir}'>");
echo("<input type='hidden' name='newFolder' id='newFolder'>");
echo("</td>");
echo("</form>");

echo("<form enctype='multipart/form-data' action='?f={$currentDir}' method='post' id='uploadForm'>");
echo("<td width=80 align='right'>");
echo("<input type='button' value='Upload File..' onclick='uploadFile()' class='cmsButton'>");
echo("<input type='hidden' name='f' value='{$currentDir}'>");
echo("<input type='file' name='fileToUpload' id='fileToUpload' onchange='document.all.uploadForm.submit()' style='display:none'>");
echo("</td>");
echo("</form>");
?>

</tr></table>

<table border=0 cellspacing=0 cellpadding=10 width="800px">
<?php

// List mapper

$aapnemappe=opendir($currentDir);
while (($mappe = readdir($aapnemappe)) !== false)
  {
  if ($mappe!="." && $mappe!="..")
    {
    if (is_dir("{$currentDir}/{$mappe}"))
      {
      $filantall = 0;
      $filer = scandir("{$currentDir}/{$mappe}");
      $filantall = count($filer) - 2;
      $filantall = "{$filantall} items";

      echo("<tr valign='middle' onmouseover='this.style.backgroundColor=\"#f0f0f0\";' onmouseout='this.style.backgroundColor=\"initial\";'>");
      echo("<td>");
      echo("<a href='?f={$currentDir}/{$mappe}'><i class='material-icons foldericon'>&#xE2C7;</i> {$mappe}</a></td>");
      echo("<td align='right'>");
      echo("{$filantall}</td>");
      echo("<td align='right'>");
      echo("<a href='javascript:confirmNavigate(\"index.php?sp=explorer&f={$currentDir}&deletefolder={$mappe}\",\"Are you sure you want to delete this folder?\")' alt='Delete'><i class='material-icons deleteicon'>&#xE92B;</i></a></td>");
      echo("</tr>");
      }
    }
  }
closedir($aapnemappe);

?>

<?php


// List filer

$aapnemappe=opendir($currentDir);

while ($filer=readdir($aapnemappe))
  {
  if ($filer!="." && $filer!="..")
    {
      if (is_file("{$currentDir}/{$filer}"))
      {

      $filnavn = $currentDir."/".$filer;

      $filstorrelse = filesize("{$currentDir}/{$filer}");
      $filstorrelse = formatBytes($filstorrelse);

      echo("<tr valign='middle' onmouseover='this.style.backgroundColor=\"#f0f0f0\";' onmouseout='this.style.backgroundColor=\"initial\";'>");
      echo("<td>");
      echo("<a href='{$currentDir}/{$filer}' target='_blank' style='text-overflow:ellipsis;white-space:nowrap;overflow:hidden'><i class='material-icons fileicon'>&#xE873;</i> {$filer}</a></td>");
      echo("<td style='width:100px' align='right'>");
      echo("{$filstorrelse}</td>");
      echo("<td style='width:50px' align='right'>");
      echo("<a href='javascript:confirmNavigate(\"index.php?sp=filemanager&f={$currentDir}&deletefile={$filer}\",\"Are you sure you want to delete this file?\")' alt='Delete'><i class='material-icons deleteicon'>&#xE92B;</i></a></td>");
      echo("</tr>");
      }
    }
  }
closedir($aapnemappe);

?>

</table>

</body>
</html>