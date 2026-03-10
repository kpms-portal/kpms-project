<?php
/*
Template Name: KPMS - Apply Online
*/
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Apply Online – KPMS | Kamal Public Middle School Abbottabad</title>
<?php include get_stylesheet_directory() . '/analytics.php'; ?>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400;1,500;1,600&family=DM+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<style>
:root {
  --blue: #003087;
  --blue-deep: #001f5c;
  --blue-light: #1a5fcc;
  --blue-bright: #2878e6;
  --gold: #FFD100;
  --gold-light: #FFE04A;
  --gold-warm: #FFC520;
  --coral: #E8443A;
  --sky: #00AEEF;
  --navy: #001840;
  --navy-deep: #000f2b;
  --cream: #f5f7fb;
  --cream-warm: #edf1f8;
  --white: #ffffff;
  --text: #0a1e3d;
  --text-muted: #4a5e7a;
  --ice: #e0eaff;
  --ice-light: #d0ddf5;
}

*{margin:0;padding:0;box-sizing:border-box}
html{scroll-behavior:smooth}
body{font-family:'DM Sans',sans-serif;color:var(--text);background:var(--white);overflow-x:hidden}

/* ===== SKIP LINK (accessibility) ===== */
.skip-link {
  position: absolute; top: -100px; left: 16px;
  background: var(--gold); color: var(--navy-deep);
  padding: 12px 24px; font-weight: 700; border-radius: 0 0 8px 8px;
  z-index: 10000; transition: top 0.3s; text-decoration: none;
}
.skip-link:focus { top: 0; }

/* ===== TOPBAR ===== */
.topbar {
  background: var(--navy-deep);
  padding: 6px 60px;
  display: flex; justify-content: space-between; align-items: center;
  font-size: 12px; color: rgba(255,255,255,0.6);
}
.topbar-left { display: flex; gap: 20px; align-items: center; }
.topbar-right { display: flex; gap: 14px; align-items: center; }
.topbar a {
  color: rgba(255,255,255,0.6); text-decoration: none;
  transition: color 0.3s;
}
.topbar a:hover { color: var(--gold); }
.topbar-translate select {
  background: rgba(255,255,255,0.08);
  border: 1px solid rgba(255,255,255,0.12);
  border-radius: 4px; padding: 3px 8px;
  color: rgba(255,255,255,0.6); font-size: 11px;
  font-family: inherit; cursor: pointer; outline: none;
}
.topbar-translate select option { background: var(--navy-deep); color: #fff; }
.parent-portal-btn {
  background: var(--gold); color: var(--navy-deep) !important;
  padding: 3px 12px; border-radius: 4px;
  font-weight: 700; font-size: 11px;
  letter-spacing: 0.5px; transition: all 0.3s;
}
.parent-portal-btn:hover { background: var(--gold-light); }

/* ===== NAV ===== */
.nav {
  position: sticky; top: 0; z-index: 1000;
  background: var(--white);
  box-shadow: 0 1px 0 rgba(0,0,0,0.06);
  transition: box-shadow 0.3s;
}
.nav.scrolled { box-shadow: 0 4px 30px rgba(0,0,0,0.08); }
.nav-inner {
  max-width: 1400px; margin: 0 auto;
  padding: 0 60px;
  height: 85px;
  display: flex; align-items: center; justify-content: space-between;
}
.nav-logo { display: flex; align-items: center; gap: 14px; text-decoration: none; }
.nav-logo-icon {
  width: 80px; height: 80px;
  border-radius: 50%;
  overflow: hidden;
  flex-shrink: 0;
}
.nav-logo-icon img {
  width: 100%; height: 100%;
  object-fit: cover;
}
.nav-logo-text {
  font-family: 'Playfair Display', serif;
  font-size: 22px; font-weight: 600;
  color: var(--blue-deep);
}
.nav-logo-sub {
  font-size: 11px; font-weight: 500;
  color: var(--text-muted);
  letter-spacing: 0.5px;
  display: block; margin-top: -2px;
}

/* Desktop Dropdown Menus */
.nav-menu { display: flex; align-items: center; gap: 0; list-style: none; }
.nav-menu > li { position: relative; }
.nav-menu > li > a {
  display: flex; align-items: center; gap: 5px;
  padding: 24px 22px;
  text-decoration: none;
  font-size: 15px; font-weight: 600;
  color: var(--text);
  letter-spacing: 0.3px;
  transition: color 0.3s;
  position: relative;
}
.nav-menu > li > a::after {
  content: '';
  position: absolute; bottom: 0; left: 22px; right: 22px;
  height: 3px; border-radius: 3px 3px 0 0;
  background: var(--blue);
  transform: scaleX(0);
  transition: transform 0.3s ease;
}
.nav-menu > li:hover > a { color: var(--blue); }
.nav-menu > li:hover > a::after { transform: scaleX(1); }
.dropdown-arrow {
  font-size: 8px; transition: transform 0.3s; margin-top: 1px;
}
.nav-menu > li:hover .dropdown-arrow { transform: rotate(180deg); }

/* Dropdown */
.dropdown {
  position: absolute; top: 100%; left: 0;
  min-width: 260px;
  background: var(--white);
  border-radius: 0 0 12px 12px;
  box-shadow: 0 16px 48px rgba(0,0,0,0.12);
  opacity: 0; visibility: hidden;
  transform: translateY(-8px);
  transition: opacity 0.15s ease, transform 0.15s ease, visibility 0s 0.15s;
  padding: 8px 0;
  border-top: 3px solid var(--blue);
  z-index: 1;
}
.nav-menu > li:hover .dropdown {
  opacity: 1; visibility: visible; transform: translateY(0);
  transition: opacity 0.25s cubic-bezier(0.16, 1, 0.3, 1), transform 0.25s cubic-bezier(0.16, 1, 0.3, 1), visibility 0s;
  z-index: 100;
}
.dropdown a {
  display: block;
  padding: 12px 24px;
  text-decoration: none;
  font-size: 14px; font-weight: 500;
  color: var(--text-muted);
  transition: all 0.2s;
  border-left: 3px solid transparent;
}
.dropdown a:hover {
  color: var(--blue);
  background: var(--ice);
  border-left-color: var(--blue);
  padding-left: 28px;
}

/* Mobile hamburger button */
.mobile-toggle { display: none; cursor: pointer; background: none; border: none; padding: 8px; }
.mobile-toggle span { display: block; width: 22px; height: 2px; background: var(--text); margin: 5px 0; transition: all 0.3s; border-radius: 2px; }

<?php include get_stylesheet_directory() . '/mobile-menu-css.php'; ?>

/* ===== SEARCH OVERLAY ===== */
.search-overlay {
  position: fixed; inset: 0; z-index: 9998;
  background: rgba(0,15,43,0.85);
  backdrop-filter: blur(8px);
  display: flex; align-items: flex-start; justify-content: center;
  padding-top: 140px;
  opacity: 0; pointer-events: none;
  transition: opacity 0.3s;
}
.search-overlay.open { opacity: 1; pointer-events: all; }
.search-box { width: 90%; max-width: 680px; position: relative; }
.search-box input {
  width: 100%; padding: 20px 60px 20px 24px;
  border: none; border-radius: 14px;
  font-family: 'DM Sans', sans-serif;
  font-size: 20px; font-weight: 500;
  color: var(--text); outline: none;
  box-shadow: 0 20px 60px rgba(0,0,0,0.3);
}
.search-box input::placeholder { color: var(--text-muted); }
.search-close {
  position: absolute; right: 16px; top: 50%; transform: translateY(-50%);
  background: none; border: none; font-size: 26px;
  color: var(--text-muted); cursor: pointer; padding: 4px 8px;
}
.search-hint { text-align: center; margin-top: 14px; font-size: 13px; color: rgba(255,255,255,0.45); }

/* Nav search button */
.nav-search-btn {
  background: none; border: none; cursor: pointer; padding: 8px;
  display: flex; align-items: center; color: var(--text-muted);
  transition: color 0.3s;
}
.nav-search-btn:hover { color: var(--blue); }
.nav-search-btn svg { width: 20px; height: 20px; }

/* ===== HERO ===== */
@keyframes fadeUp {
  from { opacity: 0; transform: translateY(28px); }
  to { opacity: 1; transform: translateY(0); }
}

/* ===== SECTION STYLES ===== */
.section-label {
  font-size: 12px; font-weight: 700;
  letter-spacing: 3px; text-transform: uppercase;
  color: var(--blue);
  margin-bottom: 12px;
}
.section-title {
  font-family: 'Playfair Display', serif;
  font-size: clamp(26px, 3.5vw, 38px);
  font-weight: 500;
  color: var(--text);
  line-height: 1.25;
}
.section-subtitle {
  font-size: 18px;
  color: var(--text-muted);
  margin-top: 10px;
}

/* ===== BTN ===== */
.btn {
  padding: 14px 36px;
  border-radius: 8px;
  font-family: 'DM Sans', sans-serif;
  font-size: 14px; font-weight: 700;
  letter-spacing: 0.8px; text-transform: uppercase;
  text-decoration: none;
  cursor: pointer; border: none;
  transition: all 0.35s cubic-bezier(0.16, 1, 0.3, 1);
}
.btn-gold {
  background: var(--gold);
  color: var(--navy-deep);
}
.btn-gold:hover {
  background: var(--gold-light);
  transform: translateY(-2px);
  box-shadow: 0 8px 24px rgba(245,166,35,0.35);
}

/* ===== FOOTER ===== */
.footer {
  padding: 70px 60px 36px;
  background: var(--navy-deep);
}
.footer-inner { max-width: 1200px; margin: 0 auto; }
.footer-grid {
  display: grid;
  grid-template-columns: 2fr 1fr 1fr 1fr;
  gap: 50px;
  padding-bottom: 50px;
  border-bottom: 1px solid rgba(255,255,255,0.06);
}
.footer-brand { display: flex; align-items: center; gap: 12px; margin-bottom: 16px; }
.footer-brand-icon {
  width: 90px; height: 90px;
  border-radius: 50%;
  overflow: hidden;
  flex-shrink: 0;
}
.footer-brand-icon img {
  width: 100%; height: 100%;
  object-fit: cover;
}
.footer-brand-name {
  font-family: 'Playfair Display', serif;
  font-size: 20px; font-weight: 600; color: var(--white);
}
.footer-desc {
  font-size: 14px; color: rgba(255,255,255,0.45);
  line-height: 1.7; margin-bottom: 20px;
}
.footer-contact {
  font-size: 13px; color: rgba(255,255,255,0.5);
  margin-bottom: 6px;
}
.footer-heading {
  font-family: 'Playfair Display', serif;
  font-size: 15px; font-weight: 600;
  color: var(--white); margin-bottom: 20px;
}
.footer-links { list-style: none; }
.footer-links li { margin-bottom: 10px; }
.footer-links a {
  text-decoration: none;
  font-size: 13px; color: rgba(255,255,255,0.45);
  transition: all 0.3s;
}
.footer-links a:hover { color: var(--gold-light); padding-left: 4px; }
.footer-bottom {
  padding-top: 28px;
  display: flex; justify-content: space-between; align-items: center;
  flex-wrap: wrap; gap: 16px;
}
.footer-copy { font-size: 12px; color: rgba(255,255,255,0.25); }
.footer-legal { display: flex; gap: 20px; }
.footer-legal a {
  text-decoration: none;
  font-size: 12px; color: rgba(255,255,255,0.25);
  transition: color 0.3s;
}
.footer-legal a:hover { color: var(--gold-light); }
.footer-social { display: flex; gap: 14px; }
.footer-social a {
  width: 40px; height: 40px;
  border-radius: 50%;
  display: flex; align-items: center; justify-content: center;
  text-decoration: none;
  transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
  position: relative;
}
.footer-social a:hover {
  transform: translateY(-5px) scale(1.15);
}
.footer-social a.fb { background: #1877F2; }
.footer-social a.fb:hover { box-shadow: 0 8px 25px rgba(24,119,242,0.5); }
.footer-social a.ig { background: linear-gradient(45deg, #f09433, #e6683c, #dc2743, #cc2366, #bc1888); }
.footer-social a.ig:hover { box-shadow: 0 8px 25px rgba(225,48,108,0.5); }
.footer-social a.yt { background: #FF0000; }
.footer-social a.yt:hover { box-shadow: 0 8px 25px rgba(255,0,0,0.5); }
.footer-social a.wa { background: #25D366; }
.footer-social a.wa:hover { box-shadow: 0 8px 25px rgba(37,211,102,0.5); }
.footer-social a svg { width: 20px; height: 20px; fill: white; }

/* ===== SCROLL REVEAL ===== */
.reveal {
  opacity: 0; transform: translateY(36px);
  transition: all 0.7s cubic-bezier(0.16,1,0.3,1);
}
.reveal.visible { opacity: 1; transform: translateY(0); }
.reveal-d1 { transition-delay: 0.1s; }
.reveal-d2 { transition-delay: 0.2s; }
.reveal-d3 { transition-delay: 0.3s; }
.reveal-d4 { transition-delay: 0.4s; }
.reveal-d5 { transition-delay: 0.5s; }

/* ===== INNER PAGE STYLES ===== */
.page-hero {
  background: linear-gradient(160deg, rgba(0,24,64,0.88) 0%, rgba(0,48,135,0.7) 50%, rgba(0,24,64,0.82) 100%),
    url('https://images.unsplash.com/photo-1503676260728-1c00da094a0b?w=1920&q=85') center/cover;
  padding: 140px 60px 80px;
  text-align: center;
  position: relative;
}
.page-hero-label {
  font-size: 12px; font-weight: 700;
  letter-spacing: 3px; text-transform: uppercase;
  color: var(--gold-light);
  margin-bottom: 12px;
}
.page-hero-title {
  font-family: 'Playfair Display', serif;
  font-size: clamp(32px, 4vw, 48px);
  font-weight: 500; color: var(--white);
  line-height: 1.2; margin-bottom: 16px;
}
.page-hero-subtitle {
  font-size: 18px; color: rgba(255,255,255,0.7);
  max-width: 600px; margin: 0 auto;
}
.page-breadcrumb {
  margin-top: 20px; font-size: 13px; color: rgba(255,255,255,0.5);
}
.page-breadcrumb a { color: rgba(255,255,255,0.7); text-decoration: none; }
.page-breadcrumb a:hover { color: var(--gold-light); }

/* Page Content Area */
.page-content {
  max-width: 1100px; margin: 0 auto;
  padding: 80px 60px;
}
.page-content h2 {
  font-family: 'Playfair Display', serif;
  font-size: 28px; font-weight: 500;
  color: var(--text); margin-bottom: 16px;
}
.page-content h3 {
  font-size: 20px; font-weight: 700;
  color: var(--blue-deep); margin-bottom: 10px; margin-top: 32px;
}
.page-content p {
  font-size: 16px; line-height: 1.8;
  color: var(--text-muted); margin-bottom: 20px;
}
.page-content ul {
  list-style: none; padding: 0;
}
.page-content ul li {
  padding: 8px 0 8px 24px;
  position: relative; color: var(--text-muted);
  font-size: 15px;
}
.page-content ul li::before {
  content: '\2726'; position: absolute; left: 0;
  color: var(--gold); font-size: 12px;
}

/* Info Cards Grid */
.info-cards {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
  gap: 24px; margin: 40px 0;
}
.info-card {
  background: var(--white);
  border: 2px solid var(--ice);
  border-radius: 16px;
  padding: 32px;
  transition: all 0.3s;
}
.info-card:hover {
  border-color: var(--blue-light);
  box-shadow: 0 12px 40px rgba(0,48,135,0.08);
  transform: translateY(-4px);
}
.info-card-icon {
  font-size: 36px; margin-bottom: 16px;
  display: block;
}
.info-card h3 {
  font-family: 'Playfair Display', serif;
  font-size: 20px; font-weight: 600;
  color: var(--text); margin: 0 0 10px;
}
.info-card p {
  font-size: 14px; color: var(--text-muted);
  line-height: 1.7; margin: 0;
}

/* Form Styles */
.kpms-form {
  max-width: 700px;
  margin: 40px auto;
}
.form-group {
  margin-bottom: 24px;
}
.form-group label {
  display: block; font-size: 14px; font-weight: 600;
  color: var(--text); margin-bottom: 6px;
}
.form-group input,
.form-group select,
.form-group textarea {
  width: 100%; padding: 14px 18px;
  border: 2px solid var(--ice);
  border-radius: 10px;
  font-size: 15px; font-family: inherit;
  color: var(--text);
  transition: border-color 0.3s, box-shadow 0.3s;
  background: var(--white);
}
.form-group input:focus,
.form-group select:focus,
.form-group textarea:focus {
  outline: none;
  border-color: var(--blue);
  box-shadow: 0 0 0 3px rgba(0,48,135,0.1);
}
.form-row {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 16px;
}

/* ===== APPLICATION STEPS TIMELINE ===== */
.steps-section {
  padding: 80px 60px;
  background: var(--cream-warm);
}
.steps-inner {
  max-width: 1100px; margin: 0 auto;
  text-align: center;
}
.steps-timeline {
  display: flex;
  justify-content: space-between;
  align-items: flex-start;
  margin-top: 50px;
  position: relative;
}
.steps-timeline::before {
  content: '';
  position: absolute;
  top: 40px;
  left: 10%;
  right: 10%;
  height: 4px;
  background: var(--ice);
  border-radius: 2px;
  z-index: 0;
}
.step-item {
  flex: 1;
  display: flex;
  flex-direction: column;
  align-items: center;
  position: relative;
  z-index: 1;
  padding: 0 8px;
}
.step-circle {
  width: 80px; height: 80px;
  border-radius: 50%;
  background: var(--white);
  border: 4px solid var(--blue);
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 32px;
  margin-bottom: 16px;
  transition: all 0.4s cubic-bezier(0.16,1,0.3,1);
  box-shadow: 0 8px 24px rgba(0,48,135,0.1);
}
.step-item:hover .step-circle {
  background: var(--blue);
  transform: translateY(-6px) scale(1.08);
  box-shadow: 0 16px 40px rgba(0,48,135,0.25);
}
.step-item:hover .step-circle .step-emoji {
  filter: brightness(10);
}
.step-number {
  font-family: 'Playfair Display', serif;
  font-size: 14px; font-weight: 700;
  color: var(--blue);
  letter-spacing: 1px;
  text-transform: uppercase;
  margin-bottom: 6px;
}
.step-title {
  font-family: 'Playfair Display', serif;
  font-size: 18px; font-weight: 600;
  color: var(--text);
  margin-bottom: 6px;
}
.step-desc {
  font-size: 13px;
  color: var(--text-muted);
  line-height: 1.5;
  max-width: 150px;
}

/* ===== APPLICATION FORM SECTION ===== */
.form-section {
  padding: 80px 60px;
  background: var(--white);
}
.form-inner {
  max-width: 800px; margin: 0 auto;
}
.form-section-heading {
  font-family: 'Playfair Display', serif;
  font-size: 22px; font-weight: 600;
  color: var(--blue-deep);
  margin: 40px 0 24px;
  padding-bottom: 12px;
  border-bottom: 2px solid var(--ice);
  display: flex; align-items: center; gap: 10px;
}
.form-section-heading .heading-icon {
  font-size: 24px;
}
.form-submit-btn {
  display: inline-block;
  padding: 16px 48px;
  background: linear-gradient(135deg, var(--blue), var(--blue-deep));
  color: var(--white);
  border: none;
  border-radius: 10px;
  font-family: 'DM Sans', sans-serif;
  font-size: 16px;
  font-weight: 700;
  letter-spacing: 0.8px;
  text-transform: uppercase;
  cursor: pointer;
  transition: all 0.35s cubic-bezier(0.16, 1, 0.3, 1);
  box-shadow: 0 8px 24px rgba(0,48,135,0.2);
  position: relative;
  overflow: hidden;
}
.form-submit-btn::before {
  content: '';
  position: absolute;
  top: 0; left: -100%; width: 100%; height: 100%;
  background: linear-gradient(90deg, transparent, rgba(255,209,0,0.2), transparent);
  transition: left 0.5s;
}
.form-submit-btn:hover {
  transform: translateY(-3px);
  box-shadow: 0 14px 40px rgba(0,48,135,0.3);
}
.form-submit-btn:hover::before {
  left: 100%;
}

/* ===== DOCUMENTS CHECKLIST ===== */
.docs-section {
  padding: 80px 60px;
  background: var(--cream);
}
.docs-inner {
  max-width: 800px; margin: 0 auto;
}
.docs-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
  gap: 16px;
  margin-top: 30px;
}
.doc-item {
  display: flex;
  align-items: center;
  gap: 14px;
  padding: 18px 22px;
  background: var(--white);
  border-radius: 12px;
  border: 2px solid var(--ice);
  transition: all 0.3s;
}
.doc-item:hover {
  border-color: var(--blue-light);
  box-shadow: 0 8px 24px rgba(0,48,135,0.08);
  transform: translateY(-2px);
}
.doc-check {
  width: 36px; height: 36px;
  border-radius: 50%;
  background: linear-gradient(135deg, #28a745, #20c997);
  display: flex;
  align-items: center;
  justify-content: center;
  flex-shrink: 0;
  color: white;
  font-size: 16px;
  font-weight: 700;
}
.doc-text {
  font-size: 15px;
  font-weight: 600;
  color: var(--text);
}

/* ===== APPLICATION FEE ===== */
.fee-box {
  max-width: 700px;
  margin: 50px auto;
  background: linear-gradient(135deg, var(--blue), var(--blue-deep));
  border-radius: 20px;
  padding: 40px;
  text-align: center;
  position: relative;
  overflow: hidden;
}
.fee-box::before {
  content: '';
  position: absolute;
  width: 200px; height: 200px;
  background: var(--gold);
  border-radius: 50%;
  opacity: 0.08;
  top: -60px; right: -40px;
}
.fee-box::after {
  content: '';
  position: absolute;
  width: 140px; height: 140px;
  background: var(--coral);
  border-radius: 50%;
  opacity: 0.06;
  bottom: -40px; left: -30px;
}
.fee-amount {
  font-family: 'Playfair Display', serif;
  font-size: 42px; font-weight: 700;
  color: var(--gold-light);
  margin-bottom: 8px;
  position: relative; z-index: 1;
}
.fee-label {
  font-size: 16px; font-weight: 600;
  color: rgba(255,255,255,0.9);
  margin-bottom: 4px;
  position: relative; z-index: 1;
}
.fee-note {
  font-size: 14px;
  color: rgba(255,255,255,0.6);
  line-height: 1.7;
  position: relative; z-index: 1;
  max-width: 500px;
  margin: 10px auto 0;
}
.fee-tag {
  display: inline-block;
  background: rgba(232,68,58,0.9);
  color: white;
  font-size: 11px;
  font-weight: 700;
  letter-spacing: 1px;
  text-transform: uppercase;
  padding: 4px 14px;
  border-radius: 20px;
  margin-bottom: 16px;
  position: relative; z-index: 1;
}

/* ===== IMPORTANT DATES ===== */
.dates-section {
  padding: 80px 60px;
  background: var(--white);
}
.dates-inner {
  max-width: 900px; margin: 0 auto;
}
.dates-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
  gap: 20px;
  margin-top: 40px;
}
.date-card {
  background: var(--white);
  border: 2px solid var(--ice);
  border-radius: 16px;
  padding: 28px;
  display: flex;
  gap: 18px;
  align-items: flex-start;
  transition: all 0.3s;
}
.date-card:hover {
  border-color: var(--blue-light);
  box-shadow: 0 12px 40px rgba(0,48,135,0.08);
  transform: translateY(-4px);
}
.date-badge {
  min-width: 60px;
  text-align: center;
  background: var(--blue);
  border-radius: 12px;
  padding: 12px 8px;
  flex-shrink: 0;
}
.date-badge .date-month {
  font-size: 10px; font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 1px;
  color: var(--gold-light);
}
.date-badge .date-day {
  font-family: 'Playfair Display', serif;
  font-size: 26px; font-weight: 700;
  color: var(--white);
  line-height: 1.1;
}
.date-info h4 {
  font-family: 'Playfair Display', serif;
  font-size: 17px; font-weight: 600;
  color: var(--text);
  margin: 0 0 6px;
}
.date-info p {
  font-size: 13px;
  color: var(--text-muted);
  line-height: 1.5;
  margin: 0;
}

/* ===== ADMISSIONS CONTACT ===== */
.admissions-contact {
  padding: 80px 60px;
  background: var(--cream-warm);
}
.admissions-contact-inner {
  max-width: 800px;
  margin: 0 auto;
}
.contact-card {
  background: var(--white);
  border-radius: 20px;
  padding: 48px;
  box-shadow: 0 20px 60px rgba(0,0,0,0.06);
  border: 2px solid var(--ice);
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 32px;
}
.contact-card-left {
  display: flex;
  flex-direction: column;
  justify-content: center;
}
.contact-card-left h3 {
  font-family: 'Playfair Display', serif;
  font-size: 26px; font-weight: 600;
  color: var(--text);
  margin-bottom: 12px;
}
.contact-card-left p {
  font-size: 15px;
  color: var(--text-muted);
  line-height: 1.7;
  margin-bottom: 20px;
}
.contact-detail {
  display: flex;
  align-items: center;
  gap: 12px;
  margin-bottom: 14px;
}
.contact-detail-icon {
  width: 42px; height: 42px;
  border-radius: 10px;
  background: var(--ice);
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 20px;
  flex-shrink: 0;
}
.contact-detail-text {
  font-size: 14px;
  color: var(--text);
  font-weight: 500;
}
.contact-detail-label {
  font-size: 11px;
  font-weight: 700;
  color: var(--text-muted);
  text-transform: uppercase;
  letter-spacing: 1px;
}
.contact-card-right {
  background: var(--blue);
  border-radius: 16px;
  padding: 36px;
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  text-align: center;
}
.contact-card-right .cta-icon {
  font-size: 48px;
  margin-bottom: 16px;
}
.contact-card-right h4 {
  font-family: 'Playfair Display', serif;
  font-size: 22px; font-weight: 600;
  color: var(--white);
  margin-bottom: 10px;
}
.contact-card-right p {
  font-size: 14px;
  color: rgba(255,255,255,0.7);
  line-height: 1.6;
  margin-bottom: 20px;
}
.contact-card-right .btn-gold {
  display: inline-block;
}

/* ===== RESPONSIVE ===== */
@media (max-width: 1024px) {
  .nav-inner { padding-left: 30px !important; padding-right: 30px !important; }
  .steps-section, .form-section, .docs-section, .dates-section, .admissions-contact { padding-left: 30px !important; padding-right: 30px !important; }
  .footer-grid { grid-template-columns: 1fr 1fr; }
}

@media (max-width: 768px) {
  .topbar { display: none; }
  .nav-menu { display: none; }
  .nav-search-btn { display: none; }
  .mobile-toggle { display: block; }
  .nav-inner { padding: 0 20px !important; height: 64px; }
  .page-hero { padding: 120px 20px 60px; }
  .page-content { padding: 40px 20px; }
  .form-row { grid-template-columns: 1fr; }
  .steps-section, .form-section, .docs-section, .dates-section, .admissions-contact { padding-left: 20px !important; padding-right: 20px !important; }
  .steps-timeline {
    flex-direction: column;
    align-items: center;
    gap: 32px;
  }
  .steps-timeline::before {
    top: 0; bottom: 0;
    left: 50%;
    width: 4px;
    height: 100%;
    transform: translateX(-50%);
  }
  .step-circle { width: 64px; height: 64px; font-size: 26px; }
  .step-desc { max-width: 220px; }
  .docs-grid { grid-template-columns: 1fr; }
  .dates-grid { grid-template-columns: 1fr; }
  .contact-card { grid-template-columns: 1fr; }
  .footer-grid { grid-template-columns: 1fr; gap: 32px; }
  .footer-bottom { flex-direction: column; text-align: center; }
  .fee-box { padding: 30px 20px; }
  .fee-amount { font-size: 32px; }
}

/* ===== PENCIL CURSOR ===== */
body {
  cursor: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='28' height='28' viewBox='0 0 28 28'%3E%3Cg transform='translate(28,0) scale(-1,1) rotate(-45 14 14)'%3E%3Crect x='11' y='3' width='6' height='18' rx='1' fill='%23FFD700' stroke='%23001840' stroke-width='0.7'/%3E%3Crect x='11' y='3' width='6' height='4' rx='1' fill='%234A90D9' stroke='%23001840' stroke-width='0.7'/%3E%3Crect x='12' y='4' width='4' height='2' rx='0.5' fill='%236BB3E0' opacity='0.6'/%3E%3Cpolygon points='11,21 17,21 14,26' fill='%23F5DEB3' stroke='%23001840' stroke-width='0.7'/%3E%3Cpolygon points='13,24 15,24 14,26' fill='%23003087'/%3E%3C/g%3E%3C/svg%3E") 25 25, auto;
}
a, button, .feature-card, .stat-card, .news-card, .gallery-item {
  cursor: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='32' height='32' viewBox='0 0 32 32'%3E%3Cdefs%3E%3Cfilter id='g' x='-20%25' y='-20%25' width='140%25' height='140%25'%3E%3CfeGaussianBlur stdDeviation='1' result='b'/%3E%3CfeMerge%3E%3CfeMergeNode in='b'/%3E%3CfeMergeNode in='SourceGraphic'/%3E%3C/feMerge%3E%3C/filter%3E%3C/defs%3E%3Cg transform='translate(32,0) scale(-1,1) rotate(-45 16 16)' filter='url(%23g)'%3E%3Crect x='13' y='3' width='6' height='20' rx='1' fill='%23FFD700' stroke='%23001840' stroke-width='0.8'/%3E%3Crect x='13' y='3' width='6' height='4' rx='1' fill='%234A90D9' stroke='%23001840' stroke-width='0.8'/%3E%3Crect x='14' y='4' width='4' height='2' rx='0.5' fill='%236BB3E0' opacity='0.6'/%3E%3Cpolygon points='13,23 19,23 16,28' fill='%23F5DEB3' stroke='%23001840' stroke-width='0.8'/%3E%3Cpolygon points='15,26 17,26 16,28' fill='%23003087'/%3E%3C/g%3E%3C/svg%3E") 28 28, pointer;
}

</style>
</head>
<body>
<?php include get_stylesheet_directory() . '/gtm-body.php'; ?>

<!-- SKIP LINK (accessibility) -->
<a href="#main-content" class="skip-link">Skip to main content</a>

<!-- TOPBAR -->
<div class="topbar" role="banner">
  <div class="topbar-left">
    <a href="tel:+923135914700">&#x1F4DE; +92 313 5914700</a>
    <a href="mailto:admissions@kpms.edu.pk">&#x2709; admissions@kpms.edu.pk</a>
  </div>
  <div class="topbar-right">
    <div class="topbar-translate">
      &#x1F310; <select onchange="if(this.value)window.open('https://translate.google.com/translate?sl=en&tl='+this.value+'&u='+location.href,'_blank')" aria-label="Translate page">
        <option value="">English</option>
        <option value="ur">&#x627;&#x631;&#x62F;&#x648;</option>
        <option value="ps">&#x67E;&#x69A;&#x62A;&#x648;</option>
        <option value="ar">&#x627;&#x644;&#x639;&#x631;&#x628;&#x64A;&#x629;</option>
        <option value="zh">&#x4E2D;&#x6587;</option>
      </select>
    </div>
    <a href="/parent-portal/" class="parent-portal-btn">&#x1F510; Parent Portal</a>
  </div>
</div>

<!-- NAVIGATION -->
<nav class="nav" id="nav" role="navigation" aria-label="Main navigation">
  <div class="nav-inner">
    <a href="/" class="nav-logo" aria-label="KPMS Home">
      <div class="nav-logo-icon"><img src="http://kpms.edu.pk/wp-content/uploads/2026/02/Kamal-Public-School-2.png" alt="KPMS Logo" onerror="this.style.display='none';this.parentElement.style.cssText='display:flex;align-items:center;justify-content:center;font-weight:700;font-size:24px';this.parentElement.textContent='K'"></div>
      <div>
        <span class="nav-logo-text">KPMS</span>
        <span class="nav-logo-sub">Kamal Public Middle School</span>
      </div>
    </a>

    <ul class="nav-menu">
      <li><a href="/">Home</a></li>
      <li>
        <a href="#">About Us <span class="dropdown-arrow">&#x25BC;</span></a>
        <div class="dropdown">
          <a href="/staff-directory/">Staff Directory</a>
          <a href="/mission-vision/">Mission &amp; Vision</a>
          <a href="/campus/">Our Campus</a>
          <a href="/contact/">Contact</a>
        </div>
      </li>
      <li>
        <a href="#">Calendar <span class="dropdown-arrow">&#x25BC;</span></a>
        <div class="dropdown">
          <a href="/calendar/">Upcoming Events</a>
          <a href="/calendar/">Past Events</a>
        </div>
      </li>
      <li><a href="#">Academic Programs <span class="dropdown-arrow">&#x25BC;</span></a><div class="dropdown"><a href="/montessori/">Montessori Program</a><a href="/primary-education/">Primary Education</a><a href="/tuition/">Tuition &amp; Tutoring</a></div></li>
      <li><a href="#">Admissions <span class="dropdown-arrow">&#x25BC;</span></a><div class="dropdown"><a href="/apply-online/">Apply Online</a><a href="/prospectus/">View Prospectus</a><a href="/schedule-tour/">Schedule a Tour</a></div></li>
      <li>
        <a href="#">Parents <span class="dropdown-arrow">&#x25BC;</span></a>
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
      <button class="nav-search-btn" onclick="toggleSearch()" aria-label="Search">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
      </button>
      <button class="mobile-toggle" aria-label="Open menu">
        <span></span><span></span><span></span>
      </button>
    </div>
  </div>
</nav>

<!-- SEARCH OVERLAY -->
<div class="search-overlay" id="searchOverlay" role="search">
  <div class="search-box">
    <input type="text" placeholder="Search staff, events, forms, pages..." id="searchInput" aria-label="Search the site">
    <button class="search-close" onclick="toggleSearch()" aria-label="Close search">&#x2715;</button>
  </div>
  <div class="search-hint">Press ESC to close</div>
</div>

<?php include get_stylesheet_directory() . '/mobile-menu.php'; ?>

<!-- PAGE HERO -->
<section class="page-hero" style="background: linear-gradient(160deg, rgba(0,24,64,0.88) 0%, rgba(0,48,135,0.7) 50%, rgba(0,24,64,0.82) 100%), url('https://images.unsplash.com/photo-1580582932707-520aed937b7b?w=1920&q=85') center/cover;">
  <div class="page-hero-label">Admissions</div>
  <h1 class="page-hero-title">Apply Online</h1>
  <p class="page-hero-subtitle">Take the first step toward an exceptional education for your child</p>
  <div class="page-breadcrumb"><a href="/">Home</a> / <a href="/apply-online/">Admissions</a> / Apply Online</div>
</section>

<!-- ===== SECTION 1: APPLICATION STEPS TIMELINE ===== -->
<section class="steps-section" id="main-content">
  <div class="steps-inner">
    <div class="section-label reveal">How It Works</div>
    <h2 class="section-title reveal reveal-d1">Your Path to KPMS</h2>
    <p class="section-subtitle reveal reveal-d2" style="max-width:600px; margin:10px auto 0; color:var(--text-muted);">Follow these five simple steps to join the KPMS family</p>

    <div class="steps-timeline reveal reveal-d3">
      <div class="step-item">
        <div class="step-circle"><span class="step-emoji">&#x1F4CB;</span></div>
        <div class="step-number">Step 1</div>
        <div class="step-title">Inquiry</div>
        <div class="step-desc">Submit your initial interest and learn about our programs</div>
      </div>
      <div class="step-item">
        <div class="step-circle"><span class="step-emoji">&#x1F4DD;</span></div>
        <div class="step-number">Step 2</div>
        <div class="step-title">Application</div>
        <div class="step-desc">Complete the full application form with required documents</div>
      </div>
      <div class="step-item">
        <div class="step-circle"><span class="step-emoji">&#x1F4CA;</span></div>
        <div class="step-number">Step 3</div>
        <div class="step-title">Assessment</div>
        <div class="step-desc">Student evaluation to understand learning level and needs</div>
      </div>
      <div class="step-item">
        <div class="step-circle"><span class="step-emoji">&#x1F91D;</span></div>
        <div class="step-number">Step 4</div>
        <div class="step-title">Interview</div>
        <div class="step-desc">Family meeting with our admissions team</div>
      </div>
      <div class="step-item">
        <div class="step-circle"><span class="step-emoji">&#x1F393;</span></div>
        <div class="step-number">Step 5</div>
        <div class="step-title">Enrollment</div>
        <div class="step-desc">Welcome to KPMS! Complete enrollment and orientation</div>
      </div>
    </div>
  </div>
</section>

<!-- ===== SECTION 2: APPLICATION FORM ===== -->
<section class="form-section">
  <div class="form-inner">
    <div style="text-align:center;" class="reveal">
      <div class="section-label">Start Your Journey</div>
      <h2 class="section-title">Application Form</h2>
      <p style="font-size:16px; color:var(--text-muted); margin-top:10px; max-width:550px; margin-left:auto; margin-right:auto;">Please fill in all required fields. Our admissions team will review your application and get back to you within 5 business days.</p>
    </div>

    <?php $kpms_nonce = wp_create_nonce('kpms_form_nonce'); $kpms_ajax = admin_url('admin-ajax.php'); ?>
    <script>window.kpmsAjax={url:"<?php echo esc_url($kpms_ajax); ?>",nonce:"<?php echo esc_attr($kpms_nonce); ?>"};</script>
    <form class="kpms-form" id="applyForm" style="max-width:750px;" novalidate>
      <input type="hidden" name="form_type" value="application">

      <!-- Student Information -->
      <div class="form-section-heading reveal">
        <span class="heading-icon">&#x1F393;</span> Student Information
      </div>

      <div class="form-row reveal">
        <div class="form-group">
          <label>Student Full Name *</label>
          <input type="text" name="student_name" placeholder="Enter student's full name" required>
          <div class="form-error" style="display:none;color:#e74c3c;font-size:12px;margin-top:4px;">Required</div>
        </div>
        <div class="form-group">
          <label>Date of Birth *</label>
          <input type="date" name="date_of_birth" required>
          <div class="form-error" style="display:none;color:#e74c3c;font-size:12px;margin-top:4px;">Required</div>
        </div>
      </div>
      <div class="form-row reveal">
        <div class="form-group">
          <label>Gender *</label>
          <select name="gender" required>
            <option value="">Select gender</option>
            <option value="male">Male</option>
            <option value="female">Female</option>
          </select>
          <div class="form-error" style="display:none;color:#e74c3c;font-size:12px;margin-top:4px;">Required</div>
        </div>
        <div class="form-group">
          <label>Grade Applying For *</label>
          <select name="grade_applying_for" required>
            <option value="">Select grade level</option>
            <option value="nursery">Nursery</option>
            <option value="pre-k">Pre-K</option>
            <option value="kg">KG (Kindergarten)</option>
            <option value="grade-1">Grade 1</option>
            <option value="grade-2">Grade 2</option>
            <option value="grade-3">Grade 3</option>
            <option value="grade-4">Grade 4</option>
            <option value="grade-5">Grade 5</option>
          </select>
          <div class="form-error" style="display:none;color:#e74c3c;font-size:12px;margin-top:4px;">Required</div>
        </div>
      </div>
      <div class="form-group reveal">
        <label>Previous School Name</label>
        <input type="text" name="previous_school" placeholder="Name of previous school (if applicable)">
      </div>

      <!-- Parent/Guardian Information -->
      <div class="form-section-heading reveal">
        <span class="heading-icon">&#x1F468;&#x200D;&#x1F469;&#x200D;&#x1F467;</span> Parent / Guardian Information
      </div>

      <div class="form-row reveal">
        <div class="form-group">
          <label>Parent/Guardian Full Name *</label>
          <input type="text" name="parent_name" placeholder="Enter full name" required>
          <div class="form-error" style="display:none;color:#e74c3c;font-size:12px;margin-top:4px;">Required</div>
        </div>
        <div class="form-group">
          <label>Relationship to Student *</label>
          <select name="relationship" required>
            <option value="">Select relationship</option>
            <option value="father">Father</option>
            <option value="mother">Mother</option>
            <option value="guardian">Legal Guardian</option>
            <option value="grandparent">Grandparent</option>
            <option value="other">Other</option>
          </select>
          <div class="form-error" style="display:none;color:#e74c3c;font-size:12px;margin-top:4px;">Required</div>
        </div>
      </div>
      <div class="form-row reveal">
        <div class="form-group">
          <label>Email Address *</label>
          <input type="email" name="parent_email" placeholder="you@example.com" required>
          <div class="form-error" style="display:none;color:#e74c3c;font-size:12px;margin-top:4px;">Valid email required</div>
        </div>
        <div class="form-group">
          <label>Phone Number *</label>
          <input type="tel" name="parent_phone" placeholder="+92 3XX XXXXXXX" required>
          <div class="form-error" style="display:none;color:#e74c3c;font-size:12px;margin-top:4px;">Required</div>
        </div>
      </div>
      <div class="form-group reveal">
        <label>Home Address *</label>
        <textarea name="address" rows="3" placeholder="Full residential address" required></textarea>
        <div class="form-error" style="display:none;color:#e74c3c;font-size:12px;margin-top:4px;">Required</div>
      </div>

      <!-- Additional Information -->
      <div class="form-section-heading reveal">
        <span class="heading-icon">&#x1F4AC;</span> Additional Information
      </div>

      <div class="form-group reveal">
        <label>How did you hear about KPMS?</label>
        <select name="how_heard">
          <option value="">Select an option</option>
          <option value="social-media">Social Media</option>
          <option value="friend">Friend or Family Referral</option>
          <option value="website">KPMS Website</option>
          <option value="newspaper">Newspaper / Print Ad</option>
          <option value="other">Other</option>
        </select>
      </div>
      <div class="form-group reveal">
        <label>Additional Notes or Questions</label>
        <textarea name="additional_notes" rows="4" placeholder="Any special needs, questions, or additional information you'd like to share..."></textarea>
      </div>

      <div style="text-align:center; margin-top:36px;" class="reveal">
        <button type="submit" class="form-submit-btn" id="applySubmitBtn">&#x1F4E8; Submit Application</button>
        <p style="font-size:12px; color:var(--text-muted); margin-top:14px;">By submitting, you agree to our admissions terms and privacy policy.</p>
      </div>
      <div id="applyFormMsg" style="display:none; text-align:center; margin-top:20px; padding:16px 24px; border-radius:10px; font-weight:600;"></div>

    </form>

    <script>
    document.getElementById('applyForm').addEventListener('submit', async function(e) {
      e.preventDefault();
      const form = this;
      const btn = document.getElementById('applySubmitBtn');
      const msgDiv = document.getElementById('applyFormMsg');

      form.querySelectorAll('.form-error').forEach(el => el.style.display = 'none');
      msgDiv.style.display = 'none';

      let valid = true;
      const required = ['student_name','date_of_birth','gender','grade_applying_for','parent_name','relationship','parent_email','parent_phone','address'];
      required.forEach(name => {
        const el = form.querySelector('[name="'+name+'"]');
        if (el && !el.value.trim()) {
          const err = el.parentElement.querySelector('.form-error');
          if (err) err.style.display = 'block';
          valid = false;
        }
      });
      const emailEl = form.querySelector('[name="parent_email"]');
      if (emailEl && emailEl.value && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(emailEl.value)) {
        const err = emailEl.parentElement.querySelector('.form-error');
        if (err) err.style.display = 'block';
        valid = false;
      }

      if (!valid) { form.querySelector('.form-error[style*="block"]')?.scrollIntoView({behavior:'smooth',block:'center'}); return; }

      btn.disabled = true;
      const origText = btn.innerHTML;
      btn.textContent = 'Submitting...';

      try {
        const data = new FormData(form);
        data.append('action', 'kpms_form_submit');
        data.append('_kpms_nonce', window.kpmsAjax.nonce);
        const resp = await fetch(window.kpmsAjax.url, { method: 'POST', body: data });
        const json = await resp.json();
        if (json.success) {
          msgDiv.style.cssText = 'display:block;text-align:center;margin-top:20px;padding:16px 24px;border-radius:10px;font-weight:600;background:#d4edda;color:#155724;';
          msgDiv.textContent = json.data.message;
          form.reset();
        } else {
          msgDiv.style.cssText = 'display:block;text-align:center;margin-top:20px;padding:16px 24px;border-radius:10px;font-weight:600;background:#f8d7da;color:#721c24;';
          msgDiv.textContent = json.data?.message || 'Something went wrong. Please try again.';
        }
      } catch(err) {
        msgDiv.style.cssText = 'display:block;text-align:center;margin-top:20px;padding:16px 24px;border-radius:10px;font-weight:600;background:#f8d7da;color:#721c24;';
        msgDiv.textContent = 'Network error. Please check your connection and try again.';
      }
      btn.disabled = false;
      btn.innerHTML = origText;
    });
    </script>
  </div>
</section>

<!-- ===== SECTION 3: REQUIRED DOCUMENTS CHECKLIST ===== -->
<section class="docs-section">
  <div class="docs-inner">
    <div style="text-align:center;" class="reveal">
      <div class="section-label">Be Prepared</div>
      <h2 class="section-title">Required Documents</h2>
      <p style="font-size:16px; color:var(--text-muted); margin-top:10px;">Please have the following documents ready for submission</p>
    </div>

    <div class="docs-grid">
      <div class="doc-item reveal reveal-d1">
        <div class="doc-check">&#x2713;</div>
        <div class="doc-text">Birth Certificate (original + copy)</div>
      </div>
      <div class="doc-item reveal reveal-d2">
        <div class="doc-check">&#x2713;</div>
        <div class="doc-text">Previous School Report Card</div>
      </div>
      <div class="doc-item reveal reveal-d1">
        <div class="doc-check">&#x2713;</div>
        <div class="doc-text">4 Passport-size Photographs</div>
      </div>
      <div class="doc-item reveal reveal-d2">
        <div class="doc-check">&#x2713;</div>
        <div class="doc-text">Parent/Guardian CNIC Copy</div>
      </div>
      <div class="doc-item reveal reveal-d1">
        <div class="doc-check">&#x2713;</div>
        <div class="doc-text">Transfer Certificate (if applicable)</div>
      </div>
      <div class="doc-item reveal reveal-d2">
        <div class="doc-check">&#x2713;</div>
        <div class="doc-text">Medical / Health Record</div>
      </div>
      <div class="doc-item reveal reveal-d1" style="grid-column: 1 / -1; max-width: 340px; margin: 0 auto;">
        <div class="doc-check">&#x2713;</div>
        <div class="doc-text">Vaccination Record</div>
      </div>
    </div>
  </div>
</section>

<!-- ===== SECTION 4: NEXT STEPS ===== -->
<section style="padding:80px 60px; background:var(--white);">
  <div class="reveal" style="max-width:700px; margin:0 auto; text-align:center;">
    <div class="section-label">What Happens Next</div>
    <h2 class="section-title" style="margin-bottom:16px;">After You Apply</h2>
    <p style="font-size:16px; line-height:1.8; color:var(--text-muted);">Once we receive your application, our admissions team will review it and contact you to schedule a student assessment. For any questions about the application process, please contact our admissions office.</p>
    <div style="margin-top:24px;">
      <a href="/contact/" class="btn btn-blue">Contact Admissions</a>
    </div>
  </div>
</section>

<!-- ===== SECTION 5: IMPORTANT DATES / DEADLINES ===== -->
<section class="dates-section">
  <div class="dates-inner">
    <div style="text-align:center;" class="reveal">
      <div class="section-label">Mark Your Calendar</div>
      <h2 class="section-title">Important Dates &amp; Deadlines</h2>
      <p style="font-size:16px; color:var(--text-muted); margin-top:10px;">Key milestones in the admissions process</p>
    </div>

    <div class="dates-grid">
      <div class="date-card reveal reveal-d1">
        <div class="date-badge">
          <div class="date-month">Mar</div>
          <div class="date-day">1</div>
        </div>
        <div class="date-info">
          <h4>Applications Open</h4>
          <p>Online and in-person applications begin for the new academic year</p>
        </div>
      </div>
      <div class="date-card reveal reveal-d2">
        <div class="date-badge">
          <div class="date-month">May</div>
          <div class="date-day">31</div>
        </div>
        <div class="date-info">
          <h4>Application Deadline</h4>
          <p>Last date to submit completed applications with all required documents</p>
        </div>
      </div>
      <div class="date-card reveal reveal-d3">
        <div class="date-badge">
          <div class="date-month">Jun</div>
          <div class="date-day">15</div>
        </div>
        <div class="date-info">
          <h4>Assessment Week</h4>
          <p>Student evaluations and assessments conducted at the school campus</p>
        </div>
      </div>
      <div class="date-card reveal reveal-d1">
        <div class="date-badge">
          <div class="date-month">Jun</div>
          <div class="date-day">30</div>
        </div>
        <div class="date-info">
          <h4>Interview Notifications</h4>
          <p>Families notified of interview schedules and assessment results</p>
        </div>
      </div>
      <div class="date-card reveal reveal-d2">
        <div class="date-badge">
          <div class="date-month">Jul</div>
          <div class="date-day">15</div>
        </div>
        <div class="date-info">
          <h4>Enrollment Confirmation</h4>
          <p>Final admission decisions communicated and enrollment packets sent</p>
        </div>
      </div>
      <div class="date-card reveal reveal-d3">
        <div class="date-badge">
          <div class="date-month">Aug</div>
          <div class="date-day">1</div>
        </div>
        <div class="date-info">
          <h4>New Student Orientation</h4>
          <p>Welcome day for new students and families to meet staff and tour campus</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ===== SECTION 6: ADMISSIONS CONTACT ===== -->
<section class="admissions-contact">
  <div class="admissions-contact-inner">
    <div style="text-align:center; margin-bottom:40px;" class="reveal">
      <div class="section-label">Need Help?</div>
      <h2 class="section-title">Admissions Office</h2>
    </div>

    <div class="contact-card reveal reveal-d1">
      <div class="contact-card-left">
        <h3>Get in Touch</h3>
        <p>Our admissions team is here to guide you through every step of the process.</p>

        <div class="contact-detail">
          <div class="contact-detail-icon">&#x1F4DE;</div>
          <div>
            <div class="contact-detail-label">Phone</div>
            <div class="contact-detail-text">+92 313 5914700</div>
          </div>
        </div>
        <div class="contact-detail">
          <div class="contact-detail-icon">&#x2709;&#xFE0F;</div>
          <div>
            <div class="contact-detail-label">Email</div>
            <div class="contact-detail-text">admissions@kpms.edu.pk</div>
          </div>
        </div>
        <div class="contact-detail">
          <div class="contact-detail-icon">&#x1F552;</div>
          <div>
            <div class="contact-detail-label">Office Hours</div>
            <div class="contact-detail-text">Mon - Sat, 8:00 AM - 3:00 PM</div>
          </div>
        </div>
        <div class="contact-detail">
          <div class="contact-detail-icon">&#x1F4CD;</div>
          <div>
            <div class="contact-detail-label">Address</div>
            <div class="contact-detail-text">Sheikh ul Bandi Road, Abbottabad, KPK 22010</div>
          </div>
        </div>
      </div>
      <div class="contact-card-right">
        <div class="cta-icon">&#x1F3EB;</div>
        <h4>Visit Our Campus</h4>
        <p>Schedule a personal tour to see our classrooms, facilities, and meet our dedicated teachers.</p>
        <a href="/schedule-tour/" class="btn btn-gold">Schedule a Tour</a>
      </div>
    </div>
  </div>
</section>

<!-- FOOTER -->
<footer class="footer">
  <div class="footer-inner">
    <div class="footer-grid">
      <div>
        <div class="footer-brand">
          <div class="footer-brand-icon"><img src="http://kpms.edu.pk/wp-content/uploads/2026/02/Kamal-Public-School-2.png" alt="KPMS Logo" onerror="this.style.display='none';this.parentElement.style.cssText='display:flex;align-items:center;justify-content:center;font-weight:700;font-size:28px';this.parentElement.textContent='K'"></div>
          <div class="footer-brand-name">KPMS</div>
        </div>
        <p class="footer-desc">Kamal Public Middle School has been cultivating curiosity and building character in Abbottabad's young learners since 1985.</p>
        <div class="footer-contact">&#x1F4CD; Sheikh ul Bandi, Abbottabad, KPK</div>
        <div class="footer-contact">&#x1F4DE; +92 313 5914700</div>
        <div class="footer-contact">&#x2709; info@kpms.edu.pk</div>
      </div>
      <div>
        <h4 class="footer-heading">Admission</h4>
        <ul class="footer-links">
          <li><a href="/enrollment/">How to Apply</a></li>
          <li><a href="/campus/">Visit</a></li>
          <li><a href="/enrollment/">How to Apply</a></li>
          <li><a href="/enrollment/">Admission FAQs</a></li>
          <li><a href="/calendar/">Admission Event</a></li>
          <li><a href="/contact/">Contact Admission</a></li>
        </ul>
      </div>
      <div>
        <h4 class="footer-heading">About</h4>
        <ul class="footer-links">
          <li><a href="/">Welcome</a></li>
          <li><a href="/campus/">Our Campus</a></li>
          <li><a href="/staff-directory/">Our Faculty</a></li>
          <li><a href="/mission-vision/">History</a></li>
          <li><a href="/philosophy/">Approach &amp; Philosophy</a></li>
        </ul>
      </div>
      <div>
        <h4 class="footer-heading">Links</h4>
        <ul class="footer-links">
          <li><a href="/calendar/">Summer Programs</a></li>
          <li><a href="/careers/">Careers</a></li>
          <li><a href="/contact/">Contact Us</a></li>
        </ul>
        <h4 class="footer-heading" style="margin-top: 28px;">Connect</h4>
        <div class="footer-social">
          <a href="#" class="fb" title="Facebook"><svg viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg></a>
          <a href="#" class="ig" title="Instagram"><svg viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg></a>
          <a href="#" class="yt" title="YouTube"><svg viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 00-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 00.502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 002.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 002.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg></a>
          <a href="https://wa.me/+923135914700" class="wa" title="WhatsApp"><svg viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg></a>
        </div>
      </div>
    </div>
    <div class="footer-bottom">
      <div class="footer-copy">&copy; 1985&ndash;2026 Kamal Public Middle School Abbottabad. All Rights Reserved.</div>
      <div class="footer-legal">
        <a href="/">Privacy Policy</a>
        <a href="/">Terms</a>
        <a href="/">Accessibility</a>
        <a href="/">Anti&#x2011;Discrimination</a>
        <a href="/">Sitemap</a>
      </div>
    </div>
  </div>
</footer>

<script>
// Sticky nav shadow
window.addEventListener('scroll', () => {
  document.getElementById('nav').classList.toggle('scrolled', window.scrollY > 10);
});

// Mobile nav
<?php include get_stylesheet_directory() . '/mobile-menu-js.php'; ?>

// Search overlay
function toggleSearch() {
  const overlay = document.getElementById('searchOverlay');
  overlay.classList.toggle('open');
  if (overlay.classList.contains('open')) {
    setTimeout(() => document.getElementById('searchInput').focus(), 100);
  }
}
document.addEventListener('keydown', (e) => {
  if (e.key === 'Escape') {
    document.getElementById('searchOverlay').classList.remove('open');
    document.getElementById('mobileNav').classList.remove('open');
  }
  // Ctrl+K or Cmd+K to open search
  if ((e.metaKey || e.ctrlKey) && e.key === 'k') {
    e.preventDefault();
    toggleSearch();
  }
});

// Scroll reveal
const reveals = document.querySelectorAll('.reveal');
const obs = new IntersectionObserver(entries => {
  entries.forEach(e => { if (e.isIntersecting) e.target.classList.add('visible'); });
}, { threshold: 0.12, rootMargin: '0px 0px -40px 0px' });
reveals.forEach(el => obs.observe(el));
</script>


</body>
</html>