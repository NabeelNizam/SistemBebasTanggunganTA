document.addEventListener('DOMContentLoaded', () => {
    const navLinks = document.querySelectorAll('.navbar a');

    navLinks.forEach(link => {
        link.addEventListener('click', (e) => {
            // Hapus kelas "active" dari semua tautan
            navLinks.forEach(nav => nav.classList.remove('active'));

            // Tambahkan kelas "active" pada tautan yang diklik
            e.target.classList.add('active');
        });
    });
});
