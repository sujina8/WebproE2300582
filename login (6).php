<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/><meta name="viewport" content="width=device-width,initial-scale=1.0"/>
  <title>My Enrolments – EduSkill</title>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet"/>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
  <link rel="stylesheet" href="../assets/css/shared.css"/>
  <link rel="stylesheet" href="../assets/css/Sujina.css"/>
</head>
<body>
<div class="dash-layout">
  <aside class="sidebar">
    <div class="sidebar-logo"><img src="../assets/images/eduskill-logo.png" alt="EduSkill" style="height:30px;width:30px;object-fit:contain;display:inline-block;vertical-align:middle;margin-right:4px"> My Learning</div>
    <div class="sidebar-label">Main</div>
    <a href="dashboard.php"><i class="fas fa-home"></i> Dashboard</a>
    <div class="sidebar-label">Courses</div>
    <a href="browse.php"><i class="fas fa-compass"></i> Browse Courses</a>
    <a href="enrolled.php" class="active"><i class="fas fa-book-open"></i> My Enrolments</a>
    <a href="learning.php"><i class="fas fa-play-circle"></i> Continue Learning</a>
    <div class="sidebar-label">Account</div>
    <a href="profile.php"><i class="fas fa-user-edit"></i> My Profile</a>
    <a href="receipt.php"><i class="fas fa-receipt"></i> Receipts</a>
    <a href="login.php" class="logout-link" onclick="EduAuth.logout('login.php')"><i class="fas fa-sign-out-alt"></i> Logout</a>
  </aside>
  <main class="dash-main">
    <div class="nav-wrapper" style="position:fixed;top:16px;left:var(--sidebar-w);right:0;transform:none;width:calc(100% - var(--sidebar-w) - 32px);max-width:900px">
      <nav id="navbar" style="border-radius:20px">
        <span class="nav-logo" style="font-size:1rem"><i class="fas fa-book-open" style="color:var(--primary)"></i> My Enrolments</span>
        <a href="login.php" onclick="EduAuth.logout('login.php')" class="btn-outline" style="font-size:.8rem;padding:7px 16px"><i class="fas fa-sign-out-alt"></i> Logout</a>
      </nav>
    </div>
    <div style="margin-top:56px">
      <div class="table-wrap">
        <div class="panel-header" style="padding:18px 22px;border-bottom:1px solid var(--cream-dark);display:flex;justify-content:space-between;align-items:center">
          <h3><i class="fas fa-list-check" style="color:var(--primary);margin-right:8px"></i>Enrolled Courses</h3>
          <a href="browse.php" class="btn-primary" style="font-size:.82rem;padding:9px 18px"><i class="fas fa-plus"></i> Enroll More</a>
        </div>
        <table>
          <thead><tr><th>Course</th><th>Provider</th><th>Enrolled</th><th>Progress</th><th>Status</th><th>Actions</th></tr></thead>
          <tbody>
            <tr>
              <td><strong>Full-Stack Web Development</strong></td>
              <td>TechPro Academy</td><td>02 Jan 2025</td>
              <td><div style="display:flex;align-items:center;gap:8px"><div style="flex:1;height:6px;background:var(--cream-dark);border-radius:3px;overflow:hidden"><div style="height:100%;width:75%;background:linear-gradient(90deg,var(--primary),var(--primary-light));border-radius:3px"></div></div><span style="font-size:.76rem;font-weight:600;color:var(--primary)">75%</span></div></td>
              <td><span class="badge badge-blue">In Progress</span></td>
              <td style="display:flex;gap:6px;flex-wrap:wrap">
                <button class="tbl-btn tbl-default" onclick="window.location.href='learning.php?course=Full-Stack'"><i class="fas fa-play"></i> Continue</button>
                <button class="tbl-btn tbl-blue" onclick="window.location.href='receipt.php?course=Full-Stack+Web+Development&fee=1%2C500&provider=TechPro+Academy'"><i class="fas fa-receipt"></i> Receipt</button>
              </td>
            </tr>
            <tr>
              <td><strong>UI/UX Design Fundamentals</strong></td>
              <td>DesignHub MY</td><td>15 Jan 2025</td>
              <td><div style="display:flex;align-items:center;gap:8px"><div style="flex:1;height:6px;background:var(--cream-dark);border-radius:3px;overflow:hidden"><div style="height:100%;width:40%;background:linear-gradient(90deg,var(--primary),var(--primary-light));border-radius:3px"></div></div><span style="font-size:.76rem;font-weight:600;color:var(--primary)">40%</span></div></td>
              <td><span class="badge badge-blue">In Progress</span></td>
              <td style="display:flex;gap:6px">
                <button class="tbl-btn tbl-default" onclick="window.location.href='learning.php?course=UIUX'"><i class="fas fa-play"></i> Continue</button>
                <button class="tbl-btn tbl-blue" onclick="window.location.href='receipt.php?course=UI%2FUX+Design&fee=1%2C500&provider=DesignHub+MY'"><i class="fas fa-receipt"></i> Receipt</button>
              </td>
            </tr>
            <tr>
              <td><strong>Digital Marketing Mastery</strong></td>
              <td>MarketPro Institute</td><td>10 Dec 2024</td>
              <td><div style="display:flex;align-items:center;gap:8px"><div style="flex:1;height:6px;background:var(--cream-dark);border-radius:3px;overflow:hidden"><div style="height:100%;width:100%;background:#16a34a;border-radius:3px"></div></div><span style="font-size:.76rem;font-weight:600;color:#16a34a">100%</span></div></td>
              <td><span class="badge badge-green">Completed</span></td>
              <td style="display:flex;gap:6px;flex-wrap:wrap">
                <button class="tbl-btn tbl-green" onclick="showToast('Certificate downloaded!')"><i class="fas fa-certificate"></i> Certificate</button>
                <button class="tbl-btn tbl-blue" onclick="window.location.href='receipt.php?course=Digital+Marketing+Mastery&fee=1%2C500&provider=MarketPro'"><i class="fas fa-receipt"></i> Receipt</button>
                <button class="tbl-btn" style="background:#f0f4ff;color:#4f46e5;border:1px solid #c7d2fe" onclick="openReview('Digital Marketing Mastery')"><i class="fas fa-star"></i> Review</button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </main>
</div>
<script src="../assets/js/shared.js"></script>
<script src="../assets/js/auth.js"></script>
<script src="../assets/js/Sujina.js"></script>
<script>requireStudent();
// ── Load real enrolments from PHP when XAMPP is active ──────
(function loadEnrolments() {
  const tbody = document.getElementById('enrolTbody');
  if (!tbody) return;

  fetch('../includes/get_enrolments.php')
    .then(r => r.json())
    .then(data => {
      if (!data.success || !data.enrolments || !data.enrolments.length) return;
      // Replace static rows with live data
      tbody.innerHTML = data.enrolments.map(e => {
        const d    = new Date(e.enrolled_at);
        const date = d.toLocaleDateString('en-MY', {day:'2-digit', month:'short', year:'numeric'});
        const statusBadge = e.status === 'completed'
          ? '<span class="badge badge-green">Completed</span>'
          : '<span class="badge badge-blue">In Progress</span>';
        const actions = e.status === 'completed'
          ? `<button class="tbl-btn tbl-green" onclick="showToast('Certificate downloaded!')"><i class="fas fa-certificate"></i> Certificate</button>`
          : `<button class="tbl-btn tbl-default" onclick="window.location.href='learning.php'"><i class="fas fa-play"></i> Continue</button>`;
        const receiptBtn = e.receipt_no
          ? `<button class="tbl-btn tbl-blue" onclick="window.location.href='receipt.php?course=${encodeURIComponent(e.title)}&fee=${e.amount_paid}&provider=${encodeURIComponent(e.provider_name)}'"><i class="fas fa-receipt"></i> Receipt</button>`
          : '';
        const pct = `<div style="display:flex;align-items:center;gap:8px">
          <div style="flex:1;height:6px;background:var(--cream-dark);border-radius:3px;overflow:hidden">
            <div style="height:100%;width:${e.progress}%;background:linear-gradient(90deg,var(--primary),var(--primary-light));border-radius:3px"></div>
          </div>
          <span style="font-size:.76rem;font-weight:600;color:var(--primary);white-space:nowrap">${e.progress}%</span></div>`;
        return `<tr>
          <td><strong>${e.title}</strong></td>
          <td>${e.provider_name}</td>
          <td>${date}</td>
          <td>${pct}</td>
          <td>${statusBadge}</td>
          <td style="display:flex;gap:6px;flex-wrap:wrap">${actions}${receiptBtn}</td>
        </tr>`;
      }).join('');
    })
    .catch(() => {}); // keep static HTML when XAMPP is off
})();
</script>

<!-- Review Modal (UC5) -->
<div id="reviewModal" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.45);z-index:9999;align-items:center;justify-content:center">
  <div style="background:white;border-radius:20px;padding:32px;max-width:460px;width:90%;position:relative">
    <button onclick="closeReview()" style="position:absolute;top:16px;right:16px;background:none;border:none;font-size:1.2rem;cursor:pointer;color:var(--text-light)"><i class="fas fa-times"></i></button>
    <h3 style="margin:0 0 4px;font-family:'Playfair Display',serif">Write a Review</h3>
    <p id="reviewCourseName" style="font-size:.85rem;color:var(--text-light);margin:0 0 20px"></p>
    <label style="font-size:.85rem;font-weight:600;display:block;margin-bottom:8px">Your Rating</label>
    <div id="starPicker" style="display:flex;gap:6px;margin-bottom:18px;font-size:1.8rem;cursor:pointer">
      <span onclick="setRating(1)" class="rstar">&#9734;</span>
      <span onclick="setRating(2)" class="rstar">&#9734;</span>
      <span onclick="setRating(3)" class="rstar">&#9734;</span>
      <span onclick="setRating(4)" class="rstar">&#9734;</span>
      <span onclick="setRating(5)" class="rstar">&#9734;</span>
    </div>
    <label style="font-size:.85rem;font-weight:600;display:block;margin-bottom:8px">Your Feedback</label>
    <textarea id="reviewText" rows="4" placeholder="Share your experience with this course…" style="width:100%;padding:12px;border-radius:10px;border:1.5px solid rgba(201,123,46,.2);font-family:'DM Sans',sans-serif;font-size:.88rem;resize:none;outline:none;box-sizing:border-box"></textarea>
    <button onclick="submitReview()" style="margin-top:16px;width:100%;background:linear-gradient(135deg,var(--primary),var(--primary-light));color:white;border:none;padding:12px;border-radius:10px;font-family:'DM Sans',sans-serif;font-weight:600;font-size:.92rem;cursor:pointer">
      <i class="fas fa-paper-plane"></i> Submit Review
    </button>
  </div>
</div>
<style>
.rstar{color:#d1d5db;transition:color .15s}
.rstar.active{color:#f59e0b}
</style>
<script>
var _reviewRating = 0;
var _reviewCourse = '';
function openReview(course) {
  _reviewCourse = course;
  _reviewRating = 0;
  document.getElementById('reviewCourseName').textContent = course;
  document.getElementById('reviewText').value = '';
  document.querySelectorAll('.rstar').forEach(s => s.classList.remove('active'));
  document.getElementById('reviewModal').style.display = 'flex';
}
function closeReview() { document.getElementById('reviewModal').style.display = 'none'; }
function setRating(n) {
  _reviewRating = n;
  document.querySelectorAll('.rstar').forEach((s,i) => {
    s.innerHTML = i < n ? '&#9733;' : '&#9734;';
    i < n ? s.classList.add('active') : s.classList.remove('active');
  });
}
function submitReview() {
  if (!_reviewRating) { showToast('Please select a star rating.', false); return; }
  var txt = document.getElementById('reviewText').value.trim();
  if (!txt) { showToast('Please write your feedback.', false); return; }
  // Save to localStorage
  var reviews = JSON.parse(localStorage.getItem('edu_reviews')||'[]');
  reviews.push({ course: _reviewCourse, rating: _reviewRating, text: txt, date: new Date().toISOString(),
    student: localStorage.getItem('edu_name')||'Student' });
  localStorage.setItem('edu_reviews', JSON.stringify(reviews));
  closeReview();
  showToast('Review submitted! Thank you for your feedback.');
}
</script>
</body>
</html>
