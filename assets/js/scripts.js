// Simple Validation for Register/Login forms
document.addEventListener("DOMContentLoaded", function () {
    const loginForm = document.querySelector('form[action="../scripts/login.php"]');
    const registerForm = document.querySelector('form[action="../scripts/register.php"]');

    if (loginForm) {
        loginForm.addEventListener('submit', function (e) {
            const username = document.getElementById('username').value.trim();
            const password = document.getElementById('password').value.trim();

            if (!username || !password) {
                e.preventDefault();
                alert("Both fields are required.");
            }
        });
    }

    if (registerForm) {
        registerForm.addEventListener('submit', function (e) {
            const username = document.getElementById('username').value.trim();
            const password = document.getElementById('password').value.trim();
            const role = document.getElementById('role').value;

            if (!username || !password || !role) {
                e.preventDefault();
                alert("All fields are required.");
            }
        });
    }
});

// Borrow Book Confirmation Alert
const borrowBtns = document.querySelectorAll('a[href*="borrow.php"]');
borrowBtns.forEach(btn => {
    btn.addEventListener('click', function (e) {
        const confirmAction = confirm("Are you sure you want to borrow this book?");
        if (!confirmAction) {
            e.preventDefault();
        }
    });
});

// Auto Logout Timer
let logoutTimer;
const autoLogout = () => {
    const timeout = 60 * 30 * 1000; // 30 minutes
    logoutTimer = setTimeout(() => {
        alert("You have been logged out due to inactivity.");
        window.location.href = "../scripts/login.php?logout=true";
    }, timeout);
};

window.addEventListener('mousemove', () => {
    clearTimeout(logoutTimer);
    autoLogout();
});

autoLogout();
