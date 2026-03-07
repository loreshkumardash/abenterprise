<?php $this->load->view("common/meta");?>
<div class="wrapper">

  <?php $this->load->view("common/sidebar");?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Payment Receipts
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">

        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">List Cancel Receipts</h3>
            </div>
            <!-- /.box-header -->
            
            <div class="box-body">
              <div class="row">
                <div class="col-md-12">
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
                </div>
                <form role="form" action="<?php echo site_url("payments/download_receipts");?>" method="post" id="searchForm">
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="session_id">Session</label>

                    <select class="form-control " id="session_id" name="session_id">
                      <option value=""></option>
                      <?php if($sessions){ for($i=0;$i<count($sessions);$i++){?>
                      <option value="<?php echo $sessions[$i]['session_id'];?>" <?php //echo $sessions[$i]['active_session'] == 'Active' ? 'selected="selected"' : '';?>><?php echo $sessions[$i]['session_name'];?></option>
                      <?php }}?>
                    </select>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="class_id">Class</label>
                    <select class="form-control " id="class_id" name="class_id">
                      <option value=""></option>
                      <?php if($classes){ for($i=0;$i<count($classes);$i++){?>
                      <option value="<?php echo $classes[$i]['class_id'];?>"><?php echo $classes[$i]['class_name'];?></option>
                      <?php }}?>
                    </select>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="student_id">Student</label>
                    <select class="form-control " id="student_id" name="student_id">
                      <option value="">select</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="created_on_from">Create date from</label>
                    <input type="date" class="form-control" id="created_on_from" name="created_on_from" value="<?php echo set_value("created_on_from");?>">
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="created_on_to">Create date to</label>
                    <input type="date" class="form-control" id="created_on_to" name="created_on_to" value="<?php echo set_value("created_on_to");?>">
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="receipt_no">Receipt No</label>
                    <input type="text" class="form-control" id="receipt_no" name="receipt_no" value="<?php echo set_value("receipt_no");?>">
                  </div>
                </div>
                <div class="col-md-4">
                  <button type="submit" name="submitBtn" value="submit" class="btn bg-navy btn-flat margin" formaction="<?=site_url("payments/list_cancel_receipts");?>" formmethod="get">Search</button>
                  <button type="submit" name="submitBtn" value="submit" class="btn bg-maroon btn-flat margin">Download</button>
                </div>
                  
                </form>
              </div>
              <div class="row">
                <div class="col-md-12" id="dataTablediv">
                  <div class="table-responsive mb-0" data-pattern="priority-columns">
                  <table width="100%" class="table table-condensed table-small-font table-bordered table-striped">
                    <thead>
                    <tr>
                      <th data-priority="1">Receipt No</th>
                      <th data-priority="1">Date</th>
                      <th data-priority="1">Amount</th>
                      <th data-priority="1">Student</th>
                      <th data-priority="1">Class</th>
                      <th data-priority="1">Session</th>
                      <th data-priority="1">Payment Mode</th>
                      <th data-priority="1">Receipt Status</th>
                      <th data-priority="1">Action</th>
                    </tr>
                    </thead>
                    <tbody class="font11">
                    <?php if($records){ for($i=0;$i<count($records);$i++){?>
                    <tr>
                      <td><a href="<?php echo site_url("payments/view_receipt/".$records[$i]['receipt_id']);?>" class="btn bg-maroon btn-flat btn-xs"><?php echo $records[$i]['receipt_no'];?></a></td>
                      <td><?php echo date("d/m/Y g:i A", strtotime($records[$i]['created_on']));?></td>
                      <td><?php echo $records[$i]['total_amount'];?></td>
                      <td><?php echo $records[$i]['student_first_name'].' '.$records[$i]['student_last_name'];?></td>
                      <td><?php echo $records[$i]['class_name'];?></td>
                      <td><?php echo $records[$i]['session_name'];?></td>
                      <td><?php echo $records[$i]['payment_mode'];?></td>
                      <td><?php echo $records[$i]['receipt_status'];?></td>
                      <td>
                        <a href="<?php echo site_url("payments/print_receipt/".$records[$i]['receipt_id']);?>" target="_blank" class="btn btn-primary btn-xs"><i class="fa fa-print"></i></a>
                      </td>
                    </tr>
                    <?php }} ?>
                    </tbody>
                  </table>
                  </div>
                  <?php if($records){echo $sPages;}?>
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
<link href="<?=base_url();?>assets/RWD-Table-Patterns/dist/css/rwd-table.min.css" rel="stylesheet" type="text/css" media="screen">
<script src="<?=base_url();?>assets/RWD-Table-Patterns/dist/js/rwd-table.min.js"></script>
<script type="text/javascript">
    $(function () {
        $('.table-responsive').responsiveTable({
            addDisplayAllBtn: false
        });
    });
</script>
<script type="text/javascript">
  $(document).ready(function(){
    $("#class_id").change(function(e){
      e.preventDefault();
      if($(this).val() != ''){
        $.ajax({
          url: '<?php echo site_url("masters/getStudentListBySessionClass");?>',
          data : {class_id : $(this).val(), session_id : $("#session_id").val()},
          dataType: "HTML",
          type : "POST",
          success: function(data){
            $("#student_id").html(data);
          }
        });
      }else{
        $("#student_id").html('<option value="">select</option>');
      }
    });
  });
</script>
</body>
</html>