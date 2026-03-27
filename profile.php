<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/><meta name="viewport" content="width=device-width,initial-scale=1.0"/>
  <title>Provider Registration – EduSkill</title>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet"/>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
  <link rel="stylesheet" href="../assets/css/shared.css"/>
  <link rel="stylesheet" href="../assets/css/Sailabee.css"/>
</head>
<body>
<div class="nav-wrapper">
  <nav id="navbar">
    <a href="../index.php" class="nav-logo"><div class="nav-logo-icon"><img src="../assets/images/eduskill-logo.png" alt="EduSkill" style="width:30px;height:30px;object-fit:contain;border-radius:50%;display:block"></div>EduSkill</a>
    <a href="login.php" class="btn-outline" style="font-size:.82rem;padding:8px 18px"><i class="fas fa-sign-in-alt"></i> Login</a>
  </nav>
</div>

<div class="auth-wrap top-align">
  <div class="auth-card wide">
    <div class="auth-icon prov-icon"><i class="fas fa-building"></i></div>
    <h2>Provider Registration</h2>
    <p class="sub">Apply to list your courses on EduSkill</p>

    <div class="pending-note">
      <i class="fas fa-info-circle"></i>
      <div>After registration your account will be <strong>pending approval</strong> from a Ministry of Education officer. You will be notified once approved.</div>
    </div>

    <div class="sec-divider">Organisation Details</div>
    <div class="fg"><label>Organisation Name</label>
      <div class="input-wrap"><i class="fas fa-building prefix"></i><input type="text" id="orgName" placeholder="TechPro Academy Sdn Bhd"/></div>
    </div>
    <div class="form-row">
      <div class="fg"><label>SSM Registration No.</label>
        <div class="input-wrap"><i class="fas fa-id-card prefix"></i><input type="text" id="regNo" placeholder="SSM-1234567-X"/></div>
      </div>
      <div class="fg"><label>Organisation Type</label>
        <div class="input-wrap"><i class="fas fa-sitemap prefix"></i>
          <select id="orgType">
            <option value="">Select type</option>
            <option>Private Training Centre</option><option>Public University</option>
            <option>Private University</option><option>Polytechnic / Community College</option>
            <option>Professional Body</option><option>NGO / Non-profit</option>
          </select>
        </div>
      </div>
    </div>
    <div class="fg"><label>Business Address</label>
      <div class="input-wrap"><i class="fas fa-map-marker-alt prefix"></i><input type="text" id="address" placeholder="No. 1, Jalan Teknologi, 63000 Cyberjaya, Selangor"/></div>
    </div>

    <div class="sec-divider">Contact Person</div>
    <div class="form-row">
      <div class="fg"><label>Contact Person Name</label>
        <div class="input-wrap"><i class="fas fa-user prefix"></i><input type="text" id="cpName" placeholder="Dato' Ahmad"/></div>
      </div>
      <div class="fg"><label>Role / Designation</label>
        <div class="input-wrap"><i class="fas fa-briefcase prefix"></i><input type="text" id="cpRole" placeholder="Director / Manager"/></div>
      </div>
    </div>
    <div class="form-row">
      <div class="fg"><label>Official Email</label>
        <div class="input-wrap"><i class="fas fa-envelope prefix"></i><input type="email" id="email" placeholder="admin@company.my"/></div>
      </div>
      <div class="fg"><label>Phone Number</label>
        <div class="input-wrap"><i class="fas fa-phone prefix"></i><input type="tel" id="phone" placeholder="+603-1234 5678"/></div>
      </div>
    </div>

    <div class="sec-divider">Supporting Documents</div>
    <p style="font-size:.83rem;color:var(--text-light);margin:-4px 0 14px">Upload your company registration certificate and accreditation documents (PDF, JPG, PNG – max 5MB each).</p>
    <div class="fg">
      <label>Company Registration Certificate <span style="color:#e06418">*</span></label>
      <div class="doc-upload-box" id="docBox1" onclick="document.getElementById('docFile1').click()" ondragover="event.preventDefault();this.classList.add('drag-over')" ondragleave="this.classList.remove('drag-over')" ondrop="handleDocDrop(event,'docFile1','docName1','docBox1')">
        <i class="fas fa-cloud-upload-alt" style="font-size:1.6rem;color:var(--primary);margin-bottom:8px;display:block"></i>
        <span id="docName1" style="font-size:.85rem;color:var(--text-mid)">Click or drag &amp; drop to upload</span>
        <input type="file" id="docFile1" accept=".pdf,.jpg,.jpeg,.png" style="display:none" onchange="showDocName('docFile1','docName1','docBox1')"/>
      </div>
    </div>
    <div class="fg" style="margin-top:12px">
      <label>Accreditation / Professional Body Certificate <span style="font-size:.78rem;color:var(--text-light)">(optional)</span></label>
      <div class="doc-upload-box" id="docBox2" onclick="document.getElementById('docFile2').click()" ondragover="event.preventDefault();this.classList.add('drag-over')" ondragleave="this.classList.remove('drag-over')" ondrop="handleDocDrop(event,'docFile2','docName2','docBox2')">
        <i class="fas fa-cloud-upload-alt" style="font-size:1.6rem;color:var(--primary);margin-bottom:8px;display:block"></i>
        <span id="docName2" style="font-size:.85rem;color:var(--text-mid)">Click or drag &amp; drop to upload</span>
        <input type="file" id="docFile2" accept=".pdf,.jpg,.jpeg,.png" style="display:none" onchange="showDocName('docFile2','docName2','docBox2')"/>
      </div>
    </div>

    <div class="sec-divider">Account Security</div>
    <div class="form-row">
      <div class="fg"><label>Password</label>
        <div class="input-wrap"><i class="fas fa-lock prefix"></i>
          <input type="password" id="pass" placeholder="Min 8 chars"/>
          <button class="eye-btn" onclick="togglePw('pass',this)" type="button"><i class="fas fa-eye"></i></button>
        </div>
      </div>
      <div class="fg"><label>Confirm Password</label>
        <div class="input-wrap"><i class="fas fa-lock prefix"></i><input type="password" id="pass2" placeholder="Re-enter"/></div>
      </div>
    </div>

    <div class="terms">
      <input type="checkbox" id="terms"/>
      <label for="terms">I confirm all information is accurate and I agree to the <a href="#">Provider Terms</a> and <a href="#">Privacy Policy</a></label>
    </div>
    <button class="auth-btn prov-btn" onclick="doRegister()">Submit Application &nbsp;<i class="fas fa-paper-plane"></i></button>
    <div class="auth-footer">Already approved? <a href="login.php">Sign in here</a></div>
  </div>
</div>

<style>
.doc-upload-box{border:2px dashed rgba(201,123,46,.35);border-radius:12px;padding:22px;text-align:center;cursor:pointer;transition:border-color .2s,background .2s}
.doc-upload-box:hover,.doc-upload-box.drag-over{border-color:var(--primary);background:rgba(201,123,46,.05)}
.doc-upload-box.has-file{border-color:#16a34a;background:rgba(22,163,74,.05)}
</style>
<script src="../assets/js/shared.js"></script>
<script src="../assets/js/auth.js"></script>
<script src="../assets/js/Sailabee.js"></script>
<script>
function showDocName(inputId, nameId, boxId) {
  var f = document.getElementById(inputId).files[0];
  if (!f) return;
  document.getElementById(nameId).innerHTML = '<i class="fas fa-file-check" style="color:#16a34a;margin-right:6px"></i>' + f.name;
  document.getElementById(boxId).classList.add('has-file');
}
function handleDocDrop(e, inputId, nameId, boxId) {
  e.preventDefault();
  document.getElementById(boxId).classList.remove('drag-over');
  var f = e.dataTransfer.files[0];
  if (!f) return;
  var dt = new DataTransfer(); dt.items.add(f);
  document.getElementById(inputId).files = dt.files;
  document.getElementById(nameId).innerHTML = '<i class="fas fa-file-check" style="color:#16a34a;margin-right:6px"></i>' + f.name;
  document.getElementById(boxId).classList.add('has-file');
}
function doRegister() {
  var docFile1 = document.getElementById('docFile1');
  if (!docFile1.files.length) { showToast('Please upload your Company Registration Certificate.', false); return; }
  if (!validateRegisterForm()) return;
  const payload = {
    orgName    :document.getElementById('orgName').value.trim(),
    regNo      :document.getElementById('regNo').value.trim(),
    orgType    :document.getElementById('orgType').value,
    address    :document.getElementById('address').value.trim(),
    contactName:document.getElementById('cpName').value.trim(),
    contactRole:document.getElementById('cpRole').value.trim(),
    email      :document.getElementById('email').value.trim(),
    phone      :document.getElementById('phone').value.trim(),
    password   :document.getElementById('pass').value,
    confirmPassword:document.getElementById('pass2').value,
  };
  fetch('../includes/register_provider.php', {
    method:'POST', headers:{'Content-Type':'application/json'},
    body: JSON.stringify(payload)
  })
  .then(r => r.json())
  .then(data => {
    if (data.success) {
      showToast('Application submitted! Awaiting Ministry approval.');
      setTimeout(()=>window.location.href='login.php',2500);
    } else { showToast(data.message||'Registration failed.',false); }
  })
  .catch(() => {
    const result = EduAuth.registerProvider(payload);
    if (result.success) {
      showToast('Application submitted! Awaiting Ministry approval. (demo mode)');
      setTimeout(()=>window.location.href='login.php',2500);
    } else { showToast(result.message||'Registration failed.',false); }
  });
}
</script>
</body>
</html>