<?php
error_reporting(0);
defined('BASEPATH') OR exit('No direct script access allowed');

class Receipts extends CI_Controller {

	public function __construct(){
		parent::__construct();
		is_logged_in();
		date_default_timezone_set("Asia/Kolkata"); 
		$this->present_date 		= date('Y-m-d');
		$this->present_time 		= date('H:i:a');
		$this->present_timefmt 		= date('h:i:a');
		$this->present_time1 		= date('H:i');
		$this->tod_date 		= date('d-M-Y');
		$this->dayltr 			= date("l"); 
	}
 
	public function index()
	{
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$data['activemenu'] = 'masters';
		$data['activesubmenu'] = 'masters';
		$this->load->view('dashboard', $data);
	}

	public function add_receipt()
	{
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));

		if($this->input->post('submitBtn')){
			$session_id = $this->session->userdata('session_id');
			$this->form_validation->set_rules('voucher_name', 'Ledger Name', 'trim|required');
			
			$this->form_validation->set_error_delimiters('<p class="has-error"><label class="control-label">', '</label></p>');
			if($this->form_validation->run()){
				$voucherno = $this->Common_Model->FetchData("receipts","*","1 ORDER BY receipt_id DESC");
						if ($voucherno) {

							$expvoucherno = explode('RV',$voucherno[0]['receipt_no']);
							$rc = (end($expvoucherno) +  1) ;
							$newvoucherno = str_pad($rc, 6, '0', STR_PAD_LEFT);
							$receipt_no = 'RV'.str_pad($newvoucherno, 6, '0', STR_PAD_LEFT);
						}else {
							$receipt_no = 'RV'.str_pad('1', 6, '0', STR_PAD_LEFT);
						}
		
				$data_list = array(
					'voucher_name'		=> $this->input->post('voucher_name'),
					'voucher_date'		=> $this->input->post('voucher_date'),
					'receipt_no'		=> $receipt_no,
					'voucher_type'		=> $this->input->post('voucher_type'),
					'credit_amount'		=> $this->input->post('amount_paid'),
					'amount_paid' 		=> $this->input->post('amount_paid'),
					'payment_mode'		=> $this->input->post('payment_mode'),
					'cheque_no'			=> $this->input->post('cheque_no'),
					'bank_id'			=> $this->input->post('bank_id'),
					'bank_name'			=> $this->input->post('bank_name'),
					'bank_branch'		=> $this->input->post('bank_branch'),
					'payment_remarks'	=> addslashes($this->input->post('payment_remarks')),
					'created_by'		=> $this->session->userdata('user_id'),
					'session_id'		=> $session_id,
					'voucher_status'	=> 'Paid',

				);

				$remarks = addslashes($this->input->post('payment_remarks'));
				$totalpaid = $this->input->post('amount_paid');
				$payment_mode = $this->input->post('payment_mode');
				$receiptname = $this->input->post('voucher_name');
				$receipt_id = $this->Common_Model->dbinsertid("receipts",$data_list);
				if ($receipt_id) {
					$this->Common_Model->db_query("UPDATE ledgers SET credit_balance = credit_balance + ".$this->input->post('amount_paid')." WHERE ledger_id='".$this->input->post('voucher_name')."' ");
				}


				if ($receipt_id) { for ($i=0; $i <count($this->input->post('itm_amount')) ; $i++) {

					$receipt_item = array(
						'invoice_id' 	=> $this->input->post('invoice_id')[$i], 
						'invoice_no' 	=> $this->input->post('invoice_no')[$i], 
						'itm_due' 		=> $this->input->post('itm_due')[$i], 
						'itm_days' 		=> $this->input->post('itm_days')[$i], 
						'itm_amount' 	=> $this->input->post('itm_amount')[$i], 
						'itm_remark' 	=> $this->input->post('itm_remark')[$i], 
						'itm_balance' 	=> $this->input->post('itm_balance')[$i],  
						'receipt_id' 	=> $receipt_id,
						 
					); 

					$this->Common_Model->db_query("UPDATE invoices SET due_amount = due_amount - ".$this->input->post('itm_amount')[$i]." WHERE invoice_id='".$this->input->post('invoice_id')[$i]."' ");
					
					$this->Common_Model->dbinsertid("receipts_items",$receipt_item);

					
					
				}}

				$bankdata = $this->Common_Model->FetchData("banks", "*", "bank_id = '".$this->input->post('bank_id')."'");

				if($payment_mode == 'Cash'){
						$cash = $this->Common_Model->FetchData("cash_log", "*", "1 ORDER BY id DESC LIMIT 1");
						if($cash){
							$balance = $cash[0]['cash_balance'] + $totalpaid;
						}else{
							$balance = 0;
						}
						$datalist1 = array(
										"mode"				=> 'Credit',
										"amount" 			=> $totalpaid,
										"cash_balance"		=> $balance,
										"date" 				=> date("Y-m-d"),
										"created_by" 		=> $this->session->userdata("user_id"),
										"remarks" 			=> $remarks,
										"receipt_id" 		=> $receipt_id,
										"voucher_id" 		=> 0
									);
						$this->Common_Model->dbinsertid("cash_log", $datalist1);

					}
					if($payment_mode == 'Cheque'){
						if($bankdata){
							$bankbal = $bankdata[0]['balance'] + $totalpaid;
							$ttype = 'Credit';
							
							$bankdata = array(
										"bank_id"			=> $this->input->post('bank_id'),
										"transaction_type"	=> $ttype,
										"transaction_mode"	=> $payment_mode,
										"transaction_amount"=> $totalpaid,
										"balance_amount"	=> $bankbal,
										"transaction_date" 	=> date("Y-m-d"),
										"remarks" 			=> addslashes($remarks),
										"receipt_id" 		=> $receipt_id,
										"voucher_id" 		=> 0
									);
							$this->Common_Model->dbinsertid("bank_book", $bankdata);
							$this->Common_Model->db_query("UPDATE banks SET balance = ".$bankbal." WHERE bank_id = ".$this->input->post('bank_id'));
						}
					}

					if($payment_mode == 'Net Banking'){
						if($bankdata){
							$bankbal = $bankdata[0]['balance'] + $totalpaid;
							$ttype = 'Credit';
						
							$bankdata = array(
										"bank_id"		=> $this->input->post('bank_id'),
										"transaction_type"	=> $ttype,
										"transaction_mode"	=> $payment_mode,
										"transaction_amount"	=> $totalpaid,
										"balance_amount"	=> $bankbal,
										"transaction_date" 	=> date("Y-m-d"),
										"remarks" 			=> addslashes($remarks),
										"receipt_id" 		=> $receipt_id,
										"voucher_id" 		=> 0
									);
							$this->Common_Model->dbinsertid("bank_book", $bankdata);
							$this->Common_Model->db_query("UPDATE banks SET balance = ".$bankbal." WHERE bank_id = ".$this->input->post('bank_id'));
						}
					}

				$this->session->set_flashdata('success', 'Receipt Added successfully.' );
				redirect('receipts/add_receipt');
			}else{
				$this->session->set_flashdata('error', validation_errors());
				redirect('receipts/add_receipt');
			}
		}

		$data['ledgers'] = $this->Common_Model->FetchData("ledgers as a LEFT JOIN under_group as b on a.acount_group=b.group_id","*","b.category='Debit' ORDER BY ledger_name ASC");

		//$data['ledger'] = $this->Common_Model->FetchData("ledgers as a LEFT JOIN under_group as b on a.acount_group=b.group_id","*","b.category='Payment' ORDER BY ledger_name ASC");
		$data['banks'] = $this->Common_Model->FetchData("banks", "*", "1 ORDER BY bank_name ASC");
		$data['activemenu'] = 'receipts';
		$data['activesubmenu'] = 'add_receipt';
		$this->load->view('receipts/add_receipt', $data);
	}

	public function list_receipt()
	{
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$data['per_page'] = $per_page = isset($_REQUEST['per_page']) ? $_REQUEST['per_page'] : 30;
		$data['page'] = $page = isset($_REQUEST['page']) ? $_REQUEST['page'] : '1';
		$this->load->helper('url');
		$currentURL = current_url();
		$sql = "1";
		
		$urlvars = '';


		if(isset($_REQUEST['voucher_date_from']) && isset($_REQUEST['voucher_date_to']) && $_REQUEST['voucher_date_from'] == $_REQUEST['voucher_date_to']){
			$sql.= " AND DATE(a.voucher_date) = '".$_REQUEST['voucher_date_from']."'";
			$urlvars.= "&voucher_date_from=".$_REQUEST['voucher_date_from']."&voucher_date_to=".$_REQUEST['voucher_date_to'];
		}else{
			if(isset($_REQUEST['voucher_date_from']) && $_REQUEST['voucher_date_from'] != ''){
				$sql.= " AND DATE(a.voucher_date) >= '".$_REQUEST['voucher_date_from']."'";
				$urlvars.= "&voucher_date_from=".$_REQUEST['voucher_date_from'];
			}
			
			if(isset($_REQUEST['voucher_date_to']) && $_REQUEST['voucher_date_to'] != ''){
				$sql.= " AND DATE(a.voucher_date) <= '".$_REQUEST['voucher_date_to']."'";
				$urlvars.= "&voucher_date_to=".$_REQUEST['voucher_date_to'];
			}
		}

		if(isset($_REQUEST['voucher_name']) && $_REQUEST['voucher_name'] != ''){
			$sql.= " AND a.voucher_name = ".$_REQUEST['voucher_name']."";
			$urlvars.= "&voucher_name=".$_REQUEST['voucher_name'];
		}
		
		if(isset($_REQUEST['receipt_no']) && $_REQUEST['receipt_no'] != ''){
			$sql.= " AND a.receipt_no LIKE '%".$_REQUEST['receipt_no']."%'";
			$urlvars.= "&receipt_no=".$_REQUEST['receipt_no'];
		}$sql.= " ORDER BY a.voucher_date DESC ";

		$totalrecords = $this->Common_Model->FetchRows("receipts as a LEFT JOIN ledgers AS b ON a.voucher_name=b.ledger_id", "*", "$sql");
		$sSql = "SELECT * FROM receipts as a LEFT JOIN ledgers AS b ON a.voucher_name=b.ledger_id WHERE $sql";
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

		//$data['records'] = $this->Common_Model->FetchData("receipts as a LEFT JOIN ledgers AS b ON a.voucher_name=b.ledger_id","*","1 ORDER BY a.receipt_id DESC");

		$data['ledgers'] = $this->Common_Model->FetchData("ledgers as a LEFT JOIN under_group as b on a.acount_group=b.group_id","*","b.category='Debit' ORDER BY ledger_name ASC");
		$data['activemenu'] = 'receipts';
		$data['activesubmenu'] = 'list_receipt';
		$this->load->view('receipts/list_receipt', $data);
	}


	public function cancel_receipt($receipt_id = 0){
		$data = array();
		error_reporting(0);
		ini_set('display_error', -1);
		if ($receipt_id) {
			$items = $this->Common_Model->FetchData("receipts_items","*","receipt_id=".$receipt_id." order by receipt_items_id ASC");
			$receipt = $this->Common_Model->FetchData("receipts","*","receipt_id=".$receipt_id."");

				
			for ($i=0; $i <count($items) ; $i++) { 

				$this->Common_Model->db_query("UPDATE invoices SET due_amount = due_amount + ".$items[$i]['itm_amount']." WHERE invoice_id='".$items[$i]['invoice_id']."' ");

				 
			}
			$this->Common_Model->db_query("UPDATE receipts SET voucher_status = 'Cancelled' ,cancel_date = '".date('Y-m-d H:i:s')."',cancel_by = '".$this->session->userdata("user_id")."' WHERE receipt_id = '".$receipt_id."' ");

			$this->Common_Model->db_query("UPDATE ledgers SET credit_balance = credit_balance - ".$receipt[0]['credit_amount']." WHERE ledger_id='".$receipt[0]['voucher_name']."' ");



				$remarks = 'Cancelled Receipt';
				$payment_mode = $receipt[0]['payment_mode'];
				$totalpaid = $receipt[0]['amount_paid'];
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
										"receipt_id" 		=> $receipt_id,
										"voucher_id" 		=> 0
									);
						$this->Common_Model->dbinsertid("cash_log", $datalist1);

					}
					if($payment_mode == 'Cheque'){
						$bankdata = $this->Common_Model->FetchData("banks", "*", "bank_id = '".$receipt[0]['bank_id']."'");
						if($bankdata){
							$bankbal = $bankdata[0]['balance'] - $totalpaid;
							$ttype = 'Debit';
							
							$bankdata = array(
										"bank_id"			=> $receipt[0]['bank_id'],
										"transaction_type"	=> $ttype,
										"transaction_mode"	=> $payment_mode,
										"transaction_amount"=> $totalpaid,
										"balance_amount"	=> $bankbal,
										"transaction_date" 	=> date("Y-m-d"),
										"remarks" 			=> addslashes($remarks),
										"receipt_id" 		=> $receipt_id,
										"voucher_id" 		=> 0
									);
							$this->Common_Model->dbinsertid("bank_book", $bankdata);
							$this->Common_Model->db_query("UPDATE banks SET balance = ".$bankbal." WHERE bank_id = ".$receipt[0]['bank_id']);
						}
					}

					if($payment_mode == 'Net Banking'){
						$bankdata = $this->Common_Model->FetchData("banks", "*", "bank_id = '".$receipt[0]['bank_id']."'");
						if($bankdata){
							$bankbal = $bankdata[0]['balance'] - $totalpaid;
							$ttype = 'Debit';
						
							$bankdata = array(
										"bank_id"		=> $receipt[0]['bank_id'],
										"transaction_type"	=> $ttype,
										"transaction_mode"	=> $payment_mode,
										"transaction_amount"	=> $totalpaid,
										"balance_amount"	=> $bankbal,
										"transaction_date" 	=> date("Y-m-d"),
										"remarks" 			=> addslashes($remarks),
										"receipt_id" 		=> $receipt_id,
										"voucher_id" 		=> 0
									);
							$this->Common_Model->dbinsertid("bank_book", $bankdata);
							$this->Common_Model->db_query("UPDATE banks SET balance = ".$bankbal." WHERE bank_id = ".$receipt[0]['bank_id']);
						}
					}


			$this->session->set_flashdata('success', 'Cancel successfully.' );

			redirect('receipts/list_receipt/'.$receipt_id.'',$data);
			//print_r($items);exit;
		}
	}

	public function print_receipt($receipt_id=0){	
		error_reporting(0);

		$data['records'] = $records = $this->Common_Model->FetchData("receipts as a LEFT JOIN ledgers AS b ON a.voucher_name=b.ledger_id","*","receipt_id = '".$receipt_id."' ");
		$data['ledger'] = $this->Common_Model->FetchData("ledgers","*","ledger_id=".$records[0]['ledger_id']." ");
		

		$data['items'] = $this->Common_Model->FetchData("receipts_items as a LEFT JOIN invoices as b on a.invoice_id=b.invoice_id","*","a.receipt_id = '".$receipt_id."' ");

			
		$this->load->library('Pdf');	
		$pdf = new Pdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		$html = $this->load->view('receipts/print_receipt', $data, TRUE);
		
		
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('TFMS');
		$pdf->SetTitle('Receipt Voucher');
		$pdf->SetSubject('Receipt Voucher');
		$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
		$pdf->setHeaderData($ln='', $lw=0, $ht='', $hs='', $tc=array(0,0,0), $lc=array(0,0,0));
		$pdf->SetMargins(5, 15, 5, true);
		$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
		$pdf->SetAutoPageBreak(TRUE, 17);

		// set image scale factor
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
		$pdf->AddPage('L', 'A4', true, true);
		$pdf->SetMargins(5, 15, 5, true);
		$pdf->SetFont('helvetica', '', 8);
		$pdf->setFontSubsetting(false);
		$pdf->writeHTML($html, true, false, false, false, '');
		date_default_timezone_set("Asia/Kolkata");
		$filename = 'ReceiptVoucher_'.date("YmdHis").'.pdf';
		$pdf->Output($filename);
		
	}

	public function delete_receipt($receipt_id = 0){
		$data = array();
		error_reporting(0);
		ini_set('display_error', -1);
		if ($receipt_id) {
			$items = $this->Common_Model->FetchData("receipts_items","*","receipt_id=".$receipt_id." order by receipt_items_id ASC");
			$receipt = $this->Common_Model->FetchData("receipts","*","receipt_id=".$receipt_id."");

			if ($receipt[0]['voucher_status'] == 'Paid') {
						
				for ($i=0; $i <count($items) ; $i++) { 

				$this->Common_Model->db_query("UPDATE invoices SET due_amount = due_amount + ".$items[$i]['itm_amount']." WHERE invoice_id='".$items[$i]['invoice_id']."' ");

				 
				}

				$this->Common_Model->db_query("UPDATE ledgers SET credit_balance = credit_balance - ".$receipt[0]['credit_amount']." WHERE ledger_id='".$receipt[0]['voucher_name']."' ");

				$remarks = 'Deleted Receipt';
				$payment_mode = $receipt[0]['payment_mode'];
				$totalpaid = $receipt[0]['amount_paid'];
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
										"receipt_id" 		=> $receipt_id,
										"voucher_id" 		=> 0
									);
						$this->Common_Model->dbinsertid("cash_log", $datalist1);

					}
					if($payment_mode == 'Cheque'){
						$bankdata = $this->Common_Model->FetchData("banks", "*", "bank_id = '".$receipt[0]['bank_id']."'");
						if($bankdata){
							$bankbal = $bankdata[0]['balance'] - $totalpaid;
							$ttype = 'Debit';
							
							$bankdata = array(
										"bank_id"			=> $receipt[0]['bank_id'],
										"transaction_type"	=> $ttype,
										"transaction_mode"	=> $payment_mode,
										"transaction_amount"=> $totalpaid,
										"balance_amount"	=> $bankbal,
										"transaction_date" 	=> date("Y-m-d"),
										"remarks" 			=> addslashes($remarks),
										"receipt_id" 		=> $receipt_id,
										"voucher_id" 		=> 0
									);
							$this->Common_Model->dbinsertid("bank_book", $bankdata);
							$this->Common_Model->db_query("UPDATE banks SET balance = ".$bankbal." WHERE bank_id = ".$receipt[0]['bank_id']);
						}
					}

					if($payment_mode == 'Net Banking'){
						$bankdata = $this->Common_Model->FetchData("banks", "*", "bank_id = '".$receipt[0]['bank_id']."'");
						if($bankdata){
							$bankbal = $bankdata[0]['balance'] - $totalpaid;
							$ttype = 'Debit';
						
							$bankdata = array(
										"bank_id"		=> $receipt[0]['bank_id'],
										"transaction_type"	=> $ttype,
										"transaction_mode"	=> $payment_mode,
										"transaction_amount"	=> $totalpaid,
										"balance_amount"	=> $bankbal,
										"transaction_date" 	=> date("Y-m-d"),
										"remarks" 			=> addslashes($remarks),
										"receipt_id" 		=> $receipt_id,
										"voucher_id" 		=> 0
									);
							$this->Common_Model->dbinsertid("bank_book", $bankdata);
							$this->Common_Model->db_query("UPDATE banks SET balance = ".$bankbal." WHERE bank_id = ".$receipt[0]['bank_id']);
						}
					}
			}
			$this->Common_Model->DelData("receipts","receipt_id=".$receipt_id."");
			$this->Common_Model->DelData("receipts_items","receipt_id=".$receipt_id."");

			$this->session->set_flashdata('success', 'Deleted successfully.' );

			redirect('receipts/list_receipt/'.$receipt_id.'',$data);
			//print_r($items);exit;
		}
	}

	public function get_ledgerDetails(){
		$ledger = $this->Common_Model->FetchData("ledgers","*","ledger_id=".$this->input->post('voucher_name')."");

		$invoice = $this->Common_Model->FetchData("invoices","*","invoice_name=".$this->input->post('voucher_name')." AND due_amount > 0 AND invoice_status='Submitted' order by invoice_date DESC");
		$html2 = '';
		if ($invoice) { for ($i=0; $i < count($invoice) ; $i++) { 
			$html2 .='
					<tr class="product_tr" data-id="'.$invoice[$i]['invoice_id'].'" style="border: hidden!important;">
                        <td><span  style="margin-left: 5px;">'.$invoice[$i]['invoice_no'].'</span></td>
                        <td class="text-center" class="">'.$invoice[$i]['grand_total'].'</td>
                        <td class="text-center">'.$invoice[$i]['invoice_date'].'</td>
                        <td class="text-center">'.$invoice[$i]['invoice_date'].'</td>
                        <td class="text-center">';
                         $strt = strtotime($invoice[$i]['invoice_date']); $endd = strtotime(date('Y-m-d')); $da_between = ceil(abs($endd - $strt) / 86400);
            $html2 .=''.$da_between.'</td>
                        <td class="text-center dueamt">'.$invoice[$i]['due_amount'].'</td>
                        <td class="text-center"></td>
                        
                      </tr>
			';
			
		}}

		$html = $ledger[0]['ledger_name'].',';
		$html .= $ledger[0]['phone_no'].',';
		$html .= $ledger[0]['mobile'].',';
		$html .= $ledger[0]['ledger_type'].',';
		$html .= $html2.',';

		echo $html;
	}

	public function get_bill_details(){
		$invoice_id = $this->input->post("invoice_id");
		$invoice = $this->Common_Model->FetchData("invoices","*","invoice_id=".$invoice_id."");

		$start = strtotime($invoice[0]['invoice_date']); $end = strtotime(date('Y-m-d')); $days_between = ceil(abs($end - $start) / 86400);

		$html = $invoice[0]['invoice_no'].',';
		$html .= $invoice[0]['due_amount'].',';
		$html .= $invoice[0]['invoice_date'].',';
		$html .= $days_between.',';
		$html .= $invoice[0]['invoice_id'].',';

		echo $html;
	}
}