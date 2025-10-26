<?php
// Start session and suppress notices/warnings that can break JSON
session_start();
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);

// Force JSON output
header('Content-Type: application/json; charset=utf-8');

// Include environment and DB
require_once __DIR__ . "/includes/env.php";
require_once __DIR__ . "/includes/db_connect.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Default response
$response = ['status' => 'error', 'message' => '❌ Something went wrong.'];

// Only handle POST requests
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Sanitize POST input
    $name    = trim($_POST['name'] ?? '');
    $email   = trim($_POST['email'] ?? '');
    $mobile  = trim($_POST['mobile'] ?? '');
    $message = trim($_POST['message'] ?? '');

    // Remove spaces from mobile for DB
    $mobile_clean = preg_replace('/\s+/', '', $mobile);

    // Server-side validation
    if (
        strlen($name) < 2 || 
        !filter_var($email, FILTER_VALIDATE_EMAIL) || 
        !preg_match('/^\+?\s*(?:\d\s*){10,15}$/', $mobile) || 
        strlen($message) < 5
    ) {
        $response['message'] = '❌ Invalid input. Please check your entries.';
    } else {

        // Insert into database
        $stmt = $conn->prepare("INSERT INTO contact_messages (name, email, mobile, message) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $email, $mobile_clean, $message);

        if ($stmt->execute()) {

            $response['status']  = 'success';
            $response['message'] = '✅ Thank you for contacting us! We’ll get back to you soon.';

            // Send email only if SMTP credentials exist
            if (!empty(SMTP_USER) && !empty(SMTP_PASS)) {

                require __DIR__ . '/PHPMailer/src/Exception.php';
                require __DIR__ . '/PHPMailer/src/PHPMailer.php';
                require __DIR__ . '/PHPMailer/src/SMTP.php';

                $mail = new PHPMailer(true);

                try {
                    $mail->isSMTP();
                    $mail->Host       = 'smtp.hostinger.com';
                    $mail->SMTPAuth   = true;
                    $mail->Username   = SMTP_USER;
                    $mail->Password   = SMTP_PASS;
                    $mail->SMTPSecure = 'tls';
                    $mail->Port       = 587;

                    // Optional: enable debug while testing
                    if (TEST_MODE) {
                        $mail->SMTPDebug = 2;
                        $mail->Debugoutput = 'html';
                    } else {
                        $mail->SMTPDebug = 0;
                    }

                    $mail->setFrom(SMTP_USER, 'ANU Hospitality Staff');
                    $mail->addAddress(ADMIN_EMAIL, 'Admin');
                    $mail->addReplyTo($email, $name);

                    $mail->isHTML(true);
                    $mail->Subject = '📩 New Contact Us Message';
                    $mail->Body    = "
                        <h2>New Contact Form Submission</h2>
                        <p><strong>Name:</strong> " . htmlspecialchars($name) . "</p>
                        <p><strong>Email:</strong> " . htmlspecialchars($email) . "</p>
                        <p><strong>Mobile:</strong> " . htmlspecialchars($mobile) . "</p>
                        <p><strong>Message:</strong> " . nl2br(htmlspecialchars($message)) . "</p>
                        <hr>
                        <p><strong>Sent At:</strong> " . date('Y-m-d H:i:s') . "</p>
                    ";

                    $mail->send();

                } catch (Exception $e) {
                    error_log("Mailer Error: {$mail->ErrorInfo}");
                    if (TEST_MODE) {
                        $response['status']  = 'warning';
                        $response['message'] .= " ⚠️ Email warning: {$mail->ErrorInfo}";
                    }
                }
            }

        } else {
            $response['message'] = '⚠️ Failed to save your message. Please try again later.';
        }

        $stmt->close();
    }
}

$conn->close();

// Clear any accidental output before sending JSON
if (ob_get_length()) ob_clean();
echo json_encode($response);
exit;
?>
