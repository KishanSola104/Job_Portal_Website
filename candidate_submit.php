<?php
// ============================
// Candidate Application Submit
// ============================

ob_start();
session_start();
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . "/includes/env.php";
require_once __DIR__ . "/includes/db_connect.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$response = ['status' => 'error', 'message' => '❌ Something went wrong.'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Sanitize
    $name       = trim($_POST['name'] ?? '');
    $email      = trim($_POST['email'] ?? '');
    $phone      = trim($_POST['phone'] ?? '');
    $address    = trim($_POST['address'] ?? '');
    $job_role   = trim($_POST['job_role'] ?? '');
    $experience = intval($_POST['experience'] ?? 0);
    $year       = intval($_POST['dob_year'] ?? 0);
    $month      = intval($_POST['dob_month'] ?? 0);
    $day        = intval($_POST['dob_day'] ?? 0);

    // Resume check
    if (!isset($_FILES['resume']) || $_FILES['resume']['error'] != 0) {
        echo json_encode(['status'=>'error','message'=>'❌ Upload your resume!']);
        exit;
    }

    // Clean phone
    $phone_clean = preg_replace('/\s+/', '', $phone);

    // Validation
    if (strlen($name) < 2 || !filter_var($email, FILTER_VALIDATE_EMAIL) || !preg_match('/^\+?\s*(?:\d\s*){10,15}$/', $phone)) {
        $response['message'] = '❌ Invalid personal information.';
    } elseif(strlen($address) < 5) {
        $response['message'] = '❌ Address is too short.';
    } elseif(empty($job_role)) {
        $response['message'] = '❌ Select job role.';
    } elseif($experience < 0) {
        $response['message'] = '❌ Invalid experience.';
    } elseif(!$year || !$month || !$day) {
        $response['message'] = '❌ Select complete DOB.';
    } else {

        // Resume Upload
        $resume_name = time() . "_" . preg_replace('/[^a-zA-Z0-9_\.-]/','',basename($_FILES['resume']['name']));
        $resume_path = __DIR__ . "/uploads/resumes/" . $resume_name;

        if (!move_uploaded_file($_FILES['resume']['tmp_name'], $resume_path)) {
            echo json_encode(['status'=>'error','message'=>'❌ Failed to upload resume.']);
            exit;
        }

        $dob = sprintf("%04d-%02d-%02d", $year, $month, $day);

        // Insert
        $stmt = $conn->prepare("INSERT INTO candidate_applications (name,email,phone,dob,address,job_role,experience,resume) VALUES (?,?,?,?,?,?,?,?)");
        $stmt->bind_param("ssssssis", $name, $email, $phone_clean, $dob, $address, $job_role, $experience, $resume_name);

        if ($stmt->execute()) {

            $response['status'] = 'success';
            $response['message'] = '✅ Your application has been submitted successfully!';

            // Send Email
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
                    $mail->SMTPDebug  = TEST_MODE ? 2 : 0;

                    $mail->setFrom(SMTP_USER, 'ANU Hospitality Staff');
                    $mail->addAddress(ADMIN_EMAIL, 'Admin');
                    $mail->addReplyTo($email, $name);

                    $mail->isHTML(true);
                    $mail->Subject = '📩 New Candidate Application';

                    $adminLoginUrl = "https://anuhospitalitystaff.com/admin/login.php";
                
                    $submittedAt = date('Y-m-d H:i:s');

                    // ✅ Email Body
                    $mail->Body = <<<HTML
<h2>New Candidate Application</h2>
<p><strong>Name:</strong> {$name}</p>
<p><strong>Email:</strong> {$email}</p>
<p><strong>Phone:</strong> {$phone}</p>
<p><strong>Address:</strong> {$address}</p>
<p><strong>Job Role:</strong> {$job_role}</p>
<p><strong>Experience:</strong> {$experience} years</p>
<p><strong>Date of Birth:</strong> {$dob}</p>



<hr>
<p><strong>Submitted At:</strong> {$submittedAt}</p>

<a href="{$adminLoginUrl}" target="_blank" style="display:inline-block;padding:10px 16px;background:#004080;color:#fff;border-radius:6px;text-decoration:none;font-weight:600;">
🔐 Open Admin Panel
</a>
HTML;

                    $mail->send();

                } catch (Exception $e) {
                    error_log("Resume Mail Error: {$mail->ErrorInfo}");
                }
            }

        } else {
            $response['message'] = '⚠️ Database error. Try again.';
        }

        $stmt->close();
    }
}

$conn->close();

if (ob_get_length()) ob_end_clean();
echo json_encode($response);
exit;
?>
