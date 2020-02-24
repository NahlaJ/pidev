<?php
if (is_uploaded_file($_FILES['userfile']['tmp_name'])) {

    //echo "File ". $_FILES['userfile']['name'] ." uploaded successfully.\n";
    $temp = explode(".", $_FILES["userfile"]["name"]);
    $newfilename = round(microtime(true)) . '.' . end($temp);
    move_uploaded_file($_FILES["userfile"]["tmp_name"], $newfilename);
    echo "$newfilename";
    //move_uploaded_file ($_FILES['userfile'] ['tmp_name'], $_FILES['userfile'] ['tmp_name']);
} else {
  echo "Possible file upload attack: ";
  echo "filename '". $_FILES['userfile']['tmp_name'] . "'.";
  print_r($_FILES);
}
?>
