<?php $this->load->view("common/meta");?>
<div class="wrapper">

  <?php $this->load->view("common/sidebar");?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Appointment Letter
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Appointment Letter</h3>
            </div>
            <!-- /.box-header -->
            <form role="form" action="" method="post" enctype="multipart/form-data">
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
              <div class="col-md-12" style="margin-top:15px;border : 1px solid #ddd;padding: 15px;border-radius: 5px;">
                        <div class="icon icon-lg icon-shape" style="margin-top: -28px!important;">
                            <span style="background-color: white;width: 100px;font-size: 12px;padding-left: 4px;padding-right: 4px;"><label style="color: green;">Appiontment Details</label></span>
                        </div>
                        <div class="row">
                          <div class="col-md-6">
                            <div class="row" style="margin-top:3px;">
                              <div class="col-md-5">
                                <label for = "name" style="margin-top:5px!important;"> Name</label>
                              </div>
                              <div class="col-md-7">
                                <input type="text" class="form-control" id="name" name="name" placeholder="" value="<?=$appointment[0]['name']; ?>">
                              </div>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="row" style="margin-top:3px;">
                              <div class="col-md-5">
                                <label for = "so_name" style="margin-top:5px!important;"> S/O</label>
                              </div>
                              <div class="col-md-7">
                                <input type="text" class="form-control" id="so_name" name="so_name" placeholder=""value="<?=$appointment[0]['so_name']; ?>" >
                              </div>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="row" style="margin-top:3px;">
                              <div class="col-md-5">
                                <label for = "at" style="margin-top:5px!important;"> At</label>
                              </div>
                              <div class="col-md-7">
                                <input type="text" class="form-control" id="at" name="at" placeholder="" value="<?=$appointment[0]['at']; ?>">
                              </div>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="row" style="margin-top:3px;">
                              <div class="col-md-5">
                                <label for = "post" style="margin-top:5px!important;" value=""> Post</label>
                              </div>
                              <div class="col-md-7">
                                <input type="text" class="form-control" id="post" name="post" placeholder="" value="<?=$appointment[0]['post']; ?>">
                              </div>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="row" style="margin-top:3px;">
                              <div class="col-md-5">
                                <label for = "dist" style="margin-top:5px!important;">Dist</label>
                              </div>
                              <div class="col-md-7">
                                 <input type="text" class="form-control" id="dist" name="dist" placeholder="" value="<?=$appointment[0]['dist']; ?>">
                              </div>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="row" style="margin-top:3px;">
                              <div class="col-md-5">
                                <label for = "state" style="margin-top:5px!important;">State</label>
                              </div>
                              <div class="col-md-7">
                                <input type="text" class="form-control" id="state" name="state" placeholder="" value="<?=$appointment[0]['state']; ?>">
                              </div>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="row" style="margin-top:3px;">
                              <div class="col-md-5">
                                <label for = "pincode" style="margin-top:5px!important;">Pin Code</label>
                              </div>
                              <div class="col-md-7">
                                <input type="number" class="form-control" id="pincode" name="pincode" placeholder="" value="<?=$appointment[0]['pincode']; ?>">
                              </div>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="row" style="margin-top:3px;">
                              <div class="col-md-5">
                                <label for = "position" style="margin-top:5px!important;">Position</label>
                              </div>
                              <div class="col-md-7">
                                <input type="text" class="form-control" id="position" name="position" placeholder="" value="<?=$appointment[0]['position']; ?>">
                              </div>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="row" style="margin-top:3px;">
                              <div class="col-md-5">
                                <label for = "based_at" style="margin-top:5px!important;">Initially Based At</label>
                              </div>
                              <div class="col-md-7">
                                <input type="text" class="form-control" id="based_at" name="based_at" placeholder="" value="<?=$appointment[0]['based_at']; ?>">
                              </div>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="row" style="margin-top:3px;">
                              <div class="col-md-5">
                                <label for = "reporting_to" style="margin-top:5px!important;">Reporting To</label>
                              </div>
                              <div class="col-md-7">
                                <input type="text" class="form-control" id="reporting_to" name="reporting_to" placeholder="" value="<?=$appointment[0]['reporting_to']; ?>">
                              </div>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="row" style="margin-top:3px;">
                              <div class="col-md-5">
                                <label for = "joining_date" style="margin-top:5px!important;">Joining Date</label>
                              </div>
                              <div class="col-md-7">
                                <input type="date" class="form-control" id="joining_date" name="joining_date" placeholder=""  value="<?=$appointment[0]['joining_date']; ?>">
                              </div>
                            </div>
                          </div>

                          </div>
                        </div>

                <div class="col-md-12" style="margin-top:15px;border : 1px solid #ddd;padding: 15px;border-radius: 5px;">
                      <div class="icon icon-lg icon-shape" style="margin-top: -28px!important;">
                        <span style="background-color: white;width: 100px;font-size: 12px;padding-left: 4px;padding-right: 4px;"><label style="color: green;"> Salary Wages</label></span>
                      </div>
                      <div class="row" style="margin-top:4px;">
                        <div class="col-md-12">
                          <table class="table table-bordered table-condensed table-striped">
                            <thead style="background-color:#dae6f5;">
                              <tr>
                                <th width="10%">Sl.No</th>
                                <th width="20%">Perticular</th>
                                <th width="35%">Amount</th>
                                <th width="10%">Action</th>
                                
                              </tr>
                            </thead>
                            <tbody class="listitems">
                              <?php if ($salary) { for ($i=0; $i < count($salary); $i++) {  ?>
                              <tr>
                                  <td width="10%" style="text-align: center;">1</td>
                                  <td width="45%">
                                   <input type="text" name="perticular[]" class="form-control" id="perticular" required="required" value="<?=$salary[$i]['perticular']; ?>"> 
                                    
                                  </td>
                                  <td width="20%">
                                    <input type="number" name="amount[]" class="form-control accessories" id="amount" required="required" value="<?=$salary[$i]['amount'] ?>">
                                  </td>
                                  <td width="10%">
                                    <a href="javascript:;" class="btnRemoveItem btn btn-xs btn-danger">
                                      <i class="fa fa-trash"></i>
                                    </a>
                                  </td>
                              </tr>
                               <?php }} ?>
                            </tbody>
                          </table>
                          <a href="javascript:;" class="btn btn-xs btn-warning btnAddItomMore pull-right">Add More</a>
                          <br><br>
                        </div>
                      </div>
                    </div><br>
              <div class="col-md-6">
                <div class="row" style="margin-top:14px;">
                  <div class="col-md-5">
                    <label for = "total_amount" style="margin-top:5px!important;">Total Amount</label>
                  </div>
                  <div class="col-md-7">
                    <input type="text" class="form-control" id="total_amount" name="total_amount" placeholder="" readonly value="<?=$appointment[0]['total_amount']; ?>">
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
<!-- ./wrapper -->

<?php $this->load->view("common/script");?>




<script src="<?php echo base_url()?>bower_components/select2/dist/js/select2.full.min.js"></script>
<script type="text/javascript">
    
 
  $(".btnAddItomMore").click(function(e){
    var sl = parseInt($(".listitems tr").length) + 1;
    
    
    $(".listitems").append('<tr><td width="10%" style="text-align: center;">'+sl+'</td><td width="40%"><input type="text" name="perticular[]" class="form-control" id="perticular" required></td><td width="20%"><input type="number" name="amount[]" class="form-control accessories" id="amount" required></td><td   width="10%"><a href="javascript:;" class="btnRemoveItem btn btn-xs btn-danger"><i class="fa fa-trash"></i></a></td></tr>');
  });

   $(document).on("click", ".btnRemoveItem", function(e){
      $(this).closest('tr').remove();
      
  });


   
 $(document).on("keyup",".accessories",function(){
    var obj = $(this).closest('tr');
    var rate = parseFloat(obj.find('#amount').val());
    var total = rate ;
    calculate();
   });

    function calculate(){
      var inputs1 = $(".accessories");
      var dramounttot = 0;
      for(var i= 0; i < inputs1.length; i++){
        if($(inputs1[i]).val() != ''){
          dramounttot = dramounttot + parseFloat($(inputs1[i]).val());
        }
      }
      dramounttot = dramounttot;
      $('#total_amount').val(dramounttot.toFixed(2));
    }

       
</script>

</body>
</html>


