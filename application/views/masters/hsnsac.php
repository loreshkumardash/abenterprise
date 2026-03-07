<?php $this->load->view("common/meta");?>
<div class="wrapper">

  <?php $this->load->view("common/sidebar");?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Master Data
        <small>HSN/SAC</small>
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <?php if(in_array('hsnsacadd', $accessar) || $this->session->userdata('usertype') == 'Admin'){ ?>
        <div class="col-md-4">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Add HSN/SAC</h3>
            </div>
            <!-- /.box-header -->
            <form role="form" action="<?php echo site_url("masters/hsnsac/$did");?>" method="post">
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
              <strong>Success !</strong> <?php echo $this->session->flashdata('error');?>
              </div>
              <?php
              }
              ?>
                
                
              <div class="form-group">
                <label for="area_name">HSN/SAC</label>
                <input type="text" class="form-control" id="hsnsac" name="hsnsac" placeholder="Enter HSN/SAC" value="<?php echo isset($rec[0]['hsnsac'])?$rec[0]['hsnsac']:'';?>">
              </div>

              <div class="form-group">
                <label for="short_name">Short Name</label>
                <input type="text" class="form-control" id="short_name" name="short_name" placeholder="Enter Short Name" value="<?php echo isset($rec[0]['short_name'])?$rec[0]['short_name']:'';?>">
              </div>

              <div class="form-group">
                <label for="sgst">SGST %</label>
                <input type="text" class="form-control" id="sgst" name="sgst" placeholder="0.00" step="0.01" value="<?php echo isset($rec[0]['sgst'])?$rec[0]['sgst']:'';?>">
              </div>

              <div class="form-group">
                <label for="cgst">CGST %</label>
                <input type="text" class="form-control" id="cgst" name="cgst" readonly placeholder="0.00" step="0.01" value="<?php echo isset($rec[0]['cgst'])?$rec[0]['cgst']:'';?>">
              </div>

              <div class="form-group">
                <label for="igst">IGST %</label>
                <input type="text" class="form-control" id="igst" name="igst" readonly placeholder="0.00" step="0.01" value="<?php echo isset($rec[0]['igst'])?$rec[0]['igst']:'';?>">
              </div>

              <div class="form-group">
                <label for="type">Type</label>
                <select class="form-control" name="type" id="type">
                  <option value="Goods" <?php echo isset($rec[0]['type']) && $rec[0]['type']=='Goods'?'selected':'';?>>Goods</option>
                  <option value="Service" <?php echo isset($rec[0]['type']) && $rec[0]['type']=='Service'?'selected':'';?>>Service</option>
                </select>
              </div>

              <div class="form-group">
                <label for="uqc_unit">UQC (unit)</label>
                <input type="text" class="form-control" id="uqc_unit" name="uqc_unit" placeholder="Enter UQC" value="<?php echo isset($rec[0]['uqc_unit'])?$rec[0]['uqc_unit']:'';?>">
              </div>

              <div class="form-group">
                <label for="cess">CESS %</label>
                <input type="text" class="form-control" id="cess" name="cess" placeholder="0.00" step="0.01" value="<?php echo isset($rec[0]['cess'])?$rec[0]['cess']:'';?>">
              </div>

            </div>
            <div class="box-footer">
              <button type="submit" name="submitBtn" value="submit" class="btn btn-primary">Submit</button>
            </div>
            </form>
          </div>
        </div>
        <?php }?>
        <div class="col-md-8">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">List HSN/SAC</h3>
              <?php if ($did > 0) { ?>
                <a href="<?php echo site_url("masters/hsnsac");?>" class="btn btn-xs btn-primary float-right">Add New</a>
              <?php } ?>
            </div>
            <div class="box-body">
              <table id="" class="table table-bordered table-condensed table-striped">
                <tr>
                  <th>ID</th>
                  <th>HSN/SAC</th>
                  <th>Short Name</th>
                  <th>SGST %</th>
                  <th>CGST %</th>
                  <th>IGST %</th>
                  <th>Type</th>
                  <th>UQC</th>
                  <th>CESS %</th>
                  <th>Action</th>
                </tr>
                <?php if($hsnsac){ for($i=0;$i<count($hsnsac);$i++){?>
                <tr>
                  <td><?php echo $hsnsac[$i]['hsnsac_id'];?></td>
                  <td><?php echo $hsnsac[$i]['hsnsac'];?></td>
                  <td><?php echo $hsnsac[$i]['short_name'];?></td>
                  <td><?php echo $hsnsac[$i]['sgst'];?></td>
                  <td><?php echo $hsnsac[$i]['cgst'];?></td>
                  <td><?php echo $hsnsac[$i]['igst'];?></td>
                  <td><?php echo $hsnsac[$i]['type'];?></td>
                  <td><?php echo $hsnsac[$i]['uqc_unit'];?></td>
                  <td><?php echo $hsnsac[$i]['cess'];?></td>
                 
                  <td>
                    <?php if(in_array('hsnsacedit', $accessar) || $this->session->userdata('usertype') == 'Admin'){ ?>
                    <a href="<?php echo site_url("masters/hsnsac/".$hsnsac[$i]['hsnsac_id']);?>" class="btn btn-xs btn-warning">Edit</a>
                    <?php }?>
                    <?php if(in_array('hsnsacdelete', $accessar) || $this->session->userdata('usertype') == 'Admin'){ ?>
                    <a href="<?php echo site_url("masters/deletehsnsac/".$hsnsac[$i]['hsnsac_id']);?>" class="btn btn-xs btn-danger" onclick="return confirm('Are you sure to delete this?');">Delete</a>
                    <?php }?>
                  </td>
                </tr>
                <?php }} ?>
              </table>
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
  $(document).ready(function(){

  });
  $(document).on("keyup change","#sgst",function(){
      var sgst = parseFloat($(this).val());
      var cgst = sgst;
      var igst = sgst * 2;
      $("#cgst").val(sgst.toFixed(2));
      $("#igst").val(igst.toFixed(2));
  });
</script>
</body>
</html>