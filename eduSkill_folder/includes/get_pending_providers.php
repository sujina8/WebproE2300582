<?php
/* ============================================================
   EduSkill – includes/get_pending_providers.php
   Returns all pending provider applications for admin review
   Returns: JSON { success, providers: [...] }
   ============================================================ */

session_start();
require_once 'db.php';
header('Content-Type: application/json');

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'Unauthorised.']);
    exit;
}

$stmt = $pdo->query(
    "SELECT id, org_name, org_type, reg_no, contact_name, email, phone, created_at
     FROM providers
     WHERE status = 'pending'
     ORDER BY created_at ASC"
);
$providers = $stmt->fetchAll();

echo json_encode([
    'success'   => true,
    'providers' => $providers,
    'count'     => count($providers)
]);
?>
