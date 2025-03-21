<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'user') {
    header("Location: /views/login.php");
    exit;
}
?>

<?php include 'header.php'; ?>
<main>
    <section class="signup-section">
        <div class="signup-box" data-aos="fade-up">
            <h2>Report an Issue</h2>
            <form action="/controllers/IssueController.php?action=report" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="description">Issue Description</label>
                    <textarea id="description" name="description" required></textarea>
                </div>
                <div class="form-group">
                    <label for="category">Category</label>
                    <select id="category" name="category" required>
                        <option value="Hardware">Hardware</option>
                        <option value="Software">Software</option>
                        <option value="Network">Network</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="file">Attach File (Optional)</label>
                    <input type="file" id="file" name="file">
                </div>
                <button type="submit" class="cta-btn">Submit</button>
            </form>
        </div>
    </section>
</main>
<?php include 'footer.php'; ?>