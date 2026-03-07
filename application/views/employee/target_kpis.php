<?php $this->load->view("common/meta"); ?>
<div class="wrapper">

    <?php $this->load->view("common/sidebar"); ?>

    <div class="content-wrapper">

        <section class="content-header">
            <h1>Employees <small>Collections Targets & KPIs</small></h1>
        </section>

        <section class="content">

            <?php if ($this->session->flashdata('success')): ?>
            <div class="alert alert-success">
                <?= $this->session->flashdata('success'); ?>
            </div>
            <?php endif; ?>

            <div class="box box-primary">
                <form method="post" action="<?= site_url('employee/target_kpis/'.$employee->employee_id); ?>">

                    <div class="box-body">

                        <h4><b>Employee Details</b></h4>
                        <div class="row">

                            <div class="col-md-4 form-group">
                                <label>Employee Name</label>
                                <input type="text" class="form-control"
                                    value="<?= $employee->emp_firstname.' '.$employee->emp_middlename.' '.$employee->emp_lastname; ?>"
                                    readonly>
                            </div>

                            <div class="col-md-4 form-group">
                                <label>Designation</label>
                                <input type="text" class="form-control"
                                    value="<?= $designation->designation_name ?? '' ?>" readonly>
                            </div>

                            <div class="col-md-4 form-group">
                                <label>Team / Region</label>
                                <input type="text" name="team_region" class="form-control"
                                    value="<?= isset($target->team_region) ? $target->team_region : ''; ?>">
                            </div>

                        </div>

                        <hr>

                        <h4><b>Monthly Targets (INR)</b></h4>

                        <div class="row">

                            <div class="col-md-4 form-group">
                                <label>Gross Target</label>
                                <input type="number" step="0.01" name="gross_target" class="form-control"
                                    value="<?= isset($target->gross_target) ? $target->gross_target : ''; ?>">
                            </div>

                            <div class="col-md-4 form-group">
                                <label>Realization Target</label>
                                <input type="number" step="0.01" name="realization_target" class="form-control"
                                    value="<?= isset($target->realization_target) ? $target->realization_target : ''; ?>">
                            </div>

                            <div class="col-md-4 form-group">
                                <label>New Accounts to be Contacted</label>
                                <input type="number" name="new_accounts" class="form-control"
                                    value="<?= isset($target->new_accounts) ? $target->new_accounts : ''; ?>">
                            </div>

                        </div>

                        <hr>

                        <h4><b>KPIs</b></h4>

                        <div class="row">

                            <div class="col-md-4 form-group">
                                <label>Calls made per day</label>
                                <input type="number" name="calls_per_day" class="form-control"
                                    value="<?= isset($target->calls_per_day) ? $target->calls_per_day : ''; ?>">
                            </div>

                            <div class="col-md-4 form-group">
                                <label>Field visits per week</label>
                                <input type="number" name="field_visits_per_week" class="form-control"
                                    value="<?= isset($target->field_visits_per_week) ? $target->field_visits_per_week : ''; ?>">
                            </div>

                            <div class="col-md-4 form-group">
                                <label>Promise-to-pay commitments</label>
                                <input type="number" name="ptp_commitments" class="form-control"
                                    value="<?= isset($target->ptp_commitments) ? $target->ptp_commitments : ''; ?>">
                            </div>

                            <div class="col-md-4 form-group">
                                <label>Recovery Rate (%)</label>
                                <input type="number" step="0.01" name="recovery_rate" class="form-control"
                                    value="<?= isset($target->recovery_rate) ? $target->recovery_rate : ''; ?>">
                            </div>

                            <div class="col-md-4 form-group">
                                <label>Resolution Time (Days)</label>
                                <input type="number" name="resolution_time" class="form-control"
                                    value="<?= isset($target->resolution_time) ? $target->resolution_time : ''; ?>">
                            </div>

                            <div class="col-md-4 form-group">
                                <label>Custodian Compliance (%)</label>
                                <input type="number" step="0.01" name="custodian_compliance" class="form-control"
                                    value="<?= isset($target->custodian_compliance) ? $target->custodian_compliance : ''; ?>">
                            </div>

                        </div>

                        <hr>

                        <h4><b>Incentive Structure</b></h4>

                        <div class="row">

                            <div class="col-md-4 form-group">
                                <label>Achievement ≥ 90% (Incentive %)</label>
                                <input type="text" name="incentive_90" class="form-control"
                                    value="<?= isset($target->incentive_90) ? $target->incentive_90 : ''; ?>">
                            </div>

                            <div class="col-md-4 form-group">
                                <label>Achievement ≥ 100% (Incentive + Bonus)</label>
                                <input type="text" name="incentive_100" class="form-control"
                                    value="<?= isset($target->incentive_100) ? $target->incentive_100 : ''; ?>">
                            </div>

                            <div class="col-md-4 form-group">
                                <label>Team / Individual Bonus Details</label>
                                <input type="text" name="bonus_details" class="form-control"
                                    value="<?= isset($target->bonus_details) ? $target->bonus_details : ''; ?>">
                            </div>

                        </div>

                        <hr>

                        <h4><b>Work Plan / Handover Template</b></h4>

                        <div class="form-group">
                            <label>Daily Call Log Format</label>
                            <textarea name="daily_call_log" class="form-control"
                                rows="3"><?= isset($target->daily_call_log) ? $target->daily_call_log : ''; ?></textarea>
                        </div>

                        <div class="form-group">
                            <label>Daily Field Visit Report</label>
                            <textarea name="daily_field_visit" class="form-control"
                                rows="3"><?= isset($target->daily_field_visit) ? $target->daily_field_visit : ''; ?></textarea>
                        </div>

                        <div class="form-group">
                            <label>Weekly Status Report Structure</label>
                            <textarea name="weekly_status" class="form-control"
                                rows="3"><?= isset($target->weekly_status) ? $target->weekly_status : ''; ?></textarea>
                        </div>

                        <div class="form-group">
                            <label>Payment Receipt & Acknowledgment Format</label>
                            <textarea name="payment_format" class="form-control"
                                rows="3"><?= isset($target->payment_format) ? $target->payment_format : ''; ?></textarea>
                        </div>

                    </div>

                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary">Save / Update</button>
                        <a href="<?= site_url('employee'); ?>" class="btn btn-default">Back</a>
                    </div>

                </form>
            </div>

        </section>
    </div>

    <?php $this->load->view("common/footer"); ?>
</div>

<?php $this->load->view("common/script"); ?>
</body>

</html>