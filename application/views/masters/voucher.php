<?php $this->load->view("common/meta");?>
<style type="text/css">
  .select2-container--default .select2-selection--multiple .select2-selection__choice {
    background-color: #ac2828 !important;
  }
</style>
<div class="wrapper">

  <?php $this->load->view("common/sidebar");?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Master Data
        <small>Voucher</small>
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <?php if(in_array('vouchersadd', $accessar) || $this->session->userdata('usertype') == 'Admin'){ ?>
        <div class="col-md-4">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Add Voucher</h3>
            </div>
            <!-- /.box-header -->
            <form role="form" action="<?php echo site_url("masters/voucher/$vid");?>" method="post" enctype="multipart/form-data">
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
              <label for="voucher_type">Voucher Type:</label>
              <select class="form-control form-control-sm" name="voucher_type" id="voucher_type">
                <option value="">Select Voucher Type</option>
                <option value="Quotation">Quotation</option>
                <option value="Sale Order">Sale Order</option>
                <option value="Purchase Order">Purchase Order</option>
                <option value="Expenses">Expenses</option>
                <option value="Enquiry">Enquiry</option>
              </select>  
            </div>

            <div class="form-group">
              <label for="level_number">Enter Level (1-4):</label>
              <select id="level_number" name="level_number" class="form-control form-control-sm" >
                <option value="">-Select-</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
              </select>
            </div>

           
                <div class="form-group level1" style="display: none;">
                  <label>Level-1</label><br>
                  <select class="form-control" id="employee_ids1" name="employee_ids1[]" multiple="multiple" style="color:black;width: 100%;">
                    <?php foreach ($employees as $employee): ?>
                      <option value="<?php echo $employee['employee_id']; ?>"><?php echo $employee['employee_name']; ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
                <div class="form-group level2" style="display: none;">
                  <label>Level-2</label><br>
                  <select class="form-control" id="employee_ids2" name="employee_ids2[]" multiple="multiple" style="color:black;width: 100%;">
                    <?php foreach ($employees as $employee): ?>
                      <option value="<?php echo $employee['employee_id']; ?>"><?php echo $employee['employee_name']; ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
                <div class="form-group level3" style="display: none;">
                  <label>Level-3</label><br>
                  <select class="form-control" id="employee_ids3" name="employee_ids3[]" multiple="multiple" style="color:black;width: 100%;">
                    <?php foreach ($employees as $employee): ?>
                      <option value="<?php echo $employee['employee_id']; ?>"><?php echo $employee['employee_name']; ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
                <div class="form-group level4" style="display: none;">
                  <label>Level-4</label><br>
                  <select class="form-control" id="employee_ids4" name="employee_ids4[]" multiple="multiple" style="color:black;width: 100%;">
                    <?php foreach ($employees as $employee): ?>
                      <option value="<?php echo $employee['employee_id']; ?>"><?php echo $employee['employee_name']; ?></option>
                    <?php endforeach; ?>
                  </select>
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
              <h3 class="box-title">List Voucher</h3>
            </div>
            <div class="box-body">
              <table id="" class="table table-bordered table-condensed table-striped">
                <tr>
                  <th>ID</th>
                  <th>Voucher Type</th>
                  <th>Levels</th>
                  <th>Name</th>
                  <th>Action</th>
                </tr>
                <?php if($records){ for($i=0;$i<count($records);$i++){?>
                <tr>
                  <td><?php echo $records[$i]['vid'];?></td>
                  <td><?php echo $records[$i]['voucher_type'];?></td>
                  <td><?php echo $records[$i]['level_number']?></td>
                  <!-- <td><?php echo $records[$i]['field_values'];?></td> -->
                  <td>
                    <?php 
                    
                    $level1 = json_decode($records[$i]['level_1'], true);
                    $level2 = json_decode($records[$i]['level_2'], true);
                    $level3 = json_decode($records[$i]['level_3'], true);
                    $level4 = json_decode($records[$i]['level_4'], true);
                    if ($level1) {
                      echo '<b style="color:orange;">LEVEL-1 </b>';
                      foreach ($level1 as $value) {
                        $emp = $this->Common_Model->db_query("SELECT employee_name FROM employees WHERE employee_id=".$value);
                        if ($emp) {
                          echo $emp[0]['employee_name'].', ';
                        }
                      }
                      echo '</br>';
                    }
                    if ($level2) {
                      echo '<b style="color:orange;">LEVEL-2 </b>';
                      foreach ($level2 as $value) {
                        $emp = $this->Common_Model->db_query("SELECT employee_name FROM employees WHERE employee_id=".$value);
                        if ($emp) {
                          echo $emp[0]['employee_name'].', ';
                        }
                      }
                      echo '</br>';
                    }
                    if ($level3) {
                      echo '<b style="color:orange;">LEVEL-3 </b>';
                      foreach ($level3 as $value) {
                        $emp = $this->Common_Model->db_query("SELECT employee_name FROM employees WHERE employee_id=".$value);
                        if ($emp) {
                          echo $emp[0]['employee_name'].', ';
                        }
                      }
                      echo '</br>';
                    }
                    if ($level4) {
                      echo '<b style="color:orange;">LEVEL-4 </b>';
                      foreach ($level4 as $value) {
                        $emp = $this->Common_Model->db_query("SELECT employee_name FROM employees WHERE employee_id=".$value);
                        if ($emp) {
                          echo $emp[0]['employee_name'].', ';
                        }
                      }
                      echo '</br>';
                    }
                    ?>
                  </td>
                  <td>
        <?php if(in_array('vouchersedit', $accessar) || $this->session->userdata('usertype') == 'Admin'){ ?>
                    <a href="<?php echo site_url("masters/edit_vouchertype/".$records[$i]['vid']);?>" class="btn btn-xs btn-warning">Edit</a>
                    <?php } ?>
                    <?php if(in_array('vouchersdelete', $accessar) || $this->session->userdata('usertype') == 'Admin'){ ?>
                    <a href="<?php echo site_url("masters/deletevoucher/".$records[$i]['vid']);?>" class="btn btn-xs btn-danger" onclick="return confirm('Are you sure to delete this?');">Delete</a>
                    <?php } ?>
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
<script type="text/javascript">
  $(document).on("change","#level_number",function(){
      if ($(this).val() == 4) {
        $(".level1").show();
        $(".level2").show();
        $(".level3").show();
        $(".level4").show();
      }else if ($(this).val() == 3) {
        $(".level1").show();
        $(".level2").show();
        $(".level3").show();
        $(".level4").hide();$("#employee_ids4").val(null).trigger('change');
      }else if ($(this).val() == 2) {
        $(".level1").show();
        $(".level2").show();
        $(".level3").hide();$("#employee_ids3").val(null).trigger('change');
        $(".level4").hide();$("#employee_ids4").val(null).trigger('change');
      }else if ($(this).val() == 1) {
        $(".level1").show();
        $(".level2").hide();$("#employee_ids2").val(null).trigger('change');
        $(".level3").hide();$("#employee_ids3").val(null).trigger('change');
        $(".level4").hide();$("#employee_ids4").val(null).trigger('change');
      }else {
        $(".level1").hide();$("#employee_ids1").val(null).trigger('change');
        $(".level2").hide();$("#employee_ids2").val(null).trigger('change');
        $(".level3").hide();$("#employee_ids3").val(null).trigger('change');
        $(".level4").hide();$("#employee_ids4").val(null).trigger('change');
      }



  });
</script>
<script type="text/javascript">
  $(document).ready(function(){
    $("#employee_ids1").select2()
  });
  $(document).ready(function(){
    $("#employee_ids2").select2()
  });
  $(document).ready(function(){
    $("#employee_ids3").select2()
  });
  $(document).ready(function(){
    $("#employee_ids4").select2()
  });
</script>
 


</body> 
</html>