<?php
/* ============================================================
   EduSkill – includes/setup_db.php
   Database setup script - Run once to create tables
   ============================================================ */

require_once 'db.php';
header('Content-Type: application/json');

try {
    // Create students table
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS students (
            id INT AUTO_INCREMENT PRIMARY KEY,
            first_name VARCHAR(80) NOT NULL,
            last_name VARCHAR(80) NOT NULL,
            email VARCHAR(150) NOT NULL UNIQUE,
            password VARCHAR(255) NOT NULL,
            phone VARCHAR(20),
            dob DATE,
            education VARCHAR(100),
            is_verified TINYINT(1) DEFAULT 1,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB
    ");
    
    echo "✅ Students table created/verified\n";
    
    // Check if any students exist
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM students");
    $count = $stmt->fetch();
    echo "📊 Current students count: " . $count['count'] . "\n";
    
    echo "\n🎉 Database setup complete!";
    
} catch (PDOException $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
?>