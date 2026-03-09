<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<head>
  <?php $this->load->view('common/meta');?>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<body class="hold-transition skin-blue sidebar-mini">
  <div class="wrapper">

    <?php $this->load->view("common/sidebar"); ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <h1>
          Leads <small>Lead List</small>
        </h1>
        <form class="breadcrumb float-sm-right" style="padding:0;margin:0;">
            <li style="width:200px"><input type="date" name="date" value="<?=$date?>" class="form-control"> </li>
            <li><button type="submit" class="btn btn-primary btn-flat">Submit</button></li>
        </form>
      </section>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="box" style="padding:10px;">
            <div class="box-body"> 
                    <table class="table">
                        <tr>
                            <th>Sl No.</th>
                            <th>Name</th>
                            <th>Gender</th>
                            <th>Date of Birth</th>
                            <th>Purpose</th>
                            <th>Course</th>
                            <th>Email</th>
                            <th>Mobile</th>
                            <th>State</th>
                            <th>City</th> 
                        </tr>
                        <?php if($records){
                            for ($i=0; $i < count($records) ; $i++) { ?>
                            <tr>
                                <td><?= $i+1 ?></td>
                                <td><?=$records[$i]['name']?></td>
                                <td><?=$records[$i]['gender']?></td>
                                <td><?=$records[$i]['dob']?></td>
                                <td><?=$records[$i]['purpose']?></td>
                                <td><?=$records[$i]['course']?></td>
                                <td><?=$records[$i]['email']?></td>
                                <td><?=$records[$i]['mobile']?></td>
                                <td><?=$records[$i]['state']?></td>
                                <td><?=$records[$i]['city']?></td>
                            <tr>
                        <?php }} ?> 
                    </table>


                  <!-- <div class="col-lg-8">
                    <canvas id="dateWiseChart" width="800" height="400"></canvas>
                  </div>
                  <div class="col-lg-4">
                    <canvas id="cancelReasonChart" width="800" height="400"></canvas>
                  </div> -->
                
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
    // Line Chart Data
    const dateWiseData = [
        { date: "2024-11-20", nextFollowUp: 5, campusVisit: 3, confirmAdmission: 2, cancelTotal: 1 },
        { date: "2024-11-21", nextFollowUp: 4, campusVisit: 2, confirmAdmission: 1, cancelTotal: 2 },
        { date: "2024-11-22", nextFollowUp: 6, campusVisit: 4, confirmAdmission: 3, cancelTotal: 0 }
    ];

    // Extract Line Chart Data
    const lineLabels = dateWiseData.map(item => item.date); // Dates
    const nextFollowUps = dateWiseData.map(item => item.nextFollowUp);
    const campusVisits = dateWiseData.map(item => item.campusVisit);
    const confirmAdmissions = dateWiseData.map(item => item.confirmAdmission);
    const cancels = dateWiseData.map(item => item.cancelTotal);

    // Create the Line Chart
    const dateWiseCtx = document.getElementById('dateWiseChart').getContext('2d');
    const dateWiseChart = new Chart(dateWiseCtx, {
        type: 'line',
        data: {
            labels: lineLabels,
            datasets: [
                {
                    label: 'Follow-Up',
                    data: nextFollowUps,
                    borderColor: 'rgba(75, 192, 192, 1)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderWidth: 2
                },
                {
                    label: 'Campus Visit',
                    data: campusVisits,
                    borderColor: 'rgba(153, 102, 255, 1)',
                    backgroundColor: 'rgba(153, 102, 255, 0.2)',
                    borderWidth: 2
                },
                {
                    label: 'Confirm Admission',
                    data: confirmAdmissions,
                    borderColor: 'rgba(255, 206, 86, 1)',
                    backgroundColor: 'rgba(255, 206, 86, 0.2)',
                    borderWidth: 2
                },
                {
                    label: 'Cancel',
                    data: cancels,
                    borderColor: 'rgba(255, 99, 132, 1)',
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderWidth: 2
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'top' },
                title: {
                    display: true,
                    text: 'Date-Wise Report for John Doe'
                }
            },
            scales: {
                x: {
                    title: { display: true, text: 'Date' }
                },
                y: {
                    beginAtZero: true,
                    title: { display: true, text: 'Count' }
                }
            }
        }
    });

    // Pie Chart Data
    const cancelReasons = {
        "Not Interested": 10,
        "Financial Issue": 5,
        "Location Issue": 3,
        "Other": 2
    };

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
    const cancelReasonCtx = document.getElementById('cancelReasonChart').getContext('2d');
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
                    text: 'Cancel Reasons Breakdown'
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

