document.addEventListener('DOMContentLoaded', function () {
    const questions = document.querySelectorAll('.question');

    questions.forEach(question => {
        question.addEventListener('click', () => {
            // Toggle active class pada question
            question.classList.toggle('active');
            
            // Ambil element answer yang berdekatan
            const answer = question.nextElementSibling;
            
            // Toggle active class pada answer
            if (answer.classList.contains('active')) {
                answer.style.maxHeight = null; // Reset jika tutup
                answer.classList.remove('active');
            } else {
                answer.style.maxHeight = answer.scrollHeight + "px"; // Hitung tinggi konten
                answer.classList.add('active');
            }
            
            // Tutup answer lain yang sedang terbuka
            questions.forEach(otherQuestion => {
                if (otherQuestion !== question) {
                    otherQuestion.classList.remove('active');
                    const otherAnswer = otherQuestion.nextElementSibling;
                    otherAnswer.style.maxHeight = null;
                    otherAnswer.classList.remove('active');
                }
            });
        });
    });
});





document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        document.querySelector(this.getAttribute('href')).scrollIntoView({
            behavior: 'smooth'
        });
    });
});
