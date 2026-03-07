<?php $this->load->view("common/meta");?>
<style type="text/css">

  .table>tbody>tr[data-href], table>tbody>tr[data-href] {
    cursor: pointer;
    
}
.table>tbody>tr[data-href]:hover {
    background:#4e635e;
    color: white;
  }
tr {
    display: table-row;
    vertical-align: inherit;
    border-color: inherit;
}
table.dataTable {
    clear: both;
    max-width: none!important;
    border-collapse: separate!important;
}
    

</style>
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
        
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">View Ledgers</h3>
              
                <a href="<?php echo site_url("masters/list_ledger");?>" class="btn btn-xs btn-primary float-right">Back</a>
              
            </div>
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
                  <div class="col-md-7">

                    <div class="row"> 
                      <div class="col-md-4">
                          <p>Ledger Name : </p>
                      </div>
                      <div class="col-md-8">
                          <p><?=$rec[0]['ledger_name'];?></p> 
                             
                      </div>
                    </div>

                    <div class="row"> 
                      <div class="col-md-4">
                          <p>Station : </p>
                      </div>
                      <div class="col-md-8">
                          <p><?=$rec[0]['station'];?></p> 
                             
                      </div>
                    </div>

                    <div class="row"> 
                      <div class="col-md-4">
                          <p>Account Group : </p>
                      </div>
                      <div class="col-md-8">
                          <p><?=$rec[0]['group_name'];?></p> 
                             
                      </div>
                    </div>


                    

                    <div class="row"> 
                      <div class="col-md-4">
                          <p>Mail To : </p>
                      </div>
                      <div class="col-md-8">
                          <p><?=$rec[0]['mail_to'];?></p>    
                      </div>
                    </div>

                    <div class="row"> 
                      <div class="col-md-4">
                          <p>Address : </p>
                      </div>
                      <div class="col-md-8">
                          <p><?=$rec[0]['address'];?></p>    
                      </div>
                    </div>

                    <div class="row"> 
                      <div class="col-md-4">
                          <p>Pin : </p>
                      </div>
                      <div class="col-md-8">
                          <p><?=$rec[0]['pincode'];?></p>    
                      </div>
                    </div>

                    <div class="row"> 
                      <div class="col-md-4">
                          <p>Email : </p>
                      </div>
                      <div class="col-md-8">
                          <p><?=$rec[0]['email'];?></p>    
                      </div>
                    </div>

                    <div class="row"> 
                      <div class="col-md-4">
                          <p>Mobile : </p>
                      </div>
                      <div class="col-md-8">
                          <p><?=$rec[0]['mobile'];?></p>    
                      </div>
                    </div>

                    <div class="row"> 
                      <div class="col-md-4">
                          <p>GST No. : </p>
                      </div>
                      <div class="col-md-8">
                          <p><?=$rec[0]['gst_no'];?></p>    
                      </div>
                    </div>

                    <div class="row"> 
                      <div class="col-md-4">
                          <p>State : </p>
                      </div>
                      <div class="col-md-8">
                          <p><?=$rec[0]['state_title'];?></p>    
                      </div>
                    </div>

                    <div class="row"> 
                      <div class="col-md-4">
                          <p>Country : </p>
                      </div>
                      <div class="col-md-8">
                          <p><?=$rec[0]['leadger_country'];?></p>    
                      </div>
                    </div>

                    

                  </div>

                  <div class="col-md-5">
                      <table id="" class="table table-list dataTable collapsed table-bordered" width="100%" >
                        <tr style="background-color: #222e2b;color: white;">
                          <th colspan="2">LEDGER ALTRATION</th>
                        </tr>
                        <?php if(in_array('ledgeredit', $accessar) || $this->session->userdata('usertype') == 'Admin'){ ?>
                        <tr class='clickable-row' data-href="<?=site_url("masters/edit_ledger/".$rec[0]['ledger_id']);?>" role="row" class="odd">
                          <td>A</td>
                          <td>Edit Ledger Details</td>
                          
                        </tr>
                        <?php } ?>
                        <tr class='clickable-row' data-href="<?=site_url("masters/ledgerbank_details?ledger_id=".$rec[0]['ledger_id']);?>" role="row" class="odd">
                          <td>B</td>
                          <td>Bank Details</td>
                        </tr>

                        <?php $chkreg = $this->Common_Model->FetchData("ledgers","*","unregledger_id=".$rec[0]['ledger_id']); 
                        if ($chkreg) {}else{
                        ?>

                        <tr class='clickable-row' data-href="<?=site_url("masters/ctregdparty?ledger_id=".$rec[0]['ledger_id']);?>" role="row" class="odd">
                          <td>C</td>
                          <td>Convert to register party</td>
                        </tr>
                      <?php } ?>
                      <?php if($rec[0]['bankorcashac']=='Yes'){}else{ ?>  

                        <tr class='clickable-row' data-href="<?=site_url("masters/ledger_workorder?ledger_id=".$rec[0]['ledger_id']);?>" role="row" class="odd">
                          <td>D</td>
                          <td>Work Order ( If any )</td>
                        </tr>
 
                        <?php } ?>
                      </table>
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
  jQuery(document).ready(function($) {
    $(".clickable-row").click(function() {
      if (confirm("Are you sure you want to navigate to this page?")) {
        window.location = $(this).data("href");
      }
    });
});
</script>
</body>
</html>