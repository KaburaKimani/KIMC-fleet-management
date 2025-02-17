emailjs.init('YOUR_EMAILJS_USER_ID'); // Replace with your EmailJS user ID
document.getElementById('support-form')?.addEventListener('submit', function (e) {
    e.preventDefault();

    const serviceID = 'service_jo56p5o'; // Replace with your service ID
    const templateID = 'YOUR_EMAILJS_TEMPLATE_ID'; // Replace with your template ID

    emailjs.sendForm(serviceID, templateID, this)
        .then(() => {
            alert('Your message has been sent successfully!');
            this.reset();
        })
        .catch((error) => {
            console.error('Failed to send message:', error);
            alert('Failed to send message. Please try again.');
        });
});
// Sign Up Form Submission
document.getElementById('signup-form')?.addEventListener('submit', function (e) {
    e.preventDefault();

    // Get form data
    const name = document.getElementById('name').value;
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;
    const role = document.getElementById('role').value;

    // Validate role selection
    if (!role) {
        alert('Please select a role.');
        return;
    }

    // Save user data to localStorage (for demo purposes)
    const user = {
        name,
        email,
        password,
        role,
    };
    localStorage.setItem('currentUser', JSON.stringify(user));

    alert('Sign up successful!');
    window.location.href = 'dprofile.html'; // Redirect to profile page
});
// Display User Profile Information
window.onload = function () {
    const user = JSON.parse(localStorage.getItem('currentUser'));

    if (user) {
        document.getElementById('profile-name').textContent = user.name;
        document.getElementById('profile-email').textContent = user.email;
        document.getElementById('profile-role').textContent = user.role;
    } else {
        alert('User not found. Please sign up.');
        window.location.href = 'dsignup.html';
    }
};