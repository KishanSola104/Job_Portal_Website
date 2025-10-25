<?php
ob_start(); // Start output buffering
session_start();
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . "/includes/env.php";
require_once __DIR__ . "/includes/db_connect.php";
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$response = ['status' => 'error', 'message' => '❌ Something went wrong.'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Sanitize input
    $name       = trim($_POST['name'] ?? '');
    $email      = trim($_POST['email'] ?? '');
    $phone      = trim($_POST['phone'] ?? '');
    $address    = trim($_POST['address'] ?? '');
    $job_role   = trim($_POST['job_role'] ?? '');
    $experience = intval($_POST['experience'] ?? 0);
    $year       = intval($_POST['dob_year'] ?? 0);
    $month      = intval($_POST['dob_month'] ?? 0);
    $day        = intval($_POST['dob_day'] ?? 0);

    // Validate resume
    if (!isset($_FILES['resume']) || $_FILES['resume']['error'] != 0) {
        echo json_encode(['status'=>'error','message'=>'❌ Upload your resume!']);
        exit;
    }

    // Server-side validation
    if (strlen($name)<2 || !filter_var($email,FILTER_VALIDATE_EMAIL) || !preg_match('/^\+?\d{8,15}$/',$phone)) {
        $response['message'] = '❌ Invalid personal information.';
    } elseif(strlen($address)<5) {
        $response['message'] = '❌ Address too short.';
    } elseif(empty($job_role)) {
        $response['message'] = '❌ Select a job role.';
    } elseif($experience<0) {
        $response['message'] = '❌ Invalid experience.';
    } elseif(!$year || !$month || !$day) {
        $response['message'] = '❌ Select complete DOB.';
    } else {

        $resume_name = time() . "_" . basename($_FILES['resume']['name']);
        $resume_path = __DIR__ . "/uploads/resumes/" . $resume_name;

        if (!move_uploaded_file($_FILES['resume']['tmp_name'], $resume_path)) {
            echo json_encode(['status'=>'error','message'=>'❌ Failed to upload resume.']);
            exit;
        }

        $dob = sprintf("%04d-%02d-%02d", $year, $month, $day);

        $stmt = $conn->prepare("INSERT INTO candidate_applications (name,email,phone,dob,address,job_role,experience,resume) VALUES (?,?,?,?,?,?,?,?)");
        if (!$stmt) {
            echo json_encode(['status'=>'error','message'=>'❌ Database error: '.$conn->error]);
            exit;
        }

        $stmt->bind_param("ssssssis",$name,$email,$phone,$dob,$address,$job_role,$experience,$resume_name);

        if($stmt->execute()){
            $response['status'] = 'success';
            $response['message'] = '✅ Your application has been submitted successfully!';

            // Send email (if configured)
            if(!empty(SMTP_USER) && !empty(SMTP_PASS)){
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
                    $mail->SMTPDebug  = 0; // important: disable debug output

                    $mail->setFrom(SMTP_USER,'ANU Hospitality Staff');
                    $mail->addAddress(ADMIN_EMAIL,'Admin');
                    $mail->addReplyTo($email,$name);

                    $mail->isHTML(true);
                    $mail->Subject = '📩 New Candidate Application';
                    $mail->Body    = "
                        <h2>New Candidate Application</h2>
                        <p><strong>Name:</strong> ".htmlspecialchars($name)."</p>
                        <p><strong>Email:</strong> ".htmlspecialchars($email)."</p>
                        <p><strong>Phone:</strong> ".htmlspecialchars($phone)."</p>
                        <p><strong>Address:</strong> ".htmlspecialchars($address)."</p>
                        <p><strong>Job Role:</strong> ".htmlspecialchars($job_role)."</p>
                        <p><strong>Experience:</strong> ".htmlspecialchars($experience)." years</p>
                        <p><strong>Date of Birth:</strong> ".htmlspecialchars($dob)."</p>
                        <p><strong>Resume:</strong> ".htmlspecialchars($resume_name)."</p>
                        <hr>
                        <p><strong>Submitted At:</strong> ".date('Y-m-d H:i:s')."</p>
                    ";
                    $mail->send();
                } catch(Exception $e){
                    error_log("Mailer Error: {$mail->ErrorInfo}");
                    $response['message'] .= " ⚠️ Email sending failed.";
                }
            }

        } else {
            $response['message'] = '⚠️ Failed to save application. '.$stmt->error;
        }

        $stmt->close();
    }
}

$conn->close();
if(ob_get_length()) ob_end_clean(); // remove any accidental output
echo json_encode($response);
exit;
?>