<?php $this->load->view("common/meta");?>
<div class="wrapper">

  <?php $this->load->view("common/sidebar");?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Check
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">List Check</h3>
            </div>
            <!-- /.box-header -->
            
            <div class="box-body">
              <div class="row">
                <div class="col-md-12">
		            <form role="form" action="<?php echo site_url("cheque/listcheque");?>" method="get" id="searchForm">
		                   
                  <div class="col-md-2">
                    <div class="form-group">
                      <label for="purchase_date_from">From Date</label>
                      <input type="date" class="form-control" id="from_date" name="from_date">
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="form-group">
                      <label for="purchase_date_to">To Date</label>
                      <input type="date" class="form-control" id="to_date" name="to_date">
                    </div>
                  </div>
                  <div class="col-md-4">
                    <button type="submit" name="submitBtn" value="submit" class="btn bg-navy btn-flat margin" style="margin-top: 25px;">Search</button>
		                <input type="submit" name="download" value="Download" formaction="<?=site_url('cheque/download_cheque');?>" class="btn btn-warning" style="margin-top: 15px;">
                  </div>
                </form>
		
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
                
              </div>
              <div class="row">
                <div class="col-md-12" id="dataTablediv" style="overflow-x:auto;">
                  <?php if($records){?>
                  <table id="" class="table table-bordered table-condensed table-striped">
                    <tr>
                      <th>ID</th>
		                  <th>Date</th>
            		      <th>Mobile No</th>
                      <th>Amount</th>
                      <th>Check No</th>
                      <th>Bank</th>
                      <th>Branch</th>
            		      <th>Deposit A/c No</th>		      
            		      <th>Clear/Not</th>
            		      <th>Clear date(If clear)</th>
            		      <th>Remarks</th>
            		      <th>Added by</th>
                      <th>Action</th>
                    </tr>
                    <?php if($records){ for($i=0;$i<count($records);$i++){?>
                    <tr>
                      <td><?php echo $records[$i]['id'];?></td>
                      <td><?php echo date("d/m/Y", strtotime($records[$i]['entry_date']));?></td>
                      
		                  <td><?php echo $records[$i]['phn_no'];?></td>
                      <td><?php echo $records[$i]['amt'];?></td>
                      <td><?php echo $records[$i]['chk_no'];?></td>
		                  <td><?php echo $records[$i]['bank'];?></td>
                      <td><?php echo $records[$i]['branch'];?></td>
                      <td><?php echo $records[$i]['deposit_ac'];?></td>                      
            		      <td style="color:blue;"><?php echo $records[$i]['clear_not'];?></td>
            		      <td><?php if(($records[$i]['c_date']) > 0){ echo date("d/m/Y", strtotime($records[$i]['c_date'])); }else{ echo "";}?></td>
                      <td><?php echo $records[$i]['remarks'];?></td>
		                  <td><?php echo $this->session->userdata("firstname").' '.$this->session->userdata("lastname");?></td>
                      <td>
                        <?php if(in_array('chequeedit', $accessar) || $this->session->userdata('usertype') == 'Admin'){ ?>
				          <?php if(in_array('chequeedit', $accessar) && ($records[$i]['clear_not']=='') || $this->session->userdata('usertype') == 'Admin'){?>
                  			<a href="<?php echo site_url("cheque/edit_cheque/".$records[$i]['id']);?>" class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i></a>
                        <?php }}?>
                        <?php if($this->session->userdata('usertype') == 'Admin'){ ?>
                  			<a href="<?php echo site_url("cheque/delete_cheque/".$records[$i]['id']);?>" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></a>
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