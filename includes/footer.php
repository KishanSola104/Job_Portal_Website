<?php
// footer.php - ANU Hospitality
?>

<!-- CSS Link -->
  <link rel="stylesheet" href="assets/css/min_css/footer_min.css"> 

<footer>

    <!-- ==========================
         FOOTER SECTION 1: CONTACT FORM
    =========================== -->
   <!-- ==========================
     CONTACT US SECTION
=========================== -->
<div class="footer-one contact-us" id="contact-us">
    <div class="contact-us-container">
        <h3>Contact Us</h3>
        <p>Have questions? Reach out to us and we’ll get back to you shortly.</p>
        <form id="contactForm" class="contact-form">
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
                <button type="submit" class="btn btn-primary">Send Message</button>
            </div>
            <div id="form-message"></div> <!-- For JS messages -->
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
                    <li><a href="domestic">Domestic</a></li>
                    <li><a href="commercial">Commercial</a></li>
                    <li><a href="vacancies">Vacancies</a></li>
                    <li><a href="/Job_Portal_Website/#services">Services</a></li>
                    <li><a href="/Job_Portal_Website/#jobs">Job Roles</a></li>
                    <li><a href="#contact-us">Contact Us</a></li>
                </ul>
            </div>

            <!-- Privacy Links -->
            <div class="footer-column quick-links">
                <h4>Polocy Links</h4>
                <ul>
    <li><a href="privacy_policy">Privacy Policy</a></li>
    <li><a href="terms_conditions">Terms & Conditions</a></li>
    <li><a href="equal_policy">Equal Opportunities Policy</a></li>
    <li><a href="modern_slavery">Modern Slavery Statement</a></li>
    <li><a href="#">Cancellation Policy</a></li>
    <li><a href="#">Refund Policy</a></li>
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


<script src="assets/js/min_js/script_min.js" defer></script>




<!-- WhatsApp Floating Button -->
<a href="https://wa.me/911234567890" class="whatsapp-float" target="_blank" title="Chat with us on WhatsApp">
    <i class="fa-brands fa-whatsapp"></i>
</a>



<!-- Contact Us Form validations  -->
<!-- Contact Us Form validations -->
<script>
document.getElementById("contactForm").addEventListener("submit", function(e) {
    e.preventDefault();

    const name = document.getElementById("name").value.trim();
    const email = document.getElementById("email").value.trim();
    const mobile = document.getElementById("mobile").value.trim();
    const message = document.getElementById("message").value.trim();
    const submitBtn = this.querySelector("button[type='submit']");

    const emailPattern = /^[^ ]+@[^ ]+\.[a-z]{2,3}$/;
    // Allow optional + at start, digits, spaces, total digits 10–15
    const mobilePattern = /^\+?\s*(?:\d\s*){10,15}$/;


    // Client-side validation
    if (name.length < 2) return showMessage("Please enter a valid name.", "error");
    if (!email.match(emailPattern)) return showMessage("Please enter a valid email address.", "error");
    if (!mobile.match(mobilePattern)) return showMessage("Please enter a valid mobile number (10–15 digits).", "error");
    if (message.length < 5) return showMessage("Message should be at least 5 characters long.", "error");

    submitBtn.disabled = true;
    submitBtn.textContent = "Sending...";

    const formData = new FormData();
    formData.append("name", name);
    formData.append("email", email);
    formData.append("mobile", mobile);
    formData.append("message", message);

    fetch("contact_submit.php", { method: "POST", body: formData })
        .then(res => res.json())
        .then(data => {
            // Show message based on status
            if (data.status === "success") {
                showMessage(data.message, "success");
                document.getElementById("contactForm").reset();
            } else if (data.status === "warning") {
                showMessage(data.message, "warning");
            } else {
                showMessage(data.message, "error");
            }
        })
        .catch(err => showMessage("Network error. Please try again later.", "error"))
        .finally(() => {
            submitBtn.disabled = false;
            submitBtn.textContent = "Send Message";
        });
});

function showMessage(text, type) {
    const msgDiv = document.getElementById("form-message");
    msgDiv.textContent = text;
    msgDiv.style.padding = "10px";
    msgDiv.style.borderRadius = "5px";
    msgDiv.style.fontWeight = "500";
    msgDiv.style.marginTop = "10px";
    msgDiv.style.transition = "opacity 0.5s ease-in-out";
    msgDiv.style.opacity = 1;

    if (type === "success") {
        msgDiv.style.backgroundColor = "#d4edda";
        msgDiv.style.color = "#155724";
        msgDiv.style.border = "1px solid #c3e6cb";
    } else if (type === "warning") {
        msgDiv.style.backgroundColor = "#fff3cd";
        msgDiv.style.color = "#856404";
        msgDiv.style.border = "1px solid #ffeeba";
    } else { // error
        msgDiv.style.backgroundColor = "#f8d7da";
        msgDiv.style.color = "#721c24";
        msgDiv.style.border = "1px solid #f5c6cb";
    }

    setTimeout(() => { msgDiv.style.opacity = 0; }, 7000);
}
</script>






</body>
</html>
