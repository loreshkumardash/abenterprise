<br><h2 style="text-align:center;">PROFESSIONAL TAX TO BE DEDUCTED AS PER  SLAB  RATE </h2>
<table class="table table-bordered table-condensed table-striped" border="1" cellpadding="3" style="font-family:sans-serif;">
	<?php if ($rec) { for ($i=0; $i < count($rec); $i++) { 
		$state = $this->Common_Model->FetchData("state","*","state_id=".$rec[$i]['state_id']);
		$ptm = $this->Common_Model->FetchData("ptm","*","state_id=".$rec[$i]['state_id']." ORDER BY ratefrom ASC");
		?>
	<tr style="font-size:13px;">
		<th width="20%"><b>State</b></th>
		<th width="60%"><b>Slab Rate</b></th>
		<th width="20%"><b>Professional Tax</b></th>
	</tr>
		<?php if ($ptm) { for ($a=0; $a < count($ptm); $a++) {  ?>
		<tr style="font-size:13px;">
			<td width="20%"><?=$a==0?$state[0]['state_title']:'';?></td>
			<td width="60%"><?=(float)$ptm[$a]['ratefrom'];?> <?=$ptm[$a]['ratetype']=='1'?'to '.(float)$ptm[$a]['rateto']:'and above';?> </td>
			<td width="20%" style="text-align:right;"><?=(float)$ptm[$a]['proftax'];?></td>
		</tr>
		<?php }} ?>
	<?php }} ?>
</table>