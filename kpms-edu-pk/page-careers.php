<?php
/*
Template Name: KPMS - Careers
*/
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Careers – KPMS | Kamal Public Middle School Abbottabad</title>
<?php include get_stylesheet_directory() . '/analytics.php'; ?>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400;1,500;1,600&family=DM+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<style>
:root {
  --blue: #003087; --blue-deep: #001f5c; --blue-light: #1a5fcc; --blue-bright: #2878e6;
  --gold: #FFD100; --gold-light: #FFE04A; --gold-warm: #FFC520;
  --coral: #E8443A; --sky: #00AEEF;
  --navy: #001840; --navy-deep: #000f2b;
  --cream: #f5f7fb; --cream-warm: #edf1f8;
  --white: #ffffff; --text: #0a1e3d; --text-muted: #4a5e7a;
  --ice: #e0eaff; --ice-light: #d0ddf5;
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
.btn-blue {
  background: var(--blue);
  color: var(--white);
}
.btn-blue:hover {
  background: var(--blue-deep);
  transform: translateY(-2px);
  box-shadow: 0 8px 24px rgba(0,48,135,0.3);
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
.btn-outline-blue {
  background: transparent;
  color: var(--blue);
  border: 2px solid var(--blue);
}
.btn-outline-blue:hover {
  background: var(--blue);
  color: var(--white);
  transform: translateY(-2px);
  box-shadow: 0 8px 24px rgba(0,48,135,0.2);
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
.btn-white {
  background: var(--white);
  color: var(--blue-deep);
}
.btn-white:hover {
  transform: translateY(-2px);
  box-shadow: 0 8px 24px rgba(0,0,0,0.15);
}

/* ===== HERO ===== */
.hero {
  position: relative;
  min-height: 520px;
  display: flex; align-items: center; justify-content: center;
  overflow: hidden;
  padding: 140px 60px 100px;
}
.hero-bg {
  position: absolute; inset: 0;
  background:
    linear-gradient(160deg, rgba(0,24,64,0.88) 0%, rgba(0,48,135,0.6) 50%, rgba(0,24,64,0.82) 100%),
    url('https://images.unsplash.com/photo-1522202176988-66273c2fd55f?w=1920&q=85') center/cover;
}
.hero-shapes {
  position: absolute; inset: 0; overflow: hidden; pointer-events: none;
}
.shape {
  position: absolute; border-radius: 50%; opacity: 0.08;
}
.shape-1 { width: 400px; height: 400px; background: var(--gold); top: -100px; right: -100px; }
.shape-2 { width: 250px; height: 250px; background: var(--coral); bottom: -60px; left: -60px; }
.shape-3 { width: 180px; height: 180px; background: var(--sky); top: 40%; left: 10%; }
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
  font-size: clamp(36px, 6vw, 60px);
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
.hero-scroll {
  position: absolute; bottom: 32px; left: 50%; transform: translateX(-50%);
  z-index: 2; opacity: 0; animation: fadeUp 0.8s 1.1s forwards;
}
.scroll-dot {
  width: 28px; height: 44px;
  border: 2px solid rgba(255,255,255,0.3);
  border-radius: 14px;
  position: relative;
}
.scroll-dot::after {
  content: '';
  position: absolute; top: 8px; left: 50%; transform: translateX(-50%);
  width: 4px; height: 8px;
  background: var(--gold-light);
  border-radius: 3px;
  animation: scrollBounce 2s infinite;
}
@keyframes scrollBounce {
  0%,100%{ transform: translateX(-50%) translateY(0); opacity: 1; }
  50%{ transform: translateX(-50%) translateY(10px); opacity: 0.3; }
}
@keyframes fadeUp {
  from { opacity: 0; transform: translateY(28px); }
  to { opacity: 1; transform: translateY(0); }
}

/* Now Hiring badge */
.now-hiring-ribbon {
  display: inline-flex; align-items: center; gap: 8px;
  background: var(--coral);
  color: var(--white);
  padding: 6px 18px;
  border-radius: 6px;
  font-size: 12px; font-weight: 700;
  letter-spacing: 1.5px; text-transform: uppercase;
  margin-bottom: 20px;
  opacity: 0; animation: fadeUp 0.8s 0.1s forwards;
  box-shadow: 0 4px 16px rgba(232,68,58,0.4);
}
.now-hiring-ribbon .pulse-dot {
  width: 8px; height: 8px;
  background: var(--white);
  border-radius: 50%;
  animation: pulse 1.5s infinite;
}
@keyframes pulse {
  0%, 100% { opacity: 1; transform: scale(1); }
  50% { opacity: 0.5; transform: scale(1.4); }
}

/* ===== WHY WORK AT KPMS ===== */
.why-section {
  padding: 100px 60px;
  background: var(--white);
}
.why-inner {
  max-width: 1200px; margin: 0 auto;
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 60px;
  align-items: center;
}
.why-text h2 {
  font-family: 'Playfair Display', serif;
  font-size: clamp(26px, 3.5vw, 36px);
  font-weight: 500;
  color: var(--text);
  line-height: 1.25;
  margin-bottom: 20px;
}
.why-text p {
  font-size: 16px; line-height: 1.8;
  color: var(--text-muted); margin-bottom: 16px;
}
.why-text ul {
  list-style: none; padding: 0; margin: 20px 0;
}
.why-text ul li {
  padding: 8px 0 8px 28px;
  position: relative; color: var(--text-muted);
  font-size: 15px; line-height: 1.6;
}
.why-text ul li::before {
  content: '';
  position: absolute; left: 0; top: 14px;
  width: 10px; height: 10px;
  background: var(--gold);
  clip-path: polygon(50% 0%, 100% 50%, 50% 100%, 0% 50%);
}
.why-image {
  border-radius: 20px;
  overflow: hidden;
  position: relative;
  box-shadow: 0 20px 60px rgba(0,0,0,0.1);
}
.why-image img {
  width: 100%; height: 100%;
  object-fit: cover;
  display: block;
  min-height: 400px;
}
.why-image-overlay {
  position: absolute; bottom: 0; left: 0; right: 0;
  padding: 24px;
  background: linear-gradient(to top, rgba(0,15,43,0.8) 0%, transparent 100%);
}
.why-image-stat {
  font-family: 'Playfair Display', serif;
  font-size: 28px; font-weight: 700;
  color: var(--gold-light);
}
.why-image-stat-label {
  font-size: 13px; color: rgba(255,255,255,0.8);
  font-weight: 600;
}

/* ===== BENEFITS ===== */
.benefits-section {
  padding: 100px 60px;
  background: var(--cream-warm);
}
.benefits-inner {
  max-width: 1200px; margin: 0 auto;
}
.benefits-header {
  text-align: center; margin-bottom: 60px;
}
.benefits-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 24px;
}
.benefit-card {
  background: var(--white);
  border: 2px solid var(--ice);
  border-radius: 16px;
  padding: 36px 28px;
  transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
  position: relative;
  overflow: hidden;
}
.benefit-card::before {
  content: '';
  position: absolute; top: 0; left: 0; right: 0;
  height: 4px;
  background: linear-gradient(90deg, var(--blue), var(--gold));
  transform: scaleX(0);
  transition: transform 0.4s cubic-bezier(0.16, 1, 0.3, 1);
  transform-origin: left;
}
.benefit-card:hover {
  border-color: var(--blue-light);
  box-shadow: 0 16px 48px rgba(0,48,135,0.1);
  transform: translateY(-6px);
}
.benefit-card:hover::before {
  transform: scaleX(1);
}
.benefit-icon {
  width: 56px; height: 56px;
  border-radius: 14px;
  display: flex; align-items: center; justify-content: center;
  font-size: 26px;
  margin-bottom: 20px;
}
.benefit-icon.dev { background: #e8f5e9; }
.benefit-icon.team { background: #e3f2fd; }
.benefit-icon.location { background: #fff3e0; }
.benefit-icon.impact { background: #fce4ec; }
.benefit-icon.salary { background: #f3e5f5; }
.benefit-icon.growth { background: #e0f7fa; }
.benefit-card h3 {
  font-family: 'Playfair Display', serif;
  font-size: 20px; font-weight: 600;
  color: var(--text); margin-bottom: 10px;
}
.benefit-card p {
  font-size: 14px; color: var(--text-muted);
  line-height: 1.7;
}

/* ===== CURRENT OPENINGS ===== */
.openings-section {
  padding: 100px 60px;
  background: var(--white);
}
.openings-inner {
  max-width: 1000px; margin: 0 auto;
}
.openings-header {
  text-align: center; margin-bottom: 60px;
}
.job-card {
  background: var(--white);
  border: 2px solid var(--ice);
  border-radius: 16px;
  padding: 32px;
  margin-bottom: 20px;
  transition: all 0.3s;
  display: flex; align-items: center; justify-content: space-between;
  gap: 24px;
}
.job-card:hover {
  border-color: var(--blue-light);
  box-shadow: 0 12px 40px rgba(0,48,135,0.08);
  transform: translateY(-3px);
}
.job-info { flex: 1; }
.job-title {
  font-family: 'Playfair Display', serif;
  font-size: 22px; font-weight: 600;
  color: var(--text); margin-bottom: 8px;
}
.job-meta {
  display: flex; gap: 16px; align-items: center;
  margin-bottom: 10px; flex-wrap: wrap;
}
.job-tag {
  display: inline-flex; align-items: center; gap: 4px;
  padding: 4px 12px;
  border-radius: 6px;
  font-size: 12px; font-weight: 600;
  letter-spacing: 0.5px;
}
.job-tag.dept {
  background: var(--ice);
  color: var(--blue);
}
.job-tag.type {
  background: #e8f5e9;
  color: #2e7d32;
}
.job-tag.type.part-time {
  background: #fff3e0;
  color: #e65100;
}
.job-desc {
  font-size: 14px; color: var(--text-muted);
  line-height: 1.6;
}
.job-apply {
  flex-shrink: 0;
}

/* ===== APPLICATION PROCESS ===== */
.process-section {
  padding: 100px 60px;
  background: var(--cream-warm);
}
.process-inner {
  max-width: 1000px; margin: 0 auto;
}
.process-header {
  text-align: center; margin-bottom: 60px;
}
.process-steps {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 20px;
  position: relative;
}
.process-steps::before {
  content: '';
  position: absolute;
  top: 40px;
  left: 12.5%;
  right: 12.5%;
  height: 3px;
  background: var(--ice);
  z-index: 0;
}
.process-step {
  text-align: center;
  position: relative;
  z-index: 1;
}
.step-number {
  width: 80px; height: 80px;
  border-radius: 50%;
  background: var(--blue);
  color: var(--white);
  font-family: 'Playfair Display', serif;
  font-size: 28px; font-weight: 700;
  display: flex; align-items: center; justify-content: center;
  margin: 0 auto 20px;
  box-shadow: 0 8px 24px rgba(0,48,135,0.2);
  transition: all 0.3s;
}
.process-step:hover .step-number {
  transform: scale(1.1);
  box-shadow: 0 12px 32px rgba(0,48,135,0.3);
  background: var(--blue-bright);
}
.process-step h4 {
  font-family: 'Playfair Display', serif;
  font-size: 17px; font-weight: 600;
  color: var(--text); margin-bottom: 8px;
}
.process-step p {
  font-size: 13px; color: var(--text-muted);
  line-height: 1.6;
}

/* ===== APPLICATION FORM ===== */
.form-section {
  padding: 100px 60px;
  background: var(--white);
}
.form-inner {
  max-width: 800px; margin: 0 auto;
}
.form-header {
  text-align: center; margin-bottom: 50px;
}
.kpms-form {
  background: var(--cream-warm);
  border-radius: 20px;
  padding: 48px;
  border: 2px solid var(--ice);
}
.form-group {
  margin-bottom: 24px;
}
.form-group label {
  display: block; font-size: 14px; font-weight: 600;
  color: var(--text); margin-bottom: 6px;
}
.form-group label .required {
  color: var(--coral);
}
.form-group input,
.form-group select,
.form-group textarea {
  width: 100%; padding: 12px 16px;
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
.form-group textarea {
  min-height: 140px;
  resize: vertical;
}
.form-group input[type="file"] {
  padding: 10px 16px;
  cursor: pointer;
}
.form-group input[type="file"]::file-selector-button {
  background: var(--blue);
  color: var(--white);
  border: none;
  padding: 8px 16px;
  border-radius: 6px;
  font-family: inherit;
  font-size: 13px;
  font-weight: 600;
  cursor: pointer;
  margin-right: 12px;
  transition: background 0.3s;
}
.form-group input[type="file"]::file-selector-button:hover {
  background: var(--blue-deep);
}
.form-row {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 16px;
}
.form-error {
  color: var(--coral);
  font-size: 12px;
  margin-top: 4px;
  display: none;
}
.form-group.error input,
.form-group.error select,
.form-group.error textarea {
  border-color: var(--coral);
}
.form-group.error .form-error {
  display: block;
}
.form-success {
  display: none;
  text-align: center;
  padding: 40px;
}
.form-success.show {
  display: block;
}
.form-success-icon {
  font-size: 60px;
  margin-bottom: 16px;
  display: block;
}
.form-success h3 {
  font-family: 'Playfair Display', serif;
  font-size: 24px; font-weight: 600;
  color: var(--text); margin-bottom: 10px;
}
.form-success p {
  font-size: 16px; color: var(--text-muted);
  line-height: 1.6;
}

/* ===== TESTIMONIAL ===== */
.testimonial-section {
  padding: 100px 60px;
  background: var(--navy);
  text-align: center;
  position: relative;
  overflow: hidden;
}
.testimonial-section::before {
  content: '';
  position: absolute; inset: 0;
  background: radial-gradient(ellipse at center, rgba(0,48,135,0.2) 0%, transparent 60%);
}
.testimonial-inner {
  max-width: 800px; margin: 0 auto;
  position: relative; z-index: 1;
}
.testimonial-quote {
  font-family: 'Playfair Display', serif;
  font-size: clamp(20px, 3vw, 28px);
  font-weight: 400;
  font-style: italic;
  color: var(--white);
  line-height: 1.6;
  margin-bottom: 32px;
}
.testimonial-quote::before {
  content: '\201C';
  display: block;
  font-size: 72px;
  color: var(--gold);
  line-height: 1;
  margin-bottom: 12px;
  font-style: normal;
}
.testimonial-author {
  display: flex; align-items: center; gap: 16px;
  justify-content: center;
}
.testimonial-avatar {
  width: 56px; height: 56px;
  border-radius: 50%;
  background: var(--blue);
  display: flex; align-items: center; justify-content: center;
  font-size: 22px; font-weight: 700;
  color: var(--gold-light);
  font-family: 'Playfair Display', serif;
  border: 3px solid rgba(255,255,255,0.15);
}
.testimonial-name {
  font-size: 16px; font-weight: 700;
  color: var(--white);
}
.testimonial-role {
  font-size: 13px; color: rgba(255,255,255,0.6);
  margin-top: 2px;
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
.reveal-d4 { transition-delay: 0.4s; }
.reveal-d5 { transition-delay: 0.5s; }

/* ===== RESPONSIVE ===== */
@media (max-width: 1200px) {
  .nav-inner { padding: 0 30px; }
  .hero { padding: 140px 30px 100px; }
  .why-section, .benefits-section, .openings-section,
  .process-section, .form-section, .testimonial-section,
  .cta, .footer { padding-left: 30px; padding-right: 30px; }
  .benefits-grid { grid-template-columns: repeat(2, 1fr); }
  .footer-grid { grid-template-columns: 1fr 1fr; }
}

@media (max-width: 900px) {
  .topbar { display: none; }
  .nav-menu { display: none; }
  .nav-search-btn { display: none; }
  .mobile-toggle { display: block; }
  .nav-inner { padding: 0 20px !important; height: 64px; }
  .hero { padding: 120px 20px 80px; }
  .why-inner { grid-template-columns: 1fr; gap: 40px; }
  .why-image { order: -1; }
  .why-image img { min-height: 280px; }
  .benefits-grid { grid-template-columns: repeat(2, 1fr); gap: 16px; }
  .benefit-card { padding: 24px 20px; }
  .job-card { flex-direction: column; align-items: flex-start; }
  .job-apply { width: 100%; }
  .job-apply .btn { width: 100%; text-align: center; }
  .process-steps { grid-template-columns: repeat(2, 1fr); gap: 30px; }
  .process-steps::before { display: none; }
  .kpms-form { padding: 32px 24px; }
  .form-row { grid-template-columns: 1fr; }
  .footer-grid { grid-template-columns: 1fr; gap: 32px; }
  .footer-bottom { flex-direction: column; text-align: center; }
  .hero-btns { flex-direction: column; align-items: center; }
  .why-section, .benefits-section, .openings-section,
  .process-section, .form-section, .testimonial-section,
  .cta, .footer { padding-left: 20px; padding-right: 20px; }
}

@media (max-width: 600px) {
  .benefits-grid { grid-template-columns: 1fr; }
  .process-steps { grid-template-columns: 1fr; gap: 24px; }
  .step-number { width: 64px; height: 64px; font-size: 24px; }
  .hero-title { font-size: 32px; }
  .kpms-form { padding: 24px 16px; }
  .testimonial-quote { font-size: 18px; }
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
    <a href="tel:+923135914700">&#128222; +92 313 5914700</a>
    <a href="mailto:careers@kpms.edu.pk">&#9993; careers@kpms.edu.pk</a>
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
    <a href="/parent-portal/" class="parent-portal-btn">&#128274; Parent Portal</a>
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
    <input type="text" placeholder="Search careers, positions, departments..." id="searchInput" aria-label="Search the site">
    <button class="search-close" onclick="toggleSearch()" aria-label="Close search">&#10005;</button>
  </div>
  <div class="search-hint">Press ESC to close</div>
</div>

<?php include get_stylesheet_directory() . '/mobile-menu.php'; ?>

<!-- ============================== -->
<!-- MAIN CONTENT -->
<!-- ============================== -->
<main id="main-content">

<!-- HERO -->
<section class="hero">
  <div class="hero-bg"></div>
  <div class="hero-shapes">
    <div class="shape shape-1"></div>
    <div class="shape shape-2"></div>
    <div class="shape shape-3"></div>
  </div>
  <div class="hero-content">
    <div class="now-hiring-ribbon">
      <span class="pulse-dot"></span>
      Now Hiring
    </div>
    <div class="hero-badge">Join Our Team</div>
    <h1 class="hero-title">Career <em>Opportunities</em></h1>
    <p class="hero-subtitle">Shape the future of education at KPMS. Join a passionate team of educators dedicated to inspiring young minds in the heart of Abbottabad.</p>
    <div class="hero-btns">
      <a href="#openings" class="btn btn-gold">View Open Positions</a>
      <a href="#apply-form" class="btn btn-outline-light">Apply Now</a>
    </div>
  </div>
  <div class="hero-scroll"><div class="scroll-dot"></div></div>
</section>

<!-- WHY WORK AT KPMS -->
<section class="why-section">
  <div class="why-inner">
    <div class="why-text reveal">
      <div class="section-label">Why KPMS</div>
      <h2>A Rewarding Place to Build Your Career</h2>
      <p>At Kamal Public Middle School, we believe that great educators are the foundation of great education. Since 1985, we have fostered a culture that values professional growth, collaboration, and the meaningful impact every team member has on our students' lives.</p>
      <p>Located in the scenic city of Abbottabad, surrounded by the natural beauty of the Hazara region, KPMS offers a working environment that is both professionally fulfilling and personally enriching.</p>
      <ul>
        <li>Ongoing professional development and training workshops</li>
        <li>Supportive and collaborative team culture</li>
        <li>Beautiful campus in the heart of Abbottabad</li>
        <li>Meaningful work that shapes the next generation</li>
      </ul>
      <a href="#openings" class="btn btn-blue" style="margin-top:16px;">See Open Roles</a>
    </div>
    <div class="why-image reveal reveal-d2">
      <img src="https://images.unsplash.com/photo-1524178232363-1fb2b075b655?w=800&q=80" alt="Teachers collaborating at KPMS">
      <div class="why-image-overlay">
        <div class="why-image-stat">40+</div>
        <div class="why-image-stat-label">Years of Educational Excellence</div>
      </div>
    </div>
  </div>
</section>

<!-- BENEFITS -->
<section class="benefits-section">
  <div class="benefits-inner">
    <div class="benefits-header reveal">
      <div class="section-label">Benefits &amp; Perks</div>
      <h2 class="section-title">What We Offer</h2>
      <p class="section-subtitle">KPMS is committed to supporting our team members in every way possible</p>
    </div>
    <div class="benefits-grid">
      <div class="benefit-card reveal reveal-d1">
        <div class="benefit-icon dev">
          <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="#2e7d32" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
        </div>
        <h3>Professional Development</h3>
        <p>Access ongoing training programs, workshops, and conferences to continuously enhance your teaching skills and stay current with the latest educational methodologies.</p>
      </div>
      <div class="benefit-card reveal reveal-d2">
        <div class="benefit-icon team">
          <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="#1565c0" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
        </div>
        <h3>Collaborative Environment</h3>
        <p>Work alongside a supportive team of dedicated professionals who share your passion for education. Our collaborative culture fosters innovation and mutual growth.</p>
      </div>
      <div class="benefit-card reveal reveal-d3">
        <div class="benefit-icon location">
          <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="#e65100" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
        </div>
        <h3>Beautiful Location</h3>
        <p>Our campus is situated in the picturesque city of Abbottabad, known for its pleasant climate, lush greenery, and breathtaking views of the surrounding mountains.</p>
      </div>
      <div class="benefit-card reveal reveal-d1">
        <div class="benefit-icon impact">
          <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="#c62828" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
        </div>
        <h3>Student Impact</h3>
        <p>Make a real difference in the lives of young learners. Every day, you will see the direct impact of your work as you help students discover their potential and build character.</p>
      </div>
      <div class="benefit-card reveal reveal-d2">
        <div class="benefit-icon salary">
          <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="#6a1b9a" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
        </div>
        <h3>Competitive Compensation</h3>
        <p>We offer attractive salary packages that recognize your qualifications and experience, along with comprehensive benefits to ensure your well-being and financial security.</p>
      </div>
      <div class="benefit-card reveal reveal-d3">
        <div class="benefit-icon growth">
          <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="#00695c" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/><polyline points="17 6 23 6 23 12"/></svg>
        </div>
        <h3>Growth Opportunities</h3>
        <p>Advance your career through clear pathways for professional progression. We actively promote from within and support our team members in achieving their career goals.</p>
      </div>
    </div>
  </div>
</section>

<!-- CURRENT OPENINGS -->
<section class="openings-section" id="openings">
  <div class="openings-inner">
    <div class="openings-header reveal">
      <div class="section-label">Open Positions</div>
      <h2 class="section-title">Current Openings</h2>
      <p class="section-subtitle">Find your place in our growing team of dedicated educators</p>
    </div>

    <div class="job-card reveal reveal-d1">
      <div class="job-info">
        <h3 class="job-title">Primary School Teacher</h3>
        <div class="job-meta">
          <span class="job-tag dept">Academic Faculty</span>
          <span class="job-tag type">Full Time</span>
        </div>
        <p class="job-desc">We are looking for a passionate educator to teach grades 1-5. The ideal candidate will have experience in creating engaging lesson plans and fostering a positive classroom environment that nurtures curiosity and academic growth.</p>
      </div>
      <div class="job-apply">
        <a href="#apply-form" class="btn btn-blue">Apply</a>
      </div>
    </div>

    <div class="job-card reveal reveal-d2">
      <div class="job-info">
        <h3 class="job-title">Montessori Guide</h3>
        <div class="job-meta">
          <span class="job-tag dept">Montessori Program</span>
          <span class="job-tag type">Full Time</span>
        </div>
        <p class="job-desc">Seeking a certified Montessori educator to guide children ages 3-6 through our renowned early childhood program. Candidates should hold a recognized Montessori certification and bring a deep understanding of child-centered learning.</p>
      </div>
      <div class="job-apply">
        <a href="#apply-form" class="btn btn-blue">Apply</a>
      </div>
    </div>

    <div class="job-card reveal reveal-d3">
      <div class="job-info">
        <h3 class="job-title">Computer Science Instructor</h3>
        <div class="job-meta">
          <span class="job-tag dept">Technology</span>
          <span class="job-tag type">Full Time</span>
        </div>
        <p class="job-desc">Join our team to teach technology and digital literacy across multiple grade levels. You will develop curriculum that prepares students for the digital age while fostering computational thinking and problem-solving skills.</p>
      </div>
      <div class="job-apply">
        <a href="#apply-form" class="btn btn-blue">Apply</a>
      </div>
    </div>

    <div class="job-card reveal reveal-d4">
      <div class="job-info">
        <h3 class="job-title">Administrative Assistant</h3>
        <div class="job-meta">
          <span class="job-tag dept">Administration</span>
          <span class="job-tag type">Full Time</span>
        </div>
        <p class="job-desc">Support the smooth operation of our school by managing communications, scheduling, record-keeping, and front office duties. This role is ideal for an organized professional who thrives in a collaborative school environment.</p>
      </div>
      <div class="job-apply">
        <a href="#apply-form" class="btn btn-blue">Apply</a>
      </div>
    </div>

    <div class="job-card reveal reveal-d5">
      <div class="job-info">
        <h3 class="job-title">Sports Coach</h3>
        <div class="job-meta">
          <span class="job-tag dept">Physical Education</span>
          <span class="job-tag type part-time">Part Time</span>
        </div>
        <p class="job-desc">Lead physical education classes and after-school sports programs. We seek an energetic coach who can inspire students to develop healthy habits, teamwork skills, and a lifelong love of physical activity.</p>
      </div>
      <div class="job-apply">
        <a href="#apply-form" class="btn btn-blue">Apply</a>
      </div>
    </div>

  </div>
</section>

<!-- APPLICATION PROCESS -->
<section class="process-section">
  <div class="process-inner">
    <div class="process-header reveal">
      <div class="section-label">How to Apply</div>
      <h2 class="section-title">Application Process</h2>
      <p class="section-subtitle">Four simple steps to join our team</p>
    </div>
    <div class="process-steps">
      <div class="process-step reveal reveal-d1">
        <div class="step-number">1</div>
        <h4>Browse Positions</h4>
        <p>Explore our current openings and find the role that matches your skills and passion for education.</p>
      </div>
      <div class="process-step reveal reveal-d2">
        <div class="step-number">2</div>
        <h4>Submit Application</h4>
        <p>Fill out our application form below with your details, resume, and a brief cover letter.</p>
      </div>
      <div class="process-step reveal reveal-d3">
        <div class="step-number">3</div>
        <h4>Interview Process</h4>
        <p>Qualified candidates will be invited for an interview with our academic leadership team.</p>
      </div>
      <div class="process-step reveal reveal-d4">
        <div class="step-number">4</div>
        <h4>Welcome to KPMS!</h4>
        <p>Successful candidates will receive an offer and begin their onboarding journey with our team.</p>
      </div>
    </div>
  </div>
</section>

<!-- APPLICATION FORM -->
<section class="form-section" id="apply-form">
  <div class="form-inner">
    <div class="form-header reveal">
      <div class="section-label">Apply Now</div>
      <h2 class="section-title">Submit Your Application</h2>
      <p class="section-subtitle">Take the first step towards a rewarding career at KPMS</p>
    </div>

    <?php $kpms_nonce = wp_create_nonce('kpms_form_nonce'); $kpms_ajax = admin_url('admin-ajax.php'); ?>
    <script>window.kpmsAjax={url:"<?php echo esc_url($kpms_ajax); ?>",nonce:"<?php echo esc_attr($kpms_nonce); ?>"};</script>
    <form class="kpms-form reveal" id="careerForm" novalidate>
      <input type="hidden" name="form_type" value="career">
      <div class="form-row">
        <div class="form-group" id="nameGroup">
          <label for="fullName">Full Name <span class="required">*</span></label>
          <input type="text" id="fullName" name="full_name" placeholder="Enter your full name" required>
          <div class="form-error">Please enter your full name</div>
        </div>
        <div class="form-group" id="emailGroup">
          <label for="email">Email Address <span class="required">*</span></label>
          <input type="email" id="email" name="email" placeholder="your.email@example.com" required>
          <div class="form-error">Please enter a valid email address</div>
        </div>
      </div>
      <div class="form-row">
        <div class="form-group" id="phoneGroup">
          <label for="phone">Phone Number <span class="required">*</span></label>
          <input type="tel" id="phone" name="phone" placeholder="+92 3XX XXXXXXX" required>
          <div class="form-error">Please enter your phone number</div>
        </div>
        <div class="form-group" id="positionGroup">
          <label for="position">Position Interested In <span class="required">*</span></label>
          <select id="position" name="position" required>
            <option value="">Select a position...</option>
            <option value="primary-teacher">Primary School Teacher</option>
            <option value="montessori-guide">Montessori Guide</option>
            <option value="cs-instructor">Computer Science Instructor</option>
            <option value="admin-assistant">Administrative Assistant</option>
            <option value="sports-coach">Sports Coach</option>
            <option value="other">Other / General Application</option>
          </select>
          <div class="form-error">Please select a position</div>
        </div>
      </div>
      <div class="form-group" id="messageGroup">
        <label for="coverLetter">Cover Letter / Message</label>
        <textarea id="coverLetter" name="cover_letter" placeholder="Tell us about yourself, your experience, and why you'd like to join KPMS..." rows="6"></textarea>
      </div>
      <div style="text-align:center; margin-top:8px;">
        <button type="submit" id="careerSubmitBtn" class="btn btn-gold" style="padding:16px 48px; font-size:15px;">Submit Application</button>
      </div>
      <div id="careerFormMsg" style="display:none; text-align:center; margin-top:20px; padding:16px 24px; border-radius:10px; font-weight:600;"></div>
    </form>

    <div class="form-success" id="formSuccess">
      <span class="form-success-icon">&#10004;&#65039;</span>
      <h3>Application Submitted!</h3>
      <p>Thank you for your interest in joining KPMS. Our team will review your application and get back to you within 5-7 business days.</p>
    </div>
  </div>
</section>

<!-- TESTIMONIAL -->
<section class="testimonial-section">
  <div class="testimonial-inner reveal">
    <div class="testimonial-quote">
      Working at KPMS has been the most fulfilling chapter of my career. The administration truly supports our professional growth, and seeing our students thrive every day reminds me why I chose this profession. The sense of community here is unlike anything I have experienced before.
    </div>
    <div class="testimonial-author">
      <div class="testimonial-avatar">S</div>
      <div>
        <div class="testimonial-name">Saima Anwar</div>
        <div class="testimonial-role">Senior Primary Teacher, KPMS (Since 2012)</div>
      </div>
    </div>
  </div>
</section>

<!-- CTA -->
<section class="cta">
  <div class="cta-label">We're Here to Help</div>
  <h2 class="cta-title">Questions About Careers?</h2>
  <div class="cta-actions">
    <a href="/contact/" class="btn btn-gold">Contact HR</a>
    <a href="#openings" class="btn btn-outline-light">View Openings</a>
  </div>
</section>

</main>

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
// ===== STICKY NAV SHADOW =====
window.addEventListener('scroll', () => {
  document.getElementById('nav').classList.toggle('scrolled', window.scrollY > 10);
});

// ===== MOBILE NAV =====
<?php include get_stylesheet_directory() . '/mobile-menu-js.php'; ?>

// ===== SEARCH OVERLAY =====
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
  if ((e.metaKey || e.ctrlKey) && e.key === 'k') {
    e.preventDefault();
    toggleSearch();
  }
});

// ===== SCROLL REVEAL =====
const reveals = document.querySelectorAll('.reveal');
const obs = new IntersectionObserver(entries => {
  entries.forEach(e => { if (e.isIntersecting) e.target.classList.add('visible'); });
}, { threshold: 0.12, rootMargin: '0px 0px -40px 0px' });
reveals.forEach(el => obs.observe(el));

// ===== SMOOTH SCROLL FOR ANCHOR LINKS =====
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
  anchor.addEventListener('click', function(e) {
    const target = document.querySelector(this.getAttribute('href'));
    if (target) {
      e.preventDefault();
      target.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }
  });
});

// ===== FORM VALIDATION & AJAX SUBMIT =====
document.getElementById('careerForm').addEventListener('submit', async function(e) {
  e.preventDefault();
  const form = this;
  const btn = document.getElementById('careerSubmitBtn');
  const msgDiv = document.getElementById('careerFormMsg');
  let isValid = true;

  // Reset errors
  document.querySelectorAll('.form-group').forEach(g => g.classList.remove('error'));
  msgDiv.style.display = 'none';

  // Full Name
  if (!document.getElementById('fullName').value.trim()) {
    document.getElementById('nameGroup').classList.add('error');
    isValid = false;
  }

  // Email
  const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  if (!document.getElementById('email').value.trim() || !emailRegex.test(document.getElementById('email').value.trim())) {
    document.getElementById('emailGroup').classList.add('error');
    isValid = false;
  }

  // Phone
  if (!document.getElementById('phone').value.trim()) {
    document.getElementById('phoneGroup').classList.add('error');
    isValid = false;
  }

  // Position
  if (!document.getElementById('position').value) {
    document.getElementById('positionGroup').classList.add('error');
    isValid = false;
  }

  if (!isValid) {
    const firstError = document.querySelector('.form-group.error');
    if (firstError) firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
    return;
  }

  // Submit via AJAX
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
      document.getElementById('careerForm').style.display = 'none';
      document.getElementById('formSuccess').classList.add('show');
      document.getElementById('formSuccess').scrollIntoView({ behavior: 'smooth', block: 'center' });
    } else {
      msgDiv.style.cssText = 'display:block;text-align:center;margin-top:20px;padding:16px 24px;border-radius:10px;font-weight:600;background:#f8d7da;color:#721c24;';
      msgDiv.textContent = json.data?.message || 'Something went wrong.';
    }
  } catch(err) {
    msgDiv.style.cssText = 'display:block;text-align:center;margin-top:20px;padding:16px 24px;border-radius:10px;font-weight:600;background:#f8d7da;color:#721c24;';
    msgDiv.textContent = 'Network error. Please try again.';
  }
  btn.disabled = false;
  btn.textContent = origText;
});
</script>


</body>
</html>
