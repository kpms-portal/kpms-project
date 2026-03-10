<?php
/*
Template Name: KPMS - Schedule a Tour
*/
?>
<?php

// This is a standalone page template — it does NOT load the parent theme header/footer.
// The entire page is self-contained in the HTML below.
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Schedule a Tour – KPMS | Kamal Public Middle School Abbottabad</title>
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
.hero {
  position: relative;
  height: 85vh; min-height: 580px; max-height: 800px;
  display: flex; align-items: center; justify-content: center;
  overflow: hidden;
}
.hero-bg {
  position: absolute; inset: 0;
  background:
    linear-gradient(160deg, rgba(0,24,64,0.82) 0%, rgba(0,48,135,0.55) 50%, rgba(0,24,64,0.78) 100%),
    url('https://images.unsplash.com/photo-1503676260728-1c00da094a0b?w=1920&q=85') center/cover;
}
.hero-content {
  position: relative; z-index: 2;
  text-align: center; max-width: 820px; padding: 0 30px;
}
.hero-badge {
  display: inline-flex; align-items: center; gap: 8px;
  background: rgba(255,255,255,0.12);
  backdrop-filter: blur(12px);
  border: 1px solid rgba(255,255,255,0.15);
  border-radius: 40px;
  padding: 8px 22px;
  font-size: 13px; font-weight: 600;
  color: var(--gold-light);
  letter-spacing: 1.5px; text-transform: uppercase;
  margin-bottom: 28px;
  opacity: 0; animation: fadeUp 0.8s 0.2s forwards;
}
.hero-title {
  font-family: 'Playfair Display', serif;
  font-size: clamp(36px, 6vw, 66px);
  font-weight: 500;
  color: var(--white);
  line-height: 1.12;
  margin-bottom: 24px;
  opacity: 0; animation: fadeUp 0.8s 0.4s forwards;
}
.hero-title em {
  font-style: italic;
  color: var(--gold-light);
  font-weight: 400;
}
.hero-subtitle {
  font-size: clamp(16px, 2.2vw, 20px);
  color: rgba(255,255,255,0.85);
  line-height: 1.65;
  max-width: 600px; margin: 0 auto 40px;
  opacity: 0; animation: fadeUp 0.8s 0.6s forwards;
}
.hero-btns {
  display: flex; gap: 16px; justify-content: center; flex-wrap: wrap;
  opacity: 0; animation: fadeUp 0.8s 0.8s forwards;
}
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
.btn-outline {
  background: transparent;
  color: var(--white);
  border: 2px solid rgba(255,255,255,0.3);
}
.btn-outline:hover {
  border-color: var(--gold-light);
  color: var(--gold-light);
  transform: translateY(-2px);
}
@keyframes fadeUp {
  from { opacity: 0; transform: translateY(28px); }
  to { opacity: 1; transform: translateY(0); }
}

/* ===== SECTION COMMON ===== */
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

/* ===== CTA BANNER ===== */
.cta {
  padding: 70px 60px;
  background: var(--blue-deep);
  text-align: center;
  position: relative;
  overflow: hidden;
}
.cta::before, .cta::after {
  content: '';
  position: absolute;
  border-radius: 50%;
  opacity: 0.08;
}
.cta::before { width: 300px; height: 300px; background: var(--gold); top: -100px; right: -60px; }
.cta::after { width: 200px; height: 200px; background: var(--coral); bottom: -80px; left: -40px; }
.cta-label {
  font-size: 13px; font-weight: 700;
  letter-spacing: 3px; text-transform: uppercase;
  color: var(--gold-light);
  margin-bottom: 14px;
  position: relative; z-index: 1;
}
.cta-title {
  font-family: 'Playfair Display', serif;
  font-size: clamp(28px, 4vw, 42px);
  font-weight: 500;
  color: var(--white);
  margin-bottom: 32px;
  position: relative; z-index: 1;
}
.cta-actions {
  display: flex; gap: 16px; justify-content: center; flex-wrap: wrap;
  position: relative; z-index: 1;
}
.btn-white {
  background: var(--white);
  color: var(--blue-deep);
}
.btn-white:hover {
  transform: translateY(-2px);
  box-shadow: 0 8px 24px rgba(0,0,0,0.15);
}
.btn-outline-light {
  background: transparent;
  color: var(--white);
  border: 2px solid rgba(255,255,255,0.3);
}
.btn-outline-light:hover {
  border-color: var(--gold-light);
  color: var(--gold-light);
  transform: translateY(-2px);
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
.reveal-d6 { transition-delay: 0.6s; }

/* ===== PENCIL CURSOR ===== */
body {
  cursor: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='28' height='28' viewBox='0 0 28 28'%3E%3Cg transform='translate(28,0) scale(-1,1) rotate(-45 14 14)'%3E%3Crect x='11' y='3' width='6' height='18' rx='1' fill='%23FFD700' stroke='%23001840' stroke-width='0.7'/%3E%3Crect x='11' y='3' width='6' height='4' rx='1' fill='%234A90D9' stroke='%23001840' stroke-width='0.7'/%3E%3Crect x='12' y='4' width='4' height='2' rx='0.5' fill='%236BB3E0' opacity='0.6'/%3E%3Cpolygon points='11,21 17,21 14,26' fill='%23F5DEB3' stroke='%23001840' stroke-width='0.7'/%3E%3Cpolygon points='13,24 15,24 14,26' fill='%23003087'/%3E%3C/g%3E%3C/svg%3E") 25 25, auto;
}
a, button, .feature-card, .stat-card, .news-card, .gallery-item {
  cursor: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='32' height='32' viewBox='0 0 32 32'%3E%3Cdefs%3E%3Cfilter id='g' x='-20%25' y='-20%25' width='140%25' height='140%25'%3E%3CfeGaussianBlur stdDeviation='1' result='b'/%3E%3CfeMerge%3E%3CfeMergeNode in='b'/%3E%3CfeMergeNode in='SourceGraphic'/%3E%3C/feMerge%3E%3C/filter%3E%3C/defs%3E%3Cg transform='translate(32,0) scale(-1,1) rotate(-45 16 16)' filter='url(%23g)'%3E%3Crect x='13' y='3' width='6' height='20' rx='1' fill='%23FFD700' stroke='%23001840' stroke-width='0.8'/%3E%3Crect x='13' y='3' width='6' height='4' rx='1' fill='%234A90D9' stroke='%23001840' stroke-width='0.8'/%3E%3Crect x='14' y='4' width='4' height='2' rx='0.5' fill='%236BB3E0' opacity='0.6'/%3E%3Cpolygon points='13,23 19,23 16,28' fill='%23F5DEB3' stroke='%23001840' stroke-width='0.8'/%3E%3Cpolygon points='15,26 17,26 16,28' fill='%23003087'/%3E%3C/g%3E%3C/svg%3E") 28 28, pointer;
}

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
  width: 100%; padding: 12px 16px;
  border: 2px solid var(--ice);
  border-radius: 10px;
  font-size: 15px; font-family: inherit;
  color: var(--text);
  transition: border-color 0.3s;
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

/* ===== TOUR OPTIONS CARDS ===== */
.tour-options {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 28px;
  margin: 40px 0 60px;
}
.tour-option-card {
  background: var(--white);
  border: 2px solid var(--ice);
  border-radius: 20px;
  padding: 40px 36px;
  position: relative;
  transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
  overflow: hidden;
}
.tour-option-card:hover {
  border-color: var(--blue-light);
  box-shadow: 0 20px 60px rgba(0,48,135,0.1);
  transform: translateY(-6px);
}
.tour-option-card .popular-badge {
  position: absolute; top: 20px; right: 20px;
  background: var(--gold);
  color: var(--navy-deep);
  padding: 5px 14px;
  border-radius: 20px;
  font-size: 11px;
  font-weight: 800;
  letter-spacing: 0.5px;
  text-transform: uppercase;
}
.tour-option-icon {
  font-size: 48px;
  margin-bottom: 20px;
  display: block;
}
.tour-option-card h3 {
  font-family: 'Playfair Display', serif;
  font-size: 24px; font-weight: 600;
  color: var(--text); margin: 0 0 16px;
}
.tour-detail-row {
  display: flex; align-items: center; gap: 10px;
  padding: 8px 0;
  font-size: 14px;
  color: var(--text-muted);
}
.tour-detail-row strong {
  color: var(--text);
  min-width: 80px;
}
.tour-what-list {
  margin-top: 16px;
  padding: 0;
  list-style: none;
}
.tour-what-list li {
  padding: 6px 0 6px 22px;
  position: relative;
  font-size: 14px;
  color: var(--text-muted);
}
.tour-what-list li::before {
  content: '\2713';
  position: absolute; left: 0;
  color: var(--blue);
  font-weight: 700;
  font-size: 14px;
}
.tour-facilities {
  display: flex; flex-wrap: wrap; gap: 8px;
  margin-top: 12px;
}
.tour-facilities span {
  background: var(--ice);
  color: var(--blue);
  padding: 4px 12px;
  border-radius: 20px;
  font-size: 12px;
  font-weight: 600;
}
.tour-note {
  margin-top: 16px;
  padding: 12px 16px;
  background: var(--cream-warm);
  border-radius: 10px;
  font-size: 13px;
  color: var(--text-muted);
  font-style: italic;
  border-left: 3px solid var(--gold);
}

/* ===== CAMPUS HIGHLIGHTS GRID ===== */
.highlights-section {
  padding: 80px 60px;
  background: var(--cream-warm);
}
.highlights-inner {
  max-width: 1200px; margin: 0 auto;
}
.highlights-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 24px;
  margin-top: 40px;
}
.highlight-card {
  background: var(--white);
  border-radius: 16px;
  overflow: hidden;
  transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
  border: 1px solid rgba(0,0,0,0.04);
}
.highlight-card:hover {
  transform: translateY(-6px);
  box-shadow: 0 20px 60px rgba(0,0,0,0.1);
}
.highlight-card-img {
  width: 100%;
  aspect-ratio: 4/3;
  overflow: hidden;
}
.highlight-card-img img {
  width: 100%; height: 100%; object-fit: cover;
  transition: transform 0.6s ease;
}
.highlight-card:hover .highlight-card-img img {
  transform: scale(1.06);
}
.highlight-card-body {
  padding: 22px 24px 26px;
}
.highlight-card-body h4 {
  font-family: 'Playfair Display', serif;
  font-size: 18px; font-weight: 600;
  color: var(--text);
  margin: 0 0 8px;
}
.highlight-card-body p {
  font-size: 14px;
  color: var(--text-muted);
  line-height: 1.6;
  margin: 0;
}

/* ===== MAPS SECTION ===== */
.maps-section {
  padding: 80px 60px;
  background: var(--white);
}
.maps-inner {
  max-width: 1100px; margin: 0 auto;
}
.maps-info-row {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 24px;
  margin-top: 32px;
}
.maps-info-item {
  text-align: center;
  padding: 20px;
}
.maps-info-item .maps-icon {
  font-size: 28px;
  margin-bottom: 10px;
  display: block;
}
.maps-info-item h4 {
  font-family: 'Playfair Display', serif;
  font-size: 16px; font-weight: 600;
  color: var(--text);
  margin: 0 0 6px;
}
.maps-info-item p {
  font-size: 13px;
  color: var(--text-muted);
  line-height: 1.6;
  margin: 0;
}

/* ===== FAQ ACCORDION ===== */
.faq-section {
  padding: 80px 60px;
  background: var(--cream-warm);
}
.faq-inner {
  max-width: 800px; margin: 0 auto;
}
.faq-list {
  margin-top: 40px;
}
.faq-item {
  margin-bottom: 12px;
}
.faq-item details {
  background: var(--white);
  border: 2px solid var(--ice);
  border-radius: 14px;
  overflow: hidden;
  transition: all 0.3s;
}
.faq-item details[open] {
  border-color: var(--blue);
  box-shadow: 0 8px 24px rgba(0,48,135,0.06);
}
.faq-item summary {
  padding: 18px 24px;
  font-size: 16px;
  font-weight: 700;
  color: var(--text);
  cursor: pointer;
  list-style: none;
  display: flex;
  align-items: center;
  justify-content: space-between;
  transition: color 0.3s;
}
.faq-item summary::-webkit-details-marker { display: none; }
.faq-item summary::after {
  content: '+';
  font-size: 22px;
  font-weight: 300;
  color: var(--blue);
  transition: transform 0.3s;
  flex-shrink: 0;
  margin-left: 16px;
}
.faq-item details[open] summary::after {
  content: '\2212';
  transform: rotate(180deg);
}
.faq-item details[open] summary {
  color: var(--blue);
  border-bottom: 1px solid var(--ice);
}
.faq-answer {
  padding: 18px 24px;
  font-size: 15px;
  color: var(--text-muted);
  line-height: 1.7;
}

/* ===== CONTACT CTA SECTION ===== */
.contact-cta-section {
  padding: 80px 60px;
  background: var(--blue-deep);
  text-align: center;
  position: relative;
  overflow: hidden;
}
.contact-cta-section::before, .contact-cta-section::after {
  content: '';
  position: absolute;
  border-radius: 50%;
  opacity: 0.08;
}
.contact-cta-section::before { width: 300px; height: 300px; background: var(--gold); top: -100px; right: -60px; }
.contact-cta-section::after { width: 200px; height: 200px; background: var(--coral); bottom: -80px; left: -40px; }
.contact-cta-inner {
  max-width: 700px; margin: 0 auto;
  position: relative; z-index: 1;
}
.contact-cta-inner h2 {
  font-family: 'Playfair Display', serif;
  font-size: clamp(26px, 3.5vw, 38px);
  font-weight: 500;
  color: var(--white);
  margin-bottom: 28px;
}
.contact-cta-methods {
  display: flex;
  gap: 36px;
  justify-content: center;
  flex-wrap: wrap;
  margin-top: 20px;
}
.contact-cta-method {
  text-align: center;
}
.contact-cta-method .cta-method-icon {
  font-size: 32px;
  margin-bottom: 8px;
  display: block;
}
.contact-cta-method a {
  color: var(--gold-light);
  text-decoration: none;
  font-size: 16px;
  font-weight: 700;
  transition: color 0.3s;
}
.contact-cta-method a:hover {
  color: var(--white);
}
.contact-cta-method p {
  font-size: 13px;
  color: rgba(255,255,255,0.5);
  margin-top: 4px;
}

/* ===== RADIO GROUP ===== */
.radio-group {
  display: flex; gap: 20px; flex-wrap: wrap;
}
.radio-group label {
  display: flex; align-items: center; gap: 8px;
  font-size: 15px; font-weight: 500;
  color: var(--text);
  cursor: pointer;
  padding: 10px 20px;
  border: 2px solid var(--ice);
  border-radius: 10px;
  transition: all 0.3s;
}
.radio-group label:hover {
  border-color: var(--blue-light);
  background: var(--ice);
}
.radio-group input[type="radio"] {
  width: auto;
  accent-color: var(--blue);
}
.radio-group input[type="radio"]:checked + span {
  color: var(--blue);
  font-weight: 700;
}

/* ===== RESPONSIVE ===== */
@media (max-width: 1024px) {
  .nav-inner, .page-content, .highlights-section, .maps-section, .faq-section, .contact-cta-section { padding-left: 30px !important; padding-right: 30px !important; }
  .tour-options { gap: 20px; }
  .highlights-grid { grid-template-columns: repeat(2, 1fr); }
  .maps-info-row { grid-template-columns: repeat(2, 1fr); }
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
  .tour-options { grid-template-columns: 1fr; }
  .form-row { grid-template-columns: 1fr; }
  .highlights-section { padding: 60px 20px !important; }
  .highlights-grid { grid-template-columns: 1fr; max-width: 420px; margin-left: auto; margin-right: auto; }
  .maps-section { padding: 60px 20px !important; }
  .maps-info-row { grid-template-columns: 1fr 1fr; gap: 16px; }
  .faq-section { padding: 60px 20px !important; }
  .contact-cta-section { padding: 60px 20px !important; }
  .contact-cta-methods { flex-direction: column; gap: 20px; }
  .footer-grid { grid-template-columns: 1fr; gap: 32px; }
  .footer-bottom { flex-direction: column; text-align: center; }
  .hero-btns { flex-direction: column; align-items: center; }
  .radio-group { flex-direction: column; }
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
    <a href="tel:+923135914700">&#128222; +92 313 5914700</a>
    <a href="mailto:admissions@kpms.edu.pk">&#9993; admissions@kpms.edu.pk</a>
  </div>
  <div class="topbar-right">
    <div class="topbar-translate">
      &#127760; <select onchange="if(this.value)window.open('https://translate.google.com/translate?sl=en&tl='+this.value+'&u='+location.href,'_blank')" aria-label="Translate page">
        <option value="">English</option>
        <option value="ur">&#1575;&#1585;&#1583;&#1608;</option>
        <option value="ps">&#1662;&#1690;&#1578;&#1608;</option>
        <option value="ar">&#1575;&#1604;&#1593;&#1585;&#1576;&#1610;&#1577;</option>
        <option value="zh">&#20013;&#25991;</option>
      </select>
    </div>
    <a href="/parent-portal/" class="parent-portal-btn">&#128272; Parent Portal</a>
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
        <a href="#">About Us <span class="dropdown-arrow">&#9660;</span></a>
        <div class="dropdown">
          <a href="/staff-directory/">Staff Directory</a>
          <a href="/mission-vision/">Mission &amp; Vision</a>
          <a href="/campus/">Our Campus</a>
          <a href="/contact/">Contact</a>
        </div>
      </li>
      <li>
        <a href="#">Calendar <span class="dropdown-arrow">&#9660;</span></a>
        <div class="dropdown">
          <a href="/calendar/">Upcoming Events</a>
          <a href="/calendar/">Past Events</a>
        </div>
      </li>
      <li>
        <a href="#">Academic Programs <span class="dropdown-arrow">&#9660;</span></a>
        <div class="dropdown">
          <a href="/montessori/">Montessori Program</a>
          <a href="/primary-education/">Primary Education</a>
          <a href="/tuition/">Tuition &amp; Tutoring</a>
        </div>
      </li>
      <li>
        <a href="#">Admissions <span class="dropdown-arrow">&#9660;</span></a>
        <div class="dropdown">
          <a href="/apply-online/">Apply Online</a>
          <a href="/prospectus/">View Prospectus</a>
          <a href="/schedule-tour/">Schedule a Tour</a>
        </div>
      </li>
      <li>
        <a href="#">Parents <span class="dropdown-arrow">&#9660;</span></a>
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
    <button class="search-close" onclick="toggleSearch()" aria-label="Close search">&#10005;</button>
  </div>
  <div class="search-hint">Press ESC to close</div>
</div>

<?php include get_stylesheet_directory() . '/mobile-menu.php'; ?>

<!-- PAGE HERO -->
<section class="page-hero" id="main-content" style="background: linear-gradient(160deg, rgba(0,24,64,0.88) 0%, rgba(0,48,135,0.7) 50%, rgba(0,24,64,0.82) 100%), url('https://images.unsplash.com/photo-1580582932707-520aed937b7b?w=1920&q=85') center/cover;">
  <div class="page-hero-label">Admissions</div>
  <h1 class="page-hero-title">Schedule a Tour</h1>
  <p class="page-hero-subtitle">Experience the warmth and excellence of KPMS firsthand &mdash; we'd love to show you around</p>
  <div class="page-breadcrumb"><a href="/">Home</a> / <a href="/apply-online/">Admissions</a> / Schedule a Tour</div>
</section>

<div class="page-content">

  <!-- SECTION 1: Tour Options -->
  <div style="text-align:center; margin-bottom:10px;">
    <div class="section-label">Choose Your Experience</div>
    <h2 style="margin-bottom:8px;">Tour Options</h2>
    <p style="max-width:560px; margin:0 auto;">Select the tour format that works best for your family</p>
  </div>

  <div class="tour-options reveal">
    <!-- In-Person Visit Card -->
    <div class="tour-option-card">
      <span class="popular-badge">Most Popular</span>
      <span class="tour-option-icon">&#127979;</span>
      <h3>In-Person Visit</h3>
      <div class="tour-detail-row"><strong>Available:</strong> Monday &ndash; Friday, 9:00 AM &ndash; 2:00 PM</div>
      <div class="tour-detail-row"><strong>Duration:</strong> 45 &ndash; 60 minutes</div>
      <h4 style="font-size:14px; font-weight:700; color:var(--blue-deep); margin-top:20px; margin-bottom:8px;">What to Expect</h4>
      <ul class="tour-what-list">
        <li>Campus walkthrough</li>
        <li>Classroom observation</li>
        <li>Meet the principal</li>
        <li>Q&amp;A session</li>
      </ul>
      <h4 style="font-size:14px; font-weight:700; color:var(--blue-deep); margin-top:20px; margin-bottom:8px;">What You'll See</h4>
      <div class="tour-facilities">
        <span>Classrooms</span>
        <span>Library</span>
        <span>Science Lab</span>
        <span>Computer Lab</span>
        <span>Playground</span>
        <span>Assembly Hall</span>
      </div>
    </div>

    <!-- Virtual Tour Card -->
    <div class="tour-option-card">
      <span class="tour-option-icon">&#128187;</span>
      <h3>Virtual Tour</h3>
      <div class="tour-detail-row"><strong>Available:</strong> Monday &ndash; Friday, 10:00 AM &ndash; 4:00 PM</div>
      <div class="tour-detail-row"><strong>Duration:</strong> 30 minutes via Zoom</div>
      <h4 style="font-size:14px; font-weight:700; color:var(--blue-deep); margin-top:20px; margin-bottom:8px;">What's Covered</h4>
      <ul class="tour-what-list">
        <li>Video walkthrough</li>
        <li>Program overview</li>
        <li>Admissions info</li>
        <li>Live Q&amp;A</li>
      </ul>
      <div class="tour-note">Perfect for families outside Abbottabad</div>
    </div>
  </div>

  <!-- SECTION 2: Tour Scheduling Form -->
  <div style="text-align:center; margin-top:60px;">
    <div class="section-label">Book Your Visit</div>
    <h2>Schedule Your Tour</h2>
    <p style="max-width:520px; margin:0 auto;">Fill out the form below and we'll confirm your visit within 24 hours</p>
  </div>

  <?php $kpms_nonce = wp_create_nonce('kpms_form_nonce'); $kpms_ajax = admin_url('admin-ajax.php'); ?>
  <script>window.kpmsAjax={url:"<?php echo esc_url($kpms_ajax); ?>",nonce:"<?php echo esc_attr($kpms_nonce); ?>"};</script>
  <form class="kpms-form reveal" id="tourForm" novalidate>
    <input type="hidden" name="form_type" value="tour">
    <div class="form-row">
      <div class="form-group">
        <label for="parent-name">Parent/Guardian Name *</label>
        <input type="text" id="parent-name" name="parent_name" placeholder="Full name" required>
        <div class="form-error" style="display:none;color:#e74c3c;font-size:12px;margin-top:4px;">Required</div>
      </div>
      <div class="form-group">
        <label for="email">Email Address *</label>
        <input type="email" id="email" name="email" placeholder="you@example.com" required>
        <div class="form-error" style="display:none;color:#e74c3c;font-size:12px;margin-top:4px;">Valid email required</div>
      </div>
    </div>
    <div class="form-row">
      <div class="form-group">
        <label for="phone">Phone Number *</label>
        <input type="tel" id="phone" name="phone" placeholder="+92 3XX XXXXXXX" required>
        <div class="form-error" style="display:none;color:#e74c3c;font-size:12px;margin-top:4px;">Required</div>
      </div>
      <div class="form-group">
        <label for="preferred-date">Preferred Date *</label>
        <input type="date" id="preferred-date" name="preferred_date" required>
        <div class="form-error" style="display:none;color:#e74c3c;font-size:12px;margin-top:4px;">Required</div>
      </div>
    </div>
    <div class="form-row">
      <div class="form-group">
        <label for="preferred-time">Preferred Time *</label>
        <select id="preferred-time" name="preferred_time" required>
          <option value="">Select a time</option>
          <option value="9:00 AM">9:00 AM</option>
          <option value="10:00 AM">10:00 AM</option>
          <option value="11:00 AM">11:00 AM</option>
          <option value="12:00 PM">12:00 PM</option>
          <option value="1:00 PM">1:00 PM</option>
          <option value="2:00 PM">2:00 PM</option>
        </select>
        <div class="form-error" style="display:none;color:#e74c3c;font-size:12px;margin-top:4px;">Required</div>
      </div>
      <div class="form-group">
        <label for="grade-interest">Grade of Interest *</label>
        <select id="grade-interest" name="grade_interest" required>
          <option value="">Select grade level</option>
          <option value="Nursery">Nursery</option>
          <option value="Pre-K">Pre-K</option>
          <option value="KG">KG</option>
          <option value="Grade 1">Grade 1</option>
          <option value="Grade 2">Grade 2</option>
          <option value="Grade 3">Grade 3</option>
          <option value="Grade 4">Grade 4</option>
          <option value="Grade 5">Grade 5</option>
        </select>
        <div class="form-error" style="display:none;color:#e74c3c;font-size:12px;margin-top:4px;">Required</div>
      </div>
    </div>
    <div class="form-group">
      <label>Tour Type *</label>
      <div class="radio-group">
        <label><input type="radio" name="tour_type" value="in-person" required> <span>In-Person Visit</span></label>
        <label><input type="radio" name="tour_type" value="virtual"> <span>Virtual Tour</span></label>
      </div>
      <div class="form-error" style="display:none;color:#e74c3c;font-size:12px;margin-top:4px;">Please select tour type</div>
    </div>
    <div class="form-group">
      <label for="attendees">Number of Attendees</label>
      <select id="attendees" name="attendees">
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
      </select>
    </div>
    <div class="form-group">
      <label for="questions">Questions or Special Requests</label>
      <textarea id="questions" name="questions" rows="4" placeholder="Any questions or special accommodations we should know about?"></textarea>
    </div>
    <div style="text-align:center; margin-top:10px;">
      <button type="submit" id="tourSubmitBtn" class="btn" style="padding:16px 48px; font-size:16px; border:none; border-radius:10px; background:linear-gradient(135deg, var(--blue) 0%, var(--blue-deep) 100%); color:white; font-weight:700; letter-spacing:0.8px; text-transform:uppercase; transition:all 0.35s cubic-bezier(0.16,1,0.3,1); box-shadow:0 6px 20px rgba(0,48,135,0.25);">Schedule My Visit</button>
    </div>
    <div id="tourFormMsg" style="display:none; text-align:center; margin-top:20px; padding:16px 24px; border-radius:10px; font-weight:600;"></div>
  </form>

  <script>
  document.getElementById('tourForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    const form = this;
    const btn = document.getElementById('tourSubmitBtn');
    const msgDiv = document.getElementById('tourFormMsg');

    form.querySelectorAll('.form-error').forEach(el => el.style.display = 'none');
    msgDiv.style.display = 'none';

    let valid = true;
    ['parent_name','email','phone','preferred_date','preferred_time','grade_interest'].forEach(name => {
      const el = form.querySelector('[name="'+name+'"]');
      if (el && !el.value.trim()) {
        const err = el.parentElement.querySelector('.form-error');
        if (err) err.style.display = 'block';
        valid = false;
      }
    });
    const emailEl = form.querySelector('[name="email"]');
    if (emailEl && emailEl.value && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(emailEl.value)) {
      emailEl.parentElement.querySelector('.form-error').style.display = 'block';
      valid = false;
    }
    if (!form.querySelector('[name="tour_type"]:checked')) {
      form.querySelector('.radio-group').parentElement.querySelector('.form-error').style.display = 'block';
      valid = false;
    }

    if (!valid) { form.querySelector('.form-error[style*="block"]')?.scrollIntoView({behavior:'smooth',block:'center'}); return; }

    btn.disabled = true;
    const origText = btn.textContent;
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
        msgDiv.textContent = json.data?.message || 'Something went wrong.';
      }
    } catch(err) {
      msgDiv.style.cssText = 'display:block;text-align:center;margin-top:20px;padding:16px 24px;border-radius:10px;font-weight:600;background:#f8d7da;color:#721c24;';
      msgDiv.textContent = 'Network error. Please check your connection.';
    }
    btn.disabled = false;
    btn.textContent = origText;
  });
  </script>

</div>

<!-- SECTION 3: Campus Highlights -->
<section class="highlights-section">
  <div class="highlights-inner">
    <div style="text-align:center;">
      <div class="section-label">Explore Our Campus</div>
      <h2 class="section-title">Campus Highlights</h2>
      <p class="section-subtitle">Discover the spaces where our students learn, play, and grow</p>
    </div>
    <div class="highlights-grid">
      <div class="highlight-card reveal reveal-d1">
        <div class="highlight-card-img">
          <img src="https://images.unsplash.com/photo-1580582932707-520aed937b7b?w=600&q=80" alt="Modern Classrooms" loading="lazy">
        </div>
        <div class="highlight-card-body">
          <h4>Modern Classrooms</h4>
          <p>Bright, spacious rooms designed for optimal learning</p>
        </div>
      </div>
      <div class="highlight-card reveal reveal-d2">
        <div class="highlight-card-img">
          <img src="https://images.unsplash.com/photo-1521587760476-6c12a4b040da?w=600&q=80" alt="Library" loading="lazy">
        </div>
        <div class="highlight-card-body">
          <h4>Library</h4>
          <p>Over 2,000 books and a dedicated reading corner</p>
        </div>
      </div>
      <div class="highlight-card reveal reveal-d3">
        <div class="highlight-card-img">
          <img src="https://images.unsplash.com/photo-1532094349884-543bc11b234d?w=600&q=80" alt="Science Lab" loading="lazy">
        </div>
        <div class="highlight-card-body">
          <h4>Science Lab</h4>
          <p>Hands-on experiments that bring science to life</p>
        </div>
      </div>
      <div class="highlight-card reveal reveal-d4">
        <div class="highlight-card-img">
          <img src="https://images.unsplash.com/photo-1516321497487-e288fb19713f?w=600&q=80" alt="Computer Lab" loading="lazy">
        </div>
        <div class="highlight-card-body">
          <h4>Computer Lab</h4>
          <p>Digital literacy from an early age</p>
        </div>
      </div>
      <div class="highlight-card reveal reveal-d5">
        <div class="highlight-card-img">
          <img src="https://images.unsplash.com/photo-1564429238961-bf8b8cd0e8b5?w=600&q=80" alt="Playground" loading="lazy">
        </div>
        <div class="highlight-card-body">
          <h4>Playground</h4>
          <p>Safe outdoor spaces for play and physical development</p>
        </div>
      </div>
      <div class="highlight-card reveal reveal-d6">
        <div class="highlight-card-img">
          <img src="https://images.unsplash.com/photo-1540575467063-178a50c2df87?w=600&q=80" alt="Assembly Hall" loading="lazy">
        </div>
        <div class="highlight-card-body">
          <h4>Assembly Hall</h4>
          <p>Where our community comes together</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- SECTION 4: Google Maps -->
<section class="maps-section">
  <div class="maps-inner">
    <div style="text-align:center;">
      <div class="section-label">Location</div>
      <h2 class="section-title">Find Us</h2>
    </div>
    <div style="margin-top:32px; border-radius:16px; overflow:hidden; box-shadow: 0 12px 40px rgba(0,0,0,0.1);">
      <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3307.0!2d73.2215!3d34.1688!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMzTCsDEwJzA3LjciTiA3M8KwMTMnMTcuNCJF!5e0!3m2!1sen!2spk!4v1700000000000" width="100%" height="400" style="border:0;border-radius:16px;" allowfullscreen="" loading="lazy"></iframe>
    </div>
    <div class="maps-info-row reveal">
      <div class="maps-info-item">
        <span class="maps-icon">&#128205;</span>
        <h4>Address</h4>
        <p>Sheikh ul Bandi Road<br>Abbottabad, KPK 22010<br>Pakistan</p>
      </div>
      <div class="maps-info-item">
        <span class="maps-icon">&#128222;</span>
        <h4>Phone</h4>
        <p>+92 313 5914700</p>
      </div>
      <div class="maps-info-item">
        <span class="maps-icon">&#9993;</span>
        <h4>Email</h4>
        <p>admissions@kpms.edu.pk</p>
      </div>
      <div class="maps-info-item">
        <span class="maps-icon">&#128336;</span>
        <h4>Office Hours</h4>
        <p>Mon &ndash; Sat<br>8:00 AM &ndash; 3:00 PM</p>
      </div>
    </div>
  </div>
</section>

<!-- SECTION 5: FAQ -->
<section class="faq-section">
  <div class="faq-inner">
    <div style="text-align:center;">
      <div class="section-label">Common Questions</div>
      <h2 class="section-title">Frequently Asked Questions</h2>
    </div>
    <div class="faq-list">
      <div class="faq-item reveal">
        <details>
          <summary>What should I bring to the tour?</summary>
          <div class="faq-answer">Just yourselves! We recommend comfortable shoes for walking the campus.</div>
        </details>
      </div>
      <div class="faq-item reveal">
        <details>
          <summary>Can my child come along?</summary>
          <div class="faq-answer">Absolutely! We encourage prospective students to visit.</div>
        </details>
      </div>
      <div class="faq-item reveal">
        <details>
          <summary>How long does the tour take?</summary>
          <div class="faq-answer">In-person tours last 45&ndash;60 minutes. Virtual tours are about 30 minutes.</div>
        </details>
      </div>
      <div class="faq-item reveal">
        <details>
          <summary>Is there parking available?</summary>
          <div class="faq-answer">Yes, free parking is available on campus.</div>
        </details>
      </div>
      <div class="faq-item reveal">
        <details>
          <summary>Can I meet the teachers?</summary>
          <div class="faq-answer">During school hours, you may briefly observe classes in session.</div>
        </details>
      </div>
      <div class="faq-item reveal">
        <details>
          <summary>What if I need to reschedule?</summary>
          <div class="faq-answer">No problem! Just email or call us at least 24 hours in advance.</div>
        </details>
      </div>
    </div>
  </div>
</section>

<!-- SECTION 6: Contact CTA -->
<section class="contact-cta-section">
  <div class="contact-cta-inner reveal">
    <div class="section-label" style="color:var(--gold-light);">Ready to Connect?</div>
    <h2>Can't Wait? Contact Us Directly</h2>
    <div class="contact-cta-methods">
      <div class="contact-cta-method">
        <span class="cta-method-icon">&#128222;</span>
        <a href="tel:+923135914700">+92 313 5914700</a>
        <p>Call us directly</p>
      </div>
      <div class="contact-cta-method">
        <span class="cta-method-icon">&#9993;</span>
        <a href="mailto:admissions@kpms.edu.pk">admissions@kpms.edu.pk</a>
        <p>Email us anytime</p>
      </div>
      <div class="contact-cta-method">
        <span class="cta-method-icon">&#128172;</span>
        <a href="https://wa.me/+923135914700">Chat on WhatsApp</a>
        <p>Quick response guaranteed</p>
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
        <div class="footer-contact">&#128205; Sheikh ul Bandi, Abbottabad, KPK</div>
        <div class="footer-contact">&#128222; +92 313 5914700</div>
        <div class="footer-contact">&#9993; info@kpms.edu.pk</div>
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
        <a href="/">Anti&#8209;Discrimination</a>
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

// Set minimum date for date input to today
(function() {
  const dateInput = document.getElementById('preferred-date');
  if (dateInput) {
    const today = new Date();
    const yyyy = today.getFullYear();
    const mm = String(today.getMonth() + 1).padStart(2, '0');
    const dd = String(today.getDate()).padStart(2, '0');
    dateInput.setAttribute('min', yyyy + '-' + mm + '-' + dd);
  }
})();
</script>


</body>
</html>
