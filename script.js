function openPopup(id) {
    document.getElementById(id).style.display = "flex";
}

function closePopup(id) {
    document.getElementById(id).style.display = "none";
}

function togglePassword(inputId) {
    let passwordField = document.getElementById(inputId);
    passwordField.type = passwordField.type === "password" ? "text" : "password";
}

function validateSignup() {
    let password = document.getElementById("signup-password").value;
    let confirmPassword = document.getElementById("confirm-password").value;
    let errorText = document.getElementById("password-error");

    if (password !== confirmPassword) {
        errorText.style.display = "block";
        return false; 
    } else {
        errorText.style.display = "none";
        return true; 
    }
}
