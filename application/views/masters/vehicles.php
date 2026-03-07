<?php $this->load->view("common/meta");?>
<div class="wrapper">

  <?php $this->load->view("common/sidebar");?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Master Data
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">List Vehicles
              
              </h3>
              <!--<a href="<?=site_url("masters/add_vehicles");?>" class="btn btn-primary btn-sm" style="float:right;">Add New</a>
              <a href="<?=site_url("masters/repairs");?>" class="btn btn-primary btn-sm" style="float:right; margin: 0 20px;">Repairs</a>
              <a href="<?=site_url("masters/add_repair");?>" class="btn btn-primary btn-sm" style="float:right;">Add Repair Work</a>-->
            </div>
            
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
                <form role="form" action="<?php echo site_url("masters/vehicles");?>" method="get" id="searchForm">
                  <div class="col-md-2">
                    <div class="form-group">
                      <label for="registration_no">Registration No</label>
                      <input type="text" class="form-control" id="registration_no" name="registration_no" value="<?php echo set_value("registration_no");?>">
                    </div>
                  </div>
                  
                  <div class="col-md-4">
                    <button type="submit" name="submitBtn" value="submit" class="btn bg-navy btn-flat margin">Search</button>
                  </div>
                </form>
              </div>
              <div class="row">
                <div class="col-md-12" id="dataTablediv" style="overflow-x:auto;">
                  <?php if($records){?>
                  <table id="" class="table table-bordered table-condensed table-striped">
                    <tr>
                      <th width="5%">ID</th>
                      <th>Registration No</th>
                      <th>Fitness</th>
                      <th>Pollution</th>
                      <th>Tax</th>
                      <th>Permit</th>
                      <th>Insurance</th>
                      <th>Insurance Company Name</th>
                      <th>Insurance Amount </th>
                      <th width="10%">Action</th>
                    </tr>
                    <?php if($records){ for($i=0;$i<count($records);$i++){?>
                    <tr>
                      <td><?php echo $records[$i]['vehicle_id'];?></td>
                      <td><?php echo $records[$i]['registration_no'];?></td>
                      <td>
                        <small class="label bg-green"><?=date("d/m/Y", strtotime($records[$i]['fitness_valid_from']));?></small><br/>
                        <?php 
                        if( strtotime($records[$i]['fitness_valid_to']) < time() ){
                          echo '<small class="label bg-red">'.date("d/m/Y", strtotime($records[$i]['fitness_valid_to'])).'</small>';
                        } else {
                          echo '<small class="label bg-green">'.date("d/m/Y", strtotime($records[$i]['fitness_valid_to'])).'</small>';
                        }
                        ?>
                      </td>
                      <td>
                        <small class="label bg-green"><?=date("d/m/Y", strtotime($records[$i]['pollution_valid_from']));?></small><br/>
                        <?php 
                        if( strtotime($records[$i]['pollution_valid_to']) < time() ){
                          echo '<small class="label bg-red">'.date("d/m/Y", strtotime($records[$i]['pollution_valid_to'])).'</small>';
                        } else {
                          echo '<small class="label bg-green">'.date("d/m/Y", strtotime($records[$i]['pollution_valid_to'])).'</small>';
                        }
                        ?>
                      </td>
                      <td>
                        <small class="label bg-green"><?=date("d/m/Y", strtotime($records[$i]['tax_valid_from']));?></small><br/>
                        <?php 
                        if( strtotime($records[$i]['tax_valid_to']) < time() ){
                          echo '<small class="label bg-red">'.date("d/m/Y", strtotime($records[$i]['tax_valid_to'])).'</small>';
                        } else {
                          echo '<small class="label bg-green">'.date("d/m/Y", strtotime($records[$i]['tax_valid_to'])).'</small>';
                        }
                        ?>
                      </td>
                      <td>
                        <small class="label bg-green"><?=date("d/m/Y", strtotime($records[$i]['permit_valid_from']));?></small><br/>
                        <?php 
                        if( strtotime($records[$i]['permit_valid_to']) < time() ){
                          echo '<small class="label bg-red">'.date("d/m/Y", strtotime($records[$i]['permit_valid_to'])).'</small>';
                        } else {
                          echo '<small class="label bg-green">'.date("d/m/Y", strtotime($records[$i]['permit_valid_to'])).'</small>';
                        }
                        ?>
                      </td>
                      <td>
                        <small class="label bg-green"><?=date("d/m/Y", strtotime($records[$i]['insurance_valid_from']));?></small><br/>
                        <?php 
                        if( strtotime($records[$i]['insurance_valid_to']) < time() ){
                          echo '<small class="label bg-red">'.date("d/m/Y", strtotime($records[$i]['insurance_valid_to'])).'</small>';
                        } else {
                          echo '<small class="label bg-green">'.date("d/m/Y", strtotime($records[$i]['insurance_valid_to'])).'</small>';
                        }
                        ?>
                      </td>
                      <td><?=$records[$i]['insurance_company'];?></td>
                      <td><?=$records[$i]['insurance_amount'];?></td>
                      <td>
                        <a href="<?php echo site_url("masters/edit_vehicles/".$records[$i]['vehicle_id']);?>" class="btn btn-warning btn-xs"><i class="fa fa-pencil"></i></a>
                        <?php if($this->session->userdata("usertype") == 'Admin'){ ?>
                        <a href="<?php echo site_url("masters/delete_vehicles/".$records[$i]['vehicle_id']);?>" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></a>
                        <a href="<?php echo site_url("masters/config_route/".$records[$i]['vehicle_id']);?>" class="btn btn-success btn-xs" title="Route Config"><i class="fa fa-map"></i></a>
                        <?php }?>
                      </td>
                    </tr>
                    <?php }} ?>
                  </table>
                  <?php echo $sPages; }else{echo 'No records found';}?>
                </div>
              </div>
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
  $(document).ready(function(){
    $("#class_id").change(function(e){
      e.preventDefault();
      if($(this).val() != ''){
        $.ajax({
          url: '<?php echo site_url("masters/getStudentListBySessionClass");?>',
          data : {class_id : $(this).val(), session_id : $("#session_id").val()},
          dataType: "HTML",
          type : "POST",
          success: function(data){
            $("#student_id").html(data);
          }
        });
      }else{
        $("#student_id").html('<option value="">select</option>');
      }
    });
  });
</script>
</body>
</html>