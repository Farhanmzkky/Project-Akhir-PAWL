const input = document.getElementById('photos');
if (input) {
    const box = document.getElementById('drop-area');
    const selection = document.getElementById('selection');
    const names = document.getElementById('file-names');
    const count = document.getElementById('file-count');
    const preview = document.getElementById('preview');
    const saved = { names: names.textContent, count: count.textContent, empty: selection.hidden };
    let urls = [];

    function refresh() {
        const files = Array.from(input.files);
        urls.forEach(url => URL.revokeObjectURL(url));
        urls = [];
        preview.replaceChildren();
        input.setCustomValidity('');
        selection.hidden = saved.empty;
        names.textContent = saved.names;
        count.textContent = saved.count;
        if (!files.length) return;
        const invalid = files.some(file => file.size > 5 * 1024 * 1024 || !['image/jpeg', 'image/png'].includes(file.type));
        if (invalid || files.length > 3) {
            input.setCustomValidity('Pilih 1–3 foto JPG atau PNG, maksimal 5 MB per foto.');
            input.reportValidity();
            return;
        }
        selection.hidden = false;
        names.textContent = files.map(file => file.name).join(' · ');
        count.textContent = files.length + ' foto siap dikirim';
        files.forEach((file, index) => {
            const image = document.createElement('img');
            const url = URL.createObjectURL(file);
            urls.push(url);
            image.src = url;
            image.alt = 'Pratinjau foto ' + (index + 1);
            preview.append(image);
        });
    }

    input.addEventListener('change', refresh);
    box.addEventListener('dragover', event => {
        event.preventDefault();
        box.classList.add('drag-over');
    });
    box.addEventListener('dragleave', () => box.classList.remove('drag-over'));
    box.addEventListener('drop', event => {
        event.preventDefault();
        box.classList.remove('drag-over');
        if (event.dataTransfer.files.length) {
            input.files = event.dataTransfer.files;
            refresh();
        }
    });
}
