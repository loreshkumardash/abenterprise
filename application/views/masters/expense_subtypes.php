<?php $this->load->view("common/meta");?>
<div class="wrapper">

  <?php $this->load->view("common/sidebar");?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Master Data
        <small>Expense Sub Types</small>
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <?php if(in_array('expensesubtypeadd', $accessar) || $this->session->userdata('usertype') == 'Admin'){ ?>
        <div class="col-md-4">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Add Expense Sub Types</h3>
            </div>
            <!-- /.box-header -->
            <form role="form" action="<?php echo site_url("masters/expense_subtypes");?>" method="post" enctype="multipart/form-data">
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
                <label for="expense_name">Sub Type</label>
                <select class="form-control" id="expense_type_id" name="expense_type_id" required>
                	<option value="">Select</option>
                	<?php if ($exprec) {for ($i=0; $i <count($exprec) ; $i++) { ?>
                		<option value="<?=$exprec[$i]['id'];?>"><?=$exprec[$i]['expense_name'];?></option>
                	<?php } }
                	?>
                	
                </select>
              </div>  
              <div class="form-group">
                <label for="expense_name">Sub Type Name</label>
                <input type="text" class="form-control" id="expense_name" name="expense_name" placeholder="Enter Expense Sub Types Name" required>
              </div>
              <div class="form-group">
                <label for="expense_name">Entry Type</label>
                <select class="form-control" id="entry_type" name="entry_type" >
                  <option value="1" >Single</option>
                  <option value="2" >Multiple</option>
                </select>
              </div>
              <div class="form-group">
                <label for="expense_name">Icon</label>
                <input type="file" name="expense_subtypeicon" class="form-control" accept="image/*">
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
              <h3 class="box-title">List Expense Sub Types</h3>
            </div>
            <div class="box-body">
              <table id="" class="table table-bordered table-condensed table-striped">
                <tr>
                  <th>Expense Sub Type</th>
                  <th>Entry Type</th>
                  <th>Expense Type</th>
                  <th>Icon</th>
                  <th>Action</th>
                </tr>
                <?php if($records){ for($i=0;$i<count($records);$i++){?>
                <tr>
                  <td><?php echo $records[$i]['expense_subtypename'];?></td>
                  <td><?php echo $records[$i]['entry_type']=='1'?'Single':'Multiple';?></td>
                  <td><?php echo $records[$i]['expense_name'];?></td>
                  <td><img src="<?=base_url("uploads/expenseicon/".$records[$i]['expense_subtypeicon']);?>"></td>
                  <td>
                  	<?php if(in_array('expensesubtypeedit', $accessar) || $this->session->userdata('usertype') == 'Admin'){ ?>
                    <a href="<?php echo site_url("masters/editexpensesubtype/".$records[$i]['expense_subtypes_id']);?>" class="btn btn-xs btn-warning" >Edit</a>
                    <?php }?>
                    <?php if(in_array('expensesubtypedelete', $accessar) || $this->session->userdata('usertype') == 'Admin'){ ?>
                    <a href="<?php echo site_url("masters/deleteexpensesubtypes/".$records[$i]['expense_subtypes_id']);?>" class="btn btn-xs btn-danger" onclick="return confirm('Are you sure to delete this?');">Delete</a>
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