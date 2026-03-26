<?php
/* ============================================================
   EduSkill – includes/update_progress.php
   Tracks student progress through course materials
   Accepts: POST JSON { enrolment_id, progress_percentage, module_id }
   Returns: JSON { success, message, new_progress, certificate_eligible? }
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

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'student') {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'Unauthorised. Student login required.']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);
$enrolmentId = (int)($data['enrolment_id'] ?? 0);
$progress = (int)($data['progress_percentage'] ?? 0);
$moduleId = (int)($data['module_id'] ?? 0);
$studentId = $_SESSION['id'];

if (!$enrolmentId || $progress < 0 || $progress > 100) {
    echo json_encode(['success' => false, 'message' => 'Invalid enrolment or progress data.']);
    exit;
}

// Verify ownership
$stmt = $pdo->prepare("SELECT e.id, e.progress, e.status, c.title, c.duration 
                       FROM enrolments e 
                       JOIN courses c ON c.id = e.course_id 
                       WHERE e.id = ? AND e.student_id = ?");
$stmt->execute([$enrolmentId, $studentId]);
$enrolment = $stmt->fetch();

if (!$enrolment) {
    echo json_encode(['success' => false, 'message' => 'Enrolment not found or access denied.']);
    exit;
}

// Update progress in course_modules if module tracking is used
if ($moduleId > 0) {
    $stmt = $pdo->prepare("INSERT INTO module_progress (enrolment_id, module_id, completed, last_accessed) 
                           VALUES (?, ?, 1, NOW()) 
                           ON DUPLICATE KEY UPDATE completed = 1, last_accessed = NOW()");
    $stmt->execute([$enrolmentId, $moduleId]);
    
    // Calculate actual progress based on completed modules
    $stmt = $pdo->prepare("SELECT COUNT(*) as total, 
                                  SUM(CASE WHEN mp.completed = 1 THEN 1 ELSE 0 END) as completed
                           FROM course_modules cm
                           LEFT JOIN module_progress mp ON mp.module_id = cm.id AND mp.enrolment_id = ?
                           WHERE cm.course_id = (SELECT course_id FROM enrolments WHERE id = ?)");
    $stmt->execute([$enrolmentId, $enrolmentId]);
    $moduleStats = $stmt->fetch();
    
    if ($moduleStats['total'] > 0) {
        $progress = round(($moduleStats['completed'] / $moduleStats['total']) * 100);
    }
}

// Update enrolment progress
$stmt = $pdo->prepare("UPDATE enrolments SET progress = ?, updated_at = NOW() WHERE id = ?");
$stmt->execute([$progress, $enrolmentId]);

// Check if course is now completed
$certificateEligible = false;
$newStatus = $enrolment['status'];

if ($progress >= 100 && $enrolment['status'] !== 'completed') {
    $newStatus = 'completed';
    $stmt = $pdo->prepare("UPDATE enrolments SET status = 'completed', completed_at = NOW() WHERE id = ?");
    $stmt->execute([$enrolmentId]);
    $certificateEligible = true;
    
    // Generate certificate automatically
    $certNo = 'CERT-' . date('Y') . '-' . str_pad($enrolmentId, 6, '0', STR_PAD_LEFT);
    $stmt = $pdo->prepare("INSERT INTO certificates (enrolment_id, certificate_no, issued_at) 
                           VALUES (?, ?, NOW()) 
                           ON DUPLICATE KEY UPDATE certificate_no = ?");
    $stmt->execute([$enrolmentId, $certNo, $certNo]);
}

echo json_encode([
    'success' => true,
    'message' => $certificateEligible ? 'Congratulations! You have completed the course. Certificate generated.' : 'Progress updated successfully.',
    'new_progress' => $progress,
    'new_status' => $newStatus,
    'certificate_eligible' => $certificateEligible,
    'course_title' => $enrolment['title']
]);
?>