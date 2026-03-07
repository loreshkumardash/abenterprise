<table width="100%">
    <tr>
        <td width="20%"><p width:100%;>&nbsp;&nbsp;</p><img src="<?=base_url();?>assets/img/phoenixlogo.png" alt="Young Phoenix" width="90"></td>
        <td width="60%" valign="top">
        <p align="center" width="100%" style="margin-top:0px; font-weight:bold; font-size:12px;">
        <span style="font-size: 23px; font-weight: bold; margin:0;">YOUNG PHOENIX PUBLIC SCHOOL</span><br/>
        Affiliated to CBSE, New Delhi<br/>
        DAY - CUM - RESIDENCIAL<br/>
        Gopinathpur, Bhubaneswar - 2, Ph. No.(0674) 2343851, Mob. : 8658599505<br/>
        Affiliation No.: 1530218 &nbsp;&nbsp;&nbsp;&nbsp;   School Code : 53200
        </p>
        <h3 align="center" style="font-size: 18px; font-weight: bold; text-decoration:underline;">NOTICE</h3>
        </td>
        <td width="20%"></td>
    </tr>
</table>
<p style="font-size:14px;"><b><?=stripslashes($notice[0]['notice_title'])?>, Notice No. (<?=$notice[0]['notice_no']?>)</b><br>
<a href="<?=base_url();?>/uploads/studentdata/<?=$notice[0]['notice_file'];?>">View File</a>
</p>
<?=nl2br(stripslashes($notice[0]['notice_description']));?>
<img src="<?=base_url();?>/uploads/studentdata/<?=$notice[0]['notice_file'];?>" style="width:500px; height:520px;">
