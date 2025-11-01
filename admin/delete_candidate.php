<?php
session_start();
if(!isset($_SESSION['admin_logged_in'])) { 
    exit("Unauthorized Access");
}

include("../includes/db_connect.php");

if(!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: candidate_applications?msg=invalid");
    exit();
}

$id = (int)$_GET['id'];

// 1. Fetch resume filename before deleting
$getResume = $conn->prepare("SELECT resume FROM candidate_applications WHERE id = ?");
$getResume->bind_param("i", $id);
$getResume->execute();
$result = $getResume->get_result();

if($result->num_rows === 0){
    header("Location: candidate_applications?msg=notfound");
    exit();
}

$row = $result->fetch_assoc();
$resumeFile = $row['resume'];
$resumePath = "../uploads/resumes/" . $resumeFile;

// 2. Delete record using secure prepared stmt
$delete = $conn->prepare("DELETE FROM candidate_applications WHERE id = ?");
$delete->bind_param("i", $id);
$delete->execute();

// 3. If resume exists, delete the file
if(!empty($resumeFile) && file_exists($resumePath)){
    unlink($resumePath);
}

// 4. Redirect back with confirmation
header("Location: candidate_applications?msg=deleted");
exit();
?>
