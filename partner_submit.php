<?php
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'includes/db_connect.php'; // $conn
require 'includes/env.php';        // SMTP_USER, SMTP_PASS

$response = ['status' => 'error', 'message' => 'Something went wrong!'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // --- Sanitize & get POST data ---
    $company_name   = trim($_POST['company_name'] ?? '');
    $contact_person = trim($_POST['contact_person'] ?? '');
    $email          = trim($_POST['email'] ?? '');
    $phone          = trim($_POST['phone'] ?? '');
    $website        = trim($_POST['website'] ?? '');
    $address        = trim($_POST['address'] ?? '');
    $service_type   = trim($_POST['service_type'] ?? '');
    $notes          = trim($_POST['notes'] ?? '');

    // --- Server-side validation ---
    if (strlen($company_name) < 2) {
        $response['message'] = 'Company name must be at least 2 characters.';
    } elseif (!preg_match('/^[a-zA-Z\s]+$/', $contact_person)) {
        $response['message'] = 'Contact person should contain only letters and spaces.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $response['message'] = 'Invalid email address.';
    } elseif (!preg_match('/^\+?\d{8,15}$/', $phone)) {
        $response['message'] = 'Phone number must be 8–15 digits, optional +.';
    } elseif (strlen($address) < 5) {
        $response['message'] = 'Address is too short.';
    } elseif (strlen($service_type) < 2) {
        $response['message'] = 'Service type is required.';
    } else {

        // --- Insert into database ---
        $stmt = $conn->prepare("
            INSERT INTO partner_applications 
            (company_name, contact_person, email, phone, website, address, service_type, notes)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)
        ");
        $stmt->bind_param(
            "ssssssss",
            $company_name,
            $contact_person,
            $email,
            $phone,
            $website,
            $address,
            $service_type,
            $notes
        );

        if ($stmt->execute()) {
            $response = ['status' => 'success', 'message' => 'Partner application submitted successfully!'];

            // --- Send email to admin ---
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
                $mail->addAddress(SMTP_USER, 'Admin');
                $mail->addReplyTo($email, $contact_person);

                $mail->isHTML(true);
                $mail->Subject = '📩 New Partner Application Received';
                $mail->Body    = "
                    <h3>New Partner Application</h3>
                    <p><strong>Company Name:</strong> " . htmlspecialchars($company_name) . "</p>
                    <p><strong>Contact Person:</strong> " . htmlspecialchars($contact_person) . "</p>
                    <p><strong>Email:</strong> " . htmlspecialchars($email) . "</p>
                    <p><strong>Phone:</strong> " . htmlspecialchars($phone) . "</p>
                    <p><strong>Website:</strong> " . htmlspecialchars($website) . "</p>
                    <p><strong>Address:</strong> " . htmlspecialchars($address) . "</p>
                    <p><strong>Service Type:</strong> " . htmlspecialchars($service_type) . "</p>
                    <p><strong>Notes:</strong> " . htmlspecialchars($notes) . "</p>
                    <hr>
                    <p><strong>Submitted At:</strong> " . date('Y-m-d H:i:s') . "</p>
                ";
                $mail->send();
            } catch (Exception $e) {
                error_log("Mailer Error: {$mail->ErrorInfo}");
            }

        } else {
            $response = ['status' => 'error', 'message' => 'Database insert failed!'];
        }

        $stmt->close();
    }
}

$conn->close();
header('Content-Type: application/json');
echo json_encode($response);
exit;
