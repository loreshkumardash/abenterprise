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
   

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Sale Report <small>Month Wise</small></h3>
              <a href="<?=site_url('reports/print_salereport');?>" class="btn btn-primary btn-sm float-right" target="_blank">Print</a>
            </div>
            <div class="box-body">
              <table id="" class="table table-bordered table-condensed table-striped" style="font-size: 16px!important;">
                <tr>
                  <th width="10%" class="text-center">#SL</th>
                  <th width="40%">MONTH</th>
                  <th width="25%" class="text-right">INVOICE AMOUNT</th>
                  <th width="25%" class="text-right">RECEIPT AMOUNT</th>
                </tr>

                <?php 
                    $start    = $this->session->userdata("session_start_date");
                        $end = $this->session->userdata("session_end_date");
                        $months = $this->Common_Model->list_months($start,$end, 'd-m-Y');
                        for ($i=0; $i < count($months) ; $i++) { 
                          $start_date = date("Y-m-01",strtotime($months[$i]));
                          $last_date = date("Y-m-t",strtotime($months[$i]));

                          $invoice = $this->Common_Model->db_query("SELECT SUM(grand_total) AS ia FROM invoices WHERE invoice_date>='".$start_date."' AND invoice_date<='".$last_date."'");

                          $receipt = $this->Common_Model->db_query("SELECT SUM(amount_paid) AS ra FROM receipts WHERE voucher_date >='".$start_date."' AND voucher_date<='".$last_date."'");
                          ?>

                      <tr>
                        <td width="10%" class="text-center"><?=$i+1;?></td>
                        <td width="40%"><?=date('F - Y',strtotime($months[$i]));?></td>
                        <td width="25%" class="text-right"><?=$invoice[0]['ia']>0?number_format($invoice[0]['ia'],2):'';?></td>
                        <td width="25%" class="text-right"><?=$receipt[0]['ra']>0?number_format($receipt[0]['ra'],2):'';?></td>
                      </tr>

                <?php  } ?>
                
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