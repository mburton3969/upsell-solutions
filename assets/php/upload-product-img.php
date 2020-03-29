<?php
//var_dump($_FILES);
error_reporting(0);

//Setup Variables...
$errors = '';
$img_upc = $_REQUEST['img_upc'];

//Load Document Here...
$uploadOk = 0;
if($_FILES['file']['size'] != 0) {
//$post_body = file_get_contents('php://input');//Set the RAW data from POST Variables to be able to view them.
$id = rand(100000,1000000);

//Document Parsing
$target_dir = "../product-imgs/";
$target_file2 = $target_dir . basename($_FILES["file"]["name"]);

$uploadOk = 1;
$imageFileType = pathinfo($target_file2,PATHINFO_EXTENSION);
$target_file = $target_dir . $id . "_pImg_upc_" . $img_upc . "." . $imageFileType;
// Check if image file is a actual image or fake image
//if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["file"]["tmp_name"]);
    if($check !== false) {
      //  echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        $errors .= "File is not an image.";
        $uploadOk = 0;
    }
//}
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" && $imageFileType != "JPG" && $imageFileType != "pdf" 
    && $imageFileType != "PDF" && $imageFileType != "docx" && $imageFileType != "doc" 
    && $imageFileType != "tiff" && $imageFileType != "TIFF") {
    $errors .= "ERROR!- only JPG, JPEG, PDF, PNG, GIF & TIFF files are allowed.";
    //echo $imageFileType;
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    $errors .= "ERROR!- your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
      
      //INSERT FILE PATH INTO DATABASE
      $file_name_1 = 'http://reseller-solutions.com/assets/product-imgs/' . $id . "_pImg_upc_" . $img_upc . "." . $imageFileType;
      //echo 'File was moved to the right location!';
    }else{
      $errors .= "Not uploaded because of error #" . $_FILES["file"]["error"];
    }
}
}else{
  //Set URL to empty if no file was selected to upload...
  $file_name_1 = '';
  $uploadOk = 0;
}//End if file was uploaded

if($uploadOk == 0){
  //Upload Error...
  $x->response = 'ERROR';
  $x->message = 'There was an issue uploading your file!';
}else{
  //Upload Sucessfull...
  $x->response = 'GOOD';
  $x->message = 'Upload Sucessfull!';
  $x->img_url = $file_name_1;
}

$response = json_encode($x, JSON_PRETTY_PRINT);
echo $response;

?>