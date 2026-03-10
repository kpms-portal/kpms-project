const fs = require('fs');

const files = [
  'kpms-homepage.php', 'page-contact.php', 'page-enrollment.php', 'page-calendar.php',
  'page-parent-portal.php', 'page-staff-directory.php', 'page-montessori.php',
  'page-primary-education.php', 'page-tuition.php', 'page-apply-online.php',
  'page-prospectus.php', 'page-schedule-tour.php', 'page-mission-vision.php',
  'page-campus.php', 'page-student-resources.php', 'page-student-games.php',
  'page-careers.php', 'page-lunch-menu.php'
];

let results = [];

files.forEach(file => {
  if (!fs.existsSync(file)) { results.push('SKIP: ' + file); return; }
  let html = fs.readFileSync(file, 'utf8');
  let changes = [];

  // 1. Add "Support" dropdown to desktop nav (before the closing </ul> of nav-menu)
  // Find the Students dropdown and add Support after it
  // Pattern: Students dropdown closing </div>\n      </li>\n    </ul>

  // Different arrow encodings across files
  const arrowPatterns = ['▼', '&#x25BC;', '&#9660;'];

  let addedSupport = false;
  for (const arrow of arrowPatterns) {
    // Look for the Students section in desktop nav
    const studentsPattern = `<a href="#">Students <span class="dropdown-arrow">${arrow}</span></a>
        <div class="dropdown">
          <a href="/student-resources/">Resources</a>
          <a href="/student-games/">Learning Games</a>
        </div>
      </li>
    </ul>`;

    const studentsReplacement = `<a href="#">Students <span class="dropdown-arrow">${arrow}</span></a>
        <div class="dropdown">
          <a href="/student-resources/">Resources</a>
          <a href="/student-games/">Learning Games</a>
        </div>
      </li>
      <li>
        <a href="#">Support <span class="dropdown-arrow">${arrow}</span></a>
        <div class="dropdown">
          <a href="/donate/">Donate</a>
          <a href="/careers/">Careers</a>
        </div>
      </li>
    </ul>`;

    if (html.includes(studentsPattern)) {
      html = html.replace(studentsPattern, studentsReplacement);
      addedSupport = true;
      changes.push('desktop-support');
      break;
    }
  }

  // Try alternative patterns if the exact match didn't work
  if (!addedSupport) {
    // Try with regex - find Students li closing and </ul>
    const regex = /(<a href="#">Students[^<]*<span class="dropdown-arrow">[^<]*<\/span><\/a>\s*<div class="dropdown">\s*<a href="\/student-resources\/">Resources<\/a>\s*<a href="\/student-games\/">Learning Games<\/a>\s*<\/div>\s*<\/li>)\s*(<\/ul>)/;
    if (regex.test(html)) {
      html = html.replace(regex, `$1
      <li>
        <a href="#">Support <span class="dropdown-arrow">▼</span></a>
        <div class="dropdown">
          <a href="/donate/">Donate</a>
          <a href="/careers/">Careers</a>
        </div>
      </li>
    $2`);
      addedSupport = true;
      changes.push('desktop-support-regex');
    }
  }

  // 2. Add Support section to mobile nav
  // Find the Students mobile section and add Support after it
  const mobileStudents = `<div class="mobile-section">
      <div class="mobile-section-title">Students</div>
      <a href="/student-resources/">Resources</a>
      <a href="/student-games/">Learning Games</a>
    </div>`;

  const mobileStudentsWithSupport = `<div class="mobile-section">
      <div class="mobile-section-title">Students</div>
      <a href="/student-resources/">Resources</a>
      <a href="/student-games/">Learning Games</a>
    </div>
    <div class="mobile-section">
      <div class="mobile-section-title">Support</div>
      <a href="/donate/">Donate</a>
      <a href="/careers/">Careers</a>
    </div>`;

  if (html.includes(mobileStudents) && !html.includes('"mobile-section-title">Support<')) {
    html = html.replace(mobileStudents, mobileStudentsWithSupport);
    changes.push('mobile-support');
  }

  // 3. Fix the homepage "Give" button -> "Donate" pointing to /donate/
  if (html.includes('<a href="/contact/" class="btn btn-outline-light">Give</a>')) {
    html = html.replace('<a href="/contact/" class="btn btn-outline-light">Give</a>', '<a href="/donate/" class="btn btn-outline-light">Donate</a>');
    changes.push('give-btn');
  }

  // Skip if Support already exists in desktop nav
  if (html.includes('>Support <span class="dropdown-arrow">') && !addedSupport) {
    changes.push('already-has-support');
  }

  fs.writeFileSync(file, html, 'utf8');
  results.push('OK: ' + file + ' [' + changes.join(', ') + ']');
});

results.forEach(r => console.log(r));
