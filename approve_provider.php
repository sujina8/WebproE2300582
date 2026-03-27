<?php
/* ============================================================
   EduSkill – includes/login_admin.php
   Handles admin / Ministry officer login
   Accepts: POST JSON { email, password }
   Returns: JSON { success, message, name, role }
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

$data  = json_decode(file_get_contents('php://input'), true);
$email = strtolower(trim($data['email'] ?? ''));
$pass  = $data['password'] ?? '';

if (!$email || !$pass) {
    echo json_encode(['success' => false, 'message' => 'Email and password are required.']);
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM admins WHERE email = ? LIMIT 1");
$stmt->execute([$email]);
$admin = $stmt->fetch();

if (!$admin) {
    echo json_encode(['success' => false, 'message' => 'Access denied. Invalid credentials.']);
    exit;
}

/* ── Verify password ──
   The seed SQL has a placeholder hash. For first-time setup,
   use this helper: http://localhost/eduskill/includes/create_admin.php
   ── */
if (!password_verify($pass, $admin['password'])) {
    echo json_encode(['success' => false, 'message' => 'Access denied. Invalid credentials.']);
    exit;
}

$_SESSION['role']  = 'admin';
$_SESSION['id']    = $admin['id'];
$_SESSION['name']  = $admin['name'];
$_SESSION['email'] = $admin['email'];

echo json_encode([
    'success' => true,
    'message' => 'Login successful.',
    'name'    => $admin['name'],
    'role'    => 'admin',
    'id'      => $admin['id']
]);
?>
