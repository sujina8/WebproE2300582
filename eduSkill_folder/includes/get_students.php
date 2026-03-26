<?php
/* ============================================================
   EduSkill – includes/get_students.php
   Returns all registered students (admin use)
   Returns: JSON { success, students: [...] }
   ============================================================ */

session_start();
require_once 'db.php';
header('Content-Type: application/json');

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'Unauthorised.']);
    exit;
}

$stmt = $pdo->query(
    "SELECT s.id,
            CONCAT(s.first_name, ' ', s.last_name) AS full_name,
            s.email, s.phone, s.education,
            s.created_at,
            COUNT(e.id) AS enrolled_courses
     FROM students s
     LEFT JOIN enrolments e ON e.student_id = s.id
     GROUP BY s.id
     ORDER BY s.created_at DESC"
);
$students = $stmt->fetchAll();

echo json_encode([
    'success'  => true,
    'students' => $students,
    'count'    => count($students)
]);
?>
