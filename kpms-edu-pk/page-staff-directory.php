<?php
/*
Template Name: KPMS - Staff Directory
*/
?>
<?php

/*
Template Name: KPMS New Homepage
*/

// This is a standalone page template — it does NOT load the parent theme header/footer.
// The entire page is self-contained in the HTML below.
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>KPMS – Kamal Public Middle School | Abbottabad</title>
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

/* ===== QUICK LINKS BAR ===== */
.quick-links {
  margin-top: -36px; position: relative; z-index: 10;
  max-width: 1020px; margin-left: auto; margin-right: auto;
  padding: 0 30px;
}
.quick-links-grid {
  display: grid; grid-template-columns: repeat(4, 1fr); gap: 12px;
}
.quick-link-item {
  background: var(--white); border-radius: 12px;
  padding: 16px 14px; display: flex; align-items: center; gap: 12px;
  box-shadow: 0 8px 30px rgba(0,0,0,0.1);
  text-decoration: none; transition: all 0.3s cubic-bezier(0.16,1,0.3,1);
}
.quick-link-item:hover { transform: translateY(-4px); box-shadow: 0 14px 40px rgba(0,0,0,0.15); }
.quick-link-icon {
  width: 42px; height: 42px; border-radius: 10px;
  display: flex; align-items: center; justify-content: center;
  font-size: 20px; flex-shrink: 0;
}
.ql-enroll { background: #e8f5e9; }
.ql-cal { background: #fff3e0; }
.ql-lunch { background: #fce4ec; }
.ql-portal { background: #e3f2fd; }
.quick-link-text { font-size: 13px; font-weight: 700; color: var(--text); line-height: 1.2; }
.quick-link-sub { font-size: 10px; font-weight: 400; color: var(--text-muted); display: block; margin-top: 2px; }

/* ===== FEATURED EVENTS ===== */
.events-section { padding: 80px 60px 40px; max-width: 1300px; margin: 0 auto; }
.events-header { display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 36px; }
.events-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 18px; }
.event-card {
  border: 2px solid var(--ice); border-radius: 14px;
  padding: 22px; display: flex; gap: 16px; align-items: flex-start;
  transition: all 0.3s; text-decoration: none;
}
.event-card:hover {
  border-color: var(--blue-light); background: var(--ice);
  transform: translateY(-3px); box-shadow: 0 8px 24px rgba(0,48,135,0.08);
}
.event-date-box {
  min-width: 54px; text-align: center;
  background: var(--blue); border-radius: 10px;
  padding: 10px 8px; flex-shrink: 0;
}
.event-month {
  font-size: 10px; font-weight: 700; text-transform: uppercase;
  letter-spacing: 1px; color: var(--gold-light);
}
.event-day {
  font-family: 'Playfair Display', serif;
  font-size: 24px; font-weight: 700; color: var(--white); line-height: 1.1;
}
.event-info h4 { font-size: 14px; font-weight: 700; color: var(--text); margin-bottom: 3px; line-height: 1.3; }
.event-info p { font-size: 12px; color: var(--text-muted); line-height: 1.5; }
.event-time { font-size: 11px; font-weight: 600; color: var(--blue); margin-top: 5px; }
.see-all-link {
  font-size: 13px; font-weight: 700; color: var(--blue);
  text-decoration: none; display: flex; align-items: center; gap: 6px;
  transition: gap 0.3s;
}
.see-all-link:hover { gap: 10px; }

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

/* ===== THREE FEATURE CARDS (Nobles style) ===== */
.features {
  padding: 0 60px;
  margin-top: 40px;
  position: relative; z-index: 10;
  max-width: 1300px; margin-left: auto; margin-right: auto;
}
.features-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 24px;
}
.feature-card {
  position: relative;
  border-radius: 16px;
  overflow: hidden;
  aspect-ratio: 3/4;
  cursor: pointer;
  box-shadow: 0 20px 60px rgba(0,0,0,0.15);
  transition: transform 0.5s cubic-bezier(0.16,1,0.3,1), box-shadow 0.5s ease;
}
.feature-card:hover {
  transform: translateY(-8px);
  box-shadow: 0 30px 80px rgba(0,0,0,0.2);
}
.feature-card img {
  position: absolute; inset: 0;
  width: 100%; height: 100%; object-fit: cover;
  transition: transform 0.8s cubic-bezier(0.16,1,0.3,1);
}
.feature-card:hover img { transform: scale(1.06); }
.feature-overlay {
  position: absolute; inset: 0;
  background: linear-gradient(to top, rgba(0,15,43,0.92) 0%, rgba(0,15,43,0.2) 50%, transparent 65%);
}
.feature-content {
  position: absolute; bottom: 0; left: 0; right: 0;
  padding: 32px;
  z-index: 2;
}
.feature-tag {
  font-size: 11px; font-weight: 700;
  letter-spacing: 2px; text-transform: uppercase;
  color: var(--gold-light);
  margin-bottom: 8px;
}
.feature-title {
  font-family: 'Playfair Display', serif;
  font-size: 22px; font-weight: 500;
  color: var(--white);
  line-height: 1.3;
}
.feature-arrow {
  display: inline-flex; align-items: center; gap: 6px;
  margin-top: 14px;
  font-size: 13px; font-weight: 700;
  color: var(--gold-light);
  letter-spacing: 0.5px;
  transition: gap 0.3s;
}
.feature-card:hover .feature-arrow { gap: 12px; }

/* ===== STATS ===== */
.stats {
  padding: 100px 60px 90px;
  background: var(--cream-warm);
  position: relative;
}
.stats-top {
  text-align: center; margin-bottom: 60px;
}
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
.stats-carousel {
  max-width: 1200px; margin: 0 auto;
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

/* ===== VIDEO TOUR ===== */
.video-section {
  padding: 100px 60px;
  background: var(--navy);
  text-align: center;
  position: relative;
  overflow: hidden;
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
  margin-top: -60px;
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

/* ===== PHOTO GALLERY / AROUND KPMS ===== */
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

/* ===== NEWS ===== */
.news {
  padding: 100px 60px;
  background: var(--cream-warm);
}
.news-inner { max-width: 1200px; margin: 0 auto; }
.news-header {
  display: flex; justify-content: space-between; align-items: flex-end;
  margin-bottom: 50px; flex-wrap: wrap; gap: 20px;
}
.news-link {
  font-size: 14px; font-weight: 700;
  color: var(--blue);
  text-decoration: none;
  letter-spacing: 0.5px; text-transform: uppercase;
  display: flex; align-items: center; gap: 6px;
  transition: gap 0.3s;
}
.news-link:hover { gap: 12px; }
.news-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 28px;
}
.news-card {
  background: var(--white);
  border-radius: 16px;
  overflow: hidden;
  transition: all 0.4s ease;
  border: 1px solid rgba(0,0,0,0.04);
}
.news-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 16px 48px rgba(0,0,0,0.08);
}
.news-img {
  width: 100%; aspect-ratio: 4/3; overflow: hidden;
}
.news-img img {
  width: 100%; height: 100%; object-fit: cover;
  transition: transform 0.6s ease;
}
.news-card:hover .news-img img { transform: scale(1.05); }
.news-body { padding: 24px; }
.news-tag {
  font-size: 11px; font-weight: 700;
  color: var(--blue);
  letter-spacing: 1.5px; text-transform: uppercase;
  margin-bottom: 8px;
}
.news-title {
  font-family: 'Playfair Display', serif;
  font-size: 19px; font-weight: 500;
  color: var(--text);
  line-height: 1.4;
  margin-bottom: 10px;
}
.news-date { font-size: 13px; color: var(--text-muted); }

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

/* ===== RESPONSIVE ===== */
@media (max-width: 1024px) {
  .nav-inner, .features, section, .events-section { padding-left: 30px !important; padding-right: 30px !important; }
  .stats-carousel { grid-template-columns: repeat(2, 1fr); }
  .features-grid { gap: 16px; }
  .gallery-grid { grid-template-rows: 200px 200px; }
  .news-grid { grid-template-columns: repeat(2, 1fr); }
  .footer-grid { grid-template-columns: 1fr 1fr; }
  .events-grid { grid-template-columns: repeat(2, 1fr); }
  .events-grid .event-card:nth-child(3) { grid-column: 1 / -1; max-width: 400px; }
  .quick-links-grid { grid-template-columns: repeat(2, 1fr); gap: 10px; }
  .quick-links { max-width: 600px; }
}

@media (max-width: 768px) {
  .topbar { display: none; }
  .nav-menu { display: none; }
  .nav-search-btn { display: none; }
  .mobile-toggle { display: block; }
  .nav-inner { padding: 0 20px !important; height: 64px; }
  .features { padding: 0 20px !important; margin-top: 30px; }
  .features-grid { grid-template-columns: 1fr; max-width: 400px; margin: 0 auto; }
  .feature-card { aspect-ratio: 4/3; }
  section, .events-section { padding-left: 20px !important; padding-right: 20px !important; }
  .stats-carousel { grid-template-columns: repeat(2, 1fr); gap: 12px; }
  .stat-card { padding: 24px 16px; }
  .stat-number { font-size: 36px; }
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
  .news-grid { grid-template-columns: 1fr; }
  .footer-grid { grid-template-columns: 1fr; gap: 32px; }
  .footer-bottom { flex-direction: column; text-align: center; }
  .hero-btns { flex-direction: column; align-items: center; }
  .quick-links { padding: 0 20px; margin-top: -30px; }
  .quick-links-grid { grid-template-columns: repeat(2, 1fr); gap: 8px; }
  .quick-link-item { padding: 12px 10px; }
  .quick-link-text { font-size: 12px; }
  .events-grid { grid-template-columns: 1fr; }
  .events-grid .event-card:nth-child(3) { max-width: none; }
  .events-header { flex-direction: column; align-items: flex-start; gap: 12px; }
}
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

/* Calendar Styles */
.calendar-month {
  margin: 40px 0;
}
.calendar-month-title {
  font-family: 'Playfair Display', serif;
  font-size: 24px; font-weight: 500;
  color: var(--text); margin-bottom: 20px;
  display: flex; align-items: center; gap: 10px;
}
.cal-event {
  display: flex; gap: 16px; align-items: flex-start;
  padding: 18px;
  border-left: 4px solid var(--blue);
  background: var(--ice);
  border-radius: 0 12px 12px 0;
  margin-bottom: 12px;
  transition: all 0.3s;
}
.cal-event:hover {
  background: var(--white);
  box-shadow: 0 6px 20px rgba(0,0,0,0.06);
  transform: translateX(4px);
}
.cal-event-date {
  min-width: 52px; text-align: center;
  background: var(--blue); border-radius: 10px;
  padding: 8px 6px; flex-shrink: 0;
}
.cal-event-date .day {
  font-family: 'Playfair Display', serif;
  font-size: 22px; font-weight: 700; color: var(--white);
}
.cal-event-date .dow {
  font-size: 10px; font-weight: 700; text-transform: uppercase;
  letter-spacing: 1px; color: var(--gold-light);
}
.cal-event-info h4 {
  font-size: 16px; font-weight: 700; color: var(--text); margin: 0 0 4px;
}
.cal-event-info p {
  font-size: 13px; color: var(--text-muted); margin: 0;
}

/* Lunch Menu Styles */
.menu-week {
  margin: 40px 0;
}
.menu-week-title {
  font-size: 18px; font-weight: 700;
  color: var(--blue-deep); margin-bottom: 16px;
}
.menu-grid {
  display: grid;
  grid-template-columns: repeat(5, 1fr);
  gap: 12px;
}
.menu-day {
  background: var(--white);
  border: 2px solid var(--ice);
  border-radius: 14px;
  padding: 20px 16px;
  text-align: center;
  transition: all 0.3s;
}
.menu-day:hover {
  border-color: var(--gold);
  box-shadow: 0 8px 24px rgba(255,209,0,0.15);
  transform: translateY(-3px);
}
.menu-day-name {
  font-size: 12px; font-weight: 700;
  text-transform: uppercase; letter-spacing: 1px;
  color: var(--blue); margin-bottom: 12px;
}
.menu-day-icon { font-size: 32px; margin-bottom: 10px; display: block; }
.menu-day-meal {
  font-size: 15px; font-weight: 600;
  color: var(--text); margin-bottom: 4px;
}
.menu-day-detail {
  font-size: 12px; color: var(--text-muted); line-height: 1.5;
}

/* Portal Styles */
.portal-login {
  max-width: 440px; margin: 60px auto;
  background: var(--white);
  border: 2px solid var(--ice);
  border-radius: 20px;
  padding: 48px 40px;
  box-shadow: 0 20px 60px rgba(0,0,0,0.06);
  text-align: center;
}
.portal-login-icon {
  font-size: 48px; margin-bottom: 16px;
}
.portal-login h2 {
  text-align: center; margin-bottom: 8px;
}
.portal-login p {
  text-align: center; margin-bottom: 32px;
}
.portal-features {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
  gap: 20px; margin: 60px 0 40px;
}
.portal-feature {
  display: flex; gap: 14px; align-items: flex-start;
  padding: 24px;
  background: var(--cream-warm);
  border-radius: 14px;
}
.portal-feature-icon {
  font-size: 28px; flex-shrink: 0;
}
.portal-feature h4 {
  font-size: 15px; font-weight: 700;
  color: var(--text); margin: 0 0 4px;
}
.portal-feature p {
  font-size: 13px; color: var(--text-muted); margin: 0; line-height: 1.5;
}

/* Staff Directory */
.staff-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 24px; margin: 40px 0;
}
.staff-card {
  background: var(--white);
  border: 2px solid var(--ice);
  border-radius: 16px;
  padding: 28px;
  text-align: center;
  transition: all 0.3s;
}
.staff-card:hover {
  border-color: var(--blue-light);
  box-shadow: 0 12px 40px rgba(0,48,135,0.08);
  transform: translateY(-4px);
}
.staff-avatar {
  width: 80px; height: 80px;
  border-radius: 50%;
  background: var(--blue);
  color: var(--white);
  display: flex; align-items: center; justify-content: center;
  font-family: 'Playfair Display', serif;
  font-size: 28px; font-weight: 600;
  margin: 0 auto 16px;
}
.staff-card h4 {
  font-family: 'Playfair Display', serif;
  font-size: 18px; font-weight: 600;
  color: var(--text); margin: 0 0 4px;
}
.staff-card .staff-role {
  font-size: 13px; font-weight: 600;
  color: var(--blue); text-transform: uppercase;
  letter-spacing: 1px; margin-bottom: 8px;
}
.staff-card .staff-bio {
  font-size: 13px; color: var(--text-muted);
  line-height: 1.6;
}

/* Responsive for inner pages */
@media (max-width: 1024px) {
  .staff-grid { grid-template-columns: repeat(2, 1fr); }
}
@media (max-width: 768px) {
  .page-hero { padding: 120px 20px 60px; }
  .page-content { padding: 40px 20px; }
  .form-row { grid-template-columns: 1fr; }
  .staff-grid { grid-template-columns: 1fr; }
  .menu-grid { grid-template-columns: repeat(2, 1fr); }
  .menu-day:nth-child(5) { grid-column: 1 / -1; max-width: 200px; margin: 0 auto; }
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
<section class="page-hero" style="background: linear-gradient(160deg, rgba(0,24,64,0.88) 0%, rgba(0,48,135,0.7) 50%, rgba(0,24,64,0.82) 100%), url('https://images.unsplash.com/photo-1524178232363-1fb2b075b655?w=1920&q=85') center/cover;">
  <div class="page-hero-label">Our Team</div>
  <h1 class="page-hero-title">Staff Directory</h1>
  <p class="page-hero-subtitle">Meet the dedicated educators who make KPMS a special place to learn and grow.</p>
  <div class="page-breadcrumb"><a href="/">Home</a> / <a href="#">About Us</a> / Staff Directory</div>
</section>

<div class="page-content">
<?php
  global $wpdb;
  $staff_table = $wpdb->prefix . 'kpms_staff';
  $has_table = ($wpdb->get_var("SHOW TABLES LIKE '$staff_table'") === $staff_table);

  $sections = [
      'leadership' => 'Leadership',
      'teaching'   => 'Teaching Faculty',
      'support'    => 'Support Staff',
  ];

  foreach ($sections as $cat_key => $cat_label):
      $staff_members = $has_table ? $wpdb->get_results($wpdb->prepare(
          "SELECT * FROM $staff_table WHERE category = %s AND is_active = 1 ORDER BY display_order ASC, name ASC", $cat_key
      )) : [];
      if (empty($staff_members)) continue;
      $is_first = ($cat_key === 'leadership');
  ?>
  <h2 style="text-align:center;<?php echo $is_first ? '' : ' margin-top:60px;'; ?>"><?php echo esc_html($cat_label); ?></h2>
  <div class="staff-grid">
    <?php foreach ($staff_members as $member):
      $display_name = !empty($member->name) ? $member->name : '';
      if (empty($display_name) && $member->user_id > 0) {
          $u = get_userdata($member->user_id);
          $display_name = $u ? $u->display_name : 'Staff Member';
      }
      $initials = function_exists('kpms_get_initials') ? kpms_get_initials($display_name) : strtoupper(substr($display_name, 0, 2));
      $color = !empty($member->circle_color) ? $member->circle_color : '#003087';
      $text_color = ($color === '#FFD100') ? 'var(--navy-deep)' : '#fff';
      $role = !empty($member->title) ? $member->title : $member->department;
    ?>
    <div class="staff-card">
      <?php if (!empty($member->photo_url)): ?>
        <img src="<?php echo esc_url($member->photo_url); ?>" alt="<?php echo esc_attr($display_name); ?>" style="width:80px;height:80px;border-radius:50%;object-fit:cover;margin:0 auto 16px;display:block;border:3px solid <?php echo esc_attr($color); ?>;">
      <?php else: ?>
        <div class="staff-avatar" style="background:<?php echo esc_attr($color); ?>;color:<?php echo $text_color; ?>;"><?php echo esc_html($initials); ?></div>
      <?php endif; ?>
      <h4><?php echo esc_html($display_name); ?></h4>
      <?php if (!empty($role)): ?>
        <div class="staff-role"><?php echo esc_html($role); ?></div>
      <?php endif; ?>
      <?php if (!empty($member->bio)): ?>
        <div class="staff-bio"><?php echo esc_html($member->bio); ?></div>
      <?php endif; ?>
      <?php if (!empty($member->quote)): ?>
        <div class="staff-bio" style="font-style:italic;margin-top:8px;">"<?php echo esc_html($member->quote); ?>"</div>
      <?php endif; ?>
      <?php if (!empty($member->qualifications)): ?>
        <div class="staff-bio" style="margin-top:6px;font-size:12px;color:var(--blue);"><?php echo esc_html($member->qualifications); ?></div>
      <?php endif; ?>
    </div>
    <?php endforeach; ?>
  </div>
  <?php endforeach; ?>

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
