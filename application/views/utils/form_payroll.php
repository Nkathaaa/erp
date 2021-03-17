<div class="col-lg-6">
    <div class="card">
        <div class="card-header">

            <small> <?php  echo ucfirst($pageMode)?></small>
            <small> <?php  echo $page_title ?></small>
        </div>
        <div class="card-body card-block">
            <?php

           $formAction=$pageMode=="edit"? "view/crud/payroll/edit":"view/crud/payroll/add";

           $payrollId="";
           $payrollEmployeeName="";
            $payrollDate="";
            $payrollDescription="";
           if(isset($payRoll_Info)) {
               $dataRow=$payRoll_Info[0];
               $payrollId=$dataRow->payrollId;
            $payrollEmployeeName=$dataRow->payrollEmployeeName;
            $payrollDate=$dataRow->payrollDate;
            $payrollDescription=$dataRow->payrollDescription;
            }
            ?>

            <form action="<?php echo site_url($formAction)?>" method="post" enctype="multipart/form-data" class="form-horizontal">
                <div class="form-group">
                    <div class="col-12">

                        <input type="hidden" id="payrollId"  name="payrollId" placeholder="" class="form-control" required value="<?php  echo $payrollId ?>"  >
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-12">
                        <label>Employee Name</label>

                        <select name="payrollEmployeeName" id="payrollEmployeeName" class="form-control">
                            <option value="">Select</option>


                            <?php

                            if (isset($allStaff)) {

                                foreach ($allStaff as $oneRow) {
                                    $staffId=$oneRow->staffId;

                                    ?>
                                    <option value="<?php echo $oneRow->staffId; ?>"
                                        <?php if ($payrollEmployeeName == $staffId) echo " selected "; ?> >
                                        <?php echo $oneRow->staffName; ?>
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
                        <label>Payroll Date</label>

                        <input type="date" name="payrollDate" id="payrollDate" placeholder="" class="form-control" required value="<?php  echo $payrollDate ?>">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-12">
                        <label>Payroll Description</label>
                        <input type="text" id="payrollDescription" name="payrollDescription" placeholder="" class="form-control" required value="<?php  echo $payrollDescription?>">
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