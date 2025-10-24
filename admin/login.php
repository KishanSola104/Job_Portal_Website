<?php
session_start();
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
  header("Location: admin_dashboard.php");
  exit;
}
$error = isset($_GET['error']) ? htmlspecialchars($_GET['error']) : '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Login | ANU Hospitality Staff Ltd</title>
  <style>
    /* === RESET === */
    * { margin: 0; padding: 0; box-sizing: border-box; font-family: "Poppins", sans-serif; }

    body {
      background: linear-gradient(135deg, #007bff, #00c6ff);
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    .login-container {
      background: #fff;
      padding: 40px 35px;
      border-radius: 16px;
      box-shadow: 0 10px 30px rgba(0,0,0,0.15);
      width: 370px;
      animation: fadeIn 0.7s ease-in-out;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(-10px); }
      to { opacity: 1; transform: translateY(0); }
    }

    .login-header {
      text-align: center;
      margin-bottom: 25px;
    }

    .login-header h2 {
      color: #333;
      font-size: 24px;
      font-weight: 600;
    }

    .login-header p {
      color: #666;
      font-size: 14px;
      margin-top: 5px;
    }

    form {
      display: flex;
      flex-direction: column;
    }

    .input-field {
      position: relative;
      margin-bottom: 18px;
    }

    .input-field input {
      width: 100%;
      padding: 12px 14px;
      border: 1.5px solid #ccc;
      border-radius: 8px;
      font-size: 14px;
      transition: 0.3s;
    }

    .input-field input:focus {
      border-color: #007bff;
      outline: none;
      box-shadow: 0 0 5px rgba(0,123,255,0.4);
    }

    button {
      padding: 12px;
      background: #007bff;
      border: none;
      color: #fff;
      border-radius: 8px;
      cursor: pointer;
      font-size: 15px;
      font-weight: 600;
      transition: background 0.3s;
    }

    button:hover {
      background: #0056b3;
    }

    .error-box {
      margin-top: 15px;
      padding: 10px 12px;
      border-left: 4px solid #ff4d4d;
      background: #ffe6e6;
      color: #cc0000;
      font-size: 14px;
      border-radius: 6px;
      animation: shake 0.3s ease-in-out;
    }

    @keyframes shake {
      0%, 100% { transform: translateX(0); }
      20%, 60% { transform: translateX(-5px); }
      40%, 80% { transform: translateX(5px); }
    }

    footer {
      text-align: center;
      margin-top: 18px;
      font-size: 13px;
      color: #777;
    }

    footer a {
      color: #007bff;
      text-decoration: none;
      font-weight: 500;
    }
    footer a:hover { text-decoration: underline; }
  </style>
</head>
<body>

  <div class="login-container">
    <div class="login-header">
      <h2>Admin Login</h2>
      <p>Welcome to ANU Hospitality Staff Ltd</p>
    </div>

    <form action="admin_login_check.php" method="POST">
      <div class="input-field">
        <input type="text" name="username" placeholder="Admin Username" required>
      </div>

      <div class="input-field">
        <input type="password" name="password" placeholder="Password" required>
      </div>

      <button type="submit">Sign In</button>

      <?php if ($error): ?>
        <div class="error-box"><?= $error ?></div>
      <?php endif; ?>
    </form>

    <footer>
      &copy; <?= date("Y") ?> ANU Hospitality Staff Ltd. All rights reserved.
    </footer>
  </div>

</body>
</html>
