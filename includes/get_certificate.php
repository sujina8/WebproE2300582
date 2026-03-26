<?php
/* ============================================================
   EduSkill – includes/get_certificate.php
   Retrieves certificate information for completed courses
   Accepts: GET enrolment_id (student) or GET all (admin)
   Returns: JSON or PDF certificate data
   ============================================================ */

session_start();
require_once 'db.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
    exit;
}

$role = $_SESSION['role'] ?? '';
$userId = (int)($_SESSION['id'] ?? 0);
$enrolmentId = (int)($_GET['enrolment_id'] ?? 0);
$format = $_GET['format'] ?? 'json';

// For PDF output
if ($format === 'pdf' && $enrolmentId) {
    // This would generate PDF, but for now return JSON
    header('Content-Type: application/json');
}

// Student view - get their certificates
if ($role === 'student') {
    if ($enrolmentId) {
        $stmt = $pdo->prepare("
            SELECT c.certificate_no, c.issued_at, c.verification_code,
                   e.completed_at, e.progress,
                   crs.title as course_title, crs.level, crs.duration,
                   CONCAT(s.first_name, ' ', s.last_name) as student_name,
                   s.email as student_email,
                   p.org_name as provider_name
            FROM certificates c
            JOIN enrolments e ON e.id = c.enrolment_id
            JOIN courses crs ON crs.id = e.course_id
            JOIN students s ON s.id = e.student_id
            JOIN providers p ON p.id = crs.provider_id
            WHERE e.id = ? AND e.student_id = ?
        ");
        $stmt->execute([$enrolmentId, $userId]);
        $certificate = $stmt->fetch();
        
        if (!$certificate) {
            echo json_encode(['success' => false, 'message' => 'Certificate not found or not completed.']);
            exit;
        }
        
        echo json_encode(['success' => true, 'certificate' => $certificate]);
        exit;
    } else {
        // Get all certificates for student
        $stmt = $pdo->prepare("
            SELECT c.certificate_no, c.issued_at, c.verification_code,
                   crs.title as course_title, crs.level,
                   e.completed_at
            FROM certificates c
            JOIN enrolments e ON e.id = c.enrolment_id
            JOIN courses crs ON crs.id = e.course_id
            WHERE e.student_id = ?
            ORDER BY c.issued_at DESC
        ");
        $stmt->execute([$userId]);
        $certificates = $stmt->fetchAll();
        
        echo json_encode(['success' => true, 'certificates' => $certificates, 'count' => count($certificates)]);
        exit;
    }
}

// Admin view - get all certificates
if ($role === 'admin') {
    $stmt = $pdo->query("
        SELECT c.certificate_no, c.issued_at, c.verification_code,
               crs.title as course_title,
               CONCAT(s.first_name, ' ', s.last_name) as student_name,
               s.email as student_email,
               p.org_name as provider_name
        FROM certificates c
        JOIN enrolments e ON e.id = c.enrolment_id
        JOIN courses crs ON crs.id = e.course_id
        JOIN students s ON s.id = e.student_id
        JOIN providers p ON p.id = crs.provider_id
        ORDER BY c.issued_at DESC
        LIMIT 100
    ");
    $certificates = $stmt->fetchAll();
    
    echo json_encode(['success' => true, 'certificates' => $certificates, 'count' => count($certificates)]);
    exit;
}

http_response_code(403);
echo json_encode(['success' => false, 'message' => 'Unauthorised.']);
?>