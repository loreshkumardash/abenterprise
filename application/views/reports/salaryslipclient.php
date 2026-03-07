<?php $this->load->view("common/meta");?>
<div class="wrapper">

  <?php $this->load->view("common/sidebar");?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Salary Slip</h3>
            </div>
            <!-- /.box-header -->
            
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
                <form role="form" action="<?=site_url("reports/salaryslipclient");?>" method="post" id="searchForm" target="_blank">
                
                            <div class="col-md-2">
                                <label for="year">Year</label>
                              <select class="form-control form-control-sm" name="year" id="year" required="required">
                                  <option value="">Select</option>
                                <?php $yr = date("Y"); for ($y=0; $y < 6; $y++) { 
                                  $yrr = $yr - $y;
                                  $sel = $yrr == $year ? 'selected="selected"' : '';
                                  echo '<option value="'.$yrr.'" '.$sel.'>'.$yrr.'</option>';
                                }
                                ?>
                              </select>
                            </div>
                            <div class="col-md-2">
                                <label for="month">Month</label>
                              <select class="form-control form-control-sm" name="month" id="month" required="required" >
                                <option value="01" <?=$month == '01' ? 'selected="selected"' : '';?>>Jan</option>
                                <option value="02" <?=$month == '02' ? 'selected="selected"' : '';?>>Feb</option>
                                <option value="03" <?=$month == '03' ? 'selected="selected"' : '';?>>Mar</option>
                                <option value="04" <?=$month == '04' ? 'selected="selected"' : '';?>>Apr</option>
                                <option value="05" <?=$month == '05' ? 'selected="selected"' : '';?>>May</option>
                                <option value="06" <?=$month == '06' ? 'selected="selected"' : '';?>>Jun</option>
                                <option value="07" <?=$month == '07' ? 'selected="selected"' : '';?>>Jul</option>
                                <option value="08" <?=$month == '08' ? 'selected="selected"' : '';?>>Aug</option>
                                <option value="09" <?=$month == '09' ? 'selected="selected"' : '';?>>Sept</option>
                                <option value="10" <?=$month == '10' ? 'selected="selected"' : '';?>>Oct</option>
                                <option value="11" <?=$month == '11' ? 'selected="selected"' : '';?>>Nov</option>
                                <option value="12" <?=$month == '12' ? 'selected="selected"' : '';?>>Dec</option>
                              </select>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="employee_id">Employee Code</label>
                                    <input type="text" class="form-control" id="employee_code" required="required" name="employee_code" placeholder="Enter Employee Code">
                                        
                                </div>
                            </div>  
                            
                        
                <div class="col-md-3" style="padding-top: 15px;">
                  <button type="button" name="submitBtn" value="submit" class="btn bg-navy btn-flat margin" id="searchBtn">Search</button>

                  <button type="submit" name="downloadBtn" value="submit"class="btn bg-maroon btn-flat margin">Download</button>
                  
                </div>
                </form>
              </div>
              <div class="row">
                <div class="col-md-12" id="dataTablediv">
                  
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

  $(document).on("change","#unit_id",function(){
    
    let unit_id = $(this).val();

    if (unit_id != '') {
        $.ajax({
            url: '<?=site_url("employee/get_designationByUnit");?>',
            data: {unit_id : unit_id},
            dataType:"HTML",
            type:"POST",
            success:function(data){
                if (data) {
                        $("#designation_id").html(data.split(',')[0]);
                        
                      }else{

                      }

            }
        });
    }
  });
  $(document).ready(function(){
      $("#searchBtn").click(function(e){
        e.preventDefault();
        var year = $("#year").val();
        var month = $("#month").val();
        var employee_code = $("#employee_code").val();
        

          if (year != '' && month != '' && employee_code != '') {
                $.ajax({
                    url: '<?=site_url("reports/get_salarySlipClient");?>',
                    data: {year : year,month:month,employee_code:employee_code},
                    dataType:"HTML",
                    type:"POST",
                    success:function(data){
                     
                        $("#dataTablediv").html(data);
 
                    }
                }); 
            }else{
               $("#dataTablediv").html('');
              
            }
      });
  });
</script>
</body>
</html>