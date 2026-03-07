<?php $this->load->view("common/meta");?>
<div class="wrapper">

  <?php $this->load->view("common/sidebar");?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Master Data
        <small>Gst Master</small>
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <?php if(in_array('gstmasteradd', $accessar) || $this->session->userdata('usertype') == 'Admin' || $this->session->userdata('usertype') == 'Accounts'){ ?>
        <div class="col-md-4">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Add GST</h3>
              
            </div>
            <!-- /.box-header -->
            <form role="form" action="<?php echo site_url("masters/gstmaster/$did");?>" method="post">
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
                <label for="department_name">GSTIN</label>
                <input type="text" class="form-control" id="gst_no" name="gst_no" placeholder="Enter GST No." value="<?php echo isset($rec[0]['gst_no'])?$rec[0]['gst_no']:'';?>" required>
              </div> 
              <div class="form-group">
                <label for="gstname">Name  (as on GST)</label>
                <input type="text" class="form-control" id="gstname" name="gstname" placeholder="Enter Name" value="<?php echo isset($rec[0]['gstname'])?$rec[0]['gstname']:'';?>" required>
              </div>
              <div class="form-group">
                <label for="gstaddress">Address</label>
                <textarea class="form-control" id="gstaddress" name="gstaddress" required><?php echo isset($rec[0]['gstaddress'])?$rec[0]['gstaddress']:'';?></textarea>
              </div>
              <div class="form-group">
                <label for="gst_head">Location</label>
                <input type="text" class="form-control" id="gst_head" name="gst_head" placeholder="Enter Location" value="<?php echo isset($rec[0]['gst_head'])?$rec[0]['gst_head']:'';?>" required>
              </div>
              <div class="form-group">
                <label for="gstpin">Pin Code</label>
                <input type="number" class="form-control" id="gstpin" name="gstpin" value="<?php echo isset($rec[0]['gstpin'])?$rec[0]['gstpin']:'';?>" placeholder="Enter Pin" required>
              </div>
              <div class="form-group">
                <label for="gststate">State</label>
                <select class="form-control" id="gststate" name="gststate" required>
                    <option value="">Select State</option>
                    <?php if ($state) { for ($i=0; $i < count($state); $i++) { ?>
                        <option value="<?=$state[$i]['state_id'];?>" <?php echo isset($rec[0]['gststate']) && $state[$i]['state_id']==$rec[0]['gststate']?'selected':'';?>><?=$state[$i]['state_title'];?></option>
                    <?php }} ?>
                </select>
              </div>
              
            </div>
            <div class="box-footer">
              <button type="submit" name="submitBtn" value="submit" class="btn btn-primary"><?=$btnVal;?></button>
            </div>
            </form>
          </div>
        </div>
        <?php }?>
        <div class="col-md-8">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">List GSTIN</h3>
              <?php if($did > 0){ ?>
              <a href="<?=site_url('masters/gstmaster');?>" class="btn btn-primary btn-xs float-right">Add New</a>
            <?php } ?>
            </div>
            <div class="box-body">
              <table id="" class="table table-bordered table-condensed table-striped">
                <tr>
                  <th>Sl</th>
                  <th>Location</th>
                  <th>GST No.</th>
                  <th>State Code</th>
                  <th>Action</th>
                </tr>
                <?php if($records){ for($i=0;$i<count($records);$i++){?>
                <tr>
                  <td><?php echo $i+1;?></td>
                  <td><?php echo $records[$i]['gst_head'];?></td>
                  <td><?php echo $records[$i]['gst_no'];?></td>
                  <td><?php echo $records[$i]['state_code'];?></td>
                  <td>
		              <?php if(in_array('gstmasteredit', $accessar) || $this->session->userdata('usertype') == 'Admin' || $this->session->userdata('usertype') == 'Accounts'){ ?>
                    <a href="<?php echo site_url("masters/gstmaster/".$records[$i]['gst_id']);?>" class="btn btn-xs btn-warning">Edit</a>
                    <?php }?>
                    <?php if(in_array('gstmasterdelete', $accessar) || $this->session->userdata('usertype') == 'Admin'  || $this->session->userdata('usertype') == 'Accounts'){ ?>
                    <a href="<?php echo site_url("masters/deletegstmaster/".$records[$i]['gst_id']);?>" class="btn btn-xs btn-danger" onclick="return confirm('Are you sure to delete this?');">Delete</a>
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