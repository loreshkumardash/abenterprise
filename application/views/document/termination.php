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
              <h3 class="box-title">Termination Letter</h3>
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
                <input type="text" class="form-control" id="ter_employee_id" name="ter_employee_id" placeholder="">
              </div>
              <div class="col-md-4 form-group">
                <label for="ter_emp_name">Employee Name</label>
                <input type="text" class="form-control" id="ter_emp_name" name="ter_emp_name" placeholder="" >
              </div>
              <div class="col-md-2 form-group">
                <label for="ter_date">Date</label>
                <input type="date" class="form-control" id="ter_date" name="ter_date" placeholder="" value="<?php echo date('Y-m-d');?>">
              </div>
              <div class="row">
              </div>
              <div class="col-md-8 form-group">
                <label for="ter_reason">Reason Of Termination</label>
                <textarea  class="form-control input-md" id="ter_reason" name="ter_reason" rows="2"></textarea>
              </div>
            </div>
            <div class="box-footer">
              <button type="submit" name="submitBtn" value="submit" class="btn btn-primary">Submit</button>
            </div>
            </form>
          </div>
        </div>
        
        <div class="col-md-12">
          <div class="box">
            
            <div class="box-body">

              <div class="nav-tabs-custom">
                  <div class="tab-content">
                      <div class="active tab-pane" id="paymentview">
                        <table id="" class="table table-bordered table-condensed table-striped">
                          <thead>
                          <tr>
                            <th width="5%">#Sl</th>
                            <th width="15%">Employee Id</th>
                            <th width="15%">Date</th>
                            <th width="15%">Name</th>
                            <th width="40%">Reason Of Termination</th>
                            <th width="10%">Action</th>
                          </tr>
                        </thead>
                        <tbody class="studentpaymentdata">
                           <?php if ($termination) { for ($i=0; $i < count($termination); $i++) {  ?>
                            <tr>
                              <td  width="5%"><?=$i+1;?></td>
                              <td width="15%"><?=$termination[$i]['ter_employee_id'];?></td>
                              <td width="15%"><?=$termination[$i]['ter_date'];?></td>
                              <td width="15%"><?=$termination[$i]['ter_emp_name'];?></td>
                              <td width="40%"><?=$termination[$i]['ter_reason'];?></td>
                              <td width="10%">
                                <a href="<?php echo site_url();?>/document/edit_termination/<?=$termination[$i]['termination_letter_id'];?>" class="btn btn-warning btn-xs">edit</a>
                               <a href="<?php echo site_url();?>/document/delete_termination/<?=$termination[$i]['termination_letter_id'];?>" onclick="return confirm('Are you sure to delete this?');" class="btn btn-danger btn-xs">delete</a>
                               <a href="<?php echo site_url('document/print_termination_letter/'.$termination[$i]['termination_letter_id']);?>" class="btn btn-primary btn-xs" target=_blank><i class="fa fa-print"></i></a>
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
