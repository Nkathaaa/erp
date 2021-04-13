<div class="col-lg-6">
	<div class="card">

        <?php
		$action= $pageMode== 'edit' ?'view/crud/warehouse/edit': 'view/crud/warehouse/add';
		$wH_Id='';
		$wH_Name='';
		$wH_Loc='';
		$wH_C_Cap='';
		$wH_A_Cap='';
		$wH_Desc='';
		$wH_Temp='';
		if (isset($warehouse_Info))


		{

			    $dataRow=$warehouse_Info[0];
			    $wH_Id=$dataRow->warehouse_Id;
				$wH_Name = $dataRow->warehouse_Name;
				$wH_Loc = $dataRow->warehouse_Coordinates;
				$wH_C_Cap = $dataRow->warehouse_Full_Capacity;
				$wH_A_Cap = $dataRow->warehouse_Present_Capacity;

				$wH_Temp = $dataRow->warehouse_Temp;

		}
		?>


		<div class="card-header">
			<small> </small>
		</div>

		<div class="card-body">
			<form action="<?php echo site_url($action)?>" method="post" enctype="multipart/form-data" class="form-horizontal">

				<div class="form-group">
					<div class="col-12">
						<input type="hidden" class="form-control" value="" required value="<?php echo $wH_Id ?>" name="wH_Id" id="wH_Id"  >
					</div>
				</div>

				<div class="form-group">
					<div class="col-12">
						<label>Warehouse Name</label>
						<input type="text" class="form-control" name="wH_Name" id="wH_Name"  required value="<?php echo $wH_Name ?>">
					</div>
				</div>




				<div class="form-group">
					<div class="col-12">
						<label>Warehouse Location</label>
						<input type="text" class="form-control" name="wH_Loc" id="wH_Loc" placeholder="" required value="<?php echo $wH_Loc ?>">
					</div>
				</div>

				<div class="form-group">
					<div class="col-12">
						<label>Warehouse Maximum Capacity</label>
						<input type="text" class="form-control" name="wH_A_Cap" id="wH_A_Cap" placeholder="" required value="<?php echo $wH_C_Cap?>">
					</div>
				</div>



				<div class="form-group">
					<div class="col-12">
						<label>Warehouse Present Capacity</label>
						<input type="text" class="form-control" name="wH_C_Cap" id="wH_C_Cap" placeholder="" required value="<?php echo $wH_A_Cap ?>">
					</div>
				</div>

				<div class="form-group">
					<div class="col-12">
						<label>Temperature(optional)</label>
						<input type="text" class="form-control" name="wH_Temp" id="wH_Temp" placeholder="" required value="<?php echo $wH_Temp ?>">
					</div>
				</div>


				<button class="col-md-12">
					<button type="submit" class="btn btn-danger" >Save</button>
				</div>


			</form>
		</div>


	</div>

</div>
