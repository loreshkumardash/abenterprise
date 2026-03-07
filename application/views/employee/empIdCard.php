<?php $this->load->view("common/meta");?>
<div class="wrapper">

    <?php $this->load->view("common/sidebar");?>

    <div class="content-wrapper">
        <section class="content-header">
            <h1>
                Employees <small>ID Card</small>
            </h1>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="box">
                        <div class="box-body">
                            <div class="">
                                <div class="col-md-12">
                                    <?php
                                    if($this->session->flashdata('success')){
                                    ?>
                                    <div class="alert alert-dismissable alert-success">
                                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                                        <strong>Success !</strong>
                                        <?php echo $this->session->flashdata('success');?>
                                    </div>
                                    <?php
                                    }
            
                                    if($this->session->flashdata('error')){
                                    ?>
                                    <div class="alert alert-dismissable alert-danger">
                                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                                        <strong>Error !</strong> <?php echo $this->session->flashdata('error');?>
                                    </div>
                                    <?php
                                    }
                                    ?>

                                    <div class="container" style="width:720px">

                                        <!-- FRONT SIDE -->
                                        <div id="frontCard" style="
                                            width:54mm;
                                            height:86mm;
                                            background:url('<?php echo base_url('assets/idfront.png'); ?>') no-repeat center;
                                            background-size:cover;
                                            border:1px solid #333;
                                            border-radius:3mm;
                                            display:inline-block;
                                            vertical-align:top;
                                            margin-right:5mm;
                                            box-sizing:border-box;
                                            position:relative;
                                            font-family:Arial, sans-serif;
                                            ">

                                            <!-- Logo -->
                                            <div style="text-align:center;margin-top:3mm;">
                                                <img src="<?php echo base_url('assets/logo.png'); ?>"
                                                    style="width:18mm;">
                                            </div>

                                            <!-- Photo -->
                                            <div style="text-align:center;">
                                                <img src="<?= base_url('uploads/employeeicon/'.$employee['emp_photo']); ?>"
                                                    style="
                                                        width:22mm;
                                                        height:22mm;
                                                        border:1px solid #333;
                                                        object-fit:cover;
                                                        background:#fff;
                                                        border-radius:2mm;
                                                    ">
                                            </div>

                                            <!-- Employee Info -->
                                            <div style="text-align:center;margin-top:2mm;padding:0 3mm;">

                                                <p style="font-size:10px;margin:1mm 0;font-weight:bold;">
                                                    <?= $employee['emp_firstname'].' '.$employee['emp_middlename'].' '.$employee['emp_lastname']; ?>
                                                </p>

                                                <p style="font-size:9px;margin:1mm 0;">
                                                    ID: <?= $employee['techno_emp_id']; ?>
                                                </p>

                                                <p style="font-size:9px;margin:1mm 0;">
                                                    <?= $employee['designation_name']; ?>
                                                </p>

                                                <p style="font-size:9px;margin:1mm 0;">
                                                    <?= $employee['department_name']; ?>
                                                </p>

                                                <p style="font-size:9px;margin-top:2mm;color:#c62828;font-weight:bold;">
                                                    Emergency: <?= $employee['emergency_contact']; ?>
                                                </p>

                                            </div>

                                            <!-- Signature -->
                                            <div style="
                                                position:absolute;
                                                bottom:9mm;
                                                left:4mm;
                                                right:4mm;
                                                text-align:center;
                                                font-size:9px;
                                                border-top:1px solid #333;
                                                ">
                                                HR Signature
                                            </div>

                                        </div>
                                        <!-- Back Side -->
                                        <div id="backCard" style="
                                            width:54mm;
                                            height:86mm;
                                            background:url('<?php echo base_url('assets/idback.png'); ?>') no-repeat center;
                                            background-size:cover;
                                            border:1px solid #333;
                                            border-radius:3mm;
                                            display:inline-block;
                                            vertical-align:top;
                                            padding:5mm;
                                            box-sizing:border-box;
                                            position:relative;
                                            text-align:center;
                                            font-family:Arial, sans-serif;
                                            ">

                                            <!-- Header -->
                                            <div style="
                                                text-align:center;
                                                border-bottom:1px solid rgba(0,0,0,0.3);
                                                padding-bottom:2mm;
                                            ">
                                                <h4 style="margin:0;font-size:12px;letter-spacing:0.5px;">
                                                    AB ENTERPRISE
                                                </h4>
                                            </div>

                                            <div style="margin-top:6mm;font-size:9px;">
                                                <strong>Property of AB ENTERPRISE</strong><br>
                                                If found, please return to HR
                                            </div>

                                            <!-- Bottom Content -->
                                            <div style="
                                                position:absolute;
                                                bottom:5mm;
                                                left:5mm;
                                                right:5mm;
                                                font-size:9px;
                                                    ">

                                                <?php
                                                    $qrData = base_url('employee/verify/'.$employee['techno_emp_id']);
                                                    ?>

                                                <div style="text-align:center;margin-bottom:3mm;">
                                                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=<?= urlencode($qrData); ?>"
                                                        style="
                                                    width:28mm;
                                                    height:28mm;
                                                    border:1px solid #333;
                                                    background:#fff;
                                                    padding:2mm;
                                                    ">

                                                    <p style="font-size:8px;margin-top:1mm;">
                                                        ID: <strong><?= $employee['techno_emp_id']; ?></strong>
                                                    </p>
                                                </div>

                                                <p style="margin:1mm 0;">Authorized Signature</p>
                                                <div style="border-bottom:1px solid #333;height:6mm;margin-bottom:2mm;">
                                                </div>

                                                <p style="margin:1mm 0;">Date of Issue</p>
                                                <div style="border-bottom:1px solid #333;height:5mm;">
                                                    <?= date('d-m-Y'); ?>
                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                    <div style="margin-top:20px;text-align:center;">
                                        <button class="btn btn-primary" onclick="printCard('frontCard')">
                                            Print Front
                                        </button>

                                        <button class="btn btn-success" onclick="printCard('backCard')">
                                            Print Back
                                        </button>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
<?php $this->load->view("common/footer");?>
</div>
<?php $this->load->view("common/script");?>

<script>
function printCard(cardId) {
    var content = document.getElementById(cardId).outerHTML;

    var win = window.open('', '', 'width=400,height=600');

    win.document.write(`
        <html>
        <head>
        <title>Print ID</title>

        <base href="<?= base_url(); ?>">

        <style>
            body{
                margin:0;
                display:flex;
                justify-content:center;
                align-items:center;
                height:100vh;
            }

            *{
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
        </style>
        </head>
        <body onload="window.print();window.close();">
            ${content}
        </body>
        </html>
    `);

    win.document.close();
}
</script>
</body>

</html>