<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
class Messages extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('Common_Model');
		is_logged_in();
		date_default_timezone_set("Asia/Kolkata"); 
		$this->present_date 		= date('Y-m-d');
		$this->present_time 		= date('H:i:a');
		$this->timestamp 			= date('Y-m-d H:i:s');
	}

	public function index(){
    	error_reporting(0);
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
        $current_date = date('Y-m-d');
		
		//print_r($records);exit;
		
		$data['activemenu'] = 'message';
		$data['activesubmenu'] = 'messages';
        $this->load->view('messages/listmessages', $data);
    }

    public function viewmessage($user_id=0){
    	error_reporting(0);
		$data = array();
		$data['accessar'] = json_decode($this->session->userdata('access_menus'));
		$data['user_id'] = $user_id;
        $current_date = date('Y-m-d');
		
		$data['rec'] = $this->Common_Model->db_query("SELECT ledger_name,ledger_alias,acount_group FROM  ledgers WHERE ledger_id=".$user_id);
		
		$data['activemenu'] = 'message';
		$data['activesubmenu'] = 'messages';
        $this->load->view('messages/messages', $data);
    }

    function fetch_grmessages(){
    	$records = $this->Common_Model->FetchData("messages as a LEFT JOIN ledgers as b on a.user_id=b.ledger_id","a.*,b.ledger_name,b.ledger_alias","a.utype='user' GROUP BY a.user_id ORDER BY a.created_at DESC");
    	/*$sql = "SELECT m.message,m.user_id, m.created_at FROM messages m ORDER BY m.created_at DESC";
		$result = $this->Common_Model->db_query($sql);*/

		if ($records) {
		    foreach ($records as $key => $row) {
		    	$result = $this->Common_Model->db_query("SELECT m.message,m.user_id, m.created_at FROM messages m WHERE m.user_id=".$row['user_id']." ORDER BY m.created_at DESC LIMIT 1");
		    	echo '<div class="message">
		    	<a href="'.site_url("messages/viewmessage/".$row['user_id']).'">
			    	<div class="row">
			    		<div class="col-md-1">
			    			<img src="'.base_url().'assets/usericon.png" class="profile-user-img img-responsive img-circle" style="height:50px!important;width:50px;margin-top:5px;">
			    		</div>
			    		<div class="col-md-9" >
			    			<span style="font-weight:600;font-size:15px;color: #000;">'.$row['ledger_name'].' [<span style="color:green;">'.$row['ledger_alias'].'</span>]</span><br>
			    			<span style="color:#888;">'.substr($result[0]['message'],0,100).'...</span>
			    		</div>
			    		<div class="col-md-2">
			    			<span class="message-time" style="color:blue;">'.date("H:i A", strtotime($result[0]['created_at'])).'</span><br>
			    		</div>
			    	</div>
			    	</a>
		    	</div>';
		        
		    }
		} else {
		    echo "No messages";
		}

    }

    function fetch_messages($user_id=0){
    	
    	// Fetch all messages for the given user ID
			$sql = "SELECT m.is_delivered,m.is_read,m.id,m.message,m.user_id,m.utype, m.created_at FROM messages m WHERE m.user_id=".$user_id." ORDER BY m.created_at ASC";
			$result = $this->Common_Model->db_query($sql);

			if ($result) {

			    $groupedMessages = [];

			    // Group messages by date
			    foreach ($result as $row) {
			        $date = date('Y-m-d', strtotime($row['created_at']));
			        $groupedMessages[$date][] = $row;
			    }

			    $previousDate = '';

			    // Output messages with date separators
			    foreach ($groupedMessages as $date => $messages) {
			        // Output date separator if the date has changed
			        if ($date != $previousDate) {
			            echo '<div class="" style="text-align:center!important;display: inline-block;margin: 20px 0; width: 100%;"><strong style="text-align:center!important;font-weight: bold;font-size: 14px;background-color: #f0f0f0;padding: 5px;border-radius: 10px;color:black;">' . date('M j, Y', strtotime($date)) . '</strong></div>';
			            $previousDate = $date;
			        }

			        foreach ($messages as $row) {
			        	if ($row['is_read'] == '0' && $row['utype'] !='bot') {
			        		$this->markMessagesAsRead($row['id']);
			        	}
			        	
			            $class = htmlspecialchars($row['utype'], ENT_QUOTES, 'UTF-8');
			            $floatClass = ($class == 'bot') ? 'float-right' : 'float-left';
			            $messageContent = htmlspecialchars($row['message'], ENT_QUOTES, 'UTF-8');
			            $formattedTime = date("H:i A", strtotime($row['created_at']));
			            
			            // Determine tick status
			            $isDelivered = $row['is_delivered']=='1' && $class=='bot' ? 'tick-delivered' : '';
			            $isRead = $row['is_read'] =='1' && $class=='bot'? 'tick-read' : '';

			            echo '<div class="message ' . $class . ' ' . $floatClass . '">
			                    <div class="message-content">' . $messageContent . '</div>
			                    <div class="message-time">' . $formattedTime . ' <span class="' . $isDelivered . ' ' . $isRead . '"></span></div>
			                    
			                </div>';
			        }
			    }
			} else {
			    echo "No messages";
			}



    }

    function send_message($user_id=0){
    	$message = $_POST['message'];
		$user_id = $user_id;

		$data_list = array(
		    'message'       => $message,
		    'user_id'       => $user_id,
		    'created_at'    => date('Y-m-d H:i:s'),
		    'utype'         => 'bot',
		    'uid'           => $this->session->userdata("user_id"),
		    'is_delivered'  => FALSE,
		    'is_read'       => FALSE
		);

		$message_id = $this->Common_Model->dbinsertid("messages", $data_list);


		// Example usage: Update the status of a message
		$this->markMessageAsDelivered($message_id);
    }

    function markMessagesAsRead($id) {
		    $this->Common_Model->db_query("UPDATE messages SET is_read = 1 WHERE id = ".$id."");
		}
	function markMessageAsDelivered($id) {
		     $this->Common_Model->db_query("UPDATE messages SET is_delivered = 1 WHERE id = ".$id."");
		}


}