<div class="col-lg-6">
    <div class="card">
        <div class="card-header">

        </div>
        <div class="card-body card-block">

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





                <div class="col-md-12">
                    <button type="submit" class="btn btn-danger ">
                        save
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>