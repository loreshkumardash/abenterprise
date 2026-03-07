<?php $this->load->view("common/meta");?>
<div class="wrapper">

  <?php $this->load->view("common/sidebar");?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Offer Letter
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        
        <div class="col-md-5">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Offer Letter</h3>
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

              <label for="offer_name">Name</label>
              <input type="text" class="form-control" id="offer_name" name="offer_name" placeholder="">
              
                <label for="designation">Designation</label>
              <input type="text" class="form-control" id="designation" name="designation" placeholder="" >

               <label for="offer_location">Location</label>
              <input type="text" class="form-control" id="offer_location" name="offer_location" placeholder="" >

              <label for="gross_salary">Gross Salary</label>
              <input type="number" class="form-control" id="gross_salary" name="gross_salary" placeholder="" >
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
                            <th>Name</th>
                            <th>Designation</th>
                            <th>Location</th>
                            <th>Gross Salary</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody class="studentpaymentdata">
                           <?php if ($offerletter) { for ($i=0; $i < count($offerletter); $i++) {  ?>
                            <tr>
                              <td><?=$i+1;?></td>
                              <td><?=$offerletter[$i]['offer_name'];?></td>
                              <td><?=$offerletter[$i]['designation'];?></td>
                              <td><?=$offerletter[$i]['offer_location'];?></td>
                              <td><?=$offerletter[$i]['gross_salary'];?></td>
                              <td>
                                <a href="<?php echo site_url();?>/document/editofferletter/<?=$offerletter[$i]['offerletter_id'];?>" class="btn btn-warning btn-xs">edit</a>
                               <a href="<?php echo site_url();?>/document/deleteofferletter/<?=$offerletter[$i]['offerletter_id'];?>" onclick="return confirm('Are you sure to delete this?');" class="btn btn-danger btn-xs">delete</a>
                               <a href="<?php echo site_url('document/print_offerletter/'.$offerletter[$i]['offerletter_id']);?>" class="btn btn-primary btn-xs" target=_blank><i class="fa fa-print"></i></a>
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

