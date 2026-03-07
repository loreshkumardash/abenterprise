<table class="table table-condensed table-striped" width="100%">
	<tr>
		<td colspan="2" style="text-align:center;font-size:19px;">GLOSENT</td>
	</tr>
	<tr>
		<td colspan="2">
			<b><span style="font-size:16px;color:#7a110b;">

            Period <?php if($fdate){echo date('d M Y',strtotime($fdate)).' -' ; }?>  <?php if($ldate){ echo date('d M Y',strtotime($ldate)) ; }?></span></b>
        </td>
	</tr>
	<tr>
		<td width="50%">
			<table class="table table-bordered table-condensed table-striped" border="1" width="100%">
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
                              <th style="text-align:left;"><?=$subcategory[$b]['subcategory_name'];?></th>
                              <th></th>
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
                              <td><?=$group[$c]['group_name'];?></td>
                              
                              <td style="text-align: right;"><?php $grpdiff = $grp_credit[0]['totcredit'] - $grp_debit[0]['totdebit'];
                                
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
                          <th style="text-align:left;">Sales Account</th>
                          <th></th>
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
                              <td><?=$compgst[$g]['gst_head'];?> Branch Sales</td>
                              
                              <td style="text-align: right;"><?php $grpdiff = $saleac[0]['totcredit'];
                                
                                  echo number_format($grpdiff,2);
                                
                                    ?></td>
                              <td></td>
                            </tr>

                   <?php }} }}?>
                  </table>
		</td>
		<td width="50%">
			<table id="tblexportData" class="table  table-condensed table-striped" border="1">
                      <tr>
                        <th width="60%" style="text-align:left;">PARTICULARS</th>
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
                              <th style="text-align:left;"><?=$subcategoryy[$b]['subcategory_name'];?></th>
                              <th></th>
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
                              <td><?=$group[$c]['group_name'];?></td>
                              
                              <td style="text-align: right;"><?php $grpdiff =  $grp_debit[0]['totdebit'] - $grp_credit[0]['totcredit'];
                                
                                  echo number_format($grpdiff,2);
                                
                                    ?></td>
                              <td></td>
                            </tr>
                          <?php  }}
                          ?>

                         
                      <?php }}}?>
                      <?php  $purchaseac = $this->Common_Model->db_query("SELECT SUM(item_amount) as totdebit FROM purchase_items as a LEFT JOIN purchase as d on a.purchase_id=d.purchase_id LEFT JOIN ledgers as b on d.purchase_from=b.ledger_id WHERE d.purchase_date >= '".$fdate."' AND d.purchase_date <= '".$ldate."'");
                       ?>
                      <tr class="product_tr">
                          <th style="text-align:left;">Purchase Account</th>
                          <th></th>
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
                              <td><?=$assets[$g]['item_name'];?> </td>
                              
                              <td style="text-align: right;"><?php $grpdiff = $purchaseacg[0]['totdebit'];
                                
                                  echo number_format($grpdiff,2);
                                
                                    ?></td>
                              <td></td>
                            </tr>

                   <?php }} }}?>
                  </table> 
		</td>
	</tr>
	<tr>
		<td width="50%">
			<table id="tblexportData" class="table  table-condensed table-striped" border="1">
              <tr>
                <th width="60%" style="text-align:left;">Total</th>
                <th width="15%"></th>
                <th width="25%" style="text-align: right;"><?=number_format($totalincome,2);?></th>
              </tr>

            </table>
		</td>
		<td width="50%">
			<table id="tblexportData" class="table  table-condensed table-striped" border="1">
              <tr>
                <th width="60%" style="text-align:left;">Total</th>
                <th width="15%"></th>
                <th width="25%" style="text-align: right;"><?=number_format($totalexpence,2);?></th>
              </tr>

            </table>
		</td>
	</tr>
	<tr>
		<td colspan="2">
			<?php $result = round($totalincome,2) - round($totalexpence,2); ?>
              
                    <table id="tblexportData" class="table  table-condensed table-striped" border="1">
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
		</td>
	</tr>
</table>

                   
               
                
                  
                
              
                   
                
                   
                
              
                  
 
