<?php $this->load->view("common/meta");?>
<div class="wrapper">

  <?php $this->load->view("common/sidebar");?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Examinations
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <form role="form" action="<?php echo site_url("cheque/addcheque");?>" method="post" id="searchForm">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Add Cheque</h3>
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
                
                  <div class="col-md-6">
                    <div class="row">
			<div class="col-md-6">
                        <div class="form-group">
                          <label for="amt">Date</label><span style="color:red;">*</span>
                            <input type="date" name="date" id="date" class="form-control">
                        </div>
                      </div>
			<div class="col-md-6">
                        <div class="form-group">
                          <label for="amt">Amount</label><span style="color:red;">*</span>
                            <input type="text" name="amt" id="amt" class="form-control">
                        </div>
                      </div>
			<div class="col-md-6">
                        <div class="form-group">
                          <label for="chk_no">Cheque No.</label><span style="color:red;">*</span>
                            <input type="text" name="chk_no" id="chk_no" class="form-control">
                        </div>
                      </div>
			<div class="col-md-6">
                        <div class="form-group">
                          <label for="bank">Bank</label><span style="color:red;">*</span>
                            <input type="text" name="bank" id="bank" class="form-control">
                        </div>
                      </div>
			<div class="col-md-6">
                        <div class="form-group">
                          <label for="branch">Branch</label><span style="color:red;">*</span>
                            <input type="text" name="branch" id="branch" class="form-control">
                        </div>
                      </div>
      <div class="col-md-6">
                        <div class="form-group">
                          <label for="session_id">Session</label>
                          <select class="form-control " id="session_id" name="session_id" readonly="readonly">
                            <?php if($sessions){ for($i=0;$i<count($sessions);$i++){if($sessions[$i]['active_session'] == 'Active'){?>
                            <option value="<?php echo $sessions[$i]['session_id'];?>" <?php echo $sessions[$i]['active_session'] == 'Active' ? 'selected="selected"' : '';?>><?php echo $sessions[$i]['session_name'];?></option>
                            <?php }}}?>
                          </select>
                        </div>
                      </div>
                      
      <div class="col-md-6">
                        <div class="form-group">
                          <label for="phn_no">Phone No.</label>
                            <!-- <span id="mobile"></span> -->
                            <input type="text" name="phn_no" class="form-control">
                        </div>
                      </div>
                      
      <div class="col-md-6">
                        <div class="form-group">
                          <label for="deposit_ac">Deposit in which account</label><span style="color:red;">*</span>
                          <select class="form-control " id="deposit_ac" name="deposit_ac" required="required">
                            <option value="">select</option>			    
                          </select>
                        </div>
                      </div>
					
			<div class="col-md-12">
                        <div class="form-group">
                          <label for="remarks">Remarks</label>
                            <textarea name="remarks" class="form-control"></textarea>
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
</script>
</body>
</html>