window.addEventListener('DOMContentLoaded', (event) => {
    const toast = document.getElementById('toast');
    
    if (!toast) {
        return;
    }
    
    const message = toast.innerHTML.trim();
    
    if (message !== "") {
        console.log('Showing toast with message:', message);
        toast.classList.add('show');

        setTimeout(() => {
            toast.classList.remove('show');
        }, 3000);
    }

    const savedTheme = localStorage.getItem('theme') || 'light';
    const themeText = document.getElementById('theme-text');
    if (themeText) {
        themeText.textContent = savedTheme === 'dark' ? 'Light Mode' : 'Dark Mode';
    }

});

// Theme Toggle
function toggleTheme() {
    const html = document.documentElement;
    const currentTheme = html.getAttribute('data-theme');
    const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
    
    html.setAttribute('data-theme', newTheme);
    localStorage.setItem('theme', newTheme);
    
    document.getElementById('theme-text').textContent = 
        newTheme === 'dark' ? 'Light Mode' : 'Dark Mode';
}
