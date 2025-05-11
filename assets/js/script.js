document.addEventListener('DOMContentLoaded', function() {
    // Validasi form sebelum submit
    const form = document.querySelector('form');
    if (form) {
        form.addEventListener('submit', function(e) {
            const checkboxes = document.querySelectorAll('input[type="checkbox"]:checked');
            if (checkboxes.length === 0) {
                e.preventDefault();
                alert('Pilih minimal 1 gejala!');
            }
        });
    }
});