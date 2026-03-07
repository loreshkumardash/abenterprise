<?php
error_reporting(0);
defined('BASEPATH') OR exit('No direct script access allowed');
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
class Masters extends CI_Controller {

	public function __construct(){
		parent::__construct();
		is_logged_in();
		date_default_timezone_set("Asia/Kolkata"); 
		$this->present_date 		= date('Y-m-d');
		$this->present_time 		= date('H:i:a');
		$this->present_timefmt 		= date('h:i:a');
		$this->present_time1 		= date('H:i');
		$this->tod_date 		= date('d-M-Y');
		$this->dayltr 			= date("l"); 
	}

	public function index()
	{
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$data['activemenu'] = 'masters';
		$data['activesubmenu'] = 'masters';
		$this->load->view('dashboard', $data);
	}
	
    // Location Management - Add & Edit
    public function location($lid = 0) {
        $data = array();
        $data['accessar'] = json_decode($this->session->userdata('access_menus'));

        // Check if Editing an Existing Location
        if ($lid > 0) {
            $data['edit_record'] = $this->Common_Model->FetchData("location", "*", "lid = ".$lid);
        }
        //echo "<pre>";print_r($data['edit_record']);exit;
        if ($this->input->post('submitBtn')) {
            $this->form_validation->set_rules('location', 'Location', 'trim|required');
            $this->form_validation->set_error_delimiters('<p class="has-error"><label class="control-label">', '</label></p>');

            if ($this->form_validation->run()) {
                $data_list = array(
                    'location' => $this->input->post('location')
                );

                if ($this->input->post('lid')) {
                    // Update Existing Location
                    $this->Common_Model->update_records("location", "lid", $this->input->post('lid'), $data_list);
                    $this->session->set_flashdata('success', 'Location updated successfully.');
                } else {
                    // Insert New Location
                    $this->Common_Model->dbinsertid("location", $data_list);
                    $this->session->set_flashdata('success', 'Location added successfully.');
                }

                redirect(site_url("masters/location"));
            } else {
                $this->session->set_flashdata('error', validation_errors());
            }
        }

        // Fetch All Locations
        $data['activemenu'] = 'masters';
        $data['activesubmenu'] = 'location';
        $data['records'] = $this->Common_Model->FetchData("location", "*");

        $this->load->view('masters/location', $data);
    }

    // Edit Location (Calls Location with ID)
    public function editlocation($lid) {
        $this->location($lid);
    }

    // Delete Location
    public function deletelocation($lid = 0) {
        if ($lid > 0) {
            $this->Common_Model->DelData("location", "lid = ".$lid);
            $this->session->set_flashdata('success', 'Location deleted successfully.');
        } else {
            $this->session->set_flashdata('error', 'Invalid location ID.');
        }
        redirect(site_url("masters/location"));
    }
    
    //upcomig location

    public function uplocation($uc_lid = 0) {
        $data = array();
        $data['accessar'] = json_decode($this->session->userdata('access_menus'));

        // Check if Editing an Existing Location
        if ($uc_lid > 0) {
            $data['edit_record'] = $this->Common_Model->FetchData("uc_location", "*", "uc_lid = ".$uc_lid);
        }
        //echo "<pre>";print_r($data['edit_record']);exit;
        if ($this->input->post('submitBtn')) {
            $this->form_validation->set_rules('uplocation', 'Upcoming Location', 'trim|required');
            $this->form_validation->set_error_delimiters('<p class="has-error"><label class="control-label">', '</label></p>');

            if ($this->form_validation->run()) {
                $data_list = array(
                    'uc_location' => $this->input->post('uplocation')
                );

                if ($this->input->post('uc_lid')) {
                    // Update Existing Location
                    $this->Common_Model->update_records("uc_location", "uc_lid", $this->input->post('uc_lid'), $data_list);
                    $this->session->set_flashdata('success', 'Upcoming Location updated successfully.');
                } else {
                    // Insert New Location
                    $this->Common_Model->dbinsertid("uc_location", $data_list);
                    $this->session->set_flashdata('success', 'Upcoming Location added successfully.');
                }

                redirect(site_url("masters/uplocation"));
            } else {
                $this->session->set_flashdata('error', validation_errors());
            }
        }

        // Fetch All Locations
        $data['activemenu'] = 'masters';
        $data['activesubmenu'] = 'uplocation';
        $data['records'] = $this->Common_Model->FetchData("uc_location", "*");

        $this->load->view('masters/uplocation', $data);
    }

    // Edit Location (Calls Location with ID)
    public function edituplocation($uc_lid) {
        $this->uplocation($uc_lid);
    }

    // Delete Location
    public function deleteuplocation($uc_lid = 0) {
        if ($uc_lid > 0) {
            $this->Common_Model->DelData("uc_location", "uc_lid = ".$uc_lid);
            $this->session->set_flashdata('success', 'Upcoming Location deleted successfully.');
        } else {
            $this->session->set_flashdata('error', 'Invalid Upcoming location ID.');
        }
        redirect(site_url("masters/uplocation"));
    }

	public function sessions()
	{
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		if($this->input->post('submitBtn')){
			$this->form_validation->set_rules('session_name', 'Session Name', 'trim|required|is_unique[users.username]');
			$this->form_validation->set_rules('session_start_date', 'Session start Date', 'trim|required');
			$this->form_validation->set_rules('session_end_date', 'Session end Date', 'trim|required');
			$this->form_validation->set_error_delimiters('<p class="has-error"><label class="control-label">', '</label></p>');
			if($this->form_validation->run()){
				$this->Common_Model->db_query("UPDATE sessions SET active_session = ''");
				$data_list = array(
					'session_name'			=> $this->input->post('session_name'),
					'session_start_date'			=> $this->input->post('session_start_date'),
					'session_end_date'			=> $this->input->post('session_end_date'),
					'session_description'			=> $this->input->post('session_description'),
					'active_session'			=> 'Active'
				);
				$id = $this->Common_Model->dbinsertid("sessions", $data_list);
				$sessions = $this->Common_Model->FetchData("sessions", "*", "active_session = 'Active'");
				$this->session->set_userdata($sessions[0]);
				$this->session->set_flashdata('success', 'Session Added successfully.' );
				redirect('masters/sessions');
			}else{
				$this->session->set_flashdata('error', validation_errors());
			}
		}
		if($this->input->post('active_session')){
			$this->Common_Model->db_query("UPDATE sessions SET active_session = ''");
			$this->Common_Model->db_query("UPDATE sessions SET active_session = 'Active' WHERE session_id = ".$this->input->post('active_session'));
			$sessions = $this->Common_Model->FetchData("sessions", "*", "active_session = 'Active'");
			$this->session->set_userdata($sessions[0]);
		}
		$data['activemenu'] = 'masters';
		$data['activesubmenu'] = 'sessions';
		$data['records'] = $this->Common_Model->FetchData("sessions", "*", "1 ORDER BY session_id DESC");
		$this->load->view('masters/sessions', $data);
	}

	
	function deleteexamterm($exam_term_id = 0){
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$this->Common_Model->DelData("exam_term", "exam_term_id = ".$exam_term_id);
		$this->session->set_flashdata('success', 'Record deleted successfully.' );
		redirect($_SERVER['HTTP_REFERER']);
	}

	function deletesession($session_id = 0){
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$this->Common_Model->DelData("sessions", "session_id = ".$session_id);
		$this->session->set_flashdata('success', 'Record deleted successfully.' );
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	function commercialterm(){
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$data['records'] = $this->Common_Model->FetchData("commercialterm","*","1");
		$data['activemenu'] = 'masters';
		$data['activesubmenu'] = 'commercialterm';
		$this->load->view('masters/commercialterm', $data);
	}

	function add_commercialterm(){
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		if($this->input->post('submitBtn')){
			$this->form_validation->set_rules('term_type', 'Term Type', 'trim|required');
			$this->form_validation->set_rules('term_for', 'Term For', 'trim|required');
			$this->form_validation->set_rules('term_description', 'Term Description', 'trim|required');
			$this->form_validation->set_error_delimiters('<p class="has-error"><label class="control-label">', '</label></p>');
			if($this->form_validation->run()){
				$data_list = array(
					'term_type'			=> $this->input->post('term_type'),
					'term_for'			=> $this->input->post('term_for'),
					'term_description'	=> $this->input->post('term_description'),
				);
				$id = $this->Common_Model->dbinsertid("commercialterm", $data_list);
				$this->session->set_flashdata('success', 'Term Added successfully.' );
				redirect('masters/add_commercialterm');
			}else{
				$this->session->set_flashdata('error', validation_errors());
			}
		}
		$data['activemenu'] = 'masters';
		$data['activesubmenu'] = 'commercialterm';
		$this->load->view('masters/add_commercialterm', $data);
	}

	function edit_commercialterm($commercialterm_id=0){
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		if($this->input->post('submitBtn')){
			$this->form_validation->set_rules('term_type', 'Term Type', 'trim|required');
			$this->form_validation->set_rules('term_for', 'Term For', 'trim|required');
			$this->form_validation->set_rules('term_description', 'Term Description', 'trim|required');
			$this->form_validation->set_error_delimiters('<p class="has-error"><label class="control-label">', '</label></p>');
			if($this->form_validation->run()){
				$data_list = array(
					'term_type'			=> $this->input->post('term_type'),
					'term_for'			=> $this->input->post('term_for'),
					'term_description'	=> $this->input->post('term_description'),
				);
				$id = $this->Common_Model->update_records("commercialterm", "commercialterm_id", $commercialterm_id, $data_list);
				$this->session->set_flashdata('success', 'Term Updated successfully.' );
				redirect('masters/commercialterm');
			}else{
				$this->session->set_flashdata('error', validation_errors());
			}
		}
		$data['rec'] = $this->Common_Model->FetchData("commercialterm","*","commercialterm_id=".$commercialterm_id);
		$data['activemenu'] = 'masters';
		$data['activesubmenu'] = 'commercialterm';
		$this->load->view('masters/edit_commercialterm', $data);
	}

	function delete_commercialterm($commercialterm_id=0){
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		
		$this->Common_Model->DelData("commercialterm", "commercialterm_id = ".$commercialterm_id);
		$this->session->set_flashdata('success', 'Record deleted successfully.' );
		redirect($_SERVER['HTTP_REFERER']);
	}

	public function classes()
	{
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		if($this->input->post('submitBtn')){
			$this->form_validation->set_rules('class_name', 'Class Name', 'trim|required|is_unique[classes.class_name]');
			$this->form_validation->set_error_delimiters('<p class="has-error"><label class="control-label">', '</label></p>');
			if($this->form_validation->run()){
				$data_list = array(
					'class_name'			=> $this->input->post('class_name'),
					'class_description'		=> $this->input->post('class_description'),
					'class_active'			=> 'Active'
				);
				$id = $this->Common_Model->dbinsertid("classes", $data_list);
				$this->session->set_flashdata('success', 'Class Added successfully.' );
				redirect('masters/classes');
			}else{
				$this->session->set_flashdata('error', validation_errors());
			}
		}
		$data['activemenu'] = 'masters';
		$data['activesubmenu'] = 'classes';
		$data['records'] = $this->Common_Model->FetchData("classes", "*", "1 ORDER BY class_name ASC");
		$this->load->view('masters/classes', $data);
	}

	function editclass($class_id = 0){
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		if($this->input->post('submitBtn')){
			$this->form_validation->set_rules('class_name', 'Class Name', 'trim|required');
			$this->form_validation->set_error_delimiters('<p class="has-error"><label class="control-label">', '</label></p>');
			if($this->form_validation->run()){
				$data_list = array(
					'class_name'			=> $this->input->post('class_name'),
					'class_figure'			=> $this->input->post('class_figure'),
					'noofsubjects'			=> $this->input->post('noofsubjects'),
					'class_description'		=> $this->input->post('class_description')
				);
				$id = $this->Common_Model->update_records("classes", "class_id", $class_id, $data_list);
				$this->session->set_flashdata('success', 'Class Updated successfully.' );
				redirect('masters/classes');
			}else{
				$this->session->set_flashdata('error', validation_errors());
			}
		}
		$data['activemenu'] = 'masters';
		$data['activesubmenu'] = 'classes';
		$data['rec'] = $this->Common_Model->FetchData("classes", "*", "class_id = $class_id");
		$this->load->view('masters/editclass', $data);
	}

	function deleteclass($class_id = 0){
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$this->Common_Model->DelData("classes", "class_id = ".$class_id);
		$this->Common_Model->DelData("subjects", "class_id = ".$class_id);
		$this->session->set_flashdata('success', 'Record deleted successfully.' );
		redirect($_SERVER['HTTP_REFERER']);
	}

	public function cca_types()
	{
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		if($this->input->post('submitBtn')){
			$this->form_validation->set_rules('cca_name', 'Class Name', 'trim|required|is_unique[cca.cca_name]');
			$this->form_validation->set_error_delimiters('<p class="has-error"><label class="control-label">', '</label></p>');
			if($this->form_validation->run()){
				$data_list = array(
					'cca_name'			=> $this->input->post('cca_name'),
					'cca_desc'		=> $this->input->post('cca_desc'),
				);
				$id = $this->Common_Model->dbinsertid("cca", $data_list);
				$this->session->set_flashdata('success', 'CCA Added successfully.' );
				redirect('masters/cca_types');
			}else{
				$this->session->set_flashdata('error', validation_errors());
			}
		}
		$data['activemenu'] = 'masters';
		$data['activesubmenu'] = 'cca_types';
		$data['records'] = $this->Common_Model->FetchData("cca", "*", "1 ORDER BY cca_name ASC");
		$this->load->view('masters/cca', $data);
	}

	function deletecca($cca_id = 0){
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$this->Common_Model->DelData("cca", "cca_id = ".$cca_id);
		$this->session->set_flashdata('success', 'CCA deleted successfully.' );
		redirect($_SERVER['HTTP_REFERER']);
	}

	public function positions()
	{
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		if($this->input->post('submitBtn')){
			$this->form_validation->set_rules('position_name', 'Position Name', 'trim|required|is_unique[positions.position_name]');
			$this->form_validation->set_error_delimiters('<p class="has-error"><label class="control-label">', '</label></p>');
			if($this->form_validation->run()){
				$data_list = array(
					'position_name'			=> $this->input->post('position_name'),
				);
				$id = $this->Common_Model->dbinsertid("positions", $data_list);
				$this->session->set_flashdata('success', 'Position Added successfully.' );
				redirect('masters/positions');
			}else{
				$this->session->set_flashdata('error', validation_errors());
			}
		}
		$data['activemenu'] = 'masters';
		$data['activesubmenu'] = 'positions';
		$data['records'] = $this->Common_Model->FetchData("positions", "*", "1 ORDER BY position_name ASC");
		$this->load->view('masters/positions', $data);
	}

	function deletepositions($position_id = 0){
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$this->Common_Model->DelData("positions", "position_id = ".$position_id);
		$this->session->set_flashdata('success', 'Record deleted successfully.' );
		redirect($_SERVER['HTTP_REFERER']);
	}

	public function subjects(){
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$this->load->helper('url');
		$currentURL = current_url();
		$sql = "1";
		
		if(isset($_REQUEST['class_idd']) && $_REQUEST['class_idd'] != ''){
			$sql.= " AND s.class_id = '".$_REQUEST['class_idd']."'";
			
		}
		$data['records'] = $this->Common_Model->FetchData("subjects AS s LEFT JOIN classes AS c ON s.class_id = c.class_id", "*", "$sql AND 1 ORDER BY c.class_name ASC");
		if($this->input->post('submitBtn')){
			$this->form_validation->set_rules('subject_name', 'Subject Name', 'trim|required');
			$this->form_validation->set_error_delimiters('<p class="has-error"><label class="control-label">', '</label></p>');
			if($this->form_validation->run()){
				$data_list = array(
					'subject_name'			=> $this->input->post('subject_name'),
					'class_id'		=> $this->input->post('class_name')
				);
				
				$id = $this->Common_Model->dbinsertid("subjects", $data_list);
				$this->session->set_flashdata('success', 'Subject Added successfully.' );
				redirect('masters/subjects');
			}else{
				$this->session->set_flashdata('error', validation_errors());
			}
		}

		$data['activemenu'] = 'masters';
		$data['activesubmenu'] = 'subjects';
		
		$data['records1'] = $this->Common_Model->FetchData("classes", "*", "1 ORDER BY class_name ASC");
		$this->load->view('masters/subjects', $data);
	}

	public function editsubject($subject_id = 0)
	{
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		if($this->input->post('submitBtn')){
			$this->form_validation->set_rules('subject_name', 'Subject Name', 'trim|required');
			$this->form_validation->set_error_delimiters('<p class="has-error"><label class="control-label">', '</label></p>');
			if($this->form_validation->run()){
				$data_list = array(
					'subject_name'			=> $this->input->post('subject_name'),
					'subject_no'			=> $this->input->post('subject_no')
				);
				$id = $this->Common_Model->update_records("subjects", "subject_id", $subject_id, $data_list);
				$this->session->set_flashdata('success', 'Subject Updated successfully.' );
				redirect('masters/subjects');
			}else{
				$this->session->set_flashdata('error', validation_errors());
			}
		}
		$data['activemenu'] = 'masters';
		$data['activesubmenu'] = 'subjects';
		$data['rec'] = $this->Common_Model->FetchData("subjects", "*", "subject_id = $subject_id");
		$this->load->view('masters/editsubject', $data);
	}

	function deletesubject($subject_id = 0){
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$this->Common_Model->DelData("subjects", "subject_id = ".$subject_id);
		$this->session->set_flashdata('success', 'Record deleted successfully.' );
		redirect($_SERVER['HTTP_REFERER']);
	}

	function getSubjectsByClassId(){
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$records = $this->Common_Model->FetchData("subjects", "*", "class_id = '".$this->input->post("class_id")."' ORDER BY subject_name ASC");
		echo '<option value="">select</option>';
		if($records){ for($i=0;$i<count($records);$i++){
			echo '<option value="'.$records[$i]['subject_id'].'">'.$records[$i]['subject_name'].'</option>';
		}}
		die(0);
	}

	public function admissionfees()
	{
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		if($this->input->post('submitBtn')){
			$this->form_validation->set_rules('class_id', 'Class', 'trim|required');
			$this->form_validation->set_error_delimiters('<p class="has-error"><label class="control-label">', '</label></p>');
			if($this->form_validation->run()){
				$data_list = array(
					'session_id'		=> $this->session->userdata('session_id'),
					'class_id'			=> $this->input->post('class_id'),
					'amount'			=> $this->input->post('amount'),
					'amount1'			=> $this->input->post('amount1'),
					'amount2'			=> $this->input->post('amount2'),
					'amount3'			=> $this->input->post('amount3'),
					'amount4'			=> $this->input->post('amount4'),
					'amount5'			=> $this->input->post('amount5'),
					'amount6'			=> $this->input->post('amount6'),
					'amount7'			=> $this->input->post('amount7'),
					//'details'			=> $this->input->post('details')
				);
				$id = $this->Common_Model->dbinsertid("admission_fees", $data_list);
				$this->session->set_flashdata('success', 'Fees Added successfully.' );
				redirect('masters/admissionfees');
			}else{
				$this->session->set_flashdata('error', validation_errors());
			}
		}
		$data['activemenu'] = 'masters';
		$data['activesubmenu'] = 'admissionfees';
		if($this->input->post('searchBtn')){
			$data['records'] = $this->Common_Model->FetchData("admission_fees AS f LEFT JOIN sessions AS s ON f.session_id = s.session_id LEFT JOIN classes AS c ON f.class_id = c.class_id", "*", "f.session_id = ".$this->input->post("session_id"));
			$data['session_id'] = $this->input->post("session_id");
		}else{
			$data['records'] = $this->Common_Model->FetchData("admission_fees AS f LEFT JOIN sessions AS s ON f.session_id = s.session_id LEFT JOIN classes AS c ON f.class_id = c.class_id", "*", "f.session_id = ".$this->session->userdata("session_id"));
			$data['session_id'] = $this->session->userdata("session_id");
		}
		$data['sessions'] = $this->Common_Model->FetchData("sessions", "*", "1 ORDER BY session_id DESC");
		$data['classes'] = $this->Common_Model->FetchData("classes", "*", "1 ORDER BY class_name ASC");
		$this->load->view('masters/admissionfees', $data);
	}

	function editadmissionfees($id = 0){
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		if($this->input->post('submitBtn')){
			$this->form_validation->set_rules('class_id', 'Class', 'trim|required');
			$this->form_validation->set_error_delimiters('<p class="has-error"><label class="control-label">', '</label></p>');
			if($this->form_validation->run()){
				$data_list = array(
					'session_id'		=> $this->session->userdata('session_id'),
					'class_id'			=> $this->input->post('class_id'),
					'amount'			=> $this->input->post('amount'),
					'amount1'			=> $this->input->post('amount1'),
					'amount2'			=> $this->input->post('amount2'),
					'amount3'			=> $this->input->post('amount3'),
					'amount4'			=> $this->input->post('amount4'),
					'amount5'			=> $this->input->post('amount5'),
					'amount6'			=> $this->input->post('amount6'),
					'amount7'			=> $this->input->post('amount7'),
					//'details'			=> $this->input->post('details')
				);
				$this->Common_Model->update_records("admission_fees", "id", $id, $data_list);
				$this->session->set_flashdata('success', 'Fees Updated successfully.' );
				redirect('masters/admissionfees');
			}else{
				$this->session->set_flashdata('error', validation_errors());
			}
		}
		$data['activemenu'] = 'masters';
		$data['activesubmenu'] = 'admissionfees';
		$data['records'] = $this->Common_Model->FetchData("admission_fees AS f LEFT JOIN sessions AS s ON f.session_id = s.session_id LEFT JOIN classes AS c ON f.class_id = c.class_id", "*", "f.session_id = ".$this->session->userdata("session_id"));
		$data['sessions'] = $this->Common_Model->FetchData("sessions", "*", "1 ORDER BY session_id DESC");
		$data['classes'] = $this->Common_Model->FetchData("classes", "*", "1 ORDER BY class_name ASC");
		$data['fee'] = $this->Common_Model->FetchData("admission_fees", "*", "id = $id");
		$this->load->view('masters/editadmissionfees', $data);	
	}

	function deletefees($id = 0){
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$this->Common_Model->DelData("admission_fees", "id = ".$id);
		$this->session->set_flashdata('success', 'Record deleted successfully.' );
		redirect($_SERVER['HTTP_REFERER']);
	}

	function getClassAdmissionFee(){
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$fee = $this->Common_Model->FetchData("admission_fees", "*", "class_id = ".$this->input->post("class_id")." AND session_id = ".$this->input->post("session_id")."");
		echo json_encode($fee[0]);
	}

	function getTransferFeeamount(){
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$fee = $this->Common_Model->FetchData("admission_fees", "*", "class_id = ".$this->input->post("class_id")." AND session_id = ".$this->input->post("session_id")."");
		if($fee){
			echo $fee[0]['amount5'];
		}else{
			echo '0.00';
		}		
	}

	function getEmpListBySession(){
		//var selected = '';
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$records = $this->Common_Model->FetchData("employees", "*", "session_id = ".$this->input->post("session_id")." ORDER BY employee_name ASC");
		$html = '<option value="">select</option>';
		if($records){ for($i=0;$i<count($records);$i++){
			$html.= '<option value="'.$records[$i]['employee_id'].'">'.$records[$i]['employee_name'].'</option>';
		}}
		echo $html;
	}

	function getReadmStudentListBySessionClass(){
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$records = $this->Common_Model->FetchData("student_admission AS sa LEFT JOIN students AS s ON sa.student_id = s.student_id", "s.student_id, s.student_first_name, s.student_last_name", "sa.class_id = ".$this->input->post("class_id")." AND sa.session_id = ".$this->input->post("session_id")." AND s.tc_taken = 'No' AND admission_status = 'Active' AND session_status = 0 ORDER BY s.student_first_name ASC");
		$html = '<option value="">select</option>';
		if($records){ for($i=0;$i<count($records);$i++){
			$html.= '<option value="'.$records[$i]['student_id'].'">'.$records[$i]['student_first_name'].' '.$records[$i]['student_last_name'].'</option>';
		}}
		echo $html;
	}

	function getStudentListBySessionClass1(){
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$records = $this->Common_Model->FetchData("student_admission AS sa LEFT JOIN students AS s ON sa.student_id = s.student_id", "s.student_serial_no,s.student_id, s.student_first_name, s.student_last_name", "sa.class_id = ".$this->input->post("class_id")." AND sa.session_id = ".$this->input->post("session_id")." AND s.student_section = ".$this->input->post("section_id")." AND admission_status = 'Active' ORDER BY s.student_serial_no ASC");
		$html = '<table class="table table-condensed table-bordered"><tr><th>Adm. No.</th><th>Name</th><th colspan="2">Status</th><th>Remarks</th></tr>';
		if($records){ for($i=0;$i<count($records);$i++){
			$html.= '<tr><th>'.$records[$i]['student_serial_no'].'</th><th><input type="hidden" name="student_id[]" value="'.$records[$i]['student_id'].'">'.$records[$i]['student_first_name'].' '.$records[$i]['student_last_name'].'</th><th><input type="radio" name="status'.$records[$i]['student_id'].'" value="1" id="present'.$records[$i]['student_id'].'" checked="checked" class="placedradio" /><label for="present'.$records[$i]['student_id'].'" class="inputplacer3">Present</label></th><th><input type="radio" name="status'.$records[$i]['student_id'].'" value="0" id="absent'.$records[$i]['student_id'].'" class="placedradio" /><label for="absent'.$records[$i]['student_id'].'" class="inputdanger">Absent</label></th><th><input type="text" name="remarks[]" value="" class="form-control"></th></tr>';
		}}
		$html.= '</table>';
		echo $html;
	}

	function getStudentListBySessionClass10(){
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$records = $this->Common_Model->FetchData("student_admission AS sa LEFT JOIN students AS s ON sa.student_id = s.student_id", "s.student_id, s.student_first_name, s.student_last_name", "sa.class_id = ".$this->input->post("class_id")." AND sa.session_id = ".$this->input->post("session_id")." AND s.student_section = ".$this->input->post("section_id")." AND admission_status = 'Active' ORDER BY s.student_first_name ASC");
		$html = '<option value="">select</option>';
		if($records){ for($i=0;$i<count($records);$i++){
			$html.= '<option value="'.$records[$i]['student_id'].'">'.$records[$i]['student_first_name'].' '.$records[$i]['student_last_name'].'</option>';
		}}
		echo $html;
	}

	function getStudentListBySessionClass3to8(){
	    error_reporting(0);
		//print_r($this->session->userdata('exam_term'));exit;
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$res = $this->Common_Model->FetchData("exam_term","*","active_exam_term = 'Active'");
		$inputval = $this->Common_Model->FetchData("addmarkvalidations","*","session_id=".$this->input->post("session_id")." AND class_id=".$this->input->post("class_id")." AND term='".$res[0]['exam_term']."'");
		$validations = json_decode($inputval[0]['validations']);

		$resultshowval = $this->Common_Model->FetchData("resultshowcontrols","*","session_id=".$this->input->post("session_id")." AND class_id=".$this->input->post("class_id")." AND section_id='".$this->input->post("section_id")."' AND term='".$res[0]['exam_term']."'");
		$rscval = json_decode($resultshowval[0]['validations']);
		
		$records = $this->Common_Model->FetchData("student_admission AS sa LEFT JOIN students AS s ON sa.student_id = s.student_id LEFT JOIN exam_result_items as b ON sa.student_id = b.student_id LEFT JOIN exam_results as c ON b.exam_result_id = c.exam_result_id", "*", "sa.class_id = ".$this->input->post("class_id")." AND sa.session_id = ".$this->input->post("session_id")." AND s.student_section = ".$this->input->post("section_id")." AND sa.admission_status = 'Active' AND c.subject_id ='".$this->input->post("subject_id")."' AND c.term ='".$res[0]['exam_term']."'  ORDER BY s.student_serial_no ASC");
		$rec = $this->Common_Model->FetchData("student_admission AS sa LEFT JOIN students AS s ON sa.student_id = s.student_id ", "*", "sa.class_id = ".$this->input->post("class_id")." AND sa.session_id = ".$this->input->post("session_id")." AND s.student_section = ".$this->input->post("section_id")." AND sa.admission_status = 'Active' ORDER BY s.student_serial_no ASC");
		
		$html = '<div style="overflow-x:auto;"><table class="table table-bordered table-condensed table-striped itemslist" width="100%"><tr>
                        <th width="10%">Scholastic Areas</th>
                        <th  width="60%" colspan="6">
                          <select class="form-control" name="exam_term" id="exam_term" required>
                            
                            <option value="'.$res[0]['exam_term'].'">'.$res[0]['exam_term'].'</option>
                            
                          </select>
                        </th>
                        <th width="30%" colspan="2"></th>
                      </tr>
                      <tr>
                        <th width="10%" >Adm. No</th>
                        <th width="20%">Student Name</th>
                        <th width="10%">Attendance</th>
                        <th class="premid text-center" width="10%" colspan="1" >' 
             . ( $res[0]['exam_term'] == 'Term-1 (100 marks)' ? 'Periodic Test-1 (30)' : 'Periodic Test-2 (30)' ) . '</th>
                        
                        <th class="premid text-center" width="10%">' 
             . ( $res[0]['exam_term'] == 'Term-1 (100 marks)' ? 'PT-1 Weightage (10)' : 'PT-2 Weightage (10)' ) . '</th>
                     
                        <th class="portf text-center" width="10%">Portfolio<br>(5)</th>
                        <th class="suben text-center" width="10%">Sub-enrich.<br>(5)</th>
                       	<th class="hy80 text-center" width="10%">' 
             			. ( $res[0]['exam_term'] == 'Term-1 (100 marks)' ? 'Half Yearly<br>(80)' : 'Annual (80)' ) . '</th>
                        <th class="total100 text-center" width="5%">Total<br>(100)</th>
                        <th class="grade text-center" width="5%">Grade</th>
                      </tr>';
		if($records){ for($i=0;$i<count($records);$i++){
			$d = json_decode($records[$i]['subject_studied']);
				//print_r($d);exit;
				if (in_array($this->input->post("subject_id"), $d)) {
				/*$rec = $this->Common_Model->FetchData("","","")*/
			$html.= '<tr><td>'.$records[$i]['student_serial_no'].'</td><td><input type="hidden" name="result_id" value="'.$records[$i]['exam_result_id'].'"><input type="hidden" name="student_id[]" value="'.$records[$i]['student_id'].'">'.$records[$i]['student_first_name'].' '.$records[$i]['student_last_name'].'</td>
			<td width="10%">
				<select class="form-control" name="attend_val[]">
					<option value="Present" '.($records[$i]['attend_val']=='Present'?'selected':'').'>Present</option>
					<option value="Absent" '.($records[$i]['attend_val']=='Absent'?'selected':'').'>Absent</option>
				</select>
			</td>
			<td width="10%">
				'.(in_array('periodictest', $rscval) ? '' : '
			<input type="number" name="pt[]" class="form-control pt marktoadd text-center" step="0.01" '.(in_array('pt', $validations) ? 'readonly' : '').' value="'.$records[$i]['pt'].'">').'</td>
			<td width="10%">
				'.(in_array('ptweightage', $rscval) ? '' : '
			<input type="number" name="pt_weightage[]" class="form-control pt_weightage marktoadd text-center" step="0.01" readonly value="'.$records[$i]['pt_weightage'].'">').'</td>

			<td width="10%">'.(in_array('portfolio', $rscval) ? '' : '
			<input type="number" name="portfolio[]" class="form-control portfolio marktoadd text-center" step="0.01" '.(in_array('Portfolio', $validations) ? 'readonly' : '').' value="'.$records[$i]['portfolio'].'">').'</td>

			<td width="10%">'.(in_array('subenrichment', $rscval) ? '' : '<input type="number" name="sub_enrichment[]" class="form-control sub_enrichment marktoadd text-center" step="0.01" '.(in_array('subenrichment', $validations) ? 'readonly' : '').' value="'.$records[$i]['sub_enrichment'].'">').'</td>

			<td width="10%">'.(in_array('halfyearly', $rscval) ? '' : '<input type="number" name="half_yearly[]" class="form-control half_yearly marktoadd text-center" step="0.01" '.(in_array('halfyearly', $validations) ? 'readonly' : '').' value="'.$records[$i]['half_yearly'].'" >').'</td>

			<td width="5%">'.(in_array('total', $rscval) ? '' : '<input type="number" name="total[]" class="form-control total text-center" step="0.01" readonly value="'.$records[$i]['total'].'">').'</td>

			<td width="5%">'.(in_array('grade', $rscval) ? '' : '<input type="text" name="grade[]" class="form-control grade text-center" readonly value="'.$records[$i]['grade'].'">').'</td></tr>';
		}}}else{ for($i=0;$i<count($rec);$i++){
			$e = json_decode($rec[$i]['subject_studied']);
				//print_r($d);exit;
				if (in_array($this->input->post("subject_id"), $e)) {
			$html.= '<tr><td width="10%">'.$rec[$i]['student_serial_no'].'</td><td width="20%"><input type="hidden" name="student_id[]" value="'.$rec[$i]['student_id'].'">'.$rec[$i]['student_first_name'].' '.$rec[$i]['student_last_name'].'</td>
			<td width="10%">
				<select class="form-control" name="attend_val[]">
					<option value="Present">Present</option>
					<option value="Absent">Absent</option>
				</select>
			</td>
			<td width="10%" ><input type="number" name="pt[]" class="form-control pt marktoadd text-center" step="0.01" '.(in_array('pt', $validations) ? 'readonly' : '').'></td><td width="10%"><input type="number" name="pt_weightage[]" class="form-control pt_weightage marktoadd text-center" step="0.01" readonly ></td><td width="10%"><input type="number" name="portfolio[]" class="form-control portfolio marktoadd text-center" step="0.01" '.(in_array('Portfolio', $validations) ? 'readonly' : '').'></td><td width="10%"><input type="number" name="sub_enrichment[]" class="form-control sub_enrichment marktoadd text-center" step="0.01" '.(in_array('subenrichment', $validations) ? 'readonly' : '').'></td><td width="10%"><input type="number" name="half_yearly[]" class="form-control half_yearly marktoadd text-center" step="0.01" '.(in_array('half_yearly', $validations) ? 'readonly' : '').'></td><td width="5%"><input type="number" name="total[]" class="form-control total text-center" step="0.01" readonly ></td><td width="5%"><input type="text" name="grade[]" class="form-control grade text-center" readonly ></td></tr>';
		}}}

		
		$html.= '</table></div>';
		echo $html;
	}

	function getStudentListBySessionClassNew3to8(){
	    error_reporting(0);
		//print_r($this->session->userdata('exam_term'));exit;
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$res = $this->Common_Model->FetchData("exam_term","*","active_exam_term = 'Active'");
		$inputval = $this->Common_Model->FetchData("addmarkvalidations","*","session_id=".$this->input->post("session_id")." AND class_id=".$this->input->post("class_id")." AND term='".$res[0]['exam_term']."' AND term='".$res[0]['exam_term']."'");
		$validations = json_decode($inputval[0]['validations']);

		$resultshowval = $this->Common_Model->FetchData("resultshowcontrols","*","session_id=".$this->input->post("session_id")." AND class_id=".$this->input->post("class_id")." AND section_id='".$this->input->post("section_id")."' AND term='".$res[0]['exam_term']."'");
		$rscval = json_decode($resultshowval[0]['validations']);
		
		$rec = $this->Common_Model->FetchData("student_admission AS sa LEFT JOIN students AS s ON sa.student_id = s.student_id ", "*", "sa.class_id = ".$this->input->post("class_id")." AND sa.session_id = ".$this->input->post("session_id")." AND s.student_section = ".$this->input->post("section_id")." AND sa.admission_status = 'Active' ORDER BY s.student_serial_no ASC");
		
		$html = '<div style="overflow-x:auto;"><table class="table table-bordered table-condensed table-striped itemslist" width="100%"><tr>
                        <th width="10%">Scholastic Areas</th>
                        <th  width="60%" colspan="6">
                          <select class="form-control" name="exam_term" id="exam_term" required>
                            
                            <option value="'.$res[0]['exam_term'].'">'.$res[0]['exam_term'].'</option>
                            
                          </select>
                        </th>
                        <th width="30%" colspan="2"></th>
                      </tr>
                      <tr>
                        <th width="10%" >Adm. No</th>
                        <th width="20%">Student Name</th>
                        <th class="premid text-center" width="10%" colspan="1" >' 
             . ( $res[0]['exam_term'] == 'Term-1 (100 marks)' ? 'Periodic Test-1 (30)' : 'Periodic Test-2 (30)' ) . '</th>
                        
                        <th class="premid text-center" width="10%">' 
             . ( $res[0]['exam_term'] == 'Term-1 (100 marks)' ? 'PT-1 Weightage (10)' : 'PT-2 Weightage (10)' ) . '</th>
                     
                        <th class="portf text-center" width="10%">Portfolio<br>(5)</th>
                        <th class="suben text-center" width="10%">Sub-enrich.<br>(5)</th>
                       	<th class="hy80 text-center" width="10%">' 
             			. ( $res[0]['exam_term'] == 'Term-1 (100 marks)' ? 'Half Yearly<br>(80)' : 'Annual (80)' ) . '</th>
                        <th class="total100 text-center" width="10%">Total<br>(100)</th>
                        <th class="grade text-center" width="10%">Grade</th>
                      </tr>';
		
		for($i=0;$i<count($rec);$i++){
				$oldstd = $this->Common_Model->FetchData("exam_result_items as a  LEFT JOIN exam_results as b ON a.exam_result_id = b.exam_result_id", "*", "b.class_id = '".$this->input->post("class_id")."' AND b.session_id = '".$this->input->post("session_id")."' AND b.section = '".$this->input->post("section_id")."' AND b.subject_id ='".$this->input->post("subject_id")."' AND b.term ='".$res[0]['exam_term']."' AND a.student_id='".$rec[$i]['student_id']."' ");
			
			if ($oldstd) {
				
			}else{


			$e = json_decode($rec[$i]['subject_studied']);
				//print_r($d);exit;
				if (in_array($this->input->post("subject_id"), $e)) {
			$html.= '<tr><td width="10%">'.$rec[$i]['student_serial_no'].'</td><td width="20%"><input type="hidden" name="student_id[]" value="'.$rec[$i]['student_id'].'">'.$rec[$i]['student_first_name'].' '.$rec[$i]['student_last_name'].'</td><td width="10%" ><input type="number" name="pt[]" class="form-control pt marktoadd text-center" step="0.01" '.(in_array('pt', $validations) ? 'readonly' : '').'></td><td width="10%"><input type="number" name="pt_weightage[]" class="form-control pt_weightage marktoadd text-center" step="0.01" readonly ></td><td width="10%"><input type="number" name="portfolio[]" class="form-control portfolio marktoadd text-center" step="0.01" '.(in_array('Portfolio', $validations) ? 'readonly' : '').'></td><td width="10%"><input type="number" name="sub_enrichment[]" class="form-control sub_enrichment marktoadd text-center" step="0.01" '.(in_array('subenrichment', $validations) ? 'readonly' : '').'></td><td width="10%"><input type="number" name="half_yearly[]" class="form-control half_yearly marktoadd text-center" step="0.01" '.(in_array('half_yearly', $validations) ? 'readonly' : '').'></td><td width="10%"><input type="number" name="total[]" class="form-control total text-center" step="0.01" readonly ></td><td width="10%"><input type="text" name="grade[]" class="form-control grade text-center" readonly ></td></tr>';
				}
			}
		}


		
		$html.= '</table></div>';
		echo $html;
	}

	function getStudentListBySessionClassNurceryto2(){
	    error_reporting(0);
		//print_r($this->session->userdata('exam_term'));exit;
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$res = $this->Common_Model->FetchData("exam_term","*","active_exam_term = 'Active'");
		$inputval = $this->Common_Model->FetchData("addmarkvalidations","*","session_id=".$this->input->post("session_id")." AND class_id=".$this->input->post("class_id")." AND term='".$res[0]['exam_term']."'");
		$validations = json_decode($inputval[0]['validations']);

		$resultshowval = $this->Common_Model->FetchData("resultshowcontrols","*","session_id=".$this->input->post("session_id")." AND class_id=".$this->input->post("class_id")." AND section_id='".$this->input->post("section_id")."' AND term='".$res[0]['exam_term']."'");
		$rscval = json_decode($resultshowval[0]['validations']);
		
		$records = $this->Common_Model->FetchData("student_admission AS sa LEFT JOIN students AS s ON sa.student_id = s.student_id LEFT JOIN exam_result_items as b ON sa.student_id = b.student_id LEFT JOIN exam_results as c ON b.exam_result_id = c.exam_result_id", "*", "sa.class_id = ".$this->input->post("class_id")." AND sa.session_id = ".$this->input->post("session_id")." AND s.student_section = ".$this->input->post("section_id")." AND sa.admission_status = 'Active' AND c.subject_id ='".$this->input->post("subject_id")."' AND c.term ='".$res[0]['exam_term']."'  ORDER BY s.student_serial_no ASC");
		$rec = $this->Common_Model->FetchData("student_admission AS sa LEFT JOIN students AS s ON sa.student_id = s.student_id ", "*", "sa.class_id = ".$this->input->post("class_id")." AND sa.session_id = ".$this->input->post("session_id")." AND s.student_section = ".$this->input->post("section_id")." AND sa.admission_status = 'Active' ORDER BY s.student_serial_no ASC");
		
		$html = '<div style="overflow-x:auto;"><table class="table table-bordered table-condensed table-striped itemslist" width="100%"><tr>
                        <th width="10%">Scholastic Areas</th>
                        <th  width="60%" colspan="6">
                          <select class="form-control" name="exam_term" id="exam_term" required>
                            
                            <option value="'.$res[0]['exam_term'].'">'.$res[0]['exam_term'].'</option>
                            
                          </select>
                        </th>
                        <th width="30%" colspan="2"></th>
                      </tr>
                      <tr>
                        <th width="10%" >Adm. No</th>
                        <th width="20%">Student Name</th>
                        <th width="10%">Attendance</th>
                        <th class="premid text-center" width="10%" colspan="1" >' 
             . ( $res[0]['exam_term'] == 'Term-1 (100 marks)' ? 'Periodic Test-1 (20)' : 'Periodic Test-2 (20)' ) . '</th>
                        
                        <th class="premid text-center" width="10%">' 
             . ( $res[0]['exam_term'] == 'Term-1 (100 marks)' ? 'PT-1 Weightage (10)' : 'PT-2 Weightage (10)' ) . '</th>
                     
                        <th class="portf text-center" width="10%">Portfolio<br>(5)</th>
                        <th class="suben text-center" width="10%">Sub-enrich.<br>(5)</th>
                       	<th class="hy80 text-center" width="8%">' 
             			. ( $res[0]['exam_term'] == 'Term-1 (100 marks)' ? 'Half Yearly<br>(80)' : 'Annual (80)' ) . '</th>
                        <th class="total100 text-center" width="7%">Total<br>(100)</th>
                        <th class="grade text-center" width="5%">Grade</th>
                      </tr>';
		if($records){ for($i=0;$i<count($records);$i++){
			$d = json_decode($records[$i]['subject_studied']);
				//print_r($d);exit;
				if (in_array($this->input->post("subject_id"), $d)) {
				/*$rec = $this->Common_Model->FetchData("","","")*/
			$html.= '<tr><td>'.$records[$i]['student_serial_no'].'</td><td><input type="hidden" name="result_id" value="'.$records[$i]['exam_result_id'].'"><input type="hidden" name="student_id[]" value="'.$records[$i]['student_id'].'">'.$records[$i]['student_first_name'].' '.$records[$i]['student_last_name'].'</td>
			<td width="10%">
				<select class="form-control" name="attend_val[]">
					<option value="Present" '.($records[$i]['attend_val']=='Present'?'selected':'').'>Present</option>
					<option value="Absent" '.($records[$i]['attend_val']=='Absent'?'selected':'').'>Absent</option>
				</select>
			</td>
			<td width="10%">'.(in_array('periodictest', $rscval) ? '' : '<input type="number" name="pt[]" class="form-control pt marktoadd text-center" step="0.01" '.(in_array('pt', $validations) ? 'readonly' : '').' value="'.$records[$i]['pt'].'">').'</td>

			<td width="10%">'.(in_array('ptweightage', $rscval) ? '' : '<input type="number" name="pt_weightage[]" class="form-control pt_weightage marktoadd text-center" step="0.01" readonly value="'.$records[$i]['pt_weightage'].'">').'</td>

			<td width="10%">'.(in_array('portfolio', $rscval) ? '' : '<input type="number" name="portfolio[]" class="form-control portfolio marktoadd text-center" step="0.01" '.(in_array('Portfolio', $validations) ? 'readonly' : '').' value="'.$records[$i]['portfolio'].'">').'</td>

			<td width="10%">'.(in_array('subenrichment', $rscval) ? '' : '<input type="number" name="sub_enrichment[]" class="form-control sub_enrichment marktoadd text-center" step="0.01" '.(in_array('subenrichment', $validations) ? 'readonly' : '').' value="'.$records[$i]['sub_enrichment'].'">').'</td>

			<td width="8%">'.(in_array('halfyearly', $rscval) ? '' : '<input type="number" name="half_yearly[]" class="form-control half_yearly marktoadd text-center" step="0.01" '.(in_array('half_yearly', $validations) ? 'readonly' : '').' value="'.$records[$i]['half_yearly'].'">').'</td>

			<td width="7%">'.(in_array('total', $rscval) ? '' : '<input type="number" name="total[]" class="form-control total text-center" step="0.01" readonly value="'.$records[$i]['total'].'">').'</td>

			<td width="5%">'.(in_array('grade', $rscval) ? '' : '<input type="text" name="grade[]" class="form-control grade text-center" readonly value="'.$records[$i]['grade'].'">').'</td></tr>';
		}}}else{ for($i=0;$i<count($rec);$i++){
			$e = json_decode($rec[$i]['subject_studied']);
				//print_r($d);exit;
				if (in_array($this->input->post("subject_id"), $e)) {
			$html.= '<tr><td width="10%">'.$rec[$i]['student_serial_no'].'</td><td width="20%"><input type="hidden" name="student_id[]" value="'.$rec[$i]['student_id'].'">'.$rec[$i]['student_first_name'].' '.$rec[$i]['student_last_name'].'</td>
			<td width="10%">
				<select class="form-control" name="attend_val[]" >
					<option value="Present">Present</option>
					<option value="Absent">Absent</option> 
				</select>
			</td>
			<td width="10%" ><input type="number" name="pt[]" class="form-control pt marktoadd text-center" step="0.01" '.(in_array('pt', $validations) ? 'readonly' : '').'></td><td width="10%"><input type="number" name="pt_weightage[]" class="form-control pt_weightage marktoadd text-center" step="0.01" readonly ></td><td width="10%"><input type="number" name="portfolio[]" class="form-control portfolio marktoadd text-center" step="0.01" '.(in_array('Portfolio', $validations) ? 'readonly' : '').'></td><td width="10%"><input type="number" name="sub_enrichment[]" class="form-control sub_enrichment marktoadd text-center" step="0.01" '.(in_array('subenrichment', $validations) ? 'readonly' : '').'></td><td width="8%"><input type="number" name="half_yearly[]" class="form-control half_yearly marktoadd text-center" step="0.01" '.(in_array('half_yearly', $validations) ? 'readonly' : '').'></td><td width="7%"><input type="number" name="total[]" class="form-control total text-center" step="0.01" readonly ></td><td width="5%"><input type="text" name="grade[]" class="form-control grade text-center" readonly ></td></tr>';
		}}}

		
		$html.= '</table></div>';
		echo $html;
	}

	function getStudentListBySessionClassNewNurceryto2(){
	    error_reporting(0);
		//print_r($this->session->userdata('exam_term'));exit;
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$res = $this->Common_Model->FetchData("exam_term","*","active_exam_term = 'Active'");
		$inputval = $this->Common_Model->FetchData("addmarkvalidations","*","session_id=".$this->input->post("session_id")." AND class_id=".$this->input->post("class_id")." AND term='".$res[0]['exam_term']."'");
		$validations = json_decode($inputval[0]['validations']);

		$resultshowval = $this->Common_Model->FetchData("resultshowcontrols","*","session_id=".$this->input->post("session_id")." AND class_id=".$this->input->post("class_id")." AND section_id='".$this->input->post("section_id")."' AND term='".$res[0]['exam_term']."'");
		$rscval = json_decode($resultshowval[0]['validations']);
		
		
		$rec = $this->Common_Model->FetchData("student_admission AS sa LEFT JOIN students AS s ON sa.student_id = s.student_id ", "*", "sa.class_id = ".$this->input->post("class_id")." AND sa.session_id = ".$this->input->post("session_id")." AND s.student_section = ".$this->input->post("section_id")." AND sa.admission_status = 'Active' ORDER BY s.student_serial_no ASC");
		
		$html = '<div style="overflow-x:auto;"><table class="table table-bordered table-condensed table-striped itemslist" width="100%"><tr>
                        <th width="10%">Scholastic Areas</th>
                        <th  width="60%" colspan="6">
                          <select class="form-control" name="exam_term" id="exam_term" required>
                            
                            <option value="'.$res[0]['exam_term'].'">'.$res[0]['exam_term'].'</option>
                            
                          </select>
                        </th>
                        <th width="30%" colspan="2"></th>
                      </tr>
                      <tr>
                        <th width="10%" >Adm. No</th>
                        <th width="20%">Student Name</th>
                        <th class="premid text-center" width="10%" colspan="1" >' 
             . ( $res[0]['exam_term'] == 'Term-1 (100 marks)' ? 'Periodic Test-1 (20)' : 'Periodic Test-2 (20)' ) . '</th>
                        
                        <th class="premid text-center" width="10%">' 
             . ( $res[0]['exam_term'] == 'Term-1 (100 marks)' ? 'PT-1 Weightage (10)' : 'PT-2 Weightage (10)' ) . '</th>
                     
                        <th class="portf text-center" width="10%">Portfolio<br>(5)</th>
                        <th class="suben text-center" width="10%">Sub-enrich.<br>(5)</th>
                       	<th class="hy80 text-center" width="10%">' 
             			. ( $res[0]['exam_term'] == 'Term-1 (100 marks)' ? 'Half Yearly<br>(80)' : 'Annual (80)' ) . '</th>
                        <th class="total100 text-center" width="10%">Total<br>(100)</th>
                        <th class="grade text-center" width="10%">Grade</th>
                      </tr>';
		for($i=0;$i<count($rec);$i++){
				$oldstd = $this->Common_Model->FetchData("exam_result_items as a  LEFT JOIN exam_results as b ON a.exam_result_id = b.exam_result_id", "*", "b.class_id = '".$this->input->post("class_id")."' AND b.session_id = '".$this->input->post("session_id")."' AND b.section = '".$this->input->post("section_id")."' AND b.subject_id ='".$this->input->post("subject_id")."' AND b.term ='".$res[0]['exam_term']."' AND a.student_id='".$rec[$i]['student_id']."' ");
			
			if ($oldstd) {
				
			}else{

			$e = json_decode($rec[$i]['subject_studied']);
				//print_r($d);exit;
				if (in_array($this->input->post("subject_id"), $e)) {
			$html.= '<tr><td width="10%">'.$rec[$i]['student_serial_no'].'</td><td width="20%"><input type="hidden" name="student_id[]" value="'.$rec[$i]['student_id'].'">'.$rec[$i]['student_first_name'].' '.$rec[$i]['student_last_name'].'</td><td width="10%" ><input type="number" name="pt[]" class="form-control pt marktoadd text-center" step="0.01" '.(in_array('pt', $validations) ? 'readonly' : '').'></td><td width="10%"><input type="number" name="pt_weightage[]" class="form-control pt_weightage marktoadd text-center" step="0.01" readonly ></td><td width="10%"><input type="number" name="portfolio[]" class="form-control portfolio marktoadd text-center" step="0.01" '.(in_array('Portfolio', $validations) ? 'readonly' : '').'></td><td width="10%"><input type="number" name="sub_enrichment[]" class="form-control sub_enrichment marktoadd text-center" step="0.01" '.(in_array('subenrichment', $validations) ? 'readonly' : '').'></td><td width="10%"><input type="number" name="half_yearly[]" class="form-control half_yearly marktoadd text-center" step="0.01" '.(in_array('half_yearly', $validations) ? 'readonly' : '').'></td><td width="10%"><input type="number" name="total[]" class="form-control total text-center" step="0.01" readonly ></td><td width="10%"><input type="text" name="grade[]" class="form-control grade text-center" readonly ></td></tr>';
				}
			}
		}

		
		$html.= '</table></div>';
		echo $html;
	}

	function getStudentListBySessionClassstd9(){
	    error_reporting(0);
		
		$class_id = $this->input->post("class_id");
		$subject_id = $this->input->post("subject_id");

		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$res = $this->Common_Model->FetchData("exam_term","*","active_exam_term = 'Active'");
		$inputval = $this->Common_Model->FetchData("addmarkvalidations","*","session_id='".$this->input->post("session_id")."' AND class_id='".$this->input->post("class_id")."' AND term='".$res[0]['exam_term']."'");
		$validations = json_decode($inputval[0]['validations']);

		$resultshowval = $this->Common_Model->FetchData("resultshowcontrols","*","session_id=".$this->input->post("session_id")." AND class_id=".$this->input->post("class_id")." AND section_id='".$this->input->post("section_id")."' AND term='".$res[0]['exam_term']."'");
		$rscval = json_decode($resultshowval[0]['validations']);
		
		$records = $this->Common_Model->FetchData("student_admission AS sa LEFT JOIN students AS s ON sa.student_id = s.student_id LEFT JOIN exam_result_items as b ON sa.student_id = b.student_id LEFT JOIN exam_results as c ON b.exam_result_id = c.exam_result_id", "*", "sa.class_id = ".$this->input->post("class_id")." AND sa.session_id = ".$this->input->post("session_id")." AND s.student_section = ".$this->input->post("section_id")." AND sa.admission_status = 'Active' AND c.subject_id ='".$this->input->post("subject_id")."' AND c.term ='".$res[0]['exam_term']."'  ORDER BY s.student_serial_no ASC");
		$rec = $this->Common_Model->FetchData("student_admission AS sa LEFT JOIN students AS s ON sa.student_id = s.student_id ", "*", "sa.class_id = ".$this->input->post("class_id")." AND sa.session_id = ".$this->input->post("session_id")." AND s.student_section = ".$this->input->post("section_id")." AND sa.admission_status = 'Active' ORDER BY s.student_serial_no ASC");
		if($res[0]['exam_term'] == 'Term-1 (100 marks)'){
		$html = '<div style="overflow-x:auto;"><table class="table table-bordered table-condensed table-striped itemslist" width="100%"><tr>
                        <th width="10%">Scholastic Areas</th>
                        <th  width="60%" colspan="6">
                          <select class="form-control" name="exam_term" id="exam_term" required>
                            
                            <option value="'.$res[0]['exam_term'].'">'.$res[0]['exam_term'].'</option>
                            
                          </select>
                        </th>
                        <th width="30%" colspan="2"></th>
                      </tr>
                      <tr>
                        <th width="10%" >Adm. No</th>
                        <th width="20%">Student Name</th>
                        <th width="10%">Attendance</th>

                        <th class="opt text-center" width="10%" colspan="1" >Periodic Test-1<br>('. ( $subject_id == "296" || $subject_id == "234" ? '25':'30').')</th>

                        ' . ( $subject_id == "296"  || $subject_id == "234" ? '<th class="otheory text-center" width="10%">Theory<br>(25)</th>
                        <th class="opractical text-center" width="10%">Practical<br>(25)</th>' : '
                       	<th class="ohalf_yearly text-center" width="10%">Half Yearly<br>(80)</th>' ) . '
                        
             			
                        
                      </tr>';
		if($records){ for($i=0;$i<count($records);$i++){
			$d = json_decode($records[$i]['subject_studied']);
				//print_r($d);exit;
				if (in_array($this->input->post("subject_id"), $d)) {
				/*$rec = $this->Common_Model->FetchData("","","")*/
			$html.= '<tr><td>'.$records[$i]['student_serial_no'].'</td><td><input type="hidden" name="result_id" value="'.$records[$i]['exam_result_id'].'"><input type="hidden" name="student_id[]" value="'.$records[$i]['student_id'].'">'.$records[$i]['student_first_name'].' '.$records[$i]['student_last_name'].'</td>
			<td width="10%">
				<select class="form-control" name="attend_val[]">
					<option value="Present" '.($records[$i]['attend_val']=='Present'?'selected':'').'>Present</option>
					<option value="Absent" '.($records[$i]['attend_val']=='Absent'?'selected':'').'>Absent</option>
				</select>
			</td>
			<td width="10%" class="opt">'.(in_array('periodictest', $rscval) ? '' : '<input type="number" name="pt[]" class="form-control pt marktoadd text-center" step="0.01" '.(in_array('periodictest', $validations) ? 'readonly' : '').' value="'.$records[$i]['pt'].'">').'</td>
			' . ( $subject_id == "296" || $subject_id == "234" ? '<td class="otheory">'.(in_array('halfyearly', $rscval) ? '' : '<input type="number" name="theory[]" class="form-control theory marktoadd text-center" step="0.01" value="'.$records[$i]['theory'].'" '.(in_array('halfyearly', $validations) ? 'readonly' : '').'></td><td class="opractical"><input type="number" name="practical[]" class="form-control practical marktoadd text-center" step="0.01" value="'.$records[$i]['practical'].'" '.(in_array('halfyearly', $validations) ? 'readonly' : '').'>').'</td>
				' : '
				<td width="10%" class="ohalf_yearly">'.(in_array('halfyearly', $rscval) ? '' : '<input type="number" name="half_yearly[]" class="form-control half_yearly marktoadd text-center" step="0.01" '.(in_array('halfyearly', $validations) ? 'readonly' : '').' value="'.$records[$i]['half_yearly'].'">').'</td>' ) . '
			</tr>';
		}}}else{ for($i=0;$i<count($rec);$i++){
			$e = json_decode($rec[$i]['subject_studied']);
				//print_r($d);exit;
				if (in_array($this->input->post("subject_id"), $e)) {
			$html.= '<tr><td width="10%">'.$rec[$i]['student_serial_no'].'</td><td width="20%"><input type="hidden" name="student_id[]" value="'.$rec[$i]['student_id'].'">'.$rec[$i]['student_first_name'].' '.$rec[$i]['student_last_name'].'</td>
			<td width="10%">
				<select class="form-control" name="attend_val[]">
					<option value="Present">Present</option>
					<option value="Absent">Absent</option>
				</select>
			</td>
			<td width="10%" class="opt"><input type="number" name="pt[]" class="form-control pt marktoadd text-center" step="0.01" '.(in_array('periodictest', $validations) ? 'readonly' : '').'></td>'. ( $subject_id == "296" || $subject_id == "234" ? '<td class="otheory"><input type="number" name="theory[]" class="form-control theory marktoadd text-center" step="0.01" value="" '.(in_array('halfyearly', $validations) ? 'readonly' : '').'></td><td class="opractical"><input type="number" name="practical[]" class="form-control practical marktoadd text-center" step="0.01" value="" '.(in_array('halfyearly', $validations) ? 'readonly' : '').'></td>' : '<td width="10%" class="ohalf_yearly"><input type="number" name="half_yearly[]" class="form-control half_yearly marktoadd text-center" step="0.01" '.(in_array('halfyearly', $validations) ? 'readonly' : '').'></td>' ) . '</tr>';
		}}}

		
		$html.= '</table></div>';
	}else {
			$html = '<div style="overflow-x:auto;"><table class="table table-bordered table-condensed table-striped itemslist" width="100%"><tr>
                        <th width="10%">Scholastic Areas</th>
                        <th  width="60%" colspan="6">
                          <select class="form-control" name="exam_term" id="exam_term" required>
                            
                            <option value="'.$res[0]['exam_term'].'">'.$res[0]['exam_term'].'</option>
                            
                          </select>
                        </th>
                        <th width="30%" colspan="2"></th>
                      </tr>
                      <tr>
                        <th width="10%" >Adm. No</th>
                        <th width="20%">Student Name</th>
                        <th width="10%">Attendance</th>
                        <th class="opt text-center" width="10%" colspan="1" >PT-2<br>('. ( $subject_id == "296" || $subject_id == "234" ? '25':'30').')</th>


                        ' . ( $subject_id == "296"  || $subject_id == "234" ? '<th class="otheory text-center" width="10%">Theory<br>(25)</th>
                        <th class="opractical text-center" width="10%">Practical<br>(25)</th>' : '
                        <th class="m_assessment text-center" width="10%">M.Assessment<br>(5)</th>
                        <th class="portfolio text-center" width="10%">Portfolio<br>(5)</th>
                        <th class="ohalf_yearly text-center" width="10%">Sub.Enrichment<br>(5)</th>
                       	<th class="ohalf_yearly text-center" width="10%">Annual<br>(80)</th>' ) . '
                        
             			
                        
                      </tr>';
		if($records){ for($i=0;$i<count($records);$i++){
			$d = json_decode($records[$i]['subject_studied']);
				//print_r($d);exit;
				if (in_array($this->input->post("subject_id"), $d)) {
				/*$rec = $this->Common_Model->FetchData("","","")*/
			$html.= '<tr><td>'.$records[$i]['student_serial_no'].'</td><td><input type="hidden" name="result_id" value="'.$records[$i]['exam_result_id'].'"><input type="hidden" name="student_id[]" value="'.$records[$i]['student_id'].'">'.$records[$i]['student_first_name'].' '.$records[$i]['student_last_name'].'</td>
			<td width="10%">
				<select class="form-control" name="attend_val[]">
					<option value="Present" '.($records[$i]['attend_val']=='Present'?'selected':'').'>Present</option>
					<option value="Absent" '.($records[$i]['attend_val']=='Absent'?'selected':'').'>Absent</option>
				</select>
			</td>
			<td width="10%" class="opt">'.(in_array('periodictest', $rscval) ? '' : '<input type="number" name="pt[]" class="form-control pt marktoadd text-center" step="0.01" '.(in_array('periodictest', $validations) ? 'readonly' : '').' value="'.$records[$i]['pt'].'">').'</td>
			' . ( $subject_id == "296" || $subject_id == "234" ? '<td class="otheory">'.(in_array('halfyearly', $rscval) ? '' : '<input type="number" name="theory[]" class="form-control theory marktoadd text-center" step="0.01" value="'.$records[$i]['theory'].'" '.(in_array('halfyearly', $validations) ? 'readonly' : '').'></td><td class="opractical"><input type="number" name="practical[]" class="form-control practical marktoadd text-center" step="0.01" value="'.$records[$i]['practical'].'" '.(in_array('halfyearly', $validations) ? 'readonly' : '').'>').'</td>
				' : '<td width="10%" class="massessment">'.(in_array('massessment', $rscval) ? '' : '<input type="number" name="m_assessment[]" class="form-control m_assessment marktoadd text-center" step="0.01" '.(in_array('multipleassessment', $validations) ? 'readonly' : '').' value="'.$records[$i]['m_assessment'].'">').'</td><td width="10%" class="portfolioo">'.(in_array('portfolio', $rscval) ? '' : '<input type="number" name="portfolio[]" class="form-control portfolio marktoadd text-center" step="0.01" '.(in_array('portfolio', $validations) ? 'readonly' : '').' value="'.$records[$i]['portfolio'].'">').'</td><td width="10%" class="senrichment">'.(in_array('subenrichmment', $rscval) ? '' : '<input type="number" name="sub_enrichment[]" class="form-control s_enrichment marktoadd text-center" step="0.01" '.(in_array('subenrichment', $validations) ? 'readonly' : '').' value="'.$records[$i]['sub_enrichment'].'">').'</td>
				<td width="10%" class="ohalf_yearly">'.(in_array('halfyearly', $rscval) ? '' : '<input type="number" name="half_yearly[]" class="form-control half_yearly marktoadd text-center" step="0.01" '.(in_array('halfyearly', $validations) ? 'readonly' : '').' value="'.$records[$i]['half_yearly'].'">').'</td>' ) . '
			</tr>';
		}}}else{ for($i=0;$i<count($rec);$i++){
			$e = json_decode($rec[$i]['subject_studied']);
				//print_r($d);exit;
				if (in_array($this->input->post("subject_id"), $e)) {
			$html.= '<tr><td width="10%">'.$rec[$i]['student_serial_no'].'</td><td width="20%"><input type="hidden" name="student_id[]" value="'.$rec[$i]['student_id'].'">'.$rec[$i]['student_first_name'].' '.$rec[$i]['student_last_name'].'</td>
			<td width="10%">
				<select class="form-control" name="attend_val[]">
					<option value="Present">Present</option>
					<option value="Absent">Absent</option>
				</select>
			</td>
			<td width="10%" class="opt"><input type="number" name="pt[]" class="form-control pt marktoadd text-center" step="0.01" '.(in_array('periodictest', $validations) ? 'readonly' : '').'></td>'. ( $subject_id == "296" || $subject_id == "234" ? '<td class="otheory"><input type="number" name="theory[]" class="form-control theory marktoadd text-center" step="0.01" value="" '.(in_array('halfyearly', $validations) ? 'readonly' : '').'></td><td class="opractical"><input type="number" name="practical[]" class="form-control practical marktoadd text-center" step="0.01" value="" '.(in_array('halfyearly', $validations) ? 'readonly' : '').'></td>' : '<td width="10%" class="massessment"><input type="number" name="m_assessment[]" class="form-control m_assessment marktoadd text-center" step="0.01" '.(in_array('multipleassessment', $validations) ? 'readonly' : '').'></td><td width="10%" class="portfolioo"><input type="number" name="portfolio[]" class="form-control portfolio marktoadd text-center" step="0.01" '.(in_array('portfolio', $validations) ? 'readonly' : '').'></td><td width="10%" class="senrichment"><input type="number" name="sub_enrichment[]" class="form-control s_enrichment marktoadd text-center" step="0.01" '.(in_array('subenrichment', $validations) ? 'readonly' : '').'></td><td width="10%" class="ohalf_yearly"><input type="number" name="half_yearly[]" class="form-control half_yearly marktoadd text-center" step="0.01" '.(in_array('halfyearly', $validations) ? 'readonly' : '').'></td>' ) . '</tr>';
		}}}

		
		$html.= '</table></div>';
	}
		echo $html;
		
	}

	function getStudentListBySessionClassNewstd9(){
	    error_reporting(0);
		
		$class_id = $this->input->post("class_id");
		$subject_id = $this->input->post("subject_id");

		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$res = $this->Common_Model->FetchData("exam_term","*","active_exam_term = 'Active'");
		$inputval = $this->Common_Model->FetchData("addmarkvalidations","*","session_id='".$this->input->post("session_id")."' AND class_id='".$this->input->post("class_id")."' AND term='".$res[0]['exam_term']."'");
		$validations = json_decode($inputval[0]['validations']);

		$resultshowval = $this->Common_Model->FetchData("resultshowcontrols","*","session_id=".$this->input->post("session_id")." AND class_id=".$this->input->post("class_id")." AND section_id='".$this->input->post("section_id")."' AND term='".$res[0]['exam_term']."'");
		$rscval = json_decode($resultshowval[0]['validations']);
		
		
		$rec = $this->Common_Model->FetchData("student_admission AS sa LEFT JOIN students AS s ON sa.student_id = s.student_id ", "*", "sa.class_id = ".$this->input->post("class_id")." AND sa.session_id = ".$this->input->post("session_id")." AND s.student_section = ".$this->input->post("section_id")." AND sa.admission_status = 'Active' ORDER BY s.student_serial_no ASC");
		if($res[0]['exam_term'] == 'Term-1 (100 marks)'){
		$html = '<div style="overflow-x:auto;"><table class="table table-bordered table-condensed table-striped itemslist" width="100%"><tr>
                        <th width="10%">Scholastic Areas</th>
                        <th  width="60%" colspan="6">
                          <select class="form-control" name="exam_term" id="exam_term" required>
                            
                            <option value="'.$res[0]['exam_term'].'">'.$res[0]['exam_term'].'</option>
                            
                          </select>
                        </th>
                        <th width="30%" colspan="2"></th>
                      </tr>
                      <tr>
                        <th width="10%" >Adm. No</th>
                        <th width="20%">Student Name</th>
                        <th class="opt text-center" width="10%" colspan="1" >Periodic Test-1<br>('. ( $subject_id == "296" || $subject_id == "234" ? '25':'30').')</th>

                        ' . ( $subject_id == "296"  || $subject_id == "234" ? '<th class="otheory text-center" width="10%">Theory<br>(25)</th>
                        <th class="opractical text-center" width="10%">Practical<br>(25)</th>' : '
                       	<th class="ohalf_yearly text-center" width="10%">Half Yearly<br>(80)</th>' ) . '
                        
             			
                        
                      </tr>';
		for($i=0;$i<count($rec);$i++){

				$oldstd = $this->Common_Model->FetchData("exam_result_items as a  LEFT JOIN exam_results as b ON a.exam_result_id = b.exam_result_id", "*", "b.class_id = '".$this->input->post("class_id")."' AND b.session_id = '".$this->input->post("session_id")."' AND b.section = '".$this->input->post("section_id")."' AND b.subject_id ='".$this->input->post("subject_id")."' AND b.term ='".$res[0]['exam_term']."' AND a.student_id='".$rec[$i]['student_id']."' ");
			
			if ($oldstd) {
				
			}else{

			$e = json_decode($rec[$i]['subject_studied']);
				//print_r($d);exit;
				if (in_array($this->input->post("subject_id"), $e)) {
			$html.= '<tr><td width="10%">'.$rec[$i]['student_serial_no'].'</td><td width="20%"><input type="hidden" name="student_id[]" value="'.$rec[$i]['student_id'].'">'.$rec[$i]['student_first_name'].' '.$rec[$i]['student_last_name'].'</td><td width="10%" class="opt"><input type="number" name="pt[]" class="form-control pt marktoadd text-center" step="0.01" '.(in_array('periodictest', $validations) ? 'readonly' : '').'></td>'. ( $subject_id == "296" || $subject_id == "234" ? '<td class="otheory"><input type="number" name="theory[]" class="form-control theory marktoadd text-center" step="0.01" value="" '.(in_array('halfyearly', $validations) ? 'readonly' : '').'></td><td class="opractical"><input type="number" name="practical[]" class="form-control practical marktoadd text-center" step="0.01" value="" '.(in_array('halfyearly', $validations) ? 'readonly' : '').'></td>' : '<td width="10%" class="ohalf_yearly"><input type="number" name="half_yearly[]" class="form-control half_yearly marktoadd text-center" step="0.01" '.(in_array('halfyearly', $validations) ? 'readonly' : '').'></td>' ) . '</tr>';
				}
			}
		}

		
		$html.= '</table></div>';
	}else {
			$html = '<div style="overflow-x:auto;"><table class="table table-bordered table-condensed table-striped itemslist" width="100%"><tr>
                        <th width="10%">Scholastic Areas</th>
                        <th  width="60%" colspan="6">
                          <select class="form-control" name="exam_term" id="exam_term" required>
                            
                            <option value="'.$res[0]['exam_term'].'">'.$res[0]['exam_term'].'</option>
                            
                          </select>
                        </th>
                        <th width="30%" colspan="2"></th>
                      </tr>
                      <tr>
                        <th width="10%" >Adm. No</th>
                        <th width="20%">Student Name</th>
                        <th class="opt text-center" width="10%" colspan="1" >PT-2<br>('. ( $subject_id == "296" || $subject_id == "234" ? '25':'30').')</th>


                        ' . ( $subject_id == "296"  || $subject_id == "234" ? '<th class="otheory text-center" width="10%">Theory<br>(25)</th>
                        <th class="opractical text-center" width="10%">Practical<br>(25)</th>' : '
                        <th class="m_assessment text-center" width="10%">M.Assessment<br>(5)</th>
                        <th class="portfolio text-center" width="10%">Portfolio<br>(5)</th>
                        <th class="ohalf_yearly text-center" width="10%">Sub.Enrichment<br>(5)</th>
                       	<th class="ohalf_yearly text-center" width="10%">Annual<br>(80)</th>' ) . '
                        
             			
                        
                      </tr>';
		for($i=0;$i<count($rec);$i++){

				$oldstd = $this->Common_Model->FetchData("exam_result_items as a  LEFT JOIN exam_results as b ON a.exam_result_id = b.exam_result_id", "*", "b.class_id = '".$this->input->post("class_id")."' AND b.session_id = '".$this->input->post("session_id")."' AND b.section = '".$this->input->post("section_id")."' AND b.subject_id ='".$this->input->post("subject_id")."' AND b.term ='".$res[0]['exam_term']."' AND a.student_id='".$rec[$i]['student_id']."' ");
			
			if ($oldstd) {
				
			}else{

			$e = json_decode($rec[$i]['subject_studied']);
				//print_r($d);exit;
				if (in_array($this->input->post("subject_id"), $e)) {
			$html.= '<tr><td width="10%">'.$rec[$i]['student_serial_no'].'</td><td width="20%"><input type="hidden" name="student_id[]" value="'.$rec[$i]['student_id'].'">'.$rec[$i]['student_first_name'].' '.$rec[$i]['student_last_name'].'</td><td width="10%" class="opt"><input type="number" name="pt[]" class="form-control pt marktoadd text-center" step="0.01" '.(in_array('periodictest', $validations) ? 'readonly' : '').'></td>'. ( $subject_id == "296" || $subject_id == "234" ? '<td class="otheory"><input type="number" name="theory[]" class="form-control theory marktoadd text-center" step="0.01" value="" '.(in_array('halfyearly', $validations) ? 'readonly' : '').'></td><td class="opractical"><input type="number" name="practical[]" class="form-control practical marktoadd text-center" step="0.01" value="" '.(in_array('halfyearly', $validations) ? 'readonly' : '').'></td>' : '<td width="10%" class="massessment"><input type="number" name="m_assessment[]" class="form-control m_assessment marktoadd text-center" step="0.01" '.(in_array('multipleassessment', $validations) ? 'readonly' : '').'></td><td width="10%" class="portfolioo"><input type="number" name="portfolio[]" class="form-control portfolio marktoadd text-center" step="0.01" '.(in_array('portfolio', $validations) ? 'readonly' : '').'></td><td width="10%" class="senrichment"><input type="number" name="sub_enrichment[]" class="form-control s_enrichment marktoadd text-center" step="0.01" '.(in_array('subenrichment', $validations) ? 'readonly' : '').'></td><td width="10%" class="ohalf_yearly"><input type="number" name="half_yearly[]" class="form-control half_yearly marktoadd text-center" step="0.01" '.(in_array('halfyearly', $validations) ? 'readonly' : '').'></td>' ) . '</tr>';
				}
			}
		}

		
		$html.= '</table></div>';
	}
		echo $html;
		
	}

	function get_totworkdatval(){
		$res = $this->Common_Model->FetchData("exam_term","*","active_exam_term = 'Active'");

		$inputval = $this->Common_Model->FetchData("addmarkvalidations","*","session_id=".$this->input->post("session_id")." AND class_id=".$this->input->post("class_id")." AND term='".$res[0]['exam_term']."'");
		$validations = json_decode($inputval[0]['validations']);

		if(in_array('totalworkingdays', $validations)){
			$html = 'True';
		}else{
			$html = 'False';
		}
		echo $html;
	}

	function get_totworkdatvalhide(){
		$res = $this->Common_Model->FetchData("exam_term","*","active_exam_term = 'Active'");

		$resultshowval = $this->Common_Model->FetchData("resultshowcontrols","*","session_id=".$this->input->post("session_id")." AND class_id=".$this->input->post("class_id")." AND section_id='".$this->input->post("section_id")."' AND term='".$res[0]['exam_term']."'");
		$rscval = json_decode($resultshowval[0]['validations']);

		 if(in_array('totalworkingdays', $rscval)){
			$html = 'Hide';
		}else{
			$html = 'False';
		}
		echo $html;
	}
	
function getStudentListBySessionClass23(){
	
    error_reporting(0);
		//$html='res';echo $html;exit;
		//print_r($this->session->userdata('exam_term'));exit;
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$res = $this->Common_Model->FetchData("exam_term","*","active_exam_term = 'Active'");
		$ssn = $this->session->userdata('session_id');

		$inputval = $this->Common_Model->FetchData("addmarkvalidations","*","session_id=".$this->input->post("session_id")." AND class_id=".$this->input->post("class_id")." AND term='".$res[0]['exam_term']."'");
		$validations = json_decode($inputval[0]['validations']);

		$resultshowval = $this->Common_Model->FetchData("resultshowcontrols","*","session_id=".$this->input->post("session_id")." AND class_id=".$this->input->post("class_id")." AND section_id='".$this->input->post("section_id")."' AND term='".$res[0]['exam_term']."'");
		$rscval = json_decode($resultshowval[0]['validations']);

		$records = $this->Common_Model->FetchData("student_admission AS sa LEFT JOIN students AS s ON sa.student_id = s.student_id LEFT JOIN exam_remark_items as b ON sa.student_id = b.student_id LEFT JOIN exam_remarks as c ON b.exam_remark_id = c.exam_remark_id", "*", "sa.class_id = ".$this->input->post("class_id")." AND sa.session_id = ".$this->input->post("session_id")." AND s.student_section = ".$this->input->post("section_id")." AND admission_status = 'Active' AND c.term ='".$res[0]['exam_term']."'  ORDER BY s.student_serial_no ASC");
		$rem = $this->Common_Model->FetchData("student_admission AS sa LEFT JOIN students AS s ON sa.student_id = s.student_id ", "*", "sa.class_id = ".$this->input->post("class_id")." AND sa.session_id = ".$this->input->post("session_id")." AND s.student_section = ".$this->input->post("section_id")." AND admission_status = 'Active' ORDER BY s.student_serial_no ASC");
		//print_r($rec);exit;
		$html = '<table class="table table-condensed table-bordered"><tr>
                        <th>Scholastic Areas</th>
                        <th colspan="6">
                          <select class="form-control" name="exam_term" id="exam_term" required>
                            
                            <option value="'.$res[0]['exam_term'].'">'.$res[0]['exam_term'].'</option>
                            
                          </select>
                        </th>
                      </tr>
                      <tr>
                        
                        <th style="width: 3%;">Adm.No.</th>
                        <th style="width: 15%;">Student Name</th>
                        
                        <th style="width: 10%;">Discipline Grade</th>
                        <th style="width: 10%;">Total Working Days</th>
                        <th style="width: 7%;">Total Attendance</th>
                        <th style="width: 5%;">grade</th>
                        <th style="width: 50%;">Remarks</th>

                        
                      </tr>';
		if($records){ for($i=0;$i<count($records);$i++){
				/*$rec = $this->Common_Model->FetchData("","","")*/
			$html.= '<tr><td>'.$records[$i]['student_serial_no'].'</td><td><input type="hidden" name="result_id" value="'.$records[$i]['exam_remark_id'].'"><input type="hidden" name="student_id[]" value="'.$records[$i]['student_id'].'">'.$records[$i]['student_first_name'].' '.$records[$i]['student_last_name'].'</td><td>'.(in_array('disciplinegrade', $rscval) ? '' : '<select type="text" class="form-control " id="discipline_grade" name="discipline_grade[]">
                            <option value="A" ' 
             . ( $records[$i]['dg'] == "A" ? 'selected="selected"' : '' ) . '>A</option>
                            <option value="B" ' 
             . ( $records[$i]['dg'] == "B" ? 'selected="selected"' : '' ) . '>B</option>
                            <option value="C" ' 
             . ( $records[$i]['dg'] == "C" ? 'selected="selected"' : '' ) . '>C</option>
                            
                          </select>').'</td><td>'.(in_array('totalworkingdays', $rscval) ? '' : '<input type="number" class="form-control twd" id="twd" name="twd[]" value="'.$records[$i]['twd'].'" readonly >').'</td><td>'.(in_array('totalattendance', $rscval) ? '' : '<input type="number" class="form-control" id="ta" name="ta[]" value="'.$records[$i]['ta'].'" '.(in_array('totalattendance', $validations) ? 'readonly' : '').'>').'</td>';

                          $recor = $this->Common_Model->FetchData("exam_result_items as s LEFT JOIN exam_results as r ON r.exam_result_id=s.exam_result_id LEFT JOIN sessions as t ON r.session_id=t.session_id LEFT JOIN classes AS c ON r.class_id = c.class_id LEFT JOIN sections AS d ON r.section = d.section_id LEFT JOIN students AS e ON s.student_id = e.student_id LEFT JOIN subjects AS f ON r.subject_id = f.subject_id", "*", "s.student_id = ".$rem[$i]['student_id']." AND r.term = '".$res[0]['exam_term']."' AND r.session_id = ".$ssn."");
						
	                        	$r_mark = array_column($recor, 'grand_total'); 
                           $min = min($r_mark);

                           $remsub=$rem[$i]['subject_studied'];
	                        $sub_json = json_decode($remsub);

                           for ($d=0; $d <5 ; $d++) {
	                        		# code...
	                        	
	                        	$record = $this->Common_Model->FetchData("exam_result_items as s LEFT JOIN exam_results as r ON r.exam_result_id=s.exam_result_id LEFT JOIN sessions as t ON r.session_id=t.session_id LEFT JOIN classes AS c ON r.class_id = c.class_id LEFT JOIN sections AS d ON r.section = d.section_id LEFT JOIN students AS e ON s.student_id = e.student_id LEFT JOIN subjects AS f ON r.subject_id = f.subject_id", "*", "s.student_id = ".$rem[$i]['student_id']." AND r.term = '".$res[0]['exam_term']."' AND r.session_id = ".$ssn." AND r.subject_id='".$sub_json[$d]."' ");
	                        	$rec = $this->Common_Model->FetchData("exam_result_items as s LEFT JOIN exam_results as r ON r.exam_result_id=s.exam_result_id LEFT JOIN sessions as t ON r.session_id=t.session_id LEFT JOIN classes AS c ON r.class_id = c.class_id LEFT JOIN sections AS d ON r.section = d.section_id LEFT JOIN students AS e ON s.student_id = e.student_id LEFT JOIN subjects AS f ON r.subject_id = f.subject_id", "*", "s.student_id = ".$rem[$i]['student_id']." AND r.term = '".$res[0]['exam_term']."' AND r.session_id = ".$ssn." AND r.subject_id='".$sub_json[5]."' ");
	                        	$re = $this->Common_Model->FetchData("exam_result_items as s LEFT JOIN exam_results as r ON r.exam_result_id=s.exam_result_id LEFT JOIN sessions as t ON r.session_id=t.session_id LEFT JOIN classes AS c ON r.class_id = c.class_id LEFT JOIN sections AS d ON r.section = d.section_id LEFT JOIN students AS e ON s.student_id = e.student_id LEFT JOIN subjects AS f ON r.subject_id = f.subject_id", "*", "s.student_id = ".$rem[$i]['student_id']." AND r.term = '".$res[0]['exam_term']."' AND r.session_id = ".$ssn."  AND s.grade='E' AND r.subject_id='".$sub_json[$d]."'");
	                        	if($record){ for($b=0;$b<count($record);$b++){
	                        		if ($record[$b]['totalt']<33 && $record[$b]['final_mark']==$min && $record[$b]['final_mark']!=0 && $record[$b]['subject_id']==$re[0]['subject_id']){
	                        			$result = $rec[0]['grand_total'];
	                        			
	                        		}else{
	                        			$result = $record[$b]['grand_total'];
	                        		}
	                        		
	                        		$resultt[$i] +=round($result);
	                        	}
	                        }

	                        }
	                        $tot_grade = $resultt[$i]/500*100 ;
								if($tot_grade > 91){
											$grd = "A1";
										}else if($tot_grade > 80 && $tot_grade <= 90){
											$grd = "A2";
										}else if($tot_grade > 70 && $tot_grade <= 80){
											$grd = "B1";
										}else if($tot_grade > 60 && $tot_grade <= 70){
											$grd = "B2";
										}else if($tot_grade > 50 && $tot_grade <= 60){
											$grd = "C1";
										}else if($tot_grade > 40 && $tot_grade <= 50){
											$grd = "C2";
										}else if($tot_grade > 30 && $tot_grade <= 40){
											$grd = "D";
										}else if($tot_grade <= 30){
											$grd = "E";
										}
								;
								
							$remark = $this->Common_Model->FetchData("attributes","*"," grade='".$grd."' order by id asc");
							//print_r($remark);exit;	
						$html .='<td><input type="text" class="form-control" value="'.$grd.'" readonly></td><td><select class="form-control " id="teacher_remarks" name="teacher_remarks[]">';
							
								if($remark && !in_array('teacherremarks', $rscval)){for ($c=0; $c < count($remark); $c++) { 
									
									$html.='<option value="'.$remark[$c]['attribute'].'" ' 
             . ( $records[$i]['remark'] == $remark[$c]['attribute'] ? 'selected="selected"' : '' ) . '>'.$remark[$c]['attribute'].'</option>';
								}}
										$html.='</select>
										</td></tr>';
		}}else{ for($i=0;$i<count($rem);$i++){
			$html.= '<tr><td>'.$rem[$i]['student_serial_no'].'</td><td><input type="hidden" name="student_id[]" value="'.$rem[$i]['student_id'].'">'.$rem[$i]['student_first_name'].' '.$rem[$i]['student_last_name'].'</td>
                          <td>'.(in_array('disciplinegrade', $rscval) ? '' : '<select type="text" class="form-control " id="discipline_grade" name="discipline_grade[]">
                            <option value="A">A</option>
                            <option value="B" >B</option>
                            <option value="C" >C</option>

                          </select>').'
						</td><td>'.(in_array('totalworkingdays', $rscval) ? '' : '<input type="number" class="form-control twd" id="twd" name="twd[]" readonly >').'</td><td>'.(in_array('totalattendance', $rscval) ? '' : '<input type="number" class="form-control" id="ta" name="ta[]" '.(in_array('totalattendance', $validations) ? 'readonly' : '').'>').'</td>';
						

						$recor = $this->Common_Model->FetchData("exam_result_items as s LEFT JOIN exam_results as r ON r.exam_result_id=s.exam_result_id LEFT JOIN sessions as t ON r.session_id=t.session_id LEFT JOIN classes AS c ON r.class_id = c.class_id LEFT JOIN sections AS d ON r.section = d.section_id LEFT JOIN students AS e ON s.student_id = e.student_id LEFT JOIN subjects AS f ON r.subject_id = f.subject_id", "*", "s.student_id = ".$rem[$i]['student_id']." AND r.term = '".$res[0]['exam_term']."' AND r.session_id = ".$ssn."");
						
	                        	$r_mark = array_column($recor, 'grand_total'); 
                           $min = min($r_mark);

                           $remsub=$rem[$i]['subject_studied'];
                           
	                        $sub_json = json_decode($remsub);

                           for ($d=0; $d <5 ; $d++) {
	                        	
	                        	
	                        	$record = $this->Common_Model->FetchData("exam_result_items as s LEFT JOIN exam_results as r ON r.exam_result_id=s.exam_result_id LEFT JOIN sessions as t ON r.session_id=t.session_id LEFT JOIN classes AS c ON r.class_id = c.class_id LEFT JOIN sections AS d ON r.section = d.section_id LEFT JOIN students AS e ON s.student_id = e.student_id LEFT JOIN subjects AS f ON r.subject_id = f.subject_id", "*", "s.student_id = ".$rem[$i]['student_id']." AND r.term = '".$res[0]['exam_term']."' AND r.session_id = ".$ssn." AND r.subject_id='".$sub_json[$d]."' ");
	                        	$rec = $this->Common_Model->FetchData("exam_result_items as s LEFT JOIN exam_results as r ON r.exam_result_id=s.exam_result_id LEFT JOIN sessions as t ON r.session_id=t.session_id LEFT JOIN classes AS c ON r.class_id = c.class_id LEFT JOIN sections AS d ON r.section = d.section_id LEFT JOIN students AS e ON s.student_id = e.student_id LEFT JOIN subjects AS f ON r.subject_id = f.subject_id", "*", "s.student_id = ".$rem[$i]['student_id']." AND r.term = '".$res[0]['exam_term']."' AND r.session_id = ".$ssn." AND r.subject_id='".$sub_json[5]."' ");
	                        	$re = $this->Common_Model->FetchData("exam_result_items as s LEFT JOIN exam_results as r ON r.exam_result_id=s.exam_result_id LEFT JOIN sessions as t ON r.session_id=t.session_id LEFT JOIN classes AS c ON r.class_id = c.class_id LEFT JOIN sections AS d ON r.section = d.section_id LEFT JOIN students AS e ON s.student_id = e.student_id LEFT JOIN subjects AS f ON r.subject_id = f.subject_id", "*", "s.student_id = ".$rem[$i]['student_id']." AND r.term = '".$res[0]['exam_term']."' AND r.session_id = ".$ssn."  AND s.grade='E' AND r.subject_id='".$sub_json[$d]."'");
	                        	//print_r($record);exit;
	                        	if($record){ for($b=0;$b<count($record);$b++){
	                        		if ($record[$b]['final_mark']<33 && $record[$b]['final_mark']==$min && $record[$b]['final_mark']!=0 && $record[$b]['subject_id']==$re[0]['subject_id']){
	                        			$result = $rec[0]['grand_total'];
	                        			
	                        		}else{
	                        			$result = $record[$b]['grand_total'];
	                        		}
	                        		
	                        		$resultt[$i] +=round($result);
	                        	}
	                        }

	                        }
	                        $tot_grade = $resultt[$i]/500*100 ;
								if($tot_grade > 91){
											$grd = "A1";
										}else if($tot_grade > 80 && $tot_grade <= 90){
											$grd = "A2";
										}else if($tot_grade > 70 && $tot_grade <= 80){
											$grd = "B1";
										}else if($tot_grade > 60 && $tot_grade <= 70){
											$grd = "B2";
										}else if($tot_grade > 50 && $tot_grade <= 60){
											$grd = "C1";
										}else if($tot_grade > 40 && $tot_grade <= 50){
											$grd = "C2";
										}else if($tot_grade > 30 && $tot_grade <= 40){
											$grd = "D";
										}else if($tot_grade <= 30){
											$grd = "E";
										}
								;
								
							$remark = $this->Common_Model->FetchData("attributes","*"," grade='".$grd."' order by id asc");
							//print_r($remark);exit;	
						$html .='<td><input type="text" class="form-control" value="'.$grd.'" readonly></td><td><select class="form-control " id="teacher_remarks" name="teacher_remarks[]">';
							
								if($remark && !in_array('teacherremarks', $rscval)){for ($c=0; $c < count($remark); $c++) { 
									
									$html.='<option value="'.$remark[$c]['attribute'].'">'.$remark[$c]['attribute'].'</option>';
								}}
										$html.='</select>
										</td></tr>';
		}}

		
		$html.= '</table>';
		echo $html;
	}
	function getStudentListBySessionClass25(){
		
	    error_reporting(0);
		//$html='res';echo $html;exit;
		//print_r($this->session->userdata('exam_term'));exit;
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$res = $this->Common_Model->FetchData("exam_term","*","active_exam_term = 'Active'");
		$ssn = $this->session->userdata('session_id');

		$inputval = $this->Common_Model->FetchData("addmarkvalidations","*","session_id=".$this->input->post("session_id")." AND class_id=".$this->input->post("class_id")." AND term='".$res[0]['exam_term']."'");
		$validations = json_decode($inputval[0]['validations']);

		$resultshowval = $this->Common_Model->FetchData("resultshowcontrols","*","session_id=".$this->input->post("session_id")." AND class_id=".$this->input->post("class_id")." AND section_id='".$this->input->post("section_id")."' AND term='".$res[0]['exam_term']."'");
		$rscval = json_decode($resultshowval[0]['validations']);

		$records = $this->Common_Model->FetchData("student_admission AS sa LEFT JOIN students AS s ON sa.student_id = s.student_id LEFT JOIN exam_remark_items as b ON sa.student_id = b.student_id LEFT JOIN exam_remarks as c ON b.exam_remark_id = c.exam_remark_id", "*", "sa.class_id = ".$this->input->post("class_id")." AND sa.session_id = ".$this->input->post("session_id")." AND s.student_section = ".$this->input->post("section_id")." AND admission_status = 'Active' AND c.term ='".$res[0]['exam_term']."'  ORDER BY s.student_serial_no ASC");
		$rem = $this->Common_Model->FetchData("student_admission AS sa LEFT JOIN students AS s ON sa.student_id = s.student_id ", "*", "sa.class_id = ".$this->input->post("class_id")." AND sa.session_id = ".$this->input->post("session_id")." AND s.student_section = ".$this->input->post("section_id")." AND admission_status = 'Active' ORDER BY s.student_serial_no ASC");
		//print_r($rec);exit;
		$html = '<table class="table table-condensed table-bordered"><tr>
                        <th>Scholastic Areas</th>
                        <th colspan="6">
                          <select class="form-control" name="exam_term" id="exam_term" required>
                            
                            <option value="'.$res[0]['exam_term'].'">'.$res[0]['exam_term'].'</option>
                            
                          </select>
                        </th>
                      </tr>
                      <tr>
                        <th style="width: 3%;">Adm.No.</th>
                        <th style="width: 15%;">Student Name</th>
                        
                        <th style="width: 10%;">Discipline Grade</th>
                        <th style="width: 10%;">Total Working Days</th>
                        <th style="width: 7%;">Total Attendance</th>
                        <th style="width: 5%;">grade</th>
                        <th style="width: 50%;">Remarks</th>

                        
                      </tr>';
		if($records){ for($i=0;$i<count($records);$i++){
				/*$rec = $this->Common_Model->FetchData("","","")*/
			$html.= '<tr><td>'.$records[$i]['student_serial_no'].'</td><td><input type="hidden" name="result_id" value="'.$records[$i]['exam_remark_id'].'"><input type="hidden" name="student_id[]" value="'.$records[$i]['student_id'].'">'.$records[$i]['student_first_name'].' '.$records[$i]['student_last_name'].'</td><td>'.(in_array('disciplinegrade', $rscval) ? '' : '<select type="text" class="form-control " id="discipline_grade" name="discipline_grade[]">
                            <option value="A" ' 
             . ( $records[$i]['dg'] == "A" ? 'selected="selected"' : '' ) . '>A</option>
                            <option value="B" ' 
             . ( $records[$i]['dg'] == "B" ? 'selected="selected"' : '' ) . '>B</option>
                            <option value="C" ' 
             . ( $records[$i]['dg'] == "C" ? 'selected="selected"' : '' ) . '>C</option>
                            
                          </select>').'</td><td>'.(in_array('totalworkingdays', $rscval) ? '' : '<input type="number" class="form-control twd" id="twd" name="twd[]" value="'.$records[$i]['twd'].'" '.(in_array('totalworkingdays', $validations) ? 'readonly' : '').'>').'</td><td>'.(in_array('totalattendance', $rscval) ? '' : '<input type="number" class="form-control" id="ta" name="ta[]" value="'.$records[$i]['ta'].'" '.(in_array('totalattendance', $validations) ? 'readonly' : '').'>').'</td>';
                          $recor = $this->Common_Model->FetchData("exam_result_items as s LEFT JOIN exam_results as r ON r.exam_result_id=s.exam_result_id LEFT JOIN sessions as t ON r.session_id=t.session_id LEFT JOIN classes AS c ON r.class_id = c.class_id LEFT JOIN sections AS d ON r.section = d.section_id LEFT JOIN students AS e ON s.student_id = e.student_id LEFT JOIN subjects AS f ON r.subject_id = f.subject_id", "*", "s.student_id = ".$rem[$i]['student_id']." AND r.term = '".$res[0]['exam_term']."' AND r.session_id = ".$ssn."");
						
	                        	$r_mark = array_column($recor, 'total'); 
                           $min = min($r_mark);

                           $remsub=$rem[$i]['subject_studied'];
	                        $sub_json = json_decode($remsub);

                           for ($d=0; $d <5 ; $d++) {
	                        		# code...
	                        	
	                        	$record = $this->Common_Model->FetchData("exam_result_items as s LEFT JOIN exam_results as r ON r.exam_result_id=s.exam_result_id LEFT JOIN sessions as t ON r.session_id=t.session_id LEFT JOIN classes AS c ON r.class_id = c.class_id LEFT JOIN sections AS d ON r.section = d.section_id LEFT JOIN students AS e ON s.student_id = e.student_id LEFT JOIN subjects AS f ON r.subject_id = f.subject_id", "*", "s.student_id = ".$rem[$i]['student_id']." AND r.term = '".$res[0]['exam_term']."' AND r.session_id = ".$ssn." AND r.subject_id='".$sub_json[$d]."' ");
	                        	$rec = $this->Common_Model->FetchData("exam_result_items as s LEFT JOIN exam_results as r ON r.exam_result_id=s.exam_result_id LEFT JOIN sessions as t ON r.session_id=t.session_id LEFT JOIN classes AS c ON r.class_id = c.class_id LEFT JOIN sections AS d ON r.section = d.section_id LEFT JOIN students AS e ON s.student_id = e.student_id LEFT JOIN subjects AS f ON r.subject_id = f.subject_id", "*", "s.student_id = ".$rem[$i]['student_id']." AND r.term = '".$res[0]['exam_term']."' AND r.session_id = ".$ssn." AND r.subject_id='".$sub_json[5]."' ");
	                        	$re = $this->Common_Model->FetchData("exam_result_items as s LEFT JOIN exam_results as r ON r.exam_result_id=s.exam_result_id LEFT JOIN sessions as t ON r.session_id=t.session_id LEFT JOIN classes AS c ON r.class_id = c.class_id LEFT JOIN sections AS d ON r.section = d.section_id LEFT JOIN students AS e ON s.student_id = e.student_id LEFT JOIN subjects AS f ON r.subject_id = f.subject_id", "*", "s.student_id = ".$rem[$i]['student_id']." AND r.term = '".$res[0]['exam_term']."' AND r.session_id = ".$ssn."  AND s.grade='E' AND r.subject_id='".$sub_json[$d]."'");
	                        	if($record){ for($b=0;$b<count($record);$b++){
	                        		if ($record[$b]['total']<33 && $record[$b]['total']==$min && $record[$b]['total']!=0 && $record[$b]['subject_id']==$re[0]['subject_id']){
	                        			$result = $rec[0]['total'];
	                        			
	                        		}else{
	                        			$result = $record[$b]['total'];
	                        		}
	                        		
	                        		$resultt[$i] +=round($result);
	                        		$subtotal[$i] +=100;
	                        	}
	                        }

	                        }
	                        $tot_grade = $resultt[$i]/$subtotal[$i]*100 ;
	                        
								if($tot_grade >= 91){
											$grd = "A1";
										}else if($tot_grade >= 81 && $tot_grade < 91){
											$grd = "A2";
										}else if($tot_grade >= 71 && $tot_grade < 81){
											$grd = "B1";
										}else if($tot_grade >= 61 && $tot_grade < 71){
											$grd = "B2";
										}else if($tot_grade >= 51 && $tot_grade < 61){
											$grd = "C1";
										}else if($tot_grade >= 41 && $tot_grade < 51){
											$grd = "C2";
										}else if($tot_grade >= 33 && $tot_grade < 41){
											$grd = "D";
										}else if($tot_grade < 33){
											$grd = "E";
										}
								;
								
							$remark = $this->Common_Model->FetchData("attributes","*"," grade='".$grd."' order by id asc");
							//print_r($remark);exit;	
						$html .='<td><input type="text" class="form-control" value="'.$grd.'" readonly></td><td><select class="form-control " id="teacher_remarks" name="teacher_remarks[]">';
							
								if($remark && !in_array('teacherremarks', $rscval)){for ($c=0; $c < count($remark); $c++) { 
									
									$html.='<option value="'.$remark[$c]['attribute'].'" ' 
             . ( $records[$i]['remark'] == $remark[$c]['attribute'] ? 'selected="selected"' : '' ) . '>'.$remark[$c]['attribute'].'</option>';
								}}
										$html.='</select></td></tr>';
		}}else{ for($i=0;$i<count($rem);$i++){
			$html.= '<tr><td>'.$rem[$i]['student_serial_no'].'</td><td><input type="hidden" name="student_id[]" value="'.$rem[$i]['student_id'].'">'.$rem[$i]['student_first_name'].' '.$rem[$i]['student_last_name'].'</td>
                          <td>'.(in_array('disciplinegrade', $rscval) ? '' : '<select type="text" class="form-control " id="discipline_grade" name="discipline_grade[]">
                            <option value="A">A</option>
                            <option value="B" >B</option>
                            <option value="C" >C</option>

                          </select>').'
						</td><td>'.(in_array('totalworkingdays', $rscval) ? '' : '<input type="number" class="form-control twd" id="twd" name="twd[]" '.(in_array('totalworkingdays', $validations) ? 'readonly' : '').'>').'</td><td>'.(in_array('totalattendance', $rscval) ? '' : '<input type="number" class="form-control" id="ta" name="ta[]" '.(in_array('totalattendance', $validations) ? 'readonly' : '').'>').'</td>';
						

						$recor = $this->Common_Model->FetchData("exam_result_items as s LEFT JOIN exam_results as r ON r.exam_result_id=s.exam_result_id LEFT JOIN sessions as t ON r.session_id=t.session_id LEFT JOIN classes AS c ON r.class_id = c.class_id LEFT JOIN sections AS d ON r.section = d.section_id LEFT JOIN students AS e ON s.student_id = e.student_id LEFT JOIN subjects AS f ON r.subject_id = f.subject_id", "*", "s.student_id = ".$rem[$i]['student_id']." AND r.term = '".$res[0]['exam_term']."' AND r.session_id = ".$ssn."");
						
	                        	$r_mark = array_column($recor, 'total'); 
                           $min = min($r_mark);

                           $remsub=$rem[$i]['subject_studied'];
	                        $sub_json = json_decode($remsub);

                           for ($d=0; $d <5 ; $d++) {
	                        		# code...
	                        	
	                        	$record = $this->Common_Model->FetchData("exam_result_items as s LEFT JOIN exam_results as r ON r.exam_result_id=s.exam_result_id LEFT JOIN sessions as t ON r.session_id=t.session_id LEFT JOIN classes AS c ON r.class_id = c.class_id LEFT JOIN sections AS d ON r.section = d.section_id LEFT JOIN students AS e ON s.student_id = e.student_id LEFT JOIN subjects AS f ON r.subject_id = f.subject_id", "*", "s.student_id = ".$rem[$i]['student_id']." AND r.term = '".$res[0]['exam_term']."' AND r.session_id = ".$ssn." AND r.subject_id='".$sub_json[$d]."' ");
	                        	$rec = $this->Common_Model->FetchData("exam_result_items as s LEFT JOIN exam_results as r ON r.exam_result_id=s.exam_result_id LEFT JOIN sessions as t ON r.session_id=t.session_id LEFT JOIN classes AS c ON r.class_id = c.class_id LEFT JOIN sections AS d ON r.section = d.section_id LEFT JOIN students AS e ON s.student_id = e.student_id LEFT JOIN subjects AS f ON r.subject_id = f.subject_id", "*", "s.student_id = ".$rem[$i]['student_id']." AND r.term = '".$res[0]['exam_term']."' AND r.session_id = ".$ssn." AND r.subject_id='".$sub_json[5]."' ");
	                        	$re = $this->Common_Model->FetchData("exam_result_items as s LEFT JOIN exam_results as r ON r.exam_result_id=s.exam_result_id LEFT JOIN sessions as t ON r.session_id=t.session_id LEFT JOIN classes AS c ON r.class_id = c.class_id LEFT JOIN sections AS d ON r.section = d.section_id LEFT JOIN students AS e ON s.student_id = e.student_id LEFT JOIN subjects AS f ON r.subject_id = f.subject_id", "*", "s.student_id = ".$rem[$i]['student_id']." AND r.term = '".$res[0]['exam_term']."' AND r.session_id = ".$ssn."  AND s.grade='E' AND r.subject_id='".$sub_json[$d]."'");
	                        	if($record){ for($b=0;$b<count($record);$b++){
	                        		if ($record[$b]['total']<33 && $record[$b]['total']==$min && $record[$b]['total']!=0 && $record[$b]['subject_id']==$re[0]['subject_id']){
	                        			$result = $rec[0]['total'];
	                        			
	                        		}else{
	                        			$result = $record[$b]['total'];
	                        		}
	                        		
	                        		$resultt[$i] +=round($result);
	                        		$subtotal[$i] +=100;
	                        	}
	                        }

	                        }
	                        $tot_grade = $resultt[$i]/$subtotal[$i]*100 ;
								if($tot_grade >= 91){
											$grd = "A1";
										}else if($tot_grade >= 81 && $tot_grade < 91){
											$grd = "A2";
										}else if($tot_grade >= 71 && $tot_grade < 81){
											$grd = "B1";
										}else if($tot_grade >= 61 && $tot_grade < 71){
											$grd = "B2";
										}else if($tot_grade >= 51 && $tot_grade < 61){
											$grd = "C1";
										}else if($tot_grade >= 41 && $tot_grade < 51){
											$grd = "C2";
										}else if($tot_grade >= 33 && $tot_grade < 41){
											$grd = "D";
										}else if($tot_grade < 33){
											$grd = "E";
										}
								;
								
							$remark = $this->Common_Model->FetchData("attributes","*"," grade='".$grd."' order by id asc");
							//print_r($remark);exit;	
						$html .='<td><input type="text" class="form-control" value="'.$grd.'" readonly></td><td><select class="form-control " id="teacher_remarks" name="teacher_remarks[]">';
							
								if($remark && !in_array('teacherremarks', $rscval)){for ($c=0; $c < count($remark); $c++) { 
									
									$html.='<option value="'.$remark[$c]['attribute'].'">'.$remark[$c]['attribute'].'</option>';
								}}
										$html.='</select>
										</td></tr>';
		}}

		
		$html.= '</table>';
		echo $html;
	}
	function getStudentListBySessionClass24(){
		error_reporting(0);
		//$html='res';echo $html;exit;
		//print_r($this->session->userdata('exam_term'));exit;
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$res = $this->Common_Model->FetchData("exam_term","*","active_exam_term = 'Active'");

		$inputval = $this->Common_Model->FetchData("addmarkvalidations","*","session_id=".$this->input->post("session_id")." AND class_id=".$this->input->post("class_id")." AND term='".$res[0]['exam_term']."'");
		$validations = json_decode($inputval[0]['validations']);

		$resultshowval = $this->Common_Model->FetchData("resultshowcontrols","*","session_id=".$this->input->post("session_id")." AND class_id=".$this->input->post("class_id")." AND section_id='".$this->input->post("section_id")."' AND term='".$res[0]['exam_term']."'");
		$rscval = json_decode($resultshowval[0]['validations']);

		$records = $this->Common_Model->FetchData("student_admission AS sa LEFT JOIN students AS s ON sa.student_id = s.student_id LEFT JOIN exam_remark_items as b ON sa.student_id = b.student_id LEFT JOIN exam_remarks as c ON b.exam_remark_id = c.exam_remark_id", "*", "sa.class_id = ".$this->input->post("class_id")." AND sa.session_id = ".$this->input->post("session_id")." AND s.student_section = ".$this->input->post("section_id")." AND admission_status = 'Active' AND c.term ='".$res[0]['exam_term']."'  ORDER BY s.student_serial_no ASC");
		$rec = $this->Common_Model->FetchData("student_admission AS sa LEFT JOIN students AS s ON sa.student_id = s.student_id ", "*", "sa.class_id = ".$this->input->post("class_id")." AND sa.session_id = ".$this->input->post("session_id")." AND s.student_section = ".$this->input->post("section_id")." AND admission_status = 'Active' ORDER BY s.student_serial_no ASC");
		$class_id = $this->input->post("class_id");
		//print_r($rec);exit;
		$html = '<table class="table table-condensed table-bordered"><tr>
                        <th>Scholastic Areas</th>
                        <th colspan="6">
                          <select class="form-control" name="exam_term" id="exam_term" required>
                            
                            <option value="'.$res[0]['exam_term'].'">'.$res[0]['exam_term'].'</option>
                            
                          </select>
                        </th>
                      </tr>
                      <tr>
                        
                        <th style="width: 7%;">Adm.No.</th>
                        <th style="width: 15%;">Student Name</th>';
                        
                    	 $html.='<th style="width: 12%;" class="text-center">Work Education Grade</th>';	
                        if ($this->input->post("class_id") == 44 || $this->input->post("class_id") == 45 || $this->input->post("class_id") == 46 || $this->input->post("class_id") == 47) { 
                        	$html .= '<th style="width: 12%;" class="text-center">General Studies</th>';
                        }else {
                        	$html .= '<th style="width: 12%;" class="text-center">Art/Music Education Grade</th>';
                        } 
                        
                       $html.='<th style="width: 12%;" class="text-center">Health & Physical Education Grade</th>
                        
                        

                        
                      </tr>';
		if($records){ for($i=0;$i<count($records);$i++){
				/*$rec = $this->Common_Model->FetchData("","","")*/
			$html.= '<tr><td>'.$records[$i]['student_serial_no'].'</td><td><input type="hidden" name="result_id" value="'.$records[$i]['exam_remark_id'].'"><input type="hidden" name="student_id[]" value="'.$records[$i]['student_id'].'">'.$records[$i]['student_first_name'].' '.$records[$i]['student_last_name'].'</td>';
			
			$html.='<td>'.(in_array('workeducation', $rscval) ? '' : '<select class="form-control" id="work_education_grade" name="work_education_grade[]">
                            <option value="A" ' 
             . ( $records[$i]['weg'] == "A" ? 'selected="selected"' : '' ) . '> A</option>
                            <option value="B" ' 
             . ( $records[$i]['weg'] == "B" ? 'selected="selected"' : '' ) . '> B</option>
                            <option value="C" ' 
             . ( $records[$i]['weg'] == "C" ? 'selected="selected"' : '' ) . '> C</option>
                            
                          </select>').'</td><td>'.(in_array('arteducation', $rscval) ? '' : '<select class="form-control " id="art_education_grade" name="art_education_grade[]">
                            <option value="A" ' 
             . ( $records[$i]['aeg'] == "A" ? 'selected="selected"' : '' ) . '>A</option>
                            <option value="B" ' 
             . ( $records[$i]['aeg'] == "B" ? 'selected="selected"' : '' ) . '>B</option>
                            <option value="C" ' 
             . ( $records[$i]['aeg'] == "C" ? 'selected="selected"' : '' ) . '>C</option>
                            
                          </select>').'</td><td>'.(in_array('healtheducation', $rscval) ? '' : '<select class="form-control " id="health_education_grade" name="health_education_grade[]">
                            <option value="A" ' 
             . ( $records[$i]['peg'] == "A" ? 'selected="selected"' : '' ) . '>A</option>
                            <option value="B" ' 
             . ( $records[$i]['peg'] == "B" ? 'selected="selected"' : '' ) . '>B</option>
                            <option value="C" ' 
             . ( $records[$i]['peg'] == "C" ? 'selected="selected"' : '' ) . '>C</option>
                           
                          </select>').'</td></tr>';
		}}else{ for($i=0;$i<count($rec);$i++){
			$html.= '<tr><td>'.$rec[$i]['student_serial_no'].'</td><td><input type="hidden" name="student_id[]" value="'.$rec[$i]['student_id'].'">'.$rec[$i]['student_first_name'].' '.$rec[$i]['student_last_name'].'</td>';
				

				
			$html.='<td>'.(in_array('workeducation', $rscval) ? '' : '<select class="form-control" id="work_education_grade" name="work_education_grade[]">
                            <option value="A">A</option>
                            <option value="B" >B</option>
                            <option value="C" >C</option>
                            
                          </select>').'
					</td><td>'.(in_array('arteducation', $rscval) ? '' : '<select class="form-control " id="art_education_grade" name="art_education_grade[]">
                            <option value="A">A</option>
                            <option value="B" >B</option>
                            <option value="C" >C</option>
                          </select>').'
						</td><td>'.(in_array('healtheducation', $rscval) ? '' : '<select class="form-control " id="health_education_grade" name="health_education_grade[]">
                            <option value="A">A</option>
                            <option value="B" >B</option>
                            <option value="C" >C</option>
                          </select>').'</td>
                          </tr>';
		}}

		
		$html.= '</table>';
		echo $html;
	}

	public function getStudentListforOtherSubject1to8(){

		error_reporting(0);
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$res = $this->Common_Model->FetchData("exam_term","*","active_exam_term = 'Active'");
		$inputval = $this->Common_Model->FetchData("addmarkvalidations","*","session_id=".$this->input->post("session_id")." AND class_id=".$this->input->post("class_id")." AND term='".$res[0]['exam_term']."' AND term='".$res[0]['exam_term']."'");
		$validations = json_decode($inputval[0]['validations']);

		$resultshowval = $this->Common_Model->FetchData("resultshowcontrols","*","session_id=".$this->input->post("session_id")." AND class_id=".$this->input->post("class_id")." AND section_id='".$this->input->post("section_id")."'");
		$rscval = json_decode($resultshowval[0]['validations']);
		
		$records = $this->Common_Model->FetchData("student_admission AS sa LEFT JOIN students AS s ON sa.student_id = s.student_id LEFT JOIN exam_otherresult_items as b ON sa.student_id = b.student_id LEFT JOIN exam_otherresults as c ON b.exam_otherresult_id = c.exam_otherresult_id", "*", "sa.class_id = ".$this->input->post("class_id")." AND sa.session_id = ".$this->input->post("session_id")." AND s.student_section = ".$this->input->post("section_id")." AND sa.admission_status = 'Active' AND c.subject_id ='".$this->input->post("subject_name")."' AND c.term ='".$res[0]['exam_term']."'  ORDER BY s.student_serial_no ASC");
		$rec = $this->Common_Model->FetchData("student_admission AS sa LEFT JOIN students AS s ON sa.student_id = s.student_id ", "*", "sa.class_id = ".$this->input->post("class_id")." AND sa.session_id = ".$this->input->post("session_id")." AND s.student_section = ".$this->input->post("section_id")." AND sa.admission_status = 'Active' ORDER BY s.student_serial_no ASC");
		
		$html = '<div style="overflow-x:auto;"><table class="table table-bordered table-condensed table-striped itemslist" width="100%"><tr>
                        <th width="10%">Scholastic Areas</th>
                        <th  width="60%" colspan="6">
                          <select class="form-control" name="exam_term" id="exam_term" required>
                            
                            <option value="'.$res[0]['exam_term'].'">'.$res[0]['exam_term'].'</option>
                            
                          </select>
                        </th>
                        <th width="30%" colspan="2"></th>
                      </tr>
                      <tr>
                        <th width="10%" >Adm. No</th>
                        <th width="20%">Student Name</th> 
                        <th class="text-center" width="10%">Half Yearly</th>
                        <th class="text-center" width="10%">Grade</th>
                      </tr>';
		if($records){ for($i=0;$i<count($records);$i++){
			
				/*$rec = $this->Common_Model->FetchData("","","")*/
			$html.= '<tr><td>'.$records[$i]['student_serial_no'].'</td><td><input type="hidden" name="result_id" value="'.$records[$i]['exam_otherresult_id'].'"><input type="hidden" name="student_id[]" value="'.$records[$i]['student_id'].'">'.$records[$i]['student_first_name'].' '.$records[$i]['student_last_name'].'</td>

			<td width="10%">'.(in_array('halfyearly', $rscval) ? '' : '<input type="number" name="half_yearly[]" class="form-control half_yearly marktoadd text-center" step="0.01" '.(in_array('halfyearly', $validations) ? 'readonly' : '').' value="'.$records[$i]['half_yearly'].'" >').'</td>

			<td width="10%">'.(in_array('grade', $rscval) ? '' : '<input type="text" name="grade[]" class="form-control grade text-center" readonly value="'.$records[$i]['grade'].'">').'</td></tr>';
		}}else{ for($i=0;$i<count($rec);$i++){
			
			$html.= '<tr><td width="10%">'.$rec[$i]['student_serial_no'].'</td><td width="20%"><input type="hidden" name="student_id[]" value="'.$rec[$i]['student_id'].'">'.$rec[$i]['student_first_name'].' '.$rec[$i]['student_last_name'].'</td><td width="10%"><input type="number" name="half_yearly[]" class="form-control half_yearly marktoadd text-center" step="0.01" '.(in_array('half_yearly', $validations) ? 'readonly' : '').'></td><td width="10%"><input type="text" name="grade[]" class="form-control grade text-center" readonly ></td></tr>';
		}}

		
		$html.= '</table></div>';
		echo $html;
	}

	function getStudentListBySessionClass4(){
	    error_reporting(0);
		//print_r($this->input->post("class_id"));exit;
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$res = $this->Common_Model->FetchData("exam_term","*","active_exam_term = 'Active'");
		$inputval = $this->Common_Model->FetchData("addmarkvalidations","*","session_id=".$this->input->post("session_id")." AND class_id=".$this->input->post("class_id")." AND term='".$res[0]['exam_term']."'");
		$validations = json_decode($inputval[0]['validations']);

		$resultshowval = $this->Common_Model->FetchData("resultshowcontrols","*","session_id=".$this->input->post("session_id")." AND class_id=".$this->input->post("class_id")." AND section_id='".$this->input->post("section_id")."' AND term='".$res[0]['exam_term']."'");
		$rscval = json_decode($resultshowval[0]['validations']);

		
		$records = $this->Common_Model->FetchData("student_admission AS sa LEFT JOIN students AS s ON sa.student_id = s.student_id LEFT JOIN exam_result_items as b ON sa.student_id = b.student_id LEFT JOIN exam_results as c ON b.exam_result_id = c.exam_result_id", "*", "sa.class_id = ".$this->input->post("class_id")." AND sa.session_id = ".$this->input->post("session_id")." AND s.student_section = ".$this->input->post("section_id")." AND sa.admission_status = 'Active' AND c.subject_id ='".$this->input->post("subject_id")."' AND c.section ='".$this->input->post("section_id")."' AND c.class_id ='".$this->input->post("class_id")."' AND c.term ='".$res[0]['exam_term']."'  ORDER BY s.student_serial_no ASC");
		//print_r($records);exit;
		$rec = $this->Common_Model->FetchData("student_admission AS sa LEFT JOIN students AS s ON sa.student_id = s.student_id LEFT JOIN subjects_mark AS n ON sa.class_id = n.class_id", "*", "sa.class_id = ".$this->input->post("class_id")." AND sa.session_id = ".$this->input->post("session_id")." AND s.student_section = ".$this->input->post("section_id")." AND n.subject_id = ".$this->input->post("subject_id")." AND sa.admission_status = 'Active' ORDER BY s.student_serial_no ASC");
		//print_r($rec[0]['subject_studied']);exit;
		if ($this->input->post("class_id") == 44 || $this->input->post("class_id") == 46 || $this->input->post("class_id") == 50) {
			

		$html = '<table class="table table-condensed table-bordered" width="100%"><tr>
                        <th>Scholastic Areas</th>
                        <th colspan="4">
                          <select class="form-control" name="exam_term" id="exam_term" required>
                            
                            <option value="'.$res[0]['exam_term'].'">'.$res[0]['exam_term'].'</option>
                            
                          </select>
                        </th>
                      </tr>
                      <tr>
                        <th style="width: 5%;">Adm. No</th>
                        <th style="width: 15%;">Student Name</th>
                        <th style="width: 10%;">Attendance</th>
                        
                        <th style="width: 15%;" class="text-center">' 
             . ( $res[0]['exam_term'] == 'Term-1 (100 marks)' ? 'Periodic Test 1' : 'Periodic Test 2' ) . ' (30)</th>
             
                        <th style="width: 15%;" class="text-center">' 
             . ( $res[0]['exam_term'] == 'Term-1 (100 marks)' ? 'Half Yearly' : 'Annual' ) . ' ('.$rec[0]['maxmark_theory'].')</th>
             		'. ( $res[0]['exam_term'] == 'Term-1 (100 marks)' ? '':'
                        <th style="width: 15%;" class="text-center">I.A/Practical('.$rec[0]['maxmark_practical'].')</th>').'
                      </tr>';
		if($records){ for($i=0;$i<count($records);$i++){
				$d = json_decode($records[$i]['subject_studied']);
				//print_r($d);exit;
				if (in_array($this->input->post("subject_id"), $d)) {
 	
				/*$rec = $this->Common_Model->FetchData("","","")*/
			$html.= '<tr><td>'.$records[$i]['student_serial_no'].'</td><td><input type="hidden" name="result_id" value="'.$records[$i]['exam_result_id'].'"><input type="hidden" name="student_id[]" value="'.$records[$i]['student_id'].'">'.$records[$i]['student_first_name'].' '.$records[$i]['student_last_name'].'</td>
			<td width="10%">
				<select class="form-control" name="attend_val[]">
					<option value="Present" '.($records[$i]['attend_val']=='Present'?'selected':'').'>Present</option>
					<option value="Absent" '.($records[$i]['attend_val']=='Absent'?'selected':'').'>Absent</option>
				</select>
			</td>
			<td>'.(in_array('periodictest', $rscval) ? '' : '<input type="number" name="periodic_test[]" class="form-control periodic_test marktoadd text-center" step="0.01" value="'.$records[$i]['periodic_test'].'" '.(in_array('periodictest', $validations) ? 'readonly' : '').'>').'</td>
			<td style="display:none;"><input type="number" name="maxmarks_theory[]" class="form-control max_marks marktoadd text-center" step="0.01" readonly value="'.$records[$i]['maxmarks_theory'].'"></td>
			<td>'.(in_array('halfyearly', $rscval) ? '' : '<input type="number" name="mark_obtained_theory[]" class="form-control mark_obtained_theory marktoadd text-center half_yearly" step="0.01" value="'.$records[$i]['mark_obtained_theory'].'" '.(in_array('halfyearly', $validations) ? 'readonly' : '').'>').'</td>
			'. ( $res[0]['exam_term'] == 'Term-1 (100 marks)' ? '':'<td style="display:none;"><input type="number" name="maxmarks_practical[]" class="form-control maxmarks_practical marktoadd text-center" step="0.01" readonly value="'.$records[$i]['maxmarks_practical'].'"></td>
				<td>'.(in_array('iapractical', $rscval) ? '' : '<input type="number" name="mark_obtained_practical[]" class="form-control mark_obtained_practical marktoadd text-center" step="0.01" value="'.$records[$i]['mark_obtained_practical'].'" '.(in_array('iapractical', $validations) ? 'readonly' : '').'>').'</td>').' </tr>';
		}}}else{ for($i=0;$i<count($rec);$i++){ 
			$e = json_decode($rec[$i]['subject_studied']); 
				//print_r($d);exit;
				if (in_array($this->input->post("subject_id"), $e)) {
			$html.= '<tr><td>'.$rec[$i]['student_serial_no'].'</td><td><input type="hidden" name="student_id[]" value="'.$rec[$i]['student_id'].'">'.$rec[$i]['student_first_name'].' '.$rec[$i]['student_last_name'].'</td>
			<td width="10%">
				<select class="form-control" name="attend_val[]">
					<option value="Present">Present</option>
					<option value="Absent">Absent</option>
				</select>
			</td>
			<td><input type="number" name="periodic_test[]" class="form-control periodic_test marktoadd text-center" step="0.01" value="" '.(in_array('periodictest', $validations) ? 'readonly' : '').'></td><td style="display:none;"><input type="number" name="maxmarks_theory[]" class="form-control max_marks marktoadd text-center" step="0.01" readonly value="'.$rec[$i]['maxmark_theory'].'"></td><td><input type="number" name="mark_obtained_theory[]" value="" class="form-control mark_obtained_theory marktoadd text-center half_yearly" step="0.01" '.(in_array('halfyearly', $validations) ? 'readonly' : '').' ></td>'. ( $res[0]['exam_term'] == 'Term-1 (100 marks)' ? '':'<td style="display:none;"><input type="number" name="maxmarks_practical[]" class="form-control maxmarks_practical marktoadd text-center" step="0.01" readonly value="'.$rec[$i]['maxmark_practical'].'"></td><td><input type="number" name="mark_obtained_practical[]" class="form-control mark_obtained_practical marktoadd text-center" step="0.01" '.(in_array('iapractical', $validations) ? 'readonly' : '').'></td>').'</tr>';
		}}}

		
		$html.= '</table>';
	}else{
			$html = '<table class="table table-condensed table-bordered" width="100%"><tr>
                        <th>Scholastic Areas</th>
                        <th colspan="4">
                          <select class="form-control" name="exam_term" id="exam_term" required>
                            
                            <option value="'.$res[0]['exam_term'].'">'.$res[0]['exam_term'].'</option>
                            
                          </select>
                        </th>
                      </tr>
                      <tr>
                        <th style="width: 5%;">Adm. No</th>
                        <th style="width: 15%;">Student Name</th>
                        <th style="width: 10%;">Attendance</th>
                        
                        <th style="width: 15%;" class="text-center">' 
             . ( $res[0]['exam_term'] == 'Term-1 (100 marks)' ? 'Periodic Test 1' : 'Pre Board-1' ) . ' (30)</th>
             
                        <th style="width: 15%;" class="text-center">' 
             . ( $res[0]['exam_term'] == 'Term-1 (100 marks)' ? 'Half Yearly' : 'Pre Board-2' ) . ' ('.$rec[0]['maxmark_theory'].')</th>
             		
                      </tr>';
		if($records){ for($i=0;$i<count($records);$i++){
				$d = json_decode($records[$i]['subject_studied']);
				//print_r($d);exit;
				if (in_array($this->input->post("subject_id"), $d)) {
 	
				/*$rec = $this->Common_Model->FetchData("","","")*/
			$html.= '<tr><td>'.$records[$i]['student_serial_no'].'</td><td><input type="hidden" name="result_id" value="'.$records[$i]['exam_result_id'].'"><input type="hidden" name="student_id[]" value="'.$records[$i]['student_id'].'">'.$records[$i]['student_first_name'].' '.$records[$i]['student_last_name'].'</td>
			<td width="10%">
				<select class="form-control" name="attend_val[]">
					<option value="Present" '.($records[$i]['attend_val']=='Present'?'selected':'').'>Present</option>
					<option value="Absent" '.($records[$i]['attend_val']=='Absent'?'selected':'').'>Absent</option>
				</select>
			</td>
			<td>'.(in_array('periodictest', $rscval) ? '' : '<input type="number" name="periodic_test[]" class="form-control periodic_test marktoadd text-center" step="0.01" value="'.$records[$i]['periodic_test'].'" '.(in_array('periodictest', $validations) ? 'readonly' : '').'>').'</td>
			<td style="display:none;"><input type="number" name="maxmarks_theory[]" class="form-control max_marks marktoadd text-center" step="0.01" readonly value="'.$records[$i]['maxmarks_theory'].'"></td>
			<td>'.(in_array('halfyearly', $rscval) ? '' : '<input type="number" name="mark_obtained_theory[]" class="form-control mark_obtained_theory marktoadd text-center half_yearly" step="0.01" value="'.$records[$i]['mark_obtained_theory'].'" '.(in_array('halfyearly', $validations) ? 'readonly' : '').'>').'</td>
			 </tr>';
		}}}else{ for($i=0;$i<count($rec);$i++){ 
			$e = json_decode($rec[$i]['subject_studied']); 
				//print_r($d);exit;
				if (in_array($this->input->post("subject_id"), $e)) {
			$html.= '<tr><td>'.$rec[$i]['student_serial_no'].'</td><td><input type="hidden" name="student_id[]" value="'.$rec[$i]['student_id'].'">'.$rec[$i]['student_first_name'].' '.$rec[$i]['student_last_name'].'</td>
			<td width="10%">
				<select class="form-control" name="attend_val[]">
					<option value="Present">Present</option>
					<option value="Absent">Absent</option>
				</select>
			</td>
			<td><input type="number" name="periodic_test[]" class="form-control periodic_test marktoadd text-center" step="0.01" value="" '.(in_array('periodictest', $validations) ? 'readonly' : '').'></td><td style="display:none;"><input type="number" name="maxmarks_theory[]" class="form-control max_marks marktoadd text-center" step="0.01" readonly value="'.$rec[$i]['maxmark_theory'].'"></td><td><input type="number" name="mark_obtained_theory[]" class="form-control mark_obtained_theory marktoadd text-center half_yearly" step="0.01" '.(in_array('halfyearly', $validations) ? 'readonly' : '').' ></td></tr>';
		}}}

		
		$html.= '</table>';
	}


		echo $html;
	}

	function getStudentListBySessionClassNew4(){
	    error_reporting(0);
		//print_r($this->input->post("class_id"));exit;
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$res = $this->Common_Model->FetchData("exam_term","*","active_exam_term = 'Active'");
		$inputval = $this->Common_Model->FetchData("addmarkvalidations","*","session_id=".$this->input->post("session_id")." AND class_id=".$this->input->post("class_id")." AND term='".$res[0]['exam_term']."'");
		$validations = json_decode($inputval[0]['validations']);

		$resultshowval = $this->Common_Model->FetchData("resultshowcontrols","*","session_id=".$this->input->post("session_id")." AND class_id=".$this->input->post("class_id")." AND section_id='".$this->input->post("section_id")."' AND term='".$res[0]['exam_term']."'");
		$rscval = json_decode($resultshowval[0]['validations']);

		$rec = $this->Common_Model->FetchData("student_admission AS sa LEFT JOIN students AS s ON sa.student_id = s.student_id LEFT JOIN subjects_mark AS n ON sa.class_id = n.class_id", "*", "sa.class_id = ".$this->input->post("class_id")." AND sa.session_id = ".$this->input->post("session_id")." AND s.student_section = ".$this->input->post("section_id")." AND n.subject_id = ".$this->input->post("subject_id")." AND sa.admission_status = 'Active' ORDER BY s.student_serial_no ASC");
		
		if ($this->input->post("class_id") == 44 || $this->input->post("class_id") == 46) {
			

		$html = '<table class="table table-condensed table-bordered" width="100%"><tr>
                        <th>Scholastic Areas</th>
                        <th colspan="4">
                          <select class="form-control" name="exam_term" id="exam_term" required>
                            
                            <option value="'.$res[0]['exam_term'].'">'.$res[0]['exam_term'].'</option>
                            
                          </select>
                        </th>
                      </tr>
                      <tr>
                        <th style="width: 5%;">Adm. No</th>
                        <th style="width: 15%;">Student Name</th>
                        <th style="width: 10%;">Attendance</th>
                        
                        <th style="width: 15%;" class="text-center">' 
             . ( $res[0]['exam_term'] == 'Term-1 (100 marks)' ? 'Periodic Test 1' : 'Periodic Test 2' ) . ' (30)</th>
             
                        <th style="width: 15%;" class="text-center">' 
             . ( $res[0]['exam_term'] == 'Term-1 (100 marks)' ? 'Half Yearly' : 'Annual' ) . ' ('.$rec[0]['maxmark_theory'].')</th>
             		'. ( $res[0]['exam_term'] == 'Term-1 (100 marks)' ? '':'
                        <th style="width: 15%;" class="text-center">I.A/Practical('.$rec[0]['maxmark_practical'].')</th>').'
                      </tr>';
		for($i=0;$i<count($rec);$i++){ 
			
			$oldstd = $this->Common_Model->FetchData("exam_result_items as a  LEFT JOIN exam_results as b ON a.exam_result_id = b.exam_result_id", "*", "b.class_id = '".$this->input->post("class_id")."' AND b.session_id = '".$this->input->post("session_id")."' AND b.section = '".$this->input->post("section_id")."' AND b.subject_id ='".$this->input->post("subject_id")."' AND b.term ='".$res[0]['exam_term']."' AND a.student_id='".$rec[$i]['student_id']."' ");
			
			if ($oldstd) {
				
			}else{
				$e = json_decode($rec[$i]['subject_studied']); 
				//print_r($d);exit;
				if (in_array($this->input->post("subject_id"), $e)) {
			$html.= '<tr><td>'.$rec[$i]['student_serial_no'].'</td><td><input type="hidden" name="student_id[]" value="'.$rec[$i]['student_id'].'">'.$rec[$i]['student_first_name'].' '.$rec[$i]['student_last_name'].'</td><td width="10%">
				<select class="form-control" name="attend_val[]">
					<option value="Present">Present</option>
					<option value="Absent">Absent</option>
				</select>
			</td><td><input type="number" name="periodic_test[]" class="form-control periodic_test marktoadd text-center" step="0.01" value="" '.(in_array('periodictest', $validations) ? 'readonly' : '').'></td><td style="display:none;"><input type="number" name="maxmarks_theory[]" class="form-control max_marks marktoadd text-center" step="0.01" readonly value="'.$rec[$i]['maxmark_theory'].'"></td><td><input type="number" name="mark_obtained_theory[]" class="form-control mark_obtained_theory marktoadd text-center half_yearly" step="0.01" '.(in_array('halfyearly', $validations) ? 'readonly' : '').' ></td>'. ( $res[0]['exam_term'] == 'Term-1 (100 marks)' ? '':'<td style="display:none;"><input type="number" name="maxmarks_practical[]" class="form-control maxmarks_practical marktoadd text-center" step="0.01" readonly value="'.$rec[$i]['maxmark_practical'].'"></td><td><input type="number" name="mark_obtained_practical[]" class="form-control mark_obtained_practical marktoadd text-center" step="0.01" '.(in_array('iapractical', $validations) ? 'readonly' : '').'></td>').'</tr>';
				}
			}

			

	}

		
		$html.= '</table>';
	}else{
			$html = '<table class="table table-condensed table-bordered" width="100%"><tr>
                        <th>Scholastic Areas</th>
                        <th colspan="4">
                          <select class="form-control" name="exam_term" id="exam_term" required>
                            
                            <option value="'.$res[0]['exam_term'].'">'.$res[0]['exam_term'].'</option>
                            
                          </select>
                        </th>
                      </tr>
                      <tr>
                        <th style="width: 5%;">Adm. No</th>
                        <th style="width: 15%;">Student Name</th>
                        <th style="width: 10%;">Attendance</th>
                        
                        <th style="width: 15%;" class="text-center">' 
             . ( $res[0]['exam_term'] == 'Term-1 (100 marks)' ? 'Periodic Test 1' : 'Pre Board-1' ) . ' (30)</th>
             
                        <th style="width: 15%;" class="text-center">' 
             . ( $res[0]['exam_term'] == 'Term-1 (100 marks)' ? 'Half Yearly' : 'Pre Board-2' ) . ' ('.$rec[0]['maxmark_theory'].')</th>
             		
                      </tr>';
		for($i=0;$i<count($rec);$i++){

			$oldstd = $this->Common_Model->FetchData("exam_result_items as a  LEFT JOIN exam_results as b ON a.exam_result_id = b.exam_result_id", "*", "b.class_id = '".$this->input->post("class_id")."' AND b.session_id = '".$this->input->post("session_id")."' AND b.section = '".$this->input->post("section_id")."' AND b.subject_id ='".$this->input->post("subject_id")."' AND b.term ='".$res[0]['exam_term']."' AND a.student_id='".$rec[$i]['student_id']."' ");

			if ($oldstd) {
				
			}else{

			$e = json_decode($rec[$i]['subject_studied']); 
				//print_r($d);exit;
				if (in_array($this->input->post("subject_id"), $e)) {
			$html.= '<tr><td>'.$rec[$i]['student_serial_no'].'</td><td><input type="hidden" name="student_id[]" value="'.$rec[$i]['student_id'].'">'.$rec[$i]['student_first_name'].' '.$rec[$i]['student_last_name'].'</td><td width="10%">
				<select class="form-control" name="attend_val[]">
					<option value="Present">Present</option>
					<option value="Absent">Absent</option>
				</select>
			</td><td><input type="number" name="periodic_test[]" class="form-control periodic_test marktoadd text-center" step="0.01" value="" '.(in_array('periodictest', $validations) ? 'readonly' : '').'></td><td style="display:none;"><input type="number" name="maxmarks_theory[]" class="form-control max_marks marktoadd text-center" step="0.01" readonly value="'.$rec[$i]['maxmark_theory'].'"></td><td><input type="number" name="mark_obtained_theory[]" class="form-control mark_obtained_theory marktoadd text-center half_yearly" step="0.01" '.(in_array('halfyearly', $validations) ? 'readonly' : '').' ></td></tr>';
			}

		}
	}

		
		$html.= '</table>';
	}


		echo $html;
	}

	function getSLFCClassNurceryto8(){

	    error_reporting(0);
		$term = $this->session->userdata('exam_term');
		$ssn = $this->session->userdata('session_id');
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$res = $this->Common_Model->FetchData("exam_term","*","active_exam_term = 'Active'");

		$rem = $this->Common_Model->FetchData("student_admission AS sa LEFT JOIN students AS s ON sa.student_id = s.student_id ", "*", "sa.class_id = ".$this->input->post("class_id")." AND sa.session_id = ".$this->input->post("session_id")." AND s.student_section = ".$this->input->post("section_id")." AND admission_status = 'Active' ORDER BY s.student_serial_no ASC");
		$classes = $this->Common_Model->FetchData("classes","*","class_id='".$this->input->post("class_id")."'");
		$html = '<table class="table table-condensed table-bordered" width="100%"><tr>
                        <th colspan="2">Scholastic Areas</th>
                        <th colspan="6">
                          <select class="form-control" name="exam_term" id="exam_term" required>
                            
                            <option value="'.$res[0]['exam_term'].'">'.$res[0]['exam_term'].'</option>
                            
                          </select>
                        </th>
                      </tr>
                      <tr>
                        <th width="10%">Students</th>
                        ';
                        for($n=0; $n < $classes[0]['noofsubjects'];$n++){
                        	$html.='<th width="10%">Subject</th>
                        	<th width="20%" class="text-center">' 
             . ( $res[0]['exam_term'] == 'Term-1 (100 marks)' ? 'PT-1<br>(20/30)' : 'PT-2<br>(20/30)' ) . '</th>
                        <th width="10%" class="text-center">' 
             . ( $res[0]['exam_term'] == 'Term-1 (100 marks)' ? 'PT-1 Weightage<br>(10)' : 'PT-2 Weightage(10)' ) . '</th>
                        
                        <th width="10%" class="text-center">Portfolio<br>(5)</th>
                        <th width="10%" class="text-center">Sub-enrich.<br>(5)</th>
                       	<th width="10%" class="text-center">' 
             			. ( $res[0]['exam_term'] == 'Term-1 (100 marks)' ? 'Half Yearly<br>(80)' : 'Annual<br>(80)' ) . '</th>
                        <th width="10%" class="text-center">Total<br>(100)</th>
                        <th width="10%" class="text-center">Grade</th>
                        

             	';
                        }
                        $html.='<th style="width: 7%;" class="text-center">GK Mark</th>
	                        <th style="width: 7%;" class="text-center">GK Grade</th>
	                        <th style="width: 7%;" class="text-center">MS Mark</th>
	                        <th style="width: 7%;" class="text-center">MS Grade</th>
	                        <th style="width: 7%;" class="text-center">Comp. Mark</th>
	                        <th style="width: 7%;" class="text-center">Comp. Grade</th>
	                        <th style="width: 7%;" class="text-center">Work Education Grade</th>
	                        <th style="width: 7%;" class="text-center">Art Education Grade</th>
	                        <th style="width: 7%;" class="text-center">Physical Education Grade</th>
	                        <th style="width: 7%;" class="text-center">Discipline Grade</th>
	                        <th style="width: 7%;" class="text-center">Total Working Days</th>
	                        <th style="width: 7%;" class="text-center">Total Attendance</th>
	                        <th style="width: 7%;" class="text-center">Teacher Remarks</th>
	                        </tr>';
	                        if ($rem) {for ($c=0; $c <count($rem) ; $c++) {

	                        	$chkcert = $this->Common_Model->FetchData("certificate","*","session_id='".$this->input->post('session_id')."' AND class_id='".$this->input->post('class_id')."' AND section_id='".$this->input->post('section_id')."' AND exam_term='".$res[0]['exam_term']."' AND student_id='".$rem[$c]['student_id']."'");
						if ($chkcert) {
							
						}else{

	                        	$html.= '<tr><td><input type="hidden" name="student[]" value="'.$rem[$c]['student_id'].'">'.$rem[$c]['student_first_name'].' '.$rem[$c]['student_last_name'].'</td>';
	                        	$remsub=$rem[$c]['subject_studied'];
	                        	$sub_json = json_decode($remsub);
	                        	$records = $this->Common_Model->FetchData("exam_result_items as s LEFT JOIN exam_results as r ON r.exam_result_id=s.exam_result_id LEFT JOIN sessions as t ON r.session_id=t.session_id LEFT JOIN classes AS c ON r.class_id = c.class_id LEFT JOIN sections AS d ON r.section = d.section_id LEFT JOIN students AS e ON s.student_id = e.student_id LEFT JOIN subjects AS f ON r.subject_id = f.subject_id", "*", "s.student_id = ".$rem[$c]['student_id']." AND r.term = '".$res[0]['exam_term']."' AND r.session_id = ".$ssn."");
	                        	$r_mark = array_column($records, 'total'); 
                           $min = min($r_mark);
                           //print_r($min);
                           
	                        	//print_r($sub_json);
	                        	for ($d=0; $d <count($sub_json) ; $d++) {
	                        		# code...
	                        	
	                        	$record = $this->Common_Model->FetchData("exam_result_items as s LEFT JOIN exam_results as r ON r.exam_result_id=s.exam_result_id LEFT JOIN sessions as t ON r.session_id=t.session_id LEFT JOIN classes AS c ON r.class_id = c.class_id LEFT JOIN sections AS d ON r.section = d.section_id LEFT JOIN students AS e ON s.student_id = e.student_id LEFT JOIN subjects AS f ON r.subject_id = f.subject_id", "*", "s.student_id = ".$rem[$c]['student_id']." AND r.term = '".$res[0]['exam_term']."' AND r.session_id = ".$ssn." AND r.subject_id='".$sub_json[$d]."' ");
	                        	$rec = $this->Common_Model->FetchData("exam_result_items as s LEFT JOIN exam_results as r ON r.exam_result_id=s.exam_result_id LEFT JOIN sessions as t ON r.session_id=t.session_id LEFT JOIN classes AS c ON r.class_id = c.class_id LEFT JOIN sections AS d ON r.section = d.section_id LEFT JOIN students AS e ON s.student_id = e.student_id LEFT JOIN subjects AS f ON r.subject_id = f.subject_id", "*", "s.student_id = ".$rem[$c]['student_id']." AND r.term = '".$res[0]['exam_term']."' AND r.session_id = ".$ssn." AND r.subject_id='".$sub_json[5]."' ");
	                        	$re = $this->Common_Model->FetchData("exam_result_items as s LEFT JOIN exam_results as r ON r.exam_result_id=s.exam_result_id LEFT JOIN sessions as t ON r.session_id=t.session_id LEFT JOIN classes AS c ON r.class_id = c.class_id LEFT JOIN sections AS d ON r.section = d.section_id LEFT JOIN students AS e ON s.student_id = e.student_id LEFT JOIN subjects AS f ON r.subject_id = f.subject_id", "*", "s.student_id = ".$rem[$c]['student_id']." AND r.term = '".$res[0]['exam_term']."' AND r.session_id = ".$ssn."  AND s.grade='E'");
	                        	
	                        	//print_r($re[0]['subject_id']);
	                        	if($record){ for($i=0;$i<count($record);$i++){
	                        		$html.='<input type="hidden" id="std'.$i.'" name="student_id[]" value="'.$record[$i]['student_id'].'"><input type="hidden" id="sub'.$i.'" name="sub_status[]" value="'.(($record[$i]['subject_id']==296 || $record[$i]['subject_id']==234)?"Optional":"Compulsory").'"><input type="hidden" id="sub'.$i.'" name="subject_id[]" value="'.$record[$i]['subject_id'].'"><td><input type="text" id="sub'.$i.'" name="" value="'.$record[$i]['subject_name'].'" class="form-control td_width" readonly></td><td><input type="number" id="pt'.$i.'" name="pt[]" class="form-control td_width pt marktoadd text-center" step="0.01" value="'.$record[$i]['pt'].'" readonly></td><td><input type="number" id="pt1'.$i.'" name="pt_weightage[]" class="form-control td_width pt_weightage marktoadd text-center" step="0.01" value="'.$record[$i]['pt_weightage'].'" readonly></td><td><input type="number" id="pt2'.$i.'" name="portfolio[]" class="form-control td_width portfolio marktoadd text-center" step="0.01" value="'.$record[$i]['portfolio'].'" readonly></td><td><input type="number" id="pb'.$i.'" name="sub_enrichment[]" class="form-control td_width sub_enrichment marktoadd text-center" readonly step="0.01" value="'.$record[$i]['sub_enrichment'].'"></td><td><input type="number" id="pa'.$i.'" name="half_yearly[]" class="form-control td_width half_yearly marktoadd text-center" readonly step="0.01" value="'.$record[$i]['half_yearly'].'"></td>';
	                        		if ($record[$i]['total']<30 && $record[$i]['total']==$min && $record[$i]['sub_total']!=0 && $record[$i]['subject_id']==$re[0]['subject_id']){
				$html.='<td><input type="number" id="t5'.$i.'" name="total[]" class="form-control td_width total text-center" step="0.01" readonly value="'.$rec[0]['total'].'"></td><td><input type="text" id="grade'.$i.'" name="grade[]" class="form-control td_width grade text-center" readonly value="'.$rec[0]['grade'].'"></td>';
			}else{

			$html.='<td><input type="number" id="t5'.$i.'" name="total[]" class="form-control td_width total text-center" step="0.01" readonly value="'.$record[$i]['total'].'"></td><td><input type="text" id="grade'.$i.'" name="grade[]" class="form-control td_width grade text-center" readonly value="'.$record[$i]['grade'].'"></td>';
		}
	                        }}}
	                        $remark = $this->Common_Model->FetchData("exam_remark_items as s LEFT JOIN exam_remarks as r ON r.exam_remark_id=s.exam_remark_id ", "*", "s.student_id = ".$rem[$c]['student_id']." AND r.term = '".$res[0]['exam_term']."' AND r.session_id = ".$ssn."");
                      	if($remark){
                      			$html.='<td><input type="number" class="form-control td_width text-center" name="gkmark[]" value="'.$remark[0]['gkmark'].'" readonly step="0.01"></td>
                      			<td><input type="text" class="form-control td_width text-center" name="gkgrade[]" value="'.$remark[0]['gkgrade'].'" readonly></td>
                      			<td><input type="number" class="form-control td_width text-center" name="msmark[]" value="'.$remark[0]['msmark'].'" readonly step="0.01"></td>
                      			<td><input type="text" class="form-control td_width text-center" name="msgrade[]" value="'.$remark[0]['msgrade'].'" readonly></td>
                      			<td><input type="number" class="form-control td_width text-center" name="compmark[]" value="'.$remark[0]['compmark'].'" readonly step="0.01"></td>
                      			<td><input type="text" class="form-control td_width text-center" name="compgrade[]" value="'.$remark[0]['compgrade'].'" readonly></td>
                      					<td><input type="text" class="form-control td_width text-center" name="work_grade[]" value="'.$remark[0]['weg'].'" readonly></td><td><input type="text" class="form-control td_width text-center" name="art_grade[]" value="'.$remark[0]['aeg'].'" readonly></td><td><input type="text" class="form-control td_width text-center" name="physical_grade[]" value="'.$remark[0]['peg'].'" readonly></td><td><input type="text" class="form-control td_width text-center" name="descipline_grade[]" value="'.$remark[0]['dg'].'" readonly></td><td><input type="number" class="form-control td_width text-center" name="t_working_days[]" value="'.$remark[0]['twd'].'" readonly></td><td><input type="number" class="form-control td_width text-center" name="t_attend[]" value="'.$remark[0]['ta'].'" readonly></td><td><input type="text" class="form-control td_width text-center" name="teacher_remark[]" value="'.$remark[0]['remark'].'" readonly></td>
                      			';
                      	}
	                        
                      	
		$html.='</tr>';
	}}}
		$html.= '</table>';

         echo $html;
	}

	function getSLFCClass9and10(){

	    error_reporting(0);
		$term = $this->session->userdata('exam_term');
		$ssn = $this->session->userdata('session_id');
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$res = $this->Common_Model->FetchData("exam_term","*","active_exam_term = 'Active'");

		$rem = $this->Common_Model->FetchData("student_admission AS sa LEFT JOIN students AS s ON sa.student_id = s.student_id ", "*", "sa.class_id = ".$this->input->post("class_id")." AND sa.session_id = ".$this->input->post("session_id")." AND s.student_section = ".$this->input->post("section_id")." AND admission_status = 'Active' ORDER BY s.student_serial_no ASC");
		if($res[0]['exam_term'] == 'Term-1 (100 marks)'){

		$html = '<table class="table table-condensed table-bordered" width="100%"><tr>
                        <th colspan="2">Scholastic Areas</th>
                        <th colspan="6">
                          <select class="form-control" name="exam_term" id="exam_term" required>
                            
                            <option value="'.$res[0]['exam_term'].'">'.$res[0]['exam_term'].'</option>
                            
                          </select>
                        </th>
                      </tr>
                      <tr>
                        <th width="10%">Students</th>
                        ';
                        for($n=0; $n < 6;$n++){
                        	$html.='<th width="10%">Subject</th>
                        	<th width="20%" class="text-center">PT-1<br>(25/30)</th>
                        	<th width="10%" class="text-center">Theory<br>(25)</th>
                        	<th width="10%" class="text-center">Practical<br>(25)</th>
	                       	<th width="10%" class="text-center">Half Yearly<br>(80)</th>

                        ';
                        }
                        $html.='<th style="width: 7%;">Work Education Grade</th>
	                        <th style="width: 7%;">Art Education Grade</th>
	                        <th style="width: 7%;">Physical Education Grade</th>
	                        <th style="width: 7%;">Discipline Grade</th>
	                        <th style="width: 7%;">Total Working Days</th>
	                        <th style="width: 7%;">Total Attendance</th>
	                        <th style="width: 7%;">Teacher Remarks</th>
	                        </tr>';
	                        if ($rem) {for ($c=0; $c <count($rem) ; $c++) {

	                        	$chkcert = $this->Common_Model->FetchData("certificate","*","session_id='".$this->input->post('session_id')."' AND class_id='".$this->input->post('class_id')."' AND section_id='".$this->input->post('section_id')."' AND exam_term='".$res[0]['exam_term']."' AND student_id='".$rem[$c]['student_id']."'");
						if ($chkcert) {
							
						}else{

	                        	$html.= '<tr><td><input type="hidden" name="student[]" value="'.$rem[$c]['student_id'].'">'.$rem[$c]['student_first_name'].' '.$rem[$c]['student_last_name'].'</td>';
	                        	$remsub=$rem[$c]['subject_studied'];
	                        	$sub_json = json_decode($remsub);
	                        	$records = $this->Common_Model->FetchData("exam_result_items as s LEFT JOIN exam_results as r ON r.exam_result_id=s.exam_result_id LEFT JOIN sessions as t ON r.session_id=t.session_id LEFT JOIN classes AS c ON r.class_id = c.class_id LEFT JOIN sections AS d ON r.section = d.section_id LEFT JOIN students AS e ON s.student_id = e.student_id LEFT JOIN subjects AS f ON r.subject_id = f.subject_id", "*", "s.student_id = ".$rem[$c]['student_id']." AND r.term = '".$res[0]['exam_term']."' AND r.session_id = ".$ssn."");
  
	                        	for ($d=0; $d <count($sub_json) ; $d++) {

	                        	
	                        	$record = $this->Common_Model->FetchData("exam_result_items as s LEFT JOIN exam_results as r ON r.exam_result_id=s.exam_result_id LEFT JOIN sessions as t ON r.session_id=t.session_id LEFT JOIN classes AS c ON r.class_id = c.class_id LEFT JOIN sections AS d ON r.section = d.section_id LEFT JOIN students AS e ON s.student_id = e.student_id LEFT JOIN subjects AS f ON r.subject_id = f.subject_id", "*", "s.student_id = ".$rem[$c]['student_id']." AND r.term = '".$res[0]['exam_term']."' AND r.session_id = ".$ssn." AND r.subject_id='".$sub_json[$d]."' ");
	                        	$rec = $this->Common_Model->FetchData("exam_result_items as s LEFT JOIN exam_results as r ON r.exam_result_id=s.exam_result_id LEFT JOIN sessions as t ON r.session_id=t.session_id LEFT JOIN classes AS c ON r.class_id = c.class_id LEFT JOIN sections AS d ON r.section = d.section_id LEFT JOIN students AS e ON s.student_id = e.student_id LEFT JOIN subjects AS f ON r.subject_id = f.subject_id", "*", "s.student_id = ".$rem[$c]['student_id']." AND r.term = '".$res[0]['exam_term']."' AND r.session_id = ".$ssn." AND r.subject_id='".$sub_json[5]."' ");
	                        	

	                        	if($record){ for($i=0;$i<count($record);$i++){
	                        		$html.='<input type="hidden" id="std'.$i.'" name="student_id[]" value="'.$record[$i]['student_id'].'"><input type="hidden" id="sub'.$i.'" name="sub_status[]" value="'.(($record[$i]['subject_id']==296 || $record[$i]['subject_id']==234)?"Optional":"Compulsory").'"><input type="hidden" id="sub'.$i.'" name="subject_id[]" value="'.$record[$i]['subject_id'].'"><td><input type="text" id="sub'.$i.'" name="" value="'.$record[$i]['subject_name'].'" class="form-control td_width" readonly></td><td><input type="number" id="pt'.$i.'" name="pt[]" class="form-control td_width pt marktoadd text-center" step="0.01" value="'.$record[$i]['pt'].'" readonly></td><td><input type="number" id="theory'.$i.'" name="theory[]" class="form-control td_width theory marktoadd text-center" step="0.01" value="'.$record[$i]['theory'].'" readonly></td><td><input type="number" id="practical'.$i.'" name="practical[]" class="form-control td_width practical marktoadd text-center" readonly step="0.01" value="'.$record[$i]['practical'].'"></td><td><input type="number" id="pa'.$i.'" name="half_yearly[]" class="form-control td_width half_yearly marktoadd text-center" readonly step="0.01" value="'.$record[$i]['half_yearly'].'"></td>';


	                        		
	                        }}}
	                        $remark = $this->Common_Model->FetchData("exam_remark_items as s LEFT JOIN exam_remarks as r ON r.exam_remark_id=s.exam_remark_id ", "*", "s.student_id = ".$rem[$c]['student_id']." AND r.term = '".$res[0]['exam_term']."' AND r.session_id = ".$ssn."");
                      	if($remark){
                      			$html.='
                      					<td><input type="text" class="form-control td_width" name="work_grade[]" value="'.$remark[0]['weg'].'" readonly></td><td><input type="text" class="form-control td_width" name="art_grade[]" value="'.$remark[0]['aeg'].'" readonly></td><td><input type="text" class="form-control td_width" name="physical_grade[]" value="'.$remark[0]['peg'].'" readonly></td><td><input type="text" class="form-control td_width" name="descipline_grade[]" value="'.$remark[0]['dg'].'" readonly></td><td><input type="number" class="form-control td_width" name="t_working_days[]" value="'.$remark[0]['twd'].'" readonly></td><td><input type="number" class="form-control td_width" name="t_attend[]" value="'.$remark[0]['ta'].'" readonly></td><td><input type="text" class="form-control td_width" name="teacher_remark[]" value="'.$remark[0]['remark'].'" readonly></td>
                      			';
                      	}
	                        
                      	
		$html.='</tr>';
	}}}
		$html.= '</table>';
	}else{
			$html = '<table class="table table-condensed table-bordered" width="100%"><tr>
                        <th colspan="2">Scholastic Areas</th>
                        <th colspan="6">
                          <select class="form-control" name="exam_term" id="exam_term" required>
                            
                            <option value="'.$res[0]['exam_term'].'">'.$res[0]['exam_term'].'</option>
                            
                          </select>
                        </th>
                      </tr>
                      <tr>
                        <th width="10%">Students</th>
                        ';
                        for($n=0; $n < 6;$n++){
                        	$html.='<th width="10%">Subject</th>
                        	<th width="20%" class="text-center">PT-2</th>
                        	<th width="10%" class="text-center">M.Assessment</th>
                        	<th width="10%" class="text-center">Portfolio</th>
                        	<th width="10%" class="text-center">Sub. Enrichment</th>
                        	<th width="10%" class="text-center">Theory</th>
                        	<th width="10%" class="text-center">Practical</th>
	                       	<th width="10%" class="text-center">Annual</th>

                        ';
                        }
                        $html.='<th style="width: 7%;">Work Education Grade</th>
	                        <th style="width: 7%;">Art Education Grade</th>
	                        <th style="width: 7%;">Physical Education Grade</th>
	                        <th style="width: 7%;">Discipline Grade</th>
	                        <th style="width: 7%;">Total Working Days</th>
	                        <th style="width: 7%;">Total Attendance</th>
	                        <th style="width: 7%;">Teacher Remarks</th>
	                        </tr>';
	                        if ($rem) {for ($c=0; $c <count($rem) ; $c++) {

	                        	$chkcert = $this->Common_Model->FetchData("certificate","*","session_id='".$this->input->post('session_id')."' AND class_id='".$this->input->post('class_id')."' AND section_id='".$this->input->post('section_id')."' AND exam_term='".$res[0]['exam_term']."' AND student_id='".$rem[$c]['student_id']."'");
						if ($chkcert) {
							
						}else{

	                        	$html.= '<tr><td><input type="hidden" name="student[]" value="'.$rem[$c]['student_id'].'">'.$rem[$c]['student_first_name'].' '.$rem[$c]['student_last_name'].'</td>';
	                        	$remsub=$rem[$c]['subject_studied'];
	                        	$sub_json = json_decode($remsub);
	                        	$records = $this->Common_Model->FetchData("exam_result_items as s LEFT JOIN exam_results as r ON r.exam_result_id=s.exam_result_id LEFT JOIN sessions as t ON r.session_id=t.session_id LEFT JOIN classes AS c ON r.class_id = c.class_id LEFT JOIN sections AS d ON r.section = d.section_id LEFT JOIN students AS e ON s.student_id = e.student_id LEFT JOIN subjects AS f ON r.subject_id = f.subject_id", "*", "s.student_id = ".$rem[$c]['student_id']." AND r.term = '".$res[0]['exam_term']."' AND r.session_id = ".$ssn."");
  
	                        	for ($d=0; $d <count($sub_json) ; $d++) {

	                        	
	                        	$record = $this->Common_Model->FetchData("exam_result_items as s LEFT JOIN exam_results as r ON r.exam_result_id=s.exam_result_id LEFT JOIN sessions as t ON r.session_id=t.session_id LEFT JOIN classes AS c ON r.class_id = c.class_id LEFT JOIN sections AS d ON r.section = d.section_id LEFT JOIN students AS e ON s.student_id = e.student_id LEFT JOIN subjects AS f ON r.subject_id = f.subject_id", "*", "s.student_id = ".$rem[$c]['student_id']." AND r.term = '".$res[0]['exam_term']."' AND r.session_id = ".$ssn." AND r.subject_id='".$sub_json[$d]."' ");

	                        	$recordterm1 = $this->Common_Model->FetchData("exam_result_items as s LEFT JOIN exam_results as r ON r.exam_result_id=s.exam_result_id LEFT JOIN sessions as t ON r.session_id=t.session_id LEFT JOIN classes AS c ON r.class_id = c.class_id LEFT JOIN sections AS d ON r.section = d.section_id LEFT JOIN students AS e ON s.student_id = e.student_id LEFT JOIN subjects AS f ON r.subject_id = f.subject_id", "*", "s.student_id = ".$rem[$c]['student_id']." AND r.term = 'Term-1 (100 marks)' AND r.session_id = ".$ssn." AND r.subject_id='".$sub_json[$d]."' ");
	                        	

	                        	$rec = $this->Common_Model->FetchData("exam_result_items as s LEFT JOIN exam_results as r ON r.exam_result_id=s.exam_result_id LEFT JOIN sessions as t ON r.session_id=t.session_id LEFT JOIN classes AS c ON r.class_id = c.class_id LEFT JOIN sections AS d ON r.section = d.section_id LEFT JOIN students AS e ON s.student_id = e.student_id LEFT JOIN subjects AS f ON r.subject_id = f.subject_id", "*", "s.student_id = ".$rem[$c]['student_id']." AND r.term = '".$res[0]['exam_term']."' AND r.session_id = ".$ssn." AND r.subject_id='".$sub_json[5]."' ");
	                        	

	                        	if($record){ for($i=0;$i<count($record);$i++){
	                        		$html.='<input type="hidden" id="std'.$i.'" name="student_id[]" value="'.$record[$i]['student_id'].'"><input type="hidden" id="sub'.$i.'" name="sub_status[]" value="'.(($record[$i]['subject_id']==296 || $record[$i]['subject_id']==234)?"Optional":"Compulsory").'"><input type="hidden" id="sub'.$i.'" name="subject_id[]" value="'.$record[$i]['subject_id'].'"><td><input type="text" id="sub'.$i.'" name="" value="'.$record[$i]['subject_name'].'" class="form-control td_width" readonly></td>';


	                        		$html .='<td><input type="number" id="pt'.$i.'" name="pt[]" class="form-control td_width pt marktoadd text-center" step="0.01" value="'.$record[$i]['pt'].'" readonly></td><td><input type="number" id="m_assessment'.$i.'" name="m_assessment[]" class="form-control td_width m_assessment marktoadd text-center" step="0.01" value="'.$record[$i]['m_assessment'].'" readonly></td><td><input type="number" id="portfolio'.$i.'" name="portfolio[]" class="form-control td_width portfolio marktoadd text-center" step="0.01" value="'.$record[$i]['portfolio'].'" readonly></td><td><input type="number" id="sub_enrichment'.$i.'" name="sub_enrichment[]" class="form-control td_width sub_enrichment marktoadd text-center" step="0.01" value="'.$record[$i]['sub_enrichment'].'" readonly></td><td><input type="number" id="theory'.$i.'" name="theory[]" class="form-control td_width theory marktoadd text-center" step="0.01" value="'.$record[$i]['theory'].'" readonly></td><td><input type="number" id="practical'.$i.'" name="practical[]" class="form-control td_width practical marktoadd text-center" readonly step="0.01" value="'.$record[$i]['practical'].'"></td><td><input type="number" id="pa'.$i.'" name="half_yearly[]" class="form-control td_width half_yearly marktoadd text-center" readonly step="0.01" value="'.$record[$i]['half_yearly'].'"></td>';
	                        		
	                        }}}
	                        $remark = $this->Common_Model->FetchData("exam_remark_items as s LEFT JOIN exam_remarks as r ON r.exam_remark_id=s.exam_remark_id ", "*", "s.student_id = ".$rem[$c]['student_id']." AND r.term = '".$res[0]['exam_term']."' AND r.session_id = ".$ssn."");
                      	if($remark){
                      			$html.='
                      					<td><input type="text" class="form-control td_width" name="work_grade[]" value="'.$remark[0]['weg'].'" readonly></td><td><input type="text" class="form-control td_width" name="art_grade[]" value="'.$remark[0]['aeg'].'" readonly></td><td><input type="text" class="form-control td_width" name="physical_grade[]" value="'.$remark[0]['peg'].'" readonly></td><td><input type="text" class="form-control td_width" name="descipline_grade[]" value="'.$remark[0]['dg'].'" readonly></td><td><input type="number" class="form-control td_width" name="t_working_days[]" value="'.$remark[0]['twd'].'" readonly></td><td><input type="number" class="form-control td_width" name="t_attend[]" value="'.$remark[0]['ta'].'" readonly></td><td><input type="text" class="form-control td_width" name="teacher_remark[]" value="'.$remark[0]['remark'].'" readonly></td>
                      			';
                      	}
	                        
                      	
		$html.='</tr>';
	}}}
		$html.= '</table>';
	}

         echo $html;
	}


	function getStudentListBySessionClass44(){
	    error_reporting(0);
		$term = $this->session->userdata('exam_term');
		$ssn = $this->session->userdata('session_id');
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$res = $this->Common_Model->FetchData("exam_term","*","active_exam_term = 'Active'");

		$rem = $this->Common_Model->FetchData("student_admission AS sa LEFT JOIN students AS s ON sa.student_id = s.student_id ", "*", "sa.class_id = ".$this->input->post("class_id")." AND sa.session_id = ".$this->input->post("session_id")." AND s.student_section = ".$this->input->post("section_id")." AND admission_status = 'Active' ORDER BY s.student_serial_no ASC");
		$classes = $this->Common_Model->FetchData("classes","*","class_id='".$this->input->post("class_id")."'");
		if($res[0]['exam_term'] == 'Term-1 (100 marks)'){
		$html = '<table class="table table-condensed table-bordered"><tr>
                        <th colspan="2">Scholastic Areas</th>
                        <th colspan="6">
                          <select class="form-control" name="exam_term" id="exam_term" required>
                            
                            <option value="'.$res[0]['exam_term'].'">'.$res[0]['exam_term'].'</option>
                            
                          </select>
                        </th>
                      </tr>
                      <tr>
                        <th style="width: 7%;">Students</th>
                        ';
                        for($n=0; $n < $classes[0]['noofsubjects'];$n++){
                        	$html.='<th style="width: 12%;">Subject</th>
			                        <th width="20%" class="text-center">Periodic Test</th>
		                        	<th width="10%" class="text-center">Max Marks HY</th>
		                        	<th width="10%" class="text-center">Half Yearly</th>
			                      ';
                        }
                        $html.='<th style="width: 7%;">Work Education Grade</th>
	                        <th style="width: 7%;">Art Education Grade</th>
	                        <th style="width: 7%;">Physical Education Grade</th>
	                        <th style="width: 7%;">Discipline Grade</th>
	                        <th style="width: 7%;">Total Working Days</th>
	                        <th style="width: 7%;">Total Attendance</th>
	                        <th style="width: 7%;">Teacher Remarks</th>
	                        </tr>';
	             if ($rem) {for ($c=0; $c <count($rem) ; $c++) {

	             			$chkcert = $this->Common_Model->FetchData("certificate","*","session_id='".$this->input->post('session_id')."' AND class_id='".$this->input->post('class_id')."' AND section_id='".$this->input->post('section_id')."' AND exam_term='".$res[0]['exam_term']."' AND student_id='".$rem[$c]['student_id']."'");
						if ($chkcert) {
							
						}else{


	                        	$html.= '<tr><td><input type="hidden" name="student[]" value="'.$rem[$c]['student_id'].'">'.$rem[$c]['student_first_name'].' '.$rem[$c]['student_last_name'].'</td>';
	                        	$remsub=$rem[$c]['subject_studied'];
	                        	$sub_json = json_decode($remsub);
	                        	$records = $this->Common_Model->FetchData("exam_result_items as s LEFT JOIN exam_results as r ON r.exam_result_id=s.exam_result_id LEFT JOIN sessions as t ON r.session_id=t.session_id LEFT JOIN classes AS c ON r.class_id = c.class_id LEFT JOIN sections AS d ON r.section = d.section_id LEFT JOIN students AS e ON s.student_id = e.student_id LEFT JOIN subjects AS f ON r.subject_id = f.subject_id", "*", "s.student_id = ".$rem[$c]['student_id']." AND r.term = '".$res[0]['exam_term']."' AND r.session_id = ".$ssn."");
	                        	
                           //print_r($min);
                           
	                        	//print_r($sub_json);
	                        	for ($d=0; $d <count($sub_json) ; $d++) {
	                        		# code...
	                        	
	                        	$record = $this->Common_Model->FetchData("exam_result_items as s LEFT JOIN exam_results as r ON r.exam_result_id=s.exam_result_id LEFT JOIN sessions as t ON r.session_id=t.session_id LEFT JOIN classes AS c ON r.class_id = c.class_id LEFT JOIN sections AS d ON r.section = d.section_id LEFT JOIN students AS e ON s.student_id = e.student_id LEFT JOIN subjects AS f ON r.subject_id = f.subject_id", "*", "s.student_id = ".$rem[$c]['student_id']." AND r.term = '".$res[0]['exam_term']."' AND r.session_id = ".$ssn." AND r.subject_id='".$sub_json[$d]."' ");
	                        	$rec = $this->Common_Model->FetchData("exam_result_items as s LEFT JOIN exam_results as r ON r.exam_result_id=s.exam_result_id LEFT JOIN sessions as t ON r.session_id=t.session_id LEFT JOIN classes AS c ON r.class_id = c.class_id LEFT JOIN sections AS d ON r.section = d.section_id LEFT JOIN students AS e ON s.student_id = e.student_id LEFT JOIN subjects AS f ON r.subject_id = f.subject_id", "*", "s.student_id = ".$rem[$c]['student_id']." AND r.term = '".$res[0]['exam_term']."' AND r.session_id = ".$ssn." AND r.subject_id='".$sub_json[5]."' ");
	                        	
	                        	
	                        	//print_r($re[0]['subject_id']);
	                        	if($record){ for($i=0;$i<count($record);$i++){
	                        		$html.= '<input type="hidden" id="std'.$i.'" name="student_id[]" value="'.$record[$i]['student_id'].'"><input type="hidden" id="sub'.$i.'" name="sub_status[]" value="'.$record[$i]['sub_status'].'"><input type="hidden" id="sub'.$i.'" name="subject_id[]" value="'.$record[$i]['subject_id'].'"><td><input type="text" id="sub'.$i.'" name="" value="'.$record[$i]['subject_name'].'" class="form-control td_width" readonly></td><td><input type="number" name="periodic_test[]" class="form-control td_width periodic_test marktoadd text-center" step="0.01" readonly value="'.$record[$i]['periodic_test'].'"></td><td><input type="number" name="maxmarks_theory[]" class="form-control td_width max_marks marktoadd text-center" step="0.01" readonly value="'.$record[$i]['maxmarks_theory'].'"></td><td><input type="number" name="mark_obtained_theory[]" class="form-control td_width mark_obtained_theory marktoadd text-center" step="0.01" value="'.$record[$i]['mark_obtained_theory'].'" readonly></td></td>';
	                        		
	                        }}}
	                        $remark = $this->Common_Model->FetchData("exam_remark_items as s LEFT JOIN exam_remarks as r ON r.exam_remark_id=s.exam_remark_id ", "*", "s.student_id = ".$rem[$c]['student_id']." AND r.term = '".$res[0]['exam_term']."' AND r.session_id = ".$ssn."");
                      	if($remark){
                      			$html.='
                      					<td><input type="text" class="form-control td_width" name="work_grade[]" value="'.$remark[0]['weg'].'" readonly></td><td><input type="text" class="form-control td_width" name="art_grade[]" value="'.$remark[0]['aeg'].'" readonly></td><td><input type="text" class="form-control td_width" name="physical_grade[]" value="'.$remark[0]['peg'].'" readonly></td><td><input type="text" class="form-control td_width" name="descipline_grade[]" value="'.$remark[0]['dg'].'" readonly></td><td><input type="number" class="form-control td_width" name="t_working_days[]" value="'.$remark[0]['twd'].'" readonly></td><td><input type="number" class="form-control td_width" name="t_attend[]" value="'.$remark[0]['ta'].'" readonly></td><td><input type="text" class="form-control td_width" name="teacher_remark[]" value="'.$remark[0]['remark'].'" readonly></td>
                      			';
                      	}
	                        
                      	
		$html.='</tr>';
	}} }
		$html.= '</table>';
	}else{

		if ($this->input->post("class_id") == 44 || $this->input->post("class_id") == 46 || $this->input->post("class_id") == 50) {
			
		$html = '<table class="table table-condensed table-bordered"><tr>
                        <th colspan="2">Scholastic Areas</th>
                        <th colspan="6">
                          <select class="form-control" name="exam_term" id="exam_term" required>
                            
                            <option value="'.$res[0]['exam_term'].'">'.$res[0]['exam_term'].'</option>
                            
                          </select>
                        </th>
                      </tr>
                      <tr>
                        <th style="width: 7%;">Students</th>
                        ';
                        for($n=0; $n < $classes[0]['noofsubjects'];$n++){
                        	$html.='<th style="width: 12%;">Subject</th>
			                        <th width="20%" class="text-center">Periodic Test</th>
		                        	<th width="10%" class="text-center">Max Marks Annual</th>
		                        	<th width="10%" class="text-center">Annual</th>
		                        	<th width="10%" class="text-center">Max Marks I.A</th>
		                        	<th width="10%" class="text-center">I.A</th>
			                      ';
                        }
                        $html.='<th style="width: 7%;">Work Education Grade</th>
	                        <th style="width: 7%;">Art Education Grade</th>
	                        <th style="width: 7%;">Physical Education Grade</th>
	                        <th style="width: 7%;">Discipline Grade</th>
	                        <th style="width: 7%;">Total Working Days</th>
	                        <th style="width: 7%;">Total Attendance</th>
	                        <th style="width: 7%;">Teacher Remarks</th>
	                        </tr>';
	                        if ($rem) {for ($c=0; $c <count($rem) ; $c++) {
	                        	$chkcert = $this->Common_Model->FetchData("certificate","*","session_id='".$this->input->post('session_id')."' AND class_id='".$this->input->post('class_id')."' AND section_id='".$this->input->post('section_id')."' AND exam_term='".$res[0]['exam_term']."' AND student_id='".$rem[$c]['student_id']."'");
						if ($chkcert) {
							
						}else{


	                        	$html.= '<tr><td><input type="hidden" name="student[]" value="'.$rem[$c]['student_id'].'">'.$rem[$c]['student_first_name'].' '.$rem[$c]['student_last_name'].'</td>';
	                        	$remsub=$rem[$c]['subject_studied'];
	                        	$sub_json = json_decode($remsub);
	                        	$records = $this->Common_Model->FetchData("exam_result_items as s LEFT JOIN exam_results as r ON r.exam_result_id=s.exam_result_id LEFT JOIN sessions as t ON r.session_id=t.session_id LEFT JOIN classes AS c ON r.class_id = c.class_id LEFT JOIN sections AS d ON r.section = d.section_id LEFT JOIN students AS e ON s.student_id = e.student_id LEFT JOIN subjects AS f ON r.subject_id = f.subject_id", "*", "s.student_id = ".$rem[$c]['student_id']." AND r.term = '".$res[0]['exam_term']."' AND r.session_id = ".$ssn."");
	                        	
                           //print_r($min);
                           
	                        	//print_r($sub_json);
	                        	for ($d=0; $d <count($sub_json) ; $d++) {
	                        		# code...
	                        	
	                        	$record = $this->Common_Model->FetchData("exam_result_items as s LEFT JOIN exam_results as r ON r.exam_result_id=s.exam_result_id LEFT JOIN sessions as t ON r.session_id=t.session_id LEFT JOIN classes AS c ON r.class_id = c.class_id LEFT JOIN sections AS d ON r.section = d.section_id LEFT JOIN students AS e ON s.student_id = e.student_id LEFT JOIN subjects AS f ON r.subject_id = f.subject_id", "*", "s.student_id = ".$rem[$c]['student_id']." AND r.term = '".$res[0]['exam_term']."' AND r.session_id = ".$ssn." AND r.subject_id='".$sub_json[$d]."' ");
	                        	$rec = $this->Common_Model->FetchData("exam_result_items as s LEFT JOIN exam_results as r ON r.exam_result_id=s.exam_result_id LEFT JOIN sessions as t ON r.session_id=t.session_id LEFT JOIN classes AS c ON r.class_id = c.class_id LEFT JOIN sections AS d ON r.section = d.section_id LEFT JOIN students AS e ON s.student_id = e.student_id LEFT JOIN subjects AS f ON r.subject_id = f.subject_id", "*", "s.student_id = ".$rem[$c]['student_id']." AND r.term = '".$res[0]['exam_term']."' AND r.session_id = ".$ssn." AND r.subject_id='".$sub_json[5]."' ");
	                        	
	                        	
	                        	//print_r($re[0]['subject_id']);
	                        	if($record){ for($i=0;$i<count($record);$i++){
	                        		$html.= '<input type="hidden" id="std'.$i.'" name="student_id[]" value="'.$record[$i]['student_id'].'"><input type="hidden" id="sub'.$i.'" name="sub_status[]" value="'.$record[$i]['sub_status'].'"><input type="hidden" id="sub'.$i.'" name="subject_id[]" value="'.$record[$i]['subject_id'].'"><td><input type="text" id="sub'.$i.'" name="" value="'.$record[$i]['subject_name'].'" class="form-control td_width" readonly></td><td><input type="number" name="periodic_test[]" class="form-control td_width periodic_test marktoadd text-center" step="0.01" readonly value="'.$record[$i]['periodic_test'].'"></td><td><input type="number" name="maxmarks_theory[]" class="form-control td_width max_marks marktoadd text-center" step="0.01" readonly value="'.$record[$i]['maxmarks_theory'].'"></td><td><input type="number" name="mark_obtained_theory[]" class="form-control td_width mark_obtained_theory marktoadd text-center" step="0.01" value="'.$record[$i]['mark_obtained_theory'].'" readonly></td><td><input type="number" name="maxmarks_practical[]" class="form-control td_width maxmarks_practical marktoadd text-center" step="0.01" readonly value="'.$record[$i]['maxmarks_practical'].'"></td><td><input type="number" name="mark_obtained_practical[]" class="form-control td_width mark_obtained_practical marktoadd text-center" step="0.01" value="'.$record[$i]['mark_obtained_practical'].'" readonly></td>';
	                        		
	                        }}}
	                        $remark = $this->Common_Model->FetchData("exam_remark_items as s LEFT JOIN exam_remarks as r ON r.exam_remark_id=s.exam_remark_id ", "*", "s.student_id = ".$rem[$c]['student_id']." AND r.term = '".$res[0]['exam_term']."' AND r.session_id = ".$ssn."");
                      	if($remark){
                      			$html.='
                      					<td><input type="text" class="form-control td_width" name="work_grade[]" value="'.$remark[0]['weg'].'" readonly></td><td><input type="text" class="form-control td_width" name="art_grade[]" value="'.$remark[0]['aeg'].'" readonly></td><td><input type="text" class="form-control td_width" name="physical_grade[]" value="'.$remark[0]['peg'].'" readonly></td><td><input type="text" class="form-control td_width" name="descipline_grade[]" value="'.$remark[0]['dg'].'" readonly></td><td><input type="number" class="form-control td_width" name="t_working_days[]" value="'.$remark[0]['twd'].'" readonly></td><td><input type="number" class="form-control td_width" name="t_attend[]" value="'.$remark[0]['ta'].'" readonly></td><td><input type="text" class="form-control td_width" name="teacher_remark[]" value="'.$remark[0]['remark'].'" readonly></td>
                      			';
                      	}
	                        
                      	
		$html.='</tr>';
	}}}
		$html.= '</table>';
		}else{
			$html = '<table class="table table-condensed table-bordered"><tr>
                        <th colspan="2">Scholastic Areas</th>
                        <th colspan="6">
                          <select class="form-control" name="exam_term" id="exam_term" required>
                            
                            <option value="'.$res[0]['exam_term'].'">'.$res[0]['exam_term'].'</option>
                            
                          </select>
                        </th>
                      </tr>
                      <tr>
                        <th style="width: 7%;">Students</th>
                        ';
                        for($n=0; $n < $classes[0]['noofsubjects'];$n++){
                        	$html.='<th style="width: 12%;">Subject</th>
			                        <th width="20%" class="text-center">Pre Board-1</th>
		                        	<th width="10%" class="text-center">Max Marks<br>Pre Board-2</th>
		                        	<th width="10%" class="text-center">Pre Board-2</th>

			                      ';
                        }
                        $html.='<th style="width: 7%;">Work Education Grade</th>
	                        <th style="width: 7%;">Art Education Grade</th>
	                        <th style="width: 7%;">Physical Education Grade</th>
	                        <th style="width: 7%;">Discipline Grade</th>
	                        <th style="width: 7%;">Total Working Days</th>
	                        <th style="width: 7%;">Total Attendance</th>
	                        <th style="width: 7%;">Teacher Remarks</th>
	                        </tr>';
	                        if ($rem) {for ($c=0; $c <count($rem) ; $c++) {
	                        	$html.= '<tr><td><input type="hidden" name="student[]" value="'.$rem[$c]['student_id'].'">'.$rem[$c]['student_first_name'].' '.$rem[$c]['student_last_name'].'</td>';
	                        	$remsub=$rem[$c]['subject_studied'];
	                        	$sub_json = json_decode($remsub);
	                        	$records = $this->Common_Model->FetchData("exam_result_items as s LEFT JOIN exam_results as r ON r.exam_result_id=s.exam_result_id LEFT JOIN sessions as t ON r.session_id=t.session_id LEFT JOIN classes AS c ON r.class_id = c.class_id LEFT JOIN sections AS d ON r.section = d.section_id LEFT JOIN students AS e ON s.student_id = e.student_id LEFT JOIN subjects AS f ON r.subject_id = f.subject_id", "*", "s.student_id = ".$rem[$c]['student_id']." AND r.term = '".$res[0]['exam_term']."' AND r.session_id = ".$ssn."");
	                        	
                           //print_r($min);
                           
	                        	//print_r($sub_json);
	                        	for ($d=0; $d <count($sub_json) ; $d++) {
	                        		# code...
	                        	
	                        	$record = $this->Common_Model->FetchData("exam_result_items as s LEFT JOIN exam_results as r ON r.exam_result_id=s.exam_result_id LEFT JOIN sessions as t ON r.session_id=t.session_id LEFT JOIN classes AS c ON r.class_id = c.class_id LEFT JOIN sections AS d ON r.section = d.section_id LEFT JOIN students AS e ON s.student_id = e.student_id LEFT JOIN subjects AS f ON r.subject_id = f.subject_id", "*", "s.student_id = ".$rem[$c]['student_id']." AND r.term = '".$res[0]['exam_term']."' AND r.session_id = ".$ssn." AND r.subject_id='".$sub_json[$d]."' ");
	                        	$rec = $this->Common_Model->FetchData("exam_result_items as s LEFT JOIN exam_results as r ON r.exam_result_id=s.exam_result_id LEFT JOIN sessions as t ON r.session_id=t.session_id LEFT JOIN classes AS c ON r.class_id = c.class_id LEFT JOIN sections AS d ON r.section = d.section_id LEFT JOIN students AS e ON s.student_id = e.student_id LEFT JOIN subjects AS f ON r.subject_id = f.subject_id", "*", "s.student_id = ".$rem[$c]['student_id']." AND r.term = '".$res[0]['exam_term']."' AND r.session_id = ".$ssn." AND r.subject_id='".$sub_json[5]."' ");
	                        	
	                        	
	                        	//print_r($re[0]['subject_id']);
	                        	if($record){ for($i=0;$i<count($record);$i++){
	                        		$html.= '<input type="hidden" id="std'.$i.'" name="student_id[]" value="'.$record[$i]['student_id'].'"><input type="hidden" id="sub'.$i.'" name="sub_status[]" value="'.$record[$i]['sub_status'].'"><input type="hidden" id="sub'.$i.'" name="subject_id[]" value="'.$record[$i]['subject_id'].'"><td><input type="text" id="sub'.$i.'" name="" value="'.$record[$i]['subject_name'].'" class="form-control td_width" readonly></td><td><input type="number" name="periodic_test[]" class="form-control td_width periodic_test marktoadd text-center" step="0.01" readonly value="'.$record[$i]['periodic_test'].'"></td><td><input type="number" name="maxmarks_theory[]" class="form-control td_width max_marks marktoadd text-center" step="0.01" readonly value="'.$record[$i]['maxmarks_theory'].'"></td><td><input type="number" name="mark_obtained_theory[]" class="form-control td_width mark_obtained_theory marktoadd text-center" step="0.01" value="'.$record[$i]['mark_obtained_theory'].'" readonly></td><td style="display:none;"><input type="number" name="maxmarks_practical[]" class="form-control td_width maxmarks_practical marktoadd text-center" step="0.01" readonly value="'.$record[$i]['maxmarks_practical'].'"></td><td style="display:none;"><input type="number" name="mark_obtained_practical[]" class="form-control td_width mark_obtained_practical marktoadd text-center" step="0.01" value="'.$record[$i]['mark_obtained_practical'].'" readonly></td>';
	                        		
	                        }}}
	                        $remark = $this->Common_Model->FetchData("exam_remark_items as s LEFT JOIN exam_remarks as r ON r.exam_remark_id=s.exam_remark_id ", "*", "s.student_id = ".$rem[$c]['student_id']." AND r.term = '".$res[0]['exam_term']."' AND r.session_id = ".$ssn."");
                      	if($remark){
                      			$html.='
                      					<td><input type="text" class="form-control td_width" name="work_grade[]" value="'.$remark[0]['weg'].'" readonly></td><td><input type="text" class="form-control td_width" name="art_grade[]" value="'.$remark[0]['aeg'].'" readonly></td><td><input type="text" class="form-control td_width" name="physical_grade[]" value="'.$remark[0]['peg'].'" readonly></td><td><input type="text" class="form-control td_width" name="descipline_grade[]" value="'.$remark[0]['dg'].'" readonly></td><td><input type="number" class="form-control td_width" name="t_working_days[]" value="'.$remark[0]['twd'].'" readonly></td><td><input type="number" class="form-control td_width" name="t_attend[]" value="'.$remark[0]['ta'].'" readonly></td><td><input type="text" class="form-control td_width" name="teacher_remark[]" value="'.$remark[0]['remark'].'" readonly></td>
                      			';
                      	}
	                        
                      	
		$html.='</tr>';
	}}
		$html.= '</table>';
		}

	}
         echo $html;
	}


	function getAccessoriesListByClass(){
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$records = $this->Common_Model->FetchPaginationData("class_accessories AS ca LEFT JOIN accessories AS a ON ca.item_id = a.item_id LEFT JOIN classes AS c ON ca.class_id = c.class_id", "c.class_name, a.item_name, ca.id, ca.minqty", "ca.class_id = ".$this->input->post("class_id")." ORDER BY a.item_name ASC");
		?>
		<table id="" class="table table-bordered table-condensed table-striped">
			<tr>
				<th>Item Name</th>
				<th>Minimum Qty</th>
			</tr>
			<?php if($records){ for($i=0;$i<count($records);$i++){?>
			<tr>
				<td><?php echo $records[$i]['item_name'];?></td>
				<td><?php echo $records[$i]['minqty'];?></td>
			</tr>
			<?php }} ?>
		</table>
		<?php
	}

	public function accessories()
	{
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$this->perPage = 20;
		$rows = $this->Common_Model->FetchPaginationRows("accessories", "*", "1 ORDER BY item_id DESC", array());
		$datalist = $this->Common_Model->FetchPaginationData("accessories", "*", "1 ORDER BY item_id DESC", array('limit'=>$this->perPage));
        $config['first_link']  = 'First';
        $config['target']      = '#dataTablediv'; //parent div tag id
        $config['base_url']    = base_url().'index.php/masters/accessories_ajax';
        $config['total_rows']  = $rows;
        $config['per_page']    = $this->perPage;
        $this->ajax_pagination->initialize($config);
		$data['records'] = $datalist;
		$data['sessions'] = $this->Common_Model->FetchData("sessions", "*", "1 ORDER BY session_id DESC");
		$data['classes'] = $this->Common_Model->FetchData("classes", "*", "1 ORDER BY class_name ASC");
		$data['activemenu'] = 'masters';
		$data['activesubmenu'] = 'accessories';
		$this->load->view('masters/accessories', $data);
	}

	function accessories_ajax(){
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$page = $this->input->post('page');
        if(!$page){
            $offset = 0;
        }else{
            $offset = $page;
        }
		$sql = "1";
		$param = array();
		if(isset($_POST['item_name']) && $_POST['item_name'] != ''){
			$sql.= " AND item_name LIKE '%".$_POST['item_name']."%'";
			$param['item_name'] = $_POST['item_name'];
		}

		if(isset($_POST['item_description']) && $_POST['item_description'] != ''){
			$sql.= " AND item_description LIKE '%".$_POST['item_description']."%'";
			$param['item_description'] = $_POST['item_description'];
		}

		$this->perPage = 20;
		$rows = $this->Common_Model->FetchPaginationRows("accessories", "*", "$sql ORDER BY item_id DESC", array());
		$datalist = $this->Common_Model->FetchPaginationData("accessories", "*", "$sql ORDER BY item_id DESC", array('start' => $offset,'limit'=>$this->perPage));
        $config['first_link']  = 'First';
        $config['target']      = '#dataTablediv';
        $config['base_url']    = base_url().'index.php/masters/accessories_ajax';
        $config['total_rows']  = $rows;
        $config['per_page']    = $this->perPage;
        $config['param_ar']	   = $param;
        $this->ajax_pagination->initialize($config);
		$data['records'] = $datalist;
		$this->load->view('masters/accessories_ajax', $data);
	}
    public function set_periodtime($did = 0)
	{
		$data = array();
		$data['did'] = $did;
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		if($this->input->post('submitBtn')){
			$this->form_validation->set_rules('start_time', 'Start Time', 'trim|required');
			$this->form_validation->set_rules('period', 'Period', 'trim|required');
			$this->form_validation->set_rules('end_time', 'End Time', 'trim|required');
			$this->form_validation->set_error_delimiters('<p class="has-error"><label class="control-label">', '</label></p>');
			if($this->form_validation->run()){
				$data_list = array(
					'period'			=> $this->input->post('period'),
					'start_time'		=> $this->input->post('start_time'),
					'end_time'			=> $this->input->post('end_time'),
					'duration'			=> $this->input->post('duration'),
					'type'				=> $this->input->post('type'),
					
				);
				if($did > 0){					
					 $this->Common_Model->update_records('set_periodtime', 'id', $did, $data_list);
					$this->session->set_flashdata('success', ' Update successfully.' );
				redirect('masters/set_periodtime');
				}else{
				
				
				$id = $this->Common_Model->dbinsertid("set_periodtime", $data_list);
				$this->session->set_flashdata('success', ' Added successfully.' );
				redirect('masters/set_periodtime');
			}
			}else{
				$this->session->set_flashdata('error', validation_errors());
			}
		}
		$data['activemenu'] = 'masters';
		$data['activesubmenu'] = 'set_periodtime';
		$data['records'] = $this->Common_Model->FetchData("set_periodtime", "*", "1 ORDER BY id ASC");
		$data['rec'] = $this->Common_Model->FetchData("set_periodtime", "*", "id=".$did."");
		$this->load->view('masters/set_periodtime', $data);
	}
	function deleteperiodtime($id = 0){
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$this->Common_Model->DelData("set_periodtime", "id = ".$id);
		
		$this->session->set_flashdata('success', 'Record deleted successfully.' );
		redirect($_SERVER['HTTP_REFERER']);
	}
	function add_accessories(){
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		if($this->input->post('submitBtn')){
			$this->form_validation->set_rules('item_name', 'Item Name', 'trim|required|is_unique[accessories.item_name]');
			//$this->form_validation->set_rules('item_price', 'Itme Price', 'trim|required');
			$this->form_validation->set_error_delimiters('<p class="has-error"><label class="control-label">', '</label></p>');
			if($this->form_validation->run()){
				$data_list = array(
					'session_id'		=> $this->session->userdata('session_id'),
					'item_name'			=> $this->input->post('item_name'),
					'item_description'	=> $this->input->post('item_description'),
					//'item_price'		=> $this->input->post('item_price'),
					'item_quantity'		=> $this->input->post('item_quantity')
				);
				$id = $this->Common_Model->dbinsertid("accessories", $data_list);
				$this->session->set_flashdata('success', 'Item Added successfully.' );
				redirect('masters/accessories');
			}else{
				$this->session->set_flashdata('error', validation_errors());
				redirect('masters/accessories');
			}
		}
	}

	function edit_accessories($item_id = 0){
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		if($this->input->post('submitBtn')){
			$this->form_validation->set_rules('item_name', 'Item Name', 'trim|required');
			//$this->form_validation->set_rules('item_price', 'Itme Price', 'trim|required');
			$this->form_validation->set_error_delimiters('<p class="has-error"><label class="control-label">', '</label></p>');
			if($this->form_validation->run()){
				$data_list = array(
					'session_id'		=> $this->session->userdata('session_id'),
					'item_name'			=> $this->input->post('item_name'),
					'item_description'	=> $this->input->post('item_description'),
					//'item_price'		=> $this->input->post('item_price'),
					'item_quantity'		=> $this->input->post('item_quantity')
				);
				$id = $this->Common_Model->update_records("accessories", "item_id", $item_id, $data_list);
				$this->session->set_flashdata('success', 'Item Updated successfully.' );
				redirect('masters/accessories');
			}else{
				$this->session->set_flashdata('error', validation_errors());
				redirect('masters/accessories');
			}
		}
		$data['item'] = $this->Common_Model->FetchData("accessories", "*", "item_id = $item_id");
		$data['activemenu'] = 'masters';
		$data['activesubmenu'] = 'accessories';
		$this->load->view('masters/accessories_edit', $data);
	}

	function delete_accessories($item_id = 0){
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$this->Common_Model->DelData("accessories", "item_id = ".$item_id);
		$this->session->set_flashdata('success', 'Record deleted successfully.' );
		redirect($_SERVER['HTTP_REFERER']);
	}

	function class_accessories(){
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		if($this->input->post('submitBtn')){
			$this->form_validation->set_rules('class_id', 'Class', 'trim|required');
			$this->form_validation->set_rules('item_id', 'Item Name', 'trim|required');
			$this->form_validation->set_error_delimiters('<p class="has-error"><label class="control-label">', '</label></p>');
			if($this->form_validation->run()){
				$rec = $this->Common_Model->FetchData("class_accessories", "*", "item_id = ". $this->input->post('item_id')." AND class_id = ".$this->input->post('class_id'));
				if($rec){
					$this->Common_Model->db_query("UPDATE class_accessories SET minqty = ".$this->input->post('minqty'). " WHERE item_id = ". $this->input->post('item_id')." AND class_id = ".$this->input->post('class_id'));
					$this->session->set_flashdata('success', 'Item quantity updated successfully for class.' );
				}else{
					$data_list = array(
						'class_id'	=> $this->input->post('class_id'),
						'item_id'	=> $this->input->post('item_id'),
						'minqty'	=> $this->input->post('minqty')
					);
					$id = $this->Common_Model->dbinsertid("class_accessories", $data_list);
					$this->session->set_flashdata('success', 'Item quantity added successfully for class.' );
				}
				redirect('masters/class_accessories');
			}else{
				$this->session->set_flashdata('error', validation_errors());
				redirect('masters/class_accessories');
			}
		}
		$data['per_page'] = $per_page = isset($_REQUEST['per_page']) ? $_REQUEST['per_page'] : 10;
		$data['page'] = $page = isset($_REQUEST['page']) ? $_REQUEST['page'] : '1';
		$this->load->helper('url');
		$currentURL = current_url();
		$sql = "1";
		$urlvars = '';
		if(isset($_REQUEST['class_id']) && $_REQUEST['class_id'] != ''){
			$sql.= " AND ca.class_id = '".$_REQUEST['class_id']."'";
			$urlvars.= "&class_id=".$_REQUEST['class_id'];
		}

		if(isset($_REQUEST['item_id']) && $_REQUEST['item_id'] != ''){
			$sql.= " AND ca.item_id = '".$_REQUEST['item_id']."'";
			$urlvars.= "&item_id=".$_REQUEST['item_id'];
		}
		$rows = $this->Common_Model->FetchRows("class_accessories AS ca LEFT JOIN accessories AS a ON ca.item_id = a.item_id LEFT JOIN classes AS c ON ca.class_id = c.class_id", "c.class_name, a.item_name, ca.id, ca.minqty, ca.is_required", "$sql ORDER BY c.class_name, a.item_name ASC");
        $this->load->library("Paginator");
		$this->paginator->setparam(array("page_num" => $page, "num_rows" => $rows));
		$this->paginator->set_Limit($per_page);

		$range1 = $this->paginator->getRange1();
		$range2 = $this->paginator->getRange2();

		$records = $this->Common_Model->db_query("SELECT c.class_name, a.item_name, ca.id, ca.minqty, ca.is_required FROM class_accessories AS ca LEFT JOIN accessories AS a ON ca.item_id = a.item_id LEFT JOIN classes AS c ON ca.class_id = c.class_id WHERE $sql ORDER BY c.class_name, a.item_name ASC LIMIT ".$range1.', '.$range2);
		$queryvars = "per_page=$per_page".$urlvars;
		$paging_info = $this->paginator->DBPagingNav($queryvars, $currentURL);
		$aData['tot_page'] = $paging_info[0];
		$aData['pages'] = $paging_info[1];
		$data['sPages'] = $aData['pages'];
		$data['records'] = $records;

		$data['items'] = $this->Common_Model->FetchData("accessories", "*", "1 ORDER BY item_id DESC");
		$data['classes'] = $this->Common_Model->FetchData("classes", "*", "1 ORDER BY class_name ASC");
		$data['activemenu'] = 'masters';
		$data['activesubmenu'] = 'class-accessories';
		$this->load->view('masters/accessories_class', $data);
	}

	function delete_class_accessories($id = 0){
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$this->Common_Model->DelData("class_accessories", "id = ".$id);
		$this->session->set_flashdata('success', 'Record deleted successfully.' );
		redirect($_SERVER['HTTP_REFERER']);
	}

	function change_class_accessories_req(){
		$this->Common_Model->db_query("UPDATE class_accessories SET is_required = ".$this->input->post('v'). " WHERE id = ". $this->input->post('id'));
		echo "UPDATE class_accessories SET is_required = ".$this->input->post('v'). " WHERE id = ". $this->input->post('id');
		exit;
	}

	function settings(){
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		if($this->input->post('submitBtn')){
			$data_list = $this->input->post("settings");
			foreach($data_list as $key => $val){
				$this->Common_Model->update_records("settings", "setting_name", $key, array("setting_value" => addslashes($val)));
			}
			$this->session->set_flashdata('success', 'Settings updated successfully.' );
			redirect("masters/settings");
		}
		$data['activemenu'] = 'settings';
		$data['activesubmenu'] = 'settings';
		$data['records'] = $this->Common_Model->FetchData("settings", "*", "");
		$this->load->view('masters/settings', $data);
	}

	public function expense_types(){
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		if($this->input->post('submitBtn')){
			$this->form_validation->set_rules('expense_name', 'Expense Name', 'trim|required|is_unique[expense_types.expense_name]');
			$this->form_validation->set_error_delimiters('<p class="has-error"><label class="control-label">', '</label></p>');
			if($this->form_validation->run()){
				$data_list = array(
					'expense_name'			=> $this->input->post('expense_name'),
				);

				if($_FILES['expense_icon']['name']!=""){
					$newfile = date('Ymd His').uniqid();
					$config = array(
						'upload_path' => "uploads/expenseimg/",
						'allowed_types' => 'jpg|png|jpeg',
						'overwrite' => TRUE,
						'file_name' => $newfile,
						'max_size' => "200048000" 
					);

					$this->load->library('upload', $config);
					$this->upload->initialize($config);
					if($this->upload->do_upload("expense_icon"))
					{
						$dat = $this->upload->data();
						$data_list['expense_icon'] = $dat['file_name'];
							$this->load->library('image_lib');
			                $config['image_library'] = 'gd2'; // Set your preferred image processing library
					        $config['source_image'] = $dat['full_path'];
					        $config['create_thumb'] = FALSE; // Create a thumbnail version
					        $config['maintain_ratio'] = TRUE;
					        $config['width'] = 50; // Set the width you desire for the thumbnail
					        $config['height'] = 50; // Set the height you desire for the thumbnail
					        $config['quality'] = 80; 
					        $config['new_image']  = 'uploads/expenseicon/' . $dat['file_name'];
					        $this->image_lib->initialize($config);
					        $this->image_lib->resize();
							$this->image_lib->clear();
					}else{
						$filename = '';
						$this->session->set_flashdata('error', $this->upload->display_errors());
						redirect($_SERVER['HTTP_REFERER']);
					}
				}else{ $data_list['expense_icon'] = '';}


				$id = $this->Common_Model->dbinsertid("expense_types", $data_list);
				$this->session->set_flashdata('success', 'Expense Type Added successfully.' );
				redirect('masters/expense_types');
			}else{
				$this->session->set_flashdata('error', validation_errors());
			}
		}
		$data['activemenu'] = 'masters';
		$data['activesubmenu'] = 'expense_types';
		$data['records'] = $this->Common_Model->FetchData("expense_types", "*", "1 ORDER BY expense_name ASC");
		$this->load->view('masters/expense_types', $data);
	}
	
	public function editexpensetypes($id=0){
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		if($this->input->post('submitBtn')){
			$this->form_validation->set_rules('expense_name', 'Expense Name', 'trim|required');
			$this->form_validation->set_error_delimiters('<p class="has-error"><label class="control-label">', '</label></p>');
			if($this->form_validation->run()){
				$data_list = array(
					'expense_name'			=> $this->input->post('expense_name'),
				);

				if($_FILES['expense_icon']['name']!=""){
					$newfile = date('Ymd His').uniqid();
					$config = array(
						'upload_path' => "uploads/expenseimg/",
						'allowed_types' => 'jpg|png|jpeg',
						'overwrite' => TRUE,
						'file_name' => $newfile,
						'max_size' => "200048000" 
					);

					$this->load->library('upload', $config);
					$this->upload->initialize($config);
					if($this->upload->do_upload("expense_icon"))
					{
						$dat = $this->upload->data();
						$data_list['expense_icon'] = $dat['file_name'];
							$this->load->library('image_lib');
			                $config['image_library'] = 'gd2'; // Set your preferred image processing library
					        $config['source_image'] = $dat['full_path'];
					        $config['create_thumb'] = FALSE; // Create a thumbnail version
					        $config['maintain_ratio'] = TRUE;
					        $config['width'] = 50; // Set the width you desire for the thumbnail
					        $config['height'] = 50; // Set the height you desire for the thumbnail
					        $config['quality'] = 80; 
					        $config['new_image']  = 'uploads/expenseicon/' . $dat['file_name'];
					        $this->image_lib->initialize($config);
					        $this->image_lib->resize();
							$this->image_lib->clear();
					}else{
						$filename = '';
						$this->session->set_flashdata('error', $this->upload->display_errors());
						redirect($_SERVER['HTTP_REFERER']);
					}
				}else{ }
				
				


				$this->Common_Model->update_records("expense_types","id", $id, $data_list);
				$this->session->set_flashdata('success', 'Expense Type Updated successfully.' );
				redirect('masters/expense_types');
			}else{
				$this->session->set_flashdata('error', validation_errors());
			}
		}
		$data['activemenu'] = 'masters';
		$data['activesubmenu'] = 'expense_types';
		$data['rec'] = $this->Common_Model->FetchData("expense_types", "*", "id=".$id."");
		$this->load->view('masters/editexpensetypes', $data);
	}

	public function expense_subtypes(){
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));


		if($this->input->post('submitBtn')){
			$this->form_validation->set_rules('expense_name', 'Expense Name', 'trim|required|is_unique[expense_types.expense_name]');
			$this->form_validation->set_error_delimiters('<p class="has-error"><label class="control-label">', '</label></p>');
			if($this->form_validation->run()){
				$data_list = array(
					'expense_type_id'			=> $this->input->post('expense_type_id'),
					'expense_subtypename'		=> $this->input->post('expense_name'),
					'entry_type'		=> $this->input->post('entry_type'),
				);

				if($_FILES['expense_subtypeicon']['name']!=""){
					$newfile = 'STE_'.date('Ymd His').uniqid();
					$config = array(
						'upload_path' => "uploads/expenseimg/",
						'allowed_types' => 'jpg|png|jpeg',
						'overwrite' => TRUE,
						'file_name' => $newfile,
						'max_size' => "200048000" 
					);

					$this->load->library('upload', $config);
					$this->upload->initialize($config);
					if($this->upload->do_upload("expense_subtypeicon"))
					{
						$dat = $this->upload->data();
						$data_list['expense_subtypeicon'] = $dat['file_name'];
							$this->load->library('image_lib');
			                $config['image_library'] = 'gd2'; // Set your preferred image processing library
					        $config['source_image'] = $dat['full_path'];
					        $config['create_thumb'] = FALSE; // Create a thumbnail version
					        $config['maintain_ratio'] = TRUE;
					        $config['width'] = 50; // Set the width you desire for the thumbnail
					        $config['height'] = 50; // Set the height you desire for the thumbnail
					        $config['quality'] = 80; 
					        $config['new_image']  = 'uploads/expenseicon/' . $dat['file_name'];
					        $this->image_lib->initialize($config);
					        $this->image_lib->resize();
							$this->image_lib->clear();
					}else{
						$filename = '';
						$this->session->set_flashdata('error', $this->upload->display_errors());
						redirect($_SERVER['HTTP_REFERER']);
					}
				}else{ $data_list['expense_subtypeicon'] = '';}


				$id = $this->Common_Model->dbinsertid("expense_subtypes", $data_list);
				$this->session->set_flashdata('success', 'Expense Sub Type Added successfully.' );
				redirect('masters/expense_subtypes');
			}else{
				$this->session->set_flashdata('error', validation_errors());
			}
		}

  		$data['activemenu'] = 'masters';
		$data['activesubmenu'] = 'expense_subtypes';
		$data['records'] = $this->Common_Model->FetchData("expense_subtypes as a LEFT JOIN expense_types as b on a.expense_type_id=b.id", "*", "1 ORDER BY expense_subtypename ASC");
		$data['exprec'] = $this->Common_Model->FetchData("expense_types", "*", "1 ORDER BY expense_name ASC");
		$this->load->view('masters/expense_subtypes', $data);
  	}

  	public function editexpensesubtype($expense_subtypes_id=0){
  		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));


		if($this->input->post('submitBtn')){
			$this->form_validation->set_rules('expense_name', 'Expense Sub Name', 'trim|required');
			$this->form_validation->set_error_delimiters('<p class="has-error"><label class="control-label">', '</label></p>');
			if($this->form_validation->run()){
				$data_list = array(
					'expense_type_id'			=> $this->input->post('expense_type_id'),
					'expense_subtypename'		=> $this->input->post('expense_name'),
					'entry_type'				=> $this->input->post('entry_type'),
				);

				if($_FILES['expense_subtypeicon']['name']!=""){
					$newfile = 'STE_'.date('Ymd His').uniqid();
					$config = array(
						'upload_path' => "uploads/expenseimg/",
						'allowed_types' => 'jpg|png|jpeg',
						'overwrite' => TRUE,
						'file_name' => $newfile,
						'max_size' => "200048000" 
					);

					$this->load->library('upload', $config);
					$this->upload->initialize($config);
					if($this->upload->do_upload("expense_subtypeicon"))
					{
						$dat = $this->upload->data();
						$data_list['expense_subtypeicon'] = $dat['file_name'];
							$this->load->library('image_lib');
			                $config['image_library'] = 'gd2'; // Set your preferred image processing library
					        $config['source_image'] = $dat['full_path'];
					        $config['create_thumb'] = FALSE; // Create a thumbnail version
					        $config['maintain_ratio'] = TRUE;
					        $config['width'] = 50; // Set the width you desire for the thumbnail
					        $config['height'] = 50; // Set the height you desire for the thumbnail
					        $config['quality'] = 80; 
					        $config['new_image']  = 'uploads/expenseicon/' . $dat['file_name'];
					        $this->image_lib->initialize($config);
					        $this->image_lib->resize();
							$this->image_lib->clear();
					}else{
						$filename = '';
						$this->session->set_flashdata('error', $this->upload->display_errors());
						redirect($_SERVER['HTTP_REFERER']);
					}
				}else{ }


				$id = $this->Common_Model->update_records("expense_subtypes","expense_subtypes_id",$expense_subtypes_id, $data_list);
				
				$limitation_rec = $this->Common_Model->FetchData("expense_limitation","*","expense_type_id=".$this->input->post('expense_type_id')." AND expense_subtypes_id=".$expense_subtypes_id."");
				if ($limitation_rec) {
					$this->Common_Model->DelData("expense_limitation","expense_type_id=".$this->input->post('expense_type_id')." AND expense_subtypes_id=".$expense_subtypes_id."");
				}

				foreach ($this->input->post('designation_id[]') as $key => $value) {
						$designation_id=$this->input->post("designation_id[".$key."]");
						$limit_items = array(
							'expense_type_id' 	  => $this->input->post('expense_type_id'), 
							'expense_subtypes_id' => $expense_subtypes_id, 
							'designation' 		=> $designation_id, 
							'limitamt' 			=> $this->input->post("limitamt[".$key."]"), 
						);
						
						$this->Common_Model->dbinsertid("expense_limitation",$limit_items);

					}
				
				$this->session->set_flashdata('success', 'Expense Sub Type Updated successfully.' );
				redirect('masters/expense_subtypes');
			}else{
				$this->session->set_flashdata('error', validation_errors());
			}
		}

  		$data['activemenu'] = 'masters';
		$data['activesubmenu'] = 'expense_subtypes';
		$data['rec'] = $this->Common_Model->FetchData("expense_subtypes", "*", "expense_subtypes_id=".$expense_subtypes_id);
		$data['exprec'] = $this->Common_Model->FetchData("expense_types", "*", "1 ORDER BY expense_name ASC");
		$data['designation'] = $this->Common_Model->FetchData("designation as a LEFT JOIN department as b on a.department_id=b.did", "*", "1 ORDER BY designation_name ASC");
		$this->load->view('masters/editexpensesubtype', $data);
  	}
  	
  	function deleteexpensesubtypes($expense_subtypes_id = 0){
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$this->Common_Model->DelData("expense_subtypes", "expense_subtypes_id = ".$expense_subtypes_id);
		$this->session->set_flashdata('success', 'Record deleted successfully.' );
		redirect($_SERVER['HTTP_REFERER']);
	}

	function deleteexpensetypes($id = 0){
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$this->Common_Model->DelData("expense_types", "id = ".$id);
		$this->session->set_flashdata('success', 'Record deleted successfully.' );
		redirect($_SERVER['HTTP_REFERER']);
	}

	function getSubjectsListByClass9(){
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$teacher_id = $this->session->userdata('employee_tagged_id');
		//print_r($this->session->userdata('employee_id'));exit;
		$section =  $this->input->post("section");
		$class_id =  $this->input->post("class_id");
		$rec = $this->Common_Model->FetchData("teacher_class_subject_tag", "*", "class_id = ".$class_id." AND section_id =".$section." AND teacher_id =".$teacher_id."");
		
		$html = '<option value="">select</option>';
		if($rec){ for($i=0;$i<count($rec);$i++){
				$records = $this->Common_Model->FetchData("subjects", "*", "subject_id = ".$rec[$i]['subject_id']." AND subject_no !='100'");
				if($records[0]['subject_id']){
			$html.= '<option value="'.$records[0]['subject_id'].'">'.$records[0]['subject_name'].'</option>';
		}
		}}
		echo $html;
	}

	function getSubjectsListByClass(){
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$records = $this->Common_Model->FetchData("subjects", "*", "class_id = ".$this->input->post("class_id")." AND subject_no !='100'");
		$html = '<option value="">select</option>';
		if($records){ for($i=0;$i<count($records);$i++){
			$html.= '<option value="'.$records[$i]['subject_id'].'">'.$records[$i]['subject_name'].'</option>';
		}}
		echo $html;
	}
	function getSubjectsListByClassdwn(){
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$records = $this->Common_Model->FetchData("subjects", "*", "class_id = ".$this->input->post("class_id")." AND subject_no !='100'");
		$html = '<option value="5001">All Subjects</option>';
		if($records){ for($i=0;$i<count($records);$i++){
			$html.= '<option value="'.$records[$i]['subject_id'].'">'.$records[$i]['subject_name'].'</option>';
		}}
		echo $html;
	}
	function getSubjectsListByClassforhidestudent(){
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$class_id = $this->input->post("class_id");
		$records = $this->Common_Model->FetchData("subjects", "*", "class_id = ".$this->input->post("class_id"));
		$html = '<option value="">select</option>';
		if($records){ for($i=0;$i<count($records);$i++){
			$html.= '<option value="'.$records[$i]['subject_id'].'">'.$records[$i]['subject_name'].'</option>';
		}
		
	}
		echo $html;
	}

	function getStudentDataById(){
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$records = $this->Common_Model->FetchData("students", "*", "student_id = ".$this->input->post("student_id"));
		if($records){ 
			echo json_encode($records[0]);
		}else{

		}
	}

	function notices(){
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$data['per_page'] = $per_page = isset($_REQUEST['per_page']) ? $_REQUEST['per_page'] : 10;
		$data['page'] = $page = isset($_REQUEST['page']) ? $_REQUEST['page'] : '1';
		$this->load->helper('url');
		$currentURL = current_url();
		$sql = "1";
		
		$urlvars = '';
		
		if(isset($_REQUEST['notice_no']) && $_REQUEST['notice_no'] != ''){
			$sql.= " AND notice_no = '".$_REQUEST['notice_no']."'";
			$urlvars.= "&notice_no=".$_REQUEST['notice_no'];
		}

		if(isset($_REQUEST['notice_title']) && $_REQUEST['notice_title'] != ''){
			$sql.= " AND notice_title LIKE '%".$_REQUEST['notice_title']."%'";
			$urlvars.= "&notice_title=".$_REQUEST['notice_title'];
		}

		if(isset($_REQUEST['created_on_from']) && $_REQUEST['created_on_from'] != ''){
			$sql.= " AND create_on >= '".$_REQUEST['created_on_from']."'";
			$urlvars.= "&created_on_from=".$_REQUEST['created_on_from'];
		}

		if(isset($_REQUEST['created_on_to']) && $_REQUEST['created_on_to'] != ''){
			$sql.= " AND create_on <= '".$_REQUEST['created_on_to']."'";
			$urlvars.= "&created_on_to=".$_REQUEST['created_on_to'];
		}


		$sSql = "SELECT COUNT(*) as num FROM notices WHERE $sql";
		$records = $this->Common_Model->db_query($sSql);
		$totalrecords = $records[0]['num'];
		if($totalrecords){
			$sSql = "SELECT * FROM notices WHERE $sql ORDER BY created_on DESC";
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
		$data['activemenu'] = 'notices';
		$data['activesubmenu'] = 'notices';
		$this->load->view('masters/notices', $data);
	}

	function add_notices(){
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		if($this->input->post('submitBtn')){
			$this->form_validation->set_rules('notice_title', 'Notice Title', 'trim|required');
			$this->form_validation->set_rules('notice_no', 'Notice Number', 'trim|required|is_unique[notices.notice_no]');
			$this->form_validation->set_error_delimiters('<p class="has-error"><label class="control-label">', '</label></p>');
			if($this->form_validation->run()){
				$data_list = array(
					'notice_title'		=> addslashes($this->input->post('notice_title')),
					'notice_description'=> addslashes(nl2br($this->input->post('notice_description'))),
					'notice_attachments'=> '',
					'created_on'		=> date('Y-m-d H:i:s'),
					'notice_end_date'	=> $this->input->post('notice_end_date'),
					'notice_no'			=> addslashes($this->input->post('notice_no')),
					'class_ids'			=> implode(' ', $this->input->post('class_ids[]')),
					'sms_text'			=> addslashes($this->input->post('sms_text')),
				);
			
				if($_FILES['notice_file']['name']!=""){
						$newfile = preg_replace('/\W+/', '-', strtolower($_FILES['notice_file']['name'])).uniqid();
						$config = array(
							'upload_path' => "uploads/studentdata/",
							'allowed_types' => 'pdf|doc|docx|jpg|png|jpeg',
							'overwrite' => TRUE,
							'file_name' => $newfile,
							'max_size' => "200048000" 
						);

						$this->load->library('upload', $config);
						$this->upload->initialize($config);
						if($this->upload->do_upload("notice_file"))
						{
							$dat = $this->upload->data();
							$data_list['notice_file'] = $dat['file_name'];
						}else{
							$filename = '';
							$this->session->set_flashdata('error', $this->upload->display_errors());
							redirect($_SERVER['HTTP_REFERER']);
						}
					}else{ $data_list['notice_file'] = '';}
	
				$id = $this->Common_Model->dbinsertid("notices", $data_list);
				$this->session->set_flashdata('success', 'Notice added successfully.' );
				if($this->input->post('send_sms') != '' && $this->input->post('sms_text') != '' && !empty($this->input->post('class_ids[]'))){
					$classids = implode(',', $this->input->post('class_ids[]'));
					$students = $this->Common_Model->FetchData("students", "student_mobile", "student_class IN ($classids)");
					if($students){
						for($i = 0; $i < count($students); $i++){
							//file_get_contents('http://137.59.52.74/api/mt/SendSMS?user=YOUNGPHOENIX&password=123456&senderid=YPPSKL&channel=Trans&DCS=0&flashsms=0&number='.$students[$i]['student_mobile'].'&text='.urlencode($this->input->post("sms_text")).'&route=1');
						}
					}
				}
				redirect('masters/notices');
			}else{
				$this->session->set_flashdata('error', validation_errors());
			}
		}
		$data['activemenu'] = 'notices';
		$data['activesubmenu'] = 'add_notices';
		$data['classes'] = $this->Common_Model->FetchData("classes", "*", "1 ORDER BY class_name ASC");
		$data['ntc'] = $this->Common_Model->FetchData("notices", "*", "1 ORDER BY notice_id DESC");
		$this->load->view('masters/add_notices', $data);
	}

	function edit_notice($notice_id = 0){
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$data['notice']	= $notice = $this->Common_Model->FetchData("notices", "*", "notice_id = ".$notice_id);
		if($this->input->post('submitBtn')){
			$this->form_validation->set_rules('notice_title', 'Notice Title', 'trim|required');
			$this->form_validation->set_rules('notice_no', 'Notice Number', 'trim|required');
			$this->form_validation->set_error_delimiters('<p class="has-error"><label class="control-label">', '</label></p>');
			if($this->form_validation->run()){
				$data_list = array(
					'notice_title'		=> addslashes($this->input->post('notice_title')),
					'notice_description'=> addslashes(nl2br($this->input->post('notice_description'))),
					'notice_attachments'=> '',
					'created_on'		=> date('Y-m-d H:i:s'),
					'notice_end_date'	=> $this->input->post('notice_end_date'),
					'notice_no'			=> addslashes($this->input->post('notice_no')),
					'class_ids'			=> implode(' ', $this->input->post('class_ids[]')),
					'sms_text'			=> addslashes($this->input->post('sms_text')),
				);

				if($_FILES['notice_file']['name']!=""){
						$newfile = preg_replace('/\W+/', '-', strtolower($_FILES['notice_file']['name'])).uniqid();
						$config = array(
							'upload_path' => "uploads/studentdata/",
							'allowed_types' => 'pdf|doc|docx|jpg|png|jpeg',
							'overwrite' => TRUE,
							'file_name' => $newfile,
							'max_size' => "200048000" 
						);

						$this->load->library('upload', $config);
						$this->upload->initialize($config);
						if($this->upload->do_upload("notice_file"))
						{
							$dat = $this->upload->data();
							$data_list['notice_file'] = $dat['file_name'];
						}else{
							$filename = '';
							$this->session->set_flashdata('error', $this->upload->display_errors());
							redirect($_SERVER['HTTP_REFERER']);
						}
					}else{ $data_list['notice_file'] = $notice[0]['notice_file'];}

				$this->Common_Model->update_records("notices", "notice_id", $notice_id, $data_list);
				$this->session->set_flashdata('success', 'Notice updated successfully.' );
				if($this->input->post('send_sms') != '' && $this->input->post('sms_text') != '' && !empty($this->input->post('class_ids[]'))){
					$classids = implode(',', $this->input->post('class_ids[]'));
					$students = $this->Common_Model->FetchData("students", "student_mobile", "student_class IN ($classids)");
					if($students){
						for($i = 0; $i < count($students); $i++){
							//file_get_contents('http://137.59.52.74/api/mt/SendSMS?user=YOUNGPHOENIX&password=123456&senderid=YPPSKL&channel=Trans&DCS=0&flashsms=0&number='.$students[$i]['student_mobile'].'&text='.urlencode($this->input->post("sms_text")).'&route=1');
						}
					}
				}
				redirect('masters/notices');
			}else{
				$this->session->set_flashdata('error', validation_errors());
			}
		}
		$data['activemenu'] = 'notices';
		$data['activesubmenu'] = 'notices';
		
		$data['classes'] = $this->Common_Model->FetchData("classes", "*", "1 ORDER BY class_name ASC");
		$this->load->view('masters/edit_notice', $data);
	}

	function view_notice($notice_id = 0){
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$data['notice'] = $this->Common_Model->FetchData("notices", "*", "notice_id = ".$notice_id);
		error_reporting(0);
		ini_set('display_error', -1);
		$html = $this->load->view('masters/view_notice', $data, TRUE);
		$this->load->library('Notices');
		$pdf = new Notices(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('O.P.JINDAL');
		$pdf->SetTitle('Notice');
		$pdf->SetSubject('Notice');
		$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
		$pdf->setHeaderData($ln='', $lw=0, $ht='', $hs='<table width="100%">		<tr>			<td width="20%"><img src="'.base_url().'assets/img/phoenixlogo.png" alt="O.P.JINDAL" width="100"></td>			<td width="80%">			<h1 align="center" style="font-size: 30px; font-weight: bold;">O.P.JINDAL SCHOOL</h1>			<p align="center" width="100%">			Affiliated to CBSE, New Delhi<br/>			DAY - CUM - RESIDENCIAL<br/>			Gopinathpur, Bhubaneswar - 2, Ph. No.(0674) 2343851, Mob. : 8658599505</p>			</td>		</tr>	</table>', $tc=array(0,0,0), $lc=array(0,0,0));
		$pdf->SetMargins(5, 5, 5, true);
		$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
		$pdf->SetAutoPageBreak(TRUE, 17);
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
		$pdf->AddPage('P', 'A4', true, true);
		$pdf->SetMargins(5, 25, 5, true);
		$pdf->SetFont('helvetica', '', 8);
		$pdf->setFontSubsetting(false);
		$pdf->writeHTML($html, true, false, false, false, '');
		date_default_timezone_set("Asia/Kolkata");
		$filename = date("YmdHis").'.pdf';
		$pdf->Output($filename, 'I');
	}

	function delete_notice($notice_id = 0){
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$this->Common_Model->DelData("notices", "notice_id = ".$notice_id);
		$this->session->set_flashdata('success', 'Record deleted successfully.' );
		redirect($_SERVER['HTTP_REFERER']);
	}

	function vehicles(){
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$data['per_page'] = $per_page = isset($_REQUEST['per_page']) ? $_REQUEST['per_page'] : 20;
		$data['page'] = $page = isset($_REQUEST['page']) ? $_REQUEST['page'] : '1';
		$this->load->helper('url');
		$currentURL = current_url();
		$sql = "1";
		
		$urlvars = '';
		

		if(isset($_REQUEST['registration_no']) && $_REQUEST['registration_no'] != ''){
			$sql.= " AND registration_no LIKE '%".$_REQUEST['registration_no']."%'";
			$urlvars.= "&registration_no=".$_REQUEST['registration_no'];
		}

		$sSql = "SELECT COUNT(*) as num FROM vehicles WHERE $sql";
		$records = $this->Common_Model->db_query($sSql);
		$totalrecords = $records[0]['num'];
		if($totalrecords){
			$sSql = "SELECT * FROM vehicles WHERE $sql ORDER BY vehicle_id DESC";
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
		$data['activemenu'] = 'vehicles';
		$data['activesubmenu'] = 'vehicles';
		$this->load->view('masters/vehicles', $data);
	}

	function add_vehicles(){
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		if($this->input->post('submitBtn')){
			$this->form_validation->set_rules('registration_no', 'Registration No', 'trim|required|is_unique[vehicles.registration_no]');
			$this->form_validation->set_error_delimiters('<p class="has-error"><label class="control-label">', '</label></p>');
			if($this->form_validation->run()){
				$data_list = array(
					'registration_no'		=> addslashes($this->input->post('registration_no')),
					'description'			=> addslashes($this->input->post('description')),
					'fitness_valid_from'	=> $this->input->post('fitness_valid_from'),
					'fitness_valid_to'		=> $this->input->post('fitness_valid_to'),
					'pollution_valid_from'	=> $this->input->post('pollution_valid_from'),
					'pollution_valid_to'	=> $this->input->post('pollution_valid_to'),
					'tax_valid_from'		=> $this->input->post('tax_valid_from'),
					'tax_valid_to'			=> $this->input->post('tax_valid_to'),
					'permit_valid_from'		=> $this->input->post('permit_valid_from'),
					'permit_valid_to'		=> $this->input->post('permit_valid_to'),
					'insurance_valid_from'	=> $this->input->post('insurance_valid_from'),
					'insurance_valid_to'	=> $this->input->post('insurance_valid_to'),
					'insurance_company'		=> $this->input->post('insurance_company'),
					'insurance_amount'		=> $this->input->post('insurance_amount'),
					'conductor_id'			=> $this->input->post('conductor_id')
				);
				$id = $this->Common_Model->dbinsertid("vehicles", $data_list);
				$this->session->set_flashdata('success', 'Vehicle added successfully.' );
				
				redirect('masters/vehicles');
			}else{
				$this->session->set_flashdata('error', validation_errors());
			}
		}
		$data['activemenu'] = 'vehicles';
		$data['activesubmenu'] = 'add_vehicles';
		$data['conductor_data']   = $this->Common_Model->FetchData("users", "user_id,firstname,lastname", "usertype = 'Conductor' AND userstatus = 1");
		$this->load->view('masters/add_vehicles', $data);
	}

	function delete_vehicles($vehicle_id = 0){
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$this->Common_Model->DelData("vehicles", "vehicle_id = ".$vehicle_id);
		$this->session->set_flashdata('success', 'Record deleted successfully.' );
		redirect($_SERVER['HTTP_REFERER']);
	}

	function edit_vehicles($vehicle_id = 0){
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		if($this->input->post('submitBtn')){
			$this->form_validation->set_rules('registration_no', 'Registration No', 'trim|required');
			$this->form_validation->set_error_delimiters('<p class="has-error"><label class="control-label">', '</label></p>');
			if($this->form_validation->run()){
				$data_list = array(
					'registration_no'		=> addslashes($this->input->post('registration_no')),
					'description'			=> addslashes($this->input->post('description')),
					'fitness_valid_from'	=> $this->input->post('fitness_valid_from'),
					'fitness_valid_to'		=> $this->input->post('fitness_valid_to'),
					'pollution_valid_from'	=> $this->input->post('pollution_valid_from'),
					'pollution_valid_to'	=> $this->input->post('pollution_valid_to'),
					'tax_valid_from'		=> $this->input->post('tax_valid_from'),
					'tax_valid_to'			=> $this->input->post('tax_valid_to'),
					'permit_valid_from'		=> $this->input->post('permit_valid_from'),
					'permit_valid_to'		=> $this->input->post('permit_valid_to'),
					'insurance_valid_from'	=> $this->input->post('insurance_valid_from'),
					'insurance_valid_to'	=> $this->input->post('insurance_valid_to'),
					'insurance_company'		=> $this->input->post('insurance_company'),
					'insurance_amount'		=> $this->input->post('insurance_amount'),
					'conductor_id'			=> $this->input->post('conductor_id')
				);
				$id = $this->Common_Model->update_records("vehicles", "vehicle_id", $vehicle_id, $data_list);
				$this->session->set_flashdata('success', 'Vehicle updated successfully.' );
				
				redirect('masters/vehicles');
			}else{
				$this->session->set_flashdata('error', validation_errors());
			}
		}
		$data['activemenu'] = 'vehicles';
		$data['activesubmenu'] = 'add_vehicles';
		$data['vehicle']	= $this->Common_Model->FetchData("vehicles", "*", "vehicle_id = ".$vehicle_id);
		$data['conductor_data']   = $this->Common_Model->FetchData("users", "user_id,firstname,lastname", "usertype = 'Conductor' AND userstatus = 1");
		$this->load->view('masters/edit_vehicles', $data);
	}

	function add_vehicle_repair_log(){
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		if($this->input->post('submitBtn')){
			$this->form_validation->set_rules('registration_no', 'Registration No', 'trim|required');
			$this->form_validation->set_error_delimiters('<p class="has-error"><label class="control-label">', '</label></p>');
			if($this->form_validation->run()){
				$data_list = array(
					'vehicle_id'			=> addslashes($this->input->post('registration_no')),
					'repair_work'			=> addslashes($this->input->post('repair_work')),
					'repair_date'			=> $this->input->post('repair_date'),
					'garage_name'			=> $this->input->post('garage_name'),
					'repair_amount'			=> $this->input->post('repair_amount'),
					'created_by'			=> $this->session->userdata('user_id'),
					'created_on'			=> date('Y-m-d H:i:s')
				);
				$this->Common_Model->dbinsertid("vehicles_repair_log", $data_list);
				$totalpaid = $this->input->post('repair_amount');
				if($this->input->post('addvoucher') == 'Yes'){
				$payment_mode 	= $this->input->post("payment_mode");
				$remarks 		= addslashes($this->input->post("remarks"));
				$bankdata = $this->Common_Model->FetchData("banks", "*", "bank_id = '".$this->input->post('bank_id')."'");
				$datalist = array(
					"payment_date"		=> date('Y-m-d'),
					"amount" 			=> $totalpaid,
					"payment_mode" 		=> $payment_mode,
					"purpose" 			=> 'Expense',
					"created_on" 		=> date("Y-m-d H:i:s"),
					"created_by" 		=> $this->session->userdata("user_id"),
					"remarks" 			=> $remarks,
					"employee_id" 		=> 0,
					"expense_type" 		=> $this->input->post("expense_type"),
					"mobile"			=> '',
					"bank_id"			=> $this->input->post("bank_id"),
					"cheque_no"			=> $payment_mode != 'Cash' ? $this->input->post('cheque_no') : '',
					"bank_name"			=> $payment_mode != 'Cash' ? $this->input->post('bank_name') : '',
					"bank_branch"		=> $payment_mode != 'Cash' ? $this->input->post('bank_branch') : ''
				);
				$voucher_id = $this->Common_Model->dbinsertid("vouchers", $datalist);
				$voucher_no = date('Ymd').str_pad($voucher_id, 6, '0', STR_PAD_LEFT);
				$this->Common_Model->db_query("UPDATE vouchers SET voucher_no = '".$voucher_no."' WHERE voucher_id = ".$voucher_id);
				if($payment_mode == 'Cash'){
					$cash = $this->Common_Model->FetchData("cash_log", "*", "1 ORDER BY id DESC LIMIT 1");
					if($cash){
						$balance = $cash[0]['cash_balance'] - $totalpaid;
					}else{
						$balance = 0;
					}
					$datalist1 = array(
									"mode"				=> 'Debit',
									"amount" 			=> $totalpaid,
									"cash_balance"		=> $balance,
									"date" 				=> date("Y-m-d"),
									"created_by" 		=> $this->session->userdata("user_id"),
									"remarks" 			=> $remarks,
									"receipt_id" 		=> 0,
									"voucher_id" 		=> $voucher_id
								);
					$this->Common_Model->dbinsertid("cash_log", $datalist1);
				}
				if($payment_mode == 'Cheque'){
					if($bankdata){
						$bankbal = $bankdata[0]['balance'] - $totalpaid;
						$ttype = 'Debit';
						
						$bankdata = array(
									"bank_id"			=> $this->input->post('bank_id'),
									"transaction_type"	=> $ttype,
									"transaction_mode"	=> $payment_mode,
									"transaction_amount"=> $totalpaid,
									"balance_amount"	=> $bankbal,
									"transaction_date" 	=> date("Y-m-d"),
									"remarks" 			=> addslashes($remarks),
									"receipt_id" 		=> 0,
									"voucher_id" 		=> $voucher_id
								);
						$this->Common_Model->dbinsertid("bank_book", $bankdata);
						$this->Common_Model->db_query("UPDATE banks SET balance = ".$bankbal." WHERE bank_id = ".$this->input->post('bank_id'));
					}
				}

				if($payment_mode == 'Net Banking'){
					if($bankdata){
						$bankbal = $bankdata[0]['balance'] - $totalpaid;
						$ttype = 'Debit';
					
						$bankdata = array(
									"bank_id"			=> $this->input->post('bank_id'),
									"transaction_type"	=> $ttype,
									"transaction_mode"	=> $payment_mode,
									"transaction_amount"=> $totalpaid,
									"balance_amount"	=> $bankbal,
									"transaction_date" 	=> date("Y-m-d"),
									"remarks" 			=> addslashes($remarks),
									"receipt_id" 		=> 0,
									"voucher_id" 		=> $voucher_id
								);
						$this->Common_Model->dbinsertid("bank_book", $bankdata);
						$this->Common_Model->db_query("UPDATE banks SET balance = ".$bankbal." WHERE bank_id = ".$this->input->post('bank_id'));
					}
				}

				
				if($this->input->post('saveandprint') == 'Yes'){
					$this->session->set_flashdata('saveandprint', $voucher_id);
				}
				}
				$this->session->set_flashdata('success', 'Vehicle Repair updated successfully.' );
				redirect('masters/add_vehicle_repair_log');
			}else{
				$this->session->set_flashdata('error', validation_errors());
				redirect('masters/add_vehicle_repair_log');
			}
		}
		$data['activemenu'] = 'vehicles';
		$data['activesubmenu'] = 'vehicle_repair_log';
		$data['vehicles']	= $this->Common_Model->FetchData("vehicles", "*", "1 ORDER BY registration_no ASC");
		$data['expense_types'] = $this->Common_Model->FetchData("expense_types", "*", "1 ORDER BY expense_name ASC");
		$data['banks'] = $this->Common_Model->FetchData("banks", "*", "status = 1 ORDER BY bank_name ASC");
		$this->load->view('masters/add_vehicle_repair_log', $data);
	}

	function vehicle_repair_log(){
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$data['per_page'] = $per_page = isset($_REQUEST['per_page']) ? $_REQUEST['per_page'] : 20;
		$data['page'] = $page = isset($_REQUEST['page']) ? $_REQUEST['page'] : '1';
		$this->load->helper('url');
		$currentURL = current_url();
		$sql = "1";
		
		$urlvars = '';
		
		if(isset($_REQUEST['registration_no']) && $_REQUEST['registration_no'] != ''){
			$sql.= " AND v.registration_no LIKE '%".$_REQUEST['registration_no']."%'";
			$urlvars.= "&registration_no=".$_REQUEST['registration_no'];
		}

		if(isset($_REQUEST['repair_work']) && $_REQUEST['repair_work'] != ''){
			$sql.= " AND r.repair_work LIKE '%".$_REQUEST['repair_work']."%'";
			$urlvars.= "&repair_work=".$_REQUEST['repair_work'];
		}

		if(isset($_REQUEST['garage_name']) && $_REQUEST['garage_name'] != ''){
			$sql.= " AND r.garage_name LIKE '%".$_REQUEST['garage_name']."%'";
			$urlvars.= "&garage_name=".$_REQUEST['garage_name'];
		}

		if(isset($_REQUEST['repair_date_from']) && $_REQUEST['repair_date_from'] != ''){
			$sql.= " AND r.repair_date >= '".$_REQUEST['repair_date_from']."'";
			$urlvars.= "&repair_date_from=".$_REQUEST['repair_date_from'];
		}
		
		if(isset($_REQUEST['repair_date_to']) && $_REQUEST['repair_date_to'] != ''){
			$sql.= " AND r.repair_date <= '".$_REQUEST['repair_date_to']."'";
			$urlvars.= "&repair_date_to=".$_REQUEST['repair_date_to'];
		}

		$sSql = "SELECT COUNT(*) as num FROM vehicles_repair_log AS r LEFT JOIN vehicles AS v ON r.vehicle_id = v.vehicle_id WHERE $sql";
		$records = $this->Common_Model->db_query($sSql);
		$totalrecords = $records[0]['num'];
		if($totalrecords){
			$sSql = "SELECT r.repair_id, r.vehicle_id, r.repair_work, r.repair_date, r.garage_name, r.repair_amount, v.registration_no, v.description FROM vehicles_repair_log AS r LEFT JOIN vehicles AS v ON r.vehicle_id = v.vehicle_id WHERE $sql ORDER BY vehicle_id DESC";
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
		$data['activemenu'] = 'vehicles';
		$data['activesubmenu'] = 'vehicle_repair_log';
		$data['vehicles']	= $this->Common_Model->FetchData("vehicles", "*", "1 ORDER BY registration_no ASC");
		$this->load->view('masters/vehicle_repair_log', $data);
	}

	function delete_repair_log($repair_id = 0){
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$this->Common_Model->DelData("vehicles_repair_log", "repair_id = ".$repair_id);
		$this->session->set_flashdata('success', 'Record deleted successfully.' );
		redirect("masters/vehicle_repair_log");
	}

	function add_vehicle_fuel_log(){
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		if($this->input->post('submitBtn')){
			$this->form_validation->set_rules('registration_no', 'Registration No', 'trim|required');
			$this->form_validation->set_error_delimiters('<p class="has-error"><label class="control-label">', '</label></p>');
			if($this->form_validation->run()){
				$data_list = array(
					'vehicle_id'			=> addslashes($this->input->post('registration_no')),
					'remarks'				=> addslashes($this->input->post('remarks')),
					'record_date'			=> $this->input->post('record_date'),
					'opening_km'			=> $this->input->post('opening_km'),
					'closing_km'			=> $this->input->post('closing_km'),
					'distance_covered'		=> $this->input->post('distance_covered'),
					'fuel_in_tank'			=> $this->input->post('fuel_in_tank'),
					'fuel_filled'			=> $this->input->post('fuel_filled'),
					'fuel_used'				=> $this->input->post('fuel_used'),
					'fuel_balance'			=> $this->input->post('fuel_balance'),
					'driver_name'			=> $this->input->post('driver_name'),
					'created_by'			=> $this->session->userdata('user_id'),
					'created_on'			=> date('Y-m-d H:i:s')
				);
				$id = $this->Common_Model->dbinsertid("vehicles_fuel_log", $data_list);
				$totalpaid = $this->input->post('amount');
				if($this->input->post('addvoucher') == 'Yes'){
				$payment_mode 	= $this->input->post("payment_mode");
				$remarks 		= addslashes($this->input->post("remarks"));
				$bankdata = $this->Common_Model->FetchData("banks", "*", "bank_id = '".$this->input->post('bank_id')."'");
				$datalist = array(
					"payment_date"		=> date('Y-m-d'),
					"amount" 			=> $totalpaid,
					"payment_mode" 		=> $payment_mode,
					"purpose" 			=> 'Expense',
					"created_on" 		=> date("Y-m-d H:i:s"),
					"created_by" 		=> $this->session->userdata("user_id"),
					"remarks" 			=> $remarks,
					"employee_id" 		=> 0,
					"expense_type" 		=> $this->input->post("expense_type"),
					"mobile"			=> '',
					"bank_id"			=> $this->input->post("bank_id"),
					"cheque_no"			=> $payment_mode != 'Cash' ? $this->input->post('cheque_no') : '',
					"bank_name"			=> $payment_mode != 'Cash' ? $this->input->post('bank_name') : '',
					"bank_branch"		=> $payment_mode != 'Cash' ? $this->input->post('bank_branch') : ''
				);
				$voucher_id = $this->Common_Model->dbinsertid("vouchers", $datalist);
				$voucher_no = date('Ymd').str_pad($voucher_id, 6, '0', STR_PAD_LEFT);
				$this->Common_Model->db_query("UPDATE vouchers SET voucher_no = '".$voucher_no."' WHERE voucher_id = ".$voucher_id);
				if($payment_mode == 'Cash'){
					$cash = $this->Common_Model->FetchData("cash_log", "*", "1 ORDER BY id DESC LIMIT 1");
					if($cash){
						$balance = $cash[0]['cash_balance'] - $totalpaid;
					}else{
						$balance = 0;
					}
					$datalist1 = array(
									"mode"				=> 'Debit',
									"amount" 			=> $totalpaid,
									"cash_balance"		=> $balance,
									"date" 				=> date("Y-m-d"),
									"created_by" 		=> $this->session->userdata("user_id"),
									"remarks" 			=> $remarks,
									"receipt_id" 		=> 0,
									"voucher_id" 		=> $voucher_id
								);
					$this->Common_Model->dbinsertid("cash_log", $datalist1);

				}
				if($payment_mode == 'Cheque'){
					if($bankdata){
						$bankbal = $bankdata[0]['balance'] - $totalpaid;
						$ttype = 'Debit';
						
						$bankdata = array(
									"bank_id"			=> $this->input->post('bank_id'),
									"transaction_type"	=> $ttype,
									"transaction_mode"	=> $payment_mode,
									"transaction_amount"=> $totalpaid,
									"balance_amount"	=> $bankbal,
									"transaction_date" 	=> date("Y-m-d"),
									"remarks" 			=> addslashes($remarks),
									"receipt_id" 		=> 0,
									"voucher_id" 		=> $voucher_id
								);
						$this->Common_Model->dbinsertid("bank_book", $bankdata);
						$this->Common_Model->db_query("UPDATE banks SET balance = ".$bankbal." WHERE bank_id = ".$this->input->post('bank_id'));
					}
				}

				if($payment_mode == 'Net Banking'){
					if($bankdata){
						$bankbal = $bankdata[0]['balance'] - $totalpaid;
						$ttype = 'Debit';
					
						$bankdata = array(
									"bank_id"			=> $this->input->post('bank_id'),
									"transaction_type"	=> $ttype,
									"transaction_mode"	=> $payment_mode,
									"transaction_amount"=> $totalpaid,
									"balance_amount"	=> $bankbal,
									"transaction_date" 	=> date("Y-m-d"),
									"remarks" 			=> addslashes($remarks),
									"receipt_id" 		=> 0,
									"voucher_id" 		=> $voucher_id
								);
						$this->Common_Model->dbinsertid("bank_book", $bankdata);
						$this->Common_Model->db_query("UPDATE banks SET balance = ".$bankbal." WHERE bank_id = ".$this->input->post('bank_id'));
					}
				}

				
				if($this->input->post('saveandprint') == 'Yes'){
					$this->session->set_flashdata('saveandprint', $voucher_id);
				}
				}
				$this->session->set_flashdata('success', 'Vehicle Fuel log successfully.' );
				redirect('masters/add_vehicle_fuel_log');
			}else{
				$this->session->set_flashdata('error', validation_errors());
				redirect('masters/add_vehicle_fuel_log');
			}
		}
		$data['activemenu'] = 'vehicles';
		$data['activesubmenu'] = 'vehicle_fuel_log';
		$data['vehicles']	= $this->Common_Model->FetchData("vehicles", "*", "1 ORDER BY registration_no ASC");
		$data['expense_types'] = $this->Common_Model->FetchData("expense_types", "*", "1 ORDER BY expense_name ASC");
		$data['banks'] = $this->Common_Model->FetchData("banks", "*", "status = 1 ORDER BY bank_name ASC");
		$this->load->view('masters/add_vehicle_fuel_log', $data);
	}

	function vehicle_fuel_log(){
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$data['per_page'] = $per_page = isset($_REQUEST['per_page']) ? $_REQUEST['per_page'] : 20;
		$data['page'] = $page = isset($_REQUEST['page']) ? $_REQUEST['page'] : '1';
		$this->load->helper('url');
		$currentURL = current_url();
		$sql = "1";
		
		$urlvars = '';
		
		if(isset($_REQUEST['registration_no']) && $_REQUEST['registration_no'] != ''){
			$sql.= " AND v.registration_no LIKE '%".$_REQUEST['registration_no']."%'";
			$urlvars.= "&registration_no=".$_REQUEST['registration_no'];
		}

		if(isset($_REQUEST['driver_name']) && $_REQUEST['driver_name'] != ''){
			$sql.= " AND f.driver_name LIKE '%".$_REQUEST['driver_name']."%'";
			$urlvars.= "&driver_name=".$_REQUEST['driver_name'];
		}

		if(isset($_REQUEST['record_date_from']) && $_REQUEST['record_date_from'] != ''){
			$sql.= " AND f.record_date >= '".$_REQUEST['record_date_from']."'";
			$urlvars.= "&record_date_from=".$_REQUEST['record_date_from'];
		}
		
		if(isset($_REQUEST['record_date_to']) && $_REQUEST['record_date_to'] != ''){
			$sql.= " AND f.record_date <= '".$_REQUEST['record_date_to']."'";
			$urlvars.= "&record_date_to=".$_REQUEST['record_date_to'];
		}

		$sSql = "SELECT COUNT(*) as num FROM vehicles_fuel_log AS f LEFT JOIN vehicles AS v ON f.vehicle_id = v.vehicle_id WHERE $sql";
		$records = $this->Common_Model->db_query($sSql);
		$totalrecords = $records[0]['num'];
		if($totalrecords){
			$sSql = "SELECT f.fuel_id, f.vehicle_id, f.record_date, f.opening_km, f.remarks, f.closing_km, f.distance_covered, f.fuel_in_tank, f.fuel_filled, f.fuel_used, f.fuel_balance, f.driver_name, f.created_by, f.created_on, v.registration_no, v.description, u.firstname, u.lastname FROM vehicles_fuel_log AS f LEFT JOIN vehicles AS v ON f.vehicle_id = v.vehicle_id LEFT JOIN users AS u ON f.created_by = u.user_id WHERE $sql ORDER BY vehicle_id DESC";
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
		$data['activemenu'] = 'vehicles';
		$data['activesubmenu'] = 'vehicle_fuel_log';
		$data['vehicles']	= $this->Common_Model->FetchData("vehicles", "*", "1 ORDER BY registration_no ASC");
		$this->load->view('masters/vehicle_fuel_log', $data);
	}

	function delete_fuel_log($fuel_id = 0){
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$this->Common_Model->DelData("vehicles_fuel_log", "fuel_id = ".$fuel_id);
		$this->session->set_flashdata('success', 'Record deleted successfully.' );
		redirect("masters/vehicle_fuel_log");
	}

	function assets(){
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$data['per_page'] = $per_page = isset($_REQUEST['per_page']) ? $_REQUEST['per_page'] : 20;
		$data['page'] = $page = isset($_REQUEST['page']) ? $_REQUEST['page'] : '1';
		$this->load->helper('url');
		$currentURL = current_url();
		$sql = "1";
		
		$urlvars = '';
		

		if(isset($_REQUEST['item_name']) && $_REQUEST['item_name'] != ''){
			$sql.= " AND item_name LIKE '%".$_REQUEST['item_name']."%'";
			$urlvars.= "&item_name=".$_REQUEST['item_name'];
		}
		if(isset($_REQUEST['purchase_from']) && $_REQUEST['purchase_from'] != ''){
			$sql.= " AND purchase_from LIKE '%".$_REQUEST['purchase_from']."%'";
			$urlvars.= "&purchase_from=".$_REQUEST['purchase_from'];
		}
		if(isset($_REQUEST['bill_no']) && $_REQUEST['bill_no'] != ''){
			$sql.= " AND bill_no LIKE '%".$_REQUEST['bill_no']."%'";
			$urlvars.= "&bill_no=".$_REQUEST['bill_no'];
		}
		if(isset($_REQUEST['purchase_date_from']) && $_REQUEST['purchase_date_from'] != ''){
			$sql.= " AND purchase_date >= '".$_REQUEST['purchase_date_from']."'";
			$urlvars.= "&purchase_date_from=".$_REQUEST['purchase_date_from'];
		}
		if(isset($_REQUEST['purchase_date_to']) && $_REQUEST['purchase_date_to'] != ''){
			$sql.= " AND purchase_date <= '".$_REQUEST['purchase_date_to']."'";
			$urlvars.= "&purchase_date_to=".$_REQUEST['purchase_date_to'];
		}

		$sSql = "SELECT COUNT(*) as num FROM assets WHERE $sql";
		$records = $this->Common_Model->db_query($sSql);
		$totalrecords = $records[0]['num'];
		if($totalrecords){
			$sSql = "SELECT * FROM assets WHERE $sql ORDER BY asset_id DESC";
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
		$data['activemenu'] = 'assets';
		$data['activesubmenu'] = 'assets';
		$this->load->view('masters/assets', $data);
	}

	function add_assets(){
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		if($this->input->post('submitBtn')){
			$this->form_validation->set_rules('item_name', 'Item Name', 'trim|required');
			
			$this->form_validation->set_error_delimiters('<p class="has-error"><label class="control-label">', '</label></p>');
			if($this->form_validation->run()){
				$chk_item = $this->Common_Model->FetchData("assets","*","item_name='".$this->input->post('item_name')."' AND item_unit='".$this->input->post('item_unit')."'");
				if ($chk_item) {
					$this->session->set_flashdata('error', 'Item Already Exists!');
					redirect('masters/add_assets');
				}else{

					$data_list = array(
						'item_name'		=> addslashes($this->input->post('item_name')),
						'item_unit'	=> addslashes($this->input->post('item_unit')),
						'item_price'	=> addslashes($this->input->post('item_price')),
						'item_sale_price'	=> $this->input->post('item_sale_price'),
						'item_type'	=> $this->input->post('item_type'),
						'minqty'	=> '1',
						
					);
					$id = $this->Common_Model->dbinsertid("assets", $data_list);
					$this->session->set_flashdata('success', 'Asset Added Successfully');
					redirect('masters/add_assets');
				}
			}else{
				$this->session->set_flashdata('error', validation_errors());
			}
		}
		$data['activemenu'] = 'assets';
		$data['activesubmenu'] = 'assets';
		$data['assets'] = $this->Common_Model->FetchData("assets","*","1 ORDER BY item_type ASC");
		$this->load->view('masters/add_assets', $data);
	}

	function addStocks(){
		$asset_id =$this->input->post('asset_id');
		$stock =$this->input->post('stock');
		$asset = $this->Common_Model->FetchData("assets","*","asset_id=".$asset_id);
		$newstock = $asset[0]['item_qty'] + $stock;
		$this->Common_Model->db_query("UPDATE assets SET item_qty=".$newstock." WHERE asset_id=".$asset_id."");

		echo $newstock;
	}

	function edit_assets($asset_id=0){
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		if($this->input->post('submitBtn')){
			$this->form_validation->set_rules('item_name', 'Item Name', 'trim|required');
			
			$this->form_validation->set_error_delimiters('<p class="has-error"><label class="control-label">', '</label></p>');
			if($this->form_validation->run()){
				$data_list = array(
					'item_name'		=> addslashes($this->input->post('item_name')),
					'item_unit'	=> addslashes($this->input->post('item_unit')),
					'item_price'	=> addslashes($this->input->post('item_price')),
					'item_sale_price'	=> $this->input->post('item_sale_price'),
					'item_type'	=> $this->input->post('item_type'),
					'minqty'	=> '1',
					
				);
				$id = $this->Common_Model->update_records("assets","asset_id", $asset_id, $data_list);
				$this->session->set_flashdata('success', 'Asset Updated Successfully');
				redirect('masters/add_assets');
			}else{
				$this->session->set_flashdata('error', validation_errors());
			}
		}
		$data['activemenu'] = 'assets';
		$data['activesubmenu'] = 'assets';
		$data['rec'] = $this->Common_Model->FetchData("assets","*","asset_id=".$asset_id."");
		$this->load->view('masters/edit_assets', $data);
	}

	function delete_assets($asset_id = 0){
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$this->Common_Model->DelData("assets", "asset_id = ".$asset_id);
		$this->session->set_flashdata('success', 'Record deleted successfully.' );
		redirect($_SERVER['HTTP_REFERER']);
	}

	

	function getSubjectsCommaClass(){
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$subjects = $this->Common_Model->db_query("SELECT GROUP_CONCAT(`subject_name` SEPARATOR ', ') AS names FROM subjects WHERE class_id = '".$this->input->post('class_id')."'");
		if($subjects){
			echo $subjects[0]['names'];
		}else{
			echo '';
		}
		die();
	}

	function notes(){
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		if($this->input->post('submitBtn')){
			$this->form_validation->set_rules('note', 'Note', 'trim|required');
			$this->form_validation->set_error_delimiters('<p class="has-error"><label class="control-label">', '</label></p>');
			if($this->form_validation->run()){
				$data_list = array(
					'note'			=> addslashes($this->input->post('note')),
					'created_by'				=> $this->session->userdata('user_id'),
					'created_on'		=> date("Y-m-d H:i:s")
				);
				$id = $this->Common_Model->dbinsertid("notes", $data_list);
				$this->session->set_flashdata('success', 'Note added successfully.' );
				redirect('masters/notes');
			}else{
				$this->session->set_flashdata('error', validation_errors());
			}
		}
		$data['per_page'] = $per_page = isset($_REQUEST['per_page']) ? $_REQUEST['per_page'] : 20;
		$data['page'] = $page = isset($_REQUEST['page']) ? $_REQUEST['page'] : '1';
		$this->load->helper('url');
		$currentURL = current_url();
		$sql = "created_by = ".$this->session->userdata("user_id");
		$urlvars = '';
		if(isset($_REQUEST['note']) && $_REQUEST['note'] != ''){
			$sql.= " AND note LIKE '%".$_REQUEST['note']."%'";
			$urlvars.= "&note=".$_REQUEST['note'];
		}

		$sSql = "SELECT COUNT(*) as num FROM notes WHERE $sql";
		$records = $this->Common_Model->db_query($sSql);
		$totalrecords = $records[0]['num'];
		if($totalrecords){
			$sSql = "SELECT * FROM notes WHERE $sql ORDER BY id DESC";
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
		$data['activemenu'] = 'notes';
		$data['activesubmenu'] = 'notes';
		$this->load->view('masters/notes', $data);
	}

	function academic_calendar(){
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		if($this->input->post('submitBtn')){
			//$this->form_validation->set_rules('class_id', 'Class', 'trim|required');
			$this->form_validation->set_rules('session_id', 'Session', 'trim|required');
			$this->form_validation->set_error_delimiters('<p class="has-error"><label class="control-label">', '</label></p>');
			if($this->form_validation->run()){
				
				$data_list = array(
					"class_id"		=> $this->input->post("class_id"),
					"session_id"	=> $this->input->post('session_id'),
				); 
				$config = array(
					'upload_path' => "./uploads/",
					'allowed_types' => 'pdf|doc|docx|jpg|png|jpeg',
					'overwrite' => TRUE,
					'file_name' => 'routine_'.uniqid().time(),
					'max_size' => "10048000" 
				);

				$this->load->library('upload', $config);
				$this->upload->initialize($config);
				if($_FILES['attachment']['name']!=""){
					if($this->upload->do_upload("attachment"))
					{
						$dat = $this->upload->data();
						$data_list['attachment'] = $dat['file_name'];
					}else{
						$filename = '';
						$this->session->set_flashdata('error', $this->upload->display_errors());
						redirect($_SERVER['HTTP_REFERER']);
					}
				}
				$inchk = $this->Common_Model->FetchData("routines", "*", "class_id = '".$this->input->post('class_id')."' AND session_id = '".$this->input->post('session_id')."'");
				if($inchk){
					$this->Common_Model->update_records("routines", "routine_id", $inchk[0]['routine_id'], $data_list);
				}else{
					$this->Common_Model->dbinsertid("routines", $data_list);
				}
				
				$this->session->set_flashdata('success', 'Routine saved successfully.' );
				redirect("masters/academic_calendar");
		   	}else{
				$this->session->set_flashdata("error", validation_errors());
			}
		}
		$data['per_page'] = $per_page = isset($_REQUEST['per_page']) ? $_REQUEST['per_page'] : 20;
		$data['page'] = $page = isset($_REQUEST['page']) ? $_REQUEST['page'] : '1';
		$this->load->helper('url');
		$currentURL = current_url();
		$sql = "1";
		$urlvars = '';
		if(isset($_REQUEST['session_id']) && $_REQUEST['session_id'] != ''){
			$sql.= " AND sy.session_id = '".$_REQUEST['session_id']."'";
			$urlvars.= "&session_id=".$_REQUEST['session_id'];
		}
		if(isset($_REQUEST['class_id']) && $_REQUEST['class_id'] != ''){
			$sql.= " AND sy.class_id = '".$_REQUEST['class_id']."'";
			$urlvars.= "&class_id=".$_REQUEST['class_id'];
		}

		$sSql = "SELECT COUNT(*) as num FROM routines AS sy LEFT JOIN sessions AS s ON sy.session_id = s.session_id LEFT JOIN classes AS c ON sy.class_id = c.class_id WHERE $sql";
		$records = $this->Common_Model->db_query($sSql);
		$totalrecords = $records[0]['num'];
		if($totalrecords){
			$sSql = "SELECT * FROM routines AS sy LEFT JOIN sessions AS s ON sy.session_id = s.session_id LEFT JOIN classes AS c ON sy.class_id = c.class_id WHERE $sql ORDER BY s.session_name DESC";
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
		$data['activemenu'] = 'routines';
		$data['activesubmenu'] = 'routines';
		$data['sessions'] = $this->Common_Model->FetchData("sessions", "*", "1 ORDER BY session_name DESC");
		$data['classes'] = $this->Common_Model->FetchData("classes", "*", "1 ORDER BY class_name ASC");
		$this->load->view('masters/academic_calendar', $data);
	}

	function delete_routine($routine_id = 0){
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$this->Common_Model->deleterecord("routines", "routine_id", $routine_id);
		$this->session->set_flashdata('success', 'Routine Deleted successfully.');
		redirect("masters/academic_calendar");
	}

	function syllabus(){
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		if($this->input->post('submitBtn')){
			$this->form_validation->set_rules('class_id', 'Class', 'trim|required');
			$this->form_validation->set_rules('session_id', 'Session', 'trim|required');
			$this->form_validation->set_error_delimiters('<p class="has-error"><label class="control-label">', '</label></p>');
			if($this->form_validation->run()){
				
				$data_list = array(
					"class_id"		=> $this->input->post("class_id"),
					"session_id"	=> $this->input->post('session_id'),
				); 
				$config = array(
					'upload_path' => "./uploads/",
					'allowed_types' => 'pdf|jpg|png|jpeg',
					'overwrite' => TRUE,
					'file_name' => 'syllabus_'.uniqid().time(),
					'max_size' => "10048000" 
				);

				$this->load->library('upload', $config);
				$this->upload->initialize($config);
				if($_FILES['attachment']['name']!=""){
					if($this->upload->do_upload("attachment"))
					{
						$dat = $this->upload->data();
						$data_list['attachment'] = $dat['file_name'];
					}else{
						$filename = '';
						$this->session->set_flashdata('error', $this->upload->display_errors());
						redirect($_SERVER['HTTP_REFERER']);
					}
				}
				$inchk = $this->Common_Model->FetchData("syllabus", "*", "class_id = '".$this->input->post('class_id')."' AND session_id = '".$this->input->post('session_id')."'");
				if($inchk){
					$this->Common_Model->update_records("syllabus", "syllabus_id", $inchk[0]['syllabus_id'], $data_list);
				}else{
					$this->Common_Model->dbinsertid("syllabus", $data_list);
				}
				
				$this->session->set_flashdata('success', 'Syllabus saved successfully.' );
				redirect("masters/syllabus");
		   	}else{
				$this->session->set_flashdata("error", validation_errors());
			}
		}
		$data['per_page'] = $per_page = isset($_REQUEST['per_page']) ? $_REQUEST['per_page'] : 20;
		$data['page'] = $page = isset($_REQUEST['page']) ? $_REQUEST['page'] : '1';
		$this->load->helper('url');
		$currentURL = current_url();
		$sql = "1";
		$urlvars = '';
		if(isset($_REQUEST['session_id']) && $_REQUEST['session_id'] != ''){
			$sql.= " AND sy.session_id = '".$_REQUEST['session_id']."'";
			$urlvars.= "&session_id=".$_REQUEST['session_id'];
		}
		if(isset($_REQUEST['class_id']) && $_REQUEST['class_id'] != ''){
			$sql.= " AND sy.class_id = '".$_REQUEST['class_id']."'";
			$urlvars.= "&class_id=".$_REQUEST['class_id'];
		}

		$sSql = "SELECT COUNT(*) as num FROM syllabus AS sy LEFT JOIN sessions AS s ON sy.session_id = s.session_id LEFT JOIN classes AS c ON sy.class_id = c.class_id WHERE $sql";
		$records = $this->Common_Model->db_query($sSql);
		$totalrecords = $records[0]['num'];
		if($totalrecords){
			$sSql = "SELECT * FROM syllabus AS sy LEFT JOIN sessions AS s ON sy.session_id = s.session_id LEFT JOIN classes AS c ON sy.class_id = c.class_id WHERE $sql ORDER BY s.session_name DESC";
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
		}else{
			$data['records'] = 0;
		}
		$data['activemenu'] = 'syllabus';
		$data['activesubmenu'] = 'syllabus';
		$data['sessions'] = $this->Common_Model->FetchData("sessions", "*", "1 ORDER BY session_name DESC");
		$data['classes'] = $this->Common_Model->FetchData("classes", "*", "1 ORDER BY class_name ASC");
		$this->load->view('masters/syllabus', $data);
	}

	function edit_syllabus($syllabus_id = 0){
		$data = array();
		$data['syllabus_id'] = $syllabus_id;
		$data['rec'] = $rec = $this->Common_Model->FetchData("syllabus as s LEFT JOIN classes as c ON c.class_id=s.class_id LEFT JOIN sessions se ON se.session_id=s.session_id", "*", "syllabus_id=".$syllabus_id);
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		if($this->input->post('submitBtn')){
			$this->form_validation->set_rules('class_id', 'Class', 'trim|required');
			$this->form_validation->set_rules('session_id', 'Session', 'trim|required');
			$this->form_validation->set_error_delimiters('<p class="has-error"><label class="control-label">', '</label></p>');
			if($this->form_validation->run()){				
				$data_list = array(
					"class_id"		=> $this->input->post("class_id"),
					"session_id"	=> $this->input->post('session_id'),
				); 
				$config = array(
					'upload_path' => "./uploads/",
					'allowed_types' => 'pdf|jpg|png|jpeg',
					'overwrite' => TRUE,
					'file_name' => 'syllabus_'.uniqid().time(),
					'max_size' => "10048000" 
				);

				$this->load->library('upload', $config);
				$this->upload->initialize($config);

				if($_FILES['attachment']['name']!=""){
					if($this->upload->do_upload("attachment"))
					{
						$dat = $this->upload->data();
						$data_list['attachment'] = $dat['file_name'];
					}else{
						$filename = '';
						$this->session->set_flashdata('error', $this->upload->display_errors());
						redirect($_SERVER['HTTP_REFERER']);
					}
				}else{
					$data_list['attachment'] = $rec[0]['attachment'];;
				}	
				//print_r($data_list)	;exit;	
					$this->Common_Model->update_records("syllabus", "syllabus_id", $syllabus_id, $data_list);
				$this->session->set_flashdata('success', 'Syllabus Updated successfully.' );
				redirect("masters/syllabus");
		   	}else{
				$this->session->set_flashdata("error", validation_errors());
			}
		}

		$data['activemenu'] = 'syllabus';
		$data['activesubmenu'] = 'syllabus';		
		$data['sessions'] = $this->Common_Model->FetchData("sessions", "*", "1 ORDER BY session_name DESC");
		$data['classes'] = $this->Common_Model->FetchData("classes", "*", "1 ORDER BY class_name ASC");
		$this->load->view('masters/edit_syllabus', $data);
	}

	function delete_syllabus($syllabus_id = 0){
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$this->Common_Model->deleterecord("syllabus", "syllabus_id", $syllabus_id);
		$this->session->set_flashdata('success', 'Syllabus Deleted successfully.');
		redirect("masters/syllabus");
	}

	function notepad(){
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$data['per_page'] = $per_page = isset($_REQUEST['per_page']) ? $_REQUEST['per_page'] : 20;
		$data['page'] = $page = isset($_REQUEST['page']) ? $_REQUEST['page'] : '1';
		$this->load->helper('url');
		$currentURL = current_url();
		$sql = "created_by = ".$this->session->userdata("user_id");
		$urlvars = '';
		if(isset($_REQUEST['notes']) && $_REQUEST['notes'] != ''){
			$sql.= " AND notes LIKE '%".$_REQUEST['notes']."%'";
			$urlvars.= "&notes=".$_REQUEST['notes'];
		}

		$sSql = "SELECT COUNT(*) as num FROM notepad WHERE $sql";
		$records = $this->Common_Model->db_query($sSql);
		$totalrecords = $records[0]['num'];
		if($totalrecords){
			$sSql = "SELECT * FROM notepad WHERE $sql ORDER BY id DESC";
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
		$data['activemenu'] = 'notepad';
		$data['activesubmenu'] = 'notepad';
		$this->load->view('masters/notepad', $data);
	}

	function add_notepad(){
		$data = array();
		if($this->input->post('submitBtn')){
			$this->form_validation->set_rules('notes', 'Notepad', 'trim|required');
			$this->form_validation->set_rules('subject', 'Subject', 'trim|required');
			$this->form_validation->set_error_delimiters('<p class="has-error"><label class="control-label">', '</label></p>');
			if($this->form_validation->run()){
				$data_list = array(
					'notes'			=> addslashes($this->input->post('notes')),
					'subject'		=> addslashes($this->input->post('subject')),
					'notepad_no'		=> $this->input->post('notepad_no'),
					'created_by'		=> $this->session->userdata('user_id'),
					'created_on'		=> date("Y-m-d H:i:s")
				);
				$id = $this->Common_Model->dbinsertid("notepad", $data_list);
				$this->session->set_flashdata('success', 'Record added successfully.' );
				redirect('masters/notepad');
			}else{
				$this->session->set_flashdata('error', validation_errors());
			}
		}
		$data['note'] = $this->Common_Model->FetchData("notepad", "*", "1 ORDER BY id DESC");
		$data['activemenu'] = 'notepad';
		$data['activesubmenu'] = 'add_notepad';
		$this->load->view('masters/add_notepad', $data);
	}

	function edit_notepad($id = 0){
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		if($this->input->post('submitBtn')){
			$this->form_validation->set_rules('notes', 'Notepad', 'trim|required');
			$this->form_validation->set_rules('subject', 'Subject', 'trim|required');
			$this->form_validation->set_error_delimiters('<p class="has-error"><label class="control-label">', '</label></p>');
			if($this->form_validation->run()){
				$data_list = array(
					'notes'			=> addslashes($this->input->post('notes')),
					'subject'			=> addslashes($this->input->post('subject'))
				);
				$id = $this->Common_Model->dbinsertid("notepad", $data_list);
				$this->session->set_flashdata('success', 'Record updated successfully.' );
				redirect($_SERVER['HTTP_REFERER']);
			}else{
				$this->session->set_flashdata('error', validation_errors());
			}
		}
		$data['activemenu'] = 'notepad';
		$data['activesubmenu'] = 'notepad';
		$data['notepad'] = $this->Common_Model->FetchData("notepad", "*", "id = $id");
		$this->load->view('masters/edit_notepad', $data);
	}

	function view_notepad($id = 0){
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$data['notepad'] = $this->Common_Model->FetchData("notepad", "*", "id = ".$id);
		error_reporting(0);
		ini_set('display_error', -1);
		$html = $this->load->view('masters/view_notepad', $data, TRUE);
		$this->load->library('Notepad');
		$pdf = new Notepad(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('O.P.JINDAL');
		$pdf->SetTitle('Notepad');
		$pdf->SetSubject('Notepad');
		$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
		$pdf->setHeaderData($ln='', $lw=0, $ht='', $hs='<table width="100%"><tr><td width="20%"><img src="'.base_url().'assets/img/phoenixlogo.png" alt="O.P.JINDAL" width="100"></td><td width="80%"><h1 align="center" style="font-size: 30px; font-weight: bold;">O.P.JINDAL SCHOOL</h1>			<p align="center" width="100%">			Affiliated to CBSE, New Delhi<br/>			DAY - CUM - RESIDENCIAL<br/>			Gopinathpur, Bhubaneswar - 2, Ph. No.(0674) 2343851, Mob. : 8658599505</p>			</td>		</tr>	</table>', $tc=array(0,0,0), $lc=array(0,0,0));
		$pdf->SetMargins(5, 5, 5, true);
		$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
		$pdf->SetAutoPageBreak(TRUE, 17);
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
		$pdf->AddPage('P', 'A4', true, true);
		$pdf->SetMargins(5, 25, 5, true);
		$pdf->SetFont('helvetica', '', 8);
		$pdf->setFontSubsetting(false);
		$pdf->writeHTML($html, true, false, false, false, '');
		date_default_timezone_set("Asia/Kolkata");
		$filename = date("YmdHis").'.pdf';
		$pdf->Output($filename, 'I');
	}

	function delete_notepad($id = 0){
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$this->Common_Model->DelData("notepad", "id = ".$id);
		$this->session->set_flashdata('success', 'Record deleted successfully.' );
		redirect($_SERVER['HTTP_REFERER']);
	}

	function banks(){
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		if($this->input->post('online_bank')){
			$this->Common_Model->db_query("UPDATE banks SET online = '0'");
			$this->Common_Model->db_query("UPDATE banks SET online = '1' WHERE bank_id = ".$this->input->post('online_bank'));
		}
		$data['per_page'] = $per_page = isset($_REQUEST['per_page']) ? $_REQUEST['per_page'] : 20;
		$data['page'] = $page = isset($_REQUEST['page']) ? $_REQUEST['page'] : '1';
		$this->load->helper('url');
		$currentURL = current_url();
		$sql = "1";
		$urlvars = '';
		if(isset($_REQUEST['bank_name']) && $_REQUEST['bank_name'] != ''){
			$sql.= " AND bank_name LIKE '%".$_REQUEST['bank_name']."%'";
			$urlvars.= "&bank_name=".$_REQUEST['bank_name'];
		}

		$sSql = "SELECT COUNT(*) as num FROM banks WHERE $sql";
		$records = $this->Common_Model->db_query($sSql);
		$totalrecords = $records[0]['num'];
		if($totalrecords){
			$sSql = "SELECT * FROM banks WHERE $sql ORDER BY bank_id ASC";
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
		$data['activemenu'] = 'masters';
		$data['activesubmenu'] = 'banks';
		$this->load->view('masters/banks', $data);
	}

	function add_bank(){
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		if($this->input->post('submitBtn')){
			$this->form_validation->set_rules('bank_name', 'Bank Name', 'trim|required');
			$this->form_validation->set_rules('account_no', 'Account no', 'trim|required');
			$this->form_validation->set_error_delimiters('<p class="has-error"><label class="control-label">', '</label></p>');
			if($this->form_validation->run()){
				$data_list = array(
					'bank_name'			=> addslashes($this->input->post('bank_name')),
					'micr_code'			=> addslashes($this->input->post('micr_code')),
					'branch_name'		=> addslashes($this->input->post('branch_name')),
					'account_no'		=> addslashes($this->input->post('account_no')),
					'bank_ifsc'			=> addslashes($this->input->post('bank_ifsc')),
					'corporate_id'		=> addslashes($this->input->post('corporate_id')),
					'bank_address'		=> addslashes($this->input->post('bank_address')),
					'remark'			=> addslashes($this->input->post('remark')),
					'balance'			=> $this->input->post('balance'),
					'status'			=> addslashes($this->input->post('status'))
				);
				$id = $this->Common_Model->dbinsertid("banks", $data_list);
				$this->session->set_flashdata('success', 'Record added successfully.' );
				redirect('masters/banks');
			}else{
				$this->session->set_flashdata('error', validation_errors());
			}
		}
		$data['activemenu'] = 'masters';
		$data['activesubmenu'] = 'banks';
		$this->load->view('masters/add_bank', $data);
	}

	function edit_bank($id = 0){
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		if($this->input->post('submitBtn')){
			$this->form_validation->set_rules('bank_name', 'Bank Name', 'trim|required');
			$this->form_validation->set_rules('account_no', 'Account no', 'trim|required');
			$this->form_validation->set_error_delimiters('<p class="has-error"><label class="control-label">', '</label></p>');
			if($this->form_validation->run()){
				$data_list = array(
					'bank_name'			=> addslashes($this->input->post('bank_name')),
					'micr_code'			=> addslashes($this->input->post('micr_code')),
					'branch_name'		=> addslashes($this->input->post('branch_name')),
					'account_no'		=> addslashes($this->input->post('account_no')),
					'bank_ifsc'			=> addslashes($this->input->post('bank_ifsc')),
					'corporate_id'		=> addslashes($this->input->post('corporate_id')),
					'bank_address'		=> addslashes($this->input->post('bank_address')),
					'remark'			=> addslashes($this->input->post('remark')),
					'status'			=> addslashes($this->input->post('status'))
				);
				$id = $this->Common_Model->update_records("banks", "bank_id", $id, $data_list);
				$this->session->set_flashdata('success', 'Record added successfully.' );
				redirect('masters/banks');
			}else{
				$this->session->set_flashdata('error', validation_errors());
			}
		}
		$data['activemenu'] = 'masters';
		$data['activesubmenu'] = 'banks';
		$data['bank'] = $this->Common_Model->FetchData("banks", "*", "bank_id = $id");
		$this->load->view('masters/edit_bank', $data);
	}

	function delete_bank($bank_id = 0){
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$this->Common_Model->DelData("banks", "bank_id = ".$bank_id);
		$this->session->set_flashdata('success', 'Record deleted successfully.' );
		redirect($_SERVER['HTTP_REFERER']);
	}


	function branch(){
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		
		$data['per_page'] = $per_page = isset($_REQUEST['per_page']) ? $_REQUEST['per_page'] : 20;
		$data['page'] = $page = isset($_REQUEST['page']) ? $_REQUEST['page'] : '1';
		$this->load->helper('url');
		$currentURL = current_url();
		$sql = "1";
		$urlvars = '';
		if(isset($_REQUEST['branch_name']) && $_REQUEST['branch_name'] != ''){
			$sql.= " AND a.branch_name LIKE '%".$_REQUEST['branch_name']."%'";
			$urlvars.= "&branch_name=".$_REQUEST['branch_name'];
		}

		$sSql = "SELECT COUNT(*) as num FROM branch as a LEFT JOIN state as b on a.state=b.state_id WHERE $sql";
		$records = $this->Common_Model->db_query($sSql);
		$totalrecords = $records[0]['num'];
		if($totalrecords){
			$sSql = "SELECT * FROM branch as a LEFT JOIN state as b on a.state=b.state_id WHERE $sql ORDER BY a.branch_id ASC";
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
		$data['activemenu'] = 'masters';
		$data['activesubmenu'] = 'branch';
		$this->load->view('masters/branch', $data);
	}

	function add_branch(){
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		if($this->input->post('submitBtn')){
			$this->form_validation->set_rules('branch_name', 'Branch Name', 'trim|required');
			//$this->form_validation->set_rules('account_no', 'Account no', 'trim|required');
			$this->form_validation->set_error_delimiters('<p class="has-error"><label class="control-label">', '</label></p>');
			if($this->form_validation->run()){
				$data_list = array(
					'branch_name'			=> $this->input->post('branch_name'),
					'branch_manager'		=> $this->input->post('branch_manager'),
					'mobile_no'				=> $this->input->post('mobile_no'),
					'fax_no'				=> $this->input->post('fax_no'),
					'email'					=> $this->input->post('email'),
					'website'				=> $this->input->post('website'),
					'address'				=> $this->input->post('address'),
					'city'					=> $this->input->post('city'),
					'pincode'				=> $this->input->post('pincode'),
					'state'					=> $this->input->post('state')
				);
				$id = $this->Common_Model->dbinsertid("branch", $data_list);
				$this->session->set_flashdata('success', 'Record added successfully.' );
				redirect('masters/branch');
			}else{
				$this->session->set_flashdata('error', validation_errors());
			}
		}
		$data['state'] = $this->Common_Model->FetchData("state","*","1 order by state_title ASC");
		$data['activemenu'] = 'masters';
		$data['activesubmenu'] = 'branch';
		$this->load->view('masters/add_branch', $data);
	}

	function edit_branch($id = 0){
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		if($this->input->post('submitBtn')){
			$this->form_validation->set_rules('branch_name', 'Banch Name', 'trim|required');
			//$this->form_validation->set_rules('account_no', 'Account no', 'trim|required');
			$this->form_validation->set_error_delimiters('<p class="has-error"><label class="control-label">', '</label></p>');
			if($this->form_validation->run()){
				$data_list = array(
					'branch_name'			=> $this->input->post('branch_name'),
					'branch_manager'		=> $this->input->post('branch_manager'),
					'mobile_no'				=> $this->input->post('mobile_no'),
					'fax_no'				=> $this->input->post('fax_no'),
					'email'					=> $this->input->post('email'),
					'website'				=> $this->input->post('website'),
					'address'				=> $this->input->post('address'),
					'city'					=> $this->input->post('city'),
					'pincode'				=> $this->input->post('pincode'),
					'state'					=> $this->input->post('state')
				);
				$id = $this->Common_Model->update_records("branch", "branch_id", $id, $data_list);
				$this->session->set_flashdata('success', 'Record added successfully.' );
				redirect('masters/branch');
			}else{
				$this->session->set_flashdata('error', validation_errors());
			}
		}
		$data['state'] = $this->Common_Model->FetchData("state","*","1 order by state_title ASC");
		$data['activemenu'] = 'masters';
		$data['activesubmenu'] = 'branch';
		$data['branch'] = $this->Common_Model->FetchData("branch", "*", "branch_id = $id");
		$this->load->view('masters/edit_branch', $data);
	}

	function delete_branch($branch_id = 0){
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$this->Common_Model->DelData("branch", "branch_id = ".$branch_id);
		$this->session->set_flashdata('success', 'Record deleted successfully.' );
		redirect($_SERVER['HTTP_REFERER']);
	}

	function state(){
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		
		$data['per_page'] = $per_page = isset($_REQUEST['per_page']) ? $_REQUEST['per_page'] : 20;
		$data['page'] = $page = isset($_REQUEST['page']) ? $_REQUEST['page'] : '1';
		$this->load->helper('url');
		$currentURL = current_url();
		$sql = "1";
		$urlvars = '';
		if(isset($_REQUEST['state_id']) && $_REQUEST['state_id'] != ''){
			$sql.= " AND state_id '".$_REQUEST['state_id']."'";
			$urlvars.= "&state_id=".$_REQUEST['state_id'];
		}

		$sSql = "SELECT COUNT(*) as num FROM state WHERE $sql";
		$records = $this->Common_Model->db_query($sSql);
		$totalrecords = $records[0]['num'];
		if($totalrecords){
			$sSql = "SELECT * FROM state WHERE $sql ORDER BY state_title ASC";
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
		$data['activemenu'] = 'masters';
		$data['activesubmenu'] = 'statemaster';
		$this->load->view('masters/state', $data);
	}

	function edit_state($state_id = 0){
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		if($this->input->post('submitBtn')){
			$this->form_validation->set_rules('state_id', 'State', 'trim|required');
			$this->form_validation->set_error_delimiters('<p class="has-error"><label class="control-label">', '</label></p>');
			if($this->form_validation->run()){
				$data_list = array(
					
					'lwf_percent'					=> $this->input->post('lwf_percent'),
					'lwfemp_share'					=> $this->input->post('lwfemp_share'),
					'lwfdeduction_period'			=> $this->input->post('lwfdeduction_period'),
					'lwfempr_share'					=> $this->input->post('lwfempr_share')
					
				);
				$id = $this->Common_Model->update_records("state", "state_id", $state_id, $data_list);
				$this->session->set_flashdata('success', 'Record Updated successfully.' );
				redirect('masters/state');
			}else{
				$this->session->set_flashdata('error', validation_errors());
			}
		}
		$data['state'] = $this->Common_Model->FetchData("state","*","1 order by state_title ASC");

		$data['rec'] = $this->Common_Model->FetchData("state","*","state_id=".$state_id."");
		$data['activemenu'] = 'masters';
		$data['activesubmenu'] = 'statemaster';
		
		$this->load->view('masters/edit_state', $data);
	}
	
	public function courses(){
		$this->load->helper('url');
		$currentURL = current_url();
		$data = array();
		$sql = "1";
		$queryvars = "";
		if(isset($_REQUEST['course_name']) && $_REQUEST['course_name'] != ''){
			$sql.= " AND course_name LIKE '%".$_REQUEST['course_name']."%'";
			$queryvars.= "&course_name=".$_REQUEST['course_name'];
		}
		
		$rows = $this->Common_Model->FetchRows("classes", "*", "$sql");
		$data['page_num'] = $page_num = isset($_REQUEST['page']) ? $_REQUEST['page'] : 1;
		$this->load->library("Paginator",array("page_num" => $page_num, "num_rows" => $rows));
		$this->paginator->set_Limit(10);

		$range1 = $this->paginator->getRange1();
		$range2 = $this->paginator->getRange2();

		$sql .= " LIMIT ".$range1.', '.$range2;
		$records = $this->Common_Model->db_query("SELECT * FROM classes");

		$paging_info = $this->paginator->DBPagingNav($queryvars, $currentURL);

		$data['tot_page'] = $paging_info[0];
		$data['sPages'] = $paging_info[1];
		$data['rows'] = $rows;
		$data['records'] = $records;
		$data['pagetitle'] = 'OnlineExam - Courses List';
		$data['currentmenu'] = 'masters';
		$data['currentsubmenu'] = 'courses';
		$this->load->view('online-exam-views/master/courses', $data);
	}

	
	
	function allsubjects(){
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$this->load->helper('url');
		$currentURL = current_url();
		$data = array();
		$sql = "1";
		$queryvars = "";
		if(isset($_REQUEST['subject_name']) && $_REQUEST['subject_name'] != ''){
			$sql.= " AND s.subject_name LIKE '%".$_REQUEST['subject_name']."%'";
			$queryvars.= "&subject_name=".$_REQUEST['subject_name'];
		}
		if(isset($_REQUEST['subject_description']) && $_REQUEST['subject_description'] != ''){
			$sql.= " AND s.subject_description LIKE '%".$_REQUEST['subject_description']."%'";
			$queryvars.= "&subject_description=".$_REQUEST['subject_description'];
		}
	    if(isset($_REQUEST['class_id']) && $_REQUEST['class_id'] != ''){
			$sql.= " AND s.class_id = '".$_REQUEST['class_id']."'";
			$queryvars.= "&class_id=".$_REQUEST['class_id'];
		}
		$sql.= " ORDER BY s.subject_id DESC";
		$rows = $this->Common_Model->FetchRows("subjects AS s LEFT JOIN classes AS c ON s.class_id = c.class_id", "*", "$sql");
		$data['page_num'] = $page_num = isset($_REQUEST['page']) ? $_REQUEST['page'] : 1;
		$this->load->library("Paginator",array("page_num" => $page_num, "num_rows" => $rows));
		$this->paginator->set_Limit(10);

		$range1 = $this->paginator->getRange1();
		$range2 = $this->paginator->getRange2();
		$sql .= " LIMIT ".$range1.', '.$range2;
		
		$records = $this->Common_Model->db_query("SELECT * FROM subjects AS s LEFT JOIN classes AS c ON s.class_id = c.class_id");

		$paging_info = $this->paginator->DBPagingNav($queryvars, $currentURL);

		$data['tot_page'] = $paging_info[0];
		$data['sPages'] = $paging_info[1];
		$data['rows'] = $rows;
		$data['records'] = $records;
		$data['pagetitle'] = 'OnlineExam - Subjects List';
		$data['currentmenu'] = 'masters';
		$data['currentsubmenu'] = 'subjects';
		$data['classes'] = $this->Common_Model->FetchData("classes", "*", "1 ORDER BY class_name ASC");
		$this->load->view('online-exam-views/master/subjects', $data);
	}

	function chapters(){
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$this->load->helper('url');
		$currentURL = current_url();
		$data = array();
		$sql = "1";
		$queryvars = "";
		if(isset($_REQUEST['chapter_name']) && $_REQUEST['chapter_name'] != ''){
			$sql.= " AND p.chapter_name LIKE '%".$_REQUEST['chapter_name']."%'";
			$queryvars.= "&chapter_name=".$_REQUEST['chapter_name'];
		}
		if(isset($_REQUEST['chapter_description']) && $_REQUEST['chapter_description'] != ''){
			$sql.= " AND p.chapter_description LIKE '%".$_REQUEST['chapter_description']."%'";
			$queryvars.= "&chapter_description=".$_REQUEST['chapter_description'];
		}
		if(isset($_REQUEST['class_id']) && $_REQUEST['class_id'] != ''){
			$sql.= " AND p.class_id = '".$_REQUEST['class_id']."'";
			$queryvars.= "&class_id=".$_REQUEST['class_id'];
		}
		if(isset($_REQUEST['subject_id']) && $_REQUEST['subject_id'] != ''){
			$sql.= " AND p.subject_id = '".$_REQUEST['subject_id']."'";
			$queryvars.= "&subject_id=".$_REQUEST['subject_id'];
		}
		$sql.= " ORDER BY p.chapter_id DESC";
		$rows = $this->Common_Model->FetchRows("chapters AS p LEFT JOIN subjects AS s ON p.subject_id = s.subject_id LEFT JOIN classes AS c ON p.class_id = c.class_id", "*", "$sql");
		$data['page_num'] = $page_num = isset($_REQUEST['page']) ? $_REQUEST['page'] : 1;
		$this->load->library("Paginator");
		$this->paginator->setparam(array("page_num" => $page_num, "num_rows" => $rows));
		$this->paginator->set_Limit(10);

		$range1 = $this->paginator->getRange1();
		$range2 = $this->paginator->getRange2();

		$sql .= " LIMIT ".$range1.', '.$range2;
		$records = $this->Common_Model->db_query("SELECT * FROM chapters AS p LEFT JOIN subjects AS s ON p.subject_id = s.subject_id LEFT JOIN classes AS c ON p.class_id = c.class_id WHERE ".$sql);

		$paging_info = $this->paginator->DBPagingNav($queryvars, $currentURL);

		$data['tot_page'] = $paging_info[0];
		$data['sPages'] = $paging_info[1];
		$data['rows'] = $rows;
		$data['records'] = $records;
		$data['pagetitle'] = 'Online Exam - Chapters List';
		$data['currentmenu'] = 'masters';
		$data['currentsubmenu'] = 'chapters';
		$data['classes'] = $this->Common_Model->FetchData("classes", "*", "1 ORDER BY class_name ASC");
		$this->load->view('online-exam-views/master/chapters', $data);
	}

	function add_chapter(){
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		if($this->input->post('submitBtn')){
			$this->form_validation->set_rules('chapter_name', 'Chapter Name', 'trim|required');
			$this->form_validation->set_error_delimiters('<p class="has-error"><label class="control-label">', '</label></p>');
			if($this->form_validation->run()){
				$data_list = array(
					"chapter_name"			=> $this->input->post("chapter_name"),
					"chapter_description"	=> addslashes($this->input->post("chapter_description")),
					"subject_id"			=> $this->input->post("subject_id"),
					"class_id"				=> $this->input->post("class_id")
				);
				$this->Common_Model->dbinsertid("chapters", $data_list);
				$this->session->set_flashdata('success', 'Record Added successfully.' );
				redirect($_SERVER['HTTP_REFERER']);
			}else{
				$this->session->set_flashdata("error", validation_errors());
			}
		}
		$data['pagetitle'] = 'YPP Online Exam - Add Chapter';
		$data['currentmenu'] = 'masters';
		$data['currentsubmenu'] = 'chapters';
		$data['classes'] = $this->Common_Model->FetchData("classes", "*", "1 ORDER BY class_name ASC");
		$this->load->view('online-exam-views/master/add_chapter', $data);
	}

	function edit_chapter($chapter_id = 0){
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		if($this->input->post('submitBtn')){
			$this->form_validation->set_rules('chapter_name', 'Chapter Name', 'trim|required');
			$this->form_validation->set_error_delimiters('<p class="has-error"><label class="control-label">', '</label></p>');
			if($this->form_validation->run()){
				$data_list = array(
					"chapter_name"			=> $this->input->post("chapter_name"),
					"chapter_description"	=> addslashes($this->input->post("chapter_description")),
					"subject_id"			=> $this->input->post("subject_id"),
					"class_id"				=> $this->input->post("class_id")
				);
				$this->Common_Model->update_records("chapters", "chapter_id", $chapter_id, $data_list);
				$this->session->set_flashdata('success', 'Record Updated successfully.' );
				redirect($_SERVER['HTTP_REFERER']);
			}else{
				$this->session->set_flashdata("error", validation_errors());
			}
		}
		$data['chapter'] = $chapter =  $this->Common_Model->FetchData("chapters", "*", "chapter_id = ".$chapter_id);
		$data['pagetitle'] = 'YPP Online Exam - Edit Chapter';
		$data['currentmenu'] = 'masters';
		$data['currentsubmenu'] = 'chapters';
		$data['classes'] = $this->Common_Model->FetchData("classes", "*", "1 ORDER BY class_name ASC");
		$data['subjects'] = $this->Common_Model->FetchData("subjects", "*", "class_id = '".$chapter[0]['class_id']."' ORDER BY subject_name ASC");
		$this->load->view('online-exam-views/master/edit_chapter', $data);
	}

	function delete_chapter($chapter_id = 0){
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$this->Common_Model->DelData("chapters", "chapter_id = ".$chapter_id);
		redirect("masters/chapters");
	}

	public function department($did = 0){
		$data = array();
		$data['did'] = $did;
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		if($this->input->post('submitBtn')){
			$this->form_validation->set_rules('department_name', 'Department Name', 'trim|required');
			$this->form_validation->set_rules('shift_id', 'Shift Name', 'trim|required');
			
			//$this->form_validation->set_message('is_unique', 'Duplicate Department.');
			$this->form_validation->set_error_delimiters('<p class="has-error"><label class="control-label">', '</label></p>');
			if($this->form_validation->run()){
				$data_list = array(
					'department_name'       => $this->input->post('department_name'),
					'shift_id'		        => $this->input->post('shift_id'),
					
					'department_active'	    => 'Active'
				);
			if($did > 0){					
					$id = $this->Common_Model->update_records('department', 'did', $did, $data_list);
					$this->session->set_flashdata('success', 'Department Update successfully.' );
				redirect('masters/department');
				}else{
				$id = $this->Common_Model->dbinsertid("department", $data_list);
			}
				$this->session->set_flashdata('success', 'Department Added successfully.' );
				redirect('masters/department');
			}else{
				$this->session->set_flashdata('error', validation_errors());
			}
		}
		if($did > 0){
			$data['btnVal']      = 'Update';
			$data['sectionData'] = $this->Common_Model->FetchData("department", "*", "did = ".$did);
		}
		$data['activemenu'] = 'masters';
		$data['activesubmenu'] = 'department';
		$data['rec'] = $this->Common_Model->FetchData("department A INNER JOIN shift B ON (A.shift_id = B.shift_id)", "A.*,B.shift_name", "did=".$did);
		$data['records'] = $this->Common_Model->FetchData("department A INNER JOIN shift B ON (A.shift_id = B.shift_id)", "A.*,B.shift_name", "1 ORDER BY department_name ASC");
		$data['shift'] = $this->Common_Model->FetchData("shift", "*", "1 ORDER BY shift_id ASC");
		$this->load->view('masters/department', $data);
	}

	function deletedepartment($department_id = 0){
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$this->Common_Model->DelData("department", "did = ".$department_id);
		$this->session->set_flashdata('success', 'Record deleted successfully.' );
		redirect($_SERVER['HTTP_REFERER']);
	}

	public function designation($did = 0){
		$data = array();
		$data['did'] = $did;
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		if($this->input->post('submitBtn')){
			$this->form_validation->set_rules('department_id', 'Department Name', 'trim|required');
			$this->form_validation->set_rules('designation_name', 'Designation Name', 'trim|required');
			
			//$this->form_validation->set_message('is_unique', 'Duplicate Department.');
			$this->form_validation->set_error_delimiters('<p class="has-error"><label class="control-label">', '</label></p>');
			if($this->form_validation->run()){
				$data_list = array(
					'department_id'       => $this->input->post('department_id'),
					'designation_name'    => $this->input->post('designation_name'),
					'designation_active'  => 'Active'
				);
			if($did > 0){					
					$id = $this->Common_Model->update_records('designation', 'designation_id', $did, $data_list);
					$this->session->set_flashdata('success', 'Designation Update successfully.' );
				redirect('masters/designation');
				}else{
				$id = $this->Common_Model->dbinsertid("designation", $data_list);
			}
				$this->session->set_flashdata('success', 'Designation Added successfully.' );
				redirect('masters/designation');
			}else{
				$this->session->set_flashdata('error', validation_errors());
			}
		}
		
		$data['activemenu'] = 'masters';
		$data['activesubmenu'] = 'designation';
		$data['rec'] = $this->Common_Model->FetchData("designation as a LEFT JOIN department as b on a.department_id=b.did", "*", "designation_id=".$did);
		$data['records'] = $this->Common_Model->FetchData("designation as a LEFT JOIN department as b on a.department_id=b.did", "*", "1 ORDER BY designation_name ASC");
		$data['department'] = $this->Common_Model->FetchData("department", "*", "1 ORDER BY did ASC");
		$this->load->view('masters/designation', $data);
	}

	function deletedesignation($designation_id = 0){
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$this->Common_Model->DelData("designation", "designation_id = ".$designation_id);
		$this->session->set_flashdata('success', 'Record deleted successfully.' );
		redirect($_SERVER['HTTP_REFERER']);
	}

	public function wages()
	{
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		if($this->input->post('submitBtn')){
			$this->form_validation->set_rules('wages_name', 'Wages Head', 'trim|required|is_unique[wages.wages_name]');
			$this->form_validation->set_message('is_unique', 'Duplicate Wages Head.');
			$this->form_validation->set_error_delimiters('<p class="has-error"><label class="control-label">', '</label></p>');
			if($this->form_validation->run()){
				$data_list = array(
					'wages_name'       => $this->input->post('wages_name'),
					'wages_active'	    => 'Active'
				);
				$id = $this->Common_Model->dbinsertid("wages", $data_list);
				$this->session->set_flashdata('success', 'Wages Head Added successfully.' );
				redirect('masters/wages');
			}else{
				$this->session->set_flashdata('error', validation_errors());
			}
		}
		$data['activemenu'] = 'masters';
		$data['activesubmenu'] = 'wages';
		$data['records'] = $this->Common_Model->FetchData("wages", "*", "1 ORDER BY sequence ASC");
		$this->load->view('masters/wages', $data);
	}

	function deletewages($wages_id = 0){
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$this->Common_Model->DelData("wages", "wages_id = ".$wages_id);
		$this->session->set_flashdata('success', 'Record deleted successfully.' );
		redirect($_SERVER['HTTP_REFERER']);
	}

	public function units($did=0)
	{
		error_reporting(0);
		$data = array();
		$data['ledger_id'] = $ledger_id = $_GET['ledger_id'];
		if (isset($_GET['did']) && $_GET['did']>0) {
			$did=$_GET['did'];
		}
		$data['did'] = $did;

		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		if($this->input->post('submitBtn')){
			//echo $ledger_id;exit;
			$this->form_validation->set_rules('unit_name', 'Unit', 'trim|required');
			//$this->form_validation->set_message('is_unique', 'Duplicate units .');
			$this->form_validation->set_error_delimiters('<p class="has-error"><label class="control-label">', '</label></p>');
			if($this->form_validation->run()){
				$data_list = array(
					'ledger_id'       	=> $ledger_id,
					'unit_name'       	=> $this->input->post('unit_name'),
					'unit_location'     => $this->input->post('unit_location'),
					'description'       => $this->input->post('description'),
					'unit_active'	    => 'Active',
					'year'				=> $this->input->post('year'),
					'month'				=> $this->input->post('month'),
					'entry_date'		=> date('Y-m-d')
				);
				if ($did > 0) {
					$this->Common_Model->update_records("units","unit_id",$did,$data_list);
					$this->session->set_flashdata('success', 'Unit Updated successfully.' );
				}else{
					$id = $this->Common_Model->dbinsertid("units", $data_list);
					$this->session->set_flashdata('success', 'Unit Added successfully.' );
				}
				
				redirect('masters/units?ledger_id='.$ledger_id.'');
			}else{
				$this->session->set_flashdata('error', validation_errors());
			}
		}
		$data['month'] = isset($_REQUEST['month']) ? $_REQUEST['month'] : date('m', strtotime(date('Y-m')." -1 month"));
		$data['activemenu'] = 'masters';
		$data['submainmenu'] = 'ledgermaster';
		$data['mainmenu'] = 'ledger';
		$data['activesubmenu'] = 'list_ledger';
		$data['records'] = $this->Common_Model->FetchData("units", "*", "ledger_id=".$ledger_id." ORDER BY unit_id ASC");
		$data['rec'] = $this->Common_Model->FetchData("units", "*", "unit_id = ".$did."");
		$this->load->view('masters/units', $data);
	}

	function deleteunits($unit_id = 0){
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$this->Common_Model->DelData("units", "unit_id = ".$unit_id);
		$this->session->set_flashdata('success', 'Record deleted successfully.' );
		redirect($_SERVER['HTTP_REFERER']);
	}

	public function ledger_attributes($did=0)
	{
		error_reporting(0);
		$data = array();
		$data['ledger_id'] = $ledger_id = $_GET['ledger_id'];
		if (isset($_GET['did']) && $_GET['did']>0) {
			$did=$_GET['did'];
		}
		$data['did'] = $did;
		$data['ledger'] = $this->Common_Model->FetchData("ledgers","*","ledger_id=".$ledger_id."");

		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		if($this->input->post('submitBtn')){
			//echo $ledger_id;exit;
			$this->form_validation->set_rules('attribute_name', 'Attribute Name', 'trim|required');
			//$this->form_validation->set_message('is_unique', 'Duplicate units .');
			$this->form_validation->set_error_delimiters('<p class="has-error"><label class="control-label">', '</label></p>');
			if($this->form_validation->run()){
				$data_list = array(
					'ledger_id'       	=> $ledger_id,
					'attribute_name'    => $this->input->post('attribute_name'),
					'quantity'    		=> $this->input->post('quantity'),
					'hsnsac_id'    		=> $this->input->post('hsnsac_id'),
					'per_day'     		=> $this->input->post('per_day'),
					'per_month'       	=> $this->input->post('per_month'),
					'thirty_one'       	=> $this->input->post('thirty_one'),
					'thirty'       		=> $this->input->post('thirty'),
					'twenty_eight'      => $this->input->post('twenty_eight'),
					'twenty_nine'       	=> $this->input->post('twenty_nine'),
					'updt'       		=> date('Y-m-d')
					
				);
				if ($did > 0) {
					$this->Common_Model->update_records("ledger_attributes","attribute_id",$did,$data_list);
					$this->session->set_flashdata('success', 'Attribute Updated successfully.' );
				}else{
					$id = $this->Common_Model->dbinsertid("ledger_attributes", $data_list);
					$this->session->set_flashdata('success', 'Attribute Added successfully.' );
				}
				
				redirect('masters/ledger_attributes?ledger_id='.$ledger_id.'');
			}else{
				$this->session->set_flashdata('error', validation_errors());
			}
		}
		$data['activemenu'] = 'masters';
		$data['submainmenu'] = 'ledgermaster';
		$data['mainmenu'] = 'ledger';
		$data['activesubmenu'] = 'list_ledger';
		$data['records'] = $this->Common_Model->FetchData("ledger_attributes as a LEFT JOIN hsnsac as b on a.hsnsac_id=b.hsnsac_id", "*", "a.ledger_id=".$ledger_id." ORDER BY a.attribute_id DESC");
		$data['rec'] = $this->Common_Model->FetchData("ledger_attributes", "*", "attribute_id = ".$did."");
		$data['hsnsac'] = $this->Common_Model->FetchData("hsnsac","*","type='Service' order by hsnsac_id");
		$this->load->view('masters/ledger_attributes', $data);
	}

	function deleteledger_attributes($attribute_id = 0){
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$this->Common_Model->DelData("ledger_attributes", "attribute_id = ".$attribute_id);
		$this->session->set_flashdata('success', 'Record deleted successfully.' );
		redirect($_SERVER['HTTP_REFERER']);
	}

	public function hsnsac($did = 0)
	{
		$data = array();
		$data['did'] = $did;
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		if($this->input->post('submitBtn')){
			$this->form_validation->set_rules('hsnsac', 'HSN/SAC', 'trim|required');
			$this->form_validation->set_error_delimiters('<p class="has-error"><label class="control-label">', '</label></p>');
			if($this->form_validation->run()){
				$data_list = array(
					'hsnsac'		=> $this->input->post('hsnsac'),
					'short_name'	=> $this->input->post('short_name'),
					'sgst'			=> $this->input->post('sgst'),
					'cgst'			=> $this->input->post('cgst'),
					'igst'			=> $this->input->post('igst'),
					'type'			=> $this->input->post('type'),
					'uqc_unit'		=> $this->input->post('uqc_unit'),
					'cess'			=> $this->input->post('cess'),
					
				);
				if($did > 0){					
					$id = $this->Common_Model->update_records('hsnsac', 'hsnsac_id', $did, $data_list);
					$this->session->set_flashdata('success', 'HSN/SAC Update successfully.' );
				redirect('masters/hsnsac');
				}else{
				$id = $this->Common_Model->dbinsertid("hsnsac", $data_list);
				}

				$this->session->set_flashdata('success', 'HSN/SAC Added successfully.' );
				redirect('masters/hsnsac');
			}else{
				$this->session->set_flashdata('error', validation_errors());
			}
		}
		$data['activemenu'] = 'masters';
		$data['submainmenu'] = 'inventorymaster';
		$data['activesubmenu'] = 'hsnsac';
		$data['hsnsac'] = $this->Common_Model->FetchData("hsnsac", "*", "1 ORDER BY hsnsac_id ASC");
		$data['rec'] = $this->Common_Model->FetchData("hsnsac", "*", "hsnsac_id = $did");
		$this->load->view('masters/hsnsac', $data);
	}

	function deletehsnsac($hsnsac_id = 0){
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$this->Common_Model->DelData("hsnsac", "hsnsac_id = ".$hsnsac_id);
		$this->session->set_flashdata('success', 'Record deleted successfully.' );
		redirect($_SERVER['HTTP_REFERER']);
	}

	public function group($did = 0)
	{
		$data = array();
		$data['did'] = $did;
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		if($this->input->post('submitBtn')){
			$this->form_validation->set_rules('group_name', 'Group Name', 'trim|required');
			$this->form_validation->set_rules('subcategory_id', 'Sub Category', 'trim|required');
			$this->form_validation->set_error_delimiters('<p class="has-error"><label class="control-label">', '</label></p>');
			if($this->form_validation->run()){
				$chksubcat = $this->Common_Model->FetchData("under_group","*","subcategory_id=".$this->input->post('subcategory_id')." AND group_name='".$this->input->post('group_name')."'");
				if ($chksubcat && $did < 1) {
					$this->session->set_flashdata('error', 'Group Already Exists!' );
					redirect('masters/group');
				}else{


				$data_list = array(
					'subcategory_id'	=> $this->input->post('subcategory_id'),
					'group_name'		=> $this->input->post('group_name'),
					
					
				);
				if($did > 0){					
					$id = $this->Common_Model->update_records('under_group', 'group_id', $did, $data_list);
					$this->session->set_flashdata('success', 'Group Update successfully.' );
				redirect('masters/group');
				}else{
				    $subcat = $this->Common_Model->FetchData("subcategory","*","subcategory_id=".$this->input->post('subcategory_id'));

					if ($subcat) {
						$grp = $this->Common_Model->FetchData("under_group","*","subcategory_id=".$this->input->post('subcategory_id')." ORDER BY group_id DESC LIMIT 1");
						if ($grp && $grp[0]['accode']>0) {
			    				$tempId = $grp[0]['accode'];
			    				$accode = ($tempId +  1) ;
			    				if ($accode > $subcat[0]['code_to']) {
			    					$this->session->set_flashdata('error', 'Group Creation Limit Exceeds!' );
									redirect('masters/group');
			    				}
			    			}else {
			    				$tempId = $subcat[0]['code_from'];
			    				$accode = ($tempId);
			    				
			    			}

			    		$data_list['accode'] = $accode;	
			    		
					}
				$id = $this->Common_Model->dbinsertid("under_group", $data_list);
				}

				$this->session->set_flashdata('success', 'Group Added successfully.' );
				redirect('masters/group');
			}
			}else{
				$this->session->set_flashdata('error', validation_errors());
			}
		}
		$data['activemenu'] = 'masters';
		$data['activesubmenu'] = 'group';
		$data['subcategory'] = $this->Common_Model->FetchData("subcategory", "*", "1 ORDER BY subcategory_id ASC");
		$data['group'] = $this->Common_Model->FetchData("under_group as a LEFT JOIN subcategory as b on a.subcategory_id=b.subcategory_id", "*", "1 ORDER BY a.subcategory_id DESC");
		$data['rec'] = $this->Common_Model->FetchData("under_group", "*", "group_id = $did");
		$this->load->view('masters/group', $data);
	}

	function deletegroup($group_id = 0){
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$this->Common_Model->DelData("group", "group_id = ".$group_id);
		$this->session->set_flashdata('success', 'Record deleted successfully.' );
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	public function subcategory($did = 0)
	{
		$data = array();
		$data['did'] = $did;
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		if($this->input->post('submitBtn')){
			$this->form_validation->set_rules('category_id', 'Category', 'trim|required');
			$this->form_validation->set_rules('subcategory_name', 'Subcategory Name', 'trim|required');
			$this->form_validation->set_error_delimiters('<p class="has-error"><label class="control-label">', '</label></p>');
			if($this->form_validation->run()){

				$chksubcat = $this->Common_Model->FetchData("subcategory","*","category_id=".$this->input->post('category_id')." AND subcategory_name='".$this->input->post('subcategory_name')."'");
				if ($chksubcat && $did < 1) {
					$this->session->set_flashdata('error', 'Sub Category Already Exists!' );
					redirect('masters/subcategory');
				}else{


				$data_list = array(
					'category_id'			=> $this->input->post('category_id'),
					'subcategory_name'		=> $this->input->post('subcategory_name'),
					
				);
				if($did > 0){					
					$id = $this->Common_Model->update_records('subcategory', 'subcategory_id', $did, $data_list);
					$this->session->set_flashdata('success', 'Sub Category Update successfully.' );
				redirect('masters/subcategory');
				}else{
				    $category = $this->Common_Model->FetchData("category","*","category_id=".$this->input->post('category_id'));

					if ($category) {
						$subcat = $this->Common_Model->FetchData("subcategory","*","category_id=".$this->input->post('category_id')." ORDER BY subcategory_id DESC LIMIT 1");
						if ($subcat && $subcat[0]['code_from']>0) {
			    				$tempId = $subcat[0]['code_from'];
			    				$code_from = ($tempId +  100) ;
			    				$code_to = ($code_from +  98) ;
			    			}else {
			    				$tempId = $category[0]['account_code'];
			    				$code_from = ($tempId +  1) ;
			    				$code_to = ($code_from +  98) ;
			    			}

			    		$data_list['code_from'] = $code_from;	
			    		$data_list['code_to']   = $code_to;	
					}
				$subcategory_id = $this->Common_Model->dbinsertid("subcategory", $data_list);
				}

				$this->session->set_flashdata('success', 'Sub Category Added successfully.' );
				redirect('masters/subcategory');
			}
			}else{
				$this->session->set_flashdata('error', validation_errors());
			}
		}
		$data['activemenu'] = 'masters';
		$data['activesubmenu'] = 'subcategory';
		$data['category'] = $this->Common_Model->FetchData("category", "*", "1 ORDER BY category_id ASC");
		$data['subcategory'] = $this->Common_Model->FetchData("subcategory as a LEFT JOIN category as b on a.category_id=b.category_id", "*", "1 ORDER BY a.subcategory_id ASC");
		$data['rec'] = $this->Common_Model->FetchData("subcategory", "*", "subcategory_id = $did");
		$this->load->view('masters/subcategory', $data);
	}

	function deletesubcategory($subcategory_id = 0){
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$this->Common_Model->DelData("subcategory", "subcategory_id = ".$subcategory_id);
		$this->session->set_flashdata('success', 'Record deleted successfully.' );
		redirect($_SERVER['HTTP_REFERER']);
	}

	public function payment_type($pid=0)
	{
		error_reporting(0);
		$data = array();
		$data['pid'] = $pid;
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		if($this->input->post('submitBtn')){
			$this->form_validation->set_rules('ptype_name', 'Payment Type', 'trim|required');
			//$this->form_validation->set_message('is_unique', 'Duplicate units .');
			$this->form_validation->set_error_delimiters('<p class="has-error"><label class="control-label">', '</label></p>');
			if($this->form_validation->run()){
				$data_list = array(
					'ptype_name'       	=> $this->input->post('ptype_name'),
					'description'       => $this->input->post('description'),
					'ptype_active'	    => 'Active'
				);
				if ($pid > 0) {
					$this->Common_Model->update_records("payment_type","ptype_id",$pid,$data_list);
					$this->session->set_flashdata('success', 'Data Updated successfully.' );
				}else{
					$id = $this->Common_Model->dbinsertid("payment_type", $data_list);
					$this->session->set_flashdata('success', 'Data Added successfully.' );
				}
				
				redirect('masters/payment_type');
			}else{
				$this->session->set_flashdata('error', validation_errors());
			}
		}
		$data['activemenu'] = 'masters';
		$data['activesubmenu'] = 'payment_type';
		$data['records'] = $this->Common_Model->FetchData("payment_type", "*", "1 ORDER BY ptype_id ASC");
		$data['rec'] = $this->Common_Model->FetchData("payment_type", "*", "ptype_id = ".$pid."");
		$this->load->view('masters/payment_type', $data);
	}

	function deletepayment_type($pid = 0){
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$this->Common_Model->DelData("payment_type", "ptype_id = ".$pid);
		$this->session->set_flashdata('success', 'Record deleted successfully.' );
		redirect($_SERVER['HTTP_REFERER']);
	}

	public function list_ledger()
	{
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		
		$data['per_page'] = $per_page = isset($_REQUEST['per_page']) ? $_REQUEST['per_page'] : 100;
		$data['page'] = $page = isset($_REQUEST['page']) ? $_REQUEST['page'] : '1';
		$this->load->helper('url');
		$currentURL = current_url();
		$sql = "1 AND ledger_alias !=''";
		$urlvars = '';
		
		if(isset($_REQUEST['ledger_name']) && $_REQUEST['ledger_name'] != ''){
			$sql.= " AND ledger_name LIKE '%".$_REQUEST['ledger_name']."%'";
			$urlvars.= "&ledger_name=".$_REQUEST['ledger_name'];
		}

		if(isset($_REQUEST['account_group']) && $_REQUEST['account_group'] != ''){
			$sql.= " AND acount_group = '".$_REQUEST['account_group']."'";
			$urlvars.= "&acount_group=".$_REQUEST['account_group'];
		}
		
		$sSql = "SELECT COUNT(*) as num FROM ledgers as a WHERE $sql";
		$records = $this->Common_Model->db_query($sSql);
		$totalrecords = $records[0]['num'];
		if($totalrecords){
			$sSql = "SELECT * FROM ledgers as a LEFT JOIN state as b on a.ledger_state=b.state_id LEFT JOIN under_group as c on a.acount_group=c.group_id WHERE $sql ORDER BY a.ledger_name ASC";
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

		if ($this->input->post('downloadBtn')) {
			
			$records = $this->Common_Model->db_query("SELECT * FROM ledgers as a LEFT JOIN state as b on a.ledger_state=b.state_id LEFT JOIN under_group as c on a.acount_group=c.group_id WHERE $sql ORDER BY a.ledger_name DESC ");
			$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		// Set document properties
		$spreadsheet->getProperties()->setCreator('GLOSENT')
					->setLastModifiedBy($this->session->userdata('firstname').' '.$this->session->userdata('lastname'))
					->setTitle('Ledger Report')
					->setSubject('Ledger Report')
					->setDescription('');
		// add style to the header
		$styleArray = array(
			'font' => array(
				'bold' => true,
			),
			'alignment' => array(
				'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
				'vertical'   => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
			),
			'borders' => array(
				'bottom' => array(
					'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
					'color' => array('rgb' => '333333'),
				),
			),
			'fill' => array(
				'type'       => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_GRADIENT_LINEAR,
				'rotation'   => 90,
				'startcolor' => array('rgb' => '0d0d0d'),
				'endColor'   => array('rgb' => 'f2f2f2'),
			),
		);
		$cellstyleArray = array(
			'borders' => array(
				'allBorders' => [
		            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
		            'color' => ['rgb' => '333333'],
		        ],
			)
		);
		$spreadsheet->getActiveSheet()->getStyle('A1:G1')->applyFromArray($styleArray);
		$spreadsheet->getActiveSheet()->getStyle('A2:G2')->applyFromArray($styleArray);
		$spreadsheet->getActiveSheet()->mergeCells("A1:G1");
		$spreadsheet->getActiveSheet()->mergeCells("A2:G2");
		// auto fit column to content
		foreach(range('A', 'G') as $columnID) {
			$spreadsheet->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
		}
		
		// set the names of header cells
		$sheet->setCellValue('A1', 'GLOSENT');
		$sheet->setCellValue('A2', 'Entry Report');

		$sheet->setCellValue('A3', 'ID');
		$sheet->setCellValue('B3', 'Ledger Name');
		$sheet->setCellValue('C3', 'Account Group');
		$sheet->setCellValue('D3', 'Email');
		$sheet->setCellValue('E3', 'Mobile');
		$sheet->setCellValue('F3', 'GST');
		$sheet->setCellValue('G3', 'State');


		$totaldebit = 0;
		$totalcredit = 0;
		$x = 4;
		if($records){
			for($i=0;$i<count($records);$i++){
            	
				$sheet->setCellValueExplicit('A'.$x, $records[$i]['ledger_id'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
				$sheet->setCellValue('B'.$x, $records[$i]['ledger_name']);
				$sheet->setCellValue('C'.$x, $records[$i]['group_name']);
				$sheet->setCellValue('D'.$x, $records[$i]['email']);
				$sheet->setCellValue('E'.$x, $records[$i]['mobile']);
				$sheet->setCellValue('F'.$x, $records[$i]['gst_no']);
				$sheet->setCellValue('G'.$x, $records[$i]['state_title']);
	
				$x++;
			}
		}

		$spreadsheet->getActiveSheet()->getStyle('A4:G'.$x)->applyFromArray($cellstyleArray);
		$writer = new Xlsx($spreadsheet);
		header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Ledger Report'.time().'.xlsx"');
        $writer->save('php://output');
        exit;
    }
		
		//$data['records'] = $this->Common_Model->FetchData("ledgers as a LEFT JOIN state as b on a.ledger_state=b.state_id LEFT JOIN under_group as c on a.acount_group=c.group_id","*","1 ORDER BY a.ledger_name ASC");
		$data['accountgroup'] = $this->Common_Model->FetchData("under_group","*","1 ORDER BY group_name ASC");
		$data['activemenu'] = 'masters';
		$data['submainmenu'] = 'ledgermaster';
		$data['mainmenu'] = 'ledger';
		$data['activesubmenu'] = 'list_ledger';
		$this->load->view('masters/list_ledger', $data);
	}

	public function view_ledger($ledger_id = 0)
	{
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		
		$data['rec'] = $this->Common_Model->FetchData("ledgers as a LEFT JOIN under_group as b on a.acount_group=b.group_id LEFT JOIN state as e on a.ledger_state=e.state_id LEFT JOIN payment_type as p on a.payment_type=p.ptype_id","*","ledger_id=".$ledger_id."");
		$data['activemenu'] = 'masters';
		$data['submainmenu'] = 'ledgermaster';
		$data['mainmenu'] = 'ledger';
		$data['activesubmenu'] = 'list_ledger';
		$this->load->view('masters/view_ledger', $data);
	}

	public function add_ledger()
	{
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		if($this->input->post('submitBtn')){

			$this->form_validation->set_rules('ledger_name', 'Ledger Name', 'trim|required');
			$this->form_validation->set_error_delimiters('<p class="has-error"><label class="control-label">', '</label></p>');
			if($this->form_validation->run()){
			    $ledger = $this->Common_Model->FetchData("ledgers","*","acount_group !='50' AND acount_group !='51' AND emp_id=0 ORDER BY ledger_alias DESC LIMIT 1");
			    $gcat = 'GL';
			    
    			if ($ledger) {
    
    				$tempId = explode($gcat,$ledger[0]['ledger_alias']);
    				$rc = (end($tempId) +  1) ;
    				$newtempId = str_pad($rc, 6, '0', STR_PAD_LEFT);
    				$data['ledger_alias'] = $ledger_alias = $gcat.str_pad($newtempId, 6, '0', STR_PAD_LEFT);
    			}else {
    				$data['ledger_alias'] = $ledger_alias = $gcat.str_pad('1', 6, '0', STR_PAD_LEFT);
    			}
			    
			    
				$data_list = array(
					'ledger_name'		=> $this->input->post('ledger_name'),
					'ledger_alias'		=> $ledger_alias,
					'station'			=> $this->input->post('station'),
                //  'sezunit'			=> $this->input->post('sezunit'),
					'gst_applicable'	=> 'Yes',
					'acount_group'		=> $this->input->post('acount_group'),
					'opening_balance'	=> $this->input->post('opening_balance'),
					'balance_type'		=> $this->input->post('balance_type'),
					'ledger_type'		=> 'REGISTERED',
					'bankorcashac'		=> $this->input->post('bankorcashac')!=''?$this->input->post('bankorcashac'):'No',
				//	'reconciliation'		=> $this->input->post('reconciliation'),
					'inv_isaffect'		=> $this->input->post('inv_isaffect'),
					'hsnsaccode'		=> $this->input->post('hsnsaccode'),
					'gstperc'			=> $this->input->post('gstperc'),
					'ledger_isaprv'		=> '1',

				);
				
				$id = $this->Common_Model->dbinsertid("ledgers",$data_list);


				$this->session->set_flashdata('success', 'Ledger Added successfully.' );
				redirect('masters/list_ledger');
			}else{
				$this->session->set_flashdata('error', validation_errors());
				redirect('masters/list_ledger');
			}
		}
		$data['undergroup'] = $this->Common_Model->FetchData("under_group","*","1 ORDER BY group_name ASC");
		
		$data['state'] = $this->Common_Model->FetchData("state","*","1 ORDER BY state_title ASC");
		$data['gst'] = $this->Common_Model->FetchData("company_gst","*","1 ORDER BY gst_id ASC");
		$data['activemenu'] = 'masters';
		$data['submainmenu'] = 'ledgermaster';
		$data['mainmenu'] = 'ledger';
		$data['activesubmenu'] = 'add_ledger';
		$this->load->view('masters/add_ledger', $data);
	}

	public function edit_ledger($ledger_id = 0)
	{
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		if($this->input->post('submitBtn')){

			$this->form_validation->set_rules('ledger_name', 'Ledger Name', 'trim|required');
			$this->form_validation->set_error_delimiters('<p class="has-error"><label class="control-label">', '</label></p>');
			if($this->form_validation->run()){
				$data_list = array(
					'ledger_name'		=> $this->input->post('ledger_name'),
					'station'			=> $this->input->post('station'),
                //  'sezunit'			=> $this->input->post('sezunit'),
					'gst_applicable'	=> 'Yes',
					'acount_group'		=> $this->input->post('acount_group'),
					'opening_balance'	=> $this->input->post('opening_balance'),
					'balance_type'		=> $this->input->post('balance_type'),
					'bankorcashac'		=> $this->input->post('bankorcashac')!=''?$this->input->post('bankorcashac'):'No',
				//	'reconciliation'		=> $this->input->post('reconciliation'),
					'inv_isaffect'		=> $this->input->post('inv_isaffect'),
					'hsnsaccode'		=> $this->input->post('hsnsaccode'),
					'gstperc'			=> $this->input->post('gstperc'),

				);
    $id = $this->Common_Model->update_records("ledgers","ledger_id", $ledger_id, $data_list);
				$this->session->set_flashdata('success', 'Ledger Updated successfully.' );
				redirect('masters/view_ledger/'.$ledger_id);
			}else{
				$this->session->set_flashdata('error', validation_errors());
				redirect('masters/view_ledger/'.$ledger_id);
			}
		}
		$data['undergroup'] = $this->Common_Model->FetchData("under_group","*","1 ORDER BY group_name ASC");
		
		$data['state'] = $this->Common_Model->FetchData("state","*","1 ORDER BY state_title ASC");
		$data['rec'] = $this->Common_Model->FetchData("ledgers","*","ledger_id=".$ledger_id."");
		$data['gst'] = $this->Common_Model->FetchData("company_gst","*","1 ORDER BY gst_id ASC");
		$data['activemenu'] = 'masters';
		$data['submainmenu'] = 'ledgermaster';
		$data['mainmenu'] = 'ledger';
		$data['activesubmenu'] = 'list_ledger';
		$this->load->view('masters/edit_ledger', $data);
	}
	
	public function ledger_utensils()
	{	
		$ledger_id = $_GET['ledger_id'];
		
		
		$data = array();
		$data['ledger_id'] = $ledger_id;
		
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		if($this->input->post('submitBtn')){
			$ledgerId = $this->input->post('ledger_id');
			$this->form_validation->set_rules('ledger_id', 'Ledger Id', 'trim|required');
			$this->form_validation->set_error_delimiters('<p class="has-error"><label class="control-label">', '</label></p>');
			if($this->form_validation->run()){
				$data_list = array(
					
					'utensiladded_on'	=> $this->input->post('utensiladded_on'),
					'remarks'			=> $this->input->post('remarks'),
					'totalamount'		=> $this->input->post('totalamount'),
					'ledger_id'			=> $ledgerId,
					'utensiladded_by'			=> $this->session->userdata('user_id'),
	
				);

				$utensil_id = $this->Common_Model->dbinsertid("ledger_utensils", $data_list);

				if ($utensil_id) {
					foreach ($this->input->post('item_id[]') as $key => $value) {
					$itemtotal = 0;
					
						$this->Common_Model->dbinsertid("ledgerutensil_items", 
							array(
								"item_id" 		=> $this->input->post("item_id[".$key."]"),
								"utensil_id" 	=> $utensil_id,
								"item_quantity" => $this->input->post("item_quantity[".$key."]"),
								"item_rate" 	=> $this->input->post("item_rate[".$key."]"),
								"item_amount" 	=> $this->input->post("item_amount[".$key."]"),
								
							)
						);

						$this->Common_Model->db_query("UPDATE assets SET item_qty = item_qty -".$this->input->post("item_quantity[".$key."]")." WHERE asset_id ='".$this->input->post("item_id[".$key."]")."'");

						
					}
				}


				$this->session->set_flashdata('success', 'Data Added successfully.' );
				redirect('masters/ledger_utensils?ledger_id='.$ledgerId);
			}else{
				$this->session->set_flashdata('error', validation_errors());
				redirect('masters/ledger_utensils?ledger_id='.$ledgerId);
			}
		}
		
		$data['activemenu'] = 'masters';
		$data['submainmenu'] = 'ledgermaster';
		$data['mainmenu'] = 'ledger';
		$data['activesubmenu'] = 'list_ledger';
		$data['ledger'] = $this->Common_Model->FetchData("ledgers as a LEFT JOIN under_group as b on a.acount_group=b.group_id", "*", "ledger_id = $ledger_id");
		$data['records'] = $this->Common_Model->FetchData("ledger_utensils as a LEFT JOIN users AS b on a.utensiladded_by=b.user_id", "*", "a.ledger_id=".$ledger_id." ORDER BY a.utensil_id DESC");
		//$data['rec'] = $this->Common_Model->FetchData("ledger_utensils", "*", "workorder_id = $did");
		$this->load->view('masters/ledger_utensils', $data);
	}

	public function ledger_utensilsprint(){
		$ledger_id = $_GET['ledger_id'];
		$did = $_GET['did'];
		$data = array();
		$data['ledger_id'] = $ledger_id;
		$data['rec'] = $this->Common_Model->FetchData("ledger_utensils as a LEFT JOIN users AS b on a.utensiladded_by=b.user_id LEFT JOIN ledgers AS c on a.ledger_id=c.ledger_id", "*", "a.ledger_id=".$ledger_id." AND a.utensil_id=".$did);

		$data['items'] = $this->Common_Model->FetchData("ledgerutensil_items as a LEFT JOIN assets as b on a.item_id=b.asset_id","*","a.utensil_id=".$did."");

		$html = $this->load->view('masters/pdf_utensilsprint', $data, TRUE);
		


			$this->load->library('Pdf');
			$pdf = new Pdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
			$pdf->SetCreator(PDF_CREATOR);
			$pdf->SetAuthor('TF&MS');
			$pdf->SetTitle('Techno');
			$pdf->SetSubject('Techno');

			$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
			$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
			$pdf->SetMargins(5, 5, 5, true);
			$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
			$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

			$pdf->SetAutoPageBreak(TRUE, 17);
			// set image scale factor
			$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
			$pdf->AddPage('P', 'A4', true, true);

			$pdf->SetMargins(5, 5, 5, true);

			$pdf->SetFont('helvetica', '', 10);

			$pdf->setFontSubsetting(false);
			$pdf->writeHTML($html, true, false, false, false, '');
			date_default_timezone_set("Asia/Kolkata");
			$filename = date("YmdHis").'.pdf';
			$pdf->Output($filename, 'I');


	}

	public function ledger_utensilsedit()
	{	
		$ledger_id = $_GET['ledger_id'];
		$did = $_GET['did'];
		$data = array();
		$data['ledger_id'] = $ledger_id;

		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		if($this->input->post('submitBtn')){
			$ledgerId = $this->input->post('ledger_id');
			$this->form_validation->set_rules('ledger_id', 'Ledger Id', 'trim|required');
			$this->form_validation->set_error_delimiters('<p class="has-error"><label class="control-label">', '</label></p>');
			if($this->form_validation->run()){
				$data_list = array(
					
					'utensiladded_on'	=> $this->input->post('utensiladded_on'),
					'remarks'			=> $this->input->post('remarks'),
					'totalamount'		=> $this->input->post('totalamount'),
					'ledger_id'			=> $ledgerId,
					'utensiladded_by'			=> $this->session->userdata('user_id'),
	
				);

				 $this->Common_Model->update_records("ledger_utensils","utensil_id",$did, $data_list);

				if ($did) {

					$items = $this->Common_Model->FetchData("ledgerutensil_items","*","utensil_id=".$did."");
					//print_r($items);exit;
					if ($items) { for ($i=0; $i < count($items) ; $i++) { 
						$this->Common_Model->db_query("UPDATE assets SET item_qty = item_qty +".$items[$i]['item_quantity']." WHERE asset_id ='".$items[$i]['item_id']."'");
					}}

					$this->Common_Model->DelData("ledgerutensil_items","utensil_id=".$did."");

					foreach ($this->input->post('item_id[]') as $key => $value) {
					$itemtotal = 0;
					
						$this->Common_Model->dbinsertid("ledgerutensil_items", 
							array(
								"item_id" 		=> $this->input->post("item_id[".$key."]"),
								"utensil_id" 	=> $did,
								"item_quantity" => $this->input->post("item_quantity[".$key."]"),
								"item_rate" 	=> $this->input->post("item_rate[".$key."]"),
								"item_amount" 	=> $this->input->post("item_amount[".$key."]"),
								
							)
						);

						$this->Common_Model->db_query("UPDATE assets SET item_qty = item_qty -".$this->input->post("item_quantity[".$key."]")." WHERE asset_id ='".$this->input->post("item_id[".$key."]")."'");

						
					}
				}


				$this->session->set_flashdata('success', 'Data Updated successfully.' );
				redirect('masters/ledger_utensils?ledger_id='.$ledgerId);
			}else{
				$this->session->set_flashdata('error', validation_errors());
				redirect('masters/ledger_utensils?ledger_id='.$ledgerId);
			}
		}






		$data['activemenu'] = 'masters';
		$data['submainmenu'] = 'ledgermaster';
		$data['mainmenu'] = 'ledger';
		$data['activesubmenu'] = 'list_ledger';
		$data['ledger'] = $this->Common_Model->FetchData("ledgers as a LEFT JOIN under_group as b on a.acount_group=b.group_id", "*", "ledger_id = $ledger_id");
		
		$data['rec'] = $this->Common_Model->FetchData("ledger_utensils", "*", "ledger_id=".$ledger_id." AND utensil_id=".$did);
		$data['items'] = $this->Common_Model->FetchData("ledgerutensil_items","*","utensil_id=".$did."");
		$data['assets'] = $this->Common_Model->FetchData("assets","*","item_type='Utensil' order by item_name ASC");
		$this->load->view('masters/ledger_utensilsedit', $data);
	}

	function get_utensils(){
		$assets = $this->Common_Model->FetchData("assets","*","item_type='Utensil' order by item_name ASC");
		$html='<option value="">Select</option>';
		if ($assets) {for ($i=0; $i <count($assets) ; $i++) { 
			$html.='<option value="'.$assets[$i]['asset_id'].'">'.$assets[$i]['item_name'].'</option>';
		}}

		echo $html;
	}

	
	
	function get_utensilsRate(){
		$assets = $this->Common_Model->FetchData("assets","*","asset_id=".$this->input->post('asset_id')."");
		

		echo $assets[0]['item_price'];
	}
	
	public function ledger_workorder($did=0)
	{	
		$ledger_id = $_GET['ledger_id'];
		if (isset($_GET['did']) && $_GET['did']>0) {
			$did=$_GET['did'];
		}
		
		$data = array();
		$data['ledger_id'] = $ledger_id;
		$data['did'] = $did;
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		if($this->input->post('submitBtn')){
			$ledgerId = $this->input->post('ledger_id');
			$this->form_validation->set_rules('ledger_id', 'Ledger Id', 'trim|required');
			$this->form_validation->set_error_delimiters('<p class="has-error"><label class="control-label">', '</label></p>');
			if($this->form_validation->run()){
				$data_list = array(
					'wo_no'						=> $this->input->post('wo_no'),
					'wo_date'					=> $this->input->post('wo_date'),
					'woexp_date'			=> $this->input->post('woexp_date'),
					'security_amt'		=> $this->input->post('security_amt'),
					'deposit_mode'		=> $this->input->post('deposit_mode'),
					'remarks'					=> $this->input->post('remarks'),
					'ledger_id'				=> $ledgerId,
					'default_wo'			=> 'Active',
					'workorder_entry'	=> date('Y-m-d H:i:s'),
					
				);
				if($did > 0){					
					$id = $this->Common_Model->update_records('ledger_workorder', 'workorder_id', $did, $data_list);
					$this->session->set_flashdata('success', 'Work Order Update successfully.' );
				redirect('masters/ledger_workorder?ledger_id='.$ledgerId);
				}else{
				$id = $this->Common_Model->dbinsertid("ledger_workorder", $data_list);
				}

				$this->session->set_flashdata('success', 'Work Order Added successfully.' );
				redirect('masters/ledger_workorder?ledger_id='.$ledgerId);
			}else{
				$this->session->set_flashdata('error', validation_errors());
				redirect('masters/ledger_workorder?ledger_id='.$ledgerId);
			}
		}
		if($this->input->post('default_wo')){
			$this->Common_Model->db_query("UPDATE ledger_workorder SET default_wo = ''");
			$this->Common_Model->db_query("UPDATE ledger_workorder SET default_wo = 'Active' WHERE workorder_id = ".$this->input->post('default_wo'));
			
		}
		$data['activemenu'] = 'masters';
		$data['submainmenu'] = 'ledgermaster';
		$data['mainmenu'] = 'ledger';
		$data['activesubmenu'] = 'list_ledger';
		$data['ledger'] = $this->Common_Model->FetchData("ledgers as a LEFT JOIN under_group as b on a.acount_group=b.group_id", "*", "ledger_id = $ledger_id");
		$data['records'] = $this->Common_Model->FetchData("ledger_workorder", "*", "ledger_id=".$ledger_id." ORDER BY workorder_id DESC");
		$data['rec'] = $this->Common_Model->FetchData("ledger_workorder", "*", "workorder_id = $did");
		$this->load->view('masters/ledger_workorder', $data);
	}

	function deletework_order($did = 0){
		
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$this->Common_Model->DelData("ledger_workorder", "workorder_id = ".$did);
		$this->session->set_flashdata('success', 'Record deleted successfully.' );
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	public function gstmaster($did = 0){
		$data = array();
		$data['did'] = $did;
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		if($this->input->post('submitBtn')){
			if ($did > 0) {
				$this->form_validation->set_rules('gst_no', 'GST No.', 'trim|required');
			}else{
				$this->form_validation->set_rules('gst_no', 'GST No.', 'trim|required|is_unique[company_gst.gst_no]');
			}
			$this->form_validation->set_message('is_unique', 'Duplicate GST No.');
			$this->form_validation->set_error_delimiters('<p class="has-error"><label class="control-label">', '</label></p>');
			if($this->form_validation->run()){
				$data_list = array(
					'gst_no'       		=> $this->input->post('gst_no'),
					'gst_head'		    => $this->input->post('gst_head'),
					'gstname'		    => $this->input->post('gstname'),
					'gstaddress'		=> $this->input->post('gstaddress'),
					'gstpin'		    => $this->input->post('gstpin'),
					'gststate'		    => $this->input->post('gststate'),
					'gst_active'	    => 'Active'
				);
			if($did > 0){					
					$id = $this->Common_Model->update_records('company_gst', 'gst_id', $did, $data_list);
					$this->session->set_flashdata('success', 'GST Update successfully.' );
				redirect('masters/gstmaster');
				}else{
				$id = $this->Common_Model->dbinsertid("company_gst", $data_list);
			}
				$this->session->set_flashdata('success', 'GST Added successfully.' );
				redirect('masters/gstmaster');
			}else{
				$this->session->set_flashdata('error', validation_errors());
			}
		}
		if($did > 0){
			$data['btnVal']      = 'Update';
			$data['sectionData'] = $this->Common_Model->FetchData("company_gst", "*", "gst_id = ".$did);
		}else{
			$data['btnVal']      = 'Submit';
		}
		$data['activemenu'] = 'masters';
		$data['activesubmenu'] = 'gstmaster';
		$data['rec'] = $this->Common_Model->FetchData("company_gst","*", "gst_id=".$did);
		
		$data['records'] = $this->Common_Model->FetchData("company_gst as a LEFT JOIN state as b on a.gststate=b.state_id", "*", "1 ORDER BY a.gst_id ASC");
		$data['state'] = $this->Common_Model->FetchData("state", "*", "1 ORDER BY state_title ASC");
		$this->load->view('masters/gstmaster', $data);
	}

	function deletegstmaster($gst_id = 0){
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$this->Common_Model->DelData("company_gst", "gst_id = ".$gst_id);
		$this->session->set_flashdata('success', 'Record deleted successfully.' );
		redirect($_SERVER['HTTP_REFERER']);
	}

	public function leavetype($leave_id = 0)
	{	
		error_reporting(0);
		$data = array();
		$data['leave_id'] = $leave_id;
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		if($this->input->post('submitBtn')){
			$this->form_validation->set_rules('leave_type', 'Leave Type', 'trim|required');
			$this->form_validation->set_rules('leave_count', 'Number Of Leave', 'trim|required');
			//$this->form_validation->set_message('is_unique', 'Duplicate Leave Type.');
			$this->form_validation->set_error_delimiters('<p class="has-error"><label class="control-label">', '</label></p>');
			if($this->form_validation->run()){
				$data_list = array(
					'leave_type'        => $this->input->post('leave_type'),
					'leave_count'       => $this->input->post('leave_count'),
					'is_paid'      	    => ($this->input->post('is_paid'))?$this->input->post('is_paid'):0,
					'leave_active'	    => 'Active'
				);
				if($leave_id>0){
				 	$this->Common_Model->update_records("leave_master","leave_id",$leave_id, $data_list);
					$this->session->set_flashdata('success', 'Leave Type Updated successfully.' );
				}else{
					$id = $this->Common_Model->dbinsertid("leave_master", $data_list);
					$this->session->set_flashdata('success', 'Leave Type Added successfully.' );
				}
				redirect('masters/leavetype');
			}else{
				$this->session->set_flashdata('error', validation_errors());
			}
		}
		$data['activemenu'] = 'masters';
		$data['activesubmenu'] = 'leavetype';
		$data['records'] = $this->Common_Model->FetchData("leave_master", "*", "1 ORDER BY leave_type ASC");
		$data['rec'] = $this->Common_Model->FetchData("leave_master", "*", "leave_id=".$leave_id." ");
		$this->load->view('masters/leavetype', $data);
	}

	function deleteleavetype($leave_id = 0){
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$this->Common_Model->DelData("leave_master", "leave_id = ".$leave_id);
		$this->session->set_flashdata('success', 'Record deleted successfully.' );
		redirect($_SERVER['HTTP_REFERER']);
	}

	public function serviceitem($item_id = 0)
	{	
		error_reporting(0);
		$data = array();
		$data['item_id'] = $item_id;
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		if($this->input->post('submitBtn')){
			$this->form_validation->set_rules('item_name', 'Service item', 'trim|required');
			$this->form_validation->set_error_delimiters('<p class="has-error"><label class="control-label">', '</label></p>');
			if($this->form_validation->run()){
				$data_list = array(
					'item_name'        => $this->input->post('item_name'),
					'item_active'	    => 'Active'
				);
				if($item_id>0){
				 	$this->Common_Model->update_records("service_item","item_id",$item_id, $data_list);
					$this->session->set_flashdata('success', 'Leave Type Updated successfully.' );
				}else{
					$id = $this->Common_Model->dbinsertid("service_item", $data_list);
					$this->session->set_flashdata('success', 'Service Item Added successfully.' );
				}
				redirect('masters/serviceitem');
			}else{
				$this->session->set_flashdata('error', validation_errors());
			}
		}
		$data['activemenu'] = 'masters';
		$data['activesubmenu'] = 'serviceitem';
		$data['records'] = $this->Common_Model->FetchData("service_item", "*", "1 ORDER BY item_name ASC");
		$data['rec'] = $this->Common_Model->FetchData("service_item", "*", "item_id=".$item_id." ");
		$this->load->view('masters/serviceitem', $data);
	}

	function deleteserviceitem($item_id = 0){
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$this->Common_Model->DelData("service_item", "item_id = ".$item_id);
		$this->session->set_flashdata('success', 'Record deleted successfully.' );
		redirect($_SERVER['HTTP_REFERER']);
	}

	function deletesection($section_id = 0){
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$this->Common_Model->DelData("sections", "section_id = ".$section_id);
		$this->session->set_flashdata('success', 'Record deleted successfully.' );
		redirect($_SERVER['HTTP_REFERER']);
	}

	function holidays(){
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$data['activemenu'] = 'masters';
		$data['activesubmenu'] = 'holidays';
		$holiday = $this->Common_Model->FetchData("holiday", "*", "1 ORDER BY id ASC");	
		$event = array();
		if(!empty($holiday)){
			foreach ($holiday as $key => $value) {
				$txtType = ($value['type'] == 1)?'(Holiday)':'(Event)';
				$tmpArr['title'] = $value['name'] . ' ' . $txtType;
				$tmpArr['start'] = date("Y-m-d",strtotime($value['from_date']));
				$tmpArr['end'] = date("Y-m-d",strtotime($value['to_date']));
				$tmpArr['type'] = $value['type'];
				$tmpArr['uid'] = $value['id'];
				array_push($event, $tmpArr);
			}
		}		
		$data['event'] = $event;
		//echo "<pre>";print_r($holiday);exit;
		$this->load->view('masters/holidays', $data);
	}

	function holidaylist(){
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$data['activemenu'] = 'masters';
		$data['activesubmenu'] = 'holidays';
		$holiday = $this->Common_Model->FetchData("holiday", "*", "1 ORDER BY id ASC");
		$event = array();
		if(!empty($holiday)){
			foreach ($holiday as $key => $value) {
				$txtType = ($value['type'] == 1)?'(Holiday)':'(Event)';
				$tmpArr['title'] = $value['name'] . ' ' . $txtType;
				$tmpArr['start'] = date("Y-m-d",strtotime($value['from_date']));
				$tmpArr['end'] = date("Y-m-d",strtotime($value['to_date']));
				$tmpArr['type'] = $value['type'];
				$tmpArr['uid'] = $value['id'];
				array_push($event, $tmpArr);
			}
		}		
		$data['event'] = $event;
		//echo "<pre>";print_r($holiday);exit;
		$this->load->view('masters/holidaylist', $data);
	}

	public function sections($section_id = 0){
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$data['sectionData'] = array();
		$data['btnVal']      = 'Submit';
		$data['section_id']  = $section_id;
		if($this->input->post('submitBtn')){
			$this->form_validation->set_rules('class_id', 'Class Name', 'trim|required');
			$this->form_validation->set_rules('section_name', 'Section Name', 'trim|required');
			$this->form_validation->set_error_delimiters('<p class="has-error"><label class="control-label">', '</label></p>');
			if($this->form_validation->run()){
				$data_list = array(
					'class_id'				=> $this->input->post('class_id'),
					'section_name'			=> $this->input->post('section_name'),
					'section_active'		=> 'Active'
				);

				if($section_id > 0){
					$chk_section = $this->Common_Model->db_query("SELECT COUNT(1) as cnt FROM sections WHERE class_id = '".$this->input->post('class_id')."' and section_name = '".$this->input->post('section_name')."' AND section_id NOT IN (".$section_id.")");
					if($chk_section[0]['cnt']>0){
						$this->session->set_flashdata("error", 'Duplicate Section Found !!! ');
						redirect('masters/sections');
					}
					$id = $this->Common_Model->update_records('sections', 'section_id', $section_id, $data_list);
				}else{
					$chk_section = $this->Common_Model->db_query("SELECT COUNT(1) as cnt FROM sections WHERE class_id = '".$this->input->post('class_id')."' and section_name = '".$this->input->post('section_name')."'");
					if($chk_section[0]['cnt']>0){
						$this->session->set_flashdata("error", 'Duplicate Section Found !!! ');
						redirect('masters/sections');
					}
					$id = $this->Common_Model->dbinsertid("sections", $data_list);
				}
				$this->session->set_flashdata('success', 'Section Added successfully.' );
				redirect('masters/sections');
			}else{
				$this->session->set_flashdata('error', validation_errors());
			}
		}
		if($section_id > 0){
			$data['btnVal']      = 'Update';
			$data['sectionData'] = $this->Common_Model->FetchData("sections", "*", "section_id = ".$section_id);
		}
		$data['activemenu'] = 'masters';
		$data['activesubmenu'] = 'sections';
		$data['classlist'] = $this->Common_Model->FetchData("classes", "*", "1 ORDER BY class_name ASC");
		$data['records'] = $this->Common_Model->FetchData("sections A LEFT JOIN classes B ON (A.class_id = B.class_id)", "A.*,B.class_name", "1 ORDER BY section_name ASC");
		$this->load->view('masters/sections', $data);
	}

	function appointment(){
		$DB2 = $this->load->database('db2', TRUE);
		$this->load->helper('url');
		$currentURL = current_url();
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));		
		$query = $DB2->select('*')->get('tbl_appointment');
		$rec = $query->result();
		$records = json_decode(json_encode($rec),true);		
		$data['records'] = $records;

		$data['activemenu'] = 'appointment';
		$data['activesubmenu'] = 'appointment';
		$this->load->view('masters/appointment', $data);
				
     	if($this->input->post('submitBtn')){
			$id = $_POST['appId'];
			$this->load->helper('url');
			$currentURL = current_url();
			$data = array();
			$DB2->select('*');
			$DB2->from('tbl_appointment');
			$DB2->where('id', $id);
			$query = $DB2->get();
			$row = $query->row_array();
			$name = $row['name'];
			$phn= $row['contact_no'];

			$sql = "UPDATE tbl_appointment SET response='Appointment approved' where id=$id";
	            	$qry = $DB2->query($sql);
			
			$text = urlencode("MR./MRS ".$name.", YOUR APPOINTMENT FOR YPP SCHOOL HAS BEEN APPOROVED");
			$loginId = urlencode("YOUNGPHOENIX");
			$password = urlencode("123456");
			$mobileNumber = urlencode("".$phn."");		
			$url="http://137.59.52.74/api/mt/SendSMS?user=".$loginId."&password=".$password."&senderid=YPPSKL&channel=Trans&DCS=0&flashsms=0&number=".$mobileNumber."&text=".$text."&route=1";
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_exec($ch);
			curl_close($ch);
		}

	    if($this->input->post('cancelBtn')){
			$id = $_POST['appId'];
			$this->load->helper('url');
			$currentURL = current_url();
			$data = array();
			$DB2->select('*');
			$DB2->from('tbl_appointment');
			$DB2->where('id', $id);
			$query = $DB2->get();
			$row = $query->row_array();
			$name = $row['name'];
			$phn= $row['contact_no'];

			$sql = "UPDATE tbl_appointment SET response='Appointment cancelled' where id=$id";
	            	$qry = $DB2->query($sql);	

			$text = urlencode("SORRY MR./MRS ".$name." !! YOUR APPOINTMENT FOR YPP SCHOOL HAS BEEN CANCELLED");
			$loginId = urlencode("YOUNGPHOENIX");
			$password = urlencode("123456");
			$mobileNumber = urlencode("".$phn."");		
			$url="http://137.59.52.74/api/mt/SendSMS?user=".$loginId."&password=".$password."&senderid=YPPSKL&channel=Trans&DCS=0&flashsms=0&number=".$mobileNumber."&text=".$text."&route=1";
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_exec($ch);
			curl_close($ch);
		}
	}

	function appMsg(){
		$DB2 = $this->load->database('db2', TRUE);
		$id = $_POST['appId'];
		$this->load->helper('url');
		$currentURL = current_url();
		$data = array();		
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
     if($this->input->post('submitBtn')){
		$DB2->select('*');
		$DB2->from('tbl_appointment');
		$DB2->where('id', $id);
		$query = $DB2->get();
		$row = $query->row_array();
		$name = $row['name'];
		$phn= $row['contact_no'];

		$sql = "UPDATE tbl_appointment SET response='Appointment approved' where id=$id";
            	$qry = $DB2->query($sql);
		
		$text = urlencode("MR./MRS ".$name.", YOUR APPOINTMENT FOR YPP SCHOOL HAS BEEN APPOROVED");
		$loginId = urlencode("YOUNGPHOENIX");
		$password = urlencode("123456");
		$mobileNumber = urlencode("".$phn."");		
		$url="http://137.59.52.74/api/mt/SendSMS?user=".$loginId."&password=".$password."&senderid=YPPSKL&channel=Trans&DCS=0&flashsms=0&number=".$mobileNumber."&text=".$text."&route=1";
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_exec($ch);
		curl_close($ch);
	}


	if($this->input->post('cancelBtn')){
		$DB2->select('*');
		$DB2->from('tbl_appointment');
		$DB2->where('id', $id);
		$query = $DB2->get();
		$row = $query->row_array();
		$name = $row['name'];
		$phn= $row['contact_no'];

		$sql = "UPDATE tbl_appointment SET response='Appointment cancelled' where id=$id";
            	$qry = $DB2->query($sql);	

		$text = urlencode("SORRY MR./MRS ".$name." !! YOUR APPOINTMENT FOR YPP SCHOOL HAS BEEN CANCELLED");
		$loginId = urlencode("YOUNGPHOENIX");
		$password = urlencode("123456");
		$mobileNumber = urlencode("".$phn."");		
		$url="http://137.59.52.74/api/mt/SendSMS?user=".$loginId."&password=".$password."&senderid=YPPSKL&channel=Trans&DCS=0&flashsms=0&number=".$mobileNumber."&text=".$text."&route=1";
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_exec($ch);
		curl_close($ch);
	}

$query = $DB2->select('*')->get('tbl_appointment');
		$rec = $query->result();
		$records = json_decode(json_encode($rec),true);		
//echo '<pre>';print_r($records);exit;
		$data['records'] = $records;
		$data['activemenu'] = 'masters';
		$data['activesubmenu'] = 'appointment';
		$this->load->view('masters/appointment',$data);
	}

	
	public function examination_mark($id = 0){
		$data = array();
		$data['id'] = $id;
		if($this->input->post('submitBtn')){
			$this->form_validation->set_rules('periodic_test', 'Periodic Test', 'trim|required');
			$this->form_validation->set_rules('note_book', 'Note Book', 'trim|required');
			$this->form_validation->set_rules('subject_enrichment', 'Subject Enrichment', 'trim|required');
			$this->form_validation->set_rules('practical_mark', 'Practical Mark', 'trim|required');
			$this->form_validation->set_rules('annual_examination', 'Annual Examination', 'trim|required');
			$this->form_validation->set_error_delimiters('<p class="has-error"><label class="control-label">', '</label></p>');
			if($this->form_validation->run()){
				$data_list = array(
					'class_id'		=> $this->input->post('class_id'),
					'periodic_test'		=> $this->input->post('periodic_test'),
					'note_book'		=> $this->input->post('note_book'),
					'subject_enrichment'	=> $this->input->post('subject_enrichment'),
					'practical_mark'	=> $this->input->post('practical_mark'),
					'annual_examination'	=> $this->input->post('annual_examination')					
				);

				//print_r($data_list);exit;
			     if($id > 0){									
				$id = $this->Common_Model->update_records('examination_mark', 'id', $id, $data_list);
				$this->session->set_flashdata('success', 'Marks Updated successfully.' );
				redirect('masters/examination_mark');
			     }else{
				$id = $this->Common_Model->dbinsertid("examination_mark", $data_list);
			     }
				$this->session->set_flashdata('success', 'Marks Added successfully.' );
				redirect('masters/examination_mark');
			}else{
				$this->session->set_flashdata('error', validation_errors());
			}
		}
		if($id > 0){
			$data['btnVal']      = 'Update';
			$data['markData'] = $this->Common_Model->FetchData("examination_mark", "*", "id = ".$id);
		}
		$data['activemenu'] = 'masters';
		$data['activesubmenu'] = 'examination_mark';
		$data['records'] = $this->Common_Model->FetchData("examination_mark AS s LEFT JOIN classes AS c ON s.class_id = c.class_id", "*", "1 ORDER BY c.class_name ASC");
		$data['records1'] = $this->Common_Model->FetchData("classes", "*", "1 ORDER BY class_name ASC");
		$this->load->view('masters/examination_mark', $data);
	}	

	public function subjects_mark($id = 0){
		$data = array();
		$data['id'] = $id;
		if($this->input->post('submitBtn')){
			$this->form_validation->set_rules('subject_id', 'Subject', 'trim|required');
			$this->form_validation->set_rules('theory_mark', 'Max. Mark Theory', 'trim|required');
			$this->form_validation->set_rules('practical_mark', 'Max. Mark Practical', 'trim|required');
			
			$this->form_validation->set_error_delimiters('<p class="has-error"><label class="control-label">', '</label></p>');
			if($this->form_validation->run()){
				$data_list = array(
					'class_id'		=> $this->input->post('class_id'),
					'subject_id'		=> $this->input->post('subject_id'),
					'maxmark_theory'		=> $this->input->post('theory_mark'),
					'maxmark_practical'	=> $this->input->post('practical_mark'),
					'status'	=> 1
									
				);

				//print_r($data_list);exit;
			     if($id > 0){									
				$id = $this->Common_Model->update_records('subjects_mark', 'id', $id, $data_list);
				$this->session->set_flashdata('success', 'Marks Updated successfully.' );
				redirect('masters/subjects_mark');
			     }else{
				$id = $this->Common_Model->dbinsertid("subjects_mark", $data_list);
			     }
				$this->session->set_flashdata('success', 'Marks Added successfully.' );
				redirect('masters/subjects_mark');
			}else{
				$this->session->set_flashdata('error', validation_errors());
			}
		}
		if($id > 0){
			$data['btnVal']      = 'Update';
			$data['markData'] = $this->Common_Model->FetchData("subjects_mark", "*", "id = ".$id);
		}
		$data['activemenu'] = 'masters';
		$data['activesubmenu'] = 'subjects_mark';
		$data['records'] = $this->Common_Model->FetchData("subjects_mark AS a LEFT JOIN classes AS b ON a.class_id = b.class_id LEFT JOIN subjects AS c ON a.subject_id = c.subject_id", "*", "1 ORDER BY a.class_id ASC");
		$data['records1'] = $this->Common_Model->FetchData("classes", "*", "1 ORDER BY class_name ASC");
		$this->load->view('masters/subjects_mark', $data);
	}

	public function add_application(){
		$data = array();
		if($this->input->post('submitBtn')){
			//$this->form_validation->set_rules('session_id','Session','trim|required');
			$this->form_validation->set_rules('date','Date','trim|required');
			$this->form_validation->set_rules('class_id','Class','trim|required');
			$this->form_validation->set_rules('student_id','Student','trim|required');
			$this->form_validation->set_rules('app_subject','Application Subject','trim|required');
			$this->form_validation->set_rules('matter','Matter','trim|required');
		if($this->form_validation->run()){
			$data_list = array(			
				'session_id' 	=> $this->input->post('session_id'),
				'class_id' 		=> $this->input->post('class_id'),
				'student_id' 	=> $this->input->post('student_id'),
				'app_subject' 	=> $this->input->post('app_subject'),
				'matter'		=> $this->input->post('matter'),
				'date'			=> $this->input->post('date')
			);
			$id = $this->Common_Model->dbinsertid('application',$data_list);
			$this->session->set_flashdata("success"," Application added successfully.");
			redirect('masters/add_application');
		}

		}else{
		    $data['sessions'] = $this->Common_Model->FetchData('sessions','*','active_session="Active"');
			$data['classes'] = $this->Common_Model->FetchData('classes','*','1 ORDER by class_id ASC');
			$this->load->view('masters/add_application',$data);
		}

	}

	public function list_application(){
		$data = array();
		$data['records'] = $this->Common_Model->FetchData('application as app LEFT JOIN classes as cls ON cls.class_id = app.class_id LEFT JOIN students as stu ON stu.student_id=app.student_id LEFT JOIN sessions as s ON s.session_id = app.session_id','*','1 ORDER by id DESC');
		$this->load->view('masters/list_application',$data);
	}

	public function delete_application($id=0){
		$data = array();
		$data['id'] = $id;
		$this->Common_Model->DelData('application','id='.$id);
		$this->session->set_flashdata('success',' Application delete successfully.');
		redirect('masters/list_application');
	}

		function transport(){
		$this->load->helper('url');
		$currentURL = current_url();
		$data = array();
		$sql = "1";
		$queryvars = "";
		$sql.= " ORDER BY trans_id ASC";
		$rows = $this->Common_Model->FetchRows("erp_transport", "*", "$sql");
		$data['page_num'] = $page_num = isset($_REQUEST['page']) ? $_REQUEST['page'] : 1;
		$this->load->library("Paginator");
		$this->paginator->setparam(array("page_num" => $page_num, "num_rows" => $rows));
		$this->paginator->set_Limit(10);
		$range1 = $this->paginator->getRange1();
		$range2 = $this->paginator->getRange2();

		$sql .= " LIMIT ".$range1.', '.$range2;
		$records = $this->Common_Model->db_query("SELECT * FROM erp_transport WHERE ".$sql);

		$paging_info = $this->paginator->DBPagingNav($queryvars, $currentURL);

		$data['tot_page'] = $paging_info[0];
		$data['sPages'] = $paging_info[1];
		$data['rows'] = $rows;
		$data['records'] = $records;
		$data['activemenu'] = 'transport';
		$data['activesubmenu'] = 'transport';
		$this->load->view('masters/transports', $data);
	}


	function add_edit_transport($trans_id = 0){
		$this->load->helper('security');
		$data 			    	= array();
		$data['trans_id'] 		= $trans_id;
		$data['activemenu']   	= 'transport';
		$data['activesubmenu']  = 'add_edit_transport';
		$data['route_data'] 	= array();
		$data['stoppage_data']  = array();
		$updQur             	= '';
		if($this->input->post('submitBtn')){
			//echo '<pre>';print_r($this->input->post());exit;
			$route_name    = $this->input->post("route_name");
			$active_status = $this->input->post("active_status");
			$stoppage_name = $this->input->post("stoppage_name");
			$rowVal        = $this->input->post("rowid");
			$action        = $this->input->post("hdnUserType");


			foreach($stoppage_name as $ind=>$val) 
			{
			    $stpgName   = $stoppage_name[$ind];
			    $rowid  	= $rowVal[$ind];

			    $this->form_validation->set_rules("stoppage_name[".$ind."]", "Stoppage Name", "trim|xss_clean|required");
			    $this->form_validation->set_rules("rowid[".$ind."]", "Row", "trim|xss_clean|integer|required");
			    $this->form_validation->set_error_delimiters('<p class="has-error"><label class="control-label">', '</label></p>');
		    	if($action == 'A'){
		    		$updQur .= "(@LASTID,'$stpgName'),";
		    	}else{
		    		$updQur .= "($rowid,'$trans_id','$stpgName'),";
		    	}
			}

			//echo $updQur;exit;
			if($this->form_validation->run()){
				if($updQur != ''){
					$updQur = rtrim($updQur,',');
					$prepareQur = 'CALL STOPPAGE_SETUP("'.$action.'","'.$updQur.'","'.$trans_id.'","'.$route_name.'","'.$active_status.'")';
					$this->Common_Model->QueryData($prepareQur);
				}
				$this->session->set_flashdata('success', 'Route Added Successfully.' );
			}else{
				$this->session->set_flashdata("error", validation_errors());
			}
			redirect('masters/transport');
		}
		if($trans_id > 0){
			$data['route_data']   = $this->Common_Model->FetchData("erp_transport", "*", "trans_id = ".$trans_id);
			$data['stoppage_data']   = $this->Common_Model->FetchData("erp_stoppage", "*", "route_id = ".$trans_id);
		}
		//echo '<pre>';print_r($data);exit;
		$this->load->view('masters/add_edit_transport',$data);
	}


	function delete_transport($route_id){
		if($route_id > 0){
			$this->Common_Model->DelData("erp_transport", "trans_id = ". $route_id);
			$this->Common_Model->DelData("erp_stoppage", "route_id = ". $route_id);
			redirect("masters/transport");
		}else{
			echo '<script>window.history.back();</script>';exit;
		}
	}



	function download_route_data(){
		$this->load->helper('url');
		$data = array();
		$curSession 	= $this->session->userdata['session_name'];
		$sql 			= "1";
		//$sql			.= " AND A.session = '".$curSession."'";
		$records = $this->Common_Model->db_query("SELECT A.*,CONCAT(B.student_first_name,' ',B.student_last_name) AS fullname,B.student_mobile AS mobile,B.student_email AS email,B.present_address AS address,C.route_name,D.stoppage_name FROM `erp_assign_transport` A LEFT JOIN students B ON (A.student_id = B.student_id) LEFT JOIN erp_transport C ON (A.route_id = C.trans_id) LEFT JOIN erp_stoppage D ON (A.stoppage_id = D.stpg_id) WHERE ".$sql);
		//print_r($records);exit;

		if($records){
			$html = '<table border=1> <tr> <th>Student Name</th><th>Mobile</th> <th>Email</th><th>Address</th><th>Route Name</th><th>Stoppage Name</th></tr>';

            for($i=0;$i<count($records);$i++){
            	$html.= '<tr><td>'.$records[$i]['fullname'].'</td><td>'.$records[$i]['mobile'].'</td><td>'.$records[$i]['email'].'</td><td>'.$records[$i]['address'].'</td> <td>'.$records[$i]['route_name'].'</td><td>'.$records[$i]['stoppage_name'].'</td> </tr>';

            }
            $html.= '</table>';
            $this->db->close();
			header("Content-type: application/vnd.ms-excel");
			header("Content-Disposition: attachment; filename=routedata".time().".xls");
			echo $html;
		}else{
			$this->session->set_flashdata('error', 'No Records found' );
			redirect("masters/transport");
		}

	}

	function config_route($vehicle_id = 0){
		$this->load->helper('security');
		$data 			    	= array();
		$data['vehicle_id'] 	= $vehicle_id;
		$data['activemenu']   	= 'transport';
		$data['activesubmenu']  = 'transport';
		$data['route_data'] 	= array();
		$data['stoppage_data']  = array();
		$updQur             	= '';
		if($this->input->post('submitBtn')){
			//echo '<pre>';print_r($this->input->post());exit;
			$route_id  	    = $this->input->post("route_id");
			$rowVal         = $this->input->post("rowid");
			$action         = $this->input->post("hdnUserType");


			foreach($route_id as $ind=>$val) 
			{
			    $routName   = $route_id[$ind];
			    $rowid  	= $rowVal[$ind];

			    $this->form_validation->set_rules("route_id[".$ind."]", "Route Name", "trim|xss_clean|required");
			    $this->form_validation->set_rules("rowid[".$ind."]", "Row", "trim|xss_clean|integer|required");
			    $this->form_validation->set_error_delimiters('<p class="has-error"><label class="control-label">', '</label></p>');
		    	if($action == 'A'){
		    		$updQur .= "('$vehicle_id','$routName'),";
		    	}else{
		    		$updQur .= "($rowid,'$vehicle_id','$routName'),";
		    	}
			}

			//echo $updQur;exit;
			if($this->form_validation->run()){
				if($updQur != ''){
					$updQur = rtrim($updQur,',');
					$prepareQur = 'CALL VEHICLE_SETUP("'.$action.'","'.$updQur.'","'.$vehicle_id.'")';
					$this->Common_Model->QueryData($prepareQur);
				}
				$this->session->set_flashdata('success', 'Route Configured Successfully.' );
			}else{
				$this->session->set_flashdata("error", validation_errors());
			}
			redirect('masters/vehicles');
		}
		if($vehicle_id > 0){
			$data['route_data']   = $this->Common_Model->FetchData("erp_route_details", "*", "vehicle_id = ".$vehicle_id);
		}
		//echo '<pre>';print_r($data);exit;
		$this->load->view('masters/config_route',$data);
	}

    public function adm_registration()
	{
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		if($this->input->post('submitBtn')){
			$this->form_validation->set_rules('ar_no', 'Admission Registration No', 'trim|required');
			$this->form_validation->set_error_delimiters('<p class="has-error"><label class="control-label">', '</label></p>');
			if($this->form_validation->run()){
				$data_list = array(
					'ar_no'				=> $this->input->post('ar_no'),
					'entry_date'		=> date('Y-m-d')
				);
				$id = $this->Common_Model->dbinsertid("adm_registration", $data_list);
				$this->session->set_flashdata('success', 'AR No Added successfully.' );
				redirect('masters/adm_registration');
			}else{
				$this->session->set_flashdata('error', validation_errors());
			}
		}
		$data['activemenu'] 	= 'masters';
		$data['activesubmenu']  = 'adm_registration';
		$data['records'] 		= $this->Common_Model->FetchData('adm_registration','*','1 ORDER by id desc');
		$this->load->view('masters/adm_registration', $data);
	}

	public function edit_arno($id=0)
	{
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));		
		if($this->input->post('submitBtn')){
			$this->form_validation->set_rules('ar_no', 'Admission Registration No', 'trim|required');
			$this->form_validation->set_error_delimiters('<p class="has-error"><label class="control-label">', '</label></p>');
			if($this->form_validation->run()){
				$data_list = array(
					'ar_no'				=> $this->input->post('ar_no'),
					'entry_date'		=> date('Y-m-d')
				);
				$id = $this->Common_Model->update_records("adm_registration", "id", $id, $data_list);
				$this->session->set_flashdata('success', 'AR No Updated successfully.' );
				redirect('masters/adm_registration');
			}else{
				$this->session->set_flashdata('error', validation_errors());
			}
		}
		$data['activemenu'] 	= 'masters';
		$data['activesubmenu']  = 'adm_registration';
		$data['rec'] 		= $this->Common_Model->FetchData('adm_registration','*','id = '.$id);
		$data['records'] 		= $this->Common_Model->FetchData('adm_registration','*','1 ORDER by id desc');
		$this->load->view('masters/adm_registration', $data);
	}

	function delete_arno($id = 0){
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$this->Common_Model->DelData("adm_registration", "id = ".$id);
		$this->session->set_flashdata('success', 'Record deleted successfully.' );
		redirect($_SERVER['HTTP_REFERER']);
	}

	function bulkassigntransport($routeId){
		$this->load->helper('security');
		$data 			    	= array();
		$data['routeId'] 		= $routeId;
		$data['activemenu']   	= 'masters';
		$data['activesubmenu']  = 'transport';
		$updQur             	= '';
		if($this->input->post('submitBtn')){
			$route_id  	    = $routeId;
			$stoppage_id  	= $this->input->post("stoppage_id");
			$stud_ids  		= $this->input->post("stud_ids");
			foreach($stud_ids as $ind=>$val) 
			{
			    $studName   = $stud_ids[$ind];

			    $this->form_validation->set_rules("stud_ids[".$ind."]", "Student Name", "trim|xss_clean|required");
			    $this->form_validation->set_error_delimiters('<p class="has-error"><label class="control-label">', '</label></p>');
		    	$updQur .= "('$route_id','$stoppage_id','$studName'),";
			}
			//echo $updQur;exit;
			if($this->form_validation->run()){
				if($updQur != ''){
					$updQur = rtrim($updQur,',');
					$prepareQur = 'CALL BULK_STUD_ASSIGN("A","'.$updQur.'")';
					$this->Common_Model->QueryData($prepareQur);
				}
				$this->session->set_flashdata('success', 'Student Configured Successfully.' );
			}else{
				$this->session->set_flashdata("error", validation_errors());
			}
			redirect('masters/transport');
		}
		$data['sessions'] 		= $this->Common_Model->FetchData("sessions", "*", "1 ORDER BY session_id DESC");
		$data['classes'] 		= $this->Common_Model->FetchData("classes", "*", "1 ORDER BY class_name ASC");
		$this->load->view('masters/bulkassigntransport',$data);
	}

    function getStudentmarks(){
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$records = $this->Common_Model->FetchData("exam_results", "*", "student_id = ".$this->input->post("student_id"));
		if($records){ 
			foreach ($records as $key => $val) {
				
			echo json_encode($val);
		}}else{

		}
	}
	
	function getSubjectsListBytagClass(){
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$postData = $this->input->post();
		$teacher_id = $postData['teacherId'];
			$classId    = $postData['classId']; 
		$records = $this->Common_Model->db_query("SELECT subject_id,subject_name FROM subjects WHERE subject_id IN (SELECT subject_id FROM teacher_class_subject_tag WHERE teacher_id = ".$teacher_id." AND class_id = ".$classId.")");
		$html = '<option value="">select</option>';
		if($records){ for($i=0;$i<count($records);$i++){
			$html.= '<option value="'.$records[$i]['subject_id'].'">'.$records[$i]['subject_name'].'</option>';
		}}
		echo $html;
	}
	
	function getccagroups(){
		//var selected = '';
		$cls = $this->input->post("class_id");
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$records = $this->Common_Model->FetchData("ccagroups", "*", "class_id = ".$this->input->post("class_id")." AND session_id = ".$this->input->post("session_id")."");
		$html = '<option value="">select</option>';
		if($records){ for($i=0;$i<count($records);$i++){
			$html.= '<option value="'.$records[$i]['gid'].'">'.$records[$i]['cgrp'].'</option>';
		}}
		echo $html; 
	}
	public function attributes($did = 0){
		error_reporting(0);
			$data = array();
			$data['did'] = $did;
			$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		 if($this->input->post('submitBtn')){
			$this->form_validation->set_rules('grade', 'Grade', 'trim|required');
			$this->form_validation->set_rules('attribute', 'Attribute', 'trim|required');
			$this->form_validation->set_error_delimiters('<p class="has-error"><label class="control-label">', '</label></p>');
			if($this->form_validation->run()){
				$data_list = array(
					
					'grade'			=> $this->input->post('grade'),
					'attribute'		=> $this->input->post('attribute'),
					'upd_on'		=>date('Y-m-d')
				);
				if($did > 0){					
					$id = $this->Common_Model->update_records('attributes', 'id', $did, $data_list);
					$this->session->set_flashdata('success', 'Attribute Update successfully.' );
				redirect('masters/attributes');
				}else{
					$this->Common_Model->dbinsertid('attributes', $data_list);
					$this->session->set_flashdata('success', 'Attribute Added successfully.' );
				redirect('masters/attributes');
				}

			}else{
				$this->session->set_flashdata('error', validation_errors());
			}
		}
		$data['activemenu'] = 'masters';
		$data['activesubmenu']  = 'attributes';
		$data['records'] = $this->Common_Model->FetchData("attributes ", "*", "1 ORDER BY grade asc");
		
		$data['rec'] = $this->Common_Model->FetchData("attributes", "*", "id=".$did."");
		$this->load->view('masters/attributes', $data);
	}
	function deleteattribute($id = 0){
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$this->Common_Model->DelData("attributes", "id = ".$id);
		
		$this->session->set_flashdata('success', 'Record deleted successfully.' );
		redirect($_SERVER['HTTP_REFERER']);
	}
	function getStudentListBySessionClassbe4(){
		//print_r($this->input->post("class_id"));exit;
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$res = $this->Common_Model->FetchData("exam_term","*","active_exam_term = 'Active'");
		$records = $this->Common_Model->FetchData("student_admission AS sa LEFT JOIN students AS s ON sa.student_id = s.student_id LEFT JOIN board_exam_result_items as b ON sa.student_id = b.student_id LEFT JOIN board_exam_results as c ON b.board_exam_results_id = c.board_exam_results_id", "*", "sa.class_id = ".$this->input->post("class_id")." AND sa.session_id = ".$this->input->post("session_id")." AND s.student_section = ".$this->input->post("section_id")." AND sa.admission_status = 'Active' AND c.subject_id ='".$this->input->post("subject_id")."' AND c.term ='".$res[0]['exam_term']."'  ORDER BY s.student_first_name ASC");
		//print_r($records);exit;
		$rec = $this->Common_Model->FetchData("student_admission AS sa LEFT JOIN students AS s ON sa.student_id = s.student_id LEFT JOIN subjects_mark AS n ON sa.class_id = n.class_id", "*", "sa.class_id = ".$this->input->post("class_id")." AND sa.session_id = ".$this->input->post("session_id")." AND s.student_section = ".$this->input->post("section_id")." AND n.subject_id = ".$this->input->post("subject_id")." AND sa.admission_status = 'Active' ORDER BY s.student_first_name ASC");
		//print_r($rec[0]['subject_studied']);exit;
		$html = '<table class="table table-condensed table-bordered"><tr>
                        <th>Scholastic Areas</th>
                        <th colspan="4">
                          <select class="form-control" name="exam_term" id="exam_term" required>
                            
                            <option value="'.$res[0]['exam_term'].'">'.$res[0]['exam_term'].'</option>
                            
                          </select>
                        </th>
                      </tr>
                      <tr>
                        
                        <th style="width: 10%;">Student Name</th>
                        <th style="width: 4%;" class="text-center">Unit Test 2</th>
                        <th style="width: 4%;" class="text-center">Pre-Board</th>
                        <th style="width: 4%;" class="text-center">Sahodaya</th>
                        <th style="width: 4%;" class="text-center">I.A/Practical</th>
                        <th style="width: 4%;" class="text-center">Board Result (100)</th>
                        
                      </tr>';
		if($records){ for($i=0;$i<count($records);$i++){
				$d = json_decode($records[$i]['subject_studied']);
				//print_r($d);exit;
				if (in_array($this->input->post("subject_id"), $d)) {
 
				/*$rec = $this->Common_Model->FetchData("","","")*/
			$html.= '<tr><td><input type="hidden" name="result_id" value="'.$records[$i]['board_exam_results_id'].'"><input type="hidden" name="student_id[]" value="'.$records[$i]['student_id'].'">'.$records[$i]['student_first_name'].' '.$records[$i]['student_last_name'].'</td><td><input type="number" name="unit_testt[]" class="form-control max_marks marktoadd" step="0.01" value="'.$records[$i]['unit_testt'].'"></td><td><input type="number" name="pre_board[]" class="form-control marktoadd" step="0.01" value="'.$records[$i]['pre_board'].'"></td><td><input type="number" name="sahodaya[]" class="form-control" step="0.01" value="'.$records[$i]['sahodaya'].'" ></td><td><input type="number" name="ia_practical[]" class="form-control " step="0.01" value="'.$records[$i]['ia_practical'].'" ></td><td><input type="number" name="board_result[]" class="form-control marktoadd board_result" step="0.01" value="'.$records[$i]['board_result'].'" ><input type="hidden" name="grade[]" class="form-control marktoadd grade"  value="'.$records[$i]['grade'].'" readonly></td></tr>';
		}}}else{ for($i=0;$i<count($rec);$i++){ 
			$e = json_decode($rec[$i]['subject_studied']); 
				//print_r($d);exit;
				if (in_array($this->input->post("subject_id"), $e)) {
			$html.= '<tr><td><input type="hidden" name="student_id[]" value="'.$rec[$i]['student_id'].'">'.$rec[$i]['student_first_name'].' '.$rec[$i]['student_last_name'].'</td><td><input type="number" name="unit_testt[]" class="form-control max_marks marktoadd" step="0.01" value=""></td><td><input type="number" name="pre_board[]" class="form-control marktoadd" step="0.01" value=""></td><td><input type="number" name="sahodaya[]" class="form-control" step="0.01" value="" ></td><td><input type="number" name="ia_practical[]" class="form-control " step="0.01" value="" ></td><td><input type="number" name="board_result[]" class="form-control marktoadd board_result" step="0.01" value="" ><input type="hidden" name="grade[]" class="form-control marktoadd grade"  value="" readonly></td></tr>';
		}}}

		
		$html.= '</table>';
		echo $html;
	}
	function getStudentListBySessionClassbe9(){
		//print_r($this->input->post("class_id"));exit;
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$res = $this->Common_Model->FetchData("exam_term","*","active_exam_term = 'Active'");

		$records = $this->Common_Model->FetchData("student_admission AS sa LEFT JOIN students AS s ON sa.student_id = s.student_id LEFT JOIN board_exam_result_items as b ON sa.student_id = b.student_id LEFT JOIN board_exam_results as c ON b.board_exam_results_id = c.board_exam_results_id", "*", "sa.class_id = ".$this->input->post("class_id")." AND sa.session_id = ".$this->input->post("session_id")." AND s.student_section = ".$this->input->post("section_id")." AND sa.admission_status = 'Active' AND c.subject_id ='".$this->input->post("subject_id")."' AND c.term ='".$res[0]['exam_term']."'  ORDER BY s.student_first_name ASC");
		$rec = $this->Common_Model->FetchData("student_admission AS sa LEFT JOIN students AS s ON sa.student_id = s.student_id ", "*", "sa.class_id = ".$this->input->post("class_id")." AND sa.session_id = ".$this->input->post("session_id")." AND s.student_section = ".$this->input->post("section_id")." AND sa.admission_status = 'Active' ORDER BY s.student_first_name ASC");

		//print_r($rec);exit;
		$html = '<table class="table table-condensed table-bordered"><tr>
                        <th>Scholastic Areas</th>
                        <th colspan="4">
                          <select class="form-control" name="exam_term" id="exam_term" required>
                            
                            <option value="'.$res[0]['exam_term'].'">'.$res[0]['exam_term'].'</option>
                            
                          </select>
                        </th>
                      </tr>
                      <tr>
                        
                        <th style="width: 10%;">Student Name</th>
                        <th style="width: 4%;">Post Mid Term</th>
                        <th style="width: 4%;">Pre-Board</th>
                        <th style="width: 4%;">Sahodaya</th>
                        <th style="width: 4%;">Per test (3)</th>
                        <th style="width: 4%;">Mult-Asse (2)</th>
                        <th style="width: 4%;">Portfolio (2)</th>
                        <th style="width: 4%;">Sub-enrich (3)</th>
                        <th style="width: 4%;">Total (10)</th>
                        <th style="width: 4%;">Board Result (100)</th>
                        
                      </tr>';
		if($records){ for($i=0;$i<count($records);$i++){
				$d = json_decode($records[$i]['subject_studied']);
				//print_r($d);exit;
				if (in_array($this->input->post("subject_id"), $d)) {
 
				/*$rec = $this->Common_Model->FetchData("","","")*/
			$html.= '<tr><td><input type="hidden" name="result_id" value="'.$records[$i]['board_exam_results_id'].'"><input type="hidden" name="student_id[]" value="'.$records[$i]['student_id'].'">'.$records[$i]['student_first_name'].' '.$records[$i]['student_last_name'].'</td><td><input type="number" name="post_mid_term[]" class="form-control max_marks marktoadd" step="0.01" value="'.$records[$i]['post_mid_term'].'"></td><td><input type="number" name="pre_board[]" class="form-control marktoadd" step="0.01" value="'.$records[$i]['pre_board'].'"></td><td><input type="number" name="sahodaya[]" class="form-control" step="0.01" value="'.$records[$i]['sahodaya'].'" ></td><td><input type="number" name="per_testt[]" class="form-control " step="0.01" value="'.$records[$i]['per_testt'].'" ></td><td><input type="number" name="mult_asse[]" class="form-control " step="0.01" value="'.$records[$i]['mult_asse'].'" ></td><td><input type="number" name="portfolio[]" class="form-control " step="0.01" value="'.$records[$i]['portfolio'].'" ></td><td><input type="number" name="sub_enrich[]" class="form-control " step="0.01" value="'.$records[$i]['sub_enrich'].'" ></td><td><input type="number" name="total[]" class="form-control " step="0.01" value="'.$records[$i]['total'].'" ></td><td><input type="number" name="board_result[]" class="form-control marktoadd board_result" step="0.01" value="'.$records[$i]['board_result'].'" ><input type="hidden" name="grade[]" class="form-control marktoadd grade"  value="'.$records[$i]['grade'].'" readonly></td></tr>';
		}}}else{ for($i=0;$i<count($rec);$i++){ 
			$e = json_decode($rec[$i]['subject_studied']); 
				//print_r($d);exit;
				if (in_array($this->input->post("subject_id"), $e)) {
			$html.= '<tr><td><input type="hidden" name="student_id[]" value="'.$rec[$i]['student_id'].'">'.$rec[$i]['student_first_name'].' '.$rec[$i]['student_last_name'].'</td><td><input type="number" name="post_mid_term[]" class="form-control max_marks marktoadd" step="0.01" value=""></td><td><input type="number" name="pre_board[]" class="form-control marktoadd" step="0.01" value=""></td><td><input type="number" name="sahodaya[]" class="form-control" step="0.01" value="" ></td><td><input type="number" name="per_testt[]" class="form-control " step="0.01" value="" ></td><td><input type="number" name="mult_asse[]" class="form-control " step="0.01" value="" ></td><td><input type="number" name="portfolio[]" class="form-control " step="0.01" value="" ></td><td><input type="number" name="sub_enrich[]" class="form-control " step="0.01" value="" ></td><td><input type="number" name="total[]" class="form-control " step="0.01" value="" ></td><td><input type="number" name="board_result[]" class="form-control marktoadd board_result" step="0.01" value="" ><input type="hidden" name="grade[]" class="form-control marktoadd grade"  value="" readonly></td></tr>';
		}}}

		
		$html.= '</table>';
		echo $html;
	}
	function getStudentListBySessionClass444(){
		//print_r($this->input->post("class_id"));exit;
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$res = $this->Common_Model->FetchData("exam_term","*","exam_term = '".$this->input->post("term")."'");
		$records = $this->Common_Model->FetchData("student_admission AS sa LEFT JOIN students AS s ON sa.student_id = s.student_id LEFT JOIN exam_result_items as b ON sa.student_id = b.student_id LEFT JOIN exam_results as c ON b.exam_result_id = c.exam_result_id", "*", "sa.class_id = ".$this->input->post("class_id")." AND sa.session_id = ".$this->input->post("session_id")." AND s.student_section = ".$this->input->post("section_id")." AND sa.admission_status = 'Active' AND c.subject_id ='".$this->input->post("subject_id")."' AND c.term ='".$this->input->post("term")."' AND c.create_by='".$this->input->post("teacher_id")."' ORDER BY s.student_first_name ASC");
		//print_r($records);exit;
		if ($res[0]['exam_term'] == 'Term-1 (100 marks)') {
			$html = '<div style="overflow-x:auto;"><table class="table table-condensed table-bordered text-center" ><tr>
					
				<th style="font-size:15px;">Periodic Test 1</th>	
					
				<th>Half-Yearly</th>	
		</tr><tr>';
          //echo count($records); 
          $c=0;           
          $p=0;           
		if($records){ for($i=0;$i<count($records);$i++){

			if ($records[$i]['periodic_test']>0) {
				$c+=1;
			}
			if ($records[$i]['periodic_test']==0) {
				$p+=1;
			}
			
		}
			$html.= '<td style="color:'.($c>$p?"green":"red").'">'.($c>$p?"Completed":"Pending").' <br>'.($records[0]['periodic_date'] != ''?date("d-m-Y H:i a",strtotime($records[0]['periodic_date'])):'').'</td>';	
		}
		if($records){ for($i=0;$i<count($records);$i++){

			if ($records[$i]['mark_obtained_theory']>0) {
				$c+=1;
			}
			if ($records[$i]['mark_obtained_theory']==0) {
				$p+=1;
			}
			
		}
			$html.= '<td style="color:'.($c>$p?"green":"red").'">'.($c>$p?"Completed":"Pending").' <br>'.($records[0]['halfyearly_date'] != ''?date("d-m-Y H:i a",strtotime($records[0]['halfyearly_date'])):'').'</td>';
		
			}
		
		$html.= '</tr></table>';
	}else{
			$html = '<div style="overflow-x:auto;"><table class="table table-condensed table-bordered text-center" ><tr>
					
				<th style="font-size:15px;">Periodic Test 2</th>		
				<th>Annual</th>	
				<th>I.A/Practical</th>	
		</tr><tr>';
          //echo count($records); 
          $c=0;           
          $p=0;           
		if($records){ for($i=0;$i<count($records);$i++){

			if ($records[$i]['periodic_test']>0) {
				$c+=1;
			}
			if ($records[$i]['periodic_test']==0) {
				$p+=1;
			}
			
		}
			$html.= '<td style="color:'.($c>$p?"green":"red").'">'.($c>$p?"Completed":"Pending").' <br>'.($records[0]['periodic_date'] != ''?date("d-m-Y H:i a",strtotime($records[0]['periodic_date'])):'').'</td>';	
		}
		if($records){ for($i=0;$i<count($records);$i++){

			if ($records[$i]['mark_obtained_theory']>0) {
				$c+=1;
			}
			if ($records[$i]['mark_obtained_theory']==0) {
				$p+=1;
			}
			
		}
			$html.= '<td style="color:'.($c>$p?"green":"red").'">'.($c>$p?"Completed":"Pending").' <br>'.($records[0]['halfyearly_date'] != ''?date("d-m-Y H:i a",strtotime($records[0]['halfyearly_date'])):'').'</td>';
		
		}
		if($records){ for($i=0;$i<count($records);$i++){

			if ($records[$i]['mark_obtained_practical']>0) {
				$c+=1;
			}
			if ($records[$i]['mark_obtained_practical']==0) {
				$p+=1;
			}
			
		}
			$html.= '<td style="color:'.($c>$p?"green":"red").'">'.($c>$p?"Completed":"Pending").' <br>'.($records[0]['aipractical_date'] != ''?date("d-m-Y H:i a",strtotime($records[0]['aipractical_date'])):'').'</td>';	
		}
	$html.= '</tr></table>';
		}
		
		echo $html;
	}
	 public function addmarkreportClassnurseryto8(){
	 	$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$res = $this->Common_Model->FetchData("exam_term","*","exam_term = '".$this->input->post("term")."'");
		$records = $this->Common_Model->FetchData("student_admission AS sa LEFT JOIN students AS s ON sa.student_id = s.student_id LEFT JOIN exam_result_items as b ON sa.student_id = b.student_id LEFT JOIN exam_results as c ON b.exam_result_id = c.exam_result_id", "*", "sa.class_id = ".$this->input->post("class_id")." AND sa.session_id = ".$this->input->post("session_id")." AND s.student_section = ".$this->input->post("section_id")." AND sa.admission_status = 'Active' AND c.subject_id ='".$this->input->post("subject_id")."' AND c.term ='".$this->input->post("term")."' AND c.create_by='".$this->input->post("teacher_id")."' ORDER BY s.student_first_name ASC");
		//print_r($records);exit;
		if ($res[0]['exam_term'] == 'Term-1 (100 marks)') {
			$html = '<div style="overflow-x:auto;"><table class="table table-condensed table-bordered text-center" ><tr>
					
				<th style="font-size:15px;">Periodic Test 1</th>	
				<th style="font-size:15px;">Portfolio</th>	
				<th style="font-size:15px;">Sub Enrichment</th>		
				<th style="font-size:15px;">Half-Yearly</th>	
		</tr><tr>';
          //echo count($records); 
          $c=0;           
          $p=0;           
		if($records){ for($i=0;$i<count($records);$i++){

			if ($records[$i]['pt']>0) {
				$c+=1;
			}
			if ($records[$i]['pt']==0) {
				$p+=1;
			}
			
		}
			$html.= '<td style="color:'.($c>$p?"green":"red").'">'.($c>$p?"Completed":"Pending").' <br>'.($records[0]['ptdate'] != ''?date("d-m-Y H:i a",strtotime($records[0]['ptdate'])):'').'</td>';	
		}
		if($records){ for($i=0;$i<count($records);$i++){

			if ($records[$i]['portfolio']>0) {
				$c+=1;
			}
			if ($records[$i]['portfolio']==0) {
				$p+=1;
			}
			
		}
			$html.= '<td style="color:'.($c>$p?"green":"red").'">'.($c>$p?"Completed":"Pending").' <br>'.($records[0]['portfolio_date'] != ''?date("d-m-Y H:i a",strtotime($records[0]['portfolio_date'])):'').'</td>';
		
			}
		if($records){ for($i=0;$i<count($records);$i++){

			if ($records[$i]['sub_enrichment']>0) {
				$c+=1;
			}
			if ($records[$i]['sub_enrichment']==0) {
				$p+=1;
			}
			
		}
			$html.= '<td style="color:'.($c>$p?"green":"red").'">'.($c>$p?"Completed":"Pending").' <br>'.($records[0]['sub_enrichment_date'] != ''?date("d-m-Y H:i a",strtotime($records[0]['sub_enrichment_date'])):'').'</td>';
		
			}

		if($records){ for($i=0;$i<count($records);$i++){

			if ($records[$i]['half_yearly']>0) {
				$c+=1;
			}
			if ($records[$i]['half_yearly']==0) {
				$p+=1;
			}
			
		}
			$html.= '<td style="color:'.($c>$p?"green":"red").'">'.($c>$p?"Completed":"Pending").' <br>'.($records[0]['halfyearly_date'] != ''?date("d-m-Y H:i a",strtotime($records[0]['halfyearly_date'])):'').'</td>';
		
			}


		$html.= '</tr></table>';
	}else{
			$html = '<div style="overflow-x:auto;"><table class="table table-condensed table-bordered text-center" ><tr>
					
				<th style="font-size:15px;">Periodic Test 2</th>	
				<th style="font-size:15px;">Portfolio</th>	
				<th style="font-size:15px;">Sub Enrichment</th>		
				<th style="font-size:15px;">Annual</th>	
		</tr><tr>';
          //echo count($records); 
          $c=0;           
          $p=0;           
		if($records){ for($i=0;$i<count($records);$i++){

			if ($records[$i]['pt']>0) {
				$c+=1;
			}
			if ($records[$i]['pt']==0) {
				$p+=1;
			}
			
		}
			$html.= '<td style="color:'.($c>$p?"green":"red").'">'.($c>$p?"Completed":"Pending").' <br>'.($records[0]['ptdate'] != ''?date("d-m-Y H:i a",strtotime($records[0]['ptdate'])):'').'</td>';	
		}
		if($records){ for($i=0;$i<count($records);$i++){

			if ($records[$i]['portfolio']>0) {
				$c+=1;
			}
			if ($records[$i]['portfolio']==0) {
				$p+=1;
			}
			
		}
			$html.= '<td style="color:'.($c>$p?"green":"red").'">'.($c>$p?"Completed":"Pending").' <br>'.($records[0]['portfolio_date'] != ''?date("d-m-Y H:i a",strtotime($records[0]['portfolio_date'])):'').'</td>';
		
			}
		if($records){ for($i=0;$i<count($records);$i++){

			if ($records[$i]['sub_enrichment']>0) {
				$c+=1;
			}
			if ($records[$i]['sub_enrichment']==0) {
				$p+=1;
			}
			
		}
			$html.= '<td style="color:'.($c>$p?"green":"red").'">'.($c>$p?"Completed":"Pending").' <br>'.($records[0]['sub_enrichment_date'] != ''?date("d-m-Y H:i a",strtotime($records[0]['sub_enrichment_date'])):'').'</td>';
		
			}

		if($records){ for($i=0;$i<count($records);$i++){

			if ($records[$i]['half_yearly']>0) {
				$c+=1;
			}
			if ($records[$i]['half_yearly']==0) {
				$p+=1;
			}
			
		}
			$html.= '<td style="color:'.($c>$p?"green":"red").'">'.($c>$p?"Completed":"Pending").' <br>'.($records[0]['halfyearly_date'] != ''?date("d-m-Y H:i a",strtotime($records[0]['halfyearly_date'])):'').'</td>';
		
			}


		$html.= '</tr></table>';
		}
		
		echo $html;
	 }
	function getStudentListBySessionClass999(){
		//print_r($this->session->userdata('exam_term'));exit;
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$res = $this->Common_Model->FetchData("exam_term","*","exam_term = '".$this->input->post("term")."'");
		$records = $this->Common_Model->FetchData("student_admission AS sa LEFT JOIN students AS s ON sa.student_id = s.student_id LEFT JOIN exam_result_items as b ON sa.student_id = b.student_id LEFT JOIN exam_results as c ON b.exam_result_id = c.exam_result_id", "*", "sa.class_id = ".$this->input->post("class_id")." AND sa.session_id = ".$this->input->post("session_id")." AND s.student_section = ".$this->input->post("section_id")." AND sa.admission_status = 'Active' AND c.subject_id ='".$this->input->post("subject_id")."' AND c.term ='".$this->input->post("term")."' AND c.create_by='".$this->input->post("teacher_id")."'  ORDER BY s.student_first_name ASC");
		
		if ($res[0]['exam_term'] == 'Term-1 (100 marks)') {
			$html = '<div style="overflow-x:auto;"><table class="table table-condensed table-bordered text-center" ><tr>
					
				<th style="font-size:15px;">Periodic Test 1</th>
				'.($this->input->post("subject_id") == 296 || $this->input->post("subject_id") == 234 ? '<th style="font-size:15px;">Theory</th><th style="font-size:15px;">Practical</th>':'<th style="font-size:15px;">Half-Yearly</th>').'
					

		</tr><tr>';
          //echo count($records); 
          $c=0;           
          $p=0;           
		if($records){ for($i=0;$i<count($records);$i++){

			if ($records[$i]['pt']>0) {
				$c+=1;
			}
			if ($records[$i]['pt']==0) {
				$p+=1;
			}
			
		}
			$html.= '<td style="color:'.($c>$p?"green":"red").'">'.($c>$p?"Completed":"Pending").' <br>'.($records[0]['ptdate'] != ''?date("d-m-Y H:i a",strtotime($records[0]['ptdate'])):'').'</td>';	
		}
		if($this->input->post("subject_id") == 296 || $this->input->post("subject_id") == 234 ){
			if($records){ for($i=0;$i<count($records);$i++){
				if ($records[$i]['theory']>0) {
				$c+=1;
			}
			if ($records[$i]['theory']==0) {
				$p+=1;
			}
			
		}
			$html.= '<td style="color:'.($c>$p?"green":"red").'">'.($c>$p?"Completed":"Pending").' <br>'.($records[0]['theory_date'] != ''?date("d-m-Y H:i a",strtotime($records[0]['theory_date'])):'').'</td>';
		
			}
		if($records){ for($i=0;$i<count($records);$i++){

			if ($records[$i]['practical']>0) {
				$c+=1;
			}
			if ($records[$i]['practical']==0) {
				$p+=1;
			}
			
		}
			$html.= '<td style="color:'.($c>$p?"green":"red").'">'.($c>$p?"Completed":"Pending").' <br>'.($records[0]['practical_date'] != ''?date("d-m-Y H:i a",strtotime($records[0]['practical_date'])):'').'</td>';
		
			}
		}else{
			if($records){ for($i=0;$i<count($records);$i++){

			if ($records[$i]['half_yearly']>0) {
				$c+=1;
			}
			if ($records[$i]['half_yearly']==0) {
				$p+=1;
			}
			
		}
			$html.= '<td style="color:'.($c>$p?"green":"red").'">'.($c>$p?"Completed":"Pending").' <br>'.($records[0]['halfyearly_date'] != ''?date("d-m-Y H:i a",strtotime($records[0]['halfyearly_date'])):'').'</td>';
		
			}

		}

		$html.= '</tr></table>';
	}else{
		$html = '<div style="overflow-x:auto;"><table class="table table-condensed table-bordered text-center" ><tr>
					
				<th style="font-size:15px;">Periodic Test 2</th>
				'.($this->input->post("subject_id") == 296 || $this->input->post("subject_id") == 234 ? '<th style="font-size:15px;">Theory</th><th style="font-size:15px;">Practical</th>':'
					<th style="font-size:15px;">M.Accessment</th>
					<th style="font-size:15px;">Portfolio</th>
					<th style="font-size:15px;">S.Enrichment</th>
					<th style="font-size:15px;">Annual</th>').'
					

		</tr><tr>';
          //echo count($records); 
          $c=0;           
          $p=0;           
		if($records){ for($i=0;$i<count($records);$i++){

			if ($records[$i]['pt']>0) {
				$c+=1;
			}
			if ($records[$i]['pt']==0) {
				$p+=1;
			}
			
		}
			$html.= '<td style="color:'.($c>$p?"green":"red").'">'.($c>$p?"Completed":"Pending").' <br>'.($records[0]['ptdate'] != ''?date("d-m-Y H:i a",strtotime($records[0]['ptdate'])):'').'</td>';	
		}
		if($this->input->post("subject_id") == 296 || $this->input->post("subject_id") == 234 ){
			if($records){ for($i=0;$i<count($records);$i++){
				if ($records[$i]['theory']>0) {
				$c+=1;
			}
			if ($records[$i]['theory']==0) {
				$p+=1;
			}
			
		}
			$html.= '<td style="color:'.($c>$p?"green":"red").'">'.($c>$p?"Completed":"Pending").' <br>'.($records[0]['theory_date'] != ''?date("d-m-Y H:i a",strtotime($records[0]['theory_date'])):'').'</td>';
		
			}
		if($records){ for($i=0;$i<count($records);$i++){

			if ($records[$i]['practical']>0) {
				$c+=1;
			}
			if ($records[$i]['practical']==0) {
				$p+=1;
			}
			
		}
			$html.= '<td style="color:'.($c>$p?"green":"red").'">'.($c>$p?"Completed":"Pending").' <br>'.($records[0]['practical_date'] != ''?date("d-m-Y H:i a",strtotime($records[0]['practical_date'])):'').'</td>';
		
			}
		}else{
			if($records){ for($i=0;$i<count($records);$i++){

			if ($records[$i]['m_accessment']>0) {
				$c+=1;
			}
			if ($records[$i]['m_accessment']==0) {
				$p+=1;
			}
			
		}
			$html.= '<td style="color:'.($c>$p?"green":"red").'">'.($c>$p?"Completed":"Pending").' <br>'.($records[0]['m_accessment_date'] != ''?date("d-m-Y H:i a",strtotime($records[0]['m_accessment_date'])):'').'</td>';
		
			}
			if($records){ for($i=0;$i<count($records);$i++){

			if ($records[$i]['portfolio']>0) {
				$c+=1;
			}
			if ($records[$i]['portfolio']==0) {
				$p+=1;
			}
			
		}
			$html.= '<td style="color:'.($c>$p?"green":"red").'">'.($c>$p?"Completed":"Pending").' <br>'.($records[0]['portfolio_date'] != ''?date("d-m-Y H:i a",strtotime($records[0]['portfolio_date'])):'').'</td>';
		
			}
			if($records){ for($i=0;$i<count($records);$i++){

			if ($records[$i]['sub_enrichment']>0) {
				$c+=1;
			}
			if ($records[$i]['sub_enrichment']==0) {
				$p+=1;
			}
			
		}
			$html.= '<td style="color:'.($c>$p?"green":"red").'">'.($c>$p?"Completed":"Pending").' <br>'.($records[0]['sub_enrichment_date'] != ''?date("d-m-Y H:i a",strtotime($records[0]['sub_enrichment_date'])):'').'</td>';
		
			}
			if($records){ for($i=0;$i<count($records);$i++){

			if ($records[$i]['half_yearly']>0) {
				$c+=1;
			}
			if ($records[$i]['half_yearly']==0) {
				$p+=1;
			}
			
		}
			$html.= '<td style="color:'.($c>$p?"green":"red").'">'.($c>$p?"Completed":"Pending").' <br>'.($records[0]['halfyearly_date'] != ''?date("d-m-Y H:i a",strtotime($records[0]['halfyearly_date'])):'').'</td>';
		
			}


		}

		$html.= '</tr></table>';
	}
		
		
		
		echo $html;
	}
	function getSubjectsListByClass99(){
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$rec = $this->Common_Model->FetchData("teacher_class_subject_tag", "*", "class_id = ".$this->input->post('class_id')." AND section_id =".$this->input->post('section')." AND teacher_id =".$this->input->post('teacher_id')."");
		$html = '<option value="">select</option>';
		if($rec){ for($i=0;$i<count($rec);$i++){
			$records = $this->Common_Model->FetchData("subjects", "*", "subject_id = ".$rec[$i]['subject_id']);
			$html.= '<option value="'.$records[0]['subject_id'].'">'.$records[0]['subject_name'].'</option>';
		}}
		echo $html;
	}
	
	function getStudentListBySessionClasssec(){
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$records = $this->Common_Model->FetchData("student_admission AS sa LEFT JOIN students AS s ON sa.student_id = s.student_id", "s.student_id, s.student_first_name, s.student_last_name", "sa.class_id = ".$this->input->post("class_id")." AND sa.session_id = ".$this->input->post("session_id")." AND s.student_section = ".$this->input->post("student_section")." AND admission_status = 'Active' ORDER BY s.student_first_name ASC");
		$html = '<table class="table table-condensed table-bordered"><tr><th>Name</th><th colspan="2">Status</th><th>Remarks</th></tr>';
		if($records){ for($i=0;$i<count($records);$i++){
			$html.= '<option value="'.$records[$i]['student_id'].'">'.$records[$i]['student_first_name'].' '.$records[$i]['student_last_name'].'</option>';
		}}
		$html.= '</table>';
		echo $html;
	}
	function getotherSubjectsListByClass9(){
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$teacher_id = $this->session->userdata('employee_tagged_id');
		//print_r($this->session->userdata('employee_id'));exit;
		$section =  $this->input->post("section");
		$class_id =  $this->input->post("class_id");
		$rec = $this->Common_Model->FetchData("teacher_class_subject_tag", "*", "class_id = ".$class_id." AND section_id =".$section." AND teacher_id =".$teacher_id."");
		
		$html = '<option value="">select</option>';
		if($rec){ for($i=0;$i<count($rec);$i++){
				$records = $this->Common_Model->FetchData("subjects", "*", "subject_id = ".$rec[$i]['subject_id']." AND subject_no ='100'");
			$html.= '<option value="'.$records[0]['subject_id'].'">'.$records[0]['subject_name'].'</option>';
		}}
		echo $html;
	}

	function getotherSubjectsListByClass(){
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$records = $this->Common_Model->FetchData("subjects", "*", "class_id = ".$this->input->post("class_id")." AND subject_no ='100'");
		$html = '<option value="">select</option>';
		if($records){ for($i=0;$i<count($records);$i++){
			$html.= '<option value="'.$records[$i]['subject_id'].'">'.$records[$i]['subject_name'].'</option>';
		}}
		echo $html;
	}

	public function ledgerbank_details($did=0)
	{	
		$ledger_id = $_GET['ledger_id'];
		if (isset($_GET['did']) && $_GET['did']>0) {
			$did=$_GET['did'];
		}
		
		$data = array();
		$data['ledger_id'] = $ledger_id;
		$data['did'] = $did;
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		if($this->input->post('submitBtn')){
			$ledgerId = $this->input->post('ledger_id');
			$this->form_validation->set_rules('ledger_id', 'Ledger Id', 'trim|required');
			$this->form_validation->set_error_delimiters('<p class="has-error"><label class="control-label">', '</label></p>');
			if($this->form_validation->run()){
				$data_list = array(
					'bankac_no'			=> $this->input->post('bankac_no'),
					'acholder_name'		=> $this->input->post('acholder_name'),
					'bank_name'			=> $this->input->post('bank_name'),
					'bankbranch_name'	=> $this->input->post('bankbranch_name'),
					'bank_city'			=> $this->input->post('bank_city'),
					'ifsc_code'			=> $this->input->post('ifsc_code'),
					'micr_code'			=> $this->input->post('micr_code'),
					'ledger_id'			=> $ledgerId,
					'bankdetails_entry'	=> date('Y-m-d H:i:s'),
					
				);
				if($did > 0){					
					$id = $this->Common_Model->update_records('ledgerbank_details', 'bankdetails_id', $did, $data_list);
					$this->session->set_flashdata('success', 'Bank Details Update successfully.' );
				redirect('masters/ledgerbank_details?ledger_id='.$ledgerId);
				}else{
				$id = $this->Common_Model->dbinsertid("ledgerbank_details", $data_list);
				}

				$this->session->set_flashdata('success', 'Bank Details Added successfully.' );
				redirect('masters/ledgerbank_details?ledger_id='.$ledgerId);
			}else{
				$this->session->set_flashdata('error', validation_errors());
				redirect('masters/ledgerbank_details?ledger_id='.$ledgerId);
			}
		}
		if($this->input->post('default_ac')){
			$this->Common_Model->db_query("UPDATE ledgerbank_details SET default_ac = ''");
			$this->Common_Model->db_query("UPDATE ledgerbank_details SET default_ac = 'Active' WHERE bankdetails_id = ".$this->input->post('default_ac'));
			
		}
		$data['activemenu'] = 'masters';
		$data['submainmenu'] = 'ledgermaster';
		$data['mainmenu'] = 'ledger';
		$data['activesubmenu'] = 'list_ledger';
		$data['ledger'] = $this->Common_Model->FetchData("ledgers as a LEFT JOIN under_group as b on a.acount_group=b.group_id", "*", "ledger_id = $ledger_id");
		$data['records'] = $this->Common_Model->FetchData("ledgerbank_details", "*", "ledger_id=".$ledger_id." ORDER BY bankdetails_id DESC");
		$data['rec'] = $this->Common_Model->FetchData("ledgerbank_details", "*", "bankdetails_id = $did");
		$this->load->view('masters/ledgerbank_details', $data);
	}

	function deletebank_details($did = 0){
		
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$this->Common_Model->DelData("ledgerbank_details", "bankdetails_id = ".$did);
		$this->session->set_flashdata('success', 'Record deleted successfully.' );
		redirect($_SERVER['HTTP_REFERER']);
	}

	public function contractedpost($unit_id = 0,$contractedpost_id=0)
	{
		error_reporting(0);
		$data = array();
		
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		if($this->input->post('submitBtn')){
			
			$this->form_validation->set_rules('post_designation', 'Designation', 'trim|required');
			//$this->form_validation->set_message('is_unique', 'Duplicate units .');
			$this->form_validation->set_error_delimiters('<p class="has-error"><label class="control-label">', '</label></p>');
			if($this->form_validation->run()){

				$duplicate = $this->Common_Model->FetchData("contractedpost","*","post_designation = ".$this->input->post('post_designation')." AND unit_id=".$unit_id."");
				if ($duplicate && $contractedpost_id == 0) {
					$this->session->set_flashdata('error', 'Duplicate Post Found !' );
				}else{

				$data_list = array(
					'unit_id'       	=> $unit_id,
					'post_designation'  => $this->input->post('post_designation'),
					'duty_hrs'     		=> $this->input->post('duty_hrs'),
					'en_fee'     		=> $this->input->post('en_fee'),
					'post_strength'     => $this->input->post('post_strength'),
					'postcreated_by'	=> $this->session->userdata('user_id'),
					'postcreated_on'	=> date('Y-m-d H:i:s')
				);
				if ($contractedpost_id>0) {
					$this->Common_Model->update_records("contractedpost","contractedpost_id", $contractedpost_id, $data_list);
					$this->session->set_flashdata('success', 'Data Updated successfully.' );
				}else{
					$id = $this->Common_Model->dbinsertid("contractedpost", $data_list);
					$this->session->set_flashdata('success', 'Data Added successfully.' );
				}
			}
				
				redirect('masters/viewunit/'.$unit_id.'');
			}else{
				$this->session->set_flashdata('error', validation_errors());
			}
		}
		
	}

	function deletecontractedpost($contractedpost_id = 0){
		
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$this->Common_Model->DelData("contractedpost", "contractedpost_id = ".$contractedpost_id);
		$this->session->set_flashdata('success', 'Record deleted successfully.' );
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	public function bonusleavewages($unit_id = 0)
	{
	    $data['unit_id'] = $unit_id;
		error_reporting(0);
		$data = array();
		
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		if($this->input->post('submitBtn')){
			
			$this->form_validation->set_rules('leave_wages', 'Designation', 'trim|required');
			
			$this->form_validation->set_error_delimiters('<p class="has-error"><label class="control-label">', '</label></p>');
			if($this->form_validation->run()){

			$duplicate = $this->Common_Model->FetchData("bonusleavewages","*","unit_id=".$unit_id." AND designation_id=".$this->input->post('designation_id'));
				

				$data_list = array(
					'unit_id'       	=> $unit_id,
					'designation_id'    => $this->input->post('designation_id'),
					'bonus'             => $this->input->post('bonus'),
					'bonusonamount'     => $this->input->post('bonusonamount'),
					'bonus_asperamount' => $this->input->post('bonus_asperamount'),
					'leave_wages'     	=> $this->input->post('leave_wages'),
					'leaveonamount'     => $this->input->post('leaveonamount'),
					'leave_asperamount' => $this->input->post('leave_asperamount')
				);
				//print_r($data_list);exit;
				if ($duplicate) {
					
					$this->Common_Model->db_query("UPDATE bonusleavewages SET bonus = '".$this->input->post('bonus')."',bonusonamount = '".$this->input->post('bonusonamount')."',bonus_asperamount = '".$this->input->post('bonus_asperamount')."', leave_wages = '".$this->input->post('leave_wages')."',leaveonamount = '".$this->input->post('leaveonamount')."',leave_asperamount = '".$this->input->post('leave_asperamount')."' WHERE id=".$duplicate[0]['id']."");
					$this->session->set_flashdata('success', 'Data Updated successfully.' );
				}else {
					$id = $this->Common_Model->dbinsertid("bonusleavewages", $data_list);
					$this->session->set_flashdata('success', 'Data Added successfully.' );
				}
		
				
				redirect('masters/viewunit/'.$unit_id.'');
			}else{
				$this->session->set_flashdata('error', validation_errors());
			}
		}
		
		$data['records'] = $this->Common_Model->FetchData("bonusleavewages", "*", "1");
		$this->load->view('masters/viewunit', $data);
		
	}
	
	function deletebonusleave($id=0){
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$this->Common_Model->DelData("bonusleavewages", "id = ".$id);
		$this->session->set_flashdata('success', 'Record deleted successfully.' );
		redirect($_SERVER['HTTP_REFERER']);
	}

	public function listunits()
	{
		error_reporting(0);
		$data = array();
		$this->load->helper('url');
		$currentURL = current_url();
		$data = array();
		$sql = "1";
		$queryvars = "";
		if(isset($_REQUEST['unit_id']) && $_REQUEST['unit_id'] != ''){
			$sql.= " AND unit_id = '".$_REQUEST['unit_id']."'";
			$queryvars.= "&unit_id=".$_REQUEST['unit_id'];
		}
		if(isset($_REQUEST['unit_name']) && $_REQUEST['unit_name'] != ''){
			$sql.= " AND unit_name LIKE '%".$_REQUEST['unit_name']."%'";
			$queryvars.= "&unit_name=".$_REQUEST['unit_name'];
		}
		
		$sql.= " ORDER BY unit_id DESC";
		$rows = $this->Common_Model->FetchRows("units", "*", "$sql");
		$data['page_num'] = $page_num = isset($_REQUEST['page']) ? $_REQUEST['page'] : 1;
		$this->load->library("Paginator");
		$this->paginator->setparam(array("page_num" => $page_num, "num_rows" => $rows));
		$this->paginator->set_Limit(100);
		$range1 = $this->paginator->getRange1();
		$range2 = $this->paginator->getRange2();

		$sql .= " LIMIT ".$range1.', '.$range2;
		$records = $this->Common_Model->db_query("SELECT * FROM units WHERE ".$sql);

		$paging_info = $this->paginator->DBPagingNav($queryvars, $currentURL);

		$data['tot_page'] = $paging_info[0];
		$data['sPages'] = $paging_info[1];
		$data['rows'] = $rows;
		$data['records'] = $records;
		
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		
		$data['activemenu'] = 'masters';
		$data['submainmenu'] = 'unitparameter';
		$data['activesubmenu'] = 'listunits';
		//$data['records'] = $this->Common_Model->FetchData("units", "*", "1 ORDER BY unit_id DESC");
		$this->load->view('masters/listunits', $data);
	}

	public function viewunit($unit_id = 0,$id = 0,$bonusleave_id=0)
	{
		error_reporting(0);
		$data = array();
		$data['unit_id'] = $unit_id;
		
		$data['salrate_id'] = $salrate_id;
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		
		$data['activemenu'] = 'masters';
		$data['submainmenu'] = 'unitparameter';
		$data['activesubmenu'] = 'listunits';
		$data['records'] = $this->Common_Model->FetchData("units", "*", "unit_id=".$unit_id."");
		$data['rec'] = $this->Common_Model->FetchData("contractedpost", "*", "contractedpost_id=".$id."");

		$data['unit'] = $this->Common_Model->FetchData("units", "*", "unit_id=".$unit_id."");
		
		$data['bonusleave'] = $this->Common_Model->FetchData("bonusleavewages as a LEFT JOIN designation as b on a.designation_id=b.designation_id", "*", "a.unit_id=".$unit_id."");
        
        $data['bonusleaverec'] = $this->Common_Model->FetchData("bonusleavewages ", "*", "id=".$bonusleave_id."");
        
		$data['conpost'] = $this->Common_Model->FetchData("contractedpost as a LEFT JOIN designation as b on a.post_designation=b.designation_id", "*", "a.unit_id=".$unit_id." order by a.contractedpost_id DESC");

		$data['desig'] = $this->Common_Model->FetchData("contractedpost as a LEFT JOIN designation as b on a.post_designation=b.designation_id", "*", "unit_id=".$unit_id." order by designation_id ASC");

		$data['designation'] = $this->Common_Model->FetchData("designation", "*", "1 order by designation_id ASC");

		$data['salrate'] = $this->Common_Model->FetchData("salary_rates as a LEFT JOIN designation as b on a.designation_id=b.designation_id LEFT JOIN contractedpost as c on a.designation_id=c.post_designation AND c.unit_id='".$unit_id."'", "*", "a.unit_id='".$unit_id."' order by a.salary_rates_id ASC");


		//$data['salratedata'] = $this->Common_Model->FetchData("salary_rates as a LEFT JOIN designation as b on a.designation_id=b.designation_id LEFT JOIN contractedpost as c on a.designation_id=c.post_designation", "*", "a.unit_id=".$unit_id." AND a.salary_rates_id=".$salrate_id."");

		$this->load->view('masters/viewunit', $data);
	}

	public function salarysettings($unit_id = 0)
	{
		error_reporting(0);
		$data = array();
		$data['unit_id'] = $unit_id;
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		if($this->input->post('submitBtn')){
			
			$this->form_validation->set_rules('pfchallan_group', 'PF Challan Group', 'trim|required');
			//$this->form_validation->set_message('is_unique', 'Duplicate units .');
			$this->form_validation->set_error_delimiters('<p class="has-error"><label class="control-label">', '</label></p>');
			if($this->form_validation->run()){

					$data_list = array(
					
					'separate_ot'  		=> $this->input->post('separate_ot'),
					'esion_ot'     		=> $this->input->post('esion_ot'),
					'ot_payable'     	=> $this->input->post('ot_payable'),
					'ot_display'		=> $this->input->post('ot_display'),
					'separatepf_challan'=> $this->input->post('separatepf_challan'),
					'pfchallan_group'	=> $this->input->post('pfchallan_group'),
					'esichallan_zone'	=> $this->input->post('esichallan_zone'),
					'esilimit_applicable'=> $this->input->post('esilimit_applicable'),
					'salcycleday_from'	=> $this->input->post('salcycleday_from'),
					'salcycleday_to'	=> $this->input->post('salcycleday_to'),
					'unitmonth_days'	=> $this->input->post('unitmonth_days'),
					'exclude_sunday'	=> $this->input->post('exclude_sunday'),
					'uniform_ded'		=> $this->input->post('uniform_ded'),
					'ptax_ded'			=> $this->input->post('ptax_ded'),
					'bonus_period'		=> $this->input->post('bonus_period'),
					'bonus_on'			=> $this->input->post('bonus_on'),
					'paybonus_limit'	=> $this->input->post('paybonus_limit'),
					'gratuity_period'	=> $this->input->post('gratuity_period'),
					'gratuity_days'		=> $this->input->post('gratuity_days'),
					'gratuity_rate'		=> $this->input->post('gratuity_rate')
					

				);

					$this->Common_Model->update_records("units","unit_id", $unit_id, $data_list);
					$this->session->set_flashdata('success', 'Data Updated successfully.' );

				redirect('masters/viewunit/'.$unit_id.'');
			}else{
				$this->session->set_flashdata('error', validation_errors());
				redirect('masters/viewunit/'.$unit_id.'');
			}
		}
		
	}

	public function salaryrates($unit_id = 0)
	{
		error_reporting(0);
		$data = array();
		$data['unit_id'] = $unit_id;
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		if($this->input->post('submitBtn')){
			
			$this->form_validation->set_rules('designation_id', 'Designation', 'trim|required');
			//$this->form_validation->set_message('is_unique', 'Duplicate units .');
			$this->form_validation->set_error_delimiters('<p class="has-error"><label class="control-label">', '</label></p>');
			if($this->form_validation->run()){

					$data_list = array(
					
					'unit_id'  				=> $unit_id,
					'designation_id'    	=> $this->input->post('designation_id'),
					//'ot_on'     			=> $this->input->post('ot_on'),
					//'otday_rate'			=> $this->input->post('otday_rate'),
					//'per_ot'				=> $this->input->post('per_ot'),
					'month_day'				=> $this->input->post('month_day'),
					//'ment_ded'				=> $this->input->post('ment_ded'),
					//'pf_limit'				=> $this->input->post('pf_limit'),
					//'pfasperduty'			=> $this->input->post('pfasperduty'),
					//'thrper_hour'			=> $this->input->post('thrper_hour'),
					//'otmonth_day'			=> $this->input->post('otmonth_day'),
					'other_ded'				=> $this->input->post('other_ded'),
					'othded_asperduty'				=> $this->input->post('othded_asperduty'),
					'pfcalc_days'			=> $this->input->post('pfcalc_days'),
					'gross'					=> $this->input->post('gross'),
					'pfded'					=> $this->input->post('pfded'),
					'esi_ded'				=> $this->input->post('esi_ded'),
					//'lwf_ded'				=> $this->input->post('lwf_ded'),
					'food'					=> $this->input->post('food'),
					'food_asperduty'		=> $this->input->post('food_asperduty'),
					'accmd'					=> $this->input->post('accmd'),
					'accmd_asperduty'		=> $this->input->post('accmd_asperduty'),
					'uniform'				=> $this->input->post('uniform'),
					'uniform_asperduty'		=> $this->input->post('uniform_asperduty'),
					'netinhand'				=> $this->input->post('netinhand'),
					'srcreated_by'			=> $this->session->userdata('user_id'),
					'srcreated_on'			=> date('Y-m-d H:i:s'),
					'bonus'					=> $this->input->post('bonusamt'),
					'lv_wage'				=> $this->input->post('leave'),
					'totbasic'				=> $this->input->post('totbasic'),
					'totextrawork'			=> $this->input->post('totextrawork'),
					'totallowance'			=> $this->input->post('totallowance'),
					'bonusamt'				=> $this->input->post('bonusamt'),
					'epfamt'					=> $this->input->post('epfamt'),
					'esiamt'					=> $this->input->post('esiamt'),
					'totdeduction'			=> $this->input->post('totdeduction'),
					'basic_cat'			=> $this->input->post('basic_cat'),
					'pfon_amt'			=> $this->input->post('pfon_amt'),
					'thirty_one'			=> $this->input->post('thirty_one'),
					'thirty'			=> $this->input->post('thirty'),
					'twenty_nine'			=> $this->input->post('twenty_nine'),
					'twenty_eight'			=> $this->input->post('twenty_eight'),
					'month'					=> date('Y-m-d',strtotime($this->input->post('month'))),
					'oton_amt'				=> $this->input->post('oton_amt'),
					'ot_asperduty'			=> $this->input->post('ot_asperduty')
					
					

				);

					if ($this->input->post('salrate_id') > 0) {
						$this->Common_Model->update_records("salary_rates","salary_rates_id", $this->input->post('salrate_id'), $data_list);

						$this->Common_Model->DelData("salary_rates_items","salary_rates_id=".$this->input->post('salrate_id')."");

						for ($i=0; $i < count($this->input->post('wages_id')); $i++) { 
							$wages_list = array(
								'salary_rates_id' 	=> $this->input->post('salrate_id'), 
								'wages_id' 			=> $this->input->post('wages_id')[$i], 
								'wages_name' 		=> $this->input->post('wages_name')[$i], 
								'amount' 			=> $this->input->post('amount')[$i], 
								'pfamount' 			=> $this->input->post('pfamount')[$i], 
								'esiamount' 		=> $this->input->post('esiamount')[$i], 
								'pf' 				=> $this->input->post('pf')[$i], 
								'esi' 				=> $this->input->post('esi')[$i], 
								'fixrate' 			=> $this->input->post('fixrate')[$i] 
							);


							 $this->Common_Model->dbinsertid("salary_rates_items",$wages_list);
						}

						$this->session->set_flashdata('success', 'Data Updated successfully.' );
					}else{
						$salary_rates_id = $this->Common_Model->dbinsertid("salary_rates", $data_list);

						if ($salary_rates_id) {
						for ($i=0; $i < count($this->input->post('wages_id')); $i++) { 
							$wages_list = array(
								'salary_rates_id' 	=> $salary_rates_id, 
								'wages_id' 			=> $this->input->post('wages_id')[$i], 
								'wages_name' 		=> $this->input->post('wages_name')[$i], 
								'amount' 			=> $this->input->post('amount')[$i],
								'pfamount' 			=> $this->input->post('pfamount')[$i], 
								'esiamount' 		=> $this->input->post('esiamount')[$i], 
								'pf' 				=> $this->input->post('pf')[$i], 
								'esi' 				=> $this->input->post('esi')[$i], 
								'fixrate' 			=> $this->input->post('fixrate')[$i] 
							);

							$salary_rates_items_id = $this->Common_Model->dbinsertid("salary_rates_items",$wages_list);
						}
					}

					$this->session->set_flashdata('success', 'Data Added successfully.' );

					}
					

				redirect('masters/viewunit/'.$unit_id.'');
			}else{
				$this->session->set_flashdata('error', validation_errors());
				redirect('masters/viewunit/'.$unit_id.'');
			}
		}
		
	}

	function delete_salaryrates($salary_rates_id = 0){
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$this->Common_Model->DelData("salary_rates", "salary_rates_id = ".$salary_rates_id);
		$this->Common_Model->DelData("salary_rates_items", "salary_rates_id = ".$salary_rates_id);
		$this->session->set_flashdata('success', 'Record deleted successfully.' );
		redirect($_SERVER['HTTP_REFERER']);
	}

	function get_SalrateData(){
		error_reporting(0);
		$designation_id = $this->input->post('designation_id');
		$unit_id = $this->input->post('unit_id');

		$start  = $this->session->userdata("session_start_date");
        $end = $this->session->userdata("session_end_date");
		$months = $this->Common_Model->list_months($start,$end, 'd-m-Y');


		$records = $this->Common_Model->FetchData("salary_rates","*","designation_id=".$designation_id." AND unit_id=".$unit_id."");
		$recs = $this->Common_Model->FetchData("bonusleavewages","*","unit_id=".$unit_id." AND designation_id=".$designation_id);
		if(!empty($records[0]['salary_rates_id'])){
		   $wagebasic = $this->Common_Model->FetchData("salary_rates_items","*","salary_rates_id=".$records[0]['salary_rates_id']." AND wages_id=6"); 
		}
		
		$epf  = $wagebasic[0]['amount']*12/100;
		$esic = $wagebasic[0]['amount']*0.75/100;
		$epfesicdeduct = $epf+$esic;
		if ($records) {
			$html='<div class="row">
				<input type="hidden" name="salrate_id" value="'.$records[0]['salary_rates_id'].'">
				<input type="hidden" name="bonuspercent" id="bonuspercent" value="'.($recs[0]['bonus']?$recs[0]['bonus']:0).'">
				<input type="hidden" name="bonusonamount" id="bnsonamount" value="'.($recs[0]['bonusonamount']?$recs[0]['bonusonamount']:0).'">
				<input type="hidden" name="bonus_asperamount" id="bns_asperamount" value="'.($recs[0]['bonus_asperamount']?$recs[0]['bonus_asperamount']:'').'">
				<input type="hidden" name="leavepercent" id="leavepercent" value="'.($recs[0]['leave_wages']?$recs[0]['leave_wages']:0).'">
				<input type="hidden" name="leaveonamount" id="lveonamount" value="'.($recs[0]['leaveonamount']?$recs[0]['leaveonamount']:0).'">
				<input type="hidden" name="leave_asperamount" id="lve_asperamount" value="'.($recs[0]['leave_asperamount']?$recs[0]['leave_asperamount']:'').'">
				<input type="hidden" name="month_day" id="month_day" value="'.$records[0]['month_day'].'">
                                
                <div class="col-md-12">
					<label>Wages Days ( If month days is )</label>
				</div>
						 	<div class="form-group col-md-2">
                                 <label for="thirty_one">31 Days</label> 
                                <input type="number" name="thirty_one" id="thirty_one" class="form-control input-sm calc_amt" value="'.$records[0]['thirty_one'].'">
                                        
                            </div>
                             <div class="form-group col-md-2">
                                 <label for="thirty">30 Days</label> 
                                <input type="number" name="thirty" id="thirty" class="form-control input-sm calc_amt" value="'.$records[0]['thirty'].'">
                                        
                            </div>
                            <div class="form-group col-md-2">
                                 <label for="twenty_nine">29 Days</label> 
                                <input type="number" name="twenty_nine" id="twenty_nine" class="form-control input-sm calc_amt" value="'.$records[0]['twenty_nine'].'">
                                        
                            </div>
                            <div class="form-group col-md-2">
                                 <label for="twenty_eight">28 Days</label> 
                                <input type="number" name="twenty_eight" id="twenty_eight" class="form-control input-sm calc_amt" value="'.$records[0]['twenty_eight'].'">
                                        
                            </div> 

                        
                                
                              
                                

                              <!--  <div class="form-group col-md-2">
                                    <label for="pfcalc_days">PF Calc.Days</label>
                                    <input type="number" class="form-control input-sm calc_amt" id="pfcalc_days" name="pfcalc_days" value="'.$records[0]['pfcalc_days'].'">
                                </div> -->
                                
                            </div>
                            <div class="row">
                               <div class="form-group col-md-2">
                                    <label for="month_day">Month</label>
                                    <select class="form-control input-sm calc_amt" id="month" name="month" >
                                    	<option value="">Select</option>';
                                    for ($i=0; $i < count($months) ; $i++) {
                                    $html.='<option value="'.$months[$i].'" '.($months[$i]==date('d-m-Y',strtotime($records[0]['month']))?'selected':'').' firstdate="'.date("Y-m-01",strtotime($months[$i])).'" lastdate="'.date("Y-m-t",strtotime($months[$i])).'">'.date("F",strtotime($months[$i])).'</option>'; 
				                          
				                      }
				                  $html.='   </select> 
                                </div>
                              <div class="form-group col-md-2">
                                 <label for="esi">ESI ( on gross )</label> 
                                <select name="esi_ded" id="esi_ded" class="form-control input-sm calc_amt">
                                        <option value="No" '.($records[0]['esi_ded']=='No'?'selected':'').'>No</option>
                                        <option value="Yes" '.($records[0]['esi_ded']=='Yes'?'selected':'').'>Yes</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-2">
                                 <label for="esi">Basic</label> 
                                	<select name="basic_cat" id="basic_cat" class="form-control input-sm calc_amt">
                                        <option value="Flexible" '.($records[0]['basic_cat']=='Flexible'?'selected':'').'>Flexible</option>
                                        <option value="Fix" '.($records[0]['basic_cat']=='Fix'?'selected':'').'>Fix</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="pfcalc_days">PF On (Rs.)</label>
                                    <input type="number" class="form-control input-sm calc_amt" id="pfon_amt" name="pfon_amt" value="'.$records[0]['pfon_amt'].'" step="0.01">
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="otcalc_days">OT Amount</label>
                                    <input type="number" class="form-control input-sm calc_amt" id="oton_amt" name="oton_amt" value="'.$records[0]['oton_amt'].'" step="0.01">
	                             </div>
	                            <div class="form-group col-md-2" style="margin-top:25px;">
                                    <input type="checkbox" id="ot_asperduty" name="ot_asperduty" value="Yes" class="calc_amt" '.($records[0]['ot_asperduty']=='Yes'?'checked':'').'> <label>As Per Day</label>
                                </div>
                                
                                
                            </div>


                            <br>
                            <table class="table" cellpadding="0" border="0">
                            <tr style="background-color:#f2fce3;">
                            	<th width="10%">Sl No</th> 
	                            <th width="40%">Wages Head</th> 
	                           	<th width="14%" class="text-center">Amount</th> 
                               	<th width="12%" class="text-center">PF</th>
                               	<th width="12%" class="text-center">ESI</th>
                               	<th width="12%" class="text-center">FixRate</th> 
                            </tr>
                               ';
                     $wages = $this->Common_Model->FetchData("wages","*","1 order by sequence ASC"); 
                        if ($wages) { for ($i=0; $i <count($wages) ; $i++) {
                        $wageval = $this->Common_Model->FetchData("salary_rates_items","*","salary_rates_id=".$records[0]['salary_rates_id']." AND wages_id=".$wages[$i]['wages_id']."");

                            $html.='<tr style="border:hidden;">
                               <td width="10%">'.($i + 1).'</td> 
                               <td width="40%">'.$wageval[0]['wages_name'].'
                                   
                                   <input type="hidden" class="form-control input-sm wages_id" name="wages_id[]" value="'.$wageval[0]['wages_id'].'">
                                    <input type="hidden" class="form-control input-sm" name="wages_name[]" value="'.$wageval[0]['wages_name'].'">
                               </td> 
                               <td width="14%">
                                    <input type="number" class="form-control input-sm calc_amt amount " name="amount[]" step="0.01" id="'.($wages[$i]['wages_id']==6?'basicamount':'').'" value="'.$wageval[0]['amount'].'">
                                </td> 
                               <td width="12%" class="text-center">
                                   <input type="checkbox" name="wpf[]" class="wpf calc_amt" value="Yes" '.($wageval[0]['wages_id']==6?'':'disabled').' id="'.($wageval[0]['wages_id']==6?'basicpf':'').'" '.($wageval[0]['pf']=='Yes'?'checked':'').'>
                                   <input type="hidden" name="pf[]" class="form-control input-sm pf" value="'.$wageval[0]['pf'].'" >
                                   <input type="hidden" name="pfamount[]" class="form-control input-sm pfamount" value="'.$wageval[0]['pfamount'].'" step="0.01">
                               </td>
                               <td width="12%" class="text-center">
                                   <input type="checkbox" name="wesi[]" class="wesi calc_amt" value="Yes" id="'.($wages[$i]['wages_id']==6?'basicesi':'').'" '.($wageval[0]['esi']=='Yes'?'checked':'').'>
                                   <input type="hidden" name="esi[]" class="form-control input-sm esi" value="'.$wageval[0]['esi'].'">
                                   <input type="hidden" name="esiamount[]" class="form-control input-sm esiamount" value="'.$wageval[0]['esiamount'].'" step="0.01">
                               </td>
                               <td width="12%" class="text-center">
                                   <input type="checkbox" name="wfixrate[]" class="wfixrate" value="Yes" disabled  '.($wageval[0]['fixrate']=='Yes'?'checked':'').'>
                                   <input type="hidden" name="fixrate[]" class="form-control input-sm fixrate" value="'.$wageval[0]['fixrate'].'" >
                               </td> 
                            </tr>';
                         }}

                        $html.='</table>
                        
                        <div class="row" style="margin-top:5px;">
                        		
                               <div class="col-md-2">
                                <label for="totbasic" style="margin-top:5px;">Basic</label> 
                                </div>
                                <div class="col-md-2">
                                <input type="number" class="form-control input-sm" id="totbasic" name="totbasic" value="'.$records[0]['totbasic'].'" readonly step="0.01">
                                      
                                </div>
                                <div class="col-md-2">
                                <label for="totextrawork" style="margin-top:5px;">Extra Work</label> 
                                </div>
                                <div class="col-md-2">
                                <input type="number" class="form-control input-sm" id="totextrawork" name="totextrawork" value="'.$records[0]['totextrawork'].'" readonly step="0.01">
                                      
                                </div>
                                <div class="col-md-2" >
	                                <label for="totallowance" style="margin-top:5px;">Allowance</label> 
	                                </div>
	                                <div class="col-md-2">
	                                <input type="number" class="form-control input-sm" id="totallowance" name="totallowance" value="'.$records[0]['totallowance'].'" readonly step="0.01">
	                                      
	                                </div>
                              </div>
                              <div class="row" style="margin-top:5px;">
                              
                                <div class="col-md-2">
                                <label for="bonusamt" style="margin-top:5px;">Bonus</label> 
                                </div>
                                <div class="col-md-2">
                                <input type="number" class="form-control input-sm" id="bonusamt" name="bonusamt" value="'.$records[0]['bonus'].'" readonly step="0.01">
                                      
                                </div>

                                <div class="col-md-2">
                                <label for="leave" style="margin-top:5px;">Leave</label> 
                                </div>
                                <div class="col-md-2">
                                <input type="number" class="form-control input-sm" id="leave" name="leave" value="'.$records[0]['lv_wage'].'" readonly step="0.01">
                                      
                                </div>
                             </div>
                              <div class="row" style="margin-top:5px;">

	                               <div class="col-md-2 col-sm-2 col-xs-2"><label>Gross</label></div> 
	                               <div class="col-md-2 col-sm-12 col-xs-12">
	                                   <input type="number" name="gross" id="gross" class="gross form-control input-sm" readonly value="'.$records[0]['gross'].'" step="0.01">
	                               </div>
                               
                        		</div>
                            
                   <div class="row">             
                <div class="col-md-12"  >
                    <div class="row" style="padding:5px;">
                    <div class="col-md-12">
                        <div class="col-md-12" style="margin-top:15px;border: 1px solid #ddd;padding: 14px;border-radius: 5px;">
                                <div class="icon icon-lg icon-shape" style="margin-top: -25px!important;">
                                    <span style="background-color: white;width: 100px;font-size: 12px;padding-left: 4px;padding-right: 4px;"> Deductions</span>
                                </div>
                            
                            <div class="col-md-6" style="padding:0;">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="food" style="margin-top:5px;">Food</label> 
                                    </div>
                                    <div class="col-md-4">
                                        <input type="number" class="form-control input-sm deduction_amt calc_amt" id="food" name="food" value="'.$records[0]['food'].'" step="0.01" readonly>     
                                    </div>
                                    <div class="col-md-4">
                                        <input type="checkbox" id="food_asperduty" name="food_asperduty" value="Yes" class="calc_amt" '.($records[0]['food_asperduty']=='Yes'?'checked':'').' disabled> <label>As Per Duty</label>      
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6" style="padding:0;">
                             <div class="row">
                            	<div class="col-md-4">
                            		<label for="other_ded" style="margin-top:5px;">Other Ded.</label>
                            	</div>
                            	<div class="col-md-4">
                                    <input type="number" class="form-control input-sm calc_amt deduction_amt" id="other_ded" name="other_ded" value="'.$records[0]['other_ded'].'" step="0.01">    
                                    </div>
                                    <div class="col-md-4">
                                        <input type="checkbox" id="othded_asperduty" name="othded_asperduty" value="Yes" class="calc_amt"  '.($records[0]['othded_asperduty']=='Yes'?'checked':'').'> <label>As Per Duty</label>     
                                    </div>
                                </div>
                               </div>
                            <div class="col-md-6" style="padding:0;margin-top: 5px;">
                                <div class="row">
                                    <div class="col-md-4">
                                    <label for="uniform" style="margin-top:5px;">Uniform</label> 
                                    </div>
                                    <div class="col-md-4">
                                    <input type="number" class="form-control input-sm deduction_amt calc_amt" id="uniform" name="uniform" value="'.$records[0]['uniform'].'" step="0.01" readonly>    
                                    </div>
                                    <div class="col-md-4">
                                        <input type="checkbox" id="uniform_asperduty" name="uniform_asperduty" value="Yes" class="calc_amt" '.($records[0]['uniform_asperduty']=='Yes'?'checked':'').' disabled> <label>As Per Duty</label>     
                                    </div>
                                </div>

                            </div>
                            
                            
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="col-md-12" style="padding:0;margin-top: 5px;" >
                        <div class="row">
                                

                                <div class="col-md-2">
                                <label for="epf" style="margin-top:5px;">EPF</label> 
                                </div>
                                <div class="col-md-2">
                                <input type="number" class="form-control input-sm" id="epf" name="epfamt" value="'.$records[0]['epfamt'].'" readonly step="0.01">
                                      
                                </div>
                                <div class="col-md-2">
                                <label for="esi" style="margin-top:5px;">ESI</label> 
                                </div>
                                <div class="col-md-2">
                                <input type="number" class="form-control input-sm" id="esi" name="esiamt" value="'.$records[0]['esiamt'].'" readonly step="0.01">
                                      
                                </div>
                                <div class="col-md-2">
                                <label for="totdeduction" style="margin-top:5px;">Other Deduction</label> 
                                </div>
                                <div class="col-md-2">
                                <input type="number" class="form-control input-sm" id="totdeduction" name="totdeduction" value="'.$records[0]['totdeduction'].'" readonly step="0.01">
                                      
                                </div>
                            </div>
                            <div class="row" style="margin-top:5px;">
                                <div class="col-md-2">
                                <label for="netinhand" style="margin-top:5px;">Net Inhand</label> 
                                </div>
                                <div class="col-md-2">
                                <input type="text" class="form-control input-sm" id="netinhand" name="netinhand" value="'.$records[0]['netinhand'].'" readonly >
                                      
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>



                            </div>';
		}else{

			
                        
			$html='
				<div class="row">
				<input type="hidden" name="salrate_id" value="">
				<input type="hidden" name="bonuspercent" id="bonuspercent" value="'.($recs[0]['bonus']?$recs[0]['bonus']:0).'">
				<input type="hidden" name="bonusonamount" id="bonusonamount" value="'.($recs[0]['bonusonamount']?$recs[0]['bonusonamount']:0).'">
				<input type="hidden" name="bonus_asperamount" id="bonus_asperamount" value="'.($recs[0]['bonus_asperamount']?$recs[0]['bonus_asperamount']:'').'">
				<input type="hidden" name="leavepercent" id="leavepercent" value="'.($recs[0]['leave_wages']?$recs[0]['leave_wages']:0).'">
				<input type="hidden" name="leaveonamount" id="leaveonamount" value="'.($recs[0]['leaveonamount']?$recs[0]['leaveonamount']:0).'">
				<input type="hidden" name="leave_asperamount" id="leave_asperamount" value="'.($recs[0]['leave_asperamount']?$recs[0]['leave_asperamount']:'').'">
				<input type="hidden" name="month_day" id="month_day" value="0">
                     <div class="col-md-12">
					<label>Wages Days ( If month days is )</label>
				</div>
						 	<div class="form-group col-md-2">
                                 <label for="thirty_one">31 Days</label> 
                                <input type="number" name="thirty_one" id="thirty_one" class="form-control input-sm calc_amt" value="0">
                                        
                            </div>
                             <div class="form-group col-md-2">
                                 <label for="thirty">30 Days</label> 
                                <input type="number" name="thirty" id="thirty" class="form-control input-sm calc_amt" value="0">
                                        
                            </div>
                            <div class="form-group col-md-2">
                                 <label for="twenty_nine">29 Days</label> 
                                <input type="number" name="twenty_nine" id="twenty_nine" class="form-control input-sm calc_amt" value="0">
                                        
                            </div>
                            <div class="form-group col-md-2">
                                 <label for="twenty_eight">28 Days</label> 
                                <input type="number" name="twenty_eight" id="twenty_eight" class="form-control input-sm calc_amt" value="0">
                                        
                            </div> 
                                
                                

                           </div>     
                            <div class="row">
                            <div class="form-group col-md-2">
                                    <label for="month_day">Month</label>
                                    <select class="form-control input-sm calc_amt" id="month" name="month" >
                                    	<option value="">Select</option>';
                                    for ($i=0; $i < count($months) ; $i++) {
                                    $html.='<option value="'.$months[$i].'" firstdate="'.date("Y-m-01",strtotime($months[$i])).'" lastdate="'.date("Y-m-t",strtotime($months[$i])).'">'.date("F",strtotime($months[$i])).'</option>'; 
				                          
				                      }	
                        $html.='</select>
                                </div>
                               
                               <!-- <div class="form-group col-md-2">
                                    <label for="pfcalc_days">PF Calc.Days</label>
                                    <input type="number" class="form-control input-sm calc_amt" id="pfcalc_days" name="pfcalc_days" value="0">
                                </div> -->
                                <div class="form-group col-md-2">
                                 <label for="esi">ESI ( on gross )</label> 
                                <select name="esi_ded" id="esi_ded" class="form-control calc_amt">
                                        <option value="No">No</option>
                                        <option value="Yes">Yes</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-2">
                                 <label for="esi">Basic</label> 
                                	<select name="basic_cat" id="basic_cat" class="form-control input-sm calc_amt">
                                        <option value="Flexible" >Flexible</option>
                                        <option value="Fix" >Fix</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="pfcalc_days">PF On (Rs.)</label>
                                    <input type="number" class="form-control input-sm calc_amt" id="pfon_amt" name="pfon_amt" value="0.00" step="0.01">
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="otcalc_days">OT Amount</label>
                                    <input type="number" class="form-control input-sm calc_amt" id="oton_amt" name="oton_amt" value="0.00" step="0.01">
	                             </div>
	                            <div class="form-group col-md-2" style="margin-top:25px;">
                                    <input type="checkbox" id="ot_asperduty" name="ot_asperduty" value="Yes" class="calc_amt"> <label>As Per Day</label>
                                </div>
                            </div>
                                
                                
                            </div>


                            <br>
                            <table class="table" cellpadding="0" border="0">
                            <tr style="background-color:#f2fce3;">
                            	<th width="10%">Sl No</th> 
	                            <th width="40%">Wages Head</th> 
	                           	<th width="14%" class="text-center">Amount</th> 
                               	<th width="12%" class="text-center">PF</th>
                               	<th width="12%" class="text-center">ESI</th>
                               	<th width="12%" class="text-center">FixRate</th> 
                            </tr>
                               ';
                     $wages = $this->Common_Model->FetchData("wages","*","1 order by sequence ASC"); 
                        if ($wages) { for ($i=0; $i <count($wages) ; $i++) { 
                            $html.='<tr style="border:hidden;">
                               <td width="10%">'.($i + 1).'</td> 
                               <td width="40%">'.$wages[$i]['wages_name'].'
                                   
                                   <input type="hidden" class="form-control input-sm wages_id" name="wages_id[]" value="'.$wages[$i]['wages_id'].'">
                                    <input type="hidden" class="form-control input-sm" name="wages_name[]" value="'.$wages[$i]['wages_name'].'">
                               </td> 
                               <td width="14%">
                                    <input type="number" class="form-control input-sm calc_amt amount " name="amount[]" step="0.01" id="'.($wages[$i]['wages_id']==6?'basicamount':'').'" value="0.00">
                                </td> 
                               <td width="12%" class="text-center">
                                   <input type="checkbox" name="wpf[]" class="wpf calc_amt" value="Yes" '.($wages[$i]['wages_id']==6?'':'disabled').' id="'.($wages[$i]['wages_id']==6?'basicpf':'').'">
                                   <input type="hidden" name="pf[]" class="form-control input-sm pf" value="">
                                   <input type="hidden" name="pfamount[]" class="form-control input-sm pfamount" value="0.00" step="0.01">
                               </td>
                               <td width="12%" class="text-center">
                                   <input type="checkbox" name="wesi[]" class="wesi calc_amt" value="Yes" id="'.($wages[$i]['wages_id']==6?'basicesi':'').'">
                                   <input type="hidden" name="esi[]" class="form-control input-sm esi" value="">
                                   <input type="hidden" name="esiamount[]" class="form-control input-sm esiamount" value="0.00" step="0.01">
                               </td>
                               <td width="12%" class="text-center">
                                   <input type="checkbox" name="wfixrate[]" class="wfixrate" value="Yes" disabled>
                                   <input type="hidden" name="fixrate[]" class="form-control input-sm fixrate" value="" >
                               </td> 
                            </tr>';
                         }}

                        $html.='</table>
                        
                        <div class="row" style="margin-top:5px;">
                        		
                               <div class="col-md-2">
                                <label for="totbasic" style="margin-top:5px;">Basic</label> 
                                </div>
                                <div class="col-md-2">
                                <input type="number" class="form-control input-sm" id="totbasic" name="totbasic" value="0.00" readonly step="0.01">
                                      
                                </div>
                                <div class="col-md-2">
                                <label for="totextrawork" style="margin-top:5px;">Extra Work</label> 
                                </div>
                                <div class="col-md-2">
                                <input type="number" class="form-control input-sm" id="totextrawork" name="totextrawork" value="0.00" readonly step="0.01">
                                      
                                </div>
                                <div class="col-md-2" >
	                                <label for="totallowance" style="margin-top:5px;">Allowance</label> 
	                                </div>
	                                <div class="col-md-2">
	                                <input type="number" class="form-control input-sm" id="totallowance" name="totallowance" value="0.00" readonly step="0.01">
	                                      
	                                </div>
                              </div>
                              <div class="row" style="margin-top:5px;">
                              
                                <div class="col-md-2">
                                <label for="bonusamt" style="margin-top:5px;">Bonus</label> 
                                </div>
                                <div class="col-md-2">
                                <input type="number" class="form-control input-sm" id="bonusamt" name="bonusamt" value="0.00" readonly step="0.01">
                                      
                                </div>

                                <div class="col-md-2">
                                <label for="leave" style="margin-top:5px;">Leave</label> 
                                </div>
                                <div class="col-md-2">
                                <input type="number" class="form-control input-sm" id="leave" name="leave" value="0.00" readonly step="0.01">
                                      
                                </div>
                             </div>
                              <div class="row" style="margin-top:5px;">

	                               <div class="col-md-2 col-sm-2 col-xs-2"><label>Gross</label></div> 
	                               <div class="col-md-2 col-sm-12 col-xs-12">
	                                   <input type="number" name="gross" id="gross" class="gross form-control input-sm" readonly value="0.00" step="0.01">
	                               </div>
                               
                        		</div>
                            
                   <div class="row">             
                <div class="col-md-12"  >
                    <div class="row" style="padding:5px;">
                    <div class="col-md-12">
                        <div class="col-md-12" style="margin-top:15px;border: 1px solid #ddd;padding: 14px;border-radius: 5px;">
                                <div class="icon icon-lg icon-shape" style="margin-top: -25px!important;">
                                    <span style="background-color: white;width: 100px;font-size: 12px;padding-left: 4px;padding-right: 4px;"> Deductions</span>
                                </div>
                            
                            <div class="col-md-6" style="padding:0;">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="food" style="margin-top:5px;">Food</label> 
                                    </div>
                                    <div class="col-md-4">
                                        <input type="number" class="form-control input-sm deduction_amt calc_amt" id="food" name="food" value="0.00" step="0.01" readonly>     
                                    </div>
                                    <div class="col-md-4">
                                        <input type="checkbox" id="food_asperduty" name="food_asperduty" value="Yes" class="calc_amt" disabled> <label>As Per Duty</label>      
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6" style="padding:0;">
                             <div class="row">
                            	<div class="col-md-4">
                            		<label for="other_ded" style="margin-top:5px;">Other Ded.</label>
                            	</div>
                            	<div class="col-md-4">
                                    <input type="number" class="form-control input-sm calc_amt deduction_amt" id="other_ded" name="other_ded" value="0.00" step="0.01">    
                                    </div>
                                    <div class="col-md-4">
                                        <input type="checkbox" id="othded_asperduty" name="othded_asperduty" value="Yes" class="calc_amt"> <label>As Per Duty</label>     
                                    </div>
                                </div>
                               </div>
                            <div class="col-md-6" style="padding:0;margin-top: 5px;">
                                <div class="row">
                                    <div class="col-md-4">
                                    <label for="uniform" style="margin-top:5px;">Uniform</label> 
                                    </div>
                                    <div class="col-md-4">
                                    <input type="number" class="form-control input-sm deduction_amt calc_amt" id="uniform" name="uniform" value="0.00" step="0.01" readonly>    
                                    </div>
                                    <div class="col-md-4">
                                        <input type="checkbox" id="uniform_asperduty" name="uniform_asperduty" value="Yes" class="calc_amt" disabled> <label>As Per Duty</label>     
                                    </div>
                                </div>

                            </div>
                            
                            
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="col-md-12" style="padding:0;margin-top: 5px;" >
                        <div class="row">
                                

                                <div class="col-md-2">
                                <label for="epf" style="margin-top:5px;">EPF</label> 
                                </div>
                                <div class="col-md-2">
                                <input type="number" class="form-control input-sm" id="epf" name="epfamt" value="0.00" readonly step="0.01">
                                      
                                </div>
                                <div class="col-md-2">
                                <label for="esi" style="margin-top:5px;">ESI</label> 
                                </div>
                                <div class="col-md-2">
                                <input type="number" class="form-control input-sm" id="esi" name="esiamt" value="0.00" readonly step="0.01">
                                      
                                </div>
                                <div class="col-md-2">
                                <label for="totdeduction" style="margin-top:5px;">Other Deduction</label> 
                                </div>
                                <div class="col-md-2">
                                <input type="number" class="form-control input-sm" id="totdeduction" name="totdeduction" value="0.00" readonly step="0.01">
                                      
                                </div>
                            </div>
                            <div class="row" style="margin-top:5px;">
                                <div class="col-md-2">
                                <label for="netinhand" style="margin-top:5px;">Net Inhand</label> 
                                </div>
                                <div class="col-md-2">
                                <input type="text" class="form-control input-sm" id="netinhand" name="netinhand" value="0.00" readonly >
                                      
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>



                            </div>
			';
		}
		echo $html;
	}

	function get_monthyear(){
		$date = $this->input->post("date");

		$start_date = date("Y-m-01",strtotime($date));
        $last_date = date("Y-m-t",strtotime($date));

        $start = new DateTime($start_date);
		$end = new DateTime($last_date);
		$end->modify('+1 day');
		$interval = $end->diff($start);
		$days = $interval->days;

		$period = new DatePeriod($start, new DateInterval('P1D'), $end);
		foreach($period as $dt) {
		    $curr = $dt->format('D');
		    if ($curr == 'Sun') {
		        $days--;
		    }
		    
		}
		$no_of_working_days = $days;

		$html = $no_of_working_days.'@#,';
		$html .= $interval->days.'@#,';
        echo $html;exit;
	}
	
	function unitstatus($unit_id=0){
		$rec = $this->Common_Model->FetchData("units","*","unit_id=".$unit_id."");
		
		if ($rec[0]['unit_active']  == 'Inactive') {
			$this->Common_Model->db_query("UPDATE units SET unit_active ='Active' WHERE unit_id=".$unit_id."");
		}else if ($rec[0]['unit_active']  == 'Active') {
			$this->Common_Model->db_query("UPDATE units SET unit_active ='Inactive',terminated_on='".date('Y-m-d H:i:s')."' WHERE unit_id=".$unit_id."");
		}
		
		
		redirect($_SERVER['HTTP_REFERER']);
	}
  
  function forceDownloadQR($url, $width = 150, $height = 150) {
      $this->load->library('ciqrcode');
     $cencr = $this->Common_Model->encrypt($url,'TFMS2015');
    $untid = $url;
    $url    = urlencode($cencr);
    $params['data'] = $url;
	$params['level'] = 'H';
	$params['size'] = 10;
	$params['savename'] = FCPATH.'tes.png';
	$this->ciqrcode->generate($params);
	$qrimgPath = FCPATH.'tes.png';
	$this->load->helper('download');
	$data = file_get_contents($qrimgPath);
	$filename = 'qrcode_'.$untid.'.png';
	force_download($filename, $data);
    /*$image  = 'http://chart.apis.google.com/chart?chs='.$width.'x'.$height.'&cht=qr&chl='.$url;
    $file = file_get_contents($image);
    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=qrcode-'".$untid."'.png");
    header("Cache-Control: public");
    header("Content-length: " . strlen($file)); // tells file size
    header("Pragma: no-cache");
    echo $file;*/
    die;
	}
	
  function ptm(){
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));

			if($this->input->post('submitBtn')){
				$this->form_validation->set_rules('state_id', 'State', 'trim|required');
				$this->form_validation->set_error_delimiters('<p class="has-error"><label class="control-label">', '</label></p>');
				if($this->form_validation->run()){
					$rec_chk = $this->Common_Model->FetchData("ptm","*","state_id=".$this->input->post('state_id'));
					if ($rec_chk) {
						$this->Common_Model->DelData("ptm","state_id=".$this->input->post('state_id'));
					}
					foreach ($this->input->post('ratefrom[]') as $key => $value) {
					$data_list = array(
						'state_id'			=> $this->input->post('state_id'),
						'ratefrom'			=> $this->input->post('ratefrom['.$key.']'),
						'rateto'			=> ($this->input->post('ratetype['.$key.']')==1?$this->input->post('rateto['.$key.']'):'10000000'),
						'proftax'			=> $this->input->post('proftax['.$key.']'),
						'ratetype'			=> $this->input->post('ratetype['.$key.']'),
					);
					$id = $this->Common_Model->dbinsertid("ptm", $data_list);
				}
					$this->session->set_flashdata('success', 'Data Added successfully.' );
					redirect('masters/ptm');
				}else{
					$this->session->set_flashdata('error', validation_errors());
				}
			}


		$data['state'] = $this->Common_Model->FetchData("state","*","1 ORDER BY state_title ASC");
		$data['gst'] = $this->Common_Model->FetchData("company_gst","*","1 ORDER BY gst_id ASC");
		$data['activemenu'] = 'masters';
		$data['activesubmenu'] = 'ptm';
		$this->load->view('masters/ptm', $data);
	}

	function get_stateslab(){
		$state_id = $this->input->post("state_id");
		$rec = $this->Common_Model->FetchData("ptm","*","state_id=".$state_id." ORDER BY ptm_id ASC");
		$html = '';
		if ($rec) { for ($i=0; $i < count($rec); $i++) { 
			
		$html .= '<tr>
                    <td width="8%">'.($i+1).'</td>
                    <td width="15%"><input type="number" step="0.01" class="form-control" name="ratefrom[]" value="'.$rec[$i]['ratefrom'].'"></td>
                    <td width="25%">
                      <select name="ratetype[]" class="form-control ratetype">
                        <option value="1" '.($rec[$i]['ratetype']==1?"selected":"").'>To</option>
                        <option value="2" '.($rec[$i]['ratetype']==2?"selected":"").'>and Above</option>
                      </select>
                    </td>
                    <td width="15%"><input type="number" step="0.01" class="form-control rateto" name="rateto[]" value="'.($rec[$i]['ratetype']==1?$rec[$i]['rateto']:'').'" '.($rec[$i]['ratetype']==1?'':'readonly').'></td>
                    <td width="20%"><input type="number" step="0.01" class="form-control" name="proftax[]" value="'.$rec[$i]['proftax'].'"></td>
                    <td width="17%">
                      <a href="javascript:;" class="btnRemoveItm btn btn-xs btn-danger">
                      <i class="fa fa-trash"></i>
                      </a>
                    </td>
                  </tr>';

              }}else{
              	$html .= '<tr>
                    <td width="8%">1</td>
                    <td width="15%"><input type="number" step="0.01" class="form-control" name="ratefrom[]" value="0"></td>
                    <td width="25%">
                      <select name="ratetype[]" class="form-control ratetype">
                        <option value="1">To</option>
                        <option value="2">and Above</option>
                      </select>
                    </td>
                    <td width="15%"><input type="number" step="0.01" class="form-control rateto" name="rateto[]" value="0"></td>
                    <td width="20%"><input type="number" step="0.01" class="form-control" name="proftax[]" value="0"></td>
                    <td width="17%">
                      <a href="javascript:;" class="btnRemoveItm btn btn-xs btn-danger">
                      <i class="fa fa-trash"></i>
                      </a>
                    </td>
                  </tr>';
              }

		echo $html;exit;
	}

	function print_ptslabrate(){
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$data['rec'] = $this->Common_Model->FetchData("ptm", "*", "1 GROUP BY state_id ORDER BY ptm_id ASC");
		//print_r($data['rec']);exit;
		error_reporting(0);
		ini_set('display_error', -1);
		$html = $this->load->view('masters/print_ptslabrate', $data, TRUE);
		$this->load->library('pdf');
		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('Techno');
		$pdf->SetTitle('Slab Rate');
		$pdf->SetSubject('Slab Rate');
		
		$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
		$pdf->setHeaderData($ln='technofulllogo.png', $lw=70, $ht='', $hs='', $tc=array(0,0,0), $lc=array(0,0,0));
		$pdf->setFooterData(array(0, 0, 0), array(0,64,328));
		$pdf->SetMargins(10, 22, 10, true);
		$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
		$pdf->SetAutoPageBreak(TRUE, 17);
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

		$pdf->AddPage('P', 'A4', true, true);
		$pdf->SetMargins(10, 22, 10, true);
		$pdf->SetFont('helvetica', '', 8);
		$pdf->setFontSubsetting(false);
		$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
		date_default_timezone_set("Asia/Kolkata");
		$filename = 'Professional Tax Rate-'.date("YmdHis").'.pdf';
		$pdf->Output($filename, 'I');
	}
  
  public function get_distByState(){
  	$state_id = $this->input->post("state_id");
  	$records = $this->Common_Model->FetchData("district","*","state_id=".$state_id);
  	$html = '<option value="">District</option>';
  	if ($records) { for ($i=0; $i < count($records); $i++) { 
  			$html .='<option value="'.$records[$i]['district_id'].'">'.$records[$i]['district_title'].'</option>';
  		}}

  		echo $html;exit;
  }
  
  function unit(){
  	$data = array();
	$data['accessar'] = json_decode($this->session->userdata('access_menus'));

		$data['per_page'] = $per_page = isset($_REQUEST['per_page']) ? $_REQUEST['per_page'] : 10;
		$data['page'] = $page = isset($_REQUEST['page']) ? $_REQUEST['page'] : '1';
		$this->load->helper('url');
		$currentURL = current_url();
		$sql = "1";
		$urlvars = '';
		

		$sSql = "SELECT COUNT(*) as num FROM unit  WHERE $sql";
		$records = $this->Common_Model->db_query($sSql);
		$totalrecords = $records[0]['num'];
		if($totalrecords){
			$sSql = "SELECT * FROM unit WHERE $sql ORDER BY id DESC";
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


	$data['activemenu'] = 'masters';
	$data['activesubmenu'] = 'unit';
	$this->load->view('masters/unit', $data);
  }

  function add_unit(){
  	$data = array();
	$data['accessar'] = json_decode($this->session->userdata('access_menus'));

	if($this->input->post('submitBtn')){
		$this->form_validation->set_rules('name', 'Unit Name', 'trim|required|is_unique[unit.name]');
		$this->form_validation->set_rules('print', 'Print Name', 'trim|required');
		$this->form_validation->set_error_delimiters('<p class="has-error"><label class="control-label">', '</label></p>');
		if($this->form_validation->run()){
			$data_list = array(
				'name'			=> $this->input->post('name'),
				'alias'			=> $this->input->post('alias'),
				'print'			=> $this->input->post('print'),
			);
			$id = $this->Common_Model->dbinsertid("unit", $data_list);
			$this->session->set_flashdata('success', 'Unit Added successfully.' );
			redirect('masters/add_unit');
		}else{
			$this->session->set_flashdata('error', validation_errors());
		}
	}

	$data['activemenu'] = 'masters';
	$data['activesubmenu'] = 'unit';
	$this->load->view('masters/add_unit', $data);
  }

  function edit_unit($id){
  	$data = array();
	$data['accessar'] = json_decode($this->session->userdata('access_menus'));

	if($this->input->post('submitBtn') && $id > 0){
		$this->form_validation->set_rules('name', 'Unit Name', 'trim|required');
		$this->form_validation->set_rules('print', 'Print Name', 'trim|required');
		$this->form_validation->set_error_delimiters('<p class="has-error"><label class="control-label">', '</label></p>');
		if($this->form_validation->run()){
			$data_list = array(
				'name'			=> $this->input->post('name'),
				'alias'			=> $this->input->post('alias'),
				'print'			=> $this->input->post('print'),
			);
			$this->Common_Model->update_records("unit","id", $id, $data_list);
			$this->session->set_flashdata('success', 'Unit Updated successfully.' );
			redirect('masters/unit');
		}else{
			$this->session->set_flashdata('error', validation_errors());
		}
	}
	$data['rec'] = $this->Common_Model->FetchData("unit","*","id=".$id);
	$data['activemenu'] = 'masters';
	$data['activesubmenu'] = 'unit';
	$this->load->view('masters/edit_unit', $data);
  }

  function delete_unit($id){
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		if ($id > 0) {
			$this->Common_Model->DelData("unit", "id = ".$id);
			$this->session->set_flashdata('success', 'Record deleted successfully.' );
		}else{
			$this->session->set_flashdata('error', 'Record not found!!' );
		}
		
		redirect($_SERVER['HTTP_REFERER']);
	}

	function unitconversion(){
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));

			$data['per_page'] = $per_page = isset($_REQUEST['per_page']) ? $_REQUEST['per_page'] : 10;
			$data['page'] = $page = isset($_REQUEST['page']) ? $_REQUEST['page'] : '1';
			$this->load->helper('url');
			$currentURL = current_url();
			$sql = "1";
			$urlvars = '';
			

			$sSql = "SELECT COUNT(*) as num FROM unit_con  WHERE $sql";
			$records = $this->Common_Model->db_query($sSql);
			$totalrecords = $records[0]['num'];
			if($totalrecords){
				$sSql = "SELECT * FROM unit_con WHERE $sql ORDER BY id DESC";
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


		$data['activemenu'] = 'masters';
		$data['activesubmenu'] = 'unitconversion';
		$this->load->view('masters/unitconversion', $data);
	}

	function add_unitconversion(){
  	$data = array();
	$data['accessar'] = json_decode($this->session->userdata('access_menus'));

		if($this->input->post('submitBtn')){
			$this->form_validation->set_rules('main', 'Main Unit', 'trim|required');
			$this->form_validation->set_rules('sub', 'Sub Unit', 'trim|required');
			$this->form_validation->set_error_delimiters('<p class="has-error"><label class="control-label">', '</label></p>');
			if($this->form_validation->run()){
				$data_list = array(
					'main'			=> $this->input->post('main'),
					'sub'			=> $this->input->post('sub'),
					'factor'		=> $this->input->post('factor'),
					'typee'		=> $this->input->post('main').' / '.$this->input->post('sub'),
					'tipe'		=> $this->input->post('sub').' / '.$this->input->post('main'),
				);
				$id = $this->Common_Model->dbinsertid("unit_con", $data_list);
				$this->session->set_flashdata('success', 'Unit Conversion Added successfully.' );
				redirect('masters/add_unitconversion');
			}else{
				$this->session->set_flashdata('error', validation_errors());
			}
		}
	$data['unit'] = $this->Common_Model->FetchData("unit","*","1 ORDER BY name ASC");	
	$data['activemenu'] = 'masters';
	$data['activesubmenu'] = 'unitconversion';
	$this->load->view('masters/add_unitconversion', $data);
  }
  function edit_unitconversion($id){
  	$data = array();
	$data['accessar'] = json_decode($this->session->userdata('access_menus'));

		if($this->input->post('submitBtn') && $id > 0){
			$this->form_validation->set_rules('main', 'Main Unit', 'trim|required');
			$this->form_validation->set_rules('sub', 'Sub Unit', 'trim|required');
			$this->form_validation->set_error_delimiters('<p class="has-error"><label class="control-label">', '</label></p>');
			if($this->form_validation->run()){
				$data_list = array(
					'main'			=> $this->input->post('main'),
					'sub'			=> $this->input->post('sub'),
					'factor'		=> $this->input->post('factor'),
					'typee'		=> $this->input->post('main').' / '.$this->input->post('sub'),
					'tipe'		=> $this->input->post('sub').' / '.$this->input->post('main'),
				);
				$id = $this->Common_Model->update_records("unit_con","id", $id, $data_list);
				$this->session->set_flashdata('success', 'Unit Conversion Updated successfully.' );
				redirect('masters/unitconversion');
			}else{
				$this->session->set_flashdata('error', validation_errors());
			}
		}
	$data['unit'] = $this->Common_Model->FetchData("unit","*","1 ORDER BY name ASC");	
	$data['rec'] = $this->Common_Model->FetchData("unit_con","*","id=".$id);	
	$data['activemenu'] = 'masters';
	$data['activesubmenu'] = 'unitconversion';
	$this->load->view('masters/edit_unitconversion', $data);
  }

  function delete_unitconversion($id){
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		if ($id > 0) {
			$this->Common_Model->DelData("unit_con", "id = ".$id);
			$this->session->set_flashdata('success', 'Record deleted successfully.' );
		}else{
			$this->session->set_flashdata('error', 'Record not found!!' );
		}
		
		redirect($_SERVER['HTTP_REFERER']);
	}

	function item(){
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
			$data['per_page'] = $per_page = isset($_REQUEST['per_page']) ? $_REQUEST['per_page'] : 100;
			$data['page'] = $page = isset($_REQUEST['page']) ? $_REQUEST['page'] : '1';
			$this->load->helper('url');
			$currentURL = current_url();
			$sql = "1";
			$urlvars = '';

			if(isset($_REQUEST['itemsearch']) && $_REQUEST['itemsearch'] != ''){
				$sql.= " AND name LIKE '%".$_REQUEST['itemsearch']."%' OR code LIKE '%".$_REQUEST['itemsearch']."%' OR print LIKE '%".$_REQUEST['itemsearch']."%'";
				$urlvars.= "&name LIKE '%".$_REQUEST['itemsearch']."%' OR code LIKE '%".$_REQUEST['itemsearch']."%' OR print LIKE '%".$_REQUEST['itemsearch']."%'";
			}
			

			$sSql = "SELECT COUNT(*) as num FROM item  WHERE $sql";
			$records = $this->Common_Model->db_query($sSql);
			$totalrecords = $records[0]['num'];
			if($totalrecords){
				$sSql = "SELECT * FROM item WHERE $sql ORDER BY id DESC";
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
		$data['activemenu'] = 'masters';
		$data['activesubmenu'] = 'item';
		$this->load->view('masters/item', $data);
	}

	function add_item(){
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));

			if($this->input->post('submitBtn')){
				$this->form_validation->set_rules('name', 'Name', 'trim|required');
				$this->form_validation->set_rules('group', 'Group', 'trim|required');
				$this->form_validation->set_error_delimiters('<p class="has-error"><label class="control-label">', '</label></p>');
				if($this->form_validation->run()){

					$item = $this->Common_Model->FetchData("item","*","1 ORDER BY id DESC LIMIT 1");
					if ($item) {

						$tempId = explode('G',$item[0]['code']);
						$rc = (end($tempId) +  1) ;
						$newtpId = str_pad($rc, 6, '0', STR_PAD_LEFT);
						$itemcode = 'G'.str_pad($newtpId, 6, '0', STR_PAD_LEFT);
					}else {
						$itemcode = 'G'.str_pad('1', 6, '0', STR_PAD_LEFT);
					}

					$data_list = array(
						'date'			=> date('Y-m-d'),
						'month'			=> date('M'),
						'year'			=> date('Y'),
						'code'			=> $itemcode,
						'name'			=> $this->input->post('name'),
						'print'			=> $this->input->post('print'),
						'group'			=> $this->input->post('group'),
						'rate'			=> $this->input->post('rate'),
						'hsn'			=> $this->input->post('hsn'),
						'serial'		=> $this->input->post('serial'),
						'sl_no'			=> $this->input->post('sl_no'),
						'des'			=> $this->input->post('des'),
						'des1'			=> $this->input->post('des1'),
						'des2'			=> $this->input->post('des2'),
						'des3'			=> $this->input->post('des3'),
						'unit'			=> $this->input->post('unit'),
						'stock'			=> $this->input->post('stock'),
						'alt_unit'		=> $this->input->post('alt_unit'),
						'alt_fact'		=> $this->input->post('alt_fact'),
						'alt_type'		=> $this->input->post('alt_type'),
						'alt_stock'		=> $this->input->post('alt_stock'),
						'pack'			=> $this->input->post('pack'),
						'packalt_type'	=> $this->input->post('packalt_type'),
						'pack_con'		=> $this->input->post('pack_con'),
						'main_price'	=> $this->input->post('main_price'),
						'main_sale'		=> $this->input->post('main_sale'),
						'main_mrp'		=> $this->input->post('main_mrp'),
						'alt_price'		=> $this->input->post('alt_price'),
						'alt_sale'		=> $this->input->post('alt_sale'),
						'alt_mrp'		=> $this->input->post('alt_mrp'),
						'pack_price'	=> $this->input->post('pack_price'),
						'pack_sale'		=> $this->input->post('pack_sale'),
						'pack_mrp'		=> $this->input->post('pack_mrp'),
						
					);

					if($_FILES['image']['name']!=""){
					$newfile = 'ITEM_'.uniqid();
					$config = array(
						'upload_path' => "uploads/item/",
						'allowed_types' => 'jpg|png|jpeg',
						'overwrite' => TRUE,
						'file_name' => $newfile,
						'max_size' => "200048000" 
					);

					$this->load->library('upload', $config);
					$this->upload->initialize($config);
					if($this->upload->do_upload("image"))
					{
						$dat = $this->upload->data();
						$data_list['photo'] = $dat['file_name'];
					}else{
						$filename = '';
						$this->session->set_flashdata('error', $this->upload->display_errors());
						print_r($this->upload->display_errors());exit;
						redirect($_SERVER['HTTP_REFERER']);
					}
				}else{ $data_list['photo'] = '';}

					$id = $this->Common_Model->dbinsertid("item", $data_list);
					$this->session->set_flashdata('success', 'Item Added successfully.' );
					redirect('masters/add_item');
				}else{
					$this->session->set_flashdata('error', validation_errors());
				}
			}

		$data['unit'] = $this->Common_Model->FetchData("unit","*","1 ORDER BY name ASC");
		$data['activemenu'] = 'masters';
		$data['activesubmenu'] = 'item';
		$this->load->view('masters/add_item', $data);
	}

	function edit_item($id){
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));

			if($this->input->post('submitBtn') && $id > 0){
				$this->form_validation->set_rules('name', 'Name', 'trim|required');
				$this->form_validation->set_rules('group', 'Group', 'trim|required');
				$this->form_validation->set_error_delimiters('<p class="has-error"><label class="control-label">', '</label></p>');
				if($this->form_validation->run()){


					$data_list = array(
						'name'			=> $this->input->post('name'),
						'print'			=> $this->input->post('print'),
						'group'			=> $this->input->post('group'),
						'rate'			=> $this->input->post('rate'),
						'hsn'			=> $this->input->post('hsn'),
						'serial'		=> $this->input->post('serial'),
						'sl_no'			=> $this->input->post('sl_no'),
						'des'			=> $this->input->post('des'),
						'des1'			=> $this->input->post('des1'),
						'des2'			=> $this->input->post('des2'),
						'des3'			=> $this->input->post('des3'),
						'unit'			=> $this->input->post('unit'),
						'stock'			=> $this->input->post('stock'),
						'alt_unit'		=> $this->input->post('alt_unit'),
						'alt_fact'		=> $this->input->post('alt_fact'),
						'alt_type'		=> $this->input->post('alt_type'),
						'alt_stock'		=> $this->input->post('alt_stock'),
						'pack'			=> $this->input->post('pack'),
						'packalt_type'	=> $this->input->post('packalt_type'),
						'pack_con'		=> $this->input->post('pack_con'),
						'main_price'	=> $this->input->post('main_price'),
						'main_sale'		=> $this->input->post('main_sale'),
						'main_mrp'		=> $this->input->post('main_mrp'),
						'alt_price'		=> $this->input->post('alt_price'),
						'alt_sale'		=> $this->input->post('alt_sale'),
						'alt_mrp'		=> $this->input->post('alt_mrp'),
						'pack_price'	=> $this->input->post('pack_price'),
						'pack_sale'		=> $this->input->post('pack_sale'),
						'pack_mrp'		=> $this->input->post('pack_mrp'),
						
					);
					if($_FILES['image']['name']!=""){
					$newfile = 'ITEM_'.uniqid();
					$config = array(
						'upload_path' => "uploads/item/",
						'allowed_types' => 'jpg|png|jpeg',
						'overwrite' => TRUE,
						'file_name' => $newfile,
						'max_size' => "200048000" 
					);

					$this->load->library('upload', $config);
					$this->upload->initialize($config);
					if($this->upload->do_upload("image"))
					{
						$dat = $this->upload->data();
						$data_list['photo'] = $dat['file_name'];
					}else{
						$filename = '';
						$this->session->set_flashdata('error', $this->upload->display_errors());
						print_r($this->upload->display_errors());exit;
						redirect($_SERVER['HTTP_REFERER']);
					}
				}else{ }
					$id = $this->Common_Model->update_records("item","id", $id, $data_list);
					$this->session->set_flashdata('success', 'Item Updated successfully.' );
					redirect('masters/item');
				}else{
					$this->session->set_flashdata('error', validation_errors());
				}
			}

		$data['unit'] = $this->Common_Model->FetchData("unit","*","1 ORDER BY name ASC");
		$data['rec'] = $this->Common_Model->FetchData("item","*","id=".$id);
		$data['activemenu'] = 'masters';
		$data['activesubmenu'] = 'item';
		$this->load->view('masters/edit_item', $data);
	}

	function delete_item($id){
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		if ($id > 0) {
			$this->Common_Model->DelData("item", "id = ".$id);
			$this->session->set_flashdata('success', 'Record deleted successfully.' );
		}else{
			$this->session->set_flashdata('error', 'Record not found!!' );
		}
		
		redirect($_SERVER['HTTP_REFERER']);
	}

	function view_item($id){
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));



		$data['rec'] = $this->Common_Model->FetchData("item","*","id=".$id);
		$data['activemenu'] = 'masters';
		$data['activesubmenu'] = 'item';
		$this->load->view('masters/view_item', $data);	
	}
	
	function billofmaterial(){
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));

		$data['activemenu'] = 'masters';
		$data['activesubmenu'] = 'billofmaterial';
		$this->load->view('masters/billofmaterial', $data);
	}

	function add_billofmaterials(){
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));

		if($this->input->post('add1')){
				$alias=$_POST['alias'];
				$code=$_POST['code'];
				$qry="select * from  item where code='$code'";
				$query=$this->Common_Model->db_query($qry);
				$res=$query[0];
				$item=$res['name'];
				$group=$res['group'];
				$qty=$_POST['qty'];
				$unit1=$_POST['unit'];
				$unit=$res[''.$_POST['unit'].''];
				$des1=$_POST['des1'];
				// user or account
				$name5=$_POST['name'];
				
				$c_id1 = $this->session->userdata("user_id"); 
				$type=$this->session->userdata("usertype");
				
				$display_order=$_POST['display_order'];
				// close user or account
				$insert1=$this->Common_Model->db_query("INSERT INTO `bill_raw`(`alias`, `item`, `code`,`des`,`group`, `qty`, `unit`,`name`,`c_id`,`type`,`display_order`,`unit1`) VALUES ('$alias','$item','$code','$des1','$group','$qty','$unit','$name5','$c_id1','$type','$display_order','$unit1')");
				if($insert1){
					redirect($_SERVER['HTTP_REFERER']);
				}else {
				  	redirect($_SERVER['HTTP_REFERER']);
				 } 
		}

		if($this->input->post('add2')){
		  	$alias=$_POST['alias'];
			$code=$_POST['code'];
			$qry="select * from  item where code='$code'";
			$query=$this->Common_Model->db_query($qry);
			$res=$query[0];
			$item=$res['name'];
			$group=$res['group'];
			$qty=$_POST['qty'];
			$unit=$_POST['unit'];

			$insert2=$this->Common_Model->db_query("INSERT INTO `bill_prod`(`alias`, `item`, `code`, `group`, `qty`, `unit`) VALUES ('$alias','$item','$code','$group','$qty','$unit')");
			if($insert2){
				redirect($_SERVER['HTTP_REFERER']); 
			}else {
			  	redirect($_SERVER['HTTP_REFERER']);
			 } 
		}

		if($this->input->post('submit')){

			$date=$_POST['date'];
			$month=date('M',strtotime($date));
		    $year=date('Y',strtotime($date));

			$bom=$_POST['bom'];
			$alias=$_POST['alias'];
			$item=$_POST['item'];
			$qty=$_POST['qty'];
			$unit=$_POST['unit'];
			$exp_unit=$_POST['exp_unit'];
			$insert=$this->Common_Model->db_query("INSERT INTO `bill`(`date`, `month`, `year`, `bom`, `alias`, `item`, `qty`, `unit`, `exp_unit`) VALUES ('$date','$month','$year','$bom','$alias','$item','$qty','$unit','$exp_unit')");
			if($insert){
				$this->session->set_flashdata('success', 'Added successfully.' );
				redirect("masters/billofmaterial"); 
			}
			 else {
			  	redirect($_SERVER['HTTP_REFERER']);
			 } 
		}

		$data['activemenu'] = 'masters';
		$data['activesubmenu'] = 'billofmaterial';
		$this->load->view('masters/add_billofmaterials', $data);
	}

	function billmaterial_view(){
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));

		$data['activemenu'] = 'masters';
		$data['activesubmenu'] = 'billofmaterial';
		$this->load->view('masters/billmaterial_view', $data);
	}

	function billmaterial_edit(){
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));

		if($this->input->post('add1')){
			  	$alias=$_POST['alias'];
			  	$id2=$_POST['id2'];
				$code=$_POST['code'];
				$qry="select * from  item where code='$code'";
				$query=$this->Common_Model->db_query($qry);
				$res=$query[0];
				$item=$res['name'];
				$group=$res['group'];
				$qty=$_POST['qty'];
				$unit1=$_POST['unit'];
			    $unit=$res[''.$_POST['unit'].''];
				$des1=$_POST['des1'];
				// user or account
				$name5=$_POST['name'];
				
				$c_id1 = $this->session->userdata("user_id"); 
				$type=$this->session->userdata("usertype");
				
				$display_order=$_POST['display_order'];
				// close user or account
				$insert1=$this->Common_Model->db_query("INSERT INTO `bill_raw`(`alias`, `item`, `code`,`des`,`group`, `qty`, `unit`,`name`,`c_id`,`type`,`display_order`,`unit1`) VALUES ('$alias','$item','$code','$des1','$group','$qty','$unit','$name5','$c_id1','$type','$display_order','$unit1')");
				if($insert1){
				redirect("masters/billmaterial_edit?id=".$id2.""); 
				}
				 else {
				 redirect("masters/billmaterial_edit?id=".$id2.""); 
				 } 
		}

		if($this->input->post('update')){
			//print_r($_POST);exit;
			$id=$_POST['id'];
		  	$date=$_POST['date'];
		  /*$month=date('M',strtotime($date));
		    $year=date('Y',strtotime($date));*/

			$bom=$_POST['bom'];
			$alias=$_POST['alias'];
			$item=$_POST['item'];
			$qty=$_POST['qty'];
			$unit=$_POST['unit'];
			$exp_unit=$_POST['exp_unit'];
			$update=$this->Common_Model->db_query("UPDATE `bill` SET `bom`='$bom',`alias`='$alias',`item`='$item',`qty`='$qty',`unit`='$unit',`exp_unit`='$exp_unit',`date`='$date' WHERE id='$id' ");
			if($update){
				$this->session->set_flashdata('success', 'Updated successfully.' );
				redirect("masters/billofmaterial"); 
			}
			 else {
			  redirect("masters/billmaterial_edit?id=".$id.""); 
			 } 
		}

		$data['activemenu'] = 'masters';
		$data['activesubmenu'] = 'billofmaterial';
		$this->load->view('masters/billmaterial_edit', $data);
	}

	function billrawdelete(){
		$id4=$_GET['id1'];
		$id10=$_GET['id'];
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$this->Common_Model->DelData("bill_raw", "id = ".$id4);
		$this->session->set_flashdata('success', 'Record deleted successfully.' );
		redirect($_SERVER['HTTP_REFERER']);
	
	}

	function billrawedit(){
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));

		 if($this->input->post('update')){
 
			$id20=$_POST['id'];
			$id2=$_POST['id2'];
			$alias=$_POST['alias'];
			$code=$_POST['code'];
			$qry="select * from  item where code='$code'";
			$query=$this->Common_Model->db_query($qry);
			$res=$query[0];
			$item=$res['name'];
			$des=$_POST['des'];
			$group=$res['group'];
			$qty=$_POST['qty'];
			$unit1=$_POST['unit'];
			$unit=$res[''.$_POST['unit'].''];

			$update=$this->Common_Model->db_query("UPDATE `bill_raw` SET `alias`='$alias',`code`='$code',`des`='$des',`group`='$group',qty='$qty',`unit`='$unit',`unit1`='$unit1' WHERE id='$id20'");

			if($update){
				$this->session->set_flashdata('success', 'Updated successfully.' );
				redirect("masters/billmaterial_edit?id=".$id2.""); 
			}
			 else {
			 	redirect("masters/billrawedit?id10=".$id20."&id=".$id2."");
			  	
			 } 
		}


		$data['activemenu'] = 'masters';
		$data['activesubmenu'] = 'billofmaterial';
		$this->load->view('masters/billrawedit', $data);
	}

	function billmaterial_delete(){
		$alias=$_GET['alias'];
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$this->Common_Model->DelData("bill", "alias = '$alias'");
		$this->Common_Model->DelData("bill_raw", "alias = '$alias'");
		$this->session->set_flashdata('success', 'Record deleted successfully.' );
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	function itemgroup(){
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));

			$data['per_page'] = $per_page = isset($_REQUEST['per_page']) ? $_REQUEST['per_page'] : 10;
		$data['page'] = $page = isset($_REQUEST['page']) ? $_REQUEST['page'] : '1';
		$this->load->helper('url');
		$currentURL = current_url();
		$sql = "1";
		$urlvars = '';
		

		$sSql = "SELECT COUNT(*) as num FROM itemgroup  WHERE $sql";
		$records = $this->Common_Model->db_query($sSql);
		$totalrecords = $records[0]['num'];
		if($totalrecords){
			$sSql = "SELECT * FROM itemgroup WHERE $sql ORDER BY maingroup ASC";
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

		$data['activemenu'] = 'masters';
		$data['activesubmenu'] = 'itemgroup';
		$this->load->view('masters/itemgroup', $data);
	}

	function itemgroup_add(){
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));

		if($this->input->post('submitBtn')){
			$this->form_validation->set_rules('maingroup', 'Main Group', 'trim|required');
			$this->form_validation->set_rules('itemgroup_name', 'Item Group Name', 'trim|required|is_unique[itemgroup.itemgroup_name]');
			$this->form_validation->set_error_delimiters('<p class="has-error"><label class="control-label">', '</label></p>');
			if($this->form_validation->run()){
				$data_list = array(
					'maingroup'			=> $this->input->post('maingroup'),
					'itemgroup_name'	=> $this->input->post('itemgroup_name'),
					
				);
				$itemgroup_id = $this->Common_Model->dbinsertid("itemgroup", $data_list);
				$this->session->set_flashdata('success', 'Added successfully.' );
				redirect('masters/itemgroup_add');
			}else{
				$this->session->set_flashdata('error', validation_errors());
			}
		}
		
		$data['activemenu'] = 'masters';
		$data['activesubmenu'] = 'itemgroup';
		$this->load->view('masters/itemgroup_add', $data);
	}

	function itemgroup_edit($itemgroup_id=0){
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));

		if($this->input->post('submitBtn')){
			$this->form_validation->set_rules('maingroup', 'Main Group', 'trim|required');
			$this->form_validation->set_rules('itemgroup_name', 'Item Group Name', 'trim|required');
			$this->form_validation->set_error_delimiters('<p class="has-error"><label class="control-label">', '</label></p>');
			if($this->form_validation->run()){
				$data_list = array(
					'maingroup'			=> $this->input->post('maingroup'),
					'itemgroup_name'	=> $this->input->post('itemgroup_name'),
					
				);
				 $this->Common_Model->update_records("itemgroup","itemgroup_id", $itemgroup_id, $data_list);
				$this->session->set_flashdata('success', 'Updated successfully.' );
				redirect('masters/itemgroup');
			}else{
				$this->session->set_flashdata('error', validation_errors());
			}
		}

		$data['rec'] = $this->Common_Model->FetchData("itemgroup","*","itemgroup_id=".$itemgroup_id);
		$data['activemenu'] = 'masters';
		$data['activesubmenu'] = 'itemgroup';
		$this->load->view('masters/itemgroup_edit', $data);
	}

	function itemgroup_delete($itemgroup_id = 0){
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$this->Common_Model->DelData("itemgroup", "itemgroup_id = ".$itemgroup_id);
		$this->session->set_flashdata('success', 'Record deleted successfully.' );
		redirect($_SERVER['HTTP_REFERER']);
	}

	function itemsubgroup(){
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));

			$data['per_page'] = $per_page = isset($_REQUEST['per_page']) ? $_REQUEST['per_page'] : 10;
		$data['page'] = $page = isset($_REQUEST['page']) ? $_REQUEST['page'] : '1';
		$this->load->helper('url');
		$currentURL = current_url();
		$sql = "1";
		$urlvars = '';
		

		$sSql = "SELECT COUNT(*) as num FROM itemsubgroup as a   WHERE $sql";
		$records = $this->Common_Model->db_query($sSql);
		$totalrecords = $records[0]['num'];
		if($totalrecords){
			$sSql = "SELECT a.*,b.itemgroup_name FROM itemsubgroup as a LEFT JOIN itemgroup as b on a.itemgroup_id=b.itemgroup_id WHERE $sql ORDER BY a.maingroup ASC";
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

		$data['activemenu'] = 'masters';
		$data['activesubmenu'] = 'itemsubgroup';
		$this->load->view('masters/itemsubgroup', $data);
	}

	function itemsubgroup_add(){
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));

		if($this->input->post('submitBtn')){
			$this->form_validation->set_rules('maingroup', 'Main Group', 'trim|required');
			$this->form_validation->set_rules('itemgroup_id', 'Item Group', 'trim|required');
			$this->form_validation->set_rules('itemsubgroup_name', 'Item Sub Group Name', 'trim|required|is_unique[itemsubgroup.itemsubgroup_name]');
			$this->form_validation->set_error_delimiters('<p class="has-error"><label class="control-label">', '</label></p>');
			if($this->form_validation->run()){
				$data_list = array(
					'maingroup'			=> $this->input->post('maingroup'),
					'itemgroup_id'	=> $this->input->post('itemgroup_id'),
					'itemsubgroup_name'	=> $this->input->post('itemsubgroup_name'),
					
				);
				$itemsubgroup_id = $this->Common_Model->dbinsertid("itemsubgroup", $data_list);
				$this->session->set_flashdata('success', 'Added successfully.' );
				redirect('masters/itemsubgroup_add');
			}else{
				$this->session->set_flashdata('error', validation_errors());
			}
		}
		
		$data['activemenu'] = 'masters';
		$data['activesubmenu'] = 'itemsubgroup';
		$this->load->view('masters/itemsubgroup_add', $data);
	}

	function get_itemgroup(){
		$maingroup = $this->input->post("maingroup");
		$records = $this->Common_Model->FetchData("itemgroup","*","maingroup='".$maingroup."'");
		$html ='<option value="">--Select--</option>';
		if ($records) { for ($i=0; $i <count($records) ; $i++) { 
			$html .='<option value="'.$records[$i]['itemgroup_id'].'">'.$records[$i]['itemgroup_name'].'</option>';
		}}
		echo $html;exit;
	}

	function itemsubgroup_edit($itemsubgroup_id=0){
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));

		if($this->input->post('submitBtn')){
			$this->form_validation->set_rules('maingroup', 'Main Group', 'trim|required');
			$this->form_validation->set_rules('itemgroup_id', 'Item Group', 'trim|required');
			$this->form_validation->set_rules('itemsubgroup_name', 'Item Sub Group Name', 'trim|required');
			$this->form_validation->set_error_delimiters('<p class="has-error"><label class="control-label">', '</label></p>');
			if($this->form_validation->run()){
				$data_list = array(
					'maingroup'			=> $this->input->post('maingroup'),
					'itemgroup_id'		=> $this->input->post('itemgroup_id'),
					'itemsubgroup_name'	=> $this->input->post('itemsubgroup_name'),
					
				);
				$this->Common_Model->update_records("itemsubgroup", "itemsubgroup_id", $itemsubgroup_id, $data_list);
				$this->session->set_flashdata('success', 'Updated successfully.' );
				redirect('masters/itemsubgroup');
			}else{
				$this->session->set_flashdata('error', validation_errors());
			}
		}
		
		$data['rec'] = $this->Common_Model->FetchData("itemsubgroup","*","itemsubgroup_id=".$itemsubgroup_id);
		$data['activemenu'] = 'masters';
		$data['activesubmenu'] = 'itemsubgroup';
		$this->load->view('masters/itemsubgroup_edit', $data);
	}

	function itemsubgroup_delete($itemsubgroup_id=0){
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$this->Common_Model->DelData("itemsubgroup", "itemsubgroup_id = ".$itemsubgroup_id);
		$this->session->set_flashdata('success', 'Record deleted successfully.' );
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	function billraweditt($id=0){
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$data['id2'] = $id2=$_GET['id'];

		if ($this->input->post("update")) {
			$id=$_POST['id'];
			$alias=$_POST['alias'];
			$code=$_POST['code'];
			$qry="select * from  item where code='$code'";
			$query=$this->Common_Model->db_query($qry);
			$res=$query[0];
			$item=$res['name'];
			$group=$res['group'];
			$qty=$_POST['qty'];
			$unit1=$_POST['unit'];
			$unit=$res[''.$_POST['unit'].''];

			$update=$this->Common_Model->db_query("UPDATE `bill_raw` SET `alias`='$alias',`code`='$code',`group`='$group',qty='$qty',`unit`='$unit',`unit1`='$unit1' WHERE id='$id'");

			if($update){
 
				redirect("masters/add_billofmaterials"); 
			}else {
				redirect("masters/billraweditt?id=".$id."");
			}

		}

		
		$data['activemenu'] = 'masters';
		$data['activesubmenu'] = 'add_billofmaterials';
		$this->load->view('masters/billraweditt', $data);
	}

	function billrawdeletee(){
		$id4=$_GET['id'];
		
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$this->Common_Model->DelData("bill_raw", "id = ".$id4);
		$this->session->set_flashdata('success', 'Record deleted successfully.' );
		redirect($_SERVER['HTTP_REFERER']);
	
	}
	
	function documentheads(){
  	$data = array();
	$data['accessar'] = json_decode($this->session->userdata('access_menus'));

		$data['per_page'] = $per_page = isset($_REQUEST['per_page']) ? $_REQUEST['per_page'] : 10;
		$data['page'] = $page = isset($_REQUEST['page']) ? $_REQUEST['page'] : '1';
		$this->load->helper('url');
		$currentURL = current_url();
		$sql = "1";
		$urlvars = '';
		

		$sSql = "SELECT COUNT(*) as num FROM documentheads  WHERE $sql";
		$records = $this->Common_Model->db_query($sSql);
		$totalrecords = $records[0]['num'];
		if($totalrecords){
			$sSql = "SELECT * FROM documentheads WHERE $sql ORDER BY dochead_id DESC";
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


	$data['activemenu'] = 'masters';
	$data['activesubmenu'] = 'documentheads';
	$this->load->view('masters/documentheads', $data);
  }

  function add_documentheads(){
  	$data = array();
	$data['accessar'] = json_decode($this->session->userdata('access_menus'));

	if($this->input->post('submitBtn')){
		$this->form_validation->set_rules('dochead', 'Document Name', 'trim|required|is_unique[documentheads.dochead]');
		$this->form_validation->set_error_delimiters('<p class="has-error"><label class="control-label">', '</label></p>');
		if($this->form_validation->run()){
			$data_list = array(
				'dochead'			=> $this->input->post('dochead'),
				
			);

			if($_FILES['docfile']['name']!=""){
					$newfile = $this->input->post('dochead').'-'.uniqid();
					$config = array(
						'upload_path' => "uploads/docfiles/",
						'allowed_types' => 'jpg|png|jpeg|pdf|doc|docx|xls|xlsx',
						'overwrite' => TRUE,
						'file_name' => $newfile,
						'max_size' => 10 * (1024 * 1024) 
					);

					$this->load->library('upload', $config);
					$this->upload->initialize($config);
					if($this->upload->do_upload("docfile"))
					{
						$dat = $this->upload->data();
						$data_list['docfile'] = $dat['file_name'];
					}else{
						$filename = '';
						$this->session->set_flashdata('error', $this->upload->display_errors());
						redirect($_SERVER['HTTP_REFERER']);
					}
				}else{ $data_list['docfile'] = '';}

			$dochead_id = $this->Common_Model->dbinsertid("documentheads", $data_list);
			$this->session->set_flashdata('success', 'Data Added successfully.' );
			redirect('masters/add_documentheads');
		}else{
			$this->session->set_flashdata('error', validation_errors());
		}
	}

	$data['activemenu'] = 'masters';
	$data['activesubmenu'] = 'documentheads';
	$this->load->view('masters/add_documentheads', $data);
  }

  function edit_documenthead($dochead_id=0){
  	$data = array();
	$data['accessar'] = json_decode($this->session->userdata('access_menus'));

	if($this->input->post('submitBtn')){
		$this->form_validation->set_rules('dochead', 'Document Name', 'trim|required');
		$this->form_validation->set_error_delimiters('<p class="has-error"><label class="control-label">', '</label></p>');
		if($this->form_validation->run()){
			$data_list = array(
				'dochead'			=> $this->input->post('dochead'),
				
			);

			if($_FILES['docfile']['name']!=""){
					$newfile = $this->input->post('dochead').'-'.uniqid();
					$config = array(
						'upload_path' => "uploads/docfiles/",
						'allowed_types' => 'jpg|png|jpeg|pdf|doc|docx|xls|xlsx',
						'overwrite' => TRUE,
						'file_name' => $newfile,
						'max_size' => 10 * (1024 * 1024) 
					);

					$this->load->library('upload', $config);
					$this->upload->initialize($config);
					if($this->upload->do_upload("docfile"))
					{
						$dat = $this->upload->data();
						$data_list['docfile'] = $dat['file_name'];
					}else{
						$filename = '';
						$this->session->set_flashdata('error', $this->upload->display_errors());
						redirect($_SERVER['HTTP_REFERER']);
					}
				}else{ }

			$this->Common_Model->update_records("documentheads","dochead_id", $dochead_id, $data_list);
			$this->session->set_flashdata('success', 'Data Updated successfully.' );
			redirect('masters/documentheads');
		}else{
			$this->session->set_flashdata('error', validation_errors());
		}
	}
	$data['rec'] = $this->Common_Model->FetchData("documentheads","*","dochead_id=".$dochead_id);
	$data['activemenu'] = 'masters';
	$data['activesubmenu'] = 'documentheads';
	$this->load->view('masters/edit_documenthead', $data);
  }

  function delete_documenthead($id=0){
  	$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		if ($id > 0) {
			$this->Common_Model->DelData("documentheads", "dochead_id = ".$id);
			$this->session->set_flashdata('success', 'Record deleted successfully.' );
		}else{
			$this->session->set_flashdata('error', 'Record not found!!' );
		}
		
		redirect($_SERVER['HTTP_REFERER']);
  }

  function transporter(){
  	$data = array();
	$data['accessar'] = json_decode($this->session->userdata('access_menus'));

		$data['per_page'] = $per_page = isset($_REQUEST['per_page']) ? $_REQUEST['per_page'] : 10;
		$data['page'] = $page = isset($_REQUEST['page']) ? $_REQUEST['page'] : '1';
		$this->load->helper('url');
		$currentURL = current_url();
		$sql = "1";
		$urlvars = '';
		

		$sSql = "SELECT COUNT(*) as num FROM transporter  WHERE $sql";
		$records = $this->Common_Model->db_query($sSql);
		$totalrecords = $records[0]['num'];
		if($totalrecords){
			$sSql = "SELECT * FROM transporter WHERE $sql ORDER BY transporter_id DESC";
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


	$data['activemenu'] = 'masters';
	$data['activesubmenu'] = 'transporter';
	$this->load->view('masters/transporter', $data);
  }

  function add_transporter(){
  	$data = array();
	$data['accessar'] = json_decode($this->session->userdata('access_menus'));

	if($this->input->post('submitBtn')){
		$this->form_validation->set_rules('transporter_name', 'Transporter Name', 'trim|required');
		$this->form_validation->set_error_delimiters('<p class="has-error"><label class="control-label">', '</label></p>');
		if($this->form_validation->run()){
			$data_list = array(
				'transporter_name'	=> $this->input->post('transporter_name'),
				'contactno'			=> $this->input->post('contactno'),
				'transporter_no'	=> $this->input->post('transporter_no'),
				'transporter_address'=> $this->input->post('transporter_address'),
			);

			/*if($_FILES['transporter_doc']['name']!=""){
					$newfile = $this->input->post('transporter_doc').'-'.uniqid();
					$config = array(
						'upload_path' => "uploads/transporter_docfile/",
						'allowed_types' => 'jpg|png|jpeg|pdf|doc|docx|xls|xlsx',
						'overwrite' => TRUE,
						'file_name' => $newfile,
						'max_size' => 5 * (1024 * 1024) 
					);

					$this->load->library('upload', $config);
					$this->upload->initialize($config);
					if($this->upload->do_upload("transporter_doc"))
					{
						$dat = $this->upload->data();
						$data_list['transporter_doc'] = $dat['file_name'];
					}else{
						$filename = '';
						$this->session->set_flashdata('error', $this->upload->display_errors());
						redirect($_SERVER['HTTP_REFERER']);
					}
				}else{ $data_list['transporter_doc'] = '';}*/

			$dochead_id = $this->Common_Model->dbinsertid("transporter", $data_list);
			$this->session->set_flashdata('success', 'Data Added successfully.' );
			redirect('masters/add_transporter');
		}else{
			$this->session->set_flashdata('error', validation_errors());
		}
	}

	$data['activemenu'] = 'masters';
	$data['activesubmenu'] = 'transporter';
	$this->load->view('masters/add_transporter', $data);
  }

  function edit_transporter($transporter_id=0){
  	$data = array();
	$data['accessar'] = json_decode($this->session->userdata('access_menus'));

	if($this->input->post('submitBtn')){
		$this->form_validation->set_rules('transporter_name', 'Transporter Name', 'trim|required');
		$this->form_validation->set_error_delimiters('<p class="has-error"><label class="control-label">', '</label></p>');
		if($this->form_validation->run()){
			$data_list = array(
				'transporter_name'	=> $this->input->post('transporter_name'),
				'contactno'			=> $this->input->post('contactno'),
				'transporter_no'	=> $this->input->post('transporter_no'),
				'transporter_address'=> $this->input->post('transporter_address'),
			);

			/*if($_FILES['transporter_doc']['name']!=""){
					$newfile = $this->input->post('transporter_doc').'-'.uniqid();
					$config = array(
						'upload_path' => "uploads/transporter_docfile/",
						'allowed_types' => 'jpg|png|jpeg|pdf|doc|docx|xls|xlsx',
						'overwrite' => TRUE,
						'file_name' => $newfile,
						'max_size' => 5 * (1024 * 1024) 
					);

					$this->load->library('upload', $config);
					$this->upload->initialize($config);
					if($this->upload->do_upload("transporter_doc"))
					{
						$dat = $this->upload->data();
						$data_list['transporter_doc'] = $dat['file_name'];
					}else{
						$filename = '';
						$this->session->set_flashdata('error', $this->upload->display_errors());
						redirect($_SERVER['HTTP_REFERER']);
					}
				}else{ }*/

			$this->Common_Model->update_records("transporter","transporter_id", $transporter_id, $data_list);
			$this->session->set_flashdata('success', 'Data Updated successfully.' );
			redirect('masters/transporter');
		}else{
			$this->session->set_flashdata('error', validation_errors());
		}
	}
	$data['rec'] = $this->Common_Model->FetchData("transporter","*","transporter_id=".$transporter_id);
	$data['activemenu'] = 'masters';
	$data['activesubmenu'] = 'transporter';
	$this->load->view('masters/edit_transporter', $data);
  }

  function delete_transporter($transporter_id=0){
  	$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		if ($transporter_id > 0) {
			$this->Common_Model->DelData("transporter", "transporter_id = ".$transporter_id);
			$this->session->set_flashdata('success', 'Record deleted successfully.' );
		}else{
			$this->session->set_flashdata('error', 'Record not found!!' );
		}
		
		redirect($_SERVER['HTTP_REFERER']);
  }

  function get_itemunits(){
  	$code=$_POST['code1'];
	$records= $this->Common_Model->db_query("SELECT * FROM  item where code='$code'  ");
		
	echo json_encode($records[0]);exit;
  }

  function ctregdparty(){
  	$ledger_id=$_GET['ledger_id'];
  	$ledger_id1=0;
  	$query6 = "SELECT * FROM mail";
			$result6 = $this->Common_Model->db_query($query6);
			$row6 = $result6[0];
			$emaill=$row6['email'];
			$pass=$row6['pass'];
        
	        require 'vendor/PHPMailer/src/Exception.php';
	        require 'vendor/PHPMailer/src/PHPMailer.php';
	        require 'vendor/PHPMailer/src/SMTP.php';
  	$ledgerrec = $this->Common_Model->FetchData("ledgers","*","ledger_id=".$ledger_id);
  	//print_r($ledgerrec);exit;
  	if ($ledgerrec) {
  		$email = $ledgerrec[0]['email'];
  		if ($ledgerrec[0]['acount_group'] == '50' && $ledgerrec[0]['email']) {
  			$ledgergr = $this->Common_Model->FetchData("ledgers","*","acount_group=50 AND email='".$ledgerrec[0]['email']."' AND ledger_isunr=0");
  			if ($ledgergr) {
  				$this->session->set_flashdata('error', 'Already Registered!!' );
  				redirect($_SERVER['HTTP_REFERER']);
  			}

  			$ledger = $this->Common_Model->FetchData("ledgers","*","acount_group=50 AND ledger_isunr ='0' ORDER BY request_no DESC LIMIT 1");
	        $gcat = 'GSR';
	    
				if ($ledger) {

				$tempId = explode($gcat,$ledger[0]['request_no']);
				$rc = (end($tempId) +  1);
				$newtempId = str_pad($rc, 5, '0', STR_PAD_LEFT);
				$request_no = $gcat.str_pad($newtempId, 5, '0', STR_PAD_LEFT);
			}else {
				$request_no = $gcat.str_pad('1', 5, '0', STR_PAD_LEFT);
			}

				$data_list = array(
					'request_no'		=> $request_no,
					'bankorcashac'		=> 'No',
					'email'				=> $ledgerrec[0]['email'],
					'ledger_date'		=> date('Y-m-d'),
					'acount_group'		=> '50',
					'added_on' 	        => date('Y-m-d H:i:s'),
					'added_by' 			=> $this->session->userdata("user_id"),
					'unregledger_id' 	=> $ledger_id,
				);
				
				$ledger_id1 = $this->Common_Model->dbinsertid("ledgers",$data_list);

				$table = '<div style="padding:10px;">
					<img src = "https://glosent.in/erp/assets/logopng.png" height="40" style=""><br>
					Respected Sir/Madam,
					<br><br>
					This is to inform you, that new request has been registered by '.$this->session->userdata('firstname').' '.$this->session->userdata('lastname').' . (support@glosent.in) with request number '.$request_no.'.
					<br><br>
					Please go through below link, and upload all required documents.
					<br><br>
					https://portal.glosent.in/supplier
					<br><br>
					Should you need any further information, please do not hesitate to contact us.<br>
					Contact No: +91 9765497655<br>
					E-Mail : support@glosent.in
					<br><br>
					_______________________________ <br>
					Thanks & regards<br>
							Administrator.<br>
							Web – www.glosent.in <br>
				      GLOSENT <br>
							<br><br>
							<i style="color:#d2b4de;">Note: This is a system generated mail. Do not send reply mail.</i>
			</div>
                <div style="padding:10px;">
                    		'.$this->input->post("messages").'
                    </div>
                ';
  		}else if ($ledgerrec[0]['acount_group'] == '51' && $ledgerrec[0]['email']) {
  			$ledgergr = $this->Common_Model->FetchData("ledgers","*","acount_group=51 AND email='".$ledgerrec[0]['email']."' AND ledger_isunr=0");
  			if ($ledgergr) {
  				$this->session->set_flashdata('error', 'Already Registered!!' );
  				redirect($_SERVER['HTTP_REFERER']);
  			}

  			$ledger = $this->Common_Model->FetchData("ledgers","*","acount_group=51 AND ledger_isunr ='0' ORDER BY request_no DESC LIMIT 1");
			$gcat = 'GCR';
	       
			if ($ledger) {
		    
				$tempId = explode($gcat,$ledger[0]['request_no']);
				$rc = (end($tempId) +  1);
				$newtempId = str_pad($rc, 5, '0', STR_PAD_LEFT);
				$request_no = $gcat.str_pad($newtempId, 5, '0', STR_PAD_LEFT);
			}else {
				$request_no = $gcat.str_pad('1', 5, '0', STR_PAD_LEFT);
			}

				$data_list = array(
					'request_no'		=> $request_no,
					'bankorcashac'		=> 'No',
					'email'				=> $ledgerrec[0]['email'],
					'ledger_date'		=> date('Y-m-d'),
					'acount_group'		=> '51',
					'added_on' 	        => date('Y-m-d H:i:s'),
					'added_by' 			=> $this->session->userdata("user_id"),
					'unregledger_id' 	=> $ledger_id,
				);
				
				$ledger_id1 = $this->Common_Model->dbinsertid("ledgers",$data_list);

				$table = '	<div style="padding:10px;">
						<img src = "https://glosent.in/erp/assets/glosent_logo.png" height="40" width="40" style="margin-top:13px;"><br>
						Respected Sir/Madam,
						<br><br>
						This is to inform you, that new request has been registered by '.$this->session->userdata('firstname').' '.$this->session->userdata('lastname').' . (support@glosent.in) with request number '.$request_no.'.
						<br><br>
						Please go through below link, and upload all required documents.
						<br><br>
						https://portal.glosent.in/customer
						<br><br>
						Should you need any further information, please do not hesitate to contact us.<br>
						Contact No: +91 9765497655<br>
						E-Mail : support@glosent.in
						<br><br>
						_______________________________ <br>
						Thanks & regards<br>
								Administrator.<br>
								Web – www.glosent.in <br>
					      GLOSENT <br>
								<br><br>
								<i style="color:#d2b4de;">Note: This is a system generated mail. Do not send reply mail.</i>
				</div>
                		
                ';
  		}else{
  			$this->session->set_flashdata('error', 'Something went wrong!!' );
            redirect($_SERVER['HTTP_REFERER']);
  		}

  		if ($ledger_id1 > 0) {
  			$dataarr = array(
  				'email' => '',
  			);
  			$this->Common_Model->update_records("ledgers", "ledger_id", $ledger_id, $dataarr);
  			$mail = new PHPMailer(true);

      
            try {
                //Server settings
                $mail->isSMTP();
                $mail->Host       = 'smtp.gmail.com';
                $mail->SMTPAuth   = true;  
                $mail->Username   = $emaill;
                $mail->Password   = $pass; 
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port       = 587;  

                $mail->setFrom($emaill, 'Glosent');
                $recipients = [$email];
                foreach ($recipients as $recipient) {
                    $mail->addAddress($recipient);
                }
                $mail->addReplyTo($emaill, 'Glosent');

                $mail->isHTML(true);
                $mail->Subject = 'Customer Request';
                $mail->Body    = '<h4>'.$table.'</h4>';

                $mail->send();
               $arrResult = array('response' => 'success');
               

            } catch (Exception $e) {
                $arrResult = array('response' => "Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
            }

            $this->session->set_flashdata('success', 'Party registered successfully.' );
            redirect($_SERVER['HTTP_REFERER']);
  		}else{
  			$this->session->set_flashdata('error', 'Something went wrong!!' );
            redirect($_SERVER['HTTP_REFERER']);
  		}

  	}else{
  		$this->session->set_flashdata('error', 'Records not found!!' );
        redirect($_SERVER['HTTP_REFERER']);
  	}
  }

  public function exclusion($eid = 0){
		$data = array();
		$data['eid'] = $eid;
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		if($this->input->post('submitBtn')){
			$this->form_validation->set_rules('exclusion_name', 'Exclusion Name', 'trim|required');
			
			$this->form_validation->set_error_delimiters('<p class="has-error"><label class="control-label">', '</label></p>');
			if($this->form_validation->run()){
				$data_list = array(
					'exclusion_name'       => $this->input->post('exclusion_name'),
					'exclusion_active'	    => 'Active'
				);
			if($eid > 0){					
					$id = $this->Common_Model->update_records('exclusion', 'eid', $eid, $data_list);
					$this->session->set_flashdata('success', 'Exclusion Update successfully.' );
				redirect('masters/exclusion');
				}else{
				$id = $this->Common_Model->dbinsertid("exclusion", $data_list);
			}
				$this->session->set_flashdata('success', 'Exclusion Added successfully.' );
				redirect('masters/exclusion');
			}else{
				$this->session->set_flashdata('error', validation_errors());
			}
		}
		if($eid > 0){
			$data['btnVal']      = 'Update';
			$data['sectionData'] = $this->Common_Model->FetchData("exclusion", "*", "eid = ".$eid);
		}
		$data['activemenu'] = 'masters';
		$data['activesubmenu'] = 'exclusion';
		$data['rec'] = $this->Common_Model->FetchData("exclusion", "*", "eid=".$eid);
		$data['records'] = $this->Common_Model->FetchData("exclusion", "*", "1 ORDER BY exclusion_name ASC");
		$this->load->view('masters/exclusion', $data);
	}

	function deleteexclusion($exclusion_id = 0){
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$this->Common_Model->DelData("exclusion", "eid = ".$exclusion_id);
		$this->session->set_flashdata('success', 'Record deleted successfully.' );
		redirect($_SERVER['HTTP_REFERER']);
	}


// public function voucher() {
//     $data = array();
//     $data['accessar'] = json_decode($this->session->userdata('access_menus'));

//     if ($this->input->post('submitBtn')) {
//         $this->form_validation->set_rules('voucher_type', 'Voucher Type', 'required');
//         $this->form_validation->set_rules('level_number', 'Level Number', 'required|integer|greater_than[0]|less_than_equal_to[4]');

//         if ($this->form_validation->run()) {
//             $fieldValues = $this->input->post('field_values');
//            //print_r($fieldValues);exit;
           
//             if (!$fieldValues || !is_array($fieldValues)) {
//                 $this->session->set_flashdata('error', 'Field values are required and should be valid.');
//                 redirect('masters/voucher');
//             }

//             $fieldValuesString = json_encode($fieldValues); // Store as JSON to maintain structure
//             //$fieldValuesString = implode(',', $fieldValues);
//             //print_r($fieldValuesString);exit;
//             $voucherData = array(
//                 'voucher_type' => $this->input->post('voucher_type'),
//                 'level_number' => $this->input->post('level_number'),
//                 'field_values' => $fieldValuesString, // Store as JSON string
//             );
            
//             $id = $this->Common_Model->dbinsertid("voucher", $voucherData);
//             if ($id) {
//                 $this->session->set_flashdata('success', 'Voucher saved successfully!');
//             } else {
//                 $this->session->set_flashdata('error', 'Failed to save voucher.');
//             }

//             redirect('masters/voucher');
//         } else {
//             $data['error'] = validation_errors();
//         }
//     }

//     $data['records'] = $this->Common_Model->FetchData("voucher", "*", "1 ORDER BY voucher_type ASC");
//     $data['employees'] = $this->Common_Model->FetchData('employees', '*', "1 ORDER BY employee_name ASC");
//     $this->load->view('masters/voucher', $data);
// }


public function voucher() {
    $data = array();
    $data['accessar'] = json_decode($this->session->userdata('access_menus'));

    if ($this->input->post('submitBtn')) {
        $this->form_validation->set_rules('voucher_type', 'Voucher Type', 'required');
        $this->form_validation->set_rules('level_number', 'Level Number', 'required|integer|greater_than[0]|less_than_equal_to[4]');

        if ($this->form_validation->run()) {

            $fieldValuesString = json_encode($fieldValues); // Store as JSON to maintain structure
            $voucherData = array(
                'voucher_type' => $this->input->post('voucher_type'),
                'level_number' => $this->input->post('level_number'),
                //'field_values' => $fieldValuesString, // Store as JSON string
                'level_1' => json_encode($this->input->post('employee_ids1')),
                'level_2' => json_encode($this->input->post('employee_ids2')),
                'level_3' => json_encode($this->input->post('employee_ids3')),
                'level_4' => json_encode($this->input->post('employee_ids4')),
            );
            
            $id = $this->Common_Model->dbinsertid("voucher", $voucherData);
            if ($id) {
                $this->session->set_flashdata('success', 'Voucher saved successfully!');
            } else {
                $this->session->set_flashdata('error', 'Failed to save voucher.');
            }

            redirect('masters/voucher');
        } else {
            $data['error'] = validation_errors();
        }
    }

    $data['records'] = $this->Common_Model->FetchData("voucher", "*", "1 ORDER BY voucher_type ASC");
    $data['employees'] = $this->Common_Model->FetchData('employees', '*', "1 ORDER BY employee_name ASC");
    $this->load->view('masters/voucher', $data);
}


  public function  deletevoucher($voucher_id=0){
     $data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$this->Common_Model->DelData("voucher", "vid = ".$voucher_id);
		$this->session->set_flashdata('success', 'Record deleted successfully.' );
		redirect($_SERVER['HTTP_REFERER']);
  }

  // public function edit_vouchertype($vid=0){
  // 	//echo $vid;exit;
  // 	$data = array();
  // 	$data['accessar'] = json_decode($this->session->userdata('access_menus'));
// 		if($this->input->post('submitBtn')){

// 			$this->form_validation->set_rules('voucher_type', 'Voucher Type', 'required');
  //           $this->form_validation->set_rules('level_number', 'Level Number', 'required|integer|greater_than[0]|less_than_equal_to[4]');

// 			if($this->form_validation->run()){
// 				$fieldValues = $this->input->post('field_values');
  //          //print_r($fieldValues);exit;
           
  //           if (!$fieldValues || !is_array($fieldValues)) {
  //               $this->session->set_flashdata('error', 'Field values are required and should be valid.');
  //               redirect('masters/voucher');
  //           }

  //           $fieldValuesString = json_encode($fieldValues); // Store as JSON to maintain structure
  //           //$fieldValuesString = implode(',', $fieldValues);
  //           //print_r($fieldValuesString);exit;
  //           $voucherData = array(
  //               'voucher_type' => $this->input->post('voucher_type'),
  //               'level_number' => $this->input->post('level_number'),
  //               'field_values' => $fieldValuesString, // Store as JSON string
  //           );
// 				 //print_r($voucherData);
// 				$id = $this->Common_Model->update_records("voucher", "vid", $vid, $voucherData);
				
// 				$this->session->set_flashdata('success', 'Voucher Updated successfully.' );
// 				redirect('masters/voucher');
// 			}else{
// 				$this->session->set_flashdata('error', validation_errors());
// 			}
// 		}
// 		$data['activemenu'] = 'masters';
// 		$data['activesubmenu'] = 'edit_vouchertype';
// 		$data['rec'] = $this->Common_Model->FetchData("voucher", "*", "vid = $vid");
// 		$data['employees'] = $this->Common_Model->FetchData('employees', '*', "1 ORDER BY employee_name ASC");
  // 	$this->load->view('masters/edit_vouchertype',$data);
  // }

  public function edit_vouchertype($vid=0){
  	//echo $vid;exit;
  	$data = array();
  	$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		if($this->input->post('submitBtn')){

			$this->form_validation->set_rules('voucher_type', 'Voucher Type', 'required');
            $this->form_validation->set_rules('level_number', 'Level Number', 'required|integer|greater_than[0]|less_than_equal_to[4]');

			if($this->form_validation->run()){

            $voucherData = array(
                'voucher_type' => $this->input->post('voucher_type'),
                'level_number' => $this->input->post('level_number'),
                'level_1' => json_encode($this->input->post('employee_ids1')),
                'level_2' => json_encode($this->input->post('employee_ids2')),
                'level_3' => json_encode($this->input->post('employee_ids3')),
                'level_4' => json_encode($this->input->post('employee_ids4')),
            );
				
				$this->Common_Model->update_records("voucher", "vid", $vid, $voucherData);
				
				$this->session->set_flashdata('success', 'Voucher Updated successfully.' );
				redirect('masters/voucher');
			}else{
				$this->session->set_flashdata('error', validation_errors());
			}
		}
		$data['activemenu'] = 'masters';
		$data['activesubmenu'] = 'edit_vouchertype';
		$data['rec'] = $this->Common_Model->FetchData("voucher", "*", "vid = $vid");
		$data['employees'] = $this->Common_Model->FetchData('employees', '*', "1 ORDER BY employee_name ASC");
  	$this->load->view('masters/edit_vouchertype',$data);
  }
  
}
