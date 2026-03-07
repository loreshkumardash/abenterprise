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
              <h3 class="box-title">Profit & Loss</h3>
            </div>
            <!-- /.box-header -->
            
            <div class="box-body">
              <div class="row">
                
                <form role="form" action="<?php echo site_url("reports/profitloss_report");?>" method="post" id="searchForm">
                  <div class="col-md-2">
                    <div class="form-group">
                      <label for="date_from">Date From</label>
                      <input type="date" class="form-control" id="date_from" name="date_from" value="<?php echo set_value("date_from")?set_value("date_from"):$fdate;?>" required="required">
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="form-group">
                      <label for="date_to">Date To</label>
                      <input type="date" class="form-control" id="date_to" name="date_to" value="<?php echo set_value("date_to")?set_value("date_to"):$ldate;?>" required="required">
                    </div>
                  </div>
                  <div class="col-md-4">
                    <button type="submit" name="submitBtn" value="submit" class="btn bg-navy btn-flat margin" style="margin-top: 25px;">Search</button>
                    <button type="submit" name="downloadBtn" value="submit" class="btn bg-maroon btn-flat margin" style="margin-top: 25px;">Download</button>
                    
                  </div>
                  <div class="col-md-4">
                    <center>
                      <br>
                          <b><span style="font-size:18px;color:#7a110b;">

                            <?php if($fdate){echo date('d M Y',strtotime($fdate)).' -' ; }?>  <?php if($ldate){ echo date('d M Y',strtotime($ldate)) ; }?></span></b>
                        </center>
                  </div>
                </form>
              </div>
              <div class="row">
                <div class="col-md-6" id="dataTablediv">
                  <table id="tblexportData" class="table  table-condensed table-striped">
                      <tr>
                        <th width="60%">PARTICULARS</th>
                        <th width="15%"></th>
                        <th width="25%"></th>
                      </tr>
                      <?php if ($category) { $totalincome = 0; for ($a=0; $a < count($category); $a++) {
                          $subcategory = $this->Common_Model->FetchData("subcategory","*","category_id=".$category[$a]['category_id']);

                          if ($subcategory) { for ($b=0; $b < count($subcategory); $b++) { 
                            $subcat_debit = $this->Common_Model->db_query("SELECT SUM(dramount) as totdebit FROM entry_items as a LEFT JOIN entries as d on a.entry_id=d.entry_id LEFT JOIN ledgers as b on a.ledger=b.ledger_id LEFT JOIN under_group as c on b.acount_group=c.group_id WHERE  c.subcategory_id=".$subcategory[$b]['subcategory_id']." AND d.entry_dt>='".$fdate."' AND d.entry_dt<='".$ldate."'");

                            $subcat_credit = $this->Common_Model->db_query("SELECT SUM(cramount) as totcredit FROM entry_items as a LEFT JOIN entries as d on a.entry_id=d.entry_id LEFT JOIN ledgers as b on a.ledger=b.ledger_id LEFT JOIN under_group as c on b.acount_group=c.group_id WHERE  c.subcategory_id=".$subcategory[$b]['subcategory_id']." AND d.entry_dt>='".$fdate."' AND d.entry_dt<='".$ldate."'");

                            ?>

                            <tr class="product_tr">
                              <th><?=$subcategory[$b]['subcategory_name'];?></th>
                              <th>
                              <th style="text-align: right;"><?php $subdiff = $subcat_credit[0]['totcredit'] - $subcat_debit[0]['totdebit'];
                                
                                  echo number_format($subdiff,2);
                                $totalincome += round($subdiff,2);
                                    ?>
                                      
                              </th>
                            </tr>

                            <?php $group = $this->Common_Model->FetchData("under_group","*","subcategory_id=".$subcategory[$b]['subcategory_id'].""); 
                            if ($group) { for ($c=0; $c < count($group); $c++) { 


                              $grp_debit = $this->Common_Model->db_query("SELECT SUM(dramount) as totdebit FROM entry_items as a LEFT JOIN entries as d on a.entry_id=d.entry_id LEFT JOIN ledgers as b on a.ledger=b.ledger_id LEFT JOIN under_group as c on b.acount_group=c.group_id WHERE  b.acount_group=".$group[$c]['group_id']." AND d.entry_dt>='".$fdate."' AND d.entry_dt<='".$ldate."'");

                            $grp_credit = $this->Common_Model->db_query("SELECT SUM(cramount) as totcredit FROM entry_items as a LEFT JOIN entries as d on a.entry_id=d.entry_id LEFT JOIN ledgers as b on a.ledger=b.ledger_id LEFT JOIN under_group as c on b.acount_group=c.group_id WHERE  b.acount_group=".$group[$c]['group_id']." AND d.entry_dt>='".$fdate."' AND d.entry_dt<='".$ldate."'");


                              ?>
                            <tr class="product_tr">
                              <td>&nbsp&nbsp<?=$group[$c]['group_name'];?></td>
                              
                              <td style="text-align: right;">&nbsp&nbsp<?php $grpdiff = $grp_credit[0]['totcredit'] - $grp_debit[0]['totdebit'];
                                
                                  echo number_format($grpdiff,2);
                                
                                    ?></td>
                              <td></td>
                            </tr>
                          <?php  }}
                          ?>

                         
                      <?php }}} ?>
                      <?php  $saleac = $this->Common_Model->db_query("SELECT SUM(item_amount) as totcredit FROM invoice_items as a LEFT JOIN invoices as d on a.invoice_id=d.invoice_id LEFT JOIN ledgers as b on d.invoice_name=b.ledger_id WHERE d.invoice_status='Submitted' AND d.invoice_date >= '".$fdate."' AND d.invoice_date <= '".$ldate."'");
                       ?>
                      <tr class="product_tr">
                          <th>Sales Account</th>
                          <th>
                          <th style="text-align: right;"><?php $subdiff = $saleac[0]['totcredit'];
                            
                              echo number_format($subdiff,2);
                            $totalincome += round($subdiff,2);
                                ?>
                                  
                          </th>
                      </tr>
                      <?php $compgst = $this->Common_Model->FetchData("company_gst","*","1 ORDER BY gst_id ASC"); if ($compgst) { for ($g=0; $g < count($compgst); $g++) {

                        $saleac = $this->Common_Model->db_query("SELECT SUM(item_amount) as totcredit FROM invoice_items as a LEFT JOIN invoices as d on a.invoice_id=d.invoice_id LEFT JOIN ledgers as b on d.invoice_name=b.ledger_id WHERE d.invoice_status='Submitted' AND d.invoice_date >= '".$fdate."' AND d.invoice_date <= '".$ldate."' AND d.companygst_id=".$compgst[$g]['gst_id']."");
                        if ($saleac[0]['totcredit'] > 0) { ?>
                          
                        
                      <tr class="product_tr">
                              <td>&nbsp&nbsp<?=$compgst[$g]['gst_head'];?> Branch Sales</td>
                              
                              <td style="text-align: right;">&nbsp&nbsp<?php $grpdiff = $saleac[0]['totcredit'];
                                
                                  echo number_format($grpdiff,2);
                                
                                    ?></td>
                              <td></td>
                            </tr>

                   <?php }} }}?>
                  </table> 
                </div>
                <div class="col-md-6" id="dataTablediv">
                  <table id="tblexportData" class="table  table-condensed table-striped">
                      <tr>
                        <th width="60%">PARTICULARS</th>
                        <th width="15%"></th>
                        <th width="25%"></th>
                      </tr>
                      <?php if ($categoryy) { $totalexpence=0; for ($a=0; $a < count($categoryy); $a++) {
                          $subcategoryy = $this->Common_Model->FetchData("subcategory","*","category_id=".$categoryy[$a]['category_id']);

                          if ($subcategoryy) { for ($b=0; $b < count($subcategoryy); $b++) { 
                            $subcat_debit = $this->Common_Model->db_query("SELECT SUM(dramount) as totdebit FROM entry_items as a LEFT JOIN entries as d on a.entry_id=d.entry_id LEFT JOIN ledgers as b on a.ledger=b.ledger_id LEFT JOIN under_group as c on b.acount_group=c.group_id WHERE  c.subcategory_id=".$subcategoryy[$b]['subcategory_id']." AND d.entry_dt>='".$fdate."' AND d.entry_dt<='".$ldate."'");

                            $subcat_credit = $this->Common_Model->db_query("SELECT SUM(cramount) as totcredit FROM entry_items as a LEFT JOIN entries as d on a.entry_id=d.entry_id LEFT JOIN ledgers as b on a.ledger=b.ledger_id LEFT JOIN under_group as c on b.acount_group=c.group_id WHERE  c.subcategory_id=".$subcategoryy[$b]['subcategory_id']." AND d.entry_dt>='".$fdate."' AND d.entry_dt<='".$ldate."'");

                            ?>

                            <tr class="product_tr">
                              <th><?=$subcategoryy[$b]['subcategory_name'];?></th>
                              <th>
                              <th style="text-align: right;"><?php $subdiff =  $subcat_debit[0]['totdebit'] - $subcat_credit[0]['totcredit'];
                                
                                  echo number_format($subdiff,2);
                                  $totalexpence += round($subdiff,2);
                                    ?>
                                      
                              </th>
                            </tr>

                            <?php $group = $this->Common_Model->FetchData("under_group","*","subcategory_id=".$subcategoryy[$b]['subcategory_id'].""); 
                            if ($group) { for ($c=0; $c < count($group); $c++) { 


                              $grp_debit = $this->Common_Model->db_query("SELECT SUM(dramount) as totdebit FROM entry_items as a LEFT JOIN entries as d on a.entry_id=d.entry_id LEFT JOIN ledgers as b on a.ledger=b.ledger_id LEFT JOIN under_group as c on b.acount_group=c.group_id WHERE  b.acount_group=".$group[$c]['group_id']." AND d.entry_dt>='".$fdate."' AND d.entry_dt<='".$ldate."'");

                            $grp_credit = $this->Common_Model->db_query("SELECT SUM(cramount) as totcredit FROM entry_items as a LEFT JOIN entries as d on a.entry_id=d.entry_id LEFT JOIN ledgers as b on a.ledger=b.ledger_id LEFT JOIN under_group as c on b.acount_group=c.group_id WHERE  b.acount_group=".$group[$c]['group_id']." AND d.entry_dt>='".$fdate."' AND d.entry_dt<='".$ldate."'");


                              ?>
                            <tr class="product_tr">
                              <td>&nbsp&nbsp<?=$group[$c]['group_name'];?></td>
                              
                              <td style="text-align: right;">&nbsp&nbsp<?php $grpdiff =  $grp_debit[0]['totdebit'] - $grp_credit[0]['totcredit'];
                                
                                  echo number_format($grpdiff,2);
                                
                                    ?></td>
                              <td></td>
                            </tr>
                          <?php  }}
                          ?>

                         
                      <?php }}} ?>
                      <?php  $purchaseac = $this->Common_Model->db_query("SELECT SUM(item_amount) as totdebit FROM purchase_items as a LEFT JOIN purchase as d on a.purchase_id=d.purchase_id LEFT JOIN ledgers as b on d.purchase_from=b.ledger_id WHERE d.purchase_date >= '".$fdate."' AND d.purchase_date <= '".$ldate."'");
                       ?>
                      <tr class="product_tr">
                          <th>Purchase Account</th>
                          <th>
                          <th style="text-align: right;"><?php $subdiff = $purchaseac[0]['totdebit'];
                            
                              echo number_format($subdiff,2);
                            $totalexpence += round($subdiff,2);
                                ?>
                                  
                          </th>
                      </tr>

                      <?php $assets = $this->Common_Model->FetchData("assets","*","item_type='Asset' ORDER BY item_name ASC"); if ($assets) { for ($g=0; $g < count($assets); $g++) {

                        $purchaseacg = $this->Common_Model->db_query("SELECT SUM(item_amount) as totdebit FROM purchase_items as a LEFT JOIN purchase as d on a.purchase_id=d.purchase_id LEFT JOIN ledgers as b on d.purchase_from=b.ledger_id WHERE d.purchase_date >= '".$fdate."' AND d.purchase_date <= '".$ldate."' AND a.item_id=".$assets[$g]['asset_id']."");
                        if ($purchaseacg[0]['totdebit'] > 0) { ?>
                          
                        
                      <tr class="product_tr">
                              <td>&nbsp&nbsp<?=$assets[$g]['item_name'];?> </td>
                              
                              <td style="text-align: right;">&nbsp&nbsp<?php $grpdiff = $purchaseacg[0]['totdebit'];
                                
                                  echo number_format($grpdiff,2);
                                
                                    ?></td>
                              <td></td>
                            </tr>

                   <?php }} }}?>
                  </table> 
                </div>
              </div>
              <div class="row">
                <div class="col-md-6" id="dataTablediv">
                  <table id="tblexportData" class="table  table-condensed table-striped">
                      <tr>
                        <th width="60%">Total</th>
                        <th width="15%"></th>
                        <th width="25%" style="text-align: right;"><?=number_format($totalincome,2);?></th>
                      </tr>

                      </table> 
                </div>
            
              <div class="col-md-6" id="dataTablediv">
                  <table id="tblexportData" class="table  table-condensed table-striped">
                      <tr>
                        <th width="60%">Total</th>
                        <th width="15%"></th>
                        <th width="25%" style="text-align: right;"><?=number_format($totalexpence,2);?></th>
                      </tr>

                      </table> 
                </div>
              </div>
              <?php $result = round($totalincome,2) - round($totalexpence,2); ?>
               <div class="row">
                  <div class="col-md-12" id="dataTablediv">
                    <table id="tblexportData" class="table  table-condensed table-striped">
                    <tr style="background-color: <?php if (round($result,2) == 0) { echo '#d2d5f7';}else  if (round($result,2) > 0) { echo '#cff5cb';}else if (round($result,2) < 0) { echo '#f7d2d5'; }  ?>!important;">
                      <td>
                            <b><?php if (round($result,2) == 0) {
                            echo 'Balanced';
                          }else if (round($result,2) > 0) {
                            echo 'Profit';
                          }else if (round($result,2) < 0) {
                            echo 'Loss';
                          }  ?></b>

                          <span style="margin-left:150px;"><b><?=number_format(abs($result),2);?></b></span>


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

 
</script>
</body>
</html>