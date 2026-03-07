<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->perPage = 10;
		date_default_timezone_set('Asia/Kolkata');
	}

	public function index()
	{
		
	}

	public function viewprofile(){
		
		$employee_id = $_REQUEST['employee_id'];
		
			$data = array();
			$data['accessar'] = json_decode($this->session->userdata('access_menus'));

			$data['records'] = $employee = $this->Common_Model->db_query("SELECT em.employee_id, em.employee_name, em.department_id, em.emp_fathername, em.aadhar_number, em.emp_mobile, em.employee_mobile2, em.emp_permaddress, em.employee_email, em.emp_status, em.epf_status,em.view_psw, em.epf_percentile, em.emp_firstname, em.emp_lastname,em.emp_doj, em.emp_dob,em.emp_cat,em.techno_emp_id, em.emp_photo, d.department_name, d.shift_id, d.start_time, d.end_time, d.department_active, u.user_id, u.firstname, u.lastname, u.useremail, u.userphone, u.username, u.password, u.usertype, u.created_on, u.last_login_on, u.last_login_ip, u.userstatus, u.access_id, u.employee_tagged_id, e.designation_name, f.st_paymode, f.st_acno, f.st_bankname,f.st_acholdername, f.st_ifsc, f.kyc_adharno, f.kyc_panno, g.pf_uanno, g.pf_number, g.esi_number,em.emp_nickname,em.emp_gender,em.emp_mothername,em.higher_qual,g.emp_ispmjjy,g.emp_ispmsvy,em.emp_plotno,em.emp_state,em.emp_dist,em.emp_curpin,em.emp_at,em.emp_po,em.emp_tahsil,em.emp_landmark,em.emp_plotnop,em.emp_statep,em.emp_distp,em.emp_curpinp,em.emp_atp,em.emp_pop,em.emp_tahsilp,em.emp_landmarkp,em.exp_year FROM employees AS em LEFT JOIN users AS u ON em.employee_id = u.employee_tagged_id LEFT JOIN department AS d ON em.department_id = d.did LEFT JOIN designation AS e ON em.designation_id = e.designation_ID LEFT JOIN bankandkyc AS f ON em.employee_id = f.employee_id LEFT JOIN pfandesi AS g ON em.employee_id = g.employee_id WHERE em.employee_id=".$employee_id);

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
			$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
			$pdf->SetCreator(PDF_CREATOR);
			$pdf->SetAuthor('GLOSENT');
			$pdf->SetTitle('GLOSENT');
			$pdf->SetSubject('GLOSENT');

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

		exit;
	}
}