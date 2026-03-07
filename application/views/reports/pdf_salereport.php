          
              <table class="table" width="100%" style="margin-bottom: 0px;font-family: serif;">
                <tr>
                  <th style="text-align:center;">
                      <span style="margin: 0px;font-size: 15px;">IMPRONEX SECURITY SERVICES</span><br>
                      <span style="margin: 0px;font-size: 15px;">PLOT NO-126/2899,LANE-1,KHANDAGIRI VIHAR BHUBANESWAR,KHORDHA, ODISHA,751030</span><br>
                      <span style="margin-top: 0px;margin-bottom: 4px;color: black;font-family: serif;font-size: 15px;">SALE REPORT</span>
                  </th>
                </tr>
              </table>
              <br><br><br><br>

          <table id="" class="table table-bordered table-condensed table-striped" style="font-size: 16px!important;font-family: serif;" cellpadding="3">
                <tr>
                  <th width="10%" style="text-align:center;border-top: 1px solid black;border-bottom: 1px solid black;">#SL</th>
                  <th width="40%" style="border-top: 1px solid black;border-bottom: 1px solid black;">MONTH</th>
                  <th width="25%" style="text-align:right;border-top: 1px solid black;border-bottom: 1px solid black;">INVOICE AMOUNT</th>
                  <th width="25%" style="text-align:right;border-top: 1px solid black;border-bottom: 1px solid black;">RECEIPT AMOUNT</th>
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
                        <td width="10%" style="text-align:center;"><?=$i+1;?></td>
                        <td width="40%"><?=date('F - Y',strtotime($months[$i]));?></td>
                        <td width="25%" style="text-align:right;"><?=$invoice[0]['ia']>0?number_format($invoice[0]['ia'],2):'';?></td>
                        <td width="25%" style="text-align:right;"><?=$receipt[0]['ra']>0?number_format($receipt[0]['ra'],2):'';?></td>
                      </tr>

                <?php  } ?>
                    <tr>
                      <th width="10%" style="text-align:center;border-bottom: 1px solid black;"></th>
                      <th width="40%" style="border-bottom: 1px solid black;"></th>
                      <th width="25%" style="text-align:right;border-bottom: 1px solid black;"></th>
                      <th width="25%" style="text-align:right;border-bottom: 1px solid black;"></th>
                    </tr>  
              </table>