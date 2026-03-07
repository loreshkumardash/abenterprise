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
              <input type="text" class="form-control" id="employee_id" name="employee_id" placeholder="">
              
                <label for="experience_date">Date</label>
              <input type="date" class="form-control" id="experience_date" name="experience_date" placeholder="" value="<?php echo date('Y-m-d'); ?>">

               <label for="emp_name">Employee Name</label>
              <input type="text" class="form-control" id="emp_name" name="emp_name" placeholder="" readonly>

              <label for="empsite_name">Site Name</label>
              <input type="text" class="form-control" id="empsite_name" name="empsite_name" placeholder="" >
            </div>
            <div class="box-footer">
              <button type="submit" name="submitBtn" value="submit" class="btn btn-primary">Submit</button>
            </div>
            </form>
          </div>
        </div>
        
        <div class="col-md-7">
          <div class="box">
            
            <div class="box-body">

              <div class="nav-tabs-custom">
                  <div class="tab-content">
                      <div class="active tab-pane" id="paymentview">
                        <table id="" class="table table-bordered table-condensed table-striped">
                          <thead>
                          <tr>
                            <th>#Sl</th>
                            <th>Employee ID</th>
                            <th>Employee Name</th>
                            <th>Site Name</th>
                            <th>Date</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody class="studentpaymentdata">
                           <?php if ($experience) { for ($i=0; $i < count($experience); $i++) {  ?>
                            <tr>
                              <td><?=$i+1;?></td>
                              <td><?=$experience[$i]['employee_id'];?></td>
                               <td><?=$experience[$i]['emp_name'];?></td>
                               <td><?=$experience[$i]['empsite_name'];?></td>
                              <td><?=$experience[$i]['experience_date'];?></td>
                             
                              
                              <td>
                                <a href="<?php echo site_url();?>/document/edit_experience/<?=$experience[$i]['experience_letter_id'];?>" class="btn btn-warning btn-xs">edit</a>
                               <a href="<?php echo site_url();?>/document/delete_experience/<?=$experience[$i]['experience_letter_id'];?>" onclick="return confirm('Are you sure to delete this?');" class="btn btn-danger btn-xs">delete</a>
                               <a href="<?php echo site_url('document/print_experience_letter/'.$experience[$i]['experience_letter_id']);?>" class="btn btn-primary btn-xs" target=_blank><i class="fa fa-print"></i></a>
                              </td> 
                            </tr>
                             <?php }} ?>  
                        </tbody>
                          
                        </table>
                      </div>
                  </div>
              </div>
            </div>
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



