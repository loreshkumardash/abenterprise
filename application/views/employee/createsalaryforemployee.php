<?php $this->load->view("common/meta");?>
<div class="wrapper">

  <?php $this->load->view("common/sidebar");?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Create Salary Transaction Data For the financial year - <?=$curSession;?>
      </h1>
    </section>

    <!-- Main content -->
    <!-- <div class="box-footer">
              <button type="submit" name="submitBtn" value="submit" class="btn btn-primary">Submit</button>
              <button type="reset" name="reset" value="reset" class="btn btn-default">Reset</button>
            </div> -->


    <form role="form" action="<?=site_url('employee/salarytransaction').'/'.$employeeId;?>" method="post">
    <section class="content">
      <div class="row">
        <div class="col-md-3">

          <!-- Profile Image -->
          <div class="box box-primary">
            <div class="box-body box-profile">
              <!--<img class="profile-user-img img-responsive img-circle" src="../../dist/img/user4-128x128.jpg" alt="User profile picture">-->
              <h3 class="profile-username text-center"><?php echo $employee[0]['employee_name'];?></h3>

              <p class="text-muted text-center">#ID : <?php echo $employee[0]['employee_id'];?></p>


            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

         
        </div>
        <div class="col-md-9">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#profile" data-toggle="tab">Profile</a></li>
            </ul>
            <div class="tab-content">
              <div class="active tab-pane" id="profile">
                <table class="table table-bordered table-condensed table-striped">
                  <tr>
                    <th colspan="2">Employee Name</th>
                  </tr>
                  <tr>
                    <td colspan="2"><?php echo $employee[0]['employee_name'];?></td>
                  </tr>
                  <tr>
                    <th>Father's/Husband's Name</th>
                    <th>Aadhar Number</th>
                  </tr>
                  <tr>
                    <td><?php echo $employee[0]['fathus_name'];?></td>
                    <td><?php echo $employee[0]['aadhar_number'];?></td>
                  </tr>
                  <tr>
                    <th>Email</th>
                    <th>Phone Number</th>
                  </tr>
                  <tr>
                    <td><?php echo $employee[0]['employee_email'];?></td>
                    <td><?php echo $employee[0]['employee_mobile'];?></td>
                  </tr>
                  <tr>
                    <th colspan="2">Employee Address</th>
                  </tr>
                  <tr>
                    <td colspan="2"><?php echo $employee[0]['employee_address'];?></td>
                  </tr>
                </table>

              </div>
              <div class="box-footer">
                <button type="submit" name="createSalary" value="submit" class="btn btn-primary">Generate</button>
              </div>
            </div>
          </div>
        </div>
      </div>
      

    </section>
    </form>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <?php $this->load->view("common/footer");?>
</div>
<!-- ./wrapper -->

<?php $this->load->view("common/script");?>
<script type="text/javascript">
</script>
</body>
</html>
