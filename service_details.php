<?php
session_start();
include("includes/db_connect.php");

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: services.php");
    exit();
}

$service_id = intval($_GET['id']);
$query = mysqli_query($conn, "SELECT * FROM services WHERE id = $service_id LIMIT 1");

if (mysqli_num_rows($query) == 0) {
    header("Location: services.php");
    exit();
}

$service = mysqli_fetch_assoc($query);

$page_title = "ANU Hospitality Staff Ltd - " . $service['service_title'];
include("includes/header.php");
?>

<!-- CSS Link -->
  <link rel="stylesheet" href="assets/css/min_css/service_details.min.css">


<main>
<div class="service-details-wrapper">

    <div class="service-flex-box">

        <!-- IMAGE -->
        <div class="service-image-wrapper">
            <img src="assets/images/<?php echo $service['service_image']; ?>" alt="<?php echo $service['service_title']; ?>">
        </div>

        <!-- TEXT -->
        <div class="service-text-content">
            <h1><?php echo $service['service_title']; ?></h1>

            <p class="service-short-desc"><?php echo $service['service_short_desc']; ?></p>

            <!-- LONG DESCRIPTION WITH READ MORE -->
            <div class="service-long-desc fade" id="serviceDesc">
                <?php echo nl2br($service['service_long_desc']); ?>
            </div>

            <button class="read-more-btn" id="readMoreBtn">Read More</button>

            <div class="service-btn-box">
                <a href="#" class="btn btn-primary">
                    Book a Service
                </a>
                <a href="partner_application" class="btn btn-secondary">
                    Join Us
                </a>
            </div>
        </div>

    </div>

</div>
</main>

<script>
const descBox = document.getElementById("serviceDesc");
const readBtn = document.getElementById("readMoreBtn");

readBtn.addEventListener("click", () => {
    descBox.classList.toggle("expanded");
    descBox.classList.toggle("fade");
    readBtn.textContent = descBox.classList.contains("expanded") ? "Read Less" : "Read More";
});
</script>

<?php include("includes/footer.php"); ?>
