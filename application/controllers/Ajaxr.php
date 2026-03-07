<?php
error_reporting(0);
defined('BASEPATH') OR exit('No direct script access allowed');

class Ajaxr extends CI_Controller {

	public function __construct(){
		parent::__construct();
		is_logged_in();
		date_default_timezone_set("Asia/Kolkata"); 
		$this->present_date 		= date('Y-m-d');
		$this->present_time 		= date('H:i:a');
		$this->timestamp 			= date('Y-m-d H:i:s'); 
	}

	public function index()
	{

	}

	function calculate_emi(){
		$session = $this->Common_Model->FetchData("sessions", "*", "session_id = ".$this->input->post('session_id'));
		$plan = $this->input->post("plan");
		$fee = $this->input->post("fee");
		$paid = $this->input->post("paid");
		$pending = $fee - $paid;
		$emis = array();
		if($pending < $plan)
			$emis = array();
			// If x % n == 0 then the minimum  
			// difference is 0 and all  
			// numbers are x / n 
		else if ($pending % $plan == 0){ 
			for($i = 0; $i < $plan; $i++){ 
				$emis[] = ($pending / $plan); 
			} 
		}else{ 
			// upto n-(x % n) the values  
			// will be x / n  
			// after that the values  
			// will be x / n + 1 
			$zp = $plan - ($pending % $plan); 
			$pp = $pending / $plan; 
			for ($i = 0; $i < $plan; $i++){ 
				if($i >= $zp){ 
					$emis[] = (int)$pp + 1; 
				}else{ 
					$emis[] = (int)$pp; 
				} 
			} 
		}
		$now = strtotime($session[0]['session_start_date']);
		$end_date = strtotime($session[0]['session_end_date']);
		$datediff = $end_date - $now;

		$days = round($datediff / (60 * 60 * 24));
		$darr = array();
		if($days < $plan)
			$darr = array();
		else if ($days % $plan == 0){ 
			for($i = 0; $i < $plan; $i++){ 
				$darr[] = ($days / $plan); 
			} 
		}else{ 
			$zp = $plan - ($days % $plan); 
			$pp = $days / $plan; 
			for ($i = 0; $i < $plan; $i++){ 
				if($i >= $zp){ 
					$darr[] = (int)$pp + 1; 
				}else{ 
					$darr[] = (int)$pp; 
				} 
			} 
		}
		$html='';
		$ds = 0;

		for ($i=0; $i < count($emis); $i++) { 
			$ds = $ds + $darr[$i];
			$date = strtotime(date("Y",strtotime("-1 year")).'-12-31');
			$date = strtotime("+".$ds." day", $date);
			$dt = date("Y-m-d", $date);
			$duedate = date("Y-m-d", strtotime("+30 day", strtotime($dt)));
			$html.= '<tr><td><input type="number" class="form-control input-sm" name="emis[]" value="'.$emis[$i].'"></td><td><input type="date" class="form-control input-sm" name="plan_date[]" value="'.$dt.'"></td><td><input type="date" class="form-control input-sm" name="due_date[]" value="'.$duedate.'"></td></tr>';
		}
		echo $html;
		exit(); 
	}


	function calculate_transemi(){
		$session = $this->Common_Model->FetchData("sessions", "*", "session_id = ".$this->input->post('session_id'));
		$plan = $this->input->post("plan");
		$fee = $this->input->post("fee");
		$paid = $this->input->post("paid");
		$pending = $fee - $paid;
		$emis = array();
		if($pending < $plan)
			$emis = array();
			// If x % n == 0 then the minimum  
			// difference is 0 and all  
			// numbers are x / n 
		else if ($pending % $plan == 0){ 
			for($i = 0; $i < $plan; $i++){ 
				$emis[] = ($pending / $plan); 
			} 
		}else{ 
			// upto n-(x % n) the values  
			// will be x / n  
			// after that the values  
			// will be x / n + 1 
			$zp = $plan - ($pending % $plan); 
			$pp = $pending / $plan; 
			for ($i = 0; $i < $plan; $i++){ 
				if($i >= $zp){ 
					$emis[] = (int)$pp + 1; 
				}else{ 
					$emis[] = (int)$pp; 
				} 
			} 
		}
		$now = strtotime($session[0]['session_start_date']);
		$end_date = strtotime($session[0]['session_end_date']);
		$datediff = $end_date - $now;

		$days = round($datediff / (60 * 60 * 24));
		$darr = array();
		if($days < $plan)
			$darr = array();
		else if ($days % $plan == 0){ 
			for($i = 0; $i < $plan; $i++){ 
				$darr[] = ($days / $plan); 
			} 
		}else{ 
			$zp = $plan - ($days % $plan); 
			$pp = $days / $plan; 
			for ($i = 0; $i < $plan; $i++){ 
				if($i >= $zp){ 
					$darr[] = (int)$pp + 1; 
				}else{ 
					$darr[] = (int)$pp; 
				} 
			} 
		}
		$html='';
		$ds = 0;

		for ($i=0; $i < count($emis); $i++) { 
			$ds = $ds + $darr[$i];
			$date = strtotime(date("Y",strtotime("-1 year")).'-12-31');
			$date = strtotime("+".$ds." day", $date);
			$dt = date("Y-m-d", $date);
			$duedate = date("Y-m-d", strtotime("+30 day", strtotime($dt)));
			$html.= '<tr><td><input type="number" class="form-control input-sm" name="transemis[]" value="'.$emis[$i].'"></td><td><input type="date" class="form-control input-sm" name="transplan_date[]" value="'.$dt.'"></td><td><input type="date" class="form-control input-sm" name="transdue_date[]" value="'.$duedate.'"></td></tr>';
		}
		echo $html;
		exit(); 
	}

	function getClassAccessoriesBuy(){
		$records = $this->Common_Model->FetchPaginationData("assets", "*", "1 ORDER BY item_name ASC");
		$items = $this->Common_Model->FetchData("assets", "*", "1 ORDER BY item_name ASC");
		$html = '';
		$options = '';
		
		if($items){
				for($i=0;$i<count($items);$i++){
					$options.= '<option value="'.$items[$i]['asset_id'].'" data-price="'.$items[$i]['item_price'].'">'.$items[$i]['item_name'].'</option>';
				}
			}
		if($records){ for($r=0; $r < count($records); $r++){
			$de = '<a href="javascript:;" class="btnRemoveItem btn btn-xs btn-danger pu<option value=""></option>-trash"></i> </a>';
			$total = (int)$records[$r]['item_price'] * (int)$records[$r]['minqty'];
			$html.= '<tr><td><select class="form-control item_name" name="item_name[]"><option value=""></option>'.$options.'</select></td><td> <input type="text" name="item_price[]" class="form-control item_price" value="'.$records[$r]['item_price'].'" readonly="readonly"> Quantity<br/> <input type="number" name="item_quantity[]" class="form-control item_quantity" min="1" value="'.$records[$r]['minqty'].'"> </td> <td> <input type="text" name="item_total_price[]" class="form-control item_total_price" readonly="readonly" value="'.$total.'">'.$de.'</td></tr>';
		}} 

		echo $html;
		die();
	}


	function book_select_option(){
		$records = $this->Common_Model->FetchData("`books` AS b LEFT JOIN book_categories_mapping AS m ON b.book_id = m.book_id LEFT JOIN book_categories AS c ON m.category_id = c.category_id", "b.book_id, b.isbn, b.title, b.subtitle, b.author, b.edition, b.edition_year, b.quantity, b.cover_image, b.physical_form, b.publisher, b.price, b.pages, b.pdf_copy, b.pdf_url, b.available_quantity, GROUP_CONCAT(c.category_name) AS category", "b.title LIKE '%".$_GET['q']."%' OR b.subtitle LIKE '%".$_GET['q']."%' OR b.isbn LIKE '%".$_GET['q']."%' OR c.category_name LIKE '%".$_GET['q']."%' GROUP BY b.book_id");
		$json = [];
		if($records){
			$j=1;
			for($i=0;$i<count($records);$i++){
				$json[] = ['id'=>$records[$i]['book_id'], 'text'=>$records[$i]['title']];
			}
		}
		echo json_encode($json);
		die();
	}

	function get_book_info_by_id(){
		$records = $this->Common_Model->FetchData("books", "*", "book_id = '".$this->input->post("book_id")."'");
		$data = array(
			"book_id"				=> $records[0]['book_id'],
			"title"					=> $records[0]['title'],
			"author"				=> $records[0]['author'],
			"available_quantity"	=> $records[0]['available_quantity'],
			"isbn"					=> $records[0]['isbn']
		);
		echo json_encode($data);die();
	}	


	function get_subjects_options(){
		$records = $this->Common_Model->FetchData("subjects", "*", "class_id = '".$this->input->post("class_id")."' ORDER BY subject_name ASC");
		$options = '<option value="">select</option>';

		if($records){ for($r=0; $r < count($records); $r++){
			$options.= '<option value="'.$records[$r]['subject_id'].'">'.$records[$r]['subject_name'].'</option>';
		}}
		echo $options;
		die();
	}

	function get_subjects_options1(){
		$class = $this->Common_Model->FetchData("classes", "*", "class_id = '".$this->input->post("class_id")."'");
		if($class){
			for($x = 1; $x <= $class[0]['noofsubjects']; $x++){
				?>
				<div class="col-md-<?=$this->input->post("col")?>">
                  <div class="form-group">
                    <label for="subject_studied6">Subject <?=$x?></label>
                    <select class="form-control addadmissionfields subject_studied" id="subject_studied<?=$x?>" name="subject_studied[]">
                        <option></option>
                      	<?php
						$records = $this->Common_Model->FetchData("subjects", "*", "class_id = '".$this->input->post("class_id")."' AND subject_no = $x");
						$options = '';
						if($records){ for($r=0; $r < count($records); $r++){
						$options.= '<option value="'.$records[$r]['subject_id'].'">'.$records[$r]['subject_name'].'</option>';
						}}
						echo $options;
                      	?>
                    </select>
                  </div>
                </div>
				<?php 
			}
		}
		die();
	}

	function check_id_proof(){
		$student = $this->Common_Model->FetchData("students", "*", "id_proof = '".$this->input->post("id_proof")."'");
		if($student){
			echo 'exists';
		}else{
			echo 'not exists';
		}
		die();
	}

	function get_student_info(){
		$student = $this->Common_Model->FetchData("students as s LEFT JOIN classes as cls ON cls.class_id=s.student_class", "cls.class_name, s.student_first_name,s.student_last_name,s.father_name,s.mother_name,s.father_contact_no,s.student_dob, s.student_profile_photo", "student_id = '".$this->input->post('student_id')."'");
		echo json_encode($student[0]);
		exit;
	}
	
	function get_dataBypincode(){
    // Retrieve the pincode from the POST request
    $pincode = $this->input->post("pincode");
    
    // Initialize cURL session
    $curl = curl_init();
    
    // Set cURL options
    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api.postalpincode.in/pincode/' . $pincode,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_HTTPAUTH => CURLAUTH_ANY,
        CURLOPT_TIMEOUT => 30,  // Increased timeout to 30 seconds
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_POSTFIELDS => '',
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json'
        ),
    ));
    
    // Execute the cURL request and fetch the response
    $response = curl_exec($curl);
    
    // Check for cURL errors
    if(curl_errno($curl)) {
        // Print cURL error
        echo 'cURL Error: ' . curl_error($curl);
        curl_close($curl);
        return null;
    }
    
    // Close cURL session
    curl_close($curl);
    
    // Decode the JSON response
    $decodedResponse = json_decode($response, true);
    
    // Print the response (for debugging purposes)
    //print_r($decodedResponse[0]['Status']);
    if ($decodedResponse[0]['Status']=='Success') {
    		$status = $decodedResponse[0]['Status'];
    		$district = $decodedResponse[0]['PostOffice'][0]['District'];
    		$state = $decodedResponse[0]['PostOffice'][0]['State'];
    		echo json_encode(array("status" => $status, "district" => $district, "state" => $state));
    }else{
    		echo json_encode(array("status" => 0, "district" => '', "state" => ''));
    }
    
    // Return the decoded response
    return $response;
	}
}