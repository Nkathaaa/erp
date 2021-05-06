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
                    <button class="au-btn au-btn-icon au-btn--green au-btn--small" onclick="location.href='<?php echo site_url('view/staff/add')?>'">
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

                <?php if($this->session->flashdata('error_msg'))
                {?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <button type="button" class="close" data-dismiss="alert"  aria-hidden="true">&times;
                        </button>

                        <?php echo $this->session->flashdata('error_msg');?>
                    </div>
                <?php }
                if ($this->session->flashdata('success_msg'))
                {
                    ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close" aria-hidden="true">
                        </button>
                        <?php echo $this->session->flashdata('success_msg');?>
                    </div>

                <?php }?>
                <table class="table table-data2" id="table">
                    <thead>
                    <tr>

                        <th>#</th>
                        <th>Salutation</th>
                        <th> Name</th>
                        <th>Department</th>
                        <th>Job Title</th>

                    </tr>
                    </thead>
                    <tbody>


                    <?php
                    if(isset($allStaff)&&is_array($allStaff)&&count($allStaff)>0) {
                        $staffCount = 0;

                        foreach ($allStaff as $dataRow) {
                            $staffCount+=1;

                            $id=$dataRow->staffId;
                            $staffName=$dataRow->staffName;
                            $staffDepartment=$this->Admin_model->getDepartments()[0]->departmentTitle;
                            $staffJobTitle=$dataRow->staffJobTitle;
                            $staffSalutation=$dataRow->staffSalutation;
                            $editUrl="";
                            $deleteUrl="";

                            if(isset($userRoles)){

                                if(in_array('33',json_decode($userRoles))){
                                    $editUrl=site_url('view/staff/edit/'.$id);
                                }

                                if(in_array('34',json_decode($userRoles))){
                                    $deleteUrl=site_url('view/staff/delete/'.$id);

                                }
                            }

                            echo "<tr>";
                            echo "<td>".$id."</td>";
                            echo"<td>".$staffSalutation."</td>";
                            echo "<td>".$staffName."</td>";
                            echo "<td>".$staffDepartment ."</td>";
                            echo"<td>".$staffJobTitle."</td>";





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