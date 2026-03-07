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
                <form role="form" action="<?php echo site_url("reports/receivable");?>" method="post" id="searchForm">
                    
                    <div class="col-md-2">
                        <div class="form-group">
                          <label for="unit">Customer Code</label>
                          <input type="text" class="form-control form-control-sm" name="unit" id="clientunit">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                          <label for="unit">Name</label>
                        
                          <input type="text" class="form-control form-control-sm" name="unitname" id="unitname" readonly>
                        </div>
                    </div>
                    <div class="col-md-3">
                      <button type="submit" name="submitBtn" value="submit" class="btn bg-navy btn-flat margin" style="margin-top: 25px;">Search</button>

                      <button type="reset" name="resetBtn"  class="btn btn-warning margin" style="margin-top: 25px;width: 6rem;">Clear</button>
                      
                    </div>
                    <div class="col-md-4">
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
                        <th width="10%">Code</th>
                        <th width="25%">PARTY NAME</th>
                        <th width="10%" class="text-right">TOTAL</th>
                        <th width="10%" class="text-right">PAID</th>
                        <th width="10%" class="text-right">PENDING</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                        $grandtotinv=0;$grandtotpaid=0;$grandtotdue=0;
                       if($ledgers){for ($i=0; $i < count($ledgers); $i++) { 
                          $invoice = $this->Common_Model->db_query("SELECT * FROM invoices WHERE invoice_name=".$ledgers[$i]['ledger_id']." ORDER BY invoice_date DESC");
                          $totinvamt=0;$totpaid = 0;$totadded=0;$totdue=0;
                          if ($invoice) {  for ($a=0; $a < count($invoice); $a++) {
                              $paid = $this->Common_Model->db_query("SELECT SUM(itm_amount) as paid_amt FROM billadj_data WHERE invoice_id = ".$invoice[$a]['invoice_id']." AND adj_type='Receipt' or invoice_id = ".$invoice[$a]['invoice_id']." AND adj_type='Credit Note'");
                        
                              $added = $this->Common_Model->db_query("SELECT SUM(itm_amount) as paid_amt FROM billadj_data WHERE invoice_id = ".$invoice[$a]['invoice_id']." AND adj_type='Debit Note'");
                            $totinvamt +=$invoice[$a]['grand_total'];
                            $totpaid +=$paid[0]['paid_amt'];
                            $totadded +=$added[0]['paid_amt'];
                              $due = ($invoice[$a]['grand_total'] + $added[0]['paid_amt']) - $paid[0]['paid_amt'];
                              
                          }}
                          $totdue= ($totinvamt + $totadded) - $totpaid;
                          $grandtotinv +=$totinvamt;
                          $grandtotpaid +=$totpaid;
                          $grandtotdue +=$totdue;
                        ?>
                        <tr class="product_tr rcvableview" data-id="<?=$ledgers[$i]['ledger_id'];?>">
                          <td width="10%"><?=$ledgers[$i]['ledger_alias'];?></td>
                          <td width="25%"><?=$ledgers[$i]['ledger_name'];?></td>
                          <td width="10%" class="text-right"><?=price_format(round($totinvamt,2));?></td>
                          <td width="10%" class="text-right"><?=price_format(round($totpaid,2));?></td>
                          <td width="10%" class="text-right"><?=price_format(round($totdue,2));?></td>
                        </tr>
                      <?php }} ?>
                        <tr style="font-weight:bold;">
                          <td width="35%" colspan="2">Total</td>
                          <td width="10%" class="text-right"><?=price_format(round($grandtotinv,2));?></td>
                          <td width="10%" class="text-right"><?=price_format(round($grandtotpaid,2));?></td>
                          <td width="10%" class="text-right"><?=price_format(round($grandtotdue,2));?></td>
                        </tr>
                    </tbody>
                  </table>
                   <?php if($ledgers){echo $sPages;}?>
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

  $(document).on('click', '.rcvableview', function(){
      var id = $(this).attr('data-id');
      var url = "<?php echo site_url(); ?>";
      document.location.href=url+'reports/billreceivable?ledger_id='+id;
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

