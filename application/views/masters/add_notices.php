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
              <h3 class="box-title">Add Notices </h3>              
            </div>
            <!-- /.box-header -->
            <form role="form" action="<?php echo site_url("masters/add_notices");?>" method="post" enctype="multipart/form-data">
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
                      <input type="text" name="notice_title" id="notice_title" class="form-control" value="<?=set_value('notice_title');?>">
                    </div>
                    <div class="col-md-4">
                      <label for="notice_no">Notice No.</label>
                      <input type="text" name="notice_no" id="notice_no" class="form-control" value="<?=set_value('notice_no');?>" readonly>
                    </div>
                    <div class="col-md-4">
                      <label for="notice_end_date">Notice End Date</label>
                      <input type="date" name="notice_end_date" id="notice_end_date" class="form-control" value="<?=set_value('notice_end_date');?>">
                    </div>
		    <div class="col-md-4">
                      <label for="notice_end_date">Upload File</label>
                      <input type="file" name="notice_file" id="notice_file" class="form-control" value="<?=set_value('notice_file');?>">
                    </div>

                    <div class="col-md-12">
                      <label for="notice_description">Notice Description</label>
                      <textarea name="notice_description" id="notice_description" class="form-control"><?=set_value('notice_description');?></textarea>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                    <label for="notice_description">Notice applicable for <input type="checkbox" class="checkall" name="allclass" value="selectall"> All Class</label>
                    <div class="row">
                        <div class="col-md-12">
                            <ul class="classlistli">
                            <?php if($classes){ for($i = 0; $i < count($classes); $i++){?>
                                <li><label for="class<?=$i?>"><input type="checkbox" class="sameclass" name="class_ids[]" id="class<?=$i?>" value="<?=$classes[$i]['class_id']?>"> <?=$classes[$i]['class_name']?></label></li>
                            <?php }}?>
                            </ul>
                        </div>
                        <div class="col-md-12">
                        <label for="sms_text">Notice SMS Text  <label class="label label-danger" for="send_sms"><input type="checkbox" name="send_sms" id="send_sms" value="1"> Send SMS</label></label>
                        <textarea name="sms_text" id="sms_text" class="form-control"><?=set_value('sms_text');?></textarea>
                        </div>
                    </div>
                </div>
              </div>
              
              
            </div>
            <div class="box-footer">
              <button type="submit" name="submitBtn" value="submit" class="btn btn-primary">Submit</button>
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
  //alert(4);
  var count = '<?=$ntc[0]['notice_no'];?>';
  count = Number(count)+1;
      document.getElementById('notice_no').value = count;
  });
</script>
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
