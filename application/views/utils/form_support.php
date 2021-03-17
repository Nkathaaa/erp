<div class="col-lg-6">
    <div class="card">
        <div class="card-header">

            <small> <?php  echo ucfirst($pageMode)?></small>
            <small> <?php  echo $page_title?></small>
        </div>
        <div class="card-body card-block">
            <?php
            $formAction= $pageMode == "edit" ?'view/crud/supportTickets/edit':'view/crud/supportTickets/add';
            $ticketId="";
            $ticketNumber="";
            $ticketProject="";
            $ticketDateOpened="";
            $ticketStatus="";
            $ticketDateClosed="";
            $ticketCommentary="";
            if(isset($ticket_Info)){
                $oneRow=$ticket_Info[0];
                $ticketId=$oneRow->ticketId;
                $ticketNumber=$oneRow->ticketNumber;
                $ticketProject=$oneRow->ticketProject;
                $ticketDateOpened=$oneRow->ticketDateOpened;
                $ticketStatus=$oneRow->ticketStatus;
                $ticketDateClosed=$oneRow->ticketDateClosed;
                $ticketCommentary=$oneRow->ticketCommentary;

            }



            ?>
            <form action="<?php echo site_url($formAction)?>" method="post" enctype="multipart/form-data" class="form-horizontal">
                <div class="form-group">
                    <div class="col-12">

                        <input type="hidden" id="ticketId"  name="ticketId" placeholder="" class="form-control" required value="<?php  echo $ticketId ?>"  >
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-12">
                      <label>Ticket Number</label>
                        <input type="text" id="ticketNumber" name="ticketNumber" placeholder="" class="form-control"  required value="<?php  echo $ticketNumber?>">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-12">
                        <label>Ticket Project</label>

                        <select name="ticketProject" id="ticketProject" class="form-control">
                            <option value="">Select</option>


                            <?php

                            if (isset($allProjects)) {

                                foreach ($allProjects as $oneRow) {

                                    ?>
                                    <option value="<?php echo $oneRow->projId; ?>"
                                        <?php if ($ticketProject == $oneRow->projId) echo " selected "; ?> >
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
                        <label>Date Opened</label>
                        <input type="date" id="ticketDateOpened" name="ticketDateOpened" placeholder="" class="form-control" required value="<?php  echo $ticketDateOpened?>">
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-12">
                        <label>Ticket Status</label>
                       <select name="ticketStatus" id="ticketStatus" class="form-control">

                        <option value="ongoing" <?php if(isset($ticketStatus)&& $ticketStatus=='ongoing');?>>Ongoing</option>
                        <option value="complete" <?php if(isset($ticketStatus)&& $ticketStatus=='complete');?>>Complete</option>

                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-12">
                        <label>Date Closed</label>
                        <input type="date" id="ticketDateClosed" name="ticketDateClosed" placeholder="" class="form-control" required value="<?php  echo $ticketDateClosed ?>">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-12">
                        <label>Commentary</label>

                        <input type="text" id="ticketCommentary" name="ticketCommentary" placeholder="" class="form-control" required value="<?php  echo $ticketCommentary ?>">
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