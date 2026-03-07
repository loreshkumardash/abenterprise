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
            <h3 class="box-title">PF & ESI Settings</h3>
            <h3 class="float-right box-title"><span>Employee Code : </span> <span style="color:green;"><?=$employee[0]['techno_emp_id'];?></span></h3>
        </div>
        <form role="form" action="<?php echo site_url("employee/pfandesi/".$employee[0]['employee_id']);?>" method="post" enctype="multipart/form-data">
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
                    <div class="col-md-6">
                        <div class="col-md-12" >
                            
                            <div class="col-md-12" style="padding:0;">
                                <div class="row">
                                    <div class="col-md-4">
                                    <label for="pf_uanno" style="margin-top:5px;">UAN Number</label> 
                                    </div>
                                    <div class="col-md-8">
                                    <input type="text" class="form-control input-sm" id="pf_uanno" name="pf_uanno" value="<?=$rec[0]['pf_uanno'];?>">
                                          
                                    </div>
                                </div>
                            </div>


                             <input type="hidden" class="form-control input-sm" id="employee_id" name="employee_id" value="<?=$employee[0]['employee_id'];?>">


                            <div class="col-md-12" style="padding:0;margin-top:5px;">
                                <div class="row">
                                    <div class="col-md-4">
                                    <label for="pf_membdate" style="margin-top:5px;">PF Membership Date</label> 
                                    </div>
                                    <div class="col-md-8">
                                    <input type="date" class="form-control input-sm" id="pf_membdate" name="pf_membdate" value="<?php echo date('Y-m-d',strtotime($rec[0]['pf_membdate']));?>">  
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12" style="padding:0;margin-top:5px;">
                                <div class="row">
                                    <div class="col-md-4">
                                    <label for="pf_deduction" style="margin-top:5px;">PF Deduction</label> 
                                    </div>
                                    <div class="col-md-8">
                                    <input type="radio" id="pf_deduction" name="pf_deduction" value="Yes" <?=$rec[0]['pf_deduction']=='Yes'?'checked':'';?>> Yes

                                    <input type="radio" id="pf_deduction" name="pf_deduction" value="No" style="margin-left:50px;" <?=$rec[0]['pf_deduction']=='No'?'checked':'';?>> No
                                         
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12" style="padding:0;margin-top:5px;">
                                <div class="row">
                                    <div class="col-md-4">
                                    <label for="pf_number" style="margin-top:5px;">PF Number</label> 
                                    </div>
                                    <div class="col-md-8">
                                    <input type="text" class="form-control input-sm" id="pf_number" name="pf_number" value="<?=$rec[0]['pf_number'];?>">  
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12" style="padding:0;margin-top:5px;">
                                <div class="row">
                                    <div class="col-md-4">
                                    <label for="vpf_deduction" style="margin-top:5px;">VPF Deduction</label> 
                                    </div>
                                    <div class="col-md-8">
                                    <input type="radio" id="vpf_deduction" name="vpf_deduction" value="Yes" <?=$rec[0]['vpf_deduction']=='Yes'?'checked':'';?>> Yes

                                    <input type="radio" id="vpf_deduction" name="vpf_deduction" value="No" style="margin-left:50px;" <?=$rec[0]['vpf_deduction']=='No'?'checked':'';?>> No
                                         
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12" style="padding:0;margin-top:5px;">
                                <div class="row">
                                    <div class="col-md-4">
                                    <label for="vpf_rate" style="margin-top:5px;">VPF Rate</label> 
                                    </div>
                                    <div class="col-md-8">
                                    <input type="number" class="form-control input-sm" id="vpf_rate" name="vpf_rate" step="0.01" value="<?=$rec[0]['vpf_rate'];?>">  
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12" style="padding:0;margin-top:5px;">
                                <div class="row">
                                    <div class="col-md-4">
                                    <label for="pf_limit" style="margin-top:5px;">PF Limit</label> 
                                    </div>
                                    <div class="col-md-8">
                                    <input type="number" class="form-control input-sm" id="pf_limit" name="pf_limit" step="0.01" value="<?=$rec[0]['pf_limit'];?>">  
                                    </div>
                                </div>
                            </div>
                            
                        </div>

                        

                    </div>
                    <div class="col-md-6">
                        <div class="col-md-12">
                           
                            <div class="col-md-12" style="padding:0;">
                                <div class="row">
                                    <div class="col-md-4">
                                    <label for="esi_membdate" style="margin-top:5px;">ESI Membership Date</label> 
                                    </div>
                                    <div class="col-md-8">
                                    <input type="date" class="form-control input-sm" id="esi_membdate" name="esi_membdate" value="<?php echo date('Y-m-d',strtotime($rec[0]['esi_membdate']));?>">  
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12" style="padding:0;margin-top:5px;">
                                <div class="row">
                                    <div class="col-md-4">
                                    <label for="esi_deduction" style="margin-top:5px;">ESI Deduction</label> 
                                    </div>
                                    <div class="col-md-8">
                                    <input type="radio" id="esi_deduction" name="esi_deduction" value="Yes" <?=$rec[0]['esi_deduction']=='Yes'?'checked':'';?>> Yes
                                    <input type="radio" id="esi_deduction" name="esi_deduction" value="No" style="margin-left:50px;" <?=$rec[0]['esi_deduction']=='No'?'checked':'';?>> No
                                         
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12" style="padding:0;margin-top:5px;">
                                <div class="row">
                                    <div class="col-md-4">
                                    <label for="kyc_acholdername" style="margin-top:5px;">ESI Number</label> 
                                    </div>
                                    <div class="col-md-8">
                                    <input type="text" class="form-control input-sm" id="esi_number" name="esi_number" value="<?=$rec[0]['esi_number'];?>">  
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12" style="padding:0;margin-top:5px;">
                                <div class="row">
                                    <div class="col-md-4">
                                    <label for="esi_limappl" style="margin-top:5px;">ESI Limit Applicable</label> 
                                    </div>
                                    <div class="col-md-8">
                                    <input type="radio" id="esi_limappl" name="esi_limappl" value="Yes" <?=$rec[0]['esi_limappl']=='Yes'?'checked':'';?>> Yes
                                    <input type="radio" id="esi_limappl" name="esi_limappl" value="No" style="margin-left:50px;" <?=$rec[0]['esi_limappl']=='No'?'checked':'';?>> No
                                         
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12" style="padding:0;margin-top:5px;">
                                <div class="row">
                                    <div class="col-md-4">
                                    <label for="ptax_deduction" style="margin-top:5px;">P.Tax Deduction</label> 
                                    </div>
                                    <div class="col-md-8">
                                    <input type="radio" id="ptax_deduction" name="ptax_deduction" value="Yes" <?=$rec[0]['ptax_deduction']=='Yes'?'checked':'';?>> Yes
                                    <input type="radio" id="ptax_deduction" name="ptax_deduction" value="No" style="margin-left:50px;" <?=$rec[0]['ptax_deduction']=='No'?'checked':'';?>> No
                                         
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12" style="padding:0;margin-top:5px;">
                                <div class="row">
                                    <div class="col-md-4">
                                    <label for="lwf_deduction" style="margin-top:5px;">LWF Deduction</label> 
                                    </div>
                                    <div class="col-md-8">
                                    <input type="radio" id="lwf_deduction" name="lwf_deduction" value="Yes" <?=$rec[0]['lwf_deduction']=='Yes'?'checked':'';?>> Yes
                                    <input type="radio" id="lwf_deduction" name="lwf_deduction" value="No" style="margin-left:50px;" <?=$rec[0]['lwf_deduction']=='No'?'checked':'';?>> No
                                         
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
