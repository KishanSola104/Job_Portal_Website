<?php
session_start();
$page_title = "Choose Service Type - ANU Hospitality Staff Ltd";
include("includes/header.php");
?>

<!-- CSS Link -->
  <link rel="stylesheet" href="assets/css/min_css/choose_type.min.css">



<main>
    <div class="choose-wrapper">

        <h1>Select Your Service Category</h1>
        <p>Please choose the type of service based on your requirement.</p>

        <div class="choose-grid">

            <!-- Domestic Services -->
            <a href="domestic" class="choose-card">
                <i class="fa-solid fa-house-chimney"></i>
                <h2>Domestic Services</h2>
                <p>For homes, apartments, private villas, and personal assistance needs.</p>
            </a>

            <!-- Commercial Services -->
            <a href="commercial" class="choose-card">
                <i class="fa-solid fa-building"></i>
                <h2>Commercial Services</h2>
                <p>For corporate offices, hotels, restaurants, events, and business operations.</p>
            </a>

        </div>

    </div>
</main>

<?php include("includes/footer.php"); ?>
