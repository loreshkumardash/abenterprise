<?php $this->load->view("common/meta");?>
<div class="wrapper">

<?php $this->load->view("common/sidebar");?>

<div class="content-wrapper">
<section class="content-header">
    <h1>
        Master Data
        <small>Units</small>
    </h1>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <?php if(in_array('unitsadd', $accessar) || $this->session->userdata('usertype') == 'Admin'){ ?>
        <div class="col-md-4">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Add Unit</h3>
                </div>
                <form role="form" action="<?php echo site_url("masters/units?ledger_id=".$ledger_id."&did=".$did);?>" method="post">
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
                        <div class="form-group">
                            <label for="unit_name">Unit Name</label>
                            <input type="text" class="form-control" id="unit_name" name="unit_name" placeholder="Enter Unit Name" value="<?=$rec[0]['unit_name']?$rec[0]['unit_name']:'';?>">
                        </div>
                        <div class="form-group">
                            <label for="unit_location">Unit Location</label>
                            <input type="text" class="form-control" id="unit_location" name="unit_location" placeholder="Enter Location" value="<?=$rec[0]['unit_location']?$rec[0]['unit_location']:'';?>">
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea  class="form-control" id="description" name="description" placeholder="Enter Unit Description" rows="3"><?=$rec[0]['description']?$rec[0]['description']:'';?></textarea>
                        </div>
                    </div>
                    <div class="box-footer">
                        <button type="submit" name="submitBtn" value="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
        <?php }?>
        <div class="col-md-8">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">List Units</h3>
                </div>
                <div class="box-body">
                    <table id="" class="table table-bordered table-condensed table-striped">
                        <tr>
                            <th>SlNo.</th>
                            <th>Designation Name</th>
                            <th>Duty Hours</th>
                            <th>Strength</th>
                            <th>Action</th>
                        </tr>
                        <?php if($records){ for($i=0;$i<count($records);$i++){?>
                        <tr>
                            <td><?php echo $records[$i]['unit_id'];?></td>
                            <td><?php echo $records[$i]['unit_name'];?></td>
                            <td><?php echo $records[$i]['unit_location'];?></td>
                            <td><?php echo $records[$i]['description'];?></td>
                            <td>
                            
                            <?php if(in_array('unitsdelete', $accessar) || $this->session->userdata('usertype') == 'Admin'){ ?>
                            <a href="<?php echo site_url("masters/deleteunits/".$records[$i]['unit_id']);?>" class="btn btn-xs btn-danger" onclick="return confirm('Are you sure to delete this?');">Delete</a>
                            <?php }?>
                            </td>
                        </tr>
                        <?php }} ?>
                    </table>
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
    </script>
</body>
</html>