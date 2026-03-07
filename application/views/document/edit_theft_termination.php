<?php $this->load->view("common/meta");?>
<div class="wrapper">

  <?php $this->load->view("common/sidebar");?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Theft Termination Letter
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        
        <div class="col-md-5">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Theft Termination Letter</h3>
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

              <label for="employe_id">Employee Id</label>
              <input type="text" class="form-control" id="employe_id" name="employe_id" placeholder="" value="<?=$termination[0]['employe_id']; ?>">
              
                <label for="theft_date">Date</label>
              <input type="date" class="form-control" id="theft_date" name="theft_date" placeholder="" value="<?=$termination[0]['theft_date']; ?>">

               <label for="theftemp_name">Employee Name</label>
              <input type="text" class="form-control" id="theftemp_name" name="theftemp_name" placeholder="" value="<?=$termination[0]['theftemp_name']; ?>">

              <label for="reason_of_ter">Reason Of Termination</label>
              <textarea class="form-control input-md" id="reason_of_ter" name="reason_of_ter" rows="4"><?=$termination[0]['reason_of_ter']; ?></textarea>
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
  $(document).on('keyup','#employe_id',function(){
    var employe_id = $(this).val();

    if (employe_id != '') {
            $.ajax({
                url: '<?=site_url("document/get_employeeDataById");?>',
                data: {employee_id : employe_id},
                dataType:"HTML",
                type:"POST",
                success:function(data){
                    if (data) {
                      $("#theftemp_name").val(data.split('@#@')[0]);
                    }else{

                    }
                    

                }
              });
        }
  });
</script>
</body>
</html>
