<?php $this->load->view("common/meta");?>
<style>
.switch {
  position: relative;
  display: inline-block;
  width: 40px;
  height: 21px;
}

.switch input { 
  opacity: 0;
  width: 0;
  height: 0;
}

.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 18px;
  width: 22px;
  left: 2px;
  bottom: 2px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider {
  background-color: #2196F3;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
  -webkit-transform: translateX(15px);
  -ms-transform: translateX(15px);
  transform: translateX(15px);
}

/* Rounded sliders */
.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;
}
</style>
<div class="wrapper">

<?php $this->load->view("common/sidebar");?>

<div class="content-wrapper">
<section class="content-header">
    <h1>
        Unit Parameter
        <small>Profile</small>
    </h1>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        
        <div class="col-md-12">
            <div class="row">
                
                
                    <div class="box-body row">
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

            <div class="col-md-3">
                <div class="box box-primary">
                    <div class="box-body box-profile">
                        <h3 class="profile-username text-center"><?php echo $records[0]['unit_name'];?></h3>
                        <strong><i class="margin-r-5">#</i> Unit Code</strong>
                        <p class="text-muted">
                        # <?php echo $records[0]['unit_id'];?>
                        </p>
                        <strong><i class="fa fa-map-marker margin-r-5"></i> Location</strong>
                        <p class="text-muted ">
                         <?php echo $records[0]['unit_location'];?>
                        </p>
                        <strong><i class="fa fa-check margin-r-5"></i> Status</strong>
                        <p class="text-muted ">
                         <?php echo $records[0]['unit_active'];?>
                        </p>
                        <div style="height:160px;">
                            <?php if($this->session->userdata('usertype') == 'Admin'){ ?>
                            <table>
                                <tr>
                                    <td>
                                        <label class="switch">
                                          <input type="checkbox" name="unit_status" id="unit_status" value="<?php echo $records[0]['unit_id'];?>" <?php echo $records[0]['unit_active'] == 'Active' ? 'checked="checked"' : '';?>>
                                          <span class="slider round"></span>
                                        </label>
                                  </td>
                                </tr>
                            </table>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="<?=$bonusleaverec?'':'active';?>"><a href="#contractedpost" data-toggle="tab">Contracted Post</a></li>
                        
                        <li class="<?=$bonusleaverec?'active':'';?>"><a href="#bonusleavewages" data-toggle="tab">Bonus & Leave(%)</a></li>
                        <li><a href="#salaryrates" data-toggle="tab">Salary Rates</a></li>
                        <li><a href="#salaryrateslist" data-toggle="tab">List Rates</a></li>
                        
                    </ul>
                    <div class="tab-content">
                        <div class="<?=$bonusleaverec?'':'active';?> tab-pane" id="contractedpost">
                            <form role="form" action="<?php echo site_url("masters/contractedpost/".$unit_id."/".$rec[0]['contractedpost_id']."");?>" method="post">
                                <div class="box-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="post_designation">Designation</label><span style="color:red;">*</span>
                                        <select class="form-control input-sm" id="post_designation" name="post_designation">
                                            <option value="">--Select--</option>
                                        <?php if ($designation) { for ($i=0; $i < count($designation); $i++) { ?>
                                              <option value="<?=$designation[$i]['designation_id'];?>" <?=$rec[0]['post_designation'] && $rec[0]['post_designation']==$designation[$i]['designation_id']?'selected':'';?>><?=$designation[$i]['designation_name'];?></option>  
                                        <?php } } ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="duty_hrs">Duty Hours</label><span style="color:red;">*</span>
                                        <input type="number" class="form-control input-sm" id="duty_hrs" name="duty_hrs" value="<?=$rec[0]['duty_hrs']?$rec[0]['duty_hrs']:'';?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="post_strength">Strength</label><span style="color:red;">*</span>
                                        <input type="number" class="form-control input-sm" id="post_strength" name="post_strength" value="<?=$rec[0]['post_strength']?$rec[0]['post_strength']:'';?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="post_strength">Enrollment Fee.</label><span style="color:red;">*</span>
                                        <input type="text" class="form-control input-sm" id="en_fee" name="en_fee" value="<?=$rec[0]['en_fee']?$rec[0]['en_fee']:'';?>">
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" name="submitBtn" value="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                    </div>
                                    <div class="col-md-8">
                                       <table id="" class="table table-bordered table-condensed table-striped">
                                            <tr>
                                                <th width="10%">SlNo.</th>
                                                <th width="30%">Designation</th>
                                                <th width="12%">Duty Hrs</th>
                                                <th width="10%">Strength</th>
                                                <th width="15%">Enr. Fee</th>
                                                <th width="12%">Action</th>
                                            </tr>
                                            <?php if ($conpost) { for ($i=0; $i < count($conpost); $i++) { ?>
                                                <tr>
                                                <td width="10%"><?=$i+1;?></td>
                                                <td width="20%"><?=$conpost[$i]['designation_name'];?></td>
                                                <td width="12%"><?=$conpost[$i]['duty_hrs'];?></td>
                                                <td width="10%"><?=$conpost[$i]['post_strength'];?></td>
                                                <td width="15%"><?=$conpost[$i]['en_fee'];?></td>
                                                <td width="12%">
                                                    <a href="<?php echo site_url("masters/viewunit/".$conpost[$i]['unit_id']."/".$conpost[$i]['contractedpost_id']);?>" class="btn btn-xs btn-warning"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                                    <a href="<?php echo site_url("masters/deletecontractedpost/".$conpost[$i]['contractedpost_id']);?>" class="btn btn-xs btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></a>

                                                </td>
                                            </tr>
                                            <?php }} ?>
                                        </table>
                                    </div>
                                    </div>

                                </div>
                                
                            </form>
                        </div>
                        
                        <div class="tab-pane <?=$bonusleaverec?'active':'';?>" id="bonusleavewages">
                            <form role="form" action="<?php echo site_url("masters/bonusleavewages/".$unit_id."");?>" method="post">
                                <div class="box-body">
                                    <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <select class="form-control input-sm" id="designation_id" name="designation_id" <?=$bonusleaverec[0]['designation_id']?'readonly="readonly"':'';?>>
                                                <option value="">--Select--</option>
                                                <?php if ($desig) { for ($i=0; $i < count($desig); $i++) { ?>
                                                    <option value="<?=$desig[$i]['designation_id'];?>" <?=$bonusleaverec[0]['designation_id'] && $bonusleaverec[0]['designation_id']==$desig[$i]['designation_id']?'selected':'';?>><?=$desig[$i]['designation_name'];?></option>
                                                <?php }} ?>
                                            </select>
                                        </div>
                                    <div class="form-group">
                                        <label for="duty_hrs">Bonus(%)</label><span style="color:red;">*</span>
                                        <input type="number" class="form-control input-sm" id="bonus" name="bonus" required step="0.01" value="<?=$bonusleaverec[0]['bonus']?$bonusleaverec[0]['bonus']:'0';?>">
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-6">
                                            <input type="number" class="form-control input-sm" id="bonusonamount" name="bonusonamount" step="0.01" value="<?=$bonusleaverec[0]['bonusonamount']?$bonusleaverec[0]['bonusonamount']:'0.00';?>">
                                            </div>
                                            <div class="col-md-6">
                                            <input type="checkbox" id="bonus_asperamount" name="bonus_asperamount" value="Yes" class="calc_amt" <?=$bonusleaverec[0]['bonus_asperamount']=='Yes'?'checked':'';?>> <label>On Amount</label>
                                            </div> 
                                            
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="post_strength">Leave Wages(%)</label><span style="color:red;">*</span>
                                        <input type="number" class="form-control input-sm" id="leave_wages" name="leave_wages" required step="0.01" value="<?=$bonusleaverec[0]['leave_wages']?$bonusleaverec[0]['leave_wages']:'0';?>">
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-6">
                                            <input type="number" class="form-control input-sm" id="leaveonamount" name="leaveonamount" step="0.01" value="<?=$bonusleaverec[0]['leaveonamount']?$bonusleaverec[0]['leaveonamount']:'0.00';?>">
                                            </div>
                                            <div class="col-md-6">
                                            <input type="checkbox" id="leave_asperamount" name="leave_asperamount" value="Yes" class="calc_amt" <?=$bonusleaverec[0]['leave_asperamount']=='Yes'?'checked':'';?>> <label>On Amount</label>
                                            </div> 
                                            
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" name="submitBtn" value="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                    </div>
                                    <div class="col-md-8">
                                       <table id="" class="table table-bordered table-condensed table-striped">
                                            <tr>
                                                <th width="10%">SlNo.</th>
                                                <th width="45%">Designation</th>
                                                <th width="15%">Bonus(%)</th>
                                                <th width="15%">Leave(%)</th>
                                                <th width="15%">Action</th>
                                            </tr>
                                            <?php if ($bonusleave) { for ($i=0; $i < count($bonusleave); $i++) { ?>
                                                <tr>
                                                <td width="10%"><?=$i+1;?></td>
                                                <td width="45%"><?=$bonusleave[$i]['designation_name'];?></td>
                                                <td width="15%"><?=$bonusleave[$i]['bonus'];?></td>
                                                <td width="15%"><?=$bonusleave[$i]['leave_wages'];?></td>
                                                <td width="15%">
                                                   <a href="<?php echo site_url("masters/viewunit/".$unit_id."/0/".$bonusleave[$i]['id']);?>" class="btn btn-xs btn-warning"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                                    <a href="<?php echo site_url("masters/deletebonusleave/".$bonusleave[$i]['id']);?>" class="btn btn-xs btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></a> 
                                                </td>
                                               
                                            </tr>
                                            <?php }} ?>
                                        </table>
                                    </div>
                                    </div>

                                </div>
                                
                            </form>
                        </div>


            
            <div class="tab-pane" id="salaryrates">
                <form role="form" action="<?php echo site_url("masters/salaryrates/".$unit_id);?>" method="post">
                    <div class="box-body row">
                        <div class="col-md-12" >
                            <div class="row">
                                <div class="col-md-2">
                                    <label for="designation">Designation</label><span style="color:red;">*</span>
                                </div>
                                <div class="col-md-4">
                                    <select class="form-control input-sm" id="designation_id" name="designation_id">
                                        <option value="">--Select--</option>
                                        <?php if ($desig) { for ($i=0; $i < count($desig); $i++) { ?>
                                            <option value="<?=$desig[$i]['designation_id'];?>"><?=$desig[$i]['designation_name'];?></option>
                                        <?php }} ?>
                                    </select>
                                </div> 
                            </div>

                            <br>
                            <div id="salratedata">
                                
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        <button type="submit" name="submitBtn" value="submit" class="btn btn-primary submitdisbtn" disabled >Submit</button>
                    </div>
                </form>
            </div>
            <div class="tab-pane" id="salaryrateslist">
                <table class="table">
                    <tr>
                        <th>SlNo.</th>
                        <th>Designation</th>
                        <th>Strength</th>
                        <th>Duty Hrs.</th>
                        <th>Gross</th>
                        <th>Deduction</th>
                        <th>Create Dt.</th>
                        <th>Update Dt.</th>
                        <th>Action</th>
                    </tr>
                    <?php if ($salrate) { for ($i=0; $i <count($salrate) ; $i++) { ?>
                        <tr>
                            <td><?=$i+1;?></td>
                            <td><?=$salrate[$i]['designation_name'];?></td>
                            <td class="text-center"><?=$salrate[$i]['post_strength'];?></td>
                            <td class="text-center"><?=$salrate[$i]['duty_hrs'];?></td>
                            <td class="text-right"><?=$salrate[$i]['gross'];?></td>
                            <td class="text-right"><?=$salrate[$i]['totdeduction'];?></td>
                            <td><?=date('d-m-Y',strtotime($salrate[$i]['srcreated_on']));?></td>
                            <td><?=$salrate[$i]['srupdated_on']?date('d-m-Y',strtotime($salrate[$i]['srupdated_on'])):'';?></td>
                            <td>
                                
                                <?php if(in_array('salaryratesdelete', $accessar) || $this->session->userdata('usertype') == 'Admin'){ ?>
                                    <a href="<?php echo site_url("masters/delete_salaryrates/".$salrate[$i]['salary_rates_id']);?>" class="btn btn-danger btn-xs" onclick="return confirm('Are you sure for delete?');"><i class="fa fa-trash"></i></a>
                                <?php }?>
                            </td>
                        </tr>
                    <?php }} ?>
                </table>
            </div>


                    </div>
                </div>
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
        $('.clockpick').clockpicker({
            autoclose:true
        });
        
        $(document).on('click', '#unit_status', function(){
          var unit_id = $(this).val();
          
          var url = "<?php echo site_url(); ?>";
          document.location.href=url+'/masters/unitstatus/'+unit_id;
         
        }); 

        $(document).on("change keyup",".calc_amt",function(){
            var obj = $(this).closest("tr");
            let wgs_amt =  parseFloat(obj.find(".amount").val());
            
            if (obj.find(".pf").val()=='Yes') {
                    obj.find(".pfamount").val(wgs_amt.toFixed(0));
            }else{
                obj.find(".pfamount").val(0);
            }

            if (obj.find(".esi").val()=='Yes') {
                    obj.find(".esiamount").val(wgs_amt.toFixed(0));
            }else{
                obj.find(".esiamount").val(0);
            }

        calculate();
        });
        
        $(document).on("change keyup",".deduction_amt",function(){
        calculate();
        });

        $(document).on("change","#designation_id",function(){
            let designation_id = $(this).val();
            let unit_id = '<?php echo $unit_id; ?>'

            if (designation_id != '') {
            $.ajax({
                url: '<?=site_url("masters/get_SalrateData");?>',
                data: {designation_id : designation_id, unit_id : unit_id},
                dataType:"HTML",
                type:"POST",
                success:function(data){
                  if (data) {
                    
                    $("#salratedata").html(data);
                    $(".submitdisbtn").removeAttr('disabled');
                   calculate();
                  }else{
                    $("#salratedata").html('');
                    calculate();
                  }
                }
              });
        }else{
            $("#salratedata").html('');
            $(".submitdisbtn").attr('disabled','disabled');
            calculate();
        }
        });

        $(document).on("click",".wpf",function(){
            var obj = $(this).closest("tr");
             
            let wgs_amt =  parseFloat(obj.find(".amount").val());


            
            if(this.checked){
                obj.find(".pf").val('Yes');
                obj.find(".pfamount").val(wgs_amt.toFixed(0));
                
            }else{
                obj.find(".pf").val('');
                obj.find(".pfamount").val(0);
                
            }
        });

         $(document).on("click",".wesi",function(){
            var obj = $(this).closest("tr");
             
             let wgs_amt =  parseFloat(obj.find(".amount").val());
            
            if(this.checked){
                obj.find(".esi").val('Yes');
                obj.find(".esiamount").val(wgs_amt.toFixed(0));
                
            }else{
                obj.find(".esi").val('');
                obj.find(".esiamount").val(0);
                
            }
        });
         $(document).on("click",".wfixrate",function(){
            var obj = $(this).closest("tr");
            
            if(this.checked){
                obj.find(".fixrate").val('Yes');
            }else{
                obj.find(".fixrate").val('');
            }
        });

         /*$(document).on("change","#month",function(){
            var date = $(this).val();
            if (date != '') {
            $.ajax({
                url: '<?=site_url("masters/get_monthyear");?>',
                data: {date : date},
                dataType:"HTML",
                type:"POST",
                success:function(data){
                  if (data) {
                    $("#pfcalc_days").val(data.split('@#,')[0]);
                    $("#month_day").val(data.split('@#,')[1]);
                  }else{
                    $("#pfcalc_days").val('0');
                    $("#month_day").val('0');
                  }
                }
              });
        }
         });*/


         function calculate(){


               var start = new Date($("#month option:selected").attr("firstdate"));
                  var end = new Date($("#month option:selected").attr("lastdate"));
                  
                var diff = new Date(end - start);
                  var days = 1;
                  days = diff / 1000 / 60 / 60 / 24;
                  if (days == NaN) {
                    var totdt = days;
                  } else {
                    var totdt = days + 1;
                  }


                  var totalSundays = 0;

                    for (var i = start; i <= end; ){
                        if (i.getDay() == 0){
                            totalSundays++;
                        }
                        i.setTime(i.getTime() + 1000*60*60*24);
                    }

            var montdays = totdt; 

             var basic_cat = $("#basic_cat").val();
             var pfon_amt = $("#pfon_amt").val();
             var thirty_one = $("#thirty_one").val();
             var thirty = $("#thirty").val();
             var twenty_nine = $("#twenty_nine").val();
             var twenty_eight = $("#twenty_eight").val();

             $("#month_day").val(totdt);

             if (montdays == 31) {
                var pfcalDays = thirty_one;
            }else if (montdays == 30) {
                var pfcalDays = thirty;
            }else if (montdays == 29) {
                var pfcalDays = twenty_nine;
            }else if (montdays == 28) {
                var pfcalDays = twenty_eight;
            }

             
             
             //alert(pfcalDays)
            
                //var pfcalDays = $("#pfcalc_days").val();
                var esi_ded = $("#esi_ded").val(); 
                var bonuspercent = parseFloat($("#bonuspercent").val());
                var leavepercent = parseFloat($("#leavepercent").val());

                if (basic_cat =='Fix') {
                    var tatalbasicamt = parseFloat($("#basicamount").val());
                }else{
                    var tatalbasicamt = parseFloat($("#basicamount").val()) * pfcalDays;
                }
                
                
                var bnsonamount = parseFloat($("#bnsonamount").val());
                var bns_asperamount = $("#bns_asperamount").val();
                var lveonamount = parseFloat($("#lveonamount").val());
                var lve_asperamount = $("#lve_asperamount").val();
                
                if (bns_asperamount=='Yes' && tatalbasicamt >= bnsonamount ) {
                    var bonusamt = bnsonamount * (bonuspercent/100);
                }else{
                    var bonusamt = tatalbasicamt * (bonuspercent/100);
                }

                if (lve_asperamount=='Yes' && tatalbasicamt >= lveonamount ) {
                    var leaveamt = lveonamount * (leavepercent/100);
                }else{
                    var leaveamt = tatalbasicamt * (leavepercent/100);
                }

                //var bonusamt = tatalbasicamt * (bonuspercent/100);
                //var leaveamt = tatalbasicamt * (leavepercent/100);

                var food = parseFloat($("#food").val());
                var other_ded = parseFloat($("#other_ded").val());
                var uniform = parseFloat($("#uniform").val());

               

                if ($('input[name="food_asperduty"]').is(':checked')) {
                    var food_amt = (food / pfcalDays) * pfcalDays;
                }else{
                     var food_amt = food;
                }

                if ($('input[name="othded_asperduty"]').is(':checked')) {
                    var other_ded_amt = (other_ded / pfcalDays) * pfcalDays;
                }else{
                     var other_ded_amt = other_ded;
                }

                if ($('input[name="uniform_asperduty"]').is(':checked')) {
                    var uniform_amt = (uniform / pfcalDays) * pfcalDays;
                }else{
                     var uniform_amt = uniform;
                }

                //Total Deduction
               var totalDeduction = food_amt + uniform_amt + other_ded_amt;


                var inputs1 = $(".amount");
                var allowanceAmt = 0;
                for(var i = 1; i < inputs1.length; i++){
                    if($(inputs1[i]).val() != ''){
                        allowanceAmt = allowanceAmt + parseFloat($(inputs1[i]).val());
                    }
                }
                allowanceAmt = allowanceAmt;

                //Total Allowance
                var totallowance = (allowanceAmt / pfcalDays) * pfcalDays;

                var grossWages = tatalbasicamt + totallowance + bonusamt + leaveamt;

                //EPF
                 if ($("#basicpf").is(':checked')) {
                    var basic = tatalbasicamt;
                }else if (pfon_amt > 0) {
                    var basic = pfon_amt;
                }else{
                     var basic = 0;
                }

                var epf = basic * (12/100);

                var inputs2 = $(".esiamount");
                var esiAmt = 0;
                for(var i = 1; i < inputs2.length; i++){
                    if($(inputs2[i]).val() != ''){
                        esiAmt = esiAmt + parseFloat($(inputs2[i]).val());
                    }
                }
                esiAmt = esiAmt;

                //ESI 
                if (esi_ded =='Yes') {
                    var esi = grossWages * (0.75/100);
                }else{
                    var esi = esiAmt * (0.75/100);
                }

                //ESI ON BASIC

                if ($("#basicesi").is(':checked')) {
                    var basicesi = tatalbasicamt;
                }else{
                     var basicesi = 0;
                }

                var esib = basicesi * (0.75/100); 
                if (esi_ded =='Yes') {
                    var totesi = esi;
                }else{
                    var totesi = esi + esib;
                }

                if (totesi > 21000) {
                    totesi = 21000;
                }else{
                    totesi = totesi;
                }
                

                var netInHand =  grossWages - epf - totesi - totalDeduction;

               

                $("#totbasic").val(tatalbasicamt.toFixed(2));
                $("#epf").val(epf.toFixed(2));
                $("#esi").val(totesi.toFixed(2));
                $("#bonusamt").val(bonusamt.toFixed(2));
                $("#leave").val(leaveamt.toFixed(2));
                $("#totallowance").val(totallowance.toFixed(2));
                $("#totdeduction").val(totalDeduction.toFixed(2));
                $("#gross").val(grossWages.toFixed(2));
                $("#netinhand").val(netInHand.toFixed(0));
                
        }


    </script>
</body>
</html>