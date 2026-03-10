/* ===== LOCK HORIZONTAL SCROLL ON MOBILE ===== */
html { overflow-x: hidden; }
*, *::before, *::after { max-width: 100vw; }
img, video, iframe, embed, object { max-width: 100%; height: auto; }
main, #page, #content { overflow-x: hidden; }
@media (max-width: 768px) {
    section { overflow-x: hidden; max-width: 100vw; }
    .hero-section h1, .hero-section h2, .hero-content h1, .hero-content h2 {
        font-size: clamp(28px, 7vw, 48px) !important;
        word-wrap: break-word; overflow-wrap: break-word;
    }
}

/* ===== MOBILE MENU — DANA HALL INSPIRED ===== */
.kpms-mobile-menu {
    position: fixed;
    inset: 0;
    background: #fff;
    z-index: 999999;
    display: flex;
    flex-direction: column;
    transform: translateX(100%);
    transition: transform 0.35s cubic-bezier(0.16, 1, 0.3, 1);
    overflow-y: auto;
    -webkit-overflow-scrolling: touch;
}
.kpms-mobile-menu.open {
    transform: translateX(0);
}

/* Header */
.mobile-menu-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 20px 24px;
    border-bottom: 1px solid #f1f5f9;
    flex-shrink: 0;
}
.mobile-menu-brand {
    display: flex;
    align-items: center;
    gap: 12px;
}
.mobile-menu-logo {
    width: 48px;
    height: 48px;
    object-fit: contain;
}
.mobile-menu-title {
    font-family: 'Playfair Display', serif;
    font-size: 24px;
    font-weight: 700;
    color: #003087;
}
.mobile-menu-close {
    background: none;
    border: none;
    color: #1a1a2e;
    cursor: pointer;
    padding: 8px;
    border-radius: 8px;
    transition: background 0.2s;
}
.mobile-menu-close:hover {
    background: #f1f5f9;
}

/* Search */
.mobile-menu-search {
    padding: 16px 24px;
    position: relative;
    flex-shrink: 0;
}
.mobile-search-input {
    width: 100%;
    padding: 14px 20px 14px 48px;
    border: 1.5px solid #e2e8f0;
    border-radius: 12px;
    font-size: 15px;
    font-family: 'DM Sans', sans-serif;
    background: #f8fafc;
    transition: border-color 0.2s;
    box-sizing: border-box;
}
.mobile-search-input:focus {
    outline: none;
    border-color: #003087;
    background: #fff;
}
.mobile-search-icon {
    position: absolute;
    left: 40px;
    top: 50%;
    transform: translateY(-50%);
}

/* Nav Items */
.mobile-menu-nav {
    flex: 1;
    padding: 8px 0;
}

/* Top-level link (no submenu) */
.mobile-menu-link {
    display: block;
    padding: 22px 28px;
    font-family: 'DM Sans', sans-serif;
    font-size: 16px;
    font-weight: 800;
    letter-spacing: 2px;
    color: #1a1a2e;
    text-decoration: none;
    border-bottom: 1px solid #f1f5f9;
    transition: background 0.15s;
}
.mobile-menu-link:hover,
.mobile-menu-link:active {
    background: #f8fafc;
    color: #003087;
}

/* Category heading with expand toggle */
.mobile-menu-heading {
    display: flex;
    align-items: center;
    justify-content: space-between;
    width: 100%;
    padding: 22px 28px;
    background: none;
    border: none;
    border-bottom: 1px solid #f1f5f9;
    font-family: 'DM Sans', sans-serif;
    font-size: 16px;
    font-weight: 800;
    letter-spacing: 2px;
    color: #1a1a2e;
    cursor: pointer;
    text-align: left;
    transition: background 0.15s;
}
.mobile-menu-heading:hover,
.mobile-menu-heading:active {
    background: #f8fafc;
}

/* The + / - icon */
.mobile-menu-icon {
    width: 38px;
    height: 38px;
    border: 2px solid #FFD100;
    border-radius: 4px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 22px;
    font-weight: 300;
    color: #1a1a2e;
    flex-shrink: 0;
    transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
    line-height: 1;
    background: transparent;
}

/* When expanded */
.mobile-menu-heading.expanded {
    color: #003087;
}
.mobile-menu-heading.expanded .mobile-menu-icon {
    background: #FFD100;
    color: #003087;
    border-color: #FFD100;
}

/* Submenu — hidden by default */
.mobile-submenu {
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.35s cubic-bezier(0.16, 1, 0.3, 1);
    background: #f8fafc;
}
.mobile-submenu.open {
    max-height: 400px;
}
.mobile-submenu a {
    display: block;
    padding: 16px 28px 16px 44px;
    font-family: 'DM Sans', sans-serif;
    font-size: 15px;
    font-weight: 500;
    color: #5a6577;
    text-decoration: none;
    border-bottom: 1px solid rgba(0,0,0,0.04);
    transition: all 0.15s;
}
.mobile-submenu a:hover,
.mobile-submenu a:active {
    color: #003087;
    background: #E8F4FD;
    padding-left: 52px;
}

/* Footer section — dark background */
.mobile-menu-footer {
    background: #003087;
    padding: 16px 0;
    flex-shrink: 0;
    margin-top: auto;
}
.mobile-footer-link {
    display: block;
    padding: 16px 28px;
    font-family: 'DM Sans', sans-serif;
    font-size: 15px;
    font-weight: 600;
    color: rgba(255,255,255,0.85);
    text-decoration: none;
    border-bottom: 1px solid rgba(255,255,255,0.1);
    transition: all 0.15s;
}
.mobile-footer-link:last-child {
    border-bottom: none;
}
.mobile-footer-link:hover {
    color: #FFD100;
    background: rgba(255,255,255,0.05);
}

/* Prevent body scroll when menu is open */
body.mobile-menu-open {
    overflow: hidden;
    position: fixed;
    width: 100%;
    height: 100%;
}
