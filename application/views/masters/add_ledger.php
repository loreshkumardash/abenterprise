<?php $this->load->view("common/meta");?>
<div class="wrapper">

  <?php $this->load->view("common/sidebar");?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Master Data
        <small>Ledger Master</small>
      </h1> 
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <?php if(in_array('ledgermasteradd', $accessar) || $this->session->userdata('usertype') == 'Admin' || $this->session->userdata('usertype') == 'Accounts'){ ?>
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Add Ledger</h3>
              
            </div>
            <!-- /.box-header -->
            <form role="form" action="<?php echo site_url("masters/add_ledger");?>" method="post">
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
              <div class="row">  
                <div class="col-md-12">
                    <div class="row form-group"> 
                      <div class="col-md-2">
                          <label for="ledger_name">Ledger Name : </label>
                      </div>
                      <div class="col-md-10">
                          <input type="text" class="form-control form-control-sm" name="ledger_name" id="ledger_name" required placeholder="Enter Ledger Name"> 
                             
                      </div>
                    </div>

                    <div class="row form-group">
                      <div class="col-md-2">
                          <label for="station">Location : </label>
                      </div>
                      <div class="col-md-5">
                          <input type="text" class="form-control form-control-sm" name="station" id="station" placeholder="Enter Ledger Location"> 
                             
                      </div>
                      
                    </div>

                    <div class="row form-group">
                      <div class="col-md-2">
                          <label for="acount_group">Account Group : </label>
                      </div>
                      <div class="col-md-5">
                          <select class="form-control form-control-sm" name="acount_group" id="acount_group" required>
                              <option value="">Select</option>
                              <?php if ($undergroup) { for ($i=0; $i <count($undergroup) ; $i++) {
                                    if($undergroup[$i]['group_id'] != 50 && $undergroup[$i]['group_id'] != 51){
                              ?>
                                  <option value="<?=$undergroup[$i]['group_id'];?>"><?=$undergroup[$i]['group_name'];?></option>
                               
                             <?php } }} ?>
                          </select> 
                             
                      </div>
                     
                    </div>

                    <div class="row form-group">
                      
                      <div class="col-md-2">
                          <label for="opening_balance">Opening Bal. : </label>
                      </div>
                      <div class="col-md-2">
                          <input type="number" class="form-control form-control-sm" name="opening_balance" id="opening_balance" placeholder="0.00" step="0.01"> 
                             
                      </div>
                      
                      <div class="col-md-1">
                          <label for="type">Type : </label>
                      </div>
                      <div class="col-md-1">
                          <select class="form-control form-control-sm" name="balance_type" id="balance_type">
                            <option value="Dr">Dr</option>
                            <option value="Cr">Cr</option>
                          </select>     
                      </div>
                      <div class="col-md-1">
                          <button type="button" class="btn btn-secondary" data-toggle="tooltip" data-placement="top" title="Note: Assets &amp; Expenses always have Dr balance and Liabilities &amp; Incomes always have Cr balance.">
                             <i class="fa fa-info-circle" aria-hidden="true"></i>
                            </button>
                      </div>
                        <div class="col-md-2">
                        </div>
                      <div class="col-md-3">
                           <span><input type="checkbox" name="bankorcashac" style="margin-top:7px;" value="Yes"></span> 
                            <label  style="font-size:15px;">Bank or cash account</label>  
                           <span style="margin-left:10px;"><button type="button" class="btn btn-sm btn-secondary" data-toggle="tooltip" data-placement="top" title="Note: Select if the ledger account is a bank or a cash account." style="border-radius: 15px;">
                             <i class="fa fa-info-circle" aria-hidden="true"></i>
                            </button></span> 
                      </div>
                    </div>


                     <div class="row form-group"> 
                        <div class="col-md-3">
                            <label>Inventory values are affected ? </label> 
                        </div>
                        <div class="col-md-2">
                            <select class="form-control" name="inv_isaffect" id="inv_isaffect">
                              <option value="0">No</option>
                              <option value="1">Yes</option>
                            </select>
                        </div>
                    </div>

                    <div class="row form-group  invaf" style="display:none;"> 
                        <div class="col-md-3">
                            <label>HSN/ SAC Code  </label> 
                        </div>
                        <div class="col-md-2">
                            <input type="text" class="form-control" name="hsnsaccode" id="hsnsaccode" placeholder="Enter HSN/SAC">
                        </div>
                    </div>

                    <div class="row form-group invaf" style="display:none;"> 
                        <div class="col-md-3">
                            <label>GST %  </label> 
                        </div>
                        <div class="col-md-2">
                            <select class="form-control" name="gstperc" id="gstperc">
                              <option value="0">0%</option>
                              <option value="5">5%</option>
                              <option value="12">12%</option>
                              <option value="18">18%</option>
                              <option value="28">28%</option>
                            </select>
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
    $(document).on("change",'#inv_isaffect',function(){
        var inv_isaffect = $(this).val();
        if (inv_isaffect == 1) {
            $(".invaf").show();
            $("#hsnsaccode").attr("required","required");
        }else{
            $(".invaf").hide();
            $("#hsnsaccode").removeAttr("required");
        }
    });
</script>
</body>
</html>
