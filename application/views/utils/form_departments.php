<div class="col-lg-6">
    <div class="card">
        <div class="card-header">

            <small> <?php  echo ucfirst($pageMode)?></small>
            <small> <?php  echo $page_title?></small>
        </div>
        <div class="card-body card-block">

            <?php
            $formAction=$pageMode=="edit"? "view/crud/departments/edit":"view/crud/departments/add";
            $departmentId="";
            $departmentTitle="";
            $departmentDescription="";
            $departmentMinimumSalary="";
            $departmentHighestSalary="";
            if(isset($department_Info)){
                $dataRow=$department_Info[0];

                $departmentId=$dataRow->departmentId;
                $departmentTitle=$dataRow->departmentTitle;
                $departmentDescription=$dataRow->departmentDescription;
                $departmentMinimumSalary=$dataRow->departmentMinimumSalary;
                $departmentHighestSalary=$dataRow->departmentHighestSalary;


            }


            ?>
            <form action="<?php echo site_url($formAction)?>" method="post" enctype="multipart/form-data" class="form-horizontal">
                <div class="form-group">
                    <div class="col-12">

                        <input type="hidden" id="departmentId"  name="departmentId" placeholder="" class="form-control" required value="<?php  echo $departmentId ?>"  >
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-12">
                        <label>Department Title</label>

                        <input type="text" id="departmentTitle" name="departmentTitle" placeholder="" class="form-control"  required value="<?php  echo $departmentTitle ?>">
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-12">
                        <label>Department Description</label>
                        <input type="text" id="departmentDescription" name="departmentDescription" placeholder="" class="form-control"  required value="<?php  echo $departmentDescription ?>">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-12">
                        <label>Department Minimum Salary</label>
                        <input type="text" name="departmentMinimumSalary" id="departmentMinimumSalary" placeholder="" class="form-control" required value="<?php  echo $departmentMinimumSalary ?>">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-12">
                        <label>Department Highest Salary</label>

                        <input type="text" id="departmentHighestSalary" name="departmentHighestSalary" placeholder="" class="form-control" required value="<?php  echo $departmentHighestSalary?>">
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