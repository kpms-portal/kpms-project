<?php
/*
Template Name: KPMS - Primary Education
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
<title>Primary Education – KPMS | Kamal Public Middle School Abbottabad</title>
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

/* ===== INNER PAGE HERO ===== */
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

/* ===== PAGE CONTENT AREA ===== */
.page-content {
  max-width: 1100px; margin: 0 auto;
  padding: 80px 60px;
}
.page-content h2 {
  font-family: 'Playfair Display', serif;
  font-size: 28px; font-weight: 500;
  color: var(--text); margin-bottom: 16px;
}
.page-content p {
  font-size: 16px; line-height: 1.8;
  color: var(--text-muted); margin-bottom: 20px;
}

/* ===== CURRICULUM OVERVIEW GRID ===== */
.curriculum-section {
  padding: 80px 60px;
  background: var(--cream);
  max-width: 100%;
}
.curriculum-inner {
  max-width: 1200px; margin: 0 auto;
}
.curriculum-grid {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 20px;
  margin-top: 50px;
}
.subject-card {
  background: var(--white);
  border: 2px solid var(--ice);
  border-radius: 16px;
  padding: 32px 24px;
  text-align: center;
  transition: all 0.3s cubic-bezier(0.16,1,0.3,1);
}
.subject-card:hover {
  border-color: var(--blue-light);
  box-shadow: 0 12px 40px rgba(0,48,135,0.08);
  transform: translateY(-5px);
}
.subject-icon {
  font-size: 42px;
  margin-bottom: 14px;
  display: block;
}
.subject-card h3 {
  font-family: 'Playfair Display', serif;
  font-size: 18px; font-weight: 600;
  color: var(--text);
  margin-bottom: 8px;
}
.subject-card p {
  font-size: 13px;
  color: var(--text-muted);
  line-height: 1.6;
  margin: 0;
}

/* ===== GRADE ACCORDION ===== */
.grades-section {
  padding: 80px 60px;
  background: var(--white);
}
.grades-inner {
  max-width: 900px; margin: 0 auto;
}
.grade-accordion {
  margin-top: 50px;
}
.grade-item {
  margin-bottom: 12px;
}
.grade-item details {
  border: 2px solid var(--ice);
  border-radius: 14px;
  overflow: hidden;
  transition: all 0.3s;
}
.grade-item details[open] {
  border-color: var(--blue-light);
  box-shadow: 0 8px 30px rgba(0,48,135,0.06);
}
.grade-item summary {
  padding: 22px 28px;
  font-family: 'Playfair Display', serif;
  font-size: 20px; font-weight: 600;
  color: var(--text);
  cursor: pointer;
  display: flex;
  align-items: center;
  gap: 14px;
  list-style: none;
  transition: all 0.3s;
  background: var(--white);
}
.grade-item summary::-webkit-details-marker { display: none; }
.grade-item summary::before {
  content: '+';
  display: flex; align-items: center; justify-content: center;
  width: 32px; height: 32px;
  border-radius: 8px;
  background: var(--ice);
  color: var(--blue);
  font-size: 20px; font-weight: 700;
  flex-shrink: 0;
  transition: all 0.3s;
}
.grade-item details[open] summary::before {
  content: '\2212';
  background: var(--blue);
  color: var(--white);
}
.grade-item summary:hover {
  color: var(--blue);
  background: var(--cream);
}
.grade-body {
  padding: 0 28px 28px;
  background: var(--cream);
}
.grade-body h4 {
  font-size: 14px; font-weight: 700;
  color: var(--blue); margin-bottom: 10px;
  text-transform: uppercase;
  letter-spacing: 1px;
}
.grade-body ul {
  list-style: none; padding: 0; margin-bottom: 16px;
}
.grade-body ul li {
  padding: 6px 0 6px 22px;
  position: relative;
  color: var(--text-muted);
  font-size: 14px; line-height: 1.7;
}
.grade-body ul li::before {
  content: '\2726';
  position: absolute; left: 0;
  color: var(--gold);
  font-size: 12px;
}

/* ===== TEACHING METHODOLOGY ===== */
.methodology-section {
  padding: 80px 60px;
  background: var(--cream-warm);
}
.methodology-inner {
  max-width: 1200px; margin: 0 auto;
}
.methodology-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 28px;
  margin-top: 50px;
}
.method-card {
  background: var(--white);
  border-radius: 16px;
  overflow: hidden;
  transition: all 0.4s cubic-bezier(0.16,1,0.3,1);
  border: 1px solid rgba(0,0,0,0.04);
}
.method-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 16px 48px rgba(0,0,0,0.08);
}
.method-img {
  width: 100%; aspect-ratio: 4/3; overflow: hidden;
}
.method-img img {
  width: 100%; height: 100%; object-fit: cover;
  transition: transform 0.6s ease;
}
.method-card:hover .method-img img { transform: scale(1.05); }
.method-body {
  padding: 28px;
}
.method-icon {
  font-size: 36px; margin-bottom: 12px; display: block;
}
.method-body h3 {
  font-family: 'Playfair Display', serif;
  font-size: 20px; font-weight: 600;
  color: var(--text); margin-bottom: 10px;
}
.method-body p {
  font-size: 14px; color: var(--text-muted);
  line-height: 1.7; margin: 0;
}

/* ===== ASSESSMENT APPROACH ===== */
.assessment-section {
  padding: 80px 60px;
  background: var(--white);
}
.assessment-inner {
  max-width: 1100px; margin: 0 auto;
}
.assessment-content {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 60px;
  margin-top: 40px;
  align-items: start;
}
.assessment-text p {
  font-size: 15px; color: var(--text-muted);
  line-height: 1.8; margin-bottom: 16px;
}
.assessment-features {
  list-style: none; padding: 0; margin-top: 20px;
}
.assessment-features li {
  padding: 10px 0 10px 28px;
  position: relative;
  color: var(--text);
  font-size: 15px; font-weight: 500;
}
.assessment-features li::before {
  content: '\2713';
  position: absolute; left: 0;
  color: var(--blue);
  font-weight: 700;
  font-size: 16px;
}
.timeline {
  position: relative;
  padding-left: 32px;
}
.timeline::before {
  content: '';
  position: absolute;
  left: 12px; top: 0; bottom: 0;
  width: 3px;
  background: var(--ice);
  border-radius: 3px;
}
.timeline-item {
  position: relative;
  margin-bottom: 28px;
  padding-bottom: 4px;
}
.timeline-item::before {
  content: '';
  position: absolute;
  left: -26px; top: 6px;
  width: 14px; height: 14px;
  border-radius: 50%;
  background: var(--blue);
  border: 3px solid var(--ice);
}
.timeline-item.gold::before {
  background: var(--gold);
}
.timeline-item.coral::before {
  background: var(--coral);
}
.timeline-item.sky::before {
  background: var(--sky);
}
.timeline-month {
  font-size: 11px; font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 1.5px;
  color: var(--blue);
  margin-bottom: 4px;
}
.timeline-event {
  font-size: 15px; font-weight: 600;
  color: var(--text);
}
.timeline-desc {
  font-size: 13px; color: var(--text-muted);
  margin-top: 2px;
}

/* ===== EXTRACURRICULAR ===== */
.extra-section {
  padding: 80px 60px;
  background: var(--cream);
}
.extra-inner {
  max-width: 1200px; margin: 0 auto;
}
.extra-grid {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 20px;
  margin-top: 50px;
}
.activity-card {
  background: var(--white);
  border: 2px solid var(--ice);
  border-radius: 16px;
  padding: 28px 20px;
  text-align: center;
  transition: all 0.3s cubic-bezier(0.16,1,0.3,1);
}
.activity-card:hover {
  border-color: var(--gold);
  box-shadow: 0 12px 36px rgba(255,209,0,0.12);
  transform: translateY(-5px);
}
.activity-icon {
  font-size: 40px; margin-bottom: 12px; display: block;
}
.activity-card h3 {
  font-family: 'Playfair Display', serif;
  font-size: 16px; font-weight: 600;
  color: var(--text); margin-bottom: 6px;
}
.activity-card p {
  font-size: 12px; color: var(--text-muted);
  line-height: 1.6; margin: 0;
}

/* ===== STATS ===== */
.stats {
  padding: 80px 60px;
  background: var(--cream-warm);
  position: relative;
}
.stats-top {
  text-align: center; margin-bottom: 50px;
}
.stats-carousel {
  max-width: 1100px; margin: 0 auto;
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 24px;
}
.stat-card {
  border-radius: 18px;
  padding: 38px 24px;
  text-align: center;
  transition: all 0.4s ease;
  position: relative;
  overflow: hidden;
  border: none;
}
.stat-card:nth-child(1) { background: var(--gold); }
.stat-card:nth-child(2) { background: #E8443A; }
.stat-card:nth-child(3) { background: #00AEEF; }
.stat-card:nth-child(4) { background: var(--blue); }
.stat-card:hover {
  transform: translateY(-12px) scale(1.02);
  box-shadow: 0 24px 60px rgba(0,0,0,0.25);
  z-index: 10;
}
.stat-card:nth-child(1):hover { box-shadow: 0 24px 60px rgba(255,209,0,0.4); }
.stat-card:nth-child(2):hover { box-shadow: 0 24px 60px rgba(232,68,58,0.4); }
.stat-card:nth-child(3):hover { box-shadow: 0 24px 60px rgba(0,174,239,0.4); }
.stat-card:nth-child(4):hover { box-shadow: 0 24px 60px rgba(0,48,135,0.4); }
.stat-card:hover .stat-emoji {
  transform: scale(1.3);
  transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1);
}
.stat-card:hover .stat-number {
  transform: scale(1.1);
  transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1);
}
.stat-emoji { font-size: 36px; margin-bottom: 14px; display: block; transform: scale(1); transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1); }
.stat-card:nth-child(1) .stat-emoji,
.stat-card:nth-child(1) .stat-number { color: var(--navy-deep); }
.stat-card:nth-child(1) .stat-label { color: rgba(0,15,43,0.7); }
.stat-card:nth-child(2) .stat-emoji,
.stat-card:nth-child(2) .stat-number,
.stat-card:nth-child(3) .stat-emoji,
.stat-card:nth-child(3) .stat-number,
.stat-card:nth-child(4) .stat-emoji,
.stat-card:nth-child(4) .stat-number { color: var(--white); }
.stat-card:nth-child(2) .stat-label,
.stat-card:nth-child(3) .stat-label,
.stat-card:nth-child(4) .stat-label { color: rgba(255,255,255,0.85); }
.stat-number {
  font-family: 'Playfair Display', serif;
  font-size: 52px; font-weight: 700;
  line-height: 1;
  margin-bottom: 8px;
  transform: scale(1);
  transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1);
}
.stat-label {
  font-size: 14px; font-weight: 600;
  line-height: 1.5;
  text-transform: uppercase;
  letter-spacing: 0.5px;
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

/* ===== RESPONSIVE ===== */
@media (max-width: 1024px) {
  .nav-inner { padding-left: 30px !important; padding-right: 30px !important; }
  .curriculum-section, .grades-section, .methodology-section, .assessment-section, .extra-section, .stats, .cta { padding-left: 30px !important; padding-right: 30px !important; }
  .curriculum-grid { grid-template-columns: repeat(2, 1fr); }
  .methodology-grid { grid-template-columns: repeat(2, 1fr); }
  .methodology-grid .method-card:nth-child(3) { grid-column: 1 / -1; max-width: 450px; margin: 0 auto; }
  .extra-grid { grid-template-columns: repeat(2, 1fr); }
  .stats-carousel { grid-template-columns: repeat(2, 1fr); }
  .assessment-content { grid-template-columns: 1fr; gap: 40px; }
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
  .curriculum-section, .grades-section, .methodology-section, .assessment-section, .extra-section, .stats, .cta { padding-left: 20px !important; padding-right: 20px !important; }
  .curriculum-grid { grid-template-columns: repeat(2, 1fr); gap: 12px; }
  .subject-card { padding: 24px 16px; }
  .methodology-grid { grid-template-columns: 1fr; }
  .methodology-grid .method-card:nth-child(3) { max-width: none; }
  .extra-grid { grid-template-columns: repeat(2, 1fr); gap: 12px; }
  .activity-card { padding: 20px 14px; }
  .stats-carousel { grid-template-columns: repeat(2, 1fr); gap: 12px; }
  .stat-card { padding: 24px 16px; }
  .stat-number { font-size: 36px; }
  .footer-grid { grid-template-columns: 1fr; gap: 32px; }
  .footer-bottom { flex-direction: column; text-align: center; }
  .cta-actions { flex-direction: column; align-items: center; }
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
    <a href="mailto:info@kpms.edu.pk">&#x2709; info@kpms.edu.pk</a>
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
      <li>
        <a href="#">Academic Programs <span class="dropdown-arrow">&#x25BC;</span></a>
        <div class="dropdown">
          <a href="/montessori/">Montessori Program</a>
          <a href="/primary-education/">Primary Education</a>
          <a href="/tuition/">Tuition &amp; Tutoring</a>
        </div>
      </li>
      <li>
        <a href="#">Admissions <span class="dropdown-arrow">&#x25BC;</span></a>
        <div class="dropdown">
          <a href="/apply-online/">Apply Online</a>
          <a href="/prospectus/">View Prospectus</a>
          <a href="/schedule-tour/">Schedule a Tour</a>
        </div>
      </li>
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
<section class="page-hero" id="main-content" style="background: linear-gradient(160deg, rgba(0,24,64,0.88) 0%, rgba(0,48,135,0.7) 50%, rgba(0,24,64,0.82) 100%), url('https://images.unsplash.com/photo-1580582932707-520aed937b7b?w=1920&q=85') center/cover;">
  <div class="page-hero-label">Academic Programs</div>
  <h1 class="page-hero-title">Primary Education</h1>
  <p class="page-hero-subtitle">A comprehensive curriculum for Grades 1-5 that builds strong foundations for lifelong learning</p>
  <div class="page-breadcrumb"><a href="/">Home</a> / <a href="/montessori/">Academic Programs</a> / Primary Education</div>
</section>


<!-- ===== SECTION 1: CURRICULUM OVERVIEW ===== -->
<section class="curriculum-section">
  <div class="curriculum-inner">
    <div style="text-align:center;">
      <div class="section-label reveal">Our Curriculum</div>
      <h2 class="section-title reveal reveal-d1">Eight Core Subjects for Holistic Growth</h2>
      <p class="section-subtitle reveal reveal-d2">Every child receives a well-rounded education rooted in both academic excellence and creative exploration</p>
    </div>
    <div class="curriculum-grid">
      <div class="subject-card reveal">
        <span class="subject-icon">&#x1F4D6;</span>
        <h3>English</h3>
        <p>Reading comprehension, grammar, creative writing, and oral communication skills for confident expression</p>
      </div>
      <div class="subject-card reveal reveal-d1">
        <span class="subject-icon">&#x1F5CA;</span>
        <h3>Urdu</h3>
        <p>National language fluency through poetry, prose, handwriting, and conversational Urdu practice</p>
      </div>
      <div class="subject-card reveal reveal-d2">
        <span class="subject-icon">&#x1F4D0;</span>
        <h3>Mathematics</h3>
        <p>Number sense, arithmetic operations, geometry, measurement, and problem-solving from basic to advanced</p>
      </div>
      <div class="subject-card reveal reveal-d3">
        <span class="subject-icon">&#x1F52C;</span>
        <h3>Science</h3>
        <p>Hands-on exploration of the natural world through experiments, observation, and scientific inquiry</p>
      </div>
      <div class="subject-card reveal">
        <span class="subject-icon">&#x1F30D;</span>
        <h3>Social Studies</h3>
        <p>Geography, history, civics, and cultural awareness to develop informed and responsible citizens</p>
      </div>
      <div class="subject-card reveal reveal-d1">
        <span class="subject-icon">&#x1F54C;</span>
        <h3>Islamiyat</h3>
        <p>Quranic recitation, Islamic history, moral values, and daily prayers integrated into character building</p>
      </div>
      <div class="subject-card reveal reveal-d2">
        <span class="subject-icon">&#x1F3A8;</span>
        <h3>Art &amp; Music</h3>
        <p>Creative expression through drawing, painting, calligraphy, and exposure to traditional and modern music</p>
      </div>
      <div class="subject-card reveal reveal-d3">
        <span class="subject-icon">&#x1F3C3;</span>
        <h3>Physical Education</h3>
        <p>Motor skills, teamwork, fitness, and sportsmanship through structured games and physical activities</p>
      </div>
    </div>
  </div>
</section>


<!-- ===== SECTION 2: GRADE-BY-GRADE BREAKDOWN ===== -->
<section class="grades-section">
  <div class="grades-inner">
    <div style="text-align:center;">
      <div class="section-label reveal">Grade Levels</div>
      <h2 class="section-title reveal reveal-d1">Grade-by-Grade Breakdown</h2>
      <p class="section-subtitle reveal reveal-d2">Explore the key learning milestones and focus areas for each grade level</p>
    </div>
    <div class="grade-accordion">

      <div class="grade-item reveal">
        <details>
          <summary>Grade 1 &mdash; Building Blocks</summary>
          <div class="grade-body">
            <h4>Key Learning Milestones</h4>
            <ul>
              <li>Recognize and write all English and Urdu alphabets fluently</li>
              <li>Read simple sentences and short stories independently</li>
              <li>Master addition and subtraction within 100</li>
              <li>Identify basic shapes, colors, and patterns in the environment</li>
              <li>Understand the five senses and basic body systems</li>
              <li>Memorize selected Surahs and daily duas</li>
            </ul>
            <h4>Focus Areas</h4>
            <ul>
              <li>Phonics and letter recognition for bilingual literacy</li>
              <li>Fine motor skills through handwriting and art activities</li>
              <li>Social skills and classroom routines</li>
            </ul>
          </div>
        </details>
      </div>

      <div class="grade-item reveal reveal-d1">
        <details>
          <summary>Grade 2 &mdash; Growing Confidence</summary>
          <div class="grade-body">
            <h4>Key Learning Milestones</h4>
            <ul>
              <li>Read and comprehend grade-level passages in English and Urdu</li>
              <li>Write structured paragraphs with correct punctuation</li>
              <li>Master multiplication tables up to 5 and basic division</li>
              <li>Understand the water cycle and plant life cycles</li>
              <li>Identify Pakistan on a map and learn about local communities</li>
              <li>Perform Wudu and understand the basics of Salah</li>
            </ul>
            <h4>Focus Areas</h4>
            <ul>
              <li>Reading fluency and vocabulary expansion</li>
              <li>Introduction to measurement and time</li>
              <li>Collaborative group projects</li>
            </ul>
          </div>
        </details>
      </div>

      <div class="grade-item reveal reveal-d2">
        <details>
          <summary>Grade 3 &mdash; Expanding Horizons</summary>
          <div class="grade-body">
            <h4>Key Learning Milestones</h4>
            <ul>
              <li>Compose short essays and creative stories in both languages</li>
              <li>Master all multiplication tables and multi-digit addition/subtraction</li>
              <li>Conduct simple science experiments and record observations</li>
              <li>Study the provinces of Pakistan, national symbols, and festivals</li>
              <li>Learn about the life of the Holy Prophet (PBUH)</li>
              <li>Participate in class debates and oral presentations</li>
            </ul>
            <h4>Focus Areas</h4>
            <ul>
              <li>Critical thinking through hands-on science</li>
              <li>Introduction to fractions and basic geometry</li>
              <li>Cultural awareness and national identity</li>
            </ul>
          </div>
        </details>
      </div>

      <div class="grade-item reveal reveal-d3">
        <details>
          <summary>Grade 4 &mdash; Deepening Understanding</summary>
          <div class="grade-body">
            <h4>Key Learning Milestones</h4>
            <ul>
              <li>Write detailed essays with introduction, body, and conclusion</li>
              <li>Work with fractions, decimals, and multi-digit multiplication/division</li>
              <li>Understand ecosystems, weather patterns, and states of matter</li>
              <li>Study the history of the subcontinent and Pakistan Movement</li>
              <li>Learn about the Five Pillars of Islam in depth</li>
              <li>Develop research skills through mini-projects</li>
            </ul>
            <h4>Focus Areas</h4>
            <ul>
              <li>Independent research and presentation skills</li>
              <li>Advanced problem-solving in mathematics</li>
              <li>Environmental awareness and stewardship</li>
            </ul>
          </div>
        </details>
      </div>

      <div class="grade-item reveal">
        <details>
          <summary>Grade 5 &mdash; Preparing for Middle School</summary>
          <div class="grade-body">
            <h4>Key Learning Milestones</h4>
            <ul>
              <li>Demonstrate strong reading comprehension and analytical writing</li>
              <li>Master long division, percentage, and basic algebra concepts</li>
              <li>Understand the human body systems, force, and simple machines</li>
              <li>Study world geography, major civilizations, and current events</li>
              <li>Complete the Nazra Quran and study selected Ahadith</li>
              <li>Lead group projects and participate in inter-school competitions</li>
            </ul>
            <h4>Focus Areas</h4>
            <ul>
              <li>Transition skills for middle school readiness</li>
              <li>Leadership and public speaking development</li>
              <li>Comprehensive board exam preparation</li>
            </ul>
          </div>
        </details>
      </div>

    </div>
  </div>
</section>


<!-- ===== SECTION 3: TEACHING METHODOLOGY ===== -->
<section class="methodology-section">
  <div class="methodology-inner">
    <div style="text-align:center;">
      <div class="section-label reveal">How We Teach</div>
      <h2 class="section-title reveal reveal-d1">Our Teaching Methodology</h2>
      <p class="section-subtitle reveal reveal-d2">Modern, student-centered approaches that make learning engaging and effective</p>
    </div>
    <div class="methodology-grid">
      <div class="method-card reveal">
        <div class="method-img">
          <img src="https://images.unsplash.com/photo-1503676260728-1c00da094a0b?w=600&q=80" alt="Project-Based Learning" loading="lazy">
        </div>
        <div class="method-body">
          <span class="method-icon">&#x1F3AF;</span>
          <h3>Project-Based Learning</h3>
          <p>Students tackle real-world problems through hands-on projects that integrate multiple subjects. From building model ecosystems to creating community maps, every project develops critical thinking and creativity.</p>
        </div>
      </div>
      <div class="method-card reveal reveal-d1">
        <div class="method-img">
          <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?w=600&q=80" alt="Collaborative Work" loading="lazy">
        </div>
        <div class="method-body">
          <span class="method-icon">&#x1F91D;</span>
          <h3>Collaborative Work</h3>
          <p>Group activities and peer learning help students develop communication, empathy, and teamwork. Children learn to listen, share ideas, and build upon each other's strengths in a supportive environment.</p>
        </div>
      </div>
      <div class="method-card reveal reveal-d2">
        <div class="method-img">
          <img src="https://images.unsplash.com/photo-1544717305-2782549b5136?w=600&q=80" alt="Differentiated Instruction" loading="lazy">
        </div>
        <div class="method-body">
          <span class="method-icon">&#x1F9E9;</span>
          <h3>Differentiated Instruction</h3>
          <p>Every child learns differently. Our teachers adapt lessons to meet diverse learning styles and paces, providing enrichment for advanced learners and additional support for those who need it.</p>
        </div>
      </div>
    </div>
  </div>
</section>


<!-- ===== SECTION 4: ASSESSMENT APPROACH ===== -->
<section class="assessment-section">
  <div class="assessment-inner">
    <div style="text-align:center;">
      <div class="section-label reveal">Measuring Progress</div>
      <h2 class="section-title reveal reveal-d1">Our Assessment Approach</h2>
      <p class="section-subtitle reveal reveal-d2">Continuous evaluation that focuses on growth, understanding, and holistic development</p>
    </div>
    <div class="assessment-content">
      <div class="assessment-text reveal">
        <p>At KPMS, assessment is not just about exams. We believe in a continuous, multi-faceted approach that captures the full picture of each child's academic and personal growth throughout the year.</p>
        <p>Our teachers use a blend of formative assessments, project evaluations, and formal examinations to ensure every student receives timely feedback and personalized support.</p>
        <ul class="assessment-features">
          <li>Weekly quizzes and classwork evaluations</li>
          <li>Monthly unit tests with detailed feedback</li>
          <li>Quarterly report cards sent home to parents</li>
          <li>Parent-teacher conferences every quarter</li>
          <li>Portfolio-based assessment for arts and projects</li>
          <li>Annual board-style examinations for Grades 3-5</li>
        </ul>
      </div>
      <div class="timeline reveal reveal-d1">
        <div class="timeline-item">
          <div class="timeline-month">April</div>
          <div class="timeline-event">Academic Year Begins</div>
          <div class="timeline-desc">Orientation week and baseline assessments</div>
        </div>
        <div class="timeline-item gold">
          <div class="timeline-month">June</div>
          <div class="timeline-event">First Quarterly Exams</div>
          <div class="timeline-desc">Report cards and parent-teacher meetings</div>
        </div>
        <div class="timeline-item coral">
          <div class="timeline-month">August</div>
          <div class="timeline-event">Mid-Year Assessments</div>
          <div class="timeline-desc">Progress reviews and learning plan adjustments</div>
        </div>
        <div class="timeline-item sky">
          <div class="timeline-month">September</div>
          <div class="timeline-event">Science Fair &amp; Project Week</div>
          <div class="timeline-desc">Hands-on demonstrations and portfolio reviews</div>
        </div>
        <div class="timeline-item gold">
          <div class="timeline-month">November</div>
          <div class="timeline-event">Third Quarter Exams</div>
          <div class="timeline-desc">Detailed report cards and parent conferences</div>
        </div>
        <div class="timeline-item">
          <div class="timeline-month">January</div>
          <div class="timeline-event">Sports Day &amp; Competitions</div>
          <div class="timeline-desc">Inter-class competitions and physical assessments</div>
        </div>
        <div class="timeline-item coral">
          <div class="timeline-month">March</div>
          <div class="timeline-event">Annual Final Examinations</div>
          <div class="timeline-desc">Comprehensive year-end exams and promotion decisions</div>
        </div>
      </div>
    </div>
  </div>
</section>


<!-- ===== SECTION 5: EXTRACURRICULAR ACTIVITIES ===== -->
<section class="extra-section">
  <div class="extra-inner">
    <div style="text-align:center;">
      <div class="section-label reveal">Beyond the Classroom</div>
      <h2 class="section-title reveal reveal-d1">Extracurricular Activities</h2>
      <p class="section-subtitle reveal reveal-d2">Building character, confidence, and lifelong passions outside the classroom</p>
    </div>
    <div class="extra-grid">
      <div class="activity-card reveal">
        <span class="activity-icon">&#x1F3CF;</span>
        <h3>Cricket</h3>
        <p>Our cricket program develops batting, bowling, and fielding skills through regular practice and inter-school matches</p>
      </div>
      <div class="activity-card reveal reveal-d1">
        <span class="activity-icon">&#x26BD;</span>
        <h3>Football</h3>
        <p>Team spirit and physical fitness through football training, friendly matches, and tournament participation</p>
      </div>
      <div class="activity-card reveal reveal-d2">
        <span class="activity-icon">&#x1F3A8;</span>
        <h3>Art Club</h3>
        <p>Explore painting, sketching, calligraphy, and crafts with guidance from experienced art instructors</p>
      </div>
      <div class="activity-card reveal reveal-d3">
        <span class="activity-icon">&#x1F399;</span>
        <h3>Debate Society</h3>
        <p>Public speaking, logical reasoning, and confident argumentation in both English and Urdu</p>
      </div>
      <div class="activity-card reveal">
        <span class="activity-icon">&#x1F9EA;</span>
        <h3>Science Club</h3>
        <p>Hands-on experiments, science fairs, and discovery projects that spark curiosity and innovation</p>
      </div>
      <div class="activity-card reveal reveal-d1">
        <span class="activity-icon">&#x1F54C;</span>
        <h3>Naat &amp; Qiraat</h3>
        <p>Beautiful recitation of Quran and Naat competitions that nurture spiritual growth and eloquence</p>
      </div>
      <div class="activity-card reveal reveal-d2">
        <span class="activity-icon">&#x1F3AD;</span>
        <h3>Drama Club</h3>
        <p>Stage performances, role-playing, and storytelling that build confidence and creative expression</p>
      </div>
      <div class="activity-card reveal reveal-d3">
        <span class="activity-icon">&#x269A;</span>
        <h3>Scouts</h3>
        <p>Outdoor skills, community service, discipline, and leadership through the Pakistan Boy Scouts program</p>
      </div>
    </div>
  </div>
</section>


<!-- ===== SECTION 6: STATS ===== -->
<section class="stats">
  <div class="stats-top">
    <div class="section-label reveal">By the Numbers</div>
    <h2 class="section-title reveal reveal-d1">Our Primary Program at a Glance</h2>
  </div>
  <div class="stats-carousel">
    <div class="stat-card reveal">
      <span class="stat-emoji">&#x1F468;&#x200D;&#x1F3EB;</span>
      <div class="stat-number">15:1</div>
      <div class="stat-label">Student-Teacher<br>Ratio</div>
    </div>
    <div class="stat-card reveal reveal-d1">
      <span class="stat-emoji">&#x1F4DA;</span>
      <div class="stat-number">20</div>
      <div class="stat-label">Max Class<br>Size</div>
    </div>
    <div class="stat-card reveal reveal-d2">
      <span class="stat-emoji">&#x1F4DD;</span>
      <div class="stat-number">8</div>
      <div class="stat-label">Core<br>Subjects</div>
    </div>
    <div class="stat-card reveal reveal-d3">
      <span class="stat-emoji">&#x1F3C6;</span>
      <div class="stat-number">6</div>
      <div class="stat-label">Extracurricular<br>Clubs</div>
    </div>
  </div>
</section>


<!-- ===== SECTION 7: CTA ===== -->
<section class="cta">
  <div class="cta-label">Start Your Journey</div>
  <h2 class="cta-title">Enroll Your Child in Our Primary Program</h2>
  <div class="cta-actions">
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
