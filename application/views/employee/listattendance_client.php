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
                    <h3 class="box-title">List Attendance</h3>
                </div>
            <!-- /.box-header -->

                <div class="box-body">
                    <div class="row">
                        <form role="form" action="" method="get" id="searchForm">
                        
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="log_date_from">Log Date From</label>
                                    <input type="date" class="form-control" id="log_date_from" name="log_date_from" value="">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="log_date_to">Log Date To</label>
                                    <input type="date" class="form-control" id="log_date_to" name="log_date_to" value="">
                                </div>
                            </div>
                            <div class="col-md-4" style="padding-top: 25px;">
                                <button type="submit" name="submitBtn" value="submit" class="btn bg-navy btn-flat">Search</button>
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