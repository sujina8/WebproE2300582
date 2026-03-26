/* ============================================================
   EduSkill – assets/js/auth.js
   Pure front-end authentication (no XAMPP / MySQL needed)
   Uses localStorage as the "database" for demo purposes.

   ACCOUNTS
   ─────────────────────────────────────────────────────────────
   TEST ADMIN      (front-end demo only)
     Email    : testadmin@eduskill.my
     Password : TestAdmin@2025
     Access   : Full admin dashboard – data is dummy/in-memory

   PERMANENT ADMIN (real backend – needs XAMPP + MySQL)
     Email    : admin@mohr.gov.my
     Password : EduSkill@Admin99!
     Access   : Full admin dashboard – connects to real DB

   Students & Providers can self-register; accounts are saved
   to localStorage so they persist across browser sessions.
   ============================================================ */

(function () {

  /* ── Storage keys ── */
  const KEY_STUDENTS  = 'edu_students';
  const KEY_PROVIDERS = 'edu_providers';
  const KEY_SESSION   = 'edu_session';   // { role, name, email, id, adminType? }

  /* ── Built-in demo accounts ── */
  const DEMO_ACCOUNTS = {
    /* ---- TEST admin: pure front-end, no DB ---- */
    'testadmin@eduskill.my': {
      password : 'TestAdmin@2025',
      role     : 'admin',
      name     : 'Test Admin',
      adminType: 'test',          // signals front-end-only mode
    },
    /* ---- PERMANENT admin: needs XAMPP (handled by PHP) ---- */
    'admin@mohr.gov.my': {
      password : 'EduSkill@Admin99!',
      role     : 'admin',
      name     : 'Ministry Admin',
      adminType: 'permanent',     // real backend login
    },
  };

  /* ── Helpers ── */
  function loadList(key)       { try { return JSON.parse(localStorage.getItem(key) || '[]'); } catch { return []; } }
  function saveList(key, arr)  { localStorage.setItem(key, JSON.stringify(arr)); }
  function getSession()        { try { return JSON.parse(localStorage.getItem(KEY_SESSION) || 'null'); } catch { return null; } }
  function saveSession(obj)    { localStorage.setItem(KEY_SESSION, JSON.stringify(obj)); }
  function clearSession()      { localStorage.removeItem(KEY_SESSION);
                                 // keep legacy keys used by older pages
                                 localStorage.removeItem('edu_role');
                                 localStorage.removeItem('edu_name'); }

  function syncLegacy(session) {
    // Some pages still read edu_role / edu_name directly
    if (session) {
      localStorage.setItem('edu_role', session.role);
      localStorage.setItem('edu_name', session.name);
    }
  }


  /* ── Seed demo accounts on first load ── */
  (function seedDemoAccounts() {
    // Only seed once
    if (localStorage.getItem('edu_seeded_v2')) return;

    const students  = loadList(KEY_STUDENTS);
    const providers = loadList(KEY_PROVIDERS);

    // Demo student
    if (!students.find(s => s.email === 'student@eduskill.my')) {
      students.push({
        id        : 'STU-DEMO-001',
        name      : 'Ahmad Faris',
        firstName : 'Ahmad',
        lastName  : 'Faris',
        email     : 'student@eduskill.my',
        phone     : '+60 12-345 6789',
        dob       : '2000-01-15',
        education : "Bachelor's Degree",
        password  : 'Student@123',
        joinedAt  : new Date().toISOString(),
      });
      saveList(KEY_STUDENTS, students);
    }

    // Demo approved provider
    if (!providers.find(p => p.email === 'provider@techpro.my')) {
      providers.push({
        id          : 'PRV-DEMO-001',
        orgName     : 'TechPro Academy',
        regNo       : 'SSM-1234567-A',
        orgType     : 'Private Training Centre',
        address     : 'No. 1, Jalan Teknologi, Cyberjaya',
        contactName : 'Dato Ahmad',
        contactRole : 'Director',
        email       : 'provider@techpro.my',
        phone       : '+603-1234 5678',
        password    : 'Provider@123',
        status      : 'approved',
        appliedAt   : new Date().toISOString(),
      });
    }

    // Demo pending provider
    if (!providers.find(p => p.email === 'pending@learn.my')) {
      providers.push({
        id          : 'PRV-DEMO-002',
        orgName     : 'LearnHub Malaysia',
        regNo       : 'SSM-9876543-X',
        orgType     : 'Private Training Centre',
        address     : 'No. 5, Jalan Ilmu, Petaling Jaya',
        contactName : 'Tan Wei Ming',
        contactRole : 'Manager',
        email       : 'pending@learn.my',
        phone       : '+603-8765 4321',
        password    : 'Pending@123',
        status      : 'pending',
        appliedAt   : new Date().toISOString(),
      });
    }

    saveList(KEY_PROVIDERS, providers);
    localStorage.setItem('edu_seeded_v2', '1');
  })();

  /* ── Public API ── */
  window.EduAuth = {

    /* ─── Session ─── */
    session   : getSession,
    isLoggedIn: ()    => !!getSession(),
    role      : ()    => (getSession() || {}).role  || null,
    name      : ()    => (getSession() || {}).name  || 'User',
    email     : ()    => (getSession() || {}).email || '',
    adminType : ()    => (getSession() || {}).adminType || null,

    logout(redirectTo) {
      clearSession();
      window.location.href = redirectTo || '../index.html';
    },

    requireRole(role, loginPage) {
      const s = getSession();
      if (!s || s.role !== role) {
        window.location.href = loginPage || '../index.html';
        return false;
      }
      syncLegacy(s);
      return true;
    },

    /* ─── Admin login ─── */
    loginAdmin(email, password) {
      const e   = email.trim().toLowerCase();
      const acc = DEMO_ACCOUNTS[e];

      if (!acc || acc.role !== 'admin') {
        return { success: false, message: 'Invalid credentials. Access denied.' };
      }
      if (acc.password !== password) {
        return { success: false, message: 'Incorrect password. Access denied.' };
      }

      const session = { role: 'admin', name: acc.name, email: e, adminType: acc.adminType };
      saveSession(session);
      syncLegacy(session);
      return { success: true, name: acc.name, adminType: acc.adminType };
    },

    /* ─── Student login ─── */
    loginStudent(email, password) {
      const e        = email.trim().toLowerCase();
      const students = loadList(KEY_STUDENTS);
      const found    = students.find(s => s.email === e);

      if (!found)                    return { success: false, message: 'No account found with that email.' };
      if (found.password !== password) return { success: false, message: 'Incorrect password.' };

      const session = { role: 'student', name: found.name, email: e, id: found.id };
      saveSession(session);
      syncLegacy(session);
      return { success: true, name: found.name };
    },

    /* ─── Provider login ─── */
    loginProvider(email, password) {
      const e         = email.trim().toLowerCase();
      const providers = loadList(KEY_PROVIDERS);
      const found     = providers.find(p => p.email === e);

      if (!found)                     return { success: false, message: 'No account found with that email.' };
      if (found.password !== password) return { success: false, message: 'Incorrect password.' };
      if (found.status === 'pending') return { success: false, status: 'pending', message: 'Your account is pending Ministry approval.' };

      const session = { role: 'provider', name: found.orgName, email: e, id: found.id };
      saveSession(session);
      syncLegacy(session);
      return { success: true, name: found.orgName };
    },

    /* ─── Student registration ─── */
    registerStudent(data) {
      const e        = (data.email || '').trim().toLowerCase();
      const students = loadList(KEY_STUDENTS);

      if (!e || !data.password || !data.firstName || !data.lastName)
        return { success: false, message: 'Please fill in all required fields.' };
      if (students.find(s => s.email === e))
        return { success: false, message: 'An account with this email already exists.' };
      if (data.password.length < 8)
        return { success: false, message: 'Password must be at least 8 characters.' };
      if (data.password !== data.confirmPassword)
        return { success: false, message: 'Passwords do not match.' };

      const student = {
        id        : 'STU-' + Date.now(),
        name      : data.firstName.trim() + ' ' + data.lastName.trim(),
        firstName : data.firstName.trim(),
        lastName  : data.lastName.trim(),
        email     : e,
        phone     : data.phone     || '',
        dob       : data.dob       || '',
        education : data.education || '',
        password  : data.password,
        joinedAt  : new Date().toISOString(),
      };

      students.push(student);
      saveList(KEY_STUDENTS, students);
      return { success: true, message: 'Account created! You can now sign in.' };
    },

    /* ─── Provider registration ─── */
    registerProvider(data) {
      const e         = (data.email || '').trim().toLowerCase();
      const providers = loadList(KEY_PROVIDERS);

      const required = ['orgName','regNo','orgType','address','contactName','email','phone','password'];
      for (const f of required) {
        if (!data[f] || !String(data[f]).trim())
          return { success: false, message: 'Please fill in all required fields.' };
      }
      if (providers.find(p => p.email === e))
        return { success: false, message: 'An account with this email already exists.' };
      if (data.password !== data.confirmPassword)
        return { success: false, message: 'Passwords do not match.' };
      if (data.password.length < 8)
        return { success: false, message: 'Password must be at least 8 characters.' };

      const provider = {
        id          : 'PRV-' + Date.now(),
        orgName     : data.orgName.trim(),
        regNo       : data.regNo.trim(),
        orgType     : data.orgType,
        address     : data.address.trim(),
        contactName : data.contactName.trim(),
        contactRole : data.contactRole || '',
        email       : e,
        phone       : data.phone.trim(),
        password    : data.password,
        status      : 'pending',   // admin must approve
        appliedAt   : new Date().toISOString(),
      };

      providers.push(provider);
      saveList(KEY_PROVIDERS, providers);
      return { success: true, message: 'Application submitted! Awaiting Ministry approval.' };
    },

    /* ─── Admin helpers: get lists of registered users ─── */
    getStudents ()  { return loadList(KEY_STUDENTS).map(s => ({ ...s, password: '***' })); },
    getProviders()  { return loadList(KEY_PROVIDERS).map(p => ({ ...p, password: '***' })); },

    approveProvider(id) {
      const list = loadList(KEY_PROVIDERS);
      const p    = list.find(x => x.id === id);
      if (!p) return false;
      p.status = 'approved';
      saveList(KEY_PROVIDERS, list);
      return true;
    },

    rejectProvider(id) {
      const list = loadList(KEY_PROVIDERS).filter(x => x.id !== id);
      saveList(KEY_PROVIDERS, list);
      return true;
    },
  };

})();
