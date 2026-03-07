<?php $this->load->view("common/meta");?>
<div class="wrapper">

  <?php $this->load->view("common/sidebar");?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Collection Report
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <?php
          if($this->session->flashdata('success')){
          ?>
          <div class="alert alert-dismissable alert-success">
          <button type="button" class="close" data-dismiss="alert">&times;</button>
          <strong>Success !</strong> <?php echo $this->session->flashdata('success');?>
          </div>
          <?php
          }
          if($this->session->flashdata('saveandprint')){
            ?>
          <script type="text/javascript">
            window.open('<?php echo site_url("payments/print_voucher/".$this->session->flashdata('saveandprint'))?>','winname','directories=no,titlebar=no,toolbar=no,location=no,status=no,menubar=no,scrollbars=no,resizable=no,width=900,height=650');
          </script>
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
        </div>
        <form role="form" action="" method="get">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Search</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">              
              <div class="row">
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="created_on_from">Receipt Date From</label>
                    <input type="date" class="form-control input-sm"  id="created_on_from" name="created_on_from"  value="">
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="created_on_to">Receipt Date To</label>
                    <input type="date" class="form-control input-sm"  id="created_on_to" name="created_on_to"  value="">
                  </div>
                </div>
                <div class="col-md-2" style="padding-top: 25px;">
                  <button type="submit" name="submitBtn" value="submit" class="btn btn-primary">Search</button>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Collection Summary Report </h3>
            </div>
            <!-- /.box-header -->
            
            <div class="box-body">
              <?php if($emparr){ $coltotal = 0; $exptotal = 0; ?>
              <table class="table table-condensed table-bordered table-stripped">
                <tr>
                  <th style="text-align:center;">User</th>
                  <th style="text-align:center;">Cash Collection</th>
                  <th style="text-align:center;">Cheque Collection</th>
                  <th style="text-align:center;">Online Collection</th>
                  <th style="text-align:center;">Total Collection</th>
                  <th style="text-align:center;">Cash Expense</th>
                  <th style="text-align:center;">Cheque Expense</th>
                  <th style="text-align:center;">Online Expense</th>
                  <th style="text-align:center;">Bank Deposite</th>
                  <th style="text-align:center;">Total Expense</th>
                  <th style="text-align:center;">Balance</th>
                </tr>
                <?php foreach ($emparr as $key => $value) {?>
                <tr>
                  <th><?=$value;?></th>
                  <td align="center"><?=array_key_exists($key, $colarr) ? $colarr[$key]['cashcol'] : '0';?></td>
                  <td align="center"><?=array_key_exists($key, $colarr) ? $colarr[$key]['chequecol'] : '0';?></td>
                  <td align="center"><?=array_key_exists($key, $colarr) ? $colarr[$key]['netcol'] : '0';?></td>
                  <td align="center"><?=array_key_exists($key, $colarr) ? $colarr[$key]['stotal'] : '0';?></td>
                  <td align="center"><?=array_key_exists($key, $exparr) ? $exparr[$key]['cashcol'] : '0';?></td>
                  <td align="center"><?=array_key_exists($key, $exparr) ? $exparr[$key]['chequecol'] : '0';?></td>
                  <td align="center"><?=array_key_exists($key, $exparr) ? $exparr[$key]['netcol'] : '0';?></td>
                  <td align="center"><?=array_key_exists($key, $exparr) ? $exparr[$key]['bankdp'] : '0';?></td>
                  <td align="center"><?=array_key_exists($key, $exparr) ? $exparr[$key]['stotal'] : '0';?></td>
                  <td align="center">
                    <?php
                    $x = array_key_exists($key, $colarr) ? $colarr[$key]['stotal'] : '0';
                    $coltotal = $coltotal + (float)$x;
                    $y = array_key_exists($key, $exparr) ? $exparr[$key]['stotal'] : '0';
                    $exptotal = $exptotal + (float)$y;
                    //if($x > $y){
                      echo $x - $y;
                    //}else{
                      //echo 0;
                    //}
                    ?>
                  </td>
                </tr>
                <?php } ?>
                </tr>
              </table>
              <?php  } ?>
              
            </div>
          </div>
        </div>
        </form>
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <?php $this->load->view("common/footer");?>
</div>
<?php $this->load->view("common/script");?>
<script type="text/javascript">
  
</script>
</body>
</html>