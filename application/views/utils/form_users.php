<div class="col-lg-6">
    <div class="card">
        <div class="card-header">

            <small> <?php  echo ucfirst($pageMode)?></small>
            <small> <?php  echo $page_title?></small>
        </div>
        <div class="card-body card-block">
            <?php
            $formAction=$pageMode=='edit'?'view/crud/users/edit':'view/crud/users/add';
				   $userId='';
                   $userFirstName='';
                   $userSecondName='';
                    $userEmailAddress='';
                    $userPhone='';
                    $userDateRegistered='';
                    $userImage='';
                    $userRoleGroup='';
                    $userPassword='';
                    $userLoginStatus='';
                    $userLastLogin='';
            if(isset($user_Info)) {
             $dataRow=$user_Info[0];
             $userId=$dataRow->userId;
                   $userFirstName=$dataRow->userFirstName;
                   $userSecondName=$dataRow->userSecondName;
                    $userEmailAddress=$dataRow->userEmailAddress;
                    $userPhone=$dataRow->userPhone;
                    $userDateRegistered=$dataRow->userDateRegistered;
                    $userImage=$dataRow->userImage;
                    $userRoleGroup=$dataRow->userRoleGroup;
                    $userPassword=$dataRow->userPassword;
                    $userLoginStatus=$dataRow->userLoginStatus;
                    $userLastLogin=$dataRow->userLastLogin;

            }
            ?>

            <form action="<?php echo site_url($formAction)?>" method="post" enctype="multipart/form-data" class="form-horizontal">
                <div class="form-group">
                    <div class="col-12">

                        <input type="hidden" id="userId"  name="userId" placeholder="" class="form-control" required value="<?php  echo $userId ?>"  >
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-12">
                       <label>First Name</label>
                        <input type="text" id="userFirstName" name="userFirstName" placeholder="" class="form-control"  required value="<?php  echo $userFirstName ?>">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-12">
                        <label>Second Name</label>
                        <input type="text" name="userSecondName" id="userSecondName" placeholder="" class="form-control" required value="<?php  echo $userSecondName ?>">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-12">
                        <label>Email Address</label>
                        <input type="text" id="userEmailAddress" name="userEmailAddress" placeholder="" class="form-control" required value="<?php  echo $userEmailAddress ?>">
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-12">
                        <label>Phone</label>
                        <input type="text" id="userPhone" name="userPhone" placeholder="" class="form-control" required value="<?php  echo $userPhone ?>">
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-12">
                        <label>Date Registered</label>
                        <input type="date" id="userDateRegistered" name="userDateRegistered" placeholder="" class="form-control" required value="<?php  echo $userDateRegistered ?>">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-12">
                        <label>Image</label>
                        <input type="file" id="userImage" name="userImage" placeholder="" class="form-control" required value="">
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-12">
                        <label>Role Group</label>
                        <select name="userRoleGroup" id="userRoleGroup" class="form-control">
                            <option value="">Select</option>


                            <?php

                            if (isset($allUserGroups)) {

                                foreach ($allUserGroups as $oneRow) {


                                    ?>
                                    <option value="<?php echo $oneRow->uGrId; ?>"
                                        <?php if ($userRoleGroup == $oneRow->uGrId) echo " selected "; ?> >
                                        <?php echo $oneRow->uGrTitle; ?>
                                    </option>
                                    <?php
                                }
                            }
                            ?>


                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-12">
                        <label>Password</label>
                        <input type="text" id="userPassword" name="userPassword" placeholder="" class="form-control" required value="<?php  echo $userPassword ?>">
                    </div>
                </div>



                <div class="col-md-12">
                    <button type="submit" class="btn btn-danger ">
                        save
                    </button>


                </div>
            </form>
        </div>
    </div>
</div>
