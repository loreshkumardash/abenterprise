<?php $this->load->view("common/meta");?>
<div class="wrapper">

  <?php $this->load->view("common/sidebar");?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Master Data
        <small>Professional Tax Master</small>
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <?php if(in_array('ptmadd', $accessar) || $this->session->userdata('usertype') == 'Admin'){ ?>
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Professional Tax Master</h3>
              <a href="<?=site_url("masters/print_ptslabrate");?>" class="btn btn-sm btn-success float-right" target="_blank">Print Slab Rates</a>
            </div>
            <!-- /.box-header -->
            <form role="form" action="<?php echo site_url("masters/ptm");?>" method="post">
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
                
              <div class="col-md-4"> 
                <div class="form-group">
                  <label for="department_name">State</label>
                  <select class="form-control" name="state_id" id="state_id">
                    <option value="">Select</option>
                    <?php if ($state) { for ($i=0; $i < count($state) ; $i++) { ?> 
                                <option value="<?=$state[$i]['state_id'];?>"><?=$state[$i]['state_title'];?></option>
                              <?php }} ?>
                  </select>
                </div>
              </div> 
             <div class="col-md-12">
              <div class="col-md-9">
              <table class="table table-bordered table-condensed table-striped">
                <thead>
                  <tr>
                    <th width="8%">Sl</th>
                    <th width="42%" colspan="3">Slab Rate</th>
                    
                    <th width="25%">Professional Tax</th>
                    <th width="25%">Action</th>
                  </tr>
                </thead>
                <tbody class="otheritemslist">
                  <tr>
                    <td width="8%">1</td>
                    <td width="15%"><input type="number" step="0.01" class="form-control" name="ratefrom[]" value="0"></td>
                    <td width="25%">
                      <select name="ratetype[]" class="form-control ratetype">
                        <option value="1">To</option>
                        <option value="2">and Above</option>
                      </select>
                    </td>
                    <td width="15%"><input type="number" step="0.01" class="form-control rateto" name="rateto[]" value="0" ></td>
                    <td width="20%"><input type="number" step="0.01" class="form-control" name="proftax[]" value="0"></td>
                    <td width="17%">
                      <a href="javascript:;" class="btnRemoveItm btn btn-xs btn-danger">
                      <i class="fa fa-trash"></i>
                      </a>
                    </td>
                  </tr>
                </tbody>
              </table>
              <a href="javascript:;" class="label label-success btnAddMoreItm pull-right">Add More</a>
              </div>
              </div>

            </div>
            <div class="box-footer">
              <button type="submit" name="submitBtn" value="submit" class="btn btn-primary">Submit</button>
            </div>
            </form>
          </div>
        </div>
        <?php }?>
        
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
  $('.clockpick').clockpicker({
            autoclose:true
        });

  $(document).on('change','#state_id',function(){
      var state_id = $(this).val();
      
         $.ajax({
            url: '<?=site_url("masters/get_stateslab");?>', 
            data: {state_id : state_id},
            dataType:"HTML",
            type:"POST",
            success:function(data){
              $(".otheritemslist").html(data);
            }
          });
       
  });

  $(document).on('change','.ratetype',function(){
    var obj = $(this).closest("tr");
    if ($(this).val() == '2') {
      obj.find('.rateto').attr('readonly','readonly');
      $(".btnAddMoreItm").hide();
    }else{
      obj.find('.rateto').removeAttr('readonly');
    }
  });

  $(".btnAddMoreItm").click(function(e){
    var slot = parseInt($(".otheritemslist tr").length) + 1;
    if (slot > 10) {
        alert("You can't add more than 4 items!");
        return false;
    }
    
    $(".otheritemslist").append('<tr><td width="8%">'+slot+'</td><td width="15%"><input type="number" step="0.01" class="form-control" name="ratefrom[]" value="0"></td><td width="25%"><select name="ratetype[]" class="form-control ratetype"><option value="1">To</option><option value="2">and Above</option></select></td><td width="15%"><input type="number" step="0.01" class="form-control rateto" name="rateto[]" value="0"></td><td width="20%"><input type="number" step="0.01" class="form-control" name="proftax[]" value="0"></td><td width="17%"><a href="javascript:;" class="btnRemoveItm btn btn-xs btn-danger"><i class="fa fa-trash"></i></a></td></tr>');
  });

   $(document).on("click", ".btnRemoveItm", function(e){
    
      $(this).closest('tr').remove();
      calculate();
    
  });
</script>
</body>
</html>