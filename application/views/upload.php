<?php

/**
 * target directory
 * $target=site
 *
 */


if(is_uploaded_file($_FILES['file']['tmp_name']))
{
    $mimeType=mime_content_type($_FILES['file']['tmp_name']);
    $validExtensions=array('audio/mpeg','image/png', 'image/jpeg');
    if(!in_array($mimeType, $validExtensions)){
        echo "This file type is not allowed";

    }

    if($mimeType=="audio/mpeg"){
        $destinationFolder=$_SERVER['DOCUMENT_ROOT']  . '/erp/res/uploads/videos/';
    }else if($mimeType=="image/png"||"image/jpeg"){
        $destinationFolder=$_SERVER['DOCUMENT_ROOT']  . '/erp/res/uploads/images/';

    }


}




 if(file_exists($destinationFolder . basename($_FILES['file']['name'])))
 {
     echo "The File already exits" ."<br>";
     $uploadOK=0;
 }else {


     if ($_FILES['file']['size'] > 50000000) {
         echo "The file is too large" . "<br>";
         $uploadOK = 0;
         exit();
     } else {
         $uploadOK = 1;
     }


     if ($uploadOK = 0) {
         echo "Sorry,the file couldn't be uploaded" . "<br>";
     } else {

         if (move_uploaded_file($_FILES['file']['tmp_name'], $destinationFolder . basename($_FILES['file']['name']))) {
             echo "Sucess!!" . htmlspecialchars(basename($_FILES['file']['name'])) . "File uploaded";
         } else {
             echo "Failed !The file has not  been uploaded" . "<br>";
         }
     }
 }
