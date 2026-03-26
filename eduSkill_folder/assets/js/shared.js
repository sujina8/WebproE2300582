/* ============================================================
   EduSkill – assets/js/shared.js
   Shared utilities used across ALL pages
   (student, provider, admin, public)
   ============================================================ */

/* ── Navbar scroll shadow ── */
window.addEventListener('scroll', () => {
  const nb = document.getElementById('navbar');
  if (nb) nb.classList.toggle('scrolled', scrollY > 10);
});

/* ── Hamburger (public pages) ── */
document.addEventListener('DOMContentLoaded', () => {
  const h = document.getElementById('hamburger');
  const m = document.getElementById('mobileMenu');
  if (h && m) {
    h.addEventListener('click', () => {
      h.classList.toggle('open');
      m.classList.toggle('open');
    });
  }
});

/* ── Scroll reveal (public / home page) ── */
document.addEventListener('DOMContentLoaded', () => {
  const obs = new IntersectionObserver((entries) => {
    entries.forEach((e, i) => {
      if (e.isIntersecting) {
        setTimeout(() => e.target.classList.add('visible'), i * 70);
        obs.unobserve(e.target);
      }
    });
  }, { threshold: 0.1 });
  document.querySelectorAll('.reveal').forEach(el => obs.observe(el));
});

/* ── Counter animation (home hero stats) ── */
function animateCounters(selector) {
  document.querySelectorAll(selector || '.stat-number[data-target]').forEach(el => {
    const target = +el.dataset.target;
    let c = 0;
    const step = Math.ceil(target / 55);
    const iv = setInterval(() => {
      c = Math.min(c + step, target);
      el.textContent = c + '+';
      if (c >= target) clearInterval(iv);
    }, 22);
  });
}

/* ── Toast notification ── */
function showToast(msg, ok = true) {
  let t = document.getElementById('toast');
  if (!t) {
    t = document.createElement('div');
    t.id = 'toast'; t.className = 'toast';
    t.innerHTML = '<i id="toastIcon" class="fas fa-check-circle" style="color:#4ade80"></i><span id="toastMsg"></span>';
    document.body.appendChild(t);
  }
  const icon = document.getElementById('toastIcon');
  const msg_el = document.getElementById('toastMsg');
  if (icon) { icon.className = ok ? 'fas fa-check-circle' : 'fas fa-exclamation-circle'; icon.style.color = ok ? '#4ade80' : '#fb923c'; }
  if (msg_el) msg_el.textContent = msg;
  t.classList.add('show');
  setTimeout(() => t.classList.remove('show'), 3400);
}

/* ── Toggle password visibility ── */
function togglePw(inputId, btn) {
  const inp = document.getElementById(inputId);
  if (!inp) return;
  if (inp.type === 'password') { inp.type = 'text'; btn.innerHTML = '<i class="fas fa-eye-slash"></i>'; }
  else { inp.type = 'password'; btn.innerHTML = '<i class="fas fa-eye"></i>'; }
}

/* ── Bar chart renderer (used in provider & admin reports) ── */
function renderBarChart(containerId, labels, values, colorOverride) {
  const el = document.getElementById(containerId);
  if (!el) return;
  const max = Math.max(...values, 1);
  el.innerHTML = values.map((v, i) => `
    <div class="chart-row">
      <div class="chart-label">${labels[i]}</div>
      <div class="chart-outer">
        <div class="chart-inner" data-w="${Math.round(v / max * 100)}"
             style="width:0${colorOverride ? ';background:' + colorOverride : ''}"></div>
      </div>
      <div class="chart-val">${v}</div>
    </div>`).join('');
  setTimeout(() => el.querySelectorAll('.chart-inner').forEach(b => b.style.width = b.dataset.w + '%'), 300);
}

/* ── Auth object ── */
const Auth = {
  getRole: ()   => localStorage.getItem('edu_role'),
  getName: ()   => localStorage.getItem('edu_name') || 'User',
  set:  (role, name) => { localStorage.setItem('edu_role', role); localStorage.setItem('edu_name', name); },
  clear: ()     => { localStorage.removeItem('edu_role'); localStorage.removeItem('edu_name'); },
  logout: (redirectTo) => { Auth.clear(); window.location.href = redirectTo || '../index.html'; },
  requireRole: (role, loginPage) => {
    if (localStorage.getItem('edu_role') !== role) {
      window.location.href = loginPage || '../index.html';
      return false;
    }
    return true;
  }
};

/* ── Redirect logged-in users away from public index ── */
function redirectIfLoggedIn() {
  const role = Auth.getRole();
  if (!role) return;
  const map = { student: 'student/dashboard.html', provider: 'provider/dashboard.html', admin: 'admin/dashboard.html' };
  if (map[role]) window.location.href = map[role];
}

/* ── Generic tab switcher ── */
function switchTab(name, btn, prefix) {
  const pre = prefix || 'tab';
  document.querySelectorAll('.tab-pane').forEach(p => p.classList.remove('active'));
  document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
  const pane = document.getElementById(pre + '-' + name);
  if (pane) pane.classList.add('active');
  if (btn)  btn.classList.add('active');
}

/* ── Modal helpers ── */
function openModal(id)  { const m = document.getElementById(id); if (m) m.classList.add('open'); }
function closeModal(id) { const m = document.getElementById(id); if (m) m.classList.remove('open'); }
