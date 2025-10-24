<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$database = "anu_hospitality_staff";

$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$admin_username = trim($_POST['username']);
$admin_password = trim($_POST['password']);

// Fetch admin record
$stmt = $conn->prepare("SELECT * FROM admins WHERE username = ?");
$stmt->bind_param("s", $admin_username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
  $row = $result->fetch_assoc();

  // Verify password
  if (password_verify($admin_password, $row['password'])) {
    $_SESSION['admin_logged_in'] = true;
    $_SESSION['admin_username'] = $row['username'];
    header("Location: admin_dashboard.php");
    exit;
  } else {
    header("Location: login.php?error=Invalid Password");
    exit;
  }
} else {
  header("Location: login.php?error=Admin ID not found");
  exit;
}

$stmt->close();
$conn->close();
?>
