<?php
defined('BASEPATH') OR exit('No direct script access allowed');
error_reporting(0);
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST GET PUT DELETE OPTIONS");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
header("Content-Type: application/json");
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
		$this->timestamp = date('Y-m-d H:i:s');
	}

	public function index(){
		$data = (!empty($_REQUEST))?$_REQUEST:json_decode(file_get_contents("php://input"));
		$method = (!empty($_REQUEST['method']))?$_REQUEST['method']:$data->method;

		switch ($method) { 
		    
			case 'login':{
				if (!empty($_REQUEST['username']) && !empty($_REQUEST['password'])) {
                    $username = trim(strip_tags(stripslashes($_REQUEST['username'])));
                    $password = md5(trim($_REQUEST['password']));
                
                					
					//$userdata = $this->Common_Model->FetchData("users", "*", "username = '".$username."' AND password = '".$password."' AND userstatus='1'");
					$userdata = $this->Common_Model->FetchData("users", "*", 
						"(userphone = '".$username."' OR useremail = '".$username."' ) AND password = '".$password."' AND userstatus = 1");
					
					
					if(!empty($userdata)){

						$sessions = $this->Common_Model->FetchData("sessions", "*", "active_session = 'Active'");
						$resultArr['status'] 	= 200;
						$resultArr['resultSet'] = $userdata[0];
						
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
                        'log_loc'			=> $_REQUEST['log_loc'],
                        'remarks' 	=> "Clock In"
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
              	$records = $this->Common_Model->FetchData("user_attendance_log","*","status='1' AND log_date='".date('Y-m-d')."' AND user_id=".$_REQUEST['user_id']."");
                $response = array('status' =>'200','msg' => 'Inserted !!','Data' => $records);
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
                    'log_loc'			=> $_REQUEST['log_loc'],
                    'remarks' 	=> "Clock Out"  
			    	);
				$records = $this->Common_Model->FetchData("user_attendance_log","*","status='2' AND log_date='".date('Y-m-d')."' AND user_id=".$_REQUEST['user_id']."");
				if ($records) {
					$records = $this->Common_Model->update_records("user_attendance_log","attendance_log_id",$records[0]['attendance_log_id'],$datalist);
					$response = array('msg' => 'Clockout Updated !!');
					//echo json_encode($records);
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
              	$records = $this->Common_Model->FetchData("user_attendance_log","*","status='2' AND log_date='".date('Y-m-d')."' AND user_id=".$_REQUEST['user_id']."");
                $response = array('status' =>'200','msg' => 'Inserted !!','Data' => $records);
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
		   			"assigned_to=".$id . " AND comp_status = 'Missed'");
		   		$data['sitevisit'] = $this->Common_Model->countRows("lead_enquiry" ,
		   			"assigned_to=".$id . " AND comp_status = 'Site Visit'");
		   	// Count total records
        $countSql = "SELECT COUNT(i.enq_id) AS num 
             FROM interest i 
             LEFT JOIN lead_enquiry le ON i.enq_id = le.enq_id 
             WHERE i.user_id = '$id' AND le.comp_status = 'Interested'";

             $records = $this->Common_Model->db_query($countSql);

		   		$data['interested'] = $records[0]['num'];
		   		$data['not_interested'] = $this->Common_Model->countRows("interest" ,
		   			"user_id=".$id . " AND remarks = 'not interested'");
		   			
		   	// Count total records
        $countSql = "SELECT COUNT(DISTINCT cb.enq_id) AS num 
             FROM callback cb 
             LEFT JOIN lead_enquiry le ON cb.enq_id = le.enq_id 
            WHERE cb.user_id = '$id' AND (le.comp_status = 'Initiated' OR le.comp_status = 'Callback')";

                    
                $records = $this->Common_Model->db_query($countSql);     
		   		$data['callback'] = $records[0]['num'];
		   		$data['opportunity'] = $this->Common_Model->countRows("lead_enquiry" ,
		   			"assigned_to=".$id . " AND comp_status = 'Opportunity'");
		   		$data['no_of_contacts'] = $this->Common_Model->countRows("lead_enquiry" ,
		   			"assigned_to=".$id. " AND (comp_status = 'Initiated' OR comp_status = 'Interested' OR comp_status = 'Opportunity' OR comp_status = 'Callback' OR comp_status = 'Follow Up')");
		   		$data['no_of_success_leads'] = $this->Common_Model->countRows("lead_enquiry" , "assigned_to=".$id . " AND comp_status = 'Success'");
		   		$data['no_of_delete_leads'] = $this->Common_Model->countRows("lead_enquiry" , "assigned_to=".$id . " AND comp_status = 'Delete'");
		   		$data['follow_ups'] = $this->Common_Model->countRows("lead_enquiry" , "assigned_to=".$id . " AND comp_status = 'Follow Up'");
		   		echo json_encode($data);

 		   }break;
 		   
 		   case "listOfContacts" : {
 		   	$data = array();
 		   	$id = $_REQUEST['user_id'];
 		   $data['List_of_Leads'] = $this->Common_Model->FetchData("lead_enquiry","*","assigned_to=".$id. " AND (comp_status = 'Initiated' OR comp_status = 'Interested' OR comp_status = 'Opportunity' OR comp_status = 'Callback' OR comp_status = 'Missed' OR comp_status = 'Site Visit' OR comp_status = 'Follow Up') ORDER BY enq_id DESC");
 		   	echo json_encode($data);
 		   }break;
 		   
 		  case "listOfLeads" : {
 		   	$data = array();
 		   	$id = $_REQUEST['user_id'];
 		   	$data['List_of_Leads'] = $this->Common_Model->FetchData("lead_enquiry as le LEFT JOIN erp_source  es ON es.id = le.source","le.*,es.source","assigned_to=".$id. " AND comp_status = 'Initiated'  AND enq_id NOT IN (SELECT enq_id FROM callback) ORDER BY enq_id DESC");
 		   	if($data['List_of_Leads']) {
 		   	$data['total_leads'] = count($data['List_of_Leads']);
 		   }
 		   	echo json_encode($data);
 		   }break;

 		   case "lastClockData" : {
 		   	$data = array();
 		   	$id = $_REQUEST['user_id'];
 		   	$data['last_clock_record'] = $this->Common_Model->FetchData("user_attendance_log","*", "user_id=".$id." ORDER BY attendance_log_id DESC LIMIT 2");
 		   	echo json_encode($data);
 		   }break;

 		   case "call_Logs_View": {
				    $data = array();
				    $id = isset($_REQUEST['user_id']) ? $_REQUEST['user_id'] : 0;
				    $enq_id = isset($_REQUEST['enq_id']) ? $_REQUEST['enq_id'] : 0;

				    if ($id > 0) {
				        $condition = "emp_id = $id AND enquiry_remark = 'call log'";

				        
				        if ($enq_id > 0) {
				            $condition .= " AND enq_id = $enq_id";
				        }

				        $call_logs = $this->Common_Model->FetchData("lead_activity", "*", " $condition ORDER BY id DESC");

				        if (!empty($call_logs)) {
				            foreach ($call_logs as &$log) {
				                $log['user_id'] = $log['emp_id'];
				            	if($log['attachment']) {
				                $log['attachment_url'] = site_url('uploads/call_records/' . $log['attachment']);
				            	}else {
				            		$log['attachment_url'] = '';
				            	}
				        	}
				            $data['call_logs'] = $call_logs;
				        } else {
				            $data['call_logs'] = 'No call logs found';
				        }
				    } else {
				        $data['error'] = 'Invalid user_id';
				    }

				    echo json_encode($data);
				    }break;



 		   

 		  case "call_logs" : {
	 		   	$enq_id = $_REQUEST['enq_id'];

			    // Get current enquiry status
			    $comp_status = $this->Common_Model->FetchData("lead_enquiry", "comp_status", "enq_id = $enq_id");
			    //$comp_status = $status[0]['comp_status'] ?? '';

	 		   	$data_list = array(
					'emp_id'=> $_REQUEST['user_id'],
					'enq_id'=> $_REQUEST['enq_id'],
					'enquiry_remark'=> $_REQUEST['enquiry_remark'],
					
					'enquiry_status'=> $_REQUEST['enquiry_status'],
					'dateadded'=>date('Y-m-d H:i:s'),
					'sim_id' => $_REQUEST['sim_id'],
					'call_type' => $_REQUEST['call_type'],
					'call_duration' => $_REQUEST['call_duration'],
					'location' => $_REQUEST['location'],
					'date_time' => $_REQUEST['date_time']
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

	                 if($data_list['call_type']=='outgoing' && $data_list['call_duration']=='0 sec' && 
	                 	$comp_status == 'Initiated') {

		                $datalist = array(
							'comp_status' => 'Missed'			
						);

	    			
		    		   $this->Common_Model->update_records("lead_enquiry","enq_id",$enq_id,
		    		   $datalist);
	    		     }
	                 $response = array('msg' => 'Success !!'); 
	                 echo json_encode($response);

 		   } break;
 		   
 		   case "missed" : {
 		   		$data = array();
 		   		$user_id = $_REQUEST['user_id'];
 		   		
 		   	    $data['List_of_Leads'] = $this->Common_Model->FetchData("lead_enquiry as le LEFT JOIN erp_source  es ON es.id = le.source LEFT JOIN callback cb ON le.enq_id = cb.enq_id","le.*,es.source,cb.notes","assigned_to=".$user_id. " AND comp_status = 'Missed' ORDER BY enq_id DESC");
 		   		echo json_encode($data);
 		    }break;
 		    
 		    case "current_call_logs": {
			    $data = array();
			    $id = isset($_REQUEST['user_id']) ? $_REQUEST['user_id'] : 0;

			    if ($id > 0) {
			        $today = date("Y-m-d");
			        $condition = "emp_id = $id AND la.enquiry_remark = 'call log' AND DATE(date_time) = '$today'";

			        $call_logs = $this->Common_Model->FetchData("lead_activity as la LEFT JOIN lead_enquiry as le ON la.enq_id = le.enq_id", "la.*,le.name,le.mobile", $condition);

			        if (!empty($call_logs)) {
			            foreach ($call_logs as &$log) {
			                $log['user_id'] = $log['emp_id'];
			                $log['attachment_url'] = !empty($log['attachment']) 
			                    ? site_url('uploads/call_records/' . $log['attachment']) 
			                    : '';
			            }
			            $data['call_logs'] = $call_logs;
			        } else {
			            $data['call_logs'] = 'No call logs found for today';
			        }
			    } else {
			        $data['error'] = 'Invalid user_id';
			    }

			    echo json_encode($data);
			} break;


 		   case "contact_details" : {
 		   	$data = array();
 		   	$id = $_REQUEST['enq_id'];
 		   	$data['contact_details'] = $this->Common_Model->FetchData("lead_enquiry","customer_code,name,email,mobile,amobile,wp_no,state,city,location,specification,budget,enquiry_remark","enq_id=".$id);
 		   	$data['contact_details'][0]['amobile'] = "";
 		   	echo json_encode($data);
 		   }break;

 		   case "attendanceReport":{
    		$data = array();
    		$id = isset($_REQUEST['user_id']) ? $_REQUEST['user_id'] : 0;
    		$start_date = isset($_REQUEST['start_date']) ? $_REQUEST['start_date'] : '';
    		$end_date = isset($_REQUEST['end_date']) ? $_REQUEST['end_date'] : '';

    		if ($id > 0 && !empty($start_date) && !empty($end_date)) {
        		$this->db->select('attendance_log_id, user_id, status, log_date, log_datetime, log_lat, log_long, log_loc, approve_status, remarks');
        		$this->db->from('user_attendance_log');
        		$this->db->where('user_id', $id);
        		$this->db->where('log_date >=', $start_date);
        		$this->db->where('log_date <=', $end_date);
        		$this->db->order_by('log_date', 'ASC');
        		$query = $this->db->get();

        			if ($query->num_rows() > 0) {
            			$data['attendance_report'] = $query->result_array();
        			} else {
            			$data['attendance_report'] = 'No records found for the given date range';
        				}
    				} else {
        				$data['error'] = 'Invalid user_id or date range';
    				}

    			echo json_encode($data);
    			break;
    		}
    		
    		case "callBack" : {
    		    $enq_id = $_REQUEST['enq_id'];
    			$data_list = array(
					'user_id'=> $_REQUEST['user_id'],
					'enq_id' => $_REQUEST['enq_id'],
					'reason'=> $_REQUEST['reason'],
					'date_added'=>date('Y-m-d H:i:s'),
					'next_date'=>$_REQUEST['next_date'],
					'notes'=>$_REQUEST['notes']
				);
			  $count = $this->Common_Model->countRows("callback", "enq_id = $enq_id");
				if($count) {
					$this->Common_Model->update_records("callback", "enq_id", "$enq_id", 
			  	$data_list);
			  	$id = 1;
			   } else {
			  $id = $this->Common_Model->dbinsertid("callback", $data_list);
			  }
			  
			  $datalist = array(
			  		'comp_status' => 'Callback'
			  );
			  $this->Common_Model->update_records("lead_enquiry", "enq_id", "$enq_id", $datalist);
			  if($id){
			  	$response = $data_list;
              $response['msg'] =  'Success !!';
              } else {
              	$response = array('msg' => 'FAil..!!');
              }
              echo json_encode($response); 
                
 		   		break;
    		}

    		case "interested" : {
    		    $enq_id = $_REQUEST['enq_id'];
    			$data_list = array(
					'user_id'=> $_REQUEST['user_id'],
					'enq_id' => $_REQUEST['enq_id'],
					'prop_id' => $_REQUEST['prop_id'],
					'require_type'=> $_REQUEST['require_type'],
					
					'prop_type'=>$_REQUEST['prop_type'],
					'prop_sub_type'=>$_REQUEST['prop_sub_type'],
					'prop_stage'=>$_REQUEST['prop_stage'],
					'location'=>$_REQUEST['location'],
					'budgets'=>$_REQUEST['budgets'],
					'remarks'=> 'interested',
					'reason'=>$_REQUEST['reason'],
					'notes'=>$_REQUEST['notes'],
					'dateadded' => date('Y-m-d H:i:s')
				);
			 $count = $this->Common_Model->countRows("interest", "enq_id = $enq_id");
				if($count) {
			    $this->Common_Model->update_records("interest", "enq_id", "$enq_id", 
			  	$data_list);
					$id = 1;
			   } else {
			  $id = $this->Common_Model->dbinsertid("interest", $data_list);
			  }
			  
			  $datalist = array(
			  		'comp_status' => 'Interested'
			  );
			  $this->Common_Model->update_records("lead_enquiry", "enq_id", "$enq_id", $datalist);
              $response = array('msg' => 'Success..!!'); 
              echo json_encode($response); 
              
 		   		
    		}break;

    		case "notInterest" :{
    		    $enq_id = $_REQUEST['enq_id'];
    			$data_list = array(
    				'user_id'=> $_REQUEST['user_id'],
    				'enq_id' => $_REQUEST['enq_id'],
    				
    			    'remarks'=> 'not interested',
    				'reason'=> $_REQUEST['reason'],
    				'notes'=> $_REQUEST['notes'],
    				'dateadded' => date('Y-m-d H:i:s')
    			);
    		 $count = $this->Common_Model->countRows("interest", "enq_id = $enq_id");
				if($count) {
					$this->Common_Model->update_records("interest", "enq_id", "$enq_id", 
			  	$data_list);
					$id = 1;
			   } else {
			  $id = $this->Common_Model->dbinsertid("interest", $data_list);
			  }
              $response = array('msg' => 'Success..!!'); 
              echo json_encode($response);
             
    		}break;	

    		case "viewcallback" : {
    		
    			$data = array();
    			$id = $_REQUEST['user_id'];
    			$data['view_call_back'] = $this->Common_Model->FetchData(
				    "callback as cb LEFT JOIN lead_enquiry as le ON cb.enq_id = le.enq_id", 
				    "*, cb.reason", 
				    "cb.user_id = " . $id . " AND  cb.next_date = (
									    SELECT MAX(cb2.next_date) 
									    FROM callback cb2 
									    WHERE cb2.enq_id = cb.enq_id
									) AND (le.comp_status = 'Callback' OR le.comp_status = 'Initiated') ORDER BY cb.next_date; "
													);
    			echo json_encode($data);
    		}break;

    		case "viewinterested" : {
    			$data = array();
    			$id = $_REQUEST['user_id'];
    			$data['view_interested'] = $this->Common_Model->FetchData(
				    "interest as i LEFT JOIN lead_enquiry as le ON i.enq_id = le.enq_id LEFT JOIN location AS loc ON i.location = loc.lid", 
				    "*,loc.location, COALESCE(i.budget, le.budget) AS budget", 
				    "i.user_id = " . $id . " AND i.remarks = 'interested' AND le.comp_status = 'Interested' ORDER BY le.enq_id DESC"
				);

    			echo json_encode($data);
    		}break;

    		case "viewNotinterested" : {
    			$data = array();
    			$id = $_REQUEST['user_id'];
    			$data['view_not_interested'] = $this->Common_Model->FetchData(
				    "interest as i LEFT JOIN lead_enquiry as le ON i.enq_id = le.enq_id", 
				    "*", 
				    "i.user_id = " . $id . " AND i.remarks = 'not interested' ORDER BY le.enq_id DESC "
				);

    			echo json_encode($data);
    		}break;

    		case "add_lead" : {
    			$data_list=array(
				'name' => $_REQUEST['name'],
	            'customer_code' => $_REQUEST['customer_code'],
	            
	            'email' => $_REQUEST['email'],
	            'mobile' => $_REQUEST['mobile'],
	            'amobile' => $_REQUEST['amobile'],
	            'wp_no' => $_REQUEST['wp_no'] ? $_REQUEST['wp_no'] : $_REQUEST['mobile'],
	            'gender' => $_REQUEST['gender'],
	            'state' => $_REQUEST['state'],
	            'city' => $_REQUEST['city'],
	           'location' => $_REQUEST['location'],
	           'specification' => $_REQUEST['specification'],
	            'budget' => $_REQUEST['budget'],
	            'assigned_to' => $_REQUEST['user_id'],
	            'enquiry_date' => date('Y-m-d'),
	            'enquiry_remark'  => $_REQUEST['remark'],
	            'source' => $_REQUEST['source']
			);
    		  $id = $this->Common_Model->dbinsertid("lead_enquiry", $data_list);
              if($id){
              	$response = $data_list;
              	$response['msg'] =  'Success..!!';
              	} else {
              		$response = array('msg' => 'FAil..!!');
              	} 
              echo json_encode($response);
            
    		}break;

    	  case "cp_reg": {

    	  	$cp = $this->Common_Model->FetchData("cp_reg","*","1 ORDER BY cp_id DESC LIMIT 1");
			if ($cp) {

				$tempId = explode('KRCP',$cp[0]['cp_code']);
				$rc = (end($tempId) +  1) ;
				$newtempId = str_pad($rc, 6, '0', STR_PAD_LEFT);
				$cp_code = $cp_code = 'KRCP'.str_pad($newtempId, 6, '0', STR_PAD_LEFT);
			}else {
				$cp_code = $cp_code = 'KRCP'.str_pad('1', 6, '0', STR_PAD_LEFT);
		 	}

			    $data_list = array(
			        'firstname'   => isset($_REQUEST['f_name']) ? trim($_REQUEST['f_name']) : '',
			        'lastname'    => isset($_REQUEST['l_name']) ? trim($_REQUEST['l_name']) : '',
			        'company'     => isset($_REQUEST['company']) ? trim($_REQUEST['company']) : '',
			        'mobile'      => isset($_REQUEST['mobile']) ? trim($_REQUEST['mobile']) : '',
			        'email'       => isset($_REQUEST['email']) ? trim($_REQUEST['email']) : '',
			        'address'     => isset($_REQUEST['address']) ? trim($_REQUEST['address']) : '',
			        'doc_type'    => isset($_REQUEST['doc_type']) ? trim($_REQUEST['doc_type']) : '',
			        'document'    => isset($_REQUEST['document']) ? trim($_REQUEST['document']) : '',
			        'ac_no'       => isset($_REQUEST['ac_no']) ? trim($_REQUEST['ac_no']) : '',
			        'ifsc'        => isset($_REQUEST['ifsc']) ? trim($_REQUEST['ifsc']) : '',
			        'prop_types'  => isset($_REQUEST['prop_types']) ? trim($_REQUEST['prop_types']) : '',
			        'password'    => isset($_REQUEST['password']) ? trim($_REQUEST['password']) : '',
			        'cp_code' => $cp_code
			        // 'otp'         => rand(100000, 999999),
			        // 'otp_time'    => date("Y-m-d H:i:s", strtotime("+10 minutes"))
			    );

			    // File Upload: Document Image
			    if (!empty($_FILES['doc_img']['name'])) {
			        $config['upload_path']   = 'uploads/docfiles/';
			        $config['allowed_types'] = 'jpg|jpeg|png|gif';
			        $config['file_name']     = 'PROFILE_' . date("Ymd") . '_' . time();
			        $config['max_size']      = '1024';

			        $this->load->library('upload', $config);
			        $this->upload->initialize($config);

			        if ($this->upload->do_upload('doc_img')) {
			            $uploadData = $this->upload->data();
			            $data_list['doc_img'] = $uploadData['file_name'];
			        } else {
			            $data_list['doc_img'] = '';
			        }
			    } else {
			        $data_list['doc_img'] = '';
			    }

			    // File Upload: Agreement Document
			    if (!empty($_FILES['agreement']['name'])) {
			        $config['upload_path']   = 'uploads/docfiles/';
			        $config['allowed_types'] = 'pdf|doc|docx|txt';
			        $config['file_name']     = 'DOCUMENT_' . date("Ymd") . '_' . time();
			        $config['max_size']      = '2048';  // Max size: 2MB

			        $this->upload->initialize($config);

			        if ($this->upload->do_upload('agreement')) {
			            $uploadData = $this->upload->data();
			            $data_list['agreement'] = $uploadData['file_name'];
			        } else {
			            $data_list['agreement'] = '';
			        }
			    } else {
			        $data_list['agreement'] = '';
			    }

			    // Insert Data into Database
			    $id = $this->Common_Model->dbinsertid("cp_reg", $data_list);
			    
			     // Insert into users table
            $datalist = array(
					'firstname'=> $_REQUEST['f_name'],
					'lastname'=> $_REQUEST['l_name'],
					'userphone'=> $_REQUEST['mobile'],
					'useremail'=> $_REQUEST['email'],
					'username'=> $_REQUEST['username'],
					'password'=> md5($_REQUEST['password']),
					'usertype' => "Channel Partner",
					'userstatus' => 0,
					'employee_tagged_id' => $id,
					'created_on'=>date('Y-m-d H:i:s')
				);
            
            $cpUserId = $this->Common_Model->dbinsertid("users", $datalist);


			    if ($id && $cpUserId) {
			    	$res = $this->Common_Model->FetchData("cp_reg","*", "cp_id=".$id);
			        $response = $res[0];
			        $response['msg'] = 'Success..!!';
			    } else {
			        $response = array('msg' => 'Fail..!!');
			    }

			    echo json_encode($response);
			}
			break;

		 case "cp_login": {

			    $identifier = $_REQUEST['identifier'] ?? '';  // Email or Mobile
			    $otp = $_REQUEST['otp'] ?? '';

			    if (!$identifier) {
			        echo json_encode(['msg' => 'Email or Mobile is required']);
			        exit;
			    }

			    // Fetch Channel Partner (CP) details
			    $cp = $this->Common_Model->FetchData("cp_reg", "*", "email = '$identifier' OR mobile = '$identifier'");

			    if (!$cp) {
			        echo json_encode(['msg' => 'User not found']);
			        exit;
			    }

			    $cp_id = $cp[0]['cp_id']; // Store CP ID

			    if (!$otp) {
			        // Generate OTP and Update DB
			        $data_list = [
			            'otp' => rand(100000, 999999),
			            'otp_time' => date("Y-m-d H:i:s", strtotime("+10 minutes"))
			        ];
			        $this->Common_Model->update_records("cp_reg", "cp_id", $cp_id, 
			        	$data_list);

			        echo json_encode(['msg' => 'OTP sent', 'otp' => $data_list['otp']]); // Show OTP for testing
			    } else {
			        // Verify OTP
			        $cp = $this->Common_Model->FetchData("cp_reg", "*", "otp = '$otp' AND (email = '$identifier' OR mobile = '$identifier')");
			        
			        if ($cp) {
			            $this->Common_Model->update_records("cp_reg", "cp_id", $cp_id, ['otp' => null]);
			            echo json_encode(['msg' => 'Login successful', 'user' => $cp[0]]);
			        } else {
			            echo json_encode(['msg' => 'Invalid OTP']);
			        }
			    }
			} break;


		 case "property" : {
				$data = array();
    			$id = $_REQUEST['user_id'];
    			$locate = $_REQUEST['location'];
    			
    			$cond = '';
    			if($locate){
    				$cond = " AND location='$locate'";
    			}
				$data = $this->Common_Model->FetchData("property","pid, prop_name", 
					" FIND_IN_SET ('$id', assigne_to) AND avail_status = 'available' $cond");
				if($data) {
					for ($i=0; $i<count($data); $i++) {
				$data[$i]['link'] = site_url('pages/details/' .$data[$i]['pid']);
				}
			   }
				echo json_encode($data);
			}break;

		 case "property_list" : {
				$data = array();
    			$id = $_REQUEST['user_id'];
    			$pid = $_REQUEST['pid'];

				$data = $this->Common_Model->FetchData("property","*", 
					" FIND_IN_SET ('$id', assigne_to) AND pid='$pid' ");

				if($data) {
				$res = $this->Common_Model->FetchData('property_images','*',"pid='$pid'");
				if($res){
					$total = count($res);
					for($i=0;$i<$total;$i++) { 
						$Photo = $res[$i]['images'];
						
						$PropertyPic=site_url("uploads/photos/$Photo");
						$data[0]['images'][$i]=$PropertyPic;
						
					}
				}
			 }	
				echo json_encode($data);
			}break;
			
		 case "locations" : {
		 	$data = array();
		 	
		 	$data['location-name'] = $this->Common_Model->FetchData("location","*");
		 	echo json_encode($data); 
		 }break;
		 
		 case "upcoming_locations" : {
		 	$data = array();
		 	
		 	$data['upcoming-location-names'] = $this->Common_Model->FetchData("uc_location","*");
		 	echo json_encode($data); 
		 }break;
			
			case "edit_lead" : {

				$enq_id = $_REQUEST['enq_id'];
				$user_id = $_REQUEST['user_id'];

    			$data_list=array(
				'name' => $_REQUEST['name'],
	            
	            
	            'email' => $_REQUEST['email'],
	            
	            'amobile' => $_REQUEST['amobile'],
	            'wp_no' => $_REQUEST['wp_no'],
	            'gender' => $_REQUEST['gender'],
	            'state' => $_REQUEST['state'],
	            'city' => $_REQUEST['city'],
	           'location' => $_REQUEST['location'],
	           'specification' => $_REQUEST['specification'],
	            'budget' => $_REQUEST['budget'],
	            'enquiry_remark'  => $_REQUEST['remark'],
	            'updated_by'  => $user_id,
	            'updated_at'  => $this->timestamp
			);
    		   $this->Common_Model->update_records("lead_enquiry","enq_id",$enq_id,
    		   $data_list);
              
              	$response = $data_list;
              	$response['msg'] =  'Success..!!';
              	
              	echo json_encode($response);
            
    		}break;

           case "success_lead" : {
    	 	$enq_id = $_REQUEST['enq_id'];
    	 	$data_list=array(
				'comp_status' => 'Success',
				'reason' => $_REQUEST['reason']
			);
			 $this->Common_Model->update_records("lead_enquiry","enq_id",$enq_id,
    		   $data_list);
              
              	
              	$response['msg'] =  'Success..!!';
             echo json_encode($response);	
    	 } break;
    	 
    	  case "delete_lead" : {
    	 	$enq_id = $_REQUEST['enq_id'];
    	 	$data_list=array(
				'comp_status' => 'Delete',
				'reason' => $_REQUEST['reason'],
				'delete_date' => date('Y-m-d H:i:s')
			);
			 $this->Common_Model->update_records("lead_enquiry","enq_id",$enq_id,
    		   $data_list);
              
              	
              	$response['msg'] =  'Success..!!';
             echo json_encode($response);	
    	 } break;		
    	
    	 case "success_leads" : {
 		   	$data = array();
 		   	$id = $_REQUEST['user_id'];
 		   	$data['List_of_success_Leads'] = $this->Common_Model->FetchData("lead_enquiry","*","assigned_to=".$id. " AND comp_status = 'Success' ORDER BY enq_id DESC");
 		   	echo json_encode($data);
 		   }break;

 		   case "delete_leads" : {
 		   	$data = array();
 		   	$id = $_REQUEST['user_id'];
 		   	$data['List_of_delete_Leads'] = $this->Common_Model->FetchData("lead_enquiry","*","assigned_to=".$id. " AND comp_status = 'Delete' ORDER BY enq_id DESC");
 		   	echo json_encode($data);
 		   }break;
            
          case "search_lead" : {
 		   	$data = array();
 		   	$id = $_REQUEST['user_id'];
 		   	$mobile = $_REQUEST['mobile'];

 		   	$data['List_of_Leads'] = $this->Common_Model->FetchData("lead_enquiry","*","assigned_to=".$id. " AND comp_status = 'Initiated' AND 
 		   		(mobile = '$mobile' OR amobile = '$mobile' OR wp_no = '$mobile') ORDER BY enq_id DESC");
 		   	echo json_encode($data);
 		   }break; 
 		   
 		 case "cancel_callback" : {
 		  	$data = array();
 		  	$id = $_REQUEST['enq_id'];
 		   $this->Common_Model->DelData("callback", "enq_id = '$id'");
 		   $datalist = array(
 		   		'comp_status' => 'Delete',
 		   		'reason' => $_REQUEST['reason'],
 		   		'delete_date' => date('Y-m-d H:i:s')
 		   );
 		   $this->Common_Model->update_records("lead_enquiry", "enq_id", "$id", $datalist);
 		   $data['msg'] =  'Success..!!';
 		  	echo json_encode($data);
 		  }break;
 		  
 		  case "opportunity" : {
 		      $enq_id = $_REQUEST['enq_id'];
 		      // Handling multiple property types
    		 //$prop_type = isset($_REQUEST['prop_type']) ? implode(',', $_REQUEST['prop_type']) : '';
    		 $prop_type =  $_REQUEST['prop_type'];
    			$data_list = array(
					'user_id'=> $_REQUEST['user_id'],
					'enq_id' => $_REQUEST['enq_id'],
					'prop_id' => $_REQUEST['prop_id'],
					'require_type'=> $_REQUEST['require_type'],
					'other_prop' => $_REQUEST['other_prop'],
					'prop_type' => $prop_type,  // Multiple property types handled here
					'prop_sub_type'=>$_REQUEST['prop_sub_type'],
					'prop_stage'=>$_REQUEST['prop_stage'],
					'location'=>$_REQUEST['location'],
					'uc_location'=>$_REQUEST['uc_location'],
					'remarks'=> 'opportunity',
					'locations'=>$_REQUEST['locations'],
					'city' => $_REQUEST['city'],
					'reason'=>$_REQUEST['reason'],
					'notes'=>$_REQUEST['notes'],
					'dateadded' => date('Y-m-d H:i:s')
				);
			 $count = $this->Common_Model->countRows("interest", "enq_id = $enq_id");
				if($count) {
					$this->Common_Model->update_records("interest", "enq_id", "$enq_id", 
			  	$data_list);
					$id = 1;
			   } else {
			  $id = $this->Common_Model->dbinsertid("interest", $data_list);
			  }
			  
			 $datalist = array(
			  		'name' => $_REQUEST['name'],
			  		'comp_status' => 'Opportunity',
			  		'budget' => $_REQUEST['budget']
			  );
			  $this->Common_Model->update_records("lead_enquiry", "enq_id", "$enq_id", 
			  	$datalist);
			  $this->Common_Model->DelData("callback", "enq_id = '$enq_id'");	
              $response = array('msg' => 'Success..!!'); 
              echo json_encode($response); 
              
 		   		
    		}break;
    		
    		case "viewopportunity" : {
    			$data = array();
    			$id = $_REQUEST['user_id'];
    		$data['view_opportunities'] = $this->Common_Model->FetchData(
				    "interest as i LEFT JOIN lead_enquiry as le ON i.enq_id = le.enq_id LEFT JOIN erp_source as es ON es.id = le.source LEFT JOIN uc_location ucl ON i.uc_location = ucl.uc_lid", 
				    "*,i.locations,i.city,es.source,ucl.uc_location", 
				    "i.user_id = " . $id . " AND le.comp_status = 'Opportunity' ORDER BY le.enquiry_date DESC"
				);

    			echo json_encode($data);
    		}break;
    		
    		case "rp_reg": {

    	  	$rp = $this->Common_Model->FetchData("rp_reg","*","1 ORDER BY rp_id DESC LIMIT 1");
			if ($rp) {

				$tempId = explode('KR-RP',$rp[0]['rp_code']);
				$rc = (end($tempId) +  1) ;
				$newtempId = str_pad($rc, 6, '0', STR_PAD_LEFT);
				$rp_code = $rp_code = 'KR-RP'.str_pad($newtempId, 6, '0', STR_PAD_LEFT);
			}else {
				$rp_code = $rp_code = 'KR-RP'.str_pad('1', 6, '0', STR_PAD_LEFT);
		 	}

			    $data_list = array(
			        'firstname'   => isset($_REQUEST['f_name']) ? trim($_REQUEST['f_name']) : '',
			        'lastname'    => isset($_REQUEST['l_name']) ? trim($_REQUEST['l_name']) : '',
			        
			        'mobile'      => isset($_REQUEST['mobile']) ? trim($_REQUEST['mobile']) : '',
			        'email'       => isset($_REQUEST['email']) ? trim($_REQUEST['email']) : '',
			        'address'     => isset($_REQUEST['address']) ? trim($_REQUEST['address']) : '',
			        'locality'       => isset($_REQUEST['locality']) ? trim($_REQUEST['locality']) : '',
			        'gender'       => isset($_REQUEST['gender']) ? trim($_REQUEST['gender']) : '',
			        'doc_type'    => isset($_REQUEST['doc_type']) ? trim($_REQUEST['doc_type']) : '',
			        'doc_no'    => isset($_REQUEST['doc_no']) ? trim($_REQUEST['doc_no']) : '',
			        'ac_no'       => isset($_REQUEST['ac_no']) ? trim($_REQUEST['ac_no']) : '',
			        'ifsc'        => isset($_REQUEST['ifsc']) ? trim($_REQUEST['ifsc']) : '',
			        'prop_types'  => isset($_REQUEST['prop_types']) ? trim($_REQUEST['prop_types']) : '',
			        'password'   => isset($_REQUEST['password']) ? trim($_REQUEST['password']) : '',
			        'rp_code' => $rp_code
			        // 'otp'         => rand(100000, 999999),
			        // 'otp_time'    => date("Y-m-d H:i:s", strtotime("+10 minutes"))
			    );

			    // File Upload: Document Image
			    if (!empty($_FILES['doc_img']['name'])) {
			        $config['upload_path']   = 'uploads/docfiles/';
			        $config['allowed_types'] = 'jpg|jpeg|png|gif';
			        $config['file_name']     = 'PROFILE_' . date("Ymd") . '_' . time();
			        $config['max_size']      = '2048';

			        $this->load->library('upload', $config);
			        $this->upload->initialize($config);

			        if ($this->upload->do_upload('doc_img')) {
			            $uploadData = $this->upload->data();
			            $data_list['doc_img'] = $uploadData['file_name'];
			        } else {
			            $data_list['doc_img'] = '';
			        }
			    } else {
			        $data_list['doc_img'] = '';
			    }

			   

			    // Insert Data into Database
			    $id = $this->Common_Model->dbinsertid("rp_reg", $data_list);
			    
			    // Insert into users table
           $datalist = array(
					'firstname'=> $_REQUEST['f_name'],
					'lastname'=> $_REQUEST['l_name'],
					'userphone'=> $_REQUEST['mobile'],
					'useremail'=> $_REQUEST['email'],
					'username'=> $_REQUEST['username'],
					'password'=> md5($_REQUEST['password']),
					'usertype' => "Referal Partner",
					'userstatus' => 0,
					'employee_tagged_id' => $id,
					'created_on'=>date('Y-m-d H:i:s')
				);
            
            $rpUserId = $this->Common_Model->dbinsertid("users", $datalist);


			    if ($id && $rpUserId) {
			    	$res = $this->Common_Model->FetchData("rp_reg","*", "rp_id=".$id);
			        $response = $res[0];
			        $response['msg'] = 'Success..!!';
			    } else {
			        $response = array('msg' => 'Fail..!!');
			    }

			    echo json_encode($response);
			}
			break;
			
			case "rp_login": {

			    $identifier = $_REQUEST['identifier'] ?? '';  // Email or Mobile
			    $otp = $_REQUEST['otp'] ?? '';

			    if (!$identifier) {
			        echo json_encode(['msg' => 'Email or Mobile is required']);
			        exit;
			    }

			    // Fetch Channel Partner (CP) details
			    $rp = $this->Common_Model->FetchData("rp_reg AS rp JOIN users AS u ON rp.rp_id = u.user_id", "*", " (rp.email = '$identifier' OR rp.mobile = '$identifier') ");

			    if (!$rp) {
			        echo json_encode(['msg' => 'User not found']);
			        exit;
			    }

			    $rp_id = $rp[0]['rp_id']; // Store RP ID

			    if (!$otp) {
			        // Generate OTP and Update DB
			        $data_list = [
			            'otp' => rand(100000, 999999),
			            'otp_time' => date("Y-m-d H:i:s", strtotime("+10 minutes"))
			        ];
			        $this->Common_Model->update_records("rp_reg", "rp_id", $rp_id, 
			        	$data_list);

			        echo json_encode(['msg' => 'OTP sent', 'otp' => $data_list['otp']]); // Show OTP for testing
			    } else {
			        // Verify OTP
			        $rp = $this->Common_Model->FetchData("rp_reg", "*", "otp = '$otp' AND (email = '$identifier' OR mobile = '$identifier') AND u.userstatus = 1");
			        
			        if ($rp) {
			            $this->Common_Model->update_records("rp_reg", "rp_id", $rp_id, ['otp' => null]);
			            echo json_encode(['msg' => 'Login successful', 'user' => $rp[0]]);
			        } else {
			            echo json_encode(['msg' => 'Invalid OTP']);
			        }
			    }
			} break;
			
			
			case "fcm" : {
    			$user_id = $_REQUEST['user_id'];

    			$data_list = array(
    				'fcm_token' => $_REQUEST['fcm_token']
    			);
    			$this->Common_Model->update_records("users", "user_id", "$user_id",
    			 $data_list);
    			$response = array('msg' => 'Success..!!'); 
              echo json_encode($response); 
    		} break;
    		
    		case "edit_opportunity" : {

				$enq_id = $_REQUEST['enq_id'];
				//$user_id = $_REQUEST['user_id'];
				$data_list = array(
					
					
					'prop_id' => $_REQUEST['prop_id'],
					
					'other_prop' => $_REQUEST['other_prop'],
					'prop_type'=>$_REQUEST['prop_type'],
					'prop_sub_type'=>$_REQUEST['prop_sub_type'],
					'uc_location'=>$_REQUEST['uc_location'],
					'locations'=>$_REQUEST['locations'],
					'city' => $_REQUEST['city'],
					'remarks'=> 'opportunity',
					'reason'=>$_REQUEST['reason'],
					'notes'=>$_REQUEST['notes']
					
				);

    			
    		   $this->Common_Model->update_records("interest","enq_id",$enq_id,
    		   $data_list);
    		   
    		   $datalist = array(
    		   		'name'      => $_REQUEST['name'],
    		   		'budget'    => $_REQUEST['budget'],
    		   );
    		   $this->Common_Model->update_records("lead_enquiry", "enq_id", $enq_id, $datalist);
              
              	$response = $data_list;
              	$response['msg'] =  'Success..!!';
              	
              		
              	
              echo json_encode($response);
            
    		} break;
    		
    		case "delete_opportunity" : {
	 		  	$data = array();
	 		  	$id = $_REQUEST['enq_id'];
	 		   $this->Common_Model->DelData("interest", "enq_id = '$id'");
	 		   $data_list=array(
				'comp_status' => 'Delete',
				'reason' => $_REQUEST['reason'],
				'delete_date' => date('Y-m-d H:i:s')
			);
	 		   $this->Common_Model->update_records("lead_enquiry","enq_id",$id,
    		   $data_list);
	 		   $data['msg'] =  'Success..!!';
	 		  	echo json_encode($data);
	 		}break;
	 		
	 		case "myProfile" : {
			    $data = array();
			    $id = isset($_REQUEST['user_id']) ? (int)$_REQUEST['user_id'] : 0;  // Ensure ID is numeric

			    if ($id <= 0) {
			        echo json_encode(['status' => 'error', 'msg' => 'Invalid User ID']);
			        exit;
			    }

			    $profile = $this->Common_Model->FetchData(
			        "employees",
			        "emp_photo, techno_emp_id, employee_name, emp_age, emp_mobile, emp_bloodgrp, emp_pgmobile, emp_plotno, emp_at, emp_po, emp_landmark,emp_curpinp",
			        "user_id = $id"
			    );

			      if ($profile) {
			        // Add the URL path for the photo
			        $base_url = base_url('uploads/employee/');  // Example base path
			        $profile[0]['emp_photo'] = !empty($profile[0]['emp_photo']) 
			                                    ? $base_url . $profile[0]['emp_photo'] 
			                                    : $base_url . 'default.jpg';  // Default image if no photo exists

			        $data['my_profile'] = $profile;
			        $data['status'] = 'success';
			    } else {
			        $data['status'] = 'error';
			        $data['msg'] = 'User profile not found';
			    }

			    echo json_encode($data);
			} break;
            
            case "updateProfilePhoto" : {
			    $user_id = $_REQUEST['user_id'] ?? '';

			    if (!$user_id) {
			        echo json_encode(['msg' => 'User ID is required']);
			        exit;
			    }

			    if (!empty($_FILES['emp_photo']['name'])) {
			    	 // Custom Filename Format
			        $newfile = preg_replace('/\W+/', '-', strtolower(
			            $this->input->post('emp_firstname') . ' ' . $this->input->post('emp_lastname')
			        )) . uniqid();
			        // File Upload Configuration
			        $config['upload_path']   = 'uploads/employee/';
			        $config['allowed_types'] = 'jpg|jpeg|png|pdf';
			        $config['file_name']     = $newfile; // Custom filename here
			        $config['max_size']      = '10240';  // Max size: 10MB

			        $this->load->library('upload', $config);
			        $this->upload->initialize($config);

			        if ($this->upload->do_upload('emp_photo')) {
			            $uploadData = $this->upload->data();
			            $emp_photo = $uploadData['file_name'];

			            // Update Database
			            $data_list = ['emp_photo' => $emp_photo];
			            $this->Common_Model->update_records("employees", "user_id", $user_id, $data_list);

			            $response = [
			                'msg' => 'Profile photo updated successfully',
			                'photo_url' => base_url('uploads/employee/' . $emp_photo)
			            ];
			        } else {
			            $response = ['msg' => 'Photo upload failed', 'error' => $this->upload->display_errors()];
			        }
			    } else {
			        $response = ['msg' => 'No photo uploaded'];
			    }

			    echo json_encode($response);
			} break;

            case "edit_interested" : {
				$enq_id = $_REQUEST['enq_id'];
				//$user_id = $_REQUEST['user_id'];
				$data_list = array(
					'prop_id' => $_REQUEST['prop_id'],
					'prop_type'  =>  $_REQUEST['prop_type'],
					'prop_sub_type'  =>  $_REQUEST['prop_sub_type'],
					'budgets'  =>  $_REQUEST['budgets'],
					'location'  =>  $_REQUEST['location'],
					// 'city' => $_REQUEST['city'],
					'remarks'=> 'interested',
					'reason'  =>  $_REQUEST['reason'],
					'notes'  =>  $_REQUEST['notes']
				);

    			
    		   $this->Common_Model->update_records("interest","enq_id",$enq_id,
    		   $data_list);

    		   $datalist = array(
    		   		'name' => $_REQUEST['name']
    		   );
    		   $this->Common_Model->update_records("lead_enquiry", "enq_id", $enq_id, 
    		   	$datalist);
              	$response['msg'] =  'Success..!!';
              echo json_encode($response);            
    		} break;
    		
    		case "delete_interested" : {
	 		  	$data = array();
	 		  	$id = $_REQUEST['enq_id'];
	 		   $this->Common_Model->DelData("interest", "enq_id = '$id'");
	 		   $data_list=array(
				'comp_status' => 'Delete',
				'reason' => $_REQUEST['reason'],
				'delete_date' => date('Y-m-d H:i:s')
			);
	 		   $this->Common_Model->update_records("lead_enquiry","enq_id",$id,
    		   $data_list);
	 		   $data['msg'] =  'Success..!!';
	 		  	echo json_encode($data);
	 		}break;
	 		
	 		case "sources" : {
		 	$data = array();
		 	
		 	$data['source-name'] = $this->Common_Model->FetchData("erp_source","*","status = '1'");
		 	echo json_encode($data); 
		   }break;
		   
		   case "follow_up" : {
		 	$data = array();
		 	$enq_id = $_REQUEST['enq_id'];
				
				// Handling multiple property types
    		 $deal = isset($_REQUEST['deal_mode']) ? implode(',', $_REQUEST['deal_mode']) : '';
				$data_list = array(
					
					
					'f_status' => $_REQUEST['f_status'],
					
					'budget' => $_REQUEST['budget'],
					'deal_mode' => $deal,  // Multiple property types handled here
					
					'f_notes'=>$_REQUEST['f_notes'],
					'comp_status' => 'Follow Up'
					
				);

    			
    		   $this->Common_Model->update_records("lead_enquiry","enq_id",$enq_id,
    		   $data_list);
    		   $response['msg'] =  'Success..!!';
	 		  	echo json_encode($response);

		  }break;
		  
		  case "view_follow_up" : {
		  		$data = array();
    			$id = $_REQUEST['user_id'];
    			$data['view_follow_ups'] = $this->Common_Model->FetchData(
				    "lead_enquiry as le LEFT JOIN erp_source as es ON es.id = le.source", 
				    "*,es.source", 
				    "le.assigned_to = " . $id . " AND le.comp_status = 'Follow Up' ORDER BY le.enquiry_date DESC"
				);

    			echo json_encode($data);
		    }break;
		    
		    case "edit_follow_up" : {

				$enq_id = $_REQUEST['enq_id'];
				//$user_id = $_REQUEST['user_id'];
				// Handling multiple property types
    		 $deal = isset($_REQUEST['deal_mode']) ? implode(',', $_REQUEST['deal_mode']) : '';
				$data_list = array(
					
					'name' => $_REQUEST['name'],
					'mobile'=>$_REQUEST['mobile'],
					'f_status'=>$_REQUEST['f_status'],
					
					'budget'=>$_REQUEST['budget'],
					'deal_mode' => $deal,  // Multiple property types handled here
					
					'f_notes'=>$_REQUEST['f_notes'],
					'comp_status' => 'Follow Up'
					
				);

    		   $this->Common_Model->update_records("lead_enquiry", "enq_id", $enq_id, 
    		   	$data_list);             
              	 
              	$response['msg'] =  'Success..!!';
             echo json_encode($response);
            
    		} break;

    		case "delete_follow_up" : {
	 		  	$data = array();
	 		  	$id = $_REQUEST['enq_id'];
	 		   
	 		   $data_list=array(
				'comp_status' => 'Delete',
				'reason' => $_REQUEST['reason'],
				'delete_date' => date('Y-m-d H:i:s')
			   );
	 		   $this->Common_Model->update_records("lead_enquiry","enq_id",$id,
    		   $data_list);
	 		   $data['msg'] =  'Success..!!';
	 		  	echo json_encode($data);
	 		}break;
	 		
	 		case "leave_type" : {
	 		 	$data = $this->Common_Model->FetchData("leave_master","*");
	 		 	echo json_encode($data);
	 		 }break;
	 		 
	 		 case "apply_leave": {

			    $user_id = $_REQUEST['user_id'] ?? ''; // User ID from request
			    $leave_type = $_REQUEST['leave_type'] ?? '';
			    $apply_from = $_REQUEST['apply_from'] ?? '';
			    $apply_to = $_REQUEST['apply_to'] ?? '';
			    $hfday = $_REQUEST['hfday'] ?? '';
                $reason = $_REQUEST['leavereason'] ?? '';
			    

			    // Fetch employee_id using user_id from users table
			    $employee_id = $this->Common_Model->FetchData("users", "employee_tagged_id", "user_id = $user_id");

			    

			    

			    

			    // Calculate number of leave days
			    $maxdate = date('Y-m-d', strtotime("+1 day", strtotime($apply_to)));
			    $maxdate = strtotime($maxdate);
			    $mindate = strtotime($apply_from);
			    $datediff = $maxdate - $mindate;
			    $no_of_days = round($datediff / (60 * 60 * 24)) * $hfday;

			    // Fetch session details
			    $curSession = $this->Common_Model->FetchData("sessions","session_name","active_session = 'Active'");

			    $data_list = array(
			        'leave_type'    => $leave_type,
			        'employee_id'   => $employee_id,
			        'apply_from'    => date('Y-m-d', strtotime($apply_from)),
			        'apply_to'      => date('Y-m-d', strtotime($apply_to)),
			        'no_of_days'    => $no_of_days,
			        'session'       => $curSession,
			        'hfday'         => $hfday,
			        'leave_status'  => 0,  // Pending status
			        'created_on'    => date('Y-m-d H:i:s'),
			        'leavereason'   => $reason
			    );

			    // Insert into `leave_application`
			    $this->Common_Model->dbinsertid("leave_application", $data_list);

			    echo json_encode(['msg' => 'Leave applied successfully']);
			} break;
    		
    		case "avl_leave" : {
			    $user_id = $_REQUEST['user_id'];
			    
			    // Fetch employee ID from users table
			    $employee = $this->Common_Model->FetchData("users", "employee_tagged_id", "user_id = $user_id");
			    if (!$employee) {
			        echo json_encode(['msg' => 'Employee not found']);
			        exit;
			    }
			    $employee_id = $employee; // Extract actual ID

			    // Fetch active session
			    $sessionData = $this->Common_Model->FetchData("sessions", "session_name", "active_session = 'Active'");
			    $curSession = $sessionData;

			    if (empty($curSession)) {
			        echo json_encode(['msg' => 'No active session found']);
			        exit;
			    }

			    // Fetch leave types
			    $leavetypes = $this->Common_Model->FetchData("leave_master", "*", "leave_active = 'Active'");
			    
			    $leave = []; // Initialize an empty array

			    if ($leavetypes) {
			        foreach ($leavetypes as $i => $type) {
			            // Get total leaves taken
			            $totleave = $this->Common_Model->db_query("
			                SELECT SUM(no_of_days) AS totalleave 
			                FROM leave_application 
			                WHERE employee_id = $employee_id 
			                AND session = '$curSession' 
			                AND leave_type = '".$type['leave_id']."' 
			                AND leave_status = '1'
			            ");

			            $leave_taken = $totleave[0]['totalleave'] ?? 0;

			            // Fetch leave balance
			            if ($type['leave_type'] == 'EL') {
			                $records = $this->Common_Model->db_query("
			                    SELECT A.leave_type, ((A.leave_count + 0) - $leave_taken) AS leaveleft 
			                    FROM leave_master A 
			                    WHERE A.leave_id = ".$type['leave_id']." 
			                    GROUP BY A.leave_id
			                ");
			            } else {
			                $records = $this->Common_Model->db_query("
			                    SELECT A.leave_type, (A.leave_count - $leave_taken) AS leaveleft 
			                    FROM leave_master A 
			                    WHERE A.leave_id = ".$type['leave_id']." 
			                    GROUP BY A.leave_id
			                ");
			            }

			            $leave[$i] = [
			                'leave_type' => $type['leave_type'],
			                'leave_avl'  => $type['leave_count'],
			                'leave_left' => $records[0]['leaveleft'] ?? 0
			            ];
			        }
			    }

			    $datalist = $this->Common_Model->FetchData("leave_application AS l LEFT JOIN leave_master AS lm ON l.leave_type = lm.leave_id", "lm.leave_id, lm.leave_type, lm.leave_count, lm.is_paid, lm.leave_active, l.leave_apply_id, l.employee_id, l.apply_from, l.apply_to, l.no_of_days, l.session, l.leave_status,l.created_on,l.hfday,l.leavereason", "l.employee_id = $employee_id ORDER BY l.created_on DESC");

			    $res = array(
			    	'avl_leave' => $leave,
			    	'leave_list' => $datalist
			    );

			    echo json_encode($res);

			    exit;
			} break;
			
			case "view_attendance" : {
				$data = array();
				$user_id = $_REQUEST['user_id'];
				if (!$user_id) {
			        echo json_encode(['msg' => 'User ID is required']);
			        exit;
			    }
				$emp_data = $this->Common_Model->FetchData("users", "employee_tagged_id", "user_id = $user_id");
				if (!$emp_data) {
			        echo json_encode(['msg' => 'Employee not found']);
			        exit;
			    }
				$emp_id = $emp_data;
				$attendance =  $this->Common_Model->FetchData("emp_attendance","*","employee_id = $emp_id");
				if (!$attendance) {
			        echo json_encode(['msg' => 'No attendance records found']);
			        exit;
			    }
				$res['my_attendance'] = $attendance;
				echo json_encode($res);
			}break;
			
			case "site_visit" : {
				$data = array();
				$enq_id = $_REQUEST['enq_id'];
				$user_id = $_REQUEST['user_id'];
				$data_list = array(			
					
					'enq_id' => $enq_id,
					'user_id' => $user_id,
					'c_name' => $_REQUEST['c_name'],		
					'con_no' => $_REQUEST['con_no'],
					'email' => $_REQUEST['email'],
					'visit_date' => $_REQUEST['visit_date'],
					'time_slot' => $_REQUEST['time_slot'],
					'specific_time' => $_REQUEST['specific_time'],
					'prop_interest' => $_REQUEST['prop_interest'],
					'notes' => $_REQUEST['notes'],
					'request_by' => 'Executive',
					'dateadded' => $this->timestamp
				);
				$this->Common_Model->dbinsertid("site_visit",$data_list);
				$datalist = array(
					'comp_status' => 'Site Visit'
				);
				$this->Common_Model->update_records("lead_enquiry", "enq_id", "$enq_id", 
			  	$datalist);

    		   $response['msg'] =  'Success..!!';
	 		  	echo json_encode($response);
			}break;
			
			case "view_sitevisit" : {
    			$data = array();
    			$id = $_REQUEST['user_id'];
    			$data['view_sitevisit'] = $this->Common_Model->FetchData(
				    "site_visit as s LEFT JOIN lead_enquiry as l ON s.enq_id = l.enq_id", 
				    "s.*,l.comp_status", 
				    "user_id = " . $id . " AND l.comp_status = 'Site Visit' ORDER BY s.sid DESC"
				);
                if($data['view_sitevisit']) {
	 		   	$data['total_sitevisit_leads'] = count($data['view_sitevisit']);
	 		   }
    			echo json_encode($data);
    		}break;
    		
    		case "edit_site_visit" : {
    			$data = array();
				$enq_id = $_REQUEST['enq_id'];
				$user_id = $_REQUEST['user_id'];
				$data_list = array(			
					
					'c_name' => $_REQUEST['c_name'],		
					'con_no' => $_REQUEST['con_no'],
					'email' => $_REQUEST['email'],
					'visit_date' => $_REQUEST['visit_date'],
					'time_slot' => $_REQUEST['time_slot'],
					'specific_time' => $_REQUEST['specific_time'],
					'prop_interest' => $_REQUEST['prop_interest'],
					'notes' => $_REQUEST['notes'],
					
					'updated_on' => $this->timestamp
				);
				$this->Common_Model->update_records("site_visit","enq_id","$enq_id",$data_list);
				

    		   $response['msg'] =  'Success..!!';
	 		  	echo json_encode($response);

    		}break;
    		
    		case "delete_site_visit" : {
	 		  	$data = array();
	 		  	$id = $_REQUEST['enq_id'];
	 		    $this->Common_Model->DelData("site_visit", "enq_id = '$id'");
	 		       $data_list=array(
					'comp_status' => 'Delete',
					'reason' => $_REQUEST['reason'],
					'delete_date' => date('Y-m-d H:i:s')
				   );
	 		    $this->Common_Model->update_records("lead_enquiry","enq_id",$id, $data_list);
	 		    $data['msg'] =  'Success..!!';
	 		  	echo json_encode($data);
	 		}break;

		}
	}
}





