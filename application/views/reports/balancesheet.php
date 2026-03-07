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
              <h3 class="box-title">Balance Sheet</h3>
            </div>
            <!-- /.box-header -->
            
            <div class="box-body">
              <div class="row">
                  <div class="col-md-4">
                      <b><span style="font-size:18px;color:#7a110b;">
                        <?php if($fdate){echo date('d M Y',strtotime($fdate)).' -' ; }?>  <?php if($ldate){ echo date('d M Y',strtotime($ldate)) ; }?>
                          <input type="hidden" class="f_date" value="<?=$fdate;?>">
                          <input type="hidden" class="l_date" value="<?=$ldate;?>">
                        </span></b>
                  </div>
                  <div class="col-md-2">
                    <label for="year">From Date</label>
                    <input type="date" class="form-control" name="fromdate" id="fromdate">
                  </div>
                  <div class="col-md-2">
                    <label for="year">To Date</label>
                    <input type="date" class="form-control" name="todate" id="todate">
                  </div>
                  <div class="col-md-1" >
                    <button type="button" id="searchbtn" class="btn bg-navy btn-sm" style="margin-top:25px;">Search</button>
                  </div>
                  <div class="col-md-3">
                    <div class="float-right">
                      <a href="<?=site_url('reports/balancesheetprint_pdf/'.$fdate.'/'.$ldate);?>" class="btn btn-primary btn-sm" style="width: 9rem;" target="_blank">Print as Pdf</a>
                      <a href="<?=site_url('reports/balancesheetprint_excel/'.$fdate.'/'.$ldate);?>" class="btn btn-warning btn-sm" style="width: 9rem;">Print as Excel</a>
                    </div>
                  </div>
              </div>
              <div class="row">
                <div class="col-md-12" id="dataTablediv">
                  <table id="tblexportData" class="table  table-condensed table-striped">
                    <thead>
                      <tr>
                        <th width="40%">PARTICULARS</th>
                        <th width="15%" >OPENING</th>
                        <th width="15%">DEBIT</th>
                        <th width="15%">CREDIT</th>
                        <th width="15%">CLOSING</th>
                      </tr>
                    </thead>
                    <tbody> 
                      <?php $totaldebit=0;$totalcredit=0;
                      if ($category) { for ($a=0; $a < count($category); $a++) { 
                        $subcategory = $this->Common_Model->FetchData("subcategory","*","category_id=".$category[$a]['category_id']);

                      if ($subcategory) { for ($b=0; $b < count($subcategory); $b++) { 

                        $subcat_debitasop = $this->Common_Model->db_query("SELECT SUM(dramount) as totdebit FROM entry_items as a LEFT JOIN entries as d on a.entry_id=d.entry_id LEFT JOIN ledgers as b on a.ledger=b.ledger_id LEFT JOIN under_group as c on b.acount_group=c.group_id WHERE  c.subcategory_id=".$subcategory[$b]['subcategory_id']." AND d.entry_dt < '".$fdate."'");

                        $subcat_creditasop = $this->Common_Model->db_query("SELECT SUM(cramount) as totcredit FROM entry_items as a LEFT JOIN entries as d on a.entry_id=d.entry_id LEFT JOIN ledgers as b on a.ledger=b.ledger_id LEFT JOIN under_group as c on b.acount_group=c.group_id WHERE  c.subcategory_id=".$subcategory[$b]['subcategory_id']." AND d.entry_dt < '".$fdate."' ");

                        $subcat_openingdr = $this->Common_Model->db_query("SELECT SUM(opening_balance) as totopening FROM ledgers as a LEFT JOIN under_group as c on a.acount_group=c.group_id WHERE c.subcategory_id=".$subcategory[$b]['subcategory_id']." ");


                            $subcat_debit = $this->Common_Model->db_query("SELECT SUM(dramount) as totdebit FROM entry_items as a LEFT JOIN entries as d on a.entry_id=d.entry_id LEFT JOIN ledgers as b on a.ledger=b.ledger_id LEFT JOIN under_group as c on b.acount_group=c.group_id WHERE  c.subcategory_id=".$subcategory[$b]['subcategory_id']." AND d.entry_dt>='".$fdate."' AND d.entry_dt<='".$ldate."'");

                            $subcat_credit = $this->Common_Model->db_query("SELECT SUM(cramount) as totcredit FROM entry_items as a LEFT JOIN entries as d on a.entry_id=d.entry_id LEFT JOIN ledgers as b on a.ledger=b.ledger_id LEFT JOIN under_group as c on b.acount_group=c.group_id WHERE  c.subcategory_id=".$subcategory[$b]['subcategory_id']." AND d.entry_dt>='".$fdate."' AND d.entry_dt<='".$ldate."'");

                            
                            //$subcat_openingcr = $this->Common_Model->db_query("SELECT SUM(opening_balance) as totopening FROM ledgers as a LEFT JOIN under_group as c on a.acount_group=c.group_id WHERE a.balance_type='Cr' AND c.subcategory_id=".$subcategory[$b]['subcategory_id']." ");
                            if ($category[$a]['category_id']==1 || $category[$a]['category_id']==4) {
                            $totopening = $subcat_openingdr[0]['totopening'] + $subcat_debitasop[0]['totdebit'] - $subcat_creditasop[0]['totcredit'];
                          }else{
                              $totopening = $subcat_openingdr[0]['totopening'] + $subcat_creditasop[0]['totcredit'] - $subcat_debitasop[0]['totdebit'];
                          }
                            
                            $totaldebit +=$subcat_debit[0]['totdebit'];
                            $totalcredit +=$subcat_credit[0]['totcredit'];
                            if ($category[$a]['category_id']==1 || $category[$a]['category_id']==4) {
                              $dc = 'Dr';
                            }else{
                              $dc = 'Cr';
                            }
                            ?>
                            <tr class="product_tr">
                              <th><?=$subcategory[$b]['subcategory_name'];?></th>
                              <th>
                                  <?php echo $dc.' '.number_format(abs($totopening),2); 
                                
                                   ?>
                                </th>
                              <th><?=$subcat_debit[0]['totdebit']?number_format($subcat_debit[0]['totdebit'],2):'0.00';?></th>
                              <th><?=$subcat_credit[0]['totcredit']?number_format($subcat_credit[0]['totcredit'],2):'0.00';?></th>
                              <th><?php 
                              if ($category[$a]['category_id']==1 || $category[$a]['category_id']==4) {

                                $subdiff = $totopening + $subcat_debit[0]['totdebit']-$subcat_credit[0]['totcredit'];

                                if ($subdiff > 0) {
                                  echo 'Dr '.number_format(abs($subdiff),2); 
                                }else if ($subdiff < 0) {
                                  echo 'Cr '.number_format(abs($subdiff),2); 
                                }else{
                                  echo '0.00';
                                }
                              }else{

                                $subdiff = $totopening + $subcat_credit[0]['totcredit'] - $subcat_debit[0]['totdebit'];
                                 if ($subdiff > 0) {
                                  echo 'Cr '.number_format(abs($subdiff),2); 
                                }else if ($subdiff < 0) {
                                  echo 'Dr '.number_format(abs($subdiff),2); 
                                }else{
                                  echo '0.00';
                                }
                              }


                                    ?>
                                      
                              </th>
                            </tr>

                          <?php $group = $this->Common_Model->FetchData("under_group","*","subcategory_id=".$subcategory[$b]['subcategory_id'].""); 
                            if ($group) { for ($c=0; $c < count($group); $c++) { 
                              $grp_debitasop = $this->Common_Model->db_query("SELECT SUM(dramount) as totdebit FROM entry_items as a LEFT JOIN entries as d on a.entry_id=d.entry_id LEFT JOIN ledgers as b on a.ledger=b.ledger_id LEFT JOIN under_group as c on b.acount_group=c.group_id WHERE  b.acount_group=".$group[$c]['group_id']." AND d.entry_dt < '".$fdate."'");

                              $grp_creditasop = $this->Common_Model->db_query("SELECT SUM(cramount) as totcredit FROM entry_items as a LEFT JOIN entries as d on a.entry_id=d.entry_id LEFT JOIN ledgers as b on a.ledger=b.ledger_id LEFT JOIN under_group as c on b.acount_group=c.group_id WHERE  b.acount_group=".$group[$c]['group_id']." AND d.entry_dt < '".$fdate."'");

                              $grp_openingdr = $this->Common_Model->db_query("SELECT SUM(opening_balance) as totopening FROM ledgers as a LEFT JOIN under_group as c on a.acount_group=c.group_id WHERE a.acount_group=".$group[$c]['group_id']." ");

                              $grp_debit = $this->Common_Model->db_query("SELECT SUM(dramount) as totdebit FROM entry_items as a LEFT JOIN entries as d on a.entry_id=d.entry_id LEFT JOIN ledgers as b on a.ledger=b.ledger_id LEFT JOIN under_group as c on b.acount_group=c.group_id WHERE  b.acount_group=".$group[$c]['group_id']." AND d.entry_dt>='".$fdate."' AND d.entry_dt<='".$ldate."'");

                            $grp_credit = $this->Common_Model->db_query("SELECT SUM(cramount) as totcredit FROM entry_items as a LEFT JOIN entries as d on a.entry_id=d.entry_id LEFT JOIN ledgers as b on a.ledger=b.ledger_id LEFT JOIN under_group as c on b.acount_group=c.group_id WHERE  b.acount_group=".$group[$c]['group_id']." AND d.entry_dt>='".$fdate."' AND d.entry_dt<='".$ldate."'");

                            
                            //$grp_openingcr = $this->Common_Model->db_query("SELECT SUM(opening_balance) as totopening FROM ledgers as a LEFT JOIN under_group as c on a.acount_group=c.group_id WHERE a.balance_type='Cr' AND a.acount_group=".$group[$c]['group_id']." ");
                            if ($category[$a]['category_id']==1 || $category[$a]['category_id']==4) {
                            $totopeninggrp = $grp_openingdr[0]['totopening'] + $grp_debitasop[0]['totdebit'] - $grp_creditasop[0]['totcredit'];
                          }else{
                              $totopeninggrp = $grp_openingdr[0]['totopening'] + $grp_creditasop[0]['totcredit'] - $grp_debitasop[0]['totdebit'];
                          }


                              ?>
                            <tr class="product_tr balancesheet_ledgers" data-id="<?=$group[$c]['group_id'];?>">
                              <td>&nbsp&nbsp<?=$group[$c]['group_name'];?></td>
                              <td>&nbsp&nbsp<?php 
                                  echo $dc.' '.number_format(abs($totopeninggrp),2); 
                                 ?></td>
                              <td>&nbsp&nbsp<?=$grp_debit[0]['totdebit']?number_format($grp_debit[0]['totdebit'],2):'0.00';?></td>
                              <td>&nbsp&nbsp<?=$grp_credit[0]['totcredit']?number_format($grp_credit[0]['totcredit'],2):'0.00';?></td>
                              <td>&nbsp&nbsp

                                <?php 
                              if ($category[$a]['category_id']==1 || $category[$a]['category_id']==4) {
                              $grpdiff =  $grp_debit[0]['totdebit']-$grp_credit[0]['totcredit'] + $totopeninggrp;
                            }else{
                              $grpdiff =   $totopeninggrp + $grp_credit[0]['totcredit']-$grp_debit[0]['totdebit'];
                            }

                              if ($category[$a]['category_id']==1 || $category[$a]['category_id']==4) {
                                if ($grpdiff > 0) {
                                  echo 'Dr '.number_format(abs($grpdiff),2); 
                                }else if ($grpdiff < 0) {
                                  echo 'Cr '.number_format(abs($grpdiff),2); 
                                }else{
                                  echo '0.00';
                                }
                              }else{
                                if ($grpdiff > 0) {
                                  echo 'Cr '.number_format(abs($grpdiff),2); 
                                }else if ($grpdiff < 0) {
                                  echo 'Dr '.number_format(abs($grpdiff),2); 
                                }else{
                                  echo '0.00';
                                }
                              }
                                    ?>
                                      
                              </td>
                            </tr>
                          <?php  }}
                          ?>

                     <?php   }}
                      
                       ?>
                       <?php   }}
                      
                       ?>

                       <tr>
                         <th>Total</th>
                         <th></th>
                         <th>Dr <?=number_format($totaldebit,2);?></th>
                         <th>Cr <?=number_format($totalcredit,2);?></th>
                         <th></th>
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
  $(document).on('click', '.balancesheet_ledgers', function(){
      var id = $(this).attr('data-id');
      var fdate = $(".f_date").val();
      var ldate = $(".l_date").val();
      var url = "<?php echo site_url(); ?>";
      /*document.location.href=url+"/reports/todaysgrossprofitWithDay/"+id;*/
      document.location.href=url+'reports/balancesheet_ledgers/'+id+'/'+fdate+'/'+ldate;
    });
 $(document).on('click', '#searchbtn', function(){
      
     var fromdate = $("#fromdate").val();
      var todate = $("#todate").val();
      if (fromdate !='' && todate != '') {
      var url = "<?php echo site_url(); ?>";
      /*document.location.href=url+"/reports/todaysgrossprofitWithDay/"+id;*/
      document.location.href=url+'/reports/balancesheet/'+fromdate+'/'+todate;
    }
    });
</script>
</body>
</html>
