<?php $this->load->view("common/meta");?>
<style type="text/css">
	.hovernow:hover {
  transform: scale(1)!important;
  -webkit-transform: scale(1)!important;
  -moz-transform: scale(1)!important;
  box-shadow: rgba(0, 0, 0, 0.25) 0px 54px 55px, rgba(0, 0, 0, 0.12) 0px -12px 30px, rgba(0, 0, 0, 0.12) 0px 4px 6px, rgba(0, 0, 0, 0.17) 0px 12px 13px, rgba(0, 0, 0, 0.09) 0px -3px 5px!important;
  -webkit-box-shadow: rgba(0, 0, 0, 0.25) 0px 54px 55px, rgba(0, 0, 0, 0.12) 0px -12px 30px, rgba(0, 0, 0, 0.12) 0px 4px 6px, rgba(0, 0, 0, 0.17) 0px 12px 13px, rgba(0, 0, 0, 0.09) 0px -3px 5px!important;
  -moz-box-shadow: rgba(0, 0, 0, 0.25) 0px 54px 55px, rgba(0, 0, 0, 0.12) 0px -12px 30px, rgba(0, 0, 0, 0.12) 0px 4px 6px, rgba(0, 0, 0, 0.17) 0px 12px 13px, rgba(0, 0, 0, 0.09) 0px -3px 5px!important;
  cursor: pointer;
}
</style>
<div class="wrapper">

  <?php $this->load->view("common/sidebar");?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        User Tracking History
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">User Tracking History</h3>
              
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
                
             
                  
                 
                
                  <div class="col-lg-12">
                      <table id="" class="table " cellpadding="3">
                      	<thead>
	                        <tr>
	                          <th>Sl#</th>
	                          <th>User Id</th>
	                          <th>User Name</th>
	                          
	                        </tr>
                        </thead>
                        <?php  if ($records) {
                        	$accessar = json_decode($records[0]['tracking_access']);
                        	//print_r($accessar);
                        }else{
                        	$accessar='';
                        } ?>
                        <tbody>
                        	<?php if ($accessar) {
                        		foreach ($accessar as $key => $value) {
                        			$user = $this->Common_Model->FetchData("users","*","user_id=".$value);
                        			if ($user) { ?>
                        				
                        			
                        	<tr style="border: hidden;margin-top:8px;box-shadow: rgba(0, 0, 0, 0.16) 0px 10px 36px 0px, rgba(0, 0, 0, 0.06) 0px 0px 0px 1px;border-radius: 9px;" class="hovernow" data-id="<?=$user[0]['user_id'];?>">
		                      <td width="5%" class="text-center"><span class="circle"><?=$key + 1;?></span></td>
		                      <td width="35%"><?=$user[0]['user_id'];?></td>
		                      <td width="15%" class=""><?=$user[0]['firstname'];?> <?=$user[0]['lastname'];?></td>
		                      
		                      
		                    </tr>
		                   <?php }
                        		}
                        	} ?>
                        </tbody>
                        
                      </table>
                      
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
	$(document).on('click','.hovernow',function(){
		var user_id= $(this).attr('data-id');
		var appUrl = '<?=site_url();?>';
		document.location.href=appUrl+'/users/viewUserAttendance/'+user_id;
	});

	if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
</script>
</body>
</html>