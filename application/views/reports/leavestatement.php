<?php $this->load->view("common/meta");?>
<div class="wrapper">

  <?php $this->load->view("common/sidebar");?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Leave Statement</h3>
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
                <form role="form" action="<?=site_url("reports/leavestatement");?>" method="post" id="searchForm" target="_blank">
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="session_id">Session</label>
                    <select class="form-control " id="session_id" name="session_id" readonly="readonly">
                      <?php if($sessions){ for($i=0;$i<count($sessions);$i++){if($sessions[$i]['active_session'] == 'Active'){?>
                      <option value="<?php echo $sessions[$i]['session_id'];?>" <?php echo $sessions[$i]['active_session'] == 'Active' ? 'selected="selected"' : '';?>><?php echo $sessions[$i]['session_name'];?></option>
                      <?php }}}?>
                    </select>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="month">Month</label>
                    <select class="form-control " id="month" name="month">
                      <option value="">Select</option>
                      <?php if ($months) { for ($i=0; $i <count($months) ; $i++) { ?>
                          <option value="<?=$months[$i]['strmonth'];?>"><?php echo date('F',strtotime($months[$i]['strmonth']));?></option>
                      <?php }} ?>
                      
                    </select>
                  </div>
                </div>
                <div class="col-md-6" style="padding-top: 15px;">
                  <button type="button" name="submitBtn" value="submit" class="btn bg-navy btn-flat margin" id="searchBtn">Search</button>

                  <button type="submit" name="downloadBtn" value="submit"class="btn bg-maroon btn-flat margin">Download</button>
                  
                </div>
                </form>
              </div>
              <div class="row">
                <div class="col-md-12" id="dataTablediv">
                  
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

  function searchForm(){
    $.ajax({
      url:"<?php echo site_url('student/liststudents_ajax');?>",
      type:"POST",
      data: $("#searchForm").serialize(),
      dataType:"html",
      success: function(data){
        $('#dataTablediv').html(data);
      }
    });
  }
  $(document).ready(function(){
      $("#searchBtn").click(function(e){
        e.preventDefault();
        var session_id = $("#session_id").val();
        var month = $("#month").val();

          if (session_id != '' && month != '') {
                $.ajax({
                    url: '<?=site_url("reports/get_leavestatement");?>',
                    data: {session_id : session_id,month:month},
                    dataType:"HTML",
                    type:"POST",
                    success:function(data){
                     
                        $("#dataTablediv").html(data);
                      
                        
                    }
                }); 
            }else{
               $("#dataTablediv").html('');
              
            }
      });
  });
</script>
</body>
</html>