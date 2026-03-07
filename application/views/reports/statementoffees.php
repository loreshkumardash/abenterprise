<?php $this->load->view("common/meta");?>
<div class="wrapper">

  <?php $this->load->view("common/sidebar");?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Statement of Fees</h3>
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
                <form role="form" action="" method="post" id="searchForm">
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="session_id">Session</label>
                    <select class="form-control input-sm" id="session_id" name="session_id">
                      <?php if($sessions){ for($i=0;$i<count($sessions);$i++){?>
                      <option value="<?php echo $sessions[$i]['session_id'];?>" <?php echo $sessions[$i]['active_session'] == 'Active' ? 'selected="selected"' : '';?>><?php echo $sessions[$i]['session_name'];?></option>
                      <?php }}?>
                    </select>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="class_id">Class</label>
                    <select class="form-control input-sm" id="class_id" name="class_id" required="required">
                      <option value=""></option>
                      <?php if($classes){ for($i=0;$i<count($classes);$i++){?>
                      <option value="<?php echo $classes[$i]['class_id'];?>" <?php echo set_value('class_id') == $classes[$i]['class_id'] ? 'selected="selected"' : '';?>><?php echo $classes[$i]['class_name'];?></option>
                      <?php }}?>
                    </select>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="class_id">Students</label>
                    <select class="form-control input-sm " id="student_id" name="student_id" required="required">
                      <option value="">select</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="date_from">Date From</label>
                    <input type="date" class="form-control input-sm " id="date_from" name="date_from">
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="date_to">to Date</label>
                    <input type="date" class="form-control input-sm " id="date_to" name="date_to">
                  </div>
                </div>
                <div class="col-md-2" style="padding-top: 25px;">
                  <button type="submit" formaction="<?php echo site_url("reports/statementoffees");?>" name="submitBtn" value="submit" class="btn bg-navy btn-sm btn-flat">Search</button>
                </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- /.content -->
    <?php
    if(isset($receipts) && $receipts){
    ?>
    <section class="invoice">
      <!-- title row -->
      <div class="row">
        <div class="col-xs-12">
          <h2 class="page-header">
            <i class="fa fa-globe"></i> Statement of Fees
            <small class="pull-right">Date: <?=$date_from;?> to <?=$date_to;?></small>
          </h2>
        </div>
        <!-- /.col -->
      </div>
      <!-- info row -->
      <div class="row invoice-info">
        <div class="col-sm-4 invoice-col">
          <address>
            <strong>Student Information</strong><br>
            <?php echo $student[0]['student_first_name'].' '.$student[0]['student_last_name'];?><br>
            <?php echo $student[0]['session_name'];?><br>
            <?php echo $student[0]['class_name'];?><br>
          </address>
        </div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col">
          <address>
            <strong>Parent Information</strong><br>
            <?php echo $student[0]['father_name'];?><br>
            Mobile: <?php echo $student[0]['father_contact_no'];?><br>
            <?php echo $student[0]['mother_name'];?><br>
            Mobile: <?php echo $student[0]['mother_contact_no'];?><br>
            Email: <?php echo $student[0]['student_email'];?>
          </address>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

      <!-- Table row -->
      <div class="row">
        <div class="col-xs-12 table-responsive">
          <table class="table table-striped">
            <thead>
            <tr>
              <th>Sl No</th>
              <th>Date</th>
              <th>Receipt No</th>
              <th>Description</th>
              <th>Amount</th>
            </tr>
            </thead>
            <tbody>
              <?php
              $sl = 1;
              $total = 0;
              for($i=0;$i<count($receipts);$i++){
              $items = db_query("SELECT GROUP_CONCAT(DISTINCT item_type) AS items FROM receipts_items WHERE receipt_id = ".$receipts[$i]['receipt_id']);
              $total = $total + $receipts[$i]['total_amount'];
              ?>
              <tr>
                <td><?=$sl++;?></td>
                <td><?=date("d/m/Y", strtotime($receipts[$i]['receipt_date']));?></td>
                <td><?=$receipts[$i]['receipt_no'];?></td>
                <td><?=$items[0]['items'];?></td>
                <td align="right"><?=$receipts[$i]['total_amount'];?></td>
              </tr>
              <?php 
              }
              ?>
            </tbody>
            <tfoot>
              <tr>
                <th></th>
                <th></th>
                <th></th>
                <th>Grand Total</th>
                <td align="right"><b><?=$total;?></b></td>
              </tr>
            </tfoot>
          </table>
          <p>Amount In Words : <b><?=translateToWords($total);?></b> only</p>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->


      <!-- this row will not appear when printing -->
      <div class="row no-print">
        <div class="col-xs-12">
          <form method="get" action="<?php echo site_url("reports/download_statementoffees");?>" target="_blank">
            <input type="hidden" name="session_id" value="<?=$student[0]['session_id']?>">
            <input type="hidden" name="class_id" value="<?=$student[0]['class_id']?>">
            <input type="hidden" name="student_id" value="<?=$student[0]['student_id']?>">
            <input type="hidden" name="date_from" value="<?=$date_from?>">
            <input type="hidden" name="date_to" value="<?=$date_to?>">

            <button type="submit" name="generatePdf" value="submit" class="btn btn-primary pull-right" style="margin-right: 5px;">
            <i class="fa fa-download"></i> Generate PDF
          </button>
          </form>
          
        </div>
      </div>
    </section>
    <?php 
    }else{
    ?>
    <section class="invoice">
      <div class="row">
        <div class="col-md-12">
          No records found
        </div>
      </div>
    </section>
    <?php
    }
    ?>
  </div>
  <!-- /.content-wrapper -->
  <?php $this->load->view("common/footer");?>
</div>
<!-- ./wrapper -->

<?php $this->load->view("common/script");?>

<script type="text/javascript">

  function searchForm(){
    $.ajax({
      url:"<?php echo site_url('student/liststudents_ajax');?>",
      type:"POST",
      data: $("#searchForm").serialize(),
      dataType:"html",
      success: function(data){
        $('#dataTablediv').html(data);
      }
    });
  }
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