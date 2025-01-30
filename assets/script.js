function validateForm() {
    let password = document.querySelector("[name='password']").value;
    let confirmPassword = document.querySelector("[name='confirm_password']").value;
    if (password !== confirmPassword) {
        alert("Les mots de passe ne correspondent pas !");
        return false;
    }
    return true;
}
