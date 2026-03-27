<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/><meta name="viewport" content="width=device-width,initial-scale=1.0"/>
  <title>Student Login – EduSkill</title>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet"/>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
  <link rel="stylesheet" href="../assets/css/shared.css"/>
  <link rel="stylesheet" href="../assets/css/Sujina.css"/>
</head>
<body>
<!-- Minimal back-link nav -->
<div class="nav-wrapper">
  <nav id="navbar">
    <a href="../index.php" class="nav-logo"><div class="nav-logo-icon"><img src="../assets/images/eduskill-logo.png" alt="EduSkill" style="width:30px;height:30px;object-fit:contain;border-radius:50%;display:block"></div>EduSkill</a>
    <div style="display:flex;gap:10px">
      <a href="../index.php" class="btn-outline" style="font-size:.82rem;padding:8px 18px"><i class="fas fa-home"></i> Home</a>
    </div>
  </nav>
</div>

<div class="auth-wrap">
  <div class="auth-card">
    <div class="auth-icon"><i class="fas fa-user-graduate"></i></div>
    <h2>Student Login</h2>
    <p class="sub">Sign in to access your courses &amp; progress</p>

    <div class="test-creds">
      <strong>Demo Account</strong>
      <p>Email: <code>student@eduskill.my</code><br>Password: <code>Student@123</code></p>
      <p style="margin-top:6px;font-size:.76rem;color:var(--text-light)">
        <i class="fas fa-user-plus" style="color:var(--primary)"></i>&nbsp;
        Or <a href="register.php" style="color:var(--primary);font-weight:600">create your own account</a> — no XAMPP needed.
      </p>
    </div>

    <div class="err-msg" id="errMsg"><i class="fas fa-exclamation-circle"></i> Invalid email or password.</div>

    <div class="fg">
      <label>Email Address</label>
      <div class="input-wrap"><i class="fas fa-envelope prefix"></i><input type="email" id="email" placeholder="student@example.com"/></div>
    </div>
    <div class="fg">
      <label>Password</label>
      <div class="input-wrap">
        <i class="fas fa-lock prefix"></i>
        <input type="password" id="pass" placeholder="Enter your password"/>
        <button class="eye-btn" onclick="togglePw('pass',this)" type="button"><i class="fas fa-eye"></i></button>
      </div>
    </div>
    <button class="auth-btn" onclick="doLogin()">Sign In &nbsp;<i class="fas fa-arrow-right"></i></button>
    <div class="auth-footer">
      Don't have an account? <a href="register.php">Register here</a><br>
      <a href="#" style="margin-top:6px;display:inline-block">Forgot password?</a>
    </div>
  </div>
</div>

<script src="../assets/js/shared.js"></script>
<script src="../assets/js/auth.js"></script>
<script src="../assets/js/Sujina.js"></script>
<script>
if (EduAuth.role() === 'student') window.location.href = 'dashboard.php';

function doLogin() {
  const email = document.getElementById('email').value.trim();
  const pass  = document.getElementById('pass').value;
  const err   = document.getElementById('errMsg');
  err.classList.remove('show');
  if (!email || !pass) {
    err.textContent = 'Please enter your email and password.';
    err.classList.add('show'); return;
  }
  fetch('../includes/login_student.php', {
    method:'POST', headers:{'Content-Type':'application/json'},
    body: JSON.stringify({ email, password: pass })
  })
  .then(r => r.json())
  .then(data => {
    if (data.success) {
      localStorage.setItem('edu_role', data.role);
      localStorage.setItem('edu_name', data.name);
      if (data.id) localStorage.setItem('edu_id', String(data.id));
      showToast('Welcome back, ' + data.name + '!');
      setTimeout(() => window.location.href = 'dashboard.php', 1100);
    } else {
      err.textContent = data.message;
      err.classList.add('show');
    }
  })
  .catch(() => {
    const result = EduAuth.loginStudent(email, pass);
    if (result.success) {
      showToast('Welcome back, ' + result.name + '! (demo mode)');
      setTimeout(() => window.location.href = 'dashboard.php', 1100);
    } else {
      err.textContent = result.message;
      err.classList.add('show');
    }
  });
}
document.querySelectorAll('input').forEach(i =>
  i.addEventListener('keydown', e => { if (e.key === 'Enter') doLogin(); }));
initNavScroll();
</script>
</body>
</html>