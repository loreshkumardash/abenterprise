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
              <h3 class="box-title">Stock Report Items ( Site Wise )</h3>
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
                <div class="col-md-12" id="dataTablediv">
                  
                  <?php
                  if(isset($items) && $items){
                    ?>
                  <table class="table table-bordered table-condensed table-striped" id="stocktable">
                    
                    <tr>
                      <th >Sl No</th>
                      <th >Item ID</th>
                      <th >Name</th>
                      <th style="text-align:center;">Unit</th>
                      <th  style="text-align:center;">Desciption</th>
                      <th  style="text-align:right;">Price</th>
                      <th  style="text-align:right;">Stock</th>
                    </tr>
                    <?php
                    $sl = 1;
                    $totalstock = 0;
                    $totalprice = 0;
                    foreach ($items as $key => $value) {
                      $rec = $this->Common_Model->db_query("SELECT SUM(item_quantity) AS stock , SUM(item_amount) AS price , c.item_type,c.item_unit,c.item_name FROM ledgerutensil_items as a LEFT JOIN ledger_utensils as b on a.utensil_id=b.utensil_id LEFT JOIN assets as c on a.item_id=c.asset_id  WHERE b.ledger_id=".$ledger_id." AND a.item_id=".$value."");
                        ?>
                    <tr>
                      <td><?=$sl++;?></td>
                      <td><?php echo $value;?></td>
                      <td><?php echo $rec[0]['item_name'];?></td>
                      <td style="text-align:center;"><?php echo $rec[0]['item_unit'];?></td>
                      <td style="text-align:center;"><?php echo $rec[0]['item_type'];?></td>
                      <td style="text-align:right;"><?php echo $rec[0]['price'];?></td>
                      <td style="text-align:right;"><?php echo $rec[0]['stock'];?></td>
                    </tr>
                    <?php
                    $totalstock += $rec[0]['stock'];
                    $totalprice += $rec[0]['price'];
                    }
                    ?>
                    
                    <tr>
                      <td colspan="2"><b>Site Name :</b></td>
                      <td ><b><?=$ledgers[0]['ledger_name'];?></b></td>
                      <td style="text-align:center;"></td>
                      <td style="text-align:center;"><b>TOTAL</b></td>
                      <td style="text-align:right;"><b><?php echo number_format($totalprice,2);?></b></td>
                      <td style="text-align:right;"><b><?php echo $totalstock;?></b></td>
                    </tr>
                  </table>
                  
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