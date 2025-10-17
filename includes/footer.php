<?php
// footer.php - ANU Hospitality
?>

<footer>

    <!-- Footer Section 1: Contact Us Form -->
    <div class="footer-one contact-us">
        <div class="contact-us-container">
            <h3>Contact Us</h3>
            <p>Have questions? Reach out to us and we’ll get back to you shortly.</p>
            <form action="contact_submit.php" method="POST" class="contact-form">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" name="name" id="name" placeholder="Your Name" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" placeholder="Your Email" required>
                </div>
                <div class="form-group">
                    <label for="mobile">Mobile Number</label>
                    <input type="text" name="mobile" id="mobile" placeholder="Your Mobile Number" required>
                </div>
                <div class="form-group">
                    <label for="message">Message</label>
                    <textarea name="message" id="message" rows="5" placeholder="Your Message" required></textarea>
                </div>
                <div class="form-group submit-btn">
                    <button type="submit" class="btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Footer Section 2 -->
    <div class="footer-two">
        <hr class="footer-separator">
        <div class="footer-two-container">

            <!-- Logo & Address -->
            <div class="footer-column address">
                <img src="assets/logos/Final Logo.png" alt="ANU Hospitality Logo" class="footer-logo">
                <p>
                    123 Main Street, City, Country<br>
                    UK & India Offices<br>
                    Email: info@anuhospitality.com<br>
                    Phone: +44 1234 567 890
                </p>
            </div>

            <!-- Quick Links -->
            <div class="footer-column quick-links">
                <h4>Quick Links</h4>
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="about.php">About Us</a></li>
                    <li><a href="services.php">Services</a></li>
                    <li><a href="job_roles.php">Job Roles</a></li>
                    <li><a href="job_roles.php">Contact Us</a></li>
                </ul>
            </div>

             <!-- PRIVACY Links -->
            <div class="footer-column quick-links">
                <h4>Privacy Links</h4>
                <ul>
                    <li><a href="privacy.php">Privacy Policy</a></li>
                    <li><a href="terms.php">Terms & Conditions</a></li>
                </ul>
            </div>


            <!-- Social Links -->
            <div class="footer-column social-links">
                <h4>Connect with Us</h4>
                <div class="social-icons">
                    <a href="#" target="_blank"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" target="_blank"><i class="fab fa-instagram"></i></a>
                    <a href="#" target="_blank"><i class="fab fa-twitter"></i></a>
                    <a href="#" target="_blank"><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>

        </div>
    </div>

    <!-- HR Separators between Section 2 and 3 -->
     <hr class="footer-hr-90">
    <hr class="footer-hr-70">
    

    <!-- Footer Section 3 -->
    <div class="footer-three">
        <p>© <?php echo date("Y"); ?> ANU Hospitality Staff Ltd. All Rights Reserved.</p>
        <p>Designed and Developed by 
            <a href="https://shreejiitsolutions.com" target="_blank">Shreeji IT Solutions PVT. LTD.</a>
        </p>
    </div>

</footer>




<!-- Footer Stylesheet -->
<link rel="stylesheet" href="assets/css/footer.css">

</body>
</html>
