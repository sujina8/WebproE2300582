<?php
/* ============================================================
   EduSkill – includes/get_provider_stats.php
   Returns live dashboard statistics for the logged-in provider.
   Returns: JSON {
     success, course_count, student_count, avg_rating,
     revenue_total, courses: [...], enrolments: [...],
     monthly: [...]   ← monthly enrolment counts for chart
   }
   ============================================================ */

session_start();
require_once 'db.php';
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Content-Type');

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'provider') {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'Unauthorised. Provider login required.']);
    exit;
}

$providerId = (int) $_SESSION['id'];

/* ── Course summary ── */
$stmt = $pdo->prepare(
    "SELECT c.id, c.title, c.category, c.level, c.duration,
            c.price, c.is_active, c.created_at,
            COUNT(e.id)          AS enrolled_count,
            COALESCE(AVG(r.rating), 0) AS avg_rating
     FROM courses c
     LEFT JOIN enrolments e ON e.course_id = c.id
     LEFT JOIN reviews    r ON r.course_id = c.id
     WHERE c.provider_id = ?
     GROUP BY c.id
     ORDER BY c.created_at DESC"
);
$stmt->execute([$providerId]);
$courses = $stmt->fetchAll();

/* ── Aggregate stats ── */
$course_count  = count($courses);
$student_count = array_sum(array_column($courses, 'enrolled_count'));
$avg_rating    = $course_count
    ? round(array_sum(array_column($courses, 'avg_rating')) / $course_count, 1)
    : 0;

/* ── Revenue: sum of all enrolment amounts for this provider's courses ── */
$stmt = $pdo->prepare(
    "SELECT COALESCE(SUM(e.amount_paid), 0) AS total
     FROM enrolments e
     JOIN courses c ON c.id = e.course_id
     WHERE c.provider_id = ?"
);
$stmt->execute([$providerId]);
$revenue_total = (float) $stmt->fetchColumn();

/* ── Enrolment list ── */
$stmt = $pdo->prepare(
    "SELECT e.id, e.enrolled_at, e.status, e.progress, e.amount_paid,
            c.title AS course_title,
            CONCAT(s.first_name, ' ', s.last_name) AS student_name,
            s.email AS student_email
     FROM enrolments e
     JOIN courses  c ON c.id  = e.course_id
     JOIN students s ON s.id  = e.student_id
     WHERE c.provider_id = ?
     ORDER BY e.enrolled_at DESC
     LIMIT 50"
);
$stmt->execute([$providerId]);
$enrolments = $stmt->fetchAll();

/* ── Monthly enrolments for current year (chart data) ── */
$year  = (int) date('Y');
$stmt  = $pdo->prepare(
    "SELECT MONTH(e.enrolled_at) AS month, COUNT(*) AS count
     FROM enrolments e
     JOIN courses c ON c.id = e.course_id
     WHERE c.provider_id = ? AND YEAR(e.enrolled_at) = ?
     GROUP BY MONTH(e.enrolled_at)"
);
$stmt->execute([$providerId, $year]);
$monthRows = $stmt->fetchAll();
$monthly   = array_fill(1, 12, 0);
foreach ($monthRows as $row) {
    $monthly[(int)$row['month']] = (int)$row['count'];
}

echo json_encode([
    'success'       => true,
    'course_count'  => $course_count,
    'student_count' => $student_count,
    'avg_rating'    => $avg_rating,
    'revenue_total' => $revenue_total,
    'courses'       => $courses,
    'enrolments'    => $enrolments,
    'monthly'       => array_values($monthly),
]);
?>
