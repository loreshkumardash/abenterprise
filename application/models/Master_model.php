<?php
error_reporting(0);
class Master_model extends CI_Model {
    function __construct(){
        parent::__construct();
    }
	
	
	function do_upload($filename,$config){
		$config['max_size'] = '10000';
		$config['max_width']  = '1024';
		$config['max_height']  = '768';
		$this->load->library('upload', $config);
		  //$this->upload->initialize($config);
		if ( ! $this->upload->do_upload($filename)){
			return $error = array('error' => $this->upload->display_errors());
		}else{
			return $data = array('upload_data' => $this->upload->data());
		}
	}
	public function testimonial_data($emp_uid,$sql)
	{
	if($sql!='')
	{
		$sq="SELECT b.rating_num,b.rating_total, b.testimonial, e.* FROM apex_testimonial b INNER JOIN apex_enquiry e ON b.client_id = e.enquiry_id AND e.emp_uid='$emp_uid'".$sql;
	}
	else
	{
		$sq="";
		
	}
		
		$kw=$this->db->query($sq);
		$kow = $kw->result_array();
		if(!empty($kow)){
			//print_r($kow);
			foreach($kow as $vl)
			{
				$dos[]=$vl;
			}
			return $dos;
		}else{
			return 0;
		}	
	}
	
	function generate_random_code($length = 10,$suffix='') {
		$alphabets = range('A','Z');
		$numbers = range('0','9');
		$final_array = array_merge($alphabets,$numbers);
			 
		$password = '';
		
		while($length--) {
		  $key = array_rand($final_array);
		  $password .= $final_array[$key];
		}
		
		return strtoupper($suffix).$password;
	}
	public function countRows($tbl,$cond="")
	{
		$this->db->select('COUNT(*) as num');
		$this->db->from($tbl);
		if($cond != ""){
			$this->db->where($cond);
		}	
		$query = $this->db->get();
		$row = $query->row();
		return $row->num;
	}
	public function FetchRows($tbl,$val="*",$cond="")
	{
		if($cond!="")
		{
			$sq="SELECT $val FROM $tbl WHERE $cond";
		}
		else
		{
			$sq="SELECT $val FROM $tbl";
		}
		$res=$this->db->query($sq);
		return $res->num_rows(); 		
	}
	public function FetchData($tbl,$val="*",$cond="")
	{
		if($cond!="")
		{
			$sq="SELECT $val FROM $tbl WHERE $cond";
		}
		else
		{
			$sq="SELECT $val FROM $tbl";
		}
		
		$kw=$this->db->query($sq);
		$kow = $kw->result_array();
		if(!empty($kow)){
			if(($val=="*") || (strpos($val,",")>0) || (strpos($val,"distinct")>0))
			{
				//print_r($kow);
				foreach($kow as $vl)
				{
					$dos[]=$vl;
				}
				return $dos;
			}
			else
			{
				
				foreach($kow as $vl)
				{
//				if(strpos($val,"distinct")>0){
//					str_replace("distinct ","",$val);
//				}
				return $vl["$val"];
				}
			}
		}else{
			return 0;
		}	
	}
	public function GetCountryParam(){
		$countryparam = $this->FetchDistinctSingleData("apex_param_stages","country");
		return $countryparam;
	}
	public function FetchDistinctSingleData($tbl,$col,$cond="")
	{
		if($cond!="")
		{
			$sq="SELECT distinct $col FROM $tbl WHERE $cond";
		}
		else
		{
			$sq="SELECT distinct $col FROM $tbl";
		}
		$kw=$this->db->query($sq);
		$kow = $kw->result_array();
		if(!empty($kow)){
			foreach($kow as $vl)
			{
				$dos[]=$vl;
			}
			return $dos;
		}else{
			return 0;
		}	
	}

	public function FetchPageaalljoinData($qur,$params = array()){
		//$sq="SELECT $val FROM $tbl1 INNER JOIN $tbl2 INNER JOIN $tbl3 INNER JOIN $tbl4 ON $cond";
		$sq=$qur;
		
		if(array_key_exists("start",$params) && array_key_exists("limit",$params))
		{
		$sq .= " LIMIT ".$params['start'].",".$params['limit'];
		}
		elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params))
		{
		$sq .= " LIMIT ".$params['limit'];
		}
		
		$kw=$this->db->query($sq);
		$kow = $kw->result_array();
		if(!empty($kow))
		{
		//print_r($kow);
		foreach($kow as $vl)
		{
		$dos[]=$vl;
		}
		return $dos;
		}
		else
		{
		return 0;
		} 
	}	
	public function FetchPaginationRows($tbl,$val="*",$cond="",$params = array()){
		if($cond!="")
		{
			$sq="SELECT $val FROM $tbl WHERE $cond";
		}
		else
		{
			$sq="SELECT $val FROM $tbl";
		}
        if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
			$sq .= " LIMIT ".$params['start'].",".$params['limit'];
        }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
			$sq .= " LIMIT ".$params['limit'];
        }
		$res=$this->db->query($sq);
		return $res->num_rows(); 		
	}
	public function FetchPaginationData($tbl,$val="*",$cond="",$params = array())
	{
		if($cond!="")
		{
			$sq="SELECT $val FROM $tbl WHERE $cond";
		}
		else
		{
			$sq="SELECT $val FROM $tbl";
		}
        if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
			$sq .= " LIMIT ".$params['start'].",".$params['limit'];
        }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
			$sq .= " LIMIT ".$params['limit'];
        }
		$kw=$this->db->query($sq);
		$kow = $kw->result_array();
		if(!empty($kow)){
			if(($val=="*") || (strpos($val,",")>0))
			{
				//print_r($kow);
				foreach($kow as $vl)
				{
					$dos[]=$vl;
				}
				return $dos;
			}
			else
			{
				
				foreach($kow as $vl)
				{
				return $vl["$val"];
				}
			}
		}else{
			return 0;
		}	
	}
	public function FetchUnionPaginationRows($tbl1,$tbl2,$val1="*",$val2="*",$cond1="",$cond2="",$params = array()){
		if($cond1!="" || $cond2!="")
		{
			$sq1="SELECT $val1 FROM $tbl1 WHERE $cond1";
			$sq2="SELECT $val2 FROM $tbl2 WHERE $cond2";
		}
		else
		{
			$sq1="SELECT $val1 FROM $tbl1";
			$sq2="SELECT $val2 FROM $tbl2";
			
		}
		$sq = "select * from (".$sq1.") first union all select * from (".$sq2.") last";
        if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
			$sq .= " LIMIT ".$params['start'].",".$params['limit'];
        }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
			$sq .= " LIMIT ".$params['limit'];
        }
		$res=$this->db->query($sq);
		return $res->num_rows(); 		
	}
	public function FetchUnionPaginationData($tbl1,$tbl2,$val1="*",$val2="*",$cond1="",$cond2="",$params = array())
	{
		if($cond1!="" || $cond2!="")
		{
			$sq1="SELECT $val1 FROM $tbl1 WHERE $cond1";
			$sq2="SELECT $val2 FROM $tbl2 WHERE $cond2";
		}
		else
		{
			$sq1="SELECT $val1 FROM $tbl1";
			$sq2="SELECT $val2 FROM $tbl2";
		}
		$sq = "select * from (".$sq1.") first union all select * from (".$sq2.") last";
        if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
			$sq .= " LIMIT ".$params['start'].",".$params['limit'];
        }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
			$sq .= " LIMIT ".$params['limit'];
        }
		$kw=$this->db->query($sq);
		$kow = $kw->result_array();
		if(!empty($kow)){
			if(($val1=="*") || ($val2=="*") || (strpos($val1,",")>0) || (strpos($val2,",")>0))
			{
				//print_r($kow);
				foreach($kow as $vl)
				{
					$dos[]=$vl;
				}
				return $dos;
			}
			else
			{
				
				foreach($kow as $vl)
				{
				return $vl["$val"];
				}
			}
		}else{
			return 0;
		}	
	}
	public function FetchUnionData($tbl1,$tbl2,$val1="*",$val2="*",$cond1="",$cond2="")
	{
		if($cond1!="" || $cond2!="")
		{
			$sq1="SELECT $val1 FROM $tbl1 WHERE $cond1";
			$sq2="SELECT $val2 FROM $tbl2 WHERE $cond2";
		}
		else
		{
			$sq1="SELECT $val1 FROM $tbl1";
			$sq2="SELECT $val2 FROM $tbl2";
		}
		$sq = "select * from (".$sq1.") first union all select * from (".$sq2.") last";
		$kw=$this->db->query($sq);
		$kow = $kw->result_array();
		if(!empty($kow)){
			if(($val1=="*") || ($val2=="*") || (strpos($val1,",")>0) || (strpos($val2,",")>0))
			{
				//print_r($kow);
				foreach($kow as $vl)
				{
					$dos[]=$vl;
				}
				return $dos;
			}
			else
			{
				
				foreach($kow as $vl)
				{
				return $vl["$val"];
				}
			}
		}else{
			return 0;
		}	
	}
	public function FetchjoinData($tbl1,$tbl2,$val,$cond)
	{
		$sq="SELECT $val FROM $tbl1 INNER JOIN $tbl2 ON $cond";
		$kw=$this->db->query($sq);
		$kow = $kw->result_array();
		if(!empty($kow)){
			//print_r($kow);
			foreach($kow as $vl)
			{
				$dos[]=$vl;
			}
			return $dos;
		}else{
			return 0;
		}	
	}
	public function FetchleftjoinData($tbl1,$tbl2,$val,$cond)
	{
		$sq="SELECT $val FROM $tbl1 LEFT JOIN $tbl2 ON $cond";
		$kw=$this->db->query($sq);
		$kow = $kw->result_array();
		if(!empty($kow)){
			//print_r($kow);
			foreach($kow as $vl)
			{
				$dos[]=$vl;
			}
			return $dos;
		}else{
			return 0;
		}	
	}
	public function FetchmultijoinData($tbl1,$tbl2,$tbl3,$val,$cond1,$cond2)
	{
		$sq="SELECT $val FROM $tbl1 INNER JOIN $tbl2 ON $cond1 INNER JOIN $tbl3 ON $cond2";
		$kw=$this->db->query($sq);
		$kow = $kw->result_array();
		if(!empty($kow)){
			//print_r($kow);
			foreach($kow as $vl)
			{
				$dos[]=$vl;
			}
			return $dos;
		}else{
			return 0;
		}	
	}
	public function FetchBranchCollection($sql){
		$kw=$this->db->query($sql);
		$kow = $kw->result_array();
		if(!empty($kow)){
			foreach($kow as $vl)
			{
				$dos[]=$vl;
			}
			return $dos;
		}else{
			return 0;
		}	
	}
	public function FetchPaymentSingleData($pid,$enq_type){
		if($enq_type == "enquiry"){
			$sq="select b.branch_name,e.*,p.* from apex_branch b inner join apex_enquiry e on b.branch_id = e.branch_id inner join apex_payment p on e.enquiry_id = p.enquiry_id AND p.payment_id = '$pid' WHERE enquiry_type= '$enq_type'";
		}else{
			$sq="select b.branch_name,e.*,p.* from apex_branch b inner join apex_bulk_enquiry e on b.branch_id = e.branch_id inner join apex_payment p on e.enquiry_id = p.enquiry_id AND p.payment_id = '$pid' WHERE enquiry_type= '$enq_type'";
		}
		$kw=$this->db->query($sq);
		$kow = $kw->result_array();
		if(!empty($kow)){
			//print_r($kow);
			foreach($kow as $vl)
			{
				$dos[]=$vl;
			}
			return $dos;
		}else{
			return 0;
		}	
	}
	
	public function FetchPaymentData($cond="",$type="")
	{	
		if($type == "enquiry"){
			$sq="select b.branch_name,e.*,p.* from apex_branch b inner join apex_enquiry e on b.branch_id = e.branch_id inner join apex_payment p on e.enquiry_id = p.enquiry_id WHERE p.enquiry_type = 'enquiry' ";
		}else{
			$sq="select b.branch_name,e.*,p.* from apex_branch b inner join apex_bulk_enquiry e on b.branch_id = e.branch_id inner join apex_payment p on e.enquiry_id = p.enquiry_id WHERE p.enquiry_type = 'bulk' ";
		}	
		if($cond != ""){
			$sq .= $cond;
		}
		$sq .= " ORDER BY p.payment_date DESC";
		$kw=$this->db->query($sq);
		$kow = $kw->result_array();
		if(!empty($kow)){
			//print_r($kow);
			foreach($kow as $vl)
			{
				$dos[]=$vl;
			}
			return $dos;
		}else{
			return 0;
		}	
	}
	public function FetchPaymentData1($cond="",$type="")
	{	
		if($type == "enquiry"){
			$sq="select b.branch_name,e.*,p.* from apex_branch b inner join apex_enquiry e on b.branch_id = e.branch_id inner join apex_retention_payment p on e.enquiry_id = p.enquiry_id AND p.enquiry_type = 'enquiry' WHERE";
		}else{
			$sq="select b.branch_name,e.*,p.* from apex_branch b inner join apex_bulk_enquiry e on b.branch_id = e.branch_id inner join apex_retention_payment p on e.enquiry_id = p.enquiry_id AND p.enquiry_type = 'bulk' WHERE";
		}	
		if($cond != ""){
			$sq .= $cond;
		}
		$sq .= " ORDER BY p.payment_date";
		$kw=$this->db->query($sq);
		$kow = $kw->result_array();
		if(!empty($kow)){
			//print_r($kow);
			foreach($kow as $vl)
			{
				$dos[]=$vl;
			}
			return $dos;
		}else{
			return 0;
		}	
	}	
	public function FetchPaginationjoinData($tbl1,$tbl2,$val,$cond,$params = array())
	{
		$sq="SELECT $val FROM $tbl1 INNER JOIN $tbl2 ON $cond";
        if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
			$sq .= " LIMIT ".$params['start'].",".$params['limit'];
        }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
			$sq .= " LIMIT ".$params['limit'];
        }
		$kw=$this->db->query($sq);
		$kow = $kw->result_array();
		if(!empty($kow)){
			//print_r($kow);
			foreach($kow as $vl)
			{
				$dos[]=$vl;
			}
			return $dos;
		}else{
			return 0;
		}	
	}
		
	public function InsertData($tbl,$data){
		$str = $this->db->insert($tbl, $data);
		return $this->db->insert_id();
	}
	//Updating arrays of data in table
	public function UpdateQuery($tbl,$data,$cond)
	{
		$data=$this->UpdateValues($data);
		//echo "UPDATE $tbl SET $data WHERE $cond";exit;
		$val=$this->db->query("UPDATE $tbl SET $data WHERE $cond");
		if($this->db->affected_rows()>0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	private function UpdateValues($arr)
	{
		$values="";
		if(!empty($arr))
		{
			foreach($arr as $key=>$value)
			{
				if($values!="")
				{
					$values .= " , ";
				}
				$values .="$key='$value'";
				
			}
		}
		if($values!="")
		{
			return $values;
		}
	}
	public function DeleteData($tbl,$cond,$param)
	{
		$this->db->where($cond,$param);
		$this->db->delete($tbl);
		return $this->db->affected_rows();
	}
	public function DelData($tbl,$cond)
	{
		$this->db->where($cond);
		$this->db->delete($tbl);
		return $this->db->affected_rows();
	}
	public function DeleteMultiple($tbl,$array,$array2)
	{
		$this->db->where($array);
		$this->db->not_like($array2);
		$this->db->delete($tbl);
		return $this->db->affected_rows();
	}

	public function get_enquiry_list($branch_id, $branch_allotment, $sql){
		$qry = "SELECT p.payment_id, p.enquiry_type, e.* FROM apex_payment AS p LEFT JOIN apex_enquiry AS e ON p.enquiry_id = e.enquiry_id WHERE p.enquiry_type = 'enquiry' AND p.retention_status = 'Y' AND e.case_allocation_status = 0 ".$sql;
		if($this->session->userdata('USER_TYPE')=="Manager"){
			$qry.= " AND p.branch_id='$branch_id'";
		}else if($this->session->userdata('USER_TYPE')=="Zonal"){
			$qry = " AND p.branch_id IN($branch_allotment)";
		}else{
			
		}
		//echo $qry;exit;	
		$query = $this->db->query($qry);
		$kow = $query->result_array();
		if(!empty($kow)){
			foreach($kow as $vl)
			{
				$dos[]=$vl;
			}
			return $dos;
		}else{
			return 0;
		}	
	}

public function feedback_personal()
 {
  $sq="SELECT apex_client_personal.name,apex_client_personal.email,apex_client_personal.altmail,apex_client_personal.country,apex_client_personal.dob,apex_client_personal.passport_number,apex_client_personal.issue_place,apex_client_personal.valid_period,apex_client_personal.passport_type,apex_client_personal.previous_passport,apex_client_personal.mobile,apex_client_personal.altmobile,apex_client_personal.marital_status from apex_client_personal WHERE client_id=1";
  
  $kw=$this->db->query($sq);
  $kow = $kw->result_array();
  if(!empty($kow)){
   //print_r($kow);
   foreach($kow as $vl)
   {
    $dos[]=$vl;
   }
   return $dos;
  }else{
   return 0;
  } 
 }
 public function feedback_profession()
 {
  $sq="SELECT apex_client_professional.company,apex_client_professional.duration_from,apex_client_professional.duration_to,apex_client_professional.designation,apex_client_professional.role,apex_client_professional.sp_company,apex_client_professional.sp_design,apex_client_professional.sp_place from apex_client_professional WHERE client_id=1";
  
  $kw=$this->db->query($sq);
  $kow = $kw->result_array();
  if(!empty($kow)){
   //print_r($kow);
   foreach($kow as $vl)
   {
    $dos[]=$vl;
   }
   return $dos;
  }else{
   return 0;
  } 
 }
 public function feedback_education()
 {
  $sq="SELECT apex_education.course_name,apex_education.degree_name,apex_education.study_field,apex_education.duration_from,apex_education.duration_to,apex_education.university,apex_education.place,apex_education.extra_percentage,apex_education.marksheet,apex_education.resume,apex_education.correspondence_type from apex_education WHERE client_id=1";
  
  $kw=$this->db->query($sq);
  $kow = $kw->result_array();
  if(!empty($kow)){
   //print_r($kow);
   foreach($kow as $vl)
   {
    $dos[]=$vl;
   }
   return $dos;
  }else{
   return 0;
  } 
 }
 
function feedback_age()
{
 
 $result=$this->FetchData("apex_age","*","id!=''");
 if($result)
 {
  foreach($result as $key=>$val)
  {
   $ads[]=$val;
  }
  
 }
 return $ads;
}
function feedback_edu()
{
 
 $result=$this->FetchData("apex_edu","*","id!=''");
 if($result)
 {
  foreach($result as $key=>$val)
  {
   $ads[]=$val;
  }
  
 }
 return $ads;
}

	function FetchBranchWiseExpenses($from_date, $to_date){
		$sql = '';
		if($from_date != '' && $to_date != ''){
			$from_dt = explode("/",$from_date);
			$from_date = $from_dt[2]."-".$from_dt[0]."-".$from_dt[1];
			$from_date .= " 00:00:00";
			$to_dt = explode("/",$to_date);
			$to_date = $to_dt[2]."-".$to_dt[0]."-".$to_dt[1];
			$to_date .= " 00:00:00";
			$sql.= " AND p.payment_date BETWEEN '$from_date' AND '$to_date'";
		}else{
			$sql.= " AND p.payment_date LIKE '".date("Y-m-d")."%'";
		}
		$query = $this->db->query("SELECT b.*, ROUND(IFNULL(p.total_payment,0), 2) AS total_payment, ROUND(IFNULL(rp.total_retention,0), 2) AS total_retention, (ROUND(IFNULL(p.total_payment,0),2) + ROUND(IFNULL(rp.total_retention,0), 2)) AS total FROM apex_branch AS b LEFT OUTER JOIN (SELECT SUM(p.total_amount) AS total_payment, p.branch_id FROM apex_payment AS p WHERE p.pay_type='evaluation' ".$sql." GROUP BY p.branch_id) AS p ON b.branch_id = p.branch_id LEFT OUTER JOIN (SELECT SUM(p.total_amount) AS total_retention, p.branch_id FROM apex_retention_payment AS p WHERE 1 ".$sql." GROUP BY p.branch_id) AS rp ON b.branch_id = rp.branch_id ORDER BY total DESC");
		return $query;
	}
	
	function QueryData($sql){
		$query = $this->db->query($sql);
		return $query;
	}
}
