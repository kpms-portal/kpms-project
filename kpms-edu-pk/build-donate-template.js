const fs = require('fs');

// Read the donate HTML
let html = fs.readFileSync('kpms-donate.html', 'utf8');

// 1. Add PHP template header
html = html.replace('<!DOCTYPE html>', `<?php
/*
Template Name: KPMS - Donate
*/
?>
<?php $kpms_nonce = wp_create_nonce('wp_rest'); ?>
<!DOCTYPE html>`);

// 2. Add Amiri font to the existing font link (also add it to the donate page)
// Already included in the donate HTML

// 3. Replace the simplified nav with KPMS main site nav
const oldTopbar = `<!-- TOPBAR -->
<div class="topbar">
  <div class="topbar-left">
    <span>📞 +92 992 383 883</span>
    <span>✉️ <a href="mailto:info@kpms.edu.pk">info@kpms.edu.pk</a></span>
  </div>
  <div class="topbar-right">
    <a href="#" class="parent-portal-btn">PARENT PORTAL</a>
  </div>
</div>

<!-- NAV -->
<nav class="nav" id="mainNav">
  <div class="nav-inner">
    <a href="/" class="nav-logo">
      <div class="nav-logo-icon">
        <svg viewBox="0 0 40 40" fill="none">
          <circle cx="20" cy="20" r="18" stroke="#FFD100" stroke-width="2"/>
          <text x="20" y="26" text-anchor="middle" fill="#FFD100" font-family="Playfair Display" font-size="16" font-weight="700">K</text>
        </svg>
      </div>
      <div>
        <span class="nav-logo-text">Kamal Public</span>
        <span class="nav-logo-sub">Middle School — Abbottabad</span>
      </div>
    </a>
    <div class="nav-links">
      <a href="/">Home</a>
      <a href="/about">About</a>
      <a href="/admissions">Admissions</a>
      <a href="/programs">Programs</a>
      <a href="/donate" class="active">Give</a>
      <a href="/donate" class="donate-nav-btn">Donate Now</a>
    </div>
    <button class="mobile-toggle" id="mobileToggle" aria-label="Menu">
      <span></span><span></span><span></span>
    </button>
  </div>
</nav>`;

const newNav = `<!-- TOPBAR -->
<div class="topbar" role="banner">
  <div class="topbar-left">
    <a href="tel:+923135914700">📞 +92 313 5914700</a>
    <a href="mailto:info@kpms.edu.pk">✉ info@kpms.edu.pk</a>
  </div>
  <div class="topbar-right">
    <div class="topbar-translate">
      🌐 <select onchange="if(this.value)window.open('https://translate.google.com/translate?sl=en&tl='+this.value+'&u='+location.href,'_blank')" aria-label="Translate page">
        <option value="">English</option>
        <option value="ur">اردو</option>
        <option value="ps">پښتو</option>
        <option value="ar">العربية</option>
        <option value="zh">中文</option>
      </select>
    </div>
    <a href="/parent-portal/" class="parent-portal-btn">🔐 Parent Portal</a>
  </div>
</div>

<!-- NAVIGATION -->
<nav class="nav" id="mainNav" role="navigation" aria-label="Main navigation">
  <div class="nav-inner">
    <a href="/" class="nav-logo" aria-label="KPMS Home">
      <div class="nav-logo-icon"><img src="http://kpms.edu.pk/wp-content/uploads/2026/02/Kamal-Public-School-2.png" alt="KPMS Logo"></div>
      <div>
        <span class="nav-logo-text">KPMS</span>
        <span class="nav-logo-sub">Kamal Public Middle School</span>
      </div>
    </a>

    <ul class="nav-menu">
      <li><a href="/">Home</a></li>
      <li>
        <a href="#">About Us <span class="dropdown-arrow">▼</span></a>
        <div class="dropdown">
          <a href="/staff-directory/">Staff Directory</a>
          <a href="/mission-vision/">Mission &amp; Vision</a>
          <a href="/campus/">Our Campus</a>
          <a href="/contact/">Contact</a>
        </div>
      </li>
      <li>
        <a href="#">Calendar <span class="dropdown-arrow">▼</span></a>
        <div class="dropdown">
          <a href="/calendar/">Upcoming Events</a>
          <a href="/calendar/">Past Events</a>
        </div>
      </li>
      <li>
        <a href="#">Academic Programs <span class="dropdown-arrow">▼</span></a>
        <div class="dropdown">
          <a href="/montessori/">Montessori Program</a>
          <a href="/primary-education/">Primary Education</a>
          <a href="/tuition/">Tuition &amp; Tutoring</a>
        </div>
      </li>
      <li>
        <a href="#">Admissions <span class="dropdown-arrow">▼</span></a>
        <div class="dropdown">
          <a href="/apply-online/">Apply Online</a>
          <a href="/prospectus/">View Prospectus</a>
          <a href="/schedule-tour/">Schedule a Tour</a>
        </div>
      </li>
      <li>
        <a href="#">Parents <span class="dropdown-arrow">▼</span></a>
        <div class="dropdown">
          <a href="/parent-portal/">Parent Portal</a>
        </div>
      </li>
      <li>
        <a href="#">Students <span class="dropdown-arrow">▼</span></a>
        <div class="dropdown">
          <a href="/student-resources/">Resources</a>
          <a href="/student-games/">Learning Games</a>
        </div>
      </li>
      <li>
        <a href="#">Support <span class="dropdown-arrow">▼</span></a>
        <div class="dropdown">
          <a href="/donate/">Donate</a>
          <a href="/careers/">Careers</a>
        </div>
      </li>
    </ul>

    <div style="display:flex;align-items:center;gap:8px;">
      <a href="/donate/" class="donate-nav-btn" style="padding:8px 20px;border-radius:50px;font-weight:700;font-size:13px;text-decoration:none;">Donate Now</a>
      <button class="mobile-toggle" onclick="toggleMobile()" aria-label="Open menu">
        <span></span><span></span><span></span>
      </button>
    </div>
  </div>
</nav>

<!-- MOBILE NAV -->
<div class="mobile-nav" id="mobileNav" role="dialog" aria-label="Mobile menu">
  <div class="mobile-nav-header">
    <a href="/" class="nav-logo">
      <div class="nav-logo-icon"><img src="http://kpms.edu.pk/wp-content/uploads/2026/02/Kamal-Public-School-2.png" alt="KPMS Logo"></div>
      <div><span class="nav-logo-text">KPMS</span></div>
    </a>
    <button class="mobile-close" onclick="toggleMobile()" aria-label="Close menu">✕</button>
  </div>
  <div class="mobile-nav-body">
    <a href="/" style="font-family:'Playfair Display',serif; font-size:18px; font-weight:600; color:var(--blue-deep);">Home</a>
    <div class="mobile-section">
      <div class="mobile-section-title">About Us</div>
      <a href="/staff-directory/">Staff Directory</a>
      <a href="/mission-vision/">Mission &amp; Vision</a>
      <a href="/campus/">Our Campus</a>
      <a href="/contact/">Contact</a>
    </div>
    <div class="mobile-section">
      <div class="mobile-section-title">Academic Programs</div>
      <a href="/montessori/">Montessori Program</a>
      <a href="/primary-education/">Primary Education</a>
      <a href="/tuition/">Tuition &amp; Tutoring</a>
    </div>
    <div class="mobile-section">
      <div class="mobile-section-title">Admissions</div>
      <a href="/apply-online/">Apply Online</a>
      <a href="/prospectus/">View Prospectus</a>
      <a href="/schedule-tour/">Schedule a Tour</a>
    </div>
    <div class="mobile-section">
      <div class="mobile-section-title">Parents</div>
      <a href="/parent-portal/">Parent Portal</a>
    </div>
    <div class="mobile-section">
      <div class="mobile-section-title">Students</div>
      <a href="/student-resources/">Resources</a>
      <a href="/student-games/">Learning Games</a>
    </div>
    <div class="mobile-section">
      <div class="mobile-section-title">Support</div>
      <a href="/donate/">Donate</a>
      <a href="/careers/">Careers</a>
    </div>
    <div style="margin-top:20px; padding-top:20px; border-top:2px solid var(--blue-light);">
      <a href="/donate/" style="display:inline-block; background:var(--ramadan-emerald); color:#fff; padding:12px 24px; border-radius:50px; font-weight:700; font-size:14px;">🌙 Donate Now</a>
    </div>
  </div>
</div>`;

html = html.replace(oldTopbar, newNav);

// 4. Add KPMS nav CSS overrides (dropdown, mobile nav, logo) to the existing <style>
const navCSS = `
/* ===== KPMS NAV OVERRIDES ===== */
.nav-logo-icon { width: 56px; height: 56px; border-radius: 50%; overflow: hidden; flex-shrink: 0; }
.nav-logo-icon img { width: 100%; height: 100%; object-fit: cover; }
.nav-menu { display: flex; align-items: center; gap: 0; list-style: none; }
.nav-menu > li { position: relative; }
.nav-menu > li > a {
  display: flex; align-items: center; gap: 5px;
  padding: 24px 18px; text-decoration: none;
  font-size: 14px; font-weight: 600; color: var(--text);
  transition: color 0.3s; position: relative;
}
.nav-menu > li > a::after {
  content: ''; position: absolute; bottom: 0; left: 18px; right: 18px;
  height: 3px; border-radius: 3px 3px 0 0; background: var(--blue);
  transform: scaleX(0); transition: transform 0.3s ease;
}
.nav-menu > li:hover > a { color: var(--blue); }
.nav-menu > li:hover > a::after { transform: scaleX(1); }
.dropdown-arrow { font-size: 8px; transition: transform 0.3s; margin-top: 1px; }
.nav-menu > li:hover .dropdown-arrow { transform: rotate(180deg); }
.dropdown {
  position: absolute; top: 100%; left: 0; min-width: 240px;
  background: var(--white); border-radius: 0 0 12px 12px;
  box-shadow: 0 16px 48px rgba(0,0,0,0.12);
  opacity: 0; visibility: hidden; transform: translateY(-8px);
  transition: opacity 0.15s ease, transform 0.15s ease, visibility 0s 0.15s;
  padding: 8px 0; border-top: 3px solid var(--blue); z-index: 100;
}
.nav-menu > li:hover .dropdown {
  opacity: 1; visibility: visible; transform: translateY(0);
  transition: opacity 0.25s cubic-bezier(0.16, 1, 0.3, 1), transform 0.25s cubic-bezier(0.16, 1, 0.3, 1), visibility 0s;
}
.dropdown a {
  display: block; padding: 12px 24px; text-decoration: none;
  font-size: 14px; font-weight: 500; color: var(--text-muted);
  transition: all 0.2s; border-left: 3px solid transparent;
}
.dropdown a:hover { color: var(--blue); background: var(--blue-light); border-left-color: var(--blue); padding-left: 28px; }
.donate-nav-btn {
  background: var(--ramadan-emerald) !important; color: var(--white) !important;
}
.donate-nav-btn:hover { background: var(--ramadan-emerald-light) !important; transform: translateY(-1px); }
.topbar-translate select {
  background: rgba(255,255,255,0.08); border: 1px solid rgba(255,255,255,0.12);
  border-radius: 4px; padding: 3px 8px; color: rgba(255,255,255,0.6);
  font-size: 11px; font-family: inherit; cursor: pointer; outline: none;
}
.topbar-translate select option { background: var(--blue-deep); color: #fff; }
/* Mobile nav */
.mobile-nav {
  position: fixed; inset: 0; z-index: 9999; background: var(--white);
  opacity: 0; pointer-events: none; transition: opacity 0.3s; overflow-y: auto;
}
.mobile-nav.open { opacity: 1; pointer-events: all; }
.mobile-nav-header {
  display: flex; justify-content: space-between; align-items: center;
  padding: 16px 24px; border-bottom: 1px solid rgba(0,0,0,0.06);
}
.mobile-close { background: none; border: none; font-size: 28px; cursor: pointer; color: var(--text); }
.mobile-nav-body { padding: 24px; }
.mobile-nav-body .mobile-section { margin-bottom: 24px; }
.mobile-section-title {
  font-family: 'Playfair Display', serif; font-size: 16px; font-weight: 600;
  color: var(--blue-deep); padding-bottom: 12px; margin-bottom: 12px;
  border-bottom: 2px solid rgba(0,48,135,0.1);
}
.mobile-nav-body a {
  display: block; padding: 10px 0; text-decoration: none;
  font-size: 15px; color: var(--text-muted); font-weight: 500;
}
.mobile-nav-body a:hover { color: var(--blue); }
@media (max-width: 1024px) { .nav-menu { display: none; } }
@media (min-width: 1025px) { .mobile-toggle { display: none !important; } }

/* ===== DONOR INFO OVERLAY ===== */
.donor-overlay {
  position: fixed; inset: 0; z-index: 10000;
  background: rgba(0,15,43,0.7); backdrop-filter: blur(6px);
  display: flex; align-items: center; justify-content: center;
  opacity: 0; pointer-events: none; transition: opacity 0.3s;
}
.donor-overlay.open { opacity: 1; pointer-events: all; }
.donor-modal {
  background: var(--white); border-radius: 20px; padding: 40px;
  width: 90%; max-width: 480px; max-height: 90vh; overflow-y: auto;
  position: relative; box-shadow: 0 30px 80px rgba(0,0,0,0.3);
}
.donor-modal::before {
  content: ''; position: absolute; top: 0; left: 0; right: 0;
  height: 5px; background: linear-gradient(90deg, var(--gold), var(--ramadan-emerald), var(--gold));
  border-radius: 20px 20px 0 0;
}
.donor-modal h3 {
  font-family: 'Playfair Display', serif; font-size: 22px;
  color: var(--blue-deep); margin-bottom: 6px; text-align: center;
}
.donor-modal .modal-sub {
  text-align: center; color: var(--text-muted); font-size: 14px; margin-bottom: 24px;
}
.donor-field { margin-bottom: 14px; }
.donor-field label {
  display: block; font-size: 13px; font-weight: 600; color: var(--text); margin-bottom: 4px;
}
.donor-field label .req { color: #e74c3c; }
.donor-field input, .donor-field textarea {
  width: 100%; padding: 12px 14px; border: 2px solid #e2e8f0;
  border-radius: 10px; font-size: 14px; font-family: inherit;
  transition: border-color 0.3s; box-sizing: border-box;
}
.donor-field input:focus, .donor-field textarea:focus {
  border-color: var(--ramadan-emerald); outline: none;
}
.donor-check {
  display: flex; align-items: center; gap: 8px;
  font-size: 13px; color: var(--text-muted); margin-bottom: 20px; cursor: pointer;
}
.donor-btn-row { display: flex; gap: 10px; }
.donor-btn-row button {
  flex: 1; padding: 14px; border: none; border-radius: 12px;
  font-size: 15px; font-weight: 700; font-family: inherit; cursor: pointer;
}
.donor-btn-cancel { background: #e9ecef; color: var(--text); }
.donor-btn-submit {
  background: linear-gradient(135deg, var(--ramadan-emerald), var(--ramadan-emerald-light));
  color: var(--white); position: relative;
}
.donor-btn-submit:hover { transform: translateY(-1px); box-shadow: 0 8px 24px rgba(6,78,59,0.3); }
.donor-btn-submit.loading { color: transparent; }
.donor-btn-submit.loading::after {
  content: ''; position: absolute; width: 20px; height: 20px;
  top: 50%; left: 50%; margin: -10px 0 0 -10px;
  border: 2px solid rgba(255,255,255,0.3); border-top-color: #fff;
  border-radius: 50%; animation: donorSpin 0.6s linear infinite;
}
@keyframes donorSpin { to { transform: rotate(360deg); } }
.donor-error {
  background: #f8d7da; color: #721c24; padding: 10px 14px;
  border-radius: 8px; font-size: 13px; margin-bottom: 14px; display: none;
}
/* Success state */
.donor-success { text-align: center; }
.donor-success-icon {
  width: 60px; height: 60px; background: var(--green); color: #fff;
  border-radius: 50%; display: flex; align-items: center; justify-content: center;
  font-size: 28px; margin: 0 auto 16px;
}
.donor-success h3 { margin-bottom: 8px; }
.donor-instructions { background: #f8f9fa; border-radius: 12px; padding: 20px; margin: 16px 0; text-align: left; }
.donor-instructions h4 { color: var(--blue-deep); font-size: 14px; margin-bottom: 12px; }
.donor-method {
  background: var(--white); border: 1px solid #e2e8f0; border-radius: 8px;
  padding: 14px; margin-bottom: 10px;
}
.donor-method h5 { margin: 0 0 6px; color: var(--blue); font-size: 13px; }
.donor-method p { margin: 3px 0; font-size: 13px; color: var(--text-muted); }
.donor-ref-code {
  display: inline-block; background: var(--blue-deep); color: var(--gold);
  padding: 10px 24px; border-radius: 8px; font-family: monospace;
  font-size: 18px; font-weight: 700; letter-spacing: 1px; margin: 8px 0;
}
`;

html = html.replace('</style>', navCSS + '</style>');

// 5. Replace the old footer with KPMS footer
const oldFooter = `<!-- FOOTER -->
<footer class="footer">
  <div class="footer-grid">
    <div class="footer-brand">
      <div style="font-family: 'Playfair Display', serif; font-size: 20px; font-weight: 700; color: #fff;">
        Kamal Public<br>Middle School
      </div>
      <p>Building confidence, critical thinking, and digital empowerment since 1984. Serving the children of Abbottabad, Pakistan.</p>
    </div>
    <div>
      <h4>Quick Links</h4>
      <ul class="footer-links">
        <li><a href="/">Home</a></li>
        <li><a href="/about">About KPMS</a></li>
        <li><a href="/admissions">Admissions</a></li>
        <li><a href="/programs">Academic Programs</a></li>
        <li><a href="/donate">Give / Donate</a></li>
      </ul>
    </div>
    <div>
      <h4>Contact</h4>
      <ul class="footer-links">
        <li>Abbottabad, KPK</li>
        <li>Pakistan</li>
        <li><a href="tel:+92992383883">+92 992 383 883</a></li>
        <li><a href="mailto:info@kpms.edu.pk">info@kpms.edu.pk</a></li>
      </ul>
    </div>
    <div>
      <h4>For Donors</h4>
      <ul class="footer-links">
        <li><a href="#">Zakat Guidelines</a></li>
        <li><a href="#">Impact Reports</a></li>
        <li><a href="#">Financial Transparency</a></li>
        <li><a href="#">Wire Transfer Info</a></li>
      </ul>
    </div>
  </div>
  <div class="footer-bottom">
    <span>© 2026 Kamal Public Middle School. All rights reserved. | <a href="#">Privacy</a> · <a href="#">Accessibility</a></span>
    <div class="footer-social">
      <a href="#" title="Facebook">f</a>
      <a href="#" title="Instagram">ig</a>
      <a href="#" title="YouTube">▶</a>
      <a href="#" title="WhatsApp">wa</a>
    </div>
  </div>
</footer>`;

const newFooter = `<!-- FOOTER -->
<footer class="footer">
  <div class="footer-grid" style="max-width:1200px;margin:0 auto;">
    <div>
      <div style="display:flex;align-items:center;gap:12px;margin-bottom:16px;">
        <div style="width:56px;height:56px;border-radius:50%;overflow:hidden;flex-shrink:0;"><img src="http://kpms.edu.pk/wp-content/uploads/2026/02/Kamal-Public-School-2.png" alt="KPMS" style="width:100%;height:100%;object-fit:cover;"></div>
        <div style="font-family:'Playfair Display',serif;font-size:20px;font-weight:700;color:#fff;">KPMS</div>
      </div>
      <p>Kamal Public Middle School has been cultivating curiosity and building character in Abbottabad's young learners since 1985.</p>
      <p style="margin-top:10px;">📍 Sheikh ul Bandi, Abbottabad, KPK</p>
      <p>📞 +92 313 5914700</p>
      <p>✉ info@kpms.edu.pk</p>
    </div>
    <div>
      <h4>Quick Links</h4>
      <ul class="footer-links">
        <li><a href="/">Home</a></li>
        <li><a href="/mission-vision/">About KPMS</a></li>
        <li><a href="/apply-online/">Admissions</a></li>
        <li><a href="/donate/">Donate</a></li>
        <li><a href="/contact/">Contact</a></li>
      </ul>
    </div>
    <div>
      <h4>For Donors</h4>
      <ul class="footer-links">
        <li><a href="/donate/">Give Zakat</a></li>
        <li><a href="/donate/">Impact Reports</a></li>
        <li><a href="/donate/">Financial Transparency</a></li>
        <li><a href="/donate/">Wire Transfer Info</a></li>
      </ul>
    </div>
    <div>
      <h4>Programs</h4>
      <ul class="footer-links">
        <li><a href="/montessori/">Montessori</a></li>
        <li><a href="/primary-education/">Primary Education</a></li>
        <li><a href="/tuition/">Tuition & Tutoring</a></li>
        <li><a href="/careers/">Careers</a></li>
      </ul>
    </div>
  </div>
  <div class="footer-bottom" style="max-width:1200px;margin:0 auto;">
    <span>© 1985–2026 Kamal Public Middle School Abbottabad. All Rights Reserved.</span>
    <span><a href="/">Privacy</a> · <a href="/">Terms</a> · <a href="/">Accessibility</a></span>
  </div>
</footer>`;

html = html.replace(oldFooter, newFooter);

// 6. Add the donor info modal before closing </body>
const donorModal = `
<!-- DONOR INFO MODAL -->
<div class="donor-overlay" id="donorOverlay">
  <div class="donor-modal" id="donorModal">
    <!-- Form State -->
    <div id="donorFormState">
      <h3>Complete Your Donation</h3>
      <p class="modal-sub">You're giving <strong id="modalAmount"></strong> as <strong id="modalType"></strong></p>
      <div class="donor-error" id="donorError"></div>
      <div class="donor-field">
        <label>Full Name <span class="req">*</span></label>
        <input type="text" id="donorName" placeholder="Your full name">
      </div>
      <div class="donor-field">
        <label>Email <span class="req">*</span></label>
        <input type="email" id="donorEmail" placeholder="your@email.com">
      </div>
      <div class="donor-field">
        <label>Phone</label>
        <input type="tel" id="donorPhone" placeholder="(optional)">
      </div>
      <div class="donor-field">
        <label>Message (optional)</label>
        <textarea id="donorMessage" rows="2" placeholder="Leave a message of support..."></textarea>
      </div>
      <label class="donor-check">
        <input type="checkbox" id="donorAnon"> Make my donation anonymous
      </label>
      <div class="donor-btn-row">
        <button class="donor-btn-cancel" onclick="closeDonorModal()">Cancel</button>
        <button class="donor-btn-submit" id="donorSubmitBtn" onclick="submitDonation()">Donate Now</button>
      </div>
    </div>
    <!-- Success State -->
    <div id="donorSuccessState" class="donor-success" style="display:none;">
      <div class="donor-success-icon">&#10003;</div>
      <h3>JazakAllah Khair!</h3>
      <p class="modal-sub">Your donation pledge has been recorded.</p>
      <div class="donor-instructions">
        <h4>Send Your Payment</h4>
        <div id="successZelle" class="donor-method"></div>
        <div id="successWire" class="donor-method"></div>
        <div style="text-align:center;margin-top:14px;">
          <strong style="font-size:12px;color:var(--text-muted);">Reference Code:</strong><br>
          <span class="donor-ref-code" id="successRef"></span><br>
          <small style="color:var(--text-muted);">Include this in your payment memo</small>
        </div>
      </div>
      <p style="font-size:12px;color:var(--text-muted);margin-top:12px;">You will receive an email confirmation once your payment has been verified. 100% of your donation goes directly to educating children at KPMS.</p>
      <button class="donor-btn-cancel" onclick="closeDonorModal()" style="width:100%;margin-top:16px;padding:12px;border-radius:10px;">Close</button>
    </div>
  </div>
</div>
`;

html = html.replace('</body>', donorModal + '</body>');

// 7. Replace the old JavaScript with API-integrated version
const oldScript = `<script>
// ===== DONATION CARD LOGIC =====
const amountBtns = document.querySelectorAll('.amount-btn');
const customInput = document.getElementById('customAmount');
const donateBtn = document.getElementById('donateBtn');
const zakatToggle = document.getElementById('zakatToggle');
let selectedAmount = 100;
let isZakat = true;

function updateDonateBtn() {
  const label = isZakat ? 'Zakat' : 'Sadaqah';
  const amt = selectedAmount ? \`\$\${selectedAmount.toLocaleString()}\` : '';
  donateBtn.textContent = '';
  const shimmer = document.createElement('span');
  shimmer.className = 'btn-shimmer';
  donateBtn.appendChild(shimmer);
  donateBtn.appendChild(document.createTextNode(
    amt ? \`Give \${amt} via Zelle — Zero Fees\` : 'Enter an Amount'
  ));
}

amountBtns.forEach(btn => {
  btn.addEventListener('click', () => {
    amountBtns.forEach(b => b.classList.remove('selected'));
    btn.classList.add('selected');
    selectedAmount = parseInt(btn.dataset.amount);
    customInput.value = '';
    updateDonateBtn();
  });
});

customInput.addEventListener('input', () => {
  amountBtns.forEach(b => b.classList.remove('selected'));
  selectedAmount = parseInt(customInput.value) || 0;
  updateDonateBtn();
});

zakatToggle.addEventListener('click', () => {
  isZakat = !isZakat;
  zakatToggle.classList.toggle('active', isZakat);
  updateDonateBtn();
});

donateBtn.addEventListener('click', () => {
  if (!selectedAmount) return;
  // Show payment instructions modal or redirect
  const zakatText = isZakat ? ' (Zakat)' : ' (Sadaqah)';
  const msg = \`Thank you for choosing to give \$\${selectedAmount.toLocaleString()}\${zakatText}!\\n\\n\` +
    \`To complete your donation with ZERO fees:\\n\\n\` +
    \`📱 Zelle: Send to donate@kpms.edu.pk\\n\` +
    \`🏦 Wire Transfer: Contact info@kpms.edu.pk for bank details\\n\\n\` +
    \`Please include "\${isZakat ? 'ZAKAT' : 'SADAQAH'}-\${Date.now().toString(36).toUpperCase()}" as your memo.\\n\\n\` +
    \`You will receive a confirmation receipt within 24 hours.\`;
  alert(msg);
});

// ===== FAQ ACCORDION =====
document.querySelectorAll('.faq-question').forEach(q => {
  q.addEventListener('click', () => {
    const item = q.parentElement;
    const answer = item.querySelector('.faq-answer');
    const isOpen = item.classList.contains('open');

    // Close all
    document.querySelectorAll('.faq-item.open').forEach(openItem => {
      openItem.classList.remove('open');
      openItem.querySelector('.faq-answer').style.maxHeight = '0';
    });

    // Open clicked (if wasn't open)
    if (!isOpen) {
      item.classList.add('open');
      answer.style.maxHeight = answer.scrollHeight + 'px';
    }
  });
});

// ===== SCROLL REVEAL =====
const revealObserver = new IntersectionObserver((entries) => {
  entries.forEach(entry => {
    if (entry.isIntersecting) {
      entry.target.classList.add('visible');
    }
  });
}, { threshold: 0.1, rootMargin: '0px 0px -40px 0px' });

document.querySelectorAll('.reveal').forEach(el => revealObserver.observe(el));

// ===== NAV SCROLL EFFECT =====
const nav = document.getElementById('mainNav');
window.addEventListener('scroll', () => {
  nav.classList.toggle('scrolled', window.scrollY > 30);
});

// ===== FLOATING PROGRESS WIDGET =====
const progressFloat = document.getElementById('progressFloat');
window.addEventListener('scroll', () => {
  progressFloat.classList.toggle('visible', window.scrollY > 600);
});

// ===== SMOOTH SCROLL TO TOP (CTA) =====
document.querySelector('.cta-donate-btn').addEventListener('click', (e) => {
  e.preventDefault();
  window.scrollTo({ top: 0, behavior: 'smooth' });
});
</script>`;

const newScript = `<script>
const API_BASE = '<?php echo esc_url(rest_url("kpms/v1/")); ?>';
const WP_NONCE = '<?php echo $kpms_nonce; ?>';

// ===== DONATION CARD LOGIC =====
const amountBtns = document.querySelectorAll('.amount-btn');
const customInput = document.getElementById('customAmount');
const donateBtn = document.getElementById('donateBtn');
const zakatToggle = document.getElementById('zakatToggle');
let selectedAmount = 100;
let isZakat = true;

function updateDonateBtn() {
  const amt = selectedAmount ? '$' + selectedAmount.toLocaleString() : '';
  donateBtn.textContent = '';
  const shimmer = document.createElement('span');
  shimmer.className = 'btn-shimmer';
  donateBtn.appendChild(shimmer);
  donateBtn.appendChild(document.createTextNode(
    amt ? 'Give ' + amt + ' via Zelle — Zero Fees' : 'Enter an Amount'
  ));
}

amountBtns.forEach(function(btn) {
  btn.addEventListener('click', function() {
    amountBtns.forEach(function(b) { b.classList.remove('selected'); });
    btn.classList.add('selected');
    selectedAmount = parseInt(btn.dataset.amount);
    customInput.value = '';
    updateDonateBtn();
  });
});

customInput.addEventListener('input', function() {
  amountBtns.forEach(function(b) { b.classList.remove('selected'); });
  selectedAmount = parseInt(customInput.value) || 0;
  updateDonateBtn();
});

zakatToggle.addEventListener('click', function() {
  isZakat = !isZakat;
  zakatToggle.classList.toggle('active', isZakat);
  updateDonateBtn();
});

// Open donor info modal instead of alert
donateBtn.addEventListener('click', function() {
  if (!selectedAmount || selectedAmount < 1) return;
  document.getElementById('modalAmount').textContent = '$' + selectedAmount.toLocaleString();
  document.getElementById('modalType').textContent = isZakat ? 'Zakat' : 'Sadaqah';
  document.getElementById('donorFormState').style.display = 'block';
  document.getElementById('donorSuccessState').style.display = 'none';
  document.getElementById('donorError').style.display = 'none';
  document.getElementById('donorOverlay').classList.add('open');
});

function closeDonorModal() {
  document.getElementById('donorOverlay').classList.remove('open');
}

// Close on overlay click
document.getElementById('donorOverlay').addEventListener('click', function(e) {
  if (e.target === this) closeDonorModal();
});

// Submit donation to REST API
function submitDonation() {
  var name = document.getElementById('donorName').value.trim();
  var email = document.getElementById('donorEmail').value.trim();
  var phone = document.getElementById('donorPhone').value.trim();
  var message = document.getElementById('donorMessage').value.trim();
  var anon = document.getElementById('donorAnon').checked;
  var errEl = document.getElementById('donorError');
  var btn = document.getElementById('donorSubmitBtn');

  errEl.style.display = 'none';
  if (!name) { errEl.textContent = 'Please enter your name.'; errEl.style.display = 'block'; return; }
  if (!email || !email.match(/^[^\\s@]+@[^\\s@]+\\.[^\\s@]+$/)) { errEl.textContent = 'Please enter a valid email.'; errEl.style.display = 'block'; return; }

  btn.classList.add('loading');
  btn.disabled = true;

  fetch(API_BASE + 'donate/pledge', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json', 'X-WP-Nonce': WP_NONCE },
    body: JSON.stringify({
      donor_name: name, donor_email: email, donor_phone: phone,
      amount: selectedAmount, donation_type: isZakat ? 'zakat' : 'sadaqah',
      donor_message: message, is_anonymous: anon, campaign: 'ramadan-2026'
    })
  })
  .then(function(r) { return r.json(); })
  .then(function(data) {
    btn.classList.remove('loading');
    btn.disabled = false;
    if (data.code) { errEl.textContent = data.message || 'Something went wrong.'; errEl.style.display = 'block'; return; }

    // Show success
    document.getElementById('donorFormState').style.display = 'none';
    document.getElementById('donorSuccessState').style.display = 'block';
    document.getElementById('successRef').textContent = data.reference;

    // Zelle info
    var zelleEl = document.getElementById('successZelle');
    if (data.zelle && (data.zelle.email || data.zelle.phone)) {
      var zh = '<h5>Zelle</h5>';
      if (data.zelle.name) zh += '<p><strong>To:</strong> ' + esc(data.zelle.name) + '</p>';
      if (data.zelle.email) zh += '<p><strong>Email:</strong> ' + esc(data.zelle.email) + '</p>';
      if (data.zelle.phone) zh += '<p><strong>Phone:</strong> ' + esc(data.zelle.phone) + '</p>';
      zh += '<p><strong>Memo:</strong> ' + esc(data.reference) + '</p>';
      zelleEl.innerHTML = zh;
    } else { zelleEl.style.display = 'none'; }

    // Wire info
    var wireEl = document.getElementById('successWire');
    if (data.wire && data.wire.bank_name) {
      var wh = '<h5>Wire Transfer</h5>';
      wh += '<p><strong>Bank:</strong> ' + esc(data.wire.bank_name) + '</p>';
      if (data.wire.account_name) wh += '<p><strong>Account Name:</strong> ' + esc(data.wire.account_name) + '</p>';
      if (data.wire.routing_number) wh += '<p><strong>Routing:</strong> ' + esc(data.wire.routing_number) + '</p>';
      if (data.wire.account_number) wh += '<p><strong>Account:</strong> ' + esc(data.wire.account_number) + '</p>';
      if (data.wire.swift_code) wh += '<p><strong>SWIFT:</strong> ' + esc(data.wire.swift_code) + '</p>';
      wh += '<p><strong>Memo:</strong> ' + esc(data.reference) + '</p>';
      wireEl.innerHTML = wh;
    } else { wireEl.style.display = 'none'; }

    loadProgress();
  })
  .catch(function() {
    btn.classList.remove('loading'); btn.disabled = false;
    errEl.textContent = 'Network error. Please try again.'; errEl.style.display = 'block';
  });
}

function esc(s) { var d = document.createElement('div'); d.appendChild(document.createTextNode(s)); return d.innerHTML; }

// ===== FAQ ACCORDION =====
document.querySelectorAll('.faq-question').forEach(function(q) {
  q.addEventListener('click', function() {
    var item = q.parentElement;
    var answer = item.querySelector('.faq-answer');
    var isOpen = item.classList.contains('open');
    document.querySelectorAll('.faq-item.open').forEach(function(openItem) {
      openItem.classList.remove('open');
      openItem.querySelector('.faq-answer').style.maxHeight = '0';
    });
    if (!isOpen) { item.classList.add('open'); answer.style.maxHeight = answer.scrollHeight + 'px'; }
  });
});

// ===== SCROLL REVEAL =====
var revealObserver = new IntersectionObserver(function(entries) {
  entries.forEach(function(entry) { if (entry.isIntersecting) entry.target.classList.add('visible'); });
}, { threshold: 0.1, rootMargin: '0px 0px -40px 0px' });
document.querySelectorAll('.reveal').forEach(function(el) { revealObserver.observe(el); });

// ===== NAV SCROLL EFFECT =====
window.addEventListener('scroll', function() {
  document.getElementById('mainNav').classList.toggle('scrolled', window.scrollY > 30);
});

// ===== MOBILE NAV =====
function toggleMobile() { document.getElementById('mobileNav').classList.toggle('open'); }
document.addEventListener('keydown', function(e) {
  if (e.key === 'Escape') { document.getElementById('mobileNav').classList.remove('open'); closeDonorModal(); }
});

// ===== FLOATING PROGRESS WIDGET + API =====
var progressFloat = document.getElementById('progressFloat');
window.addEventListener('scroll', function() {
  progressFloat.classList.toggle('visible', window.scrollY > 600);
});

function loadProgress() {
  fetch(API_BASE + 'campaign/progress?campaign=ramadan-2026')
    .then(function(r) { return r.json(); })
    .then(function(d) {
      // Update floating widget
      document.querySelector('.progress-float-amount').textContent = '$' + Number(d.total_raised).toLocaleString() + ' / $' + Number(d.goal_amount).toLocaleString();
      document.querySelector('.progress-bar-fill').style.width = Math.min(d.percent, 100) + '%';
      document.querySelector('.progress-float-sub').textContent = d.total_donors + ' donor' + (d.total_donors !== 1 ? 's' : '') + ' so far — be the next';
      // Update hero stats
      var statVals = document.querySelectorAll('.hero-stat-value');
      if (statVals.length >= 3 && d.total_raised > 0) {
        // Only update if there are actual donations
      }
    }).catch(function(){});
}
loadProgress();

// ===== SMOOTH SCROLL TO TOP (CTA) =====
document.querySelector('.cta-donate-btn').addEventListener('click', function(e) {
  e.preventDefault();
  window.scrollTo({ top: 0, behavior: 'smooth' });
});
</script>`;

html = html.replace(oldScript, newScript);

fs.writeFileSync('page-donate.php', html, 'utf8');
console.log('OK: page-donate.php created (' + html.length + ' chars)');
