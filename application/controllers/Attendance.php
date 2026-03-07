<?php
error_reporting(0);
defined('BASEPATH') OR exit('No direct script access allowed');
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Attendance extends CI_Controller {

	public function __construct(){
		parent::__construct();
		is_logged_in();
		date_default_timezone_set("Asia/Kolkata"); 
		$this->present_date 		= date('Y-m-d');
		$this->present_time 		= date('H:i:a');
		$this->timestamp 		= date('Y-m-d H:i:s'); 
	}

    public function attendances() {
	    $data = array();
	    $data['accessar'] = json_decode($this->session->userdata('access_menus'));
	    $datetime = new DateTime();
	    $datetime->modify('-5 days');
	    $attndate = $datetime->format('Y-m-d'); 
	    $sql = "1";

	    $data['per_page'] = $per_page = $this->input->get('per_page') ?? 15;
	    $data['page'] = $page = $this->input->get('page') ?? 1;
	    $this->load->helper('url');
	    $currentURL = current_url();
	    $queryvars = '';

	    // Count total records
	    $countSql = "SELECT COUNT(*) as num FROM user_attendance_log 
	                 WHERE $sql AND log_date >= '$attndate' AND log_date <= '".date('Y-m-d')."' 
	                 AND approve_status=0 AND status=1";
	    $records = $this->Common_Model->db_query($countSql);
	    $totalrecords = $records[0]['num'] ?? 0;

	    if ($totalrecords) {
	        $this->load->library("Paginator");
	        $this->paginator->setparam(array("page_num" => $page, "num_rows" => $totalrecords));
	        $this->paginator->set_Limit($per_page);
	        $range1 = $this->paginator->getRange1();
	        $range2 = $this->paginator->getRange2();

	        // Fetch paginated records
	        $sSql = "SELECT b.employee_name, a.user_id, a.log_datetime, a.attendance_log_id, a.log_loc, a.log_date, 
	                        a.status, b.techno_emp_id, a.user_img 
	                 FROM user_attendance_log as a 
	                 LEFT JOIN employees as b ON a.user_id = b.user_id 
	                 LEFT JOIN users as u ON a.user_id = u.user_id 
	                 WHERE $sql AND a.log_date >= '$attndate' AND a.log_date <= '".date('Y-m-d')."' 
	                 AND approve_status=0 AND status=1 
	                 ORDER BY a.log_date DESC 
	                 LIMIT $range1, $range2";

	        $data['attenrec'] = $this->Common_Model->db_query($sSql);

	        $queryvars = "per_page=$per_page";
	        $paging_info = $this->paginator->DBPagingNav($queryvars, $currentURL, $totalrecords, $per_page);
	        $data['sPages'] = $paging_info[1];
	    } else {
	        $data['attenrec'] = array();
	    }

	    // Employee Attendance Summary
	    $data['empatten'] = $this->Common_Model->db_query("
	        SELECT SUM(A.noatten) as empduty, SUM(working_hour) as empwhour 
	        FROM emp_attendance A 
	        WHERE A.employee_id = ".$this->session->userdata('employee_tagged_id')." 
	        AND MONTH(A.attended_date) = MONTH(CURRENT_DATE()) 
	        AND YEAR(A.attended_date) = YEAR(CURRENT_DATE())
	    ");

	    $data['activemenu'] = 'attendance';
	    $data['activesubmenu'] = 'attendances';
	    $this->load->view('attendance/attendancelist', $data);
	}


	 function attenapprv($user_id=0,$log_date=''){
		if ($user_id > 0 && $log_date) {
			$employee = $this->Common_Model->db_query("SELECT employee_id FROM employees WHERE user_id=".$user_id);
			$rec1 = $this->Common_Model->FetchData("user_attendance_log","*","log_date='".$log_date."' AND user_id=".$user_id." AND status=1");
			$rec2 = $this->Common_Model->FetchData("user_attendance_log","*","log_date='".$log_date."' AND user_id=".$user_id." AND status=2");
			if ($rec1) {
					$clockintime = date('H:i:s',strtotime($rec1[0]['log_datetime']));
					$inlocation = $rec1[0]['log_loc'];
				}else{
					$clockintime = '';
					$inlocation = '';
				}
			if (!empty($rec2)) {
					$clockouttime = date('H:i:s',strtotime($rec2[0]['log_datetime']));
					$outlocation = $rec2[0]['log_loc'];
				}else{
					$clockouttime = '';
					$outlocation = '';
				}

			if (!empty($rec2) && !empty($rec1)) {
				  $login_timestamp = strtotime($rec1[0]['log_datetime']);
	              $logout_timestamp = strtotime($rec2[0]['log_datetime']);
	              $time_difference = $logout_timestamp - $login_timestamp;

	              $hours = floor($time_difference / 3600);
	              $time_difference %= 3600;
	              $minutes = floor($time_difference / 60);
	              $seconds = $time_difference % 60;
	              $total_hours += $hours;
	              $total_minutes += $minutes;
	              $time_difference_formatted = sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);
	              $workinghour = date('H:i:s', strtotime($time_difference_formatted));
			}else{
				$workinghour = 0;
			}
			$data_list = array(
								'employee_id' 	=> $employee[0]['employee_id'], 
								'attended_date' => $log_date, 
								'intime' 		=> $clockintime, 
								'outtime' 		=> $clockouttime, 
								'working_hour' 	=> $workinghour, 
								'inlocation' 	=> $inlocation, 
								'outlocation' 	=> $outlocation, 
								'approved_by' 	=> $this->session->userdata('user_id'), 
								'approved_datetime' => date('Y-m-d H:i:s'), 
							);
			$attendance_id = $this->Common_Model->dbinsertid("emp_attendance",$data_list);
			if ($attendance_id > 0) {
				$this->Common_Model->db_query("UPDATE user_attendance_log SET approve_status='1' WHERE log_date='".$log_date."' AND user_id=".$user_id."");
			}
			redirect($_SERVER['HTTP_REFERER']);
		}else{
			redirect($_SERVER['HTTP_REFERER']);
		}

	}

	

	public function apprvattends() {
	    $data = array();
	    $data['accessar'] = json_decode($this->session->userdata('access_menus'));
	    $curSession = $this->session->userdata['session_name'];

	    // Pagination Setup
	    $data['per_page'] = $per_page = $this->input->get('per_page') ?? 50;
	    $data['page'] = $page = $this->input->get('page') ?? 1;

	    $this->load->helper('url');
	    $currentURL = current_url();
	    $queryvars = "";
	    $sql = "1"; // Default condition
	    
	    $data['employees'] = $this->Common_Model->FetchData("employees", "*");

	    // Retrieve filter inputs
        $emp_id = $this->input->get('assignees');

         // Apply employee filter if set
        if (!empty($emp_id)) {
            $sql .= " AND em.employee_id = " . $this->db->escape($emp_id);
            $queryvars .= "&assignees=" . urlencode($emp_id);
        }

	    // Filtering based on log_date and to_date
	    if (!empty($_REQUEST['log_date'])) {
	        $log_date = $this->db->escape($_REQUEST['log_date']);
	        $sql .= " AND l.attended_date >= $log_date";
	        $queryvars .= "&log_date=" . $_REQUEST['log_date'];
	    }

	    if (!empty($_REQUEST['to_date'])) {
	        $to_date = $this->db->escape($_REQUEST['to_date']);
	        $sql .= " AND l.attended_date <= $to_date";
	        $queryvars .= "&to_date=" . $_REQUEST['to_date'];
	    }

	    // Count total records for pagination
	    $countSql = "
	        SELECT COUNT(*) AS num 
	        FROM emp_attendance AS l 
	        LEFT JOIN employees AS em ON em.employee_id = l.employee_id  
	        WHERE $sql
	    ";
	    
	    $records = $this->Common_Model->db_query($countSql);
	    $totalrecords = $records[0]['num'] ?? 0;

	    if ($totalrecords > 0) {
	        $this->load->library("Paginator");
	        $this->paginator->setparam(["page_num" => $page, "num_rows" => $totalrecords]);
	        $this->paginator->set_Limit($per_page);
	        $range1 = $this->paginator->getRange1();
	        $range2 = $per_page;

	        // Fetch paginated records
	        $sSql = "
	            SELECT 
	                em.employee_id, 
	                em.employee_name, 
	                em.emp_mobile, 
	                l.attended_date, 
	                l.intime, 
	                l.outtime, 
	                l.inlocation, 
	                l.outlocation, 
	                l.working_hour, 
	                em.techno_emp_id, 
	                l.attendance_id, 
	                l.remarks 
	            FROM emp_attendance AS l 
	            LEFT JOIN employees AS em ON em.employee_id = l.employee_id  
	            WHERE $sql 
	            ORDER BY l.attendance_id DESC 
	            LIMIT $range1, $range2
	        ";

	        $record = $this->Common_Model->db_query($sSql);
	        $data['records'] = $record ? array_unique($record, SORT_REGULAR) : [];
	        
	        // Pagination Setup
	        $paging_info = $this->paginator->DBPagingNav($queryvars, $currentURL, $totalrecords, $per_page);
	        $data['sPages'] = $paging_info[1];
	    } else {
	        $data['records'] = [];
	        $data['sPages'] = "";
	    }

	    if(isset($_REQUEST['downloadBtn'])){
			$html = '<table border=1> <tr> <th>Sl No.</th><th>Employee Name</th><th>Mobile</th><th>Log Date</th><th>In time</th><th>In Location</th><th>Out time </th><th>Out Location</th><th>Working Hour</th><th>Remarks</th> </tr>';

            for($i=0;$i<count($records);$i++){
            	if ($records[$i]['employee_id']) { $a++;
            		
            	$html.= '<tr><td>'.($a).'</td><td>'.$records[$i]['employee_name'].'</td><td>'.$records[$i]['emp_mobile'].'</td><td>'.$records[$i]['attended_date'].'</td><td>'.$records[$i]['intime'].'</td><td>'.$records[$i]['inlocation'].'</td><td>'.$records[$i]['outtime'].'</td><td>'.$records[$i]['outlocation'].'</td><td>'.$records[$i]['working_hour'].'</td><td>'.$records[$i]['remarks'].'</td> </tr>';

            }}
            $html.= '</table>';
            $this->db->close();
			header("Content-type: application/vnd.ms-excel");
			header("Content-Disposition: attachment; filename=attendancereport".time().".xls");
			echo $html;exit;
		}

	    $data['accessar'] = json_decode($this->session->userdata('access_menus'));
	   
	    // Active Menus
	    $data['activemenu'] = 'attendance';
	    $data['activesubmenu'] = 'apprvattends';

	    // Load View
	    $this->load->view('attendance/apprvattends', $data);
	}


	public function UpdateAttenHour(){ 
    	$attendance_id = $this->input->post("attendance_id");
    	$working_hour = $this->input->post("working_hour");
    	$remarks = $this->input->post("remarks");
    	$this->Common_Model->db_query("UPDATE emp_attendance SET working_hour=".$working_hour.",remarks='".$remarks."' WHERE attendance_id=".$attendance_id);
    	exit;
    }
    
    public function UpdateClockinTim(){
    	$attendance_id = $this->input->post("attendance_id");
    	$colckintime = $this->input->post("colckintime");
    	$remarks = $this->input->post("remarks");
    	$rec = $this->Common_Model->FetchData("user_attendance_log","*","attendance_log_id=".$attendance_id);

    	if($rec){
    		$intime = $rec[0]['log_date'].' '.$colckintime;
    		$datalist = array(
    			'log_datetime' => $intime,
    			'remarks' => "Clock In"
    			 );
    		$this->Common_Model->update_records("user_attendance_log","attendance_log_id",$attendance_id,$datalist);
    	}
    	
    	exit;
    }

    public function UpdateClockoutTim(){
    	$attendance_id = $this->input->post("attendance_id");
    	$colckouttime = $this->input->post("colckouttime");
    	$remarks = $this->input->post("remarks");
    	$attenval = $this->input->post("attenval");
    	$rec = $this->Common_Model->FetchData("user_attendance_log","*","attendance_log_id=".$attendance_id);

    	if($rec){
    		$intime = $rec[0]['log_date'].' '.$colckouttime;
    		$datalist = array(
    			'log_datetime' => $intime,
    			'remarks' => "Clock Out"
    			 );
    	    if ($attenval == '2') {
    		    $this->Common_Model->update_records("user_attendance_log","attendance_log_id",$attendance_id,$datalist);
    	    }else{
    			$datalist['user_id'] = $rec[0]['user_id'];
    			$datalist['status'] = '2';
    			$datalist['log_date'] = $rec[0]['log_date'];
    			$this->Common_Model->dbinsertid("user_attendance_log",$datalist);
    		}
    	}
    	exit;
    }
}