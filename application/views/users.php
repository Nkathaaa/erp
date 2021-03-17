
<div class="container">
<div class="row">
    <div class="col-md-12">
        <!-- DATA TABLE -->
        <h3 class="title-5 mb-35"><?php echo $page_title?></h3>
        <div class="table-data__tool">
            <div class="table-data__tool-left">
                <div class="rs-select2--light rs-select2--md">
                    <select class="js-select2" name="property">
                        <option selected="selected">All Properties</option>
                        <option value="">Option 1</option>
                        <option value="">Option 2</option>
                    </select>
                    <div class="dropDownSelect2"></div>
                </div>
                <div class="rs-select2--light rs-select2--sm">
                    <select class="js-select2" name="time">
                        <option selected="selected">Today</option>
                        <option value="">3 Days</option>
                        <option value="">1 Week</option>
                    </select>
                    <div class="dropDownSelect2"></div>
                </div>
                <button class="au-btn-filter">  <i class="zmdi zmdi-filter-list"></i> filters</button>
            </div>
            <div class="table-data__tool-right">
                <button class="au-btn au-btn-icon au-btn--green au-btn--small"
						onclick="location.href='<?php echo site_url('view/users/add')?>'">
                    <i class="zmdi zmdi-plus"></i>add new
				</button>
                <div class="rs-select2--dark rs-select2--sm rs-select2--dark2">
                    <select class="js-select2" name="type">
                        <option selected="selected">Export</option>
                        <option value="">Option 1</option>
                        <option value="">Option 2</option>
                    </select>
                    <div class="dropDownSelect2"></div>
                </div>
            </div>
        </div>
        <div class="table-responsive table-responsive-data2">

            <?php if($this->session->flashdata('error_msg'))
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
            <table class="table table-data2">
                <thead>
                <tr>

                    <th>#</th>
                    <th>First Name</th>
                    <th>Second Name</th>
                    <th>Phone</th>
                    <th>Email Address</th>
                    <th>Date Registered</th>
                    <th>Image</th>
                    <th>RoleGroup</th>
                    <th>Password</th>
                    <th>Login Status</th>
                    <th>Last Login</th>



                </tr>
                </thead>
                <tbody>


                <?php
                if(isset($allUserData)&&is_array($allUserData)&&count($allUserData)>=0){
                    $itemCount=0;
                    foreach ($allUserData as $dataRow) {
                        $itemCount+=1;

                        $id=$dataRow->userId;
                        $userFirstName=$dataRow->userFirstName;
                        $userSecondName=$dataRow->userSecondName;
                        $userEmailAddress=$dataRow->userEmailAddress;
                        $userPhone=$dataRow->userPhone;
                        $userDateRegistered=$dataRow->userDateRegistered;
                        $userImage=$dataRow->userImage;
                        $userRoleGroup=$dataRow->userRoleGroup;
                        $userPassword=$dataRow->userPassword;
                        $userLoginStatus=$dataRow->userLoginStatus;
                        $userLastLogin=$dataRow->userLastLogin;;
                        $editUrl="";
                        $deleteUrl="";

                        if(isset($userRoles)){

                            if(in_array('41',json_decode($userRoles))){
                                $editUrl=site_url('view/users/edit/'.$id);
                            }
                            if(in_array('42',json_decode($userRoles))){
                                $deleteUrl=site_url('view/users/delete/'.$id);
                            }
                        }

                        echo "<tr>";
                        echo "<td>".$id."</td>";
                        echo "<td>".$userFirstName."</td>";
                        echo "<td>".$userSecondName."</td>";
                        echo "<td>".$userPhone."</td>";
                        echo "<td>".$userEmailAddress."</td>";
                        echo "<td>".$userDateRegistered."</td>";
                        echo "<td>".$userImage."</td>";
                        echo "<td>".$userRoleGroup."</td>";
                        echo "<td>".$userPassword."</td>";
                        echo "<td>".$userLoginStatus."</td>";
                        echo "<td>".$userLastLogin."</td>";

                        ?>


                        <td>
                            <div class="table-data-feature">

                                <button class="item" data-toggle="tooltip" data-placement="top" title="Edit" onclick="location.href='<?php echo $editUrl?>'">
                                    <i class="zmdi zmdi-edit"></i>
                                </button>
                                <button class="item" data-toggle="tooltip" data-placement="top" title="Delete" onclick="return deleteAlert('<?php echo $deleteUrl?>')"">
                                <i class="zmdi zmdi-delete"></i>
                                </button>
                            </div>
                        </td>
                        <?php
                        echo "</tr>";
                    }
                }
                ?>


                </tbody>
            </table>
        </div>
        <!-- END DATA TABLE -->
    </div>
  </div>
</div>
