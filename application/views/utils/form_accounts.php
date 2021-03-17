<div class="col-lg-6">
    <div class="card">
        <div class="card-header">

            <small> <?php  echo ucfirst($pageMode)?></small>
            <small> <?php  echo $page_title?></small>
        </div>
        <div class="card-body card-block">
            <?php

            $formAction=$pageMode=="edit"?"view/crud/accounts/edit":"view/crud/accounts/add";
            $accountId="";
            $accountAmount="";
            $accountDate="";
            $accountProject="";
            $accountModeOfPayment="";
            $accountType="";
            if(isset($accounts_Info)){
                $dataRow=$accounts_Info[0];
                $accountId=$dataRow->accountId;
                $accountAmount=$dataRow->accountAmount;
                $accountDate=$dataRow->accountDate;
                $accountProject=$dataRow->accountProject;
                $accountModeOfPayment=$dataRow->accountModeOfPayment;
                $accountType=$dataRow->accountType;
            }

            ?>

            <form action="<?php echo site_url($formAction)?>" method="post" enctype="multipart/form-data" class="form-horizontal">
                <div class="form-group">
                    <div class="col-12">

                        <input type="hidden" id="accountId"  name="accountId" placeholder="" class="form-control" required value="<?php  echo $accountId ?>"  >
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-12">
                        <label>Amount</label>
                        <input type="text" id="accountAmount" name="accountAmount" placeholder="" class="form-control"  required value="<?php  echo $accountAmount ?>">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-12">
                        <label>Date</label>
                        <input type="date" name="accountDate" id="accountDate" placeholder="" class="form-control" required value="<?php  echo $accountDate ?>">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-12">
                        <label>Project</label>
                        <select name="accountProject" id="accountProject" class="form-control">
                            <option value="">Select</option>


                            <?php

                            if (isset($allProjects)) {

                                foreach ($allProjects as $oneRow) {


                                    ?>
                                    <option value="<?php echo $oneRow->projId; ?>"
                                        <?php if ($accountProject == $oneRow->projId) echo " selected "; ?> >
                                        <?php echo $oneRow->projTitle; ?>
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
                        <label>Mode Of Payment</label>
                        <input type="text" id="accountModeOfPayment" name="accountModeOfPayment" placeholder="" class="form-control" required value="<?php  echo $accountModeOfPayment?>">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-12">
                        <label>Account Type</label>
                        <input type="text" id="accountType" name="accountType" placeholder="" class="form-control" required value="<?php  echo $accountType?>">
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