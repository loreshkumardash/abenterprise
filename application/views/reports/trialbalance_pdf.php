    <table class="table table-condensed table-striped" cellpadding="3">
      <tr>
        <td width="70%"><span style="font-size:16px;"><b>GLOSENT</b></span></td>
        <td width="30%"></td>
      </tr>
      <tr>
        <td  width="70%"><span style="font-size:12px;"><b>Trial Balance</b></span></td>
        <td width="30%"><span style="font-size:12px;"><b><span><?php if($fdate){echo date('d M Y',strtotime($fdate)).' -' ; }?>  <?php if($ldate){ echo date('d M Y',strtotime($ldate)) ; }?></span></b></span></td>

      </tr>
    </table>
    <table id="tblexportData" class="table table-condensed table-striped" cellpadding="2" style="font-size: 11px;">
      <thead>
        <tr style="background-color: #ddd;">
          <th width="40%">PARTICULARS</th>
          <th width="15%" >OPENING</th>
          <th width="15%">DEBIT</th>
          <th width="15%">CREDIT</th>
          <th width="15%">CLOSING</th>
        </tr>
      </thead>
      <tbody>
        <?php  $totaldebit=0;$totalcredit=0;
        if ($subcategory) { for ($b=0; $b < count($subcategory); $b++) {
            
            $subcat_debitasop = $this->Common_Model->db_query("SELECT SUM(dramount) as totdebit FROM entry_items as a LEFT JOIN entries as d on a.entry_id=d.entry_id LEFT JOIN ledgers as b on a.ledger=b.ledger_id LEFT JOIN under_group as c on b.acount_group=c.group_id WHERE  c.subcategory_id=".$subcategory[$b]['subcategory_id']." AND d.entry_dt < '".$fdate."'");

           $subcat_creditasop = $this->Common_Model->db_query("SELECT SUM(cramount) as totcredit FROM entry_items as a LEFT JOIN entries as d on a.entry_id=d.entry_id LEFT JOIN ledgers as b on a.ledger=b.ledger_id LEFT JOIN under_group as c on b.acount_group=c.group_id WHERE  c.subcategory_id=".$subcategory[$b]['subcategory_id']." AND d.entry_dt < '".$fdate."'");
           
              $subcat_debit = $this->Common_Model->db_query("SELECT SUM(dramount) as totdebit FROM entry_items as a LEFT JOIN entries as d on a.entry_id=d.entry_id LEFT JOIN ledgers as b on a.ledger=b.ledger_id LEFT JOIN under_group as c on b.acount_group=c.group_id WHERE  c.subcategory_id=".$subcategory[$b]['subcategory_id']." AND d.entry_dt>='".$fdate."' AND d.entry_dt<='".$ldate."'");

              $subcat_credit = $this->Common_Model->db_query("SELECT SUM(cramount) as totcredit FROM entry_items as a LEFT JOIN entries as d on a.entry_id=d.entry_id LEFT JOIN ledgers as b on a.ledger=b.ledger_id LEFT JOIN under_group as c on b.acount_group=c.group_id WHERE  c.subcategory_id=".$subcategory[$b]['subcategory_id']." AND d.entry_dt>='".$fdate."' AND d.entry_dt<='".$ldate."'");

              $subcat_openingdr = $this->Common_Model->db_query("SELECT SUM(opening_balance) as totopening FROM ledgers as a LEFT JOIN under_group as c on a.acount_group=c.group_id WHERE c.subcategory_id=".$subcategory[$b]['subcategory_id']." ");
              //$subcat_openingcr = $this->Common_Model->db_query("SELECT SUM(opening_balance) as totopening FROM ledgers as a LEFT JOIN under_group as c on a.acount_group=c.group_id WHERE a.balance_type='Cr' AND c.subcategory_id=".$subcategory[$b]['subcategory_id']." ");

              if ($subcategory[$b]['category_id']==1 || $subcategory[$b]['category_id']==4) {
                  $totopening = $subcat_openingdr[0]['totopening'] + $subcat_debitasop[0]['totdebit'] - $subcat_creditasop[0]['totcredit'];
                }else{
                    $totopening = $subcat_openingdr[0]['totopening'] + $subcat_creditasop[0]['totcredit'] - $subcat_debitasop[0]['totdebit'];
                }
              
              $totaldebit +=$subcat_debit[0]['totdebit'];
              $totalcredit +=$subcat_credit[0]['totcredit'];
                if ($subcategory[$b]['category_id']==1 || $subcategory[$b]['category_id']==4) {
                              $dc = 'Dr';
                            }else{
                              $dc = 'Cr';
                            }
              ?>
              <tr class="product_tr">
                <th width="40%"><b><?=$subcategory[$b]['subcategory_name'];?></b></th>
                <th width="15%"><b><?php echo $dc.' '.number_format(abs($totopening),2); 
                                
                                   ?>
                  </b></th>
                <th width="15%"><b><?=$subcat_debit[0]['totdebit']?number_format($subcat_debit[0]['totdebit'],2):'0.00';?></b></th>
                <th width="15%"><b><?=$subcat_credit[0]['totcredit']?number_format($subcat_credit[0]['totcredit'],2):'0.00';?></b></th>
                <th width="15%"><b><?php 
                         if ($subcategory[$b]['category_id']==1 || $subcategory[$b]['category_id']==4) {
                          $subdiff = $totopening + $subcat_debit[0]['totdebit'] - $subcat_credit[0]['totcredit'];

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
                        
                </b></th>
              </tr>

            <?php $group = $this->Common_Model->FetchData("under_group","*","subcategory_id=".$subcategory[$b]['subcategory_id'].""); 
              if ($group) { for ($c=0; $c < count($group); $c++) { 

                $grp_debitasop = $this->Common_Model->db_query("SELECT SUM(dramount) as totdebit FROM entry_items as a LEFT JOIN entries as d on a.entry_id=d.entry_id LEFT JOIN ledgers as b on a.ledger=b.ledger_id LEFT JOIN under_group as c on b.acount_group=c.group_id WHERE  b.acount_group=".$group[$c]['group_id']." AND d.entry_dt < '".$fdate."' ");

                $grp_creditasop = $this->Common_Model->db_query("SELECT SUM(cramount) as totcredit FROM entry_items as a LEFT JOIN entries as d on a.entry_id=d.entry_id LEFT JOIN ledgers as b on a.ledger=b.ledger_id LEFT JOIN under_group as c on b.acount_group=c.group_id WHERE  b.acount_group=".$group[$c]['group_id']." AND d.entry_dt < '".$fdate."'");
                
                $grp_debit = $this->Common_Model->db_query("SELECT SUM(dramount) as totdebit FROM entry_items as a LEFT JOIN entries as d on a.entry_id=d.entry_id LEFT JOIN ledgers as b on a.ledger=b.ledger_id LEFT JOIN under_group as c on b.acount_group=c.group_id WHERE  b.acount_group=".$group[$c]['group_id']." AND d.entry_dt>='".$fdate."' AND d.entry_dt<='".$ldate."'");

              $grp_credit = $this->Common_Model->db_query("SELECT SUM(cramount) as totcredit FROM entry_items as a LEFT JOIN entries as d on a.entry_id=d.entry_id LEFT JOIN ledgers as b on a.ledger=b.ledger_id LEFT JOIN under_group as c on b.acount_group=c.group_id WHERE  b.acount_group=".$group[$c]['group_id']." AND d.entry_dt>='".$fdate."' AND d.entry_dt<='".$ldate."'");

              $grp_openingdr = $this->Common_Model->db_query("SELECT SUM(opening_balance) as totopening FROM ledgers as a LEFT JOIN under_group as c on a.acount_group=c.group_id WHERE a.acount_group=".$group[$c]['group_id']." ");
              //$grp_openingcr = $this->Common_Model->db_query("SELECT SUM(opening_balance) as totopening FROM ledgers as a LEFT JOIN under_group as c on a.acount_group=c.group_id WHERE a.balance_type='Cr' AND a.acount_group=".$group[$c]['group_id']." ");

             if ($subcategory[$b]['category_id']==1 || $subcategory[$b]['category_id']==4) {
                    $totopeninggrp = $grp_openingdr[0]['totopening'] + $grp_debitasop[0]['totdebit'] - $grp_creditasop[0]['totcredit'];
                  }else{
                      $totopeninggrp = $grp_openingdr[0]['totopening'] + $grp_creditasop[0]['totcredit'] - $grp_debitasop[0]['totdebit'];
                  }


                ?>
              <tr class="product_tr trialbalance_ledgers" data-id="<?=$group[$c]['group_id'];?>">
                <td width="40%"><?=$group[$c]['group_name'];?></td>
                <td width="15%"><?php 
                                  echo $dc.' '.number_format(abs($totopeninggrp),2); 
                                 ?></td>
                <td width="15%"><?=$grp_debit[0]['totdebit']?number_format($grp_debit[0]['totdebit'],2):'0.00';?></td>
                <td width="15%"><?=$grp_credit[0]['totcredit']?number_format($grp_credit[0]['totcredit'],2):'0.00';?></td>
                <td width="15%"><?php 
                        if ($subcategory[$b]['category_id']==1 || $subcategory[$b]['category_id']==4) {
                          $grpdiff = $totopeninggrp + $grp_debit[0]['totdebit'] - $grp_credit[0]['totcredit'];

                        if ($grpdiff > 0) {
                          echo 'Dr '.number_format(abs($grpdiff),2); 
                        }else if ($grpdiff < 0) {
                          echo 'Cr '.number_format(abs($grpdiff),2); 
                        }else{
                          echo '0.00';
                        }
                      }else{
                        $grpdiff = $totopeninggrp + $grp_credit[0]['totcredit'] - $grp_debit[0]['totdebit'];

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
         <tr style="background-color: #ddd;">
           <th width="40%"><b>Total</b></th>
           <th width="15%"></th>
           <th width="15%"><b>Dr <?=number_format($totaldebit,2);?></b></th>
           <th width="15%"><b>Cr <?=number_format($totalcredit,2);?></b></th>
           <th width="15%"></th>
         </tr>
      </tbody>

       
    </table> 
                