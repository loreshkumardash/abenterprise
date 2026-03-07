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
          <form role="form" action="<?php echo site_url("masters/editexpensesubtype/".$rec[0]['expense_subtypes_id']);?>" method="post" enctype="multipart/form-data">
        <?php if(in_array('expensetypesedit', $accessar) || $this->session->userdata('usertype') == 'Admin'){ ?>
        <div class="col-md-4">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Edit Expense Sub Types</h3>
            </div>
            <!-- /.box-header -->
            
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
                		<option value="<?=$exprec[$i]['id'];?>" <?=$rec[0]['expense_type_id']==$exprec[$i]['id']?'selected':'';?>><?=$exprec[$i]['expense_name'];?></option>
                	<?php } }
                	?>
                	
                </select>
              </div>  
              <div class="form-group">
                <label for="expense_name">Sub Type Name</label>
                <input type="text" class="form-control" id="expense_name" name="expense_name" placeholder="Enter Expense Sub Types Name" value="<?=$rec[0]['expense_subtypename'];?>" required>
              </div>
              <div class="form-group">
                <label for="expense_name">Entry Type</label>
                <select class="form-control" id="entry_type" name="entry_type" >
                  <option value="1" <?=$rec[0]['entry_type']=='1'?'selected':'';?>>Single</option>
                  <option value="2" <?=$rec[0]['entry_type']=='2'?'selected':'';?>>Multiple</option>
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
            
          </div>
        </div>
        <div class="col-md-6">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Set Limit of Expenses</h3>
            </div>
            <table class="table table-bordered table-condensed table-striped" cellpadding="0">
                <tr>
                  <th>Department</th>
                  <th>Designation</th>
                  <th>Limit Amount</th>
                </tr>
                <?php if ($designation) { for ($i=0; $i <count($designation) ; $i++) { 
                    $limitrec = $this->Common_Model->FetchData("expense_limitation","*","expense_type_id=".$rec[0]['expense_type_id']." AND expense_subtypes_id=".$rec[0]['expense_subtypes_id']." AND designation=".$designation[$i]['designation_id']);
                  ?>
                  <tr>
                    <td><?=$designation[$i]['department_name'];?></td>
                    <td><?=$designation[$i]['designation_name'];?>
                      <input type="hidden" name="designation_id[]" value="<?=$designation[$i]['designation_id'];?>">
                    </td>
                    <td><input type="number" name="limitamt[]" step="0.01" value="<?=$limitrec?$limitrec[0]['limitamt']:0;?>" style="line-height:5px;"></td>
                  </tr>
                <?php }} ?>
                
            </table>
          </div>
        </div>
        <?php }?>
        </form>
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