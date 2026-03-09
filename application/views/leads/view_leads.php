<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php $this->load->view('common/meta'); ?>
    <link rel="stylesheet" href="<?= base_url('assets/bootstrap/css/bootstrap.min.css'); ?>">
    <style>
        .box-custom {
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }
        .box-header-custom {
            background: #001F3F;
            color: #fff;
            padding: 10px 15px;
            border-radius: 5px 5px 0 0;
            font-size: 16px;
            font-weight: bold;
        }
        .form-control[readonly] {
            background-color: #f9f9f9;
        }
        .table-bordered th, .table-bordered td {
            vertical-align: middle !important;
        }
    </style>
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

    <?php $this->load->view("common/sidebar"); ?>

    <div class="content-wrapper">
        <section class="content-header">
            <h1>Leads <small>View Lead Details</small></h1>
            <ol class="breadcrumb">
                <li><a href="<?= site_url('dashboard'); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Leads</li>
            </ol>
        </section>

        <section class="content">
            <div class="row">
                <div class="col-lg-12">
                    <div class="box box-custom">
                        <div class="box-header-custom text-center bg-primary" style="font-size: 20px;">Customer Info</div>
                        <div class="box-body">
                            <?php if (!empty($records)): ?>
                                <?php $lead = $records[0]; ?>
                                <form method="post" action="<?= site_url('lead/view_leads/' . $lead['enq_id']); ?>">
                                    
                                    <!-- Lead Details -->
                                    <div class="box box-custom">
                                        <div class="box-header-custom">Lead Details</div>
                                        <div class="box-body">
                                            <table class="table table-bordered">
                                                <tr>
                                                    <th width="20%">Customer Name</th>
                                                    <td><?= $lead['name']; ?></td>
                                                    <th>Customer Code</th>
                                                    <td><?= $lead['customer_code']; ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Email</th>
                                                    <td><?= $lead['email']; ?></td>
                                                    <th>Mobile</th>
                                                    <td><?= $lead['mobile']; ?></td>
                                                    
                                                </tr>
                                                <tr>
                                                    <th>Alternate Mobile</th>
                                                    <td><?= $lead['amobile']; ?></td>
                                                    <th>Whatsapp No.</th>
                                                    <td><?= $lead['wp_no']; ?></td>
                                                </tr>
                                                <tr>
                                                    <th>State</th>
                                                    <td><?= $lead['state']; ?></td>
                                                    <th>City</th>
                                                    <td><?= $lead['city']; ?></td>
                                                    
                                                </tr>
                                                <tr>
                                                    <th>Gender</th>
                                                    <td><?= $lead['gender']; ?></td>
                                                    <th>Location</th>
                                                    <td><?= $lead['lead_location']; ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Specification</th>
                                                    <td><?= $lead['specification']; ?></td>
                                                    <th>Budget</th>
                                                    <td><?= $lead['budget']; ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Lead Occupation</th>
                                                    <td><?= $lead['occupation']; ?></td>
                                                    <th>Salary(Optional)</th>
                                                    <td><?= $lead['salary']; ?>
                                                        
                                                    </td>
                                                </tr>
                                                 <tr>
                                                    <th>Mode Of Deal</th>
                                                    <td><?= $lead['deal_mode']; ?></td>
                                                    <th>Plan Out Date</th>
                                                    <td><?= $lead['plan_o_date']; ?>
                                                        
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Lead Date</th>
                                                    <td><?= date("d-M-Y", strtotime($lead['enquiry_date'])); ?></td>
                                                    <th>Lead Remark</th>
                                                    <td><?= $lead['le_enquiry_remark']; ?>
                                                        
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Lead Status</th>
                                                    <td><?= $lead['comp_status']; ?></td>
                                                    <th>Reason</th>
                                                    <td><?= $lead['reason']; ?>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Follow Up Status</th>
                                                    <td><?= $lead['f_status']; ?></td>
                                                    <th>Follow Up Notes</th>
                                                    <td><?= $lead['f_notes']; ?>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Lead Message (Website)</th>
                                                     <td><?= $lead['message']; ?></td>
                                                     <th>Lead Source</th>
                                                     <td><?= $lead['lead_source']; ?></td>
                                                 </tr>
                                                 <tr>
                                                    <th>Last Updated By</th>
                                                     <td><?= $lead['emp_firstname'] . ' ' . $lead['emp_lastname']." - [".$lead['emp_user']."]"; ?></td>
                                                     <th>Last Updated At</th>
                                                     <td><?= ($lead['updated_at']) ? date('d-M-Y H:i:s', strtotime($lead['updated_at'])) : 'N/A'; ?></td>
                                                 </tr>
                                            </table>
                                        </div>
                                    </div>

                                    <!-- Assigned Employee & Activity -->
                                    <div class="box box-custom">
                                        <div class="box-header-custom">Assigned Employee & Activity</div>
                                        <div class="box-body">
                                            <table class="table table-bordered">
                                                <tr>
                                                    <th width="20%">Assigned Employee</th>
                                                     <td><?= $lead['employee_firstname'] . ' ' . $lead['employee_lastname']." - [".$lead['emp_usertype']."]"; ?></td>
                                                     <th>Last Call Activity</th>
                                                      <td><?= !empty($lead['activity_date']) ? date('d-m-Y H:i:s', strtotime($lead['activity_date'])) : 'NA'; ?>
                                                          
                                                      </td>


                                                </tr>
                                            </table>
                                        </div>
                                    </div>

                                    <!-- Interest & Not Interested -->
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="box box-custom">
                                                <div class="box-header-custom">
                                                Requirement Info [ Interested Or Not Interested Or Opportunity ]</div>
                                                <div class="box-body">
                                                    <table class="table table-bordered">
                                                        <tr>
                                                            <th>Requirement Type</th>
                                                            <td><?= $lead['require_type']; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Property Name</th>
                                                            <td><?= $lead['property_name']; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Property Type</th>
                                                            <td><?= $lead['prop_type']; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Property Sub Type</th>
                                                            <td><?= $lead['prop_sub_type']; ?></td>
                                                        </tr>
                                                         
                                                        
                                                        <tr>
                                                            <th>Property Location</th>
                                                            <td><?= $lead['interest_location']; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Remarks</th>
                                                            <td><?= $lead['interest_remarks']; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Opportunity Area</th>
                                                            <td><?= $lead['opp_city']." , ".$lead['opp_location']." , ".$lead['opp_locality']; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Other Property Name</th>
                                                            <td><?= $lead['other_prop']; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Reason</th>
                                                            <td><?= $lead['interest_reason']; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Notes</th>
                                                            <td><?= $lead['interest_notes']; ?></td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>

                                        
                                    </div>
                                    
                                   <!-- site visit-->
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="box box-custom">
                                                <div class="box-header-custom">
                                                Site Visit Info </div>
                                                <div class="box-body">
                                                    <table class="table table-bordered">
                                                        <tr>
                                                            <th>Site Visit Date</th>
                                                            
                                                            <td>
                                                                <?= (!empty($lead['site_date']) && $lead['site_date'] != '0000-00-00') 
                                                                    ? date("d-M-Y", strtotime($lead['site_date'])) 
                                                                    : 'NA'; ?>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <th>Time Slot</th>
                                                            <td><?= $lead['site_slot']; ?></td>
                                                        </tr>

                                                        <tr>
                                                            <th>Specific Time (If Any)</th>
                                                            <td>
                                                                <?= (!empty($lead['site_time']) && $lead['site_time'] != '00:00:00') 
                                                                    ? date("h:i A", strtotime($lead['site_time'])) 
                                                                    : 'NA'; ?>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <th>Property Site Interest</th>
                                                            <td><?= $lead['site_interest']; ?></td>
                                                        </tr>

                                                        <tr>
                                                            <th>Specific Requirements (if any)</th>
                                                            <td><?= $lead['site_notes']; ?></td>
                                                        </tr>

                                                        <tr>
                                                            <th>Request Date</th>
                                                            <td>
                                                                <?= (!empty($lead['site_dateadd']) && $lead['site_dateadd'] != '0000-00-00 00:00:00') 
                                                                    ? date("d-M-Y H:i:s", strtotime($lead['site_dateadd'])) 
                                                                    : 'NA'; ?>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <th>Request By</th>
                                                            <td><?= $lead['site_request']; ?></td>
                                                        </tr>
                                                        
                                                    </table>
                                                </div>
                                            </div>
                                        </div>

                                        
                                    </div>

                                    <!-- Callback Details -->
                                    <div class="box box-custom">
                                        <div class="box-header-custom">Callback Details</div>
                                        <div class="box-body">
                                            <table class="table table-bordered">
                                                <tr>
                                                    <th width="20%">Attend Date</th>
                                                     <td><?= !empty($lead['callback_date']) ? date('d-M-Y H:i:s', strtotime($lead['callback_date'])) : 'NA'; ?></td>
                                                    <th>Next Follow-up Date</th>
                                                     <td><?= !empty($lead['callback_next_date']) ? date('d-M-Y H:i:s', strtotime($lead['callback_next_date'])) : 'NA'; ?>
                                                         
                                                     </td>
                                                </tr>
                                                <tr>
                                                    <th>Reason</th>
                                                    <td><?= $lead['callback_reason']; ?></td>
                                                    <th>Notes</th>
                                                    <td><?= $lead['callback_notes']; ?></td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>

                                    <!-- Call Logs -->
                                    <div class="box box-custom">
                                        <div class="box-header-custom">Call Logs</div>
                                        <div class="box-body">
                                            <table class="table table-bordered">
                                                
                                                    <?php if($records){ for ($i=0; $i < count($records) ; $i++) { ?>
                                                  <tr>      
                                                   
                                                    <th width="20%"><?= $records[$i]['activity_date'] ? date("d-m-Y H:i:s", strtotime($records[$i]['activity_date'])) : "--" ; ?> <br> <?=$records[$i]['la_calltype']." => ".$records[$i]['la_calltime'];?></th>

                                                    <td>
                                                       <?php if($records[$i]['attachment']) {?>
                                                            <a href="<?= site_url('uploads/call_records/' . $records[$i]['attachment']); ?>" target="_blank">
                                                                <i class="fa fa-play" style="color: #1e90ff;"> Play</i>
                                                            </a>
                                                        <?php } else {
                                                        echo "no records";  }  ?>
                                                        
                                                    </td>
                                                    </tr>
                                                    <?php  }} ?>
                                                
                                            </table>
                                        </div>
                                    </div>

                                </form>
                            <?php else: ?>
                                <p>No lead data found.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <?php $this->load->view("common/footer"); ?>
</div>

<?php $this->load->view("common/script"); ?>
</body>
</html>
