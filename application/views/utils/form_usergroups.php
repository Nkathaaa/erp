<div class="col-lg-6">
    <div class="card" style="width:1200px">
        <div class="card-header" style="width:1200px">


            <small> <?php  echo ucfirst($pageMode)?></small>
            <small> <?php  echo $page_title?></small>
        </div>
        <div class="card-body card-block" style="width:1200px">

            <?php

          $formAction=$pageMode=="edit"?"view/crud/userGroups/edit":"view/crud/userGroups/add";

            $uGrId="";
            $uGrTitle="";
            $uGrDescription="";
            $uGrRoles="";
            $groupRolesArray=[];
          if(isset($uGroup_Info)) {
              $dataRow = $uGroup_Info[0];

              $uGrId = $dataRow->uGrId;
              $uGrTitle = $dataRow->uGrTitle;
              $uGrDescription = $dataRow->uGrDescription;


              if ($dataRow->uGrRoles != '') {
                  $uGrRoles = $dataRow->uGrRoles;
                  $groupRolesArray = json_decode($dataRow->uGrRoles);


              }
          }
            ?>

            <form action="<?php echo site_url($formAction) ?>" method="post" enctype="multipart/form-data"
                  id="userGroupForm" class="form-horizontal">
                <div class="form-group">

                    <div class="col-12">

                        <input type="hidden" id="userGrId" name="userGrId" placeholder="" class="form-control" required
                               value="<?php echo $uGrId ?>">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-12">
                        <label>uGroup Title</label>
                        <input type="text" id="uGrTitle" name="uGrTitle" placeholder="" class="form-control"
                               required="<?php if ($pageMode == 'view') echo 'disabled'; ?>"
                               value="<?php echo $uGrTitle ?>">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-12">
                        <label>uGroup Description</label>
                        <input type="text" name="uGrDescription" id="uGrDescription" placeholder="" class="form-control"
                               required="<?php if ($pageMode == 'view') echo 'disabled'; ?>"
                               value="<?php echo $uGrDescription ?>">
                    </div>
                </div>
                <div class="form-check form-check-inline">
                    <div class="row">
                        <!--Loop through the values in the accessroles table and display a table of roles as checkboxes -->
                        <?php
                        $accId = "";
                        $accType = "";
                        $accTitle = "";

                        if (isset($allRoles)) {
                            echo '<input type="hidden" name="totalRoles" value="' . count($allRoles) . '">';

                            $count = 0;
                            $itemIndexToUse = 0;

                            foreach ($allRoles as $dataRow) {
                                $accId = $dataRow->accId;
                                $accType = $dataRow->accType;
                                $accTitle = $dataRow->accTitle;
                                $count += 1;
                                $itemIdTag = "accId_" . $count


                                ?>


                                <div class="col-md-2" <?php if (!isset($adminMode) || !$adminMode) echo "style='display:none'"; ?>
                                     style="color:#fff;width:1000px; background:
                            <?php
                                     //if statement classifying account types into ADD,READ.UPDATE and DELETE and assigning different color codes to each role
                                     if ($accType == "ADD") {
                                         echo "purple";
                                     } else if ($accType == "READ") {
                                         echo "green";
                                     } else if ($accType == "UPDATE") {
                                         echo "blue";
                                     } else {
                                         echo "red";

                                     }

                                     ?>">
                                    <label>
                                        <input type="checkbox"
                                               name="<?php echo $itemIdTag ?>"
                                               value="<?php echo $accId ?>"

                                            <?php
                                            //Disable checkbox editing if the mode is view
                                            if ($pageMode == 'view') echo "disabled"; ?>


                                            <?php if (in_array($accId, $groupRolesArray)) //Check box if the accId in groupRles Rray defined above
                                            {
                                                echo 'checked';
                                            }
                                            ?>

                                            <?php
                                            // Disable checkbox if the adminMode isnt set or the  usertype isnt admin
                                            if (!isset($adminMode) || !$adminMode) {
                                                echo 'disabled="disabled"';
                                            }
                                            ?>
                                        />


                                        <!--A hidden input that submits values when the checkboxes above are disabled-->
                                        <?php
                                        if (!isset($adminMode) || !$adminMode) {
                                            ?>
                                            <input class="" type="hidden" name="<?php echo $itemIdTag; ?>"
                                                   value="<?php if (in_array($accId, $groupRolesArray)) {
                                                       echo $accId;
                                                   };
                                                   ?>">
                                        <?php }; ?>

                                        <?php if ($accId == 6)
                                            echo "<i style='text-decoration:underline'>$accTitle).</i>"; else echo $accTitle; ?>
                                    </label>

                                </div>


                                <?php
                            }
                        } else {
                            //in the event there are no roles
                            echo "<input type='hidden' name='totalRoles' value='0'>";
                        }

                        ?>

                    </div>

                </div>


                <div class="col-md-12">
                    <br>

                    <div class="form-group">
                        <?php if ($pageMode == "add" || $pageMode == "edit") {
                            if ($pageMode == "add" && in_array("47", json_decode($this->userRoles)))
                                echo '<button type="submit" class="btn btn-danger">Save</button>';
                            else if ($pageMode == "edit" && in_array("49", json_decode($this->userRoles)))
                                echo '<button type="submit" class="btn btn-danger">Save</button>';
                        }
                        ?>
                    </div>




            </form>


            </div>
        </div>
    </div>
</div>