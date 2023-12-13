

<table border="0px" cellspacing="0px" cellpadding="0px" width="100%">
  <tr valign="middle">
    <td>
      <h1>
        <span class="material-icons">folder_open</span>
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
    <td align="right" style="white-space:nowrap">
      <?php
      echo("<form action='?f={$currentDir}' method='post' id='createFolderForm' style='display:inline-block'>");
      echo("<button onclick='createFolder()'><span class='material-icons'>create_new_folder</span><span class='hideOnMobile'> New Folder</span></button>");
      echo("<input type='hidden' name='f' value='{$currentDir}'>");
      echo("<input type='hidden' name='newFolder' id='newFolder'>");
      echo("</form>");
      echo("<form enctype='multipart/form-data' action='?f={$currentDir}' method='post' id='uploadForm' style='display:inline-block'>");
      echo("<button onclick='uploadFile()' style='margin-left:10px'><span class='material-icons'>upload_file</span><span class='hideOnMobile'> Upload File</span></button>");
      echo("<input type='hidden' name='f' value='{$currentDir}'>");
      echo("<input type='file' name='fileToUpload' id='fileToUpload' onchange='document.all.uploadForm.submit()' style='display:none'>");
      echo("</form>");
      ?>
    </td>
  </tr>
</table>

<table border="0" cellspacing="0" cellpadding="10px" width="100%">
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