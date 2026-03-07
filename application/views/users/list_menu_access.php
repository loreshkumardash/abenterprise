<?php $this->load->view("common/meta");?>
<div class="wrapper">

<?php $this->load->view("common/sidebar");?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
<h1>
Users
</h1>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">List User Access</h3>
                </div>
            <!-- /.box-header -->

                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12" id="dataTablediv">
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
                            <table id="" class="table table-bordered table-condensed table-striped">
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Action</th>
                                </tr>
                                <?php if($access){ for($i=0;$i<count($access);$i++){?>
                                <tr>
                                    <td><?php echo $access[$i]['access_id'];?></td>
                                    <td>
                                        <?php echo $access[$i]['access_name'];?>
                                    </td>
                                    <td>
                                        <?php if(in_array('menuaccessedit', $accessar) || $this->session->userdata('usertype') == 'Admin'){ ?>
                                        <a href="<?php echo site_url("users/edit_menu_access/".$access[$i]['access_id']);?>" class="btn btn-xs btn-warning">Edit</a>
                                        <?php }?>
                                        <?php if(in_array('menuaccessdelete', $accessar) || $this->session->userdata('usertype') == 'Admin'){ ?>
                                        <a href="<?php echo site_url("users/delete_menu_access/".$access[$i]['access_id']);?>" class="btn btn-xs btn-danger">Delete</a>
                                        <?php }?>
                                    </td>
                                </tr>
                                <?php }} ?>
                            </table>
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

<script type="text/javascript">
function searchForm(){
    $.ajax({
        url:"<?php echo site_url('employee/listemployees_ajax');?>",
        type:"POST",
        data: $("#searchForm").serialize(),
        dataType:"html",
        success: function(data){
            $('#dataTablediv').html(data);
        }
    });
}
$(document).ready(function(){

});
</script>
</body>
</html>