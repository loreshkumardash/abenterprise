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
              <h3 class="box-title">Add Item</h3>
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

      <form method="post" action="<?=site_url("masters/add_item");?>" enctype="multipart/form-data">
        <div class="row">
			    <div class="col-md-12"> 
			          <div class="box" style="background-color: #fbfafa;">  <center><h3 style="border-radius: 5px;color: red; text-decoration: underline;text-decoration-color: #b4ec90;"> General Information</h3></center><br>
             	<div class="row" style="font-size: 14px; color:#928b8b; line-height: 33px">
						  <div class="col-md-6">
						    <div class="row">
							   	<div class="col-md-4" >
							      <span style="font-weight: 600;color: #4c4c4c;font-size: 14px;">ITEM NAME </span>
							    </div>
							    <div class="col-md-8">  
							     <input type="text" name="name" id="name" class="form-control" maxlength="40" required>
							   </div>
						   </div>
						   <div class="row" style="margin-top:5px;">   
							    <div class="col-md-4">
							       <span style="font-weight: 600;color: #4c4c4c;font-size: 14px;">ITEM PRINT NAME</span>
							    </div>
							    <div class="col-md-8">   
							      <input type="text" name="print" id="print" class="form-control" maxlength="40">
							    </div>
						    </div>
						    <div class="row" style="margin-top:5px;">
							    <div class="col-md-4">
							       <span style="font-weight: 600;color: #4c4c4c;font-size: 14px;">ITEM GROUP</span>
							    </div>
							    <div class="col-md-8"> 
							      <select name="group" class="form-control" style="" required>
							        <option value="">--Select--</option>
							        <option value="Asset">Asset</option>
							        <option value="Consumable Materials">Consumable Materials</option>
							        <option value="INTERMEDIATE PRODUCT">INTERMEDIATE PRODUCT</option>
							        <option value="PRODUCTS">PRODUCTS</option>
							        <option value="Raw Materials">Raw Materials</option>
							        <option value="SERVICES">SERVICES</option>
							      </select>
							    </div>
							</div>
							<div class="row" style="margin-top:5px;">
							     <div class="col-md-4" style="margin-top:5px;">
							       <span style="font-weight: 600;color: #4c4c4c;font-size: 14px;">TAX RATE % </span>
							    </div>
							    <div class="col-md-8"> 
							      <select name="rate" class="form-control" style="" required>
							       <option value="">--Select--</option>
							        <option value="5">5%</option>
							        <option value="12">12%</option>
							        <option value="18">18%</option>
							        <option value="28">28%</option>
							        <option value="0">0%</option>
							      </select>
							    </div>
							</div>

						  </div>
						

						  <div class="col-md-6">
						    <div class="row" >
							    <div class="col-md-4">
							       <span style="font-weight: 600;color: #4c4c4c;font-size: 14px;">ITEM PICTURE</span>
							    </div>

							    <div class="col-md-5">
							      <div class="drop-zone" style="border:solid 1px coral;line-height:80px;border-radius:10px;">
							        <span class="drop-zone__prompt">Drop file here or click to upload</span>
							        <input type="file" name="image" id="file6" onchange="return fileValidation6()"  accept=".jpg,.jpeg,.png"  class="drop-zone__input" style="display:none;"> 

							      </div>
							      <!-- <input type="file" name="image" id="file6" onchange="return fileValidation6()"  accept=".jpg,.jpeg,.png"> --> 
							   </div>

							   <div class="col-md-3">
							     <center> Upload Maximum size  1MB.</center>
							   </div>
							</div>
							<div class="row" style="margin-top:10px;">
							    <div class="col-md-4">
							       <span style="font-weight: 600;color: #4c4c4c;font-size: 14px;">HSN / SAC CODE </span>
							    </div>
							    <div class="col-md-8"><input type="number"pattern="[7-9]{1}[0-9]{9}" pattern="/^-?\d+\.?\d*$/" onKeyPress="if(this.value.length==8) return false;" name="hsn" class="form-control"></div>
						   	</div>
						   	<div class="row" style="margin-top:5px;">
						     	<div class="col-md-4">
						       		<span style="font-weight: 600;color: #4c4c4c;font-size: 14px;">Serial No. Wise Details</span>
						    	</div>
							    <div class="col-md-8"> 
							      <select name="serial" id="serial" class="form-control">
							       <option value="">--Select--</option>
							       <option value="Yes">Yes</option>
							        <option value="No">No</option>
							        </select>
							      <div id="Yes"><input type="text" name="sl_no" class="form-control" placeholder="Enter Serial No"></div>
      							<div id="No"></div>
							     </div>
							</div>
				   </div>
				 </div>

				<div class="row">
				     <div class="col-md-3 csed">
						 <span style="font-weight: 600;color: #4c4c4c;font-size: 14px;">ITEM DESCRIPTION - 1 </span>
					     <textarea class="form-control" name="des" maxlength="40" style="" rows="1"></textarea>
				  	</div>
				   	<div class="col-md-3 csed">
						 <span style="font-weight: 600;color: #4c4c4c;font-size: 14px;">ITEM DESCRIPTION - 2 </span>
					     <textarea class="form-control" name="des1" maxlength="40" rows="1"></textarea>
				  	</div>
				   	<div class="col-md-3 csed">
						 <span style="font-weight: 600;color: #4c4c4c;font-size: 14px;">ITEM DESCRIPTION - 3 </span>
					     <textarea class="form-control" name="des2" maxlength="40" rows="1"></textarea>
				  	</div>
				   	<div class="col-md-3 csed">
					 <span style="font-weight: 600;color: #4c4c4c;font-size: 14px;">ITEM DESCRIPTION - 4 </span>
				     <textarea class="form-control" name="des3" maxlength="40" rows="1"></textarea>
				  	</div>
				</div>

				</div>


				<div class="row">
 
					<div class="col-md-12"> 
					   <div class="box" style="background-color: #fbfafa;">  <center><h3 style=" border-radius: 5px;color: red; text-decoration: underline;text-decoration-color: #b4ec90; ">UNIT DETAILS</h3></center><br>
					<div class="row" style="font-size: 14px; color:#928b8b; ">
					 
					  <div class="col-md-1" style="align-self: center;">
					    <span style="font-weight: 600;color: #000;font-size: 14px;">Main Unit</span>
					  </div>
					  <div class="col-md-3">
					     <select name="unit" class="form-control" style="" id="unit" onchange="calcVals()">
					       <option value="">--Select--</option>
					       <?php if($unit){for ($i=0; $i < count($unit); $i++) { ?>
					       		<option value="<?=$unit[$i]['name'];?>"><?=$unit[$i]['name'];?></option>
					       <?php }} ?>
					      
					    </select> 
					  </div>
					   <div class="col-md-1" style="align-self: center;">
					    <span style="font-weight: 600;color: #4c4c4c;font-size: 14px;">Alternate Unit</span>
					  </div>
					  <div class="col-md-3">
					     <select name="alt_unit" class="form-control" id="main"   required style="" onchange="calcVals()" >
					      <option value="">--Select--</option>
					      	<?php if($unit){for ($i=0; $i < count($unit); $i++) { ?>
					       		<option value="<?=$unit[$i]['name'];?>"><?=$unit[$i]['name'];?></option>
					       <?php }} ?>
					    </select>
					  </div>
					   <div class="col-md-1" style="align-self: center;">
					    <span style="font-weight: 600;color: #4c4c4c;font-size: 14px;">Conversion Factor</span>
					  </div>
					    <div class="col-md-3"> 
					      <input list="fact" type="number"  step="any" class="form-control" name="alt_fact">
					      <datalist id="fact" style="overflow-y: auto !important">
					     
					      </datalist>
					    </div>
					</div>
					<br>
					<div class="row">
					 
					 
					  <div class="col-md-1" style="align-self: center;">
					    <span style="font-weight: 600;color: #4c4c4c;font-size: 14px;">Opening Stock(Qty)</span></div>
					  <div class="col-md-3" style="align-self: center;"><input type="number" pattern="[7-9]{1}[0-9]{9}" pattern="/^-?\d+\.?\d*$/" onKeyPress="if(this.value.length==15) return false;"  name="stock" class="form-control" ></div>
					  <div class="col-md-1" style="align-self: center;"><span style="font-weight: 600;color: #4c4c4c;font-size: 14px;">Conversion Type </span></div>
					    <div class="col-md-7" style="align-self: center;"> 
					      <div class="your-class">
					        <input type="radio" name="alt_type" id="totalAmount2">
					        <input type="text"  id="totalAmount" style="margin:0px 20px 0px 12px;width: 38%">  
					        <input type="radio" name="alt_type"  id="totalAmount3" style="margin-left: -10px">
					        <input type="text"  id="totalAmount1" style="margin:0px 0px 0px 12px;width: 39%">
					      </div>
					    </div>

					  </div>
					    <hr>

					    <div class="row">
					      <div class="col-md-1" style="align-self: center;"><span style="font-weight: 600;color: #000;font-size: 14px;">Packaging  Unit </span><br></div>
					      <div class="col-md-3">
					        <select name="pack" class="form-control" id="unit1" style="" onchange="calcValss()" required>
					            <option value="">--Select--</option>
					             <?php if($unit){for ($i=0; $i < count($unit); $i++) { ?>
								       		<option value="<?=$unit[$i]['name'];?>"><?=$unit[$i]['name'];?></option>
								       <?php }} ?>
					        </select>
					      </div>
					     
					      <div class="col-md-1" style="align-self: center;"><span style="font-weight: 600;color: #4c4c4c;font-size: 14px;">Conversion Factor</span></div>
					      <div class="col-md-3 "> 
					            
					         <input type="text" class="form-control" id="fac1" name="pack_con" style=" resize: none !important;padding: 0px 8px !important;" >
					      </div>
					      <div class="col-md-4"></div>
					    </div>

					    <div class="row">
					      <div class="col-md-1" style="align-self: center;"> <br>
					        <span style="font-weight: 600;color: #4c4c4c;font-size: 14px;">Opening Stock(Qty)</span></div>
					      <div class="col-md-3"><br><input type="number" pattern="[7-9]{1}[0-9]{9}" pattern="/^-?\d+\.?\d*$/" onKeyPress="if(this.value.length==15) return false;" name="alt_stock" class="form-control"></div>
					       <div class="col-md-1" style="align-self: center;"><br>
					        <span style="font-weight: 600;color: #4c4c4c;font-size: 14px;">Conversion Type</span></div>
					      <div class="col-md-7" style="align-self: center;"> <br>
					        <div class="your-class">
					            <input type="radio" name="packalt_type" id="totalAmount21" >
					            <input type="text"  id="totalAmount0" style="margin:0px 20px 0px 12px;width: 38%"> 
					            <input type="radio" name="packalt_type"  id="totalAmount31" style="margin-left: -10px">
					            <input type="text"  id="totalAmount11" style="margin:0px 0px 0px 12px;width: 39%">
					        </div>
					      </div>
					    </div>
					 
					    </div>
 
          </div>
        </div>
				</div>

				<div class="col-md-12"> 
              <div class="box" style="background-color: #fbfafa;">  <center><h3 style=" border-radius: 5px;color: red; text-decoration: underline;text-decoration-color: #b4ec90; ">PRICE DETAILS</h3></center><br> 
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
					                    <td><input type="number" class="form-control"  pattern="[0-9]+([\.,][0-9]+)?" step="0.01" onKeyPress="if(this.value.length==15) return false;" name="main_price" style="width: 100%"></td>
					                    <td><input type="number" class="form-control"  pattern="[0-9]+([\.,][0-9]+)?" step="0.01" onKeyPress="if(this.value.length==15) return false;" name="main_sale" style="width:  100%"></td>
					                    <td><input type="number" class="form-control"  pattern="[0-9]+([\.,][0-9]+)?" step="0.01" onKeyPress="if(this.value.length==15) return false;" name="main_mrp" style="width:  100%"></td>
					                  </tr>
					                  <tr>
					                    <td>ALTERNATE UNIT</td>
					                    <td><input type="number" class="form-control"  pattern="[0-9]+([\.,][0-9]+)?" step="0.01" onKeyPress="if(this.value.length==15) return false;" name="alt_price" style="width: 100%"></td>
					                    <td><input type="number" class="form-control"  pattern="[0-9]+([\.,][0-9]+)?" step="0.01" onKeyPress="if(this.value.length==15) return false;" name="alt_sale" style="width: 100%"></td>
					                    <td><input type="number" class="form-control"  pattern="[0-9]+([\.,][0-9]+)?" step="0.01" onKeyPress="if(this.value.length==15) return false;" name="alt_mrp" style="width: 100%"></td>
					                  </tr>
					                  <tr>
					                    <td>PACKAGING UNIT</td>
					                    <td><input type="number" class="form-control"  pattern="[0-9]+([\.,][0-9]+)?" step="0.01" onKeyPress="if(this.value.length==15) return false;" name="pack_price" style="width: 100%"></td>
					                    <td><input type="number" class="form-control"  pattern="[0-9]+([\.,][0-9]+)?" step="0.01" onKeyPress="if(this.value.length==15) return false;" name="pack_sale" style="width: 100%"></td>
					                    <td><input type="number" class="form-control"  pattern="[0-9]+([\.,][0-9]+)?" step="0.01" onKeyPress="if(this.value.length==15) return false;" name="pack_mrp" style="width: 100%"></td>
					                  </tr>
					                </thead>
					                <tbody>
					       
					                  
					                </tbody>
					              </table>
					        </div>
							    <center> <br><input type="submit" name="submitBtn" class="btn btn-info" value="Submit"  style="padding: 8px;line-height: 12px;width: 100px"></center>

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
      

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <?php $this->load->view("common/footer");?>
</div>
<!-- ./wrapper -->

<?php $this->load->view("common/script");?>
		<script>
			document.querySelectorAll(".drop-zone__input").forEach((inputElement) => {
			  const dropZoneElement = inputElement.closest(".drop-zone");

			  dropZoneElement.addEventListener("click", (e) => {
			    inputElement.click();
			  });

			  inputElement.addEventListener("change", (e) => {
			    if (inputElement.files.length) {
			      updateThumbnail(dropZoneElement, inputElement.files[0]);
			    }
			  });

			  dropZoneElement.addEventListener("dragover", (e) => {
			    e.preventDefault();
			    dropZoneElement.classList.add("drop-zone--over");
			  });

			  ["dragleave", "dragend"].forEach((type) => {
			    dropZoneElement.addEventListener(type, (e) => {
			      dropZoneElement.classList.remove("drop-zone--over");
			    });
			  });

			  dropZoneElement.addEventListener("drop", (e) => {
			    e.preventDefault();

			    if (e.dataTransfer.files.length) {
			      inputElement.files = e.dataTransfer.files;
			      updateThumbnail(dropZoneElement, e.dataTransfer.files[0]);
			    }

			    dropZoneElement.classList.remove("drop-zone--over");
			  });
			});

			function updateThumbnail(dropZoneElement, file) {
			  let thumbnailElement = dropZoneElement.querySelector(".drop-zone__thumb");

			  // First time - remove the prompt
			  if (dropZoneElement.querySelector(".drop-zone__prompt")) {
			    dropZoneElement.querySelector(".drop-zone__prompt").remove();
			  }

			  // First time - there is no thumbnail element, so lets create it
			  if (!thumbnailElement) {
			    thumbnailElement = document.createElement("div");
			    thumbnailElement.classList.add("drop-zone__thumb");
			    dropZoneElement.appendChild(thumbnailElement);
			  }

			  thumbnailElement.dataset.label = file.name;

			  // Show thumbnail for image files
			  if (file.type.startsWith("image/")) {
			    const reader = new FileReader();

			    reader.readAsDataURL(file);
			    reader.onload = () => {
			      thumbnailElement.style.backgroundImage = `url('${reader.result}')`;
			    };
			  } else {
			    thumbnailElement.style.backgroundImage = null;
			  }
			}
		</script>
		<script>
		    $(document).ready(function () {
		           //alert('fasdfsdf');
		           $('#main').change(function(){
		            var main=$(this).val();
		            //alert(room_type);
		            $.ajax({
		              type:'POST',
		              url:'ajax.php',
		              data:{main:main},
		              cache:false,
		              success:function(data)
		              {
		          $('#fact').html(data);
		          }
		            })
		      })
		           
		        });
		  </script>
		  <script type="text/javascript">
		    $(document).ready(function () {
		           //alert('fasdfsdf');
		           $('#main1').change(function(){
		            var main1=$(this).val();
		            //alert(room_type);
		            $.ajax({
		              type:'POST',
		              url:'ajax1.php',
		              data:{main1:main1},
		              cache:false,
		              success:function(data)
		              {
		          $('#fac2').html(data);
		        }
		            })
		      })
		        });
		</script>
		<script type="text/javascript">
       function calcVals() {
			  var e = document.getElementById("unit");
			  var f = document.getElementById("main");
			  var selFrst = e.options[e.selectedIndex].value;
			  var selScnd = f.options[f.selectedIndex].value;

			  var totalCal = selFrst +"/" +selScnd;
			   document.getElementById("totalAmount2").value = totalCal;
			  document.getElementById("totalAmount").value = totalCal;
			 
			   var totalCal1 = selScnd +"/" +selFrst;
			   document.getElementById("totalAmount3").value = totalCal1;
			  document.getElementById("totalAmount1").value = totalCal1;
			   
			}
    </script>
		<script type="text/javascript">
       function calcValss() {
				  var e = document.getElementById("unit");
				  var f = document.getElementById("unit1");
				  var selFrst = e.options[e.selectedIndex].value;
				  var selScnd = f.options[f.selectedIndex].value;

				  var totalCal21 = selFrst +"/" +selScnd;
				   document.getElementById("totalAmount21").value = totalCal21;
				  document.getElementById("totalAmount0").value = totalCal21;
				 
				   var totalCal22 = selScnd +"/" +selFrst;
				   document.getElementById("totalAmount31").value = totalCal22;
				  document.getElementById("totalAmount11").value = totalCal22;
				   
				}
  </script>
		<script>
	  	$(document).ready(function(){
	      $('#name').keyup(function(){
	        var name=$('#name').val();
	        //var price2=$('#price2').val();
	        var print=name;
	        $('#print').val(print);
	      });
	    });
    </script>
    <script>
        $(document).ready(function(){
           $('#serial').change(function(){
               // alert('working');
                var md5=$(this).val();
                //alert(md);
                if(md5=='Yes')
                {
                    $('#Yes').show();
                    $('#No').hide();
          
                }
                else if(md5=='No')
                {
                    //$('#No').show();
                    $('#Yes').hide();
          
                }
         
            })
           $('#Yes').hide();
           $('#No').hide();
       
         })
    </script>
</body>
</html>