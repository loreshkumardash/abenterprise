<?php $this->load->view("common/meta");?>
<div class="wrapper">

  <?php $this->load->view("common/sidebar");?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Unit Access
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Unit Access</h3>
              
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
                <form method="post" action="<?=site_url("users/unitaccess");?>" >
                  <div class="col-md-12 row">
                    <div class="col-md-4">
                      <div class="form-group">
                        <label for="user_id">Select User</label>
                        <select class="form-control" id="user_id" name="user_id">
                          <option value="">Select</option>
                          <?php if ($user) { for ($i=0; $i <count($user) ; $i++) { ?>
                              <option value="<?=$user[$i]['user_id'];?>"><?=$user[$i]['firstname'];?> <?=$user[$i]['lastname'];?></option>
                          <?php } } ?>
                        </select>
                      </div>
                    </div>
                    <input type="hidden" name="access_unit_id" id="access_unit_id">
                    
                   
                    </div>
                    <div class="col-md-8">
                            <table class="table table-condensed">
                                <tr>
                                    <th><input type="checkbox" class="checkall"></th>
                                    <th>Unit Code </th>
                                    <th>Unit Name </th>
                                    <th><i class="fa fa-eye" title="View"></i></th>
                                    
                                </tr>
                                <tbody id="unitdata">
                                  
                                </tbody>
                                
        
                            </table>
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    <button type="submit" name="submitBtn" value="submit" class="btn btn-primary">Submit</button>
                    <button type="reset" name="reset" value="reset" class="btn btn-default">Reset</button>
                </div>
                  </form>
                
                 
          </div>
        </div>
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
<script type="text/javascript">
  
    $(document).on('change','.checkall',function(e){
        e.preventDefault();
        if($(this).prop("checked") == true){
            $(this).closest("table").find('input[type=checkbox]').each(function() { this.checked = true; });
        }else{
            $(this).closest("table").find('input[type=checkbox]').each(function() { this.checked = false; });
        }
    });

    $(document).on('change','.checkall1',function(e){
        e.preventDefault();
        if($(this).prop("checked") == true){
            $(this).closest("tr").find('input[type=checkbox]').each(function() { this.checked = true; });
        }else{
            $(this).closest("tr").find('input[type=checkbox]').each(function() { this.checked = false; });
        }
    });
  

    $(document).on('change', '#user_id', function(){
  
        var user_id = $("#user_id").val();
        
        if (user_id) {
          $.ajax({
              url: '<?=site_url("users/get_unitAccess");?>',
              data: {user_id : user_id},
              dataType:"HTML",
              type:"POST",
              success:function(data){
              if(data){
                $("#unitdata").html(data.split('@#,')[1]);
                $("#access_unit_id").val(data.split('@#,')[0]);
                
                    
                  
              }else{
                 $("#unitdata").html('');
                 $("#access_unit_id").val('');
              }
          }
          });
          } 
            
});
</script>

</body>
</html>