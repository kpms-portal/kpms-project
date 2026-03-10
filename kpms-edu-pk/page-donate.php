<?php
/*
Template Name: KPMS - Donate
*/
?>
<?php $kpms_nonce = wp_create_nonce('wp_rest'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Support KPMS – Kamal Public Middle School Abbottabad</title>
<?php include get_stylesheet_directory() . '/analytics.php'; ?>
<meta name="description" content="Support the long-term sustainability of Kamal Public Middle School. Your contribution directly funds education, teacher retention, and campus infrastructure in Abbottabad.">
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;0,900;1,400;1,500&family=DM+Sans:wght@300;400;500;600;700&family=Amiri:wght@400;700&display=swap" rel="stylesheet">
<style>
/* ===== RESET & VARIABLES ===== */
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

:root {
  --blue: #003087;
  --blue-deep: #001f5c;
  --blue-light: #1a5fcc;
  --blue-bright: #2878e6;
  --gold: #FFD100;
  --gold-light: #FFE04A;
  --gold-warm: #FFC520;
  --gold-dark: #C9A400;
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
  --pak-green: #01411C;
  --pak-green-light: #046A38;
  --pak-green-bright: #0B8A4B;
  --green: #2ECC71;
  --green-deep: #1a9c54;
  --ramadan-emerald: #064E3B;
  --ramadan-emerald-light: #0B7A5A;
  --ramadan-cream: #FEF9F0;
  --ramadan-warm: #F5ECD7;
  --spring: cubic-bezier(0.16, 1, 0.3, 1);
}

html { scroll-behavior: smooth; }

body {
  font-family: 'DM Sans', -apple-system, sans-serif;
  color: var(--text);
  background: var(--ramadan-cream);
  line-height: 1.6;
  -webkit-font-smoothing: antialiased;
  overflow-x: hidden;
}

/* ===== SKIP LINK ===== */
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
.nav.scrolled { box-shadow: 0 4px 30px rgba(0,0,0,0.1); }
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
.nav-logo-icon img { width: 100%; height: 100%; object-fit: cover; }
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
.dropdown-arrow { font-size: 8px; transition: transform 0.3s; margin-top: 1px; }
.nav-menu > li:hover .dropdown-arrow { transform: rotate(180deg); }
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
  transition: opacity 0.25s var(--spring), transform 0.25s var(--spring), visibility 0s;
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

/* Search */
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
.nav-search-btn {
  background: none; border: none; cursor: pointer; padding: 8px;
  display: flex; align-items: center; color: var(--text-muted);
  transition: color 0.3s;
}
.nav-search-btn:hover { color: var(--blue); }
.nav-search-btn svg { width: 20px; height: 20px; }

/* ===== HERO ===== */
.hero {
  position: relative;
  min-height: 92vh;
  display: flex;
  align-items: center;
  overflow: hidden;
  background: linear-gradient(165deg, var(--blue-deep) 0%, #001233 40%, var(--ramadan-emerald) 100%);
}
.hero-bg-pattern {
  position: absolute; inset: 0;
  background-image:
    radial-gradient(ellipse 800px 600px at 80% 20%, rgba(255,209,0,0.08) 0%, transparent 70%),
    radial-gradient(ellipse 600px 400px at 20% 80%, rgba(10,143,108,0.15) 0%, transparent 70%);
}
.hero-pattern-overlay {
  position: absolute; inset: 0;
  opacity: 0.04;
  background-image: url("data:image/svg+xml,%3Csvg width='80' height='80' viewBox='0 0 80 80' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' stroke='%23FFD100' stroke-width='1'%3E%3Cpath d='M40 0L80 40L40 80L0 40Z'/%3E%3Cpath d='M40 10L70 40L40 70L10 40Z'/%3E%3Cpath d='M40 20L60 40L40 60L20 40Z'/%3E%3C/g%3E%3C/svg%3E");
}

/* Floating crescent moon + stars */
.celestial {
  position: absolute; top: 8%; right: 10%;
  width: 180px; height: 180px;
  animation: celestialFloat 8s ease-in-out infinite;
  z-index: 1;
}
@keyframes celestialFloat {
  0%, 100% { transform: translateY(0) rotate(0deg); }
  50% { transform: translateY(-20px) rotate(3deg); }
}
.crescent-moon {
  width: 140px; height: 140px;
  border-radius: 50%;
  box-shadow: inset -30px 4px 0 0 var(--gold);
  position: relative;
  opacity: 0.6;
}
.star {
  position: absolute;
  color: var(--gold);
  animation: starTwinkle 3s ease-in-out infinite;
  opacity: 0.7;
}
.star:nth-child(2) { top: -20px; right: 10px; font-size: 18px; animation-delay: 0.5s; }
.star:nth-child(3) { top: 20px; right: -30px; font-size: 14px; animation-delay: 1s; }
.star:nth-child(4) { top: 60px; right: -15px; font-size: 10px; animation-delay: 1.5s; }
.star:nth-child(5) { top: -10px; right: -50px; font-size: 12px; animation-delay: 2s; }
@keyframes starTwinkle {
  0%, 100% { opacity: 0.4; transform: scale(1); }
  50% { opacity: 1; transform: scale(1.3); }
}

.hero-content {
  position: relative; z-index: 2;
  max-width: 1400px; margin: 0 auto;
  padding: 80px 60px;
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 80px;
  align-items: center;
}
.hero-text { color: var(--white); }
.hero-badge {
  display: inline-flex; align-items: center; gap: 8px;
  background: rgba(255,209,0,0.12);
  border: 1px solid rgba(255,209,0,0.25);
  padding: 8px 20px;
  border-radius: 50px;
  font-size: 13px;
  font-weight: 600;
  color: var(--gold);
  margin-bottom: 28px;
  backdrop-filter: blur(10px);
}
.hero-badge .badge-dot {
  width: 8px; height: 8px;
  background: var(--gold);
  border-radius: 50%;
  animation: pulse-dot 2s ease-in-out infinite;
}
@keyframes pulse-dot {
  0%, 100% { opacity: 1; transform: scale(1); }
  50% { opacity: 0.5; transform: scale(0.8); }
}
.hero h1 {
  font-family: 'Playfair Display', serif;
  font-size: clamp(34px, 5vw, 58px);
  font-weight: 900;
  line-height: 1.1;
  margin-bottom: 24px;
}
.hero h1 .gold-text { color: var(--gold); }
.hero h1 .emerald-text { color: #4ADE80; }
.hero-subtitle {
  font-size: 18px;
  line-height: 1.7;
  color: rgba(255,255,255,0.78);
  margin-bottom: 36px;
  max-width: 520px;
}
.hero-stats {
  display: flex; gap: 40px;
  margin-bottom: 40px;
}
.hero-stat {
  text-align: center;
}
.hero-stat-value {
  font-family: 'Playfair Display', serif;
  font-size: 38px;
  font-weight: 900;
  color: var(--gold);
  line-height: 1;
}
.hero-stat-label {
  font-size: 12px;
  font-weight: 600;
  color: rgba(255,255,255,0.6);
  text-transform: uppercase;
  letter-spacing: 1px;
  margin-top: 6px;
}
.hero-verse {
  font-family: 'Amiri', serif;
  font-size: 18px;
  font-style: italic;
  color: rgba(255,255,255,0.55);
  border-left: 3px solid var(--gold);
  padding-left: 20px;
  margin-top: 10px;
  line-height: 1.8;
}
.hero-verse .arabic {
  display: block;
  font-size: 22px;
  font-style: normal;
  direction: rtl;
  color: rgba(255,255,255,0.45);
  margin-bottom: 6px;
}

/* Hero Right -- Donation Card */
.hero-card-area {
  display: flex;
  justify-content: center;
}
.donation-card {
  background: var(--white);
  border-radius: 20px;
  padding: 40px 36px;
  width: 100%;
  max-width: 480px;
  box-shadow:
    0 30px 80px rgba(0,0,0,0.3),
    0 0 0 1px rgba(255,255,255,0.1);
  position: relative;
  overflow: hidden;
}
.donation-card::before {
  content: '';
  position: absolute; top: 0; left: 0; right: 0;
  height: 5px;
  background: linear-gradient(90deg, var(--gold), var(--ramadan-emerald), var(--gold));
}
.card-header {
  text-align: center;
  margin-bottom: 24px;
}
.card-header h2 {
  font-family: 'Playfair Display', serif;
  font-size: 24px;
  font-weight: 700;
  color: var(--blue-deep);
  margin-bottom: 6px;
}
.card-header p {
  color: var(--text-muted);
  font-size: 14px;
}
.zero-fee-badge {
  display: inline-flex; align-items: center; gap: 6px;
  background: rgba(46,204,113,0.1);
  color: var(--green-deep);
  font-size: 12px;
  font-weight: 700;
  padding: 6px 14px;
  border-radius: 50px;
  margin-top: 12px;
  letter-spacing: 0.3px;
}
.zero-fee-badge svg { width: 14px; height: 14px; }

/* Donation Amount Grid */
.donate-amounts {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 10px;
  margin-bottom: 16px;
}
.don-amt-btn {
  position: relative;
  padding: 16px 8px;
  border: 2px solid #e2e8f0;
  border-radius: 12px;
  background: var(--white);
  cursor: pointer;
  text-align: center;
  transition: all 0.3s var(--spring);
  overflow: hidden;
  font-family: 'DM Sans', sans-serif;
  font-size: 18px;
  font-weight: 700;
  color: var(--text);
}
.don-amt-btn:hover {
  border-color: var(--ramadan-emerald);
  background: rgba(6,78,59,0.03);
  transform: translateY(-2px);
  box-shadow: 0 8px 24px rgba(6,78,59,0.12);
}
.don-amt-btn.active {
  border-color: var(--ramadan-emerald);
  background: rgba(6,78,59,0.06);
  box-shadow: 0 0 0 3px rgba(6,78,59,0.15);
  color: var(--ramadan-emerald);
}
.don-amt-btn.active::after {
  content: '\2713';
  position: absolute;
  top: 6px; right: 8px;
  font-size: 11px;
  color: var(--ramadan-emerald);
  font-weight: 700;
}

/* Custom Amount */
.don-custom-wrap {
  position: relative;
  margin-bottom: 20px;
}
.don-custom-wrap .dollar-sign {
  position: absolute;
  left: 16px; top: 50%; transform: translateY(-50%);
  font-size: 18px; font-weight: 700;
  color: var(--text-muted);
}
.don-custom-input {
  width: 100%;
  padding: 14px 16px 14px 36px;
  border: 2px solid #e2e8f0;
  border-radius: 12px;
  font-size: 18px;
  font-family: 'DM Sans', sans-serif;
  font-weight: 600;
  color: var(--text);
  transition: all 0.3s;
  background: var(--white);
  outline: none;
}
.don-custom-input:focus {
  border-color: var(--ramadan-emerald);
  box-shadow: 0 0 0 3px rgba(6,78,59,0.12);
}
.don-custom-input::placeholder {
  font-weight: 400;
  color: #aab5c8;
}

/* Type toggle */
.don-type-toggle {
  display: flex;
  gap: 8px;
  margin-bottom: 20px;
}
.don-type-btn {
  flex: 1;
  padding: 12px 8px;
  border: 2px solid #e2e8f0;
  border-radius: 10px;
  background: var(--white);
  font-family: 'DM Sans', sans-serif;
  font-size: 13px; font-weight: 600;
  color: var(--text-muted);
  cursor: pointer;
  transition: all 0.3s var(--spring);
  text-align: center;
}
.don-type-btn:hover {
  border-color: var(--ramadan-emerald);
}
.don-type-btn.active {
  border-color: var(--ramadan-emerald);
  color: var(--ramadan-emerald);
  background: rgba(6,78,59,0.05);
}

/* Donate / Submit Button */
.don-submit-btn {
  width: 100%;
  padding: 18px;
  background: linear-gradient(135deg, var(--ramadan-emerald) 0%, var(--ramadan-emerald-light) 100%);
  color: var(--white);
  border: none;
  border-radius: 14px;
  font-size: 17px;
  font-weight: 700;
  font-family: 'DM Sans', sans-serif;
  cursor: pointer;
  transition: all 0.3s var(--spring);
  position: relative;
  overflow: hidden;
  letter-spacing: 0.3px;
}
.don-submit-btn:hover {
  transform: translateY(-2px);
  box-shadow: 0 12px 36px rgba(6,78,59,0.35);
}
.don-submit-btn:active { transform: translateY(0); }
.don-submit-btn:disabled {
  opacity: 0.5;
  cursor: not-allowed;
  transform: none;
  box-shadow: none;
}
.don-submit-btn .btn-shimmer {
  position: absolute; inset: 0;
  background: linear-gradient(90deg, transparent, rgba(255,255,255,0.15), transparent);
  transform: translateX(-100%);
  animation: shimmer 3s ease-in-out infinite;
}
@keyframes shimmer {
  0% { transform: translateX(-100%); }
  100% { transform: translateX(100%); }
}
.don-submit-btn.loading {
  position: relative;
  color: transparent;
}
.don-submit-btn.loading::after {
  content: '';
  position: absolute;
  top: 50%; left: 50%;
  width: 22px; height: 22px;
  margin: -11px 0 0 -11px;
  border: 3px solid rgba(255,255,255,0.3);
  border-top-color: var(--white);
  border-radius: 50%;
  animation: spin 0.7s linear infinite;
}
@keyframes spin { to { transform: rotate(360deg); } }

.card-secure-note {
  display: flex; align-items: center; justify-content: center;
  gap: 8px;
  margin-top: 16px;
  font-size: 12px;
  color: var(--text-muted);
}
.card-secure-note svg { width: 14px; height: 14px; color: var(--green-deep); }
.card-footer-note {
  text-align: center;
  margin-top: 12px;
  font-size: 11px;
  color: var(--text-muted);
  line-height: 1.6;
}

/* Form fields inside card */
.don-form-group {
  margin-bottom: 16px;
}
.don-form-group label {
  display: block;
  font-size: 13px; font-weight: 600;
  color: var(--text);
  margin-bottom: 5px;
}
.don-form-group input,
.don-form-group textarea {
  width: 100%;
  padding: 12px 16px;
  border: 2px solid #e2e8f0;
  border-radius: 10px;
  font-family: 'DM Sans', sans-serif;
  font-size: 14px;
  color: var(--text);
  outline: none;
  transition: border-color 0.3s;
}
.don-form-group input:focus,
.don-form-group textarea:focus {
  border-color: var(--ramadan-emerald);
  box-shadow: 0 0 0 3px rgba(6,78,59,0.1);
}
.don-form-group textarea {
  resize: vertical;
  min-height: 70px;
}
.don-checkbox {
  display: flex; align-items: center; gap: 10px;
  margin-bottom: 20px;
  font-size: 13px; color: var(--text-muted);
}
.don-checkbox input { width: 18px; height: 18px; cursor: pointer; }

.don-error {
  display: none;
  background: #fef2f2;
  color: #991b1b;
  padding: 10px 14px;
  border-radius: 10px;
  font-size: 13px; font-weight: 600;
  margin-bottom: 16px;
  border: 1px solid #fecaca;
}
.don-back-btn {
  background: none; border: none;
  color: var(--blue);
  font-family: 'DM Sans', sans-serif;
  font-size: 13px; font-weight: 600;
  cursor: pointer;
  margin-bottom: 16px;
  display: flex; align-items: center; gap: 6px;
}
.don-back-btn:hover { text-decoration: underline; }

/* Success step */
.don-success {
  text-align: center;
}
.don-success-icon {
  width: 64px; height: 64px;
  background: #dcfce7;
  border-radius: 50%;
  display: flex; align-items: center; justify-content: center;
  margin: 0 auto 16px;
  font-size: 28px;
}
.don-success h3 {
  font-family: 'Playfair Display', serif;
  font-size: 22px; font-weight: 600;
  margin-bottom: 10px;
}
.don-success p {
  font-size: 14px;
  color: var(--text-muted);
  line-height: 1.7;
  margin-bottom: 6px;
}
.don-ref-code {
  display: inline-block;
  background: #e8f5ec;
  padding: 8px 18px;
  border-radius: 8px;
  font-family: monospace;
  font-size: 16px; font-weight: 700;
  color: var(--ramadan-emerald);
  letter-spacing: 2px;
  margin: 12px 0;
  border: 1px solid #d4e8db;
}
.don-payment-info {
  text-align: left;
  background: var(--white);
  border: 2px solid #e2e8f0;
  border-radius: 12px;
  padding: 20px;
  margin-top: 16px;
}
.don-payment-info h5 {
  font-family: 'Playfair Display', serif;
  font-size: 16px; font-weight: 600;
  margin-bottom: 10px;
  color: var(--text);
}
.don-payment-info p {
  font-size: 13px;
  margin-bottom: 4px;
  text-align: left;
}

/* Donate step visibility */
.donate-step { display: none; }
.donate-step.active { display: block; }

/* ===== SCROLLING TICKER ===== */
.ticker {
  background: var(--gold);
  padding: 14px 0;
  overflow: hidden;
  position: relative;
}
.ticker-track {
  display: flex;
  animation: ticker-scroll 30s linear infinite;
  white-space: nowrap;
}
@keyframes ticker-scroll {
  0% { transform: translateX(0); }
  100% { transform: translateX(-50%); }
}
.ticker-item {
  display: inline-flex;
  align-items: center;
  gap: 12px;
  padding: 0 40px;
  font-size: 14px;
  font-weight: 700;
  color: var(--blue-deep);
  letter-spacing: 0.5px;
}
.ticker-item .separator {
  width: 6px; height: 6px;
  background: var(--blue-deep);
  border-radius: 50%;
  opacity: 0.3;
}

/* ===== SECTION HELPERS ===== */
.section-inner { max-width: 1200px; margin: 0 auto; position: relative; z-index: 1; }
.section-label {
  display: inline-flex; align-items: center; gap: 8px;
  font-size: 12px; font-weight: 700;
  color: var(--ramadan-emerald);
  text-transform: uppercase;
  letter-spacing: 2px;
  margin-bottom: 16px;
}
.section-label::before {
  content: '';
  width: 24px; height: 2px;
  background: var(--ramadan-emerald);
}
.section-title {
  font-family: 'Playfair Display', serif;
  font-size: clamp(28px, 4vw, 44px);
  font-weight: 700;
  color: var(--blue-deep);
  margin-bottom: 16px;
  line-height: 1.15;
}
.section-subtitle {
  font-size: 17px;
  color: var(--text-muted);
  max-width: 640px;
  margin-bottom: 50px;
  line-height: 1.7;
}

/* ===== STORY SECTION ===== */
.story-section {
  padding: 100px 60px;
  background: var(--ramadan-cream);
  position: relative;
}
.story-section::before {
  content: '';
  position: absolute;
  top: 0; left: 50%; transform: translateX(-50%);
  width: 1px; height: 60px;
  background: linear-gradient(to bottom, var(--ramadan-emerald), transparent);
}
.story-inner {
  max-width: 780px;
  margin: 0 auto;
  text-align: center;
  background: var(--white);
  padding: 64px 56px;
  border-radius: 24px;
  border: 1px solid rgba(0,0,0,0.04);
  box-shadow:
    0 1px 2px rgba(0,0,0,0.04),
    0 8px 32px rgba(0,48,135,0.06),
    0 32px 64px rgba(0,48,135,0.04);
  position: relative;
  transition: all 0.4s var(--spring);
}
.story-inner:hover {
  transform: translateY(-4px);
  box-shadow: 0 20px 50px rgba(0,0,0,0.08);
}
.story-inner::before {
  content: '';
  position: absolute;
  top: 0; left: 0; right: 0;
  height: 4px;
  background: linear-gradient(90deg, var(--ramadan-emerald), var(--gold), var(--blue));
  border-radius: 24px 24px 0 0;
}
.story-quote-mark {
  font-family: 'Playfair Display', serif;
  font-size: 72px;
  color: var(--gold);
  opacity: 0.4;
  line-height: 1;
  margin-bottom: -16px;
}
.story-inner .section-label {
  color: var(--ramadan-emerald);
}
.story-inner .section-title {
  font-size: clamp(26px, 4vw, 38px);
  letter-spacing: -0.5px;
  margin-bottom: 12px;
}
.story-inner p {
  font-size: 17px;
  color: var(--text-muted);
  line-height: 1.9;
  margin-top: 20px;
}
.story-inner p:last-child {
  font-size: 18px;
  font-weight: 600;
  color: var(--ramadan-emerald);
  font-style: italic;
}
.story-divider {
  width: 40px; height: 2px;
  background: var(--gold);
  margin: 28px auto;
  border-radius: 2px;
}

/* ===== LEADERSHIP SECTION ===== */
.leadership-section {
  padding: 100px 60px;
  background: var(--white);
}
.leadership-inner {
  max-width: 900px;
  margin: 0 auto;
  display: grid;
  grid-template-columns: 260px 1fr;
  gap: 56px;
  align-items: center;
}
.leader-photo {
  width: 260px; height: 300px;
  background: linear-gradient(145deg, var(--ice) 0%, #f0f3fa 100%);
  border-radius: 20px;
  display: flex; align-items: center; justify-content: center;
  overflow: hidden;
  box-shadow:
    0 2px 4px rgba(0,0,0,0.04),
    0 16px 48px rgba(0,48,135,0.08);
  transition: all 0.4s var(--spring);
}
.leader-photo:hover {
  transform: translateY(-6px);
  box-shadow: 0 24px 60px rgba(0,0,0,0.12);
}
.leader-photo img {
  width: 100%; height: 100%;
  object-fit: cover;
  display: block;
}
.leader-info .section-label { color: var(--ramadan-emerald); }
.leader-info h3 {
  font-family: 'Playfair Display', serif;
  font-size: 30px; font-weight: 600;
  color: var(--text);
  margin-bottom: 6px;
  letter-spacing: -0.3px;
}
.leader-role {
  font-size: 13px; font-weight: 700;
  color: var(--ramadan-emerald);
  letter-spacing: 2px;
  text-transform: uppercase;
  margin-bottom: 24px;
  display: inline-block;
  padding-bottom: 12px;
  border-bottom: 2px solid var(--gold);
}
.leader-info p {
  font-size: 16px;
  color: var(--text-muted);
  line-height: 1.85;
}

/* ===== INITIATIVE SECTION (dark gradient) ===== */
.initiative-section {
  padding: 100px 60px;
  background: linear-gradient(165deg, var(--blue-deep) 0%, #001233 50%, var(--ramadan-emerald) 100%);
  color: var(--white);
  position: relative;
  overflow: hidden;
}
.initiative-section .hero-pattern-overlay { opacity: 0.03; }
.initiative-section .section-label { color: var(--gold); }
.initiative-section .section-label::before { background: var(--gold); }
.initiative-section .section-title { color: var(--white); }
.initiative-inner {
  max-width: 920px;
  margin: 0 auto;
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 64px;
  align-items: start;
  position: relative;
  z-index: 1;
}
.initiative-text .section-title {
  margin-bottom: 20px;
  letter-spacing: -0.3px;
}
.initiative-text p {
  font-size: 16px;
  color: rgba(255,255,255,0.7);
  line-height: 1.85;
  margin-bottom: 16px;
}
.initiative-text p em {
  font-style: italic;
  color: var(--gold);
  font-weight: 500;
}
.initiative-list {
  list-style: none;
  padding: 0;
  background: rgba(255,255,255,0.06);
  backdrop-filter: blur(20px);
  border: 1px solid rgba(255,255,255,0.1);
  border-radius: 20px;
  padding: 8px 0;
  transition: all 0.4s var(--spring);
}
.initiative-list:hover {
  background: rgba(255,255,255,0.1);
  transform: translateY(-4px);
  box-shadow: 0 20px 50px rgba(0,0,0,0.2);
}
.initiative-list li {
  padding: 18px 24px 18px 52px;
  position: relative;
  font-size: 15px;
  color: rgba(255,255,255,0.85);
  font-weight: 500;
  border-bottom: 1px solid rgba(255,255,255,0.08);
  transition: background 0.2s;
}
.initiative-list li:last-child { border-bottom: none; }
.initiative-list li:hover { background: rgba(255,255,255,0.04); }
.initiative-list li::before {
  content: '\2726';
  position: absolute; left: 22px; top: 20px;
  color: var(--gold);
  font-size: 14px;
}

/* ===== CTA BANNER ===== */
.cta-banner {
  padding: 100px 60px;
  background: linear-gradient(135deg, var(--ramadan-emerald) 0%, var(--blue-deep) 100%);
  text-align: center;
  color: var(--white);
  position: relative;
  overflow: hidden;
}
.cta-banner .hero-pattern-overlay { opacity: 0.04; }
.cta-inner { max-width: 700px; margin: 0 auto; position: relative; z-index: 1; }
.cta-banner h2 {
  font-family: 'Playfair Display', serif;
  font-size: clamp(28px, 4vw, 46px);
  font-weight: 900;
  margin-bottom: 20px;
  line-height: 1.15;
}
.cta-banner p {
  font-size: 18px;
  color: rgba(255,255,255,0.7);
  margin-bottom: 36px;
  line-height: 1.7;
}
.cta-donate-btn {
  display: inline-flex;
  align-items: center; gap: 10px;
  padding: 20px 48px;
  background: var(--gold);
  color: var(--blue-deep);
  border: none;
  border-radius: 50px;
  font-size: 18px;
  font-weight: 700;
  font-family: 'DM Sans', sans-serif;
  cursor: pointer;
  transition: all 0.3s var(--spring);
  text-decoration: none;
}
.cta-donate-btn:hover {
  transform: translateY(-3px);
  box-shadow: 0 16px 40px rgba(255,209,0,0.35);
}

/* ===== TRANSPARENCY NOTE ===== */
.transparency-section {
  padding: 50px 60px;
  background: var(--ramadan-cream);
}
.transparency-inner {
  max-width: 600px;
  margin: 0 auto;
  text-align: center;
  padding: 24px 36px;
  border: 1px solid rgba(0,0,0,0.06);
  border-radius: 16px;
  background: var(--white);
  box-shadow: 0 4px 20px rgba(0,0,0,0.04);
}
.transparency-inner p {
  font-size: 13px;
  color: var(--text-muted);
  line-height: 1.7;
  font-style: italic;
  letter-spacing: 0.1px;
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
.footer-brand-icon img { width: 100%; height: 100%; object-fit: cover; }
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
  transition: all 0.4s var(--spring);
}
.footer-social a:hover { transform: translateY(-5px) scale(1.15); }
.footer-social a.fb { background: #1877F2; }
.footer-social a.fb:hover { box-shadow: 0 8px 25px rgba(24,119,242,0.5); }
.footer-social a.ig { background: linear-gradient(45deg, #f09433, #e6683c, #dc2743, #cc2366, #bc1888); }
.footer-social a.ig:hover { box-shadow: 0 8px 25px rgba(225,48,108,0.5); }
.footer-social a.yt { background: #FF0000; }
.footer-social a.yt:hover { box-shadow: 0 8px 25px rgba(255,0,0,0.5); }
.footer-social a.wa { background: #25D366; }
.footer-social a.wa:hover { box-shadow: 0 8px 25px rgba(37,211,102,0.5); }
.footer-social a svg { width: 20px; height: 20px; fill: white; }

/* ===== FLOATING PROGRESS WIDGET ===== */
.progress-float {
  position: fixed;
  bottom: 28px;
  right: 28px;
  background: var(--white);
  border-radius: 16px;
  padding: 18px 22px;
  box-shadow: 0 12px 40px rgba(0,0,0,0.15);
  z-index: 999;
  width: 280px;
  border: 1px solid rgba(0,0,0,0.06);
  transform: translateY(120%);
  transition: transform 0.5s var(--spring);
}
.progress-float.visible { transform: translateY(0); }
.progress-float-header {
  display: flex; justify-content: space-between; align-items: center;
  margin-bottom: 10px;
}
.progress-float-title { font-size: 13px; font-weight: 700; color: var(--blue-deep); }
.progress-float-amount { font-size: 13px; font-weight: 600; color: var(--ramadan-emerald); }
.progress-bar-bg {
  height: 8px;
  background: #e2e8f0;
  border-radius: 50px;
  overflow: hidden;
}
.progress-bar-fill {
  height: 100%;
  background: linear-gradient(90deg, var(--ramadan-emerald), var(--gold));
  border-radius: 50px;
  transition: width 1.5s var(--spring);
}
.progress-float-sub {
  font-size: 11px;
  color: var(--text-muted);
  margin-top: 8px;
}

/* ===== SCROLL REVEAL ===== */
.reveal {
  opacity: 0; transform: translateY(30px);
  transition: opacity 0.8s ease, transform 0.8s var(--spring);
}
.reveal.visible { opacity: 1; transform: translateY(0); }
.reveal-d1 { transition-delay: 0.1s; }
.reveal-d2 { transition-delay: 0.2s; }
.reveal-d3 { transition-delay: 0.3s; }
.reveal-delay-1 { transition-delay: 0.1s; }
.reveal-delay-2 { transition-delay: 0.2s; }
.reveal-delay-3 { transition-delay: 0.3s; }
.reveal-delay-4 { transition-delay: 0.4s; }
.reveal-delay-5 { transition-delay: 0.5s; }

/* ===== RESPONSIVE ===== */
@media (max-width: 1200px) {
  .nav-inner { padding: 0 30px; }
  .hero-content { padding: 80px 30px; gap: 48px; }
  .story-section, .leadership-section, .initiative-section,
  .cta-banner, .footer, .transparency-section { padding-left: 30px; padding-right: 30px; }
  .footer-grid { grid-template-columns: 1fr 1fr; }
}

@media (max-width: 1024px) {
  .hero-content { grid-template-columns: 1fr; gap: 48px; }
  .hero-card-area { justify-content: flex-start; }
  .donation-card { max-width: 100%; }
  .celestial { display: none; }
  .leadership-inner { grid-template-columns: 1fr; gap: 30px; }
  .leader-photo { width: 200px; height: 240px; margin: 0 auto; }
  .initiative-inner { grid-template-columns: 1fr; gap: 40px; }
}

@media (max-width: 900px) {
  .topbar { display: none; }
  .nav-menu { display: none; }
  .nav-search-btn { display: none; }
  .mobile-toggle { display: block; }
  .nav-inner { padding: 0 20px !important; height: 64px; }
}

@media (max-width: 768px) {
  .hero { min-height: auto; }
  .hero-content { padding: 60px 20px; }
  .hero h1 { font-size: 32px; }
  .hero-stats { gap: 24px; }
  .hero-stat-value { font-size: 28px; }
  .donation-card { padding: 32px 24px; }
  .donate-amounts { grid-template-columns: repeat(3, 1fr); gap: 8px; }
  .don-amt-btn { font-size: 16px; padding: 14px 6px; }
  .story-section, .leadership-section, .initiative-section,
  .cta-banner, .transparency-section { padding: 70px 20px; }
  .story-inner { padding: 40px 28px; }
  .footer { padding: 48px 20px 24px; }
  .footer-grid { grid-template-columns: 1fr; gap: 32px; }
  .footer-bottom { flex-direction: column; text-align: center; }
  .progress-float { width: calc(100% - 40px); right: 20px; bottom: 20px; }
}

@media (max-width: 480px) {
  .donate-amounts { grid-template-columns: repeat(2, 1fr); }
  .hero-stats { flex-direction: column; gap: 16px; align-items: flex-start; }
  .hero h1 { font-size: 28px; }
  .story-inner { padding: 32px 20px; }
  .story-quote-mark { font-size: 60px; }
  .leader-info { text-align: center; }
}

/* ===== PENCIL CURSOR ===== */
body {
  cursor: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='28' height='28' viewBox='0 0 28 28'%3E%3Cg transform='translate(28,0) scale(-1,1) rotate(-45 14 14)'%3E%3Crect x='11' y='3' width='6' height='18' rx='1' fill='%23FFD700' stroke='%23001840' stroke-width='0.7'/%3E%3Crect x='11' y='3' width='6' height='4' rx='1' fill='%234A90D9' stroke='%23001840' stroke-width='0.7'/%3E%3Crect x='12' y='4' width='4' height='2' rx='0.5' fill='%236BB3E0' opacity='0.6'/%3E%3Cpolygon points='11,21 17,21 14,26' fill='%23F5DEB3' stroke='%23001840' stroke-width='0.7'/%3E%3Cpolygon points='13,24 15,24 14,26' fill='%23003087'/%3E%3C/g%3E%3C/svg%3E") 25 25, auto;
}
a, button, .donation-card {
  cursor: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='32' height='32' viewBox='0 0 32 32'%3E%3Cdefs%3E%3Cfilter id='g' x='-20%25' y='-20%25' width='140%25' height='140%25'%3E%3CfeGaussianBlur stdDeviation='1' result='b'/%3E%3CfeMerge%3E%3CfeMergeNode in='b'/%3E%3CfeMergeNode in='SourceGraphic'/%3E%3C/feMerge%3E%3C/filter%3E%3C/defs%3E%3Cg transform='translate(32,0) scale(-1,1) rotate(-45 16 16)' filter='url(%23g)'%3E%3Crect x='13' y='3' width='6' height='20' rx='1' fill='%23FFD700' stroke='%23001840' stroke-width='0.8'/%3E%3Crect x='13' y='3' width='6' height='4' rx='1' fill='%234A90D9' stroke='%23001840' stroke-width='0.8'/%3E%3Crect x='14' y='4' width='4' height='2' rx='0.5' fill='%236BB3E0' opacity='0.6'/%3E%3Cpolygon points='13,23 19,23 16,28' fill='%23F5DEB3' stroke='%23001840' stroke-width='0.8'/%3E%3Cpolygon points='15,26 17,26 16,28' fill='%23003087'/%3E%3C/g%3E%3C/svg%3E") 28 28, pointer;
}
</style>
</head>
<body>
<?php include get_stylesheet_directory() . '/gtm-body.php'; ?>

<!-- SKIP LINK -->
<a href="#main-content" class="skip-link">Skip to main content</a>

<!-- TOPBAR -->
<div class="topbar" role="banner">
  <div class="topbar-left">
    <a href="tel:+923135914700">&#128222; +92 313 5914700</a>
    <a href="mailto:info@kpms.edu.pk">&#9993; info@kpms.edu.pk</a>
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
    <input type="text" placeholder="Search KPMS..." id="searchInput" aria-label="Search the site">
    <button class="search-close" onclick="toggleSearch()" aria-label="Close search">&#10005;</button>
  </div>
  <div class="search-hint">Press ESC to close</div>
</div>

<?php include get_stylesheet_directory() . '/mobile-menu.php'; ?>

<!-- ===== MAIN CONTENT ===== -->
<main id="main-content">

<!-- HERO with split layout: text left, donation card right -->
<section class="hero">
  <div class="hero-bg-pattern"></div>
  <div class="hero-pattern-overlay"></div>

  <!-- Crescent Moon + Stars -->
  <div class="celestial">
    <div class="crescent-moon">
      <span class="star">&#10022;</span>
      <span class="star">&#10022;</span>
      <span class="star">&#10022;</span>
      <span class="star">&#10022;</span>
    </div>
  </div>

  <div class="hero-content">
    <!-- LEFT TEXT -->
    <div class="hero-text">
      <div class="hero-badge">
        <span class="badge-dot"></span>
        KPMS Sustainability Initiative
      </div>
      <h1>
        Building<br>
        <span class="gold-text">Permanence.</span><br>
        <span class="emerald-text">Protecting Opportunity.</span>
      </h1>
      <p class="hero-subtitle">KPMS has been revitalized. Now we are building long-term sustainability through structured community support.</p>

      <div class="hero-stats">
        <div class="hero-stat">
          <div class="hero-stat-value">120+</div>
          <div class="hero-stat-label">Students</div>
        </div>
        <div class="hero-stat">
          <div class="hero-stat-value">40+</div>
          <div class="hero-stat-label">Years</div>
        </div>
        <div class="hero-stat">
          <div class="hero-stat-value">100%</div>
          <div class="hero-stat-label">Goes to Students</div>
        </div>
      </div>

      <div class="hero-verse">
        <span class="arabic">&#1605;&#1614;&#1606; &#1584;&#1614;&#1575; &#1649;&#1604;&#1617;&#1614;&#1584;&#1616;&#1609; &#1610;&#1615;&#1602;&#1585;&#1616;&#1590;&#1615; &#1649;&#1604;&#1604;&#1617;&#1614;&#1607;&#1614; &#1602;&#1614;&#1585;&#1590;&#1611;&#1575; &#1581;&#1614;&#1587;&#1614;&#1606;&#1611;&#1575;</span>
        "Who will loan Allah a beautiful loan, that He may multiply it for them many times over?"
        <br>-- Surah Al-Baqarah 2:245
      </div>
    </div>

    <!-- RIGHT -- DONATION CARD (multi-step form) -->
    <div class="hero-card-area">
      <div class="donation-card">
        <div class="card-header">
          <h2>Support KPMS Today</h2>
          <p>Choose an amount below or enter a custom contribution.</p>
          <div class="zero-fee-badge">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
            0% FEES -- 100% GOES TO KPMS
          </div>
        </div>

        <!-- STEP 1: Amount -->
        <div class="donate-step active" id="stepAmount">
          <div class="donate-amounts" id="amountGrid">
            <button class="don-amt-btn" data-amount="100">$100</button>
            <button class="don-amt-btn" data-amount="250">$250</button>
            <button class="don-amt-btn" data-amount="500">$500</button>
            <button class="don-amt-btn" data-amount="1200">$1,200</button>
            <button class="don-amt-btn" data-amount="3000">$3,000</button>
            <button class="don-amt-btn" data-amount="6000">$6,000</button>
          </div>

          <div class="don-custom-wrap">
            <span class="dollar-sign">$</span>
            <input type="number" class="don-custom-input" id="customAmount" placeholder="Custom amount" min="1" max="100000">
          </div>

          <div class="don-type-toggle">
            <button class="don-type-btn active" data-type="zakat">Zakat</button>
            <button class="don-type-btn" data-type="sadaqah">Sadaqah</button>
            <button class="don-type-btn" data-type="general">General</button>
          </div>

          <button class="don-submit-btn" id="btnNext" disabled>
            <span class="btn-shimmer"></span>
            Continue
          </button>

          <div class="card-secure-note">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
            Zelle &middot; Wire Transfer &middot; Direct Deposit -- No middleman, no fees
          </div>
        </div>

        <!-- STEP 2: Info -->
        <div class="donate-step" id="stepInfo">
          <button class="don-back-btn" id="btnBack">&#8592; Back</button>
          <div class="don-error" id="donError"></div>
          <div class="don-form-group">
            <label>Full Name *</label>
            <input type="text" id="donorName" placeholder="Your full name" required>
          </div>
          <div class="don-form-group">
            <label>Email *</label>
            <input type="email" id="donorEmail" placeholder="you@example.com" required>
          </div>
          <div class="don-form-group">
            <label>Phone</label>
            <input type="tel" id="donorPhone" placeholder="+1 (555) 000-0000">
          </div>
          <div class="don-form-group">
            <label>Message (optional)</label>
            <textarea id="donorMessage" placeholder="Any message you'd like to include..."></textarea>
          </div>
          <div class="don-checkbox">
            <input type="checkbox" id="donorAnon">
            <label for="donorAnon">Make my contribution anonymous</label>
          </div>
          <button class="don-submit-btn" id="btnSubmit">Submit Pledge</button>
        </div>

        <!-- STEP 3: Success -->
        <div class="donate-step" id="stepSuccess">
          <div class="don-success">
            <div class="don-success-icon">&#10003;</div>
            <h3>Thank You for Your Support</h3>
            <p>Your pledge of <strong id="pledgeAmount"></strong> (<span id="pledgeType"></span>) has been recorded.</p>
            <div class="don-ref-code" id="refCode"></div>
            <p>Please include this reference code when completing your transfer.</p>
            <div class="don-payment-info" id="zelleInfo"></div>
            <div class="don-payment-info" id="wireInfo" style="margin-top:16px;"></div>
          </div>
        </div>

        <div class="card-footer-note">
          You will receive a confirmation receipt within 24 hours.
        </div>
      </div>
    </div>
  </div>
</section>

<!-- SCROLLING TICKER -->
<div class="ticker">
  <div class="ticker-track">
    <div class="ticker-item">KPMS SUSTAINABILITY INITIATIVE <span class="separator"></span></div>
    <div class="ticker-item">ZERO PLATFORM FEES <span class="separator"></span></div>
    <div class="ticker-item">EVERY DOLLAR EDUCATES <span class="separator"></span></div>
    <div class="ticker-item">FULFILL YOUR ZAKAT <span class="separator"></span></div>
    <div class="ticker-item">40+ YEARS OF IMPACT <span class="separator"></span></div>
    <div class="ticker-item">120 CHILDREN COUNTING ON YOU <span class="separator"></span></div>
    <div class="ticker-item">KPMS SUSTAINABILITY INITIATIVE <span class="separator"></span></div>
    <div class="ticker-item">ZERO PLATFORM FEES <span class="separator"></span></div>
    <div class="ticker-item">EVERY DOLLAR EDUCATES <span class="separator"></span></div>
    <div class="ticker-item">FULFILL YOUR ZAKAT <span class="separator"></span></div>
    <div class="ticker-item">40+ YEARS OF IMPACT <span class="separator"></span></div>
    <div class="ticker-item">120 CHILDREN COUNTING ON YOU <span class="separator"></span></div>
  </div>
</div>

<!-- THE STORY -->
<section class="story-section" id="our-story">
  <div class="story-inner reveal">
    <div class="story-quote-mark">&ldquo;</div>
    <div class="section-label">Our Story</div>
    <h2 class="section-title">A School Given a Second Chance</h2>
    <p>KPMS faced operational and financial instability. Rather than allow it to close, new leadership stepped in to restore the school's academic and financial foundation.</p>
    <div class="story-divider"></div>
    <p>Facilities were renovated. Academic systems were strengthened. Teacher stability improved.</p>
    <p>The next step is ensuring that KPMS never again faces uncertainty.</p>
  </div>
</section>

<!-- LEADERSHIP -->
<section class="leadership-section" id="leadership">
  <div class="leadership-inner reveal">
    <div class="leader-photo">
      <img src="https://kpms.edu.pk/wp-content/uploads/2026/03/tmp_f4318a5f-48d8-42cb-baf4-077e820841c6.png" alt="Jawad Hasan - Chairman, KPMS">
    </div>
    <div class="leader-info">
      <div class="section-label">Leadership &amp; Stewardship</div>
      <h3>Jawad Hasan</h3>
      <div class="leader-role">Chairman</div>
      <p>Jawad Hasan assumed leadership of KPMS during a period of instability and personally funded the school's revitalization. He now focuses on long-term strategy, institutional governance, and building sustainable financial support to protect the school's future.</p>
    </div>
  </div>
</section>

<!-- SUSTAINABILITY INITIATIVE (dark gradient background) -->
<section class="initiative-section" id="initiative">
  <div class="hero-pattern-overlay"></div>
  <div class="initiative-inner">
    <div class="initiative-text reveal">
      <div class="section-label">The Vision</div>
      <h2 class="section-title">The KPMS Sustainability Initiative</h2>
      <p>Sustainable schools do not rely on year-to-year survival. They are built on stability.</p>
      <p><em>This is not a short-term campaign. It is a long-term commitment to permanence.</em></p>
    </div>
    <div class="reveal reveal-d1">
      <ul class="initiative-list">
        <li>Provide consistent teacher funding</li>
        <li>Support scholarship students</li>
        <li>Maintain and upgrade facilities</li>
        <li>Protect academic continuity</li>
        <li>Build long-term institutional resilience</li>
      </ul>
    </div>
  </div>
</section>

<!-- CTA BANNER -->
<section class="cta-banner">
  <div class="hero-pattern-overlay"></div>
  <div class="cta-inner reveal">
    <h2>Join the Next Chapter<br>of KPMS</h2>
    <p>KPMS has been rebuilt. With your partnership, it will be secured for generations. Become part of the founding circle committed to educational stability in Abbottabad.</p>
    <a href="#main-content" class="cta-donate-btn">Support KPMS Today</a>
  </div>
</section>

<!-- TRANSPARENCY NOTE -->
<section class="transparency-section">
  <div class="transparency-inner reveal">
    <p>KPMS is currently not a registered nonprofit entity. Contributions are not tax-deductible at this time. All contributions directly support school operations and long-term sustainability.</p>
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
        </ul>
      </div>
      <div>
        <h4 class="footer-heading">Links</h4>
        <ul class="footer-links">
          <li><a href="/careers/">Careers</a></li>
          <li><a href="/calendar/">Summer Programs</a></li>
          <li><a href="/student-resources/">Student Resources</a></li>
          <li><a href="/donate/">Support KPMS</a></li>
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
      </div>
    </div>
  </div>
</footer>

<!-- FLOATING PROGRESS WIDGET -->
<div class="progress-float" id="progressFloat">
  <div class="progress-float-header">
    <span class="progress-float-title">Campaign Goal</span>
    <span class="progress-float-amount" id="progressFloatAmount">Loading...</span>
  </div>
  <div class="progress-bar-bg">
    <div class="progress-bar-fill" id="progressFloatBar" style="width: 0%"></div>
  </div>
  <div class="progress-float-sub" id="progressFloatSub">Loading campaign progress...</div>
</div>

<script>
(function() {
  'use strict';

  var API = '<?php echo esc_url(rest_url("kpms/v1/")); ?>';
  var NONCE = '<?php echo $kpms_nonce; ?>';

  var selectedAmount = 0;
  var donationType = 'zakat';

  // Elements
  var stepAmount = document.getElementById('stepAmount');
  var stepInfo = document.getElementById('stepInfo');
  var stepSuccess = document.getElementById('stepSuccess');
  var errorEl = document.getElementById('donError');
  var customInput = document.getElementById('customAmount');
  var btnNext = document.getElementById('btnNext');
  var btnBack = document.getElementById('btnBack');
  var btnSubmit = document.getElementById('btnSubmit');
  var amtBtns = document.querySelectorAll('.don-amt-btn');
  var typeBtns = document.querySelectorAll('.don-type-btn');

  // Load campaign progress
  function loadProgress() {
    fetch(API + 'campaign/progress?campaign=ramadan-2026')
      .then(function(r) { return r.json(); })
      .then(function(data) {
        var pct = Math.min(data.percent || 0, 100);
        var raised = fmt(data.total_raised);
        var goal = fmt(data.goal_amount);
        var donors = data.total_donors || 0;

        // Update floating widget
        var floatAmount = document.getElementById('progressFloatAmount');
        var floatBar = document.getElementById('progressFloatBar');
        var floatSub = document.getElementById('progressFloatSub');
        if (floatAmount) floatAmount.textContent = '$' + raised + ' / $' + goal;
        if (floatBar) floatBar.style.width = pct + '%';
        if (floatSub) floatSub.textContent = donors + ' supporter' + (donors !== 1 ? 's' : '') + ' so far';
      })
      .catch(function() {});
  }

  // Amount selection
  amtBtns.forEach(function(btn) {
    btn.addEventListener('click', function() {
      amtBtns.forEach(function(b) { b.classList.remove('active'); });
      btn.classList.add('active');
      customInput.value = '';
      selectedAmount = parseFloat(btn.dataset.amount);
      updateNext();
    });
  });

  // Custom amount
  customInput.addEventListener('input', function() {
    amtBtns.forEach(function(b) { b.classList.remove('active'); });
    selectedAmount = parseFloat(customInput.value) || 0;
    updateNext();
  });

  // Type toggle
  typeBtns.forEach(function(btn) {
    btn.addEventListener('click', function() {
      typeBtns.forEach(function(b) { b.classList.remove('active'); });
      btn.classList.add('active');
      donationType = btn.dataset.type;
    });
  });

  function updateNext() {
    btnNext.disabled = !(selectedAmount >= 1);
  }

  // Navigation between steps
  btnNext.addEventListener('click', function() {
    if (selectedAmount < 1) return;
    stepAmount.classList.remove('active');
    stepInfo.classList.add('active');
    hideError();
  });

  btnBack.addEventListener('click', function() {
    stepInfo.classList.remove('active');
    stepAmount.classList.add('active');
    hideError();
  });

  // Submit pledge
  btnSubmit.addEventListener('click', function() {
    hideError();

    var name = document.getElementById('donorName').value.trim();
    var email = document.getElementById('donorEmail').value.trim();
    var phone = document.getElementById('donorPhone').value.trim();
    var msg = document.getElementById('donorMessage').value.trim();
    var anon = document.getElementById('donorAnon').checked;

    if (!name) return showError('Please enter your full name.');
    if (!email || !email.match(/^[^\s@]+@[^\s@]+\.[^\s@]+$/)) return showError('Please enter a valid email address.');
    if (selectedAmount < 1 || selectedAmount > 100000) return showError('Amount must be between $1 and $100,000.');

    btnSubmit.classList.add('loading');
    btnSubmit.disabled = true;

    fetch(API + 'donate/pledge', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-WP-Nonce': NONCE
      },
      body: JSON.stringify({
        donor_name: name,
        donor_email: email,
        donor_phone: phone,
        amount: selectedAmount,
        donation_type: donationType,
        donor_message: msg,
        is_anonymous: anon,
        campaign: 'ramadan-2026'
      })
    })
    .then(function(r) { return r.json(); })
    .then(function(data) {
      btnSubmit.classList.remove('loading');
      btnSubmit.disabled = false;

      if (data.code) {
        showError(data.message || 'Something went wrong. Please try again.');
        return;
      }

      // Show success
      stepInfo.classList.remove('active');
      stepSuccess.classList.add('active');

      document.getElementById('pledgeAmount').textContent = '$' + fmt(selectedAmount);
      var typeLabels = { zakat: 'Zakat', sadaqah: 'Sadaqah', general: 'General' };
      document.getElementById('pledgeType').textContent = typeLabels[donationType] || donationType;
      document.getElementById('refCode').textContent = data.reference;

      // Zelle info
      var zelleEl = document.getElementById('zelleInfo');
      if (data.zelle && (data.zelle.email || data.zelle.phone)) {
        var html = '<h5>Send via Zelle</h5>';
        if (data.zelle.name) html += '<p><strong>To:</strong> ' + esc(data.zelle.name) + '</p>';
        if (data.zelle.email) html += '<p><strong>Email:</strong> ' + esc(data.zelle.email) + '</p>';
        if (data.zelle.phone) html += '<p><strong>Phone:</strong> ' + esc(data.zelle.phone) + '</p>';
        html += '<p><strong>Memo:</strong> ' + esc(data.reference) + '</p>';
        zelleEl.innerHTML = html;
      } else {
        zelleEl.style.display = 'none';
      }

      // Wire info
      var wireEl = document.getElementById('wireInfo');
      if (data.wire && data.wire.bank_name) {
        var whtml = '<h5>Wire Transfer</h5>';
        whtml += '<p><strong>Bank:</strong> ' + esc(data.wire.bank_name) + '</p>';
        if (data.wire.account_name) whtml += '<p><strong>Account Name:</strong> ' + esc(data.wire.account_name) + '</p>';
        if (data.wire.routing_number) whtml += '<p><strong>Routing:</strong> ' + esc(data.wire.routing_number) + '</p>';
        if (data.wire.account_number) whtml += '<p><strong>Account:</strong> ' + esc(data.wire.account_number) + '</p>';
        if (data.wire.swift_code) whtml += '<p><strong>SWIFT:</strong> ' + esc(data.wire.swift_code) + '</p>';
        whtml += '<p><strong>Memo:</strong> ' + esc(data.reference) + '</p>';
        wireEl.innerHTML = whtml;
      } else {
        wireEl.style.display = 'none';
      }

      loadProgress();
    })
    .catch(function() {
      btnSubmit.classList.remove('loading');
      btnSubmit.disabled = false;
      showError('Network error. Please check your connection and try again.');
    });
  });

  function showError(msg) {
    errorEl.textContent = msg;
    errorEl.style.display = 'block';
  }
  function hideError() {
    errorEl.style.display = 'none';
  }
  function fmt(n) {
    return parseFloat(n).toLocaleString('en-US', { minimumFractionDigits: 0, maximumFractionDigits: 2 });
  }
  function esc(s) {
    var div = document.createElement('div');
    div.appendChild(document.createTextNode(s));
    return div.innerHTML;
  }

  // Init
  loadProgress();

  // Sticky nav shadow
  window.addEventListener('scroll', function() {
    document.getElementById('nav').classList.toggle('scrolled', window.scrollY > 10);
  });

  // Mobile nav
  <?php include get_stylesheet_directory() . '/mobile-menu-js.php'; ?>

  // Search overlay
  window.toggleSearch = function() {
    var overlay = document.getElementById('searchOverlay');
    overlay.classList.toggle('open');
    if (overlay.classList.contains('open')) {
      setTimeout(function() { document.getElementById('searchInput').focus(); }, 100);
    }
  };

  document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
      document.getElementById('searchOverlay').classList.remove('open');
      document.getElementById('mobileNav').classList.remove('open');
    }
    if ((e.metaKey || e.ctrlKey) && e.key === 'k') {
      e.preventDefault();
      toggleSearch();
    }
  });

  // Scroll reveal
  var reveals = document.querySelectorAll('.reveal');
  var obs = new IntersectionObserver(function(entries) {
    entries.forEach(function(e) { if (e.isIntersecting) e.target.classList.add('visible'); });
  }, { threshold: 0.12, rootMargin: '0px 0px -40px 0px' });
  reveals.forEach(function(el) { obs.observe(el); });

  // Floating progress widget - show after scrolling past hero
  var progressFloat = document.getElementById('progressFloat');
  window.addEventListener('scroll', function() {
    progressFloat.classList.toggle('visible', window.scrollY > 600);
  });

  // CTA smooth scroll to top
  var ctaBtn = document.querySelector('.cta-donate-btn');
  if (ctaBtn) {
    ctaBtn.addEventListener('click', function(e) {
      e.preventDefault();
      window.scrollTo({ top: 0, behavior: 'smooth' });
    });
  }

  // Smooth scroll for anchor links
  document.querySelectorAll('a[href^="#"]').forEach(function(anchor) {
    anchor.addEventListener('click', function(e) {
      var href = this.getAttribute('href');
      if (href === '#main-content') return; // handled by CTA above or skip link
      var target = document.querySelector(href);
      if (target) {
        e.preventDefault();
        target.scrollIntoView({ behavior: 'smooth', block: 'start' });
      }
    });
  });
})();
</script>

</body>
</html>
