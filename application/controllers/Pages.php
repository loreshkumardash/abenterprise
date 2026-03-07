<?php 
error_reporting(0);
defined('BASEPATH') OR exit('No direct script access allowed');



class Pages extends CI_Controller {

	public function __construct(){
		parent::__construct();
		
		date_default_timezone_set("Asia/Kolkata"); 
		$this->present_date 		= date('Y-m-d');
		$this->present_time 		= date('H:i:a');
		$this->timestamp 		= date('Y-m-d H:i:s'); 
		$this->load->library('form_validation');
    	$this->load->model('Common_Model');
	}
  
    public function index($pid = 0) {
		$data = array();
		 // Fetch all properties
	    $data['properties'] = $this->Common_Model->FetchData("property as a LEFT JOIN users as b on a.proj_head=b.user_id", "a.*,b.userphone", "avail_status = 'available' ORDER BY pid DESC");

	    // Fetch all property images
	    foreach ($data['properties'] as $key => $property) {
	        $data['properties'][$key]['images'] = $this->Common_Model->FetchData(
	            "property_images", 
	            "*", 
	            "pid = " . $property['pid'] . " AND image_type = 'property_image'"
	        );
	    }

		 $this->load->view('website/index', $data);
	}
	
	public function details($pid=0) {
		$data = array();
		$data['property'] = $this->Common_Model->FetchData("property as a LEFT JOIN users as b on a.proj_head=b.user_id", "a.*,b.userphone", "pid = $pid");
		$data['propertyimg'] = $this->Common_Model->FetchData("property_images", "*", 
			"pid = $pid AND image_type = 'property_image'");
		$data['floorplan'] = $this->Common_Model->FetchData("property_images", "*", 
			"pid = $pid AND image_type = 'floor_plan'");

		//echo"<pre>";print_r($data['property']);exit;

		 $this->load->view('website/details', $data);
	}


public function enquiry(){
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    	$this->load->library('form_validation');
        $this->load->model('Common_Model');

        $this->form_validation->set_rules('phone','Phone','required|numeric|exact_length[10]');
        $this->form_validation->set_rules('email','Email','required');

        if ($this->form_validation->run()) {

            $data = [
                'property_id' => $this->input->post('property_id'),
                'email'       => $this->input->post('email'),
                'phone'       => $this->input->post('phone'),
                'remark'      => $this->input->post('remark'),
                'other'		  => $this->input->post('other'),
                'price'		  => $this->input->post('price'),
                'area'		  => $this->input->post('area'),
                'created_at'  => date('Y-m-d H:i:s')
            ];

            $insert = $this->Common_Model->dbinsertid('property_enquiry', $data);

            if($insert){
                $this->session->set_flashdata('success','Enquiry submitted successfully');
            }else{
                $this->session->set_flashdata('error','DB Insert Failed');
            }
        }else {
            $this->session->set_flashdata('error', validation_errors());
        }
    }

    redirect($_SERVER['HTTP_REFERER']);
}


	public function enquiry_backup($pid = 0){
    // POST check (best practice)
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $this->load->library('form_validation');
        $this->load->model('Common_Model');

        $this->form_validation->set_rules('email','Email','required|valid_email');
        $this->form_validation->set_rules('phone','Phone Number','required|numeric|exact_length[10]');
        $this->form_validation->set_rules('remark','Remark','trim|required');
        if ($this->form_validation->run() === TRUE) {
            $data = array(
                'property_id' => $pid,
                'email'       => $this->input->post('email', TRUE),
                'phone'       => $this->input->post('phone', TRUE),
                'remark'      => $this->input->post('remark', TRUE),
                'created_at'  => date('Y-m-d H:i:s')
            );

            $insert = $this->Common_Model->dbinsertid('property_enquiry', $data);

            if ($insert) {
                $this->session->set_flashdata(
                    'success',
                    'Enquiry submitted successfully'
                );
            } else {
                $this->session->set_flashdata(
                    'error',
                    'Database insert failed'
                );
            }

            redirect('pages/enquiry/'.$pid);
        } else {
            $this->session->set_flashdata(
                'error',
                validation_errors()
            );
        }
    }

    // Load form
    $data['pid'] = $pid;
    $this->load->view('website/enquiry', $data);
}


    public function listing($pid = 0) { 
	    $data = array();
	    
	    // Fetch all properties
	    $data['properties'] = $this->Common_Model->FetchData("property as a LEFT JOIN users as b on a.proj_head=b.user_id", "*", "avail_status = 'available'");

	    // Fetch all property images
	    foreach ($data['properties'] as $key => $property) {
	        $data['properties'][$key]['images'] = $this->Common_Model->FetchData(
	            "property_images", 
	            "*", 
	            "pid = " . $property['pid'] . " AND image_type = 'property_image'"
	        );
	    }
	    //echo"<pre>";print_r($data['properties']);exit; 

	    $this->load->view('website/listing', $data);
	}

	public function contact_us(){
		$data = array();
		if($this->input->post()){
		$datalist = array(
			'fullname' => $this->input->post('fullname'),
			
			'email_id' => $this->input->post('email_id'),
			'subject' => $this->input->post('subject'),
			'message' => $this->input->post('message'),
			'dateadded' => $this->timestamp
		);
		//echo "pre";print_r($datalist);exit;
		$this->Common_Model->dbinsertid('contact_us',$datalist);
		echo "<script>alert('Thank you for your Message! We appreciate your time and effort for us. Your Message has been successfully submitted. Our team will get in touch with you shortly...');
		window.location.href = '".site_url()."';
		</script>";	
		 exit;
	   } 
	   $this->load->view('website/contact', $data);
		 
	}
	
	public function mailform() {
		$data = array();

		 $this->load->view('website/mail-form', $data);
	}
	
	
	public function about() {
		$data = array();

		 $this->load->view('website/about', $data);
	}
	public function privacyPolicy() {
		$data = array();

		 $this->load->view('website/privacy-policy', $data);
	}
	
	public function termCondition() {
		$data = array();

		 $this->load->view('website/terms-conditions', $data);
	}
	public function services() {
		$data = array();

		 $this->load->view('website/services', $data);
	}
// 	public function mailform() {
// 		$data = array();

// 		 $this->load->view('website/mail-form', $data);
// 	}
    public function submitEnquiry() {
		$data = array();
		if($this->input->post()){
		$datalist = array(
			'name' => $this->input->post('name'),
			'mobile' => $this->input->post('mobile'),
			'email' => $this->input->post('email'),
			'wp_no' => $this->input->post('wp_no'),
			'specification' => $this->input->post('specification'),
			'location' => $this->input->post('preferred_location'),
			'budget' => $this->input->post('budget'),
			'deal_mode' => $this->input->post('deal_mode'),
			'occupation' => $this->input->post('occupation'),
			'salary' => $this->input->post('salary'),
			'plan_o_date' => $this->input->post('plan_o_date'),
			'message' => $this->input->post('message'),
			'enquiry_date' => date("Y-m-d"),
			'source'  => 3
		);
		//echo "pre";print_r($datalist);exit;
		$this->Common_Model->dbinsertid('lead_enquiry',$datalist);
		echo "<script>alert('Thank you for your enquiry! Your request has been successfully submitted. Our team will get in touch with you shortly.');
		window.location.href = '".site_url()."';
		</script>";	
	   } else {
	   		echo "<script>alert('Something went wrong..!!');
	   		window.location.href = '".site_url()."';
	   		</script>";

	   }

		 //redirect('pages/index');
	}
	
	public function siteVisit() {
		$data = array();
		if($this->input->post()){
		$datalist = array(
			'c_name' => $this->input->post('c_name'),
			'con_no' => $this->input->post('con_no'),
			'email' => $this->input->post('email'),
			'visit_date' => $this->input->post('visit_date'),
			'time_slot' => $this->input->post('time_slot'),
			'specific_time' => $this->input->post('specific_time'),
			'prop_interest' => $this->input->post('prop_interest'),
			'notes' => $this->input->post('notes'),
			'dateadded' => $this->timestamp,
			'request_by' => 'Website'
		);
		//echo "pre";print_r($datalist);exit;
		$this->Common_Model->dbinsertid('site_visit',$datalist);
		$data_list = array(
			'name' => $this->input->post('c_name'),
			'mobile' => $this->input->post('con_no'),
			'enquiry_date' => $this->present_date,
			'enquiry_remark' => $this->input->post('notes'),
			'specification' => $this->input->post('prop_interest')
		);
		$this->Common_Model->dbinsertid('lead_enquiry',$data_list);
	    echo "<script>alert('Thank you for your Site Visit Request! We appreciate your time and effort for Our Site Visit. Your request has been successfully submitted. Our team will get in touch with you shortly...');
		window.location.href = '".site_url()."';
		</script>";	
	   } else {
	   		echo "<script>alert('Something went wrong..!!');
	   		window.location.href = '".site_url()."';
	   		</script>";

	   }

	}
	
	public function feedback(){
		$data = array();
		if($this->input->post()){
		$datalist = array(
			'name' => $this->input->post('name'),
			'mob_no' => $this->input->post('mob_no'),
			'date_visit' => $this->input->post('date_visit'),
			
			'prop_visited' => $this->input->post('prop_visited'),
			'rating' => $this->input->post('rating'),
			'likes' => $this->input->post('likes'),
			'concerns' => $this->input->post('concerns'),
			'proceed' => $this->input->post('proceed'),
			'dateadded' => $this->timestamp
		);
		
		$this->Common_Model->dbinsertid('feedback_s',$datalist);
		echo "<script>alert('Thank you for your feedback! We appreciate your time and effort in helping us improve.');
		window.location.href = '".site_url()."';
		</script>";	
		 exit;
		} 
		$this->load->view('website/feedback-form', $data);
	}
}

