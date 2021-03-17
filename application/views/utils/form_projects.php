<div class="col-lg-6">
    <div class="card">
        <div class="card-header">

            <small> <?php  echo ucfirst($pageMode)?></small>
            <small> <?php  echo $page_title?></small>

        </div>
        <div class="card-body card-block">
            <?php
            $formAction=$pageMode=="edit" ? "view/crud/projects/edit":"view/crud/projects/add";


            $projId="";
            $projTitle="";
            $projClientId="";
            $projStartDate="";
            $projTentativeEndDate="";
            $projActualEndDate="";
            $projMilestones="";
            $projDeliverables="";
            $projTotalCost="";
            $projCostBreakDown="";
            $projStaffInvolved="";
            if(isset($projects_Info)){
                $dataRow=$projects_Info[0];

                $projId=$dataRow->projId;
                $projTitle=$dataRow->projTitle;
                $projClientId=$dataRow->projClientId;
                $projStartDate=$dataRow->projStartDate;
                $projTentativeEndDate=$dataRow->projTentativeEndDate;
                $projActualEndDate=$dataRow->projActualEndDate;
                $projMilestones=$dataRow->projMilestones;
                $projDeliverables=$dataRow->projDeliverables;
                $projTotalCost=$dataRow->projTotalCost;
                $projCostBreakDown=$dataRow->projCostBreakDown;
                $projStaffInvolved=$dataRow->projStaffInvolved;


            }
            ?>



            <form action="<?php echo site_url($formAction)?>" method="post" enctype="multipart/form-data" class="form-horizontal">
                <div class="form-group">
                    <div class="col-12">

                        <input type="hidden" id="projId"  name="projId" placeholder="" class="form-control" required value="<?php  echo $projId ?>"  >
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-12">
                        <label> Title</label>
                        <input type="text" id="projTitle" name="projTitle" placeholder="" class="form-control"  required value="<?php  echo $projTitle ?>">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-12">
                        <label>Client </label>

                        <select name="projClientId" id="projClientId" class="form-control">
                            <option value="">Select</option>
                            <?php if (isset($allClients))
                            {
                               foreach($allClients as $dataRow)
                               {
                                 $clientId=$dataRow->clientId;
                                 $clientTitle=$dataRow->clientTitle;
                                 ?>

                                   <option value="<?php if($projClientId==$clientId) echo 'selected' ?>">
                                       <?php echo $clientTitle; ?>

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
                        <label>Start Date</label>
                        <input type="date" id="projStartDate" name="projStartDate" placeholder="" class="form-control" required value="<?php  echo $projStartDate ?>">
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-12">
                        <label>Tentative End Date</label>
                        <input type="date" id="projTentativeEndDate" name="projTentativeEndDate" placeholder="" class="form-control" required value="<?php  echo $projTentativeEndDate ?>">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-12">
                        <label>Actual End Date</label>
                        <input type="date" id="projActualEndDate" name="projActualEndDate" placeholder="" class="form-control" required value="<?php  echo $projActualEndDate ?>">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-12">
                        <label>Milestones</label>
                        <input type="text" id="projMilestones" name="projMilestones" placeholder="" class="form-control" required value="<?php  echo $projMilestones ?>">
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-12">
                        <label>Deliverables</label>
                        <input type="text" id="projDeliverables" name="projDeliverables" placeholder="" class="form-control" required value="<?php  echo $projDeliverables ?>">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-12">
                        <label>Total Cost</label>
                        <input type="text" id="projTotalCost" name="projTotalCost" placeholder="" class="form-control" required value="<?php  echo $projTotalCost ?>">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-12">
                        <label>Cost BreakDown</label>
                        <input type="text" id="projCostBreakDown" name="projCostBreakDown" placeholder="" class="form-control" required value="<?php  echo $projCostBreakDown ?>">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-12">
                        <label>Staff Involved</label>
                        <select name="projStaffInvolved" id="projStaffInvolved" class="form-control">
                        <option value="">Select</option>
                        <?php
                        if (isset($allStaff))
                        {
                            foreach($allStaff as $dataRow)
                            {
                                $staffId=$dataRow->staffId;
                                $staffName=$dataRow->staffName;
                                ?>

                                <option value="<?php echo $staffId; ?>"
                                    <?php if($projStaffInvolved==$staffId) echo 'selected'; ?> >
                                    <?php echo $staffName; ?>
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