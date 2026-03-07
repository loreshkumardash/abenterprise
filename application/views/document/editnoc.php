<?php $this->load->view("common/meta");?>
<div class="wrapper">

  <?php $this->load->view("common/sidebar");?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        NOC Letter
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        
        <div class="col-md-5">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">NOC Letter</h3>
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

              <label for="emp_id">Employee Id</label>
              <input type="text" class="form-control" id="emp_id" name="emp_id" placeholder="Enter Employee Id" value="<?=$noc[0]['emp_id'];?>">

              <label for="emp_name">Employee Name</label>
              <input type="text" class="form-control" id="emp_name" name="emp_name" placeholder="Employee Name" readonly value="<?=$noc[0]['emp_name'];?>">
              
              <label for="site_name">Site Name</label>
              <input type="text" class="form-control" id="site_name" name="site_name" placeholder="Enter Site Name" value="<?=$noc[0]['site_name'];?>" >

               <label for="form_date">Service From</label>
              <input type="date" class="form-control" id="form_date" name="form_date" placeholder="Enter Employee Id" value="<?=$noc[0]['form_date'];?>">

              <label for="to_date">Service To</label>
              <input type="date" class="form-control" id="to_date" name="to_date" placeholder="Enter Employee Id" value="<?=$noc[0]['to_date'];?>" >
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
  $(document).on('keyup','#emp_id',function(){
    var emp_id = $(this).val();

    if (emp_id != '') {
            $.ajax({
                url: '<?=site_url("document/get_employeeDataById");?>',
                data: {employee_id : emp_id},
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
