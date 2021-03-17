

    <aside class="menu-sidebar2">
        <div class="logo">
            <a href="#">
                <img src="<?php echo base_url();?>res/images/icon/logowhite.png" alt="KISS DEVS">
            </a>
        </div>


        <div class="menu-sidebar2__content js-scrollbar1">
            <div class="account2">

                <div class="image img-cir img-120">
                    <img src="<?php echo base_url(); ?>res/images/icon/she.jpg" >
                </div>
                <h4 class="name"><?php echo $this->session->userdata('username') ?></h4>
                <a href="<?php echo site_url('view/signout') ?>">
                <i class="zmdi zmdi-power"></i>Logout</a>


            </div>
            <nav class="navbar-sidebar2">
                <ul class="list-unstyled navbar__list">


                <?php

                if(isset($adminMenu)) {
                    foreach ($adminMenu as $oneRow) {


                        if ($oneRow->menuSideNav == '1') {
                            if ($oneRow->menuHasChild == '0') {
                                ?>
                                <li class="has-sub">
                                    <a href="<?php
                                    if ($oneRow->menuLink  !='#')
                                    {
                                        echo site_url($oneRow->menuLink);
                                    } else
                                        echo "#"; ?>">
                                        <i class="<?php echo $oneRow->menuIconClass; ?>"></i><?php echo $oneRow->menuTitle; ?>
                                    </a>
                                </li>
                                <?php
                            } else {
                                ?>
                                <!--<li class="active has-sub">-->
                                <li class="active has-sub">
                                    <a class="js-arrow" href="#">
                                        <i class="<?php echo $oneRow->menuIconClass; ?>"></i><?php echo $oneRow->menuTitle; ?>

                                    </a>
                                    <ul class="list-unstyled navbar__sub-list js-sub-list">

                                        <?php
                                        if (isset($adminsubmenu)) {
                                            for ($i = 0; $i <count($adminsubmenu); $i++) {
                                                $submenuArray = $adminsubmenu[$i];
                                                foreach ($submenuArray as $oneRow) {
                                                    $submenuid = $oneRow->subMenuParentFk;
                                                    if ($submenuid == $mainMenuId) { ?>
                                                        <li>
                                                            <a href="<?php
                                                            if ($oneRow->subMenuLink != '#')
                                                            {
                                                                echo site_url($oneRow->subMenuLink);
                                                            } else
                                                                echo "javascript:void(0)"; ?>">
                                                                <?php echo $oneRow->subMenuTitle ?>
                                                            </a>
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
            </nav>
        </div>
    </aside>
    <!-- END MENU SIDEBAR-->

    <!-- PAGE CONTAINER-->
    <div class="page-container2">
        <!-- HEADER DESKTOP-->

            <div class="section__content section__content--p30">
                <div class="container-fluid">



                            <div class="setting-menu js-right-sidebar d-none d-lg-block">
                                <div class="account-dropdown__body">
                                    <div class="account-dropdown__item">

                                        <a href="<?php echo site_url('view/users/edit/'.$this->session->userdata('userid')); ?>">
                                            <i class="zmdi zmdi-account"></i>Account</a>
                                    </div>
                                    <div class="account-dropdown__item">

                                        <a href="<?php echo site_url('view/signout'); ?>">
                                            <i class="zmdi zmdi-power"></i>Logout</a>
                                    </div>


                                </div>
                            </div>



                </div>
            </div>
        </div>

    <aside class="menu-sidebar2 js-right-sidebar d-block d-lg-none">
        <div class="logo">
            <a href="#">
                <img src="<?php echo base_url();?>res/images/icon/logowhite.png" alt="tt">
            </a>
        </div>
        <div class="menu-sidebar2__content js-scrollbar2">
            <div class="account2">
                <div class="image img-cir img-120">
                    <img src="<?php echo base_url(); ?>res/images/icon/she.jpg" >
                </div>

                <h4 class="name"><?php echo $this->session->userdata('username') ?></h4>
                <a href="<?php echo site_url('view/signout') ?>">
                <i class="zmdi zmdi-power"></i>Logout</a>
            </div>
            <nav class="navbar-sidebar2">
                <ul class="list-unstyled navbar__list">


                    <?php

                    if(isset($adminMenu)) {
                        foreach ($adminMenu as $oneRow) {


                            if ($oneRow->menuSideNav == '1') {
                                if ($oneRow->menuHasChild == '0') {
                                    ?>
                                    <li class="active has-sub">
                                        <a href="<?php
                                        if ($oneRow->menuLink  !='#')
                                        {
                                            echo site_url($oneRow->menuLink);
                                        } else
                                            echo "#"; ?>">
                                            <i class="<?php echo $oneRow->menuIconClass; ?>"></i><?php echo $oneRow->menuTitle; ?>
                                        </a>
                                    </li>
                                    <?php
                                } else {
                                    ?>
                                    <li class="active has-sub">
                                        <a class="js-arrow" href="#">
                                            <i class="<?php echo $oneRow->menuIconClass; ?>"></i><?php echo $oneRow->menuTitle; ?>

                                        </a>
                                        <ul class="list-unstyled navbar__sub-list js-sub-list">

                                            <?php
                                            if (isset($adminsubmenu)) {
                                                for ($i = 0; $i <count($adminsubmenu); $i++) {
                                                    $submenuArray = $adminsubmenu[$i];
                                                    foreach ($submenuArray as $oneRow) {
                                                        $submenuid = $oneRow->subMenuParentFk;
                                                        if ($submenuid == $mainMenuId) { ?>
                                                            <li>
                                                                <a href="<?php
                                                                if ($oneRow->subMenuLink != '#')
                                                                {
                                                                    echo site_url($oneRow->subMenuLink);
                                                                } else
                                                                    echo "javascript:void(0)"; ?>">
                                                                    <?php echo $oneRow->subMenuTitle ?>
                                                                </a>
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
            </nav>
        </div>
    </aside>
        <!-- END HEADER DESKTOP-->



