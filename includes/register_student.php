<?php
/* ============================================================
   EduSkill – includes/register_student.php
   Handles student account registration
   Accepts: POST JSON { firstName, lastName, email, phone,
                        education, dob, password }
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

$data = json_decode(file_get_contents('php://input'), true);

$firstName = trim($data['firstName'] ?? '');
$lastName  = trim($data['lastName']  ?? '');
$email     = strtolower(trim($data['email'] ?? ''));
$phone     = trim($data['phone']     ?? '');
$education = trim($data['education'] ?? '');
$dob       = trim($data['dob']       ?? '');
$password  = $data['password']       ?? '';

/* ── Validation ── */
if (!$firstName || !$lastName || !$email || !$phone || !$password) {
    echo json_encode(['success' => false, 'message' => 'All required fields must be filled.']);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['success' => false, 'message' => 'Please enter a valid email address.']);
    exit;
}

if (strlen($password) < 8) {
    echo json_encode(['success' => false, 'message' => 'Password must be at least 8 characters.']);
    exit;
}

if (!preg_match('/[A-Z]/', $password)) {
    echo json_encode(['success' => false, 'message' => 'Password must contain at least one uppercase letter.']);
    exit;
}

if (!preg_match('/[0-9]/', $password)) {
    echo json_encode(['success' => false, 'message' => 'Password must contain at least one number.']);
    exit;
}

/* ── Check duplicate email ── */
$stmt = $pdo->prepare("SELECT id FROM students WHERE email = ?");
$stmt->execute([$email]);
if ($stmt->fetch()) {
    echo json_encode(['success' => false, 'message' => 'This email address is already registered. Please log in instead.']);
    exit;
}

/* ── Hash password and insert ── */
$hashed = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);

$stmt = $pdo->prepare(
    "INSERT INTO students (first_name, last_name, email, password, phone, dob, education, is_verified, created_at)
     VALUES (?, ?, ?, ?, ?, ?, ?, 1, NOW())"
);
$stmt->execute([
    $firstName,
    $lastName,
    $email,
    $hashed,
    $phone,
    $dob ?: null,
    $education
]);

$newId = $pdo->lastInsertId();

echo json_encode([
    'success' => true,
    'message' => 'Account created successfully! You can now log in.',
    'id'      => $newId
]);
?>
