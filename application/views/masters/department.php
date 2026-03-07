<?php $this->load->view("common/meta");?>
<div class="wrapper">

  <?php $this->load->view("common/sidebar");?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Master Data
        <small>Department</small>
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
         <?php if($accessar) {  if(in_array('departmentsadd', $accessar) || $this->session->userdata('usertype') == 'Admin'){ ?>
        <div class="col-md-4">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Add Department</h3>
            </div>
            <!-- /.box-header -->
            <form role="form" action="<?php echo site_url("masters/department/$did");?>" method="post">
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
                <input type="text" class="form-control" id="department_name" name="department_name" placeholder="Enter Department Name" value="<?php echo isset($rec[0]['department_name'])?$rec[0]['department_name']:'';?>">
              </div>
              <div class="form-group">
                <label for="class_description">Select Shift</label>
                <select class="form-control" id="shift_id" name="shift_id">
                  <option value="">-Select-</option>
                  <?php if(!empty($shift)){
                          foreach ($shift as $k => $v) {?>
                            <option value="<?php echo $v['shift_id'];?>" <?php if(isset($rec[0]['shift_id'])) {echo $rec[0]['shift_id'] == $v['shift_id'] ? 'selected="selected"' : '';}?>><?php echo $v['shift_name'];?></option>
                         <?php }
                        }
                  ?>
                </select>
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
              <h3 class="box-title">List Department</h3>
            </div>
            <div class="box-body">
              <table id="" class="table table-bordered table-condensed table-striped">
                <tr>
                  <th>ID</th>
                  <th>Department</th>
                  <th>Shift</th>
                 
                  <th>Action</th>
                </tr>
                <?php if($records){ for($i=0;$i<count($records);$i++){?>
                <tr>
                  <td><?php echo $records[$i]['did'];?></td>
                  <td><?php echo $records[$i]['department_name'];?></td>
                  <td><?php echo $records[$i]['shift_name'];?></td>
                  
                  <td>
		    <?php if(in_array('departmentsedit', $accessar) || $this->session->userdata('usertype') == 'Admin'){ ?>
                    <a href="<?php echo site_url("masters/department/".$records[$i]['did']);?>" class="btn btn-xs btn-warning">Edit</a>
                    <?php }?>
                    <?php if(in_array('departmentsdelete', $accessar) || $this->session->userdata('usertype') == 'Admin'){ ?>
                    <a href="<?php echo site_url("masters/deletedepartment/".$records[$i]['did']);?>" class="btn btn-xs btn-danger" onclick="return confirm('Are you sure to delete this?');">Delete</a>
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