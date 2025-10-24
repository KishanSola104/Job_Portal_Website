<?php
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once 'includes/db_connect.php';
require_once 'includes/env.php'; // SMTP_USER and SMTP_PASS

$response = ['status' => 'error', 'message' => 'Something went wrong!'];

// Only allow POST requests
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // ----------------------------
    // Sanitize & validate input
    // ----------------------------
    $name       = trim($_POST['name'] ?? '');
    $email      = trim($_POST['email'] ?? '');
    $phone      = trim($_POST['phone'] ?? '');
    $address    = trim($_POST['address'] ?? '');
    $job_role   = trim($_POST['job_role'] ?? '');
    $experience = intval($_POST['experience'] ?? 0);
    $year       = intval($_POST['dob_year'] ?? 0);
    $month      = intval($_POST['dob_month'] ?? 0);
    $day        = intval($_POST['dob_day'] ?? 0);

    // Allowed job roles
    $allowed_jobs = [
        "Housekeeping","HousekeepingSupervisor","Laundry","Maintenance",
        "FrontDesk","Receptionist","Concierge",
        "Kitchen","ChefSpecialist","RestaurantService","BarStaff","RoomService",
        "Event","EventCoordinator","Security",
        "HotelManagement","AdminStaff","HR","Marketing","Other"
    ];

    if (
        strlen($name) < 2 ||
        !filter_var($email, FILTER_VALIDATE_EMAIL) ||
        !preg_match('/^\+?\d{8,15}$/', $phone) ||
        $year < 1900 || $month < 1 || $month > 12 || $day < 1 || $day > 31 ||
        strlen($address) < 5 ||
        empty($job_role) || !in_array($job_role, $allowed_jobs) ||
        $experience < 0
    ) {
        echo json_encode(['status'=>'error','message'=>'Invalid input data!']);
        exit;
    }

    $dob = sprintf('%04d-%02d-%02d', $year, $month, $day);

    // ----------------------------
    // Resume Upload
    // ----------------------------
    $uploadDir = __DIR__ . '/uploads/resumes/';
    if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true); // safer permissions

    if (!isset($_FILES['resume'])) {
        echo json_encode(['status'=>'error','message'=>'Resume file missing!']);
        exit;
    }

    $resume = $_FILES['resume'];
    $allowedExt = ['pdf','doc','docx'];
    $ext = strtolower(pathinfo($resume['name'], PATHINFO_EXTENSION));

    if (!in_array($ext, $allowedExt)) {
        echo json_encode(['status'=>'error','message'=>'Invalid resume format!']);
        exit;
    }

    if ($resume['size'] > 5*1024*1024) {
        echo json_encode(['status'=>'error','message'=>'Resume exceeds 5MB!']);
        exit;
    }

    // Safe filename: timestamp + sanitized original name
    $resumeName = 'resume_' . time() . '_' . preg_replace('/[^a-zA-Z0-9_\-\.]/','_', $resume['name']);
    $destination = $uploadDir . $resumeName;

    if (!move_uploaded_file($resume['tmp_name'], $destination)) {
        echo json_encode(['status'=>'error','message'=>'Failed to upload resume!']);
        exit;
    }

    // Optional: add .htaccess to prevent public access
    $htaccessFile = $uploadDir . '.htaccess';
    if (!file_exists($htaccessFile)) {
        file_put_contents($htaccessFile, "Options -Indexes\n<FilesMatch \"\.(pdf|doc|docx)$\">\nRequire all granted\n</FilesMatch>");
    }

    // ----------------------------
    // Insert into DB
    // ----------------------------
    $stmt = $conn->prepare("INSERT INTO candidate_applications (name,email,phone,dob,address,job_role,experience,resume) VALUES (?,?,?,?,?,?,?,?)");
    $stmt->bind_param("ssssssis", $name, $email, $phone, $dob, $address, $job_role, $experience, $resumeName);

    if ($stmt->execute()) {
        // ----------------------------
        // Send email notification
        // ----------------------------
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
            $mail->addReplyTo($email, $name);
            $mail->addAttachment($destination, $resumeName);

            $mail->isHTML(true);
            $mail->Subject = "New Candidate Application: " . htmlspecialchars($name);
            $mail->Body = "
                <h2>New Candidate Application</h2>
                <p><strong>Name:</strong> ".htmlspecialchars($name)."</p>
                <p><strong>Email:</strong> ".htmlspecialchars($email)."</p>
                <p><strong>Phone:</strong> ".htmlspecialchars($phone)."</p>
                <p><strong>DOB:</strong> $dob</p>
                <p><strong>Address:</strong> ".htmlspecialchars($address)."</p>
                <p><strong>Job Role:</strong> ".htmlspecialchars($job_role)."</p>
                <p><strong>Experience:</strong> $experience years</p>
                <p>The resume is attached with this email.</p>
            ";
            $mail->send();
        } catch(Exception $e){
            error_log("Mailer Error: " . $mail->ErrorInfo);
        }

        $response = ['status'=>'success','message'=>'✅ Application submitted successfully!'];
    } else {
        $response = ['status'=>'error','message'=>'Database insert failed!'];
    }

    $stmt->close();
}

$conn->close();
header('Content-Type: application/json');
echo json_encode($response);
exit;
?>
