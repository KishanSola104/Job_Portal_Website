<?php
if(!isset($_SESSION)) { session_start(); }

// Security check
if(!isset($_SESSION['admin_logged_in'])) {
    header("Location: ../admin/login");
    exit();
}

$current_page = basename($_SERVER['PHP_SELF'], ".php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Admin Panel | Anu Hospitality Staff LTD</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
  header,nav{background:#fff}.topbar,nav a{font-size:15px}nav,nav a{display:flex}body{margin:0;background:#f8fbff;font-family:Arial,sans-serif}header{width:100%;box-shadow:0 1px 6px rgba(0,0,0,.12);position:sticky;top:0;z-index:1000}.topbar{background:#004080;padding:14px 18px;color:#fff;text-align:center;letter-spacing:.5px;position:relative}.hamburger{position:absolute;right:15px;top:11px;cursor:pointer;font-size:22px;color:#fff;display:none;z-index:2000;transition:.3s}nav{padding:12px 15px;justify-content:center;align-items:center;gap:28px;border-bottom:1px solid #e3e3e3;flex-wrap:wrap}nav a{color:#004080;text-decoration:none;font-weight:600;align-items:center;gap:6px;padding:6px 9px;border-radius:5px;transition:.3s}nav a:hover{background:#e8f1ff;color:#0078ff}nav a.active{background:#0078ff;color:#fff!important;box-shadow:0 2px 6px rgba(0,0,0,.18)}@media(max-width:700px){nav{display:none;flex-direction:column;padding:18px 0;gap:18px}nav.show{display:flex}.hamburger{display:block}}
</style>
</head>
<body>

<header>
    <div class="topbar">
        Welcome, <?php echo $_SESSION['admin_username']; ?> | Anu Hospitality Staff LTD

        <div class="hamburger" id="menuToggle" onclick="toggleMenu()">
            <i class="fa-solid fa-bars menu-icon"></i>
        </div>
    </div>

    <nav id="adminMenu">
        <a href="dashboard" class="<?= ($current_page=='dashboard')?'active':'' ?>" onclick="closeMenu()">
            <i class="fa-solid fa-chart-line"></i> Dashboard
        </a>

        <a href="candidate_applications" class="<?= ($current_page=='candidate_applications')?'active':'' ?>" onclick="closeMenu()">
            <i class="fa-solid fa-user-tie"></i> Candidates
        </a>

        <a href="partner_applications" class="<?= ($current_page=='partner_applications')?'active':'' ?>" onclick="closeMenu()">
            <i class="fa-solid fa-handshake"></i> Partners
        </a>

        <a href="contact_queries" class="<?= ($current_page=='contact_queries')?'active':'' ?>" onclick="closeMenu()">
            <i class="fa-solid fa-envelope"></i> Contacts
        </a>

         <a href="manage_vacancies" class="<?= ($current_page=='manage_vacancies')?'active':'' ?>" onclick="closeMenu()">
        <i class="fa-solid fa-briefcase"></i> Vacancies
    </a>

        <a href="logout" onclick="closeMenu()">
            <i class="fa-solid fa-power-off"></i> Logout
        </a>
    </nav>
</header>

<script>
const menu = document.getElementById("adminMenu");
const toggle = document.getElementById("menuToggle");
const icon = document.querySelector(".menu-icon");

function toggleMenu(){
    menu.classList.toggle("show");
    if(menu.classList.contains("show")){
        icon.classList.replace("fa-bars", "fa-times");
    } else {
        icon.classList.replace("fa-times", "fa-bars");
    }
}

function closeMenu(){
    menu.classList.remove("show");
    icon.classList.replace("fa-times", "fa-bars");
}

document.addEventListener("click", function(e){
    if (!menu.contains(e.target) && !toggle.contains(e.target)){
        closeMenu();
    }
});
</script>
