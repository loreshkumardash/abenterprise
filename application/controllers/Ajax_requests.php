<?php
error_reporting(0);
defined('BASEPATH') OR exit('No direct script access allowed');

class Ajax_requests extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->perPage = 10;
		//is_logged_in();
		date_default_timezone_set('Asia/Kolkata');
	}
	
	function Item_select_option(){
		$records = $this->Common_Model->FetchData("item ", "*","name LIKE '%".$_GET['q']."%' GROUP BY id");
		$json = [];
		if($records){
			$j=1;
			for($i=0;$i<count($records);$i++){
				$json[] = ['id'=>$records[$i]['id'], 'text'=>$records[$i]['name'].','.$records[$i]['code']];
			}
		}
		echo json_encode($json);
		die();
	}

	function get_subject_option(){
		$records = $this->Common_Model->FetchData("subjects", "*", "class_id = '".$this->input->post("class_id")."' ORDER BY subject_name ASC");
		$html = '<option value="">select</option>';
		if($records){
			for($i=0;$i<count($records);$i++){
				$html.= '<option value="'.$records[$i]['subject_id'].'">'.$records[$i]['subject_name'].'</option>';
			}
		}
		$this->db->close();
		echo $html;
		die(0);
	}

	function get_chapter_option(){
		$records = $this->Common_Model->FetchData("chapters", "*", "subject_id = '".$this->input->post("subject_id")."' ORDER BY chapter_name ASC");
		$html = '<option value="">select</option>';
		if($records){
			for($i=0;$i<count($records);$i++){
				$html.= '<option value="'.$records[$i]['chapter_id'].'">'.$records[$i]['chapter_name'].'</option>';
			}
		}
		$this->db->close();
		echo $html;
		die(0);
	}

	function get_category_options_by_shop_id(){
		$records = $this->Common_Model->FetchData("categories", "*", "shop_id = '".$this->input->post("shop_id")."' AND category_status = 'Active' AND delete_status = 0 ORDER BY category_name ASC");
		$html = '<option value="">select</option>';
		if($records){
			for($i=0;$i<count($records);$i++){
				$html.= '<option value="'.$records[$i]['category_id'].'">'.$records[$i]['category_name'].'</option>';
			}
		}
		$this->db->close();
		echo $html;
		die(0);
	}

	function get_subcategory_options(){
		$records = $this->Common_Model->FetchData("categories_sub", "*", "category_id = '".$this->input->post("category_id")."' AND subcategory_status = 'Active' AND delete_status = 0 ORDER BY subcategory_name ASC");
		$html = '<option value="">select</option>';
		if($records){
			for($i=0;$i<count($records);$i++){
				$html.= '<option value="'.$records[$i]['subcategory_id'].'">'.$records[$i]['subcategory_name'].'</option>';
			}
		}
		$this->db->close();
		echo $html;
		die(0);
	}

	function get_item_info_by_bin(){
		$records = $this->Common_Model->FetchData("items", "*", "BIN = '".$this->input->post("bin_no")."'");
		if($records){
			$arr = array("item_present" => 1, "item_id" => $records[0]['id'], "item_stock" => $records[0]['QTY_STOCK'], "item_description" => 'Code - '.$records[0]['ITEM_CODE'].'</br>DESC - '.$records[0]['DESC'].'</br>Rate - '.$records[0]['RATE'].'</br>Stock: '.$records[0]['QTY_STOCK']);
			$this->db->close();
			echo json_encode($arr);
		}else{
			$this->db->close();
			echo json_encode(array("item_present" => 0));
		}
	}

	function updateexamtime(){
		$this->Common_Model->db_query("UPDATE exams_result SET updated_on = '".date("Y-m-d H:i:s")."', exam_time_taken = '".$_POST['timetaken']."' WHERE exam_id = '".$_POST['examid']."' AND student_id = '".$this->session->userdata("student_id")."'");
		$this->db->close();
		echo 'time saved';
	}

	function saveandnext(){
		$chk = $this->Common_Model->FetchData("exams_evaluation", "exam_id = '".$_POST['examid']."' AND student_id = '".$this->session->userdata("student_id")."' AND question_id = '".$_POST['questionid']."'");
		if($chk){
			$this->Common_Model->db_query("UPDATE exams_evaluation SET status = 'answered', timetaken = '".$_POST['timetaken']."', question_answer = '".$_POST['answer']."' WHERE exam_id = '".$_POST['examid']."' AND student_id = '".$this->session->userdata("student_id")."' AND question_id = '".$_POST['questionid']."'");
		}else{
			$this->Common_Model->db_query("INSERT INTO exams_evaluation SET status = 'answered', timetaken = '".$_POST['timetaken']."', question_answer = '".$_POST['answer']."', exam_id = '".$_POST['examid']."', student_id = '".$this->session->userdata("student_id")."', question_id = '".$_POST['questionid']."'");
		}
		$this->db->close();
		echo 'saved';
	}


	function saveandnextun(){
		if($this->Common_Model->FetchRows("exams_evaluation", "exam_id = '".$_POST['examid']."' AND student_id = '".$this->session->userdata("student_id")."' AND question_id = '".$_POST['questionid']."'")){
			$this->Common_Model->db_query("UPDATE exams_evaluation SET status = 'notAnswered', timetaken = '".$_POST['timetaken']."', question_answer = '' WHERE exam_id = '".$_POST['examid']."' AND student_id = '".$this->session->userdata("student_id")."' AND question_id = '".$_POST['questionid']."'");
		}else{
			$this->Common_Model->db_query("INSERT INTO exams_evaluation SET status = 'notAnswered', timetaken = '".$_POST['timetaken']."', question_answer = '', exam_id = '".$_POST['examid']."', student_id = '".$this->session->userdata("student_id")."', question_id = '".$_POST['questionid']."'");
		}
		$this->db->close();
		echo 'saved';
	}

	function saveandmark(){
		if($this->Common_Model->FetchRows("exams_evaluation", "exam_id = '".$_POST['examid']."' AND student_id = '".$this->session->userdata("student_id")."' AND question_id = '".$_POST['questionid']."'")){
			$this->Common_Model->db_query("UPDATE exams_evaluation SET status = 'markedForRiview', timetaken = '".$_POST['timetaken']."', question_answer = '".$_POST['answer']."' WHERE exam_id = '".$_POST['examid']."' AND student_id = '".$this->session->userdata("student_id")."' AND question_id = '".$_POST['questionid']."'");
		}else{
			$this->Common_Model->db_query("INSERT INTO exams_evaluation SET status = 'markedForRiview', timetaken = '".$_POST['timetaken']."', question_answer = '".$_POST['answer']."', exam_id = '".$_POST['examid']."', student_id = '".$this->session->userdata("student_id")."', question_id = '".$_POST['questionid']."'");
		}
		$this->db->close();
		echo 'saved';
	}

	function markandnext(){
		if($this->Common_Model->FetchRows("exams_evaluation", "exam_id = '".$_POST['examid']."' AND student_id = '".$this->session->userdata("student_id")."' AND question_id = '".$_POST['questionid']."'")){
			$this->Common_Model->db_query("UPDATE exams_evaluation SET question_answer = '', status = 'marked', timetaken = '".$_POST['timetaken']."' WHERE exam_id = '".$_POST['examid']."' AND student_id = '".$this->session->userdata("student_id")."' AND question_id = '".$_POST['questionid']."'");
		}else{
			$this->Common_Model->db_query("INSERT INTO exams_evaluation SET status = 'marked', timetaken = '".$_POST['timetaken']."', exam_id = '".$_POST['examid']."', question_answer = '', student_id = '".$this->session->userdata("student_id")."', question_id = '".$_POST['questionid']."'");
		}
		$this->db->close();
		echo 'saved';
	}

	function endexam(){
		$examdata = $this->Common_Model->FetchData("exams", "*","exam_id = '".$_POST['examid']."' ");

		$noofques = $this->Common_Model->FetchRows("exams_question", "*", "exam_id = '".$examdata[0]['exam_id']."'");
		$right_answer=0;
		$wrong_answer=0;
		$unanswered=0;
		$correct_ques_id = '';
		$incorrect_ques_id = '';
		$unanswered_ques_id = '';
		
		$exam_positive_mark = 0;
		$exam_negative_mark = 0;
		$exam_total_mark = 0;
		$marks_secured = 0;
		$answersheet = '';
		$slno = 0;
		$i=1;

		$examresult = $this->Common_Model->FetchData("exams_result", "*", "exam_id = '".$examdata[0]['exam_id']."' AND student_id = '".$this->session->userdata("student_id")."'");

		$questions = $this->Common_Model->FetchData("exams_question AS ex LEFT JOIN questions AS q ON ex.question_id = q.q_id", "*", "ex.exam_id = '".$examdata[0]['exam_id']."'");
		for($i=0;$i<count($questions);$i++){
			$user_answer = '';
			$mark = 0;
			$user_answer = isset($_POST[$questions[$i]['q_id']]) ? $_POST[$questions[$i]['q_id']] : '';
			if($user_answer == $questions[$i]['correct_option']){
				$exam_positive_mark = $exam_positive_mark + (float)$examdata[0]['exam_positive_mark'];
				$question_status =1;
				$right_answer++;
			}
			elseif($user_answer == ''){
				$question_status = 2;
				$unanswered++;
			}
			else{
				$exam_negative_mark = $exam_negative_mark + (float)$examdata[0]['exam_negative_mark'];
				$question_status = 0;
				$wrong_answer++;
			}
			$exam_total_mark = $exam_total_mark + (float)$examdata[0]['exam_positive_mark'];
			$timetaken = $_POST['individualtimer'.$questions[$i]['q_id']];
			$this->Common_Model->db_query("UPDATE exams_evaluation SET question_status = $question_status, timetaken = '$timetaken', question_answer = '$user_answer', marks = '$mark' WHERE exam_id='".$examdata[0]['exam_id']."' AND question_id = '".$questions[$i]['q_id']."' AND student_id = '".$this->session->userdata("student_id")."'");
			
		}
		$exam_total_mark = round($exam_total_mark,2);
		$exam_negative_mark = round($exam_negative_mark,2);
		$marks_secured = $exam_positive_mark - $exam_negative_mark;
		$marks_secured = round($marks_secured,2);
		$percentage = $marks_secured/$exam_total_mark*100;
		$percentage = round($percentage, 2);
		$chk = $this->Common_Model->FetchData("exams_evaluation","*", "exam_id='".$examdata[0]['exam_id']."' AND student_id = '".$this->session->userdata("student_id")."' AND question_status = 0");
		if($chk){
			for($i=0;$i<count($chk);$i++){
				$incorrect_ques_id.= ($incorrect_ques_id == '')? $chk[$i]['question_id'] : ','.$chk[$i]['question_id'];
			}
		}
		$chk = $this->Common_Model->FetchData("exams_evaluation","*", "exam_id='".$examdata[0]['exam_id']."' AND student_id = '".$this->session->userdata("student_id")."' AND question_status = 1");
		if($chk){
			for($i=0;$i<count($chk);$i++){

				$correct_ques_id.= ($correct_ques_id == '')? $chk[$i]['question_id'] : ','.$chk[$i]['question_id'];
			}
		}
		$chk = $this->Common_Model->FetchData("exams_evaluation","*", "exam_id='".$examdata[0]['exam_id']."' AND student_id = '".$this->session->userdata("student_id")."' AND question_status = 2");
		if($chk){
			for($i=0;$i<count($chk);$i++){
				$unanswered_ques_id.= ($unanswered_ques_id == '')? $chk[$i]['question_id'] : ','.$chk[$i]['question_id'];
			}
		}

		$this->Common_Model->db_query("UPDATE exams_result SET `correct_ques` = '$correct_ques_id', `correct_no` = '$right_answer', `incorrect_ques` = '$incorrect_ques_id', `incorrect_no` = '$wrong_answer', `unattempted_ques` = '$unanswered_ques_id', `unattempted_no` = '$unanswered', `total_marks` = '$exam_total_mark', `scored_marks` = '$marks_secured', `scored_percentage` = '$percentage', `exam_status` = 'appeared' WHERE exam_id = '".$examdata[0]['exam_id']."' AND student_id = '".$this->session->userdata("student_id")."'");
		$this->db->close();
		echo 'success';exit;
	}
	
	function loadAllclass(){
		$classData = $this->Common_Model->FetchData("classes","class_id,class_name", "1=1 AND class_active = 'Active'");
		if(!empty($classData)){
			echo json_encode(array('status' => 200, 'result' => $classData));exit();
		}else{
			echo json_encode(array('status' => 500));exit();
		}
	}



	function loadsubJect(){
		$classId = ($this->input->post("classId") > 0)?$this->input->post("classId"):0;
		$contQur = '';
		if($classId > 0){
			$contQur = "class_id = ".$classId;
		}
		$records = $this->Common_Model->FetchData("subjects", "subject_id,subject_name", $contQur." ORDER BY subject_name ASC");
		if(!empty($records)){
			echo json_encode(array('status' => 200, 'result' => $records));exit();
		}else{
			echo json_encode(array('status' => 500));exit();
		}
	}


	function checkLeaveavail(){
		$leave_type = $this->input->post("leave_type");
		$employeeId = $this->input->post("employeeId");
		$curSession = $this->input->post("curSession");
		$apply_from = $this->input->post("apply_from");
		$apply_to 	= $this->input->post("apply_to");
		$hfday 		= $this->input->post("hfday");

		$mxdate = date('d-m-Y', strtotime("+1 day", strtotime($apply_to)));
		$maxdate  = strtotime($mxdate);
		$mdate  = strtotime($apply_to);
		$mindate  = strtotime($apply_from);

		if($mindate > $mdate){
			echo json_encode(array('status' => 500, 'msg' => 'Sorry From date can not be greater than to date'));exit();
		}
		$datediff = $maxdate - $mindate;

		$daysDiff =  round($datediff / (60 * 60 * 24));
		$diffday  = $daysDiff * $hfday;

		$totleave =  $this->Common_Model->db_query("SELECT SUM(no_of_days) AS totalleave FROM leave_application WHERE employee_id = ".$employeeId." AND session = '".$curSession."' AND leave_type='".$leave_type."'");
		if ($totleave[0]['totalleave']) {
			$leave = $totleave[0]['totalleave'];
		}else{
			$leave = 0;
		}

		$records = $this->Common_Model->db_query("SELECT A.leave_type,(A.leave_count-$leave) AS leaveleft FROM leave_master A LEFT JOIN leave_application B ON (A.leave_id = B.leave_type AND B.employee_id = ".$employeeId." AND B.session = '".$curSession."') WHERE A.leave_id = ".$leave_type." GROUP BY leave_id");
		if(!empty($records)){
			echo json_encode(array('status' => 200, 'result' => $records, 'daysDiff' => $diffday));exit();
		}else{
			echo json_encode(array('status' => 500));exit();
		}
	}


	function addHoliday(){
		$event_name = $this->input->post("event_name");
		$type = $this->input->post("type");
		$start_date = $this->input->post("start_date");
		$end_date = $this->input->post("end_date");
		$start_date =(strtotime($start_date) > 0)?date('Y-m-d',strtotime($start_date)):'';
		$end_date =(strtotime($end_date) > 0)?date('Y-m-d',strtotime($end_date)):'';
		$session = '';

		$data_list = array(
			'type'				=> $type,
			'name'				=> $event_name,
			'from_date'			=> $start_date,
			'to_date'			=> $end_date,
			'session'			=> $session
		);

		$records = $this->Common_Model->db_query("select COUNT(1) as cnt from holiday where type = '".$type."' and name ='".$event_name."' and from_date ='".$start_date."' and to_date ='".$end_date."' and session ='".$session."'");
		if($records[0]['cnt']==0){
			$holiday_id  = $this->Common_Model->dbinsertid("holiday", $data_list);
			if($holiday_id>0){
				echo json_encode(array('status' => 200,'uid' => $holiday_id));exit();
			}else{
				echo json_encode(array('status' => 500));exit();
			}
		}
	}

	function removeHoliday(){
		$id = $this->input->post("id");
		$this->Common_Model->DelData("holiday", "id = ".$id);
		echo json_encode(array('status' => 200));exit();
	}
	
	function loadMasterBank(){
		$banks = $this->Common_Model->FetchData("banks", "*");
		if(!empty($banks)){
			echo json_encode(array('status' => 200, 'res' => $banks));exit;
		}else{
			echo json_encode(array('status' => 500, 'msg' => 'Something went wrong.'));exit;
		}
	}

	

	function studentphnNo(){
		$id = $this->input->post("student_id");
		$students= $this->Common_Model->FetchData("students","student_id,student_mobile", "student_id=$id");
		//echo $students[0]['student_mobile'];exit;
		if(!empty($students)){
			echo json_encode(array('status' => 200, 'result' => $students));
		}else{
			echo json_encode(array('status' => 500));exit();
		}
	}

	

	function loadTaggedEmployee(){
		$requestData = $this->input->post();
		$subject_id  = $requestData['subjectId'];
		$data = array();
		//if($subject_id>0){
			$query = "SELECT emp.employee_id,emp.employee_name FROM teacher_class_subject_tag emptg inner join employees emp on emptg.teacher_id = emp.employee_id where 1=1 ";
			if($subject_id > 0){
				$query .= " AND emptg.subject_id = ".$subject_id;
			}
			$query .= " group by emp.employee_id ";
			//echo $query;exit;
			$employees = $this->db->query($query);

			$empData = $employees->result_array();
			if(!empty($empData)){
				foreach($empData as $row)
				{
					$data[]=$row;
				}
			}
		//}

		if(!empty($data)){
			echo json_encode(array('status' => 200, 'res' => $data));exit;
		}else{
			echo json_encode(array('status' => 500, 'msg' => 'Something went wrong.'));exit;
		}
	}

	function loadsection(){
		$requestData = $this->input->post();
		$classId  = $requestData['classId'];
		$data = array();
		if($classId>0){
			$sections = $this->db->query("SELECT * FROM sections where class_id = $classId");

			$empData = $sections->result_array();
			if(!empty($empData)){
				foreach($empData as $row)
				{
					$data[]=$row;
				}
			}
		}

		if(!empty($data)){
			echo json_encode(array('status' => 200, 'res' => $data));exit;
		}else{
			echo json_encode(array('status' => 500, 'msg' => 'Something went wrong.'));exit;
		}
	}

	function Getsection(){
		$requestData = $this->input->post();
		$classId  = $requestData['classId'];
		$data = array();
		if($classId>0){
			$sections = $this->db->query("SELECT * FROM sections where class_id = $classId");

			$empData = $sections->result_array();
			if(!empty($empData)){
				foreach($empData as $row)
				{
					$data[]=$row;
				}
			}
		}

		if(!empty($data)){
			echo json_encode(array('status' => 200, 'res' => $data));exit;
		}else{
			echo json_encode(array('status' => 500, 'msg' => 'Something went wrong.'));exit;
		}
	}


	  function get_TotalRooms(){
		$requestData = $this->input->post();
		$hostel_Id   = $requestData['hostel_id'];
		//print_r($requestData);exit;
		$unit  = array();
		if($hostel_Id>0){
			$unit = $this->Common_Model->FetchData("tbl_hostel", "*", "id = ".$hostel_Id);
		}

		if(!empty($unit)){
			echo json_encode(array('status' => 200, 'res' => $unit));exit;
		}else{
			echo json_encode(array('status' => 500, 'msg' => 'Something went wrong.'));exit;
		}
	}

	function get_roomname(){
		$requestData = $this->input->post();
		$hostel_name   = $requestData['hostel_id'];
		//print_r($requestData);exit;
		$unit  = array();
		if($hostel_name>0){
			$unit = $this->Common_Model->FetchData("hostel_rooms", "*", "hostel_name = ".$hostel_name);
			//print_r($unit);exit;
		}

		if(!empty($unit)){
			echo json_encode(array('status' => 200, 'res' => $unit));exit;
		}else{
			echo json_encode(array('status' => 500, 'msg' => 'Something went wrong.'));exit;
		}
	}

	function loadHostels(){
		$hostelArr  = array();
		$hostelArr  = $this->Common_Model->FetchData("tbl_hostel", "*", "1 ORDER BY name ASC");
		
		if(!empty($hostelArr)){
			echo json_encode(array('status' => 200, 'res' => $hostelArr));exit;
		}else{
			echo json_encode(array('status' => 500, 'msg' => 'Something went wrong.'));exit;
		}
	}


	function loadRooms(){
		$requestData = $this->input->post();
		$hostelId    = $requestData['hostelId'];
		$roomArr	 = array();
		if($hostelId > 0){
			$roomArr   = $this->Common_Model->FetchData("hostel_rooms", "*", "hostel_name = ".$hostelId." ORDER BY room_name ASC");
		}
		
		if(!empty($roomArr)){
			echo json_encode(array('status' => 200, 'result' => $roomArr));exit;
		}else{
			echo json_encode(array('status' => 500, 'msg' => 'Something went wrong.'));exit;
		}
	}


	function loadBeds(){
		$requestData = $this->input->post();
		$roomId      = $requestData['roomId'];
		$bedArr	     = array();
		if($roomId > 0){
			$bedArr   = $this->Common_Model->FetchData("`tbl_beds` A LEFT JOIN tbl_hostel_beds B ON (A.hostebed_id = B.id)", "A.`id`,A.`bed_name`,B.room_name", "B.room_name = ".$roomId);
		}
		
		if(!empty($bedArr)){
			echo json_encode(array('status' => 200, 'result' => $bedArr));exit;
		}else{
			echo json_encode(array('status' => 500, 'msg' => 'Something went wrong.'));exit;
		}
	}

	function checkAvail(){
		$requestData = $this->input->post();
		if(!empty($requestData)){
			$assigned_hostel = $requestData['assigned_hostel'];
			$assigned_room   = $requestData['assigned_room'];
			$assigned_bed    = $requestData['assigned_bed'];
			$configId    	 = $requestData['configId'];
			$session     	 = $this->session->userdata['session_name'];
			$sQcode          = "";
			if($configId > 0){
				$sQcode      = " AND assign_id NOT IN (".$configId.")";
			}
			$checkBeds       = $this->Common_Model->db_query("SELECT COUNT(1) AS cnt FROM erp_hostel_assign WHERE assigned_hostel = ".$assigned_hostel." AND assigned_room = ".$assigned_room." AND assigned_bed = ".$assigned_bed." AND session = '".$session."'".$sQcode);
			if($checkBeds[0]['cnt'] > 0){
				$bedLists       = $this->Common_Model->db_query("SELECT bed_name FROM tbl_beds WHERE id NOT IN (SELECT assigned_bed FROM erp_hostel_assign WHERE assigned_hostel = ".$assigned_hostel." AND assigned_room = ".$assigned_room." AND session = '".$session."')");
				//print_r($bedLists);exit;
				if(!empty($bedLists)){
					$bedavailList = implode(' | ',array_column($bedLists, 'bed_name'));
					echo json_encode(array('status' => 200, 'allocation' => 2, 'bedavailList' => $bedavailList));exit;
				}else{
					echo json_encode(array('status' => 200, 'allocation' => 3));exit;
				}
			}else{
				echo json_encode(array('status' => 200, 'allocation' => 1));exit;
			}
		}
	}

	function loadDays(){
		$days = $this->Common_Model->FetchData("erp_day_master", "*");
		if(!empty($days)){
			echo json_encode(array('status' => 200, 'res' => $days));exit;
		}else{
			echo json_encode(array('status' => 500, 'msg' => 'Something went wrong.'));exit;
		}
	}

	function loadAllEmployee(){
		$employee = $this->Common_Model->FetchData("employees", "*");
		if(!empty($employee)){
			echo json_encode(array('status' => 200, 'res' => $employee));exit;
		}else{
			echo json_encode(array('status' => 500, 'msg' => 'Something went wrong.'));exit;
		}
	}

		function loadAllroute(){
		$routeArr   = array();
		$routeArr  = $this->Common_Model->FetchData("erp_transport", "*", "1 ORDER BY route_name ASC");
		
		if(!empty($routeArr)){
			echo json_encode(array('status' => 200, 'result' => $routeArr));exit;
		}else{
			echo json_encode(array('status' => 500, 'msg' => 'Something went wrong.'));exit;
		}
	}

	function loadStoppage(){
		$requestData  = $this->input->post();
		$routeId      = $requestData['routeId'];
		$stpArr	      = array();
		if($routeId > 0){
			$stpArr   = $this->Common_Model->FetchData("erp_stoppage", "*", "route_id = ".$routeId);
		}
		
		if(!empty($stpArr)){
			echo json_encode(array('status' => 200, 'result' => $stpArr));exit;
		}else{
			echo json_encode(array('status' => 500, 'msg' => 'Something went wrong.'));exit;
		}
	}


	function loadconductorroute(){
		$requestData  = $this->input->post();
		$conductorId  = $requestData['conductorId'];
		$routeArr     = array();
		if($conductorId > 0){
			$routeArr   = $this->Common_Model->db_query("SELECT A.trans_id,A.route_name FROM `erp_transport` A LEFT JOIN erp_route_details B ON (A.trans_id = B.route_id) INNER JOIN vehicles C ON (B.vehicle_id = C.vehicle_id) WHERE A.status = 1 AND C.conductor_id = ".$conductorId);
		}
		
		if(!empty($routeArr)){
			echo json_encode(array('status' => 200, 'result' => $routeArr));exit;
		}else{
			echo json_encode(array('status' => 500, 'msg' => 'Something went wrong.'));exit;
		}
	}


	function loadStudentList(){
		$requestData  = $this->input->post();
		$stoppage_id  = $requestData['stoppage_id'];
		$studArr      = array();
		if($stoppage_id > 0){
			$studArr   = $this->Common_Model->db_query("SELECT A.*,B.student_first_name,B.student_last_name,COALESCE(C.atten_id,0) AS atten_id,COALESCE(C.pickup_status,0) AS pickup_status,COALESCE(C.dropup_status,0) AS dropup_status,COALESCE(C.remark,'') AS remark FROM erp_assign_transport A LEFT JOIN students B ON (A.student_id = B.student_id) LEFT JOIN erp_conductor_attendance C ON (B.student_id = C.student_id AND C.attendance_date = DATE(NOW())) WHERE A.stoppage_id = ".$stoppage_id);
		}
		
		if(!empty($studArr)){
			echo json_encode(array('status' => 200, 'result' => $studArr));exit;
		}else{
			echo json_encode(array('status' => 500, 'msg' => 'Something went wrong.'));exit;
		}
	}


	function loadconductoragainstroute(){
		$requestData  = $this->input->post();
		$routeId  	  = $requestData['routeId'];
		$conductArr   = array();
		if($routeId > 0){
			$conductArr   = $this->Common_Model->db_query("SELECT A.conductor_id,C.firstname,C.lastname FROM `vehicles` A LEFT JOIN erp_route_details B ON (A.`vehicle_id` = B.vehicle_id) LEFT JOIN users C ON (A.conductor_id = C.user_id) WHERE B.route_id = ".$routeId);
		}
		
		if(!empty($conductArr)){
			echo json_encode(array('status' => 200, 'result' => $conductArr));exit;
		}else{
			echo json_encode(array('status' => 500, 'msg' => 'Something went wrong.'));exit;
		}
	}



	function loadstudagainststoppage(){
		$requestData  = $this->input->post();
		$stoppage_id  = $requestData['stoppage_id'];
		$studArr      = array();
		if($stoppage_id > 0){
			$studArr   = $this->Common_Model->db_query("SELECT A.*,B.student_first_name,B.student_last_name FROM erp_assign_transport A LEFT JOIN students B ON (A.student_id = B.student_id) WHERE A.stoppage_id = ".$stoppage_id);
		}
		
		if(!empty($studArr)){
			echo json_encode(array('status' => 200, 'result' => $studArr));exit;
		}else{
			echo json_encode(array('status' => 500, 'msg' => 'Something went wrong.'));exit;
		}
	}

	function loadstudentagainstclass(){
		$requestData  = $this->input->post();
		$class_id  	  = $requestData['class_id'];
		$studArr      = array();
		if($class_id > 0){
			$sql = "active_status=0";
			if(isset($requestData['session_id']) && $requestData['session_id'] != ''){
				$sql.= " AND s.student_session = '".$requestData['session_id']."'";
			}

			if(isset($requestData['class_id']) && $requestData['class_id'] != ''){
				$sql.= " AND s.student_class = '".$requestData['class_id']."'";
			}

			$datalist = $this->Common_Model->db_query("SELECT s.student_id, s.student_first_name, s.student_last_name, s.student_mobile, s.student_gender, s.father_name, s.mother_name, s.guardian_name, s.father_contact_no, s.mother_contact_no, s.guardian_contact_no, ss.session_name, c.class_name, sec.section_name FROM students AS s LEFT JOIN sessions AS ss ON s.student_session = ss.session_id LEFT JOIN classes AS c ON s.student_class = c.class_id LEFT JOIN sections AS sec ON s.student_section = sec.section_id WHERE $sql ORDER BY s.student_first_name ASC");
		}
		
		if(!empty($datalist)){
			echo json_encode(array('status' => 200, 'result' => $datalist));exit;
		}else{
			echo json_encode(array('status' => 500, 'msg' => 'Something went wrong.'));exit;
		}
	}

		function loadStoppagecheck(){
		$requestData  = $this->input->post();
		$routeId      = $requestData['routeId'];
		//$trvl_date    = (strtotime($requestData['trvl_date']) > 0)?date('Y-m-d',strtotime($requestData['trvl_date'])):date('Y-m-d');
		$sel_vehicle  = $requestData['sel_vehicle'];
		$stpArr	      = array();
		$existedData  = '';
		if($routeId > 0){
			$stpArr       = $this->Common_Model->FetchData("erp_stoppage", "*", "route_id = ".$routeId);
			//$curDatechk   = $this->Common_Model->FetchData("erp_route_set", "set_id,chkstpg", "sel_route = ".$routeId." AND sel_vehicle = ".$sel_vehicle." AND trvl_date = '".$trvl_date."'");
			$curDatechk   = $this->Common_Model->FetchData("erp_route_set", "set_id,chkstpg", "sel_route = ".$routeId." AND sel_vehicle = ".$sel_vehicle);
			//print_r($curDatechk);exit;
			if(!empty($curDatechk)){
				$existedData = $curDatechk[0];
			}
		}
		
		if(!empty($stpArr)){
			echo json_encode(array('status' => 200, 'result' => $stpArr, 'existedData' => $existedData));exit;
		}else{
			echo json_encode(array('status' => 500, 'msg' => 'Something went wrong.'));exit;
		}
	}


	function loadvehicleagainstroute(){
		$requestData  = $this->input->post();
		$routeId  	  = $requestData['routeId'];
		$vehicleArr   = array();
		if($routeId > 0){
			$vehicleArr   = $this->Common_Model->db_query("SELECT A.`vehicle_id`,A.`registration_no` FROM `vehicles` A LEFT JOIN erp_route_details B ON (A.`vehicle_id` = B.vehicle_id) WHERE 1 AND A.conductor_id > 0 AND B.route_id = ".$routeId);
		}
		
		if(!empty($vehicleArr)){
			echo json_encode(array('status' => 200, 'result' => $vehicleArr));exit;
		}else{
			echo json_encode(array('status' => 500, 'msg' => 'Something went wrong.'));exit;
		}
	}

	function loadchapter(){
		$requestData  = $this->input->post();
		$class_id  	  = $requestData['class_id'];
		$subject_id   = $requestData['subject_id'];
		$chapterArr   = array();
		if($class_id > 0 && $subject_id > 0){
			$chapterArr   = $this->Common_Model->db_query("SELECT chapter_id, chapter_name FROM chapters WHERE chapter_status = 'Active' AND class_id = ".$class_id." AND subject_id = ".$subject_id);
		}
		
		if(!empty($chapterArr)){
			echo json_encode(array('status' => 200, 'result' => $chapterArr));exit;
		}else{
			echo json_encode(array('status' => 500, 'msg' => 'Something went wrong.'));exit;
		}
	}
	
	function get_examtitle(){
		$class_id  	  = $this->input->post("class_id");
		$records   = array();
		if($class_id > 0){
		    $records = $this->Common_Model->FetchData("exams", "*", "exam_class = ".$class_id);
		}
		$html = '<option value="">select</option>';
		if($records){ for($r=0; $r < count($records); $r++){
			$html.= '<option value="'.$records[$r]['exam_id'].'">'.$records[$r]['exam_title'].'</option>';
		}}
		echo $html;
		
	}
	
	function get_UnitBydesignation(){
		$unit_id = $this->input->post("unit");
		//$records = $this->Common_Model->FetchData("subjects", "*", "class_id = '".$this->input->post("class_id")."' ORDER BY subject_name ASC");
		$records = $this->Common_Model->db_query("SELECT * FROM contractedpost C LEFT JOIN designation D ON C.post_designation=D.designation_id WHERE C.unit_id=".$unit_id);
		$html = '<option value="">select</option>';
		if($records){
			for($i=0;$i<count($records);$i++){
				$html.= '<option value="'.$records[$i]['post_designation'].'">'.$records[$i]['designation_name'].'</option>';
			}
		}
		$this->db->close();
		echo $html;
		die(0);
	}

}