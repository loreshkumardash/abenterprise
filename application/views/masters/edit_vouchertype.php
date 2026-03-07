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
        <small>Voucher Approval</small>
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <?php if(in_array('vouchersedit', $accessar) || $this->session->userdata('usertype') == 'Admin'){ ?>
        <div class="col-md-4">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Edit Voucher Approval</h3>
            </div>
            <!-- /.box-header -->
            <form role="form" action="<?php echo site_url("masters/edit_vouchertype/").$rec[0]['vid']?>" method="post">
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
                <option value="Quotation" <?=$rec[0]['voucher_type']=='Quotation'?'selected':'';?>>Quotation</option>
                <option value="Sale Order" <?=$rec[0]['voucher_type']=='Sale Order'?'selected':'';?>>Sale Order</option>
                <option value="Purchase Order" <?=$rec[0]['voucher_type']=='Purchase Order'?'selected':'';?>>Purchase Order</option>
                <option value="Expenses" <?=$rec[0]['voucher_type']=='Expenses'?'selected':'';?>>Expenses</option>
                <option value="Enquiry" <?=$rec[0]['voucher_type']=='Enquiry'?'selected':'';?>>Enquiry</option>
              </select>  
            </div>

            <div class="form-group">
              <label for="level_number">Enter Level (1-4):</label>
              <select id="level_number" name="level_number" class="form-control form-control-sm" >
                <option value="">-Select-</option>
                <option value="1" <?=$rec[0]['level_number']=='1'?'selected':'';?>>1</option>
                <option value="2" <?=$rec[0]['level_number']=='2'?'selected':'';?>>2</option>
                <option value="3" <?=$rec[0]['level_number']=='3'?'selected':'';?>>3</option>
                <option value="4" <?=$rec[0]['level_number']=='4'?'selected':'';?>>4</option>
              </select>
            </div>
            <?php 
                $level1 = json_decode($rec[0]['level_1'], true);
                $level2 = json_decode($rec[0]['level_2'], true);
                $level3 = json_decode($rec[0]['level_3'], true);
                $level4 = json_decode($rec[0]['level_4'], true);
             ?>
            <div class="form-group level1" style="<?=$rec[0]['level_number']>='1'?'':'display: none;';?>">
                  <label>Level-1</label><br>
                  <select class="form-control" id="employee_ids1" name="employee_ids1[]" multiple="multiple" style="color:black;width: 100%;">
                    <?php 

                    foreach ($employees as $employee): ?>
                      <option value="<?php echo $employee['employee_id']; ?>" <?php echo in_array($employee['employee_id'], $level1) ? 'selected' : ''; ?>><?php echo $employee['employee_name']; ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
                <div class="form-group level2" style="<?=$rec[0]['level_number']>='2'?'':'display: none;';?>">
                  <label>Level-2</label><br>
                  <select class="form-control" id="employee_ids2" name="employee_ids2[]" multiple="multiple" style="color:black;width: 100%;">
                    <?php foreach ($employees as $employee): ?>
                      <option value="<?php echo $employee['employee_id']; ?>" <?php echo in_array($employee['employee_id'], $level2) ? 'selected' : ''; ?>><?php echo $employee['employee_name']; ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
                <div class="form-group level3" style="<?=$rec[0]['level_number']>='3'?'':'display: none;';?>">
                  <label>Level-3</label><br>
                  <select class="form-control" id="employee_ids3" name="employee_ids3[]" multiple="multiple" style="color:black;width: 100%;">
                    <?php foreach ($employees as $employee): ?>
                      <option value="<?php echo $employee['employee_id']; ?>" <?php echo in_array($employee['employee_id'], $level3) ? 'selected' : ''; ?>><?php echo $employee['employee_name']; ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
                <div class="form-group level4" style="<?=$rec[0]['level_number']>='4'?'':'display: none;';?>">
                  <label>Level-4</label><br>
                  <select class="form-control" id="employee_ids4" name="employee_ids4[]" multiple="multiple" style="color:black;width: 100%;">
                    <?php foreach ($employees as $employee): ?>
                      <option value="<?php echo $employee['employee_id']; ?>" <?php echo in_array($employee['employee_id'], $level4) ? 'selected' : ''; ?>><?php echo $employee['employee_name']; ?></option>
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
  $('.clockpick').clockpicker({
            autoclose:true
        });
</script>
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