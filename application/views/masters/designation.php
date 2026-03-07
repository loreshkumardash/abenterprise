<?php $this->load->view("common/meta");?>
<div class="wrapper">

  <?php $this->load->view("common/sidebar");?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Master Data
        <small>Designation</small>
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
       <?php if($accessar) {  if(in_array('designationsadd', $accessar) || $this->session->userdata('usertype') == 'Admin'){ ?>
        <div class="col-md-4">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Add Designation</h3>
            </div>
            <!-- /.box-header -->
            <form role="form" action="<?php echo site_url("masters/designation/$did");?>" method="post">
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
                <label for="department_name">Department Name</label>
                <select class="form-control" id="department_id" name="department_id">
                    <option value="">Select Department</option>
                    <?php if ($department) { for ($i=0; $i <count($department) ; $i++) { ?>
                        <option value="<?=$department[$i]['did'];?>" <?=$did>0 && $rec[0]['department_id']==$department[$i]['did']?'selected':'';?>><?=$department[$i]['department_name'];?></option>
                    <?php }} ?>
                </select>
              </div>

              <div class="form-group">
                <label for="designation_name">Designation Name</label>
                <input type="text" class="form-control" id="designation_name" name="designation_name" placeholder="Enter Designation Name" value="<?php echo isset($rec[0]['designation_name'])?$rec[0]['designation_name']:'';?>">
              </div>
              
            </div>
            <div class="box-footer">
              <button type="submit" name="submitBtn" value="submit" class="btn btn-primary">Submit</button>
            </div>
            </form>
          </div>
        </div>
        <?php }}?>
        <div class="col-md-8">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">List Designation</h3>
            </div>
            <div class="box-body">
              <table id="" class="table table-bordered table-condensed table-striped">
                <tr>
                  <th>ID</th>
                  <th>Department</th>
                  <th>Designation</th>
                  <th>Action</th>
                </tr>
                <?php if($records){ for($i=0;$i<count($records);$i++){?>
                <tr>
                  <td><?php echo $records[$i]['designation_id'];?></td>
                  <td><?php echo $records[$i]['department_name'];?></td>
                  <td><?php echo $records[$i]['designation_name'];?></td>
                 
                  <td>
		              <?php if(in_array('designationsedit', $accessar) || $this->session->userdata('usertype') == 'Admin'){ ?>
                    <a href="<?php echo site_url("masters/designation/".$records[$i]['designation_id']);?>" class="btn btn-xs btn-warning">Edit</a>
                    <?php }?>
                    <?php if(in_array('designationsdelete', $accessar) || $this->session->userdata('usertype') == 'Admin'){ ?>
                    <a href="<?php echo site_url("masters/deletedesignation/".$records[$i]['designation_id']);?>" class="btn btn-xs btn-danger" onclick="return confirm('Are you sure to delete this?');">Delete</a>
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