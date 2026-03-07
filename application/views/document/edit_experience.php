<?php $this->load->view("common/meta");?>
<div class="wrapper">

  <?php $this->load->view("common/sidebar");?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Experience Letter
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        
        <div class="col-md-5">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Experience Letter</h3>
            </div>
            <!-- /.box-header -->
            <form role="form" action="" method="post" enctype="multipart/form-data">
            <div class="box-body">
              <?php
              if($this->session->flashdata('success')){
              ?>
              <div class="alert alert-dismissable alert-success">
              <button type="button" class="close" data-dismiss="alert">&times;</button>
              <strong>Success !</strong> <?php echo $this->session->flashdata('success');?>
              </div>
              <?php
              }
              
              if($this->session->flashdata('error')){
              ?>
              <div class="alert alert-dismissable alert-danger">
              <button type="button" class="close" data-dismiss="alert">&times;</button>
              <strong>Success !</strong> <?php echo $this->session->flashdata('error');?>
              </div>
              <?php
              }
              ?>

              <label for="employee_id">Employee Id</label>
              <input type="text" class="form-control" id="employee_id" name="employee_id" placeholder="" value="<?=$experience[0]['employee_id'] ; ?>">
              
                <label for="experience_date">Date</label>
              <input type="date" class="form-control" id="experience_date" name="experience_date" placeholder="" value="<?=$experience[0]['experience_date'] ; ?>">

               <label for="emp_name">Employee Name</label>
              <input type="text" class="form-control" id="emp_name" name="emp_name" placeholder="" value="<?=$experience[0]['emp_name'] ; ?>">

              <label for="empsite_name">Site Name</label>
              <input type="text" class="form-control" id="empsite_name" name="empsite_name" placeholder="" value="<?=$experience[0]['empsite_name'] ; ?>">
            </div>
            <div class="box-footer">
              <button type="submit" name="submitBtn" value="submit" class="btn btn-primary">Submit</button>
            </div>
            </form>
          </div>
        </div>
        
        
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <?php $this->load->view("common/footer");?>
</div>
<!-- ./wrapper -->

<?php $this->load->view("common/script");?>
<script type="text/javascript">
  $(document).on('keyup','#employee_id',function(){
    var employeeId = $(this).val();

    if (employeeId != '') {
            $.ajax({
                url: '<?=site_url("document/get_employeeDataById");?>',
                data: {employee_id : employeeId},
                dataType:"HTML",
                type:"POST",
                success:function(data){
                    if (data) {
                      $("#emp_name").val(data.split('@#@')[0]);
                    }else{

                    }
                    

                }
              });
        }
  });
</script>
</body>
</html>
