<?php $(document).ready(function(){
    $(".configsamt").keyup(function(e){
       var basic_pay = parseFloat($(".salaryamt1").val());
       var grade_pay = parseFloat($(".salaryamt2").val());

       var dearness_amt = ((basic_pay + grade_pay) / 100 )* 154;
       $(".salaryamt3").val(dearness_amt.toFixed());
       $(".salaryamt3").attr("readonly","readonly");

       var hra_amt = ((basic_pay + grade_pay) / 100 )* 10;
       $(".salaryamt4").val(hra_amt.toFixed());
       //$(".salaryamt4").attr("readonly","readonly");

       var opjsall_amt = ((basic_pay + grade_pay) / 100 )* 15;
       $(".salaryamt5").val(opjsall_amt.toFixed());
       //$(".salaryamt5").attr("readonly","readonly");

       var spla_amt = parseFloat($(".salaryamt6").val());
       var arrear1_amt = parseFloat($(".salaryamt7").val());
       var arrear2_amt = parseFloat($(".salaryamt8").val());

       var total_amt = (basic_pay + grade_pay + dearness_amt + hra_amt + opjsall_amt + spla_amt +arrear1_amt + arrear2_amt);
       $("#total_earning").val(total_amt.toFixed());

       var epf_percentage = basic_pay + grade_pay + dearness_amt + arrear1_amt + arrear2_amt;
       var epf_amt = (epf_percentage /100)*12;

       $("#epfpercentile").val(epf_amt.toFixed());
       $("#epfpercentile").attr("readonly","readonly");
      
      var tds_amt = parseFloat($("#tdspercentile").val());
      var ptax_amt = parseFloat($("#ptaxpercentile").val());
      var tv_amt = parseFloat($("#tvpercentile").val());
      var internet_amt = parseFloat($("#internetpercentile").val());
      var electricity_amt = parseFloat($("#electricitypercentile").val());
      var medical_amt = parseFloat($("#medicalpercentile").val());
      var otherfee_amt = parseFloat($("#otherfeepercentile").val());

      var total_deduction = (epf_amt + tds_amt + ptax_amt + tv_amt + internet_amt + electricity_amt + medical_amt + otherfee_amt);

      var net_amount = total_amt - total_deduction;
      $("#netamount").val(net_amount.toFixed());
    });
});