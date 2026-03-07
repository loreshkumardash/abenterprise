<!DOCTYPE html>
<html>

<head>
    <style>
    body {
        font-family: helvetica;
        font-size: 12px;
    }

    .center {
        text-align: center;
    }

    .subtitle {
        font-size: 14px;
        margin-top: 5px;
    }

    .section {
        margin-top: 25px;
    }

    .label {
        font-weight: bold;
    }

    .box {
        border: 1px solid #000;
        height: 80px;
        margin-top: 10px;
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
    <!-- ================= PAGE 1 ================= -->

    <h2 class="center" style="margin-bottom:5px;">NEW JOINER KIT</h2>
    <p class="center" style="margin-top:0;">
        Employee Onboarding Documents, Forms & Agreements
    </p>


    <div class="section">
        <p><span class="label">Prepared For:</span> <?php echo $employee->employee_name; ?></p>

        <p><span class="label">Date of Joining:</span>
            <?php echo date("d/m/Y", strtotime($employee->emp_doj)); ?>
        </p>

        <p><span class="label">Date of Issue:</span>
            <?php echo date("d/m/Y"); ?>
        </p>
    </div>

    <div class="section">
        <p class="label">Company Details:</p>
        <p>
            AB ENTERPRISE <br>
            Ground Floor, Vasundhara Apartment <br>
            Rasulgarh, 751010 <br>
            Contact: [ ] <br>
            Email: hr@abenterprise.com
        </p>
    </div>

    <table width="100%">
        <tr>
            <td width="50%">
                <p class="label">HR Signature:</p>
            </td>
            <td width="50%">
                <p class="label">Company Stamp:</p>
            </td>
        </tr>
    </table>

    <!-- PAGE BREAK -->
    <tcpdf method="AddPage" />

    <!-- ================= PAGE 2 ================= -->

    <h3>Security & Acknowledgement</h3>

    <p>
        I, <?php echo $employee->employee_name; ?>, confirm that I have received
        the New Joiner Kit and agree to abide by company policies.
    </p>

    <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:25px; font-size:12px;">
        <tr>
            <td width="50%" align="left">
                <strong>Employee Signature:</strong> ___________________________
            </td>
            <td width="50%" align="right">
                <strong>Date:</strong> <?= date('d/m/Y'); ?>
            </td>
        </tr>
    </table>
</body>

</html>