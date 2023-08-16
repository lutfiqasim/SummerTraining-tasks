
function validateForm() {
    const uname = document.getElementById('name');
    const password = document.getElementById('password');
    const form = document.getElementById('form');
    const errorElement = document.getElementById("error");

    form.addEventListener('submit', (e) => {
        let messages = [];
        if (uname.value === '' || uname.value == null) {
            messages.push('Name is required');
        }

        if (password.value === '' || password.value == null) {
            messages.push('Password is required');
        } else if (password.value.length < 6) {
            messages.push('Password must be at least 6 characters');
        }
        if (password.value.length >= 20) {
            messages.push('Password must be less than 20 characters');
        }
        if (password.value.toUpperCase() === 'PASSWORD') {
            messages.push("Password can't be 'password'");
        }
        if (messages.length > 0) {
            e.preventDefault();
            // errorElement.innerText = messages.join(', ');
            $("#error").text(messages.join(', ')).dialog();
        } else {
            errorElement.innerText = "";
        }
    });
}
// Call the function on page load
window.onload = validateForm;
