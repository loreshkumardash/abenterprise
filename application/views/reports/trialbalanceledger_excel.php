                  <table class="table table-condensed table-striped" cellpadding="2" border="1">
                    <tr>
                      <td width="70%" colspan="3"><span style="font-size:16px;"><b>GLOSENT</b></span></td>
                      <td width="30%" colspan="2"><b style="font-size:12px;">Group : <?=$group[0]['group_name'];?></b></td>
                    </tr>
                    <tr>
                      <td  width="70%" colspan="3"><span style="font-size:12px;"><b>Trial Balance Details</b></span></td>
                      <td width="30%" colspan="2"><span style="font-size:12px;"><b><span><?php if($fdate){echo date('d M Y',strtotime($fdate)).' -' ; }?>  <?php if($ldate){ echo date('d M Y',strtotime($ldate)) ; }?></span></b></span></td>

                    </tr>
                  </table>
                  <table id="tblexportData" class="table  table-condensed table-striped" cellpadding="2" style="font-size: 13px;" border="1">
                    <thead>
                      <tr style="background-color:#ddd;">
                        <th style="text-align:left;">PARTICULARS</th>
                        <th>OPENING</th>
                        <th>DEBIT</th>
                        <th>CREDIT</th>
                        <th>CLOSING</th>
                      </tr>
                    </thead>
                    <tbody> 
                      <?php if ($ledgers) { $drtotal =0;$crtotal =0; for ($i=0; $i < count($ledgers); $i++) { 

                        $category = $this->Common_Model->FetchData("under_group as a LEFT JOIN subcategory as b on a.subcategory_id=b.subcategory_id","*","group_id=".$ledgers[$i]['acount_group']."");

                            $ledg_debitasop = $this->Common_Model->db_query("SELECT SUM(dramount) as totdebit FROM entry_items as a LEFT JOIN entries as d on a.entry_id=d.entry_id LEFT JOIN ledgers as b on a.ledger=b.ledger_id LEFT JOIN under_group as c on b.acount_group=c.group_id WHERE  b.ledger_id=".$ledgers[$i]['ledger_id']." AND d.entry_dt < '".$fdate."' ");

                        $ledg_creditasop = $this->Common_Model->db_query("SELECT SUM(cramount) as totcredit FROM entry_items as a LEFT JOIN entries as d on a.entry_id=d.entry_id LEFT JOIN ledgers as b on a.ledger=b.ledger_id LEFT JOIN under_group as c on b.acount_group=c.group_id WHERE  b.ledger_id=".$ledgers[$i]['ledger_id']." AND d.entry_dt < '".$fdate."' ");

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
                            $balance = $opening + $ledg_credit[0]['totcredit'] - $ledg_debit[0]['totdebit'];
                          }

                            $drtotal +=$ledg_debit[0]['totdebit'];
                            $crtotal +=$ledg_credit[0]['totcredit'];
                        ?>
                        <tr class="product_tr">
                        <td><?=$ledgers[$i]['ledger_name'];?></td>
                        <td><?php if ($category[0]['category_id']==1 || $category[0]['category_id']==4) {
                              echo 'Dr';
                            }else{echo 'Cr';} ?> <?=number_format($opening,2);?></td>
                        <td><?=$ledg_debit[0]['totdebit']?number_format($ledg_debit[0]['totdebit'],2):'0.00';?></td>
                        <td><?=$ledg_credit[0]['totcredit']?number_format($ledg_credit[0]['totcredit'],2):'0.00';?></td>
                        <td><?php if ($category[0]['category_id']==1 || $category[0]['category_id']==4) {

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

                        <tr style="background-color: #ddd;">
                          <th><b>Total</b></th>
                          <th></th>
                          <th><b>Dr <?=number_format($drtotal,2);?></b></th>
                          <th><b>Cr <?=number_format($crtotal,2);?></b></th>
                          <th></th>
                        </tr>

                    </tbody>

                     
                  </table> 
                