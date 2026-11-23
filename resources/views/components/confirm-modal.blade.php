<div id="confirm-modal-backdrop"
     class="fixed inset-0 bg-ink/60 backdrop-blur-xs z-[9998] hidden items-center justify-center p-4 transition-all duration-200 opacity-0"
     role="dialog"
     aria-modal="true"
     aria-labelledby="confirm-modal-title"
     aria-describedby="confirm-modal-message">
    
    <div id="confirm-modal-card"
         class="bg-white border border-line rounded-container max-w-md w-full p-6 sm:p-7 shadow-[0_20px_50px_rgba(24,63,50,0.18)] flex flex-col gap-5 transform scale-95 transition-all duration-200">
        
        <!-- Header with Icon & Title -->
        <div class="flex items-start gap-4">
            <div id="confirm-modal-icon-box"
                 class="w-12 h-12 rounded-2xl flex items-center justify-center shrink-0">
                <!-- SVG Icon injected -->
            </div>
            <div class="flex-1 min-w-0 pt-0.5">
                <h3 id="confirm-modal-title" class="text-section text-ink font-bold leading-tight"></h3>
                <p id="confirm-modal-message" class="text-body text-muted mt-1.5 leading-relaxed"></p>
            </div>
        </div>

        <!-- Actions -->
        <div class="flex items-center justify-end gap-3 pt-2 border-t border-line/60">
            <button type="button"
                    id="confirm-modal-cancel"
                    class="inline-flex items-center justify-center min-h-[42px] px-5 rounded-btn bg-white border border-line text-ink text-label font-semibold hover:bg-soft transition-all cursor-pointer">
                Batal
            </button>
            <button type="button"
                    id="confirm-modal-confirm"
                    class="inline-flex items-center justify-center min-h-[42px] px-6 rounded-btn text-white text-label font-bold transition-all shadow-sm cursor-pointer">
                Ya, lanjutkan
            </button>
        </div>
    </div>
</div>

<script>
(function() {
    const backdrop = document.getElementById('confirm-modal-backdrop');
    const card = document.getElementById('confirm-modal-card');
    const titleEl = document.getElementById('confirm-modal-title');
    const messageEl = document.getElementById('confirm-modal-message');
    const iconBox = document.getElementById('confirm-modal-icon-box');
    const cancelBtn = document.getElementById('confirm-modal-cancel');
    const confirmBtn = document.getElementById('confirm-modal-confirm');

    let onConfirmCallback = null;

    const icons = {
        danger: {
            iconBg: 'bg-[#F8E2DC] text-[#903E35]',
            btnBg: 'bg-[#903E35] hover:bg-[#7b332b]',
            svg: `<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>`
        },
        primary: {
            iconBg: 'bg-soft text-forest',
            btnBg: 'bg-forest hover:bg-forest-hover',
            svg: `<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>`
        }
    };

    function closeModal() {
        if (!backdrop) return;
        backdrop.classList.add('opacity-0');
        card.classList.remove('scale-100');
        card.classList.add('scale-95');
        setTimeout(() => {
            backdrop.classList.remove('flex');
            backdrop.classList.add('hidden');
            onConfirmCallback = null;
        }, 180);
    }

    window.openConfirmModal = function({
        title = 'Konfirmasi Tindakan',
        message = 'Apakah kamu yakin ingin melanjutkan tindakan ini?',
        confirmText = 'Ya, lanjutkan',
        cancelText = 'Batal',
        variant = 'primary',
        onConfirm = null
    } = {}) {
        if (!backdrop) return;
        titleEl.textContent = title;
        messageEl.textContent = message;
        confirmBtn.textContent = confirmText;
        cancelBtn.textContent = cancelText;
        onConfirmCallback = onConfirm;

        const style = icons[variant] || icons.primary;
        iconBox.className = 'w-12 h-12 rounded-2xl flex items-center justify-center shrink-0 ' + style.iconBg;
        iconBox.innerHTML = style.svg;

        confirmBtn.className = 'inline-flex items-center justify-center min-h-[42px] px-6 rounded-btn text-white text-label font-bold transition-all shadow-sm cursor-pointer ' + style.btnBg;

        backdrop.classList.remove('hidden');
        backdrop.classList.add('flex');
        requestAnimationFrame(() => {
            backdrop.classList.remove('opacity-0');
            card.classList.remove('scale-95');
            card.classList.add('scale-100');
            confirmBtn.focus();
        });
    };

    cancelBtn.addEventListener('click', closeModal);
    backdrop.addEventListener('click', (e) => {
        if (e.target === backdrop) closeModal();
    });

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && !backdrop.classList.contains('hidden')) {
            closeModal();
        }
    });

    confirmBtn.addEventListener('click', () => {
        const callback = onConfirmCallback;
        closeModal();
        if (typeof callback === 'function') {
            callback();
        }
    });

    // Intercept clicks on elements with data-confirm
    document.addEventListener('submit', function(e) {
        const form = e.target;
        if (form.dataset.confirmed === 'true') {
            form.removeAttribute('data-confirmed');
            return;
        }

        const confirmMsg = form.getAttribute('data-confirm');
        if (confirmMsg) {
            e.preventDefault();
            window.openConfirmModal({
                title: form.getAttribute('data-confirm-title') || 'Konfirmasi Tindakan',
                message: confirmMsg,
                confirmText: form.getAttribute('data-confirm-btn') || 'Ya, lanjutkan',
                cancelText: form.getAttribute('data-confirm-cancel') || 'Batal',
                variant: form.getAttribute('data-confirm-variant') || 'primary',
                onConfirm: function() {
                    form.dataset.confirmed = 'true';
                    form.submit();
                }
            });
        }
    });

    document.addEventListener('click', function(e) {
        const btn = e.target.closest('button[data-confirm], a[data-confirm]');
        if (!btn) return;
        if (btn.tagName === 'BUTTON' && btn.type === 'submit' && btn.form) {
            if (btn.form.dataset.confirmed === 'true') {
                btn.form.removeAttribute('data-confirmed');
                return;
            }
            e.preventDefault();
            window.openConfirmModal({
                title: btn.getAttribute('data-confirm-title') || 'Konfirmasi Tindakan',
                message: btn.getAttribute('data-confirm'),
                confirmText: btn.getAttribute('data-confirm-btn') || 'Ya, lanjutkan',
                cancelText: btn.getAttribute('data-confirm-cancel') || 'Batal',
                variant: btn.getAttribute('data-confirm-variant') || 'primary',
                onConfirm: function() {
                    btn.form.dataset.confirmed = 'true';
                    // if button had a name or formaction, handle it
                    if (btn.hasAttribute('formaction')) {
                        btn.form.action = btn.getAttribute('formaction');
                    }
                    btn.form.requestSubmit ? btn.form.requestSubmit(btn) : btn.form.submit();
                }
            });
        }
    });
})();
</script>
