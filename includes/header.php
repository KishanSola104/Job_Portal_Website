<?php
// Start session if not started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Default page title
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
    <meta name="robots" content="index, follow">
    <link rel="icon" type="image/png" href="assets/logos/favicon.png">

    <!-- Fonts & Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- Stylesheets -->
    <link rel="stylesheet" href="assets/css/header.css">
    <link rel="stylesheet" href="assets/css/footer.css">
    <link rel="stylesheet" href="assets/css/style.css"> <!-- Global stylesheet -->
    <link rel="stylesheet" href="assets/css/policy.css"> <!-- Privacy Policy specific stylesheet -->
    <link rel="stylesheet" href="assets/css/candidate_application.css"> <!-- Application specific stylesheet -->
    <link rel="stylesheet" href="assets/css/partner_application.css"> <!-- Partner Application specific stylesheet -->
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
                <a href="index.php">
                    <img src="assets/logos/Final Logo.png" alt="ANU Hospitality Staff Ltd Logo" class="site-logo">
                </a>
            </div>

            <nav class="main-nav">
        <ul>
  <li><a href="/Job_Portal_Website/#hero">Home</a></li>
  <li><a href="/Job_Portal_Website/#about-us">About Us</a></li>
  <li><a href="/Job_Portal_Website/#services">Services</a></li>
  <li><a href="/Job_Portal_Website/#jobs">Job Roles</a></li>
  <li><a href="#contact-us">Contact Us</a></li>
</ul>

            </nav>

            <div class="nav-buttons">
                <a href="candidate_application" class="btn btn-primary">Apply Now</a>
                <a href="partner_application" class="btn btn-secondary">Join Us</a>
            </div>
        </div>
    </div>

    <!-- Mobile Header -->
    <div class="main-header mobile-header">
        <div class="header-container">
            <div class="mobile-logo">
                <a href="index.php"><img src="assets/logos/Final Logo.png" alt="ANU Hospitality Staff Ltd Logo" class="site-logo"></a>
            </div>
            <div class="menu-toggle"><i class="fa-solid fa-bars"></i></div>
        </div>

        <nav class="mobile-nav">
            <div class="mobile-nav-top">
                <div class="mobile-logo">
                    <a href="index.php"><span class="logo-text">ANU HOSPITALITY STAFF LTD</span></a>
                </div>
                <div class="close-menu"><i class="fa-solid fa-xmark"></i></div>
            </div>

           <ul>
  <li><a href="/Job_Portal_Website/#hero">Home</a></li>
  <li><a href="/Job_Portal_Website/#about-us">About Us</a></li>
  <li><a href="/Job_Portal_Website/#services">Services</a></li>
  <li><a href="/Job_Portal_Website/#jobs">Job Roles</a></li>
  <li><a href="#contact-us">Contact</a></li>
</ul>



            <div class="nav-buttons-mobile">
                <a href="candidate_application" class="btn btn-primary">Apply Now</a>
                <a href="partner_application" class="btn btn-secondary">Join Us</a>
            </div>
        </nav>
    </div>

</header>

<!-- Mobile Menu JS -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const mobileToggle = document.querySelector('.mobile-header .menu-toggle');
    const mobileMenu = document.querySelector('.mobile-nav');
    const closeMenu = document.querySelector('.mobile-nav .close-menu i');

    // Open menu
    mobileToggle.addEventListener('click', e => {
        e.stopPropagation();
        mobileMenu.classList.add('active');
    });

    // Close menu using X
    closeMenu.addEventListener('click', () => {
        mobileMenu.classList.remove('active');
    });

    // Close menu on outside click
    document.addEventListener('click', e => {
        if(mobileMenu.classList.contains('active') && !mobileMenu.contains(e.target) && !mobileToggle.contains(e.target)){
            mobileMenu.classList.remove('active');
        }
    });

    // Close menu when a link is clicked
    mobileMenu.querySelectorAll('a').forEach(link => {
        link.addEventListener('click', () => {
            mobileMenu.classList.remove('active');
        });
    });
});
</script>


<script>
document.addEventListener('DOMContentLoaded', () => {
    const header = document.querySelector('header');
    const main = document.querySelector('main');

    function adjustMainPadding() {
        main.style.paddingTop = header.offsetHeight + 'px';
    }

    function handleShrink() {
        if(window.scrollY > 50) { 
            header.classList.add('shrink');
        } else {
            header.classList.remove('shrink');
        }
        adjustMainPadding(); 
    }

    // Initial
    adjustMainPadding();
    handleShrink();

    // Events
    window.addEventListener('scroll', handleShrink);
    window.addEventListener('resize', adjustMainPadding);
});
</script>

