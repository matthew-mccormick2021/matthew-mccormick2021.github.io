<?php
<?php
// Validate and sanitize email address
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

// Sanitize user inputs to prevent XSS
$name = htmlspecialchars(trim($_POST['name']));
$phone = htmlspecialchars(trim($_POST['phone']));
$message = htmlspecialchars(trim($_POST['message']));

if ($email_address === FALSE) {
    echo 'Invalid email';
    exit(1);
}

// Check for hidden field to prevent spam
if (empty($_POST['_gotcha'])) {
    // Create the email and send the message
    $to = 'matthew.mccormick2021@gmail.com'; // Replace with your email address
    $email_subject = "Website Contact Form: $name";
    $email_body = "You have received a new message from your website contact form.\n\n" .
                  "Here are the details:\n\n" .
                  "Name: $name\n\n" .
                  "Email: $email_address\n\n" .
                  "Phone: $phone\n\n" .
                  "Message:\n$message";
    $headers = "From: noreply@yourdomain.com\n"; // Use a valid sender email
    $headers .= "Reply-To: $email_address";

    // Attempt to send the email and handle errors
    if (mail($to, $email_subject, $email_body, $headers)) {
        echo "Message sent successfully!";
    } else {
        echo "Message delivery failed.";
    }
    return true;
}

// If the hidden field was filled out, it's likely a bot
echo "Gotcha, spambot!";
return false;
?>
