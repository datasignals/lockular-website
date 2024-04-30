<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Function to redirect
function redirect($string) {
    header('Location: '.$string, true, 302);
    exit;
}

// Check if form was submitted
if (!isset($_POST)) {
    redirect('/');
}

// Process form data
$name = htmlspecialchars($_POST['full_name']);
$job = htmlspecialchars($_POST['job_title']);
$company = htmlspecialchars($_POST['company_name']);
$email = htmlspecialchars($_POST['email']);
$message = htmlspecialchars(nl2br($_POST['message']));

// Function to verify reCAPTCHA
function getCaptcha($SecretKey) {
    $Response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=" . '6LdwhUkpAAAAAD9quOKNsPqZ7OAljheaXFV_FrN8' . "&response={$SecretKey}");
    $Return = json_decode($Response);
    return $Return;
}

$Return = getCaptcha($_POST['g-recaptcha-response']);

if ($Return->success == true && $Return->score > 0.5) {
    require '/var/www/html/vendor/autoload.php'; // Include PHPMailer autoload.php

    $mail = new PHPMailer(true);
    try {
        // SMTP configuration using environment variables
        $mail->isSMTP();
        $mail->Host       = getenv('SMTP_SERVER');
        $mail->Port       = getenv('SMTP_PORT');
        $mail->SMTPAuth   = true;
        $mail->Username   = getenv('SMTP_USERNAME');
        $mail->Password   = getenv('SMTP_PASSWORD');
        $mail->SMTPSecure = 'tls'; // Use 'tls' or 'ssl' as per your SMTP configuration

        // Email content and settings
        $mail->setFrom('noreply@lockular.com', 'Lockular Website');
        $mail->addAddress('info@lockular.com');
        $mail->isHTML(true);
        $mail->Subject = "Website Enquiry Form by $name on " . date('d-m-Y');
        
        $webAddress = "https://www.lockular.com";

        $htmlMessage = "
            <html>
            <body>
                <h2>Website Enquiry | Contact Us </h2>
                <p><strong>Full Name:</strong> $name</p>
                <p><strong>Company Name:</strong> $company</p>
                <p><strong>Job Role:</strong> $job</p>
                <p><strong>Email Address:</strong> $email</p>
                <p><strong>Message:</strong></p>
                <p>$message</p>
                <p>This email was sent via the website form on " . date('d-m-Y') . "</p>
            </body>
            </html>
        ";

        
        $mail->Body = $htmlMessage;

        $mail->send();
        // Log message for successful email sending
        error_log('Email sent successfully.');
        // Redirect to a thank-you page after successful submission
        header('Location: /thank-you.html');
        exit();
    } catch (Exception $e) {
        // Log message for email sending failure
        error_log('Failed to send email: ' . $mail->ErrorInfo);
        // Display an error message to the user
        echo '<p>Message could not be sent.</p>';
    }
}
?>
