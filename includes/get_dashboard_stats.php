<?php
/* ============================================================
   EduSkill – includes/get_dashboard_stats.php
   Returns live dashboard statistics for the logged-in student.
   Returns: JSON {
     success, enrolled_count, completed_count,
     cert_count, total_hours, courses: [...],
     recent_enrolments: [...]
   }
   ============================================================ */

session_start();
require_once 'db.php';
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Content-Type');

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'student') {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'Unauthorised. Student login required.']);
    exit;
}

$studentId = (int) $_SESSION['id'];

/* ── Total enrolments ── */
$stmt = $pdo->prepare(
    "SELECT COUNT(*) AS total,
            SUM(CASE WHEN status = 'completed' THEN 1 ELSE 0 END) AS completed,
            SUM(CASE WHEN status = 'active'    THEN 1 ELSE 0 END) AS active
     FROM enrolments
     WHERE student_id = ?"
);
$stmt->execute([$studentId]);
$counts = $stmt->fetch();

/* ── Certificates = completed enrolments ── */
$cert_count  = (int) ($counts['completed'] ?? 0);
$enrolled    = (int) ($counts['total']     ?? 0);
$completed   = (int) ($counts['completed'] ?? 0);

/* ── Estimate hours learned: sum of active progress * course duration hours ── */
/* We use a simple proxy: each 'week' of duration ≈ 7 hours of content */
$stmt = $pdo->prepare(
    "SELECT e.progress, c.duration
     FROM enrolments e
     JOIN courses c ON c.id = e.course_id
     WHERE e.student_id = ? AND e.status IN ('active','completed')"
);
$stmt->execute([$studentId]);
$rows = $stmt->fetchAll();

$total_hours = 0;
foreach ($rows as $row) {
    // Extract numeric week/day count from duration string (e.g. "8 Weeks", "2 Days")
    preg_match('/(\d+)\s*(week|day)/i', $row['duration'] ?? '', $m);
    $unit = strtolower($m[2] ?? 'week');
    $qty  = (int) ($m[1] ?? 0);
    $hrs  = ($unit === 'day') ? $qty * 3 : $qty * 7;
    $total_hours += (int) round($hrs * (min((int)$row['progress'], 100) / 100));
}

/* ── Course progress list ── */
$stmt = $pdo->prepare(
    "SELECT e.progress, e.status, e.enrolled_at,
            c.id AS course_id, c.title, c.category, c.duration, c.level, c.price,
            p.org_name AS provider_name,
            r.receipt_no
     FROM enrolments e
     JOIN courses  c ON c.id  = e.course_id
     JOIN providers p ON p.id = c.provider_id
     LEFT JOIN receipts r ON r.enrolment_id = e.id
     WHERE e.student_id = ?
     ORDER BY e.enrolled_at DESC"
);
$stmt->execute([$studentId]);
$courses = $stmt->fetchAll();

echo json_encode([
    'success'         => true,
    'enrolled_count'  => $enrolled,
    'completed_count' => $completed,
    'cert_count'      => $cert_count,
    'total_hours'     => $total_hours,
    'courses'         => $courses,
]);
?>
