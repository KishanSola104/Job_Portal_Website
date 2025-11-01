<?php
session_start();
if(!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}

include("../includes/db_connect.php");

// Add Vacancy
if(isset($_POST['add_vacancy'])) {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $location = mysqli_real_escape_string($conn, $_POST['location']);
    $job_type = $_POST['job_type'];
    $salary = mysqli_real_escape_string($conn, $_POST['salary']);

    mysqli_query($conn, "INSERT INTO vacancies(title, description, location, job_type, salary) 
                         VALUES('$title','$description','$location','$job_type','$salary')");
    header("Location: manage_vacancies.php?success=added");
}

// Delete Vacancy
if(isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    mysqli_query($conn, "DELETE FROM vacancies WHERE id = $id");
    header("Location: manage_vacancies.php?success=deleted");
}

// Toggle Status
if(isset($_GET['toggle'])) {
    $id = intval($_GET['toggle']);
    mysqli_query($conn, "UPDATE vacancies SET status = IF(status='Open','Closed','Open') WHERE id = $id");
    header("Location: manage_vacancies.php?success=updated");
}

$vacancies = mysqli_query($conn, "SELECT * FROM vacancies ORDER BY posted_on DESC");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Manage Vacancies - Admin Panel</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
.add-btn,table{font-size:15px}.add-btn,.btn{text-decoration:none;font-weight:600}.add-btn,.btn,.form-group label,.header-area h2,.status-closed,.status-open,th{font-weight:600}body{margin:0;background:#f4f7fb;font-family:Inter,Arial,sans-serif}.container{max-width:1150px;margin:60px auto;padding:0 25px}.header-area{display:flex;justify-content:space-between;align-items:center;margin-bottom:28px}.header-area h2{margin:0;color:#1a1a1a;font-size:28px;letter-spacing:-.3px}.add-btn{background:#0a66c2;padding:10px 22px;color:#fff;border-radius:6px;transition:.25s}.add-btn:hover{background:#004a99}.vacancy-table-container{background:#fff;padding:20px;border-radius:10px;border:1px solid #e6e9ef;overflow-x:auto}table{width:100%;border-collapse:collapse;min-width:900px}td,th{padding:14px 15px;text-align:left;white-space:nowrap}th{background:#eef2f7;color:#1a1a1a;border-bottom:1px solid #d8dee7}tr:nth-child(2n){background:#fafbfd}.status-open{color:#0a7b26}.status-closed{color:#d42828}.btn{padding:6px 12px;border-radius:6px;font-size:13px}.btn-toggle,.save-btn{background:#0a66c2;color:#fff}.btn-edit{background:#e6a200;color:#fff}.btn-delete{background:#d94141;color:#fff}.modal{display:none;position:fixed;inset:0;background:rgba(0,0,0,.35);justify-content:center;align-items:center;z-index:9999}.modal-box{background:#fff;width:540px;border-radius:12px;padding:25px 30px;border:1px solid #d9dce1;animation:.25s ease-in-out fadeIn}@keyframes fadeIn{from{opacity:0;transform:translateY(-10px)}to{opacity:1;transform:translateY(0)}}.modal-box h3{margin-bottom:20px;font-size:21px;text-align:center;color:#1a1a1a}.form-group input,.form-group select,.form-group textarea{max-width:95%;width:100%;padding:10px 12px;border:1px solid #cdd4dd;border-radius:6px;font-size:14px;background:#fff}.form-grid{display:grid;grid-template-columns:repeat(2,1fr);gap:18px}.form-group label{font-size:14px;margin-bottom:6px;display:block}textarea{resize:none;height:85px}.modal-actions{display:flex;justify-content:center;gap:14px;margin-top:18px}.cancel-btn,.save-btn{padding:10px 24px;border-radius:6px;font-size:15px;font-weight:600;border:none;cursor:pointer}.cancel-btn{background:#eef2f7;color:#333}@media (max-width:600px){.modal-box{width:90%;padding:20px}.form-grid{grid-template-columns:1fr}table{min-width:100%;font-size:14px}.add-btn{padding:9px 18px}}
</style>
</head>

<body>
<?php include("../includes/admin_header.php"); ?>

<div class="container">

    <div class="header-area">
        <h2>Manage Vacancies</h2>
        <a href="#" class="add-btn" onclick="openModal()">+ Add Vacancy</a>
    </div>

    <div class="vacancy-table-container">
        <table>
            <tr>
                <th>Job Title</th>
                <th>Location</th>
                <th>Job Type</th>
                <th>Salary</th>
                <th>Status</th>
                <th>Posted</th>
                <th>Actions</th>
            </tr>

            <?php while($row = mysqli_fetch_assoc($vacancies)) { ?>
            <tr>
                <td><?= $row['title']; ?></td>
                <td><?= $row['location']; ?></td>
                <td><?= $row['job_type']; ?></td>
                <td><?= $row['salary'] ?: 'Not Disclosed'; ?></td>
                <td class="<?= $row['status']=='Open'?'status-open':'status-closed' ?>">
                    <?= $row['status']; ?>
                </td>
                <td><?= date("d M Y", strtotime($row['posted_on'])); ?></td>
                <td>
                    <a class="btn btn-toggle" href="?toggle=<?= $row['id'] ?>">Toggle</a>
                    <a class="btn btn-edit" href="edit_vacancy.php?id=<?= $row['id'] ?>">Edit</a>
                    <a class="btn btn-delete" href="?delete=<?= $row['id'] ?>" onclick="return confirm('Delete vacancy?')">Delete</a>
                </td>
            </tr>
            <?php } ?>
        </table>
    </div>
</div>

<!-- Add Vacancy Modal -->
<div class="modal" id="addModal">
    <div class="modal-box">
        <h3>Add Vacancy</h3>
        <form method="POST">
            <div class="form-grid">
                <div class="form-group">
                    <label>Job Title</label>
                    <input type="text" name="title" required>
                </div>

                <div class="form-group">
                    <label>Location</label>
                    <input type="text" name="location" required>
                </div>

                <div class="form-group">
                    <label>Job Type</label>
                    <select name="job_type">
                        <option>Full Time</option>
                        <option>Part Time</option>
                        <option>Contract</option>
                        <option>Temporary</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Salary (Optional)</label>
                    <input type="text" name="salary">
                </div>
            </div>

            <div class="form-group" style="margin-top:12px;">
                <label>Description</label>
                <textarea name="description" required></textarea>
            </div>

            <div class="modal-actions">
                <button type="submit" name="add_vacancy" class="save-btn">Save</button>
                <button type="button" class="cancel-btn" onclick="closeModal()">Cancel</button>
            </div>
        </form>
    </div>
</div>

<script>
function openModal(){ document.getElementById('addModal').style.display='flex'; }
function closeModal(){ document.getElementById('addModal').style.display='none'; }
window.onclick=function(e){ if(e.target.id=='addModal') closeModal(); }
</script>


<?php include("../includes/admin_footer.php"); ?>

</body>
</html>
