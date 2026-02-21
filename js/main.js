// Loader
window.addEventListener('load', () => {
    setTimeout(() => {
        const loader = document.querySelector('.loader');
        if (loader) loader.classList.add('hidden');
    }, 1000);
});

// Login modal
const loginModal = document.querySelector('.login');
const formsContainer = document.querySelector('.forms-container');
const showSignup = document.querySelector('.show-signup');
const showSignin = document.querySelector('.show-signin');

function openLogin() {
    if (!loginModal) return;
    loginModal.style.display = 'flex';
    document.body.classList.add('modal-open');
    setTimeout(() => loginModal.classList.add('active'), 10);
}

function closeLogin() {
    if (!loginModal) return;
    loginModal.classList.add('closing');
    setTimeout(() => {
        loginModal.style.display = 'none';
        loginModal.classList.remove('active', 'closing');
        document.body.classList.remove('modal-open');
        if (formsContainer) formsContainer.classList.remove('active');
    }, 400);
}

if (showSignup) {
    showSignup.addEventListener('click', () => {
        if (formsContainer) formsContainer.classList.add('active');
    });
}

if (showSignin) {
    showSignin.addEventListener('click', () => {
        if (formsContainer) formsContainer.classList.remove('active');
    });
}

window.addEventListener('keydown', (e) => {
    if (e.key === 'Escape' && loginModal && loginModal.classList.contains('active')) {
        closeLogin();
    }
});

// Password show/hide
document.querySelectorAll(".password-toggle").forEach(toggle => {
    toggle.addEventListener("click", () => {
        const input = toggle.parentElement.querySelector(".password");
        const icon = toggle.querySelector("i");
        if (!input) return;
        input.type = input.type === "password" ? "text" : "password";
        icon.classList.toggle("fa-eye-slash");
    });
});

// Parallax effect on hero (only on pages that have it)
const heroBg = document.querySelector('.hero-bg');
if (heroBg) {
    window.addEventListener('mousemove', function(e) {
        const x = (e.clientX / window.innerWidth - 0.5) * 20;
        const y = (e.clientY / window.innerHeight - 0.5) * 20;
        heroBg.style.transform = `translate(${x}px, ${y}px) scale(1.1)`;
    });
}

// FAQ accordion
document.querySelectorAll('.faq-question').forEach(function(question) {
    question.addEventListener('click', function() {
        const faqBox = this.parentElement;
        const isOpen = faqBox.classList.contains('active');
        document.querySelectorAll('.faq-item').forEach(faq => faq.classList.remove('active'));
        if (!isOpen) faqBox.classList.add('active');
    });
});

// Alert toasts
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.alert').forEach(alert => {
        setTimeout(() => {
            alert.classList.add('fade-out');
            setTimeout(() => alert.remove(), 300);
        }, 3000);
    });
});

// Scroll animations
const observer = new IntersectionObserver((entries) => {
    entries.forEach(e => {
        if (e.isIntersecting) e.target.classList.add('visible');
    });
}, { threshold: 0.15 });

document.querySelectorAll('.pro, .product1 h4, .page-header h4').forEach(el => {
    observer.observe(el);
});

// Delete address modal
function confirmDelete(url) {
    const btn = document.getElementById('deleteConfirmBtn');
    const modal = document.getElementById('deleteModal');
    if (!btn || !modal) return;
    btn.href = url;
    modal.style.display = 'flex';
}

function closeDeleteModal() {
    const modal = document.getElementById('deleteModal');
    if (modal) modal.style.display = 'none';
}

document.addEventListener('DOMContentLoaded', function() {
    const deleteModal = document.getElementById('deleteModal');
    if (deleteModal) {
        deleteModal.addEventListener('click', function(e) {
            if (e.target === this) closeDeleteModal();
        });
    }
});

document.addEventListener('keydown', e => {
    if (e.key === 'Escape') closeDeleteModal();
});