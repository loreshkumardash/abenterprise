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
        <?php if(in_array('unitsadd', $accessar) || $this->session->userdata('usertype') == 'Admin' || $this->session->userdata('usertype') == 'Accounts'){ ?>
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
                                <label for="year">Year</label>
                              <select class="form-control" name="year" id="year">
                                <?php $yr = date("Y"); for ($y=0; $y < 6; $y++) { 
                                  $yrr = $yr - $y;
                                  $sel = $yrr == $year ? 'selected="selected"' : '';
                                  echo '<option value="'.$yrr.'" '.$sel.'>'.$yrr.'</option>';
                                }
                                ?>
                              </select>
                        </div>
                        <div class="form-group">
                                <label for="month">Month</label>
                              <select class="form-control form-control-sm" name="month" id="month">
                                <option value="01" <?=$month == '01' ? 'selected="selected"' : '';?>>Jan</option>
                                <option value="02" <?=$month == '02' ? 'selected="selected"' : '';?>>Feb</option>
                                <option value="03" <?=$month == '03' ? 'selected="selected"' : '';?>>Mar</option>
                                <option value="04" <?=$month == '04' ? 'selected="selected"' : '';?>>Apr</option>
                                <option value="05" <?=$month == '05' ? 'selected="selected"' : '';?>>May</option>
                                <option value="06" <?=$month == '06' ? 'selected="selected"' : '';?>>Jun</option>
                                <option value="07" <?=$month == '07' ? 'selected="selected"' : '';?>>Jul</option>
                                <option value="08" <?=$month == '08' ? 'selected="selected"' : '';?>>Aug</option>
                                <option value="09" <?=$month == '09' ? 'selected="selected"' : '';?>>Sept</option>
                                <option value="10" <?=$month == '10' ? 'selected="selected"' : '';?>>Oct</option>
                                <option value="11" <?=$month == '11' ? 'selected="selected"' : '';?>>Nov</option>
                                <option value="12" <?=$month == '12' ? 'selected="selected"' : '';?>>Dec</option>
                              </select>
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
                            <th>ID</th>
                            <th>Unit Name</th>
                            <th>Location</th>
                            <th>Description</th>
                            <th>Action</th>
                        </tr>
                        <?php if($records){ for($i=0;$i<count($records);$i++){?>
                        <tr>
                            <td><?php echo $records[$i]['unit_id'];?></td>
                            <td><?php echo $records[$i]['unit_name'];?></td>
                            <td><?php echo $records[$i]['unit_location'];?></td>
                            <td><?php echo $records[$i]['description'];?></td>
                            <td>
                            <?php if(in_array('unitsedit', $accessar) || $this->session->userdata('usertype') == 'Admin'  || $this->session->userdata('usertype') == 'Accounts'  || $this->session->userdata('usertype') == 'HR'){ ?>
                            <a href="<?php echo site_url("masters/units?ledger_id=".$records[$i]['ledger_id']."&did=".$records[$i]['unit_id']);?>" class="btn btn-xs btn-warning" >Edit</a>
                            <?php }?>
                            <?php if(in_array('unitsdelete', $accessar) || $this->session->userdata('usertype') == 'Admin' || $this->session->userdata('usertype') == 'Accounts'  || $this->session->userdata('usertype') == 'HR'){ ?>
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