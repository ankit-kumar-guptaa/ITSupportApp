<?php include 'header.php'; ?>
<main>
    <section class="signup-section">
        <div class="signup-box" data-aos="fade-up">
            <h2>Admin Registration</h2>
            <form action="/controllers/AdminController.php?action=admin_register" method="POST">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" id="name" name="name" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <div class="form-group">
                    <label for="code">Unique Code</label>
                    <input type="text" id="code" name="code" required placeholder="e.g., ADMIN-2025-XYZ123">
                </div>
                <button type="submit" class="cta-btn">Register as Admin</button>
            </form>
        </div>
    </section>
</main>
<?php include 'footer.php'; ?>