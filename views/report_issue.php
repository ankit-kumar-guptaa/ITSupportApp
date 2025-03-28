<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'user') {
    header("Location: /views/login.php");
    exit;
}
?>

<?php include 'header.php'; ?>

<main class="issue-reporting-container">
    <section class="signup-section">
        <div class="signup-box" data-aos="fade-up">
            <div class="form-header">
                <h2>Report an Issue</h2>
                <p>We'll get back to you within 24 hours</p>
                <div class="progress-steps">
                    <div class="step active">1</div>
                    <div class="step">2</div>
                    <div class="step">3</div>
                </div>
            </div>
            
            <form action="/controllers/IssueController.php?action=report" method="POST" enctype="multipart/form-data" class="issue-form">
                <div class="form-group floating-label">
                    <textarea id="description" name="description" required></textarea>
                    <label for="description">Issue Description</label>
                    <div class="character-count">0/500</div>
                </div>
                
                <div class="form-row">
                    <div class="form-group floating-label select-group">
                        <select id="category" name="category" required>
                            <option value=""></option>
                            <option value="Hardware">Hardware</option>
                            <option value="Software">Software</option>
                            <option value="Network">Network</option>
                        </select>
                        <label for="category">Category</label>
                        <i class="dropdown-icon"></i>
                    </div>
                    
                    <div class="form-group floating-label select-group">
                        <select id="gadget_type" name="gadget_type" required>
                            <option value=""></option>
                            <option value="Mobile">Mobile</option>
                            <option value="Laptop">Laptop</option>
                            <option value="MacBook">MacBook</option>
                            <option value="Other">Other</option>
                        </select>
                        <label for="gadget_type">Gadget Type</label>
                        <i class="dropdown-icon"></i>
                    </div>
                </div>
                
                <div class="form-group file-upload-area">
                    <input type="file" id="file" name="file" class="file-input" hidden>
                    <label for="file" class="file-upload-label">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M7 10V9C7 6.23858 9.23858 4 12 4C14.7614 4 17 6.23858 17 9V10C19.2091 10 21 11.7909 21 14V18C21 20.2091 19.2091 22 17 22H7C4.79086 22 3 20.2091 3 18V14C3 11.7909 4.79086 10 7 10Z" stroke="#4A5568" stroke-width="2"/>
                            <path d="M12 15V18M12 18L15 15M12 18L9 15" stroke="#4A5568" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                        <span class="file-upload-text">Drag & drop files or <span class="browse-link">Browse</span></span>
                        <span class="file-upload-hint">Supports: JPG, PNG, PDF (Max 5MB)</span>
                    </label>
                    <div class="file-preview" id="file-preview"></div>
                </div>
                
                <div class="form-footer">
                    <button type="submit" class="submit-btn">
                        <span>Submit Issue</span>
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M5 12H19M19 12L12 5M19 12L12 19" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </button>
                </div>
            </form>
        </div>
    </section>
</main>

<style>
:root {
    --primary: #4361ee;
    --primary-light: #e0e7ff;
    --secondary: #3f37c9;
    --dark: #1e293b;
    --light: #f8fafc;
    --gray: #94a3b8;
    --danger: #ef4444;
    --success: #10b981;
}

.issue-reporting-container {
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    background-color: #f1f5f9;
    padding: 2rem;
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
}

.signup-section {
    width: 100%;
    max-width: 600px;
}

.signup-box {
    background: white;
    border-radius: 16px;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
    padding: 2.5rem;
    transition: all 0.3s ease;
}

.form-header {
    text-align: center;
    margin-bottom: 2rem;
}

.form-header h2 {
    font-size: 1.75rem;
    font-weight: 700;
    color: var(--dark);
    margin-bottom: 0.5rem;
}

.form-header p {
    color: var(--gray);
    margin-bottom: 1.5rem;
}

.progress-steps {
    display: flex;
    justify-content: center;
    gap: 1rem;
    margin-bottom: 1.5rem;
}

.step {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    background: #e2e8f0;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    color: #64748b;
}

.step.active {
    background: var(--primary);
    color: white;
}

.issue-form {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.form-row {
    display: flex;
    gap: 1.5rem;
}

.form-row > * {
    flex: 1;
}

.form-group {
    position: relative;
}

.floating-label {
    position: relative;
    margin-bottom: 1.5rem;
}

.floating-label label {
    position: absolute;
    top: 1rem;
    left: 1rem;
    color: var(--gray);
    background: white;
    padding: 0 0.25rem;
    transition: all 0.2s ease;
    pointer-events: none;
    transform-origin: left center;
}

.floating-label textarea,
.floating-label select {
    width: 100%;
    padding: 1rem;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    font-size: 0.9375rem;
    transition: all 0.2s ease;
    background: white;
}

.floating-label textarea {
    min-height: 120px;
    resize: vertical;
}

.floating-label textarea:focus,
.floating-label select:focus {
    outline: none;
    border-color: var(--primary);
    box-shadow: 0 0 0 3px var(--primary-light);
}

.floating-label textarea:focus + label,
.floating-label textarea:not(:placeholder-shown) + label,
.floating-label select:focus + label,
.floating-label select:not([value=""]) + label {
    transform: translateY(-1.75rem) scale(0.875);
    color: var(--primary);
    font-weight: 500;
}

.character-count {
    position: absolute;
    bottom: 0.5rem;
    right: 0.5rem;
    font-size: 0.75rem;
    color: var(--gray);
}

.select-group {
    position: relative;
}

.select-group i.dropdown-icon {
    position: absolute;
    right: 1rem;
    top: 50%;
    transform: translateY(-50%);
    width: 0;
    height: 0;
    border-left: 5px solid transparent;
    border-right: 5px solid transparent;
    border-top: 5px solid var(--gray);
    pointer-events: none;
}

.file-upload-area {
    border: 2px dashed #e2e8f0;
    border-radius: 8px;
    padding: 2rem;
    text-align: center;
    transition: all 0.2s ease;
}

.file-upload-area:hover {
    border-color: var(--primary);
}

.file-upload-label {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.5rem;
    cursor: pointer;
}

.file-upload-label svg {
    width: 48px;
    height: 48px;
    stroke: var(--gray);
}

.file-upload-text {
    color: var(--dark);
    font-weight: 500;
}

.browse-link {
    color: var(--primary);
    text-decoration: underline;
}

.file-upload-hint {
    color: var(--gray);
    font-size: 0.875rem;
}

.file-preview {
    margin-top: 1rem;
    display: none;
}

.file-preview.active {
    display: block;
}

.submit-btn {
    background: var(--primary);
    color: white;
    border: none;
    border-radius: 8px;
    padding: 1rem 1.5rem;
    font-size: 1rem;
    font-weight: 600;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    cursor: pointer;
    transition: all 0.2s ease;
    width: 100%;
}

.submit-btn:hover {
    background: var(--secondary);
    transform: translateY(-2px);
}

.submit-btn svg {
    transition: transform 0.2s ease;
}

.submit-btn:hover svg {
    transform: translateX(4px);
}

/* Responsive adjustments */
@media (max-width: 640px) {
    .form-row {
        flex-direction: column;
        gap: 1.5rem;
    }
    
    .signup-box {
        padding: 1.5rem;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Character counter for description
    const description = document.getElementById('description');
    const charCount = document.querySelector('.character-count');
    
    description.addEventListener('input', function() {
        const count = this.value.length;
        charCount.textContent = `${count}/500`;
        
        if (count > 500) {
            charCount.style.color = 'var(--danger)';
        } else {
            charCount.style.color = 'var(--gray)';
        }
    });
    
    // File upload preview
    const fileInput = document.getElementById('file');
    const filePreview = document.getElementById('file-preview');
    
    fileInput.addEventListener('change', function() {
        if (this.files && this.files[0]) {
            const file = this.files[0];
            const fileType = file.type.split('/')[0];
            
            filePreview.innerHTML = '';
            filePreview.classList.add('active');
            
            if (fileType === 'image') {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.style.maxWidth = '100px';
                    img.style.maxHeight = '100px';
                    img.style.borderRadius = '4px';
                    filePreview.appendChild(img);
                }
                reader.readAsDataURL(file);
            } else {
                const fileInfo = document.createElement('div');
                fileInfo.innerHTML = `
                    <div style="display: flex; align-items: center; gap: 0.5rem;">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M14 2H6C5.46957 2 4.96086 2.21071 4.58579 2.58579C4.21071 2.96086 4 3.46957 4 4V20C4 20.5304 4.21071 21.0391 4.58579 21.4142C4.96086 21.7893 5.46957 22 6 22H18C18.5304 22 19.0391 21.7893 19.4142 21.4142C19.7893 21.0391 20 20.5304 20 20V8L14 2Z" stroke="#4A5568" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M14 2V8H20" stroke="#4A5568" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <span>${file.name}</span>
                    </div>
                `;
                filePreview.appendChild(fileInfo);
            }
        }
    });
    
    // Drag and drop functionality
    const fileUploadLabel = document.querySelector('.file-upload-label');
    
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        fileUploadLabel.addEventListener(eventName, preventDefaults, false);
    });
    
    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }
    
    ['dragenter', 'dragover'].forEach(eventName => {
        fileUploadLabel.addEventListener(eventName, highlight, false);
    });
    
    ['dragleave', 'drop'].forEach(eventName => {
        fileUploadLabel.addEventListener(eventName, unhighlight, false);
    });
    
    function highlight() {
        fileUploadLabel.parentElement.style.borderColor = 'var(--primary)';
        fileUploadLabel.parentElement.style.backgroundColor = 'var(--primary-light)';
    }
    
    function unhighlight() {
        fileUploadLabel.parentElement.style.borderColor = '#e2e8f0';
        fileUploadLabel.parentElement.style.backgroundColor = 'transparent';
    }
    
    fileUploadLabel.addEventListener('drop', handleDrop, false);
    
    function handleDrop(e) {
        const dt = e.dataTransfer;
        const files = dt.files;
        fileInput.files = files;
        const event = new Event('change');
        fileInput.dispatchEvent(event);
    }
});
</script>
<?php include 'footer.php'; ?>