<?php
defined('BASEPATH') OR exit('No direct script access allowed');
error_reporting(0);
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST GET PUT DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
date_default_timezone_set('Asia/Calcutta'); 
define('ROOT_URL',$_SERVER['DOCUMENT_ROOT']);
define("PROJECT_NAME","Security");
define("PAGE_TITLE","Welcome to KR Developer");
define("PROTOCOL",'https://');
define("HOST",$_SERVER['HTTP_HOST']);
define('PROJECT_URL','https://ladderbricks.com/erp');

class Api_request extends CI_Controller{
	public function __construct(){
		parent::__construct();
		$this->perPage = 10;
		//is_logged_in();
		date_default_timezone_set('Asia/Kolkata');
	}

	public function index(){
		$data = (!empty($_REQUEST))?$_REQUEST:json_decode(file_get_contents("php://input"));
		$method = (!empty($_REQUEST['method']))?$_REQUEST['method']:$data->method;

		switch ($method) { 
			case 'login':{
				if(!empty($_REQUEST['username']) && !empty($_REQUEST['password'])){
					$username = strip_tags(stripslashes($_REQUEST['username']));
					$password = $_REQUEST['password'];
					
					//$userdata = $this->Common_Model->FetchData("users", "*", "username = '".$username."' AND password = '".$password."' AND userstatus='1'");
					$userdata = $this->Common_Model->FetchData("employees", "*", "(emp_mobile = '".$username."' OR employee_email = '".$username."' OR techno_emp_id = '".$username."') AND view_psw = '".$password."' AND (emp_status = 'Active' OR emp_status = 'Leave')");
					
					
					if(!empty($userdata)){

						$sessions = $this->Common_Model->FetchData("sessions", "*", "active_session = 'Active'");
						//$resultArr['status'] 	= 200;
						$resultArr['resultSet'] = array();
						foreach ($userdata as $key => $value) {
							
										$dataArr = array('user_id' => $value['user_id'], 'firstname' => $value['emp_firstname'],'middlename' => $value['emp_middlename'], 'lastname' => $value['emp_lastname'], 'useremail' => $value['employee_email'], 'userphone'=> $value['emp_mobile'], 'usertype'=> 'Others',
										'location'=> $value['location'], 'userstatus'=> 1,'status'=> $value['emp_status'], 'employee_tagged_id'=> $value['employee_id'],'profile_pic'=> $value['emp_photo']?'https://localhost/KRdeveloper/erp/uploads/employee/'.$value['emp_photo']:'','profile_pdf' => 'https://localhost/KRdeveloper/erp/profile/viewprofile?employee_id='.$value['employee_id']);
							
							array_push($resultArr['resultSet'], $dataArr);
							//print_r($resultArr['resultSet']);exit;
						}
						$this->output
						        ->set_status_header(200)
						        ->set_content_type('application/json', 'utf-8')
						        ->set_output(json_encode($resultArr, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
						        ->_display();
						exit;
					}else{
						$response = array('msg' => 'Username OR Password is not correct, please try again !!');
						$this->output
						        ->set_status_header(200)
						        ->set_content_type('application/json', 'utf-8')
						        ->set_output(json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
						        ->_display();
						exit;
					}

				}else{
					$response = array('msg' => 'Sorry No record Found!!!');
						$this->output
						        ->set_status_header(200)
						        ->set_content_type('application/json', 'utf-8')
						        ->set_output(json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
						        ->_display();
						exit;
				}
			}break;


			case "clockin":{	
                $resultArr  = array();	
				    $datalist = array(
    					'status'	      => 1,
    					'user_id'    		=> $_REQUEST['user_id'],
    					'log_date'    	=> date('Y-m-d'),
                        'log_datetime'	=> date('Y-m-d H:i:s'), 
                        'log_lat'				=> $_REQUEST['log_lat'], 
                        'log_long'			=> $_REQUEST['log_long'], 
                        'log_loc'			=> $_REQUEST['log_loc'] 
            				);
				$records = $this->Common_Model->FetchData("user_attendance_log","*","status='1' AND log_date='".date('Y-m-d')."' AND user_id=".$_REQUEST['user_id']."");
				if ($records) {
					$response = array('msg' => 'Already Clocked in !!');
	                $this->output
							        ->set_status_header(200)
							        ->set_content_type('application/json', 'utf-8')
							        ->set_output(json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
							        ->_display();
							exit;
				}else{
					if(!empty($_REQUEST['user_img'])){
					   $base64_string = $_REQUEST['user_img'];
                        if (preg_match('/^data:image\/(\w+);base64,/', $base64_string, $type)) {
                                $base64_string = substr($base64_string, strpos($base64_string, ',') + 1);
                                $type = strtolower($type[1]); // jpg, png, gif
                            
                                if (!in_array($type, ['jpg', 'jpeg', 'png', 'gif'])) {
                                    die('Invalid image type.');
                                }
                                $base64_string = base64_decode($base64_string);
                            
                                if ($base64_string === false) {
                                    die('Base64 decode failed.');
                                }
                            }else{
                                die('Did not match data URI with image data.');
                            }

                        $attachment = 'CI_'.date('YmdHis').uniqid().'.png';
                        $file_path = 'uploads/attendancefile/'.$attachment;
                        
                        if (file_put_contents($file_path, $base64_string)) {
                                $attachment_final = $attachment;
                        } else {
                                $attachment_final ='';
                        }
                    }else{
				    	$attachment_final = "";
				    }
					$datalist['user_img'] = $attachment_final;
				$attendance_log_id = $this->Common_Model->dbinsertid("user_attendance_log",$datalist);
				}
              if(!empty($attendance_log_id)){
                $response = array('status' =>'200','msg' => 'Inserted !!');
                $this->output
						        ->set_status_header(200)
						        ->set_content_type('application/json', 'utf-8')
						        ->set_output(json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
						        ->_display();
						exit;
              }else{
                $response = array('msg' => 'Something went wrong!!');
                $this->output
						        ->set_status_header(200)
						        ->set_content_type('application/json', 'utf-8')
						        ->set_output(json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
						        ->_display();
						exit;
              }				
			}break;	

			case "clockout":{	
              $resultArr  = array();	
				$datalist = array(
					'status'	      => 2,
					'user_id'    		=> $_REQUEST['user_id'],
					'log_date'    	=> date('Y-m-d'),
                    'log_datetime'	=> date('Y-m-d H:i:s'),
                    'log_lat'				=> $_REQUEST['log_lat'], 
                    'log_long'			=> $_REQUEST['log_long'],
                    'log_loc'			=> $_REQUEST['log_loc']  
			    	);
				$records = $this->Common_Model->FetchData("user_attendance_log","*","status='2' AND log_date='".date('Y-m-d')."' AND user_id=".$_REQUEST['user_id']."");
				if ($records) {
					$records = $this->Common_Model->update_records("user_attendance_log","attendance_log_id",$records[0]['attendance_log_id'],$datalist);
					$response = array('msg' => 'Clockout Updated !!');
	                $this->output
							        ->set_status_header(200)
							        ->set_content_type('application/json', 'utf-8')
							        ->set_output(json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
							        ->_display();
							exit;
				}else{
				    if(!empty($_REQUEST['user_img'])){
					   $base64_string = $_REQUEST['user_img'];
                        if (preg_match('/^data:image\/(\w+);base64,/', $base64_string, $type)) {
                                $base64_string = substr($base64_string, strpos($base64_string, ',') + 1);
                                $type = strtolower($type[1]); // jpg, png, gif
                            
                                if (!in_array($type, ['jpg', 'jpeg', 'png', 'gif'])) {
                                    die('Invalid image type.');
                                }
                                $base64_string = base64_decode($base64_string);
                            
                                if ($base64_string === false) {
                                    die('Base64 decode failed.');
                                }
                            }else{
                                die('Did not match data URI with image data.');
                            }

                        $attachment = 'CO_'.date('YmdHis').uniqid().'.png';
                        $file_path = 'uploads/attendancefile/'.$attachment;
                        
                        if (file_put_contents($file_path, $base64_string)) {
                                $attachment_final = $attachment;
                        } else {
                                $attachment_final ='';
                        }       
				    }else{
				    	$attachment_final = "";
				    }
					$datalist['user_img'] = $attachment_final;
				$attendance_log_id = $this->Common_Model->dbinsertid("user_attendance_log",$datalist);
				}
              if(!empty($attendance_log_id)){
                $response = array('status' =>'200','msg' => 'Inserted !!');
                $this->output
						        ->set_status_header(200)
						        ->set_content_type('application/json', 'utf-8')
						        ->set_output(json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
						        ->_display();
						exit;
              }else{
                $response = array('msg' => 'Something went wrong!!');
                $this->output
						        ->set_status_header(200)
						        ->set_content_type('application/json', 'utf-8')
						        ->set_output(json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
						        ->_display();
						exit;
              }				
			}break;

			case 'clockinStatus':{
				if(!empty($_REQUEST['user_id'])){
					//$todaydate = date('Y-m-d H:i:s');
					$user_id = $_REQUEST['user_id'];
					$log_date = $_REQUEST['log_date'];

					$records = $this->Common_Model->FetchData("user_attendance_log","*","log_date='".$log_date."' AND user_id=".$user_id."");
					if(!empty($records)){
						
						$resultArr['status'] 	= 200;
						$resultArr['resultSet'] = array();
						foreach ($records as $key => $value) {
							# code...
							$dataArr = array('user_id' => $value['user_id'], 'status' => $value['status'], 'log_date' => $log_date,'log_datetime' => $value['log_datetime'],'log_lat' => $value['log_lat'],'log_long' => $value['log_long'],'log_loc' => $value['log_loc']);
							array_push($resultArr['resultSet'], $dataArr);
							//print_r($resultArr['resultSet']);exit;
						}
						$this->output
						        ->set_status_header(200)
						        ->set_content_type('application/json', 'utf-8')
						        ->set_output(json_encode($resultArr, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
						        ->_display();
						exit;
					}else{
					$response = array('msg' => 'Sorry No record Found!!!');
						$this->output
						        ->set_status_header(200)
						        ->set_content_type('application/json', 'utf-8')
						        ->set_output(json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
						        ->_display();
						exit;
					}
				}else{
					$response = array('msg' => 'Sorry No record Found!!!');
						$this->output
						        ->set_status_header(200)
						        ->set_content_type('application/json', 'utf-8')
						        ->set_output(json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
						        ->_display();
						exit;
					}
			}break;

			case 'clockinStatusByMonth':{
				if(!empty($_REQUEST['user_id']) && !empty($_REQUEST['month']) && !empty($_REQUEST['year'])){
				
					$user_id = $_REQUEST['user_id'];
					$month = $_REQUEST['month'];
					$year = $_REQUEST['year'];

					$ndate = '01-'.$month.'-'.$year;
					$fdate = date('Y-m-01',strtotime($ndate));
					$ldate = date('Y-m-t',strtotime($ndate));
					
					$dates = $this->Common_Model->getBetweenDates($fdate,$ldate);

					if(!empty($dates)){
						
						$resultArr['status'] 	= 200;
						$resultArr['resultSet'] = array();
						foreach ($dates as $ke => $val) {
							$rec1 = $this->Common_Model->FetchData("user_attendance_log","*","log_date='".$val."' AND user_id=".$user_id." AND status='1'");

							$rec2 = $this->Common_Model->FetchData("user_attendance_log","*","log_date='".$val."' AND user_id=".$user_id." AND status='2'");
							

							if (!empty($rec1)) {

								if (!empty($rec1) && !empty($rec2)) {
									$status='Present';
								}else{
									$status='Absent';
								}

								if (!empty($rec2)) {
									$clockouttime = $rec2[0]['log_datetime'];
									$clockout_lat = $rec2[0]['log_lat'];
									$clockout_long = $rec2[0]['log_long'];
									$clockout_loc = $rec2[0]['log_loc'];
								}else{
									$clockouttime = 0;
									$clockout_lat = '';
									$clockout_long = '';
									$clockout_loc = '';
								}


								
								$dataArr = array('user_id' => $user_id, 'status' => $status, 'log_date' => $val,'clock_in_time' => $rec1[0]['log_datetime'],'clock_out_time' => $clockouttime,'clockin_lat' => $rec1[0]['log_lat'],'clockin_long' => $rec1[0]['log_long'],'clockin_loc' => $rec1[0]['log_loc'],'clockout_lat' => $clockout_lat,'clockout_long' => $clockout_long,'clockout_loc' => $clockout_loc);
									array_push($resultArr['resultSet'], $dataArr);
								
							}else{
								$dataArr =array();
							}
							
							
						}
						$this->output
						        ->set_status_header(200)
						        ->set_content_type('application/json', 'utf-8')
						        ->set_output(json_encode($resultArr, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
						        ->_display();
						exit;
					}else{
					$response = array('msg' => 'Sorry No record Found!!!');
						$this->output
						        ->set_status_header(200)
						        ->set_content_type('application/json', 'utf-8')
						        ->set_output(json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
						        ->_display();
						exit;
					}
				}else{
					$response = array('msg' => 'Sorry No record Found!!!');
						$this->output
						        ->set_status_header(200)
						        ->set_content_type('application/json', 'utf-8')
						        ->set_output(json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
						        ->_display();
						exit;
					}
			}break;
            
         case 'getSalSlip':{
				if(!empty($_REQUEST['user_id'])){
					$user_id = $_REQUEST['user_id'];
					
					$employee = $this->Common_Model->db_query("SELECT employee_id,user_id FROM employees WHERE user_id=".$user_id."");

					if(empty($employee)){
							$response = array('msg' => 'Sorry No record Found!!!');
							$this->output
							        ->set_status_header(200)
							        ->set_content_type('application/json', 'utf-8')
							        ->set_output(json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
							        ->_display();
							exit;
					}

					$records = $this->Common_Model->FetchData("salary_transaction_attribute as a","*","a.employee_id=".$employee[0]['employee_id']." ORDER BY attr_id DESC LIMIT 10");
					if(!empty($records)){
						
						$resultArr['status'] 	= 200;
						$resultArr['resultSet'] = array();
						foreach ($records as $key => $value) {
							# code...
							$dataArr = array('month' => $value['month'], 'year' => $value['year'], 'ispaid' => 'Yes','printsliplink' => site_url("salslip/salaryslip?attr_id=".$value['attr_id']."&employee_id=".$employee[0]['employee_id']."&month=".$value['month']."&year=".$value['year']));
							array_push($resultArr['resultSet'], $dataArr);
						}
						$this->output
						        ->set_status_header(200)
						        ->set_content_type('application/json', 'utf-8')
						        ->set_output(json_encode($resultArr, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
						        ->_display();
						exit;
					}else{
					$response = array('msg' => 'Sorry No record Found!!!');
						$this->output
						        ->set_status_header(200)
						        ->set_content_type('application/json', 'utf-8')
						        ->set_output(json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
						        ->_display();
						exit;
					}
				}else{
					$response = array('msg' => 'Sorry No record Found!!!');
						$this->output
						        ->set_status_header(200)
						        ->set_content_type('application/json', 'utf-8')
						        ->set_output(json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
						        ->_display();
						exit;
					}
			}break;
			
			case 'getLedgers':{
				
					$records = $this->Common_Model->db_query("SELECT ledger_id,ledger_name FROM ledgers WHERE ledger_alias !='' AND acount_group=50 OR ledger_alias !='' AND acount_group=51 ORDER BY ledger_name ASC");
					if(!empty($records)){
						
						$resultArr['status'] 	= 200;
						$resultArr['resultSet'] = array();
						foreach ($records as $key => $value) {
							# code...
							$dataArr = array('ledger_id' => $value['ledger_id'], 'ledger_name' => $value['ledger_name']);
							array_push($resultArr['resultSet'], $dataArr);
							//print_r($resultArr['resultSet']);exit;
						}
						$this->output
						        ->set_status_header(200)
						        ->set_content_type('application/json', 'utf-8')
						        ->set_output(json_encode($resultArr, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
						        ->_display();
						exit;
					}else{
					$response = array('msg' => 'Sorry No record Found!!!');
						$this->output
						        ->set_status_header(200)
						        ->set_content_type('application/json', 'utf-8')
						        ->set_output(json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
						        ->_display();
						exit;
					}
				
			}break;

			case 'expensetype':{
				
					$records = $this->Common_Model->FetchData("expense_types","*","1 ORDER BY expense_name ASC");
					if(!empty($records)){
						
						$resultArr['status'] 	= 200;
						$resultArr['resultSet'] = array();
						foreach ($records as $key => $value) {
							# code...
							$dataArr = array('expensetype_id' => $value['id'], 'expensetype_name' => $value['expense_name'],'expense_icon'=> $value['expense_icon']?'https://glosent.in/erp/uploads/expenseimg/'.$value['expense_icon']:'');
							array_push($resultArr['resultSet'], $dataArr);
							//print_r($resultArr['resultSet']);exit;
						}
						$this->output
						        ->set_status_header(200)
						        ->set_content_type('application/json', 'utf-8')
						        ->set_output(json_encode($resultArr, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
						        ->_display();
						exit;
					}else{
					$response = array('msg' => 'Sorry No record Found!!!');
						$this->output
						        ->set_status_header(200)
						        ->set_content_type('application/json', 'utf-8')
						        ->set_output(json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
						        ->_display();
						exit;
					}
				
			}break;

			case 'expensesubtype':{

					$id = $_REQUEST['expensetype_id'];
					$records = $this->Common_Model->FetchData("expense_subtypes","*","expense_type_id=".$id." ORDER BY expense_subtypename ASC");
					if(!empty($records)){
						
						$resultArr['status'] 	= 200;
						$resultArr['resultSet'] = array();
						foreach ($records as $key => $value) {
							# code...
							$dataArr = array('expensesubtypes_id' => $value['expense_subtypes_id'],'entry_type' => $value['entry_type'], 'expensesubtype_name' => $value['expense_subtypename'],'expensesubtype_icon'=> $value['expense_subtypeicon']?'https://glosent.in/erp/uploads/expenseimg/'.$value['expense_subtypeicon']:'');
							array_push($resultArr['resultSet'], $dataArr);
							//print_r($resultArr['resultSet']);exit;
						}
						$this->output
						        ->set_status_header(200)
						        ->set_content_type('application/json', 'utf-8')
						        ->set_output(json_encode($resultArr, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
						        ->_display();
						exit;
					}else{
					$response = array('msg' => 'Sorry No record Found!!!');
						$this->output
						        ->set_status_header(200)
						        ->set_content_type('application/json', 'utf-8')
						        ->set_output(json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
						        ->_display();
						exit;
					}
				
			}break;

			case "expenseadd" :{
				if ($_REQUEST['totalex_amount'] > 0 && !empty($_REQUEST['user_id']) && !empty($_REQUEST['expensetype_id']) && !empty($_REQUEST['expensesubtype_id']) && !empty($_REQUEST['date'])) {
					
				$resultArr  = array();	
				$exprec = $this->Common_Model->FetchData("expenses","*","1 ORDER BY expense_id DESC LIMIT 1");
					if ($exprec) {
						$rc = ($exprec[0]['exnumber'] +  1) ;
						$exnumber = $rc;
					}else {
						$exnumber = 1;
					}

				$expsubtype = $this->Common_Model->FetchData("expense_subtypes","*","expense_subtypes_id=".$_REQUEST['expensesubtype_id']);

				if ($expsubtype) {
					$rec = $this->Common_Model->FetchData("expenses","*","sub_category=".$_REQUEST['expensesubtype_id']." AND date='".$_REQUEST['date']."' AND expadded_by=".$_REQUEST["user_id"]);
					if ($rec && $expsubtype[0]['entry_type']=='1') {
						
						$response = array('msg' => 'You can not add expenses more times a day in '.$expsubtype[0]['expense_subtypename'].'!!');
                $this->output
						        ->set_status_header(200)
						        ->set_content_type('application/json', 'utf-8')
						        ->set_output(json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
						        ->_display();
						exit;
					}
				}

				$data_list = array(
					
					'category'				=> $_REQUEST['expensetype_id'],
					'sub_category'		=> $_REQUEST['expensesubtype_id'],
					'ledger_id'				=> $_REQUEST['ledger_id'],
					'exprefix'				=> 'EXP/'.date('Y').'/',
					'exnumber'				=> $exnumber,
					'paymentmode'			=> 'CASH',
					'date'						=> $_REQUEST['date'],
					'totalex_amount'	=> $_REQUEST['totalex_amount'],
					'payment_notes'		=> $_REQUEST['payment_notes'],
					'bank_id'					=> 0,
					'cheque_no'				=> '',
					'bank_name'				=> '',
					'bank_branch'			=> '',
					'expadded_on'			=> date('Y-m-d H:i:s'),
					'expadded_by'			=> $_REQUEST["user_id"],
				);

				$allowedFile         = array('png' ,'jpg','jpeg','pdf');
		    	$allowedFileMime     = array('image/jpeg','image/jpg', 'image/png', 'pdf');

					if(!empty($_FILES['expenseaattachment']['name'])){
				        $attachment = $_FILES['expenseaattachment']['name'];
				        $attachment_tmp = $_FILES['expenseaattachment']['tmp_name'];
				        if(!in_array(mime_content_type($attachment_tmp),$allowedFileMime)){ 
				            echo json_encode(array('status' => 500, 'msg' => 'Uploaded photo not a valid file, Upload (jpg,jpeg,png,pdf) files only!!'));exit;
				        }else{
				            if($_FILES['expenseaattachment']['size'] > (800*1024)) {  
				                echo json_encode(array('status' => 500, 'msg' => 'Uploaded photo size too large!!'));exit;
				            } else {     
				            	            
				                 $expld_attachment      = explode('.',$attachment);
				                 $attachment_final = 'EXP_'.date('YmdHis').uniqid().'.'.end($expld_attachment);
				                 move_uploaded_file($attachment_tmp,'uploads/expensefile/'.$attachment_final);
				            }
				        }       
				    }else{
				    	$attachment_final = "";
				    }
					$data_list['expenseaattachment'] = $attachment_final;
				
				$expense_id = $this->Common_Model->dbinsertid("expenses", $data_list);
				
           if(!empty($expense_id)){
                $response = array('status' =>'200','msg' => 'Inserted !!');
                $this->output
						        ->set_status_header(200)
						        ->set_content_type('application/json', 'utf-8')
						        ->set_output(json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
						        ->_display();
								exit;
           }else{
                $response = array('msg' => 'Something went wrong!!');
                $this->output
						        ->set_status_header(200)
						        ->set_content_type('application/json', 'utf-8')
						        ->set_output(json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
						        ->_display();
						exit;
              }
        }else{
                $response = array('msg' => 'Something went wrong!!');
                $this->output
						        ->set_status_header(200)
						        ->set_content_type('application/json', 'utf-8')
						        ->set_output(json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
						        ->_display();
						exit;
              }				
			}break;

			case "expenselist": {
				if (!empty($_REQUEST['user_id'])) {
						$records = $this->Common_Model->FetchData("expenses as a LEFT JOIN expense_types as b on a.category=b.id LEFT JOIN expense_subtypes as c on a.sub_category=c.expense_subtypes_id","*","expadded_by=".$_REQUEST['user_id']." ORDER BY expense_id ASC");
					if(!empty($records)){
						
						$resultArr['status'] 	= 200;
						$resultArr['resultSet'] = array();
						
						foreach ($records as $key => $value) {
							

							$ledger = $this->Common_Model->db_query("SELECT ledger_name FROM ledgers WHERE ledger_id=".$value['ledger_id']);
							# code...
							$dataArr = array('expense_id' => $value['expense_id'], 'expensetype_id' => $value['category'],'expensesubtype_id' => $value['sub_category'], 'date' => $value['date'],'expense_name' => $value['expense_name'],'expense_no' => $value['exprefix'].''.$value['exnumber'], 'expense_subtypename' => $value['expense_subtypename'],'totalex_amount' => $value['totalex_amount'], 'payment_notes' => $value['payment_notes'],'expenseaattachment'=> $value['expenseaattachment']?'https://glosent.in/erp/uploads/expensefile/'.$value['expenseaattachment']:'','status' => $value['status'],'ledger_id' => $value['ledger_id'],'ledger_name'=> $ledger?$ledger[0]['ledger_name']:'','query_remark' => $value['query_remark'],'query_remark_st' => $value['query_remark_st'],'query_ans' => $value['query_ans'],'query_ans_st' => $value['query_ans_st']);
							array_push($resultArr['resultSet'], $dataArr);
							//print_r($resultArr['resultSet']);exit;
						}
						$this->output
						        ->set_status_header(200)
						        ->set_content_type('application/json', 'utf-8')
						        ->set_output(json_encode($resultArr, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
						        ->_display();
						exit;
					}else{
					$response = array('msg' => 'Sorry No record Found!!!');
						$this->output
						        ->set_status_header(200)
						        ->set_content_type('application/json', 'utf-8')
						        ->set_output(json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
						        ->_display();
						exit;
					}
				}else{
                $response = array('msg' => 'Something went wrong!!');
                $this->output
						        ->set_status_header(200)
						        ->set_content_type('application/json', 'utf-8')
						        ->set_output(json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
						        ->_display();
						exit;
              }	

			}break;

			case "expenseById": {
					if (!empty($_REQUEST['expense_id'])) {
						$records = $this->Common_Model->FetchData("expenses as a LEFT JOIN expense_types as b on a.category=b.id LEFT JOIN expense_subtypes as c on a.sub_category=c.expense_subtypes_id","*","expense_id=".$_REQUEST['expense_id']."");
					if(!empty($records)){
						
						$resultArr['status'] 	= 200;
						$resultArr['resultSet'] = array();
						
						foreach ($records as $key => $value) {
							

							$ledger = $this->Common_Model->db_query("SELECT ledger_name FROM ledgers WHERE ledger_id=".$value['ledger_id']);
							# code...
							$dataArr = array('expense_id' => $value['expense_id'], 'date' => $value['date'],'expense_name' => $value['expense_name'],'expense_no' => $value['exprefix'].''.$value['exnumber'], 'expense_subtypename' => $value['expense_subtypename'],'totalex_amount' => $value['totalex_amount'], 'payment_notes' => $value['payment_notes'],'expenseaattachment'=> $value['expenseaattachment']?'https://glosent.in/erp/uploads/expensefile/'.$value['expenseaattachment']:'','status' => $value['status'],'ledger_id' => $value['ledger_id'],'ledger_name'=> $ledger?$ledger[0]['ledger_name']:'','query_remark' => $value['query_remark'],'query_remark_st' => $value['query_remark_st'],'query_ans' => $value['query_ans'],'query_ans_st' => $value['query_ans_st']);
							array_push($resultArr['resultSet'], $dataArr);
							//print_r($resultArr['resultSet']);exit;
						}
						$this->output
						        ->set_status_header(200)
						        ->set_content_type('application/json', 'utf-8')
						        ->set_output(json_encode($resultArr, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
						        ->_display();
						exit;
					}else{
					$response = array('msg' => 'Sorry No record Found!!!');
						$this->output
						        ->set_status_header(200)
						        ->set_content_type('application/json', 'utf-8')
						        ->set_output(json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
						        ->_display();
						exit;
					}
				}else{
                $response = array('msg' => 'Something went wrong!!');
                $this->output
						        ->set_status_header(200)
						        ->set_content_type('application/json', 'utf-8')
						        ->set_output(json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
						        ->_display();
						exit;
              }
			}break;

			case "expenseedit" :{
				if ($_REQUEST['totalex_amount'] > 0  && !empty($_REQUEST['expensetype_id']) && !empty($_REQUEST['expensesubtype_id']) && !empty($_REQUEST['date']) && !empty($_REQUEST['expense_id'])) {
					
				$resultArr  = array();	
				

				$data_list = array(
					
					'category'				=> $_REQUEST['expensetype_id'],
					'sub_category'		=> $_REQUEST['expensesubtype_id'],
					'ledger_id'				=> $_REQUEST['ledger_id'],
					'date'						=> $_REQUEST['date'],
					'totalex_amount'	=> $_REQUEST['totalex_amount'],
					'payment_notes'		=> $_REQUEST['payment_notes'],
					'bank_id'					=> 0,
					'cheque_no'				=> '',
					'bank_name'				=> '',
					'bank_branch'			=> '',
				);

				$allowedFile         = array('png' ,'jpg','jpeg','pdf');
		    	$allowedFileMime     = array('image/jpeg','image/jpg', 'image/png', 'pdf');

					if(!empty($_FILES['expenseaattachment']['name'])){
				        $attachment = $_FILES['expenseaattachment']['name'];
				        $attachment_tmp = $_FILES['expenseaattachment']['tmp_name'];
				        if(!in_array(mime_content_type($attachment_tmp),$allowedFileMime)){ 
				            echo json_encode(array('status' => 500, 'msg' => 'Uploaded photo not a valid file, Upload (jpg,jpeg,png,pdf) files only!!'));exit;
				        }else{
				            if($_FILES['expenseaattachment']['size'] > (800*1024)) {  
				                echo json_encode(array('status' => 500, 'msg' => 'Uploaded photo size too large!!'));exit;
				            } else {     
				            	            
				                 $expld_attachment      = explode('.',$attachment);
				                 $attachment_final = 'EXP_'.date('YmdHis').uniqid().'.'.end($expld_attachment);
				                 move_uploaded_file($attachment_tmp,'uploads/expensefile/'.$attachment_final);
				                 $data_list['expenseaattachment'] = $attachment_final;
				            }
				        }       
				    }else{
				    	
				    }
					
				
				 	$this->Common_Model->update_records("expenses","expense_id",$_REQUEST['expense_id'], $data_list);
				
           
                $response = array('status' =>'200','msg' => 'Updated !!');
                $this->output
						        ->set_status_header(200)
						        ->set_content_type('application/json', 'utf-8')
						        ->set_output(json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
						        ->_display();
								exit;
           
        }else{
                $response = array('msg' => 'Something went wrong!!');
                $this->output
						        ->set_status_header(200)
						        ->set_content_type('application/json', 'utf-8')
						        ->set_output(json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
						        ->_display();
						exit;
              }				
			}break;
			
			case "chktotexpBycat" :{
				if (!empty($_REQUEST['date']) && !empty($_REQUEST['subcategory']) && $_REQUEST['totalex_amount'] > 0 && !empty($_REQUEST['user_id'])) {

						$date = $_REQUEST['date'];
						$subcategory = $_REQUEST['subcategory'];
						$totalex_amount = $_REQUEST['totalex_amount'];
						$user_id = $_REQUEST['user_id'];

							$employee = $this->Common_Model->db_query("SELECT designation_id FROM employees WHERE user_id=".$user_id."");
							$subcat = $this->Common_Model->db_query("SELECT expense_subtypename FROM expense_subtypes WHERE expense_subtypes_id=".$subcategory."");

						if ($employee) {
							
							$limitrec = $this->Common_Model->db_query("SELECT limitamt FROM expense_limitation WHERE expense_subtypes_id=".$subcategory." AND designation =".$employee[0]['designation_id']."");
							if ($limitrec) {
								$limitamt = $limitrec[0]['limitamt'];
							}else{
								$limitamt = 0;
							}

							$records = $this->Common_Model->db_query("SELECT SUM(totalex_amount) as totexp FROM expenses WHERE expadded_by ='".$user_id."' AND date='".$date."' AND sub_category=".$subcategory." AND status != 2");
							$restamt = $limitamt - $records[0]['totexp'];
							if ($totalex_amount > $restamt) {
								$restamount = $restamt;
								$status .= 'F';
								$msg .= 'You have ₹ '.$restamt.' left for '.$subcat[0]["expense_subtypename"].' Category.';
							}else{
								$restamount = $restamt;
								$status .= 'T';
								$msg .= 'You have ₹ '.$restamt.' left for '.$subcat[0]["expense_subtypename"].' Category.';
							}
						}else{
							$restamount = '0';
							$status .= 'F';
							$msg .= 'Employee data not found!!';
								
						}

						$resultArr['status'] 	= 200;
						$resultArr['resultSet'] = array();
						
							$dataArr = array('restamount' => $restamount, 'status' => $status,'msg' => $msg);
							array_push($resultArr['resultSet'], $dataArr);
							//print_r($resultArr['resultSet']);exit;
						
						$this->output
						        ->set_status_header(200)
						        ->set_content_type('application/json', 'utf-8')
						        ->set_output(json_encode($resultArr, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
						        ->_display();
						exit;

					}else{
						$response = array('msg' => 'Something went wrong!!');
                $this->output
						        ->set_status_header(200)
						        ->set_content_type('application/json', 'utf-8')
						        ->set_output(json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
						        ->_display();
						exit;
					}
			}break;

			case "chkExpCnt" : {
									if (!empty($_REQUEST['date']) && !empty($_REQUEST['subcategory']) && !empty($_REQUEST['user_id'])) {

						$date = $_REQUEST['date'];
						$subcategory = $_REQUEST['subcategory'];
						$user_id = $_REQUEST['user_id'];

						$expsubtype = $this->Common_Model->FetchData("expense_subtypes","*","expense_subtypes_id=".$subcategory);

						$resultArr['status'] 	= 200;
						$resultArr['resultSet'] = array();

						if ($expsubtype) {
								$rec = $this->Common_Model->FetchData("expenses","*","sub_category=".$subcategory." AND date='".$date."' AND expadded_by=".$user_id." AND status != 2");
								if ($rec && $expsubtype[0]['entry_type']=='1') {

										$dataArr = array('status' => 'F', 'msg' => 'You can not add expenses more times a day in '.$expsubtype[0]['expense_subtypename'].'!!');
										array_push($resultArr['resultSet'], $dataArr);
										//print_r($resultArr['resultSet']);exit;
									
									$this->output
									        ->set_status_header(200)
									        ->set_content_type('application/json', 'utf-8')
									        ->set_output(json_encode($resultArr, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
									        ->_display();
									exit;

								}else{
									$dataArr = array('status' => 'T', 'msg' => 'You can add expenses in '.$expsubtype[0]['expense_subtypename'].'!!');
										array_push($resultArr['resultSet'], $dataArr);
										//print_r($resultArr['resultSet']);exit;
									
									$this->output
									        ->set_status_header(200)
									        ->set_content_type('application/json', 'utf-8')
									        ->set_output(json_encode($resultArr, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
									        ->_display();
									exit;
								}
				
						}else{
									$response = array('status' => 'F','msg' => 'Something went wrong!!');
		                $this->output
								        ->set_status_header(200)
								        ->set_content_type('application/json', 'utf-8')
								        ->set_output(json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
								        ->_display();
								exit;
								
						}	

					}else{
						$response = array('status' => 'F','msg' => 'Something went wrong!!');
                $this->output
						        ->set_status_header(200)
						        ->set_content_type('application/json', 'utf-8')
						        ->set_output(json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
						        ->_display();
						exit;
					}
			}break;
			
			case "replyaboutquery":{	
              $resultArr  = array();
              $expense_id = $_REQUEST['expense_id'];
							$datalist = array(
								'query_ans'    		=> $_REQUEST['query_ans'],
								'query_remark_st' => 0,
								'query_ans_st'    => 1,
							);
				$records = $this->Common_Model->FetchData("expenses","*","expense_id=".$expense_id."");
				if ($records) {
						$rec = $this->Common_Model->update_records("expenses","expense_id",$expense_id,$datalist);
						$response = array('msg' => 'Updated Successfully.');
	                $this->output
							        ->set_status_header(200)
							        ->set_content_type('application/json', 'utf-8')
							        ->set_output(json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
							        ->_display();
							exit;
					}else{
                $response = array('msg' => 'Something went wrong!!');
                $this->output
						        ->set_status_header(400)
						        ->set_content_type('application/json', 'utf-8')
						        ->set_output(json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
						        ->_display();
						exit;
              }				
			}break;
			
			case "chkEmpStatus" : {
					if (!empty($_REQUEST['user_id'])) {

						$user_id = $_REQUEST['user_id'];

						$employee = $this->Common_Model->db_query("SELECT emp_status,user_id FROM employees WHERE user_id=".$user_id);

						$resultArr['status'] 	= 200;
						$resultArr['resultSet'] = array();

						if ($employee) {
								
										$dataArr = array('user_id'=> $employee[0]['user_id'], 'status' => $employee[0]['emp_status']);
										array_push($resultArr['resultSet'], $dataArr);
										//print_r($resultArr['resultSet']);exit;
									
									$this->output
									        ->set_status_header(200)
									        ->set_content_type('application/json', 'utf-8')
									        ->set_output(json_encode($resultArr, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
									        ->_display();
									exit;

								
				
						}else{
									$response = array('msg' => 'Something went wrong!!');
		                $this->output
								        ->set_status_header(200)
								        ->set_content_type('application/json', 'utf-8')
								        ->set_output(json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
								        ->_display();
								exit;
								
						}	

					}else{
						$response = array('msg' => 'Something went wrong!!');
                $this->output
						        ->set_status_header(200)
						        ->set_content_type('application/json', 'utf-8')
						        ->set_output(json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
						        ->_display();
						exit;
					}
			}break;
			
		   case "Dashboard" : {
		   		$data = array();
		   		$id = $_REQUEST['user_id'];
		   		$data['missed'] = $this->Common_Model->countRows("lead_enquiry" ,
		   			"assigned_to=".$id . " AND enquiry_status = 'missed'");
		   		$data['sales'] = $this->Common_Model->countRows("lead_enquiry" ,
		   			"assigned_to=".$id . " AND enquiry_status = 'sales'");
		   		$data['interested'] = $this->Common_Model->countRows("lead_enquiry" ,
		   			"assigned_to=".$id . " AND enquiry_status = 'interested'");
		   		$data['callback'] = $this->Common_Model->countRows("lead_enquiry" ,
		   			"assigned_to=".$id . " AND enquiry_status = 'callback'");
		   		$data['opportunity'] = $this->Common_Model->countRows("lead_enquiry" ,
		   			"assigned_to=".$id . " AND enquiry_status = 'opportunity'");
		   		$data['no_of_contacts'] = $this->Common_Model->countRows("lead_enquiry" ,
		   			"assigned_to=".$id);
		   		echo json_encode($data);

 		   }break;
 		   case "listOfLeads" : {
 		   	$data = array();
 		   	$id = $_REQUEST['user_id'];
 		   	$data['List_of_Leads'] = $this->Common_Model->FetchData("lead_enquiry","*","assigned_to=".$id);
 		   	echo json_encode($data);
 		   }break;

 		   case "lastClockData" : {
 		   	$data = array();
 		   	$id = $_REQUEST['user_id'];
 		   	$data['last_clock_record'] = $this->Common_Model->FetchData("user_attendance_log","*", "user_id=".$id." ORDER BY attendance_log_id DESC LIMIT 1");
 		   	echo json_encode($data);
 		   }break;

 		   case "call_Logs_View":
              $data = array();
               $id = isset($_REQUEST['user_id']) ? $_REQUEST['user_id'] : 0;

               if ($id > 0) {
                 $call_logs = $this->Common_Model->FetchData(
                   "lead_activity", 
                      "*", 
                        "emp_id = $id AND enquiry_remark = 'call log'"
                );

                 if (!empty($call_logs)) {
                    foreach ($call_logs as &$log) {
                       $log['attachment_url'] = site_url('uploads/call_records/' . $log['attachment']);
                     }
                     $data['call_logs'] = $call_logs;
                   } else {
                     $data['call_logs'] = 'No call logs found';
                    }
                  } else {
                    $data['error'] = 'Invalid user_id';
                   }

                   echo json_encode($data);
                     break;


 		   

 		   case "call_logs" : {
 		   	$data_list = array(
					'emp_id'=> $_REQUEST['emp_id'],
					'enq_id'=> $_REQUEST['enq_id'],
					'enquiry_remark'=> $_REQUEST['enquiry_remark'],
					
					'enquiry_status'=> $_REQUEST['enquiry_status'],
					'dateadded'=>date('Y-m-d H:i:s')
				);

 		   	  if (!empty($_FILES['attachment']['name'])) {
                 $config['upload_path']   = 'uploads/call_records/';
                 $config['allowed_types'] = 'mp3|wav|aac|m4a|ogg';
                 $config['file_name']     = 'AUDIO_' . date("Ymd") . '_' . time();
                 $config['max_size']      = '10240';  // Max size in KB (10 MB)
    
                 // Load upload library and initialize configuration
                  $this->load->library('upload', $config);
                  $this->upload->initialize($config);
    
                     if ($this->upload->do_upload('attachment')) {
                       $uploadData = $this->upload->data();
                        $data_list['attachment'] = $uploadData['file_name'];
                      } else {
                   print_r($this->upload->display_errors());
                    $data_list['attachment'] = '';
                     }
                  } else {
                     $data_list['attachment'] = '';
                    }
              $id = $this->Common_Model->dbinsertid("lead_activity", $data_list);
              $response = array('msg' => 'Success !!'); 
              echo json_encode($response);   
 		   }break;

 		   case "contact_details" : {
 		   	$data = array();
 		   	$id = $_REQUEST['user_id'];
 		   	$data['contact_details'] = $this->Common_Model->FetchData("lead_enquiry","name,email,mobile,state,city","assigned_to=".$id);
 		   	echo json_encode($data);
 		   }break;

		}
	}
}





