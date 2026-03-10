<?php
/*
Template Name: KPMS - Learning Games
*/
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Learning Games – KPMS | Kamal Public Middle School Abbottabad</title>
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
  padding: 140px 60px 80px;
  text-align: center;
  position: relative;
  overflow: hidden;
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

/* ===== GAMES HERO (playful gradient) ===== */
.games-hero {
  background: linear-gradient(135deg, #003087 0%, #1a5fcc 25%, #00AEEF 50%, #2878e6 75%, #003087 100%);
  position: relative;
}
.games-hero::before {
  content: '';
  position: absolute; inset: 0;
  background:
    radial-gradient(circle at 15% 30%, rgba(255,209,0,0.2) 0%, transparent 40%),
    radial-gradient(circle at 85% 60%, rgba(232,68,58,0.15) 0%, transparent 35%),
    radial-gradient(circle at 50% 80%, rgba(0,174,239,0.2) 0%, transparent 40%);
  pointer-events: none;
}
.games-hero .page-hero-label,
.games-hero .page-hero-title,
.games-hero .page-hero-subtitle,
.games-hero .page-breadcrumb,
.games-hero .hero-emoji {
  position: relative; z-index: 2;
}
.hero-emoji {
  font-size: 56px;
  margin-bottom: 16px;
  display: block;
  animation: heroBounce 2s ease-in-out infinite;
}
@keyframes heroBounce {
  0%, 100% { transform: translateY(0) rotate(0deg); }
  25% { transform: translateY(-10px) rotate(-3deg); }
  75% { transform: translateY(-10px) rotate(3deg); }
}
.floating-emoji {
  position: absolute;
  font-size: 32px;
  opacity: 0.25;
  animation: floatEmoji 6s ease-in-out infinite;
  pointer-events: none;
  z-index: 1;
}
@keyframes floatEmoji {
  0%, 100% { transform: translateY(0) rotate(0deg); }
  50% { transform: translateY(-20px) rotate(15deg); }
}

/* ===== CATEGORY FILTER BAR ===== */
.filter-bar {
  padding: 0 60px;
  background: var(--white);
  border-bottom: 2px solid var(--ice);
  position: sticky;
  top: 85px;
  z-index: 100;
}
.filter-bar-inner {
  max-width: 1200px;
  margin: 0 auto;
  display: flex;
  align-items: center;
  gap: 8px;
  padding: 16px 0;
  overflow-x: auto;
  -webkit-overflow-scrolling: touch;
}
.filter-btn {
  padding: 10px 24px;
  border-radius: 50px;
  font-family: 'DM Sans', sans-serif;
  font-size: 14px;
  font-weight: 600;
  border: 2px solid var(--ice);
  background: var(--white);
  color: var(--text-muted);
  cursor: pointer;
  transition: all 0.3s cubic-bezier(0.16,1,0.3,1);
  white-space: nowrap;
  display: flex;
  align-items: center;
  gap: 6px;
}
.filter-btn:hover {
  border-color: var(--blue-light);
  color: var(--blue);
  background: var(--ice);
}
.filter-btn.active {
  background: var(--blue);
  color: var(--white);
  border-color: var(--blue);
  box-shadow: 0 4px 16px rgba(0,48,135,0.25);
}
.filter-btn .filter-emoji {
  font-size: 16px;
}

/* ===== GAMES GRID ===== */
.games-section {
  padding: 60px;
  max-width: 1300px;
  margin: 0 auto;
}
.games-grid {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 24px;
}
.game-card {
  background: var(--white);
  border: 2px solid var(--ice);
  border-radius: 20px;
  padding: 32px 24px 28px;
  text-align: center;
  transition: all 0.4s cubic-bezier(0.16,1,0.3,1);
  position: relative;
  overflow: hidden;
  text-decoration: none;
  display: block;
}
.game-card::before {
  content: '';
  position: absolute;
  top: 0; left: 0; right: 0;
  height: 4px;
  border-radius: 20px 20px 0 0;
  transition: height 0.3s ease;
}
.game-card[data-category="math"]::before { background: linear-gradient(90deg, #FF6B6B, #FFD93D); }
.game-card[data-category="science"]::before { background: linear-gradient(90deg, #6BCB77, #00AEEF); }
.game-card[data-category="english"]::before { background: linear-gradient(90deg, #A66CFF, #FF6B9D); }
.game-card[data-category="coding"]::before { background: linear-gradient(90deg, #00AEEF, #4D96FF); }
.game-card[data-category="general"]::before { background: linear-gradient(90deg, #FFD93D, #FF914D); }
.game-card:hover::before { height: 6px; }
.game-card:hover {
  border-color: var(--blue-light);
  box-shadow: 0 20px 60px rgba(0,48,135,0.12);
  transform: translateY(-8px);
}
.game-card-emoji {
  font-size: 52px;
  display: block;
  margin-bottom: 16px;
  transition: transform 0.4s cubic-bezier(0.16,1,0.3,1);
}
.game-card:hover .game-card-emoji {
  transform: scale(1.25) rotate(-5deg);
}
.game-card h3 {
  font-family: 'Playfair Display', serif;
  font-size: 18px;
  font-weight: 600;
  color: var(--text);
  margin: 0 0 8px;
}
.game-card .game-desc {
  font-size: 14px;
  color: var(--text-muted);
  line-height: 1.6;
  margin: 0 0 16px;
}
.game-card .game-category-badge {
  display: inline-block;
  padding: 4px 14px;
  border-radius: 20px;
  font-size: 11px;
  font-weight: 700;
  letter-spacing: 0.5px;
  text-transform: uppercase;
}
.badge-math { background: #fff0f0; color: #d63031; }
.badge-science { background: #e8f8ee; color: #00a854; }
.badge-english { background: #f0e6ff; color: #7c3aed; }
.badge-coding { background: #e0f4ff; color: #0284c7; }
.badge-general { background: #fff7e0; color: #d97706; }

.game-card .play-indicator {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  margin-top: 14px;
  font-size: 13px;
  font-weight: 700;
  color: var(--blue);
  letter-spacing: 0.5px;
  text-transform: uppercase;
  opacity: 0;
  transform: translateY(8px);
  transition: all 0.3s ease;
}
.game-card:hover .play-indicator {
  opacity: 1;
  transform: translateY(0);
}
.play-indicator svg {
  width: 16px; height: 16px;
  fill: var(--blue);
}

/* Hide cards when filtered out */
.game-card.hidden {
  display: none;
}

/* ===== FEATURED GAME ===== */
.featured-section {
  padding: 80px 60px;
  background: var(--cream-warm);
}
.featured-inner {
  max-width: 1100px;
  margin: 0 auto;
}
.featured-card {
  background: var(--white);
  border-radius: 24px;
  overflow: hidden;
  box-shadow: 0 16px 60px rgba(0,48,135,0.08);
  display: grid;
  grid-template-columns: 1fr 1fr;
  align-items: center;
  border: 2px solid var(--ice);
  transition: all 0.4s cubic-bezier(0.16,1,0.3,1);
}
.featured-card:hover {
  box-shadow: 0 24px 80px rgba(0,48,135,0.14);
  transform: translateY(-4px);
}
.featured-visual {
  background: linear-gradient(135deg, #003087, #00AEEF);
  padding: 60px 40px;
  text-align: center;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  min-height: 320px;
  position: relative;
  overflow: hidden;
}
.featured-visual::before {
  content: '';
  position: absolute; inset: 0;
  background: radial-gradient(circle at 30% 40%, rgba(255,209,0,0.15), transparent 60%);
}
.featured-visual .featured-emoji {
  font-size: 80px;
  position: relative;
  z-index: 1;
  animation: heroBounce 3s ease-in-out infinite;
}
.featured-visual .featured-badge {
  position: relative; z-index: 1;
  display: inline-block;
  background: var(--gold);
  color: var(--navy-deep);
  padding: 8px 24px;
  border-radius: 50px;
  font-size: 12px;
  font-weight: 700;
  letter-spacing: 2px;
  text-transform: uppercase;
  margin-top: 20px;
}
.featured-content {
  padding: 48px 40px;
}
.featured-content .featured-week-label {
  font-size: 12px;
  font-weight: 700;
  letter-spacing: 3px;
  text-transform: uppercase;
  color: var(--coral);
  margin-bottom: 12px;
}
.featured-content h3 {
  font-family: 'Playfair Display', serif;
  font-size: 28px;
  font-weight: 600;
  color: var(--text);
  margin: 0 0 12px;
}
.featured-content p {
  font-size: 16px;
  color: var(--text-muted);
  line-height: 1.8;
  margin: 0 0 8px;
}
.featured-highlights {
  list-style: none;
  padding: 0;
  margin: 20px 0 28px;
}
.featured-highlights li {
  padding: 8px 0 8px 28px;
  position: relative;
  font-size: 14px;
  color: var(--text-muted);
  line-height: 1.6;
}
.featured-highlights li::before {
  content: '\2605';
  position: absolute;
  left: 0;
  color: var(--gold);
  font-size: 14px;
}

/* ===== SAFETY NOTICE ===== */
.safety-section {
  padding: 80px 60px;
}
.safety-inner {
  max-width: 900px;
  margin: 0 auto;
}
.safety-card {
  background: linear-gradient(135deg, #fff9e0, #fff3cc);
  border: 2px solid #ffe082;
  border-radius: 24px;
  padding: 48px 48px 44px;
  position: relative;
  overflow: hidden;
}
.safety-card::before {
  content: '';
  position: absolute;
  top: -30px; right: -30px;
  width: 120px; height: 120px;
  background: rgba(255,209,0,0.2);
  border-radius: 50%;
}
.safety-card::after {
  content: '';
  position: absolute;
  bottom: -20px; left: -20px;
  width: 80px; height: 80px;
  background: rgba(232,68,58,0.1);
  border-radius: 50%;
}
.safety-header {
  display: flex;
  align-items: center;
  gap: 16px;
  margin-bottom: 20px;
  position: relative;
  z-index: 1;
}
.safety-header .safety-icon {
  font-size: 40px;
}
.safety-header h3 {
  font-family: 'Playfair Display', serif;
  font-size: 24px;
  font-weight: 600;
  color: var(--text);
  margin: 0;
}
.safety-tips {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 16px;
  position: relative;
  z-index: 1;
}
.safety-tip {
  display: flex;
  align-items: flex-start;
  gap: 12px;
  background: var(--white);
  border-radius: 14px;
  padding: 20px;
  border: 1px solid rgba(255,209,0,0.3);
  transition: all 0.3s;
}
.safety-tip:hover {
  box-shadow: 0 8px 24px rgba(0,0,0,0.06);
  transform: translateY(-2px);
}
.safety-tip .tip-emoji {
  font-size: 28px;
  flex-shrink: 0;
}
.safety-tip .tip-text {
  font-size: 14px;
  color: var(--text-muted);
  line-height: 1.6;
}
.safety-tip .tip-text strong {
  display: block;
  color: var(--text);
  font-size: 15px;
  margin-bottom: 4px;
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
  .games-grid { grid-template-columns: repeat(3, 1fr); }
}

@media (max-width: 900px) {
  .nav-inner { padding-left: 30px !important; padding-right: 30px !important; }
  .games-grid { grid-template-columns: repeat(2, 1fr); }
  .featured-card { grid-template-columns: 1fr; }
  .featured-visual { min-height: 220px; padding: 40px 24px; }
  .featured-content { padding: 36px 28px; }
  .safety-tips { grid-template-columns: 1fr; }
  .footer-grid { grid-template-columns: 1fr 1fr; }
  .filter-bar { padding: 0 30px; top: 64px; }
  .games-section { padding: 40px 30px; }
  .featured-section { padding: 60px 30px; }
  .safety-section { padding: 60px 30px; }
}

@media (max-width: 600px) {
  .topbar { display: none; }
  .nav-menu { display: none; }
  .nav-search-btn { display: none; }
  .mobile-toggle { display: block; }
  .nav-inner { padding: 0 20px !important; height: 64px; }
  .page-hero { padding: 120px 20px 60px; }
  .filter-bar { padding: 0 16px; top: 64px; }
  .filter-bar-inner { gap: 6px; padding: 12px 0; }
  .filter-btn { padding: 8px 16px; font-size: 13px; }
  .games-section { padding: 30px 16px; }
  .games-grid { grid-template-columns: 1fr; max-width: 400px; margin: 0 auto; }
  .game-card { padding: 28px 20px 24px; }
  .featured-section { padding: 40px 16px; }
  .featured-content { padding: 28px 20px; }
  .featured-content h3 { font-size: 22px; }
  .safety-section { padding: 40px 16px; }
  .safety-card { padding: 32px 24px 28px; }
  .safety-tips { grid-template-columns: 1fr; }
  .footer { padding: 50px 20px 28px; }
  .footer-grid { grid-template-columns: 1fr; gap: 32px; }
  .footer-bottom { flex-direction: column; text-align: center; }
  .cta { padding: 50px 20px; }
  .cta-actions { flex-direction: column; align-items: center; }
  .hero-emoji { font-size: 44px; }
  .floating-emoji { display: none; }
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
        <a href="#">Students <span class="dropdown-arrow">&#x25BC;</span></a>
        <div class="dropdown">
          <a href="/student-resources/">Resources</a>
          <a href="/student-games/">Learning Games</a>
        </div>
      </li>
      <li>
        <a href="#">Support <span class="dropdown-arrow">&#x25BC;</span></a>
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
    <input type="text" placeholder="Search games, resources, pages..." id="searchInput" aria-label="Search the site">
    <button class="search-close" onclick="toggleSearch()" aria-label="Close search">&#x2715;</button>
  </div>
  <div class="search-hint">Press ESC to close</div>
</div>

<?php include get_stylesheet_directory() . '/mobile-menu.php'; ?>


<!-- ===================== PAGE HERO ===================== -->
<section class="page-hero games-hero" id="main-content">
  <!-- Floating background emojis -->
  <span class="floating-emoji" style="top:15%; left:8%; animation-delay:0s;">&#x1F3AE;</span>
  <span class="floating-emoji" style="top:25%; right:12%; animation-delay:1.2s; font-size:28px;">&#x1F9E9;</span>
  <span class="floating-emoji" style="bottom:20%; left:15%; animation-delay:2.4s; font-size:36px;">&#x1F680;</span>
  <span class="floating-emoji" style="top:40%; right:6%; animation-delay:0.8s; font-size:26px;">&#x2B50;</span>
  <span class="floating-emoji" style="bottom:30%; right:20%; animation-delay:1.8s; font-size:30px;">&#x1F4A1;</span>
  <span class="floating-emoji" style="top:60%; left:5%; animation-delay:3s; font-size:24px;">&#x1F3C6;</span>

  <span class="hero-emoji">&#x1F3AE;</span>
  <div class="page-hero-label">Fun Learning</div>
  <h1 class="page-hero-title">Learning Games</h1>
  <p class="page-hero-subtitle">Play, learn, and grow with fun educational games!</p>
  <div class="page-breadcrumb"><a href="/">Home</a> / <a href="/student-resources/">Students</a> / Learning Games</div>
</section>


<!-- ===================== CATEGORY FILTER BAR ===================== -->
<div class="filter-bar" id="filterBar">
  <div class="filter-bar-inner">
    <button class="filter-btn active" data-filter="all" onclick="filterGames('all', this)">
      <span class="filter-emoji">&#x1F31F;</span> All Games
    </button>
    <button class="filter-btn" data-filter="math" onclick="filterGames('math', this)">
      <span class="filter-emoji">&#x1F4D0;</span> Math
    </button>
    <button class="filter-btn" data-filter="science" onclick="filterGames('science', this)">
      <span class="filter-emoji">&#x1F52C;</span> Science
    </button>
    <button class="filter-btn" data-filter="english" onclick="filterGames('english', this)">
      <span class="filter-emoji">&#x1F4DA;</span> English
    </button>
    <button class="filter-btn" data-filter="coding" onclick="filterGames('coding', this)">
      <span class="filter-emoji">&#x1F4BB;</span> Coding
    </button>
    <button class="filter-btn" data-filter="general" onclick="filterGames('general', this)">
      <span class="filter-emoji">&#x1F9E0;</span> General Knowledge
    </button>
  </div>
</div>


<!-- ===================== GAMES GRID ===================== -->
<section class="games-section">
  <div class="games-grid" id="gamesGrid">

    <!-- ===== MATH GAMES ===== -->
    <a href="https://www.prodigygame.com" target="_blank" rel="noopener noreferrer" class="game-card reveal reveal-d1" data-category="math">
      <span class="game-card-emoji">&#x1F9D9;</span>
      <h3>Prodigy Math</h3>
      <p class="game-desc">Adventure-based math game</p>
      <span class="game-category-badge badge-math">Math</span>
      <div class="play-indicator">
        <svg viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg> Play Now
      </div>
    </a>

    <a href="https://www.mathplayground.com" target="_blank" rel="noopener noreferrer" class="game-card reveal reveal-d2" data-category="math">
      <span class="game-card-emoji">&#x1F3AF;</span>
      <h3>Math Playground</h3>
      <p class="game-desc">Fun math games and puzzles</p>
      <span class="game-category-badge badge-math">Math</span>
      <div class="play-indicator">
        <svg viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg> Play Now
      </div>
    </a>

    <a href="https://www.coolmathgames.com" target="_blank" rel="noopener noreferrer" class="game-card reveal reveal-d3" data-category="math">
      <span class="game-card-emoji">&#x1F9CA;</span>
      <h3>Cool Math Games</h3>
      <p class="game-desc">Math-based puzzle games</p>
      <span class="game-category-badge badge-math">Math</span>
      <div class="play-indicator">
        <svg viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg> Play Now
      </div>
    </a>

    <a href="https://www.multiplication.com" target="_blank" rel="noopener noreferrer" class="game-card reveal reveal-d4" data-category="math">
      <span class="game-card-emoji">&#x2716;</span>
      <h3>Multiplication.com</h3>
      <p class="game-desc">Master multiplication tables</p>
      <span class="game-category-badge badge-math">Math</span>
      <div class="play-indicator">
        <svg viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg> Play Now
      </div>
    </a>

    <!-- ===== SCIENCE GAMES ===== -->
    <a href="https://pbskids.org/games/science" target="_blank" rel="noopener noreferrer" class="game-card reveal reveal-d1" data-category="science">
      <span class="game-card-emoji">&#x1F52C;</span>
      <h3>PBS Science Games</h3>
      <p class="game-desc">Explore science concepts</p>
      <span class="game-category-badge badge-science">Science</span>
      <div class="play-indicator">
        <svg viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg> Play Now
      </div>
    </a>

    <a href="https://kids.nationalgeographic.com/games" target="_blank" rel="noopener noreferrer" class="game-card reveal reveal-d2" data-category="science">
      <span class="game-card-emoji">&#x1F30D;</span>
      <h3>National Geographic Kids</h3>
      <p class="game-desc">Nature and science games</p>
      <span class="game-category-badge badge-science">Science</span>
      <div class="play-indicator">
        <svg viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg> Play Now
      </div>
    </a>

    <a href="https://mysteryscience.com" target="_blank" rel="noopener noreferrer" class="game-card reveal reveal-d3" data-category="science">
      <span class="game-card-emoji">&#x1F50E;</span>
      <h3>Mystery Science</h3>
      <p class="game-desc">Science mystery challenges</p>
      <span class="game-category-badge badge-science">Science</span>
      <div class="play-indicator">
        <svg viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg> Play Now
      </div>
    </a>

    <!-- ===== ENGLISH & READING ===== -->
    <a href="https://www.vocabulary.com" target="_blank" rel="noopener noreferrer" class="game-card reveal reveal-d1" data-category="english">
      <span class="game-card-emoji">&#x1F4D6;</span>
      <h3>Vocabulary.com</h3>
      <p class="game-desc">Build your word power</p>
      <span class="game-category-badge badge-english">English</span>
      <div class="play-indicator">
        <svg viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg> Play Now
      </div>
    </a>

    <a href="https://www.funbrain.com" target="_blank" rel="noopener noreferrer" class="game-card reveal reveal-d2" data-category="english">
      <span class="game-card-emoji">&#x1F9E0;</span>
      <h3>Funbrain</h3>
      <p class="game-desc">Reading and word games</p>
      <span class="game-category-badge badge-english">English</span>
      <div class="play-indicator">
        <svg viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg> Play Now
      </div>
    </a>

    <a href="https://www.abcya.com" target="_blank" rel="noopener noreferrer" class="game-card reveal reveal-d3" data-category="english">
      <span class="game-card-emoji">&#x1F524;</span>
      <h3>ABCya</h3>
      <p class="game-desc">Language arts games</p>
      <span class="game-category-badge badge-english">English</span>
      <div class="play-indicator">
        <svg viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg> Play Now
      </div>
    </a>

    <!-- ===== CODING GAMES ===== -->
    <a href="https://scratch.mit.edu" target="_blank" rel="noopener noreferrer" class="game-card reveal reveal-d1" data-category="coding">
      <span class="game-card-emoji">&#x1F431;</span>
      <h3>Scratch</h3>
      <p class="game-desc">Create stories and games with code</p>
      <span class="game-category-badge badge-coding">Coding</span>
      <div class="play-indicator">
        <svg viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg> Play Now
      </div>
    </a>

    <a href="https://code.org/learn" target="_blank" rel="noopener noreferrer" class="game-card reveal reveal-d2" data-category="coding">
      <span class="game-card-emoji">&#x1F4BB;</span>
      <h3>Code.org</h3>
      <p class="game-desc">Learn to code with fun activities</p>
      <span class="game-category-badge badge-coding">Coding</span>
      <div class="play-indicator">
        <svg viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg> Play Now
      </div>
    </a>

    <a href="https://blockly.games" target="_blank" rel="noopener noreferrer" class="game-card reveal reveal-d3" data-category="coding">
      <span class="game-card-emoji">&#x1F9E9;</span>
      <h3>Blockly Games</h3>
      <p class="game-desc">Puzzle-based coding</p>
      <span class="game-category-badge badge-coding">Coding</span>
      <div class="play-indicator">
        <svg viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg> Play Now
      </div>
    </a>

    <!-- ===== GENERAL KNOWLEDGE ===== -->
    <a href="https://www.brainpop.com" target="_blank" rel="noopener noreferrer" class="game-card reveal reveal-d1" data-category="general">
      <span class="game-card-emoji">&#x1F4FA;</span>
      <h3>BrainPOP</h3>
      <p class="game-desc">Animated learning</p>
      <span class="game-category-badge badge-general">General</span>
      <div class="play-indicator">
        <svg viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg> Play Now
      </div>
    </a>

    <a href="https://www.seterra.com" target="_blank" rel="noopener noreferrer" class="game-card reveal reveal-d2" data-category="general">
      <span class="game-card-emoji">&#x1F5FA;</span>
      <h3>Seterra Geography</h3>
      <p class="game-desc">Geography quiz games</p>
      <span class="game-category-badge badge-general">General</span>
      <div class="play-indicator">
        <svg viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg> Play Now
      </div>
    </a>

    <a href="https://kahoot.it" target="_blank" rel="noopener noreferrer" class="game-card reveal reveal-d3" data-category="general">
      <span class="game-card-emoji">&#x1F3C6;</span>
      <h3>Kahoot!</h3>
      <p class="game-desc">Quiz-based learning</p>
      <span class="game-category-badge badge-general">General</span>
      <div class="play-indicator">
        <svg viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg> Play Now
      </div>
    </a>

  </div>
</section>


<!-- ===================== FEATURED GAME OF THE WEEK ===================== -->
<section class="featured-section">
  <div class="featured-inner">
    <div style="text-align:center; margin-bottom:40px;" class="reveal">
      <div class="section-label">Editor's Pick</div>
      <h2 class="section-title">Featured Game of the Week</h2>
    </div>

    <div class="featured-card reveal reveal-d1">
      <div class="featured-visual">
        <span class="featured-emoji">&#x1F431;</span>
        <span class="featured-badge">&#x2B50; This Week's Pick</span>
      </div>
      <div class="featured-content">
        <div class="featured-week-label">Featured This Week</div>
        <h3>Scratch by MIT</h3>
        <p>Scratch is a free programming language and online community where you can create your own interactive stories, games, and animations. Designed for students ages 8 to 16, it makes learning to code as fun as playing a game!</p>
        <ul class="featured-highlights">
          <li>Drag-and-drop coding blocks make it easy to start</li>
          <li>Create animations, games, and interactive stories</li>
          <li>Share your projects with a global community</li>
          <li>Learn logic, creativity, and problem-solving</li>
          <li>Used by millions of students worldwide</li>
        </ul>
        <a href="https://scratch.mit.edu" target="_blank" rel="noopener noreferrer" class="btn btn-blue">Try Scratch Now</a>
      </div>
    </div>
  </div>
</section>


<!-- ===================== SAFETY NOTICE ===================== -->
<section class="safety-section">
  <div class="safety-inner">
    <div class="safety-card reveal">
      <div class="safety-header">
        <span class="safety-icon">&#x1F6E1;</span>
        <h3>Stay Safe While Playing</h3>
      </div>
      <div class="safety-tips">
        <div class="safety-tip reveal reveal-d1">
          <span class="tip-emoji">&#x1F468;&#x200D;&#x1F469;&#x200D;&#x1F467;</span>
          <div class="tip-text">
            <strong>Play with Supervision</strong>
            Always have a parent, guardian, or teacher nearby when using online games and websites.
          </div>
        </div>
        <div class="safety-tip reveal reveal-d2">
          <span class="tip-emoji">&#x23F0;</span>
          <div class="tip-text">
            <strong>Set Time Limits</strong>
            Take regular breaks and limit screen time. A good rule is 30 minutes of play followed by a short break.
          </div>
        </div>
        <div class="safety-tip reveal reveal-d3">
          <span class="tip-emoji">&#x1F512;</span>
          <div class="tip-text">
            <strong>Protect Personal Info</strong>
            Never share your real name, address, phone number, or school name on any website or game.
          </div>
        </div>
        <div class="safety-tip reveal reveal-d4">
          <span class="tip-emoji">&#x1F4AC;</span>
          <div class="tip-text">
            <strong>Tell a Trusted Adult</strong>
            If you see anything online that makes you uncomfortable, tell a parent or teacher right away.
          </div>
        </div>
      </div>
    </div>
  </div>
</section>


<!-- ===================== CTA ===================== -->
<section class="cta">
  <div class="cta-label">Keep Exploring</div>
  <h2 class="cta-title">Looking for More Learning Resources?</h2>
  <div class="cta-actions">
    <a href="/student-resources/" class="btn btn-white">Explore More Resources</a>
    <a href="/contact/" class="btn btn-outline-light">Contact Us</a>
  </div>
</section>


<!-- ===================== FOOTER ===================== -->
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
          <li><a href="/apply-online/">How to Apply</a></li>
          <li><a href="/campus/">Visit</a></li>
          <li><a href="/prospectus/">View Prospectus</a></li>
          <li><a href="/schedule-tour/">Schedule a Tour</a></li>
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
        </ul>
      </div>
      <div>
        <h4 class="footer-heading">Links</h4>
        <ul class="footer-links">
          <li><a href="/contact/">Careers</a></li>
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
        <a href="/">Anti&#x2011;Discrimination</a>
        <a href="/">Sitemap</a>
      </div>
    </div>
  </div>
</footer>


<!-- ===================== JAVASCRIPT ===================== -->
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

// ===== CATEGORY FILTER =====
function filterGames(category, btn) {
  // Update active button
  document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
  btn.classList.add('active');

  // Filter cards
  const cards = document.querySelectorAll('.game-card');
  cards.forEach(card => {
    if (category === 'all' || card.getAttribute('data-category') === category) {
      card.classList.remove('hidden');
      // Re-trigger reveal animation
      card.classList.remove('visible');
      setTimeout(() => {
        obs.observe(card);
      }, 50);
    } else {
      card.classList.add('hidden');
    }
  });
}
</script>

</body>
</html>
