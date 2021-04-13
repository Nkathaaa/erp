<div class="col-lg-6">
    <div class="card">
        <div class="card-header">

            <small> <?php  echo ucfirst($pageMode)?></small>
            <small> <?php  echo $page_title?></small>
        </div>
        <div class="card-body card-block">
            <?php
            $formAction=$pageMode=="edit"?"view/crud/sms/edit":"view/crud/sms/add";

            $smsId="";
            $sendTo="";
            $sendFrom="";

            if(isset($sms_Info)){
                $dataRow=$sms_Info[0];
                $smsId=$dataRow->smsIdId;
                $sendTo=$dataRow->sendTo;
                $sendFrom=$dataRow->sendFrom;
                $message=$dataRow->message;

            }


            ?>

            <form action="<?php echo site_url($formAction)?>" method="post" enctype="multipart/form-data" class="form-horizontal">
                <div class="form-group">
                    <div class="col-12">

                        <input type="hidden" id="smsId"  name="smsId" placeholder="" class="form-control" required value="<?php   ?>"  >
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-12">
                        <label>Send To</label>
                        <input type="text" id="sendTo" name="sendTo" placeholder="" class="form-control"  required value="<?php   ?>">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-12">
                        <label>Event Date</label>
                        <input type="text" name="sendFrom" id="sendFrom" placeholder="" class="form-control" required value="<?php    ?>">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-12">
                        <label>Text Content</label>
                        <input type="text" id="message" name="message" placeholder="" class="form-control" required value="<?php  ?>">
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