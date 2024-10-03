<?php
$email_address = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);

// Check for empty fields
if (empty($_POST['name']) || 
    empty($_POST['email']) || 
    empty($_POST['phone']) || 
    empty($_POST['message']) || 
    !$email_address) {
    echo "No arguments Provided!";
    return false;
}

$name = htmlspecialchars($_POST['name']);
$phone = htmlspecialchars($_POST['phone']);
$message = htmlspecialchars($_POST['message']);

if ($email_address === FALSE) {
    echo 'Invalid email';
    exit(1);
}

if (empty($_POST['_gotcha'])) { // If hidden field was filled out (by spambots) don't send!
    // Create the email and send the message
    $to = 'matthew.mccormick2021@gmail.com'; // Replace with your email address
    $email_subject = "Website Contact Form: $name";
    $email_body = "You have received a new message from your website contact form.\n\n".
                  "Here are the details:\n\n".
                  "Name: $name\n\n".
                  "Email: $email_address\n\n".
                  "Phone: $phone\n\n".
                  "Message:\n$message";
    $headers = "From: noreply@yourdomain.com\n"; // Use a valid sender email
    $headers .= "Reply-To: $email_address";

    if (mail($to, $email_subject, $email_body, $headers)) {
        echo "Message sent successfully!";
    } else {
        echo "Message delivery failed.";
    }
    return true;
}

echo "Gotcha, spambot!";
return false;
?>
