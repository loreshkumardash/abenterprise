<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Employee Verification</title>

    <style>
    body {
        font-family: Arial, sans-serif;
        background: #f4f6f9;
        margin: 0;
        padding: 0;
    }

    .container {
        width: 100%;
        max-width: 420px;
        margin: 60px auto;
    }

    .card {
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        padding: 25px;
    }

    .header {
        text-align: center;
        margin-bottom: 20px;
    }

    .header h2 {
        margin: 0;
        color: #2c3e50;
    }

    .status {
        text-align: center;
        padding: 8px 12px;
        border-radius: 6px;
        font-size: 14px;
        font-weight: bold;
        margin-bottom: 20px;
    }

    .status.active {
        background: #e8f8f0;
        color: #27ae60;
    }

    .info {
        margin-bottom: 12px;
    }

    .label {
        font-weight: bold;
        color: #555;
    }

    .value {
        color: #222;
    }

    .footer {
        text-align: center;
        margin-top: 20px;
        font-size: 12px;
        color: #888;
    }
    </style>
</head>

<body>

    <div class="container">
        <div class="card">

            <div class="header">
                <h2>Employee Verification</h2>
            </div>

            <div class="status active">
                <?= $employee['emp_status'] ?>
            </div>

            <div class="info">
                <span class="label">Employee ID:</span><br>
                <span class="value"><?= $employee['techno_emp_id'] ?></span>
            </div>

            <div class="info">
                <span class="label">Name:</span><br>
                <span class="value">
                    <?= $employee['emp_firstname'].' '.$employee['emp_lastname'] ?>
                </span>
            </div>

            <div class="info">
                <span class="label">Mobile:</span><br>
                <span class="value"><?= $employee['emp_mobile'] ?></span>
            </div>

            <div class="footer">
                Verified by Company System
            </div>

        </div>
    </div>

</body>

</html>