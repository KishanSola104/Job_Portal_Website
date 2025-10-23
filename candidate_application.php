<?php
// Start the session
session_start();
$page_title = "ANU Hospitality Staff Ltd - Candidate Application";
include('includes/application_header.php');
?>

<main>
  <section class="candidate-form-section">
    <div class="candidate-container">
      <h2 class="candidate-title">Candidate Application Form</h2>

     <form id="candidate-application-form" enctype="multipart/form-data" action="candidate_submit.php" method="POST">


        <!-- PERSONAL DETAILS -->
        <div class="candidate-section">
          <h3>Personal Details</h3>
          <div class="candidate-grid">

            <div class="candidate-field">
              <label for="candidate-name">Full Name *</label>
              <input type="text" id="candidate-name" name="name" placeholder="John Doe" required>
            </div>

            <div class="candidate-field">
              <label for="candidate-email">Email *</label>
              <input type="email" id="candidate-email" name="email" placeholder="example@email.com" required>
            </div>

            <div class="candidate-field">
              <label for="candidate-phone">Phone *</label>
              <input type="text" id="candidate-phone" name="phone" placeholder="+911234567890" required>
            </div>

            <div class="candidate-field candidate-dob">
              <label>Date of Birth *</label>
              <select id="candidate-year" name="dob_year" required>
                <option value="">Year</option>
              </select>
              <select id="candidate-month" name="dob_month" required>
                <option value="">Month</option>
              </select>
              <select id="candidate-day" name="dob_day" required>
                <option value="">Day</option>
              </select>
            </div>

            <div class="candidate-field" style="grid-column: 1 / -1;">
              <label for="candidate-address">Address *</label>
              <textarea id="candidate-address" name="address" placeholder="Your Address" required></textarea>
            </div>

          </div>
        </div>

        <!-- PROFESSIONAL DETAILS -->
        <div class="candidate-section">
          <h3>Professional Details</h3>
          <div class="candidate-grid">

            <div class="candidate-field">
              <label for="candidate-job">Job Role Applying For *</label>
             <select id="candidate-job" name="job_role" required>
  <option value="">Select a Job Role</option>

  <optgroup label="Housekeeping & Maintenance">
    <option value="Housekeeping">Housekeeping Staff</option>
    <option value="HousekeepingSupervisor">Housekeeping Supervisor</option>
    <option value="Laundry">Laundry Staff</option>
    <option value="Maintenance">Maintenance / Facility Staff</option>
  </optgroup>

  <optgroup label="Front Office">
    <option value="FrontDesk">Front of House & Reception Staff</option>
    <option value="Receptionist">Receptionist / Front Office Assistant</option>
    <option value="Concierge">Concierge</option>
  </optgroup>

  <optgroup label="Food & Beverage">
    <option value="Kitchen">Kitchen Porters & Chefs</option>
    <option value="ChefSpecialist">Specialist Chefs (Pastry, Indian, Continental)</option>
    <option value="RestaurantService">Restaurant / Wait Staff</option>
    <option value="BarStaff">Bar Staff / Bartender</option>
    <option value="RoomService">Room Service Attendant</option>
  </optgroup>

  <optgroup label="Events & Security">
    <option value="Event">Event & Banquet Staff</option>
    <option value="EventCoordinator">Event Coordinator</option>
    <option value="Security">Security Staff</option>
  </optgroup>

  <optgroup label="Management & Administration">
    <option value="HotelManagement">Hotel Management Trainee</option>
    <option value="AdminStaff">Administrative Staff</option>
    <option value="HR">Human Resources Assistant</option>
    <option value="Marketing">Marketing & Sales Assistant</option>
    </optgroup>

    <optgroup label="Other Roles">
      <option value="Other">Other</option>
    </optgroup>
  
</select>

            </div>

            <div class="candidate-field">
              <label for="candidate-experience">Years of Experience *</label>
              <input type="number" id="candidate-experience" name="experience" min="0" max="50" placeholder="0" required>
            </div>

            <div class="candidate-field" style="grid-column: 1 / -1;">
              <label for="candidate-resume">Upload Resume (PDF/DOC, max 5MB) *</label>
              <input type="file" id="candidate-resume" name="resume" accept=".pdf,.doc,.docx" required>
            </div>

          </div>
        </div>

        <!-- TERMS & BUTTONS -->
       <div class="candidate-section">
  <div class="candidate-field candidate-terms-container">
    <input type="checkbox" id="candidate-terms" required>
    <label for="candidate-terms" class="candidate-terms-label">
      I agree to the 
      <a href="terms_conditions" target="_blank">Terms & Conditions</a> and 
      <a href="privacy_policy" target="_blank">Privacy Policy</a>
    </label>
  </div>

  <div class="candidate-buttons">
    <button type="reset" id="candidate-reset">Cancel</button>
    <button type="submit" id="candidate-submit">Submit</button>
  </div>
</div>


      </form>
    </div>
  </section>
</main>



<?php include('includes/application_footer.php'); ?>
