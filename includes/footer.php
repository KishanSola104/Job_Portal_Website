<?php
// footer.php - ANU Hospitality
?>

<footer>

    <!-- ==========================
         FOOTER SECTION 1: CONTACT FORM
    =========================== -->
    <div class="footer-one contact-us" id="contact-us">
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
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>

    <!-- ==========================
         FOOTER SECTION 2: LINKS & INFO
    =========================== -->
    <div class="footer-two">
        <hr class="footer-separator">
        <div class="footer-two-container">

            <!-- Logo & Address -->
            <div class="footer-column address">
                <img src="assets/logos/Final Logo.png" alt="ANU Hospitality Logo" class="footer-logo">
                <p>
                    123 Main Street, City, Country<br>
                    UK & India Offices<br>
                    Email: <a href="mailto:info@anuhospitality.com">info@anuhospitality.com</a><br>
                    Phone: <a href="tel:+441234567890">+44 1234 567 890</a>
                </p>
            </div>

            <!-- Quick Links -->
            <div class="footer-column quick-links">
                <h4>Quick Links</h4>
                <ul>
                    <li><a href="/Job_Portal_Website/#hero">Home</a></li>
                    <li><a href="/Job_Portal_Website/#about-us">About Us</a></li>
                    <li><a href="/Job_Portal_Website/#services">Services</a></li>
                    <li><a href="/Job_Portal_Website/#jobs">Job Roles</a></li>
                    <li><a href="#contact-us">Contact Us</a></li>
                </ul>
            </div>

            <!-- Privacy Links -->
            <div class="footer-column quick-links">
                <h4>Privacy Links</h4>
                <ul>
    <li><a href="privacy_policy">Privacy Policy</a></li>
    <li><a href="terms_conditions">Terms & Conditions</a></li>
    <li><a href="equal_policy">Equal Opportunities Policy</a></li>
    <li><a href="modern_slavery">Modern Slavery Statement</a></li>
    <li><a href="ethical_trading">Ethical Trading Policy</a></li>
</ul>

            </div>

            <!-- Social Links -->
            <div class="footer-column social-links">
                <h4>Connect with Us</h4>
                <div class="social-icons">
                    <a href="#" target="_blank" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" target="_blank" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                    <a href="#" target="_blank" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
                    <a href="#" target="_blank" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>

        </div>
    </div>

    <!-- HR Separators -->
    <hr class="footer-hr-90">
    <hr class="footer-hr-70">

    <!-- ==========================
         FOOTER SECTION 3: COPYRIGHT
    =========================== -->
    <div class="footer-three">
        <p>© <?php echo date("Y"); ?> ANU Hospitality Staff Ltd. All Rights Reserved.</p>
        <p>Designed and Developed by 
            <a href="https://www.linkedin.com/company/shreeji-it-solution-pvt-ltd/?viewAsMember=true" target="_blank">Shreeji IT Solutions PVT. LTD.</a>
        </p>
    </div>

</footer>


<script src="assets/js/script.js" defer></script>
<script src="assets/js/policy.js" defer></script>



<!-- WhatsApp Floating Button -->
<a href="https://wa.me/911234567890" class="whatsapp-float" target="_blank" title="Chat with us on WhatsApp">
    <i class="fa-brands fa-whatsapp"></i>
</a>



</body>
</html>
