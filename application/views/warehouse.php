<div class="container">
  <div class="row">
	  <div class="col-md-12">
      <h3 class="mb-35 title-5" ><?php echo $page_title ?>   </h3>
		  <div class="table-data__tool">
			  <div class="table-data__tool-left">
				  <div class="rs-select2--light rs-select2--md">
					  <select class="js-select2" name="property">
						  <option selected="selected">All Properties </option>
						  <option>option 1</option>
						  <option>option 2</option>


					  </select>
					  <div class="dropDownSelect2"></div>

				  </div>

				  <div class="rs-select2--light rs-select2--sm">
					  <select class="js-select2" name="property">
						  <option selected="selected">Today</option>
						  <option>One Week</option>
						  <option>One Month</option>

					  </select>
					  <div class="dropDownSelect2"> </div>

				  </div>

                 <button class="au-btn-filter"><i class="zmdi zmdi-filter-list" ></i>filters</button>
			  </div>


			  <div class="table-data__tool-right">
				  <button class="au-btn au-btn-icon au-btn--green au-btn--small"
						  onclick="location.href='<?php echo  site_url('view/warehouse/add')?>'"
				          <i class="zmdi zmdi-plus" ></i>add new

				  </button>
				  <div class="rs-select2--dark rs-select2--sm rs-select2--dark2">
					  <select class="js-select2" name="type">
						  <option selected="selected">Export</option>
						  <option>option 1</option>
						  <option>option 2</option>

					  </select>
					  <div class="dropDownSelect2"></div>

				  </div>

			  </div>


		  </div>
		  <div class="table-responsive table-responsive-data2">
               <?php if($this->session->flashdata('error_msg'))

               { ?>

                 <div class="alert alert-danger alert-dismissible  fade show" role="alert">
                    <button type="button" class="close"  data-dismiss="alert" aria-label="Close" aria-hidden="true">

					</button>
					 <?php }
					 echo ($this->session->flashdata('error_msg'))
					 ?>
				 </div>



			  <?php if($this->session->flashdata('success_msg'))

			  { ?>
               <div class="alert alert-success alert-dismissible fade show" role="alert">
				   <button type="button" class="close" data-dismiss="alert" aria-label="Close" aria-hidden="true">

				   </button>
				   <?php }
				   echo ($this->session->flashdata('success_msg'))
				   ?>
			   </div>


		  </div>

		  <table class="table table-data2">
			  <thead>
			  <tr>
				  <th>Warehouse Name</th>
				  <th>Warehouse Co-ordinates</th>
				  <th>Warehouse Full Capacity</th>
				  <th>Warehouse Present Capacity</th>

				  <th>Temperature(optional)</th>
			  </tr>

			  </thead>
			  <tbody>

			  <?php if( isset($allWarehouse) && is_array($allWarehouse)&& count($allWarehouse)>=0)
			  {
                 $itemCount=0;
			  	 foreach($allWarehouse as $dataRow)
			  	 {
			  	      $itemCount+=1;
			  	      $id=$dataRow->warehouse_Id;
                      $wh_Name= $dataRow->warehouse_Name;
                      $wH_Loc=$dataRow->warehouse_Coordinates;
                      $wH_C_Cap=$dataRow->warehouse_Full_Capacity;
                      $wH_A_Cap=$dataRow->warehouse_Present_Capacity;

                      $wH_Temp=$dataRow->warehouse_Temp;
					  $edit_url="";
					  $delete_url="";


          		        if (isset($userRoles))
							 {
								   if (in_array('62', json_decode($userRoles))) {
									   $edit_url = site_url('view/warehouse/edit/' . $id);
								   };
								   if (in_array('63', json_decode($userRoles))) {
									   $delete_url = site_url('view/warehouse/delete/' . $id);
								   }
							   }
          		        echo "<tr>";
          		        echo "<td>".$wh_Name."</td>";
					    echo "<td>".$wH_Loc."</td>";
					    echo "<td>".$wH_C_Cap."</td>";
					    echo "<td>".$wH_A_Cap."</td>";

					   echo "<td>".$wH_Temp."</td>";

					   ?>
					 <td>
					 <div class="table-data-feature">

                       <button class="item" data-toggle="tooltip" data-placement="top" title="Edit" onclick="location.href='<?php echo $edit_url?>'">

                        <i class="zmdi zmdi-edit"></i>
					   </button>

						<button class="item" data-toggle="tooltip" data-placement="top" title="Delete" onclick="return deleteAlert('<?php echo $delete_url?>')">
                        <i class="zmdi zmdi-delete"></i>
						</button>
					 </td>



					 </div>

			  <?php
          		        echo"</tr>";

			  	 }
			  }?>





			  </tbody>

		  </table>

	  </div>


  </div>


</div>
