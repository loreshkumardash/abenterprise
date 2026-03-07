<?php $this->load->view("common/meta");?>
<div class="wrapper">

  <?php $this->load->view("common/sidebar");?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Edit Cheque
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <form role="form" action="<?php echo site_url("cheque/edit_cheque").'/'.$rec[0]['id'];?>" method="post" id="searchForm">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
              
		          <h4 style="color:green;">Cheque No. : <?=$rec[0]['chk_no'];?></h4>
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
                  <strong>Success !</strong> <?php echo $this->session->flashdata('error');?>
                  </div>
                  <?php
                  }
                  ?>
                </div>
                
                  <div class="col-md-5">
                    <div class="row">
		       <div class="col-md-6">
                        <div class="form-group">
                          <label for="remarks">Remarks</label>
                            <textarea name="remarks" class="form-control"><?=$rec[0]['remarks'];?></textarea>
                        </div>
                      </div>
			<div class="col-md-6">
                        <div class="form-group">
                          <label for="clear_not">Clear/Not</label><br>
                            <input type="radio" value="clear" name="clear_not" onchange="my_function(this.value);">Clear
			    <input type="radio" value="Not clear" name="clear_not" onchange="my_function(this.value);">Not Clear
                        </div>
                      </div>
			<div class="col-md-6" id="c_date" style="display:none;">
                        <div class="form-group">
                          <label for="c_date">Clear date</label>
                            <input type="date" value="" name="c_date" class="form-control">
                        </div>
                      </div>
                     </div>
                  </div>
              </div>
            </div>
            <div class="box-footer">
              <button type="submit" name="submitBtn" value="submit" class="btn btn-primary" onclick="return confirm('Are you sure to submit this?')">Submit</button>
            </div>
          </div>
        </div>
        </form>
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
    $(document).ready(function(){
//alert(4);
     loadMasterBank('deposit_ac'); 
  });
</script>

<script type="text/javascript">
  $(document).ready(function(){
    $("#class_id").change(function(e){
      e.preventDefault();
      if($(this).val() != ''){
        $.ajax({
          url: '<?php echo site_url("masters/getStudentListBySessionClass");?>',
          data : {class_id : $(this).val(), session_id : $("#session_id").val()},
          dataType: "HTML",
          type : "POST",
          success: function(data){
            $("#student_id").html(data);
          }
        });
      }else{
        $("#student_id").html('<option value="">select</option>');
      }
    });
  });

    function my_function(status){
	    //alert(status);
	if(status == 'clear'){
	   $('#c_date').show();
	}else{
	   $('#c_date').hide();
	} 
    }
</script>
</body>
</html>