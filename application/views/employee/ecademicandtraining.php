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
        <div class="box-header with-border">
            <h3 class="box-title">Ecademic & Training Details</h3>
            <h3 class="float-right box-title"><span>Employee Code : </span> <span style="color:green;"><?=$employee[0]['techno_emp_id'];?></span></h3>
        </div>
        <form role="form" action="<?php echo site_url("employee/ecademicandtraining/".$employee[0]['employee_id']);?>" method="post" enctype="multipart/form-data">
            <div class="box-body">
                <div class="">
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
                            <strong>Success !</strong> <?php echo $this->session->flashdata('error');?>
                        </div>
                        <?php
                        }
                        ?>
                    </div>
                    
                    <div class="col-md-12">
                    	
                    </div>

                </div>
                </div>

                
            
            
            <div class="box-footer">
                <button type="submit" name="submitBtn" value="submit" class="btn btn-primary">Submit</button>
                <button type="reset" name="resetBtn" class="btn btn-default">Reset</button>
            </div>
        </div>

        </form>
    </div>
</div>
</div>
</section>
</div>
<?php $this->load->view("common/footer");?>
</div>
<?php $this->load->view("common/script");?>

<script type="text/javascript">
    
</script>
</body>
</html>
