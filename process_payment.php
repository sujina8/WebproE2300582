<?php
/* ============================================================
   EduSkill – includes/approve_provider.php
   Admin: approve or reject a training provider
   Accepts: POST JSON { provider_id, action }
            action = 'approve' | 'reject'
   Returns: JSON { success, message }
   ============================================================ */

session_start();
require_once 'db.php';
header('Content-Type: application/json');

/* ── Only admins can call this ── */
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'Unauthorised. Admin access required.']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
    exit;
}

$data       = json_decode(file_get_contents('php://input'), true);
$providerId = (int)($data['provider_id'] ?? 0);
$action     = trim($data['action'] ?? '');

if (!$providerId || !in_array($action, ['approve', 'reject'])) {
    echo json_encode(['success' => false, 'message' => 'Invalid request data.']);
    exit;
}

$newStatus = ($action === 'approve') ? 'approved' : 'rejected';

$stmt = $pdo->prepare("UPDATE providers SET status = ? WHERE id = ?");
$stmt->execute([$newStatus, $providerId]);

if ($stmt->rowCount() === 0) {
    echo json_encode(['success' => false, 'message' => 'Provider not found.']);
    exit;
}

/* ── Get provider name for response ── */
$stmt = $pdo->prepare("SELECT org_name FROM providers WHERE id = ?");
$stmt->execute([$providerId]);
$provider = $stmt->fetch();

echo json_encode([
    'success' => true,
    'message' => ($provider['org_name'] ?? 'Provider') . ' has been ' . $newStatus . '.',
    'status'  => $newStatus
]);
?>
