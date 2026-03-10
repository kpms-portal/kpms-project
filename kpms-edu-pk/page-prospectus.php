<?php
/*
Template Name: KPMS - View Prospectus
*/
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>School Prospectus – KPMS | Kamal Public Middle School Abbottabad</title>
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

/* ===== SECTION LABELS ===== */
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

/* ===== INNER PAGE STYLES ===== */
.page-hero {
  background: linear-gradient(160deg, rgba(0,24,64,0.88) 0%, rgba(0,48,135,0.7) 50%, rgba(0,24,64,0.82) 100%),
    url('https://images.unsplash.com/photo-1580582932707-520aed937b7b?w=1920&q=85') center/cover;
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

/* ===== PRINCIPAL MESSAGE ===== */
.principal-section {
  display: grid;
  grid-template-columns: 340px 1fr;
  gap: 50px;
  align-items: start;
  margin-bottom: 80px;
}
.principal-photo {
  border-radius: 16px;
  overflow: hidden;
  box-shadow: 0 20px 60px rgba(0,0,0,0.12);
}
.principal-photo img {
  width: 100%; height: 480px;
  object-fit: cover; display: block;
}
.principal-message h2 {
  font-family: 'Playfair Display', serif;
  font-size: 32px; font-weight: 500;
  color: var(--text); margin-bottom: 24px;
}
.principal-quote {
  border-left: 4px solid var(--blue);
  padding-left: 28px;
  margin: 24px 0;
}
.principal-quote p {
  font-style: italic;
  font-size: 17px;
  line-height: 1.9;
  color: var(--text-muted);
}
.principal-signature {
  font-size: 15px;
  font-weight: 600;
  color: var(--text);
  margin-top: 28px;
  padding-top: 20px;
  border-top: 2px solid var(--ice);
}
.principal-signature span {
  display: block;
  font-size: 13px;
  font-weight: 400;
  color: var(--text-muted);
  margin-top: 4px;
}

/* ===== KEY FACTS GRID ===== */
.facts-section {
  background: var(--cream-warm);
  padding: 80px 60px;
  margin: 0 -60px;
  width: calc(100% + 120px);
}
.facts-inner {
  max-width: 1100px;
  margin: 0 auto;
}
.facts-grid {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 20px;
  margin-top: 40px;
}
.fact-card {
  background: var(--white);
  border: 2px solid var(--ice);
  border-radius: 16px;
  padding: 28px 20px;
  text-align: center;
  transition: all 0.3s;
}
.fact-card:hover {
  border-color: var(--blue-light);
  box-shadow: 0 12px 40px rgba(0,48,135,0.08);
  transform: translateY(-4px);
}
.fact-icon {
  font-size: 32px;
  margin-bottom: 12px;
  display: block;
}
.fact-value {
  font-family: 'Playfair Display', serif;
  font-size: 22px;
  font-weight: 700;
  color: var(--blue-deep);
  margin-bottom: 4px;
}
.fact-label {
  font-size: 13px;
  color: var(--text-muted);
  font-weight: 500;
}

/* ===== PROGRAM CARDS ===== */
.programs-section {
  padding: 80px 0;
}
.programs-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 28px;
  margin-top: 40px;
}
.program-card {
  background: var(--white);
  border: 2px solid var(--ice);
  border-radius: 16px;
  overflow: hidden;
  transition: all 0.4s ease;
}
.program-card:hover {
  transform: translateY(-6px);
  box-shadow: 0 16px 48px rgba(0,48,135,0.1);
  border-color: var(--blue-light);
}
.program-card-img {
  width: 100%;
  aspect-ratio: 16/10;
  overflow: hidden;
}
.program-card-img img {
  width: 100%; height: 100%;
  object-fit: cover;
  transition: transform 0.6s ease;
}
.program-card:hover .program-card-img img {
  transform: scale(1.05);
}
.program-card-body {
  padding: 28px;
}
.program-card-body h3 {
  font-family: 'Playfair Display', serif;
  font-size: 20px; font-weight: 600;
  color: var(--text); margin: 0 0 4px;
}
.program-card-body .program-ages {
  font-size: 13px; font-weight: 600;
  color: var(--blue);
  text-transform: uppercase;
  letter-spacing: 1px;
  margin-bottom: 12px;
}
.program-card-body p {
  font-size: 14px;
  color: var(--text-muted);
  line-height: 1.7;
  margin-bottom: 16px;
}
.program-link {
  font-size: 14px; font-weight: 700;
  color: var(--blue);
  text-decoration: none;
  display: inline-flex;
  align-items: center; gap: 6px;
  transition: gap 0.3s;
}
.program-link:hover { gap: 12px; }

/* ===== FACILITIES GRID ===== */
.facilities-section {
  background: var(--cream-warm);
  padding: 80px 60px;
  margin: 0 -60px;
  width: calc(100% + 120px);
}
.facilities-inner {
  max-width: 1100px;
  margin: 0 auto;
}
.facilities-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 20px;
  margin-top: 40px;
}
.facility-card {
  border-radius: 16px;
  overflow: hidden;
  position: relative;
  aspect-ratio: 4/3;
  box-shadow: 0 8px 30px rgba(0,0,0,0.1);
  transition: all 0.4s ease;
}
.facility-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 16px 48px rgba(0,0,0,0.15);
}
.facility-card img {
  width: 100%; height: 100%;
  object-fit: cover;
  transition: transform 0.6s ease;
}
.facility-card:hover img {
  transform: scale(1.05);
}
.facility-label {
  position: absolute;
  bottom: 14px; left: 14px;
  background: rgba(28,42,58,0.85);
  backdrop-filter: blur(8px);
  padding: 8px 16px;
  border-radius: 8px;
  font-size: 13px; font-weight: 600;
  color: white;
  letter-spacing: 0.3px;
}

/* ===== FEE TABLE ===== */
.fee-section {
  padding: 80px 0;
}
.fee-table {
  width: 100%;
  border-collapse: collapse;
  border-radius: 16px;
  overflow: hidden;
  box-shadow: 0 8px 30px rgba(0,0,0,0.08);
  margin-top: 40px;
}
.fee-table thead th {
  background: var(--gold);
  color: var(--navy-deep);
  font-size: 14px;
  font-weight: 700;
  letter-spacing: 0.5px;
  text-transform: uppercase;
  padding: 18px 28px;
  text-align: left;
}
.fee-table tbody td {
  padding: 18px 28px;
  font-size: 15px;
  color: var(--text);
  border-bottom: 1px solid var(--ice);
}
.fee-table tbody tr:nth-child(even) {
  background: var(--cream);
}
.fee-table tbody tr:hover {
  background: var(--ice);
}
.fee-table tbody td:last-child {
  font-weight: 700;
  color: var(--blue-deep);
}
.fee-note {
  font-size: 14px;
  color: var(--text-muted);
  margin-top: 20px;
  font-style: italic;
  padding-left: 16px;
  border-left: 3px solid var(--gold);
}

/* ===== ACADEMIC CALENDAR TIMELINE ===== */
.calendar-section {
  background: var(--cream-warm);
  padding: 80px 60px;
  margin: 0 -60px;
  width: calc(100% + 120px);
}
.calendar-inner {
  max-width: 1100px;
  margin: 0 auto;
}
.timeline {
  margin-top: 40px;
  position: relative;
}
.timeline::before {
  content: '';
  position: absolute;
  left: 24px;
  top: 0; bottom: 0;
  width: 3px;
  background: var(--ice);
  border-radius: 3px;
}
.timeline-item {
  display: flex;
  gap: 24px;
  align-items: flex-start;
  margin-bottom: 20px;
  position: relative;
}
.timeline-dot {
  width: 50px; height: 50px;
  background: var(--blue);
  border-radius: 50%;
  display: flex; align-items: center; justify-content: center;
  flex-shrink: 0;
  position: relative;
  z-index: 1;
  box-shadow: 0 4px 16px rgba(0,48,135,0.2);
}
.timeline-dot span {
  font-size: 10px;
  font-weight: 700;
  color: var(--white);
  text-transform: uppercase;
  letter-spacing: 0.5px;
}
.timeline-content {
  background: var(--white);
  border: 2px solid var(--ice);
  border-radius: 12px;
  padding: 20px 24px;
  flex: 1;
  transition: all 0.3s;
}
.timeline-content:hover {
  border-color: var(--blue-light);
  box-shadow: 0 8px 24px rgba(0,48,135,0.06);
  transform: translateX(4px);
}
.timeline-content h4 {
  font-size: 16px;
  font-weight: 700;
  color: var(--text);
  margin: 0 0 4px;
}
.timeline-content p {
  font-size: 14px;
  color: var(--text-muted);
  margin: 0;
  line-height: 1.5;
}

/* ===== DOWNLOAD PROSPECTUS ===== */
.download-section {
  padding: 80px 0;
  text-align: center;
}
.download-card {
  max-width: 560px;
  margin: 40px auto 0;
  background: var(--white);
  border: 3px solid var(--blue);
  border-radius: 20px;
  padding: 48px 40px;
  box-shadow: 0 20px 60px rgba(0,48,135,0.1);
  transition: all 0.3s;
}
.download-card:hover {
  transform: translateY(-4px);
  box-shadow: 0 28px 70px rgba(0,48,135,0.15);
}
.download-icon {
  font-size: 56px;
  margin-bottom: 20px;
  display: block;
}
.download-card h3 {
  font-family: 'Playfair Display', serif;
  font-size: 24px; font-weight: 600;
  color: var(--text);
  margin-bottom: 12px;
}
.download-card p {
  font-size: 14px;
  color: var(--text-muted);
  margin-bottom: 28px;
}
.download-btn {
  display: inline-block;
  padding: 16px 44px;
  background: var(--blue);
  color: var(--white);
  border-radius: 10px;
  font-size: 15px;
  font-weight: 700;
  text-decoration: none;
  letter-spacing: 0.5px;
  transition: all 0.3s;
}
.download-btn:hover {
  background: var(--blue-deep);
  transform: translateY(-2px);
  box-shadow: 0 8px 24px rgba(0,48,135,0.3);
}
.download-meta {
  font-size: 12px;
  color: var(--text-muted);
  margin-top: 16px;
}

/* ===== VIRTUAL TOUR ===== */
.video-section {
  padding: 100px 60px;
  background: var(--navy);
  text-align: center;
  position: relative;
  overflow: hidden;
  margin: 0 -60px;
  width: calc(100% + 120px);
}
.video-section::before {
  content: '';
  position: absolute; inset: 0;
  background: radial-gradient(ellipse at center, rgba(0,48,135,0.15) 0%, transparent 60%);
}
.video-inner {
  max-width: 900px; margin: 0 auto;
  position: relative; z-index: 1;
}
.video-placeholder {
  width: 100%;
  aspect-ratio: 16/9;
  border-radius: 16px;
  overflow: hidden;
  position: relative;
  margin-top: 30px;
  box-shadow: 0 30px 80px rgba(0,0,0,0.4);
  cursor: pointer;
}
.video-placeholder img {
  width: 100%; height: 100%; object-fit: cover;
}
.video-play {
  position: absolute; inset: 0;
  display: flex; align-items: center; justify-content: center;
  background: rgba(0,0,0,0.2);
  transition: background 0.3s;
}
.video-placeholder:hover .video-play { background: rgba(0,0,0,0.35); }
.play-btn {
  width: 80px; height: 80px;
  background: var(--gold);
  border-radius: 50%;
  display: flex; align-items: center; justify-content: center;
  font-size: 28px;
  box-shadow: 0 8px 32px rgba(245,166,35,0.4);
  transition: all 0.3s;
}
.video-placeholder:hover .play-btn {
  transform: scale(1.1);
  box-shadow: 0 12px 40px rgba(245,166,35,0.5);
}

/* ===== CTA BANNER ===== */
.cta {
  padding: 70px 60px;
  background: var(--blue-deep);
  text-align: center;
  position: relative;
  overflow: hidden;
  margin: 0 -60px;
  width: calc(100% + 120px);
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
  .page-content { padding-left: 30px !important; padding-right: 30px !important; }
  .principal-section { grid-template-columns: 280px 1fr; gap: 30px; }
  .facts-grid { grid-template-columns: repeat(2, 1fr); }
  .programs-grid { grid-template-columns: repeat(2, 1fr); }
  .facilities-grid { grid-template-columns: repeat(2, 1fr); }
  .footer-grid { grid-template-columns: 1fr 1fr; }
}

@media (max-width: 768px) {
  .topbar { display: none; }
  .nav-menu { display: none; }
  .nav-search-btn { display: none; }
  .mobile-toggle { display: block; }
  .nav-inner { padding: 0 20px !important; height: 64px; }
  .page-hero { padding: 120px 20px 60px; }
  .page-content { padding: 40px 20px !important; }
  .principal-section { grid-template-columns: 1fr; gap: 30px; }
  .principal-photo img { height: 360px; }
  .facts-grid { grid-template-columns: repeat(2, 1fr); gap: 12px; }
  .fact-card { padding: 20px 14px; }
  .programs-grid { grid-template-columns: 1fr; max-width: 420px; margin-left: auto; margin-right: auto; }
  .facilities-grid { grid-template-columns: 1fr 1fr; }
  .fee-table thead th,
  .fee-table tbody td { padding: 14px 16px; font-size: 14px; }
  .timeline-dot { width: 40px; height: 40px; }
  .timeline-dot span { font-size: 9px; }
  .timeline::before { left: 19px; }
  .footer-grid { grid-template-columns: 1fr; gap: 32px; }
  .footer-bottom { flex-direction: column; text-align: center; }
  .facts-section,
  .facilities-section,
  .calendar-section,
  .video-section,
  .cta { padding-left: 20px !important; padding-right: 20px !important; }
  .download-card { padding: 36px 24px; }
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
    <a href="tel:+923135914700">📞 +92 313 5914700</a>
    <a href="mailto:admissions@kpms.edu.pk">✉ admissions@kpms.edu.pk</a>
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
<section class="page-hero" id="main-content" style="background: linear-gradient(160deg, rgba(0,24,64,0.88) 0%, rgba(0,48,135,0.7) 50%, rgba(0,24,64,0.82) 100%), url('https://images.unsplash.com/photo-1580582932707-520aed937b7b?w=1920&q=85') center/cover;">
  <div class="page-hero-label">Admissions</div>
  <h1 class="page-hero-title">School Prospectus</h1>
  <p class="page-hero-subtitle">Discover what makes KPMS the premier choice for your child's education in Abbottabad</p>
  <div class="page-breadcrumb"><a href="/">Home</a> / <a href="/apply-online/">Admissions</a> / Prospectus</div>
</section>

<div class="page-content">

  <!-- 1. WELCOME MESSAGE FROM PRINCIPAL -->
  <div class="principal-section reveal">
    <div class="principal-photo">
      <img src="https://images.unsplash.com/photo-1560250097-0b93528c311a?w=600&q=80" alt="Kamal Ahmed Khan, Founder & Principal of KPMS">
    </div>
    <div class="principal-message">
      <div class="section-label">Welcome</div>
      <h2>A Message from Our Founder</h2>
      <div class="principal-quote">
        <p>"When I founded Kamal Public Middle School in 1985, my vision was simple yet profound: to create a nurturing environment where every child in Abbottabad could receive a world-class education rooted in our rich cultural values. Over the decades, we have remained steadfast in this mission."</p>
        <p>"At KPMS, we believe that education is not merely the transfer of knowledge, but the ignition of a flame that burns with curiosity, discipline, and compassion. Our teachers are not just instructors - they are mentors who shape the character and future of each student entrusted to our care."</p>
        <p>"I invite you to explore our prospectus and discover how KPMS can be the foundation for your child's lifelong journey of learning and achievement. We look forward to welcoming your family into ours."</p>
      </div>
      <div class="principal-signature">
        Kamal Ahmed Khan
        <span>Founder &amp; Principal, M.Ed, University of Peshawar</span>
      </div>
    </div>
  </div>

  <!-- 2. SCHOOL OVERVIEW - KEY FACTS -->
  <div class="facts-section reveal">
    <div class="facts-inner">
      <div style="text-align:center;">
        <div class="section-label">At a Glance</div>
        <div class="section-title">School Overview</div>
      </div>
      <div class="facts-grid">
        <div class="fact-card">
          <span class="fact-icon">🏫</span>
          <div class="fact-value">1985</div>
          <div class="fact-label">Founded</div>
        </div>
        <div class="fact-card">
          <span class="fact-icon">📍</span>
          <div class="fact-value">Abbottabad</div>
          <div class="fact-label">Sheikh ul Bandi, KPK</div>
        </div>
        <div class="fact-card">
          <span class="fact-icon">📚</span>
          <div class="fact-value">Pre-K – 5</div>
          <div class="fact-label">Grades Offered</div>
        </div>
        <div class="fact-card">
          <span class="fact-icon">👨‍🎓</span>
          <div class="fact-value">120+</div>
          <div class="fact-label">Students Enrolled</div>
        </div>
        <div class="fact-card">
          <span class="fact-icon">👩‍🏫</span>
          <div class="fact-value">12:1</div>
          <div class="fact-label">Student-Teacher Ratio</div>
        </div>
        <div class="fact-card">
          <span class="fact-icon">🌳</span>
          <div class="fact-value">2 Acres</div>
          <div class="fact-label">Campus Size</div>
        </div>
        <div class="fact-card">
          <span class="fact-icon">🏅</span>
          <div class="fact-value">BISE</div>
          <div class="fact-label">Accreditation – Abbottabad</div>
        </div>
        <div class="fact-card">
          <span class="fact-icon">🗣️</span>
          <div class="fact-value">3 Languages</div>
          <div class="fact-label">English, Urdu, Pashto</div>
        </div>
      </div>
    </div>
  </div>

  <!-- 3. PROGRAMS OFFERED -->
  <div class="programs-section reveal">
    <div style="text-align:center;">
      <div class="section-label">Our Programs</div>
      <div class="section-title">Programs Offered</div>
      <p class="section-subtitle">Comprehensive education pathways tailored to every stage of early development</p>
    </div>
    <div class="programs-grid">
      <div class="program-card reveal reveal-d1">
        <div class="program-card-img">
          <img src="https://images.unsplash.com/photo-1587654780291-39c9404d7dd0?w=600&q=80" alt="Montessori Program at KPMS">
        </div>
        <div class="program-card-body">
          <div class="program-ages">Ages 3–6</div>
          <h3>Montessori Program</h3>
          <p>Our Montessori program nurtures natural curiosity through hands-on learning, self-directed activities, and a carefully prepared environment that fosters independence and a love for learning.</p>
          <a href="/montessori/" class="program-link">Learn More →</a>
        </div>
      </div>
      <div class="program-card reveal reveal-d2">
        <div class="program-card-img">
          <img src="https://images.unsplash.com/photo-1503676260728-1c00da094a0b?w=600&q=80" alt="Primary Education at KPMS">
        </div>
        <div class="program-card-body">
          <div class="program-ages">Grades 1–5</div>
          <h3>Primary Education</h3>
          <p>A rigorous academic curriculum aligned with national standards, combining English-medium instruction with strong foundations in mathematics, science, social studies, and Islamic studies.</p>
          <a href="/primary-education/" class="program-link">Learn More →</a>
        </div>
      </div>
      <div class="program-card reveal reveal-d3">
        <div class="program-card-img">
          <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?w=600&q=80" alt="Tutoring Services at KPMS">
        </div>
        <div class="program-card-body">
          <div class="program-ages">All Levels</div>
          <h3>Tutoring Services</h3>
          <p>Personalized one-on-one and small-group tutoring sessions designed to support students who need additional help or want to accelerate their learning in specific subjects.</p>
          <a href="/tuition/" class="program-link">Learn More →</a>
        </div>
      </div>
    </div>
  </div>

  <!-- 4. FACILITIES -->
  <div class="facilities-section reveal">
    <div class="facilities-inner">
      <div style="text-align:center;">
        <div class="section-label">Campus Life</div>
        <div class="section-title">Our Facilities</div>
        <p class="section-subtitle">A modern campus designed to inspire learning and growth</p>
      </div>
      <div class="facilities-grid">
        <div class="facility-card reveal reveal-d1">
          <img src="https://images.unsplash.com/photo-1580582932707-520aed937b7b?w=600&q=80" alt="Modern Classrooms at KPMS">
          <div class="facility-label">Modern Classrooms</div>
        </div>
        <div class="facility-card reveal reveal-d2">
          <img src="https://images.unsplash.com/photo-1521587760476-6c12a4b040da?w=600&q=80" alt="Library & Reading Room at KPMS">
          <div class="facility-label">Library &amp; Reading Room</div>
        </div>
        <div class="facility-card reveal reveal-d3">
          <img src="https://images.unsplash.com/photo-1532094349884-543bc11b234d?w=600&q=80" alt="Science Laboratory at KPMS">
          <div class="facility-label">Science Laboratory</div>
        </div>
        <div class="facility-card reveal reveal-d1">
          <img src="https://images.unsplash.com/photo-1516321497487-e288fb19713f?w=600&q=80" alt="Computer Lab at KPMS">
          <div class="facility-label">Computer Lab</div>
        </div>
        <div class="facility-card reveal reveal-d2">
          <img src="https://images.unsplash.com/photo-1551966775-a4ddc8df052b?w=600&q=80" alt="Playground & Sports Area at KPMS">
          <div class="facility-label">Playground &amp; Sports Area</div>
        </div>
        <div class="facility-card reveal reveal-d3">
          <img src="https://images.unsplash.com/photo-1540575467063-178a50c2df87?w=600&q=80" alt="Assembly Hall at KPMS">
          <div class="facility-label">Assembly Hall</div>
        </div>
      </div>
    </div>
  </div>

  <!-- 5. ADMISSIONS INFO -->
  <div class="fee-section reveal">
    <div style="text-align:center;">
      <div class="section-label">Admissions</div>
      <div class="section-title">Affordable Quality Education</div>
      <p class="section-subtitle">KPMS is committed to providing accessible, high-quality education for every family in Abbottabad</p>
    </div>
    <div style="max-width:700px; margin:30px auto 0; text-align:center;">
      <p style="font-size:16px; line-height:1.8; color:var(--text-muted); margin-bottom:20px;">For detailed information about tuition, financial assistance, and sibling discounts, please contact our admissions office. We offer flexible options to make quality education accessible to all families.</p>
      <a href="/contact/" class="btn btn-blue">Contact Admissions</a>
    </div>
  </div>

  <!-- 6. ACADEMIC CALENDAR HIGHLIGHTS -->
  <div class="calendar-section reveal">
    <div class="calendar-inner">
      <div style="text-align:center;">
        <div class="section-label">Important Dates</div>
        <div class="section-title">Academic Calendar Highlights</div>
      </div>
      <div class="timeline">
        <div class="timeline-item reveal reveal-d1">
          <div class="timeline-dot"><span>MAR</span></div>
          <div class="timeline-content">
            <h4>Admissions Open</h4>
            <p>Application period begins for the upcoming academic year. Submit forms online or at the school office.</p>
          </div>
        </div>
        <div class="timeline-item reveal reveal-d2">
          <div class="timeline-dot"><span>APR</span></div>
          <div class="timeline-content">
            <h4>New Session Begins</h4>
            <p>Welcome Day ceremony and orientation for new students and parents. Classes commence.</p>
          </div>
        </div>
        <div class="timeline-item reveal reveal-d1">
          <div class="timeline-dot"><span>JUN</span></div>
          <div class="timeline-content">
            <h4>Summer Break</h4>
            <p>June through July. Optional summer enrichment programs available for interested students.</p>
          </div>
        </div>
        <div class="timeline-item reveal reveal-d2">
          <div class="timeline-dot"><span>AUG</span></div>
          <div class="timeline-content">
            <h4>Second Term</h4>
            <p>Students return from summer break. Second term classes and extracurricular activities begin.</p>
          </div>
        </div>
        <div class="timeline-item reveal reveal-d1">
          <div class="timeline-dot"><span>OCT</span></div>
          <div class="timeline-content">
            <h4>Mid-Year Exams</h4>
            <p>Mid-year assessments across all grades. Parent-teacher conferences to follow.</p>
          </div>
        </div>
        <div class="timeline-item reveal reveal-d2">
          <div class="timeline-dot"><span>DEC</span></div>
          <div class="timeline-content">
            <h4>Annual Day &amp; Prize Distribution</h4>
            <p>Celebration of student achievements with performances, awards, and community gathering.</p>
          </div>
        </div>
        <div class="timeline-item reveal reveal-d1">
          <div class="timeline-dot"><span>JAN</span></div>
          <div class="timeline-content">
            <h4>Final Exams</h4>
            <p>Comprehensive year-end examinations for all grades. Preparation workshops provided.</p>
          </div>
        </div>
        <div class="timeline-item reveal reveal-d2">
          <div class="timeline-dot"><span>FEB</span></div>
          <div class="timeline-content">
            <h4>Results &amp; Promotions</h4>
            <p>Report cards issued. Promotion ceremonies and academic counseling for the next session.</p>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- 7. DOWNLOAD PROSPECTUS -->
  <div class="download-section reveal">
    <div class="section-label">Get the Full Details</div>
    <div class="section-title">Download Our Prospectus</div>
    <div class="download-card">
      <span class="download-icon">📄</span>
      <h3>Download Complete Prospectus (PDF)</h3>
      <p>Everything you need to know about KPMS - our programs, curriculum, facilities, and admissions process in one comprehensive document.</p>
      <a href="#" class="download-btn">Download Prospectus PDF</a>
      <div class="download-meta">2025-2026 Academic Year | 24 Pages | 3.2 MB</div>
    </div>
  </div>

  <!-- 8. VIRTUAL TOUR PLACEHOLDER -->
  <div class="video-section">
    <div class="video-inner">
      <div class="section-label" style="color:var(--gold-light);">Explore Our Campus</div>
      <div class="section-title" style="color:var(--white); margin-bottom:10px;">Take a Virtual Tour</div>
      <p style="color:rgba(255,255,255,0.6); font-size:17px; max-width:600px; margin:0 auto;">Experience the KPMS campus from the comfort of your home. See our classrooms, facilities, and the vibrant community that awaits your child.</p>
      <div class="video-placeholder">
        <img src="https://images.unsplash.com/photo-1580582932707-520aed937b7b?w=1200&q=80" alt="Virtual tour of KPMS campus">
        <div class="video-play">
          <div class="play-btn">▶</div>
        </div>
      </div>
    </div>
  </div>

  <!-- 9. CTA -->
  <div class="cta">
    <div class="cta-label">Enroll Today</div>
    <h2 class="cta-title">Ready to Join the KPMS Family?</h2>
    <div class="cta-actions">
      <a href="/apply-online/" class="btn btn-gold">Apply Online</a>
      <a href="/schedule-tour/" class="btn btn-outline-light">Schedule a Visit</a>
    </div>
  </div>

</div>

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
      <div class="footer-copy">© 1985–2026 Kamal Public Middle School Abbottabad. All Rights Reserved.</div>
      <div class="footer-legal">
        <a href="/">Privacy Policy</a>
        <a href="/">Terms</a>
        <a href="/">Accessibility</a>
        <a href="/">Anti‑Discrimination</a>
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