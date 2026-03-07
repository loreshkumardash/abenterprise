<!DOCTYPE html>
<html>

<head>
    <style>
    body {
        font-family: helvetica;
        font-size: 11px;
        line-height: 1.6;
    }

    .title {
        text-align: center;
        font-weight: bold;
        text-decoration: underline;
        margin-bottom: 15px;
    }

    .section-title {
        font-weight: bold;
        margin-top: 15px;
        margin-bottom: 5px;
    }

    table {
        width: 100%;
    }

    table td {
        padding: 4px 0;
        vertical-align: top;
    }


    .noborder td {
        border: none;
    }

    .subtitle {
        text-align: center;
        font-size: 13px;
        padding-bottom: 20px;
    }

    h2 {
        text-align: center;
        text-transform: uppercase;
    }
    </style>
</head>

<body>

    <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:25px; font-size:12px;">
        <tr>
            <td width="50%" align="left">
                <strong>Ref.:</strong> ___________________________
            </td>
            <td width="50%" align="right">
                <strong>Date:</strong> <?= date('d/m/Y'); ?>
            </td>
        </tr>
    </table>

    <h2 style="margin-bottom:15px;">OFFER LETTER</h2>

    <p>
        <strong>Date:</strong> <?= date('d/m/Y'); ?>
    </p>

    <p>
        <strong>To,</strong><br>
        <?= $employee['emp_firstname'].' '.$employee['emp_middlename'].' '.$employee['emp_lastname']; ?><br>
        <?= 
        ($employee['emp_atp'] ?? '') . ', ' .
        ($employee['emp_pop'] ?? '') . ', ' .
        ($employee['emp_curpinp'] ?? '')
    ?>
    </p>

    <p>
        Dear
        <strong><?= $employee['emp_firstname'].' '.$employee['emp_middlename'] .' '.$employee['emp_lastname']; ?></strong>,
    </p>

    <p>
        We are pleased to appoint you at <strong>AB ENTERPRISE</strong> as
        <strong><?= $employee['designation_name']; ?> — <?= ucfirst($employee['grade'] ?? '[Grade]'); ?></strong>.
        This appointment is subject to verification of documents and successful completion of probation.
    </p>

    <p class="section-title">Basic Details</p>

    <table>
        <tr>
            <td width="35%">• Employee Name</td>
            <td width="65%">:
                <?= $employee['emp_firstname'].' '.$employee['emp_middlename'] .' '.$employee['emp_lastname']; ?></td>
        </tr>
        <tr>
            <td>• Designation</td>
            <td>: <?= $employee['designation_name']; ?></td>
        </tr>
        <tr>
            <td>• Grade</td>
            <td>: <?= ucfirst($employee['grade'] ?? ''); ?></td>
        </tr>
        <tr>
            <td>• Date of Joining</td>
            <td>:
                <?= !empty($employee['emp_doj']) 
    ? date('d/m/Y', strtotime($employee['emp_doj'])) 
    : ''; 
?>
            </td>
        </tr>
        <tr>
            <td>• Reporting To</td>
            <td>: <?= $employee['reporting_to'] ?? '[Name & Designation]'; ?></td>
        </tr>
        <tr>
            <td>• Work Location</td>
            <td>: Ground Floor, Vasundhara Apartment, Rasulgarh, 751010</td>
        </tr>
        <tr>
            <td>• Working Hours</td>
            <td>
                : Mon–Sat 9:30 AM — 6:30 PM<br>
                &nbsp;&nbsp; (First & Second Saturday and Sunday off as per rota; see Holiday List)
            </td>
        </tr>
        <tr>
            <td>• Probation</td>
            <td>: 6 Months</td>
        </tr>
        <tr>
            <td>• Notice Period</td>
            <td>: Probationary employees — 30 days;<br>
                &nbsp;&nbsp; Confirmed employees — 60 days
            </td>
        </tr>
        <tr>
            <td>• Salary</td>
            <td>: <?= $employee['e_salary'] ?? '[CTC / Basic / Components]'; ?></td>
        </tr>
        <tr>
            <td>• Benefits</td>
            <td>: EPF, ESI, Mediclaim (as per company policy)</td>
        </tr>
    </table>

    <p>
        Please sign and return the duplicate copy of this letter as acceptance.
    </p>

    <br>

    <p>
        <strong>For AB ENTERPRISE</strong><br>
        Authorized Signatory: ___________________________<br>
        Name: ___________________________<br>
        Designation: HR Manager<br>
        Date: ___________________________
    </p>

    <br>

    <p>
        <strong>Employee Acceptance</strong><br>
        I,
        <strong><?= $employee['emp_firstname'].' '.$employee['emp_middlename'].' '.$employee['emp_lastname']; ?></strong>,
        accept the terms and will join on
        <?= !empty($employee['emp_doj']) 
    ? date('d/m/Y', strtotime($employee['emp_doj'])) 
    : ''; 
?>.
    </p>

    <p>
        Signature: ___________________________ &nbsp;&nbsp;
        Date: _______________
    </p>

</body>

</html>