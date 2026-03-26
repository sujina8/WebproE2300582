<?php
/* ============================================================
   EduSkill – includes/db_test.php
   Simple endpoint to check if PHP backend is available
   ============================================================ */
header('Content-Type: application/json');
echo json_encode(['success' => true, 'message' => 'PHP backend available']);
?>