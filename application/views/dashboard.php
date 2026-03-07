<?php $this->load->view("common/meta");?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<style type="text/css">
table {
    padding: 0px !important;
    margin: 0px !important;
}

.table>tbody>tr[data-url],
table>tbody>tr[data-url] {
    cursor: pointer;

}

.table>tbody>tr[data-url]:hover {
    background: #0567e8;
    color: white;
    text-transform: bold;
}

tr {
    display: table-row;
    vertical-align: inherit;


}

.table>tbody>tr>td {
    padding: 1px;
}

table.dataTable {
    clear: both;
    max-width: none !important;
    border-collapse: ;
    font-size: 16px;
    font-weight: 400px;
    font-family: inherit;
    padding: 0px;

}

.customer_table tr:nth-child(even) {
    background: #FFF
}

.customer_table tr:nth-child(odd) {
    background: #FFF
}

.tableFixHead {
    overflow: auto;
    height: 170px;
}

.tableFixHead thead th {
    position: sticky;
    top: 0;
    z-index: 1;
    background-color: #d0b034;
    color: black;
    line-height: 7px !important;
}

#myChart {
    width: 100%;
    /* Make it responsive */
    height: 300px !important;
    /* Set height */
}
</style>
<style>
.notice {
    background-color: #ffeb3b;
    padding: 10px;
    border: 1px solid #fbc02d;
    border-radius: 5px;
    color: #333;
    margin: 10px 0;
    font-size: 14px;
    font-weight: bold;
}
</style>

<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">

        <?php $this->load->view("common/sidebar");?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                    Dashboard
                    <small>Control panel</small>
                </h1>
                <ol class="breadcrumb">
                    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                    <li class="active">Dashboard</li>
                </ol>
            </section>
            <?php
                    
                    $userName = $user[0]['firstname']; 
                    $currentHour = date('H');
                    if ($currentHour < 12) {
                        $timeOfDay = "morning";
                    } elseif ($currentHour < 18) {
                        $timeOfDay = "afternoon";
                    } else {
                        $timeOfDay = "evening";
                    }

                    $welcomeMessage = "Good $timeOfDay, $userName ! Welcome back to your Dashboard.";
                ?>
            <?php if($this->session->userdata("usertype") == 'Admin'){ ?>
            <!-- Main content -->
            <section class="content">

                <div class="col-md-12" style="padding:0;margin:0;">
                    <div class="box"
                        style="background-color:#F0F3F4;box-shadow: rgba(50, 50, 93, 0.25) 0px 30px 60px -12px, rgba(0, 0, 0, 0.3) 0px 18px 36px -18px;">
                        <div class="box-header with-border" style="color:#34495E;">
                            <h3 class="box-title"><?=$welcomeMessage;?> [Admin]</b></h3>
                            <span class="float-right"><i class="fa fa-calendar" aria-hidden="true"></i> &nbsp<span
                                    id="time"></span></span>
                        </div>
                    </div>
                </div>
                <!-- Small boxes (Stat box) -->
                <div class="row">

                    <!-- ./col -->
                    <div class="col-lg-3 col-xs-6">
                        <!-- small box -->

                        <div class="small-box bg-primary" style="line-height: .2!important">
                            <div class="inner">
                                <h3><?php echo $lead && $lead > 0 ? $lead : '0'; ?></h3>

                                <p>Total Leads</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-stats-bars" style="line-height: 1.2!important"></i>
                            </div>
                            <a href="<?=site_url('lead');?>" class="small-box-footer">More info <i
                                    class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>

                    <div class="col-lg-3 col-xs-6">
                        <div class="small-box bg-green" style="line-height: .2!important">
                            <div class="inner">
                                <h3><?php echo $employees && $employees > 0 ? $employees : '0'; ?></h3>

                                <p>Total Employees</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-stats-bars" style="line-height: 1.2!important"></i>
                            </div>
                            <a href="<?=site_url('employee');?>" class="small-box-footer">More info <i
                                    class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>



                    <!-- ./col -->
                    <div class="col-lg-3 col-xs-6">
                        <!-- small box -->
                        <div class="small-box bg-aqua" style="line-height: .2!important">
                            <div class="inner">
                                <h3><?php echo $rp && $rp > 0 ? $rp : '0'; ?></h3>

                                <p>Total Referal Partners</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-stats-bars" style="line-height: 1.2!important"></i>
                            </div>
                            <a href="<?=site_url('referalpartner/approvedpartners');?>" class="small-box-footer">More
                                info <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-xs-6">
                        <!-- small box -->
                        <div class="small-box bg-maroon" style="line-height: .2!important">
                            <div class="inner">
                                <h3><?php echo $cp && $cp > 0 ? $cp : '0'; ?></h3>

                                <p>Total Channel Partners</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-stats-bars" style="line-height: 1.2!important"></i>
                            </div>
                            <a href="<?=site_url('channelpartner/approvedpartners');?>" class="small-box-footer">More
                                info <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-xs-6">
                        <!-- small box -->
                        <div class="small-box bg-teal" style="line-height: .2!important">
                            <div class="inner">
                                <!-- <h3><?php echo $propa && $props > 0 ? $propa : '0'; ?></h3> -->
                                <h3><?php echo ($propa ?? 0) + ($props ?? 0); ?></h3>

                                <p>Properties</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-stats-bars" style="line-height: 1.2!important"></i>
                            </div>
                            <a href="<?=site_url('property/listproperty');?>" class="small-box-footer">More info <i
                                    class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-xs-6">
                        <!-- small box -->
                        <div class="small-box bg-yellow" style="line-height: 0.2 !important">
                            <div class="inner">
                                <h3><?php echo $propup && $propup > 0 ? $propup : '0'; ?></h3>

                                <p>Upcoming Properties</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-stats-bars" style="line-height: 1.2!important"></i>
                            </div>
                            <a href="<?=site_url('property/upcomingproperty');?>" class="small-box-footer">More info <i
                                    class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-xs-6">
                        <!-- small box -->
                        <div class="small-box bg-red" style="line-height: .2!important">
                            <div class="inner">
                                <h3><?php echo $slead && $slead > 0 ? $slead : '0'; ?></h3>

                                <p>Total Success Leads</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-stats-bars" style="line-height: 1.2!important"></i>
                            </div>
                            <a href="<?=site_url('lead?status=Success');?>" class="small-box-footer">More info <i
                                    class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-xs-6">
                        <!-- small box -->
                        <div class="small-box bg-blue" style="line-height: .2!important">
                            <div class="inner">
                                <h3><?php echo $opportunity && $opportunity > 0 ? $opportunity : '0'; ?></h3>

                                <p>Opportunities</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-stats-bars" style="line-height: 1.2!important"></i>
                            </div>
                            <a href="<?=site_url('leadreport/opportunity');?>" class="small-box-footer">More info <i
                                    class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                </div>
                <!--  <div class="row">
        <div class="col-md-12">
            <div class="chart-container">
                <h3>Monthly Financial Overview</h3>
                <canvas id="myChart"></canvas>
            </div>
        </div>
      </div> -->
                <!-- <div class="row">
        <div class="col-md-12">
          <h5>Employee Attendance</h5>
          <table class="table  table-condensed table-striped" cellpadding="3">
            <tr style="background-color: #34495E;color: white;">
                <th>Emp. ID</th>
                <th>Employee Name</th>
                <th>Check in Location</th>
                <th width="10%">Check in Date & Time</th>
                <th width="5%"></th>
                <th>Check Out Location</th>
                <th width="10%">Check Out Date & Time</th>
                <th width="5%"></th>
                <th width="10%" style="text-align:center;">Action</th>
              </tr>
            <?php if ($attenrec) { for ($i=0; $i < count($attenrec); $i++) { 
                $rec2 = $this->Common_Model->db_query("SELECT a.log_datetime,a.log_loc,a.log_date,a.status,a.attendance_log_id,a.remarks,a.user_img FROM user_attendance_log as a WHERE a.log_date='".$attenrec[$i]['log_date']."' AND approve_status=0 AND status=2 AND user_id=".$attenrec[$i]['user_id']."");
              ?>
              <tr >
                <td><?=$attenrec[$i]['techno_emp_id'];?> </td>
                <td><?=$attenrec[$i]['employee_name'];?> </td>
                <td><?=$attenrec[$i]['log_loc'];?> </td>
                <td><?=date('d-m-Y H:i:s',strtotime($attenrec[$i]['log_datetime']));?></td>
                <td style="text-align: center;">
                  <?php if ($attenrec[$i]['user_img']) { 

                    $filePath = FCPATH."uploads/attendancefile/".$rec2[0]['user_img'];
                    if (!file_exists($filePath)) { }else{ 

                    ?>
                  <a href="<?=base_url("uploads/attendancefile/".$attenrec[$i]['user_img']);?>" class=""  target="_blank" ><i class="fa fa-picture-o" style="color:green;font-size: 17px;"></i></a>
                <?php }} ?>
                <br>
                    <a href="javascript:void(0);" title="Update Hour" class="clockineditbtn"><i class="fa fa-edit" style="color:maroon;font-size: 17px;"></i></a>

                                        <div class="modal clockineditModal fade bd-example-modal-sm" tabindex="-1" role="dialog">
                                              <div class="modal-dialog modal-dialog-centered modal-sm" role="document" style="margin-top:15%;padding: 40px;margin-right: 15% !important;">
                                                <div class="modal-content">
                                                  <div class="modal-body">
                                                    <input type="time" class="form-control input-sm clockintime" value="<?=date('H:i:s',strtotime($attenrec[$i]['log_datetime']));?>">
                                                    <input type="text" class="form-control input-sm remarksin" value="<?=$attenrec[$i]['remarks'];?>" maxlength="100" style="margin-top: 5px;" placeholder="Enter Remarks">
                                                    <input type="hidden" class="form-control input-sm attendanceclockin_id" value="<?=$attenrec[$i]['attendance_log_id'];?>">
                                                    <button type="button"  class="btn btn-primary btn-sm updclockinsubmitBtn" style="margin-top: 5px;">Update</button>
                                                    <button type="button"  class="btn btn-warning btn-sm" data-dismiss="modal" style="margin-top: 5px;">Cancel</button>
                                                  </div>
                                                  
                                                  
                                                </div>
                                              </div>
                                        </div>

                </td>
                <td><?=$rec2?$rec2[0]['log_loc']:'';?> </td>
                <td><?=$rec2?date('d-m-Y H:i:s',strtotime($rec2[0]['log_datetime'])):'';?></td>
                <td style="text-align: center;">
                <?php if ($rec2 && $rec2[0]['user_img']) { 

                    $filePath = FCPATH."uploads/attendancefile/".$rec2[0]['user_img'];
                    if (!file_exists($filePath)) { }else{ 

                    ?>
                    <a href="<?=base_url("uploads/attendancefile/".$rec2[0]['user_img']);?>" class=""  target="_blank" ><i class="fa fa-picture-o" style="color:green;font-size: 17px;"></i></a>
                <?php }} ?>
                <br>
                <?php //if ($rec2) { ?>
                              <a href="javascript:void(0);" title="Update Hour" class="clockouteditbtn"><i class="fa fa-edit" style="color:maroon;font-size: 17px;"></i></a>

                                 <div class="modal clockouteditModal fade bd-example-modal-sm" tabindex="-1" role="dialog">
                                       <div class="modal-dialog modal-dialog-centered modal-sm" role="document" style="margin-top:15%;padding: 40px;margin-right: 15% !important;">
                                            <div class="modal-content">
                                              <div class="modal-body">
                                                <input type="time" class="form-control input-sm clockouttime" value="<?=$rec2?date('H:i:s',strtotime($rec2[0]['log_datetime'])):'';?>">
                                                <input type="text" class="form-control input-sm remarksout" value="<?=$rec2?$rec2[0]['remarks']:'';?>" maxlength="100" style="margin-top: 5px;" placeholder="Enter Remarks">
                                                <input type="hidden" class="form-control input-sm attendanceclockout_id" value="<?=$rec2 && $rec2[0]['attendance_log_id']?$rec2[0]['attendance_log_id']:$attenrec[$i]['attendance_log_id'];?>">
                                                <input type="hidden" class="form-control input-sm attendanceclockout_idval" value="<?=$rec2 && $rec2[0]['attendance_log_id']?'2':'1';?>">
                                                <button type="button"  class="btn btn-primary btn-sm updclockoutsubmitBtn" style="margin-top: 5px;">Update</button>
                                                <button type="button"  class="btn btn-warning btn-sm" data-dismiss="modal" style="margin-top: 5px;">Cancel</button>
                                              </div>
                                              
                                              
                                            </div>
                                          </div>
                                    </div>
                        <?php //} ?>

                </td>
                <td width="10%" align="center">
                  <?php if($rec2){ ?>
                      <a href="<?=site_url('dashboard/attenapprv/'.$attenrec[$i]['user_id'].'/'.$attenrec[$i]['log_date']);?>" class="btn btn-xs bg-green" onclick="return confirm('Are you sure for approve?');">Approve</a>
                  <?php } ?>

                </td>
              </tr>
            <?php }} ?>
          </table>
        </div>
      </div> -->

                <div class="col-md-6" id="chartContainerA">
                    <h3 class="text-center">Lead Status</h3>
                    <canvas id="myPieChart"></canvas>
                </div>&nbsp;&nbsp;
                <div class="col-md-6" id="chartContainerB">
                    <h3 class="text-center">Property Status</h3>
                    <canvas id="leadStatusChart"></canvas>
                </div>
            </section>

            <?php }else if($this->session->userdata("usertype") == 'Employee'){ ?>

            <section class="content">

                <div class="col-md-12" style="padding:0;margin:0;">
                    <div class="box"
                        style="background-color:#F0F3F4;box-shadow: rgba(50, 50, 93, 0.25) 0px 30px 60px -12px, rgba(0, 0, 0, 0.3) 0px 18px 36px -18px;">
                        <div class="box-header with-border" style="color:#34495E;">
                            <h3 class="box-title"><?=$welcomeMessage;?> [Employee]</b></h3>
                            <span class="float-right"><i class="fa fa-calendar" aria-hidden="true"></i> &nbsp<span
                                    id="time"></span></span>
                        </div>
                    </div>
                </div>
                <!-- Small boxes (Stat box) -->
                <div class="row">

                    <div class="col-lg-3 col-xs-6">
                        <!-- small box -->
                        <div class="small-box bg-yellow" style="line-height: .2!important">
                            <div class="inner">
                                <h3><?php echo $leads && $leads > 0 ? $leads : '0'; ?></h3>

                                <p>Total Leads</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-stats-bars" style="line-height: 1.2!important"></i>
                            </div>
                            <a href="" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <!-- <div class="col-lg-3 col-xs-6">

          <div class="small-box bg-red" style="line-height: .2!important">
            <div class="inner">
              <h3><?php echo $expenses && $expenses[0]['expense']>0 ? $expenses[0]['expense'] : '0.00';?></h3>

              <p>Monthly Expenses</p>
            </div>
            <div class="icon">
              <i class="ion ion-pie-graph" style="line-height: 1.2!important"></i>
            </div>
            <a href="<?php echo site_url("payments/list_vouchers");?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>  -->
                    <!-- ./col -->
                    <!-- ./col -->
                    <div class="col-lg-3 col-xs-6">

                        <div class="small-box bg-red" style="line-height: .2!important">
                            <div class="inner">
                                <h3><?php echo $empexpence && $empexpence[0]['totexp'] > 0 ? $empexpence[0]['totexp'] : '0.00';?>
                                </h3>

                                <p>My Expenses</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-pie-graph" style="line-height: 1.2!important"></i>
                            </div>
                            <a href="" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->

                    <div class="col-lg-3 col-xs-6">

                        <div class="small-box bg-green" style="line-height: .2!important">
                            <div class="inner">
                                <h3><?php echo $empatten && $empatten[0]['empduty'] > 0 ? $empatten[0]['empduty'] : '0';?>
                                </h3>

                                <p>My Attendance</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-stats-bars" style="line-height: 1.2!important"></i>
                            </div>
                            <a href="" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>


                </div>
                <!-- <?php if($this->session->userdata("access_id") > '0'){ ?>
      <div class="row">
        <div class="col-md-12">
          <h5>Employee Attendance</h5>
          <table class="table  table-condensed table-striped" cellpadding="3">
            <tr style="background-color: #34495E;color: white;">
                <th>Emp. ID</th>
                <th>Employee Name</th>
                <th>Check in Location</th>
                <th width="10%">Check in Date & Time</th>
                <th width="5%"></th>
                <th>Check Out Location</th>
                <th width="10%">Check Out Date & Time</th>
                <th width="5%"></th>
                <th width="10%" style="text-align:center;">Action</th>
              </tr>
            <?php if ($attenrec) { for ($i=0; $i < count($attenrec); $i++) { 
                $rec2 = $this->Common_Model->db_query("SELECT a.log_datetime,a.log_loc,a.log_date,a.status,a.attendance_log_id,a.remarks,a.user_img FROM user_attendance_log as a WHERE a.log_date='".$attenrec[$i]['log_date']."' AND approve_status=0 AND status=2");
              ?>
              <tr >
                <td><?=$attenrec[$i]['techno_emp_id'];?> </td>
                <td><?=$attenrec[$i]['employee_name'];?> </td>
                <td><?=$attenrec[$i]['log_loc'];?> </td>
                <td><?=date('d-m-Y H:i:s',strtotime($attenrec[$i]['log_datetime']));?></td>
                <td style="text-align: center;">
                  <?php if ($attenrec[$i]['user_img']) { 

                    $filePath = FCPATH."uploads/attendancefile/".$rec2[0]['user_img'];
                    if (!file_exists($filePath)) { }else{ 

                    ?>
                  <a href="<?=base_url("uploads/attendancefile/".$attenrec[$i]['user_img']);?>" class=""  target="_blank" ><i class="fa fa-picture-o" style="color:green;font-size: 17px;"></i></a>
                <?php }} ?>
                <br>
                    <a href="javascript:void(0);" title="Update Hour" class="clockineditbtn "><i class="fa fa-edit" style="color:maroon;font-size: 17px;"></i></a>

                                        <div class="modal clockineditModal fade bd-example-modal-sm" tabindex="-1" role="dialog">
                                              <div class="modal-dialog modal-dialog-centered modal-sm" role="document" style="margin-top:15%;padding: 40px;margin-right: 15% !important;">
                                                <div class="modal-content">
                                                  <div class="modal-body">
                                                    <input type="time" class="form-control input-sm clockintime" value="<?=date('H:i:s',strtotime($attenrec[$i]['log_datetime']));?>">
                                                    <input type="text" class="form-control input-sm remarksin" value="<?=$attenrec[$i]['remarks'];?>" maxlength="100" style="margin-top: 5px;" placeholder="Enter Remarks">
                                                    <input type="hidden" class="form-control input-sm attendanceclockin_id" value="<?=$attenrec[$i]['attendance_log_id'];?>">
                                                    <button type="button"  class="btn btn-primary btn-sm updclockinsubmitBtn" style="margin-top: 5px;">Update</button>
                                                    <button type="button"  class="btn btn-warning btn-sm" data-dismiss="modal" style="margin-top: 5px;">Cancel</button>
                                                  </div>
                                                  
                                                  
                                                </div>
                                              </div>
                                        </div>

                </td>
                <td><?=$rec2?$rec2[0]['log_loc']:'';?> </td>
                <td><?=$rec2?date('d-m-Y H:i:s',strtotime($rec2[0]['log_datetime'])):'';?></td>
                <td style="text-align: center;">
                <?php if ($rec2 && $rec2[0]['user_img']) { 

                    $filePath = FCPATH."uploads/attendancefile/".$rec2[0]['user_img'];
                    if (!file_exists($filePath)) { }else{ 

                    ?>
                    <a href="<?=base_url("uploads/attendancefile/".$rec2[0]['user_img']);?>" class=""  target="_blank" ><i class="fa fa-picture-o" style="color:green;font-size: 17px;"></i></a>
                <?php }} ?>
                <br>
                <?php //if ($rec2) { ?>
                              <a href="javascript:void(0);" title="Update Hour" class="clockouteditbtn"><i class="fa fa-edit" style="color:maroon;font-size: 17px;"></i></a>

                                 <div class="modal clockouteditModal fade bd-example-modal-sm" tabindex="-1" role="dialog">
                                       <div class="modal-dialog modal-dialog-centered modal-sm" role="document" style="margin-top:15%;padding: 40px;margin-right: 15% !important;">
                                            <div class="modal-content">
                                              <div class="modal-body">
                                                <input type="time" class="form-control input-sm clockouttime" value="<?=$rec2?date('H:i:s',strtotime($rec2[0]['log_datetime'])):'';?>">
                                                <input type="text" class="form-control input-sm remarksout" value="<?=$rec2?$rec2[0]['remarks']:'';?>" maxlength="100" style="margin-top: 5px;" placeholder="Enter Remarks">
                                                <input type="hidden" class="form-control input-sm attendanceclockout_id" value="<?=$rec2 && $rec2[0]['attendance_log_id']?$rec2[0]['attendance_log_id']:$attenrec[$i]['attendance_log_id'];?>">
                                                <input type="hidden" class="form-control input-sm attendanceclockout_idval" value="<?=$rec2 && $rec2[0]['attendance_log_id']?'2':'1';?>">
                                                <button type="button"  class="btn btn-primary btn-sm updclockoutsubmitBtn" style="margin-top: 5px;">Update</button>
                                                <button type="button"  class="btn btn-warning btn-sm" data-dismiss="modal" style="margin-top: 5px;">Cancel</button>
                                              </div>
                                              
                                              
                                            </div>
                                          </div>
                                    </div>
                        <?php //} ?>

                </td>
                <td width="10%" align="center">
                  <?php if($rec2){ ?>
                      <a href="<?=site_url('dashboard/attenapprv/'.$attenrec[$i]['user_id'].'/'.$attenrec[$i]['log_date']);?>" class="btn btn-xs bg-green" onclick="return confirm('Are you sure for approve?');">Approve</a>
                  <?php } ?>
 -->
                <!-- </td>
              </tr>
            <?php }} ?> -->
                </table>
        </div>
    </div>
    <?php } ?>


    </section>



    <?php } else if($this->session->userdata("usertype") == 'HR'){ ?>
    <section class="content">
        <div class="col-md-12" style="padding:0;margin:0;">
            <div class="box"
                style="background-color:#F0F3F4;box-shadow: rgba(50, 50, 93, 0.25) 0px 30px 60px -12px, rgba(0, 0, 0, 0.3) 0px 18px 36px -18px;">
                <div class="box-header with-border" style="color:#34495E;">
                    <h3 class="box-title"><?=$welcomeMessage;?></b></h3>
                    <span class="float-right"><i class="fa fa-calendar" aria-hidden="true"></i> &nbsp<span
                            id="time"></span></span>
                </div>
            </div>
        </div>
        <div class="row">

            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-red" style="line-height: .2!important">
                    <div class="inner">
                        <h3><?php echo $empexpence && $empexpence[0]['totexp'] > 0 ? $empexpence[0]['totexp'] : '0.00';?>
                        </h3>

                        <p> Expenses</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-pie-graph" style="line-height: 1.2!important"></i>
                    </div>
                    <a href="" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->

            <!-- <div class="col-lg-3 col-xs-6">
            //small box 
            <div class="small-box bg-green" style="line-height: .2!important">
              <div class="inner">
                <h3><?php echo $empatten && $empatten[0]['empduty'] > 0 ? $empatten[0]['empduty'] : '0';?></h3>

                <p>My Attendance</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars" style="line-height: 1.2!important"></i>
              </div>
              <a href="" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>
        </div> -->
            <div class="col-md-5" style="border : 1px solid black;padding: 3px;margin: 0;">
                <div class="icon icon-lg icon-shape " style="margin-top: -15px!important;">
                    <span
                        style="background-color: whitesmoke;width: 100px;font-size: 12px;padding-left: 3px;padding-right: 3px;">Birthday
                        List</span>
                </div>

                <div style="background-color: #e6d767;height: 170px;padding: 0px;" class="dataTable tableFixHead ">
                    <table class="table customer_table">
                        <thead>
                            <tr style="background-color: #ddd;">
                                <th>Sl</th>
                                <th>Emp.Code</th>
                                <th>Emp.Name</th>
                                <th>D.O.B</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($employee) { for ($i=0; $i < count($employee); $i++) {

                $today = date("m-d");
                $empdob = date("m-d",strtotime($employee[$i]['emp_dob']));

                if ($empdob == $today) { ?>


                            <tr data-url="javascript:void(0);"
                                onclick="return viewemployee(<?php echo $employee[$i]['employee_id'];?>);">
                                <td><?=$i+1;?></td>
                                <td><?=$employee[$i]['techno_emp_id'];?></td>
                                <td><?=$employee[$i]['employee_name'];?></td>
                                <td><?=$employee[$i]['emp_dob'];?></td>
                            </tr>
                            <?php } }} ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="col-md-2" style="padding: 10px;margin: 0;">
                <div class="icon icon-lg icon-shape text-center " style="margin-top: -15px!important;">
                    <span style="background-color: whitesmoke;width: 100px;font-size: 12px;">Details</span>
                </div>
                <div style="background-color: white;height: 170px;padding: 0px;">

                </div>
            </div>

            <div class="col-md-5" style="border : 1px solid black;padding: 3px;margin: 0;">
                <div class="icon icon-lg icon-shape  " style="margin-top: -15px!important;tec">
                    <span
                        style="background-color: whitesmoke;width: 100px;font-size: 12px;padding-left: 3px;padding-right: 3px;">New
                        Employee Joined</span>
                </div>
                <div style="background-color: #a6e667;" class="dataTable tableFixHead ">
                    <table class="table customer_table" border="1">
                        <thead>
                            <tr style="background-color: #ddd;">
                                <th>Sl</th>
                                <th>Emp.Code</th>
                                <th>Emp.Name</th>
                                <th>Dept.</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($employee) { for ($i=0; $i < count($employee); $i++) {?>
                            <tr data-url="javascript:void(0);"
                                onclick="return viewemployee(<?php echo $employee[$i]['employee_id'];?>);">
                                <td><?=$i+1;?></td>
                                <td><?=$employee[$i]['techno_emp_id'];?></td>
                                <td><?=$employee[$i]['employee_name'];?></td>
                                <td><?=$employee[$i]['department_name'];?></td>
                            </tr>
                            <?php }} ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <?php if($this->session->userdata("access_id") > '0'){ ?>
        <div class="row">
            <div class="col-md-12">
                <h5>Employee Attendance</h5>
                <table class="table  table-condensed table-striped" cellpadding="3">
                    <tr style="background-color: #34495E;color: white;">
                        <th>Emp. ID</th>
                        <th>Employee Name</th>
                        <th>Check in Location</th>
                        <th width="10%">Check in Date & Time</th>
                        <th width="5%"></th>
                        <th>Check Out Location</th>
                        <th width="10%">Check Out Date & Time</th>
                        <th width="5%"></th>
                        <th width="10%" style="text-align:center;">Action</th>
                    </tr>
                    <?php if ($attenrec) { for ($i=0; $i < count($attenrec); $i++) { 
                $rec2 = $this->Common_Model->db_query("SELECT a.log_datetime,a.log_loc,a.log_date,a.status,a.attendance_log_id,a.remarks,a.user_img FROM user_attendance_log as a WHERE a.log_date='".$attenrec[$i]['log_date']."' AND approve_status=0 AND status=2");
              ?>
                    <tr>
                        <td><?=$attenrec[$i]['techno_emp_id'];?> </td>
                        <td><?=$attenrec[$i]['employee_name'];?> </td>
                        <td><?=$attenrec[$i]['log_loc'];?> </td>
                        <td><?=date('d-m-Y H:i:s',strtotime($attenrec[$i]['log_datetime']));?></td>
                        <td style="text-align: center;">
                            <?php if ($attenrec[$i]['user_img']) { 

                    $filePath = FCPATH."uploads/attendancefile/".$rec2[0]['user_img'];
                    if (!file_exists($filePath)) { }else{ 

                    ?>
                            <a href="<?=base_url("uploads/attendancefile/".$attenrec[$i]['user_img']);?>" class=""
                                target="_blank"><i class="fa fa-picture-o" style="color:green;font-size: 17px;"></i></a>
                            <?php }} ?>
                            <br>
                            <a href="javascript:void(0);" title="Update Hour" class="clockineditbtn"><i
                                    class="fa fa-edit" style="color:maroon;font-size: 17px;"></i></a>

                            <div class="modal clockineditModal fade bd-example-modal-sm" tabindex="-1" role="dialog">
                                <div class="modal-dialog modal-dialog-centered modal-sm" role="document"
                                    style="margin-top:15%;padding: 40px;margin-right: 15% !important;">
                                    <div class="modal-content">
                                        <div class="modal-body">
                                            <input type="time" class="form-control input-sm clockintime"
                                                value="<?=date('H:i:s',strtotime($attenrec[$i]['log_datetime']));?>">
                                            <input type="text" class="form-control input-sm remarksin"
                                                value="<?=$attenrec[$i]['remarks'];?>" maxlength="100"
                                                style="margin-top: 5px;" placeholder="Enter Remarks">
                                            <input type="hidden" class="form-control input-sm attendanceclockin_id"
                                                value="<?=$attenrec[$i]['attendance_log_id'];?>">
                                            <button type="button" class="btn btn-primary btn-sm updclockinsubmitBtn"
                                                style="margin-top: 5px;">Update</button>
                                            <button type="button" class="btn btn-warning btn-sm" data-dismiss="modal"
                                                style="margin-top: 5px;">Cancel</button>
                                        </div>


                                    </div>
                                </div>
                            </div>

                        </td>
                        <td><?=$rec2?$rec2[0]['log_loc']:'';?> </td>
                        <td><?=$rec2?date('d-m-Y H:i:s',strtotime($rec2[0]['log_datetime'])):'';?></td>
                        <td style="text-align: center;">
                            <?php if ($rec2 && $rec2[0]['user_img']) { 

                    $filePath = FCPATH."uploads/attendancefile/".$rec2[0]['user_img'];
                    if (!file_exists($filePath)) { }else{ 

                    ?>
                            <a href="<?=base_url("uploads/attendancefile/".$rec2[0]['user_img']);?>" class=""
                                target="_blank"><i class="fa fa-picture-o" style="color:green;font-size: 17px;"></i></a>
                            <?php }} ?>
                            <br>
                            <?php //if ($rec2) { ?>
                            <a href="javascript:void(0);" title="Update Hour" class="clockouteditbtn"><i
                                    class="fa fa-edit" style="color:maroon;font-size: 17px;"></i></a>

                            <div class="modal clockouteditModal fade bd-example-modal-sm" tabindex="-1" role="dialog">
                                <div class="modal-dialog modal-dialog-centered modal-sm" role="document"
                                    style="margin-top:15%;padding: 40px;margin-right: 15% !important;">
                                    <div class="modal-content">
                                        <div class="modal-body">
                                            <input type="time" class="form-control input-sm clockouttime"
                                                value="<?=$rec2?date('H:i:s',strtotime($rec2[0]['log_datetime'])):'';?>">
                                            <input type="text" class="form-control input-sm remarksout"
                                                value="<?=$rec2?$rec2[0]['remarks']:'';?>" maxlength="100"
                                                style="margin-top: 5px;" placeholder="Enter Remarks">
                                            <input type="hidden" class="form-control input-sm attendanceclockout_id"
                                                value="<?=$rec2 && $rec2[0]['attendance_log_id']?$rec2[0]['attendance_log_id']:$attenrec[$i]['attendance_log_id'];?>">
                                            <input type="hidden" class="form-control input-sm attendanceclockout_idval"
                                                value="<?=$rec2 && $rec2[0]['attendance_log_id']?'2':'1';?>">
                                            <button type="button" class="btn btn-primary btn-sm updclockoutsubmitBtn"
                                                style="margin-top: 5px;">Update</button>
                                            <button type="button" class="btn btn-warning btn-sm" data-dismiss="modal"
                                                style="margin-top: 5px;">Cancel</button>
                                        </div>


                                    </div>
                                </div>
                            </div>
                            <?php //} ?>

                        </td>
                        <td width="10%" align="center">
                            <?php if($rec2){ ?>
                            <a href="<?=site_url('dashboard/attenapprv/'.$attenrec[$i]['user_id'].'/'.$attenrec[$i]['log_date']);?>"
                                class="btn btn-xs bg-green"
                                onclick="return confirm('Are you sure for approve?');">Approve</a>
                            <?php } ?>

                        </td>
                    </tr>
                    <?php }} ?>
                </table>
            </div>
        </div>
        <?php } ?>
    </section>
    <?php }else if($this->session->userdata("usertype") == 'Channel Partner') { ?>
    <!-- $this->session->userdata("usertype") == 'Channelpartner') -->
    <section class="content">

        <div class="col-md-12" style="padding:0;margin:0;">
            <div class="box"
                style="background-color:#F0F3F4;box-shadow: rgba(50, 50, 93, 0.25) 0px 30px 60px -12px, rgba(0, 0, 0, 0.3) 0px 18px 36px -18px;">
                <div class="box-header with-border" style="color:#34495E;">
                    <h3 class="box-title"><?=$welcomeMessage;?> [Channel partner]</b></h3>
                    <span class="float-right"><i class="fa fa-calendar" aria-hidden="true"></i> &nbsp<span
                            id="time"></span></span>
                </div>
            </div>
        </div>
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-yellow" style="line-height: .2!important">
                    <div class="inner">
                        <h3><?php echo $leads && $leads > 0 ? $leads : '0'; ?></h3>

                        <p>Total Leads</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-stats-bars" style="line-height: 1.2!important"></i>
                    </div>
                    <a href="" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-red" style="line-height: .2!important">
                    <div class="inner">
                        <h3><?php echo $empexpence && $empexpence[0]['totexp'] > 0 ? $empexpence[0]['totexp'] : '0.00';?>
                        </h3>

                        <p>Expenses</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-pie-graph" style="line-height: 1.2!important"></i>
                    </div>
                    <a href="" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->


        </div>

        <?php } ?>
    </section>




    </div>

    </div>
    <?php $this->load->view("common/footer");?>
    <?php $this->load->view("common/script");?>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>
    <script>
    function viewemployee(Id) {
        var url = "<?php echo site_url(); ?>";
        document.location.href = url + "/employee/viewemployee/" + Id;
    }
    </script>
    <script type="text/javascript">
    var timestamp = '<?=time();?>';

    function updateTime() {
        $('#time').html(Date(timestamp));
        timestamp++;
    }
    $(function() {
        setInterval(updateTime, 1000);
    });
    </script>
    <script type="text/javascript">
    $(document).on('click', '.clockineditbtn', function() {
        var obj = $(this).closest("tr");
        obj.find(".clockineditModal").modal('toggle');
        obj.find(".clockineditModal").modal('show');
    });

    $(document).on('click', '.updclockinsubmitBtn', function() {
        var obj = $(this).closest("tr");
        var attendance_id = obj.find('.attendanceclockin_id').val();
        var colckintime = obj.find('.clockintime').val();
        var remarks = obj.find('.remarksin').val();


        if (colckintime && attendance_id > 0) {
            $.ajax({
                url: '<?=site_url("employee/UpdateClockinTim");?>',
                data: {
                    attendance_id: attendance_id,
                    colckintime: colckintime,
                    remarks: remarks
                },
                dataType: "HTML",
                type: "POST",
                success: function(data) {
                    alert(data)
                    window.location.reload();
                }
            });
        }
    });

    $(document).on('click', '.clockouteditbtn', function() {
        var obj = $(this).closest("tr");
        obj.find(".clockouteditModal").modal('toggle');
        obj.find(".clockouteditModal").modal('show');
    });

    $(document).on('click', '.updclockoutsubmitBtn', function() {
        var obj = $(this).closest("tr");
        var attendance_id = obj.find('.attendanceclockout_id').val();
        var colckouttime = obj.find('.clockouttime').val();
        var remarks = obj.find('.remarksout').val();
        var attenval = obj.find('.attendanceclockout_idval').val();

        if (colckouttime && attendance_id > 0) {

            $.ajax({
                url: '<?=site_url("employee/UpdateClockoutTim");?>',
                data: {
                    attendance_id: attendance_id,
                    colckouttime: colckouttime,
                    remarks: remarks,
                    attenval: attenval
                },
                dataType: "HTML",
                async: true,
                type: "POST",
                success: function(data) {
                    window.location.reload();
                }
            });
        }
    });
    </script>

    <style>
    #chartContainerA {
        width: 520px;
        height: 520px;
        margin-bottom: 100px;
    }

    #chartContainerB {
        width: 520px;
        height: 520px;
        margin-bottom: 100px;
        margin-left: 2%;
    }
    </style>

    <script>
    const ctx = document.getElementById('myPieChart').getContext('2d');

    new Chart(ctx, {
        type: 'pie',
        data: {
            labels: ['Lead Interested', 'Opportunities', 'Site Visit', 'Rejected'],
            datasets: [{
                label: 'Lead Status',
                data: [<?= $interest.",".$opportunity.",".$slead.",".$dlead?>], // Sample data values
                backgroundColor: [
                    '#4CAF50', // Green for Interested                        
                    '#FFC107', // Yellow for Opportunities
                    '#2196F3', // Blue for Site Visit
                    '#F44336' // Red for Rejected
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
            // plugins: {
            //     legend: {
            //         position: 'top'
            //     }
            // }
        }
    });
    </script>
    <script>
    const cty = document.getElementById('leadStatusChart').getContext('2d');

    new Chart(cty, {
        type: 'pie',
        data: {
            labels: ['Available Properties', 'Sold Properties', 'Upcoming Proiperties'],
            datasets: [{
                label: 'Property Status',
                data: [<?= $propa.",".$props.",".$propup?>], // Sample data values
                backgroundColor: [
                    '#4CAF50', // Green for available properties
                    // '#2196F3', // Blue for Initiated

                    '#F44336', // Red for sold properties
                    '#FFC107' // Yellow for upcoming properties
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
            // plugins: {
            //     legend: {
            //         position: 'top'
            //     }
            // }
        }
    });
    </script>
</body>

</html>