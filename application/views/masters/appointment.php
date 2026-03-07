<?php $this->load->view("common/meta");?>
<div class="wrapper">
<?php $this->load->view("common/sidebar");?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">

</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Appointment</h3>
                </div>
            <!-- /.box-header -->
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12">
                            <form method="post" action="appointment">
                                <table class="table table-bordered table-condensed">
                                    <tr>                      
                                        <th>Select</th>                      
                                        <th>Date</th>
                                        <th>Time</th>
                                        <th>Name</th>
                                        <th>Contact No</th>
                                        <th>Email-Id</th>
                                        <th>Cause</th>
                                        <th>Action</th>
                                    </tr>
                                    <?php if($records){$j = 1; for($i=0;$i<count($records);$i++){?>
                                    <tr>
                                        <td><?php if(!empty($records[$i]['response'])){echo "";}else{?><input type="checkbox" name="appId" value="<?=$records[$i]['id'];?>"><?php }?></td>
                                        <td><?=$records[$i]['entry_date'];?></td>
                                        <td><?=$records[$i]['timing'];?></td>
                                        <td><?=$records[$i]['name'];?></td>
                                        <td><?=$records[$i]['contact_no'];?></td>
                                        <td><?=$records[$i]['email'];?></td>
                                        <td><?=$records[$i]['cause'];?></td>	
                                        <td>
                                        <?php if(!empty($records[$i]['response'])){
                                        echo $records[$i]['response'];
                                        }else{?>
                                        <input type="submit" class="btn btn-warning btn-xs" name="submitBtn" value="Approve">&nbsp;<input type="submit" name="cancelBtn" class="btn btn-primary btn-xs" value="Cancel">
                                        <?php }?>
                                        </td>
                                    </tr>  
                                    <?php }}?>                 
                                </table>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                <?php //if($records){echo $sPages; }?>
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
<?php $this->load->view("common/script");?>
<script src="<?=base_url();?>bower_components/select2/dist/js/select2.full.min.js"></script>
<script type="text/javascript">

</script>

</body>
</html>