<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/><meta name="viewport" content="width=device-width,initial-scale=1.0"/>
  <title>Course Enrollment – EduSkill</title>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet"/>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
  <link rel="stylesheet" href="../assets/css/shared.css"/>
  <link rel="stylesheet" href="../assets/css/Sujina.css"/>
</head>
<body>
<div class="nav-wrapper" style="top:12px">
  <nav id="navbar">
    <a href="dashboard.php" class="nav-logo"><div class="nav-logo-icon"><img src="../assets/images/eduskill-logo.png" alt="EduSkill" style="width:30px;height:30px;object-fit:contain;border-radius:50%;display:block"></div>EduSkill</a>
    <ul class="nav-links">
      <li><a href="browse.php">Browse</a></li>
      <li><a href="enrolled.php">My Courses</a></li>
    </ul>
    <a href="login.php" onclick="EduAuth.logout('login.php')" class="btn-outline" style="font-size:.82rem;padding:8px 18px"><i class="fas fa-sign-out-alt"></i> Logout</a>
    <button class="nav-hamburger" id="hamburger"><span></span><span></span><span></span></button>
  </nav>
</div>

<div class="enrol-hero">
  <div class="enrol-inner">
    <!-- Left: Course info -->
    <div>
      <div style="font-size:.8rem;color:var(--text-light);margin-bottom:14px">
        <a href="browse.php" style="color:var(--primary)">Courses</a> &rsaquo;
        <span id="heroCat">Technology</span> &rsaquo;
        <span id="heroTitle">Loading…</span>
      </div>
      <span id="heroTag" style="display:inline-block;background:rgba(201,123,46,.1);color:var(--primary);font-size:.72rem;font-weight:700;padding:4px 12px;border-radius:50px;margin-bottom:12px;letter-spacing:.06em;text-transform:uppercase">Technology</span>
      <h1 id="heroH1" style="font-family:'Playfair Display',serif;font-size:clamp(1.6rem,3vw,2.2rem);margin-bottom:14px;line-height:1.25">Loading course…</h1>
      <p id="heroDesc" style="color:var(--text-mid);font-size:.97rem;line-height:1.78;margin-bottom:20px;max-width:560px"></p>
      <div style="display:flex;gap:20px;flex-wrap:wrap;margin-bottom:18px;font-size:.85rem;color:var(--text-mid)">
        <span><i class="fas fa-star" style="color:#f59e0b"></i> <strong id="heroRating">4.9</strong> <span id="heroReviews" style="color:var(--text-light)"></span></span>
        <span><i class="fas fa-users"></i> <span id="heroEnrolled">0</span> enrolled</span>
        <span><i class="fas fa-clock"></i> <span id="heroDur">8 Weeks</span></span>
        <span><i class="fas fa-signal"></i> <span id="heroLevel">Beginner</span></span>
      </div>
      <div style="display:flex;align-items:center;gap:10px">
        <div id="provAvatar" style="width:36px;height:36px;border-radius:50%;background:linear-gradient(135deg,var(--primary),var(--primary-light));display:flex;align-items:center;justify-content:center;color:white;font-weight:700;font-size:.85rem;flex-shrink:0">TP</div>
        <div>
          <div id="provName" style="font-size:.88rem;font-weight:600">TechPro Academy</div>
          <div style="font-size:.76rem;color:var(--text-light)">Approved Training Provider</div>
        </div>
      </div>

      <!-- Course tabs -->
      <div style="margin-top:32px">
        <div class="tab-nav" style="background:white;border-radius:50px;padding:5px;border:1px solid rgba(201,123,46,.12);width:fit-content;display:flex;gap:4px;margin-bottom:20px">
          <button class="tab-btn active" onclick="showCTab('overview',this)">Overview</button>
          <button class="tab-btn" onclick="showCTab('curriculum',this)">Curriculum</button>
          <button class="tab-btn" onclick="showCTab('reviews',this)">Reviews</button>
        </div>

        <!-- Overview -->
        <div class="tab-pane active" id="ctab-overview">
          <div class="form-card">
            <h3>What You Will Learn</h3>
            <ul id="outcomeList" style="list-style:none;padding:0;margin:0"></ul>
          </div>
        </div>

        <!-- Curriculum -->
        <div class="tab-pane" id="ctab-curriculum">
          <div class="form-card">
            <h3 id="curriculumTitle">Curriculum</h3>
            <div id="curriculumList"></div>
          </div>
        </div>

        <!-- Reviews -->
        <div class="tab-pane" id="ctab-reviews">
          <div class="form-card">
            <h3>Student Reviews</h3>
            <div id="reviewList"></div>
          </div>
        </div>
      </div>
    </div>

    <!-- Right: Enrol card -->
    <div class="enrol-card">
      <div class="enrol-img" id="enrolImg" style="background:linear-gradient(135deg,#667eea,#764ba2)">
        <i id="enrolIcon" class="fas fa-book"></i>
      </div>
      <div class="enrol-price">RM <span id="cardPrice">1,500</span>.00 <span>/ person</span></div>
      <button class="enrol-btn" onclick="document.getElementById('payModal').classList.add('open')">
        <i class="fas fa-lock"></i>&nbsp;Enroll Now – Secure Payment
      </button>
      <p style="font-size:.76rem;color:var(--text-light);text-align:center">30-day money-back guarantee</p>
      <div class="includes">
        <h4>This course includes</h4>
        <div class="inc-item"><i class="fas fa-check-circle"></i> <span id="incHours">40+ hours</span> on-demand content</div>
        <div class="inc-item"><i class="fas fa-check-circle"></i> <span id="incProjects">Hands-on projects</span></div>
        <div class="inc-item"><i class="fas fa-check-circle"></i> Downloadable resources</div>
        <div class="inc-item"><i class="fas fa-check-circle"></i> Certificate of completion</div>
        <div class="inc-item"><i class="fas fa-check-circle"></i> Lifetime access</div>
        <div class="inc-item"><i class="fas fa-check-circle"></i> Official enrolment receipt</div>
      </div>
    </div>
  </div>
</div>

<!-- Payment modal -->
<div class="modal-overlay" id="payModal">
  <div class="modal">
    <h3>Complete Your Enrolment</h3>
    <p id="payTitle" style="font-size:.86rem;color:var(--text-light);margin-bottom:20px"></p>
    <p style="font-size:.82rem;font-weight:600;color:var(--text-mid);margin-bottom:10px">Select Payment Method</p>
    <div class="pm-grid">
      <button class="pm-btn active" onclick="selectPayMethod(this)"><i class="fas fa-university"></i>Online Banking</button>
      <button class="pm-btn" onclick="selectPayMethod(this)"><i class="fas fa-credit-card"></i>Credit / Debit</button>
      <button class="pm-btn" onclick="selectPayMethod(this)"><i class="fas fa-mobile-alt"></i>e-Wallet</button>
      <button class="pm-btn" onclick="selectPayMethod(this)"><i class="fas fa-qrcode"></i>QR Pay</button>
    </div>
    <div class="fg"><label>Account / Cardholder Name</label><input type="text" id="payName" placeholder="Full name on account"/></div>
    <div class="fg"><label>Reference / Last 4 Digits</label><input type="text" id="payRef" placeholder="xxxx" maxlength="4"/></div>
    <div class="modal-footer">
      <button class="btn-outline" onclick="document.getElementById('payModal').classList.remove('open')">Cancel</button>
      <button class="btn-primary" id="payBtn" onclick="doPayment()"><i class="fas fa-lock"></i> Pay RM <span id="payBtnAmt">1,500</span></button>
    </div>
  </div>
</div>

<div class="toast" id="toast"><i id="toastIcon" class="fas fa-check-circle" style="color:#4ade80"></i><span id="toastMsg"></span></div>

<script src="../assets/js/shared.js"></script>
<script src="../assets/js/auth.js"></script>
<script src="../assets/js/Sujina.js"></script>
<script>
requireStudent();
initNavScroll();

/* ── Load course from URL id ── */
const params   = new URLSearchParams(window.location.search);
const courseId = parseInt(params.get('id')) || 1;
const course   = COURSE_DATA.find(c => c.id === courseId) || COURSE_DATA[0];
const detail   = COURSE_DETAILS[courseId] || COURSE_DETAILS[1];

/* ── Populate header ── */
document.title = course.title + ' – Enroll – EduSkill';
document.getElementById('heroCat').textContent      = course.cat;
document.getElementById('heroTitle').textContent    = course.title;
document.getElementById('heroTag').textContent      = course.cat;
document.getElementById('heroH1').textContent       = course.title;
document.getElementById('heroDesc').textContent     = course.desc;
document.getElementById('heroRating').textContent   = course.rating;
document.getElementById('heroReviews').textContent  = '(' + course.reviews + ' reviews)';
document.getElementById('heroEnrolled').textContent = course.reviews; // use reviews count as enrolled proxy
document.getElementById('heroDur').textContent      = course.dur;
document.getElementById('heroLevel').textContent    = course.level;
document.getElementById('provName').textContent     = course.provider;

/* ── Provider avatar initials ── */
const words = course.provider.split(' ');
const initials = words.length >= 2 ? words[0][0] + words[1][0] : words[0].slice(0,2);
document.getElementById('provAvatar').textContent = initials.toUpperCase();

/* ── Enrol card ── */
document.getElementById('enrolImg').style.background = detail.grad;
document.getElementById('enrolIcon').className = 'fas ' + detail.icon;
document.getElementById('cardPrice').textContent    = course.price.toLocaleString();
document.getElementById('payTitle').textContent     = course.title + ' · RM ' + course.price.toLocaleString() + '.00';
document.getElementById('payBtnAmt').textContent    = course.price.toLocaleString();
document.getElementById('incHours').textContent     = detail.hours;
document.getElementById('incProjects').textContent  = detail.projects;

/* ── Outcomes ── */
document.getElementById('outcomeList').innerHTML = detail.outcomes.map(o =>
  `<li style="display:flex;gap:10px;margin-bottom:9px;font-size:.88rem;color:var(--text-mid)">
    <i class="fas fa-check" style="color:var(--primary);margin-top:3px;flex-shrink:0"></i>${o}
  </li>`).join('');

/* ── Curriculum ── */
document.getElementById('curriculumTitle').textContent = 'Curriculum (' + course.dur + ')';
document.getElementById('curriculumList').innerHTML = detail.curriculum.map((row, i) =>
  `<div style="padding:12px 0;${i < detail.curriculum.length-1 ? 'border-bottom:1px solid var(--cream-dark);' : ''}display:flex;justify-content:space-between">
    <span style="font-size:.86rem;color:var(--text-mid)"><strong>${row[0]}:</strong> ${row[1]}</span>
    <span style="font-size:.76rem;color:var(--text-light)">${row[2]}</span>
  </div>`).join('');

/* ── Reviews ── */
document.getElementById('reviewList').innerHTML = detail.reviews.map((r, i) =>
  `<div style="padding:16px 0;${i < detail.reviews.length-1 ? 'border-bottom:1px solid var(--cream-dark);' : ''}">
    <div style="display:flex;align-items:center;gap:10px;margin-bottom:8px">
      <div style="width:34px;height:34px;border-radius:50%;background:linear-gradient(135deg,var(--primary),var(--primary-light));display:flex;align-items:center;justify-content:center;color:white;font-size:.8rem;font-weight:700;flex-shrink:0">${r.init}</div>
      <div>
        <div style="font-size:.88rem;font-weight:600">${r.name}</div>
        <div style="color:#f59e0b;font-size:.8rem">${'★'.repeat(r.stars)}${'☆'.repeat(5-r.stars)}</div>
      </div>
    </div>
    <p style="font-size:.82rem;color:var(--text-mid)">${r.text}</p>
  </div>`).join('');

/* ── Tab switcher ── */
function showCTab(name, btn) {
  document.querySelectorAll('.tab-pane[id^="ctab-"]').forEach(p => p.classList.remove('active'));
  document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
  document.getElementById('ctab-' + name).classList.add('active');
  btn.classList.add('active');
}

/* ── Payment ── */
function doPayment() {
  processPayment(course.title, course.price.toLocaleString(), course.provider, courseId);
}
</script>
</body>
</html>
