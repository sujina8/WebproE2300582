<?php
/* ============================================================
   EduSkill – includes/course_modules.php
   Manages course modules/lessons for providers
   GET: Get modules for a course
   POST: Add/update/delete modules
   ============================================================ */

session_start();
require_once 'db.php';
header('Content-Type: application/json');

$method = $_SERVER['REQUEST_METHOD'];
$role = $_SESSION['role'] ?? '';
$userId = (int)($_SESSION['id'] ?? 0);

// GET - Fetch modules for a course
if ($method === 'GET') {
    $courseId = (int)($_GET['course_id'] ?? 0);
    $studentView = isset($_GET['student']) && $_GET['student'] === 'true';
    
    if (!$courseId) {
        echo json_encode(['success' => false, 'message' => 'Course ID required.']);
        exit;
    }
    
    // Verify course exists and access rights
    $stmt = $pdo->prepare("SELECT provider_id, title FROM courses WHERE id = ?");
    $stmt->execute([$courseId]);
    $course = $stmt->fetch();
    
    if (!$course) {
        echo json_encode(['success' => false, 'message' => 'Course not found.']);
        exit;
    }
    
    // Check if student is enrolled for student view
    if ($studentView && $role === 'student') {
        $stmt = $pdo->prepare("SELECT id, progress FROM enrolments WHERE student_id = ? AND course_id = ?");
        $stmt->execute([$userId, $courseId]);
        if (!$stmt->fetch()) {
            echo json_encode(['success' => false, 'message' => 'You are not enrolled in this course.']);
            exit;
        }
    } else if (!$studentView && $role !== 'provider' && $role !== 'admin') {
        http_response_code(403);
        echo json_encode(['success' => false, 'message' => 'Unauthorised.']);
        exit;
    } else if (!$studentView && $role === 'provider' && $course['provider_id'] != $userId) {
        http_response_code(403);
        echo json_encode(['success' => false, 'message' => 'You do not own this course.']);
        exit;
    }
    
    $stmt = $pdo->prepare("
        SELECT id, title, description, video_url, resource_url, 
               duration_minutes, order_position, is_free_preview
        FROM course_modules
        WHERE course_id = ?
        ORDER BY order_position ASC
    ");
    $stmt->execute([$courseId]);
    $modules = $stmt->fetchAll();
    
    // Add progress tracking for students
    if ($role === 'student' && $studentView) {
        $stmt = $pdo->prepare("
            SELECT enrolment_id, module_id, completed
            FROM module_progress mp
            JOIN enrolments e ON e.id = mp.enrolment_id
            WHERE e.student_id = ? AND e.course_id = ?
        ");
        $stmt->execute([$userId, $courseId]);
        $progress = $stmt->fetchAll();
        $progressMap = [];
        foreach ($progress as $p) {
            $progressMap[$p['module_id']] = $p['completed'];
        }
        
        foreach ($modules as &$module) {
            $module['completed'] = $progressMap[$module['id']] ?? 0;
        }
    }
    
    echo json_encode(['success' => true, 'modules' => $modules, 'course_title' => $course['title']]);
    exit;
}

// POST - Manage modules (provider only)
if ($method === 'POST') {
    if ($role !== 'provider') {
        http_response_code(403);
        echo json_encode(['success' => false, 'message' => 'Provider access required.']);
        exit;
    }
    
    $data = json_decode(file_get_contents('php://input'), true);
    $action = $data['action'] ?? '';
    $courseId = (int)($data['course_id'] ?? 0);
    
    // Verify course ownership
    $stmt = $pdo->prepare("SELECT id FROM courses WHERE id = ? AND provider_id = ?");
    $stmt->execute([$courseId, $userId]);
    if (!$stmt->fetch()) {
        echo json_encode(['success' => false, 'message' => 'Course not found or access denied.']);
        exit;
    }
    
    // Add module
    if ($action === 'add') {
        $title = trim($data['title'] ?? '');
        $description = trim($data['description'] ?? '');
        $videoUrl = trim($data['video_url'] ?? '');
        $resourceUrl = trim($data['resource_url'] ?? '');
        $duration = (int)($data['duration_minutes'] ?? 0);
        $order = (int)($data['order_position'] ?? 0);
        $isFreePreview = (int)($data['is_free_preview'] ?? 0);
        
        if (!$title) {
            echo json_encode(['success' => false, 'message' => 'Module title is required.']);
            exit;
        }
        
        $stmt = $pdo->prepare("
            INSERT INTO course_modules (course_id, title, description, video_url, resource_url, 
                                       duration_minutes, order_position, is_free_preview, created_at)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())
        ");
        $stmt->execute([$courseId, $title, $description, $videoUrl, $resourceUrl, 
                        $duration, $order, $isFreePreview]);
        
        echo json_encode(['success' => true, 'message' => 'Module added successfully.', 'module_id' => $pdo->lastInsertId()]);
        exit;
    }
    
    // Update module
    if ($action === 'update') {
        $moduleId = (int)($data['module_id'] ?? 0);
        $title = trim($data['title'] ?? '');
        $description = trim($data['description'] ?? '');
        $videoUrl = trim($data['video_url'] ?? '');
        $resourceUrl = trim($data['resource_url'] ?? '');
        $duration = (int)($data['duration_minutes'] ?? 0);
        $order = (int)($data['order_position'] ?? 0);
        $isFreePreview = (int)($data['is_free_preview'] ?? 0);
        
        if (!$moduleId || !$title) {
            echo json_encode(['success' => false, 'message' => 'Module ID and title required.']);
            exit;
        }
        
        $stmt = $pdo->prepare("
            UPDATE course_modules 
            SET title = ?, description = ?, video_url = ?, resource_url = ?,
                duration_minutes = ?, order_position = ?, is_free_preview = ?, updated_at = NOW()
            WHERE id = ? AND course_id = ?
        ");
        $stmt->execute([$title, $description, $videoUrl, $resourceUrl, $duration, $order, 
                        $isFreePreview, $moduleId, $courseId]);
        
        echo json_encode(['success' => true, 'message' => 'Module updated successfully.']);
        exit;
    }
    
    // Delete module
    if ($action === 'delete') {
        $moduleId = (int)($data['module_id'] ?? 0);
        
        if (!$moduleId) {
            echo json_encode(['success' => false, 'message' => 'Module ID required.']);
            exit;
        }
        
        $stmt = $pdo->prepare("DELETE FROM course_modules WHERE id = ? AND course_id = ?");
        $stmt->execute([$moduleId, $courseId]);
        
        echo json_encode(['success' => true, 'message' => 'Module deleted successfully.']);
        exit;
    }
    
    echo json_encode(['success' => false, 'message' => 'Invalid action.']);
    exit;
}

echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
?>