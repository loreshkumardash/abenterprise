<?php $this->load->view("common/meta");?>
<div class="wrapper">

<?php $this->load->view("common/sidebar");?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
        Cash Book
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Cash Transaction</h3>
                    </div>
                    <div class="box-body">
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
                            <form role="form" action="" method="get" id="searchForm">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="mode">Mode</label>
                                    <select class="form-control " id="mode" name="mode">
                                        <option value="">All</option>
                                        <option value="Credit" <?=isset($_REQUEST['mode']) && $_REQUEST['mode'] == 'Credit' ? 'selected="selected"' : '';?>>Credit</option>
                                        <option value="Debit" <?=isset($_REQUEST['mode']) && $_REQUEST['mode'] == 'Debit' ? 'selected="selected"' : '';?>>Debit</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="datefrom">Create date from</label>
                                    <input type="date" class="form-control" id="datefrom" name="datefrom" value="<?php echo isset($_REQUEST['datefrom']) ? $_REQUEST['datefrom'] : set_value("datefrom");?>">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="dateto">Create date to</label>
                                    <input type="date" class="form-control" id="dateto" name="dateto" value="<?php echo isset($_REQUEST['dateto']) ? $_REQUEST['dateto'] : set_value("dateto");?>">
                                </div>
                            </div>
                            <div class="col-md-4" style="padding-top: 25px;">
                                <button type="submit" name="submitBtn" value="submit" class="btn bg-navy btn-flat">Search</button>
                                <button type="submit" name="downloadBtn" value="submit" class="btn bg-maroon btn-flat" formmethod="post" formaction="<?=site_url("payments/download_cashbook");?>">Download</button>
                            </div>
                            </form>
                        </div>
                        <div class="row">
                            <div class="col-md-4 col-sm-6 col-xs-12">
                                <div class="info-box">
                                    <span class="info-box-icon bg-green"><i class="fa fa-inr"></i></span>

                                    <div class="info-box-content">
                                        <span class="info-box-text">Total Cash Credit</span>
                                        <span class="info-box-number"><?=$totalcredit;?></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-6 col-xs-12">
                                <div class="info-box">
                                    <span class="info-box-icon bg-red"><i class="fa fa-inr"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Total Cash Debit</span>
                                        <span class="info-box-number"><?=$totaldebit;?></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12" id="dataTablediv">
                                <div class="table-responsive mb-0" data-pattern="priority-columns">
                                    <table id="" class="table table-condensed table-small-font table-bordered table-striped">
                                        <tr>
                                            <th>ID</th>
                                            <th>Mode</th>
                                            <th>Date</th>
                                            <th>Amount</th>
                                            <th>From</th>
                                            <th>Remarks</th>
                                            <th>Status</th>
                                            <th>Balance</th>
                                        </tr>
                                        <?php if($records){ for($i=0;$i<count($records);$i++){?>
                                        <tr>
                                            <td><?php echo $records[$i]['id'];?></td>
                                            <td><?php echo $records[$i]['mode'];?></td>
                                            <td><?php echo date("d/m/Y g:i A", strtotime($records[$i]['created_on']));?></td>
                                            <td><?php echo $records[$i]['amount'];?></td>
                                            <td><?php echo $records[$i]['voucher_id'] == 0 ? 'Receipt No: '.$records[$i]['receipt_no'] : 'Voucher No: '.$records[$i]['voucher_no'];?></td>
                                            <td>
                                            <?php echo $records[$i]['remarks'];?>
                                            <?php 
                                            if($records[$i]['voucher_no'] != '' && $records[$i]['cheque_nov'] != ''){
                                            echo '<br/>Cheque No : '.$records[$i]['cheque_nov'].', Bank Name - '.$records[$i]['bank_namev'].', '.$records[$i]['bank_branchv'];
                                            }
                                            if($records[$i]['receipt_no'] != '' && $records[$i]['cheque_nor'] != ''){
                                            echo '<br/>Cheque No : '.$records[$i]['cheque_nor'].', Bank Name - '.$records[$i]['bank_namer'].', '.$records[$i]['bank_branchr'];
                                            }
                                            ?> 
                                            </td>
                                            <th><?php echo $records[$i]['voucher_status'];?></th>
                                            <th><?php echo $records[$i]['cash_balance'];?></th>
                                        </tr>
                                        <?php }} ?>
                                    </table>
                                </div>
                            <?php if($records){echo $sPages;}?>
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
<link href="<?=base_url();?>assets/RWD-Table-Patterns/dist/css/rwd-table.min.css" rel="stylesheet" type="text/css" media="screen">
<script src="<?=base_url();?>assets/RWD-Table-Patterns/dist/js/rwd-table.min.js"></script>
<script type="text/javascript">
    /*$(function () {
        $('.table-responsive').responsiveTable({
            addDisplayAllBtn: false
        });
    });*/
</script>
<script type="text/javascript">

</script>
</body>
</html>