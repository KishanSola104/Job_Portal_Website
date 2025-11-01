<?php
ob_start();
session_start();
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
header('Content-Type: application/json; charset=utf-8');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'includes/db_connect.php';
require 'includes/env.php';

$response = ['status' => 'error', 'message' => '❌ Something went wrong.'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $company_name   = trim($_POST['company_name'] ?? '');
    $contact_person = trim($_POST['contact_person'] ?? '');
    $email          = trim($_POST['email'] ?? '');
    $phone          = trim($_POST['phone'] ?? '');
    $website        = trim($_POST['website'] ?? '');
    $address        = trim($_POST['address'] ?? '');
    $service_type   = trim($_POST['service_type'] ?? '');
    $notes          = trim($_POST['notes'] ?? '');

    // Clean phone
    $phone_clean = preg_replace('/\s+/', '', $phone);

    // Validation
    if (strlen($company_name) < 2) {
        $response['message'] = '❌ Company name must be at least 2 characters.';
    } elseif (!preg_match('/^[a-zA-Z\s]+$/', $contact_person)) {
        $response['message'] = '❌ Contact person should contain only letters and spaces.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $response['message'] = '❌ Invalid email address.';
    } elseif (!preg_match('/^\+?\d{10,15}$/', $phone_clean)) {
        $response['message'] = '❌ Phone number must be 10–15 digits, optional +.';
    } elseif (strlen($address) < 5) {
        $response['message'] = '❌ Address is too short.';
    } elseif (strlen($service_type) < 2) {
        $response['message'] = '❌ Service type is required.';
    } else {

        $stmt = $conn->prepare("
            INSERT INTO partner_applications 
            (company_name, contact_person, email, phone, website, address, service_type, notes)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)
        ");

        if (!$stmt) {
            $response['message'] = '❌ Database error: ' . $conn->error;
            echo json_encode($response); exit;
        }

        $stmt->bind_param(
            "ssssssss",
            $company_name,
            $contact_person,
            $email,
            $phone_clean,
            $website,
            $address,
            $service_type,
            $notes
        );

        if ($stmt->execute()) {

            $response['status']  = 'success';
            $response['message'] = '✅ Partner application submitted successfully!';

            // Send admin notification email
            if (!empty(SMTP_USER) && !empty(SMTP_PASS)) {
                try {
                    $mail = new PHPMailer(true);
                    $mail->isSMTP();
                    $mail->Host       = 'smtp.hostinger.com';
                    $mail->SMTPAuth   = true;
                    $mail->Username   = SMTP_USER;
                    $mail->Password   = SMTP_PASS;
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                    $mail->Port       = 587;

                    $mail->setFrom(SMTP_USER, 'ANU Hospitality Staff');
                    $mail->addAddress(ADMIN_EMAIL, 'Admin');
                    $mail->addReplyTo($email, $contact_person);

                    $mail->isHTML(true);
                    $mail->Subject = '📩 New Partner Application Received';

                    $adminLoginUrl = "https://anuhospitalitystaff.com/admin/login.php";
                    $submittedAt   = date('Y-m-d H:i:s');

                    $mail->Body = <<<HTML
<h3>New Partner Application</h3>
<p><strong>Company Name:</strong> {$company_name}</p>
<p><strong>Contact Person:</strong> {$contact_person}</p>
<p><strong>Email:</strong> {$email}</p>
<p><strong>Phone:</strong> {$phone}</p>
<p><strong>Website:</strong> {$website}</p>
<p><strong>Address:</strong> {$address}</p>
<p><strong>Service Type:</strong> {$service_type}</p>
<p><strong>Notes:</strong> {$notes}</p>

<hr>
<p><strong>Submitted At:</strong> {$submittedAt}</p>

<a href="{$adminLoginUrl}" target="_blank" style="
    display:inline-block;
    margin-top:10px;
    padding:10px 16px;
    background:#004080;
    color:#fff;
    border-radius:6px;
    text-decoration:none;
    font-weight:600;">
-> Open Admin Panel
</a>
HTML;

                    $mail->send();

                } catch (Exception $e) {
                    error_log("Mailer Error: {$mail->ErrorInfo}");
                }
            }

        } else {
            $response['message'] = '❌ Database insert failed: '.$stmt->error;
        }

        $stmt->close();
    }
}

$conn->close();

if (ob_get_length()) ob_clean();
echo json_encode($response);
exit;
?>
