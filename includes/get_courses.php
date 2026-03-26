<?php
/* ============================================================
   EduSkill – includes/get_courses.php
   Returns active courses (public) or all courses (admin)
   Query params: ?role=admin (for admin full list)
   Returns: JSON { success, courses: [...] }
   ============================================================ */

session_start();
require_once 'db.php';
header('Content-Type: application/json');

$role = $_GET['role'] ?? 'public';

if ($role === 'admin') {
    if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
        http_response_code(403);
        echo json_encode(['success' => false, 'message' => 'Unauthorised.']);
        exit;
    }
    $stmt = $pdo->query(
        "SELECT c.*, p.org_name AS provider_name,
                COUNT(e.id) AS enrolled_count
         FROM courses c
         JOIN providers p ON p.id = c.provider_id
         LEFT JOIN enrolments e ON e.course_id = c.id
         GROUP BY c.id
         ORDER BY c.created_at DESC"
    );
} elseif ($role === 'provider') {
    if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'provider') {
        http_response_code(403);
        echo json_encode(['success' => false, 'message' => 'Unauthorised.']);
        exit;
    }
    $stmt = $pdo->prepare(
        "SELECT c.*, COUNT(e.id) AS enrolled_count
         FROM courses c
         LEFT JOIN enrolments e ON e.course_id = c.id
         WHERE c.provider_id = ?
         GROUP BY c.id
         ORDER BY c.created_at DESC"
    );
    $stmt->execute([$_SESSION['id']]);
} else {
    /* Public — only active courses */
    $stmt = $pdo->query(
        "SELECT c.id, c.title, c.category, c.description,
                c.level, c.duration, c.price,
                p.org_name AS provider_name,
                COUNT(e.id) AS enrolled_count
         FROM courses c
         JOIN providers p ON p.id = c.provider_id AND p.status = 'approved'
         LEFT JOIN enrolments e ON e.course_id = c.id
         WHERE c.is_active = 1
         GROUP BY c.id
         ORDER BY enrolled_count DESC"
    );
}

$courses = $stmt->fetchAll();

echo json_encode([
    'success' => true,
    'courses' => $courses,
    'count'   => count($courses)
]);
?>
