<?php $this->load->view("common/meta");?>
<div class="wrapper">
<?php $this->load->view("common/sidebar");?>
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Routines
      </h1>
    </section>
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Routines</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="row">
                <div class="col-md-12">
                  <div class="row">
                    <form role="form" action="" method="get" id="searchForm" enctype="multipart/form-data">
                      <div class="col-md-2">
                        <div class="form-group">
                          <label for="session_id">Session</label>
                          <select class="form-control " id="session_id" name="session_id">
                            <option value=""></option>
                            <?php if($sessions){ for($i=0;$i<count($sessions);$i++){?>
                            <option value="<?php echo $sessions[$i]['session_id'];?>"><?php echo $sessions[$i]['session_name'];?></option>
                            <?php }}?>
                          </select>
                        </div>
                      </div>
                      <!--<div class="col-md-2">
                        <div class="form-group">
                          <label for="class_id">Class</label>
                          <select class="form-control " id="class_id" name="class_id">
                            <option value=""></option>
                            <?php if($classes){ for($i=0;$i<count($classes);$i++){?>
                            <option value="<?php echo $classes[$i]['class_id'];?>"><?php echo $classes[$i]['class_name'];?></option>
                            <?php }}?>
                          </select>
                        </div>
                      </div>-->
                      <div class="col-md-2">
                        <div class="form-group">
                          <label for="class_id">Routine File</label>
                          <input type="file" name="attachment" class="form-control" accept="application/pdf,image/*">
                        </div>
                      </div>
                      <div class="col-md-4" style="padding-top: 14px;">
                        <button type="submit" name="searchBtn" value="search" class="btn bg-navy btn-flat margin">Search</button>
                        <button type="submit" name="submitBtn" value="submit" class="btn bg-primary btn-flat margin" formmethod="post" formaction="<?php echo site_url("masters/academic_calendar");?>" formenctype="multipart/form-data">Add New</button>
                      </div>
                    </form>
                  </div>
                </div>
                <div class="col-md-12">
                  <table class="table table-bordered table-condensed">
                    <tr>
                      <th>Sl No</th>
                      <th>Session</th>
                      <!--<th>Class</th>-->
                      <th>Routine</th>
                      <th>Action</th>
                    </tr>
                  <?php if($records){$j = 1; for($i=0;$i<count($records);$i++){?>
                    <tr>
                      <td><?=$j?></td>
                      <td><?=$records[$i]['session_name'];?></td>
                      <!--<td><?=$records[$i]['class_name'];?></td>-->
                      <td><a href="<?=base_url().'uploads/'.$records[$i]['attachment'];?>" target="_blank" class="btn btn-primary btn-xs">File</a></td>
                      <td>
                        <?php if(in_array('routinedelete', $accessar) || $this->session->userdata('usertype') == 'Admin'){ ?>
                        <a href="<?=site_url("masters/delete_routine/".$records[$i]['routine_id']);?>" class="btn btn-danger btn-xs" onclick="return confirm('Are you sure to delete this?');">Delete</a>
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