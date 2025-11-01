<?php
// Start the session
session_start();

// Page title
$page_title = "ANU Hospitality Staff Ltd - Home";

// Include header
include('includes/header.php');
?>

<!-- CSS Link -->
<link rel="stylesheet" href="assets/css/min_css/style_min.css"> 


<main>

    <!-- Hero Section -->
    <section class="hero-section" id="hero">
        <div class="hero-slider">
            <div class="hero-slide active">
                <img src="assets/images/Hero1.webp" alt="Slide 1" fetchpriority="high"   decoding="async" loading="eager">
                <div class="hero-text">
                    <div class="hero-lines">
                        <span class="line line1">Experience world-class hospitality and unmatched service standards</span> <br>
                        <span class="line line2">With ANU Hospitality Staff LTD, we redefine comfort and excellence</span>
                    </div>
                </div>
            </div>
            <div class="hero-slide">
                <img src="assets/images/Hero2.webp" alt="Slide 2"  loading="lazy">
                <div class="hero-text">
                    <div class="hero-lines">
                        <span class="line line1">Discover innovative solutions and dedicated staff for your every need</span> <br>
                        <span class="line line2">ANU Hospitality Staff LTD ensures every experience is memorable</span>
                    </div>
                </div>
            </div>
            <div class="hero-slide">
                <img src="assets/images/Hero3.webp" alt="Slide 3" loading="lazy">
                <div class="hero-text">
                    <div class="hero-lines">
                        <span class="line line1">Join thousands of satisfied clients who trust us for perfection</span> <br>
                        <span class="line line2">Let ANU Hospitality Staff LTD transform your hospitality experience</span>
                    </div>
                </div>
            </div>
        </div>

       

        <!-- Slider indicators -->
        <div class="hero-indicators">
            <span class="indicator active"></span>
            <span class="indicator"></span>
            <span class="indicator"></span>
        </div>
    </section>


    
 <!-- About Us Section -->
<!-- About Us Section -->
<section class="about-section" id="about-us">
    <div class="about-container">
        <div class="left-part-about">
            <h2>About ANU Hospitality Staff Ltd</h2>
            <p>
                At <strong>ANU Hospitality Staff Ltd</strong>, we provide reliable, professional and fully trained 
                staff for both <strong>Domestic</strong> and <strong>Commercial</strong> environments across the UK. 
                We understand that every home and business has different needs, which is why our services are designed 
                to be flexible, transparent and tailored to you.
            </p>

            <p>
                Whether you are looking for domestic cleaners, commercial facility staff, housekeeping teams, 
                hotel workforce, reception staff or event support — our trained professionals ensure quality, 
                hygiene and service excellence at every step.
            </p>

            <p>
                With a strong commitment to trust, professionalism and reliability, ANU Hospitality Staff Ltd 
                has become a preferred partner for homeowners, businesses and hospitality groups seeking 
                **consistent results and peace of mind**.
            </p>

           
        </div>

        <div class="right-part-about">
            <img src="assets/images/about.webp" alt="About Us Image" loading="lazy">
        </div>
    </div>
</section> 


 <!-- Why Choose Us -->
<section class="why-choose-us" id="why-choose-us">
  <div class="wcu-container slide-from-right">

    <h2 class="wcu-title">Why Choose Us</h2>
    <p class="wcu-subtext">
      At ANU Hospitality Staff Ltd, we focus on delivering quality, trust, and convenience.
      Whether it's for your home or business, we ensure professional and reliable staffing solutions.
    </p>

    <div class="wcu-boxes">

      <div class="wcu-box">
        <i class="fas fa-user-shield wcu-icon"></i>
        <h3>Verified & Skilled Professionals</h3>
        <p>Our staff are fully vetted, trained, and experienced.</p>
      </div>

      <div class="wcu-box">
        <i class="fas fa-bolt wcu-icon"></i>
        <h3>Quick Response & Service</h3>
        <p>Fast communication and quick service delivery.</p>
      </div>

      <div class="wcu-box">
        <i class="fas fa-tags wcu-icon"></i>
        <h3>Affordable Pricing</h3>
        <p>Simple, fair pricing with complete transparency.</p>
      </div>

      <div class="wcu-box">
        <i class="fas fa-headset wcu-icon"></i>
        <h3>24/7 Support</h3>
        <p>We are available anytime to assist you.</p>
      </div>

    </div>

    <a href="partner_application" class="btn btn-secondary">Join Us</a>

  </div>
</section>





<!-- ==========================
     HOW WE WORK SECTION
========================== -->
<section class="how-we-work">
  <h2 class="section-title">How We Work</h2>

  <div class="work-container">

    <div class="work-part left animate">
      <p>
        At ANU Hospitality Staff Ltd, we believe that reliable staffing should be simple,
        transparent, and stress-free. Whether you need staff for your home or your business,
        we follow a structured and professional approach to ensure quality every time.
      </p>

      <p>
        We start by understanding your exact requirements — the type of work, number of staff,
        timings, location, and any special preferences. Based on this, we match you with
        skilled and verified professionals who are best suited for the task.
      </p>
    </div>

    <div class="divider"></div>

    <div class="work-part right animate delay">
      <p>
        All our staff members go through strict background checks, identity verification,
        and skill assessment to ensure safety, reliability, and professionalism.
      </p>

      <p>
        Once placed, we remain in continuous touch to provide support, ensure service quality,
        and make replacements quickly if needed. Our goal is to deliver trusted, flexible,
        and affordable staffing solutions — every time.
      </p>
    </div>

  </div>
</section>



<!-- ================================
     SERVICES SECTION
================================ -->
<section class="services-section" id="services">
  <div class="container">
    <h2 class="section-title">Our Services</h2>

    <!-- 🔹 FIRST ROW -->
    <div class="services-row first-services-row">
      <a href="service_details?id=1" class="service-card">
  <img src="assets/images/staff.webp" alt="Temporary & Permanent Recruitment">
  <div class="service-overlay">
    <i class="fa-solid fa-arrow-up-right-from-square overlay-link-icon"></i>
    <p>We provide End-to-end recruitment service for hospitality employers looking for temporary or permanent staffing.</p>
  </div>
  <h3>Temporary & Permanent Recruitment</h3>
</a>


      <a href="service_details.php?id=2" class="service-card">
  <img src="assets/images/catreen.webp" alt="Catering & Food Service Staff" loading="lazy">
  <div class="service-overlay">
    <i class="fa-solid fa-arrow-up-right-from-square overlay-link-icon"></i>
    <p>Experienced catering teams ensuring quality food preparation, serving, and customer satisfaction.</p>
  </div>
  <h3>Catering & Food Service Staff</h3>
</a>

<a href="service_details.php?id=3" class="service-card">
  <img src="assets/images/security.webp" alt="Security & Stewarding Services" loading="lazy">
  <div class="service-overlay">
    <i class="fa-solid fa-arrow-up-right-from-square overlay-link-icon"></i>
    <p>Provide trained security officers, stewards, and event marshals for safe and organized operations.</p>
  </div>
  <h3>Security & Stewarding Services</h3>
</a>

<a href="service_details.php?id=4" class="service-card hide-tab hide-mob">
  <img src="assets/images/Logistic.webp" alt="Warehouse & Logistics Support" loading="lazy">
  <div class="service-overlay">
    <i class="fa-solid fa-arrow-up-right-from-square overlay-link-icon"></i>
    <p>Reliable manpower for packing, organizing, and delivery support — ideal for hotels, catering, or event.</p>
  </div>
  <h3>Warehouse & Logistics Support</h3>
</a>

    </div>

    <!-- 🔹 SECOND ROW -->
    <div class="services-row second-services-row">
    <a href="service_details.php?id=5" class="service-card">
  <img src="assets/images/rec.webp" alt="Front of House & Reception Staff" loading="lazy">
  <div class="service-overlay">
    <i class="fa-solid fa-arrow-up-right-from-square overlay-link-icon"></i>
    <p>Receptionists, concierges, and guest service assistants who ensure a warm welcome and smooth customer.</p>
  </div>
  <h3>Front of House & Reception Staff</h3>
</a>

<a href="service_details.php?id=6" class="service-card">
  <img src="assets/images/chef.webp" alt="Kitchen Porters & Chefs" loading="lazy">
  <div class="service-overlay">
    <i class="fa-solid fa-arrow-up-right-from-square overlay-link-icon"></i>
    <p>Supply kitchen porters, commis chefs, and head chefs for restaurants, hotels, and catering events.</p>
  </div>
  <h3>Kitchen Porters & Chefs</h3>
</a>

<a href="service_details.php?id=7" class="service-card hide-tab hide-mob">
  <img src="assets/images/clean.webp" alt="Housekeeping & Cleaning Services" loading="lazy">
  <div class="service-overlay">
    <i class="fa-solid fa-arrow-up-right-from-square overlay-link-icon"></i>
    <p>Professional room attendants, cleaners, and supervisors for hotels, offices, and residential buildings.</p>
  </div>
  <h3>Housekeeping & Cleaning Services</h3>
</a>

<a href="service_details.php?id=8" class="service-card hide-tab hide-mob">
  <img src="assets/images/hotelstaff.webp" alt="Hotel & Restaurant Staffing" loading="lazy">
  <div class="service-overlay">
    <i class="fa-solid fa-arrow-up-right-from-square overlay-link-icon"></i>
    <p>Provide experienced staff for hotels, restaurants, and catering companies — including waiters, housekeeping, and kitchen assistants.</p>
  </div>
  <h3>Hotel & Restaurant Staffing</h3>
</a>

    </div>

    <!-- 🔹 EXTRA ROW (View More) -->
    <div class="extra-services-row">
      <a href="service_details.php?id=9" class="service-card extra-card">
  <img src="assets/images/Event.webp" alt="Event & Banquet Management Staff" loading="lazy">
  <div class="service-overlay">
    <i class="fa-solid fa-arrow-up-right-from-square overlay-link-icon"></i>
    <p>Our experienced banquet and event staff deliver seamless coordination and hospitality excellence.</p>
  </div>
  <h3>Event & Banquet Management Staff</h3>
</a>

<a href="service_details.php?id=10" class="service-card extra-card">
  <img src="assets/images/main.webp" alt="Maintenance & Facility Support" loading="lazy">
  <div class="service-overlay">
    <i class="fa-solid fa-arrow-up-right-from-square overlay-link-icon"></i>
    <p>Provide handymen, electricians, and plumbers for hotels, offices, and property management.</p>
  </div>
  <h3>Maintenance & Facility Support</h3>
</a>

<a href="service_details.php?id=11" class="service-card extra-card">
  <img src="assets/images/bar.webp" alt="Bar & Beverage Staff" loading="lazy">
  <div class="service-overlay">
    <i class="fa-solid fa-arrow-up-right-from-square overlay-link-icon"></i>
    <p>Provide experienced bartenders, baristas, and beverage servers for hotels, restaurants, bars, and events.</p>
  </div>
  <h3>Bar & Beverage Staff</h3>
</a>

    </div>

    <!-- 🔹 BUTTONS -->
    <div class="services-buttons">
      <button class="btn view-more" style="background-color:#0056b3; color:#fff;">View More</button>
      <a href="choose_type" class="btn join-us btn-secondary">Book a Service</a>
    </div>
  </div>
</section>


<!-- ================================
     JOB ROLES SECTION
================================ -->
<section class="job-section" id="jobs">
  <div class="container">
   <center> <h2 class="section-title">Job Roles</h2> </center>

    <!-- 🔹 ROW 1 -->
    <div class="jobs-row first-job-row">
      <div class="job-card">
        <img src="assets/images/housekeeping.webp" alt="Housekeeping" loading="lazy">
        <h4>Housekeeping</h4>
        <p>Housekeeping Manager, Office Coordinator, Floor Supervisor, Room Attendant, Porter, Night Cleaner, Public Area Cleaner</p>
      </div>

      <div class="job-card">
        <img src="assets/images/gyms.webp" alt="Housekeeping Staff" loading="lazy">
        <h4>LEISURE & GYMS</h4>
        <p>CLEANER, SPA ATTENDANT, SPA THERAPIST, RECEPTIONIST</p>
      </div>

      <div class="job-card">
        <img src="assets/images/cong.webp" alt="Chef" loading="lazy">
        <h4>Concierge</h4>
        <p>Assist guests with various requests and provide information about the hotel and local area.</p>
      </div>

      <div class="job-card hide-tab hide-mob">
        <img src="assets/images/resi.webp" alt="Waiter/Waitress" loading="lazy">
        <h4>RESIDENTIAL</h4>
        <p>ESTATE OPERATIVE, CONCIERGE, CLEANER, END-OF-TENANCY CLEANER, PORTER, RECEPTIONIST, SECURITY PERSONNEL</p>
      </div>
    </div>

    <!-- 🔹 ROW 2 -->
    <div class="jobs-row second-job-row">
      <div class="job-card">
        <img src="assets/images/admin.webp" alt="Receptionist" loading="lazy">
        <h4>Administrative</h4>
        <p>HR Executive, Payroll Assistant, Personal Assistant, Accounts Payable Clerk</p>
      </div>

      <div class="job-card">
        <img src="assets/images/security1.webp" alt="Security Staff" loading="lazy">
        <h4>Security Staff</h4>
        <p>Manned Guarding Solutions, Concierge & Welcome Services, Event And Hospitality Security, Security Solutions And Consultancy</p>
      </div>

      <div class="job-card">
        <img src="assets/images/food.webp" alt="Housekeeping Supervisor" loading="lazy">
        <h4>Food & Beverage</h4>
        <p>Chef (all levels), Waiter, Wine Waiter, Events Waiter, Banqueting Staff, Host, Cloakroom Attendant</p>
      </div>

      <div class="job-card hide-tab hide-mob">
        <img src="assets/images/eventPlan.webp" alt="Event Coordinator" loading="lazy">
        <h4>Event Coordinator</h4>
        <p>Plan and organize hotel events smoothly.</p>
      </div>
    </div>

    <!-- 🔹 EXTRA ROW (View More) -->
    <div class="extra-row">
      <div class="job-card extra-card">
        <img src="assets/images/logi.webp" alt="Waiter/Waitress" loading="lazy">
        <h4>LOGISTICS & WAREHOUSE</h4>
        <p>WAREHOUSE OPERATIVE, DRIVER</p>
      </div>

      <div class="job-card extra-card">
        <img src="assets/images/front.webp" alt="Event Coordinator" loading="lazy">
        <h4>Front of House & Back of House</h4>
        <p>Receptionist, Concierge, Doorman, Maintenance & Engineering, Painter</p>
      </div>
    </div>

 

    <!-- 🔹 BUTTONS -->
    <div class="job-buttons">
      <button class="btn view-more">View More</button>
      <a href="candidate_application" class="btn apply-now btn-secondary">Apply Now</a>
    </div>
  </div>
</section>






</main>





<?php 
// Include footer
include('includes/footer.php');
?>

