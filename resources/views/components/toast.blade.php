<div id="toast-container"
     class="fixed top-5 right-5 z-[9999] flex flex-col gap-3 max-w-sm sm:max-w-md w-full pointer-events-none px-4 sm:px-0"
     role="region"
     aria-live="polite"
     aria-label="Notifikasi">
</div>

<template id="toast-template">
    <div class="toast-item pointer-events-auto bg-white border rounded-2xl p-4 shadow-[0_10px_30px_rgba(24,63,50,0.12)] flex items-start gap-3.5 transition-all duration-300 transform translate-x-full opacity-0 overflow-hidden relative group">
        <!-- Accent indicator line on top/left -->
        <div class="toast-indicator absolute left-0 top-0 bottom-0 w-1.5"></div>

        <!-- Icon container -->
        <div class="toast-icon-box w-9 h-9 rounded-xl flex items-center justify-center shrink-0 mt-0.5">
            <!-- Icon SVG inserted dynamically -->
        </div>

        <!-- Content -->
        <div class="flex-1 min-w-0 pr-2">
            <h4 class="toast-title text-label font-bold text-ink leading-snug"></h4>
            <p class="toast-message text-caption sm:text-body text-muted mt-0.5 break-words leading-relaxed"></p>
        </div>

        <!-- Close Button -->
        <button type="button"
                class="toast-close text-muted hover:text-ink w-7 h-7 rounded-lg hover:bg-ivory flex items-center justify-center shrink-0 transition-colors"
                aria-label="Tutup notifikasi">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>

        <!-- Progress bar timer -->
        <div class="toast-progress absolute bottom-0 left-0 right-0 h-0.5 opacity-60">
            <div class="toast-progress-bar h-full transition-all linear"></div>
        </div>
    </div>
</template>

<script>
(function() {
    const container = document.getElementById('toast-container');
    const template = document.getElementById('toast-template');

    const config = {
        success: {
            title: 'Berhasil',
            borderColor: 'border-[#92DEB4]',
            indicatorBg: 'bg-forest',
            iconBoxBg: 'bg-soft text-forest',
            progressBg: 'bg-forest',
            icon: `<svg class="w-5 h-5 text-forest" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>`
        },
        error: {
            title: 'Gagal',
            borderColor: 'border-[#F2BFB5]',
            indicatorBg: 'bg-[#903E35]',
            iconBoxBg: 'bg-[#F8E2DC] text-[#903E35]',
            progressBg: 'bg-[#903E35]',
            icon: `<svg class="w-5 h-5 text-[#903E35]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>`
        },
        warning: {
            title: 'Peringatan',
            borderColor: 'border-[#F5C563]/50',
            indicatorBg: 'bg-[#E5A83B]',
            iconBoxBg: 'bg-amber-50 text-[#C27803]',
            progressBg: 'bg-[#E5A83B]',
            icon: `<svg class="w-5 h-5 text-[#C27803]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>`
        },
        info: {
            title: 'Informasi',
            borderColor: 'border-line',
            indicatorBg: 'bg-forest',
            iconBoxBg: 'bg-soft text-forest',
            progressBg: 'bg-forest',
            icon: `<svg class="w-5 h-5 text-forest" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>`
        }
    };

    window.showToast = function(message, type = 'success', title = null, duration = 4500) {
        if (!container || !template) return;
        const typeConf = config[type] || config.info;
        const node = template.content.cloneNode(true);
        const toast = node.querySelector('.toast-item');

        toast.classList.add(typeConf.borderColor);
        toast.querySelector('.toast-indicator').classList.add(typeConf.indicatorBg);
        
        const iconBox = toast.querySelector('.toast-icon-box');
        iconBox.className += ' ' + typeConf.iconBoxBg;
        iconBox.innerHTML = typeConf.icon;

        toast.querySelector('.toast-title').textContent = title || typeConf.title;
        toast.querySelector('.toast-message').textContent = message;

        const progressBar = toast.querySelector('.toast-progress-bar');
        progressBar.classList.add(typeConf.progressBg);
        progressBar.style.width = '100%';

        let timerId = null;
        let remaining = duration;
        let startTime = Date.now();

        function dismiss() {
            toast.classList.remove('translate-x-0', 'opacity-100');
            toast.classList.add('translate-x-full', 'opacity-0');
            setTimeout(() => toast.remove(), 320);
        }

        toast.querySelector('.toast-close').addEventListener('click', dismiss);

        function startTimer() {
            startTime = Date.now();
            progressBar.style.transition = `width ${remaining}ms linear`;
            progressBar.style.width = '0%';
            timerId = setTimeout(dismiss, remaining);
        }

        function pauseTimer() {
            clearTimeout(timerId);
            const elapsed = Date.now() - startTime;
            remaining = Math.max(0, remaining - elapsed);
            const currentWidthPercent = (remaining / duration) * 100;
            progressBar.style.transition = 'none';
            progressBar.style.width = currentWidthPercent + '%';
        }

        toast.addEventListener('mouseenter', pauseTimer);
        toast.addEventListener('mouseleave', () => {
            if (remaining > 0) startTimer();
        });

        container.appendChild(toast);

        // Trigger smooth entrance animation
        requestAnimationFrame(() => {
            toast.classList.remove('translate-x-full', 'opacity-0');
            toast.classList.add('translate-x-0', 'opacity-100');
            startTimer();
        });
    };

    // Auto display session flashes from backend
    @if(session('notice'))
        window.addEventListener('DOMContentLoaded', () => {
            window.showToast(@json(session('notice')), 'success');
        });
    @endif

    @if(session('success'))
        window.addEventListener('DOMContentLoaded', () => {
            window.showToast(@json(session('success')), 'success');
        });
    @endif

    @if(session('status'))
        window.addEventListener('DOMContentLoaded', () => {
            window.showToast(@json(session('status')), 'info');
        });
    @endif

    @if(session('error'))
        window.addEventListener('DOMContentLoaded', () => {
            window.showToast(@json(session('error')), 'error');
        });
    @endif

    @if(session('warning'))
        window.addEventListener('DOMContentLoaded', () => {
            window.showToast(@json(session('warning')), 'warning');
        });
    @endif

    @if(session('evidence_sent'))
        window.addEventListener('DOMContentLoaded', () => {
            window.showToast('Bukti berhasil dikirim dan menunggu verifikasi admin!', 'success', 'Misi Dikirim');
        });
    @endif

    @if($errors->any())
        window.addEventListener('DOMContentLoaded', () => {
            window.showToast(@json($errors->first()), 'error', 'Pemeriksaan Formulir');
        });
    @endif
})();
</script>
