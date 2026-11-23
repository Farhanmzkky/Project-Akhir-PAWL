(function() {
    const input = document.getElementById('photos');
    if (!input) return;

    const box = document.getElementById('drop-area');
    const selection = document.getElementById('selection');
    const names = document.getElementById('file-names');
    const count = document.getElementById('file-count');
    const preview = document.getElementById('preview');
    const saved = {
        names: names ? names.textContent : '',
        count: count ? count.textContent : '',
        empty: selection ? selection.classList.contains('hidden') : true
    };
    let urls = [];

    function formatBytes(bytes) {
        if (bytes < 1024 * 1024) {
            return (bytes / 1024).toFixed(0) + ' KB';
        }
        return (bytes / (1024 * 1024)).toFixed(1) + ' MB';
    }

    function refresh() {
        const files = Array.from(input.files || []);
        urls.forEach(url => URL.revokeObjectURL(url));
        urls = [];
        if (preview) preview.replaceChildren();

        if (files.length === 0) {
            if (selection) {
                if (saved.empty) {
                    selection.classList.add('hidden');
                } else {
                    selection.classList.remove('hidden');
                    if (names) names.textContent = saved.names;
                    if (count) count.textContent = saved.count;
                }
            }
            return;
        }

        // Validate max 3 files
        if (files.length > 3) {
            if (window.showToast) {
                window.showToast('Maksimal hanya dapat memilih 3 foto.', 'error', 'Batas Foto');
            }
            input.value = '';
            refresh();
            return;
        }

        // Validate format & size
        const invalidType = files.some(file => !['image/jpeg', 'image/png'].includes(file.type));
        if (invalidType) {
            if (window.showToast) {
                window.showToast('Format foto harus berupa JPG atau PNG.', 'error', 'Format Tidak Didukung');
            }
            input.value = '';
            refresh();
            return;
        }

        const oversize = files.some(file => file.size > 5 * 1024 * 1024);
        if (oversize) {
            if (window.showToast) {
                window.showToast('Ukuran foto melebihi batas 5 MB per file.', 'error', 'File Terlalu Besar');
            }
            input.value = '';
            refresh();
            return;
        }

        // Valid selection
        if (selection) {
            selection.classList.remove('hidden');
            if (names) names.textContent = files.map(f => f.name).join(' · ');
            if (count) count.textContent = files.length + ' foto baru dipilih (siap diunggah)';
        }

        if (window.showToast) {
            window.showToast(files.length + ' foto berhasil dipilih.', 'success', 'Foto Terpilih');
        }

        // Render rich preview
        if (preview) {
            files.forEach((file, index) => {
                const url = URL.createObjectURL(file);
                urls.push(url);

                const card = document.createElement('div');
                card.className = 'relative w-28 h-28 rounded-2xl overflow-hidden border-2 border-line bg-ivory shadow-xs group transition-transform duration-200 hover:scale-105';

                const img = document.createElement('img');
                img.src = url;
                img.alt = 'Pratinjau foto ' + (index + 1);
                img.className = 'w-full h-full object-cover';

                const badge = document.createElement('span');
                badge.className = 'absolute bottom-1.5 left-1.5 right-1.5 bg-ink/75 backdrop-blur-xs text-white text-[10px] font-semibold px-2 py-0.5 rounded-lg text-center truncate pointer-events-none';
                badge.textContent = formatBytes(file.size);

                card.appendChild(img);
                card.appendChild(badge);
                preview.appendChild(card);
            });

            // Add clear button
            const clearBtn = document.createElement('button');
            clearBtn.type = 'button';
            clearBtn.className = 'self-center px-3 py-1.5 rounded-btn bg-white border border-line text-caption text-[#903E35] font-semibold hover:bg-[#F8E2DC]/50 transition-colors cursor-pointer';
            clearBtn.textContent = 'Batal pilih foto';
            clearBtn.addEventListener('click', () => {
                input.value = '';
                refresh();
            });
            preview.appendChild(clearBtn);
        }
    }

    input.addEventListener('change', refresh);

    if (box) {
        box.addEventListener('dragover', event => {
            event.preventDefault();
            box.classList.add('border-forest', 'bg-soft/40');
        });
        box.addEventListener('dragleave', () => {
            box.classList.remove('border-forest', 'bg-soft/40');
        });
        box.addEventListener('drop', event => {
            event.preventDefault();
            box.classList.remove('border-forest', 'bg-soft/40');
            if (event.dataTransfer.files && event.dataTransfer.files.length) {
                input.files = event.dataTransfer.files;
                refresh();
            }
        });
    }
})();
