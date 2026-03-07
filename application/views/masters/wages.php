<?php $this->load->view("common/meta");?>
<div class="wrapper">

<?php $this->load->view("common/sidebar");?>

<div class="content-wrapper">
<section class="content-header">
    <h1>
        Master Data
        <small>Wages Head</small>
    </h1>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <?php if(in_array('wagesheadadd', $accessar) || $this->session->userdata('usertype') == 'Admin'){ ?>
        <div class="col-md-4">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Add Wages Head</h3>
                </div>
                <form role="form" action="<?php echo site_url("masters/wages");?>" method="post">
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
                            <label for="wages_name">Wages Head</label>
                            <input type="text" class="form-control" id="wages_name" name="wages_name" placeholder="Enter Wages Head">
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
                    <h3 class="box-title">List Wages Head</h3>
                </div>
                <div class="box-body">
                    <table id="" class="table table-bordered table-condensed table-striped">
                        <tr>
                            <th>ID</th>
                            <th>Wages Head</th>
                            <th>Type</th>
                            <th>Action</th>
                        </tr>
                        <?php if($records){ for($i=0;$i<count($records);$i++){?>
                        <tr>
                            <td><?php echo $records[$i]['wages_id'];?></td>
                            <td><?php echo $records[$i]['wages_name'];?></td>
                            <td><?php echo $records[$i]['deduction'] == '0' ? 'Addition(+)' : 'Deduction(-)';?></td>
                            <?php if(in_array('wagesheaddelete', $accessar) || $this->session->userdata('usertype') == 'Admin'){ ?>
                            <td><a href="<?php echo site_url("masters/deletewages/".$records[$i]['wages_id']);?>" class="btn btn-xs btn-danger" onclick="return confirm('Are you sure to delete this?');">Delete</a></td>
                            <?php }?>
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