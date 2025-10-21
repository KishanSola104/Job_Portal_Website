<?php
// Start the session
session_start();

// Page title
$page_title = "ANU Hospitality Staff Ltd - Home";

// Include header
include('includes/header.php');
?>




<main>

    <!-- Hero Section -->
    <section class="hero-section" id="hero">
        <div class="hero-slider">
            <div class="hero-slide active">
                <img src="assets/images/MBG1.jpg" alt="Slide 1">
                <div class="hero-text">
                    <div class="hero-lines">
                        <span class="line line1">Experience world-class hospitality and unmatched service standards</span> <br>
                        <span class="line line2">With ANU Hospitality Staff LTD, we redefine comfort and excellence</span>
                    </div>
                </div>
            </div>
            <div class="hero-slide">
                <img src="assets/images/MBG2.jpg" alt="Slide 2">
                <div class="hero-text">
                    <div class="hero-lines">
                        <span class="line line1">Discover innovative solutions and dedicated staff for your every need</span> <br>
                        <span class="line line2">ANU Hospitality Staff LTD ensures every experience is memorable</span>
                    </div>
                </div>
            </div>
            <div class="hero-slide">
                <img src="assets/images/MBG3.jpg" alt="Slide 3">
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
<section class="about-section" id="about-us">
    <div class="about-container">
        <div class="left-part-about">
            <h2>About ANU Hospitality Staff LTD</h2>
            <p>
                At <strong>ANU Hospitality Staff LTD</strong>, we specialize in providing exceptional hospitality services across the UK and internationally. 
                Our dedicated team ensures that every client experience is seamless, professional, and memorable.
            </p>
            <p>
                From staff management to catering and premium customer solutions, we provide services tailored to your unique needs. 
                With years of experience, our commitment to quality and excellence sets us apart in the hospitality industry.
            </p>
        </div>
        <div class="right-part-about">
            <img src="assets/images/about.png" alt="About Us Image">
        </div>
    </div>
</section>

<!-- ==========================
     HOW WE WORK SECTION
========================== -->
<section class="how-we-work">
  <h2 class="section-title">How We Work</h2>

  <div class="work-container">
    <!-- Left Side -->
    <div class="work-part left">
      <p class="animate">
        WE PRIDE OURSELVES ON DELIVERING BESPOKE RECRUITMENT SOLUTIONS TO OUR CLIENTS, 
        RECOGNISING THAT EACH LUXURY HOTEL AND PROPERTY HAS DISTINCT REQUIREMENTS. 
        WHETHER IT'S EXECUTIVE MANAGEMENT, CULINARY ARTS, GUEST SERVICES, OR SPECIALISED ROLES, 
        ANU HOSPITALITY STAFF LTD IS ADEPT AT SOURCING TALENT THAT NOT ONLY MEETS BUT EXCEEDS EXPECTATIONS.
      </p>
      <p class="animate delay">
        WITH A GLOBAL NETWORK AND LOCAL EXPERTISE, ANU HOSPITALITY STAFF LTD BRIDGES THE GAP 
        BETWEEN INTERNATIONAL EXCELLENCE AND REGIONAL NUANCES. 
        WE LEVERAGE OUR EXTENSIVE CONNECTIONS TO ATTRACT CANDIDATES WITH A WEALTH OF EXPERIENCE, 
        ENSURING THAT OUR CLIENTS AND CANDIDATES RECEIVE AND EXPERIENCE THE VERY BEST IN THE INDUSTRY.
      </p>
    </div>

    <!-- Vertical Divider -->
    <div class="divider"></div>

    <!-- Right Side -->
    <div class="work-part right">
      <p class="animate">
        OUR COMMITMENT TO QUALITY IS UNWAVERING. WE METICULOUSLY VET CANDIDATES, ASSESSING 
        NOT ONLY THEIR QUALIFICATIONS BUT ALSO THEIR UNDERSTANDING OF AND PASSION FOR 
        THE LUXURY HOSPITALITY EXPERIENCE. THIS DEDICATION ENSURES THAT OUR PLACEMENTS CONTRIBUTE 
        NOT ONLY TO THE SUCCESS OF THE HOTELS, PRIVATE FAMILY OFFICES AND HOUSEHOLDS WE SERVE 
        BUT ALSO TO THE ENRICHMENT OF THE GUEST EXPERIENCE.
      </p>
      <p class="animate delay">
        STAYING AHEAD IN THE EVER-EVOLVING LANDSCAPE OF LUXURY HOSPITALITY IS PARAMOUNT. 
        ANU HOSPITALITY STAFF LTD STAYS ABREAST OF INDUSTRY TRENDS AND INNOVATIONS, 
        ALLOWING US TO ADVISE OUR CLIENTS ON THE LATEST TALENT STRATEGIES AND 
        ENSURING THAT THE CANDIDATES WE RECOMMEND ARE AT THE FOREFRONT OF INDUSTRY BEST PRACTICES.
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
      <div class="service-card">
        <img src="assets/images/staff.jpg" alt="Staff & Workforce Solutions">
        <div class="service-overlay">
          <p>We provide End-to-end recruitment service for hospitality employers looking for temporary or permanent staffing.</p>
        </div>
        <h3>Temporary & Permanent Recruitment</h3>
      </div>

      <div class="service-card">
        <img src="assets/images/catreen.jpg" alt="Catering & Food Services">
        <div class="service-overlay">
          <p>Experienced catering teams ensuring quality food preparation, serving, and customer satisfaction.</p>
        </div>
        <h3>Catering & Food Service Staff</h3>
      </div>

      <div class="service-card">
        <img src="assets/images/security.jpg" alt="Training & Consultancy">
        <div class="service-overlay">
          <p>Provide trained security officers, stewards, and event marshals for safe and organized operations.</p>
        </div>
        <h3>Security & Stewarding Services</h3>
      </div>

      <div class="service-card hide-tab hide-mob">
        <img src="assets/images/logistic.jpg" alt="Event & Banquet Management Staff">
        <div class="service-overlay">
          <p>Reliable manpower for packing, organizing, and delivery support — ideal for hotels, catering, or event</p>
        </div>
        <h3>Warehouse & Logistics Support</h3>
      </div>
    </div>

    <!-- 🔹 SECOND ROW -->
    <div class="services-row second-services-row">
      <div class="service-card">
        <img src="assets/images/rec.jpg" alt="Facility & Event Management">
        <div class="service-overlay">
          <p>Receptionists, concierges, and guest service assistants who ensure a warm welcome and smooth customer.</p>
        </div>
        <h3>Front of House & Reception Staff</h3>
      </div>

      <div class="service-card">
        <img src="assets/images/chef.jpg" alt="Premium Services">
        <div class="service-overlay">
          <p>Supply kitchen porters, commis chefs, and head chefs for restaurants, hotels, and catering events.</p>
        </div>
        <h3>Kitchen Porters & Chefs</h3>
      </div>

      <div class="service-card hide-tab hide-mob">
        <img src="assets/images/clean.jpg" alt="Hospitality Consulting">
        <div class="service-overlay">
          <p>Professional room attendants, cleaners, and supervisors for hotels, offices, and residential buildings.</p>
        </div>
        <h3>Housekeeping & Cleaning Services</h3>
      </div>

      <div class="service-card hide-tab hide-mob">
        <img src="assets/images/hotelstaff.jpg" alt="Temporary Staffing">
        <div class="service-overlay">
          <p>Provide experienced staff for hotels, restaurants, and catering companies — including waiters, housekeeping, and kitchen assistants.</p>
        </div>
        <h3>Hotel & Restaurant Staffing</h3>
      </div>
    </div>

    <!-- 🔹 EXTRA ROW (View More) -->
    <div class="extra-services-row">
      <div class="service-card extra-card">
        <img src="assets/images/Event.jpg" alt="Event & Banquet Management Staff">
        <div class="service-overlay">
          <p>Our experienced banquet and event staff deliver seamless coordination and hospitality excellence.</p>
        </div>
        <h3>Event & Banquet Management Staff</h3>
      </div>

      <div class="service-card extra-card">
        <img src="assets/images/main.jpg" alt="Hospitality Consulting">
        <div class="service-overlay">
          <p>Provide handymen, electricians, and plumbers for hotels, offices, and property management.</p>
        </div>
        <h3>Maintenance & Facility Support</h3>
      </div>

      <div class="service-card extra-card">
        <img src="assets/images/bar.jpg" alt="Temporary Staffing">
        <div class="service-overlay">
          <p>Provide experienced bartenders, baristas, and beverage servers for hotels, restaurants, bars, and events.</p>
        </div>
        <h3>Bar & Beverage Staff</h3>
      </div>
    </div>

    <!-- 🔹 BUTTONS -->
    <div class="services-buttons">
      <button class="btn view-more" style="background-color:#0056b3; color:#fff;">View More</button>
      <a href="partner_application" class="btn join-us">Join Us</a>
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
        <img src="assets/images/housekeeping.jpg" alt="Housekeeping">
        <h4>Housekeeping</h4>
        <p>Housekeeping Manager, Office Coordinator, Floor Supervisor, Room Attendant, Porter, Night Cleaner, Public Area Cleaner</p>
      </div>

      <div class="job-card">
        <img src="assets/images/gyms.jpg" alt="Housekeeping Staff">
        <h4>LEISURE & GYMS</h4>
        <p>CLEANER, SPA ATTENDANT, SPA THERAPIST, RECEPTIONIST</p>
      </div>

      <div class="job-card">
        <img src="assets/images/cong.jpg" alt="Chef">
        <h4>Concierge</h4>
        <p>Assist guests with various requests and provide information about the hotel and local area.</p>
      </div>

      <div class="job-card hide-tab hide-mob">
        <img src="assets/images/resi.jpg" alt="Waiter/Waitress">
        <h4>RESIDENTIAL</h4>
        <p>ESTATE OPERATIVE, CONCIERGE, CLEANER, END-OF-TENANCY CLEANER, PORTER, RECEPTIONIST, SECURITY PERSONNEL</p>
      </div>
    </div>

    <!-- 🔹 ROW 2 -->
    <div class="jobs-row second-job-row">
      <div class="job-card">
        <img src="assets/images/admin.jpg" alt="Receptionist">
        <h4>Administrative</h4>
        <p>HR Executive, Payroll Assistant, Personal Assistant, Accounts Payable Clerk</p>
      </div>

      <div class="job-card">
        <img src="assets/images/security1.jpg" alt="Security Staff">
        <h4>Security Staff</h4>
        <p>Manned Guarding Solutions, Concierge & Welcome Services, Event And Hospitality Security, Security Solutions And Consultancy</p>
      </div>

      <div class="job-card">
        <img src="assets/images/food.jpg" alt="Housekeeping Supervisor">
        <h4>Food & Beverage</h4>
        <p>Chef (all levels), Waiter, Wine Waiter, Events Waiter, Banqueting Staff, Host, Cloakroom Attendant</p>
      </div>

      <div class="job-card hide-tab hide-mob">
        <img src="assets/images/eventPlan.jpg" alt="Event Coordinator">
        <h4>Event Coordinator</h4>
        <p>Plan and organize hotel events smoothly.</p>
      </div>
    </div>

    <!-- 🔹 EXTRA ROW (View More) -->
    <div class="extra-row">
      <div class="job-card extra-card">
        <img src="assets/images/logi.jpg" alt="Waiter/Waitress">
        <h4>LOGISTICS & WAREHOUSE</h4>
        <p>WAREHOUSE OPERATIVE, DRIVER</p>
      </div>

      <div class="job-card extra-card">
        <img src="assets/images/front.jpg" alt="Event Coordinator">
        <h4>Front of House & Back of House</h4>
        <p>Receptionist, Concierge, Doorman, Maintenance & Engineering, Painter</p>
      </div>
    </div>

 

    <!-- 🔹 BUTTONS -->
    <div class="job-buttons">
      <button class="btn view-more">View More</button>
      <a href="candidate_application" class="btn apply-now">Apply Now</a>
    </div>
  </div>
</section>






</main>





<?php 
// Include footer
include('includes/footer.php');
?>

