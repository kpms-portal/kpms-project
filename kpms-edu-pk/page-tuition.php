<?php
/*
Template Name: KPMS - Tuition &amp; Tutoring
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
<title>Tuition &amp; Tutoring – KPMS | Kamal Public Middle School Abbottabad</title>
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

/* ===== BUTTON STYLES ===== */
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
.btn-blue {
  background: var(--blue);
  color: var(--white);
}
.btn-blue:hover {
  background: var(--blue-deep);
  transform: translateY(-2px);
  box-shadow: 0 8px 24px rgba(0,48,135,0.3);
}

/* ===== ANIMATIONS ===== */
@keyframes fadeUp {
  from { opacity: 0; transform: translateY(28px); }
  to { opacity: 1; transform: translateY(0); }
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

/* ===== SUBJECT CARDS GRID ===== */
.subjects-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 24px;
  margin: 40px 0;
}
.subject-card {
  background: var(--white);
  border: 2px solid var(--ice);
  border-radius: 16px;
  padding: 32px 24px;
  text-align: center;
  transition: all 0.4s cubic-bezier(0.16,1,0.3,1);
  position: relative;
  overflow: hidden;
}
.subject-card:hover {
  border-color: var(--blue-light);
  box-shadow: 0 16px 48px rgba(0,48,135,0.1);
  transform: translateY(-6px);
}
.subject-card-emoji {
  font-size: 48px;
  margin-bottom: 16px;
  display: block;
  transition: transform 0.3s cubic-bezier(0.16,1,0.3,1);
}
.subject-card:hover .subject-card-emoji {
  transform: scale(1.2);
}
.subject-card h3 {
  font-family: 'Playfair Display', serif;
  font-size: 20px; font-weight: 600;
  color: var(--text); margin: 0 0 12px;
}
.subject-card p {
  font-size: 14px; color: var(--text-muted);
  line-height: 1.7; margin: 0 0 16px;
}
.subject-levels {
  display: flex; gap: 6px; justify-content: center; flex-wrap: wrap;
}
.level-badge {
  font-size: 11px; font-weight: 700;
  padding: 4px 12px; border-radius: 20px;
  letter-spacing: 0.5px;
}
.level-beginner { background: #e8f5e9; color: #2e7d32; }
.level-intermediate { background: #fff3e0; color: #e65100; }
.level-advanced { background: #fce4ec; color: #c62828; }

/* ===== TUTORING OPTIONS ===== */
.tutoring-options {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 28px;
  margin: 40px 0;
}
.tutor-option-card {
  background: var(--white);
  border: 2px solid var(--ice);
  border-radius: 16px;
  padding: 40px 32px;
  transition: all 0.4s cubic-bezier(0.16,1,0.3,1);
}
.tutor-option-card:hover {
  border-color: var(--blue-light);
  box-shadow: 0 16px 48px rgba(0,48,135,0.1);
  transform: translateY(-6px);
}
.tutor-option-icon {
  font-size: 48px; margin-bottom: 20px; display: block;
}
.tutor-option-card h3 {
  font-family: 'Playfair Display', serif;
  font-size: 22px; font-weight: 600;
  color: var(--text); margin: 0 0 12px;
}
.tutor-option-card > p {
  font-size: 15px; color: var(--text-muted);
  line-height: 1.7; margin: 0 0 20px;
}
.tutor-benefits {
  list-style: none; padding: 0; margin: 0 0 20px;
}
.tutor-benefits li {
  padding: 8px 0 8px 28px;
  position: relative;
  font-size: 14px; color: var(--text-muted);
  line-height: 1.6;
}
.tutor-benefits li::before {
  content: '✓';
  position: absolute; left: 0;
  color: #2e7d32; font-weight: 700;
  font-size: 16px;
}
.tutor-price {
  font-family: 'Playfair Display', serif;
  font-size: 28px; font-weight: 700;
  color: var(--blue);
}
.tutor-price span {
  font-family: 'DM Sans', sans-serif;
  font-size: 14px; font-weight: 500;
  color: var(--text-muted);
}

/* ===== AFTER-SCHOOL PROGRAM ===== */
.afterschool-section {
  background: var(--cream-warm);
  padding: 80px 60px;
}
.afterschool-inner {
  max-width: 1100px; margin: 0 auto;
}
.afterschool-grid {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 40px;
  margin-top: 40px;
  align-items: start;
}
.afterschool-details {
  font-size: 15px; color: var(--text-muted); line-height: 1.8;
}
.afterschool-features {
  list-style: none; padding: 0; margin: 20px 0;
}
.afterschool-features li {
  padding: 10px 0 10px 32px;
  position: relative;
  font-size: 15px; color: var(--text-muted);
}
.afterschool-features li::before {
  content: '✦';
  position: absolute; left: 0;
  color: var(--gold); font-size: 14px;
}
.schedule-table {
  width: 100%;
  border-collapse: separate;
  border-spacing: 0;
  border-radius: 14px;
  overflow: hidden;
  box-shadow: 0 8px 30px rgba(0,0,0,0.06);
  background: var(--white);
}
.schedule-table th {
  background: var(--blue);
  color: var(--white);
  padding: 14px 16px;
  font-size: 13px; font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 1px;
  text-align: left;
}
.schedule-table td {
  padding: 14px 16px;
  font-size: 14px;
  color: var(--text-muted);
  border-bottom: 1px solid var(--ice);
}
.schedule-table tr:last-child td {
  border-bottom: none;
}
.schedule-table tr:hover td {
  background: var(--ice);
}

/* ===== PRICING TABLE ===== */
.pricing-section {
  padding: 80px 60px;
  max-width: 1200px; margin: 0 auto;
}
.pricing-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 24px;
  margin-top: 40px;
}
.pricing-card {
  background: var(--white);
  border: 2px solid var(--ice);
  border-radius: 16px;
  padding: 40px 28px;
  text-align: center;
  transition: all 0.4s cubic-bezier(0.16,1,0.3,1);
  position: relative;
}
.pricing-card:hover {
  transform: translateY(-8px);
  box-shadow: 0 20px 60px rgba(0,48,135,0.1);
}
.pricing-card.featured {
  border-color: var(--gold);
  box-shadow: 0 12px 40px rgba(255,209,0,0.15);
}
.pricing-card.featured::before {
  content: 'Most Popular';
  position: absolute;
  top: -14px; left: 50%; transform: translateX(-50%);
  background: var(--gold);
  color: var(--navy-deep);
  padding: 6px 20px;
  border-radius: 20px;
  font-size: 12px; font-weight: 700;
  letter-spacing: 1px;
  text-transform: uppercase;
}
.pricing-card-icon {
  font-size: 42px; margin-bottom: 16px; display: block;
}
.pricing-card h3 {
  font-family: 'Playfair Display', serif;
  font-size: 22px; font-weight: 600;
  color: var(--text); margin: 0 0 8px;
}
.pricing-amount {
  font-family: 'Playfair Display', serif;
  font-size: 42px; font-weight: 700;
  color: var(--blue); margin: 16px 0 4px;
}
.pricing-period {
  font-size: 14px; color: var(--text-muted); margin-bottom: 24px;
}
.pricing-features {
  list-style: none; padding: 0; margin: 0 0 28px;
  text-align: left;
}
.pricing-features li {
  padding: 10px 0 10px 28px;
  position: relative;
  font-size: 14px; color: var(--text-muted);
  border-bottom: 1px solid var(--ice);
}
.pricing-features li:last-child {
  border-bottom: none;
}
.pricing-features li::before {
  content: '✓';
  position: absolute; left: 0;
  color: #2e7d32; font-weight: 700; font-size: 16px;
}

/* ===== SCHEDULE GRID ===== */
.schedule-section {
  background: var(--cream-warm);
  padding: 80px 60px;
}
.schedule-inner {
  max-width: 1100px; margin: 0 auto;
}
.week-grid {
  display: grid;
  grid-template-columns: repeat(5, 1fr);
  gap: 12px;
  margin-top: 40px;
}
.day-column {
  background: var(--white);
  border: 2px solid var(--ice);
  border-radius: 14px;
  overflow: hidden;
  transition: all 0.3s;
}
.day-column:hover {
  border-color: var(--blue-light);
  box-shadow: 0 8px 24px rgba(0,48,135,0.08);
  transform: translateY(-3px);
}
.day-header {
  background: var(--blue);
  color: var(--white);
  padding: 14px;
  text-align: center;
  font-size: 14px; font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 1px;
}
.day-slots {
  padding: 12px;
}
.time-slot {
  padding: 10px 12px;
  border-radius: 8px;
  margin-bottom: 8px;
  font-size: 13px;
  font-weight: 600;
  text-align: center;
  transition: all 0.2s;
}
.time-slot:last-child { margin-bottom: 0; }
.slot-available {
  background: #e8f5e9;
  color: #2e7d32;
  border: 1px solid #c8e6c9;
}
.slot-available:hover {
  background: #c8e6c9;
}
.slot-limited {
  background: #fff3e0;
  color: #e65100;
  border: 1px solid #ffe0b2;
}
.slot-full {
  background: #fce4ec;
  color: #c62828;
  border: 1px solid #f8bbd0;
}

/* ===== ENROLLMENT STEPS ===== */
.enroll-section {
  padding: 80px 60px;
  max-width: 1100px; margin: 0 auto;
}
.steps-timeline {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 0;
  margin-top: 50px;
  position: relative;
}
.steps-timeline::before {
  content: '';
  position: absolute;
  top: 40px;
  left: 12.5%;
  right: 12.5%;
  height: 3px;
  background: var(--ice);
  z-index: 0;
}
.step-item {
  text-align: center;
  position: relative;
  z-index: 1;
}
.step-circle {
  width: 80px; height: 80px;
  border-radius: 50%;
  background: var(--blue);
  color: var(--white);
  display: flex; align-items: center; justify-content: center;
  font-size: 32px;
  margin: 0 auto 20px;
  box-shadow: 0 8px 24px rgba(0,48,135,0.2);
  transition: all 0.3s;
}
.step-item:hover .step-circle {
  transform: scale(1.1);
  box-shadow: 0 12px 36px rgba(0,48,135,0.3);
}
.step-number {
  font-size: 11px; font-weight: 700;
  color: var(--blue);
  letter-spacing: 2px;
  text-transform: uppercase;
  margin-bottom: 8px;
}
.step-item h4 {
  font-family: 'Playfair Display', serif;
  font-size: 18px; font-weight: 600;
  color: var(--text); margin-bottom: 8px;
}
.step-item p {
  font-size: 13px; color: var(--text-muted);
  line-height: 1.6;
  max-width: 180px; margin: 0 auto;
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
  .subjects-grid { grid-template-columns: repeat(2, 1fr); }
  .pricing-grid { grid-template-columns: repeat(2, 1fr); }
  .week-grid { grid-template-columns: repeat(3, 1fr); }
  .steps-timeline { grid-template-columns: repeat(2, 1fr); gap: 40px; }
  .steps-timeline::before { display: none; }
  .footer-grid { grid-template-columns: 1fr 1fr; }
  .afterschool-grid { grid-template-columns: 1fr; }
}

@media (max-width: 768px) {
  .topbar { display: none; }
  .nav-menu { display: none; }
  .nav-search-btn { display: none; }
  .mobile-toggle { display: block; }
  .nav-inner { padding: 0 20px !important; height: 64px; }
  .page-hero { padding: 120px 20px 60px; }
  .page-content { padding: 40px 20px; }
  .subjects-grid { grid-template-columns: 1fr; }
  .tutoring-options { grid-template-columns: 1fr; }
  .pricing-grid { grid-template-columns: 1fr; max-width: 400px; margin-left: auto; margin-right: auto; }
  .pricing-card.featured { margin-top: 20px; }
  .week-grid { grid-template-columns: repeat(2, 1fr); }
  .week-grid .day-column:nth-child(5) { grid-column: 1 / -1; max-width: 240px; margin: 0 auto; }
  .steps-timeline { grid-template-columns: 1fr 1fr; gap: 30px; }
  .steps-timeline::before { display: none; }
  .afterschool-section { padding: 60px 20px; }
  .pricing-section { padding: 60px 20px; }
  .schedule-section { padding: 60px 20px; }
  .enroll-section { padding: 60px 20px; }
  .footer-grid { grid-template-columns: 1fr; gap: 32px; }
  .footer-bottom { flex-direction: column; text-align: center; }
  .cta { padding: 50px 20px; }
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
<section class="page-hero" id="main-content" style="background: linear-gradient(160deg, rgba(0,24,64,0.88) 0%, rgba(0,48,135,0.7) 50%, rgba(0,24,64,0.82) 100%), url('https://images.unsplash.com/photo-1522202176988-66273c2fd55f?w=1920&q=85') center/cover;">
  <div class="page-hero-label">Academic Programs</div>
  <h1 class="page-hero-title">Tuition &amp; Tutoring</h1>
  <p class="page-hero-subtitle">Personalized academic support to help every student reach their full potential</p>
  <div class="page-breadcrumb"><a href="/">Home</a> / <a href="/montessori/">Academic Programs</a> / Tuition &amp; Tutoring</div>
</section>


<!-- SECTION 1: TUTORING SUBJECTS -->
<div class="page-content">
  <div style="text-align:center; margin-bottom:10px;" class="reveal">
    <div class="section-label">What We Teach</div>
    <h2 class="section-title">Tutoring Subjects</h2>
    <p class="section-subtitle" style="color:var(--text-muted); font-size:16px; max-width:600px; margin:10px auto 0;">Expert tutoring across all core subjects of the Pakistani national curriculum</p>
  </div>

  <div class="subjects-grid">
    <div class="subject-card reveal reveal-d1">
      <span class="subject-card-emoji">&#x1F4D0;</span>
      <h3>Mathematics</h3>
      <p>Arithmetic, algebra, geometry, fractions, decimals, and problem-solving strategies</p>
      <div class="subject-levels">
        <span class="level-badge level-beginner">Beginner</span>
        <span class="level-badge level-intermediate">Intermediate</span>
        <span class="level-badge level-advanced">Advanced</span>
      </div>
    </div>
    <div class="subject-card reveal reveal-d2">
      <span class="subject-card-emoji">&#x1F4DA;</span>
      <h3>English</h3>
      <p>Reading comprehension, grammar, essay writing, vocabulary building, and spoken English</p>
      <div class="subject-levels">
        <span class="level-badge level-beginner">Beginner</span>
        <span class="level-badge level-intermediate">Intermediate</span>
        <span class="level-badge level-advanced">Advanced</span>
      </div>
    </div>
    <div class="subject-card reveal reveal-d3">
      <span class="subject-card-emoji">&#x1F52C;</span>
      <h3>Science</h3>
      <p>General science, physics concepts, biology basics, chemistry fundamentals, and lab skills</p>
      <div class="subject-levels">
        <span class="level-badge level-beginner">Beginner</span>
        <span class="level-badge level-intermediate">Intermediate</span>
        <span class="level-badge level-advanced">Advanced</span>
      </div>
    </div>
    <div class="subject-card reveal reveal-d1">
      <span class="subject-card-emoji">&#x1F4DD;</span>
      <h3>Urdu</h3>
      <p>Urdu reading, writing, grammar, composition, poetry comprehension, and Nazra</p>
      <div class="subject-levels">
        <span class="level-badge level-beginner">Beginner</span>
        <span class="level-badge level-intermediate">Intermediate</span>
        <span class="level-badge level-advanced">Advanced</span>
      </div>
    </div>
    <div class="subject-card reveal reveal-d2">
      <span class="subject-card-emoji">&#x1F30D;</span>
      <h3>Social Studies</h3>
      <p>Pakistan studies, geography, history, civics, current affairs, and map skills</p>
      <div class="subject-levels">
        <span class="level-badge level-beginner">Beginner</span>
        <span class="level-badge level-intermediate">Intermediate</span>
      </div>
    </div>
    <div class="subject-card reveal reveal-d3">
      <span class="subject-card-emoji">&#x1F54C;</span>
      <h3>Islamiyat</h3>
      <p>Islamic studies, Quran recitation, Hadith, Islamic history, ethics, and moral values</p>
      <div class="subject-levels">
        <span class="level-badge level-beginner">Beginner</span>
        <span class="level-badge level-intermediate">Intermediate</span>
      </div>
    </div>
  </div>
</div>


<!-- SECTION 2: TUTORING OPTIONS -->
<div style="background:var(--cream-warm); padding:80px 60px;">
  <div style="max-width:1100px; margin:0 auto;">
    <div style="text-align:center; margin-bottom:10px;" class="reveal">
      <div class="section-label">Choose Your Style</div>
      <h2 class="section-title">Tutoring Options</h2>
      <p style="color:var(--text-muted); font-size:16px; max-width:600px; margin:10px auto 0;">Flexible learning formats tailored to your child's needs</p>
    </div>

    <div class="tutoring-options">
      <div class="tutor-option-card reveal reveal-d1">
        <span class="tutor-option-icon">&#x1F464;</span>
        <h3>One-on-One Tutoring</h3>
        <p>Focused, individualized instruction designed to address your child's specific learning gaps and accelerate progress.</p>
        <ul class="tutor-benefits">
          <li>Personalized attention from a dedicated tutor</li>
          <li>Custom-paced lessons based on student ability</li>
          <li>Flexible scheduling around your family's routine</li>
          <li>Detailed progress reports sent to parents</li>
          <li>Exam preparation and practice tests</li>
        </ul>
        <a href="/contact/" class="btn btn-blue" style="margin-top:16px; font-size:13px; padding:10px 24px;">Inquire Now</a>
      </div>
      <div class="tutor-option-card reveal reveal-d2">
        <span class="tutor-option-icon">&#x1F465;</span>
        <h3>Group Tutoring</h3>
        <p>Small-group sessions that combine expert instruction with the benefits of collaborative learning and peer support.</p>
        <ul class="tutor-benefits">
          <li>Small groups of 3-5 students</li>
          <li>Collaborative problem-solving activities</li>
          <li>Peer support and healthy academic competition</li>
          <li>Affordable rates for families</li>
          <li>Social skill development alongside academics</li>
        </ul>
        <a href="/contact/" class="btn btn-blue" style="margin-top:16px; font-size:13px; padding:10px 24px;">Inquire Now</a>
      </div>
    </div>
  </div>
</div>


<!-- SECTION 3: AFTER-SCHOOL PROGRAM -->
<section class="afterschool-section">
  <div class="afterschool-inner">
    <div style="text-align:center; margin-bottom:10px;" class="reveal">
      <div class="section-label">Extended Learning</div>
      <h2 class="section-title">After-School Program</h2>
      <p style="color:var(--text-muted); font-size:16px; max-width:600px; margin:10px auto 0;">A structured, supervised environment for homework help and enrichment from 2:30 to 5:00 PM</p>
    </div>

    <div class="afterschool-grid">
      <div class="reveal reveal-d1">
        <div class="afterschool-details">
          <p style="font-size:16px; line-height:1.8; color:var(--text-muted); margin-bottom:20px;">Our after-school program provides a safe, stimulating environment where students can complete homework, receive additional academic support, and participate in enrichment activities.</p>
          <ul class="afterschool-features">
            <li>Supervised homework help with qualified teachers</li>
            <li>Subject-specific enrichment activities</li>
            <li>Guided study sessions and reading time</li>
            <li>Healthy afternoon snack included</li>
            <li>Safe pick-up procedures for parents</li>
            <li>Art, craft, and creative expression time</li>
          </ul>
          <div style="margin-top:24px;">
            <img src="https://images.unsplash.com/photo-1503676260728-1c00da094a0b?w=600&q=80" alt="Students studying" style="width:100%; border-radius:14px; box-shadow:0 8px 30px rgba(0,0,0,0.1);">
          </div>
        </div>
      </div>
      <div class="reveal reveal-d2">
        <table class="schedule-table">
          <thead>
            <tr>
              <th>Time</th>
              <th>Activity</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td><strong>2:30 - 2:45 PM</strong></td>
              <td>Arrival &amp; Snack Time</td>
            </tr>
            <tr>
              <td><strong>2:45 - 3:30 PM</strong></td>
              <td>Homework Help Session</td>
            </tr>
            <tr>
              <td><strong>3:30 - 4:00 PM</strong></td>
              <td>Subject Enrichment Activity</td>
            </tr>
            <tr>
              <td><strong>4:00 - 4:30 PM</strong></td>
              <td>Guided Study &amp; Reading</td>
            </tr>
            <tr>
              <td><strong>4:30 - 4:50 PM</strong></td>
              <td>Creative Expression / Art</td>
            </tr>
            <tr>
              <td><strong>4:50 - 5:00 PM</strong></td>
              <td>Pack Up &amp; Pick-Up</td>
            </tr>
          </tbody>
        </table>
        <div style="margin-top:24px; padding:20px; background:var(--white); border-radius:14px; border:2px solid var(--ice);">
          <p style="font-size:14px; color:var(--text-muted); margin:0;">Monday through Friday, snack included. <a href="/contact/" style="color:var(--blue); font-weight:600;">Contact us</a> for details.</p>
        </div>
      </div>
    </div>
  </div>
</section>


<!-- SECTION 4: HOW TO ENROLL -->
<section class="pricing-section">
  <div style="text-align:center; margin-bottom:10px;" class="reveal">
    <div class="section-label">Get Started</div>
    <h2 class="section-title">How to Enroll in Tutoring</h2>
    <p style="color:var(--text-muted); font-size:16px; max-width:600px; margin:10px auto 0;">Contact us to learn about our tutoring options and find the right fit for your child</p>
  </div>

  <div class="pricing-grid">
    <div class="pricing-card reveal reveal-d1">
      <span class="pricing-card-icon">&#x1F393;</span>
      <h3>Individual Sessions</h3>
      <ul class="pricing-features">
        <li>One-on-one with dedicated tutor</li>
        <li>Any subject of your choice</li>
        <li>Flexible scheduling</li>
        <li>Progress report after each session</li>
        <li>Free initial assessment</li>
      </ul>
      <a href="/contact/" class="btn btn-blue" style="width:100%; text-align:center;">Inquire Now</a>
    </div>

    <div class="pricing-card featured reveal reveal-d2">
      <span class="pricing-card-icon">&#x2B50;</span>
      <h3>Monthly Packages</h3>
      <ul class="pricing-features">
        <li>Multiple sessions per month</li>
        <li>Up to 2 subjects covered</li>
        <li>Priority scheduling</li>
        <li>Monthly progress report</li>
        <li>Free parent-teacher meeting</li>
        <li>Exam prep materials included</li>
      </ul>
      <a href="/contact/" class="btn btn-gold" style="width:100%; text-align:center;">Contact Us</a>
    </div>

    <div class="pricing-card reveal reveal-d3">
      <span class="pricing-card-icon">&#x1F46B;</span>
      <h3>Group Sessions</h3>
      <ul class="pricing-features">
        <li>Small groups (3-5 students)</li>
        <li>Collaborative learning environment</li>
        <li>Peer-to-peer support</li>
        <li>Weekly progress updates</li>
        <li>Sibling discounts available</li>
      </ul>
      <a href="/contact/" class="btn btn-blue" style="width:100%; text-align:center;">Learn More</a>
    </div>
  </div>
</section>


<!-- SECTION 5: SCHEDULE & AVAILABILITY -->
<section class="schedule-section">
  <div class="schedule-inner">
    <div style="text-align:center; margin-bottom:10px;" class="reveal">
      <div class="section-label">Plan Ahead</div>
      <h2 class="section-title">Schedule &amp; Availability</h2>
      <p style="color:var(--text-muted); font-size:16px; max-width:600px; margin:10px auto 0;">View available tutoring slots throughout the week</p>
    </div>

    <div class="week-grid">
      <div class="day-column reveal reveal-d1">
        <div class="day-header">Monday</div>
        <div class="day-slots">
          <div class="time-slot slot-available">8:00 - 9:00 AM</div>
          <div class="time-slot slot-available">9:00 - 10:00 AM</div>
          <div class="time-slot slot-limited">3:00 - 4:00 PM</div>
          <div class="time-slot slot-available">4:00 - 5:00 PM</div>
        </div>
      </div>
      <div class="day-column reveal reveal-d2">
        <div class="day-header">Tuesday</div>
        <div class="day-slots">
          <div class="time-slot slot-available">8:00 - 9:00 AM</div>
          <div class="time-slot slot-limited">9:00 - 10:00 AM</div>
          <div class="time-slot slot-available">3:00 - 4:00 PM</div>
          <div class="time-slot slot-full">4:00 - 5:00 PM</div>
        </div>
      </div>
      <div class="day-column reveal reveal-d3">
        <div class="day-header">Wednesday</div>
        <div class="day-slots">
          <div class="time-slot slot-limited">8:00 - 9:00 AM</div>
          <div class="time-slot slot-available">9:00 - 10:00 AM</div>
          <div class="time-slot slot-available">3:00 - 4:00 PM</div>
          <div class="time-slot slot-available">4:00 - 5:00 PM</div>
        </div>
      </div>
      <div class="day-column reveal reveal-d1">
        <div class="day-header">Thursday</div>
        <div class="day-slots">
          <div class="time-slot slot-available">8:00 - 9:00 AM</div>
          <div class="time-slot slot-available">9:00 - 10:00 AM</div>
          <div class="time-slot slot-full">3:00 - 4:00 PM</div>
          <div class="time-slot slot-limited">4:00 - 5:00 PM</div>
        </div>
      </div>
      <div class="day-column reveal reveal-d2">
        <div class="day-header">Friday</div>
        <div class="day-slots">
          <div class="time-slot slot-available">8:00 - 9:00 AM</div>
          <div class="time-slot slot-available">9:00 - 10:00 AM</div>
          <div class="time-slot slot-available">3:00 - 4:00 PM</div>
          <div class="time-slot slot-limited">4:00 - 5:00 PM</div>
        </div>
      </div>
    </div>

    <div style="display:flex; gap:20px; justify-content:center; margin-top:24px; flex-wrap:wrap;" class="reveal">
      <div style="display:flex; align-items:center; gap:8px; font-size:13px; color:var(--text-muted);">
        <span style="width:14px; height:14px; border-radius:4px; background:#e8f5e9; border:1px solid #c8e6c9; display:inline-block;"></span> Available
      </div>
      <div style="display:flex; align-items:center; gap:8px; font-size:13px; color:var(--text-muted);">
        <span style="width:14px; height:14px; border-radius:4px; background:#fff3e0; border:1px solid #ffe0b2; display:inline-block;"></span> Limited Spots
      </div>
      <div style="display:flex; align-items:center; gap:8px; font-size:13px; color:var(--text-muted);">
        <span style="width:14px; height:14px; border-radius:4px; background:#fce4ec; border:1px solid #f8bbd0; display:inline-block;"></span> Full
      </div>
    </div>
  </div>
</section>


<!-- SECTION 6: HOW TO ENROLL -->
<section class="enroll-section">
  <div style="text-align:center; margin-bottom:10px;" class="reveal">
    <div class="section-label">Get Started</div>
    <h2 class="section-title">How to Enroll</h2>
    <p style="color:var(--text-muted); font-size:16px; max-width:600px; margin:10px auto 0;">Four simple steps to begin your child's tutoring journey</p>
  </div>

  <div class="steps-timeline">
    <div class="step-item reveal reveal-d1">
      <div class="step-circle">&#x1F4DE;</div>
      <div class="step-number">Step 1</div>
      <h4>Contact Us</h4>
      <p>Call, email, or WhatsApp us to express your interest in tutoring services</p>
    </div>
    <div class="step-item reveal reveal-d2">
      <div class="step-circle">&#x1F4CB;</div>
      <div class="step-number">Step 2</div>
      <h4>Assessment</h4>
      <p>We evaluate your child's current level and identify areas for improvement</p>
    </div>
    <div class="step-item reveal reveal-d3">
      <div class="step-circle">&#x1F91D;</div>
      <div class="step-number">Step 3</div>
      <h4>Match with Tutor</h4>
      <p>We pair your child with the best-suited tutor for their learning style</p>
    </div>
    <div class="step-item reveal reveal-d1">
      <div class="step-circle">&#x1F680;</div>
      <div class="step-number">Step 4</div>
      <h4>Begin Sessions</h4>
      <p>Start tutoring sessions and watch your child's confidence grow</p>
    </div>
  </div>
</section>


<!-- SECTION 7: CTA BANNER -->
<section class="cta">
  <div class="cta-label">Take the Next Step</div>
  <h2 class="cta-title">Ready to Boost Your Child's Learning?</h2>
  <div class="cta-actions">
    <a href="/contact/" class="btn btn-white">Contact Us</a>
    <a href="/contact/" class="btn btn-outline-light">Schedule Assessment</a>
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
