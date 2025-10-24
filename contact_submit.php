<?php
session_start();
require_once "includes/db_connect.php";
require_once "includes/env.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$response = ['status' => 'error', 'message' => '❌ Something went wrong.'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name    = trim($_POST['name'] ?? '');
    $email   = trim($_POST['email'] ?? '');
    $mobile  = trim($_POST['mobile'] ?? '');
    $message = trim($_POST['message'] ?? '');

    if (strlen($name) < 2 || !filter_var($email, FILTER_VALIDATE_EMAIL) || !preg_match('/^[0-9]{10,15}$/', $mobile) || strlen($message) < 5) {
        $response['message'] = '❌ Invalid input. Please check your entries.';
    } else {
        $stmt = $conn->prepare("INSERT INTO contact_messages (name, email, mobile, message) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $email, $mobile, $message);

        if ($stmt->execute()) {
            require 'PHPMailer/src/Exception.php';
            require 'PHPMailer/src/PHPMailer.php';
            require 'PHPMailer/src/SMTP.php';

            $mail = new PHPMailer(true);

            try {
                $mail->isSMTP();
                $mail->Host       = 'smtp.hostinger.com';
                $mail->SMTPAuth   = true;
                $mail->Username   = SMTP_USER;
                $mail->Password   = SMTP_PASS;
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port       = 587;

                $mail->setFrom(SMTP_USER, 'ANU Hospitality Staff');
                $mail->addAddress(SMTP_USER, 'Admin');
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
            }

            $response['status']  = 'success';
            $response['message'] = '✅ Thank you for contacting us! We’ll get back to you soon.';
        }
        $stmt->close();
    }
}

$conn->close();
header('Content-Type: application/json');
echo json_encode($response);
exit;
?>
