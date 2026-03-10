(function() {
    'use strict';

    const app = document.getElementById('kpms-donate-app');
    if (!app) return;

    const API = (typeof kpmsDonate !== 'undefined') ? kpmsDonate.api : '/wp-json/kpms/v1/';
    const NONCE = (typeof kpmsDonate !== 'undefined') ? kpmsDonate.nonce : '';

    let selectedAmount = 0;
    let donationType = 'zakat';
    const campaign = app.dataset.campaign || 'ramadan-2026';
    const defaultAmount = parseInt(app.dataset.default || '100', 10);

    // Elements
    const stepAmount  = document.getElementById('kpms-step-amount');
    const stepInfo    = document.getElementById('kpms-step-info');
    const stepSuccess = document.getElementById('kpms-step-success');
    const errorEl     = document.getElementById('kpms-don-error');
    const amtBtns     = document.querySelectorAll('.kpms-don-amt');
    const customInput = document.getElementById('kpms-custom-amount');
    const typeBtns    = document.querySelectorAll('.kpms-don-type');
    const nextBtn     = document.getElementById('kpms-next-info');
    const backBtn     = document.getElementById('kpms-back-amount');
    const submitBtn   = document.getElementById('kpms-submit-pledge');

    // Load progress bar
    function loadProgress() {
        const bar = document.getElementById('kpms-progress-bar');
        if (!bar) return;

        fetch(API + 'campaign/progress?campaign=' + encodeURIComponent(campaign))
            .then(r => r.json())
            .then(data => {
                bar.innerHTML =
                    '<div class="kpms-don-progress-title">' + data.campaign_title + '</div>' +
                    '<div class="kpms-don-progress-numbers"><strong>$' + numberFormat(data.total_raised) + '</strong> raised of $' + numberFormat(data.goal_amount) + ' goal</div>' +
                    '<div class="kpms-don-progress-bar-outer"><div class="kpms-don-progress-bar-inner" style="width:' + Math.min(data.percent, 100) + '%"></div></div>' +
                    '<div class="kpms-don-progress-donors">' + data.total_donors + ' donor' + (data.total_donors !== 1 ? 's' : '') + '</div>';
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
            updateContinueBtn();
        });
    });

    // Custom amount
    customInput.addEventListener('input', function() {
        amtBtns.forEach(function(b) { b.classList.remove('active'); });
        selectedAmount = parseFloat(customInput.value) || 0;
        updateContinueBtn();
    });

    // Pre-select default amount
    amtBtns.forEach(function(btn) {
        if (parseInt(btn.dataset.amount, 10) === defaultAmount) {
            btn.click();
        }
    });

    // Type toggle
    typeBtns.forEach(function(label) {
        label.addEventListener('click', function() {
            typeBtns.forEach(function(l) { l.classList.remove('active'); });
            label.classList.add('active');
            donationType = label.dataset.type;
            var radio = label.querySelector('input');
            if (radio) radio.checked = true;
        });
    });

    function updateContinueBtn() {
        nextBtn.disabled = !(selectedAmount >= 1);
    }

    // Navigation
    nextBtn.addEventListener('click', function() {
        if (selectedAmount < 1) return;
        stepAmount.style.display = 'none';
        stepInfo.style.display = 'block';
        hideError();
    });

    backBtn.addEventListener('click', function() {
        stepInfo.style.display = 'none';
        stepAmount.style.display = 'block';
        hideError();
    });

    // Submit pledge
    submitBtn.addEventListener('click', function() {
        hideError();

        var name  = document.getElementById('kpms-donor-name').value.trim();
        var email = document.getElementById('kpms-donor-email').value.trim();
        var phone = document.getElementById('kpms-donor-phone').value.trim();
        var msg   = document.getElementById('kpms-donor-message').value.trim();
        var anon  = document.getElementById('kpms-anonymous').checked;

        if (!name) return showError('Please enter your name.');
        if (!email || !email.match(/^[^\s@]+@[^\s@]+\.[^\s@]+$/)) return showError('Please enter a valid email.');
        if (selectedAmount < 1 || selectedAmount > 100000) return showError('Amount must be between $1 and $100,000.');

        submitBtn.classList.add('loading');
        submitBtn.disabled = true;

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
                campaign: campaign
            })
        })
        .then(function(r) { return r.json(); })
        .then(function(data) {
            submitBtn.classList.remove('loading');
            submitBtn.disabled = false;

            if (data.code) {
                showError(data.message || 'Something went wrong. Please try again.');
                return;
            }

            // Show success
            stepInfo.style.display = 'none';
            stepSuccess.style.display = 'block';

            document.getElementById('kpms-pledge-amount').textContent = '$' + numberFormat(selectedAmount);
            document.getElementById('kpms-pledge-type').textContent = donationType === 'zakat' ? 'Zakat' : 'Sadaqah';
            document.getElementById('kpms-ref-code').textContent = data.reference;

            // Zelle info
            var zelleEl = document.getElementById('kpms-zelle-info');
            if (data.zelle && (data.zelle.email || data.zelle.phone)) {
                var html = '<h5>Zelle</h5>';
                if (data.zelle.name) html += '<p><strong>To:</strong> ' + escHtml(data.zelle.name) + '</p>';
                if (data.zelle.email) html += '<p><strong>Email:</strong> ' + escHtml(data.zelle.email) + '</p>';
                if (data.zelle.phone) html += '<p><strong>Phone:</strong> ' + escHtml(data.zelle.phone) + '</p>';
                html += '<p><strong>Memo:</strong> ' + escHtml(data.reference) + '</p>';
                zelleEl.innerHTML = html;
            } else {
                zelleEl.style.display = 'none';
            }

            // Wire info
            var wireEl = document.getElementById('kpms-wire-info');
            if (data.wire && data.wire.bank_name) {
                var whtml = '<h5>Wire Transfer</h5>';
                whtml += '<p><strong>Bank:</strong> ' + escHtml(data.wire.bank_name) + '</p>';
                if (data.wire.account_name) whtml += '<p><strong>Account Name:</strong> ' + escHtml(data.wire.account_name) + '</p>';
                if (data.wire.routing_number) whtml += '<p><strong>Routing:</strong> ' + escHtml(data.wire.routing_number) + '</p>';
                if (data.wire.account_number) whtml += '<p><strong>Account:</strong> ' + escHtml(data.wire.account_number) + '</p>';
                if (data.wire.swift_code) whtml += '<p><strong>SWIFT:</strong> ' + escHtml(data.wire.swift_code) + '</p>';
                whtml += '<p><strong>Memo:</strong> ' + escHtml(data.reference) + '</p>';
                wireEl.innerHTML = whtml;
            } else {
                wireEl.style.display = 'none';
            }

            // Refresh progress
            loadProgress();
        })
        .catch(function() {
            submitBtn.classList.remove('loading');
            submitBtn.disabled = false;
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

    function numberFormat(n) {
        return parseFloat(n).toLocaleString('en-US', { minimumFractionDigits: 0, maximumFractionDigits: 2 });
    }

    function escHtml(s) {
        var div = document.createElement('div');
        div.appendChild(document.createTextNode(s));
        return div.innerHTML;
    }

    // Init
    loadProgress();
})();
