<?php $this->load->view("common/meta");?>
<div class="wrapper">

  <?php $this->load->view("common/sidebar");?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Study Material
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="box" style="padding-left:34px;">
            <div class="box-header with-border">
              <h3 class="box-title"><?=$tab_name;?> Study Material</h3>
              <a href="<?=site_url("employee/viewmaterial");?>" class="btn btn-primary btn-sm pull-right">Back</a>
            </div>
            <!-- /.box-header -->
            <form method="post" class="form-horizontal" autocomplete="off" enctype="multipart/form-data">
                  <div class="form-group row" style="padding-top:10px;">
                    <div class="col-md-2"><label for="class_id">Select Class</label></div>
                    <div class="col-md-4">
                      <select class="form-control" name="class_id" id="class_id" required onchange="loadTaggedSubject('subject_id',this.value,<?=$teacherId;?>,0);loadstudentagainstclassdropdown('student_id',this.value)">
                        <option value="">-Select-</option>
                      </select>
                    </div>
                  </div>


                  <div class="form-group row">
                    <div class="col-md-2"><label for="subject_id">Subject</label></div>
                    <div class="col-md-4">
                      <select class="form-control" name="subject_id" id="subject_id" onchange="return loadchapter('chapter_id',$('#class_id').val(),this.value)" required>
                        <option value="">-Select-</option>
                      </select>
                    </div>
                  </div>


                  <div class="form-group row">
                    <div class="col-md-2"><label for="chapter_id">Chapter</label></div>
                    <div class="col-md-4">
                      <input type="text" name="chapter_id" class="form-control">
                    </div>
                  </div>

                  <div class="form-group row">
                    <div class="col-md-2"><label for="no_of_class">Supportive Document(if any pdf doc or image file)</label></div>
                    <div class="col-md-4">
                      <input type="file" class="form-control form-control-sm" name="material_file" id="material_file">
                      <input type="hidden" name="hdnmaterial_file" id="hdnmaterial_file" value="<?php echo (!empty($material_data))?$material_data[0]['material_file']:'';?>">
                    </div>
                  </div>


                  <div class="form-group row">
                    <div class="col-md-2"><label for="material_remark"> Remark</label></div>
                    <div class="col-md-4">
                      <textarea name="material_remark" rows="5" cols="54" id="material_remark" ></textarea>
                    </div>
                  </div>

                  <div class="form-group row" style="padding-bottom:10px; padding-left:14px;">
                      <button type="submit" name="submitBtn" value="submit" class="btn btn-primary"><?=$btn_val;?></button>
                  </div>
                </form>
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
      <?php  if($material_id>0){ ?>
          loadTaggedClass('class_id','<?=$teacherId;?>','<?=$material_data[0]['class_id'];?>');
          loadTaggedSubject('subject_id','<?=$material_data[0]['class_id'];?>','<?=$teacherId;?>','<?=$material_data[0]['subject_id'];?>');
          loadchapter('chapter_id','<?=$material_data[0]['class_id'];?>','<?=$material_data[0]['subject_id'];?>','<?=$material_data[0]['chapter_id'];?>')
          $('#material_remark').val('<?=$material_data[0]['material_remark'];?>');
          
      <?php }else{ ?>
        loadTaggedClass('class_id','<?=$teacherId;?>');
     <?php  } ?>
  });
</script>
</body>
</html>
