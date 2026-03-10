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
  display: grid; grid-template-columns: repeat(3, 1fr); gap: 12px;
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

/* ===== ANNOUNCEMENT BANNER ===== */
/* ===== ANNOUNCEMENT TICKER ===== */
.kpms-ticker {
  background: linear-gradient(135deg, #001a4d, #003087);
  display: flex;
  align-items: center;
  height: 44px;
  position: relative;
  z-index: 100;
  overflow: hidden;
  border-bottom: 2px solid rgba(255,209,0,0.15);
}
.kpms-ticker-label {
  background: #FFD100;
  color: #003087;
  font-size: 14px;
  font-weight: 700;
  padding: 0 16px;
  height: 100%;
  display: flex;
  align-items: center;
  flex-shrink: 0;
  z-index: 3;
}
.kpms-ticker-window {
  flex: 1;
  overflow: hidden;
  height: 100%;
  display: flex;
  align-items: center;
}
.kpms-ticker-belt {
  display: inline-flex;
  align-items: center;
  white-space: nowrap;
  will-change: transform;
}
.kpms-ticker-item {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  font-size: 13px;
  color: #fff;
  padding: 0 6px;
}
.kpms-ticker-item strong { color: #fff; font-weight: 700; }
.kpms-ticker-dot {
  color: #FFD100;
  font-size: 8px;
  padding: 0 18px;
  opacity: 0.4;
}
.kpms-ticker-priority {
  font-size: 9px;
  font-weight: 800;
  text-transform: uppercase;
  letter-spacing: 0.7px;
  padding: 2px 7px;
  border-radius: 3px;
  flex-shrink: 0;
}
.kpms-pri-normal { background: rgba(255,255,255,0.1); color: rgba(255,255,255,0.7); }
.kpms-pri-important { background: #FFD100; color: #003087; }
.kpms-pri-urgent { background: #E8443A; color: #fff; }
.kpms-ticker-close {
  background: none; border: none;
  color: rgba(255,255,255,0.35);
  font-size: 18px;
  padding: 0 14px;
  height: 100%;
  cursor: pointer;
  flex-shrink: 0;
  z-index: 3;
}
.kpms-ticker-close:hover { color: #fff; }
@media (max-width: 768px) {
  .kpms-ticker { height: 38px; }
  .kpms-ticker-label { padding: 0 10px; font-size: 12px; }
  .kpms-ticker-item { font-size: 12px; }
}

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
    url('<?php echo esc_url(kpms_get_section_image('hero_bg', 'https://images.unsplash.com/photo-1503676260728-1c00da094a0b?w=1920&q=85')); ?>') center/cover;
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

/* ===== FACULTY SHOWCASE ===== */
.faculty-showcase {
  padding: 90px 60px;
  max-width: 1300px;
  margin: 0 auto;
}
.faculty-showcase-header {
  text-align: center;
  margin-bottom: 50px;
}
.faculty-showcase-subtitle {
  font-size: 17px;
  color: var(--text-muted);
  margin-top: 10px;
}
.faculty-carousel {
  position: relative;
  display: grid;
  grid-template-columns: 1fr 1.2fr;
  gap: 50px;
  align-items: center;
  min-height: 480px;
}
.faculty-photo-side {
  position: relative;
}
.faculty-photo-main {
  width: 100%;
  aspect-ratio: 3/4;
  border-radius: 20px;
  overflow: hidden;
  box-shadow: 0 20px 60px rgba(0,48,135,0.15);
}
.faculty-photo-main img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  transition: opacity 0.5s ease;
}
.faculty-photo-prev,
.faculty-photo-next {
  position: absolute;
  width: 56px;
  height: 56px;
  border-radius: 50%;
  overflow: hidden;
  border: 3px solid var(--white);
  box-shadow: 0 4px 16px rgba(0,0,0,0.15);
  transition: transform 0.3s;
  cursor: pointer;
}
.faculty-photo-prev { top: 50%; left: -28px; transform: translateY(-50%); }
.faculty-photo-next { top: 50%; right: -28px; transform: translateY(-50%); }
.faculty-photo-prev:hover,
.faculty-photo-next:hover { transform: translateY(-50%) scale(1.1); }
.faculty-photo-prev img,
.faculty-photo-next img {
  width: 100%; height: 100%; object-fit: cover;
}
.faculty-info-name {
  position: absolute;
  bottom: 0;
  left: 0;
  right: 0;
  padding: 30px 24px 20px;
  background: linear-gradient(transparent, rgba(0,15,43,0.85));
  border-radius: 0 0 20px 20px;
}
.faculty-info-name h3 {
  font-family: 'Playfair Display', serif;
  font-size: 22px;
  font-weight: 600;
  color: var(--white);
  margin-bottom: 2px;
}
.faculty-info-name span {
  font-size: 13px;
  color: var(--gold-light);
  font-weight: 500;
}
.faculty-profile-link {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  margin-top: 12px;
  font-size: 12px;
  font-weight: 700;
  letter-spacing: 1.5px;
  text-transform: uppercase;
  color: var(--white);
  text-decoration: none;
  cursor: pointer;
  transition: color 0.3s;
}
.faculty-profile-link::after {
  content: '';
  display: inline-block;
  width: 40px;
  height: 2px;
  background: var(--gold);
  transition: width 0.3s;
}
.faculty-profile-link:hover { color: var(--gold-light); }
.faculty-profile-link:hover::after { width: 60px; }

.faculty-quote-side {
  padding: 20px 0;
}
.faculty-quote-marks {
  font-family: 'Playfair Display', serif;
  font-size: 120px;
  line-height: 0.6;
  color: var(--gold);
  opacity: 0.3;
  margin-bottom: 10px;
  user-select: none;
}
.faculty-quote-text {
  font-family: 'Playfair Display', serif;
  font-size: 24px;
  font-weight: 400;
  font-style: italic;
  color: var(--text);
  line-height: 1.6;
  padding: 28px 32px;
  border-left: 4px solid var(--gold);
  border-right: 1px solid var(--ice);
  border-top: 1px solid var(--ice);
  border-bottom: 1px solid var(--ice);
  border-radius: 0 16px 16px 0;
  background: linear-gradient(135deg, rgba(255,209,0,0.03), transparent);
  transition: opacity 0.5s ease;
}
.faculty-carousel-nav {
  display: flex;
  align-items: center;
  gap: 16px;
  margin-top: 36px;
}
.faculty-nav-btn {
  width: 48px;
  height: 48px;
  border-radius: 50%;
  border: 2px solid var(--ice);
  background: var(--white);
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  font-size: 18px;
  color: var(--blue);
  transition: all 0.3s;
}
.faculty-nav-btn:hover {
  background: var(--blue);
  color: var(--white);
  border-color: var(--blue);
  transform: scale(1.08);
}
.faculty-nav-dots {
  display: flex;
  gap: 8px;
}
.faculty-nav-dot {
  width: 10px;
  height: 10px;
  border-radius: 50%;
  background: var(--ice);
  transition: all 0.3s;
  cursor: pointer;
}
.faculty-nav-dot.active {
  background: var(--blue);
  transform: scale(1.2);
}
.faculty-explore-link {
  margin-left: auto;
  font-size: 13px;
  font-weight: 700;
  letter-spacing: 1px;
  text-transform: uppercase;
  color: var(--blue);
  text-decoration: none;
  transition: color 0.3s;
}
.faculty-explore-link:hover { color: var(--gold-warm); }

/* Faculty Modal */
.faculty-modal-overlay {
  position: fixed;
  inset: 0;
  z-index: 10000;
  background: rgba(0,15,43,0.7);
  backdrop-filter: blur(6px);
  display: flex;
  align-items: center;
  justify-content: center;
  opacity: 0;
  pointer-events: none;
  transition: opacity 0.4s;
}
.faculty-modal-overlay.open {
  opacity: 1;
  pointer-events: all;
}
.faculty-modal {
  background: var(--white);
  border-radius: 20px;
  max-width: 720px;
  width: 92%;
  max-height: 90vh;
  overflow-y: auto;
  box-shadow: 0 30px 80px rgba(0,0,0,0.25);
  transform: translateY(30px) scale(0.95);
  transition: transform 0.4s cubic-bezier(0.16, 1, 0.3, 1);
  position: relative;
}
.faculty-modal-overlay.open .faculty-modal {
  transform: translateY(0) scale(1);
}
.faculty-modal-close {
  position: absolute;
  top: 16px;
  right: 16px;
  width: 40px;
  height: 40px;
  border-radius: 50%;
  border: none;
  background: var(--cream);
  color: var(--text);
  font-size: 20px;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: all 0.3s;
  z-index: 1;
}
.faculty-modal-close:hover {
  background: var(--coral);
  color: var(--white);
}
.faculty-modal-top {
  display: grid;
  grid-template-columns: 200px 1fr;
  gap: 28px;
  padding: 32px 32px 0;
}
.faculty-modal-photo {
  width: 200px;
  height: 200px;
  border-radius: 16px;
  overflow: hidden;
}
.faculty-modal-photo img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}
.faculty-modal-info h2 {
  font-family: 'Playfair Display', serif;
  font-size: 26px;
  font-weight: 600;
  color: var(--blue-deep);
  margin-bottom: 4px;
}
.faculty-modal-info .modal-title {
  font-size: 15px;
  color: var(--text-muted);
  font-weight: 500;
  margin-bottom: 16px;
}
.faculty-modal-info .modal-contact a {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  font-size: 13px;
  color: var(--blue);
  text-decoration: none;
  margin-right: 20px;
  font-weight: 600;
  transition: color 0.3s;
}
.faculty-modal-info .modal-contact a:hover { color: var(--gold-warm); }
.faculty-modal-details {
  padding: 24px 32px 32px;
}
.faculty-modal-details .detail-row {
  display: flex;
  gap: 40px;
  margin-bottom: 20px;
  padding-bottom: 20px;
  border-bottom: 1px solid var(--ice);
}
.detail-label {
  font-size: 11px;
  font-weight: 700;
  letter-spacing: 1.5px;
  text-transform: uppercase;
  color: var(--text-muted);
  margin-bottom: 4px;
}
.detail-value {
  font-size: 15px;
  color: var(--text);
  font-weight: 500;
}
.faculty-modal-bio {
  position: relative;
  padding: 24px 28px;
  background: var(--cream);
  border-radius: 14px;
  margin-top: 8px;
}
.faculty-modal-bio .bio-quote-mark {
  font-family: 'Playfair Display', serif;
  font-size: 80px;
  line-height: 0.5;
  color: var(--gold);
  opacity: 0.4;
  position: absolute;
  top: 16px;
  left: 20px;
}
.faculty-modal-bio p {
  font-family: 'Playfair Display', serif;
  font-size: 18px;
  font-style: italic;
  line-height: 1.7;
  color: var(--text);
  position: relative;
  z-index: 1;
  padding-top: 16px;
}

@media (max-width: 1024px) {
  .faculty-carousel { gap: 30px; }
  .faculty-quote-text { font-size: 20px; padding: 20px 24px; }
}
@media (max-width: 768px) {
  .faculty-showcase { padding: 60px 20px; }
  .faculty-carousel { grid-template-columns: 1fr; gap: 30px; min-height: auto; }
  .faculty-photo-main { max-width: 320px; margin: 0 auto; }
  .faculty-photo-prev { left: 0; }
  .faculty-photo-next { right: 0; }
  .faculty-quote-text { font-size: 18px; }
  .faculty-modal-top { grid-template-columns: 1fr; text-align: center; }
  .faculty-modal-photo { margin: 0 auto; }
  .detail-row { flex-direction: column; gap: 16px; }
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

<?php
// ===== ANNOUNCEMENT TICKER =====
global $wpdb;
$ann_table = $wpdb->prefix . 'kpms_announcements';
$today = current_time('Y-m-d');
if ($wpdb->get_var("SHOW TABLES LIKE '$ann_table'") === $ann_table) {
    $live_announcements = $wpdb->get_results(
        "SELECT * FROM $ann_table WHERE (expires_at IS NULL OR expires_at = '0000-00-00' OR expires_at >= '$today') ORDER BY FIELD(priority,'urgent','important','normal'), created_at DESC LIMIT 10"
    );
} else {
    $live_announcements = [];
}
if (!empty($live_announcements)):
?>
<div class="kpms-ticker" id="kpmsTicker">
  <div class="kpms-ticker-label">📢</div>
  <div class="kpms-ticker-window">
    <div class="kpms-ticker-belt" id="kpmsTickerBelt">
      <?php
      // Build once, print TWICE for seamless loop
      $items_html = '';
      foreach ($live_announcements as $ann) {
          $priority = strtolower($ann->priority ?? 'normal');
          $title = esc_html($ann->title ?? '');
          $msg = esc_html(wp_trim_words($ann->message ?? '', 12));
          $items_html .= '<span class="kpms-ticker-item">';
          $items_html .= '<span class="kpms-ticker-priority kpms-pri-' . esc_attr($priority) . '">' . esc_html(ucfirst($priority)) . '</span> ';
          $items_html .= '<strong>' . $title . '</strong>';
          if ($msg) $items_html .= ' &mdash; ' . $msg;
          $items_html .= '</span>';
          $items_html .= '<span class="kpms-ticker-dot">✦</span>';
      }
      echo $items_html;
      echo $items_html;
      ?>
    </div>
  </div>
  <button class="kpms-ticker-close" onclick="document.getElementById('kpmsTicker').style.display='none'" aria-label="Close">&times;</button>
</div>
<?php endif; ?>

<!-- HERO -->
<section class="hero">
  <div class="hero-bg"></div>
  <div class="hero-shapes">
    <div class="shape shape-1"></div>
    <div class="shape shape-2"></div>
    <div class="shape shape-3"></div>
  </div>
  <div class="hero-content">
    <div class="hero-badge">✦ Est. 1985 · Abbottabad, KPK</div>
    <h1 class="hero-title">Building <em>Confidence</em>, Critical Thinking<br>&amp; Digital Empowerment</h1>
    <p class="hero-subtitle">A joyful Abbottabad day school nurturing young minds from Pre‑Kindergarten through 5th Grade with purpose, creativity, and care.</p>
    <div class="hero-btns">
      <a href="/campus/" class="btn btn-gold">Schedule a Visit</a>
      <a href="/enrollment/" class="btn btn-outline">How to Apply</a>
    </div>
  </div>
  <div class="hero-scroll"><div class="scroll-dot"></div></div>
</section>

<!-- QUICK LINKS BAR -->
<div class="quick-links" id="main-content">
  <div class="quick-links-grid">
    <a href="/enrollment/" class="quick-link-item">
      <div class="quick-link-icon ql-enroll">📋</div>
      <div><span class="quick-link-text">Enrollment</span><span class="quick-link-sub">Apply for 2026–27</span></div>
    </a>
    <a href="/calendar/" class="quick-link-item">
      <div class="quick-link-icon ql-cal">📅</div>
      <div><span class="quick-link-text">Calendar</span><span class="quick-link-sub">Key dates &amp; events</span></div>
    </a>
    <a href="/parent-portal/" class="quick-link-item">
      <div class="quick-link-icon ql-portal">🔐</div>
      <div><span class="quick-link-text">Parent Portal</span><span class="quick-link-sub">Grades &amp; reports</span></div>
    </a>
  </div>
</div>

<!-- FEATURED EVENTS — Next 3 Important Dates -->
<?php
$events_table = $wpdb->prefix . 'kpms_events';
$homepage_events = [];
if ($wpdb->get_var("SHOW TABLES LIKE '$events_table'") === $events_table) {
    $homepage_events = $wpdb->get_results($wpdb->prepare(
        "SELECT * FROM $events_table WHERE event_date >= %s ORDER BY event_date ASC, event_time ASC LIMIT 3", $today
    ));
}
// Fallback hardcoded events if DB is empty
if (empty($homepage_events)):
?>
<div class="events-section">
  <div class="events-header">
    <div>
      <div class="section-label">What's Coming Up</div>
      <h2 class="section-title" style="font-size:28px;">Upcoming Events</h2>
    </div>
    <a href="/calendar/" class="see-all-link">View Full Calendar →</a>
  </div>
  <div class="events-grid">
    <a href="/calendar/" class="event-card">
      <div class="event-date-box"><div class="event-month">Mar</div><div class="event-day">15</div></div>
      <div class="event-info"><h4>Spring Art Exhibition</h4><p>Student artwork showcase open to parents and community</p><div class="event-time">🕐 10:00 AM – 2:00 PM</div></div>
    </a>
    <a href="/calendar/" class="event-card">
      <div class="event-date-box"><div class="event-month">Mar</div><div class="event-day">22</div></div>
      <div class="event-info"><h4>Parent-Teacher Conference</h4><p>Individual meetings with teachers to discuss progress</p><div class="event-time">🕐 1:00 PM – 5:00 PM</div></div>
    </a>
    <a href="/calendar/" class="event-card">
      <div class="event-date-box"><div class="event-month">Apr</div><div class="event-day">05</div></div>
      <div class="event-info"><h4>Open House for New Families</h4><p>Tour campus and meet our teachers — all are welcome</p><div class="event-time">🕐 9:00 AM – 12:00 PM</div></div>
    </a>
  </div>
</div>
<?php else: ?>
<div class="events-section">
  <div class="events-header">
    <div>
      <div class="section-label">What's Coming Up</div>
      <h2 class="section-title" style="font-size:28px;">Upcoming Events</h2>
    </div>
    <a href="/calendar/" class="see-all-link">View Full Calendar →</a>
  </div>
  <div class="events-grid">
    <?php foreach ($homepage_events as $evt):
      $date = strtotime($evt->event_date);
      $month = date('M', $date);
      $day = date('j', $date);
      $time_str = '';
      if (!empty($evt->event_time)) {
          $time_str = date('g:i A', strtotime($evt->event_time));
      }
    ?>
    <a href="/calendar/" class="event-card">
      <div class="event-date-box">
        <div class="event-month"><?php echo esc_html($month); ?></div>
        <div class="event-day"><?php echo esc_html($day); ?></div>
      </div>
      <div class="event-info">
        <h4><?php echo esc_html($evt->event_name); ?></h4>
        <?php if (!empty($evt->description)): ?>
        <p><?php echo esc_html(wp_trim_words($evt->description, 12)); ?></p>
        <?php endif; ?>
        <?php if (!empty($time_str)): ?>
        <div class="event-time">🕐 <?php echo esc_html($time_str); ?><?php if (!empty($evt->location)): ?> · <?php echo esc_html($evt->location); ?><?php endif; ?></div>
        <?php endif; ?>
      </div>
    </a>
    <?php endforeach; ?>
  </div>
</div>
<?php endif; ?>

<!-- THREE FEATURE CARDS (mirrors Nobles layout) -->
<div class="features">
  <div class="features-grid">
    <a href="/philosophy/" class="feature-card reveal">
      <img src="<?php echo esc_url(kpms_get_section_image('feature_philosophy', 'https://images.unsplash.com/photo-1509062522246-3755977927d7?w=700&q=80')); ?>" alt="School Philosophy">
      <div class="feature-overlay"></div>
      <div class="feature-content">
        <div class="feature-tag">Cultivating Curiosity</div>
        <h3 class="feature-title">Read Our School Philosophy</h3>
        <div class="feature-arrow">Explore →</div>
      </div>
    </a>
    <a href="/staff-directory/" class="feature-card reveal reveal-d1">
      <img src="<?php echo esc_url(kpms_get_section_image('feature_faculty', 'https://images.unsplash.com/photo-1577896851231-70ef18881754?w=700&q=80')); ?>" alt="Our Faculty">
      <div class="feature-overlay"></div>
      <div class="feature-content">
        <div class="feature-tag">Connecting with Common Purpose</div>
        <h3 class="feature-title">Meet Our Faculty</h3>
        <div class="feature-arrow">Explore →</div>
      </div>
    </a>
    <a href="/campus/" class="feature-card reveal reveal-d2">
      <img src="<?php echo esc_url(kpms_get_section_image('feature_community', 'https://images.unsplash.com/photo-1529156069898-49953e39b3ac?w=700&q=80')); ?>" alt="Creating Community">
      <div class="feature-overlay"></div>
      <div class="feature-content">
        <div class="feature-tag">Creating Community</div>
        <h3 class="feature-title">Discover a Shared Space Like No Other</h3>
        <div class="feature-arrow">Explore →</div>
      </div>
    </a>
  </div>
</div>

<!-- STATS -->
<section class="stats">
  <div class="stats-top">
    <div class="section-label reveal">KPMS at a Glance</div>
    <h2 class="section-title reveal reveal-d1">An Abbottabad Day School for Students in Grades Pre‑K Through 5</h2>
  </div>
  <div class="stats-carousel">
    <div class="stat-card reveal">
      <span class="stat-emoji">👧🏽</span>
      <div class="stat-number">120</div>
      <div class="stat-label">Total Students at KPMS<br>Pre-K to Grade 5</div>
    </div>
    <div class="stat-card reveal reveal-d1">
      <span class="stat-emoji">📖</span>
      <div class="stat-number">12</div>
      <div class="stat-label">Students in the<br>Average Classroom</div>
    </div>
    <div class="stat-card reveal reveal-d2">
      <span class="stat-emoji">🎨</span>
      <div class="stat-number">6</div>
      <div class="stat-label">Art Exhibitions<br>Each Year</div>
    </div>
    <div class="stat-card reveal reveal-d3">
      <span class="stat-emoji">🌳</span>
      <div class="stat-number">40</div>
      <div class="stat-label">Years of Educational<br>Excellence</div>
    </div>
  </div>
</section>

<!-- VIDEO TOUR -->
<section class="video-section">
  <div class="video-inner">
    <div class="section-label reveal" style="color:var(--gold-light)">A Video Tour</div>
    <h2 class="section-title reveal reveal-d1" style="color:var(--white)">Experience the Magic of KPMS</h2>
    <p class="section-subtitle reveal reveal-d2" style="color:rgba(255,255,255,0.6)">Our curriculum recognizes high art and incorporates the making of constructivist art projects as fundamental mechanisms for higher learning.</p>
    <div class="video-placeholder reveal reveal-d2" id="kpmsVideoBox">
      <img src="<?php echo esc_url(kpms_get_section_image('video_tour', 'https://images.unsplash.com/photo-1580582932707-520aed937b7b?w=1200&q=80')); ?>" alt="KPMS Campus Tour" id="kpmsVideoPoster">
      <div class="video-play" id="kpmsVideoPlay">
        <div class="play-btn">▶</div>
      </div>
    </div>
  </div>
</section>

<!-- AROUND KPMS -->
<section class="gallery">
  <div class="gallery-inner">
    <div style="text-align:center;">
      <div class="section-label reveal">Around KPMS</div>
      <h2 class="section-title reveal reveal-d1">Life on Our Campus</h2>
    </div>
    <div class="gallery-grid">
      <div class="gallery-item reveal">
        <img src="<?php echo esc_url(kpms_get_section_image('gallery_morning_assembly', 'https://images.unsplash.com/photo-1503676260728-1c00da094a0b?w=900&q=80')); ?>" alt="Learning Together">
        <div class="gallery-label">Morning Assembly</div>
      </div>
      <div class="gallery-item reveal reveal-d1">
        <img src="<?php echo esc_url(kpms_get_section_image('gallery_library', 'https://images.unsplash.com/photo-1497633762265-9d179a990aa6?w=600&q=80')); ?>" alt="Library">
        <div class="gallery-label">Library</div>
      </div>
      <div class="gallery-item reveal reveal-d2">
        <img src="<?php echo esc_url(kpms_get_section_image('gallery_classrooms', 'https://images.unsplash.com/photo-1588075592446-265fd1e6e76f?w=600&q=80')); ?>" alt="Classroom">
        <div class="gallery-label">Classrooms</div>
      </div>
      <div class="gallery-item reveal reveal-d1">
        <img src="<?php echo esc_url(kpms_get_section_image('gallery_art_studio', 'https://images.unsplash.com/photo-1571260899304-425eee4c7efc?w=600&q=80')); ?>" alt="Art Studio">
        <div class="gallery-label">Art Studio</div>
      </div>
      <div class="gallery-item reveal reveal-d2">
        <img src="<?php echo esc_url(kpms_get_section_image('gallery_outdoor_learning', 'https://images.unsplash.com/photo-1544717305-2782549b5136?w=600&q=80')); ?>" alt="Students Reading">
        <div class="gallery-label">Outdoor Learning</div>
      </div>
      <div class="gallery-item reveal reveal-d3">
        <img src="<?php echo esc_url(kpms_get_section_image('gallery_play_area', 'https://images.unsplash.com/photo-1564429238961-bf8eada3e2e6?w=900&q=80')); ?>" alt="Play Area">
        <div class="gallery-label">Play &amp; Recreation</div>
      </div>
    </div>
  </div>
</section>

<!-- IN THE NEWS -->
<section class="news">
  <div class="news-inner">
    <div class="news-header">
      <div>
        <div class="section-label reveal">In the News</div>
        <h2 class="section-title reveal reveal-d1">Stories from Our Community</h2>
      </div>
      <a href="/news/" class="news-link reveal">View All News →</a>
    </div>
    <div class="news-grid">
      <div class="news-card reveal">
        <div class="news-img">
          <img src="<?php echo esc_url(kpms_get_section_image('news_card_1', 'https://images.unsplash.com/photo-1513364776144-60967b0f800f?w=600&q=80')); ?>" alt="Art Exhibition">
        </div>
        <div class="news-body">
          <div class="news-tag">Arts</div>
          <h3 class="news-title">Annual Art Exhibition Showcases Young Talent</h3>
          <div class="news-date">February 10, 2026</div>
        </div>
      </div>
      <div class="news-card reveal reveal-d1">
        <div class="news-img">
          <img src="<?php echo esc_url(kpms_get_section_image('news_card_2', 'https://images.unsplash.com/photo-1427504494785-3a9ca7044f45?w=600&q=80')); ?>" alt="Sports Day">
        </div>
        <div class="news-body">
          <div class="news-tag">Events</div>
          <h3 class="news-title">KPMS Students Shine at Regional Science Fair</h3>
          <div class="news-date">January 28, 2026</div>
        </div>
      </div>
      <div class="news-card reveal reveal-d2">
        <div class="news-img">
          <img src="<?php echo esc_url(kpms_get_section_image('news_card_3', 'https://images.unsplash.com/photo-1516627145497-ae6968895b74?w=600&q=80')); ?>" alt="Community">
        </div>
        <div class="news-body">
          <div class="news-tag">Community</div>
          <h3 class="news-title">Celebrating 40 Years of Excellence in Education</h3>
          <div class="news-date">January 15, 2026</div>
        </div>
      </div>
    </div>
  </div>
</section>

<?php
// ===== FACULTY CAROUSEL — DATABASE DRIVEN =====
global $wpdb;
$staff_table = $wpdb->prefix . 'kpms_staff';

// Show staff marked "Feature on Homepage"
$carousel_staff = $wpdb->get_results(
    "SELECT * FROM {$staff_table} WHERE is_active = 1 AND featured_on_homepage = 1 ORDER BY display_order ASC, id ASC LIMIT 10"
);

// Fallback: if no one is featured, show leadership
if (empty($carousel_staff)) {
    $carousel_staff = $wpdb->get_results(
        "SELECT * FROM {$staff_table} WHERE is_active = 1 AND category = 'leadership' ORDER BY display_order ASC, id ASC LIMIT 8"
    );
}

$total_slides = count($carousel_staff);
$first = !empty($carousel_staff) ? $carousel_staff[0] : null;

if ($first):
    // Determine prev/next for initial thumbnails
    $prev_staff = $carousel_staff[$total_slides - 1];
    $next_staff = $total_slides > 1 ? $carousel_staff[1] : $first;

    // Helper: get photo or empty string
    $first_photo = !empty($first->photo_url) ? $first->photo_url : '';
    $prev_photo = !empty($prev_staff->photo_url) ? $prev_staff->photo_url : '';
    $next_photo = !empty($next_staff->photo_url) ? $next_staff->photo_url : '';
    $first_quote = !empty($first->quote) ? $first->quote : 'Dedicated to inspiring the next generation of learners.';
    $first_title = !empty($first->title) ? $first->title : $first->department;

    // Build the JS data array from the same query
    $faculty_json = array();
    foreach ($carousel_staff as $fs) {
        $faculty_json[] = array(
            'name'   => $fs->name,
            'title'  => !empty($fs->title) ? $fs->title : $fs->department,
            'photo'  => !empty($fs->photo_url) ? $fs->photo_url : '',
            'thumb'  => !empty($fs->photo_url) ? $fs->photo_url : '',
            'quote'  => !empty($fs->quote) ? $fs->quote : 'Dedicated to inspiring the next generation of learners.',
            'dept'   => $fs->department,
            'degree' => $fs->qualifications,
            'email'  => !empty($fs->email) ? $fs->email : '',
            'phone'  => !empty($fs->phone) ? $fs->phone : '',
            'color'  => !empty($fs->circle_color) ? $fs->circle_color : '#003087',
            'initials' => function_exists('kpms_get_initials') ? kpms_get_initials($fs->name) : strtoupper(mb_substr($fs->name, 0, 2)),
        );
    }
?>
<!-- FACULTY SHOWCASE -->
<section class="faculty-showcase" id="facultyShowcase">
  <div class="faculty-showcase-header">
    <div class="section-label reveal">Our Educators</div>
    <h2 class="section-title reveal reveal-d1">Meet the Educators Who Inspire</h2>
    <p class="faculty-showcase-subtitle reveal reveal-d2">The heart of KPMS is our dedicated faculty</p>
  </div>
  <div class="faculty-carousel reveal">
    <div class="faculty-photo-side">
      <div class="faculty-photo-main">
        <?php if ($first_photo): ?>
          <img id="facultyMainImg" src="<?php echo esc_url($first_photo); ?>" alt="<?php echo esc_attr($first->name); ?>">
        <?php else: ?>
          <img id="facultyMainImg" src="" alt="<?php echo esc_attr($first->name); ?>" style="display:none;">
          <div id="facultyMainPlaceholder" style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;background:<?php echo esc_attr($first->circle_color ?: '#003087'); ?>;font-size:80px;font-weight:700;color:#fff;font-family:'DM Sans',sans-serif;">
            <?php echo esc_html(function_exists('kpms_get_initials') ? kpms_get_initials($first->name) : strtoupper(mb_substr($first->name, 0, 2))); ?>
          </div>
        <?php endif; ?>
      </div>
      <?php if ($total_slides > 1): ?>
      <div class="faculty-photo-prev" id="facultyPrevThumb" title="Previous">
        <?php if ($prev_photo): ?>
          <img src="<?php echo esc_url($prev_photo); ?>" alt="Previous">
        <?php else: ?>
          <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;background:<?php echo esc_attr($prev_staff->circle_color ?: '#003087'); ?>;font-size:18px;font-weight:700;color:#fff;">
            <?php echo esc_html(function_exists('kpms_get_initials') ? kpms_get_initials($prev_staff->name) : strtoupper(mb_substr($prev_staff->name, 0, 2))); ?>
          </div>
        <?php endif; ?>
      </div>
      <div class="faculty-photo-next" id="facultyNextThumb" title="Next">
        <?php if ($next_photo): ?>
          <img src="<?php echo esc_url($next_photo); ?>" alt="Next">
        <?php else: ?>
          <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;background:<?php echo esc_attr($next_staff->circle_color ?: '#003087'); ?>;font-size:18px;font-weight:700;color:#fff;">
            <?php echo esc_html(function_exists('kpms_get_initials') ? kpms_get_initials($next_staff->name) : strtoupper(mb_substr($next_staff->name, 0, 2))); ?>
          </div>
        <?php endif; ?>
      </div>
      <?php endif; ?>
      <div class="faculty-info-name">
        <h3 id="facultyName"><?php echo esc_html($first->name); ?></h3>
        <span id="facultyTitle"><?php echo esc_html($first_title); ?></span>
        <div><a class="faculty-profile-link" onclick="openFacultyModal()">View Full Profile</a></div>
      </div>
    </div>
    <div class="faculty-quote-side">
      <div class="faculty-quote-marks">&ldquo;</div>
      <div class="faculty-quote-text" id="facultyQuote"><?php echo esc_html($first_quote); ?></div>
      <div class="faculty-carousel-nav">
        <button class="faculty-nav-btn" onclick="prevFaculty()" aria-label="Previous faculty">&#8592;</button>
        <button class="faculty-nav-btn" onclick="nextFaculty()" aria-label="Next faculty">&#8594;</button>
        <div class="faculty-nav-dots" id="facultyDots">
          <?php for ($i = 0; $i < $total_slides; $i++): ?>
          <div class="faculty-nav-dot<?php echo $i === 0 ? ' active' : ''; ?>" onclick="goToFaculty(<?php echo $i; ?>)"></div>
          <?php endfor; ?>
        </div>
        <a href="/staff-directory/" class="faculty-explore-link">Explore All Our Faculty &rarr;</a>
      </div>
    </div>
  </div>
</section>
<?php endif; ?>

<!-- FACULTY MODAL -->
<div class="faculty-modal-overlay" id="facultyModal">
  <div class="faculty-modal">
    <button class="faculty-modal-close" onclick="closeFacultyModal()" aria-label="Close">&times;</button>
    <div class="faculty-modal-top">
      <div class="faculty-modal-photo">
        <img id="modalPhoto" src="" alt="Faculty Photo">
      </div>
      <div class="faculty-modal-info">
        <h2 id="modalName"></h2>
        <div class="modal-title" id="modalTitle"></div>
        <div class="modal-contact">
          <a id="modalEmail" href="#"><span>&#9993;</span> Email Me</a>
          <a id="modalPhone" href="#"><span>&#9742;</span> <span id="modalPhoneText"></span></a>
        </div>
      </div>
    </div>
    <div class="faculty-modal-details">
      <div class="detail-row">
        <div>
          <div class="detail-label">Department(s)</div>
          <div class="detail-value" id="modalDept"></div>
        </div>
        <div>
          <div class="detail-label">Degree(s)</div>
          <div class="detail-value" id="modalDegree"></div>
        </div>
      </div>
      <div class="detail-label">Biography</div>
      <div class="faculty-modal-bio">
        <span class="bio-quote-mark">&ldquo;</span>
        <p id="modalBio"></p>
      </div>
    </div>
  </div>
</div>

<!-- CTA — FIND YOUR KPMS -->
<section class="cta">
  <div class="cta-label reveal">Find Your KPMS</div>
  <h2 class="cta-title reveal reveal-d1">Begin Your Child's Journey Today</h2>
  <div class="cta-actions reveal reveal-d2">
    <a href="/campus/" class="btn btn-white">Visit</a>
    <a href="/enrollment/" class="btn btn-outline-light">Apply</a>
    <a href="/donate/" class="btn btn-outline-light">Donate</a>
  </div>
</section>

<!-- HIRING BANNER -->
<section style="background: linear-gradient(135deg, var(--gold) 0%, var(--gold-warm) 100%); padding: 40px 60px; text-align: center;">
  <div style="max-width: 900px; margin: 0 auto; display: flex; align-items: center; justify-content: center; gap: 24px; flex-wrap: wrap;">
    <div style="font-size: 36px;">&#x1F4BC;</div>
    <div style="text-align: left;">
      <div style="font-family: 'Playfair Display', serif; font-size: 22px; font-weight: 700; color: var(--navy-deep);">We're Hiring!</div>
      <p style="font-size: 15px; color: var(--navy); margin: 4px 0 0;">Join our team of passionate educators. Multiple positions available.</p>
    </div>
    <a href="/careers/" style="background: var(--navy-deep); color: var(--white); padding: 12px 28px; border-radius: 8px; font-weight: 700; font-size: 14px; text-decoration: none; letter-spacing: 0.5px; transition: all 0.3s; white-space: nowrap;">VIEW OPENINGS</a>
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
// ===== CONTINUOUS TICKER SCROLL =====
(function() {
    var belt = document.getElementById('kpmsTickerBelt');
    if (!belt) return;
    requestAnimationFrame(function() {
        var halfWidth = belt.scrollWidth / 2;
        var speed = 50;
        var position = 0;
        var paused = false;
        var lastTime = null;
        var ticker = document.getElementById('kpmsTicker');
        ticker.addEventListener('mouseenter', function() { paused = true; });
        ticker.addEventListener('mouseleave', function() { paused = false; lastTime = null; });
        function animate(timestamp) {
            if (!paused) {
                if (lastTime === null) lastTime = timestamp;
                var delta = (timestamp - lastTime) / 1000;
                lastTime = timestamp;
                position -= speed * delta;
                if (Math.abs(position) >= halfWidth) {
                    position += halfWidth;
                }
                belt.style.transform = 'translateX(' + position + 'px)';
            } else {
                lastTime = null;
            }
            requestAnimationFrame(animate);
        }
        requestAnimationFrame(animate);
    });
})();

// ===== VIDEO PLAYER =====
(function() {
    var box = document.getElementById('kpmsVideoBox');
    if (!box) return;
    box.addEventListener('click', function() {
        var poster = document.getElementById('kpmsVideoPoster');
        var playBtn = document.getElementById('kpmsVideoPlay');
        if (poster) poster.style.display = 'none';
        if (playBtn) playBtn.style.display = 'none';
        var existing = box.querySelector('video');
        if (existing) return;
        var video = document.createElement('video');
        video.src = '<?php echo esc_url(get_option("kpms_section_image_video_tour_url", "https://kpms.edu.pk/wp-content/uploads/2026/03/8499683-hd_1920_1080_30fps.mp4")); ?>';
        video.controls = true;
        video.autoplay = true;
        video.style.cssText = 'width:100%;height:100%;object-fit:cover;position:absolute;inset:0;border-radius:16px;';
        box.appendChild(video);
    });
})();

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

<?php if ($first): ?>
<script>
// ===== FACULTY CAROUSEL (Database-Driven) =====
const facultyData = <?php echo wp_json_encode($faculty_json); ?>;

let currentFaculty = 0;
let facultyAutoplay = null;

// Helper: set an element to show a photo or initials placeholder
function setFacultyImage(container, f, size) {
  if (!container) return;
  if (f.photo) {
    // Show img, hide any placeholder
    var img = container.querySelector('img');
    var ph = container.querySelector('.faculty-initials-ph');
    if (img) { img.src = f.photo; img.alt = f.name; img.style.display = ''; }
    if (ph) ph.style.display = 'none';
    // If no img tag exists (was placeholder-only initially), create one
    if (!img && f.photo) {
      img = document.createElement('img');
      img.src = f.photo; img.alt = f.name;
      img.style.cssText = 'width:100%;height:100%;object-fit:cover;';
      container.insertBefore(img, container.firstChild);
      if (ph) ph.style.display = 'none';
    }
  } else {
    // No photo — show initials placeholder
    var img = container.querySelector('img');
    var ph = container.querySelector('.faculty-initials-ph');
    if (img) img.style.display = 'none';
    if (!ph) {
      ph = document.createElement('div');
      ph.className = 'faculty-initials-ph';
      ph.style.cssText = 'width:100%;height:100%;display:flex;align-items:center;justify-content:center;background:' + (f.color || '#003087') + ';font-weight:700;color:#fff;font-family:DM Sans,sans-serif;';
      ph.style.fontSize = size === 'large' ? '80px' : '18px';
      container.appendChild(ph);
    } else {
      ph.style.display = 'flex';
      ph.style.background = f.color || '#003087';
    }
    ph.textContent = f.initials || f.name.charAt(0);
  }
}

function updateFaculty(index) {
  var f = facultyData[index];
  var prevIdx = (index - 1 + facultyData.length) % facultyData.length;
  var nextIdx = (index + 1) % facultyData.length;

  var mainContainer = document.querySelector('.faculty-photo-main');
  var quoteEl = document.getElementById('facultyQuote');

  // Fade out
  if (mainContainer) mainContainer.style.opacity = '0';
  if (quoteEl) quoteEl.style.opacity = '0';

  setTimeout(function() {
    // Main photo
    setFacultyImage(mainContainer, f, 'large');

    // Name & title
    document.getElementById('facultyName').textContent = f.name;
    document.getElementById('facultyTitle').textContent = f.title;
    if (quoteEl) quoteEl.textContent = f.quote;

    // Prev/next thumbnails
    var prevThumb = document.getElementById('facultyPrevThumb');
    var nextThumb = document.getElementById('facultyNextThumb');
    if (prevThumb) setFacultyImage(prevThumb, facultyData[prevIdx], 'small');
    if (nextThumb) setFacultyImage(nextThumb, facultyData[nextIdx], 'small');

    // Dots
    var dots = document.querySelectorAll('.faculty-nav-dot');
    dots.forEach(function(d, i) { d.classList.toggle('active', i === index); });

    // Fade in
    if (mainContainer) mainContainer.style.opacity = '1';
    if (quoteEl) quoteEl.style.opacity = '1';
  }, 300);

  currentFaculty = index;
}

function nextFaculty() { updateFaculty((currentFaculty + 1) % facultyData.length); resetAutoplay(); }
function prevFaculty() { updateFaculty((currentFaculty - 1 + facultyData.length) % facultyData.length); resetAutoplay(); }
function goToFaculty(i) { updateFaculty(i); resetAutoplay(); }

function startAutoplay() { facultyAutoplay = setInterval(function() { updateFaculty((currentFaculty + 1) % facultyData.length); }, 6000); }
function resetAutoplay() { clearInterval(facultyAutoplay); startAutoplay(); }

function openFacultyModal() {
  var f = facultyData[currentFaculty];
  var modalPhoto = document.getElementById('modalPhoto');
  if (f.photo) {
    modalPhoto.src = f.photo;
    modalPhoto.style.display = '';
  } else {
    modalPhoto.style.display = 'none';
  }
  document.getElementById('modalName').textContent = f.name;
  document.getElementById('modalTitle').textContent = f.title;
  document.getElementById('modalDept').textContent = f.dept;
  document.getElementById('modalDegree').textContent = f.degree;
  document.getElementById('modalBio').textContent = f.quote;

  var emailEl = document.getElementById('modalEmail');
  if (f.email) {
    emailEl.href = 'mailto:' + f.email;
    emailEl.innerHTML = '<span>&#9993;</span> ' + f.email;
    emailEl.style.display = '';
  } else {
    emailEl.style.display = 'none';
  }

  var phoneEl = document.getElementById('modalPhone');
  if (f.phone) {
    phoneEl.style.display = 'inline-flex';
    phoneEl.href = 'tel:' + f.phone;
    document.getElementById('modalPhoneText').textContent = f.phone;
  } else {
    phoneEl.style.display = 'none';
  }

  document.getElementById('facultyModal').classList.add('open');
  document.body.style.overflow = 'hidden';
}

function closeFacultyModal() {
  document.getElementById('facultyModal').classList.remove('open');
  document.body.style.overflow = '';
}

document.getElementById('facultyModal').addEventListener('click', function(e) {
  if (e.target === this) closeFacultyModal();
});

var prevThumbEl = document.getElementById('facultyPrevThumb');
var nextThumbEl = document.getElementById('facultyNextThumb');
if (prevThumbEl) prevThumbEl.addEventListener('click', prevFaculty);
if (nextThumbEl) nextThumbEl.addEventListener('click', nextFaculty);

// Add fade transition to main photo container
var mainPhotoEl = document.querySelector('.faculty-photo-main');
if (mainPhotoEl) mainPhotoEl.style.transition = 'opacity 0.3s ease';

// Start autoplay
if (facultyData.length > 1) startAutoplay();
</script>
<?php endif; ?>


</body>
</html>
