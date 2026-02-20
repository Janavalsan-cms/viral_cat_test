
<?php
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    die("Invalid request");
}

// ======================
// LOAD PHPMailer
// ======================
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'assets/PHPMailer.php';
require 'assets/SMTP.php';
require 'assets/Exception.php';

// ======================
// Detect form type
// ======================
$isContactForm = isset($_POST['description']);
$isMessageForm = isset($_POST['message']);

$to = "janavalsandev@gmail.com";

// ======================
// FORM 1
// ======================
if ($isContactForm) {
    $name = htmlspecialchars(trim($_POST['name'] ?? ''));
    $email = filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL);
    $phone = htmlspecialchars(trim($_POST['phone'] ?? ''));
    $description = htmlspecialchars(trim($_POST['description'] ?? ''));

    if (!$name || !$email) {
        die("Required fields missing");
    }

    $subject = "New Contact Form Submission";

    $message = '
    <html>
    <body style="font-family:Arial;background:#f4f6f8;padding:20px;">
    <h2>New Contact Form Submission</h2>
    <p><strong>Name:</strong> ' . $name . '</p>
    <p><strong>Email:</strong> ' . $email . '</p>
    <p><strong>Phone:</strong> ' . $phone . '</p>
    <p><strong>Message:</strong><br>' . nl2br($description) . '</p>
    </body>
    </html>';
}

// ======================
// FORM 2
// ======================
elseif ($isMessageForm) {
    $name = htmlspecialchars(trim($_POST['name'] ?? ''));
    $email = filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL);
    $website = htmlspecialchars(trim($_POST['website'] ?? ''));
    $messageText = htmlspecialchars(trim($_POST['message'] ?? ''));

    if (!$name || !$email || !$messageText) {
        die("Missing required fields");
    }

    $subject = "New Contact Form Submission";

    $message = '
    <html>
    <body style="font-family:Arial;background:#f4f6f8;padding:20px;">
    <h2>New Contact Message</h2>
    <p><strong>Name:</strong> ' . $name . '</p>
    <p><strong>Email:</strong> ' . $email . '</p>
    <p><strong>Website:</strong> ' . $website . '</p>
    <p><strong>Message:</strong><br>' . nl2br($messageText) . '</p>
    </body>
    </html>';
}

else {
    die("Unknown form type");
}

// ======================
// SEND VIA ZOHO SMTP
// ======================
$mail = new PHPMailer(true);

try {
    // SMTP SETTINGS
$mail->isSMTP();
$mail->Host       = 'smtp.gmail.com';
$mail->SMTPAuth   = true;
$mail->Username   = 'viralcatmailer@gmail.com';
$mail->Password   = 'welcom##vca..123';
$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // ✅ SMTPS for 465
$mail->Port       = 587; // ✅

    // Email settings
    $mail->setFrom('viralcatmailer@gmail.com', 'Viral Cat Agency Website');
    $mail->addAddress($to);

    // CC
    // $mail->addCC('lijoy@mindstory.in');
    // $mail->addCC('jvwork001@gmail.com');
    // $mail->addCC('lijoymindstory@gmail.com');

    // Reply to customer
    $mail->addReplyTo($email, $name);

    // Content
    $mail->isHTML(true);
    $mail->Subject = $subject;
    $mail->Body    = $message;

    $mail->send();

    echo "<div style='color:green;font-weight:600;'>The form was submitted successfully.</div>";

} catch (Exception $e) {
    echo "<div style='color:red;font-weight:600;'>Mailer Error: {$mail->ErrorInfo}</div>";
}
exit;
?>
