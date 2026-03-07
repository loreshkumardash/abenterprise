<?php $this->load->view("common/meta");?>
<div class="wrapper">
<?php $this->load->view("common/sidebar");?>
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <?php if(in_array('notesadd', $accessar) || $this->session->userdata('usertype') == 'Admin'){ ?>
        <div class="col-md-5">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Notes</h3>
            </div>
            <!-- /.box-header -->
            <form role="form" action="<?php echo site_url("masters/notes");?>" method="post">
            <div class="box-body">
              <div class="row">
                <div class="col-md-12">
                  
                  <div class="form-group">
                    <label for="note">Write Notes</label>
                    <textarea class="form-control" id="note" name="note"></textarea>
                  </div>
                  
                </div>
              </div>
            </div>
            <div class="box-footer">
              <input type="submit" name="submitBtn" value="Submit" class="btn btn-primary">
            </div>
            </form>
          </div>
        </div>
        <?php }?>
        <div class="col-md-7">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">My Notes</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="row">
                <?php if($records){ for($i=0;$i<count($records);$i++){?>
                <div class="col-md-12">
                  
                  <blockquote class="pull-right">
                    <p><?=nl2br(stripslashes($records[$i]['note']));?></p>
                    <small><?=date("d/m/Y g:i a", strtotime($records[$i]['created_on']));?></small>
                  </blockquote>
                  
                </div>
                <?php }}?>
              </div>
            </div>
            <div class="box-footer">
              <?php if($records){echo $sPages; }?>
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
<script type="text/javascript">

</script>

</body>
</html>