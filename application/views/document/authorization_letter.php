<?php $this->load->view("common/meta");?>
<div class="wrapper">

  <?php $this->load->view("common/sidebar");?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Authorization Letter
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Authorization Letter</h3>
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
              <div class="col-md-4 form-group">
                <label for="authorization_to">To The</label>
                <input type="text" class="form-control" id="authorization_to" name="authorization_to" placeholder="">
              </div>
              
              <div class="col-md-4 form-group">
                <label for="sitename">Site Name</label>
                <input type="text" class="form-control" id="sitename" name="sitename" placeholder="" >
              </div>

              <div class="col-md-3 form-group">
                <label for="date">Date</label>
                <input type="date" class="form-control" id="date" name="date" placeholder="" value="<?=date('Y-m-d'); ?>">
              </div>
              <div class="col-md-4 form-group">
                <label for="address">Address</label>
                <input type="text" class="form-control" id="address" name="address" placeholder="" >
              </div>
              <div class="col-md-4 form-group">
                <label for="from_dt">Sub</label>
                <input type="text" class="form-control" id="sub" name="sub" placeholder="" >
              </div>
              <div class="col-md-3 form-group">
                <label for="regards">Regards</label>
                <input type="text" class="form-control" id="regards" name="regards" placeholder="" >
              </div>
              <div class="col-md-11 form-group">
                <label for="description">Description</label>
                <textarea  class="form-control input-md" id="description" name="description" rows="3"></textarea>
              </div>
              
            </div>
            <div class="box-footer">
              <button type="submit" name="submitBtn" value="submit" class="btn btn-primary">Submit</button>
            </div>
            </form>
          </div>
        </div>
        </div>
          </section>
          <div class="row">
        <div class="col-md-12">
          <div class="box-header with-border">
            
            <div class="box-body">

              <div class="nav-tabs-custom">
                  <div class="tab-content">
                      <div class="active tab-pane" id="paymentview">
                        <table id="" class="table table-bordered table-condensed table-striped">
                          <thead>
                          <tr>
                            <th>#Sl</th>
                            <th>To</th>
                            <th>Site name</th>
                            <th>Address</th>
                            <th>Sub</th>
                            <th>Description</th>
                            <th>Regrads</th>
                            <th>Date</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody class="studentpaymentdata">
                          <?php if ($authorization) { for ($i=0; $i < count($authorization); $i++) {  ?>
                            <tr>
                              <td><?=$i+1;?></td>
                              <td><?=$authorization[$i]['authorization_to'];?></td>
                              <td><?=$authorization[$i]['sitename'];?></td>
                              <td><?=$authorization[$i]['address'];?></td>
                              <td><?=$authorization[$i]['sub'];?></td>
                              <td><?=$authorization[$i]['description'];?></td>
                              <td><?=$authorization[$i]['regards'];?></td>
                              <td><?=$authorization[$i]['date'];?></td>
                              <td> 
                               <a href="<?php echo site_url();?>/document/edit_authorization/<?=$authorization[$i]['authorization_id'];?>" class="btn btn-warning btn-xs">edit</a>
                               <a href="<?php echo site_url();?>/document/delete_authorization/<?=$authorization[$i]['authorization_id'];?>" onclick="return confirm('Are you sure to delete this?');" class="btn btn-danger btn-xs">delete</a>
                               <a href="<?php echo site_url('document/print_authorization/'.$authorization[$i]['authorization_id']);?>" class="btn btn-primary btn-xs" target=_blank><i class="fa fa-print"></i></a>
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
  
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <?php $this->load->view("common/footer");?>
</div>
<!-- ./wrapper -->

<?php $this->load->view("common/script");?>

