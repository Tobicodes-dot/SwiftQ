document.getElementById("loginForm").addEventListener("submit", async function (e) {
    e.preventDefault();

    const formData = new FormData(this);
    const submitBtn = this.querySelector('button[type="submit"]');
    const originalBtnText = submitBtn.innerText;

    // Basic client-side validation
    const email = formData.get('email');
    const password = formData.get('password');

    if (!email || !password) {
        alert("Please enter both email and password.");
        return;
    }

    try {
        submitBtn.innerText = "Logging in...";
        submitBtn.disabled = true;

        // Note: Ensure the backend endpoint ../../Backend/auth/individual/login.php exists or update this path
        const response = await fetch('../../Backend/auth/individual/login.php', {
            method: 'POST',
            body: formData
        });

        const data = await response.json();

        if (data.success) {
            // Redirect to individual dashboard
            window.location.href = data.redirect || '../../Public/dashboard/individual/index.html';
        } else {
            alert(data.message || 'Login failed. Please check your credentials.');
        }
    } catch (error) {
        console.error('Error:', error);
        alert('An error occurred during login. Please try again later.');
    } finally {
        submitBtn.innerText = originalBtnText;
        submitBtn.disabled = false;
    }
});
