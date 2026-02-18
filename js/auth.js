// const loginModal = document.querySelector('.login');
// const closeBtn = document.querySelector('.close-btn');

// function openLogin() {
//     document.querySelector('.login').style.display="flex";
//     document.body.classList.add('modal-open');
//     loginModal.classList.add('active');
// }

// // for closing animation
// function closeLogin() {
//   loginModal.classList.add('closing'); 

//   setTimeout(() => {
//     document.querySelector(".login").style.display = "none";
//     loginModal.classList.remove('active');
//     loginModal.classList.remove('closing');
//     document.body.classList.remove('modal-open');
    
//   }, 250);
// }


// this is to click out side of modal to exit and also to improve ui experience
// window.addEventListener('click', (e) => {
//   if (e.target.classList.contains('login')) {
//     closeLogin();
//   }
// });

// esc to close login modal
window.addEventListener('keydown', (e) => {
  if (e.key === 'Escape') {
    closeLogin();
  }
});


/// LOGIN FORM HANDLER FOR PHP
const signinForm = document.getElementById('signinForm');
    if (signinForm) {
        signinForm.addEventListener('submit', function(e) {

            // Show loading
            const submitBtn = this.querySelector('.submit-btn');
            const originalText = submitBtn.textContent;
            submitBtn.textContent = 'Signing In...';
            submitBtn.disabled = true;
        
        });
    }
/// REGISTRTION FORM HJANDLE
const signupForm = document.getElementById('signupForm');
if (signupForm) {
    signupForm.addEventListener('submit', function(e) {
        
        const submitBtn = this.querySelector('.submit-btn');
        submitBtn.textContent = 'Creating Account...';
        submitBtn.disabled = true;
        
    });
}

