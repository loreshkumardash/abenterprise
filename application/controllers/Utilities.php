<?php
error_reporting(0);
defined('BASEPATH') OR exit('No direct script access allowed');
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Utilities extends CI_Controller {

	public function __construct(){
		parent::__construct();
		is_logged_in();
		date_default_timezone_set("Asia/Kolkata"); 
		$this->present_date 		= date('Y-m-d');
		$this->present_time 		= date('H:i:a');
		$this->timestamp 		= date('Y-m-d H:i:s'); 
	}

	public function index()
	{

	}

	public function empdataexcelupload(){
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));

		if($this->input->post('submitBtn')){

			$this->form_validation->set_rules('session_id', 'Session', 'trim|required');
			
			
			$this->form_validation->set_error_delimiters('<p class="has-error"><label class="control-label">', '</label></p>');
			if($this->form_validation->run()){
				$this->Common_Model->db_query("UPDATE sessions SET active_session = ''");
				$data_list = array(
					'session_id'		=> $this->input->post('session_id'),
					'remarks'			=> addslashes($this->input->post('remarks')),
					'uploaded_on'		=> $this->input->post('uploaded_on'),
					
				);

				if($_FILES['attached_file']['name']!=""){
					$newfile = 'EMPDATAFILE-'.uniqid().'_'.date('Ymd');
					$config = array(
						'upload_path' => "uploads/empdatafile/",
						'allowed_types' => 'xls|xlsx',
						'overwrite' => TRUE,
						'file_name' => $newfile,
						'max_size' => "200048000" 
					);

					$this->load->library('upload', $config);
					$this->upload->initialize($config);
					if($this->upload->do_upload("attached_file"))
					{
						$dat = $this->upload->data();
						$data_list['attached_file'] = $dat['file_name'];
					}else{
						$filename = '';
						$this->session->set_flashdata('error', $this->upload->display_errors());
						redirect($_SERVER['HTTP_REFERER']);
					}
				}else{ $data_list['attached_file'] = '';}

				$id = $this->Common_Model->dbinsertid("employeeexceldata", $data_list);
				
				
				$this->session->set_flashdata('success', 'Data Added successfully.' );
				redirect('utilities/empdataexcelupload');
			}else{
				$this->session->set_flashdata('error', validation_errors());
			}
		}


		$data['session'] = $this->Common_Model->FetchData("sessions","*","1 order by session_id DESC");
		$data['activemenu'] = 'utilities';
		$data['activesubmenu'] = 'empdataexcelupload';
		$this->load->view('utilities/empdataexcelupload', $data);
	}

	public function unitattendanceupload(){
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));

		if($this->input->post('submitBtn')){

			$this->form_validation->set_rules('session_id', 'Session', 'trim|required');
			
			
			$this->form_validation->set_error_delimiters('<p class="has-error"><label class="control-label">', '</label></p>');
			if($this->form_validation->run()){
				$this->Common_Model->db_query("UPDATE sessions SET active_session = ''");
				$data_list = array(
					'session_id'		=> $this->input->post('session_id'),
					'remarks'			=> addslashes($this->input->post('remarks')),
					'uploaded_on'		=> $this->input->post('uploaded_on'),
					
				);

				if($_FILES['attached_file']['name']!=""){
					$newfile = 'UNITATTENDANCE-'.uniqid().'_'.date('Ymd');
					$config = array(
						'upload_path' => "uploads/unitatten/",
						'allowed_types' => 'xls|xlsx',
						'overwrite' => TRUE,
						'file_name' => $newfile,
						'max_size' => "200048000" 
					);

					$this->load->library('upload', $config);
					$this->upload->initialize($config);
					if($this->upload->do_upload("attached_file"))
					{
						$dat = $this->upload->data();
						$data_list['attached_file'] = $dat['file_name'];
					}else{
						$filename = '';
						$this->session->set_flashdata('error', $this->upload->display_errors());
						redirect($_SERVER['HTTP_REFERER']);
					}
				}else{ $data_list['attached_file'] = '';}

				$id = $this->Common_Model->dbinsertid("unitatten", $data_list);
				
				
				$this->session->set_flashdata('success', 'Data Added successfully.' );
				redirect('utilities/unitattendanceupload');
			}else{
				$this->session->set_flashdata('error', validation_errors());
			}
		}

		$data['session'] = $this->Common_Model->FetchData("sessions","*","1 order by session_id DESC");
		$data['activemenu'] = 'utilities';
		$data['activesubmenu'] = 'unitattendanceupload';
		$this->load->view('utilities/unitattendanceupload', $data);
	}

	public function downloadexcelformats(){
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));

		$data['empexldata'] = $this->Common_Model->FetchData("employeeexceldata as a LEFT JOIN sessions as b on a.session_id=b.session_id","*","1 order by id DESC");
		$data['activemenu'] = 'utilities';
		$data['activesubmenu'] = 'downloadexcelformats';
		$this->load->view('utilities/downloadexcelformats', $data);
	}

	public function downloadunitattendance(){
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));

		$data['unitatten'] = $this->Common_Model->FetchData("unitatten as a LEFT JOIN sessions as b on a.session_id=b.session_id","*","1 order by id DESC");
		$data['activemenu'] = 'utilities';
		$data['activesubmenu'] = 'downloadexcelformats';
		$this->load->view('utilities/downloadunitattendance', $data);
	}
}