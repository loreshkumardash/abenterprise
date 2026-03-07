<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Employee Profile</title>

    <style>
    body {
        font-family: Arial, sans-serif;
        font-size: 13px;
    }

    table {
        border-collapse: collapse;
        width: 100%;
    }

    td,
    th {
        border: 1px solid #000;
        padding: 5px;
        vertical-align: top;
    }

    .title {
        text-align: center;
        font-size: 20px;
        font-weight: bold;
    }

    .subtitle {
        text-align: center;
        font-size: 13px;
        padding-bottom: 20px;
    }

    .section {
        background-color: #e6e6e6;
        font-weight: bold;
        text-align: left;
    }

    .no-border td,
    .no-border th {
        border: none;
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
                <strong>Date:</strong> ___________________________
            </td>
        </tr>
    </table>

    <h1 style="text-align:center; text-decoration:underline; font-size: 18px;">
        Employee Profile
    </h1>

    <br>

    <!-- Personal Details -->
    <table>
        <tr class="section">
            <td colspan="4">PERSONAL DETAILS</td>
        </tr>
        <tr>
            <td>Full Name</td>
            <td><?=$records[0]['employee_name'];?></td>
            <td>Father/Spouse’s Name</td>
            <td><?=$records[0]['emp_fathername'];?></td>
        </tr>
        <tr>
            <td>Nationality</td>
            <td><?=$records[0]['nationality'];?></td>
            <td>Date of Birth</td>
            <td>
                <?=$records[0]['emp_dob'] && $records[0]['emp_dob'] !='0000-00-00'?date('d/m/Y',strtotime($records[0]['emp_dob'])):'';?>
            </td>
        </tr>
        <tr>
            <td>Aadhaar Number</td>
            <td><?=$records[0]['aadhar_number'];?></td>
            <td>Gender</td>
            <td><?=$records[0]['emp_gender'];?></td>
        </tr>
        <tr>
            <td>Marital Status</td>
            <td><?=$records[0]['emp_maritalstatus'];?></td>
            <td>Blood Group</td>
            <td><?=$records[0]['emp_bloodgrp'];?></td>
        </tr>
        <tr>
            <td>Personal Email</td>
            <td><?=$records[0]['employee_email'];?></td>
            <td>PAN No.</td>
            <td><?= $bankkyc['kyc_panno'] ?? ''; ?></td>
        </tr>

        <tr>
            <td>Voter ID</td>
            <td><?=$id_details['voter_id'];?></td>
            <td>Passport No.</td>
            <td><?= $id_details['passport_no']; ?></td>
        </tr>

        <tr>
            <td>Primary Mob.</td>
            <td><?=$records[0]['emp_mobile'];?></td>
            <td>Alternate Mob.</td>
            <td><?=$records[0]['emp_amobile']; ?></td>
        </tr>

        <tr>
            <td>Current Address</td>
            <td>
                <?= $records[0]['emp_at'] ?? ''; ?>,
                <?= $records[0]['emp_po'] ?? ''; ?>,
                <?= ($records[0]['emp_landmark'] ?? '') . ' - ' . ($records[0]['emp_curpin'] ?? ''); ?>
            </td>

            <td>Permanent Address</td>
            <td>
                <?= $records[0]['emp_atp'] ?? ''; ?>,
                <?= $records[0]['emp_pop'] ?? ''; ?>,
                <?= ($records[0]['emp_landmarkp'] ?? '') . ' - ' . ($records[0]['emp_curpinp'] ?? ''); ?>
            </td>
        </tr>
    </table>

    <br><br>

    <!-- Career Obj -->
    <table>
        <tr class="section">
            <td colspan="6">CAREER OBJECTIVE</td>
        </tr>
        <tr>
            <td colspan="6"><?= $records[0]['career_objective']; ?></td>
        </tr>
    </table>

    <br><br>

    <!-- Experience -->
    <table>
        <tr class="section">
            <td colspan="6">PROFESSIONAL EXPERIENCE</td>
        </tr>

        <tr>
            <th width="5%">SL</th>
            <th width="20%">Company Name</th>
            <th width="15%">From</th>
            <th width="15%">To</th>
            <th width="20%">Designation</th>
            <th width="25%">Reason for Leaving</th>
        </tr>

        <?php if (!empty($experience)) { ?>
        <?php $i = 1; ?>
        <?php foreach ($experience as $exp) { ?>
        <tr>
            <td><?= $i++; ?></td>
            <td><?= $exp['employer']; ?></td>
            <td><?= $exp['from_date']; ?></td>
            <td><?= $exp['to_date']; ?></td>
            <td><?= $exp['designation']; ?></td>
            <td><?= $exp['reason']; ?></td>
        </tr>

        <tr>
            <td></td>
            <td colspan="5">
                <strong>Key Responsibilities:</strong>
                <?= nl2br($exp['responsibilities'] ?? ''); ?>
            </td>
        </tr>
        <?php } ?>
        <?php } else { ?>
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td></td>
            <td colspan="5">
                <strong>Key Responsibilities:</strong>
            </td>
        </tr>
        <?php } ?>
    </table>

    <br><br>


    <!-- Education -->
    <table>
        <tr class="section">
            <td colspan="6">EDUCATION DETAILS</td>
        </tr>
        <tr>
            <th width="15%">Degree</th>
            <th width="15%">Board</th>
            <th width="35%">Institute</th>
            <th width="15%">Passing Year</th>
            <th width="20%">Percentage/Grade</th>
        </tr>

        <?php if (!empty($education)) { ?>
        <?php foreach ($education as $edu) { ?>
        <tr>
            <td><?= $edu['degree']; ?></td>
            <td><?= $edu['board']; ?></td>
            <td><?= $edu['institute']; ?></td>
            <td><?= $edu['passing_year']; ?></td>
            <td><?= $edu['percentage']; ?></td>
        </tr>
        <?php } ?>
        <?php } else { ?>
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <?php } ?>
    </table>

    <br><br>

    <!-- Skills/Certifications -->
    <table>
        <tr class="section">
            <td colspan="4">SKILLS & CERTIFICATIONS</td>
        </tr>

        <tr>
            <th width="30%">Skill</th>
            <th width="30%">Certification</th>
            <th width="30%">Organization</th>
            <th width="10%">Status</th>
        </tr>

        <?php if (!empty($skills)) { ?>
        <?php foreach ($skills as $skill) { ?>
        <tr>
            <td><?= $skill['skill']; ?></td>
            <td><?= $skill['certification'] ?? '-'; ?></td>
            <td><?= $skill['organization'] ?? '-'; ?></td>
            <td><?= $skill['certification'] ? 'Certified' : 'Skill'; ?></td>
        </tr>
        <?php } ?>
        <?php } else { ?>
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <?php } ?>
    </table>

    <br><br>

    <!-- References -->
    <table>
        <tr class="section">
            <td colspan="6">REFERENCES</td>
        </tr>

        <tr>
            <th width="30%">Name</th>
            <th width="30%">Relationship</th>
            <th width="20%">Phone</th>
            <th width="20%">Email</th>
        </tr>

        <?php if (!empty($references)) { ?>
        <?php foreach ($references as $ref) { ?>
        <tr>
            <td><?= $ref['ref_name']; ?></td>
            <td><?= $ref['relationship']; ?></td>
            <td><?= $ref['phone']; ?></td>
            <td><?= $ref['email']; ?></td>
        </tr>
        <?php } ?>
        <?php } else { ?>
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <?php } ?>
    </table>

</body>

</html>