
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

<body class='new_pass'>

        <div class="text-center reset-content form">

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
            <div class="logo">
                <img src="<?php echo base_url()?>res/images/logo.png" alt="">
            </div>



            <form action="<?php echo site_url('view/create_new_password'); ?>" method="post" autocomplete="off">
                <div class="form-group text-left text-light">
                    <label for="">Username</label>
                    <input type="text" class="text-input py-2" name="userEmail"autocomplete="off"  placeholder="username" required>

                    <label for="password">Password 1</label>
                    <input type="text" class="text-input py-2 " name="pass1" autocomplete="off" required placeholder="password">

                    <label for="password">Password 2</label>
                    <input type="text" class="text-input py-2 " name="pass2" autocomplete="off" placeholder="password" required>



                    <input type="submit" class="btn btn-primary mt-3 btn-block py-2" value='Submit'>
                </div>
            </form>

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
