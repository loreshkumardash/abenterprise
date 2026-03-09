<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<head>
  <?php $this->load->view('common/meta');?>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<div class="wrapper">

  <!-- Navbar -->

  <!-- /.navbar -->
  <?php $this->load->view('common/sidebar');?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark"> Leads</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?=site_url('dashboard');?>">Home</a></li>
                        <li class="breadcrumb-item"><a href="#">Leads</a></li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container">
            <div class="card" style="padding:10px">
                <div class="card-header">
                    <h3 class="card-title">Lead Graph Report</h3>
                </div>
                 
                  <div class="col-md-6">
                    <canvas id="Chart" width="400" height="400"></canvas>
                  </div>
                
            </div>
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  
  <!-- Main Footer -->
  <?php $this->load->view('common/footer');?>
</div>

<?php $this->load->view('common/script');?>


<script type="text/javascript">
    // Pie Chart Data
    const cancelReasons = <?= json_encode($records) ?>;
    // Extract Pie Chart Data
    const pieLabels = Object.keys(cancelReasons); // Cancel reason names
    const pieData = Object.values(cancelReasons); // Counts for each reason
    const pieBackgroundColors = [
        'rgba(255, 99, 132, 0.6)', // Red
        'rgba(54, 162, 235, 0.6)', // Blue
        'rgba(255, 206, 86, 0.6)', // Yellow
        'rgba(75, 192, 192, 0.6)'  // Green
    ];

    // Create the Pie Chart
    const cancelReasonCtx = document.getElementById('Chart').getContext('2d');
    const cancelReasonChart = new Chart(cancelReasonCtx, {
        type: 'pie',
        data: {
            labels: pieLabels,
            datasets: [{
                data: pieData,
                backgroundColor: pieBackgroundColors,
                borderColor: pieBackgroundColors.map(color => color.replace('0.6', '1')), // Darker border
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'top' },
                title: {
                    display: true,
                    text: 'Leads'
                },
                tooltip: {
                    callbacks: {
                        label: (tooltipItem) => {
                            const reason = tooltipItem.label;
                            const value = tooltipItem.raw;
                            const total = pieData.reduce((sum, val) => sum + val, 0);
                            const percentage = ((value / total) * 100).toFixed(2);
                            return `${reason}: ${value} (${percentage}%)`;
                        }
                    }
                }
            }
        }
    });

</script>
    
</body>
</html>

