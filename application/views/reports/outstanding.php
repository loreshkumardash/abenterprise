<?php $this->load->view("common/meta");?>
<style type="text/css">
  table{
    padding: 0px!important;
    margin: 0px!important;
  }
  .table>tbody>tr[data-id], table>tbody>tr[data-id] {
    cursor: pointer;
    
}
.table>tbody>tr.cb:hover {
    background:#4e635e;
    color: white;
    text-transform: bold;
  }
  
 .ld_btn:hover {
    background-image: linear-gradient(to top, #29abd6, #e4eaf5);
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
    border-collapse: ;
    font-size: 16px;
    font-weight: 400px;
    font-family: inherit;
    padding: 0px;

}
</style>
<div class="wrapper">

  <?php $this->load->view("common/sidebar");?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Outstanding
        
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">List Outstanding</h3>
              <a href="<?=site_url('reports/print_outstanding');?>" class="btn btn-primary btn-sm float-right" target="_blank">Print</a>
            </div>
            <div class="box-body">
              <table id="" class="table table-bordered table-condensed table-striped">
                <tr>
                  <th width="5%" class="text-center">SlNo.</th>
                  <th width="35%">Particulars</th>
                  <th width="20%" class="text-right">Invoice Amt</th>
                  <th width="20%" class="text-right">Credit</th>
                  <th width="20%" class="text-right">Balance</th>
                  
                </tr>
                <?php if ($ledger) { $invtotal = 0;$rcpttotal = 0;$baltotal = 0; for ($i=0; $i <count($ledger) ; $i++) { 
                    $inv = $this->Common_Model->db_query("SELECT SUM(grand_total) AS totinvamt FROM invoices WHERE invoice_name=".$ledger[$i]['ledger_id']."");
                    $rcpt = $this->Common_Model->db_query("SELECT SUM(amount_paid) AS totrcptamt FROM receipts WHERE voucher_name=".$ledger[$i]['ledger_id']."");
                    $balance = $inv[0]['totinvamt'] - $rcpt[0]['totrcptamt'];

                    $invtotal += $inv[0]['totinvamt'];
                    $rcpttotal += $rcpt[0]['totrcptamt'];
                    $baltotal += $balance;


                  ?>
                  <tr>
                    <td width="5%" class="text-center"><?=$i+1;?></td>
                    <td width="35%"><?=$ledger[$i]['ledger_name'];?></td>
                    <td width="20%" class="text-right"><?=number_format($inv[0]['totinvamt'],2);?></td>
                    <td width="20%" class="text-right"><?=number_format($rcpt[0]['totrcptamt'],2);?></td>
                    <td width="20%" class="text-right"><?=number_format($balance,2);?></td>
                    
                  </tr>
                <?php } ?>

                <tr>
                  <td width="40%" colspan="2" style="text-align:center;border-top: 1px solid black;"><b>TOTAL</b></td>

                  <td width="20%" style="text-align:right;border-top: 1px solid black;"><b><?=number_format($invtotal,2);?></b></td>

                  <td width="20%" style="text-align:right;border-top: 1px solid black;"><b><?=number_format($rcpttotal,2);?></b></td>

                  <td width="20%" style="text-align:right;border-top: 1px solid black;"><b><?=number_format($baltotal,2);?></b></td>
                </tr>

                <?php } ?>
              </table>
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
  $(document).on('click', '.description', function(){
       
        var id = $(this).attr('data-id');
        var category = $(this).attr('data-category');

        $(".desc_id").val(id);
        $(".desc_category").val(category);
        
 
        $('.mymodal').modal('toggle');
        $('.mymodal').modal('show');


      });
    $(document).on('click', '.cancel_btn', function(){
      $('.mymodal').modal('toggle');
      $('.mymodal').modal('hide');
    });
</script>
</body>
</html>