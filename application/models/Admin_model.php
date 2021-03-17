<?php
if(!defined('BASEPATH'))
    exit('No direct script access allowed');


/**
 * @property CI_DB_query_builder $db   Database
 * @property CI_DB_forge $dbforge     Database
 * @property CI_DB_result $result    Database
 * @property CI_Session $session
 **/
class Admin_model extends CI_Model
{

    var $defaultPassword = "xxxx";

    var $passwordSalt = 'co<%8&-)smILx&-';
    //Fix paths
    //var $gallery_path= base_url('/res/image/icon/gallery/');

    //var $vids_path= base_url('/res/image/icon/vids_path/');

    public function __construct()
    {
        parent::__construct();


    }

    function authorize($username, $password)
    {
        //Get the system user data for the user with the specifiedemai address
        //This data is what is sctored in the userdata of the session and used to verify useroles and other key features
        $sql="SELECT * FROM systemusers WHERE userPhone='".$username."'AND userLoginStatus='1'";
        $qry=$this->db->query($sql);

        //if theere os no return value for email entered...try using phone number or vice versa



		//The system is using email address
		//Phone number functionality isnt complete
        if($qry!==FALSE||!is_array($qry)||count($qry->result())<=0){
            $sql="SELECT * FROM systemusers WHERE userEmailAddress='".$username."'AND userLoginStatus='1'";


            $qry=$this->db->query($sql);


			$result=$qry->result();


            if($qry!=FALSE){
                foreach ($result as $oneRow){
                   $userPass=$oneRow->userPassword;

					if($userPass==md5($this->getPasswordSalt().$password,FALSE))
                        {
                        return $qry->result();

                    }else{
                        return false;
                    }
                }
            }else{
                return false;
            }


        }


    }


    /*
     * CURRENT USER ROLES; to stay dynamic
     */
    function getCurrentUserRoles($userid = '')
    {
        $sql = "SELECT * FROM systemusers WHERE userId=" . $this->session->userdata('userid');

        if ($userid != '') { // If we view an individual
            $sql = "SELECT * FROM systemusers WHERE userId=" . $userid;
        }

        $users= $this->db->query($sql);

        if ($users->result()) {
            //parse
            $userRoleGroupId = $users->result()[0]->userRoleGroup;
            $userRoles = $this->getRoleGroups($userRoleGroupId)[0]->uGrRoles;
            return $userRoles;
        }
    }


    //generic add  items function with value to be specified being table,array to be added or edited and a datananme that
    //specifies value that is affected that is used to customize sucess or error messages
function editItems($table,$array,$edit_array,$dataname){
        $qry=$this->db->update($table,$array,$edit_array);

        if($qry){
            $this->session->set_flashdata("success_msg",$dataname.  "   successfuly  updated");
            return true;
        }else{
            $this->session->set_flashdata('error_msg',$dataname."could not be saved".json_decode($this->db->error()));
            return false;




        }
}
//returns password salt initialized at beginning of program
    function getPassWordSalt()
    {
     return $this->passwordSalt;
    }

 function uploader($cont_name,$contType='',$fieldname,$id='')
 {
     {
         $pathToUse = "";
         //An if statement of the diferent file paths for videos,pictures  and general uplaods
         if ($contType != '' && $contType == "profile") {
             $pathToUse = $this->pics_path;
         } else if ($contType != '' && $contType == "contentVideo") {
             $pathToUse = $this->vids_path;
         } else if ($contType != "" && $contType == "general") {
             $pathToUse = $this->gallery_path;
         }


//create variables and assign them to   $_FILES array varibales
         if (is_array($_FILES[$fieldname]["name"])) {

             $returnArray = [];
             $returnString = '';

             for ($i = 0; $i < count($_FILES[$fieldname]['name']); $i++) {
                 //the variable holds the temp-name property of array files
                 $oneFieldName = $_FILES[$fieldname]['tmp_name'][$i];
                 //$onefileExt holds the name propery of $_FILES
                 $oneFileExt = pathinfo($_FILES[$fieldname]['name'][$i], PATHINFO_EXTENSION);

                 $size = filesize($oneFieldName);
                 //Sets the maximum upload file to 2mb
                 if ($size > 2000 * 1024)
                 {
                     //File limit exceeded error
                     $error = "File size exceeded";
                 } else {

                     if (is_uploaded_file($_FILES[$fieldname]["tmp_name"][$i]))
                     {
                         if (isset($id) && $id != '')
                         {
                             //create filename from cooncationating the  $id,cont_name,time(),rand(0 and fileext varlues as beloe
                             $filename = $id . "_" . $cont_name . '_' . time() . $i . '_' . rand(0, 1000) . '.' . $oneFileExt;
                         } else
                             {
                             $filename = $cont_name . '_' . date('YMdHis') . $i . '_' . rand(0, 1000) . '.' . $oneFileExt;
                         }

                             //copy file/image from temp folder to the specified file
                         //essentiall $onefirlname is source  and destination is $pathToUse.'/'.$filename
                         //Try using copy() first then use move_u[loded_file
                         if (!@copy($oneFieldName, $pathToUse . '/' . $filename)) {
                             if (!@move_uploaded_file($oneFieldName, $pathToUse . '/' . $filename)) {
                                 $this->set_error("Upload destination error");
                                 return FALSE;
                             } else {
                                 //If upload is doen succesfuly,resize the image with 640*640 ratio
                                 $resizedImage = $this->resizeImage($pathToUse . '/' . $filename, "640", "640");

                                 //Write over the old image
                                 $imgfile = $pathToUse . '/' . $filename;

                                 //another method to get image type that is more guaranted but expenisve
                                 //get imagesize return an associated array with Array ( [0] => 205 [1] => 120 [2] => 3 [3] => width="205" height="120" [bits] => 8 [mime] => image/png)

                                 $info=getimagesize($pathToUse.'/'.$filename);
                                 $mime=$info['mime'];
                                 $width=$info[0];
                                 $height=$info[1];
                                 $type=$info[2];

                               //switc statement that converts the  resizedImage to jpg and replaces the initial $imgfile with ot
                                 //$imagejpeg/png/gif creates a new file of type jpeg/png from the $imgfile
                                 switch ($type) {
                                     case IMAGETYPE_JPEG:
                                         imagejpeg($resizedImage, $imgfile);
                                         break;
                                     case IMAGETYPE_PNG:
                                         imagepng($resizedImage, $imgfile);
                                         break;
                                     case IMAGETYPE_GIF:
                                         imagegif($resizedImage, $imgfile);
                                         break;
                                     default:
                                         imagejpeg($resizedImage, $imgfile);
                                         break;
                                 }

                                 //addd filename to return array
                                 array_push($returnArray, $filename);
                             }
                         }
                     } else {
                         $error = (!isset($_FILES[$fieldname]["error"][$i])) ? 4 : $_FILES[$fieldname]["error"][$i];
                     }
                 }
             }

             $returnString = json_encode($returnArray);

             return $returnString;
         } else {
             //For videa or image file
             $filename = $cont_name . '_' . time() . '_' . rand(0, 1000);



             if ($contType == "general" || $contType == "profile") {

                 //For profile and general $cont_type set the following varible values
                 if ($contType == "profile") {
                     $config = array(
                         //The types permited
                         'allowed_types' => 'jpg|gif|png|jpeg|JPG|PNG',
                         'upload_path' => $pathToUse,
                         'max_size' => 5000,
                         'maintain_ration' => true,
                         'create_thumb' => false,
                         'width' => 640,
                         'height' => 640,
                         'file_name' => $filename
                     );
                 } else if ($contType == "general") {
                     $config = array(
                         'allowed_types' => 'pdf|jpg|gif|png|jpeg|JPG|PNG|xls|xlsx',
                         'upload_path' => $pathToUse,
                         'max_size' => 5000,
                         'file_name' => $filename
                     );
                 }

                 //upload  the image
                 $this->load->library('upload', $config);
                 if (!$this->upload->do_upload($fieldname)) {
                     echo $this->upload->display_errors();
                     exit("<br>Image Upload error occurred!");
                 }
                 //returns all the upload data
                 $upload_data = $this->upload->data();

                 //resize image

                 if (isset($upload_data)) {

                     //NB: File size is concatenated at the end for use when saving the path to db. It will be used later for metrics
                     return $filename . $upload_data['file_ext'] . "#" . $upload_data['file_size'];
                 } else {
                     return false;
                 }
             } else if ($contType == "contentVideo") {
                 //set video variables
                 $config = array(
                     'allowed_types' => 'mp4|mpeg|flv|3gp|ogv',
                     'upload_path' => $pathToUse,
                     'max_size' => 10000,
                     'maintain_ration' => true,
                     'height' => 500,
                     'file_name' => $filename
                 );

                 //upload the video
                 $this->load->library('upload', $config);
                 if (!$this->upload->do_upload($fieldname)) {
                     echo $this->upload->display_errors();
                     exit("<br>Video Upload Error");
                 }
                 //return video data
                 $video_data = $this->upload->data();

                 //Return the video name
//
                 return $filename . $video_data['file_ext'] . "#" . $video_data['file_size'];
             }
         }
     }


 }

function addItems($table,$array,$dataname)
{
    $qry = $this->db->insert($table, $array);


    if ($qry) {
        $this->session->set_flashdata('success_msg' , $dataname . "  successfully added");
        return true;
    } else {
        $this->session->set_flashdata("error_msg" ,$dataname . "could not be added" . json_encode($this->db->error()));
        return false;
    }
}

function deleteItems($table,$array,$dataname){
        $qry=$this->db->delete($table,$array);
        if($qry){
            $this->session->set_flashdata('success_msg',$dataname.  "  successfully deleted");
                return true;
        }else{
            $this->session->set_flashdata('error_msg',$dataname."could not be deleted".json_encode($this->db->error()));
            return false;

        }
}


    function getRoleGroups($id = '', $limit = '')
    {
        $sql = "SELECT * FROM usergroups ORDER BY uGrId DESC";

        // filters
        if ($id != '') {
            $sql = "SELECT * FROM usergroups WHERE uGrId='$id'";
        }

        // limiting data returned
        if ($limit != '') {
            // convert string to integer
            $upperLimit = ( int )$limit;
            $sql = $sql . " LIMIT 0, $upperLimit";
        }

        $allData = $this->db->query($sql);

        if ($allData !== FALSE) {
            return $allData->result();
        }
    }





//get the menu
    function getMenu($type, $accessRoles, $id = '')
    {

        //type is adminMenu or nonadminType
        $sql = "SELECT * FROM $type";

        if ($accessRoles != '') {
            //filter menu by the roles of the current user
            $roleArray = json_decode($accessRoles);

            $rolesString = "";

            //parse the role ids array into a format that MySQL can understand
            //Essentally take the output and separate the roles array  based on the size of the return output
            //ie 0 values (,1 vlue ),numerous value ,
            if (is_array($roleArray)) {
                for ($i = 0; $i < count($roleArray); $i++) {
                    $oneId = $roleArray[$i];

                    if ($i == 0) {
                        $rolesString .= "(" . $oneId;

                        //also check if there is only one entry in the array
                        if ($i == (count($roleArray) - 1)) {
                            $rolesString .= ")";
                        }
                    } else if ($i == (count($roleArray) - 1)) {
                        $rolesString .= ", " . $oneId . ")";
                    } else {
                        $rolesString .= ", " . $oneId;
                    }
                }
            } else {
                $rolesString = "('')";
            }

            //if id is provided; just filter by that; for sub menus
            //The id is used to id that a submenu exists.
            if ($id != '') {
                //loading a sub menu
                $sql .= " WHERE subMenuParentFK='$id' AND subMenuAccessRoleFK IN $rolesString ";

//                echo "QUERY: <br><br> ".$sql." <br><br>";
//                exit();
            } else {// if no id us menuAcess Fk to filter the roles
                $sql .= " WHERE menuAccessRoleFK IN $rolesString";

//                echo "QUERY: <br><br> " . $sql . " <br><br>";
//                exit();
            }

            //ordering
            $sql .= " ORDER BY menuOrdering";


            $menuInfo = $this->db->query($sql);
        }

        if (isset($menuInfo) && $menuInfo->result()) {
            //The return value is the menu based on the varibles entered
            return $menuInfo->result();

        }
    }

    function getClients($id='',$limit='',$filterArray=''){

        $sql="SELECT * FROM client  ORDER BY clientId DESC";

        if(isset($filterArray)&& is_array($filterArray)&& count($filterArray)> 0){

            for($i=0;$i < count($filterArray);$i++){
                $separatedData = preg_split("/[\s,]+/", $filterArray);
                $dbTerm = $separatedData[0];
                $realParam = $separatedData[1];

                if($realParam !=null && realParam != '' &&$realParam !='Any'){

                    if($dbTerm=="clientId"||$dbTerm="clientEmail") {

                        if (strpos($sql, $dbTerm . "=") !== FALSE) {
                            $sql = $sql . "OR" . $dbTerm . "='" . $realParam . "'";
                        } else {
                            $sql = $sql . "AND" . $dbTerm . "='" . $realParam . "'";
                        }
                    }else{
                        $sql=$sql."AND".$dbTerm."LIKE '%".$realParam."%'";


                    }

                    $sql=$sql."ORDER BY clientId DESC";

                }
            }


        }

        if($id!=''){

            $sql="SELECT * FROM client WHERE clientId=$id";

        }
        if($limit!=''){
            $upperLimit=(int)$limit;
            $sql=$sql."LIMIT 0 ,$upperLimit";
        }

        $allData=$this->db->query($sql);

        if($allData !==FALSE){
            return $allData->result();
        }





    }

    function getSupportTickets($id='',$limit='',$filterArray=''){
        $sql="SELECT * FROM supporttickets WHERE ticketId<>''";
        if(isset($filterArray)&& is_array($filterArray)&&count($filterArray)>=0) {
            for ($i = 0; $i < count($filterArray); $i++) {
                $separatedArray = preg_split("][,/''", $filterArray);
                $realParam = $separatedArray[0];
                $dbTerm = $separatedArray[1];

                if ($realParam != "" && $realParam != "Any" && $realParam != null) {

                    if ($dbTerm == "ticketId" || $dbTerm = "ticketName") {
                        if (strpos($sql , "$dbTerm" . "=")!==FALSE) {
                            $sql = $sql . "AND" . $dbTerm . "='" . $realParam . "'";


                        } else {
                            $sql = $sql . "OR" . $dbTerm . "='" . $realParam . "'";
                        }
                    }


                } else {
                    $sql = $sql . "AND" . $dbTerm . "LIKE'%" . $realParam . "%'";
                }

                $sql = $sql . "ORDER BY ticketId DESC";
            }
        }


                if($id != ''){
                    $sql="SELECT * FROM supporttickets WHERE ticketId=$id";
                }

                if($limit=''){
                    $upperLimit=(int)$limit;
                    $sql=$sql."LIMIT BY 0,$upperLimit";

                }

                $allData=$this->db->query($sql);
                if($allData !==FALSE){
                    return $allData->result();
                }

    }

 function getRoles($role_Id="",$role_Type="")

 {
     //get roles from acessRoles table and classify them a s Add.Read,Update and delete
     $sql="SELECT * FROM accessroles ORDER BY FIELD(accType,'ADD','READ','UPDATE','DELETE')";
     //get roles basedon role id
     if($role_Id!=''){
         $sql="SELECT * FROM accessroles WHERE accId=$role_Id";
     }
     //get role based on acctType
     if($role_Type!=''){
         $sql="SELECT * FROM accessroles WHERE accType=$role_Type";
     }

     $allRoles=$this->db->query($sql);

     If($allRoles !='') {
         return $allRoles->result();
     }


 }
  function getAccounts($id='',$limit='',$filterArray=''){
        $sql="SELECT * FROM accounts WHERE accountId<>''";

        if(isset($filterArray)&& is_array($filterArray)&& count($filterArray)>0){
            for($i=0;$i<count($filterArray);$i++){
                $separatedData=preg_split("][,/",$filterArray);
                $realParam=$separatedData[0];
                $dbTerm=$separatedData[1];

                if($realParam!=''&& $realParam !=null&&$realParam !="Any"){

                    if($dbTerm="accountId"|| $dbTerm="accountName"){
                        if(strpos($sql,$dbTerm."=")!==FALSE){

                            $sql = $sql . "AND" . $dbTerm . "='" . $realParam . "'";
                        }

                    }else{
                        $sql=$sql."OR".$dbTerm."='".$realParam."'";
                    }
                }else{
                    $sql=$sql."AND".$dbTerm."LIKE'%".$realParam."%'";
                }
            }

            $sql=$sql."ORDER BY accountId DESC";
        }

        if($id!=""){
            $sql="SELECT * FROM accounts WHERE accountId=$id";
        }
        if($limit!=""){
            $upperLimit=(int)$limit;
            $sql=$sql."LIMIT  BY O,$upperLimit";
        }
        $allData=$this->db->query($sql);
        if($allData!==FALSE){
            return $allData->result();

        }


  }


    function getUsers($id = '', $filtersArray = '', $limit = '')
    {
        $sql = "SELECT * FROM systemusers ORDER BY userId DESC";

        // filters
        $toCheckRoles = false;
        $inRoles = false; //indicates if to check if the role is included or excluded
        $roleId = [];
        $toCheckStatus = false;
        $statusToUse = "";

        if (isset($filtersArray) && is_array($filtersArray) && count($filtersArray) > 0) {
            //create a dynamic query
            $sql = "SELECT * FROM systemusers WHERE userId <> '0' ";

            //loop through the search values array, extracting the sensible parameters and build an sql
            for ($i = 0; $i < count($filtersArray); $i++) {
                //split data by "#" sign
                $separatedData = preg_split("/[\#]+/", $filtersArray[$i]);

                $dbTerm = $separatedData[0];
                $realParam = $separatedData[1];

                //build sql on top of the basic one
                if ($realParam != null && $realParam != "" && $realParam != "Any") {
                    //you can create exceptions here for columns that cannot work with the "LIKE" comparison which is default below
                    if ($dbTerm == "userId" || $dbTerm == "userAccountNo" || $dbTerm == "userNatID" || $dbTerm == "userPhone" || $dbTerm == "userEmail"
                        || $dbTerm == "userLoginStatus" || $dbTerm == "userGender" || $dbTerm == "userRoleGroup"
                    ) {
                        if (strpos($sql, $dbTerm . "=") !== false) //necessary since similar columns may be added from an array
                            $sql = $sql . " OR " . $dbTerm . "='" . $realParam . "'";
                        else
                            $sql = $sql . " AND " . $dbTerm . " = '" . $realParam . "'";
                    } else if ($dbTerm == "userActive") {
                        $toCheckStatus = true;
                        $statusToUse = $realParam;

                    } else if ($dbTerm == "accType") {
                        //Admin or Ordinary
                        //TODO: Implement JSON CONTAINS here starting at MySQL 5.7 in the future
                        $toCheckRoles = true;
                        $roleId = "20";

                        if ($realParam == "Admin")
                            $inRoles = true;
                    } else {
                        $sql = $sql . " AND " . $dbTerm . " LIKE '%" . $realParam . "%'";
                    }
                }
            }

            //order clause on query
            $sql = $sql . " ORDER BY userId DESC ";

//            echo $sql;
//            exit();
        }

        // limiting data returned
        if ($limit != '') {
            // convert string to integer
            $upperLimit = ( int )$limit;
            $sql = $sql . " LIMIT 0, $upperLimit";
        }

        if ($id != '') {
            $sql = "SELECT * FROM systemusers WHERE userId='$id'";
        }

        $allData = $this->db->query($sql);

        if ($allData !== FALSE) {
            $returnArray1 = $allData->result();
            if ($toCheckRoles) {
                $returnArray1 = []; //reset since processing into the array is about to happne
                //check every row for the required data
                foreach ($allData->result() as $oneRow) {
                    if ($inRoles) {
                        if (in_array($roleId, json_decode($oneRow->userRoles))) {
                            if (!in_array($oneRow, $returnArray1))
                                $returnArray1 [] = $oneRow;
                        }
                    } else {
                        //inverse
                        if (!in_array($roleId, json_decode($oneRow->userRoles))) {
                            if (!in_array($oneRow, $returnArray1))
                                $returnArray1 [] = $oneRow;
                        }
                    }
                }
            }

            $returnArray2 = $returnArray1;
            if ($toCheckStatus) {
                $returnArray2 = []; //reset
                //check every row for the required data
                foreach ($returnArray1 as $oneRow) {
                    $activeStatusArray = json_decode($oneRow->userActive); //active or dormant status for the user products

                    if (is_array($activeStatusArray)) {
                        foreach ($activeStatusArray as $onePStatusObj) {
                            foreach ($onePStatusObj as $oneProdId => $oneProdStatus) {
                                if ($statusToUse == $oneProdStatus) {
                                    if (!in_array($oneRow, $returnArray2))
                                        $returnArray2 [] = $oneRow;
                                }
                            }
                        }
                    }
                }
            }

            //return final value
            return $returnArray2;
        }
    }

    function getStaff($id='',$limit=''){

        $sql="SELECT * FROM staff ORDER BY staffId DESC";

        //Filter by id
        if($id!=''){
            $sql="SELECT * FROM staff WHERE staffId='$id'";
        }


        if($limit!=''){
            //converts string limit to int
            $upperLimit=(int)$limit;
            $sql=$sql."LIMIT  0,$upperLimit";

        }
        //run the sql query
        $allStaffData=$this->db->query($sql);
        if($allStaffData!==FALSE) {
            //The array is data from the staff table
            return $allStaffData->result();


        }


    }

    function getWarehouse($id=""){
    	$sql= "SELECT * from warehouse WHERE warehouse_Id=$id";

    	$allWarehouseData=$this->db->query($sql);
    	if($allWarehouseData !==FALSE){
    		return $allWarehouseData->result();
		}


	}

    function getTasks($id='',$limit='',$filterArray=''){
        $sql="SELECT * FROM task WHERE taskId<>''";

        if(isset($filterArray)&&is_array($filterArray)&&count($filterArray)>=0){
            for ($i=0;$i<count($filterArray);$i++){
                $separateItems=preg_split("/\[]''", $filterArray);
                $dbTerm=$separateItems[1];
                $realParam=$separateItems[0];

                if($realParam!=null && $realParam !=''&&$realParam!='Any'){

                    if($dbTerm=="taskId" || $dbTerm=="taskProject") {
                        $sql = $sql . "AND" . $dbTerm . "='" . $realParam . "'";
                    } else {
                        $sql = $sql . "OR" . $dbTerm . "='" . $realParam . "'";

                    }
                }else{
                    $sql=$sql."AND".$dbTerm."LIKE '%".$realParam."%'";
                }

            }
            $sql=$sql."ORDER BY taskId";
        }

        if($id!=''){
            $sql="SELECT * FROM task WHERE taskId=$id";

        }

        if($limit=''){
            $upperLimit=(int)$limit;
            $sql=$sql."LIMIT BY 0,$upperLimit";

        }

        $allData=$this->db->query($sql);
        if($allData !==FALSE){
            return $allData->result();
        }


    }


    function getDepartments($id='',$filterArray='',$limit=''){

        $sql="SELECT * FROM departments WHERE departmentId<>''";

        if(isset($filterArray)&& is_array($filterArray)&& count($filterArray)>=0){

            for($i=0;$i<count($filterArray);$i++){
                $separateArray=preg_split("''[]\/", $filterArray);

                $realParam=$separateArray[0];
                $dbTerm=$separateArray[1];

                if($realParam !=""&& $realParam !=null && $realParam !="Any"){

                    if($dbTerm=="departmentId"||$dbTerm="departmentBudgetId"){

                        $sql=$sql."AND".$dbTerm."'=".$realParam."'";

                    }else{
                        $sql=$sql."OR".$dbTerm."'=".$realParam."'";
                    }


                }else{
                    $sql=$sql."AND".$dbTerm."LIKE '%".$realParam."%'";
                }


            }
            $sql=$sql."ORDER BY departmentId DESC";
        }

        if($id=''){
            $sql="SELECT * FROM departments WHERE departmentId=$id";

        }
        if($limit=''){
             $upperLimit=(int)$limit;
             $sql=$sql."LIMIT BY 0,$upperLimit";

        }

        $allData=$this->db->query($sql);


        if($allData!==FALSE){
            return $allData->result();

        }




    }
   function getPayroll($id='',$filterArray='',$limit=''){

        $sql="SELECT * FROM payroll WHERE payrollId<>''";

        if(isset($filterArray)&&is_array($filterArray)&&count($filterArray)>0){
            for($i=0;$i<count($filterArray);$i++){
                $separateArray=preg_split("''/\][",$filterArray);
                $dbTerm=$separateArray[1];
                $realParam=$separateArray[0];

                if($realParam!=''&& $realParam='Any'&& $realParam =null){

                    if($dbTerm=='payrollId' || $dbTerm='payrollName'){

                        $sql=$sql."AND".$dbTerm."'=".$realParam."'";

                    }else{
                        $sql=$sql."OR".$dbTerm."'=".$realParam."'";

                    }
                }else{
                    $sql=$sql."AND".$dbTerm."LIKE '%".$realParam."%'";

                }

            }

            $sql=$sql."GROUP BY payrollId DESC";
        }

        if($id!='') {
            $sql = "SELECT * FROM payroll WHERE payrollId=$id";
        }

        if($limit!=''){
               $upperLimit=(int)$limit;
               $sql=$sql."LIMIT BY 0,$upperLimit";

            }

        $allData=$this->db->query($sql);
        if($allData !==FALSE){
            return $allData->result();
        }


   }

   function getEvents($id='',$limit='',$filterArray=''){
        $sql="SELECT * FROM events WHERE eventId<>''";

        if(isset($filterArray)&& is_array($filterArray)&& count($filterArray)>=0){
            for($i=0;$i<count($filterArray);$i++){

                $separatedArray=preg_split("[]''/" ,$filterArray);
                $dbTerm=$separatedArray[0];
                $realParam=$separatedArray[1];

                if($realParam !=''&& $realParam !=null &&$realParam!="Any"){

                    if($dbTerm=="eventId"|| $dbTerm=="eventName"){

                        $sql=$sql."AND".$dbTerm."'=".$realParam."'";

                    }else{
                        $sql=$sql."OR".$dbTerm."'=".$realParam."'";
                    }

                }else{
                    $sql=$sql."AND".$dbTerm."LIKE'%".$realParam."%'";

                }



            }
            $sql=$sql."ORDER BY eventId DESC";

        }


        if($id!=''){

            $sql="SELECT * FROM  events WHERE eventId=$id";
        }
        if($limit=''){

            $upperLimit=(int)$limit;
            $sql=$sql."LIMIT BY 0,$upperLimit";


            $sql=$sql."ORDER BY eventId";
        }



       $allData=$this->db->query($sql);
       if($allData !==FALSE){
           return $allData->result();
       }


   }

   function  getProjects($id='',$limit='',$filterArray='')
   {
       $sql="SELECT * FROM projects WHERE projId<>''";
       if(isset($filterArray)&& is_array($filterArray)&& count($filterArray)>=0){
           for($i=0;$i<count($filterArray);$i++){

               $separatedArray=preg_split("[]''/" ,$filterArray);
               $dbTerm=$separatedArray[0];
               $realParam=$separatedArray[1];

               if($realParam !=''|| $realParam !=null || $realParam!="Any"){

                   if($dbTerm=="projId"|| $dbTerm=="projTitle"){

                       $sql=$sql."AND".$dbTerm."'=".$realParam."'";

                   }else{
                       $sql=$sql."OR".$dbTerm."'=".$realParam."'";
                   }

               }else{
                   $sql=$sql."AND".$dbTerm."LIKE'%".$realParam."%'";

               }



           }
           $sql=$sql."ORDER BY projId DESC";

       }


       if($id!=''){

           $sql="SELECT * FROM  projects WHERE projId=$id";
       }
       if($limit=''){

           $upperLimit=(int)$limit;
           $sql=$sql."LIMIT BY 0,$upperLimit";


           $sql=$sql."ORDER BY projId";
       }



       $allData=$this->db->query($sql);
       if($allData !==FALSE){
           return $allData->result();

       }


   }

   function getLogs($id='',$limit='')
   {
       $sql="SELECT * FROM  logs ORDER BY logId";

       if($id=''){
           $sql="SELECT * FROM logs WHERE logId=$id";

       }
       if($limit=''){
           $upperLimit=(int)$limit;
           $sql=$sql."LIMIT BY 0,$upperLimit";

       }

       $allData=$this->db->query($sql);
       if($allData !==FALSE){
          return $allData->result();
       }

   }





}
