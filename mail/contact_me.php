<?php
// Ensure that the request is made using the POST method
if ($_SERVER["REQUEST_METHOD"] === "POST") {
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

    $name = strip_tags(trim($_POST['name']));
    $phone = strip_tags(trim($_POST['phone']));
    $message = strip_tags(trim($_POST['message']));

    // Check if the email is valid
    if ($email_address === FALSE) {
        echo 'Invalid email';
        exit(1);
    }

    // Set the recipient email address
    $to = 'matthew.mccormick2021@gmail.com'; // Your email address
    $email_subject = "Website Contact Form: $name";
    $email_body = "You have received a new message from your website contact form.\n\n" .
                  "Here are the details:\n\n" .
                  "Name: $name\n\n" .
                  "Email: $email_address\n\n" .
                  "Phone: $phone\n\n" .
                  "Message:\n$message";
    $headers = "From: noreply@gmail.com\n"; // The email address the generated message will be from
    $headers .= "Reply-To: $email_address";

    // Send the email
    if (mail($to, $email_subject, $email_body, $headers)) {
        echo "Message sent successfully!";
        return true;
    } else {
        echo "Message could not be sent. Please try again.";
        return false;
    }
} else {
    echo "Invalid request method!";
    return false;
}
?>

