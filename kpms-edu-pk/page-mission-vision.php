<?php
/*
Template Name: KPMS - Mission & Vision
*/
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Mission & Vision – KPMS | Kamal Public Middle School Abbottabad</title>
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
.btn-blue {
  background: var(--blue);
  color: var(--white);
}
.btn-blue:hover {
  background: var(--blue-deep);
  transform: translateY(-2px);
  box-shadow: 0 8px 24px rgba(0,48,135,0.35);
}
.btn-outline-blue {
  background: transparent;
  color: var(--blue);
  border: 2px solid var(--blue);
}
.btn-outline-blue:hover {
  background: var(--blue);
  color: var(--white);
  transform: translateY(-2px);
  box-shadow: 0 8px 24px rgba(0,48,135,0.25);
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

/* ===== MISSION BANNER ===== */
.mission-banner {
  padding: 100px 60px;
  background: linear-gradient(135deg, var(--blue-deep) 0%, var(--blue) 50%, var(--blue-light) 100%);
  text-align: center;
  position: relative;
  overflow: hidden;
}
.mission-banner::before {
  content: '';
  position: absolute;
  width: 500px; height: 500px;
  border-radius: 50%;
  background: var(--gold);
  opacity: 0.06;
  top: -200px; right: -150px;
}
.mission-banner::after {
  content: '';
  position: absolute;
  width: 350px; height: 350px;
  border-radius: 50%;
  background: var(--gold);
  opacity: 0.04;
  bottom: -150px; left: -100px;
}
.mission-banner-inner {
  max-width: 900px;
  margin: 0 auto;
  position: relative;
  z-index: 1;
}
.mission-banner-label {
  font-size: 13px; font-weight: 700;
  letter-spacing: 3px; text-transform: uppercase;
  color: var(--gold-light);
  margin-bottom: 20px;
}
.mission-banner-quote {
  font-family: 'Playfair Display', serif;
  font-size: clamp(24px, 3.5vw, 36px);
  font-weight: 500;
  color: var(--white);
  line-height: 1.35;
  margin-bottom: 28px;
}
.mission-banner-quote em {
  color: var(--gold);
  font-style: normal;
}
.mission-banner-text {
  font-size: 17px;
  color: rgba(255,255,255,0.7);
  line-height: 1.85;
  max-width: 780px;
  margin: 0 auto;
}
.mission-banner-divider {
  width: 80px; height: 4px;
  background: var(--gold);
  border-radius: 4px;
  margin: 30px auto 0;
}

/* ===== THREE PILLARS ===== */
.pillars-section {
  padding: 100px 60px;
  background: var(--white);
}
.pillars-inner {
  max-width: 1200px;
  margin: 0 auto;
}
.pillars-header {
  text-align: center;
  margin-bottom: 60px;
}
.pillars-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 32px;
}
.pillar-card {
  background: var(--white);
  border: 2px solid var(--ice);
  border-radius: 20px;
  padding: 48px 36px;
  text-align: center;
  transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
  position: relative;
  overflow: hidden;
}
.pillar-card::before {
  content: '';
  position: absolute;
  top: 0; left: 0; right: 0;
  height: 4px;
  background: linear-gradient(90deg, var(--blue), var(--gold));
  transform: scaleX(0);
  transition: transform 0.4s cubic-bezier(0.16, 1, 0.3, 1);
  transform-origin: left;
}
.pillar-card:hover::before {
  transform: scaleX(1);
}
.pillar-card:hover {
  border-color: var(--blue-light);
  box-shadow: 0 20px 60px rgba(0,48,135,0.1);
  transform: translateY(-6px);
}
.pillar-icon {
  width: 80px; height: 80px;
  border-radius: 50%;
  display: flex; align-items: center; justify-content: center;
  margin: 0 auto 24px;
  font-size: 36px;
  transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1);
}
.pillar-card:hover .pillar-icon {
  transform: scale(1.15);
}
.pillar-icon.confidence { background: linear-gradient(135deg, #e8f4fd, #d0e8ff); }
.pillar-icon.critical { background: linear-gradient(135deg, #fff3e0, #ffe0b2); }
.pillar-icon.digital { background: linear-gradient(135deg, #e0f7fa, #b2ebf2); }
.pillar-number {
  font-size: 13px; font-weight: 800;
  letter-spacing: 2px; text-transform: uppercase;
  color: var(--blue-light);
  margin-bottom: 12px;
}
.pillar-card h3 {
  font-family: 'Playfair Display', serif;
  font-size: 24px; font-weight: 600;
  color: var(--text);
  margin-bottom: 14px;
}
.pillar-card p {
  font-size: 15px; color: var(--text-muted);
  line-height: 1.8;
}
.pillar-features {
  list-style: none; padding: 0;
  margin-top: 20px; text-align: left;
}
.pillar-features li {
  padding: 7px 0 7px 24px;
  position: relative;
  font-size: 14px; color: var(--text-muted);
  font-weight: 500;
}
.pillar-features li::before {
  content: '\2726';
  position: absolute; left: 0;
  color: var(--gold); font-size: 12px;
}

/* ===== VISION SECTION ===== */
.vision-section {
  padding: 100px 60px;
  background: var(--cream-warm);
  text-align: center;
}
.vision-inner {
  max-width: 900px;
  margin: 0 auto;
}
.vision-icon {
  font-size: 56px;
  margin-bottom: 24px;
  display: block;
}
.vision-label {
  font-size: 13px; font-weight: 700;
  letter-spacing: 3px; text-transform: uppercase;
  color: var(--blue);
  margin-bottom: 16px;
}
.vision-title {
  font-family: 'Playfair Display', serif;
  font-size: clamp(26px, 3.5vw, 38px);
  font-weight: 500;
  color: var(--text);
  line-height: 1.35;
  margin-bottom: 24px;
}
.vision-statement {
  font-family: 'Playfair Display', serif;
  font-size: clamp(20px, 2.5vw, 28px);
  font-weight: 400;
  font-style: italic;
  color: var(--blue-deep);
  line-height: 1.55;
  max-width: 780px;
  margin: 0 auto 30px;
  position: relative;
  padding: 0 30px;
}
.vision-statement::before,
.vision-statement::after {
  font-family: 'Playfair Display', serif;
  font-size: 72px;
  color: var(--gold);
  opacity: 0.4;
  position: absolute;
  line-height: 1;
}
.vision-statement::before {
  content: '\201C';
  top: -10px; left: -10px;
}
.vision-statement::after {
  content: '\201D';
  bottom: -30px; right: -10px;
}
.vision-desc {
  font-size: 16px;
  color: var(--text-muted);
  line-height: 1.85;
  max-width: 700px;
  margin: 0 auto;
}

/* ===== CORE VALUES ===== */
.values-section {
  padding: 100px 60px;
  background: var(--white);
}
.values-inner {
  max-width: 1200px;
  margin: 0 auto;
}
.values-header {
  text-align: center;
  margin-bottom: 60px;
}
.values-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 28px;
}
.value-card {
  background: var(--white);
  border: 2px solid var(--ice);
  border-radius: 16px;
  padding: 36px 28px;
  transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
  position: relative;
  overflow: hidden;
}
.value-card::before {
  content: '';
  position: absolute; top: 0; left: 0;
  width: 4px; height: 0;
  background: var(--blue);
  border-radius: 0 0 4px 0;
  transition: height 0.4s cubic-bezier(0.16, 1, 0.3, 1);
}
.value-card:hover::before {
  height: 100%;
}
.value-card:hover {
  border-color: var(--blue-light);
  box-shadow: 0 16px 48px rgba(0,48,135,0.08);
  transform: translateY(-5px);
}
.value-icon {
  font-size: 42px;
  margin-bottom: 18px;
  display: block;
  transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1);
}
.value-card:hover .value-icon {
  transform: scale(1.15);
}
.value-card h3 {
  font-family: 'Playfair Display', serif;
  font-size: 20px; font-weight: 600;
  color: var(--text);
  margin-bottom: 10px;
}
.value-card p {
  font-size: 14px; color: var(--text-muted);
  line-height: 1.7;
}

/* ===== HISTORY TIMELINE ===== */
.timeline-section {
  padding: 100px 60px;
  background: var(--cream-warm);
}
.timeline-inner {
  max-width: 900px;
  margin: 0 auto;
}
.timeline-header {
  text-align: center;
  margin-bottom: 60px;
}
.timeline {
  position: relative;
}
.timeline::before {
  content: '';
  position: absolute;
  left: 50%; top: 0; bottom: 0;
  width: 3px;
  background: var(--ice);
  border-radius: 3px;
  transform: translateX(-50%);
}
.timeline-item {
  display: flex;
  align-items: flex-start;
  margin-bottom: 50px;
  position: relative;
}
.timeline-item:last-child {
  margin-bottom: 0;
}
.timeline-item:nth-child(odd) {
  flex-direction: row;
}
.timeline-item:nth-child(even) {
  flex-direction: row-reverse;
}
.timeline-dot {
  position: absolute;
  left: 50%;
  transform: translateX(-50%);
  width: 22px; height: 22px;
  border-radius: 50%;
  background: var(--blue);
  border: 4px solid var(--cream-warm);
  z-index: 2;
  transition: all 0.3s;
  top: 20px;
}
.timeline-item:hover .timeline-dot {
  background: var(--gold);
  transform: translateX(-50%) scale(1.3);
  box-shadow: 0 0 0 6px rgba(255,209,0,0.3);
}
.timeline-content {
  width: calc(50% - 40px);
  background: var(--white);
  border-radius: 14px;
  padding: 28px 30px;
  border: 2px solid var(--ice);
  transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
}
.timeline-item:hover .timeline-content {
  border-color: var(--blue-light);
  box-shadow: 0 12px 40px rgba(0,48,135,0.08);
  transform: translateY(-3px);
}
.timeline-year {
  display: inline-block;
  background: var(--blue);
  color: var(--white);
  font-size: 14px; font-weight: 700;
  padding: 4px 14px;
  border-radius: 20px;
  margin-bottom: 12px;
  letter-spacing: 0.5px;
}
.timeline-content h3 {
  font-family: 'Playfair Display', serif;
  font-size: 19px; font-weight: 600;
  color: var(--text);
  margin-bottom: 8px;
}
.timeline-content p {
  font-size: 14px; color: var(--text-muted);
  line-height: 1.7;
  margin: 0;
}

/* ===== LEADERSHIP SECTION ===== */
.leadership-section {
  padding: 100px 60px;
  background: var(--white);
}
.leadership-inner {
  max-width: 1000px;
  margin: 0 auto;
}
.leadership-header {
  text-align: center;
  margin-bottom: 60px;
}
.founder-card {
  display: grid;
  grid-template-columns: 320px 1fr;
  gap: 50px;
  align-items: center;
  background: var(--white);
  border: 2px solid var(--ice);
  border-radius: 24px;
  padding: 48px;
  transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
}
.founder-card:hover {
  border-color: var(--blue-light);
  box-shadow: 0 20px 60px rgba(0,48,135,0.08);
}
.founder-img {
  width: 100%; height: 380px;
  border-radius: 16px;
  overflow: hidden;
  background: linear-gradient(135deg, var(--blue-deep) 0%, var(--blue) 100%);
  display: flex;
  align-items: center;
  justify-content: center;
  position: relative;
}
.founder-img-placeholder {
  color: var(--white);
  text-align: center;
}
.founder-img-placeholder .initials {
  font-family: 'Playfair Display', serif;
  font-size: 64px;
  font-weight: 700;
  display: block;
  margin-bottom: 10px;
}
.founder-img-placeholder .role-text {
  font-size: 13px;
  font-weight: 600;
  letter-spacing: 2px;
  text-transform: uppercase;
  color: var(--gold-light);
}
.founder-body {
  padding: 10px 0;
}
.founder-badge {
  display: inline-block;
  background: var(--ice);
  color: var(--blue);
  font-size: 12px; font-weight: 700;
  letter-spacing: 1.5px; text-transform: uppercase;
  padding: 6px 16px;
  border-radius: 20px;
  margin-bottom: 16px;
}
.founder-body h3 {
  font-family: 'Playfair Display', serif;
  font-size: 30px; font-weight: 600;
  color: var(--text);
  margin-bottom: 6px;
}
.founder-title {
  font-size: 16px; font-weight: 600;
  color: var(--blue);
  margin-bottom: 20px;
}
.founder-body p {
  font-size: 15px; color: var(--text-muted);
  line-height: 1.85;
  margin-bottom: 16px;
}
.founder-quote {
  font-family: 'Playfair Display', serif;
  font-size: 17px;
  font-style: italic;
  color: var(--blue-deep);
  line-height: 1.6;
  padding: 20px 24px;
  border-left: 4px solid var(--gold);
  background: var(--cream);
  border-radius: 0 12px 12px 0;
  margin-top: 20px;
}

/* ===== CTA BANNER ===== */
.cta {
  padding: 90px 60px;
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
.cta::before { width: 350px; height: 350px; background: var(--gold); top: -120px; right: -80px; }
.cta::after { width: 220px; height: 220px; background: var(--coral); bottom: -90px; left: -50px; }
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
  margin-bottom: 16px;
  position: relative; z-index: 1;
}
.cta-subtitle {
  font-size: 17px;
  color: rgba(255,255,255,0.6);
  max-width: 550px;
  margin: 0 auto 32px;
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
.reveal-d4 { transition-delay: 0.4s; }
.reveal-d5 { transition-delay: 0.5s; }

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

/* ===== RESPONSIVE ===== */
@media (max-width: 1200px) {
  .nav-inner, .pillars-section, .values-section, .timeline-section,
  .leadership-section, .mission-banner, .vision-section, .cta, .footer {
    padding-left: 40px !important;
    padding-right: 40px !important;
  }
  .pillars-grid { gap: 24px; }
  .founder-card { grid-template-columns: 280px 1fr; gap: 40px; padding: 40px; }
}

@media (max-width: 900px) {
  .nav-inner, .pillars-section, .values-section, .timeline-section,
  .leadership-section, .mission-banner, .vision-section, .cta, .footer {
    padding-left: 30px !important;
    padding-right: 30px !important;
  }
  .pillars-grid { grid-template-columns: 1fr; max-width: 480px; margin: 0 auto; }
  .values-grid { grid-template-columns: repeat(2, 1fr); }
  .timeline::before { left: 24px; }
  .timeline-dot { left: 24px; transform: translateX(-50%); }
  .timeline-item:hover .timeline-dot { transform: translateX(-50%) scale(1.3); }
  .timeline-item,
  .timeline-item:nth-child(odd),
  .timeline-item:nth-child(even) {
    flex-direction: row;
    padding-left: 56px;
  }
  .timeline-content { width: 100%; }
  .founder-card { grid-template-columns: 1fr; gap: 30px; padding: 32px; }
  .founder-img { height: 300px; }
  .footer-grid { grid-template-columns: 1fr 1fr; }
}

@media (max-width: 600px) {
  .topbar { display: none; }
  .nav-menu { display: none; }
  .nav-search-btn { display: none; }
  .mobile-toggle { display: block; }
  .nav-inner { padding: 0 20px !important; height: 64px; }
  .pillars-section, .values-section, .timeline-section,
  .leadership-section, .mission-banner, .vision-section, .cta, .footer {
    padding-left: 20px !important;
    padding-right: 20px !important;
  }
  .values-grid { grid-template-columns: 1fr; }
  .page-hero { padding: 120px 20px 60px; }
  .mission-banner { padding: 60px 20px; }
  .vision-section { padding: 60px 20px; }
  .timeline-section { padding: 60px 20px; }
  .timeline-item,
  .timeline-item:nth-child(odd),
  .timeline-item:nth-child(even) {
    padding-left: 48px;
  }
  .timeline::before { left: 18px; }
  .timeline-dot { left: 18px; }
  .founder-card { padding: 24px; }
  .founder-img { height: 250px; }
  .footer-grid { grid-template-columns: 1fr; gap: 32px; }
  .footer-bottom { flex-direction: column; text-align: center; }
  .cta-actions { flex-direction: column; align-items: center; }
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
        <a href="#">Students <span class="dropdown-arrow">&#9660;</span></a>
        <div class="dropdown">
          <a href="/student-resources/">Resources</a>
          <a href="/student-games/">Learning Games</a>
        </div>
      </li>
      <li>
        <a href="#">Support <span class="dropdown-arrow">&#9660;</span></a>
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


<!-- ===== PAGE HERO ===== -->
<section class="page-hero" style="background: linear-gradient(160deg, rgba(0,24,64,0.9) 0%, rgba(0,48,135,0.75) 50%, rgba(0,24,64,0.85) 100%), url('https://images.unsplash.com/photo-1523050854058-8df90110c7f1?w=1920&q=85') center/cover;">
  <div class="page-hero-label">Our Foundation</div>
  <h1 class="page-hero-title">Mission &amp; Vision</h1>
  <p class="page-hero-subtitle">Guided by purpose, driven by values, and committed to shaping confident leaders for tomorrow</p>
  <div class="page-breadcrumb"><a href="/">Home</a> / <a href="#">About Us</a> / Mission &amp; Vision</div>
</section>


<!-- ===== SECTION 1: MISSION STATEMENT BANNER ===== -->
<section class="mission-banner" id="main-content">
  <div class="mission-banner-inner reveal">
    <div class="mission-banner-label">Our Mission</div>
    <h2 class="mission-banner-quote">Building <em>Confidence</em>, <em>Critical Thinking</em>, and <em>Digital Empowerment</em></h2>
    <p class="mission-banner-text">At KPMS, we are committed to building confidence, critical thinking, and digital empowerment in every student. Through innovative teaching, character development, and technology integration, we prepare young minds for the challenges of tomorrow. Our mission drives every classroom interaction, every extracurricular activity, and every relationship we build with our students and their families.</p>
    <div class="mission-banner-divider"></div>
  </div>
</section>


<!-- ===== SECTION 2: THREE PILLARS ===== -->
<section class="pillars-section">
  <div class="pillars-inner">

    <div class="pillars-header reveal">
      <div class="section-label">Our Three Pillars</div>
      <h2 class="section-title">The Foundation of Everything We Do</h2>
      <p class="section-subtitle">Three guiding pillars that shape our curriculum, culture, and community</p>
    </div>

    <div class="pillars-grid">

      <div class="pillar-card reveal reveal-d1">
        <div class="pillar-icon confidence">💪</div>
        <div class="pillar-number">Pillar One</div>
        <h3>Confidence</h3>
        <p>Building self-assured learners through supportive environments where every child feels valued, heard, and empowered to take on new challenges without fear of failure.</p>
        <ul class="pillar-features">
          <li>Public speaking and presentation skills</li>
          <li>Student-led assemblies and events</li>
          <li>Growth mindset cultivation</li>
          <li>Positive reinforcement frameworks</li>
        </ul>
      </div>

      <div class="pillar-card reveal reveal-d2">
        <div class="pillar-icon critical">🧠</div>
        <div class="pillar-number">Pillar Two</div>
        <h3>Critical Thinking</h3>
        <p>Developing analytical minds through inquiry-based learning that encourages students to question, explore, reason, and form well-supported conclusions on their own.</p>
        <ul class="pillar-features">
          <li>Inquiry-based learning methodology</li>
          <li>Problem-solving workshops</li>
          <li>Collaborative group projects</li>
          <li>Science and mathematics olympiads</li>
        </ul>
      </div>

      <div class="pillar-card reveal reveal-d3">
        <div class="pillar-icon digital">💻</div>
        <div class="pillar-number">Pillar Three</div>
        <h3>Digital Empowerment</h3>
        <p>Preparing students for a technology-driven future by integrating digital literacy, coding foundations, and responsible technology use into everyday learning experiences.</p>
        <ul class="pillar-features">
          <li>Computer science fundamentals</li>
          <li>Digital literacy and online safety</li>
          <li>Interactive learning platforms</li>
          <li>Technology-enhanced classroom tools</li>
        </ul>
      </div>

    </div>

  </div>
</section>


<!-- ===== SECTION 3: VISION ===== -->
<section class="vision-section">
  <div class="vision-inner">

    <div class="reveal">
      <span class="vision-icon">🔭</span>
      <div class="vision-label">Our Vision</div>
      <h2 class="vision-title">Where We Are Headed</h2>
    </div>

    <div class="reveal reveal-d1">
      <p class="vision-statement">To be a leading institution in Abbottabad that transforms young minds into confident, compassionate, and capable leaders.</p>
    </div>

    <div class="reveal reveal-d2">
      <p class="vision-desc">We envision a learning community where every child discovers their unique potential, develops the skills to navigate an ever-changing world, and graduates with the character and competence to make meaningful contributions to society. KPMS aspires to set the standard for holistic education in the region, blending academic excellence with moral integrity, creative expression, and a deep sense of responsibility to one another and the wider community.</p>
    </div>

  </div>
</section>


<!-- ===== SECTION 4: CORE VALUES ===== -->
<section class="values-section">
  <div class="values-inner">

    <div class="values-header reveal">
      <div class="section-label">What We Stand For</div>
      <h2 class="section-title">Our Core Values</h2>
      <p class="section-subtitle">The principles that guide our actions, decisions, and relationships every day</p>
    </div>

    <div class="values-grid">

      <div class="value-card reveal reveal-d1">
        <span class="value-icon">🏆</span>
        <h3>Excellence in Education</h3>
        <p>We pursue the highest standards in teaching and learning, continuously improving our curriculum and methods to deliver an education that truly prepares students for the future. Every lesson is an opportunity to inspire greatness.</p>
      </div>

      <div class="value-card reveal reveal-d2">
        <span class="value-icon">🌟</span>
        <h3>Character Development</h3>
        <p>We believe education extends beyond textbooks. We nurture honesty, integrity, resilience, and empathy in every student, helping them grow into individuals who lead with purpose and act with principle in all areas of life.</p>
      </div>

      <div class="value-card reveal reveal-d3">
        <span class="value-icon">🚀</span>
        <h3>Innovation &amp; Technology</h3>
        <p>We embrace modern teaching tools and methodologies, ensuring our students are not just consumers of technology but creative, responsible, and confident digital citizens prepared for the opportunities of the 21st century.</p>
      </div>

      <div class="value-card reveal reveal-d1">
        <span class="value-icon">🤝</span>
        <h3>Community &amp; Service</h3>
        <p>We foster a strong sense of belonging and social responsibility. Through community service projects, collaborative learning, and family engagement, we teach students that giving back is an essential part of a meaningful life.</p>
      </div>

      <div class="value-card reveal reveal-d2">
        <span class="value-icon">🕊️</span>
        <h3>Respect &amp; Inclusion</h3>
        <p>We celebrate diversity and create an environment where every student, regardless of background, feels welcome and respected. Our classrooms are spaces where different perspectives are valued and every voice matters.</p>
      </div>

      <div class="value-card reveal reveal-d3">
        <span class="value-icon">📚</span>
        <h3>Lifelong Learning</h3>
        <p>We instill a love of learning that extends far beyond the classroom walls. By cultivating curiosity, creativity, and a growth mindset, we prepare students to be enthusiastic, self-directed learners throughout their entire lives.</p>
      </div>

    </div>

  </div>
</section>


<!-- ===== SECTION 5: HISTORY TIMELINE ===== -->
<section class="timeline-section">
  <div class="timeline-inner">

    <div class="timeline-header reveal">
      <div class="section-label">Our Journey</div>
      <h2 class="section-title">Milestones in Our History</h2>
      <p class="section-subtitle">Four decades of dedication to educational excellence in Abbottabad</p>
    </div>

    <div class="timeline">

      <div class="timeline-item reveal reveal-d1">
        <div class="timeline-dot"></div>
        <div class="timeline-content">
          <span class="timeline-year">1985</span>
          <h3>School Founded</h3>
          <p>Kamal Public Middle School was founded by Kamal Ahmed Khan with a vision to provide quality education to the children of Abbottabad. Starting with just a handful of students and a single classroom, KPMS began its journey of transforming young minds in the heart of KPK.</p>
        </div>
      </div>

      <div class="timeline-item reveal reveal-d2">
        <div class="timeline-dot"></div>
        <div class="timeline-content">
          <span class="timeline-year">1990</span>
          <h3>Expanded to Middle School</h3>
          <p>Responding to growing demand from families, KPMS expanded its academic offerings to include middle school grades. New classrooms were constructed, additional faculty were recruited, and the curriculum was enriched to serve students through the eighth grade.</p>
        </div>
      </div>

      <div class="timeline-item reveal reveal-d3">
        <div class="timeline-dot"></div>
        <div class="timeline-content">
          <span class="timeline-year">2000</span>
          <h3>Computer Lab Established</h3>
          <p>Recognizing the growing importance of technology in education, KPMS established its first dedicated computer laboratory. This forward-thinking investment gave students hands-on access to digital tools and laid the groundwork for the school's commitment to digital empowerment.</p>
        </div>
      </div>

      <div class="timeline-item reveal reveal-d1">
        <div class="timeline-dot"></div>
        <div class="timeline-content">
          <span class="timeline-year">2010</span>
          <h3>Modern Campus Renovation</h3>
          <p>A comprehensive renovation transformed the KPMS campus with modern facilities, including updated classrooms, a science laboratory, a library, and improved outdoor play areas. The renovated campus created an inspiring environment for both students and teachers alike.</p>
        </div>
      </div>

      <div class="timeline-item reveal reveal-d2">
        <div class="timeline-dot"></div>
        <div class="timeline-content">
          <span class="timeline-year">2020</span>
          <h3>Digital Learning Integration</h3>
          <p>KPMS embraced the digital age by integrating technology across all subjects and classrooms. Interactive whiteboards, student tablets, and digital learning platforms were introduced, enabling a blended learning approach that enhanced engagement and academic outcomes.</p>
        </div>
      </div>

      <div class="timeline-item reveal reveal-d3">
        <div class="timeline-dot"></div>
        <div class="timeline-content">
          <span class="timeline-year">2024</span>
          <h3>Montessori Program Launched</h3>
          <p>Expanding its reach to the youngest learners, KPMS launched a dedicated Montessori program for children ages 3 to 6. This new program brings the globally recognized Montessori philosophy to Abbottabad, emphasizing independence, hands-on learning, and respect for each child's developmental pace.</p>
        </div>
      </div>

    </div>

  </div>
</section>


<!-- ===== SECTION 6: LEADERSHIP / FOUNDER ===== -->
<section class="leadership-section">
  <div class="leadership-inner">

    <div class="leadership-header reveal">
      <div class="section-label">Our Leadership</div>
      <h2 class="section-title">The Visionary Behind KPMS</h2>
      <p class="section-subtitle">Meet the founder who started it all with a dream and unwavering determination</p>
    </div>

    <div class="founder-card reveal reveal-d1">
      <div class="founder-img">
        <div class="founder-img-placeholder">
          <span class="initials">KAK</span>
          <span class="role-text">Founder</span>
        </div>
      </div>
      <div class="founder-body">
        <span class="founder-badge">Founder &amp; Visionary</span>
        <h3>Kamal Ahmed Khan</h3>
        <div class="founder-title">Founder, Kamal Public Middle School</div>
        <p>In 1985, Kamal Ahmed Khan embarked on a mission to bring quality, accessible education to the children of Sheikh ul Bandi, Abbottabad. With a deep belief that every child deserves the opportunity to learn, grow, and succeed, he established KPMS as a beacon of educational excellence in the community.</p>
        <p>His philosophy has always been simple yet profound: education should build not just knowledge, but character. Under his guidance, KPMS has grown from a single classroom into a thriving institution that has touched the lives of thousands of students and families across the region.</p>
        <div class="founder-quote">"Education is the most powerful gift we can give our children. It shapes not just their future, but the future of our entire community."</div>
      </div>
    </div>

  </div>
</section>


<!-- ===== SECTION 7: CTA ===== -->
<section class="cta">
  <div class="cta-label reveal">Become Part of Our Story</div>
  <h2 class="cta-title reveal reveal-d1">Join Our Community</h2>
  <p class="cta-subtitle reveal reveal-d2">Experience the KPMS difference firsthand. Schedule a campus visit or begin your application today.</p>
  <div class="cta-actions reveal reveal-d3">
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
          <li><a href="/campus/">Visit Campus</a></li>
          <li><a href="/enrollment/">Admission FAQs</a></li>
          <li><a href="/calendar/">Admission Events</a></li>
          <li><a href="/contact/">Contact Admission</a></li>
        </ul>
      </div>
      <div>
        <h4 class="footer-heading">About</h4>
        <ul class="footer-links">
          <li><a href="/">Welcome</a></li>
          <li><a href="/campus/">Our Campus</a></li>
          <li><a href="/staff-directory/">Our Faculty</a></li>
          <li><a href="/mission-vision/">Mission &amp; Vision</a></li>
          <li><a href="/contact/">Contact Us</a></li>
        </ul>
      </div>
      <div>
        <h4 class="footer-heading">Links</h4>
        <ul class="footer-links">
          <li><a href="/careers/">Careers</a></li>
          <li><a href="/calendar/">Summer Programs</a></li>
          <li><a href="/student-resources/">Student Resources</a></li>
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