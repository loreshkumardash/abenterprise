<?php $this->load->view("common/meta");?>
<div class="wrapper">

  <?php $this->load->view("common/sidebar");?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Suspension Letter
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Suspension Letter</h3>
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
                <label for="susemp_id">Employee Id</label>
                <input type="text" class="form-control" id="susemp_id" name="susemp_id" placeholder="">
              </div>
              <div class="col-md-3 form-group">
                <label for="susemp_name">Employee Name</label>
                <input type="text" class="form-control" id="susemp_name" name="susemp_name" placeholder="" >
              </div>
              <div class="col-md-2 form-group">
                <label for="suspension_date">Date</label>
                <input type="date" class="form-control" id="suspension_date" name="suspension_date" placeholder="" required value="<?php echo date('Y-m-d') ;?>">
              </div>
              <div class="col-md-2 form-group">
                <label for="rejoin_date">Rejoin Office Form</label>
                <input type="date" class="form-control" id="rejoin_date" name="rejoin_date" placeholder="" required>
              </div>
            
              <div class="col-md-9 form-group">
                <label for="suspension_reason">Reason Of Suspension</label>
                <textarea  class="form-control input-md" id="suspension_reason" name="suspension_reason" rows="2"></textarea>
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
                            <th>#Sl</th>
                            <th>Employee Id</th>
                            <th>Date</th>
                            <th>Employee Name</th>
                            <th>Reason Of Suspension</th>
                            <th>Rejoin Office Form</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody class="studentpaymentdata">
                           <?php if ($suspension) { for ($i=0; $i < count($suspension); $i++) {  ?>
                            <tr>
                              <td><?=$i+1;?></td>
                              <td><?=$suspension[$i]['susemp_id'];?></td>
                              <td><?=$suspension[$i]['suspension_date'];?></td>
                              <td><?=$suspension[$i]['susemp_name'];?></td>
                              <td><?=$suspension[$i]['suspension_reason'];?></td>
                              <td><?=$suspension[$i]['rejoin_date'];?></td>
                              <td>
                                <a href="<?php echo site_url();?>/document/edit_suspension/<?=$suspension[$i]['suspension_id'];?>" class="btn btn-warning btn-xs">edit</a>
                               <a href="<?php echo site_url();?>/document/delete_suspension/<?=$suspension[$i]['suspension_id'];?>" onclick="return confirm('Are you sure to delete this?');" class="btn btn-danger btn-xs">delete</a>
                               <a href="<?php echo site_url('document/print_suspenssion/'.$suspension[$i]['suspension_id']);?>" class="btn btn-primary btn-xs" target=_blank><i class="fa fa-print"></i></a>
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
  $(document).on('keyup','#susemp_id',function(){
    var susemp_id = $(this).val();

    if (susemp_id != '') {
            $.ajax({
                url: '<?=site_url("document/get_employeeDataById");?>',
                data: {employee_id : susemp_id},
                dataType:"HTML",
                type:"POST",
                success:function(data){
                    if (data) {
                      $("#susemp_name").val(data.split('@#@')[0]);
                    }else{

                    }
                    

                }
              });
        }
  });
</script>
</body>
</html>
