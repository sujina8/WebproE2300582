<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/><meta name="viewport" content="width=device-width,initial-scale=1.0"/>
  <title>Organisation Profile – EduSkill</title>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet"/>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
  <link rel="stylesheet" href="../assets/css/shared.css"/>
  <link rel="stylesheet" href="../assets/css/Sailabee.css"/>
  <style>
    /* ── Top pill navbar (above hero) ── */
    .profile-nav-wrapper { top: 16px; }
    .profile-nav {
      background: rgba(91,108,246,0.22) !important;
      border-color: rgba(255,255,255,0.3) !important;
    }
    .profile-nav.scrolled {
      background: rgba(255,255,255,0.97) !important;
      border-color: rgba(91,108,246,0.2) !important;
      box-shadow: 0 12px 40px rgba(91,108,246,0.18) !important;
    }
    .profile-nav .nav-logo { color: white; }
    .profile-nav.scrolled .nav-logo { color: var(--provider-accent); }
    .profile-nav .nav-logo-icon { background: rgba(255,255,255,.25); }
    .profile-nav.scrolled .nav-logo-icon { background: var(--provider-accent); }
    .profile-nav .nav-hamburger span { background: white; }
    .profile-nav.scrolled .nav-hamburger span { background: var(--text-dark); }
    .profile-nav-links { display:flex; align-items:center; gap:4px; }
    .profile-nav-links a {
      display:flex; align-items:center; gap:6px; padding:8px 14px;
      border-radius:50px; font-size:.87rem; font-weight:500;
      color:rgba(255,255,255,.9); text-decoration:none;
      transition:background .2s,color .2s; white-space:nowrap;
    }
    .profile-nav-links a:hover { background:rgba(255,255,255,.18); }
    .profile-nav.scrolled .profile-nav-links a { color:var(--text-mid); }
    .profile-nav.scrolled .profile-nav-links a:hover { background:rgba(91,108,246,.09); color:var(--provider-accent); }
    .profile-nav.scrolled .profile-nav-links a[style*="150,150"] { color:#b91c1c !important; }
    .mobile-menu a:hover { background:#f0f0ff; color:var(--provider-accent); }
    .p-hero { padding-top: 110px !important; }
    @media(max-width:768px) { .profile-nav-links { display:none !important; } }
    @media(min-width:769px) { #hamburger { display:none !important; } }

    /* ── Profile body: single column, full width ── */
    .p-body-wrap {
      max-width: 1160px;
      margin: 0 auto;
      padding: 32px 24px 60px;
    }

    /* ── Horizontal tab bar (provider accent = purple) ── */
    .profile-tabs-bar {
      display: flex;
      align-items: center;
      gap: 4px;
      background: white;
      border-radius: 16px;
      padding: 10px 16px;
      margin-bottom: 24px;
      border: 1px solid rgba(91,108,246,0.12);
      box-shadow: 0 3px 14px rgba(91,108,246,0.07);
      flex-wrap: wrap;
    }
    .ptab {
      display: flex;
      align-items: center;
      gap: 7px;
      padding: 9px 18px;
      border-radius: 10px;
      border: none;
      background: none;
      font-family: 'DM Sans', sans-serif;
      font-size: .88rem;
      font-weight: 500;
      color: var(--text-mid);
      cursor: pointer;
      transition: background .2s, color .2s;
      white-space: nowrap;
    }
    .ptab:hover { background: #f0f0ff; color: var(--provider-accent); }
    .ptab.active {
      background: #f0f0ff;
      color: var(--provider-accent);
      border-bottom: 2px solid var(--provider-accent);
      font-weight: 600;
    }
    .ptab i { font-size: .85rem; }
    .ptab-spacer { flex: 1; }
    .ptab-link {
      display: flex;
      align-items: center;
      gap: 7px;
      padding: 9px 16px;
      border-radius: 10px;
      font-size: .87rem;
      font-weight: 500;
      color: var(--provider-accent);
      text-decoration: none;
      transition: background .2s;
      white-space: nowrap;
    }
    .ptab-link:hover { background: #f0f0ff; }
    .ptab-logout { color: #b91c1c !important; }
    .ptab-logout:hover { background: rgba(220,38,38,0.06) !important; }

    /* ── Content area ── */
    .p-content { display: flex; flex-direction: column; gap: 20px; }
    .tab-pane  { display: none; }
    .tab-pane.active { display: block; }

    /* ── Form card ── */
    .form-card {
      background: white;
      border-radius: 18px;
      padding: 28px;
      border: 1px solid rgba(91,108,246,0.1);
      box-shadow: 0 3px 14px rgba(91,108,246,0.06);
      margin-bottom: 20px;
    }
    .sec-title {
      font-family: 'Playfair Display', serif;
      font-size: 1.1rem;
      font-weight: 700;
      margin-bottom: 20px;
      padding-bottom: 12px;
      border-bottom: 1px solid var(--cream-dark);
      color: var(--text-dark);
    }

    /* ── Responsive ── */
    @media(max-width:600px) {
      .profile-tabs-bar { padding:8px 10px; gap:2px; border-radius:12px; }
      .ptab { padding:8px 12px; font-size:.82rem; }
      .ptab-spacer { display:none; }
      .ptab-link { padding:8px 12px; font-size:.82rem; }
      .p-body-wrap { padding:20px 16px 40px; }
      .form-card { padding:20px 16px; }
    }
  </style>
</head>
<body>
<div class="nav-wrapper profile-nav-wrapper">
  <nav id="navbar" class="profile-nav">
    <a href="dashboard.php" class="nav-logo" style="color:white">
      <div class="nav-logo-icon" style="background:rgba(255,255,255,.25)"><i class="fas fa-chalkboard-teacher"></i></div>
      EduSkill
    </a>
    <div class="profile-nav-links">
      <a href="dashboard.php"><i class="fas fa-home"></i> Dashboard</a>
      <a href="courses.php"><i class="fas fa-book"></i> My Courses</a>
      <a href="enrolments.php"><i class="fas fa-users"></i> Enrolments</a>
      <a href="login.php" onclick="EduAuth.logout('login.php')" style="color:rgba(255,150,150,.95)"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </div>
    <button class="nav-hamburger" id="hamburger" aria-label="Menu">
      <span></span><span></span><span></span>
    </button>
  </nav>
  <div class="mobile-menu" id="mobileMenu">
    <a href="dashboard.php"><i class="fas fa-home"></i> Dashboard</a>
    <a href="courses.php"><i class="fas fa-book"></i> My Courses</a>
    <a href="add-course.php"><i class="fas fa-plus-circle"></i> Add Course</a>
    <a href="enrolments.php"><i class="fas fa-users"></i> Student Enrolments</a>
    <a href="materials.php"><i class="fas fa-folder-open"></i> Teaching Materials</a>
    <a href="teaching.php"><i class="fas fa-chalkboard"></i> Course Teaching</a>
    <div class="m-divider"></div>
    <a href="login.php" onclick="EduAuth.logout('login.php')" style="color:#b91c1c"><i class="fas fa-sign-out-alt"></i> Logout</a>
  </div>
</div>

<div class="p-hero">
  <div class="p-inner">
    <div class="org-av"><i class="fas fa-building"></i></div>
    <div class="p-info">
      <h2 id="orgTitle">TechPro Academy</h2>
      <p>provider@techpro.my &nbsp;·&nbsp; SSM-1234567-A</p>
      <div class="chips">
        <span class="chip"><i class="fas fa-check-circle"></i> Approved</span>
        <span class="chip"><i class="fas fa-book"></i> 3 Courses</span>
        <span class="chip"><i class="fas fa-users"></i> 52 Students</span>
      </div>
    </div>
  </div>
</div>

<div class="p-body-wrap">

  <!-- Horizontal tab bar -->
  <div class="profile-tabs-bar">
    <button class="ptab active" onclick="switchPTab('org',this)"><i class="fas fa-building"></i> Organisation</button>
    <button class="ptab" onclick="switchPTab('contact',this)"><i class="fas fa-user"></i> Contact Person</button>
    <button class="ptab" onclick="switchPTab('security',this)"><i class="fas fa-lock"></i> Security</button>
    <button class="ptab" onclick="switchPTab('banking',this)"><i class="fas fa-university"></i> Banking</button>
    <div class="ptab-spacer"></div>
    <a href="dashboard.php" class="ptab-link"><i class="fas fa-home"></i> Dashboard</a>
    <a href="login.php" onclick="EduAuth.logout('login.php')" class="ptab-link ptab-logout"><i class="fas fa-sign-out-alt"></i> Logout</a>
  </div>

  <!-- Content -->
  <div class="p-content">
    <!-- Organisation details -->
    <div class="tab-pane active" id="pane-org">
      <div class="form-card">
        <div class="sec-title">Organisation Details</div>
        <div class="fg"><label>Organisation Name</label><input type="text" value="TechPro Academy Sdn Bhd"/></div>
        <div class="form-row">
          <div class="fg"><label>SSM Registration No.</label><input type="text" value="SSM-1234567-A" readonly style="opacity:.7;cursor:not-allowed"/></div>
          <div class="fg"><label>Organisation Type</label>
            <select><option selected>Private Training Centre</option><option>Public University</option><option>Professional Body</option><option>NGO / Non-profit</option></select>
          </div>
        </div>
        <div class="fg"><label>Business Address</label><input type="text" value="No. 12, Jalan Teknologi, 63000 Cyberjaya, Selangor"/></div>
        <div class="form-row">
          <div class="fg"><label>Website</label><input type="url" value="https://techpro.my"/></div>
          <div class="fg"><label>Year Established</label><input type="number" value="2018"/></div>
        </div>
        <div class="fg"><label>Organisation Description</label>
          <textarea rows="3">TechPro Academy is a leading technology training centre based in Cyberjaya, offering industry-relevant courses in web development, data science, and mobile applications.</textarea>
        </div>
        <button class="btn-primary" style="background:#5b6cf6;box-shadow:none" onclick="showToast('Changes saved!')"><i class="fas fa-save"></i> Save Changes</button>
      </div>
    </div>

    <!-- Contact person -->
    <div class="tab-pane" id="pane-contact">
      <div class="form-card">
        <div class="sec-title">Contact Person Details</div>
        <div class="form-row">
          <div class="fg"><label>Full Name</label><input type="text" value="Dato' Ahmad Syafiq"/></div>
          <div class="fg"><label>Role / Designation</label><input type="text" value="Director"/></div>
        </div>
        <div class="form-row">
          <div class="fg"><label>Official Email</label><input type="email" value="provider@techpro.my"/></div>
          <div class="fg"><label>Phone Number</label><input type="tel" value="+603-8888-1234"/></div>
        </div>
        <button class="btn-primary" style="background:#5b6cf6;box-shadow:none" onclick="showToast('Changes saved!')"><i class="fas fa-save"></i> Save Changes</button>
      </div>
    </div>

    <!-- Security -->
    <div class="tab-pane" id="pane-security">
      <div class="form-card">
        <div class="sec-title">Change Password</div>
        <div class="fg"><label>Current Password</label><input type="password" placeholder="Current password"/></div>
        <div class="fg"><label>New Password</label><input type="password" placeholder="Min 8 chars"/></div>
        <div class="fg"><label>Confirm New Password</label><input type="password" placeholder="Confirm"/></div>
        <button class="btn-primary" style="background:#5b6cf6;box-shadow:none" onclick="showToast('Password updated!')"><i class="fas fa-key"></i> Update Password</button>
      </div>
    </div>

    <!-- Banking -->
    <div class="tab-pane" id="pane-banking">
      <div class="form-card">
        <div class="sec-title">Bank Account for Payouts</div>
        <p style="font-size:.84rem;color:var(--text-light);margin-bottom:16px">Course revenue is transferred here after the Ministry's processing period (7–14 business days).</p>
        <div class="form-row">
          <div class="fg"><label>Bank Name</label>
            <select><option selected>Maybank</option><option>CIMB</option><option>RHB</option><option>Public Bank</option><option>Hong Leong</option></select>
          </div>
          <div class="fg"><label>Account Number</label><input type="text" placeholder="XXXX-XXXX-XXXX"/></div>
        </div>
        <div class="fg"><label>Account Holder Name</label><input type="text" value="TechPro Academy Sdn Bhd"/></div>
        <button class="btn-primary" style="background:#5b6cf6;box-shadow:none" onclick="showToast('Banking details saved!')"><i class="fas fa-save"></i> Save Details</button>
      </div>
    </div>
  </div>
</div>

<script src="../assets/js/shared.js"></script>
<script src="../assets/js/auth.js"></script>
<script src="../assets/js/Sailabee.js"></script>
<script>
requireProvider();
document.getElementById('orgTitle').textContent = EduAuth.name() || 'TechPro Academy';

// Profile horizontal tab switcher
function switchPTab(name, btn) {
  document.querySelectorAll('.tab-pane').forEach(p => p.classList.remove('active'));
  document.querySelectorAll('.ptab').forEach(b => b.classList.remove('active'));
  const pane = document.getElementById('pane-' + name);
  if (pane) pane.classList.add('active');
  if (btn) btn.classList.add('active');
}

// Hamburger toggle
const _hbg = document.getElementById('hamburger');
const _mob = document.getElementById('mobileMenu');
if (_hbg && _mob) {
  _hbg.addEventListener('click', () => {
    _hbg.classList.toggle('open');
    _mob.classList.toggle('open');
  });
}

// Scroll: hero-transparent ↔ white
const _nav = document.getElementById('navbar');
window.addEventListener('scroll', () => {
  _nav.classList.toggle('scrolled', window.scrollY > 50);
});
</script>
</body>
</html>
