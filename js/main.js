// const loader = document.querySelector('.loader');

// window.addEventListener('load', () =>{
//     loader.classList.add('hidden');
// })



 window.addEventListener('load', () => {
            setTimeout(() => {
                document.querySelector('.loader').classList.add('hidden');
            }, 1000);
        });

// login
const loginModal = document.querySelector('.login');
        const formsContainer = document.querySelector('.forms-container');
        const showSignup = document.querySelector('.show-signup');
        const showSignin = document.querySelector('.show-signin');

        function openLogin() {
            loginModal.style.display = 'flex';
            document.body.classList.add('modal-open');
            setTimeout(() => {
                loginModal.classList.add('active');
            }, 10);
        }

        function closeLogin() {
            loginModal.classList.add('closing');
            setTimeout(() => {
                loginModal.style.display = 'none';
                loginModal.classList.remove('active', 'closing');
                document.body.classList.remove('modal-open');
                formsContainer.classList.remove('active');
            }, 400);
        }

        showSignup.addEventListener('click', () => {
            formsContainer.classList.add('active');
        });

        showSignin.addEventListener('click', () => {
            formsContainer.classList.remove('active');
        });

        window.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && loginModal.classList.contains('active')) {
                closeLogin();
            }
        });

// pass hide and show

document.querySelectorAll(".password-toggle").forEach(toggle => {
    toggle.addEventListener("click", () => {
        const input = toggle.parentElement.querySelector(".password");
        const icon = toggle.querySelector("i");

        const type = input.type === "password" ? "text" : "password";
        input.type = type;

        icon.classList.toggle("fa-eye-slash");
    });
});

// Parallax effect on hero
const heroBg = document.querySelector('.hero-bg');

window.addEventListener('mousemove', function(e) {
    const x = (e.clientX / window.innerWidth - 0.5) * 20;
    const y = (e.clientY / window.innerHeight - 0.5) * 20;
    heroBg.style.transform = `translate(${x}px, ${y}px) scale(1.1)`;
});

// FAQ open row thing

let allQuestions = document.querySelectorAll('.faq-question');

allQuestions.forEach(function(question) {  
    question.addEventListener('click', function() { 

        let faqBox = this.parentElement;
        let isOpen = faqBox.classList.contains('active');
        let allFAQs = document.querySelectorAll('.faq-item'); 

        allFAQs.forEach(function(faq) {
            faq.classList.remove('active');
        });

        if (!isOpen) {
            faqBox.classList.add('active');
        }
    });
});

// toast for succes msgs and errors

document.addEventListener('DOMContentLoaded', function() {
    const alerts = document.querySelectorAll('.alert');
    
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.classList.add('fade-out');
            setTimeout(() => {
                alert.remove();
            }, 300); 
        }, 3000); 
    });
});