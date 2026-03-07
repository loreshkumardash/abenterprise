<?php $this->load->view("common/meta");?>
<style type="text/css">

  .table>tbody>tr[data-url], table>tbody>tr[data-url] {
    cursor: pointer;
    
}
.table>tbody>tr[data-url]:hover {
    background:#b0b0b0;
    color: black;
  }
tr {
    display: table-row;
    vertical-align: inherit;
    border-color: inherit;
    line-height: 5px!important;
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
              <h3 class="box-title">List Ledgers</h3>
              
                
              
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
              
              <div class="col-md-12">
                  <form role="form" action="" method="post" id="searchForm">
                      <div class="row">
                      <div class="col-md-3">
                          <div class="form-group">
                              <label for="ledger_name">Ledger Name</label>
                              <input type="text" class="form-control" id="ledger_name" name="ledger_name" value="<?=isset($_REQUEST['ledger_name'])?$_REQUEST['ledger_name']:'';?>">
                          </div>
                      </div>
                    <div class="col-md-3">
                          <div class="form-group">
                              <label for="account_group">Account Group</label>
                              <select class="form-control" id="account_group" name="account_group" >
                                <option value="">Select</option>
                                <?php if ($accountgroup) { for ($i=0; $i <count($accountgroup) ; $i++) { ?>
                                  <option value="<?=$accountgroup[$i]['group_id'];?>"><?=$accountgroup[$i]['group_name'];?></option>
                                <?php }} ?>
                              </select>
                          </div>
                      </div>
                      <div class="col-md-4" style="padding-top: 15px;">
                          <button type="submit" name="submitBtn" value="submit" class="btn bg-navy btn-flat">Search</button>
                        <button type="submit" name="downloadBtn" value="submit" class="btn bg-maroon btn-flat margin">Download</button>
                      </div>
                      </div>
                  </form>
              </div>

              <table id="" class="table table-list dataTable no-footer dtr-inline collapsed" width="100%" >
                <tr style="background-color: #2e2d2e;color: white;">
                  <th >Sl</th>
                  <th >Alias</th>
                  <th >Ledger Name</th>
                  <th >Account Group</th>
                  <th  class="text-center">Mobile</th>
                  <th class="text-center">GST</th>
                  <th  class="text-center">State</th>
                  
                  

                </tr>
                <?php if($records){ for($i=0;$i<count($records);$i++){
                    $unit = $this->Common_Model->FetchData("units","*","ledger_id=".$records[$i]['ledger_id']."");
                ?>
                <tr data-url="javascript:void(0);" onclick="return view(<?php echo $records[$i]['ledger_id'];?>);" role="row" class="odd">
                  <td ><?php echo ($i+1);?></td>
                  <td ><?php echo $records[$i]['ledger_alias'];?></td>
                  <td ><?php echo $records[$i]['ledger_name'];?></td>
                  <td ><?php echo $records[$i]['group_name'];?></td>
                  <td  class="text-left"><?php echo $records[$i]['mobile'];?></td>
                  <td  class="text-left"><?php echo $records[$i]['gst_no'];?></td>
                  <td  class="text-left"><?php echo $records[$i]['state_title'];?></td>
                 
                </tr>
                <?php }} ?>
              </table>
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
<script>
   
  var curPage = 'view_ledger';
  
  function view(Id){
    document.location.href=curPage+"/"+Id;
  }
</script>
</body>
</html>