<?php
// Start the session
session_start();

// Page title
$page_title = "ANU Hospitality Staff Ltd - Vacancies";

// Include header & DB
include('includes/header.php');
include('includes/db_connect.php');

// Fetch only OPEN vacancies
$vacancies = mysqli_query($conn, "SELECT * FROM vacancies WHERE status='Open' ORDER BY posted_on DESC");
?>

<main style="background:#fff; padding:70px 0; font-family:Inter, sans-serif;">

<div class="vacancy-container">
    
    <div class="vacancy-heading">
        <h2>Current Job Openings</h2>
        <p>We are always looking for skilled, compassionate and dedicated staff members.</p>
    </div>

    <div class="vacancy-grid">
        <?php while($row = mysqli_fetch_assoc($vacancies)) { ?>
        <div class="vacancy-card">

            <div class="job-head">
                <h3><?= $row['title']; ?></h3>
            </div>

            <div class="job-details">
                <p><strong>Location:</strong> <?= $row['location']; ?></p>
                <p><strong>Job Type:</strong> <?= $row['job_type']; ?></p>
                <p><strong>Salary:</strong> <?= $row['salary'] ?: "Not Disclosed"; ?></p>
            </div>

            <p class="job-desc"><strong>Details:</strong><br><?= substr($row['description'], 0, 140); ?>...</p>

            <a href="vacancy_application?id=<?= $row['id']; ?>" class="apply-btn">Apply Now</a>

        </div>
        <?php } ?>
    </div>


    <!-- ================= EXTRA APPLY SECTION ================ -->
    <div class="extra-apply-box">
        <h3>Didn't Find a Suitable Job?</h3>
        <p>
            Even if there isn't a vacancy that matches your profile right now,<br>
            you can still submit your application. We will review it and contact you<br>
            when a suitable opportunity becomes available.
        </p>

        <a href="candidate_application" class="apply-btn btn-primary">Apply Now</a>
    </div>
    <!-- ====================================================== -->

</div>

</main>

<?php include('includes/footer.php'); ?>


<!-- STYLES -->
<style>
.vacancy-container{max-width:1150px;margin:auto;padding:0 22px}.vacancy-heading{text-align:center;margin-bottom:45px}.vacancy-heading h2{font-size:34px;font-weight:700;color:#111;margin-bottom:8px}.vacancy-heading p{color:#626d7d;font-size:15px}.vacancy-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(320px,1fr));gap:28px}.vacancy-card{background:#f8f9fa;border:1px solid #dce8ff;border-radius:14px;padding:24px;transition:.25s;display:flex;flex-direction:column;justify-content:space-between}.apply-btn,.center-btn{display:inline-block}.vacancy-card:hover{transform:translateY(-4px);box-shadow:0 6px 24px rgba(0,0,0,.08)}.job-head h3{margin:0;color:#111;font-size:20px;font-weight:700}.job-details{margin:14px 0;font-size:15px;color:#334155;line-height:1.7}.job-details p{margin:0}.job-desc{font-size:14px;color:#565e6a;line-height:1.6;margin:18px 0;flex-grow:1}.apply-btn{background:#0a66c2;color:#fff;padding:11px 20px;border-radius:8px;font-weight:600;text-align:center;text-decoration:none;transition:.25s}.apply-btn:hover{background:#004a99}.extra-apply-box{text-align:center;margin-top:60px;padding:35px;background:#f8f9fa;border-radius:14px;border:1px solid #dce8ff}.extra-apply-box h3{font-size:24px;font-weight:600;margin-bottom:12px}.extra-apply-box p{color:#56606b;line-height:1.7;margin-bottom:25px}
</style>
