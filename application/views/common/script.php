<script src="<?php echo base_url()?>bower_components/jquery/dist/jquery.min.js"></script>
<script src="<?php echo base_url()?>bower_components/jquery-ui/jquery-ui.min.js"></script>
<script>
  $.widget.bridge('uibutton', $.ui.button);
  var appUrl = '<?php echo site_url();?>';
</script>
<script src="<?php echo base_url()?>bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="<?php echo base_url()?>bower_components/jquery-sparkline/dist/jquery.sparkline.min.js"></script>
<script src="<?php echo base_url()?>plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="<?php echo base_url()?>plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<script src="<?php echo base_url()?>bower_components/jquery-knob/dist/jquery.knob.min.js"></script>
<script src="<?php echo base_url()?>bower_components/moment/min/moment.min.js"></script>
<script src="<?php echo base_url()?>bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<script src="<?php echo base_url()?>bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script src="<?php echo base_url()?>plugins/timepicker/bootstrap-timepicker.min.js"></script>
<script src="<?php echo base_url()?>bower_components/select2/dist/js/select2.full.min.js"></script>

<script src="<?php echo base_url()?>plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<script src="<?php echo base_url()?>bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<script src="<?php echo base_url()?>bower_components/SumoSelect/jquery.sumoselect.min.js"></script>
<script src="<?php echo base_url()?>bower_components/fastclick/lib/fastclick.js"></script>
<script src="<?php echo base_url()?>assets/js/formvalidation.js"></script>
<script src="<?php echo base_url()?>dist/js/adminlte.min.js"></script>
<script src="<?php echo base_url()?>assets/js/clockpicker.js"></script>
<script src="<?php echo base_url()?>assets/js/commonAjax.js"></script>
<script src="<?php echo base_url()?>vendor/jquery.validation/jquery.validate.min.js"></script>
<script type="text/javascript">
    $(document).on("click",".addinvoice_modalbtn",function(){
    $('.mymodal112').modal('toggle');
    $('.mymodal112').modal('show');

});
$(function () {
  $('[data-toggle="tooltip"]').tooltip()
})
</script>
<script type="text/javascript">
  /*document.onreadystatechange = function () {
  var state = document.readyState
  if (state == 'interactive') {
       document.getElementById('contents').style.visibility="hidden";
  } else if (state == 'complete') {
      setTimeout(function(){
         document.getElementById('interactive');
         document.getElementById('load').style.visibility="hidden";
         document.getElementById('content').style.visibility="visible";
      },1000);
  }
}*/
</script>
<script src="<?php echo base_url()?>bower_components/select2/dist/js/select2.full.min.js"></script>

<script>$(document).ready(function() {
        $('.select2').select2({
            placeholder: "Select a Employee",
            allowClear: true
        });
          $('.sumoselect').SumoSelect({ selectAll: true, placeholder: 'Select options' });
    });
</script>