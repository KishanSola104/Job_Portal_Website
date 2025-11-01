<?php
session_start();
if(!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}

include("../includes/db_connect.php");

// Sanitize Search
$search = isset($_GET['search']) ? trim($_GET['search']) : "";

// Pagination
$limit = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page - 1) * $limit;

// Prepared query (safe)
$sql = "SELECT id, name, email, phone, job_role 
        FROM candidate_applications 
        WHERE name LIKE ? OR email LIKE ? OR phone LIKE ? OR job_role LIKE ?
        ORDER BY created_at DESC
        LIMIT ?, ?";
$stmt = $conn->prepare($sql);

$like = "%$search%";
$stmt->bind_param("ssssii", $like, $like, $like, $like, $start, $limit);
$stmt->execute();
$result = $stmt->get_result();

// Count Total for Pagination
$count_sql = "SELECT COUNT(*) AS total FROM candidate_applications 
              WHERE name LIKE ? OR email LIKE ? OR phone LIKE ? OR job_role LIKE ?";
$count_stmt = $conn->prepare($count_sql);
$count_stmt->bind_param("ssss", $like, $like, $like, $like);
$count_stmt->execute();
$totalRecords = $count_stmt->get_result()->fetch_assoc()['total'];
$totalPages = ceil($totalRecords / $limit);
?>

<!DOCTYPE html>
<html>
<head>
<title>Candidate Applications - Admin</title>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
.pagination,h2{text-align:center}body{font-family:Arial,sans-serif;background:#f8fbff;margin:0}.container{width:95%;margin:auto;padding:20px}h2{color:#004080;margin-bottom:15px}.search-box{width:100%;padding:10px;border-radius:6px;border:1px solid #aaa;margin-bottom:18px;font-size:15px}.table{width:100%;border-collapse:collapse;background:#fff;border-radius:8px;overflow:hidden;box-shadow:0 3px 10px rgba(0,0,0,.08)}.table th{background:#004080;color:#fff;padding:12px;text-align:left}.table td{padding:12px;border-bottom:1px solid #e5e5e5}.actions button{border:none;padding:7px 12px;border-radius:5px;cursor:pointer;font-size:13px;color:#fff;margin-right:5px}.view-btn{background:#0078ff}.view-btn:hover{background:#005fcc}.delete-btn{background:#f44}.delete-btn:hover{background:#c00}.pagination{margin-top:14px}.pagination a{padding:8px 14px;margin:2px;background:#f1f1f1;border-radius:5px;text-decoration:none;color:#004080}.pagination a.active{background:#0078ff;color:#fff}@media(max-width:700px){.table td:nth-child(3),.table td:nth-child(4),.table td:nth-child(5),.table th:nth-child(3),.table th:nth-child(4),.table th:nth-child(5){display:none}.table td,.table th{font-size:14px;padding:8px}.actions button{padding:5px 8px;font-size:11px}}
</style>

<script>
function viewCandidate(id){
    document.getElementById("modal-bg").style.display="flex";
    document.getElementById("modal-content").innerHTML="Loading...";
    fetch("view_candidate.php?id=" + id)
        .then(res => res.text())
        .then(data => document.getElementById("modal-content").innerHTML = data);
}

function closeModal(){
    document.getElementById("modal-bg").style.display="none";
}

function deleteCandidate(id){
    if(confirm("Are you sure you want to DELETE this application? This cannot be undone.")){
        window.location.href="delete_candidate.php?id=" + id;
    }
}
</script>

</head>
<body>

<?php include("../includes/admin_header.php"); ?>

<div class="container">

<h2><i class="fa-solid fa-user-tie"></i> Candidate Applications</h2>

<form method="GET">
    <input type="text" name="search" class="search-box" placeholder="Search by Name, Email, Phone or Role..." value="<?php echo htmlspecialchars($search); ?>">
</form>

<table class="table">
<tr>
    <th>#</th>
    <th>Name</th>
    <th>Email</th>
    <th>Phone</th>
    <th>Role</th>
    <th>Actions</th>
</tr>

<?php 
$sr = $start + 1;
while($row = $result->fetch_assoc()):
?>
<tr>
    <td><?php echo $sr++; ?></td>
    <td><?php echo htmlspecialchars($row['name']); ?></td>
    <td><?php echo htmlspecialchars($row['email']); ?></td>
    <td><?php echo htmlspecialchars($row['phone']); ?></td>
    <td><?php echo htmlspecialchars($row['job_role']); ?></td>
    <td class="actions">
        <button class="view-btn" onclick="viewCandidate(<?php echo $row['id']; ?>)">View</button>
        <button class="delete-btn" onclick="deleteCandidate(<?php echo $row['id']; ?>)">Delete</button>
    </td>
</tr>
<?php endwhile; ?>
</table>

<div class="pagination">
<?php if($page > 1): ?>
    <a href="?page=<?php echo $page-1; ?>&search=<?php echo $search; ?>">Previous</a>
<?php endif; ?>

<?php for($i = 1; $i <= $totalPages; $i++): ?>
    <a class="<?php echo ($i==$page)?'active':''; ?>" href="?page=<?php echo $i; ?>&search=<?php echo $search; ?>"><?php echo $i; ?></a>
<?php endfor; ?>

<?php if($page < $totalPages): ?>
    <a href="?page=<?php echo $page+1; ?>&search=<?php echo $search; ?>">Next</a>
<?php endif; ?>
</div>

</div>

<!-- Modal -->
<div id="modal-bg" style="display:none; justify-content:center; align-items:center; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.6);">
    <div id="modal-content" style="background:white; padding:20px; width:90%; max-width:500px; border-radius:10px; max-height:90vh; overflow-y:auto;"></div>
</div>

<?php include("../includes/admin_footer.php"); ?>

</body>
</html>
