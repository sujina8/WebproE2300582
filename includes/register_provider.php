<?php
/* ============================================================
   EduSkill – includes/register_provider.php
   Handles training provider registration application
   Accepts: POST JSON { orgName, regNo, orgType, address,
                        contactName, contactRole, email,
                        phone, password }
   Returns: JSON { success, message }
   Status is set to 'pending' — awaits admin approval
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

$orgName     = trim($data['orgName']     ?? '');
$regNo       = strtoupper(trim($data['regNo'] ?? ''));
$orgType     = trim($data['orgType']     ?? '');
$address     = trim($data['address']     ?? '');
$contactName = trim($data['contactName'] ?? '');
$contactRole = trim($data['contactRole'] ?? '');
$email       = strtolower(trim($data['email'] ?? ''));
$phone       = trim($data['phone']       ?? '');
$password    = $data['password']         ?? '';

/* ── Validation ── */
if (!$orgName || !$regNo || !$orgType || !$address || !$contactName || !$email || !$phone || !$password) {
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

/* ── Check duplicate email OR registration number ── */
$stmt = $pdo->prepare("SELECT id FROM providers WHERE email = ? OR reg_no = ?");
$stmt->execute([$email, $regNo]);
if ($stmt->fetch()) {
    echo json_encode(['success' => false, 'message' => 'An application with this email or registration number already exists.']);
    exit;
}

/* ── Hash password and insert ── */
$hashed = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);

$stmt = $pdo->prepare(
    "INSERT INTO providers
     (org_name, reg_no, org_type, address, email, password,
      contact_name, contact_role, phone, status, created_at)
     VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 'pending', NOW())"
);
$stmt->execute([
    $orgName,
    $regNo,
    $orgType,
    $address,
    $email,
    $hashed,
    $contactName,
    $contactRole,
    $phone
]);

echo json_encode([
    'success' => true,
    'message' => 'Application submitted successfully. Your account is pending approval from the Ministry of Education. You will be notified once approved.'
]);
?>
