<?php $this->load->view("common/meta");?>
<div class="wrapper">

  <?php $this->load->view("common/sidebar");?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Termination Letter
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Edit Termination Letter</h3>
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
              <div class="col-md-2 form-group">
                <label for="ter_employee_id">Employee Id</label>
                <input type="text" class="form-control" id="ter_employee_id" name="ter_employee_id" placeholder="" value="<?=$termination[0]['ter_employee_id']; ?>">
              </div>
              <div class="col-md-4 form-group">
                <label for="ter_emp_name">Employee Name</label>
                <input type="text" class="form-control" id="ter_emp_name" name="ter_emp_name" placeholder="" value="<?=$termination[0]['ter_emp_name']; ?>" readonly>
              </div>
              <div class="col-md-2 form-group">
                <label for="ter_date">Date</label>
                <input type="date" class="form-control" id="ter_date" name="ter_date" placeholder="" value="<?=$termination[0]['ter_date']; ?>">
              </div>
              
            <div class="col-md-8 form-group">
              <label for="ter_reason">Reason Of Termination</label>
              <textarea class="form-control input-md" id="ter_reason" name="ter_reason" rows="2" ><?=$termination[0]['ter_reason']; ?></textarea>
            </div>
            </div>
            <div class="box-footer">
              <button type="submit" name="submitBtn" value="submit" class="btn btn-primary">Update</button>
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
  $(document).on('keyup','#ter_employee_id',function(){
    var ter_employee_id = $(this).val();

    if (ter_employee_id != '') {
            $.ajax({
                url: '<?=site_url("document/get_employeeDataById");?>',
                data: {employee_id : ter_employee_id},
                dataType:"HTML",
                type:"POST",
                success:function(data){
                    if (data) {
                      $("#ter_emp_name").val(data.split('@#@')[0]);
                    }else{

                    }
                    

                }
              });
        }
  });
</script>
</body>
</html>
