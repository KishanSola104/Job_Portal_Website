<?php
session_start();
if(!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}

include("../includes/db_connect.php");

// Fetch Counts
$candidate_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM candidate_applications"))['total'];
$partner_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM partner_applications"))['total'];
$message_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM contact_messages"))['total'];
$vacancy_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM vacancies"))['total'];

?>
<!DOCTYPE html>
<html>
<head>
<title>Admin Dashboard - ANU Hospitality Staff Ltd</title>

<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>
    body {
        margin: 0;
        font-family: 'Inter', Arial, sans-serif;
        background: #f4f7fc;
    }

    .dashboard-container {
        max-width: 1200px;
        margin: 40px auto;
        padding: 0 30px;
    }

    .section-title {
        font-size: 28px;
        font-weight: 700;
        color: #002b5c;
        text-align: center;
        margin-bottom: 40px;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(230px, 1fr));
        gap: 24px;
        margin-bottom: 60px;
    }

    .stat-card {
        background: white;
        border-radius: 12px;
        padding: 28px;
        text-align: center;
        box-shadow: 0 4px 14px rgba(0,0,0,0.08);
        transition: .3s;
    }
    .stat-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.12);
    }
    .stat-card i {
        font-size: 38px;
        color: #006bff;
        margin-bottom: 12px;
    }
    .stat-card h3 {
        font-size: 17px;
        margin-bottom: 6px;
        color: #002b5c;
        font-weight: 600;
    }
    .stat-card p {
        font-size: 34px;
        font-weight: 700;
        color: #006bff;
    }

    .charts-wrapper {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(380px, 1fr));
        gap: 40px;
        margin-bottom: 60px;
    }

    .chart-box {
        background: #fff;
        border-radius: 12px;
        padding: 25px;
        box-shadow: 0 4px 14px rgba(0,0,0,0.08);
    }

    .chart-title {
        font-size: 18px;
        color: #002b5c;
        margin-bottom: 18px;
        text-align: center;
        font-weight: 600;
    }
</style>

</head>
<body>

<?php include("../includes/admin_header.php"); ?>

<div class="dashboard-container">

    <h2 class="section-title">Admin Dashboard</h2>

    <div class="stats-grid">
        <div class="stat-card">
            <i class="fa-solid fa-user-tie"></i>
            <h3>Total Candidate Applications</h3>
            <p><?php echo $candidate_count; ?></p>
        </div>

        <div class="stat-card">
            <i class="fa-solid fa-handshake"></i>
            <h3>Total Partner Applications</h3>
            <p><?php echo $partner_count; ?></p>
        </div>

        <div class="stat-card">
            <i class="fa-solid fa-envelope"></i>
            <h3>Total Contact Queries</h3>
            <p><?php echo $message_count; ?></p>
        </div>

        <div class="stat-card">
            <i class="fa-solid fa-briefcase"></i>
            <h3>Total Vacancies Posted</h3>
            <p><?php echo $vacancy_count; ?></p>
        </div>

        <div class="stat-card">
            <i class="fa-solid fa-user-shield"></i>
            <h3>Logged in as</h3>
            <p><?php echo $_SESSION['admin_username']; ?></p>
        </div>
    </div>

    <!-- CHARTS -->
    <div class="charts-wrapper">

        <div class="chart-box">
            <h3 class="chart-title">Applications Overview</h3>
            <canvas id="barChart"></canvas>
        </div>

        <div class="chart-box">
            <h3 class="chart-title">Application Distribution</h3>
            <canvas id="pieChart"></canvas>
        </div>

    </div>

</div>

<script>
const chartColors = {
    blue: "#0A66C2",
    blueLight: "#78B9FF",
    grayLight: "#E7EDF5",
    grayText: "#4A5B6C"
};

// BAR CHART (Corporate Style)
new Chart(document.getElementById("barChart"), {
    type: "bar",
    data: {
        labels: ["Candidates", "Partners", "Messages", "Vacancies"],
        datasets: [{
            label: "Total Count",
            data: [<?php echo $candidate_count; ?>, <?php echo $partner_count; ?>, <?php echo $message_count; ?>, <?php echo $vacancy_count; ?>],
            backgroundColor: chartColors.blue,
            borderRadius: 8,
            barThickness: 45
        }]
    },
    options: {
        plugins: {
            legend: { display: false },
        },
        scales: {
            y: {
                beginAtZero: true,
                grid: { color: chartColors.grayLight },
                ticks: { color: chartColors.grayText }
            },
            x: {
                ticks: { color: chartColors.grayText }
            }
        }
    }
});

// PIE CHART (Corporate Style)
new Chart(document.getElementById("pieChart"), {
    type: "doughnut",
    data: {
        labels: ["Candidates", "Partners", "Messages", "Vacancies"],
        datasets: [{
            data: [<?php echo $candidate_count; ?>, <?php echo $partner_count; ?>, <?php echo $message_count; ?>, <?php echo $vacancy_count; ?>],
            backgroundColor: [
                chartColors.blue,
                chartColors.blueLight,
                chartColors.grayText,
                "#003A75"
            ],
            borderWidth: 0
        }]
    },
    options: {
        cutout: "55%", // Makes it look modern like LinkedIn dashboard
        plugins: {
            legend: {
                position: "bottom",
                labels: {
                    color: chartColors.grayText,
                    padding: 14,
                    font: { size: 14 }
                }
            }
        }
    }
});
</script>

<?php include("../includes/admin_footer.php"); ?>

</body>
</html>
