<?php
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    die("Invalid request");
}

// Determine which form was submitted by checking which fields exist
$isContactForm = isset($_POST['description']);
$isMessageForm = isset($_POST['message']);

// CHANGE THIS EMAIL
$to = "janavalsans@gmail.com";

// ======================
// FORM 1: Contact Form (with description field)
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
    box-shadow:0 10px 25px rgba(0,0,0,0.08);">
    
    <tr>
    <td style="background:#111;color:#ffffff;padding:25px;text-align:center;">
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
    </html>
    ';
}

// ======================
// FORM 2: Message Form (with website field)
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
    box-shadow:0 10px 25px rgba(0,0,0,0.08);">
    
    <tr>
    <td style="background:#111;color:#ffffff;padding:25px;text-align:center;">
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
    </html>
    ';
}

else {
    die("Unknown form type");
}

// ======================
// Email headers
// ======================
$headers = "MIME-Version: 1.0\r\n";
$headers .= "Content-type:text/html;charset=UTF-8\r\n";
$headers .= "From: Website <noreply@yourdomain.com>\r\n";
$headers .= "Reply-To: $email\r\n";

// ======================
// Send mail
// ======================
$mailSent = mail($to, $subject, $message, $headers);

if ($mailSent) {
    echo "<div style='color:green;font-weight:600;'>The form was submitted successfully.</div>";
} else {
    echo "<div style='color:red;font-weight:600;'>Unable to send your message. Please try again later.</div>";
}
exit;
?>