<?php $this->load->view("common/meta");?>
<div class="wrapper">

    <?php $this->load->view("common/sidebar");?>

    <div class="content-wrapper">
        <section class="content-header">
            <h1>
                Employees <small>Mediclaim</small>
            </h1>
        </section>
        <section class="content">
            <form role="form" action="<?php echo site_url("employee/mediclaim/".$employee['employee_id']);?>"
                method="post">
                <input type="hidden" name="employee_id" value="<?= $employee['employee_id']; ?>">
                <div class="row">
                    <div class="col-md-12"
                        style="margin-top:15px;border: 1px solid #ddd;padding: 14px;border-radius: 5px;">

                        <div class="icon icon-lg icon-shape" style="margin-top: -25px!important;">
                            <span
                                style="background-color: white;width: 180px;font-size: 12px;padding-left: 4px;padding-right: 4px;">
                                Employee Mediclaim Form
                            </span>
                        </div>

                        <div class="row">

                            <!-- LEFT SIDE -->
                            <div class="col-md-6">

                                <!-- Name -->
                                <div class="form-group">
                                    <label>Name</label>
                                    <input type="text" class="form-control input-sm"
                                        value="<?= $employee['emp_firstname'].' '.$employee['emp_middlename'].' '.$employee['emp_lastname']; ?>"
                                        readonly>
                                </div>

                                <!-- DOB -->
                                <div class="form-group">
                                    <label>DOB</label>
                                    <input type="date" class="form-control input-sm"
                                        value="<?= $employee['emp_dob']; ?>" readonly>
                                </div>

                                <!-- Employee ID -->
                                <div class="form-group">
                                    <label>Employee ID</label>
                                    <input type="text" class="form-control input-sm"
                                        value="<?= $employee['techno_emp_id']; ?>" readonly>
                                </div>

                                <!-- Designation -->
                                <div class="form-group">
                                    <label>Designation</label>
                                    <input type="text" class="form-control input-sm"
                                        value="<?= $designation['designation_name']; ?>" readonly>
                                </div>

                                <!-- Date of Joining -->
                                <div class="form-group">
                                    <label>Date of Joining</label>
                                    <input type="date" class="form-control input-sm"
                                        value="<?= $employee['emp_doj']; ?>" readonly>
                                </div>

                                <!-- Sum Insured -->
                                <div class="form-group">
                                    <label>Sum Insured</label>
                                    <input type="text" class="form-control input-sm" name="sum_insured"
                                        placeholder="Enter sum insured amount" value="<?= $medical['sum_insured']; ?>">
                                </div>

                            </div>


                            <!-- RIGHT SIDE -->
                            <div class="col-md-6">

                                <!-- Nominee Section -->
                                <h5><strong>Nominee for Insurance</strong></h5>

                                <div class="form-group">
                                    <label>Name</label>
                                    <input type="text" class="form-control input-sm" name="nominee_name"
                                        value="<?= $medical['nominee_name']; ?>">
                                </div>

                                <div class="form-group">
                                    <label>Relation</label>
                                    <select name="nominee_relation" class="form-control input-sm">
                                        <option value="">-- Select Relation --</option>
                                        <option value="Spouse"
                                            <?= ($medical['nominee_relation'] == 'Spouse') ? 'selected' : '' ?>>Spouse
                                        </option>
                                        <option value="Son"
                                            <?= ($medical['nominee_relation'] == 'Son') ? 'selected' : '' ?>>Son
                                        </option>
                                        <option value="Daughter"
                                            <?= ($medical['nominee_relation'] == 'Daughter') ? 'selected' : '' ?>>
                                            Daughter</option>
                                        <option value="Father"
                                            <?= ($medical['nominee_relation'] == 'Father') ? 'selected' : '' ?>>Father
                                        </option>
                                        <option value="Mother"
                                            <?= ($medical['nominee_relation'] == 'Mother') ? 'selected' : '' ?>>Mother
                                        </option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>DOB</label>
                                    <input type="date" class="form-control input-sm" name="nominee_dob"
                                        value="<?= $medical['nominee_dob']; ?>">
                                </div>

                            </div>

                        </div>


                        <hr>

                        <!-- Family Members -->
                        <hr>

                        <h5><strong>Family Members to be Included</strong></h5>
                        <small>(Spouse, Children, Parents — list with DOB)</small>

                        <div id="familyContainer">

                            <?php 
                                if (!empty($medical['family_members'])) {
                                    foreach ($medical['family_members'] as $index => $family) {
                                ?>
                            <div class="row familyRow" style="margin-top:10px;">
                                <div class="col-md-4">
                                    <input type="text" name="family_name[]" class="form-control input-sm"
                                        value="<?= $family['name']; ?>" placeholder="Name">
                                </div>

                                <div class="col-md-4">
                                    <select name="family_relation[]" class="form-control input-sm">
                                        <option value="">-- Select Relation --</option>
                                        <option value="Spouse" <?= ($family['relation']=='Spouse')?'selected':''; ?>>
                                            Spouse</option>
                                        <option value="Son" <?= ($family['relation']=='Son')?'selected':''; ?>>Son
                                        </option>
                                        <option value="Daughter"
                                            <?= ($family['relation']=='Daughter')?'selected':''; ?>>Daughter</option>
                                        <option value="Father" <?= ($family['relation']=='Father')?'selected':''; ?>>
                                            Father</option>
                                        <option value="Mother" <?= ($family['relation']=='Mother')?'selected':''; ?>>
                                            Mother</option>
                                    </select>
                                </div>

                                <div class="col-md-3">
                                    <input type="date" name="family_dob[]" class="form-control input-sm"
                                        value="<?= $family['dob']; ?>">
                                </div>

                                <div class="col-md-1 text-center">
                                    <?php if ($index == 0) { ?>
                                    <button type="button" class="btn btn-success btn-sm addRow">+</button>
                                    <?php } else { ?>
                                    <button type="button" class="btn btn-danger btn-sm removeRow">-</button>
                                    <?php } ?>
                                </div>
                            </div>
                            <?php 
                                    }
                                } else {
                                ?>
                            <div class="row familyRow" style="margin-top:10px;">
                                <div class="col-md-4">
                                    <input type="text" name="family_name[]" class="form-control input-sm"
                                        placeholder="Name">
                                </div>

                                <div class="col-md-4">
                                    <select name="family_relation[]" class="form-control input-sm">
                                        <option value="">-- Select Relation --</option>
                                        <option value="Spouse">Spouse</option>
                                        <option value="Son">Son</option>
                                        <option value="Daughter">Daughter</option>
                                        <option value="Father">Father</option>
                                        <option value="Mother">Mother</option>
                                    </select>
                                </div>

                                <div class="col-md-3">
                                    <input type="date" name="family_dob[]" class="form-control input-sm">
                                </div>

                                <div class="col-md-1 text-center">
                                    <button type="button" class="btn btn-success btn-sm addRow">+</button>
                                </div>
                            </div>
                            <?php } ?>

                        </div>

                        <hr>

                        <!-- Medical Declaration -->
                        <h5><strong>Medical Declaration</strong></h5>

                        <div class="form-group">
                            <label>Are you / any family member suffering from any pre-existing illness?</label><br>

                            <label class="radio-inline">
                                <input type="radio" name="medical_issue" value="No" checked> No
                            </label>

                            <label class="radio-inline">
                                <input type="radio" name="medical_issue" value="Yes"> Yes
                            </label>
                        </div>

                        <div class="form-group">
                            <label>If Yes, give details</label>
                            <textarea class="form-control input-sm" name="medical_details"
                                rows="3"><?= $medical['medical_details']; ?></textarea>
                        </div>

                    </div>

                </div>
                <div class="text-center" style="margin-top:20px;">
                    <button type="submit" class="btn btn-primary" name="save_print">
                        Save & Print
                    </button>

                </div>
            </form>
        </section>
    </div>
    <?php $this->load->view("common/footer");?>
</div>
<?php $this->load->view("common/script");?>

<script>
$(document).on('click', '.addRow', function() {

    var newRow = `
    <div class="row familyRow" style="margin-top:10px;">
        <div class="col-md-4">
            <input type="text" name="family_name[]" class="form-control input-sm" placeholder="Name">
        </div>

        <div class="col-md-4">
            <select name="family_relation[]" class="form-control input-sm">
                <option value="">-- Select Relation --</option>
                <option value="Spouse">Spouse</option>
                <option value="Son">Son</option>
                <option value="Daughter">Daughter</option>
                <option value="Father">Father</option>
                <option value="Mother">Mother</option>
            </select>
        </div>

        <div class="col-md-3">
            <input type="date" name="family_dob[]" class="form-control input-sm">
        </div>

        <div class="col-md-1 text-center">
            <button type="button" class="btn btn-danger btn-sm removeRow">-</button>
        </div>
    </div>`;

    $('#familyContainer').append(newRow);
});


$(document).on('click', '.removeRow', function() {
    $(this).closest('.familyRow').remove();
});
</script>

</body>

</html>