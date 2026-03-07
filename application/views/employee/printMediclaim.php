<!DOCTYPE html>
<html>

<head>
    <style>
    body {
        font-family: helvetica;
        font-size: 10px;
        line-height: 1.6;
    }

    .title {
        text-align: center;
        font-size: 14px;
        font-weight: bold;
        margin-bottom: 15px;
    }


    table {
        width: 100%;
    }

    .family-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 5px;
    }

    .family-table th,
    .family-table td {
        border: 1px solid #000;
        text-align: left;
        padding: 4px 0;
        vertical-align: top;
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

    <div class="title">MEDICLAIM ENROLLMENT FORM</div>

    <?php 
$emp = $records[0]; 
$desg = $designation[0]['designation_name'] ?? '';
?>

    <div style="background:#f2f2f2;padding:6px;font-weight:bold;">
        Employee Details
    </div>

    <table border="1" cellpadding="5" cellspacing="0" width="100%">
        <tr>
            <td width="35%"><strong>Name</strong></td>
            <td width="65%">
                <?= $emp['emp_firstname'].' '.$emp['emp_middlename'].' '.$emp['emp_lastname']; ?>
            </td>
        </tr>

        <tr>
            <td><strong>DOB</strong></td>
            <td><?= date('d-m-Y', strtotime($emp['emp_dob'])); ?></td>
        </tr>

        <tr>
            <td><strong>Employee ID</strong></td>
            <td><?= $emp['techno_emp_id']; ?></td>
        </tr>

        <tr>
            <td><strong>Designation</strong></td>
            <td><?= $desg; ?></td>
        </tr>

        <tr>
            <td><strong>Date of Joining</strong></td>
            <td><?= date('d-m-Y', strtotime($emp['emp_doj'])); ?></td>
        </tr>

        <tr>
            <td><strong>Sum Insured</strong></td>
            <td><?= $medical['sum_insured']; ?></td>
        </tr>
    </table>


    <br>


    <div style="background:#f2f2f2;padding:6px;font-weight:bold;margin-top:15px;">
        Nominee for Insurance
    </div>

    <table border="1" cellpadding="5" cellspacing="0" width="100%">
        <tr>
            <td width="35%"><strong>Name</strong></td>
            <td width="65%"><?= $medical['nominee_name']; ?></td>
        </tr>

        <tr>
            <td><strong>Relation</strong></td>
            <td><?= $medical['nominee_relation']; ?></td>
        </tr>

        <tr>
            <td><strong>DOB</strong></td>
            <td>
                <?= !empty($medical['nominee_dob']) 
                ? date('d-m-Y', strtotime($medical['nominee_dob'])) 
                : ''; ?>
            </td>
        </tr>
    </table>


    <br>


    <div style="background:#f2f2f2;padding:6px;font-weight:bold;">
        Family Members to be Included (Spouse, Children, Parents — list with DOB)
    </div>


    <?php if (!empty($medical['family_members'])): ?>

    <table class="family-table">
        <tr>
            <th width="40%">Name</th>
            <th width="30%">Relation</th>
            <th width="30%">DOB</th>
        </tr>

        <?php foreach ($medical['family_members'] as $member): ?>
        <tr>
            <td><?= $member['name']; ?></td>
            <td><?= $member['relation']; ?></td>
            <td><?= !empty($member['dob']) ? date('d-m-Y', strtotime($member['dob'])) : ''; ?></td>
        </tr>
        <?php endforeach; ?>

    </table>

    <?php else: ?>
    <p>None</p>
    <?php endif; ?>

    <br>

    <div style="background:#f2f2f2;padding:6px;font-weight:bold;">
        Medical Declaration:
    </div>


    <table>
        <tr>
            <td>
                • <strong>Are you/any family member suffering from any pre-existing illness?</strong>
                <?= $medical['medical_issue']; ?>
            </td>
        </tr>

        <?php if ($medical['medical_issue'] == 'Yes'): ?>
        <tr>
            <td>
                <strong>If Yes, give details:</strong><br>
                <?= $medical['medical_details']; ?>
            </td>
        </tr>
        <?php endif; ?>
    </table>

    <br>

    <div style="background:#f2f2f2;padding:6px;font-weight:bold;">
        Employee Consent:
    </div>

    <p>
        • I authorize <strong>AB ENTERPRISE</strong> to enroll me and listed family members under the group medical
        insurance scheme.
        I agree to provide any required documents.
    </p>

    <br><br>

    <table width="100%">
        <tr>
            <td width="50%">
                <strong>Employee Signature:</strong> ____________________________
            </td>
            <td width="50%" align="right">
                <strong>Date:</strong> ____________________________
            </td>
        </tr>
    </table>

</body>

</html>