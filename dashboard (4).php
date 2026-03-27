<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/><meta name="viewport" content="width=device-width,initial-scale=1.0"/>
  <title>Browse Courses – EduSkill</title>
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
    <a href="browse.php" class="active"><i class="fas fa-compass"></i> Browse Courses</a>
    <a href="enrolled.php"><i class="fas fa-book-open"></i> My Enrolments</a>
    <a href="learning.php"><i class="fas fa-play-circle"></i> Continue Learning</a>
    <div class="sidebar-label">Account</div>
    <a href="profile.php"><i class="fas fa-user-edit"></i> My Profile</a>
    <a href="receipt.php"><i class="fas fa-receipt"></i> Receipts</a>
    <a href="login.php" class="logout-link" onclick="EduAuth.logout('login.php')"><i class="fas fa-sign-out-alt"></i> Logout</a>
  </aside>
  <main class="dash-main">
    <div class="nav-wrapper" style="position:fixed;top:16px;left:var(--sidebar-w);right:0;transform:none;width:calc(100% - var(--sidebar-w) - 32px);max-width:900px">
      <nav id="navbar" style="border-radius:20px">
        <span class="nav-logo" style="font-size:1rem"><i class="fas fa-compass" style="color:var(--primary)"></i> Browse Courses</span>
        <a href="login.php" onclick="EduAuth.logout('login.php')" class="btn-outline" style="font-size:.8rem;padding:7px 16px"><i class="fas fa-sign-out-alt"></i> Logout</a>
      </nav>
    </div>
    <div style="margin-top:56px">
      <div style="margin-bottom:24px">
        <div class="filter-bar">
          <div class="filter-chip active" onclick="setCourseCategory('all',this)">All</div>
          <div class="filter-chip" onclick="setCourseCategory('Technology',this)">Technology</div>
          <div class="filter-chip" onclick="setCourseCategory('Design',this)">Design</div>
          <div class="filter-chip" onclick="setCourseCategory('Business',this)">Business</div>
          <div class="filter-chip" onclick="setCourseCategory('Finance',this)">Finance</div>
          <div class="filter-chip" onclick="setCourseCategory('Healthcare',this)">Healthcare</div>
          <select id="sortSel" onchange="renderCourseGrid()" style="padding:8px 14px;border-radius:50px;border:1.5px solid rgba(201,123,46,.2);background:white;font-family:'DM Sans',sans-serif;font-size:.85rem;color:var(--text-mid);outline:none">
            <option value="">Sort: Featured</option>
            <option value="price-asc">Price: Low to High</option>
            <option value="price-desc">Price: High to Low</option>
            <option value="rating">Highest Rated</option>
          </select>
          <input type="text" id="searchInput" placeholder="Search…" oninput="renderCourseGrid()" style="padding:8px 16px;border-radius:50px;border:1.5px solid rgba(201,123,46,.2);background:white;font-family:'DM Sans',sans-serif;font-size:.85rem;outline:none;width:180px"/>
          <span class="results-count" id="resCount"></span>
        </div>
      </div>
      <div class="courses-grid" id="courseGrid"></div>
    </div>
  </main>
</div>
<script src="../assets/js/shared.js"></script>
<script src="../assets/js/auth.js"></script>
<script src="../assets/js/Sujina.js"></script>
<script>
requireStudent();
renderCourseGrid();
function goEnroll(id,title){window.location.href='enroll.php?id='+id+'&title='+encodeURIComponent(title);}

// ── Load live courses from PHP when XAMPP is active ─────────
(function loadLiveCourses() {
  fetch('../includes/get_courses.php')
    .then(r => r.json())
    .then(data => {
      if (!data.success || !data.courses || !data.courses.length) return;
      // Map category to image
      const catImg = {
        'Technology': '../assets/images/technology.jpg',
        'Design'    : '../assets/images/design.jpg',
        'Business'  : '../assets/images/business.jpg',
        'Finance'   : '../assets/images/finance.jpg',
        'Healthcare': '../assets/images/healthcare.jpg',
      };
      // Override COURSE_DATA with live DB data then re-render
      COURSE_DATA.length = 0;
      data.courses.forEach(c => {
        COURSE_DATA.push({
          id      : c.id,
          title   : c.title,
          provider: c.provider_name,
          cat     : c.category,
          img     : catImg[c.category] || '../assets/images/technology.jpg',
          level   : c.level,
          dur     : c.duration,
          price   : parseFloat(c.price),
          rating  : parseFloat(c.avg_rating) || 4.5,
          reviews : parseInt(c.enrolled_count) || 0,
          desc    : c.description || 'A certified training course.'
        });
      });
      renderCourseGrid();
    })
    .catch(() => {}); // keep COURSE_DATA fallback when XAMPP off
})();
</script>
</body>
</html>
