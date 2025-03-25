<?php include 'header.php'; ?>
<main>
    <section class="signup-section">
        <div class="signup-box" data-aos="fade-up">
            <h2>Register as Agent</h2>
            <form action="/controllers/AgentController.php?action=register" method="POST">
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
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <div class="form-group">
                    <label for="specialization">Specialization</label>
                    <select id="specialization" name="specialization" required>
                        <option value="Hardware">Hardware</option>
                        <option value="Software">Software</option>
                        <option value="Network">Network</option>
                    </select>
                </div>
                <button type="submit" class="cta-btn">Register</button>
            </form>
        </div>
    </section>
</main>
<?php include 'footer.php'; ?>