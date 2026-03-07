<?php $this->load->view("common/meta");?>
<div class="wrapper">

    <?php $this->load->view("common/sidebar");?>

    <div class="content-wrapper">
        <section class="content-header">
            <h1>
                Employees
            </h1>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">Edit Employee</h3>
                        </div>
                        <form role="form"
                            action="<?php echo site_url("employee/editemployee/".$employee[0]['employee_id']);?>"
                            method="post" enctype="multipart/form-data">
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

                                    <div class="col-md-12"
                                        style="margin-top:15px;border : 1px solid #ddd;padding: 15px;">
                                        <div class="icon icon-lg icon-shape" style="margin-top: -28px!important;">
                                            <span
                                                style="background-color: white;width: 100px;font-size: 12px;padding-left: 4px;padding-right: 4px;">Personal
                                                & Contact</span>
                                        </div>
                                        <div class="col-md-4" style="padding:0;">
                                            <div class="form-group">
                                                <div class="col-md-12">
                                                    <div class="row">
                                                        <div class="col-md-4" style="padding:0;">
                                                            <label for="emp_firstname" style="margin-top:5px;">Employee
                                                                Id</label>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <input type="text" class="form-control input-sm"
                                                                id="techno_emp_id" name="techno_emp_id"
                                                                value="<?=$employee[0]['techno_emp_id'];?>" readonly>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12" style="margin-top:5px;">
                                                    <div class="row">
                                                        <div class="col-md-4" style="padding:0;">
                                                            <label for="emp_firstname" style="margin-top:5px;">First
                                                                name</label><span style="color:red;">*</span>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <input type="text" class="form-control input-sm"
                                                                id="emp_firstname" name="emp_firstname"
                                                                value="<?php echo $employee[0]['emp_firstname'];?>"
                                                                placeholder="Enter First Name" required="required">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-12" style="margin-top:5px;">
                                                    <div class="row">
                                                        <div class="col-md-4" style="padding:0;">
                                                            <label for="emp_firstname" style="margin-top:5px;">Nick
                                                                name</label>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <input type="text" class="form-control input-sm"
                                                                id="emp_nickname" name="emp_nickname"
                                                                value="<?php echo $employee[0]['emp_nickname'];?>"
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
                                                            <select class="form-control input-sm" id="emp_status"
                                                                name="emp_status" required="required">
                                                                <option value="Active"
                                                                    <?=$employee[0]['emp_status']=='Active'?'selected':'';?>>
                                                                    Active</option>
                                                                <option value="Inactive"
                                                                    <?=$employee[0]['emp_status']=='Inactive'?'selected':'';?>>
                                                                    Inactive</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-2" style="padding:0;">
                                                            <label>Gender</label>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <input type="radio" name="emp_gender" class="forh"
                                                                value="Male"
                                                                <?=$employee[0]['emp_gender']=='Male'?'checked':'';?>>
                                                            Male &nbsp;&nbsp;
                                                            <input type="radio" name="emp_gender" class="forh"
                                                                value="Female"
                                                                <?=$employee[0]['emp_gender']=='Female'?'checked':'';?>>
                                                            Female &nbsp;&nbsp;
                                                            <input type="radio" name="emp_gender" class="forh"
                                                                value="Others"
                                                                <?=$employee[0]['emp_gender']=='Others'?'checked':'';?>>
                                                            Others

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12" style="margin-top:5px;">
                                                    <div class="row">
                                                        <div class="col-md-2">
                                                            <label for="emp_lastname" style="margin-top:5px;">Middle
                                                                name</label>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <input type="text" class="form-control input-sm"
                                                                id="emp_middlename" name="emp_middlename"
                                                                value="<?php echo $employee[0]['emp_middlename'];?>"
                                                                placeholder="Enter Middle Name">
                                                        </div>
                                                        <div class="col-md-2" style="padding:0;">
                                                            <label for="emp_lastname" style="margin-top:5px;">Last
                                                                name</label><span style="color:red;">*</span>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <input type="text" class="form-control input-sm"
                                                                id="emp_lastname" name="emp_lastname"
                                                                value="<?php echo $employee[0]['emp_lastname'];?>"
                                                                placeholder="Enter Last Name" required="required">
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
                                                            <input type="date" class="form-control input-sm"
                                                                id="emp_dob" name="emp_dob"
                                                                value="<?php echo $employee[0]['emp_dob'];?>"
                                                                required="required">

                                                        </div>

                                                        <div class="col-md-2" style="padding:0;">
                                                            <label for="emp_appform_no"
                                                                style="margin-top:5px;">Application No</label>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <input type="text" class="form-control input-sm"
                                                                id="emp_appform_no" name="emp_appform_no"
                                                                value="<?php echo $employee[0]['emp_appform_no'];?>"
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
                                                        <div class="col-md-4" style="padding:0;">
                                                            <label for="emp_maritalstatus"
                                                                style="margin-top:5px;">Marital Status</label>
                                                        </div>
                                                        <div class="col-md-8" style="margin-top:6px;">
                                                            <input type="radio" id="emp_maritalstatus" class="forh"
                                                                name="emp_maritalstatus" value="Yes"
                                                                <?=$employee[0]['emp_maritalstatus']=='Yes'?'checked':'';?>>
                                                            Married
                                                            <input type="radio" id="emp_maritalstatus" class="forh"
                                                                name="emp_maritalstatus" value="No"
                                                                style="margin-left:50px;"
                                                                <?=$employee[0]['emp_maritalstatus']=='No'?'checked':'';?>>
                                                            Unmarried
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-12" style="margin-top:5px;">
                                                    <div class="row">
                                                        <div class="col-md-4" style="padding:0;">
                                                            <label for="emp_age" style="margin-top:5px;">Age</label>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <input type="number" class="form-control input-sm"
                                                                id="emp_age" name="emp_age"
                                                                value="<?php echo $employee[0]['emp_age'];?>"
                                                                placeholder="Enter Age" readonly>
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="col-md-12" style="margin-top:5px;">
                                                    <div class="row">
                                                        <div class="col-md-4" style="padding:0;">
                                                            <label for="emp_doj" style="margin-top:5px;">Date of
                                                                Joining</label>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <input type="date" class="form-control input-sm"
                                                                id="emp_doj" name="emp_doj"
                                                                value="<?php echo date('Y-m-d',strtotime($employee[0]['emp_doj']));?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12" style="margin-top:5px;">
                                                    <div class="row">
                                                        <div class="col-md-4" style="padding:0;">
                                                            <label for="emp_jobtype" style="margin-top:5px;">Job
                                                                Type</label>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <select class="form-control input-sm" id="emp_jobtype"
                                                                name="emp_jobtype"
                                                                value="<?php echo set_value("emp_jobtype");?>">
                                                                <option value="Casual"
                                                                    <?=$employee[0]['emp_jobtype']=='Casual'?'selected':'';?>>
                                                                    Casual</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-12" style="margin-top:5px;">
                                                    <div class="row">
                                                        <div class="col-md-4" style="padding:0;">
                                                            <label for="emp_department"
                                                                style="margin-top:5px;">Department</label><span
                                                                style="color:red;">*</span>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <select class="form-control input-sm" id="emp_department"
                                                                name="emp_department" required>
                                                                <option value="">None</option>
                                                                <?php if(!empty($department)){
                                        foreach ($department as $k => $v) {
                                        $selected = ($employee[0]['department_id'] == $v['did'])?'selected':'';
                                        echo '<option value="'.$v['did'].'" '.$selected.'>'.$v['department_name'].'</option>';
                                        }
                                        }
                                        ?>
                                                            </select>

                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-12" style="margin-top:5px;">
                                                    <div class="row">
                                                        <div class="col-md-4" style="padding:0;">
                                                            <label for="emp_designation"
                                                                style="margin-top:5px;">Designation</label><span
                                                                style="color:red;">*</span>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <select class="form-control input-sm" id="emp_designation"
                                                                name="emp_designation">
                                                                <option value="">None</option>
                                                                <?php if(!empty($designation)){
                                                                    foreach ($designation as $k => $v) {
                                                                    $selected = ($employee[0]['designation_id'] == $v['designation_id'])?'selected':'';
                                                                    echo '<option value="'.$v['designation_id'].'" '.$selected.'>'.$v['designation_name'].'</option>';
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
                                                            <label for="emp_pob" style="margin-top:5px;"
                                                                id="emp_pob">Place Of Birth</label>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <input type="text" class="form-control input-sm"
                                                                id="emp_pob" name="emp_pob"
                                                                value="<?php echo $employee[0]['emp_pob'];?>"
                                                                required="required" placeholder="">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-12" style="margin-top:5px;">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <label for="emp_remark" style="margin-top:5px;">Experience
                                                            </label>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <select type="text" class="form-control input-sm"
                                                                id="exp_year" name="exp_year">
                                                                <?php for ($i=0; $i <= 30; $i++) { ?>
                                                                <option value="<?=$i;?>"
                                                                    <?=$employee[0]['exp_year']==$i?'selected':'';?>>
                                                                    <?=$i;?> Year</option>
                                                                <?php } ?>
                                                            </select>

                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="col-md-12" style="margin-top:5px;">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <label for="dutyhour" style="margin-top:5px;">Duty
                                                                Hour</label><span style="color:red;">*</span>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <input type="number" class="form-control input-sm"
                                                                id="dutyhour" name="dutyhour" required step="0.01"
                                                                value="<?=$employee[0]['dutyhour'];?>">


                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-12" style="margin-top:5px;">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <label for="grade" style="margin-top:5px;">Grade</label>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <select name="grade" class="form-control input-sm">
                                                                <option value="junior"
                                                                    <?=$employee[0]['grade']=='junior'?'selected':'';?>>
                                                                    Junior</option>
                                                                <option value="mid"
                                                                    <?=$employee[0]['grade']=='mid'?'selected':'';?>>Mid
                                                                </option>
                                                                <option value="upper"
                                                                    <?=$employee[0]['grade']=='upper'?'selected':'';?>>
                                                                    Upper</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-12" style="margin-top:5px;">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <label for="e_salary" style="margin-top:5px;">Salary</label>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <input type="number" step="0.01"
                                                                class="form-control input-sm" id="e_salary"
                                                                value="<?php echo $employee[0]['e_salary'];?>"
                                                                name="e_salary" placeholder="Enter Salary">
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                        <div class="col-md-6" style="padding:0;">
                                            <div class="form-group">

                                                <div class="col-md-12" style="margin-top:5px;">
                                                    <div class="row">
                                                        <div class="col-md-4" style="padding:0;">
                                                            <label for="emp_photo" style="margin-top:5px;">Employee
                                                                Photo</label>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <input type="file" class="form-control input-sm"
                                                                id="emp_photo" name="emp_photo"
                                                                accept="image/png,image/jpeg,image/jpg">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-12" style="margin-top:5px;">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <label for="emp_mobile" style="margin-top:5px;">Mobile
                                                                No.</label><span style="color:red;">*</span>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <input type="tel" class="form-control input-sm"
                                                                id="emp_mobile" name="emp_mobile" maxlength="10"
                                                                placeholder="Enter Mobile No."
                                                                value="<?=$employee[0]['emp_mobile'];?>" required>

                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-12" style="margin-top:5px;">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <label for="emp_amobile" style="margin-top:5px;">Alternate
                                                                Mobile No.</label>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <input type="tel" class="form-control input-sm"
                                                                id="emp_amobile" name="emp_amobile" maxlength="10"
                                                                placeholder="Enter Alternate Mobile No."
                                                                value="<?=$employee[0]['emp_amobile'];?>">

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
                                                            <input type="email" class="form-control input-sm"
                                                                id="employee_email" name="employee_email"
                                                                placeholder="Enter Email"
                                                                value="<?=$employee[0]['employee_email'];?>" required>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-12" style="margin-top:5px;">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <label for="official_email" style="margin-top:5px;">Official
                                                                Email</label><span style="color:red;">*</span>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <input type="email" class="form-control input-sm"
                                                                id="official_email" name="official_email" required
                                                                value="<?php echo $employee[0]['official_email'];?>"
                                                                placeholder="Enter Official Email (To be created)">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-12" style="margin-top:5px;">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <label for="emp_pgmobile"
                                                                style="margin-top:5px;">Parents/Guardian Mobile
                                                                No.</label>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <input type="tel" class="form-control input-sm"
                                                                id="emp_pgmobile" name="emp_pgmobile" maxlength="10"
                                                                placeholder="Enter Parents/Guardian Mobile No."
                                                                value="<?=$employee[0]['emp_pgmobile'];?>">

                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-12" style="margin-top:5px;">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <label for="emp_bloodgrp" style="margin-top:5px;">Blood
                                                                Group</label>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <select class="form-control input-sm" id="emp_bloodgrp"
                                                                name="emp_bloodgrp">
                                                                <option value="">--Select Blood Group--</option>
                                                                <option value="A+"
                                                                    <?= ($employee[0]['emp_bloodgrp'] == 'A+') ? 'selected' : ''; ?>>
                                                                    A+</option>
                                                                <option value="A-"
                                                                    <?= ($employee[0]['emp_bloodgrp'] == 'A-') ? 'selected' : ''; ?>>
                                                                    A-</option>
                                                                <option value="B+"
                                                                    <?= ($employee[0]['emp_bloodgrp'] == 'B+') ? 'selected' : ''; ?>>
                                                                    B+</option>
                                                                <option value="B-"
                                                                    <?= ($employee[0]['emp_bloodgrp'] == 'B-') ? 'selected' : ''; ?>>
                                                                    B-</option>
                                                                <option value="AB+"
                                                                    <?= ($employee[0]['emp_bloodgrp'] == 'AB+') ? 'selected' : ''; ?>>
                                                                    AB+</option>
                                                                <option value="AB-"
                                                                    <?= ($employee[0]['emp_bloodgrp'] == 'AB-') ? 'selected' : ''; ?>>
                                                                    AB-</option>
                                                                <option value="O+"
                                                                    <?= ($employee[0]['emp_bloodgrp'] == 'O+') ? 'selected' : ''; ?>>
                                                                    O+</option>
                                                                <option value="O-"
                                                                    <?= ($employee[0]['emp_bloodgrp'] == 'O-') ? 'selected' : ''; ?>>
                                                                    O-</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-12" style="margin-top:5px;">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <label for="emp_remark" style="margin-top:5px;">Higher
                                                                Qualification</label>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <input type="text" class="form-control input-sm"
                                                                id="higher_qual" name="higher_qual"
                                                                placeholder="Enter Higher Qualification"
                                                                value="<?=$employee[0]['higher_qual'];?>">

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
                                                            <input type="text" class="form-control input-sm"
                                                                id="nationality" name="nationality"
                                                                value="<?php echo $employee[0]['nationality'];?>"
                                                                placeholder="Enter Nationality">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-12" style="margin-top:5px;">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <label for="reporting" style="margin-top:5px;">Reporting
                                                                To</label>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <input type="text" class="form-control input-sm"
                                                                id="reporting" name="reporting"
                                                                value="<?php echo $employee[0]['reporting_to'];?>"
                                                                placeholder="Enter Name & Designation">
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                        <div class="col-md-12" style="margin-top:5px;">
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <label for="emergency_name" style="margin-top:5px;">Emergency
                                                        Contact
                                                        Name</label>
                                                </div>
                                                <div class="col-md-2">
                                                    <input type="text" class="form-control input-sm" id="emergency_name"
                                                        name="emergency_name"
                                                        value="<?php echo $employee[0]['emergency_name'];?>"
                                                        placeholder="Enter Emergency Contact Name">
                                                </div>
                                                <div class="col-md-2">
                                                    <label for="emergency_relation" style="margin-top:5px;">Emergency
                                                        Contact
                                                        Relation</label>
                                                </div>
                                                <div class="col-md-2">
                                                    <input type="text" class="form-control input-sm"
                                                        id="emergency_relation" name="emergency_relation"
                                                        value="<?php echo $employee[0]['emergency_relation'];?>"
                                                        placeholder="Enter Emergency Contact Relation">
                                                </div>
                                                <div class="col-md-2" style="padding:0;">
                                                    <label for="emergency_contact" style="margin-top:5px;">Emergency
                                                        Contact
                                                        No.</label>
                                                </div>
                                                <div class="col-md-2">
                                                    <input type="tel" class="form-control input-sm"
                                                        id="emergency_contact" name="emergency_contact"
                                                        value="<?php echo $employee[0]['emergency_contact'];?>"
                                                        placeholder="Enter Emergency Contact No." required="required">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12"
                                        style="margin-top:15px;border: 1px solid #ddd;padding: 14px;border-radius: 5px;">
                                        <div class="icon icon-lg icon-shape" style="margin-top: -25px!important;">
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
                                                                <label for="emp_fathername" style="margin-top:5px;"
                                                                    id="forhnm">Father's
                                                                    Name</label><span style="color:red;">*</span>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <input type="text" class="form-control input-sm"
                                                                    id="emp_fathername" name="emp_fathername"
                                                                    value="<?php echo $employee[0]['emp_fathername'];?>"
                                                                    required="required" placeholder="">
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
                                                                <input type="text" class="form-control input-sm"
                                                                    id="emp_mothername" name="emp_mothername"
                                                                    value="<?php echo $employee[0]['emp_mothername'];?>"
                                                                    placeholder="Enter Mother's Name">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12" style="margin-top:15px;">
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <label for="emp_spousename" style="margin-top:5px;"
                                                                    id="forhnm">Spouse's
                                                                    Name</label><span style="color:red;">*</span>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <input type="text" class="form-control input-sm"
                                                                    id="emp_spousename" name="emp_spousename"
                                                                    value="<?php echo $employee[0]['emp_spousename'];?>"
                                                                    required="required" placeholder="">
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
                                                                <label for="f_occ" style="margin-top:5px;">Father
                                                                    Occupation</label>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <input type="text" class="form-control input-sm"
                                                                    id="f_occ" name="f_occ"
                                                                    value="<?php echo $employee[0]['emp_father_occ'];?>"
                                                                    placeholder="Enter Occupation">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12" style="margin-top:6px;">
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <label for="m_occ" style="margin-top:5px;">Mother's
                                                                    Occupation</label>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <input type="text" class="form-control input-sm"
                                                                    id="m_occ" name="m_occ"
                                                                    value="<?php echo $employee[0]['emp_mother_occ'];?>"
                                                                    placeholder="Enter Occupation">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12" style="margin-top:6px;">
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <label for="s_occ" style="margin-top:5px;">Spouse's
                                                                    Occupation</label>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <input type="text" class="form-control input-sm"
                                                                    id="s_occ" name="s_occ"
                                                                    value="<?php echo $employee[0]['emp_spouse_occ'];?>"
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
                                        <div class="icon icon-lg icon-shape" style="margin-top: -25px!important;">
                                            <span
                                                style="background-color: white;width: 100px;font-size: 12px;padding-left: 4px;padding-right: 4px;">Current
                                                Address</span>
                                        </div>
                                        <div class="">
                                            <div class="col-md-6" style="padding:0;">
                                                <div class="form-group">
                                                    <div class="col-md-12">
                                                        <div class="row">
                                                            <div class="col-md-4" style="padding:0;">
                                                                <label for="emp_current"
                                                                    style="margin-top:5px;">PLOT/HOUSE/KHATA No</label>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <input type="text" class="form-control input-sm"
                                                                    id="emp_plotno" name="emp_plotno"
                                                                    placeholder="PLOT/HOUSE/KHATA No"
                                                                    value="<?=$employee[0]['emp_plotno'];?>">
                                                            </div>
                                                        </div>
                                                    </div>


                                                    <div class="col-md-12" style="margin-top:6px;">
                                                        <div class="row">
                                                            <div class="col-md-4" style="padding:0;">
                                                                <label for="emp_address"
                                                                    style="margin-top:5px;">State</label>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <select class="form-control input-sm" id="emp_state"
                                                                    name="emp_state">
                                                                    <option value="">State</option>
                                                                    <?php if ($state) { for ($i=0; $i < count($state); $i++) { ?>
                                                                    <option value="<?=$state[$i]['state_id'];?>"
                                                                        <?=$employee[0]['emp_state'] == $state[$i]['state_id']?'selected':'';?>>
                                                                        <?=$state[$i]['state_title'];?></option>
                                                                    <?php } } ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12" style="margin-top:6px;">
                                                        <div class="row">
                                                            <div class="col-md-4" style="padding:0;">
                                                                <label for="emp_address"
                                                                    style="margin-top:5px;">District</label>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <select class="form-control input-sm" id="emp_dist"
                                                                    name="emp_dist">
                                                                    <option value="">District</option>
                                                                    <?php if ($district) { for ($i=0; $i < count($district); $i++) { ?>
                                                                    <option value="<?=$district[$i]['district_id'];?>"
                                                                        <?=$employee[0]['emp_dist'] == $district[$i]['district_id']?'selected':'';?>>
                                                                        <?=$district[$i]['district_title'];?></option>
                                                                    <?php } } ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12" style="margin-top:6px;">
                                                        <div class="row">
                                                            <div class="col-md-4" style="padding:0;">
                                                                <label for="emp_curpin" style="margin-top:5px;">Pin
                                                                    Code</label>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <input type="number" class="form-control input-sm"
                                                                    id="emp_curpin" name="emp_curpin"
                                                                    placeholder="Enter Pincode"
                                                                    value="<?=$employee[0]['emp_curpin'];?>">
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
                                                                <input type="text" class="form-control input-sm"
                                                                    id="emp_at" name="emp_at" placeholder="Enter At"
                                                                    value="<?=$employee[0]['emp_at'];?>">
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
                                                                <input type="text" class="form-control input-sm"
                                                                    id="emp_po" name="emp_po" placeholder="Enter PO"
                                                                    value="<?=$employee[0]['emp_po'];?>">
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
                                                                <input type="text" class="form-control input-sm"
                                                                    id="emp_tahsil" name="emp_tahsil"
                                                                    placeholder="Enter Tahsil"
                                                                    value="<?=$employee[0]['emp_tahsil'];?>">
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
                                                                <input type="text" class="form-control input-sm"
                                                                    id="emp_landmark" name="emp_landmark"
                                                                    placeholder="Enter Landmark"
                                                                    value="<?=$employee[0]['emp_landmark'];?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>



                                    </div>

                                    <div class="col-md-12"
                                        style="margin-top:15px;border: 1px solid #ddd;padding: 14px;border-radius: 5px;">
                                        <div class="icon icon-lg icon-shape" style="margin-top: -25px!important;">
                                            <span
                                                style="background-color: white;width: 100px;font-size: 12px;padding-left: 4px;padding-right: 4px;">Permanent
                                                Address &nbsp&nbsp<input type="checkbox" id="sameaddress"></span>
                                        </div>

                                        <div class="">
                                            <div class="col-md-6" style="padding:0;">
                                                <div class="form-group">
                                                    <div class="col-md-12">
                                                        <div class="row">
                                                            <div class="col-md-4" style="padding:0;">
                                                                <label for="emp_current"
                                                                    style="margin-top:5px;">PLOT/HOUSE/KHATA No</label>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <input type="text" class="form-control input-sm"
                                                                    id="emp_plotnop" name="emp_plotnop"
                                                                    placeholder="PLOT/HOUSE/KHATA No"
                                                                    value="<?=$employee[0]['emp_plotnop'];?>">
                                                            </div>
                                                        </div>
                                                    </div>


                                                    <div class="col-md-12" style="margin-top:6px;">
                                                        <div class="row">
                                                            <div class="col-md-4" style="padding:0;">
                                                                <label for="emp_address"
                                                                    style="margin-top:5px;">State</label>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <select class="form-control input-sm" id="emp_statep"
                                                                    name="emp_statep">
                                                                    <option value="">State</option>
                                                                    <?php if ($state) { for ($i=0; $i < count($state); $i++) { ?>
                                                                    <option value="<?=$state[$i]['state_id'];?>"
                                                                        <?=$employee[0]['emp_statep'] == $state[$i]['state_id']?'selected':'';?>>
                                                                        <?=$state[$i]['state_title'];?></option>
                                                                    <?php } } ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12" style="margin-top:6px;">
                                                        <div class="row">
                                                            <div class="col-md-4" style="padding:0;">
                                                                <label for="emp_address"
                                                                    style="margin-top:5px;">District</label>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <select class="form-control input-sm" id="emp_distp"
                                                                    name="emp_distp">
                                                                    <option value="">District</option>
                                                                    <?php if ($districtp) { for ($i=0; $i < count($districtp); $i++) { ?>
                                                                    <option value="<?=$districtp[$i]['district_id'];?>"
                                                                        <?=$employee[0]['emp_distp'] == $districtp[$i]['district_id']?'selected':'';?>>
                                                                        <?=$districtp[$i]['district_title'];?></option>
                                                                    <?php } } ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12" style="margin-top:6px;">
                                                        <div class="row">
                                                            <div class="col-md-4" style="padding:0;">
                                                                <label for="emp_curpin" style="margin-top:5px;">Pin
                                                                    Code</label>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <input type="number" class="form-control input-sm"
                                                                    id="emp_curpinp" name="emp_curpinp"
                                                                    placeholder="Enter Pincode"
                                                                    value="<?=$employee[0]['emp_curpinp'];?>">
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
                                                                <input type="text" class="form-control input-sm"
                                                                    id="emp_atp" name="emp_atp" placeholder="Enter At"
                                                                    value="<?=$employee[0]['emp_atp'];?>">
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
                                                                <input type="text" class="form-control input-sm"
                                                                    id="emp_pop" name="emp_pop" placeholder="Enter PO"
                                                                    value="<?=$employee[0]['emp_pop'];?>">
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
                                                                <input type="text" class="form-control input-sm"
                                                                    id="emp_tahsilp" name="emp_tahsilp"
                                                                    placeholder="Enter Tahsil"
                                                                    value="<?=$employee[0]['emp_tahsilp'];?>">
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
                                                                <input type="text" class="form-control input-sm"
                                                                    id="emp_landmarkp" name="emp_landmarkp"
                                                                    placeholder="Enter Landmark"
                                                                    value="<?=$employee[0]['emp_landmarkp'];?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                    </div>
                                    <div class="col-md-12"
                                        style="margin-top:15px;border: 1px solid #ddd;padding: 14px;border-radius: 5px;">
                                        <div class="icon icon-lg icon-shape" style="margin-top: -25px!important;">
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
                                                                    value="<?= $employee_id_details[0]['dl_no'] ?? '' ?>"
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
                                                                    value="<?= $employee_id_details[0]['passport_no'] ?? '' ?>"
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
                                                                <label for="emp_voter" style="margin-top:5px;">Voter
                                                                    ID.</label>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <input type="text" class="form-control input-sm"
                                                                    id="emp_voter" name="emp_voter"
                                                                    value="<?= $employee_id_details[0]['voter_id'] ?? '' ?>"
                                                                    placeholder="Enter Voter ID No.">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6" style="padding:0;margin-top:5px;">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <label style="margin-top:5px;">Upload
                                                            PVR</label>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <input type="file" name="pvr" class="form-control input-sm"
                                                            accept=".pdf,.jpg,.jpeg,.png">
                                                        <?php if(!empty($doc['pvr'])){ ?>
                                                        <a href="<?= base_url('uploads/employee_documents/'.$doc['pvr']) ?>"
                                                            target="_blank">
                                                            View Uploaded PVR
                                                        </a>
                                                        <?php } ?>
                                                        <input type="hidden" name="old_pvr"
                                                            value="<?= $doc['pvr'] ?? '' ?>">
                                                    </div>
                                                </div>
                                            </div>

                                        </div>


                                    </div>

                                    <div class="col-md-12"
                                        style="margin-top:15px;border:1px solid #ddd;padding:14px;border-radius:5px;">
                                        <div class="icon icon-lg icon-shape" style="margin-top:-25px!important;">
                                            <span
                                                style="background-color:white;width:100px;font-size:12px;padding:0 4px;">Edcational
                                                Details</span>
                                        </div>
                                        <div class="col-md-12 p-0">
                                            <h6><strong>From 10th to Highest Qualification</strong></h6>

                                            <div id="educationContainer">

                                                <?php if (!empty($education)) { ?>
                                                <?php foreach ($education as $k => $edu) { ?>

                                                <div class="row edu-row mb-3 align-items-start">
                                                    <div class="col-md-1 text-center">
                                                        <strong class="edu-serial"><?= $k + 1 ?></strong>
                                                    </div>

                                                    <div class="col-md-10">
                                                        <div class="row">
                                                            <div class="col-md-2">
                                                                <select class="form-control input-sm"
                                                                    name="education_level[]">
                                                                    <option value="">Level</option>
                                                                    <?php
                                                                        $levels = ['10th','12th','Diploma','Bachelors','Masters'];
                                                                        foreach ($levels as $lvl) {
                                                                            $sel = ($edu['degree'] === $lvl) ? 'selected' : '';
                                                                            echo "<option value=\"$lvl\" $sel>$lvl</option>";
                                                                        }
                                                                    ?>
                                                                </select>

                                                            </div>

                                                            <div class="col-md-2">
                                                                <input type="text" class="form-control input-sm"
                                                                    name="year[]" value="<?= $edu['passing_year'] ?>">
                                                            </div>

                                                            <div class="col-md-2">
                                                                <input type="text" class="form-control input-sm"
                                                                    name="board[]" value="<?= $edu['board'] ?>">
                                                            </div>

                                                            <div class="col-md-2">
                                                                <input type="text" class="form-control input-sm"
                                                                    name="institute[]" value="<?= $edu['institute'] ?>">
                                                            </div>

                                                            <div class="col-md-2">
                                                                <input type="text" class="form-control input-sm"
                                                                    name="qualification[]"
                                                                    value="<?= $edu['qualification'] ?>">
                                                            </div>

                                                            <div class="col-md-2">
                                                                <input type="text" class="form-control input-sm"
                                                                    name="percentage[]"
                                                                    value="<?= $edu['percentage'] ?>">
                                                            </div>

                                                            <div class="col-md-4 mt-2">
                                                                <?php if (!empty($edu['certificate'])) { ?>
                                                                <a href="<?= base_url('uploads/education/'.$edu['certificate']) ?>"
                                                                    target="_blank">View Certificate</a>
                                                                <?php } ?>
                                                                <input type="file" class="form-control"
                                                                    name="emp_cert[]" accept=".pdf,.jpg,.jpeg,.png">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-1 text-center">
                                                        <button type="button" class="btn btn-danger btn-xs removeRow"
                                                            <?= ($k == 0 && count($education) == 1) ? 'disabled' : '' ?>>−</button>
                                                    </div>
                                                </div>

                                                <?php } ?>
                                                <?php } else { ?>

                                                <!-- Fallback empty row (VERY IMPORTANT) -->
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
                                                                    <option value="10th">10th</option>
                                                                    <option value="12th">12th</option>
                                                                    <option value="Diploma">Diploma</option>
                                                                    <option value="Bachelors">Bachelors</option>
                                                                    <option value="Masters">Masters</option>
                                                                </select>
                                                            </div>

                                                            <div class="col-md-2">
                                                                <input type="text" class="form-control input-sm"
                                                                    name="year[]">
                                                            </div>

                                                            <div class="col-md-2">
                                                                <input type="text" class="form-control input-sm"
                                                                    name="board[]">
                                                            </div>

                                                            <div class="col-md-2">
                                                                <input type="text" class="form-control input-sm"
                                                                    name="institute[]">
                                                            </div>

                                                            <div class="col-md-2">
                                                                <input type="text" class="form-control input-sm"
                                                                    name="qualification[]">
                                                            </div>

                                                            <div class="col-md-2">
                                                                <input type="text" class="form-control input-sm"
                                                                    name="percentage[]">
                                                            </div>

                                                            <div class="col-md-4 mt-2">
                                                                <input type="file" class="form-control"
                                                                    name="emp_cert[]">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-1 text-center">
                                                        <button type="button" class="btn btn-danger btn-xs removeRow"
                                                            disabled>−</button>
                                                    </div>
                                                </div>

                                                <?php } ?>

                                            </div>

                                            <div class="text-right mt-2">
                                                <button type="button" class="btn btn-success btn-xs" id="addEduBtn">+
                                                    Add Education</button>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="col-md-12"
                                        style="margin-top:15px;border:1px solid #ddd;padding:14px;border-radius:5px;">
                                        <div class="icon icon-lg icon-shape" style="margin-top:-25px!important;">
                                            <span
                                                style="background-color:white;width:100px;font-size:12px;padding:0 4px;">Experiences</span>
                                        </div>

                                        <div class="col-md-12 p-0">
                                            <h6><strong>Present & Past</strong></h6>

                                            <div id="experienceContainer">
                                                <?php if (!empty($experience)) {
                                                foreach ($experience as $k => $exp) { ?>

                                                <div class="row exp-row mb-2 align-items-center">
                                                    <input type="hidden" name="exp_id[]" value="<?= $exp['id'] ?>">
                                                    <div class="col-md-1 text-center">
                                                        <strong class="exp-serial"><?= $k+1 ?></strong>
                                                    </div>

                                                    <div class="col-md-10">
                                                        <div class="row">
                                                            <div class="col-md-2">
                                                                <input type="text" class="form-control input-sm"
                                                                    name="employer[]" value="<?= $exp['employer'] ?>">
                                                            </div>
                                                            <div class="col-md-1">
                                                                <input type="date" class="form-control input-sm"
                                                                    name="from_date[]" value="<?= $exp['from_date'] ?>">
                                                            </div>

                                                            <div class="col-md-1">
                                                                <input type="date" class="form-control input-sm"
                                                                    name="to_date[]" value="<?= $exp['to_date'] ?>">
                                                            </div>
                                                            <div class="col-md-2">
                                                                <input type="text" class="form-control input-sm"
                                                                    name="designation[]"
                                                                    value="<?= $exp['designation'] ?>">
                                                            </div>
                                                            <div class="col-md-2">
                                                                <input type="text" class="form-control input-sm"
                                                                    name="salary[]" value="<?= $exp['salary'] ?>">
                                                            </div>
                                                            <div class="col-md-2">
                                                                <input type="text" class="form-control input-sm"
                                                                    name="responsibilities[]"
                                                                    value="<?= $exp['responsibilities'] ?>">
                                                            </div>
                                                            <div class="col-md-2">
                                                                <input type="text" class="form-control input-sm"
                                                                    name="reason[]" value="<?= $exp['reason'] ?>">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-1 text-center">
                                                        <button type="button" class="btn btn-danger btn-xs removeExpRow"
                                                            <?= ($k==0 && count($experience)==1) ? 'disabled' : '' ?>>−</button>
                                                    </div>
                                                </div>

                                                <?php } } ?>

                                            </div>

                                            <div class="text-right mt-2">
                                                <button type="button" class="btn btn-success btn-xs" id="addExpBtn">+
                                                    Add Experience</button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12"
                                        style="margin-top:15px;border:1px solid #ddd;padding:14px;border-radius:5px;">
                                        <div class="icon icon-lg icon-shape" style="margin-top:-25px!important;">
                                            <span
                                                style="background-color:white;width:100px;font-size:12px;padding:0 4px;">References</span>
                                        </div>

                                        <div class="col-md-12 p-0">
                                            <h6><strong>Professional References</strong></h6>

                                            <div id="referenceContainer">
                                                <?php if (!empty($references)) {
                                                    foreach ($references as $k => $ref) { ?>

                                                <div class="row ref-row mb-2 align-items-center">
                                                    <input type="hidden" name="ref_id[]" value="<?= $ref['id'] ?>">
                                                    <div class="col-md-1 text-center">
                                                        <strong class="ref-serial"><?= $k+1 ?></strong>
                                                    </div>

                                                    <div class="col-md-10">
                                                        <div class="row">
                                                            <div class="col-md-2"><input type="text"
                                                                    class="form-control input-sm" name="ref_name[]"
                                                                    value="<?= $ref['ref_name'] ?>"></div>
                                                            <div class="col-md-2"><input type="text"
                                                                    class="form-control input-sm"
                                                                    name="ref_relationship[]"
                                                                    value="<?= $ref['relationship'] ?>"></div>
                                                            <div class="col-md-2"><input type="text"
                                                                    class="form-control input-sm"
                                                                    name="ref_organization[]"
                                                                    value="<?= $ref['organization'] ?>"></div>
                                                            <div class="col-md-2"><input type="text"
                                                                    class="form-control input-sm" name="ref_phone[]"
                                                                    value="<?= $ref['phone'] ?>"></div>
                                                            <div class="col-md-2"><input type="email"
                                                                    class="form-control input-sm" name="ref_email[]"
                                                                    value="<?= $ref['email'] ?>"></div>
                                                            <div class="col-md-2"><input type="text"
                                                                    class="form-control input-sm" name="ref_years[]"
                                                                    value="<?= $ref['years_known'] ?>"></div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-1 text-center">
                                                        <button type="button" class="btn btn-danger btn-xs removeRefRow"
                                                            <?= ($k==0 && count($references)==1) ? 'disabled' : '' ?>>−</button>
                                                    </div>
                                                </div>

                                                <?php } } ?>

                                            </div>

                                            <div class="text-right mt-2">
                                                <button type="button" class="btn btn-success btn-xs" id="addRefBtn">+
                                                    Add Reference</button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12"
                                        style="margin-top:15px;border: 1px solid #ddd;padding: 14px;border-radius: 5px;">
                                        <div class="icon icon-lg icon-shape" style="margin-top: -25px!important;">
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
                                                                <label for="emp_medh" style="margin-top:5px;">Major
                                                                    Medical
                                                                    History (If Any) </label>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <textarea class="form-control input-sm" id="emp_medh"
                                                                    name="emp_medh"><?= $medical[0]['medical_history'] ?? '' ?></textarea>
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
                                                                    value="<?= $medical[0]['allergies'] ?? '' ?>"
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
                                                                <label for="reg_med" style="margin-top:5px;">Regular
                                                                    Medications</label>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <input type="text" class="form-control input-sm"
                                                                    id="reg_med" name="reg_med"
                                                                    value="<?= $medical[0]['regular_medications'] ?? '' ?>"
                                                                    placeholder="Enter Regular Medications">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12" style="margin-top:6px;">
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <label for="emp_doc" style="margin-top:5px;">Family
                                                                    Doctor's
                                                                    Name</label>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <input type="text" class="form-control input-sm"
                                                                    id="emp_doc" name="emp_doc"
                                                                    value="<?= $medical[0]['doctor_name'] ?? '' ?>"
                                                                    placeholder="Enter Family Doctor's Name">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12" style="margin-top:6px;">
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <label for="doc_no" style="margin-top:5px;">Doctor's
                                                                    Contact
                                                                    No.</label>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <input type="tel" class="form-control input-sm"
                                                                    id="doc_no" name="doc_no"
                                                                    value="<?= $medical[0]['doctor_contact'] ?? '' ?>"
                                                                    placeholder="Enter Family Doctor's Contact No.">
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>

                                            </div>

                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-12"
                                                style="margin-top:15px;border: 1px solid #ddd;padding: 14px;border-radius: 5px;">
                                                <div class="icon icon-lg icon-shape"
                                                    style="margin-top: -25px!important;">
                                                    <span
                                                        style="background-color: white;width: 100px;font-size: 12px;padding-left: 4px;padding-right: 4px;">Salary
                                                        Transfer Bank Details</span>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="col-md-12" style="padding:0;">
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <label for="st_paymode" style="margin-top:5px;">Pay
                                                                    Mode</label>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <select name="st_paymode" class="form-control input-sm">
                                                                    <option value="Cash"
                                                                        <?= ($bank['st_paymode'] ?? '')=='Cash'?'selected':'' ?>>
                                                                        Cash</option>
                                                                    <option value="Cheque"
                                                                        <?= ($bank['st_paymode'] ?? '')=='Cheque'?'selected':'' ?>>
                                                                        Cheque</option>
                                                                    <option value="Net Banking"
                                                                        <?= ($bank['st_paymode'] ?? '')=='Net Banking'?'selected':'' ?>>
                                                                        E-payment</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12" style="padding:0;margin-top:5px;">
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <label for="st_bankname" style="margin-top:5px;">Bank
                                                                    Name</label>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <input type="text" class="form-control input-sm"
                                                                    name="st_bankname"
                                                                    value="<?= $bank['st_bankname'] ?? '' ?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12" style="padding:0;margin-top:5px;">
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <label for="st_branch" style="margin-top:5px;">Branch
                                                                    Name</label>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <input type="text" class="form-control input-sm"
                                                                    id="st_branch" name="st_branch"
                                                                    value="<?= $bank['st_branch'] ?? '' ?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12" style="padding:0;margin-top:5px;">
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <label for="st_acno" style="margin-top:5px;">Account
                                                                    Number</label>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <input type="text" class="form-control input-sm"
                                                                    id="st_acno" name="st_acno"
                                                                    value="<?= $bank['st_acno'] ?? '' ?>">

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="col-md-12" style="padding:0;margin-top:5px;">
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <label for="st_acholdername"
                                                                    style="margin-top:5px;">Account
                                                                    Holder
                                                                    Name</label>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <input type="text" class="form-control input-sm"
                                                                    id="st_acholdername" name="st_acholdername"
                                                                    value="<?= $bank['st_acholdername'] ?? '' ?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12" style="padding:0;margin-top:5px;">
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <label for="st_ifsc" style="margin-top:5px;">IFSC
                                                                    Code</label>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <input type="text" class="form-control input-sm"
                                                                    id="st_ifsc" name="st_ifsc"
                                                                    value="<?= $bank['st_ifsc'] ?? '' ?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12" style="padding:0;margin-top:5px;">
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <label for="st_referenceno"
                                                                    style="margin-top:5px;">Reference
                                                                    No.</label>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <input type="text" class="form-control input-sm"
                                                                    id="st_referenceno" name="st_referenceno"
                                                                    value="<?= $bank['st_referenceno'] ?? '' ?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12" style="padding:0;margin-top:5px;">
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <label for="emp_cheque">Upload
                                                                    Cheque</label>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <input type="file" name="emp_cheque" id="emp_cheque"
                                                                    class="form-control" accept=".pdf,.jpg,.jpeg,.png">
                                                                <?php if(!empty($bank['emp_cheque'])){ ?>
                                                                <a href="<?= base_url('uploads/cheques/'.$bank['emp_cheque']) ?>"
                                                                    target="_blank">
                                                                    View Uploaded Cheque
                                                                </a>
                                                                <?php } ?>
                                                                <input type="hidden" name="old_cheque"
                                                                    value="<?= $bank['emp_cheque'] ?? '' ?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="box-footer">
                                <button type="submit" name="submitBtn" value="submit"
                                    class="btn btn-primary">Save</button>
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

$("body").on('change keyup', '.wages', function() {
    var epf = parseFloat($("#epf_percentile").val());
    var sal = 0;
    $(".addition").each(function() {
        sal = sal + parseFloat($(this).val());
    });
    var deduction = 0;
    $(".deduction").each(function() {
        deduction = deduction + parseFloat($(this).val());
    });
    var total = sal - (epf + deduction);
    $("#total_salary").val(total.toFixed(2));
});
$(document).ready(function() {
    $("#epf_percentile").change(function() {
        var epf = parseFloat($(this).val());
        var sal = 0;
        $(".addition").each(function() {
            sal = sal + parseFloat($(this).val());
        });
        var deduction = 0;
        $(".deduction").each(function() {
            deduction = deduction + parseFloat($(this).val());
        });
        var total = sal - (epf + deduction);
        $("#total_salary").val(total.toFixed(2));
    });
    $(".createlogin").change(function() {
        if ($(this).prop("checked")) {
            $(".logindetails").show();
        } else {
            $(".logindetails").hide();
        }
    });
});

$(document).on('change', '#emp_headofc', function() {
    var emp_headofc = $(this).val();

    if (emp_headofc != '') {
        $.ajax({
            url: '<?=site_url("employee/get_UnitByHeadofc");?>',
            data: {
                emp_headofc: emp_headofc
            },
            dataType: "HTML",
            type: "POST",
            success: function(data) {

                $("#emp_unit").html(data);

            }
        });
    }

});

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
        let emp_state = $('#emp_state').prop('outerHTML');
        let emp_dist = $('#emp_dist').prop('outerHTML');
        $('#emp_plotnop').val('');
        $('#emp_statep').html(emp_state);
        $('#emp_distp').html(emp_dist);
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

function toggleEduRemoveButtons() {
    $('.removeRow').prop('disabled', $('.edu-row').length === 1);
}

$('#addEduBtn').on('click', function() {

    let row = $('.edu-row').first().clone(true);

    row.find('input[type=text], select').val('');
    row.find('.removeRow').prop('disabled', false);

    row.find('input[type=file]').replaceWith(
        '<input type="file" class="form-control" name="emp_cert[]" accept=".pdf,.jpg,.jpeg,.png">'
    );

    $('#educationContainer').append(row);

    updateEduSerials();
    toggleEduRemoveButtons();
});

$(document).on('click', '.removeRow', function() {
    $(this).closest('.edu-row').remove();
    updateEduSerials();
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
    row.find('input[type=hidden]').val('');
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
    row.find('input[type=hidden]').val('');
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
</script>
</body>

</html>