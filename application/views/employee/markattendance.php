<?php $this->load->view("common/meta");?>
<div class="wrapper">

<?php $this->load->view("common/sidebar");?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
    Mark Attendance
    </h1>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Mark Attendance</h3>
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
                        <form role="form" action="<?php echo site_url("employee/markattendance");?>" method="post" id="searchForm">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="employee_id">Employee Name</label>
                                    <select class="form-control" id="employee_id" required="required" name="employee_id">
                                        <option value="">select</option>
                                        <?php if($employees){ for($i=0;$i<count($employees);$i++){?>
                                        <option value="<?php echo $employees[$i]['employee_id'];?>"><?php echo $employees[$i]['employee_name'];?></option>
                                        <?php }}?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="attended_date">Attendance Date</label>
                                    <input type="date" class="form-control" id="attended_date" name="attended_date" value="<?=date("Y-m-d")?>" required="required">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="bootstrap-timepicker">
                                    <div class="form-group">
                                        <label>In Time:</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control timepicker" name="in_time">
                                            <div class="input-group-addon">
                                                <i class="fa fa-clock-o"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="bootstrap-timepicker">
                                    <div class="form-group">
                                        <label>Out Time:</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control timepicker" name="out_time">
                                            <div class="input-group-addon">
                                                <i class="fa fa-clock-o"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4" style="padding-top: 25px;">
                                <button type="submit" name="submitBtn" value="submit" class="btn bg-navy btn-flat">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Search Attendance</h3>
                </div>
            <!-- /.box-header -->

                <div class="box-body">
                    <div class="row">
                        <form role="form" action="" method="get" id="searchForm">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="employee_id">Employee Name</label>
                                    <select class="form-control" id="employee_id" required="required" name="employee_id">
                                        <option value="">select</option>
                                        <?php if($employees){ for($i=0;$i<count($employees);$i++){?>
                                        <option value="<?php echo $employees[$i]['employee_id'];?>"><?php echo $employees[$i]['employee_name'];?></option>
                                        <?php }}?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="log_date_from">Log Date From</label>
                                    <input type="date" class="form-control" id="log_date_from" name="log_date_from" value="">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="log_date_to">Log Date From</label>
                                    <input type="date" class="form-control" id="log_date_to" name="log_date_to" value="">
                                </div>
                            </div>
                            <div class="col-md-4" style="padding-top: 25px;">
                                <button type="submit" name="submitBtn" value="submit" class="btn bg-navy btn-flat">Submit</button>
                            </div>
                        </form>
                        <div class="col-md-12">
                            <table id="" class="table table-bordered table-condensed table-striped">
                                <tr>
                                    <th>ID</th>
                                    <th>Employee Name</th>
                                    <th>Email</th>
                                    <th>Mobile</th>
                                    <th>Attended Date</th>
                                    <th>In time</th>
                                    <th>Out time</th>
                                </tr>
                                <?php if($records){ for($i=0;$i<count($records);$i++){?>
                                <tr>
                                    <td><?php echo $records[$i]['id'];?></td>
                                    <td><?php echo $records[$i]['employee_name'];?></td>
                                    <td><?php echo $records[$i]['employee_email'];?></td>
                                    <td>
                                        <?php echo $records[$i]['emp_mobile'];?>
                                        <?php echo $records[$i]['employee_mobile2'] != '' ? ', '.$records[$i]['employee_mobile2'] : '';?>
                                    </td>
                                    <td><?php echo date("d/m/Y", strtotime($records[$i]['attended_date']));?></td>
                                    <td><?php echo date("g:i a", strtotime($records[$i]['in_time']));?></td>
                                    <td><?php echo date("g:i a", strtotime($records[$i]['out_time']));?></td>
                                </tr>
                                <?php }} ?>
                            </table>
                            <?php if($records){ echo $sPages;}?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
</div>
<!-- /.content-wrapper -->
<?php $this->load->view("common/footer");?>
</div>
<!-- ./wrapper -->

<?php $this->load->view("common/script");?>

<script type="text/javascript">
$(document).ready(function(){
    $('.timepicker').timepicker({
      showInputs: false
    })
});


</script>
</body>
</html>