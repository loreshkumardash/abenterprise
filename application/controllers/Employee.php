<?php
error_reporting(0);
defined('BASEPATH') OR exit('No direct script access allowed');
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Employee extends CI_Controller {

	public function __construct(){
		parent::__construct();
		is_logged_in();
		date_default_timezone_set("Asia/Kolkata"); 
		$this->present_date 		= date('Y-m-d');
		$this->present_time 		= date('H:i:a');
		$this->timestamp 		= date('Y-m-d H:i:s'); 
	}

	public function index(){
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$data['per_page'] = $per_page = isset($_REQUEST['per_page']) ? $_REQUEST['per_page'] : 40;
		$data['page'] = $page = isset($_REQUEST['page']) ? $_REQUEST['page'] : '1';
		$this->load->helper('url');
		$currentURL = current_url();
		$sql = "1";
		$urlvars = '';
		if(isset($_REQUEST['date_from']) && $_REQUEST['date_from'] != ''){
			$sql.= " AND em.emp_doj >= '".$_REQUEST['date_from']."'";
			$urlvars.= "&date_from=".$_REQUEST['date_from'];
		}
		if(isset($_REQUEST['date_to']) && $_REQUEST['date_to'] != ''){
			$sql.= " AND em.emp_doj <= '".$_REQUEST['date_to']."'";
			$urlvars.= "&date_to=".$_REQUEST['date_to'];
		}
		if(isset($_REQUEST['employee_id']) && $_REQUEST['employee_id'] != ''){
			$sql.= " AND em.employee_id LIKE '%".$_REQUEST['employee_id']."%'";
			$urlvars.= "&employee_id=".$_REQUEST['employee_id'];
		}
		if(isset($_REQUEST['employee_name']) && $_REQUEST['employee_name'] != ''){
			$sql.= " AND em.employee_name LIKE '%".$_REQUEST['employee_name']."%'";
			$urlvars.= "&employee_name=".$_REQUEST['employee_name'];
		}
		if(isset($_REQUEST['emp_firstname']) && $_REQUEST['emp_firstname'] != ''){
			$sql.= " AND em.emp_firstname LIKE '%".$_REQUEST['emp_firstname']."%'";
			$urlvars.= "&emp_firstname=".$_REQUEST['emp_firstname'];
		}
		if(isset($_REQUEST['emp_lastname']) && $_REQUEST['emp_lastname'] != ''){
			$sql.= " AND em.emp_lastname LIKE '%".$_REQUEST['emp_lastname']."%'";
			$urlvars.= "&emp_lastname=".$_REQUEST['emp_lastname'];
		}
		if(isset($_REQUEST['employee_email']) && $_REQUEST['employee_email'] != ''){
			$sql.= " AND e.kyc_adharno LIKE '%".$_REQUEST['employee_email']."%'";
			$urlvars.= "&employee_email=".$_REQUEST['employee_email'];
		}
		if(isset($_REQUEST['employee_mobile']) && $_REQUEST['employee_mobile'] != ''){
			$sql.= " AND em.emp_mobile = '".$_REQUEST['employee_mobile']."'";
			$urlvars.= "&employee_mobile=".$_REQUEST['employee_mobile'];
		}
		if(isset($_REQUEST['department_id']) && $_REQUEST['department_id'] != ''){
			$sql.= " AND em.department_id = '".$_REQUEST['department_id']."'";
			$urlvars.= "&department_id=".$_REQUEST['department_id'];
		}
		if(isset($_REQUEST['emp_cat']) && $_REQUEST['emp_cat'] != ''){
			$sql.= " AND em.emp_cat LIKE '%".$_REQUEST['emp_cat']."%'";
			$urlvars.= "&emp_cat=".$_REQUEST['emp_cat'];
		}
		
		if ($this->session->userdata("usertype") == 'Admin') {
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
             $sql .= " AND em.user_id IN (" .$eassign. ")"; 
		}
		

		$sSql = "SELECT COUNT(*) as num FROM employees AS em LEFT JOIN bankandkyc AS e ON em.employee_id = e.employee_id WHERE $sql";
		$records = $this->Common_Model->db_query($sSql);
		$totalrecords = $records[0]['num'];
		if($totalrecords){
			//$sSql = "SELECT em.employee_id, em.employee_name, em.department_id, em.emp_fathername, em.aadhar_number, em.emp_mobile, em.employee_mobile2, em.emp_peraddress, em.employee_email, em.emp_status, em.emp_cat, em.epf_status, em.epf_percentile, em.emp_firstname, em.emp_lastname,em.techno_emp_id, em.emp_dob,em.emp_doj, em.emp_photo, d.department_name, d.shift_id, d.start_time, d.end_time, d.department_active, e.kyc_adharno,em.last_edit_by,em.last_edit_on,em.emp_at,em.emp_po FROM employees AS em LEFT JOIN department AS d ON em.department_id = d.did LEFT JOIN bankandkyc AS e ON em.employee_id = e.employee_id WHERE $sql ORDER BY em.techno_emp_id DESC";

			$sSql = "SELECT * 
         FROM employees AS em 
         LEFT JOIN department AS d ON em.department_id = d.did 
         LEFT JOIN designation AS deg ON em.designation_id = deg.designation_id 
         WHERE $sql 
         ORDER BY em.techno_emp_id DESC";

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
		$data['activemenu'] = 'employee';
		$data['activesubmenu'] = 'listemployee';
		$this->load->view('employee/listemployees', $data);
	}

	function listemployees_ajax(){
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
		if(isset($_POST['date_from']) && $_POST['date_from'] != ''){
			$sql.= " AND em.emp_doj >= '".$_POST['date_from']."'";
			$param['date_from'] = $_POST['date_from'];
		}
		if(isset($_POST['date_to']) && $_POST['date_to'] != ''){
			$sql.= " AND em.emp_doj <= '".$_POST['date_to']."'";
			$param['date_to'] = $_POST['date_to'];
		}

		if(isset($_POST['employee_id']) && $_POST['employee_id'] != ''){
			$sql.= " AND em.techno_emp_id = '".$_POST['employee_id']."'";
			$param['employee_id'] = $_POST['employee_id'];
		}
		
		if(isset($_POST['employee_name']) && $_POST['employee_name'] != ''){
			$sql.= " AND em.employee_name LIKE '%".$_POST['employee_name']."%'";
			$param['employee_name'] = $_POST['employee_name'];
		}

		if(isset($_POST['emp_firstname']) && $_POST['emp_firstname'] != ''){
			$sql.= " AND em.emp_firstname LIKE '%".$_POST['emp_firstname']."%'";
			$param['emp_firstname'] = $_POST['emp_firstname'];
		}

		if(isset($_POST['emp_lastname']) && $_POST['emp_lastname'] != ''){
			$sql.= " AND em.emp_lastname LIKE '%".$_POST['emp_lastname']."%'";
			$param['emp_lastname'] = $_POST['emp_lastname'];
		}
		if(isset($_POST['employee_email']) && $_POST['employee_email'] != ''){
			$sql.= " AND e.kyc_adharno LIKE '%".$_POST['employee_email']."%'";
			$param['employee_email'] = $_POST['employee_email'];
		}
		
		if(isset($_POST['employee_mobile']) && $_POST['employee_mobile'] != ''){
			$sql.= " AND em.emp_mobile LIKE '%".$_POST['employee_mobile']."%'";
			$param['employee_mobile'] = $_POST['employee_mobile'];
		}
		if(isset($_REQUEST['emp_cat']) && $_REQUEST['emp_cat'] != ''){
			$sql.= " AND em.emp_cat = '".$_REQUEST['emp_cat']."'";
			$param['emp_cat'] = $_POST['emp_cat'];
		}
		
		if ($this->session->userdata("usertype") == 'Admin') {
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
             $sql .= " AND em.user_id IN (" .$eassign. ")"; 
		}

		$this->perPage = 20;
		$rows = "SELECT COUNT(*) as num FROM employees AS em LEFT JOIN users AS u ON em.employee_id = u.employee_tagged_id LEFT JOIN department AS d ON em.department_id = d.did LEFT JOIN bankandkyc AS e ON em.employee_id = e.employee_id WHERE $sql";
		$datalist = $this->Common_Model->FetchPaginationData("employees AS em LEFT JOIN users AS u ON em.employee_id = u.employee_tagged_id LEFT JOIN department AS d ON em.department_id = d.did LEFT JOIN bankandkyc AS e ON em.employee_id = e.employee_id", "em.employee_id, em.employee_name, em.department_id, em.emp_fathername, em.aadhar_number, em.emp_mobile, em.employee_mobile2, em.emp_peraddress, em.employee_email, em.emp_status,em.techno_emp_id, em.emp_cat, em.epf_status, em.epf_percentile, em.emp_firstname, em.emp_lastname, em.emp_dob,em.emp_doj, em.emp_photo, d.department_name, d.shift_id, d.start_time, d.end_time, d.department_active, u.user_id, u.firstname, u.lastname, u.useremail, u.userphone, u.username, u.password, u.usertype, u.created_on, u.last_login_on, u.last_login_ip, u.userstatus, u.access_id, u.employee_tagged_id,e.kyc_adharno,em.last_edit_by,em.last_edit_on,em.emp_at,em.emp_po", "$sql GROUP BY em.employee_id ORDER BY em.techno_emp_id DESC", array('start' => $offset,'limit'=>$this->perPage));
        $config['first_link']  = 'First';
        $config['target']      = '#dataTablediv';
        $config['base_url']    = base_url().'index.php/employee/listemployees_ajax';
        $config['total_rows']  = $rows;
        $config['per_page']    = $this->perPage;
        $config['param_ar']	   = $param;
        $this->ajax_pagination->initialize($config);
		$data['records'] = $datalist;
		$this->load->view('employee/listemployees_ajax', $data);
	}


	function download_emp(){
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		//$data['per_page'] = $per_page = isset($_REQUEST['per_page']) ? $_REQUEST['per_page'] : 10;
		$data['page'] = $page = isset($_REQUEST['page']) ? $_REQUEST['page'] : '1';
		
		$sql = "1";
		
		if(isset($_REQUEST['date_from']) && $_REQUEST['date_from'] != ''){
			$sql.= " AND em.emp_doj >= '".$_REQUEST['date_from']."'";
			
		}
		if(isset($_REQUEST['date_to']) && $_REQUEST['date_to'] != ''){
			$sql.= " AND em.emp_doj <= '".$_REQUEST['date_to']."'";
			
		}

		if(isset($_REQUEST['employee_id']) && $_REQUEST['employee_id'] != ''){
			$sql.= " AND em.techno_emp_id = '".$_REQUEST['employee_id']."'";
			
		}
		if(isset($_REQUEST['employee_name']) && $_REQUEST['employee_name'] != ''){
			$sql.= " AND em.employee_name LIKE '%".$_REQUEST['employee_name']."%'";
			
		}
		if(isset($_REQUEST['employee_email']) && $_REQUEST['employee_email'] != ''){
			$sql.= " AND f.kyc_adharno LIKE '%".$_REQUEST['employee_email']."%'";
			
		}
		if(isset($_REQUEST['employee_mobile']) && $_REQUEST['employee_mobile'] != ''){
			$sql.= " AND em.emp_mobile = '".$_REQUEST['employee_mobile']."'";
			
		}
		if(isset($_REQUEST['department_id']) && $_REQUEST['department_id'] != ''){
			$sql.= " AND em.department_id = '".$_REQUEST['department_id']."'";
			
		}
		if(isset($_REQUEST['emp_cat']) && $_REQUEST['emp_cat'] != ''){
			$sql.= " AND em.emp_cat = '".$_REQUEST['emp_cat']."'";
			
		}

		$datalist = $this->Common_Model->db_query("SELECT em.employee_id, em.employee_name, em.department_id, em.emp_fathername, em.aadhar_number, em.emp_mobile, em.employee_mobile2, em.emp_permaddress, em.employee_email, em.emp_status, em.epf_status,em.view_psw, em.epf_percentile, em.emp_firstname, em.emp_lastname,em.emp_doj, em.emp_dob,em.emp_cat,em.techno_emp_id, em.emp_photo, d.department_name, d.shift_id, d.start_time, d.end_time, d.department_active, u.user_id, u.firstname, u.lastname, u.useremail, u.userphone, u.username, u.password, u.usertype, u.created_on, u.last_login_on, u.last_login_ip, u.userstatus, u.access_id, u.employee_tagged_id, e.designation_name, f.st_paymode, f.st_acno, f.st_bankname, f.st_ifsc, f.kyc_adharno, f.kyc_panno, g.pf_uanno, g.pf_number, g.esi_number,em.emp_nickname,em.emp_gender,em.emp_mothername,em.higher_qual,g.emp_ispmjjy,g.emp_ispmsvy,em.emp_plotno,em.emp_state,em.emp_dist,em.emp_curpin,em.emp_at,em.emp_po,em.emp_tahsil,em.emp_landmark,em.emp_plotnop,em.emp_statep,em.emp_distp,em.emp_curpinp,em.emp_atp,em.emp_pop,em.emp_tahsilp,em.emp_landmarkp FROM employees AS em LEFT JOIN users AS u ON em.employee_id = u.employee_tagged_id LEFT JOIN department AS d ON em.department_id = d.did LEFT JOIN designation AS e ON em.designation_id = e.designation_ID LEFT JOIN bankandkyc AS f ON em.employee_id = f.employee_id LEFT JOIN pfandesi AS g ON em.employee_id = g.employee_id WHERE $sql ORDER BY em.techno_emp_id DESC");
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		// Set document properties
		$spreadsheet->getProperties()->setCreator('Glosent')
					->setLastModifiedBy($this->session->userdata('firstname').' '.$this->session->userdata('lastname'))
					->setTitle('Employee Report')
					->setSubject('Employee Report')
					->setDescription('Employee Report');
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
		$spreadsheet->getActiveSheet()->getStyle('A1:AB1')->applyFromArray($styleArray);
		// auto fit column to content
		foreach(range('A', 'AB') as $columnID) {
			$spreadsheet->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
		}

		$sheet->setCellValue('A1', 'Employee ID');
		$sheet->setCellValue('B1', 'Employee Name');		
		$sheet->setCellValue('C1', 'Employee Profile Photo');
		$sheet->setCellValue('D1', 'Nick Name');
		$sheet->setCellValue('E1', 'Date of Birth');
		$sheet->setCellValue('F1', 'Gender');
		$sheet->setCellValue('G1', 'Father/Husband Name');
		$sheet->setCellValue('H1', "Mother's Name");
		$sheet->setCellValue('I1', 'Email');		
		$sheet->setCellValue('J1', 'Mobile No');
		$sheet->setCellValue('K1', 'Aadhar No');
		$sheet->setCellValue('L1', 'Higher Qualification');
		$sheet->setCellValue('M1', 'Current Address');
		$sheet->setCellValue('N1', 'Permanent Address');
		$sheet->setCellValue('O1', 'Date of Joining');
		$sheet->setCellValue('P1', 'Department');
		$sheet->setCellValue('Q1', 'Designation');
		$sheet->setCellValue('R1', 'Employee Status');
		$sheet->setCellValue('S1', 'Payment Mode');
		$sheet->setCellValue('T1', 'Bank Name');
		$sheet->setCellValue('U1', 'A/c No');
		$sheet->setCellValue('V1', 'IFSC Code');
		$sheet->setCellValue('W1', 'PAN No');
		$sheet->setCellValue('X1', 'PF No');
		$sheet->setCellValue('Y1', 'ESI No');
		$sheet->setCellValue('Z1', 'PMJJY');
		$sheet->setCellValue('AA1', 'PMSVY');
        $sheet->setCellValue('AB1', 'Password');
		
		
		$x = 2;
		if($datalist){
			for($i=0;$i<count($datalist);$i++){

				$curstate = $this->Common_Model->FetchData("state","*","state_id=".$datalist[$i]['emp_state']);
				$curdist = $this->Common_Model->FetchData("district","*","district_id =".$datalist[$i]['emp_dist']);

				$perstate = $this->Common_Model->FetchData("state","*","state_id=".$datalist[$i]['emp_statep']);
				$perdist = $this->Common_Model->FetchData("district","*","district_id =".$datalist[$i]['emp_distp']);
				$curraddress = $datalist[$i]['emp_plotno'].','.$datalist[$i]['emp_at'].','.$datalist[$i]['emp_po'].','.$datalist[$i]['emp_tahsil'].','.$datalist[$i]['emp_landmark'].','.$curstate[0]['state_title'].','.$curdist[0]['district_title'].','.$datalist[$i]['emp_curpin'];

				$peraddress = $datalist[$i]['emp_plotnop'].','.$datalist[$i]['emp_atp'].','.$datalist[$i]['emp_pop'].','.$datalist[$i]['emp_tahsilp'].','.$datalist[$i]['emp_landmarkp'].','.$perstate[0]['state_title'].','.$perdist[0]['district_title'].','.$datalist[$i]['emp_curpinp'];
				
					
				$dob = $datalist[$i]['emp_dob'] == '0000-00-00' ? '' : date("d/m/Y", strtotime($datalist[$i]['emp_dob']));
				$drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
				$drawing->setName('Logo');
				$drawing->setDescription('Logo');
				// if($datalist[$i]['emp_photo'] != ''){
				// 	$drawing->setPath('./uploads/employee/'.$datalist[$i]['emp_photo']);
				// }else{
				// 	$drawing->setPath('./assets/61f75ea9a680def2ed1c6929fe75aeee.jpg');
				// }
				
				$drawing->setHeight(60);
				$drawing->setCoordinates('C'.$x);
				$drawing->setWorksheet($spreadsheet->getActiveSheet());
				$spreadsheet->getActiveSheet()->getRowDimension($x)->setRowHeight(60);
				$writer = new Xlsx($spreadsheet);
				$sheet->setCellValue('A'.$x, $datalist[$i]['techno_emp_id']);
				$sheet->setCellValue('B'.$x, $datalist[$i]['employee_name']);
				// $sheet->setCellValue('C'.$x, $datalist[$i]['emp_photo']);
				$sheet->setCellValue('D'.$x, $datalist[$i]['emp_nickname']);
				$sheet->setCellValue('E'.$x, $datalist[$i]['emp_dob']);	
				$sheet->setCellValue('F'.$x, $datalist[$i]['emp_gender']);	
				$sheet->setCellValue('G'.$x, $datalist[$i]['emp_fathername']);
				$sheet->setCellValue('H'.$x, $datalist[$i]['emp_mothername']);
				$sheet->setCellValue('I'.$x, $datalist[$i]['employee_email']);
				$sheet->setCellValueExplicit('J'.$x, $datalist[$i]['emp_mobile'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
				$sheet->setCellValueExplicit('K'.$x, $datalist[$i]['kyc_adharno'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
				$sheet->setCellValue('L'.$x, $datalist[$i]['higher_qual']);
				$sheet->setCellValue('M'.$x, $curraddress);				
				$sheet->setCellValue('N'.$x, $peraddress);				
				$sheet->setCellValue('O'.$x, $datalist[$i]['emp_doj']);				
				$sheet->setCellValue('P'.$x, $datalist[$i]['department_name']);				
				$sheet->setCellValue('Q'.$x, $datalist[$i]['designation_name']);				
				$sheet->setCellValue('R'.$x, $datalist[$i]['emp_status']);				
				$sheet->setCellValue('S'.$x, $datalist[$i]['st_paymode']);				
				$sheet->setCellValue('T'.$x, $datalist[$i]['st_bankname']);
				$sheet->setCellValueExplicit('U'.$x, $datalist[$i]['st_acno'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);				
				$sheet->setCellValue('V'.$x, $datalist[$i]['st_ifsc']);	
				$sheet->setCellValueExplicit('W'.$x, $datalist[$i]['kyc_panno'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);			
				$sheet->setCellValueExplicit('X'.$x, $datalist[$i]['pf_number'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);			
				$sheet->setCellValueExplicit('Y'.$x, $datalist[$i]['esi_number'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);			
				$sheet->setCellValue('Z'.$x, ($datalist[$i]['emp_ispmjjy']=='1'?'Yes':'No'));
				$sheet->setCellValue('AA'.$x, ($datalist[$i]['emp_ispmsvy']=='1'?'Yes':'No'));
              	$sheet->setCellValue('AB'.$x, $datalist[$i]['view_psw']);
				$x++;
			}
		}
		$x--;
		$spreadsheet->getActiveSheet()->getStyle('O1:O'.$spreadsheet->getActiveSheet()->getHighestRow())->getAlignment()->setWrapText(true); 
		$spreadsheet->getActiveSheet()->getStyle('P1:P'.$spreadsheet->getActiveSheet()->getHighestRow())->getAlignment()->setWrapText(true); 
		foreach(range('AA', 'AB') as $columnID) {
			$spreadsheet->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
		}
		$spreadsheet->getActiveSheet()->getStyle('A2:AB2'.$x)->applyFromArray($cellstyleArray);
		$writer = new Xlsx($spreadsheet);
		header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="employee_data.xlsx"');
        $writer->save('php://output');
        exit;

	}
	public function addemployee(){
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		
		$employee = $this->Common_Model->FetchData(
    		"employees",
    		"techno_emp_id",
    		"techno_emp_id LIKE 'AB%' ORDER BY techno_emp_id DESC LIMIT 1"
		);

		if (!empty($employee)) {
    		$lastId = $employee;
    		$rc = (int) substr($lastId, 2) + 1;
		} else {
    		$rc = 1;
		}

		$techno_emp_id = 'AB' . str_pad($rc, 6, '0', STR_PAD_LEFT);
		$data['techno_emp_id'] = $techno_emp_id;


		if($this->input->post('submitBtn')){
			$this->form_validation->set_rules('emp_firstname', 'Employee First Name', 'trim|required');
			$this->form_validation->set_rules('emp_lastname', 'Employee Last Name', 'trim|required');
			$this->form_validation->set_rules('emp_dob', 'DOB', 'trim|required');
			$this->form_validation->set_rules('emp_fathername', 'Father Name', 'trim|required');
			$this->form_validation->set_rules('emp_mobile', 'Mobile', 'trim|required|is_unique[employees.emp_mobile]');
			$this->form_validation->set_rules('employee_email', 'Email', 'trim|required|is_unique[employees.employee_email]');
			
			$this->form_validation->set_error_delimiters('<p class="has-error"><label class="control-label">', '</label></p>');
			if($this->form_validation->run()){

				$data_list = array(
					'employee_name'			=> ucwords($this->input->post('emp_firstname').' '.$this->input->post('emp_middlename').' '.$this->input->post('emp_lastname')),
					'emp_firstname'			=> ucwords($this->input->post('emp_firstname')),
					'emp_middlename'			=> ucwords($this->input->post('emp_middlename')),
					'emp_lastname'			=> ucwords($this->input->post('emp_lastname')),
					'emp_nickname'			=> ucwords($this->input->post('emp_nickname')),
					'emp_appform_no'		=> $this->input->post('emp_appform_no'),
					'employee_email'		=> $this->input->post('employee_email'),
					'techno_emp_id'			=> $techno_emp_id,
					'emp_status'			=> $this->input->post('emp_status'),
					'emp_dob'				=> $this->input->post('emp_dob'),
					'emp_gender'			=> $this->input->post('emp_gender'),
					'emergency_name'     => $this->input->post('emergency_name'),
					'emergency_relation' => $this->input->post('emergency_relation'),
					'emergency_contact'  =>$this->input->post('emergency_contact'),
					'career_objective' => $this->input->post('cobj', true),
					'official_email' => $this->input->post('official_email'),
					'emp_pob' => $this->input->post('emp_pob'),
					'emp_cat'				=> 'Staff',
					'emp_fathername'		=> $this->input->post('emp_fathername'),
					'emp_mothername'		=> $this->input->post('emp_mothername'),
					'emp_doj'				=> $this->input->post('emp_doj'),
					'emp_jobtype'			=> $this->input->post('emp_jobtype'),
					'emp_maritalstatus'		=> $this->input->post('emp_maritalstatus'),
					'emp_spousename'		=> $this->input->post('emp_spousename'),
					'emp_annivdate'			=> $this->input->post('emp_annivdate'),
					'department_id'			=> $this->input->post('emp_department'),
					'designation_id'		=> $this->input->post('emp_designation'),
					'grade' => in_array($this->input->post('grade'), ['junior','mid','upper'])
    					? $this->input->post('grade')
    					: null,
					'e_salary' => $this->input->post('e_salary') !== ''
    					? (float) $this->input->post('e_salary')
    					: null,
					'reporting_to' => $this->input->post('reporting') ?: null,

					'nationality' => $this->input->post('nationality') ?: null,
					'emp_father_occ' 		=> $this->input->post('f_occ'),
					'emp_mother_occ' 		=> $this->input->post('m_occ'),
					'emp_spouse_occ' 		=> $this->input->post('s_occ'),
					'higher_qual'			=> $this->input->post('higher_qual'),
					'exp_year'				=> $this->input->post('exp_year'),
						'emp_plotno'			=> $this->input->post('emp_plotno'),
						'emp_state'				=> $this->input->post('emp_state'),
						'emp_dist'				=> $this->input->post('emp_dist'),
						'emp_curpin'			=> $this->input->post('emp_curpin'),
						'emp_at'				=> $this->input->post('emp_at'),
						'emp_po'				=> $this->input->post('emp_po'),
						'emp_tahsil'			=> $this->input->post('emp_tahsil'),
						'emp_landmark'			=> $this->input->post('emp_landmark'),
					'emp_plotnop'			=> $this->input->post('emp_plotnop'),
					'emp_statep'				=> $this->input->post('emp_statep'),
					'emp_distp'				=> $this->input->post('emp_distp'),
					'emp_curpinp'			=> $this->input->post('emp_curpinp'),
					'emp_atp'				=> $this->input->post('emp_atp'),
					'emp_pop'				=> $this->input->post('emp_pop'),
					'emp_tahsilp'			=> $this->input->post('emp_tahsilp'),
					'emp_landmarkp'			=> $this->input->post('emp_landmarkp'),
          			'dutyhour'				=> $this->input->post('dutyhour'),
					'emp_mobile'			=> $this->input->post('emp_mobile'),
					'emp_amobile'			=> $this->input->post('emp_amobile'),
					'emp_pgmobile'			=> $this->input->post('emp_pgmobile'),
					'emp_bloodgrp'     => $this->input->post('emp_bloodgrp'),
					'emp_age'         => $this->input->post('emp_age'),
					'aadhar_number'        => $this->input->post('kyc_adharno'),
					'emp_curaddress'		=> '',
					'emp_current'			=> '',
					'emp_curraddress'		=> '',
					'emp_peraddress'		=> '',
					'emp_permanent'		    => '',
					'emp_permaddress'		=> '',
					'emp_perpin'			=> '',
					'view_psw'				=> $this->input->post('password'),
					'session_id'            => $this->session->userdata("session_id"),
                  	'last_edit_on'			    => date('Y-m-d H:i:s'),
					'last_edit_by'			    => $this->session->userdata("firstname").' '.$this->session->userdata("lastname"),
				);
				if($_FILES['emp_photo']['name']!=""){
					$newfile = preg_replace('/\W+/', '-', strtolower($this->input->post('emp_firstname').' '.$this->input->post('emp_lastname'))).uniqid();
					$config = array(
						'upload_path' => "uploads/employeeicon/",
						'allowed_types' => 'jpg|png|jpeg|pdf',
						'overwrite' => TRUE,
						'file_name' => $newfile,
						'max_size' => "200048000" 
					);

					$this->load->library('upload', $config);
					$this->upload->initialize($config);
					if($this->upload->do_upload("emp_photo"))
					{
						$dat = $this->upload->data();
						$data_list['emp_photo'] = $dat['file_name'];
							$this->load->library('image_lib');
			                $config['image_library'] = 'gd2'; // Set your preferred image processing library
					        $config['source_image'] = $dat['full_path'];
					        $config['create_thumb'] = FALSE; // Create a thumbnail version
					        $config['maintain_ratio'] = TRUE;
					        $config['width'] = 50; // Set the width you desire for the thumbnail
					        $config['height'] = 50; // Set the height you desire for the thumbnail
					        $config['quality'] = 50; 
					        $config['new_image']  = 'uploads/employeeicon/' . $dat['file_name'];
					        $this->image_lib->initialize($config);
					        $this->image_lib->resize();
							$this->image_lib->clear();
					}else{
						$filename = '';
						$this->session->set_flashdata('error', $this->upload->display_errors());
						redirect($_SERVER['HTTP_REFERER']);
					}
				}else{ $data_list['emp_photo'] = '';}
				
				if ($this->input->post("receivable_amt") == 0) {
						$data_list['regd_paystatus'] = 1;
					}else{
						$data_list['regd_paystatus'] = 0;
					}
					// echo '<pre>';print_r($data_list);exit;					
				$employee_id = $this->Common_Model->dbinsertid("employees", $data_list);
				
				if($employee_id){
					
						$data_list = array(
							'firstname'         => ucwords($this->input->post('emp_firstname')),
							'lastname'          => ucwords($this->input->post('emp_lastname')),
							'userphone'			=> $this->input->post('emp_mobile'),
							'useremail'			=> $this->input->post('employee_email'),
							'username'			=> strtolower($this->input->post('username')),
							'password'			=> md5($this->input->post('password')),
							'usertype'			=> $this->input->post('usertype'),
							'access_id'			=> $this->input->post('access_id'),
							'created_on'		=> date('Y-m-d H:i:s'),
							'userstatus'		=> $this->input->post('userstatus'),
							'employee_tagged_id'	=> $employee_id
						);
						$user_id = $this->Common_Model->dbinsertid("users", $data_list);
						if ($user_id) {
							$this->Common_Model->db_query("UPDATE employees SET view_psw ='".$this->input->post('password')."',user_id =".$user_id." WHERE employee_id=".$employee_id."");
						}
				
		$cheque_file = null;

		if (!empty($_FILES['emp_cheque']['name'])) {

		$config = [
                'upload_path'   => './uploads/cheques/',
                'allowed_types' => 'pdf|jpg|jpeg|png',
                'encrypt_name'  => true,
                'max_size'      => 2048
            ];

   	 	$this->load->library('upload', $config);

    	if (!$this->upload->do_upload('emp_cheque')) {

        $error = $this->upload->display_errors();
        $this->session->set_flashdata('error', $error);
        redirect($_SERVER['HTTP_REFERER']);
        exit;

    	} else {

        $uploadData  = $this->upload->data();
        $cheque_file = $uploadData['file_name'];
    	}
		}


		$dataforkyc = array(
    	'employee_id'        => $employee_id,
    	'st_paymode'         => $this->input->post('st_paymode'),
    	'st_bankname'        => $this->input->post('st_bankname'),
    	'st_branch'          => $this->input->post('st_branch'),
    	'st_acno'            => $this->input->post('st_acno'),
    	'st_acholdername'    => $this->input->post('st_acholdername'),
    	'st_ifsc'            => $this->input->post('st_ifsc'),
    	'st_referenceno'     => $this->input->post('st_referenceno'),

    	'physicalchallenged' => $this->input->post('physicalchallenged'),
    	'int_worker'         => $this->input->post('int_worker'),
    	'place_oforigin'     => $this->input->post('place_oforigin'),

    	'kyc_panno'          => $this->input->post('kyc_panno'),
    	'kyc_panname'        => $this->input->post('kyc_panname'),
    	'kyc_adharno'        => $this->input->post('kyc_adharno'),
    	'kyc_adharname'      => $this->input->post('kyc_adharname'),
    	'kyc_adharstate'     => $this->input->post('kyc_adharstate'),

    	'emp_cheque'         => $cheque_file,

    	'updated_by'         => $this->session->userdata('user_id'),
    	'updated_on'         => date('Y-m-d H:i:s')
		);

		$bankandkyc_id = $this->Common_Model->dbinsertid("bankandkyc", $dataforkyc);

		$pan_file = '';
		$aadhar_file = '';
		$pvr_file = '';

		$config = [
		    'upload_path'   => './uploads/employee_documents/',
		    'allowed_types' => 'jpg|jpeg|png|pdf',
		    'encrypt_name'  => true,
    		'max_size'      => 2048
			];

			$this->load->library('upload');

				if(!empty($_FILES['pancard']['name'])){
    				$this->upload->initialize($config);

    				if($this->upload->do_upload('pancard')){
        				$data = $this->upload->data();
        				$pan_file = $data['file_name'];
    				}
				}

				if(!empty($_FILES['aadharcard']['name'])){
    				$this->upload->initialize($config);

    				if($this->upload->do_upload('aadharcard')){
       				 $data = $this->upload->data();
       				 $aadhar_file = $data['file_name'];
    				}
				}

				if(!empty($_FILES['pvr']['name'])){
    				$this->upload->initialize($config);

    				if($this->upload->do_upload('pvr')){
        				$data = $this->upload->data();
        				$pvr_file = $data['file_name'];
    				}
				}

				$doc_data = [
    				'employee_id' => $employee_id,
    				'pancard'     => $pan_file,
    				'aadharcard'  => $aadhar_file,
    				'pvr' => $pvr_file
					];

					$this->db->insert('employee_documents', $doc_data);

					$dataforpfandesi = array(
						'employee_id' 			=> $employee_id,
						'emp_ispf' 				=> $this->input->post('emp_ispf'), 
						'pf_number' 			=> $this->input->post('pf_number'), 
						'emp_ispmjjy' 		=> $this->input->post('emp_ispmjjy'), 
						'emp_isesi' 				=> $this->input->post('emp_isesi'), 
						'esi_number' 			=> $this->input->post('esi_number'), 
						'emp_ispmsvy' 			=> $this->input->post('emp_ispmsvy'), 
						'updated_by' 			=> $this->session->userdata('user_id'), 
						'updated_on' 			=> date('Y-m-d H:i:s')
						 );
					$pfandesi_id = $this->Common_Model->dbinsertid("pfandesi", $dataforpfandesi);

					$employeeId = $employee_id;
		$data['getepfAmt'] 			= $this->Common_Model->FetchData("epf", "*", "");
		$data['getPaymentHeads'] 	= $this->Common_Model->FetchData("wages", "*", "wages_active = 'Active' ");

		$slrate_list = array(
					
					'employee_id'  			=> $employee_id,
					'basic_cat'				=> $this->input->post('basic_cat'),
					'ctc_type'				=> $this->input->post('ctc_type'),
					'bonuspercent'			=> $this->input->post('bonuspercent'),
					'salaryvalue'			=> $this->input->post('salaryvalue'),
					'employerpfperc'		=> $this->input->post('employerpfperc'),
					'employeresiperc'		=> $this->input->post('employeresiperc'),
					'grosssalary'		=> $this->input->post('grosssalary'),
					'totdedpermonth'		=> $this->input->post('totdedpermonth'),
					'totdedperannum'		=> $this->input->post('totdedperannum'),
					'totdedperday'			=> $this->input->post('totdedperday'),
					'netsalpermonth'		=> $this->input->post('netsalpermonth'),
					'netsalperannum'		=> $this->input->post('netsalperannum'),
					'netsalperday'			=> $this->input->post('netsalperday'),
					'strcreated_by'			=> $this->session->userdata('user_id'),
					'strcreated_on'			=> date('Y-m-d H:i:s'),

				);

					
				$salary_structure_id = $this->Common_Model->dbinsertid("salary_structure", $slrate_list);

					if ($salary_structure_id) {
						for ($i=0; $i < count($this->input->post('wages_id')); $i++) { 
							$wages_list = array(
								'salary_structure_id' 	=> $salary_structure_id, 
								'wages_id' 			=> $this->input->post('wages_id')[$i], 
								'wages_name' 		=> $this->input->post('wages_name')[$i], 
								'permonth' 			=> $this->input->post('permonth')[$i], 
								'perannum' 			=> $this->input->post('perannum')[$i], 
								'perday' 			=> $this->input->post('perday')[$i], 
							);

							$salary_structure_items_id = $this->Common_Model->dbinsertid("salary_structure_items",$wages_list);
							}
						}
						
					$data_list = array(
								'ledger_name'		=> ucwords($this->input->post('emp_firstname').' '.$this->input->post('emp_middlename').' '.$this->input->post('emp_lastname')),
								'ledger_alias'	=> $techno_emp_id.'.10',
								'acount_group'	=> 81,
								'email'				=> $this->input->post('employee_email'),
								'mobile'				=> $this->input->post('emp_mobile'),
								'emp_id' 				=> $employee_id,
								'ledger_isaprv' => 1,
								'actype' 				=> 'SALARY'
							);
							
							$leid = $this->Common_Model->dbinsertid("ledgers",$data_list);

							$data_list = array(
								'ledger_name'		=> ucwords($this->input->post('emp_firstname').' '.$this->input->post('emp_middlename').' '.$this->input->post('emp_lastname')),
								'ledger_alias'	=> $techno_emp_id.'.20',
								'acount_group'	=> 96,
								'email'			=> $this->input->post('employee_email'),
								'mobile'		=> $this->input->post('emp_mobile'),
								'emp_id' 		=> $employee_id,
								'ledger_isaprv' => 1,
								'actype' 		=> 'ADVANCE'
							);
							
							$leid = $this->Common_Model->dbinsertid("ledgers",$data_list);

						    
							$data_list = array(
								'ledger_name'		=> ucwords($this->input->post('emp_firstname').' '.$this->input->post('emp_middlename').' '.$this->input->post('emp_lastname')),
								'ledger_alias'	=> $techno_emp_id.'.30',
								'acount_group'	=> 96,
								'email'			=> $this->input->post('employee_email'),
								'mobile'		=> $this->input->post('emp_mobile'),
								'emp_id' 		=> $employee_id,
								'ledger_isaprv' => 1,
								'actype' 		=> 'EXPENSES'
							);
							
							$leid = $this->Common_Model->dbinsertid("ledgers",$data_list);

					}

					$education_level = $this->input->post('education_level');

		if (!empty($education_level)) {

    	$this->load->library('upload');

    	foreach ($education_level as $i => $degree) {

        if (trim($degree) === '') {
            continue;
        }

        $edu_data = [
            'employee_id'   => $employee_id,
            'degree'        => $degree,
            'qualification' => $this->input->post('qualification')[$i] ?? null,
            'board'         => $this->input->post('board')[$i] ?? null,
            'institute'     => $this->input->post('institute')[$i] ?? null,
            'passing_year'  => $this->input->post('year')[$i] ?? null,
            'percentage'    => $this->input->post('percentage')[$i] ?? null,
            'created_on'    => date('Y-m-d H:i:s')
        ];

        if (!empty($_FILES['emp_cert']['name'][$i])) {

            $_FILES['file']['name']     = $_FILES['emp_cert']['name'][$i];
            $_FILES['file']['type']     = $_FILES['emp_cert']['type'][$i];
            $_FILES['file']['tmp_name'] = $_FILES['emp_cert']['tmp_name'][$i];
            $_FILES['file']['error']    = $_FILES['emp_cert']['error'][$i];
            $_FILES['file']['size']     = $_FILES['emp_cert']['size'][$i];

            $config = [
                'upload_path'   => './uploads/education/',
                'allowed_types' => 'pdf|jpg|jpeg|png',
                'encrypt_name'  => true,
                'max_size'      => 2048
            ];

            $this->upload->initialize($config);

            if ($this->upload->do_upload('file')) {
                $fileData = $this->upload->data();
                $edu_data['certificate'] = $fileData['file_name'];
            }
        }

        $this->Common_Model->dbinsertid('employee_education', $edu_data);
    	}
		}

		$employers = $this->input->post('employer');

		$from_dates = $this->input->post('from_date');
		$to_dates   = $this->input->post('to_date');

		if (!empty($employers)) {

    	foreach ($employers as $i => $employer) {

        if (trim($employer) === '') {
            continue;
        }

        $exp_data = [
            'employee_id'      => $employee_id,
            'employer'         => $employer,
            'from_date'        => $from_dates[$i] ?? null,
            'to_date'          => $to_dates[$i] ?? null,
            'designation'      => $this->input->post('designation')[$i] ?? null,
            'salary'           => $this->input->post('salary')[$i] ?? null,
            'responsibilities' => $this->input->post('responsibilities')[$i] ?? null,
            'reason'           => $this->input->post('reason')[$i] ?? null,
            'created_on'       => date('Y-m-d H:i:s')
        ];

        $this->Common_Model->dbinsertid('employee_experience', $exp_data);
    	}
		}

		$ref_names = $this->input->post('ref_name');

		if (!empty($ref_names)) {

    	foreach ($ref_names as $i => $name) {

        if (trim($name) === '') {
            continue;
        }

        $ref_data = [
            'employee_id'  => $employee_id,
            'ref_name'     => $this->security->xss_clean($name),
            'relationship' => $this->security->xss_clean($this->input->post('ref_relationship')[$i] ?? null),
            'organization' => $this->security->xss_clean($this->input->post('ref_organization')[$i] ?? null),
            'phone'        => $this->input->post('ref_phone')[$i] ?? null,
            'email'        => $this->input->post('ref_email')[$i] ?? null,
            'years_known'  => is_numeric($this->input->post('ref_years')[$i] ?? null)
                                ? $this->input->post('ref_years')[$i]
                                : null,
            'created_on'   => date('Y-m-d H:i:s')
        ];

        $this->Common_Model->dbinsertid('employee_references', $ref_data);
    	}
		}

		$skills = $this->input->post('skills');

		if (!empty($skills)) {

    	foreach ($skills as $i => $skill) {

        if (trim($skill) === '') {
            continue;
        }

        $skill_data = [
            'employee_id'   => $employee_id,
            'skill'         => $this->security->xss_clean($skill),
            'certification' => $this->security->xss_clean(
                                $this->input->post('certification')[$i] ?? null
                              ),
            'organization'  => $this->security->xss_clean(
                                $this->input->post('organization')[$i] ?? null
                              ),
        ];

        $this->Common_Model->dbinsertid('employee_skills', $skill_data);
    	}
		}


		$id_data = [
    	'employee_id' => $employee_id,
    	'dl_no'       => trim($this->input->post('emp_dl', true)),
    	'passport_no' => trim($this->input->post('emp_passport', true)),
    	'voter_id'    => trim($this->input->post('emp_voter', true)),
    	'created_on'  => date('Y-m-d H:i:s')
		];

		$this->db->insert('employee_id_details', $id_data);


		$medical_data = [
    		'employee_id'         => $employee_id,
    		'medical_history'     => trim($this->input->post('emp_medh', true)),
    		'allergies'           => trim($this->input->post('allergy', true)),
    		'regular_medications' => trim($this->input->post('reg_med', true)),
    		'doctor_name'         => trim($this->input->post('emp_doc', true)),
    		'doctor_contact'      => trim($this->input->post('doc_no', true)),
    		'created_on'          => date('Y-m-d H:i:s')
		];

    	$medical_data['created_on'] = date('Y-m-d H:i:s');

    	$this->db->insert('employee_medical', $medical_data);


				$this->session->set_flashdata('success', 'employee Added successfully.' );
				redirect('employee/viewemployee/'.$employee_id);
			}else{
				$this->session->set_flashdata('error', validation_errors());
			}
		}
		$data['activemenu'] = 'employee';
		$data['activesubmenu'] = 'addemployee';
		
		$data['department'] = $this->Common_Model->FetchData("department ", "*", "1 ORDER BY department_name ASC");
		$data['department'] = $this->Common_Model->FetchData("department ", "*", "1 ORDER BY department_name ASC");

		$data['units'] = $this->Common_Model->FetchData("units", "*", "1 ORDER BY unit_id ASC");
		$data['branch'] = $this->Common_Model->FetchData("branch ", "*", "1 ORDER BY branch_id ASC");
		$data['getepfAmt'] 			= $this->Common_Model->FetchData("epf", "*", "");
		$data['wages'] 	= $this->Common_Model->FetchData("wages", "*", "wages_active = 'Active' ORDER BY sequence ASC");
		$data['state'] 	= $this->Common_Model->FetchData("state", "*", "1 ORDER BY state_title ASC");
		$data['items'] 	= $this->Common_Model->FetchData("assets", "*", "item_type='Asset' ORDER BY item_name ASC");
		$data['getPaymentHeads'] 	= $this->Common_Model->FetchData("wages", "*", "wages_active = 'Active' order by sequence ASC"); 
		$data['access'] = $this->Common_Model->FetchData("menu_access", "*", "1");

		$start  = date('Y-01-01');
        $end = date('Y-12-31');
		$data['months'] = $this->Common_Model->list_months($start,$end, 'd-m-Y');
		$this->load->view('employee/addemployee', $data);
	}

	function get_UnitByHeadofc(){
		$ledger_id = $this->input->post('emp_headofc');
		$unit = $this->Common_Model->FetchData("units","*","ledger_id=".$ledger_id."");
		$html='<option value="">None</option>';
		if ($unit) { for ($i=0; $i < count($unit) ; $i++) { 
			$html .='<option value="'.$unit[$i]['unit_id'].'">'.$unit[$i]['unit_name'].'</option>';
		}}
		echo $html;
	}

	function viewemployee($employee_id = 0){
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$data['activemenu'] = 'employee';
		$data['activesubmenu'] = 'listemployee';
		$data['employee_id'] = $employee_id;
		$data['employee'] = $employee = $this->Common_Model->db_query("SELECT em.employee_id, em.view_psw, em.emp_doj, em.employee_name, em.department_id, em.emp_fathername, em.aadhar_number, em.emp_mobile, em.employee_mobile2, em.emp_landmark, em.employee_email, em.emp_status, em.epf_status, em.emp_cat, em.epf_percentile, em.emp_firstname, em.emp_lastname, em.emp_dob, em.emp_photo, em.bank_name, em.ac_no, em.ifsc, d.department_name, d.shift_id, d.start_time, d.end_time, d.department_active, u.user_id, u.firstname, u.lastname, u.useremail, u.userphone, u.username, u.password, u.usertype, u.created_on, u.last_login_on, u.last_login_ip, u.userstatus, u.access_id, u.employee_tagged_id,bnk.st_bankname,bnk.st_acno,bnk.st_ifsc,em.techno_emp_id, deg.designation_name  FROM employees AS em LEFT JOIN users AS u ON em.employee_id = u.employee_tagged_id LEFT JOIN bankandkyc AS bnk ON em.employee_id = bnk.employee_id LEFT JOIN department AS d ON em.department_id = d.did  LEFT JOIN designation AS deg ON em.designation_id = deg.designation_id WHERE em.employee_id = $employee_id");
		// print_r($employee);exit;
		$this->perPage = 20;
		$rows = $this->Common_Model->FetchPaginationRows("leave_application AS l LEFT JOIN leave_master AS lm ON l.leave_type = lm.leave_id", "lm.leave_id, lm.leave_type, lm.leave_count, lm.is_paid, lm.leave_active, l.leave_apply_id, l.employee_id, l.apply_from, l.apply_to, l.no_of_days, l.session, l.leave_status", "l.employee_id = $employee_id ORDER BY l.created_on DESC", array());
		$datalist = $this->Common_Model->FetchPaginationData("leave_application AS l LEFT JOIN leave_master AS lm ON l.leave_type = lm.leave_id", "lm.leave_id, lm.leave_type, lm.leave_count, lm.is_paid, lm.leave_active, l.leave_apply_id, l.employee_id, l.apply_from, l.apply_to, l.no_of_days, l.session, l.leave_status,l.created_on,l.hfday", "l.employee_id = $employee_id ORDER BY l.created_on DESC", array('limit'=>$this->perPage));
		$param = array();
		$param['employee_id'] = $employee_id;
        $config1['first_link']  = 'First';
        $config1['target']      = '#dataTablediv'; //parent div tag id
        $config1['base_url']    = base_url().'index.php/employee/list_emp_leave_ajax';
        $config1['total_rows']  = $rows;
        $config1['per_page']    = $this->perPage;
        $config1['param_ar']	   = $param;
        $this->ajax_pagination->initialize($config1);
		$data['leaves'] = $datalist;
		$data['leavetypes'] = $this->Common_Model->FetchData("leave_master", "*", "leave_active = 'Active'");
		$curSession    				= $this->session->userdata['session_name'];
		$data['curSession']			= $curSession;
		/*$data['salaries'] 	= $this->Common_Model->FetchData("salary_transaction", "*", "session = '".$curSession."' AND employee_id = ".$employee_id);*/
		$data['getepfAmt'] 			= $this->Common_Model->FetchData("epf", "*", "");
		$data['getPaymentHeads'] 	= $this->Common_Model->FetchData("wages", "*", "wages_active = 'Active' order by sequence ASC"); 
		$data['empoyeeSalary'] 	    = $this->Common_Model->FetchData("salary_config", "*", "employee_id = ".$employee_id);
		$data['empoyeeEpf'] 	    = $this->Common_Model->FetchData("employees", "epf_status,epf_percentile,tds_status,tds_percentile,ptax_status,ptax_percentile,tv_status,tv_percentile,internet_status,internet_percentile,electricity_status,electricity_percentile,medical_status,medical_percentile,otherfee_status,otherfee_percentile,total_earning,netsalary_amt", "employee_id = ".$employee_id);
		$data['advsals'] 	= $this->Common_Model->FetchData("adv_salary AS a LEFT JOIN vouchers AS v ON a.voucher_id = v.voucher_id", "*", "a.employee_id = ".$employee_id." ORDER BY advsal_id DESC LIMIT 0, 10");
		$data['salaryslips'] = $this->Common_Model->FetchData("salary_transaction", "*", "credit_status = 1 AND employee_id = ".$employee_id." ORDER BY `year` DESC LIMIT 0, 12");
		
		$data['salstructure'] = $salstructure = $this->Common_Model->FetchData("salary_structure","*","employee_id=".$employee_id."");

		/*$data['salrates'] = $salrates = $this->Common_Model->FetchData("salary_rates","*","employee_id=".$employee_id."");
		
		if(!empty($salrates) && $records[0]['salary_rates_id']){
		   $data['wagebasic'] = $this->Common_Model->FetchData("salary_rates_items","*","salary_rates_id=".$records[0]['salary_rates_id']." AND wages_id=6"); 
		}*/

		$data['salaries'] 	= $this->Common_Model->FetchData("salary_transaction_attribute as a","*","a.employee_id=".$employee[0]['employee_id']." ORDER BY attr_id DESC LIMIT 10");
		
		$data['user'] = $this->Common_Model->FetchData("users","*","user_id=".$employee[0]['user_id']."");
		$data['access'] = $this->Common_Model->FetchData("menu_access", "*", "1");

		$data['wages'] = $this->Common_Model->FetchData("wages","*","1 order by sequence ASC");
		$start  = date('Y-01-01');
        $end = date('Y-12-31');
		$data['months'] = $this->Common_Model->list_months($start,$end, 'd-m-Y');
				// echo '<pre>';print_r($data);exit;


		$this->load->view('employee/viewemployee', $data);
	}
	
	
	public function edituserdetails($user_id=0,$employee_id=0){
			$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		if($this->input->post('submitBtn')){
			$this->form_validation->set_rules('username', 'Username', 'trim|required');

			$this->form_validation->set_error_delimiters('<p class="has-error"><label class="control-label">', '</label></p>');
			if($this->form_validation->run()){
				$data_list = array(
					'username'			=> strtolower($this->input->post('username')),
					'usertype'			=> $this->input->post('usertype'),
					'access_id'			=> $this->input->post('access_id'),
				);
				if($this->input->post("password") != ''){
					$emp_tagId = '';
					$data_list['password'] = md5($this->input->post('password'));
					$datalist['view_psw']  = $this->input->post('password');
				     if($employee_id){
								$emp_tagId  = $employee_id;
				     } 
				}
					$id = $this->Common_Model->update_records("users", "user_id", $user_id, $data_list);
		       if($emp_tagId){
							$emp_id = $this->Common_Model->update_records("employees", "employee_id", $emp_tagId, $datalist);
		       }
				
//echo $emp_id;exit;
				$this->session->set_flashdata('success', 'Data updated successfully.' );
				redirect($_SERVER['HTTP_REFERER']);
			}else{
				$this->session->set_flashdata('error', validation_errors());
			}
		}
		redirect($_SERVER['HTTP_REFERER']);
	}

	public function salaryrates($employee_id = 0)
	{
		error_reporting(0);
		$data = array();
		$data['employee_id'] = $employee_id;
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		if($this->input->post('submitBtn')){
			

					$data_list = array(
					
					'employee_id'  			=> $employee_id,
					'basic_cat'				=> $this->input->post('basic_cat'),
					'ctc_type'				=> $this->input->post('ctc_type'),
					'bonuspercent'			=> $this->input->post('bonuspercent'),
					'salaryvalue'			=> $this->input->post('salaryvalue'),
					'employerpfperc'		=> $this->input->post('employerpfperc'),
					'employeresiperc'		=> $this->input->post('employeresiperc'),
					'grosssalary'			=> $this->input->post('grosssalary'),
					'totdedpermonth'		=> $this->input->post('totdedpermonth'),
					'totdedperannum'		=> $this->input->post('totdedperannum'),
					'totdedperday'			=> $this->input->post('totdedperday'),
					'netsalpermonth'		=> $this->input->post('netsalpermonth'),
					'netsalperannum'		=> $this->input->post('netsalperannum'),
					'netsalperday'			=> $this->input->post('netsalperday'),
					'strcreated_by'			=> $this->session->userdata('user_id'),
					'strcreated_on'			=> date('Y-m-d H:i:s'),

				);

				if ($this->input->post('salary_structure_id') > 0) {
						$this->Common_Model->update_records("salary_structure","salary_structure_id", $this->input->post('salary_structure_id'), $data_list);

						$this->Common_Model->DelData("salary_structure_items","salary_structure_id=".$this->input->post('salary_structure_id')."");

						for ($i=0; $i < count($this->input->post('wages_id')); $i++) { 
							$wages_list = array(
								'salary_structure_id' 	=> $this->input->post('salary_structure_id'), 
								'wages_id' 			=> $this->input->post('wages_id')[$i], 
								'wages_name' 		=> $this->input->post('wages_name')[$i], 
								'permonth' 			=> $this->input->post('permonth')[$i], 
								'perannum' 			=> $this->input->post('perannum')[$i], 
								'perday' 			=> $this->input->post('perday')[$i], 
							);


							 $this->Common_Model->dbinsertid("salary_structure_items",$wages_list);
						}

						$this->session->set_flashdata('success', 'Data Updated successfully.' );
					}else{
						$salary_structure_id = $this->Common_Model->dbinsertid("salary_structure", $data_list);

					if ($salary_structure_id) {
						for ($i=0; $i < count($this->input->post('wages_id')); $i++) { 
							$wages_list = array(
								'salary_structure_id' 	=> $salary_structure_id, 
								'wages_id' 			=> $this->input->post('wages_id')[$i], 
								'wages_name' 		=> $this->input->post('wages_name')[$i], 
								'permonth' 			=> $this->input->post('permonth')[$i], 
								'perannum' 			=> $this->input->post('perannum')[$i], 
								'perday' 			=> $this->input->post('perday')[$i], 
							);

							$salary_structure_items_id = $this->Common_Model->dbinsertid("salary_structure_items",$wages_list);
							}
						}
						$this->session->set_flashdata('success', 'Data Added successfully.' );
					}
					

				redirect($_SERVER['HTTP_REFERER']);
			
			}else{
				$this->session->set_flashdata('error', 'Something went wrong!!');
				redirect($_SERVER['HTTP_REFERER']);
		}
		
	}

	public function Updateclockouttime(){
		$clockouttimelog_id = $this->input->post("clockouttimelog_id");
		$clockouttime = $this->input->post("clockouttime");
		$this->Common_Model->db_query("UPDATE user_attendance_log SET log_datetime = '".$clockouttime."' WHERE attendance_log_id =".$clockouttimelog_id);
		exit;
	}

	public function Updateclockintime(){
		$clockintimelog_id = $this->input->post("clockintimelog_id");
		$clockintime = $this->input->post("clockintime");
		$this->Common_Model->db_query("UPDATE user_attendance_log SET log_datetime = '".$clockintime."' WHERE attendance_log_id =".$clockintimelog_id);
		exit;
	}

	public function attendanceapproval(){
		if ($this->input->post('user_id') > 0) {
			$records = $this->Common_Model->FetchData("empapprove_attendance","*","user_id=".$this->input->post('user_id')." AND month=".$this->input->post('month')." AND year=".$this->input->post('year')."");
			if ($records) {
				$this->session->set_flashdata('error', 'Attendance already added.' );
				redirect($_SERVER['HTTP_REFERER']);
			}
			$employee = $this->Common_Model->db_query("SELECT employee_id,employee_name,techno_emp_id FROM employees WHERE user_id=".$this->input->post('user_id'));
		
			if ($employee) {
				$salrates = $this->Common_Model->db_query("SELECT basic_cat FROM salary_rates WHERE employee_id=".$employee[0]['employee_id']);
				if ($salrates[0]['basic_cat']=='Fix') {
					$data_list = array(
						'user_id'			=> $this->input->post('user_id'),
						'employee_id'		=> $employee[0]['employee_id'],
						'employee_code' 	=> $employee[0]['techno_emp_id'],
						'employee_name' 	=> $employee[0]['employee_name'], 
						'payable_days' 		=> $this->input->post('totatten'),
						'ot_days' 			=> 0, 
						'total_duty' 		=> $this->input->post('totatten'), 
						'extra_hour' 		=> $this->input->post('hours'),
						'extra_min' 		=> $this->input->post('minutes'),
						'year'				=> $this->input->post('year'),
						'month'				=> $this->input->post('month'),
						'entry_date'		=> date('Y-m-d'),
					);
				}else{

					$data_list = array(
						'user_id'			=> $this->input->post('user_id'),
						'employee_id'		=> $employee[0]['employee_id'],
						'employee_code' 	=> $employee[0]['techno_emp_id'],
						'employee_name' 	=> $employee[0]['employee_name'], 
						'payable_days' 		=> $this->input->post('days'),
						'ot_days' 			=> 0, 
						'total_duty' 		=> $this->input->post('days'), 
						'extra_hour' 		=> $this->input->post('hours'),
						'extra_min' 		=> $this->input->post('minutes'),
						'year'				=> $this->input->post('year'),
						'month'				=> $this->input->post('month'),
						'entry_date'		=> date('Y-m-d'),
					);
				}

				$empapprove_attendance_id = $this->Common_Model->dbinsertid("empapprove_attendance", $data_list);
				if ($empapprove_attendance_id) {
					$this->session->set_flashdata('success', 'Data Added successfully.' );
					redirect($_SERVER['HTTP_REFERER']);
				}else{
					$this->session->set_flashdata('error', 'Something went wrong!!' );
					redirect($_SERVER['HTTP_REFERER']);
				}
			}
		}else{
			$this->session->set_flashdata('error', 'Something went wrong!!' );
			
		}
				
		redirect($_SERVER['HTTP_REFERER']);		
				
	}
 
	function list_emp_leave_ajax(){
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
		if(isset($_POST['employee_name']) && $_POST['employee_name'] != ''){
			$sql.= " AND employee_name LIKE '%".$_POST['employee_name']."%'";
			$param['employee_name'] = $_POST['employee_name'];
		}

		if(isset($_POST['employee_email']) && $_POST['employee_email'] != ''){
			$sql.= " AND employee_email LIKE '%".$_POST['employee_email']."%'";
			$param['employee_email'] = $_POST['employee_email'];
		}
		
		if(isset($_POST['employee_mobile']) && $_POST['employee_mobile'] != ''){
			$sql.= " AND employee_mobile LIKE '%".$_POST['employee_mobile']."%'";
			$param['employee_mobile'] = $_POST['employee_mobile'];
		}

		$this->perPage = 20;
		$rows = $this->Common_Model->FetchPaginationRows("leave_application AS l LEFT JOIN leave_master AS lm ON l.leave_type = lm.leave_id", "lm.leave_id, lm.leave_type, lm.leave_count, lm.is_paid, lm.leave_active, l.leave_apply_id, l.employee_id, l.apply_from, l.apply_to, l.no_of_days, l.session, l.leave_status", "$sql ORDER BY l.created_on DESC", array());
		$datalist = $this->Common_Model->FetchPaginationData("leave_application AS l LEFT JOIN leave_master AS lm ON l.leave_type = lm.leave_id", "lm.leave_id, lm.leave_type, lm.leave_count, lm.is_paid, lm.leave_active, l.leave_apply_id, l.employee_id, l.apply_from, l.apply_to, l.no_of_days, l.session, l.leave_status", "$sql ORDER BY l.created_on DESC", array('start' => $offset,'limit'=>$this->perPage));
        $config['first_link']  = 'First';
        $config['target']      = '#dataTablediv';
        $config['base_url']    = base_url().'index.php/employee/list_emp_leave_ajax';
        $config['total_rows']  = $rows;
        $config['per_page']    = $this->perPage;
        $config['param_ar']	   = $param;
        $this->ajax_pagination->initialize($config);
		$data['leaves'] = $datalist;
		$this->load->view('employee/list_emp_leave_ajax', $data);
	}

	function editemployee($employee_id = 0){
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		if($this->input->post('submitBtn')){
			$this->form_validation->set_rules('emp_firstname', 'Employee Name', 'trim|required');
			$this->form_validation->set_rules('emp_department', 'Department', 'trim|required');
			$this->form_validation->set_rules('emp_mobile', 'Mobile', 'trim|required');
			$this->form_validation->set_rules('employee_email', 'Email', 'trim|required');
			
			$this->form_validation->set_error_delimiters('<p class="has-error"><label class="control-label">', '</label></p>');
			if($this->form_validation->run()){
				$data_list = array(
					'employee_name'			=> ucwords($this->input->post('emp_firstname').' '.$this->input->post('emp_middlename').' '.$this->input->post('emp_lastname')),
					'emp_firstname'			=> ucwords($this->input->post('emp_firstname')),
					'emp_middlename'			=> ucwords($this->input->post('emp_middlename')),
					'emp_lastname'			=> ucwords($this->input->post('emp_lastname')),
					'emp_nickname'			=> ucwords($this->input->post('emp_nickname')),
					'emp_appform_no'		=> $this->input->post('emp_appform_no'),
					'techno_emp_id'			=> $this->input->post('techno_emp_id'),
					'employee_email'		=> $this->input->post('employee_email'),
					'emp_status'			=> $this->input->post('emp_status'),
					'emp_dob'				=> $this->input->post('emp_dob'),
					'emp_gender'			=> $this->input->post('emp_gender'),
					'emergency_name'     => $this->input->post('emergency_name'),
					'emergency_relation' => $this->input->post('emergency_relation'),
					'emergency_contact'  =>$this->input->post('emergency_contact'),
					'official_email' => $this->input->post('official_email'),
					'emp_pob' => $this->input->post('emp_pob'),
					'emp_cat'				=> 'Staff',
					'emp_fathername'		=> $this->input->post('emp_fathername'),
					'emp_mothername'		=> $this->input->post('emp_mothername'),
					'emp_doj'				=> $this->input->post('emp_doj'),
					'emp_jobtype'			=> $this->input->post('emp_jobtype'),
					'emp_maritalstatus'		=> $this->input->post('emp_maritalstatus'),
					'emp_spousename'		=> $this->input->post('emp_spousename'),
					'emp_annivdate'			=> $this->input->post('emp_annivdate'),
					'department_id'			=> $this->input->post('emp_department'),
					'designation_id'		=> $this->input->post('emp_designation'),
					'higher_qual'			=> $this->input->post('higher_qual'),
					'emp_father_occ' 		=> $this->input->post('f_occ'),
					'emp_mother_occ' 		=> $this->input->post('m_occ'),
					'emp_spouse_occ' 		=> $this->input->post('s_occ'),
					'exp_year'				=> $this->input->post('exp_year'),
						'emp_plotno'			=> $this->input->post('emp_plotno'),
						'emp_state'				=> $this->input->post('emp_state'),
						'emp_dist'				=> $this->input->post('emp_dist'),
						'emp_curpin'			=> $this->input->post('emp_curpin'),
						'emp_at'				=> $this->input->post('emp_at'),
						'emp_po'				=> $this->input->post('emp_po'),
						'emp_tahsil'			=> $this->input->post('emp_tahsil'),
						'emp_landmark'			=> $this->input->post('emp_landmark'),
					'emp_plotnop'			=> $this->input->post('emp_plotnop'),
					'emp_statep'				=> $this->input->post('emp_statep'),
					'emp_distp'				=> $this->input->post('emp_distp'),
					'emp_curpinp'			=> $this->input->post('emp_curpinp'),
					'emp_atp'				=> $this->input->post('emp_atp'),
					'emp_pop'				=> $this->input->post('emp_pop'),
					'emp_tahsilp'			=> $this->input->post('emp_tahsilp'),
					'emp_landmarkp'			=> $this->input->post('emp_landmarkp'),
                    'dutyhour'				=> $this->input->post('dutyhour'),
					'emp_mobile'			=> $this->input->post('emp_mobile'),
					'emp_amobile'			=> $this->input->post('emp_amobile'),
					'emp_pgmobile'			=> $this->input->post('emp_pgmobile'),
					'emp_age'			=> $this->input->post('emp_age'),
					'emp_bloodgrp'			=> $this->input->post('emp_bloodgrp'),
					'emp_curaddress'		=> '',
					'emp_current'			=> '',
					'emp_curraddress'		=> '',
					'emp_peraddress'		=> '',
					'emp_permanent'		    => '',
					'emp_permaddress'		=> '',
					'emp_perpin'			=> '',
                  	'last_edit_on'			    => date('Y-m-d H:i:s'),
					'last_edit_by'			    => $this->session->userdata("firstname").' '.$this->session->userdata("lastname"),
				);

				if($_FILES['emp_photo']['name']!=""){
					$newfile = preg_replace('/\W+/', '-', strtolower($this->input->post('emp_firstname').' '.$this->input->post('emp_lastname'))).uniqid();
					$config = array(
						'upload_path' => "uploads/employeeicon/",
						'allowed_types' => 'jpg|png|jpeg',
						'overwrite' => TRUE,
						'file_name' => $newfile,
						'max_size' => "200048000" 
					);

					$this->load->library('upload', $config);
					$this->upload->initialize($config);
					if($this->upload->do_upload("emp_photo"))
					{
						$dat = $this->upload->data();
						$data_list['emp_photo'] = $dat['file_name'];
						$this->load->library('image_lib');
			                $config['image_library'] = 'gd2'; // Set your preferred image processing library
					        $config['source_image'] = $dat['full_path'];
					        $config['create_thumb'] = FALSE; // Create a thumbnail version
					        $config['maintain_ratio'] = TRUE;
					        $config['width'] = 50; // Set the width you desire for the thumbnail
					        $config['height'] = 50; // Set the height you desire for the thumbnail
					        $config['quality'] = 50; 
					        $config['new_image']  = 'uploads/employeeicon/' . $dat['file_name'];
					        $this->image_lib->initialize($config);
					        $this->image_lib->resize();
							$this->image_lib->clear();
					}else{
						$filename = '';
						$this->session->set_flashdata('error', $this->upload->display_errors());
						redirect($_SERVER['HTTP_REFERER']);
					}
				}else{ }


				$employee_update = $this->Common_Model->update_records("employees", "employee_id", $employee_id, $data_list);

				$data['bank'] = $this->db
        ->where('employee_id',$employee_id)
        ->get('bankandkyc')
        ->row_array();

				$cheque_file = $this->input->post('old_cheque');

				if (!empty($_FILES['emp_cheque']['name'])) {

    				$config = [
        				'upload_path'   => './uploads/cheques/',
       				 'allowed_types' => 'pdf|jpg|jpeg|png',
       				 'encrypt_name'  => true,
       				 'max_size'      => 2048
   				 ];

   				 $this->load->library('upload', $config);

    				if (!$this->upload->do_upload('emp_cheque')) {

       				 $this->session->set_flashdata('error', $this->upload->display_errors());
       				 redirect($_SERVER['HTTP_REFERER']);
       				 exit;

    				} else {

       				 $uploadData  = $this->upload->data();
        				$cheque_file = $uploadData['file_name'];
    				}
				}

				$bankData = [

    				'st_paymode'      => $this->input->post('st_paymode'),
    				'st_bankname'     => $this->input->post('st_bankname'),
    				'st_branch'       => $this->input->post('st_branch'),
    				'st_acno'         => $this->input->post('st_acno'),
    				'st_acholdername' => $this->input->post('st_acholdername'),
    				'st_ifsc'         => $this->input->post('st_ifsc'),
    				'st_referenceno'  => $this->input->post('st_referenceno'),

    				'emp_cheque'      => $cheque_file,

    				'updated_by'      => $this->session->userdata('user_id'),
    				'updated_on'      => date('Y-m-d H:i:s')

				];

				$bank = $this->db
           				 ->where('employee_id',$employee_id)
           				 ->get('bankandkyc')
           				 ->row_array();

				if($bank){

    				$this->db->where('employee_id',$employee_id);
    				$this->db->update('bankandkyc',$bankData);

				}else{

    				$bankData['employee_id'] = $employee_id;
    				$bankData['created_on']  = date('Y-m-d H:i:s');

    				$this->db->insert('bankandkyc',$bankData);
				}
				$check_id = $this->Common_Model->db_query(
    					"SELECT employee_id FROM employee_id_details WHERE employee_id = $employee_id"
					);

					if ($check_id !== 0) {

    					$id_data = [
        					'dl_no'       => trim($this->input->post('emp_dl', true)),
        					'passport_no' => trim($this->input->post('emp_passport', true)),
        					'voter_id'    => trim($this->input->post('emp_voter', true)),
        					'updated_on'  => date('Y-m-d H:i:s')
    					];

    					$this->db->where('employee_id', $employee_id)
             					->update('employee_id_details', $id_data);

					} else {

    					$id_data = [
        					'employee_id' => $employee_id,
        					'dl_no'       => trim($this->input->post('emp_dl', true)),
        					'passport_no' => trim($this->input->post('emp_passport', true)),
       					 'voter_id'    => trim($this->input->post('emp_voter', true)),
        					'created_on'  => date('Y-m-d H:i:s')
    					];

    					$this->db->insert('employee_id_details', $id_data);
					}

					$medical_data = [
    					'employee_id'         => $employee_id,
   					 'medical_history'     => trim($this->input->post('emp_medh', true)),
   					 'allergies'           => trim($this->input->post('allergy', true)),
   					 'regular_medications' => trim($this->input->post('reg_med', true)),
   					 'doctor_name'         => trim($this->input->post('emp_doc', true)),
   					 'doctor_contact'      => trim($this->input->post('doc_no', true)),
					];

					$exists = $this->db
    					->select('id')
    					->where('employee_id', $employee_id)
   					 ->get('employee_medical')
    					->row_array();

					if (!empty($exists)) {

    					$medical_data['updated_on'] = date('Y-m-d H:i:s');

    					$this->db->where('employee_id', $employee_id)
             					->update('employee_medical', $medical_data);

					} else {

    					$medical_data['created_on'] = date('Y-m-d H:i:s');

    					$this->db->insert('employee_medical', $medical_data);
					}

					$education_level = $this->input->post('education_level');

					if (empty($education_level)) {
    					return;
					}

					$this->db->trans_start();
					$this->load->library('upload');

					$this->db->where('employee_id', $employee_id)
         					->delete('employee_education');

					foreach ($education_level as $i => $degree) {

    					if (empty($degree)) continue;

   					 $edu_data = [
       					 'employee_id'  => (int)$employee_id,
      					  'degree'       => $degree,
       					 'passing_year' => $_POST['year'][$i] ?? null,
       					 'board'        => $_POST['board'][$i] ?? null,
     					   'institute'    => $_POST['institute'][$i] ?? null,
       					 'qualification'=> $_POST['qualification'][$i] ?? null,
       					 'percentage'   => $_POST['percentage'][$i] ?? null,
       					 'created_on'   => date('Y-m-d H:i:s')
   					 ];

						if (!empty($_FILES['emp_cert']['name'][$i])) {

            $_FILES['file']['name']     = $_FILES['emp_cert']['name'][$i];
            $_FILES['file']['type']     = $_FILES['emp_cert']['type'][$i];
            $_FILES['file']['tmp_name'] = $_FILES['emp_cert']['tmp_name'][$i];
            $_FILES['file']['error']    = $_FILES['emp_cert']['error'][$i];
            $_FILES['file']['size']     = $_FILES['emp_cert']['size'][$i];

            $config = [
                'upload_path'   => './uploads/education/',
                'allowed_types' => 'pdf|jpg|jpeg|png',
                'encrypt_name'  => true,
                'max_size'      => 2048 // 2MB
            ];

            $this->upload->initialize($config);

            if ($this->upload->do_upload('file')) {
                $fileData = $this->upload->data();
                $edu_data['certificate'] = $fileData['file_name'];
            }
        }
    	$this->db->insert('employee_education', $edu_data);
		}


				$this->db->trans_complete();

				$employer = $this->input->post('employer');
				$exp_ids  = $this->input->post('exp_id');
				$from_dates = $this->input->post('from_date');
				$to_dates   = $this->input->post('to_date');

				if (!empty($employer)) {

    				$saved_ids = [];

    				foreach ($employer as $i => $emp) {

       				 if (trim($emp) === '') {
            continue;
        				}

       				 $exp_data = [
            				'employee_id'      => $employee_id,
            				'employer'         => $emp,
            				'from_date' => $from_dates[$i] ?? null,
							'to_date'   => $to_dates[$i] ?? null,
            'designation'      => $this->input->post('designation')[$i] ?? null,
           				 'salary'           => $this->input->post('salary')[$i] ?? null,
           				 'responsibilities' => $this->input->post('responsibilities')[$i] ?? null,
          				  'reason'           => $this->input->post('reason')[$i] ?? null,
        				];

        				if (!empty($exp_ids[$i])) {

           				 // $exp_data['updated_on'] = date('Y-m-d H:i:s');

            				$this->db->where('id', $exp_ids[$i])
                  				   ->update('employee_experience', $exp_data);

           				 $saved_ids[] = $exp_ids[$i];

        				} else {

            				$exp_data['created_on'] = date('Y-m-d H:i:s');

           				 $this->db->insert('employee_experience', $exp_data);
           				 $saved_ids[] = $this->db->insert_id();
        				}
    				}

    				if (!empty($saved_ids)) {
        $this->db->where('employee_id', $employee_id)
                 ->where_not_in('id', $saved_ids)
                 ->delete('employee_experience');
   				 }
				}

				$ref_names = $this->input->post('ref_name');
				$ref_ids   = $this->input->post('ref_id');

				if (!empty($ref_names)) {

   				 $saved_ids = [];

   				 foreach ($ref_names as $i => $name) {

        				if (trim($name) === '') {
            				continue;
        				}

        				$ref_data = [
            				'employee_id'   => $employee_id,
            				'ref_name'      => $name,
            				'relationship'  => $this->input->post('ref_relationship')[$i] ?? null,
            				'organization'  => $this->input->post('ref_organization')[$i] ?? null,
            				'phone'         => $this->input->post('ref_phone')[$i] ?? null,
            				'email'         => $this->input->post('ref_email')[$i] ?? null,
            				'years_known'   => $this->input->post('ref_years')[$i] ?? null,
        				];

        if (!empty($ref_ids[$i])) {

            // $ref_data['updated_on'] = date('Y-m-d H:i:s');

            $this->db->where('id', $ref_ids[$i])
                     ->update('employee_references', $ref_data);

            $saved_ids[] = $ref_ids[$i];

        } else {

            $ref_data['created_on'] = date('Y-m-d H:i:s');

            $this->db->insert('employee_references', $ref_data);
            $saved_ids[] = $this->db->insert_id();
        }
    		}

    		if (!empty($saved_ids)) {
        	$this->db->where('employee_id', $employee_id)
                 ->where_not_in('id', $saved_ids)
                 ->delete('employee_references');
    		}
				}

				$chekEmpDataexist = $this->Common_Model->db_query("SELECT COUNT(1) as tot FROM users WHERE employee_tagged_id = ".$employee_id);
				
				
				if($chekEmpDataexist[0]['tot'] > 0){
					$data_lists = array(
						'firstname'         => ucwords($this->input->post('emp_firstname')),
						'lastname'          => ucwords($this->input->post('emp_lastname')),
						'useremail'         => $this->input->post('employee_email'),
						'userphone'			=> $this->input->post('emp_mobile')
					);
                 
					$id = $this->Common_Model->update_records("users", "employee_tagged_id", $employee_id, $data_lists);
				}
				
				$employee = $this->Common_Model->FetchData("employees","*","employee_id=".$employee_id);

				$ledger = $this->Common_Model->FetchData("ledgers","*","emp_id=".$employee_id);
				if ($ledger) {
						$data_list = array(
								'ledger_name'		=> ucwords($this->input->post('emp_firstname').' '.$this->input->post('emp_middlename').' '.$this->input->post('emp_lastname')),
								'email'					=> $this->input->post('employee_email'),
								'mobile'				=> $this->input->post('emp_mobile'),
								
							);
							
							$this->Common_Model->update_records("ledgers","emp_id",$employee_id,$data_list);
				}else{
				    $data_list = array(
								'ledger_name'		=> ucwords($this->input->post('emp_firstname').' '.$this->input->post('emp_middlename').' '.$this->input->post('emp_lastname')),
								'ledger_alias'	=> $employee[0]['techno_emp_id'].'.10',
								'acount_group'	=> 81,
								'email'			=> $this->input->post('employee_email'),
								'mobile'		=> $this->input->post('emp_mobile'),
								'emp_id' 		=> $employee_id,
								'ledger_isaprv' => 1,
								'actype' 		=> 'SALARY'
							);
							
							$leid = $this->Common_Model->dbinsertid("ledgers",$data_list);

							$data_list = array(
								'ledger_name'		=> ucwords($this->input->post('emp_firstname').' '.$this->input->post('emp_middlename').' '.$this->input->post('emp_lastname')),
								'ledger_alias'	=> $employee[0]['techno_emp_id'].'.20',
								'acount_group'	=> 96,
								'email'			=> $this->input->post('employee_email'),
								'mobile'		=> $this->input->post('emp_mobile'),
								'emp_id' 		=> $employee_id,
								'ledger_isaprv' => 1,
								'actype' 		=> 'ADVANCE'
							);
							
							$leid = $this->Common_Model->dbinsertid("ledgers",$data_list);

						    
							$data_list = array(
								'ledger_name'		=> ucwords($this->input->post('emp_firstname').' '.$this->input->post('emp_middlename').' '.$this->input->post('emp_lastname')),
								'ledger_alias'	=> $employee[0]['techno_emp_id'].'.30',
								'acount_group'	=> 96,
								'email'			=> $this->input->post('employee_email'),
								'mobile'		=> $this->input->post('emp_mobile'),
								'emp_id' 		=> $employee_id,
								'ledger_isaprv' => 1,
								'actype' 		=> 'EXPENSES'
							);
							
							$leid = $this->Common_Model->dbinsertid("ledgers",$data_list);
				}
				$this->session->set_flashdata('success', 'employee Updated successfully.' );
				redirect('employee');
			}else{
				$this->session->set_flashdata('error', validation_errors());
			}
				}
				$data['activemenu'] = 'employee';
				$data['activesubmenu'] = 'listemployee';
				$data['employee'] =$employee= $this->Common_Model->FetchData("employees", "*", "employee_id = ".$employee_id);
				$data['department'] = $this->Common_Model->FetchData("department ", "*", "1 ORDER BY department_name ASC");
        		$data['ledger'] = $this->Common_Model->FetchData("ledgers as a LEFT JOIN under_group as b on a.acount_group=b.group_id", "*", "b.category='Debit' 		ORDER BY a.ledger_name ASC");
				$data['units'] = $this->Common_Model->FetchData("units ", "*", "1 ORDER BY unit_id ASC");
				$data['branch'] = $this->Common_Model->FetchData("branch ", "*", "1 ORDER BY branch_id ASC");
				$data['state'] 	= $this->Common_Model->FetchData("state", "*", "1 ORDER BY state_title ASC");
				if ($employee && $employee[0]['emp_state']) {
					$data['district'] 	= $this->Common_Model->FetchData("district", "*", "state_id=".$employee[0]['emp_state']." ORDER BY district_title ASC");
				}else{
					$data['district'] = '';
				}

				if ($employee && $employee[0]['emp_statep']) {
					$data['districtp'] 	= $this->Common_Model->FetchData("district", "*", "state_id=".$employee[0]['emp_statep']." ORDER BY district_title ASC");
				}else{
					$data['districtp'] = '';
				}
		
					$data['designation'] = $this->Common_Model->FetchData("designation ", "*", "department_id=".$employee[0]['department_id']." ORDER BY 			designation_name ASC");

					$data['employee_id_details'] = $this->Common_Model->FetchData(
    					"employee_id_details",
    					"*",
    					"employee_id=".$employee_id
					);

		$data['education'] = $this->Common_Model->FetchData(
		    "employee_education",
		    "*",
		    "employee_id=".$employee_id." ORDER BY id ASC"
		);

		$data['experience'] = $this->Common_Model->FetchData(
		    "employee_experience",
		    "*",
		    "employee_id=".$employee_id." ORDER BY id ASC"
		);

		$data['references'] = $this->Common_Model->FetchData(
		    "employee_references",
		    "*",
		    "employee_id=".$employee_id." ORDER BY id ASC"
		);

		$data['medical'] = $this->Common_Model->FetchData(
		    "employee_medical",
		    "*",
		    "employee_id=".$employee_id." ORDER BY id ASC"
		);

		$data['bank'] = $this->db
        ->where('employee_id',$employee_id)
        ->get('bankandkyc')
        ->row_array();
				$this->load->view('employee/editemployee', $data);
}
  
  function employee_configur(){
		$records = $this->Common_Model->FetchData("employees","*","emp_cat='Others' ORDER BY employee_id ASC");
		if ($records) { for ($i=0; $i <count($records) ; $i++) { 
			$spchar = str_split("@#$%*()?");
				shuffle($spchar);
				if(rand(1, 20) > 10){
					$password = rand(10, 99).substr(strtolower($records[$i]['emp_firstname']), 0, 2).substr(strtolower($records[$i]['emp_lastname']), 0, 2).substr(strtolower($records[$i]['session_id']), 0, 2).$spchar[1];
				}else{
					$password = rand(10, 99).substr(strtoupper($records[$i]['emp_firstname']), 0, 2).substr(strtolower($records[$i]['emp_lastname']), 0, 2).substr(strtolower($records[$i]['session_id']), 0, 2).$spchar[1];
				}
			$usernm = strip_tags(stripslashes($records[$i]['emp_mobile']));
			$passw = md5($password);
			$user = $this->Common_Model->FetchData("users", "*", "username = '".$usernm."' AND password = '".$passw."' AND userstatus = 1");
			if ($user) {
				
			}else{
			$data_list = array(
					'firstname'         => ucwords($records[$i]['emp_firstname']),
					'lastname'          => ucwords($records[$i]['emp_lastname']),
					'userphone'			=> $records[$i]['emp_mobile'],
					'username'			=> $records[$i]['emp_mobile'],
					'password'			=> md5($password),
					'usertype'			=> 'Others',
					'access_id'			=> 0,
					'created_on'		=> date('Y-m-d H:i:s'),
					'userstatus'		=> '1',
					'employee_tagged_id'	=> $records[$i]['employee_id'],
					'usercategory'		=> 0,
				);
				$user_id = $this->Common_Model->dbinsertid("users", $data_list);
				if ($user_id) {
					$this->Common_Model->db_query("UPDATE employees SET view_psw ='".$password."' WHERE employee_id=".$records[$i]['employee_id']."");
				}
			}
		}}
		echo 'Success';exit;
	}

	function deleteemployee($employee_id = 0){
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$this->Common_Model->DelData("employees", "employee_id = ".$employee_id);
		$this->Common_Model->DelData("bankandkyc", "employee_id = ".$employee_id);
		$this->Common_Model->DelData("pfandesi", "employee_id = ".$employee_id);
		$this->Common_Model->DelData("salary_config", "employee_id = ".$employee_id);
		$this->Common_Model->DelData("salary_transaction", "employee_id = ".$employee_id);
		$this->Common_Model->DelData("salary_transaction_attribute", "employee_id = ".$employee_id);
		$this->Common_Model->DelData("users", "employee_tagged_id = ".$employee_id);
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	function bankandkyc($employee_id = 0){
		error_reporting(0);
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$data['employee'] = $employee = $this->Common_Model->FetchData("employees","*","employee_id=".$employee_id."");
		if($this->input->post('submitBtn')){
			$this->form_validation->set_rules('kyc_adharno', 'Aadhaar No.', 'trim|required');
			$this->form_validation->set_rules('kyc_adharstate', 'Aadhaar State', 'trim|required');
			
			$this->form_validation->set_error_delimiters('<p class="has-error"><label class="control-label">', '</label></p>');
			if($this->form_validation->run()){

				$datalist = array(
					'st_paymode' 			=> $this->input->post('st_paymode'), 
						'st_bankname' 			=> $this->input->post('st_bankname'), 
						'st_acno' 				=> $this->input->post('st_acno'), 
						'st_acholdername' 		=> $this->input->post('st_acholdername'), 
						'st_ifsc' 				=> $this->input->post('st_ifsc'), 
						'st_referenceno' 		=> $this->input->post('st_referenceno'), 
						 
						'physicalchallenged' 	=> $this->input->post('physicalchallenged'), 
						'int_worker' 			=> $this->input->post('int_worker'), 
						'place_oforigin' 		=> $this->input->post('place_oforigin'), 
						
						 
						'kyc_panno' 			=> $this->input->post('kyc_panno'), 
						'kyc_panname' 			=> $this->input->post('kyc_panname'), 
						'kyc_adharno' 			=> $this->input->post('kyc_adharno'), 
						 
						'kyc_adharname' 		=> $this->input->post('kyc_adharname'), 
						'kyc_adharstate' 		=> $this->input->post('kyc_adharstate'), 
						'updated_by' 			=> $this->session->userdata('user_id'), 
						'updated_on' 			=> date('Y-m-d H:i:s')
				);


				$this->Common_Model->update_records("bankandkyc","employee_id",$employee_id,$datalist);

				$this->session->set_flashdata('success', 'Bank and KYC Details Updated successfully.' );
				redirect($_SERVER['HTTP_REFERER']);
				//redirect('employee/bankandkyc/'.$employee_id);
			}else{
				$this->session->set_flashdata('error', validation_errors());
				redirect($_SERVER['HTTP_REFERER']);
			}
		}

		$data['state'] = $state = $this->Common_Model->FetchData("state","*","1 order by state_title ASC");
		$data['rec'] = $this->Common_Model->FetchData("bankandkyc","*","employee_id=".$employee_id."");
		$data['activemenu'] = 'employee';
		$data['activesubmenu'] = 'listemployee';
		$this->load->view('employee/bankandkyc', $data);
	}

	function pfandesi($employee_id = 0){
		error_reporting(0);
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$data['employee'] = $employee = $this->Common_Model->FetchData("employees","*","employee_id=".$employee_id."");
		if($this->input->post('submitBtn')){
			$this->form_validation->set_rules('employee_id', 'Employee Id', 'trim|required');
			
			$this->form_validation->set_error_delimiters('<p class="has-error"><label class="control-label">', '</label></p>');
			if($this->form_validation->run()){

				$datalist = array(
					'emp_ispf' 				=> $this->input->post('emp_ispf'), 
					'pf_number' 			=> $this->input->post('pf_number'), 
					'emp_ispmjjy' 			=> $this->input->post('emp_ispmjjy'), 
					'emp_isesi' 			=> $this->input->post('emp_isesi'), 
					'esi_number' 			=> $this->input->post('esi_number'), 
					'emp_ispmsvy' 			=> $this->input->post('emp_ispmsvy'), 
					'updated_by' 			=> $this->session->userdata('user_id'), 
					'updated_on' 			=> date('Y-m-d H:i:s') 
				);


				$this->Common_Model->update_records("pfandesi","employee_id",$employee_id,$datalist);

				$this->session->set_flashdata('success', 'PF and ESI Settings Updated successfully.' );
				//redirect('employee/pfandesi/'.$employee_id);
				redirect($_SERVER['HTTP_REFERER']);
			}else{
				$this->session->set_flashdata('error', validation_errors());
				redirect($_SERVER['HTTP_REFERER']);
			}
		}

		$data['rec'] = $this->Common_Model->FetchData("pfandesi","*","employee_id=".$employee_id."");
		$data['activemenu'] = 'employee';
		$data['activesubmenu'] = 'listemployee';
		$this->load->view('employee/pfandesi', $data);
	}

	public function aadhardetails($employee_id = 0){
		error_reporting(0);
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$data['employee'] = $employee = $this->Common_Model->FetchData("employees","*","employee_id=".$employee_id."");
		if (empty($employee)) {
			$this->session->set_flashdata('error', 'Employee data not found!!' );
				redirect($_SERVER['HTTP_REFERER']);
		}
		if($this->input->post('submitBtn')){
				$records = $this->Common_Model->FetchData("aadhardetails","*","employee_id=".$employee_id);
				$datalist = array(
					'employee_id' 			=> $employee_id, 
					'adhr_name' 			=> $this->input->post('adhr_name'), 
					'adhr_plotno' 			=> $this->input->post('adhr_plotno'), 
					'adhr_state' 			=> $this->input->post('adhr_state'), 
					'adhr_dist' 			=> $this->input->post('adhr_dist'), 
					'adhr_contactno' 		=> $this->input->post('adhr_contactno'), 
					'adhr_at' 				=> $this->input->post('adhr_at'), 
					'adhr_po' 				=> $this->input->post('adhr_po'), 
					'adhr_tahsil' 			=> $this->input->post('adhr_tahsil'), 
					'adhr_pincode' 			=> $this->input->post('adhr_pincode'), 
					'adhr_landmark' 		=> $this->input->post('adhr_landmark'), 
					'adhr_email' 			=> $this->input->post('adhr_email'), 
					'adhrupdated_by' 			=> $this->session->userdata('user_id'), 
					'adhrupdated_on' 			=> date('Y-m-d H:i:s') 
				);

				if ($records) {
					$this->Common_Model->update_records("aadhardetails","employee_id",$employee_id,$datalist);
				}else{
					$this->Common_Model->dbinsertid("aadhardetails",$datalist);
				}
				

				$this->session->set_flashdata('success', 'Aadhaar Details Updated successfully.' );
				redirect($_SERVER['HTTP_REFERER']);
		}else{
			$this->session->set_flashdata('error', 'Something went wrong!!');
		}
		redirect($_SERVER['HTTP_REFERER']);
	}

	public function nomineedetails($employee_id = 0){
		error_reporting(0);
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$data['employee'] = $employee = $this->Common_Model->FetchData("employees","*","employee_id=".$employee_id."");
		if (empty($employee)) {
			$this->session->set_flashdata('error', 'Employee data not found!!' );
				redirect($_SERVER['HTTP_REFERER']);
		}
		if($this->input->post('submitBtn')){
				$records = $this->Common_Model->FetchData("nomineedetails","*","employee_id=".$employee_id);
				$datalist = array(
					'employee_id' 			=> $employee_id, 
					'no_name' 				=> $this->input->post('no_name'), 
					'no_plotno' 			=> $this->input->post('no_plotno'), 
					'no_po' 				=> $this->input->post('no_po'), 
					'no_state' 				=> $this->input->post('no_state'), 
					'no_pincode' 			=> $this->input->post('no_pincode'), 
					'no_contactno' 			=> $this->input->post('no_contactno'), 
					'no_relationship' 		=> $this->input->post('no_relationship'), 
					'no_at' 				=> $this->input->post('no_at'), 
					'no_tahsil' 			=> $this->input->post('no_tahsil'), 
					'no_dist' 				=> $this->input->post('no_dist'), 
					'no_landmark' 			=> $this->input->post('no_landmark'), 
					'no_email' 				=> $this->input->post('no_email'), 
					'noupdated_by' 			=> $this->session->userdata('user_id'), 
					'noupdated_on' 			=> date('Y-m-d H:i:s') 
				);

				if ($records) {
					$this->Common_Model->update_records("nomineedetails","employee_id",$employee_id,$datalist);
				}else{
					$this->Common_Model->dbinsertid("nomineedetails",$datalist);
				}
				

				$this->session->set_flashdata('success', 'Nominee Details Updated successfully.' );
				redirect($_SERVER['HTTP_REFERER']);
		}else{
			$this->session->set_flashdata('error', 'Something went wrong!!');
		}
		redirect($_SERVER['HTTP_REFERER']);
	}

	public function familydetails($employee_id = 0){
		error_reporting(0);
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$data['employee'] = $employee = $this->Common_Model->FetchData("employees","*","employee_id=".$employee_id."");
		if (empty($employee)) {
			$this->session->set_flashdata('error', 'Employee data not found!!' );
				redirect($_SERVER['HTTP_REFERER']);
		}
		if($this->input->post('submitBtn')){
				$records = $this->Common_Model->FetchData("familydetails","*","employee_id=".$employee_id);
				if ($records) {
					$this->Common_Model->DelData("familydetails","employee_id=".$employee_id);
				}
				foreach ($this->input->post('m_name[]') as $key => $value) {
					
				 	if($this->input->post("m_name[".$key."]") != ''){
						
		 				$this->Common_Model->dbinsertid("familydetails", 
		 				array(
		 					"employee_id"		=> $employee_id,
		 					"m_name" 			=> $this->input->post("m_name[".$key."]"),
		 					"m_dob" 			=> $this->input->post("m_dob[".$key."]"),
		 					"m_relationship" 	=> $this->input->post("m_relationship[".$key."]"),
		 					
							)
						);

					}
				}

				$this->session->set_flashdata('success', 'Family Details Updated successfully.' );
				redirect($_SERVER['HTTP_REFERER']);
		}else{
			$this->session->set_flashdata('error', 'Something went wrong!!');
		}
		redirect($_SERVER['HTTP_REFERER']);
	}

	public function trainingdetails($employee_id = 0){
		error_reporting(0);
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$data['employee'] = $employee = $this->Common_Model->FetchData("employees","*","employee_id=".$employee_id."");
		if (empty($employee)) {
			$this->session->set_flashdata('error', 'Employee data not found!!' );
				redirect($_SERVER['HTTP_REFERER']);
		}
		if($this->input->post('submitBtn')){
				$records = $this->Common_Model->FetchData("trainingdetails","*","employee_id=".$employee_id);
				if ($records) {
					$this->Common_Model->DelData("trainingdetails","employee_id=".$employee_id);
				}
				foreach ($this->input->post('trainingtype[]') as $key => $value) {
					
				 	if($this->input->post("trainingtype[".$key."]") != ''){
						
		 				$this->Common_Model->dbinsertid("trainingdetails", 
		 				array(
		 					"employee_id"		=> $employee_id,
		 					"trainingtype" 		=> $this->input->post("trainingtype[".$key."]"),
		 					"topicname" 		=> $this->input->post("topicname[".$key."]"),
		 					"institutename" 	=> $this->input->post("institutename[".$key."]"),
		 					"sponseredby" 		=> $this->input->post("sponseredby[".$key."]"),
		 					"datefrom" 			=> $this->input->post("datefrom[".$key."]"),
		 					"dateto" 			=> $this->input->post("dateto[".$key."]"),
		 					
							)
						);

					}
				}

				$this->session->set_flashdata('success', 'Training Details Updated successfully.' );
				redirect($_SERVER['HTTP_REFERER']);
		}else{
			$this->session->set_flashdata('error', 'Something went wrong!!');
		}
		redirect($_SERVER['HTTP_REFERER']);
	}

	public function ecademicdetails($employee_id = 0){
		error_reporting(0);
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$data['employee'] = $employee = $this->Common_Model->FetchData("employees","*","employee_id=".$employee_id."");
		if (empty($employee)) {
			$this->session->set_flashdata('error', 'Employee data not found!!' );
				redirect($_SERVER['HTTP_REFERER']);
		}
		if($this->input->post('submitBtn')){
				$records = $this->Common_Model->FetchData("ecademicdetails","*","employee_id=".$employee_id);
				if ($records) {
					$this->Common_Model->DelData("ecademicdetails","employee_id=".$employee_id);
				}
				foreach ($this->input->post('examination_passed[]') as $key => $value) {
					
				 	if($this->input->post("examination_passed[".$key."]") != ''){
						
		 				$this->Common_Model->dbinsertid("ecademicdetails", 
		 				array(
		 					"employee_id"		=> $employee_id,
		 					"examination_passed" => $this->input->post("examination_passed[".$key."]"),
		 					"name_univercity" 	=> $this->input->post("name_univercity[".$key."]"),
		 					"year_passing" 		=> $this->input->post("year_passing[".$key."]"),
		 					"p_mark" 			=> $this->input->post("p_mark[".$key."]"),
		 					"stream" 			=> $this->input->post("stream[".$key."]"),
		 					"grade" 			=> $this->input->post("grade[".$key."]"),
		 					
							)
						);

					}
				}

				$this->session->set_flashdata('success', 'Ecademic Details Updated successfully.' );
				redirect($_SERVER['HTTP_REFERER']);
		}else{
			$this->session->set_flashdata('error', 'Something went wrong!!');
		}
		redirect($_SERVER['HTTP_REFERER']);
	}

	function get_designationByDept(){
		$department_id = $this->input->post('department_id');
		$rec = $this->Common_Model->FetchData("designation","*","department_id=".$department_id." order by designation_id ASC");

		$html='<option value="">None</option>';
		if ($rec) { for ($i=0; $i < count($rec); $i++) { 
			$html.='<option value="'.$rec[$i]['designation_id'].'">'.$rec[$i]['designation_name'].'</option>';
		}}
		echo $html;
	}

	function salaryconfig($employeeId = 0){
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$data['employeeId'] 		= $employeeId;
		$data['getepfAmt'] 			= $this->Common_Model->FetchData("epf", "*", "");
		$data['getPaymentHeads'] 	= $this->Common_Model->FetchData("wages", "*", "wages_active = 'Active' ");
		$data['empoyeeSalary'] = $empoyeeSalary = $this->Common_Model->FetchData("salary_config", "*", "employee_id = ".$employeeId);
		$data['empoyeeEpf'] 	    = $this->Common_Model->FetchData("employees", "epf_status,epf_percentile,tds_status,tds_percentile,ptax_status,ptax_percentile,tv_status,tv_percentile,internet_status,internet_percentile,electricity_status,electricity_percentile,medical_status,medical_percentile,otherfee_status,otherfee_percentile,total_earning,netsalary_amt", "employee_id = ".$employeeId);
		//echo '<pre>';print_r($data['empoyeeEpf']);exit;
		if($this->input->post('submitBtn')){
			$totalSalaryhead = count($data['getPaymentHeads']);
			$totalSalary     = 0;
			$query           = '';
			$newinsert = 0;
			if($empoyeeSalary){
				$newinsert++;
				$this->Common_Model->DelData("salary_config", "employee_id = ".$employeeId);
			}
			for($i = 1; $i<=$totalSalaryhead; $i++){
				$wgId          = $data['getPaymentHeads'][$i-1]['wages_id'];
				
				$de = $this->Common_Model->FetchData("wages", "deduction", "wages_id = '$wgId'");
				if($de == '0'){
                	$totalSalary   = ($totalSalary+$this->input->post('input_value_'.$wgId)[2]);
				}
				
				$config_id     = $this->input->post('input_value_'.$wgId)[0];
				$salary_head   = $this->input->post('input_value_'.$wgId)[1];
				$salary_value  = $this->input->post('input_value_'.$wgId)[2];
				
				$query .= "(".$config_id.",".$employeeId.",".$salary_head.",".$salary_value."),";
				$this->Common_Model->db_query("INSERT INTO salary_config SET config_id = $config_id,	employee_id = $employeeId, salary_head = $salary_head, salary_value = $salary_value");
			}

			$query = rtrim($query,',');
			
				$data_lists = array(
					'epf_status'        		=> 1,
					'epf_percentile'    		=> $this->input->post('epfpercentile'),
					'tds_status'        		=> 1,
					'tds_percentile'    		=> $this->input->post('tdspercentile'),
					'ptax_status'        		=> 1,
					'ptax_percentile'    		=> $this->input->post('ptaxpercentile'),
					'tv_status'        			=> 1,
					'tv_percentile'    			=> $this->input->post('tvpercentile'),
					'internet_status'       	=> 1,
					'internet_percentile'   	=> $this->input->post('internetpercentile'),
					'electricity_status'    	=> 1,
					'electricity_percentile'	=> $this->input->post('electricitypercentile'),
					'medical_status'        	=> 1,
					'medical_percentile'    	=> $this->input->post('medicalpercentile'),
					'otherfee_status'       	=> 1,
					'otherfee_percentile'   	=> $this->input->post('otherfeepercentile'),
					'total_earning'   			=> $this->input->post('total_earning'),
					'netsalary_amt'   			=> $this->input->post('netamount'),

				);
				$id = $this->Common_Model->update_records("employees", "employee_id", $employeeId, $data_lists);
			/*if($totalSalary < $data['getepfAmt'][0]['apply_below_amt']){}else{
				$data_lists = array(
					'epf_status'        		=> 0,
					'epf_percentile'    		=> 0.00,
					'tds_status'        		=> 0,
					'tds_percentile'    		=> 0.00,
					'ptax_status'        		=> 0,
					'ptax_percentile'    		=> 0.00,
					'tv_status'        			=> 0,
					'tv_percentile'    			=> 0.00,
					'internet_status'       	=> 0,
					'internet_percentile'   	=> 0.00,
					'electricity_status'    	=> 0,
					'electricity_percentile'	=> 0.00,
					'medical_status'        	=> 0,
					'medical_percentile'    	=> 0.00,
					'otherfee_status'       	=> 0,
					'otherfee_percentile'   	=> 0.00,
					'total_earning'   			=> $this->input->post('total_earning'),
					'netsalary_amt'   			=> $this->input->post('total_earning'),
				);
				$id = $this->Common_Model->update_records("employees", "employee_id", $employeeId, $data_lists);
			}*/
			
			/*if(empty($empoyeeSalary)){
				$empSaldata = $this->Common_Model->db_query("CALL EMP_SALARY_CONFIG('A','".$query."')");
			}*/
			//echo '<pre>';print_r($chekEmpDataexist);exit;
			/*if(!empty($empSaldata) && $empSaldata[0]['msg'] == 1 || $newinsert > 0){
				$this->session->set_flashdata('success', 'Salary Configured successfully.' );
				redirect($_SERVER['HTTP_REFERER']);
			}*/
			$this->session->set_flashdata('success', 'Salary Configured successfully.' );
			redirect($_SERVER['HTTP_REFERER']);

		}

		$data['activemenu'] 		= 'employee';
		$data['activesubmenu'] 		= 'listemployee';
		$this->load->view('employee/empsalaryconfig', $data);
	}

	function tagclasssubject($teacherId){
		$data = array();
		$data['employeeId'] = $teacherId;
		$updQur = '';
		if($this->input->post('submitBtn')){
			$class_id      = $this->input->post("class_id");
			$section_id    = $this->input->post("section_id");
			$subject_id    = $this->input->post("subject_id");
			$rowVal        = $this->input->post("rowid");
			$action        = $this->input->post("hdnUserType");


			foreach($class_id as $ind=>$val) 
			{
			    $class  = $class_id[$ind];
			    $sub    = $subject_id[$ind];
			    $sec    = $section_id[$ind];
			    $rowid  = $rowVal[$ind];

			    $this->form_validation->set_rules("class_id[".$ind."]", "Class", "trim|integer|required");
			    $this->form_validation->set_rules("section_id[".$ind."]", "Section", "trim|integer|required");
			    $this->form_validation->set_rules("subject_id[".$ind."]", "Subject", "trim|integer|required");
			    $this->form_validation->set_rules("rowid[".$ind."]", "Row", "trim|integer|required");
			    $this->form_validation->set_error_delimiters('<p class="has-error"><label class="control-label">', '</label></p>');
		    	if($action == 'A'){
		    		$updQur .= "(".$teacherId.",".$class.",".$sec.",".$sub."),";
		    	}else{
		    		$updQur .= "(".$rowid.",".$teacherId.",".$class.",".$sec.",".$sub."),";
		    	}
			}

			//echo $updQur;exit;
			if($this->form_validation->run()){
				if($updQur != ''){
					$updQur = rtrim($updQur,',');
					$prepareQur = 'CALL TEACHER_SUBJECT_CLASS_TAG("'.$action.'","'.$updQur.'","'.$teacherId.'")';
					$this->Common_Model->QueryData($prepareQur);
				}
				$this->session->set_flashdata('success', 'Subject and Class Tagged Successfully.' );
			}else{
				$this->session->set_flashdata("error", validation_errors());
			}
			redirect('employee');
		}
		$data['teacher_tagged_data']   = $this->Common_Model->FetchData("teacher_class_subject_tag", "*", "teacher_id = ".$teacherId);
		$data['activemenu'] 		= 'employee';
		$data['activesubmenu'] 		= 'listemployee';
		$this->load->view('employee/teachertagging', $data);	
	}

	function generateSalaryTransaction($employee_id=0){
		$data = array();
		$curSession    				= $this->session->userdata['session_name'];
		$data['curSession']			= $curSession;
		$data['employee'] 			= $this->Common_Model->FetchData("employees", "*", "employee_id = ".$employee_id);
		$getSalarydata 				= $this->Common_Model->db_query("SELECT COUNT(1) as cursessionsalary FROM salary_transaction WHERE session = '".$curSession."' AND employee_id = ".$employee_id);
		$financialyear = explode('-', $curSession);
		$startDate = '01-04-'.$financialyear[0];
		$endDate   = '31-03-'.$financialyear[1];
		while (strtotime($startDate) <= strtotime($endDate)) {
		    $months[] = array('year' => date('Y', strtotime($startDate)), 'month' => date('m', strtotime($startDate)), );
		    $startDate = date('01 M Y', strtotime($startDate.
		        '+ 1 month'));
		}

		//echo '<pre>';print_r($months);exit;
		$prepQuery = '';
		if(!empty($months)){
			foreach ($months as $k => $v) {
				# code...
				$prepQuery .="(".$employee_id.",'".$v['month']."','".$v['year']."','".$curSession."',0),";
			}

			//echo $prepQuery;exit;
			$prepQuery = rtrim($prepQuery,',');
			if($this->Common_Model->db_query("INSERT INTO salary_transaction (employee_id,month,year,session,credit_status) VALUES ".$prepQuery)){
				$this->session->set_flashdata('success', 'Subject and Class Tagged Successfully.' );
				redirect('employee/viewemployee/'.$employee_id);
			}

		}
	}

	function salarytransaction($employeeId){
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$data['employeeId'] 		= $employeeId;
		$data['activemenu'] 		= 'employee';
		$data['activesubmenu'] 		= 'listemployee';
		$curSession    				= $this->session->userdata['session_name'];
		$data['curSession']			= $curSession;
		$data['employee'] 			= $this->Common_Model->FetchData("employees", "*", "employee_id = ".$employeeId);
		$getSalarydata 				= $this->Common_Model->db_query("SELECT COUNT(1) as cursessionsalary FROM salary_transaction WHERE session = '".$curSession."' AND employee_id = ".$employeeId);
		if($getSalarydata[0]['cursessionsalary'] == 0){
			//$data['salaryData']   	=  $this->Common_Model->FetchData("`salary_config` A LEFT JOIN wages B ON (A.`salary_head` = B.wages_id)", "A.`salary_head`, A.`salary_value`, B.wages_name", "1 AND A.`employee_id` = ".$employeeId);
			if($this->input->post('createSalary')){
				$financialyear = explode('-', $curSession);
				$startDate = '01-04-'.$financialyear[0];
				$endDate   = '31-03-'.$financialyear[1];
				while (strtotime($startDate) <= strtotime($endDate)) {
				    $months[] = array('year' => date('Y', strtotime($startDate)), 'month' => date('m', strtotime($startDate)), );
				    $startDate = date('01 M Y', strtotime($startDate.
				        '+ 1 month'));
				}

				//echo '<pre>';print_r($months);exit;
				$prepQuery = '';
				if(!empty($months)){
					foreach ($months as $k => $v) {
						# code...
						$prepQuery .="(".$employeeId.",'".$v['month']."','".$v['year']."','".$curSession."',0),";
					}

					//echo $prepQuery;exit;
					$prepQuery = rtrim($prepQuery,',');
					if($this->Common_Model->db_query("INSERT INTO salary_transaction (employee_id,month,year,session,credit_status) VALUES ".$prepQuery)){
						$this->session->set_flashdata('success', 'Subject and Class Tagged Successfully.' );
						redirect('employee/salarytransaction/'.$employeeId);
					}

				}
			}
			$this->load->view('employee/createsalaryforemployee', $data);	
		}else{
			$data['records'] 	= $this->Common_Model->FetchData("salary_transaction", "*", "session = '".$curSession."' AND employee_id = ".$employeeId);
			$this->load->view('employee/viewsalarydata', $data);	
		}
		//echo '<pre>'; print_r($this->session->all_userdata['session_name']);exit;
		//$this->load->view('employee/empsalaryconfig', $data);
	}

	function advancesalary($employeeId){
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$data['employeeId'] 		= $employeeId;
		$data['activemenu'] 		= 'employee';
		$data['activesubmenu'] 		= 'listemployee';
		$curSession    				= $this->session->userdata['session_name'];
		$data['curSession']			= $curSession;
		$data['employee'] 			= $this->Common_Model->FetchData("employees", "*", "employee_id = ".$employeeId);

		if($this->input->post('submitBtn')){
			$this->form_validation->set_rules('total_amt_taken', 'Advance Amount', 'trim|required');
			$this->form_validation->set_rules('adv_taken_date', 'Advance Taken Date', 'trim|required');
			$this->form_validation->set_rules('per_month_instl', 'Per Month Installment', 'trim|required');
			$this->form_validation->set_rules('no_of_installment', 'No Of Installment', 'trim|required');
			$this->form_validation->set_error_delimiters('<p class="has-error"><label class="control-label">', '</label></p>');
			if($this->form_validation->run()){
				$data_list = array(
					'total_amt_taken'			=> $this->input->post('total_amt_taken'),
					'employee_id'				=> $employeeId,
					'adv_taken_date'			=> (strtotime($this->input->post('adv_taken_date')) > 0)?date('Y-m-d',strtotime($this->input->post('adv_taken_date'))):'0000-00-00',
					'session'					=> $curSession,
					'per_month_instl'			=> $this->input->post('per_month_instl'),
					'no_of_installment'		    => $this->input->post('no_of_installment')
				);
				$chkClearance = $this->Common_Model->db_query("SELECT COUNT(1) as totprev FROM adv_salary WHERE employee_id = ".$employeeId." AND adv_taken_status = 0");
				if ($chkClearance[0]['totprev'] > 0) {
					$this->session->set_flashdata('error', 'Please clear previous installment and try again!' );
					redirect($_SERVER['HTTP_REFERER']);
				}else{
				$advance_add  = $this->Common_Model->dbinsertid("adv_salary", $data_list);;
				$totalpaid = $this->input->post('total_amt_taken');
				$payment_mode 	= $this->input->post("payment_mode");
				$remarks 		= addslashes($this->input->post("remarks"));
				$bankdata = $this->Common_Model->FetchData("banks", "*", "bank_id = '".$this->input->post('bank_id')."'");
				$datalist = array(
					"payment_date"		=> date('Y-m-d'),
					"amount" 			=> $totalpaid,
					"payment_mode" 		=> $payment_mode,
					"purpose" 			=> 'Salary',
					"created_on" 		=> date("Y-m-d H:i:s"),
					"created_by" 		=> $this->session->userdata("user_id"),
					"remarks" 			=> $remarks,
					"employee_id" 		=> $employeeId,
					"expense_type" 		=> 0,
					"mobile"			=> '',
					"bank_id"			=> $this->input->post("bank_id"),
					"cheque_no"			=> $payment_mode != 'Cash' ? $this->input->post('cheque_no') : '',
					"bank_name"			=> $payment_mode != 'Cash' ? $this->input->post('bank_name') : '',
					"bank_branch"		=> $payment_mode != 'Cash' ? $this->input->post('bank_branch') : ''
				);
				$voucher_id = $this->Common_Model->dbinsertid("vouchers", $datalist);
				$voucher_no = date('Ymd').str_pad($voucher_id, 6, '0', STR_PAD_LEFT);
				$this->Common_Model->db_query("UPDATE vouchers SET voucher_no = '".$voucher_no."' WHERE voucher_id = ".$voucher_id);
				$this->Common_Model->db_query("UPDATE adv_salary SET voucher_id = '".$voucher_id."' WHERE  	advsal_id = ".$advance_add);
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
				$this->session->set_flashdata('success', 'Advance Salary added successfully.' );
				redirect($_SERVER['HTTP_REFERER']);
				}
			}else{
				$this->session->set_flashdata('error', validation_errors());
				redirect($_SERVER['HTTP_REFERER']);
			}
		}

		$data['records'] 	= $this->Common_Model->FetchData("adv_salary", "*", "session = '".$curSession."' AND employee_id = ".$employeeId);
		$data['banks'] = $this->Common_Model->FetchData("banks", "*", "status = 1 ORDER BY bank_name ASC");
		$this->load->view('employee/advancesalary', $data);	
	}

	function make_as_cleared($advsal_id = 0){
		$closeAdvamtarr = array(
			'adv_taken_status' => 1
		);
		$this->Common_Model->update_records("adv_salary", "advsal_id", $advsal_id, $closeAdvamtarr);
		$this->session->set_flashdata('success', 'Marked successfully clear.' );
		redirect($_SERVER['HTTP_REFERER']);
	}

	function applyleave($employeeId){
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$data['employeeId'] 		= $employeeId;
		$data['activemenu'] 		= 'employee'; 
		$data['activesubmenu'] 		= 'listemployee';
		$curSession    				= $this->session->userdata['session_name'];
		$data['curSession']			= $curSession;
		$data['employee'] 			= $this->Common_Model->FetchData("employees", "*", "employee_id = ".$employeeId);

		if($this->input->post('submitBtn')){
			$this->form_validation->set_rules('leave_type', 'Leave Type', 'trim|required');
			$this->form_validation->set_rules('apply_from', 'Leave From', 'trim|required');
			$this->form_validation->set_rules('apply_to', 'Leave To', 'trim|required');
			$this->form_validation->set_rules('no_of_days', 'No Of Days', 'trim|required');
			$this->form_validation->set_error_delimiters('<p class="has-error"><label class="control-label">', '</label></p>');
			if($this->form_validation->run()){
				$mxdate = date('d-m-Y', strtotime("+1 day", strtotime($this->input->post('apply_to'))));
				//echo $mxdate;exit;
				$maxdate  = strtotime($mxdate);
				$mindate  = strtotime($this->input->post('apply_from'));
				
				$datediff = $maxdate - $mindate;
				$daysDiff =  round($datediff / (60 * 60 * 24));

				$no_of_days = $daysDiff * $this->input->post('hfday');
				
				$data_list = array(
					'leave_type'				=> $this->input->post('leave_type'),
					'employee_id'				=> $employeeId,
					'apply_from'				=> (strtotime($this->input->post('apply_from')) > 0)?date('Y-m-d',strtotime($this->input->post('apply_from'))):'0000-00-00',
					'apply_to'					=> (strtotime($this->input->post('apply_to')) > 0)?date('Y-m-d',strtotime($this->input->post('apply_to'))):'0000-00-00',
					'no_of_days' 				=> $no_of_days,
					'session'					=> $curSession,
					'hfday'						=> $this->input->post('hfday'),
					'leave_status'				=> 1,
					'created_on'  => date('Y-m-d H:i:s')
				);
				$leave_apply  = $this->Common_Model->dbinsertid("leave_application", $data_list);;
				$this->session->set_flashdata('success', 'Leave Applied successfully.' );
				redirect($_SERVER['HTTP_REFERER']);
			}else{
				$this->session->set_flashdata('error', validation_errors());
				redirect($_SERVER['HTTP_REFERER']);
			}
		}

		$data['records'] 		= $this->Common_Model->FetchData("leave_application", "*", "session = '".$curSession."' AND employee_id = ".$employeeId);
		$data['leaveMaster'] 	= $this->Common_Model->FetchData("leave_master", "*", "leave_active = 'Active'");
		$this->load->view('employee/applyleave', $data);	
	}
	
	function pendingleaves() {
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$curSession    		    = $this->session->userdata('session_name');
		$data['records'] = $this->Common_Model->FetchData("leave_application as a LEFT JOIN leave_master as b on a.leave_type=b.leave_id LEFT JOIN employees as c on a.employee_id=c.employee_id","*","a.session='".$curSession."' AND a.leave_status ='0' ORDER BY a.leave_apply_id DESC");

		$data['activemenu'] = 'employee';
		$data['activesubmenu'] = 'pendingleaves';
		$this->load->view('employee/pendingleaves', $data);
	}

	function approve_leave($leave_apply_id = 0){
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$data['leave_apply_id'] = $leave_apply_id;
		$data['curSession'] = $curSession   = $this->session->userdata('session_name');

		if ($this->input->post('submitBtn')) {
			$this->form_validation->set_rules('leave_type', 'Leave Type', 'trim|required');
			$this->form_validation->set_rules('leave_status', 'Leave Status', 'trim|required');
			$this->form_validation->set_error_delimiters('<p class="has-error"><label class="control-label">', '</label></p>');
			if($this->form_validation->run()){

			$datalist = array(
				'leave_type' 	=> $this->input->post('leave_type'), 
				'leave_status' 	=> $this->input->post('leave_status') 
			);

			$this->Common_Model->update_records("leave_application","leave_apply_id",$leave_apply_id,$datalist);

			$this->session->set_flashdata('success', 'Leave Update successfully.' );
				redirect($_SERVER['HTTP_REFERER']);
		}else{
			$this->session->set_flashdata('error', validation_errors());
				redirect($_SERVER['HTTP_REFERER']);
		}
	}

		$data['rec'] = $rec = $this->Common_Model->FetchData("leave_application as a LEFT JOIN employees as c on a.employee_id=c.employee_id LEFT JOIN department AS d ON c.department_id = d.did","*","a.leave_apply_id=".$leave_apply_id." ORDER BY a.leave_apply_id DESC");

		$data['leavetypes'] = $this->Common_Model->FetchData("leave_master", "*", "leave_active = 'Active' ");

		$data['activemenu'] = 'employee';
		$data['activesubmenu'] = 'pendingleaves';
		$this->load->view('employee/approve_leave', $data);
	}

	function salarystructure(){
		error_reporting(0);
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$data['activemenu'] 		= 'employee';
		$data['activesubmenu'] 		= 'salarystructure';
		//echo '<pre>';print_r($this->session->userdata());
		$userId 					= $this->session->userdata['user_id'];
		
		$curSession    				= $this->session->userdata['session_name'];
		$data['employee'] 	= $this->Common_Model->db_query("SELECT A.* FROM employees A LEFT JOIN users B ON (A.employee_id = B.employee_tagged_id) WHERE 1 and B.user_id = ".$userId);
		/*$data['employeeSalary']     = $this->Common_Model->db_query("SELECT A.`salary_value`,B.wages_name FROM `salary_config` A LEFT JOIN wages B ON (A.`salary_head` = B.wages_id) LEFT JOIN users C ON (A.`employee_id` = C.employee_tagged_id AND C.user_id = ".$userId.") WHERE 1 ");*/

		$data['employeeSalary']     = $this->Common_Model->FetchData("salary_config as a LEFT JOIN wages as b on a.salary_head=b.wages_id LEFT JOIN users as c on a.employee_id=c.employee_tagged_id AND c.user_id=".$userId."","*","a.employee_id='".$data['employee'][0]['employee_id']."' order by a.config_id ASC");

		$data['SalaryDtls'] 		= $this->Common_Model->db_query("SELECT A.* FROM `salary_transaction` A LEFT JOIN users C ON (A.`employee_id` = C.employee_tagged_id AND C.user_id = ".$userId.") WHERE C.user_id =  '".$userId."' AND session =  '".$curSession."'");
		//echo '<pre>';print_r($data);exit;
		$this->load->view('employee/salarystructure', $data);
	}

	function leaveapplication(){
		error_reporting(0);
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$data['activemenu'] 	    = 'employee';
		$data['activesubmenu'] 	    = 'leaveapplication';
		$userId 		    = $this->session->userdata('user_id');
		$curSession    		    = $this->session->userdata('session_name');
		$data['curSession']	    = $curSession;
		$data['employee'] = $employee =$this->Common_Model->db_query("SELECT A.* FROM employees A LEFT JOIN users B ON (A.employee_id = B.employee_tagged_id) WHERE 1 and B.user_id = ".$userId);
		/*$data['employee_leave']     = $this->Common_Model->db_query("SELECT A.*,B.leave_type FROM `leave_application` A LEFT JOIN leave_master B ON (A.leave_type = B.leave_id) LEFT JOIN users C ON (A.`employee_id` = C.employee_tagged_id AND C.user_id = ".$userId.") WHERE A.session = '".$curSession."'");*/

		$data['employee_leave'] = $this->Common_Model->FetchData("leave_application as a LEFT JOIN leave_master as b on a.leave_type=b.leave_id LEFT JOIN users as c on a.employee_id=c.employee_tagged_id","*","a.session='".$curSession."' AND c.user_id='".$userId."' AND a.employee_id='".$employee[0]['employee_id']."'");

		//echo '<pre>';print_r($data);exit;
		$this->load->view('employee/leaveapplication', $data);
	}

	function salarycalculate($saltranid,$employeeId,$salmonth,$salyear){
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$data['activemenu'] 		= 'employee';
		$data['activesubmenu'] 		= 'salarycalculate';
		$data['saltranid']   		= $saltranid;
		$data['employeeId']   		= $employeeId;
		$data['salmonth']			= $salmonth;
		$data['salyear']			= $salyear;
		$userId 					= $this->session->userdata['user_id'];
		$curSession    				= $this->session->userdata['session_name'];
		$data['curSession']			= $curSession;
		$checkIfproper 				= $this->Common_Model->db_query("SELECT COUNT(1) as alreadyCred FROM salary_transaction WHERE employee_id = ".$employeeId." AND year = '".$salyear."' AND month = '".$salmonth."' AND credit_status = 1");
		//echo '<pre>';print_r($checkIfproper);exit;
		if($checkIfproper[0]['alreadyCred'] > 0){
			redirect('employee/salarytransaction/'.$employeeId);exit;
		}

		if($this->input->post('submitBtn')){
			//echo '<pre>';print_r($this->input->post());exit;
			$totalempwrkdays = ($this->input->post('totalempwrkdays') > 0)?$this->input->post('totalempwrkdays'):0;
			$perdayamtforemp = ($this->input->post('perdayamtforemp') > 0)?$this->input->post('perdayamtforemp'):0;
			$totalempwages 	 = ($this->input->post('totalempwages') > 0)?$this->input->post('totalempwages'):0;
			$empepfamt 		 = ($this->input->post('empepfamt') > 0)?$this->input->post('empepfamt'):0;
			$empnotpaidleave = ($this->input->post('empnotpaidleave') > 0)?$this->input->post('empnotpaidleave'):0;
			$advpaystatus 	 = ($this->input->post('advStatus') > 0)?$this->input->post('advpaystatus'):0;
			$installamt 	 = ($this->input->post('advStatus') > 0 && $this->input->post('advpaystatus') == 1)?$this->input->post('installamt'):0;
			$pendingadvamt 	 = ($this->input->post('advStatus') > 0 && $this->input->post('advpaystatus') == 1)?$this->input->post('pendingadvamt'):0;
			$advsalId        = ($this->input->post('advStatus') > 0 && $this->input->post('advpaystatus') == 1)?$this->input->post('advsalId'):0;
			$totalpaid 		 = ($this->input->post('totalpaid') > 0)?$this->input->post('totalpaid'):0;
			$totaldeduct 	 = ($this->input->post('totaldeduct') > 0)?$this->input->post('totaldeduct'):0;

			$data_list = array(
					'sal_tran_id'   		=> $saltranid,
					'employee_id'			=> $employeeId,
					'totalempwrkdays'		=> $totalempwrkdays,
					'perdayamtforemp'		=> $perdayamtforemp,
					'totalempwages'			=> $totalempwages,
					'empepfamt'				=> $empepfamt,
					'empnotpaidleave'		=> $empnotpaidleave,
					'advpaystatus'			=> $advpaystatus,
					'installamt'			=> $installamt,
					'totalpaid'				=> $totalpaid,
					'totaldeduct'			=> $totaldeduct,
					'credit_date'			=> date('Y-m-d')
				);

			$salary_update_data = array(
					'salary_credit'			=> $totalpaid,
					'salary_deduct'			=> $totaldeduct,
					'credited_date'			=> date('Y-m-d'),
					'credit_status'			=> 1
				);
			$salary_update = $this->Common_Model->update_records("salary_transaction", "transaction_id", $saltranid, $salary_update_data);
			//echo '<pre>';			print_r($salary_update);exit;
			if($salary_update == 0){
				$salary_credit_stmt = $this->Common_Model->dbinsert("salary_transaction_attribute", $data_list);
				if($this->input->post('advStatus') > 0 && $this->input->post('advpaystatus') == 1){
					$advSalaryInsArr = array(
						'advsal_id'  		=> $advsalId,
						'employee_id'		=> $employeeId,
						'installamt' 		=> $installamt,
						'transaction_date'  => date('Y-m-d')
					);
					$advSalaryIns = $this->Common_Model->dbinsert("adv_salary_installment", $advSalaryInsArr);

					$getAdvanceCur = $this->Common_Model->db_query("SELECT A.*,COALESCE(SUM(B.installamt),0) AS paidInstallment FROM adv_salary A LEFT JOIN adv_salary_installment B ON (A.`advsal_id` = B.advsal_id) WHERE A.advsal_id = ".$advsalId." AND A.adv_taken_status = 0");

					if($getAdvanceCur[0]['paidInstallment'] >= $getAdvanceCur[0]['total_amt_taken']){
						$closeAdvamtarr = array(
							'adv_taken_status' => 1
						);
						$closeAdvamt = $this->Common_Model->update_records("adv_salary", "advsal_id", $advsalId, $closeAdvamtarr);
					}

				}
			}
			$payment_mode 	= $this->input->post("payment_mode");
			$remarks 		= addslashes($this->input->post("remarks"));
			$bankdata = $this->Common_Model->FetchData("banks", "*", "bank_id = '".$this->input->post('bank_id')."'");
			$datalist = array(
				"payment_date"		=> date('Y-m-d'),
				"amount" 			=> $totalpaid,
				"payment_mode" 		=> $payment_mode,
				"purpose" 			=> 'Salary',
				"created_on" 		=> date("Y-m-d H:i:s"),
				"created_by" 		=> $this->session->userdata("user_id"),
				"remarks" 			=> $remarks,
				"employee_id" 		=> $employeeId,
				"expense_type" 		=> 0,
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

			/*@file_get_contents('http://137.59.52.74/api/mt/SendSMS?user=YOUNGPHOENIX&password=123456&senderid=YPPSKL&channel=Trans&DCS=0&flashsms=0&number='.$this->input->post('student_mobile').'&text='.urlencode("Your salary Rs.".$totalpaid." for the month of ".$salmonth."/".$salyear." has been credited in your account through voucher no is ".$voucher_no.". For more details contact 8658599505.(".site_url("publicdata/viewsalaryreceipt/".$saltranid."/".$employeeId."/".$salmonth."/".$salyear).")").'&route=1');*/
			if($this->input->post('saveandprint') == 'Yes'){
				$this->session->set_flashdata('saveandprint', $voucher_id);
			}
			$this->session->set_flashdata('success', 'Salary Added successfully.' );
			redirect('employee');
		}


		$employeeData   			= $this->Common_Model->db_query("SELECT A.* FROM employees A  WHERE 1 and A.employee_id = ".$employeeId);
		$empSalary                  = $this->Common_Model->db_query("SELECT A.*,B.wages_name FROM `salary_config` A LEFT JOIN wages B ON (A.`salary_head` = B.wages_id) WHERE A.`employee_id` = ".$employeeId);
		//$getAllholidays             = $this->Common_Model->db_query("SELECT COUNT(1) as totholiday FROM holiday WHERE type = 1 AND MONTH(from_date) = '".$data['salmonth']."' AND YEAR(from_date) = '".$data['salyear']."'");
		$getAllholidays             = $this->Common_Model->db_query("SELECT * FROM holiday WHERE type = 1 AND MONTH(from_date) = '".$data['salmonth']."' AND YEAR(from_date) = '".$data['salyear']."'");
		$adv_salary                 = $this->Common_Model->db_query("SELECT A.*,COALESCE(SUM(B.installamt),0) AS paidInstallment FROM adv_salary A LEFT JOIN adv_salary_installment B ON (A.`advsal_id` = B.advsal_id) WHERE A.employee_id = ".$data['employeeId']." AND A.adv_taken_status = 0");
		//$adv_salary                 = $this->Common_Model->db_query("SELECT * FROM adv_salary WHERE employee_id = ".$data['employeeId']." AND adv_taken_status = 0");
		$leave_taken                = $this->Common_Model->db_query("SELECT A.*,B.leave_type,B.is_paid FROM `leave_application` A LEFT JOIN leave_master B ON (A.leave_type = B.leave_id) WHERE A.employee_id = ".$data['employeeId']." AND A.leave_status = 1 AND MONTH(A.apply_from) = '".$data['salmonth']."' AND YEAR(A.apply_from) = '".$data['salyear']."'");
		if(!empty($getAllholidays)){
			$holidayArr = array_column($getAllholidays, 'from_date');
		}else{
			$holidayArr = array();
		}
		/************************Number of working days calculation of the month*****************/
		$monthStartDate             = date($salyear.'-'.$salmonth.'-01');
		$monthEndDate   			= date("Y-m-t", strtotime($monthStartDate));
		$start = new DateTime($monthStartDate);
		$end = new DateTime($monthEndDate);
		$end->modify('+1 day');
		$interval = $end->diff($start);
		$days = $interval->days;
		$period = new DatePeriod($start, new DateInterval('P1D'), $end);
		$holidays = $holidayArr;
		foreach($period as $dt) {
		    $curr = $dt->format('D');
		    if ($curr == 'Sun') {
		        $days--;
		    }
		    elseif (in_array($dt->format('Y-m-d'), $holidays)) {
		        $days--;
		    }
		}
		/********************days calculation end**************************************/
		//echo $days;
		$data['employee'] 			= $employeeData;
		$data['empSalary'] 			= $empSalary;
		$data['getAllholidays'] 	= $getAllholidays;
		$data['adv_salary'] 		= $adv_salary;
		$data['leave_taken'] 		= $leave_taken;
		$data['no_of_working_days'] = $days;
		$data['banks'] = $this->Common_Model->FetchData("banks", "*", "status = 1 ORDER BY bank_name ASC");
		//echo '<pre>';print_r($data['adv_salary']);exit;
		$this->load->view('employee/salarycalculate', $data);
	}

	function viewsalaryreceipt($saltranid,$employeeId,$salmonth,$salyear){
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$data['activemenu'] 		= 'employee';
		$data['activesubmenu'] 		= 'listemployee';
		$data['saltranid']   		= $saltranid;
		$data['employeeId']   		= $employeeId;
		$data['salmonth']			= $salmonth;
		$data['salyear']			= $salyear;
		$userId 					= $this->session->userdata['user_id'];
		$curSession    				= $this->session->userdata['session_name'];
		$data['curSession']			= $curSession;
		$checkIfproper 				= $this->Common_Model->db_query("SELECT COUNT(1) as alreadyCred FROM salary_transaction WHERE employee_id = ".$employeeId." AND year = '".$salyear."' AND month = '".$salmonth."' AND credit_status = 0");
		$saltran 				= $this->Common_Model->db_query("SELECT * FROM salary_transaction WHERE transaction_id = '".$saltranid."'");
		$data['voucher']			= $this->Common_Model->db_query("SELECT * FROM vouchers WHERE voucher_id = '".$saltran[0]['voucher_id']."'");
		if($checkIfproper[0]['alreadyCred'] > 0){
			redirect('employee/salarytransaction/'.$employeeId);exit;
		} 
 
		$employeeData   			= $this->Common_Model->db_query("SELECT A.* FROM employees A  WHERE 1 and A.employee_id = ".$employeeId);
		/*$empSalary                  = $this->Common_Model->db_query("SELECT A.*,B.wages_name FROM `salary_config` A LEFT JOIN wages B ON (A.`salary_head` = B.wages_id) WHERE A.`employee_id` = ".$employeeId);*/

		$empSalary = $this->Common_Model->FetchData("salary_transaction_wages as a LEFT JOIN wages as b on a.wgs_id=b.wages_id","*","a.sal_tranid='".$saltranid."' AND a.emp_id='".$employeeId."'");


		
		$getAllholidays             = $this->Common_Model->db_query("SELECT * FROM holiday WHERE type = 1 AND MONTH(from_date) = '".$data['salmonth']."' AND YEAR(from_date) = '".$data['salyear']."'");
		$adv_salary                 = $this->Common_Model->db_query("SELECT A.*,COALESCE(SUM(B.installamt),0) AS paidInstallment FROM adv_salary A LEFT JOIN adv_salary_installment B ON (A.`advsal_id` = B.advsal_id) WHERE A.employee_id = ".$data['employeeId']." AND A.adv_taken_status = 0");


		$data['allTransaction']     = $this->Common_Model->db_query("SELECT * FROM salary_transaction_attribute WHERE sal_tran_id = ".$saltranid);

		$adv_salary                 = $this->Common_Model->db_query("SELECT A.*,COALESCE(SUM(B.installamt),0) AS paidInstallment FROM adv_salary A LEFT JOIN adv_salary_installment B ON (A.`advsal_id` = B.advsal_id) WHERE A.employee_id = ".$data['employeeId']." AND A.adv_taken_status = 0");
		
		$leave_taken                = $this->Common_Model->db_query("SELECT A.*,B.leave_type,B.is_paid FROM `leave_application` A LEFT JOIN leave_master B ON (A.leave_type = B.leave_id) WHERE A.employee_id = ".$data['employeeId']." AND A.leave_status = 1 AND MONTH(A.apply_from) = '".$data['salmonth']."' AND YEAR(A.apply_from) = '".$data['salyear']."'");

		$data['totalleaves'] = $this->Common_Model->db_query("SELECT SUM(no_of_days) AS totleaves FROM leave_application as a LEFT JOIN leave_master as b on a.leave_type=b.leave_id WHERE a.employee_id = ".$data['employeeId']." AND a.leave_status = 1 AND MONTH(a.apply_from) = '".$data['salmonth']."' AND YEAR(a.apply_from) = '".$data['salyear']."' ");
                   

		if(!empty($getAllholidays)){
			$holidayArr = array_column($getAllholidays, 'from_date');
		}else{
			$holidayArr = array();
		}
		/************************Number of working days calculation of the month*****************/
		$monthStartDate             = date($salyear.'-'.$salmonth.'-01');
		$monthEndDate   			= date("Y-m-t", strtotime($monthStartDate));
		$start = new DateTime($monthStartDate);
		$end = new DateTime($monthEndDate);
		$end->modify('+1 day');
		$interval = $end->diff($start);
		$days = $interval->days;
		$period = new DatePeriod($start, new DateInterval('P1D'), $end);
		$holidays = $holidayArr;
		foreach($period as $dt) {
		    $curr = $dt->format('D');
		    /*if ($curr == 'Sun') {
		        $days--;
		    }
		    elseif (in_array($dt->format('Y-m-d'), $holidays)) {
		        $days--;
		    }*/
		}
		/********************days calculation end**************************************/
		//echo $days;
		$data['employee'] 			= $employeeData;
		$data['empSalary'] 			= $empSalary;
		$data['getAllholidays'] 	= $getAllholidays;
		$data['adv_salary'] 		= $adv_salary;
		$data['leave_taken'] 		= $leave_taken;
		$data['no_of_working_days'] = $days;
		$data['advinstallments']	= $this->Common_Model->FetchData("adv_salary_installment AS a LEFT JOIN vouchers AS v ON a.voucher_id = v.voucher_id", "*", "a.transaction_id = '$saltranid'");
		//echo '<pre>';print_r($data);exit;
		$this->load->view('employee/viewsalaryreceipt', $data);
	}

	function pdfsalaryreceipt($saltranid,$employeeId,$salmonth,$salyear){
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$data['activemenu'] 		= 'employee';
		$data['activesubmenu'] 		= 'salarycalculate';
		$data['saltranid']   		= $saltranid;
		$data['employeeId']   		= $employeeId;
		$data['salmonth']			= $salmonth;
		$data['salyear']			= $salyear;
		$userId 					= $this->session->userdata['user_id'];
		$curSession    				= $this->session->userdata['session_name'];
		$data['curSession']			= $curSession;
		$checkIfproper 				= $this->Common_Model->db_query("SELECT COUNT(1) as alreadyCred FROM salary_transaction WHERE employee_id = ".$employeeId." AND year = '".$salyear."' AND month = '".$salmonth."' AND credit_status = 0");
		if($checkIfproper[0]['alreadyCred'] > 0){
			redirect('employee/salarytransaction/'.$employeeId);exit;
		}

		$employeeData   			= $this->Common_Model->db_query("SELECT A.* FROM employees A  WHERE 1 and A.employee_id = ".$employeeId);
		$empSalary                  = $this->Common_Model->db_query("SELECT A.*,B.wages_name, B.deduction FROM `salary_config` A LEFT JOIN wages B ON (A.`salary_head` = B.wages_id) WHERE A.`employee_id` = ".$employeeId);
		
		$getAllholidays             = $this->Common_Model->db_query("SELECT * FROM holiday WHERE type = 1 AND MONTH(from_date) = '".$data['salmonth']."' AND YEAR(from_date) = '".$data['salyear']."'");
		$adv_salary                 = $this->Common_Model->db_query("SELECT A.*,COALESCE(SUM(B.installamt),0) AS paidInstallment FROM adv_salary A LEFT JOIN adv_salary_installment B ON (A.`advsal_id` = B.advsal_id) WHERE A.employee_id = ".$data['employeeId']." AND A.adv_taken_status = 0");


		$data['allTransaction']     = $this->Common_Model->db_query("SELECT * FROM salary_transaction_attribute WHERE sal_tran_id = ".$saltranid);

		$adv_salary                 = $this->Common_Model->db_query("SELECT A.*,COALESCE(SUM(B.installamt),0) AS paidInstallment FROM adv_salary A LEFT JOIN adv_salary_installment B ON (A.`advsal_id` = B.advsal_id) WHERE A.employee_id = ".$data['employeeId']." AND A.adv_taken_status = 0");
		
		$leave_taken                = $this->Common_Model->db_query("SELECT A.*,B.leave_type,B.is_paid FROM `leave_application` A LEFT JOIN leave_master B ON (A.leave_type = B.leave_id) WHERE A.employee_id = ".$data['employeeId']." AND A.leave_status = 1 AND MONTH(A.apply_from) = '".$data['salmonth']."' AND YEAR(A.apply_from) = '".$data['salyear']."'");
		if(!empty($getAllholidays)){
			$holidayArr = array_column($getAllholidays, 'from_date');
		}else{
			$holidayArr = array();
		}
		/************************Number of working days calculation of the month*****************/
		$monthStartDate             = date($salyear.'-'.$salmonth.'-01');
		$monthEndDate   			= date("Y-m-t", strtotime($monthStartDate));
		$start = new DateTime($monthStartDate);
		$end = new DateTime($monthEndDate);
		$end->modify('+1 day');
		$interval = $end->diff($start);
		$days = $interval->days;
		$period = new DatePeriod($start, new DateInterval('P1D'), $end);
		$holidays = $holidayArr;
		foreach($period as $dt) {
		    $curr = $dt->format('D');
		    if ($curr == 'Sun') {
		        $days--;
		    }
		    elseif (in_array($dt->format('Y-m-d'), $holidays)) {
		        $days--;
		    }
		}
		/********************days calculation end**************************************/
		//echo $days;
		$data['employee'] 			= $employeeData;
		$data['empSalary'] 			= $empSalary;
		$data['getAllholidays'] 	= $getAllholidays;
		$data['adv_salary'] 		= $adv_salary;
		$data['leave_taken'] 		= $leave_taken;
		$data['no_of_working_days'] = $days;
		error_reporting(0);
		ini_set('display_error', -1);
		$html = $this->load->view('employee/pdfsalaryreceipt', $data, TRUE);
		$this->load->library('Pdf');
		$pdf = new Pdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('Young Phoenix');
		$pdf->SetTitle('Statement of Fees');
		$pdf->SetSubject('Statement of Fees');

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

		$pdf->SetFont('helvetica', '', 9);

		$pdf->setFontSubsetting(false);
		$pdf->writeHTML($html, true, false, false, false, '');
		date_default_timezone_set("Asia/Kolkata");
		$filename = date("YmdHis").'.pdf';
		$pdf->Output($filename, 'I');
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

	function lessionplanreport(){
		$this->load->helper('url');
		$currentURL 	= current_url();
		$data 			= array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$sql 			= "1";
		$queryvars 		= "";
		$sql			.= " AND usertype = 'Teacher' and employee_tagged_id > 0";
		$sql			.= " ORDER BY firstname ASC";
		$rows 			= $this->Common_Model->FetchRows("users", "*", "$sql");
		$data['page_num'] = $page_num = isset($_REQUEST['page']) ? $_REQUEST['page'] : 1;
		$this->load->library("Paginator");
		$this->paginator->setparam(array("page_num" => $page_num, "num_rows" => $rows));
		$this->paginator->set_Limit(10);
		$range1 = $this->paginator->getRange1();
		$range2 = $this->paginator->getRange2();

		$sql .= " LIMIT ".$range1.', '.$range2;
		$records = $this->Common_Model->db_query("SELECT * FROM users WHERE ".$sql);

		$paging_info = $this->paginator->DBPagingNav($queryvars, $currentURL);

		$data['tot_page'] = $paging_info[0];
		$data['sPages'] = $paging_info[1];
		$data['rows'] = $rows;
		$data['records'] = $records;
		$data['activemenu'] = 'employeerec';
		$data['activesubmenu'] = 'lessionprogress';
		$this->load->view('employee/lessionplanreport', $data);
	}

	function markattendance(){
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		if($this->input->post('submitBtn')){
			$this->form_validation->set_rules('employee_id', 'Employee Name', 'trim|required');
			$this->form_validation->set_rules('attended_date', 'Attendance Date', 'trim|required');
			$this->form_validation->set_error_delimiters('<p class="has-error"><label class="control-label">', '</label></p>');
			if($this->form_validation->run()){
				$chk = $this->Common_Model->FetchData("employee_attendance", "*", "employee_id = '".$this->input->post("employee_id")."' AND attended_date = '".$this->input->post("attended_date")."'");

				$data_list = array(
					'employee_id'			=> $this->input->post('employee_id'),
					'attended_date'			=> $this->input->post('attended_date'),
					//'attend_remarks'		=> addslashes($this->input->post('attend_remarks'))
				);
				if($this->input->post('in_time') != ''){
					$data_list['in_time'] = date("H:i:s", strtotime($this->input->post('in_time')));
				}
				if($this->input->post('out_time') != ''){
					$data_list['out_time'] = date("H:i:s", strtotime($this->input->post('out_time')));
				}
				if($chk){
					$this->Common_Model->update_records("employee_attendance", "id", $chk[0]['id'], $data_list);
				}else{					
					$this->Common_Model->dbinsertid("employee_attendance", $data_list);
				}
				$this->session->set_flashdata('success', 'Attendance Saved.' );
				redirect('employee/markattendance');
			}else{
				$this->session->set_flashdata('error', validation_errors());
			}
		}
		$data['per_page'] = $per_page = isset($_REQUEST['per_page']) ? $_REQUEST['per_page'] : 10;
		$data['page'] = $page = isset($_REQUEST['page']) ? $_REQUEST['page'] : '1';
		$this->load->helper('url');
		$currentURL = current_url();
		$sql = "emp_cat='Staff'";
		$urlvars = '';
		if(isset($_REQUEST['employee_id']) && $_REQUEST['employee_id'] != ''){
			$sql.= " AND l.employee_id = '".$_REQUEST['employee_id']."'";
			$urlvars.= "&employee_id=".$_REQUEST['employee_id'];
		}
		if(isset($_REQUEST['log_date_from']) && $_REQUEST['log_date_from'] != ''){
			$sql.= " AND l.attended_date >= '".$_REQUEST['log_date_from']."'";
			$urlvars.= "&log_date_from=".$_REQUEST['log_date_from'];
		}
		if(isset($_REQUEST['log_date_to']) && $_REQUEST['log_date_to'] != ''){
			$sql.= " AND l.attended_date <= '".$_REQUEST['log_date_to']."'";
			$urlvars.= "&log_date_to=".$_REQUEST['log_date_to'];
		}		

		$sSql = "SELECT COUNT(*) as num FROM employee_attendance AS l LEFT JOIN employees AS em ON l.employee_id = em.employee_id LEFT JOIN department AS d ON em.department_id = d.did WHERE $sql";
		$records = $this->Common_Model->db_query($sSql);
		$totalrecords = $records[0]['num'];
		if($totalrecords){
			$sSql = "SELECT em.employee_id, em.employee_name, em.department_id, em.emp_fathername, em.aadhar_number, em.emp_mobile, em.employee_mobile2, em.employee_address, em.employee_email, em.emp_status, em.epf_status, em.epf_percentile, em.emp_firstname, em.emp_lastname, em.emp_dob, em.emp_photo, d.department_name, d.shift_id, d.start_time, d.end_time, d.department_active, l.id, l.attended_date, l.in_time, l.out_time, l.attend_remarks FROM employee_attendance AS l LEFT JOIN employees AS em ON l.employee_id = em.employee_id LEFT JOIN department AS d ON em.department_id = d.did WHERE $sql ORDER BY l.attended_date DESC";
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
		$data['activemenu'] = 'employee';
		$data['activesubmenu'] = 'markattendance';
		$data['employees'] = $this->Common_Model->FetchData("employees", "*", "emp_cat='Staff' AND emp_status = 'Active' ORDER BY employee_name ASC");
		$this->load->view('employee/markattendance', $data);
	}

	function markattendance_client(){
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		if($this->input->post('submitBtn')){
			$this->form_validation->set_rules('unit_id', 'Unit', 'trim|required');
			$this->form_validation->set_rules('designation_id', 'Designation', 'trim|required');
			$this->form_validation->set_rules('year', 'Year', 'trim|required');
			$this->form_validation->set_rules('month', 'Month', 'trim|required');
			$this->form_validation->set_error_delimiters('<p class="has-error"><label class="control-label">', '</label></p>');

			if($this->form_validation->run()){

				
				$chk = $this->Common_Model->FetchData("employee_attendanceclient", "*", "unit_id = ".$this->input->post("unit_id")." AND designation_id = ".$this->input->post("designation_id")." AND year = ".$this->input->post("year")." AND month = ".$this->input->post("month")."");
				if ($chk) {
					$data_list = array(
					'unit_id'			=> $this->input->post('unit_id'),
					'designation_id'	=> $this->input->post('designation_id'),
					'year'				=> $this->input->post('year'),
					'month'				=> $this->input->post('month'),
					'update_date'		=> date('Y-m-d'),
				);
				
				$this->Common_Model->update_records("employee_attendanceclient","employee_attendanceclient_id", $chk[0]['employee_attendanceclient_id'], $data_list);
				
						for ($i=0; $i <count($this->input->post('employee_id')) ; $i++) { 
								$employee_attendanceclient_id = $chk[0]['employee_attendanceclient_id'];
								$employee_id 	= $this->input->post('employee_id')[$i];
								$employee_code 	= $this->input->post('employee_code')[$i];
								$employee_name 	= $this->input->post('employee_name')[$i];
								$payable_days 	= $this->input->post('payable_days')[$i];
								$ot_days 		= $this->input->post('ot_days')[$i];
								$total_duty 	= $this->input->post('total_duty')[$i];
								$extra_hour 	= $this->input->post('extra_hour')[$i];
								$fooding 		= $this->input->post('fooding')[$i];
								$uniform 		= $this->input->post('uniform')[$i];
								$pt 			= $this->input->post('pt')[$i];
								$allowances 	= $this->input->post('allowances')[$i];

							$chkatten = $this->Common_Model->FetchData("emp_attenclient_items","*","employee_id=".$employee_id." AND employee_attendanceclient_id=".$employee_attendanceclient_id."");
							if ($chkatten) {
								$this->Common_Model->db_query("UPDATE emp_attenclient_items SET  payable_days = ".$payable_days.", ot_days = ".$ot_days.", total_duty = ".$total_duty.", extra_hour = ".$extra_hour.", fooding = ".$fooding.", uniform = ".$uniform.", pt = ".$pt.", allowances = ".$allowances.", employee_code = '".$employee_code."', employee_name = '".$employee_name."' WHERE employee_attendanceclient_id = ".$chk[0]['employee_attendanceclient_id']." AND employee_id= ".$employee_id."");
						}else{
								$att_items = array(
								'employee_attendanceclient_id' => $employee_attendanceclient_id, 
								'employee_id' 				=> $employee_id, 
								'employee_code' 			=> $employee_code, 
								'employee_name' 			=> $employee_name, 
								'payable_days' 				=> $payable_days, 
								'ot_days' 					=> $ot_days,  
								'total_duty' 				=> $total_duty,
								'extra_hour' 				=> $extra_hour, 
								'fooding' 					=> $fooding, 
								'uniform' 					=> $uniform, 
								'pt' 						=> $pt, 
								'allowances' 				=> $allowances,
							);

							$this->Common_Model->dbinsertid("emp_attenclient_items", $att_items);
						}

						}
						
				}else{

				$data_list = array(
					'unit_id'			=> $this->input->post('unit_id'),
					'designation_id'	=> $this->input->post('designation_id'),
					'year'				=> $this->input->post('year'),
					'month'				=> $this->input->post('month'),
					'entry_date'		=> date('Y-m-d'),
				); 
				
				$employee_attendanceclient_id = $this->Common_Model->dbinsertid("employee_attendanceclient", $data_list);
					if ($employee_attendanceclient_id) {
						for ($i=0; $i <count($this->input->post('employee_id')) ; $i++) { 
							$att_items = array(
								'employee_attendanceclient_id' => $employee_attendanceclient_id, 
								'employee_id' 				=> $this->input->post('employee_id')[$i],
								'employee_code' 			=> $this->input->post('employee_code')[$i],
								'employee_name' 			=> $this->input->post('employee_name')[$i], 
								'payable_days' 				=> $this->input->post('payable_days')[$i], 
								'ot_days' 					=> $this->input->post('ot_days')[$i], 
								'total_duty' 				=> $this->input->post('total_duty')[$i], 
								'extra_hour' 			=> $this->input->post('extra_hour')[$i], 
								'fooding' 				=> $this->input->post('fooding')[$i], 
								'uniform' 				=> $this->input->post('uniform')[$i], 
								'pt' 					=> $this->input->post('pt')[$i], 
								'allowances' 			=> $this->input->post('allowances')[$i],
							);

							$this->Common_Model->dbinsertid("emp_attenclient_items", $att_items);
							}
						}
					}

				
				$this->session->set_flashdata('success', 'Attendance Saved.' );
				redirect('employee/markattendance_client');
			}else{
				$this->session->set_flashdata('error', validation_errors());
			}
		}else if ($this->input->post("downloadBtn")) {
		    $unit = $this->Common_Model->FetchData("units","*","unit_id=".$this->input->post('unit_id'));
			$designation = $this->Common_Model->FetchData("designation","*","designation_id=".$this->input->post('designation_id'));
			$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		// Set document properties
		$spreadsheet->getProperties()->setCreator('cakiweb.com')
					->setLastModifiedBy($this->session->userdata('firstname').' '.$this->session->userdata('lastname'))
					->setTitle('Trial Attendance')
					->setSubject('Trial Attendance')
					->setDescription('Trial Attendance');
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
		$cellstyleArray = array(
			'borders' => array(
				'allBorders' => [
		            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
		            'color' => ['rgb' => '333333'],
		        ],
			)
		);
		$spreadsheet->getActiveSheet()->getStyle('A2:J2')->applyFromArray($styleArray);
		// auto fit column to content
		foreach(range('A', 'J') as $columnID) {
			$spreadsheet->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
		}
		$spreadsheet->getActiveSheet()->getStyle('A1:J1')->applyFromArray($styleArray);
		
		$spreadsheet->getActiveSheet()->mergeCells("A1:J1");
		// set the names of header cells
		$sheet->setCellValue('A1', 'Unit :'.$unit[0]['unit_name'].', Designation: '.$designation[0]['designation_name'.'']);
		// set the names of header cells
		$sheet->setCellValue('A2', 'Employee Code');
		$sheet->setCellValue('B2', 'Employee Name');		
		$sheet->setCellValue('C2', 'Payable Days');
		$sheet->setCellValue('D2', 'OT');
		$sheet->setCellValue('E2', 'Total Duty');		
		$sheet->setCellValue('F2', 'Extra Hour');
		$sheet->setCellValue('G2', 'Fooding');
		$sheet->setCellValue('H2', 'Uniform');
		$sheet->setCellValue('I2', 'PT');
		$sheet->setCellValue('J2', 'Allowances');

		// Add some data
		$x = 3;
		$totpd = 0;
		$totot = 0;
		$tottotalduty = 0;
		$totextrahour = 0;
		$totfooding = 0;
		$totuniform = 0;
		$totpt = 0;
		$totallowances = 0;
		if(count($this->input->post('employee_id')) > 0){
			for($i=0;$i<count($this->input->post('employee_id'));$i++){
				$totpd += $this->input->post('payable_days')[$i];
				$totot += $this->input->post('ot_days')[$i];
				$tottotalduty += $this->input->post('total_duty')[$i];
				$totextrahour += $this->input->post('extra_hour')[$i];
				$totfooding += $this->input->post('fooding')[$i];
				$totuniform += $this->input->post('uniform')[$i];
				$totpt += $this->input->post('pt')[$i];
				$totallowances += $this->input->post('allowances')[$i];
				
				$sheet->setCellValue('A'.$x, $this->input->post('employee_code')[$i]);
				$sheet->setCellValue('B'.$x, $this->input->post('employee_name')[$i]);
				$sheet->setCellValue('C'.$x, $this->input->post('payable_days')[$i]);
				$sheet->setCellValue('D'.$x, $this->input->post('ot_days')[$i]);
				$sheet->setCellValue('E'.$x, $this->input->post('total_duty')[$i]);
				$sheet->setCellValue('F'.$x, $this->input->post('extra_hour')[$i]);
				$sheet->setCellValue('G'.$x, $this->input->post('fooding')[$i]);
				$sheet->setCellValue('H'.$x, $this->input->post('uniform')[$i]);				
				$sheet->setCellValue('I'.$x, $this->input->post('pt')[$i]);				
				$sheet->setCellValue('J'.$x, $this->input->post('allowances')[$i]);
				$x++;
			}
		}
		
		$sheet->setCellValue('B'.$x, 'Total Attendance');
		$sheet->getStyle('C'.$x)->getNumberFormat()->setFormatCode('0.0');
		$sheet->setCellValue('C'.$x, $totpd);
		$sheet->getStyle('D'.$x)->getNumberFormat()->setFormatCode('0.0');
		$sheet->setCellValue('D'.$x, $totot);
		$sheet->getStyle('E'.$x)->getNumberFormat()->setFormatCode('0.0');
		$sheet->setCellValue('E'.$x, $tottotalduty);
		$sheet->getStyle('F'.$x)->getNumberFormat()->setFormatCode('0.0');
		$sheet->setCellValue('F'.$x, $totextrahour);
		$sheet->getStyle('G'.$x)->getNumberFormat()->setFormatCode('0.00');
		$sheet->setCellValue('G'.$x, $totfooding);
		$sheet->getStyle('H'.$x)->getNumberFormat()->setFormatCode('0.00');
		$sheet->setCellValue('H'.$x, $totuniform);
		$sheet->getStyle('I'.$x)->getNumberFormat()->setFormatCode('0.00');
		$sheet->setCellValue('I'.$x, $totpt);
		$sheet->getStyle('J'.$x)->getNumberFormat()->setFormatCode('0.00');
		$sheet->setCellValue('J'.$x, $totallowances);
		$spreadsheet->getActiveSheet()->getStyle('A2:J'.$x)->applyFromArray($cellstyleArray);
		//Create file excel.xlsx
		$writer = new Xlsx($spreadsheet);
		//$writer->save('admission_data.xlsx');
		header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Attendance_Client.xlsx"');
        $writer->save('php://output');
        exit;
		}
		$data['per_page'] = $per_page = isset($_REQUEST['per_page']) ? $_REQUEST['per_page'] : 10;
		$data['page'] = $page = isset($_REQUEST['page']) ? $_REQUEST['page'] : '1';
		$this->load->helper('url');
		$currentURL = current_url();
		$sql = "em.emp_cat='Others'";
		$urlvars = '';
		if(isset($_REQUEST['employee_id']) && $_REQUEST['employee_id'] != ''){
			$sql.= " AND l.employee_id = '".$_REQUEST['employee_id']."'";
			$urlvars.= "&employee_id=".$_REQUEST['employee_id'];
		}
		if(isset($_REQUEST['log_date_from']) && $_REQUEST['log_date_from'] != ''){
			$sql.= " AND l.attended_date >= '".$_REQUEST['log_date_from']."'";
			$urlvars.= "&log_date_from=".$_REQUEST['log_date_from'];
		}
		if(isset($_REQUEST['log_date_to']) && $_REQUEST['log_date_to'] != ''){
			$sql.= " AND l.attended_date <= '".$_REQUEST['log_date_to']."'";
			$urlvars.= "&log_date_to=".$_REQUEST['log_date_to'];
		}		

		$sSql = "SELECT COUNT(*) as num FROM employee_attendance AS l LEFT JOIN employees AS em ON l.employee_id = em.employee_id LEFT JOIN department AS d ON em.department_id = d.did WHERE $sql";
		$records = $this->Common_Model->db_query($sSql);
		$totalrecords = $records[0]['num'];
		if($totalrecords){
			$sSql = "SELECT em.employee_id, em.employee_name, em.department_id, em.emp_fathername, em.aadhar_number, em.emp_mobile, em.employee_mobile2, em.employee_address, em.employee_email, em.emp_status, em.epf_status, em.epf_percentile, em.emp_firstname, em.emp_lastname, em.emp_dob, em.emp_photo, d.department_name, d.shift_id, d.start_time, d.end_time, d.department_active, l.id, l.attended_date, l.in_time, l.out_time, l.attend_remarks FROM employee_attendance AS l LEFT JOIN employees AS em ON l.employee_id = em.employee_id LEFT JOIN department AS d ON em.department_id = d.did WHERE $sql ORDER BY l.attended_date DESC";
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
		$data['activemenu'] = 'employee';
		$data['activesubmenu'] = 'markattendance_client';
		$data['employees'] = $this->Common_Model->FetchData("employees", "*", "emp_cat='Others' AND emp_status = 'Active' ORDER BY employee_name ASC");
		$data['month'] = isset($_REQUEST['month']) ? $_REQUEST['month'] : date('m', strtotime(date('Y-m')." -1 month"));
		$data['units'] = $this->Common_Model->FetchData("units", "*", "1 ORDER BY unit_name ASC");
		$this->load->view('employee/markattendance_client', $data);
	}

	function get_designationByUnit(){
		$unit_id = $this->input->post('unit_id');
		$rec = $this->Common_Model->FetchData("contractedpost as a LEFT JOIN designation as b on a.post_designation=b.designation_id","*","unit_id=".$unit_id."");
		$html2='<option value="">select</option>';
		if ($rec) { for ($i=0; $i < count($rec); $i++) { 
			$html2.='<option value="'.$rec[$i]['designation_id'].'">'.$rec[$i]['designation_name'].'</option>';
		}}

		$unit = $this->Common_Model->FetchData("units","*","unit_id=".$unit_id."");



		$html = $html2.',';
		$html .= $unit[0]['unit_name'].',';
		$html .= $unit[0]['unit_location'].',';
		$html .= $unit[0]['unit_active'].',';
		echo $html;

	}

	//Employee Data For Attendance
	function get_empdataByDesignationforAtten(){
		$designation_id = $this->input->post('designation_id');
		$unit_id = $this->input->post('unit_id');
		$year = $this->input->post('year');
		$month = $this->input->post('month');

		$employee = $this->Common_Model->FetchData("employees","*","designation_id = ".$designation_id." AND emp_cat='Others'");

		$records = $this->Common_Model->FetchData("employee_attendanceclient", "*", "unit_id = ".$this->input->post("unit_id")." AND designation_id = ".$this->input->post("designation_id")." AND year = ".$this->input->post("year")." AND month = ".$this->input->post("month")."");

		if ($records) {

			$html='
				<table class="table" border="0" width="100%" cellpadding="0">
					<tr>
						<th width="10%">SlNo</th>
						<th width="10%">Emp.Code</th>
						<th width="40%">Emp.Name</th>
						<th width="12%">Payable Days</th>
						<th width="12%">OT</th>
						
						<th width="16%">Total Duty</th>
					</tr>
				';
			$rec = $this->Common_Model->FetchData("emp_attenclient_items as a LEFT JOIN employees as b on a.employee_id=b.employee_id","*","a.employee_attendanceclient_id=".$records[0]['employee_attendanceclient_id']."");
		if ($rec) { for ($i=0; $i < count($rec); $i++) { 
			$html.='
					<tr>
						<td width="10%">'.($i+1).'</td>
						<td width="10%">'.$rec[$i]['employee_id'].'
							<input type="hidden" class="form-control input-sm" name="employee_id[]" value="'.$rec[$i]['employee_id'].'">
						</td>
						<td width="40%">'.$rec[$i]['employee_name'].'</td>
						<td width="12%"><input type="number" class="form-control input-sm payable_days calc_days" name="payable_days[]" value="'.$rec[$i]['payable_days'].'"></td>
						<td width="12%"><input type="number" class="form-control input-sm ot_days calc_days" name="ot_days[]" value="'.$rec[$i]['ot_days'].'"></td>
						
						<td width="16%"><input type="number" class="form-control input-sm total_duty" name="total_duty[]" value="'.$rec[$i]['total_duty'].'" readonly></td>
					</tr>
			';
		}}
		
		$html.='</table>
				<button type="submit" class="btn btn-primary btn-sm" value="submitBtn" name="submitBtn" >Submit</button>
		';

		}else{
			$html='';
			if ($employee) {
		
		$html.='
				<table class="table" border="0" width="100%" cellpadding="0">
					<tr>
						<th width="10%">SlNo</th>
						<th width="10%">Emp.Code</th>
						<th width="40%">Emp.Name</th>
						<th width="12%">Payable Days</th>
						<th width="12%">OT</th>
	
						<th width="16%">Total Duty</th>
					</tr>
				';
		 for ($i=0; $i < count($employee); $i++) { 
			$html.='
					<tr>
						<td width="10%">'.($i+1).'</td>
						<td width="10%">'.$employee[$i]['employee_id'].'
							<input type="hidden" class="form-control input-sm" name="employee_id[]" value="'.$employee[$i]['employee_id'].'">
						</td>
						<td width="40%">'.$employee[$i]['employee_name'].'</td>
						<td width="12%"><input type="number" class="form-control input-sm payable_days calc_days" name="payable_days[]" value="0"></td>
						<td width="12%"><input type="number" class="form-control input-sm ot_days calc_days" name="ot_days[]" value="0"></td>
						
						<td width="16%"><input type="number" class="form-control input-sm total_duty" name="total_duty[]" value="0" readonly></td>
					</tr>
			';
		}
		
		$html.='</table>
				<button type="submit" class="btn btn-primary btn-sm" value="submitBtn" name="submitBtn" >Submit</button>
		';
	}else{
		$html='<div>
				  <h5 style="font-family: tahoma; margin-top: 50px;font-size: 20px;color: #9e9e9e;text-align: center;font-weight: 200;"> Sorry no data found!	</h5>
				  <span class="bell fa fa-bell"></span>
				</div>';
	}

	}

		echo $html;
	}

	function biometriclog(){
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$data['per_page'] = $per_page = isset($_REQUEST['per_page']) ? $_REQUEST['per_page'] : 10;
		$data['page'] = $page = isset($_REQUEST['page']) ? $_REQUEST['page'] : '1';
		$this->load->helper('url');
		$currentURL = current_url();
		$sql = "1";
		$urlvars = '';
		if(isset($_REQUEST['employee_id']) && $_REQUEST['employee_id'] != ''){
			$sql.= " AND l.employee_id = '".$_REQUEST['employee_id']."'";
			$urlvars.= "&employee_id=".$_REQUEST['employee_id'];
		}
		if(isset($_REQUEST['log_date_from']) && $_REQUEST['log_date_from'] != ''){
			$sql.= " AND l.created_on >= '".$_REQUEST['log_date_from']."'";
			$urlvars.= "&log_date_from=".$_REQUEST['log_date_from'];
		}
		if(isset($_REQUEST['log_date_to']) && $_REQUEST['log_date_to'] != ''){
			$sql.= " AND l.created_on <= '".$_REQUEST['log_date_to']."'";
			$urlvars.= "&log_date_to=".$_REQUEST['log_date_to'];
		}		

		$sSql = "SELECT COUNT(*) as num FROM employee_attendance_log AS l LEFT JOIN employees AS em ON l.employee_id = em.employee_id LEFT JOIN department AS d ON em.department_id = d.did WHERE $sql";
		$records = $this->Common_Model->db_query($sSql);
		$totalrecords = $records[0]['num'];
		if($totalrecords){
			$sSql = "SELECT em.employee_id, em.employee_name, em.department_id, em.fathus_name, em.aadhar_number, em.employee_mobile, em.employee_mobile2, em.employee_address, em.employee_email, em.employee_status, em.epf_status, em.epf_percentile, em.emp_firstname, em.emp_lastname, em.emp_dob, em.emp_photo, em.emp_blood_group, d.department_name, d.shift_id, d.start_time, d.end_time, d.department_active, l.log_id, l.created_on FROM employee_attendance_log AS l LEFT JOIN employees AS em ON l.employee_id = em.employee_id LEFT JOIN department AS d ON em.department_id = d.did WHERE $sql ORDER BY l.log_id DESC";
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
		$data['activemenu'] = 'employee';
		$data['activesubmenu'] = 'biometriclog';
		$data['employees'] = $this->Common_Model->FetchData("employees", "*", "1 ORDER BY employee_name ASC");
		$this->load->view('employee/biometriclog', $data);
	}

		public function addstudentfeedback($feedback_id=0){
		$data 			  	 = array();
		$curSession 		 = $this->session->userdata['session_name'];
		$data['feedback_id'] = $feedback_id;
		$data['tab_name'] 	 = ($feedback_id > 0)?'Update':'Add';
		$data['btn_val'] 	 = ($feedback_id > 0)?'Update':'Add';
		$msg              	 = ($feedback_id > 0)?'Record Updated successfully.':'Record Added successfully.';
		$teacherId 			 = $this->session->get_userdata()['employee_tagged_id'];
		$data['teacherId']   = $this->session->get_userdata()['employee_tagged_id'];
		$data['feedback_data']= array();
		if($this->input->post('submitBtn')){
			$this->form_validation->set_rules('class_id', 'Class', 'trim|required');
			//$this->form_validation->set_rules('subject_id', 'Subject', 'trim|required');
			//$this->form_validation->set_rules('student_id', 'Student', 'trim|required');
			$this->form_validation->set_rules('remark', 'Subject wise remark', 'trim|required');
			$this->form_validation->set_error_delimiters('<p class="has-error"><label class="control-label">', '</label></p>');
			if($this->form_validation->run()){
				$data_list = array(
					"class"			=> $this->input->post("class_id"),
					"subject"		=> $this->input->post("subject_id"),
					"teacher_id"    => $teacherId,
					"student_id"	=> implode(' ', $this->input->post('student_id[]')),
					"remark"		=> $this->input->post("remark"),
					"other_remark"	=> $this->input->post("other_remark"),
					"session"	    => $curSession
				);
				//print_r($data_list);exit;
				if($feedback_id > 0){
					$this->Common_Model->update_records("erp_student_feedback", "feed_id", $feedback_id, $data_list);
				}else{
					$this->Common_Model->dbinsertid("erp_student_feedback", $data_list);	
				}
				$this->session->set_flashdata('success', $msg);
				redirect('employee/viewfeedback');
			}else{
				$this->session->set_flashdata("error", validation_errors());
			}
		}

		if($feedback_id > 0){
			$data['feedback_data'] = $this->Common_Model->FetchData("erp_student_feedback", "*", "feed_id = ".$feedback_id);
		}
		//echo '<pre>';print_r($data);exit;
		$data['activemenu'] = 'employeerec';
		$data['activesubmenu'] = 'lessionplan';
		$this->load->view('employee/addstudentfeedback', $data);
	}


	function viewfeedback(){
		$this->load->helper('url');
		$currentURL = current_url();
		$data = array();
		$teacherId 			 = $this->session->get_userdata()['employee_tagged_id'];
		$sql = "1";
		$sql .= " AND teacher_id = ".$teacherId;
		$queryvars = "";
		$sql.= " ORDER BY feed_id DESC";
		$rows = $this->Common_Model->FetchRows("`erp_student_feedback` A LEFT JOIN employees B ON (A.teacher_id = B.employee_id) LEFT JOIN students C ON (A.student_id = C.student_id) LEFT JOIN classes D ON (A.class = D.class_id) LEFT JOIN subjects E ON (A.subject = E.subject_id)", "A.*,B.employee_name,CONCAT(C.student_first_name,' ',C.student_last_name) AS student_name,D.class_name,E.subject_name", "$sql");
		$data['page_num'] = $page_num = isset($_REQUEST['page']) ? $_REQUEST['page'] : 1;
		$this->load->library("Paginator");
		$this->paginator->setparam(array("page_num" => $page_num, "num_rows" => $rows));
		$this->paginator->set_Limit(10);
		$range1 = $this->paginator->getRange1();
		$range2 = $this->paginator->getRange2();

		$sql .= " LIMIT ".$range1.', '.$range2;
		$records = $this->Common_Model->db_query("SELECT A.*,B.employee_name,CONCAT(C.student_first_name,' ',C.student_last_name) AS student_name,D.class_name,E.subject_name FROM `erp_student_feedback` A LEFT JOIN employees B ON (A.teacher_id = B.employee_id) LEFT JOIN students C ON (A.student_id = C.student_id) LEFT JOIN classes D ON (A.class = D.class_id) LEFT JOIN subjects E ON (A.subject = E.subject_id) WHERE ".$sql);

		$paging_info = $this->paginator->DBPagingNav($queryvars, $currentURL);

		$data['tot_page'] = $paging_info[0];
		$data['sPages'] = $paging_info[1];
		$data['rows'] = $rows;
		$data['records'] = $records;
		$data['activemenu'] = 'employee';
		$data['activesubmenu'] = 'viewfeedback';
		$this->load->view('employee/viewfeedback', $data);
	}

	function delete_feedback($feed_id){
		$this->Common_Model->DelData("erp_student_feedback", "feed_id = ".$feed_id);
		redirect($_SERVER['HTTP_REFERER']);
	}


	public function addstudymaterial($material_id=0){
		$data 			  	  = array();
		$curSession 		  = $this->session->userdata['session_name'];
		$data['material_id']  = $material_id;
		$data['tab_name'] 	  = ($material_id > 0)?'Update':'Add';
		$data['btn_val'] 	  = ($material_id > 0)?'Update':'Add';
		$msg              	  = ($material_id > 0)?'Record Updated successfully.':'Record Added successfully.';
		$teacherId 			  = $this->session->get_userdata()['employee_tagged_id'];
		$data['teacherId']    = $this->session->get_userdata()['employee_tagged_id'];
		$data['material_data']= array();
		if($this->input->post('submitBtn')){
			$this->form_validation->set_rules('class_id', 'Class', 'trim|required');
			$this->form_validation->set_rules('subject_id', 'Subject', 'trim|required');
			$this->form_validation->set_rules('chapter_id', 'Chapter', 'trim|required');
			$this->form_validation->set_error_delimiters('<p class="has-error"><label class="control-label">', '</label></p>');
			if($this->form_validation->run()){
				$data_list = array(
					"class_id"			=> $this->input->post("class_id"),
					"subject_id"		=> $this->input->post("subject_id"),
					"teacher_id"        => $teacherId,
					"chapter_id"		=> $this->input->post("chapter_id"),
					"material_remark"	=> $this->input->post("material_remark"),
					"session"	        => $curSession
				);

				if($_FILES['material_file']['name']!=""){
					$newfile = 'material'.uniqid();
					$config = array(
						'upload_path' => "uploads/material/",
						'allowed_types' => 'pdf|doc|docx|jpg|png|jpeg',
						'overwrite' => TRUE,
						'file_name' => $newfile,
						'max_size' => "200048000" 
					);

					$this->load->library('upload', $config);
					$this->upload->initialize($config);
					if($this->upload->do_upload("material_file"))
					{
						if($this->input->post("hdnmaterial_file") != ''){
							unlink('uploads/material/'.$this->input->post("hdnmaterial_file"));
						}
						$dat = $this->upload->data();
						$data_list['material_file'] = $dat['file_name'];
					}else{
						$filename = '';
						$this->session->set_flashdata('error', $this->upload->display_errors());
						print_r($this->upload->display_errors());exit;
						redirect($_SERVER['HTTP_REFERER']);
					}
				}else{ $data_list['material_file'] = ($this->input->post("hdnmaterial_file"))?$this->input->post("hdnmaterial_file"):'';}
				//echo '<pre>';print_r($data_list);exit;
				if($material_id > 0){
					$this->Common_Model->update_records("erp_student_material", "material_id", $material_id, $data_list);
				}else{
					$this->Common_Model->dbinsertid("erp_student_material", $data_list);	
				}
				$this->session->set_flashdata('success', $msg);
				redirect('employee/viewmaterial');
			}else{
				$this->session->set_flashdata("error", validation_errors());
			}
		}

		if($material_id > 0){
			$data['material_data'] = $this->Common_Model->FetchData("erp_student_material", "*", "material_id = ".$material_id);
		}
		//echo '<pre>';print_r($data);exit;
		$data['activemenu'] = 'employeerec';
		$data['activesubmenu'] = 'lessionplan';
		$this->load->view('employee/addstudymaterial', $data);
	}



	function viewmaterial(){
		$this->load->helper('url');
		$currentURL = current_url();
		$data = array();
		$teacherId 			 = $this->session->get_userdata()['employee_tagged_id'];
		$sql = "1";
		$sql .= " AND teacher_id = ".$teacherId;
		$queryvars = "";
		$sql.= " ORDER BY material_id DESC";
		$rows = $this->Common_Model->FetchRows("`erp_student_material` A LEFT JOIN employees B ON (A.teacher_id = B.employee_id) LEFT JOIN classes D ON (A.class_id = D.class_id) LEFT JOIN subjects E ON (A.subject_id = E.subject_id) LEFT JOIN chapters F ON (A.chapter_id = F.chapter_id)", "A.*,B.employee_name,D.class_name,E.subject_name,F.chapter_name", "$sql");
		$data['page_num'] = $page_num = isset($_REQUEST['page']) ? $_REQUEST['page'] : 1;
		$this->load->library("Paginator");
		$this->paginator->setparam(array("page_num" => $page_num, "num_rows" => $rows));
		$this->paginator->set_Limit(10);
		$range1 = $this->paginator->getRange1();
		$range2 = $this->paginator->getRange2();

		$sql .= " LIMIT ".$range1.', '.$range2;
		$records = $this->Common_Model->db_query("SELECT A.*,B.employee_name,D.class_name,E.subject_name,F.chapter_name FROM `erp_student_material` A LEFT JOIN employees B ON (A.teacher_id = B.employee_id) LEFT JOIN classes D ON (A.class_id = D.class_id) LEFT JOIN subjects E ON (A.subject_id = E.subject_id) LEFT JOIN chapters F ON (A.chapter_id = F.chapter_id) WHERE ".$sql);

		$paging_info = $this->paginator->DBPagingNav($queryvars, $currentURL);

		$data['tot_page'] = $paging_info[0];
		$data['sPages'] = $paging_info[1];
		$data['rows'] = $rows;
		$data['records'] = $records;
		$data['activemenu'] = 'employee';
		$data['activesubmenu'] = 'viewfeedback';
		$this->load->view('employee/viewmaterial', $data);
	}

	function delete_material($material_id,$material_file=''){
		if($material_file != ''){
			unlink('uploads/material/'.$material_file);
		}
		$this->Common_Model->DelData("erp_student_material", "material_id = ".$material_id);
		redirect($_SERVER['HTTP_REFERER']);
	}

		function assignclassteacher($teacherId){
		if($teacherId > 0){
			$data['teacherId'] 		= $teacherId;
			$data['activemenu'] 	= '';
			$data['activesubmenu']  = '';
			if($this->input->post('submitBtn')){
				$this->form_validation->set_rules('class_id', 'Class', 'trim|required');
				$this->form_validation->set_error_delimiters('<p class="has-error"><label class="control-label">', '</label></p>');
				if($this->form_validation->run()){
					$data_list = array(
						"class_id"			=> $this->input->post("class_id"),
						"section_id"		=> $this->input->post("student_section"),
						"teacher_id"		=> $teacherId
					);
					$class_id = $this->input->post("class_id");
					$section_id = $this->input->post("student_section");
					$countEisting = $this->Common_Model->countRows("erp_assign_class_teacher","class_id = $class_id AND section_id = $section_id AND teacher_id NOT IN (".$teacherId.")");
					//echo $countEisting;exit;
					if($countEisting > 0){
						$this->session->set_flashdata('error', 'Selected Class already assigned to different teacher');
						redirect('employee');
						//$this->Common_Model->update_records("erp_assign_class_teacher", "teacher_id", $teacher_id, $data_list);
					}else{
						$countEisting = $this->Common_Model->countRows("erp_assign_class_teacher","teacher_id = ".$teacherId);
						if($countEisting > 0){
							$this->Common_Model->update_records("erp_assign_class_teacher", "teacher_id", $teacherId, $data_list);
						}else{
							$this->Common_Model->dbinsertid("erp_assign_class_teacher", $data_list);
						}
					}	
					
					$this->session->set_flashdata('success', 'Class Teacher successfully assigned');
					redirect('employee');
				}else{
					$this->session->set_flashdata("error", validation_errors());
				}
			}
			if($teacherId > 0){
				$data['classes'] = $this->Common_Model->db_query("SELECT class_id,class_name FROM `classes` WHERE class_active = 'Active' AND class_id IN (SELECT class_id FROM teacher_class_subject_tag WHERE teacher_id = ".$teacherId.")");
				$data['assigned_class'] = $this->Common_Model->FetchData("erp_assign_class_teacher", "*", "teacher_id = ".$teacherId);
				
			}
			//echo '<pre>';print_r($data['teacher_class']);exit;
			$this->load->view('employee/assignclassteacher', $data);
		}
	}
	
	public function add_marks(){
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		if($this->input->post('submitBtn')){
			$this->form_validation->set_rules('session_id', 'Session', 'trim|required');
			//$this->form_validation->set_rules('student_id', 'Student', 'trim|required');
			$this->form_validation->set_error_delimiters('<p class="has-error"><label class="control-label">', '</label></p>');
			if($this->form_validation->run()){
				if($this->input->post('total') > 0){
				$data_list = array(
					'session_id'					=> $this->input->post('session_id'),
					'class_id'						=> $this->input->post('class_id'),
					'section'						=> $this->input->post('student_section'),
					'subject_id'					=> $this->input->post('subject_name'),
					'sub_status'					=> $this->input->post('sub_status'),
					'term'							=> $this->input->post('exam_term'),
					'create_by'					=> $this->session->userdata('employee_tagged_id'),
					'created_on'					=> date("Y-m-d H:i:s")
				);
				//print_r($data_list);exit;
			}

				$exam_result_id = $this->Common_Model->dbinsertid("exam_results", $data_list);
				//echo $exam_result_id;exit;
				if($exam_result_id){
					for($i=0; $i < count($this->input->post('student_id')); $i++){
						if($this->input->post('subject_name') != ''){
							//echo $exam_result_id;exit;
							$subject = $this->Common_Model->FetchData("subjects", "*", "subject_id = ".$this->input->post('subject_name'));
							$datalist = array(
								'exam_result_id'  => $exam_result_id,
								'student_id'	  => $this->input->post('student_id')[$i],
								'pmt'			  => $this->input->post('pmt')[$i],
								'p_test'		  => $this->input->post('periodic_test1')[$i],
								'per_test'		  => $this->input->post('periodic_test2')[$i],
								'p_best'		  => $this->input->post('periodic_best')[$i],
								'p_assessment'	  => $this->input->post('periodic_assessment')[$i],
								'm_assessment'	  => $this->input->post('multiple_assessment')[$i],
								'portfolio'		  => $this->input->post('portfolio')[$i],
								's_enrichment' 	  => $this->input->post('sub_enrichment')[$i],
								'p_total' 	      => $this->input->post('total')[$i],
								'total' 	      => $this->input->post('total40')[$i],
								'theory' 	      => $this->input->post('opt_theory')[$i],
								'practical' 	  => $this->input->post('opt_practical')[$i],
								'sub_total' 	  => $this->input->post('total50')[$i],
								'grand_total' 	  => $this->input->post('total100')[$i],
								'grade'			  => $this->input->post('grade')[$i]
								
							);
							$this->Common_Model->dbinsertid("exam_result_items", $datalist);

						}
					}
				}
				$this->session->set_flashdata('success', 'Exam result added successfully.' );
				redirect('examinations/addcertificate');
			}else{
				$this->session->set_flashdata('error', validation_errors());
			}
		}
		$data['activemenu'] = 'employee';
		$data['activesubmenu'] = 'add_marks';
		$data['sessions'] = $this->Common_Model->FetchData("sessions", "*", "1 ORDER BY session_id DESC");
		$data['classes'] = $this->Common_Model->FetchData("teacher_class_subject_tag", "*", "teacher_id = ".$this->session->userdata('employee_tagged_id')."");
		$data['fees'] = $this->Common_Model->FetchData("admission_fees AS f LEFT JOIN sessions AS s ON f.session_id = s.session_id LEFT JOIN classes AS c ON f.class_id = c.class_id", "*", "1");
		$this->load->view('employee/add_marks', $data);
	}

	function printsalaryreceipt($saltranid,$employeeId,$salmonth,$salyear){
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$saltranid   		= $saltranid;
		$employeeId   		= $employeeId;
		$salmonth = $data['salmonth'] = $salmonth;
		$salyear = $data['salyear']= $salyear;
		$userId 					= $this->session->userdata['user_id'];
		$curSession    				= $this->session->userdata['session_name'];
		$curSession			= $curSession;
		$checkIfproper 				= $this->Common_Model->db_query("SELECT COUNT(1) as alreadyCred FROM salary_transaction WHERE employee_id = ".$employeeId." AND year = '".$salyear."' AND month = '".$salmonth."' AND credit_status = 0");
		$saltran 				= $this->Common_Model->db_query("SELECT * FROM salary_transaction WHERE transaction_id = '".$saltranid."'");
		$voucher			= $this->Common_Model->db_query("SELECT * FROM vouchers WHERE voucher_id = '".$saltran[0]['voucher_id']."'");
		if($checkIfproper[0]['alreadyCred'] > 0){
			redirect('employee/salarytransaction/'.$employeeId);exit;
		} 

		$data['empuser'] = $this->Common_Model->FetchData("users ","*","employee_tagged_id='".$employeeId."'");

		$employeeData   			= $this->Common_Model->db_query("SELECT A.* FROM employees A  WHERE 1 and A.employee_id = ".$employeeId);

		$data['department'] = $this->Common_Model->FetchData("department","*","did='".$employeeData[0]['department_id']."'");
		$data['designation'] = $this->Common_Model->FetchData("designation","*","designation_id='".$employeeData[0]['designation_id']."'");

		$empSalary = $this->Common_Model->FetchData("salary_transaction_wages as a LEFT JOIN wages as b on a.wgs_id=b.wages_id","*","a.sal_tranid='".$saltranid."' AND a.emp_id='".$employeeId."'");


		
		$getAllholidays             = $this->Common_Model->db_query("SELECT * FROM holiday WHERE type = 1 AND MONTH(from_date) = '".$salmonth."' AND YEAR(from_date) = '".$salyear."'");
		$data['adv_salary'] = $adv_salary  = $this->Common_Model->db_query("SELECT A.*,COALESCE(SUM(B.installamt),0) AS paidInstallment FROM adv_salary A LEFT JOIN adv_salary_installment B ON (A.`advsal_id` = B.advsal_id) WHERE A.employee_id = ".$employeeId." AND A.adv_taken_status = 0");


		$data['allTransaction']     = $this->Common_Model->db_query("SELECT * FROM salary_transaction_attribute WHERE sal_tran_id = ".$saltranid);

		$adv_salary                 = $this->Common_Model->db_query("SELECT A.*,COALESCE(SUM(B.installamt),0) AS paidInstallment FROM adv_salary A LEFT JOIN adv_salary_installment B ON (A.`advsal_id` = B.advsal_id) WHERE A.employee_id = ".$employeeId." AND A.adv_taken_status = 0");
		
		$leave_taken =  $data['leave_taken'] = $this->Common_Model->db_query("SELECT A.*,B.leave_type,B.is_paid FROM `leave_application` A LEFT JOIN leave_master B ON (A.leave_type = B.leave_id) WHERE A.employee_id = ".$employeeId." AND A.leave_status = 1 AND MONTH(A.apply_from) = '".$salmonth."' AND YEAR(A.apply_from) = '".$salyear."'");

		$data['totalleaves'] = $this->Common_Model->db_query("SELECT SUM(no_of_days) AS totleaves FROM leave_application as a LEFT JOIN leave_master as b on a.leave_type=b.leave_id WHERE a.employee_id = ".$employeeId." AND a.leave_status = 1 AND MONTH(a.apply_from) = '".$salmonth."' AND YEAR(a.apply_from) = '".$salyear."' ");
		
		if(!empty($getAllholidays)){
			$holidayArr = array_column($getAllholidays, 'from_date');
		}else{
			$holidayArr = array();
		}
		/************************Number of working days calculation of the month*****************/
		$monthStartDate             = date($salyear.'-'.$salmonth.'-01');
		$monthEndDate   			= date("Y-m-t", strtotime($monthStartDate));
		$start = new DateTime($monthStartDate);
		$end = new DateTime($monthEndDate);
		$end->modify('+1 day');
		$interval = $end->diff($start);
		$days = $interval->days;
		$period = new DatePeriod($start, new DateInterval('P1D'), $end);
		$holidays = $holidayArr;
		foreach($period as $dt) {
		    $curr = $dt->format('D');
		    /*if ($curr == 'Sun') {
		        $days--;
		    }
		    elseif (in_array($dt->format('Y-m-d'), $holidays)) {
		        $days--;
		    }*/
		}
		/********************days calculation end**************************************/
		//echo $days;
		$data['employee'] = $employee			= $employeeData;
		$data['empSalary'] = $empSalary;
		$getAllholidays 	= $getAllholidays;
		$adv_salary 		= $adv_salary;
		$leave_taken 		= $leave_taken;
		$data['no_of_working_days'] = $days;
		$advinstallments	= $this->Common_Model->FetchData("adv_salary_installment AS a LEFT JOIN vouchers AS v ON a.voucher_id = v.voucher_id", "*", "a.transaction_id = '$saltranid'");
		//echo '<pre>';print_r($data);exit; 
		$html = $this->load->view('payments/printsalaryreceipt', $data, TRUE);
		$this->load->library('Pdf');
		$pdf = new Pdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('TFSM');
		$pdf->SetTitle('TFSM');
		$pdf->SetSubject('TFSM');

		$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
		$pdf->setHeaderData($ln='', $lw=0, $ht='', $hs='', $tc=array(0,0,0), $lc=array(0,0,0));
		$pdf->SetMargins(5, 5, 5, true);
		$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

		$pdf->SetAutoPageBreak(TRUE, 17);
		// set image scale factor
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
	
	function get_empdataforAtten(){
		
		$unit_id = $this->input->post("unit_id");
		$designation_id = $this->input->post("designation_id");
		$employee_code = $this->input->post("employee_code");
		$month = $this->input->post("month");
		$year = $this->input->post("year");



		$employee = $this->Common_Model->FetchData("employees","*","designation_id=".$designation_id." AND techno_emp_id='".$employee_code."'");
		

		
		

		
		if ($employee) {

			$rec = $this->Common_Model->FetchData("emp_attenclient_items as a LEFT JOIN employee_attendanceclient as b on a.employee_attendanceclient_id =b.employee_attendanceclient_id","*","a.employee_id=".$employee[0]['employee_id']." AND b.designation_id=".$designation_id." AND b.unit_id=".$unit_id." AND b.year=".$year." AND b.month=".$month."");


		if ($rec) {
			$payabledays = $rec[0]['payable_days'];
			$ot_days = $rec[0]['ot_days'];
			$total_duty = $rec[0]['total_duty'];
			$extra_hour = $rec[0]['extra_hour'];
			$fooding = $rec[0]['fooding'];
			$uniform = $rec[0]['uniform'];
			$pt = $rec[0]['pt'];
			$allowances = $rec[0]['allowances'];

		}else{
			$payabledays = 0;
			$ot_days = 0;
			$total_duty = 0;
			$extra_hour = 0;
			$fooding = 0.00;
			$uniform = 0.00;
			$pt = 0.00;
			$allowances = 0.00;
		}



			$html = $employee[0]['employee_name'].'@#,';
			$html .= $employee[0]['employee_id'].'@#,';
			$html .= $payabledays.'@#,';
			$html .= $ot_days.'@#,';
			$html .= $total_duty.'@#,';
			$html .= $extra_hour.'@#,';
			$html .= $fooding.'@#,';
			$html .= $uniform.'@#,';
			$html .= $pt.'@#,';
			$html .= $allowances.'@#,';
		}else{
			$html ='';
		}
		

		echo $html;
	}
	
	function issue_accessories_client(){
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));

		$data['per_page'] = $per_page = isset($_REQUEST['per_page']) ? $_REQUEST['per_page'] : 100;
		$data['page'] = $page = isset($_REQUEST['page']) ? $_REQUEST['page'] : '1';
		$this->load->helper('url');
		$currentURL = current_url();
		$sql = "1";
		$urlvars = '';
		if(isset($_REQUEST['date_from']) && isset($_REQUEST['date_to']) && $_REQUEST['date_from'] == $_REQUEST['date_to'] && $_REQUEST['date_from'] != ''){
			$sql.= " AND DATE(a.issue_date) = '".$_REQUEST['date_from']."'";
			$urlvars.= "&date_from=".$_REQUEST['date_from']."&date_to=".$_REQUEST['date_to'];
		}else{
			if(isset($_REQUEST['date_from']) && $_REQUEST['date_from'] != ''){
				$sql.= " AND DATE(a.issue_date) >= '".$_REQUEST['date_from']."'";
				$urlvars.= "&date_from=".$_REQUEST['date_from'];
			}
			
			if(isset($_REQUEST['date_to']) && $_REQUEST['date_to'] != ''){
				$sql.= " AND DATE(a.issue_date) <= '".$_REQUEST['date_to']."'";
				$urlvars.= "&date_to=".$_REQUEST['date_to'];
			}
		}
		
		if(isset($_REQUEST['employee_code']) && $_REQUEST['employee_code'] != ''){
			$sql.= " AND a.employee_code LIKE '%".$_REQUEST['employee_code']."%'";
			$urlvars.= "&employee_code=".$_REQUEST['employee_code'];
		}

		if(isset($_REQUEST['issue_status']) && $_REQUEST['issue_status'] != ''){
			$sql.= " AND a.issue_status LIKE '%".$_REQUEST['issue_status']."%'";
			$urlvars.= "&issue_status=".$_REQUEST['issue_status'];
		}

 
		$sSql = "SELECT COUNT(*) as num FROM issue_accessories_client as a WHERE $sql";
		$records = $this->Common_Model->db_query($sSql);
		$totalrecords = $records[0]['num'];
		if($totalrecords){
			$sSql = "SELECT * FROM issue_accessories_client as a LEFT JOIN users AS b ON a.issueadded_by=b.user_id  WHERE $sql ORDER BY a.issue_date DESC";
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
		
		$data['activemenu'] = 'employee';
		$data['activesubmenu'] = 'issue_accessories_client';
		$this->load->view('employee/issue_accessories_client', $data);
	}

	function add_issueaccessories(){
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));

		if($this->input->post('submitBtn')){
			$this->form_validation->set_rules('employee_name', 'Employee Name', 'trim|required');
			$this->form_validation->set_rules('employee_code', 'Employee Code', 'trim|required');
			$this->form_validation->set_rules('issue_date', 'Issue Date', 'trim|required');
			
			
			$this->form_validation->set_error_delimiters('<p class="has-error"><label class="control-label">', '</label></p>');
			if($this->form_validation->run()){
				$data_list = array(
						'employee_code' => $this->input->post("employee_code"),
						'employee_id' 	=> $this->input->post("employee_id"),
						'employee_name' => $this->input->post("employee_name"),
						'issue_date' 	=> $this->input->post("issue_date"),
						'tot_amount' 	=> $this->input->post("tot_amount"),
						'issue_status' 	=> $this->input->post("issue_status"),
						'issueadded_by' => $this->session->userdata("user_id"),
				);
				$issue_id = $this->Common_Model->dbinsertid("issue_accessories_client",$data_list);
				if ($issue_id) {
					foreach((array)$this->input->post('item_name[]') as $k => $v){
						if($this->input->post('item_name['.$k.']') != ''){
							$itemdata = $this->Common_Model->FetchData("assets", "*", "asset_id = ".$this->input->post('item_name['.$k.']'));
							$datalist = array(
								'item_id'			=> $this->input->post('item_name['.$k.']'),
								'item_name'			=> $itemdata[0]['item_name'],
								'item_type'			=> 'Accessories',
								'item_quantity'		=> $this->input->post('item_quantity['.$k.']'),
								'item_price'		=> $this->input->post('item_price['.$k.']'),
								'issue_id'			=> $issue_id,
								'final_amount'		=> $this->input->post('item_total_price['.$k.']'),
								'base_amount'		=> $this->input->post('item_total_price['.$k.']'),
								//'discount_amount'	=> 0
							);
							$this->Common_Model->dbinsertid("issue_accessories_items", $datalist);
							$this->Common_Model->db_query("UPDATE assets SET item_qty = item_qty - ".$this->input->post('item_quantity['.$k.']')." WHERE asset_id = ".$this->input->post('item_name['.$k.']'));
						}
					}

				$this->session->set_flashdata('success', 'Issue Accessories successfully.' );
				redirect('employee/add_issueaccessories');
				}else{
					$this->session->set_flashdata('error', 'Something went wrong.' );
				redirect('employee/add_issueaccessories');
				}
			}else{
				$this->session->set_flashdata('error', validation_errors() );
				redirect('employee/add_issueaccessories');
			}
		}

		
		$data['items'] 	= $this->Common_Model->FetchData("assets", "*", "item_type='Asset' ORDER BY item_name ASC");
		$data['activemenu'] = 'employee';
		$data['activesubmenu'] = 'add_issueaccessories';
		$this->load->view('employee/add_issueaccessories', $data);
	}

	function edit_issueaccessories($issue_id=0){
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$data['issue_id'] = $issue_id;
		if($this->input->post('submitBtn')){
			$this->form_validation->set_rules('employee_name', 'Employee Name', 'trim|required');
			$this->form_validation->set_rules('employee_code', 'Employee Code', 'trim|required');
			$this->form_validation->set_rules('issue_date', 'Issue Date', 'trim|required');
			
			
			$this->form_validation->set_error_delimiters('<p class="has-error"><label class="control-label">', '</label></p>');
			if($this->form_validation->run()){
				$data_list = array(
						'employee_code' => $this->input->post("employee_code"),
						'employee_id' 	=> $this->input->post("employee_id"),
						'employee_name' => $this->input->post("employee_name"),
						'issue_date' 	=> $this->input->post("issue_date"),
						'tot_amount' 	=> $this->input->post("tot_amount"),
						'issue_status' 	=> $this->input->post("issue_status"),
						'issueadded_by' => $this->session->userdata("user_id"),
				);
				 $this->Common_Model->update_records("issue_accessories_client","issue_id",$issue_id,$data_list);
				if ($issue_id) {
					$issueitems = $this->Common_Model->FetchData("issue_accessories_items","*","issue_id=".$issue_id."");
					if ($issueitems) { for ($i=0; $i < count($issueitems); $i++) { 
						$this->Common_Model->db_query("UPDATE assets SET item_qty = item_qty + ".$issueitems[$i]['item_quantity']." WHERE asset_id = ".$issueitems[$i]['item_id']);
					}}

					$this->Common_Model->DelData("issue_accessories_items","issue_id=".$issue_id."");
					foreach((array)$this->input->post('item_name[]') as $k => $v){
						if($this->input->post('item_name['.$k.']') != ''){
							$itemdata = $this->Common_Model->FetchData("assets", "*", "asset_id = ".$this->input->post('item_name['.$k.']'));
							$datalist = array(
								'item_id'			=> $this->input->post('item_name['.$k.']'),
								'item_name'			=> $itemdata[0]['item_name'],
								'item_type'			=> 'Accessories',
								'item_quantity'		=> $this->input->post('item_quantity['.$k.']'),
								'item_price'		=> $this->input->post('item_price['.$k.']'),
								'issue_id'			=> $issue_id,
								'final_amount'		=> $this->input->post('item_total_price['.$k.']'),
								'base_amount'		=> $this->input->post('item_total_price['.$k.']'),
								//'discount_amount'	=> 0
							);
							$this->Common_Model->dbinsertid("issue_accessories_items", $datalist);
							$this->Common_Model->db_query("UPDATE assets SET item_qty = item_qty - ".$this->input->post('item_quantity['.$k.']')." WHERE asset_id = ".$this->input->post('item_name['.$k.']'));
						}
					}

				$this->session->set_flashdata('success', 'Issue Accessories successfully.' );
				redirect('employee/edit_issueaccessories/'.$issue_id);
				}else{
					$this->session->set_flashdata('error', 'Something went wrong.' );
				redirect('employee/edit_issueaccessories/'.$issue_id);
				}
			}else{
				$this->session->set_flashdata('error', validation_errors() );
				redirect('employee/edit_issueaccessories/'.$issue_id);
			}
		}

		
		$data['items'] 	= $this->Common_Model->FetchData("assets", "*", "item_type='Asset' ORDER BY item_name ASC");
		$data['rec'] 	= $this->Common_Model->FetchData("issue_accessories_client", "*", "issue_id=".$issue_id."");
		$data['recitems'] 	= $this->Common_Model->FetchData("issue_accessories_items", "*", "issue_id=".$issue_id."");
		$data['activemenu'] = 'employee';
		$data['activesubmenu'] = 'add_issueaccessories';
		$this->load->view('employee/edit_issueaccessories', $data);
	}

	function view_issueaccessories($issue_id = 0){
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));

		$data['rec'] = $this->Common_Model->FetchData("issue_accessories_client","*","issue_id=".$issue_id."");
		$data['recitems'] = $this->Common_Model->FetchData("issue_accessories_items","*","issue_id=".$issue_id."");
		$data['activemenu'] = 'employee';
		$data['activesubmenu'] = 'issue_accessories_client';
		$this->load->view('employee/view_issueaccessories', $data);
	}

	function delete_issueaccessories($issue_id = 0){
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$issueitems = $this->Common_Model->FetchData("issue_accessories_items","*","issue_id=".$issue_id."");
			if ($issueitems) { for ($i=0; $i < count($issueitems); $i++) { 
				$this->Common_Model->db_query("UPDATE assets SET item_qty = item_qty + ".$issueitems[$i]['item_quantity']." WHERE asset_id = ".$issueitems[$i]['item_id']);
			}}
		$this->Common_Model->DelData("issue_accessories_client", "issue_id = ".$issue_id);
		$this->Common_Model->DelData("issue_accessories_items", "issue_id = ".$issue_id);
		
		
		redirect($_SERVER['HTTP_REFERER']);
	}

	function get_empData(){
		$employee_code = $this->input->post("employee_code");
		$employee = $this->Common_Model->FetchData("employees","*","techno_emp_id='".$employee_code."'");
		if ($employee) {
			$html = $employee[0]['employee_id']."@#,";
			$html .= $employee[0]['employee_name']."@#,";
		}else{
			$html = '';
		}
		echo $html;exit;
	}
  
  public function employee_documents($employee_id=0){
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$data['employee'] = $employee = $this->Common_Model->FetchData("employees","*","employee_id=".$employee_id);
		if ($this->input->post("submitBtn") && $employee_id > 0) {
			
			$data_list = array('employee_id' => $employee_id, );
			if($_FILES['aadharcard']['name']!=""){
					$newfile = 'Aadhar_'.$employee[0]['techno_emp_id'].'_'.time();
					$config = array('upload_path' => "uploads/employee_documents/",'allowed_types' => 'jpg|png|jpeg|pdf','overwrite' => TRUE,'file_name' => $newfile,'max_size' => "200048000" 
					);

					$this->load->library('upload', $config);
					$this->upload->initialize($config);
					if($this->upload->do_upload("aadharcard"))
					{
						$dat = $this->upload->data();
						$data_list['aadharcard'] = $dat['file_name'];
					}else{
						$filename = '';
						$this->session->set_flashdata('error', $this->upload->display_errors());
						redirect($_SERVER['HTTP_REFERER']);
					}
				}else{}

				if($_FILES['pancard']['name']!=""){
					$newfile = 'Pan_'.$employee[0]['techno_emp_id'].'_'.time();
					$config = array('upload_path' => "uploads/employee_documents/",'allowed_types' => 'jpg|png|jpeg|pdf','overwrite' => TRUE,'file_name' => $newfile,'max_size' => "200048000" 
					);

					$this->load->library('upload', $config);
					$this->upload->initialize($config);
					if($this->upload->do_upload("pancard"))
					{
						$dat = $this->upload->data();
						$data_list['pancard'] = $dat['file_name'];
					}else{
						$filename = '';
						$this->session->set_flashdata('error', $this->upload->display_errors());
						redirect($_SERVER['HTTP_REFERER']);
					}
				}else{}

				if($_FILES['tencertficate']['name']!=""){
					$newfile = 'TenCert_'.$employee[0]['techno_emp_id'].'_'.time();
					$config = array('upload_path' => "uploads/employee_documents/",'allowed_types' => 'jpg|png|jpeg|pdf','overwrite' => TRUE,'file_name' => $newfile,'max_size' => "200048000" 
					);

					$this->load->library('upload', $config);
					$this->upload->initialize($config);
					if($this->upload->do_upload("tencertficate"))
					{
						$dat = $this->upload->data();
						$data_list['tencertficate'] = $dat['file_name'];
					}else{
						$filename = '';
						$this->session->set_flashdata('error', $this->upload->display_errors());
						redirect($_SERVER['HTTP_REFERER']);
					}
				}else{}

				if($_FILES['tenmarksheet']['name']!=""){
					$newfile = 'TenMark_'.$employee[0]['techno_emp_id'].'_'.time();
					$config = array('upload_path' => "uploads/employee_documents/",'allowed_types' => 'jpg|png|jpeg|pdf','overwrite' => TRUE,'file_name' => $newfile,'max_size' => "200048000" 
					);

					$this->load->library('upload', $config);
					$this->upload->initialize($config);
					if($this->upload->do_upload("tenmarksheet"))
					{
						$dat = $this->upload->data();
						$data_list['tenmarksheet'] = $dat['file_name'];
					}else{
						$filename = '';
						$this->session->set_flashdata('error', $this->upload->display_errors());
						redirect($_SERVER['HTTP_REFERER']);
					}
				}else{}

				if($_FILES['twocertficate']['name']!=""){
					$newfile = 'TwoCert_'.$employee[0]['techno_emp_id'].'_'.time();
					$config = array('upload_path' => "uploads/employee_documents/",'allowed_types' => 'jpg|png|jpeg|pdf','overwrite' => TRUE,'file_name' => $newfile,'max_size' => "200048000" 
					);

					$this->load->library('upload', $config);
					$this->upload->initialize($config);
					if($this->upload->do_upload("twocertficate"))
					{
						$dat = $this->upload->data();
						$data_list['twocertficate'] = $dat['file_name'];
					}else{
						$filename = '';
						$this->session->set_flashdata('error', $this->upload->display_errors());
						redirect($_SERVER['HTTP_REFERER']);
					}
				}else{}

				if($_FILES['twomarksheet']['name']!=""){
					$newfile = 'TwoMark_'.$employee[0]['techno_emp_id'].'_'.time();
					$config = array('upload_path' => "uploads/employee_documents/",'allowed_types' => 'jpg|png|jpeg|pdf','overwrite' => TRUE,'file_name' => $newfile,'max_size' => "200048000" 
					);

					$this->load->library('upload', $config);
					$this->upload->initialize($config);
					if($this->upload->do_upload("twomarksheet"))
					{
						$dat = $this->upload->data();
						$data_list['twomarksheet'] = $dat['file_name'];
					}else{
						$filename = '';
						$this->session->set_flashdata('error', $this->upload->display_errors());
						redirect($_SERVER['HTTP_REFERER']);
					}
				}else{}

				if($_FILES['gradcertficate']['name']!=""){
					$newfile = 'GradCert_'.$employee[0]['techno_emp_id'].'_'.time();
					$config = array('upload_path' => "uploads/employee_documents/",'allowed_types' => 'jpg|png|jpeg|pdf','overwrite' => TRUE,'file_name' => $newfile,'max_size' => "200048000" 
					);

					$this->load->library('upload', $config);
					$this->upload->initialize($config);
					if($this->upload->do_upload("gradcertficate"))
					{
						$dat = $this->upload->data();
						$data_list['gradcertficate'] = $dat['file_name'];
					}else{
						$filename = '';
						$this->session->set_flashdata('error', $this->upload->display_errors());
						redirect($_SERVER['HTTP_REFERER']);
					}
				}else{}

				if($_FILES['gradmarksheet']['name']!=""){
					$newfile = 'GradMark_'.$employee[0]['techno_emp_id'].'_'.time();
					$config = array('upload_path' => "uploads/employee_documents/",'allowed_types' => 'jpg|png|jpeg|pdf','overwrite' => TRUE,'file_name' => $newfile,'max_size' => "200048000" 
					);

					$this->load->library('upload', $config);
					$this->upload->initialize($config);
					if($this->upload->do_upload("gradmarksheet"))
					{
						$dat = $this->upload->data();
						$data_list['gradmarksheet'] = $dat['file_name'];
					}else{
						$filename = '';
						$this->session->set_flashdata('error', $this->upload->display_errors());
						redirect($_SERVER['HTTP_REFERER']);
					}
				}else{}

				if($_FILES['pgradcertficate']['name']!=""){
					$newfile = 'PgCert_'.$employee[0]['techno_emp_id'].'_'.time();
					$config = array('upload_path' => "uploads/employee_documents/",'allowed_types' => 'jpg|png|jpeg|pdf','overwrite' => TRUE,'file_name' => $newfile,'max_size' => "200048000" 
					);

					$this->load->library('upload', $config);
					$this->upload->initialize($config);
					if($this->upload->do_upload("pgradcertficate"))
					{
						$dat = $this->upload->data();
						$data_list['pgradcertficate'] = $dat['file_name'];
					}else{
						$filename = '';
						$this->session->set_flashdata('error', $this->upload->display_errors());
						redirect($_SERVER['HTTP_REFERER']);
					}
				}else{}

				if($_FILES['pgradmarksheet']['name']!=""){
					$newfile = 'PgMark_'.$employee[0]['techno_emp_id'].'_'.time();
					$config = array('upload_path' => "uploads/employee_documents/",'allowed_types' => 'jpg|png|jpeg|pdf','overwrite' => TRUE,'file_name' => $newfile,'max_size' => "200048000" 
					);

					$this->load->library('upload', $config);
					$this->upload->initialize($config);
					if($this->upload->do_upload("pgradmarksheet"))
					{
						$dat = $this->upload->data();
						$data_list['pgradmarksheet'] = $dat['file_name'];
					}else{
						$filename = '';
						$this->session->set_flashdata('error', $this->upload->display_errors());
						redirect($_SERVER['HTTP_REFERER']);
					}
				}else{}

				if($_FILES['offerletter']['name']!=""){
					$newfile = 'OfferL_'.$employee[0]['techno_emp_id'].'_'.time();
					$config = array('upload_path' => "uploads/employee_documents/",'allowed_types' => 'jpg|png|jpeg|pdf','overwrite' => TRUE,'file_name' => $newfile,'max_size' => "200048000" 
					);

					$this->load->library('upload', $config);
					$this->upload->initialize($config);
					if($this->upload->do_upload("offerletter"))
					{
						$dat = $this->upload->data();
						$data_list['offerletter'] = $dat['file_name'];
					}else{
						$filename = '';
						$this->session->set_flashdata('error', $this->upload->display_errors());
						redirect($_SERVER['HTTP_REFERER']);
					}
				}else{}

				if($_FILES['nocletter']['name']!=""){
					$newfile = 'Noc_'.$employee[0]['techno_emp_id'].'_'.time();
					$config = array('upload_path' => "uploads/employee_documents/",'allowed_types' => 'jpg|png|jpeg|pdf','overwrite' => TRUE,'file_name' => $newfile,'max_size' => "200048000" 
					);

					$this->load->library('upload', $config);
					$this->upload->initialize($config);
					if($this->upload->do_upload("nocletter"))
					{
						$dat = $this->upload->data();
						$data_list['nocletter'] = $dat['file_name'];
					}else{
						$filename = '';
						$this->session->set_flashdata('error', $this->upload->display_errors());
						redirect($_SERVER['HTTP_REFERER']);
					}
				}else{}

				if($_FILES['salarysleep']['name']!=""){
					$newfile = 'SSlip_'.$employee[0]['techno_emp_id'].'_'.time();
					$config = array('upload_path' => "uploads/employee_documents/",'allowed_types' => 'jpg|png|jpeg|pdf','overwrite' => TRUE,'file_name' => $newfile,'max_size' => "200048000" 
					);

					$this->load->library('upload', $config);
					$this->upload->initialize($config);
					if($this->upload->do_upload("salarysleep"))
					{
						$dat = $this->upload->data();
						$data_list['salarysleep'] = $dat['file_name'];
					}else{
						$filename = '';
						$this->session->set_flashdata('error', $this->upload->display_errors());
						redirect($_SERVER['HTTP_REFERER']);
					}
				}else{}

				if($_FILES['bankdetails']['name']!=""){
					$newfile = 'BankDetail_'.$employee[0]['techno_emp_id'].'_'.time();
					$config = array('upload_path' => "uploads/employee_documents/",'allowed_types' => 'jpg|png|jpeg|pdf','overwrite' => TRUE,'file_name' => $newfile,'max_size' => "200048000" 
					);

					$this->load->library('upload', $config);
					$this->upload->initialize($config);
					if($this->upload->do_upload("bankdetails"))
					{
						$dat = $this->upload->data();
						$data_list['bankdetails'] = $dat['file_name'];
					}else{
						$filename = '';
						$this->session->set_flashdata('error', $this->upload->display_errors());
						redirect($_SERVER['HTTP_REFERER']);
					}
				}else{}

				if($_FILES['passport']['name']!=""){
					$newfile = 'Passport_'.$employee[0]['techno_emp_id'].'_'.time();
					$config = array('upload_path' => "uploads/employee_documents/",'allowed_types' => 'jpg|png|jpeg|pdf','overwrite' => TRUE,'file_name' => $newfile,'max_size' => "200048000" 
					);

					$this->load->library('upload', $config);
					$this->upload->initialize($config);
					if($this->upload->do_upload("passport"))
					{
						$dat = $this->upload->data();
						$data_list['passport'] = $dat['file_name'];
					}else{
						$filename = '';
						$this->session->set_flashdata('error', $this->upload->display_errors());
						redirect($_SERVER['HTTP_REFERER']);
					}
				}else{}

				if($_FILES['voterid']['name']!=""){
					$newfile = 'VoterId_'.$employee[0]['techno_emp_id'].'_'.time();
					$config = array('upload_path' => "uploads/employee_documents/",'allowed_types' => 'jpg|png|jpeg|pdf','overwrite' => TRUE,'file_name' => $newfile,'max_size' => "200048000" 
					);

					$this->load->library('upload', $config);
					$this->upload->initialize($config);
					if($this->upload->do_upload("voterid"))
					{
						$dat = $this->upload->data();
						$data_list['voterid'] = $dat['file_name'];
					}else{
						$filename = '';
						$this->session->set_flashdata('error', $this->upload->display_errors());
						redirect($_SERVER['HTTP_REFERER']);
					}
				}else{}

				if($_FILES['drivinglicence']['name']!=""){
					$newfile = 'DL_'.$employee[0]['techno_emp_id'].'_'.time();
					$config = array('upload_path' => "uploads/employee_documents/",'allowed_types' => 'jpg|png|jpeg|pdf','overwrite' => TRUE,'file_name' => $newfile,'max_size' => "200048000" 
					);

					$this->load->library('upload', $config);
					$this->upload->initialize($config);
					if($this->upload->do_upload("drivinglicence"))
					{
						$dat = $this->upload->data();
						$data_list['drivinglicence'] = $dat['file_name'];
					}else{
						$filename = '';
						$this->session->set_flashdata('error', $this->upload->display_errors());
						redirect($_SERVER['HTTP_REFERER']);
					}
				}else{}

			$documents = $this->Common_Model->FetchData("employee_documents","*","employee_id=".$employee_id);
			if ($documents) {
				$this->Common_Model->update_records("employee_documents","employee_documents_id",$documents[0]['employee_documents_id'],$data_list);
				$this->session->set_flashdata('success', 'Documents Updated Successfully.');
			}else{
				$id = $this->Common_Model->dbinsertid("employee_documents",$data_list);
				$this->session->set_flashdata('success', 'Documents Added Successfully.');
			}

			redirect("employee/employee_documents/".$employee_id);
		}
		$data['rec'] = $this->Common_Model->FetchData("employee_documents","*","employee_id=".$employee_id);

		$data['activemenu'] = 'employee';
		$data['activesubmenu'] = 'listemployee';
		$this->load->view('employee/employee_documents', $data);
	}
  
  	public function deactive_employee($employee_id=0){
		$user = $this->Common_Model->db_query("SELECT COUNT(*) as num FROM users WHERE employee_tagged_id=".$employee_id);
		$this->Common_Model->db_query("UPDATE employees SET emp_status='Deactive' WHERE employee_id=".$employee_id."");
		if ($user && $user[0]['num'] == 1) {
			$this->Common_Model->db_query("UPDATE users SET userstatus='0' WHERE employee_tagged_id=".$employee_id."");
		}
		redirect($_SERVER['HTTP_REFERER']);
	}

	public function activate_employee($employee_id=0){
		$user = $this->Common_Model->db_query("SELECT COUNT(*) as num FROM users WHERE employee_tagged_id=".$employee_id);
		$this->Common_Model->db_query("UPDATE employees SET emp_status='Active' WHERE employee_id=".$employee_id."");
		if ($user && $user[0]['num'] == 1) {
			$this->Common_Model->db_query("UPDATE users SET userstatus='1' WHERE employee_tagged_id=".$employee_id."");
		}
		redirect($_SERVER['HTTP_REFERER']);

	}

	public function verify($emp_id = ''){
    	if(!$emp_id){
    	    show_404();
    	}

    	$employee = $this->Common_Model->db_query(
    	    "SELECT * FROM employees WHERE techno_emp_id='".$emp_id."' LIMIT 1"
    	);

    	if(!$employee){
    	    echo "<h2>Invalid Employee</h2>";
    	    exit;
    	}

    	$employee = $employee[0];

    	if($employee['emp_status'] != 'Active'){
    	    echo "<h2>Employee Deactivated</h2>";
    	    exit;
    	}

    	$data['employee'] = $employee;
    	$this->load->view('employee/employee_verify',$data);
}

	public function otherdetails($employee_id=0){
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$data['employee'] = $employee = $this->Common_Model->FetchData("employees","*","employee_id=".$employee_id);




		$data['state'] = $state = $this->Common_Model->FetchData("state","*","1 order by state_title ASC");
		$data['bankrec'] = $this->Common_Model->FetchData("bankandkyc","*","employee_id=".$employee_id."");
		$data['pfesirec'] = $this->Common_Model->FetchData("pfandesi","*","employee_id=".$employee_id."");
		$data['aadharrec'] = $aadharrec = $this->Common_Model->FetchData("aadhardetails","*","employee_id=".$employee_id."");
		$data['nomineerec'] = $nomineerec = $this->Common_Model->FetchData("nomineedetails","*","employee_id=".$employee_id."");
		$data['familyrec'] = $familyrec = $this->Common_Model->FetchData("familydetails","*","employee_id=".$employee_id."");
		$data['trainingrec'] = $trainingrec = $this->Common_Model->FetchData("trainingdetails","*","employee_id=".$employee_id."");
		$data['ecademicrec'] = $ecademicrec= $this->Common_Model->FetchData("ecademicdetails","*","employee_id=".$employee_id."");

		if ($aadharrec) {
			$data['adhrdist'] = $this->Common_Model->FetchData("district","*","state_id=".$aadharrec[0]['adhr_state']."");
		}else{
			$data['adhrdist'] = '';
		}

		if ($nomineerec) {
			$data['nodist'] = $this->Common_Model->FetchData("district","*","state_id=".$nomineerec[0]['no_state']."");
		}else{
			$data['nodist'] = '';
		}
		$data['activemenu'] = 'employee';
		$data['activesubmenu'] = 'listemployee';
		$this->load->view('employee/otherdetails', $data);
	}

	function uattendance(){
	    error_reporting(0);
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		if ($this->input->post("searchBtn")) {
			$data['month'] = $this->input->post("month");
			$data['year'] = $this->input->post("year");
		}else{
			$data['month'] = date('m');
			$data['year'] = date('Y');
		}

		$data['activemenu'] = 'employee';
		$data['activesubmenu'] = 'usersattendance';
		$this->load->view('employee/uattendance', $data);
	}

	function usersattendance($user_id=0,$month=0,$year=0){
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$data['user_id'] = $user_id;
		$data['month'] = $month;
		$data['year'] = $year;

		$data['activemenu'] = 'employee';
		$data['activesubmenu'] = 'usersattendance';
		$data['user'] = $this->Common_Model->FetchData("users", "*", "1 ORDER BY firstname ASC");
		$this->load->view('employee/usersattendance', $data);
	}

	function downloaduserattendance(){

			$data['user_id'] = $this->input->post('user_id');
			$data['log_date'] = $this->input->post('log_date');


		$html = $this->load->view('employee/printuserattendance', $data, TRUE);
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

	public function salaryslip(){
		$year = $_REQUEST['year'];
		$month = $_REQUEST['month'];
		$employee_id = $_REQUEST['employee_id'];
		$attr_id = $_REQUEST['attr_id'];

				$employee = $this->Common_Model->FetchData("employees","*","employee_id=".$employee_id."");
				$datee = '01-'.$month.'-'.$year.'';
				
				if ($employee) {
		

				$attribute = $this->Common_Model->FetchData("salary_transaction_attribute as a LEFT JOIN designation as c on a.designation_id=c.designation_id","*","a.employee_id=".$employee[0]['employee_id']." AND a.year='".$year."' AND a.month='".$month."' AND a.attr_id=".$attr_id."");
				

					if ($attribute) { 
						$html = '<br><br><table class="table table-condensed table-striped table-bordered" style="font-family: serif;font-size: 13px;background:;" border="1" cellpadding="5">
								<tr>
									<td style="text-transform: uppercase;text-align:center;">SALARY SLIP OF <b>'.$employee[0]['employee_name'].'</b> ['.$employee[0]['techno_emp_id'].'] FOR THE MONTH OF <b>'.date('F-Y',strtotime($datee)).'</b></td>
								</tr>
								</table><br><br>
						';
						$totsalary = 0;
						$duty = 0;

						for ($i=0; $i < count($attribute); $i++) { 
								$empSalary = $this->Common_Model->FetchData("salary_transaction_wages","*","attr_id=".$attribute[$i]['attr_id']."");

								$totsalary += $attribute[$i]['totalpaid'];
								$duty += $attribute[$i]['totalduty'];

							$html.='<br><table style="font-family: serif;font-size: 12px;background:;" class="table table-bordered table-condensed table-striped " width="100%" border="1" cellpadding="4">
								<tr style="background:#d2e6fa!important;">
									<td width="50%" colspan="2" style=""></td>
									<td width="50%" colspan="2" style=""><b>TOTAL DUTY : <span style="">'.$attribute[$i]['totalduty'].'</span></b></td>
								</tr>
								<tr>
									<td width="50%" colspan="2" style="text-align:center;"><b>EARNING</b></td>
									<td width="50%" colspan="2" style="text-align:center;"><b>DEDUCTION</b></td>
								</tr>
								<tr>
									<td width="30%">BASIC</td>
									<td width="20%" style="text-align:right;">'.$attribute[$i]['basicamt'].'</td>
									<td width="30%">EPF</td>
									<td width="20%" style="text-align:right;">'.$attribute[$i]['empepfamt'].'</td>
									</tr>
									<tr>
										<td width="30%">HRA</td>
										<td width="20%" style="text-align:right;">'.$attribute[$i]['hraamt'].'</td>
										<td width="30%">ESI</td>
										<td width="20%" style="text-align:right;">'.$attribute[$i]['empesiamt'].'</td>
									</tr>
									<tr>
										<td width="30%">CONVEYANCE ALLOWANCES</td>
										<td width="20%" style="text-align:right;">'.$attribute[$i]['conalamt'].'</td>
										<td width="30%">PT</td>
										<td width="20%" style="text-align:right;">'.$attribute[$i]['ptamt'].'</td>
									</tr>
									<tr>
										<td width="30%">SPECIAL ALLOWANCES</td>
										<td width="20%" style="text-align:right;">'.$attribute[$i]['spcalamt'].'</td>
										<td width="30%">ADMIN & OTHER CHARGES</td>
										<td width="20%" style="text-align:right;">
											'.$attribute[$i]['admnchrge'].'</td>
									</tr>
									<tr>
										<td width="30%">BONUS</td>
										<td width="20%" style="text-align:right;">'.$attribute[$i]['empbonusamt'].'</td>
										<td width="30%">OTHER DED.</td>
										<td width="20%" style="text-align:right;">
											'.$attribute[$i]['empother_dedamt'].'</td>
									</tr>
									<tr>
										<td width="30%"></td>
										<td width="20%" style="text-align:right;"></td>
										<td width="30%">FOOD</td>
										<td width="20%" style="text-align:right;">
											'.$attribute[$i]['empfoodamt'].'</td>
									</tr>
									<tr>
										<td width="30%"></td>
										<td width="20%" style="text-align:right;"></td>
										<td width="30%">UNIFORM</td>
										<td width="20%" style="text-align:right;">
											'.$attribute[$i]['empuniformamt'].'</td>
									</tr>

									<tr>
										<td width="30%"></td>
										<td width="20%" style="text-align:right;"></td>
										<td width="30%">PENALTY</td>
										<td width="20%" style="text-align:right;">'.$attribute[$i]['emppenaltyamt'].'</td>
									</tr>
									<tr>
										<td width="30%"></td>
										<td width="20%" style="text-align:right;"></td>
										<td width="30%">INSTALLMENT</td>
										<td width="20%" style="text-align:right;">'.$attribute[$i]['installamt'].'</td>
									</tr>
									
									<tr>
										<td width="30%"></td>
										<td width="20%" style="text-align:right;"></td>
										<td width="30%"></td>
										<td width="20%" style="text-align:right;"></td>
									</tr>
									
								<tr>
									<td width="30%"><b>GROSS SALARY</b></td>
									<td width="20%" style="text-align:right;"><b>'.$attribute[$i]['totalempwages'].'</b></td>
									<td width="30%"><b>TOTAL DEDUCTION</b></td>
									<td width="20%" style="text-align:right;"><b>'.$attribute[$i]['totaldeduct'].'</b></td>
								</tr>
								<tr>
									<td width="30%"></td>
									<td width="20%"></td>
									<td width="30%"><b>ALLOWANCES</b></td>
									<td width="20%" style="text-align:right;"><b>'.$attribute[$i]['allowancesamt'].'</b></td>
								</tr>
								<tr>
									<td width="30%"></td>
									<td width="20%"></td>
									<td width="30%"><b>NET SALARY</b></td>
									<td width="20%" style="text-align:right;"><b>'.$attribute[$i]['totalpaid'].'</b></td>
								</tr>
								<tr>
									<td width="100%" colspan="4" style="text-align:center;">
										<b>'.strtoupper(translateToWords(floatval($attribute[$i]['totalpaid']))).' ONLY</b> 
									</td>
								</tr>
	
								</table><br><br><br>
									';
						}
					
						$html .='<table class="table table-condensed table-bordered " style="font-weight:600px;font-size:13px;font-family:serif;" border="1" cellpadding="5">
								<tr>
									<th width="22%"></th>
									<th width="28%"><b>Duty : '.$duty.'</b></th>
									<th width="22%"><b>TOTAL SALARY</b></th>
									<th width="28%" style="text-align:right;"><b>'.number_format($totsalary,2).'</b></th>
								</tr>
						</table>';






					}else{
						$html ='<p>No records found!</p>';
					}
				
			/*}else{
				$html ='<p>No records found!</p>';
			}*/
		}else{
			$html ='<p>No records found!</p>';
		}

		error_reporting(0);
		ini_set('display_error', -1);
		
		$this->load->library('Pdf');
		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('Salary Slip');
		$pdf->SetTitle('Salary Slip');
		$pdf->SetSubject('Salary Slip');
		
		$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
		$pdf->setHeaderData($ln='glosent_logo.png', $lw=15, $ht='', $hs='', $tc=array(0,0,0), $lc=array(0,0,0));
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
		$filename = 'SalarySlip-'.$employee_code.'-'.date("YmdHis").'.pdf';
		$pdf->Output($filename, 'I');

		exit;
	}
	
	function attendancereport(){
  		error_reporting(0);
      	$this->load->helper('url');
		$data = array();
		$curSession 	= $this->session->userdata['session_name'];
		$sql 			= "1";
		$urlvars = '';

		if(isset($_REQUEST['log_date']) && $_REQUEST['log_date'] != ''){
			$sql.= " AND l.attended_date >= '".$_REQUEST['log_date']."'";
			$urlvars.= "&log_date=".$_REQUEST['log_date'];
		}
		
		if(isset($_REQUEST['to_date']) && $_REQUEST['to_date'] != ''){
			$sql.= " AND l.attended_date <= '".$_REQUEST['to_date']."'";
			$urlvars.= "&to_date=".$_REQUEST['to_date'];
		}
		
		if ($this->session->userdata("usertype") == 'Admin') {
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
             $sql .= " AND em.user_id IN (" .$eassign. ")"; 
		}
      
      	if(isset($_REQUEST['log_date']) && $_REQUEST['log_date'] != ''){
			 $sSql = "SELECT em.employee_id, em.employee_name, em.emp_mobile, l.attended_date, l.intime, l.outtime, l.inlocation, l.outlocation, l.working_hour, em.techno_emp_id, l.attendance_id, l.remarks FROM emp_attendance AS l LEFT JOIN employees AS em  ON em.employee_id = l.employee_id  WHERE $sql ORDER BY em.employee_name ASC,l.attended_date ASC";
			$record = $this->Common_Model->db_query($sSql);
			if($record){
			    $data['records']=$records = array_unique($record, SORT_REGULAR);
			}else{
			    $data['records'] = 0;
		    }
			
		}else{
			$data['records'] = 0;
		}
      
      	if(isset($_REQUEST['downloadBtn'])){
			$html = '<table border=1> <tr> <th>Sl No.</th><th>Employee Name</th><th>Mobile</th><th>Log Date</th><th>In time</th><th>In Location</th><th>Out time </th><th>Out Location</th><th>Working Hour</th><th>Remarks</th> </tr>';

            for($i=0;$i<count($records);$i++){
            	if ($records[$i]['employee_id']) { $a++;
            		
            	$html.= '<tr><td>'.($a).'</td><td>'.$records[$i]['employee_name'].'</td><td>'.$records[$i]['emp_mobile'].'</td><td>'.$records[$i]['attended_date'].'</td><td>'.$records[$i]['intime'].'</td><td>'.$records[$i]['inlocation'].'</td><td>'.$records[$i]['outtime'].'</td><td>'.$records[$i]['outlocation'].'</td><td>'.$records[$i]['working_hour'].'</td><td>'.$records[$i]['remarks'].'</td> </tr>';

            }}
            $html.= '</table>';
            $this->db->close();
			header("Content-type: application/vnd.ms-excel");
			header("Content-Disposition: attachment; filename=attendancereport".time().".xls");
			echo $html;exit;
		}
      
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
      	$data['activemenu'] = 'employee';
		$data['activesubmenu'] = 'attendancereport';
		$data['employees'] = $this->Common_Model->FetchData("employees", "*", "1 ORDER BY employee_name ASC");
		$this->load->view('employee/attendancereport', $data);
    }

    public function UpdateAttenHour(){
    	$attendance_id = $this->input->post("attendance_id");
    	$working_hour = $this->input->post("working_hour");
    	$remarks = $this->input->post("remarks");
    	$this->Common_Model->db_query("UPDATE emp_attendance SET working_hour=".$working_hour.",remarks='".$remarks."' WHERE attendance_id=".$attendance_id);
    	exit;
    }
    
    public function UpdateClockinTim(){
    	$attendance_id = $this->input->post("attendance_id");
    	$colckintime = $this->input->post("colckintime");
    	$remarks = $this->input->post("remarks");
    	$rec = $this->Common_Model->FetchData("user_attendance_log","*","attendance_log_id=".$attendance_id);

    	if($rec){
    		$intime = $rec[0]['log_date'].' '.$colckintime;
    		$datalist = array(
    			'log_datetime' => $intime,
    			'remarks' => $remarks,
    			 );
    		$this->Common_Model->update_records("user_attendance_log","attendance_log_id",$attendance_id,$datalist);
    	}
    	
    	exit;
    }

    public function UpdateClockoutTim(){
    	$attendance_id = $this->input->post("attendance_id");
    	$colckouttime = $this->input->post("colckouttime");
    	$remarks = $this->input->post("remarks");
    	$attenval = $this->input->post("attenval");
    	$rec = $this->Common_Model->FetchData("user_attendance_log","*","attendance_log_id=".$attendance_id);

    	if($rec){
    		$intime = $rec[0]['log_date'].' '.$colckouttime;
    		$datalist = array(
    			'log_datetime' => $intime,
    			'remarks' => $remarks,
    			 );
    	    if ($attenval == '2') {
    		    $this->Common_Model->update_records("user_attendance_log","attendance_log_id",$attendance_id,$datalist);
    	    }else{
    			$datalist['user_id'] = $rec[0]['user_id'];
    			$datalist['status'] = '2';
    			$datalist['log_date'] = $rec[0]['log_date'];
    			$this->Common_Model->dbinsertid("user_attendance_log",$datalist);
    		}
    	}
    	exit;
    }
    
    function emp_pdfview($employee_id=0){
			$data = array();
			$data['accessar'] = json_decode($this->session->userdata('access_menus'));

			$data['records'] = $employee = $this->Common_Model->db_query("SELECT em.employee_id, em.employee_name, em.department_id, em.emp_fathername, em.aadhar_number,em.emp_age, em.emp_bloodgrp ,em.emp_mobile, em.employee_mobile2, em.emp_amobile,em.emp_pgmobile, em.emp_permaddress, em.employee_email, em.emp_status, em.epf_status,em.view_psw, em.epf_percentile, em.emp_firstname, em.emp_lastname,em.emp_doj, em.emp_dob,em.emp_cat,em.techno_emp_id, em.emp_photo, d.department_name, d.shift_id, d.start_time, d.end_time, d.department_active, u.user_id, u.firstname, u.lastname, u.useremail, u.userphone, u.username, u.password, u.usertype, u.created_on, u.last_login_on, u.last_login_ip, u.userstatus, u.access_id, u.employee_tagged_id, e.designation_name, f.st_paymode, f.st_acno, f.st_bankname,f.st_acholdername, f.st_ifsc, f.kyc_adharno, f.kyc_panno, g.pf_uanno, g.pf_number, g.esi_number,em.emp_nickname,em.emp_gender,em.emp_mothername,em.higher_qual,g.emp_ispmjjy,g.emp_ispmsvy,em.emp_plotno,em.emp_state,em.emp_dist,em.emp_curpin,em.emp_at,em.emp_po,em.emp_tahsil,em.emp_landmark,em.emp_plotnop,em.emp_statep,em.emp_distp,em.emp_curpinp,em.emp_atp,em.emp_pop,em.emp_tahsilp,em.emp_landmarkp,em.exp_year FROM employees AS em LEFT JOIN users AS u ON em.employee_id = u.employee_tagged_id LEFT JOIN department AS d ON em.department_id = d.did LEFT JOIN designation AS e ON em.designation_id = e.designation_ID LEFT JOIN bankandkyc AS f ON em.employee_id = f.employee_id LEFT JOIN pfandesi AS g ON em.employee_id = g.employee_id WHERE em.employee_id=".$employee_id);

			$data['ecademicrec'] = $ecademicrec= $this->Common_Model->FetchData("ecademicdetails","*","employee_id=".$employee_id."");

			$data['trainingrec'] = $trainingrec = $this->Common_Model->FetchData("trainingdetails","*","employee_id=".$employee_id."");
			
			if ($employee && $employee[0]['emp_dist']) {
						$data['district'] 	= $this->Common_Model->FetchData("district", "*", "district_id=".$employee[0]['emp_dist']." ");
					}else{
						$data['district'] = '';
					}

			if ($employee && $employee[0]['emp_state']) {
						$data['state'] 	= $this->Common_Model->FetchData("state", "*", "state_id=".$employee[0]['emp_state']." ");
					}else{
						$data['state'] = '';
					}

			if ($employee && $employee[0]['emp_distp']) {
						$data['districtp'] 	= $this->Common_Model->FetchData("district", "*", "district_id=".$employee[0]['emp_distp']."");
					}else{
						$data['districtp'] = '';
					}

			if ($employee && $employee[0]['emp_statep']) {
						$data['statep'] 	= $this->Common_Model->FetchData("state", "*", "state_id=".$employee[0]['emp_statep']." ");
					}else{
						$data['statep'] = '';
					}

			error_reporting(0);
			ini_set('display_error', -1);
			$html = $this->load->view('employee/emp_pdfview', $data, TRUE);
			$this->load->library('Pdf');
			$pdf = new Pdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
			$pdf->SetCreator(PDF_CREATOR);
			$pdf->SetAuthor('AB ENTERPRISE');
			$pdf->SetTitle('AB ENTERPRISE');
			$pdf->SetSubject('AB ENTERPRISE');

			$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
			$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
			$pdf->setHeaderData($ln='glosent_logo.jpg', $lw=12, $ht='', $hs='', $tc=array(0,0,0), $lc=array(0,0,0));
			$pdf->setFooterData(array(0, 0, 0), array(0,64,328));
			$pdf->SetMargins(10, 20, 10, true);
			$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
			$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
			$pdf->SetAutoPageBreak(TRUE, 17);
			$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

			$pdf->AddPage('P', 'A4', true, true);
			$pdf->SetMargins(10, 20, 10, true);
			$pdf->SetFont('helvetica', '', 8);
			$pdf->setFontSubsetting(false);
			$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
			date_default_timezone_set("Asia/Kolkata");
			$filename = date("YmdHis").'.pdf';
			$pdf->Output($filename, 'I');

	}
	
	function updateempstatus(){
		$employee_id = $this->input->post("emp_id");
		$empstatus = $this->input->post("empstatus");

		$res = $this->Common_Model->db_query("UPDATE employees SET emp_status='".$empstatus."' WHERE employee_id=".$employee_id);
		$user = $this->Common_Model->db_query("SELECT COUNT(*) as num FROM users WHERE employee_tagged_id=".$employee_id);
		
		if ($user && $user[0]['num'] == 1 && $empstatus !='Active') {
			$this->Common_Model->db_query("UPDATE users SET userstatus='0' WHERE employee_tagged_id=".$employee_id."");
		}else if ($user && $user[0]['num'] == 1 && $empstatus =='Active') {
			$this->Common_Model->db_query("UPDATE users SET userstatus='1' WHERE employee_tagged_id=".$employee_id."");
		}

		if ($res) {
			echo 'T';
		}else{
			echo 'F';
		}
		exit;
	}

	public function empdata()
{
    $employee_id = $this->input->post('employee_id');

    $data['employee'] = [];

    if (!empty($employee_id)) {
        $data['employee'] = $this->Common_Model->FetchData(
            "employees",
            "*",
            "employee_id = ".$this->db->escape($employee_id)
        );
    }

    $data['activemenu'] = 'employee';
    $data['activesubmenu'] = 'empdata';

    $this->load->view('employee/empdata', $data);
}

public function get_employee_by_id()
{
    $techno_emp_id = trim($this->input->post('employee_id'));

    if (empty($techno_emp_id)) {
        echo json_encode([
            'status' => false,
            'message' => 'Employee ID required'
        ]);
        return;
    }

    $employee = $this->db
        ->where('techno_emp_id', $techno_emp_id)
        ->get('employees')
        ->row_array();

    if ($employee) {
        echo json_encode([
            'status' => true,
            'employee_name' => $employee['employee_name'],
            'employee_id' => $employee['employee_id']
        ]);
    } else {
        echo json_encode([
            'status' => false,
            'message' => 'Employee not found'
        ]);
    }
}

public function empIdCard($employee_id = null)
{
	if ($this->session->userdata('usertype') !== 'Admin') {
    show_error('Unauthorized Access', 403);
	}
    if (!$employee_id) {
        $this->session->set_flashdata('error', 'Employee ID missing');
        redirect('employee');
    }

    $this->db->select("
        e.*,
        d.department_name,
        des.designation_name
    ");
    $this->db->from('employees e');

    $this->db->join(
        'department d',
        'd.did = e.department_id',
        'left'
    );

    $this->db->join(
        'designation des',
        'des.designation_id = e.designation_id',
        'left'
    );

    $this->db->where('e.employee_id', $employee_id);

    $query = $this->db->get();
    $employee = $query->row_array();

    if (empty($employee)) {
        $this->session->set_flashdata('error', 'Employee not found');
        redirect('employee');
    }

    $data['employee'] = $employee;

	 $data['activemenu'] = 'employee';
    $data['activesubmenu'] = 'empdata';

    $this->load->view('employee/empIdCard', $data);
}

public function empOffer($employee_id = null)
{
	if ($this->session->userdata('usertype') !== 'Admin') {
    show_error('Unauthorized Access', 403);
	}
    if (!$employee_id) {
        show_error('Employee ID missing');
    }

    $this->db->select("
        e.*,
        d.department_name,
        des.designation_name
    ");
    $this->db->from('employees e');
    $this->db->join('department d', 'd.did = e.department_id', 'left');
    $this->db->join('designation des', 'des.designation_id = e.designation_id', 'left');
    $this->db->where('e.employee_id', $employee_id);

    $data['employee'] = $this->db->get()->row_array();

    if (empty($data['employee'])) {
        show_error('Employee not found');
    }

    $html = $this->load->view('employee/empOffer', $data, TRUE);

    $this->load->library('pdf');
    $pdf = new pdf('P', PDF_UNIT, 'A4', true, 'UTF-8', false);

    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('AB ENTERPRISES');
    $pdf->SetTitle('Offer Letter');
    $pdf->SetSubject('Offer Letter');

    $pdf->SetMargins(15, 45, 15);
	$pdf->SetAutoPageBreak(TRUE, 35);
	$pdf->SetFont('helvetica', '', 10);

	$pdf->setPrintHeader(true);
	$pdf->setPrintFooter(true);

    $pdf->AddPage();
    $pdf->writeHTML($html, true, false, true, false, '');

    $filename = 'Offer-Letter-' . date('YmdHis') . '.pdf';

    $pdf->Output($filename, 'I');

    exit;
}


public function downloadProfile($employee_id = null){
	if ($this->session->userdata('usertype') !== 'Admin') {
    show_error('Unauthorized Access', 403);
	}
	if (!$employee_id) {
        $this->session->set_flashdata('error', 'Employee ID missing');
        redirect('employee');
    }

	$data = array();
    $data['accessar'] = json_decode($this->session->userdata('access_menus'));
	$data['records'] = $this->Common_Model->FetchData("employees","*","employee_id=".$employee_id);
        
    $this->db->select('d.designation_name');
    $this->db->from('designation as d');
    $this->db->join('employees as e', 'd.designation_id = e.designation_id', 'left');
    $this->db->where('e.employee_id', $employee_id);
    $query = $this->db->get();
    $data['designation'] = $query->result_array();

    $this->db->select('d.department_name');
    $this->db->from('department as d');
    $this->db->join('employees as e', 'd.did = e.department_id', 'left');
    $this->db->where('e.employee_id', $employee_id);
    $query = $this->db->get();
    $data['department'] = $query->result_array();

	$this->db->select('*');
	$this->db->from('employee_education');
	$this->db->where('employee_id', $employee_id);
	$query = $this->db->get();
	$data['education'] = $query->result_array();

	$this->db->select('*');
	$this->db->from('bankandkyc');
	$this->db->where('employee_id', $employee_id);
	$query = $this->db->get();
	$data['bankkyc'] = $query->row_array();

	$this->db->select('*');
	$this->db->from('employee_id_details');
	$this->db->where('employee_id', $employee_id);
	$this->db->limit(1);
	$query = $this->db->get();
	$data['id_details'] = $query->row_array();

	$this->db->select('*');
	$this->db->from('employee_references');
	$this->db->where('employee_id', $employee_id);
	$query = $this->db->get();
	$data['references'] = $query->result_array();

	$this->db->select('*');
	$this->db->from('employee_experience');
	$this->db->where('employee_id', $employee_id);
	$query = $this->db->get();
	$data['experience'] = $query->result_array();

	$this->db->select('*');
	$this->db->from('employee_skills');
	$this->db->where('employee_id', $employee_id);
	$query = $this->db->get();
	$data['skills'] = $query->result_array();

    
	$html = $this->load->view('employee/downloadProfile', $data, TRUE);
    $this->load->library('pdf');
    $pdf = new pdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('AB ENTERPRISES');
    $pdf->SetTitle('Employee Profile');
    $pdf->SetSubject('Employee Profile');
 
    $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
    $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
    $pdf->setPrintHeader(true);
    $pdf->SetMargins(15, 45, 15);  
	$pdf->SetAutoPageBreak(TRUE, 35);
    $pdf->SetFont('helvetica', '', 8);
    $pdf->setFontSubsetting(false);
    
        $pages = explode('<!--PAGEBREAK-->', $html);
          foreach ($pages as $page_html) {
              $pdf->AddPage('P', 'A4', true, true);
              $pdf->writeHTML($page_html, true, false, false, false, '');
          }

    date_default_timezone_set("Asia/Kolkata");
    $filename = 'Profile-'.date("YmdHis").'.pdf';
    $pdf->Output($filename, 'I');
    

    $data['employee'] = $employee;
	$data['activemenu'] = 'employee';
    $data['activesubmenu'] = 'empdata';

    $this->load->view('employee/downloadProfile', $data);
}

public function empdocs($employee_id = null){
	if ($this->session->userdata('usertype') !== 'Admin') {
    show_error('Unauthorized Access', 403);
	}
	$this->db->select('*');
	$this->db->from('employee_education');
	$this->db->where('employee_id', $employee_id);
	$query = $this->db->get();
	$data['education'] = $query->result_array();

	$this->db->select('*');
	$this->db->from('bankandkyc');
	$this->db->where('employee_id', $employee_id);
	$query = $this->db->get();
	$data['bankkyc'] = $query->row_array();

	$this->db->select('*');
	$this->db->from('employee_id_details');
	$this->db->where('employee_id', $employee_id);
	$this->db->limit(1);
	$query = $this->db->get();
	$data['id_details'] = $query->row_array();

	$this->db->select('em.*, pe.pf_number, pe.esi_number');
	$this->db->from('employee_medical em');
	$this->db->join('pfandesi pe', 'pe.employee_id = em.employee_id', 'left');
	$this->db->where('em.employee_id', $employee_id);
	$this->db->limit(1);
	$query = $this->db->get();
	$data['other_details'] = $query->row_array();

	$data['employee_id'] = $employee_id;

	$data['employee'] = $employee;
					// echo '<pre>';print_r($data);exit;					
	$data['activemenu'] = 'employee';
    $data['activesubmenu'] = 'empdata';

    $this->load->view('employee/empdocs', $data);

}

public function mediclaim($employee_id = null)
{


	if ($this->input->method() === 'post') {

    $employee_id = intval($this->input->post('employee_id'));

    $names     = $this->input->post('family_name');
    $relations = $this->input->post('family_relation');
    $dobs      = $this->input->post('family_dob');

    $familyArray = [];

    if (!empty($names)) {
        for ($i = 0; $i < count($names); $i++) {
            if (!empty($names[$i])) {
                $familyArray[] = [
                    'name'     => $names[$i],
                    'relation' => $relations[$i],
                    'dob'      => $dobs[$i]
                ];
            }
        }
    }

    $family_json = json_encode($familyArray);

    $medical_data = [
        'sum_insured'      => $this->input->post('sum_insured'),
        'nominee_name'     => $this->input->post('nominee_name'),
        'nominee_relation' => $this->input->post('nominee_relation'),
        'nominee_dob'      => $this->input->post('nominee_dob'),
        'medical_issue'    => $this->input->post('medical_issue'),
        'medical_details'  => $this->input->post('medical_details'),
        'family_members'   => $family_json,
    ];

    $exists = $this->db->where('employee_id', $employee_id)
                       ->get('employee_medical')
                       ->row();

    if ($exists) {

        $medical_data['updated_on'] = date('Y-m-d H:i:s');

        $this->db->where('employee_id', $employee_id)
                 ->update('employee_medical', $medical_data);

    } else {

        $medical_data['employee_id'] = $employee_id;
        $medical_data['created_on']  = date('Y-m-d H:i:s');

        $this->db->insert('employee_medical', $medical_data);
    }

    redirect('employee/printMediclaim/'.$employee_id);
	}

    if (!$employee_id) {
        redirect('employee');
    }

    $employee = $this->Common_Model
        ->FetchData("employees","*","employee_id=".$employee_id);

    $data['employee'] = $employee[0];

    $designation = $this->Common_Model
        ->db_query("SELECT d.designation_name
                    FROM designation d
                    LEFT JOIN employees e 
                    ON d.designation_id = e.designation_id
                    WHERE e.employee_id = ".$employee_id);

	$medical = $this->db->where('employee_id', $employee_id)
                        ->get('employee_medical')
                        ->row_array();

    if (!$medical) {
    $medical = [];
	}

    $medical['family_members'] = json_decode($medical['family_members'], true);

    $data['medical'] = $medical;

    $data['designation'] = $designation[0];

	$data['activemenu'] = 'employee';
    $data['activesubmenu'] = 'empdata';

    $this->load->view('employee/mediclaim', $data);
}

public function printMediclaim($employee_id = null)
{
	if ($this->session->userdata('usertype') !== 'Admin') {
    show_error('Unauthorized Access', 403);
	}
    if (!$employee_id) {
        redirect('employee');
    }

	$data['records'] = $this->Common_Model->FetchData("employees","*","employee_id=".$employee_id);
        
    $this->db->select('d.designation_name');
    $this->db->from('designation as d');
    $this->db->join('employees as e', 'd.designation_id = e.designation_id', 'left');
    $this->db->where('e.employee_id', $employee_id);
    $query = $this->db->get();
    $data['designation'] = $query->result_array();

    $medical = $this->db->where('employee_id', $employee_id)
                        ->get('employee_medical')
                        ->row_array();

    if (!$medical) {
        show_error('No Mediclaim data found.');
    }

    $medical['family_members'] = json_decode($medical['family_members'], true);

    $data['medical'] = $medical;

    $html = $this->load->view('employee/printMediclaim', $data, TRUE);

    $this->load->library('pdf');

    $pdf = new pdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('AB ENTERPRISES');
    $pdf->SetTitle('Mediclaim Enrollment');
    $pdf->SetSubject('Mediclaim Enrollment');

    $pdf->SetMargins(15, 45, 15);
$pdf->SetAutoPageBreak(TRUE, 30);
$pdf->SetFont('helvetica', '', 9);

$pdf->setPrintHeader(true);
$pdf->setPrintFooter(true);

$pdf->AddPage();
$pdf->writeHTML($html, true, false, true, false, '');

    date_default_timezone_set("Asia/Kolkata");
    $filename = 'Mediclaim-' . date("YmdHis") . '.pdf';

    $pdf->Output($filename, 'I');
}

public function relieving_letter($employee_id = null)
{
	if ($this->session->userdata('usertype') !== 'Admin') {
    show_error('Unauthorized Access', 403);
	}
    if (!$employee_id) {
        redirect('employee');
    }

    $employee = $this->db->where('employee_id', $employee_id)
                         ->get('employees')
                         ->row_array();

    if (!$employee) {
        show_error('Employee not found');
    }

    $designation = $this->db->select('d.designation_name')
                            ->from('designation as d')
                            ->join('employees as e', 'd.designation_id = e.designation_id', 'left')
                            ->where('e.employee_id', $employee_id)
                            ->get()
                            ->row_array();

							$this->db->select('d.department_name');
    $this->db->from('department as d');
    $this->db->join('employees as e', 'd.did = e.department_id', 'left');
    $this->db->where('e.employee_id', $employee_id);
    $query = $this->db->get();
    $data['department'] = $query->row_array();

    $data['employee']    = $employee;
    $data['designation'] = $designation;

    $html = $this->load->view('employee/relieving_letter', $data, TRUE);

    $this->load->library('pdf');
    $pdf = new pdf(PDF_PAGE_ORIENTATION, PDF_UNIT, 'A4', true, 'UTF-8', false);

    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('AB ENTERPRISES');
    $pdf->SetTitle('Relieving Letter & Exit Clearance');
    $pdf->SetMargins(15, 45, 15);
	$pdf->SetAutoPageBreak(TRUE, 35);
	$pdf->SetFont('helvetica', '', 11);

	$pdf->setPrintHeader(true);
	$pdf->setPrintFooter(true);

    $pdf->AddPage();
$pdf->writeHTML($html, true, false, true, false, '');

    $filename = 'Relieving-Exit-' . date("YmdHis") . '.pdf';
    $pdf->Output($filename, 'I');
}

public function emp_security($employee_id = null)
{
	if ($this->session->userdata('usertype') !== 'Admin') {
    show_error('Unauthorized Access', 403);
	}
    if (!$employee_id) {
        redirect('employee');
    }
    $employee = $this->db->where('employee_id', $employee_id)
                         ->get('employees')
                         ->row_array();

    if (!$employee) {
        show_error('Employee not found');
    }

    $bank = $this->db->where('employee_id', $employee_id)
                     ->get('bankandkyc')
                     ->row_array();

    $data['employee'] = $employee;
    $data['bank']     = $bank;

    $html = $this->load->view('employee/emp_security', $data, TRUE);

    $this->load->library('pdf');

    $pdf = new pdf(PDF_PAGE_ORIENTATION, PDF_UNIT, 'A4', true, 'UTF-8', false);

    $pdf->SetCreator(PDF_CREATOR);
	$pdf->SetAuthor('AB ENTERPRISE');
	$pdf->SetTitle('Blank Cheque for Security & Acknowledgement');
	$pdf->SetSubject('Security Cheque Acknowledgement');

	$pdf->SetMargins(15, 45, 15);
	$pdf->SetAutoPageBreak(TRUE, 35);
	$pdf->SetFont('helvetica', '', 11);

	$pdf->setPrintHeader(true);
	$pdf->setPrintFooter(true);

	$pdf->AddPage();
	$pdf->writeHTML($html, true, false, true, false, '');

    date_default_timezone_set("Asia/Kolkata");
    $filename = 'emp_security_' . date("YmdHis") . '.pdf';

    $pdf->Output($filename, 'I');
}

public function joining_kit($employee_id = null)
{
	if ($this->session->userdata('usertype') !== 'Admin') {
    show_error('Unauthorized Access', 403);
	}
    if (!$employee_id) {
        show_404();
    }

    $this->db->where('employee_id', $employee_id);
    $employee = $this->db->get('employees')->row();

    if (!$employee) {
        show_404();
    }

    $data['employee'] = $employee;

    $html = $this->load->view('employee/joining_kit', $data, TRUE);

    $this->load->library('pdf');

    $pdf = new Pdf(PDF_PAGE_ORIENTATION, PDF_UNIT, 'A4', true, 'UTF-8', false);

    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('AB ENTERPRISE');
    $pdf->SetTitle('New Joining Kit');
    $pdf->SetSubject('Employee Onboarding Kit');

    $pdf->SetMargins(15, 45, 15);
	$pdf->SetAutoPageBreak(TRUE, 35);
	$pdf->SetFont('helvetica', '', 11);

	$pdf->setPrintHeader(true);
	$pdf->setPrintFooter(true);

    $pdf->AddPage();

    $pdf->writeHTML($html, true, false, true, false, '');

    date_default_timezone_set("Asia/Kolkata");
    $filename = 'Joining_Kit_' . date("YmdHis") . '.pdf';

    $pdf->Output($filename, 'I');

    exit;
}

public function emp_epf_esi($employee_id = null)
{
    if (!$employee_id) {
        redirect('employee');
    }
    if ($this->input->method() === 'post') {

    $employee_id = intval($this->input->post('employee_id'));

    $data = [

        'pf_number'        => $this->input->post('uan'),
        'basic_salary'     => $this->input->post('basic_salary'),
        'nominee1_name'     => $this->input->post('nominee1_name'),
        'nominee1_relation' => $this->input->post('nominee1_relation'),
        'nominee1_age'      => $this->input->post('nominee1_age'),
		'nominee1_share'    => $this->input->post('nominee1_share'),

        'nominee2_name'     => $this->input->post('nominee2_name'),
        'nominee2_relation' => $this->input->post('nominee2_relation'),
        'nominee2_age'      => $this->input->post('nominee2_age'),
        'nominee2_share'    => $this->input->post('nominee2_share'),

        'gross_wages'       => $this->input->post('gross_wages'),
        'esi_contribution'  => $this->input->post('esi_contribution'),

        'updated_by'        => $this->session->userdata('user_id'),
        'updated_on'        => date('Y-m-d H:i:s'),
    ];

    $exists = $this->db->where('employee_id', $employee_id)
                       ->get('pfandesi')
                       ->row();

    if ($exists) {
        $this->db->where('employee_id', $employee_id)
                 ->update('pfandesi', $data);
    } else {
        $data['employee_id'] = $employee_id;
        $this->db->insert('pfandesi', $data);
    }

    redirect('employee/print_emp_epf_esi/'.$employee_id);
	}

    $employee = $this->db->where('employee_id',$employee_id)
                         ->get('employees')
                         ->row();

    					if (!$employee) {
        					show_404();
    					}

    $designation = $this->db->select('d.designation_name')
                            ->from('designation d')
                            ->join('employees e','e.designation_id=d.designation_id')
                            ->where('e.employee_id',$employee_id)
                            ->get()
                            ->row();

	$docs = $this->db->select('bk.*')
                            ->from('bankandkyc bk')
                            ->join('employees e','e.employee_id=bk.employee_id')
                            ->where('e.employee_id',$employee_id)
                            ->get()
                            ->row();

    $pf = $this->db->where('employee_id',$employee_id)
    					    ->get('pfandesi')
    					    ->row();

    					$data['employee']    = $employee;
    					$data['designation'] = $designation;
    					$data['docs']        = $docs;
    					$data['pf']          = $pf;

    $this->load->view('employee/emp_epf_esi', $data);
	$data['activemenu'] = 'employee';
    $data['activesubmenu'] = 'empdata';
}

public function print_emp_epf_esi($employee_id = null)
{
    if (!$employee_id) {
        show_404();
    }

    $employee = $this->db->where('employee_id',$employee_id)
                         ->get('employees')
                         ->row();

    if (!$employee) {
        show_404();
    }

    $designation = $this->db->select('d.designation_name')
                            ->from('designation d')
                            ->join('employees e','e.designation_id=d.designation_id')
                            ->where('e.employee_id',$employee_id)
                            ->get()
                            ->row();

							$docs = $this->db->select('bk.*')
                            ->from('bankandkyc bk')
                            ->join('employees e','e.employee_id=bk.employee_id')
                            ->where('e.employee_id',$employee_id)
                            ->get()
                            ->row();

    $pf = $this->db->where('employee_id',$employee_id)
                   ->get('pfandesi')
                   ->row();

    $data['employee']    = $employee;
    $data['designation'] = $designation;
    $data['pf']          = $pf;
	$data['docs']        = $docs;

    $html = $this->load->view('employee/print_emp_epf_esi',$data,TRUE);

    $this->load->library('pdf');
    $pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
	$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('AB ENTERPRISE');
$pdf->SetTitle('EPF & ESI');
$pdf->SetSubject('EPF & ESI');

$pdf->SetMargins(15, 45, 15);
$pdf->SetAutoPageBreak(TRUE, 35);
$pdf->SetFont('helvetica', '', 10);

$pdf->setPrintHeader(true);
$pdf->setPrintFooter(true);

$pdf->AddPage();
$pdf->writeHTML($html, true, false, true, false, '');

    $filename = 'EPF_ESI_'.$employee_id.'_'.date('YmdHis').'.pdf';
    $pdf->Output($filename, 'I');
    exit;
}

public function target_kpis($employee_id = null)
{
    if ($this->session->userdata('usertype') !== 'Admin') {
        show_error('Unauthorized Access', 403);
    }

    if (!$employee_id) {
        show_404();
    }

    $employee = $this->db->where('employee_id', $employee_id)
                         ->get('employees')
                         ->row();

    if (!$employee) {
        show_404();
    }

    $designation = $this->db->select('d.designation_name')
                            ->from('designation d')
                            ->join('employees e','e.designation_id = d.designation_id')
                            ->where('e.employee_id', $employee_id)
                            ->get()
                            ->row();

    $target = $this->db->where('employee_id', $employee_id)
                       ->get('employee_targets')
                       ->row();

    if ($this->input->post()) {

        $data = [
            'designation'            => $this->input->post('designation'),
            'team_region'            => $this->input->post('team_region'),
            'gross_target'           => $this->input->post('gross_target'),
            'realization_target'     => $this->input->post('realization_target'),
            'new_accounts'           => $this->input->post('new_accounts'),
            'calls_per_day'          => $this->input->post('calls_per_day'),
            'field_visits_per_week'  => $this->input->post('field_visits_per_week'),
            'ptp_commitments'        => $this->input->post('ptp_commitments'),
            'recovery_rate'          => $this->input->post('recovery_rate'),
            'resolution_time'        => $this->input->post('resolution_time'),
            'custodian_compliance'   => $this->input->post('custodian_compliance'),
            'incentive_90'           => $this->input->post('incentive_90'),
            'incentive_100'          => $this->input->post('incentive_100'),
            'bonus_details'          => $this->input->post('bonus_details'),
            'daily_call_log'         => $this->input->post('daily_call_log'),
            'daily_field_visit'      => $this->input->post('daily_field_visit'),
            'weekly_status'          => $this->input->post('weekly_status'),
            'payment_format'         => $this->input->post('payment_format'),
            'updated_at'             => date('Y-m-d H:i:s')
        ];

        if ($target) {
            $this->db->where('employee_id', $employee_id)
                     ->update('employee_targets', $data);
        } else {
            $data['employee_id'] = $employee_id;
            $data['created_at']  = date('Y-m-d H:i:s');
            $this->db->insert('employee_targets', $data);
        }

        $this->session->set_flashdata('success', 'Target & KPIs Updated Successfully');
        redirect('employee/target_kpis/'.$employee_id);
    }

    $data['employee']    = $employee;
    $data['target']      = $target;
    $data['designation'] = $designation;

    $this->load->view('employee/target_kpis', $data);
}

public function searchEmployee()
{
	if ($this->session->userdata('usertype') !== 'Admin') {
    show_error('Unauthorized Access', 403);
	}
    $keyword = $this->input->post('keyword');

    $this->db->select('e.employee_id, e.employee_name, e.techno_emp_id, d.designation_name');
    $this->db->from('employees as e');
    $this->db->join('designation as d', 'd.designation_id = e.designation_id', 'left');
    $this->db->group_start();
    $this->db->like('e.employee_name', $keyword);
    $this->db->or_like('e.techno_emp_id', $keyword);
    $this->db->group_end();

    $query = $this->db->get()->result();

    $result = [];

    foreach ($query as $row) {

    $result[] = [
        'label' => $row->employee_name . ' (' . $row->techno_emp_id . ')',
        'value' => $row->employee_name . ' (' . $row->techno_emp_id . ')',
        'emp_id' => $row->employee_id,
        'techno_emp_id' => $row->techno_emp_id,
        'designation' => $row->designation_name
    ];
	}

    echo json_encode($result);
}

public function legalAction()
{
	if ($this->session->userdata('usertype') !== 'Admin') {
    show_error('Unauthorized Access', 403);
	}
    if ($this->input->post('submit')) {

        date_default_timezone_set("Asia/Kolkata");

        $emp_involved_id = $this->input->post('emp_involved_id');
        $reporter_id     = $this->input->post('reporter_id');

        if (empty($emp_involved_id)) {
            show_error("Accused Employee is required.");
        }

        if (empty($reporter_id)) {
            show_error("Reporter is required.");
        }

        $witness_array = [];
        $witness_names   = $this->input->post('witness_name');
        $witness_contact = $this->input->post('witness_contact');

        if (!empty($witness_names)) {
            foreach ($witness_names as $key => $name) {
                if (!empty($name)) {
                    $witness_array[] = [
                        'name'    => $name,
                        'contact' => $witness_contact[$key] ?? ''
                    ];
                }
            }
        }

        $witness_json = !empty($witness_array) ? json_encode($witness_array) : null;

        $evidence_array = [];
        $upload_path = "./uploads/legal/";

        if (!is_dir($upload_path)) {
            mkdir($upload_path, 0777, true);
        }

        if (!empty($_FILES['evidence_files']['name'][0])) {

            $this->load->library('upload');
            $files = $_FILES;
            $count = count($_FILES['evidence_files']['name']);

            for ($i = 0; $i < $count; $i++) {

                $_FILES['file']['name']     = $files['evidence_files']['name'][$i];
                $_FILES['file']['type']     = $files['evidence_files']['type'][$i];
                $_FILES['file']['tmp_name'] = $files['evidence_files']['tmp_name'][$i];
                $_FILES['file']['error']    = $files['evidence_files']['error'][$i];
                $_FILES['file']['size']     = $files['evidence_files']['size'][$i];

                $config = [
                    'upload_path'   => $upload_path,
                    'allowed_types' => 'jpg|jpeg|png|pdf|doc|docx',
                    'max_size'      => 5120,
                    'encrypt_name'  => TRUE
                ];

                $this->upload->initialize($config);

                if ($this->upload->do_upload('file')) {
                    $uploadData = $this->upload->data();
                    $evidence_array[] = [
                        'original_name' => $uploadData['orig_name'],
                        'stored_name'   => $uploadData['file_name'],
                        'file_path'     => 'uploads/legal/' . $uploadData['file_name']
                    ];
                }
            }
        }

        $evidence_json = !empty($evidence_array) ? json_encode($evidence_array) : null;

        $insertData = [
            'employee_id'           => $emp_involved_id,
            'reporter_id'           => $reporter_id,
            'incident_date'         => $this->input->post('incident_date'),
            'location'              => $this->input->post('location'),
            'policy_violated'       => $this->input->post('policy_violated'),
            'incident_description'  => $this->input->post('incident_description'),
            'witness_details'       => $witness_json,
            'evidence_files'        => $evidence_json,
            'recommended_action'    => $this->input->post('recommended_action'),
            'disciplinary_action'   => $this->input->post('disciplinary_action'),
            'investigation_summary' => $this->input->post('investigation_summary'),
            'findings'              => $this->input->post('findings'),
            'financial_penalty'     => $this->input->post('financial_penalty'),
            'appeal_process'        => $this->input->post('appeal_process'),
            'created_at'            => date('Y-m-d H:i:s')
        ];

        $legal_action_id = $this->Common_Model->dbinsertid('emp_legal_action', $insertData);

    }

    $this->db->select('ela.legal_action_id, ela.incident_date, ela.disciplinary_action, e.employee_name');
    $this->db->from('emp_legal_action ela');
    $this->db->join('employees e', 'e.employee_id = ela.employee_id', 'left');
    $this->db->order_by('ela.legal_action_id', 'DESC');
    $data['legal_actions'] = $this->db->get()->result();
	$data['activemenu'] = 'employee';
    $data['activesubmenu'] = 'legalAction';

    $this->load->view('employee/legalAction', $data);

}

public function printLegalAction($id)
{
	if ($this->session->userdata('usertype') !== 'Admin') {
    show_error('Unauthorized Access', 403);
	}
    $this->db->where('legal_action_id', $id);
    $record = $this->db->get('emp_legal_action')->row();

    if (!$record) {
        show_404();
    }

    $record->witnesses = !empty($record->witness_details)
        ? json_decode($record->witness_details, true)
        : [];

    $record->evidence_files = !empty($record->evidence_files)
        ? json_decode($record->evidence_files, true)
        : [];

    $this->db->select('e.employee_id, e.employee_name, d.designation_name');
    $this->db->from('employees e');
    $this->db->join('designation d', 'd.designation_id = e.designation_id', 'left');
    $this->db->where('e.employee_id', $record->employee_id);
    $record->accused = $this->db->get()->row();

    $this->db->select('e.employee_id, e.employee_name, d.designation_name');
    $this->db->from('employees e');
    $this->db->join('designation d', 'd.designation_id = e.designation_id', 'left');
    $this->db->where('e.employee_id', $record->reporter_id);
    $record->reporter = $this->db->get()->row();

    $html = $this->load->view('employee/printLegalAction', (array)$record, TRUE);

    $this->load->library('pdf');
    $pdf = new Pdf(PDF_PAGE_ORIENTATION, PDF_UNIT, 'A4', true, 'UTF-8', false);
	$pdf->SetCreator(PDF_CREATOR);
	$pdf->SetAuthor('AB ENTERPRISE');
	$pdf->SetTitle('Legal Action Report');
	$pdf->SetSubject('Employee Legal Action Report');
	
	$pdf->SetMargins(15, 45, 15);
	$pdf->SetAutoPageBreak(TRUE, 35);
	$pdf->SetFont('helvetica', '', 11);
	
	$pdf->setPrintHeader(true);
	$pdf->setPrintFooter(true);
	
	$pdf->AddPage();
	$pdf->writeHTML($html, true, false, true, false, '');

    $pdf->Output('Legal_Action_'.$id.'.pdf', 'I');
}

}