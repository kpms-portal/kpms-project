# KPMS.EDU.PK — Fresh WordPress Setup Guide

## Step 1: Install WordPress via cPanel

1. Log into cPanel: `https://kpms.edu.pk:2083`
   - If domain hasn't propagated yet, use: `https://server60.hndservers.net:2083`
   - Username: `kpmsedup`
   
2. Find **Softaculous Apps Installer** (or "WordPress" in the cPanel dashboard)
3. Click **Install WordPress**
4. Settings:
   - Protocol: `https://`
   - Domain: `kpms.edu.pk`
   - Directory: (leave EMPTY — install in root)
   - Site Name: `Kamal Public Middle School`
   - Site Description: `Nurturing Young Minds Since 1985`
   - Admin Username: Choose something (NOT admin)
   - Admin Password: Choose a strong password
   - Admin Email: kpmsabbottabad@gmail.com
5. Click **Install**

## Step 2: Upload Theme Files

### Option A: Via cPanel File Manager
1. In cPanel, click **File Manager**
2. Navigate to: `public_html/wp-content/themes/`
3. Create a new folder called: `kpms-redesign`
4. Open the `kpms-redesign` folder
5. Upload ALL files from the zip (9 files):
   - functions.php
   - style.css
   - kpms-homepage.php
   - page-calendar.php
   - page-contact.php
   - page-enrollment.php
   - page-lunch-menu.php
   - page-parent-portal.php
   - page-staff-directory.php

### Option B: Via FTP (for Claude Code)
- Host: `kpms.edu.pk` (or `server60.hndservers.net`)
- Username: `kpmsedup`
- Port: 21
- Upload to: `public_html/wp-content/themes/kpms-redesign/`

## Step 3: Upload Logo Image

1. In WordPress admin, go to **Media → Add New**
2. Upload the KPMS logo: `Kamal-Public-School-2.png`
   - Get it from: `https://kpms.com.pk/kpms-redesign/wp-content/uploads/2024/02/Kamal-Public-School-2.png`
   - Download it first, then upload to new site
3. After upload, copy the new image URL
4. If the URL is different from what's in the templates, you'll need to update it
   - The templates expect: `kpms.edu.pk/wp-content/uploads/2024/02/Kamal-Public-School-2.png`
   - If WordPress puts it in a different folder (like 2026/02/), update all files

## Step 4: Activate Theme

1. Go to **Appearance → Themes**
2. Find "KPMS Redesign" and click **Activate**

## Step 5: Create Pages

Create these 7 pages. For each: Add Page → Set Title → Set Slug → Select Template → Publish

| # | Page Title         | Slug              | Template                     |
|---|--------------------|--------------------|------------------------------|
| 1 | Home               | home               | KPMS - Homepage              |
| 2 | Parent Portal      | parent-portal      | KPMS - Parent Portal         |
| 3 | School Calendar    | calendar           | KPMS - School Calendar       |
| 4 | Lunch Menu         | lunch-menu         | KPMS - Lunch Menu            |
| 5 | Enrollment         | enrollment         | KPMS - Enrollment            |
| 6 | Staff Directory    | staff-directory    | KPMS - Staff Directory       |
| 7 | Contact Us         | contact            | KPMS - Contact Us            |

**Phase 3 pages (when templates are ready):**

| # | Page Title         | Slug              | Template                     |
|---|--------------------|--------------------|------------------------------|
| 8 | Mission & Vision   | mission-vision     | KPMS - Mission & Vision      |
| 9 | Philosophy         | philosophy         | KPMS - School Philosophy     |
| 10| News               | news               | KPMS - News                  |
| 11| Grade Levels       | grade-levels       | KPMS - Grade Levels          |
| 12| Campus Visit       | campus-visit       | KPMS - Campus Visit          |

## Step 6: Set Homepage

1. Go to **Settings → Reading**
2. Select: **A static page**
3. Homepage: Select **"Home"**
4. Click **Save Changes**

## Step 7: Set Permalinks

1. Go to **Settings → Permalinks**
2. Select: **Post name** (/%postname%/)
3. Click **Save Changes**

## Step 8: SSL Certificate

1. In cPanel, find **SSL/TLS** or **Let's Encrypt**
2. Install a free SSL certificate for `kpms.edu.pk`
3. In WordPress, go to **Settings → General**
4. Make sure both URLs use `https://`:
   - WordPress Address: `https://kpms.edu.pk`
   - Site Address: `https://kpms.edu.pk`

## Step 9: Test All Pages

Visit each URL and verify:
- https://kpms.edu.pk/ (homepage)
- https://kpms.edu.pk/parent-portal/
- https://kpms.edu.pk/calendar/
- https://kpms.edu.pk/lunch-menu/
- https://kpms.edu.pk/enrollment/
- https://kpms.edu.pk/staff-directory/
- https://kpms.edu.pk/contact/

## Step 10: Recommended Plugins (Optional)

- **WP File Manager** — for easy file uploads
- **WPForms Lite** — if you want working contact forms
- **UpdraftPlus** — for backups

## Notes

- No legacy Elementor pages to conflict with
- All links use clean paths: /calendar/, /contact/, etc.
- Logo URL must match: wp-content/uploads/2024/02/Kamal-Public-School-2.png
- Phase 3 templates (from Claude Code) need same URL format — no /kpms-redesign/ prefix
