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
              <h3 class="box-title">Balance Sheet Details</h3>
              
              <button class="btn btn-primary btn-xs float-right" id="backBtn" target="_blank" style="margin-right:5px;border: darkred;">Back</button>
            </div>
            <!-- /.box-header -->
            
            <div class="box-body">
              <div class="row">
                
                <div class="col-md-6">
                    <b style="font-size: 18px;">
                      Group : <?=$group[0]['group_name'];?>
                    </b>
                    <br>
                    <b><span style="font-size:18px;color:#7a110b;">     
                      <?php if($fdate){echo date('d M Y',strtotime($fdate)).' -' ; }?>  <?php if($ldate){ echo date('d M Y',strtotime($ldate)) ; }?>
                        
                        <input type="hidden" class="f_date" value="<?=$fdate;?>">
                        <input type="hidden" class="l_date" value="<?=$ldate;?>">
                      </span></b>
                  </div>
                  <div class="col-md-6">
                    <div class="float-right">
                       <a href="<?=site_url('reports/balancesheetledgerprint_pdf/'.$group[0]['group_id'].'/'.$fdate.'/'.$ldate);?>" class="btn btn-primary btn-sm" style="width: 9rem;" target="_blank">Print as Pdf</a>
                      <a href="<?=site_url('reports/balancesheetledgeprint_excel/'.$group[0]['group_id'].'/'.$fdate.'/'.$ldate);?>" class="btn btn-warning btn-sm" style="width: 9rem;">Print as Excel</a>   
                    </div>
                  </div>
               
              </div>
              <div class="row">
                <div class="col-md-12" id="dataTablediv">
                  <table id="tblexportData" class="table  table-condensed table-striped">
                    <thead>
                      <tr>
                        <th width="40%">PARTICULARS</th>
                        <th width="15%">OPENING</th>
                        <th width="15%">DEBIT</th>
                        <th width="15%">CREDIT</th>
                        <th width="15%">CLOSING</th>
                      </tr>
                    </thead>
                    <tbody> 
                      <?php if ($ledgers) { $drtotal =0;$crtotal =0; for ($i=0; $i < count($ledgers); $i++) {

                      $category = $this->Common_Model->FetchData("under_group as a LEFT JOIN subcategory as b on a.subcategory_id=b.subcategory_id","*","group_id=".$ledgers[$i]['acount_group'].""); 
                      
                      $ledg_debitasop = $this->Common_Model->db_query("SELECT SUM(dramount) as totdebit FROM entry_items as a LEFT JOIN entries as d on a.entry_id=d.entry_id LEFT JOIN ledgers as b on a.ledger=b.ledger_id LEFT JOIN under_group as c on b.acount_group=c.group_id WHERE  b.ledger_id=".$ledgers[$i]['ledger_id']." AND d.entry_dt < '".$fdate."'");

                    $ledg_creditasop = $this->Common_Model->db_query("SELECT SUM(cramount) as totcredit FROM entry_items as a LEFT JOIN entries as d on a.entry_id=d.entry_id LEFT JOIN ledgers as b on a.ledger=b.ledger_id LEFT JOIN under_group as c on b.acount_group=c.group_id WHERE  b.ledger_id=".$ledgers[$i]['ledger_id']." AND d.entry_dt < '".$fdate."'");

                            if ($category[0]['category_id']==1 || $category[0]['category_id']==4) {
                            $opening = $ledgers[$i]['opening_balance'] + $ledg_debitasop[0]['totdebit'] - $ledg_creditasop[0]['totcredit'];
                          }else{
                            $opening = $ledgers[$i]['opening_balance'] + $ledg_creditasop[0]['totcredit'] - $ledg_debitasop[0]['totdebit'] ;
                          }
                            $bal_type=$ledgers[$i]['balance_type'];

                            $ledg_debit = $this->Common_Model->db_query("SELECT SUM(dramount) as totdebit FROM entry_items as a LEFT JOIN entries as d on a.entry_id=d.entry_id LEFT JOIN ledgers as b on a.ledger=b.ledger_id LEFT JOIN under_group as c on b.acount_group=c.group_id WHERE  b.ledger_id=".$ledgers[$i]['ledger_id']." AND d.entry_dt>='".$fdate."' AND d.entry_dt<='".$ldate."'");

                            $ledg_credit = $this->Common_Model->db_query("SELECT SUM(cramount) as totcredit FROM entry_items as a LEFT JOIN entries as d on a.entry_id=d.entry_id LEFT JOIN ledgers as b on a.ledger=b.ledger_id LEFT JOIN under_group as c on b.acount_group=c.group_id WHERE  b.ledger_id=".$ledgers[$i]['ledger_id']." AND d.entry_dt>='".$fdate."' AND d.entry_dt<='".$ldate."'");

                            if ($category[0]['category_id']==1 || $category[0]['category_id']==4) {
                            $balance = $opening + $ledg_debit[0]['totdebit'] - $ledg_credit[0]['totcredit'];
                          }else{
                            $balance = $opening + $ledg_credit[0]['totcredit'] - $ledg_debit[0]['totdebit'] ;
                          }

                            $drtotal +=$ledg_debit[0]['totdebit'];
                            $crtotal +=$ledg_credit[0]['totcredit'];
                        ?>
                        <tr class="product_tr ledgeracview" data-id="<?=$ledgers[$i]['ledger_id'];?>">
                        <td width="40%"><?=$ledgers[$i]['ledger_name'];?></td>
                        <td width="15%">
                            <?php if ($category[0]['category_id']==1 || $category[0]['category_id']==4) {
                              echo 'Dr';
                            }else{echo 'Cr';} ?>


                          <!-- <?=$bal_type;?> --> <?=number_format($opening,2);?></td>
                        <td width="15%"><?=$ledg_debit[0]['totdebit']?number_format($ledg_debit[0]['totdebit'],2):'0.00';?></td>
                        <td width="15%"><?=$ledg_credit[0]['totcredit']?number_format($ledg_credit[0]['totcredit'],2):'0.00';?></td>
                        <td width="15%">

                           
                          <?php if ($category[0]['category_id']==1 || $category[0]['category_id']==4) {

                          if ($balance > 0) {
                                  echo 'Dr '.number_format(abs($balance),2); 
                                }else if ($balance < 0) {
                                  echo 'Cr '.number_format(abs($balance),2); 
                                }else{
                                  echo '0.00';
                                }

                            }else{
                              if ($balance > 0) {
                                  echo 'Cr '.number_format(abs($balance),2); 
                                }else if ($balance < 0) {
                                  echo 'Dr '.number_format(abs($balance),2); 
                                }else{
                                  echo '0.00';
                                }
                            }
                                ?>
                                </td>
                      </tr>
                      <?php } }?>

                        <tr class="">
                          <th width="40%">Total</th>
                          <th width="15%"></th>
                          <th width="15%">Dr <?=number_format($drtotal,2);?></th>
                          <th width="15%">Cr <?=number_format($crtotal,2);?></th>
                          <th width="15%"></th>
                        </tr>

                    </tbody>

                     
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
  $(document).on('click','#backBtn', function(){
        window.history.go(-1);
    });
  $(document).on('click', '.ledgeracview', function(){
      var id = $(this).attr('data-id');
      var fdate = $(".f_date").val();
      var ldate = $(".l_date").val();
      var url = "<?php echo site_url(); ?>";
      /*document.location.href=url+"/reports/todaysgrossprofitWithDay/"+id;*/
      document.location.href=url+'ledger/ledger_display/?id='+id+'&date_from='+fdate+'&date_to='+ldate;
    });
</script>
</body>
</html>