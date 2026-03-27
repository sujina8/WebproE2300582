<?php
/* ============================================================
   EduSkill – includes/logout.php
   Destroys PHP session and returns JSON confirmation
   Used by all roles: student, provider, admin
   ============================================================ */

session_start();
session_unset();
session_destroy();

header('Content-Type: application/json');
echo json_encode(['success' => true, 'message' => 'Logged out successfully.']);
?>
