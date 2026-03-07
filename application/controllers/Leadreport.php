<?php 
error_reporting(0);
defined('BASEPATH') OR exit('No direct script access allowed');
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


class Leadreport extends CI_Controller {

	public function __construct(){
		parent::__construct();
		is_logged_in();
		date_default_timezone_set("Asia/Kolkata"); 
		$this->present_date 		= date('Y-m-d');
		$this->present_time 		= date('H:i:a');
		$this->timestamp 		= date('Y-m-d H:i:s'); 
	}
	
    public function leadinterest() {
        $data = array();
        $data['accessar'] = json_decode($this->session->userdata('access_menus'));
        $data['per_page'] = $per_page = $this->input->get('per_page') ?? 50;
        $data['page'] = $page = $this->input->get('page') ?? 1;

        $this->load->helper('url');
        $currentURL = current_url();
        $queryvars = "";
        $cond = "i.remarks = 'interested'"; // Base condition

        // Fetch Employees
        $data['employee'] = $this->Common_Model->FetchData("users", "*");
        
        $data['locate'] = $this->Common_Model->FetchData("location", "*");

        // Fetch Available Properties
        $data['property'] = $this->Common_Model->FetchData("property", "*", "avail_status = 'available'", "", "pid DESC");

        // Retrieve filter inputs
        $emp_id = $this->input->get('assignees');
        $prop_id = $this->input->get('properties');
        $mobile = $this->input->get('mobile');
        $specification = $this->input->get('specification');
        $location = $this->input->get('location');

        // Apply employee filter if set
        if (!empty($emp_id)) {
            $cond .= " AND u.user_id = " . $this->db->escape($emp_id);
            $queryvars .= "&assignees=" . urlencode($emp_id);
        }
        if(isset($_REQUEST['mobile']) && $_REQUEST['mobile'] != ''){
            $cond .= "  AND mobile = '".trim($_REQUEST['mobile'])."'";
            $queryvars .= "&mobile=".$_REQUEST['mobile'];
        }

        // Apply property filter if set
        if (!empty($prop_id)) {
            $cond .= " AND p.pid = " . $this->db->escape($prop_id);
            $queryvars .= "&properties=" . urlencode($prop_id);
        }
        if (!empty($specification)) {
            $cond .= " AND i.prop_type LIKE " . $this->db->escape("%$specification%");
            $queryvars .= "&specification=" . urlencode($specification);
        }
        if (!empty($location)) {
            $cond .= " AND i.location LIKE " . $this->db->escape("%$location%");
            $queryvars .= "&location=" . urlencode($location);
        }

        if ($this->session->userdata('usertype') == "Employee") {
            $user_id = $this->session->userdata('user_id');
            $cond .= " AND u.user_id = " . $this->db->escape($user_id);
        }

        // Count total records
        $countSql = "SELECT COUNT(*) as num 
                     FROM interest i 
                     LEFT JOIN users u ON i.user_id = u.user_id 
                     LEFT JOIN lead_enquiry le ON i.enq_id = le.enq_id 
                     LEFT JOIN property p ON i.prop_id = p.pid
                     WHERE $cond";

        $records = $this->Common_Model->db_query($countSql);
        $totalrecords = $records[0]['num'] ?? 0;

        if ($totalrecords > 0) {
            $this->load->library("Paginator");
            $this->paginator->setparam(["page_num" => $page, "num_rows" => $totalrecords]);
            $this->paginator->set_Limit($per_page);
            $range1 = $this->paginator->getRange1();
            $range2 = $per_page; // Fix for LIMIT

            // Retrieve paginated data
            $sSql = "SELECT
                        i.id, 
                        --i.require_type, 
                        i.prop_type, 
                        i.prop_sub_type, 
                        --i.prop_stage, 
                        i.location, 
                        i.remarks, 
                        i.notes,
                        i.dateadded, 
                        u.firstname, 
                        u.lastname, 
                        le.name AS customer_name,
                        le.mobile AS customer_mobile,
                        le.customer_code AS cust_code,
                        le.enquiry_remark AS lead_remark,
                        p.prop_name AS property_name,
                        l.location AS interest_location
                     FROM interest i 
                     LEFT JOIN users u ON i.user_id = u.user_id 
                     LEFT JOIN lead_enquiry le ON i.enq_id = le.enq_id 
                     LEFT JOIN property p ON i.prop_id = p.pid
                     LEFT JOIN location l ON i.location = l.lid
                     WHERE $cond 
                     ORDER BY i.id DESC
                     LIMIT $range1, $range2";

            $records = $this->Common_Model->db_query($sSql);

            // Setup pagination
            $queryvars = "per_page=$per_page" . $queryvars;
            $paging_info = $this->paginator->DBPagingNav($queryvars, $currentURL, $totalrecords, $per_page);
            $aData['tot_page'] = $paging_info[0];
            $aData['pages'] = $paging_info[1];
            $data['sPages'] = $aData['pages'];
            $data['record'] = $records;
            $data['norecords'] = false;
        } else {
            $data['record'] = [];
            $data['norecords'] = true;
        }

        // View parameters
        $data['activemenu'] = 'leadreport';
        $data['activesubmenu'] = 'leadinterest';
        $this->load->view('leadreport/leadinterest', $data);
    }



  public function leadnotinterest() {
        $data = array();
        $data['accessar'] = json_decode($this->session->userdata('access_menus'));
        $data['per_page'] = $per_page = $this->input->get('per_page') ?? 100;
        $data['page'] = $page = $this->input->get('page') ?? 1;

        $this->load->helper('url');
        $currentURL = current_url();
        $queryvars = "";
        $cond = "i.remarks = 'not interested'"; // Base condition

        $data['employee'] = $this->Common_Model->FetchData("users", "*");

        // Retrieve filter inputs
        $emp_id = $this->input->get('assignees');
        $mobile = $this->input->get('mobile');

        // Apply employee filter if set
        if (!empty($emp_id)) {
            $cond .= " AND u.user_id = " . $this->db->escape($emp_id);
            $queryvars .= "&assignees=" . urlencode($emp_id);
        }
        if(isset($_REQUEST['mobile']) && $_REQUEST['mobile'] != ''){
            $cond .= "  AND mobile = '".trim($_REQUEST['mobile'])."'";
            $queryvars .= "&mobile=".$_REQUEST['mobile'];
        }
        
        if ($this->session->userdata('usertype') == "Employee") {
            $user_id = $this->session->userdata('user_id');
            $cond .= " AND u.user_id = " . $this->db->escape($user_id);
        }

        // Count total records
        $countSql = "SELECT COUNT(*) as num 
                     FROM interest i 
                     LEFT JOIN users u ON i.user_id = u.user_id 
                     LEFT JOIN lead_enquiry le ON i.enq_id = le.enq_id 
                     WHERE $cond";

        $records = $this->Common_Model->db_query($countSql);
        $totalrecords = $records[0]['num'] ?? 0;

        if ($totalrecords > 0) {
            $this->load->library("Paginator");
            $this->paginator->setparam(["page_num" => $page, "num_rows" => $totalrecords]);
            $this->paginator->set_Limit($per_page);
            $range1 = $this->paginator->getRange1();
            $range2 = $per_page; // Fix for LIMIT

            // Retrieve paginated data
            $sSql = "SELECT 
                        i.id,
                        i.remarks, 
                        i.reason, 
                        i.notes,
                        i.dateadded,
                        u.firstname, 
                        u.lastname, 
                        le.name AS customer_name,
                        le.mobile AS customer_mobile,
                        le.customer_code AS cust_code
                     FROM interest i 
                     LEFT JOIN users u ON i.user_id = u.user_id 
                     LEFT JOIN lead_enquiry le ON i.enq_id = le.enq_id 
                     WHERE $cond 
                     ORDER BY i.id DESC
                     LIMIT $range1, $range2";

            $records = $this->Common_Model->db_query($sSql);

            // Setup pagination
            $queryvars = "per_page=$per_page" . $queryvars;
            $paging_info = $this->paginator->DBPagingNav($queryvars, $currentURL, $totalrecords, $per_page);
            $aData['tot_page'] = $paging_info[0];
            $aData['pages'] = $paging_info[1];
            $data['sPages'] = $aData['pages'];
            $data['record'] = $records;
            $data['norecords'] = false;
        } else {
            $data['record'] = [];
            $data['norecords'] = true;
        }

        // View parameters
        $data['activemenu'] = 'leadreport';
        $data['activesubmenu'] = 'leadnotinterest';
        $this->load->view('leadreport/leadnotinterest', $data);
    }



	public function callback() {
        $data = array();
        $data['accessar'] = json_decode($this->session->userdata('access_menus'));
        $data['per_page'] = $per_page = $this->input->get('per_page') ?? 100;
        $data['page'] = $page = $this->input->get('page') ?? 1;

        $this->load->helper('url');
        $currentURL = current_url();
        $queryvars = "";
        $cond = "1"; // Base condition

        $data['employee'] = $this->Common_Model->FetchData("users", "*");

        // Retrieve filter inputs
        $emp_id = $this->input->get('assignees');
        $mobile = $this->input->get('mobile');
        $start_date = $this->input->get('start_date');
        $end_date = $this->input->get('end_date');

        // Apply date filter if set
        if (!empty($start_date) && !empty($end_date)) {
            $cond .= " AND DATE(cb.date_added) BETWEEN " . $this->db->escape($start_date) . " AND " . $this->db->escape($end_date);
            $queryvars .= "&start_date=" . urlencode($start_date) . "&end_date=" . urlencode($end_date);
        }

        // Apply employee filter if set
        if (!empty($emp_id)) {
            $cond .= " AND u.user_id = " . $this->db->escape($emp_id);
            $queryvars .= "&assignees=" . urlencode($emp_id);
        }
        if(isset($_REQUEST['mobile']) && $_REQUEST['mobile'] != ''){
            $cond.= "  AND mobile = '".trim($_REQUEST['mobile'])."'";
            $queryvars.= "&mobile=".$_REQUEST['mobile'];
        }
        
        if ($this->session->userdata('usertype') == "Employee") {
            $user_id = $this->session->userdata('user_id');
            $cond .= " AND u.user_id = " . $this->db->escape($user_id);
        }

        // Count total records
        $countSql = "SELECT COUNT(*) as num 
                     FROM callback cb 
                     LEFT JOIN lead_enquiry le ON cb.enq_id = le.enq_id 
                     LEFT JOIN users u ON le.assigned_to = u.user_id 
                     WHERE $cond";

        $records = $this->Common_Model->db_query($countSql);
        $totalrecords = $records[0]['num'] ?? 0;

        if ($totalrecords > 0) {
            $this->load->library("Paginator");
            $this->paginator->setparam(["page_num" => $page, "num_rows" => $totalrecords]);
            $this->paginator->set_Limit($per_page);
            $range1 = $this->paginator->getRange1();
            $range2 = $per_page; // Fix for LIMIT

            // Retrieve paginated data
            $sSql = "SELECT 
                        cb.date_added,
                        cb.reason,
                        cb.next_date,
                        cb.notes, 
                        le.name AS customer_name, 
                        le.mobile AS customer_mobile,
                        le.customer_code AS cust_code,
                        u.firstname, 
                        u.lastname 
                     FROM callback cb 
                     LEFT JOIN lead_enquiry le ON cb.enq_id = le.enq_id 
                     LEFT JOIN users u ON le.assigned_to = u.user_id 
                     WHERE $cond 
                     ORDER BY cb.date_added DESC 
                     LIMIT $range1, $range2";

            $records = $this->Common_Model->db_query($sSql);

            // Setup pagination
            $queryvars = "per_page=$per_page" . $queryvars;
            $paging_info = $this->paginator->DBPagingNav($queryvars, $currentURL, $totalrecords, $per_page);
            $aData['tot_page'] = $paging_info[0];
            $aData['pages'] = $paging_info[1];
            $data['sPages'] = $aData['pages'];
            $data['record'] = $records;
            $data['norecords'] = false;
        } else {
            $data['record'] = [];
            $data['norecords'] = true;
        }

        // View parameters
        $data['activemenu'] = 'leadreport';
        $data['activesubmenu'] = 'callback';
        $this->load->view('leadreport/callback', $data);
    }


    

  

    public function calllog() {
            $data = array();
            $data['accessar'] = json_decode($this->session->userdata('access_menus'));
            $data['per_page'] = $per_page = $this->input->get('per_page') ?? 100;
            $data['page'] = $page = $this->input->get('page') ?? 1;

            $this->load->helper('url');
            $currentURL = current_url();
            $queryvars = "";
            $cond = "1"; // Base condition

            $data['employee'] = $employee = $this->Common_Model->FetchData("users", "*");

            // Retrieve filter inputs safely
            $empid = $this->input->get('assignees');
            $mobile = $this->input->get('mobile');
            $emp_name = $this->input->get('emp_name');

            // Apply filters
            if (!empty($empid)) {
                $cond .= " AND u.user_id = " . $this->db->escape($empid);
                $queryvars .= "&assignees=" . urlencode($empid);
            }
            if(isset($_REQUEST['mobile']) && $_REQUEST['mobile'] != ''){
            $cond .= "  AND mobile = '".trim($_REQUEST['mobile'])."'";
            $queryvars .= "&mobile=".$_REQUEST['mobile'];
          }
            if ($this->session->userdata('usertype') == "Employee") {
                $user_id = $this->session->userdata('user_id');
                $cond .= " AND u.user_id = " . $this->db->escape($user_id);
            }

            // Count total records
            $countSql = "SELECT COUNT(*) as num FROM lead_activity la 
                         LEFT JOIN users u ON la.emp_id = u.user_id 
                         LEFT JOIN lead_enquiry le ON la.enq_id = le.enq_id 
                         WHERE $cond";

            $records = $this->Common_Model->db_query($countSql);
            $totalrecords = $records[0]['num'] ?? 0;

            if ($totalrecords > 0) {
                $this->load->library("Paginator");
                $this->paginator->setparam(["page_num" => $page, "num_rows" => $totalrecords]);
                $this->paginator->set_Limit($per_page);
                $range1 = $this->paginator->getRange1();
                $range2 = $per_page; // Fix for LIMIT

                // Retrieve paginated data
                $sSql = "SELECT 
                            la.dateadded, 
                            la.attachment, 
                            la.enquiry_remark,
                            la.sim_id,
                            la.call_type,
                            la.call_duration,
                            la.date_time,
                            u.firstname, 
                            u.lastname, 
                            le.name AS customer_name,
                            le.mobile AS customer_mobile,
                            le.customer_code AS cust_code
                         FROM lead_activity la 
                         LEFT JOIN users u ON la.emp_id = u.user_id 
                         LEFT JOIN lead_enquiry le ON la.enq_id = le.enq_id 
                         WHERE $cond 
                         ORDER BY la.dateadded DESC 
                         LIMIT $range1, $range2";

                $records = $this->Common_Model->db_query($sSql);

                // Setup pagination
                $queryvars = "per_page=$per_page" . $queryvars;
                $paging_info = $this->paginator->DBPagingNav($queryvars, $currentURL, $totalrecords, $per_page);
                $aData['tot_page'] = $paging_info[0];
                $aData['pages'] = $paging_info[1];
                $data['sPages'] = $aData['pages'];
                $data['record'] = $records;
                $data['norecords'] = false;
            } else {
                $data['record'] = [];
                $data['norecords'] = true;
            }

            // View parameters
            $data['activemenu'] = 'leadreport';
            $data['activesubmenu'] = 'calllog';
            $this->load->view('leadreport/calllog', $data);
        }

    public function opportunity() {
        $data = array();
        $data['accessar'] = json_decode($this->session->userdata('access_menus'));
        $data['per_page'] = $per_page = $this->input->get('per_page') ?? 50;
        $data['page'] = $page = $this->input->get('page') ?? 1;

        $this->load->helper('url');
        $currentURL = current_url();
        $queryvars = "";
        $cond = "i.remarks = 'opportunity'"; // Base condition

        // Fetch Employees
        $data['employee'] = $this->Common_Model->FetchData("users", "*");
        
        $data['uclocation'] = $this->Common_Model->FetchData("uc_location", "*");

        // Fetch Available Properties
        $data['property'] = $this->Common_Model->FetchData("property", "*", "avail_status = 'available'", "", "pid DESC");

        // Retrieve filter inputs
        $emp_id = $this->input->get('assignees');
        $prop_id = $this->input->get('properties');
        $mobile = $this->input->get('mobile');
        $specification = $this->input->get('specification');
        $location = $this->input->get('uplocation');

        // Apply employee filter if set
        if (!empty($emp_id)) {
            $cond .= " AND u.user_id = " . $this->db->escape($emp_id);
            $queryvars .= "&assignees=" . urlencode($emp_id);
        }
        
       if (!empty($specification)) {
            $cond .= " AND i.prop_type LIKE " . $this->db->escape("%$specification%");
            $queryvars .= "&specification=" . urlencode($specification);
        }
        if (!empty($location)) {
           $cond .= " AND ucl.uc_lid = " . $this->db->escape($location);
            $queryvars .= "&uplocation=" . urlencode($location);
        }

        // Apply property filter if set
        if (!empty($prop_id)) {
            $cond .= " AND p.pid = " . $this->db->escape($prop_id);
            $queryvars .= "&properties=" . urlencode($prop_id);
        }
        if(isset($_REQUEST['mobile']) && $_REQUEST['mobile'] != ''){
            $cond .= "  AND mobile = '".trim($_REQUEST['mobile'])."'";
            $queryvars .= "&mobile=".$_REQUEST['mobile'];
        }
        if ($this->session->userdata('usertype') == "Employee") {
            $user_id = $this->session->userdata('user_id');
            $cond .= " AND u.user_id = " . $this->db->escape($user_id);
        }

        // Count total records
        $countSql = "SELECT COUNT(*) as num 
                     FROM interest i 
                     LEFT JOIN users u ON i.user_id = u.user_id 
                     LEFT JOIN lead_enquiry le ON i.enq_id = le.enq_id 
                     LEFT JOIN property p ON i.prop_id = p.pid
                     LEFT JOIN erp_source es ON es.id = le.source
                     LEFT JOIN uc_location ucl ON i.uc_location = ucl.uc_lid
                     WHERE $cond";

        $records = $this->Common_Model->db_query($countSql);
        $totalrecords = $records[0]['num'] ?? 0;

        if ($totalrecords > 0) {
            $this->load->library("Paginator");
            $this->paginator->setparam(["page_num" => $page, "num_rows" => $totalrecords]);
            $this->paginator->set_Limit($per_page);
            $range1 = $this->paginator->getRange1();
            $range2 = $per_page; // Fix for LIMIT

            // Retrieve paginated data
            $sSql = "SELECT
                        i.id, 
                        --i.require_type, 
                        i.prop_type, 
                        i.prop_sub_type, 
                        i.other_prop, 
                        i.location, 
                        i.remarks,
                        i.city,
                        i.locations AS locality, 
                        i.notes,
                        i.dateadded, 
                        u.firstname, 
                        u.lastname, 
                        le.name AS customer_name,
                        le.mobile AS customer_mobile,
                        le.customer_code AS cust_code,
                        le.enquiry_remark AS lead_remark,
                        p.prop_name AS property_name,
                        ucl.uc_location AS upcoming_loc,
                        es.source AS lead_source
                     FROM interest i 
                     LEFT JOIN users u ON i.user_id = u.user_id 
                     LEFT JOIN lead_enquiry le ON i.enq_id = le.enq_id 
                     LEFT JOIN property p ON i.prop_id = p.pid
                     LEFT JOIN erp_source es ON es.id = le.source
                     LEFT JOIN uc_location ucl ON i.uc_location = ucl.uc_lid
                     WHERE $cond 
                     ORDER BY i.id DESC
                     LIMIT $range1, $range2";

            $records = $this->Common_Model->db_query($sSql);

            // Setup pagination
            $queryvars = "per_page=$per_page" . $queryvars;
            $paging_info = $this->paginator->DBPagingNav($queryvars, $currentURL, $totalrecords, $per_page);
            $aData['tot_page'] = $paging_info[0];
            $aData['pages'] = $paging_info[1];
            $data['sPages'] = $aData['pages'];
            $data['record'] = $records;
            $data['norecords'] = false;
        } else {
            $data['record'] = [];
            $data['norecords'] = true;
        }

        // View parameters
        $data['activemenu'] = 'leadreport';
        $data['activesubmenu'] = 'opportunity';
        $this->load->view('leadreport/opportunity', $data);
    }
    
     public function daily_report() {
    $data = array();

    // Pagination Setup
    $data['per_page'] = $per_page = $this->input->get('per_page') ?? 10;
    $data['page'] = $page = $this->input->get('page') ?? 1;

    $currentURL = current_url();
    $queryvars = "";
    $cond = "1";

    // Apply Employee Filter
    $emp_id = $this->input->get('assignees'); 
    if (!empty($emp_id)) {
        $cond .= " AND u.user_id = " . $this->db->escape($emp_id);  
        $queryvars .= "&assignees=" . urlencode($emp_id);
    }

    // Fetch Employees
    $data['employee'] = $this->Common_Model->FetchData(
        "users AS u", 
        "*", 
       " $cond ORDER BY user_id ASC"
    );

    $date = $this->input->get('s_report_date'); 
    if (!empty($date)) {
        $cond .= " AND le.enquiry_date >= " . $this->db->escape($date);  
        $queryvars .= "&s_report_date=" . urlencode($date);
    }else {
        $date = date("Y-m-d");
        $cond .= " AND le.enquiry_date >= " . $this->db->escape($date);  
        $queryvars .= "&s_report_date=" . urlencode($date);
    }


    $date = $this->input->get('e_report_date'); 
    if (!empty($date)) {
        $cond .= " AND le.enquiry_date <= " . $this->db->escape($date);  
        $queryvars .= "&e_report_date=" . urlencode($date);
    }else {
        $date = date("Y-m-d");
        $cond .= " AND le.enquiry_date <= " . $this->db->escape($date);  
        $queryvars .= "&e_report_date=" . urlencode($date);
    }

    


    // Count Total Records for Pagination
   $countSql = "
        SELECT COUNT(DISTINCT u.user_id) AS num 
        FROM users AS u JOIN 
                lead_enquiry le ON u.user_id = le.assigned_to
        WHERE userstatus = '1' AND " . $cond;

    $records = $this->Common_Model->db_query($countSql);
    $totalrecords = $records[0]['num'] ?? 0;

    

    if ($totalrecords > 0) {
        $this->load->library("Paginator");
        $this->paginator->setparam(["page_num" => $page, "num_rows" => $totalrecords]);
        $this->paginator->set_Limit($per_page);
        $range1 = $this->paginator->getRange1();
        $range2 = $per_page;

        // Data Fetching with Pagination
        $data['records'] = $this->Common_Model->db_query("
            SELECT 
                u.user_id,
                u.firstname AS employee_fname,
                u.lastname AS employee_lname,
                COUNT(le.enq_id) AS leads_received,
                SUM(CASE WHEN le.comp_status = 'Interested' THEN 1 ELSE 0 END) AS leads_interested,
                SUM(CASE WHEN le.comp_status = 'Opportunity' THEN 1 ELSE 0 END) AS leads_opportunity,
                SUM(CASE WHEN le.comp_status = 'Callback' THEN 1 ELSE 0 END) AS leads_callback,
                SUM(CASE WHEN le.comp_status = 'Missed' THEN 1 ELSE 0 END) AS leads_missed,
                SUM(CASE WHEN le.comp_status = 'Success' THEN 1 ELSE 0 END) AS leads_success,
                SUM(CASE WHEN le.comp_status = 'Delete' THEN 1 ELSE 0 END) AS leads_deleted,
                SUM(CASE WHEN le.comp_status = 'Initiated' THEN 1 ELSE 0 END) AS leads_initiated,
                SUM(CASE WHEN le.comp_status = 'Site Visit' THEN 1 ELSE 0 END) AS leads_sitevisit,
                SUM(CASE WHEN le.comp_status = 'Follow Up' THEN 1 ELSE 0 END) AS leads_follow_up
            FROM 
                users u 
            JOIN 
                lead_enquiry le ON u.user_id = le.assigned_to
            WHERE $cond
            GROUP BY 
                u.user_id, u.firstname
            LIMIT $range1, $range2

        ");

        // Pagination Setup
        $paging_info = $this->paginator->DBPagingNav($queryvars, $currentURL, $totalrecords, $per_page);
        $data['sPages'] = $paging_info[1];
    } else {
        $data['records'] = [];
        $data['sPages'] = "";
    }
    //echo "<pre>";print_r($data['records']);exit;
    // Active Menus
    $data['activemenu'] = 'leadreport';
    $data['activesubmenu'] = 'daily_report';

    // Load View
    $this->load->view('leadreport/daily_report', $data);
}

    public function missed() {
        $data = array();
        $data['accessar'] = json_decode($this->session->userdata('access_menus'));
        
        $data['per_page'] = $per_page = $this->input->get('per_page') ?? 100;
        $data['page'] = $page = $this->input->get('page') ?? 1;
        $this->load->helper('url');
        $currentURL = current_url();
        $queryvars = '';
        $cond = "le.comp_status = 'Missed'";

         // Fetch Employees
        $data['employee'] = $this->Common_Model->FetchData("users", "*");

        // $data['locate'] = $this->Common_Model->FetchData("location", "*");

         // Retrieve filter inputs
        $emp_id = $this->input->get('assignees');
        // $prop_id = $this->input->get('properties');
        $mobile = $this->input->get('mobile');
        $specification = $this->input->get('specification');
        // $location = $this->input->get('location');

        // Apply employee filter if set
        if (!empty($emp_id)) {
            $cond .= " AND u.user_id = " . $this->db->escape($emp_id);
            $queryvars .= "&assignees=" . urlencode($emp_id);
        }
        if(isset($_REQUEST['mobile']) && $_REQUEST['mobile'] != ''){
            $cond .= "  AND le.mobile = '".trim($_REQUEST['mobile'])."'";
            $queryvars .= "&mobile=".$_REQUEST['mobile'];
        }
        if (!empty($specification)) {
            $cond .= " AND le.specification LIKE " . $this->db->escape("%$specification%");
            $queryvars .= "&specification=" . urlencode($specification);
        }

        // Count total records
        $countSql = "SELECT COUNT(*) as num 
                     FROM lead_enquiry le 
                     LEFT JOIN users u ON le.assigned_to = u.user_id
                     LEFT JOIN lead_activity la ON le.enq_id = la.enq_id 
                     WHERE $cond";
        $records = $this->Common_Model->db_query($countSql);
        $totalrecords = $records[0]['num'] ?? 0;

        if ($totalrecords) {
            $this->load->library("Paginator");
            $this->paginator->setparam(array("page_num" => $page, "num_rows" => $totalrecords));
            $this->paginator->set_Limit($per_page);
            $range1 = $this->paginator->getRange1();
            $range2 = $this->paginator->getRange2();

            // Paginated data query
            $sSql = "SELECT le.*, u.firstname, u.lastname, la.date_time, la.call_type, la.call_duration
                     FROM lead_enquiry le 
                     LEFT JOIN users u ON le.assigned_to = u.user_id 
                     LEFT JOIN lead_activity la ON le.enq_id = la.enq_id 
                     WHERE $cond 
                     ORDER BY le.enq_id DESC 
                     LIMIT $range1, $range2";

            $data['record'] = $this->Common_Model->db_query($sSql);

            $queryvars = "per_page=$per_page";
            $paging_info = $this->paginator->DBPagingNav($queryvars, $currentURL, $totalrecords, $per_page);
            $data['sPages'] = $paging_info[1];
        } else {
            $data['record'] = array();
        }

        $data['activemenu'] = 'leadreport';
        $data['activesubmenu'] = 'missed';
        $this->load->view('leadreport/missed', $data);
    }


}