let body = document.body;

let profile = document.querySelector('.header .flex .profile');
let searchForm = document.querySelector('.header .flex .search-form');
let sideBar = document.querySelector('.side-bar');
let toggleBtn = document.querySelector('#toggle-btn');

// Toggle profile visibility
document.querySelector('#user-btn').onclick = () => {
    profile.classList.toggle('active');
    searchForm.classList.remove('active');
};

// Toggle search form visibility
document.querySelector('#search-btn').onclick = () => {
    searchForm.classList.toggle('active');
    profile.classList.remove('active');
};

// Toggle sidebar visibility
document.querySelector('#menu-btn').onclick = () => {
    sideBar.classList.toggle('active');
    body.classList.toggle('active');
};

// Close sidebar
document.querySelector('.side-bar .close-side-bar').onclick = () => {
    sideBar.classList.remove('active');
    body.classList.remove('active');
};

// Handle scroll events
window.onscroll = () => {
    profile.classList.remove('active');
    searchForm.classList.remove('active');

    if (window.innerWidth < 1200) {
        sideBar.classList.remove('active');
        body.classList.remove('active');
    }
};

// Dark mode functionality
let darkMode = localStorage.getItem('dark-mode');

const enableDarkMode = () => {
    toggleBtn.classList.replace('fa-sun', 'fa-moon');
    body.classList.add('dark');
    localStorage.setItem('dark-mode', 'enabled');
};

const disableDarkMode = () => {
    toggleBtn.classList.replace('fa-moon', 'fa-sun');
    body.classList.remove('dark');
    localStorage.setItem('dark-mode', 'disabled');
};

// Set initial dark mode state
if (!darkMode) {
    localStorage.setItem('dark-mode', 'disabled');
}
if (darkMode === 'enabled') {
    enableDarkMode();
}

// Toggle dark mode on button click
if (toggleBtn) {
    toggleBtn.onclick = () => {
        let darkMode = localStorage.getItem('dark-mode');
        if (darkMode === 'disabled') {
            enableDarkMode();
        } else {
            disableDarkMode();
        }
    };
}
