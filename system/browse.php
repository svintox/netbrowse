

<table border="0px" cellspacing="0px" cellpadding="10px" width="100%">
  <tr valign="middle">
    <td>
      <h1><i class="material-icons foldericon">&#xE2C8;</i>

        <?php

        // Mappelinje

        $folderPath = explode("/",$currentDir);
        $folderString = "";

        foreach ($folderPath as $pathItem)
          {
            if ($folderString == "")
              {
                $folderString = $pathItem;
              }
            else
              {
                $folderString = $folderString . "/" . $pathItem;
              }
            if ($pathItem == ".")
              {
                echo("<a href='?f=" . $folderString . "'>Root</a> / ");
              }
            else
              {
                echo("<a href='?f=" . $folderString . "'>" . $pathItem . "</a> / ");
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
  </tr>
</table>

<table border=0 cellspacing=0 cellpadding=10 width="800px">
  <?php

    // List mapper

    $aapnemappe=opendir($currentDir);
    while (($mappe = readdir($aapnemappe)) !== false)
      {
        if ($mappe != "." && $mappe != ".." && $mappe != "netbrowse")
          {
            if (is_dir("{$currentDir}/{$mappe}"))
              {
                $mappeantall = 0;
                $mapper = scandir("{$currentDir}/{$mappe}");
                $mappeantall = count($mapper) - 2 . " items";
                echo("<tr valign='middle' onmouseover='this.style.backgroundColor=\"#f0f0f0\";' onmouseout='this.style.backgroundColor=\"initial\";'>");
                echo("<td>");
                echo("<a href='?f=" . $currentDir . "/" . $mappe . "'><i class='material-icons foldericon'>&#xE2C7;</i> " . $mappe . "</a></td>");
                echo("<td align='right'>");
                echo($mappeantall . "</td>");
                echo("<td align='right'>");
                echo("<a href='javascript:confirmNavigate(\"index.php?sp=explorer&f=" . $currentDir . "&deletefolder=" . $mappe . "\",\"Are you sure you want to delete this folder?\")' alt='Delete'><i class='material-icons deleteicon'>&#xE92B;</i></a></td>");
                echo("</tr>");
              }
          }
      }


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
                echo("<a href='../" . $currentDir . "/" . $filer . "' target='_blank' style='text-overflow:ellipsis;white-space:nowrap;overflow:hidden'><i class='material-icons fileicon'>&#xE873;</i> " . $filer . "</a></td>");
                echo("<td style='width:100px' align='right'>");
                echo($filstorrelse . "</td>");
                echo("<td style='width:50px' align='right'>");
                echo("<a href='javascript:confirmNavigate(\"index.php?sp=filemanager&f=" . $currentDir . "&deletefile=" . $filer . "\",\"Are you sure you want to delete this file?\")' alt='Delete'><i class='material-icons deleteicon'>&#xE92B;</i></a></td>");
                echo("</tr>");
              }
          }
      }

    closedir($aapnemappe);
  ?>
</table>