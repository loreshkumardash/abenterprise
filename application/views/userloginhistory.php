<?php $this->load->view("common/meta");?>
<div class="wrapper">

  <?php $this->load->view("common/sidebar");?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        User Login History
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Login History</h3>
              
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
                <form method="post">
                  <div class="col-md-12 row">
                    <div class="col-md-2">
                      <div class="form-group">
                        <label for="user_id">User</label>
                        <select class="form-control" id="user_id" name="user_id">
                          <option value="">Select</option>
                          <?php if ($user) { for ($i=0; $i <count($user) ; $i++) { ?>
                              <option value="<?=$user[$i]['user_id'];?>"><?=$user[$i]['firstname'];?> <?=$user[$i]['lastname'];?></option>
                          <?php } } ?>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="form-group">
                        <label for="class_name">From</label>
                        <input type="date" class="form-control" id="from_date" name="from_date">
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="form-group">
                        <label for="class_name">To</label>
                        <input type="date" class="form-control" id="to_date" name="to_date">
                      </div>
                    </div>
                    <div class="col-md-1">
                      <button type="submit" name="submitBtn" value="submit" class="btn btn-primary" style="margin-top:25px;">Search</button>
                      
                    </div>
                    <div class="col-md-2">
                      
                      <button type="submit" name="downloadBtn" value="submit" class="btn bg-maroon btn-flat margin" style="margin-top:25px;" >Download</button>
                    </div>
                    </div>
                  </form>
                
                  <div class="col-lg-12">
                      <table id="" class="table table-condensed table-small-font table-bordered table-striped">
                        <tr>
                          <th>Sl#</th>
                          <th>User Name</th>
                          <th>Login Time</th>
                          <th>Logout Time</th>
                        </tr>
                        <?php if ($records) {for ($i=0; $i < count($records); $i++) {?> 
                         <tr>
                           <td><?=$i+1;?></td>
                           <td><?=$records[$i]['firstname'];?> <?=$records[$i]['lastname'];?></td>
                           <td><?php echo date('d-m-Y H:i:s a',strtotime($records[$i]['logindatetime'])); ?></td>
                           <td><?php if ($records[$i]['logoutdatetime']) {
                             
                            echo date('d-m-Y H:i:s a',strtotime($records[$i]['logoutdatetime']));}else{echo '';} ?></td>
                         </tr>
                        <?php }} ?>
                        
                      </table>
                      <?php if($records){echo $sPages; }else{echo 'No records found';}?>
                  </div>
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
  $(document).on('click', '#downloadbtn', function(){
   
        var user_id = $("#user_id").val();
        var from_date = $("#from_date").val();
        var to_date = $("#to_date").val();

          $.ajax({
              url: '<?=site_url("login/downloaduserloginhistory");?>',
              data: {user_id : user_id,from_date:from_date,to_date:to_date},
              dataType:"HTML",
              type:"POST",
              success:function(data){
                alert(data)
                    
                  
              }
          }); 
            
});
</script>

</body>
</html>