<?php
/* ============================================================
   EduSkill – includes/create_admin.php
   ONE-TIME SETUP TOOL — run once, then delete this file
   
   Visit: http://localhost/eduskill/includes/create_admin.php
   This creates the admin account with a properly hashed password
   in the database so the admin login works correctly.
   
   DEFAULT CREDENTIALS CREATED:
     Email:    admin@mohr.gov.my
     Password: Admin@2025!
   
   !! DELETE THIS FILE AFTER RUNNING !!
   ============================================================ */

require_once 'db.php';

$name     = 'Officer Hamid';
$email    = 'admin@mohr.gov.my';
$password = 'Admin@2025!';
$role     = 'super_admin';

/* Hash the password */
$hashed = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);

/* Delete existing admin with same email first */
$stmt = $pdo->prepare("DELETE FROM admins WHERE email = ?");
$stmt->execute([$email]);

/* Insert with proper hash */
$stmt = $pdo->prepare(
    "INSERT INTO admins (name, email, password, role, created_at)
     VALUES (?, ?, ?, ?, NOW())"
);
$stmt->execute([$name, $email, $hashed, $role]);

echo '<div style="font-family:sans-serif;max-width:500px;margin:80px auto;padding:30px;border:2px solid #22c55e;border-radius:12px;background:#f0fdf4;">';
echo '<h2 style="color:#15803d;margin-bottom:16px">✅ Admin account created successfully!</h2>';
echo '<p style="color:#166534;margin-bottom:8px"><strong>Email:</strong> ' . htmlspecialchars($email) . '</p>';
echo '<p style="color:#166534;margin-bottom:8px"><strong>Password:</strong> ' . htmlspecialchars($password) . '</p>';
echo '<p style="color:#166534;margin-bottom:8px"><strong>Role:</strong> ' . htmlspecialchars($role) . '</p>';
echo '<hr style="margin:20px 0;border-color:#86efac">';
echo '<p style="color:#dc2626;font-weight:bold">⚠️ IMPORTANT: Delete this file now!</p>';
echo '<p style="color:#991b1b;font-size:.9rem">Navigate to <code>htdocs/eduskill/includes/</code> and delete <code>create_admin.php</code> immediately for security.</p>';
echo '<p style="margin-top:20px"><a href="../admin/login.html" style="background:#16a34a;color:white;padding:10px 20px;border-radius:8px;text-decoration:none">Go to Admin Login →</a></p>';
echo '</div>';
?>
