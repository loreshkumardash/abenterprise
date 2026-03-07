<?php $this->load->view("common/meta");?>
<div class="wrapper">

  <?php $this->load->view("common/sidebar");?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Master Data
        <small>Accessories</small>
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-4">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Minimum Accessories</h3>
            </div>
            <!-- /.box-header -->
            <form role="form" action="<?php echo site_url("masters/class_accessories");?>" method="post">
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
                <label for="class_id">Class</label>
                <select class="form-control" id="class_id" name="class_id">
                  <option value="">select</option>
                  <?php if($classes){ for($i=0;$i<count($classes);$i++){?>
                  <option value="<?php echo $classes[$i]['class_id'];?>"><?php echo $classes[$i]['class_name'];?></option>
                  <?php }}?>
                </select>
              </div>
              <div class="form-group">
                <label for="item_id">Select Accessories</label>
                <select class="form-control" id="item_id" name="item_id">
                  <option value="">select</option>
                  <?php if($items){ for($i=0;$i<count($items);$i++){?>
                  <option value="<?php echo $items[$i]['item_id'];?>"><?php echo $items[$i]['item_name'];?></option>
                  <?php }}?>
                </select>
              </div>
              <div class="form-group">
                <label for="minqty">Item Minimum Quatity</label>
                <input type="number" class="form-control" id="minqty" name="minqty" min="1">
              </div>
            </div>
            <div class="box-footer">
              <button type="submit" name="submitBtn" value="submit" class="btn btn-primary">Submit</button>
              <button type="submit" name="searchBtn" value="search" class="btn btn-success pull-right" formmethod="get">Search</button>
            </div>
            </form>
          </div>
        </div>
        <div class="col-md-8">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Class wise Accessories</h3>
            </div>
            <div class="box-body" id="dataTablediv">
              <table id="" class="table table-bordered table-condensed table-striped">
                <tr>
                  <th>Item Name</th>
                  <th>Class </th>
                  <th>Minimum Qty</th>
                  <th>Is Required?</th>
                  <th>Action</th>
                </tr>
                <?php if($records){ for($i=0;$i<count($records);$i++){?>
                <tr>
                  <td><?php echo $records[$i]['item_name'];?></td>
                  <td><?php echo $records[$i]['class_name'];?></td>
                  <td><?php echo $records[$i]['minqty'];?></td>
                  <td><input type="checkbox" value="<?=$records[$i]['id']?>" class="mark_required" <?=$records[$i]['is_required'] == '1' ? 'checked="checked"' : '';?> /></td>
                  <td>
                    <a href="<?php echo site_url("masters/delete_class_accessories/".$records[$i]['id']);?>" class="btn btn-xs btn-danger" onclick="return confirm('Are you sure to delete this?');">Delete</a>
                  </td>
                </tr>
                <?php }} ?>
              </table>
              <?php if($records){echo $sPages;} ?>
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
  function searchForm(){
    var class_id = $("#class_id").val();
    var item_id = $("#item_id").val();

    $.ajax({
      url: '<?php echo site_url("masters/class_accessories_ajax");?>',
      data: {class_id : class_id, item_id : item_id},
      dataType: "HTML",
      type: "POST",
      success: function(data){
        $("#dataTablediv").html(data);
      }
    });
  }

  $(".mark_required").change(function(e){
    e.preventDefault();
    var v;
    var id = $(this).val();
    if($(this).prop("checked") == true){
      v = 1;
    }
    else if($(this).prop("checked") == false){
      v = 0;
    }
    $.ajax({
      url: '<?php echo site_url("masters/change_class_accessories_req");?>',
      data: {v : v, id : id},
      dataType: "HTML",
      type: "POST",
      success: function(data){
        console.log("Success");
      }
    });
  });
</script>
</body>
</html>
