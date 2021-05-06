<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div id="container">
    <h1>Welcome to CodeIgniter!</h1>

    <div id="body">
        <form  method='post' action="<?php  echo site_url('view/smsDetails') ?>" >

            <input type="text" value="" placeholder="Enter phone number or numbers"  name="phoneNumber">
            <input type="text" value="" placeholder="Enter message "  name="phoneMessage">
            <input type="submit">


        </form>

        <button class="item" data-toggle="tooltip" data-placement="top" title="Edit" onclick="location.href='<?php echo site_url('welcome/upload')?>'">
            send
        </button>
    </div>

    <p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds. <?php echo  (ENVIRONMENT === 'development') ?  'CodeIgniter Version <strong>' . CI_VERSION . '</strong>' : '' ?></p>
</div>



<div class="col-lg-6">
    <div class="card">
        <div class="card-header">

            <small> <?php  echo ucfirst($pageMode)?></small>
            <small> <?php  echo $page_title?></small>
        </div>
        <div class="card-body card-block">

            <form action="<?php echo site_url($formAction)?>" method="post" enctype="multipart/form-data" class="form-horizontal">
                <div class="form-group">
                    <div class="col-12">

                        <input type="text" value="" placeholder="Enter phone number or numbers"  name="phoneNumber" class="form-control"  value=""  >
                </div>
                </div>

                <input type="text" value="" placeholder="Enter phone number or numbers"  name="phoneNumber">
                <input type="text" value="" placeholder="Enter message "  name="phoneMessage">
                <input type="submit">


                <div class="form-group">
                    <div class="col-12">
                        <label>Send To</label>
                        <input type="text"  class="form-control"  value=""  placeholder="Enter message "  name="phoneMessage">
                    </div>
                </div>


            </form>
        </div>
    </div>
