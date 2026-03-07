<?php $this->load->view("common/meta");?>

<div class="wrapper">

  <?php $this->load->view("common/sidebar");?>
  
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <!-- <section class="content-header">
      <h1>
        Employee
      </h1>
    </section> -->

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Issue Accessories </h3> 
              <a href="<?=site_url("employee/add_issueaccessories");?>" class="btn btn-xs btn-primary float-right"><i class="fa fa-plus"></i> Add New</a>           
            </div>
            <!-- /.box-header -->
            <form role="form" action="<?php echo site_url("employee/issue_accessories_client");?>" method="post" enctype="multipart/form-data">
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
                  if($this->session->flashdata('saveandprint')){
                    ?>
                  <script type="text/javascript">
                    window.open('<?php echo site_url("payments/print_voucher/".$this->session->flashdata('saveandprint'))?>','winname','directories=no,titlebar=no,toolbar=no,location=no,status=no,menubar=no,scrollbars=no,resizable=no,width=900,height=650');
                  </script>
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

                
                <div class="col-md-12">
                  <div class="row">
                    <div class="col-md-2">
                    <div class="form-group">
                      <label for="date_from">Date From</label>
                      <input type="date" class="form-control" id="date_from" name="date_from" value="<?php echo set_value("date_from");?>" >
                    </div>
                    </div>
                    <div class="col-md-2">
                      <div class="form-group">
                        <label for="date_to">Date To</label>
                        <input type="date" class="form-control" id="date_to" name="date_to" value="<?php echo set_value("date_to");?>" >
                      </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                          <label for="employee_code">Employee Code</label>
                          <input type="text" class="form-control form-control-sm" name="employee_code" id="employee_code">
                        </div>
                    </div>
                    <div class="col-md-2 form-group">
                      <label for="issue_status">Status</label>
                      <select name="issue_status" id="issue_status" class="form-control"  >
                        <option value="Pending">Pending</option>
                        <option value="Paid">Paid</option>
                      </select>
                    </div>
                     <div class="col-md-2 form-group ">
                      <button type="submit" name="submitBtn" value="submit" class="btn bg-navy btn-flat" style="margin-top:25px;">Search</button>
                    </div>
                  </div>
                </div>
                <div class="col-md-12">
                  <table class="table table-bordered table-condensed table-striped">
                      <thead>
                        <tr>
                          <th width="5%">#Sl</th>
                          <th width="10%">Issue Date</th>
                          <th width="10%">Employee Code</th>
                          <th width="20%">Employee Name</th>
                          <th width="20%">Added By</th>
                          <th width="10%" class="text-center">Total Amount</th>
                          <th width="10%" class="text-center">Status</th>
                          <th  class="text-center" width="15%">Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php if ($records) { for ($i=0; $i < count($records); $i++) { ?>
                        <tr>
                          <td width="5%"><?=$i+1;?></td>
                          <td width="10%"><?=$records[$i]['issue_date'];?></td>
                          <td width="10%"><?=$records[$i]['employee_code'];?></td>
                          <td width="20%"><?=$records[$i]['employee_name'];?></td>
                          <td width="20%"><?=$records[$i]['firstname'].' '.$records[$i]['lastname'];?></td>
                          <td width="10%" class="text-right"><?=$records[$i]['tot_amount'];?></td>
                          <td width="10%" style="color:<?=$records[$i]['issue_status']=='Paid'?'green':'red';?>;text-align: center;"><b><?=$records[$i]['issue_status'];?></b></td>
                          <td class="text-center" width="15%">
                            <a href="<?=site_url("employee/view_issueaccessories/".$records[$i]['issue_id']);?>" class="btn btn-primary btn-xs" >View</a>
                            <a href="<?=site_url("employee/edit_issueaccessories/".$records[$i]['issue_id']);?>" class="btn btn-warning btn-xs" >Edit</a>
                            <a href="<?=site_url("employee/delete_issueaccessories/".$records[$i]['issue_id']);?>" class="btn btn-danger btn-xs" onclick="return confirm('Are you sure for delete?');">Delete</a>
                          </td>
                        </tr>
                      <?php }} ?>
                      </tbody>
                  </table>
                </div>
              </div>
              
              
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
  $(document).on('click','.addstockbtn',function(){
    var obj = $(this).closest("tr");
      obj.find(".addstockModal").modal('toggle');
      obj.find(".addstockModal").modal('show');
  });
  
  if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
</script>
</body>
</html>
