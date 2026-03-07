<?php $this->load->view("common/meta");?>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <?php $this->load->view("common/sidebar");?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Application
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <form role="form" action="<?php echo site_url("masters/add_application");?>" method="post" id="searchForm">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Add Application</h3>
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
                          <label for="class_id">Class</label>
                          <select class="form-control " id="class_id" name="class_id">
                            <option value=""></option>
                            <?php if($classes){ for($i=0;$i<count($classes);$i++){?>
                            <option value="<?php echo $classes[$i]['class_id'];?>"><?php echo $classes[$i]['class_name'];?></option>
                            <?php }}?>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="student_id">Student</label>
                          <select class="form-control" id="student_id" name="student_id" required="required">
                            <option value="">select</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="cca_name">Application Subject</label>
                          <input type="text" name="app_subject" id="app_subject" class="form-control">
                        </div>
                      </div>

                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="cca_name">Matter</label>
                          <input type="text" name="matter" id="matter" class="form-control">
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="cca_date">Date</label>
                          <input type="date" class="form-control " id="date" name="date">
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
  $("#student_id").change(function(e){
        e.preventDefault();
        if($(this).val() != ''){
          $.ajax({
            url: '<?php echo site_url("ajaxr/get_student_info");?>',
            data : {student_id : $(this).val()},
            dataType: "JSON",
            type : "POST",
            success: function(data){
              $("#parent_name").val(data.father_name);              
            }
          });
        }else{
      $("#parent_name").val("");
      $("#parent_mobile").val("");
      $("#parent_address").val("");
      $("#relation").val('');
        }
      });
</script>
</body>
</html>