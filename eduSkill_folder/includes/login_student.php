<?php
/* ============================================================
   EduSkill – includes/login_student.php
   Handles student login authentication
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

/* ── Validation ── */
if (!$email || !$pass) {
    echo json_encode(['success' => false, 'message' => 'Email and password are required.']);
    exit;
}

/* ── Look up student ── */
$stmt = $pdo->prepare("SELECT * FROM students WHERE email = ? LIMIT 1");
$stmt->execute([$email]);
$student = $stmt->fetch();

if (!$student) {
    echo json_encode(['success' => false, 'message' => 'No account found with this email address.']);
    exit;
}

if (!password_verify($pass, $student['password'])) {
    echo json_encode(['success' => false, 'message' => 'Incorrect password. Please try again.']);
    exit;
}

/* ── Set PHP session ── */
$_SESSION['role']  = 'student';
$_SESSION['id']    = $student['id'];
$_SESSION['name']  = $student['first_name'] . ' ' . $student['last_name'];
$_SESSION['email'] = $student['email'];

echo json_encode([
    'success' => true,
    'message' => 'Login successful.',
    'name'    => $student['first_name'] . ' ' . $student['last_name'],
    'role'    => 'student',
    'id'      => $student['id']
]);
?>
