/* 
   EduSkill – assets/js/Sujina.js
   STUDENT JavaScript utilities
   Author: Sujina
   */

/*Auth guard: call on every student page*/
function requireStudent() {
  if (localStorage.getItem('edu_role') !== 'student') {
    window.location.href = '../student/login.html';
    return false;
  }
  return true;
}

/*  Set welcome text in dashboard */
function setStudentWelcome(nameElId, avatarElId) {
  const name = localStorage.getItem('edu_name') || 'Student';
  const el = document.getElementById(nameElId);
  const av = document.getElementById(avatarElId);
  if (el) el.textContent = 'Welcome back, ' + name + '!';
  if (av) av.textContent = name.split(' ').map(w => w[0]).join('').slice(0, 2).toUpperCase();
}

/*Animate progress bars*/
function animateProgressBars() {
  setTimeout(() => {
    document.querySelectorAll('.prog-fill[data-w]').forEach(el => {
      el.style.width = el.dataset.w + '%';
    });
  }, 400);
}

/*Course filter*/
const COURSE_DATA = [
  { id:1, title:'Full-Stack Web Development',   provider:'TechPro Academy',    cat:'Technology', img:'../assets/images/technology.jpg', level:'Beginner',     dur:'8 Weeks',  price:1500, rating:4.9, reviews:128, desc:'Master HTML, CSS, JavaScript, PHP & MySQL to build complete web applications.' },
  { id:2, title:'UI/UX Design Fundamentals',    provider:'DesignHub',          cat:'Design',     img:'../assets/images/design.jpg',     level:'Intermediate', dur:'6 Weeks',  price:1500, rating:4.8, reviews:96,  desc:'Learn user research, wireframing, and prototyping for great digital experiences.' },
  { id:3, title:'Digital Marketing Mastery',    provider:'MarketPro Institute', cat:'Business',   img:'../assets/images/business.jpg',   level:'Beginner',     dur:'4 Weeks',  price:1500, rating:4.6, reviews:74,  desc:'SEO, social media, and paid ads – build a complete digital marketing skill set.' },
  { id:4, title:'Python for Data Science',      provider:'TechPro Academy',    cat:'Technology', img:'../assets/images/technology.jpg', level:'Intermediate', dur:'10 Weeks', price:1800, rating:4.9, reviews:201, desc:'NumPy, pandas, and machine learning fundamentals for aspiring data scientists.' },
  { id:5, title:'Financial Accounting Basics',  provider:'FinanceLearn',       cat:'Finance',    img:'../assets/images/finance.jpg',    level:'Beginner',     dur:'5 Weeks',  price:1200, rating:4.5, reviews:55,  desc:'Bookkeeping, financial statements, and accounting principles from scratch.' },
  { id:6, title:'Mobile App Development',       provider:'AppMakers Academy',  cat:'Technology', img:'../assets/images/technology.jpg', level:'Intermediate', dur:'8 Weeks',  price:2000, rating:4.7, reviews:88,  desc:'Build cross-platform mobile apps with React Native and Flutter.' },
  { id:7, title:'Graphic Design Essentials',    provider:'DesignHub',          cat:'Design',     img:'../assets/images/design.jpg',     level:'Beginner',     dur:'4 Weeks',  price:950,  rating:4.6, reviews:64,  desc:'Photoshop, Illustrator, and Canva mastery for professional visual design.' },
  { id:8, title:'Business Communication',       provider:'BizSkill Centre',    cat:'Business',   img:'../assets/images/business.jpg',   level:'Beginner',     dur:'3 Weeks',  price:800,  rating:4.4, reviews:42,  desc:'Professional writing, presentation, and workplace communication skills.' },
  { id:9, title:'First Aid & CPR Certification',provider:'HealthPro Training', cat:'Healthcare', img:'../assets/images/healthcare.jpg', level:'Beginner',     dur:'2 Days',   price:350,  rating:4.8, reviews:310, desc:'Government-recognised First Aid and CPR certification course.' },
];

let _currentCat = 'all';

function setCourseCategory(cat, el) {
  _currentCat = cat;
  document.querySelectorAll('.filter-chip').forEach(c => c.classList.remove('active'));
  if (el) el.classList.add('active');
  renderCourseGrid();
}

function starsHtml(r) {
  const full = Math.floor(r), empty = 5 - full;
  return '★'.repeat(full) + '☆'.repeat(empty);
}

function renderCourseGrid(gridId, searchId, sortId) {
  const gId = gridId || 'courseGrid';
  const sId = searchId || 'searchInput';
  const soId = sortId || 'sortSel';
  const grid = document.getElementById(gId);
  if (!grid) return;

  const q    = (document.getElementById(sId) || {}).value?.toLowerCase() || '';
  const sort = (document.getElementById(soId) || {}).value || '';

  let data = COURSE_DATA.filter(c => {
    const matchCat = _currentCat === 'all' || c.cat === _currentCat;
    const matchQ   = !q || c.title.toLowerCase().includes(q) || c.provider.toLowerCase().includes(q);
    return matchCat && matchQ;
  });
  if (sort === 'price-asc')  data.sort((a,b) => a.price - b.price);
  if (sort === 'price-desc') data.sort((a,b) => b.price - a.price);
  if (sort === 'rating')     data.sort((a,b) => b.rating - a.rating);

  const rc = document.getElementById('resCount');
  if (rc) rc.textContent = `${data.length} course${data.length !== 1 ? 's' : ''} found`;

  if (!data.length) {
    grid.innerHTML = '<div class="no-results"><i class="fas fa-search"></i>No courses found.</div>';
    return;
  }

  grid.innerHTML = data.map(c => `
    <div class="course-card">
      <div class="c-img">
        <div class="c-img-bg" style="background:none;padding:0">
          <img src="${c.img}" alt="${c.cat}" style="width:100%;height:100%;object-fit:cover"/>
        </div>
        <span class="c-badge">${c.cat}</span>
      </div>
      <div class="c-body">
        <div class="c-meta"><span><i class="fas fa-clock"></i> ${c.dur}</span><span><i class="fas fa-signal"></i> ${c.level}</span></div>
        <h3>${c.title}</h3>
        <div class="c-provider"><i class="fas fa-building" style="color:var(--primary-light);margin-right:4px"></i>${c.provider}</div>
        <p>${c.desc}</p>
        <div class="c-footer">
          <div>
            <div class="c-stars">${starsHtml(c.rating)} <span style="color:#9a8a6a;font-size:.72rem">(${c.reviews})</span></div>
            <div class="c-price">RM ${c.price.toLocaleString()}.00</div>
          </div>
          <button class="btn-enroll" onclick="goEnroll(${c.id},'${c.title.replace(/'/g, "\\'")}')">Enroll Now</button>
        </div>
      </div>
    </div>`).join('');
}

function goEnroll(id, title) {
  window.location.href = 'enroll.html?id=' + id + '&title=' + encodeURIComponent(title);
}

/*Course extra details (icon, gradient, outcomes, curriculum)*/
const COURSE_DETAILS = {
  1: {
    icon:'fa-code', grad:'linear-gradient(135deg,#667eea,#764ba2)',
    outcomes:['Build responsive websites with HTML5 and CSS3','Write dynamic JavaScript (ES6+) code','Develop server-side applications using PHP','Design and query MySQL databases','Deploy a complete web application to a live server'],
    curriculum:[['Week 1','HTML5 Fundamentals','6 hrs'],['Week 2','CSS3 Layouts – Flexbox & Grid','7 hrs'],['Week 3','JavaScript Basics & DOM','8 hrs'],['Week 4','Advanced JS – ES6, Fetch API','8 hrs'],['Week 5','PHP Fundamentals','7 hrs'],['Week 6','MySQL Database Design','7 hrs'],['Week 7','Full-Stack Integration','7 hrs'],['Week 8','Deployment & Git','6 hrs']],
    hours:'56 hours', projects:'12 hands-on projects',
    reviews:[{init:'AF',name:'Ahmad Faris',stars:5,text:'Best course I\'ve taken. Clear explanations and genuinely challenging projects. Got my first job offer after completing this!'},
             {init:'RK',name:'Rajesh Kumar',stars:5,text:'From zero coding to building a full CRUD app in 8 weeks. Highly recommend for beginners!'}]
  },
  2: {
    icon:'fa-pencil-ruler', grad:'linear-gradient(135deg,#f093fb,#f5576c)',
    outcomes:['Conduct user research and usability testing','Create wireframes and interactive prototypes','Apply Figma to design real product interfaces','Understand UX heuristics and accessibility','Build a professional UX design portfolio'],
    curriculum:[['Week 1','Design Thinking & User Research','6 hrs'],['Week 2','Information Architecture & Flows','6 hrs'],['Week 3','Wireframing with Figma','7 hrs'],['Week 4','Visual Design Principles','7 hrs'],['Week 5','Prototyping & Micro-interactions','7 hrs'],['Week 6','Usability Testing & Iteration','6 hrs']],
    hours:'39 hours', projects:'8 portfolio projects',
    reviews:[{init:'SN',name:'Siti Nabilah',stars:5,text:'Transformed my design thinking completely. The Figma walkthroughs are incredibly detailed.'},
             {init:'PM',name:'Priya Menon',stars:4,text:'Great course for anyone transitioning into tech. Practical and industry-relevant.'}]
  },
  3: {
    icon:'fa-bullhorn', grad:'linear-gradient(135deg,#4facfe,#00f2fe)',
    outcomes:['Plan and execute SEO strategies','Run targeted paid advertising campaigns','Grow and manage social media channels','Measure ROI with Google Analytics','Build and automate email marketing funnels'],
    curriculum:[['Week 1','Digital Marketing Foundations','5 hrs'],['Week 2','SEO – On-page & Off-page','6 hrs'],['Week 3','Google Ads & Meta Ads','7 hrs'],['Week 4','Analytics, KPIs & Strategy','6 hrs']],
    hours:'24 hours', projects:'5 live campaigns',
    reviews:[{init:'LW',name:'Lee Wei Hong',stars:5,text:'Immediately applied the SEO techniques and saw traffic double in two weeks. Excellent ROI.'},
             {init:'NA',name:'Nur Aisyah',stars:4,text:'Very practical. The ads section alone is worth the course fee.'}]
  },
  4: {
    icon:'fa-python', grad:'linear-gradient(135deg,#43e97b,#38f9d7)',
    outcomes:['Manipulate data with NumPy and pandas','Create visualisations with Matplotlib and Seaborn','Build machine learning models with scikit-learn','Work with real datasets in Jupyter notebooks','Apply statistics for data-driven decisions'],
    curriculum:[['Week 1','Python Refresher & Jupyter','6 hrs'],['Week 2','NumPy & Data Structures','7 hrs'],['Week 3','Pandas – Data Wrangling','8 hrs'],['Week 4','Data Visualisation','7 hrs'],['Week 5','Statistics for DS','8 hrs'],['Week 6','Machine Learning Basics','8 hrs'],['Week 7','Model Evaluation & Tuning','7 hrs'],['Week 8','Capstone – EDA Project','6 hrs'],['Week 9','Deep Learning Intro','7 hrs'],['Week 10','Deployment & Pipelines','5 hrs']],
    hours:'69 hours', projects:'10 data projects',
    reviews:[{init:'RK',name:'Rajesh Kumar',stars:5,text:'Landed a data analyst role after finishing this. The machine learning modules are top-notch.'},
             {init:'DL',name:'David Lim',stars:5,text:'Best investment I made this year. Detailed, practical, and the notebooks are reusable!'}]
  },
  5: {
    icon:'fa-chart-line', grad:'linear-gradient(135deg,#f6d365,#fda085)',
    outcomes:['Record business transactions accurately','Prepare income statements and balance sheets','Apply double-entry bookkeeping principles','Understand basic tax and compliance concepts','Use accounting software fundamentals'],
    curriculum:[['Week 1','Accounting Equation & Concepts','5 hrs'],['Week 2','Double-Entry Bookkeeping','5 hrs'],['Week 3','Financial Statements','6 hrs'],['Week 4','Accounts Receivable & Payable','5 hrs'],['Week 5','Basic Tax & Compliance','5 hrs']],
    hours:'26 hours', projects:'6 case studies',
    reviews:[{init:'AF',name:'Ahmad Faris',stars:5,text:'Perfect for small business owners. Explained everything without the jargon.'},
             {init:'PM',name:'Priya Menon',stars:4,text:'Helped me understand our company\'s financials. Very practical content.'}]
  },
  6: {
    icon:'fa-mobile-alt', grad:'linear-gradient(135deg,#a18cd1,#fbc2eb)',
    outcomes:['Build iOS and Android apps from a single codebase','Use React Native components and hooks','Integrate REST APIs into mobile apps','Implement navigation and state management','Publish apps to App Store and Play Store'],
    curriculum:[['Week 1','React Native Setup & Fundamentals','6 hrs'],['Week 2','Components, Props & State','7 hrs'],['Week 3','Navigation – Stack & Tabs','7 hrs'],['Week 4','API Integration & Fetch','7 hrs'],['Week 5','Local Storage & AsyncStorage','7 hrs'],['Week 6','Styling & Animations','6 hrs'],['Week 7','Push Notifications & Camera','7 hrs'],['Week 8','Testing & App Store Deployment','6 hrs']],
    hours:'53 hours', projects:'9 mobile apps',
    reviews:[{init:'LW',name:'Lee Wei Hong',stars:5,text:'Built and shipped my first app after this course. Instructor feedback was brilliant.'},
             {init:'DL',name:'David Lim',stars:4,text:'Great depth on navigation and API handling. Saved me months of self-study.'}]
  },
  7: {
    icon:'fa-paint-brush', grad:'linear-gradient(135deg,#ff9a9e,#fad0c4)',
    outcomes:['Design logos, branding materials and print assets','Master layers, masks and effects in Photoshop','Create vector illustrations in Illustrator','Produce quick social media graphics in Canva','Build a personal graphic design portfolio'],
    curriculum:[['Week 1','Design Principles & Colour Theory','5 hrs'],['Week 2','Photoshop – Retouching & Compositing','6 hrs'],['Week 3','Illustrator – Vector Design','6 hrs'],['Week 4','Canva & Brand Identity','5 hrs']],
    hours:'22 hours', projects:'7 portfolio pieces',
    reviews:[{init:'SN',name:'Siti Nabilah',stars:5,text:'Course is very hands-on. Finished with a complete design portfolio — got freelance clients immediately.'},
             {init:'NA',name:'Nur Aisyah',stars:4,text:'Loved the Canva module. Very applicable for social media marketing too.'}]
  },
  8: {
    icon:'fa-comments', grad:'linear-gradient(135deg,#a1c4fd,#c2e9fb)',
    outcomes:['Write professional business emails and reports','Deliver confident presentations to stakeholders','Participate effectively in meetings and negotiations','Adapt communication style across cultures','Give and receive constructive feedback'],
    curriculum:[['Week 1','Foundations of Business Communication','4 hrs'],['Week 2','Professional Writing & Emails','5 hrs'],['Week 3','Presentation Skills & Public Speaking','5 hrs']],
    hours:'14 hours', projects:'4 live presentations',
    reviews:[{init:'AF',name:'Ahmad Faris',stars:4,text:'Practical exercises made a real difference to my confidence in meetings.'},
             {init:'PM',name:'Priya Menon',stars:5,text:'Writing skills improved dramatically. My manager noticed the difference immediately.'}]
  },
  9: {
    icon:'fa-heartbeat', grad:'linear-gradient(135deg,#fd746c,#ff9068)',
    outcomes:['Perform adult, child, and infant CPR correctly','Apply first aid for common workplace injuries','Use an AED (Automated External Defibrillator)','Manage bleeding, fractures, and choking','Receive a Ministry-recognised First Aid certificate'],
    curriculum:[['Day 1 AM','Basic Life Support & Adult CPR','4 hrs'],['Day 1 PM','AED Use & Choking Response','3 hrs'],['Day 2 AM','Wound Care, Burns & Fractures','4 hrs'],['Day 2 PM','Practical Assessment & Certification','3 hrs']],
    hours:'14 hours', projects:'Practical assessments',
    reviews:[{init:'RK',name:'Rajesh Kumar',stars:5,text:'Life-saving skills explained simply and practically. The practical sessions are excellent.'},
             {init:'SN',name:'Siti Nabilah',stars:5,text:'Instructor was outstanding. Already used these skills to help a colleague at work!'}]
  },
};

/*Password strength*/
function checkPasswordStrength(val, barId) {
  let s = 0;
  if (val.length >= 8) s++;
  if (/[A-Z]/.test(val)) s++;
  if (/[0-9]/.test(val)) s++;
  if (/[^A-Za-z0-9]/.test(val)) s++;
  const bar = document.getElementById(barId || 'pwBar');
  if (!bar) return;
  bar.style.width = (s * 25) + '%';
  bar.style.background = ['#dc2626','#f59e0b','#22c55e','#16a34a'][s - 1] || 'transparent';
}

/*Toggle password visibility*/
function togglePw(inputId, btn) {
  const inp = document.getElementById(inputId);
  if (!inp) return;
  if (inp.type === 'password') { inp.type = 'text'; btn.innerHTML = '<i class="fas fa-eye-slash"></i>'; }
  else { inp.type = 'password'; btn.innerHTML = '<i class="fas fa-eye"></i>'; }
}

/*Lesson player (learning page)*/
function selectLesson(el, title, desc) {
  document.querySelectorAll('.lesson-item').forEach(li => li.classList.remove('active'));
  el.classList.add('active');
  const h = document.getElementById('playerTitle');
  const p = document.getElementById('playerDesc');
  if (h) h.textContent = title;
  if (p) p.textContent = desc || 'Follow along with the lesson content below.';
  showToast('Now playing: ' + title);
}

/*Receipt page*/
function populateReceipt() {
  const params   = new URLSearchParams(window.location.search);
  const courseId = parseInt(params.get('id')) || 0;
  const course   = params.get('course')   || 'Full-Stack Web Development';
  const fee      = params.get('fee')      || '1,500';
  const provider = params.get('provider') || 'TechPro Academy';
  const name     = EduAuth ? EduAuth.name() : (localStorage.getItem('edu_name') || 'Student');

  const set     = (id, val) => { const el = document.getElementById(id); if (el) el.textContent = val; };
  const setHTML = (id, val) => { const el = document.getElementById(id); if (el) el.innerHTML   = val; };

  set('sName', name);
  set('cName', course);
  set('cProv', provider);
  set('cFee',  'RM ' + fee + '.00');
  setHTML('cTotal', '<strong>RM ' + fee + '.00</strong>');

  const now = new Date();
  set('rDate', now.toLocaleDateString('en-MY', { day:'2-digit', month:'long', year:'numeric' }));
  set('rTime', now.toLocaleTimeString('en-MY', { hour:'2-digit', minute:'2-digit' }));
  set('rRef',  'TXN-' + Math.random().toString(36).substr(2, 8).toUpperCase());
  set('rNo',   'Receipt No: EDU-' + new Date().getFullYear() + '-' + Math.floor(1000 + Math.random() * 9000));

  // Set course-specific icon & gradient on receipt
  const det = COURSE_DETAILS[courseId];
  const iconBox = document.getElementById('cIconBox');
  if (iconBox && det) {
    iconBox.style.background = det.grad;
    const ico = iconBox.querySelector('i');
    if (ico) { ico.className = 'fas ' + det.icon; ico.style.fontSize = '1.3rem'; ico.style.color = 'white'; }
  }
}

/*Navbar scroll shadow*/
function initNavScroll() {
  window.addEventListener('scroll', () => {
    const nb = document.getElementById('navbar');
    if (nb) nb.classList.toggle('scrolled', scrollY > 10);
  });
  const h = document.getElementById('hamburger');
  const m = document.getElementById('mobileMenu');
  if (h && m) {
    h.addEventListener('click', () => { h.classList.toggle('open'); m.classList.toggle('open'); });
  }
}

/* ── Toast ── */
function showToast(msg, ok = true) {
  let t = document.getElementById('toast');
  if (!t) {
    t = document.createElement('div'); t.id = 'toast'; t.className = 'toast';
    t.innerHTML = '<i id="toastIcon" class="fas fa-check-circle" style="color:#4ade80"></i><span id="toastMsg"></span>';
    document.body.appendChild(t);
  }
  document.getElementById('toastIcon').style.color = ok ? '#4ade80' : '#fb923c';
  document.getElementById('toastMsg').textContent = msg;
  t.classList.add('show');
  setTimeout(() => t.classList.remove('show'), 3400);
}

/* ── Tab switcher (profile page) ── */
function switchTab(name, el, prefix) {
  const pre = prefix || 'pane';
  document.querySelectorAll('.tab-pane').forEach(p => p.classList.remove('active'));
  // Only remove active from tab-link elements — never touch util-links
  document.querySelectorAll('.p-nav a.tab-link').forEach(a => a.classList.remove('active'));
  const pane = document.getElementById(pre + '-' + name);
  if (pane) pane.classList.add('active');
  if (el)   el.classList.add('active');
}

/*Enroll modal / payment*/
function selectPayMethod(btn) {
  document.querySelectorAll('.pm-btn').forEach(b => b.classList.remove('active'));
  btn.classList.add('active');
}

function processPayment(courseTitle, fee, provider, courseId) {
  const name = (document.getElementById('payName') || {}).value?.trim();
  const ref  = (document.getElementById('payRef')  || {}).value?.trim();
  if (!name || !ref) { showToast('Please fill in your payment details.', false); return; }
  const modal = document.getElementById('payModal');
  if (modal) modal.classList.remove('open');
  showToast('Processing payment…');
  setTimeout(() => {
    window.location.href = 'receipt.html?id=' + (courseId || '') +
      '&course=' + encodeURIComponent(courseTitle) +
      '&fee=' + encodeURIComponent(fee) +
      '&provider=' + encodeURIComponent(provider);
  }, 1500);
}

