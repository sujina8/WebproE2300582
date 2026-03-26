<?php
/* ============================================================
   EduSkill – includes/change_password.php
   Allows logged-in students or providers to change their password.
   Accepts: POST JSON { currentPassword, newPassword, confirmPassword }
   Returns: JSON { success, message }
   ============================================================ */

session_start();
require_once 'db.php';
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
    exit;
}

$role = $_SESSION['role'] ?? '';
$id   = (int) ($_SESSION['id'] ?? 0);

if (!in_array($role, ['student', 'provider']) || !$id) {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'Unauthorised.']);
    exit;
}

$data    = json_decode(file_get_contents('php://input'), true);
$current = $data['currentPassword'] ?? '';
$new     = $data['newPassword']     ?? '';
$confirm = $data['confirmPassword'] ?? '';

/* ── Basic validation ── */
if (!$current || !$new || !$confirm) {
    echo json_encode(['success' => false, 'message' => 'All password fields are required.']);
    exit;
}
if ($new !== $confirm) {
    echo json_encode(['success' => false, 'message' => 'New passwords do not match.']);
    exit;
}
if (strlen($new) < 8) {
    echo json_encode(['success' => false, 'message' => 'New password must be at least 8 characters.']);
    exit;
}
if (!preg_match('/[A-Z]/', $new)) {
    echo json_encode(['success' => false, 'message' => 'New password must contain at least one uppercase letter.']);
    exit;
}
if (!preg_match('/[0-9]/', $new)) {
    echo json_encode(['success' => false, 'message' => 'New password must contain at least one number.']);
    exit;
}

/* ── Fetch stored hash ── */
$table = ($role === 'student') ? 'students' : 'providers';
$stmt  = $pdo->prepare("SELECT password FROM {$table} WHERE id = ? LIMIT 1");
$stmt->execute([$id]);
$record = $stmt->fetch();

if (!$record) {
    echo json_encode(['success' => false, 'message' => 'Account not found.']);
    exit;
}

/* ── Verify current password ── */
if (!password_verify($current, $record['password'])) {
    echo json_encode(['success' => false, 'message' => 'Your current password is incorrect.']);
    exit;
}

/* ── Hash and update new password ── */
$hashed = password_hash($new, PASSWORD_BCRYPT, ['cost' => 12]);
$stmt   = $pdo->prepare("UPDATE {$table} SET password = ? WHERE id = ?");
$stmt->execute([$hashed, $id]);

echo json_encode([
    'success' => true,
    'message' => 'Password changed successfully. Please log in again if prompted.'
]);
?>
