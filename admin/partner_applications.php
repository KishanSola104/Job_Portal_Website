<?php
session_start();
if(!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}

include("../includes/db_connect.php");

// helper
function e($s){ return htmlspecialchars($s, ENT_QUOTES, 'UTF-8'); }

// Search handling
$search = isset($_GET['search']) ? trim($_GET['search']) : "";

// Pagination
$limit = 10;
$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$start = ($page - 1) * $limit;

// Prepare search parameter
$searchParam = "%{$search}%";

// Count total (prepared)
$countSql = "SELECT COUNT(*) AS total FROM partner_applications
             WHERE company_name LIKE ? OR contact_person LIKE ? OR email LIKE ? OR phone LIKE ? OR website LIKE ? OR service_type LIKE ?";
$countStmt = $conn->prepare($countSql);
$countStmt->bind_param("ssssss", $searchParam, $searchParam, $searchParam, $searchParam, $searchParam, $searchParam);
$countStmt->execute();
$countRes = $countStmt->get_result();
$totalRecords = (int)$countRes->fetch_assoc()['total'];
$countStmt->close();

$totalPages = $totalRecords > 0 ? (int)ceil($totalRecords / $limit) : 1;

// Fetch page data (prepared, safe)
$sql = "SELECT id, company_name, contact_person, email, phone, website, service_type, created_at
        FROM partner_applications
        WHERE company_name LIKE ? OR contact_person LIKE ? OR email LIKE ? OR phone LIKE ? OR website LIKE ? OR service_type LIKE ?
        ORDER BY created_at DESC
        LIMIT ?, ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssssii", $searchParam, $searchParam, $searchParam, $searchParam, $searchParam, $searchParam, $start, $limit);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Partner Applications - Admin</title>
    <meta name="viewport" content="width=device-width,initial-scale=1">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
    :root{ --blue:#004080; --accent:#0078ff; --bg:#f8fbff; }
    body{ margin:0; font-family:Arial, sans-serif; background:var(--bg); }
    .container{ width:95%; max-width:1100px; margin:28px auto; padding:12px; }
    h2{ color:var(--blue); text-align:center; margin-bottom:12px; }
    .search-box{ width:100%; padding:10px; border-radius:6px; border:1px solid #bbb; margin-bottom:14px; font-size:15px; }
    .table{ width:100%; border-collapse:collapse; background:#fff; box-shadow:0 3px 12px rgba(0,0,0,0.06); border-radius:8px; overflow:hidden; }
    .table th{ background:var(--blue); color:#fff; text-align:left; padding:12px; font-size:15px; }
    .table td{ padding:12px; border-bottom:1px solid #eef2f5; font-size:15px; vertical-align:middle; }
    .actions button{ border:none; padding:7px 12px; border-radius:6px; cursor:pointer; color:#fff; margin-right:6px; font-size:13px; }
    .view-btn{ background:var(--accent); } .view-btn:hover{ background:#005fcc; }
    .delete-btn{ background:#ff4444; } .delete-btn:hover{ background:#cc0000; }
    .pagination{ text-align:center; margin-top:14px; }
    .pagination a{ display:inline-block; padding:8px 12px; margin:3px; background:#f2f2f2; color:var(--blue); text-decoration:none; border-radius:6px; }
    .pagination a.active{ background:var(--accent); color:#fff; }
    /* mobile: hide extra cols (show only #, name, actions) */
    @media(max-width:700px){
        .table th:nth-child(3), .table th:nth-child(4), .table th:nth-child(5),
        .table td:nth-child(3), .table td:nth-child(4), .table td:nth-child(5){
            display:none;
        }
        .table th, .table td{ padding:10px; font-size:14px; }
        .actions button{ padding:6px 8px; font-size:12px; }
    }
    </style>

    <script>
    function viewPartner(id){
        document.getElementById('modal-bg').style.display = 'flex';
        document.getElementById('modal-content').innerHTML = '<p style="padding:24px;text-align:center">Loading...</p>';
        fetch('view_partner.php?id=' + encodeURIComponent(id))
            .then(r => r.text())
            .then(html => document.getElementById('modal-content').innerHTML = html)
            .catch(()=> document.getElementById('modal-content').innerHTML = '<p style="padding:20px;color:#d00">Failed to load</p>');
    }
    function closeModal(){ document.getElementById('modal-bg').style.display = 'none'; }
    function deletePartner(id){
        if(confirm('Delete this partner application? This action cannot be undone.')){
            window.location.href = 'delete_partner.php?id=' + encodeURIComponent(id);
        }
    }
    </script>
</head>
<body>

<?php include("../includes/admin_header.php"); ?>

<div class="container">
    <h2><i class="fa-solid fa-handshake"></i> Partner Applications</h2>

    <form method="GET" style="margin-bottom:6px;">
        <input type="text" name="search" class="search-box" placeholder="Search by Company, Contact person, Email, Phone or Service..." value="<?php echo e($search); ?>">
    </form>

    <table class="table" role="table" aria-label="Partner applications table">
        <thead>
            <tr>
                <th style="width:64px">#</th>
                <th>Company / Contact</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Service</th>
                <th style="width:155px;text-align:center">Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $sr = $start + 1;
        if($result->num_rows === 0):
        ?>
            <tr><td colspan="6" style="text-align:center;padding:18px;color:#666">No partner applications found.</td></tr>
        <?php
        else:
            while($row = $result->fetch_assoc()):
        ?>
            <tr>
                <td><?php echo $sr++; ?></td>
                <td><?php echo e($row['company_name']) . "<br><small style='color:#555'>". e($row['contact_person']) ."</small>"; ?></td>
                <td><?php echo e($row['email']); ?></td>
                <td><?php echo e($row['phone']); ?></td>
                <td><?php echo e($row['service_type']); ?></td>
                <td class="actions" style="text-align:center">
                    <button class="view-btn" type="button" onclick="viewPartner(<?php echo (int)$row['id']; ?>)">View</button>
                    <button class="delete-btn" type="button" onclick="deletePartner(<?php echo (int)$row['id']; ?>)">Delete</button>
                </td>
            </tr>
        <?php
            endwhile;
        endif;
        $stmt->close();
        ?>
        </tbody>
    </table>

    <div class="pagination" aria-label="Pagination">
        <?php if($page > 1): ?>
            <a href="?page=<?php echo $page-1; ?>&search=<?php echo urlencode($search); ?>">Previous</a>
        <?php endif; ?>

        <?php
        // show compact range around current page
        $visible = 7;
        $startPage = max(1, $page - floor($visible/2));
        $endPage = min($totalPages, $startPage + $visible - 1);
        if($endPage - $startPage + 1 < $visible) $startPage = max(1, $endPage - $visible + 1);
        for($i = $startPage; $i <= $endPage; $i++): ?>
            <a class="<?php echo ($i==$page)?'active':''; ?>" href="?page=<?php echo $i; ?>&search=<?php echo urlencode($search); ?>"><?php echo $i; ?></a>
        <?php endfor; ?>

        <?php if($page < $totalPages): ?>
            <a href="?page=<?php echo $page+1; ?>&search=<?php echo urlencode($search); ?>">Next</a>
        <?php endif; ?>
    </div>
</div>

<!-- Modal -->
<div id="modal-bg" style="display:none; justify-content:center; align-items:center; position:fixed; inset:0; background:rgba(0,0,0,0.6); z-index:3000;">
    <div id="modal-content" style="background:#fff; padding:18px; width:92%; max-width:520px; border-radius:10px; max-height:90vh; overflow:auto;"></div>
</div>


<?php include("../includes/admin_footer.php"); ?>

</body>
</html>
