#!/bin/bash
# ============================================================
# KPMS WordPress Setup Script
# Run this ON THE SERVER via SSH or cPanel Terminal
# ============================================================
#
# This script uses WP-CLI to:
#   1. Check/install WordPress
#   2. Activate the kpms-redesign theme
#   3. Create all pages with correct slugs and templates
#   4. Set the static homepage
#   5. Configure permalinks
#
# PREREQUISITES:
#   - WordPress installed in public_html/
#   - Theme files uploaded to wp-content/themes/kpms-redesign/
#   - WP-CLI available (most shared hosts have it)
#
# USAGE (via SSH or cPanel Terminal):
#   cd ~/public_html
#   bash /path/to/server-setup.sh
#
# If WP-CLI is not available, see the manual steps at bottom.
# ============================================================

set -e

# ---- Configuration ----
WP_PATH="${WP_PATH:-$HOME/public_html}"
THEME_SLUG="kpms-redesign"

echo "====================================="
echo "  KPMS WordPress Setup"
echo "====================================="
echo ""
echo "WordPress path: $WP_PATH"
echo ""

# ---- Check WP-CLI ----
if ! command -v wp &> /dev/null; then
    echo "WP-CLI not found. Attempting to download..."
    curl -O https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar
    chmod +x wp-cli.phar
    WP="php wp-cli.phar --path=$WP_PATH"
    echo "WP-CLI downloaded."
else
    WP="wp --path=$WP_PATH"
fi

echo ""

# ---- Check WordPress Installation ----
echo "[1/6] Checking WordPress installation..."
if $WP core is-installed 2>/dev/null; then
    echo "  WordPress is installed."
    $WP core version
else
    echo "  WordPress is NOT installed."
    echo ""
    echo "  Checking if WordPress files exist..."
    if [ -f "$WP_PATH/wp-config.php" ]; then
        echo "  wp-config.php found but WP not fully installed."
        echo "  Please complete installation at: https://kpms.edu.pk/wp-admin/install.php"
        exit 1
    else
        echo "  No WordPress files found. Downloading..."
        $WP core download --locale=en_US
        echo ""
        echo "  WordPress files downloaded."
        echo "  Please complete setup at: https://kpms.edu.pk/wp-admin/install.php"
        echo "  Then run this script again."
        exit 1
    fi
fi

echo ""

# ---- Verify Theme Files ----
echo "[2/6] Verifying theme files..."
THEME_DIR="$WP_PATH/wp-content/themes/$THEME_SLUG"
if [ -f "$THEME_DIR/style.css" ] && [ -f "$THEME_DIR/functions.php" ]; then
    echo "  Theme found at: $THEME_DIR"
    TEMPLATE_COUNT=$(ls "$THEME_DIR"/*.php 2>/dev/null | wc -l)
    echo "  PHP files: $TEMPLATE_COUNT"
else
    echo "  ERROR: Theme not found at $THEME_DIR"
    echo "  Please upload theme files first (run deploy.sh or upload manually)"
    exit 1
fi

echo ""

# ---- Activate Theme ----
echo "[3/6] Activating theme: $THEME_SLUG..."
CURRENT_THEME=$($WP theme list --status=active --field=name 2>/dev/null || echo "unknown")
if [ "$CURRENT_THEME" = "$THEME_SLUG" ]; then
    echo "  Theme is already active."
else
    $WP theme activate "$THEME_SLUG"
    echo "  Theme activated!"
fi

echo ""

# ---- Create Pages ----
echo "[4/6] Creating pages with templates..."

# Function to create a page if it doesn't already exist
create_page() {
    local TITLE="$1"
    local SLUG="$2"
    local TEMPLATE="$3"

    # Check if page with this slug already exists
    EXISTING=$($WP post list --post_type=page --name="$SLUG" --field=ID 2>/dev/null || echo "")

    if [ -n "$EXISTING" ]; then
        echo "  Page '$TITLE' (/$SLUG/) already exists (ID: $EXISTING)"
        # Update the template in case it's wrong
        $WP post meta update "$EXISTING" _wp_page_template "$TEMPLATE" 2>/dev/null
        echo "    -> Template set to: $TEMPLATE"
    else
        PAGE_ID=$($WP post create \
            --post_type=page \
            --post_title="$TITLE" \
            --post_name="$SLUG" \
            --post_status=publish \
            --porcelain)
        $WP post meta update "$PAGE_ID" _wp_page_template "$TEMPLATE"
        echo "  Created: '$TITLE' (/$SLUG/) -> ID: $PAGE_ID, Template: $TEMPLATE"
    fi
}

create_page "Home"             "home"             "kpms-homepage.php"
create_page "Parent Portal"    "parent-portal"    "page-parent-portal.php"
create_page "School Calendar"  "calendar"         "page-calendar.php"
create_page "Lunch Menu"       "lunch-menu"       "page-lunch-menu.php"
create_page "Enrollment"       "enrollment"       "page-enrollment.php"
create_page "Staff Directory"  "staff-directory"  "page-staff-directory.php"
create_page "Contact Us"       "contact"          "page-contact.php"

echo ""

# ---- Set Static Homepage ----
echo "[5/6] Setting static homepage..."
HOME_ID=$($WP post list --post_type=page --name="home" --field=ID 2>/dev/null || echo "")

if [ -n "$HOME_ID" ]; then
    $WP option update show_on_front page
    $WP option update page_on_front "$HOME_ID"
    echo "  Homepage set to 'Home' page (ID: $HOME_ID)"
else
    echo "  WARNING: Could not find 'Home' page to set as front page"
fi

echo ""

# ---- Set Permalinks ----
echo "[6/6] Configuring permalinks..."
$WP rewrite structure '/%postname%/' --hard 2>/dev/null || \
    $WP option update permalink_structure '/%postname%/'
$WP rewrite flush --hard 2>/dev/null || true
echo "  Permalinks set to: /%postname%/"

echo ""
echo "====================================="
echo "  Setup Complete!"
echo "====================================="
echo ""
echo "  Your site should now be live at:"
echo "    https://kpms.edu.pk/"
echo ""
echo "  Pages created:"
echo "    https://kpms.edu.pk/                  (Homepage)"
echo "    https://kpms.edu.pk/parent-portal/"
echo "    https://kpms.edu.pk/calendar/"
echo "    https://kpms.edu.pk/lunch-menu/"
echo "    https://kpms.edu.pk/enrollment/"
echo "    https://kpms.edu.pk/staff-directory/"
echo "    https://kpms.edu.pk/contact/"
echo ""
echo "  Next steps:"
echo "    1. Visit https://kpms.edu.pk/ to verify"
echo "    2. Upload logo via Media -> Add New"
echo "    3. Install SSL certificate via cPanel"
echo "    4. Install recommended plugins (WPForms, UpdraftPlus)"
echo ""

# ============================================================
# MANUAL STEPS (if WP-CLI is not available)
# ============================================================
#
# If your host doesn't support WP-CLI, do this in wp-admin:
#
# 1. ACTIVATE THEME:
#    Appearance -> Themes -> Find "KPMS Redesign" -> Activate
#
# 2. CREATE PAGES (Pages -> Add New, for each):
#    Title: Home             | Slug: home           | Template: KPMS - Homepage
#    Title: Parent Portal    | Slug: parent-portal   | Template: KPMS - Parent Portal
#    Title: School Calendar  | Slug: calendar        | Template: KPMS - School Calendar
#    Title: Lunch Menu       | Slug: lunch-menu      | Template: KPMS - Lunch Menu
#    Title: Enrollment       | Slug: enrollment      | Template: KPMS - Enrollment
#    Title: Staff Directory  | Slug: staff-directory  | Template: KPMS - Staff Directory
#    Title: Contact Us       | Slug: contact         | Template: KPMS - Contact Us
#
# 3. SET HOMEPAGE:
#    Settings -> Reading -> "A static page" -> Homepage: "Home" -> Save
#
# 4. PERMALINKS:
#    Settings -> Permalinks -> "Post name" -> Save
#
# ============================================================
