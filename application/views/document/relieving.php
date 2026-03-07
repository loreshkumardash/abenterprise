<?php $this->load->view("common/meta");?>
<div class="wrapper">

  <?php $this->load->view("common/sidebar");?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Relieving Letter
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        
        <div class="col-md-5">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Relieving Letter</h3>
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

              <label for="relieving_name">Name</label>
              <input type="text" class="form-control" id="relieving_name" name="relieving_name" placeholder="">
              
                <label for="relieving_so">S/O</label>
              <input type="text" class="form-control" id="relieving_so" name="relieving_so" placeholder="" >

               <label for="relieving_designation">Designation</label>
              <input type="text" class="form-control" id="relieving_designation" name="relieving_designation" placeholder="" >

              <label for="from_dt">Form Date</label>
              <input type="date" class="form-control" id="from_dt" name="from_dt" placeholder="" >

              <label for="to_dt">To Date</label>
              <input type="date" class="form-control" id="to_dt" name="to_dt" placeholder="" >
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
                            <th>S/O</th>
                            <th>Designation</th>
                            <th>From Date</th>
                            <th>To Date</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody class="studentpaymentdata">
                          <?php if ($relieving) { for ($i=0; $i < count($relieving); $i++) {  ?>
                            <tr>
                              <td><?=$i+1;?></td>
                              <td><?=$relieving[$i]['relieving_name'];?></td>
                              <td><?=$relieving[$i]['relieving_so'];?></td>
                              <td><?=$relieving[$i]['relieving_designation'];?></td>
                              <td><?=$relieving[$i]['from_dt'];?></td>
                              <td><?=$relieving[$i]['to_dt'];?></td>
                              <td> 
                               <a href="<?php echo site_url();?>/document/editrelieving/<?=$relieving[$i]['relieving_id'];?>" class="btn btn-warning btn-xs">edit</a>
                               <a href="<?php echo site_url();?>/document/deleterelieving/<?=$relieving[$i]['relieving_id'];?>" onclick="return confirm('Are you sure to delete this?');" class="btn btn-danger btn-xs">delete</a>
                               <a href="<?php echo site_url('document/print_relieving/'.$relieving[$i]['relieving_id']);?>" class="btn btn-primary btn-xs" target=_blank><i class="fa fa-print"></i></a>
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

