<?php
/* ============================================================
   EduSkill – includes/reviews.php
   GET  → returns all published reviews (public)
   POST → submit a new review (student only)
   ============================================================ */

session_start();
require_once 'db.php';
header('Content-Type: application/json');

/* ══ GET – fetch all reviews ════════════════════════════════ */
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $courseId = isset($_GET['course_id']) ? (int)$_GET['course_id'] : null;

    if ($courseId) {
        $stmt = $pdo->prepare(
            "SELECT r.id, r.rating, r.review_text, r.role_label, r.created_at,
                    CONCAT(s.first_name, ' ', s.last_name) AS reviewer_name,
                    c.title AS course_title
             FROM reviews r
             JOIN students s ON s.id = r.student_id
             JOIN courses c  ON c.id = r.course_id
             WHERE r.course_id = ?
             ORDER BY r.created_at DESC"
        );
        $stmt->execute([$courseId]);
    } else {
        $stmt = $pdo->query(
            "SELECT r.id, r.rating, r.review_text, r.role_label, r.created_at,
                    CONCAT(s.first_name, ' ', s.last_name) AS reviewer_name,
                    c.title AS course_title
             FROM reviews r
             JOIN students s ON s.id = r.student_id
             JOIN courses c  ON c.id = r.course_id
             ORDER BY r.created_at DESC
             LIMIT 50"
        );
    }

    $reviews = $stmt->fetchAll();
    echo json_encode(['success' => true, 'reviews' => $reviews, 'count' => count($reviews)]);
    exit;
}

/* ══ POST – submit a review ═════════════════════════════════ */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'student') {
        http_response_code(403);
        echo json_encode(['success' => false, 'message' => 'Only logged-in students can leave reviews.']);
        exit;
    }

    $data       = json_decode(file_get_contents('php://input'), true);
    $courseId   = (int)($data['course_id']   ?? 0);
    $rating     = (int)($data['rating']      ?? 0);
    $reviewText = trim($data['review_text']  ?? '');
    $roleLabel  = trim($data['role_label']   ?? 'Student');
    $studentId  = $_SESSION['id'];

    if (!$courseId || $rating < 1 || $rating > 5 || !$reviewText) {
        echo json_encode(['success' => false, 'message' => 'Please fill in all review fields and select a rating.']);
        exit;
    }

    /* Must be enrolled to review */
    $enrChk = $pdo->prepare(
        "SELECT id FROM enrolments WHERE student_id = ? AND course_id = ?"
    );
    $enrChk->execute([$studentId, $courseId]);
    if (!$enrChk->fetch()) {
        echo json_encode(['success' => false, 'message' => 'You can only review courses you are enrolled in.']);
        exit;
    }

    /* Check already reviewed */
    $revChk = $pdo->prepare("SELECT id FROM reviews WHERE student_id = ? AND course_id = ?");
    $revChk->execute([$studentId, $courseId]);
    if ($revChk->fetch()) {
        echo json_encode(['success' => false, 'message' => 'You have already reviewed this course.']);
        exit;
    }

    $roleLabel = in_array($roleLabel, ['Student','Training Provider']) ? $roleLabel : 'Student';

    $stmt = $pdo->prepare(
        "INSERT INTO reviews (student_id, course_id, role_label, rating, review_text, created_at)
         VALUES (?, ?, ?, ?, ?, NOW())"
    );
    $stmt->execute([$studentId, $courseId, $roleLabel, $rating, $reviewText]);

    echo json_encode(['success' => true, 'message' => 'Thank you! Your review has been submitted.']);
    exit;
}

echo json_encode(['success' => false, 'message' => 'Invalid request.']);
?>
