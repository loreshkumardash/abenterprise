<?php
error_reporting(0);  
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

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
	    error_reporting(0);
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		//echo "<pre>";print_r($data['accessar']);exit;
		$date = date('Y-m-d');

		$data['leads'] = $leads = $this->Common_Model->countRows("lead_enquiry", "assigned_to=".$this->session->userdata('user_id')."");
		//echo $leads;exit;
		$data['lead'] = $lead = $this->Common_Model->countRows("lead_enquiry");
		
		$data['employees'] = $this->Common_Model->countRows("employees", "");

		$data['cp'] = $this->Common_Model->countRows("cp_reg", "approval = 'Approved'");
		$data['rp'] = $this->Common_Model->countRows("rp_reg", "approval = 'Approved'");

		$data['prop'] = $this->Common_Model->countRows("property");

 	    $data['propa'] = $this->Common_Model->countRows("property", "p_status = 'Live' AND avail_status = 'available'");

		$data['props'] = $this->Common_Model->countRows("property", "avail_status = 'sold'");

		$data['propup'] = $this->Common_Model->countRows("property", "p_status = 'Upcoming'");

		//for chart
		$data['inlead'] = $lead = $this->Common_Model->countRows("lead_enquiry", "comp_status='Initiated'");

		$data['interest'] = $this->Common_Model->countRows("interest", "remarks = 'interested'");
		$data['slead'] = $this->Common_Model->countRows("lead_enquiry", "comp_status = 'Success'");
		$data['opportunity'] = $this->Common_Model->countRows("interest", "remarks = 'opportunity'");
		
		$data['dlead'] = $this->Common_Model->countRows("lead_enquiry", "comp_status = 'Delete'");

		
		$data['user'] = $this->Common_Model->FetchData("users","*", "user_id=".$this->session->userdata('user_id')."");
		$data['emp'] = $this->Common_Model->FetchData("employees as a LEFT JOIN department as b on a.department_id=b.did","*","a.employee_id=".$this->session->userdata('employee_tagged_id')."");

   $employee_id = $this->session->userdata('employee_tagged_id');



		$data['employee'] = $this->Common_Model->FetchData("employees as a LEFT JOIN department as b on a.department_id=b.did","*","1 order by employee_id DESC");
		$sql ='1';
		if($this->session->userdata("usertype") == 'Admin'){
			$sql .= '';
		
		}else{
		    $tracking = $this->Common_Model->FetchData("access_tracking","*","access_userid=".$this->session->userdata('user_id'));
            if ($tracking) {  $access = json_decode($tracking[0]['tracking_access']);
                  if ($access) { for ($j=0; $j <count($access) ; $j++) { 
                      if(!empty($access[$j]) && $access[$j] > 0){
                        if ($j==0) {
                          $eassign = $access[$j]."";
                        }else{
                         $eassign = $eassign . ",'".$access[$j]."' ";
                        }
                      }
                    }}
                  }else{
                    $eassign ='1';
                  }
             $sql .= " AND b.user_id IN (" .$eassign. ")";
             
		}
		
		$datetime = new DateTime();
		$datetime->modify('-2 days');
		$attndate = $datetime->format('Y-m-d');
		
		$data['attenrec'] = $this->Common_Model->db_query("SELECT b.employee_name,a.user_id,a.log_datetime,a.attendance_log_id,a.log_loc,a.log_date,a.status,b.techno_emp_id,a.user_img FROM user_attendance_log as a LEFT JOIN employees as b on a.user_id=b.user_id WHERE $sql AND a.log_date >='".$attndate."' AND a.log_date <='".date('Y-m-d')."' AND approve_status=0 AND status=1 ORDER BY a.log_date DESC");
		
		$data['empatten'] = $this->Common_Model->db_query("SELECT SUM(A.noatten) as empduty,SUM(working_hour) as empwhour FROM emp_attendance A WHERE A.employee_id=".$this->session->userdata('employee_tagged_id')." AND MONTH(A.attended_date)=MONTH(CURRENT_DATE()) AND YEAR(A.attended_date)=YEAR(CURRENT_DATE())");

        $data['empexpence'] = $this->Common_Model->db_query("SELECT SUM(totalex_amount) as totexp FROM expenses  WHERE expadded_by=".$this->session->userdata('user_id')." AND status=1 AND MONTH(date)=MONTH(CURRENT_DATE()) AND YEAR(date)=YEAR(CURRENT_DATE())");
        
        $session  = $this->Common_Model->FetchData("sessions","*","active_session='Active'");
          $year = date('Y');
          $start = date('Y-m',strtotime($session[0]['session_start_date']));
          $end = date('Y-m',strtotime($session[0]['session_end_date']));

    $months =  $this->Common_Model->list_months($start,$end,'Y-m-d'); 

    $monthNames = [];
    $sales = [];
    $purchase = [];
    $expense = [];
    $payment = [];
        foreach ($months as $date) {
            $monthName = date('F', strtotime($date)); // 'F' gives full month name
            $fdate = date("Y-m-01",strtotime($date));
            $ldate = date("Y-m-t",strtotime($date));

            $saleac = $this->Common_Model->db_query("SELECT SUM(item_amount) as totcredit FROM invoice_items as a LEFT JOIN invoices as d on a.invoice_id=d.invoice_id LEFT JOIN ledgers as b on d.invoice_name=b.ledger_id WHERE d.invoice_status='Submitted' AND d.invoice_date >= '".$fdate."' AND d.invoice_date <= '".$ldate."'");

            $purchaseac = $this->Common_Model->db_query("SELECT SUM(item_amount) as totdebit FROM purchase_items as a LEFT JOIN purchase as d on a.purchase_id=d.purchase_id LEFT JOIN ledgers as b on d.purchase_from=b.ledger_id WHERE d.purchase_date >= '".$fdate."' AND d.purchase_date <= '".$ldate."'");

            $exp = $this->Common_Model->db_query("SELECT SUM(totalex_amount) as totexp FROM  expenses as a  WHERE a.date >= '".$fdate."' AND a.date <= '".$ldate."' AND a.status='1'");

            $paym = $this->Common_Model->db_query("SELECT SUM(cramount) as totpayment FROM entry_items as a LEFT JOIN entries as d on a.entry_id=d.entry_id WHERE d.entry_dt>='".$fdate."' AND d.entry_dt<='".$ldate."' AND d.entry_type='Payment' AND a.ledger_head='1'");

            $sales[] = ($saleac[0]['totcredit']?$saleac[0]['totcredit']:0);
            $purchase[] = ($purchaseac[0]['totdebit']?$purchaseac[0]['totdebit']:0);
            $expense[] = ($exp[0]['totexp']?$exp[0]['totexp']:0);
            $payment[] = ($paym[0]['totpayment']?$paym[0]['totpayment']:0);
            $monthNames[] = $monthName;
        } 

    $curdate = date('Y-m-d'); 
    $cfdate = date("Y-m-01",strtotime($curdate));
    $cldate = date("Y-m-t",strtotime($curdate));

    	$data['msale'] = $this->Common_Model->db_query("SELECT SUM(item_amount) as totcredit FROM invoice_items as a LEFT JOIN invoices as d on a.invoice_id=d.invoice_id LEFT JOIN ledgers as b on d.invoice_name=b.ledger_id WHERE d.invoice_status='Submitted' AND d.invoice_date >= '".$cfdate."' AND d.invoice_date <= '".$cldate."'");

      $data['mpurchase'] = $this->Common_Model->db_query("SELECT SUM(item_amount) as totdebit FROM purchase_items as a LEFT JOIN purchase as d on a.purchase_id=d.purchase_id LEFT JOIN ledgers as b on d.purchase_from=b.ledger_id WHERE d.purchase_date >= '".$cfdate."' AND d.purchase_date <= '".$cldate."'");

      $data['mexpense'] = $this->Common_Model->db_query("SELECT SUM(totalex_amount) as totexp FROM  expenses as a  WHERE a.date >= '".$cfdate."' AND a.date <= '".$cldate."' AND a.status='1'");

      $data['mpayment'] = $this->Common_Model->db_query("SELECT SUM(cramount) as totpayment FROM entry_items as a LEFT JOIN entries as d on a.entry_id=d.entry_id WHERE d.entry_dt>='".$cfdate."' AND d.entry_dt<='".$cldate."' AND d.entry_type='Payment' AND a.ledger_head='1'");


   
        
    $data['months'] = $monthNames;
    $data['sales'] = $sales;
    $data['purchases'] = $purchase;
    $data['expense'] = $expense;
    $data['payments'] = $payment;
         
       
		$data['classes'] = '';
		$data['activemenu'] = 'dashboard';
		$data['activesubmenu'] = 'dashboard';
		$this->load->view('dashboard', $data);
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
	
	
    function getStudentListBySessionClass444(){
		//print_r($this->input->post("class_id"));exit;
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$res = $this->Common_Model->FetchData("exam_term","*","active_exam_term = 'Active'");
		$session = $this->session->userdata('session_id');

		$records = $this->Common_Model->FetchData("student_admission AS sa LEFT JOIN students AS s ON sa.student_id = s.student_id LEFT JOIN exam_result_items as b ON sa.student_id = b.student_id LEFT JOIN exam_results as c ON b.exam_result_id = c.exam_result_id", "*", "sa.class_id = ".$this->input->post("class_id")." AND sa.session_id = ".$session." AND s.student_section = ".$this->input->post("section_id")." AND sa.admission_status = 'Active' AND c.subject_id ='".$this->input->post("subject_id")."' AND c.term ='".$res[0]['exam_term']."' AND c.create_by='".$this->session->userdata("employee_tagged_id")."' ORDER BY s.student_first_name ASC");
		//print_r($records);exit;
		if ($res[0]['exam_term'] == 'Term-1 (100 marks)') {
			$html = '<div style="overflow-x:auto;"><table class="table table-condensed table-bordered text-center" width="100%"><tr>
					
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
			$html = '<div style="overflow-x:auto;"><table class="table table-condensed table-bordered text-center" width="100%"><tr>
					
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
		$res = $this->Common_Model->FetchData("exam_term","*","active_exam_term = 'Active'");
		$session = $this->session->userdata('session_id');

		$records = $this->Common_Model->FetchData("student_admission AS sa LEFT JOIN students AS s ON sa.student_id = s.student_id LEFT JOIN exam_result_items as b ON sa.student_id = b.student_id LEFT JOIN exam_results as c ON b.exam_result_id = c.exam_result_id", "*", "sa.class_id = ".$this->input->post("class_id")." AND sa.session_id = ".$session." AND s.student_section = ".$this->input->post("section_id")." AND sa.admission_status = 'Active' AND c.subject_id ='".$this->input->post("subject_id")."' AND c.term ='".$res[0]['exam_term']."' AND c.create_by='".$this->session->userdata("employee_tagged_id")."' ORDER BY s.student_first_name ASC");
		//print_r($records);exit;
		if ($res[0]['exam_term'] == 'Term-1 (100 marks)') {
			$html = '<div style="overflow-x:auto;"><table class="table table-condensed table-bordered text-center" width="100%"><tr>
					
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
			$html = '<div style="overflow-x:auto;"><table class="table table-condensed table-bordered text-center" width="100%"><tr>
					
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
		$res = $this->Common_Model->FetchData("exam_term","*","active_exam_term = 'Active'");
		$session = $this->session->userdata('session_id');

		$records = $this->Common_Model->FetchData("student_admission AS sa LEFT JOIN students AS s ON sa.student_id = s.student_id LEFT JOIN exam_result_items as b ON sa.student_id = b.student_id LEFT JOIN exam_results as c ON b.exam_result_id = c.exam_result_id", "*", "sa.class_id = ".$this->input->post("class_id")." AND sa.session_id = ".$session." AND s.student_section = ".$this->input->post("section_id")." AND sa.admission_status = 'Active' AND c.subject_id ='".$this->input->post("subject_id")."' AND c.term ='".$res[0]['exam_term']."' AND c.create_by='".$this->session->userdata("employee_tagged_id")."'  ORDER BY s.student_first_name ASC");
		
		if ($res[0]['exam_term'] == 'Term-1 (100 marks)') {
			$html = '<div style="overflow-x:auto;"><table class="table table-condensed table-bordered text-center" width="100%"><tr>
					
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
		$html = '<div style="overflow-x:auto;"><table class="table table-condensed table-bordered text-center" width="100%"><tr>
					
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
	function online_exam(){
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$data['pagetitle'] = 'Dashboard';
		$data['currentmenu'] = 'dashboard';
		$data['currentsubmenu'] = 'dashboard';
		$data['totalstudent'] = $this->Common_Model->FetchRows("students", "*", "1");
		$data['totalexams'] = $this->Common_Model->FetchRows("exams", "*", "1");
		$data['students'] = $this->Common_Model->db_query("SELECT COUNT(s.student_id) AS studentnos, c.class_name FROM classes AS c LEFT JOIN students AS s ON c.class_id = s.student_class WHERE 1 GROUP BY c.class_id");
		$this->db->close();
		$this->load->view('online-exam-views/dashboard', $data);
	}
}
