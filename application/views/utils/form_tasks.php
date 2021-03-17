<div class="col-lg-6">
    <div class="card">
        <div class="card-header">

            <small> <?php  echo ucfirst($pageMode)?></small>
            <small> <?php  echo $page_title?></small>
        </div>
        <div class="card-body card-block">
            <?php
            $formAction=$pageMode=="edit"?"view/crud/tasks/edit":"view/crud/tasks/add";
                $taskId="";
                $taskTitle="";
                $taskProject="";
                $taskStartDate="";
                $taskEndDate="";
                $taskStatus="";

            if(isset($tasks_Info)){
                $dataRow=$tasks_Info[0];
                $taskId=$dataRow->taskId;
                $taskTitle=$dataRow->taskTitle;
                $taskProject=$dataRow->taskProject;
                $taskStartDate=$dataRow->taskStartDate;
                $taskEndDate=$dataRow->taskEndDate;
                $taskStatus=$dataRow->taskStatus;

            }


            ?>

            <form action="<?php echo site_url($formAction)?>" method="post" enctype="multipart/form-data" class="form-horizontal">
                <div class="form-group">
                    <div class="col-12">

                        <input type="hidden" id="taskId"  name="taskId" placeholder="" class="form-control" required value="<?php  echo $taskId ?>"  >
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-12">
                        <label>Task Title</label>
                        <input type="text" id="taskTitle" name="taskTitle" placeholder="" class="form-control"  required value="<?php  echo $taskTitle ?>">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-12">
                        <label>Task Project</label>
                        <select name="taskProject" id="taskProject" class="form-control">
                            <option value="">Select</option>


                            <?php

                            if (isset($allProjects)) {

                                foreach ($allProjects as $oneRow) {

                                    ?>
                                    <option value="<?php echo $oneRow->projId; ?>"
                                        <?php if ($taskProject == $oneRow->projId) echo " selected "; ?> >
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
                        <label>Task StartDate</label>
                        <input type="date" id="taskStartDate" name="taskStartDate" placeholder="" class="form-control" required value="<?php  echo $taskStartDate ?>">
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-12">
                        <label>Task EndDate</label>

                        <input type="date" id="taskEndDate" name="taskEndDate" placeholder="" class="form-control" required value="<?php  echo $taskEndDate ?>">
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-12">
                        <label>Task Status</label>
                        <select name="taskStatus" id="taskStatus" class="form-control">
                            <option value="ongoing" <?php if(isset($taskStatus)&& $taskStatus=='ongoing');?>>Ongoing</option>
                            <option value="complete" <?php if(isset($taskStatus)&& $taskStatus=='complete');?>>Complete</option>
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