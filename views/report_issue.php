<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'user') {
    header("Location: /views/login.php");
    exit;
}
?>

<?php include 'header.php'; ?>

<style>
    /* CSS Bhai - Attractive Design */
.signup-section {
    min-height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
    padding: 20px;
}

.signup-box {
    background: white;
    padding: 40px;
    border-radius: 15px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    width: 100%;
    max-width: 500px;
    transition: transform 0.3s ease;
}

.signup-box:hover {
    transform: translateY(-5px);
}

.signup-box h2 {
    text-align: center;
    color: #333;
    margin-bottom: 30px;
    font-size: 2rem;
    font-weight: 700;
    position: relative;
}

.signup-box h2::after {
    content: '';
    width: 50px;
    height: 3px;
    background: #007bff;
    position: absolute;
    bottom: -10px;
    left: 50%;
    transform: translateX(-50%);
}

.issue-form {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.form-group {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.form-group label {
    font-size: 1rem;
    color: #555;
    font-weight: 500;
}

.form-group textarea,
.form-group select,
.form-group input[type="file"] {
    padding: 12px;
    border: 2px solid #ddd;
    border-radius: 8px;
    font-size: 1rem;
    transition: border-color 0.3s ease, box-shadow 0.3s ease;
}

.form-group textarea:focus,
.form-group select:focus,
.form-group input[type="file"]:focus {
    border-color: #007bff;
    box-shadow: 0 0 8px rgba(0, 123, 255, 0.3);
    outline: none;
}

.form-group textarea {
    min-height: 100px;
    resize: vertical;
}

.form-group select {
    appearance: none;
    background: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="black" viewBox="0 0 24 24"><path d="M7 10l5 5 5-5z"/></svg>') no-repeat right 12px center;
    background-size: 12px;
    padding-right: 30px;
}

.file-upload {
    position: relative;
}

.file-input {
    padding: 10px;
    background: #f9f9f9;
    cursor: pointer;
}

.cta-btn {
    background: #007bff;
    color: white;
    padding: 12px;
    border: none;
    border-radius: 8px;
    font-size: 1.1rem;
    font-weight: 600;
    cursor: pointer;
    transition: background 0.3s ease, transform 0.2s ease;
}

.cta-btn:hover {
    background: #0056b3;
    transform: scale(1.05);
}

.cta-btn:active {
    transform: scale(0.98);
}

/* Responsive Design */
@media (max-width: 480px) {
    .signup-box {
        padding: 20px;
    }

    .signup-box h2 {
        font-size: 1.5rem;
    }

    .cta-btn {
        font-size: 1rem;
    }
}
</style>

<main>
    <section class="signup-section">
        <div class="signup-box" data-aos="fade-up">
            <h2>Report an Issue</h2>
            <form action="/controllers/IssueController.php?action=report" method="POST" enctype="multipart/form-data" class="issue-form">
                <div class="form-group">
                    <label for="description">Issue Description</label>
                    <textarea id="description" name="description" placeholder="Describe your issue here..." required></textarea>
                </div>
                <div class="form-group">
                    <label for="category">Category</label>
                    <select id="category" name="category" required>
                        <option value="" disabled selected>Select Category</option>
                        <option value="Hardware">Hardware</option>
                        <option value="Software">Software</option>
                        <option value="Network">Network</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="gadget_type">Gadget Type</label>
                    <select id="gadget_type" name="gadget_type" required>
                        <option value="" disabled selected>Select Gadget</option>
                        <option value="Mobile">Mobile</option>
                        <option value="Laptop">Laptop</option>
                        <option value="MacBook">MacBook</option>
                        <option value="Other">Other</option>
                    </select>
                </div>
                <div class="form-group file-upload">
                    <label for="file">Attach File (Optional)</label>
                    <input type="file" id="file" name="file" class="file-input">
                </div>
                <button type="submit" class="cta-btn">Submit Issue</button>
            </form>
        </div>
    </section>
</main>
<?php include 'footer.php'; ?>