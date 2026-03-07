<?php
$emp  = $employee;
$desg = !empty($designation['designation_name']) ? $designation['designation_name'] : '';
$dept = !empty($department['department_name']) ? $department['department_name'] : '';
$today = date('d-m-Y');
?>

<style>
body {
    font-family: helvetica;
    font-size: 11px;
    line-height: 1.6;
}

.title {
    font-size: 15px;
    font-weight: bold;
    text-align: center;
    margin-bottom: 15px;
}

.section-title {
    font-weight: bold;
    margin-top: 15px;
    margin-bottom: 8px;
}

table {
    width: 100%;
    border-collapse: collapse;
}

td,
th {
    padding: 6px;
    border: 1px solid #000;
}

.no-border td {
    border: none;
    padding: 4px;
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
<!-- ================= PAGE 1 ================= -->
<div>

    <div class="title">RELIEVING LETTER</div>
    <hr>
    <p>Date: <?= $today; ?></p>

    <p>
        To,<br>
        <?= $emp['emp_firstname'].' '.$emp['emp_middlename'].' '.$emp['emp_lastname']; ?><br>
        <?= $emp['emp_at']; ?>, <?= $emp['emp_po']; ?><br><?= $emp['emp_landmark'].' - '.$emp['emp_curpin']; ?>
    </p>

    <p>
        This is to certify that
        <strong><?= $emp['emp_firstname'].' '.$emp['emp_middlename'].' '.$emp['emp_lastname']; ?></strong>
        was employed with <strong>AB ENTERPRISES</strong> from
        <strong><?= date('d-m-Y', strtotime($emp['emp_doj'])); ?></strong>
        to <strong><?= $today; ?></strong>
        as <strong><?= $desg; ?></strong>.
    </p>

    <p>
        All dues payable to the employee have been settled and cleared.
    </p>

    <p>We wish them success in their future endeavors.</p>

    <br><br><br>

    <p>
        Signature:<br><br>
        _________________________<br>
        HR Manager
    </p>

</div>

<tcpdf method="AddPage" />

<!-- ================= PAGE 2 ================= -->
<div>
    <div class="title" style="font-size: 15px; font-weight: bold; text-align: center; margin-bottom: 15px;">EMPLOYEE
        DETAILS</div>
    <br>
    <hr>
    <table>
        <tr>
            <td><strong>Name</strong></td>
            <td><?= $emp['emp_firstname'].' '.$emp['emp_middlename'].' '.$emp['emp_lastname']; ?></td>
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
            <td><strong>Department</strong></td>
            <td><?= $dept; ?></td>
        </tr>

        <tr>
            <td><strong>Date of Joining</strong></td>
            <td><?= date('d-m-Y', strtotime($emp['emp_doj'])); ?></td>
        </tr>

        <tr>
            <td><strong>Last Working Day</strong></td>
            <td><?= $today; ?></td>
        </tr>
    </table>

</div>

<tcpdf method="AddPage" />

<!-- ================= PAGE 3 ================= -->
<div>
    <div class="title" style="font-size: 15px; font-weight: bold; text-align: center; margin-bottom: 15px;">DEPARTMENTAL
        CLEARANCES</div>
    <br>
    <hr>

    <table>
        <tr>
            <th>Department</th>
            <th>Status</th>
            <th>Signature</th>
            <th>Date</th>
        </tr>
        <tr>
            <td>IT Department</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>Finance Department</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>Admin Department</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>Security</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
    </table>
</div>

<tcpdf method="AddPage" />

<!-- ================= PAGE 4 ================= -->
<div>
    <div class="title" style="font-size: 15px; font-weight: bold; text-align: center; margin-bottom: 15px;">FINAL
        SETTLEMENT COMPUTATION</div>
    <br>
    <hr>

    <table>
        <tr>
            <th>Description</th>
            <th>Amount (₹)</th>
        </tr>
        <tr>
            <td>Salary Till Last Working Day</td>
            <td></td>
        </tr>
        <tr>
            <td>Leave Encashment</td>
            <td></td>
        </tr>
        <tr>
            <td>Bonus / Incentives</td>
            <td></td>
        </tr>
        <tr>
            <td>Deductions</td>
            <td></td>
        </tr>
        <tr>
            <td><strong>Net Payable</strong></td>
            <td></td>
        </tr>
    </table>
</div>

<tcpdf method="AddPage" />

<!-- ================= PAGE 5 ================= -->
<div>
    <div class="title" style="font-size: 15px; font-weight: bold; text-align: center; margin-bottom: 15px;">EXIT
        INTERVIEW NOTES</div>
    <br>
    <hr>

    <table class="no-border">
        <tr>
            <td>Reason for Leaving:</td>
        </tr>
        <tr>
            <td style="height:80px;"></td>
        </tr>

        <tr>
            <td>Feedback about Company:</td>
        </tr>
        <tr>
            <td style="height:80px;"></td>
        </tr>

        <tr>
            <td>Suggestions for Improvement:</td>
        </tr>
        <tr>
            <td style="height:80px;"></td>
        </tr>
    </table>
</div>

<tcpdf method="AddPage" />

<!-- ================= PAGE 6 ================= -->
<div>
    <div class="title" style="font-size: 15px; font-weight: bold; text-align: center; margin-bottom: 15px;">EMPLOYEE
        DECLARATION & SIGNATURE</div>
    <br>
    <hr>

    <p>
        I confirm that I have handed over all company property, documents,
        assets and responsibilities assigned to me. I certify that the
        information provided above is accurate.
    </p>

    <br><br>

    <table class="no-border">
        <tr>
            <td>Employee Signature: _______________________</td>
            <td>Date: ______________</td>
        </tr>
    </table>

    <br><br>

    <tcpdf method="AddPage" />

    <!-- ================= PAGE 7 ================= -->
    <div class="title" style="font-size: 15px; font-weight: bold; text-align: center; margin-bottom: 15px;">CHECKLIST &
        ACKNOWLEDGEMENT</div>
    <br>
    <hr>
    <table>
        <tr>
            <th><strong>Document / Form</strong></th>
            <th><strong>Employee Signature</strong></th>
            <th><strong>HR Signature</strong></th>
        </tr>
        <tr>
            <td>Relieving Letter</td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>Department Clearance Form</td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>Final Settlement Sheet</td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>Exit Interview Form</td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>All Documents Verified</td>
            <td></td>
            <td></td>
        </tr>
    </table>

</div>