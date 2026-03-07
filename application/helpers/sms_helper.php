<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


function sendMobVerifyCode($candidate_id, $h_id){
	
	$CI =& get_instance();
	$CandidateData     = $CI->Common_Model->FetchData(TAB_CANDIDATE, "*", "candidate_id ='$candidate_id'");
	$candidate_id	= $CandidateData[0]['candidate_id'];
	$name	= $CandidateData[0]['name'];
	$mobile	= $CandidateData[0]['mobile'];
	$mob_verfy_code	= $CandidateData[0]['mob_verfy_code'];

	date_default_timezone_set("Asia/Kolkata");
	$present_date = date('Y-m-d');
	$present_time = date('h:i:a');
	$ip = getenv("REMOTE_ADDR"); 

	// SMS API Here------start--------------// 
	$message_content = "Your unique verification code is $mob_verfy_code Incase you have not made this request contact Corporate Resources @ 09338136693 For details visit www.crplindia.com";

	$msg=urlencode($message_content);	
	// SMS API Here------start--------------// 	
	$url="http://alerts.simplydial-mks.com/api/web2sms.php?workingkey=8962ha8r3tqs684r2kos&sender=CRPLIN&to=$mobile&message=$msg";
	$ch=curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$output=curl_exec($ch);
	curl_close($ch); 

	$sSql = 'INSERT INTO '.TAB_COMUNICATION_RECORDS. " SET h_id = '".$h_id."', com_type = 'SMS', com_content = '$message_content'";
	$CI->Common_Model->QueryData($sSql);                          
	return $output;		
}
function generatePIN($digits = 4){
    $i = 0; //counter
    $pin = ""; //our default pin is blank.
    while($i < $digits){
        //generate a random number between 0 and 9.
        $pin .= mt_rand(0, 9);
        $i++;
    }
    return $pin;
}
