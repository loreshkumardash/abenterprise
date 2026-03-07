<?php $this->load->view("common/meta");?>
<div class="wrapper">

<?php $this->load->view("common/sidebar");?>

<div class="content-wrapper">
<section class="content-header">
    <h1>
        Unit Parameter
        <small>List Units</small>
    </h1>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <?php if(in_array('unitsadd', $accessar) || $this->session->userdata('usertype') == 'Admin' || $this->session->userdata('usertype') == 'HR'){ ?>
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Search Unit</h3>
                </div>
                <form role="form" action="<?php echo site_url("masters/listunits");?>" method="post">
                    <div class="box-body">
                        <?php
                        if($this->session->flashdata('success')){
                        ?>
                        <div class="alert alert-dismissable alert-success">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <strong>Success !</strong> <?php echo $this->session->flashdata('success');?>
                        </div>
                        <?php
                        }
                        if($this->session->flashdata('error')){
                        ?>
                        <div class="alert alert-dismissable alert-danger">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <strong>Success !</strong> <?php echo $this->session->flashdata('error');?>
                        </div>
                        <?php
                        }
                        ?>
                        <div class="form-group col-md-2">
                            <label for="unit_id">Unit Code</label>
                            <input type="text" class="form-control input-sm" id="unit_id" name="unit_id" placeholder="Enter Unit Code" value="">
                        </div>
                        <div class="form-group col-md-2">
                            <label for="unit_name">Unit Name</label>
                            <input type="text" class="form-control input-sm" id="unit_name" name="unit_name" placeholder="Enter Unit Name" value="">
                        </div>
                        
                        <div class="form-group col-md-2">
                            <button type="submit" name="submitBtn" value="submit" class="btn btn-primary" style="margin-top:22px;">Search</button>
                        </div>
                    </div>
                    
                </form>
            </div>
        </div>
        <?php }?>
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">List Units</h3>
                </div>
                <div class="box-body">
                    <table id="" class="table table-bordered table-condensed table-striped">
                        <tr>
                            <th width="10%" class="text-center">SlNo.</th>
                            <th width="10%"  class="text-center">Unit Code</th>
                            <th width="30%"  class="text-left">Unit Name</th>
                            <th width="15%"  class="text-left">Location</th>
                          	<th width="15%"  class="text-left">Unit Password</th>
                            <th width="10%"  class="text-center">Description</th>
                            <th width="10%"  class="text-center">Action</th>
                        </tr>
                        <?php if($records){ for($i=0;$i<count($records);$i++){?>
                        <tr>
                            <td class="text-center"><?=$i+1;?></td>
                            <td class="text-center"><?php echo $records[$i]['unit_id'];?></td>
                            <td><?php echo $records[$i]['unit_name'];?></td>
                            <td><?php echo $records[$i]['unit_location'];?></td>
                          <td><?php echo $records[$i]['unit_password'];?></td>
                            <td><?php echo $records[$i]['description'];?></td>
                            
                            <td class="text-center">
                            
                            <?php if(in_array('unitsview', $accessar) || $this->session->userdata('usertype') == 'Admin' || $this->session->userdata('usertype') == 'HR'){ ?>
                              
                             <a class="btn btn-xs bg-maroon" href="<?=site_url("masters/forceDownloadQR/".$records[$i]['unit_id']."/400/400");?>"> Qr <i class="fa fa-download"></i></a>
                              
                            <a href="<?php echo site_url("masters/viewunit/".$records[$i]['unit_id']);?>" class="btn btn-xs btn-primary">View</a>
                            <?php }?>
                            </td>
                        </tr>
                        <?php }} ?>
                    </table>
                    <?php if($records){ echo $sPages;}else{echo '';}?>
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
<!-- ./wrapper -->

    <?php $this->load->view("common/script");?>
    <script type="text/javascript">
        $('.clockpick').clockpicker({
            autoclose:true
        });
        
        if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
    </script>
    
</body>
</html>


