<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Salslip extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->perPage = 10;
		date_default_timezone_set('Asia/Kolkata');
	}

	public function index()
	{
		
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
}