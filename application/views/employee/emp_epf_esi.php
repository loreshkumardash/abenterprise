<?php $this->load->view("common/meta");?>
<div class="wrapper">

    <?php $this->load->view("common/sidebar");?>

    <div class="content-wrapper">
        <section class="content-header">
            <h1>Employees <small>EPF & ESI Enrollment</small></h1>
        </section>

        <section class="content">
            <form method="post" action="<?= site_url('employee/emp_epf_esi/'.$employee->employee_id); ?>">
                <input type="hidden" name="employee_id" value="<?= $employee->employee_id ?>">

                <div class="box box-primary">
                    <div class="box-body">
                        <h4>Employee Details</h4>

                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Name:</strong>
                                    <?= $employee->emp_firstname.' '.$employee->emp_middlename.' '.$employee->emp_lastname ?>
                                </p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>DOB:</strong> <?= $employee->emp_dob ?></p>
                            </div>

                            <div class="col-md-6">
                                <p><strong>DOJ:</strong> <?= $employee->emp_doj ?></p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Designation:</strong> <?= $designation->designation_name ?? '' ?></p>
                            </div>
                        </div>

                        <hr>
                        <h4>EPF Enrollment</h4>

                        <div class="row">

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Father / Spouse Name</label>
                                    <input type="text" class="form-control" name="father_spouse_name"
                                        value="<?= $employee->emp_fathername ?? '' ?>" readonly>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Gender</label>
                                    <input type="text" class="form-control" name="gender"
                                        value="<?= $employee->emp_gender ?? '' ?>" readonly>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>UAN</label>
                                    <input type="text" class="form-control" name="uan"
                                        value="<?= $pf->pf_number ?? '' ?>">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Aadhaar</label>
                                    <input type="text" class="form-control" name="aadhaar"
                                        value="<?= $docs->kyc_adharno ?? '' ?>" readonly>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>PAN</label>
                                    <input type="text" class="form-control" name="pan"
                                        value="<?= $docs->kyc_panno ?? '' ?>" readonly>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Basic Salary</label>
                                    <input type="text" class="form-control" name="basic_salary"
                                        value="<?= $pf->basic_salary ?? '' ?>">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>PF Rate</label>
                                    <input type="text" class="form-control" name="pf_rate" value="12%" readonly>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Bank Account</label>
                                    <input type="text" class="form-control" name="bank_account"
                                        value="<?= $docs->st_acno ?? '' ?>" readonly>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>IFSC</label>
                                    <input type="text" class="form-control" name="ifsc"
                                        value="<?= $docs->st_ifsc ?? '' ?>" readonly>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Pension Nominee 1</label>
                                            <div class="form-group">
                                                <label>Name</label>
                                                <input type="text" class="form-control input-sm" name="nominee1_name"
                                                    value="<?= $pf->nominee1_name ?? '' ?>">
                                            </div>

                                            <div class="form-group">
                                                <label>Relation</label>
                                                <select name="nominee1_relation" class="form-control input-sm">
                                                    <option value="">None</option>

                                                    <?php 
                                                        $relations = ['Spouse','Son','Daughter','Father','Mother','Brother','Sister'];

                                                        foreach($relations as $relation){ 
                                                         $selected = (!empty($pf->nominee1_relation) && $pf->nominee1_relation == $relation) ? 'selected' : '';
                                                         echo '<option value="'.$relation.'" '.$selected.'>'.$relation.'</option>';
                                                     }
                                                        ?>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>Age</label>
                                                <input type="number" class="form-control input-sm" name="nominee1_age"
                                                    value="<?= $pf->nominee1_age ?? '' ?>">
                                            </div>
                                            <div class="form-group">
                                                <label>Share</label>
                                                <input type="number" class="form-control input-sm" name="nominee1_share"
                                                    value="<?= $pf->nominee1_share ?? '' ?>">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Pension Nominee 2</label>
                                            <div class="form-group">
                                                <label>Name</label>
                                                <input type="text" class="form-control input-sm" name="nominee2_name"
                                                    value="<?= $pf->nominee2_name ?? '' ?>">
                                            </div>

                                            <div class="form-group">
                                                <label>Relation</label>
                                                <select name="nominee2_relation" class="form-control input-sm">
                                                    <option value="">None</option>

                                                    <?php 
                                                        $relations = ['Spouse','Son','Daughter','Father','Mother','Brother','Sister'];

                                                        foreach($relations as $relation){ 
                                                            $selected = (!empty($pf->nominee2_relation) && $pf->nominee2_relation == $relation) ? 'selected' : '';
                                                            echo '<option value="'.$relation.'" '.$selected.'>'.$relation.'</option>';
                                                        }
                                                        ?>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>Age</label>
                                                <input type="number" class="form-control input-sm" name="nominee2_age"
                                                    value="<?= $pf->nominee2_age ?? '' ?>">
                                            </div>
                                            <div class="form-group">
                                                <label>Share</label>
                                                <input type="number" class="form-control input-sm" name="nominee2_share"
                                                    value="<?= $pf->nominee2_share ?? '' ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <hr>
                        <h4>ESI Enrollment</h4>

                        <div class="row">

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Present Address</label>
                                    <input type="text" class="form-control" readonly
                                        value="AT: <?= $employee->emp_at ?? '' ?> | PO: <?= $employee->emp_po ?? '' ?> | <?= $employee->emp_landmark ?? '' ?> - <?= $employee->emp_curpin ?? '' ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Gross Wages</label>
                                    <input type="number" class="form-control" name="gross_wages" step="0.01"
                                        value="<?= $pf->gross_wages ?? '' ?>">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>ESI Contribution</label>
                                    <input type="number" class="form-control" name="esi_contribution" step="0.01"
                                        value="<?= $pf->esi_contribution ?? '' ?>">
                                </div>
                            </div>

                        </div>

                    </div>

                    <div class="box-footer text-center">
                        <button type="submit" class="btn btn-primary btn-lg">
                            Save & Print
                        </button>
                    </div>

                </div>

            </form>
        </section>
    </div>

    <?php $this->load->view("common/footer");?>
</div>

<?php $this->load->view("common/script");?>
</body>

</html>