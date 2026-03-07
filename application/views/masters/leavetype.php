<?php $this->load->view("common/meta");?>
<div class="wrapper">

  <?php $this->load->view("common/sidebar");?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Master Data
        <small>Leave Type</small>
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <?php if(in_array('leavetypeadd', $accessar) || $this->session->userdata('usertype') == 'Admin'){ ?>
        <div class="col-md-4">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Add Leave Type</h3>
            </div>
            <!-- /.box-header -->
            <form role="form" action="<?php echo site_url("masters/leavetype/".$leave_id);?>" method="post">
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
                <label for="leave_type">Leave Type</label>
                <input type="text" class="form-control" id="leave_type" maxlength="120" name="leave_type" placeholder="Enter Leave Type" value="<?=$rec[0]['leave_type']?$rec[0]['leave_type']:'';?>">
              </div>

              <div class="form-group">
                <label for="leave_count">No of leave</label>
                <input type="text" class="form-control" onkeypress="return isNumberKey(event);" maxlength="3" id="leave_count" name="leave_count" placeholder="Enter No of Leave" value="<?=$rec[0]['leave_count']?$rec[0]['leave_count']:'';?>">
              </div>

              <div class="form-group">
                <label for="leave_type">is Paid Leave ?</label>
                <input type="checkbox" name="is_paid" id="is_paid" value="1" <?=$rec[0]['is_paid'] && $rec[0]['is_paid']=='1'?'checked':'';?>>
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
              <h3 class="box-title">Leave Type</h3>
            </div>
            <div class="box-body">
              <table id="" class="table table-bordered table-condensed table-striped">
                <tr>
                  <th>ID</th>
                  <th>Leave Type</th>
                  <th>Leave Count</th>
                  <th>Is Paid</th>
                  <th>Action</th>
                </tr>
                <?php if($records){ for($i=0;$i<count($records);$i++){?>
                <tr>
                  <td><?php echo $records[$i]['leave_id'];?></td>
                  <td><?php echo $records[$i]['leave_type'];?></td>
                  <td><?php echo $records[$i]['leave_count'];?></td>
                  <td><?php echo ($records[$i]['is_paid'] == 1)?'Yes':'No';?></td>
                  <td>
                    <?php if(in_array('leavetypeedit', $accessar) || $this->session->userdata('usertype') == 'Admin'){ ?>
                    <a href="<?php echo site_url("masters/leavetype/".$records[$i]['leave_id']);?>" class="btn btn-xs btn-warning" >Edit</a>
                    <?php }?>
                    <?php if(in_array('leavetypedelete', $accessar) || $this->session->userdata('usertype') == 'Admin'){ ?>
                    <a href="<?php echo site_url("masters/deleteleavetype/".$records[$i]['leave_id']);?>" class="btn btn-xs btn-danger" onclick="return confirm('Are you sure to delete this?');">Delete</a>
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