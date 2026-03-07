<?php $this->load->view("common/meta");?>
<div class="wrapper">

    <?php $this->load->view("common/sidebar");?>

    <div class="content-wrapper">
        <section class="content-header">
            <h1>
                Employees
            </h1>
        </section>

        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="box">

                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <?php
                            if($this->session->flashdata('success')){
                            ?>
                                    <div class="alert alert-dismissable alert-success">
                                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                                        <strong>Success !</strong> <?php echo $this->session->flashdata('success');?>
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
                                </div>

                                <div class="container-fluid">
                                    <h3 class="mb-4">Employee Documents</h3>

                                    <!-- ================= Education Details ================= -->
                                    <div class="card mb-4">
                                        <div class="card-header">
                                            <strong>Education Details</strong>
                                        </div>
                                        <div class="card-body">
                                            <table class="table table-bordered table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Degree</th>
                                                        <th>Certificate</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php if (!empty($education)) : ?>
                                                    <?php $i = 1; foreach ($education as $edu) : ?>
                                                    <tr>
                                                        <td><?= $i++; ?></td>
                                                        <td><?= $edu['degree']; ?></td>
                                                        <td>
                                                            <?php if (!empty($edu['certificate'])) : ?>
                                                            <a href="<?= base_url('uploads/education/'.$edu['certificate']); ?>"
                                                                target="_blank">View</a>
                                                            <?php else : ?>
                                                            <span class="text-muted">N/A</span>
                                                            <?php endif; ?>
                                                        </td>
                                                    </tr>
                                                    <?php endforeach; ?>
                                                    <?php else : ?>
                                                    <tr>
                                                        <td colspan="8" class="text-center">No education records found
                                                        </td>
                                                    </tr>
                                                    <?php endif; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <!-- ================= ID Proof Details ================= -->
                                    <div class="card mb-4">
                                        <div class="card-header">
                                            <strong>ID Proof Details</strong>
                                        </div>
                                        <div class="card-body">
                                            <table class="table table-bordered">
                                                <tbody>
                                                    <?php if (!empty($id_details)) : ?>
                                                    <tr>
                                                        <th>PAN Card</th>
                                                        <td><?= $bankkyc['kyc_panno']; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Aadhaar Number</th>
                                                        <td><?= $bankkyc['kyc_adharno']; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Voter ID</th>
                                                        <td><?= $id_details['voter_id']; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th>DL No.</th>
                                                        <td><?= $id_details['dl_no']; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Passport No.</th>
                                                        <td><?= $id_details['passport_no']; ?></td>
                                                    </tr>
                                                    <?php else : ?>
                                                    <tr>
                                                        <td class="text-center">No ID proof details found</td>
                                                    </tr>
                                                    <?php endif; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <!-- ================= Others ================= -->
                                    <div class="card mb-4">
                                        <div class="card-header">
                                            <strong>Others</strong>
                                        </div>
                                        <div class="card-body">
                                            <table class="table table-bordered">
                                                <tbody>
                                                    <?php if (!empty($other_details)) : ?>
                                                    <tr>
                                                        <th>Mediclaim</th>
                                                        <td>
                                                            <a href="<?= site_url('employee/printMediclaim/'.$employee_id); ?>" target="_blank">View</a>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>PF Number</th>
                                                        <td><?= $other_details['pf_number'] ?? 'N/A'; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th>ESI Number</th>
                                                        <td><?= $other_details['esi_number'] ?? 'N/A'; ?></td>
                                                    </tr>
                                                    <?php else : ?>
                                                    <tr>
                                                        <td class="text-center">No details found</td>
                                                    </tr>
                                                    <?php endif; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                </div>


                            </div>

                        </div>
                        <?php $this->load->view("common/footer");?>
                    </div>
                </div>
            </div>
        </section>

    </div>

</div>
<?php $this->load->view("common/script");?>
</body>

</html>