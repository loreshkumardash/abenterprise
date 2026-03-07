<?php
error_reporting(0);
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {

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
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$data['activemenu'] = 'users';
		$data['activesubmenu'] = 'users';
		$this->load->view('dashboard', $data);
	}

	public function add_menu_access()
	{
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		if($this->input->post('submitBtn')){
			$this->form_validation->set_rules('access_name', 'Access Name', 'trim|required|is_unique[menu_access.access_name]');
			$this->form_validation->set_error_delimiters('<p class="has-error"><label class="control-label">', '</label></p>');
			if($this->form_validation->run()){
				$data_list = array(
					'access_name'         	=> ucwords($this->input->post('access_name')),
					'access_menus'		=> json_encode($this->input->post('menu_access[]'))
				);
				$id = $this->Common_Model->dbinsertid("menu_access", $data_list);
				$this->session->set_flashdata('success', 'User Access Added successfully.' );
				redirect('users/list_menu_access');
			}else{
				$this->session->set_flashdata('error', validation_errors());
			}
		}
		$data['activemenu'] = 'users';
		$data['activesubmenu'] = 'add_menu_access';
		$this->load->view('users/add_menu_access', $data);
	}

	public function edit_menu_access($access_id = 0)
	{
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		if($this->input->post('submitBtn')){
			$this->form_validation->set_rules('access_name', 'Access Name', 'trim|required');
			$this->form_validation->set_error_delimiters('<p class="has-error"><label class="control-label">', '</label></p>');
			if($this->form_validation->run()){
				$data_list = array(
					'access_name'         	=> ucwords($this->input->post('access_name')),
					'access_menus'		=> json_encode($this->input->post('menu_access[]'))
				);
				$this->Common_Model->update_records("menu_access", "access_id", $access_id, $data_list);
				$this->session->set_flashdata('success', 'User Access Updated successfully.' );
				redirect('users/list_menu_access');
			}else{
				$this->session->set_flashdata('error', validation_errors());
			}
		}
		$data['activemenu'] = 'users';
		$data['activesubmenu'] = 'list_menu_access';
		$data['access'] = $this->Common_Model->FetchData("menu_access", "*", "access_id = $access_id");
		$this->load->view('users/edit_menu_access', $data);
	}

	function list_menu_access(){
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$data['activemenu'] = 'users';
		$data['activesubmenu'] = 'list_menu_access';
		$data['access'] = $this->Common_Model->FetchData("menu_access", "*", "1");
		$this->load->view('users/list_menu_access', $data);
	}

	function delete_menu_access($access_id = 0){
		$this->Common_Model->DelData("menu_access", "access_id = ".$access_id);
		$this->session->set_flashdata('success', 'Record deleted successfully.' );
		redirect($_SERVER['HTTP_REFERER']);
	}

	public function adduser($empoyeeId = 0)
	{
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		if($this->input->post('submitBtn')){
			$this->form_validation->set_rules('username', 'Username', 'trim|required|is_unique[users.username]');
			$this->form_validation->set_rules('useremail', 'Email', 'trim|required|is_unique[users.username]');
			$this->form_validation->set_rules('firstname', 'First Name', 'trim|required');
			$this->form_validation->set_rules('lastname', 'Last Name', 'trim|required');
			$this->form_validation->set_rules('userphone', 'Mobile', 'trim|required');
			$this->form_validation->set_error_delimiters('<p class="has-error"><label class="control-label">', '</label></p>');
			if($this->form_validation->run()){
				$data_list = array(
					'firstname'         => ucwords($this->input->post('firstname')),
					'lastname'          => ucwords($this->input->post('lastname')),
					'useremail'         => strtolower($this->input->post('useremail')),
					'userphone'			=> $this->input->post('userphone'),
					'username'			=> strtolower($this->input->post('username')),
					'password'			=> md5($this->input->post('password')),
					'usertype'			=> $this->input->post('usertype'),
					'access_id'			=> $this->input->post('access_id'),
					'created_on'		=> date('Y-m-d H:i:s'),
					'userstatus'		=> $this->input->post('userstatus'),
					'usercategory'		=> $this->input->post('usercategory'),
					'employee_tagged_id'=> $this->input->post('empoyeeId')
				);
				$id = $this->Common_Model->dbinsertid("users", $data_list);
				$this->session->set_flashdata('success', 'User Added successfully.' );
				redirect('users/listuser');
			}else{
				$this->session->set_flashdata('error', validation_errors());
			}
		}
		if($empoyeeId > 0){
			$data['empData'] = $this->Common_Model->FetchData("employees", "*", "employee_id = $empoyeeId");
		}else{
			$data['empData'] = array();
		}
		$data['activemenu'] = 'users';
		$data['activesubmenu'] = 'adduser';
		$data['access'] = $this->Common_Model->FetchData("menu_access", "*", "1");
		$this->load->view('users/adduser', $data);
	}

	public function listuser()
	{
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$data['per_page'] = $per_page = isset($_REQUEST['per_page']) ? $_REQUEST['per_page'] : 10;
		$data['page'] = $page = isset($_REQUEST['page']) ? $_REQUEST['page'] : '1';
		$this->load->helper('url');
		$currentURL = current_url();
		if($this->session->userdata('usertype')=='Admin'){
		    $sql = "1";
		}else{
		    $sql = "usertype!='Admin'";
		}
		
		
		$urlvars = '';
		
		if(isset($_REQUEST['username']) && $_REQUEST['username'] != ''){
			$sql.= " AND username LIKE '%".$_REQUEST['username']."%'";
			$urlvars.= "&username=".$_REQUEST['username'];
		}

		if(isset($_REQUEST['firstname']) && $_REQUEST['firstname'] != ''){
			$sql.= " AND firstname LIKE '%".$_REQUEST['firstname']."%'";
			$urlvars.= "&firstname=".$_REQUEST['firstname'];
		}

		if(isset($_REQUEST['lastname']) && $_REQUEST['lastname'] != ''){
			$sql.= " AND lastname LIKE '%".$_REQUEST['lastname']."%'";
			$urlvars.= "&lastname=".$_REQUEST['lastname'];
		}
		
		if(isset($_REQUEST['useremail']) && $_REQUEST['useremail'] != ''){
			$sql.= " AND useremail LIKE '%".$_REQUEST['useremail']."%'";
			$urlvars.= "&useremail=".$_REQUEST['useremail'];
		}

		$sSql = "SELECT COUNT(*) as num FROM users WHERE $sql";
		//echo $sSql;exit;
		$records = $this->Common_Model->db_query($sSql);
		$totalrecords = $records[0]['num'];
		if($totalrecords){
			$sSql = "SELECT * FROM users WHERE $sql ORDER BY user_id DESC";
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

		$data['activemenu'] = 'users';
		$data['activesubmenu'] = 'listuser';
		$data['access'] = $this->Common_Model->FetchData("menu_access", "*", "1");
		$this->load->view('users/listuser', $data);
	}

	function listuserAjax(){
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$this->perPage = 10;
		$page = $this->input->post('page');
        if(!$page){
            $offset = 0;
        }else{
            $offset = $page;
        }
		$sql = "usertype!='Admin'";
		$param = array();
		if(isset($_POST['username']) && $_POST['username']!=''){
			$sql.= " AND username LIKE '%".$_POST['username']."%'";
			$param['username'] = $_POST['username'];
		}
		if(isset($_POST['firstname']) && $_POST['firstname']!=''){
			$sql.= " AND firstname LIKE '%".$_POST['firstname']."%'";
			$param['firstname'] = $_POST['firstname'];
		}
		if(isset($_POST['lastname']) && $_POST['lastname']!=''){
			$sql.= " AND lastname LIKE '%".$_POST['lastname']."%'";
			$param['lastname'] = $_POST['lastname'];
		}
		if(isset($_POST['useremail']) && $_POST['useremail']!=''){
			$sql.= " AND useremail LIKE '%".$_POST['useremail']."%'";
			$param['useremail'] = $_POST['useremail'];
		}
		$rows = $this->Common_Model->FetchPaginationRows("users", "*", "$sql ORDER BY user_id DESC", array());
		$datalist = $this->Common_Model->FetchPaginationData("users", "*", "$sql ORDER BY user_id DESC", array('start' => $offset, 'limit'=>$this->perPage));

        $config['first_link']  = 'First';
        $config['div']         = 'dataTablediv';
        $config['base_url']    = base_url().'index.php/users/listuserAjax';
        $config['total_rows']  = $rows;
        $config['per_page']    = $this->perPage;
		$config['param_ar']    = $param;
        $this->ajax_pagination->initialize($config);
		
		$data['records'] = $datalist;
		$data['activemenu'] = 'users';
		$data['activesubmenu'] = 'listuser';
		$this->load->view('users/listuserAjax', $data);
	}

	function edituser($user_id = 0){
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		if($this->input->post('submitBtn')){
			$this->form_validation->set_rules('username', 'Username', 'trim|required');
			$this->form_validation->set_rules('useremail', 'Email', 'trim|required');
			$this->form_validation->set_rules('firstname', 'First Name', 'trim|required');
			$this->form_validation->set_rules('lastname', 'Last Name', 'trim|required');
			$this->form_validation->set_rules('userphone', 'Mobile', 'trim|required');
			$this->form_validation->set_error_delimiters('<p class="has-error"><label class="control-label">', '</label></p>');
			if($this->form_validation->run()){
				$data_list = array(
					'firstname'         => ucwords($this->input->post('firstname')),
					'lastname'          => ucwords($this->input->post('lastname')),
					'useremail'         => strtolower($this->input->post('useremail')),
					'userphone'			=> $this->input->post('userphone'),
					'username'			=> strtolower($this->input->post('username')),
					'usertype'			=> $this->input->post('usertype'),
					'access_id'			=> $this->input->post('access_id'),
					'usercategory'		=> $this->input->post('usercategory'),
					'userstatus'		=> $this->input->post('userstatus')
				);
				if($this->input->post("password") != ''){
					$emp_tagId = '';
					$data_list['password'] = md5($this->input->post('password'));
					$datalist['view_psw']  = $this->input->post('password');
				     if($this->input->post('etag_id')){
					$emp_tagId  = $this->input->post('etag_id');
				     } 
				}
				$id = $this->Common_Model->update_records("users", "user_id", $user_id, $data_list);
			       if($emp_tagId){
					$emp_id = $this->Common_Model->update_records("employees", "employee_id", $emp_tagId, $datalist);
			       }
				
//echo $emp_id;exit;
				$this->session->set_flashdata('success', 'User Added successfully.' );
				redirect('users/listuser');
			}else{
				$this->session->set_flashdata('error', validation_errors());
			}
		}
		$data['user'] = $this->Common_Model->FetchData("users", "*", "user_id = $user_id");
		$data['activemenu'] = 'users';
		$data['activesubmenu'] = 'listuser';
		$data['access'] = $this->Common_Model->FetchData("menu_access", "*", "1");
		$this->load->view('users/edituser', $data);
	}

	function deleteuser($user_id = 0){
		$this->Common_Model->DelData("users", "user_id = ".$user_id);
		$this->session->set_flashdata('success', 'Record deleted successfully.' );
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	function usersattendance($user_id=0,$month=0,$year=0){
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$data['user_id'] = $user_id;
		$data['month'] = $month;
		$data['year'] = $year;

		$data['activemenu'] = 'users';
		$data['activesubmenu'] = 'usersattendance';
		$data['user'] = $this->Common_Model->FetchData("users", "*", "usercategory='1' ORDER BY firstname ASC");
		$this->load->view('users/usersattendance', $data);
	}

	function downloaduserattendance(){

			$data['user_id'] = $this->input->post('user_id');
			$data['log_date'] = $this->input->post('log_date');


		$html = $this->load->view('users/printuserattendance', $data, TRUE);
		$this->load->library('Pdf');
		$pdf = new Pdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('TFMS');
		$pdf->SetTitle('TFMS');
		$pdf->SetSubject('TFMS');

		$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
		$pdf->setHeaderData($ln='technofulllogo.png', $lw=70, $ht='', $hs='', $tc=array(0,0,0), $lc=array(0,0,0));
		$pdf->setFooterData(array(0, 0, 0), array(0,64,328));
		$pdf->SetMargins(10, 10, 10, true);
		$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
		$pdf->SetAutoPageBreak(TRUE, 10);
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

		$pdf->AddPage('L', 'A4', true, true);
		$pdf->SetMargins(10, 10, 10, true);
		$pdf->SetFont('helvetica', '', 8);
		$pdf->setFontSubsetting(false);
		$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
		date_default_timezone_set("Asia/Kolkata");
		$filename = 'User Attendance'.date("YmdHis").'.pdf';
		$pdf->Output($filename, 'I');
		
	}

	function get_userAttendance(){
		$user_id = $this->input->post('user_id');
		$log_date = $this->input->post('log_date');
		
		$html='';
		if (!empty($user_id)) {
				$rec1 = $this->Common_Model->FetchData("user_attendance_log","*","log_date='".$log_date."' AND user_id=".$user_id." AND status='1'");
				$rec2 = $this->Common_Model->FetchData("user_attendance_log","*","log_date='".$log_date."' AND user_id=".$user_id." AND status='2'");
				$user = $this->Common_Model->FetchData("users", "*", "user_id=".$user_id."");
				if ($rec1) {
					$checkin = date('d-m-Y H:i:s',strtotime($rec1[0]['log_datetime']));
				}else{
					$checkin = '';
				}

				if ($rec2) {
					$checkout = date('d-m-Y H:i:s',strtotime($rec2[0]['log_datetime']));
				}else{
					$checkout = '';
				}

				if (!empty($rec1) && !empty($rec2)) {
					$status = 'Present';
				}else{
					$status = 'Absent';
				}
				$html.='<tr><td>1</td><td>'.$user[0]['user_id'].'</td><td>'.$user[0]['firstname'].' '.$user[0]['lastname'].'</td><td>'.$log_date.'</td><td>'.$checkin.'</td><td>'.$checkout.'</td><td>'.$status.'</td></tr>';
		}else{
			$users = $this->Common_Model->FetchData("users", "*", "usercategory='1' AND usertype !='Others' ORDER BY firstname ASC");
			if ($users) { for ($i=0; $i <count($users) ; $i++) { 
				$rec1 = $this->Common_Model->FetchData("user_attendance_log","*","log_date='".$log_date."' AND user_id=".$users[$i]['user_id']." AND status='1'");
				$rec2 = $this->Common_Model->FetchData("user_attendance_log","*","log_date='".$log_date."' AND user_id=".$users[$i]['user_id']." AND status='2'");

				if ($rec1) {
					$checkin = date('d-m-Y H:i:s',strtotime($rec1[0]['log_datetime']));
				}else{
					$checkin = '';
				}

				if ($rec2) {
					$checkout = date('d-m-Y H:i:s',strtotime($rec2[0]['log_datetime']));
				}else{
					$checkout = '';
				}

				if (!empty($rec1) && !empty($rec2)) {
					$status = 'Present';
				}else{
					$status = 'Absent';
				}
				$html.='<tr><td>'.($i+1).'</td><td>'.$users[$i]['user_id'].'</td><td>'.$users[$i]['firstname'].' '.$users[$i]['lastname'].'</td><td>'.$log_date.'</td><td>'.$checkin.'</td><td>'.$checkout.'</td><td>'.$status.'</td></tr>';
			}}
			
		}
		echo $html;exit;

	}

	function trackingaccess(){
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));

		if($this->input->post('submitBtn')){

			$this->form_validation->set_rules('user_id', 'User', 'trim|required');
			$this->form_validation->set_error_delimiters('<p class="has-error"><label class="control-label">', '</label></p>');
			if($this->form_validation->run()){
				$data_list = array(
					'access_userid'     => $this->input->post('user_id'),
					'tracking_access'	=> json_encode($this->input->post('tracking_access[]'))
				);
				if ($this->input->post('access_tracking_id') > 0) {
					 $this->Common_Model->update_records("access_tracking","access_tracking_id",$this->input->post('access_tracking_id'), $data_list);
				}else{
					$id = $this->Common_Model->dbinsertid("access_tracking", $data_list);
				}
				
				$this->session->set_flashdata('success', 'Tracking Access Added successfully.' );
				redirect('users/trackingaccess');
			}else{
				$this->session->set_flashdata('error', validation_errors());
			}
		}
		
		if(isset($_REQUEST['user_id']) && $_REQUEST['user_id'] > 0){
			$data['records'] = $this->Common_Model->FetchData("access_tracking","*","access_userid=".$_REQUEST['user_id']);
			$data['user'] = $this->Common_Model->FetchData("users","*","user_id=".$_REQUEST['user_id']);

			$html = $this->load->view('users/pdf_trackingassign', $data, TRUE);
			$this->load->library('Pdf');
			$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
			$pdf->SetCreator(PDF_CREATOR);
			$pdf->SetAuthor('Glosent');
			$pdf->SetTitle('Employee Assign');
			$pdf->SetSubject('Employee Assign');

			$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
			$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
			$pdf->setHeaderData($ln='glosent_logo.png', $lw=15, $ht='', $hs='', $tc=array(0,0,0), $lc=array(0,0,0));
			$pdf->setFooterData(array(0, 0, 0), array(0,64,328));
			$pdf->SetMargins(5, 22, 5, true);
			$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
			$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

			$pdf->SetAutoPageBreak(TRUE, 17);
			// set image scale factor
			$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
			$pdf->AddPage('P', 'A4', true, true);

			$pdf->SetMargins(5, 22, 5, true);

			$pdf->SetFont('helvetica', '', 9);

			$pdf->setFontSubsetting(false);
			$pdf->writeHTML($html, true, false, false, false, '');
			date_default_timezone_set("Asia/Kolkata");
			$filename = 'Assign Report-'.date("YmdHis").'.pdf';
			$pdf->Output($filename, 'I');
		}

		$data['activemenu'] = 'users';
		$data['activesubmenu'] = 'trackingaccess';
		$data['user'] = $this->Common_Model->FetchData("users", "*", "access_id > 0 ORDER BY firstname ASC");
		$this->load->view('users/trackingaccess', $data);
	}

	function get_trackingAccess(){
		$user_id = $this->input->post('user_id');
		$records = $this->Common_Model->FetchData("access_tracking","*","access_userid=".$user_id);
		
		 $html='';
		 $user = $this->Common_Model->FetchData("employees", "*", "1 ORDER BY employee_name ASC");
		if ($records) {
			$accessar = json_decode($records[0]['tracking_access']);
			if ($user) { for ($i=0; $i <count($user) ; $i++) { 
                $trackaccess_id = $records[0]['access_tracking_id'];             
                $html.='<tr>
                    <th><input type="checkbox" class="checkall1"></th>
                    <td>'.$user[$i]['employee_name'].' </td>
                    <td><input value="'.$user[$i]['user_id'].'" id="'.$user[$i]['user_id'].'" name="tracking_access[]" type="checkbox" title="View"  '.(in_array($user[$i]['user_id'], $accessar) ? 'checked="checked"' : '').'></td>
                    
                </tr>';
                 } }
		}else{
			 if ($user) { for ($i=0; $i <count($user) ; $i++) { 
                $trackaccess_id ='0';             
                $html.='<tr>
                    <th><input type="checkbox" class="checkall1"></th>
                    <td>'.$user[$i]['employee_name'].'</td>
                    <td><input value="'.$user[$i]['user_id'].'" id="'.$user[$i]['user_id'].'" name="tracking_access[]" type="checkbox" title="View" ></td>
                    
                </tr>';
                 } } 
		}

		 $rem = $trackaccess_id.'@#,';
		 $rem .= $html.'@#,';
		 echo $rem;exit;
	}

	function usertrackinghistory(){
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));		

		$data['activemenu'] = 'users';
		$data['activesubmenu'] = 'usertrackinghistory';
		
		$data['records']  = $this->Common_Model->FetchData("access_tracking","*","access_userid=".$this->session->userdata('user_id'));		
		
		$this->load->view('users/usertrackinghistory', $data);
	}

	function viewUserAttendance($user_id=0){
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));

		$data['rec'] = $this->Common_Model->FetchData("users","*","user_id=".$user_id);
		if (isset($_REQUEST['log_date']) && $_REQUEST['log_date'] != '') {
			$data['fdate'] = date('Y-m-d',strtotime($_REQUEST['log_date']));
			$data['ldate'] = date('Y-m-d',strtotime($_REQUEST['log_date']));
		}else{


		$data['fdate'] = date('Y-m-d');
		$data['ldate'] = date('Y-m-d',mktime(0, 0, 0, date("m")-3, date("d"),   date("Y")));
		}

		
		$data['activemenu'] = 'users';
		$data['activesubmenu'] = 'usertrackinghistory';
		$this->load->view('users/viewUserAttendance', $data);
	}

	function viewRecordonMap($user_id=0,$userdate=''){
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$data['userdate'] = $userdate;
		$data['location'] = $this->Common_Model->FetchData("userlocation","*","user_id=".$user_id." AND locationentry_dt >='".$userdate." 00:00:00' AND locationentry_dt <='".$userdate." 23:59:59'");
		$data['user'] = $this->Common_Model->FetchData("users","*","user_id=".$user_id."");
		//print_r($data['location']);exit;
		$data['activemenu'] = 'users';
		$data['activesubmenu'] = 'usertrackinghistory';
		$this->load->view('users/viewRecordonMap', $data);

	}
  
  function unitaccess(){
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));

		if($this->input->post('submitBtn')){

			$this->form_validation->set_rules('user_id', 'User', 'trim|required');
			$this->form_validation->set_error_delimiters('<p class="has-error"><label class="control-label">', '</label></p>');
			if($this->form_validation->run()){
				$data_list = array(
					'access_userid'     => $this->input->post('user_id'),
					'unit_access'	=> json_encode($this->input->post('unit_access[]'))
				);
				if ($this->input->post('access_unit_id') > 0) {
					 $this->Common_Model->update_records("access_unit","access_unit_id",$this->input->post('access_unit_id'), $data_list);
				}else{
					$id = $this->Common_Model->dbinsertid("access_unit", $data_list);
				}
				
				$this->session->set_flashdata('success', 'Access Added successfully.' );
				redirect('users/unitaccess');
			}else{
				$this->session->set_flashdata('error', validation_errors());
			}
		}

		$data['activemenu'] = 'users';
		$data['activesubmenu'] = 'unitaccess';
		$data['user'] = $this->Common_Model->FetchData("users", "*", "usercategory='1' AND usertype !='Others' ORDER BY firstname ASC");
		$this->load->view('users/unitaccess', $data);
	}

	function get_unitAccess(){
		$user_id = $this->input->post('user_id');
		$records = $this->Common_Model->FetchData("access_unit","*","access_userid=".$user_id);
		
		 $html='';
		 $units = $this->Common_Model->FetchData("units", "*", "unit_active='Active' ORDER BY unit_id ASC");
		if ($records) {
			$accessar = json_decode($records[0]['unit_access']);
			if ($units) { for ($i=0; $i <count($units) ; $i++) { 
                $unitaccess_id = $records[0]['access_unit_id'];             
                $html.='<tr>
                    <th><input type="checkbox" class="checkall1"></th>
                    <td>'.$units[$i]['unit_id'].'</td>
                    <td>'.$units[$i]['unit_name'].'</td>
                    <td><input value="'.$units[$i]['unit_id'].'" id="'.$units[$i]['unit_id'].'" name="unit_access[]" type="checkbox" title="View"  '.(in_array($units[$i]['unit_id'], $accessar) ? 'checked="checked"' : '').'></td>
                    
                </tr>';
                 } }
		}else{
			 if ($units) { for ($i=0; $i <count($units) ; $i++) { 
                $unitaccess_id ='0';             
                $html.='<tr>
                    <th><input type="checkbox" class="checkall1"></th>
                    <td>'.$units[$i]['unit_id'].'</td>
                    <td>'.$units[$i]['unit_name'].'</td>
                    <td><input value="'.$units[$i]['unit_id'].'" id="'.$units[$i]['unit_id'].'" name="unit_access[]" type="checkbox" title="View" ></td>
                    
                </tr>';
                 } } 
		}

		 $rem = $unitaccess_id.'@#,';
		 $rem .= $html.'@#,';
		 echo $rem;exit;
	}
  
  function uattendance(){
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		if ($this->input->post("searchBtn")) {
			$data['month'] = $this->input->post("month");
			$data['year'] = $this->input->post("year");
		}else{
			$data['month'] = date('m');
			$data['year'] = date('Y');
		}

		$data['activemenu'] = 'users';
		$data['activesubmenu'] = 'usersattendance';
		/*$data['user'] = $this->Common_Model->FetchData("users", "*", "usercategory='1' ORDER BY firstname ASC");*/
		$this->load->view('users/uattendance', $data);
	}
  
  function unattendance(){
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		if ($this->input->post("searchBtn")) {
			$data['unit_id'] = $this->input->post("unit_id");
			$data['month'] = $this->input->post("month");
			$data['year'] = $this->input->post("year");
		}else{
			$data['unit_id'] = '0';
			$data['month'] = '0';
			$data['year'] = '0';
		}

		$data['activemenu'] = 'users';
		$data['activesubmenu'] = 'unitattendance';
		$data['records']  = $this->Common_Model->FetchData("access_unit","*","access_userid=".$this->session->userdata('user_id'));
		/*$data['user'] = $this->Common_Model->FetchData("users", "*", "usercategory='1' ORDER BY firstname ASC");*/
		$this->load->view('users/unattendance', $data);
	}

	function unitattendance($user_id=0,$month=0,$year=0,$unit_id=0){
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));

		$data['records']  = $this->Common_Model->FetchData("access_unit","*","access_userid=".$this->session->userdata('user_id'));
		$data['user_id']=$user_id;
		$data['month']=$month;
		$data['year']=$year;
		$data['unit_id']=$unit_id;

		$data['activemenu'] = 'users';
		$data['activesubmenu'] = 'unitattendance';
		//$data['units'] = $this->Common_Model->FetchData("units", "*", "unit_active='Active' ORDER BY unit_id ASC");
		$this->load->view('users/unitattendance', $data);
	}

	function get_unitAttendance(){
		$unit_id = $this->input->post('unit_id');
		$log_date = $this->input->post('log_date');
		
		$html='';
		if (!empty($unit_id)) {
				$rec1 = $this->Common_Model->FetchData("client_attendance_log as a LEFT JOIN employees as b on a.employee_id=b.employee_id","a.*,b.employee_name,b.techno_emp_id","log_date='".$log_date."' AND unit_id=".$unit_id." AND status='1'");
				if ($rec1) { for ($i=0; $i <count($rec1) ; $i++) { 
					
				

					$rec2 = $this->Common_Model->FetchData("client_attendance_log as a LEFT JOIN employees as b on a.employee_id=b.employee_id","a.*,b.employee_name,b.techno_emp_id","log_date='".$log_date."' AND unit_id=".$unit_id." AND user_id=".$rec1[$i]['user_id']." AND status='2'");
				
				
				
				if ($rec1[$i]['log_datetime']) {
					$checkin = date('d-m-Y H:i:s',strtotime($rec1[0]['log_datetime']));
				}else{
					$checkin = '';
				}

				if ($rec2[0]['log_datetime']) {
					$checkout = date('d-m-Y H:i:s',strtotime($rec2[0]['log_datetime']));
				}else{
					$checkout = '';
				}

				if (!empty($rec1[$i]['log_datetime']) && !empty($rec2[0]['log_datetime'])) {
					$datetime1 = new DateTime($rec1[$i]['log_datetime']);
					$datetime2 = new DateTime($rec2[0]['log_datetime']);
					$interval = $datetime1->diff($datetime2);
					$workinghour = $interval->format('%h').".".$interval->format('%i')."";
					
					$status = 'Present';
				}else{
					$status = 'Absent';
					$workinghour = '';
				}
				$html.='<tr><td>1</td><td>'.$unit_id.'</td><td>'.$rec1[$i]['techno_emp_id'].'</td><td>'.$rec1[$i]['employee_name'].'</td><td>'.$log_date.'</td><td>'.$checkin.'</td><td>'.$checkout.'</td><td>'.$workinghour.'</td><td>'.$status.'</td></tr>';
				}
			}else{
				$html .='No records found !!';
			}
		}else{
			$html .='';
			
		}
		echo $html;exit;

	}

	function downloadunitattendance(){
		$data['unit_id'] = $this->input->post('unit_id');
		$data['log_date'] = $this->input->post('log_date');


		$html = $this->load->view('users/printunitattendance', $data, TRUE);
		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition: attachment; filename=Scanner Attendance".time().".xls");
		echo $html;
		exit;
	}

}




