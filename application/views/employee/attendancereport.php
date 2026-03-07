<?php $this->load->view("common/meta");?>
<div class="wrapper">

  <?php $this->load->view("common/sidebar");?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Employee
      </h1>
    </section>



    <!-- Main content -->
    <!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Attendance Report</h3>
                </div>
            <!-- /.box-header -->

                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12">
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
                                <strong>Error !</strong> <?php echo $this->session->flashdata('error');?>
                            </div>
                            <?php
                            }
                            ?>
                        </div>
                        <div class="col-md-12">
                        <form role="form" action="" method="get" id="searchForm">
                            <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="log_date_from">Log Date From</label>
                                    <input type="date" class="form-control" id="log_date" name="log_date" value="<?=isset($_REQUEST['log_date'])?$_REQUEST['log_date']:'';?>">
                                </div>
                            </div>
                          <div class="col-md-2">
                                <div class="form-group">
                                    <label for="log_date_from">Log Date To</label>
                                    <input type="date" class="form-control" id="to_date" name="to_date" value="<?=isset($_REQUEST['to_date'])?$_REQUEST['to_date']:'';?>">
                                </div>
                            </div>
                            <div class="col-md-4" style="padding-top: 15px;">
                                <button type="submit" name="submitBtn" value="submit" class="btn bg-navy btn-flat">Search</button>
                              <button type="submit" name="downloadBtn" value="submit" class="btn bg-maroon btn-flat margin">Download</button>
                            </div>
                            </div>
                        </form>
                    </div>
                        
                        <div class="col-md-12">
                            <table id="" class="table table-bordered table-condensed table-striped">
                                <tr>
                                  
                                    <th>ID</th>
                                    <th>Employee Name</th>
                                    <th>Mobile</th>
                                    <th>Log Date</th>
                                    <th>In time</th>
                                    <th>In Location</th>
                                    <th>Out time </th>
                                    <th>Out Location</th>
                                    <th>Working Hour</th>
                                    <th>Action</th>
                                </tr>
                                <?php if($records){ for($i=0;$i<count($records);$i++){
                                    if ($records[$i]['employee_id']) {
                                        
                                    ?>
                                <tr>
                                    
                                    <td><?php echo $records[$i]['techno_emp_id'];?></td>
                                    <td><?php echo $records[$i]['employee_name'];?></td>
                                    <td><?php echo $records[$i]['emp_mobile'];?></td>
                                    <td><?php echo $records[$i]['attended_date'];?></td>
                                    <td><?php echo $records[$i]['intime'];?></td>
                                    <td><?php echo $records[$i]['inlocation'];?></td>
                                    <td><?php echo $records[$i]['outtime'];?></td>
                                    <td><?php echo $records[$i]['outlocation'];?></td>
                                    <td><?php echo $records[$i]['working_hour'];?><?php echo $records[$i]['remarks']?' (Updated)':'';?><br><?php echo $records[$i]['remarks'];?></td>
                                    <td style="text-align: center;">
                                        <a href="javascript:void(0);" title="Update Hour" class="clockintimebtn"><i class="fa fa-edit" style="color:maroon;"></i></a>

                                        <div class="modal clockintimeModal fade bd-example-modal-sm" tabindex="-1" role="dialog">
                                              <div class="modal-dialog modal-dialog-centered modal-sm" role="document" style="margin-top:15%;padding: 40px;margin-right: 15% !important;">
                                                <div class="modal-content">
                                                  <div class="modal-body">
                                                    <input type="number" class="form-control input-sm working_hour" value="<?=$records[$i]['working_hour'];?>">
                                                    <input type="text" class="form-control input-sm remarks" value="<?=$records[$i]['remarks'];?>" maxlength="100" style="margin-top: 5px;" placeholder="Enter Remarks">
                                                    <input type="hidden" class="form-control input-sm attendance_id" value="<?=$records[$i]['attendance_id'];?>">
                                                    <button type="button"  class="btn btn-primary btn-sm updhoursubmitBtn" style="margin-top: 5px;">Update</button>
                                                    <button type="button"  class="btn btn-warning btn-sm" data-dismiss="modal" style="margin-top: 5px;">Cancel</button>
                                                  </div>
                                                  
                                                  
                                                </div>
                                              </div>
                                        </div>
                                    </td>
                                </tr>
                                <?php }}} ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Main Footer -->
  <?php $this->load->view('common/footer');?>
</div>
<?php $this->load->view('common/script');?>

<script type="text/javascript">
$(document).ready(function(){
    $('.timepicker').timepicker({
      showInputs: false
    })
});
    
    $(document).on('click','.clockintimebtn',function(){
        var obj = $(this).closest("tr");
          obj.find(".clockintimeModal").modal('toggle');
          obj.find(".clockintimeModal").modal('show');
      });

    $(document).on('click','.updhoursubmitBtn',function(){
        var obj = $(this).closest("tr");
        var attendance_id = obj.find('.attendance_id').val();
        var working_hour = obj.find('.working_hour').val();
        var remarks = obj.find('.remarks').val();
        

          if (working_hour && attendance_id > 0) {

              $.ajax({
                  url: '<?=site_url("employee/UpdateAttenHour");?>',
                  data: {attendance_id : attendance_id,working_hour:working_hour,remarks:remarks},
                  dataType:"HTML",
                  async: true,
                  type:"POST",
                  success:function(data){
                      window.location.reload();
                  }
                });
            }  
      });

</script>
</body>
</html>





