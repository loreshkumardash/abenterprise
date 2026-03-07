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
            <h3 class="box-title">Bank & KYC Details</h3>
            <h3 class="float-right box-title"><span>Employee Code : </span> <span style="color:green;"><?=$employee[0]['techno_emp_id'];?></span></h3>
        </div>
        <form role="form" action="<?php echo site_url("employee/bankandkyc/".$employee[0]['employee_id']);?>" method="post" enctype="multipart/form-data">
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
                    <div class="row">
                    <div class="col-md-6">
                        <div class="col-md-12" style="margin-top:15px;border: 1px solid #ddd;padding: 14px;border-radius: 5px;" >
                            <div class="icon icon-lg icon-shape" style="margin-top: -25px!important;">
                                <span style="background-color: white;width: 100px;font-size: 12px;padding-left: 4px;padding-right: 4px;">Salary Transfer Bank Details</span>
                            </div>
                            <div class="col-md-12" style="padding:0;">
                                <div class="row">
                                    <div class="col-md-4">
                                    <label for="st_paymode" style="margin-top:5px;">Pay Mode</label> 
                                    </div>
                                    <div class="col-md-8">
                                    <select class="form-control input-sm" id="st_paymode" name="st_paymode">
                                        <option value="Cash" <?=$rec[0]['st_paymode']=='Cash'?'selected':'';?>>Cash</option>
                                        <option value="Cheque" <?=$rec[0]['st_paymode']=='Cheque'?'selected':'';?>>Cheque</option>
                                        <option value="Net Banking" <?=$rec[0]['st_paymode']=='Net Banking'?'selected':'';?>>Net Banking</option>
                                    </select>  
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12" style="padding:0;margin-top:5px;">
                                <div class="row">
                                    <div class="col-md-4">
                                    <label for="st_bankname" style="margin-top:5px;">Bank Name</label> 
                                    </div>
                                    <div class="col-md-8">
                                    <input type="text" class="form-control input-sm" id="st_bankname" name="st_bankname" value="<?=$rec[0]['st_bankname'];?>">  
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12" style="padding:0;margin-top:5px;">
                                <div class="row">
                                    <div class="col-md-4">
                                    <label for="st_acno" style="margin-top:5px;">Account Number</label> 
                                    </div>
                                    <div class="col-md-8">
                                    <input type="number" class="form-control input-sm" id="st_acno" name="st_acno" value="<?=$rec[0]['st_acno'];?>">
                                         
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12" style="padding:0;margin-top:5px;">
                                <div class="row">
                                    <div class="col-md-4">
                                    <label for="st_acholdername" style="margin-top:5px;">Account Holder Name</label> 
                                    </div>
                                    <div class="col-md-8">
                                    <input type="text" class="form-control input-sm" id="st_acholdername" name="st_acholdername" value="<?=$rec[0]['st_acholdername'];?>">  
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12" style="padding:0;margin-top:5px;">
                                <div class="row">
                                    <div class="col-md-4">
                                    <label for="st_ifsc" style="margin-top:5px;">IFSC Code</label> 
                                    </div>
                                    <div class="col-md-8">
                                    <input type="text" class="form-control input-sm" id="st_ifsc" name="st_ifsc" value="<?=$rec[0]['st_ifsc'];?>">
                                         
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12" style="padding:0;margin-top:5px;">
                                <div class="row">
                                    <div class="col-md-4">
                                    <label for="st_referenceno" style="margin-top:5px;">Reference No.</label> 
                                    </div>
                                    <div class="col-md-8">
                                    <input type="text" class="form-control input-sm" id="st_referenceno" name="st_referenceno" value="<?=$rec[0]['st_referenceno'];?>">  
                                    </div>
                                </div>
                            </div>
                        </div>

                       

                        <div class="col-md-12" style="margin-top:5px;border: 1px solid #ddd;padding: 14px;border-radius: 5px;">
                            <div class="col-md-12" style="padding:0;">
                                <div class="row">
                                    <div class="col-md-4">
                                    <label for="physicalchallenged" style="margin-top:5px;">Physicaly Challenged</label> 
                                    </div>
                                    <div class="col-md-8">
                                    <select class="form-control input-sm" id="physicalchallenged" name="physicalchallenged">
                                        <option value="No" <?=$rec[0]['physicalchallenged']=='No'?'selected':'';?>>No</option>
                                        <option value="Yes" <?=$rec[0]['physicalchallenged']=='Yes'?'selected':'';?>>Yes</option>
                                    </select>
                                         
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12" style="padding:0;margin-top:5px;">
                                <div class="row">
                                    <div class="col-md-4">
                                    <label for="int_worker" style="margin-top:5px;">International Worker</label> 
                                    </div>
                                    <div class="col-md-8">
                                    <select class="form-control input-sm" id="int_worker" name="int_worker">
                                        <option value="No" <?=$rec[0]['int_worker']=='No'?'selected':'';?>>No</option>
                                        <option value="Yes" <?=$rec[0]['int_worker']=='Yes'?'selected':'';?>>Yes</option>
                                    </select>
                                         
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12" style="padding:0;margin-top:5px;">
                                <div class="row">
                                    <div class="col-md-4">
                                    <label for="place_oforigin" style="margin-top:5px;">Place of Origin</label> 
                                    </div>
                                    <div class="col-md-8">
                                    <input type="text" class="form-control input-sm" id="place_oforigin" name="place_oforigin" value="<?=$rec[0]['place_oforigin'];?>">  
                                    </div>
                                </div>
                            </div>
                            
                            
                        </div>

                    </div>
                    <div class="col-md-6">
                        <div class="col-md-12" style="margin-top:15px;border: 1px solid #ddd;padding: 14px;border-radius: 5px;" >
                            <div class="icon icon-lg icon-shape" style="margin-top: -25px!important;">
                                <span style="background-color: white;width: 100px;font-size: 12px;padding-left: 4px;padding-right: 4px;">UAN & KYC Bank Details</span>
                            </div>
                            
                            <div class="col-md-12" style="padding:0;margin-top:5px;">
                                <div class="row">
                                    <div class="col-md-4">
                                    <label for="kyc_panno" style="margin-top:5px;">Pan Number</label> 
                                    </div>
                                    <div class="col-md-8">
                                    <input type="text" class="form-control input-sm" id="kyc_panno" name="kyc_panno" value="<?=$rec[0]['kyc_panno'];?>">
                                         
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12" style="padding:0;margin-top:5px;">
                                <div class="row">
                                    <div class="col-md-4">
                                    <label for="kyc_panname" style="margin-top:5px;">Name as per Pan   </label> 
                                    </div>
                                    <div class="col-md-7">

                                    <input type="text" class="form-control input-sm" id="kyc_panname" name="kyc_panname" value="<?=$rec[0]['kyc_panname'];?>">
                                         
                                    </div>

                                    <div class="col-md-1">
                                        <input type="checkbox" id="asperpan">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12" style="padding:0;margin-top:5px;">
                                <div class="row">
                                    <div class="col-md-4">
                                    <label for="kyc_adharno" style="margin-top:5px;">Aadhaar No.</label><span style="color:red;">*</span>
                                    </div>
                                    <div class="col-md-8">
                                    <input type="text" class="form-control input-sm" id="kyc_adharno" name="kyc_adharno" required value="<?=$rec[0]['kyc_adharno'];?>">
                                         
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-12" style="padding:0;margin-top:5px;">
                                <div class="row">
                                    <div class="col-md-4">
                                    <label for="kyc_adharname" style="margin-top:5px;">Name as per Aadhaar</label> 
                                    </div>
                                    <div class="col-md-7">
                                    <input type="text" class="form-control input-sm" id="kyc_adharname" name="kyc_adharname" value="<?=$rec[0]['kyc_adharname'];?>">
                                         
                                    </div>
                                    <div class="col-md-1">
                                        <input type="checkbox" id="asperaadhar">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12" style="padding:0;margin-top:5px;">
                                <div class="row">
                                    <div class="col-md-4">
                                    <label for="kyc_adharstate" style="margin-top:5px;">Aadhaar State</label><span style="color:red;">*</span> 
                                    </div>
                                    <div class="col-md-8">
                                    <select class="form-control input-sm" id="kyc_adharstate" name="kyc_adharstate" required>
                                        <option value="">--Select State--</option>
                                        <?php if ($state) { for ($i=0; $i < count($state); $i++) { ?>
                                            <option value="<?=$state[$i]['state_id'];?>" <?=$state[$i]['state_id']==$rec[0]['kyc_adharstate']?'selected':'';?>><?=$state[$i]['state_title'];?></option>
                                       <?php } } ?>
                                    </select>
                                         
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
    $('#asperpan').click(function(){
          if($(this).prop("checked") == true){
              let st_acholdername = $('#st_acholdername').val();
            
              $('#kyc_panname').val(st_acholdername);
             
          }else if($(this).prop("checked") == false){
              $('#kyc_panname').val('');
              
          }
      });

    $('#asperaadhar').click(function(){
          if($(this).prop("checked") == true){
              let st_acholdername = $('#st_acholdername').val();
            
              $('#kyc_adharname').val(st_acholdername);
             
          }else if($(this).prop("checked") == false){
              $('#kyc_adharname').val('');
              
          }
      });
</script>
</body>
</html>
