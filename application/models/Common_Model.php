<?php
error_reporting(0);
class Common_Model extends CI_Model {

    function __construct()
    {
        parent::__construct();
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
	function dbinsert ($tablename, $details)
    {
		if($this->db->insert ($tablename, $details))
		{
			//return true;
			return $this->db->insert_id();
		}
		else
		{
			return 0;
		}
    }
	
	function singleColumnResult($sql, $column){
		$query = $this->db->query($sql);
		$res = $query->row();
		if(!empty($res)){
			return $res->$column;
		}else{
			return NULL;
		}
	}
	
	function dbinsertbatch ($tablename, $details){
		if($this->db->insert_batch ($tablename, $details)){
			return true;
		}else{
			return false;
		}
    }
	
	function dbinsertid ($tablename, $details)
    {
		$this->db->trans_start();
		$this->db->insert($tablename, $details);
		$insert_id = $this->db->insert_id();
		$this->db->trans_complete();
		return  $insert_id;
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
	
	function db_select ($tablename)
    {
    	$query = $this->db->query("SELECT * FROM $tablename"); 
    	return $query;
    }
	
	function db_select_order($tablename, $ordercol, $order)
    {
    	$query = $this->db->query("SELECT * FROM $tablename ORDER BY $ordercol $order"); 
    	return $query;
    }
	
	function update_records($table, $field, $fieldvalue, $data)
    {
         $this->db->where( $field, $fieldvalue);
         //$this->db->update($table, $data);
		 
		if($this->db->update($table, $data))
		{
			//return true;
			return $this->db->insert_id();
		}
		else
		{
			return 0;
		}
    }
	
	function select_record($tablename, $idname, $idvalue)
	{
		$this->db->select('*');
		$this->db->from($tablename);
		$this->db->where($idname, $idvalue);
		$results = $this->db->get();
		return $results->row();
	}
	
	function select_records($tablename, $idname, $idvalue)
	{
		$this->db->select('*');
		$this->db->from($tablename);
		$this->db->where_in($idname, explode(',',$idvalue));
		return $results = $this->db->get();
		//return $results->row();
	}
	
	function select_records_order($tablename, $idname, $idvalue, $orderby, $orderval)
	{
		$this->db->select('*');
		$this->db->from($tablename);
		$this->db->where_in($idname, explode(',',$idvalue));
		$this->db->order_by($orderby, $orderval);
		return $results = $this->db->get();
		//return $results->row();
	}
	
	function select_records_in($tablename, $idname, $idvalue)
	{
		$this->db->select('*');
		$this->db->from($tablename);
		$this->db->where($idname, $idvalue);
		return $results = $this->db->get();
		//return $results->row();
	}
	
	function deleterecord($tablename, $idname, $idvalue)
	{
		$this->db->where($idname, $idvalue);
		$this->db->delete($tablename);
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
	
	public function getPagination($tbl,$val="*",$cond="",$params = array()){
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
		return $this->db->query($sq);
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
	function QueryData($sql){
		$query = $this->db->query($sql);
		return $query;
	}
	function db_query($sql){
		$sql = trim($sql);
        $sql_action = strtoupper(substr($sql,0,6));
		
		switch($sql_action)
		{
			case 'SELECT':
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
			break;
			case 'INSERT':
			
				$this->db->query($sql);
				return $this->db->insert_id();

			break;
			case 'UPDATE':
				$this->db->query($sql);
				return $this->db->affected_rows();

			break;
			case 'DELETE':
				$this->db->query($sql);
				return $this->db->affected_rows();

			break;

			default:

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
	}
	function db_getvalue($table_name,$field_name,$where_cond='1'){
		$data = $this->FetchData($table_name, $field_name, $where_cond);
		//echo $field_name;exit;
		if($data){
			return $data[0][$field_name];
		}else{
			return false;
		}
	}
	
	function db_getarr($query,$field1,$field2)
	{
		$infoArr = array();
		$result = $this->db_query($query);
		if($result){
			for($j=0;isset($result[$j]);$j++)
			{
				$key = $result[$j][$field1];
				$value = $result[$j][$field2];
				$infoArr[$key] = stripslashes($value);
			}
		}
		return $infoArr;
	}

	function get_admission_data($class_id = 0, $session_id = 0){
		$clstar = $this->Common_Model->db_query("SELECT SUM(if(sa.Readmission = '1', 1, 0)) AS readm, SUM(if(sa.Readmission = '0', 1, 0)) AS newadm FROM student_admission AS sa LEFT JOIN sessions AS s ON sa.session_id = s.session_id LEFT JOIN classes AS c ON sa.class_id = c.class_id WHERE sa.class_id = '".$class_id."' AND sa.session_id = ".$session_id."");
		if($clstar){
			return $clstar[0];
		}else{
			return array("readm" => 0, "newadm" => 0);
		}
	}

function getBetweenDates($startDate, $endDate)
    {
        $rangArray = [];
            
        $startDate = strtotime($startDate);
        $endDate = strtotime($endDate);
             
        for ($currentDate = $startDate; $currentDate <= $endDate; 
                                        $currentDate += (86400)) {
                                                
            $date = date('Y-m-d', $currentDate);
            $rangArray[] = $date;
        }
  
        return $rangArray;
    }

    
    function list_months($date_from,$date_to, $return_format){
        $arr_months = array();
        $a =  new \DateTime($date_from);
        $x =  new \DateTime($date_to);

        $start = $a->modify('first day of this month');
        $end = $x->modify('first day of next month');

        $interval = \DateInterval::createFromDateString('1 month');
        $period = new \DatePeriod($start, $interval, $end);

        foreach ($period as $dt) {
            $arr_months[] = $dt->format($return_format);
        }

        return $arr_months ;
    }
  
  	function encrypt($plainText,$key)
	{
		$key = $this->hextobin(md5($key));
		$initVector = pack("C*", 0x00, 0x01, 0x02, 0x03, 0x04, 0x05, 0x06, 0x07, 0x08, 0x09, 0x0a, 0x0b, 0x0c, 0x0d, 0x0e, 0x0f);
		$openMode = openssl_encrypt($plainText, 'AES-128-CBC', $key, OPENSSL_RAW_DATA, $initVector);
		$encryptedText = bin2hex($openMode);
		return $encryptedText;
	}

	function decrypt($encryptedText,$key)
	{
		$key = $this->hextobin(md5($key));
		$initVector = pack("C*", 0x00, 0x01, 0x02, 0x03, 0x04, 0x05, 0x06, 0x07, 0x08, 0x09, 0x0a, 0x0b, 0x0c, 0x0d, 0x0e, 0x0f);
		$encryptedText = $this->hextobin($encryptedText);
		$decryptedText = openssl_decrypt($encryptedText, 'AES-128-CBC', $key, OPENSSL_RAW_DATA, $initVector);
		return $decryptedText;
	}
		//*********** Padding Function *********************

	function pkcs5_pad ($plainText, $blockSize)
	{
		$pad = $blockSize - (strlen($plainText) % $blockSize);
		return $plainText . str_repeat(chr($pad), $pad);
	}

		

	function hextobin($hexString) 
	{ 
		$length = strlen($hexString); 
		$binString="";   
		$count=0; 
		while($count<$length) 
		{       
			$subString =substr($hexString,$count,2);           
			$packedString = pack("H*",$subString); 
			if ($count==0)
			{
				$binString=$packedString;
			} 
			
			else 
			{
				$binString.=$packedString;
			} 
			
			$count+=2; 
		} 
		return $binString; 
	}
	
	function fetch_customer_data($id){
 					$id=$id;
					 $query = "SELECT * FROM quotation where id='$id' ";
					 $result = $this->Common_Model->db_query($query);
					 $row = $result[0];
					  $vch=$row['vch'];
					  $narration=$row['narration'];

					$party_code=$row['party_code'];
					$query1 = "SELECT * FROM ledgers where ledger_alias='$party_code' ";
					$result1=$this->Common_Model->db_query($query1);
					 $row1 = $result1[0];

					$query3 = "SELECT * FROM quot_item  where vch='$vch'  order by name ASC ";
					
					$result3=$this->Common_Model->db_query($query3);
					 foreach($result3 as $key => $row3)
					 $group=$row3['group_name'];


					$query4 = "SELECT * FROM quot_item  where vch='$vch' group by  group_name ";
					$result4=$this->Common_Model->db_query($query4);
				
	              $output='
							<html>
							<head>
							</head>
							<body style="font-family: Helvetica Neue, Helvetica, Arial, sans-serif;">
							<div class="book" >
							    <div class="page">
							        <div class="subpage pageborder">
							<div class="container"  >
							<div class="row">
							  <div class="col-md-12" style="width:100%">
							    <img src="./assets/logo png.png" style="height: 50px;float: right;margin-bottom: 10px;">

							  </div>
							</div>
							<div class="row">
							  <div class="col-md-4">
							    <p>Date : '.date('d-F-Y',strtotime($row['date'])).'</p>
							  </div>
							  <div class="col-md-4"> 
							    <center>
							      <br>
							    <h3 style="text-decoration:underline;margin: 0;"><b><span id="yellow" style="color:orange" style="color:orange">C</span>USTOMER DETAILS</b></h3>
							       <p class="line"></p>
							     </center>
							  </div>
							  <div class="col-md-4">
							   <p style="text-align: right;">Quotation No : '.$row['vch'].'</p> 
							  </div>
							</div>
							<div class="row">
								   <div class="col-md-12">
								     <center>
								      
								       <h3 style="text-transform: uppercase;">'.$row1['ledger_name'].'</h3>
								       <p>'.$row1['address'].'</p>
								     <p>
								       Contact No. - <u>+91-'.$row1['mobile'].'</u><br> 
								       Email -  <u>'.$row1['email'].'</u></p>
								     </center>
								   </div>
							</div>
							<div class="row" style="">
    						<div class="col-md-12">
							<center><h2>TECHNO-COMMERCIAL OFFER  </h2></center>
							<div class="row">
							   <div class="col-md-12">
							   <p>  
							 ';
							 
			$ab=$this->Common_Model->db_query("select * from `catgroup` ");
			foreach ($ab as $key => $ab1) {
				$group_title2=$ab1['group_title'];
				$name2=$ab1['name'];
				$select=$this->Common_Model->db_query("select * from quot_item  where vch='$vch' AND group_name='$group_title2' order by id ASC");
				                
				    foreach ($select as $key => $row) {
				        $group_name2=$row['group_name'];
				    	}
				        if($group_title2==$group_name2){ 
				       
				         $output .='<i class="fa fa-check-square-o"style="font-size: 16px;font-weight: 300 !important"></i> &nbsp;<span style="font-weight:600;color:orange" id="yellow">'.$group_name2.'</span>  &nbsp;&nbsp;&nbsp;'.$select[0]['name'].'
				      <br>';
				       } }    

							 $output .= '</p>
							 		</div>
							  		</div>
							 	</div>
  							</div>
							 <div class="row vv">
							    <div class="col-md-12">
							      <center>
							        <img src="./assets/logo png.png" style="height: 40px;">
							        <p style="margin-bottom: 0px">Contact Person : '.$row['name'].'</p>
							        <p style="margin-bottom: 0px">Mobile No : '.$row['mno'].'</p>
							        <h5 style="color:green!important;margin-bottom: 0px;font-weight:600;"><u id="green">REGISTERED OFFICE</u></h5>
							        <p style="margin-bottom: 0px">Plot No-1094/2869,  Madanpur,</p>
							        <p style="margin-bottom: 0px">Bhubaneswar, Odisha, INDIA, 752054 </p>

							      </center>
							    </div>
							   </div>
							  </div>

							 </div>    
							</div>
							

							<div class="page">
							  	<div class="subpage pageborder">
								    <div class="container its" >
										<div class="row">
										  <div class="col-md-12">
										    <img src="./assets/logo png.png" style="height: 50px;float: right;margin-bottom: 10px;">

										  </div>
										</div>
										<div class="row " >
										  <div class="col-md-12">
										    <h3 style="text-decoration:underline;margin: 0;"><b><span id="yellow" style="color:orange">A</span>BOUT US</b></h3>
										    <p class="text-justify" style="font-size: 16px;line-height:1;font-style: italic !important;font-family: math;margin:0;">GLOSENT is a leading provider of innovative solutions for the safe and efficient handling, storage, and distribution of gases, including LPG, NG & other industrial gases. With a commitment to delivering top-quality products and services, we cater to diverse industries that require precise and reliable gas systems. </p>
										  </div>
										</div>
										<h4 style="text-decoration:underline;margin: 0;"><b>OUR <span id="yellow" style="color:orange">V</span>ISION</b></h4>
										<div class="row">
										  <div class="col-md-12">
										    <p class="text-justify" style="font-size: 16px;line-height:1;font-style: italic !important;font-family: math;">To be a global leader in the gas systems industry, recognized for our innovation, technical expertise, and unwavering commitment to customer satisfaction. We aspire to create a safer, more efficient future for gas storage, distribution, and management, enhancing the performance of industries across the globe.
										</p>
										  </div>
										</div>
										<h4 style="text-decoration:underline;margin: 0;"><b>OUR <span id="yellow" style="color:orange">M</span>ISSION</b></h4>
										<div class="row">
										  <div class="col-md-12">
										    <p class="text-justify" style="font-size: 16px;line-height:1;font-style: italic !important;font-family: math;">To passionately innovate what is essential to growth of our customer and create value to the customer by providing exceptionally competitive products and services.
										</p>
										  </div>
										</div>
										<h4 style="text-decoration:underline;margin: 0;"><b>OUR CORE <span id="yellow" style="color:orange">V</span>ALUES</b></h4>
										<div class="row">
										  <div class="col-md-12">
										    <p class="text-justify" style="font-size: 16px;line-height:1;font-style: italic !important;font-family: math;">✓ <b>Innovation:</b> We are constantly seeking ways to improve our solutions and incorporate new technologies to better serve our clients.</p>
										     <p class="text-justify" style="font-size: 16px;line-height:1;font-style: italic !important;font-family: math;">✓ <b>Integrity:</b> We believe in honesty and transparency in all our dealings, and our client’s satisfaction is our top priority.</p>
										     <p class="text-justify" style="font-size: 16px;line-height:1;font-style: italic !important;font-family: math;">✓ <b>Excellence:</b> We strive for excellence in every project, ensuring that all systems we design, fabricate, and install are of the highest quality and reliability.</p>
										  </div>
										</div>

										<h4 style="text-decoration:underline;margin: 0;"><b>WHAT WE <span id="yellow" style="color:orange">D</span>O?</b></h4>
										<div class="row">
										  <div class="col-md-12" style="font-style: italic !important;font-family: math;font-size: 16px !important;">
										    <p class="text-justify" style="font-size: 16px;line-height:.5;">✓ <b> Thermal Engineering</b></p>
										      &nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-circle-thin" style="font-size: 8px"></i>&nbsp;&nbsp;Fuel Conversions from other fuels to LPG / NG<br>

										      &nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-circle-thin" style="font-size: 8px"></i>&nbsp;&nbsp;Boiler Installation (IBR / NON-IBR)<br>

										      &nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-circle-thin" style="font-size: 8px"></i>&nbsp;&nbsp;Hot Water Generators (Shell & Tube / Coil Type)
										    <p class="text-justify" style="font-size: 16px;line-height:.5;">✓ <b> Gas Storage Solutions</b></p>

										      &nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-circle-thin" style="font-size: 8px"></i>&nbsp;&nbsp;LPG Supply<br>
										      &nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-circle-thin" style="font-size: 8px"></i>&nbsp;&nbsp;Installation of Gas Bank- VOT, LOT, BULK Storages<br>
										      &nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-circle-thin" style="font-size: 8px"></i>&nbsp;&nbsp;Vaporiser & Gas Trains

										    <p class="text-justify" style="font-size: 16px;line-height:.5;">✓ <b> Utility Engineering</b></p>
										      &nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-circle-thin" style="font-size: 8px"></i>&nbsp;&nbsp;Pipeline Installations: Turnkey Solutions<br>
										      &nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-circle-thin" style="font-size: 8px"></i>&nbsp;&nbsp;Technical Design: Based on Pressure & Flow


										    <p class="text-justify" style="font-size: 16px;line-height:.5;">✓ <b> Fabrications</b></p>
										      &nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-circle-thin" style="font-size: 8px"></i>&nbsp;&nbsp;Skid-Mounted Systems<br> 
										      &nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-circle-thin" style="font-size: 8px"></i>&nbsp;&nbsp;Pressure Vessels and Storage Tanks<br> 
										      &nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-circle-thin" style="font-size: 8px"></i>&nbsp;&nbsp;Heat Exchangers<br> 
										      &nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-circle-thin" style="font-size: 8px"></i>&nbsp;&nbsp;Handling and Lifting Equipment
										    <p class="text-justify" style="font-size: 16px;line-height:.5;">✓ <b> Engineering Documentation</b></p>
										      &nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-circle-thin" style="font-size: 8px"></i>&nbsp;&nbsp;Engineering Standards and Compliance Documentation<br> 
										      &nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-circle-thin" style="font-size: 8px"></i>&nbsp;&nbsp;Energy Audits & Technical calculations<br> 
										      &nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-circle-thin" style="font-size: 8px"></i>&nbsp;&nbsp;Third Party Inspections<br>
										  </div>
										</div>
										<h4 style="text-decoration:underline;margin: 0;"><b>WHY <span id="yellow" style="color:orange">G</span>LOSENT? </b></h4>
										  <div class="row">
										    <div class="col-md-12" style="font-style: italic !important;font-family: math;font-size: 16px !important;">
										      <p class="text-justify" style="font-size: 16px;line-height:.2;">✓ <b> Innovative Product Solutions</b></p>
										      <p class="text-justify" style="font-size: 16px;line-height:.2;">✓ <b> Focus on Compliance and Safety</b></p>
										      <p class="text-justify" style="font-size: 16px;line-height:.2;">✓ <b> Innovative and Customizable Solutions</b></p>
										      <p class="text-justify" style="font-size: 16px;line-height:.2;">✓ <b> Turnkey Project Management</b></p>
										      <p class="text-justify" style="font-size: 16px;line-height:.2;">✓ <b> Commitment to Sustainability</b></p>
										      <p class="text-justify" style="font-size: 16px;line-height:.2;">✓ <b> Dedicated Technical Support and Training</b></p>
										    </div>
										  </div>
									</div>
								</div>
							</div>

							<div class="page">
							  <div class="subpage pageborder">
							    <div class="container" >
							    <div class="row">
								  <div class="col-md-12">
								    <img src="./assets/logo png.png" style="height: 50px;float: right;margin-bottom: 10px;">

								  </div>
								</div>
							      <div class="row">
							        <div class="col-md-12">
							        <h3 style="text-decoration:underline;"><b><span id="yellow" style="color:orange">S</span>COPE OF SUPPLY</b></h3>';
							   


							          $query9="select * from `catgroup` ";
							          
							          $result9=$this->Common_Model->db_query($query9);
							          foreach($result9 as $key => $row9){
							            $group_title2=$row9['group_title'];  
							            $name2=$row9['name'];
							            
							          $query10 = "select * from quot_item where vch='$vch' AND group_name='$group_title2' order by display_order ASC"; 
							            
							            $result10=$this->Common_Model->db_query($query10);
							      
							              if ($result10) {
							                 
							                      
							$output.='<center><h4><b id="yellow" style="color:orange">'.$group_title2.' </b>&nbsp;&nbsp;&nbsp;<b> '.$result10[0]['name'].'</b></h4></center>
							        <div class="table-responsive">
							          <table class="table  table-bordered">
							            <thead>
							                  <tr>
							                    <th style="text-align: center;">Sl No. </th>
							                    <th width="45%" style="text-transform: uppercase;text-align: center;">Description</th>
							                    <th style="text-transform: uppercase;text-align: center;">Qty.</th>
							                    <th style="text-transform: uppercase;text-align: center;">UOM</th>
							                    <th style="text-transform: uppercase;text-align: center;">Rate</th>
							                    <th style="text-transform: uppercase;text-align: center;">Amount</th>
							                  </tr>
							            </thead>
							            <tbody>
							    ';
							  
							        $sl=0;
							            $sum1=0;
							    foreach($result10 as $key => $row10){
							    	$se1=$this->Common_Model->db_query("select * from item  where code='".$row10['code']."'");
							    	$rw=$se1[0];
							         $sl++;
							             $sum1+=$row10['amount'];
							        $output .= '
							              <tr>
							                <td>'.$sl.'</td>
							                <td><span id="blue">Item Code : &nbsp;&nbsp;'.$row10['code'].'</span><br>
									            <span id="green">'.$row10['item'].'</span><br>
									              
									              <hr style="margin: 0px">
									              '.$row10['des'].'
									              <br> <span id="blue">HSN / SAC CODE :&nbsp;&nbsp;'.$rw['hsn'].'</span>';
									              if($row10['unit1'] !='unit'){ 
									                $output .= '<br><span id="blue">MAIN UNIT : '.$rw['unit'].'</span>';
									               } if($row10['unit1'] !='alt_unit'){ 
									                $output .= '<br><span id="blue">SECONDARY UNIT : '.$rw['alt_unit'].'</span>';
									              } if($row10['unit1'] !='pack'){ 
									                $output .= '<br><span id="blue">PACKING UNIT : '.$rw['pack'].'</span>';
									             } 
									          $output .= '</td>
							                <td>'.$row10['qty'].'</td>
							                <td>'.$row10['unit'].'</td>
							                   
							                <td style="text-align: right;"> '.price_format($rate1=$row10['amount']/$row10['qty']).'</td>
							                  
							                <td style="text-align: right;"> '.price_format($row10['amount']).'</td>
							            </tr>
							            ';
							          }

							           $output .= '
							           <tr>
							            <td colspan="5"><p style="float: left;margin: 0px;font-size: 19px;font-weight: 600">Total Price</p></td>
							            <td style="font-size: 18px;font-weight: 600;style="text-align: right;"">'.price_format($sum1).'</td>
							           </tr>
							            </tbody>
							          </table>
							         </div>';
							         } 
							        }
							         $output .='<center><h4>Summary</h4></center>
							      <div class="table-responsive">
							          <table class="table table-bordered" width="100%">
						                <thead>
						                  <tr>
						                    <th>PART</th>
						                    <th width="45%">DESCRIPTION</th>
						                    <th style="text-align:center;">BASIC</th>
						                    <th style="text-align:center;">GST</th>
						                    <th style="text-align:center;">AMOUNT</th>
						                  </tr>
						                </thead>
						                <tbody>';
		                          $sum2=0;
		                          $ab=$this->Common_Model->db_query("select * from `catgroup` ");
		                           foreach ($ab as $key => $ab1) {
		                             
		                            $group_title2=$ab1['group_title'];
		                            $name2=$ab1['name'];
		                            $select=$this->Common_Model->db_query("select * from quot_item  where vch='$vch' AND group_name='$group_title2' order by id ASC");
					                        
					                           
					                   $sum1=0;
					                   $gst3 = 0;
					                   foreach ($select as $key => $row) {
					                    
					                    $group_name2=$row['group_name'];
					                    $sum1+=$row['amount'];
					                    $gst3+=$row['rate_price'];
					            
					                  }
					                  if($group_title2==$group_name2){
					                  $output .='<tr>
					                    <td>'.$ab1['group_title'].'</td>
					                   <td width="45%">'.$select[0]['name'].'</td>
					                   <td style="text-align:right;">'.price_format($sum1).'</td>
					                   <td style="text-align:right;">'.price_format($gst3).'</td>
					                   <td style="text-align:right;">'.price_format($all=$sum1+$gst3).'</td>
					                  </tr>';
					                    } 
						                   $sum2+=$sum1;
						                   $gst4+=$gst3;
					                    }
					                   $output .='<tr>
					                     <td colspan="2">Total Price</td>
					                     <td style="font-size: 20px;font-weight: 600;text-align:right;">'.price_format($sum2).'</td>
					                     <td style="font-size: 20px;font-weight: 600;text-align:right;">'.price_format($gst4).'</td>
					                     <td style="font-size: 20px;font-weight: 600;text-align:right;">'.price_format($all4=$sum2+$gst4).'</td>
					                   </tr>

					                </tbody>
					              </table>
								  </div>
								  
			         </div>
			         </div>
			         </div>
			         </div>
			         </div>
							          ';
							            
							    
							           $output .= '
							           <div class="page pagebreak" style="page-break-inside: avoid;">
							  <div class="subpage pageborder">
							    <div class="container">
							    <div class="row">
							  <div class="col-md-12">
							    <img src="./assets/logo png.png" style="height: 50px;float: right;margin-bottom: 10px;">

							  </div>
							</div>
							    <div class="row">
							      <div class="col-md-12">
							        <h3 style="text-decoration:underline;"><b><span id="yellow" style="color:orange">C</span>OMMERCIAL TERMS</b></h3>
							      ';
							          $query11="select * from `quot_terms` where vch='$vch' ";
							          
							          $result11=$this->Common_Model->db_query($query11);
							          foreach($result11 as $key => $row11){
							          $output .= '
							            <center><h6 style="font-weight: 600;font-size: 18px;letter-spacing: 1px;margin-bottom:2px;">  '.$row11['groups'].'
							        
							            </h6></center>
				                    <div class=" table-responsive" style="background-color: #fff">
				                      <table class="table tb table-bordered" style="margin-bottom: 0px">
				                        <tbody>
				                          <tr>
				                            <td width="30%" style="font-weight: 500;color: #000 !important;font-size: 14px;"> DELIVERY PERIOD</td>
				                            <td>'.$row11['commercial_terms1'].'</td>
				                           </tr>
				                          <tr>
				                            <td  style="font-weight: 500;color: #000 !important;font-size: 14px;">PRICE</td>
				                             <td>'.$row11['commercial_terms2'].'</td>
				                           </tr>
				                           <tr>
				                            <td  style="font-weight: 500;color: #000 !important;font-size: 14px;">GST</td>
				                             <td>'.$row11['commercial_terms3'].'</td>
				                           </tr>
				                            <tr>
				                            <td  style="font-weight: 500;color: #000 !important;font-size: 14px;">PACKING & FORWARDING</td>
				                             <td>'.$row11['commercial_terms4'].'</td>
				                           </tr>
				                          <tr>
				                            <td  style="font-weight: 500;color: #000 !important;font-size: 14px;">TRANSIT INSURANCE</td>
				                             <td>'.$row11['commercial_terms5'].'</td>
				                          </tr>
				                          <tr>
				                            <td  style="font-weight: 500;color: #000 !important;font-size: 14px;">LOADING & UNLOADING</td>
				                             <td>'.$row11['commercial_terms10'].'</td>
				                          </tr>
				                            <tr>
				                            <td  style="font-weight: 500;color: #000 !important;font-size: 14px;">MISCELLANEOUS</td>
				                             <td>'.$row11['commercial_terms11'].'</td>
				                           </tr>
				                            <tr>
				                            <td  style="font-weight: 500;color: #000 !important;font-size: 14px;">PAYMENT TERMS</td>
				                             <td>'.$row11['commercial_terms7'].'</td>
				                           </tr>
				                            <tr>
				                            <td  style="font-weight: 500;color: #000 !important;font-size: 14px;">QUOTATION VALIDITY</td>
				                             <td>'.$row11['commercial_terms8'].'</td>
				                           </tr>
				                            <tr>
				                            <td  style="font-weight: 500;color: #000 !important;font-size: 14px;">WARRANTY</td>
				                             <td>'.$row11['commercial_terms9'].'<br><span> This warrantee does not apply to system after commissioning, are determined to have been damaged due to neglect, abuse, overloading, mis-handling, accident or improper use. </span><br>
				     <span>There is not any Warrantee applicable for Electrical & electronic components.</span></td>
				                           </tr>
				                        </tbody>
				                      </table>
				                      </div>
							                ';
							            
							        }
							           $output .= '
							 
							    </div>
							    <div class="col-md-12">
							     <span> This warrantee does not apply to system after commissioning, are determined to have been damaged due to neglect, abuse, overloading, mis-handling, accident or improper use. </span><br>
							     <span>There is not any Warrantee applicable for Electrical & electronic components.</span>
							    </div>
							  </div> 
							    ';
							     $query12="select * from `quotation` where vch='$vch' ";
							          
							          $result12=$this->Common_Model->db_query($query12);
							          $row12 = $result12[0];
							     $output .= '
							    <div class="row">
							      <div class="col-md-12">
							       <h3 style="text-decoration:underline;"><b><span id="yellow" style="color:orange">E</span>XCLUSIONS</b></h3>';
							if($row12['exc1'])  {   
                          		$output .='<li>  '.$row12['exc1'].'</li>';
                           		} 
                           if($row12['exc2'])  {  
                           		$output .='<li> '.$row12['exc2'].'</li>';
                        		} 
                           if($row12['exc3'])  {  
                           		$output .='<li> '.$row12['exc3'].'</li>';
                           	} 
                           if($row12['exc4'])  {    
                           		$output .='<li> '.$row12['exc4'].'</li>';
                          	 } 
                          if($row12['exc5'])  {   
                           		$output .='<li> '. $row12['exc5'].'</li>';
                          	} 
                           if($row12['exc6'])  {   
                           		$output .='<li> '.$row12['exc6'].'</li>';
                           	} 
                           if($row12['exc7'])  {    
                           		$output .='<li> '.$row12['exc7'].'</li>';
                           	} 
                            if($row12['exc8'])  {   
                           		$output .='<li> '.$row12['exc8'].'</li>';
                           	}
                           if($row12['exc9'])  {   
                           		$output .='<li> '.$row12['exc9'].'</li>';
                           	} 
                            if($row12['exc10'])  {    
                           		$output .='<li> '.$row12['exc10'].'</li>';
                         	}
                            if($row12['exc11'])  {    
                           		$output .='<li> '.$row12['exc11'].'</li>';
                          	}
                            $output .='</ol>';
							        



							       $output .='<span id="darkblue" style="color: darkblue">
							         Thanking you and assuring you of our best services at all times.<br>
							         Should you need any more information, please feel free to contact us.
							       </span>

							';
							           $query13="select * from `quotation` where vch='$vch' ";
							            
							            $result13=$this->Common_Model->db_query($query12);
							            $row13 = $result13[0];
							            
							              $a_userid=$row13['c_id'];
							                    $query14="select * from `users` where user_id='$a_userid' ";
							                    
							                    $result14=$this->Common_Model->db_query($query14);
							                    $row14 =$result14[0];
							                    $name=$row14['firstname'].' '.$row14['lastname'];
							                    $mno=$row14['userphone'];
							                    $userid=$row14['user_id'];
							                    $email=$row14['useremail'];
							             

							 $output .= '
							       <p style="text-align:  right">Thanks & Regards<br>
							                                     For <b>Glosent</b><br>
							        <br>
							       '.$name.' <br>
							       Mob. No. '.$mno.' 
							       </p>
							       <center><span id="red" style="font-size: 11px;color: red; ">This is Computer-Generated Document ,Hence No Signature Required</span></center>
							       </div>
							       </div>



							        </div>
							      </div>
							    </div>
							  </div>
							</div>

							</div>
							</body>
							</html>
							 ';
							  return $output;

	}
	
	function fetch_customer_data_re($id){
 					$id=$id;
					 $query = "SELECT * FROM r_quotation where id='$id' ";
					 $result = $this->Common_Model->db_query($query);
					 $row = $result[0];
					  $vch=$row['vch'];
					  $narration=$row['narration'];

					$party_code=$row['party_code'];
					$query1 = "SELECT * FROM ledgers where ledger_alias='$party_code' ";
					$result1=$this->Common_Model->db_query($query1);
					 $row1 = $result1[0];

					$query3 = "SELECT * FROM r_quot_item  where vch='$vch'  order by name ASC ";
					
					$result3=$this->Common_Model->db_query($query3);
					 foreach($result3 as $key => $row3)
					 $group=$row3['group_name'];


					$query4 = "SELECT * FROM r_quot_item  where vch='$vch' group by  group_name ";
					$result4=$this->Common_Model->db_query($query4);
				
	              $output='
							<html>
							<head>
							</head>
							<body style="font-family: Helvetica Neue, Helvetica, Arial, sans-serif;">
							<div class="book" >
							    <div class="page">
							        <div class="subpage pageborder">
							<div class="container"  >
							<br><br><br><br><br>
							<div class="row" style="display: -webkit-box;">
							  <div class="col-md-6" style="width:50%">
							    <p style="font-size:17px;margin-bottom:2px">Date : '. date('d-F-Y',strtotime($row['date'])).'</p>
							  </div>
							  <div class="col-md-6" style="width:50%">
							   <p style="font-size:17px;text-align:right;margin-bottom:2px">Quotation No : '.$row['vch'].'</p> 
							  </div>
							</div>
							<div class="row">
							   <div class="col-md-2"></div>
							   <div class="col-md-8">
							     <center style="line-height:18px;">
							       <h3 style="margin-bottom: 0px;font-size: 25px;font-weight:500;">Customer Details</h3> </center>
							       <p style="background-color:#000 !important;height:1px !important;width:28% !important;margin-bottom:0px !important;margin-left:35% !important"></p>
							      <center style="line-height:18px;"> <h3 style="text-transform: uppercase;margin-bottom:0px">'.$row1['ledger_name'].'</h3>
							       <p>'.$row1['address'].' </p>
							       <p>Kind Attention  -  <u>'.$row1['ledger_name'].'</u> <br>
							       Contact No. - <u>+91-'.$row1['mobile'].'</u><br> 
							       Email -  <u>'.$row1['email'].'</u></p>

							      
							       <h2 style="">TECHNO-COMMERCIAL OFFER <br> FOR</h2>
							       <h3>'.$narration.'</h3>
							     </center>
							   </div>
							   <div class="col-md-2"></div>
							</div>
							 ';
							 foreach($result4 as $row4)
							 
							 
							  $output .='
							  <div class="row">
							   <div class="col-md-12">
							   <p>  <i class="fa fa-check-square-o " aria-hidden="true" style="font-size: 16px;font-weight: 300 !important;color:#2196f3  !important"></i>  '.$row4['name'].'</p>
							   </div>
							  </div>
							  ';

							 $output .= '
							 <div class="row vv">
							    <div class="col-md-12">
							      <center>
							        <h3 style="margin-bottom: 0px">GLOSENT INDIA PRIVATE LIMITED</h3>
							        <p id="red" style="color: red;margin-bottom: 0px">(AN ISO 9001-2015 CERTIFIED COMPANY)</p>
							        <p style="margin-bottom: 0px">CIN: U74140OR2014PTC018128</p>
							        <p style="margin-bottom: 0px">Contact Person : '.$row['name'].' </p>
							        <p style="margin-bottom: 0px">Mobile No : '.$row['mno'].' </p>
							        <h5 style="color:green !important;margin-bottom: 0px"><u>REGISTERED OFFICE</u></h5>
							        <p style="margin-bottom: 0px">Plot No-6/1124, Ranasinghpur, AIIMS Hospital Road,</p>
							        <p style="margin-bottom: 0px">Behind Biju Patnaik State Police Academy,</p>
							        <p style="margin-bottom: 0px">Bhubaneswar, Odisha, INDIA, 751019</p>
							        <h5 style="color: green;margin-bottom: 0px"><u>MANUFACTURING UNIT</u></h5>
							        <p style="margin-bottom: 0px">Gat No-1532, Jyotiba Nagar, Talawade, Pune<br>Maharashtra, INDIA, 411062</p>
							        <h5 style="color: green;margin-bottom: 0px"><u>REGIONAL OFFICE</u></h5>
							        <p style="margin-bottom: 0px">PUNE || DELHI || JAIPUR || CALCUTTA || VISAKHAPATNAM</p>
							      </center>
							    </div>
							   </div>
							  </div>

							 </div>    
							</div>
							<div class="page">
							  <div class="subpage pageborder">
							    <div class="container">
							<br><br>
							   <div class="row">
							    <div class="col-md-2"></div>
							    <div class="col-md-10">
							     <center><h2><u><b>INDEX</b></u></h2></center>
							      <h3>1.&nbsp;&nbsp;About GLOSENT</h3><br>
							      <h3>2.&nbsp;&nbsp;Scope of Supply</h3><br>
							      <h3>3.&nbsp;&nbsp;Commercial Terms</h3><br>
							      <h3>4.&nbsp;&nbsp;Exclusions</h3>
							    </div>
							    </div>
							  </div>
							</div>
							</div>

							<div class="page">
							  <div class="subpage pageborder">
							    <div class="container">
							<br><br>
							<div class="row">
							  <div class="col-md-12">
							    <center><h2><b>1. ABOUT GLOSENT</b></h2></center>
							    <p class="text-justify" style="font-size: 16px">We are GLOSENT INDIA PRIVATE LIMITED engaged in LPG (Liquefied Petroleum Gas) and NG
							      (Natural Gas) Gas Pipeline Installation, Fabrication and Testing Services in pan India.<br>
							      Being a front runner in the industry, we are involved in providing our customers highly
							      qualitative Thermal Engineering Services. We seamlessly integrate design solutions with existing
							      product development cycles through flexible engagement models and steer the organization towards
							      reaching their manufacturing goals on time.<br>
							      We are a team of technically competent professionals. We update our knowledge, systems, equipment
							      and materials to enable us to deliver superior products, that are economical, safe and on schedule. We
							      have always maintained a standard that meets the optimum expectation of our customers and it has
							      helped us gain a long-term relationship of commitment and integrity with them. </p>
							        </div>
							        </div>
							        <center><h2><b><span id="yellow" style="color:orange">V</span>ISION</b></h2></center>
							      <div class="row">
							        <div class="col-md-12">
							          <p class="text-justify" style="font-size: 16px">To be leading service and solution provider in Plant Design Engineering globally and to set new benchmark for innovation and service quality.
							    </p>
							  </div>
							</div>

							<div class="row">
							  <div class="col-md-12">
							  <center><h2><b><span id="yellow" style="color:orange">M</span>ISSION</b></h2></center>
							    <p class="text-justify" style="font-size: 16px">To passionately innovate what is essential to growth of our customer and create value to the customer by providing exceptionally competitive products and services.
							    </p>
							  </div>
							</div>
							<div class="row">
							  <div class="col-md-12">
							  <center><h2><b><span id="yellow" style="color:orange">V</span>ALUES</b></h2></center>
							    <p class="text-justify" style="font-size: 16px">Our values are the firm foundations upon which we build our mission.</p>
							    <p class="text-justify" style="font-size: 16px"><b>Integrity</b> :  The courage to maintain the right from the wrong without compromise.</p>
							    <p class="text-justify" style="font-size: 16px"><b>Reliability</b> : The ability to deliver on what we promise, without any exception.</p>
							    <p class="text-justify" style="font-size: 16px"><b>Accountability</b> : The strength to be responsible for our actions and decisions.</p>
							  </div>
							</div>
							<div class="row">
							  <div class="col-md-12">
							  <center><h2><b><span id="yellow" style="color:orange">O</span>UR GOALS</b></h2></center>
							    <p class="text-justify" style="font-size: 16px">Our goals are specific and well-defined, which is why our services too are extremely focused and objective.</p>
							    <p class="text-justify" style="font-size: 16px"><i class="fa fa-circle-thin" style="font-size: 8px"></i>&nbsp;&nbsp;To facilitate top quality services
							      <i class="fa fa-circle-thin" style="font-size: 8px"></i>&nbsp;&nbsp;To work with a few, but delighted clients
							      <i class="fa fa-circle-thin" style="font-size: 8px"></i>&nbsp;&nbsp;To make useful contributions to health, safety and environment
							      <i class="fa fa-circle-thin" style="font-size: 8px"></i>&nbsp;&nbsp;Facilitate environment-friendly and durable products
							      <i class="fa fa-circle-thin" style="font-size: 8px"></i>&nbsp;&nbsp;Nurture strong relationship with our clients, based on trustworthiness, and timely feedback  and updates.
							    </p>
							    </div>
							  </div>

							  </div>
							 </div>    
							</div>
							<div class="page">
							  <div class="subpage pageborder">
							    <div class="container">
							    <br><br><br>
							    <div class="row">
							      <div class="col-md-12">
							        <center><h3><b>WHAT WE DO AND WHY YOU SHOULD, TOO</b></h3></center>
							        <p class="text-justify" style="font-size: 16px">You may not realize or think about how a company like <b>GLOSENT</b> can impact your daily life. We are providing numbers of Products & Services like,</p>
							        <h5 style="color: red" id="red">1. DOWNSTREAM PIPELINE</h5>
							        <p>
							          <i class="fa fa-circle-thin" style="font-size: 8px"></i>&nbsp;&nbsp;Piped Natural Gas (PNG)
							        </p>
							        <h5 style="color: red;margin-bottom:0px !important;" id="red">2. LPG INSTALLATIONS</h5>
							        <p>
							          <i class="fa fa-circle-thin" style="font-size: 8px"></i>&nbsp;&nbsp;LPG Supply<br>
							          <i class="fa fa-circle-thin" style="font-size: 8px"></i>&nbsp;&nbsp;LOT (Liquid Off Take)<br>
							          <i class="fa fa-circle-thin" style="font-size: 8px"></i>&nbsp;&nbsp;VOT (Vapor Off Take)<br>
							          <i class="fa fa-circle-thin" style="font-size: 8px"></i>&nbsp;&nbsp;Leak Detectors<br>
							          <i class="fa fa-circle-thin" style="font-size: 8px"></i>&nbsp;&nbsp;LPG Bullets<br>
							          <i class="fa fa-circle-thin" style="font-size: 8px"></i>&nbsp;&nbsp;LPG / Propane Vaporisers
							        </p>
							        <h5 style="color: red;margin-bottom:0px !important;" id="red">3. THERMAL ENGINEERING</h5>
							        <p>
							          <i class="fa fa-circle-thin" style="font-size: 8px"></i>&nbsp;&nbsp;Fuel Conversions from other fuels to LPG / NG<br>
							          <i class="fa fa-circle-thin" style="font-size: 8px"></i>&nbsp;&nbsp;Boiler Installation (IBR / NON IBR)<br>
							          <i class="fa fa-circle-thin" style="font-size: 8px"></i>&nbsp;&nbsp;Solar Steam Projects<br>
							          <i class="fa fa-circle-thin" style="font-size: 8px"></i>&nbsp;&nbsp;Thermic Fluid Heater<br>
							          <i class="fa fa-circle-thin" style="font-size: 8px"></i>&nbsp;&nbsp;Hot Water Generators (Shell & Tube / Coil Type)
							        </p>
							        <h5 style="color: red;margin-bottom:0px !important;" id="red">4. UTILITY ENGINEERING</h5>
							        <p>
							          <i class="fa fa-circle-thin" style="font-size: 8px"></i>&nbsp;&nbsp;All Types of Industrial Gases<br>
							          <i class="fa fa-circle-thin" style="font-size: 8px"></i>&nbsp;&nbsp;Flammable Gases (LPG, PNG)<br>
							          <i class="fa fa-circle-thin" style="font-size: 8px"></i>&nbsp;&nbsp;Toxic Gases (Methanol, Ammonia)<br>
							          <i class="fa fa-circle-thin" style="font-size: 8px"></i>&nbsp;&nbsp;Compressed Air Piping<br>
							          <i class="fa fa-circle-thin" style="font-size: 8px"></i>&nbsp;&nbsp;Oil Piping (Thermic Oil, Diesel, F.O. etc.)<br>
							          <i class="fa fa-circle-thin" style="font-size: 8px"></i>&nbsp;&nbsp;Piping Works (Steam, Condensate, Chilled / Hot Water)
							        </p>
							        <h5 style="color: red;margin-bottom:0px !important;" id="red">5. STRUCTURAL FABRICATIONS</h5>
							        <p>
							          <i class="fa fa-circle-thin" style="font-size: 8px"></i>&nbsp;&nbsp;Pipe Rack / Primary Support<br>
							          <i class="fa fa-circle-thin" style="font-size: 8px"></i>&nbsp;&nbsp;Mezzanine Floor / Platform<br>
							          <i class="fa fa-circle-thin" style="font-size: 8px"></i>&nbsp;&nbsp;Stair Case & Ladders<br>
							          <i class="fa fa-circle-thin" style="font-size: 8px"></i>&nbsp;&nbsp;Industrial Shed
							        </p>
							        <h5 style="color: red;margin-bottom:0px !important;" id="red">6. EQUIPMENT FABRICATION</h5>
							        <p>
							          <i class="fa fa-circle-thin" style="font-size: 8px"></i>&nbsp;&nbsp;Exhaust Hood<br>
							          <i class="fa fa-circle-thin" style="font-size: 8px"></i>&nbsp;&nbsp;Chimney<br>
							          <i class="fa fa-circle-thin" style="font-size: 8px"></i>&nbsp;&nbsp;Water Tanks, Expansion Tank<br>
							          <i class="fa fa-circle-thin" style="font-size: 8px"></i>&nbsp;&nbsp;Reactors / Pressure Vessels
							        </p>
							        <h5 style="color: red;margin-bottom:0px !important;" id="red">7. ENGINEERING DOCUMENTATION</h5>
							        <p>
							          <i class="fa fa-circle-thin" style="font-size: 8px"></i>&nbsp;&nbsp;Project specifications<br>
							          <i class="fa fa-circle-thin" style="font-size: 8px"></i>&nbsp;&nbsp;Engineering standards<br>
							          <i class="fa fa-circle-thin" style="font-size: 8px"></i>&nbsp;&nbsp;Energy Audits<br>
							          <i class="fa fa-circle-thin" style="font-size: 8px"></i>&nbsp;&nbsp;Technical calculations<br>
							          <i class="fa fa-circle-thin" style="font-size: 8px"></i>&nbsp;&nbsp;Flow diagrams
							        </p>
							      </div>
							    </div>
							    </div>
							</div>
							</div>

							<div class="page">
							  <div class="subpage pageborder">
							    <div class="container">
							    <br><br><br>
							      <div class="row">
							        <div class="col-md-12">
							        <center><h3> 2. SCOPE OF SUPPLY </h3></center>';
							   


							          $query9="select * from `catgroup` ";
							          
							          $result9=$this->Common_Model->db_query($query9);
							          foreach($result9 as $key => $row9){
							            $group_title2=$row9['group_title'];  
							            $name2=$row9['name'];
							            
							          $query10 = "select * from r_quot_item where vch='$vch' AND group_name='$group_title2' order by display_order ASC"; 
							            
							            $result10=$this->Common_Model->db_query($query10);
							      
							              if ($result10) {
							                 
							                      
							$output.='
							<center><h4><b>'.$group_title2.'</h4><h4>'.$result10[0]['name'].'</h4></center>
							        <div class="table-responsive">
							          <table class="table  table-bordered">
							            <thead>
							                  <tr>
							                    <th style="text-align: center;">Sl No. </th>
							                    <th style="text-transform: uppercase;text-align: center;">Description</th>
							                    <th style="text-transform: uppercase;text-align: center;">Qty.</th>
							                    <th style="text-transform: uppercase;text-align: center;">UOM</th>
							                    <th style="text-transform: uppercase;text-align: center;">Rate</th>
							                    <th style="text-transform: uppercase;text-align: center;">Amount</th>
							                  </tr>
							            </thead>
							            <tbody>
							    ';
							  
							        $sl=0;
							            $sum1=0;
							    foreach($result10 as $key => $row10){
							         $sl++;
							             $sum1+=$row10['amount'];
							        $output .= '
							              <tr>
							                <td>'.$sl.'</td>
							                <td>
							                  '.$row10['item'].'<br>
							                  Item Code : &nbsp;&nbsp;'.$row10['code'].'<br>
							                  <hr style="margin: 0px">
							                   '.$row10['des'].'
							                </td>
							                <td>'.$row10['qty'].'</td>
							                <td>'.$row10['unit'].'</td>
							                   
							                <td> '.price_format($rate1=$row10['amount']/$row10['qty']).'</td>
							                  
							                <td> '.price_format($row10['amount']).'</td>
							            </tr>
							            ';
							          }
							           $output .= '
							           <tr>
							            <td colspan="5"><p style="float: left;margin: 0px;font-size: 19px;font-weight: 600">Total Price</p></td>
							            <td style="font-size: 18px;font-weight: 600">'.price_format($sum1).'</td>
							           </tr>
							            </tbody>
							           <tbody>
							          </table>
							         </div>
							          ';
							            } 
							        }
							           $output .= '

							    <div class="row">
							      <div class="col-md-12">
							        <center><h3>3. Commercial Terms</h3></center>
							      ';
							          $query11="select * from `r_quotation` where vch='$vch' ";
							          
							          $result11=$this->Common_Model->db_query($query11);
							          foreach($result11 as $key => $row11){
							          $output .= '
							            <center><h6 style="font-weight: 600;font-size: 18px;letter-spacing: 1px">  '.$row11['groups'].'
							        
							            </h6></center>
							                    <div class=" table-responsive" style="background-color: #fff">
							                      <table class="table tb table-bordered" style="margin-bottom: 0px">
							                        <tbody>
							                          <tr>
							                            <td style="font-weight: 500;color: #000 !important;font-size: 14px;"> DELIVERY PERIOD</td>
							                            <td>'.$row11['commercial_terms1'].'</td>
							                           </tr>
							                          <tr>
							                            <td  style="font-weight: 500;color: #000 !important;font-size: 14px;">PRICE</td>
							                             <td>'.$row11['commercial_terms2'].'</td>
							                           </tr>
							                           <tr>
							                            <td  style="font-weight: 500;color: #000 !important;font-size: 14px;">GST</td>
							                             <td>'.$row11['commercial_terms3'].'</td>
							                           </tr>
							                            <tr>
							                            <td  style="font-weight: 500;color: #000 !important;font-size: 14px;">PACKING & FORWARDING</td>
							                             <td>'.$row11['commercial_terms4'].'</td>
							                           </tr>
							                            <tr>
							                            <td  style="font-weight: 500;color: #000 !important;font-size: 14px;">TRANSIT INSURANCE</td>
							                             <td>'.$row11['commercial_terms5'].'</td>
							                           </tr>
							                           <tr>
							                            <td  style="font-weight: 500;color: #000 !important;font-size: 14px;">LOADING & UNLOADING</td>
							                             <td>'.$row11['commercial_terms10'].'</td>
							                           </tr>
							                           <tr>
							                            <td  style="font-weight: 500;color: #000 !important;font-size: 14px;">MISCELLANEOUS</td>
							                             <td>'.$row11['commercial_terms11'].'</td>
							                           </tr>
							                            <tr>
							                            <td  style="font-weight: 500;color: #000 !important;font-size: 14px;">FREIGHT</td>
							                             <td>'.$row11['commercial_terms6'].'</td>
							                           </tr>
							                            <tr>
							                            <td  style="font-weight: 500;color: #000 !important;font-size: 14px;">PAYMENT TERMS</td>
							                             <td>'.$row11['commercial_terms7'].'</td>
							                           </tr>
							                            <tr>
							                            <td  style="font-weight: 500;color: #000 !important;font-size: 14px;">QUOTATION VALIDITY</td>
							                             <td>'.$row11['commercial_terms8'].'</td>
							                           </tr>
							                            <tr>
							                            <td  style="font-weight: 500;color: #000 !important;font-size: 14px;">WARRANTY</td>
							                             <td>'.$row11['commercial_terms9'].'</td>
							                           </tr>
							                        </tbody>
							                      </table>
							                      </div>
							                ';
							            
							        }
							           $output .= '
							 
							    </div>
							    <div class="col-md-12">
							     <span> This warrantee does not apply to system after commissioning, are determined to have been damaged due to neglect, abuse, overloading, mis-handling, accident or improper use. </span><br>
							     <span>There is not any Warrantee applicable for Electrical & electronic components.</span>
							    </div>
							  </div> 
							    ';
							     $query12="select * from `r_quotation` where vch='$vch' ";
							          
							          $result12=$this->Common_Model->db_query($query12);
							          $row12 = $result12[0];
							     $output .= '
							    <div class="row">
							      <div class="col-md-12">
							       <center><h3>4. EXCLUSIONS</h3></center>
							<p style="line-height: 28px;white-space: pre-wrap;">
							> '.$row12['exc1'].'<br>
							> '.$row12['exc2'].'<br>
							> '.$row12['exc3'].'<br>
							> '.$row12['exc4'].'<br>
							> '.$row12['exc5'].'<br>
							> '.$row12['exc6'].'<br>
							> '.$row12['exc7'].'<br>
							> '.$row12['exc8'].'<br>
							> '.$row12['exc9'].'<br>
							> '.$row12['exc10'].'<br>
							> '.$row12['exc11'].'</p>
							        



							       <span id="red" style="color: red">
							         Thanking you and assuring you of our best services at all times.<br>
							         Should you need any more information, please feel free to contact us.
							       </span>

							';
							           $query13="select * from `r_quotation` where vch='$vch' ";
							            
							            $result13=$this->Common_Model->db_query($query12);
							            $row13 = $result13[0];
							            
							              $a_userid=$row13['c_id'];
							                    $query14="select * from `users` where user_id='$a_userid' ";
							                    
							                    $result14=$this->Common_Model->db_query($query14);
							                    $row14 =$result14[0];
							                    $name=$row14['firstname'].' '.$row14['lastname'];
							                    $mno=$row14['userphone'];
							                    $userid=$row14['user_id'];
							                    $email=$row14['useremail'];
							             

							 $output .= '
							       <p style="text-align:  right">Thanks & Regards<br>
							                                     For Glosent India Private Limited<br>
							        <br>
							       '.$userid.' <br>

							       '.$name.' <br>

							       Mob. No. '.$mno.' 

							       </p>

							       <center><span id="red" style="font-size: 11px;color: red; ">This is Computer-Generated Document ,Hence No Signature Required</span></center>
							       </div>
							       </div>



							        </div>
							      </div>
							    </div>
							  </div>
							</div>

							</div>
							</body>
							</html>
							 ';
							  return $output;

	}
	
	function fetch_customer_dataenq($id){
 					$id=$id;
					 $query = "SELECT * FROM enquiry where id='$id' ";
					 $result = $this->Common_Model->db_query($query);
					 $row = $result[0];
					  $vch=$row['vch'];
					  $narration=$row['narration'];



					$party_code=$row['party_code'];
					$query1 = "SELECT * FROM ledgers where ledger_alias='$party_code' ";
					$result1=$this->Common_Model->db_query($query1);
					 $row1 = $result1[0];

					$query3 = "SELECT * FROM enquiry_items  where vch='$vch'  order by name ASC ";
					
					$result3=$this->Common_Model->db_query($query3);
					 foreach($result3 as $key => $row3)
					 $group=$row3['group_name'];


					$query4 = "SELECT * FROM enquiry_items  where vch='$vch' group by  group_name ";
					$result4=$this->Common_Model->db_query($query4);
				
	              $output='
							<html>
							<head>
							</head>
							<body style="font-family: Helvetica Neue, Helvetica, Arial, sans-serif;">
							<div class="book" >
							    <div class="page">
							        <div class="subpage pageborder">
							<div class="container"
							<div class="row">
							  <div class="col-md-12">
							    <img src="./assets/glosent_logo.png" style="height: auto;width: 80px;float: right;">

							  </div>
							</div>
							
							
							<div class="row">
							   <div class="col-md-2"></div>
							   <div class="col-md-8">
							      <center style="line-height:18px;">
							       <h2 style="">TECHNO-COMMERCIAL OFFER</h2>
							       <h3>'.$narration.'</h3>
							     </center>
							   </div>
							   <div class="col-md-2"></div>
							</div>
							<div class="row">
							  <div class="col-md-4">
							    <p>Enquiry Date : '. date('d-F-Y',strtotime($row['date'])).'</p>
							  </div>
							  <div class="col-md-4"> 
							    <center>
							    <h3 style="margin-bottom: 0px;margin-top: -5px;font-size: 25px"></h3>
							       <p class="line"></p>
							     </center>
							  </div>
							  <div class="col-md-4">
							   <p style="text-align: right;">Enquiry No : '.$row['vch'].'</p> 
							  </div>
							</div>
							 ';
							 foreach($result4 as $row4)
							 
							 
							  $output .='
							  <div class="row">
							   <div class="col-md-12">
							   <p>  <i class="fa fa-check-square-o " aria-hidden="true" style="font-size: 16px;font-weight: 300 !important;color:#2196f3  !important"></i>  '.$row4['name'].'</p>
							   </div>
							  </div>
							  ';

							 $output .= '
							 <div class="row vv">
							    <div class="col-md-12">
							      <center>
							        <h3 style="margin-bottom: 0px">GLOSENT INDIA PRIVATE LIMITED</h3>
							        <p id="red" style="color: red;margin-bottom: 0px">(AN ISO 9001-2015 CERTIFIED COMPANY)</p>
							        <p style="margin-bottom: 0px">CIN: U74140OR2014PTC018128</p>
							        <p style="margin-bottom: 0px">Contact Person : '.$row['name'].' </p>
							        <p style="margin-bottom: 0px">Mobile No : '.$row['mno'].' </p>
							        <h5 style="color:green !important;margin-bottom: 0px"><u>REGISTERED OFFICE</u></h5>
							        <p style="margin-bottom: 0px">Plot No-6/1124, Ranasinghpur, AIIMS Hospital Road,</p>
							        <p style="margin-bottom: 0px">Behind Biju Patnaik State Police Academy,</p>
							        <p style="margin-bottom: 0px">Bhubaneswar, Odisha, INDIA, 751019</p>
							        <h5 style="color: green;margin-bottom: 0px"><u>MANUFACTURING UNIT</u></h5>
							        <p style="margin-bottom: 0px">Gat No-1532, Jyotiba Nagar, Talawade, Pune<br>Maharashtra, INDIA, 411062</p>
							        <h5 style="color: green;margin-bottom: 0px"><u>REGIONAL OFFICE</u></h5>
							        <p style="margin-bottom: 0px">PUNE || DELHI || JAIPUR || CALCUTTA || VISAKHAPATNAM</p>
							      </center>
							    </div>
							   </div>
							  </div>

							 </div>    
							</div>
							<div class="page">
							        <div class="subpage pageborder">
							    <div class="container">
								<div class="row">
								  <div class="col-md-12">
								    <img src="./assets/glosent_logo.png" style="height: auto;width: 80px;float: right;">
								  </div>
								</div>
							   <div class="row">
							    <div class="col-md-2"></div>
							    <div class="col-md-10">
							     <center><h2><u><b>INDEX</b></u></h2></center>
							      <h3>1.&nbsp;&nbsp;About GLOSENT</h3><br>
							      <h3>2.&nbsp;&nbsp;Scope of Requirement</h3><br>
							      <h3>3.&nbsp;&nbsp;Commercial Terms</h3><br>
							      <h3>4.&nbsp;&nbsp;Exclusions</h3>
							    </div>
							    </div>
							  </div>
							</div>
							</div>

							<div class="page">
							        <div class="subpage pageborder">
							    <div class="container">
									<div class="row">
									  <div class="col-md-12">
									    <img src="./assets/glosent_logo.png" style="height: auto;width: 80px;float: right;">
									  </div>
									</div>
							<div class="row">
							  <div class="col-md-12">
							    <center><h2><b>1. ABOUT GLOSENT</b></h2></center>
							    <p class="text-justify" style="font-size: 16px">We are GLOSENT INDIA PRIVATE LIMITED engaged in LPG (Liquefied Petroleum Gas) and NG
							      (Natural Gas) Gas Pipeline Installation, Fabrication and Testing Services in pan India.<br>
							      Being a front runner in the industry, we are involved in providing our customers highly
							      qualitative Thermal Engineering Services. We seamlessly integrate design solutions with existing
							      product development cycles through flexible engagement models and steer the organization towards
							      reaching their manufacturing goals on time.<br>
							      We are a team of technically competent professionals. We update our knowledge, systems, equipment
							      and materials to enable us to deliver superior products, that are economical, safe and on schedule. We
							      have always maintained a standard that meets the optimum expectation of our customers and it has
							      helped us gain a long-term relationship of commitment and integrity with them. </p>
							        </div>
							        </div>
							        <center><h2><b><span id="yellow" style="color:orange">V</span>ISION</b></h2></center>
							      <div class="row">
							        <div class="col-md-12">
							          <p class="text-justify" style="font-size: 16px">To be leading service and solution provider in Plant Design Engineering globally and to set new benchmark for innovation and service quality.
							    </p>
							  </div>
							</div>

							<div class="row">
							  <div class="col-md-12">
							  <center><h2><b><span id="yellow" style="color:orange">M</span>ISSION</b></h2></center>
							    <p class="text-justify" style="font-size: 16px">To passionately innovate what is essential to growth of our customer and create value to the customer by providing exceptionally competitive products and services.
							    </p>
							  </div>
							</div>
							<div class="row">
							  <div class="col-md-12">
							  <center><h2><b><span id="yellow" style="color:orange">V</span>ALUES</b></h2></center>
							    <p class="text-justify" style="font-size: 16px">Our values are the firm foundations upon which we build our mission.</p>
							    <p class="text-justify" style="font-size: 16px"><b>Integrity</b> :  The courage to maintain the right from the wrong without compromise.</p>
							    <p class="text-justify" style="font-size: 16px"><b>Reliability</b> : The ability to deliver on what we promise, without any exception.</p>
							    <p class="text-justify" style="font-size: 16px"><b>Accountability</b> : The strength to be responsible for our actions and decisions.</p>
							  </div>
							</div>
							<div class="row">
							  <div class="col-md-12">
							  <center><h2><b><span id="yellow" style="color:orange">O</span>UR GOALS</b></h2></center>
							    <p class="text-justify" style="font-size: 16px">Our goals are specific and well-defined, which is why our services too are extremely focused and objective.</p>
							    <p class="text-justify" style="font-size: 16px"><i class="fa fa-circle-thin" style="font-size: 8px"></i>&nbsp;&nbsp;To facilitate top quality services
							      <i class="fa fa-circle-thin" style="font-size: 8px"></i>&nbsp;&nbsp;To work with a few, but delighted clients
							      <i class="fa fa-circle-thin" style="font-size: 8px"></i>&nbsp;&nbsp;To make useful contributions to health, safety and environment
							      <i class="fa fa-circle-thin" style="font-size: 8px"></i>&nbsp;&nbsp;Facilitate environment-friendly and durable products
							      <i class="fa fa-circle-thin" style="font-size: 8px"></i>&nbsp;&nbsp;Nurture strong relationship with our clients, based on trustworthiness, and timely feedback  and updates.
							    </p>
							    </div>
							  </div>

							  </div>
							 </div>    
							</div>
							<div class="page">
							        <div class="subpage pageborder">
							    <div class="container">
							    <div class="row">
								  <div class="col-md-12">
								    <img src="./assets/glosent_logo.png" style="height: auto;width: 80px;float: right;">
								  </div>
								</div>
							    <div class="row">
							      <div class="col-md-12">
							        <center><h3><b>WHAT WE DO AND WHY YOU SHOULD, TOO</b></h3></center>
							        <p class="text-justify" style="font-size: 16px">You may not realize or think about how a company like <b>GLOSENT</b> can impact your daily life. We are providing numbers of Products & Services like,</p>
							        <h5 style="color: red" id="red">1. DOWNSTREAM PIPELINE</h5>
							        <p>
							          <i class="fa fa-circle-thin" style="font-size: 8px"></i>&nbsp;&nbsp;Piped Natural Gas (PNG)
							        </p>
							        <h5 style="color: red;margin-bottom:0px !important;" id="red">2. LPG INSTALLATIONS</h5>
							        <p>
							          <i class="fa fa-circle-thin" style="font-size: 8px"></i>&nbsp;&nbsp;LPG Supply<br>
							          <i class="fa fa-circle-thin" style="font-size: 8px"></i>&nbsp;&nbsp;LOT (Liquid Off Take)<br>
							          <i class="fa fa-circle-thin" style="font-size: 8px"></i>&nbsp;&nbsp;VOT (Vapor Off Take)<br>
							          <i class="fa fa-circle-thin" style="font-size: 8px"></i>&nbsp;&nbsp;Leak Detectors<br>
							          <i class="fa fa-circle-thin" style="font-size: 8px"></i>&nbsp;&nbsp;LPG Bullets<br>
							          <i class="fa fa-circle-thin" style="font-size: 8px"></i>&nbsp;&nbsp;LPG / Propane Vaporisers
							        </p>
							        <h5 style="color: red;margin-bottom:0px !important;" id="red">3. THERMAL ENGINEERING</h5>
							        <p>
							          <i class="fa fa-circle-thin" style="font-size: 8px"></i>&nbsp;&nbsp;Fuel Conversions from other fuels to LPG / NG<br>
							          <i class="fa fa-circle-thin" style="font-size: 8px"></i>&nbsp;&nbsp;Boiler Installation (IBR / NON IBR)<br>
							          <i class="fa fa-circle-thin" style="font-size: 8px"></i>&nbsp;&nbsp;Solar Steam Projects<br>
							          <i class="fa fa-circle-thin" style="font-size: 8px"></i>&nbsp;&nbsp;Thermic Fluid Heater<br>
							          <i class="fa fa-circle-thin" style="font-size: 8px"></i>&nbsp;&nbsp;Hot Water Generators (Shell & Tube / Coil Type)
							        </p>
							        <h5 style="color: red;margin-bottom:0px !important;" id="red">4. UTILITY ENGINEERING</h5>
							        <p>
							          <i class="fa fa-circle-thin" style="font-size: 8px"></i>&nbsp;&nbsp;All Types of Industrial Gases<br>
							          <i class="fa fa-circle-thin" style="font-size: 8px"></i>&nbsp;&nbsp;Flammable Gases (LPG, PNG)<br>
							          <i class="fa fa-circle-thin" style="font-size: 8px"></i>&nbsp;&nbsp;Toxic Gases (Methanol, Ammonia)<br>
							          <i class="fa fa-circle-thin" style="font-size: 8px"></i>&nbsp;&nbsp;Compressed Air Piping<br>
							          <i class="fa fa-circle-thin" style="font-size: 8px"></i>&nbsp;&nbsp;Oil Piping (Thermic Oil, Diesel, F.O. etc.)<br>
							          <i class="fa fa-circle-thin" style="font-size: 8px"></i>&nbsp;&nbsp;Piping Works (Steam, Condensate, Chilled / Hot Water)
							        </p>
							        <h5 style="color: red;margin-bottom:0px !important;" id="red">5. STRUCTURAL FABRICATIONS</h5>
							        <p>
							          <i class="fa fa-circle-thin" style="font-size: 8px"></i>&nbsp;&nbsp;Pipe Rack / Primary Support<br>
							          <i class="fa fa-circle-thin" style="font-size: 8px"></i>&nbsp;&nbsp;Mezzanine Floor / Platform<br>
							          <i class="fa fa-circle-thin" style="font-size: 8px"></i>&nbsp;&nbsp;Stair Case & Ladders<br>
							          <i class="fa fa-circle-thin" style="font-size: 8px"></i>&nbsp;&nbsp;Industrial Shed
							        </p>
							        <h5 style="color: red;margin-bottom:0px !important;" id="red">6. EQUIPMENT FABRICATION</h5>
							        <p>
							          <i class="fa fa-circle-thin" style="font-size: 8px"></i>&nbsp;&nbsp;Exhaust Hood<br>
							          <i class="fa fa-circle-thin" style="font-size: 8px"></i>&nbsp;&nbsp;Chimney<br>
							          <i class="fa fa-circle-thin" style="font-size: 8px"></i>&nbsp;&nbsp;Water Tanks, Expansion Tank<br>
							          <i class="fa fa-circle-thin" style="font-size: 8px"></i>&nbsp;&nbsp;Reactors / Pressure Vessels
							        </p>
							        <h5 style="color: red;margin-bottom:0px !important;" id="red">7. ENGINEERING DOCUMENTATION</h5>
							        <p>
							          <i class="fa fa-circle-thin" style="font-size: 8px"></i>&nbsp;&nbsp;Project specifications<br>
							          <i class="fa fa-circle-thin" style="font-size: 8px"></i>&nbsp;&nbsp;Engineering standards<br>
							          <i class="fa fa-circle-thin" style="font-size: 8px"></i>&nbsp;&nbsp;Energy Audits<br>
							          <i class="fa fa-circle-thin" style="font-size: 8px"></i>&nbsp;&nbsp;Technical calculations<br>
							          <i class="fa fa-circle-thin" style="font-size: 8px"></i>&nbsp;&nbsp;Flow diagrams
							        </p>
							      </div>
							    </div>
							    </div>
							</div>
							</div>

							<div class="page">
							        <div class="subpage pageborder">
							    <div class="container">
							    <div class="row">
								  <div class="col-md-12">
								    <img src="./assets/glosent_logo.png" style="height: auto;width: 80px;float: right;">
								  </div>
								</div>
							      <div class="row">
							        <div class="col-md-12">
							        <center><h3> 2. SCOPE OF REQUIREMENT </h3></center>';
							   


							          $query9="select * from `catgroup` ";
							          
							          $result9=$this->Common_Model->db_query($query9);
							          foreach($result9 as $key => $row9){
							            $group_title2=$row9['group_title'];  
							            $name2=$row9['name'];
							            
							          $query10 = "select * from enquiry_items where vch='$vch' AND group_name='$group_title2' order by display_order ASC"; 
							            
							            $result10=$this->Common_Model->db_query($query10);
							      
							              if ($result10) {
							                 
							                      
							$output.='
							<center><h4><b>'.$group_title2.'</h4><h4>'.$result10[0]['name'].'</h4></center>
							        <div class="table-responsive">
							          <table class="table  table-bordered">
							            <thead>
							                  <tr>
							                    <th style="text-align: center;">Sl No. </th>
							                    <th style="text-transform: uppercase;text-align: center;">Description</th>
							                    <th style="text-transform: uppercase;text-align: center;">Qty.</th>
							                    <th style="text-transform: uppercase;text-align: center;">UOM</th>
							                    
							                  </tr>
							            </thead>
							            <tbody>
							    ';
							  
							        $sl=0;
							            $sum1=0;
							    foreach($result10 as $key => $row10){
							         $sl++;
							             $sum1+=$row10['amount'];
							        $output .= '
							              <tr>
							                <td>'.$sl.'</td>
							                <td>
							                  '.$row10['item'].'<br>
							                  Item Code : &nbsp;&nbsp;'.$row10['code'].'<br>
							                  <hr style="margin: 0px">
							                   '.$row10['des'].'
							                </td>
							                <td>'.$row10['qty'].'</td>
							                <td>'.$row10['unit'].'</td>
							            </tr>
							            ';
							          }
							           $output .= '
							           
							            </tbody>
							           <tbody>
							          </table>
							         </div>
							          ';
							            } 
							        }
							           $output .= '

							    <div class="row">
							      <div class="col-md-12">
							        <center><h3>3. Commercial Terms</h3></center>
							      ';
							          $query11="select * from `enquiry_terms` where vch='$vch' ";
							          
							          $result11=$this->Common_Model->db_query($query11);
							          foreach($result11 as $key => $row11){
							          $output .= '
							            <center><h6 style="font-weight: 600;font-size: 18px;letter-spacing: 1px">  '.$row11['groups'].'
							        
							            </h6></center>
							                    <div class=" table-responsive" style="background-color: #fff">
							                      <table class="table tb table-bordered" style="margin-bottom: 0px">
							                        <tbody>
							                          <tr>
							                            <td style="font-weight: 500;color: #000 !important;font-size: 14px;"> DELIVERY PERIOD</td>
							                            <td>'.$row11['commercial_terms1'].'</td>
							                           </tr>
							                          <tr>
							                            <td  style="font-weight: 500;color: #000 !important;font-size: 14px;">PRICE</td>
							                             <td>'.$row11['commercial_terms2'].'</td>
							                           </tr>
							                           <tr>
							                            <td  style="font-weight: 500;color: #000 !important;font-size: 14px;">GST</td>
							                             <td>'.$row11['commercial_terms3'].'</td>
							                           </tr>
							                            <tr>
							                            <td  style="font-weight: 500;color: #000 !important;font-size: 14px;">PACKING & FORWARDING</td>
							                             <td>'.$row11['commercial_terms4'].'</td>
							                           </tr>
							                            <tr>
							                            <td  style="font-weight: 500;color: #000 !important;font-size: 14px;">TRANSIT INSURANCE</td>
							                             <td>'.$row11['commercial_terms5'].'</td>
							                           </tr>
							                           <tr>
							                            <td  style="font-weight: 500;color: #000 !important;font-size: 14px;">LOADING & UNLOADING</td>
							                             <td>'.$row11['commercial_terms10'].'</td>
							                           </tr>
							                           <tr>
							                            <td  style="font-weight: 500;color: #000 !important;font-size: 14px;">MISCELLANEOUS</td>
							                             <td>'.$row11['commercial_terms11'].'</td>
							                           </tr>
							                            <tr>
							                            <td  style="font-weight: 500;color: #000 !important;font-size: 14px;">FREIGHT</td>
							                             <td>'.$row11['commercial_terms6'].'</td>
							                           </tr>
							                            <tr>
							                            <td  style="font-weight: 500;color: #000 !important;font-size: 14px;">PAYMENT TERMS</td>
							                             <td>'.$row11['commercial_terms7'].'</td>
							                           </tr>
							                            <tr>
							                            <td  style="font-weight: 500;color: #000 !important;font-size: 14px;">QUOTATION VALIDITY</td>
							                             <td>'.$row11['commercial_terms8'].'</td>
							                           </tr>
							                            <tr>
							                            <td  style="font-weight: 500;color: #000 !important;font-size: 14px;">WARRANTY</td>
							                             <td>'.$row11['commercial_terms9'].'</td>
							                           </tr>
							                        </tbody>
							                      </table>
							                      </div>
							                ';
							            
							        }
							           $output .= '
							 
							    </div>
							    <div class="col-md-12">
							     <span> This warrantee does not apply to system after commissioning, are determined to have been damaged due to neglect, abuse, overloading, mis-handling, accident or improper use. </span><br>
							     <span>There is not any Warrantee applicable for Electrical & electronic components.</span>
							    </div>
							  </div> 
							    ';
							     $query12="select * from `enquiry` where vch='$vch' ";
							          
							          $result12=$this->Common_Model->db_query($query12);
							          $row12 = $result12[0];
							     $output .= '
							    <div class="row">
							      <div class="col-md-12">
							       <center><h3>4. EXCLUSIONS</h3></center>
							<p style="line-height: 28px;white-space: pre-wrap;">
							> '.$row12['exc1'].'<br>
							> '.$row12['exc2'].'<br>
							> '.$row12['exc3'].'<br>
							> '.$row12['exc4'].'<br>
							> '.$row12['exc5'].'<br>
							> '.$row12['exc6'].'<br>
							> '.$row12['exc7'].'<br>
							> '.$row12['exc8'].'<br>
							> '.$row12['exc9'].'<br>
							> '.$row12['exc10'].'<br>
							> '.$row12['exc11'].'</p>
							        



							       <span id="red" style="color: red">
							         Thanking you and assuring you of our best services at all times.<br>
							         Should you need any more information, please feel free to contact us.
							       </span>

							';
							           $query13="select * from `enquiry` where vch='$vch' ";
							            
							            $result13=$this->Common_Model->db_query($query12);
							            $row13 = $result13[0];
							            
							              $a_userid=$row13['c_id'];
							                    $query14="select * from `users` where user_id='$a_userid' ";
							                    
							                    $result14=$this->Common_Model->db_query($query14);
							                    $row14 =$result14[0];
							                    $name=$row14['firstname'].' '.$row14['lastname'];
							                    $mno=$row14['userphone'];
							                    $userid=$row14['user_id'];
							                    $email=$row14['useremail'];
							             

							 $output .= '
							       <p style="text-align:  right">Thanks & Regards<br>
							                                     For Glosent India Private Limited<br>
							       '.$userid.' <br>

							       '.$name.' <br>

							       Mob. No. '.$mno.' 

							       </p>

							       <center><span id="red" style="font-size: 11px;color: red; ">This is Computer-Generated Document ,Hence No Signature Required</span></center>
							       </div>
							       </div>



							        </div>
							      </div>
							    </div>
							  </div>
							</div>

							</div>
							</body>
							</html>
							 ';
							  return $output;

	}
}
