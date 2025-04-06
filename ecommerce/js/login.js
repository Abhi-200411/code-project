function validateLogin() {
    const username = document.getElementById("username").value;
    const password = document.getElementById("password").value;
    const errorElement = document.getElementById("error");

    // Clear previous error message
    errorElement.textContent = "";

    // Validate form fields
    if (username === "" || password === "") {
        errorElement.textContent = "Both username and password are required.";
        return false;
    }

    
    document.getElementById("loginForm").submit();
}
