<?php
/* ============================================================
   EduSkill – includes/notifications.php
   Handles user notifications for all roles
   GET: Fetch notifications
   POST: Mark as read, create notification
   ============================================================ */

session_start();
require_once 'db.php';
header('Content-Type: application/json');

$method = $_SERVER['REQUEST_METHOD'];
$role = $_SESSION['role'] ?? '';
$userId = (int)($_SESSION['id'] ?? 0);

if (!$userId) {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'Please log in.']);
    exit;
}

// GET notifications
if ($method === 'GET') {
    $unreadOnly = isset($_GET['unread']) && $_GET['unread'] === 'true';
    $limit = (int)($_GET['limit'] ?? 50);
    
    $sql = "SELECT id, type, title, message, link, is_read, created_at 
            FROM notifications 
            WHERE user_id = ? AND user_role = ?";
    $params = [$userId, $role];
    
    if ($unreadOnly) {
        $sql .= " AND is_read = 0";
    }
    
    $sql .= " ORDER BY created_at DESC LIMIT ?";
    $params[] = $limit;
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $notifications = $stmt->fetchAll();
    
    // Get unread count
    $stmt = $pdo->prepare("SELECT COUNT(*) as unread FROM notifications WHERE user_id = ? AND user_role = ? AND is_read = 0");
    $stmt->execute([$userId, $role]);
    $unreadCount = $stmt->fetch()['unread'];
    
    echo json_encode([
        'success' => true,
        'notifications' => $notifications,
        'unread_count' => $unreadCount,
        'total' => count($notifications)
    ]);
    exit;
}

// POST - Mark as read or create notification
if ($method === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $action = $data['action'] ?? '';
    
    // Mark as read
    if ($action === 'mark_read') {
        $notificationId = (int)($data['notification_id'] ?? 0);
        
        if ($notificationId) {
            $stmt = $pdo->prepare("UPDATE notifications SET is_read = 1 WHERE id = ? AND user_id = ? AND user_role = ?");
            $stmt->execute([$notificationId, $userId, $role]);
            $affected = $stmt->rowCount();
        } else {
            // Mark all as read
            $stmt = $pdo->prepare("UPDATE notifications SET is_read = 1 WHERE user_id = ? AND user_role = ? AND is_read = 0");
            $stmt->execute([$userId, $role]);
            $affected = $stmt->rowCount();
        }
        
        echo json_encode([
            'success' => true,
            'message' => $affected > 0 ? 'Notifications marked as read.' : 'No unread notifications.',
            'marked_count' => $affected
        ]);
        exit;
    }
    
    // Create a new notification (admin or system only)
    if ($action === 'create') {
        // Only admins can create notifications for others
        if ($_SESSION['role'] !== 'admin' && $_SESSION['role'] !== 'super_admin') {
            http_response_code(403);
            echo json_encode(['success' => false, 'message' => 'Unauthorised to create notifications.']);
            exit;
        }
        
        $targetUserId = (int)($data['user_id'] ?? 0);
        $targetRole = $data['user_role'] ?? '';
        $type = $data['type'] ?? 'general';
        $title = trim($data['title'] ?? '');
        $message = trim($data['message'] ?? '');
        $link = trim($data['link'] ?? '');
        
        if (!$targetUserId || !$targetRole || !$title || !$message) {
            echo json_encode(['success' => false, 'message' => 'Missing required fields.']);
            exit;
        }
        
        $stmt = $pdo->prepare(
            "INSERT INTO notifications (user_id, user_role, type, title, message, link, is_read, created_at)
             VALUES (?, ?, ?, ?, ?, ?, 0, NOW())"
        );
        $stmt->execute([$targetUserId, $targetRole, $type, $title, $message, $link]);
        
        echo json_encode([
            'success' => true,
            'message' => 'Notification sent successfully.',
            'notification_id' => $pdo->lastInsertId()
        ]);
        exit;
    }
    
    // Delete notification
    if ($action === 'delete') {
        $notificationId = (int)($data['notification_id'] ?? 0);
        
        if (!$notificationId) {
            echo json_encode(['success' => false, 'message' => 'Notification ID required.']);
            exit;
        }
        
        // Users can only delete their own notifications
        $stmt = $pdo->prepare("DELETE FROM notifications WHERE id = ? AND user_id = ? AND user_role = ?");
        $stmt->execute([$notificationId, $userId, $role]);
        
        echo json_encode([
            'success' => true,
            'message' => 'Notification deleted.'
        ]);
        exit;
    }
    
    echo json_encode(['success' => false, 'message' => 'Invalid action.']);
    exit;
}

echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
?>