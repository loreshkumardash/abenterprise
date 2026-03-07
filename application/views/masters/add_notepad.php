<?php $this->load->view("common/meta");?>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
<?php $this->load->view("common/sidebar");?>
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Notepads
        <!--<a href="<?=site_url("masters/notepad");?>" class="btn btn-primary pull-right">List Notepad</a>-->
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Add Notepad</h3>
            </div>
            <form role="form" action="<?php echo site_url("masters/add_notepad");?>" method="post">
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
                  
                   <div class="col-md-8">
                  <div class="row">
                    <div class="col-md-8">
                      <label for="subject">Subject</label>
                        <input type="text" class="form-control" id="subject" name="subject" placeholder="Enter Subject">
                    </div>
                    <div class="col-md-4">
                      <label for="notice_no">Notepad No.</label>
                      <input type="text" name="notepad_no" id="notepad_no" class="form-control" value="<?=set_value('notepad_no');?>" readonly>
                    </div>
                    <div class="col-md-12">
                      <label for="notes">Notepad Text</label>
                        <textarea class="form-control" id="notes" name="notes"></textarea>
                    </div>
                    <div class="col-md-7">
                      <div id="messagecontent">
                      
                      </div>
                    </div>
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
<script src="<?=base_url();?>bower_components/select2/dist/js/select2.full.min.js"></script>
<!--<script src="https://cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>-->
<script type="text/javascript">
  //CKEDITOR.replace( 'note' );
</script>
<script type="text/javascript">
  $(document).ready(function(){
  //alert(4);
  var count = '<?=$note[0]['notepad_no'];?>';
  count = Number(count)+1;
      document.getElementById('notepad_no').value = count;
  });
</script>

<script type="text/javascript" src="<?php echo base_url();?>assets/ckeditor/ckeditor.js"></script>
<script type="text/javascript">
var editor = CKEDITOR.replace( 'notes' ,
{
  filebrowserBrowseUrl: '<?=base_url();?>assets/ckfinder/ckfinder.html',
  filebrowserImageBrowseUrl: '<?=base_url();?>assets/ckfinder/ckfinder.html?type=Images',
  filebrowserUploadUrl:   '<?=base_url();?>assets/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files&currentFolder=/archive/',
  filebrowserImageUploadUrl:    '<?=base_url();?>assets/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images&currentFolder=/cars/'
});
setInterval(function(){ $("#messagecontent").html(editor.getData()); }, 2000);
</script>
</body>
</html>