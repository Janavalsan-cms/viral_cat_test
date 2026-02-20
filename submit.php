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
$isContactForm = isset($_POST['description']);              // contact form
$isMessageForm = isset($_POST['message']) && !$isJobForm && !$isContactForm; // simple message form
$isJobForm     = isset($_POST['experience']) || isset($_POST['cv_link']) || isset($_POST['position']); // job form


$to = "janavalsan@mindstory.in";

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
    <head>
    <meta charset="UTF-8">
    <title>New Submission</title>
    </head>
    <body style="margin:0;padding:0;background:#f4f6f8;font-family:Arial,sans-serif;">
    
    <table width="100%" cellpadding="0" cellspacing="0" style="background:#f4f6f8;padding:40px 0;">
    <tr>
    <td align="center">
    
    <table width="600" cellpadding="0" cellspacing="0"
    style="background:#ffffff;border-radius:10px;overflow:hidden;
    b">
    
    <tr>
    <td style="background:#6f3374;color:#ffffff;padding:25px;text-align:center;">
    <h2 style="margin:0;font-weight:600;">New Contact Form Submission</h2>
    </td>
    </tr>
    
    <tr>
    <td style="padding:30px;">
    <p style="margin-top:0;color:#555;font-size:14px;">
    Someone submitted a form on viralcatmeow.com. Here are the details:
    </p>
    
    <table width="100%" cellpadding="10" cellspacing="0"
    style="border-collapse:collapse;margin-top:20px;">
    
    <tr>
    <td style="border-bottom:1px solid #eee;font-weight:bold;width:30%;">Name</td>
    <td style="border-bottom:1px solid #eee;">' . $name . '</td>
    </tr>
    
    <tr>
    <td style="border-bottom:1px solid #eee;font-weight:bold;">Email</td>
    <td style="border-bottom:1px solid #eee;">
    <a href="mailto:' . $email . '" style="color:#0073e6;text-decoration:none;">' . $email . '</a>
    </td>
    </tr>
    
    <tr>
    <td style="border-bottom:1px solid #eee;font-weight:bold;">Phone</td>
    <td style="border-bottom:1px solid #eee;">' . $phone . '</td>
    </tr>
    
    <tr>
    <td style="border-bottom:1px solid #eee;font-weight:bold;">Message</td>
    <td style="border-bottom:1px solid #eee;">' . nl2br($description) . '</td>
    </tr>
    
    </table>
    </td>
    </tr>
    
    <tr>
    <td style="background:#f9fafb;padding:20px;text-align:center;font-size:12px;color:#888;">
    This email was generated from your website contact form.
    </td>
    </tr>
    
    </table>
    
    </td>
    </tr>
    </table>
    
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
    <head>
    <meta charset="UTF-8">
    <title>New Contact Message</title>
    </head>
    <body style="margin:0;padding:0;background:#f4f6f8;font-family:Arial,sans-serif;">
    
    <table width="100%" cellpadding="0" cellspacing="0" style="background:#f4f6f8;padding:40px 0;">
    <tr>
    <td align="center">
    
    <table width="600" cellpadding="0" cellspacing="0"
    style="background:#ffffff;border-radius:10px;overflow:hidden;
    b">
    
    <tr>
    <td style="background:#6f3374;color:#ffffff;padding:25px;text-align:center;">
    <h2 style="margin:0;">New Contact Form Submission</h2>
    </td>
    </tr>
    
    <tr>
    <td style="padding:30px;">
    <p style="margin-top:0;color:#555;font-size:14px;">
    Someone submitted a form on viralcatmeow.com. Here are the details:
    </p>
    
    <table width="100%" cellpadding="10" cellspacing="0"
    style="border-collapse:collapse;">
    
    <tr>
    <td style="border-bottom:1px solid #eee;font-weight:bold;width:35%;">Name</td>
    <td style="border-bottom:1px solid #eee;">' . $name . '</td>
    </tr>
    
    <tr>
    <td style="border-bottom:1px solid #eee;font-weight:bold;">Email</td>
    <td style="border-bottom:1px solid #eee;">
    <a href="mailto:' . $email . '">' . $email . '</a>
    </td>
    </tr>
    
    <tr>
    <td style="border-bottom:1px solid #eee;font-weight:bold;">Website</td>
    <td style="border-bottom:1px solid #eee;">' . $website . '</td>
    </tr>
    
    <tr>
    <td style="border-bottom:1px solid #eee;font-weight:bold;">Message</td>
    <td style="border-bottom:1px solid #eee;">' . nl2br($messageText) . '</td>
    </tr>
    
    </table>
    
    </td>
    </tr>
    
    <tr>
    <td style="background:#f9fafb;padding:18px;text-align:center;font-size:12px;color:#888;">
    This email was generated from your website contact form.
    </td>
    </tr>
    
    </table>
    
    </td>
    </tr>
    </table>
    
    </body>
    </html>';
}

// ======================
// FORM 3: Job application (experience + position + cv)
// ======================
elseif ($isJobForm) {
    $position   = htmlspecialchars(trim($_POST['position'] ?? ''));
    $name       = htmlspecialchars(trim($_POST['name'] ?? ''));
    $email      = filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL);
    $phone      = htmlspecialchars(trim($_POST['phone'] ?? ''));
    $experience = htmlspecialchars(trim($_POST['experience'] ?? ''));
    $portfolio  = htmlspecialchars(trim($_POST['portfolio'] ?? ''));
    $cv_link    = htmlspecialchars(trim($_POST['cv_link'] ?? ''));
    $messageText= htmlspecialchars(trim($_POST['message'] ?? ''));

    if (!$name || !$email || !$phone || !$experience || !$messageText) {
        die("Missing required fields");
    }

    // Optional URL validation (recommended)
    if ($portfolio && !filter_var($portfolio, FILTER_VALIDATE_URL)) {
        die("Invalid Portfolio URL");
    }
    if ($cv_link && !filter_var($cv_link, FILTER_VALIDATE_URL)) {
        die("Invalid CV Link URL");
    }

    $subject = "New Job Application" . ($position ? " - $position" : "");

    $message = '
    <html><head><meta charset="UTF-8"></head>
    <body style="margin:0;padding:0;background:#f4f6f8;font-family:Arial,sans-serif;">
      <table width="100%" cellpadding="0" cellspacing="0" style="background:#f4f6f8;padding:40px 0;">
        <tr><td align="center">
          <table width="600" cellpadding="0" cellspacing="0" style="background:#fff;border-radius:10px;overflow:hidden;">
            <tr>
              <td style="background:#6f3374;color:#fff;padding:25px;text-align:center;">
                <h2 style="margin:0;font-weight:600;">New Job Application</h2>
              </td>
            </tr>
            <tr><td style="padding:30px;">
              <p style="margin-top:0;color:#555;font-size:14px;">
                A candidate submitted an application on viralcatmeow.com. Details:
              </p>

              <table width="100%" cellpadding="10" cellspacing="0" style="border-collapse:collapse;margin-top:20px;">
                <tr>
                  <td style="border-bottom:1px solid #eee;font-weight:bold;width:35%;">Position</td>
                  <td style="border-bottom:1px solid #eee;">' . ($position ?: '-') . '</td>
                </tr>
                <tr>
                  <td style="border-bottom:1px solid #eee;font-weight:bold;">Name</td>
                  <td style="border-bottom:1px solid #eee;">' . $name . '</td>
                </tr>
                <tr>
                  <td style="border-bottom:1px solid #eee;font-weight:bold;">Email</td>
                  <td style="border-bottom:1px solid #eee;">
                    <a href="mailto:' . $email . '" style="color:#0073e6;text-decoration:none;">' . $email . '</a>
                  </td>
                </tr>
                <tr>
                  <td style="border-bottom:1px solid #eee;font-weight:bold;">Phone</td>
                  <td style="border-bottom:1px solid #eee;">' . $phone . '</td>
                </tr>
                <tr>
                  <td style="border-bottom:1px solid #eee;font-weight:bold;">Experience</td>
                  <td style="border-bottom:1px solid #eee;">' . $experience . '</td>
                </tr>
                <tr>
                  <td style="border-bottom:1px solid #eee;font-weight:bold;">Portfolio/LinkedIn</td>
                  <td style="border-bottom:1px solid #eee;">' . ($portfolio ? '<a href="'.$portfolio.'" target="_blank">'.$portfolio.'</a>' : '-') . '</td>
                </tr>
                <tr>
                  <td style="border-bottom:1px solid #eee;font-weight:bold;">CV Link</td>
                  <td style="border-bottom:1px solid #eee;">' . ($cv_link ? '<a href="'.$cv_link.'" target="_blank">'.$cv_link.'</a>' : '-') . '</td>
                </tr>
                <tr>
                  <td style="border-bottom:1px solid #eee;font-weight:bold;">Why interested?</td>
                  <td style="border-bottom:1px solid #eee;">' . nl2br($messageText) . '</td>
                </tr>
              </table>

            </td></tr>

            <tr>
              <td style="background:#f9fafb;padding:18px;text-align:center;font-size:12px;color:#888;">
                This email was generated from your website job application form.
              </td>
            </tr>
          </table>
        </td></tr>
      </table>
    </body></html>';
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
$mail->Password   = 'mjgrzsoyluvyiewk';
$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; 
$mail->Port       = 587; 

    // Email settings
    $mail->setFrom('viralcatmailer@gmail.com', 'Viral Cat Agency Website');
    $mail->addAddress($to);

    // CC
    $mail->addCC('lijoy@mindstory.in');
    $mail->addCC('lijoymindstory@gmail.com');

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
