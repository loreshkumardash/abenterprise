<?php $this->load->view("common/meta");?>
<div class="wrapper">
<?php $this->load->view("common/sidebar");?>
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Notepads
        <?php if(in_array('notepadadd', $accessar) || $this->session->userdata('usertype') == 'Admin'){ ?>
        <a href="<?=site_url("masters/add_notepad");?>" class="btn btn-primary pull-right">Add Notepad</a>
        <?php }?>
      </h1>
    </section>

    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">My Notepad</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="row">
                <div class="col-md-12">
                  <table class="table table-bordered table-condensed">
                    <tr>
                      <th>Sl No</th>
                      <th>Subject</th>
                      <th>Created on</th>
                      <th>Action</th>
                    </tr>
                  <?php if($records){$j = 1; for($i=0;$i<count($records);$i++){?>
                    <tr>
                      <td><?=$j?></td>
                      <td><?=$records[$i]['subject'];?></td>
                      <td><?=date("d/m/Y g:i a", strtotime($records[$i]['created_on']));?></td>
                      <td>
                        <a href="<?=site_url("masters/view_notepad/".$records[$i]['id']);?>" class="btn btn-primary" target="_blank"><i class="fa fa-print"></i></a>
                        <?php if(in_array('notepadedit', $accessar) || $this->session->userdata('usertype') == 'Admin'){ ?>
                        <a href="<?=site_url("masters/edit_notepad/".$records[$i]['id']);?>" class="btn btn-warning"><i class="fa fa-pencil"></i></a>
                        <?php }?>
                        <?php if(in_array('notepaddelete', $accessar) || $this->session->userdata('usertype') == 'Admin'){ ?>
                        <a href="<?=site_url("masters/delete_notepad/".$records[$i]['id']);?>" class="btn btn-danger " onclick="return confirm('Are you sure to delete this?');"><i class="fa fa-trash"></i></a>
                        <?php }?>
                      </td>
                    </tr>
                  <?php $j++; }}?>
                  </table>
                </div>
              </div>
            </div>
            <div class="box-footer">
              <?php if($records){echo $sPages; }?>
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
<?php $this->load->view("common/script");?>
<script src="<?=base_url();?>bower_components/select2/dist/js/select2.full.min.js"></script>
<script type="text/javascript">

</script>

</body>
</html>