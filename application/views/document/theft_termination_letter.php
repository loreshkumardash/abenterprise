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
              <input type="text" class="form-control" id="employe_id" name="employe_id" placeholder="">
              
                <label for="theft_date">Date</label>
              <input type="date" class="form-control" id="theft_date" name="theft_date" placeholder="" value="<?=date('Y-m-d');?>">

               <label for="theftemp_name">Employee Name</label>
              <input type="text" class="form-control" id="theftemp_name" name="theftemp_name" placeholder="" >

              <label for="reason_of_ter">Reason Of Termination</label>
              <textarea  class="form-control input-md" id="reason_of_ter" name="reason_of_ter" rows="4"></textarea>
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
                            <th>Date</th>
                            <th>Name</th>
                            <th>Reason Of Termination</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody class="studentpaymentdata">
                         <?php if ($termination) { for ($i=0; $i < count($termination); $i++) {  ?>
                            <tr>
                              <td><?=$i+1;?></td>
                              <td><?=$termination[$i]['employe_id'];?></td>
                              <td><?=$termination[$i]['theft_date'];?></td>
                              <td><?=$termination[$i]['theftemp_name'];?></td>
                              <td><?=substr($termination[$i]['reason_of_ter'], 0, 30) . '...';?></td>
                              <td>
                                <a href="<?php echo site_url();?>/document/edit_theft_termination/<?=$termination[$i]['termination_id'];?>" class="btn btn-warning btn-xs">edit</a>
                               <a href="<?php echo site_url();?>/document/delete_theft_termination/<?=$termination[$i]['termination_id'];?>" onclick="return confirm('Are you sure to delete this?');" class="btn btn-danger btn-xs">delete</a>
                               <a href="<?=site_url('document/print_theft_termination/'.$termination[$i]['termination_id']);?>" class="btn btn-primary btn-xs" target=_blank><i class="fa fa-print"></i></a>
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
