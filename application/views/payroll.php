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
                <button class="au-btn au-btn-icon au-btn--green au-btn--small" onclick="location.href='<?php echo site_url('view/payroll/add')?>'">
                    <i class="zmdi zmdi-plus"></i>add new</button>
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
                    <th>EmployeeName </th>
                    <th>Date </th>
                    <th>Description </th>
                </tr>
                </thead>
                <tbody>


                <?php
                if(isset($allPayroll)&&is_array($allPayroll)&&count($allPayroll)>=0){
                    $itemCount=0;
                    foreach ($allPayroll as $dataRow) {
                        $itemCount+=1;
                        $id=$dataRow->payrollId;
                        $payrollEmployeeName=$dataRow->payrollEmployeeName;
                        $payrollDate=$dataRow->payrollDate;
                        $payrollDescription=$dataRow->payrollDescription;

                        $deleteUrl="";
                        $editUrl="";





                        if(isset($userRoles)){

                            if(in_array('25',json_decode($userRoles))){
                                $editUrl=site_url('view/payroll/edit/'.$id);
                            }
                            if(in_array('26',json_decode($userRoles))){
                                $deleteUrl=site_url('view/payroll/delete/'.$id);
                            }
                        }




                        echo "<tr>";
                        echo "<td>".$id."</td>";
                        echo "<td>".$payrollEmployeeName."</td>";
                        echo "<td>".$payrollDate."</td>";
                        echo "<td>".$payrollDescription."</td>";


                        ?>


                        <td>
                            <div class="table-data-feature">

                                <button class="item" data-toggle="tooltip" data-placement="top" title="Edit" onclick="location.href='<?php echo $editUrl?>'">
                                    <i class="zmdi zmdi-edit"></i>
                                </button>
                                <button class="item" data-toggle="tooltip" data-placement="top" title="Delete" onclick="return deleteAlert('<?php echo $deleteUrl?>')"">
                                <i class="zmdi zmdi-delete"></i>
                                </button>
                            </div>
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
