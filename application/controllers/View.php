<?php
if (!defined('BASEPATH'))
    exit ('No direct script access allowed');

/**
 * @property Admin_model $Admin_model
 * @property CI_Session $session
 * @property CI_Input $input
 * @property CI_URI $uri
 * @property CI_Config $config
 * @property CI_DB_mysqli_driver $db
 * @property CI_Form_validation $form_validation
 * @property CI_Security $security
 * @property PDF pdf
 * @property Rememberme rememberme
 *
 */
require 'vendor/autoload.php';
use AfricasTalking\SDK\AfricasTalking;
class View extends CI_Controller
{
    /*
     * Default function of this class. Checks if one has logged in. If so, continue to admin pages, if not back to login.
     */

    var $today;
    var $userRoles = "";
    var $adminMode = false;
    var $nonAdminType = "";
    var $typeStaff = "Staff";
    var $smsGatewayUsername="sandbox";
    var $apiKey     = "737ceb7bd466eaf245d722ac56802e01b9f36bd3a9b4bd0f4db11b8d325ee382";
    var $sandboxCredentials="sandbox";


    public function __construct()
    {
        parent::__construct();

        date_default_timezone_set('Africa/Nairobi');
        $this->today = date('Y-m-d');

        // try to fetch the stored cookie
//        $cookie_user = $this->rememberme->verifyCookie();
        if ($this->session->userdata('is_logged_in')) {
            $this->userRoles = $this->Admin_model->getCurrentUserRoles();


            //NB: Role "6" is Admin access hence its prevalence here
            //the access to be from an authorized computer
            if (in_array("6", json_decode($this->userRoles)))
                $this->adminMode = true;
            else {
                $this->adminMode = false;
                $this->nonAdminType = $this->findUserType($this->session->userdata('userid'));
            }
        } else {
            //check the only acceptable end points for user who is not logged in
            $acceptableEndPoints = ["index","test",'upload', "login_action", "signout", "password_reset", "password_reset_action", "postmail_request","create_new_password"];

            $segment2 = $this->uri->segment(2);
            if (isset($segment2) && !in_array($segment2, $acceptableEndPoints))
                redirect('view');
        }
    }

    /*
   * Basic landing / login page
   */
    function index()
    {

        $cookie_user = $this->rememberme->verifyCookie();
        if ($cookie_user || $this->session->userdata('is_logged_in')) {
            //redirect to dashboard
          redirect('view/dashboard');
       }

        $data ['page_title'] = 'Kiss Devs ERP';

        $this->load->view('home');

        //$this->load->view('form');
    }

    function upload()
    {
        $mimeType = mime_content_type($_FILES['file']['tmp_name']);

        if (is_uploaded_file($_FILES['file']['tmp_name'])) {

            $validExtensions = array('audio/mpeg', 'image/png', 'image/jpeg');

            if (!in_array($mimeType, $validExtensions))
            {
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

             if($mimeType=="audio/mpeg"){


                    if (!@move_uploaded_file($_FILES['file']['tmp_name'], $destinationFolder . basename($_FILES['file']['name'])))
                    {
                        echo "Failed !The file has not  been uploaded" . "<br>";

                    } else {
                        echo "Sucess!!" . htmlspecialchars(basename($_FILES['file']['name'])) . "File uploaded";

                    }

                }

                else if(   $mimeType == "image/png" || "image/jpeg"  )
                {

                    if (!@move_uploaded_file($_FILES['file']['tmp_name'], $destinationFolder . basename($_FILES['file']['name']))) {

                        echo "Failed !The file has not  been uploaded" . "<br>";

                    } else {
                        $resizeImage = $this->resize_image($destinationFolder . basename($_FILES['file']['name']), '220', '200');

                        $ext = pathinfo($destinationFolder . basename($_FILES['file']['name']), PATHINFO_EXTENSION);
                        echo $ext;

                        switch ($ext) {
                            case "jpg":
                                imagejpeg($resizeImage, $destinationFolder . basename($_FILES['file']['name']));
                                break;
                            case "png":
                                imagepng($resizeImage, $destinationFolder . basename($_FILES['file']['name']));
                                break;
                            case "gif":
                                imagegif($resizeImage, $destinationFolder . basename($_FILES['file']['name']));
                                break;
                            default:
                                imagejpeg($resizeImage, $destinationFolder . basename($_FILES['file']['name']));
                                break;
                        }

                        echo "Sucess!!" . htmlspecialchars(basename($_FILES['file']['name'])) . "File uploaded";

                    }

                }
            }
        }
    }
    function resize_image($src,$width,$height)
    {
        $ext = pathinfo($src, PATHINFO_EXTENSION);
        echo "stage 1";
        switch($ext){
            case "jpg":
                $source=imagecreatefromjpeg($src);

                echo "stage 2";
                break;
            case "png":
                $source=imagecreatefrompng($src);
                break;
            case "gif":
                $source=imagecreatefromgif($src);
                break;
            default:
                $source=imagecreatefromjpeg($src);
                break;
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


        $thumb=imagecreatetruecolor($newheight,$newwidth);
        imagecopyresampled($thumb,$source,0,0,0,0,$newwidth,$newheight,$width,$height);
        imagedestroy($source);
        return $thumb;
    }
    function redirectToSms(){
        $this->load->view('welcome_message');
    }

     function smsDetails(){

        $phoneNo=$this->input->post('phoneNumber');
        $message=$this->input->post('phoneMessage');

        $this->shortms($phoneNo,$message);
    }

    public function shortms($phoneNo,$message){
        $phoneRecepientArray= preg_split ("/\,/ ", $phoneNo);
        $no=implode('',$phoneRecepientArray);

        $arr=str_split($no,'10');

        $data=array('recepients' =>$arr,'message'=>$message);


        $this->sendSMS($data);

    }
    function sendSMS($data){


        $AT= new AfricasTalking($this->getSMSUsername(), $this->getApiKey(),$this->getSandboxCredentials());
        //$AT->setCredentials();
        $sms        = $AT->sms();

        try {
            // Thats it, hit send and we'll take care of the rest

            $data1= array(
                'to'=>$data['recepients'] ,
                'message'=>$data['message'] ,
                // 'from'=>$from

            );
            $result = $sms->send($data1);
            print_r($result);

        } catch (Exception $e) {
            echo "Error: ".$e->getMessage();
        }

    }

    function getSMSUsername(){
        return $this->smsGatewayUsername;
    }
    function getApiKey(){
        return $this->apiKey;
    }
    function getSandboxCredentials(){
        return $this->sandboxCredentials;

    }


    //dashboard for logged in user
    function dashboard()
    {
        //$data array is used to specify  the page varibales for the dsahboard page
        $data ['page_title'] = 'Dashboard';
        $data ['page_content'] = 'dashboard';

        //User Roles
        //Value stored from the constructor where $this->userRoles is defined
        $data['userRoles'] = $this->userRoles;


        //defaults for integrity purpose
        //The admin or non adminMode is set to determine level of access
        $data ['adminMode'] = $this->adminMode;
        $data ['nonAdminType'] = $this->nonAdminType;




        // find menu that can be shown to this user
        //function fetches menu based on user's roles
       $data = $this->fetchMenu($data);

      //Use page data stored in $data to load the dashboard page
        //The utils/teiplate does view loading ie header,footer,sidenav and $pageContent
        $this->load->view('utils/template', $data);

    }

    function users($mode='',$id=''){
        $data['page_title']='Users';
        $data['page_content']="users";

        $data['adminMode']=$this->adminMode;
        $data['nonAdminType']=$this->nonAdminType;

        $data['pageMode']=$mode;
        $data['userRoles']=$this->userRoles;
        $data=$this->fetchMenu($data);



        if(!in_array('40',json_decode($data['userRoles']))){
            redirect('view/index');
        }
        $data['allUserData']=$this->Admin_model->getUsers();
        $data['allUserGroups']=$this->Admin_model->getRoleGroups();
        //$data['uploadData']=$this->Admin_model->uploader($this->input->post('userImage'));
        //$cont_name,$contType='',$fieldname,$id=''
        if($mode=='edit')
        {
         $data['user_Info']=$this->Admin_model->getUsers($id);
         $data['page_content']='utils/form_users';
        }
        elseif($mode=='add')
        {
            $data['page_content']='utils/form_users';
        }
        if($mode=='delete')
        {
            $this->delete('users',$id);
        }



        $this->load->view('utils/template',$data);
    }
    function sms($mode='',$id=''){
        $data['page_title']='Sms';
        $data['page_content']='sms';

        $data['userRoles']=$this->userRoles;
        $data['pageMode']=$mode;
        $data['adminMode']=$this->adminMode;
        $data['nonAdminType']=$this->nonAdminType;

        //wherev do I sendSMS
        if(!in_array('65',json_decode($data['userRoles']))){
            redirect('view/index');
        }
        $data['allSMSInfo']=$this->Admin_model->getSms();
        if($mode=='add'){
            $data['page_content']='utils/form_sms';
        }elseif($mode=='edit'){
            $data['page_content']='utils/form_sms';
            $data['specificIdSmsInfo']=$this->Admin_model->getSms($id);


        }
        if($mode=='delete')
        {
            $this->delete('sms',$id);

        }
        $data = $this->fetchMenu($data);
        $this->load->view('utils/template',$data);

    }
    function userGroups($mode='',$id=''){
        $data['page_title']='User Groups';
        $data['page_content']='usergroups';

        $data['userRoles']=$this->userRoles;

        $data['pageMode']=$mode;
        $data['adminMode']=$this->adminMode;

        $data['nonAdminType']=$this->nonAdminType;


        $data=$this->fetchMenu($data);


        if(!in_array('48',json_decode($data['userRoles']))){
            redirect('view/index');
        }
        $data['allUserGroups']=$this->Admin_model->getRoleGroups();
        $data['allRoles']=$this->Admin_model->getRoles();



        if($mode=='edit')
        {
            $data['uGroup_Info']=$this->Admin_model->getRoleGroups($id);
            $data['page_content']='utils/form_usergroups';


        }elseif ($mode=='add')
        {
            $data['page_content']='utils/form_usergroups';

        }

         if($mode=='delete')
         {
            $this->delete('userGroups',$id);

        }

        $this->load->view('utils/template',$data);
    }
    function warehouse ($mode="",$id=''){
    	$data['page_title']='Warehouse';
    	$data['page_content']="warehouse";

    	$data['userRoles']=$this->userRoles;


    	$data['adminMode']=$this->adminMode;
    	$data['nonAdminType']=$this->nonAdminType;

    	$data['pageMode']=$mode;


    	$data=$this->fetchMenu($data);

    	if(!in_array(61,json_decode($data['userRoles']))){
    		redirect('view/index');

		}
    	$data['allWarehouse']=$this->Admin_model->getWarehouse();


    	if($mode=="edit"){
    		$data['warehouse_Info']=$this->Admin_model->getWarehouse($id);
    		$data['page_content']='utils/form_warehouse';
		}elseif($mode=="add"){
    		$data['page_content']='utils/form_warehouse';

		}
    	if($mode=="delete"){
    		$this->delete('warehouse',$id);

		}

    	$this->load->view('utils/template', $data);


	}


    function tasks($mode='',$id=''){
        $data['page_title']='Tasks';
        $data['page_content']='tasks';

        $data['userRoles']=$this->userRoles;

        $data['adminMode']=$this->adminMode;
        $data['nonAdminType']=$this->nonAdminType;

        $data['pageMode']=$mode;

        $data=$this->fetchMenu($data);
        if(!in_array('44',json_decode($data['userRoles']))){
            redirect('view/index');
        }

        $data['allTasks']=$this->Admin_model->getTasks();
        $data['allProjects']=$this->Admin_model->getProjects();


        if($mode=='edit'){
            $data['tasks_Info']=$this->Admin_model->getTasks($id);
            $data['page_content']='utils/form_tasks';


        }elseif($mode=='add'){
            $data['page_content']='utils/form_tasks';

        }
        if($mode=="delete"){
            $this->delete('tasks',$id);
        }

        $this->load->view('utils/template',$data);
    }
    function accounts($mode='',$id=''){
        $data['page_title']='Accounts';
        $data['page_content']='accounts';

        $data['userRoles']=$this->userRoles;

        $data['adminMode']=$this->adminMode;
        $data['nonAdminType']=$this->nonAdminType;

        $data['pageMode']=$mode;

        $data=$this->fetchMenu($data);
        if(!in_array('56',json_decode($data['userRoles']))){
            redirect('view/index');
        }

        $data['allAccounts']=$this->Admin_model->getAccounts();
        $data['allProjects']=$this->Admin_model->getProjects();

        if($mode=='edit'){
            $data['accounts_Info']=$this->Admin_model->getAccounts($id);
            $data['page_content']='utils/form_accounts';


        }elseif($mode=='add'){
            $data['page_content']='utils/form_accounts';
        }
        if($mode=="delete"){
            $this->delete('accounts',$id);
        }

        $this->load->view('utils/template',$data);
    }

    function clients($mode='',$id=''){
       $data['page_title']='Clients';
       $data['page_content']='clients';

       $data['userRoles']=$this->userRoles;
       $data['adminMode']=$this->adminMode;
       $data['nonAdminType']=$this->nonAdminType;

       $data['pageMode']=$mode;
      $data= $this->fetchMenu($data);

        if(!in_array('8',json_decode($data['userRoles']))){
            redirect('view/index');
        }

       $data['allClients']=$this->Admin_model->getClients();


       if($mode=='edit') {
           $data['page_content'] = 'utils/form_client';
           $data['client_Info'] = $this->Admin_model->getClients($id);

       }
       elseif($mode=='add'){
           $data['page_content'] = 'utils/form_client';
    }
       if($mode=='delete') {
           $this->delete('clients', $id);
       }
        $this->load->view('utils/template',$data);

    }

    function departments($mode='',$id=''){
        $data['page_title']='Departments';
        $data['page_content']='departments';

        $data['userRoles']=$this->userRoles;

        $data['adminMode']=$this->adminMode;
        $data['nonAdminType']=$this->nonAdminType;

        $data['pageMode']=$mode;

        $data=$this->fetchMenu($data);
        if(!in_array('12',json_decode($data['userRoles']))){
            redirect('view/index');
        }

        $data['allDepartments']=$this->Admin_model->getDepartments();

        if($mode=="add"){
            $data['page_content']='utils/form_departments';

        }elseif($mode=="edit"){
            $data["department_Info"]=$this->Admin_model->getDepartments($id);
            $data['page_content']='utils/form_departments';

        }
        if($mode=="delete"){
            $this->delete("departments",$id);
        }
        $this->load->view('utils/template',$data);


    }


    function supportTickets($mode='',$id=''){
        $data['page_title']='Support Tickets';
        $data['page_content']='supportTickets';

        $data['userRoles']=$this->userRoles;

        $data['adminMode']=$this->adminMode;
        $data['nonAdminType']=$this->nonAdminType;

        $data['pageMode']=$mode;

        $data=$this->fetchMenu($data);
        if(!in_array('36',json_decode($data['userRoles']))){
            redirect('view/index');
        }

        $data['allSupportTickets']=$this->Admin_model->getSupportTickets();
        $data['allProjects']=$this->Admin_model->getProjects();


        if($mode=='edit'){
            $data['ticket_Info']=$this->Admin_model->getSupportTickets($id);
            $data['page_content']='utils/form_support';

        }elseif($mode=='add'){
            $data['page_content']='utils/form_support';
        }
        if($mode=="delete"){
            $this->delete('supportTickets',$id);
        }
        $this->load->view('utils/template',$data);

    }



    function projects ($mode='',$id=''){
        $data['page_title']='Projects';
        $data['page_content']='projects';

        $data['userRoles']=$this->userRoles;

        $data['adminMode']=$this->adminMode;
        $data['nonAdminType']=$this->nonAdminType;

        $data['pageMode']=$mode;

        $data=$this->fetchMenu($data);
        if(!in_array('28',json_decode($data['userRoles']))){
            redirect('view/index');
        }

        $data['allProjects']=$this->Admin_model->getProjects();
        $data['allClients']=$this->Admin_model->getClients();
        $data['allStaff']=$this->Admin_model->getStaff();

        if($mode=="add"){
            $data['page_content']='utils/form_projects';

        }elseif($mode=="edit"){
            $data["projects_Info"]=$this->Admin_model->getProjects($id);
            $data['page_content']='utils/form_projects';

        }
        if($mode=="delete"){
            $this->delete("projects",$id);
        }
        $this->load->view('utils/template',$data);


    }


    function payroll($mode='',$id=''){
        $data['page_title']='Payroll';
        $data['page_content']='payroll';

        $data['userRoles']=$this->userRoles;

        $data['adminMode']=$this->adminMode;
        $data['nonAdminType']=$this->nonAdminType;

        $data['pageMode']=$mode;

        $data=$this->fetchMenu($data);
        if(!in_array('24',json_decode($data['userRoles']))){
            redirect('view/index');
        }

        $data['allPayroll']=$this->Admin_model->getPayroll();
        $data['allStaff']=$this->Admin_model->getStaff();

        if($mode=='edit'){
            $data['payRoll_Info']=$this->Admin_model->getPayroll($id);
            $data['page_content']='utils/form_payroll';

        }elseif($mode=='add'){
            $data['page_content']='utils/form_payroll';
        }
        if($mode=='delete')
        {
            $this->delete('payroll',$id);
        }
        $this->load->view('utils/template',$data);

    }


    function staff($mode='',$id=''){
        $data['page_title']='Staff';
        $data['page_content']='staff';

        $data['userRoles']=$this->userRoles;

        $data['adminMode']=$this->adminMode;
        $data['nonAdminType']=$this->nonAdminType;

        $data['pageMode']=$mode;

        $data=$this->fetchMenu($data);
        if(!in_array('32',json_decode($data['userRoles']))){
            redirect('view/index');
        }

        $data['allStaff']=$this->Admin_model->getStaff();
        $data['allDepartments']=$this->Admin_model->getDepartments();

        if($mode=='edit'){
            $data['staff_Info']=$this->Admin_model->getStaff($id);
            $data['page_content']='utils/form_staff';


        }elseif($mode=='add'){
            $data['page_content']='utils/form_staff';

        }
        if($mode=="delete"){
            $this->delete('staff',$id);
        }

        $this->load->view('utils/template',$data);
    }
    function logs($mode=''){
        $data['page_title']='Logs';
        $data['page_content']='logs';

        $data['userRoles']=$this->userRoles;

        $data['adminMode']=$this->adminMode;
        $data['nonAdminType']=$this->nonAdminType;

        $data['pageMode']=$mode;

        $data=$this->fetchMenu($data);
        if(!in_array('20',json_decode($data['userRoles']))){
            redirect('view/index');
        }

        $data['log_Info']=$this->Admin_model->getLogs();


        $this->load->view('utils/template',$data);
    }
    function events($mode='',$id=''){
        $data['page_title']='Events';
        $data['page_content']='events';

        $data['userRoles']=$this->userRoles;

        $data['adminMode']=$this->adminMode;
        $data['nonAdminType']=$this->nonAdminType;

        $data['pageMode']=$mode;

        $data=$this->fetchMenu($data);
        if(!in_array('16',json_decode($data['userRoles']))){
          redirect('view/index');
        }

        $data['allEvents']=$this->Admin_model->getEvents();


        if($mode=='edit'){
            $data['event_Info']=$this->Admin_model->getEvents($id);
            $data['page_content']='utils/form_events';


        }elseif($mode=='add'){
            $data['page_content']='utils/form_events';
        }
        if($mode=="delete"){
            $this->delete('events',$id);
        }

        $this->load->view('utils/template',$data);
    }











    function fetchMenu($pageData)
    {
        //The menuResut is out of getMenu and contains the menuItems given the $pageData sent t the getMenu function
        $menuResult = $this->Admin_model->getMenu("adminMenu", $pageData['userRoles']);

        $pageData['adminMenu'] = $menuResult;


        //parse to get sub menu where available
        if (isset($menuResult)) {

            $subMenus = array();
            foreach ($menuResult as $dataRow) {
                //check if the menu has a child menu
                if ($dataRow->menuHasChild == "1") {
                    //has child; get it
                    $subMenuResult = $this->Admin_model->getMenu("adminSubMenu", $pageData['userRoles'], $dataRow->menuId);

                    //append to array
                    array_push($subMenus, $subMenuResult);
                }
            }

            //add to return data
            //NB: This is an array of arrays
            $pageData['adminSubMenu'] = $subMenus;
        }

        //process various variables to be used on page
        //profile picture
        $pageData['userImage'] = base_url('../res/dist/img/ic_user.png');
        if ($this->session->userdata('userpic') && $this->session->userdata('userpic') != "") {
            $pageData['userImage'] = base_url('../res/uploads/profile/' . $this->session->userdata('userpic'));
        }
        //first and full name
        $pageData['userFirstName'] = $this->session->userdata('username');
        $pageData['userFullName'] = $this->session->userdata('username') . " " . $this->session->userdata('user_last_name');



        return $pageData;
    }




    //find user type given id
    //NB: This is for non-admin users (can be extended in the future by using the user id)
    function findUserType($userId)
    {
        //check user group
        $returnType = "";
        $userGroup = $this->Admin_model->getUsers($userId)[0]->userRoleGroup;

        if ($userGroup == "2")
            $returnType = $this->typeStaff;

        return $returnType;
    }


    function password_reset($mode='')
    {
        $data['page_title']='Password Reset';
        $data['page_content']='pass_reset';
        $data['pageMode']=$mode;

        //$this->load->view('utils/template',$data);
        //call to reset function
        $this->load->view($data ['page_content']);
    }
    function password_reset_action()
    {
        //Get the username and token from the input fields

        $userEmail = $this->security->sanitize_filename($this->input->post('username'));
        $key = $this->input->post('key');


        //retrieve  user data for given email address
        $userCheck=$this->Admin_model->getUsers($id='',['userEmailAddress#'.$userEmail]);

        if(isset($userCheck)&&is_array($userCheck)&& count($userCheck))
        {

            //check the key entered in the form against key in database
            if($userCheck[0]->userSecretKey==md5($key))
            {
                $token = md5($this->Admin_model->getPasswordSalt() . $userEmail);
                echo $this->session->set_flashdata('success_msg', "Proceed and set the new password");
                redirect('view/postmail_request/'  . $token . '/' . $userEmail);

            }
            else {
                echo $this->session->set_flashdata('error_msg', "Incorrect key.PleaseTry again");
                redirect('view/password_reset');

            }


        }
        else
        {
            echo $this->session->set_flashdata('error_msg','Invalid Email Address! Please Try again');
            redirect('view/password_reset');
        }
    }


    function postmail_request($resetToken,$userEmail)
    {

        //compare the  reset token from the reset() function with the the token gotten by md5'ing the email address and password salt
        $confirmationToken=md5($this->Admin_model->getPasswordSalt().$userEmail);
        if($confirmationToken !=$resetToken)
        {
            echo $this->session->set_flashdata("error_msg","Bad Url request");
            redirect('view/password_reset');

        }
        //pass usermaemail and page content data to get the new password  form
        $data['email_address']=$userEmail;
        $data['page_content']='new_password';
        $this->load->view('new_password',$data);


    }



    function create_new_password()
    {



//Get the username and passwords  from  new_apssword foem
        $useremail=$this->security->sanitize_filename($this->input->post('userEmail'));
        $pass1=$this->security->sanitize_filename($this->input->post('pass1'));
        $pass2=$this->security->sanitize_filename($this->input->post('pass2'));
        //create the confirmatuon token given the username nad md5'ing the pasword salt
        $confirmationToken=md5($this->Admin_model->getPassWordSalt(),$useremail);

        $this->form_validation->set_rules('pass1','PW1','required');
        $this->form_validation->set_rules('pass2','PW2','required');



        if($this->form_validation->run()==FALSE)
        {
            $this->session->set_flashdata('error_msg','Username or password Incorrect');
            //redirect to the postmail_requets function with the confirmation tokena  and useremail url
            //sort of secure url with the specified details of the confirmationToken and useremail
            redirect('view/postmail_request/'.$confirmationToken.'/'.$useremail);
        }else{
            //compare password 1 input to password 2 input
            if($pass1!=$pass2)
            {
                echo $this->session->set_flashdata('error_msg','The passwords do not match.Please Try gain.');
                redirect('view/postmail_request/'.$confirmationToken.'/'.$useremail);
            }else
            {
                //create a hashed Password of pass2 using md5,salt it
                $newHashedPasword = md5($this->Admin_model->getPassWordSalt(), $pass2);
                //retrive hashed password from the systemusers table
                $userCheck = $this->Admin_model->getUsers($id = '', ['userEmailAddress#' . $useremail]);


                if (isset($userCheck) && is_array($userCheck) && count($userCheck) > 0)
                {
                    $data=array('userPassword'=>$newHashedPasword);

                    $conditions=array('userId'=>$userCheck[0]->userId);

                    //update  userPassword field
                    $this->Admin_model->editItems('systemusers',$data,$conditions,"Users");
                    echo $this->session->set_flashdata('success_msg',"Password Succesfully updated");
                    redirect('view');

                }
                else{
                    echo $this->session->set_flashdata('error_msg','Username doesnt match.Try again');
                    redirect('view/postmail_request/'.$confirmationToken.'/'.$useremail);
                }
            }




        }


    }
    //login / start session
    function login_action()
    {

       //Get the username and password value in the home form
        $username = $this->input->post('username', true);
        $passwd = $this->input->post('password');

        //Also get the Ip address of the user and update sytems users table
        $ipAddress = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : 'IP-ERROR';
        //Also get time on users device
        $unixTimeNow = strtotime(date('Y-m-d H:i:s'));

        //set validation rules for the home forrm
        $this->form_validation->set_rules('username', 'Phone number', 'required');
        $this->form_validation->set_rules('password', 'PIN', 'required');

        //If the form validation fails
        if ($this->form_validation->run() == FALSE) {
            echo "non validated";
            redirect('view');
        } else {
            // Get the user details from the database
            //The return value is the sysytemuser table
            $login = $this->Admin_model->authorize($username, $passwd);


            if ($login) {
                foreach ($login as $lg) {

                    //get roles based on user group
                    $groupRoles = $this->Admin_model->getRoleGroups($lg->userRoleGroup)[0]->uGrRoles;
                   //This userdata value is used to set session dataa
                    //Evert key in maintaning user session and accessing data in the systesm users table within the site
                    $userdata = array(
                        'userid' => $lg->userId,
                        'useremail' => $lg->userEmailAddress,
                        'username' => $lg->userFirstName,
                        'user_last_name' => $lg->userSecondName,
                        'user_roles' => $groupRoles,
                        'userpic' => $lg->userImage,
                        'userdatereg' => $lg->userDateRegistered,
                        'is_logged_in' => TRUE
                    );




                    //set the session data
                    $this->session->set_userdata($userdata);



                    //update the user last login details for security
                    //Used to collect and update the user login time
                    $lastLoginValue = $ipAddress . "#" . $unixTimeNow;
                    $data = array(
                        'userLastLogin' => $lastLoginValue
                    );
                  //An instance of use of userdata from session to identify item being edited in the
                    //the sytesmusers tbale as lastlogin time and Ip address are being updated
                    $conditions = array(
                        'userId' => $this->session->userdata('userid')
                    );
                    echo "edit Items";
                    //Edit the lastlogin and user Ip avalise in systemsuser table
                    //using the generic editItems function
                    $this->Admin_model->editItems('systemusers', $data, $conditions, 'User');
                    $this->session->set_userdata('success_msg', 'Login successful!');

                }
                redirect('view/dashboard');
            } else {
                $this->session->set_flashdata('error_msg', 'Incorrect Phone number or Email Address');
                echo "login error";
                redirect('view');
            }
        }
    }





    function signout(){

        //Unset the userdata that has been being used to maiantain session and provide user data within the site
        $this->session->unset_userdata('userid');
        $this->session->unset_userdata('useremail');
        $this->session->unset_userdata('username');
        $this->session->unset_userdata('user_last_name');
        $this->session->unset_userdata('user_roles');
        $this->session->unset_userdata('userpic');
        $this->session->unset_userdata('userdatereg');
        $this->session->unset_userdata('is_logged_in');

        $this->session->set_flashdata('success_msg',"You have sucessfully logged out");
        redirect('view');

    }

    //Function that adds and updats tables in the site
    //The fisrts section updates the log table by determing the  mode of the operayion ie edit...delete or add
    //and the form the action is performed on.In addition it records the user carrying out operation
    //and the time of the operation
    //The second part carries out the crud  opeartion of differenr tabels ie staff,tickets,role groups and so on
    function crud($form,$mode)
    {
        //Record changes made to forms in the logs table
        $actionTarget = $form;
        if ($mode == 'edit' || strpos($mode, 'edit') !== FALSE) {

            switch ($form) {
                case "staff":
                    $actionTarget .= "-Item_Id:" . $this->input->post('staffId');
                    break;
                case "users":
                    $actionTarget .= "-Item_Id:" . $this->input->post('userId');
                    break;
                case "sms":
                    $actionTarget .="-Item_Id:". $this->input->post('smsId');
                case "clients":
                    $actionTarget .= "-Item_Id:".$this->input->post('clientId');
                    break;
				case "warehouse":
					$actionTarget .= "-Item_Id".$this->input->post('wH_Id');
                case "events":
                    $actionTarget .="-Items_Id".$this->input->post('eventId');
                    break;
                case "payroll":
                    $actionTarget .="-Items_Id".$this->input->post('payrollId');
                    break;
                case "usergroups":
                    $actionTarget .="-Items_Id".$this->input->post('uGrId');
                    break;
                case "departments":
                    $actionTarget .="-Items_Id".$this->input->post('departmentId');
                    break;
                case "tasks":
                    $actionTarget .="-Items-Id".$this->input->post('taskId');
                    break;
                case "projects":
                    $actionTarget .="-Items-Id".$this->input->post('projId');
                    break;
                case "supporttickets":
                    $actionTarget.="-Item-Id".$this->input->post('ticketId');
                    break;
                case "accounts":
                    $actionTarget.="-Item-Id".$this->input->post('accountId');
                    break;
                }


        }

        //Log Array used  to update the log Table
        $data = array(
            'logAction' => $mode != "" ? $mode : "Automated",
            'logDateTime' => date('Y-m-d H:i:s'),
            'logUserId' => $this->session->userdata('userid'),
            'logActionTarget' => $actionTarget,
            //XSS filter enabled
            'logAllData' => json_encode($this->input->post(NULL,TRUE))
        );


        $this->Admin_model->addItems('logs', $data, "Logs");
       // $this->session->set_flashdata('success_msg', "Logs successfully updated");

        //add and update for the other tables in the site
        switch ($form) {
            case "staff":

                //check if the mode is edit
                if ($mode == 'edit') {
                    //Check if the user has edit and add rights
                    if (!in_array('4', json_decode($this->userRoles)))
                    {
                        redirect('view/index');


                    }
                    //For edit,get the staff Id value to determine what row is affected by changes
                    $staffId = $this->input->post('staffId');
                } else
                    {

                   if (!in_array('2', json_decode($this->userRoles)))
                   {
                        redirect('view/index');
                   }


                }

                //Get the input from the form

                $stDpt = $this->input->post('staffDepartment');
                $stST = $this->input->post('staffSalutation');
                $stJT = $this->input->post('staffJobTitle');
                $stNm = $this->input->post('staffName');

                $this->form_validation->set_rules('staffDepartment', "staff Department", 'required');


                if ($this->form_validation->run()== FALSE) {

                    redirect('view/index/');

                } else {
                    $data = array(

                        'staffSalutation' => $stST,
                        'staffName' => $stNm,
                        'staffDepartment' => $stDpt,
                        'staffJobTitle' => $stJT,

                    );


                    if ($mode=='edit') {
                        $conditions = array(
                            'staffId' => $staffId
                        );
                       $this->Admin_model->editItems('staff', $data,$conditions,  'Staff');




                    } elseif($mode== 'add') {
                        $this->Admin_model->addItems('staff', $data, 'Staff');

                    }
                    redirect('view/staff');


                }



                break;
            case  "sms":
                if($mode=="edit") {
                    if (!in_array('66', json_decode($this->userRoles))) {
                        redirect('view/index');

                    }
                    $smsId = $this->input->post('smsId');
                } else{
                        if(!in_array('67',json_decode($this->userRoles))){
                            redirect('view/index');
                        }
                    }
                $smsTo=$this->input->post('smsTo');
                $smsFrom=$this->input->post('smsFrom');
                $message=$this->input->post('message');
                $this->form_validation->set_rules('smsTo','sT','required');
                if($this->form_validation->run()==FALSE){
                    redirect('view/index');

                }else{
                    $data=array(
                        'smsTo'=>$smsTo,
                        'smsFro'=>$smsFrom,
                        'message'=>$message,
                    );

                    if($mode=='add') {
                        $this->Admin_model->addItems('sms', $data, 'SMS');
                    }elseif($mode=="edit"){
                        $conditions=array("smsId"=>smsId);
                        $this->Admin_model->editItems('sms',$conditions,$data,"SMS");

                    }
                }
                redirect('view/index');
                break;
			case  "warehouse":
				if($mode =="edit") {

					if (!in_array('62', json_decode($this->userRoles))) {
						redirect('view/index');
					}
					$wH_Id = $this->input->post('wH_Id');
				}else {
					if(!in_array('59',json_decode($this->userRoles))){
						redirect('view/index');

					}

					}
				$wH_Name=$this->input->post('wH_Name');
				$wH_Loc=$this->input->post('wH_Loc');
			    $wH_C_Cap=$this->input->post('wH_C_Cap');
			    $wH_A_Cap=$this->input->post('wH_A_Cap');

			    $wH_Temp=$this->input->post('wH_Temp');


			    $this->form_validation->set_rules('wH_Name','WN','required');
			    if($this->form_validation->run()== FALSE){
			    	redirect('view/index');
				}else{
			    	$data=array(
			    		'warehouse_Name'=>$wH_Name,
						'warehouse_Coordinates'=>$wH_Loc,
						'warehouse_Full_Capacity'=> $wH_C_Cap,
						'warehouse_Present_Capacity'=>$wH_A_Cap,
						'warehouse_Temp'=>$wH_Temp

					);

					if ($mode == 'edit') {
						$conditions = array('warehouse_Id' => $wH_Id);
						print_r($conditions);
						exit();

						$this->Admin_model->editItems('warehouse', $data, $conditions, "Warehouse");

					} else {

						$this->Admin_model->addItems('warehouse', $data, "Warehouse");

					}

			    	redirect('view/warehouse');

				}

               break;
            case "projects":
                if ($mode == 'edit') {
                    if (!in_array('29', json_decode($this->userRoles))) {
                        redirect('view/index');
                    }
                    $projId = $this->input->post('projId');
                } else {
                    if (!in_array('27', json_decode($this->userRoles))) {
                        redirect('view/index');
                    }
                }

                $projTitle = $this->input->post('projTitle');
                $projClientId = $this->input->post('projClientId');
                $projStartDate = $this->input->post('projStartDate');
                $projTentativeEndDate = $this->input->post('projTentativeEndDate');
                $projActualEndDate = $this->input->post('projActualEndDate');
                $projMilestones = $this->input->post('projMilestones');
                $projDeliverables = $this->input->post('projDeliverables');
                $projTotalCost = $this->input->post('projTotalCost');
                $projCostBreakDown = $this->input->post('projCostBreakDown');
                $projStaffInvolved = $this->input->post('projStaffInvolved');

                $this->form_validation->set_rules("projTitle","PT","required");
                if ($this->form_validation->run() == FALSE) {
                     redirect('view/index');
                } else {


                    $data = array(
                        'projTitle' => $projTitle,
                        'projClientId' => $projClientId,
                        'projStartDate' => $projStartDate,
                        'projTentativeEndDate' => $projTentativeEndDate,
                        'projActualEndDate' => $projActualEndDate,
                        'projMilestones' => $projMilestones,
                        'projDeliverables' => $projDeliverables,
                        'projTotalCost' => $projTotalCost,
                        'projCostBreakDown' => $projCostBreakDown,
                        'projStaffInvolved' => $projStaffInvolved

                    );

                    if ($mode == 'edit') {
                        $conditions = array('projId' => $projId);
                        $this->Admin_model->editItems('projects', $data, $conditions, "Projects");

                    } else {
                        $this->Admin_model->addItems('projects', $data, "Projects");

                    }
                    redirect("view/projects");


                }
                break;
            case "users":
                {
                    if ($mode == "edit") {
                        if (!in_array('41', json_decode($this->userRoles))) {
                           redirect('view/index');
                        }

                        $userId = $this->input->post('userId');

                    } else {
                        if (!in_array('39', json_decode($this->userRoles)))
                        {
                            redirect('view/index');
                        }

                    }

                    $uFn = $this->input->post('userFirstName');
                    $uLn = $this->input->post('userSecondName');
                    $uEA = $this->input->post('userEmailAddress');
                    $uPh = $this->input->post('userPhone');
                    $uDR = $this->input->post('userDateRegistered');
                    $uRG = $this->input->post('userRoleGroup');
                    $uPwd = $this->input->post('userPassword');
                    $uImg = $this->input->post('userImage');


                    $this->form_validation->set_rules('userEmailAddress', 'uEA', 'required');

                    if ($this->form_validation->run()== FALSE) {
                        redirect('view/index');
                        echo"run error";

                    } else {

                        $data = array(
                            'userFirstName' => $uFn,
                            'userSecondName' => $uLn,
                            'userEmailAddress' => $uEA,
                            'userPhone' => $uPh,
                            'userDateRegistered' => $uDR,
                            'userRoleGroup' => $uRG,
                            'userPassword' => $uPwd,
                            'userImage' => $uImg
                        );


                        if ($mode == 'add') {
                            $this->Admin_model->addItems('systemusers', $data, 'Users');

                        } else {
                            $conditions = array('userId' => $userId);
                            $this->Admin_model->editItems('systemusers', $data, $conditions, 'Users');

                        }

                        redirect('view/users');
                    }

                }
                break;



            case "userGroups":
                if ($mode == 'edit') {
                    if (!in_array('48', json_decode($this->userRoles))) {
                       // redirect('view/index');

                    }
                    $uGrId = $this->input->post('uGrId');
                } else {
                    if (!in_array('49', json_decode($this->userRoles))) {
                       // redirect('view/index');
                    }
                }

                $uGrT = $this->input->post('uGrTitle');
                $uGrDesc = $this->input->post('uGrDescription');
                //use the input name rotal roes of the iden inut form
                $uGrRl = $this->input->post('totalRoles');
               ;

                $rolesArray=[];
                for($i=1;$i<=$uGrRl;$i++)
                //keep count of the role counts and maks string of roles
                {
                  $idValueToPick="accId_".$i;
                  if($this->input->post($idValueToPick) !='')
                  {
                      $roleId=$this->input->post($idValueToPick);
                      //add role to the array
                      array_push($rolesArray,$roleId);
                  }
                  sort($rolesArray);
                }

                //encode data to eneble its being saved to db
                $rolesDetails=json_encode($rolesArray);



                $this->form_validation->set_rules('uGrDescription', 'User Group', 'required');
                if ($this->form_validation->run()== FALSE) {
                   redirect('view/index');
                } else {

                    $data = array(
                        'uGrTitle' => $uGrT,
                        'uGrDescription' => $uGrDesc,
                        'uGrRoles' => $rolesDetails
                    );

                    if ($mode == 'edit') {
                        $conditions = array('uGrId' => $uGrId);
                        $this->Admin_model->editItems('usergroups', $data, $conditions, 'usergroups');

                    } else {
                        $this->Admin_model->addItems('usergroups', $data, 'usergroups');

                    }
                    redirect('view/userGroups/');
                }

                break;


            case "clients":
                if ($mode == 'edit') {
                    if (!in_array('9', json_decode($this->userRoles))) {
                        redirect('view/index');

                    }
                    $clientId = $this->input->post('clientId');
                } else {
                    if (!in_array('7', json_decode($this->userRoles))) {
                        redirect('view/index');
                    }
                }

                $clientT = $this->input->post('clientTitle');
                $clientDA = $this->input->post('clientDateAdded');
                $clientAOD = $this->input->post('clientAnyOtherDetails');
                $clientP = $this->input->post('clientPhone');
                $clientE = $this->input->post('clientEmail');



                $this->form_validation->set_rules('clientTitle', 'Client Title', 'required');
                if ($this->form_validation->run()== FALSE) {
                    redirect('view/index');
                } else
                    {

                    $data = array(
                        'clientTitle' => $clientT,
                        'clientDateAdded' => $clientDA,
                        'clientAnyOtherDetails' => $clientAOD,
                        'clientPhone' => $clientP,
                        'clientEmail' => $clientE
                    );


                    if ($mode == 'edit') {
                        $conditions = array('clientId' => $clientId);
                        $this->Admin_model->editItems('client', $data, $conditions, 'clients');

                    } else
                        {
                        $this->Admin_model->addItems('client', $data, 'clients');

                        }
                    redirect('view/clients');
                }

                break;

            case "events":
                if ($mode == 'edit') {
                    if (!in_array('17', json_decode($this->userRoles))) {
                        redirect('view/index');

                    }
                    $eventId = $this->input->post('eventId');
                } else {
                    if (!in_array('15', json_decode($this->userRoles))) {
                        redirect('view/index');
                    }
                }

                $eventT = $this->input->post('eventTitle');
                $eventFD = $this->input->post('eventFullDescription');
                $eventTme = $this->input->post('eventTime');
                $eventDt = $this->input->post('eventDate');


                $this->form_validation->set_rules('eventDate',"ET","required");
                if ($this->form_validation->run()== FALSE) {
                    redirect('view/index');
                } else
                    {

                    $data = array(
                        'eventTitle' => $eventT,
                        'eventFullDescription' => $eventFD,
                        'eventTime' => $eventTme,
                        'eventDate' => $eventDt,
                    );
                    if ($mode == 'edit') {
                        $conditions = array('eventId' => $eventId);
                        $this->Admin_model->editItems('events', $data, $conditions, 'Events');

                    } else
                        {
                        $this->Admin_model->addItems('events', $data, 'Events');

                    }
                    redirect('view/events/');
                }

                break;


            case "payroll":
                if ($mode == 'edit') {
                    if (!in_array('25', json_decode($this->userRoles))) {
                        redirect('view/index');
                    }
                    $payrollId = $this->input->post('payrollId');
                } else {
                    if (!in_array('23', json_decode($this->userRoles))) {
                        redirect('view/index');
                    }
                }

                $payrollEmployeeName = $this->input->post('payrollEmployeeName');
                $payrollDate = $this->input->post('payrollDate');
                $payrollDescription = $this->input->post('payrollDescription');
                $this->form_validation->set_rules("payrollEmployeeName","PEN","required");

                if ($this->form_validation->run() == FALSE) {
                    redirect('view/index');
                } else {
                    $data = array(
                        'payrollEmployeeName' => $payrollEmployeeName,
                        'payrollDate' => $payrollDate,
                        'payrollDescription' => $payrollDescription
                    );

                    if ($mode == 'edit') {
                        $conditions = array('payrollId' => $payrollId);
                        $this->Admin_model->editItems('payroll', $data, $conditions, 'Payroll');
                    } else {
                        $this->Admin_model->addItems('payroll', $data, 'Payroll');

                    }
                    redirect('view/payroll');

                }
                break;

            case "tasks":
                if($mode=="edit"){
                    if(!in_array('45',json_decode($this->userRoles))){
                        redirect('view/index');
                    }
                    $taskId=$this->input->post('taskId');

                }else{
                    if(!in_array('43',json_decode($this->userRoles))){
                        redirect('view/index');
                    }

                }

                $taskTitle = $this->input->post('taskTitle');
                $taskProject = $this->input->post('taskProject');
                $taskStartDate = $this->input->post('taskStartDate');
                $taskEndDate = $this->input->post('taskEndDate');
                $taskStatus= $this->input->post('taskStatus');



                $this->form_validation->set_rules('taskStatus',"ET","required");
                if ($this->form_validation->run()== FALSE) {
                    redirect('view/index');
                } else
                {

                    $data = array(
                        'taskTitle' => $taskTitle,
                        'taskProject' => $taskProject,
                        'taskStartDate' => $taskStartDate,
                        'taskEndDate' => $taskEndDate,
                        'taskStatus' => $taskStatus,
                    );

                    if ($mode == 'edit') {
                        $conditions = array('taskId' => $taskId);
                        $this->Admin_model->editItems('task', $data, $conditions, 'Tasks');

                    } else
                    {
                        $this->Admin_model->addItems('task', $data, 'Tasks');

                    }

                    redirect('view/tasks/');
                }

                break;


            case "accounts":
                if ($mode == 'edit') {
                    if (!in_array('57', json_decode($this->userRoles))) {
                        redirect('view/index');

                    }
                    $accountId = $this->input->post('accountId');
                } else {
                    if (!in_array('55', json_decode($this->userRoles))) {
                        redirect('view/index');
                    }
                }

                $accountAmount=$this->input->post('accountAmount');
                $accountDate=$this->input->post('accountDate');
                $accountProject=$this->input->post('accountProject');
                $accountModeOfPayment=$this->input->post('accountModeOfPayment');
                $accountType=$this->input->post('accountType');




                $this->form_validation->set_rules('accountAmount',"ACCAMT","required");
                if ($this->form_validation->run()== FALSE) {
                    redirect('view/index');
                } else
                {

                    $data = array(
                        'accountAmount' => $accountAmount ,
                        'accountDate' => $accountDate,
                        'accountProject' => $accountProject,
                        'accountType' => $accountType,
                        'accountModeOfPayment'=>$accountModeOfPayment
                    );
                    if ($mode == 'edit') {
                        $conditions = array('accountId' => $accountId);


                        $this->Admin_model->editItems('accounts', $data, $conditions, 'Account');

                    } else
                    {
                        $this->Admin_model->addItems('accounts', $data, 'Account');

                    }
                    redirect('view/accounts/');
                }

                break;





            case "supportTickets":
                if ($mode == 'edit') {
                    if (!in_array('37', json_decode($this->userRoles))) {
                        redirect('view/index');

                    }

                    $ticketId = $this->input->post('ticketId');
                }else {
                    if (!in_array('35', json_decode($this->userRoles))) {
                        redirect('view/index');
                    }
                }



                $ticketNumber=$this->input->post('ticketNumber');
                $ticketProject=$this->input->post('ticketProject');
                $ticketDateOpened=$this->input->post('ticketDateOpened');
                $ticketStatus=$this->input->post('ticketStatus');
                $ticketDateClosed=$this->input->post('ticketStatus');
                $ticketCommentary=$this->input->post('ticketCommentary');

                $this->form_validation->set_rules("ticketProject","TP","required");
                if($this->form_validation->run()==FALSE){
                    redirect('view/index');

                }else{

                    $data=array(

                        'ticketNumber'=>$ticketNumber,
                        'ticketProject'=>$ticketProject,
                        'ticketDateOpened'=>$ticketDateOpened,
                        'ticketStatus'=>$ticketStatus,
                        'ticketDateClosed'=>$ticketDateClosed,
                        'ticketCommentary'=>$ticketCommentary

                    );
                    if($mode=='edit'){
                        $conditions=array('ticketId'=>$ticketId);
                        $this->Admin_model->editItems('supporttickets',$data,$conditions,'Support Tickets');

                    }else{
                        $this->Admin_model->addItems('supporttickets',$data,'Support Tickets');

                    }
                          redirect('view/supportTickets');
                }
                break;


            case "departments":
                 if($mode=='edit') {
                    if (!in_array('13', json_decode($this->userRoles))) {
                        redirect('view/index');
                    }
                    $departmentId = $this->input->post('departmentId');
                }
                else{
                    if(!in_array('11',json_decode($this->userRoles))){
                        redirect('view/index');

                      }
                    }


                $departmentTitle=$this->input->post('departmentTitle');
                $departmentDescription=$this->input->post('departmentDescription');
                $departmentHighestSalary=$this->input->post('departmentHighestSalary');
                $departmentMinimumSalary=$this->input->post('departmentMinimumSalary');

                $this->form_validation->set_rules("departmentTitle","DT","required");
                if($this->form_validation->run()==FALSE){
                    echo "cause run";
                    redirect('view/index');
                }else {


                    $data = array(
                        'departmentTitle' => $departmentTitle,
                        'departmentDescription' => $departmentDescription,
                        'departmentMinimumSalary' => $departmentMinimumSalary,
                        'departmentHighestSalary' => $departmentHighestSalary
                    );

                    if($mode=='edit')
                    {
                        $conditions=array('departmentId'=>$departmentId);
                        $this->Admin_model->editItems('departments',$data,$conditions,'Departments');
                    }else{
                        $this->Admin_model->addItems('departments',$data,'Departments');

                    }
                    redirect('view/departments');
                }

        }

        }



        function delete($form,$id=0){

            $actionTarget=$form."-form_id:".$id;
            $data=array(
                'logDateTime'=>date('Y-m-d H:i:s'),
                'logAction'=>'delete',
                'logActionTarget'=>$actionTarget,
                'logUserId'=>$this->session->userdata('userid'),
                 'logAllData' => json_encode("Delete item id " . $id)

            );


            $this->Admin_model->addItems('logs', $data, 'Log');
            $this->session->set_flashdata('success_msg','successfully updated logs');

        if($form=='staff')
        {
            if (!in_array('5',json_decode($this->userRoles))){
                    redirect('view/index');
                }
                  $data=array('staffId'=>$id);

                $this->Admin_model->deleteItems('staff',$data,'Staff');
                redirect('view/staff');
        }elseif($form=='clients'){

            if(!in_array('10',json_decode($this->userRoles))){
                redirect('view/index');
            }

            $data=array('clientId'=>$id);


            $this->Admin_model->deleteItems('client',$data,'Clients');
            redirect('view/clients');

        }elseif($form=="warehouse"){
        	if(!in_array('63',json_decode($this->userRoles))){
        		redirect('view/index');
			}
        	$data=array('warehouse_Id'=>$id);
        	$this->Admin_model->deleteItems('warehouse',$data,'Warehouse');

		}

       elseif($form=="events")
       {
            if(!in_array('18',json_decode($this->userRoles))){
                redirect('view/index');
            }
            $data=array('eventId'=>$id);
            $this->Admin_model->deleteItems('events',$data,"events");
            redirect('view/events');
        }
        elseif($form=="projects")
        {
            if(!in_array('30',json_decode($this->userRoles))){
                redirect('view/index');
            }

            $data=array('projId'=>$id);

            $this->Admin_model->deleteItems('projects',$data,"Projects");
            redirect('view/projects');
        }

       elseif($form=="departments")
       {
            if(!in_array('14',json_decode($this->userRoles))){
                redirect("view/index");
            }
            $data=array('departmentId'=>$id);
            $this->Admin_model->deleteItems('departments',$data,"Department");
            redirect('view/departments');
        }
        elseif($form=="payroll")
        {
            if(!in_array('26',json_decode($this->userRoles))){
                redirect('view/index');
            }
            $data=array("payrollId"=>$id);


            $this->Admin_model->deleteItems('payroll',$data,"Payroll");
            redirect('view/payroll');

        }
        elseif($form=="tasks")
        {
            if(!in_array('46',json_decode($this->userRoles))){
                redirect('view/index');
            }
            $data=array("taskId"=>$id);


            $this->Admin_model->deleteItems('task',$data,"Task");
            redirect('view/tasks');

        }
        elseif($form=="accounts")
        {
            if(!in_array('58',json_decode($this->userRoles))){
                redirect('view/index');
            }
            $data=array("accountId"=>$id);


            $this->Admin_model->deleteItems('accounts',$data,"Account");
            redirect('view/accounts');

        }

        elseif ($form=="supportTickets")
        {
            if(!in_array('38',json_decode($this->userRoles))){
                redirect('view/index');
            }
            $data=array("ticketId"=>$id);

            $this->Admin_model->deleteItems("supporttickets",$data,"Support Tickets");
            redirect('view/supportTickets');
        }elseif($form=="userGroups")
        {
            if(!in_array("50",json_decode($this->userRoles))){
                redirect('view/index');
            }
            $data=array("uGrId"=>$id);

            $this->Admin_model->deleteItems("usergroups",$data,"User Groups");
            redirect('view/userGroups');
        }


        elseif($form=="users")
        {
            if(!in_array("48",json_decode($this->userRoles))){
                redirect('view/index');
            }
            $data=array("userId"=>$id);
            $this->Admin_model->deleteItems("systemusers",$data,"Users");
            redirect('view/users');
        }


        }

}
