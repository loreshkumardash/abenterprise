<?php $this->load->view("common/meta");?>
<div class="wrapper">

  <?php $this->load->view("common/sidebar");?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Master Data
        <small>Account Groups</small>
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <?php if(in_array('accountgroupadd', $accessar) || $this->session->userdata('usertype') == 'Admin' || $this->session->userdata('usertype') == 'Accounts'){ ?>
        <div class="col-md-4">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Add Group</h3>
            </div>
            <!-- /.box-header -->
            <form role="form" action="<?php echo site_url("masters/group/$did");?>" method="post">
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
                <label for="category">Category</label>
                <select class="form-control" name="subcategory_id" id="subcategory_id">
                  <option value="">Select</option>
                  <?php if ($subcategory) { for ($i=0; $i < count($subcategory); $i++) { ?>
                      <option value="<?=$subcategory[$i]['subcategory_id'];?>" <?php echo isset($rec[0]['subcategory_id']) && $subcategory[$i]['subcategory_id']==$rec[0]['subcategory_id']?'selected':'';?>><?=$subcategory[$i]['subcategory_name'];?></option>
                  <?php }} ?>
                  
                </select>
              </div>  
              <div class="form-group">
                <label for="group_name">Group Name</label>
                <input type="text" class="form-control" id="group_name" name="group_name" placeholder="Enter Group Name" value="<?php echo isset($rec[0]['group_name'])?$rec[0]['group_name']:'';?>">
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
              <h3 class="box-title">List Group</h3>
              <?php if ($did > 0) { ?>
                <?php if(in_array('accountgroupadd', $accessar) || $this->session->userdata('usertype') == 'Admin'  || $this->session->userdata('usertype') == 'Accounts'){ ?>
                    <a href="<?php echo site_url("masters/group");?>" class="btn btn-xs btn-primary float-right">Add New</a>
                <?php } ?>
              <?php } ?>
            </div>
            <div class="box-body">
              <table id="" class="table table-bordered table-condensed table-striped">
                <tr>
                  <th>Sl</th>
                  <th>Code</th>
                  <th>Group Name</th>
                  <th>Sub Category</th>
                  <th>Action</th>
                </tr>
                <?php if($group){ for($i=0;$i<count($group);$i++){?>
                <tr>
                  <td><?php echo $i+1;?></td>
                  <td><?php echo $group[$i]['accode'];?></td>
                  <td><?php echo $group[$i]['group_name'];?></td>
                  <td><?php echo $group[$i]['subcategory_name'];?></td>
                 
                  <td>
                    <?php if($group[$i]['isdefault']=='0'){ ?>
                        <?php if(in_array('accountgroupedit', $accessar) || $this->session->userdata('usertype') == 'Admin'  || $this->session->userdata('usertype') == 'Accounts'){ ?>
                        <a href="<?php echo site_url("masters/group/".$group[$i]['group_id']);?>" class="btn btn-xs btn-warning">Edit</a>
                        <?php }?>
                        <?php if(in_array('accountgroupdelete', $accessar) || $this->session->userdata('usertype') == 'Admin'  || $this->session->userdata('usertype') == 'Accounts'){ ?>
                        <a href="<?php echo site_url("masters/deletegroup/".$group[$i]['group_id']);?>" class="btn btn-xs btn-danger" onclick="return confirm('Are you sure to delete this?');">Delete</a>
                        <?php }?>
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
</body>
</html>