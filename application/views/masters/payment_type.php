<?php $this->load->view("common/meta");?>
<div class="wrapper">

<?php $this->load->view("common/sidebar");?>

<div class="content-wrapper">
<section class="content-header">
    <h1>
        Master Data
        <small>Payment Type</small>
    </h1>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <?php if(in_array('paymenttypeadd', $accessar) || $this->session->userdata('usertype') == 'Admin'){ ?>
        <div class="col-md-4">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Add Payment Type</h3>
                </div>
                <form role="form" action="<?php echo site_url("masters/payment_type/".$pid);?>" method="post">
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
                            <label for="ptype_name">Payment Type</label>
                            <input type="text" class="form-control" id="ptype_name" name="ptype_name" placeholder="Enter Unit Name" value="<?=$rec[0]['ptype_name']?$rec[0]['ptype_name']:'';?>">
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea  class="form-control" id="description" name="description" placeholder="Enter Unit Description" rows="3"><?=$rec[0]['description']?$rec[0]['description']:'';?></textarea>
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
                    <h3 class="box-title">List Payment Type</h3>
                </div>
                <div class="box-body">
                    <table id="" class="table table-bordered table-condensed table-striped">
                        <tr>
                            <th>ID</th>
                            <th>Payment Type</th>
                            <th>Description</th>
                            <th>Action</th>
                        </tr>
                        <?php if($records){ for($i=0;$i<count($records);$i++){?>
                        <tr>
                            <td><?php echo $records[$i]['ptype_id'];?></td>
                            <td><?php echo $records[$i]['ptype_name'];?></td>
                            <td><?php echo $records[$i]['description'];?></td>
                            <td>
                            <?php if(in_array('paymenttypeedit', $accessar) || $this->session->userdata('usertype') == 'Admin'){ ?>
                            <a href="<?php echo site_url("masters/payment_type/".$records[$i]['ptype_id']);?>" class="btn btn-xs btn-warning" >Edit</a>
                            <?php }?>
                            <!-- <?php if(in_array('paymenttypedelete', $accessar) || $this->session->userdata('usertype') == 'Admin'){ ?>
                            <a href="<?php echo site_url("masters/deletepayment_type/".$records[$i]['ptype_id']);?>" class="btn btn-xs btn-danger" onclick="return confirm('Are you sure to delete this?');">Delete</a>
                            <?php }?> -->
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