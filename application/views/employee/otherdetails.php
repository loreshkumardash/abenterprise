<?php $this->load->view("common/meta");?>
<div class="wrapper">

<?php $this->load->view("common/sidebar");?>

<div class="content-wrapper">
    <section class="content-header">
        <h1>
        Employee Details
        </h1>
    </section>

    <section class="content">
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
                    <strong>Success !</strong> <?php echo $this->session->flashdata('error');?>
                </div>
                <?php
                }
                ?>
            </div>
            
            <div class="col-md-12">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#aadhardetails" data-toggle="tab">Aadhaar Details</a></li>
                        <li><a href="#bankandkyc" data-toggle="tab">Bank & Kyc</a></li>
                        <li><a href="#pfandesi" data-toggle="tab">Pf & Esi</a></li>
                        <li><a href="#ecademicdetails" data-toggle="tab">Ecademic Details</a></li>
                        <li><a href="#trainingdetails" data-toggle="tab">Training Details</a></li>
                        <li><a href="#nomineedetails" data-toggle="tab">Nominee Details</a></li>
                        <li><a href="#familydetails" data-toggle="tab">Family Details</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="active tab-pane" id="aadhardetails">
                            <form role="form" action="<?php echo site_url("employee/aadhardetails/".$employee[0]['employee_id']);?>" method="post" enctype="multipart/form-data">
					            <div class="box-body">
					                <div class="">
					                    <div class="col-md-12" style="margin-top:15px;border: 1px solid #ddd;padding: 14px;border-radius: 5px;" >
					                    	<div class="icon icon-lg icon-shape" style="margin-top: -25px!important;">
				                                <span style="background-color: white;width: 100px;font-size: 12px;padding-left: 4px;padding-right: 4px;">Aadhaar Details</span>
				                            </div>
					                    <div class="row" style="padding:5px;">
					                    
						                     <input type="hidden" class="form-control input-sm" id="employee_id" name="employee_id" value="<?=$employee[0]['employee_id'];?>">   


						                    <div class="col-md-12">
					                       		<div class="col-md-6">
				                        <div class="col-md-12" style="padding:0;">
				                             <div class="col-md-12" style="padding:0;margin-top:5px;">
				                                <div class="row">
				                                    <div class="col-md-4">
				                                    <label for="adhr_name" style="margin-top:5px;">Name as Aadhaar</label> 
				                                    </div>
				                                    <div class="col-md-8">
				                                        <input type="text" name="adhr_name" class="adhr_name form-control input-sm" placeholder="Enter Name" value="<?=isset($aadharrec)?$aadharrec[0]['adhr_name']:'';?>"> 
				                                    </div>
				                                </div>
				                            </div>

				                            <div class="col-md-12" style="padding:0;margin-top:5px;">
				                                <div class="row">
				                                    <div class="col-md-4">
				                                    <label for="adhr_plotno" style="margin-top:5px;">PLOT / HOUSE No.</label> 
				                                    </div>
				                                    <div class="col-md-8">
				                                    <input type="text" class="form-control input-sm" id="adhr_plotno" name="adhr_plotno" value="<?=isset($aadharrec)?$aadharrec[0]['adhr_plotno']:'';?>" placeholder="Enter PLOT / HOUSE / KHATA No.">  
				                                    </div>
				                                </div>
				                            </div>
				                           
				                            

				                            <div class="col-md-12" style="padding:0;margin-top:5px;">
				                                <div class="row">
				                                    <div class="col-md-4">
				                                    <label for="adhr_state" style="margin-top:5px;">State</label> 
				                                    </div>
				                                    <div class="col-md-8">
				                                        <select name="adhr_state" class="adhr_state form-control input-sm" >
				                                        	<option value="">State</option>
				                                        	<?php if ($state) { for ($i=0; $i < count($state); $i++) { ?>
			                                                    <option value="<?=$state[$i]['state_id'];?>" <?=isset($aadharrec) &&  $aadharrec[0]['adhr_state']== $state[$i]['state_id']?'selected':'';?>><?=$state[$i]['state_title'];?></option>
			                                               <?php } } ?>
				                                        </select>  
				                                    </div>
				                                </div>
				                            </div>

				                            <div class="col-md-12" style="padding:0;margin-top:5px;">
				                                <div class="row">
				                                    <div class="col-md-4">
				                                    <label for="adhr_dist" style="margin-top:5px;">District</label> 
				                                    </div>
				                                    <div class="col-md-8">
				                                        <select name="adhr_dist" class="adhr_dist form-control input-sm" >
				                                        	<option value="">District</option>
				                                        	<?php if ($adhrdist) { for ($i=0; $i < count($adhrdist); $i++) { ?>
			                                                    <option value="<?=$adhrdist[$i]['district_id'];?>" <?=isset($aadharrec) &&  $aadharrec[0]['adhr_dist']== $adhrdist[$i]['district_id']?'selected':'';?>><?=$adhrdist[$i]['district_title'];?></option>
			                                               <?php } } ?>
				                                        </select>  
				                                    </div>
				                                </div>
				                            </div>

				                            

				                            <div class="col-md-12" style="padding:0;margin-top:5px;">
				                                <div class="row">
				                                    <div class="col-md-4">
				                                    <label for="adhr_contactno" style="margin-top:5px;">Contact No.</label> 
				                                    </div>
				                                    <div class="col-md-8">
				                                        <input type="number" name="adhr_contactno" class="adhr_contactno form-control input-sm" placeholder="Enter Contact No." value="<?=isset($aadharrec)?$aadharrec[0]['adhr_contactno']:'';?>">
				                                        	
				                                    </div>
				                                </div>
				                            </div>

				                        </div>

				                        

				                    </div>
				                    <div class="col-md-6">
				                        <div class="col-md-12">
				                            <div class="col-md-12" style="padding:0;margin-top:5px;">
				                                <div class="row">
				                                    <div class="col-md-4">
				                                    <label for="adhr_at" style="margin-top:5px;">AT</label> 
				                                    </div>
				                                    <div class="col-md-8">
				                                    <input type="text" class="form-control input-sm" id="adhr_at" name="adhr_at" value="<?=isset($aadharrec)?$aadharrec[0]['adhr_at']:'';?>" placeholder="Enter AT">  
				                                    </div>
				                                </div>
				                            </div>

				                            <div class="col-md-12" style="padding:0;margin-top:5px;">
				                                <div class="row">
				                                    <div class="col-md-4">
				                                    <label for="adhr_po" style="margin-top:5px;">PO</label> 
				                                    </div>
				                                    <div class="col-md-8">
				                                        <input type="text" name="adhr_po" class="adhr_po form-control input-sm" placeholder="Enter PO" value="<?=isset($aadharrec)?$aadharrec[0]['adhr_po']:'';?>">  
				                                    </div>
				                                </div>
				                            </div>

				                            <div class="col-md-12" style="padding:0;margin-top:5px;">
				                                <div class="row">
				                                    <div class="col-md-4">
				                                    <label for="adhr_tahsil" style="margin-top:5px;">Tahsil</label> 
				                                    </div>
				                                    <div class="col-md-8">
				                                        <input type="text" class="form-control input-sm" id="adhr_tahsil" name="adhr_tahsil" value="<?=isset($aadharrec)?$aadharrec[0]['adhr_tahsil']:'';?>" placeholder="Enter Tahsil">  
				                                    </div>
				                                </div>
				                            </div>

				                            <div class="col-md-12" style="padding:0;margin-top:5px;">
				                                <div class="row">
				                                    <div class="col-md-4">
				                                    <label for="adhr_pincode" style="margin-top:5px;">Pincode</label> 
				                                    </div>
				                                    <div class="col-md-8">
				                                        <input type="text" name="adhr_pincode" class="adhr_pincode form-control input-sm" value="<?=isset($aadharrec)?$aadharrec[0]['adhr_pincode']:'';?>" placeholder="Enter Pincode" maxlength="6">
				                                        	
				                                    </div>
				                                </div>
				                            </div>
				                              
				                            <div class="col-md-12" style="padding:0;margin-top:5px;">
				                                <div class="row">
				                                    <div class="col-md-4">
				                                    <label for="adhr_landmark" style="margin-top:5px;">Landmark</label> 
				                                    </div>
				                                    <div class="col-md-8">
				                                        <input type="text" name="adhr_landmark" class="adhr_landmark form-control input-sm" value="<?=isset($aadharrec)?$aadharrec[0]['adhr_landmark']:'';?>" placeholder="Enter Landmark">
				                                        	
				                                    </div>
				                                </div>
				                            </div>

				                            <div class="col-md-12" style="padding:0;margin-top:5px;">
				                                <div class="row">
				                                    <div class="col-md-4">
				                                    <label for="adhr_email" style="margin-top:5px;">Email ( if any )</label> 
				                                    </div>
				                                    <div class="col-md-8">
				                                        <input type="email" name="adhr_email" class="adhr_email form-control input-sm" value="<?=isset($aadharrec)?$aadharrec[0]['adhr_email']:'';?>" placeholder="Enter Email" >
				                                        	
				                                    </div>
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
					        </form>
                        </div>
                        <div class="tab-pane" id="bankandkyc">
                            <form role="form" action="<?php echo site_url("employee/bankandkyc/".$employee[0]['employee_id']);?>" method="post" enctype="multipart/form-data">
				            <div class="box-body">
				                <div class="">
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
				                                        <option value="Cash" <?=$bankrec[0]['st_paymode']=='Cash'?'selected':'';?>>Cash</option>
				                                        <option value="Cheque" <?=$bankrec[0]['st_paymode']=='Cheque'?'selected':'';?>>Cheque</option>
				                                        <option value="Net Banking" <?=$bankrec[0]['st_paymode']=='Net Banking'?'selected':'';?>>Net Banking</option>
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
				                                    <input type="text" class="form-control input-sm" id="st_bankname" name="st_bankname" value="<?=$bankrec[0]['st_bankname'];?>">  
				                                    </div>
				                                </div>
				                            </div>
				                            <div class="col-md-12" style="padding:0;margin-top:5px;">
				                                <div class="row">
				                                    <div class="col-md-4">
				                                    <label for="st_acno" style="margin-top:5px;">Account Number</label> 
				                                    </div>
				                                    <div class="col-md-8">
				                                    <input type="number" class="form-control input-sm" id="st_acno" name="st_acno" value="<?=$bankrec[0]['st_acno'];?>">
				                                         
				                                    </div>
				                                </div>
				                            </div>
				                            <div class="col-md-12" style="padding:0;margin-top:5px;">
				                                <div class="row">
				                                    <div class="col-md-4">
				                                    <label for="st_acholdername" style="margin-top:5px;">Account Holder Name</label> 
				                                    </div>
				                                    <div class="col-md-8">
				                                    <input type="text" class="form-control input-sm" id="st_acholdername" name="st_acholdername" value="<?=$bankrec[0]['st_acholdername'];?>">  
				                                    </div>
				                                </div>
				                            </div>
				                            <div class="col-md-12" style="padding:0;margin-top:5px;">
				                                <div class="row">
				                                    <div class="col-md-4">
				                                    <label for="st_ifsc" style="margin-top:5px;">IFSC Code</label> 
				                                    </div>
				                                    <div class="col-md-8">
				                                    <input type="text" class="form-control input-sm" id="st_ifsc" name="st_ifsc" value="<?=$bankrec[0]['st_ifsc'];?>">
				                                         
				                                    </div>
				                                </div>
				                            </div>
				                            <div class="col-md-12" style="padding:0;margin-top:5px;">
				                                <div class="row">
				                                    <div class="col-md-4">
				                                    <label for="st_referenceno" style="margin-top:5px;">Reference No.</label> 
				                                    </div>
				                                    <div class="col-md-8">
				                                    <input type="text" class="form-control input-sm" id="st_referenceno" name="st_referenceno" value="<?=$bankrec[0]['st_referenceno'];?>">  
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
				                                        <option value="No" <?=$bankrec[0]['physicalchallenged']=='No'?'selected':'';?>>No</option>
				                                        <option value="Yes" <?=$bankrec[0]['physicalchallenged']=='Yes'?'selected':'';?>>Yes</option>
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
				                                        <option value="No" <?=$bankrec[0]['int_worker']=='No'?'selected':'';?>>No</option>
				                                        <option value="Yes" <?=$bankrec[0]['int_worker']=='Yes'?'selected':'';?>>Yes</option>
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
				                                    <input type="text" class="form-control input-sm" id="place_oforigin" name="place_oforigin" value="<?=$bankrec[0]['place_oforigin'];?>">  
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
				                                    <input type="text" class="form-control input-sm" id="kyc_panno" name="kyc_panno" value="<?=$bankrec[0]['kyc_panno'];?>">
				                                         
				                                    </div>
				                                </div>
				                            </div>
				                            <div class="col-md-12" style="padding:0;margin-top:5px;">
				                                <div class="row">
				                                    <div class="col-md-4">
				                                    <label for="kyc_panname" style="margin-top:5px;">Name as per Pan   </label> 
				                                    </div>
				                                    <div class="col-md-7">

				                                    <input type="text" class="form-control input-sm" id="kyc_panname" name="kyc_panname" value="<?=$bankrec[0]['kyc_panname'];?>">
				                                         
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
				                                    <input type="text" class="form-control input-sm" id="kyc_adharno" name="kyc_adharno" required value="<?=$bankrec[0]['kyc_adharno'];?>">
				                                         
				                                    </div>
				                                </div>
				                            </div>
				                            
				                            <div class="col-md-12" style="padding:0;margin-top:5px;">
				                                <div class="row">
				                                    <div class="col-md-4">
				                                    <label for="kyc_adharname" style="margin-top:5px;">Name as per Aadhaar</label> 
				                                    </div>
				                                    <div class="col-md-7">
				                                    <input type="text" class="form-control input-sm" id="kyc_adharname" name="kyc_adharname" value="<?=$bankrec[0]['kyc_adharname'];?>">
				                                         
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
				                                            <option value="<?=$state[$i]['state_id'];?>" <?=$state[$i]['state_id']==$bankrec[0]['kyc_adharstate']?'selected':'';?>><?=$state[$i]['state_title'];?></option>
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
				        </form>
                        </div>
                        <div class="tab-pane" id="pfandesi">
                            <form role="form" action="<?php echo site_url("employee/pfandesi/".$employee[0]['employee_id']);?>" method="post" enctype="multipart/form-data">
					            <div class="box-body">
					                <div class="">
					                    <div class="col-md-12" style="margin-top:15px;border: 1px solid #ddd;padding: 14px;border-radius: 5px;" >
					                    	<div class="icon icon-lg icon-shape" style="margin-top: -25px!important;">
				                                <span style="background-color: white;width: 100px;font-size: 12px;padding-left: 4px;padding-right: 4px;">PF & ESI Details</span>
				                            </div>
					                    <div class="row" style="padding:5px;">
					                    
					                     <input type="hidden" class="form-control input-sm" id="employee_id" name="employee_id" value="<?=$employee[0]['employee_id'];?>">   


					                    <div class="col-md-6">
				                        <div class="col-md-12" >
				                             <div class="col-md-12" style="padding:0;margin-top:5px;">
				                                <div class="row">
				                                    <div class="col-md-4">
				                                    <label for="pf_number" style="margin-top:5px;">Have Any PF No.</label> 
				                                    </div>
				                                    <div class="col-md-8">
				                                        <input type="radio" name="emp_ispf" class="emp_ispf" value="1" <?=$pfesirec[0]['emp_ispf']=='1'?'checked':'';?>> Yes &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				                                        <input type="radio" name="emp_ispf" class="emp_ispf"  value="0" <?=$pfesirec[0]['emp_ispf']=='0'?'checked':'';?>> No &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
				                                    </div>
				                                </div>
				                            </div>

				                            <div class="col-md-12" style="padding:0;margin-top:5px;">
				                                <div class="row">
				                                    <div class="col-md-4">
				                                    <label for="pf_number" style="margin-top:5px;">PF Number</label> 
				                                    </div>
				                                    <div class="col-md-8">
				                                    <input type="text" class="form-control input-sm" id="pf_number" name="pf_number" value="<?=$pfesirec[0]['pf_number'];?>" placeholder="Enter PF No.">  
				                                    </div>
				                                </div>
				                            </div>
				                           
				                            <div class="col-md-12" style="padding:0;margin-top:5px;">
				                                <div class="row">
				                                    <div class="col-md-4">
				                                    <label for="pf_number" style="margin-top:5px;">PMJJY</label> 
				                                    </div>
				                                    <div class="col-md-8">
				                                        <input type="radio" name="emp_ispmjjy" value="1" <?=$pfesirec[0]['emp_ispmjjy']=='1'?'checked':'';?>> Yes &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				                                        <input type="radio" name="emp_ispmjjy" value="0" <?=$pfesirec[0]['emp_ispmjjy']=='0'?'checked':'';?>> No &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
				                                    </div>
				                                </div>
				                            </div>

				                        </div>

				                        

				                    </div>
				                    <div class="col-md-6">
				                        <div class="col-md-12">
				                           <div class="col-md-12" style="padding:0;margin-top:5px;">
				                                <div class="row">
				                                    <div class="col-md-4">
				                                    <label for="pf_number" style="margin-top:5px;">Have Any ESI No.</label> 
				                                    </div>
				                                    <div class="col-md-8">
				                                        <input type="radio" name="emp_isesi" class="emp_isesi" value="1" <?=$pfesirec[0]['emp_isesi']=='1'?'checked':'';?>> Yes &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				                                        <input type="radio" name="emp_isesi" class="emp_isesi" value="0" <?=$pfesirec[0]['emp_isesi']=='0'?'checked':'';?>> No &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
				                                    </div>
				                                </div>
				                            </div>
				                            <div class="col-md-12" style="padding:0;margin-top:5px;">
				                                <div class="row">
				                                    <div class="col-md-4">
				                                    <label for="kyc_acholdername" style="margin-top:5px;">ESI Number</label> 
				                                    </div>
				                                    <div class="col-md-8">
				                                    <input type="text" class="form-control input-sm" id="esi_number" name="esi_number" value="<?=$pfesirec[0]['esi_number'];?>" placeholder="Enter ESI No.">  
				                                    </div>
				                                </div>
				                            </div>

				                            <div class="col-md-12" style="padding:0;margin-top:5px;">
				                                <div class="row">
				                                    <div class="col-md-4">
				                                    <label for="pf_number" style="margin-top:5px;">PMSVY</label> 
				                                    </div>
				                                    <div class="col-md-8">
				                                        <input type="radio" name="emp_ispmsvy" value="1" <?=$pfesirec[0]['emp_ispmsvy']=='1'?'checked':'';?>> Yes &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				                                        <input type="radio" name="emp_ispmsvy" value="0" <?=$pfesirec[0]['emp_ispmsvy']=='0'?'checked':'';?>> No &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
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
					        </form>
                        </div>
                        <div class="tab-pane" id="ecademicdetails">
                            <form role="form" action="<?php echo site_url("employee/ecademicdetails/".$employee[0]['employee_id']);?>" method="post" enctype="multipart/form-data">
					            <div class="box-body">
					                <div class="">
					                    <div class="col-md-12" style="margin-top:15px;border: 1px solid #ddd;padding: 14px;border-radius: 5px;" >
					                    	<div class="icon icon-lg icon-shape" style="margin-top: -25px!important;">
				                                <span style="background-color: white;width: 100px;font-size: 12px;padding-left: 4px;padding-right: 4px;">Ecademic Details</span>
				                            </div>
					                    <div class="row" style="padding:5px;">
					                    
						                     <input type="hidden" class="form-control input-sm" id="employee_id" name="employee_id" value="<?=$employee[0]['employee_id'];?>">   


						                    <div class="col-md-12">
					                       
					                             <table class="table table-bordered table-condensed table-striped">
						                            <thead style="background-color:#dae6f5;">
						                              <tr>
						                                <th width="5%" class="text-center">Sl.No<br>&nbsp</th>
						                                <th width="20%">Examination Passed<br>&nbsp</th>
						                                <th width="30%">Name of University/ Board<br>&nbsp</th>
						                                <th width="10%" class="text-center">Year Of Passing</th>
						                                <th width="10%" class="text-center">Marks <br>(%)</th>
						                                <th width="10%" class="text-center" >Stream</th>
						                                <th width="10%" class="text-center" >Grade</th>
						                                <th width="5%"></th>
						                              </tr>
						                            </thead>
						                            <tbody class="itemslist">
						                            	<?php if ($ecademicrec) { for ($i=0; $i <count($ecademicrec) ; $i++) { ?>
						                            		<tr>
							                                  <td width="5%" style="text-align: center;"><?=($i+1);?></td>
							                                  <td width="20%">
							                                    <input type="text" name="examination_passed[]" class="form-control input_capital" value="<?=$ecademicrec[$i]['examination_passed'];?>" required="required">
							                                  </td>
							                                  <td width="30%">
							                                    <input type="text" name="name_univercity[]" class="form-control input_capital" value="<?=$ecademicrec[$i]['name_univercity'];?>" required="required">
							                                  </td>
							                                  <td width="10%">
							                                    <input type="number" name="year_passing[]" class="form-control" required="required" maxlength="4" value="<?=$ecademicrec[$i]['year_passing'];?>">
							                                  </td>
							                                  <td width="10%">
							                                    <input type="number" name="p_mark[]" class="form-control p_mark calcpercentage" required="required" value="<?=$ecademicrec[$i]['p_mark'];?>">
							                                  </td>
							                                  <td width="10%">
							                                    <input type="text" name="stream[]" class="form-control stream " value="<?=$ecademicrec[$i]['stream'];?>">
							                                  </td>
							                                  <td width="10%">
							                                    <input type="text" name="grade[]" class="form-control grade" maxlength="2" value="<?=$ecademicrec[$i]['grade'];?>">
							                                  </td>
							                                  <td width="5%">
							                                    <a href="javascript:;" class="btnRemoveItem btn btn-xs btn-danger">
							                                      <i class="fa fa-trash"></i>
							                                    </a>
							                                  </td>
							                              </tr>
						                            	<?php }}else{ ?>
						                              <tr>
						                                  <td width="5%" style="text-align: center;">1</td>
						                                  <td width="20%">
						                                    <input type="text" name="examination_passed[]" class="form-control input_capital" required="required">
						                                  </td>
						                                  <td width="30%">
						                                    <input type="text" name="name_univercity[]" class="form-control input_capital" required="required">
						                                  </td>
						                                  <td width="10%">
						                                    <input type="number" name="year_passing[]" class="form-control" required="required" maxlength="4">
						                                  </td>
						                                  <td width="10%">
						                                    <input type="number" name="p_mark[]" class="form-control p_mark calcpercentage" required="required" value="0">
						                                  </td>
						                                  <td width="10%">
						                                    <input type="text" name="stream[]" class="form-control stream " value="">
						                                  </td>
						                                  <td width="10%">
						                                    <input type="text" name="grade[]" class="form-control grade" maxlength="2">
						                                  </td>
						                                  <td width="5%">
						                                    <a href="javascript:;" class="btnRemoveItem btn btn-xs btn-danger">
						                                      <i class="fa fa-trash"></i>
						                                    </a>
						                                  </td>
						                              </tr>
						                          	<?php } ?>
						                            </tbody>
						                          </table>
						                          <a href="javascript:;" class="btn btn-xs btn-warning btnAddMoreItem pull-right">Add More</a>
						                          <br><br>
					                    	</div>
					                	</div>
					                </div>
					            </div>
					        </div>

					              
					            
					            
					            <div class="box-footer">
					                <button type="submit" name="submitBtn" value="submit" class="btn btn-primary">Submit</button>
					                <button type="reset" name="resetBtn" class="btn btn-default">Reset</button>
					            </div>
					        </form>
                        </div>
                        <div class="tab-pane" id="trainingdetails">
                            <form role="form" action="<?php echo site_url("employee/trainingdetails/".$employee[0]['employee_id']);?>" method="post" enctype="multipart/form-data">
					            <div class="box-body">
					                <div class="">
					                    <div class="col-md-12" style="margin-top:15px;border: 1px solid #ddd;padding: 14px;border-radius: 5px;" >
					                    	<div class="icon icon-lg icon-shape" style="margin-top: -25px!important;">
				                                <span style="background-color: white;width: 100px;font-size: 12px;padding-left: 4px;padding-right: 4px;">Training Details</span>
				                            </div>
					                    <div class="row" style="padding:5px;">
					                    
						                     <input type="hidden" class="form-control input-sm" id="employee_id" name="employee_id" value="<?=$employee[0]['employee_id'];?>">   


						                    <div class="col-md-12">
					                       
					                             <table class="table table-bordered table-condensed table-striped">
						                            <thead style="background-color:#dae6f5;">
						                              <tr>
						                                <th width="5%" class="text-center">Sl.No</th>
						                                <th width="20%">Training Type</th>
						                                <th width="20%">Topic Name</th>
						                                <th width="20%">Name of Institute</th>
						                                <th width="10%" class="text-center">Sponsered By</th>
						                                <th width="10%" class="text-center">Date From</th>
						                                <th width="10%" class="text-center" >Date To</th>
						                                <th width="5%"></th>
						                              </tr>
						                            </thead>
						                            <tbody class="itemslisttrain">
						                            	<?php if ($trainingrec) { for ($i=0; $i <count($trainingrec) ; $i++) { ?>
						                            		<tr>
								                                  <td width="5%" style="text-align: center;"><?=($i+1);?></td>
								                                  <td width="20%">
								                                    <input type="text" name="trainingtype[]" class="form-control" required="required" value="<?=$trainingrec[$i]['trainingtype'];?>">
								                                  </td>
								                                  <td width="20%">
								                                    <input type="text" name="topicname[]" class="form-control" value="<?=$trainingrec[$i]['topicname'];?>">
								                                  </td>
								                                  <td width="20%">
								                                    <input type="text" name="institutename[]" class="form-control" required="required" value="<?=$trainingrec[$i]['institutename'];?>">
								                                  </td>
								                                  <td width="10%">
								                                    <input type="text" name="sponseredby[]" class="form-control" value="<?=$trainingrec[$i]['sponseredby'];?>">
								                                  </td>
								                                  <td width="10%">
								                                    <input type="date" name="datefrom[]" class="form-control" required="required" value="<?=$trainingrec[$i]['datefrom'];?>">
								                                  </td>
								                                  <td width="10%">
								                                    <input type="date" name="dateto[]" class="form-control " value="<?=$trainingrec[$i]['dateto'];?>">
								                                  </td>
								                                 
								                                  <td width="5%">
								                                    <a href="javascript:;" class="btnRemoveItemtrain btn btn-xs btn-danger">
								                                      <i class="fa fa-trash"></i>
								                                    </a>
								                                  </td>
								                              </tr>
						                            	<?php }}else{ ?>
						                              <tr>
						                                  <td width="5%" style="text-align: center;">1</td>
						                                  <td width="20%">
						                                    <input type="text" name="trainingtype[]" class="form-control" required="required">
						                                  </td>
						                                  <td width="20%">
						                                    <input type="text" name="topicname[]" class="form-control">
						                                  </td>
						                                  <td width="20%">
						                                    <input type="text" name="institutename[]" class="form-control" required="required">
						                                  </td>
						                                  <td width="10%">
						                                    <input type="text" name="sponseredby[]" class="form-control">
						                                  </td>
						                                  <td width="10%">
						                                    <input type="date" name="datefrom[]" class="form-control" required="required">
						                                  </td>
						                                  <td width="10%">
						                                    <input type="date" name="dateto[]" class="form-control ">
						                                  </td>
						                                 
						                                  <td width="5%">
						                                    <a href="javascript:;" class="btnRemoveItemtrain btn btn-xs btn-danger">
						                                      <i class="fa fa-trash"></i>
						                                    </a>
						                                  </td>
						                              </tr>
						                          	<?php } ?>
						                            </tbody>
						                          </table>
						                          <a href="javascript:;" class="btn btn-xs btn-warning btnAddMoreItemtrain pull-right">Add More</a>
						                          <br><br>
					                    	</div>
					                	</div>
					                </div>
					            </div>
					        </div>

					              
					            
					            
					            <div class="box-footer">
					                <button type="submit" name="submitBtn" value="submit" class="btn btn-primary">Submit</button>
					                <button type="reset" name="resetBtn" class="btn btn-default">Reset</button>
					            </div>
					        </form>
                        </div>
                        <div class="tab-pane" id="nomineedetails">
                            <form role="form" action="<?php echo site_url("employee/nomineedetails/".$employee[0]['employee_id']);?>" method="post" enctype="multipart/form-data">
					            <div class="box-body">
					                <div class="">
					                    <div class="col-md-12" style="margin-top:15px;border: 1px solid #ddd;padding: 14px;border-radius: 5px;" >
					                    	<div class="icon icon-lg icon-shape" style="margin-top: -25px!important;">
				                                <span style="background-color: white;width: 100px;font-size: 12px;padding-left: 4px;padding-right: 4px;">Nominee Details</span>
				                            </div>
					                    <div class="row" style="padding:5px;">
					                    
						                     <input type="hidden" class="form-control input-sm" id="employee_id" name="employee_id" value="<?=$employee[0]['employee_id'];?>">   


						               <div class="col-md-6">
				                        <div class="col-md-12" style="padding:0;">
				                             <div class="col-md-12" style="padding:0;margin-top:5px;">
				                                <div class="row">
				                                    <div class="col-md-4">
				                                    <label for="no_name" style="margin-top:5px;">Name</label> 
				                                    </div>
				                                    <div class="col-md-8">
				                                        <input type="text" name="no_name" class="no_name form-control input-sm" placeholder="Enter Nominee Name" value="<?=isset($nomineerec)?$nomineerec[0]['no_name']:'';?>"> 
				                                    </div>
				                                </div>
				                            </div>

				                            <div class="col-md-12" style="padding:0;margin-top:5px;">
				                                <div class="row">
				                                    <div class="col-md-4">
				                                    <label for="no_plotno" style="margin-top:5px;">PLOT / HOUSE No.</label> 
				                                    </div>
				                                    <div class="col-md-8">
				                                    <input type="text" class="form-control input-sm" id="no_plotno" name="no_plotno" value="<?=isset($nomineerec)?$nomineerec[0]['no_plotno']:'';?>" placeholder="Enter PLOT / HOUSE / KHATA No.">  
				                                    </div>
				                                </div>
				                            </div>
				                           
				                            <div class="col-md-12" style="padding:0;margin-top:5px;">
				                                <div class="row">
				                                    <div class="col-md-4">
				                                    <label for="no_po" style="margin-top:5px;">PO</label> 
				                                    </div>
				                                    <div class="col-md-8">
				                                        <input type="text" name="no_po" class="no_po form-control input-sm" placeholder="Enter PO" value="<?=isset($nomineerec)?$nomineerec[0]['no_po']:'';?>">  
				                                    </div>
				                                </div>
				                            </div>

				                            <div class="col-md-12" style="padding:0;margin-top:5px;">
				                                <div class="row">
				                                    <div class="col-md-4">
				                                    <label for="no_state" style="margin-top:5px;">State</label> 
				                                    </div>
				                                    <div class="col-md-8">
				                                        <select name="no_state" class="no_state form-control input-sm" >
				                                        	<option value="">State</option>
				                                        	<?php if ($state) { for ($i=0; $i < count($state); $i++) { ?>
			                                                    <option value="<?=$state[$i]['state_id'];?>" <?=isset($nomineerec) && $state[$i]['state_id'] == $nomineerec[0]['no_state']?'selected':'';?>><?=$state[$i]['state_title'];?></option>
			                                               <?php } } ?>
				                                        </select>  
				                                    </div>
				                                </div>
				                            </div>

				                            <div class="col-md-12" style="padding:0;margin-top:5px;">
				                                <div class="row">
				                                    <div class="col-md-4">
				                                    <label for="no_pincode" style="margin-top:5px;">Pincode</label> 
				                                    </div>
				                                    <div class="col-md-8">
				                                        <input type="text" name="no_pincode" class="no_pincode form-control input-sm" placeholder="Enter Pincode" maxlength="6" value="<?=isset($nomineerec)?$nomineerec[0]['no_pincode']:'';?>">
				                                        	
				                                    </div>
				                                </div>
				                            </div>

				                            <div class="col-md-12" style="padding:0;margin-top:5px;">
				                                <div class="row">
				                                    <div class="col-md-4">
				                                    <label for="no_contactno" style="margin-top:5px;">Contact No.</label> 
				                                    </div>
				                                    <div class="col-md-8">
				                                        <input type="number" name="no_contactno" class="no_contactno form-control input-sm" placeholder="Enter Contact No." value="<?=isset($nomineerec)?$nomineerec[0]['no_contactno']:'';?>">
				                                        	
				                                    </div>
				                                </div>
				                            </div>

				                        </div>

				                        

				                    </div>
				                    <div class="col-md-6">
				                        <div class="col-md-12">
				                           <div class="col-md-12" style="padding:0;margin-top:5px;">
				                                <div class="row">
				                                    <div class="col-md-4">
				                                    <label for="no_relationship" style="margin-top:5px;">Relationship</label> 
				                                    </div>
				                                    <div class="col-md-8">
				                                        <input type="text" name="no_relationship" class="no_relationship form-control input-sm" placeholder="Enter Relationship With Employee" value="<?=isset($nomineerec)?$nomineerec[0]['no_relationship']:'';?>"> 
				                                    </div>
				                                </div>
				                            </div>
				                            <div class="col-md-12" style="padding:0;margin-top:5px;">
				                                <div class="row">
				                                    <div class="col-md-4">
				                                    <label for="no_at" style="margin-top:5px;">AT</label> 
				                                    </div>
				                                    <div class="col-md-8">
				                                    <input type="text" class="form-control input-sm" id="no_at" name="no_at" value="<?=isset($nomineerec)?$nomineerec[0]['no_at']:'';?>" placeholder="Enter AT">  
				                                    </div>
				                                </div>
				                            </div>

				                            <div class="col-md-12" style="padding:0;margin-top:5px;">
				                                <div class="row">
				                                    <div class="col-md-4">
				                                    <label for="no_tahsil" style="margin-top:5px;">Tahsil</label> 
				                                    </div>
				                                    <div class="col-md-8">
				                                        <input type="text" class="form-control input-sm" id="no_tahsil" name="no_tahsil" value="<?=isset($nomineerec)?$nomineerec[0]['no_tahsil']:'';?>" placeholder="Enter Tahsil">  
				                                    </div>
				                                </div>
				                            </div>

				                            <div class="col-md-12" style="padding:0;margin-top:5px;">
				                                <div class="row">
				                                    <div class="col-md-4">
				                                    <label for="no_dist" style="margin-top:5px;">District</label> 
				                                    </div>
				                                    <div class="col-md-8">
				                                        <select name="no_dist" class="no_dist form-control input-sm" >
				                                        	<option value="">District</option>
				                                        	<?php if ($nodist) { for ($i=0; $i < count($nodist); $i++) { ?>
			                                                    <option value="<?=$nodist[$i]['district_id'];?>" <?=isset($nomineerec) && $nodist[$i]['district_id'] == $nomineerec[0]['no_dist']?'selected':'';?>><?=$nodist[$i]['district_title'];?></option>
			                                               <?php } } ?>
				                                        </select>  
				                                    </div>
				                                </div>
				                            </div>
				                              
				                            <div class="col-md-12" style="padding:0;margin-top:5px;">
				                                <div class="row">
				                                    <div class="col-md-4">
				                                    <label for="no_landmark" style="margin-top:5px;">Landmark</label> 
				                                    </div>
				                                    <div class="col-md-8">
				                                        <input type="text" name="no_landmark" class="no_landmark form-control input-sm" placeholder="Enter Landmark" value="<?=isset($nomineerec)?$nomineerec[0]['no_landmark']:'';?>">
				                                        	
				                                    </div>
				                                </div>
				                            </div>

				                            <div class="col-md-12" style="padding:0;margin-top:5px;">
				                                <div class="row">
				                                    <div class="col-md-4">
				                                    <label for="no_email" style="margin-top:5px;">Email ( if any )</label> 
				                                    </div>
				                                    <div class="col-md-8">
				                                        <input type="email" name="no_email" class="no_email form-control input-sm" placeholder="Enter Email" value="<?=isset($nomineerec)?$nomineerec[0]['no_email']:'';?>">
				                                        	
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
					        </form>
                            
                        </div>
                        <div class="tab-pane" id="familydetails">
                            <form role="form" action="<?php echo site_url("employee/familydetails/".$employee[0]['employee_id']);?>" method="post" enctype="multipart/form-data">
					            <div class="box-body">
					                <div class="">
					                    <div class="col-md-12" style="margin-top:15px;border: 1px solid #ddd;padding: 14px;border-radius: 5px;" >
					                    	<div class="icon icon-lg icon-shape" style="margin-top: -25px!important;">
				                                <span style="background-color: white;width: 100px;font-size: 12px;padding-left: 4px;padding-right: 4px;">Family Details</span>
				                            </div>
					                    <div class="row" style="padding:5px;">
					                    
						                     <input type="hidden" class="form-control input-sm" id="employee_id" name="employee_id" value="<?=$employee[0]['employee_id'];?>">   


						                    <div class="col-md-12">
					                       		<table class="table table-bordered table-condensed table-striped">
						                            <thead style="background-color:#dae6f5;">
						                              <tr>
						                                <th width="5%" class="text-center">Sl.No</th>
						                                <th width="50%">Name</th>
						                                <th width="20%">DOB</th>
						                                <th width="20%">Relationship</th>
						                                <th width="5%"></th>
						                              </tr>
						                            </thead>
						                            <tbody class="itemslistmbr">
						                            	<?php if ($familyrec) { for ($i=0; $i <count($familyrec) ; $i++) { ?>
						                            			<tr>
								                                  <td width="5%" style="text-align: center;"><?=($i+1);?></td>
								                                  <td width="50%">
								                                    <input type="text" name="m_name[]" class="form-control" required="required" placeholder="Enter Name" value="<?=$familyrec[$i]['m_name'];?>">
								                                  </td>
								                                  <td width="20%">
								                                    <input type="date" name="m_dob[]" class="form-control" value="<?=$familyrec[$i]['m_dob'];?>">
								                                  </td>
								                                  <td width="20%">
								                                    <input type="text" name="m_relationship[]" class="form-control" required="required" placeholder="Enter Relationship" value="<?=$familyrec[$i]['m_relationship'];?>">
								                                  </td>
								                                  <td width="5%">
								                                    <a href="javascript:;" class="btnRemoveItemtmbr btn btn-xs btn-danger">
								                                      <i class="fa fa-trash"></i>
								                                    </a>
								                                  </td>
								                              </tr>	
						                            	<?php } }else{ ?>
							                              <tr>
							                                  <td width="5%" style="text-align: center;">1</td>
							                                  <td width="50%">
							                                    <input type="text" name="m_name[]" class="form-control" required="required" placeholder="Enter Name">
							                                  </td>
							                                  <td width="20%">
							                                    <input type="date" name="m_dob[]" class="form-control">
							                                  </td>
							                                  <td width="20%">
							                                    <input type="text" name="m_relationship[]" class="form-control" required="required" placeholder="Enter Relationship">
							                                  </td>
							                                  <td width="5%">
							                                    <a href="javascript:;" class="btnRemoveItemtmbr btn btn-xs btn-danger">
							                                      <i class="fa fa-trash"></i>
							                                    </a>
							                                  </td>
							                              </tr>
						                          		<?php }  ?>
						                            </tbody>
						                          </table>
						                          <a href="javascript:;" class="btn btn-xs btn-warning btnAddMoreItemtmbr pull-right">Add More</a>
						                          <br><br>
					                             
					                    	</div>
					                	</div>
					                </div>
					            </div>
					        </div>

					              
					            
					            
					            <div class="box-footer">
					                <button type="submit" name="submitBtn" value="submit" class="btn btn-primary">Submit</button>
					                <button type="reset" name="resetBtn" class="btn btn-default">Reset</button>
					            </div>
					        </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->
<?php $this->load->view("common/footer");?>
</div>
<!-- ./wrapper -->

<?php $this->load->view("common/script");?>

<script type="text/javascript">
	$(document).on('click','.emp_ispf',function(){
		if ($(this).val()=='0') {
			$('#pf_number').val('');
		}
	});
	$(document).on('click','.emp_isesi',function(){
		if ($(this).val()=='0') {
			$('#esi_number').val('');
		}
	});

	$(".btnAddMoreItem").click(function(e){
    var sl = parseInt($(".itemslist tr").length) + 1;
    
    
	    $(".itemslist").append('<tr><td width="5%" style="text-align: center;">'+sl+'</td><td width="20%"><input type="text" name="examination_passed[]" class="form-control" required></td><td width="30%"><input type="text" name="name_univercity[]" class="form-control" required></td><td width="10%"><input type="text" name="year_passing[]" class="form-control" required></td><td width="10%"><input type="number" name="p_mark[]" class="form-control p_mark calcpercentage" required="required" value="0"></td><td width="10%"><input type="text" name="stream[]" class="form-control stream " value=""></td><td width="10%"><input type="text" name="grade[]" class="form-control grade" maxlength="2"></td><td   width="5%"><a href="javascript:;" class="btnRemoveItem btn btn-xs btn-danger"><i class="fa fa-trash"></i></a></td></tr>');
	  });

  $(document).on("click", ".btnRemoveItem", function(e){
      if(confirm("Are you sure to remove this?")){
      $(this).closest('tr').remove();
    }
      
  });

  $(".btnAddMoreItemtrain").click(function(e){
    var sl = parseInt($(".itemslisttrain tr").length) + 1;
    
    
	    $(".itemslisttrain").append('<tr><td width="5%" style="text-align: center;">'+sl+'</td><td width="20%"><input type="text" name="trainingtype[]" class="form-control" required="required"></td><td width="20%"><input type="text" name="topicname[]" class="form-control"></td><td width="20%"><input type="text" name="institutename[]" class="form-control" required="required"></td><td width="10%"><input type="text" name="sponseredby[]" class="form-control"></td><td width="10%"><input type="date" name="datefrom[]" class="form-control" required="required"></td><td width="10%"><input type="date" name="dateto[]" class="form-control "></td><td width="5%"><a href="javascript:;" class="btnRemoveItemtrain btn btn-xs btn-danger"><i class="fa fa-trash"></i></a></td></tr>');
	  });

  $(document).on("click", ".btnRemoveItemtrain", function(e){
      if(confirm("Are you sure to remove this?")){
      $(this).closest('tr').remove();
    }
      
  });

  $(".btnAddMoreItemtmbr").click(function(e){
    var sl = parseInt($(".itemslistmbr tr").length) + 1;
    
    
	    $(".itemslistmbr").append('<tr><td width="5%" style="text-align: center;">'+sl+'</td><td width="50%"><input type="text" name="m_name[]" class="form-control" placeholder="Enter Name" required="required"></td><td width="20%"><input type="date" name="m_dob[]" class="form-control"></td><td width="20%"><input type="text" name="m_relationship[]" class="form-control" required="required" placeholder="Enter Relationship"></td><td width="5%"><a href="javascript:;" class="btnRemoveItemtmbr btn btn-xs btn-danger"><i class="fa fa-trash"></i></a></td></tr>');
	  });

  $(document).on("click", ".btnRemoveItemtmbr", function(e){
      if(confirm("Are you sure to remove this?")){
      $(this).closest('tr').remove();
    }
      
  });

  $(document).on('change','.no_state',function(){
        var state_id = $(this).val();
        if (state_id != '') {
            $.ajax({
                url: '<?=site_url("masters/get_distByState");?>',
                data: {state_id : state_id},
                dataType:"HTML",
                type:"POST",
                success:function(data){
                    $(".no_dist").html(data);
                }
              });
        }
    });

  $(document).on('change','.adhr_state',function(){
        var state_id = $(this).val();
        if (state_id != '') {
            $.ajax({
                url: '<?=site_url("masters/get_distByState");?>',
                data: {state_id : state_id},
                dataType:"HTML",
                type:"POST",
                success:function(data){
                    $(".adhr_dist").html(data);
                }
              });
        }
    });
</script>
</body>
</html>
