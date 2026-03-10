<?php
/*
Template Name: KPMS - Montessori Program
*/
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Montessori Program – KPMS | Kamal Public Middle School Abbottabad</title>
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

/* ===== SECTION LABELS & TITLES ===== */
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

/* ===== BUTTONS ===== */
.btn {
  padding: 14px 36px;
  border-radius: 8px;
  font-family: 'DM Sans', sans-serif;
  font-size: 14px; font-weight: 700;
  letter-spacing: 0.8px; text-transform: uppercase;
  text-decoration: none;
  cursor: pointer; border: none;
  transition: all 0.35s cubic-bezier(0.16, 1, 0.3, 1);
  display: inline-block;
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
.btn-blue {
  background: var(--blue);
  color: var(--white);
}
.btn-blue:hover {
  background: var(--blue-deep);
  transform: translateY(-2px);
  box-shadow: 0 8px 24px rgba(0,48,135,0.35);
}

/* ===== INNER PAGE STYLES ===== */
.page-hero {
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
  content: '✦'; position: absolute; left: 0;
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

/* ===== PHOTO GALLERY ===== */
.gallery {
  padding: 100px 60px;
  background: var(--white);
}
.gallery-inner { max-width: 1300px; margin: 0 auto; }
.gallery-grid {
  display: grid;
  grid-template-columns: repeat(12, 1fr);
  grid-template-rows: 260px 260px;
  gap: 16px;
  margin-top: 50px;
}
.gallery-item {
  border-radius: 14px;
  overflow: hidden;
  position: relative;
}
.gallery-item img {
  width: 100%; height: 100%; object-fit: cover;
  transition: transform 0.6s ease;
}
.gallery-item:hover img { transform: scale(1.05); }
.gallery-item:nth-child(1) { grid-column: 1/6; }
.gallery-item:nth-child(2) { grid-column: 6/9; }
.gallery-item:nth-child(3) { grid-column: 9/13; }
.gallery-item:nth-child(4) { grid-column: 1/5; }
.gallery-item:nth-child(5) { grid-column: 5/9; }
.gallery-item:nth-child(6) { grid-column: 9/13; }
.gallery-label {
  position: absolute; bottom: 14px; left: 14px;
  background: rgba(28,42,58,0.85);
  backdrop-filter: blur(8px);
  padding: 7px 14px;
  border-radius: 8px;
  font-size: 12px; font-weight: 600;
  color: white;
  letter-spacing: 0.3px;
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

/* ===== PENCIL CURSOR ===== */
body {
  cursor: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='28' height='28' viewBox='0 0 28 28'%3E%3Cg transform='translate(28,0) scale(-1,1) rotate(-45 14 14)'%3E%3Crect x='11' y='3' width='6' height='18' rx='1' fill='%23FFD700' stroke='%23001840' stroke-width='0.7'/%3E%3Crect x='11' y='3' width='6' height='4' rx='1' fill='%234A90D9' stroke='%23001840' stroke-width='0.7'/%3E%3Crect x='12' y='4' width='4' height='2' rx='0.5' fill='%236BB3E0' opacity='0.6'/%3E%3Cpolygon points='11,21 17,21 14,26' fill='%23F5DEB3' stroke='%23001840' stroke-width='0.7'/%3E%3Cpolygon points='13,24 15,24 14,26' fill='%23003087'/%3E%3C/g%3E%3C/svg%3E") 25 25, auto;
}
a, button, .feature-card, .stat-card, .news-card, .gallery-item {
  cursor: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='32' height='32' viewBox='0 0 32 32'%3E%3Cdefs%3E%3Cfilter id='g' x='-20%25' y='-20%25' width='140%25' height='140%25'%3E%3CfeGaussianBlur stdDeviation='1' result='b'/%3E%3CfeMerge%3E%3CfeMergeNode in='b'/%3E%3CfeMergeNode in='SourceGraphic'/%3E%3C/feMerge%3E%3C/filter%3E%3C/defs%3E%3Cg transform='translate(32,0) scale(-1,1) rotate(-45 16 16)' filter='url(%23g)'%3E%3Crect x='13' y='3' width='6' height='20' rx='1' fill='%23FFD700' stroke='%23001840' stroke-width='0.8'/%3E%3Crect x='13' y='3' width='6' height='4' rx='1' fill='%234A90D9' stroke='%23001840' stroke-width='0.8'/%3E%3Crect x='14' y='4' width='4' height='2' rx='0.5' fill='%236BB3E0' opacity='0.6'/%3E%3Cpolygon points='13,23 19,23 16,28' fill='%23F5DEB3' stroke='%23001840' stroke-width='0.8'/%3E%3Cpolygon points='15,26 17,26 16,28' fill='%23003087'/%3E%3C/g%3E%3C/svg%3E") 28 28, pointer;
}


@keyframes fadeUp {
  from { opacity: 0; transform: translateY(28px); }
  to { opacity: 1; transform: translateY(0); }
}

/* ===== MONTESSORI PAGE-SPECIFIC STYLES ===== */

/* What is Montessori Section */
.montessori-intro {
  padding: 100px 60px;
  background: var(--white);
}
.montessori-intro-inner {
  max-width: 1200px; margin: 0 auto;
}
.montessori-intro-text {
  max-width: 800px; margin: 0 auto 50px;
  text-align: center;
}
.montessori-intro-text p {
  font-size: 17px; line-height: 1.85;
  color: var(--text-muted);
}
.principles-grid {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 24px;
}
.principle-card {
  background: var(--white);
  border: 2px solid var(--ice);
  border-radius: 16px;
  padding: 36px 28px;
  text-align: center;
  transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
}
.principle-card:hover {
  border-color: var(--blue-light);
  box-shadow: 0 16px 48px rgba(0,48,135,0.1);
  transform: translateY(-5px);
}
.principle-icon {
  font-size: 48px;
  margin-bottom: 18px;
  display: block;
  transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1);
}
.principle-card:hover .principle-icon {
  transform: scale(1.2);
}
.principle-card h3 {
  font-family: 'Playfair Display', serif;
  font-size: 20px; font-weight: 600;
  color: var(--text);
  margin-bottom: 10px;
}
.principle-card p {
  font-size: 14px; color: var(--text-muted);
  line-height: 1.7;
}

/* Age Groups Section */
.age-groups {
  padding: 100px 60px;
  background: var(--cream-warm);
}
.age-groups-inner {
  max-width: 1200px; margin: 0 auto;
}
.age-groups-header {
  text-align: center;
  margin-bottom: 50px;
}
.age-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 28px;
}
.age-card {
  background: var(--white);
  border-radius: 20px;
  overflow: hidden;
  transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
  box-shadow: 0 4px 20px rgba(0,0,0,0.04);
}
.age-card:hover {
  transform: translateY(-6px);
  box-shadow: 0 20px 60px rgba(0,0,0,0.1);
}
.age-card-img {
  width: 100%; height: 220px;
  overflow: hidden;
}
.age-card-img img {
  width: 100%; height: 100%; object-fit: cover;
  transition: transform 0.6s ease;
}
.age-card:hover .age-card-img img {
  transform: scale(1.06);
}
.age-card-body {
  padding: 28px;
}
.age-badge {
  display: inline-block;
  background: var(--ice);
  color: var(--blue);
  font-size: 12px; font-weight: 700;
  letter-spacing: 1px; text-transform: uppercase;
  padding: 5px 14px;
  border-radius: 20px;
  margin-bottom: 12px;
}
.age-card h3 {
  font-family: 'Playfair Display', serif;
  font-size: 22px; font-weight: 600;
  color: var(--text);
  margin-bottom: 12px;
}
.age-card p {
  font-size: 14px; color: var(--text-muted);
  line-height: 1.75;
}
.age-highlights {
  list-style: none; padding: 0; margin-top: 16px;
}
.age-highlights li {
  padding: 6px 0 6px 22px;
  position: relative;
  font-size: 13px; color: var(--text-muted);
  font-weight: 500;
}
.age-highlights li::before {
  content: '✦';
  position: absolute; left: 0;
  color: var(--gold); font-size: 11px;
}

/* Key Features Grid */
.features-section {
  padding: 100px 60px;
  background: var(--white);
}
.features-section-inner {
  max-width: 1200px; margin: 0 auto;
}
.features-section-header {
  text-align: center;
  margin-bottom: 50px;
}
.feature-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 24px;
}
.feature-grid-card {
  background: var(--white);
  border: 2px solid var(--ice);
  border-radius: 16px;
  padding: 36px 28px;
  transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
  position: relative;
  overflow: hidden;
}
.feature-grid-card::before {
  content: '';
  position: absolute; top: 0; left: 0;
  width: 4px; height: 0;
  background: var(--blue);
  border-radius: 0 0 4px 0;
  transition: height 0.4s cubic-bezier(0.16, 1, 0.3, 1);
}
.feature-grid-card:hover::before {
  height: 100%;
}
.feature-grid-card:hover {
  border-color: var(--blue-light);
  box-shadow: 0 16px 48px rgba(0,48,135,0.08);
  transform: translateY(-5px);
}
.feature-grid-icon {
  font-size: 40px;
  margin-bottom: 18px;
  display: block;
  transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1);
}
.feature-grid-card:hover .feature-grid-icon {
  transform: scale(1.15);
}
.feature-grid-card h3 {
  font-family: 'Playfair Display', serif;
  font-size: 19px; font-weight: 600;
  color: var(--text);
  margin-bottom: 10px;
}
.feature-grid-card p {
  font-size: 14px; color: var(--text-muted);
  line-height: 1.7;
}

/* Daily Schedule Section */
.schedule-section {
  padding: 100px 60px;
  background: var(--cream-warm);
}
.schedule-inner {
  max-width: 900px; margin: 0 auto;
}
.schedule-header {
  text-align: center;
  margin-bottom: 50px;
}
.schedule-timeline {
  position: relative;
}
.schedule-timeline::before {
  content: '';
  position: absolute;
  left: 32px; top: 0; bottom: 0;
  width: 3px;
  background: var(--ice);
  border-radius: 3px;
}
.schedule-item {
  display: flex;
  gap: 24px;
  align-items: flex-start;
  margin-bottom: 0;
  padding: 18px 0;
  position: relative;
  transition: all 0.3s;
}
.schedule-item:hover {
  transform: translateX(6px);
}
.schedule-dot {
  width: 20px; height: 20px;
  border-radius: 50%;
  background: var(--blue);
  border: 4px solid var(--cream-warm);
  flex-shrink: 0;
  position: relative;
  z-index: 1;
  margin-left: 23px;
  margin-top: 4px;
  transition: all 0.3s;
}
.schedule-item:hover .schedule-dot {
  background: var(--gold);
  transform: scale(1.2);
  box-shadow: 0 0 0 4px rgba(255,209,0,0.3);
}
.schedule-time {
  min-width: 90px;
  font-size: 15px; font-weight: 700;
  color: var(--blue);
  padding-top: 2px;
}
.schedule-content {
  flex: 1;
  background: var(--white);
  border-radius: 12px;
  padding: 18px 24px;
  border: 2px solid var(--ice);
  transition: all 0.3s;
}
.schedule-item:hover .schedule-content {
  border-color: var(--blue-light);
  box-shadow: 0 8px 24px rgba(0,48,135,0.06);
}
.schedule-content h4 {
  font-family: 'Playfair Display', serif;
  font-size: 17px; font-weight: 600;
  color: var(--text);
  margin-bottom: 4px;
}
.schedule-content p {
  font-size: 13px; color: var(--text-muted);
  line-height: 1.6;
  margin: 0;
}

/* Gallery Section for Montessori */
.montessori-gallery {
  padding: 100px 60px;
  background: var(--white);
}
.montessori-gallery-inner {
  max-width: 1300px; margin: 0 auto;
}
.montessori-gallery-header {
  text-align: center;
  margin-bottom: 50px;
}

/* Testimonials Section */
.testimonials {
  padding: 100px 60px;
  background: var(--cream-warm);
}
.testimonials-inner {
  max-width: 1200px; margin: 0 auto;
}
.testimonials-header {
  text-align: center;
  margin-bottom: 50px;
}
.testimonials-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 28px;
}
.testimonial-card {
  background: var(--white);
  border-radius: 20px;
  padding: 36px 32px;
  position: relative;
  transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
  box-shadow: 0 4px 20px rgba(0,0,0,0.03);
}
.testimonial-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 20px 60px rgba(0,0,0,0.08);
}
.testimonial-quote-mark {
  font-family: 'Playfair Display', serif;
  font-size: 72px;
  line-height: 1;
  color: var(--gold);
  opacity: 0.4;
  position: absolute;
  top: 20px; left: 28px;
}
.testimonial-text {
  font-size: 15px;
  color: var(--text-muted);
  line-height: 1.8;
  font-style: italic;
  margin-bottom: 20px;
  padding-top: 30px;
  position: relative;
  z-index: 1;
}
.testimonial-author {
  display: flex;
  align-items: center;
  gap: 12px;
}
.testimonial-avatar {
  width: 48px; height: 48px;
  border-radius: 50%;
  background: var(--blue);
  color: var(--white);
  display: flex;
  align-items: center;
  justify-content: center;
  font-family: 'Playfair Display', serif;
  font-size: 18px; font-weight: 600;
  flex-shrink: 0;
}
.testimonial-name {
  font-size: 15px; font-weight: 700;
  color: var(--text);
}
.testimonial-role {
  font-size: 12px; color: var(--text-muted);
  font-weight: 500;
}

/* Montessori CTA */
.montessori-cta {
  padding: 90px 60px;
  background: var(--blue-deep);
  text-align: center;
  position: relative;
  overflow: hidden;
}
.montessori-cta::before, .montessori-cta::after {
  content: '';
  position: absolute;
  border-radius: 50%;
  opacity: 0.08;
}
.montessori-cta::before { width: 350px; height: 350px; background: var(--gold); top: -120px; right: -80px; }
.montessori-cta::after { width: 220px; height: 220px; background: var(--coral); bottom: -90px; left: -50px; }

/* ===== RESPONSIVE ===== */
@media (max-width: 1024px) {
  .nav-inner, section, .montessori-intro, .age-groups, .features-section,
  .schedule-section, .montessori-gallery, .testimonials, .montessori-cta,
  .gallery, .cta, .footer {
    padding-left: 30px !important;
    padding-right: 30px !important;
  }
  .principles-grid { grid-template-columns: repeat(2, 1fr); }
  .age-grid { grid-template-columns: repeat(2, 1fr); }
  .age-grid .age-card:nth-child(3) { grid-column: 1 / -1; max-width: 450px; margin: 0 auto; }
  .feature-grid { grid-template-columns: repeat(2, 1fr); }
  .testimonials-grid { grid-template-columns: repeat(2, 1fr); }
  .testimonials-grid .testimonial-card:nth-child(3) { grid-column: 1 / -1; max-width: 450px; margin: 0 auto; }
  .gallery-grid { grid-template-rows: 200px 200px; }
  .footer-grid { grid-template-columns: 1fr 1fr; }
}

@media (max-width: 768px) {
  .topbar { display: none; }
  .nav-menu { display: none; }
  .nav-search-btn { display: none; }
  .mobile-toggle { display: block; }
  .nav-inner { padding: 0 20px !important; height: 64px; }
  section, .montessori-intro, .age-groups, .features-section,
  .schedule-section, .montessori-gallery, .testimonials, .montessori-cta,
  .gallery, .cta, .footer {
    padding-left: 20px !important;
    padding-right: 20px !important;
  }
  .principles-grid { grid-template-columns: 1fr; max-width: 400px; margin: 0 auto; }
  .age-grid { grid-template-columns: 1fr; }
  .age-grid .age-card:nth-child(3) { max-width: none; }
  .feature-grid { grid-template-columns: 1fr; }
  .testimonials-grid { grid-template-columns: 1fr; }
  .testimonials-grid .testimonial-card:nth-child(3) { max-width: none; }
  .gallery-grid {
    grid-template-columns: 1fr 1fr;
    grid-template-rows: repeat(3, 180px);
  }
  .gallery-item:nth-child(1) { grid-column: 1/3; }
  .gallery-item:nth-child(2) { grid-column: 1/2; }
  .gallery-item:nth-child(3) { grid-column: 2/3; }
  .gallery-item:nth-child(4) { grid-column: 1/2; }
  .gallery-item:nth-child(5) { grid-column: 2/3; }
  .gallery-item:nth-child(6) { grid-column: 1/3; }
  .footer-grid { grid-template-columns: 1fr; gap: 32px; }
  .footer-bottom { flex-direction: column; text-align: center; }
  .page-hero { padding: 120px 20px 60px; }
  .page-content { padding: 40px 20px; }
  .schedule-timeline::before { left: 22px; }
  .schedule-dot { margin-left: 13px; }
  .schedule-item { gap: 14px; }
  .schedule-time { min-width: 70px; font-size: 13px; }
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
    <button class="search-close" onclick="toggleSearch()" aria-label="Close search">✕</button>
  </div>
  <div class="search-hint">Press ESC to close</div>
</div>

<?php include get_stylesheet_directory() . '/mobile-menu.php'; ?>


<!-- PAGE HERO -->
<section class="page-hero" style="background: linear-gradient(160deg, rgba(0,24,64,0.88) 0%, rgba(0,48,135,0.7) 50%, rgba(0,24,64,0.82) 100%), url('https://images.unsplash.com/photo-1503676260728-1c00da094a0b?w=1920&q=85') center/cover;">
  <div class="page-hero-label">Academic Programs</div>
  <h1 class="page-hero-title">Montessori Program</h1>
  <p class="page-hero-subtitle">Nurturing independence, creativity, and a lifelong love of learning for ages 3-6</p>
  <div class="page-breadcrumb"><a href="/">Home</a> / <a href="/montessori/">Academic Programs</a> / Montessori</div>
</section>


<!-- ===== SECTION 1: WHAT IS MONTESSORI? ===== -->
<section class="montessori-intro" id="main-content">
  <div class="montessori-intro-inner">

    <div class="montessori-intro-text reveal">
      <div class="section-label">Our Philosophy</div>
      <h2 class="section-title" style="margin-bottom:20px;">What is Montessori Education?</h2>
      <p>The Montessori method, founded by Dr. Maria Montessori, is a child-centered educational approach that values the human spirit and the development of the whole child -- physical, social, emotional, and cognitive. At KPMS, our Montessori program provides a carefully prepared environment where children ages 3 to 6 can explore, discover, and learn at their own pace, guided by trained educators who respect each child's unique developmental journey.</p>
    </div>

    <div class="principles-grid">
      <div class="principle-card reveal reveal-d1">
        <span class="principle-icon">🌱</span>
        <h3>Independence</h3>
        <p>Children are encouraged to do things for themselves, building confidence and self-reliance through everyday tasks and purposeful activities.</p>
      </div>
      <div class="principle-card reveal reveal-d2">
        <span class="principle-icon">🤝</span>
        <h3>Respect</h3>
        <p>We cultivate mutual respect between children, teachers, and the environment, teaching grace, courtesy, and empathy from the earliest age.</p>
      </div>
      <div class="principle-card reveal reveal-d3">
        <span class="principle-icon">🧩</span>
        <h3>Hands-on Learning</h3>
        <p>Specially designed materials engage the senses and allow children to explore abstract concepts through concrete, tactile experiences.</p>
      </div>
      <div class="principle-card reveal reveal-d1">
        <span class="principle-icon">🏡</span>
        <h3>Prepared Environment</h3>
        <p>Our classrooms are thoughtfully organized spaces where every material has a purpose, inviting children to explore and learn independently.</p>
      </div>
    </div>

  </div>
</section>


<!-- ===== SECTION 2: AGE GROUPS ===== -->
<section class="age-groups">
  <div class="age-groups-inner">

    <div class="age-groups-header reveal">
      <div class="section-label">Programs by Age</div>
      <h2 class="section-title">Our Montessori Age Groups</h2>
      <p class="section-subtitle">Tailored learning experiences for every stage of early development</p>
    </div>

    <div class="age-grid">

      <div class="age-card reveal reveal-d1">
        <div class="age-card-img">
          <img src="https://images.unsplash.com/photo-1587654780291-39c9404d7dd0?w=600&q=80" alt="Nursery children at KPMS" loading="lazy">
        </div>
        <div class="age-card-body">
          <span class="age-badge">Ages 3-4</span>
          <h3>Nursery</h3>
          <p>Our youngest learners begin their educational journey through play, sensory exploration, and gentle socialization in a warm, nurturing environment.</p>
          <ul class="age-highlights">
            <li>Sensory exploration and fine motor skills</li>
            <li>Language development through stories and songs</li>
            <li>Practical life activities (pouring, sorting, buttoning)</li>
            <li>Social skills and group interaction</li>
          </ul>
        </div>
      </div>

      <div class="age-card reveal reveal-d2">
        <div class="age-card-img">
          <img src="https://images.unsplash.com/photo-1596464716127-f2a82984de30?w=600&q=80" alt="Pre-K students learning at KPMS" loading="lazy">
        </div>
        <div class="age-card-body">
          <span class="age-badge">Ages 4-5</span>
          <h3>Pre-Kindergarten</h3>
          <p>Building on their foundation, Pre-K children dive deeper into literacy, numeracy, and the natural world with increasing independence and curiosity.</p>
          <ul class="age-highlights">
            <li>Introduction to phonics and early reading</li>
            <li>Number recognition and basic counting</li>
            <li>Nature studies and science exploration</li>
            <li>Creative expression through art and music</li>
          </ul>
        </div>
      </div>

      <div class="age-card reveal reveal-d3">
        <div class="age-card-img">
          <img src="https://images.unsplash.com/photo-1503676260728-1c00da094a0b?w=600&q=80" alt="Kindergarten students at KPMS" loading="lazy">
        </div>
        <div class="age-card-body">
          <span class="age-badge">Ages 5-6</span>
          <h3>Kindergarten</h3>
          <p>Our Kindergarten program prepares children for primary school with structured activities in reading, writing, mathematics, and collaborative learning.</p>
          <ul class="age-highlights">
            <li>Reading fluency and writing practice</li>
            <li>Mathematical operations and problem-solving</li>
            <li>Cultural studies and geography</li>
            <li>Leadership skills and peer mentoring</li>
          </ul>
        </div>
      </div>

    </div>

  </div>
</section>


<!-- ===== SECTION 3: KEY FEATURES ===== -->
<section class="features-section">
  <div class="features-section-inner">

    <div class="features-section-header reveal">
      <div class="section-label">Why KPMS Montessori</div>
      <h2 class="section-title">Key Features of Our Program</h2>
      <p class="section-subtitle">What sets our Montessori program apart</p>
    </div>

    <div class="feature-grid">

      <div class="feature-grid-card reveal reveal-d1">
        <span class="feature-grid-icon">🎯</span>
        <h3>Self-Directed Learning</h3>
        <p>Children choose their own activities within a structured environment, developing decision-making skills, concentration, and intrinsic motivation to learn and discover.</p>
      </div>

      <div class="feature-grid-card reveal reveal-d2">
        <span class="feature-grid-icon">👨‍👩‍👧‍👦</span>
        <h3>Mixed-Age Classrooms</h3>
        <p>Our multi-age groupings allow younger children to learn from older peers while older children reinforce their knowledge through teaching -- just like a real family.</p>
      </div>

      <div class="feature-grid-card reveal reveal-d3">
        <span class="feature-grid-icon">🔬</span>
        <h3>Hands-On Materials</h3>
        <p>Authentic Montessori materials -- from sandpaper letters to golden beads -- help children grasp abstract concepts through concrete, sensorial experiences.</p>
      </div>

      <div class="feature-grid-card reveal reveal-d1">
        <span class="feature-grid-icon">🌿</span>
        <h3>Prepared Environment</h3>
        <p>Every element of our classroom is intentionally designed -- child-sized furniture, organized shelves, and natural lighting create a calm, inviting space for exploration.</p>
      </div>

      <div class="feature-grid-card reveal reveal-d2">
        <span class="feature-grid-icon">📋</span>
        <h3>Individualized Curriculum</h3>
        <p>Each child progresses through the curriculum at their own pace. Teachers observe, guide, and introduce new challenges when the child is developmentally ready.</p>
      </div>

      <div class="feature-grid-card reveal reveal-d3">
        <span class="feature-grid-icon">🌳</span>
        <h3>Outdoor Learning</h3>
        <p>Our campus includes dedicated outdoor spaces where children connect with nature, develop gross motor skills, and extend their classroom learning into the open air.</p>
      </div>

    </div>

  </div>
</section>


<!-- ===== SECTION 4: DAILY SCHEDULE ===== -->
<section class="schedule-section">
  <div class="schedule-inner">

    <div class="schedule-header reveal">
      <div class="section-label">A Day at KPMS</div>
      <h2 class="section-title">Typical Montessori Day</h2>
      <p class="section-subtitle">A balanced rhythm of focused work, play, and community</p>
    </div>

    <div class="schedule-timeline">

      <div class="schedule-item reveal reveal-d1">
        <div class="schedule-dot"></div>
        <div class="schedule-time">8:00 AM</div>
        <div class="schedule-content">
          <h4>Morning Circle</h4>
          <p>Children gather for greetings, songs, calendar time, and setting intentions for the day. A peaceful start that builds community and belonging.</p>
        </div>
      </div>

      <div class="schedule-item reveal reveal-d2">
        <div class="schedule-dot"></div>
        <div class="schedule-time">8:30 AM</div>
        <div class="schedule-content">
          <h4>Work Cycle</h4>
          <p>The heart of the Montessori day -- an uninterrupted 2-hour block where children select and engage with materials across practical life, sensorial, language, and mathematics areas.</p>
        </div>
      </div>

      <div class="schedule-item reveal reveal-d3">
        <div class="schedule-dot"></div>
        <div class="schedule-time">10:30 AM</div>
        <div class="schedule-content">
          <h4>Outdoor Play &amp; Snack</h4>
          <p>Fresh air and physical activity on our playground, followed by a healthy snack. Children practice grace and courtesy while sharing snack time together.</p>
        </div>
      </div>

      <div class="schedule-item reveal reveal-d1">
        <div class="schedule-dot"></div>
        <div class="schedule-time">12:00 PM</div>
        <div class="schedule-content">
          <h4>Lunch</h4>
          <p>A communal meal where children set the table, serve themselves, and clean up -- building practical life skills and table manners in a social setting.</p>
        </div>
      </div>

      <div class="schedule-item reveal reveal-d2">
        <div class="schedule-dot"></div>
        <div class="schedule-time">12:30 PM</div>
        <div class="schedule-content">
          <h4>Rest &amp; Quiet Time</h4>
          <p>Younger children nap while older children engage in quiet activities such as reading, puzzles, or mindfulness exercises to recharge for the afternoon.</p>
        </div>
      </div>

      <div class="schedule-item reveal reveal-d3">
        <div class="schedule-dot"></div>
        <div class="schedule-time">1:30 PM</div>
        <div class="schedule-content">
          <h4>Afternoon Activities</h4>
          <p>Enrichment time featuring art, music, Urdu language, Islamic studies, storytime, and collaborative group projects that complement the morning curriculum.</p>
        </div>
      </div>

      <div class="schedule-item reveal reveal-d1">
        <div class="schedule-dot"></div>
        <div class="schedule-time">2:30 PM</div>
        <div class="schedule-content">
          <h4>Dismissal</h4>
          <p>Children gather for a closing circle to reflect on their day, share accomplishments, and prepare for a warm goodbye. Extended care available until 4:00 PM.</p>
        </div>
      </div>

    </div>

  </div>
</section>


<!-- ===== SECTION 5: PHOTO GALLERY ===== -->
<section class="montessori-gallery">
  <div class="montessori-gallery-inner">

    <div class="montessori-gallery-header reveal">
      <div class="section-label">Inside Our Classrooms</div>
      <h2 class="section-title">Life at KPMS Montessori</h2>
      <p class="section-subtitle">Moments of discovery, creativity, and joy</p>
    </div>

    <div class="gallery-grid">
      <div class="gallery-item reveal reveal-d1">
        <img src="https://images.unsplash.com/photo-1544776193-352d25ca82cd?w=900&q=80" alt="Montessori classroom activities" loading="lazy">
        <span class="gallery-label">Practical Life</span>
      </div>
      <div class="gallery-item reveal reveal-d2">
        <img src="https://images.unsplash.com/photo-1509062522246-3755977927d7?w=600&q=80" alt="Children reading together" loading="lazy">
        <span class="gallery-label">Language Arts</span>
      </div>
      <div class="gallery-item reveal reveal-d3">
        <img src="https://images.unsplash.com/photo-1588075592446-265fd1e6e76f?w=600&q=80" alt="Hands-on math activities" loading="lazy">
        <span class="gallery-label">Mathematics</span>
      </div>
      <div class="gallery-item reveal reveal-d1">
        <img src="https://images.unsplash.com/photo-1560969184-10fe8719e047?w=600&q=80" alt="Art and creativity" loading="lazy">
        <span class="gallery-label">Creative Arts</span>
      </div>
      <div class="gallery-item reveal reveal-d2">
        <img src="https://images.unsplash.com/photo-1472162072942-cd5147eb3902?w=600&q=80" alt="Outdoor learning" loading="lazy">
        <span class="gallery-label">Outdoor Play</span>
      </div>
      <div class="gallery-item reveal reveal-d3">
        <img src="https://images.unsplash.com/photo-1497633762265-9d179a990aa6?w=600&q=80" alt="Collaborative learning" loading="lazy">
        <span class="gallery-label">Group Learning</span>
      </div>
    </div>

  </div>
</section>


<!-- ===== SECTION 6: PARENT TESTIMONIALS ===== -->
<section class="testimonials">
  <div class="testimonials-inner">

    <div class="testimonials-header reveal">
      <div class="section-label">Parent Voices</div>
      <h2 class="section-title">What Parents Say</h2>
      <p class="section-subtitle">Hear from families who have experienced the KPMS Montessori difference</p>
    </div>

    <div class="testimonials-grid">

      <div class="testimonial-card reveal reveal-d1">
        <div class="testimonial-quote-mark">"</div>
        <p class="testimonial-text">Our daughter has blossomed since joining the KPMS Montessori program. She comes home every day excited to share what she learned, and her independence has grown so much. The teachers truly understand each child's needs and pace.</p>
        <div class="testimonial-author">
          <div class="testimonial-avatar">SA</div>
          <div>
            <div class="testimonial-name">Sadia Ahmed</div>
            <div class="testimonial-role">Parent of Pre-K Student</div>
          </div>
        </div>
      </div>

      <div class="testimonial-card reveal reveal-d2">
        <div class="testimonial-quote-mark">"</div>
        <p class="testimonial-text">The Montessori approach at KPMS is remarkable. My son was shy and hesitant when he started, but within months he was confidently choosing his own activities and helping younger children. The mixed-age classroom was the best thing for him.</p>
        <div class="testimonial-author">
          <div class="testimonial-avatar">FK</div>
          <div>
            <div class="testimonial-name">Faisal Khan</div>
            <div class="testimonial-role">Parent of Kindergarten Student</div>
          </div>
        </div>
      </div>

      <div class="testimonial-card reveal reveal-d3">
        <div class="testimonial-quote-mark">"</div>
        <p class="testimonial-text">We toured many schools in Abbottabad before choosing KPMS. The prepared environment, the respect shown to each child, and the quality of the Montessori materials set this program apart. We could not be happier with our decision.</p>
        <div class="testimonial-author">
          <div class="testimonial-avatar">NR</div>
          <div>
            <div class="testimonial-name">Nadia Rehman</div>
            <div class="testimonial-role">Parent of Nursery Student</div>
          </div>
        </div>
      </div>

    </div>

  </div>
</section>


<!-- ===== SECTION 7: CTA ===== -->
<section class="montessori-cta">
  <div class="cta-label reveal">Enroll Today</div>
  <h2 class="cta-title reveal reveal-d1">Begin Your Child's Montessori Journey</h2>
  <div class="cta-actions reveal reveal-d2">
    <a href="/apply-online/" class="btn btn-gold">Apply Now</a>
    <a href="/schedule-tour/" class="btn btn-outline-light">Schedule a Tour</a>
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
        <div class="footer-contact">📍 Sheikh ul Bandi, Abbottabad, KPK</div>
        <div class="footer-contact">📞 +92 313 5914700</div>
        <div class="footer-contact">✉ info@kpms.edu.pk</div>
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
</script>

</body>
</html>