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
              <h3 class="box-title">Issue Accessories Report</h3>
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
                <form role="form" action="<?=site_url("reports/issueaccessoryreport");?>" method="post" id="searchForm" >
                
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="employee_id">Employee Code</label>
                                    <input type="text" class="form-control" id="employee_code" required="required" name="employee_code" placeholder="Enter Employee Code">
                                        
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="employee_name">Employee Name</label>
                                    <input type="text" class="form-control" id="employee_name" required="required" name="employee_name" readonly>
                                        
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

  $(document).on("keyup","#employee_code",function(){
    var employee_code = $(this).val();
    $.ajax({
      url: '<?=site_url("employee/get_empData");?>',
      data: {employee_code : employee_code},
      dataType:"HTML",
      type:"POST",
      success:function(data){        
          
          $("#employee_name").val(data.split("@#,")[1]);
      }
    });
  });

  $(document).on("click","#searchBtn",function(){
    var employee_code = $("#employee_code").val();
    
    if (employee_code != '') {
		    $.ajax({
		      url: '<?=site_url("reports/get_issueReportData");?>',
		      data: {employee_code : employee_code},
		      dataType:"HTML",
		      type:"POST",
		      success:function(data){        
		         
		          $("#dataTablediv").html(data);
		      }
		    });
	}
  });

</script>
</body>
</html>