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
        <form role="form" action="<?php echo site_url("users/adduser");?>" method="post">
        <div class="col-md-6">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Add User</h3>
            </div>
            <!-- /.box-header -->
            
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
                    <input type="text" class="form-control input-sm" id="firstname" value="" name="firstname" placeholder="Enter First Name" required="required">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="lastname">Last Name</label>
                    <input type="text" class="form-control input-sm" id="lastname" name="lastname" placeholder="Enter Last Name" required="required">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="useremail">Email</label>
                    <input type="email" class="form-control input-sm" value="<?php echo (!empty($empData))?$empData[0]['employee_email']:''?>" id="useremail" name="useremail" placeholder="Enter Email" required="required">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="userphone">Mobile</label>
                    <input type="text" class="form-control input-sm" value="<?php echo (!empty($empData))?$empData[0]['emp_mobile']:''?>" id="userphone" name="userphone" placeholder="Enter Mobile" required="required">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" class="form-control input-sm" id="username" name="username" placeholder="Enter Username" required="required">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control input-sm" id="password" name="password" placeholder="Enter Password" required="required">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="usertype">User Type</label>
                    <select class="form-control input-sm" id="usertype" name="usertype">
                      <option value="Others">Others</option>
                      <option value="Admin">Admin</option>
                      <option value="HR">HR</option>
                      <option value="Accounts">Accounts</option>
                      <option value="Executive">Executive</option>
                      <option value="Branch Manager">Branch Manager</option>
                     
 
                    </select>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="access_id">User Access</label>
                    <select class="form-control input-sm" id="access_id" name="access_id">
                      <option value=""></option>
                      <?php if($access){ for($i=0;$i<count($access);$i++){?>
                      <option value="<?php echo $access[$i]['access_id'];?>"><?php echo $access[$i]['access_name'];?></option>
                      <?php }} ?>
                    </select>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="userstatus">User Status</label>
                    <select class="form-control input-sm" id="userstatus" name="userstatus">
                      <option value="1">Active</option>
                      <option value="0">Inactive</option>
                    </select>
                  </div>
                </div>
                
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="usercategory">User Category</label>
                    <select class="form-control input-sm" id="usercategory" name="usercategory">
                      <option value="1">Tracking</option>
                      <option value="0">Non-Tracking</option>
                    </select>
                  </div>
                </div>
                
              </div>
            </div>
            <div class="box-footer">
              <input type="hidden" name="empoyeeId" id="empoyeeId" value="<?php echo (!empty($empData))?$empData[0]['employee_id']:''?>">
              <button type="submit" name="submitBtn" value="submit" class="btn btn-primary">Submit</button>
              <button type="reset" name="reset" value="reset" class="btn btn-default">Reset</button>
            </div>
            
          </div>
        </div>
        
        </form>
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

