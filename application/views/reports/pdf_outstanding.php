    <table class="table" width="100%" style="margin-bottom: 0px;font-family: serif;">
        <tr>
          <th style="text-align:center;">
              <span style="margin: 0px;font-size: 15px;">IMPRONEX SECURITY SERVICES</span><br>
              <span style="margin: 0px;font-size: 15px;">PLOT NO-126/2899,LANE-1,KHANDAGIRI VIHAR BHUBANESWAR,KHORDHA, ODISHA,751030</span><br>
              <span style="margin-top: 0px;margin-bottom: 4px;color: black;font-family: serif;font-size: 15px;">OUTSTANDING REPORT</span>
          </th>
        </tr>
      </table>
      <br><br>

    <table id="" class="table table-bordered table-condensed table-striped" style="font-size: 12px;" cellpadding="2">
        <tr>
          <th width="5%" style="text-align:center;border-top: 1px solid black;border-bottom: 1px solid black;"><b>#SL</b></th>
          <th width="35%" style="border-top: 1px solid black;border-bottom: 1px solid black;"><b>PARTICULARS</b></th>
          <th width="20%" style="text-align:right;border-top: 1px solid black;border-bottom: 1px solid black;"><b>INVOICE AMOUNT</b></th>
          <th width="20%" style="text-align:right;border-top: 1px solid black;border-bottom: 1px solid black;"><b>CREDIT</b></th>
          <th width="20%" style="text-align:right;border-top: 1px solid black;border-bottom: 1px solid black;"><b>BALANCE</b></th>
      
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
            <td width="5%" style="text-align:center;"><?=$i+1;?></td>
            <td width="35%"><?=$ledger[$i]['ledger_name'];?></td>
            <td width="20%" style="text-align:right;"><?=number_format($inv[0]['totinvamt'],2);?></td>
            <td width="20%" style="text-align:right;"><?=number_format($rcpt[0]['totrcptamt'],2);?></td>
            <td width="20%" style="text-align:right;"><?=number_format($balance,2);?></td>
            
          </tr>
        <?php } ?>
          <tr>
            <td width="40%" colspan="2" style="text-align:center;border-top: 1px solid black;border-bottom: 1px solid black;"><b>TOTAL</b></td>

            <td width="20%" style="text-align:right;border-top: 1px solid black;border-bottom: 1px solid black;"><b><?=number_format($invtotal,2);?></b></td>

            <td width="20%" style="text-align:right;border-top: 1px solid black;border-bottom: 1px solid black;"><b><?=number_format($rcpttotal,2);?></b></td>

            <td width="20%" style="text-align:right;border-top: 1px solid black;border-bottom: 1px solid black;"><b><?=number_format($baltotal,2);?></b></td>
          </tr>
      <?php } ?>
      </table>