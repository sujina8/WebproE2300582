<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/><meta name="viewport" content="width=device-width,initial-scale=1.0"/>
  <title>Admin Dashboard – EduSkill</title>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet"/>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
  <link rel="stylesheet" href="../assets/css/shared.css"/>
  <link rel="stylesheet" href="../assets/css/Mijala.css"/>
</head>
<body>
<div class="dash-layout">
  <!-- Dark sidebar -->
  <aside class="sidebar">
    <div class="sidebar-logo"><i class="fas fa-user-shield"></i> Admin</div>
    <div class="sidebar-label">Main</div>
    <a href="dashboard.php" class="active"><i class="fas fa-home"></i> Dashboard</a>
    <div class="sidebar-label">Management</div>
    <a href="providers.php"><i class="fas fa-building"></i> Provider Management</a>
    <a href="courses.php"><i class="fas fa-book"></i> Course Management</a>
    <a href="students.php"><i class="fas fa-users"></i> Student Information</a>
    <div class="sidebar-label">Reports</div>
    <a href="reports.php"><i class="fas fa-chart-pie"></i> Platform Reports</a>
    <div class="sidebar-label">System</div>
    <a href="#" onclick="showToast('Settings coming soon.')"><i class="fas fa-cog"></i> Settings</a>
    <a href="login.php" class="logout-link" onclick="EduAuth.logout('login.php')"><i class="fas fa-sign-out-alt"></i> Logout</a>
  </aside>

  <main class="dash-main">
    <!-- Top nav -->
    <div class="nav-wrapper" style="position:fixed;top:16px;left:var(--sidebar-w);right:0;transform:none;width:calc(100% - var(--sidebar-w) - 32px);max-width:900px">
      <nav id="navbar" style="border-radius:20px">
        <span class="nav-logo" style="font-size:1rem"><i class="fas fa-shield-alt" style="color:var(--primary);margin-right:6px"></i>Admin Portal</span>
        <div style="display:flex;align-items:center;gap:12px">
          <span id="navName" style="font-size:.85rem;color:var(--text-mid)"></span>
          <a href="login.php" onclick="EduAuth.logout('login.php')" class="btn-outline" style="font-size:.8rem;padding:7px 16px"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </div>
      </nav>
    </div>

    <div style="margin-top:56px">
      <div class="welcome-banner">
        <div>
          <h2 id="wName">Welcome, Officer Hamid</h2>
          <p>Ministry of Education &nbsp;·&nbsp; EduSkill Admin Panel</p>
        </div>
        <span class="admin-badge"><i class="fas fa-shield-alt"></i> &nbsp;Admin Access</span>
      </div>

      <div class="stat-grid">
        <div class="stat-box"><div class="sb-icon"><i class="fas fa-building"></i></div><div class="sb-val" id="statProviders">12</div><div class="sb-label">Approved Providers</div></div>
        <div class="stat-box"><div class="sb-icon blue"><i class="fas fa-clock"></i></div><div class="sb-val" id="pendCount">2</div><div class="sb-label">Pending Approvals</div></div>
        <div class="stat-box"><div class="sb-icon green"><i class="fas fa-users"></i></div><div class="sb-val" id="statStudents">1,240</div><div class="sb-label">Total Students</div></div>
        <div class="stat-box"><div class="sb-icon purple"><i class="fas fa-book"></i></div><div class="sb-val">90</div><div class="sb-label">Total Courses</div></div>
      </div>

      <!-- Pending approvals -->
      <div class="form-card">
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:18px;flex-wrap:wrap;gap:10px">
          <h3><i class="fas fa-user-check" style="color:var(--primary);margin-right:8px"></i>Pending Provider Approvals</h3>
          <a href="providers.php" style="font-size:.83rem;color:var(--primary);font-weight:600">View All Providers →</a>
        </div>
        <div id="approvalList"></div>
      </div>

      <!-- Quick navigation cards -->
      <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:16px;margin-bottom:24px">
        <a href="providers.php" style="background:white;border-radius:16px;padding:22px;border:1px solid rgba(201,123,46,.1);box-shadow:0 3px 14px rgba(201,123,46,.07);display:flex;align-items:center;gap:14px;transition:transform .2s,box-shadow .2s" onmouseover="this.style.transform='translateY(-4px)';this.style.boxShadow='0 10px 28px rgba(201,123,46,.14)'" onmouseout="this.style.transform='';this.style.boxShadow=''">
          <div style="width:48px;height:48px;border-radius:12px;background:rgba(91,108,246,.1);display:flex;align-items:center;justify-content:center;flex-shrink:0"><i class="fas fa-building" style="color:#5b6cf6;font-size:1.1rem"></i></div>
          <div><div style="font-weight:600;font-size:.95rem">Provider Management</div><div style="font-size:.78rem;color:var(--text-light)">Approve, view & manage</div></div>
        </a>
        <a href="courses.php" style="background:white;border-radius:16px;padding:22px;border:1px solid rgba(201,123,46,.1);box-shadow:0 3px 14px rgba(201,123,46,.07);display:flex;align-items:center;gap:14px;transition:transform .2s,box-shadow .2s" onmouseover="this.style.transform='translateY(-4px)';this.style.boxShadow='0 10px 28px rgba(201,123,46,.14)'" onmouseout="this.style.transform='';this.style.boxShadow=''">
          <div style="width:48px;height:48px;border-radius:12px;background:rgba(201,123,46,.1);display:flex;align-items:center;justify-content:center;flex-shrink:0"><i class="fas fa-book" style="color:var(--primary);font-size:1.1rem"></i></div>
          <div><div style="font-weight:600;font-size:.95rem">Course Management</div><div style="font-size:.78rem;color:var(--text-light)">Review & manage all courses</div></div>
        </a>
        <a href="students.php" style="background:white;border-radius:16px;padding:22px;border:1px solid rgba(201,123,46,.1);box-shadow:0 3px 14px rgba(201,123,46,.07);display:flex;align-items:center;gap:14px;transition:transform .2s,box-shadow .2s" onmouseover="this.style.transform='translateY(-4px)';this.style.boxShadow='0 10px 28px rgba(201,123,46,.14)'" onmouseout="this.style.transform='';this.style.boxShadow=''">
          <div style="width:48px;height:48px;border-radius:12px;background:rgba(22,163,74,.1);display:flex;align-items:center;justify-content:center;flex-shrink:0"><i class="fas fa-users" style="color:#16a34a;font-size:1.1rem"></i></div>
          <div><div style="font-weight:600;font-size:.95rem">Student Information</div><div style="font-size:.78rem;color:var(--text-light)">View enrolled students</div></div>
        </a>
        <a href="reports.php" style="background:white;border-radius:16px;padding:22px;border:1px solid rgba(201,123,46,.1);box-shadow:0 3px 14px rgba(201,123,46,.07);display:flex;align-items:center;gap:14px;transition:transform .2s,box-shadow .2s" onmouseover="this.style.transform='translateY(-4px)';this.style.boxShadow='0 10px 28px rgba(201,123,46,.14)'" onmouseout="this.style.transform='';this.style.boxShadow=''">
          <div style="width:48px;height:48px;border-radius:12px;background:rgba(139,92,246,.1);display:flex;align-items:center;justify-content:center;flex-shrink:0"><i class="fas fa-chart-pie" style="color:#8b5cf6;font-size:1.1rem"></i></div>
          <div><div style="font-weight:600;font-size:.95rem">Platform Reports</div><div style="font-size:.78rem;color:var(--text-light)">Analytics & enrolments</div></div>
        </a>
      </div>
    </div>
  </main>
</div>
<!-- Provider detail modal -->
<div class="modal-overlay" id="provModal">
  <div class="modal" style="max-width:620px">
    <h3 id="modalProvName"></h3>

    <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:16px;font-size:.87rem">
      <div><span style="color:var(--text-light)">Type:</span> <span id="mType"></span></div>
      <div><span style="color:var(--text-light)">Reg No:</span> <span id="mReg"></span></div>
      <div><span style="color:var(--text-light)">Contact:</span> <span id="mContact"></span></div>
      <div><span style="color:var(--text-light)">Email:</span> <span id="mEmail"></span></div>
      <div><span style="color:var(--text-light)">Courses:</span> <span id="mCourses"></span></div>
      <div><span style="color:var(--text-light)">Students:</span> <span id="mStudents"></span></div>
      <div><span style="color:var(--text-light)">Applied:</span> <span id="mDate"></span></div>
      <div><span style="color:var(--text-light)">Status:</span> <span id="mStatus"></span></div>
    </div>

    <div style="display:flex;gap:10px;margin-top:10px">
      <button class="btn-approve" onclick="modalApproval('approve')">
        <i class="fas fa-check"></i> Approve
      </button>

      <button class="btn-reject" onclick="modalApproval('reject')">
        <i class="fas fa-times"></i> Reject
      </button>

      <button class="btn-outline" onclick="document.getElementById('provModal').classList.remove('open')">
        Close
      </button>
    </div>
  </div>
</div>

<div class="toast" id="toast"><i id="toastIcon" class="fas fa-check-circle" style="color:#4ade80"></i><span id="toastMsg"></span></div>

<script src="../assets/js/shared.js"></script>
<script src="../assets/js/auth.js"></script>
<script src="../assets/js/Mijala.js"></script>
<script>
requireAdmin();
document.getElementById('wName').textContent = 'Welcome, ' + EduAuth.name();
document.getElementById('navName').textContent = EduAuth.name();

// Merge registered providers (from localStorage) into pending list
(function mergeRegistered() {
  const registered = EduAuth.getProviders().filter(p => p.status === 'pending');
  registered.forEach(p => {
    if (!PENDING_PROVIDERS.find(x => x.email === p.email)) {
      PENDING_PROVIDERS.push({
        id     : p.id,
        name   : p.orgName,
        type   : p.orgType,
        reg    : p.regNo,
        contact: p.contactName,
        email  : p.email,
        date   : new Date(p.appliedAt).toLocaleDateString('en-GB', { day:'2-digit', month:'short', year:'numeric' }),
        _real  : true,  // flag: this is a real registration
      });
    }
  });

  // Patch handleApproval to also update EduAuth storage for real accounts
  const _orig = window.handleApproval;
  window.handleApproval = function(id, action) {
    const p = PENDING_PROVIDERS.find(x => x.id === id);
    if (p && p._real) {
      if (action === 'approve') EduAuth.approveProvider(id);
      else EduAuth.rejectProvider(id);
    }
    _orig(id, action);
  };

  // Also merge real approved providers into ALL_PROVIDERS display list
  EduAuth.getProviders().filter(p => p.status === 'approved').forEach(p => {
    if (!ALL_PROVIDERS.find(x => x.reg === p.regNo)) {
      ALL_PROVIDERS.push({ name: p.orgName, type: p.orgType, reg: p.regNo, courses: 0, students: 0, status: 'Approved' });
    }
  });

  // Merge real students into ALL_STUDENTS display list
  EduAuth.getStudents().forEach(s => {
    if (!ALL_STUDENTS.find(x => x.email === s.email)) {
      ALL_STUDENTS.push({ name: s.name, email: s.email, courses: 0, joined: new Date(s.joinedAt).toLocaleDateString('en-GB', { day:'2-digit', month:'short', year:'numeric' }), status: 'Active' });
    }
  });
})();

var _modalProviderId = null;

function viewProvider(name, type, reg, courses, students, status, contact, email, date) {
  _modalProviderId = null;

  document.getElementById('modalProvName').textContent = name;
  document.getElementById('mType').textContent = type;
  document.getElementById('mReg').textContent = reg;
  document.getElementById('mCourses').textContent = courses;
  document.getElementById('mStudents').textContent = students;
  document.getElementById('mContact').textContent = contact;
  document.getElementById('mEmail').textContent = email;
  document.getElementById('mDate').textContent = date;

  document.getElementById('mStatus').innerHTML =
    '<span class="badge badge-amber">Pending</span>';

  document.getElementById('provModal').classList.add('open');
}

function viewPendingProvider(id) {
  var p = PENDING_PROVIDERS.find(function(x){
    return String(x.id) === String(id);
  });

  if (!p) return;

  _modalProviderId = id;

  viewProvider(
    p.name,
    p.type,
    p.reg,
    0,
    0,
    'Pending',
    p.contact,
    p.email,
    p.date
  );
}

function modalApproval(action) {
  if (_modalProviderId === null) return;

  document.getElementById('provModal').classList.remove('open');
  handleApproval(_modalProviderId, action);
}

renderApprovals();
renderProviders();
renderStudents();

// Update live stat counts
const totalApproved = ALL_PROVIDERS.filter(p => p.status === 'Approved').length;
const totalStudents = ALL_STUDENTS.length;
const statProv = document.getElementById('statProviders');
const statStu  = document.getElementById('statStudents');
if (statProv) statProv.textContent = totalApproved || 12;
if (statStu)  statStu.textContent  = totalStudents  >= 1240 ? totalStudents.toLocaleString() : (1240 + totalStudents - (totalStudents <= 7 ? totalStudents : 0)).toLocaleString();
</script>
</body>
</html>
