<?php $this->load->view("common/meta");?>
<div class="wrapper">

    <?php $this->load->view("common/sidebar");?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Employees
            </h1>
        </section>

        <!-- Main content -->
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

                                <form role="form" action="" method="post" id="searchForm">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="employee_id">Employee Id</label>
                                            <input type="text" class="form-control" id="employee_id" name="employee_id"
                                                value="<?php echo set_value("employee_id");?>">
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="employee_name">Employee Name</label>
                                            <input type="text" class="form-control" id="employee_name"
                                                name="employee_name" readonly>
                                        </div>
                                    </div>

                                    <div class="col-md-4" style="padding-top: 25px;">
                                        <button type="submit" name="submitBtn" value="submit"
                                            class="btn bg-navy btn-flat">Search</button>
                                    </div>
                                </form>

                                <div class="container allBtns" style="display: none; margin-bottom:2rem;">
                                    <div class="row">
                                        <div class="col-md-12">

                                            <div class="btn btn-primary emp-action"
                                                data-url="<?php echo site_url('employee/downloadProfile/'); ?>">
                                                Profile
                                            </div>

                                            <div class="btn btn-warning emp-action"
                                                data-url="<?php echo site_url('employee/empIdCard/'); ?>">
                                                ID Card
                                            </div>

                                            <div class="btn btn-success emp-action"
                                                data-url="<?php echo site_url('employee/empOffer/'); ?>">
                                                Offer Letter
                                            </div>

                                            <div class="btn btn-info emp-action"
                                                data-url="<?php echo site_url('employee/empdocs/'); ?>">
                                                Documents
                                            </div>

                                            <div class="btn btn-primary emp-action"
                                                data-url="<?php echo site_url('employee/target_kpis/'); ?>">
                                                Target & KPIs
                                            </div>

                                            <div class="btn btn-warning emp-action"
                                                data-url="<?php echo site_url('employee/emp_epf_esi/'); ?>">
                                                EPF & ESI
                                            </div>

                                        </div>
                                    </div>

                                    <div class="row" style="margin-top:5px;">
                                        <div class="col-md-12">

                                            <div class="btn btn-info emp-action"
                                                data-url="<?php echo site_url('employee/mediclaim/'); ?>">
                                                Mediclaim
                                            </div>

                                            <div class="btn btn-primary emp-action"
                                                data-url="<?php echo site_url('employee/relieving_letter/'); ?>">
                                                Relieving Letter
                                            </div>

                                            <div class="btn btn-warning emp-action"
                                                data-url="<?php echo site_url('employee/emp_security/'); ?>">
                                                Security & Acknowledgement
                                            </div>

                                            <div class="btn btn-success emp-action"
                                                data-url="<?php echo site_url('employee/joining_kit/'); ?>">
                                                New Joiner Kit
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <!-- /.content -->
                            </div>
                            <!-- /.content-wrapper -->
                            <?php $this->load->view("common/footer");?>
                        </div>
                        <!-- ./wrapper -->

                        <?php $this->load->view("common/script");?>

                        <script>
                        var csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>';
                        var csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';

                        var currentEmployeeId = null;

                        $(document).ready(function() {

                            $('#searchForm').on('submit', function(e) {
                                e.preventDefault();

                                var employee_id = $('#employee_id').val().trim();

                                if (employee_id === '') {
                                    alert('Please enter Employee ID');
                                    return;
                                }

                                $.ajax({
                                    url: "<?php echo site_url('employee/get_employee_by_id'); ?>",
                                    type: "POST",
                                    dataType: "json",
                                    data: {
                                        employee_id: employee_id,
                                        [csrfName]: csrfHash
                                    },
                                    success: function(response) {
                                        console.log(response);

                                        if (response.status === true) {

                                            $('#employee_name').val(response.employee_name);

                                            currentEmployeeId = response.employee_id;

                                            $('.allBtns').show();

                                        } else {
                                            $('#employee_name').val('');
                                            $('.allBtns').hide();
                                            currentEmployeeId = null;
                                            alert(response.message);
                                        }
                                    },
                                    error: function(xhr) {
                                        console.log(xhr.responseText);
                                        alert('AJAX error');
                                    }
                                });

                            });

                            $('.emp-action').on('click', function() {

                                if (!currentEmployeeId) {
                                    alert('Please search employee first');
                                    return;
                                }

                                let baseUrl = $(this).data('url');
                                window.open(baseUrl + currentEmployeeId, '_blank');

                            });


                        });
                        </script>
                        </body>

                        </html>