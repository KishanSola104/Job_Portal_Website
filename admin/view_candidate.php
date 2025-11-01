<?php
session_start();
if(!isset($_SESSION['admin_logged_in'])) {
    http_response_code(403);
    exit("Unauthorized Access");
}

include("../includes/db_connect.php");

if(!isset($_GET['id']) || !is_numeric($_GET['id'])){
    exit("Invalid Request");
}

$id = (int)$_GET['id'];

$sql = "SELECT id, name, email, phone, dob, address, job_role, experience, resume 
        FROM candidate_applications WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if($result->num_rows === 0){
    exit("<p style='color:#d00;text-align:center;padding:12px;font-size:16px;'>No Record Found</p>");
}

$data = $result->fetch_assoc();

// Sanitize Output
$name = htmlspecialchars($data['name']);
$email = htmlspecialchars($data['email']);
$phone = htmlspecialchars($data['phone']);
$dob = htmlspecialchars($data['dob']);
$address = nl2br(htmlspecialchars($data['address']));
$job_role = htmlspecialchars($data['job_role']);
$experience = htmlspecialchars($data['experience']);
$resume_file = $data['resume'];
$resume_path = "../uploads/resumes/" . $resume_file;

// Check File Safety
$resume_available = (!empty($resume_file) && file_exists($resume_path));
?>

<div class="candidate-details">

    <h3><?php echo $name; ?></h3>

    <div class="details-row">
        <p><b>Email:</b> <?php echo $email; ?></p>
        <p><b>Phone:</b> <?php echo $phone; ?></p>
        <p class="full"><b>Date of Birth:</b> <?php echo $dob ?: '-'; ?></p>
        <p class="full"><b>Address:</b> <?php echo $address ?: '-'; ?></p>
        <p><b>Job Role:</b> <?php echo $job_role ?: '-'; ?></p>
        <p><b>Experience:</b> <?php echo $experience !== '' ? $experience . ' years' : '-'; ?></p>
    </div>

    <div class="btn-row">
        <button class="close-btn" onclick="closeModal()">Close</button>

        <?php if($resume_available): ?>
            <a class="download-btn" href="<?php echo $resume_path; ?>" download>
                <i class="fa-solid fa-download" style="margin-right:6px;"></i> Download Resume
            </a>
        <?php else: ?>
            <span class="no-resume">Resume Not Found</span>
        <?php endif; ?>
    </div>

</div>

<style>
.candidate-details{padding:5px 2px}.candidate-details h3{margin:0 0 10px;color:#004080;font-size:20px;font-weight:600}.details-row{display:flex;flex-wrap:wrap;gap:12px;margin:12px 0}.details-row p{margin:4px 0;font-size:15px;flex:1 1 45%;color:#222}.details-row p.full{flex:1 1 100%}.btn-row{display:flex;gap:10px;justify-content:flex-end;margin-top:18px;flex-wrap:wrap}.close-btn,.download-btn{padding:9px 14px;border-radius:6px;cursor:pointer;font-size:14px;border:none;text-decoration:none}.close-btn{background:#555;color:#fff}.close-btn:hover{background:#333}.download-btn{background:#0078ff;color:#fff}.download-btn:hover{background:#005fcc}.no-resume{background:#fff3f3;color:#c00;border:1px solid #fcc;padding:8px 12px;border-radius:6px;font-size:14px}@media (max-width:520px){.details-row p{flex:1 1 100%;font-size:14px}.btn-row{justify-content:center}.close-btn,.download-btn{width:100%;text-align:center}}
</style>
