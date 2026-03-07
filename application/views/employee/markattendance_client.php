<?php $this->load->view("common/meta");?>
<style>
 

select[readonly]
{
    pointer-events: none;
}

.table>tbody>tr[data-id], table>tbody>tr[data-id] {
    cursor: pointer;
    
}
.table>tbody>tr.product_tr:hover {
    background:#4e635e;
    color: white;
    text-transform: bold;
  }

tr {
    display: table-row;
    vertical-align: inherit;
    
}
.table>tbody>tr>td {
    padding: 2px;
}
table.dataTable {
    clear: both;
    max-width: none!important;
    border-collapse: ;
    font-size: 16px;
    font-weight: 400px;
    font-family: inherit;
    padding: 0px;

}
.customer_table tr:nth-child(even) {background: #CCC}
.customer_table tr:nth-child(odd) {background: #FFF}
 .tableFixHead          { overflow: auto; max-height: 400px; }
.tableFixHead thead th { position: sticky; top: 0; z-index: 1;background-color: #fff;color: black; }
</style>
<div class="wrapper">

<?php $this->load->view("common/sidebar");?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<!-- <section class="content-header">
    <h1>
    Mark Attendance
    </h1>
</section> -->

<!-- Main content -->
<section class="content">
    <div class="row">
        <form role="form" action="<?php echo site_url("employee/markattendance_client");?>" method="post" id="searchForm">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Mark Attendance</h3>
                </div>
            <!-- /.box-header -->

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
                        

                    <div class="row">
                        <div class="col-md-8">
                            <div class="col-md-2">
                                <label for="year">Year</label>
                              <select class="form-control form-control-sm" name="year" id="year" required="required">
                                  <option value="2023">2023</option>
                                <?php $yr = date("Y"); for ($y=0; $y < 6; $y++) { 
                                  $yrr = $yr - $y;
                                  $sel = $yrr == $year ? 'selected="selected"' : '';
                                  echo '<option value="'.$yrr.'" '.$sel.'>'.$yrr.'</option>';
                                }
                                ?>
                              </select>
                            </div>
                            <div class="col-md-2">
                                <label for="month">Month</label>
                              <select class="form-control form-control-sm" name="month" id="month" required="required" >
                                <option value="01" <?=$month == '01' ? 'selected="selected"' : '';?>>Jan</option>
                                <option value="02" <?=$month == '02' ? 'selected="selected"' : '';?>>Feb</option>
                                <option value="03" <?=$month == '03' ? 'selected="selected"' : '';?>>Mar</option>
                                <option value="04" <?=$month == '04' ? 'selected="selected"' : '';?>>Apr</option>
                                <option value="05" <?=$month == '05' ? 'selected="selected"' : '';?>>May</option>
                                <option value="06" <?=$month == '06' ? 'selected="selected"' : '';?>>Jun</option>
                                <option value="07" <?=$month == '07' ? 'selected="selected"' : '';?>>Jul</option>
                                <option value="08" <?=$month == '08' ? 'selected="selected"' : '';?>>Aug</option>
                                <option value="09" <?=$month == '09' ? 'selected="selected"' : '';?>>Sept</option>
                                <option value="10" <?=$month == '10' ? 'selected="selected"' : '';?>>Oct</option>
                                <option value="11" <?=$month == '11' ? 'selected="selected"' : '';?>>Nov</option>
                                <option value="12" <?=$month == '12' ? 'selected="selected"' : '';?>>Dec</option>
                              </select>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="employee_id">Unit/Site</label>
                                    <!--<select class="form-control" id="unit_id" required="required" name="unit_id">
                                        <option value="">select</option>
                                        <?php if($units){ for($i=0;$i<count($units);$i++){?>
                                        <option value="<?php echo $units[$i]['unit_id'];?>"><?php echo $units[$i]['unit_name'];?></option>
                                        <?php }}?>
                                    </select>-->
                                    <input type="number" class="form-control form-control-sm" name="unit_id" id="unit_id" placeholder="Unit Code">
                                </div>
                            </div>  
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="employee_id">Designation</label>
                                    <select class="form-control" id="designation_id" required="required" name="designation_id" >
                                        <option value="">select</option>
                                        <?php if($designation){ for($i=0;$i<count($designation);$i++){?>
                                        <option value="<?php echo $designation[$i]['designation_id'];?>"><?php echo $designation[$i]['designation_name'];?></option>
                                        <?php }}?>
                                    </select>

                                 
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="col-md-12 row"  style="background-color:#f2f4f5;min-height: 100px;">
                            <div class="box-header with-border" style="padding:1px;background: #2a523c;color: white;height: 25px!important;">
                                    <div class="">
                                      <h3 class="box-title" style="font-size: 14px;margin-left: 5px;margin-top: 3px;"><i class="fa fa-check" aria-hidden="true" style="background-color: green;padding: 1px;border-radius: 2px;"></i> Unit Details</h3>
                                    </div>

                            </div>
                              <table class="customer_table" width="100%" border="0">
                                    <tr>
                                      <td width="20%"><span  style="margin-left: 10px;">Name:</span></td>
                                      <td width="80%" colspan="3"><span class="unitname"></span></td>
                                    </tr>
                                    <tr>
                                      <td width="20%"><span  style="margin-left: 10px;">Location:</span></td>
                                      <td width="80%" colspan="3"><span class="unitlocation"></span></td>
                                    </tr>
                                    <tr>
                                      <td width="20%"><span  style="margin-left: 10px;">Status:</span></td>
                                      <td width="80%" colspan="3"><span class="unitstatus"></span></td>
                                    </tr>
                                    
                              </table>
                          </div>
                          </div>
                    </div>
                            
                        
                    </div>
                </div>
            </div>
        </div>
            <div class="col-md-12">
                <div class="box">
                    
                <!-- /.box-header -->

                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12 tableFixHead attendancedata" id="attendancedata" style="display:none;overflow-x: auto;min-height: 300px;">

                                <table class="table" border="0" width="100%" cellpadding="0">
                                    <thead>
                                    <tr>
                                        <th width="4%">SlNo</th>
                                        <th width="15%">Emp.Code</th>
                                        <th width="5%" style="text-align:center;">Emp.</th>
                                        
                                        <th width="9%">Payable Days</th>
                                        <th width="9%">OT</th>
                                        <th width="9%">Total Duty</th>
                                        <th width="9%">Extra Hour<br>(Days)</th>
                                        <th width="9%">Fooding</th>
                                        <th width="9%">Uniform</th>
                                        <th width="9%">P.T</th>
                                        <th width="9%">Allowance</th>
                                        <th width="4%"></th>
                                    </tr>
                                </thead>
                                <tbody class="itemslist">
                               
                                    <tr>
                                        <td width="4%">1</td>
                                        <td width="15%">
                                            <input type="text" class="form-control input-sm employee_code" name="employee_code[]" value="">
                                            <input type="hidden" class="form-control input-sm employee_id" name="employee_id[]" value="">
                                            <input type="hidden" class="form-control input-sm employee_name" name="employee_name[]" value="" readonly>
                                        </td>
                                        <td width="5%" style="text-align:center;">
                                            <span ><button type="button" class="btn btn-sm btn-secondary employee_namespan" data-toggle="tooltip" data-placement="top" title="" style="border-radius: 15px;">
                                             <i class="fa fa-question-circle" aria-hidden="true"></i>
                                            </button></span>
                                        </td>
                                        <td width="9%">
                                            <input type="number" class="form-control input-sm payable_days calc_days" name="payable_days[]" value="0" readonly step="0.01">
                                        </td>
                                        <td width="9%">
                                            <input type="number" class="form-control input-sm ot_days calc_days" name="ot_days[]" value="0" readonly step="0.01">
                                        </td>
                                        
                                        <td width="9%">
                                            <input type="number" class="form-control input-sm total_duty" name="total_duty[]" value="0" readonly step="0.01">
                                        </td>
                                        <td width="9%">
                                            <input type="number" class="form-control input-sm extra_hour calc_days" name="extra_hour[]" value="0" readonly step="0.01">
                                        </td>
                                        <td width="9%">
                                            <input type="number" class="form-control input-sm fooding calc_days" name="fooding[]" value="0.00" readonly step="0.01">
                                        </td>
                                        <td width="9%">
                                            <input type="number" class="form-control input-sm uniform calc_days" name="uniform[]" value="0.00" readonly step="0.01">
                                        </td>
                                        <td width="9%">
                                            <input type="number" class="form-control input-sm pt calc_days" name="pt[]" value="0.00" readonly step="0.01">
                                        </td>
                                        <td width="9%">
                                            <input type="number" class="form-control input-sm allowances calc_days" name="allowances[]" value="0.00" readonly step="0.01">
                                        </td>
                                        <td width="4%" style="text-align:center;">
                                            <a href="javascript:;" class="btnRemoveItm btn btn-xs btn-danger">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                </tbody>
                                    <tr>
                                        
                                        <td width="24%" colspan="3" class="text-right">Total Attendance</td>
                                        <td width="9%"><b><span id="totalpayable" style="margin-left:12px;">0</span></b></td>
                                        <td width="9%" ><b><span id="totalot" style="margin-left:12px;">0</span></b></td>
                                        <td width="9%"><b><span id="totaldutyattendance" style="margin-left:12px;">0</span></b></td>
                                        <td width="9%"><b><span id="totalextrahour" style="margin-left:12px;">0</span></b></td>
                                        <td width="9%"><b><span id="totalfooding" style="margin-left:12px;">0.00</span></b></td>
                                        <td width="9%"><b><span id="totaluniform" style="margin-left:12px;">0.00</span></b></td>
                                        <td width="9%"><b><span id="totalpt" style="margin-left:12px;">0.00</span></b></td>
                                        <td width="9%"><b><span id="totalallowances" style="margin-left:12px;">0.00</span></b></td>
                                        <td width="4%"></td>
                                    </tr>
                            </table>
                            
                                
                                
                            </div>
                            <div class="col-md-12 attendancedata" style="display:none;">
                            <a href="javascript:;" class="btn btn-xs btn-warning btnAddMoreItem pull-right">Add More</a>
                            <br><br>
                                <button type="submit" class="btn btn-primary btn-sm" value="submitBtn" name="submitBtn" onclick="return confirm('Are you sure to submit this attendance ?');">Submit</button>
                                
                                <button type="submit" class="btn bg-maroon btn-sm" value="downloadBtn" name="downloadBtn" >Download</button>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>
</div>
<!-- /.content-wrapper -->
<?php $this->load->view("common/footer");?>
</div>
<!-- ./wrapper -->

<?php $this->load->view("common/script");?>

<script type="text/javascript">
$(document).ready(function(){
    $('.timepicker').timepicker({
      showInputs: false
    })
});

$(document).on("keyup change",".calc_days",function(){
    let obj = $(this).closest('tr');
    let payable_days = parseFloat(obj.find(".payable_days").val());
    let ot_days = parseFloat(obj.find(".ot_days").val());

    let total_duty = payable_days + ot_days;
    obj.find(".total_duty").val(total_duty.toFixed(2));
     calculate();
});

$(document).on("change","#designation_id",function(){
        let designation_id = $(this).val();

        if (designation_id!='') {
            $(".attendancedata").show();
        }else{
            $(".attendancedata").hide();
        }
});

$(document).on("keyup",".employee_code",function(){

    $("#designation_id").attr('readonly','readonly');
    $("#unit_id").attr('readonly','readonly');
    $("#month").attr('readonly','readonly');
    $("#year").attr('readonly','readonly');
    var obj = $(this).closest("tr");
    var year = $("#year").val();
    var month = $("#month").val();
    var designation_id = $("#designation_id").val();
    var unit_id = $("#unit_id").val();
    var employee_code = obj.find(".employee_code").val();
   
   if (designation_id != '') {
        $.ajax({
            url: '<?=site_url("employee/get_empdataforAtten");?>',
            data: {designation_id : designation_id, employee_code : employee_code,year:year,month:month,unit_id:unit_id},
            dataType:"HTML",
            type:"POST",
            success:function(data){
               
                if (data !='') {

                obj.find(".employee_name").val(data.split('@#,')[0]);
                obj.find(".employee_namespan").attr("title",data.split('@#,')[0]);
                obj.find(".employee_id").val(data.split('@#,')[1]);
                obj.find(".payable_days").val(data.split('@#,')[2]);
                obj.find(".ot_days").val(data.split('@#,')[3]);
                obj.find(".total_duty").val(data.split('@#,')[4]);
                obj.find(".payable_days").removeAttr('readonly');
                obj.find(".ot_days").removeAttr('readonly');
                obj.find(".extra_hour").removeAttr('readonly');
                obj.find(".fooding").removeAttr('readonly');
                obj.find(".uniform").removeAttr('readonly');
                
                obj.find(".allowances").removeAttr('readonly');
                obj.find(".extra_hour").val(data.split('@#,')[5]);
                obj.find(".fooding").val(data.split('@#,')[6]);
                obj.find(".uniform").val(data.split('@#,')[7]);
                obj.find(".pt").val(data.split('@#,')[8]);
                obj.find(".allowances").val(data.split('@#,')[9]);

            }else{

                obj.find(".employee_name").val('');
                obj.find(".employee_namespan").removeAttr("title");
                obj.find(".employee_id").val();
                obj.find(".payable_days").val('0');
                obj.find(".ot_days").val('0');
                obj.find(".total_duty").val('0');
                obj.find(".payable_days").attr('readonly','readonly');
                obj.find(".ot_days").attr('readonly','readonly');
                obj.find(".extra_hour").attr('readonly','readonly');
                obj.find(".fooding").attr('readonly','readonly');
                obj.find(".uniform").attr('readonly','readonly');
                obj.find(".pt").attr('readonly','readonly');
                obj.find(".allowances").attr('readonly','readonly');
                obj.find(".extra_hour").val('0');
                obj.find(".fooding").val('0.00');
                obj.find(".uniform").val('0.00');
                obj.find(".pt").val('0.00');
                obj.find(".allowances").val('0.00');
            }
             calculate();
            }
        });
    }
});

$(document).on("click", ".btnRemoveItm", function(e){
    
      $(this).closest('tr').remove();
      calculate();
    
  });


$(".btnAddMoreItem").click(function(e){
    var sl = parseInt($(".itemslist tr").length) + 1;
    if (sl > 100) {
        alert("You can't add more than 12 items!");
        return false;
    }

    var payment_type = $("#payment_type").val();
    if (payment_type ==1) {
      var validd = '';
      var validm = 'readonly';
    }else{
      var validd = 'readonly';
      var validm = '';
    }
    
    $(".itemslist").append(' <tr><td width="4%">'+sl+'</td><td width="15%"><input type="text" class="form-control input-sm employee_code" name="employee_code[]" value=""><input type="hidden" class="form-control input-sm employee_id" name="employee_id[]" value=""><input type="hidden" class="form-control input-sm employee_name" name="employee_name[]" value="" readonly></td><td width="5%" style="text-align:center;"><span ><button type="button" class="btn btn-sm btn-secondary employee_namespan" data-toggle="tooltip" data-placement="top" title="" style="border-radius: 15px;"><i class="fa fa-question-circle" aria-hidden="true"></i></button></span></td><td width="9%"><input type="number" class="form-control input-sm payable_days calc_days" name="payable_days[]" value="0" readonly step="0.01"></td><td width="9%"><input type="number" class="form-control input-sm ot_days calc_days" name="ot_days[]" value="0" readonly step="0.01"></td><td width="9%"><input type="number" class="form-control input-sm total_duty" name="total_duty[]" value="0" readonly step="0.01"></td><td width="9%"><input type="number" class="form-control input-sm extra_hour calc_days" name="extra_hour[]" value="0" readonly step="0.01"></td><td width="9%"><input type="number" class="form-control input-sm fooding calc_days" name="fooding[]" value="0.00" readonly step="0.01"></td><td width="9%"><input type="number" class="form-control input-sm uniform calc_days" name="uniform[]" value="0.00" readonly step="0.01"></td><td width="9%"><input type="number" class="form-control input-sm pt calc_days" name="pt[]" value="0.00" readonly step="0.01"></td><td width="9%"><input type="number" class="form-control input-sm allowances calc_days" name="allowances[]" value="0.00" readonly step="0.01"></td><td width="4%" style="text-align:center;"><a href="javascript:;" class="btnRemoveItm btn btn-xs btn-danger"><i class="fa fa-trash"></i></a></td></tr>');
  });



/*$(document).on("change","#designation_id",function(){
    let designation_id = $(this).val();
    let unit_id = $("#unit_id").val();
    let year = $("#year").val();
    let month = $("#month").val();

    if (designation_id != '') {
        $.ajax({
            url: '<?=site_url("employee/get_empdataByDesignationforAtten");?>',
            data: {designation_id : designation_id, unit_id : unit_id,year : year, month : month},
            dataType:"HTML",
            type:"POST",
            success:function(data){
               
                $("#attendancedata").html(data);

            }
        });
    }
});*/

$(document).on("keyup","#unit_id",function(){
    
    let unit_id = $(this).val();

    if (unit_id != '') {
        $.ajax({
            url: '<?=site_url("employee/get_designationByUnit");?>',
            data: {unit_id : unit_id},
            dataType:"HTML",
            type:"POST",
            success:function(data){
              
                

                if (data) {
                        $("#designation_id").html(data.split(',')[0]);
                        $(".unitname").html(data.split(',')[1]);
                        $(".unitlocation").html(data.split(',')[2]);
                        $(".unitstatus").html(data.split(',')[3]);


                      }else{
                            
                      }

            }
        });
    }
});



function calculate(){
   var inputs1 = $(".total_duty");
        var itmtotal = 0;
        for(var i = 0; i < inputs1.length; i++){
            if($(inputs1[i]).val() != ''){
                itmtotal = itmtotal + parseFloat($(inputs1[i]).val());
            }
        }
    itmtotal = itmtotal;

    $("#totaldutyattendance").html(itmtotal.toFixed(2));

    var inputs2 = $(".payable_days");
        var payabletotal = 0;
        for(var i = 0; i < inputs2.length; i++){
            if($(inputs2[i]).val() != ''){
                payabletotal = payabletotal + parseFloat($(inputs2[i]).val());
            }
        }
    payabletotal = payabletotal;

     $("#totalpayable").html(payabletotal.toFixed(2));

     var inputs3 = $(".ot_days");
        var ottotal = 0;
        for(var i = 0; i < inputs3.length; i++){
            if($(inputs3[i]).val() != ''){
                ottotal = ottotal + parseFloat($(inputs3[i]).val());
            }
        }
    ottotal = ottotal;

     $("#totalot").html(ottotal.toFixed(2));
     
    var inputs4 = $(".extra_hour");
        var extra_hourtotal = 0;
        for(var i = 0; i < inputs4.length; i++){
            if($(inputs4[i]).val() != ''){
                extra_hourtotal = extra_hourtotal + parseFloat($(inputs4[i]).val());
            }
        }
    extra_hourtotal = extra_hourtotal;
     $("#totalextrahour").html(extra_hourtotal.toFixed(2));

     var inputs5 = $(".fooding");
        var foodingtotal = 0;
        for(var i = 0; i < inputs5.length; i++){
            if($(inputs5[i]).val() != ''){
                foodingtotal = foodingtotal + parseFloat($(inputs5[i]).val());
            }
        }
    foodingtotal = foodingtotal;
     $("#totalfooding").html(foodingtotal.toFixed(2));

     var inputs6 = $(".uniform");
        var uniformtotal = 0;
        for(var i = 0; i < inputs6.length; i++){
            if($(inputs6[i]).val() != ''){
                uniformtotal = uniformtotal + parseFloat($(inputs6[i]).val());
            }
        }
    uniformtotal = uniformtotal;
     $("#totaluniform").html(uniformtotal.toFixed(2));

     var inputs7 = $(".pt");
        var pttotal = 0;
        for(var i = 0; i < inputs7.length; i++){
            if($(inputs7[i]).val() != ''){
                pttotal = pttotal + parseFloat($(inputs7[i]).val());
            }
        }
    pttotal = pttotal;
     $("#totalpt").html(pttotal.toFixed(2));

     var inputs7 = $(".allowances");
        var allowancestotal = 0;
        for(var i = 0; i < inputs7.length; i++){
            if($(inputs7[i]).val() != ''){
                allowancestotal = allowancestotal + parseFloat($(inputs7[i]).val());
            }
        }
    allowancestotal = allowancestotal;
     $("#totalallowances").html(allowancestotal.toFixed(2));

}
</script>
</body>
</html>
