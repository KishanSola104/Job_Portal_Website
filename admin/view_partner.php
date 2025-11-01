<?php
session_start();
if(!isset($_SESSION['admin_logged_in'])) {
    http_response_code(403);
    exit("Unauthorized Access");
}

include("../includes/db_connect.php");

if(!isset($_GET['id']) || !is_numeric($_GET['id'])){
    exit("Invalid Request");
}

$id = (int)$_GET['id'];

$sql = "SELECT id, company_name, contact_person, email, phone, website, address, service_type, notes, created_at
        FROM partner_applications WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$res = $stmt->get_result();

if($res->num_rows === 0){
    exit("<p style='color:#d00;text-align:center;padding:10px;'>Record not found</p>");
}

$data = $res->fetch_assoc();

// sanitize helpers
function e($s){ return htmlspecialchars($s, ENT_QUOTES, 'UTF-8'); }

// sanitize phone for tel: (allow + and digits only)
$phoneRaw = $data['phone'];
$phoneForTel = preg_replace('/[^\d+]/', '', $phoneRaw);

// sanitize email for mailto
$emailSafe = $data['email'];

$company = e($data['company_name']);
$contact = e($data['contact_person']);
$website = e($data['website']);
$address = nl2br(e($data['address']));
$service = e($data['service_type']);
$notes = nl2br(e($data['notes']));
?>
<h3 style="margin:0 0 8px;color:#004080;"><?php echo $company; ?></h3>

<div class="details-row" style="display:flex;gap:12px;flex-wrap:wrap;margin:6px 0;">
    <p style="margin:6px 0;flex:1 1 45%;"><b>Contact:</b> <?php echo $contact ?: '-'; ?></p>
    <p style="margin:6px 0;flex:1 1 45%;"><b>Email:</b> <?php echo e($emailSafe ?: '-'); ?></p>
    <p style="margin:6px 0;flex:1 1 45%;"><b>Phone:</b> <?php echo e($phoneRaw ?: '-'); ?></p>
    <p style="margin:6px 0;flex:1 1 45%;"><b>Website:</b> <?php echo $website ? '<a href="'.e($website).'" target="_blank" rel="noopener">'.e($website).'</a>' : '-'; ?></p>
    <p class="full" style="flex:1 1 100%;margin-top:8px;"><b>Service Type:</b> <?php echo $service ?: '-'; ?></p>
    <p class="full" style="flex:1 1 100%;"><b>Address:</b> <?php echo $address ?: '-'; ?></p>
    <p class="full" style="flex:1 1 100%;"><b>Notes:</b><br><?php echo $notes ?: '-'; ?></p>
</div>

<div class="btn-row" style="display:flex;gap:10px;justify-content:flex-end;margin-top:12px;flex-wrap:wrap;">
    <button class="close-btn" onclick="closeModal()" style="padding:9px 14px;border-radius:6px;border:none;background:#777;color:#fff;cursor:pointer;">Close</button>

    <?php if(!empty($phoneForTel)): ?>
        <a class="action-btn" href="tel:<?php echo e($phoneForTel); ?>" style="padding:9px 14px;border-radius:6px;background:#22a; color:#fff;text-decoration:none;display:inline-block;">📞 Call</a>
    <?php endif; ?>

    <?php if(!empty($emailSafe)): ?>
        <a class="action-btn" href="mailto:<?php echo rawurlencode($emailSafe); ?>" style="padding:9px 14px;border-radius:6px;background:#0078ff;color:#fff;text-decoration:none;display:inline-block;">✉️ Email</a>
    <?php endif; ?>
</div>

<!-- small styles for modal content -->
<style>
@media (max-width:520px){
    .details-row p{ flex:1 1 100% !important; font-size:14px; }
    .btn-row{ justify-content:center; }
    .close-btn, .action-btn{ width:100%; text-align:center; display:block; }
}
</style>
<?php
$stmt->close();
