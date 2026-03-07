<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>EPF & ESI Enrollment</title>
    <style>
    body {
        font-family: helvetica;
        font-size: 11px;
        line-height: 1.6;
    }

    h2 {
        text-align: center;
        margin-bottom: 5px;
    }

    .title {
        text-align: center;
        font-size: 14px;
        font-weight: bold;
        margin-bottom: 15px;
    }

    h3 {
        margin-top: 25px;
        border-bottom: 1px solid #000;
        padding-bottom: 5px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
    }

    td {
        padding: 6px;
        vertical-align: top;
    }

    .label {
        width: 35%;
        font-weight: bold;
    }

    .value {
        width: 65%;
        border-bottom: 1px solid #000;
    }

    .signature-box {
        margin-top: 40px;
    }

    .box {
        border: 1px solid #000;
        padding: 10px;
        margin-top: 10px;
    }

    .noborder {
        text-align: center;
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

    <h2>Employee Provident Fund Enrollment</h2>
    <h3>EPF Basic Enrollment</h3>
    <br>

    <table>
        <tr>
            <td class="label">Employee Name:</td>
            <td class="value"><?= $employee->employee_name ?>
            </td>
        </tr>
        <tr>
            <td class="label">Father / Spouse Name:</td>
            <td class="value"><?= $employee->emp_fathername ?></td>
        </tr>
        <tr>
            <td class="label">Date of Birth:</td>
            <td class="value"><?= $employee->emp_dob ?></td>
        </tr>
        <tr>
            <td class="label">Gender:</td>
            <td class="value"><?= $employee->emp_gender ?></td>
        </tr>
        <tr>
            <td class="label">EPF UAN:</td>
            <td class="value"><?= $pf->pf_number ?? '' ?></td>
        </tr>
        <tr>
            <td class="label">Aadhaar:</td>
            <td class="value"><?= $docs->kyc_adharno ?? '' ?></td>
        </tr>
        <tr>
            <td class="label">PAN:</td>
            <td class="value"><?= $docs->kyc_panno ?? '' ?></td>
        </tr>
        <tr>
            <td class="label">Date of Joining:</td>
            <td class="value"><?= $employee->emp_doj ?></td>
        </tr>
        <tr>
            <td class="label">Designation:</td>
            <td class="value"><?= $designation->designation_name ?? '' ?></td>
        </tr>
        <tr>
            <td class="label">Basic Salary:</td>
            <td class="value"><?= $pf->basic_salary ?? '' ?></td>
        </tr>
        <tr>
            <td class="label">PF Contribution Rate:</td>
            <td class="value">12%</td>
        </tr>
        <tr>
            <td class="label">Bank Account No:</td>
            <td class="value"><?= $docs->st_bankname ?? '' ?></td>
        </tr>
        <tr>
            <td class="label">IFSC:</td>
            <td class="value"><?= $docs->st_ifsc ?? '' ?></td>
        </tr>
    </table>

    <h3>Pension Nomination Details</h3>

    <table border="1">
        <tr>
            <th>Name</th>
            <th>Relation</th>
            <th>Age</th>
            <th>Share %</th>
        </tr>
        <tr>
            <td><?= $pf->nominee1_name ?? '' ?></td>
            <td><?= $pf->nominee1_relation ?? '' ?></td>
            <td><?= $pf->nominee1_age ?? '' ?></td>
            <td><?= $pf->nominee1_share ?? '' ?></td>
        </tr>
        <tr>
            <td><?= $pf->nominee2_name ?? '' ?></td>
            <td><?= $pf->nominee2_relation ?? '' ?></td>
            <td><?= $pf->nominee2_age ?? '' ?></td>
            <td><?= $pf->nominee2_share ?? '' ?></td>
        </tr>
    </table>

    <div class="signature-box">
        Employee Signature: _____________________________
    </div>

    <div class="box">
        <strong>HR Use Only</strong><br><br>
        PF Account No (to be assigned): ___________________________<br><br>
        Employer Code: ___________________________<br><br>
        Processed by (HR): ___________________________ Signature: ___________________________
    </div>


    <tcpdf method="AddPage" />

    <h2>ESI Enrollment Details</h2>

    <table>
        <tr>
            <td class="label">Employee Name:</td>
            <td class="value"><?= $employee->employee_name ?>
            </td>
        </tr>
        <tr>
            <td class="label">ESI No (To be Generated):</td>
            <td class="value"></td>
        </tr>
        <tr>
            <td class="label">Aadhaar:</td>
            <td class="value"><?= $docs->kyc_adharno ?? '' ?></td>
        </tr>
        <tr>
            <td class="label">Date of Birth:</td>
            <td class="value"><?= $employee->emp_dob ?></td>
        </tr>
        <tr>
            <td class="label">Gender:</td>
            <td class="value"><?= $employee->emp_gender ?></td>
        </tr>
        <tr>
            <td class="label">Date of Joining:</td>
            <td class="value"><?= $employee->emp_doj ?></td>
        </tr>
        <tr>
            <td class="label">Present Address:</td>
            <td class="value">
                AT: <?= $employee->emp_at ?? '' ?> |
                PO: <?= $employee->emp_po ?? '' ?> |
                <?= $employee->emp_landmark ?? '' ?> -
                <?= $employee->emp_curpin ?? '' ?>
            </td>
        </tr>
        <tr>
            <td class="label">Employer Name:</td>
            <td class="value">AB ENTERPRISE</td>
        </tr>
        <tr>
            <td class="label">Employer Address:</td>
            <td class="value">Ground Floor, Vasundhara Apartment</td>
        </tr>
        <tr>
            <td class="label">Gross Monthly Wages:</td>
            <td class="value"><?= $pf->gross_wages ?? '' ?></td>
        </tr>
        <tr>
            <td class="label">ESI Contribution:</td>
            <td class="value"><?= $pf->esi_contribution ?? '' ?></td>
        </tr>
    </table>

    <div class="signature-box">
        <br>
        Employee Signature: _____________________________
        <br><br>
        Date: _____________________________
    </div>

    <div class="box">
        <strong>HR Verification & ESI Office Use</strong><br><br>
        ESI Number: ___________________________<br><br>
        Processed by: ___________________________ Date: ___________________________
    </div>

</body>

</html>