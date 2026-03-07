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
              <h3 class="box-title">Balance Sheet</h3>
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
                <form role="form" action="<?php echo site_url("reports/balance_sheet");?>" method="post" id="searchForm">
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
                    <button type="button" onclick="exportToExcel('tblexportData', 'balancesheet')" name="downloadBtn" value="submit" class="btn bg-navy btn-flat margin">Download</button>
                  </div>
                </form>
              </div>
              <div class="row">
                <div class="col-md-12" id="dataTablediv">
                  <table id="tblexportData" class="table table-bordered table-condensed table-striped">
                    <tr>
                      <td width="50%">
                        <?php if($records){?>
                        <table id="" class="table table-bordered table-condensed table-striped">
                          <tr>
                            <th width="75%">Expenditure</th>
                            <th width="25%">Amount in Rs.</th>
                          </tr>
                          <?php $expensetotal = 0; if($records){$j = 1; for($i=0;$i<count($records);$i++){ $expensetotal = $expensetotal + $records[$i]['totalamount'];?>
                          <tr>
                            <td><?php if($records[$i]['purpose']=='Salary'){echo $records[$i]['remarks'];}else{echo $records[$i]['expense_name'];}?></td>
                            <th class="moneydata"><?php echo number_format($records[$i]['totalamount'],2);?></th>
                          </tr>
                          <?php $j++;}} ?> 
                          <?php 
                          $a = count($records);
                          $b = count($incomerecords);
                          $cnt = $b - $a;
                          if($a < $b){
                            for($i=0;$i < $cnt;$i++){
                          ?>
                          <tr>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                          </tr>
                          <?php
                            }
                          }
                          ?>
                          <tr>
                            <td>&nbsp;</td>
                            <th class="moneydata"><?=number_format($expensetotal,2);?></th>
                          </tr>
                        </table>
                        <?php }else{echo 'No records found';}?>
                      </td>
                      <td width="50%">
                        <?php if($incomerecords){?>
                        <table id="" class="table table-bordered table-condensed table-striped">
                          <tr>
                            <th width="75%">Income</th>
                            <th width="25%">Amount in Rs.</th>
                          </tr>
                          <?php $incometotal = 0;  if($incomerecords){$j = 1; for($i=0;$i<count($incomerecords);$i++){ $incometotal = $incometotal + $incomerecords[$i]['totalamount'];?>
                          <tr>
                            <td><?php echo $incomerecords[$i]['income'];?></td>
                            <th class="moneydata"><?php echo number_format($incomerecords[$i]['totalamount'],2);?></th>
                          </tr>
                          <?php $j++;}} ?>
                          <?php 
                          $a = $records ? count($records) : 0;
                          $b = $incomerecords ? count($incomerecords) : 0;
                          $cnt = $a - $b;
                          if($a > $b){
                            for($i=0;$i < $cnt;$i++){
                          ?>
                          <tr>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                          </tr>
                          <?php
                            }
                          }
                          ?>
                          <tr>
                            <td>&nbsp;</td>
                            <th class="moneydata"><?=number_format($incometotal,2);?></th>
                          </tr>
                        </table>
                        <?php }else{echo 'No records found';}?>
                      </td>
                    </tr>
                  </table>
                  
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
<script type="text/javascript">
function exportToExcel(tableID, filename = ''){
    var downloadurl;
    var dataFileType = 'application/vnd.ms-excel';
    var tableSelect = document.getElementById(tableID);
    var tableHTMLData = tableSelect.outerHTML.replace(/ /g, '%20');
    
    // Specify file name
    filename = filename?filename+'.xls':'export_excel_data.xls';
    
    // Create download link element
    downloadurl = document.createElement("a");
    
    document.body.appendChild(downloadurl);
    
    if(navigator.msSaveOrOpenBlob){
        var blob = new Blob(['\ufeff', tableHTMLData], {
            type: dataFileType
        });
        navigator.msSaveOrOpenBlob( blob, filename);
    }else{
        // Create a link to the file
        downloadurl.href = 'data:' + dataFileType + ', ' + tableHTMLData;
    
        // Setting the file name
        downloadurl.download = filename;
        
        //triggering the function
        downloadurl.click();
    }
}
 
</script>
</body>
</html>