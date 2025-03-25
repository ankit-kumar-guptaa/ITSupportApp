<?php include 'header.php'; ?>
<main>
    <section class="signup-section">
        <div class="signup-box" data-aos="fade-up">
            <h2>Sign Up</h2>
            <form action="/controllers/AuthController.php?action=signup" method="POST" onsubmit="return validatePassword()">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" id="name" name="name" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="phone_number">Phone Number</label>
                    <input type="text" id="phone_number" name="phone_number" required pattern="[0-9]{10}" placeholder="Enter 10-digit phone number">
                </div>
                <div class="form-group">
                    <label for="address">Address</label>
                    <textarea id="address" name="address" required></textarea>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required onkeyup="checkPasswordStrength()">
                    <div id="password-strength" style="margin-top: 5px; font-size: 14px;"></div>
                </div>
                <button type="submit" class="cta-btn">Sign Up</button>
            </form>
        </div>
    </section>
</main>
<?php include 'footer.php'; ?>

<script>
function checkPasswordStrength() {
    const password = document.getElementById('password').value;
    const strengthDiv = document.getElementById('password-strength');
    let strength = 0;

    if (password.length >= 8) strength++;
    if (/[A-Z]/.test(password)) strength++;
    if (/[0-9]/.test(password)) strength++;
    if (/[^A-Za-z0-9]/.test(password)) strength++;

    switch (strength) {
        case 0:
        case 1:
            strengthDiv.textContent = 'Weak Password';
            strengthDiv.style.color = 'red';
            break;
        case 2:
            strengthDiv.textContent = 'Moderate Password';
            strengthDiv.style.color = 'orange';
            break;
        case 3:
            strengthDiv.textContent = 'Strong Password';
            strengthDiv.style.color = 'blue';
            break;
        case 4:
            strengthDiv.textContent = 'Very Strong Password';
            strengthDiv.style.color = 'green';
            break;
    }
}

function validatePassword() {
    const password = document.getElementById('password').value;
    let strength = 0;

    if (password.length >= 8) strength++;
    if (/[A-Z]/.test(password)) strength++;
    if (/[0-9]/.test(password)) strength++;
    if (/[^A-Za-z0-9]/.test(password)) strength++;

    if (strength < 2) {
        alert('Password is too weak! It should be at least 8 characters long, with uppercase, numbers, and special characters.');
        return false;
    }
    return true;
}
</script>