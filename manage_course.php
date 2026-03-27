<?php
/* ============================================================
   EduSkill – includes/analytics.php
   Comprehensive analytics dashboard data
   For admin: platform-wide metrics
   For provider: course performance metrics
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
$period = $_GET['period'] ?? 'month'; // week, month, year, all
$type = $_GET['type'] ?? 'overview'; // overview, courses, revenue, engagement

if (!in_array($role, ['admin', 'provider'])) {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'Unauthorised.']);
    exit;
}

// Helper function to get date range
function getDateRange($period) {
    switch($period) {
        case 'week':
            return ['start' => date('Y-m-d', strtotime('-7 days')), 'end' => date('Y-m-d')];
        case 'month':
            return ['start' => date('Y-m-d', strtotime('-30 days')), 'end' => date('Y-m-d')];
        case 'year':
            return ['start' => date('Y-m-d', strtotime('-365 days')), 'end' => date('Y-m-d')];
        default:
            return ['start' => '1970-01-01', 'end' => date('Y-m-d')];
    }
}

$dateRange = getDateRange($period);
$response = ['success' => true, 'period' => $period];

// Admin analytics
if ($role === 'admin') {
    if ($type === 'overview' || $type === 'all') {
        // Total users
        $stmt = $pdo->query("SELECT COUNT(*) as total FROM students");
        $response['total_students'] = $stmt->fetch()['total'];
        
        $stmt = $pdo->query("SELECT COUNT(*) as total FROM providers WHERE status = 'approved'");
        $response['total_providers'] = $stmt->fetch()['total'];
        
        $stmt = $pdo->query("SELECT COUNT(*) as total FROM courses WHERE is_active = 1");
        $response['total_courses'] = $stmt->fetch()['total'];
        
        // Total revenue
        $stmt = $pdo->query("SELECT SUM(amount_paid) as total FROM enrolments");
        $response['total_revenue'] = (float)($stmt->fetch()['total'] ?? 0);
        
        // Enrolment trends
        $stmt = $pdo->prepare("
            SELECT DATE(enrolled_at) as date, COUNT(*) as count
            FROM enrolments
            WHERE enrolled_at BETWEEN ? AND ?
            GROUP BY DATE(enrolled_at)
            ORDER BY date ASC
        ");
        $stmt->execute([$dateRange['start'], $dateRange['end']]);
        $response['enrolment_trends'] = $stmt->fetchAll();
        
        // Top courses
        $stmt = $pdo->query("
            SELECT c.title, COUNT(e.id) as enrolment_count, 
                   SUM(e.amount_paid) as revenue, c.price
            FROM courses c
            LEFT JOIN enrolments e ON e.course_id = c.id
            GROUP BY c.id
            ORDER BY enrolment_count DESC
            LIMIT 10
        ");
        $response['top_courses'] = $stmt->fetchAll();
        
        // Completion rates
        $stmt = $pdo->query("
            SELECT 
                COUNT(*) as total_enrolments,
                SUM(CASE WHEN status = 'completed' THEN 1 ELSE 0 END) as completed,
                ROUND(SUM(CASE WHEN status = 'completed' THEN 1 ELSE 0 END) / COUNT(*) * 100, 1) as completion_rate
            FROM enrolments
        ");
        $response['completion_stats'] = $stmt->fetch();
        
        // Recent activity
        $stmt = $pdo->query("
            (SELECT 'enrolment' as type, e.id, CONCAT(s.first_name, ' ', s.last_name) as user, 
                    c.title as item, e.enrolled_at as created_at
             FROM enrolments e
             JOIN students s ON s.id = e.student_id
             JOIN courses c ON c.id = e.course_id
             ORDER BY e.enrolled_at DESC LIMIT 5)
            UNION ALL
            (SELECT 'registration' as type, s.id, CONCAT(s.first_name, ' ', s.last_name) as user, 
                    'Student' as item, s.created_at as created_at
             FROM students s
             ORDER BY s.created_at DESC LIMIT 5)
            UNION ALL
            (SELECT 'course' as type, c.id, p.org_name as user, 
                    c.title as item, c.created_at as created_at
             FROM courses c
             JOIN providers p ON p.id = c.provider_id
             ORDER BY c.created_at DESC LIMIT 5)
            ORDER BY created_at DESC LIMIT 15
        ");
        $response['recent_activity'] = $stmt->fetchAll();
    }
}

// Provider analytics
if ($role === 'provider') {
    // Get provider's courses
    $stmt = $pdo->prepare("SELECT id, title FROM courses WHERE provider_id = ?");
    $stmt->execute([$userId]);
    $courses = $stmt->fetchAll();
    $courseIds = array_column($courses, 'id');
    
    if ($type === 'overview' || $type === 'all') {
        // Course count
        $response['total_courses'] = count($courses);
        
        // Total students across all courses
        if (!empty($courseIds)) {
            $placeholders = str_repeat('?,', count($courseIds) - 1) . '?';
            $stmt = $pdo->prepare("SELECT COUNT(DISTINCT student_id) as total FROM enrolments WHERE course_id IN ($placeholders)");
            $stmt->execute($courseIds);
            $response['total_students'] = $stmt->fetch()['total'];
            
            // Total revenue
            $stmt = $pdo->prepare("SELECT SUM(amount_paid) as total FROM enrolments WHERE course_id IN ($placeholders)");
            $stmt->execute($courseIds);
            $response['total_revenue'] = (float)($stmt->fetch()['total'] ?? 0);
            
            // Average rating
            $stmt = $pdo->prepare("SELECT AVG(rating) as avg_rating FROM reviews WHERE course_id IN ($placeholders)");
            $stmt->execute($courseIds);
            $response['avg_rating'] = round($stmt->fetch()['avg_rating'] ?? 0, 1);
        } else {
            $response['total_students'] = 0;
            $response['total_revenue'] = 0;
            $response['avg_rating'] = 0;
        }
        
        // Monthly enrolment trend
        $stmt = $pdo->prepare("
            SELECT DATE_FORMAT(enrolled_at, '%Y-%m') as month, COUNT(*) as count
            FROM enrolments e
            WHERE e.course_id IN ($placeholders) AND enrolled_at BETWEEN ? AND ?
            GROUP BY DATE_FORMAT(enrolled_at, '%Y-%m')
            ORDER BY month ASC
        ");
        $stmt->execute(array_merge($courseIds, [$dateRange['start'], $dateRange['end']]));
        $response['monthly_trend'] = $stmt->fetchAll();
        
        // Course performance breakdown
        $response['course_performance'] = [];
        foreach ($courses as $course) {
            $stmt = $pdo->prepare("
                SELECT 
                    COUNT(*) as enrolments,
                    SUM(CASE WHEN status = 'completed' THEN 1 ELSE 0 END) as completions,
                    AVG(progress) as avg_progress
                FROM enrolments
                WHERE course_id = ?
            ");
            $stmt->execute([$course['id']]);
            $stats = $stmt->fetch();
            
            $stmt = $pdo->prepare("SELECT AVG(rating) as rating FROM reviews WHERE course_id = ?");
            $stmt->execute([$course['id']]);
            $rating = $stmt->fetch();
            
            $response['course_performance'][] = [
                'course_id' => $course['id'],
                'title' => $course['title'],
                'enrolments' => $stats['enrolments'] ?? 0,
                'completions' => $stats['completions'] ?? 0,
                'completion_rate' => $stats['enrolments'] > 0 ? round(($stats['completions'] / $stats['enrolments']) * 100, 1) : 0,
                'avg_progress' => round($stats['avg_progress'] ?? 0, 1),
                'avg_rating' => round($rating['rating'] ?? 0, 1)
            ];
        }
        
        // Student engagement metrics
        if (!empty($courseIds)) {
            $stmt = $pdo->prepare("
                SELECT 
                    AVG(progress) as avg_progress,
                    COUNT(DISTINCT student_id) as active_students
                FROM enrolments
                WHERE course_id IN ($placeholders) AND progress > 0
            ");
            $stmt->execute($courseIds);
            $engagement = $stmt->fetch();
            $response['engagement_metrics'] = [
                'avg_progress' => round($engagement['avg_progress'] ?? 0, 1),
                'active_students' => $engagement['active_students'] ?? 0,
                'total_students' => $response['total_students']
            ];
        }
    }
}

echo json_encode($response);
?>