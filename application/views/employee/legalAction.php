<?php $this->load->view("common/meta"); ?>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">

<div class="wrapper">
    <?php $this->load->view("common/sidebar"); ?>

    <div class="content-wrapper">
        <section class="content-header">
            <h1>Disciplinary & Legal Action</h1>
        </section>

        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-primary">

                        <div class="box-header with-border">
                            <h3 class="box-title">Incident Report & HR Decision</h3>
                        </div>

                        <div class="box-body">

                            <?php if($this->session->flashdata('success')){ ?>
                            <div class="alert alert-success">
                                <?= $this->session->flashdata('success'); ?>
                            </div>
                            <?php } ?>

                            <form action="<?= base_url('employee/legalAction'); ?>" method="post"
                                enctype="multipart/form-data">

                                <h4><b>Incident Report</b></h4>
                                <hr>

                                <div class="row">

                                    <div class="col-md-6">
                                        <label>Date of Incident</label>
                                        <input type="date" name="incident_date" class="form-control" required>
                                    </div>

                                    <div class="col-md-6">
                                        <label>Location</label>
                                        <input type="text" name="location" class="form-control">
                                    </div>

                                    <div class="col-md-6">
                                        <label>Reported By (Name)</label>
                                        <input type="text" id="reporter_search" class="form-control"
                                            placeholder="Type Name or ID">
                                        <input type="hidden" name="reporter_id" id="reporter_id">
                                    </div>

                                    <div class="col-md-6">
                                        <label>Designation</label>
                                        <input type="text" id="reporter_designation" class="form-control" readonly>
                                    </div>

                                    <div class="col-md-6">
                                        <label>Employee Involved (Name / ID)</label>
                                        <input type="text" id="emp_search" class="form-control"
                                            placeholder="Type Name or ID">
                                        <input type="hidden" name="emp_involved_id" id="emp_involved_id">
                                    </div>

                                    <div class="col-md-6">
                                        <label>Policy / Rule Violated</label>
                                        <input type="text" name="policy_violated" class="form-control">
                                    </div>

                                    <div class="col-md-12">
                                        <label>Description of Incident</label>
                                        <textarea name="incident_description" class="form-control" rows="4"></textarea>
                                    </div>

                                </div>

                                <div class="row" style="margin-top:15px;">
                                    <div class="col-md-12">
                                        <label>Witnesses (Name & Contact)</label>

                                        <div id="witnessWrapper">
                                            <div class="row witnessRow" style="margin-bottom:8px;">
                                                <div class="col-md-5">
                                                    <input type="text" name="witness_name[]" placeholder="Witness Name"
                                                        class="form-control">
                                                </div>
                                                <div class="col-md-5">
                                                    <input type="text" name="witness_contact[]"
                                                        placeholder="Contact Number" class="form-control">
                                                </div>
                                                <div class="col-md-2">
                                                    <button type="button" class="btn btn-success addWitness">+</button>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Evidence Attachments</label>
                                        <input type="file" name="evidence_files[]" multiple class="form-control">
                                    </div>

                                    <div class="col-md-6">
                                        <label>Action Recommended</label>
                                        <textarea name="recommended_action" class="form-control"></textarea>
                                    </div>
                                </div>

                                <h4 style="margin-top:25px;"><b>HR / Management Decision</b></h4>
                                <hr>

                                <div class="row">

                                    <div class="col-md-6">
                                        <label>Date</label>
                                        <input type="text" value="<?= date('d-m-Y'); ?>" class="form-control" readonly>
                                    </div>

                                    <div class="col-md-6">
                                        <label>Disciplinary Action</label>
                                        <select name="disciplinary_action" class="form-control">
                                            <option value="">-- Select --</option>
                                            <option>Warning</option>
                                            <option>Suspension</option>
                                            <option>Termination</option>
                                            <option>Legal Notice</option>
                                        </select>
                                    </div>

                                    <div class="col-md-6">
                                        <label>Investigation Summary</label>
                                        <textarea name="investigation_summary" class="form-control"></textarea>
                                    </div>

                                    <div class="col-md-6">
                                        <label>Findings</label>
                                        <textarea name="findings" class="form-control"></textarea>
                                    </div>

                                    <div class="col-md-6">
                                        <label>Recovery / Financial Penalty</label>
                                        <input type="text" name="financial_penalty" class="form-control">
                                    </div>

                                    <div class="col-md-6">
                                        <label>Appeal Process & Timeline</label>
                                        <textarea name="appeal_process" class="form-control"></textarea>
                                    </div>

                                </div>

                                <div class="text-center" style="margin-top:20px;">
                                    <button type="submit" class="btn btn-primary" name="submit" value="1">
                                        Submit
                                    </button>
                                </div>
                            </form>

                            <hr>
                            <h4><b>Legal Action Records</b></h4>

                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead style="background:#f4f4f4;">
                                        <tr>
                                            <th>#</th>
                                            <th>Employee Name</th>
                                            <th>Date of Incident</th>
                                            <th>Disciplinary Action</th>
                                            <th>Print</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if(!empty($legal_actions)) { 
                $i = 1;
                foreach($legal_actions as $row) { ?>
                                        <tr>
                                            <td><?= $i++; ?></td>
                                            <td><?= htmlspecialchars($row->employee_name); ?></td>
                                            <td><?= date('d-m-Y', strtotime($row->incident_date)); ?></td>
                                            <td><?= htmlspecialchars($row->disciplinary_action); ?></td>
                                            <td>
                                                <a href="<?= base_url('employee/printLegalAction/'.$row->legal_action_id); ?>"
                                                    class="btn btn-primary btn-sm" target="_blank">
                                                    Print
                                                </a>
                                            </td>
                                        </tr>
                                        <?php } 
            } else { ?>
                                        <tr>
                                            <td colspan="5" class="text-center">No Records Found</td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <?php $this->load->view("common/footer"); ?>
    <?php $this->load->view("common/script"); ?>

    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>

    <script>
    // Witness Add Remove
    $(document).on('click', '.addWitness', function() {
        let row = `
<div class="row witnessRow" style="margin-bottom:8px;">
<div class="col-md-5">
<input type="text" name="witness_name[]" 
placeholder="Witness Name" class="form-control">
</div>
<div class="col-md-5">
<input type="text" name="witness_contact[]" 
placeholder="Contact Number" class="form-control">
</div>
<div class="col-md-2">
<button type="button" class="btn btn-danger removeWitness">-</button>
</div>
</div>`;
        $('#witnessWrapper').append(row);
    });

    $(document).on('click', '.removeWitness', function() {
        $(this).closest('.witnessRow').remove();
    });

    function setupAutocomplete(inputId, hiddenId, designationField = null) {

        $('#' + inputId).autocomplete({

            source: function(request, response) {
                $.ajax({
                    url: "<?= base_url('employee/searchEmployee'); ?>",
                    type: "POST",
                    dataType: "json",
                    data: {
                        keyword: request.term
                    },
                    success: function(data) {
                        response(data);
                    }
                });
            },

            minLength: 2,

            select: function(event, ui) {

                $('#' + inputId).val(ui.item.label);
                $('#' + hiddenId).val(ui.item.emp_id);

                if (designationField !== null) {
                    $('#' + designationField).val(ui.item.designation);
                }

                return false;
            },

            change: function(event, ui) {
                if (!ui.item) {
                    $('#' + inputId).val('');
                    $('#' + hiddenId).val('');
                    if (designationField !== null) {
                        $('#' + designationField).val('');
                    }
                }
            }

        });
    }

    $(document).ready(function() {
        setupAutocomplete('reporter_search', 'reporter_id', 'reporter_designation');
        setupAutocomplete('emp_search', 'emp_involved_id');
    });
    </script>

    </body>

    </html>