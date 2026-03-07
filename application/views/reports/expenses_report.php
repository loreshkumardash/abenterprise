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
                
                <form role="form" action="<?php echo site_url("reports/expenses_report");?>" method="post" id="searchForm">
                  <div class="col-md-2">
                    <div class="form-group">
                      <label for="date_from">Date From</label>
                      <input type="date" class="form-control" id="date_from" name="date_from" value="<?php echo set_value("date_from");?>" >
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="form-group">
                      <label for="date_to">To</label>
                      <input type="date" class="form-control" id="date_to" name="date_to" value="<?php echo set_value("date_to");?>" >
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="form-group">
                      <label for="date_to">Expense Type</label>
                      <select class="form-control" id="category" name="category" >
                        <option value="">All Type</option>
                        <?php if ($expense_types) { for ($i=0; $i <count($expense_types) ; $i++) { ?> 
                            <option value="<?=$expense_types[$i]['id'];?>" <?=isset($_REQUEST['category']) && $_REQUEST['category'] == $expense_types[$i]['id']?'selected':'';?>><?=$expense_types[$i]['expense_name'];?></option>
                        <?php } } ?>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="form-group">
                      <label for="date_to">Employee</label>
                      <select class="form-control" id="user_id" name="user_id" >
                        <option value="">All Employees</option>
                        <?php if ($employees) { for ($i=0; $i <count($employees) ; $i++) { ?> 
                            <option value="<?=$employees[$i]['user_id'];?>" <?=isset($_REQUEST['user_id']) && $_REQUEST['user_id'] == $employees[$i]['user_id']?'selected':'';?>><?=$employees[$i]['employee_name'];?></option>
                        <?php } } ?>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-4" >
                    <div class="form-group">
                      <label for="date_to">Site/Project</label>
                      <select class="form-control" id="ledger_id" name="ledger_id" >
                        <option value="">All</option>
                        <?php if ($ledgers) { for ($i=0; $i <count($ledgers) ; $i++) { ?> 
                            <option value="<?=$ledgers[$i]['ledger_id'];?>" <?=isset($_REQUEST['ledger_id']) && $_REQUEST['ledger_id'] == $ledgers[$i]['ledger_id']?'selected':'';?>><?=$ledgers[$i]['ledger_name'];?></option>
                        <?php } } ?>
                        
                      </select>
                    </div>
                  </div>
                  
            </div>
            <div class="row">
                  <div class="col-md-2" >
                    <div class="form-group">
                      <label for="date_to">Status</label>
                      <select class="form-control" id="status" name="status" >
                        <option value="">All</option>
                        <option value="1" <?=isset($_REQUEST['status']) && $_REQUEST['status'] == '1'?'selected':'';?>>Approved</option>
                        <option value="2" <?=isset($_REQUEST['status']) && $_REQUEST['status'] == '2'?'selected':'';?>>Rejected</option>
                        
                      </select>
                    </div>
                  </div>
                  <div class="col-md-4" style="margin-top:15px;">
                    <button type="submit" name="submitBtn" value="submit" class="btn bg-navy btn-flat margin" style="margin-right: 0;">Search</button>
                    <button type="submit" name="downloadBtn" value="submit" class="btn bg-maroon btn-flat margin">Export</button>
                  </div>
                </form>
              </div>
              <div class="row">
                <div class="col-md-12" id="dataTablediv">
                  <?php if($records){?>
                  <table id="" class="table table-bordered table-condensed table-striped">
                    <tr>
                      <th>Sl No.</th>
                      <th>Exp. Date</th>
                      <th>Exp. No.</th>
                      <th>Expense Type</th>
                      <th>Sub Type</th>
                      <th>Amount</th>
                      
                      <th>Site/Project</th>
                      <th>Added On</th>
                      <th>Status</th>
                    </tr>
                    <?php if($records){$j = 1; for($i=0;$i<count($records);$i++){
                        $emp = $this->Common_Model->db_query("SELECT employee_name FROM employees WHERE user_id=".$records[$i]['expadded_by']);
                        $ledger = $this->Common_Model->db_query("SELECT ledger_name FROM ledgers WHERE ledger_id=".$records[$i]['ledger_id']);
                      ?>
                     <tr>
                      <td><?=$j;?></td>
                      <td><?=$records[$i]['date']?date('d-M-Y',strtotime($records[$i]['date'])):'';?></td>
                      <td><?=$records[$i]['exprefix'].''.$records[$i]['exnumber'];?></td>
                      <td><?=$records[$i]['expense_name'];?></td>
                      <td><?=$records[$i]['expense_subtypename'];?></td>
                      <td><?=$records[$i]['totalex_amount'];?></td>
                      
                      <td><?=$ledger?$ledger[0]['ledger_name']:'';?></td>
                      <td><?=$emp?$emp[0]['employee_name']:'';?><br><?=$records[$i]['expadded_on'];?></td>
                      <td><?php if ($records[$i]['status']==1) { ?>
                            <span style="color:green;"><b>Approved</b></span>
                        <?php }else if ($records[$i]['status']==2) {  ?>
                            <span style="color:red;"><b>Rejected</b></span>
                        <?php }?></td>
                    </tr> 
                    <?php $j++;}} ?>
                  </table>
                  <?php echo $sPages; }else{echo 'No records found';}?>
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