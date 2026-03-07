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
              <h3 class="box-title">Edit Bill of Material</h3>
              
              <a href="<?=site_url("masters/billofmaterial");?>" class="btn btn-primary btn-sm" style="float:right;">List All</a>
              
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
					$s1=$this->Common_Model->db_query("select * from bill where id='$id'");
				 	$r1=$s1[0];
				 	$alias2=$r1['alias'];
				 	$id2=$r1['id'];
	              ?>
	            <div class="row">
				    <div class="col-md-12">
				       <div class="tile">
				        <div class="tile-body">
				        <center><h3 style="color: #f32f10 !important;font-weight: 600;text-transform: uppercase;">RAW MATERIAL CONSUMED</h3></center> 
				       <form action="" method="post"  enctype="multipart/form-data"> 



				        <?php 
				        $c_id1 = $this->session->userdata("user_id"); 
				        $s1=$this->Common_Model->db_query("select * from `users` where user_id='$c_id1'");
				          $r2=$s1[0];
				          ?>
				          <input type="hidden" name="c_id" value="<?php echo $c_id1; ?>">
				          <input type="hidden" name="type" value="<?=$this->session->userdata("usertype");?>">
				          <input type="hidden" name="name" value="<?php echo $r2['firstname'].' '.$r2['lastname']; ?>">
				          <input type="hidden" name="mno" value="<?php echo $r2['userphone']; ?>">
				         
				         	<input type="hidden" name="id2"  value="<?php echo $id2; ?>" readonly>
				        	<input type="hidden" name="alias"  value="<?php echo $alias2; ?>" readonly>
				        

				  <?php 
				  $select1=$this->Common_Model->db_query("select * from bill_raw where alias='$alias2' "); 
				  if($select1){ ?> 
				    <input type="hidden" name="display_order" value="1"> 
				  <?php } ?>

				 
				  <?php
				  $tr="select * from bill_raw where alias='$alias2' order by display_order desc limit 1";
				                  $trq=$this->Common_Model->db_query($tr);
				                  $tres=$trq[0];
				                 $id1=$tres['display_order'];
				  if(($id1)>= 1){ ?> 
				    <input type="hidden" name="display_order" value="<?php echo $tres['display_order']+1; ?>">
				  <?php } ?>



				      
				    <div class="table-responsive">
					    <table class="table  table-bordered">
					      <thead>
					        <tr>
					          <th>Item Code/Name/Description</th>
					          <th style="width:130px">Qty.</th>
					          <th style="width: 150px">Unit</th>
					          <!-- <th>Action</th> -->
					          
					        </tr>
					      </thead>
					      <tbody>
					        <tr style="margin: 0px;">
					        <td>
					            <input list="browsers1" type="text" name="code" placeholder="select" class="form-control" id="item1"   >
					            <datalist id="browsers1"  id="item1" style="overflow-y: auto !important">
					            <?php 
					              $select1=$this->Common_Model->db_query("SELECT * FROM  item ");
					              foreach ($select1 as $key => $row1) {
					              	
					              ?>
					               <option value="<?php echo $row1['code']; ?>">
					                <?php echo substr($row1['code'],0,8); ?>&nbsp;&nbsp;
					                <?php echo substr($row1['group'],0,8); ?>&nbsp;&nbsp;&nbsp;
					                <?php echo $row1['name']; ?>
					              </option>
					              <?php } ?>
					            </datalist>

					 
					            <textarea id="name1" class="form-control textarea" style="height: 35px !important;resize: none !important;  margin-top: 5px;font-size: 14px;border-bottom: none; "></textarea>
					            <textarea id="des1" name="des1" class="form-control" style="margin-top: 0px;height: 110px;border-top: none; "></textarea>
					        </td>
					        
					            <td>
					              <input type="number" name="qty" onblur="cal1()" id="qty1" class="form-control cal1" style="max-width:110px ">
					            </td>
					            <td>
					                <select name="unit" id="unt" class="form-control" required>
					                    <option value=""></option>
					                </select>
					                 <div class="form-group">
					                 <label style="color: transparent;">ADD.</label>
					                 <button type="submit" value="add1" class="btn btn-default" name="add1" title="Add" style="padding:2px 5px;font-weight: 500;margin-top:80%;font-size: 18px;">
					                       <i class="fa fa-plus" style="font-size: 18px;color: green;padding:2px 5px;"></i> Add
					                 </button>
					               </div>
					            </td>
					        

					     </tr>
					    </tbody>
				   </table>   
				  </div>
				        
				      
				   <script src="https://code.jquery.com/jquery-3.6.0.min.js"
				        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
				  <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
				      
				       <div class="row">
				        <div class="col-md-12">
				         <?php
				                   
		                    $select=$this->Common_Model->db_query("select * from bill_raw  where alias='$alias2' order by display_order ASC");
		                  		if($select){
				                      ?>
		                      <div class="table-responsive">
		                        <table class="table  table-bordered table-condensed table-striped">
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
				                <tbody class="row_position">
				                  <?php 
						            $sl=0;
							            foreach ($select as $key => $row) {
							              $sl++;
						            ?>
						            <tr id="<?php echo $row['id']?>"   draggable="true" ondragstart="start()"  ondragover="dragover()" style=" table-layout: fixed; width: 100%; border-collapse: collapse; border:1px solid #e7e7e7;">
						              	<td><?php echo $sl; ?></td>
						          		<td><?php echo $row['item']; ?>
						            		<hr style="margin: 0px">
						            		<?php echo $row['des']?>
						          		</td>
						          		<td><?php echo $row['code']; ?></td>
						           		<td><?php echo $row['group']; ?></td>
						         
						           		<td><?php echo $row['qty']; ?></td>
						          		<td><?php echo $row['unit']; ?></td>
						          		<td>
											<a href="<?=site_url("masters/billrawedit");?>?id10=<?php echo $row['id']; ?>&id=<?php echo $id2; ?>" ><i class="fa fa-edit" style="color:green"></i></a>
											&nbsp;&nbsp;
				            				<a href="<?=site_url("masters/billrawdelete");?>?id1=<?php echo $row['id']?>&id=<?php echo $id2; ?>" onclick="return confirm('Are you sure to delete ?');"><i class="fa fa-close" style="color: red"></i></a></td>
				            		</tr>
				          			<?php } ?>
				         
				                </tbody>
				              </table>
				                      </div>
				                    <?php } ?>
				        </div>
				       </div>
				    </div>
				</form>
				</div> 
				        
				
				</div>
		</div> 
				       
				      
				<form action="" method="post" role="form" enctype="multipart/form-data">
				        <input type="hidden" name="id" class="form-control" value="<?php echo $id2; ?>" >  

				       <div class="tile">
				           <center><h3 style="color: #f32f10 !important;font-weight: 600;text-transform: uppercase;"> Update Bill Of Material </h3></center>
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
				       
						<div class="row">
							<div class="col-md-12">
							 	<center> <input type="submit" name="update" class="btn btn-info" value="Update"></center>
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
    $(document).ready(function () {
           $('#item1').change(function(){
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
    });

    $(document).ready(function () {
           $('#party1').change(function(){
            var party1=$(this).val();
            //alert(11)
            $.ajax({
              type:'POST',
              url:'<?=site_url("quotation/getPartyDetails");?>',
              data:{party1:party1},
              cache:false,
              dataType:"JSON",
              success:function(data)
              {
				          $('#organisation_name').val(data.ledger_name);
				          $('#accountcode').val(data.ledger_alias);
				          $('#website').val(data.website);
				          $('#accountgroup').val(data.acount_group);
				          $('#address').val(data.address);
				          $('#countryzipcode').val(data.pincode);
				          $('#cphone').val(data.mobile);
				          $('#cemail').val(data.email);
				          
				        }
            });

      });
    });
  </script>
  <script type="text/javascript">
  		$(document).on('keyup','.cal1',function(){
  			
                  var qty = parseFloat($('#qty1').val());
                  var mrp = parseFloat($('#price1').val()); 
                  var alt_mrp = parseFloat($('#alt_pric1').val()); 
                  var pack_mrp = parseFloat($('#pack_mrp1').val()); 
                  var sale = parseFloat($('#sale1').val()); 
                  var rate = parseFloat($('#rate1').val());
                  var total1 = qty*mrp;
                  var total2 = qty*alt_mrp;
                  var total3 = qty*pack_mrp;
                  var rate_price1 = qty*mrp*rate/100;
                  $('#total1').val(total1.toFixed(2)); 
                  $('#total2').val(total2.toFixed(2)); 
                  $('#total3').val(total3.toFixed(2)); 
                  $('#rate_price1').val(rate_price1.toFixed(2));

                  if (parseInt(mrp) >= parseInt(sale)){
                    }else{
                       //alert("low price");
                       //$('#total1').val('0');
                    }
                 });
  </script>

  <script type="text/javascript">
    $(document).ready(function () {
           $('#cnamee').change(function(){
            var cus1=$(this).val();
            alert(cus1)
            $.ajax({
              type:'POST',
              url:'<?=site_url("quotation/getCustName");?>',
              data:{cus1:cus1},
              cache:false,
              success:function(data)
              {
              	alert(data)
				          $('#cname').html(data);
				        }
            });
      });
        });
    </script>
      
    <script type="text/javascript">
    $(document).ready(function () {
           $('#unt').change(function(){
            var unit1=$(this).val();
            $.ajax({
              type:'POST',
              url:'unit_ajax.php',
              data:{unit1:unit1},
             cache:false,
              success:function(data)
              {
          $('#price1').html(data);
        }
            })
      })
        });
    </script>

    <script type="text/javascript">
		    function findTotal(){
		    var arr = document.getElementsByClassName('amount');
		    var tot=0;
		    for(var i=0;i<arr.length;i++){
		        if(parseFloat(arr[i].value))
		            tot += parseFloat(arr[i].value);
		    }
		    document.getElementById('totalordercost').value = tot;
		}
		  </script>
		   <script type="text/javascript">
		    function findTotal1(){
		    var arr = document.getElementsByClassName('amount1');
		    var tot=0;
		    for(var i=0;i<arr.length;i++){
		        if(parseFloat(arr[i].value))
		            tot += parseFloat(arr[i].value);
		    }
		    document.getElementById('totalordercost1').value = tot;
		}
  </script>
	<script type="text/javascript">
	    $(".row_position").sortable({
	        delay: 150,
	        stop: function() {
	            var selectedData = new Array();
	            $(".row_position>tr").each(function() {
	                selectedData.push($(this).attr("id"));
	            });
	            updateOrder(selectedData);
	        }
	    });

	    function updateOrder(aData) {
	        $.ajax({
	            url: 'ajaxPostbill.php',
	            type: 'POST',
	            data: {
	                allData: aData
	            },
	            success: function() {
	               alert('Update Success');
	            }
	        });
	    }
	</script>
	<script type="text/javascript">
	  var row;

		function start(){  
		  row = event.target; 
		}
		function dragover(){
		  var e = event;
		  e.preventDefault(); 
		  
		  let children= Array.from(e.target.parentNode.parentNode.children);
		  
		  if(children.indexOf(e.target.parentNode)>children.indexOf(row))
		    e.target.parentNode.after(row);
		  else
		    e.target.parentNode.before(row);
		}
	</script>	
</body>
</html>