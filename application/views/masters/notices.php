<?php $this->load->view("common/meta");?>
<div class="wrapper">

  <?php $this->load->view("common/sidebar");?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Master Data
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">List Notices
              
              </h3>
              <?php if(in_array('noticeadd', $accessar) || $this->session->userdata('usertype') == 'Admin'){ ?>
              <a href="<?=site_url("masters/add_notices");?>" class="btn btn-primary btn-sm" style="float:right;">Add New</a>
              <?php }?>
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
                <form role="form" action="<?php echo site_url("masters/notices");?>" method="get" id="searchForm">
                  <div class="col-md-2">
                    <div class="form-group">
                      <label for="created_on_from">Create date from</label>
                      <input type="date" class="form-control" id="created_on_from" name="created_on_from" value="<?php echo set_value("created_on_from");?>">
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="form-group">
                      <label for="created_on_to">Create date to</label>
                      <input type="date" class="form-control" id="created_on_to" name="created_on_to" value="<?php echo set_value("created_on_to");?>">
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="form-group">
                      <label for="notice_title">Notice Title</label>
                      <input type="text" class="form-control" id="notice_title" name="notice_title" value="<?php echo set_value("notice_title");?>">
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="form-group">
                      <label for="notice_no">Notice No</label>
                      <input type="text" class="form-control" id="notice_no" name="creatnotice_noed_on_to" value="<?php echo set_value("notice_no");?>">
                    </div>
                  </div>
                  <div class="col-md-4">
                    <button type="submit" name="submitBtn" value="submit" class="btn bg-navy btn-flat margin">Search</button>
                  </div>
                </form>
              </div>
              <div class="row">
                <div class="col-md-12" id="dataTablediv">
                  <?php if($records){?>
                  <table id="" class="table table-bordered table-condensed table-striped">
                    <tr>
                      <th width="5%">ID</th>
                      <th>Notice No</th>
                      <th>Notice Title</th>
                      <th width="13%">End Date</th>
                      <th width="10%">Action</th>
                    </tr>
                    <?php if($records){ for($i=0;$i<count($records);$i++){?>
                    <tr>
                      <td><?php echo $records[$i]['notice_id'];?></td>
                      <td><?php echo $records[$i]['notice_no'];?></td>
                      <td><?php echo $records[$i]['notice_title'];?></td>
                      <td><?php echo date("d/m/Y", strtotime($records[$i]['notice_end_date']));?></td>
                      <td>
                        <?php if(in_array('noticeedit', $accessar) || $this->session->userdata('usertype') == 'Admin'){ ?>
                        <a href="<?php echo site_url("masters/edit_notice/".$records[$i]['notice_id']);?>" class="btn btn-warning btn-xs"><i class="fa fa-pencil"></i></a>
                        <?php }?>
                        <a href="<?php echo site_url("masters/view_notice/".$records[$i]['notice_id']);?>" class="btn btn-primary btn-xs" target="_blank"><i class="fa fa-print"></i></a>
                        <?php if(in_array('noticedelete', $accessar) || $this->session->userdata('usertype') == 'Admin'){ ?>
                        <a href="<?php echo site_url("masters/delete_notice/".$records[$i]['notice_id']);?>" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></a>
                        <?php }?>
                      </td>
                    </tr>
                    <?php }} ?>
                  </table>
                  <?php echo $sPages; }else{echo 'No records found';}?>
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