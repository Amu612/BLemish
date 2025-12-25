// main.js

// Example: validate email
function validateEmail(email) {
    const pattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    
    return pattern.test(email);
}

// Example: validate strong password
function validatePassword(password) {
    const pattern = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[\W_]).{8,}$/;
        
    return pattern.test(password);
}

// Example: attach validation on signup form
document.addEventListener("DOMContentLoaded", function () {
    const form = document.querySelector("form");

    if (form) {
        form.addEventListener("submit", function (e) {
            const email = form.querySelector("input[name='email']").value;
            const password = form.querySelector("input[name='password']").value;

            if (!validateEmail(email)) {
                alert("Invalid email format.");
                e.preventDefault();
            } else if (!validatePassword(password)) {
                alert("Password must be strong: 8+ characters, upper, lower, number, special char.");
                e.preventDefault();
            }
        });
    }
});
