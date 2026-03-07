<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <style>
    body {
        font-family: helvetica;
        font-size: 11px;
        line-height: 1.6;
        color: #000;
    }

    .container {
        padding: 0;
    }

    .title {
        text-align: center;
        font-size: 18px;
        font-weight: bold;
        letter-spacing: 1px;
        margin-bottom: 15px;
        text-transform: uppercase;
    }

    .section-title {
        font-size: 13px;
        font-weight: bold;
        margin-top: 18px;
        margin-bottom: 8px;
        padding-bottom: 4px;
        border-bottom: 2px solid #000;
        text-transform: uppercase;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 10px;
    }

    table.details td {
        padding: 6px 4px;
        vertical-align: top;
        border-bottom: 1px solid #ddd;
    }

    .label {
        width: 32%;
        font-weight: bold;
    }

    .value {
        width: 68%;
    }

    .witness-list {
        margin: 0;
        padding-left: 12px;
    }

    .notice-box {
        border: 1px solid #000;
        padding: 15px;
        margin-top: 10px;
        line-height: 1.2;
    }

    .signature {
        margin-top: 40px;
    }

    .footer-space {
        height: 20px;
    }

    .no-border td {
        border: none;
        padding: 4px;
    }
    </style>
</head>

<body>

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
    <div class="container">

        <div class="title">Disciplinary & Legal Action Report</div>

        <div class="section-title">1. Incident Report</div>

        <table class="details">
            <tr>
                <td class="label">Date of Incident</td>
                <td class="value"><?= date('d-m-Y', strtotime($incident_date)); ?></td>
            </tr>

            <tr>
                <td class="label">Reported By</td>
                <td class="value">
                    <?= $reporter->employee_name ?? ''; ?>
                    (<?= $reporter->designation_name ?? ''; ?>)
                </td>
            </tr>

            <tr>
                <td class="label">Employee Involved</td>
                <td class="value">
                    <?= $accused->employee_name ?? ''; ?>
                    (<?= $accused->employee_id ?? ''; ?>) -
                    <?= $accused->designation_name ?? ''; ?>
                </td>
            </tr>

            <tr>
                <td class="label">Location</td>
                <td class="value"><?= $location; ?></td>
            </tr>

            <tr>
                <td class="label">Policy Violated</td>
                <td class="value"><?= $policy_violated; ?></td>
            </tr>

            <tr>
                <td class="label">Description of Incident</td>
                <td class="value">
                    <div><?= nl2br($incident_description); ?></div>
                </td>
            </tr>

            <tr>
                <td class="label">Witnesses</td>
                <td class="value">
                    <?php if (!empty($witnesses)) : ?>
                    <?php foreach ($witnesses as $w) : ?>
                    • <?= $w['name']; ?> (<?= $w['contact']; ?>)<br>
                    <?php endforeach; ?>
                    <?php else: ?>
                    None
                    <?php endif; ?>
                </td>
            </tr>

            <tr>
                <td class="label">Evidence Attached</td>
                <td class="value"><?= !empty($evidence_files) ? 'Yes' : 'No'; ?></td>
            </tr>

            <tr>
                <td class="label">Recommended Action</td>
                <td class="value"><?= nl2br($recommended_action); ?></td>
            </tr>
        </table>


        <div class="section-title">2. HR / Management Decision</div>

        <table class="details">
            <tr>
                <td class="label">Decision Date</td>
                <td class="value"><?= date('d-m-Y'); ?></td>
            </tr>

            <tr>
                <td class="label">Investigation Summary</td>
                <td class="value"><?= nl2br($investigation_summary); ?></td>
            </tr>

            <tr>
                <td class="label">Findings</td>
                <td class="value"><?= nl2br($findings); ?></td>
            </tr>

            <tr>
                <td class="label">Disciplinary Action</td>
                <td class="value"><?= $disciplinary_action; ?></td>
            </tr>

            <tr>
                <td class="label">Financial Penalty</td>
                <td class="value"><?= $financial_penalty; ?></td>
            </tr>

            <tr>
                <td class="label">Appeal Process</td>
                <td class="value"><?= nl2br($appeal_process); ?></td>
            </tr>
        </table>


        <div class="section-title">3. Legal Notice (If Applicable)</div>

        <div class="notice-box">

            <strong>Date:</strong> <?= date('d-m-Y'); ?><br><br>

            <strong>To,</strong><br>
            <?= $accused->employee_name ?? ''; ?><br><br>

            <strong>Subject: Notice for Misconduct & Show Cause</strong><br><br>

            You are hereby directed to submit a written explanation within
            <strong>7 (Seven) days</strong> from receipt of this notice as to why disciplinary action should not be
            taken against you.<br><br>

            <strong>Details of Misconduct:</strong><br>
            <?= nl2br($incident_description); ?><br><br>

            Failure to respond within the stipulated period shall result in management taking appropriate action as
            deemed necessary without further notice.<br><br>

            <div class="signature">
                _________________________<br>
                Authorized Signatory<br>
                HR Department
            </div>

        </div>

    </div>

</body>

</html>