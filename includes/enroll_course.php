<?php
/* ============================================================
   EduSkill – includes/enroll_course.php
   Handles student course enrolment and receipt generation
   Accepts: POST JSON { course_id, payment_method, payment_ref }
   Returns: JSON { success, message, receipt_no, enrolment_id }
   ============================================================ */

session_start();
require_once 'db.php';
header('Content-Type: application/json');

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'student') {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'You must be logged in as a student to enroll.']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
    exit;
}

$data          = json_decode(file_get_contents('php://input'), true);
$courseId      = (int)($data['course_id']      ?? 0);
$paymentMethod = trim($data['payment_method'] ?? 'Online Transfer');
$paymentRef    = trim($data['payment_ref']    ?? '');
$studentId     = $_SESSION['id'];

if (!$courseId) {
    echo json_encode(['success' => false, 'message' => 'Invalid course.']);
    exit;
}

/* ── Get course details ── */
$stmt = $pdo->prepare("SELECT * FROM courses WHERE id = ? AND is_active = 1");
$stmt->execute([$courseId]);
$course = $stmt->fetch();

if (!$course) {
    echo json_encode(['success' => false, 'message' => 'Course not found or is no longer available.']);
    exit;
}

/* ── Check if already enrolled ── */
$stmt = $pdo->prepare("SELECT id FROM enrolments WHERE student_id = ? AND course_id = ?");
$stmt->execute([$studentId, $courseId]);
if ($stmt->fetch()) {
    echo json_encode(['success' => false, 'message' => 'You are already enrolled in this course.']);
    exit;
}

/* ── Check max students ── */
$stmt = $pdo->prepare("SELECT COUNT(*) AS cnt FROM enrolments WHERE course_id = ?");
$stmt->execute([$courseId]);
$count = $stmt->fetch();
if ($count['cnt'] >= $course['max_students']) {
    echo json_encode(['success' => false, 'message' => 'This course is full. Please check back later.']);
    exit;
}

/* ── Create enrolment ── */
$stmt = $pdo->prepare(
    "INSERT INTO enrolments
     (student_id, course_id, amount_paid, payment_ref, payment_method, status, progress, enrolled_at)
     VALUES (?, ?, ?, ?, ?, 'active', 0, NOW())"
);
$stmt->execute([$studentId, $courseId, $course['price'], $paymentRef, $paymentMethod]);
$enrolmentId = $pdo->lastInsertId();

/* ── Generate unique receipt number ── */
$receiptNo = 'EDU-' . date('Y') . '-' . str_pad($enrolmentId, 4, '0', STR_PAD_LEFT)
           . '-' . strtoupper(substr(md5(uniqid()), 0, 4));

$stmt = $pdo->prepare(
    "INSERT INTO receipts (enrolment_id, receipt_no, issued_at) VALUES (?, ?, NOW())"
);
$stmt->execute([$enrolmentId, $receiptNo]);

echo json_encode([
    'success'      => true,
    'message'      => 'Enrolment successful! Your receipt has been generated.',
    'receipt_no'   => $receiptNo,
    'enrolment_id' => $enrolmentId,
    'course_title' => $course['title'],
    'amount_paid'  => $course['price']
]);
?>
