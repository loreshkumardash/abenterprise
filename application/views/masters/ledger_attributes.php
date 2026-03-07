<?php $this->load->view("common/meta");?>
<div class="wrapper">

<?php $this->load->view("common/sidebar");?>

<div class="content-wrapper">
<section class="content-header">
    <h1>
        Master Data
        <small>Attribute</small>
    </h1>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <?php if(in_array('ledgerattributesadd', $accessar) || $this->session->userdata('usertype') == 'Admin' || $this->session->userdata('usertype') == 'Accounts'){ ?>
        <div class="col-md-4">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Add Attributes</h3>
                </div>
                <form role="form" action="<?php echo site_url("masters/ledger_attributes?ledger_id=".$ledger_id."&did=".$did);?>" method="post">
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
                            <label for="attribute_name">Attribute Name</label>
                            <input type="text" class="form-control" id="attribute_name" name="attribute_name" placeholder="Enter Attribute Name" value="<?=$rec[0]['attribute_name']?$rec[0]['attribute_name']:'';?>">
                        </div>
                        <div class="form-group">
                            <label for="quantity">Quantity</label>
                            <input type="number" class="form-control" id="quantity" name="quantity" value="<?=$rec[0]['quantity']?$rec[0]['quantity']:'0';?>" step="0.01" >
                        </div>
                        <div class="form-group">
                            <label for="hsnsac_id">HSN/SAC Code</label>
                            <select class="form-control" id="hsnsac_id" name="hsnsac_id" >
                                <option value="">Select HSN/SAC</option>
                                <?php if ($hsnsac) {for ($i=0; $i < count($hsnsac); $i++) { ?>
                                     <option value="<?=$hsnsac[$i]['hsnsac_id'];?>" <?=$rec[0]['hsnsac_id'] && $rec[0]['hsnsac_id']==$hsnsac[$i]['hsnsac_id']?'selected':'';?>><?=$hsnsac[$i]['hsnsac'];?></option>
                                <?php }} ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="per_day">Per Day</label>
                            <input type="number" class="form-control" id="per_day" name="per_day" value="<?=$rec[0]['per_day']?$rec[0]['per_day']:'0.00';?>" step="0.01" <?=$ledger[0]['payment_type']=='1'?'':'readonly'; ?>>
                        </div>
                        <div class="form-group">
                            <label for="per_month">Per Month</label>
                            <input type="number" class="form-control" id="per_month" name="per_month" value="<?=$rec[0]['per_month']?$rec[0]['per_month']:'0.00';?>" step="0.01" <?=$ledger[0]['payment_type']=='2'?'':'readonly'; ?>>
                        </div>
                        <label>Wages Days ( If month days is )</label>
                        <div class="row">
                            <div class="col-md-3 col-sm-3 col-xs-3 text-center">31 <br>
                                <select name="thirty_one" id="thirty_one">
                                    <?php for ($i=0; $i <= 31; $i++) { ?>
                                        <option value="<?=$i;?>" <?=$rec[0]['thirty_one'] && $rec[0]['thirty_one']==$i?'selected':'';?>><?=$i;?></option>
                                   <?php  } ?>
      
                                </select>
                            </div>
                            <div class="col-md-3 col-sm-3 col-xs-3 text-center">30 <br>
                                <select name="thirty" id="thirty">
                                    <?php for ($i=0; $i <= 30; $i++) { ?>
                                        <option value="<?=$i;?>" <?=$rec[0]['thirty'] && $rec[0]['thirty']==$i?'selected':'';?>><?=$i;?></option>
                                   <?php  } ?>
      
                                </select>
                            </div>
                            <div class="col-md-3 col-sm-3 col-xs-3 text-center">29 <br>
                                <select name="twenty_nine" id="twenty_nine">
                                    <?php for ($i=0; $i <= 29; $i++) { ?>
                                        <option value="<?=$i;?>" <?=$rec[0]['twenty_nine'] && $rec[0]['twenty_nine']==$i?'selected':'';?>><?=$i;?></option>
                                   <?php  } ?>
      
                                </select>
                            </div>
                            <div class="col-md-3 col-sm-3 col-xs-3 text-center">28 <br>
                                <select name="twenty_eight" id="twenty_eight">
                                    <?php for ($i=0; $i <= 28; $i++) { ?>
                                        <option value="<?=$i;?>" <?=$rec[0]['twenty_eight'] && $rec[0]['twenty_eight']==$i?'selected':'';?>><?=$i;?></option>
                                   <?php  } ?>
                                        
                                        
                                </select>
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
        <div class="col-md-8">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">List Attributes</h3>
                </div>
                <div class="box-body">
                    <table id="" class="table table-bordered table-condensed table-striped">
                        <tr>
                            <th width="5%">#Sl</th>
                            <th width="30%">Attribute Name</th>
                            <th width="10%">Quantity</th>
                            <th width="10%">HSN/SAC</th>
                            <th width="15%" class="text-center">Per Day</th>
                            <th width="15%" class="text-center">Per Month</th>
                            <th width="15%" class="text-center">Action</th>
                        </tr>
                        <?php if($records){ for($i=0;$i<count($records);$i++){?>
                        <tr>
                            <td><?php echo $i+1;?></td>
                            <td><?php echo $records[$i]['attribute_name'];?></td>
                            <td class="text-center"><?php echo $records[$i]['quantity'];?></td>
                            <td class="text-center"><?php echo $records[$i]['hsnsac'];?></td>
                            <td class="text-right"><?php echo $records[$i]['per_day'];?></td>
                            <td class="text-right"><?php echo $records[$i]['per_month'];?></td>
                            <td class="text-center">
                            <?php if(in_array('ledgerattributeedit', $accessar) || $this->session->userdata('usertype') == 'Admin' || $this->session->userdata('usertype') == 'Accounts'){ ?>
                            <a href="<?php echo site_url("masters/ledger_attributes?ledger_id=".$ledger_id."&did=".$records[$i]['attribute_id']);?>" class="btn btn-xs btn-warning" >Edit</a>
                            <?php }?>
                            <?php if(in_array('ledgerattributedelete', $accessar) || $this->session->userdata('usertype') == 'Admin' || $this->session->userdata('usertype') == 'Accounts'){ ?>
                            <a href="<?php echo site_url("masters/deleteledger_attributes/".$records[$i]['attribute_id']);?>" class="btn btn-xs btn-danger" onclick="return confirm('Are you sure to delete this?');">Delete</a>
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
        $('.clockpick').clockpicker({
            autoclose:true
        });
    </script>
</body>
</html>