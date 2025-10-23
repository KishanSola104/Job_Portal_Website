<?php
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$database = "anu_hospitality_staff";

$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die(json_encode(['status' => 'error','message' => 'Database connection failed.']));
}

// Get POST data
$name = trim($_POST['name']);
$email = trim($_POST['email']);
$phone = trim($_POST['phone']);
$address = trim($_POST['address']);
$job_role = trim($_POST['job_role']);
$experience = intval($_POST['experience']);
$year = intval($_POST['dob_year']);
$month = intval($_POST['dob_month']);
$day = intval($_POST['dob_day']);

// Combine DOB
$dob = sprintf('%04d-%02d-%02d', $year, $month, $day);

// Resume upload
$uploadDir = __DIR__ . '/uploads/resumes/';
$resume = $_FILES['resume'] ?? null;

if (!$resume) {
    echo json_encode(['status'=>'error','message'=>'Resume file missing!']);
    exit;
}

// Validate resume
$allowedExt = ['pdf','doc','docx'];
$ext = strtolower(pathinfo($resume['name'], PATHINFO_EXTENSION));

if (!in_array($ext, $allowedExt)) {
    echo json_encode(['status'=>'error','message'=>'Invalid resume format!']);
    exit;
}

if ($resume['size'] > 5 * 1024 * 1024) {
    echo json_encode(['status'=>'error','message'=>'Resume exceeds 5MB!']);
    exit;
}

// Generate unique filename
$resumeName = 'resume_' . time() . '_' . preg_replace('/[^a-zA-Z0-9_\-\.]/','_', $resume['name']);
$destination = $uploadDir . $resumeName;

// Move uploaded file
if (!move_uploaded_file($resume['tmp_name'], $destination)) {
    echo json_encode(['status'=>'error','message'=>'Failed to upload resume!']);
    exit;
}

// Insert into database
$stmt = $conn->prepare("INSERT INTO candidate_applications (name,email,phone,dob,address,job_role,experience,resume) VALUES (?,?,?,?,?,?,?,?)");
$stmt->bind_param("ssssssis", $name, $email, $phone, $dob, $address, $job_role, $experience, $resumeName);

if ($stmt->execute()) {
    // Send email to admin
    try {
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host = 'smtp.yourdomain.com'; // replace with your SMTP host
        $mail->SMTPAuth = true;
        $mail->Username = 'your_email@domain.com'; // replace with your email
        $mail->Password = 'your_email_password';   // replace with your email password
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('your_email@domain.com', 'ANU Hospitality Staff');
        $mail->addAddress('admin@anuhospitality.com', 'Admin'); // admin email
        $mail->addReplyTo($email, $name);

        // Attach resume
        $mail->addAttachment($destination, $resumeName);

        // Email content
        $mail->isHTML(true);
        $mail->Subject = "New Candidate Application: $name";
        $mail->Body = "
            <h2>New Candidate Application Received</h2>
            <p><strong>Name:</strong> $name</p>
            <p><strong>Email:</strong> $email</p>
            <p><strong>Phone:</strong> $phone</p>
            <p><strong>Date of Birth:</strong> $dob</p>
            <p><strong>Address:</strong> $address</p>
            <p><strong>Job Role:</strong> $job_role</p>
            <p><strong>Experience:</strong> $experience years</p>
            <p>The resume is attached with this email.</p>
        ";
        $mail->send();
    } catch (Exception $e) {
        // Log the email error, but do not fail form submission
        error_log("Mailer Error: " . $mail->ErrorInfo);
    }

    $response = ['status'=>'success','message'=>'Application submitted successfully!'];
} else {
    $response = ['status'=>'error','message'=>'Database insert failed!'];
}

$stmt->close();
$conn->close();

header('Content-Type: application/json');
echo json_encode($response);
exit;
?>
