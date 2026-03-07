<?php $this->load->view("common/meta");?>
<div class="wrapper">

  <?php $this->load->view("common/sidebar");?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Master Data
        <small>Config Route</small>
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Route Config</h3>
            </div>
            <!-- /.box-header -->
            <form method="post" class="form-horizontal">
    <!-- Main content -->
              <div class="content">
                <div class="container">
                  <div class="row">
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
                    <div class="col-lg-12">
                      <div class="card">
                        <div class="card-header">
                          <h3 class="card-title">Transport</h3>
                          <a href="<?=site_url('masters/vehicles');?>" class="btn btn-primary btn-xs float-right">Back</a>
                        </div>
                        <div class="card-body p-0">
                          <h5 class="p-4">Route Details</h5>
                          <table class="table table-striped table-bordered table-hover">
                              <thead>
                                  <tr>
                                      <th width="30">Sl#</th>
                                      <th width="30">Select Route *</th>
                                      <th width="20" class="center noPrint">Add/Remove</th>
                                  </tr>
                              </thead>
                              <tbody id="appendTr">
                                  <?php if(!empty($route_data)){
                                          foreach ($route_data as $k => $v) {
                                            $loopCnt = ($k+1);
                                    ?>
                                    <tr class="addTr">
                                      <td><label class="lblSlNo"><?=($loopCnt);?></label></td>
                                      <td>
                                          <select class="form-control route_id" required="" name="route_id[]" id="route_id<?=$loopCnt;?>">
                                            <option value="">-Select-</option>
                                          </select>
                                          <input type="hidden" id="rowid<?=$loopCnt;?>" name="rowid[]" value="<?=$v['route_dtls_id']?>" class="rownum">
                                      </td>
                                      <td class="center"><a href="javascript:void(0);" id="more1" class="btn btn-xs btn-info addMore" title="Add More" <?php if($k != count($route_data)-1){?> style="display: none;"<?php }?>> <i class="fa fa-plus" aria-hidden="true"></i> </a> &nbsp; <a href="javascript:void(0);" class="btn btn-xs btn-danger remove " title="Remove" id="less1"> <i class="fa fa-times" aria-hidden="true"></i> </a></td>
                                  </tr>
                                  
                                  <?php }}else{?>  
                                  <tr class="addTr">
                                      <td><label class="lblSlNo">1</label></td>
                                      <td>
                                        <select class="form-control route_id" required="" name="route_id[]" id="route_id1">
                                          <option value="">-Select-</option>
                                        </select>
                                          <input type="hidden" id="rowid1" name="rowid[]" value="0" class="rownum">
                                      </td>
                                      <td class="center"><a href="javascript:void(0);" id="more1" class="btn btn-xs btn-info addMore" title="Add More"> <i class="fa fa-plus" aria-hidden="true"></i> </a> &nbsp; <a href="javascript:void(0);" class="btn btn-xs btn-danger remove " title="Remove" id="less1"> <i class="fa fa-times" aria-hidden="true"></i> </a></td>
                                  </tr>
                                  <?php }?>
                              </tbody>
                          </table>
                        </div>
                        <div class="card-footer">
                            <div class="row">
                              <div class="col-md-12 text-center">                        
                                  <div class="form-group row">
                                    <div class="col-md-12">
                                      <input type="hidden" name="hdnUserType" id="hdnUserType" value="A">
                                      <button type="submit" name="submitBtn" value="Submit" class="btn btn-sm btn-primary">Submit</button>
                                    </div>
                                  </div>
                                </div>
                            </div>
                        </div>
                      </div>
                    </div>
                    
                  </div>
                  <!-- /.row -->
                </div><!-- /.container-fluid -->
              </div>
    <!-- /.content -->
    </form>
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
      <?php if(!empty($route_data)){
          foreach ($route_data as $y => $z) {
            $sloopCnt = ($y+1);
      ?>
        $('#hdnUserType').val('U');
        loadAllroute('route_id<?=$sloopCnt;?>','<?=$z['route_id']?>');
      <?php }}else{?>                      
        loadAllroute('route_id1',0);
      <?php }?> 
       /******************** add more row ********************/

      var totRow = $('#appendTr tr').length;
      if (totRow == 1)
      $('#less1').hide();
      $(document).on('click', '.addMore', function () {
          var totRowNo = $('#appendTr tr').length;
          if (Number(totRowNo) >= 15)
          {
              alert("Can not add more than 15 rows");
              return false;
          }
          $('.addTr:last').clone(true).appendTo('#appendTr');
          $('.addTr:last').find('.remove').show();
          $('.addTr:last').find('.route_id').val('');
          $('.addTr:last').find('.rownum').val(0);
          $('.addTr:last').find('td:last').html('');
          $('.addTr:last').find('td:last').html('<a href="javascript:void(0);" id="more1" class="btn btn-xs btn-info addMore" title="Add More"> <i class="fa fa-plus" aria-hidden="true"></i> </a> &nbsp; <a href="javascript:void(0);" class="btn btn-xs btn-danger remove " title="Remove" id="less1"> <i class="fa fa-times" aria-hidden="true"></i> </a>');

          $.each($('#appendTr tr'), function (e) {
              var rowNo = Number(e) + 1;
              var onchangeSubj    = "getdupVal(this.value, "+rowNo+");";
              $(this).find('.lblSlNo').text(rowNo);
              $(this).find('.route_id').attr('id', 'route_id' + rowNo);
              $(this).find('.route_id').attr('onchange', onchangeSubj);
              $(this).find('.rownum').attr('id', 'rowid' + rowNo);
              $(this).find('.addMore').attr('id', 'more' + rowNo);
              $(this).find('.remove').attr('id', 'less' + rowNo);
              $('#more' + Number(rowNo - 1)).hide();
              $('#less' + Number(rowNo - 1)).show(); //alert($('#hdnTenderID'+rowNo).val());

          });

      });
  //================== Remove row ===========
      $(document).on('click', '.remove', function () {
          var tableRowId = $(this).attr('id');
          tableRowId = tableRowId.substr(4, 4);

          var hdnId = '';
          $(this).closest('tr').remove();
          var totRowNo = $('#appendTr tr').length;
          $.each($('#appendTr tr'), function (e) {
              var rowNo = Number(e) + 1;
              var onchangeSubj    = "getdupVal(this.value, "+rowNo+");";
              $(this).find('.lblSlNo').text(rowNo);
              $(this).find('.route_id').attr('id', 'route_id' + rowNo);
              $(this).find('.route_id').attr('onchange', onchangeSubj);
              $(this).find('.rownum').attr('id', 'rowid' + rowNo);
              $(this).find('.addMore').attr('id', 'more' + rowNo);
              $(this).find('.remove').attr('id', 'less' + rowNo);
          });
          if (totRowNo == 1)
          {
              $('#more1').show();
              $('#less1').hide();
          }
          else
              $('#more' + totRowNo).show();
      });
  /*End add more*/


  });/// document ready end


function getdupVal(levelId, ctrlId) 
{
    var totRows   = $('.addMore').length;
    var ctr       = 0;

    for(var i = 1; i <= totRows; i++) 
    {
        var selLevel = $('#route_id' + i).val();
        if (levelId == selLevel) 
        {
            ctr++;
        }
    }

    if(ctr > 1) 
    {
        alert('Same Route cannot be added repeatedly');
        $('#route_id' + ctrlId).val('');
        $('#route_id' + ctrlId).focus();
    }
}
</script>
</body>
</html>