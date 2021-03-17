<div class="col-lg-6">
    <div class="card">
        <div class="card-header">

            <small> <?php  echo $pageMode?></small>
        </div>
        <div class="card-body card-block">
            <?php

            $formAction= $pageMode == "edit" ?'view/crud/clients/edit':'view/crud/clients/add';
            $clientId='';
            $clientTitle='';
            $clientEmail='';
            $clientPhone='';
            $clientDateAdded='';
            $clientAnyOtherDetails='';


            if(isset($client_Info)){
                $dataRow=$client_Info[0];
                $clientId=$dataRow->clientId;
                $clientTitle=$dataRow->clientTitle;
                $clientEmail=$dataRow->clientEmail;
                $clientPhone=$dataRow->clientPhone;
                $clientDateAdded=$dataRow->clientDateAdded;
                $clientAnyOtherDetails=$dataRow->clientAnyOtherDetails;

            }
            ?>


            <form action="<?php echo site_url($formAction)?>" method="post" enctype="multipart/form-data" class="form-horizontal">
                <div class="form-group">
                    <div class="col-12">

                        <input type="hidden" id="clientId"  name="clientId" placeholder="" class="form-control" required value="<?php  echo $clientId ?>"  >
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-12">
                       <label>Client Title</label>
                        <input type="text" id="clientTitle" name="clientTitle" placeholder="" class="form-control"  required value="<?php  echo $clientTitle ?>">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-12">
                        <label>Client Email</label>
                        <input type="text" name="clientEmail" id="clientEmail" placeholder="" class="form-control" required value="<?php  echo $clientEmail ?>">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-12">
                        <label>Phone</label>
                        <input type="text" id="clientPhone" name="clientPhone" placeholder="" class="form-control" required value="<?php  echo $clientPhone ?>">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-12">
                        <label>Date Added</label>
                        <input type="date" id="clientDateAdded" name="clientDateAdded" placeholder="" class="form-control" required value="<?php  echo $clientDateAdded ?>">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-12">
                        <label>Any Other Details</label>
                        <input type="text" id="clientAnyOtherDetails" name="clientAnyOtherDetails" placeholder="" class="form-control" required value="<?php  echo $clientAnyOtherDetails ?>">
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