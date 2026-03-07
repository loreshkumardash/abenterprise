<?php
$emp  = $employee;
$bank = $bank;

$fullname = $emp['emp_firstname'].' '.$emp['emp_middlename'].' '.$emp['emp_lastname'];
$today = date('d-m-Y');
?>

<style>
body {
    font-family: helvetica;
    font-size: 11px;
    line-height: 1.6;
}

.title {
    font-size: 14px;
    font-weight: bold;
    text-align: center;
    margin-bottom: 15px;
}

.subtitle {
    font-weight: bold;
    margin-top: 15px;
    margin-bottom: 8px;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 10px;
}

table.data-table td {
    border: 1px solid #000;
}

.label {
    width: 35%;
    font-weight: bold;
}

.signature-table td {
    border: none;
    padding-top: 40px;
}

.note {
    font-size: 9px;
    margin-top: 20px;
}


.noborder {
    border: none !important;
}
</style>

<table class="no-border" width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:25px; font-size:12px;">
    <tr>
        <td width="50%" align="left">
            <strong>Ref.:</strong> ___________________________
        </td>
        <td width="50%" align="right">
            <strong>Date:</strong> <?= date('d/m/Y'); ?>
        </td>
    </tr>
</table>

<div style="margin-top:8px;"></div>

<div class="title">
    BLANK CHEQUE FOR SECURITY & ACKNOWLEDGEMENT
</div>

<p>
    <strong>Instruction to Candidate:</strong>
    Please provide a cancelled / blank cheque from your bank for salary & KYC purposes.
    This will be kept safely and used only for salary disbursement and recovery
    (if applicable) after written notice.
</p>

<div class="subtitle">Cheque Acknowledgement Form</div>

<table class="data-table">
    <tr>
        <td class="label">Employee Name</td>
        <td><?= $fullname; ?></td>
    </tr>

    <tr>
        <td class="label">Bank Name</td>
        <td><?= !empty($bank['st_bankname']) ? $bank['st_bankname'] : ''; ?></td>
    </tr>

    <tr>
        <td class="label">Account No</td>
        <td><?= !empty($bank['st_acno']) ? $bank['st_acno'] : ''; ?></td>
    </tr>

    <tr>
        <td class="label">IFSC</td>
        <td><?= !empty($bank['st_ifsc']) ? $bank['st_ifsc'] : ''; ?></td>
    </tr>

    <tr>
        <td class="label">Cheque Attached</td>
        <td><?= !empty($bank['emp_cheque']) ? 'Yes' : 'No'; ?></td>
    </tr>
</table>

<p style="margin-top:20px;">
    <strong>Authorization:</strong>
    I hereby authorize <strong>AB ENTERPRISE</strong> to debit my account in case of any recovery
    due to overpayment or breach of agreement with due notice.
    This authorization is limited to recovery following due internal process.
</p>

<table class="signature-table" width="100%">
    <tr>
        <td width="60%">
            Signature: ___________________________
        </td>
        <td width="40%">
            Date: <?= $today; ?>
        </td>
    </tr>
</table>

<div class="note">
    <strong>Data Privacy Note:</strong>
    All bank details and financial information will be kept strictly confidential
    and used solely for official payroll and compliance purposes as per company policy.
</div>