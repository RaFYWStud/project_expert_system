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

//Toggle Menu Hamburger
function toggleMenu() {
    const menu = document.querySelector('.hamburger-menu');
    if (menu.style.display === 'block') {
        menu.style.display = 'none';
    } else {
        menu.style.display = 'block';
    }
}

//Index progress bar
document.addEventListener('DOMContentLoaded', function () {
    const checkboxes = document.querySelectorAll('input[type="checkbox"]');
    const progress = document.getElementById('progress');

    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function () {
            const checkedCount = document.querySelectorAll('input[type="checkbox"]:checked').length;
            const totalCheckboxes = checkboxes.length;
            const progressValue = (checkedCount / totalCheckboxes) * 100;
            progress.value = progressValue;
        });
    });
});