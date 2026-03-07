<?php $this->load->view("common/meta");?>
<div class="wrapper">

  <?php $this->load->view("common/sidebar");?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Master Data
        <small>Item</small>
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">View Item</h3>
              <?php if(in_array('itemview', $accessar) || $this->session->userdata('usertype') == 'Admin'){ ?>
              <a href="<?=site_url("masters/item");?>" class="btn btn-primary btn-sm" style="float:right;">List Item</a>
              <?php }?>
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
	              <strong>Error !</strong> <?php echo $this->session->flashdata('error');?>
	              </div>
	              <?php
	              }
	              ?>

      
        <div class="row">
			    <div class="col-md-12"> 
			          <div class="" style="background-color: #fbfafa;">  <center><h3 style="border-radius: 5px;color: red; text-decoration: underline;text-decoration-color: #b4ec90;"> General Information</h3></center><br>
             	<div class="row" style="font-size: 14px; color:#928b8b; line-height: 33px">
						  <div class="col-md-6">
						    <div class="row">
							   	<div class="col-md-4" >
							      <span style="font-weight: 600;color: #4c4c4c;font-size: 14px;">ITEM NAME </span>
							    </div>
							    <div class="col-md-8">  
							     <?=$rec[0]['name'];?>
							   </div>
						   </div>
						   <div class="row" style="margin-top:5px;">   
							    <div class="col-md-4">
							       <span style="font-weight: 600;color: #4c4c4c;font-size: 14px;">ITEM PRINT NAME</span>
							    </div>
							    <div class="col-md-8">   
							      <?=$rec[0]['print'];?>
							    </div>
						    </div>
						    <div class="row" style="margin-top:5px;">
							    <div class="col-md-4">
							       <span style="font-weight: 600;color: #4c4c4c;font-size: 14px;">ITEM GROUP</span>
							    </div>
							    <div class="col-md-8"> 
							      <?=$rec[0]['group'];?>
							    </div>
							</div>
							<div class="row" style="margin-top:5px;">
							     <div class="col-md-4" style="margin-top:5px;">
							       <span style="font-weight: 600;color: #4c4c4c;font-size: 14px;">TAX RATE % </span>
							    </div>
							    <div class="col-md-8"> 
							      <?=$rec[0]['rate'];?> %
							    </div>
							</div>

						  </div>
						

						  <div class="col-md-6">
						    <div class="row" >
							    <div class="col-md-4">
							       <span style="font-weight: 600;color: #4c4c4c;font-size: 14px;">ITEM PICTURE</span>
							    </div>

							    <div class="col-md-5">
							      <div class="drop-zone">
							        

							      </div>
							      
							   </div>

							   <div class="col-md-3">
							     
							   </div>
							</div>
							<div class="row" style="margin-top:10px;">
							    <div class="col-md-4">
							       <span style="font-weight: 600;color: #4c4c4c;font-size: 14px;">HSN / SAC CODE </span>
							    </div>
							    <div class="col-md-8"><?=$rec[0]['hsn'];?></div>
						   	</div>
						   	<div class="row" style="margin-top:5px;">
						     	<div class="col-md-4">
						       		<span style="font-weight: 600;color: #4c4c4c;font-size: 14px;">Serial No. Wise Details</span>
						    	</div>
							    <div class="col-md-8"> 
							      <?=$rec[0]['serial'];?>
							      
							     </div>
							</div>
				   </div>
				 </div>

				<div class="row">
				     <div class="col-md-3 csed">
						 <span style="font-weight: 600;color: #4c4c4c;font-size: 14px;">ITEM DESCRIPTION - 1 </span>
					     <?=$rec[0]['des'];?>
				  	</div>
				   	<div class="col-md-3 csed">
						 <span style="font-weight: 600;color: #4c4c4c;font-size: 14px;">ITEM DESCRIPTION - 2 </span>
					     <?=$rec[0]['des1'];?>
				  	</div>
				   	<div class="col-md-3 csed">
						 <span style="font-weight: 600;color: #4c4c4c;font-size: 14px;">ITEM DESCRIPTION - 3 </span>
					     <?=$rec[0]['des2'];?>
				  	</div>
				   	<div class="col-md-3 csed">
					 <span style="font-weight: 600;color: #4c4c4c;font-size: 14px;">ITEM DESCRIPTION - 4 </span>
				     <?=$rec[0]['des3'];?>
				  	</div>
				</div>

				</div>


				<div class="row">
 
					<div class="col-md-12"> 
					   <div class="" style="background-color: #fbfafa;">  <center><h3 style=" border-radius: 5px;color: red; text-decoration: underline;text-decoration-color: #b4ec90; ">UNIT DETAILS</h3></center><br>
					<div class="row" style="font-size: 14px; color:#928b8b; ">
					 
					  <div class="col-md-1" style="align-self: center;">
					    <span style="font-weight: 600;color: #000;font-size: 14px;">Main Unit</span>
					  </div>
					  <div class="col-md-3">
					     <?=$rec[0]['unit'];?>
					  </div>
					   <div class="col-md-1" style="align-self: center;">
					    <span style="font-weight: 600;color: #4c4c4c;font-size: 14px;">Alternate Unit</span>
					  </div>
					  <div class="col-md-3">
					     <?=$rec[0]['alt_unit'];?>
					  </div>
					   <div class="col-md-1" style="align-self: center;">
					    <span style="font-weight: 600;color: #4c4c4c;font-size: 14px;">Conversion Factor</span>
					  </div>
					    <div class="col-md-3"> 
					      <?php echo $rec[0]['alt_fact']; ?>
					    </div>
					</div>
					<br>
					<div class="row">
					 
					 
					  <div class="col-md-1" style="align-self: center;">
					    <span style="font-weight: 600;color: #4c4c4c;font-size: 14px;">Opening Stock(Qty)</span></div>
					  <div class="col-md-3" style="align-self: center;"><?=$rec[0]['stock'];?></div>
					  <div class="col-md-1" style="align-self: center;"><span style="font-weight: 600;color: #4c4c4c;font-size: 14px;">Conversion Type </span></div>
					    <div class="col-md-7" style="align-self: center;"> 
					      <div class="your-class">
					        <?=$rec[0]['alt_type'];?>
					      </div>
					    </div>

					  </div>
					    <hr>

					    <div class="row">
					      <div class="col-md-1" style="align-self: center;"><span style="font-weight: 600;color: #000;font-size: 14px;">Packaging  Unit </span><br></div>
					      <div class="col-md-3">
					        <?=$rec[0]['pack'];?>
					      </div>
					     
					      <div class="col-md-1" style="align-self: center;"><span style="font-weight: 600;color: #4c4c4c;font-size: 14px;">Conversion Factor</span></div>
					      <div class="col-md-3 "> 
					         <?=$rec[0]['pack_con'];?>
					      </div>
					      <div class="col-md-4"></div>
					    </div>

					    <div class="row">
					      <div class="col-md-1" style="align-self: center;"> <br>
					        <span style="font-weight: 600;color: #4c4c4c;font-size: 14px;">Opening Stock(Qty)</span></div>
					      <div class="col-md-3"><br><?=$rec[0]['alt_stock'];?></div>
					       <div class="col-md-1" style="align-self: center;"><br>
					        <span style="font-weight: 600;color: #4c4c4c;font-size: 14px;">Conversion Type</span></div>
					      <div class="col-md-7" style="align-self: center;"> <br>
					        <div class="your-class">
					            <?php echo $rec[0]['packalt_type']; ?>
					        </div>
					      </div>
					    </div>
					 
					    </div>
 
          </div>
        </div>
				</div>

				<div class="col-md-12"> 
              <div class="" style="background-color: #fbfafa;">  <center><h3 style=" border-radius: 5px;color: red; text-decoration: underline;text-decoration-color: #b4ec90; ">PRICE DETAILS</h3></center><br> 
            <div class="row" style="font-size: 14px;  line-height: 33px">
					    <div class="col-md-12">
					          <div class="table-responsive">
					              <table class="table table-hover table-bordered">
					                <thead>
					                  <tr>
					                    <th>UNIT TYPE</th>
					                    <th>PURCHASE PRICE</th>
					                    <th>MINIMUM SALE PRICE</th>
					                    <th>SALE PRICE</th>
					                  </tr>
					                  <tr>
                    <td>MAIN UNIT</td>
                    <td><?php echo $rec[0]['main_price']; ?></td>
                    <td><?php echo $rec[0]['main_sale']; ?></td>
                    <td><?php echo $rec[0]['main_mrp']; ?></td>
                  </tr>
                  <tr>
                    <td>ALTERNATE UNIT</td>
                    <td><?php echo $rec[0]['alt_price']; ?></td>
                    <td><?php echo $rec[0]['alt_sale']; ?></td>
                    <td><?php echo $rec[0]['alt_mrp']; ?></td>
                  </tr>
                  <tr>
                    <td>PACKAGING UNIT</td>
                    <td><?php echo $rec[0]['pack_price']; ?></td>
                    <td><?php echo $rec[0]['pack_sale']; ?></td>
                    <td><?php echo $rec[0]['pack_mrp']; ?></td>
                  </tr>
					                </thead>
					                <tbody>
					       
					                  
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
</body>
</html>