<?php
/* ============================================================
   EduSkill – includes/get_enrolments.php
   Returns enrolments for the logged-in student
   Returns: JSON { success, enrolments: [...] }
   ============================================================ */

session_start();
require_once 'db.php';
header('Content-Type: application/json');

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'student') {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'Unauthorised.']);
    exit;
}

$stmt = $pdo->prepare(
    "SELECT e.id AS enrolment_id,
            e.enrolled_at, e.status, e.progress, e.amount_paid,
            e.payment_method,
            c.id   AS course_id,
            c.title, c.category, c.level, c.duration,
            p.org_name AS provider_name,
            r.receipt_no
     FROM enrolments e
     JOIN courses c  ON c.id = e.course_id
     JOIN providers p ON p.id = c.provider_id
     LEFT JOIN receipts r ON r.enrolment_id = e.id
     WHERE e.student_id = ?
     ORDER BY e.enrolled_at DESC"
);
$stmt->execute([$_SESSION['id']]);
$enrolments = $stmt->fetchAll();

echo json_encode([
    'success'     => true,
    'enrolments'  => $enrolments,
    'count'       => count($enrolments)
]);
?>
