<?php $this->load->view("common/meta");?>
<div class="wrapper">

    <?php $this->load->view("common/sidebar");?>

    <div class="content-wrapper">
        <section class="content-header">
            <h1>
                Employees <small>Add Employee</small>
            </h1>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="box">
                        <!-- <div class="box-header with-border">
            <h3 class="box-title">Add Employee</h3>
        </div> -->
                        <form role="form" action="<?php echo site_url("employee/addemployee");?>" method="post"
                            enctype="multipart/form-data">
                            <div class="box-body">
                                <div class="">
                                    <div class="col-md-12">
                                        <?php
                        if($this->session->flashdata('success')){
                        ?>
                                        <div class="alert alert-dismissable alert-success">
                                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                                            <strong>Success !</strong>
                                            <?php echo $this->session->flashdata('success');?>
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
                                    <div class="nav-tabs-custom">
                                        <ul class="nav nav-tabs">
                                            <li class="active"><a href="#profile" data-toggle="tab">Employee Profile</a>
                                            </li>
                                            <!-- <li><a href="#bankandkyc" data-toggle="tab">Bank & KYC Details</a></li>
                    <li><a href="#pfandesi" data-toggle="tab">PF & ESI Settings</a></li>
                    <li class="salstructure" style="display:block;"><a href="#salarystructure" data-toggle="tab">Salary Structure</a></li> -->

                                        </ul>
                                        <div class="tab-content">
                                            <div class="active tab-pane" id="profile">
                                                <div class="row">
                                                    <div class="col-md-12"
                                                        style="margin-top:15px;border : 1px solid #ddd;padding: 15px;">
                                                        <div class="icon icon-lg icon-shape"
                                                            style="margin-top: -28px!important;">
                                                            <span
                                                                style="background-color: white;width: 100px;font-size: 12px;padding-left: 4px;padding-right: 4px;">Personal
                                                                & Contact</span>
                                                        </div>
                                                        <div class="col-md-4" style="padding:0;">
                                                            <div class="form-group">
                                                                <div class="col-md-12">
                                                                    <div class="row">
                                                                        <div class="col-md-4">
                                                                            <label for="emp_firstname"
                                                                                style="margin-top:5px;">Employee
                                                                                Id</label>
                                                                        </div>
                                                                        <div class="col-md-8">
                                                                            <input type="text"
                                                                                class="form-control input-sm"
                                                                                id="techno_emp_id" name="techno_emp_id"
                                                                                value="<?=$techno_emp_id;?>" readonly>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12" style="margin-top:5px;">
                                                                    <div class="row">
                                                                        <div class="col-md-4">
                                                                            <label for="emp_firstname"
                                                                                style="margin-top:5px;">First
                                                                                name</label><span
                                                                                style="color:red;">*</span>
                                                                        </div>
                                                                        <div class="col-md-8">
                                                                            <input type="text"
                                                                                class="form-control input-sm"
                                                                                id="emp_firstname" name="emp_firstname"
                                                                                value="<?php echo set_value("emp_firstname");?>"
                                                                                placeholder="Enter First Name"
                                                                                required="required">
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-12" style="margin-top:5px;">
                                                                    <div class="row">
                                                                        <div class="col-md-4">
                                                                            <label for="emp_firstname"
                                                                                style="margin-top:5px;">Nick
                                                                                name</label>
                                                                        </div>
                                                                        <div class="col-md-8">
                                                                            <input type="text"
                                                                                class="form-control input-sm"
                                                                                id="emp_nickname" name="emp_nickname"
                                                                                value="<?php echo set_value("emp_nickname");?>"
                                                                                placeholder="Enter Nick Name">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-8" style="padding:0;">
                                                            <div class="form-group">
                                                                <div class="col-md-12">
                                                                    <div class="row">
                                                                        <div class="col-md-2">
                                                                            <label for="emp_lastname"
                                                                                style="margin-top:5px;">Status</label>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <select class="form-control input-sm"
                                                                                id="emp_status" name="emp_status"
                                                                                value="<?php echo set_value("emp_status");?>"
                                                                                required="required">
                                                                                <option value="Active">Active</option>
                                                                                <option value="Inactive">Inactive
                                                                                </option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="col-md-2" style="padding:0;">
                                                                            <label>Gender</label>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <input type="radio" name="emp_gender"
                                                                                class="forh" value="Male" checked> Male
                                                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                            <input type="radio" name="emp_gender"
                                                                                class="forh" value="Female"> Female
                                                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                            <input type="radio" name="emp_gender"
                                                                                class="forh" value="Others"> Others
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12" style="margin-top:5px;">
                                                                    <div class="row">
                                                                        <div class="col-md-2">
                                                                            <label for="emp_lastname"
                                                                                style="margin-top:5px;">Middle
                                                                                name</label>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <input type="text"
                                                                                class="form-control input-sm"
                                                                                id="emp_middlename"
                                                                                name="emp_middlename"
                                                                                value="<?php echo set_value("emp_middlename");?>"
                                                                                placeholder="Enter Middle Name">
                                                                        </div>
                                                                        <div class="col-md-2" style="padding:0;">
                                                                            <label for="emp_lastname"
                                                                                style="margin-top:5px;">Last
                                                                                name</label><span
                                                                                style="color:red;">*</span>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <input type="text"
                                                                                class="form-control input-sm"
                                                                                id="emp_lastname" name="emp_lastname"
                                                                                value="<?php echo set_value("emp_lastname");?>"
                                                                                placeholder="Enter Last Name"
                                                                                required="required">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12" style="margin-top:5px;">
                                                                    <div class="row">
                                                                        <div class="col-md-2">
                                                                            <label for="emp_lastname"
                                                                                style="margin-top:5px;">DOB</label><span
                                                                                style="color:red;">*</span>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <input type="date"
                                                                                class="form-control input-sm"
                                                                                id="emp_dob" name="emp_dob"
                                                                                value="<?php echo set_value("emp_dob");?>"
                                                                                required="required">

                                                                        </div>

                                                                        <div class="col-md-2" style="padding:0;">
                                                                            <label for="emp_appform_no"
                                                                                style="margin-top:5px;">Application
                                                                                No</label>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <input type="text"
                                                                                class="form-control input-sm"
                                                                                id="emp_appform_no"
                                                                                name="emp_appform_no"
                                                                                value="<?php echo set_value("emp_appform_no");?>"
                                                                                placeholder="Enter Application No.">
                                                                        </div>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div class="col-md-12"
                                                        style="border : 1px solid #ddd;padding: 15px;margin-top: 10px;">
                                                        <div class="col-md-6" style="padding:0;">
                                                            <div class="form-group">
                                                                <div class="col-md-12">
                                                                    <div class="row">
                                                                        <div class="col-md-4">
                                                                            <label for="emp_maritalstatus"
                                                                                style="margin-top:5px;">Marital
                                                                                Status</label>
                                                                        </div>
                                                                        <div class="col-md-8" style="margin-top:6px;">
                                                                            <input type="radio" class="forh"
                                                                                name="emp_maritalstatus" value="Yes">
                                                                            Married
                                                                            <input type="radio" class="forh"
                                                                                name="emp_maritalstatus" value="No"
                                                                                style="margin-left:50px;" checked>
                                                                            Unmarried
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-12" style="margin-top:5px;">
                                                                    <div class="row">
                                                                        <div class="col-md-4">
                                                                            <label for="emp_age"
                                                                                style="margin-top:5px;"> Age</label>
                                                                        </div>
                                                                        <div class="col-md-8">
                                                                            <input type="number"
                                                                                class="form-control input-sm"
                                                                                id="emp_age" name="emp_age"
                                                                                value="<?php echo set_value("emp_age");?>"
                                                                                placeholder="Enter Age" readonly>
                                                                        </div>
                                                                    </div>
                                                                </div>



                                                                <div class="col-md-12" style="margin-top:5px;">
                                                                    <div class="row">
                                                                        <div class="col-md-4">
                                                                            <label for="emp_doj"
                                                                                style="margin-top:5px;">Date of
                                                                                Joining</label>
                                                                        </div>
                                                                        <div class="col-md-8">
                                                                            <input type="date"
                                                                                class="form-control input-sm"
                                                                                id="emp_doj" name="emp_doj"
                                                                                value="<?php echo date("Y-m-d");?>">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12" style="margin-top:5px;">
                                                                    <div class="row">
                                                                        <div class="col-md-4">
                                                                            <label for="emp_jobtype"
                                                                                style="margin-top:5px;">Job Type</label>
                                                                        </div>
                                                                        <div class="col-md-8">
                                                                            <input class="form-control input-sm"
                                                                                id="emp_jobtype" name="emp_jobtype"
                                                                                value="<?php echo set_value("emp_jobtype");?>">


                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-12" style="margin-top:5px;">
                                                                    <div class="row">
                                                                        <div class="col-md-4">
                                                                            <label for="emp_department"
                                                                                style="margin-top:5px;">Department</label><span
                                                                                style="color:red;">*</span>
                                                                        </div>
                                                                        <div class="col-md-8">
                                                                            <select class="form-control input-sm"
                                                                                id="emp_department"
                                                                                name="emp_department" required>
                                                                                <option value="">None</option>
                                                                                <?php if(!empty($department)){
                                                                                    foreach ($department as $k => $v) {
                                        
                                                                                    echo '<option value="'.$v['did'].'">'.$v['department_name'].'</option>';
                                                                                    }
                                                                                    }
                                                                                    ?>
                                                                            </select>

                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12" style="margin-top:5px;">
                                                                    <div class="row">
                                                                        <div class="col-md-4">
                                                                            <label for="emp_designation"
                                                                                style="margin-top:5px;">Designation</label><span
                                                                                style="color:red;">*</span>
                                                                        </div>
                                                                        <div class="col-md-8">
                                                                            <select class="form-control input-sm"
                                                                                id="emp_designation"
                                                                                name="emp_designation">
                                                                                <option value="">None</option>
                                                                            </select>

                                                                        </div>
                                                                    </div>
                                                                </div>


                                                                <div class="col-md-12" style="margin-top:5px;">
                                                                    <div class="row">
                                                                        <div class="col-md-4">
                                                                            <label for="emp_pob" style="margin-top:5px;"
                                                                                id="emp_pob">Place Of Birth</label>
                                                                        </div>
                                                                        <div class="col-md-8">
                                                                            <input type="text"
                                                                                class="form-control input-sm"
                                                                                id="emp_pob" name="emp_pob"
                                                                                value="<?php echo set_value("emp_pob");?>"
                                                                                required="required" placeholder="">
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-12" style="margin-top:5px;">
                                                                    <div class="row">
                                                                        <div class="col-md-4">
                                                                            <label for="emp_remark"
                                                                                style="margin-top:5px;">Experience
                                                                            </label>
                                                                        </div>
                                                                        <div class="col-md-8">
                                                                            <select type="text"
                                                                                class="form-control input-sm"
                                                                                id="exp_year" name="exp_year">
                                                                                <?php for ($i=0; $i <= 30; $i++) { ?>
                                                                                <option value="<?=$i;?>"><?=$i;?> Year
                                                                                </option>
                                                                                <?php } ?>
                                                                            </select>

                                                                        </div>
                                                                    </div>
                                                                </div>


                                                                <div class="col-md-12" style="margin-top:5px;">
                                                                    <div class="row">
                                                                        <div class="col-md-4">
                                                                            <label for="dutyhour"
                                                                                style="margin-top:5px;">Duty
                                                                                Hour</label><span
                                                                                style="color:red;">*</span>
                                                                        </div>
                                                                        <div class="col-md-8">
                                                                            <input type="number"
                                                                                class="form-control input-sm"
                                                                                id="dutyhour" name="dutyhour" required
                                                                                step="0.01" value="8">


                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-12" style="margin-top:5px;">
                                                                    <div class="row">
                                                                        <div class="col-md-4">
                                                                            <label for="grade"
                                                                                style="margin-top:5px;">Grade</label>
                                                                        </div>
                                                                        <div class="col-md-8">
                                                                            <select class="form-control input-sm"
                                                                                name="grade" id="grade">
                                                                                <option value="">-- Select Grade --
                                                                                </option>
                                                                                <option value="junior">Junior</option>
                                                                                <option value="mid">Mid</option>
                                                                                <option value="upper">Upper</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-12" style="margin-top:5px;">
                                                                    <div class="row">
                                                                        <div class="col-md-4">
                                                                            <label for="e_salary"
                                                                                style="margin-top:5px;">Salary</label>
                                                                        </div>
                                                                        <div class="col-md-8">
                                                                            <input type="number" step="0.01"
                                                                                class="form-control input-sm"
                                                                                id="e_salary" name="e_salary"
                                                                                placeholder="Enter Salary">
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>

                                                        <div class="col-md-6" style="padding:0;">
                                                            <div class="form-group">

                                                                <div class="col-md-12" style="margin-top:5px;">
                                                                    <div class="row">
                                                                        <div class="col-md-4">
                                                                            <label for="emp_photo"
                                                                                style="margin-top:5px;">Employee
                                                                                Photo</label>
                                                                        </div>
                                                                        <div class="col-md-8">
                                                                            <input type="file"
                                                                                class="form-control input-sm"
                                                                                id="emp_photo" name="emp_photo"
                                                                                accept="image/png,image/jpeg,image/jpg">
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-12" style="margin-top:5px;">
                                                                    <div class="row">
                                                                        <div class="col-md-4">
                                                                            <label for="emp_mobile"
                                                                                style="margin-top:5px;">Mobile
                                                                                No.</label><span
                                                                                style="color:red;">*</span>
                                                                        </div>
                                                                        <div class="col-md-8">
                                                                            <input type="tel"
                                                                                class="form-control input-sm"
                                                                                id="emp_mobile" name="emp_mobile"
                                                                                maxlength="10"
                                                                                placeholder="Enter Mobile No." required>

                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-12" style="margin-top:5px;">
                                                                    <div class="row">
                                                                        <div class="col-md-4">
                                                                            <label for="emp_amobile"
                                                                                style="margin-top:5px;">Alternate Mobile
                                                                                No.</label>
                                                                        </div>
                                                                        <div class="col-md-8">
                                                                            <input type="tel"
                                                                                class="form-control input-sm"
                                                                                id="emp_amobile" name="emp_amobile"
                                                                                maxlength="10"
                                                                                placeholder="Enter Alternate Mobile No.">

                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-12" style="margin-top:5px;">
                                                                    <div class="row">
                                                                        <div class="col-md-4">
                                                                            <label for="emp_designation"
                                                                                style="margin-top:5px;">Email</label><span
                                                                                style="color:red;">*</span>
                                                                        </div>
                                                                        <div class="col-md-8">
                                                                            <input type="email"
                                                                                class="form-control input-sm"
                                                                                id="employee_email"
                                                                                name="employee_email" required
                                                                                placeholder="Enter Email">
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-12" style="margin-top:5px;">
                                                                    <div class="row">
                                                                        <div class="col-md-4">
                                                                            <label for="official_email"
                                                                                style="margin-top:5px;">Official
                                                                                Email</label><span
                                                                                style="color:red;">*</span>
                                                                        </div>
                                                                        <div class="col-md-8">
                                                                            <input type="email"
                                                                                class="form-control input-sm"
                                                                                id="official_email"
                                                                                name="official_email" required
                                                                                placeholder="Enter Official Email (To be created)">
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-12" style="margin-top:5px;">
                                                                    <div class="row">
                                                                        <div class="col-md-4">
                                                                            <label for="emp_pgmobile"
                                                                                style="margin-top:5px;">
                                                                                Parents/Guardian Mobile No.</label>
                                                                        </div>
                                                                        <div class="col-md-8">
                                                                            <input type="tel"
                                                                                class="form-control input-sm"
                                                                                id="emp_pgmobile" name="emp_pgmobile"
                                                                                maxlength="10"
                                                                                placeholder="Enter Mobile No.">

                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-12" style="margin-top:5px;">
                                                                    <div class="row">
                                                                        <div class="col-md-4">
                                                                            <label for="emp_bloodgrp"
                                                                                style="margin-top:5px;"> Blood
                                                                                Group</label>
                                                                        </div>
                                                                        <div class="col-md-8">
                                                                            <select class="form-control input-sm"
                                                                                id="emp_bloodgrp" name="emp_bloodgrp">
                                                                                <option value="">--Select Blood group--
                                                                                </option>
                                                                                <option value="A+">A+</option>
                                                                                <option value="A-">A-</option>
                                                                                <option value="B+">B+</option>
                                                                                <option value="B-">B-</option>
                                                                                <option value="AB+">AB+</option>
                                                                                <option value="AB-">AB-</option>
                                                                                <option value="O+">O+</option>
                                                                                <option value="O-">O-</option>
                                                                            </select>

                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-12" style="margin-top:5px;">
                                                                    <div class="row">
                                                                        <div class="col-md-4">
                                                                            <label for="higher_qual"
                                                                                style="margin-top:5px;">Higher
                                                                                Qualification</label>
                                                                        </div>
                                                                        <div class="col-md-8">
                                                                            <input type="text"
                                                                                class="form-control input-sm"
                                                                                id="higher_qual" name="higher_qual"
                                                                                placeholder="Enter Higher Qualification">

                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-12" style="margin-top:5px;">
                                                                    <div class="row">
                                                                        <div class="col-md-4">
                                                                            <label for="nationality"
                                                                                style="margin-top:5px;">Nationality</label>
                                                                        </div>
                                                                        <div class="col-md-8">
                                                                            <input type="text"
                                                                                class="form-control input-sm"
                                                                                id="nationality" name="nationality"
                                                                                placeholder="Enter Nationality">
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-12" style="margin-top:5px;">
                                                                    <div class="row">
                                                                        <div class="col-md-4">
                                                                            <label for="reporting"
                                                                                style="margin-top:5px;">Reporting
                                                                                To</label>
                                                                        </div>
                                                                        <div class="col-md-8">
                                                                            <input type="text"
                                                                                class="form-control input-sm"
                                                                                id="reporting" name="reporting"
                                                                                placeholder="Enter Name & Designation">
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                        <div class="col-md-12" style="margin-top:5px;">
                                                            <div class="row">
                                                                <div class="col-md-2">
                                                                    <label for="emergency_name"
                                                                        style="margin-top:5px;">Emergency Contact
                                                                        Name</label>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <input type="text" class="form-control input-sm"
                                                                        id="emergency_name" name="emergency_name"
                                                                        value="<?php echo set_value("emergency_name");?>"
                                                                        placeholder="Enter Emergency Contact Name">
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <label for="emergency_relation"
                                                                        style="margin-top:5px;">Emergency Contact
                                                                        Relation</label>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <input type="text" class="form-control input-sm"
                                                                        id="emergency_relation"
                                                                        name="emergency_relation"
                                                                        value="<?php echo set_value("emergency_relation");?>"
                                                                        placeholder="Enter Emergency Contact Relation">
                                                                </div>
                                                                <div class="col-md-2" style="padding:0;">
                                                                    <label for="emergency_contact"
                                                                        style="margin-top:5px;">Emergency Contact
                                                                        No.</label>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <input type="tel" class="form-control input-sm"
                                                                        id="emergency_contact" name="emergency_contact"
                                                                        value="<?php echo set_value("emergency_contact");?>"
                                                                        placeholder="Enter Emergency Contact No."
                                                                        required="required">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12"
                                                        style="margin-top:15px;border: 1px solid #ddd;padding: 14px;border-radius: 5px;">
                                                        <div class="icon icon-lg icon-shape"
                                                            style="margin-top: -25px!important;">
                                                            <span
                                                                style="background-color: white;width: 100px;font-size: 12px;padding-left: 4px;padding-right: 4px;">Family
                                                                Details & Occupations</span>
                                                        </div>
                                                        <div class="">
                                                            <div class="col-md-6" style="padding:0;">
                                                                <div class="form-group">
                                                                    <div class="col-md-12" style="margin-top:5px;">
                                                                        <div class="row">
                                                                            <div class="col-md-4">
                                                                                <label for="emp_fathername"
                                                                                    style="margin-top:5px;"
                                                                                    id="forhnm">Father's
                                                                                    Name</label><span
                                                                                    style="color:red;">*</span>
                                                                            </div>
                                                                            <div class="col-md-8">
                                                                                <input type="text"
                                                                                    class="form-control input-sm"
                                                                                    id="emp_fathername"
                                                                                    name="emp_fathername"
                                                                                    value="<?php echo set_value("emp_fathername");?>"
                                                                                    placeholder="Enter Father's Name">
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-md-12" style="margin-top:15px;">
                                                                        <div class="row">
                                                                            <div class="col-md-4">
                                                                                <label for="emp_mothername"
                                                                                    style="margin-top:5px;">Mother's
                                                                                    Name</label>
                                                                            </div>
                                                                            <div class="col-md-8">
                                                                                <input type="text"
                                                                                    class="form-control input-sm"
                                                                                    id="emp_mothername"
                                                                                    name="emp_mothername"
                                                                                    value="<?php echo set_value("emp_mothername");?>"
                                                                                    placeholder="Enter Mother's Name">
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-md-12" style="margin-top:15px;">
                                                                        <div class="row">
                                                                            <div class="col-md-4">
                                                                                <label for="emp_spousename"
                                                                                    style="margin-top:5px;"
                                                                                    id="emp_spousename">Spouse's
                                                                                    Name</label><span
                                                                                    style="color:red;">*</span>
                                                                            </div>
                                                                            <div class="col-md-8">
                                                                                <input type="text"
                                                                                    class="form-control input-sm"
                                                                                    id="emp_spousename"
                                                                                    name="emp_spousename"
                                                                                    value="<?php echo set_value("emp_spousename");?>"
                                                                                    placeholder="Enter Spouse's Name">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6" style="padding:0;">
                                                                <div class="form-group">

                                                                    <div class="col-md-12" style="margin-top:6px;">
                                                                        <div class="row">
                                                                            <div class="col-md-4">
                                                                                <label for="f_occ"
                                                                                    style="margin-top:5px;">Father
                                                                                    Occupation</label>
                                                                            </div>
                                                                            <div class="col-md-8">
                                                                                <input type="text"
                                                                                    class="form-control input-sm"
                                                                                    id="f_occ" name="f_occ"
                                                                                    placeholder="Enter Occupation">
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-md-12" style="margin-top:6px;">
                                                                        <div class="row">
                                                                            <div class="col-md-4">
                                                                                <label for="m_occ"
                                                                                    style="margin-top:5px;">Mother's
                                                                                    Occupation</label>
                                                                            </div>
                                                                            <div class="col-md-8">
                                                                                <input type="text"
                                                                                    class="form-control input-sm"
                                                                                    id="m_occ" name="m_occ"
                                                                                    placeholder="Enter Occupation">
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-md-12" style="margin-top:6px;">
                                                                        <div class="row">
                                                                            <div class="col-md-4">
                                                                                <label for="s_occ"
                                                                                    style="margin-top:5px;">Spouse's
                                                                                    Occupation</label>
                                                                            </div>
                                                                            <div class="col-md-8">
                                                                                <input type="text"
                                                                                    class="form-control input-sm"
                                                                                    id="s_occ" name="s_occ"
                                                                                    placeholder="Enter Occupation">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12"
                                                        style="margin-top:15px;border: 1px solid #ddd;padding: 14px;border-radius: 5px;">
                                                        <div class="icon icon-lg icon-shape"
                                                            style="margin-top: -25px!important;">
                                                            <span
                                                                style="background-color: white;width: 100px;font-size: 12px;padding-left: 4px;padding-right: 4px;">Current
                                                                Address</span>
                                                        </div>
                                                        <div class="">
                                                            <div class="col-md-6" style="padding:0;">
                                                                <div class="form-group">
                                                                    <div class="col-md-12">
                                                                        <div class="row">
                                                                            <div class="col-md-4">
                                                                                <label for="emp_current"
                                                                                    style="margin-top:5px;">PLOT/HOUSE/KHATA
                                                                                    No</label>
                                                                            </div>
                                                                            <div class="col-md-8">
                                                                                <input type="text"
                                                                                    class="form-control input-sm"
                                                                                    id="emp_plotno" name="emp_plotno"
                                                                                    placeholder="PLOT/HOUSE/KHATA No">
                                                                            </div>
                                                                        </div>
                                                                    </div>


                                                                    <div class="col-md-12" style="margin-top:6px;">
                                                                        <div class="row">
                                                                            <div class="col-md-4">
                                                                                <label for="emp_address"
                                                                                    style="margin-top:5px;">State</label>
                                                                            </div>
                                                                            <div class="col-md-8">
                                                                                <select class="form-control input-sm"
                                                                                    id="emp_state" name="emp_state">
                                                                                    <option value="">State</option>
                                                                                    <?php if ($state) { for ($i=0; $i < count($state); $i++) { ?>
                                                                                    <option
                                                                                        value="<?=$state[$i]['state_id'];?>">
                                                                                        <?=$state[$i]['state_title'];?>
                                                                                    </option>
                                                                                    <?php } } ?>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-12" style="margin-top:6px;">
                                                                        <div class="row">
                                                                            <div class="col-md-4">
                                                                                <label for="emp_address"
                                                                                    style="margin-top:5px;">District</label>
                                                                            </div>
                                                                            <div class="col-md-8">
                                                                                <select class="form-control input-sm"
                                                                                    id="emp_dist" name="emp_dist">
                                                                                    <option value="">District</option>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-12" style="margin-top:6px;">
                                                                        <div class="row">
                                                                            <div class="col-md-4">
                                                                                <label for="emp_curpin"
                                                                                    style="margin-top:5px;">Pin
                                                                                    Code</label>
                                                                            </div>
                                                                            <div class="col-md-8">
                                                                                <input type="number"
                                                                                    class="form-control input-sm"
                                                                                    id="emp_curpin" name="emp_curpin"
                                                                                    placeholder="Enter Pincode">
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                            <div class="col-md-6" style="padding:0;">
                                                                <div class="form-group">
                                                                    <div class="col-md-12">
                                                                        <div class="row">
                                                                            <div class="col-md-4">
                                                                                <label for="emp_address"
                                                                                    style="margin-top:5px;">AT</label>
                                                                            </div>
                                                                            <div class="col-md-8">
                                                                                <input type="text"
                                                                                    class="form-control input-sm"
                                                                                    id="emp_at" name="emp_at"
                                                                                    placeholder="Enter At">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-12" style="margin-top:6px;">
                                                                        <div class="row">
                                                                            <div class="col-md-4">
                                                                                <label for="emp_address"
                                                                                    style="margin-top:5px;">PO</label>
                                                                            </div>
                                                                            <div class="col-md-8">
                                                                                <input type="text"
                                                                                    class="form-control input-sm"
                                                                                    id="emp_po" name="emp_po"
                                                                                    placeholder="Enter PO">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-12" style="margin-top:6px;">
                                                                        <div class="row">
                                                                            <div class="col-md-4">
                                                                                <label for="emp_address"
                                                                                    style="margin-top:5px;">TALUKA/TAHSIL</label>
                                                                            </div>
                                                                            <div class="col-md-8">
                                                                                <input type="text"
                                                                                    class="form-control input-sm"
                                                                                    id="emp_tahsil" name="emp_tahsil"
                                                                                    placeholder="Enter Tahsil">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-12" style="margin-top:6px;">
                                                                        <div class="row">
                                                                            <div class="col-md-4">
                                                                                <label for="emp_curpin"
                                                                                    style="margin-top:5px;">Landmark</label>
                                                                            </div>
                                                                            <div class="col-md-8">
                                                                                <input type="text"
                                                                                    class="form-control input-sm"
                                                                                    id="emp_landmark"
                                                                                    name="emp_landmark"
                                                                                    placeholder="Enter Landmark">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>



                                                    </div>

                                                    <div class="col-md-12"
                                                        style="margin-top:15px;border: 1px solid #ddd;padding: 14px;border-radius: 5px;">
                                                        <div class="icon icon-lg icon-shape"
                                                            style="margin-top: -25px!important;">
                                                            <span
                                                                style="background-color: white;width: 100px;font-size: 12px;padding-left: 4px;padding-right: 4px;">Permanent
                                                                Address &nbsp;<input type="checkbox"
                                                                    id="sameaddress"></span>
                                                        </div>

                                                        <div class="">
                                                            <div class="col-md-6" style="padding:0;">
                                                                <div class="form-group">
                                                                    <div class="col-md-12">
                                                                        <div class="row">
                                                                            <div class="col-md-4">
                                                                                <label for="emp_current"
                                                                                    style="margin-top:5px;">PLOT/HOUSE/KHATA
                                                                                    No</label>
                                                                            </div>
                                                                            <div class="col-md-8">
                                                                                <input type="text"
                                                                                    class="form-control input-sm"
                                                                                    id="emp_plotnop" name="emp_plotnop"
                                                                                    placeholder="PLOT/HOUSE/KHATA No">
                                                                            </div>
                                                                        </div>
                                                                    </div>


                                                                    <div class="col-md-12" style="margin-top:6px;">
                                                                        <div class="row">
                                                                            <div class="col-md-4">
                                                                                <label for="emp_address"
                                                                                    style="margin-top:5px;">State</label>
                                                                            </div>
                                                                            <div class="col-md-8">
                                                                                <select class="form-control input-sm"
                                                                                    id="emp_statep" name="emp_statep">
                                                                                    <option value="">State</option>
                                                                                    <?php if ($state) { for ($i=0; $i < count($state); $i++) { ?>
                                                                                    <option
                                                                                        value="<?=$state[$i]['state_id'];?>">
                                                                                        <?=$state[$i]['state_title'];?>
                                                                                    </option>
                                                                                    <?php } } ?>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-12" style="margin-top:6px;">
                                                                        <div class="row">
                                                                            <div class="col-md-4">
                                                                                <label for="emp_address"
                                                                                    style="margin-top:5px;">District</label>
                                                                            </div>
                                                                            <div class="col-md-8">
                                                                                <select class="form-control input-sm"
                                                                                    id="emp_distp" name="emp_distp">
                                                                                    <option value="">District</option>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-12" style="margin-top:6px;">
                                                                        <div class="row">
                                                                            <div class="col-md-4">
                                                                                <label for="emp_curpin"
                                                                                    style="margin-top:5px;">Pin
                                                                                    Code</label>
                                                                            </div>
                                                                            <div class="col-md-8">
                                                                                <input type="number"
                                                                                    class="form-control input-sm"
                                                                                    id="emp_curpinp" name="emp_curpinp"
                                                                                    placeholder="Enter Pincode">
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                            <div class="col-md-6" style="padding:0;">
                                                                <div class="form-group">
                                                                    <div class="col-md-12">
                                                                        <div class="row">
                                                                            <div class="col-md-4">
                                                                                <label for="emp_address"
                                                                                    style="margin-top:5px;">AT</label>
                                                                            </div>
                                                                            <div class="col-md-8">
                                                                                <input type="text"
                                                                                    class="form-control input-sm"
                                                                                    id="emp_atp" name="emp_atp"
                                                                                    placeholder="Enter At">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-12" style="margin-top:6px;">
                                                                        <div class="row">
                                                                            <div class="col-md-4">
                                                                                <label for="emp_address"
                                                                                    style="margin-top:5px;">PO</label>
                                                                            </div>
                                                                            <div class="col-md-8">
                                                                                <input type="text"
                                                                                    class="form-control input-sm"
                                                                                    id="emp_pop" name="emp_pop"
                                                                                    placeholder="Enter PO">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-12" style="margin-top:6px;">
                                                                        <div class="row">
                                                                            <div class="col-md-4">
                                                                                <label for="emp_address"
                                                                                    style="margin-top:5px;">TALUKA/TAHSIL</label>
                                                                            </div>
                                                                            <div class="col-md-8">
                                                                                <input type="text"
                                                                                    class="form-control input-sm"
                                                                                    id="emp_tahsilp" name="emp_tahsilp"
                                                                                    placeholder="Enter Tahsil">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-12" style="margin-top:6px;">
                                                                        <div class="row">
                                                                            <div class="col-md-4">
                                                                                <label for="emp_curpin"
                                                                                    style="margin-top:5px;">Landmark</label>
                                                                            </div>
                                                                            <div class="col-md-8">
                                                                                <input type="text"
                                                                                    class="form-control input-sm"
                                                                                    id="emp_landmarkp"
                                                                                    name="emp_landmarkp"
                                                                                    placeholder="Enter Landmark">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>


                                                    </div>

                                                    <div class="col-md-12"
                                                        style="margin-top:15px;border:1px solid #ddd;padding:14px;border-radius:5px;">
                                                        <div class="icon icon-lg icon-shape"
                                                            style="margin-top:-25px!important;">
                                                            <span
                                                                style="background-color:white;width:100px;font-size:12px;padding:0 4px;">
                                                                Career Objectives (In Short)
                                                            </span>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <textarea class="form-control input-sm" id="cobj"
                                                                    name="cobj" rows="3" required
                                                                    placeholder="Enter Your Career Objectives"><?php echo set_value('cobj'); ?></textarea>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12"
                                                        style="margin-top:15px;border: 1px solid #ddd;padding: 14px;border-radius: 5px;">
                                                        <div class="icon icon-lg icon-shape"
                                                            style="margin-top: -25px!important;">
                                                            <span
                                                                style="background-color: white;width: 100px;font-size: 12px;padding-left: 4px;padding-right: 4px;">Login
                                                                Credentials </span>
                                                        </div>

                                                        <!-- Credential -->

                                                        <div class="row logindetails" style="padding: 0;">
                                                            <div class="col-md-4">
                                                                <div class="col-md-12" style="margin-top:5px;">
                                                                    <div class="row">
                                                                        <div class="col-md-4">
                                                                            <label for="emp_photo"
                                                                                style="margin-top:5px;">Username</label>
                                                                            <span style="color:red;">*</span>
                                                                        </div>
                                                                        <div class="col-md-8">
                                                                            <input type="text"
                                                                                class="form-control input-sm"
                                                                                maxlength="160" id="username"
                                                                                name="username" required
                                                                                value="<?php echo set_value("username");?>"
                                                                                placeholder="Enter Username" readonly>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="col-md-12" style="margin-top:5px;">
                                                                    <div class="row">
                                                                        <div class="col-md-4">
                                                                            <label for="emp_photo"
                                                                                style="margin-top:5px;">Password</label>
                                                                            <span style="color:red;">*</span>
                                                                        </div>
                                                                        <div class="col-md-8">
                                                                            <input type="password"
                                                                                class="form-control input-sm"
                                                                                id="password" name="password"
                                                                                value="<?php echo set_value("password");?>"
                                                                                required placeholder="Enter Password">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-4">
                                                                <div class="col-md-12" style="margin-top:5px;">
                                                                    <div class="row">
                                                                        <div class="col-md-4">
                                                                            <label for="emp_photo"
                                                                                style="margin-top:5px;">User
                                                                                Type</label>
                                                                        </div>
                                                                        <div class="col-md-8">
                                                                            <select class="form-control input-sm"
                                                                                id="usertype" name="usertype">
                                                                                <option value="Employee">Employee
                                                                                </option>
                                                                                <option value="Manager">Manager</option>

                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="col-md-12" style="margin-top:5px;">
                                                                    <div class="row">
                                                                        <div class="col-md-4">
                                                                            <label for="emp_photo"
                                                                                style="margin-top:5px;">User
                                                                                Access</label>
                                                                        </div>
                                                                        <div class="col-md-8">
                                                                            <select class="form-control input-sm"
                                                                                id="access_id" name="access_id">
                                                                                <option value=""></option>
                                                                                <?php if($access){ for($i=0;$i<count($access);$i++){?>
                                                                                <option
                                                                                    value="<?php echo $access[$i]['access_id'];?>">
                                                                                    <?php echo $access[$i]['access_name'];?>
                                                                                </option>
                                                                                <?php }} ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="col-md-12" style="margin-top:5px;">
                                                                    <div class="row">
                                                                        <div class="col-md-4">
                                                                            <label for="emp_photo"
                                                                                style="margin-top:5px;">User
                                                                                Status</label>
                                                                        </div>
                                                                        <div class="col-md-8">
                                                                            <select class="form-control input-sm"
                                                                                id="userstatus" name="userstatus">
                                                                                <option value="1">Active</option>
                                                                                <option value="0">Inactive</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="col-md-12" style="margin-top:5px;">
                                                                    <div class="row">
                                                                        <div class="col-md-4">
                                                                            <label for="location"
                                                                                style="margin-top:5px;">Location</label>
                                                                            <span style="color:red;">*</span>
                                                                        </div>
                                                                        <div class="col-md-8">
                                                                            <input type="text"
                                                                                class="form-control input-sm"
                                                                                maxlength="160" id="location"
                                                                                name="location" required
                                                                                value="<?php echo set_value("location");?>"
                                                                                placeholder="Enter ur Location">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- Credential -->
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-12"
                                                style="margin-top:15px;border: 1px solid #ddd;padding: 14px;border-radius: 5px;">
                                                <div class="icon icon-lg icon-shape"
                                                    style="margin-top: -25px!important;">
                                                    <span
                                                        style="background-color: white;width: 100px;font-size: 12px;padding-left: 4px;padding-right: 4px;">ID
                                                        Details</span>
                                                </div>
                                                <div class="">
                                                    <div class="col-md-6" style="padding:0;">
                                                        <div class="form-group">
                                                            <div class="col-md-12" style="margin-top:6px;">
                                                                <div class="row">
                                                                    <div class="col-md-4">
                                                                        <label for="emp_dl" style="margin-top:5px;">DL
                                                                            No.</label>
                                                                    </div>
                                                                    <div class="col-md-8">
                                                                        <input type="text" class="form-control input-sm"
                                                                            id="emp_dl" name="emp_dl"
                                                                            placeholder="Enter DL No.">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-12" style="margin-top:6px;">
                                                                <div class="row">
                                                                    <div class="col-md-4">
                                                                        <label for="emp_passport"
                                                                            style="margin-top:5px;">Passport No.</label>
                                                                    </div>
                                                                    <div class="col-md-8">
                                                                        <input type="text" class="form-control input-sm"
                                                                            id="emp_passport" name="emp_passport"
                                                                            placeholder="Enter Passport No.">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                    <div class="col-md-6" style="padding:0;">
                                                        <div class="form-group">
                                                            <div class="col-md-12" style="margin-top:6px;">
                                                                <div class="row">
                                                                    <div class="col-md-4">
                                                                        <label for="emp_voter"
                                                                            style="margin-top:5px;">Voter ID.</label>
                                                                    </div>
                                                                    <div class="col-md-8">
                                                                        <input type="text" class="form-control input-sm"
                                                                            id="emp_voter" name="emp_voter"
                                                                            placeholder="Enter Voter ID No.">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="col-md-12"
                                                style="margin-top:15px;border:1px solid #ddd;padding:14px;border-radius:5px;">
                                                <div class="icon icon-lg icon-shape"
                                                    style="margin-top:-25px!important;">
                                                    <span
                                                        style="background-color:white;width:100px;font-size:12px;padding:0 4px;">Edcational
                                                        Details</span>
                                                </div>
                                                <div class="col-md-12 p-0">
                                                    <h6><strong>From 10th to Highest Qualification</strong></h6>

                                                    <div id="educationContainer">

                                                        <div class="row edu-row mb-3 align-items-start">
                                                            <div class="col-md-1 text-center">
                                                                <strong class="edu-serial">1</strong>
                                                            </div>

                                                            <div class="col-md-10">
                                                                <div class="row">
                                                                    <div class="col-md-2">
                                                                        <select class="form-control input-sm"
                                                                            name="education_level[]">
                                                                            <option value="">Level</option>
                                                                            <option>10th</option>
                                                                            <option>12th</option>
                                                                            <option>Diploma</option>
                                                                            <option>Bachelors</option>
                                                                            <option>Masters</option>
                                                                        </select>
                                                                    </div>

                                                                    <div class="col-md-2">
                                                                        <input type="text" class="form-control input-sm"
                                                                            name="year[]" placeholder="Year">
                                                                    </div>

                                                                    <div class="col-md-2">
                                                                        <input type="text" class="form-control input-sm"
                                                                            name="board[]"
                                                                            placeholder="Board / University">
                                                                    </div>

                                                                    <div class="col-md-2">
                                                                        <input type="text" class="form-control input-sm"
                                                                            name="institute[]"
                                                                            placeholder="Institute Name">
                                                                    </div>

                                                                    <div class="col-md-2">
                                                                        <input type="text" class="form-control input-sm"
                                                                            name="qualification[]"
                                                                            placeholder="Qualification">
                                                                    </div>

                                                                    <div class="col-md-2">
                                                                        <input type="text" class="form-control input-sm"
                                                                            name="percentage[]" placeholder="% / Grade">
                                                                    </div>

                                                                    <div class="col-md-4 mt-2">
                                                                        <label class="mb-1">Upload Certificate</label>
                                                                        <input type="file" class="form-control"
                                                                            accept=".pdf,.jpg,.jpeg,.png">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-1 text-center">
                                                                <button type="button"
                                                                    class="btn btn-danger btn-xs removeRow"
                                                                    disabled>−</button>
                                                            </div>
                                                        </div>

                                                    </div>

                                                    <div class="text-right mt-2">
                                                        <button type="button" class="btn btn-success btn-xs"
                                                            id="addEduBtn">+ Add Education</button>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-12"
                                                style="margin-top:15px;border:1px solid #ddd;padding:14px;border-radius:5px;">
                                                <div class="icon icon-lg icon-shape"
                                                    style="margin-top:-25px!important;">
                                                    <span
                                                        style="background-color:white;width:100px;font-size:12px;padding:0 4px;">Experiences</span>
                                                </div>

                                                <div class="col-md-12 p-0">
                                                    <h6><strong>Present & Past</strong></h6>

                                                    <div id="experienceContainer">
                                                        <div class="row exp-row mb-2 align-items-center">
                                                            <div class="col-md-1 text-center">
                                                                <strong class="exp-serial">1</strong>
                                                            </div>

                                                            <div class="col-md-10">
                                                                <div class="row">
                                                                    <div class="col-md-2"><input type="text"
                                                                            class="form-control input-sm"
                                                                            name="employer[]" placeholder="Employer">
                                                                    </div>
                                                                    <div class="col-md-1">
                                                                        <input type="date" class="form-control input-sm"
                                                                            name="from_date[]" placeholder="From">
                                                                    </div>

                                                                    <div class="col-md-1">
                                                                        <input type="date" class="form-control input-sm"
                                                                            name="to_date[]" placeholder="To">
                                                                    </div>

                                                                    <div class="col-md-2"><input type="text"
                                                                            class="form-control input-sm"
                                                                            name="designation[]"
                                                                            placeholder="Designation"></div>
                                                                    <div class="col-md-2"><input type="text"
                                                                            class="form-control input-sm"
                                                                            name="salary[]"
                                                                            placeholder="Monthly Salary"></div>
                                                                    <div class="col-md-2"><input type="text"
                                                                            class="form-control input-sm"
                                                                            name="responsibilities[]"
                                                                            placeholder="Responsibilities"></div>
                                                                    <div class="col-md-2"><input type="text"
                                                                            class="form-control input-sm"
                                                                            name="reason[]"
                                                                            placeholder="Reason for Leaving"></div>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-1 text-center">
                                                                <button type="button"
                                                                    class="btn btn-danger btn-xs removeExpRow"
                                                                    disabled>−</button>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="text-right mt-2">
                                                        <button type="button" class="btn btn-success btn-xs"
                                                            id="addExpBtn">+ Add Experience</button>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-12"
                                                style="margin-top:15px;border:1px solid #ddd;padding:14px;border-radius:5px;">
                                                <div class="icon icon-lg icon-shape"
                                                    style="margin-top:-25px!important;">
                                                    <span
                                                        style="background-color:white;width:100px;font-size:12px;padding:0 4px;">References</span>
                                                </div>

                                                <div class="col-md-12 p-0">
                                                    <h6><strong>Professional References</strong></h6>

                                                    <div id="referenceContainer">
                                                        <div class="row ref-row mb-2 align-items-center">
                                                            <div class="col-md-1 text-center">
                                                                <strong class="ref-serial">1</strong>
                                                            </div>

                                                            <div class="col-md-10">
                                                                <div class="row">
                                                                    <div class="col-md-2"><input type="text"
                                                                            class="form-control input-sm"
                                                                            name="ref_name[]" placeholder="Name"></div>
                                                                    <div class="col-md-2"><input type="text"
                                                                            class="form-control input-sm"
                                                                            name="ref_relationship[]"
                                                                            placeholder="Relationship"></div>
                                                                    <div class="col-md-2"><input type="text"
                                                                            class="form-control input-sm"
                                                                            name="ref_organization[]"
                                                                            placeholder="Organization"></div>
                                                                    <div class="col-md-2"><input type="text"
                                                                            class="form-control input-sm"
                                                                            name="ref_phone[]" placeholder="Phone">
                                                                    </div>
                                                                    <div class="col-md-2"><input type="email"
                                                                            class="form-control input-sm"
                                                                            name="ref_email[]" placeholder="Email">
                                                                    </div>
                                                                    <div class="col-md-2"><input type="text"
                                                                            class="form-control input-sm"
                                                                            name="ref_years[]" placeholder="Years">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-1 text-center">
                                                                <button type="button"
                                                                    class="btn btn-danger btn-xs removeRefRow"
                                                                    disabled>−</button>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="text-right mt-2">
                                                        <button type="button" class="btn btn-success btn-xs"
                                                            id="addRefBtn">+ Add Reference</button>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-12"
                                                style="margin-top:15px;border:1px solid #ddd;padding:14px;border-radius:5px;">
                                                <div class="icon icon-lg icon-shape"
                                                    style="margin-top:-25px!important;">
                                                    <span
                                                        style="background-color:white;width:100px;font-size:12px;padding:0 4px;">Skills/Certifications</span>
                                                </div>

                                                <div class="col-md-12 p-0">

                                                    <div id="skillContainer">
                                                        <div class="row skill-row mb-2 align-items-center">
                                                            <div class="col-md-1 text-center">
                                                                <strong class="skill-serial">1</strong>
                                                            </div>

                                                            <div class="col-md-10">
                                                                <div class="row">
                                                                    <div class="col-md-4">
                                                                        <label for="skills">Skills</label><br>
                                                                        <input type="text" name="skills[]"
                                                                            placeholder="JavaScript, PHP, MySQL">
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <label for="certification">Certification
                                                                            Name</label><br>
                                                                        <input type="text" name="certification[]"
                                                                            placeholder="AWS Certified Developer">
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <label for="organization">Issuing
                                                                            Organization</label><br>
                                                                        <input type="text" name="organization[]"
                                                                            placeholder="Amazon Web Services">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-1 text-center">
                                                                <button type="button"
                                                                    class="btn btn-danger btn-xs removeSkillRow"
                                                                    disabled>−</button>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="text-right mt-2">
                                                        <button type="button" class="btn btn-success btn-xs"
                                                            id="addSkillBtn">+ Add Skills</button>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-12"
                                                style="margin-top:15px;border: 1px solid #ddd;padding: 14px;border-radius: 5px;">
                                                <div class="icon icon-lg icon-shape"
                                                    style="margin-top: -25px!important;">
                                                    <span
                                                        style="background-color: white;width: 100px;font-size: 12px;padding-left: 4px;padding-right: 4px;">Medical
                                                        & Insurance</span>
                                                </div>
                                                <div class="">
                                                    <div class="col-md-6" style="padding:0;">
                                                        <div class="form-group">
                                                            <div class="col-md-12" style="margin-top:6px;">
                                                                <div class="row">
                                                                    <div class="col-md-4">
                                                                        <label for="emp_medh"
                                                                            style="margin-top:5px;">Major Medical
                                                                            History (If Any) </label>
                                                                    </div>
                                                                    <div class="col-md-8">
                                                                        <textarea class="form-control input-sm"
                                                                            id="emp_medh" name="emp_medh"></textarea>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-12" style="margin-top:6px;">
                                                                <div class="row">
                                                                    <div class="col-md-4">
                                                                        <label for="allergy"
                                                                            style="margin-top:5px;">Allergies</label>
                                                                    </div>
                                                                    <div class="col-md-8">
                                                                        <input type="text" class="form-control input-sm"
                                                                            id="allergy" name="allergy"
                                                                            placeholder="Enter Allergies">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                    <div class="col-md-6" style="padding:0;">
                                                        <div class="form-group">
                                                            <div class="col-md-12" style="margin-top:6px;">
                                                                <div class="row">
                                                                    <div class="col-md-4">
                                                                        <label for="reg_med"
                                                                            style="margin-top:5px;">Regular
                                                                            Medications</label>
                                                                    </div>
                                                                    <div class="col-md-8">
                                                                        <input type="text" class="form-control input-sm"
                                                                            id="reg_med" name="reg_med"
                                                                            placeholder="Enter Regular Medications">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-12" style="margin-top:6px;">
                                                                <div class="row">
                                                                    <div class="col-md-4">
                                                                        <label for="emp_doc"
                                                                            style="margin-top:5px;">Family Doctor's
                                                                            Name</label>
                                                                    </div>
                                                                    <div class="col-md-8">
                                                                        <input type="text" class="form-control input-sm"
                                                                            id="emp_doc" name="emp_doc"
                                                                            placeholder="Enter Family Doctor's Name">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-12" style="margin-top:6px;">
                                                                <div class="row">
                                                                    <div class="col-md-4">
                                                                        <label for="doc_no"
                                                                            style="margin-top:5px;">Doctor's Contact
                                                                            No.</label>
                                                                    </div>
                                                                    <div class="col-md-8">
                                                                        <input type="tel" class="form-control input-sm"
                                                                            id="doc_no" name="doc_no"
                                                                            placeholder="Enter Family Doctor's Contact No.">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>

                                                    </div>

                                                </div>
                                            </div>
                                        </div>

                                        <div class="tab-pane" id="bankandkyc">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="col-md-12"
                                                                style="margin-top:15px;border: 1px solid #ddd;padding: 14px;border-radius: 5px;">
                                                                <div class="icon icon-lg icon-shape"
                                                                    style="margin-top: -25px!important;">
                                                                    <span
                                                                        style="background-color: white;width: 100px;font-size: 12px;padding-left: 4px;padding-right: 4px;">Salary
                                                                        Transfer Bank Details</span>
                                                                </div>
                                                                <div class="col-md-12" style="padding:0;">
                                                                    <div class="row">
                                                                        <div class="col-md-4">
                                                                            <label for="st_paymode"
                                                                                style="margin-top:5px;">Pay Mode</label>
                                                                        </div>
                                                                        <div class="col-md-8">
                                                                            <select class="form-control input-sm"
                                                                                id="st_paymode" name="st_paymode">
                                                                                <option value="Cash">Cash</option>
                                                                                <option value="Cheque">Cheque</option>
                                                                                <option value="Net Banking">E-payment
                                                                                </option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12"
                                                                    style="padding:0;margin-top:5px;">
                                                                    <div class="row">
                                                                        <div class="col-md-4">
                                                                            <label for="st_bankname"
                                                                                style="margin-top:5px;">Bank
                                                                                Name</label>
                                                                        </div>
                                                                        <div class="col-md-8">
                                                                            <input type="text"
                                                                                class="form-control input-sm"
                                                                                id="st_bankname" name="st_bankname"
                                                                                value="">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12"
                                                                    style="padding:0;margin-top:5px;">
                                                                    <div class="row">
                                                                        <div class="col-md-4">
                                                                            <label for="st_branch"
                                                                                style="margin-top:5px;">Branch
                                                                                Name</label>
                                                                        </div>
                                                                        <div class="col-md-8">
                                                                            <input type="text"
                                                                                class="form-control input-sm"
                                                                                id="st_branch" name="st_branch"
                                                                                value="">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12"
                                                                    style="padding:0;margin-top:5px;">
                                                                    <div class="row">
                                                                        <div class="col-md-4">
                                                                            <label for="st_acno"
                                                                                style="margin-top:5px;">Account
                                                                                Number</label>
                                                                        </div>
                                                                        <div class="col-md-8">
                                                                            <input type="text"
                                                                                class="form-control input-sm"
                                                                                id="st_acno" name="st_acno" value="">

                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12"
                                                                    style="padding:0;margin-top:5px;">
                                                                    <div class="row">
                                                                        <div class="col-md-4">
                                                                            <label for="st_acholdername"
                                                                                style="margin-top:5px;">Account Holder
                                                                                Name</label>
                                                                        </div>
                                                                        <div class="col-md-8">
                                                                            <input type="text"
                                                                                class="form-control input-sm"
                                                                                id="st_acholdername"
                                                                                name="st_acholdername" value="">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12"
                                                                    style="padding:0;margin-top:5px;">
                                                                    <div class="row">
                                                                        <div class="col-md-4">
                                                                            <label for="st_ifsc"
                                                                                style="margin-top:5px;">IFSC
                                                                                Code</label>
                                                                        </div>
                                                                        <div class="col-md-8">
                                                                            <input type="text"
                                                                                class="form-control input-sm"
                                                                                id="st_ifsc" name="st_ifsc" value="">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12"
                                                                    style="padding:0;margin-top:5px;">
                                                                    <div class="row">
                                                                        <div class="col-md-4">
                                                                            <label for="st_referenceno"
                                                                                style="margin-top:5px;">Reference
                                                                                No.</label>
                                                                        </div>
                                                                        <div class="col-md-8">
                                                                            <input type="text"
                                                                                class="form-control input-sm"
                                                                                id="st_referenceno"
                                                                                name="st_referenceno" value="">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12"
                                                                    style="padding:0;margin-top:5px;">
                                                                    <div class="row">
                                                                        <div class="col-md-4">
                                                                            <label for="emp_cheque">Upload
                                                                                Cheque</label>
                                                                        </div>
                                                                        <div class="col-md-8">
                                                                            <input type="file" name="emp_cheque"
                                                                                id="emp_cheque" class="form-control"
                                                                                accept=".pdf,.jpg,.jpeg,.png">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-12"
                                                                style="margin-top:5px;border: 1px solid #ddd;padding: 14px;border-radius: 5px;">
                                                                <div class="col-md-12" style="padding:0;">
                                                                    <div class="row">
                                                                        <div class="col-md-4">
                                                                            <label for="physicalchallenged"
                                                                                style="margin-top:5px;">Physically
                                                                                Challenged</label>
                                                                        </div>
                                                                        <div class="col-md-8">
                                                                            <select class="form-control input-sm"
                                                                                id="physicalchallenged"
                                                                                name="physicalchallenged">
                                                                                <option value="No">No</option>
                                                                                <option value="Yes">Yes</option>
                                                                            </select>

                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12"
                                                                    style="padding:0;margin-top:5px;">
                                                                    <div class="row">
                                                                        <div class="col-md-4">
                                                                            <label for="int_worker"
                                                                                style="margin-top:5px;">International
                                                                                Worker</label>
                                                                        </div>
                                                                        <div class="col-md-8">
                                                                            <select class="form-control input-sm"
                                                                                id="int_worker" name="int_worker">
                                                                                <option value="No">No</option>
                                                                                <option value="Yes">Yes</option>
                                                                            </select>

                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12"
                                                                    style="padding:0;margin-top:5px;">
                                                                    <div class="row">
                                                                        <div class="col-md-4">
                                                                            <label for="place_oforigin"
                                                                                style="margin-top:5px;">Place of
                                                                                Origin</label>
                                                                        </div>
                                                                        <div class="col-md-8">
                                                                            <input type="text"
                                                                                class="form-control input-sm"
                                                                                id="place_oforigin"
                                                                                name="place_oforigin" value="">
                                                                        </div>
                                                                    </div>
                                                                </div>


                                                            </div>

                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="col-md-12"
                                                                style="margin-top:15px;border: 1px solid #ddd;padding: 14px;border-radius: 5px;">
                                                                <div class="icon icon-lg icon-shape"
                                                                    style="margin-top: -25px!important;">
                                                                    <span
                                                                        style="background-color: white;width: 100px;font-size: 12px;padding-left: 4px;padding-right: 4px;">KYC
                                                                        Details</span>
                                                                </div>

                                                                <div class="col-md-12"
                                                                    style="padding:0;margin-top:5px;">
                                                                    <div class="row">
                                                                        <div class="col-md-4">
                                                                            <label for="kyc_panno"
                                                                                style="margin-top:5px;">Pan
                                                                                Number</label>
                                                                        </div>
                                                                        <div class="col-md-8">
                                                                            <input type="text"
                                                                                class="form-control input-sm"
                                                                                id="kyc_panno" name="kyc_panno"
                                                                                value="">

                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-12"
                                                                    style="padding:0;margin-top:5px;">
                                                                    <div class="row">
                                                                        <div class="col-md-4">
                                                                            <label style="margin-top:5px;">Upload
                                                                                PAN</label>
                                                                        </div>
                                                                        <div class="col-md-8">
                                                                            <input type="file" name="pancard"
                                                                                class="form-control input-sm" accept=".pdf,.jpg,.jpeg,.png">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12"
                                                                    style="padding:0;margin-top:5px;">
                                                                    <div class="row">
                                                                        <div class="col-md-4">
                                                                            <label for="kyc_panname"
                                                                                style="margin-top:5px;">Name as per Pan
                                                                            </label>
                                                                        </div>
                                                                        <div class="col-md-7">

                                                                            <input type="text"
                                                                                class="form-control input-sm"
                                                                                id="kyc_panname" name="kyc_panname"
                                                                                value="">
                                                                        </div>

                                                                        <div class="col-md-1">
                                                                            <input type="checkbox" id="asperpan">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12"
                                                                    style="padding:0;margin-top:5px;">
                                                                    <div class="row">
                                                                        <div class="col-md-4">
                                                                            <label for="kyc_adharno"
                                                                                style="margin-top:5px;">Aadhaar
                                                                                No.</label>
                                                                        </div>
                                                                        <div class="col-md-8">
                                                                            <input type="text"
                                                                                class="form-control input-sm"
                                                                                id="kyc_adharno" name="kyc_adharno"
                                                                                value="">

                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-12"
                                                                    style="padding:0;margin-top:5px;">
                                                                    <div class="row">
                                                                        <div class="col-md-4">
                                                                            <label style="margin-top:5px;">Upload
                                                                                Aadhaar</label>
                                                                        </div>
                                                                        <div class="col-md-8">
                                                                            <input type="file" name="aadharcard"
                                                                                class="form-control input-sm" accept=".pdf,.jpg,.jpeg,.png">
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-12"
                                                                    style="padding:0;margin-top:5px;">
                                                                    <div class="row">
                                                                        <div class="col-md-4">
                                                                            <label for="kyc_adharname"
                                                                                style="margin-top:5px;">Name as per
                                                                                Aadhaar</label>
                                                                        </div>
                                                                        <div class="col-md-7">
                                                                            <input type="text"
                                                                                class="form-control input-sm"
                                                                                id="kyc_adharname" name="kyc_adharname"
                                                                                value="">

                                                                        </div>
                                                                        <div class="col-md-1">
                                                                            <input type="checkbox" id="asperaadhar">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12"
                                                                    style="padding:0;margin-top:5px;">
                                                                    <div class="row">
                                                                        <div class="col-md-4">
                                                                            <label for="kyc_adharstate"
                                                                                style="margin-top:5px;">Aadhaar
                                                                                State</label>
                                                                        </div>
                                                                        <div class="col-md-8">
                                                                            <select class="form-control input-sm"
                                                                                id="kyc_adharstate"
                                                                                name="kyc_adharstate">
                                                                                <option value="">--Select State--
                                                                                </option>
                                                                                <?php if ($state) { for ($i=0; $i < count($state); $i++) { ?>
                                                                                <option
                                                                                    value="<?=$state[$i]['state_id'];?>">
                                                                                    <?=$state[$i]['state_title'];?>
                                                                                </option>
                                                                                <?php } } ?>
                                                                            </select>

                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-12"
                                                                    style="padding:0;margin-top:5px;">
                                                                    <div class="row">
                                                                        <div class="col-md-4">
                                                                            <label style="margin-top:5px;">Upload
                                                                                PVR</label>
                                                                        </div>
                                                                        <div class="col-md-8">
                                                                            <input type="file" name="pvr"
                                                                                class="form-control input-sm" accept=".pdf,.jpg,.jpeg,.png">
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="tab-pane" id="pfandesi">
                                            <div class="row">
                                                <div class="col-md-12"
                                                    style="margin-top:15px;border: 1px solid #ddd;padding: 14px;border-radius: 5px;">
                                                    <div class="row" style="padding:5px;">
                                                        <div class="col-md-6">
                                                            <div class="col-md-12">

                                                                <input type="hidden" class="form-control input-sm"
                                                                    id="employee_id" name="employee_id" value="">

                                                                <div class="col-md-12"
                                                                    style="padding:0;margin-top:5px;">
                                                                    <div class="row">
                                                                        <div class="col-md-4">
                                                                            <label for="pf_number"
                                                                                style="margin-top:5px;">Have Any PF
                                                                                No.</label>
                                                                        </div>
                                                                        <div class="col-md-8">
                                                                            <input type="radio" name="emp_ispf"
                                                                                value="1"> Yes
                                                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                            <input type="radio" name="emp_ispf"
                                                                                value="0" checked> No
                                                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-12"
                                                                    style="padding:0;margin-top:5px;">
                                                                    <div class="row">
                                                                        <div class="col-md-4">
                                                                            <label for="pf_number"
                                                                                style="margin-top:5px;">PF
                                                                                Number</label>
                                                                        </div>
                                                                        <div class="col-md-8">
                                                                            <input type="text"
                                                                                class="form-control input-sm"
                                                                                id="pf_number" name="pf_number" value=""
                                                                                placeholder="Enter PF No.">
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-12"
                                                                    style="padding:0;margin-top:5px;">
                                                                    <div class="row">
                                                                        <div class="col-md-4">
                                                                            <label for="pf_number"
                                                                                style="margin-top:5px;">PMJJY</label>
                                                                        </div>
                                                                        <div class="col-md-8">
                                                                            <input type="radio" name="emp_ispmjjy"
                                                                                value="1"> Yes
                                                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                            <input type="radio" name="emp_ispmjjy"
                                                                                value="0" checked> No
                                                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            </div>



                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="col-md-12">
                                                                <div class="col-md-12"
                                                                    style="padding:0;margin-top:5px;">
                                                                    <div class="row">
                                                                        <div class="col-md-4">
                                                                            <label for="pf_number"
                                                                                style="margin-top:5px;">Have Any ESI
                                                                                No.</label>
                                                                        </div>
                                                                        <div class="col-md-8">
                                                                            <input type="radio" name="emp_isesi"
                                                                                value="1"> Yes
                                                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                            <input type="radio" name="emp_isesi"
                                                                                value="0" checked> No
                                                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12"
                                                                    style="padding:0;margin-top:5px;">
                                                                    <div class="row">
                                                                        <div class="col-md-4">
                                                                            <label for="kyc_acholdername"
                                                                                style="margin-top:5px;">ESI
                                                                                Number</label>
                                                                        </div>
                                                                        <div class="col-md-8">
                                                                            <input type="text"
                                                                                class="form-control input-sm"
                                                                                id="esi_number" name="esi_number"
                                                                                value="" placeholder="Enter ESI No.">
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-12"
                                                                    style="padding:0;margin-top:5px;">
                                                                    <div class="row">
                                                                        <div class="col-md-4">
                                                                            <label for="pf_number"
                                                                                style="margin-top:5px;">PMSVY</label>
                                                                        </div>
                                                                        <div class="col-md-8">
                                                                            <input type="radio" name="emp_ispmsvy"
                                                                                value="1"> Yes
                                                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                            <input type="radio" name="emp_ispmsvy"
                                                                                value="0" checked> No
                                                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>


                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="salarystructure">
                                            <div class="row">
                                                <input type="hidden" name="month_day" id="month_day" value="0">

                                            </div>
                                            <div class="row">
                                                <div class="form-group col-md-2">
                                                    <label for="esi">CTC Type</label>
                                                    <select name="ctc_type" id="ctc_type"
                                                        class="form-control input-sm calc_amt">
                                                        <option value="1">Day Basic</option>
                                                        <option value="2">Hourly Basic</option>
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-2" style="display:none;">
                                                    <label for="esi">CTC Calculation Type</label>
                                                    <select name="basic_cat" id="basic_cat"
                                                        class="form-control input-sm calc_amt">
                                                        <option value="1">PF Only</option>
                                                        <option value="2">PF & ESI</option>
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-2" style="display:none;">
                                                    <label for="bonuspercent">Bonus in ( % )</label>
                                                    <input type="number" name="bonuspercent" id="bonuspercent" value="0"
                                                        class="form-control input-sm calc_amt" readonly>
                                                </div>
                                                <div class="form-group col-md-2">
                                                    <label for="salaryvalue">CTC Value</label>
                                                    <input type="number" name="salaryvalue" id="salaryvalue" value="0"
                                                        class="form-control input-sm calc_amt" step="0.01">
                                                </div>
                                                <div class="form-group col-md-2" style="display:none;">
                                                    <label for="employerpfperc">Employer PF ( in % )</label>
                                                    <input type="number" name="employerpfperc" id="employerpfperc"
                                                        value="0" class="form-control input-sm calc_amt" step="0.01">
                                                </div>
                                                <div class="form-group col-md-2" style="display:none;">
                                                    <label for="employeresiperc">Employer ESI ( in % )</label>
                                                    <input type="number" name="employeresiperc" id="employeresiperc"
                                                        value="0" class="form-control input-sm calc_amt" step="0.01">
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <label for="grosssalary">Gross Salary</label>
                                                    <input type="number" name="grosssalary" id="grosssalary" value="0"
                                                        class="form-control input-sm calc_amt" step="0.01" readonly>
                                                </div>
                                            </div>





                                            <br>
                                            <table class="table" cellpadding="0" border="0">
                                                <tr style="background-color:#f2fce3;">
                                                    <th width="10%">Sl No</th>
                                                    <th width="45%">Wages Head</th>
                                                    <th width="15%" class="text-center">Per Month</th>
                                                    <th width="15%" class="text-center">Per Annum</th>
                                                    <th width="15%" class="text-center">Per Day</th>
                                                </tr>

                                                <?php $wages = $this->Common_Model->FetchData("wages","*","1 order by sequence ASC"); 
                                    if ($wages) { for ($i=0; $i <count($wages) ; $i++) { ?>
                                                <tr style="border:hidden;">
                                                    <td width="10%"><?=($i + 1);?></td>
                                                    <td width="44%"><?=$wages[$i]['wages_name'];?>
                                                        <input type="hidden" class="form-control input-sm wages_id"
                                                            name="wages_id[]" value="<?=$wages[$i]['wages_id'];?>">
                                                        <input type="hidden" class="form-control input-sm"
                                                            name="wages_name[]" value="<?=$wages[$i]['wages_name'];?>">
                                                    </td>
                                                    <td width="15%">
                                                        <input type="number"
                                                            class="form-control input-sm calc_amt permonth "
                                                            name="permonth[]" step="0.01" id="permonth" value="0.00"
                                                            readonly>
                                                    </td>
                                                    <td width="15%" class="text-center">
                                                        <input type="number"
                                                            class="form-control input-sm calc_amt perannum "
                                                            name="perannum[]" step="0.01" id="perannum" value="0.00"
                                                            readonly>

                                                    </td>
                                                    <td width="15%" class="text-center">
                                                        <input type="number"
                                                            class="form-control input-sm calc_amt perday "
                                                            name="perday[]" step="0.01" id="perday" value="0.00"
                                                            readonly>
                                                    </td>
                                                </tr>
                                                <?php }} ?>
                                                <tr style="border:hidden;">

                                                    <td width="54%" colspan="2" style="text-align:right;">
                                                        <b>Total Deduction</b>
                                                    </td>
                                                    <td width="15%">
                                                        <input type="number"
                                                            class="form-control input-sm calc_amt totdedpermonth "
                                                            name="totdedpermonth" step="0.01" id="totdedpermonth"
                                                            value="0.00" readonly>
                                                    </td>
                                                    <td width="15%" class="text-center">
                                                        <input type="number"
                                                            class="form-control input-sm calc_amt totdedperannum "
                                                            name="totdedperannum" step="0.01" id="totdedperannum"
                                                            value="0.00" readonly>

                                                    </td>
                                                    <td width="15%" class="text-center">
                                                        <input type="number"
                                                            class="form-control input-sm calc_amt totdedperday "
                                                            name="totdedperday" step="0.01" id="totdedperday"
                                                            value="0.00" readonly>
                                                    </td>
                                                </tr>
                                                <tr style="border:hidden;">

                                                    <td width="54%" colspan="2" style="text-align:right;">
                                                        <b>Net Salary</b>
                                                    </td>
                                                    <td width="15%">
                                                        <input type="number"
                                                            class="form-control input-sm calc_amt netsalpermonth "
                                                            name="netsalpermonth" step="0.01" id="netsalpermonth"
                                                            value="0.00" readonly>
                                                    </td>
                                                    <td width="15%" class="text-center">
                                                        <input type="number"
                                                            class="form-control input-sm calc_amt netsalperannum "
                                                            name="netsalperannum" step="0.01" id="netsalperannum"
                                                            value="0.00" readonly>

                                                    </td>
                                                    <td width="15%" class="text-center">
                                                        <input type="number"
                                                            class="form-control input-sm calc_amt netsalperday "
                                                            name="netsalperday" step="0.01" id="netsalperday"
                                                            value="0.00" readonly>
                                                    </td>
                                                </tr>
                                            </table>

                                        </div>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
                <div class="box-footer">
                    <button type="submit" name="submitBtn" value="submit" class="btn btn-primary">Submit</button>
                    <button type="reset" name="resetBtn" class="btn btn-default">Reset</button>
                </div>
                </form>
            </div>
    </div>
</div>
</section>
</div>
<?php $this->load->view("common/footer");?>
</div>
<?php $this->load->view("common/script");?>

<script type="text/javascript">
$('#sameaddress').click(function() {
    if ($(this).prop("checked") == true) {
        let emp_plotno = $('#emp_plotno').val();

        let emp_state = $('#emp_state').prop('outerHTML');
        let emp_statesel = $('#emp_state').val();
        let emp_dist = $('#emp_dist').prop('outerHTML');
        let emp_distsel = $('#emp_dist').val();
        let emp_curpin = $('#emp_curpin').val();
        let emp_at = $('#emp_at').val();
        let emp_po = $('#emp_po').val();
        let emp_tahsil = $('#emp_tahsil').val();
        let emp_landmark = $('#emp_landmark').val();

        $('#emp_plotnop').val(emp_plotno);
        $('#emp_statep').html(emp_state);
        $('#emp_statep').val(emp_statesel);
        $('#emp_distp').html(emp_dist);
        $('#emp_distp').val(emp_distsel);
        $('#emp_curpinp').val(emp_curpin);
        $('#emp_atp').val(emp_at);
        $('#emp_pop').val(emp_po);
        $('#emp_tahsilp').val(emp_tahsil);
        $('#emp_landmarkp').val(emp_landmark);

    } else if ($(this).prop("checked") == false) {
        $('#emp_plotnop').val('');
        $('#emp_statep').html('');
        $('#emp_distp').html('');
        $('#emp_curpinp').val('');
        $('#emp_atp').val('');
        $('#emp_pop').val('');
        $('#emp_tahsilp').val('');
        $('#emp_landmarkp').val('');
    }
});

$(document).on('change', '#emp_state', function() {
    var state_id = $(this).val();

    if (state_id != '') {
        $.ajax({
            url: '<?=site_url("masters/get_distByState");?>',
            data: {
                state_id: state_id
            },
            dataType: "HTML",
            type: "POST",
            success: function(data) {

                $("#emp_dist").html(data);

            }
        });
    }
});

$(document).on('change', '#emp_statep', function() {
    var state_id = $(this).val();

    if (state_id != '') {
        $.ajax({
            url: '<?=site_url("masters/get_distByState");?>',
            data: {
                state_id: state_id
            },
            dataType: "HTML",
            type: "POST",
            success: function(data) {

                $("#emp_distp").html(data);

            }
        });
    }
});

$('#asperpan').click(function() {
    if ($(this).prop("checked") == true) {
        let st_acholdername = $('#st_acholdername').val();

        $('#kyc_panname').val(st_acholdername);

    } else if ($(this).prop("checked") == false) {
        $('#kyc_panname').val('');

    }
});

$('#asperaadhar').click(function() {
    if ($(this).prop("checked") == true) {
        let st_acholdername = $('#st_acholdername').val();

        $('#kyc_adharname').val(st_acholdername);

    } else if ($(this).prop("checked") == false) {
        $('#kyc_adharname').val('');

    }
});


$(document).on('change', '#emp_department', function() {
    var department_id = $(this).val();

    if (department_id != '') {
        $.ajax({
            url: '<?=site_url("employee/get_designationByDept");?>',
            data: {
                department_id: department_id
            },
            dataType: "HTML",
            type: "POST",
            success: function(data) {

                $("#emp_designation").html(data);

            }
        });
    }

});



/*$(document).on("change keyup",".calc_amt",function(){
         var obj = $(this).closest("tr");
         let wgs_amt =  parseFloat(obj.find(".amount").val());
         
         if (obj.find(".pf").val()=='Yes') {
                 obj.find(".pfamount").val(wgs_amt.toFixed(0));
         }else{
             obj.find(".pfamount").val(0);
         }

         if (obj.find(".esi").val()=='Yes') {
                 obj.find(".esiamount").val(wgs_amt.toFixed(0));
         }else{
             obj.find(".esiamount").val(0);
         }

     calculate();
     });*/

$(document).on("change keyup", ".deduction_amt", function() {
    calculate();
});



$(document).on('keyup change', '.calc_amt', function() {
    calculate();
});

function calculate() {
    var salval = parseFloat($("#salaryvalue").val());
    var pfperc = parseFloat($("#employerpfperc").val());
    var esiperc = parseFloat($("#employeresiperc").val());
    var basic_cat = $("#basic_cat").val();
    var bonuspercent = parseFloat($("#bonuspercent").val());
    var ctc_type = $("#ctc_type").val();

    var limitamt = 22942.50;

    if (ctc_type == 2) {
        var gross_sal = (salval).toFixed(2);
        $("#grosssalary").val(gross_sal);

        var fn2 = $(".wages_id");
        var gn2 = 0;
        var wasethree = 0;
        var pfemp = 0;
        var totalded = 0;
        for (var i = 0; i < fn2.length; i++) {
            var obj = $(fn2[i]).closest("tr");
            var waseid = obj.find(".wages_id").val();
            if (waseid == '1') {
                var perday = parseFloat((gross_sal * 1).toFixed(2));
                var permonth = parseFloat((gross_sal * 12).toFixed(2));
                var perannum = parseFloat((permonth * 12).toFixed(2));

                wasethree = wasethree + permonth;
                obj.find(".permonth").val(permonth);
                obj.find(".perannum").val(perannum);
                obj.find(".perday").val(perday);


            } else {
                obj.find(".permonth").val(0);
                obj.find(".perannum").val(0);
                obj.find(".perday").val(0);
            }
        }

        $("#totdedpermonth").val(totalded.toFixed(2));
        var totdedannum = 0;
        var totdedday = 0;
        $("#totdedperannum").val(totdedannum);
        $("#totdedperday").val(totdedday);

        var netsalary = parseFloat((gross_sal - totalded).toFixed(2));
        var netsalaryparmonth = parseFloat((netsalary * 12).toFixed(2));
        var netsalaryperanum = parseFloat((netsalaryparmonth * 12).toFixed(2));

        $("#netsalpermonth").val(netsalaryparmonth);
        $("#netsalperannum").val(netsalaryperanum);
        $("#netsalperday").val(netsalary);


    } else {

        if (salval > limitamt) {
            var pfd = ((salval * 6) / 106).toFixed(2);
            if (pfd >= 1800) {
                var pff = 1800;
            } else {
                var pff = pfd;
            }
            var gross_sal = (salval - pff).toFixed(2);
            $("#grosssalary").val(gross_sal);
            var fn2 = $(".wages_id");
            var gn2 = 0;
            var wasethree = 0;
            var pfemp = 0;
            var totalded = 0;
            for (var i = 0; i < fn2.length; i++) {
                var obj = $(fn2[i]).closest("tr");
                var waseid = obj.find(".wages_id").val();
                if (waseid == '1') {
                    var permonth = parseFloat((gross_sal * 0.50).toFixed(2));
                    var perannum = parseFloat((permonth * 12).toFixed(2));
                    var perday = parseFloat((perannum / 365).toFixed(2));
                    pfd = (permonth * 0.12).toFixed(2);
                    if (pfd >= 1800) {
                        var pfemp = 1800;
                    } else {
                        var pfemp = pfd;
                    }

                    wasethree = wasethree + permonth;
                    obj.find(".permonth").val(permonth);
                    obj.find(".perannum").val(perannum);
                    obj.find(".perday").val(perday);


                } else if (waseid == '2') {
                    var permonth = parseFloat((gross_sal * 0.25).toFixed(2));
                    var perannum = parseFloat((permonth * 12).toFixed(2));
                    var perday = parseFloat((perannum / 365).toFixed(2));
                    wasethree = wasethree + permonth;
                    obj.find(".permonth").val(permonth);
                    obj.find(".perannum").val(perannum);
                    obj.find(".perday").val(perday);

                } else if (waseid == '4') {
                    var permonth = parseFloat((gross_sal * 0.25).toFixed(2));
                    var perannum = parseFloat((permonth * 12).toFixed(2));
                    var perday = parseFloat((perannum / 365).toFixed(2));
                    obj.find(".permonth").val(permonth);
                    obj.find(".perannum").val(perannum);
                    obj.find(".perday").val(perday);

                } else if (waseid == '5') {
                    var permonth = pfemp;
                    var perannum = parseFloat((permonth * 12).toFixed(2));
                    var perday = parseFloat((perannum / 365).toFixed(2));
                    obj.find(".permonth").val(permonth);
                    obj.find(".perannum").val(perannum);
                    obj.find(".perday").val(perday);
                    totalded = parseFloat(totalded + permonth);
                } else if (waseid == '6') {
                    var permonth = 0;
                    obj.find(".permonth").val(0);
                    obj.find(".perannum").val(0);
                    obj.find(".perday").val(0);
                } else if (waseid == '7') {
                    var permonth = 200;
                    var perannum = parseFloat((permonth * 12).toFixed(2));
                    var perday = parseFloat((perannum / 365).toFixed(2));
                    obj.find(".permonth").val(permonth);
                    obj.find(".perannum").val(perannum);
                    obj.find(".perday").val(perday);
                    totalded = parseFloat(totalded + permonth);
                } else if (waseid == '8') {
                    var permonth = parseFloat((gross_sal * 0.015).toFixed(2));
                    var perannum = parseFloat((permonth * 12).toFixed(2));
                    var perday = parseFloat((perannum / 365).toFixed(2));
                    obj.find(".permonth").val(permonth);
                    obj.find(".perannum").val(perannum);
                    obj.find(".perday").val(perday);
                    totalded = parseFloat(totalded + permonth);
                } else if (waseid == '3') {
                    var permonth = 0;
                    obj.find(".permonth").val(0);
                    obj.find(".perannum").val(0);
                    obj.find(".perday").val(0);

                }


            }
            $("#totdedpermonth").val(totalded.toFixed(2));
            var totdedannum = parseFloat((totalded * 12).toFixed(2));
            var totdedday = parseFloat((totdedannum / 365).toFixed(2));
            $("#totdedperannum").val(totdedannum);
            $("#totdedperday").val(totdedday);

            var netsalary = parseFloat((gross_sal - totalded).toFixed(2));
            var netsalaryparmonth = parseFloat((netsalary * 12).toFixed(2));
            var netsalaryperday = parseFloat((netsalaryparmonth / 365).toFixed(2));

            $("#netsalpermonth").val(netsalary);
            $("#netsalperannum").val(netsalaryparmonth);
            $("#netsalperday").val(netsalaryperday);




        } else {
            var gross_sal = (salval - ((salval * 9.25) / 109.25)).toFixed(2);
            $("#grosssalary").val(gross_sal);
            var fn2 = $(".wages_id");
            var gn2 = 0;
            var wasethree = 0;
            var pfemp = 0;
            var totalded = 0;
            for (var i = 0; i < fn2.length; i++) {
                var obj = $(fn2[i]).closest("tr");
                var waseid = obj.find(".wages_id").val();

                if (waseid == '1') {
                    var permonth = parseFloat((gross_sal * 0.50).toFixed(2));
                    var perannum = parseFloat((permonth * 12).toFixed(2));
                    var perday = parseFloat((perannum / 365).toFixed(2));
                    pfd = (permonth * 0.12).toFixed(2);
                    if (pfd >= 1800) {
                        var pfemp = 1800;
                    } else {
                        var pfemp = pfd;
                    }
                    wasethree = wasethree + permonth;
                    obj.find(".permonth").val(permonth);
                    obj.find(".perannum").val(perannum);
                    obj.find(".perday").val(perday);


                } else if (waseid == '2') {
                    var permonth = parseFloat((permonth * 0.50).toFixed(2));
                    var perannum = parseFloat((permonth * 12).toFixed(2));
                    var perday = parseFloat((perannum / 365).toFixed(2));
                    wasethree = wasethree + permonth;
                    obj.find(".permonth").val(permonth);
                    obj.find(".perannum").val(perannum);
                    obj.find(".perday").val(perday);

                } else if (waseid == '3') {
                    var permonth = 1600;
                    var perannum = parseFloat((permonth * 12).toFixed(2));
                    var perday = parseFloat((perannum / 365).toFixed(2));
                    wasethree = wasethree + permonth;
                    obj.find(".permonth").val(1600);
                    obj.find(".perannum").val(perannum);
                    obj.find(".perday").val(perday);

                } else if (waseid == '4') {
                    var permonth = parseFloat((gross_sal - wasethree).toFixed(2));
                    var perannum = parseFloat((permonth * 12).toFixed(2));
                    var perday = parseFloat((perannum / 365).toFixed(2));
                    obj.find(".permonth").val(permonth);
                    obj.find(".perannum").val(perannum);
                    obj.find(".perday").val(perday);

                } else if (waseid == '5') {
                    var permonth = pfemp;
                    var perannum = parseFloat((permonth * 12).toFixed(2));
                    var perday = parseFloat((perannum / 365).toFixed(2));
                    obj.find(".permonth").val(permonth);
                    obj.find(".perannum").val(perannum);
                    obj.find(".perday").val(perday);
                    totalded = parseFloat(totalded + permonth);
                } else if (waseid == '6') {
                    var permonth = parseFloat((gross_sal * 0.0075).toFixed(2));
                    var perannum = parseFloat((permonth * 12).toFixed(2));
                    var perday = parseFloat((perannum / 365).toFixed(2));
                    obj.find(".permonth").val(permonth);
                    obj.find(".perannum").val(perannum);
                    obj.find(".perday").val(perday);
                    totalded = parseFloat(totalded + permonth);
                } else if (waseid == '7') {
                    var permonth = 200;
                    var perannum = parseFloat((permonth * 12).toFixed(2));
                    var perday = parseFloat((perannum / 365).toFixed(2));
                    obj.find(".permonth").val(permonth);
                    obj.find(".perannum").val(perannum);
                    obj.find(".perday").val(perday);
                    totalded = parseFloat(totalded + permonth);
                } else if (waseid == '8') {
                    var permonth = parseFloat((gross_sal * 0.015).toFixed(2));
                    var perannum = parseFloat((permonth * 12).toFixed(2));
                    var perday = parseFloat((perannum / 365).toFixed(2));
                    obj.find(".permonth").val(permonth);
                    obj.find(".perannum").val(perannum);
                    obj.find(".perday").val(perday);
                    totalded = parseFloat(totalded + permonth);
                }


            }
            $("#totdedpermonth").val(totalded.toFixed(2));
            var totdedannum = parseFloat((totalded * 12).toFixed(2));
            var totdedday = parseFloat((totdedannum / 365).toFixed(2));
            $("#totdedperannum").val(totdedannum);
            $("#totdedperday").val(totdedday);

            var netsalary = parseFloat((gross_sal - totalded).toFixed(2));
            var netsalaryparmonth = parseFloat((netsalary * 12).toFixed(2));
            var netsalaryperday = parseFloat((netsalaryparmonth / 365).toFixed(2));

            $("#netsalpermonth").val(netsalary);
            $("#netsalperannum").val(netsalaryparmonth);
            $("#netsalperday").val(netsalaryperday);

        }
    }


}

$(document).on('click', '.forh', function() {
    var emp_maritalstatus = $("input[name=emp_maritalstatus]:checked").val();
    var emp_gender = $("input[name=emp_gender]:checked").val();
    if (emp_maritalstatus == 'Yes' && emp_gender == 'Female') {
        $("#forhnm").html("Hus.'s Name");
    } else {
        $("#forhnm").html("Father's Name");
    }
});

$(function() {
    function updatePassword() {
        // Get the date of birth and split it by hyphen
        var birthdate = $("#emp_dob").val().split('-');
        // Get the values of first name, middle name, and last name
        var fname = $("#emp_firstname").val();
        var lname = $("#emp_lastname").val();
        var mname = $("#emp_middlename").val();
        // Construct the employee ID
        var empId = fname.charAt(0) + mname.charAt(0) + lname.charAt(0) + '' + birthdate.join('');
        // Set the generated employee ID as the value of the password field
        $("#password").val(empId);
    }

    // Bind both keyup and change events to the updatePassword function
    $("#emp_firstname,#emp_middlename,#emp_lastname,#emp_dob").on('keyup change', updatePassword);
});

$(function() {
    $("#emp_mobile").keyup(function() {
        var emp_mobile = $("#emp_mobile").val();
        $("#username").val(emp_mobile);
    });
});

document.getElementById('emp_dob').addEventListener('change', function() {
    const dob = new Date(this.value);
    const today = new Date();

    let age = today.getFullYear() - dob.getFullYear();
    const monthDiff = today.getMonth() - dob.getMonth();

    // Adjust if birthday not yet occurred this year
    if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < dob.getDate())) {
        age--;
    }

    if (!isNaN(age) && age >= 0) {
        document.getElementById('emp_age').value = age;
    } else {
        document.getElementById('emp_age').value = '';
    }
});

let eduIndex = 1;
/* ---------- EDUCATION ---------- */

function updateEduSerials() {
    $('.edu-row').each(function(i) {
        $(this).find('.edu-serial').text(i + 1);
    });
}

function updateFileIndexes() {
    $('.edu-row').each(function(i) {
        $(this).find('input[type=file]').attr('name', 'emp_cert[' + i + ']');
    });
}

function toggleEduRemoveButtons() {
    $('.removeRow').prop('disabled', $('.edu-row').length === 1);
}

$('#addEduBtn').on('click', function() {

    let row = $('.edu-row:first').clone();

    row.find('input[type=text], select').val('');
    row.find('.removeRow').prop('disabled', false);

    row.find('input[type=file]').replaceWith(
        '<input type="file" class="form-control" accept=".pdf,.jpg,.jpeg,.png">'
    );

    $('#educationContainer').append(row);

    updateEduSerials();
    updateFileIndexes();
    toggleEduRemoveButtons();
});

$(document).on('click', '.removeRow', function() {
    $(this).closest('.edu-row').remove();
    updateEduSerials();
    updateFileIndexes();
    toggleEduRemoveButtons();
});


/* ---------- EXPERIENCE ---------- */
function updateExpSerials() {
    $('.exp-row').each(function(i) {
        $(this).find('.exp-serial').text(i + 1);
    });
}

$('#addExpBtn').on('click', function() {
    let row = $('.exp-row:first').clone();
    row.find('input').val('');
    row.find('.removeExpRow').prop('disabled', false);
    $('#experienceContainer').append(row);
    toggleExpRemoveButtons();
    updateExpSerials();
});

$(document).on('click', '.removeExpRow', function() {
    $(this).closest('.exp-row').remove();
    toggleExpRemoveButtons();
    updateExpSerials();
});

function toggleExpRemoveButtons() {
    $('.removeExpRow').prop('disabled', $('.exp-row').length === 1);
}

/* ---------- REFERENCES ---------- */
function updateRefSerials() {
    $('.ref-row').each(function(i) {
        $(this).find('.ref-serial').text(i + 1);
    });
}

$('#addRefBtn').on('click', function() {
    let row = $('.ref-row:first').clone();
    row.find('input').val('');
    row.find('.removeRefRow').prop('disabled', false);
    $('#referenceContainer').append(row);
    toggleRefRemoveButtons();
    updateRefSerials();
});

$(document).on('click', '.removeRefRow', function() {
    $(this).closest('.ref-row').remove();
    toggleRefRemoveButtons();
    updateRefSerials();
});

function toggleRefRemoveButtons() {
    $('.removeRefRow').prop('disabled', $('.ref-row').length === 1);
}

/* ---------- Skills ---------- */
function updateSkillSerials() {
    $('.skill-row').each(function(i) {
        $(this).find('.skill-serial').text(i + 1);
    });
}

$('#addSkillBtn').on('click', function() {
    let row = $('.skill-row:first').clone();
    row.find('input').val('');
    row.find('.removeSkillRow').prop('disabled', false);
    $('#skillContainer').append(row);
    toggleSkillRemoveButtons();
    updateSkillSerials();
});

$(document).on('click', '.removeSkillRow', function() {
    $(this).closest('.skill-row').remove();
    toggleSkillRemoveButtons();
    updateSkillSerials();
});

function toggleSkillRemoveButtons() {
    $('.removeSkillRow').prop('disabled', $('.skill-row').length === 1);
}
</script>
</body>

</html>