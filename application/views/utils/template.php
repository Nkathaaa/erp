
<?php
    /**template is made up of header,fotr and other common navigation **/

    $this->load->view('utils/header');
    $this->load->view('utils/sidenav');

   $this->load->view($page_content);
   $this->load->view('utils/footer');
