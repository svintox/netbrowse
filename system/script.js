// Confirm Navigate

function confirmNavigate(url,question)
{
if (window.confirm(question) == true)
  {
  window.location=url;
  }
}


// Upload File

function uploadFile()
{
var openFileDialog = document.getElementById("fileToUpload").click();
}


// Create Folder

function createFolder()
{
let createFolderDialog = prompt("Name the folder to be created:");

if (createFolderDialog != null)
  {
  document.getElementById("newFolderInput").value = createFolderDialog;
  }
}