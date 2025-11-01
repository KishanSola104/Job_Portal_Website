<?php
session_start();
if(!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}

include("../includes/db_connect.php");

$id = intval($_GET['id']);
$vacancy = mysqli_query($conn, "SELECT * FROM vacancies WHERE id = $id");
$data = mysqli_fetch_assoc($vacancy);

if(!$data){
    header("Location: manage_vacancies.php?error=notfound");
    exit();
}

// Update Vacancy
if(isset($_POST['update_vacancy'])) {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $location = mysqli_real_escape_string($conn, $_POST['location']);
    $job_type = $_POST['job_type'];
    $salary = mysqli_real_escape_string($conn, $_POST['salary']);
    $status = $_POST['status'];

    mysqli_query($conn, "UPDATE vacancies SET 
        title='$title', 
        description='$description', 
        location='$location', 
        job_type='$job_type', 
        salary='$salary', 
        status='$status'
        WHERE id = $id");

    header("Location: manage_vacancies.php?success=updated");
    exit();
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Vacancy - Admin Panel</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
body{margin:0;background:#f4f7fb;font-family:Inter,Arial,sans-serif}.container{max-width:900px;margin:60px auto;padding:0 25px}.page-title{font-size:26px;color:#1a1a1a;font-weight:600;margin-bottom:30px}.form-box{background:#fff;padding:30px;border-radius:10px;border:1px solid #e2e6ec}.cancel-btn,.save-btn{padding:10px 28px;cursor:pointer}.form-group input,.form-group select,.form-group textarea{max-width:95%;width:100%;padding:10px 12px;border:1px solid #cfd6e2;border-radius:6px;font-size:14px;background:#fff}.form-grid{display:grid;grid-template-columns:repeat(2,1fr);gap:18px}.form-group label{font-size:14px;font-weight:600;color:#333;margin-bottom:6px;display:block}textarea{resize:none;height:110px}.actions{margin-top:25px;text-align:center}.save-btn{background:#0a66c2;color:#fff;border:none;border-radius:6px;font-weight:600;transition:.25s}.save-btn:hover{background:#004a99}.cancel-btn{background:#e9eef5;color:#2f3a45;border:none;border-radius:6px;margin-left:8px}@media(max-width:680px){.form-grid{grid-template-columns:1fr}}
</style>
</head>

<body>
<?php include("../includes/admin_header.php"); ?>

<div class="container">
    <h2 class="page-title">Edit Vacancy</h2>

    <form method="POST" class="form-box">

        <div class="form-grid">
            <div class="form-group">
                <label>Job Title</label>
                <input type="text" name="title" value="<?= $data['title']; ?>" required>
            </div>

            <div class="form-group">
                <label>Location</label>
                <input type="text" name="location" value="<?= $data['location']; ?>" required>
            </div>

            <div class="form-group">
                <label>Job Type</label>
                <select name="job_type">
                    <option <?= $data['job_type']=='Full Time'?'selected':'' ?>>Full Time</option>
                    <option <?= $data['job_type']=='Part Time'?'selected':'' ?>>Part Time</option>
                    <option <?= $data['job_type']=='Contract'?'selected':'' ?>>Contract</option>
                    <option <?= $data['job_type']=='Temporary'?'selected':'' ?>>Temporary</option>
                </select>
            </div>

            <div class="form-group">
                <label>Salary (Optional)</label>
                <input type="text" name="salary" value="<?= $data['salary']; ?>">
            </div>

            <div class="form-group">
                <label>Status</label>
                <select name="status">
                    <option <?= $data['status']=='Open'?'selected':'' ?>>Open</option>
                    <option <?= $data['status']=='Closed'?'selected':'' ?>>Closed</option>
                </select>
            </div>
        </div>

        <div class="form-group" style="margin-top:12px;">
            <label>Description</label>
            <textarea name="description" required><?= $data['description']; ?></textarea>
        </div>

        <div class="actions">
            <button type="submit" name="update_vacancy" class="save-btn">Save Changes</button>
            <a href="manage_vacancies.php"><button type="button" class="cancel-btn">Cancel</button></a>
        </div>

    </form>
</div>

<?php include("../includes/admin_footer.php"); ?>

</body>
</html>
