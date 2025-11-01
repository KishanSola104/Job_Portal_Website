<?php
session_start();
include("../includes/db_connect.php");

// If already logged in -> redirect
if(isset($_SESSION['admin_logged_in'])) {
    header("Location: dashboard");
    exit();
}

$message = "";

if(isset($_POST['login'])) {

    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Prepared statement to prevent SQL Injection
    $stmt = $conn->prepare("SELECT username, password FROM admins WHERE username = ? LIMIT 1");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows === 1) {
        $row = $result->fetch_assoc();

        if(password_verify($password, $row['password'])) {
            // Prevent session fixation attack
            session_regenerate_id(true);

            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_username'] = $row['username'];

            header("Location: dashboard");
            exit();
        } else {
            $message = "Incorrect password!";
        }
    } else {
        $message = "Username not found!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Admin Login | Anu Hospitality Staff LTD</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>
   .login-box,body{background:#fff}body{margin:0;padding:0;font-family:Arial,sans-serif;display:flex;justify-content:center;align-items:center;height:100vh}.login-box{width:100%;max-width:400px;border:1px solid #dcdcdc;border-radius:8px;padding:30px;box-shadow:0 0 8px rgba(0,0,0,.08)}.login-box h2{text-align:center;margin:0 0 5px;color:#004080;font-size:22px;text-transform:uppercase;letter-spacing:1px}.error-msg,.login-box p{font-size:14px;text-align:center}.login-box p{margin-bottom:20px;color:#6b6b6b}.login-box input{width:100%;padding:12px;border-radius:5px;border:1px solid #bfbfbf;margin-bottom:15px;font-size:15px}.login-box button{width:100%;padding:12px;background:#004080;border:none;color:#fff;border-radius:5px;font-size:16px;cursor:pointer;transition:.3s;text-transform:uppercase}.login-box button:hover{background:#0078ff}.error-msg{background:#ffe6e6;border:1px solid red;padding:8px;border-radius:4px;margin-bottom:15px;color:#b30000}.footer{position:fixed;bottom:10px;width:100%;text-align:center;font-size:13px;color:#555}@media(max-width:480px){.login-box{margin:0 15px;padding:25px}.login-box h2{font-size:20px}}
</style>
</head>
<body>

<div class="login-box">

    <h2>Anu Hospitality Staff LTD</h2>
    <p>Admin Login Portal</p>

    <?php if($message != "") { echo "<div class='error-msg'>$message</div>"; } ?>

    <form action="" method="POST">
        <input type="text" name="username" placeholder="Enter Username" required>
        <input type="password" name="password" placeholder="Enter Password" required>
        <button type="submit" name="login">Login</button>
    </form>

</div>

<div class="footer">
    © <?php echo date("Y"); ?> Anu Hospitality Staff LTD. All Rights Reserved.
</div>

</body>
</html>
