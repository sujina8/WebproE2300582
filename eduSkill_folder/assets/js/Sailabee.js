/* ============================================================
   EduSkill – assets/js/Sailabee.js
   TRAINING PROVIDER JavaScript utilities
   Author: Sailabee
   ============================================================ */

/* ── Auth guard ── */
function requireProvider() {
  if (localStorage.getItem('edu_role') !== 'provider') {
    window.location.href = '../provider/login.html';
    return false;
  }
  return true;
}

/* ── Navbar scroll ── */
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

/* ── Tab switcher ── */
function switchTab(name, btn) {
  document.querySelectorAll('.tab-pane').forEach(p => p.classList.remove('active'));
  document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
  const pane = document.getElementById('tab-' + name);
  if (pane) pane.classList.add('active');
  if (btn)  btn.classList.add('active');
  if (name === 'reports') renderProviderChart();
}

/* ── Profile tab switcher ── */
function switchProfileTab(name, el) {
  event.preventDefault();
  document.querySelectorAll('.tab-pane').forEach(p => p.classList.remove('active'));
  // Only remove active from tab-link elements — never touch util-links
  document.querySelectorAll('.p-nav a.tab-link').forEach(a => a.classList.remove('active'));
  const pane = document.getElementById('pane-' + name);
  if (pane) pane.classList.add('active');
  if (el)   el.classList.add('active');
}

/* ── Toggle password ── */
function togglePw(inputId, btn) {
  const inp = document.getElementById(inputId);
  if (!inp) return;
  if (inp.type === 'password') { inp.type = 'text'; btn.innerHTML = '<i class="fas fa-eye-slash"></i>'; }
  else { inp.type = 'password'; btn.innerHTML = '<i class="fas fa-eye"></i>'; }
}

/* ── Provider course state ── */
let PROVIDER_COURSES = [
  { id:1, title:'Full-Stack Web Development', cat:'Technology', icon:'fa-code',       grad:'linear-gradient(135deg,#667eea,#764ba2)', dur:'8 Weeks',  price:1500, level:'Beginner',     students:28, rating:4.9, status:'Active' },
  { id:2, title:'Python for Data Science',    cat:'Technology', icon:'fa-python',     grad:'linear-gradient(135deg,#43e97b,#38f9d7)', dur:'10 Weeks', price:1800, level:'Intermediate', students:15, rating:4.8, status:'Active' },
  { id:3, title:'Mobile App Development',     cat:'Technology', icon:'fa-mobile-alt', grad:'linear-gradient(135deg,#a18cd1,#fbc2eb)', dur:'8 Weeks',  price:2000, level:'Intermediate', students:9,  rating:4.7, status:'Active' },
];

const PROVIDER_ENROLMENTS = [
  { student:'Ahmad Faris',  course:'Full-Stack Web Development', date:'02 Jan 2025', status:'Active', pay:'NRs.1,500', progress:75 },
  { student:'Siti Nabilah', course:'Full-Stack Web Development', date:'05 Jan 2025', status:'Active', pay:'NRs.1,500', progress:40 },
  { student:'Rajesh Kumar', course:'Python for Data Science',    date:'10 Jan 2025', status:'Active', pay:'NRs.1,800', progress:60 },
  { student:'Priya Menon',  course:'Mobile App Development',     date:'15 Jan 2025', status:'Active', pay:'NRs.2,000', progress:25 },
  { student:'Lee Wei Hong', course:'Full-Stack Web Development', date:'20 Jan 2025', status:'Active', pay:'NRs.1,500', progress:90 },
];

/* ── Render course cards ── */
function renderCourseCards(containerId) {
  const el = document.getElementById(containerId || 'courseList');
  if (!el) return;
  el.innerHTML = PROVIDER_COURSES.map(c => `
    <div class="cm-card">
      <div class="cm-icon" style="background:none;padding:0;overflow:hidden;border-radius:14px"><img src="${c.img}" alt="${c.cat}" style="width:52px;height:52px;object-fit:cover"/></div>
      <div class="cm-info"><h4>${c.title}</h4><p>${c.cat} · ${c.level} · ${c.dur}</p></div>
      <div class="cm-stats">
        <div class="cm-stat"><strong>${c.students}</strong><span>Students</span></div>
        <div class="cm-stat"><strong>${c.rating}★</strong><span>Rating</span></div>
        <div class="cm-stat"><strong>NRs.${c.price.toLocaleString()}</strong><span>Price</span></div>
      </div>
      <span class="badge badge-green">${c.status}</span>
      <div class="cm-actions">
        <button class="btn-edit" onclick="openEditModal(${c.id})"><i class="fas fa-edit"></i> Edit</button>
        <button class="btn-del"  onclick="deleteCourse(${c.id})"><i class="fas fa-trash"></i></button>
      </div>
    </div>`).join('');
}

/* ── Render enrolment table ── */
function renderEnrolments(tbodyId) {
  const el = document.getElementById(tbodyId || 'enrolTbody');
  if (!el) return;
  el.innerHTML = PROVIDER_ENROLMENTS.map(e => `
    <tr>
      <td>${e.student}</td>
      <td>${e.course}</td>
      <td>${e.date}</td>
      <td><span class="badge badge-green">${e.status}</span></td>
      <td>${e.pay}</td>
      <td>
        <div style="display:flex;align-items:center;gap:8px">
          <div style="flex:1;height:6px;background:var(--cream-dark);border-radius:3px;overflow:hidden">
            <div style="height:100%;width:${e.progress}%;background:linear-gradient(90deg,#5b6cf6,#818cf8);border-radius:3px"></div>
          </div>
          <span style="font-size:.76rem;font-weight:600;color:#5b6cf6;white-space:nowrap">${e.progress}%</span>
        </div>
      </td>
    </tr>`).join('');
}

/* ── Edit modal ── */
let _editId = null;
function openEditModal(id) {
  const c = PROVIDER_COURSES.find(x => x.id === id);
  if (!c) return;
  _editId = id;
  const set = (i, v) => { const el = document.getElementById(i); if (el) el.value = v; };
  set('editTitle', c.title); set('editDur', c.dur); set('editPrice', c.price); set('editDesc', '');
  const m = document.getElementById('editModal');
  if (m) m.classList.add('open');
}
function closeModal() {
  const m = document.getElementById('editModal');
  if (m) m.classList.remove('open');
}
function saveEdit() {
  const c = PROVIDER_COURSES.find(x => x.id === _editId);
  if (c) {
    const g = id => (document.getElementById(id) || {}).value;
    c.title = g('editTitle') || c.title;
    c.dur   = g('editDur')   || c.dur;
    c.price = +g('editPrice')|| c.price;
  }
  closeModal();
  renderCourseCards();
  showToast('Course updated successfully!');
}
function deleteCourse(id) {
  if (!confirm('Delete this course? This cannot be undone.')) return;
  PROVIDER_COURSES = PROVIDER_COURSES.filter(c => c.id !== id);
  renderCourseCards();
  showToast('Course removed.');
}
function addCourse() {
  const g = id => (document.getElementById(id) || {}).value?.trim() || '';
  const title = g('newTitle');
  if (!title) { showToast('Please enter a course title.', false); return; }
  PROVIDER_COURSES.push({
    id: Date.now(), title, cat: g('newCat') || 'Technology',
    icon: 'fa-book', grad: 'linear-gradient(135deg,#c97b2e,#e8a44a)',
    dur: g('newDur') || 'TBD', price: +g('newPrice') || 0,
    level: g('newLevel') || 'Beginner', students: 0, rating: 0, status: 'Active'
  });
  ['newTitle','newDur','newPrice','newDesc','newMax'].forEach(id => {
    const el = document.getElementById(id); if (el) el.value = '';
  });
  switchTab('courses', document.querySelectorAll('.tab-btn')[0]);
  renderCourseCards();
  showToast(`"${title}" added successfully!`);
}

/* ── Materials ── */
const MATERIALS = [
  { id:1, title:'Week 1 – HTML5 Slides',         type:'PDF',   course:'Full-Stack Web Dev', size:'2.4 MB', date:'10 Jan 2025' },
  { id:2, title:'Week 2 – CSS Grid Exercises',    type:'ZIP',   course:'Full-Stack Web Dev', size:'1.1 MB', date:'17 Jan 2025' },
  { id:3, title:'Week 3 – JS Lecture Recording',  type:'Video', course:'Full-Stack Web Dev', size:'380 MB', date:'24 Jan 2025' },
  { id:4, title:'Python Notebook – Pandas Intro', type:'IPYNB', course:'Python for DS',      size:'0.8 MB', date:'12 Jan 2025' },
];

function renderMaterials(containerId) {
  const el = document.getElementById(containerId || 'materialList');
  if (!el) return;
  el.innerHTML = MATERIALS.map(m => `
    <div class="material-card">
      <div class="mat-icon"><i class="fas ${m.type==='Video'?'fa-video':m.type==='ZIP'?'fa-file-archive':m.type==='IPYNB'?'fa-code':'fa-file-pdf'}"></i></div>
      <div class="mat-info"><h4>${m.title}</h4><p>${m.course} · ${m.type} · ${m.size} · ${m.date}</p></div>
      <div class="mat-actions">
        <button class="btn-edit" onclick="showToast('Downloading…')"><i class="fas fa-download"></i></button>
        <button class="btn-del"  onclick="showToast('Material removed.')"><i class="fas fa-trash"></i></button>
      </div>
    </div>`).join('');
}

function simulateUpload() {
  const input = document.getElementById('fileInput');
  if (!input || !input.files.length) { showToast('Please select a file.', false); return; }
  const file = input.files[0];
  MATERIALS.unshift({ id: Date.now(), title: file.name, type: file.name.split('.').pop().toUpperCase(), course: 'General', size: (file.size/1024/1024).toFixed(1)+' MB', date: new Date().toLocaleDateString('en-MY') });
  renderMaterials();
  showToast(`"${file.name}" uploaded successfully!`);
}

/* ── Lessons ── */
const LESSONS = [
  { id:1, title:'Introduction to HTML5',       type:'Video',    dur:'45 min' },
  { id:2, title:'Semantic Elements & Forms',   type:'Video',    dur:'38 min' },
  { id:3, title:'CSS3 Flexbox Deep Dive',      type:'Video',    dur:'52 min' },
  { id:4, title:'Grid Layout Workshop',        type:'Exercise', dur:'30 min' },
  { id:5, title:'JavaScript: Variables & Scope', type:'Video', dur:'41 min' },
  { id:6, title:'DOM Manipulation Quiz',       type:'Quiz',     dur:'20 min' },
];

function renderLessons(containerId) {
  const el = document.getElementById(containerId || 'lessonList');
  if (!el) return;
  el.innerHTML = LESSONS.map(l => `
    <div class="lesson-list-item">
      <i class="fas fa-grip-vertical drag"></i>
      <span class="l-title">${l.title}</span>
      <span class="l-type">${l.type}</span>
      <span style="font-size:.76rem;color:var(--text-light)">${l.dur}</span>
      <button class="btn-edit" style="padding:5px 10px" onclick="showToast('Editing: ${l.title}')"><i class="fas fa-edit"></i></button>
      <button class="btn-del"  style="padding:5px 10px" onclick="showToast('Removed lesson.')"><i class="fas fa-trash"></i></button>
    </div>`).join('');
}

function addLesson() {
  const t = (document.getElementById('newLessonTitle')||{}).value?.trim();
  if (!t) { showToast('Please enter a lesson title.', false); return; }
  LESSONS.push({ id: Date.now(), title: t, type: (document.getElementById('newLessonType')||{}).value||'Video', dur: (document.getElementById('newLessonDur')||{}).value||'30 min' });
  const el = document.getElementById('newLessonTitle'); if (el) el.value = '';
  renderLessons();
  showToast(`Lesson "${t}" added!`);
}

/* ── Bar chart ── */
function renderProviderChart() {
  const months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
  const data   = [4,7,5,9,12,8,6,10,7,5,8,3];
  const el     = document.getElementById('provChart');
  if (!el) return;
  const max = Math.max(...data);
  el.innerHTML = data.map((v,i) => `
    <div class="chart-row">
      <div class="chart-label">${months[i]}</div>
      <div class="chart-outer"><div class="chart-inner" data-w="${Math.round(v/max*100)}" style="width:0"></div></div>
      <div class="chart-val">${v}</div>
    </div>`).join('');
  setTimeout(() => el.querySelectorAll('.chart-inner').forEach(b => b.style.width = b.dataset.w + '%'), 300);
}

/* ── Validation helpers ── */
function validateRegisterForm() {
  const fields = [['orgName','Organisation name'],['regNo','Reg. number'],['orgType','Type'],['address','Address'],['cpName','Contact name'],['email','Email'],['phone','Phone'],['pass','Password'],['pass2','Confirm password']];
  for (const [id, lbl] of fields) {
    const el = document.getElementById(id);
    if (!el || !el.value.trim()) { showToast('Please fill in: ' + lbl, false); return false; }
  }
  if (document.getElementById('pass').value !== document.getElementById('pass2').value) { showToast('Passwords do not match.', false); return false; }
  if (!document.getElementById('terms').checked) { showToast('Please accept the Terms.', false); return false; }
  return true;
}
