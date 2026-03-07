<?php $this->load->view("common/meta");?>
<div class="wrapper">

  <?php $this->load->view("common/sidebar");?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Search User</h3>
            </div>
            <div class="box-body">
              <form role="form" action="" id="frmSearch" method="post">
                <div class="row">
                <div class="col-md-2">
                  <label for="firstname">First Name</label>
                  <input type="text" class="form-control input-sm" id="firstname" name="firstname" placeholder="Enter First Name">
                </div>
                <div class="col-md-2">
                  <label for="lastname">Last Name</label>
                  <input type="text" class="form-control input-sm" id="lastname" name="lastname" placeholder="Enter Last Name">
                </div>
                <div class="col-md-2">
                  <label for="useremail">Email</label>
                  <input type="email" class="form-control input-sm" id="useremail" name="useremail" placeholder="Enter Email">
                </div>
                <div class="col-md-2">
                  <label for="userphone">Mobile</label>
                  <input type="text" class="form-control input-sm" id="userphone" name="userphone" placeholder="Enter Mobile">
                </div>
                <div class="col-md-2">
                  <label for="username">Username</label>
                  <input type="text" class="form-control input-sm" id="username" name="username" placeholder="Enter Username">
                </div>
                <div class="col-md-2">
                  <input type="submit" name="submitBtn" class="btn btn-primary" style="margin-top:23px;" value="Search">
                </div>
                </div>
              </form>
            </div>
          </div>
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Users List</h3>
            </div>
            <div class="box-body" id="dataTablediv">
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
              <table id="" class="table table-bordered table-condensed table-striped">
                <tr>
                  <th>ID</th>
                  <th>First Name</th>
                  <th>Last Name</th>
                  <th>Email</th>
                  <th>Mobile</th>
                  <th>Username</th>
                  <th>User Type</th>
                  <th>Action</th>
                </tr>
                <?php if($records){ for($i=0;$i<count($records);$i++){?>
                <tr>
                  <td><?php echo $records[$i]['user_id'];?></td>
                  <td><?php echo $records[$i]['firstname'];?></td>
                  <td><?php echo $records[$i]['lastname'];?></td>
                  <td><?php echo $records[$i]['useremail'];?></td>
                  <td><?php echo $records[$i]['userphone'];?></td>
                  <td><?php echo $records[$i]['username'];?></td>
                  <td><?php echo $records[$i]['usertype'];?></td>
                  <td>
                    <?php if(in_array('usersedit', $accessar) || $this->session->userdata('usertype') == 'Admin'){ ?>
                    <a href="<?php echo site_url("users/edituser/".$records[$i]['user_id']);?>" class="btn btn-xs btn-warning">Edit</a>
                    <?php }?>
                    <?php if(in_array('usersdelete', $accessar) || $this->session->userdata('usertype') == 'Admin'){ ?>
                    <a href="<?php echo site_url("users/deleteuser/".$records[$i]['user_id']);?>" class="btn btn-xs btn-danger" onclick="return confirm('Are you sure to delete this?');">Delete</a>
                    <?php }?>
                  </td>
                </tr>
                <?php }}else{ ?>
                <tr><td colspan="8">No Records Found</td></tr>
                <?php } ?>
              </table>
              <?php if($records){echo $sPages;} ?>
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
    $("#frmSearch").submit(function(e){
      e.preventDefault();
      $.ajax({
        type: "POST",
        url: '<?=base_url();?>index.php/users/listuserAjax',
        data: $("#frmSearch").serialize(),
        dataType: "HTML",
        success: function(data) {
          $('#dataTablediv').html(data);
        }
      }); 
    });
  </script>
</body>
</html>
