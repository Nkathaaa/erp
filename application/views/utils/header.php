
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0 shrink-to-fit=no">
    <meta name="description" content="Enterprise Managemennt System">
    <meta name="author" content="Kiss Devs">

    <title>Mini ERP</title>
    <!-- CSS -->
    <link  href="<?php echo base_url()?>res/css/font-face.css" rel="stylesheet" media="all">
    <link href="<?php  echo base_url()?>res/vendor/font-awesome-4.7/css/fontawesome.min.css" rel="stylesheet" media="all">
    <link href="<?php echo base_url()?>res/vendor/font-awesome-5/css/font" rel="stylesheet" media="all">
    <link href="<?php echo base_url(); ?>res/vendor/mdi-font/css/material-design-iconic-font.min.css" rel="stylesheet"
          media="all">
    <link href=" https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js" rel="stylesheet" media="all">


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
    <link href="<?php echo base_url(); ?>res/css/theme.css" rel="stylesheet" media="all">

</head>

<body>




<div class="page-wrapper">
    <!-- MENU SIDEBAR-->
    <header class="header-mobile d-block d-lg-none">
        <div class="header-mobile__bar">
            <div class="container-fluid">
                <div class="header-mobile-inner">
                    <a class="logo" href="<?php echo site_url(); ?>">
                        <img src="<?php echo base_url(); ?>res/images/icon/darcat.png" style="height: 50px; width: auto"
                             alt="Darcat"/>
                    </a>
                    <button class="hamburger hamburger--slider" type="button">
                            <span class="hamburger-box">
                                <span class="hamburger-inner"></span>
                            </span>
                    </button>
                </div>
            </div>
        </div>
        <nav class="navbar-mobile">
            <div class="container-fluid">
                <ul class="navbar-mobile__list list-unstyled">

                    <?php
                    //mobile menu; the desktop version is on the 'sidenav' file
                    if (isset($adminMenu)) {
                        //parse and display
                        foreach ($adminMenu as $dataRow) {
                            $mainMenuId = $dataRow->menuId;

                            //ensure this is an side navigation menu
                            if ($dataRow->menuSideNav == "1") {
                                //check if this menu will have a sub menu or not
                                if ($dataRow->menuHasChild == "0") {
                                    ?>
                                    <li>
                                        <a href="<?php if ($dataRow->menuLink != "#") {
                                            echo site_url($dataRow->menuLink);
                                        } else echo "#"; ?>">
                                            <i class="<?php echo $dataRow->menuIconClass; ?>"></i><?php echo $dataRow->menuTitle; ?>
                                        </a>
                                    </li>
                                    <?php
                                } else {
                                    //display a menu followed by its sub menus
                                    ?>
                                    <li class="has-sub">
                                        <a class="js-arrow" href="#">
                                            <i class="<?php echo $dataRow->menuIconClass; ?>"></i><?php echo $dataRow->menuTitle; ?>
                                        </a>
                                        <ul class="navbar-mobile-sub__list list-unstyled js-sub-list">

                                            <?php
                                            //parse
                                            if (isset($adminSubMenu)) {
                                                for ($i = 0; $i < count($adminSubMenu); $i++) {
                                                    //get the enclosed array and parse it to check details
                                                    $oneSubArray = $adminSubMenu[$i];

                                                    foreach ($oneSubArray as $oneRow) {
                                                        $mainMenuFK = $oneRow->subMenuParentFK;
                                                        if ($mainMenuFK == $mainMenuId) {
                                                            //display here
                                                            ?>
                                                            <li>
                                                                <a href="<?php if ($oneRow->subMenuLink != "#") {
                                                                    echo site_url($oneRow->subMenuLink);
                                                                } else echo "javascript:void(0)"; ?>">
                                                                    <?php echo $oneRow->subMenuTitle; ?></a>
                                                            </li>
                                                            <?php
                                                        }
                                                    }
                                                }
                                            }
                                            ?>
                                        </ul>
                                    </li>
                                    <?php
                                }
                            }
                        }
                    }
                    ?>
                </ul>
            </div>
        </nav>
    </header>
    <!-- END HEADER MOBILE-->
    <!-- END MENU SIDEBAR-->

    <!-- PAGE CONTAINER-->
    <div class="page-container2">
        <!-- HEADER DESKTOP-->
        <header class="header-desktop2">
            <div class="section__content section__content--p30">
                <div class="container-fluid">
                    <div class="header-wrap2">
                        <div class="logo d-block d-lg-none">
                            <a href="#">
                                <img src="<?php echo base_url();?>res/images/icon/logowhite.png" alt="KISS DEVS">
                            </a>
                        </div>
                        <div class="header-button2">
                            <div class="header-button-item js-item-menu">
                                <i class="zmdi zmdi-search"></i>
                                <div class="search-dropdown js-dropdown">
                                    <form action="">
                                        <input class="au-input au-input--full au-input--h65" type="text" placeholder="Search for datas &amp; reports..." />
                                        <span class="search-dropdown__icon">
                                                <i class="zmdi zmdi-search"></i>
                                            </span>
                                    </form>
                                </div>
                            </div>

                            <div class="header-button-item mr-0 js-sidebar-btn">
                                <i class="zmdi zmdi-menu"></i>
                            </div>
                            <div class="setting-menu js-right-sidebar d-none d-lg-block">
                                <div class="account-dropdown__body">
                                    <div class="account-dropdown__item">
                                            <a href="<?php echo site_url('view/users/edit/'.$this->session->userdata('userid')); ?>">
                                            <i class="zmdi zmdi-account"></i>Account</a>
                                    </div>
                                    <div class="account-dropdown__item">

                                        <a href="<?php echo site_url('view/signout') ?>">
                                        <i class="zmdi zmdi-power"></i>Logout</a>
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <aside class="menu-sidebar2 js-right-sidebar d-block d-lg-none">
            <div class="logo">
                <a href="#">
                    <img src="images/icon/logo-white.png" alt="Cool Admin" />
                </a>
            </div>
            <div class="menu-sidebar2__content js-scrollbar2">
                <div class="account2">
                    <div class="image img-cir img-120">
                        <img src="images/icon/avatar-big-01.jpg" alt="John Doe" />
                    </div>
                    <h4 class="name">john doe</h4>
                    <a href="#">Sign out</a>
                </div>

            </div>
        </aside>
        <!-- END HEADER DESKTOP-->

        <!-- BREADCRUMB-->
        <section class="au-breadcrumb m-t-75 mb-5">
            <div class="section__content section__content--p30">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="au-breadcrumb-content">
                                <div class="au-breadcrumb-left">
                                    <span class="au-breadcrumb-span"></span>
                                    <p class="breadcrumb-content-custom m-b-35">You are Here : <?php echo $page_title?></p>

                                </div>

                            </div>
                        </div>
                    </div>
                </div>
        </section>
        <!-- END BREADCRUMB-->


