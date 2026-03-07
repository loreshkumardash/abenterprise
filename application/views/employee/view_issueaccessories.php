<?php $this->load->view("common/meta");?>

<div class="wrapper">

  <?php $this->load->view("common/sidebar");?>
  
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Issue Accessories
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">View Issue Accessories </h3>              
            </div>
            <!-- /.box-header -->
           
            <div class="box-body">
              
                <div class="col-md-10">
	                <div class="row">
	                    <div class="col-md-3 ">
	                      <label for="employee_code">Employee Code</label>
	                    </div>
	                   
	                    <div class="col-md-8 ">
	                      <label for="employee_code">:<?=$rec[0]['employee_code'];?></label>
	                    </div>
	                </div>
                </div>
                <div class="col-md-10">
	                <div class="row">
	                    <div class="col-md-3 ">
	                      <label for="employee_code">Employee Name</label>
	                    </div>
	                   
	                    <div class="col-md-8 ">
	                      <label for="employee_code">:<?=$rec[0]['employee_name'];?></label>
	                    </div>
	                </div>
                </div>
                <div class="col-md-10">
	                <div class="row">
	                    <div class="col-md-3 ">
	                      <label for="employee_code">Issue Date</label>
	                    </div>
	                   
	                    <div class="col-md-8 ">
	                      <label for="employee_code">:<?=$rec[0]['issue_date'];?></label>
	                    </div>
	                </div>
                </div>
                <div class="col-md-10">
	                <div class="row">
	                    <div class="col-md-3 ">
	                      <label for="employee_code">Amount</label>
	                    </div>
	                   
	                    <div class="col-md-8 ">
	                      <label for="employee_code">:<?=$rec[0]['tot_amount'];?></label>
	                    </div>
	                </div>
                </div>
                    
                  <div class="row">
                    <div class="col-md-7">
                        
                        <h5>Accessories</h5>
                      <table class="table table-bordered table-condensed " width="100%">
                        <tr>
                          <th width="40%">Item Name</th>
                          <th width="20%">Price</th>
                          <th width="15%">Qty</th>
                          <th width="25%">Subtotal</th>
                          
                        </tr>
                        <tbody class="itemslist">
                        	<?php if ($recitems) { for ($i=0; $i <count($recitems) ; $i++) { ?>
                        		
                        	
                          <tr>
                            <td><?=$recitems[$i]['item_name'];?></td>
                            <td><?=$recitems[$i]['item_price'];?></td>
                            <td><?=$recitems[$i]['item_quantity'];?></td>
                            <td><?=$recitems[$i]['final_amount'];?></td>
                            
                          </tr>
                          <?php }} ?>
                        </tbody>
                        
                      </table>
                      
                    </div>
                  </div>
                  
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
<?php $this->load->view("common/script");?>
<script type="text/javascript">
 
  
</script>
</body>
</html>
