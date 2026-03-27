<?php
/* ============================================================
   EduSkill – includes/update_profile.php
   Updates personal information for the logged-in user.
   Accepts: POST JSON {
     firstName, lastName, phone, education, dob, bio   (student)
     orgName, address, website, contactName, contactRole, phone (provider)
   }
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
if (!in_array($role, ['student', 'provider'])) {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'Unauthorised.']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);
$id   = (int) ($_SESSION['id'] ?? 0);

if (!$id) {
    echo json_encode(['success' => false, 'message' => 'Session expired. Please log in again.']);
    exit;
}

/* ── Student profile update ── */
if ($role === 'student') {
    $firstName = trim($data['firstName'] ?? '');
    $lastName  = trim($data['lastName']  ?? '');
    $phone     = trim($data['phone']     ?? '');
    $education = trim($data['education'] ?? '');
    $dob       = trim($data['dob']       ?? '');

    if (!$firstName || !$lastName) {
        echo json_encode(['success' => false, 'message' => 'First and last name are required.']);
        exit;
    }

    $stmt = $pdo->prepare(
        "UPDATE students
         SET first_name = ?, last_name = ?, phone = ?, education = ?, dob = ?
         WHERE id = ?"
    );
    $stmt->execute([$firstName, $lastName, $phone, $education, $dob ?: null, $id]);

    echo json_encode([
        'success' => true,
        'message' => 'Profile updated successfully.',
        'name'    => $firstName . ' ' . $lastName
    ]);
    exit;
}

/* ── Provider profile update ── */
if ($role === 'provider') {
    $orgName     = trim($data['orgName']     ?? '');
    $address     = trim($data['address']     ?? '');
    $website     = trim($data['website']     ?? '');
    $contactName = trim($data['contactName'] ?? '');
    $contactRole = trim($data['contactRole'] ?? '');
    $phone       = trim($data['phone']       ?? '');

    if (!$orgName) {
        echo json_encode(['success' => false, 'message' => 'Organisation name is required.']);
        exit;
    }

    $stmt = $pdo->prepare(
        "UPDATE providers
         SET org_name = ?, address = ?, website = ?, contact_name = ?,
             contact_role = ?, phone = ?
         WHERE id = ?"
    );
    $stmt->execute([$orgName, $address, $website, $contactName, $contactRole, $phone, $id]);

    echo json_encode([
        'success' => true,
        'message' => 'Organisation profile updated successfully.',
        'name'    => $orgName
    ]);
    exit;
}

echo json_encode(['success' => false, 'message' => 'Unknown role.']);
?>
