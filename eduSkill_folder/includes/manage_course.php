<?php
/* ============================================================
   EduSkill – includes/manage_course.php
   Provider: add, update, or delete a course
   Accepts: POST JSON { action, ...fields }
            action = 'add' | 'update' | 'delete'
   Returns: JSON { success, message, course_id? }
   ============================================================ */

session_start();
require_once 'db.php';
header('Content-Type: application/json');

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'provider') {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'Unauthorised. Provider access required.']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
    exit;
}

$data       = json_decode(file_get_contents('php://input'), true);
$action     = trim($data['action'] ?? '');
$providerId = $_SESSION['id'];

/* ══ ADD COURSE ══════════════════════════════════════════════ */
if ($action === 'add') {
    $title       = trim($data['title']       ?? '');
    $category    = trim($data['category']    ?? '');
    $description = trim($data['description'] ?? '');
    $level       = trim($data['level']       ?? 'Beginner');
    $duration    = trim($data['duration']    ?? '');
    $price       = (float)($data['price']    ?? 0);
    $maxStudents = (int)($data['max_students'] ?? 30);

    if (!$title || !$category || !$description || !$duration || $price <= 0) {
        echo json_encode(['success' => false, 'message' => 'Please fill in all required course fields.']);
        exit;
    }

    $stmt = $pdo->prepare(
        "INSERT INTO courses
         (provider_id, title, category, description, level, duration, price, max_students, is_active, created_at)
         VALUES (?, ?, ?, ?, ?, ?, ?, ?, 1, NOW())"
    );
    $stmt->execute([$providerId, $title, $category, $description, $level, $duration, $price, $maxStudents]);

    echo json_encode([
        'success'   => true,
        'message'   => '"' . $title . '" has been published successfully.',
        'course_id' => $pdo->lastInsertId()
    ]);
    exit;
}

/* ══ UPDATE COURSE ══════════════════════════════════════════ */
if ($action === 'update') {
    $courseId    = (int)($data['course_id']  ?? 0);
    $title       = trim($data['title']       ?? '');
    $duration    = trim($data['duration']    ?? '');
    $price       = (float)($data['price']    ?? 0);
    $level       = trim($data['level']       ?? '');
    $description = trim($data['description'] ?? '');

    if (!$courseId || !$title) {
        echo json_encode(['success' => false, 'message' => 'Course ID and title are required.']);
        exit;
    }

    /* Verify ownership */
    $chk = $pdo->prepare("SELECT id FROM courses WHERE id = ? AND provider_id = ?");
    $chk->execute([$courseId, $providerId]);
    if (!$chk->fetch()) {
        echo json_encode(['success' => false, 'message' => 'Course not found or access denied.']);
        exit;
    }

    $stmt = $pdo->prepare(
        "UPDATE courses
         SET title = ?, duration = ?, price = ?, level = ?, description = ?
         WHERE id = ? AND provider_id = ?"
    );
    $stmt->execute([$title, $duration, $price, $level, $description, $courseId, $providerId]);

    echo json_encode(['success' => true, 'message' => 'Course updated successfully.']);
    exit;
}

/* ══ DELETE COURSE ══════════════════════════════════════════ */
if ($action === 'delete') {
    $courseId = (int)($data['course_id'] ?? 0);

    if (!$courseId) {
        echo json_encode(['success' => false, 'message' => 'Course ID is required.']);
        exit;
    }

    /* Check no active enrolments */
    $enrChk = $pdo->prepare(
        "SELECT COUNT(*) AS cnt FROM enrolments WHERE course_id = ? AND status = 'active'"
    );
    $enrChk->execute([$courseId]);
    $enrCount = $enrChk->fetch();
    if ($enrCount['cnt'] > 0) {
        echo json_encode([
            'success' => false,
            'message' => 'Cannot delete this course — it has active student enrolments.'
        ]);
        exit;
    }

    $stmt = $pdo->prepare("DELETE FROM courses WHERE id = ? AND provider_id = ?");
    $stmt->execute([$courseId, $providerId]);

    if ($stmt->rowCount() === 0) {
        echo json_encode(['success' => false, 'message' => 'Course not found or access denied.']);
        exit;
    }

    echo json_encode(['success' => true, 'message' => 'Course deleted successfully.']);
    exit;
}

echo json_encode(['success' => false, 'message' => 'Unknown action.']);
?>
