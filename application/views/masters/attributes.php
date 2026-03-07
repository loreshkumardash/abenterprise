<?php $this->load->view("common/meta");?>
<div class="wrapper">

  <?php $this->load->view("common/sidebar");?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Master Data
        <small>Attributes</small>
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <?php if(in_array('attributesadd', $accessar) || $this->session->userdata('usertype') == 'Admin'){ ?>
        <div class="col-md-4">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Add Attributes</h3>
            </div>
            <!-- /.box-header -->
            <form role="form" action="<?php echo site_url("masters/attributes/".$did."");?>" method="post">
            <div class="box-body">
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
                
                
              <div class="form-group">
                <label for="grade">Grade</label>
                <select class="form-control" id="grade" name="grade" >
                    <option value=""> Select </option>
                    <option value="A1" <?php echo $rec[0]['grade']== 'A1' ?'selected="selected"':'';?>> &nbsp A1 </option>
                    <option value="A2" <?php echo $rec[0]['grade']== 'A2' ?'selected="selected"':'';?>> &nbsp A2 </option>
                    <option value="B1" <?php echo $rec[0]['grade']== 'B1' ?'selected="selected"':'';?>> &nbsp B1 </option>
                    <option value="B2" <?php echo $rec[0]['grade']== 'B2' ?'selected="selected"':'';?>> &nbsp B2 </option>
                    <option value="C1" <?php echo $rec[0]['grade']== 'C1' ?'selected="selected"':'';?>> &nbsp C1 </option>
                    <option value="C2" <?php echo $rec[0]['grade']== 'C2' ?'selected="selected"':'';?>> &nbsp C2 </option>
                    <option value="D" <?php echo $rec[0]['grade']== 'D' ?'selected="selected"':'';?>> &nbsp D </option>
                    <option value="E" <?php echo $rec[0]['grade']== 'E' ?'selected="selected"':'';?>> &nbsp E </option>
                </select>
              </div>
              <div class="form-group">
                <label for="class_description">Attribute</label>
                <textarea type="text" class="form-control" id="attribute" name="attribute" placeholder="Enter Attribute"><?php echo isset($rec[0]['attribute'])?$rec[0]['attribute']:'';?></textarea>
              </div>
            </div>
            <div class="box-footer">
              <button type="submit" name="submitBtn" value="submit" class="btn btn-primary">Submit</button>
            </div>
            </form>
          </div>
        </div>
        <?php }?>
        <div class="col-md-8">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">List Attributes</h3>
            </div>
            <div class="box-body">
              <table id="" class="table table-bordered table-condensed table-striped">
                <tr>
                  <th width="10%">#Sl</th>
                  <th width="10%">Grade</th>
                  <th width="60%">Attribute</th>
                  
                  <th width="20%">Action</th>
                </tr>
                <?php if($records){ for($i=0;$i<count($records);$i++){?>
                <tr>
                  <td><?php echo $i+1;?></td>
                  <td><?php echo $records[$i]['grade'];?></td>
                  <td><?php echo $records[$i]['attribute'];?></td>
                 
                  <td>
                    <?php if(in_array('classedit', $accessar) || $this->session->userdata('usertype') == 'Admin'){ ?>
                    <a href="<?php echo site_url("masters/attributes/".$records[$i]['id']);?>" class="btn btn-xs btn-warning">Edit</a>
                    <?php }?>
                    <?php if(in_array('classdelete', $accessar) || $this->session->userdata('usertype') == 'Admin'){ ?>
                    <a href="<?php echo site_url("masters/deleteattribute/".$records[$i]['id']);?>" class="btn btn-xs btn-danger" onclick="return confirm('Are you sure to delete this?');">Delete</a>
                    <?php }?>
                  </td>
                </tr>
                <?php }} ?>
              </table>
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
</body>
</html>