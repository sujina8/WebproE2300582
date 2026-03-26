<?php
/* ============================================================
   EduSkill – includes/login_provider.php
   Handles training provider login
   Accepts: POST JSON { email, password }
   Returns: JSON { success, message, name, role, status }
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

/* ── Validation ── */
if (!$email || !$pass) {
    echo json_encode(['success' => false, 'message' => 'Email and password are required.']);
    exit;
}

/* ── Look up provider ── */
$stmt = $pdo->prepare("SELECT * FROM providers WHERE email = ? LIMIT 1");
$stmt->execute([$email]);
$provider = $stmt->fetch();

if (!$provider) {
    echo json_encode(['success' => false, 'message' => 'No account found with this email address.']);
    exit;
}

if (!password_verify($pass, $provider['password'])) {
    echo json_encode(['success' => false, 'message' => 'Incorrect password. Please try again.']);
    exit;
}

/* ── Check approval status ── */
if ($provider['status'] === 'pending') {
    echo json_encode([
        'success' => false,
        'status'  => 'pending',
        'message' => 'Your application is still pending approval from the Ministry of Education. Please check back later.'
    ]);
    exit;
}

if ($provider['status'] === 'rejected') {
    echo json_encode([
        'success' => false,
        'status'  => 'rejected',
        'message' => 'Your application was rejected. Please contact the Ministry of Education for more information.'
    ]);
    exit;
}

/* ── Set PHP session ── */
$_SESSION['role']  = 'provider';
$_SESSION['id']    = $provider['id'];
$_SESSION['name']  = $provider['org_name'];
$_SESSION['email'] = $provider['email'];

echo json_encode([
    'success' => true,
    'message' => 'Login successful.',
    'name'    => $provider['org_name'],
    'role'    => 'provider',
    'id'      => $provider['id']
]);
?>
