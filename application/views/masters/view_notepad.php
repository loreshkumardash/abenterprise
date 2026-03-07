 
<table width="100%">
    <tr>
        <td width="20%"><p width:100%;>&nbsp;&nbsp;</p><img src="<?=base_url();?>assets/img/phoenixlogo.png" alt="Young Phoenix" width="80"><br/>
	&nbsp;<p style="text-align:left; font-weight:bold; font-size: 12px; color:#046481;">Ref.: 101/2020</p>
	</td>
        <td width="60%" valign="top">
       <p align="center" width="100%" style="margin-top:0px; font-weight:bold; font-size:12px; color:#046481;">
        <div>
	    <span style="font-size: 24px; font-weight: bold; margin:0; color:#046481;">YOUNG PHOENIX PUBLIC SCHOOL</span><br/>
	    <center><hr style="color:#046481; line-height:4px;"><center>
	</div>
        Affiliated to CBSE, New Delhi<br/>
        Gopinathpur, Bhubaneswar - 2, Ph. No.(0674) 2343851, Mob. : 8658599505<br/>
	<div style="line-height:4px;">
	<hr style="color:#046481;">
	</div>	
      </p>
	
	<h3 align="center" style="font-size: 18px; font-weight: bold; text-decoration:underline;">NOTEPAD</h3>
        </td>
        <td width="20%">
		<div style="text-align:right; font-size: 12px; font-weight: bold; color:#046481;">AFF. No.: 1530218</div><br/><br/><br/><br/><br/><br>
		<p style="text-align:right; line-height:17px; font-weight:bold; font-size: 12px; color:#046481;">Date.: <?php echo $notepad[0]['created_on'];?></p>
	</td>
    </tr>
</table>
<center><h3 style="color:#046481;">Notepad No.  <?php echo $notepad[0]['notepad_no'];?></h3></center>
<p style="font-size:14px;"><b><?=stripslashes($notepad[0]['subject'])?></b></p>

<?=nl2br(stripslashes($notepad[0]['notes']));?>