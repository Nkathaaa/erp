<div class="col-lg-6">
    <div class="card">
        <div class="card-header">

            <small> <?php  echo $pageMode?></small>

        </div>
        <div class="card-body card-block">
            <?php
            $formAction=$pageMode=="edit"?"view/crud/staff/edit":"view/crud/staff/add";

            $id="";
            $staffName="";
            $staffDepartment="";
            $staffJobTitle="";
            $staffSalutation="";

            if(isset($staff_Info)){
                $dataRow=$staff_Info[0];
                $id=$dataRow->staffId;
                $staffName=$dataRow->staffName;
                $staffDepartment=$dataRow->staffDepartment	;
                $staffJobTitle=$dataRow->staffJobTitle;
                $staffSalutation=$dataRow->staffSalutation;


            }




            ?>

            <form action="<?php echo site_url($formAction)?>" method="post" enctype="multipart/form-data" class="form-horizontal">
                <div class="form-group">
                    <div class="col-12">
                        <label>staffSalutation</label>
                        <select name="staffSalutation" id="staffSalutation" class="form-control">
                            <option value="Mr" <?php if(isset($staffSalutation)&& $staffSalutation=='Mr');?>>Mr</option>
                            <option value="Miss" <?php if(isset($staffSalutation)&& $staffSalutation=='Miss');?>>Miss</option>
                            <option value="Mrs" <?php if(isset($staffSalutation)&& $staffSalutation=='Mrs');?>>Mrs</option>

                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-12">

                        <input type="hidden" id="staffId"  name="staffId" placeholder="" class="form-control" required value="<?php  echo $id ?>"  >
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-12">
                        <label>staffName</label>
                        <input type="text" name="staffName" id="staffName" placeholder="" class="form-control" required value="<?php  echo $staffName ?>">
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-12">
                        <label>staffJobTitle</label>
                        <input type="text" name="staffJobTitle" id="staffJobTitle" placeholder="" class="form-control" required value="<?php  echo $staffJobTitle ?>">


                    </div>
                </div>
                <div class="form-group">
                    <div class="col-12">
                        <label>Department</label>

                        <select name="staffDepartment" id="staffDepartment" class="form-control">
                            <option value="">Select</option>


                            <?php

                            if (isset($allDepartments)) {

                                foreach ($allDepartments as $oneRow) {
                                    $departmentId=$oneRow->departmentId;

                                    ?>
                                    <option value="<?php echo $oneRow->departmentId; ?>"
                                        <?php if ($staffDepartment == $oneRow->departmentId) echo " selected "; ?> >
                                        <?php echo $oneRow->departmentTitle; ?>
                                    </option>
                                    <?php
                                }
                            }
                            ?>


                        </select>



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