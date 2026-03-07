<?php $this->load->view("common/meta");?>
<style type="text/css">

  .table>tbody>tr[data-id], table>tbody>tr[data-id] {
    cursor: pointer;
    
}
.table>tbody>tr.product_tr:hover {
    background:#bf938b;
    color: black!important;
    text-transform: bold;
  }

tr {
    display: table-row;
    vertical-align: inherit;
     
}
.table>tbody>tr>td {
    padding: 1px;
}
table.dataTable {
    clear: both;
    max-width: none!important;
    
    font-size: 16px;
    font-weight: 400px;
    font-family: inherit;
    padding: 10px;

}
.customer_table tr:nth-child(even) {background: #CCC}
.customer_table tr:nth-child(odd) {background: #FFF}

.tableFixHead thead th { position: sticky; top: 0; z-index: 1;background-color: transparent;color: black; }  
.divspan span {
  color: blue;
}


</style>
<div class="wrapper">

  <?php $this->load->view("common/sidebar");?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
   

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Bills Receivable</h3>
              
            </div>
            <!-- /.box-header -->
            
            <div class="box-body">
              <div class="row">
                <form role="form" action="" method="post" id="searchForm">
                    <div class="col-md-2">
                    <div class="form-group">
                      <label for="date_from">Date From</label>
                      <input type="date" class="form-control" id="date_from" name="date_from" value="<?php echo set_value("date_from");?>" >
                    </div>
                    </div>
                    <div class="col-md-2">
                      <div class="form-group">
                        <label for="date_to">Date To</label>
                        <input type="date" class="form-control" id="date_to" name="date_to" value="<?php echo set_value("date_to");?>" >
                      </div>
                    </div>
                    
                    <div class="col-md-3">
                      <button type="submit" name="submitBtn" value="submit" class="btn bg-navy btn-flat margin" style="margin-top: 25px;">Search</button>

                      <button type="reset" name="resetBtn"  class="btn btn-warning margin" style="margin-top: 25px;width: 6rem;">Clear</button>
                      
                    </div>
                    <div class="col-md-5">
                      <button type="button" onclick="printDiv('dataTablediv')" style="margin-top: 25px;float:right;"><i class="fa fa-print"></i></button>
                    </div>
                </form>
                  <!--<div class="col-md-4" style="margin-top: 25px;text-align: right;">

                      <b><span style="font-size:16px;color:#7a110b;">
                        <?php if($fdate){echo date('d-M-Y',strtotime($fdate)).' To' ; }?>  <?php if($ldate){ echo date('d-M-Y',strtotime($ldate)) ; }?>
                          <input type="hidden" class="f_date" value="<?=$fdate;?>">
                          <input type="hidden" class="l_date" value="<?=$ldate;?>">
                        </span></b>

                  </div>-->
                  
              </div>
              <div class="row">
                <div class="col-md-12" id="dataTablediv">
                  <table id="tblexportData" class="table  table-condensed table-striped">
                    <thead>
                      <tr>
                        <th width="10%">DATE<br>&nbsp</th>
                        <th width="15%" >REF. NO.<br>&nbsp</th>
                        <th width="25%">PARTY NAME<br>&nbsp</th>
                        <th width="10%" class="text-right">TOTAL</th>
                        <th width="10%" class="text-right">PAID</th>
                        <th width="10%" class="text-right">PENDING</th>
                        <th width="10%" class="text-right">DUE ON<br>&nbsp</th>
                        <th width="10%" class="text-right">OVERDUE<br>BY DAYS</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php $totalpending = 0;
                      $totinvamt=0;$totpaid = 0;
                      if ($invoice) {  for ($i=0; $i < count($invoice); $i++) {  

                          $start = strtotime($invoice[$i]['invoice_date']); $end = strtotime(date('Y-m-d')); $days_between = ceil(abs($end - $start) / 86400);

                          $paid = $this->Common_Model->db_query("SELECT SUM(itm_amount) as paid_amt FROM billadj_data WHERE invoice_id = ".$invoice[$i]['invoice_id']." AND adj_type='Receipt' or invoice_id = ".$invoice[$i]['invoice_id']." AND adj_type='Credit Note'");
                        
                        $added = $this->Common_Model->db_query("SELECT SUM(itm_amount) as paid_amt FROM billadj_data WHERE invoice_id = ".$invoice[$i]['invoice_id']." AND adj_type='Debit Note'");
                        
                          $due = ($invoice[$i]['grand_total'] + $added[0]['paid_amt']) - $paid[0]['paid_amt'];

                          // if ($due > 0) {   ?>
                      <tr>
                        <td width="10%" style="color:black;font-weight: ;"><?=$invoice[$i]['invoice_date'];?></td>
                        <td width="15%" ><?=$invoice[$i]['invoice_no'];?></td>
                        <td width="25%" style="color:black;font-weight: ;"><?=$invoice[$i]['ledger_name'];?></td>
                        <td width="10%" class="text-right" style="color:black;font-weight: ;"><?=price_format(round($invoice[$i]['grand_total'],2));?></td>
                        <td width="10%" class="text-right" style="color:black;font-weight: ;"><?=price_format(round($paid[0]['paid_amt'],2));?></td>
                        <td width="10%" class="text-right" style="color:black;font-weight: ;"><?=price_format(round($due,2));?></td>
                        <td width="10%" class="text-right"><?=$invoice[$i]['invoice_date'];?></td>
                        <td width="10%" class="text-right"><?=$days_between;?></td>
                      </tr>
                           
                      <?php $totalpending +=$due;
                      		$totinvamt +=$invoice[$i]['grand_total'];
                      		$totpaid +=$paid[0]['paid_amt'];

                  }}//} ?>
                      <tr>
                       <th>Total</th>
                       <th></th>
                       <th></th>
                       <th class="text-right"><?=price_format(round($totinvamt,2));?></th>
                       <th class="text-right"><?=price_format(round($totpaid,2));?></th>
                       <th class="text-right"><?=price_format(round($totalpending,2));?></th>
                       <th></th>
                       <th></th>
                      </tr>

                    </tbody>

                     
                  </table> 
                  <?php if ($invoice) {
                    echo $sPages;
                  }else{echo '';} ?>
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
  $("#clientunit").keyup(function(){
  var unit = $(this).val();
  $.ajax({
    url: '<?=site_url("reports/get_UnitNameBycustCode");?>',
    data: {unit : unit},
    dataType:"HTML",
    type:"POST",
    success:function(data){        
        $("#unitname").val(data);
    }
  });
});
  if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
</script>
<script>
        function printDiv(divId) {
            // Get the HTML of the div
            var printContents = document.getElementById(divId).innerHTML;
            // Open a new window or tab for printing
            var originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;

            window.print();

            // Restore the original content after printing
            document.body.innerHTML = originalContents;
            window.location.reload(); // Reload to restore JavaScript events
        }
    </script>
</body>
</html>

