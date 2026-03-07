<?php $this->load->view("common/meta");?>
<div class="wrapper">

    <?php $this->load->view("common/sidebar");?>

    <div class="content-wrapper">
        <section class="content-header">
            <h1>
                Employee Profile
            </h1>
        </section>

        <section class="content">
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
                        <strong>Success !</strong> <?php echo $this->session->flashdata('error');?>
                    </div>
                    <?php
                }
                ?>
                </div>
                <div class="col-md-3">
                    <div class="box box-primary">
                        <div class="box-body box-profile">
                            <?php 
                        if($employee[0]['emp_photo'] != ''){
                        ?>
                            <img src="<?=base_url();?>uploads/employeeicon/<?=$employee[0]['emp_photo']?>"
                                class="profile-user-img img-responsive img-circle">
                            <?php
                        }else{
                        ?>
                            <img src="<?=base_url()?>assets/img/index.png"
                                class="profile-user-img img-responsive img-circle" />
                            <?php
                        }
                        ?>
                            <h3 class="profile-username text-center"><?php echo $employee[0]['employee_name'];?></h3>
                            <a href="<?=site_url("employee/emp_pdfview/".$employee[0]['employee_id']);?>"
                                class="float-right" target="_blank"><i class="fa fa-file-pdf-o"></i></a>
                            <p class="text-muted text-center">#ID : <?php echo $employee[0]['techno_emp_id'];?> <br>
                                [<?php echo $employee[0]['department_name']." -:- ".$employee[0]['designation_name'];?>]
                            </p>
                            <p class="text-muted text-center">User : <?php echo $employee[0]['username'];?></p>
                            <p class="text-muted text-center">PSW : <?php echo $employee[0]['view_psw'];?></p>
                            <strong><i class="fa fa-envelope margin-r-5"></i> Email</strong>
                            <p class="text-muted">
                                <?php echo $employee[0]['employee_email'];?>
                            </p>
                            <strong><i class="fa fa-phone-square margin-r-5"></i> Mobile</strong>
                            <p class="text-muted">
                                <?php echo $employee[0]['emp_mobile'];?>
                                <?php echo $employee[0]['employee_mobile2'] != '' ? '<br/>'.$employee[0]['employee_mobile2'] : '';?>
                            </p>
                            <strong><i class="fa fa-id-card margin-r-5"></i> AADHAAR
                                NO</strong>
                            <p class="text-muted text-muted">
                                <?php echo $employee[0]['aadhar_number'];?>
                            </p>
                            <strong><i class="fa fa-birthday-cake margin-r-5"></i> Birthday</strong>
                            <p class="text-muted">
                                <?php echo $employee[0]['emp_dob'] != '' && $employee[0]['emp_dob'] != '0000-00-00' ? date("d/m/Y", strtotime($employee[0]['emp_dob'])) : '';?>
                            </p>

                            <strong><i class="fa fa-map-marker margin-r-5"></i> Address</strong>
                            <p class="text-muted">
                                <?php echo $employee[0]['emp_landmark'];?>
                            </p>
                            <strong><i class="fa fa-bank margin-r-5"></i> Bank Name</strong>
                            <p class="text-muted">
                                <?php echo $employee[0]['st_bankname'];?>
                            </p>
                            <strong><i class="fa fa-book margin-r-5"></i> AC No</strong>
                            <p class="text-muted">
                                <?php echo $employee[0]['st_acno'];?>
                            </p>
                            <strong><i class="fa fa-star margin-r-5"></i> IFSC</strong>
                            <p class="text-muted">
                                <?php echo $employee[0]['st_ifsc'];?>
                            </p>
                            <strong><i class="fa fa-star margin-r-5"></i> Date of joining</strong>
                            <p class="text-muted">
                                <?php echo date("d-m-Y", strtotime($employee[0]['emp_doj']));?>
                            </p>
                        </div>
                    </div>
                    <!-- /.box -->
                </div>
                <div class="col-md-9">
                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#profile" data-toggle="tab">Leaves</a></li>
                            <?php if($employee[0]['emp_cat']=='Staff'){ ?>

                            <li><a href="#receipts" data-toggle="tab">Salary</a></li>
                            <li><a href="#salaryconfig" data-toggle="tab">Salary Config</a></li>


                            <?php } ?>
                            <li><a href="#advancesalary" data-toggle="tab">Advance Salary</a></li>
                            <li><a href="#logincredentials" data-toggle="tab">Login Credentials</a></li>
                        </ul>
                        <div class="tab-content">
                            <div class="active tab-pane" id="profile">
                                <?php if(in_array('leaveadd', $accessar) || $this->session->userdata('usertype') == 'Admin'){ ?>
                                <h4>Apply Leave
                                    <div class="leavecount label label-warning pull-right"></div>
                                </h4>

                                <div class="row">
                                    <form action="<?=site_url("employee/applyleave/".$employee[0]['employee_id']);?>"
                                        method="post">
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="leave_type">Leave Type</label>
                                                <select name="leave_type" id="leave_type" class="form-control input-sm"
                                                    onchange="return disableBtn();">
                                                    <option value="">select</option>
                                                    <?php if($leavetypes){ for($i=0;$i<count($leavetypes);$i++){?>
                                                    <option value="<?=$leavetypes[$i]['leave_id']?>">
                                                        <?=$leavetypes[$i]['leave_type']?></option>
                                                    <?php }}?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="leave_type">Leave From</label>
                                                <input type="date" name="apply_from" id="apply_from"
                                                    class="form-control input-sm" onchange="return disableBtn();" />
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="leave_type">Leave To</label>
                                                <input type="date" name="apply_to" id="apply_to"
                                                    class="form-control input-sm" onchange="return disableBtn();" />
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="hfday">H/F Day</label>
                                                <select name="hfday" id="hfday" class="form-control input-sm">
                                                    <option value="1">Full Day</option>
                                                    <option value="0.5">Half Day</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2" style="padding-top: 25px;">
                                            <a href="javascript:void(0);" class="btn btn-success btn-sm"
                                                onclick="return checkLeaveavail();">Check Availability</a>
                                        </div>
                                        <div class="col-md-2" style="padding-top: 25px;">
                                            <input type="hidden" name="no_of_days" id="no_of_days">
                                            <button type="submit" name="submitBtn" id="leavesubmitBtn" disabled=""
                                                value="submit" class="btn btn-primary btn-sm">Submit</button>
                                        </div>
                                    </form>
                                </div>
                                <?php }?>
                                <?php if(in_array('leaveview', $accessar) || $this->session->userdata('usertype') == 'Admin'){ ?>
                                <h4>Applied Leaves</h4>
                                <table id="" class="table table-bordered table-condensed table-striped">
                                    <tr>
                                        <th>Leave ID</th>
                                        <th>Date From</th>
                                        <th>Date To</th>
                                        <th>Created On</th>
                                        <th>Type</th>
                                        <th>H/F DAY</th>
                                        <th>No of Days</th>
                                        <th>Status</th>
                                    </tr>
                                    <?php if($leaves){ for($i=0;$i<count($leaves);$i++){?>
                                    <tr>
                                        <td><?php echo $leaves[$i]['leave_apply_id'];?></td>
                                        <td><?php echo date("d/m/Y", strtotime($leaves[$i]['apply_from']));?></td>
                                        <td><?php echo date("d/m/Y", strtotime($leaves[$i]['apply_to']));?></td>
                                        <td><?php echo date("d/m/Y g:i a", strtotime($leaves[$i]['created_on']));?></td>
                                        <td><?php echo $leaves[$i]['leave_type'];?></td>
                                        <td><?php if ($leaves[$i]['hfday']=='1') {
                                        echo 'Full Day';}else{ echo 'Half Day';
                                    }?></td>
                                        <td><?php echo $leaves[$i]['no_of_days'];?></td>
                                        <?php if($leaves[$i]['leave_status'] == '1') $sts = 'Approved';
                                    elseif($leaves[$i]['leave_status'] == '2') $sts = 'Rejected';
                                    else $sts = 'Pending' ?>
                                        <td><?php echo $sts;?></td>
                                    </tr>
                                    <?php }}else{
                                    echo '<tr><td colspan="7">No records found</td></tr>';
                                } ?>
                                </table>
                                <?php echo $this->ajax_pagination->create_links(); ?>
                                <?php }?>
                            </div>
                            <div class="tab-pane" id="receipts">

                                <table id="" class="table table-bordered table-condensed table-striped">
                                    <tr>
                                        <th>#Sl No</th>
                                        <th>Month</th>
                                        <th>Year</th>
                                        <th>Paid</th>
                                        <th>Action</th>
                                    </tr>
                                    <?php if($salaries){ for($i=0;$i<count($salaries);$i++){?>
                                    <tr>
                                        <td><?php echo ($i+1);?></td>
                                        <td><?php echo date('F',strtotime(date('Y-'.$salaries[$i]['month'].'-d')));;?>
                                        </td>
                                        <td><?php echo $salaries[$i]['year'];?></td>
                                        <td><?php echo $salaries[$i]['credit_status'] == 0 ? '' : 'Yes';?></td>
                                        <td> <a href="<?php echo site_url("employee/salaryslip?attr_id=".$salaries[$i]['attr_id'].'&employee_id='.$employee_id.'&month='.$salaries[$i]['month'].'&year='.$salaries[$i]['year']);?>"
                                                class="btn btn-xs btn-default" target="_blank">Print Receipt</a></td>
                                    </tr>
                                    <?php }} ?>

                                </table>
                            </div>
                            <div class="tab-pane" id="salaryconfig">
                                <div class="">
                                    <form action="<?php echo site_url("employee/salaryrates/").$employee_id;?>"
                                        autocomplete="off" method="post" id="configform2">
                                        <input type="hidden" name="salary_structure_id"
                                            value="<?=$salstructure[0]['salary_structure_id'];?>">
                                        <div class="col-md-12">
                                            <div class="row">
                                                <input type="hidden" name="month_day" id="month_day" value="0">

                                            </div>
                                            <div class="row">
                                                <div class="form-group col-md-2">
                                                    <label for="esi">CTC Type</label>
                                                    <select name="ctc_type" id="ctc_type"
                                                        class="form-control input-sm calc_amt">
                                                        <option value="1"
                                                            <?=$salstructure[0]['ctc_type']=='1'?'selected':'';?>>Day
                                                            Basic</option>
                                                        <option value="2"
                                                            <?=$salstructure[0]['ctc_type']=='2'?'selected':'';?>>Hourly
                                                            Basic</option>
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-3" style="display:none;">
                                                    <label for="esi">CTC Calculation Type</label>
                                                    <select name="basic_cat" id="basic_cat"
                                                        class="form-control input-sm calc_amt">
                                                        <option value="1"
                                                            <?=$salstructure[0]['basic_cat']=='1'?'selected':'';?>>PF
                                                            Only</option>
                                                        <option value="2"
                                                            <?=$salstructure[0]['basic_cat']=='2'?'selected':'';?>>PF &
                                                            ESI</option>
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-3" style="display:none;">
                                                    <label for="bonuspercent">Bonus in ( % )</label>
                                                    <input type="number" name="bonuspercent" id="bonuspercent"
                                                        value="<?=$salstructure[0]['bonuspercent'];?>"
                                                        class="form-control input-sm calc_amt">
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <label for="salaryvalue">CTC Value</label>
                                                    <input type="number" name="salaryvalue" id="salaryvalue"
                                                        value="<?=$salstructure[0]['salaryvalue'];?>"
                                                        class="form-control input-sm calc_amt" step="0.01">
                                                </div>
                                                <div class="form-group col-md-3" style="display:none;">
                                                    <label for="employerpfperc">Employer PF ( in % )</label>
                                                    <input type="number" name="employerpfperc" id="employerpfperc"
                                                        value="<?=$salstructure[0]['employerpfperc'];?>"
                                                        class="form-control input-sm calc_amt" step="0.01">
                                                </div>
                                                <div class="form-group col-md-3" style="display:none;">
                                                    <label for="employeresiperc">Employer ESI ( in % )</label>
                                                    <input type="number" name="employeresiperc" id="employeresiperc"
                                                        value="<?=$salstructure[0]['employeresiperc'];?>"
                                                        class="form-control input-sm calc_amt" step="0.01">
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <label for="grosssalary">Gross Salary</label>
                                                    <input type="number" name="grosssalary" id="grosssalary"
                                                        value="<?=$salstructure[0]['grosssalary'];?>"
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
                                    if ($wages) { for ($i=0; $i <count($wages) ; $i++) {
                                            $wageval = $this->Common_Model->FetchData("salary_structure_items","*","salary_structure_id=".$salstructure[0]['salary_structure_id']." AND wages_id=".$wages[$i]['wages_id']."");

                                     ?>
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
                                                            name="permonth[]" step="0.01" id="permonth"
                                                            value="<?=$wageval[0]['permonth'];?>" readonly>
                                                    </td>
                                                    <td width="15%" class="text-center">
                                                        <input type="number"
                                                            class="form-control input-sm calc_amt perannum "
                                                            name="perannum[]" step="0.01" id="perannum"
                                                            value="<?=$wageval[0]['perannum'];?>" readonly>

                                                    </td>
                                                    <td width="15%" class="text-center">
                                                        <input type="number"
                                                            class="form-control input-sm calc_amt perday "
                                                            name="perday[]" step="0.01" id="perday"
                                                            value="<?=$wageval[0]['perday'];?>" readonly>
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
                                                            value="<?=$salstructure[0]['totdedpermonth'];?>" readonly>
                                                    </td>
                                                    <td width="15%" class="text-center">
                                                        <input type="number"
                                                            class="form-control input-sm calc_amt totdedperannum "
                                                            name="totdedperannum" step="0.01" id="totdedperannum"
                                                            value="<?=$salstructure[0]['totdedperannum'];?>" readonly>

                                                    </td>
                                                    <td width="15%" class="text-center">
                                                        <input type="number"
                                                            class="form-control input-sm calc_amt totdedperday "
                                                            name="totdedperday" step="0.01" id="totdedperday"
                                                            value="<?=$salstructure[0]['totdedperday'];?>" readonly>
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
                                                            value="<?=$salstructure[0]['netsalpermonth'];?>" readonly>
                                                    </td>
                                                    <td width="15%" class="text-center">
                                                        <input type="number"
                                                            class="form-control input-sm calc_amt netsalperannum "
                                                            name="netsalperannum" step="0.01" id="netsalperannum"
                                                            value="<?=$salstructure[0]['netsalperannum'];?>" readonly>

                                                    </td>
                                                    <td width="15%" class="text-center">
                                                        <input type="number"
                                                            class="form-control input-sm calc_amt netsalperday "
                                                            name="netsalperday" step="0.01" id="netsalperday"
                                                            value="<?=$salstructure[0]['netsalperday'];?>" readonly>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                        <div class="box-footer">
                                            <button type="submit" name="submitBtn" value="submit"
                                                class="btn btn-primary">Submit</button>
                                        </div>
                                    </form>

                                </div>
                            </div>
                            <div class="tab-pane" id="advancesalary">
                                <form role="form"
                                    action="<?php echo site_url("employee/advancesalary/").$employee_id;?>"
                                    method="post">
                                    <input type="hidden" value="<?=$employee[0]['emp_mobile'];?>"
                                        name="employee_mobile">
                                    <div class="row">
                                        <div class="box-body">
                                            <div class=" col-md-4">
                                                <div class="form-group">
                                                    <label for="total_amt_taken">Advance Amount</label>
                                                    <input type="text" class="form-control"
                                                        onkeypress="return isDecimal(event);" maxlength="10"
                                                        id="total_amt_taken" onkeyup="return calculatePermonth();"
                                                        name="total_amt_taken" placeholder="Advance Amount Taken"
                                                        required="">
                                                </div>

                                                <div class="form-group">
                                                    <label for="no_of_installment">Total Number Of Installment</label>
                                                    <input type="text" maxlength="2"
                                                        onkeyup="return calculatePermonth();"
                                                        onkeypress="return isNumberKey(event);" class="form-control"
                                                        id="no_of_installment" name="no_of_installment"
                                                        placeholder="Total Number Of Installment" required="">
                                                </div>

                                                <div class="form-group">
                                                    <label for="per_month_instl">Per Month Installment</label>
                                                    <input type="text" readonly="" class="form-control"
                                                        id="per_month_instl" name="per_month_instl"
                                                        placeholder="Per Month Installment">
                                                </div>

                                                <div class="form-group">
                                                    <label for="adv_taken_date">Advance Salary Taken Date</label>
                                                    <input type="date" class="form-control" id="adv_taken_date"
                                                        name="adv_taken_date" placeholder="Advance Salary Taken Date"
                                                        required="">
                                                </div>
                                            </div>
                                            <div class=" col-md-8">
                                                <table class="table table-bordered table-condensed table-striped">
                                                    <tr>
                                                        <th colspan="2">
                                                            Voucher Details
                                                        </th>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <div class="form-group">
                                                                <label for="payment_mode">Payment Mode</label>
                                                                <select class="form-control " id="payment_mode"
                                                                    name="payment_mode" required="required">
                                                                    <option value="Cash">Cash</option>
                                                                    <option value="Cheque">Cheque</option>
                                                                    <option value="Net Banking">Net Banking</option>
                                                                </select>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="form-group">
                                                                <label for="bank_id">Bank</label>
                                                                <select class="form-control" id="bank_id"
                                                                    name="bank_id">
                                                                    <option>select</option>
                                                                    <?php if($banks){ for($i=0;$i<count($banks);$i++){?>
                                                                    <option value="<?php echo $banks[$i]['bank_id'];?>">
                                                                        <?php echo $banks[$i]['bank_name'].' ('.$banks[$i]['account_no'].')';?>
                                                                    </option>
                                                                    <?php }}?>
                                                                </select>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2">
                                                            <table
                                                                class="table table-bordered table-condensed table-striped">
                                                                <tr>
                                                                    <td>
                                                                        <div class="form-group">
                                                                            <label for="cheque_no">Cheque/Receipt
                                                                                No</label>
                                                                            <input type="text"
                                                                                class="form-control nocash"
                                                                                id="cheque_no" name="cheque_no"
                                                                                disabled="disabled" />
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="form-group">
                                                                            <label for="bank_name">Bank Name</label>
                                                                            <input type="text"
                                                                                class="form-control nocash"
                                                                                id="bank_name" name="bank_name"
                                                                                disabled="disabled" />
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="form-group">
                                                                            <label for="bank_branch">Bank Branch</label>
                                                                            <input type="text"
                                                                                class="form-control nocash"
                                                                                id="bank_branch" name="bank_branch"
                                                                                disabled="disabled" />
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                            <div class="form-group">
                                                                <label for="saveandprint"><input type="checkbox"
                                                                        class="" name="saveandprint" value="Yes"> Save
                                                                    and Print the voucher</label>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="remarks">Voucher Remarks</label>
                                                                <textarea class="form-control " id="remarks"
                                                                    name="remarks">Advance Salary <?=date("M Y");?></textarea>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="box-footer">
                                        <button type="submit" name="submitBtn" value="submit"
                                            class="btn btn-primary">Submit</button>
                                    </div>
                                </form>
                                <table id="" class="table table-bordered table-condensed table-striped">
                                    <tr>
                                        <th>ID</th>
                                        <th>Voucher</th>
                                        <th>Amount Taken</th>
                                        <th>Taken On</th>
                                        <th>Per Month Installment</th>
                                        <th>Number Of Installment</th>
                                        <th>Session</th>
                                        <th>Status</th>
                                    </tr>
                                    <?php if($advsals){ for($i=0;$i<count($advsals);$i++){?>
                                    <tr>
                                        <td><?php echo $advsals[$i]['advsal_id'];?></td>
                                        <td>
                                            <?php if($advsals[$i]['voucher_no'] != ''){ ?>
                                            <a href="<?php echo site_url("payments/print_voucher/".$advsals[$i]['voucher_id']);?>"
                                                target="_blank"
                                                class="btn btn-primary btn-xs"><?=$advsals[$i]['voucher_no']?></a>
                                            <?php }?>
                                        </td>
                                        <td><?php echo $advsals[$i]['total_amt_taken'];?></td>
                                        <td><?php echo date("d/m/Y", strtotime($advsals[$i]['adv_taken_date']));?></td>
                                        <td><?php echo $advsals[$i]['per_month_instl'];?></td>
                                        <td><?php echo $advsals[$i]['no_of_installment'];?></td>
                                        <td><?php echo $advsals[$i]['session'];?></td>
                                        <td>
                                            <?php echo ($advsals[$i]['adv_taken_status'] == 0)?'Pending':'Cleared';?>
                                        </td>
                                    </tr>
                                    <?php }}else{ echo '<tr><td colspan = "8"><center>Sorry!! No data found. </center></td></tr>';} ?>
                                </table>
                            </div>
                            <div class="tab-pane" id="salaryslips">
                                <table id="" class="table table-bordered table-condensed table-striped">
                                    <tr>
                                        <th>#Sl No</th>
                                        <th>Month</th>
                                        <th>Year</th>
                                        <th>Session</th>
                                        <th>Paid</th>
                                        <th>Action</th>
                                    </tr>
                                    <?php if($salaryslips){ for($i=0;$i<count($salaryslips);$i++){?>
                                    <tr>
                                        <td><?php echo ($i+1);?></td>
                                        <td><?php echo date('F',strtotime(date('Y-'.$salaryslips[$i]['month'].'-d')));;?>
                                        </td>
                                        <td><?php echo $salaryslips[$i]['year'];?></td>
                                        <td><?php echo $salaryslips[$i]['session'];?></td>
                                        <td><?php echo $salaryslips[$i]['credit_status'] == 0 ? '' : 'Yes';?></td>
                                        <td><?php if($salaryslips[$i]['credit_status'] == 0){ if(strtotime(date('Y-m')) > strtotime(date($salaryslips[$i]['year'].'-'.$salaryslips[$i]['month']))){?><a
                                                href="<?php echo site_url("employee/salarycalculate/".$salaryslips[$i]['transaction_id'].'/'.$employee_id.'/'.$salaryslips[$i]['month'].'/'.$salaryslips[$i]['year']);?>"
                                                class="btn btn-xs btn-success">Review &
                                                Pay</a><?php }else{ echo '---';} }else{ ?> <a
                                                href="<?php echo site_url("employee/pdfsalaryreceipt/".$salaryslips[$i]['transaction_id'].'/'.$employee_id.'/'.$salaryslips[$i]['month'].'/'.$salaryslips[$i]['year']);?>"
                                                target="_blank" class="btn btn-xs btn-warning">Download</a> | <a
                                                href="<?php echo site_url("employee/viewsalaryreceipt/".$salaryslips[$i]['transaction_id'].'/'.$employee_id.'/'.$salaryslips[$i]['month'].'/'.$salaryslips[$i]['year']);?>"
                                                class="btn btn-xs btn-default">View Receipt</a>' <?php } ?></td>
                                    </tr>
                                    <?php }} ?>
                                </table>
                            </div>
                            <div class="tab-pane" id="logincredentials">
                                <?php if ($user) {?>
                                <form role="form"
                                    action="<?php echo site_url("employee/edituserdetails/".$user[0]['user_id']."/".$employee[0]['employee_id']);?>"
                                    method="post">
                                    <div class="box-body">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="username">Username</label>
                                                    <input type="text" class="form-control input-sm" id="username"
                                                        name="username" placeholder="Enter Username" required="required"
                                                        value="<?php echo $user[0]['username'];?>">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="password">Password</label>
                                                    <input type="password" class="form-control input-sm" id="password"
                                                        name="password" placeholder="Enter Password to change">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="usertype">User Type</label>
                                                    <select class="form-control input-sm" id="usertype" name="usertype">

                                                        <option value="Others"
                                                            <?php echo $user[0]['usertype'] == 'Others' ? 'selected="selected"' : '';?>>
                                                            Others</option>
                                                        <option value="Admin"
                                                            <?php echo $user[0]['usertype'] == 'Admin' ? 'selected="selected"' : '';?>>
                                                            Admin</option>
                                                        <option value="HR"
                                                            <?php echo $user[0]['usertype'] == 'HR' ? 'selected="selected"' : '';?>>
                                                            HR</option>
                                                        <option value="Accounts"
                                                            <?php echo $user[0]['usertype'] == 'Accounts' ? 'selected="selected"' : '';?>>
                                                            Accounts</option>
                                                        <option value="Employee"
                                                            <?php echo $user[0]['usertype'] == 'Employee' ? 'selected="selected"' : '';?>>
                                                            Employee</option>
                                                        <option value="Manager"
                                                            <?php echo $user[0]['usertype'] == 'Manager' ? 'selected="selected"' : '';?>>
                                                            Manager</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="access_id">User Access</label>
                                                    <select class="form-control input-sm" id="access_id"
                                                        name="access_id">
                                                        <option value="">select</option>
                                                        <?php if($access){ for($i=0;$i<count($access);$i++){?>
                                                        <option value="<?php echo $access[$i]['access_id'];?>"
                                                            <?php echo $user[0]['access_id'] == $access[$i]['access_id'] ? 'selected="selected"' : '';?>>
                                                            <?php echo $access[$i]['access_name'];?></option>
                                                        <?php }} ?>
                                                    </select>
                                                </div>
                                            </div>

                                        </div>

                                    </div>
                                    <div class="box-footer">
                                        <button type="submit" name="submitBtn" value="submit"
                                            class="btn btn-primary">Update</button>
                                    </div>
                                </form>
                                <?php } ?>
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
$("#remarks").keydown(function(event) {
    console.log(this.selectionStart);
    console.log(event);
    if (event.keyCode == 8) {
        this.selectionStart--;
    }
    if (this.selectionStart < 23) {
        this.selectionStart = 23;
        console.log(this.selectionStart);
        event.preventDefault();
    }
});
$("#remarks").keyup(function(event) {
    console.log(this.selectionStart);
    if (this.selectionStart < 23) {
        this.selectionStart = 23;
        console.log(this.selectionStart);
        event.preventDefault();
    }
});

$(document).ready(function() {
    $("#payment_mode").change(function(e) {
        e.preventDefault();
        if ($(this).val() == 'Cheque' || $(this).val() == 'Net Banking' || $(this).val() ==
            'Bank Deposite' || $(this).val() == 'Bank Withdraw') {
            $(".nocash").removeAttr("disabled");
        } else {
            $(".nocash").attr("disabled", "disabled");
        }
    });
});

function calculatePermonth() {
    var totalTaken = $('#total_amt_taken').val();
    var noOfinst = $('#no_of_installment').val();
    if (parseInt(totalTaken) > 0 && parseInt(noOfinst) > 0) {
        var permonth = parseInt(totalTaken) / parseInt(noOfinst);
        $('#per_month_instl').val(parseFloat(permonth).toFixed(2));
    }
}

function disableBtn() {
    $('#leavesubmitBtn').attr('disabled', true);
}

function checkLeaveavail() {
    if ($('#leave_type').val() == '') {
        alert('Please select Leave Type.');
        $('#leave_type').focus();
        return false;
    }

    if ($('#apply_from').val() == '') {
        alert('Please select Leave From Date');
        $('#apply_from').focus();
        return false;
    }

    if ($('#apply_to').val() == '') {
        alert('Please select Leave To Date');
        $('#apply_to').focus();
        return false;
    }

    var leave_type = $('#leave_type').val();
    var employeeId = '<?=$employee_id?>';
    var curSession = '<?=$curSession?>';
    var apply_from = $('#apply_from').val();
    var apply_to = $('#apply_to').val();
    var hfday = $('#hfday').val();
    $.ajax({
        method: 'post',
        url: appUrl + '/Ajax_requests/checkLeaveavail',
        dataType: 'json',
        data: {
            leave_type: leave_type,
            employeeId: employeeId,
            curSession: curSession,
            apply_from: apply_from,
            apply_to: apply_to,
            hfday: hfday
        },
        success: function(res) {
            if (res.status === 500) {
                alert(res.msg);
                $('#apply_from').focus();
            } else {
                var result = res.result;
                var leaveType = result[0]['leave_type'];
                var leaveCount = result[0]['leaveleft'];
                var dayDiffer = res.daysDiff;

                $('#no_of_days').val(dayDiffer);
                $('.leavecount').html('<b><i>You have ' + leaveCount + ' leave left for ' + leaveType +
                    ' Category</i></b>');

                if (parseInt(dayDiffer) > parseInt(leaveCount)) {
                    alert(
                        'Sorry You do not have sufficient leave for the selected Category and date range.');
                } else {
                    $('#leavesubmitBtn').attr('disabled', false);
                }
            }
        }
    });
}

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
</script>
</body>

</html>