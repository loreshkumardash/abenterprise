<?php


session_start(); 



use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if (isset($_POST['submit'])) {
    // Validate the captcha
    if ($_SESSION['code'] != $_POST['capcode']) {
        echo "<script>
                alert('Sorry, wrong captcha code');
                location.href='" . $_SERVER['HTTP_REFERER'] . "';
              </script>";
        exit;
    } else {
        require 'PHPMailer/src/Exception.php';
        require 'PHPMailer/src/PHPMailer.php';
        require 'PHPMailer/src/SMTP.php'; 

        // Collect form data
        $name = $_POST['name'];
        $email = $_POST['email'];
        $number = $_POST['number'];
        $message = $_POST['message'];

        // Validate form inputs
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo "Invalid email format";
            exit;
        }

        // Create an instance of PHPMailer
        $mail = new PHPMailer(true);

        try {
            // Server settings
            $mail->isSMTP();                                            // Set mailer to use SMTP
            $mail->Host       = 'smtp.gmail.com';                       // Specify main and backup SMTP servers
            $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
            $mail->Username   = 'cakiweb.com@gmail.com';                // SMTP username
            $mail->Password   = 'hszs acww wvnd poit';                  // SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption
            $mail->Port       = 587;                                    // TCP port

            // Recipients
            $mail->setFrom('cakiweb.com@gmail.com', ' ');
            $mail->addAddress('cakiweb.com@gmail.com', 'Recipient Name'); // Add your recipient email

            // Content
            $mail->isHTML(true);                                        // Set email format to HTML
            $mail->Subject = 'Enquire For Ezi Erp ';
            $mail->Body    = "You have received a new message from the contact form.<br><br>" .
                             "<strong>Name:</strong> $name<br>" .
                             "<strong>Email:</strong> $email<br>" .
                             "<strong>Mobile:</strong> $number<br>" .
                             "<strong>Message:</strong><br>" . nl2br($message);
            $mail->AltBody = "You have received a new inquiry for services.\n\n" .
                             "Name: $name\n" .
                             "Email: $email\n" .
                             "Mobile: $number\n" .
                             "Message:\n$message";

            // Send the email
            $mail->send();
            
            // Add JavaScript alert and redirect
            echo "<script>
                    alert('Message has been sent successfully');
                    window.location.href = '" . $_SERVER['HTTP_REFERER'] . "';
                  </script>";
            exit; // Stop further script execution after redirect

        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }
}
?>
