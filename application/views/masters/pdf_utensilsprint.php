<table width="100%" style="font-weight:600;font-family: serif;">
	<tr>
		<td width="15%" style="border-top: 1px solid black;border-left: 1px solid black;">
			<img src="<?=base_url("assets/img/technologoupd.png");?>" height="80px">
		</td>
		<td width="70%" style="text-align:center;border-top: 1px solid black;">
			
				<span style="font-size:13px;"><b>UTENSIL RECEIPT</b></span> <br>
				<span style="font-size:15px;"><b>TECHNO FACILITY AND MANAGEMENT SERVICES</b></span><br>
				<span>PLOT NO-370/4281, Damana Square, Chandrasekharpur, BHUBANESWAR</span> <br>
				<span>PH: 0674-2579750, E-mail: technofacilitymanagement@gmail.com</span>
			
		</td>
		<td width="15%" style="border-top: 1px solid black;border-right: 1px solid black;">
		
		</td>
	</tr>
</table>
<table style="font-weight:600;font-family: serif;">
	<tr>
		<td width="40%" style="border-top: 1px solid black;border-left: 1px solid black;border-right: 1px solid black;font-size: 12px;">
			<span>To,</span><br>
			<span style="text-transform:uppercase;"><?=$rec[0]['ledger_name'];?></span><br>
			<span style="text-transform:uppercase;"><?=$rec[0]['address'];?></span>

		</td>
		<td width="60%" style="border-top: 1px solid black;border-right: 1px solid black;font-size: 14px;">
			<span>Receipt No. - <?=$rec[0]['utensil_id'];?></span><br>
			<span>Receipt Date - <?=date('d-m-Y',strtotime($rec[0]['utensiladded_on']));?></span><br><br><br>
			
			
		</td>
	</tr>
	
</table>

<table style="font-weight:600;font-family: serif;font-size: 14px;" cellpadding="3">
	
		<tr>
			<td style="border-top: 1px solid black;border-left: 1px solid black;border-right: 1px solid black;border-bottom: 1px solid black;text-align: center;" width="10%">#SL</td>

			<td style="border-top: 1px solid black;border-right: 1px solid black;border-bottom: 1px solid black;text-align: center;" width="30%">ITEMS</td>
			
			<td style="border-top: 1px solid black;border-right: 1px solid black;border-bottom: 1px solid black;text-align: center;" width="15%">UNIT</td>
			<td style="border-top: 1px solid black;border-right: 1px solid black;border-bottom: 1px solid black;text-align: center;" width="15%">QUANTITY</td>
			<td style="border-top: 1px solid black;border-right: 1px solid black;border-bottom: 1px solid black;text-align: center;" width="15%">RATE/UNIT</td>

			<td style="border-top: 1px solid black;border-right: 1px solid black;border-bottom: 1px solid black;text-align: center;" width="15%">AMOUNT</td>

		</tr>
		
	<?php if ($items) { for ($i=0; $i < count($items); $i++) { ?>
		
		<tr>
			<td style="border-left: 1px solid black;border-right: 1px solid black;font-size: 13px;text-align: center;" width="10%">
				<?=$i+1;?>
			</td>

			<td style="border-right: 1px solid black;" width="30%">
				 <?=$items[$i]['item_name'];?>
			</td>

			<td style="border-right: 1px solid black;text-align: center;" width="15%">
				<?=$items[$i]['item_unit'];?>
			</td>
			<td style="border-right: 1px solid black;text-align: center;" width="15%">
				<?=$items[$i]['item_quantity'];?>
			</td>

			<td style="border-right: 1px solid black;text-align: center;" width="15%">
				<?=$items[$i]['item_rate'];?>
			</td>

			<td style="border-right: 1px solid black;text-align: center;" width="15%">
				<?=$items[$i]['item_amount'];?>
			</td>

		</tr>
	

	<?php }} ?>
	<tr>
			<td style="border-left: 1px solid black;border-right: 1px solid black;font-size: 12px;text-align: center;" width="10%"></td><td style="border-right: 1px solid black;font-size: 12px;" width="30%"></td><td style="border-right: 1px solid black;font-size: 12px;text-align: center;" width="15%"></td><td style="border-right: 1px solid black;font-size: 12px;text-align: center;" width="15%"></td><td style="border-right: 1px solid black;font-size: 12px;text-align: center;" width="15%"></td><td style="border-right: 1px solid black;font-size: 12px;text-align: center;" width="15%"></td>

		</tr>
		<tr>
			<td style="border-left: 1px solid black;border-right: 1px solid black;font-size: 12px;text-align: center;" width="10%"></td><td style="border-right: 1px solid black;font-size: 12px;" width="30%"></td><td style="border-right: 1px solid black;font-size: 12px;text-align: center;" width="15%"></td><td style="border-right: 1px solid black;font-size: 12px;text-align: center;" width="15%"></td><td style="border-right: 1px solid black;font-size: 12px;text-align: center;" width="15%"></td><td style="border-right: 1px solid black;font-size: 12px;text-align: center;" width="15%"></td>

		</tr>
		<tr>
			<td colspan="5" style="border-right: 1px solid black;border-left: 1px solid black;border-top: 1px solid black;font-size: 12px;text-align: right;" >
					<b>GRAND TOTAL</b>
			</td>

			<td colspan="1" style="border-right: 1px solid black;border-top: 1px solid black;font-size: 12px;text-align: right;" >
				<?=$rec[0]['totalamount'];?>
			</td>
		</tr>

		<tr>
			
			<td colspan="8" style="border-left: 1px solid black;border-right: 1px solid black;border-top: 1px solid black;font-size: 12px;" >
				Amount in words : <span style="text-transform:uppercase;"><b><?=translateToWords(floatval(round($rec[0]['totalamount'])));?> ONLY</b></span>
				
			</td>
		</tr>
	</table>

<table style="font-weight:600;font-family: serif;" cellpadding="2">
	<tr>
			<td width="30%" style="border-left: 1px solid black;border-top: 1px solid black;border-bottom: 1px solid black;font-size: 11px;text-align: center;" >
				<br><br><br><br><br>
				<span>PREPARED BY</span>
			</td>
			<td width="40%" style="border-top: 1px solid black;border-bottom: 1px solid black;font-size: 11px;text-align: center;" >
				<br><br><br><br><br>
				<span>CHECKED BY</span>
			</td>

			<td width="30%" style="border-right: 1px solid black;border-top: 1px solid black;border-bottom: 1px solid black;font-size: 11px;text-align: center;" >
				<br><br><br><br><br>
				<span>AUTHORISE SIGNATORY</span>
			</td>
		</tr>
</table>


