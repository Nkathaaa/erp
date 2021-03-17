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
                <button class="au-btn au-btn-icon au-btn--green au-btn--small" onclick="location.href='<?php echo site_url('view/supportTickets/add')?>'">
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
            <table class="table table-data2">
                <thead>
                <tr>


                    <th>Ticket Number</th>
                    <th>Project</th>
                    <th>Date Opened</th>
                    <th>Status</th>
                    <th>Date Closed</th>
                    <th>Commentary</th>

                </tr>
                </thead>
                <tbody>


                <?php
                 if(isset($allSupportTickets)&& is_array($allSupportTickets)&&count($allSupportTickets)>=0) {

                     $itemCount = 0;
                     foreach ($allSupportTickets as $oneRow) {
                      $itemCount +=1;
                    $id=$oneRow->ticketId;
                    $ticketNumber=$oneRow->ticketNumber;
                    $ticketProject=$this->Admin_model->getProjects()[0]->projTitle;
                    $ticketDateOpened=$oneRow->ticketDateOpened;
                    $ticketStatus=$oneRow->ticketStatus;
                    $ticketDateClosed=$oneRow->ticketDateClosed;
                    $ticketCommentary=$oneRow->ticketCommentary;

                         $editUrl="#";
                         $deleteUrl="#";


                    if(in_array('37',json_decode($this->userRoles))) {
                        $editUrl = site_url('view/supportTickets/edit/'.$id);
                    }
                    if(in_array('38',json_decode($this->userRoles))) {

                        $deleteUrl = site_url('view/supportTickets/delete/'.$id);
                    }



                        echo "<tr>";
                         echo "<td>".$ticketNumber."</td>";
                        echo "<td>".$ticketProject."</td>";
                        echo "<td>".$ticketDateOpened."</td>";
                        echo "<td>".$ticketStatus."</td>";
                        echo "<td>".$ticketDateClosed."</td>";
                        echo "<td>".$ticketCommentary."</td>";




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