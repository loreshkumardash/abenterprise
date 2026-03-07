<?php $this->load->view("common/meta");?>
<style type="text/css">
	#imagePreview6 img{
        height: 150px; width: 150px;
      }  
      div.ex1 {
  
 
  width: 100%;
  overflow-y: scroll;
}  
div.ex2 {
  
 
  width: 100%;
  overflow-y: scroll;
}  
td>input{
  border:none; 
}
    .tile {
      margin:0px; 
    }
        /* Style the tab */
    .tab {
      overflow: hidden;
      border: 1px solid #ccc;
      background-color: #fff;
      border: none;
    }
    /* Style the buttons inside the tab */
    .tab span {
      background-color: inherit;
      float: left;
      border: none;
      outline: none;
      cursor: pointer;
      padding: 0.75rem 1.25rem;
      transition: 0.3s;
      font-size: 17px;
      
    }
    /* Change background color of buttons on hover */
    .tab span:hover {
      background-color: #ddd;
    }
    /* Create an active/current tablink class */
    .tab span.active {
      background-color: rgba(0,0,0,.03);
      border-bottom: solid 2px #ab0d0d;
    }
    .tabcontent{
      background-color:rgba(0,0,0,.03);
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
        <small>Bill of Materials</small>
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Details Bill of Material</h3>
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

	              	$alias1=$_GET['alias'];
					$select=$this->Common_Model->db_query("select * from bill where alias='$alias1'");
					$row=$select[0];
					$alias=$row['alias'];
	              ?>

      			<div class="row ">
      				<div class="col-md-12 " >
			          <div class="nav-tabs-custom">
			                    <ul class="nav nav-tabs">
			                        <li  class="active">
			                        	<a href="#overview" data-toggle="tab">OVERVIEW</a>
			                        </li>
			                        <li>
			                        	<a href="#rmc" data-toggle="tab">RAW MATERIAL</a>
			                        </li>
			                    </ul>
					        <div class="tab-content" style="background-color:rgba(0,0,0,.03)!important;">


			          	<div class="active tab-pane" id="overview">
			            	<h3>GENERAL INFORMATION</h3>
			            	<div class="row" style="font-size: 14px; color:#928b8b; ">
			            	 	<div class="col-md-2">
			             
			              			<span style="color: black;font-weight: 600">BOM NAME :</span><br><br>
			              		</div>
			              		<div class="col-md-4"> <?php echo $row['bom']; ?></div>
		                  		<div class="col-md-2">
		                 			<span style="color: black;font-weight: 600">ALIAS :</span><br><br>
		              			</div>
			               		<div class="col-md-4"> 
			               			<?php echo $row['alias']; ?>
			               		</div>
			               	</div>
			               	<div class="row" style="font-size: 14px; color:#928b8b; ">
			             		<div class="col-md-2">
			                 		<span style="color: black;font-weight: 600">ITEM TO PRODUCE :</span><br><br>
			              		</div>
			            		<div class="col-md-4">  
			           				<?php echo $row['item']; ?>
			            		</div>
			             		<div class="col-md-2">
			                 		<span style="color: black;font-weight: 600">QUANTITY :</span><br><br>
			              		</div>
			            		<div class="col-md-4">   <?php echo $row['qty']; ?></div>
			            	</div>
			            	<div class="row" style="font-size: 14px; color:#928b8b; ">
			             		<div class="col-md-2">
			                 		<span style="color: black;font-weight: 600">UNIT :</span><br><br>
			              		</div>
			            		<div class="col-md-4">   
			               			<?php echo $row['unit']; ?></div>
			              		<div class="col-md-2">
			                 		<span style="color: black;font-weight: 600">EXPENSES / UNIT :</span><br><br>
			              		</div>
			            		<div class="col-md-4">   <?php echo $row['exp_unit']; ?></div>
			              
			             	</div>
			          	</div>

			           	<div id="rmc" class="tab-pane">
							<h3>RAW MATERIAL CONSUMED</h3> 
							    <div class="row" style="font-size: 14px; color:#000; line-height: 33px">
							        <div class="col-md-12 ex2">
							            <div class="table-responsive">
							              <table class="table table-hover table-bordered table-condensed table-striped">
							                <thead>
							                  <tr>
							                    <th>Sl No</th>
							                    <th>Item Name</th>
							                    <th>Qty.</th>
							                    <th>Unit</th>
							                  </tr>
							                </thead>
							                <tbody>
								         <?php 
								            $sl=0;
								            $quantity1=0;
								            $select2=$this->Common_Model->db_query("select * from bill_raw where alias='$alias' order by id ASC");
								           foreach ($select2 as $key => $row2) {
								           	
								              $sl++;
								               $quantity1=$quantity1+$row2['qty'];
								            ?>
								                  <tr>
								                    <td><?php echo $sl; ?></td>
								                    <td>
								                        <?php echo $row2['item']; ?>
								                        <hr style="margin: 0px">
								                        <?php echo $row2['des'];?>
								                    </td>
								                    <td><?php echo $row2['qty'];?></td>
								                    <td><?php echo $row2['unit']; ?></td>
								                  </tr>
								            <?php } ?> 
			                 
			                  
							                </tbody>
							            </table>
							       	</div>
				        		</div>
 
							    <div class="col-md-9"></div>
							    <div class="col-md-3">
							      <b style="color:black"> Quantity : <?php echo $quantity1; ?></b> 
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