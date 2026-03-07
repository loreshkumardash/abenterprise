<?php $this->load->view("common/meta");?>

<div class="wrapper">

  <?php $this->load->view("common/sidebar");?>
  
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Notices
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Edit Notices </h3>              
            </div>
            <!-- /.box-header -->
            <form role="form" action="<?php echo site_url("masters/edit_notice/".$notice[0]['notice_id']);?>" method="post" enctype="multipart/form-data">
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

                <div class="col-md-8">
                  <div class="row">
                    <div class="col-md-12">
                      <label for="notice_title">Notice Subject</label>
                      <input type="text" name="notice_title" id="notice_title" class="form-control" value="<?=stripslashes($notice[0]['notice_title']);?>">
                    </div>
                    <div class="col-md-4">
                      <label for="notice_no">Notice No.</label>
                      <input type="text" name="notice_no" id="notice_no" class="form-control" value="<?=$notice[0]['notice_no'];?>">
                    </div>
                    <div class="col-md-4">
                      <label for="notice_end_date">Notice End Date</label>
                      <input type="date" name="notice_end_date" id="notice_end_date" class="form-control" value="<?=$notice[0]['notice_end_date'];?>">
                    </div>
		    <div class="col-md-4">
                      <label for="notice_end_date">Upload File</label>
                      <input type="file" name="notice_file" id="notice_file" class="form-control" value="<?php echo isset($notice[0]['notice_file'])?$notice[0]['notice_file']:'';?>">
		      <img src="<?=base_url();?>/uploads/studentdata/<?=$notice[0]['notice_file']?>" style="width:50px; height:50px;">
                    </div>
                    <div class="col-md-12">
                      <label for="notice_description">Notice Description</label>
                      <textarea name="notice_description" id="notice_description" class="form-control"><?=stripslashes($notice[0]['notice_description']);?></textarea>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                    <label for="notice_description">Notice applicable for <input type="checkbox" class="checkall" name="allclass" value="selectall"> All Class</label>
                    <div class="row">
                        <div class="col-md-12">
                            <ul class="classlistli">
                            <?php 
                            $clsarr = explode(' ', $notice[0]['class_ids']);
                            if($classes){ for($i = 0; $i < count($classes); $i++){?>
                                <li><label for="class<?=$i?>"><input type="checkbox" class="sameclass" name="class_ids[]" id="class<?=$i?>" value="<?=$classes[$i]['class_id']?>" <?=in_array($classes[$i]['class_id'], $clsarr) ? 'checked="checked"' : '';?>> <?=$classes[$i]['class_name']?></label></li>
                            <?php }}?>
                            </ul>
                        </div>
                        <div class="col-md-12">
                        <label for="sms_text">Notice SMS Text <label class="label label-danger" for="send_sms"><input type="checkbox" name="send_sms" id="send_sms" value="1"> Send SMS</label></label>
                        <textarea name="sms_text" id="sms_text" class="form-control"><?=stripslashes($notice[0]['sms_text']);?></textarea>
                        </div>
                    </div>
                </div>
              </div>
              
              
            </div>
            <div class="box-footer">
              <button type="submit" name="submitBtn" value="submit" class="btn btn-primary">Save</button>
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
<?php $this->load->view("common/script");?>
<script type="text/javascript">
  $(document).ready(function(){
    CKEDITOR.replace('notice_description',{
        filebrowserBrowseUrl: '<?php echo base_url()?>bower_components/ckfinder/ckfinder.html',
        filebrowserUploadUrl: '<?php echo base_url()?>bower_components/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files'
    });
    $(".checkall").change(function(e){
        e.preventDefault();
        if($(this). prop("checked") == true){
            $('.sameclass').prop("checked", true);
        }else{
            $('.sameclass').prop("checked", false);
        }
    });
  });
</script>

<script type="type/javascript">
$(function () {
    
})
</script>
</body>
</html>
