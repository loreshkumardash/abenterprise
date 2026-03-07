<?php
error_reporting(0);
defined('BASEPATH') OR exit('No direct script access allowed');
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
class Document extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->perPage = 10;
		is_logged_in();
		date_default_timezone_set('Asia/Kolkata');
	}
	public function experience_letter()
	{ 
		$data = array();
		if($this->input->post('submitBtn')){
			$this->form_validation->set_rules('employee_id', 'employee_id', 'trim|required');
			$this->form_validation->set_error_delimiters('<p class="has-error"><label class="control-label">', '</label></p>');

			if($this->form_validation->run()){
				$data_list = array(
					'employee_id'			=> $this->input->post('employee_id'),
					'experience_date'		=> $this->input->post('experience_date'),
					'emp_name'				=> $this->input->post('emp_name'),
					'empsite_name'			=> $this->input->post('empsite_name'),
					);
				$this->Common_Model->dbinsertid("experience_letter", $data_list);
			}
			$this->session->set_flashdata('success', 'Register successfully.' );
				redirect('document/experience_letter');
			}else{
				$this->session->set_flashdata('error', validation_errors());
				
			}

        $data['experience'] = $this->Common_Model->FetchData("experience_letter","*","1 ORDER BY experience_letter_id ASC");
		$data['activemenu'] = 'document';
		$data['activesubmenu'] = 'experience_letter';
		$this->load->view('document/experience_letter',$data);
	}
	public function edit_experience($experience_letter_id =0)
	{
		$data = array();
		$data['experience_letter_id '] = $experience_letter_id ;
		if($this->input->post('submitBtn')){
			$this->form_validation->set_rules('employee_id', 'employee_id', 'trim|required');
			$this->form_validation->set_error_delimiters('<p class="has-error"><label class="control-label">', '</label></p>');

			if($this->form_validation->run()){
				$data_list = array(
					'employee_id'			=> $this->input->post('employee_id'),
					'experience_date'		=> $this->input->post('experience_date'),
					'emp_name'				=> $this->input->post('emp_name'),
					'empsite_name'			=> $this->input->post('empsite_name'),
					);
				$this->Common_Model->update_records("experience_letter","experience_letter_id ",$experience_letter_id ,$data_list);
			}
			$this->session->set_flashdata('success', 'Register successfully.' );
				redirect('document/experience_letter');
			}else{
				$this->session->set_flashdata('error', validation_errors());
				
			}

        $data['experience'] = $this->Common_Model->FetchData("experience_letter","*","experience_letter_id =".$experience_letter_id ."");
		$data['activemenu'] = 'document';
		$data['activesubmenu'] = 'experience_letter';
		$this->load->view('document/edit_experience',$data);
	}
	public function delete_experience($experience_letter_id =0)
	{
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$this->Common_Model->DelData("experience_letter", "experience_letter_id  = ".$experience_letter_id );
		redirect($_SERVER['HTTP_REFERER']);
		$this->load->view('document/delete_experience');
	}
	public function appointment_letter()
	{
		$data = array();
		if($this->input->post('submitBtn')){
			$this->form_validation->set_rules('name', 'name', 'trim|required');
			$this->form_validation->set_error_delimiters('<p class="has-error"><label class="control-label">', '</label></p>');

			if($this->form_validation->run()){
				$data_list = array(
					'name'	                => $this->input->post('name'),
					'so_name'		        => $this->input->post('so_name'),
					'at'			        => $this->input->post('at'),
					'post'	                => $this->input->post('post'),
					'dist'			        => $this->input->post('dist'),
					'state'			        => $this->input->post('state'),
					'pincode'			    => $this->input->post('pincode'),
					'position'			    => $this->input->post('position'),
					'based_at'			    => $this->input->post('based_at'),
					'reporting_to'			=> $this->input->post('reporting_to'),
					'joining_date'			=> $this->input->post('joining_date'),
					'total_amount'			=> $this->input->post('total_amount'),
					);
				$appointment_id = $this->Common_Model->dbinsertid("appointment", $data_list);
				if($appointment_id){

					foreach ($this->input->post('perticular[]') as $key => $value) {
					
				 	if($this->input->post("perticular[".$key."]") != ''){
						
				 	$this->Common_Model->dbinsertid("salary_wages", 
				 		array(
					      "appion_id"		        => $appointment_id,
				 	      "perticular" 		        => $this->input->post("perticular[".$key."]"),
				 	      "amount" 		            => $this->input->post("amount[".$key."]"),
					)
				 ); 					
			  }
			}
		}
			
			$this->session->set_flashdata('success', 'Register successfully.' );
				redirect('document/appointment_letter');
			}else{
				$this->session->set_flashdata('error', validation_errors());
				
			}
		}

          $data['appointment'] = $this->Common_Model->FetchData("appointment","*","1 ORDER BY appointment_id ASC");
		$data['activemenu'] = 'document';
		$data['activesubmenu'] = 'appointment_letter';
		$this->load->view('document/appointment_letter',$data);
	}
	public function edit_appiontment($appointment_id=0)
	{
		$data = array();
		$data['appointment_id'] = $appointment_id;
		if($this->input->post('submitBtn')){
			$this->form_validation->set_rules('name', 'name', 'trim|required');
			$this->form_validation->set_error_delimiters('<p class="has-error"><label class="control-label">', '</label></p>');

			if($this->form_validation->run()){
				$data_list = array(
					'name'	                => $this->input->post('name'),
					'so_name'		        => $this->input->post('so_name'),
					'at'			        => $this->input->post('at'),
					'post'	                => $this->input->post('post'),
					'dist'			        => $this->input->post('dist'),
					'state'			        => $this->input->post('state'),
					'pincode'			    => $this->input->post('pincode'),
					'position'			    => $this->input->post('position'),
					'based_at'			    => $this->input->post('based_at'),
					'reporting_to'			=> $this->input->post('reporting_to'),
					'joining_date'			=> $this->input->post('joining_date'),
					);
				 $this->Common_Model->update_records("appointment","appointment_id",$appointment_id, $data_list);

				 $this->Common_Model->DelData("salary_wages","appion_id=".$appointment_id."");
				

					foreach ($this->input->post('perticular[]') as $key => $value) {
					
				 	if($this->input->post("perticular[".$key."]") != ''){
						
				 	$this->Common_Model->dbinsertid("salary_wages", 
				 		array(
					      "appion_id"		        => $appointment_id,
				 	      "perticular" 		        => $this->input->post("perticular[".$key."]"),
				 	      "amount" 		            => $this->input->post("amount[".$key."]"),
					)
				 ); 					
			  }
			}
		
			
			$this->session->set_flashdata('success', 'Register successfully.' );
				redirect('document/appointment_letter');
			}else{
				$this->session->set_flashdata('error', validation_errors());
				
			}
		}

         $data['appointment'] = $this->Common_Model->FetchData("appointment","*","appointment_id=".$appointment_id."");
        $data['salary'] = $this->Common_Model->FetchData("salary_wages","*","appion_id=".$appointment_id."");
		$data['activemenu'] = 'document';
		$data['activesubmenu'] = 'appointment_letter';
		$this->load->view('document/edit_appiontment',$data);
	}
	public function delete_appiontment($appointment_id=0)
	{
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$this->Common_Model->DelData("appointment", "appointment_id = ".$appointment_id);
		$this->Common_Model->DelData("salary_wages","appion_id=".$appointment_id."");
		redirect($_SERVER['HTTP_REFERER']);
		$this->load->view('document/delete_appiontment');
	}
	public function termination()
	{
		$data = array();
		if($this->input->post('submitBtn')){
			$this->form_validation->set_rules('ter_employee_id', 'ter_employee_id', 'trim|required');
			$this->form_validation->set_error_delimiters('<p class="has-error"><label class="control-label">', '</label></p>');

			if($this->form_validation->run()){
				$data_list = array(
					'ter_employee_id'	     => $this->input->post('ter_employee_id'),
					'ter_date'			     => $this->input->post('ter_date'),
					'ter_emp_name'			 => $this->input->post('ter_emp_name'),
					'ter_reason'			 => $this->input->post('ter_reason'),
					);
				$this->Common_Model->dbinsertid("termination_letter", $data_list);
			}
			$this->session->set_flashdata('success', 'Register successfully.' );
				redirect('document/termination');
			}else{
				$this->session->set_flashdata('error', validation_errors());
				
			}

         $data['termination'] = $this->Common_Model->FetchData("termination_letter","*","1 ORDER BY termination_letter_id ASC");
		$data['activemenu'] = 'document';
		$data['activesubmenu'] = 'termination';
		$this->load->view('document/termination',$data);
	}
   public function edit_termination($termination_letter_id=0)
	{
		$data = array();
		$data['termination_letter_id'] = $termination_letter_id;
		if($this->input->post('submitBtn')){
			$this->form_validation->set_rules('ter_employee_id', 'ter_employee_id', 'trim|required');
			$this->form_validation->set_error_delimiters('<p class="has-error"><label class="control-label">', '</label></p>');

			if($this->form_validation->run()){
				$data_list = array(
					'ter_employee_id'	     => $this->input->post('ter_employee_id'),
					'ter_date'			     => $this->input->post('ter_date'),
					'ter_emp_name'			 => $this->input->post('ter_emp_name'),
					'ter_reason'			 => $this->input->post('ter_reason'),
					);
				$this->Common_Model->update_records("termination_letter","termination_letter_id",$termination_letter_id, $data_list);
			}
			$this->session->set_flashdata('success', 'Register successfully.' );
				redirect('document/termination');
			}else{
				$this->session->set_flashdata('error', validation_errors());
				
			}

         $data['termination'] = $this->Common_Model->FetchData("termination_letter","*","termination_letter_id=".$termination_letter_id."");
		$data['activemenu'] = 'document';
		$data['activesubmenu'] = 'termination';
		$this->load->view('document/edit_termination',$data);
	}
	public function delete_termination($termination_letter_id=0)
	{
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$this->Common_Model->DelData("termination_letter", "termination_letter_id = ".$termination_letter_id);
		redirect($_SERVER['HTTP_REFERER']);
		$this->load->view('document/delete_termination');
	}
	public function suspenssion_letter()
	{
		$data = array();
		if($this->input->post('submitBtn')){
			$this->form_validation->set_rules('susemp_id', 'susemp_id', 'trim|required');
			$this->form_validation->set_error_delimiters('<p class="has-error"><label class="control-label">', '</label></p>');

			if($this->form_validation->run()){
				$data_list = array(
					'susemp_id'	            => $this->input->post('susemp_id'),
					'suspension_date'		=> $this->input->post('suspension_date'),
					'susemp_name'			=> $this->input->post('susemp_name'),
					'suspension_reason'	    => $this->input->post('suspension_reason'),
					'rejoin_date'			=> $this->input->post('rejoin_date'),
					);
				$this->Common_Model->dbinsertid("suspension", $data_list);
			}
			$this->session->set_flashdata('success', 'Register successfully.' );
				redirect('document/suspenssion_letter');
			}else{
				$this->session->set_flashdata('error', validation_errors());
				
			}

         $data['suspension'] = $this->Common_Model->FetchData("suspension","*","1 ORDER BY suspension_id ASC");
		$data['activemenu'] = 'document';
		$data['activesubmenu'] = 'suspenssion_letter';
		$this->load->view('document/suspenssion_letter',$data);
	}
	public function edit_suspension($suspension_id=0)
	{
		$data = array();
		$data['suspension_id'] = $suspension_id;
		if($this->input->post('submitBtn')){
			$this->form_validation->set_rules('susemp_id', 'susemp_id', 'trim|required');
			$this->form_validation->set_error_delimiters('<p class="has-error"><label class="control-label">', '</label></p>');

			if($this->form_validation->run()){
				$data_list = array(
					'susemp_id'	            => $this->input->post('susemp_id'),
					'suspension_date'		=> $this->input->post('suspension_date'),
					'susemp_name'			=> $this->input->post('susemp_name'),
					'suspension_reason'	    => $this->input->post('suspension_reason'),
					'rejoin_date'			=> $this->input->post('rejoin_date'),
					);
				$this->Common_Model->update_records("suspension","suspension_id",$suspension_id, $data_list);
			}
			$this->session->set_flashdata('success', 'Register successfully.' );
				redirect('document/suspenssion_letter');
			}else{
				$this->session->set_flashdata('error', validation_errors());
				
			}

         $data['suspension'] = $this->Common_Model->FetchData("suspension","*","suspension_id=".$suspension_id."");
		$data['activemenu'] = 'document';
		$data['activesubmenu'] = 'suspenssion_letter';
		$this->load->view('document/edit_suspension',$data);
	}
	public function delete_suspension($suspension_id=0)
	{
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$this->Common_Model->DelData("suspension", "suspension_id = ".$suspension_id);
		redirect($_SERVER['HTTP_REFERER']);
		$this->load->view('document/delete_suspension');
	}
	public function relieving()
	{
		$data = array();
		if($this->input->post('submitBtn')){
			$this->form_validation->set_rules('relieving_name', 'relieving Name', 'trim|required');
			$this->form_validation->set_error_delimiters('<p class="has-error"><label class="control-label">', '</label></p>');

			if($this->form_validation->run()){
				$data_list = array(
					'relieving_name'		 => $this->input->post('relieving_name'),
					'relieving_so'		     => $this->input->post('relieving_so'),
			        'relieving_designation'	   => $this->input->post('relieving_designation'),
					'from_dt'				   => $this->input->post('from_dt'),
					'to_dt'				       => $this->input->post('to_dt'),
					);
				$this->Common_Model->dbinsertid("relieving", $data_list);
			}
			$this->session->set_flashdata('success', 'Register successfully.' );
				redirect('document/relieving');
			}else{
				$this->session->set_flashdata('error', validation_errors());
				
			}

        $data['relieving'] = $this->Common_Model->FetchData("relieving","*","1 ORDER BY relieving_id ASC");
		$data['activemenu'] = 'document';
		$data['activesubmenu'] = 'relieving';
		$this->load->view('document/relieving',$data);
	}
   public function editrelieving($relieving_id = 0)
	{
		$data = array();
		$data['relieving_id'] = $relieving_id;
		if($this->input->post('submitBtn')){
			$this->form_validation->set_rules('relieving_name', 'relieving Name', 'trim|required');
			$this->form_validation->set_error_delimiters('<p class="has-error"><label class="control-label">', '</label></p>');

			if($this->form_validation->run()){
				$data_list = array(
					'relieving_name'		 => $this->input->post('relieving_name'),
					'relieving_so'		     => $this->input->post('relieving_so'),
			        'relieving_designation'	   => $this->input->post('relieving_designation'),
					'from_dt'				   => $this->input->post('from_dt'),
					'to_dt'				       => $this->input->post('to_dt'),
					);
				$this->Common_Model->update_records("relieving","relieving_id",$relieving_id, $data_list);
			}
			$this->session->set_flashdata('success', 'Register successfully.' );
				redirect('document/relieving');
			}else{
				$this->session->set_flashdata('error', validation_errors());
				
			}

        $data['relieving'] = $this->Common_Model->FetchData("relieving","*","relieving_id=".$relieving_id."");
		$data['activemenu'] = 'document';
		$data['activesubmenu'] = 'relieving';
		$this->load->view('document/editrelieving',$data);
	}
   public function deleterelieving($relieving_id=0)
	{
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$this->Common_Model->DelData("relieving", "relieving_id = ".$relieving_id);
		redirect($_SERVER['HTTP_REFERER']);
		$this->load->view('document/deleterelieving');
	}
	public function authorization_letter()
	{
		$data = array();
		if($this->input->post('submitBtn')){
			$this->form_validation->set_rules('authorization_to', 'authorization_to', 'trim|required');
			$this->form_validation->set_error_delimiters('<p class="has-error"><label class="control-label">', '</label></p>');

			if($this->form_validation->run()){
				$data_list = array(
					'authorization_to'	    => $this->input->post('authorization_to'),
					'sitename'			    => $this->input->post('sitename'),
					'address'				=> $this->input->post('address'),
					'sub'					=> $this->input->post('sub'),
					'description'			=> $this->input->post('description'),
					'regards'				=> $this->input->post('regards'),
					'date'					=> $this->input->post('date'),
					);
				$this->Common_Model->dbinsertid("authorization", $data_list);
			}
			$this->session->set_flashdata('success', 'Register successfully.' );
				redirect('document/authorization_letter');
			}else{
				$this->session->set_flashdata('error', validation_errors());
				
			}

         $data['authorization'] = $this->Common_Model->FetchData("authorization","*","1 ORDER BY authorization_id ASC");
		$data['activemenu'] = 'document';
		$data['activesubmenu'] = 'authorization_letter';
		$this->load->view('document/authorization_letter',$data);
	}
	public function edit_authorization($authorization_id=0)
	{
		$data = array();
		$data['authorization_id'] = $authorization_id;
		if($this->input->post('submitBtn')){
			$this->form_validation->set_rules('authorization_to', 'authorization_to', 'trim|required');
			$this->form_validation->set_error_delimiters('<p class="has-error"><label class="control-label">', '</label></p>');

			if($this->form_validation->run()){
				$data_list = array(
					'authorization_to'	    => $this->input->post('authorization_to'),
					'sitename'			    => $this->input->post('sitename'),
					'address'				=> $this->input->post('address'),
					'sub'					=> $this->input->post('sub'),
					'description'			=> $this->input->post('description'),
					'regards'				=> $this->input->post('regards'),
					'date'					=> $this->input->post('date'),
					);
				$this->Common_Model->update_records("authorization","authorization_id",$authorization_id, $data_list);
			}
			$this->session->set_flashdata('success', 'Register successfully.' );
				redirect('document/authorization_letter');
			}else{
				$this->session->set_flashdata('error', validation_errors());
				
			}

         $data['authorization'] = $this->Common_Model->FetchData("authorization","*","authorization_id=".$authorization_id."");
		$data['activemenu'] = 'document';
		$data['activesubmenu'] = 'authorization_letter';
		$this->load->view('document/edit_authorization',$data);
	}
	 public function delete_authorization($authorization_id=0)
	{
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$this->Common_Model->DelData("authorization", "authorization_id = ".$authorization_id);
		redirect($_SERVER['HTTP_REFERER']);
		$this->load->view('document/delete_authorization');
	}
	public function theft_termination_letter()
	{
		$data = array();
		if($this->input->post('submitBtn')){
			$this->form_validation->set_rules('employe_id', 'employe_id', 'trim|required');
			$this->form_validation->set_error_delimiters('<p class="has-error"><label class="control-label">', '</label></p>');

			if($this->form_validation->run()){
				$data_list = array(
					'employe_id'	        => $this->input->post('employe_id'),
					'theft_date'			=> $this->input->post('theft_date'),
					'theftemp_name'			=> $this->input->post('theftemp_name'),
					'reason_of_ter'			=> $this->input->post('reason_of_ter'),
					);
				$this->Common_Model->dbinsertid("termination", $data_list);
			}
			$this->session->set_flashdata('success', 'Register successfully.' );
				redirect('document/theft_termination_letter');
			}else{
				$this->session->set_flashdata('error', validation_errors());
				
			}

         $data['termination'] = $this->Common_Model->FetchData("termination","*","1 ORDER BY termination_id ASC");
		$data['activemenu'] = 'document';
		$data['activesubmenu'] = 'theft_termination_letter';
		$this->load->view('document/theft_termination_letter',$data);
	}
	public function edit_theft_termination($termination_id=0)
	{
		$data = array();
		$data['termination_id'] = $termination_id;
		if($this->input->post('submitBtn')){
			$this->form_validation->set_rules('employe_id', 'employe_id', 'trim|required');
			$this->form_validation->set_error_delimiters('<p class="has-error"><label class="control-label">', '</label></p>');

			if($this->form_validation->run()){
				$data_list = array(
					'employe_id'	        => $this->input->post('employe_id'),
					'theft_date'			=> $this->input->post('theft_date'),
					'theftemp_name'			=> $this->input->post('theftemp_name'),
					'reason_of_ter'			=> $this->input->post('reason_of_ter'),
					);
				$this->Common_Model->update_records("termination","termination_id",$termination_id, $data_list);
			}
			$this->session->set_flashdata('success', 'Register successfully.' );
				redirect('document/theft_termination_letter');
			}else{
				$this->session->set_flashdata('error', validation_errors());
				
			}

         $data['termination'] = $this->Common_Model->FetchData("termination","*","termination_id=".$termination_id."");
		$data['activemenu'] = 'document';
		$data['activesubmenu'] = 'theft_termination_letter';
		$this->load->view('document/edit_theft_termination',$data);
	}
	 public function delete_theft_termination($termination_id=0)
	{
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$this->Common_Model->DelData("termination", "termination_id = ".$termination_id);
		redirect($_SERVER['HTTP_REFERER']);
		$this->load->view('document/delete_theft_termination');
	}
	public function noc_letter()
	{
		$data = array();
		if($this->input->post('submitBtn')){
			$this->form_validation->set_rules('emp_id', 'Employee Id', 'trim|required');
			$this->form_validation->set_error_delimiters('<p class="has-error"><label class="control-label">', '</label></p>');

			if($this->form_validation->run()){
				$data_list = array(
					'emp_id'				    => $this->input->post('emp_id'),
					'emp_name'				    => $this->input->post('emp_name'),
					'site_name'					=> $this->input->post('site_name'),
					'form_date'					=> $this->input->post('form_date'),
					'to_date'					=> $this->input->post('to_date'),
					);
				$this->Common_Model->dbinsertid("noc_letter", $data_list);
			}
			$this->session->set_flashdata('success', 'Register successfully.' );
				redirect('document/noc_letter');
			}else{
				$this->session->set_flashdata('error', validation_errors());
				
			}

        $data['noc'] = $this->Common_Model->FetchData("noc_letter","*","1 ORDER BY noc_id ASC");
		$data['activemenu'] = 'document';
		$data['activesubmenu'] = 'noc_letter';
		$this->load->view('document/noc_letter',$data);
	}
	public function editnoc($noc_id = 0)
	{
		$data = array();
		$data['noc_id'] = $noc_id;
		if($this->input->post('submitBtn')){
			$this->form_validation->set_rules('emp_id', 'Employee Id', 'trim|required');
			$this->form_validation->set_error_delimiters('<p class="has-error"><label class="control-label">', '</label></p>');

			if($this->form_validation->run()){
				$data_list = array(
					'emp_id'				    => $this->input->post('emp_id'),
					'emp_name'				    => $this->input->post('emp_name'),
					'site_name'					=> $this->input->post('site_name'),
					'form_date'					=> $this->input->post('form_date'),
					'to_date'					=> $this->input->post('to_date'),
					);
				$this->Common_Model->update_records("noc_letter","noc_id",$noc_id, $data_list);
			}
			$this->session->set_flashdata('success', 'Register successfully.' );
				redirect('document/noc_letter');
			}else{
				$this->session->set_flashdata('error', validation_errors());
				
			}
        $data['noc'] = $noc = $this->Common_Model->FetchData("noc_letter","*","noc_id=".$noc_id."");
		$data['activemenu'] = 'document';
		$data['activesubmenu'] = 'noc_letter';
		$this->load->view('document/editnoc',$data);
	}
	public function deletenoc($noc_id=0)
	{
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$this->Common_Model->DelData("noc_letter", "noc_id = ".$noc_id);
		redirect($_SERVER['HTTP_REFERER']);
		$this->load->view('document/deletenoc');
	}
	public function offerletter()
	{
		$data = array();
		if($this->input->post('submitBtn')){
			$this->form_validation->set_rules('offer_name', 'Offer Name', 'trim|required');
			$this->form_validation->set_error_delimiters('<p class="has-error"><label class="control-label">', '</label></p>');

			if($this->form_validation->run()){
				$data_list = array(
					'offer_name'			    => $this->input->post('offer_name'),
					'designation'				=> $this->input->post('designation'),
					'offer_location'			=> $this->input->post('offer_location'),
					'gross_salary'			    => $this->input->post('gross_salary'),
					);
				$this->Common_Model->dbinsertid("offerletter", $data_list);
			}
			$this->session->set_flashdata('success', 'Register successfully.' );
				redirect('document/offerletter');
			}else{
				$this->session->set_flashdata('error', validation_errors());
				
			}

        $data['offerletter'] = $this->Common_Model->FetchData("offerletter","*","1 ORDER BY offerletter_id ASC");
		$data['activemenu'] = 'document';
		$data['activesubmenu'] = 'offerletter';
		$this->load->view('document/offerletter',$data);
	}
	public function editofferletter($offerletter_id = 0)
	{
		$data = array();
		$data['offerletter_id'] = $offerletter_id;
		if($this->input->post('submitBtn')){
			$this->form_validation->set_rules('offer_name', 'Name', 'trim|required');
			$this->form_validation->set_error_delimiters('<p class="has-error"><label class="control-label">', '</label></p>');

			if($this->form_validation->run()){
				$data_list = array(
					'offer_name'				=> $this->input->post('offer_name'),
					'designation'				=> $this->input->post('designation'),
					'offer_location'			=> $this->input->post('offer_location'),
					'gross_salary'			     => $this->input->post('gross_salary'),
					);
				$this->Common_Model->update_records("offerletter","offerletter_id",$offerletter_id, $data_list);
			}
			$this->session->set_flashdata('success', 'Register successfully.' );
				redirect('document/offerletter');
			}else{
				$this->session->set_flashdata('error', validation_errors());
				
			}
        $data['offerletter'] = $noc = $this->Common_Model->FetchData("offerletter","*","offerletter_id=".$offerletter_id."");
		$data['activemenu'] = 'document';
		$data['activesubmenu'] = 'offerletter';
		$this->load->view('document/editofferletter',$data);
	}
	public function deleteofferletter($offerletter_id=0)
	{
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$this->Common_Model->DelData("offerletter", "offerletter_id = ".$offerletter_id);
		redirect($_SERVER['HTTP_REFERER']);
		$this->load->view('document/deleteofferletter');
	}
	// public function leave_applications()
	// {
	// 	$data = array();

	// 	$data['activemenu'] = 'document';
	// 	$data['activesubmenu'] = 'leave_applications';
	// 	$this->load->view('document/leave_applications',$data);
	// }
	// public function transfer_letter()
	// {
	// 	$data = array();

	// 	$data['activemenu'] = 'document';
	// 	$data['activesubmenu'] = 'transfer_letter';
	// 	$this->load->view('document/transfer_letter',$data);
	// }
	// public function Joining_form()
	// {
	// 	$data = array();

	// 	$data['activemenu'] = 'document';
	// 	$data['activesubmenu'] = 'Joining_form';
	// 	$this->load->view('document/Joining_form',$data);
	// }





	function letter_transfer(){
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		error_reporting(0);
		ini_set('display_error', -1);
		
		$html = $this->load->view('document/letter_transfer', $data, TRUE);
		$this->load->library('Pdf');
		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('IMPRONEX');
		$pdf->SetTitle('Transfer Letter');
		$pdf->SetSubject('Transfer Letter');
		
		$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
		$pdf->setHeaderData($ln='logopng.png', $lw=60, $ht='', $hs='', $tc=array(0,0,0), $lc=array(0,0,0));
		$pdf->setRTL(true);
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
		$pdf->setRTL(false);
		$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
		date_default_timezone_set("Asia/Kolkata");
		$filename = 'TransferLtr-'.date("YmdHis").'.pdf';
		$pdf->Output($filename, 'I');
	}
	function print_offerletter($offerletter_id=0){
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		error_reporting(0);
		ini_set('display_error', -1);
		$data['offerletter'] = $this->Common_Model->FetchData("offerletter","*","offerletter_id=".$offerletter_id);
		$html = $this->load->view('document/print_offerletter', $data, TRUE);
		$this->load->library('Pdf');
		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('IMPRONEX');
		$pdf->SetTitle('Offer Letter');
		$pdf->SetSubject('Offer Letter');
		
		$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
		$pdf->setHeaderData($ln='logopng.png', $lw=60, $ht='', $hs='', $tc=array(0,0,0), $lc=array(0,0,0));
		$pdf->setRTL(true);
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
		$pdf->setRTL(false);
		$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
		date_default_timezone_set("Asia/Kolkata");
		$filename = 'OfferLtr-'.date("YmdHis").'.pdf';
		$pdf->Output($filename, 'I');
	}

	

	function print_experience_letter($experience_letter_id=0){
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		error_reporting(0);
		ini_set('display_error', -1);
		$data['exprience'] =$exprience= $this->Common_Model->FetchData("experience_letter","*","experience_letter_id=".$experience_letter_id);
		$data['employee'] = $this->Common_Model->FetchData("employees as a LEFT JOIN designation as b on a.designation_id=b.designation_id","*","a.techno_emp_id='".$exprience[0]['employee_id']."'");

		$html = $this->load->view('document/print_experience_letter', $data, TRUE);
		$this->load->library('Pdf');
		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('GLOSENT');
		$pdf->SetTitle('Experience Letter');
		$pdf->SetSubject('Experience Letter');
		
		$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
		$pdf->setHeaderData($ln='logopng.png', $lw=60, $ht='', $hs='', $tc=array(0,0,0), $lc=array(0,0,0));
		$pdf->setRTL(true);
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
		$pdf->setRTL(false);
		$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
		date_default_timezone_set("Asia/Kolkata");
		$filename = 'ExpLtr-'.date("YmdHis").'.pdf';
		$pdf->Output($filename, 'I');
	}
	function leave_application(){
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		error_reporting(0);
		ini_set('display_error', -1);
		
		$html = $this->load->view('document/leave_application', $data, TRUE);
		$this->load->library('Pdf');
		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('IMPRONEX');
		$pdf->SetTitle('Leave Application');
		$pdf->SetSubject('Leave Application');
		
		$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
		$pdf->setHeaderData($ln='logopng.png', $lw=60, $ht='', $hs='', $tc=array(0,0,0), $lc=array(0,0,0));
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
		$filename = 'leaveApplication-'.date("YmdHis").'.pdf';
		$pdf->Output($filename, 'I');
	}
	function print_suspenssion($suspension_id=0){
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		error_reporting(0);
		ini_set('display_error', -1);
		$data['suspension'] = $this->Common_Model->FetchData("suspension","*","suspension_id=".$suspension_id);
		$html = $this->load->view('document/print_suspenssion', $data, TRUE);
		$this->load->library('Pdf');
		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('IMPRONEX');
		$pdf->SetTitle('Suspension Letter');
		$pdf->SetSubject('Suspension Letter');
		
		$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
		$pdf->setHeaderData($ln='logopng.png', $lw=60, $ht='', $hs='', $tc=array(0,0,0), $lc=array(0,0,0));
		$pdf->setRTL(true);
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
		$pdf->setRTL(false);
		$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
		date_default_timezone_set("Asia/Kolkata");
		$filename = 'SuspensionLtr-'.date("YmdHis").'.pdf';
		$pdf->Output($filename, 'I');
	}
	function print_theft_termination($termination_id=0){
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		error_reporting(0);
		ini_set('display_error', -1);
		$data['termination'] = $termination = $this->Common_Model->FetchData("termination","*","termination_id=".$termination_id);

		$data['employee'] = $this->Common_Model->FetchData("employees as a LEFT JOIN designation as b on a.designation_id=b.designation_id","*","a.techno_emp_id='".$termination[0]['employe_id']."'");
		$html = $this->load->view('document/print_theft_termination', $data, TRUE);
		$this->load->library('Pdf');
		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('IMPRONEX');
		$pdf->SetTitle('Theft Termination');
		$pdf->SetSubject('Theft Termination');
		
		$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
		$pdf->setHeaderData($ln='logopng.png', $lw=60, $ht='', $hs='', $tc=array(0,0,0), $lc=array(0,0,0));
		$pdf->setRTL(true);
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
		$pdf->setRTL(false);
		$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
		date_default_timezone_set("Asia/Kolkata");
		$filename = 'TheftTermination-'.date("YmdHis").'.pdf';
		$pdf->Output($filename, 'I');
	}

	function print_termination_letter($termination_letter_id=0){
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		error_reporting(0);
		ini_set('display_error', -1);
		$data['termination'] = $termination= $this->Common_Model->FetchData("termination_letter","*","termination_letter_id=".$termination_letter_id);
		$data['employee'] = $this->Common_Model->FetchData("employees as a LEFT JOIN designation as b on a.designation_id=b.designation_id","*","a.techno_emp_id='".$termination[0]['ter_employee_id']."'");
		$html = $this->load->view('document/print_termination_letter', $data, TRUE);
		$this->load->library('Pdf');
		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('IMPRONEX');
		$pdf->SetTitle('Termination Letter');
		$pdf->SetSubject('Termination Letter');
		
		$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
		$pdf->setHeaderData($ln='logopng.png', $lw=60, $ht='', $hs='', $tc=array(0,0,0), $lc=array(0,0,0));
		$pdf->setRTL(true);
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
		$pdf->setRTL(false);
		$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
		date_default_timezone_set("Asia/Kolkata");
		$filename = 'TerminationLtr-'.date("YmdHis").'.pdf';
		$pdf->Output($filename, 'I');
	}
	function experience_letter2(){
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		error_reporting(0);
		ini_set('display_error', -1);
		
		$html = $this->load->view('document/experience_letter2', $data, TRUE);
		$this->load->library('Pdf');
		$pdf = new Pdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('IMPRONEX');
		$pdf->SetTitle('Experience Letter');
		$pdf->SetSubject('Experience Letter');

		$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
		$pdf->setHeaderData($ln='', $lw=0, $ht='', $hs='', $tc=array(0,0,0), $lc=array(0,0,0));
		$pdf->SetMargins(10, 10, 10, true);
		$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

		$pdf->SetAutoPageBreak(TRUE, 17);
		// set image scale factor
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
		$pdf->AddPage('P', 'A4', true, true);

		$pdf->SetMargins(10, 25, 10, true);

		$pdf->SetFont('helvetica', '', 8);

		$pdf->setFontSubsetting(false);
		$pdf->writeHTML($html, true, false, false, false, '');
		date_default_timezone_set("Asia/Kolkata");
		$filename = date("YmdHis").'.pdf';
		$pdf->Output($filename, 'I');
	}
	function print_noc($noc_id=0){
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		error_reporting(0);
		ini_set('display_error', -1);
		$data['noc'] =$noc= $this->Common_Model->FetchData("noc_letter","*","noc_id=".$noc_id);

		$data['employee'] = $this->Common_Model->FetchData("employees as a LEFT JOIN designation as b on a.designation_id=b.designation_id","*","a.techno_emp_id='".$noc[0]['emp_id']."'");

		$html = $this->load->view('document/print_noc', $data, TRUE);
		$this->load->library('Pdf');
		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('IMPRONEX');
		$pdf->SetTitle('NOC Letter');
		$pdf->SetSubject('NOC Letter');
		
		$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
		$pdf->setHeaderData($ln='logopng.png', $lw=60, $ht='', $hs='', $tc=array(0,0,0), $lc=array(0,0,0));
		$pdf->setRTL(true);
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
		$pdf->setRTL(false);
		$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
		date_default_timezone_set("Asia/Kolkata");
		$filename = 'NOCLtr-'.date("YmdHis").'.pdf';
		$pdf->Output($filename, 'I');
	}
	function print_authorization($authorization_id=0){
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		error_reporting(0);
		ini_set('display_error', -1);
		$data['authorization'] = $this->Common_Model->FetchData("authorization","*","authorization_id=".$authorization_id);
		$html = $this->load->view('document/print_authorization', $data, TRUE);
		$this->load->library('Pdf');
		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('IMPRONEX');
		$pdf->SetTitle('Authorization Letter');
		$pdf->SetSubject('Authorization Letter');
		
		$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
		$pdf->setHeaderData($ln='logopng.png', $lw=60, $ht='', $hs='', $tc=array(0,0,0), $lc=array(0,0,0));
		$pdf->setRTL(true);
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
		$pdf->setRTL(false);
		$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
		date_default_timezone_set("Asia/Kolkata");
		$filename = 'AuthorizationLtr-'.date("YmdHis").'.pdf';
		$pdf->Output($filename, 'I');
	}

	function print_relieving($relieving_id=0){
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		error_reporting(0);
		ini_set('display_error', -1);
		$data['relieving'] = $this->Common_Model->FetchData("relieving","*","relieving_id=".$relieving_id);
		$html = $this->load->view('document/print_relieving', $data, TRUE);
		$this->load->library('Pdf');
		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('IMPRONEX');
		$pdf->SetTitle('Relieving Letter');
		$pdf->SetSubject('Relieving Letter');
		
		$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
		$pdf->setHeaderData($ln='logopng.png', $lw=60, $ht='', $hs='', $tc=array(0,0,0), $lc=array(0,0,0));
		$pdf->setRTL(true);
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
		$pdf->setRTL(false);
		$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
		date_default_timezone_set("Asia/Kolkata");
		$filename = 'RelievingLtr-'.date("YmdHis").'.pdf';
		$pdf->Output($filename, 'I');
	}
	function print_appointment($appointment_id=0){
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		error_reporting(0);
		ini_set('display_error', -1);

		$data['appointment'] = $appointment = $this->Common_Model->FetchData("appointment","*","appointment_id=".$appointment_id);
         $data['salary'] = $salary = $this->Common_Model->FetchData("salary_wages","*","appion_id =".$appointment_id );
		//print_r($salary); exit;
		$html = $this->load->view('document/print_appointment', $data, TRUE);
		$this->load->library('Pdf');
		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('IMPRONEX');
		$pdf->SetTitle('Appointment Letter');
		$pdf->SetSubject('Appointment Letter');
		
		$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
		$pdf->setHeaderData($ln='logopng.png', $lw=60, $ht='', $hs='', $tc=array(0,0,0), $lc=array(0,0,0));
		$pdf->setRTL(true);
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
		$pdf->setRTL(false);
		$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
		date_default_timezone_set("Asia/Kolkata");
		$filename = 'AppointmentLtr-'.date("YmdHis").'.pdf';
		$pdf->Output($filename, 'I');
	}

	function joining_form(){
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		error_reporting(0);
		ini_set('display_error', -1);

		$html = $this->load->view('document/joining_form', $data, TRUE);
		$this->load->library('Pdf');
		$pdf = new Pdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('IMPRONEX');
		$pdf->SetTitle('Joining Form');
		$pdf->SetSubject('Joining Form');

		$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
		$pdf->setHeaderData($ln='', $lw=0, $ht='', $hs='', $tc=array(0,0,0), $lc=array(0,0,0));
		$pdf->SetMargins(10, 10, 10, true);
		$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

		$pdf->SetAutoPageBreak(TRUE, 17);
		// set image scale factor
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
		$pdf->AddPage('P', 'A4', true, true);

		$pdf->SetMargins(10, 25, 10, true);

		$pdf->SetFont('helvetica', '', 8);

		$pdf->setFontSubsetting(false);
		$pdf->writeHTML($html, true, false, false, false, '');
		date_default_timezone_set("Asia/Kolkata");
		$filename = date("YmdHis").'.pdf';
		$pdf->Output($filename, 'I');
	}



	public function get_employeeDataById(){
		$employee_id = $this->input->post('employee_id');

		$employee = $this->Common_Model->FetchData("employees","*","techno_emp_id='".$employee_id."'");
		if ($employee) {
			
		$html = $employee[0]['employee_name'].'@#@';
		$html .= $employee[0]['emp_fathername'].'@#@';

	}else{
		$html ='';
	}
		
		echo $html;
	}






}