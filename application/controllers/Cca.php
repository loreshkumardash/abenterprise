<?php
error_reporting(0);
defined('BASEPATH') OR exit('No direct script access allowed');

class Cca extends CI_Controller {

	public function __construct(){
		parent::__construct();
		is_logged_in();
		date_default_timezone_set("Asia/Kolkata"); 
		$this->present_date 	= date('Y-m-d');
		$this->present_time 	= date('H:i:a');
		$this->present_timefmt 	= date('h:i:a');
		$this->present_time1 	= date('H:i');
		$this->tod_date 		= date('d-M-Y');
		$this->dayltr 			= date("l"); 
	}

	public function index()
	{
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$data['activemenu'] = 'masters';
		$data['activesubmenu'] = 'masters';
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));           
		$this->load->view('dashboard', $data);
	}

	public function addcertificate(){
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		if($this->input->post('submitBtn')){
			$this->form_validation->set_rules('session_id', 'Session', 'trim|required');
			$this->form_validation->set_error_delimiters('<p class="has-error"><label class="control-label">', '</label></p>');
			if($this->form_validation->run()){
				$student = $this->Common_Model->FetchData("students", "*", "student_id = ".$this->input->post('student_id'));
				$data_list = array(
					'session_id'					=> $this->input->post('session_id'),
					'class_id'						=> $this->input->post('class_id'),
					'student_name'					=> $student[0]['student_first_name'].' '.$student[0]['student_last_name'],
					'cca_id'						=> $this->input->post('cca_name'),
					'cca_position'					=> $this->input->post('cca_position'),
					'cca_date'						=> $this->input->post('cca_date'),
					'created_on'					=> date("Y-m-d H:i:s"),
					'student_id'					=> $this->input->post('student_id'),
					'cca_type'						=> $this->input->post('cca_type'),
					'cca_group'						=> $this->input->post('cca_group'),
					'section_id'					=> $this->input->post('student_section'),
					'house_no'						=> $this->input->post('house_no')
				);
				//print_r($data_list);exit;
				$exam_result_id = $this->Common_Model->dbinsertid("cca_records", $data_list);
				$this->session->set_flashdata('success', 'CCA result added successfully.' );
				redirect('cca/addcertificate');
			}else{
				$this->session->set_flashdata('error', validation_errors());
			}
		}
		$data['activemenu'] 	= 'cca';
		$data['activesubmenu'] 	= 'addcertificate';
		$data['sessions'] 		= $this->Common_Model->FetchData("sessions", "*", "1 ORDER BY session_id DESC");
		$data['classes'] 		= $this->Common_Model->FetchData("classes", "*", "1 ORDER BY class_name ASC");
		$data['ccas'] 			= $this->Common_Model->FetchData("cca", "*", "1 ORDER BY cca_name DESC");
		$data['positions'] 		= $this->Common_Model->FetchData("positions", "*", "1 ORDER BY position_name ASC");
		$this->load->view('cca/addcertificate', $data);
	}

	function listcertificate(){
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$data['per_page'] = $per_page = isset($_REQUEST['per_page']) ? $_REQUEST['per_page'] : 10;
		$data['page'] = $page = isset($_REQUEST['page']) ? $_REQUEST['page'] : '1';
		$this->load->helper('url');
		$currentURL = current_url();
		$sql = "1";
		
		$urlvars = '';
		
		if(isset($_REQUEST['session_id']) && $_REQUEST['session_id'] != ''){
			$sql.= " AND r.session_id = '".$_REQUEST['session_id']."'";
			$urlvars.= "&session_id=".$_REQUEST['session_id'];
		}

		if(isset($_REQUEST['class_id']) && $_REQUEST['class_id'] != ''){
			$sql.= " AND r.class_id = '".$_REQUEST['class_id']."'";
			$urlvars.= "&class_id=".$_REQUEST['class_id'];
		}

		if(isset($_REQUEST['student_id']) && $_REQUEST['student_id'] != ''){
			$sql.= " AND r.student_id = '".$_REQUEST['student_id']."'";
			$urlvars.= "&student_id=".$_REQUEST['student_id'];
		}

		if(isset($_REQUEST['student_section']) && $_REQUEST['student_section'] != ''){
			$sql.= " AND r.section_id = '".$_REQUEST['student_section']."'";
			$urlvars.= "&student_section=".$_REQUEST['student_section'];
		}

		if(isset($_REQUEST['created_on_from']) && $_REQUEST['created_on_from'] != ''){
			$sql.= " AND r.created_on >= '".$_REQUEST['created_on_from']."'";
			$urlvars.= "&created_on_from=".$_REQUEST['created_on_from'];
		}
		
		if(isset($_REQUEST['created_on_to']) && $_REQUEST['created_on_to'] != ''){
			$sql.= " AND r.created_on <= '".$_REQUEST['created_on_to']."'";
			$urlvars.= "&created_on_to=".$_REQUEST['created_on_to'];
		}
		if(isset($_REQUEST['cca_name']) && $_REQUEST['cca_name'] != ''){
			$sql.= " AND r.cca_id LIKE '%".$_REQUEST['cca_name']."%'";
			$urlvars.= "&cca_name=".$_REQUEST['cca_name'];
		}
		if(isset($_REQUEST['cca_type']) && $_REQUEST['cca_type'] != ''){
			$sql.= " AND r.cca_type LIKE '%".$_REQUEST['cca_type']."%'";
			$urlvars.= "&cca_type=".$_REQUEST['cca_type'];
		}
		/*if(isset($_REQUEST['cca_date']) && $_REQUEST['cca_date'] != ''){
			$sql.= " AND r.cca_date = '".$_REQUEST['cca_date']."'";
			$urlvars.= "&cca_date=".$_REQUEST['cca_date'];
		}*/

		$sSql = "SELECT COUNT(*) as num FROM cca_records AS r LEFT JOIN sessions AS s ON r.session_id = s.session_id LEFT JOIN classes AS c ON r.class_id = c.class_id LEFT JOIN students AS st ON r.student_id = st.student_id WHERE $sql";
		$records = $this->Common_Model->db_query($sSql);
		$totalrecords = $records[0]['num'];
		if($totalrecords){
			$sSql = "SELECT s.session_name, c.class_name, r.id, r.cca_type, ca.cca_name, r.student_id, r.student_name, r.cca_position, p.position_name, r.class_id, r.cca_date, r.created_on, r.session_id, r.house_no, sec.section_name, cg.gid, cg.cgrp, st.student_first_name, st.student_last_name FROM cca_records AS r INNER JOIN cca AS ca ON r.cca_id = ca.cca_id LEFT JOIN ccagroups AS cg ON r.cca_group = cg.gid LEFT JOIN sessions AS s ON r.session_id = s.session_id LEFT JOIN classes AS c ON r.class_id = c.class_id LEFT JOIN sections AS sec ON r.section_id = sec.section_id LEFT JOIN students AS st ON r.student_id = st.student_id LEFT JOIN positions AS p ON r.cca_position = p.position_id WHERE $sql ORDER BY r.created_on ASC";
			$this->load->library("Paginator");
			$this->paginator->setparam(array("page_num" => $page, "num_rows" => $totalrecords));
			$this->paginator->set_Limit($per_page);

			$range1 = $this->paginator->getRange1();
			$range2 = $this->paginator->getRange2();
			$sSql .= " LIMIT ".$range1.', '.$range2;
			$records = $this->Common_Model->db_query($sSql);
			$queryvars = "per_page=$per_page".$urlvars;
			$paging_info = $this->paginator->DBPagingNav($queryvars, $currentURL);
			$aData['tot_page'] = $paging_info[0];
			$aData['pages'] = $paging_info[1];
			$data['sPages'] = $aData['pages'];
			$data['records'] = $records;
			$data['norecords'] = FALSE;
		}else{
			$data['records'] = 0;
		}

		if($this->input->get('downBtn')){
			$sSql = $this->Common_Model->db_query("SELECT s.session_name, c.class_name, r.id, ca.cca_name, r.student_id, r.student_name, r.cca_position, p.position_name, r.class_id, r.cca_date, r.created_on, r.session_id, r.house_no, sec.section_name, cg.gid, cg.cgrp, st.student_first_name, st.student_last_name FROM cca_records AS r INNER JOIN cca AS ca ON r.cca_id = ca.cca_id LEFT JOIN ccagroups AS cg ON r.cca_group = cg.gid LEFT JOIN sessions AS s ON r.session_id = s.session_id LEFT JOIN classes AS c ON r.class_id = c.class_id LEFT JOIN sections AS sec ON r.section_id = sec.section_id LEFT JOIN students AS st ON r.student_id = st.student_id LEFT JOIN positions AS p ON r.cca_position = p.position_id WHERE $sql ORDER BY r.created_on ASC");
		if($records){
			$html = '<table border=1> <tr> <th>Student Name</th><th>House</th><th>Class</th><th>Section</th><th>Name Of The Competition</th><th>Group</th> <th>' 
             . ( $records[$i]['cca_type'] == 'Participate' ? 'CCA Type' : 'Position' ) . '</th><th>CCA Date</th></tr>';
            
            for($i=0;$i<count($records);$i++){
            	$html.= '<tr><td>'.$records[$i]['student_first_name'].' '.$records[$i]['student_last_name'].'</td><td>'.$records[$i]['house_no'].'</td><td>'.$records[$i]['class_name'].'</td><td>'.$records[$i]['section_name'].'</td><td>'.$records[$i]['cca_name'].'</td><td>'.$records[$i]['cgrp'].'</td> <td>' 
             . ( $records[$i]['cca_type'] == 'Participate' ? $records[$i]['cca_type'] : $records[$i]['cca_position'] ) . '</td><td>'.$records[$i]['cca_date'].'</td></tr>';
            }
            $html.= '</table>';
            $this->db->close();
			header("Content-type: application/vnd.ms-excel");
			header("Content-Disposition: attachment; filename=cca".time().".xls");
			echo $html;exit;
		}else{
			$this->session->set_flashdata('error', 'No Records found' );
			redirect("cca/listcertificate");
		}
		}

		$data['sessions'] = $this->Common_Model->FetchData("sessions", "*", "1 ORDER BY active_session DESC");
		$data['classes'] = $this->Common_Model->FetchData("classes", "*", "1 ORDER BY class_name ASC");
		$data['cca'] = $this->Common_Model->FetchData("cca", "*", "1 ORDER BY cca_name ASC");
		$data['activemenu'] = 'cca';
		$data['activesubmenu'] = 'listcertificate';
		$this->load->view('cca/listcertificate', $data);
	}

	function view_certificate($id = 0){
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$examdata = $this->Common_Model->FetchData("cca_records AS cr LEFT JOIN cca AS c ON cr.cca_id = c.cca_id LEFT JOIN positions AS p ON cr.cca_position = p.position_id LEFT JOIN classes AS cs ON cr.class_id = cs.class_id LEFT JOIN sessions AS s ON cr.session_id = s.session_id LEFT JOIN students AS st ON cr.student_id = st.student_id ", "cr.id, 	cr.cca_id, 	c.cca_name, 	cr.student_id, 	cr.student_name, 	cr.cca_position, p.position_name, 	cr.class_id, cs.class_name, 	cr.cca_date, cr.created_on, cr.session_id, s.session_name, st.father_name, st.mother_name, st.student_gender", "cr.id = $id");
		/*
		header("Content-type: image/jpeg");
	    $imgPath = realpath(APPPATH.'../assets/certificate.jpg');
	    $image = imagecreatefromjpeg($imgPath);
	    $color = imagecolorallocate($image, 0, 0, 0);
	    $fontSize = 10;
	    $x = 515;
	    $y = 795;
	    imagestring($image, $fontSize, $x, $y, $examdata[0]['student_name'], $color);
	    imagejpeg($image);
	    */

		header('Content-Type: image/png');
		$imgPath = realpath(APPPATH.'../assets/0001.jpg');
	    $im = imagecreatefromjpeg($imgPath);
		$black = imagecolorallocate($im, 0, 0, 0);
		$font1 = realpath(APPPATH.'../assets/Pacifico.ttf');
		$font = realpath(APPPATH.'../assets/AlexBrush-Regular.ttf');

	    imagettftext($im, 35, 0, 824, 494, $black, $font, $examdata[0]['student_name']);
		imagettftext($im, 55, 0, 1065, 1230, $black, $font, $examdata[0]['class_name']);
		//imagettftext($im, 23, 0, 195, 450, $black, $font, $examdata[0]['father_name']);
		imagettftext($im, 23, 0, 545, 570, $black, $font, $examdata[0]['class_name']);
		imagettftext($im, 35, 0, 815, 633, $black, $font, $examdata[0]['cca_name']);
		imagettftext($im, 35, 0, 415, 634, $black, $font, $examdata[0]['position_name']);
		imagettftext($im, 25, 0, 655, 697, $black, $font, date('d-m-Y',strtotime($examdata[0]['cca_date'])));
		//$session = explode('-', $examdata[0]['session_name']);
		imagettftext($im, 23, 0, 405, 614, $black, $font1, $session[0]);
		imagettftext($im, 23, 0, 515, 614, $black, $font1, $session[1]);
		//imagettftext($im, 20, 0, 10, 20, $black, $font, $text);
		imagepng($im);
		imagedestroy($im);
	}

	function edit_certificate($id = 0){
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		if($this->input->post('submitBtn')){
			$this->form_validation->set_rules('session_id', 'Session', 'trim|required');
			$this->form_validation->set_rules('class_id', 'class', 'trim|required');
			$this->form_validation->set_rules('cca_name', 'cca name', 'trim|required');
			$this->form_validation->set_rules('cca_position', 'position', 'trim|required');
			$this->form_validation->set_error_delimiters('<p class="has-error"><label class="control-label">', '</label></p>');
			if($this->form_validation->run()){
				$data_list = array(
					'session_id'					=> $this->input->post('session_id'),
					'class_id'					=> $this->input->post('class_id'),					
					'cca_id'					=> $this->input->post('cca_name'),
					'cca_position'					=> $this->input->post('cca_position'),										
					'student_id'					=> $this->input->post('student_id')
				);
	//echo($id);exit;
				$id = $this->Common_Model->update_records("cca_records", "id", $id, $data_list);
				$this->session->set_flashdata('success', 'CCA result updated successfully.');
				redirect($_SERVER['HTTP_REFERER']);
			}else{
				$this->session->set_flashdata('error', validation_errors());
			}
		}
		$data['activemenu'] = 'cca';
		$data['activesubmenu'] = 'editcertificate';
		$data['sessions'] = $this->Common_Model->FetchData("sessions", "*", "1 ORDER BY session_id DESC");
		$data['cca'] = $this->Common_Model->FetchData("cca_records", "*", "id = ".$id);
		$data['classes'] = $this->Common_Model->FetchData("classes", "*", "1 ORDER BY class_name ASC");
		$data['ccas'] 			= $this->Common_Model->FetchData("cca", "*", "1 ORDER BY cca_name DESC");
		$data['positions'] 		= $this->Common_Model->FetchData("positions", "*", "1 ORDER BY position_name ASC");
		$this->load->view('cca/editcertificate', $data);
	}	

	function delete_certificate($id = 0){
		$this->Common_Model->DelData("cca_records", "id = ".$id);
		$this->session->set_flashdata('success', 'Record deleted successfully.' );
		redirect($_SERVER['HTTP_REFERER']);
	}

	public function add_conduct(){
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		if($this->input->post('submitBtn')){
			$this->form_validation->set_rules('session_id', 'Session', 'trim|required');
			$this->form_validation->set_error_delimiters('<p class="has-error"><label class="control-label">', '</label></p>');
			if($this->form_validation->run()){
				$student = $this->Common_Model->FetchData("students", "*", "student_id = ".$this->input->post('student_id'));
				$data_list = array(
					'session_id'					=> $this->input->post('session_id'),
					'from_cls'						=> $this->input->post('from_cls'),
					'class_id'						=> $this->input->post('class_id'),
					'student_name'					=> $student[0]['student_first_name'].' '.$student[0]['student_last_name'],
					
					'parent_name'					=> $this->input->post('parent_name'),
					'cca_date'						=> $this->input->post('cca_date'),
					'created_on'					=> date("Y-m-d H:i:s"),
					'student_id'					=> $this->input->post('student_id')
				);
				//print_r($data_list);exit;
				$exam_result_id = $this->Common_Model->dbinsertid("conduct", $data_list);
				$this->session->set_flashdata('success', 'Conduct certificate added successfully.' );
				redirect('cca/add_conduct');
			}else{
				$this->session->set_flashdata('error', validation_errors());
			}
		}
		$data['activemenu'] 	= 'conduct';
		$data['activesubmenu'] 	= 'add_conduct';
		$data['sessions'] 		= $this->Common_Model->FetchData("sessions", "*", "1 ORDER BY session_id DESC");
		$data['classes'] 		= $this->Common_Model->FetchData("classes", "*", "1 ORDER BY class_name ASC");
		$data['ccas'] 			= $this->Common_Model->FetchData("cca", "*", "1 ORDER BY cca_name DESC");
		//$data['positions'] 		= $this->Common_Model->FetchData("positions", "*", "1 ORDER BY position_name ASC");
		$this->load->view('cca/add_conduct', $data);
	}

	function list_conduct(){
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$data['per_page'] = $per_page = isset($_REQUEST['per_page']) ? $_REQUEST['per_page'] : 10;
		$data['page'] = $page = isset($_REQUEST['page']) ? $_REQUEST['page'] : '1';
		$this->load->helper('url');
		$currentURL = current_url();
		$sql = "1";		
		$urlvars = '';
		
		if(isset($_REQUEST['session_id']) && $_REQUEST['session_id'] != ''){
			$sql.= " AND r.session_id = '".$_REQUEST['session_id']."'";
			$urlvars.= "&session_id=".$_REQUEST['session_id'];
		}

		if(isset($_REQUEST['class_id']) && $_REQUEST['class_id'] != ''){
			$sql.= " AND r.class_id = '".$_REQUEST['class_id']."'";
			$urlvars.= "&class_id=".$_REQUEST['class_id'];
		}

		if(isset($_REQUEST['student_id']) && $_REQUEST['student_id'] != ''){
			$sql.= " AND r.student_id = '".$_REQUEST['student_id']."'";
			$urlvars.= "&student_id=".$_REQUEST['student_id'];
		}

		if(isset($_REQUEST['created_on_from']) && $_REQUEST['created_on_from'] != ''){
			$sql.= " AND r.created_on >= '".$_REQUEST['created_on_from']."'";
			$urlvars.= "&created_on_from=".$_REQUEST['created_on_from'];
		}
		
		if(isset($_REQUEST['created_on_to']) && $_REQUEST['created_on_to'] != ''){
			$sql.= " AND r.created_on <= '".$_REQUEST['created_on_to']."'";
			$urlvars.= "&created_on_to=".$_REQUEST['created_on_to'];
		}
		if(isset($_REQUEST['cca_name']) && $_REQUEST['cca_name'] != ''){
			$sql.= " AND r.cca_name LIKE '%".$_REQUEST['cca_name']."%'";
			$urlvars.= "&cca_name=".$_REQUEST['cca_name'];
		}
		if(isset($_REQUEST['cca_position']) && $_REQUEST['cca_position'] != ''){
			$sql.= " AND r.cca_position LIKE '%".$_REQUEST['cca_position']."%'";
			$urlvars.= "&cca_position=".$_REQUEST['cca_position'];
		}
		if(isset($_REQUEST['cca_date']) && $_REQUEST['cca_date'] != ''){
			$sql.= " AND r.cca_date = '".$_REQUEST['cca_date']."'";
			$urlvars.= "&cca_date=".$_REQUEST['cca_date'];
		}

		$sSql = "SELECT COUNT(*) as num FROM conduct AS r LEFT JOIN sessions AS s ON r.session_id = s.session_id LEFT JOIN classes AS c ON r.class_id = c.class_id LEFT JOIN students AS st ON r.student_id = st.student_id WHERE $sql";
		$records = $this->Common_Model->db_query($sSql);
		$totalrecords = $records[0]['num'];
		if($totalrecords){
			$sSql = "SELECT s.session_name, c.class_name, r.id, r.student_id, r.student_name, r.class_id, r.cca_date, r.created_on, r.session_id, st.student_first_name, st.student_last_name FROM conduct AS r LEFT JOIN classes AS c ON r.class_id = c.class_id LEFT JOIN students AS st ON r.student_id = st.student_id LEFT JOIN sessions AS s ON r.session_id = s.session_id WHERE $sql ORDER BY r.created_on DESC";
			$this->load->library("Paginator");
			$this->paginator->setparam(array("page_num" => $page, "num_rows" => $totalrecords));
			$this->paginator->set_Limit($per_page);

			$range1 = $this->paginator->getRange1();
			$range2 = $this->paginator->getRange2();
			$sSql .= " LIMIT ".$range1.', '.$range2;
			$records = $this->Common_Model->db_query($sSql);
			$queryvars = "per_page=$per_page".$urlvars;
			$paging_info = $this->paginator->DBPagingNav($queryvars, $currentURL);
			$aData['tot_page'] = $paging_info[0];
			$aData['pages'] = $paging_info[1];
			$data['sPages'] = $aData['pages'];
			$data['records'] = $records;
			$data['norecords'] = FALSE;
		}else{
			$data['records'] = 0;
		}

		$data['sessions'] = $this->Common_Model->FetchData("sessions", "*", "1 ORDER BY active_session DESC");
		$data['classes'] = $this->Common_Model->FetchData("classes", "*", "1 ORDER BY class_name ASC");
		$data['activemenu'] = 'conduct';
		$data['activesubmenu'] = 'list_conduct';
		$this->load->view('cca/list_conduct', $data);
	}


	function view_conduct($id = 0){
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$sSql = "SELECT s.session_name, c.class_name, r.id, r.student_id, r.student_name, r.from_cls, r.class_id, r.cca_date, r.created_on, r.session_id, sa.admission_id, st.father_name, st.mother_name, st.student_first_name, st.student_last_name FROM conduct AS r LEFT JOIN classes AS c ON r.class_id = c.class_id LEFT JOIN students AS st ON r.student_id = st.student_id LEFT JOIN student_admission AS sa ON r.student_id = sa.student_id LEFT JOIN sessions AS s ON r.session_id = s.session_id WHERE id=$id";
		$transferdata = $this->Common_Model->db_query($sSql);
		$sel = $this->Common_Model->db_query("SELECT class_name FROM classes WHERE class_id=".$transferdata[0]['from_cls']);
		$data['transferdata'] = $transferdata;		
		//error_reporting(0);
		//ini_set('display_error', -1);
		header('Content-Type: image/png');
		$imgPath = realpath(APPPATH.'../assets/0002.jpeg');
	    $im = imagecreatefromjpeg($imgPath);
		$black = imagecolorallocate($im, 0, 0, 0);
		$font1 = realpath(APPPATH.'../assets/Pacifico.ttf');
		$font = realpath(APPPATH.'../assets/AlexBrush-Regular.ttf');

	    imagettftext($im, 22, 0, 578, 334, $black, $font, $transferdata[0]['student_first_name'].' '.$transferdata[0]['student_last_name']);
		imagettftext($im, 20, 0, 765, 370, $black, $font, $transferdata[0]['father_name']);
		imagettftext($im, 20, 0, 345, 370, $black, $font, $transferdata[0]['mother_name']);
		imagettftext($im, 18, 0, 205, 570, $black, $font, $transferdata[0]['session_name']);
		imagettftext($im, 18, 0, 415, 450, $black, $font, $transferdata[0]['admission_id']);
		imagettftext($im, 18, 0, 515, 485, $black, $font, $transferdata[0]['class_name']);
		imagettftext($im, 18, 0, 355, 485, $black, $font, $sel[0]['class_name']);
		imagettftext($im, 19, 0, 175, 740, $black, $font, date('d-m-Y',strtotime($transferdata[0]['cca_date'])));
		//$session = explode('-', $examdata[0]['session_name']);
		imagettftext($im, 23, 0, 405, 614, $black, $font1, $session[0]);
		imagettftext($im, 23, 0, 515, 614, $black, $font1, $session[1]);
		//imagettftext($im, 20, 0, 10, 20, $black, $font, $text);
		imagepng($im);
		imagedestroy($im);
	}

	public function add_idcard(){
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		if($this->input->post('submitBtn')){
			$this->form_validation->set_rules('session_id', 'Session', 'trim|required');
			$this->form_validation->set_error_delimiters('<p class="has-error"><label class="control-label">', '</label></p>');
			if($this->form_validation->run()){
				$student = $this->Common_Model->FetchData("students", "*", "student_id = ".$this->input->post('student_id'));
				$data_list = array(
					'session_id'					=> $this->input->post('session_id'),
					'class_id'					=> $this->input->post('class_id'),
					'student_name'					=> $student[0]['student_first_name'].' '.$student[0]['student_last_name'],					
					'father_name'					=> $this->input->post('parent_name'),
					'mother_name'					=> $this->input->post('mother_name'),
					'contact_no'					=> $this->input->post('parent_mobile'),
					'dob'						=> $this->input->post('student_dob'),
					'student_bloodgroup'				=> $this->input->post('student_bloodgroup'),
					//'created_on'					=> date("Y-m-d H:i:s"),
					'student_id'					=> $this->input->post('student_id'),
					'pht'				=> $this->input->post('pht')
				);

				if($_FILES['student_profile']['name']!=""){
						$newfile = preg_replace('/\W+/', '-', strtolower($_FILES['student_profile']['name'])).uniqid();
						$config = array(
							'upload_path' => "uploads/studentdata/",
							'allowed_types' => 'pdf|doc|docx|jpg|png|jpeg',
							'overwrite' => TRUE,
							'file_name' => $newfile,
							'max_size' => "200048000" 
						);

						$this->load->library('upload', $config);
						$this->upload->initialize($config);
						if($this->upload->do_upload("student_profile"))
						{
							$dat = $this->upload->data();
							$data_list['student_profile'] = $dat['file_name'];
						}else{
							$filename = '';
							$this->session->set_flashdata('error', $this->upload->display_errors());
							redirect($_SERVER['HTTP_REFERER']);
						}
					}else{ $data_list['student_profile'] = '';}
	
				

				//print_r($data_list);exit;
				$exam_result_id = $this->Common_Model->dbinsertid("id_card", $data_list);
				$this->session->set_flashdata('success', 'Icard added successfully.' );
				redirect('cca/add_idcard');
			}else{
				$this->session->set_flashdata('error', validation_errors());
			}
		}
		$data['activemenu'] 	= 'idcard';
		$data['activesubmenu'] 	= 'add_idcard';
		$data['sessions'] 		= $this->Common_Model->FetchData("sessions", "*", "1 ORDER BY session_id DESC");
		$data['classes'] 		= $this->Common_Model->FetchData("classes", "*", "1 ORDER BY class_name ASC");
		$data['ccas'] 			= $this->Common_Model->FetchData("cca", "*", "1 ORDER BY cca_name DESC");
		//$data['positions'] 		= $this->Common_Model->FetchData("positions", "*", "1 ORDER BY position_name ASC");
		$this->load->view('cca/add_idcard', $data);
	}

	function list_idcard(){
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$data['per_page'] = $per_page = isset($_REQUEST['per_page']) ? $_REQUEST['per_page'] : 10;
		$data['page'] = $page = isset($_REQUEST['page']) ? $_REQUEST['page'] : '1';
		$this->load->helper('url');
		$currentURL = current_url();
		$sql = "1";		
		$urlvars = '';
		
		if(isset($_REQUEST['session_id']) && $_REQUEST['session_id'] != ''){
			$sql.= " AND r.session_id = '".$_REQUEST['session_id']."'";
			$urlvars.= "&session_id=".$_REQUEST['session_id'];
		}

		if(isset($_REQUEST['class_id']) && $_REQUEST['class_id'] != ''){
			$sql.= " AND r.class_id = '".$_REQUEST['class_id']."'";
			$urlvars.= "&class_id=".$_REQUEST['class_id'];
		}

		if(isset($_REQUEST['student_id']) && $_REQUEST['student_id'] != ''){
			$sql.= " AND r.student_id = '".$_REQUEST['student_id']."'";
			$urlvars.= "&student_id=".$_REQUEST['student_id'];
		}

		
		$sSql = "SELECT COUNT(*) as num FROM id_card AS r LEFT JOIN sessions AS s ON r.session_id = s.session_id LEFT JOIN classes AS c ON r.class_id = c.class_id LEFT JOIN students AS st ON r.student_id = st.student_id WHERE $sql";
		$records = $this->Common_Model->db_query($sSql);
		$totalrecords = $records[0]['num'];
		if($totalrecords){
			$sSql = "SELECT s.session_name, c.class_name, r.id, r.student_id, r.student_name, r.class_id, r.session_id, st.student_first_name, st.student_last_name FROM id_card AS r LEFT JOIN classes AS c ON r.class_id = c.class_id LEFT JOIN students AS st ON r.student_id = st.student_id LEFT JOIN sessions AS s ON r.session_id = s.session_id WHERE $sql ORDER BY r.id DESC";
			$this->load->library("Paginator");
			$this->paginator->setparam(array("page_num" => $page, "num_rows" => $totalrecords));
			$this->paginator->set_Limit($per_page);

			$range1 = $this->paginator->getRange1();
			$range2 = $this->paginator->getRange2();
			$sSql .= " LIMIT ".$range1.', '.$range2;
			$records = $this->Common_Model->db_query($sSql);
			$queryvars = "per_page=$per_page".$urlvars;
			$paging_info = $this->paginator->DBPagingNav($queryvars, $currentURL);
			$aData['tot_page'] = $paging_info[0];
			$aData['pages'] = $paging_info[1];
			$data['sPages'] = $aData['pages'];
			$data['records'] = $records;
			$data['norecords'] = FALSE;
		}else{
			$data['records'] = 0;
		}

		$data['sessions'] = $this->Common_Model->FetchData("sessions", "*", "1 ORDER BY active_session DESC");
		$data['classes'] = $this->Common_Model->FetchData("classes", "*", "1 ORDER BY class_name ASC");
		$data['activemenu'] = 'idcard';
		$data['activesubmenu'] = 'list_idcard';
		$this->load->view('cca/list_idcard', $data);
	}

	function view_icard($id = 0){
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$sSql = "SELECT s.session_name, c.class_name, r.id, r.student_id, r.student_bloodgroup, r.student_name, r.class_id, r.session_id, r.father_name, r.dob, r.mother_name, r.contact_no, r.student_profile FROM id_card AS r LEFT JOIN classes AS c ON r.class_id = c.class_id LEFT JOIN students AS st ON r.student_id = st.student_id LEFT JOIN sessions AS s ON r.session_id = s.session_id WHERE id=$id";
		$transferdata = $this->Common_Model->db_query($sSql);
		$data['transferdata'] = $transferdata;		
		error_reporting(0);
		ini_set('display_error', -1);
		//$html = $this->load->view('student/view_tc', $data, TRUE);
		$this->load->library('Dompdffile');
		$this->dompdffile->load_view('cca/view_icard', $data);
	}

	function delete_icard($id=0){
		$this->Common_Model->DelData("id_card","id = ".$id);
		$this->session->set_flashdata('success','Delete successfully');
		redirect('cca/list_idcard');
	}

	function edit_conduct($id = 0){
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		if($this->input->post('submitBtn')){
			$this->form_validation->set_rules('session_id', 'Session', 'trim|required');			
			$this->form_validation->set_error_delimiters('<p class="has-error"><label class="control-label">', '</label></p>');
			if($this->form_validation->run()){
				$data_list = array(
					'session_id'					=> $this->input->post('session_id'),
					'class_id'						=> $this->input->post('class_id'),
					'student_name'					=> $this->input->post('student_id'),				
					'parent_name'					=> $this->input->post('parent_name'),
					'cca_date'						=> $this->input->post('cca_date'),
					'created_on'					=> date("Y-m-d H:i:s")
				);
	//print_r($data_list);exit;
				$id = $this->Common_Model->update_records("conduct", "id", $id, $data_list);
				$this->session->set_flashdata('success', 'Conduct certificate updated successfully.');
				redirect($_SERVER['HTTP_REFERER']);
			}else{
				$this->session->set_flashdata('error', validation_errors());
			}
		}
		$data['activemenu'] = 'conduct';
		$data['activesubmenu'] = 'edit_conduct';
		$data['sessions'] = $this->Common_Model->FetchData("sessions", "*", "1 ORDER BY session_id DESC");
		$data['rec'] = $this->Common_Model->FetchData("conduct", "*", "id = ".$id);
		$data['classes'] = $this->Common_Model->FetchData("classes", "*", "1 ORDER BY class_name ASC");
		$data['ccas'] 			= $this->Common_Model->FetchData("cca", "*", "1 ORDER BY cca_name DESC");		
		$this->load->view('cca/edit_conduct', $data);
	}

	function edit_icard($id = 0){
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		if($this->input->post('submitBtn')){
			$this->form_validation->set_rules('session_id', 'Session', 'trim|required');			
			$this->form_validation->set_error_delimiters('<p class="has-error"><label class="control-label">', '</label></p>');
			if($this->form_validation->run()){
				$data_list = array(
					'session_id'					=> $this->input->post('session_id'),
					'class_id'						=> $this->input->post('class_id'),
					'student_name'					=> $this->input->post('student_id'),				
					'father_name'					=> $this->input->post('parent_name'),
					'mother_name'					=> $this->input->post('mother_name'),
					'contact_no'					=> $this->input->post('parent_mobile'),
					'dob'							=> $this->input->post('student_dob')
					//'student_id'					=> $this->input->post('student_id')
				);

				if($_FILES['student_profile']['name']!=""){
						$newfile = preg_replace('/\W+/', '-', strtolower($_FILES['student_profile']['name'])).uniqid();
						$config = array(
							'upload_path' => "uploads/studentdata/",
							'allowed_types' => 'pdf|doc|docx|jpg|png|jpeg',
							'overwrite' => TRUE,
							'file_name' => $newfile,
							'max_size' => "200048000" 
						);

						$this->load->library('upload', $config);
						$this->upload->initialize($config);
						if($this->upload->do_upload("student_profile"))
						{
							$dat = $this->upload->data();
							$data_list['student_profile'] = $dat['file_name'];
						}else{
							$filename = '';
							$this->session->set_flashdata('error', $this->upload->display_errors());
							redirect($_SERVER['HTTP_REFERER']);
						}
					}else{ $data_list['student_profile'] = '';}
	//print_r($data_list);exit;
				$id = $this->Common_Model->update_records("id_card", "id", $id, $data_list);
				$this->session->set_flashdata('success', 'Conduct certificate updated successfully.');
				redirect($_SERVER['HTTP_REFERER']);
			}else{
				$this->session->set_flashdata('error', validation_errors());
			}
		}
		$data['activemenu'] = 'idcard';
		$data['activesubmenu'] = 'edit_icard';
		$data['sessions'] = $this->Common_Model->FetchData("sessions", "*", "1 ORDER BY session_id DESC");
		$data['rec'] = $this->Common_Model->FetchData("id_card", "*", "id = ".$id);
		$data['classes'] = $this->Common_Model->FetchData("classes", "*", "1 ORDER BY class_name ASC");
		$data['ccas'] 			= $this->Common_Model->FetchData("cca", "*", "1 ORDER BY cca_name DESC");		
		$this->load->view('cca/edit_icard', $data); 
	}


	public function addccagroup(){
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		if($this->input->post('submitBtn')){
			$this->form_validation->set_rules('session_id', 'Session', 'trim|required');
			$this->form_validation->set_error_delimiters('<p class="has-error"><label class="control-label">', '</label></p>');
			if($this->form_validation->run()){				
				$data_list = array(
					'session_id'					=> $this->input->post('session_id'),
					'class_id'						=> $this->input->post('class_id'),
					'cgrp'							=> $this->input->post('cca_group')
				);
				$exam_result_id = $this->Common_Model->dbinsertid("ccagroups", $data_list);
				$this->session->set_flashdata('success', 'CCA group added successfully.' );
				redirect($_SERVER['HTTP_REFERER']);
			}else{
				$this->session->set_flashdata('error', validation_errors());
			}
		}
		$data['activemenu'] 	= 'cca';
		$data['activesubmenu'] 	= 'addccagroup';
		$data['sessions'] 		= $this->Common_Model->FetchData("sessions", "*", "1 ORDER BY session_id DESC");
		$data['classes'] 		= $this->Common_Model->FetchData("classes", "*", "1 ORDER BY class_name ASC");
		
		$this->load->view('cca/add_group', $data);
	}

    function cca_result(){
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$data['per_page'] = $per_page = isset($_REQUEST['per_page']) ? $_REQUEST['per_page'] : 10;
		$data['page'] = $page = isset($_REQUEST['page']) ? $_REQUEST['page'] : '1';
		$this->load->helper('url');
		$currentURL = current_url();
		$sql = "1";
		
		$urlvars = '';
		
		if(isset($_REQUEST['session_id']) && $_REQUEST['session_id'] != ''){
			$sql.= " AND r.session_id = '".$_REQUEST['session_id']."'";
			$urlvars.= "&session_id=".$_REQUEST['session_id'];
		}

		if(isset($_REQUEST['class_id']) && $_REQUEST['class_id'] != ''){
			$sql.= " AND r.class_id = '".$_REQUEST['class_id']."'";
			$urlvars.= "&class_id=".$_REQUEST['class_id'];
		}

		if(isset($_REQUEST['student_id']) && $_REQUEST['student_id'] != ''){
			$sql.= " AND r.student_id = '".$_REQUEST['student_id']."'";
			$urlvars.= "&student_id=".$_REQUEST['student_id'];
		}

		if(isset($_REQUEST['student_section']) && $_REQUEST['student_section'] != ''){
			$sql.= " AND r.section_id = '".$_REQUEST['student_section']."'";
			$urlvars.= "&student_section=".$_REQUEST['student_section'];
		}

		if(isset($_REQUEST['created_on_from']) && $_REQUEST['created_on_from'] != ''){
			$sql.= " AND r.created_on >= '".$_REQUEST['created_on_from']."'";
			$urlvars.= "&created_on_from=".$_REQUEST['created_on_from'];
		}
		
		if(isset($_REQUEST['created_on_to']) && $_REQUEST['created_on_to'] != ''){
			$sql.= " AND r.created_on <= '".$_REQUEST['created_on_to']."'";
			$urlvars.= "&created_on_to=".$_REQUEST['created_on_to'];
		}
		if(isset($_REQUEST['cca_name']) && $_REQUEST['cca_name'] != ''){
			$sql.= " AND r.cca_id LIKE '%".$_REQUEST['cca_name']."%'";
			$urlvars.= "&cca_name=".$_REQUEST['cca_name'];
		}
		if(isset($_REQUEST['cca_type']) && $_REQUEST['cca_type'] != ''){
			$sql.= " AND r.cca_type LIKE '%".$_REQUEST['cca_type']."%'";
			$urlvars.= "&cca_type=".$_REQUEST['cca_type'];
		}
		if(isset($_REQUEST['cca_date']) && $_REQUEST['cca_date'] != ''){
			$sql.= " AND r.cca_date = '".$_REQUEST['cca_date']."'";
			$urlvars.= "&cca_date=".$_REQUEST['cca_date'];
		}

		$sSql = "SELECT COUNT(*) as num FROM cca_records AS r LEFT JOIN sessions AS s ON r.session_id = s.session_id LEFT JOIN classes AS c ON r.class_id = c.class_id LEFT JOIN students AS st ON r.student_id = st.student_id WHERE $sql";
		$records = $this->Common_Model->db_query($sSql);
		$totalrecords = $records[0]['num'];
		if($totalrecords){
			$sSql = "SELECT s.session_name, c.class_name, r.id, ca.cca_name, r.student_id, r.student_name, r.cca_position, p.position_name, r.class_id, r.cca_date, r.created_on, r.session_id, r.house_no, sec.section_name, cg.gid, cg.cgrp, st.student_first_name, st.student_last_name FROM cca_records AS r INNER JOIN cca AS ca ON r.cca_id = ca.cca_id LEFT JOIN ccagroups AS cg ON r.cca_group = cg.gid LEFT JOIN sessions AS s ON r.session_id = s.session_id LEFT JOIN classes AS c ON r.class_id = c.class_id LEFT JOIN sections AS sec ON r.section_id = sec.section_id LEFT JOIN students AS st ON r.student_id = st.student_id LEFT JOIN positions AS p ON r.cca_position = p.position_id WHERE $sql GROUP BY r.cca_group ASC";
			$this->load->library("Paginator");
			$this->paginator->setparam(array("page_num" => $page, "num_rows" => $totalrecords));
			$this->paginator->set_Limit($per_page);

			$range1 = $this->paginator->getRange1();
			$range2 = $this->paginator->getRange2();
			$sSql .= " LIMIT ".$range1.', '.$range2;
			$records = $this->Common_Model->db_query($sSql);
			$queryvars = "per_page=$per_page".$urlvars;
			$paging_info = $this->paginator->DBPagingNav($queryvars, $currentURL);
			$aData['tot_page'] = $paging_info[0];
			$aData['pages'] = $paging_info[1];
			$data['sPages'] = $aData['pages'];
			$data['records'] = $records;
			$data['norecords'] = FALSE;
		}else{
			$data['records'] = 0;
		}

		$data['sessions'] = $this->Common_Model->FetchData("sessions", "*", "1 ORDER BY active_session DESC");
		$data['classes'] = $this->Common_Model->FetchData("classes", "*", "1 ORDER BY class_name ASC");
		$data['cca'] = $this->Common_Model->FetchData("cca", "*", "1 ORDER BY cca_name ASC");
		$data['activemenu'] = 'cca';
		$data['activesubmenu'] = 'cca_result';
		$this->load->view('cca/cca_result', $data);
	}


	function view_resultcca(){
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$data['per_page'] = $per_page = isset($_REQUEST['per_page']) ? $_REQUEST['per_page'] : 10;
		$data['page'] = $page = isset($_REQUEST['page']) ? $_REQUEST['page'] : '1';
		$this->load->helper('url');
		$currentURL = current_url();
		$sql = "1 AND r.cca_type = 'Position'";
		
		$urlvars = '';
		
		if(isset($_REQUEST['session_id']) && $_REQUEST['session_id'] != ''){
			$sql.= " AND r.session_id = '".$_REQUEST['session_id']."'";
			$urlvars.= "&session_id=".$_REQUEST['session_id'];
		}

		if(isset($_REQUEST['class_id']) && $_REQUEST['class_id'] != ''){
			$sql.= " AND r.class_id = '".$_REQUEST['class_id']."'";
			$urlvars.= "&class_id=".$_REQUEST['class_id'];
		}

		if(isset($_REQUEST['student_id']) && $_REQUEST['student_id'] != ''){
			$sql.= " AND r.student_id = '".$_REQUEST['student_id']."'";
			$urlvars.= "&student_id=".$_REQUEST['student_id'];
		}

		if(isset($_REQUEST['student_section']) && $_REQUEST['student_section'] != ''){
			$sql.= " AND r.section_id = '".$_REQUEST['student_section']."'";
			$urlvars.= "&student_section=".$_REQUEST['student_section'];
		}

		if(isset($_REQUEST['created_on_from']) && $_REQUEST['created_on_from'] != ''){
			$sql.= " AND r.created_on >= '".$_REQUEST['created_on_from']."'";
			$urlvars.= "&created_on_from=".$_REQUEST['created_on_from'];
		}
		
		if(isset($_REQUEST['created_on_to']) && $_REQUEST['created_on_to'] != ''){
			$sql.= " AND r.created_on <= '".$_REQUEST['created_on_to']."'";
			$urlvars.= "&created_on_to=".$_REQUEST['created_on_to'];
		}
		if(isset($_REQUEST['cca_name']) && $_REQUEST['cca_name'] != ''){
			$sql.= " AND r.cca_id LIKE '%".$_REQUEST['cca_name']."%'";
			$urlvars.= "&cca_name=".$_REQUEST['cca_name'];
		}
		if(isset($_REQUEST['cca_type']) && $_REQUEST['cca_type'] != ''){
			$sql.= " AND r.cca_type LIKE '%".$_REQUEST['cca_type']."%'";
			$urlvars.= "&cca_type=".$_REQUEST['cca_type'];
		}
		if(isset($_REQUEST['cca_date']) && $_REQUEST['cca_date'] != ''){
			$sql.= " AND r.cca_date = '".$_REQUEST['cca_date']."'";
			$urlvars.= "&cca_date=".$_REQUEST['cca_date'];
		}

		$sSql = "SELECT s.session_name, c.class_name, r.id, ca.cca_name, r.student_id, r.student_name, r.cca_position, p.position_name, r.class_id, r.cca_date, r.created_on, r.session_id, r.house_no, sec.section_name, cg.gid, cg.cgrp, st.student_first_name, st.student_last_name FROM cca_records AS r INNER JOIN cca AS ca ON r.cca_id = ca.cca_id LEFT JOIN ccagroups AS cg ON r.cca_group = cg.gid LEFT JOIN sessions AS s ON r.session_id = s.session_id LEFT JOIN classes AS c ON r.class_id = c.class_id LEFT JOIN sections AS sec ON r.section_id = sec.section_id LEFT JOIN students AS st ON r.student_id = st.student_id LEFT JOIN positions AS p ON r.cca_position = p.position_id WHERE $sql ORDER BY r.created_on DESC";
			$records = $this->Common_Model->db_query($sSql);
			$data['records'] = 	$records;		
			error_reporting(0);
			ini_set('display_error', -1);
			//$html = $this->load->view('student/view_tc', $data, TRUE);
			$this->load->library('Dompdffile');
			$this->dompdffile->load_view('cca/view_resultcca', $data);
	}
	
	function cca_monthreport(){
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$data['per_page'] = $per_page = isset($_REQUEST['per_page']) ? $_REQUEST['per_page'] : 10;
		$data['page'] = $page = isset($_REQUEST['page']) ? $_REQUEST['page'] : '1';
		$this->load->helper('url');
		$currentURL = current_url();
		$sql = "1";
		
		$urlvars = '';
		
		if(isset($_REQUEST['session_id']) && $_REQUEST['session_id'] != ''){
			$sql.= " AND r.session_id = '".$_REQUEST['session_id']."'";
			$urlvars.= "&session_id=".$_REQUEST['session_id'];
		}

		

		if(isset($_REQUEST['created_on_from']) && $_REQUEST['created_on_from'] != ''){
			$sql.= " AND r.cca_date >= '".$_REQUEST['created_on_from']."'";
			$urlvars.= "&created_on_from=".$_REQUEST['created_on_from'];
		}
		
		if(isset($_REQUEST['created_on_to']) && $_REQUEST['created_on_to'] != ''){
			$sql.= " AND r.cca_date <= '".$_REQUEST['created_on_to']."'";
			$urlvars.= "&created_on_to=".$_REQUEST['created_on_to'];
		}
		

		if($this->input->get('downtotBtn')){
			$records = $this->Common_Model->db_query("SELECT COUNT(*) as num, s.session_name, c.class_name, r.id, ca.cca_name, r.student_id, r.student_name, r.cca_position, p.position_name, r.class_id, r.cca_date, r.created_on, r.session_id, r.house_no, sec.section_name, cg.gid, cg.cgrp, st.student_first_name, st.student_last_name FROM cca_records AS r INNER JOIN cca AS ca ON r.cca_id = ca.cca_id LEFT JOIN ccagroups AS cg ON r.cca_group = cg.gid LEFT JOIN sessions AS s ON r.session_id = s.session_id LEFT JOIN classes AS c ON r.class_id = c.class_id LEFT JOIN sections AS sec ON r.section_id = sec.section_id LEFT JOIN students AS st ON r.student_id = st.student_id LEFT JOIN positions AS p ON r.cca_position = p.position_id WHERE $sql AND r.class_id = 30 ORDER BY r.created_on ASC");
			$records1 = $this->Common_Model->db_query("SELECT COUNT(*) as num, s.session_name, c.class_name, r.id, ca.cca_name, r.student_id, r.student_name, r.cca_position, p.position_name, r.class_id, r.cca_date, r.created_on, r.session_id, r.house_no, sec.section_name, cg.gid, cg.cgrp, st.student_first_name, st.student_last_name FROM cca_records AS r INNER JOIN cca AS ca ON r.cca_id = ca.cca_id LEFT JOIN ccagroups AS cg ON r.cca_group = cg.gid LEFT JOIN sessions AS s ON r.session_id = s.session_id LEFT JOIN classes AS c ON r.class_id = c.class_id LEFT JOIN sections AS sec ON r.section_id = sec.section_id LEFT JOIN students AS st ON r.student_id = st.student_id LEFT JOIN positions AS p ON r.cca_position = p.position_id WHERE $sql AND r.class_id = 31 ORDER BY r.created_on ASC");
			$records2 = $this->Common_Model->db_query("SELECT COUNT(*) as num, s.session_name, c.class_name, r.id, ca.cca_name, r.student_id, r.student_name, r.cca_position, p.position_name, r.class_id, r.cca_date, r.created_on, r.session_id, r.house_no, sec.section_name, cg.gid, cg.cgrp, st.student_first_name, st.student_last_name FROM cca_records AS r INNER JOIN cca AS ca ON r.cca_id = ca.cca_id LEFT JOIN ccagroups AS cg ON r.cca_group = cg.gid LEFT JOIN sessions AS s ON r.session_id = s.session_id LEFT JOIN classes AS c ON r.class_id = c.class_id LEFT JOIN sections AS sec ON r.section_id = sec.section_id LEFT JOIN students AS st ON r.student_id = st.student_id LEFT JOIN positions AS p ON r.cca_position = p.position_id WHERE $sql AND r.class_id = 32 ORDER BY r.created_on ASC");
			$records3 = $this->Common_Model->db_query("SELECT COUNT(*) as num, s.session_name, c.class_name, r.id, ca.cca_name, r.student_id, r.student_name, r.cca_position, p.position_name, r.class_id, r.cca_date, r.created_on, r.session_id, r.house_no, sec.section_name, cg.gid, cg.cgrp, st.student_first_name, st.student_last_name FROM cca_records AS r INNER JOIN cca AS ca ON r.cca_id = ca.cca_id LEFT JOIN ccagroups AS cg ON r.cca_group = cg.gid LEFT JOIN sessions AS s ON r.session_id = s.session_id LEFT JOIN classes AS c ON r.class_id = c.class_id LEFT JOIN sections AS sec ON r.section_id = sec.section_id LEFT JOIN students AS st ON r.student_id = st.student_id LEFT JOIN positions AS p ON r.cca_position = p.position_id WHERE $sql AND r.class_id = 33 ORDER BY r.created_on ASC");
			$records4 = $this->Common_Model->db_query("SELECT COUNT(*) as num, s.session_name, c.class_name, r.id, ca.cca_name, r.student_id, r.student_name, r.cca_position, p.position_name, r.class_id, r.cca_date, r.created_on, r.session_id, r.house_no, sec.section_name, cg.gid, cg.cgrp, st.student_first_name, st.student_last_name FROM cca_records AS r INNER JOIN cca AS ca ON r.cca_id = ca.cca_id LEFT JOIN ccagroups AS cg ON r.cca_group = cg.gid LEFT JOIN sessions AS s ON r.session_id = s.session_id LEFT JOIN classes AS c ON r.class_id = c.class_id LEFT JOIN sections AS sec ON r.section_id = sec.section_id LEFT JOIN students AS st ON r.student_id = st.student_id LEFT JOIN positions AS p ON r.cca_position = p.position_id WHERE $sql AND r.class_id = 34 ORDER BY r.created_on ASC");
			$records5 = $this->Common_Model->db_query("SELECT COUNT(*) as num, s.session_name, c.class_name, r.id, ca.cca_name, r.student_id, r.student_name, r.cca_position, p.position_name, r.class_id, r.cca_date, r.created_on, r.session_id, r.house_no, sec.section_name, cg.gid, cg.cgrp, st.student_first_name, st.student_last_name FROM cca_records AS r INNER JOIN cca AS ca ON r.cca_id = ca.cca_id LEFT JOIN ccagroups AS cg ON r.cca_group = cg.gid LEFT JOIN sessions AS s ON r.session_id = s.session_id LEFT JOIN classes AS c ON r.class_id = c.class_id LEFT JOIN sections AS sec ON r.section_id = sec.section_id LEFT JOIN students AS st ON r.student_id = st.student_id LEFT JOIN positions AS p ON r.cca_position = p.position_id WHERE $sql AND r.class_id = 36 ORDER BY r.created_on ASC");
			$records6 = $this->Common_Model->db_query("SELECT COUNT(*) as num, s.session_name, c.class_name, r.id, ca.cca_name, r.student_id, r.student_name, r.cca_position, p.position_name, r.class_id, r.cca_date, r.created_on, r.session_id, r.house_no, sec.section_name, cg.gid, cg.cgrp, st.student_first_name, st.student_last_name FROM cca_records AS r INNER JOIN cca AS ca ON r.cca_id = ca.cca_id LEFT JOIN ccagroups AS cg ON r.cca_group = cg.gid LEFT JOIN sessions AS s ON r.session_id = s.session_id LEFT JOIN classes AS c ON r.class_id = c.class_id LEFT JOIN sections AS sec ON r.section_id = sec.section_id LEFT JOIN students AS st ON r.student_id = st.student_id LEFT JOIN positions AS p ON r.cca_position = p.position_id WHERE $sql AND r.class_id = 37 ORDER BY r.created_on ASC");
			$records7 = $this->Common_Model->db_query("SELECT COUNT(*) as num, s.session_name, c.class_name, r.id, ca.cca_name, r.student_id, r.student_name, r.cca_position, p.position_name, r.class_id, r.cca_date, r.created_on, r.session_id, r.house_no, sec.section_name, cg.gid, cg.cgrp, st.student_first_name, st.student_last_name FROM cca_records AS r INNER JOIN cca AS ca ON r.cca_id = ca.cca_id LEFT JOIN ccagroups AS cg ON r.cca_group = cg.gid LEFT JOIN sessions AS s ON r.session_id = s.session_id LEFT JOIN classes AS c ON r.class_id = c.class_id LEFT JOIN sections AS sec ON r.section_id = sec.section_id LEFT JOIN students AS st ON r.student_id = st.student_id LEFT JOIN positions AS p ON r.cca_position = p.position_id WHERE $sql AND r.class_id = 38 ORDER BY r.created_on ASC");
			$records8 = $this->Common_Model->db_query("SELECT COUNT(*) as num, s.session_name, c.class_name, r.id, ca.cca_name, r.student_id, r.student_name, r.cca_position, p.position_name, r.class_id, r.cca_date, r.created_on, r.session_id, r.house_no, sec.section_name, cg.gid, cg.cgrp, st.student_first_name, st.student_last_name FROM cca_records AS r INNER JOIN cca AS ca ON r.cca_id = ca.cca_id LEFT JOIN ccagroups AS cg ON r.cca_group = cg.gid LEFT JOIN sessions AS s ON r.session_id = s.session_id LEFT JOIN classes AS c ON r.class_id = c.class_id LEFT JOIN sections AS sec ON r.section_id = sec.section_id LEFT JOIN students AS st ON r.student_id = st.student_id LEFT JOIN positions AS p ON r.cca_position = p.position_id WHERE $sql AND r.class_id = 39 ORDER BY r.created_on ASC");
			$records9 = $this->Common_Model->db_query("SELECT COUNT(*) as num, s.session_name, c.class_name, r.id, ca.cca_name, r.student_id, r.student_name, r.cca_position, p.position_name, r.class_id, r.cca_date, r.created_on, r.session_id, r.house_no, sec.section_name, cg.gid, cg.cgrp, st.student_first_name, st.student_last_name FROM cca_records AS r INNER JOIN cca AS ca ON r.cca_id = ca.cca_id LEFT JOIN ccagroups AS cg ON r.cca_group = cg.gid LEFT JOIN sessions AS s ON r.session_id = s.session_id LEFT JOIN classes AS c ON r.class_id = c.class_id LEFT JOIN sections AS sec ON r.section_id = sec.section_id LEFT JOIN students AS st ON r.student_id = st.student_id LEFT JOIN positions AS p ON r.cca_position = p.position_id WHERE $sql AND r.class_id = 40 ORDER BY r.created_on ASC");
			$records10 = $this->Common_Model->db_query("SELECT COUNT(*) as num, s.session_name, c.class_name, r.id, ca.cca_name, r.student_id, r.student_name, r.cca_position, p.position_name, r.class_id, r.cca_date, r.created_on, r.session_id, r.house_no, sec.section_name, cg.gid, cg.cgrp, st.student_first_name, st.student_last_name FROM cca_records AS r INNER JOIN cca AS ca ON r.cca_id = ca.cca_id LEFT JOIN ccagroups AS cg ON r.cca_group = cg.gid LEFT JOIN sessions AS s ON r.session_id = s.session_id LEFT JOIN classes AS c ON r.class_id = c.class_id LEFT JOIN sections AS sec ON r.section_id = sec.section_id LEFT JOIN students AS st ON r.student_id = st.student_id LEFT JOIN positions AS p ON r.cca_position = p.position_id WHERE $sql AND r.class_id = 41 ORDER BY r.created_on ASC");
			$records11 = $this->Common_Model->db_query("SELECT COUNT(*) as num, s.session_name, c.class_name, r.id, ca.cca_name, r.student_id, r.student_name, r.cca_position, p.position_name, r.class_id, r.cca_date, r.created_on, r.session_id, r.house_no, sec.section_name, cg.gid, cg.cgrp, st.student_first_name, st.student_last_name FROM cca_records AS r INNER JOIN cca AS ca ON r.cca_id = ca.cca_id LEFT JOIN ccagroups AS cg ON r.cca_group = cg.gid LEFT JOIN sessions AS s ON r.session_id = s.session_id LEFT JOIN classes AS c ON r.class_id = c.class_id LEFT JOIN sections AS sec ON r.section_id = sec.section_id LEFT JOIN students AS st ON r.student_id = st.student_id LEFT JOIN positions AS p ON r.cca_position = p.position_id WHERE $sql AND r.class_id = 42 ORDER BY r.created_on ASC");
			$records12 = $this->Common_Model->db_query("SELECT COUNT(*) as num, s.session_name, c.class_name, r.id, ca.cca_name, r.student_id, r.student_name, r.cca_position, p.position_name, r.class_id, r.cca_date, r.created_on, r.session_id, r.house_no, sec.section_name, cg.gid, cg.cgrp, st.student_first_name, st.student_last_name FROM cca_records AS r INNER JOIN cca AS ca ON r.cca_id = ca.cca_id LEFT JOIN ccagroups AS cg ON r.cca_group = cg.gid LEFT JOIN sessions AS s ON r.session_id = s.session_id LEFT JOIN classes AS c ON r.class_id = c.class_id LEFT JOIN sections AS sec ON r.section_id = sec.section_id LEFT JOIN students AS st ON r.student_id = st.student_id LEFT JOIN positions AS p ON r.cca_position = p.position_id WHERE $sql AND r.class_id = 43 ORDER BY r.created_on ASC");
			$records13 = $this->Common_Model->db_query("SELECT COUNT(*) as num, s.session_name, c.class_name, r.id, ca.cca_name, r.student_id, r.student_name, r.cca_position, p.position_name, r.class_id, r.cca_date, r.created_on, r.session_id, r.house_no, sec.section_name, cg.gid, cg.cgrp, st.student_first_name, st.student_last_name FROM cca_records AS r INNER JOIN cca AS ca ON r.cca_id = ca.cca_id LEFT JOIN ccagroups AS cg ON r.cca_group = cg.gid LEFT JOIN sessions AS s ON r.session_id = s.session_id LEFT JOIN classes AS c ON r.class_id = c.class_id LEFT JOIN sections AS sec ON r.section_id = sec.section_id LEFT JOIN students AS st ON r.student_id = st.student_id LEFT JOIN positions AS p ON r.cca_position = p.position_id WHERE $sql AND r.class_id = 44 ORDER BY r.created_on ASC");
			$records14 = $this->Common_Model->db_query("SELECT COUNT(*) as num, s.session_name, c.class_name, r.id, ca.cca_name, r.student_id, r.student_name, r.cca_position, p.position_name, r.class_id, r.cca_date, r.created_on, r.session_id, r.house_no, sec.section_name, cg.gid, cg.cgrp, st.student_first_name, st.student_last_name FROM cca_records AS r INNER JOIN cca AS ca ON r.cca_id = ca.cca_id LEFT JOIN ccagroups AS cg ON r.cca_group = cg.gid LEFT JOIN sessions AS s ON r.session_id = s.session_id LEFT JOIN classes AS c ON r.class_id = c.class_id LEFT JOIN sections AS sec ON r.section_id = sec.section_id LEFT JOIN students AS st ON r.student_id = st.student_id LEFT JOIN positions AS p ON r.cca_position = p.position_id WHERE $sql AND r.class_id = 45 ORDER BY r.created_on ASC");
			$records15 = $this->Common_Model->db_query("SELECT COUNT(*) as num, s.session_name, c.class_name, r.id, ca.cca_name, r.student_id, r.student_name, r.cca_position, p.position_name, r.class_id, r.cca_date, r.created_on, r.session_id, r.house_no, sec.section_name, cg.gid, cg.cgrp, st.student_first_name, st.student_last_name FROM cca_records AS r INNER JOIN cca AS ca ON r.cca_id = ca.cca_id LEFT JOIN ccagroups AS cg ON r.cca_group = cg.gid LEFT JOIN sessions AS s ON r.session_id = s.session_id LEFT JOIN classes AS c ON r.class_id = c.class_id LEFT JOIN sections AS sec ON r.section_id = sec.section_id LEFT JOIN students AS st ON r.student_id = st.student_id LEFT JOIN positions AS p ON r.cca_position = p.position_id WHERE $sql AND r.class_id = 46 ORDER BY r.created_on ASC");
			$records16 = $this->Common_Model->db_query("SELECT COUNT(*) as num, s.session_name, c.class_name, r.id, ca.cca_name, r.student_id, r.student_name, r.cca_position, p.position_name, r.class_id, r.cca_date, r.created_on, r.session_id, r.house_no, sec.section_name, cg.gid, cg.cgrp, st.student_first_name, st.student_last_name FROM cca_records AS r INNER JOIN cca AS ca ON r.cca_id = ca.cca_id LEFT JOIN ccagroups AS cg ON r.cca_group = cg.gid LEFT JOIN sessions AS s ON r.session_id = s.session_id LEFT JOIN classes AS c ON r.class_id = c.class_id LEFT JOIN sections AS sec ON r.section_id = sec.section_id LEFT JOIN students AS st ON r.student_id = st.student_id LEFT JOIN positions AS p ON r.cca_position = p.position_id WHERE $sql AND r.class_id = 47 ORDER BY r.created_on ASC");
		if($records){
			$html = '<table border=1> <tr> <th>CCA Date</th><th>Class</th><th>Group</th><th>Name Of The Competition</th><th>Total No. of Participants</th></tr>';
            
            //for($i=0;$i<count($records);$i++){
            	$cnt     	= $records[0]['num'];
            	$cnt1    	= $records1[0]['num'];
            	$cnt2    	= $records2[0]['num'];
            	$cnt3 	 	= $records3[0]['num'];
            	$cnt4 		= $records4[0]['num'];
            	$cnt5 		= $records5[0]['num'];
            	$cnt6 		= $records6[0]['num'];
            	$cnt7 		= $records7[0]['num'];
            	$cnt8 		= $records8[0]['num'];
            	$cnt9 		= $records9[0]['num'];
            	$cnt10 		= $records10[0]['num'];
            	$cnt11 		= $records11[0]['num'];
            	$cnt12 		= $records12[0]['num'];
            	$cnt13 		= $records13[0]['num'];
            	$cnt14 		= $records14[0]['num'];
            	$cnt15		= $records15[0]['num'];
            	$cnt16		= $records16[0]['num'];

            if($cnt > 0){
            	$html.= '<tr><td>'.$records[0]['cca_date'].'</td><td>'.$records[0]['class_name'].'</td><td>'.$records[0]['cgrp'].'</td><td>'.$records[0]['cca_name'].'</td> <td>'.$cnt.'</td></tr>';
            }
            if($cnt1 > 0){
            	$html .='<tr><td>'.$records1[0]['cca_date'].'</td><td>'.$records1[0]['class_name'].'</td><td>'.$records1[0]['cgrp'].'</td><td>'.$records1[0]['cca_name'].'</td> <td>'.$cnt1.'</td></tr>';
            	}
            if($cnt2 > 0){
            	$html .='<tr><td>'.$records2[0]['cca_date'].'</td><td>'.$records2[0]['class_name'].'</td><td>'.$records2[0]['cgrp'].'</td><td>'.$records2[0]['cca_name'].'</td> <td>'.$cnt2.'</td></tr>';
            	}
            if($cnt3 > 0){
            	$html .='<tr><td>'.$records3[0]['cca_date'].'</td><td>'.$records3[0]['class_name'].'</td><td>'.$records3[0]['cgrp'].'</td><td>'.$records3[0]['cca_name'].'</td> <td>'.$cnt3.'</td></tr>';
            	}
            if($cnt4 > 0){
            	$html .='<tr><td>'.$records4[0]['cca_date'].'</td><td>'.$records4[0]['class_name'].'</td><td>'.$records4[0]['cgrp'].'</td><td>'.$records4[0]['cca_name'].'</td> <td>'.$cnt4.'</td></tr>';
            	}
            if($cnt5 > 0){
            	$html .='<tr><td>'.$records5[0]['cca_date'].'</td><td>'.$records5[0]['class_name'].'</td><td>'.$records5[0]['cgrp'].'</td><td>'.$records5[0]['cca_name'].'</td> <td>'.$cnt5.'</td></tr> ';
            	}
            if($cnt6 > 0){
            	$html .='<tr><td>'.$records6[0]['cca_date'].'</td><td>'.$records6[0]['class_name'].'</td><td>'.$records6[0]['cgrp'].'</td><td>'.$records6[0]['cca_name'].'</td> <td>'.$cnt6.'</td></tr>';
            	}
            if($cnt7 > 0){
            	$html .='<tr><td>'.$records7[0]['cca_date'].'</td><td>'.$records7[0]['class_name'].'</td><td>'.$records7[0]['cgrp'].'</td><td>'.$records7[0]['cca_name'].'</td> <td>'.$cnt7.'</td></tr>';
            	}
            if($cnt8 > 0){
            	$html .='<tr><td>'.$records8[0]['cca_date'].'</td><td>'.$records8[0]['class_name'].'</td><td>'.$records8[0]['cgrp'].'</td><td>'.$records8[0]['cca_name'].'</td> <td>'.$cnt8.'</td></tr>';
            	}
            if($cnt9 > 0){
            	$html .='<tr><td>'.$records9[0]['cca_date'].'</td><td>'.$records9[0]['class_name'].'</td><td>'.$records9[0]['cgrp'].'</td><td>'.$records9[0]['cca_name'].'</td> <td>'.$cnt9.'</td></tr>';
            	}
            if($cnt10 > 0){
            	$html .='<tr><td>'.$records10[0]['cca_date'].'</td><td>'.$records10[0]['class_name'].'</td><td>'.$records10[0]['cgrp'].'</td><td>'.$records10[0]['cca_name'].'</td> <td>'.$cnt10.'</td></tr>';
            	}
            if($cnt11 > 0){
            	$html .='<tr><td>'.$records11[0]['cca_date'].'</td><td>'.$records11[0]['class_name'].'</td><td>'.$records11[0]['cgrp'].'</td><td>'.$records11[0]['cca_name'].'</td> <td>'.$cnt11.'</td></tr> ';
            	}
            if($cnt12 > 0){
            	$html .='<tr><td>'.$records12[0]['cca_date'].'</td><td>'.$records12[0]['class_name'].'</td><td>'.$records12[0]['cgrp'].'</td><td>'.$records12[0]['cca_name'].'</td> <td>'.$cnt12.'</td></tr>';
            	}
            if($cnt13 > 0){
            	$html .='<tr><td>'.$records13[0]['cca_date'].'</td><td>'.$records13[0]['class_name'].'</td><td>'.$records13[0]['cgrp'].'</td><td>'.$records13[0]['cca_name'].'</td> <td>'.$cnt13.'</td></tr>';
            	}
            if($cnt14 > 0){
            	$html .= '<tr><td>'.$records14[0]['cca_date'].'</td><td>'.$records14[0]['class_name'].'</td><td>'.$records14[0]['cgrp'].'</td><td>'.$records14[0]['cca_name'].'</td> <td>'.$cnt14.'</td></tr>';
            	}
            if($cnt15 > 0){
            	$html .= '<tr><td>'.$records15[0]['cca_date'].'</td><td>'.$records15[0]['class_name'].'</td><td>'.$records15[0]['cgrp'].'</td><td>'.$records15[0]['cca_name'].'</td> <td>'.$cnt15.'</td></tr>';
            	}
            if($cnt16 > 0){
            	$html .= '<tr><td>'.$records16[0]['cca_date'].'</td><td>'.$records16[0]['class_name'].'</td><td>'.$records16[0]['cgrp'].'</td><td>'.$records16[0]['cca_name'].'</td> <td>'.$cnt16.'</td></tr>';
            }
           // }
            $html.= '</table>';
            $this->db->close();
			header("Content-type: application/vnd.ms-excel");
			header("Content-Disposition: attachment; filename=cca".time().".xls");
			echo $html;exit;
		}else{
			$this->session->set_flashdata('error', 'No Records found' );
			redirect("cca/cca_monthreport");
		}
		}

		$data['sessions'] = $this->Common_Model->FetchData("sessions", "*", "1 ORDER BY active_session DESC");
		$data['classes'] = $this->Common_Model->FetchData("classes", "*", "1 ORDER BY class_name ASC");
		$data['cca'] = $this->Common_Model->FetchData("cca", "*", "1 ORDER BY cca_name ASC");
		$data['activemenu'] = 'cca';
		$data['activesubmenu'] = 'cca_monthreport';
		$this->load->view('cca/cca_monthreport', $data);
	}
	
	function view_participatecert($id = 0){
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$examdata = $this->Common_Model->FetchData("cca_records AS cr LEFT JOIN cca AS c ON cr.cca_id = c.cca_id LEFT JOIN positions AS p ON cr.cca_position = p.position_id LEFT JOIN classes AS cs ON cr.class_id = cs.class_id LEFT JOIN sessions AS s ON cr.session_id = s.session_id LEFT JOIN students AS st ON cr.student_id = st.student_id ", "cr.id, 	cr.cca_id, 	c.cca_name, 	cr.student_id, 	cr.student_name, 	cr.cca_position, p.position_name, 	cr.class_id, cs.class_name, 	cr.cca_date, cr.created_on, cr.session_id, s.session_name, st.father_name, st.mother_name, st.student_gender", "cr.id = $id");
		/*
		header("Content-type: image/jpeg");
	    $imgPath = realpath(APPPATH.'../assets/certificate.jpg');
	    $image = imagecreatefromjpeg($imgPath);
	    $color = imagecolorallocate($image, 0, 0, 0);
	    $fontSize = 10;
	    $x = 515;
	    $y = 795;
	    imagestring($image, $fontSize, $x, $y, $examdata[0]['student_name'], $color);
	    imagejpeg($image);
	    */

		header('Content-Type: image/png');
		$imgPath = realpath(APPPATH.'../assets/005.jpeg');
	    $im = imagecreatefromjpeg($imgPath);
		$black = imagecolorallocate($im, 0, 0, 0);
		$font1 = realpath(APPPATH.'../assets/Pacifico.ttf');
		$font = realpath(APPPATH.'../assets/AlexBrush-Regular.ttf');

	    imagettftext($im, 35, 0, 424, 424, $black, $font, $examdata[0]['student_name']);
		//imagettftext($im, 55, 0, 1065, 1230, $black, $font, $examdata[0]['class_name']);
		//imagettftext($im, 23, 0, 195, 450, $black, $font, $examdata[0]['father_name']);
		imagettftext($im, 25, 0, 280, 490, $black, $font, $examdata[0]['class_name']);
		imagettftext($im, 35, 0, 270, 553, $black, $font, $examdata[0]['cca_name']);
		//imagettftext($im, 35, 0, 415, 634, $black, $font, $examdata[0]['position_name']);
		imagettftext($im, 25, 0, 635, 555, $black, $font, date('d-m-Y',strtotime($examdata[0]['cca_date'])));
		//$session = explode('-', $examdata[0]['session_name']);
		imagettftext($im, 23, 0, 405, 614, $black, $font1, $session[0]);
		imagettftext($im, 23, 0, 515, 614, $black, $font1, $session[1]);
		//imagettftext($im, 20, 0, 10, 20, $black, $font, $text);
		imagepng($im);
		imagedestroy($im);
	}
	
	public function add_bonafidecert(){
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		if($this->input->post('submitBtn')){
			$this->form_validation->set_rules('session_id', 'Session', 'trim|required');
			$this->form_validation->set_error_delimiters('<p class="has-error"><label class="control-label">', '</label></p>');
			if($this->form_validation->run()){
				$student = $this->Common_Model->FetchData("students", "*", "student_id = ".$this->input->post('student_id'));
				$data_list = array(
					'session_id'				=> $this->input->post('session_id'),
					'class_id'					=> $this->input->post('class_id'),
					'student_id'				=> $this->input->post('student_id'),
					'dob'						=> $this->input->post('dob')
				);
				//print_r($data_list);exit;
				$exam_result_id = $this->Common_Model->dbinsertid("bonafide_certificate", $data_list);
				$this->session->set_flashdata('success', 'CCA result added successfully.' );
				redirect('cca/add_bonafidecert');
			}else{
				$this->session->set_flashdata('error', validation_errors());
			}
		}
		$data['activemenu'] 	= 'cca';
		$data['activesubmenu'] 	= 'add_bonafidecert';
		$data['sessions'] 		= $this->Common_Model->FetchData("sessions", "*", "1 ORDER BY session_id DESC");
		$data['classes'] 		= $this->Common_Model->FetchData("classes", "*", "1 ORDER BY class_name ASC");
		$data['ccas'] 			= $this->Common_Model->FetchData("cca", "*", "1 ORDER BY cca_name DESC");
		$data['positions'] 		= $this->Common_Model->FetchData("positions", "*", "1 ORDER BY position_name ASC");
		$this->load->view('cca/add_bonafidecert', $data);
	}

	function list_bonafidecert(){
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$data['per_page'] = $per_page = isset($_REQUEST['per_page']) ? $_REQUEST['per_page'] : 10;
		$data['page'] = $page = isset($_REQUEST['page']) ? $_REQUEST['page'] : '1';
		$this->load->helper('url');
		$currentURL = current_url();
		$sql = "1";
		
		$urlvars = '';
		
		if(isset($_REQUEST['session_id']) && $_REQUEST['session_id'] != ''){
			$sql.= " AND r.session_id = '".$_REQUEST['session_id']."'";
			$urlvars.= "&session_id=".$_REQUEST['session_id'];
		}

		if(isset($_REQUEST['class_id']) && $_REQUEST['class_id'] != ''){
			$sql.= " AND r.class_id = '".$_REQUEST['class_id']."'";
			$urlvars.= "&class_id=".$_REQUEST['class_id'];
		}

		if(isset($_REQUEST['student_id']) && $_REQUEST['student_id'] != ''){
			$sql.= " AND r.student_id = '".$_REQUEST['student_id']."'";
			$urlvars.= "&student_id=".$_REQUEST['student_id'];
		}

		
		$sSql = "SELECT COUNT(*) as num FROM bonafide_certificate AS r LEFT JOIN sessions AS s ON r.session_id = s.session_id LEFT JOIN classes AS c ON r.class_id = c.class_id LEFT JOIN students AS st ON r.student_id = st.student_id WHERE $sql";
		$records = $this->Common_Model->db_query($sSql);
		$totalrecords = $records[0]['num'];
		if($totalrecords){
			$sSql = "SELECT s.session_name, c.class_name, r.id, r.student_id, r.class_id, r.dob, r.session_id, st.student_first_name, st.student_last_name FROM bonafide_certificate AS r LEFT JOIN sessions AS s ON r.session_id = s.session_id LEFT JOIN classes AS c ON r.class_id = c.class_id LEFT JOIN students AS st ON r.student_id = st.student_id WHERE $sql ORDER BY r.id ASC";
			$this->load->library("Paginator");
			$this->paginator->setparam(array("page_num" => $page, "num_rows" => $totalrecords));
			$this->paginator->set_Limit($per_page);

			$range1 = $this->paginator->getRange1();
			$range2 = $this->paginator->getRange2();
			$sSql .= " LIMIT ".$range1.', '.$range2;
			$records = $this->Common_Model->db_query($sSql);
			$queryvars = "per_page=$per_page".$urlvars;
			$paging_info = $this->paginator->DBPagingNav($queryvars, $currentURL);
			$aData['tot_page'] = $paging_info[0];
			$aData['pages'] = $paging_info[1];
			$data['sPages'] = $aData['pages'];
			$data['records'] = $records;
			$data['norecords'] = FALSE;
		}else{
			$data['records'] = 0;
		}

		if($this->input->get('downBtn')){
			$sSql = "SELECT s.session_name, c.class_name, r.id, ca.cca_name, r.student_id, r.student_name, r.class_id, r.cca_date, r.session_id, sec.section_name, st.student_first_name, st.student_last_name FROM bonafide_certificate AS r INNER JOIN cca AS ca ON r.cca_id = ca.cca_id LEFT JOIN sessions AS s ON r.session_id = s.session_id LEFT JOIN classes AS c ON r.class_id = c.class_id LEFT JOIN sections AS sec ON r.section_id = sec.section_id LEFT JOIN students AS st ON r.student_id = st.student_id WHERE $sql ORDER BY r.id ASC";
		if($records){
			$html = '<table border=1> <tr> <th>Student Name</th><th>House</th><th>Class</th><th>Section</th><th>Name Of The Competition</th><th>Group</th> <th>' 
             . ( $records[$i]['cca_type'] == 'Participate' ? 'CCA Type' : 'Position' ) . '</th><th>CCA Date</th></tr>';
            
            for($i=0;$i<count($records);$i++){
            	$html.= '<tr><td>'.$records[$i]['student_first_name'].' '.$records[$i]['student_last_name'].'</td><td>'.$records[$i]['house_no'].'</td><td>'.$records[$i]['class_name'].'</td><td>'.$records[$i]['section_name'].'</td><td>'.$records[$i]['cca_name'].'</td><td>'.$records[$i]['cgrp'].'</td> <td>' 
             . ( $records[$i]['cca_type'] == 'Participate' ? $records[$i]['cca_type'] : $records[$i]['cca_position'] ) . '</td><td>'.$records[$i]['cca_date'].'</td></tr>';
            }
            $html.= '</table>';
            $this->db->close();
			header("Content-type: application/vnd.ms-excel");
			header("Content-Disposition: attachment; filename=cca".time().".xls");
			echo $html;exit;
		}else{
			$this->session->set_flashdata('error', 'No Records found' );
			redirect("cca/list_bonafidecert");
		}
		}

		$data['sessions'] = $this->Common_Model->FetchData("sessions", "*", "1 ORDER BY active_session DESC");
		$data['classes'] = $this->Common_Model->FetchData("classes", "*", "1 ORDER BY class_name ASC");
		$data['cca'] = $this->Common_Model->FetchData("cca", "*", "1 ORDER BY cca_name ASC");
		$data['activemenu'] = 'cca';
		$data['activesubmenu'] = 'list_bonafidecert';
		$this->load->view('cca/list_bonafidecert', $data);
	}

	public function add_armybonafidecert(){
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		if($this->input->post('submitBtn')){
			$this->form_validation->set_rules('session_id', 'Session', 'trim|required');
			$this->form_validation->set_error_delimiters('<p class="has-error"><label class="control-label">', '</label></p>');
			if($this->form_validation->run()){
				$student = $this->Common_Model->FetchData("students", "*", "student_id = ".$this->input->post('student_id'));
				$data_list = array(
					'session_id'				=> $this->input->post('session_id'),
					'class_id'					=> $this->input->post('class_id'),
					'section_id'				=> $this->input->post('student_section'),
					'student_id'				=> $this->input->post('student_id'),
					//'dob'						=> $this->input->post('dob'),
					'cert_date'					=> $this->input->post('cert_date')
				);
				//print_r($data_list);exit;
				$exam_result_id = $this->Common_Model->dbinsertid("bonafide_armycertificate", $data_list);
				$this->session->set_flashdata('success', 'CCA result added successfully.' );
				redirect('cca/add_armybonafidecert');
			}else{
				$this->session->set_flashdata('error', validation_errors());
			}
		}
		$data['activemenu'] 	= 'cca';
		$data['activesubmenu'] 	= 'add_armybonafidecert';
		$data['sessions'] 		= $this->Common_Model->FetchData("sessions", "*", "1 ORDER BY session_id DESC");
		$data['classes'] 		= $this->Common_Model->FetchData("classes", "*", "1 ORDER BY class_name ASC");
		$this->load->view('cca/add_armybonafidecert', $data);
	}

	function list_armybonafidecert(){
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$data['per_page'] = $per_page = isset($_REQUEST['per_page']) ? $_REQUEST['per_page'] : 10;
		$data['page'] = $page = isset($_REQUEST['page']) ? $_REQUEST['page'] : '1';
		$this->load->helper('url');
		$currentURL = current_url();
		$sql = "1";		
		$urlvars = '';
		
		if(isset($_REQUEST['session_id']) && $_REQUEST['session_id'] != ''){
			$sql.= " AND r.session_id = '".$_REQUEST['session_id']."'";
			$urlvars.= "&session_id=".$_REQUEST['session_id'];
		}

		if(isset($_REQUEST['class_id']) && $_REQUEST['class_id'] != ''){
			$sql.= " AND r.class_id = '".$_REQUEST['class_id']."'";
			$urlvars.= "&class_id=".$_REQUEST['class_id'];
		}

		if(isset($_REQUEST['student_id']) && $_REQUEST['student_id'] != ''){
			$sql.= " AND r.student_id = '".$_REQUEST['student_id']."'";
			$urlvars.= "&student_id=".$_REQUEST['student_id'];
		}

		if(isset($_REQUEST['created_on_from']) && $_REQUEST['created_on_from'] != ''){
			$sql.= " AND r.created_on >= '".$_REQUEST['created_on_from']."'";
			$urlvars.= "&created_on_from=".$_REQUEST['created_on_from'];
		}
		
		if(isset($_REQUEST['created_on_to']) && $_REQUEST['created_on_to'] != ''){
			$sql.= " AND r.created_on <= '".$_REQUEST['created_on_to']."'";
			$urlvars.= "&created_on_to=".$_REQUEST['created_on_to'];
		}
		if(isset($_REQUEST['cca_name']) && $_REQUEST['cca_name'] != ''){
			$sql.= " AND r.cca_name LIKE '%".$_REQUEST['cca_name']."%'";
			$urlvars.= "&cca_name=".$_REQUEST['cca_name'];
		}
		if(isset($_REQUEST['cca_position']) && $_REQUEST['cca_position'] != ''){
			$sql.= " AND r.cca_position LIKE '%".$_REQUEST['cca_position']."%'";
			$urlvars.= "&cca_position=".$_REQUEST['cca_position'];
		}
		if(isset($_REQUEST['cca_date']) && $_REQUEST['cca_date'] != ''){
			$sql.= " AND r.cca_date = '".$_REQUEST['cca_date']."'";
			$urlvars.= "&cca_date=".$_REQUEST['cca_date'];
		}

		$sSql = "SELECT COUNT(*) as num FROM bonafide_armycertificate AS r LEFT JOIN sessions AS s ON r.session_id = s.session_id LEFT JOIN classes AS c ON r.class_id = c.class_id LEFT JOIN students AS st ON r.student_id = st.student_id WHERE $sql";
		$records = $this->Common_Model->db_query($sSql);
		$totalrecords = $records[0]['num'];
		if($totalrecords){
			$sSql = "SELECT s.session_name, c.class_name, r.id, r.student_id, r.class_id, r.cert_date, r.session_id, st.student_first_name, st.student_last_name FROM bonafide_armycertificate AS r LEFT JOIN classes AS c ON r.class_id = c.class_id LEFT JOIN students AS st ON r.student_id = st.student_id LEFT JOIN sessions AS s ON r.session_id = s.session_id WHERE $sql ORDER BY r.id DESC";
			$this->load->library("Paginator");
			$this->paginator->setparam(array("page_num" => $page, "num_rows" => $totalrecords));
			$this->paginator->set_Limit($per_page);

			$range1 = $this->paginator->getRange1();
			$range2 = $this->paginator->getRange2();
			$sSql .= " LIMIT ".$range1.', '.$range2;
			$records = $this->Common_Model->db_query($sSql);
			$queryvars = "per_page=$per_page".$urlvars;
			$paging_info = $this->paginator->DBPagingNav($queryvars, $currentURL);
			$aData['tot_page'] = $paging_info[0];
			$aData['pages'] = $paging_info[1];
			$data['sPages'] = $aData['pages'];
			$data['records'] = $records;
			$data['norecords'] = FALSE;
		}else{
			$data['records'] = 0;
		}

		$data['sessions'] = $this->Common_Model->FetchData("sessions", "*", "1 ORDER BY active_session DESC");
		$data['classes'] = $this->Common_Model->FetchData("classes", "*", "1 ORDER BY class_name ASC");
		$data['activesubmenu'] = 'list_armybonafidecert';
		$this->load->view('cca/list_armybonafidecert', $data);
	}

	function view_armybonafidecert($id = 0){
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$data['records'] = $this->Common_Model->FetchData("bonafide_armycertificate as ba LEFT JOIN classes as c ON ba.class_id = c.class_id LEFT JOIN sessions AS s ON ba.session_id = s.session_id LEFT JOIN sections AS sc ON ba.section_id = sc.section_id LEFT JOIN students AS st ON ba.student_id = st.student_id", "*", "id = ".$id);
		
		error_reporting(0);
		ini_set('display_error', -1);
		//$html = $this->load->view('student/view_tc', $data, TRUE);
		$this->load->library('Dompdffile');
		$this->dompdffile->load_view('cca/view_armybonafidecert', $data);		
	}

	function view_bonafidecert($id = 0){
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$data['records'] = $this->Common_Model->FetchData("bonafide_certificate as ba LEFT JOIN classes as c ON ba.class_id = c.class_id LEFT JOIN sessions AS s ON ba.session_id = s.session_id LEFT JOIN students AS st ON ba.student_id = st.student_id", "*", "id = ".$id);
		
		error_reporting(0);
		ini_set('display_error', -1);
		//$html = $this->load->view('student/view_tc', $data, TRUE);
		$this->load->library('Dompdffile');
		$this->dompdffile->load_view('cca/view_bonafidecert', $data);		
	}


	public function add_charactercert(){
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		if($this->input->post('submitBtn')){
			$this->form_validation->set_rules('session_id', 'Session', 'trim|required');
			$this->form_validation->set_error_delimiters('<p class="has-error"><label class="control-label">', '</label></p>');
			if($this->form_validation->run()){
				$student = $this->Common_Model->FetchData("students", "*", "student_id = ".$this->input->post('student_id'));
				$data_list = array(
					'session_id'				=> $this->input->post('session_id'),
					'class_id'					=> $this->input->post('class_id'),
					'student_id'				=> $this->input->post('student_id'),
					'dob'						=> $this->input->post('dob'),
					'secured_percentage'		=> $this->input->post('result')
				);
				//print_r($data_list);exit;
				$exam_result_id = $this->Common_Model->dbinsertid("character_certificate", $data_list);
				$this->session->set_flashdata('success', 'Character Certificate added successfully.' );
				redirect('cca/add_charactercert');
			}else{
				$this->session->set_flashdata('error', validation_errors());
			}
		}
		$data['activemenu'] 	= 'cca';
		$data['activesubmenu'] 	= 'add_charactercert';
		$data['sessions'] 		= $this->Common_Model->FetchData("sessions", "*", "1 ORDER BY session_id DESC");
		$data['classes'] 		= $this->Common_Model->FetchData("classes", "*", "1 ORDER BY class_name ASC");
		$data['ccas'] 			= $this->Common_Model->FetchData("cca", "*", "1 ORDER BY cca_name DESC");
		$data['positions'] 		= $this->Common_Model->FetchData("positions", "*", "1 ORDER BY position_name ASC");
		$this->load->view('cca/add_charactercert', $data);
	}

	function list_charactercert(){
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$data['per_page'] = $per_page = isset($_REQUEST['per_page']) ? $_REQUEST['per_page'] : 10;
		$data['page'] = $page = isset($_REQUEST['page']) ? $_REQUEST['page'] : '1';
		$this->load->helper('url');
		$currentURL = current_url();
		$sql = "1";
		
		$urlvars = '';
		
		if(isset($_REQUEST['session_id']) && $_REQUEST['session_id'] != ''){
			$sql.= " AND r.session_id = '".$_REQUEST['session_id']."'";
			$urlvars.= "&session_id=".$_REQUEST['session_id'];
		}

		if(isset($_REQUEST['class_id']) && $_REQUEST['class_id'] != ''){
			$sql.= " AND r.class_id = '".$_REQUEST['class_id']."'";
			$urlvars.= "&class_id=".$_REQUEST['class_id'];
		}

		if(isset($_REQUEST['student_id']) && $_REQUEST['student_id'] != ''){
			$sql.= " AND r.student_id = '".$_REQUEST['student_id']."'";
			$urlvars.= "&student_id=".$_REQUEST['student_id'];
		}

		
		$sSql = "SELECT COUNT(*) as num FROM character_certificate AS r LEFT JOIN sessions AS s ON r.session_id = s.session_id LEFT JOIN classes AS c ON r.class_id = c.class_id LEFT JOIN students AS st ON r.student_id = st.student_id WHERE $sql";
		$records = $this->Common_Model->db_query($sSql);
		$totalrecords = $records[0]['num'];
		if($totalrecords){
			$sSql = "SELECT s.session_name, c.class_name, r.id, r.student_id, r.class_id, r.dob, r.session_id, st.student_first_name, st.student_last_name FROM character_certificate AS r LEFT JOIN sessions AS s ON r.session_id = s.session_id LEFT JOIN classes AS c ON r.class_id = c.class_id LEFT JOIN students AS st ON r.student_id = st.student_id WHERE $sql ORDER BY r.id ASC";
			$this->load->library("Paginator");
			$this->paginator->setparam(array("page_num" => $page, "num_rows" => $totalrecords));
			$this->paginator->set_Limit($per_page);

			$range1 = $this->paginator->getRange1();
			$range2 = $this->paginator->getRange2();
			$sSql .= " LIMIT ".$range1.', '.$range2;
			$records = $this->Common_Model->db_query($sSql);
			$queryvars = "per_page=$per_page".$urlvars;
			$paging_info = $this->paginator->DBPagingNav($queryvars, $currentURL);
			$aData['tot_page'] = $paging_info[0];
			$aData['pages'] = $paging_info[1];
			$data['sPages'] = $aData['pages'];
			$data['records'] = $records;
			$data['norecords'] = FALSE;
		}else{
			$data['records'] = 0;
		}

		if($this->input->get('downBtn')){
			$sSql = "SELECT s.session_name, c.class_name, r.id, ca.cca_name, r.student_id, r.student_name, r.class_id, r.cca_date, r.session_id, sec.section_name, st.student_first_name, st.student_last_name FROM character_certificate AS r INNER JOIN cca AS ca ON r.cca_id = ca.cca_id LEFT JOIN sessions AS s ON r.session_id = s.session_id LEFT JOIN classes AS c ON r.class_id = c.class_id LEFT JOIN sections AS sec ON r.section_id = sec.section_id LEFT JOIN students AS st ON r.student_id = st.student_id WHERE $sql ORDER BY r.id ASC";
		if($records){
			$html = '<table border=1> <tr> <th>Student Name</th><th>House</th><th>Class</th><th>Section</th><th>Name Of The Competition</th><th>Group</th> <th>' 
             . ( $records[$i]['cca_type'] == 'Participate' ? 'CCA Type' : 'Position' ) . '</th><th>CCA Date</th></tr>';
            
            for($i=0;$i<count($records);$i++){
            	$html.= '<tr><td>'.$records[$i]['student_first_name'].' '.$records[$i]['student_last_name'].'</td><td>'.$records[$i]['house_no'].'</td><td>'.$records[$i]['class_name'].'</td><td>'.$records[$i]['section_name'].'</td><td>'.$records[$i]['cca_name'].'</td><td>'.$records[$i]['cgrp'].'</td> <td>' 
             . ( $records[$i]['cca_type'] == 'Participate' ? $records[$i]['cca_type'] : $records[$i]['cca_position'] ) . '</td><td>'.$records[$i]['cca_date'].'</td></tr>';
            }
            $html.= '</table>';
            $this->db->close();
			header("Content-type: application/vnd.ms-excel");
			header("Content-Disposition: attachment; filename=cca".time().".xls");
			echo $html;exit;
		}else{
			$this->session->set_flashdata('error', 'No Records found' );
			redirect("cca/list_charactercert");
		}
		}

		$data['sessions'] = $this->Common_Model->FetchData("sessions", "*", "1 ORDER BY active_session DESC");
		$data['classes'] = $this->Common_Model->FetchData("classes", "*", "1 ORDER BY class_name ASC");
		$data['cca'] = $this->Common_Model->FetchData("cca", "*", "1 ORDER BY cca_name ASC");
		$data['activemenu'] = 'cca';
		$data['activesubmenu'] = 'list_charactercert';
		$this->load->view('cca/list_charactercert', $data);
	}

	function view_charactercert($id = 0){
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$data['records'] = $this->Common_Model->FetchData("character_certificate as ba LEFT JOIN classes as c ON ba.class_id = c.class_id LEFT JOIN sessions AS s ON ba.session_id = s.session_id LEFT JOIN students AS st ON ba.student_id = st.student_id", "*", "id = ".$id);
		
		error_reporting(0);
		ini_set('display_error', -1);
		//$html = $this->load->view('student/view_tc', $data, TRUE);
		$this->load->library('Dompdffile');
		$this->dompdffile->load_view('cca/view_charactercert', $data);		
	}
	
	public function add_membershipcert(){
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		if($this->input->post('submitBtn')){
			$this->form_validation->set_rules('session_id', 'Session', 'trim|required');
			$this->form_validation->set_error_delimiters('<p class="has-error"><label class="control-label">', '</label></p>');
			if($this->form_validation->run()){
				$student = $this->Common_Model->FetchData("students", "*", "student_id = ".$this->input->post('student_id'));
				$data_list = array(
					'session_id'				=> $this->input->post('session_id'),
					'class_id'					=> $this->input->post('class_id'),
					'student_id'				=> $this->input->post('student_id'),
					'dob'						=> $this->input->post('dob'),
					'secured_percentage'		=> $this->input->post('result')
				);
				//print_r($data_list);exit;
				$exam_result_id = $this->Common_Model->dbinsertid("membership_certificate", $data_list);
				$this->session->set_flashdata('success', 'Character Certificate added successfully.' );
				redirect('cca/add_membershipcert');
			}else{
				$this->session->set_flashdata('error', validation_errors());
			}
		}
		$data['activemenu'] 	= 'cca';
		$data['activesubmenu'] 	= 'add_membershipcert';
		$data['sessions'] 		= $this->Common_Model->FetchData("sessions", "*", "1 ORDER BY session_id DESC");
		$data['classes'] 		= $this->Common_Model->FetchData("classes", "*", "1 ORDER BY class_name ASC");
		$data['ccas'] 			= $this->Common_Model->FetchData("cca", "*", "1 ORDER BY cca_name DESC");
		$data['positions'] 		= $this->Common_Model->FetchData("positions", "*", "1 ORDER BY position_name ASC");
		$this->load->view('cca/add_membershipcert', $data);
	}

	function list_membershipcert(){
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$data['per_page'] = $per_page = isset($_REQUEST['per_page']) ? $_REQUEST['per_page'] : 10;
		$data['page'] = $page = isset($_REQUEST['page']) ? $_REQUEST['page'] : '1';
		$this->load->helper('url');
		$currentURL = current_url();
		$sql = "1";
		
		$urlvars = '';
		
		if(isset($_REQUEST['session_id']) && $_REQUEST['session_id'] != ''){
			$sql.= " AND r.session_id = '".$_REQUEST['session_id']."'";
			$urlvars.= "&session_id=".$_REQUEST['session_id'];
		}

		if(isset($_REQUEST['class_id']) && $_REQUEST['class_id'] != ''){
			$sql.= " AND r.class_id = '".$_REQUEST['class_id']."'";
			$urlvars.= "&class_id=".$_REQUEST['class_id'];
		}

		if(isset($_REQUEST['student_id']) && $_REQUEST['student_id'] != ''){
			$sql.= " AND r.student_id = '".$_REQUEST['student_id']."'";
			$urlvars.= "&student_id=".$_REQUEST['student_id'];
		}

		
		$sSql = "SELECT COUNT(*) as num FROM membership_certificate AS r LEFT JOIN sessions AS s ON r.session_id = s.session_id LEFT JOIN classes AS c ON r.class_id = c.class_id LEFT JOIN students AS st ON r.student_id = st.student_id WHERE $sql";
		$records = $this->Common_Model->db_query($sSql);
		$totalrecords = $records[0]['num'];
		if($totalrecords){
			$sSql = "SELECT s.session_name, c.class_name, r.id, r.student_id, r.class_id, r.dob, r.session_id, st.student_first_name, st.student_last_name FROM membership_certificate AS r LEFT JOIN sessions AS s ON r.session_id = s.session_id LEFT JOIN classes AS c ON r.class_id = c.class_id LEFT JOIN students AS st ON r.student_id = st.student_id WHERE $sql ORDER BY r.id ASC";
			$this->load->library("Paginator");
			$this->paginator->setparam(array("page_num" => $page, "num_rows" => $totalrecords));
			$this->paginator->set_Limit($per_page);

			$range1 = $this->paginator->getRange1();
			$range2 = $this->paginator->getRange2();
			$sSql .= " LIMIT ".$range1.', '.$range2;
			$records = $this->Common_Model->db_query($sSql);
			$queryvars = "per_page=$per_page".$urlvars;
			$paging_info = $this->paginator->DBPagingNav($queryvars, $currentURL);
			$aData['tot_page'] = $paging_info[0];
			$aData['pages'] = $paging_info[1];
			$data['sPages'] = $aData['pages'];
			$data['records'] = $records;
			$data['norecords'] = FALSE;
		}else{
			$data['records'] = 0;
		}

		if($this->input->get('downBtn')){
			$sSql = "SELECT s.session_name, c.class_name, r.id, ca.cca_name, r.student_id, r.student_name, r.class_id, r.cca_date, r.session_id, sec.section_name, st.student_first_name, st.student_last_name FROM membership_certificate AS r INNER JOIN cca AS ca ON r.cca_id = ca.cca_id LEFT JOIN sessions AS s ON r.session_id = s.session_id LEFT JOIN classes AS c ON r.class_id = c.class_id LEFT JOIN sections AS sec ON r.section_id = sec.section_id LEFT JOIN students AS st ON r.student_id = st.student_id WHERE $sql ORDER BY r.id ASC";
		if($records){
			$html = '<table border=1> <tr> <th>Student Name</th><th>House</th><th>Class</th><th>Section</th><th>Name Of The Competition</th><th>Group</th> <th>' 
             . ( $records[$i]['cca_type'] == 'Participate' ? 'CCA Type' : 'Position' ) . '</th><th>CCA Date</th></tr>';
            
            for($i=0;$i<count($records);$i++){
            	$html.= '<tr><td>'.$records[$i]['student_first_name'].' '.$records[$i]['student_last_name'].'</td><td>'.$records[$i]['house_no'].'</td><td>'.$records[$i]['class_name'].'</td><td>'.$records[$i]['section_name'].'</td><td>'.$records[$i]['cca_name'].'</td><td>'.$records[$i]['cgrp'].'</td> <td>' 
             . ( $records[$i]['cca_type'] == 'Participate' ? $records[$i]['cca_type'] : $records[$i]['cca_position'] ) . '</td><td>'.$records[$i]['cca_date'].'</td></tr>';
            }
            $html.= '</table>';
            $this->db->close();
			header("Content-type: application/vnd.ms-excel");
			header("Content-Disposition: attachment; filename=cca".time().".xls");
			echo $html;exit;
		}else{
			$this->session->set_flashdata('error', 'No Records found' );
			redirect("cca/list_membershipcert");
		}
		}

		$data['sessions'] = $this->Common_Model->FetchData("sessions", "*", "1 ORDER BY active_session DESC");
		$data['classes'] = $this->Common_Model->FetchData("classes", "*", "1 ORDER BY class_name ASC");
		$data['cca'] = $this->Common_Model->FetchData("cca", "*", "1 ORDER BY cca_name ASC");
		$data['activemenu'] = 'cca';
		$data['activesubmenu'] = 'list_membershipcert';
		$this->load->view('cca/list_membershipcert', $data);
	}

	function view_membershipcert($id = 0){
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$data['records'] = $this->Common_Model->FetchData("membership_certificate as ba LEFT JOIN classes as c ON ba.class_id = c.class_id LEFT JOIN sessions AS s ON ba.session_id = s.session_id LEFT JOIN students AS st ON ba.student_id = st.student_id", "*", "id = ".$id);
		
		error_reporting(0);
		ini_set('display_error', -1);
		//$html = $this->load->view('student/view_tc', $data, TRUE);
		$this->load->library('Dompdffile');
		$this->dompdffile->load_view('cca/view_membershipcert', $data);		
	}
	
	public function add_studycert(){
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		if($this->input->post('submitBtn')){
			$this->form_validation->set_rules('session_id', 'Session', 'trim|required');
			$this->form_validation->set_error_delimiters('<p class="has-error"><label class="control-label">', '</label></p>');
			if($this->form_validation->run()){
				$student = $this->Common_Model->FetchData("students", "*", "student_id = ".$this->input->post('student_id'));
				$data_list = array(
					'session_id'				=> $this->input->post('session_id'),
					'class_id'					=> $this->input->post('class_id'),
					'student_id'				=> $this->input->post('student_id'),
					'pob'						=> $this->input->post('pob'),
					'study_from'				=> $this->input->post('study_from'),
					'cca_date'					=> date('Y-m-d')
				);
				//print_r($data_list);exit;
				$exam_result_id = $this->Common_Model->dbinsertid("study_certificate", $data_list);
				$this->session->set_flashdata('success', 'Study Certificate added successfully.' );
				redirect('cca/add_studycert');
			}else{
				$this->session->set_flashdata('error', validation_errors());
			}
		}
		$data['activemenu'] 	= 'cca';
		$data['activesubmenu'] 	= 'add_studycert';
		$data['sessions'] 		= $this->Common_Model->FetchData("sessions", "*", "1 ORDER BY session_id DESC");
		$data['classes'] 		= $this->Common_Model->FetchData("classes", "*", "1 ORDER BY class_name ASC");
		$data['ccas'] 			= $this->Common_Model->FetchData("cca", "*", "1 ORDER BY cca_name DESC");
		$data['positions'] 		= $this->Common_Model->FetchData("positions", "*", "1 ORDER BY position_name ASC");
		$this->load->view('cca/add_studycert', $data);
	}

	function list_studycert(){
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$data['per_page'] = $per_page = isset($_REQUEST['per_page']) ? $_REQUEST['per_page'] : 10;
		$data['page'] = $page = isset($_REQUEST['page']) ? $_REQUEST['page'] : '1';
		$this->load->helper('url');
		$currentURL = current_url();
		$sql = "1";
		
		$urlvars = '';
		
		if(isset($_REQUEST['session_id']) && $_REQUEST['session_id'] != ''){
			$sql.= " AND r.session_id = '".$_REQUEST['session_id']."'";
			$urlvars.= "&session_id=".$_REQUEST['session_id'];
		}

		if(isset($_REQUEST['class_id']) && $_REQUEST['class_id'] != ''){
			$sql.= " AND r.class_id = '".$_REQUEST['class_id']."'";
			$urlvars.= "&class_id=".$_REQUEST['class_id'];
		}

		if(isset($_REQUEST['student_id']) && $_REQUEST['student_id'] != ''){
			$sql.= " AND r.student_id = '".$_REQUEST['student_id']."'";
			$urlvars.= "&student_id=".$_REQUEST['student_id'];
		}

		
		$sSql = "SELECT COUNT(*) as num FROM study_certificate AS r LEFT JOIN sessions AS s ON r.session_id = s.session_id LEFT JOIN classes AS c ON r.class_id = c.class_id LEFT JOIN students AS st ON r.student_id = st.student_id WHERE $sql";
		$records = $this->Common_Model->db_query($sSql);
		$totalrecords = $records[0]['num'];
		if($totalrecords){
			$sSql = "SELECT s.session_name, c.class_name, r.id, r.student_id, r.class_id, r.dob, r.session_id, st.student_first_name, st.student_last_name FROM study_certificate AS r LEFT JOIN sessions AS s ON r.session_id = s.session_id LEFT JOIN classes AS c ON r.class_id = c.class_id LEFT JOIN students AS st ON r.student_id = st.student_id WHERE $sql ORDER BY r.id ASC";
			$this->load->library("Paginator");
			$this->paginator->setparam(array("page_num" => $page, "num_rows" => $totalrecords));
			$this->paginator->set_Limit($per_page);

			$range1 = $this->paginator->getRange1();
			$range2 = $this->paginator->getRange2();
			$sSql .= " LIMIT ".$range1.', '.$range2;
			$records = $this->Common_Model->db_query($sSql);
			$queryvars = "per_page=$per_page".$urlvars;
			$paging_info = $this->paginator->DBPagingNav($queryvars, $currentURL);
			$aData['tot_page'] = $paging_info[0];
			$aData['pages'] = $paging_info[1];
			$data['sPages'] = $aData['pages'];
			$data['records'] = $records;
			$data['norecords'] = FALSE;
		}else{
			$data['records'] = 0;
		}

		if($this->input->get('downBtn')){
			$sSql = "SELECT s.session_name, c.class_name, r.id, ca.cca_name, r.student_id, r.student_name, r.class_id, r.cca_date, r.session_id, sec.section_name, st.student_first_name, st.student_last_name FROM study_certificate AS r INNER JOIN cca AS ca ON r.cca_id = ca.cca_id LEFT JOIN sessions AS s ON r.session_id = s.session_id LEFT JOIN classes AS c ON r.class_id = c.class_id LEFT JOIN sections AS sec ON r.section_id = sec.section_id LEFT JOIN students AS st ON r.student_id = st.student_id WHERE $sql ORDER BY r.id ASC";
		if($records){
			$html = '<table border=1> <tr> <th>Student Name</th><th>House</th><th>Class</th><th>Section</th><th>Name Of The Competition</th><th>Group</th> <th>' 
             . ( $records[$i]['cca_type'] == 'Participate' ? 'CCA Type' : 'Position' ) . '</th><th>CCA Date</th></tr>';
            
            for($i=0;$i<count($records);$i++){
            	$html.= '<tr><td>'.$records[$i]['student_first_name'].' '.$records[$i]['student_last_name'].'</td><td>'.$records[$i]['house_no'].'</td><td>'.$records[$i]['class_name'].'</td><td>'.$records[$i]['section_name'].'</td><td>'.$records[$i]['cca_name'].'</td><td>'.$records[$i]['cgrp'].'</td> <td>' 
             . ( $records[$i]['cca_type'] == 'Participate' ? $records[$i]['cca_type'] : $records[$i]['cca_position'] ) . '</td><td>'.$records[$i]['cca_date'].'</td></tr>';
            }
            $html.= '</table>';
            $this->db->close();
			header("Content-type: application/vnd.ms-excel");
			header("Content-Disposition: attachment; filename=cca".time().".xls");
			echo $html;exit;
		}else{
			$this->session->set_flashdata('error', 'No Records found' );
			redirect("cca/list_studycert");
		}
		}

		$data['sessions'] = $this->Common_Model->FetchData("sessions", "*", "1 ORDER BY active_session DESC");
		$data['classes'] = $this->Common_Model->FetchData("classes", "*", "1 ORDER BY class_name ASC");
		$data['cca'] = $this->Common_Model->FetchData("cca", "*", "1 ORDER BY cca_name ASC");
		$data['activemenu'] = 'cca';
		$data['activesubmenu'] = 'list_studycert';
		$this->load->view('cca/list_studycert', $data);
	}

	function view_studycertificate($id = 0){
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$data['records'] = $this->Common_Model->FetchData("study_certificate as ba LEFT JOIN classes as c ON ba.class_id = c.class_id LEFT JOIN sessions AS s ON ba.session_id = s.session_id LEFT JOIN students AS st ON ba.student_id = st.student_id", "*", "id = ".$id);
		
		error_reporting(0);
		ini_set('display_error', -1);
		//$html = $this->load->view('student/view_tc', $data, TRUE);
		$this->load->library('Dompdffile');
		$this->dompdffile->load_view('cca/view_studycertificate', $data);		
	}
	
	function view_resultccalist(){
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$data['per_page'] = $per_page = isset($_REQUEST['per_page']) ? $_REQUEST['per_page'] : 10;
		$data['page'] = $page = isset($_REQUEST['page']) ? $_REQUEST['page'] : '1';
		$this->load->helper('url');
		$currentURL = current_url();
		$sql = "1 AND r.cca_type = 'Position'";
		
		$urlvars = '';
		
		if(isset($_REQUEST['session_id']) && $_REQUEST['session_id'] != ''){
			$sql.= " AND r.session_id = '".$_REQUEST['session_id']."'";
			$urlvars.= "&session_id=".$_REQUEST['session_id'];
		}

		if(isset($_REQUEST['class_id']) && $_REQUEST['class_id'] != ''){
			$sql.= " AND r.class_id = '".$_REQUEST['class_id']."'";
			$urlvars.= "&class_id=".$_REQUEST['class_id'];
		}

		if(isset($_REQUEST['student_id']) && $_REQUEST['student_id'] != ''){
			$sql.= " AND r.student_id = '".$_REQUEST['student_id']."'";
			$urlvars.= "&student_id=".$_REQUEST['student_id'];
		}

		if(isset($_REQUEST['student_section']) && $_REQUEST['student_section'] != ''){
			$sql.= " AND r.section_id = '".$_REQUEST['student_section']."'";
			$urlvars.= "&student_section=".$_REQUEST['student_section'];
		}

		if(isset($_REQUEST['created_on_from']) && $_REQUEST['created_on_from'] != ''){
			$sql.= " AND r.created_on >= '".$_REQUEST['created_on_from']."'";
			$urlvars.= "&created_on_from=".$_REQUEST['created_on_from'];
		}
		
		if(isset($_REQUEST['created_on_to']) && $_REQUEST['created_on_to'] != ''){
			$sql.= " AND r.created_on <= '".$_REQUEST['created_on_to']."'";
			$urlvars.= "&created_on_to=".$_REQUEST['created_on_to'];
		}
		if(isset($_REQUEST['cca_name']) && $_REQUEST['cca_name'] != ''){
			$sql.= " AND r.cca_id LIKE '%".$_REQUEST['cca_name']."%'";
			$urlvars.= "&cca_name=".$_REQUEST['cca_name'];
		}
		if(isset($_REQUEST['cca_type']) && $_REQUEST['cca_type'] != ''){
			$sql.= " AND r.cca_type LIKE '%".$_REQUEST['cca_type']."%'";
			$urlvars.= "&cca_type=".$_REQUEST['cca_type'];
		}
		if(isset($_REQUEST['cca_date']) && $_REQUEST['cca_date'] != ''){
			$sql.= " AND r.cca_date = '".$_REQUEST['cca_date']."'";
			$urlvars.= "&cca_date=".$_REQUEST['cca_date'];
		}

		$sSql = "SELECT s.session_name, c.class_name, r.id, ca.cca_name, r.student_id, r.student_name, r.cca_position, p.position_name, r.class_id, r.cca_date, r.created_on, r.session_id, r.house_no, sec.section_name, cg.gid, cg.cgrp, st.student_first_name, st.student_last_name FROM cca_records AS r INNER JOIN cca AS ca ON r.cca_id = ca.cca_id LEFT JOIN ccagroups AS cg ON r.cca_group = cg.gid LEFT JOIN sessions AS s ON r.session_id = s.session_id LEFT JOIN classes AS c ON r.class_id = c.class_id LEFT JOIN sections AS sec ON r.section_id = sec.section_id LEFT JOIN students AS st ON r.student_id = st.student_id LEFT JOIN positions AS p ON r.cca_position = p.position_id WHERE $sql AND r.class_id = '".$_REQUEST["class_id"]."' AND r.session_id = '".$_REQUEST["session_id"]."' AND r.cca_group = '".$_REQUEST["cca_group"]."' ORDER BY r.created_on DESC";
			$records = $this->Common_Model->db_query($sSql);
			$data['records'] = 	$records;		
			error_reporting(0);
			ini_set('display_error', -1);
			//$html = $this->load->view('student/view_tc', $data, TRUE);
			$this->load->library('Dompdffile');
			$this->dompdffile->load_view('cca/view_resultcca', $data);
	}

}
