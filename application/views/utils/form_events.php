<div class="col-lg-6">
    <div class="card">
        <div class="card-header">

            <small> <?php  echo ucfirst($pageMode)?></small>
            <small> <?php  echo $page_title?></small>
        </div>
        <div class="card-body card-block">
            <?php
            $formAction=$pageMode=="edit"?"view/crud/events/edit":"view/crud/events/add";

            $eventId="";
            $eventTitle="";
            $eventDate="";
            $eventTime="";
            $eventFullDescription="";
            if(isset($event_Info)){
                $dataRow=$event_Info[0];
                $eventId=$dataRow->eventId;
                $eventTitle=$dataRow->eventTitle;
                $eventDate=$dataRow->eventDate;
                $eventTime=$dataRow->eventTime;
                $eventFullDescription=$dataRow->eventFullDescription;

            }


            ?>

            <form action="<?php echo site_url($formAction)?>" method="post" enctype="multipart/form-data" class="form-horizontal">
                <div class="form-group">
                    <div class="col-12">

                        <input type="hidden" id="eventId"  name="eventId" placeholder="" class="form-control" required value="<?php  echo $eventId ?>"  >
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-12">
                        <label>Event Title</label>
                        <input type="text" id="eventTitle" name="eventTitle" placeholder="" class="form-control"  required value="<?php  echo $eventTitle ?>">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-12">
                       <label>Event Date</label>
                        <input type="date" name="eventDate" id="eventDate" placeholder="" class="form-control" required value="<?php  echo $eventDate ?>">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-12">
                        <label>Event Time</label>
                        <input type="text" id="eventTime" name="eventTime" placeholder="" class="form-control" required value="<?php  echo $eventTime ?>">
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-12">
                        <label>Event Full Description</label>

                        <input type="text" id="eventFullDescription" name="eventFullDescription" placeholder="" class="form-control" required value="<?php  echo $eventFullDescription ?>">
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