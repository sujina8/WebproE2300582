<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/><meta name="viewport" content="width=device-width,initial-scale=1.0"/>
  <title>Enrolment Management – EduSkill</title>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet"/>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
  <link rel="stylesheet" href="../assets/css/shared.css"/>
  <link rel="stylesheet" href="../assets/css/Sailabee.css"/>
</head>
<body>
<div class="dash-layout">
  <aside class="sidebar">
    <div class="sidebar-logo"><i class="fas fa-chalkboard-teacher"></i> Provider</div>
    <div class="sidebar-label">Main</div>
    <a href="dashboard.php"><i class="fas fa-home"></i> Dashboard</a>
    <div class="sidebar-label">Teaching</div>
    <a href="courses.php"><i class="fas fa-book"></i> My Courses</a>
    <a href="enrolments.php" class="active"><i class="fas fa-users"></i> Student Enrolments</a>
    <a href="materials.php"><i class="fas fa-folder-open"></i> Teaching Materials</a>
    <a href="teaching.php"><i class="fas fa-chalkboard"></i> Course Teaching</a>
    <div class="sidebar-label">Reports</div>
    <a href="dashboard.php#reports"><i class="fas fa-chart-bar"></i> Reports</a>
    <div class="sidebar-label">Account</div>
    <a href="profile.php"><i class="fas fa-building"></i> Organisation</a>
    <a href="login.php" class="logout-link" onclick="EduAuth.logout('login.php')"><i class="fas fa-sign-out-alt"></i> Logout</a>
  </aside>
  <main class="dash-main">
    <div class="nav-wrapper" style="position:fixed;top:16px;left:var(--sidebar-w);right:0;transform:none;width:calc(100% - var(--sidebar-w) - 32px);max-width:900px">
      <nav id="navbar" style="border-radius:20px">
        <span class="nav-logo" style="font-size:1rem;color:#5b6cf6"><i class="fas fa-users" style="color:#5b6cf6;margin-right:6px"></i>Student Enrolments</span>
        <div style="display:flex;align-items:center;gap:12px">
          <span id="navName" style="font-size:.85rem;color:var(--text-mid)"></span>
          <a href="login.php" onclick="EduAuth.logout('login.php')" class="btn-outline" style="font-size:.8rem;padding:7px 16px;border-color:#5b6cf6;color:#5b6cf6"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </div>
      </nav>
    </div>

    <div style="margin-top:56px">
      <!-- Summary stats -->
      <div class="stat-grid" style="margin-bottom:24px">
        <div class="stat-box"><div class="sb-icon"><i class="fas fa-users"></i></div><div class="sb-val">52</div><div class="sb-label">Total Students</div></div>
        <div class="stat-box"><div class="sb-icon amber"><i class="fas fa-book-open"></i></div><div class="sb-val">3</div><div class="sb-label">Active Courses</div></div>
        <div class="stat-box"><div class="sb-icon green"><i class="fas fa-check-circle"></i></div><div class="sb-val">14</div><div class="sb-label">Completions</div></div>
        <div class="stat-box"><div class="sb-icon"><i class="fas fa-coins"></i></div><div class="sb-val">RM 78k</div><div class="sb-label">Total Revenue</div></div>
      </div>

      <!-- Filter bar -->
      <div class="table-wrap">
        <div class="table-header">
          <h3><i class="fas fa-list" style="color:#5b6cf6;margin-right:8px"></i>All Enrolments</h3>
          <div style="display:flex;gap:10px;flex-wrap:wrap">
            <select id="courseFilter" onchange="filterEnrolments()" style="padding:8px 12px;border-radius:8px;border:1.5px solid rgba(91,108,246,.2);font-family:'DM Sans',sans-serif;font-size:.83rem;outline:none">
              <option value="">All Courses</option>
              <option>Full-Stack Web Development</option>
              <option>Python for Data Science</option>
              <option>Mobile App Development</option>
            </select>
            <select id="statusFilter" onchange="filterEnrolments()" style="padding:8px 12px;border-radius:8px;border:1.5px solid rgba(91,108,246,.2);font-family:'DM Sans',sans-serif;font-size:.83rem;outline:none">
              <option value="">All Status</option>
              <option>Active</option>
              <option>Completed</option>
            </select>
            <input type="text" id="studentSearch" placeholder="Search student…" oninput="filterEnrolments()" style="padding:8px 12px;border-radius:8px;border:1.5px solid rgba(91,108,246,.2);font-family:'DM Sans',sans-serif;font-size:.83rem;outline:none;width:160px"/>
            <button class="btn-primary" style="background:#5b6cf6;box-shadow:none;font-size:.82rem;padding:9px 16px" onclick="exportReport()"><i class="fas fa-download"></i> Export CSV</button>
          </div>
        </div>
        <table>
          <thead>
            <tr>
              <th>Student Name</th>
              <th>Course</th>
              <th>Enrolled Date</th>
              <th>Progress</th>
              <th>Status</th>
              <th>Payment</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody id="enrolTbody"></tbody>
        </table>
      </div>

      <!-- Monthly chart -->
      <div class="form-card">
        <h3><i class="fas fa-chart-bar" style="color:#5b6cf6;margin-right:8px"></i>Monthly Enrolments – 2025</h3>
        <p style="font-size:.85rem;color:var(--text-light);margin-bottom:18px">New student enrolments across all your courses per month.</p>
        <div class="chart-wrap" id="provChart"></div>
        <div style="display:flex;gap:10px;margin-top:18px;flex-wrap:wrap">
          <button class="btn-primary" style="background:#5b6cf6;box-shadow:none;font-size:.85rem" onclick="showToast('Monthly report exported.')"><i class="fas fa-download"></i> Export Monthly Report</button>
          <button class="btn-outline" style="border-color:#5b6cf6;color:#5b6cf6;font-size:.85rem" onclick="showToast('Yearly report exported.')"><i class="fas fa-download"></i> Export Yearly Report</button>
        </div>
      </div>
    </div>
  </main>
</div>

<script src="../assets/js/shared.js"></script>
<script src="../assets/js/auth.js"></script>
<script src="../assets/js/Sailabee.js"></script>
<script>
requireProvider();
document.getElementById('navName').textContent = EduAuth.name() || '';

renderEnrolments('enrolTbody');
renderProviderChart();

function filterEnrolments() {
  const courseF  = document.getElementById('courseFilter').value.toLowerCase();
  const statusF  = document.getElementById('statusFilter').value.toLowerCase();
  const searchF  = document.getElementById('studentSearch').value.toLowerCase();
  const rows = document.querySelectorAll('#enrolTbody tr');
  rows.forEach(r => {
    const txt = r.textContent.toLowerCase();
    const show = (!courseF || txt.includes(courseF)) &&
                 (!statusF || txt.includes(statusF)) &&
                 (!searchF || txt.includes(searchF));
    r.style.display = show ? '' : 'none';
  });
}

function exportReport() {
  showToast('Enrolment data exported as CSV.');
}
</script>
</body>
</html>
