<?php $this->load->view("common/meta");?>
<style type="text/css">
  table{
    padding: 0px!important;
    margin: 0px!important;
  }
  .table>tbody>tr[data-id], table>tbody>tr[data-id] {
    cursor: pointer;
    
}
.table>tbody>tr.cb:hover {
    background:#4e635e;
    color: white;
    text-transform: bold;
  }
  
 .ld_btn:hover {
    background-image: linear-gradient(to top, #29abd6, #e4eaf5);
  } 

tr {
    display: table-row;
    vertical-align: inherit;
    
}
.table>tbody>tr>td {
    padding: 1px;
}
table.dataTable {
    clear: both;
    max-width: none!important;
    border-collapse: ;
    font-size: 16px;
    font-weight: 400px;
    font-family: inherit;
    padding: 0px;

}
</style>
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
              <h3 class="box-title">Stock Report ( Site Wise )</h3>
              <button id="btnExport" class="btn btn-sm btn-primary pull-right" onclick="fnExcelReport();"> EXPORT EXCEL </button>
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
                
              </div>
              <div class="row">
                <form method="post">
                  <div class="col-md-12">
                    <div class="col-md-3 form-group">
                        <label>Select</label>
                        <select name="ledger_id" class="form-control">
                          <?php if ($ledgers) { for ($i=0; $i <count($ledgers) ; $i++) { ?>
                              <option value="<?=$ledgers[$i]['ledger_id'];?>"><?=$ledgers[$i]['ledger_name'];?></option>
                          <?php }} ?>
                          
                        </select>
                    </div>
                    <button type="submit" class="btn bg-navy btn-flat" style="margin-top:25px;">Search</button>
                  </div>
                </form>
                <div class="col-md-12" id="dataTablediv">
                  <?php
                  if(isset($records) && $records){
                    ?>
                  <table class="table table-bordered table-condensed table-striped" id="stocktable">
                    <tr>
                      <th width="5%">Sl No</th>
                      <th width="10%">Ledger Id</th>
                      <th width="60%">Ledger Name</th>
                      <th width="15%" style="text-align:right;">Price</th>
                      <th width="10%" style="text-align:right;">Stock</th>
                    </tr>
                    <?php
                    $sl = 1;
                    $totalstock = 0;
                    $totalprice = 0;
                    for($i=0;$i<count($records);$i++){
                      $stockledger = $this->Common_Model->db_query("SELECT SUM(item_quantity) AS stock , SUM(item_amount) AS price FROM ledgerutensil_items as a LEFT JOIN ledger_utensils as b on a.utensil_id=b.utensil_id  WHERE b.ledger_id=".$records[$i]['ledger_id']);

                        ?>
                    <tr data-id="<?=$records[$i]['ledger_id'];?>" class="cb description">
                      <td><?=$sl++;?></td>
                      <td><?php echo $records[$i]['ledger_id'];?></td>
                      <td><?php echo $records[$i]['ledger_name'];?></td>
                      <td style="text-align:right;"><?php echo $stockledger[0]['price']; ?></td>
                      <td style="text-align:right;"><?php echo $stockledger[0]['stock'];?></td>
                    </tr>
                    <?php
                    /*$totalstock += $records[$i]['item_qty'];
                    $totalprice += $records[$i]['item_price'];*/
                    }
                    ?>
                   
                  </table>
                  <?php if ($records) {
                    echo $sPages;
                  } ?>
                    <?php
                  }
                  ?>
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
  function fnExcelReport()
  {
    var tab_text="<table border='2px'><tr bgcolor='#87AFC6'>";
    var textRange; var j=0;
    tab = document.getElementById('stocktable'); // id of table

    for(j = 0 ; j < tab.rows.length ; j++) 
    {     
        tab_text=tab_text+tab.rows[j].innerHTML+"</tr>";
        //tab_text=tab_text+"</tr>";
    }

    tab_text=tab_text+"</table>";
    tab_text= tab_text.replace(/<A[^>]*>|<\/A>/g, "");//remove if u want links in your table
    tab_text= tab_text.replace(/<img[^>]*>/gi,""); // remove if u want images in your table
    tab_text= tab_text.replace(/<input[^>]*>|<\/input>/gi, ""); // reomves input params

    var ua = window.navigator.userAgent;
    var msie = ua.indexOf("MSIE "); 

    if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./))      // If Internet Explorer
    {
        txtArea1.document.open("txt/html","replace");
        txtArea1.document.write(tab_text);
        txtArea1.document.close();
        txtArea1.focus(); 
        sa=txtArea1.document.execCommand("SaveAs",true,"stockreport.xls");
    }  
    else                 //other browser not tested on IE 11
        sa = window.open('data:application/vnd.ms-excel,' + encodeURIComponent(tab_text));  

    return (sa);
  }

  $(document).ready(function(){
  
  });

  if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }

    $(document).on('click', '.description', function(){
      var id = $(this).attr('data-id');
      var url = "<?php echo site_url(); ?>";
      /*document.location.href=url+"/reports/todaysgrossprofitWithDay/"+id;*/
      document.location.href=url+'/reports/stockledger_items/'+id;
    });
</script>
<iframe id="txtArea1" style="display:none"></iframe>

</body>
</html>