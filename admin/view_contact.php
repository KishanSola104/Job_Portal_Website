<?php
session_start();
if(!isset($_SESSION['admin_logged_in'])) { exit("Unauthorized"); }

include("../includes/db_connect.php");

if(!isset($_GET['id']) || !is_numeric($_GET['id'])){ exit("Invalid Request"); }

$id = intval($_GET['id']);

$sql = "SELECT name, email, mobile, message, sent_at FROM contact_messages WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$res = $stmt->get_result();

if($res->num_rows == 0){ exit("No Data Found"); }

$data = $res->fetch_assoc();
?>

<h3><?php echo htmlspecialchars($data['name']); ?></h3>

<p><b>Email:</b> <?php echo htmlspecialchars($data['email']); ?></p>
<p><b>Phone:</b> <?php echo htmlspecialchars($data['mobile']); ?></p>
<p><b>Received:</b> <?php echo $data['sent_at']; ?></p>
<p><b>Message:</b><br><?php echo nl2br(htmlspecialchars($data['message'])); ?></p>

<div style="margin-top:18px; display:flex; gap:10px;">
    <button onclick="closeModal()" style="background:#555; color:#fff; border:none; padding:8px 12px; border-radius:6px; cursor:pointer;">Close</button>

    <a href="mailto:<?php echo $data['email']; ?>?subject=Regarding your query" 
       style="background:#0078ff; color:#fff; padding:8px 12px; border-radius:6px; text-decoration:none;">
       Reply via Email
    </a>
</div>
