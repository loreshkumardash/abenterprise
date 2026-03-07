<?php $this->load->view("common/meta");?>

<div class="wrapper">

  <?php $this->load->view("common/sidebar");?>
  
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Vehicles
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Add Vehicles </h3>              
            </div>
            <!-- /.box-header -->
            <form role="form" action="<?php echo site_url("masters/add_vehicles");?>" method="post" enctype="multipart/form-data">
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

                <div class="col-md-5">
                  <div class="row">
                    <div class="col-md-6">
                      <label for="registration_no">Vehicle No</label>
                      <input type="text" name="registration_no" id="registration_no" class="form-control" value="<?=set_value('registration_no');?>">
                    </div>
                    <div class="col-md-6">
                      <label for="description">Description.</label>
                      <input type="text" name="description" id="description" class="form-control" value="<?=set_value('description');?>">
                    </div>
                    <div class="col-md-6">
                      <label for="fitness_valid_from">Fitness Valid From</label>
                      <input type="date" name="fitness_valid_from" id="fitness_valid_from" class="form-control" value="<?=set_value('fitness_valid_from');?>">
                    </div>
                    <div class="col-md-6">
                      <label for="fitness_valid_to">Fitness Valid Upto</label>
                      <input type="date" name="fitness_valid_to" id="fitness_valid_to" class="form-control" value="<?=set_value('fitness_valid_to');?>">
                    </div>
                    <div class="col-md-6">
                      <label for="pollution_valid_from">Pollution Valid From</label>
                      <input type="date" name="pollution_valid_from" id="pollution_valid_from" class="form-control" value="<?=set_value('pollution_valid_from');?>">
                    </div>
                    <div class="col-md-6">
                      <label for="pollution_valid_to">Pollution Valid Upto</label>
                      <input type="date" name="pollution_valid_to" id="pollution_valid_to" class="form-control" value="<?=set_value('pollution_valid_to');?>">
                    </div>
                    <div class="col-md-6">
                      <label for="tax_valid_from">Tax Valid From</label>
                      <input type="date" name="tax_valid_from" id="tax_valid_from" class="form-control" value="<?=set_value('tax_valid_from');?>">
                    </div>
                    <div class="col-md-6">
                      <label for="tax_valid_to">Tax Valid Upto</label>
                      <input type="date" name="tax_valid_to" id="tax_valid_to" class="form-control" value="<?=set_value('tax_valid_to');?>">
                    </div>
                    <div class="col-md-6">
                      <label for="permit_valid_from">Permit Valid From</label>
                      <input type="date" name="permit_valid_from" id="permit_valid_from" class="form-control" value="<?=set_value('permit_valid_from');?>">
                    </div>
                    <div class="col-md-6">
                      <label for="permit_valid_to">Permit Valid Upto</label>
                      <input type="date" name="permit_valid_to" id="permit_valid_to" class="form-control" value="<?=set_value('permit_valid_to');?>">
                    </div>
                    <div class="col-md-6">
                      <label for="insurance_valid_from">Insurance Valid From</label>
                      <input type="date" name="insurance_valid_from" id="insurance_valid_from" class="form-control" value="<?=set_value('insurance_valid_from');?>">
                    </div>
                    <div class="col-md-6">
                      <label for="insurance_valid_to">Insurance Valid Upto</label>
                      <input type="date" name="insurance_valid_to" id="insurance_valid_to" class="form-control" value="<?=set_value('insurance_valid_to');?>">
                    </div>
                    <div class="col-md-6">
                      <label for="insurance_company">Insurance Company</label>
                      <input type="text" name="insurance_company" id="insurance_company" class="form-control" value="<?=set_value('insurance_company');?>">
                    </div>
                    <div class="col-md-6">
                      <label for="insurance_amount">Insurance Amount.</label>
                      <input type="text" name="insurance_amount" id="insurance_amount" class="form-control" value="<?=set_value('insurance_amount');?>">
                    </div>
                    <div class="col-md-6">
                      <label for="conductor_idconductor_id">Assign Conductor</label>
                      <select name="conductor_id" id="conductor_id" class="form-control">
                        <option value="">-Select-</option>
                        <?php if(!empty($conductor_data)){  foreach ($conductor_data as $ks => $vs) {
                          echo '<option value="'.$vs['user_id'].'">'.$vs['firstname'].' '.$vs['lastname'].'</option>';
                        } }?>
                      </select>
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

</script>

<script type="type/javascript">
$(function () {
    
})
</script>
</body>
</html>
