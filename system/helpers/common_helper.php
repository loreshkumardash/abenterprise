<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function ordinal($number) {
    $ends = array('th','st','nd','rd','th','th','th','th','th','th');
    if ((($number % 100) >= 11) && (($number%100) <= 13))
        return $number. 'th';
    else
        return $number. $ends[$number % 10];
}

function numword($number){
   $no = floor($number);
   $point = round($number - $no, 2) * 100;
   $hundred = null;
   $digits_1 = strlen($no);
   $i = 0;
   $str = array();
   $words = array('0' => '', '1' => 'one', '2' => 'two',
    '3' => 'three', '4' => 'four', '5' => 'five', '6' => 'six',
    '7' => 'seven', '8' => 'eight', '9' => 'nine',
    '10' => 'ten', '11' => 'eleven', '12' => 'twelve',
    '13' => 'thirteen', '14' => 'fourteen',
    '15' => 'fifteen', '16' => 'sixteen', '17' => 'seventeen',
    '18' => 'eighteen', '19' =>'nineteen', '20' => 'twenty',
    '30' => 'thirty', '40' => 'forty', '50' => 'fifty',
    '60' => 'sixty', '70' => 'seventy',
    '80' => 'eighty', '90' => 'ninety');
   $digits = array('', 'hundred', 'thousand', 'lakh', 'crore');
   while ($i < $digits_1) {
     $divider = ($i == 2) ? 10 : 100;
     $number = floor($no % $divider);
     $no = floor($no / $divider);
     $i += ($divider == 10) ? 1 : 2;
     if ($number) {
        $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
        $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
        $str [] = ($number < 21) ? $words[$number] .
            " " . $digits[$counter] . $plural . " " . $hundred
            :
            $words[floor($number / 10) * 10]
            . " " . $words[$number % 10] . " "
            . $digits[$counter] . $plural . " " . $hundred;
     } else $str[] = null;
  }
  $str = array_reverse($str);
  $result = implode('', $str);
  $points = ($point) ?
    "." . $words[$point / 10] . " " . 
          $words[$point = $point % 10] : '';
  return $result;
}

function numberTowords($num){ 
    $ones = array( 
        1 => "one", 
        2 => "two", 
        3 => "three", 
        4 => "four", 
        5 => "five", 
        6 => "six", 
        7 => "seven", 
        8 => "eight", 
        9 => "nine", 
        10 => "ten", 
        11 => "eleven", 
        12 => "twelve", 
        13 => "thirteen", 
        14 => "fourteen", 
        15 => "fifteen", 
        16 => "sixteen", 
        17 => "seventeen", 
        18 => "eighteen", 
        19 => "nineteen" 
    ); 
    $tens = array( 
        1 => "ten",
        2 => "twenty", 
        3 => "thirty", 
        4 => "forty", 
        5 => "fifty", 
        6 => "sixty", 
        7 => "seventy", 
        8 => "eighty", 
        9 => "ninety" 
    ); 
    $hundreds = array( 
        "hundred", 
        "thousand", 
        "million", 
        "billion", 
        "trillion", 
        "quadrillion" 
    ); //limit t quadrillion 
    $num = number_format($num,2,".",","); 
    $num_arr = explode(".",$num); 
    $wholenum = $num_arr[0]; 
    $decnum = $num_arr[1]; 
    $whole_arr = array_reverse(explode(",",$wholenum)); 
    krsort($whole_arr); 
    $rettxt = ""; 
    foreach($whole_arr as $key => $i){ 
        if($i < 20){ 
            $rettxt .= $ones[$i]; 
        }elseif($i < 100){ 
            $rettxt .= $tens[substr($i,0,1)]; 
            $rettxt .= " ".$ones[substr($i,1,1)]; 
        }else{ 
            $rettxt .= $ones[substr($i,0,1)]." ".$hundreds[0]; 
            $rettxt .= " ".$tens[substr($i,1,1)]; 
            $rettxt .= " ".$ones[substr($i,2,1)]; 
        } 
        if($key > 0){ 
            $rettxt .= " ".$hundreds[$key]." "; 
        }
    }
    if($decnum > 0){ 
        $rettxt .= " and "; 
        if($decnum < 20){ 
            $rettxt .= $ones[$decnum]; 
        }elseif($decnum < 100){ 
            $rettxt .= $tens[substr($decnum,0,1)]; 
            $rettxt .= " ".$ones[substr($decnum,1,1)]; 
        } 
    } 
    return $rettxt; 
}

function clean($string){
	return preg_replace('/[^A-Za-z0-9\- ]/', '', trim($string)); // Removes special chars.
}

function cleantext($string){
	return preg_replace('/[^A-Za-z0-9\-. , &- ]/', '', trim($string)); // Removes special chars.
}

function removeSpace($string){
	return str_replace(' ', '', $string); // Replaces all spaces.
}

function get_session_details() 
{
	$CI =& get_instance();
	$data = (object)$CI->session->all_userdata();
	return $data;
}
function is_logged_in()
{
	$CI =& get_instance();
	$is_logged_in = $CI->session->userdata('user_id');
	if(!isset($is_logged_in) || $is_logged_in != true)
	{
		redirect ('login');   
	}       
}
function get_locations_options(){
	$CI =& get_instance();
	$records = $CI->Common_Model->FetchData(TAB_LOCATION, "*", "loc_id > 0 AND parent_state_id = 0 and parent_country_id != 0 ORDER BY loc_id ASC");
	return $records;
}

function getFetchData($table, $columns, $condition){
	$CI =& get_instance();
	$records = $CI->Common_Model->FetchData($table, $columns, $condition);
	return $records;
}

function getFetchRows($table, $columns, $condition){
	$CI =& get_instance();
	$records = $CI->Common_Model->FetchRows($table, $columns, $condition);
	return $records;
}

function db_query($sql){
	$CI =& get_instance();
	$records = $CI->Common_Model->db_query($sql);
	return $records;
}

function getarray($query,$field1,$field2){
    $CI =& get_instance();
    $records = $CI->Common_Model->db_getarr($query,$field1,$field2);
    return $records;
}

function get_locations_options_2($id){
	$CI =& get_instance();
	$records = $CI->Common_Model->FetchData(TAB_LOCATION, "*", "parent_state_id = ".$id." ORDER BY loc_name ASC");
	return $records;
}

function getAdmissionCount($class_id = 0, $session_id = 0){
    $CI =& get_instance();
    $clstar = $CI->Common_Model->db_query("SELECT SUM(if(sa.Readmission = '1', 1, 0)) AS readm, SUM(if(sa.Readmission = '0', 1, 0)) AS newadm FROM student_admission AS sa LEFT JOIN sessions AS s ON sa.session_id = s.session_id LEFT JOIN classes AS c ON sa.class_id = c.class_id WHERE sa.class_id = '".$class_id."' AND sa.session_id = ".$session_id."");
    if($clstar){
        return $clstar[0];
    }else{
        return array("readm" => 0, "newadm" => 0);
    }
}

function get_degree($parent_id = 0, $degree_type = ''){
	$CI =& get_instance();
	$sql = '1';
	if($parent_id){
		$sql.=" AND degree_parent_id ='$parent_id'";
	}else{
		$sql.=" AND degree_parent_id ='0'";
	}
	if($degree_type != ''){
		$sql.=" AND degree_type = '$degree_type'";
	}
	$records = $CI->Common_Model->FetchData(TAB_DEGREE, "*", $sql);
	return $records;
}

function get_browsername() { if (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== FALSE){ $browser = 'Microsoft Internet Explorer'; }elseif (strpos($_SERVER['HTTP_USER_AGENT'], 'Chrome') !== FALSE) { $browser = 'Google Chrome'; }elseif (strpos($_SERVER['HTTP_USER_AGENT'], 'Firefox') !== FALSE) { $browser = 'Mozilla Firefox'; }elseif (strpos($_SERVER['HTTP_USER_AGENT'], 'Opera') !== FALSE) { $browser = 'Opera'; }elseif (strpos($_SERVER['HTTP_USER_AGENT'], 'Safari') !== FALSE) { $browser = 'Apple Safari'; }else { $browser = 'error'; } return $browser; }

function makeHandlerKey() {
	$salt = "abchefghjkmnpqrstuvwxyz0123456789";
	srand((double)microtime()*1000000);
	$i = 0;
	$pass = '';
	while ($i <= 9) {
		$num = rand() % 33;
		$tmp = substr($salt, $num, 2);
		$pass = $pass . $tmp;
		$i++;
	}
	return $pass;
}

function read_docx($filename){

    $striped_content = '';
    $content = '';

    if(!$filename || !file_exists($filename)) return false;

    $zip = zip_open($filename);
    if (!$zip || is_numeric($zip)) return false;

    while ($zip_entry = zip_read($zip)) {

        if (zip_entry_open($zip, $zip_entry) == FALSE) continue;

        if (zip_entry_name($zip_entry) != "word/document.xml") continue;

        $content .= zip_entry_read($zip_entry, zip_entry_filesize($zip_entry));

        zip_entry_close($zip_entry);
    }
    zip_close($zip);      
    $content = str_replace('</w:r></w:p></w:tc><w:tc>', " ", $content);
    $content = str_replace('</w:r></w:p>', "\r\n", $content);
    $striped_content = strip_tags($content);

    return addslashes($striped_content);
}

function rtf_isPlainText($s) {
    $arrfailAt = array("*", "fonttbl", "colortbl", "datastore", "themedata");
    for ($i = 0; $i < count($arrfailAt); $i++)
        if (!empty($s[$arrfailAt[$i]])) return false;
    return true;
}

function rtf2text($filename) {
    // Read the data from the input file.
    $text = file_get_contents($filename);
    if (!strlen($text))
        return "";

    // Create empty stack array.
    $document = "";
    $stack = array();
    $j = -1;
    // Read the data character-by- character…
    for ($i = 0, $len = strlen($text); $i < $len; $i++) {
        $c = $text[$i];

        // Depending on current character select the further actions.
        switch ($c) {
            // the most important key word backslash
            case "\\":
                // read next character
                $nc = $text[$i + 1];

                // If it is another backslash or nonbreaking space or hyphen,
                // then the character is plain text and add it to the output stream.
                if ($nc == '\\' && rtf_isPlainText($stack[$j])) $document .= '\\';
                elseif ($nc == '~' && rtf_isPlainText($stack[$j])) $document .= ' ';
                elseif ($nc == '_' && rtf_isPlainText($stack[$j])) $document .= '-';
                // If it is an asterisk mark, add it to the stack.
                elseif ($nc == '*') $stack[$j]["*"] = true;
                // If it is a single quote, read next two characters that are the hexadecimal notation
                // of a character we should add to the output stream.
                elseif ($nc == "'") {
                    $hex = substr($text, $i + 2, 2);
                    if (rtf_isPlainText($stack[$j]))
                        $document .= html_entity_decode("&#".hexdec($hex).";");
                    //Shift the pointer.
                    $i += 2;
                // Since, we’ve found the alphabetic character, the next characters are control word
                // and, possibly, some digit parameter.
                } elseif ($nc >= 'a' && $nc <= 'z' || $nc >= 'A' && $nc <= 'Z') {
                    $word = "";
                    $param = null;

                    // Start reading characters after the backslash.
                    for ($k = $i + 1, $m = 0; $k < strlen($text); $k++, $m++) {
                        $nc = $text[$k];
                        // If the current character is a letter and there were no digits before it,
                        // then we’re still reading the control word. If there were digits, we should stop
                        // since we reach the end of the control word.
                        if ($nc >= 'a' && $nc <= 'z' || $nc >= 'A' && $nc <= 'Z') {
                            if (empty($param))
                                $word .= $nc;
                            else
                                break;
                        // If it is a digit, store the parameter.
                        } elseif ($nc >= '0' && $nc <= '9')
                            $param .= $nc;
                        // Since minus sign may occur only before a digit parameter, check whether
                        // $param is empty. Otherwise, we reach the end of the control word.
                        elseif ($nc == '-') {
                            if (empty($param))
                                $param .= $nc;
                            else
                                break;
                        } else
                            break;
                    }
                    // Shift the pointer on the number of read characters.
                    $i += $m - 1;

                    // Start analyzing what we’ve read. We are interested mostly in control words.
                    $toText = "";
                    switch (strtolower($word)) {
                        // If the control word is "u", then its parameter is the decimal notation of the
                        // Unicode character that should be added to the output stream.
                        // We need to check whether the stack contains \ucN control word. If it does,
                        // we should remove the N characters from the output stream.
                        case "u":
                            $toText .= html_entity_decode("&#x".dechex($param).";");
                            $ucDelta = @$stack[$j]["uc"];
                            if ($ucDelta > 0)
                                $i += $ucDelta;
                        break;
                        // Select line feeds, spaces and tabs.
                        case "par": case "page": case "column": case "line": case "lbr":
                            $toText .= "\n"; 
                        break;
                        case "emspace": case "enspace": case "qmspace":
                            $toText .= " "; 
                        break;
                        case "tab": $toText .= "\t"; break;
                        // Add current date and time instead of corresponding labels.
                        case "chdate": $toText .= date("m.d.Y"); break;
                        case "chdpl": $toText .= date("l, j F Y"); break;
                        case "chdpa": $toText .= date("D, j M Y"); break;
                        case "chtime": $toText .= date("H:i:s"); break;
                        // Replace some reserved characters to their html analogs.
                        case "emdash": $toText .= html_entity_decode("&mdash;"); break;
                        case "endash": $toText .= html_entity_decode("&ndash;"); break;
                        case "bullet": $toText .= html_entity_decode("&#149;"); break;
                        case "lquote": $toText .= html_entity_decode("&lsquo;"); break;
                        case "rquote": $toText .= html_entity_decode("&rsquo;"); break;
                        case "ldblquote": $toText .= html_entity_decode("&laquo;"); break;
                        case "rdblquote": $toText .= html_entity_decode("&raquo;"); break;
                        // Add all other to the control words stack. If a control word
                        // does not include parameters, set &param to true.
                        default:
                            $stack[$j][strtolower($word)] = empty($param) ? true : $param;
                        break;
                    }
                    // Add data to the output stream if required.
                    if (rtf_isPlainText($stack[$j]))
                        $document .= $toText;
                }

                $i++; 
            break;
            // If we read the opening brace {, then new subgroup starts and we add
            // new array stack element and write the data from previous stack element to it.
            case "{":
                array_push($stack, $stack[$j++]);
            break;
            // If we read the closing brace }, then we reach the end of subgroup and should remove 
            // the last stack element.
            case "}":
                array_pop($stack);
                $j--;
            break;
            // Skip “trash”.
            case '\0': case '\r': case '\f': case '\n': break;
            // Add other data to the output stream if required.
            default:
                if (rtf_isPlainText($stack[$j]))
                    $document .= $c;
            break;
        }
    }
    // Return result.
    return $document;
}

function makeMailvfcode() {
	$salt = "1456789wxyz";
	srand((double)microtime()*1000000);
	$i = 0;
	$pass ='';
	while ($i <= 100) {
	$num = rand() % 33;
	$tmp = substr($salt, $num, 1);
	$pass = $pass . $tmp;
	$i++;
	}
	return $pass;
}

function makeOtpcode() {
	$salt = "23456789wxyz";
	srand((double)microtime()*1000000);
	$i = 0;
	$pass ='';
	while ($i <= 100) {
	$num = rand() % 70;
	$tmp = substr($salt, $num, 1);
	$pass = $pass . $tmp;
	$i++;
	}
	return $pass;
}

function formatDate($datetime, $type='1', $format="m/d/Y")
{
	if($type == 1) // For Display
	{
		$dt = split("[- :]",$datetime);
		$formatted_dt = @date($format, mktime($dt[3],$dt[4],$dt[5],$dt[1],$dt[2],$dt[0]));
	}
	else // For Database Entry
	{
		$dt = split('/',$datetime);
		$formatted_dt = @date("Y-m-d", mktime(0,0,0,$dt[0],$dt[1],$dt[2]));
	}

	return $formatted_dt;
}

function dirsize($dirName)
{
   $dir  = dir($dirName);
   $size = 0;

   while($file = $dir->read()) {
	   if ($file != '.' && $file != '..') {
		   if (is_dir($dirName.'/'.$file)) {
			   $size += dirsize($dirName . '/' . $file);
		   } else {
			   $size += filesize($dirName . '/' . $file);
		   }
	   }
   }
   $dir->close();

   return $size;
}

function sendMail($to, $subject,$message, $to_header='', $from_header='')
{
	if($to_header) $headers .= "To: ".$to_header."\n";
	if($from_header) $headers .= "From: ".$from_header."\n";
	$headers .= "MIME-Version: 1.0\n";

	$headers .= "Content-type: text/html; charset=iso-8859-1\n";
	$headers .= "X-Mailer: PHP\n"; // mailer
	$headers .= "X-Priority: 1\n"; // Urgent message!
	$headers .= "Return-Path: <".FROM_EMAIL.">\n";  // Return path for errors

	@mail($to, $subject, $message, $headers);
}

function sendMailContact($TAB_CONTACTS, $contact_id, $subject, $message, $from)
{
	global $domainDB;

	$sSql 		= 'select * from '.$TAB_CONTACTS. " where contact_id='$contact_id'";
	$data 		= $domainDB->db_query($sSql);
	$to_email 	= $data[0]['contact_email'];

	$first_name = $data[0]['first_name'];
	$middleName = $data[0]['middle_name'];
	$lastName 	= $data[0]['last_name'];
	$fullname 	= $first_name.','.$middleName.','.$lastName;

	$business_street 	= $data[0]['business_street'];
	$business_city 	 	= $data[0]['business_city'];
	$business_post_code = $data[0]['business_post_code'];
	$businessaddress 	=   $business_street.','.$business_city.','.$business_post_code;

	$home_city 			= $data[0]['home_city'];
	$home_street 		= $data[0]['home_street'];
	$home_post_code 	= $data[0]['home_post_code'];
	$home_country 		=   $data[0]['home_country'];
	$homeaddress 		= $home_street.','.$home_city.','.$home_post_code.','.$home_country;

	$mailInfo = array($data[0]['prefix'],
	$data[0]['first_name'],
	$data[0]['middle_name'],
	$data[0]['last_name'],
	$fullname,
	$data[0]['suffix'],
	$data[0]['contact_email'],
	$data[0]['home_street'],
	$data[0]['home_city'],
	$data[0]['home_post_code'],
	$homeaddress,
	$businessaddress,
	$data[0]['home_phone'],
	$data[0]['work_phone'],
	$data[0]['contact_mobile']);

	$subject = stripslashes($subject);
	$mail_msg = stripslashes($message);
	$tmp_str = ' style="BACKGROUND-COLOR: #ccffff"';
	$mail_msg = str_replace($tmp_str, "", $mail_msg);

	$source = array('##Prefix##', '##First-Name##', '##Middle-Name##', '##Last-Name##', '##Full-Name##', '##Suffix##', '##Email-Address##', '##Home-Address##', '##Business-Address##',  '##Home-Phone##', '##Work-Phone##', '##Mobile##');
	$mail_msg = stripslashes(str_replace($source, $mailInfo, $mail_msg));

	//echo($to_email.'<p>'.$mail_msg);
	//exit();

	$start = strpos($from, '<') + 1;
	$end = strpos($from, '>');
	$from_email = substr($from, $start, $end - $start);

	$headers .= "To: ".$fullname.'<'.$to_email.'>'."\n";
	$headers .= "From: ".$from."\n";
	$headers .= "MIME-Version: 1.0\n";

	$headers .= "Content-type: text/html; charset=iso-8859-1\n";
	$headers .= "X-Mailer: PHP\n"; // mailer
	$headers .= "X-Priority: 1\n"; // Urgent message!
	$headers .= "Return-Path: <".$from_email.">\n";

	@mail($to_email, $subject, $mail_msg, $headers);
}

function makecomma($input)
{
   // This function is written by some anonymous person - I got it from Google
   if(strlen($input)<=2)
   { return $input; }
   $length=substr($input,0,strlen($input)-2);
   $formatted_input = makecomma($length).",".substr($input,-2);
   return $formatted_input;
}

function formatInIndianStyle($num){
   // This is my function
   $num = sprintf("%01.2f",$num);
   $pos = strpos((string)$num, ".");
   if ($pos === false) { $decimalpart="00";}
   else { $decimalpart= substr($num, $pos+1, 2); $num = substr($num,0,$pos); }

   if(strlen($num)>3 & strlen($num) <= 12){
               $last3digits = substr($num, -3 );
               $numexceptlastdigits = substr($num, 0, -3 );
               $formatted = makecomma($numexceptlastdigits);
               $stringtoreturn = $formatted.",".$last3digits.".".$decimalpart ;
   }elseif(strlen($num)<=3){
               $stringtoreturn = $num.".".$decimalpart ;
   }elseif(strlen($num)>12){
               $stringtoreturn = number_format($num, 2);
   }

   if(substr($stringtoreturn,0,2)=="-,"){$stringtoreturn = "-".substr($stringtoreturn,2 );}

   return $stringtoreturn;
}




function makeRandomKey_email() {
  $salt = "abchefghjkmnpqrstuvwxyz0123456789";
  srand((double)microtime()*1000000);
      $i = 0;
      while ($i <= 15) {
            $num = rand() % 33;
            $tmp = substr($salt, $num, 1);
            $pass = $pass . $tmp;
            $i++;
      }
      return $pass;
}

function dfultPassword() {
$salt = "abchefghjkmnpqrstuvwxyz0123456789";
srand((double)microtime()*1000000);
      $i = 0;
      while ($i <= 9) {
            $num = rand() % 33;
            $tmp = substr($salt, $num, 1);
            $pass = $pass . $tmp;
            $i++;
      }
      return $pass;
}

function makeDefultPath() {
  $salt = "987654321";
  $pass = '';
  srand((double)microtime()*1000000);
      $i = 0;
      while ($i <= 5) {
            $num = rand() % 3;
            $tmp = substr($salt, $num, 1);
            $pass = $pass . $tmp;
            $i++;
      }
      return $pass;
}
function makeDefultPath1() {
  $salt = "01abche23fghjkmnpqr4567stuv89wxyz";
  srand((double)microtime()*1000000);
      $i = 0;
      while ($i <= 100) {
            $num = rand() % 10;
            $tmp = substr($salt, $num, 1);
            $pass = $pass . $tmp;
            $i++;
      }
      return $pass;
}

function makeCandidateKey() {
  $salt = "tuvwxyz012abch34efg56hjkmn789pqrs";
  $pass = '';
  srand((double)microtime()*1000000);
      $i = 0;
      while ($i <= 9) {
            $num = rand() % 20;
            $tmp = substr($salt, $num, 2);
            $pass = $pass . $tmp;
            $i++;
      }
      return $pass;
}

function FI($sinput,$sparam='',$sdisp='')
{
  /**
  * Formats form input fields
  *
  * $sparam = 'h' htmlspecialchars,trim
  * $sparam = 's' stripslashes,trim
  * $sparam = '' stripslashes,htmlspecialchars,trim
  * $sdisp  = 'n'  does not echo
  */
  if($sparam == 'h') $sinput = htmlspecialchars(trim($sinput));
  elseif($sparam == 's') $sinput = stripslashes(trim($sinput));
  else $sinput = stripslashes(htmlspecialchars(trim($sinput)));

  return $sinput;
 }

 function FO($sinput)
 {
  /**
  * Prepares Form POST Data for insertion to DB.
  *
  */
  if(is_array($sinput))
  {
   foreach($sinput as $key => $val)
   {
   		$sinput[$key] = addslashes(trim($val));
   }
  }
  else
  {
   $sinput = addslashes(trim($sinput));
  }

  return $sinput;
 }
 function deleteDir($foldername,$delete_current=1)
 {
	if(is_dir($foldername))
	{
		$inputarray = opendir($foldername);
		while($file = readdir($inputarray))
		{
			if (($file != ".") && ($file != ".."))
			{
				$filename = $foldername . "/" . $file;
				if (is_dir($filename))
				{
					deleteDir($filename);
				}
				elseif(is_file($filename)) //checking file
				{
					@unlink($filename);
				}
			}
		}
		if($delete_current) @rmdir($foldername);
	}
 }

 function makeThumbImage($source_path,$dest_path,$thumb_width,$quality='100')
 {
 	//SWITCHES THE IMAGE CREATE FUNCTION BASED ON FILE EXTENSION
 	$source = imagecreatefromjpeg($source_path);


 	//CREATES THE PATH TO THE SAVED FILE
 	$fullpath = $dest_path;

 	//FINDS SIZE OF THE OLD FILE
 	$imageX = imagesx($source);
 	$imageY = imagesy($source);

 	//FINDS SIZE OF THE NEW FILE
 	$thumbX = $thumb_width;
 	$thumbY = (int) (($thumbX * $imageY) / $imageX );

 	//CREATES IMAGE WITH NEW SIZES
 	$thumb = imagecreatetruecolor($thumbX, $thumbY);

 	//RESIZES OLD IMAGE TO NEW SIZES
 	imagecopyresampled ($thumb, $source, 0, 0, 0, 0, $thumbX, $thumbY, $imageX, $imageY);

 	//SAVES IMAGE AND SETS QUALITY || NUMERICAL VALUE = QUALITY ON SCALE OF 1-100
 	imagejpeg($thumb, $fullpath, $quality);
 }

 function translateToWords(float $number){
    $decimal = round($number - ($no = floor($number)), 2) * 100;
    $hundred = null;
    $digits_length = strlen($no);
    $i = 0;
    $str = array();
    $words = array(0 => '', 1 => 'one', 2 => 'two',
        3 => 'three', 4 => 'four', 5 => 'five', 6 => 'six',
        7 => 'seven', 8 => 'eight', 9 => 'nine',
        10 => 'ten', 11 => 'eleven', 12 => 'twelve',
        13 => 'thirteen', 14 => 'fourteen', 15 => 'fifteen',
        16 => 'sixteen', 17 => 'seventeen', 18 => 'eighteen',
        19 => 'nineteen', 20 => 'twenty', 30 => 'thirty',
        40 => 'forty', 50 => 'fifty', 60 => 'sixty',
        70 => 'seventy', 80 => 'eighty', 90 => 'ninety');
    $digits = array('', 'hundred','thousand','lakh', 'crore');
    while( $i < $digits_length ) {
        $divider = ($i == 2) ? 10 : 100;
        $number = floor($no % $divider);
        $no = floor($no / $divider);
        $i += $divider == 10 ? 1 : 2;
        if ($number) {
            $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
            $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
            $str [] = ($number < 21) ? $words[$number].' '. $digits[$counter]. $plural.' '.$hundred:$words[floor($number / 10) * 10].' '.$words[$number % 10]. ' '.$digits[$counter].$plural.' '.$hundred;
        } else $str[] = null;
    }
    $Rupees = implode('', array_reverse($str));
    $paise = ($decimal > 0) ? "." . ($words[$decimal / 10] . " " . $words[$decimal % 10]) . ' Paise' : '';
    return ($Rupees ? $Rupees . 'Rupees ' : '') . $paise;
}