<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<head>
  <?php $this->load->view('common/meta');?>
<body class="hold-transition skin-blue sidebar-mini">
  <div class="wrapper">

    <?php $this->load->view("common/sidebar"); ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <h1>
          Leads <small>Lead Report</small>
        </h1>
        <form class="breadcrumb" style="padding:0;margin:0;">
            <li style="width:200px"> 
                <select class="form-control" name="leadtype">
                    <option value="Source" <?=$_REQUEST['leadtype']=='Source'?'selected':''?>>Source</option>
                    <option value="Counselor" <?=$_REQUEST['leadtype']=='Counselor'?'selected':''?> >Counselor</option>
                </select> 
            </li>
            <li><button type="submit" class="btn btn-primary btn-flat">Submit</button></li>
        </form>
      </section>

    <!-- Main content -->
    <div class="content">
        <div class="row">
            <div class="col-lg-12">
                <div class="box" style="padding:10px;">
                    <div class="box-body"> 
                    
                    <table class="table">
                        <tr>
                            <th>Sl No.</th>
                            <th>Name</th>
                            <th>Total Lead</th>
                            <th>Success Lead</th>
                            <th>Conversion Rate</th>
                        </tr>
                        <?php if($records){
                            for ($i=0; $i < count($records) ; $i++) { ?>
                            <tr>
                                <td><?= $i+1 ?></td>
                                <td><?=$records[$i]['Name']?></td>
                                <td><?=$records[$i]['total_assigned']?></td>
                                <td><?=$records[$i]['total_success']?></td>
                                <td><?= $records[$i]['total_assigned'] > 0 ? round(($records[$i]['total_success'] / $records[$i]['total_assigned']) * 100, 2) . ' %' : '0 %'; ?>
</td>
                            </tr>
                        <?php }} ?> 
                    </table>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
 </div>
  
  <!-- Main Footer -->
  <?php $this->load->view('common/footer');?>
</div>

<?php $this->load->view('common/script');?>

</body>
</html>

