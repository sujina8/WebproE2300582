<?php
/* ============================================================
   EduSkill – includes/process_payment.php
   Handles course payment processing with multiple payment methods
   Supports: Online Banking, Credit Card, e-Wallet
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
    echo json_encode(['success' => false, 'message' => 'Student login required.']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);
$courseId = (int)($data['course_id'] ?? 0);
$paymentMethod = $data['payment_method'] ?? '';
$paymentDetails = $data['payment_details'] ?? [];
$studentId = $_SESSION['id'];

// Validate payment method
$validMethods = ['online_banking', 'credit_card', 'ewallet', 'manual_transfer'];
if (!in_array($paymentMethod, $validMethods)) {
    echo json_encode(['success' => false, 'message' => 'Invalid payment method.']);
    exit;
}

// Get course details
$stmt = $pdo->prepare("SELECT * FROM courses WHERE id = ? AND is_active = 1");
$stmt->execute([$courseId]);
$course = $stmt->fetch();

if (!$course) {
    echo json_encode(['success' => false, 'message' => 'Course not available.']);
    exit;
}

// Check if already enrolled
$stmt = $pdo->prepare("SELECT id FROM enrolments WHERE student_id = ? AND course_id = ?");
$stmt->execute([$studentId, $courseId]);
if ($stmt->fetch()) {
    echo json_encode(['success' => false, 'message' => 'Already enrolled in this course.']);
    exit;
}

// Check available slots
$stmt = $pdo->prepare("SELECT COUNT(*) as enrolled FROM enrolments WHERE course_id = ?");
$stmt->execute([$courseId]);
$enrolled = $stmt->fetch();
if ($enrolled['enrolled'] >= $course['max_students']) {
    echo json_encode(['success' => false, 'message' => 'Course is full.']);
    exit;
}

// Generate payment reference
$paymentRef = 'PAY-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -6)) . '-' . $studentId;

// Create payment record
$stmt = $pdo->prepare("
    INSERT INTO payments (student_id, course_id, amount, payment_method, payment_ref, 
                         payment_details, status, created_at)
    VALUES (?, ?, ?, ?, ?, ?, 'pending', NOW())
");
$stmt->execute([$studentId, $courseId, $course['price'], $paymentMethod, $paymentRef, 
                json_encode($paymentDetails)]);

$paymentId = $pdo->lastInsertId();

// Process based on payment method
$response = ['success' => true, 'payment_id' => $paymentId, 'payment_ref' => $paymentRef];

switch ($paymentMethod) {
    case 'online_banking':
        $banks = ['MAYBANK', 'CIMB', 'PUBLIC_BANK', 'RHB', 'AMBANK'];
        $selectedBank = $paymentDetails['bank'] ?? $banks[array_rand($banks)];
        $response['redirect_url'] = "https://payment.example.com/bank/{$selectedBank}/{$paymentRef}";
        $response['message'] = "Please complete payment through {$selectedBank} online banking.";
        break;
        
    case 'credit_card':
        $response['payment_url'] = "https://payment.example.com/cc/{$paymentRef}";
        $response['message'] = "Redirecting to secure payment gateway...";
        break;
        
    case 'ewallet':
        $wallets = ['TOUCH_N_GO', 'GRABPAY', 'BOOST', 'SHOPEEPAY'];
        $selectedWallet = $paymentDetails['wallet'] ?? $wallets[array_rand($wallets)];
        $response['redirect_url'] = "https://payment.example.com/ewallet/{$selectedWallet}/{$paymentRef}";
        $response['message'] = "Please complete payment using {$selectedWallet}.";
        break;
        
    case 'manual_transfer':
        $bankAccount = [
            'bank' => 'MAYBANK',
            'account_name' => 'EDUSKILL SDN BHD',
            'account_no' => '512345678901',
            'reference' => $paymentRef
        ];
        $response['bank_details'] = $bankAccount;
        $response['message'] = "Please transfer RM " . number_format($course['price'], 2) . 
                               " to the account below and upload your payment proof.";
        break;
}

// Simulate payment success for demo/testing
if (isset($data['simulate_success']) && $data['simulate_success'] === true) {
    $stmt = $pdo->prepare("UPDATE payments SET status = 'completed', paid_at = NOW() WHERE id = ?");
    $stmt->execute([$paymentId]);
    
    // Create enrolment
    $stmt = $pdo->prepare("
        INSERT INTO enrolments (student_id, course_id, amount_paid, payment_ref, payment_method, status, progress, enrolled_at)
        VALUES (?, ?, ?, ?, ?, 'active', 0, NOW())
    ");
    $stmt->execute([$studentId, $courseId, $course['price'], $paymentRef, $paymentMethod]);
    $enrolmentId = $pdo->lastInsertId();
    
    // Generate receipt
    $receiptNo = 'REC-' . date('Ymd') . '-' . str_pad($enrolmentId, 4, '0', STR_PAD_LEFT);
    $stmt = $pdo->prepare("INSERT INTO receipts (enrolment_id, receipt_no, issued_at) VALUES (?, ?, NOW())");
    $stmt->execute([$enrolmentId, $receiptNo]);
    
    $response['success'] = true;
    $response['message'] = 'Payment successful! You are now enrolled.';
    $response['enrolment_id'] = $enrolmentId;
    $response['receipt_no'] = $receiptNo;
}

echo json_encode($response);
?>