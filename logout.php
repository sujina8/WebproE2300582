<?php
/* ============================================================
   EduSkill – includes/register_student.php
   Handles student account registration (Debug Version)
   ============================================================ */

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 1);

session_start();
require_once 'db.php';
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

// Create a log file for debugging
$logFile = __DIR__ . '/register_debug.log';

function debug_log($message, $data = null) {
    global $logFile;
    $timestamp = date('Y-m-d H:i:s');
    $logEntry = "[$timestamp] $message";
    if ($data !== null) {
        $logEntry .= " - " . print_r($data, true);
    }
    file_put_contents($logFile, $logEntry . "\n", FILE_APPEND);
}

debug_log("=== New registration request ===");

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    debug_log("Invalid request method: " . $_SERVER['REQUEST_METHOD']);
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
    exit;
}

$rawInput = file_get_contents('php://input');
debug_log("Raw input received", $rawInput);

$data = json_decode($rawInput, true);

if (!$data) {
    debug_log("JSON decode failed");
    echo json_encode(['success' => false, 'message' => 'Invalid JSON data received']);
    exit;
}

$firstName = trim($data['firstName'] ?? '');
$lastName  = trim($data['lastName']  ?? '');
$email     = strtolower(trim($data['email'] ?? ''));
$phone     = trim($data['phone']     ?? '');
$education = trim($data['education'] ?? '');
$dob       = trim($data['dob']       ?? '');
$password  = $data['password']       ?? '';

debug_log("Processing registration for: $email");

/* ── Validation ── */
if (!$firstName || !$lastName || !$email || !$phone || !$password) {
    debug_log("Missing required fields");
    echo json_encode(['success' => false, 'message' => 'All required fields must be filled.']);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    debug_log("Invalid email format: $email");
    echo json_encode(['success' => false, 'message' => 'Please enter a valid email address.']);
    exit;
}

if (strlen($password) < 8) {
    debug_log("Password too short");
    echo json_encode(['success' => false, 'message' => 'Password must be at least 8 characters.']);
    exit;
}

/* ── Check if PDO is connected ── */
if (!isset($pdo)) {
    debug_log("PDO not connected!");
    echo json_encode(['success' => false, 'message' => 'Database connection error. Please check XAMPP.']);
    exit;
}

debug_log("PDO connection successful");

/* ── Check if students table exists ── */
try {
    $stmt = $pdo->query("SHOW TABLES LIKE 'students'");
    $tableExists = $stmt->rowCount() > 0;
    debug_log("Students table exists: " . ($tableExists ? "Yes" : "No"));
    
    if (!$tableExists) {
        echo json_encode(['success' => false, 'message' => 'Database table not found. Please run database setup.']);
        exit;
    }
} catch (PDOException $e) {
    debug_log("Table check error: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
    exit;
}

/* ── Check duplicate email ── */
try {
    $stmt = $pdo->prepare("SELECT id FROM students WHERE email = ?");
    $stmt->execute([$email]);
    $existing = $stmt->fetch();
    
    if ($existing) {
        debug_log("Duplicate email found: $email, ID: " . $existing['id']);
        echo json_encode(['success' => false, 'message' => 'This email address is already registered. Please log in instead.']);
        exit;
    }
    
    debug_log("Email is unique");
} catch (PDOException $e) {
    debug_log("Duplicate check error: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
    exit;
}

/* ── Hash password and insert ── */
$hashed = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
debug_log("Password hashed successfully");

try {
    // First, check what columns exist in the table
    $stmt = $pdo->query("DESCRIBE students");
    $columns = $stmt->fetchAll(PDO::FETCH_COLUMN);
    debug_log("Available columns: " . implode(', ', $columns));
    
    // Build insert query based on existing columns
    $insertFields = ['first_name', 'last_name', 'email', 'password', 'phone'];
    $placeholders = ['?', '?', '?', '?', '?'];
    $values = [$firstName, $lastName, $email, $hashed, $phone];
    
    // Add optional fields if they exist in table
    if (in_array('dob', $columns)) {
        $insertFields[] = 'dob';
        $placeholders[] = '?';
        $values[] = $dob ?: null;
    }
    
    if (in_array('education', $columns)) {
        $insertFields[] = 'education';
        $placeholders[] = '?';
        $values[] = $education;
    }
    
    if (in_array('is_verified', $columns)) {
        $insertFields[] = 'is_verified';
        $placeholders[] = '?';
        $values[] = 1;
    }
    
    if (in_array('created_at', $columns)) {
        $insertFields[] = 'created_at';
        $placeholders[] = 'NOW()';
        // No value needed for NOW()
    }
    
    $sql = "INSERT INTO students (" . implode(', ', $insertFields) . ") 
            VALUES (" . implode(', ', $placeholders) . ")";
    
    debug_log("SQL Query: " . $sql);
    debug_log("Values: " . print_r($values, true));
    
    $stmt = $pdo->prepare($sql);
    $result = $stmt->execute($values);
    
    if (!$result) {
        $errorInfo = $stmt->errorInfo();
        debug_log("Insert failed: " . print_r($errorInfo, true));
        echo json_encode(['success' => false, 'message' => 'Failed to insert student record. Error: ' . $errorInfo[2]]);
        exit;
    }
    
    $newId = $pdo->lastInsertId();
    debug_log("Student registered successfully with ID: $newId");
    
    echo json_encode([
        'success' => true,
        'message' => 'Account created successfully! You can now log in.',
        'id'      => $newId
    ]);
    
} catch (PDOException $e) {
    debug_log("Insert error: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
    exit;
}
?>