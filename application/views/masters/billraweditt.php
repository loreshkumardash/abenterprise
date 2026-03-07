<?php $id2=$_GET['id'];
  $select5=$this->Common_Model->db_query("select * from bill_raw where id='$id2'");
$row5=$select5[0];
$username=$row5['alias']; ?>
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
        <small>Bill Raw Edit</small>
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
	              <?php } ?>
			    
			    <div class="tile">
				  	<div class="tile-body">
				 		<center><h3 style="color: #000;padding: 10px;font-size:18px;font-weight: 500 ">RAW MATERIAL CONSUMED</h3></center> 
				 	<form action="" method="post"  enctype="multipart/form-data"> 
				  		<input  type="hidden" name="id" value="<?php echo $row5['id']; ?>">
	         			<input  type="hidden" name="alias" value="<?php echo $row5['alias']; ?>">
				 		<div class="row">
				 			<div class="col-md-4">
				 				<label>Item Name/Code/Group</label>
								<input list="item1"  type="text" name="code" class="form-control" value="<?php echo $row5['code']; ?>">
	                        	<datalist id="item1">

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
				 			<div class="col-md-4">
				 				<div class="form-group">
				 					<label>QUANTITY</label>
									<input type="number" pattern="[7-9]{1}[0-9]{9}" pattern="/^-?\d+\.?\d*$/" onKeyPress="if(this.value.length==10) return false;" name="qty"  onblur="findTotal()" class="form-control" value="<?php echo $row5['qty']; ?>">
				 				</div>
				 			</div>
				  			<div class="col-md-4">
				 				<div class="form-group">
				 					<label>UNIT</label>
									<select class="form-control" type="text" name="unit" >
	          						
						           <?php $itmrec = $this->Common_Model->FetchData("item","*","code='".$row5['code']."'");
                                    $units ='<option value="">--Select--</option>';
                                    if ($itmrec) {
                                      if ($itmrec[0]['unit']) {
                                            $units .= '<option value="unit" '.($row5['unit1']=='unit'?'selected':'').'>'.$itmrec[0]['unit'].' - Main Unit</option>';
                                            }
                                      if ($itmrec[0]['alt_unit']) {
                                      $units .= '<option value="alt_unit" '.($row5['unit1']=='alt_unit'?'selected':'').'>'.$itmrec[0]['alt_unit'].' - Alt. Unit</option>';
                                            }
                                      if ($itmrec[0]['pack']) {
                                        $units .= '<option value="pack" '.($row5['unit1']=='pack'?'selected':'').'>'.$itmrec[0]['pack'].' - Pack. Unit</option>';
                                            }
                                    } ?>
                                    <?=$units;?>
						          	</select>
				 				</div>
				 			</div>
				 		</div>
				 		<div class="row">
				  			<div class="col-md-4"></div>
				  			<div class="col-md-4">
	           					<center> <button type="submit" class="btn btn-default" name="update" title="Add" value="update" style="padding: 2px 5px;font-weight: 500">
	                 			<i class="fa fa-refresh" style="font-size: 15px;color: green"></i> Update
	           					</button>
	         					</center>
	 			  			</div>
				  			<div class="col-md-4"></div>
			 			</div>
				 	</form><br>
				 	<div class="row">
				  		<div class="col-md-12">
				   			<?php
	                    	$select=$this->Common_Model->db_query("select * from bill_raw  where alias='$username' order by id ASC");
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
      									<td><?php echo $row['item']; ?></td>
	          							<td><?php echo $row['code']; ?></td>
	           							<td><?php echo $row['group']; ?></td>
	           							<td><?php echo $row['qty']; ?></td>
	          							<td><?php echo $row['unit']; ?></td>
	          							<td>
											<a href="billraweditt?id=<?php echo $row['id']; ?>" ><i class="fa fa-edit" style="color:green"></i></a>
											&nbsp;&nbsp;
	            							<a href="billrawdeletee?id=<?php echo $row['id']; ?>"><i class="fa fa-close" style="color: red"></i></a></td>
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
				          $('#unt').html('<option value="'+data.unit+'">'+data.unit+'</option>');
				          $('#rate1').html(data.rate);
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