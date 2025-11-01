<?php
session_start();
if(!isset($_SESSION['admin_logged_in'])) { exit("Unauthorized"); }

include("../includes/db_connect.php");

if(isset($_GET['id']) && is_numeric($_GET['id'])){
    $id = intval($_GET['id']);
    $conn->query("DELETE FROM contact_messages WHERE id=$id");
}

header("Location: contact_queries.php");
exit();
?>
