<!-- Stylish & Creative Loader -->
<style>
/* Loader wrapper with full viewport and light background */
.loader-wrapper {
    position: fixed;
    top: 0;
    left: 0;
    width: 100vw;
    height: 100vh;
    background: #ffffff;
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 9999;
    overflow: hidden;
}

/* Outer rotating ring */
.loader-ring {
    position: absolute;
    width: 170px;
    height: 170px;
    border-radius: 50%;
    border: 6px solid #ddd;
    border-top-color: #6366f1; /* Indigo-500 */
    animation: spin 2.5s linear infinite;
}

/* Pulsing ring behind the outer ring */
.loader-pulse {
    position: absolute;
    width: 210px;
    height: 210px;
    border-radius: 50%;
    border: 8px solid #c7d2fe; /* Indigo-200 */
    animation: pulse 3s ease-in-out infinite;
}

/* Logo container with floating animation */
.loader-logo-container {
    position: relative;
    width: 120px;
    height: 120px;
    border-radius: 50%;
    background: #f9fafb;
    display: flex;
    justify-content: center;
    align-items: center;
    box-shadow: 0 0 15px rgba(99, 102, 241, 0.6);
    animation: float 4s ease-in-out infinite;
    overflow: hidden;
}

/* Logo image larger and rotating slowly */
.loader-logo-container img {
    width: 110px;
    height: 110px;
    object-fit: contain;
    animation: slow-rotate 10s linear infinite;
}

/* Floating animation for logo container */
@keyframes float {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-15px); }
}

/* Slow rotation for logo image */
@keyframes slow-rotate {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

/* Spin animation for outer ring */
@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

/* Pulse animation for pulse ring */
@keyframes pulse {
    0%, 100% {
        transform: scale(1);
        opacity: 0.5;
    }
    50% {
        transform: scale(1.1);
        opacity: 0.8;
    }
}

/* Optional subtle shimmer over loader wrapper */
.loader-shimmer {
    position: absolute;
    top: 0;
    left: -50%;
    width: 200%;
    height: 100%;
    background: linear-gradient(120deg, transparent 30%, rgba(255, 255, 255, 0.3) 50%, transparent 70%);
    transform: skewX(-25deg);
    animation: shimmer 3s infinite;
    pointer-events: none;
}

@keyframes shimmer {
    0% { left: -50%; }
    100% { left: 150%; }
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .loader-ring {
        width: 130px;
        height: 130px;
        border-width: 4px;
    }
    .loader-pulse {
        width: 160px;
        height: 160px;
        border-width: 6px;
    }
    .loader-logo-container {
        width: 90px;
        height: 90px;
    }
    .loader-logo-container img {
        width: 80px;
        height: 80px;
    }
}
</style>

<!-- Loader HTML -->
<div class="loader-wrapper" id="loaderWrapper">
    <div class="loader-pulse"></div>
    <div class="loader-ring"></div>
    <div class="loader-logo-container">
        <img src="/assets/logo.svg" alt="Loading Logo">
    </div>
    <div class="loader-shimmer"></div>
</div>

<!-- Loader Script -->
<script>
window.addEventListener('load', () => {
    const loader = document.getElementById('loaderWrapper');
    if(loader) {
        loader.style.opacity = '0';
        setTimeout(() => {
            loader.style.display = 'none';
        }, 600);
    }
});

// Fallback in case load event does not fire
setTimeout(() => {
    const loader = document.getElementById('loaderWrapper');
    if(loader && loader.style.display !== 'none') {
        loader.style.opacity = '0';
        setTimeout(() => {
            loader.style.display = 'none';
        }, 600);
    }
}, 5000);
</script>
