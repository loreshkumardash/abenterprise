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
              <h3 class="box-title">Stock Report</h3>
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
                        <label>Item Name</label>
                        <input type="text" name="item_name" class="form-control">
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
                      <th width="10%">Item ID</th>
                      <th width="35%">Name</th>
                      <th width="10%" style="text-align:center;">Unit</th>
                      <th width="15%" style="text-align:center;">Desciption</th>
                      <th width="15%" style="text-align:right;">Price</th>
                      <th width="10%" style="text-align:right;">Stock</th>
                    </tr>
                    <?php
                    $sl = 1;
                    $totalstock = 0;
                    $totalprice = 0;
                    for($i=0;$i<count($records);$i++){
                        ?>
                    <tr>
                      <td><?=$sl++;?></td>
                      <td><?php echo $records[$i]['asset_id'];?></td>
                      <td><?php echo $records[$i]['item_name'];?></td>
                      <td style="text-align:center;"><?php echo $records[$i]['item_unit'];?></td>
                      <td style="text-align:center;"><?php echo $records[$i]['item_type'];?></td>
                      <td style="text-align:right;"><?php echo $records[$i]['item_price'];?></td>
                      <td style="text-align:right;"><?php echo $records[$i]['item_qty'];?></td>
                    </tr>
                    <?php
                    $totalstock += $records[$i]['item_qty'];
                    $totalprice += $records[$i]['item_price'];
                    }
                    ?>
                    <tr>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td style="text-align:center;"></td>
                      <td style="text-align:center;"><b>TOTAL</b></td>
                      <td style="text-align:right;"><b><?php echo number_format($totalprice,2);?></b></td>
                      <td style="text-align:right;"><b><?php echo $totalstock;?></b></td>
                    </tr>
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
</script>
<iframe id="txtArea1" style="display:none"></iframe>

</body>
</html>