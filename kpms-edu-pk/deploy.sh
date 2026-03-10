#!/bin/bash
# ============================================================
# KPMS Theme Deployment Script
# Uploads theme files to kpms.edu.pk via FTP
# ============================================================
#
# PREREQUISITES:
#   - Install lftp:  sudo apt install lftp   (Linux/WSL)
#                    brew install lftp        (macOS)
#     OR use ncftp:  sudo apt install ncftp
#
# USAGE:
#   chmod +x deploy.sh
#   ./deploy.sh
#
# The script will prompt for credentials — never hardcode them.
# ============================================================

set -e

# ---- Configuration ----
REMOTE_DIR="public_html/wp-content/themes/kpms-redesign"
SCRIPT_DIR="$(cd "$(dirname "$0")" && pwd)"

# Theme files to upload
FILES=(
    "style.css"
    "functions.php"
    "index.php"
    "kpms-homepage.php"
    "page-calendar.php"
    "page-contact.php"
    "page-enrollment.php"
    "page-lunch-menu.php"
    "page-parent-portal.php"
    "page-staff-directory.php"
    "teacher-dashboard.php"
    "teacher-ajax-handler.php"
)

# ---- Prompt for credentials ----
echo "====================================="
echo "  KPMS Theme Deployment"
echo "====================================="
echo ""

read -p "FTP Host [server60.hndservers.net]: " FTP_HOST
FTP_HOST="${FTP_HOST:-server60.hndservers.net}"

read -p "FTP Username: " FTP_USER
if [ -z "$FTP_USER" ]; then
    echo "Error: Username is required."
    exit 1
fi

read -sp "FTP Password: " FTP_PASS
echo ""

read -p "FTP Port [21]: " FTP_PORT
FTP_PORT="${FTP_PORT:-21}"

# ---- Verify local files exist ----
echo ""
echo "Checking local files..."
MISSING=0
for f in "${FILES[@]}"; do
    if [ ! -f "$SCRIPT_DIR/$f" ]; then
        echo "  MISSING: $f"
        MISSING=1
    else
        SIZE=$(wc -c < "$SCRIPT_DIR/$f" | tr -d ' ')
        echo "  OK: $f ($SIZE bytes)"
    fi
done

if [ "$MISSING" -eq 1 ]; then
    echo ""
    echo "Error: Some files are missing. Aborting."
    exit 1
fi

echo ""
echo "All ${#FILES[@]} files found."
echo ""

# ---- Choose upload method ----
if command -v lftp &> /dev/null; then
    echo "Using lftp for upload..."
    echo ""

    lftp -u "$FTP_USER","$FTP_PASS" -p "$FTP_PORT" "$FTP_HOST" <<LFTP_SCRIPT
set ssl:verify-certificate no
set ftp:passive-mode yes
mkdir -p "$REMOTE_DIR"
cd "$REMOTE_DIR"
lcd "$SCRIPT_DIR"
$(for f in "${FILES[@]}"; do echo "put $f"; done)
ls
bye
LFTP_SCRIPT

    echo ""
    echo "Upload complete via lftp!"

elif command -v ncftpput &> /dev/null; then
    echo "Using ncftpput for upload..."
    echo ""

    # Build file list with full paths
    FILE_PATHS=""
    for f in "${FILES[@]}"; do
        FILE_PATHS="$FILE_PATHS $SCRIPT_DIR/$f"
    done

    ncftpput -u "$FTP_USER" -p "$FTP_PASS" -P "$FTP_PORT" \
        "$FTP_HOST" "$REMOTE_DIR" $FILE_PATHS

    echo ""
    echo "Upload complete via ncftpput!"

elif command -v curl &> /dev/null; then
    echo "Using curl for FTP upload (slower but widely available)..."
    echo ""

    for f in "${FILES[@]}"; do
        echo "  Uploading: $f"
        curl -s --ftp-create-dirs \
            -T "$SCRIPT_DIR/$f" \
            "ftp://$FTP_HOST:$FTP_PORT/$REMOTE_DIR/$f" \
            --user "$FTP_USER:$FTP_PASS"
    done

    echo ""
    echo "Upload complete via curl!"

else
    echo "Error: No FTP client found."
    echo "Install one of: lftp, ncftp, or curl"
    echo ""
    echo "  Ubuntu/Debian: sudo apt install lftp"
    echo "  macOS:         brew install lftp"
    echo "  Windows WSL:   sudo apt install lftp"
    exit 1
fi

echo ""
echo "====================================="
echo "  Theme files uploaded successfully!"
echo "====================================="
echo ""
echo "Remote location: $REMOTE_DIR/"
echo ""
echo "Next steps:"
echo "  1. Run server-setup.sh on the server (via SSH or cPanel Terminal)"
echo "  2. Or follow SETUP-GUIDE.md manually in WordPress admin"
echo ""
