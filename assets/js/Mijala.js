/* ============================================================
   EduSkill – assets/js/Mijala.js
   ADMIN JavaScript utilities
   Author: Mijala
   ============================================================ */

/* ── Auth guard ── */
function requireAdmin() {
  if (localStorage.getItem('edu_role') !== 'admin') {
    window.location.href = '../admin/login.html';
    return false;
  }
  return true;
}

/* ── Navbar scroll ── */
function initNavScroll() {
  const nb = document.getElementById('navbar');
  if (nb) window.addEventListener('scroll', () => nb.classList.toggle('scrolled', scrollY > 10));
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
  if (name === 'reports') renderAdminChart();
}

/* ── Toggle password ── */
function togglePw(inputId, btn) {
  const inp = document.getElementById(inputId);
  if (!inp) return;
  if (inp.type === 'password') { inp.type = 'text'; btn.innerHTML = '<i class="fas fa-eye-slash"></i>'; }
  else { inp.type = 'password'; btn.innerHTML = '<i class="fas fa-eye"></i>'; }
}

/* ── Pending providers data ── */
let PENDING_PROVIDERS = [
  { id:1, name:'LearnHub Malaysia',   type:'Private Training Centre', reg:'SSM-9876543-X', contact:'Tan Wei Ming',   email:'admin@learnhub.my',  date:'18 Mar 2025' },
  { id:2, name:'HealthPro Training',  type:'Professional Body',       reg:'SSM-8765432-Y', contact:'Dr. Noor Aisha', email:'info@healthpro.my',   date:'19 Mar 2025' },
];

const ALL_PROVIDERS = [
  { name:'TechPro Academy',    type:'Private Training Centre', reg:'SSM-1234567-A', courses:3, students:52,  status:'Approved' },
  { name:'DesignHub MY',       type:'Private Training Centre', reg:'SSM-2345678-B', courses:2, students:34,  status:'Approved' },
  { name:'MarketPro Institute',type:'Professional Body',       reg:'SSM-3456789-C', courses:1, students:20,  status:'Approved' },
  { name:'FinanceLearn MY',    type:'Private Training Centre', reg:'SSM-4567890-D', courses:1, students:12,  status:'Approved' },
  { name:'AppMakers Academy',  type:'Private Training Centre', reg:'SSM-5678901-E', courses:1, students:18,  status:'Approved' },
];

const ALL_STUDENTS = [
  { name:'Ahmad Faris',  email:'ahmad@example.com',  courses:3, joined:'02 Jan 2025', status:'Active' },
  { name:'Siti Nabilah', email:'siti@example.com',   courses:1, joined:'05 Jan 2025', status:'Active' },
  { name:'Rajesh Kumar', email:'rajesh@example.com', courses:2, joined:'10 Jan 2025', status:'Active' },
  { name:'Priya Menon',  email:'priya@example.com',  courses:1, joined:'15 Jan 2025', status:'Active' },
  { name:'Lee Wei Hong', email:'lee@example.com',    courses:2, joined:'20 Jan 2025', status:'Active' },
  { name:'Nur Aisyah',   email:'aisyah@example.com', courses:1, joined:'25 Jan 2025', status:'Active' },
  { name:'David Lim',    email:'david@example.com',  courses:2, joined:'01 Feb 2025', status:'Active' },
];

const ALL_COURSES = [
  { title:'Full-Stack Web Development',   provider:'TechPro Academy',    cat:'Technology', price:1500, enrolled:28, status:'Active' },
  { title:'UI/UX Design Fundamentals',    provider:'DesignHub MY',        cat:'Design',     price:1500, enrolled:20, status:'Active' },
  { title:'Digital Marketing Mastery',    provider:'MarketPro Institute', cat:'Business',   price:1500, enrolled:20, status:'Active' },
  { title:'Python for Data Science',      provider:'TechPro Academy',    cat:'Technology', price:1800, enrolled:15, status:'Active' },
  { title:'Financial Accounting Basics',  provider:'FinanceLearn MY',    cat:'Finance',    price:1200, enrolled:12, status:'Active' },
  { title:'Mobile App Development',       provider:'AppMakers Academy',  cat:'Technology', price:2000, enrolled:18, status:'Active' },
];

/* ── Render pending approvals ── */
function renderApprovals() {
  const countEl = document.getElementById('pendCount');
  if (countEl) countEl.textContent = PENDING_PROVIDERS.length;

  const list = document.getElementById('approvalList');
  if (!list) return;

  if (!PENDING_PROVIDERS.length) {
    list.innerHTML = '<div class="empty-state"><i class="fas fa-check-circle"></i>No pending approvals. All providers reviewed!</div>';
    return;
  }
  list.innerHTML = PENDING_PROVIDERS.map(p => `
    <div class="appr-card">
      <div class="appr-icon"><i class="fas fa-building"></i></div>
      <div class="appr-info">
        <h4>${p.name}</h4>
        <p>${p.type} &nbsp;·&nbsp; Reg: ${p.reg} &nbsp;·&nbsp; Contact: ${p.contact} &nbsp;·&nbsp; ${p.email} &nbsp;·&nbsp; Applied: ${p.date}</p>
      </div>
      <span class="badge badge-amber">Pending</span>
      <div class="appr-actions">
        <button class="btn-approve" onclick="handleApproval(${p.id},'approve')"><i class="fas fa-check"></i> Approve</button>
        <button class="btn-reject"  onclick="handleApproval(${p.id},'reject')"><i class="fas fa-times"></i> Reject</button>
      </div>
    </div>`).join('');
}

function handleApproval(id, action) {
  const p = PENDING_PROVIDERS.find(x => x.id === id);
  if (!p) return;
  PENDING_PROVIDERS = PENDING_PROVIDERS.filter(x => x.id !== id);
  if (action === 'approve') {
    ALL_PROVIDERS.push({ name: p.name, type: p.type, reg: p.reg, courses: 0, students: 0, status: 'Approved' });
  }
  renderApprovals();
  renderProviders();
  showToast(`${p.name} has been ${action === 'approve' ? 'approved ✓' : 'rejected ✗'}.`);
}

/* ── Render providers table ── */
function renderProviders(filter) {
  const tbody = document.getElementById('provTbody');
  if (!tbody) return;
  const data = filter ? ALL_PROVIDERS.filter(p => p.status === filter) : ALL_PROVIDERS;
  tbody.innerHTML = data.map(p => `
    <tr>
      <td><strong>${p.name}</strong></td>
      <td>${p.type}</td>
      <td>${p.reg}</td>
      <td>${p.courses}</td>
      <td>${p.students}</td>
      <td><span class="badge badge-${p.status==='Approved'?'green':'amber'}">${p.status}</span></td>
      <td><button class="btn-view" onclick="showToast('Viewing ${p.name}')"><i class="fas fa-eye"></i></button></td>
    </tr>`).join('');
}

/* ── Render students table ── */
function renderStudents(query) {
  const tbody = document.getElementById('studentTbody');
  if (!tbody) return;
  const q    = (query || '').toLowerCase();
  const data = q ? ALL_STUDENTS.filter(s => s.name.toLowerCase().includes(q) || s.email.toLowerCase().includes(q)) : ALL_STUDENTS;
  tbody.innerHTML = data.map(s => `
    <tr>
      <td><strong>${s.name}</strong></td>
      <td>${s.email}</td>
      <td>${s.courses}</td>
      <td>${s.joined}</td>
      <td><span class="badge badge-green">${s.status}</span></td>
      <td><button class="btn-view" onclick="showToast('Viewing ${s.name}')"><i class="fas fa-eye"></i></button></td>
    </tr>`).join('');
}

/* ── Render courses table ── */
function renderCourses(statusFilter) {
  const tbody = document.getElementById('courseTbody');
  if (!tbody) return;
  const data = statusFilter ? ALL_COURSES.filter(c => c.status === statusFilter) : ALL_COURSES;
  tbody.innerHTML = data.map(c => `
    <tr>
      <td><strong>${c.title}</strong></td>
      <td>${c.provider}</td>
      <td>${c.cat}</td>
      <td>NRs.${c.price.toLocaleString()}</td>
      <td>${c.enrolled}</td>
      <td><span class="badge badge-green">${c.status}</span></td>
      <td><button class="btn-view" onclick="showToast('Viewing course')"><i class="fas fa-eye"></i></button></td>
    </tr>`).join('');
}

/* ── Platform bar chart ── */
function renderAdminChart() {
  const months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
  const data   = [42,67,55,89,120,98,76,110,87,65,88,44];
  const el     = document.getElementById('adminChart');
  if (!el) return;
  const max = Math.max(...data);
  el.innerHTML = data.map((v, i) => `
    <div class="chart-row">
      <div class="chart-label">${months[i]}</div>
      <div class="chart-outer"><div class="chart-inner" data-w="${Math.round(v/max*100)}" style="width:0"></div></div>
      <div class="chart-val">${v}</div>
    </div>`).join('');
  setTimeout(() => el.querySelectorAll('.chart-inner').forEach(b => b.style.width = b.dataset.w + '%'), 300);
}

/* ── Init all admin dashboard ── */
function initAdminDashboard() {
  requireAdmin();
  const name = localStorage.getItem('edu_name') || 'Admin';
  const el   = document.getElementById('wName');
  if (el) el.textContent = 'Welcome, ' + name;
  renderApprovals();
  renderProviders();
  renderStudents();
  renderCourses();
}
