<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<head>
  <?php $this->load->view('common/meta');?>
<body class="hold-transition skin-blue sidebar-mini">
  <div class="wrapper">

    <?php $this->load->view("common/sidebar"); ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <h1>
          Leads <small>Lead List</small>
        </h1>
        <ol class="breadcrumb">
          <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
          <li class="active">Leads</li>
        </ol>
      </section>

    <!-- Main content -->
    <div class="content">
      <div class="row">
        <div class="col-lg-12">
          <form role="form" action="" method="get" id="searchForm">
                 <div class="row"> 
                                <!-- cust code-->
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="customer_code">Customer Code</label>
                                        <input type="text" class="form-control" id="customer_code" name="customer_code" value="<?= $this->input->get('customer_code'); ?>" placeholder="Enter Code">
                                    </div>
                                </div>

                                <!--mobile-->
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="mobile">Mobile No</label>
                                        <input type="text" class="form-control" id="mobile" name="mobile" value="<?= $this->input->get('mobile'); ?>" placeholder="Enter Phone no">
                                    </div>
                                </div>

                                <!-- Start Date -->
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="start_date">Start Date</label>
                                        <input type="date" class="form-control" id="start_date" name="start_date" value="<?= $this->input->get('start_date'); ?>">
                                    </div>
                                </div>

                                <!-- End Date -->
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="end_date">End Date</label>
                                        <input type="date" class="form-control" id="end_date" name="end_date" value="<?= $this->input->get('end_date'); ?>">
                                    </div>
                                </div>

                               <!--lead status-->
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="status">Lead Status</label>
                                        <select  class="form-control" id="status" name="status" value="">
                                          <option value="">--Select--</option>
                                          <option value="Initiated" <?= $_REQUEST['status']== 'Initiated' ? 'Selected' : ''; ?> >Initiated</option>
                                          <option value="Success" <?= $_REQUEST['status']== 'Success' ? 'Selected' : ''; ?>>Success</option>
                                          <option value="Delete" <?= $_REQUEST['status']== 'Delete' ? 'Selected' : ''; ?>>Delete</option>
                                          <option value="Interested" <?= $_REQUEST['status']== 'Interested' ? 'Selected' : ''; ?>>Interested</option>
                                          <option value="Opportunity" <?= $_REQUEST['status']== 'Opportunity' ? 'Selected' : ''; ?>>Opportunity</option>
                                          <option value="Callback" <?= $_REQUEST['status']== 'Callback' ? 'Selected' : ''; ?>>Callback</option>
                                          <option value="Missed" <?= $_REQUEST['status']== 'Missed' ? 'Selected' : ''; ?>>Missed</option>
                                          <option value="Follow Up" <?= $_REQUEST['status']== 'Follow Up' ? 'Selected' : ''; ?>>Follow Up</option>
                                          <option value="Site Visit" <?= $_REQUEST['status']== 'Site Visit' ? 'Selected' : ''; ?>>Site Visit</option>
                                        </select>
                                        
                                    </div>
                                </div>

                                <!--location-->
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="location">Location</label>
                                        <input type="text" class="form-control" id="location" name="location" 
                                        value="<?= $this->input->get('location'); ?>" placeholder="Enter Location name">
                                    </div>
                                </div>

                                <!-- Employee name -->
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="assignees">Assigneed Employee</label>
                                        <select class="form-control select2" name="assignees" id="assignees">
                                            <option value="">--Select Employee--</option>
                                            <?php if (!empty($employee)) {
                                                foreach ($employee as $emp) { ?>
                                                    <option value="<?= $emp['user_id']; ?>" <?= ($this->input->get('assignees') == $emp['user_id']) ? 'selected' : ''; ?>>
                                                        <?= $emp['firstname']; ?> <?= $emp['lastname']." (".$emp['usertype'].")"; ?>
                                                    </option>
                                            <?php } } ?>
                                        </select>
                                    </div>
                                </div>
                                
                                
                                
                                 <!--specification-->
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="specification">Specification</label>
                                        <select class="form-control" id="specification" name="specification">
                                            <option value="">--Select Property Type--</option>
                                            <option value="Plot" <?= isset($_REQUEST['specification']) && $_REQUEST['specification'] == 'Plot' ? 'selected' : ''; ?>>Plot</option>
                                            <option value="Flat" <?= isset($_REQUEST['specification']) && $_REQUEST['specification'] == 'Flat' ? 'selected' : ''; ?>>Flat</option>
                                            <option value="Villa" <?= isset($_REQUEST['specification']) && $_REQUEST['specification'] == 'Villa' ? 'selected' : ''; ?>>Villa</option>
                                            <option value="Duplex" <?= isset($_REQUEST['specification']) && $_REQUEST['specification'] == 'Duplex' ? 'selected' : ''; ?>>Duplex</option>
                                            <option value="Triplex" <?= isset($_REQUEST['specification']) && $_REQUEST['specification'] == 'Triplex' ? 'selected' : ''; ?>>Triplex</option>
                                        </select>

                                        
                                    </div>
                                </div>

                               

                                <!-- Search and Reset Buttons -->
                                <div class="col-md-4 d-flex">
                                    <div class="form-group">&nbsp;<br>
                                        <button type="submit" class="btn bg-navy btn-flat">Search</button>
                                        <a href="<?= site_url("lead"); ?>" class="btn bg-gray btn-flat">Reset</a>
                                    </div>
                                </div>
                        </div>
                  </form>      

            <div class="box" style="margin-top:10px;padding:5px;">
              <div class="box-body">
              <form method="post" action="<?= site_url('lead/reassigne'); ?>" id="reassignForm"> 
                <div class="row">
                 <!--Reassigne Employee -->
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="reassignes">Reassigne Lead</label>
                            <select class="form-control select2" name="reassignes" id="reassignes">
                                <option value="">--Select Employee--</option>
                                <?php if (!empty($employee)) {
                                    foreach ($employee as $emp) { ?>
                                        <option value="<?= $emp['user_id']; ?>" <?= ($this->input->get('reassignes') == $emp['user_id']) ? 'selected' : ''; ?>>
                                            <?= $emp['firstname']; ?> <?= $emp['lastname']." (".$emp['usertype'].")"; ?>
                                        </option>
                                <?php } } ?>
                            </select>
                        </div>
                        
                    </div>

                    <div class="col-md-2">
                        <div class="form-group"><br>
                        <button type="submit" name="reasBtn" value="Submit" class="btn btn-info btn-flat">Reassigne Lead</button>

                        </div>
                    </div>
                </div>
              <div class="card-body">
                <table class="table table-striped table-bordered">
                  <tr>
                    <th><input type="checkbox" name="selectall" class="selectall"></th>
                    <th>Sl No</th>
                    <th>Customer Code</th>
                    <th>Name</th>                    
                    
                    <th>Mobile No.</th>
                    
                    
                    <th>Location</th> 
                    <th>Lead Date</th>
                    <th>Lead Status</th>                   
                    <th>Assigned To</th>                    
                    <th width="200px">Action</th>
                  </tr>
                  <?php if($records){
                    $cnt = 0;
                     for($i=0;$i<count($records);$i++){ 
                      $cnt++;
                  ?>
                      <tr>
                        <th><input type="checkbox" name="enq_id[]" value="<?php echo $records[$i]['enq_id'];?>" class="leadselect"></th>
                        <td><?=$cnt;?></td>
                        <td><?=$records[$i]['customer_code'];?></td>
                        <td><?=$records[$i]['name'];?></td>
                        
                        <td><?=$records[$i]['mobile'];?></td>
                          
                       
                        <td><?= !empty($records[$i]['location']) ? $records[$i]['location'] : '--';?></td>

                        <td><?= !empty($records[$i]['enquiry_date']) ? date("d-M-Y",strtotime($records[$i]['enquiry_date'])) : 'NA';?></td>
                        <td><?=$records[$i]['comp_status'];?></td>
                        <td><?=$records[$i]['employee_firstname'] ." ". $records[$i]['employee_lastname']?></td> 
                                                
                        <td width="200px">
                          <a href="<?=site_url('lead/view_leads/'.$records[$i]['enq_id']);?>" class="btn btn-primary btn-sm">View</a>
                          <a href="<?=site_url('lead/edit_lead/'.$records[$i]['enq_id']);?>" class="btn btn-warning btn-sm">Edit</a>
                          <a href="<?=site_url('lead/delete_lead/'.$records[$i]['enq_id']);?>" class="btn btn-danger btn-sm">Delete</a>
                        </td>
                      </tr>
                  <?php } } ?>
                </table>
              </div>
              <div class="card-footer">
                <?php if($records){echo $sPages; }?>
              </div>
            </form>
            </div>
          </div>
          
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  
  <!-- Main Footer -->
  <?php $this->load->view('common/footer');?>
</div>
<?php $this->load->view('common/script');?>
<script type="text/javascript">
    // Select all checkbox
    $(".selectall").click(function () {
      $(".leadselect").prop('checked', $(this).prop('checked'));
    });

    // Form validation
    $("#reassignForm").submit(function() {
      if ($("#reassignes").val() === "" || $(".leadselect:checked").length === 0) {
        alert("Please select an employee and at least one lead.");
        return false;
      }
    });
  </script>
</body>
</html>