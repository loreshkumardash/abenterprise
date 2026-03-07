<?php $this->load->view("common/meta");?>
<style>
  #imagePreview6 img{
        height: 150px; width: 150px;
      }  
      div.ex1 {
  
		  height:300px;
		  width: 100%;
		  overflow-y: scroll;
		}  
		div.ex2 {
		  
		  height:300px;
		  width: 100%;
		  overflow-y: scroll;
		}  
		td>input{
		  border:none; 
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
		     .row_position td:first-child{
		 border:1px solid #dee2e6;
		 border-collapse: collapse;
		 cursor:all-scroll;
		 background-color: #fff;
		}
		.row_position tr{
		   background-color: #fff;
		   cursor: text;
		}
		  .table {
                border-collapse: collapse;
            }
            .draggable {
                cursor: move;
                user-select: none;
            }
            .placeholder {
                background-color: #edf2f7;
                border: 2px dashed #cbd5e0;
            }
            .clone-list {
                border-top: 1px solid #ccc;
            }
            .clone-table {
                border-collapse: collapse;
                border: none;
            }
            .clone-table th,
            .clone-table td {
                border: 1px solid #ccc;
                border-top: none;
                padding: 0.5rem;
            }
            .dragging {
                background: #fff;
                border-top: 1px solid #ccc;
                z-index: 999;
            }
            .ui-sortable-handle{
              position: relative;
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
              <h3 class="box-title">Edit Raw Material</h3>
                            
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

	              	$id=$_GET['id'];
					$id1=$_GET['id10'];
						$s1=$this->Common_Model->db_query("select * from bill where id='$id'");
					 	$r1=$s1[0];
					 	$alias2=$r1['alias'];
					  	$s2=$this->Common_Model->db_query("select * from bill_raw where id='$id1'");
						$r2=$s2[0];
					 	$id2=$r1['id'];
	              ?>
	            
      			<div class="row">
   
			        <div class="col-md-12">
			         
			      <!--<center><a href="customer.php" class="btn btn-info">Upload Customer</a></center><br>-->
			         
			       <div class="tile">
			        <div class="tile-body">
			        <center><h3 style="color: #f32f10 !important;font-weight: 600;text-transform: uppercase;">RAW MATERIAL CONSUMED</h3></center> 
			       <form action="" method="post"  enctype="multipart/form-data"> 
			        <input  type="hidden" name="id" value="<?php echo $id1; ?>">
			         <input  type="hidden" name="alias" value="<?php echo $alias2; ?>">
			         <input  type="hidden" name="id2" value="<?php echo $id2; ?>">

			       <div class="row" >
			        <div class="col-md-12">
			          <div class="table-responsive">
			            <table class="table  table-bordered">
			              <thead>
			                <tr>
			                  <th> Item Code / Name / Description</th>
			                  <th style="width:130px">Qty.</th>
			                  <th style="width: 150px">Unit</th>
			                  <!-- <th></th> -->
			                 </tr>
			               </thead>
			               <tbody>
			                <td>
			                   <input list="item1"  type="text" name="code" class="form-control" value="<?php echo $r2['code']; ?>">
			                        <datalist id="item1">

			                               <?php 
			                                    $sl=0;
			                                    $select=$this->Common_Model->db_query("select * from item order by id DESC");
			                                    foreach ($select as $key => $row) {
			                                    	
			                                      $sl++;
			                                    ?>
			                            <option value="<?php echo $row['code']; ?>">
			                              <?php echo substr($row['code'],0,8); ?>&nbsp;&nbsp;&nbsp;
			                              <?php echo substr($row['group'],0,8); ?>&nbsp;&nbsp;&nbsp;
			                              <?php echo $row['name']; ?>
			                            </option>

			                            <?php } ?> 
			                           </datalist>
			                            <textarea id="name1" class="form-control textarea" style="height: 35px !important;resize: none !important;  margin-top: 5px;font-size: 14px;border-bottom: none;"><?php echo $r2['item']?></textarea>
			                            <textarea class="form-control" name="des"  style="margin-top: 0px;height: 110px;border-top: none;"><?php echo $r2['des'];?></textarea>
			                </td>
			                <td>
			                    <input type="text" name="qty"  class="form-control" value="<?php echo $r2['qty']; ?>">
			                </td>
			                <td>
			                   <select class="form-control" type="text" name="unit" id="unit1">
	          						
						           <?php $itmrec = $this->Common_Model->FetchData("item","*","code='".$r2['code']."'");
                                    $units ='<option value="">--Select--</option>';
                                    if ($itmrec) {
                                      if ($itmrec[0]['unit']) {
                                            $units .= '<option value="unit" '.($r2['unit1']=='unit'?'selected':'').'>'.$itmrec[0]['unit'].' - Main Unit</option>';
                                            }
                                      if ($itmrec[0]['alt_unit']) {
                                      $units .= '<option value="alt_unit" '.($r2['unit1']=='alt_unit'?'selected':'').'>'.$itmrec[0]['alt_unit'].' - Alt. Unit</option>';
                                            }
                                      if ($itmrec[0]['pack']) {
                                        $units .= '<option value="pack" '.($r2['unit1']=='pack'?'selected':'').'>'.$itmrec[0]['pack'].' - Pack. Unit</option>';
                                            }
                                    } ?>
                                    <?=$units;?>
						          	</select>

			                            <br><br><br><br>
			                              <div class="form-group" style="float: right;margin-bottom: 0px;margin-top: 0px">
					           		<button type="submit" value="update" class="btn btn-default" name="update" title="update" style="padding: 2px 5px;font-weight: 500">
					                 <i class="fa fa-refresh" style="font-size: 15px;color: green"></i> Update
					           		</button>
					         </div>
			                </td>
			                        
			              </tbody>
			             </table>
			           </div>
			         </div>
			       </div>

			
			       </form><br>
			       <div class="row">
			        <div class="col-md-12">
			         <?php
			                   
			                    $select=$this->Common_Model->db_query("select * from bill_raw  where alias='$alias2' order by display_order ASC");
			                  if($select){
			                      ?>
			           <div class="table-responsive">
			               <table class="table  table-bordered">
			                <thead>
			                  <tr>
			                    <th>Sl No </th>
			                    <th >Item Name</th>
			                    <th>Item Code</th>
			                    <th>Item Group</th>
			                    <th>Qty.</th>
			                    <th>Unit</th>
			                    <th>Action</th>
			                  </tr>
			                </thead>
			                <tbody>
			                   <?php 
						            $sl=0;
						         
						            foreach ($select as $key => $row) {
						            	
						              $sl++;
						            
						            ?>
					            <tr>
					              	<td><?php echo $sl; ?></td>
					          		<td><?php echo $row['item']; ?>
					              		<hr style="margin: 0px">
					              		<?php echo $row['des'];?>
					          		</td>
					          		<td><?php echo $row['code']; ?></td>
					           		<td><?php echo $row['group']; ?></td>
					           		<td><?php echo $row['qty']; ?></td>
					          		<td><?php echo $row['unit']; ?></td>
					           		<td>
										<a href="<?=site_url("masters/billrawedit");?>?id10=<?php echo $row['id']; ?>&id=<?php echo $id2; ?>" ><i class="fa fa-edit" style="color:green"></i></a>
										&nbsp;&nbsp;
					            	</td>
					            </tr>
					          <?php } ?>
			         
			                </tbody>
			              </table>
			                      </div>
			                    <?php } ?>
			        </div>
			       </div>
			    </div>
			        </div> 
			
			       
			        
			      </form>
			  	</div>
			        </div> 
			      
			      
			       <form action="" method="post" role="form" enctype="multipart/form-data">
			       <div class="tile">
			          <center><h3 style="color: #f32f10 !important;font-weight: 600;text-transform: uppercase;"> Add Bill Of Material Master</h3></center>
			       		<div class="tile-body">
			       		<div class="row">
			       			<div class="col-md-4">
			       				<div class="form-group">
			       					<label>BOM NAME</label>
			       					<input type="hidden" name="date" class="form-control" value="<?php echo $r1['date']; ?>" >  
			        				<input type="text" name="bom" class="form-control" value="<?php echo $r1['bom']; ?>" >
		       					</div>
			       			</div>
			       			<div class="col-md-4">
			       				<div class="form-group">
			       					<label>ALIAS</label>
			       					<input type="text" name="alias" class="form-control" value="<?php echo $alias2; ?>" readonly>
			       				</div>
			       			</div>
			        		<div class="col-md-4">
		       					<div class="form-group">
							       <label>ITEM TO PRODUCE</label>
							       <input list="item"  type="text" class="form-control" name="item" value="<?php echo $r1['item']; ?>">
								  <datalist id="item" style="overflow-y: auto !important">
								 
								       <?php 
								            $sl=0;
								            $select=$this->Common_Model->db_query("select * from item order by id DESC");
								            foreach ($select as $key => $row) {
								              $sl++;
								            ?>
								    	<option value="<?php echo $row['code']; ?>"><?php echo $row['name']; ?> &nbsp; &nbsp; &nbsp; (<?php echo $row['code']; ?>),&nbsp; &nbsp; &nbsp; <?php echo $row['group']; ?></option>

								    <?php } ?> 
								   
								   </datalist>
			       				</div>
			       			</div>
					        <div class="col-md-4">
					       		<div class="form-group">
					       			<label>QUANTITY</label>
					      			<input type="text" name="qty" class="form-control" value="<?php echo $r1['qty']; ?>" >
					       		</div>
					       	</div>
					        <div class="col-md-4">
						       	<div class="form-group">
							       <label>Unit</label>
							       <input list="unit"  class="form-control" value="<?php echo $r1['unit']; ?>" type="text" name="unit">
							  		<datalist id="unit">
							     	<?php 
							            $sl=0;
							            $select=$this->Common_Model->db_query("select * from unit order by id DESC");
							            foreach ($select as $key => $row) {
							            	
							              $sl++;
							            ?>
							    		<option value="<?php echo $row['name']; ?>"><?php echo $row['name']; ?></option>

							    	<?php } ?></datalist>
						       </div>
					       	</div>
					        <div class="col-md-4">
						       	<div class="form-group">
						       		<label>EXPENSES / UNIT</label>
						      		<input type="text" name="exp_unit" value="<?php echo $r1['exp_unit']; ?>" class="form-control">
						       	</div>
					       	</div>
			       		</div>
			       
			         
			      </div>
			        </div>
			          
			         </form>
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
    $(document).on('change','#item1', function () {
            var code=$(this).val();
            $.ajax({
              type:'POST',
              url:'<?=site_url("quotation/getItemName");?>',
              data:{code1:code},
              cache:false,
              dataType:"JSON",
              success:function(data)
              {
              	//alert(data)
				          $('#name1').html(data.name);
				          $('#des1').html(data.des+'\n'+data.des1+'\n'+data.des2+'\n'+data.des3);
				          $('#price1').html(data.main_mrp);
				          $('#sale1').html(data.main_sale);
				          $('#unt').html('<option value="unit">'+data.unit+' - Main Unit</option><option value="alt_unit">'+data.alt_unit+' - Alt. Unit</option><option value="pack">'+data.pack+' - Pack Unit</option>');
				          $('#rate1').html(data.rate);
				        }
            });

      });
   

  </script>
  	
</body>
</html>