<?php
session_start();
if(!isset($_SESSION['admin_logged_in'])) {
    exit("Unauthorized");
}
include("../includes/db_connect.php");

if(!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: partner_applications.php?msg=invalid");
    exit();
}

$id = (int)$_GET['id'];

// delete safely
$del = $conn->prepare("DELETE FROM partner_applications WHERE id = ?");
$del->bind_param("i", $id);
$del->execute();
$del->close();

header("Location: partner_applications.php?msg=deleted");
exit();
