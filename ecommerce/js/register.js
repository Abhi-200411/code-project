document.addEventListener("DOMContentLoaded", () => {
    const form = document.querySelector("form");
    const username = document.getElementById("username");
    const email = document.getElementById("email");
    const password = document.getElementById("password");
    
    form.addEventListener("submit", (event) => {
        // Clear any previous error messages
        clearErrors();

        let valid = true;
        
        // Validate Username
        if (username.value.trim() === "") {
            showError(username, "Username is required.");
            valid = false;
        }

        // Validate Email
        if (email.value.trim() === "") {
            showError(email, "Email is required.");
            valid = false;
        } else if (!isValidEmail(email.value)) {
            showError(email, "Invalid email format.");
            valid = false;
        }

        // Validate Password
        if (password.value.trim() === "") {
            showError(password, "Password is required.");
            valid = false;
        } else if (password.value.length < 6) {
            showError(password, "Password must be at least 6 characters.");
            valid = false;
        }

        // Prevent form submission if any validation failed
        if (!valid) {
            event.preventDefault();
        }
    });

    // Function to check valid email format
    function isValidEmail(email) {
        const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return regex.test(email);
    }

    // Function to display error message
    function showError(input, message) {
        const error = document.createElement("p");
        error.className = "error-message";
        error.style.color = "red";
        error.textContent = message;
        input.insertAdjacentElement("afterend", error);
    }

    // Function to clear previous error messages
    function clearErrors() {
        const errors = document.querySelectorAll(".error-message");
        errors.forEach(error => error.remove());
    }
});
