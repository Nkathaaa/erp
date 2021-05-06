<?php

function upload()
{
    if (is_uploaded_file($_FILES['file']['tmp_name'])) {
        $mimeType = mime_content_type($_FILES['file']['tmp_name']);
        $validExtensions = array('audio/mpeg', 'image/png', 'image/jpeg');

        if (!in_array($mimeType, $validExtensions)) {
            echo "This file type is not allowed";

        }

        if ($mimeType == "audio/mpeg") {
            $destinationFolder = $_SERVER['DOCUMENT_ROOT'] . '/erp/res/uploads/videos/';
        } else if ($mimeType == "image/png" || "image/jpeg") {
            $destinationFolder = $_SERVER['DOCUMENT_ROOT'] . '/erp/res/uploads/images/';

        }


    }


    if (file_exists($destinationFolder . basename($_FILES['file']['name']))) {
        echo "The File already exits" . "<br>";
        $uploadOK = 0;
    } else {


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
}

function resize_image($src,$width,$height)
{


$path = $src;
$ext = pathinfo($src, PATHINFO_EXTENSION);
echo $ext;
exit();
switch($ext){
case "jpg":
$source=imagecreatefromjpeg($src);
break;
case "png":
$source=imagecreatefrompng($src);
break;
case "gif":
$source=imagecreatefromgif($src);

}
list($width, $height) = getimagesize($src);
$ratio=$width/$height;
if($width/$height>$ratio){
    $newwidth=$height *$ratio;
    $newheight=$height;
}else{
    $newheight=$width *$ratio;
    $newwidth=$width;
}


$destination=imagecreatetruecolor($newheight,$newwidth);
imagecopyresampled($destination,$source,0,0,0,0,$newwidth,$newheight,$width,$height);
}
