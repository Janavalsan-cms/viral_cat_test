<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // 🔒 Sanitize input
    $name = htmlspecialchars(trim($_POST['name']));
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $phone = htmlspecialchars(trim($_POST['phone']));
    $description = htmlspecialchars(trim($_POST['description']));

    // 🔴 CHANGE THIS
    $to = "janavalsans@gmail.com";
    $subject = "✨ New Contact Submission — Happynex";

    // ================= EMAIL TEMPLATE =================
    $message = '
    <html>
    <head>
      <meta charset="UTF-8">
      <title>New Submission</title>
    </head>
    <body style="margin:0;padding:0;background:#f4f6f8;font-family:Arial,Helvetica,sans-serif;">

      <div style="max-width:620px;margin:40px auto;background:#ffffff;border-radius:12px;overflow:hidden;box-shadow:0 8px 24px rgba(0,0,0,0.08);">

        <!-- Header -->
        <div style="background:#7a2e2e;padding:20px 28px;">
          <h2 style="margin:0;color:#ffffff;font-weight:600;">
            Happynex — New Form Submission
          </h2>
        </div>

        <!-- Body -->
        <div style="padding:28px;color:#333333;line-height:1.6;">

          <p style="margin-top:0;color:#666;">
            Someone just submitted a form on your website. Here are the details:
          </p>

          <table width="100%" cellpadding="0" cellspacing="0" style="border-collapse:collapse;margin-top:20px;">

            <tr>
              <td style="padding:10px 0;color:#888;font-size:13px;width:140px;"><strong>Name</strong></td>
              <td style="padding:10px 0;color:#222;">'.$name.'</td>
            </tr>

            <tr>
              <td style="padding:10px 0;color:#888;font-size:13px;"><strong>Email</strong></td>
              <td style="padding:10px 0;">
                <a href="mailto:'.$email.'" style="color:#7a2e2e;text-decoration:none;font-weight:500;">'.$email.'</a>
              </td>
            </tr>

            <tr>
              <td style="padding:10px 0;color:#888;font-size:13px;"><strong>Phone</strong></td>
              <td style="padding:10px 0;color:#222;">'.$phone.'</td>
            </tr>

            <tr>
              <td style="padding:10px 0;color:#888;font-size:13px;vertical-align:top;"><strong>Description</strong></td>
              <td style="padding:10px 0;color:#222;">'.nl2br($description).'</td>
            </tr>

          </table>

        </div>

        <!-- Footer -->
        <div style="background:#fafafa;padding:18px 28px;font-size:12px;color:#999;text-align:center;">
          This message was sent from your website contact form.
        </div>

      </div>

    </body>
    </html>
    ';
    // ================= END TEMPLATE =================

    // ✅ HTML headers
    $headers = "MIME-Version: 1.0\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8\r\n";
    $headers .= "From: Happynex <noreply@yourdomain.com>\r\n";
    $headers .= "Reply-To: $email\r\n";

    // 🚀 Send mail
    if (mail($to, $subject, $message, $headers)) {
        echo "<script>alert('✅ Form submitted successfully!'); window.location.href=document.referrer;</script>";
    } else {
        echo "<script>alert('❌ Mail failed. Check server mail settings.'); window.history.back();</script>";
    }
}
?>
