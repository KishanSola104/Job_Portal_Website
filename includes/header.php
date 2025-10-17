<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($page_title)) {
    $page_title = "Anu Hospitality Staff Ltd";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($page_title); ?></title>

    <!-- Meta for SEO -->
    <meta name="description" content="Anu Hospitality Staff Ltd provides professional staffing solutions for the UK hospitality industry.">
    <link rel="icon" type="image/png" href="assets/logos/favicon.png">

    <!-- Styles -->
    <link rel="stylesheet" href="assets/css/header.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

<header>

    <!-- Top Contact Bar -->
    <div class="sub-header">
        <div class="contact-info">
            <a href="mailto:info@anuhospitality.com"><i class="fa-solid fa-envelope"></i> info@anuhospitality.com</a>
            <a href="tel:+441234567890"><i class="fa-solid fa-phone"></i> +44 1234 567 890</a>
        </div>
    </div>

    <!-- Desktop / Tablet Header -->
    <div class="main-header desktop-header">
        <div class="header-container">
            <div class="logo">
    <a href="#">
        <img src="assets/logos/Final Logo.png" alt="ANU Hospitality Staff Ltd Logo" class="site-logo">
    </a>
</div>


            <nav class="main-nav">
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="about.php">About Us</a></li>
                    <li><a href="services.php">Services</a></li>
                    <li><a href="job_roles.php">Job Roles</a></li>
                    <li><a href="contact.php">Contact</a></li>
                </ul>
            </nav>

            <div class="nav-buttons">
                <a href="candidate_apply.php" class="btn btn-primary">Apply Now</a>
                <a href="company_join.php" class="btn btn-secondary">Join Us</a>
            </div>
        </div>
    </div>

   <!-- Mobile Header -->
<div class="main-header mobile-header">
  <div class="header-container">
   <div class="mobile-logo">
    <a href="#"><img src="assets/logos/Final Logo.png" alt="ANU Hospitality Staff Ltd Logo" class="site-logo"></a>
</div>


    <div class="menu-toggle">
      <i class="fa-solid fa-bars"></i>
    </div>
  </div>

  <nav class="mobile-nav">
    <!-- Close Button -->
    <div class="mobile-nav-top">
      <div class="mobile-logo">
        <a href="#"><span class="logo-text">ANU HOSPITALITY STAFF LTD</span></a>
      </div>
      <div class="close-menu">
        <i class="fa-solid fa-xmark"></i>
      </div>
    </div>

    <ul>
      <li><a href="index.php">Home</a></li>
      <li><a href="about.php">About Us</a></li>
      <li><a href="services.php">Services</a></li>
      <li><a href="job_roles.php">Job Roles</a></li>
      <li><a href="contact.php">Contact</a></li>
    </ul>

    <div class="nav-buttons-mobile">
      <a href="candidate_apply.php" class="btn btn-primary">Apply Now</a>
      <a href="company_join.php" class="btn btn-secondary">Join Us</a>
    </div>
  </nav>
</div>


</header>



<script>
const mobileToggle = document.querySelector('.mobile-header .menu-toggle');
const mobileMenu = document.querySelector('.mobile-nav');
const closeMenu = document.querySelector('.mobile-nav .close-menu i');

// Open menu
mobileToggle.addEventListener('click', e=>{
    e.stopPropagation();
    mobileMenu.classList.add('active');
});

// Close menu using X
closeMenu.addEventListener('click', ()=>{
    mobileMenu.classList.remove('active');
});

// Close menu on outside click
document.addEventListener('click', e=>{
    if(mobileMenu.classList.contains('active') && !mobileMenu.contains(e.target) && !mobileToggle.contains(e.target)){
        mobileMenu.classList.remove('active');
    }
});

// Close menu when a link is clicked
mobileMenu.querySelectorAll('a').forEach(link=>{
    link.addEventListener('click', ()=>{
        mobileMenu.classList.remove('active');
    });
});

</script>