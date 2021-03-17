
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0 shrink-to-fit=no">
    <meta name="description" content="Enterprise Managemennt System">
    <meta name="author" content="Kiss Devs">

    <title>Mini ERP</title>
    <!-- CSS -->


    <link  href="<?php echo base_url()?>res/css/style2.css" rel="stylesheet" media="all">
    <link href="<?php echo base_url()?>res/vendor/font-awesome-5/css/font" rel="stylesheet" media="all">
    <link href="<?php  echo base_url()?>res/vendor/font-awesome-4.7/css/fontawesome.min.css" rel="stylesheet" media="all">
    <link href="<?php echo base_url()?>res/vendor/font-awesome-5/css/font" rel="stylesheet" media="all">
    <link href="<?php echo base_url()?>res/vendor/font-awesome-5/css/font" rel="stylesheet" media="all">

    <link href="<?php echo base_url(); ?>res/vendor/mdi-font/css/material-design-iconic-font.min.css" rel="stylesheet"
          media="all">

    <!-- Bootstrap -->
    <link href="<?php echo base_url(); ?>res/vendor/bootstrap-4.1/bootstrap.min.css" rel="stylesheet" media="all">

    <!-- Vendor CSS-->
    <link href="<?php echo base_url(); ?>res/vendor/animsition/animsition.min.css" rel="stylesheet" media="all">
    <link href="<?php echo base_url(); ?>res/vendor/bootstrap-progressbar/bootstrap-progressbar-3.3.4.min.css"
          rel="stylesheet" media="all">
    <link href="<?php echo base_url(); ?>res/vendor/wow/animate.css" rel="stylesheet" media="all">
    <link href="<?php echo base_url(); ?>res/vendor/css-hamburgers/hamburgers.min.css" rel="stylesheet" media="all">
    <link href="<?php echo base_url(); ?>res/vendor/slick/slick.css" rel="stylesheet" media="all">
    <link href="<?php echo base_url(); ?>res/vendor/select2/select2.min.css" rel="stylesheet" media="all">
    <link href="<?php echo base_url(); ?>res/vendor/perfect-scrollbar/perfect-scrollbar.css" rel="stylesheet"
          media="all">

    <!-- Main CSS-->


</head>

        <body class="home">
                              <div class="wrapper d-flex flex-row">
                                  <div class="left">
                                      <div class="left-content">
                                                <div class="login-form"><?php if($this->session->flashdata('error_msg'))
                                                    {?>
                                                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                            <button type="button" class="close" data-dismiss="alert"  aria-hidden="true">&times;
                                                            </button>

                                                            <?php echo $this->session->flashdata('error_msg');?>
                                                        </div>
                                                    <?php }
                                                    if ($this->session->flashdata('success_msg'))
                                                    {
                                                        ?>
                                                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close" aria-hidden="true">
                                                            </button>
                                                            <?php echo $this->session->flashdata('success_msg');?>
                                                        </div>

                                                    <?php }?>
                                                </div>
                                    <!--Logo-->
                                                <div class="logo mb-3">
                                                    <img src="<?php echo base_url()?>res/images/logo.png" alt="">
                                                </div>

                                    <form  method='post' action="<?php echo site_url('view/login_action')?>">
                                            <div class="form-group text-left text-light ">
                                                <label for="">Phone Number or Email Address</label>
                                                <input type="text" class="username py-2 text-input" name="username"  placeholder="username" required>
                                                <label for="password">Password</label>
                                                <input type="password" class="password py-2 text-input " name="password"  placeholder='password' required>

                                                <input type="submit" class="btn btn-primary py-2 text-input mt-4" value='LOG IN'>
                                            </div>
                                    </form>


                                    <div class="content py-2">
                                        <a href="<?php echo site_url('view/password_reset')?>" class="">Forgot Password</a>
                                    </div>



                                 </div>
                              </div>


                            <div class="right full-width-image"></div>


                  </div>










<!-- Jquery JS-->
<script src="<?php echo base_url(); ?>res/vendor/jquery-3.2.1.min.js"></script>
<!-- Bootstrap JS-->
<script src="<?php echo base_url(); ?>res/vendor/bootstrap-4.1/popper.min.js"></script>
<script src="<?php echo base_url(); ?>res/vendor/bootstrap-4.1/bootstrap.min.js"></script>
<!-- Vendor JS       -->
<script src="<?php echo base_url(); ?>res/vendor/slick/slick.min.js">
</script>
<script src="<?php echo base_url(); ?>res/vendor/wow/wow.min.js"></script>
<script src="<?php echo base_url(); ?>res/vendor/animsition/animsition.min.js"></script>
<script src="<?php echo base_url(); ?>res/vendor/bootstrap-progressbar/bootstrap-progressbar.min.js">
</script>
<script src="<?php echo base_url(); ?>res/vendor/counter-up/jquery.waypoints.min.js"></script>
<script src="<?php echo base_url(); ?>res/vendor/counter-up/jquery.counterup.min.js">
</script>
<script src="<?php echo base_url(); ?>res/vendor/circle-progress/circle-progress.min.js"></script>
<script src="<?php echo base_url(); ?>res/vendor/perfect-scrollbar/perfect-scrollbar.js"></script>
<script src="<?php echo base_url(); ?>res/vendor/chartjs/Chart.bundle.min.js"></script>
<script src="<?php echo base_url(); ?>res/vendor/select2/select2.min.js">
</script>

<!-- Main JS-->
<script src="<?php echo base_url(); ?>res/js/main.js"></script>
</body>
</html>
