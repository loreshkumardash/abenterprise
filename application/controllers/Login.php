<?php
error_reporting(0);
defined('BASEPATH') OR exit('No direct script access allowed');
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
class Login extends CI_Controller {

	public function __construct(){
		parent::__construct();
				
		$this->CandidateKey 		= makeCandidateKey(); 
		//$this->DisclaimerContent 	= Disclaimer(); 
		$this->authorisepin 		= generatePIN();

		date_default_timezone_set("Asia/Kolkata"); 
		$this->present_date 		= date('Y-m-d');
		$this->present_time 		= date('H:i:a');
		$this->timestamp 			= date('Y-m-d H:i:s');
		$this->browsers        		= get_browsername();
	}
	
	public function index()
	{
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		
		$sess_id = $this->session->userdata('u_id');
        if(!empty($sess_id)){
			redirect('dashboard');
		}
		if($this->input->post('submitBtn'))
		{
			date_default_timezone_set("Asia/Kolkata");
			$IP = getenv("REMOTE_ADDR");
			$browser = $_SERVER['HTTP_USER_AGENT'];

			$todaydate = date('Y-m-d H:i:s');
			$username = strip_tags(stripslashes($this->input->post('sesusername')));
			$password = $this->input->post('sespassword');
			$userdata = $this->Common_Model->FetchData("users", "*", "username = '".$username."' AND password = '".$password."' AND userstatus = 1");
			if($userdata){
              	/*if ($userdata[0]['usertype']=='Others') {
						redirect('login');
					}*/
				$data_list = array(
					'last_login_on'     => $todaydate,
					'last_login_ip'		=> $IP
				);
				$this->Common_Model->update_records("users", "user_id", $userdata[0]['user_id'], $data_list);
				$data_list = array(
					'user_id'     		=> $userdata[0]['user_id'],
					'ipaddress'			=> $IP,
					'logindatetime'		=> $todaydate,
					'browser'			=> $browser
				); 
				$this->Common_Model->dbinsertid("users_login_history", $data_list);
				$user_details = $userdata[0];
				$this->session->set_userdata($user_details);
				$access = $this->Common_Model->FetchData("menu_access", "*", "access_id = '".$userdata[0]['access_id']."'");
				$this->session->set_userdata('access_menus', $access[0]);
				$sessions = $this->Common_Model->FetchData("sessions", "*", "active_session = 'Active'");
				$this->session->set_userdata($sessions[0]);
				$this->session->set_userdata(array("wrongattempt" => 0));
				redirect('dashboard');
			}else{
				$wrongattempt = $this->session->userdata('wrongattempt') + 1;
				$this->session->set_userdata(array("wrongattempt" => $wrongattempt));

				$attempt = $this->session->userdata('wrongattempt');

				if($attempt >= 100){
					$blocked_untill = date("Y-m-d H:i:s", strtotime('+2 hours', strtotime(date("Y-m-d H:i:s"))));
					$this->Common_Model->db_query("INSERT INTO blocked_ip SET ipaddress = '".$IP."', blocked_untill = '$blocked_untill'");
					$this->session->set_flashdata('error', 'The username/password combination is not correct, please try again !!');
				}else{
					$txt = 100 - $attempt;
					$this->session->set_flashdata('error', 'The username/password combination is not correct, please try again !! '.$txt. " attempts left.");	
				}
				
				redirect('login');
			}
		}
		$data['blocked'] = $this->Common_Model->FetchRows("blocked_ip", "*", "ipaddress = '".$_SERVER['REMOTE_ADDR']."' AND blocked_untill > '".date("Y-m-d H:i:s")."'");
		$this->load->view('login', $data);
	}
	function logout(){
	    array();
		if($this->session->userdata('user_id') > 0){
		$userdata = $this->Common_Model->FetchData("users","*","user_id=".$this->session->userdata('user_id')."");
		
		$this->Common_Model->db_query("UPDATE users_login_history SET logoutdatetime = '".date('Y-m-d H:i:s')."' WHERE user_id = ".$this->session->userdata('user_id')." AND logindatetime='".$userdata[0]['last_login_on']."'");
		}
		$this->session->sess_destroy();
		redirect('login');
	}
	
// 	function sendotp(){
// 		if($this->session->userdata("otp")){
// 			//echo $this->session->userdata("otp");exit;
// 			$username = strip_tags(stripslashes($this->input->post('sesusername')));
// 			$password = $this->input->post('sespassword');
// 		}else{
// 			$username = strip_tags(stripslashes($this->input->post('username')));
// 			$password = md5($this->input->post('password'));
// 		}
// 		$userdata = $this->Common_Model->FetchData("users", "*", "username = '".$username."' AND password = '".$password."' AND userstatus = 1");

//         $otp = random_int(100000, 999999);
//         $otp_datetime   = date('Y-m-d H:i:s');
        
//         $query6 = "SELECT * FROM mail ";
// 			 $result6 = $this->Common_Model->db_query($query6);
// 			 $row6 = $result6[0];
// 			  $emaill=$row6['email'];
// 			  $passl=$row6['pass'];
// 	if ($userdata) {
// 		// if($userdata[0]['useremail'] == 'subhabishnu98@gmail.com'){
// 		if($userdata[0]['useremail'] == 'rojalinpanda40701@gmail.com'){
// 			date_default_timezone_set("Asia/Kolkata");
// 			$IP = getenv("REMOTE_ADDR");
// 			$browser = $_SERVER['HTTP_USER_AGENT'];

// 			$todaydate = date('Y-m-d H:i:s');
// 			$data_list = array(
// 					'last_login_on'     => $todaydate,
// 					'last_login_ip'		=> $IP
// 				);
// 				$this->Common_Model->update_records("users", "user_id", $userdata[0]['user_id'], $data_list);
// 				$data_list = array(
// 					'user_id'     		=> $userdata[0]['user_id'],
// 					'ipaddress'			=> $IP,
// 					'logindatetime'		=> $todaydate,
// 					'browser'			=> $browser
// 				); 
// 				$this->Common_Model->dbinsertid("users_login_history", $data_list);
// 				$user_details = $userdata[0];
// 				$this->session->set_userdata($user_details);
// 				$access = $this->Common_Model->FetchData("menu_access", "*", "access_id = '".$userdata[0]['access_id']."'");
// 				$this->session->set_userdata($access[0]);
// 				$sessions = $this->Common_Model->FetchData("sessions", "*", "active_session = 'Active'");
// 				$this->session->set_userdata($sessions[0]);
// 				$this->session->set_userdata(array("wrongattempt" => 0));
// 				redirect('dashboard');
// 		}
// 	    require 'vendor/PHPMailer/src/Exception.php';
//         require 'vendor/PHPMailer/src/PHPMailer.php';
//         require 'vendor/PHPMailer/src/SMTP.php';
      
//         $mail = new PHPMailer(true);

      
//             try {
//                 //Server settings
//                 $mail->isSMTP();                                            //Send using SMTP
//                 $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
//                 $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
//                 $mail->Username   = $emaill;                     //SMTP username
//                 $mail->Password   = $passl;                               //SMTP password
//                 $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            //Enable implicit TLS encryption
//                 $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS

//                 //Recipients
//                 $mail->setFrom($emaill, 'Glosent');
//                 $recipients = [$userdata[0]['useremail']];
//                 foreach ($recipients as $recipient) {
//                     $mail->addAddress($recipient);
//                 }
//                 //$mail->addAddress($email, 'User');     //Add a recipient
//                 $mail->addReplyTo($emaill, 'Glosent');


//                 //Content
//                 $mail->isHTML(true);                                  //Set email format to HTML
//                 $mail->Subject = 'OTP Verification';
//                 $mail->Body    = "Dear User,<br><br>

// 								To complete the verification process for your account, please use the One-Time Password (OTP) provided below. This step helps ensure the security of your account and protects your personal information.
// 								<br><br>
// 								Your OTP is: ".$otp."
// 								<br><br>
// 								Please note:
// 								<br><br>
// 								This OTP is valid for the next 15 minutes.<br>
// 								Do not share this OTP with anyone.<br>
// 								If you did not request this verification, please disregard this email and contact our support team immediately.<br>
// 								Thank you for taking steps to keep your account secure.
// 								<br><br>
// 								Best regards,<br>
// 								GLOSENT<br>
// 								Mob. : +91 97654 97655, Email : operations@glosent.in";

//                 $mail->send();
//               $arrResult = array('response' => 'success');
//             } catch (Exception $e) {
//                 $arrResult = array('response' => "Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
                
//             }


//                 $this->session->set_userdata(array("username" => $username, "password" => $password, "otp_datetime" => $otp_datetime, "otp" => $otp));
//                 if ($this->input->post("resendBtn")) {
//                 	$this->session->set_flashdata('success', 'OTP re-send successfully.');
//                 }
//             }else{
//                 $this->session->set_flashdata('error', 'Wrong Username/Password, please try again !! ');
              
//             }

//             redirect($_SERVER['HTTP_REFERER']);
// 	}
    function sendotp(){
		
			$username = strip_tags(stripslashes($this->input->post('username')));
			$password = md5($this->input->post('password'));
		
		$userdata = $this->Common_Model->FetchData("users", "*", "username = '".$username."' AND password = '".$password."' AND userstatus = 1");

        
		if ($userdata) {
		
			date_default_timezone_set("Asia/Kolkata");
			$IP = getenv("REMOTE_ADDR");
			$browser = $_SERVER['HTTP_USER_AGENT'];

			$todaydate = date('Y-m-d H:i:s');
			$data_list = array(
					'last_login_on'     => $todaydate,
					'last_login_ip'		=> $IP
				);
				$this->Common_Model->update_records("users", "user_id", $userdata[0]['user_id'], $data_list);
				$data_list = array(
					'user_id'     		=> $userdata[0]['user_id'],
					'ipaddress'			=> $IP,
					'logindatetime'		=> $todaydate,
					'browser'			=> $browser
				); 
				$this->Common_Model->dbinsertid("users_login_history", $data_list);
				$user_details = $userdata[0];
				$this->session->set_userdata($user_details);
				$access = $this->Common_Model->FetchData("menu_access", "*", "access_id = '".$userdata[0]['access_id']."'");
				$this->session->set_userdata($access[0]);
				$sessions = $this->Common_Model->FetchData("sessions", "*", "active_session = 'Active'");
				$this->session->set_userdata($sessions[0]);
				$this->session->set_userdata(array("wrongattempt" => 0));
				redirect('dashboard');
		 }
	    

            redirect($_SERVER['HTTP_REFERER']);
	}
	
	function userloginhistory(){
		error_reporting(0);
		array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$data['per_page'] = $per_page = isset($_REQUEST['per_page']) ? $_REQUEST['per_page'] : 100;
		$data['page'] = $page = isset($_REQUEST['page']) ? $_REQUEST['page'] : '1';
		$this->load->helper('url');
		$currentURL = current_url();
		$sql = "1";
		
		$urlvars = '';
		
		if(isset($_REQUEST['user_id']) && $_REQUEST['user_id'] != ''){
			$sql.= " AND a.user_id = '".$_REQUEST['user_id']."'";
			$urlvars.= "&user_id=".$_REQUEST['user_id'];
		}

		

			if(isset($_REQUEST['from_date']) && $_REQUEST['from_date'] != ''){
				$sql.= " AND a.logindatetime >= '".$_REQUEST['from_date']."'";
				$urlvars.= "&logindatetime=".$_REQUEST['from_date'];
			}

			if(isset($_REQUEST['to_date']) && $_REQUEST['to_date'] != ''){
				$sql.= " AND a.logoutdatetime <= '".$_REQUEST['to_date']."'";
				$urlvars.= "&logoutdatetime=".$_REQUEST['to_date'];
			}
	

		$sSql = "SELECT COUNT(*) as num FROM users_login_history as a WHERE $sql order by id desc";
		$records = $this->Common_Model->db_query($sSql);
		$totalrecords = $records[0]['num'];
		if($totalrecords){
			$sSql = "SELECT * FROM users_login_history as a LEFT JOIN users as b on a.user_id=b.user_id WHERE $sql ORDER BY a.id DESC";
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
		$data['user'] = $user= $this->Common_Model->FetchData("users","*","1 order by user_id ASC");

		if ($this->input->post("downloadBtn")) {
			$user_id = $this->input->post("user_id");
			$from_date = $this->input->post("from_date");
			$to_date = $this->input->post("to_date");

		if ($user_id != '') {
			$loginrecords = $this->Common_Model->FetchData("users_login_history as a LEFT JOIN users as b on a.user_id=b.user_id","*","a.user_id='".$user_id."' AND a.logindatetime >='".$from_date."' AND a.logindatetime <='".$to_date."' order by a.logindatetime DESC");

			
				
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		// Set document properties
		$spreadsheet->getProperties()->setCreator('opjsa')
					->setLastModifiedBy($this->session->userdata('firstname').' '.$this->session->userdata('lastname'))
					->setTitle('login Report')
					->setSubject('login Report')
					->setDescription('login Report');
		// add style to the header
		$styleArray = array(
			'font' => array(
				'bold' => true,
			),
			'alignment' => array(
				'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
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
		$cellstyleArray1 = array(
			'alignment' => array(
				'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
				'vertical'   => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
			),
			'borders' => array(
				'allBorders' => [
		            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
		            'color' => ['rgb' => '333333'],
		        ],
			)
		);

		$cellstyleArray = array(
			'borders' => array(
				'allBorders' => [
		            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
		            'color' => ['rgb' => '333333'],
		        ],
			)
		);
		$spreadsheet->getActiveSheet()->getStyle('A1:D1')->applyFromArray($styleArray);
		// auto fit column to content
		foreach(range('A', 'D') as $columnID) {
			$spreadsheet->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
		}

		$sheet->setCellValue('A1', 'User ID');
		$sheet->setCellValue('B1', 'User Name');		
		$sheet->setCellValue('C1', 'Login Time');
		$sheet->setCellValue('D1', 'Logout Time');		
		
		
		$x = 2;
		if($loginrecords){
			for($i=0;$i<count($loginrecords);$i++){
				$logindatetime = $loginrecords[$i]['logindatetime'] == '0000-00-00' || $loginrecords[$i]['logindatetime'] == '' ? '' : date("d-m-Y H:i:s", strtotime($loginrecords[$i]['logindatetime']));
				$logoutdatetime = $loginrecords[$i]['logoutdatetime'] == '0000-00-00' || $loginrecords[$i]['logoutdatetime'] == '' ? '' : date("d-m-Y H:i:s", strtotime($loginrecords[$i]['logoutdatetime']));

				$username = $loginrecords[$i]['firstname'].' '.$loginrecords[$i]['lastname'];
				$spreadsheet->getActiveSheet()->getRowDimension($x)->setRowHeight(17);
				$writer = new Xlsx($spreadsheet);
				$sheet->setCellValue('A'.$x, $loginrecords[$i]['user_id']);
				$sheet->setCellValue('B'.$x, $username);
				$sheet->setCellValue('C'.$x, $logindatetime);
				$sheet->setCellValue('D'.$x, $logoutdatetime);
								
				$x++;
			}
		}
		$x--;
		$spreadsheet->getActiveSheet()->getStyle('O1:O'.$spreadsheet->getActiveSheet()->getHighestRow())->getAlignment()->setWrapText(true); 
		$spreadsheet->getActiveSheet()->getStyle('P1:P'.$spreadsheet->getActiveSheet()->getHighestRow())->getAlignment()->setWrapText(true); 
		
		$spreadsheet->getActiveSheet()->getStyle('A2:D'.$x)->applyFromArray($cellstyleArray);
		$writer = new Xlsx($spreadsheet);
		header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="User_login_History_data.xlsx"');
        $writer->save('php://output');
        exit;
				
			

		}else{

		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		// Set document properties
		$spreadsheet->getProperties()->setCreator('opjsa')
					->setLastModifiedBy($this->session->userdata('firstname').' '.$this->session->userdata('lastname'))
					->setTitle('login Report')
					->setSubject('login Report')
					->setDescription('login Report');
		// add style to the header
		$styleArray = array(
			'font' => array(
				'bold' => true,
			),
			'alignment' => array(
				'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
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
		$cellstyleArray1 = array(
			'alignment' => array(
				'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
				'vertical'   => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
			),
			'borders' => array(
				'allBorders' => [
		            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
		            'color' => ['rgb' => '333333'],
		        ],
			)
		);

		$cellstyleArray = array(
			'borders' => array(
				'allBorders' => [
		            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
		            'color' => ['rgb' => '333333'],
		        ],
			)
		);
		$spreadsheet->getActiveSheet()->getStyle('A1:D1')->applyFromArray($styleArray);
		// auto fit column to content
		foreach(range('A', 'D') as $columnID) {
			$spreadsheet->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
		}

		$sheet->setCellValue('A1', 'User ID');
		$sheet->setCellValue('B1', 'User Name');		
		$sheet->setCellValue('C1', 'Login Time');
		$sheet->setCellValue('D1', 'Logout Time');		
		
		
		$x = 2;
			if ($user) { for ($a=0; $a <count($user) ; $a++) { 
				$loginrecords = $this->Common_Model->FetchData("users_login_history as a LEFT JOIN users as b on a.user_id=b.user_id","*","a.user_id='".$user[$a]['user_id']."' AND a.logindatetime >='".$from_date."' AND a.logindatetime <='".$to_date."' order by a.logindatetime DESC");

				if($loginrecords){
						for($i=0;$i<count($loginrecords);$i++){
							$logindatetime = $loginrecords[$i]['logindatetime'] == '0000-00-00' || $loginrecords[$i]['logindatetime'] == '' ? '' : date("d-m-Y H:i:s", strtotime($loginrecords[$i]['logindatetime']));
							$logoutdatetime = $loginrecords[$i]['logoutdatetime'] == '0000-00-00' || $loginrecords[$i]['logoutdatetime'] == '' ? '' : date("d-m-Y H:i:s", strtotime($loginrecords[$i]['logoutdatetime']));
							$username = $loginrecords[$i]['firstname'].' '.$loginrecords[$i]['lastname'];
							$spreadsheet->getActiveSheet()->getRowDimension($x)->setRowHeight(17);
							$writer = new Xlsx($spreadsheet);
							$sheet->setCellValue('A'.$x, $loginrecords[$i]['user_id']);
							$sheet->setCellValue('B'.$x, $username);
							$sheet->setCellValue('C'.$x, $logindatetime);
							$sheet->setCellValue('D'.$x, $logoutdatetime);
											
							$x++;
						}
					}

			}
				
			}
			$x--;
		$spreadsheet->getActiveSheet()->getStyle('O1:O'.$spreadsheet->getActiveSheet()->getHighestRow())->getAlignment()->setWrapText(true); 
		$spreadsheet->getActiveSheet()->getStyle('P1:P'.$spreadsheet->getActiveSheet()->getHighestRow())->getAlignment()->setWrapText(true); 
		
		$spreadsheet->getActiveSheet()->getStyle('A2:D'.$x)->applyFromArray($cellstyleArray);
		$writer = new Xlsx($spreadsheet);
		header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="User_login_History_data.xlsx"');
        $writer->save('php://output');
        exit;
		}
			
		}
		/*$data['history'] = $this->Common_Model->FetchData("users_login_history as a LEFT JOIN users as b on a.user_id=b.user_id","*","1 order by id desc");*/

		

		$data['activesubmenu'] = 'userloginhistory';
		$this->load->view('userloginhistory', $data);
	}

	
}

