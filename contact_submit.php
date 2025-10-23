<?php
// Start session if needed
session_start();

// Database connection
$servername = "localhost";
$username = "root"; // change if needed
$password = ""; // change if needed
$database = "anu_hospitality_staff";

$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die(json_encode([
        'status' => 'error',
        'message' => 'Database connection failed.'
    ]));
}

// Sanitize user input
$name = trim($_POST['name']);
$email = trim($_POST['email']);
$mobile = trim($_POST['mobile']);
$message = trim($_POST['message']);

// Prepared statement for safe insert
$stmt = $conn->prepare("INSERT INTO contact_messages (name, email, mobile, message) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $name, $email, $mobile, $message);

$response = [];

if ($stmt->execute()) {
    // --- PHPMailer Notification ---
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require 'PHPMailer/src/Exception.php';
    require 'PHPMailer/src/PHPMailer.php';
    require 'PHPMailer/src/SMTP.php';

    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.yourdomain.com'; // replace with your hosting SMTP
        $mail->SMTPAuth = true;
        $mail->Username = 'info@anuhospitalitystaff.com'; // your professional email
        $mail->Password = 'your-email-password'; // email password
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('info@anuhospitalitystaff.com', 'ANU Hospitality Staff');
        $mail->addAddress('info@anuhospitalitystaff.com', 'Admin'); // admin
        $mail->addReplyTo($email, $name); // reply goes to user

        $mail->isHTML(true);
        $mail->Subject = 'New Contact Us Message';
        $mail->Body = "
            <h2>New Contact Form Submission</h2>
            <p><strong>Name:</strong> $name</p>
            <p><strong>Email:</strong> $email</p>
            <p><strong>Mobile:</strong> $mobile</p>
            <p><strong>Message:</strong> $message</p>
            <p><strong>Sent At:</strong> ".date('Y-m-d H:i:s')."</p>
        ";

        $mail->send();
    } catch (Exception $e) {
        error_log("Mailer Error: {$mail->ErrorInfo}");
    }

    // --- JSON Response for AJAX ---
    $response['status'] = 'success';
    $response['message'] = 'Thank you for contacting us! We will get back to you soon.';
} else {
    $response['status'] = 'error';
    $response['message'] = 'Oops! Something went wrong. Please try again later.';
}

// Close DB connection
$stmt->close();
$conn->close();

// Send JSON response
header('Content-Type: application/json');
echo json_encode($response);
exit;
?>
