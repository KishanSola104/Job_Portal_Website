<?php
session_start();
if(!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}

include("../includes/db_connect.php");

// Search Handling
$search = "";
if(isset($_GET['search'])){
    $search = trim($_GET['search']);
}

// Pagination Setup
$limit = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page - 1) * $limit;

$sql = "SELECT * FROM contact_messages 
        WHERE name LIKE '%$search%' OR email LIKE '%$search%' OR mobile LIKE '%$search%'
        ORDER BY id DESC
        LIMIT $start, $limit";
$result = $conn->query($sql);

// Count Total Records
$countQuery = "SELECT COUNT(*) AS total FROM contact_messages 
               WHERE name LIKE '%$search%' OR email LIKE '%$search%' OR mobile LIKE '%$search%'";
$totalRecords = $conn->query($countQuery)->fetch_assoc()['total'];
$totalPages = ceil($totalRecords / $limit);
?>

<!DOCTYPE html>
<html>
<head>
<title>Contact Queries - Admin</title>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
    body{ font-family: Arial, sans-serif; background:#f8fbff; margin:0; }

    .container { width:95%; margin:auto; padding:20px; }

    h2{ color:#004080; text-align:center; margin-bottom:15px; }

    .search-box{
        width:100%; padding:10px; margin-bottom:18px;
        border-radius:6px; border:1px solid #aaa; font-size:15px;
    }

    .table{
        width:100%; border-collapse:collapse; background:white;
        border-radius:8px; overflow:hidden;
        box-shadow:0 3px 10px rgba(0,0,0,0.08);
    }

    .table th{
        background:#004080; color:white; padding:12px; text-align:left; font-size:15px;
    }

    .table td{ padding:12px; border-bottom:1px solid #e5e5e5; font-size:15px; }

    .actions button{
        border:none; padding:7px 12px; border-radius:5px; cursor:pointer;
        font-size:13px; color:white; margin-right:5px;
    }
    .view-btn{ background:#0078ff; } .view-btn:hover{ background:#005fcc; }
    .delete-btn{ background:#ff4444; } .delete-btn:hover{ background:#cc0000; }

    .pagination{text-align:center;margin-top:14px;}
    .pagination a{
        padding:8px 14px; margin:2px; background:#f1f1f1;
        text-decoration:none; border-radius:5px; color:#004080;
    }
    .pagination a.active{ background:#0078ff; color:white; }

    /* ✅ Mobile View */
    @media(max-width:700px){
        .table th:nth-child(3),
        .table th:nth-child(4),
        .table td:nth-child(3),
        .table td:nth-child(4){
            display:none;
        }
        .actions button{ padding:5px 8px; font-size:11px; }
        .table td,.table th{ font-size:14px; padding:8px; }
    }
</style>

<script>
function viewContact(id){
    document.getElementById("modal-bg").style.display="flex";
    document.getElementById("modal-content").innerHTML="Loading...";
    fetch("view_contact.php?id="+id)
    .then(res=>res.text())
    .then(data=>document.getElementById("modal-content").innerHTML=data);
}

function closeModal(){
    document.getElementById("modal-bg").style.display="none";
}

function deleteContact(id){
    if(confirm("Are you sure to DELETE this message?")){
        window.location.href = "delete_contact.php?id="+id;
    }
}
</script>

</head>
<body>

<?php include("../includes/admin_header.php"); ?>

<div class="container">

<h2><i class="fa-solid fa-envelope-circle-check"></i> Contact Queries</h2>

<form method="GET">
    <input type="text" name="search" class="search-box" placeholder="Search by Name, Email or Mobile..." value="<?php echo $search; ?>">
</form>

<table class="table">
<tr>
    <th>#</th>
    <th>Name</th>
    <th>Email</th>
    <th>Mobile</th>
    <th>Actions</th>
</tr>

<?php 
$sr = $start + 1;
while($row = $result->fetch_assoc()):
?>
<tr>
    <td><?php echo $sr++; ?></td>
    <td><?php echo $row['name']; ?></td>
    <td><?php echo $row['email']; ?></td>
    <td><?php echo $row['mobile']; ?></td>
    <td class="actions">
        <button class="view-btn" onclick="viewContact(<?php echo $row['id']; ?>)">View</button>
        <button class="delete-btn" onclick="deleteContact(<?php echo $row['id']; ?>)">Delete</button>
    </td>
</tr>
<?php endwhile; ?>
</table>

<div class="pagination">
<?php if($page > 1): ?>
    <a href="?page=<?php echo $page-1; ?>&search=<?php echo $search; ?>">Previous</a>
<?php endif; ?>

<?php for($i=1; $i<=$totalPages; $i++): ?>
    <a class="<?php echo ($i==$page) ? 'active' : ''; ?>" href="?page=<?php echo $i; ?>&search=<?php echo $search; ?>"><?php echo $i; ?></a>
<?php endfor; ?>

<?php if($page < $totalPages): ?>
    <a href="?page=<?php echo $page+1; ?>&search=<?php echo $search; ?>">Next</a>
<?php endif; ?>
</div>

</div>

<div id="modal-bg" style="display:none; justify-content:center; align-items:center; position:fixed; width:100%; height:100%; top:0; left:0; background:rgba(0,0,0,0.6);">
    <div id="modal-content" style="background:white; padding:20px; width:90%; max-width:480px; border-radius:10px; max-height:90vh; overflow-y:auto;"></div>
</div>


<?php include("../includes/admin_footer.php"); ?>

</body>
</html>
