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
              <input type="text" class="form-control" id="emp_id" name="emp_id" placeholder="Enter Employee Id">

              <label for="emp_name">Employee Name</label>
              <input type="text" class="form-control" id="emp_name" name="emp_name" placeholder="Employee Name" readonly>
              
                <label for="site_name">Site Name</label>
              <input type="text" class="form-control" id="site_name" name="site_name" placeholder="Enter Site Name" >

               <label for="form_date">Service From</label>
              <input type="date" class="form-control" id="form_date" name="form_date" placeholder="Enter Employee Id" >

              <label for="to_date">Service To</label>
              <input type="date" class="form-control" id="to_date" name="to_date" placeholder="Enter Employee Id" >
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
                            <th>Employee Id</th>
                            <th>Site Name</th>
                            <th>Service From</th>
                            <th>Service To</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody class="studentpaymentdata">
                          <?php if ($noc) { for ($i=0; $i < count($noc); $i++) {  ?>
                            <tr>
                              <td><?=$i+1;?></td>
                              <td><?=$noc[$i]['emp_id'];?></td>
                              <td><?=$noc[$i]['site_name'];?></td>
                              <td><?=$noc[$i]['form_date'];?></td>
                              <td><?=$noc[$i]['to_date'];?></td>
                              <td>
                                <a href="<?php echo site_url();?>/document/editnoc/<?=$noc[$i]['noc_id'];?>" class="btn btn-warning btn-xs">edit</a>
                               <a href="<?php echo site_url();?>/document/deletenoc/<?=$noc[$i]['noc_id'];?>" onclick="return confirm('Are you sure to delete this?');" class="btn btn-danger btn-xs">delete</a>
                               <a href="<?php echo site_url('document/print_noc/'.$noc[0]['noc_id']);?>" class="btn btn-primary btn-xs" target=_blank><i class="fa fa-print"></i></a>
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
