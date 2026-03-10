// ===== MOBILE MENU =====
(function() {
    var menu = document.getElementById('kpmsMobileMenu');
    if (!menu) return;

    var openBtn = document.querySelector('.mobile-toggle');
    var closeBtn = document.getElementById('mobileMenuClose');

    if (!openBtn) return;

    function openMenu() {
        menu.classList.add('open');
        document.body.classList.add('mobile-menu-open');
        document.body.dataset.scrollY = window.scrollY;
        document.body.style.top = '-' + window.scrollY + 'px';
    }

    function closeMenu() {
        menu.classList.remove('open');
        document.body.classList.remove('mobile-menu-open');
        var scrollY = document.body.style.top;
        document.body.style.top = '';
        window.scrollTo(0, parseInt(scrollY || '0') * -1);
    }

    openBtn.addEventListener('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        openMenu();
    });

    if (closeBtn) {
        closeBtn.addEventListener('click', function(e) {
            e.preventDefault();
            closeMenu();
        });
    }

    // Accordion toggles
    var headings = menu.querySelectorAll('.mobile-menu-heading');
    headings.forEach(function(heading) {
        heading.addEventListener('click', function() {
            var targetId = this.getAttribute('data-toggle');
            var submenu = document.getElementById(targetId);
            var icon = this.querySelector('.mobile-menu-icon');

            // Close all other submenus
            headings.forEach(function(other) {
                if (other !== heading) {
                    other.classList.remove('expanded');
                    var otherIcon = other.querySelector('.mobile-menu-icon');
                    if (otherIcon) otherIcon.textContent = '+';
                    var otherId = other.getAttribute('data-toggle');
                    var otherSub = document.getElementById(otherId);
                    if (otherSub) otherSub.classList.remove('open');
                }
            });

            // Toggle this submenu
            if (submenu.classList.contains('open')) {
                submenu.classList.remove('open');
                this.classList.remove('expanded');
                if (icon) icon.textContent = '+';
            } else {
                submenu.classList.add('open');
                this.classList.add('expanded');
                if (icon) icon.textContent = '\u2212';
            }
        });
    });

    // Close menu when a link is clicked
    menu.querySelectorAll('a').forEach(function(link) {
        link.addEventListener('click', function() {
            closeMenu();
        });
    });

    // Close on escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && menu.classList.contains('open')) {
            closeMenu();
        }
    });
})();
