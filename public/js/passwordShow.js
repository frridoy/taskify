function togglePasswordVisibility() {
    var passwordInput = document.getElementById('pass');
    var passIcon = document.getElementById('pass-icon');

    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        passIcon.classList.remove('bi-eye-slash-fill');
        passIcon.classList.add('bi-eye-fill');
    } else {
        passwordInput.type = 'password';
        passIcon.classList.remove('bi-eye-fill');
        passIcon.classList.add('bi-eye-slash-fill');
    }
}

function toggleConfirmPasswordVisibility()
{
    var passwordInput = document.getElementById('password_confirmation');
    var passIcon = document.getElementById('conf-pass-icon');

    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        passIcon.classList.remove('bi-eye-slash-fill');
        passIcon.classList.add('bi-eye-fill');
    } else {
        passwordInput.type = 'password';
        passIcon.classList.remove('bi-eye-fill');
        passIcon.classList.add('bi-eye-slash-fill');
    }
}
