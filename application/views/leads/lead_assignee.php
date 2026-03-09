<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<head>
  <?php $this->load->view('common/meta');?>
<div class="wrapper">

  <!-- Navbar -->

  <!-- /.navbar -->
  <?php $this->load->view('common/sidebar');?>
  <!-- Content Wrapper. Contains page content -->
  <body class="hold-transition skin-blue sidebar-mini">
  <div class="wrapper">

    <?php $this->load->view("common/sidebar"); ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <h1>
          Leads <small>Lead assignee</small>
        </h1>
        <ol class="breadcrumb">
          <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
          <li class="active">Leads</li>
        </ol>
      </section>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="row">
         <div class="col-md-12">
            <?php if ($this->session->flashdata('success')) { ?>
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <strong>Success!</strong> <?php echo $this->session->flashdata('success'); ?>
                </div>
            <?php } if ($this->session->flashdata('error')) { ?>
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <strong>Error!</strong> <?php echo $this->session->flashdata('error'); ?>
                </div>
            <?php } ?>
        </div>
                  
                
          <div class="col-lg-12">
              <div class="box" style="padding:10px;">
                <div class="box-body">
                  


                  
                <?php if($records){?>
                <form method="post">
                <table class="table table-striped table-bordered">
                <tr>
                  <th>#Sl</th>
                  <th>Customer Code</th>
                  <th>Name</th>
                 
                  <th>Mobile No.</th>                   
                  <th>Specification</th>
                  <th>Location</th>
                  <th>Lead Remark</th>
                  
                  <th>Enq Date</th>
                  <th><input type="checkbox" id="select_all"> Select All</th>
                </tr>
                <?php if($records){
                  $cnt = 0;
                   for($i=0;$i<count($records);$i++){ 
                    $cnt++;
                ?>
                    <tr>
                      <td><?=$cnt;?></td>
                      <td><?=$records[$i]['customer_code'];?></td>
                      <td><?=$records[$i]['name'];?></td>
                      
                      <td><?=$records[$i]['mobile'];?></td>
                      <td><?=$records[$i]['specification'];?></td>
                      <td><?=$records[$i]['location'];?></td>
                      <td><?=$records[$i]['enquiry_remark'];?></td>
                     
                      <td><?=date("d-M-Y", strtotime($records[$i]['enquiry_date']));?></td>
                      
                      <td>  
                        <input type="checkbox" name="check[]" class="select_single" value="<?= $records[$i]['enq_id']; ?>">
                      </td>
                    </tr>
                    <?php } } ?>
                  </table>
                <?php echo $sPages; }else{echo 'No records found';}?>

                <div class="row">
                    <div class="col-md-6">
                      <div class="form-group row">
                          <div class="col-md-3"><label for="assignees">Assigned To</label></div>
                          <div class="col-md-9">
                            <select class="form-control select2" name="assignees" value="" id="assignees" >
                              <option value="">--Select--</option>

                              <?php if ($employee) { 
                                     foreach ($employee as $emp) { 
                                      // Check if the user is a channel partner
                                      $isChannelPartner = ($emp['usertype'] == 'Channel Partner') ? 
                                      ' (Channel Partner)' : ' (Employee)'; 
                              ?>
                                  <option value="<?= $emp['user_id']; ?>">
                                      <?= $emp['firstname'] . ' ' . $emp['lastname'] . $isChannelPartner; ?>
                                  </option>
                              <?php } } ?>
                            </select>
                          </div>
                      </div>
                    </div>
                  
                    <div class="col-md-6">                        
                        <div class="form-group row">
                          <div class="col-md-12">
                            <!-- <button type="reset" name="cancelBtn" value="Cancel" class="btn btn-sm btn-warning">Cancel</button> -->
                            <button type="submit" name="submitBtn" value="Submit" class="btn btn-sm btn-primary" onclick="return confirm('Are you sure for assign selected leads?');">Assign Selected</button>
                            <button type="submit" name="deleteBtn" value="Submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure for delete selected leads?');">Delete Selected</button>
                          </div>
                        </div>
                        <div id="error-message" style="color: red; display: none;"></div>
                      </div>
                  </div>
              </form>
            </div>
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
  $("#department_id").change(function(){
    var department_id = $("#department_id").val();
    $.ajax({
      url : '<?=site_url('masters/get_subjectopts_by_department');?>',
      data : {department_id : department_id},
      dataType: 'HTML',
      type:"POST",
      success: function(data){
        $("#subject_id").html(data);
      }
    });
  });


  document.getElementById('select_all').addEventListener('change', function() {
        let checkboxes = document.querySelectorAll('.select_single');
        checkboxes.forEach((checkbox) => {
            checkbox.checked = this.checked;
        });
    });
</script>

<script>
document.getElementById("leadForm").addEventListener("submit", function(event) {
    var assignees = document.getElementById("assignees").value;
    var checkboxes = document.querySelectorAll("input[name='check[]']:checked");
    
    // Check if assignees is selected
    /*if (!assignees) {
        event.preventDefault(); // Prevent form submission
        document.getElementById("error-message").innerText = "Please select an assignee.";
        document.getElementById("error-message").style.display = "block";
        return;
    }*/
    
    // Check if at least one checkbox is checked
    if (checkboxes.length === 0) {
        event.preventDefault(); // Prevent form submission
        document.getElementById("error-message").innerText = "Please select at least one record.";
        document.getElementById("error-message").style.display = "block";
        return;
    }
    
    // Clear error message if validation passes
    document.getElementById("error-message").style.display = "none";
});
</script>
</body>
</html>