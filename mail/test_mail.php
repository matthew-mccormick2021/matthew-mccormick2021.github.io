<?php
$to = "matthew.mccormick2021@gmail.com"; // Replace with your email address
$subject = "Test Email";
$message = "This is a test email to check the mail server.";
$headers = "From: noreply@example.com"; // Use an appropriate From address

if (mail($to, $subject, $message, $headers)) {
    echo "Mail sent successfully!";
} else {
    echo "Mail server is not responding.";
}
?>
