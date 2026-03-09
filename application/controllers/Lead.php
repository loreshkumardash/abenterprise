<?php   
error_reporting(0);
defined('BASEPATH') OR exit('No direct script access allowed');
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class Lead extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->perPage = 50;  
		is_logged_in(); 
		date_default_timezone_set('Asia/Kolkata');
		$this->timestamp = date('Y-m-d H:i:s');
	}

	public function index()
	{
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$data['per_page'] = $per_page = isset($_REQUEST['per_page']) ? $_REQUEST['per_page'] : 100;
		$data['page'] = $page = isset($_REQUEST['page']) ? $_REQUEST['page'] : '1';
		$this->load->helper('url');
		$currentURL = current_url();
		$sql = "1";
		$queryvars = '';
		
		$data['employee'] = $employee = $this->Common_Model->FetchData("users","*","1 ORDER BY user_id ASC");

		//Retrieve filter inputs
		$emp_id = $this->input->get('assignees');
		$customer_code = $this->input->get('customer_code');
		$mobile = $this->input->get('mobile');
		 $start_date = $this->input->get('start_date');
         $end_date = $this->input->get('end_date');
        $status = $this->input->get('comp_status');
        $location = $this->input->get('location');
        $specification = $this->input->get('specification');
        
        // Apply date filter if set
		 if (!empty($start_date) && !empty($end_date)) {
		   $sql .= " AND DATE(a.enquiry_date) BETWEEN '$start_date' AND '$end_date'";
		   $queryvars .= "&start_date=".$start_date."&end_date=".$end_date;
		 }
		 
		  if(isset($_REQUEST['customer_code']) && $_REQUEST['customer_code'] != ''){
			$sql.= " AND customer_code = '".$_REQUEST['customer_code']."'";
			$queryvars.= "&customer_code=".$_REQUEST['customer_code'];
		}
		
		if(isset($_REQUEST['mobile']) && $_REQUEST['mobile'] != ''){
			$sql.= "  AND mobile = '".trim($_REQUEST['mobile'])."'";
			$queryvars.= "&mobile=".$_REQUEST['mobile'];
		}
		
		if(isset($_REQUEST['status']) && $_REQUEST['status'] != ''){
			$sql.= " AND comp_status = '".$_REQUEST['status']."'";
			$queryvars.= "&status=".$_REQUEST['status'];
		}
		if (!empty($location)) {
            $sql .= " AND location LIKE " . $this->db->escape("%$location%");
            $queryvars .= "&location=" . urlencode($location);
        }
        if (!empty($specification)) {
            $sql .= " AND specification LIKE " . $this->db->escape("%$specification%");
            $queryvars .= "&specification=" . urlencode($specification);
        }
		
		if (!empty($emp_id)) {
        $sql .= " AND user_id = '$emp_id'";
        $queryvars.= "&assignees=".$_REQUEST['assignees'];
    }


		if(isset($_REQUEST['fullname']) && $_REQUEST['fullname'] != ''){
			$sql.= " AND fullname LIKE '%".$_REQUEST['fullname']."%'";
			$queryvars.= "&fullname=".$_REQUEST['fullname'];
		}
		if(isset($_REQUEST['mobile']) && $_REQUEST['mobile'] != ''){
			$sql.= " AND mobile = '".$_REQUEST['mobile']."'";
			$queryvars.= "&mobile=".$_REQUEST['mobile'];
		}
		if(isset($_REQUEST['email']) && $_REQUEST['email'] != ''){
			$sql.= " AND email = '".$_REQUEST['email']."'";
			$queryvars.= "&email=".$_REQUEST['email'];
		}
		
		$sql.= " ORDER BY enq_id DESC";

		$sSql = "SELECT COUNT(*) as num 
         FROM lead_enquiry as a 
         LEFT JOIN users as u ON a.assigned_to = u.user_id 
         WHERE $sql";
		
		$records = $this->Common_Model->db_query($sSql);
		$totalrecords = $records[0]['num'];

		if($totalrecords){
			$sSql = "SELECT a.*, u.firstname as employee_firstname,u.lastname as employee_lastname
         FROM lead_enquiry as a 
         LEFT JOIN users as u ON a.assigned_to = u.user_id 
         WHERE $sql";

			$this->load->library("Paginator");
			$this->paginator->setparam(array("page_num" => $page, "num_rows" => $totalrecords));
			$this->paginator->set_Limit($per_page);
			$range1 = $this->paginator->getRange1();
			$range2 = $this->paginator->getRange2();
			$sSql .= " LIMIT ".$range1.', '.$range2;
			$records = $this->Common_Model->db_query($sSql);
			$queryvars = "per_page=$per_page".$queryvars;
			$paging_info = $this->paginator->DBPagingNav($queryvars, $currentURL);
			$aData['tot_page'] = $paging_info[0];
			$aData['pages'] = $paging_info[1];
			$data['sPages'] = $aData['pages'];
			$data['records'] = $records;
			$data['norecords'] = FALSE;
		}else{
			$data['records'] = 0;
		}

		

        

		$data['users'] = $this->Common_Model->FetchData("users","*","1 ORDER BY user_id");
		$data['mainmenu'] = 'lead';
		$data['submenu'] = 'listlead';
		$this->load->view('leads/list_lead', $data); 
	} 

	function lead_assignee(){ 
		
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));

		$data['employee'] = $employee = $this->Common_Model->FetchData("users","*","1 ORDER BY user_id ASC");
		//print_r($employee);exit;
		$data['records'] = $this->Common_Model->FetchData("lead_enquiry","*","assigned_to <= 0 ORDER BY enq_id DESC");

		if ($this->input->post('submitBtn')) {
        $emp_id = $this->input->post('assignees');
        $selected_leads = $this->input->post('check');
        

        if (!empty($emp_id) && !empty($selected_leads)) {
            $update_success = true;

            foreach ($selected_leads as $enq_id) {
    
                $result = $this->Common_Model->update_records('lead_enquiry',"enq_id",$enq_id,array('assigned_to'=>$emp_id));
                
            }

                $this->session->set_flashdata('success', 'Leads successfully assigned to the employee.');
            
        } else {

            $this->session->set_flashdata('error', 'Please select a employee and at least one lead.');
        }

        redirect('lead/lead_assignee');
    	}

    	if ($this->input->post('deleteBtn')) {
    		$selected_leads = $this->input->post('check');
    		foreach ($selected_leads as $enq_id) {
    
                $result = $this->Common_Model->DelData('lead_enquiry',"enq_id=".$enq_id);
                
            }

                $this->session->set_flashdata('success', 'Leads deleted successfully.');
               redirect($_SERVER['HTTP_REFERER']); 
    	}

		$data['mainmenu'] = 'lead';
		$data['submenu'] = 'lead_assignee';
		$this->load->view('leads/lead_assignee', $data);
	}
	
	public function reassigne() {
	    $data = array();
	    $data['accessar'] = json_decode($this->session->userdata('access_menus'));
	    $data['employee'] = $this->Common_Model->FetchData("users", "*", "1 ORDER BY user_id ASC");

	    if ($this->input->post('reasBtn')) {
	    	//echo"<pre>";print_r($this->input->post('reasBtn'));
	        $emp_id = $this->input->post('reassignes');
	        $selected_leads = $this->input->post('enq_id'); // Get selected leads

	        if (!empty($emp_id) && !empty($selected_leads)) {
	            foreach ($selected_leads as $enq_id) {
	            	// Update both assigned employee and lead status
                $updateData = array(
                    'assigned_to' => $emp_id,
                    're_status' => 1,
                    'comp_status' => 'Initiated'
                );
                 $this->Common_Model->update_records('lead_enquiry', "enq_id", $enq_id, $updateData);
	                
	            }
	            $this->session->set_flashdata('success', 'Leads successfully reassigned.');
	        } else {
	            $this->session->set_flashdata('error', 'Please select an employee and at least one lead.');
	        }

	        redirect('lead');
	    }

	   
	}

	

	public function view_leads($enq_id = 0) { 
    $data = array();
    $data['accessar'] = json_decode($this->session->userdata('access_menus'));

    // Fetch lead details with activity
    $data['records'] = $this->Common_Model->db_query("
		        SELECT 
		   le.enq_id,
		    le.customer_code,
		    le.name,
		    le.email,
		    le.mobile,
		    le.amobile,
		    le.wp_no,
		    le.state,
		    le.city,
		    le.location AS lead_location,
		    le.gender,
		    le.specification,
		    le.budget,
		    le.assigned_to,
		    le.enquiry_remark AS le_enquiry_remark,
		    le.enquiry_status AS le_enquiry_status,
		    le.enquiry_date,
		    le.comp_status,
		    le.reason,le.deal_mode,le.occupation,le.salary,le.plan_o_date,le.message,le.source,le.updated_by,le.updated_at,le.f_status,le.f_notes,

		    la.emp_id,
		    la.enquiry_remark AS la_enquiry_remark,
		    la.attachment,
		    la.call_type AS la_calltype,
		    la.call_duration AS la_calltime,
		    la.enquiry_status AS la_enquiry_status,
		    la.dateadded AS activity_date,

		    cb.user_id AS callback_user,
		    cb.reason AS callback_reason,
		    cb.date_added AS callback_date,
		    cb.next_date AS callback_next_date,
		    cb.notes AS callback_notes,

		    i.user_id AS interest_user,
		    i.require_type,
		    i.prop_type,
		    i.prop_sub_type,
		    i.other_prop,
		    i.location,
		    i.remarks AS interest_remarks,
		    i.locations AS opp_locality,
		    i.city AS opp_city,
		    i.reason AS interest_reason,
		    i.notes AS interest_notes,
            ucl.uc_location AS opp_location,

		    p.prop_name AS property_name,
		    l.location AS interest_location,

		    u.firstname as employee_firstname,u.lastname as employee_lastname,
		    u.usertype as emp_usertype,
		     u2.firstname as emp_firstname,u2.lastname as emp_lastname,u2.usertype as emp_user,
		    es.source AS lead_source,
		    
		    s.visit_date as site_date,
		    s.time_slot as site_slot,
		    s.specific_time as site_time,
		    s.prop_interest as site_interest,
		    s.notes as site_notes,
		    s.dateadded as site_dateadd,
		    s.request_by as site_request

		FROM lead_enquiry le
		LEFT JOIN lead_activity la ON le.enq_id = la.enq_id
		LEFT JOIN callback cb ON le.enq_id = cb.enq_id
		LEFT JOIN interest i ON le.enq_id = i.enq_id
		LEFT JOIN users as u ON le.assigned_to = u.user_id
		LEFT JOIN users as u2 ON le.updated_by = u2.user_id 
		 LEFT JOIN property p ON i.prop_id = p.pid
		 LEFT JOIN location l ON i.location = l.lid
		  LEFT JOIN erp_source es ON es.id = le.source
		  LEFT JOIN uc_location ucl ON i.uc_location = ucl.uc_lid
		  LEFT JOIN site_visit s ON le.enq_id = s.enq_id
		WHERE le.enq_id = $enq_id;
    ");
    
    // echo "<pre>";print_r($data['records']);exit;

    $data['mainmenu'] = 'lead';
    $data['submenu'] = 'listlead';
    $this->load->view('leads/view_leads', $data);
}



	function counselor_activity($emp_id=0){

		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));

		$data['Counselor'] = $this->Common_Model->FetchData("employees","*");

		//print_r($data['Counselor']);exit;
		$cond='1';
		if($_REQUEST['Counselor']){
			$cond= "la.emp_id='".$_REQUEST['Counselor']."'";
		}
		$sql = "SELECT la.*, e.name AS LeadName, e.course,emp.employee_name AS EmpName FROM lead_activity la JOIN lead_enquiry e ON la.enq_id = e.enq_id JOIN employees emp ON la.emp_id = emp.employee_id where $cond ORDER BY dateadded DESC";
		$data['activities'] = $activities =  $this->Common_Model->db_query($sql);
		//print_r($activities);exit;

		$data['mainmenu'] = 'lead';
		$data['submenu'] = 'activity';
		$this->load->view('leads/counselor_activity', $data);
	}
	
	function add_source(){
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		
		if($this->input->post('submitBtn')){
			$this->form_validation->set_rules('source', 'Source', 'trim|required');
			if($this->form_validation->run()){
			    $datalist=array(
			       'source' =>$this->input->post('source'),
			       'refer_by' => $this->input->post('refer_by')
			    );
			    $this->Common_Model->dbinsertid('erp_source',$datalist);
			    $this->session->set_flashdata('success', 'Source Added successfully !!');
				redirect("lead/add_source");
			}
		}
		
        $data['records'] = $this->Common_Model->FetchData("erp_source", "*", "status='1' ORDER BY id");
		$data['mainmenu'] = 'lead';
		$data['submenu'] = 'add_source';
		$this->load->view('leads/add_source', $data);
	}
	
	function deletesource($id){
	     $datalist=array(
    	       'status' =>0,
    	    );
    	    $this->Common_Model->update_records('erp_source','id',$id,$datalist);
    	    $this->session->set_flashdata('success', 'Source deleted successfully !!');
    	    redirect("lead/add_source");
	}
public function add_lead()
{
    $data = [];
    $data['accessar'] = json_decode($this->session->userdata('access_menus'));

    if ($this->input->post('submitBtn')) {

        $this->form_validation->set_rules('source', 'Portfolio', 'required');

        if ($this->form_validation->run()) {

            if (!empty($_FILES['upload_file']['name'])) {

                $file = $_FILES['upload_file']['tmp_name'];
                $extension = pathinfo($_FILES['upload_file']['name'], PATHINFO_EXTENSION);

                if (!in_array($extension, ['xls', 'xlsx'])) {
                    $this->session->set_flashdata('error', 'Only Excel files allowed');
                    redirect("lead/add_lead");
                }

                try {

                    $spreadsheet = IOFactory::load($file);
                    $sheetData = $spreadsheet->getActiveSheet()->toArray();

                    $portfolio_id = $this->input->post('source');

                    $insertData = [];

                    foreach ($sheetData as $index => $row) {

                        if ($index == 0) continue;

                        $insertData[] = [

                            'portfolio_id' => $portfolio_id,

                            'allocation_month' => $row[0] !== '' ? $row[0] : NULL,
                            'portfolio'        => $row[1] !== '' ? $row[1] : NULL,
                            'product'          => $row[2] !== '' ? $row[2] : NULL,
                            'loan_number'      => $row[3] !== '' ? $row[3] : NULL,
                            'customer_name'    => $row[4] !== '' ? $row[4] : NULL,
                            'customer_mobile'  => $row[5] !== '' ? $row[5] : NULL,

                            'od_pos'           => $row[6] !== '' ? $row[6] : NULL,
                            'cycle_dt'         => $row[7] !== '' ? $row[7] : NULL,
                            'emi'              => $row[8] !== '' ? $row[8] : NULL,

                            'bkt_category'     => $row[9] !== '' ? $row[9] : NULL,
                            'bkt'              => $row[10] !== '' ? $row[10] : NULL,
                            'tos'              => $row[11] !== '' ? $row[11] : NULL,
                            'dpd'              => $row[12] !== '' ? $row[12] : NULL,

                            'tenure'           => $row[13] !== '' ? $row[13] : NULL,
                            'tenure_paid'      => $row[14] !== '' ? $row[14] : NULL,

                            'pool_type'        => $row[15] !== '' ? $row[15] : NULL,

                            'tl_name'          => $row[16] !== '' ? $row[16] : NULL,
                            'tc_name'          => $row[17] !== '' ? $row[17] : NULL,
                            'fos_name'         => $row[18] !== '' ? $row[18] : NULL,
                            'fos_number'       => $row[19] !== '' ? $row[19] : NULL,

                            'location'         => $row[20] !== '' ? $row[20] : NULL,
                            'residence_address'=> $row[21] !== '' ? $row[21] : NULL,
                            'residence_zip_code'=> $row[22] !== '' ? $row[22] : NULL,
                            'residence_landline_phone'=> $row[23] !== '' ? $row[23] : NULL,

                            'customer_office_name'=> $row[24] !== '' ? $row[24] : NULL,
                            'office_address'      => $row[25] !== '' ? $row[25] : NULL,
                            'office_zip_code'     => $row[26] !== '' ? $row[26] : NULL,

                            'reference_name'   => $row[27] !== '' ? $row[27] : NULL,
                            'reference_number' => $row[28] !== '' ? $row[28] : NULL,

                            'asset_model'      => $row[29] !== '' ? $row[29] : NULL,
                            'registration_no'  => $row[30] !== '' ? $row[30] : NULL,
                            'engine_no'        => $row[31] !== '' ? $row[31] : NULL,

                            'disbursal_date'   => $row[32] !== '' ? date('Y-m-d', strtotime($row[32])) : NULL,
                            'emi_start_date'   => $row[33] !== '' ? date('Y-m-d', strtotime($row[33])) : NULL,
                            'emi_end_date'     => $row[34] !== '' ? date('Y-m-d', strtotime($row[34])) : NULL,

                            'legal_status'     => $row[35] !== '' ? $row[35] : NULL,
                            'short_code'       => $row[36] !== '' ? $row[36] : NULL,

                            'detail_calling_feedback' => $row[37] !== '' ? $row[37] : NULL,
                            'detail_fos_feedback'     => $row[38] !== '' ? $row[38] : NULL,

                            'ptp_amount'       => $row[39] !== '' ? $row[39] : NULL,
                            'ptp_date'         => $row[40] !== '' ? date('Y-m-d', strtotime($row[40])) : NULL,

                            'paid_amount'      => $row[41] !== '' ? $row[41] : NULL,
                            'paid_date'        => $row[42] !== '' ? date('Y-m-d', strtotime($row[42])) : NULL,

                            'fos_payout_grid'  => $row[43] !== '' ? $row[43] : NULL,
                            'fos_payout_percent'=> $row[44] !== '' ? $row[44] : NULL,
                            'fos_payout_amount'=> $row[45] !== '' ? $row[45] : NULL,

                            'actual_payout_grid'=> $row[46] !== '' ? $row[46] : NULL,
                            'actual_payout_percent'=> $row[47] !== '' ? $row[47] : NULL,
                            'booster_payout'   => $row[48] !== '' ? $row[48] : NULL,

                            'actual_payout_amount'=> $row[49] !== '' ? $row[49] : NULL
                        ];
                    }

                    if (!empty($insertData)) {
                        $this->db->insert_batch('lead_enquiry', $insertData);
                    }

                    $this->session->set_flashdata('success', 'Data imported successfully');
                    redirect("lead/add_lead");

                } catch (Exception $e) {

                    $this->session->set_flashdata('error', $e->getMessage());
                    redirect("lead/add_lead");
                }

            } else {

                $this->session->set_flashdata('error', 'Please upload a file');
                redirect("lead/add_lead");
            }
        }
    }

    $data['records'] = $this->Common_Model->FetchData("portfolio","*","1=1 ORDER BY id");
    $data['mainmenu'] = 'lead';
    $data['submenu'] = 'add_lead';

    $this->load->view('leads/add_lead', $data);
}

	function new_lead(){
		$user_details = $this->session->userdata();
		
		$emp_id = $user_details['user_id'];
		//echo $emp_id;exit;
		$data=array();
		if($this->input->post()){
			$datalist=array(
				'name' => $this->input->post('name'),
	            'customer_code' => $this->input->post('customer_code'),
	            
	            'email' => $this->input->post('email'),
	            'mobile' => $this->input->post('mobile'),

	            'amobile' => $this->input->post('amobile'),
	            'wp_no' => $this->input->post('wp_no') ? $this->input->post('wp_no') : $this->input->post('mobile'),
	            'gender' => $this->input->post('gender'),
	            'state' => $this->input->post('state'),
	            'city' => $this->input->post('city'),
	           'location' => $this->input->post('location'),
	           'specification' => $this->input->post('specification'),
	            'budget' => $this->input->post('budget'),
	            'assigned_to' => $emp_id,
	            'enquiry_date' => date('Y-m-d'),
	            'enquiry_remark'  => $this->input->post('remark'),
	             'source' => $this->input->post('source') 
			);
			
			if($this->session->userdata('usertype')=='Admin'){
			  unset($datalist['assigned_to']);
			}
			
			//print_r($datalist);exit;
			$this->Common_Model->dbinsertid('lead_enquiry',$datalist);
			$this->session->set_flashdata('success',"Lead added successfully");
		}
		$data['source'] = $this->Common_Model->FetchData("erp_source","*","status = '1'");
		$data['mainmenu'] = 'lead';
		$data['submenu'] = 'new_lead';
		$this->load->view('leads/new_lead', $data);
	}
	
	function edit_lead($enq_id) {
        $user_id = $this->session->userdata('user_id'); // Assuming user ID is stored in session
		if($this->input->post()) { 
			$data_list=array(
				'name' => $_REQUEST['name'],       
	            
	            'email' => $_REQUEST['email'],
	            
	            'amobile' => $_REQUEST['amobile'],
	            'wp_no' => $_REQUEST['wp_no'],
	            'gender' => $_REQUEST['gender'],
	            'state' => $_REQUEST['state'],
	            'city' => $_REQUEST['city'],
	           'location' => $_REQUEST['location'],
	           'specification' => $_REQUEST['specification'],
	            'budget' => $_REQUEST['budget'],
	            'enquiry_remark'  => $this->input->post('remark'),
	            'updated_by' => $user_id,
	            'updated_at' => $this->timestamp
	            );

		$this->Common_Model->update_records("lead_enquiry","enq_id",$enq_id,
    		   $data_list); 
    		   $this->session->set_flashdata('success',"Lead Updated successfully");
		redirect($this->input->server('HTTP_REFERER'));
	  } 
	  $data['ulead'] = $this->Common_Model->FetchData("lead_enquiry","*","enq_id= '$enq_id'");

		$data['mainmenu'] = 'lead';
		$data['submenu'] = 'edit_lead';
		$this->load->view('leads/edit_lead', $data);
	}
	
	function delete_lead($enq_id) {
		 
			
		$this->Common_Model->DelData("lead_enquiry","enq_id = '$enq_id'");
		$this->session->set_flashdata('success',"Lead Deleted successfully");
		redirect($this->input->server('HTTP_REFERER'));
		
	  
	}

	function leadreport(){
		$data =array();
		$data['date']=$date=date('Y-m-d');
		if($_REQUEST['date']){
			$data['date']=$date=$_REQUEST['date'];
		}
		$sql="SELECT *,
	       CASE 
	           WHEN DATE(campus_visit_dt) = '$date' THEN 'Campus Visit'
	           WHEN DATE(enquiry_date) = '$date' THEN 'Enquiry'
	           WHEN DATE(adm_confirm_dt) = '$date' THEN 'Admission Confirm'
	           WHEN DATE(cancel_date) = '$date' THEN CONCAT('Cancelled (', cancel_reason, ')')
	           WHEN DATE(followup_date) = '$date' THEN 'Followup'
	           ELSE NULL
	       END AS purpose FROM lead_enquiry WHERE DATE(campus_visit_dt) = '$date'
		   OR DATE(enquiry_date) = '$date'
		   OR DATE(adm_confirm_dt) = '$date'
		   OR DATE(cancel_date) = '$date'
		   OR DATE(followup_date) = '$date'";

		$data['records'] = $this->Common_Model->db_query($sql);

		//echo "<pre>";print_r($data['records']);exit;
		$data['mainmenu'] = 'leads';
		$data['submenu'] = 'leadreport';
		$this->load->view('leads/leadreport', $data);
	}

	function lead_conversion(){
		$data =array();
		

		if($_REQUEST['leadtype']=='Counselor'){
			$sql="SELECT e.employee_name as Name,COUNT(assigned_to) AS total_assigned, SUM(CASE WHEN adm_confirm_dt THEN 1 ELSE 0 END) AS total_success FROM lead_enquiry en join employees as e on en.assigned_to=e.employee_id GROUP BY assigned_to";
		}else{
			$sql="SELECT e.source as Name,COUNT(en.source) AS total_assigned, SUM(CASE WHEN adm_confirm_dt THEN 1 ELSE 0 END) AS total_success FROM lead_enquiry en join erp_source as e on en.source=e.id Where e.status='1' GROUP BY en.source";
		}

		$data['records'] = $this->Common_Model->db_query($sql);

		//echo "<pre>";print_r($data['records']);exit;
		$data['mainmenu'] = 'lead';
		$data['submenu'] = 'leadreport';
		$this->load->view('leads/lead_conversion', $data);
	}

	function leadcancel(){
		$data =array();

		$sql="SELECT e.employee_name as CounselorName,en.* FROM lead_enquiry en join employees as e on en.assigned_to=e.employee_id where enquiry_status='Cancelled' Order BY cancel_date DESC";

		$data['records'] = $this->Common_Model->db_query($sql);

		//echo "<pre>";print_r($data['records']);exit;
		$data['mainmenu'] = 'lead';
		$data['submenu'] = 'leadcancel';
		$this->load->view('leads/leadcancel', $data);
	}

	function leadgraph(){
		$data =array();
		$user_details = $this->session->userdata();
		$emp_id = $user_details['ID'];
		
		$sql="SELECT enquiry_status, COUNT(*) AS status_count FROM enquiry WHERE assigned_to = '$emp_id' GROUP BY enquiry_status";

		$records = $this->Common_Model->db_query($sql);
		$data['total_enquiry']=$this->Common_Model->countRows('lead_enquiry',"assigned_to = '$emp_id'");
		$rec=array();
		if($records){
			for ($i=0; $i < count($records) ; $i++) { 
				$rec[$records[$i]['enquiry_status']]=$records[$i]['status_count'];
			}
		}

		$data['records'] =$rec;
		//echo "<pre>";print_r($rec);exit;
		$data['mainmenu'] = 'leads';
		$data['submenu'] = 'leadgraph';
		$this->load->view('leads/leadgraph', $data);
	}



}