<div class="container">
 <div class="row">
    <div class="col-md-12">
        <!-- DATA TABLE -->
        <h3 class="title-5 m-b-35"><?php echo $page_title?></h3>
        <div class="table-data__tool">
            <div class="table-data__tool-left">
                <div class="rs-select2--light rs-select2--md">
                    <select class="js-select2" name="property">
                        <option selected="selected">All Properties</option>
                        <option value="">Option 1</option>
                        <option value="">Option 2</option>
                    </select>
                    <div class="dropDownSelect2"></div>
                </div>
                <div class="rs-select2--light rs-select2--sm">
                    <select class="js-select2" name="time">
                        <option selected="selected">Today</option>
                        <option value="">3 Days</option>
                        <option value="">1 Week</option>
                    </select>
                    <div class="dropDownSelect2"></div>
                </div>
                <button class="au-btn-filter">
                    <i class="zmdi zmdi-filter-list"></i>filters</button>
            </div>
            <div class="table-data__tool-right">
                <div class="rs-select2--dark rs-select2--sm rs-select2--dark2">
                    <select class="js-select2" name="type">
                        <option selected="selected">Export</option>
                        <option value="">Option 1</option>
                        <option value="">Option 2</option>
                    </select>
                    <div class="dropDownSelect2"></div>
                </div>
            </div>
        </div>
        <div class="table-responsive table-responsive-data2">
            <table class="table table-data2">
                <thead>
                <tr>

                    <th>#</th>
                    <th>Date Time</th>
                    <th>Action</th>
                    <th>User</th>
                    <th>ActionTarget</th>
                    <th>AllData</th>
                </tr>
                </thead>
                <tbody>


                <?php
                if(isset($log_Info)&&is_array($log_Info)&&count($log_Info)>=0){
                    $itemCount=0;
                    foreach ($log_Info as $oneRow) {


                        $id=$oneRow->logId;
                        $logDateTime = $oneRow->logDateTime;
                        $logAction=$oneRow->logAction;
                        $logUserId=$this->Admin_model->getUsers()[0]->userFirstName;
                        $logActionTarget=$oneRow->logActionTarget;
                        $logAllData=$oneRow->logAllData;


                      echo "<tr>";
                        echo "<td>".$id."</td>";
                        echo "<td>".$logDateTime."</td>";
                         echo "<td>".$logAction."</td>";
                         echo "<td>".$logUserId."</td>";
                         echo "<td>".$logActionTarget."</td>";
                         echo "<td>".$logAllData."</td>";
                        ?>


                        <td>

                        </td>
                        <?php
                        echo "</tr>";
                    }
                }
                ?>


                </tbody>
            </table>
        </div>
        <!-- END DATA TABLE -->
    </div>
  </div>
</div>
