

<?php

    function uploader($cont_name,$fieldname,$contType="",$id='')
    {

        //set paths for different contTypes
        $pathToUse="";
        if($contType !=''&& $contType =='profile')
        {
            $pathToUse=$this->pics_path;
        }else if($contType !=''&& $contType == 'contentVideo'){
            $pathToUse=$this->vids_path;
        }else if($contType !=''&& $contType=='general'){
            $pathToUse=$this->gallery_path;

        }


    //the file is moved from its current folfder ..it nname changes tfrom name to temmp name..upon saving...it gets new name
    //This includes its destination path
        if(is_array($_FILES[$fieldname]["name"]))
        {
            $returnArray=array();
            $returnStrings='';


             for($i=0; $i < count($_FILES[$fieldname]['name']);$i++){
                 $oneFieldName=$_FILES[$fieldname]["name"][$i];
                 $oneFileExt=pathinfo($_FILES[$fieldname]["name"][$i],PATHINFO_EXTENSION);
                 //chcek if file size is less than 1024 by 1000
                 $size=filesize($oneFieldName);
                 if($size >1000 *1024){
                     $error="The file is too large";
                 }else{

                     //check if file is uploaded
                     if(is_uploaded_file($_FILES[$fieldname]['tmp_name'][$i])){

                         //create $fieldname dynamically by looping through the files
                         if(isset($id)&& $id !=''){
                             $fileName=$id. "_".$cont_name."_".time()."_".rand(0,1000) ."." .$oneFileExt;


                         }else{
                             $fileName=$cont_name."_".date()."_".rand(0,1000)."_".$oneFileExt;
                         }
                         if(!@copy($oneFieldName,$pathToUse.'/'.$fileName)){
                           if(!@move_uploaded_file($oneFieldName,$pathToUse. "/".$fileName)){
                               $this->set_error('upload destination errors');
                               return FALSE;
                           }else{
                               $resizedImage=$this->resizeImage($pathToUse . "/".$fileName,"640","640");

                               //overwrite earlier image
                               $imgFile=$pathToUse."/".$fileName;

                               //get image info using slower but more effecient  method
                               $image_info=getimagesize($pathToUse."/".$fileName);
                               $mime=$image_info['mime'];
                               $width=$image_info[0];
                               $height=$image_info[1];
                               $type=$image_info[2];
                               switch($type){
                                   case IMAGETYPE_JPEG:
                                       imagejpeg($resizedImage,$imgFile);
                                       break;
                                   case IMAGETYPE_PNG:
                                       imagepng($resizedImage,$imgFile);
                                       break;
                                   case IMAGETYPE_GIF:
                                       imagegif($resizedImage,$imgFile);
                                       break;
                                   default:
                                       imagejpeg($resizedImage,$imgFile);
                                       break;


                               }
                               array_push($returnArray,$fileName);
                           }

                         }else{
                             $resizedImage=$this->resizeImage($pathToUse."/".$oneFieldName);

                             $imgFile=$pathToUse ."/".$oneFieldName;
                             $image_info=getimagesize(pathToUse ."/".$oneFieldName);
                             $mime=$image_info['mime'];
                             $width=$image_info[0];
                             $height=$image_info[1];
                             $type=$image_info[2];


                             switch($type) {
                                 case IMAGETYPE_JPEG:
                                     imagejpeg($resizedImage, $imgFile);
                                     break;
                                 case IMAGETYPE_PNG:
                                     imagepng($resizedImage,$imgFile);
                                     break;
                                 case IMAGETYPE_GIF:
                                     imagegif($resizedImage,$imgFile);
                                     break;
                             }
                             array_push($returnArray,$fileName);


                         }



                     }else{
                         $error=(!isset($_FILES[$fieldname]['error'][$i]))? 4 : $_FILES[$fieldname]['error'][$i];

                     }
                 }


        }

       $returnStrings=json_decode($returnArray);


        }else{
           $fileName =$cont_name."_".time()."_".rand(0,1000);
           if($contType=="general"||"contentVideo") {
               if ($contType == 'profile') {
                   $config = array(
                       "allowed_types" => "jpg|gif|png|jpeg|JPG|PNG",
                       "upload_path" => $pathToUse,
                       "max_size" => 5000,
                       "maintain_ration" => true,
                       "create_thumb" => false,
                       "width" => 640,
                       "height" => 640,
                       "file_name" => $fileName

                   );
               } else if ($contType == 'general') {
                   $config = array(
                       'allowed_types' => 'pdf|jpg|gif|png|jpeg|JPG|PNG|xls|xlsx',
                       'upload_path' => $pathToUse,
                       'max_size' => 5000,
                       'file_name' => $fileName
                   );
               }

               //initialze library
               $this->load->library('upload');
               //set preferences
               $this->load->initialize($config);
               $fieldname = "fieldName";
               if (!$this->upload->do_upload($fieldname)) {
                   echo $this->upload->display_errors();
                   exit("<br>Image Upload Error Ocurred");

               }
               $upload_data = $this->upload->data();
               if (isset($upload_data)) {

                   return $fileName . $upload_data['file_ext'] . "#" . $upload_data['file_size'];
               } else {
                   return false;
               }
           }else if ($contType=="contentVideo"){
               $config=array(
                   "allowed_type"=>"mp4|mpeg|flv|3gp|ogv",
                    "max_size"=>10000,
                   'upload_path' => $pathToUse,
                   'maintain_ration'=>true,
                   'file_name' => $fileName
               );

               $this->load->library('upload');
               $this->load->initialize($config);
               //$fieldname=$fie
               if(!$this->upload->do_upload($fieldname)){
                   echo $this->upload->display_errors();
                   exit("<br>Image Upload Failed");

               }
               $video_data=$this->upload->data();
               return $fileName .$video_data['file _ext']. "#" .$video_data['file_size'];

           }




        }
    }


function resizeImage($imageSrc,$width,$height)
{

}