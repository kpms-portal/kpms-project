<?php
/*
Template Name: KPMS - Student Resources
*/
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Student Resources – KPMS | Kamal Public Middle School Abbottabad</title>
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
  color: var(--blue-light);
  margin-bottom: 10px;
}
.section-title {
  font-family: 'Playfair Display', serif;
  font-size: clamp(28px, 3.5vw, 40px);
  font-weight: 500; color: var(--text);
  line-height: 1.2; margin-bottom: 16px;
}
.section-subtitle {
  font-size: 17px; color: var(--text-muted);
  line-height: 1.7; max-width: 640px;
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
  background: var(--blue-light);
  transform: translateY(-2px);
  box-shadow: 0 8px 24px rgba(0,48,135,0.3);
}
.btn-outline {
  background: transparent;
  color: var(--blue);
  border: 2px solid var(--blue);
}
.btn-outline:hover {
  background: var(--blue);
  color: var(--white);
  transform: translateY(-2px);
}
.btn-outline-white {
  background: transparent;
  color: var(--white);
  border: 2px solid rgba(255,255,255,0.3);
}
.btn-outline-white:hover {
  border-color: var(--gold-light);
  color: var(--gold-light);
  transform: translateY(-2px);
}

/* ===== PAGE HERO ===== */
.page-hero {
  background: linear-gradient(160deg, rgba(0,24,64,0.88) 0%, rgba(0,48,135,0.7) 50%, rgba(0,24,64,0.82) 100%),
    url('https://images.unsplash.com/photo-1503676260728-1c00da094a0b?w=1920&q=85') center/cover;
  padding: 140px 60px 80px;
  text-align: center;
  position: relative;
  overflow: hidden;
}
.page-hero-shapes {
  position: absolute; inset: 0; overflow: hidden; pointer-events: none;
}
.page-hero-shapes .shape {
  position: absolute; border-radius: 50%; opacity: 0.06;
}
.page-hero-shapes .shape-1 { width: 350px; height: 350px; background: var(--gold); top: -80px; right: -80px; }
.page-hero-shapes .shape-2 { width: 200px; height: 200px; background: var(--sky); bottom: -50px; left: -50px; }
.page-hero-shapes .shape-3 { width: 140px; height: 140px; background: var(--coral); top: 40%; left: 15%; }
.page-hero-label {
  font-size: 12px; font-weight: 700;
  letter-spacing: 3px; text-transform: uppercase;
  color: var(--gold-light);
  margin-bottom: 12px;
  position: relative;
  opacity: 0; animation: fadeUp 0.8s 0.2s forwards;
}
.page-hero-title {
  font-family: 'Playfair Display', serif;
  font-size: clamp(32px, 4vw, 48px);
  font-weight: 500; color: var(--white);
  line-height: 1.2; margin-bottom: 16px;
  position: relative;
  opacity: 0; animation: fadeUp 0.8s 0.4s forwards;
}
.page-hero-subtitle {
  font-size: 18px; color: rgba(255,255,255,0.7);
  max-width: 600px; margin: 0 auto;
  position: relative;
  opacity: 0; animation: fadeUp 0.8s 0.6s forwards;
}
.page-breadcrumb {
  margin-top: 20px; font-size: 13px; color: rgba(255,255,255,0.5);
  position: relative;
  opacity: 0; animation: fadeUp 0.8s 0.8s forwards;
}
.page-breadcrumb a { color: rgba(255,255,255,0.7); text-decoration: none; }
.page-breadcrumb a:hover { color: var(--gold-light); }

@keyframes fadeUp {
  from { opacity: 0; transform: translateY(28px); }
  to { opacity: 1; transform: translateY(0); }
}

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
.ql-library { background: #e3f2fd; }
.ql-homework { background: #fff3e0; }
.ql-study { background: #e8f5e9; }
.ql-tools { background: #fce4ec; }
.quick-link-text { font-size: 13px; font-weight: 700; color: var(--text); line-height: 1.2; }
.quick-link-sub { font-size: 10px; font-weight: 400; color: var(--text-muted); display: block; margin-top: 2px; }

/* ===== LEARNING RESOURCES SECTION ===== */
.resources-section {
  padding: 80px 60px;
  max-width: 1300px; margin: 0 auto;
}
.resources-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 24px;
  margin-top: 40px;
}
.resource-card {
  background: var(--white);
  border: 2px solid var(--ice);
  border-radius: 16px;
  padding: 32px 28px;
  transition: all 0.3s cubic-bezier(0.16,1,0.3,1);
  position: relative;
  overflow: hidden;
}
.resource-card::before {
  content: '';
  position: absolute; top: 0; left: 0; right: 0;
  height: 4px;
  background: var(--blue);
  transform: scaleX(0);
  transform-origin: left;
  transition: transform 0.4s cubic-bezier(0.16,1,0.3,1);
}
.resource-card:hover::before { transform: scaleX(1); }
.resource-card:hover {
  border-color: var(--blue-light);
  box-shadow: 0 16px 48px rgba(0,48,135,0.1);
  transform: translateY(-6px);
}
.resource-card-icon {
  font-size: 40px; margin-bottom: 16px;
  display: block;
}
.resource-card h3 {
  font-family: 'Playfair Display', serif;
  font-size: 20px; font-weight: 600;
  color: var(--text); margin-bottom: 12px;
}
.resource-card p {
  font-size: 14px; color: var(--text-muted);
  line-height: 1.6; margin-bottom: 18px;
}
.resource-links {
  list-style: none; padding: 0; margin: 0;
}
.resource-links li {
  margin-bottom: 10px;
}
.resource-links a {
  display: flex; align-items: center; gap: 8px;
  text-decoration: none;
  font-size: 14px; font-weight: 600;
  color: var(--blue);
  padding: 8px 14px;
  border-radius: 8px;
  background: var(--cream);
  transition: all 0.3s;
}
.resource-links a:hover {
  background: var(--ice);
  transform: translateX(4px);
  color: var(--blue-deep);
}
.resource-links a .link-arrow {
  margin-left: auto;
  font-size: 14px;
  opacity: 0;
  transform: translateX(-6px);
  transition: all 0.3s;
}
.resource-links a:hover .link-arrow {
  opacity: 1;
  transform: translateX(0);
}

/* ===== STUDY TIPS ACCORDION ===== */
.tips-section {
  padding: 80px 60px;
  background: var(--cream);
}
.tips-inner {
  max-width: 900px; margin: 0 auto;
}
.accordion {
  margin-top: 40px;
}
.accordion-item {
  background: var(--white);
  border: 2px solid var(--ice);
  border-radius: 14px;
  margin-bottom: 12px;
  overflow: hidden;
  transition: all 0.3s;
}
.accordion-item:hover {
  border-color: var(--blue-light);
}
.accordion-item.active {
  border-color: var(--blue);
  box-shadow: 0 8px 30px rgba(0,48,135,0.08);
}
.accordion-header {
  display: flex; align-items: center; gap: 14px;
  padding: 20px 24px;
  cursor: pointer;
  background: none; border: none; width: 100%;
  font-family: 'DM Sans', sans-serif;
  font-size: 16px; font-weight: 700;
  color: var(--text);
  text-align: left;
  transition: all 0.3s;
}
.accordion-header:hover { color: var(--blue); }
.accordion-icon {
  width: 36px; height: 36px;
  border-radius: 10px;
  background: var(--ice);
  display: flex; align-items: center; justify-content: center;
  font-size: 18px;
  flex-shrink: 0;
  transition: all 0.3s;
}
.accordion-item.active .accordion-icon {
  background: var(--blue);
  color: var(--white);
}
.accordion-arrow {
  margin-left: auto;
  font-size: 12px;
  transition: transform 0.3s;
  color: var(--text-muted);
}
.accordion-item.active .accordion-arrow {
  transform: rotate(180deg);
  color: var(--blue);
}
.accordion-body {
  max-height: 0;
  overflow: hidden;
  transition: max-height 0.4s cubic-bezier(0.16,1,0.3,1);
}
.accordion-body-inner {
  padding: 0 24px 24px 74px;
  font-size: 15px;
  color: var(--text-muted);
  line-height: 1.8;
}
.accordion-body-inner ul {
  list-style: none; padding: 0; margin: 10px 0 0;
}
.accordion-body-inner ul li {
  padding: 6px 0 6px 20px;
  position: relative;
}
.accordion-body-inner ul li::before {
  content: ''; position: absolute; left: 0; top: 14px;
  width: 8px; height: 8px;
  background: var(--gold);
  border-radius: 50%;
}

/* ===== HOMEWORK HELP SECTION ===== */
.homework-section {
  padding: 80px 60px;
  max-width: 1300px; margin: 0 auto;
}
.homework-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 24px;
  margin-top: 40px;
}
.homework-card {
  background: var(--white);
  border: 2px solid var(--ice);
  border-radius: 16px;
  padding: 32px 28px;
  text-align: center;
  transition: all 0.3s;
}
.homework-card:hover {
  border-color: var(--gold);
  box-shadow: 0 12px 40px rgba(255,209,0,0.12);
  transform: translateY(-4px);
}
.homework-card-icon {
  font-size: 44px; margin-bottom: 16px;
  display: block;
}
.homework-card h3 {
  font-family: 'Playfair Display', serif;
  font-size: 20px; font-weight: 600;
  color: var(--text); margin-bottom: 10px;
}
.homework-card p {
  font-size: 14px; color: var(--text-muted);
  line-height: 1.7; margin: 0;
}

/* ===== DIGITAL LITERACY SECTION ===== */
.digital-section {
  padding: 80px 60px;
  background: linear-gradient(160deg, var(--navy-deep) 0%, var(--blue-deep) 100%);
  position: relative;
  overflow: hidden;
}
.digital-section::before {
  content: '';
  position: absolute; top: -100px; right: -100px;
  width: 300px; height: 300px;
  background: var(--gold);
  border-radius: 50%;
  opacity: 0.04;
}
.digital-section::after {
  content: '';
  position: absolute; bottom: -80px; left: -80px;
  width: 220px; height: 220px;
  background: var(--sky);
  border-radius: 50%;
  opacity: 0.04;
}
.digital-inner {
  max-width: 1100px; margin: 0 auto;
  position: relative; z-index: 1;
}
.digital-section .section-label { color: var(--gold-light); }
.digital-section .section-title { color: var(--white); }
.digital-section .section-subtitle { color: rgba(255,255,255,0.65); }
.digital-grid {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 24px;
  margin-top: 40px;
}
.digital-card {
  background: rgba(255,255,255,0.06);
  border: 1px solid rgba(255,255,255,0.1);
  border-radius: 16px;
  padding: 32px 28px;
  backdrop-filter: blur(8px);
  transition: all 0.3s;
  display: flex; gap: 18px; align-items: flex-start;
}
.digital-card:hover {
  background: rgba(255,255,255,0.1);
  border-color: rgba(255,255,255,0.2);
  transform: translateY(-3px);
}
.digital-card-icon {
  font-size: 32px; flex-shrink: 0;
  width: 56px; height: 56px;
  background: rgba(255,255,255,0.08);
  border-radius: 14px;
  display: flex; align-items: center; justify-content: center;
}
.digital-card h4 {
  font-family: 'Playfair Display', serif;
  font-size: 18px; font-weight: 600;
  color: var(--white); margin-bottom: 8px;
}
.digital-card p {
  font-size: 14px; color: rgba(255,255,255,0.55);
  line-height: 1.7; margin: 0;
}

/* ===== CTA SECTION ===== */
.cta-section {
  padding: 80px 60px;
  text-align: center;
  background: var(--cream);
}
.cta-inner {
  max-width: 700px; margin: 0 auto;
}
.cta-icon { font-size: 48px; margin-bottom: 16px; display: block; }
.cta-section h2 {
  font-family: 'Playfair Display', serif;
  font-size: clamp(28px, 3vw, 36px);
  font-weight: 500; color: var(--text);
  margin-bottom: 12px;
}
.cta-section p {
  font-size: 17px; color: var(--text-muted);
  line-height: 1.7; margin-bottom: 32px;
  max-width: 520px; margin-left: auto; margin-right: auto;
}
.cta-btns {
  display: flex; gap: 16px; justify-content: center; flex-wrap: wrap;
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

/* ===== RESPONSIVE ===== */
@media (max-width: 1024px) {
  .nav-inner, section, .resources-section, .homework-section, .tips-section, .digital-section, .cta-section {
    padding-left: 30px !important; padding-right: 30px !important;
  }
  .resources-grid { grid-template-columns: repeat(2, 1fr); }
  .homework-grid { grid-template-columns: repeat(2, 1fr); }
  .homework-grid .homework-card:nth-child(3) { grid-column: 1 / -1; max-width: 400px; margin: 0 auto; }
  .footer-grid { grid-template-columns: 1fr 1fr; }
  .quick-links-grid { grid-template-columns: repeat(2, 1fr); gap: 10px; }
  .quick-links { max-width: 600px; }
}

@media (max-width: 768px) {
  .topbar { display: none; }
  .nav-menu { display: none; }
  .nav-search-btn { display: none; }
  .mobile-toggle { display: block; }
  .nav-inner { padding: 0 20px !important; height: 64px; }
  .nav-logo-icon { width: 48px; height: 48px; }
  .nav-logo-text { font-size: 18px; }
  .page-hero { padding: 120px 20px 60px; }
  .resources-section, .homework-section, .tips-section, .digital-section, .cta-section {
    padding: 50px 20px !important;
  }
  .resources-grid { grid-template-columns: 1fr; }
  .homework-grid { grid-template-columns: 1fr; }
  .homework-grid .homework-card:nth-child(3) { max-width: none; }
  .digital-grid { grid-template-columns: 1fr; }
  .quick-links { padding: 0 20px; margin-top: -30px; }
  .quick-links-grid { grid-template-columns: repeat(2, 1fr); gap: 8px; }
  .quick-link-item { padding: 12px 10px; }
  .quick-link-text { font-size: 12px; }
  .footer-grid { grid-template-columns: 1fr; gap: 32px; }
  .footer-bottom { flex-direction: column; text-align: center; }
  .cta-btns { flex-direction: column; align-items: center; }
  .accordion-body-inner { padding-left: 24px; }
}

@media (max-width: 480px) {
  .quick-links-grid { grid-template-columns: 1fr 1fr; gap: 6px; }
  .quick-link-icon { width: 34px; height: 34px; font-size: 16px; }
  .resource-card { padding: 24px 20px; }
  .digital-card { flex-direction: column; }
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
    <input type="text" placeholder="Search resources, study tips, tools..." id="searchInput" aria-label="Search the site">
    <button class="search-close" onclick="toggleSearch()" aria-label="Close search">&#10005;</button>
  </div>
  <div class="search-hint">Press ESC to close &middot; Ctrl+K to search</div>
</div>

<?php include get_stylesheet_directory() . '/mobile-menu.php'; ?>


<!-- ===== PAGE HERO ===== -->
<section class="page-hero" id="main-content" style="background: linear-gradient(160deg, rgba(0,24,64,0.88) 0%, rgba(0,48,135,0.7) 50%, rgba(0,24,64,0.82) 100%), url('https://images.unsplash.com/photo-1456513080510-7bf3a84b82f8?w=1920&q=85') center/cover;">
  <div class="page-hero-shapes">
    <div class="shape shape-1"></div>
    <div class="shape shape-2"></div>
    <div class="shape shape-3"></div>
  </div>
  <div class="page-hero-label">Student Hub</div>
  <h1 class="page-hero-title">Student Resources</h1>
  <p class="page-hero-subtitle">Tools, links, and resources to help you succeed at KPMS</p>
  <div class="page-breadcrumb"><a href="/">Home</a> / <a href="#">Students</a> / Student Resources</div>
</section>


<!-- ===== QUICK LINKS BAR ===== -->
<div class="quick-links">
  <div class="quick-links-grid">
    <a href="#learning-resources" class="quick-link-item">
      <div class="quick-link-icon ql-library">📚</div>
      <div>
        <span class="quick-link-text">Library Catalog</span>
        <span class="quick-link-sub">Browse our collection</span>
      </div>
    </a>
    <a href="#homework-help" class="quick-link-item">
      <div class="quick-link-icon ql-homework">📝</div>
      <div>
        <span class="quick-link-text">Homework Help</span>
        <span class="quick-link-sub">Get support anytime</span>
      </div>
    </a>
    <a href="#study-tips" class="quick-link-item">
      <div class="quick-link-icon ql-study">💡</div>
      <div>
        <span class="quick-link-text">Study Tips</span>
        <span class="quick-link-sub">Learn smarter</span>
      </div>
    </a>
    <a href="#online-tools" class="quick-link-item">
      <div class="quick-link-icon ql-tools">🖥</div>
      <div>
        <span class="quick-link-text">Online Tools</span>
        <span class="quick-link-sub">Digital resources</span>
      </div>
    </a>
  </div>
</div>


<!-- ===== LEARNING RESOURCES ===== -->
<section class="resources-section" id="learning-resources">
  <div class="section-label reveal">Explore &amp; Learn</div>
  <h2 class="section-title reveal reveal-d1">Learning Resources</h2>
  <p class="section-subtitle reveal reveal-d2">Explore curated resources organized by subject to support your learning at every level.</p>

  <div class="resources-grid">

    <!-- Mathematics -->
    <div class="resource-card reveal reveal-d1">
      <span class="resource-card-icon">🔢</span>
      <h3>Mathematics</h3>
      <p>Build strong math skills with these trusted online tools and practice platforms.</p>
      <ul class="resource-links">
        <li><a href="https://www.khanacademy.org/math" target="_blank" rel="noopener noreferrer">📐 Khan Academy Math <span class="link-arrow">&rarr;</span></a></li>
        <li><a href="https://www.mathway.com" target="_blank" rel="noopener noreferrer">🧮 Mathway <span class="link-arrow">&rarr;</span></a></li>
        <li><a href="https://www.mathsisfun.com" target="_blank" rel="noopener noreferrer">🎯 Math is Fun <span class="link-arrow">&rarr;</span></a></li>
      </ul>
    </div>

    <!-- Science -->
    <div class="resource-card reveal reveal-d2">
      <span class="resource-card-icon">🔬</span>
      <h3>Science</h3>
      <p>Discover the wonders of science through interactive experiments and engaging articles.</p>
      <ul class="resource-links">
        <li><a href="https://kids.nationalgeographic.com" target="_blank" rel="noopener noreferrer">🌍 National Geographic Kids <span class="link-arrow">&rarr;</span></a></li>
        <li><a href="https://spaceplace.nasa.gov" target="_blank" rel="noopener noreferrer">🚀 NASA Kids Club <span class="link-arrow">&rarr;</span></a></li>
        <li><a href="https://www.sciencebuddies.org" target="_blank" rel="noopener noreferrer">🧪 Science Buddies <span class="link-arrow">&rarr;</span></a></li>
      </ul>
    </div>

    <!-- English & Reading -->
    <div class="resource-card reveal reveal-d3">
      <span class="resource-card-icon">📖</span>
      <h3>English &amp; Reading</h3>
      <p>Improve your reading comprehension, vocabulary, and writing skills with these resources.</p>
      <ul class="resource-links">
        <li><a href="https://www.starfall.com" target="_blank" rel="noopener noreferrer">⭐ Starfall <span class="link-arrow">&rarr;</span></a></li>
        <li><a href="https://readtheory.org" target="_blank" rel="noopener noreferrer">📕 ReadTheory <span class="link-arrow">&rarr;</span></a></li>
        <li><a href="https://storybird.com" target="_blank" rel="noopener noreferrer">🐦 Storybird <span class="link-arrow">&rarr;</span></a></li>
      </ul>
    </div>

    <!-- Urdu & Islamic Studies -->
    <div class="resource-card reveal reveal-d1">
      <span class="resource-card-icon">🕌</span>
      <h3>Urdu &amp; Islamic Studies</h3>
      <p>Deepen your understanding of Urdu literature and explore Islamic knowledge resources.</p>
      <ul class="resource-links">
        <li><a href="https://www.rekhta.org" target="_blank" rel="noopener noreferrer">📜 Rekhta <span class="link-arrow">&rarr;</span></a></li>
        <li><a href="https://quran.com" target="_blank" rel="noopener noreferrer">📗 Quran.com <span class="link-arrow">&rarr;</span></a></li>
        <li><a href="https://www.urdupoint.com" target="_blank" rel="noopener noreferrer">✍ UrduPoint <span class="link-arrow">&rarr;</span></a></li>
      </ul>
    </div>

    <!-- Computer Science -->
    <div class="resource-card reveal reveal-d2">
      <span class="resource-card-icon">💻</span>
      <h3>Computer Science</h3>
      <p>Learn to code, create animations, and develop digital skills for the future.</p>
      <ul class="resource-links">
        <li><a href="https://code.org" target="_blank" rel="noopener noreferrer">🎮 Code.org <span class="link-arrow">&rarr;</span></a></li>
        <li><a href="https://scratch.mit.edu" target="_blank" rel="noopener noreferrer">🐱 Scratch <span class="link-arrow">&rarr;</span></a></li>
        <li><a href="https://www.typingclub.com" target="_blank" rel="noopener noreferrer">⌨ Typing Club <span class="link-arrow">&rarr;</span></a></li>
      </ul>
    </div>

    <!-- General Knowledge -->
    <div class="resource-card reveal reveal-d3">
      <span class="resource-card-icon">🌐</span>
      <h3>General Knowledge</h3>
      <p>Expand your horizons with these comprehensive learning and reference platforms.</p>
      <ul class="resource-links">
        <li><a href="https://www.brainpop.com" target="_blank" rel="noopener noreferrer">🧠 BrainPOP <span class="link-arrow">&rarr;</span></a></li>
        <li><a href="https://kids.britannica.com" target="_blank" rel="noopener noreferrer">📚 Britannica Kids <span class="link-arrow">&rarr;</span></a></li>
        <li><a href="https://wonderopolis.org" target="_blank" rel="noopener noreferrer">❓ Wonderopolis <span class="link-arrow">&rarr;</span></a></li>
      </ul>
    </div>

  </div>
</section>


<!-- ===== STUDY TIPS ACCORDION ===== -->
<section class="tips-section" id="study-tips">
  <div class="tips-inner">
    <div class="section-label reveal">Smart Strategies</div>
    <h2 class="section-title reveal reveal-d1">Study Tips for Success</h2>
    <p class="section-subtitle reveal reveal-d2">Develop effective study habits that will help you excel in your classes and beyond.</p>

    <div class="accordion reveal reveal-d3">

      <div class="accordion-item active">
        <button class="accordion-header" aria-expanded="true">
          <span class="accordion-icon">📅</span>
          <span>Create a Study Schedule</span>
          <span class="accordion-arrow">&#9660;</span>
        </button>
        <div class="accordion-body" style="max-height:300px;">
          <div class="accordion-body-inner">
            A consistent study schedule helps you stay organized and avoid last-minute cramming. Planning your study time makes learning more effective and less stressful.
            <ul>
              <li>Set aside the same time each day for studying</li>
              <li>Break large assignments into smaller, manageable tasks</li>
              <li>Use a planner or calendar to track due dates</li>
              <li>Include short breaks between study sessions</li>
              <li>Review your schedule weekly and adjust as needed</li>
            </ul>
          </div>
        </div>
      </div>

      <div class="accordion-item">
        <button class="accordion-header" aria-expanded="false">
          <span class="accordion-icon">📝</span>
          <span>Take Effective Notes</span>
          <span class="accordion-arrow">&#9660;</span>
        </button>
        <div class="accordion-body">
          <div class="accordion-body-inner">
            Good note-taking is one of the most powerful study skills you can develop. Well-organized notes make reviewing for tests much easier.
            <ul>
              <li>Write notes in your own words instead of copying word-for-word</li>
              <li>Use headings, bullet points, and numbered lists</li>
              <li>Highlight or underline key concepts and definitions</li>
              <li>Leave space in the margins for questions or additional notes</li>
              <li>Review and organize your notes within 24 hours of class</li>
            </ul>
          </div>
        </div>
      </div>

      <div class="accordion-item">
        <button class="accordion-header" aria-expanded="false">
          <span class="accordion-icon">📖</span>
          <span>Practice Active Reading</span>
          <span class="accordion-arrow">&#9660;</span>
        </button>
        <div class="accordion-body">
          <div class="accordion-body-inner">
            Active reading means engaging with the text rather than passively scanning pages. This approach dramatically improves comprehension and retention.
            <ul>
              <li>Preview headings and subheadings before reading</li>
              <li>Ask yourself questions as you read each section</li>
              <li>Summarize paragraphs in your own words</li>
              <li>Make connections between new information and what you already know</li>
              <li>Discuss what you read with classmates or family members</li>
            </ul>
          </div>
        </div>
      </div>

      <div class="accordion-item">
        <button class="accordion-header" aria-expanded="false">
          <span class="accordion-icon">🍅</span>
          <span>Use the Pomodoro Technique</span>
          <span class="accordion-arrow">&#9660;</span>
        </button>
        <div class="accordion-body">
          <div class="accordion-body-inner">
            The Pomodoro Technique uses timed intervals to keep you focused and productive. It prevents burnout by building in regular breaks.
            <ul>
              <li>Study for 25 minutes with full concentration</li>
              <li>Take a 5-minute break to stretch or rest your eyes</li>
              <li>After four study intervals, take a longer 15-20 minute break</li>
              <li>Remove all distractions during your study intervals</li>
              <li>Track how many intervals you complete each day</li>
            </ul>
          </div>
        </div>
      </div>

      <div class="accordion-item">
        <button class="accordion-header" aria-expanded="false">
          <span class="accordion-icon">🙋</span>
          <span>Ask Questions in Class</span>
          <span class="accordion-arrow">&#9660;</span>
        </button>
        <div class="accordion-body">
          <div class="accordion-body-inner">
            Asking questions shows curiosity and helps deepen your understanding. There is no such thing as a silly question when you are genuinely trying to learn.
            <ul>
              <li>Write down questions as they come to mind during lessons</li>
              <li>Raise your hand and ask during class discussions</li>
              <li>Visit your teacher after class if you need more clarification</li>
              <li>Form study groups where everyone can share questions</li>
              <li>Use questions to connect new topics to what you already know</li>
            </ul>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>


<!-- ===== HOMEWORK HELP ===== -->
<section class="homework-section" id="homework-help">
  <div class="section-label reveal">Support When You Need It</div>
  <h2 class="section-title reveal reveal-d1">Homework Help</h2>
  <p class="section-subtitle reveal reveal-d2">Struggling with an assignment? Here are ways to get the help you need to succeed.</p>

  <div class="homework-grid">
    <div class="homework-card reveal reveal-d1">
      <span class="homework-card-icon">👩‍🏫</span>
      <h3>Talk to Your Teacher</h3>
      <p>Your teachers are your greatest resource. Visit them during break time or after school hours to ask for clarification on assignments you find challenging. They can provide extra worksheets, explain concepts in different ways, and guide you through difficult problems step by step.</p>
    </div>
    <div class="homework-card reveal reveal-d2">
      <span class="homework-card-icon">👥</span>
      <h3>Join a Study Group</h3>
      <p>Working with classmates helps you learn from different perspectives. Form a small study group of 3-4 students who are focused and committed. Meet regularly to review class material, quiz each other before tests, and work through homework problems together.</p>
    </div>
    <div class="homework-card reveal reveal-d3">
      <span class="homework-card-icon">📚</span>
      <h3>Visit the School Library</h3>
      <p>The KPMS library is a quiet, focused environment perfect for completing homework. Our librarian can help you find reference materials, textbooks, and online resources. The library is open during school hours and provides access to computers for research projects.</p>
    </div>
  </div>
</section>


<!-- ===== DIGITAL LITERACY ===== -->
<section class="digital-section" id="online-tools">
  <div class="digital-inner">
    <div class="section-label reveal">Stay Safe Online</div>
    <h2 class="section-title reveal reveal-d1">Digital Literacy</h2>
    <p class="section-subtitle reveal reveal-d2">Learn to use technology responsibly and stay safe in the digital world.</p>

    <div class="digital-grid">
      <div class="digital-card reveal reveal-d1">
        <div class="digital-card-icon">🔒</div>
        <div>
          <h4>Protect Your Privacy</h4>
          <p>Never share personal information such as your full name, home address, phone number, or school name with strangers online. Use strong passwords that combine letters, numbers, and symbols, and never share your passwords with anyone except your parents.</p>
        </div>
      </div>
      <div class="digital-card reveal reveal-d2">
        <div class="digital-card-icon">🤝</div>
        <div>
          <h4>Be Kind Online</h4>
          <p>Treat others online the same way you would treat them in person. Think before you post or comment. If you see cyberbullying, report it to a trusted adult immediately. Remember that words can hurt, even on a screen.</p>
        </div>
      </div>
      <div class="digital-card reveal reveal-d3">
        <div class="digital-card-icon">🔍</div>
        <div>
          <h4>Evaluate Sources</h4>
          <p>Not everything you read online is true. Learn to check facts by verifying information across multiple reliable sources. Look for official websites, educational institutions, and established news organizations when doing research for school projects.</p>
        </div>
      </div>
      <div class="digital-card reveal reveal-d4">
        <div class="digital-card-icon">⏰</div>
        <div>
          <h4>Manage Screen Time</h4>
          <p>Balance your time between screens and other activities. Use technology as a tool for learning, not just entertainment. Take regular breaks to rest your eyes and stay physically active. Set device-free times, especially before bedtime.</p>
        </div>
      </div>
    </div>
  </div>
</section>


<!-- ===== CTA SECTION ===== -->
<section class="cta-section">
  <div class="cta-inner reveal">
    <span class="cta-icon">🎓</span>
    <h2>Need More Help?</h2>
    <p>Our teachers and staff are always here to support your learning journey. Do not hesitate to reach out.</p>
    <div class="cta-btns">
      <a href="/contact/" class="btn btn-blue">Contact a Teacher</a>
      <a href="#learning-resources" class="btn btn-outline">Visit the Library</a>
    </div>
  </div>
</section>


<!-- ===== FOOTER ===== -->
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
          <li><a href="/mission-vision/">History</a></li>
          <li><a href="/mission-vision/">Approach &amp; Philosophy</a></li>
        </ul>
      </div>
      <div>
        <h4 class="footer-heading">Links</h4>
        <ul class="footer-links">
          <li><a href="/calendar/">Summer Programs</a></li>
          <li><a href="/contact/">Careers</a></li>
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


<!-- ===== JAVASCRIPT ===== -->
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

// Accordion toggle
document.querySelectorAll('.accordion-header').forEach(header => {
  header.addEventListener('click', function() {
    const item = this.parentElement;
    const body = item.querySelector('.accordion-body');
    const inner = body.querySelector('.accordion-body-inner');
    const isActive = item.classList.contains('active');

    // Close all items
    document.querySelectorAll('.accordion-item').forEach(ai => {
      ai.classList.remove('active');
      ai.querySelector('.accordion-header').setAttribute('aria-expanded', 'false');
      ai.querySelector('.accordion-body').style.maxHeight = '0';
    });

    // Open clicked item if it was not already active
    if (!isActive) {
      item.classList.add('active');
      this.setAttribute('aria-expanded', 'true');
      body.style.maxHeight = inner.scrollHeight + 40 + 'px';
    }
  });
});
</script>

</body>
</html>