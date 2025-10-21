<?php
// Start the session
session_start();

// Page title
$page_title = "ANU Hospitality Staff Ltd - Partner Application";

// Include header
include('includes/header.php');
?>

<main>
  <section class="partner-form-section">
    <div class="partner-container">
      <h2 class="partner-title">Partner Application Form</h2>

      <form id="partner-form" class="partner-form">

        <!-- Company Details -->
        <div class="partner-section">
          <h3>Company Details</h3>
          <div class="partner-grid">
            <div class="partner-field">
              <label for="partner-company-name">Company Name*</label>
              <input type="text" id="partner-company-name" name="company_name" required>
            </div>
            <div class="partner-field">
              <label for="partner-contact-person">Contact Person*</label>
              <input type="text" id="partner-contact-person" name="contact_person" required>
            </div>
            <div class="partner-field">
              <label for="partner-email">Email*</label>
              <input type="email" id="partner-email" name="email" required>
            </div>
            <div class="partner-field">
              <label for="partner-phone">Phone*</label>
              <input type="text" id="partner-phone" name="phone" required>
            </div>
            <div class="partner-field">
              <label for="partner-website">Website</label>
              <input type="url" id="partner-website" name="website">
            </div>
            <div class="partner-field">
              <label for="partner-address">Address*</label>
              <textarea id="partner-address" name="address" rows="3" required></textarea>
            </div>
          </div>
        </div>

        <!-- Business Info -->
        <div class="partner-section">
          <h3>Business Information</h3>
          <div class="partner-grid">
            <div class="partner-field">
              <label for="partner-service-type">Type of Service*</label>
              <input type="text" id="partner-service-type" name="service_type" required>
            </div>
            <div class="partner-field">
              <label for="partner-notes">Notes / Additional Info</label>
              <textarea id="partner-notes" name="notes" rows="3"></textarea>
            </div>
          </div>
        </div>

        <!-- Terms & Conditions -->
        <div class="partner-section">
          <div class="partner-field partner-terms-container">
            <input type="checkbox" id="partner-terms" required>
            <label for="partner-terms" class="partner-terms-label">
              I agree to the 
              <a href="terms_conditions" target="_blank">Terms & Conditions</a> and 
              <a href="privacy_policy" target="_blank">Privacy Policy</a>
            </label>
          </div>
        </div>

        <!-- Buttons -->
        <div class="partner-buttons">
          <button type="reset" id="partner-reset">Cancel</button>
          <button type="submit" id="partner-submit">Submit</button>
        </div>

      </form>
    </div>
  </section>
</main>


<?php 
// Include footer
include('includes/application_footer.php');
?>

