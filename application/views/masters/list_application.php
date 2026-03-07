<?php $this->load->view("common/meta");?>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <?php $this->load->view("common/sidebar");?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        List Application
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">List Student</h3>
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
          
              </div>
              <div class="row">
                <div class="col-md-12" id="dataTablediv">
                  <?php if($records){?>
                  <table id="" class="table table-bordered table-condensed table-striped">
                    <tr>
                      <th>ID</th>
                      <th>Date</th>
                      <th>Session</th>
                      <th>Student Name</th>
                      <th>Class</th>
                      <th>Application Subject</th>                      
                      <th>Matter</th>
                      <th>Action</th>
                    </tr>
                    <?php if($records){ for($i=0;$i<count($records);$i++){?>
                    <tr>
                      <td><?php echo $records[$i]['id'];?></td>
                      <td><?php echo date("d/m/Y", strtotime($records[$i]['date']));?></td>
                      <td><?php echo $records[$i]['session_name'];?></td>
                      <td><?php echo $records[$i]['student_first_name'].' '.$records[$i]['student_last_name'];?></td>                      
                      <td><?php echo $records[$i]['class_name'];?></td> 
                      <td><?php echo $records[$i]['app_subject'];?></td>
                      <td><?php echo $records[$i]['matter'];?></td>
                      <td>
                        <?php if($this->session->userdata("usertype") == 'Admin'){ ?>
                        <a href="<?php echo site_url("masters/delete_application/".$records[$i]['id']);?>" class="btn btn-danger btn-xs" onclick="confirm('want to delete?');"><i class="fa fa-trash"></i></a>
                        <?php }?>
                      </td>
                    </tr>
                    <?php }} ?>
                  </table>
                  <?php }else{echo 'No records found';}?>
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