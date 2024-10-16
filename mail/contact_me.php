<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Load PHPMailer classes
require 'vendor/autoload.php'; // Adjust the path as necessary

// Validate and sanitize email address
$email_address = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);

// Check for empty fields
if (empty($_POST['name']) || 
    empty($_POST['email']) || 
    empty($_POST['phone']) || 
    empty($_POST['message']) || 
    !$email_address) {
    echo "No arguments provided or invalid email!";
    return false;
}

// Sanitize user inputs
$name = htmlspecialchars(trim($_POST['name']));
$phone = htmlspecialchars(trim($_POST['phone']));
$message = htmlspecialchars(trim($_POST['message']));

// Check if the email address is valid
if ($email_address === false) {
    echo 'Invalid email';
    exit(1);
}

// Check for hidden field to prevent spam
if (empty($_POST['_gotcha'])) { 
    $mail = new PHPMailer(true);
    
    try {
        //Server settings
        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = 'smtp.gmail.com';                       // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = 'your_email@gmail.com';            // Your Gmail address
        $mail->Password = 'your gmail password';             // Your Gmail password or App Password
        $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 587;                                   // TCP port to connect to

        //Recipients
        $mail->setFrom('your_email@gmail.com', $name);      // Sender's email
        $mail->addAddress('matthew.mccormick2021@gmail.com'); // Add a recipient
        $mail->addReplyTo($email_address, $name);           // Add reply-to email

        // Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = "Website Contact Form: $name";
        $mail->Body    = "You have received a new message from your website contact form.<br><br>" .
                         "Here are the details:<br><strong>Name:</strong> $name<br>" .
                         "<strong>Email:</strong> $email_address<br>" .
                         "<strong>Phone:</strong> $phone<br>" .
                         "<strong>Message:</strong><br>$message";

        $mail->send();
        echo "Message sent successfully!";
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
    return true;
}

// If the hidden field was filled out, it's likely a bot
echo "Gotcha, spambot!";
return false;
?>
