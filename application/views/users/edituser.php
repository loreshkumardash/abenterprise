<?php $this->load->view("common/meta");?>
<div class="wrapper">

  <?php $this->load->view("common/sidebar");?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Users
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-6">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Edit User</h3>
            </div>
            <!-- /.box-header -->
            <form role="form" action="<?php echo site_url("users/edituser/".$user[0]['user_id']);?>" method="post">
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
                
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="firstname">First Name</label>
                    <input type="text" class="form-control input-sm" id="firstname" name="firstname" placeholder="Enter First Name" required="required" value="<?php echo $user[0]['firstname'];?>">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="lastname">Last Name</label>
                    <input type="text" class="form-control input-sm" id="lastname" name="lastname" placeholder="Enter Last Name" required="required" value="<?php echo $user[0]['lastname'];?>">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="useremail">Email</label>
                    <input type="email" class="form-control input-sm" id="useremail" name="useremail" placeholder="Enter Email" required="required" value="<?php echo $user[0]['useremail'];?>">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="userphone">Mobile</label>
                    <input type="text" class="form-control input-sm" id="userphone" name="userphone" placeholder="Enter Mobile" required="required" value="<?php echo $user[0]['userphone'];?>">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" class="form-control input-sm" id="username" name="username" placeholder="Enter Username" required="required" value="<?php echo $user[0]['username'];?>">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control input-sm" id="password" name="password" placeholder="Enter Password to change">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="usertype">User Type</label>
                    <select class="form-control input-sm" id="usertype" name="usertype">
                        <option value="Others" <?php echo $user[0]['usertype'] == 'Others' ? 'selected="selected"' : '';?>>Others</option>
                      <option value="Administrator" <?php echo $user[0]['usertype'] == 'Administrator' ? 'selected="selected"' : '';?>>Administrator</option>
                      <option value="HR" <?php echo $user[0]['usertype'] == 'HR' ? 'selected="selected"' : '';?>>HR</option>
                      <option value="Accounts" <?php echo $user[0]['usertype'] == 'Accounts' ? 'selected="selected"' : '';?>>Accounts</option>
                      <option value="Executive" <?php echo $user[0]['usertype'] == 'Executive' ? 'selected="selected"' : '';?>>Executive</option>
                      <option value="Branch Manager" <?php echo $user[0]['usertype'] == 'Branch Manager' ? 'selected="selected"' : '';?>>Branch Manager</option>
                      <option value="Operator" <?php echo $user[0]['usertype'] == 'Operator' ? 'selected="selected"' : '';?>>Operator</option>
                      

                    </select>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="access_id">User Access</label>
                    <select class="form-control input-sm" id="access_id" name="access_id">
                      <option value="">select</option>
                      <?php if($access){ for($i=0;$i<count($access);$i++){?>
                      <option value="<?php echo $access[$i]['access_id'];?>" <?php echo $user[0]['access_id'] == $access[$i]['access_id'] ? 'selected="selected"' : '';?>><?php echo $access[$i]['access_name'];?></option>
                      <?php }} ?>
                    </select>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="userstatus">User Status</label>
                    <select class="form-control input-sm" id="userstatus" name="userstatus">
                      <option value="1" <?php echo $user[0]['userstatus'] == '1' ? 'selected="selected"' : '';?>>Active</option>
                      <option value="0" <?php echo $user[0]['userstatus'] == '0' ? 'selected="selected"' : '';?>>Inactive</option>
                      
                    </select>
                  </div>
                </div>
                
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="usercategory">User Category</label>
                    <select class="form-control input-sm" id="usercategory" name="usercategory">
                      <option value="1" <?php echo $user[0]['usercategory'] == '1' ? 'selected="selected"' : '';?>>Tracking</option>
                      <option value="0" <?php echo $user[0]['usercategory'] == '0' ? 'selected="selected"' : '';?>>Non-Tracking</option>
                    </select>
                  </div>
                </div>
              </div>
              <input type="hidden" class="form-control input-sm" id="etag_id" name="etag_id" value="<?php echo $user[0]['employee_tagged_id'];?>">
            </div>
            <div class="box-footer">
              <button type="submit" name="submitBtn" value="submit" class="btn btn-primary">Save</button>
            </div>
            </form>
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

