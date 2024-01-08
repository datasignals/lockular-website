<?php

function redirect($string) {
    header('Location: '.$string, true, 302);
    exit;
}

if(!isset($_POST)) {
    redirect('/');
    exit;
}

$name = htmlspecialchars($_POST['full_name']);
$job = htmlspecialchars($_POST['job_title']);
$company = htmlspecialchars($_POST['company_name']);
$email = htmlspecialchars($_POST['email']);
$message = htmlspecialchars(nl2br($_POST['message']));

// Log message for checking POST data
error_log('Received POST data: ' . print_r($_POST, true));

$webAddress = "https://www.lockular.com";
$htmlMessage = "
    <table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">
        <tr>
            <td align=\"center\">
                <table width=\"400px\" border=\"0\" cellpadding=\"10\" cellspacing=\"0\">
                    <tr>
                        <td><img src=\"$webAddress/assets/img/logos/1x/logo.png\" alt=\"Lockular\" width=\"350\"></td>
                    </tr>
                    <tr>
                        <td>
                            <hr />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p><strong>Full Name:</strong> $name</p>
                            <p><strong>Company Name:</strong> $company</p>
                            <p><strong>Job Role:</strong> $job</p>
                            <p><strong>Email Address:</strong> $email</p>
                            <hr>
                            <p><strong>Message:</strong> $message</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
";

function getCaptcha($SecretKey) {
    $Response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=" . '6LdwhUkpAAAAAD9quOKNsPqZ7OAljheaXFV_FrN8' . "&response={$SecretKey}");
    $Return = json_decode($Response);
    return $Return;
}

$Return = getCaptcha($_POST['g-recaptcha-response']);

if( $Return->success == true && $Return->score > 0.5 ){
    $from = "Lockular Website <noreply@lockular.com>";
    $to = "info@lockular.in";
    $subject = "Website Enquiry Form by " . $name . " on " . date('d-m-Y');

    $headers  = "Reply-To: $email" . "\r\n";
    $headers .= 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    $headers .= "From: $from" . "\r\n";

    // Log message for checking email headers and content
    error_log('Email headers: ' . print_r($headers, true));
    error_log('Email content: ' . $htmlMessage);

    if ( mail( $to, $subject, $htmlMessage, $headers ) ) :
        // Log message for successful email sending
        error_log('Email sent successfully.');
        redirect('/thank-you.html');
    else :
        // Log message for email sending failure
        error_log('Failed to send email.');
        echo '<p>Message could not be sent.</p>';
    endif;
}
