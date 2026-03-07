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
            <h3 class="box-title">Employee Documents</h3>
            <h3 class="float-right box-title"><span>Employee Code : </span> <span style="color:green;"><?=$employee[0]['techno_emp_id'];?></span></h3>
        </div>
        <form role="form" action="<?php echo site_url("employee/employee_documents/".$employee[0]['employee_id']);?>" method="post" enctype="multipart/form-data">
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
                    
                    <div class="col-md-12" style="margin-top:15px;border: 1px solid #ddd;padding: 14px;border-radius: 5px;" >
                    <div class="row" style="padding:5px;">
                    <div class="col-md-12">
                        <div class="col-md-12" >
                            
                            <div class="col-md-12" style="padding:0;">
                                <div class="row">
                                    <div class="col-md-5">
                                    <label for="pf_uanno" style="margin-top:5px;">Aadhar Card</label> 
                                    </div>
                                    <div class="col-md-5">
                                    <input type="file" class="form-control input-sm" id="aadharcard" name="aadharcard">
                                    </div>
                                    <div class="col-md-2">
                                    <?php if($rec[0]['aadharcard']){ ?>
                                     	<a href="<?=base_url("uploads/employee_documents/".$rec[0]['aadharcard']);?>" target="_blank">View</a>
                                     <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12" style="padding:0;margin-top:5px;">
                                <div class="row">
                                    <div class="col-md-5">
                                    <label for="pf_membdate" style="margin-top:5px;">Pan Card</label> 
                                    </div>
                                    <div class="col-md-5">
                                    <input type="file" class="form-control input-sm" id="pancard" name="pancard" >  
                                    </div>
                                    <div class="col-md-2">
                                     <?php if($rec[0]['pancard']){ ?>
                                     	<a href="<?=base_url("uploads/employee_documents/".$rec[0]['pancard']);?>" target="_blank">View</a>
                                     <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12" style="padding:0;margin-top:5px;">
                                <div class="row">
                                    <div class="col-md-5">
                                    <label for="pf_deduction" style="margin-top:5px;">10th Certificate</label> 
                                    </div>
                                    <div class="col-md-5">
                                    <input type="file" class="form-control input-sm" id="tencertficate" name="tencertficate" >
                                    </div>
                                    <div class="col-md-2">
                                     <?php if($rec[0]['tencertficate']){ ?>
                                     	<a href="<?=base_url("uploads/employee_documents/".$rec[0]['tencertficate']);?>" target="_blank">View</a>
                                     <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12" style="padding:0;margin-top:5px;">
                                <div class="row">
                                    <div class="col-md-5">
                                    <label for="pf_number" style="margin-top:5px;">10th Marksheet</label> 
                                    </div>
                                    <div class="col-md-5">
                                    <input type="file" class="form-control input-sm" id="tenmarksheet" name="tenmarksheet" > 
                                    </div>
                                    <div class="col-md-2">
                                     <?php if($rec[0]['tenmarksheet']){ ?>
                                     	<a href="<?=base_url("uploads/employee_documents/".$rec[0]['tenmarksheet']);?>" target="_blank">View</a>
                                     <?php } ?>
                                    </div>
                                </div>
                            </div>
                            
                        	<div class="col-md-12" style="padding:0;margin-top:5px;">
                                <div class="row">
                                    <div class="col-md-5">
                                    <label for="pf_deduction" style="margin-top:5px;">+2 Certificate</label> 
                                    </div>
                                    <div class="col-md-5">
                                    <input type="file" class="form-control input-sm" id="twocertficate" name="twocertficate" >
                                    </div>
                                    <div class="col-md-2">
                                     <?php if($rec[0]['twocertficate']){ ?>
                                     	<a href="<?=base_url("uploads/employee_documents/".$rec[0]['twocertficate']);?>" target="_blank">View</a>
                                     <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12" style="padding:0;margin-top:5px;">
                                <div class="row">
                                    <div class="col-md-5">
                                    <label for="pf_number" style="margin-top:5px;">+2 Marksheet</label> 
                                    </div>
                                    <div class="col-md-5">
                                    <input type="file" class="form-control input-sm" id="twomarksheet" name="twomarksheet" > 
                                    </div>
                                    <div class="col-md-2">
                                     <?php if($rec[0]['twomarksheet']){ ?>
                                     	<a href="<?=base_url("uploads/employee_documents/".$rec[0]['twomarksheet']);?>" target="_blank">View</a>
                                     <?php } ?>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-12" style="padding:0;margin-top:5px;">
                                <div class="row">
                                    <div class="col-md-5">
                                    <label for="pf_deduction" style="margin-top:5px;">Graduation Certificate</label> 
                                    </div>
                                    <div class="col-md-5">
                                    <input type="file" class="form-control input-sm" id="gradcertficate" name="gradcertficate" >
                                    </div>
                                    <div class="col-md-2">
                                     <?php if($rec[0]['gradcertficate']){ ?>
                                     	<a href="<?=base_url("uploads/employee_documents/".$rec[0]['gradcertficate']);?>" target="_blank">View</a>
                                     <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12" style="padding:0;margin-top:5px;">
                                <div class="row">
                                    <div class="col-md-5">
                                    <label for="pf_number" style="margin-top:5px;">Graduation Marksheet</label> 
                                    </div>
                                    <div class="col-md-5">
                                    <input type="file" class="form-control input-sm" id="gradmarksheet" name="gradmarksheet" > 
                                    </div>
                                    <div class="col-md-2">
                                     <?php if($rec[0]['gradmarksheet']){ ?>
                                     	<a href="<?=base_url("uploads/employee_documents/".$rec[0]['gradmarksheet']);?>" target="_blank">View</a>
                                     <?php } ?>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-12" style="padding:0;margin-top:5px;">
                                <div class="row">
                                    <div class="col-md-5">
                                    <label for="pf_deduction" style="margin-top:5px;">Post- Graduation Certificate</label> 
                                    </div>
                                    <div class="col-md-5">
                                    <input type="file" class="form-control input-sm" id="pgradcertficate" name="pgradcertficate" >
                                    </div>
                                    <div class="col-md-2">
                                     <?php if($rec[0]['pgradcertficate']){ ?>
                                     	<a href="<?=base_url("uploads/employee_documents/".$rec[0]['pgradcertficate']);?>" target="_blank">View</a>
                                     <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12" style="padding:0;margin-top:5px;">
                                <div class="row">
                                    <div class="col-md-5">
                                    <label for="pf_number" style="margin-top:5px;">Post- Graduation Marksheet</label> 
                                    </div>
                                    <div class="col-md-5">
                                    <input type="file" class="form-control input-sm" id="pgradmarksheet" name="pgradmarksheet" > 
                                    </div>
                                    <div class="col-md-2">
                                     <?php if($rec[0]['pgradmarksheet']){ ?>
                                     	<a href="<?=base_url("uploads/employee_documents/".$rec[0]['pgradmarksheet']);?>" target="_blank">View</a>
                                     <?php } ?>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12" style="padding:0;margin-top:5px;">
                                <div class="row">
                                    <div class="col-md-5">
                                    <label for="pf_deduction" style="margin-top:5px;">Offer letter/ Appointment letter of Previous employer</label> 
                                    </div>
                                    <div class="col-md-5">
                                    <input type="file" class="form-control input-sm" id="offerletter" name="offerletter" >
                                    </div>
                                    <div class="col-md-2">
                                     <?php if($rec[0]['offerletter']){ ?>
                                     	<a href="<?=base_url("uploads/employee_documents/".$rec[0]['offerletter']);?>" target="_blank">View</a>
                                     <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12" style="padding:0;margin-top:5px;">
                                <div class="row">
                                    <div class="col-md-5">
                                    <label for="pf_number" style="margin-top:5px;">Relieving Letter or NOC</label> 
                                    </div>
                                    <div class="col-md-5">
                                    <input type="file" class="form-control input-sm" id="nocletter" name="nocletter" > 
                                    </div>
                                    <div class="col-md-2">
                                     <?php if($rec[0]['nocletter']){ ?>
                                     	<a href="<?=base_url("uploads/employee_documents/".$rec[0]['nocletter']);?>" target="_blank">View</a>
                                     <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12" style="padding:0;margin-top:5px;">
                                <div class="row">
                                    <div class="col-md-5">
                                    <label for="pf_deduction" style="margin-top:5px;">Last 3 months salary slips</label> 
                                    </div>
                                    <div class="col-md-5">
                                    <input type="file" class="form-control input-sm" id="salarysleep" name="salarysleep" >
                                    </div>
                                    <div class="col-md-2">
                                     <?php if($rec[0]['salarysleep']){ ?>
                                     	<a href="<?=base_url("uploads/employee_documents/".$rec[0]['salarysleep']);?>" target="_blank">View</a>
                                     <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12" style="padding:0;margin-top:5px;">
                                <div class="row">
                                    <div class="col-md-5">
                                    <label for="pf_number" style="margin-top:5px;">Passport</label> 
                                    </div>
                                    <div class="col-md-5">
                                    <input type="file" class="form-control input-sm" id="passport" name="passport" > 
                                    </div>
                                    <div class="col-md-2">
                                     <?php if($rec[0]['passport']){ ?>
                                        <a href="<?=base_url("uploads/employee_documents/".$rec[0]['passport']);?>" target="_blank">View</a>
                                     <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12" style="padding:0;margin-top:5px;">
                                <div class="row">
                                    <div class="col-md-5">
                                    <label for="pf_number" style="margin-top:5px;">Voter Id</label> 
                                    </div>
                                    <div class="col-md-5">
                                    <input type="file" class="form-control input-sm" id="voterid" name="voterid" > 
                                    </div>
                                    <div class="col-md-2">
                                     <?php if($rec[0]['voterid']){ ?>
                                        <a href="<?=base_url("uploads/employee_documents/".$rec[0]['voterid']);?>" target="_blank">View</a>
                                     <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12" style="padding:0;margin-top:5px;">
                                <div class="row">
                                    <div class="col-md-5">
                                    <label for="pf_number" style="margin-top:5px;">Driving Licence</label> 
                                    </div>
                                    <div class="col-md-5">
                                    <input type="file" class="form-control input-sm" id="drivinglicence" name="drivinglicence" > 
                                    </div>
                                    <div class="col-md-2">
                                     <?php if($rec[0]['drivinglicence']){ ?>
                                        <a href="<?=base_url("uploads/employee_documents/".$rec[0]['drivinglicence']);?>" target="_blank">View</a>
                                     <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12" style="padding:0;margin-top:5px;">
                                <div class="row">
                                    <div class="col-md-5">
                                    <label for="pf_number" style="margin-top:5px;">Bank details</label> 
                                    </div>
                                    <div class="col-md-5">
                                    <input type="file" class="form-control input-sm" id="bankdetails" name="bankdetails" > 
                                    </div>
                                    <div class="col-md-2">
                                     <?php if($rec[0]['bankdetails']){ ?>
                                     	<a href="<?=base_url("uploads/employee_documents/".$rec[0]['bankdetails']);?>" target="_blank">View</a>
                                     <?php } ?>
                                    </div>
                                </div>
                            </div>
                           
                        </div>
                        </div>

                        

                </div>
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
