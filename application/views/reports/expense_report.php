<?php $this->load->view("common/meta");?>
<div class="wrapper">

  <?php $this->load->view("common/sidebar");?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Reports
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Expense Reports</h3>
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
                <form role="form" action="<?php echo site_url("reports/expense_report");?>" method="post" id="searchForm">
                  <div class="col-md-2">
                    <div class="form-group">
                      <label for="date_from">Date From</label>
                      <input type="date" class="form-control" id="date_from" name="date_from" value="<?php echo set_value("date_from");?>" required="required">
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="form-group">
                      <label for="date_to">To</label>
                      <input type="date" class="form-control" id="date_to" name="date_to" value="<?php echo set_value("date_to");?>" required="required">
                    </div>
                  </div>
                  <div class="col-md-4">
                    <button type="submit" name="submitBtn" value="submit" class="btn bg-navy btn-flat margin">Search</button>
                    <button formaction="<?=site_url("reports/download_expense_report");?>" type="submit" name="downloadBtn" value="submit" class="btn bg-navy btn-flat margin">Download</button>
                  </div>
                </form>
              </div>
              <div class="row">
                <div class="col-md-12" id="dataTablediv">
                  <?php if($records){?>
                  <table id="" class="table table-bordered table-condensed table-striped">
                    <tr>
                      <th>Sl No.</th>
                      <th>Expense Type</th>
                      <th>Insurance Amount </th>
                    </tr>
                    <?php if($records){$j = 1; for($i=0;$i<count($records);$i++){?>
                    <tr>
                      <td><?=$j;?></td>
                      <td><?php if($records[$i]['purpose']=='Salary'){echo $records[$i]['remarks'];}else{echo $records[$i]['expense_name'];}?></td>
                      <td><?php echo $records[$i]['totalamount'];?></td>
                    </tr>
                    <?php $j++;}} ?>
                  </table>
                  <?php }else{echo 'No records found';}?>
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