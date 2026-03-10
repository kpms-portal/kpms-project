<?php
/*
Template Name: KPMS - Our Campus
*/
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Our Campus – KPMS | Kamal Public Middle School Abbottabad</title>
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
  line-height: 1.7;
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

/* ===== PAGE HERO ===== */
.page-hero {
  position: relative;
  padding: 160px 60px 100px;
  text-align: center;
  overflow: hidden;
}
.page-hero-bg {
  position: absolute; inset: 0;
  background:
    linear-gradient(160deg, rgba(0,24,64,0.88) 0%, rgba(0,48,135,0.65) 50%, rgba(0,24,64,0.82) 100%),
    url('https://images.unsplash.com/photo-1562774053-701939374585?w=1920&q=85') center/cover;
}
.page-hero-shapes {
  position: absolute; inset: 0; overflow: hidden; pointer-events: none;
}
.page-hero-shapes .shape {
  position: absolute; border-radius: 50%; opacity: 0.08;
}
.page-hero-shapes .shape-1 { width: 400px; height: 400px; background: var(--gold); top: -100px; right: -100px; }
.page-hero-shapes .shape-2 { width: 250px; height: 250px; background: var(--coral); bottom: -60px; left: -60px; }
.page-hero-shapes .shape-3 { width: 180px; height: 180px; background: var(--sky); top: 40%; left: 10%; }
.page-hero-content {
  position: relative; z-index: 2;
  max-width: 820px; margin: 0 auto;
}
.page-hero-label {
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
.page-hero-title {
  font-family: 'Playfair Display', serif;
  font-size: clamp(36px, 6vw, 64px);
  font-weight: 500;
  color: var(--white);
  line-height: 1.12;
  margin-bottom: 24px;
  opacity: 0; animation: fadeUp 0.8s 0.4s forwards;
}
.page-hero-title em {
  font-style: italic;
  color: var(--gold-light);
  font-weight: 400;
}
.page-hero-subtitle {
  font-size: clamp(16px, 2.2vw, 20px);
  color: rgba(255,255,255,0.85);
  line-height: 1.65;
  max-width: 640px; margin: 0 auto 40px;
  opacity: 0; animation: fadeUp 0.8s 0.6s forwards;
}
.page-hero-btns {
  display: flex; gap: 16px; justify-content: center; flex-wrap: wrap;
  opacity: 0; animation: fadeUp 0.8s 0.8s forwards;
}
.page-hero-scroll {
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
.page-breadcrumb {
  margin-top: 20px; font-size: 13px; color: rgba(255,255,255,0.5);
  opacity: 0; animation: fadeUp 0.8s 1s forwards;
}
.page-breadcrumb a { color: rgba(255,255,255,0.7); text-decoration: none; }
.page-breadcrumb a:hover { color: var(--gold-light); }

/* ===== CAMPUS OVERVIEW ===== */
.campus-overview {
  padding: 100px 60px;
  max-width: 1200px; margin: 0 auto;
}
.campus-overview-inner {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 60px;
  align-items: center;
}
.campus-overview-text .section-label { margin-bottom: 14px; }
.campus-overview-text .section-title { margin-bottom: 20px; }
.campus-overview-text p {
  font-size: 16px; line-height: 1.8;
  color: var(--text-muted); margin-bottom: 16px;
}
.campus-overview-text .highlight-list {
  list-style: none; padding: 0; margin: 24px 0;
}
.campus-overview-text .highlight-list li {
  padding: 10px 0 10px 28px;
  position: relative;
  font-size: 15px; color: var(--text-muted);
  font-weight: 500;
}
.campus-overview-text .highlight-list li::before {
  content: '\2726'; position: absolute; left: 0;
  color: var(--gold); font-size: 14px; top: 11px;
}
.campus-overview-image {
  position: relative;
  border-radius: 20px;
  overflow: hidden;
  box-shadow: 0 30px 80px rgba(0,48,135,0.15);
}
.campus-overview-image img {
  width: 100%; height: 480px;
  object-fit: cover; display: block;
}
.campus-overview-image .image-accent {
  position: absolute; bottom: -16px; right: -16px;
  width: 140px; height: 140px;
  background: var(--gold);
  border-radius: 20px;
  opacity: 0.15;
  z-index: -1;
}

/* ===== FACILITIES GRID ===== */
.facilities-section {
  padding: 100px 60px;
  background: var(--cream);
}
.facilities-inner {
  max-width: 1200px; margin: 0 auto;
}
.facilities-header {
  text-align: center;
  margin-bottom: 60px;
}
.facilities-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 24px;
}
.facility-card {
  background: var(--white);
  border: 2px solid var(--ice);
  border-radius: 16px;
  padding: 36px 28px;
  transition: all 0.4s cubic-bezier(0.16,1,0.3,1);
  position: relative;
  overflow: hidden;
}
.facility-card::before {
  content: '';
  position: absolute; top: 0; left: 0; right: 0;
  height: 4px;
  background: linear-gradient(90deg, var(--blue), var(--sky));
  transform: scaleX(0);
  transform-origin: left;
  transition: transform 0.4s ease;
}
.facility-card:hover::before { transform: scaleX(1); }
.facility-card:hover {
  border-color: var(--blue-light);
  box-shadow: 0 16px 48px rgba(0,48,135,0.1);
  transform: translateY(-6px);
}
.facility-icon {
  font-size: 40px; margin-bottom: 18px;
  display: block;
}
.facility-card h3 {
  font-family: 'Playfair Display', serif;
  font-size: 20px; font-weight: 600;
  color: var(--text); margin-bottom: 10px;
}
.facility-card p {
  font-size: 14px; color: var(--text-muted);
  line-height: 1.7; margin: 0;
}

/* ===== VIRTUAL TOUR SECTION ===== */
.virtual-tour {
  padding: 100px 60px;
  max-width: 1200px; margin: 0 auto;
}
.virtual-tour-header {
  text-align: center;
  margin-bottom: 50px;
}
.virtual-tour-player {
  position: relative;
  border-radius: 20px;
  overflow: hidden;
  box-shadow: 0 30px 80px rgba(0,48,135,0.15);
  aspect-ratio: 16/9;
  max-width: 900px;
  margin: 0 auto;
  cursor: pointer;
}
.virtual-tour-player img {
  width: 100%; height: 100%;
  object-fit: cover;
}
.virtual-tour-overlay {
  position: absolute; inset: 0;
  background: linear-gradient(160deg, rgba(0,24,64,0.6) 0%, rgba(0,48,135,0.4) 100%);
  display: flex; align-items: center; justify-content: center;
  flex-direction: column; gap: 16px;
  transition: background 0.3s;
}
.virtual-tour-player:hover .virtual-tour-overlay {
  background: linear-gradient(160deg, rgba(0,24,64,0.5) 0%, rgba(0,48,135,0.3) 100%);
}
.play-btn {
  width: 80px; height: 80px;
  background: var(--gold);
  border-radius: 50%;
  display: flex; align-items: center; justify-content: center;
  box-shadow: 0 8px 30px rgba(255,209,0,0.4);
  transition: all 0.4s cubic-bezier(0.16,1,0.3,1);
}
.play-btn svg {
  width: 32px; height: 32px;
  fill: var(--navy-deep);
  margin-left: 4px;
}
.virtual-tour-player:hover .play-btn {
  transform: scale(1.12);
  box-shadow: 0 12px 40px rgba(255,209,0,0.5);
}
.play-label {
  font-size: 14px; font-weight: 700;
  color: var(--white);
  letter-spacing: 1.5px; text-transform: uppercase;
}

/* ===== CAMPUS LIFE GALLERY ===== */
.campus-gallery {
  padding: 100px 60px;
  background: var(--cream-warm);
}
.campus-gallery-inner {
  max-width: 1200px; margin: 0 auto;
}
.campus-gallery-header {
  text-align: center;
  margin-bottom: 50px;
}
.gallery-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  grid-template-rows: 260px 260px;
  gap: 16px;
}
.gallery-item {
  border-radius: 16px;
  overflow: hidden;
  position: relative;
  cursor: pointer;
}
.gallery-item:nth-child(1) { grid-column: 1/2; grid-row: 1/3; }
.gallery-item img {
  width: 100%; height: 100%;
  object-fit: cover;
  transition: transform 0.6s cubic-bezier(0.16,1,0.3,1);
}
.gallery-item:hover img { transform: scale(1.06); }
.gallery-caption {
  position: absolute; bottom: 0; left: 0; right: 0;
  padding: 20px;
  background: linear-gradient(to top, rgba(0,15,43,0.8), transparent);
  opacity: 0;
  transform: translateY(10px);
  transition: all 0.3s ease;
}
.gallery-item:hover .gallery-caption {
  opacity: 1;
  transform: translateY(0);
}
.gallery-caption span {
  font-size: 14px; font-weight: 600;
  color: var(--white);
}

/* ===== LOCATION & MAP ===== */
.location-section {
  padding: 100px 60px;
}
.location-inner {
  max-width: 1200px; margin: 0 auto;
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 50px;
  align-items: center;
}
.location-info .section-label { margin-bottom: 14px; }
.location-info .section-title { margin-bottom: 20px; }
.location-info p {
  font-size: 16px; line-height: 1.8;
  color: var(--text-muted); margin-bottom: 24px;
}
.location-details {
  list-style: none; padding: 0; margin: 0;
}
.location-details li {
  display: flex; align-items: flex-start; gap: 14px;
  padding: 14px 0;
  border-bottom: 1px solid var(--ice);
  font-size: 15px; color: var(--text-muted);
}
.location-details li:last-child { border-bottom: none; }
.location-icon {
  font-size: 20px;
  flex-shrink: 0;
  width: 36px; height: 36px;
  background: var(--ice);
  border-radius: 10px;
  display: flex; align-items: center; justify-content: center;
}
.location-detail-text strong {
  display: block;
  font-size: 14px; font-weight: 700;
  color: var(--text);
  margin-bottom: 2px;
}
.location-detail-text span {
  font-size: 14px;
  color: var(--text-muted);
}
.location-map {
  border-radius: 20px;
  overflow: hidden;
  box-shadow: 0 20px 60px rgba(0,48,135,0.12);
  border: 2px solid var(--ice);
}
.location-map iframe {
  width: 100%; height: 420px;
  border: none; display: block;
}

/* ===== CTA SECTION ===== */
.cta-section {
  padding: 100px 60px;
  background:
    linear-gradient(160deg, rgba(0,24,64,0.92) 0%, rgba(0,48,135,0.85) 50%, rgba(0,24,64,0.92) 100%),
    url('https://images.unsplash.com/photo-1580582932707-520aed937b7b?w=1920&q=85') center/cover;
  text-align: center;
  position: relative;
  overflow: hidden;
}
.cta-shapes {
  position: absolute; inset: 0; pointer-events: none;
}
.cta-shapes .shape {
  position: absolute; border-radius: 50%; opacity: 0.06;
}
.cta-shapes .shape-1 { width: 300px; height: 300px; background: var(--gold); top: -80px; left: -80px; }
.cta-shapes .shape-2 { width: 200px; height: 200px; background: var(--coral); bottom: -60px; right: -60px; }
.cta-label {
  font-size: 12px; font-weight: 700;
  letter-spacing: 3px; text-transform: uppercase;
  color: var(--gold-light);
  margin-bottom: 16px;
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
  font-size: 18px;
  color: rgba(255,255,255,0.7);
  max-width: 600px; margin: 0 auto 36px;
  line-height: 1.7;
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
  .nav-inner, .campus-overview, .virtual-tour, .location-section, .facilities-section, .campus-gallery, .cta-section {
    padding-left: 30px !important; padding-right: 30px !important;
  }
  .facilities-grid { gap: 16px; }
  .campus-overview-inner { gap: 40px; }
  .footer-grid { grid-template-columns: 1fr 1fr; }
}

@media (max-width: 900px) {
  .topbar { display: none; }
  .nav-menu { display: none; }
  .nav-search-btn { display: none; }
  .mobile-toggle { display: block; }
  .nav-inner { padding: 0 20px !important; height: 64px; }
  .page-hero { padding: 120px 30px 80px; }
  .campus-overview { padding: 60px 20px !important; }
  .campus-overview-inner { grid-template-columns: 1fr; gap: 40px; }
  .campus-overview-image img { height: 340px; }
  .facilities-section { padding: 60px 20px !important; }
  .facilities-grid { grid-template-columns: repeat(2, 1fr); gap: 16px; }
  .virtual-tour { padding: 60px 20px !important; }
  .campus-gallery { padding: 60px 20px !important; }
  .gallery-grid {
    grid-template-columns: 1fr 1fr;
    grid-template-rows: repeat(3, 200px);
  }
  .gallery-item:nth-child(1) { grid-column: 1/3; grid-row: 1/2; }
  .location-section { padding: 60px 20px !important; }
  .location-inner { grid-template-columns: 1fr; gap: 40px; }
  .location-map iframe { height: 320px; }
  .cta-section { padding: 60px 20px !important; }
  .footer-grid { grid-template-columns: 1fr; gap: 32px; }
  .footer-bottom { flex-direction: column; text-align: center; }
  .page-hero-btns { flex-direction: column; align-items: center; }
}

@media (max-width: 600px) {
  .page-hero { padding: 100px 20px 60px; }
  .facilities-grid { grid-template-columns: 1fr; }
  .facility-card { padding: 28px 22px; }
  .gallery-grid {
    grid-template-columns: 1fr;
    grid-template-rows: repeat(6, 200px);
  }
  .gallery-item:nth-child(1) { grid-column: 1; grid-row: 1; }
  .cta-actions { flex-direction: column; align-items: center; }
  .nav-logo-icon { width: 48px; height: 48px; }
  .nav-logo-text { font-size: 18px; }
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

<!-- SKIP LINK -->
<a href="#main-content" class="skip-link">Skip to main content</a>

<!-- TOPBAR -->
<div class="topbar">
  <div class="topbar-left">
    <span>&#128205; Sheikh ul Bandi, Abbottabad</span>
    <a href="tel:+923135914700">&#128222; +92 313 5914700</a>
    <a href="mailto:admissions@kpms.edu.pk">&#9993; admissions@kpms.edu.pk</a>
  </div>
  <div class="topbar-right">
    <div class="topbar-translate">
      <select aria-label="Language">
        <option value="en" selected>English</option>
        <option value="ur">&#1575;&#1585;&#1583;&#1608;</option>
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
    <input type="text" placeholder="Search campus, facilities, events..." id="searchInput" aria-label="Search the site">
    <button class="search-close" onclick="toggleSearch()" aria-label="Close search">&#10005;</button>
  </div>
  <div class="search-hint">Press ESC to close</div>
</div>

<?php include get_stylesheet_directory() . '/mobile-menu.php'; ?>

<!-- ===== MAIN CONTENT ===== -->
<main id="main-content">

  <!-- HERO -->
  <section class="page-hero">
    <div class="page-hero-bg"></div>
    <div class="page-hero-shapes">
      <div class="shape shape-1"></div>
      <div class="shape shape-2"></div>
      <div class="shape shape-3"></div>
    </div>
    <div class="page-hero-content">
      <div class="page-hero-label">Discover KPMS</div>
      <h1 class="page-hero-title">Our <em>Campus</em></h1>
      <p class="page-hero-subtitle">Explore our beautiful campus nestled in the scenic hills of Abbottabad, where tradition meets modern learning in an inspiring environment.</p>
      <div class="page-hero-btns">
        <a href="/schedule-tour/" class="btn btn-gold">Schedule a Tour</a>
        <a href="/apply-online/" class="btn btn-outline-light">Apply Now</a>
      </div>
      <div class="page-breadcrumb">
        <a href="/">Home</a> &nbsp;/&nbsp; <a href="#">About Us</a> &nbsp;/&nbsp; Our Campus
      </div>
    </div>
    <div class="page-hero-scroll">
      <div class="scroll-dot"></div>
    </div>
  </section>

  <!-- CAMPUS OVERVIEW -->
  <section class="campus-overview">
    <div class="campus-overview-inner">
      <div class="campus-overview-text reveal">
        <div class="section-label">Welcome to KPMS</div>
        <h2 class="section-title">A Place Where Young Minds Flourish</h2>
        <p>
          Located in the heart of Sheikh ul Bandi, Abbottabad, Kamal Public Middle School sits against the breathtaking backdrop of the Himalayan foothills. Since 1985, our campus has been a sanctuary of learning where students are nurtured in a serene, natural environment that inspires curiosity and academic excellence.
        </p>
        <p>
          Our thoughtfully designed grounds combine modern educational facilities with open green spaces, creating the ideal setting for holistic development. Every corner of our campus has been crafted to encourage exploration, collaboration, and personal growth.
        </p>
        <ul class="highlight-list">
          <li>Spacious, well-ventilated classrooms with natural light</li>
          <li>Lush green grounds surrounded by the hills of Abbottabad</li>
          <li>Safe, secure environment with monitored entry points</li>
          <li>Dedicated wings for Montessori and primary students</li>
        </ul>
      </div>
      <div class="campus-overview-image reveal reveal-d2">
        <img src="https://images.unsplash.com/photo-1580582932707-520aed937b7b?w=800&q=85" alt="KPMS campus grounds with lush greenery">
        <div class="image-accent"></div>
      </div>
    </div>
  </section>

  <!-- FACILITIES -->
  <section class="facilities-section">
    <div class="facilities-inner">
      <div class="facilities-header reveal">
        <div class="section-label">Campus Facilities</div>
        <h2 class="section-title">Everything Your Child Needs to Thrive</h2>
        <p class="section-subtitle">Our state-of-the-art facilities are designed to support every dimension of student learning and growth.</p>
      </div>

      <div class="facilities-grid">

        <div class="facility-card reveal reveal-d1">
          <span class="facility-icon">&#127979;</span>
          <h3>Modern Classrooms</h3>
          <p>Bright, spacious classrooms equipped with smart boards, comfortable seating, and climate control, creating an optimal environment for focused learning and interactive lessons.</p>
        </div>

        <div class="facility-card reveal reveal-d2">
          <span class="facility-icon">&#128300;</span>
          <h3>Science Laboratory</h3>
          <p>A fully equipped science lab where students conduct hands-on experiments, fostering scientific inquiry and a deeper understanding of the natural world through practical exploration.</p>
        </div>

        <div class="facility-card reveal reveal-d3">
          <span class="facility-icon">&#128187;</span>
          <h3>Computer Lab</h3>
          <p>Our modern computer lab features the latest technology and educational software, preparing students with essential digital literacy skills for the 21st century.</p>
        </div>

        <div class="facility-card reveal reveal-d1">
          <span class="facility-icon">&#128218;</span>
          <h3>Library &amp; Reading Room</h3>
          <p>An extensive collection of books, reference materials, and periodicals in a quiet, comfortable reading room that cultivates a lifelong love of literature and learning.</p>
        </div>

        <div class="facility-card reveal reveal-d2">
          <span class="facility-icon">&#9917;</span>
          <h3>Playground &amp; Sports Area</h3>
          <p>Spacious outdoor grounds for cricket, football, and athletics, along with dedicated play areas for younger students, encouraging physical fitness and team spirit.</p>
        </div>

        <div class="facility-card reveal reveal-d3">
          <span class="facility-icon">&#127916;</span>
          <h3>Assembly Hall</h3>
          <p>A large, well-appointed assembly hall used for morning assemblies, school events, award ceremonies, cultural performances, and parent-teacher meetings throughout the year.</p>
        </div>

        <div class="facility-card reveal reveal-d1">
          <span class="facility-icon">&#127912;</span>
          <h3>Montessori Wing</h3>
          <p>Specially designed learning spaces for our youngest students, featuring age-appropriate furniture, tactile learning materials, and vibrant, stimulating wall displays.</p>
        </div>

        <div class="facility-card reveal reveal-d2">
          <span class="facility-icon">&#127912;</span>
          <h3>Art &amp; Craft Room</h3>
          <p>A dedicated creative space where students express themselves through painting, drawing, calligraphy, and crafts, nurturing artistic talent and imaginative thinking.</p>
        </div>

        <div class="facility-card reveal reveal-d3">
          <span class="facility-icon">&#128332;</span>
          <h3>Prayer Room</h3>
          <p>A peaceful, dedicated prayer room where students observe daily prayers, learn Islamic values, and develop their spiritual awareness in a respectful environment.</p>
        </div>

      </div>
    </div>
  </section>

  <!-- VIRTUAL TOUR -->
  <section class="virtual-tour">
    <div class="virtual-tour-header reveal">
      <div class="section-label">Take a Look Around</div>
      <h2 class="section-title">Virtual Campus Tour</h2>
      <p class="section-subtitle">Get a glimpse of daily life at KPMS from the comfort of your home. Watch our campus tour to see our facilities, classrooms, and the vibrant atmosphere that defines our school.</p>
    </div>

    <div class="virtual-tour-player reveal reveal-d2">
      <img src="https://images.unsplash.com/photo-1497633762265-9d179a990aa6?w=1200&q=85" alt="KPMS campus aerial view for virtual tour">
      <div class="virtual-tour-overlay">
        <div class="play-btn">
          <svg viewBox="0 0 24 24"><polygon points="8,5 19,12 8,19"/></svg>
        </div>
        <span class="play-label">Watch Campus Tour</span>
      </div>
    </div>
  </section>

  <!-- CAMPUS LIFE GALLERY -->
  <section class="campus-gallery">
    <div class="campus-gallery-inner">
      <div class="campus-gallery-header reveal">
        <div class="section-label">Campus Life</div>
        <h2 class="section-title">A Day at KPMS</h2>
        <p class="section-subtitle">From classroom learning to playground adventures, every day at KPMS is filled with moments of discovery and joy.</p>
      </div>

      <div class="gallery-grid reveal reveal-d1">
        <div class="gallery-item">
          <img src="https://images.unsplash.com/photo-1503676260728-1c00da094a0b?w=800&q=85" alt="Students in classroom">
          <div class="gallery-caption"><span>Classroom Learning</span></div>
        </div>
        <div class="gallery-item">
          <img src="https://images.unsplash.com/photo-1588072432836-e10032774350?w=800&q=85" alt="Students studying together">
          <div class="gallery-caption"><span>Collaborative Study</span></div>
        </div>
        <div class="gallery-item">
          <img src="https://images.unsplash.com/photo-1427504494785-3a9ca7044f45?w=800&q=85" alt="Science experiments">
          <div class="gallery-caption"><span>Science Exploration</span></div>
        </div>
        <div class="gallery-item">
          <img src="https://images.unsplash.com/photo-1571260899304-425eee4c7efc?w=800&q=85" alt="Library reading time">
          <div class="gallery-caption"><span>Library Time</span></div>
        </div>
        <div class="gallery-item">
          <img src="https://images.unsplash.com/photo-1509062522246-3755977927d7?w=800&q=85" alt="School assembly">
          <div class="gallery-caption"><span>Morning Assembly</span></div>
        </div>
      </div>
    </div>
  </section>

  <!-- LOCATION & MAP -->
  <section class="location-section">
    <div class="location-inner">
      <div class="location-info reveal">
        <div class="section-label">Find Us</div>
        <h2 class="section-title">Our Location</h2>
        <p>KPMS is conveniently located in Sheikh ul Bandi, a peaceful residential area of Abbottabad, Khyber Pakhtunkhwa. Our campus is easily accessible and surrounded by the natural beauty of the region.</p>

        <ul class="location-details">
          <li>
            <div class="location-icon">&#128205;</div>
            <div class="location-detail-text">
              <strong>Address</strong>
              <span>Sheikh ul Bandi, Abbottabad, Khyber Pakhtunkhwa, Pakistan</span>
            </div>
          </li>
          <li>
            <div class="location-icon">&#128222;</div>
            <div class="location-detail-text">
              <strong>Phone</strong>
              <span><a href="tel:+923135914700" style="color:var(--blue);text-decoration:none;">+92 313 5914700</a></span>
            </div>
          </li>
          <li>
            <div class="location-icon">&#9993;</div>
            <div class="location-detail-text">
              <strong>Email</strong>
              <span><a href="mailto:admissions@kpms.edu.pk" style="color:var(--blue);text-decoration:none;">admissions@kpms.edu.pk</a></span>
            </div>
          </li>
          <li>
            <div class="location-icon">&#128337;</div>
            <div class="location-detail-text">
              <strong>School Hours</strong>
              <span>Monday - Saturday: 8:00 AM - 2:00 PM</span>
            </div>
          </li>
          <li>
            <div class="location-icon">&#128197;</div>
            <div class="location-detail-text">
              <strong>Office Hours</strong>
              <span>Monday - Saturday: 7:30 AM - 3:00 PM</span>
            </div>
          </li>
        </ul>
      </div>

      <div class="location-map reveal reveal-d2">
        <iframe
          src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d13215.845642507372!2d73.2046!3d34.1688!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x38de31904e045a5b%3A0x5e38e39a58f3e3e0!2sAbbottabad%2C%20Khyber%20Pakhtunkhwa%2C%20Pakistan!5e0!3m2!1sen!2s!4v1700000000000!5m2!1sen!2s"
          allowfullscreen=""
          loading="lazy"
          referrerpolicy="no-referrer-when-downgrade"
          title="KPMS Location - Sheikh ul Bandi, Abbottabad">
        </iframe>
      </div>
    </div>
  </section>

  <!-- CTA -->
  <section class="cta-section">
    <div class="cta-shapes">
      <div class="shape shape-1"></div>
      <div class="shape shape-2"></div>
    </div>
    <div class="cta-label reveal">Visit Us Today</div>
    <h2 class="cta-title reveal reveal-d1">Experience Our Campus</h2>
    <p class="cta-subtitle reveal reveal-d2">There is no substitute for seeing KPMS in person. Walk our hallways, meet our faculty, and discover why families have trusted us with their children's education since 1985.</p>
    <div class="cta-actions reveal reveal-d3">
      <a href="/schedule-tour/" class="btn btn-gold">Schedule a Tour</a>
      <a href="/contact/" class="btn btn-outline-light">Contact Us</a>
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
          <li><a href="/apply-online/">How to Apply</a></li>
          <li><a href="/campus/">Visit Campus</a></li>
          <li><a href="/apply-online/">Admission FAQs</a></li>
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