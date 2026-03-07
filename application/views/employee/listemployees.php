<?php $this->load->view("common/meta");?>
<div class="wrapper">

    <?php $this->load->view("common/sidebar");?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Employees
            </h1>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">List Employees</h3>
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
                            if($this->session->flashdata('saveandprint')){
                            ?>
                                    <script type="text/javascript">
                                    window.open(
                                        '<?php echo site_url("payments/print_voucher/".$this->session->flashdata('saveandprint'))?>',
                                        'winname',
                                        'directories=no,titlebar=no,toolbar=no,location=no,status=no,menubar=no,scrollbars=no,resizable=no,width=900,height=650'
                                        );
                                    </script>
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
                                <form role="form" action="" method="post" id="searchForm">
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="employee_id">Employee Id</label>
                                            <input type="text" class="form-control" id="employee_id" name="employee_id"
                                                value="<?php echo set_value("employee_id");?>">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="emp_firstname">First Name</label>
                                            <input type="text" class="form-control" id="emp_firstname"
                                                name="emp_firstname" value="<?php echo set_value("emp_firstname");?>">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="emp_lastname">Last Name</label>
                                            <input type="text" class="form-control" id="emp_lastname"
                                                name="emp_lastname" value="<?php echo set_value("emp_lastname");?>">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="employee_email">Aadhaar No</label>
                                            <input type="text" class="form-control" id="employee_email"
                                                name="employee_email" value="<?php echo set_value("employee_email");?>">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="employee_mobile">Mobile</label>
                                            <input type="text" class="form-control" id="employee_mobile"
                                                name="employee_mobile"
                                                value="<?php echo set_value("employee_mobile");?>">
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="date_from">Date From</label>
                                            <input type="date" class="form-control" id="date_from" name="date_from"
                                                value="<?php echo set_value("date_from");?>">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="date_to">Date To</label>
                                            <input type="date" class="form-control" id="date_to" name="date_to"
                                                value="<?php echo set_value("date_to");?>">
                                        </div>
                                    </div>
                                    <div class="col-md-4" style="padding-top: 25px;">
                                        <button type="submit" name="submitBtn" value="submit"
                                            class="btn bg-navy btn-flat">Search</button>
                                        <button type="submit" name="downloadBtn" value="submit"
                                            formaction="<?php echo site_url("employee/download_emp");?>"
                                            class="btn bg-success btn-flat">Download</button>
                                    </div>
                                </form>
                            </div>
                            <div class="row">
                                <div class="col-md-12" id="dataTablediv">
                                    <table id="" class="table table-bordered table-condensed table-striped">
                                        <tr>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Mobile</th>
                                            <th>Joining Dt.</th>
                                            <th>Date of Birth</th>
                                            <th>Address</th>
                                            <th>Status</th>
                                            <th>Last edited by</th>
                                        </tr>
                                        <?php if($records){ for($i=0;$i<count($records);$i++){?>
                                        <tr>
                                            <td>
                                                <div class="input-group-btn">
                                                    <button type="button"
                                                        class="btn bg-maroon btn-flat btn-xs dropdown-toggle"
                                                        data-toggle="dropdown" aria-expanded="false"
                                                        style="width:100%;"><?php echo $records[$i]['techno_emp_id'];?>&nbsp;<span
                                                            class="fa fa-caret-down float-right"></span></button>
                                                    <ul class="dropdown-menu">
                                                        <?php if(in_array('empprofileview', $accessar) || $this->session->userdata('usertype') == 'Admin'){ ?>
                                                        <li><a
                                                                href="<?php echo site_url("employee/viewemployee/".$records[$i]['employee_id']);?>">View</a>
                                                        </li>
                                                        <?php }?>
                                                        <?php if(in_array('empedit', $accessar) || $this->session->userdata('usertype') == 'Admin'){ ?>
                                                        <li><a
                                                                href="<?php echo site_url("employee/editemployee/".$records[$i]['employee_id']);?>">Edit
                                                                Basic Details</a></li>
                                                        <!-- <li><a href="<?php echo site_url("employee/otherdetails/".$records[$i]['employee_id']);?>">Other Details</a></li> -->
                                                        <!-- <li><a href="<?php echo site_url("employee/bankandkyc/".$records[$i]['employee_id']);?>" >Bank & KYC Details</a></li>
                                                <li><a href="<?php echo site_url("employee/pfandesi/".$records[$i]['employee_id']);?>" >PF & ESI Settings</a></li>
                                                <li><a href="<?php echo site_url("employee/ecademicandtraining/".$records[$i]['employee_id']);?>" >Ecademic & Training Details</a></li>
                                                <li><a href="<?php echo site_url("employee/nomineeandfamily/".$records[$i]['employee_id']);?>" >Nominee & Family Member Details</a></li> -->


                                                        <!-- <li><a href="<?php echo site_url("employee/employee_documents/".$records[$i]['employee_id']);?>" >Documents</a></li> -->
                                                        <?php } ?>
                                                        <li class="divider"></li>

                                                        <?php if(in_array('empdelete', $accessar) || $this->session->userdata('usertype') == 'Admin'){ ?>

                                                        <li><a href="<?php echo site_url("employee/deleteemployee/".$records[$i]['employee_id']);?>"
                                                                onclick="return confirm('Are you sure to delete this?');">Delete</a>
                                                        </li>
                                                        <?php }?>


                                                    </ul>
                                                    <?php if ($records[$i]['emp_status']=='Active') {
                                                $ocolor = '#52be80';
                                            }else if ($records[$i]['emp_status']=='Deactive') {
                                                $ocolor = '#ec7063';
                                            }else if ($records[$i]['emp_status']=='Leave') {
                                                $ocolor = '#48c9b0';
                                            }else if ($records[$i]['emp_status']=='Block') {
                                                $ocolor = '#34495e';
                                            }   
                                            ?>
                                                    <input type="hidden" class="employee_id"
                                                        value="<?=$records[$i]['employee_id'];?>">
                                                    <select class="empstatus form-control input-sm"
                                                        style="background-color:<?=$ocolor;?>;color:white;">
                                                        <option value="Active"
                                                            style="background-color:#52be80;color: white;"
                                                            <?=$records[$i]['emp_status']=='Active'?'selected':'';?>>
                                                            Active</option>
                                                        <option value="Deactive"
                                                            style="background-color: #ec7063;color: white;"
                                                            <?=$records[$i]['emp_status']=='Deactive'?'selected':'';?>>
                                                            Deactive</option>
                                                        <option value="Leave"
                                                            style="background-color: #48c9b0;color: white;"
                                                            <?=$records[$i]['emp_status']=='Leave'?'selected':'';?>>
                                                            Leave</option>
                                                        <option value="Block"
                                                            style="background-color: #34495e;color: white;"
                                                            <?=$records[$i]['emp_status']=='Block'?'selected':'';?>>
                                                            Block</option>
                                                    </select>
                                                </div>
                                            </td>
                                            <td>
                                                <ul class="products-list product-list-in-box">
                                                    <li class="item" style="padding:0px;">
                                                        <div class="product-img">
                                                            <a
                                                                href="<?php echo site_url("employee/viewemployee/".$records[$i]['employee_id']);?>">
                                                                <?php 
                                                if($records[$i]['emp_photo'] != ''){
                                                ?>
                                                                <img src="<?=base_url();?>uploads/employeeicon/<?=$records[$i]['emp_photo']?>"
                                                                    style="width:50px; height:50px;">
                                                                <?php
                                                }else{
                                                ?>
                                                                <img src="<?=base_url()?>assets/usericon.png"
                                                                    style="width:50px; height:50px;">
                                                                <?php
                                                }
                                                ?>
                                                            </a>
                                                        </div>
                                                        <div class="product-info">
                                                            <a href="<?php echo site_url("employee/viewemployee/".$records[$i]['employee_id']);?>"
                                                                class="product-title">
                                                                <?php echo $records[$i]['employee_name'];?>
                                                            </a>

                                                            <span class="product-description">
                                                                Department :
                                                                <?php echo $records[$i]['department_name'];?>
                                                            </span>

                                                            <?php if(!empty($records[$i]['designation_name'])){ ?>
                                                            <span class="product-description">
                                                                Role : <?php echo $records[$i]['designation_name'];?>
                                                            </span>
                                                            <?php } ?>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </td>

                                            <td>
                                                <?php echo $records[$i]['emp_mobile'];?><br />
                                                <?php echo $records[$i]['employee_mobile2'];?>
                                            </td>
                                            <td><?php echo $records[$i]['emp_doj'] != '' && $records[$i]['emp_doj'] != '0000-00-00' ? date("d/m/Y", strtotime($records[$i]['emp_doj'])) : '';?>
                                            </td>
                                            <td><?php echo $records[$i]['emp_dob'] != '' && $records[$i]['emp_dob'] != '0000-00-00' ? date("d/m/Y", strtotime($records[$i]['emp_dob'])) : '';?>
                                            </td>
                                            <td><?php echo 'AT: '.$records[$i]['emp_at'];?>
                                                <?php echo '<br>PO: '.$records[$i]['emp_po'];?>
                                                <?php echo '<br>PLACE: '.$records[$i]['emp_landmark']."-".$records[$i]['emp_curpin'];?>
                                            </td>
                                            <td><?php echo $records[$i]['emp_status'];?></td>
                                            <td><?php echo isset($records[$i]['last_edit_by'])?$records[$i]['last_edit_by']:'';?>
                                                <br>
                                                <?php echo isset($records[$i]['last_edit_on'])?date("d-M-Y h:i:s",strtotime($records[$i]['last_edit_on'])):'';?>
                                            </td>
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
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <?php $this->load->view("common/footer");?>
</div>
<!-- ./wrapper -->

<?php $this->load->view("common/script");?>

<script type="text/javascript">
function searchForm() {
    //alert(4);
    $.ajax({
        url: "<?php echo site_url('employee/listemployees_ajax');?>",
        type: "POST",
        data: $("#searchForm").serialize(),
        dataType: "html",
        success: function(data) {
            $('#dataTablediv').html(data);
        }
    });
}
$(document).ready(function() {
    $(document).on('change', '.empstatus', function() {
        var empstatus = $(this).val();
        var obj = $(this).closest("tr");
        var emp_id = obj.find(".employee_id").val();
        if (confirm("Are you sure to " + empstatus + " this employee?")) {
            $.ajax({
                url: "<?php echo site_url('employee/updateempstatus');?>",
                type: "POST",
                data: {
                    emp_id: emp_id,
                    empstatus: empstatus
                },
                dataType: "html",
                success: function(data) {
                    //alert(data)
                    location.reload();
                }
            });
        }
    });
});
</script>
</body>

</html>