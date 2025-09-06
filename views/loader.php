<!-- Creative Professional Loader CSS -->
<style>
/* Loader wrapper with white background */
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
    transition: opacity 0.6s ease-out;
}

/* Main loader container */
.loader-container {
    position: relative;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 30px;
}

/* Animated rings around logo */
.loader-rings {
    position: relative;
    width: 180px;
    height: 180px;
    display: flex;
    justify-content: center;
    align-items: center;
}

/* Outer rotating ring */
.ring-outer {
    position: absolute;
    width: 180px;
    height: 180px;
    border: 3px solid #f1f5f9;
    border-top-color: #3b82f6;
    border-right-color: #8b5cf6;
    border-radius: 50%;
    animation: rotate-clockwise 2s linear infinite;
}

/* Middle ring */
.ring-middle {
    position: absolute;
    width: 140px;
    height: 140px;
    border: 2px solid #f8fafc;
    border-left-color: #06b6d4;
    border-bottom-color: #10b981;
    border-radius: 50%;
    animation: rotate-counter 1.8s linear infinite;
}

/* Inner pulsing ring */
.ring-inner {
    position: absolute;
    width: 100px;
    height: 100px;
    border: 2px solid #e5e7eb;
    border-radius: 50%;
    animation: pulse-ring 2.5s ease-in-out infinite;
}

/* Large Logo container */
.loader-logo-container {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 80px;
    height: 80px;
    background: #ffffff;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 
        0 0 0 4px rgba(59, 130, 246, 0.1),
        0 8px 25px rgba(0, 0, 0, 0.1);
    animation: float-logo 3s ease-in-out infinite;
    overflow: hidden;
}

/* Large logo image */
.loader-logo-container img {
    width: 60px;
    height: 60px;
    object-fit: contain;
    animation: gentle-rotate 8s linear infinite;
}

/* Loading text with gradient */
.loader-text {
    background: linear-gradient(135deg, #3b82f6, #8b5cf6, #06b6d4);
    background-clip: text;
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    font-family: 'Arial', sans-serif;
    font-size: 22px;
    font-weight: 700;
    letter-spacing: 3px;
    text-transform: uppercase;
    animation: text-glow 2s ease-in-out infinite alternate;
    text-align: center;
}

/* Animated dots */
.loading-dots {
    display: flex;
    gap: 8px;
    margin-top: 10px;
}

.dot {
    width: 8px;
    height: 8px;
    background: linear-gradient(135deg, #3b82f6, #8b5cf6);
    border-radius: 50%;
    animation: dot-bounce 1.4s ease-in-out infinite both;
}

.dot:nth-child(1) { animation-delay: -0.32s; }
.dot:nth-child(2) { animation-delay: -0.16s; }
.dot:nth-child(3) { animation-delay: 0s; }

/* Creative progress indicator */
.progress-container {
    width: 240px;
    height: 4px;
    background: #f1f5f9;
    border-radius: 20px;
    overflow: hidden;
    position: relative;
}

.progress-wave {
    height: 100%;
    background: linear-gradient(90deg, 
        #3b82f6 0%, 
        #8b5cf6 25%, 
        #06b6d4 50%, 
        #10b981 75%, 
        #3b82f6 100%);
    border-radius: 20px;
    width: 60px;
    animation: wave-progress 2.5s ease-in-out infinite;
}

/* Animations */
@keyframes rotate-clockwise {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

@keyframes rotate-counter {
    0% { transform: rotate(360deg); }
    100% { transform: rotate(0deg); }
}

@keyframes pulse-ring {
    0%, 100% {
        transform: scale(1);
        opacity: 0.8;
    }
    50% {
        transform: scale(1.1);
        opacity: 0.4;
    }
}

@keyframes float-logo {
    0%, 100% { 
        transform: translate(-50%, -50%) translateY(0px);
    }
    50% { 
        transform: translate(-50%, -50%) translateY(-8px);
    }
}

@keyframes gentle-rotate {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

@keyframes text-glow {
    0% { opacity: 0.8; }
    100% { opacity: 1; }
}

@keyframes dot-bounce {
    0%, 80%, 100% {
        transform: scale(0.8);
        opacity: 0.5;
    }
    40% {
        transform: scale(1.2);
        opacity: 1;
    }
}

@keyframes wave-progress {
    0% {
        transform: translateX(-60px);
    }
    100% {
        transform: translateX(240px);
    }
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .loader-rings {
        width: 140px;
        height: 140px;
    }
    
    .ring-outer {
        width: 140px;
        height: 140px;
    }
    
    .ring-middle {
        width: 110px;
        height: 110px;
    }
    
    .ring-inner {
        width: 80px;
        height: 80px;
    }
    
    .loader-logo-container {
        width: 60px;
        height: 60px;
    }
    
    .loader-logo-container img {
        width: 45px;
        height: 45px;
    }
    
    .loader-text {
        font-size: 18px;
        letter-spacing: 2px;
    }
    
    .progress-container {
        width: 180px;
    }
}

@media (max-width: 480px) {
    .loader-rings {
        width: 120px;
        height: 120px;
    }
    
    .ring-outer {
        width: 120px;
        height: 120px;
    }
    
    .ring-middle {
        width: 95px;
        height: 95px;
    }
    
    .ring-inner {
        width: 70px;
        height: 70px;
    }
    
    .loader-logo-container {
        width: 50px;
        height: 50px;
    }
    
    .loader-logo-container img {
        width: 38px;
        height: 38px;
    }
    
    .loader-text {
        font-size: 16px;
        letter-spacing: 1.5px;
    }
    
    .progress-container {
        width: 160px;
    }
}
</style>

<!-- Loader HTML -->
<div class="loader-wrapper" id="loaderWrapper">
    <div class="loader-container">
        <!-- Animated rings with large logo -->
        <div class="loader-rings">
            <div class="ring-outer"></div>
            <div class="ring-middle"></div>
            <div class="ring-inner"></div>
            <div class="loader-logo-container">
                <img src="/assets/logo.svg" alt="Loading Logo">
            </div>
        </div>
        
        <!-- Loading text with gradient effect -->
        <div class="loader-text">
            Loading
        </div>
        
        <!-- Animated dots -->
        <div class="loading-dots">
            <div class="dot"></div>
            <div class="dot"></div>
            <div class="dot"></div>
        </div>
        
        <!-- Creative progress bar -->
        <div class="progress-container">
            <div class="progress-wave"></div>
        </div>
    </div>
</div>

<!-- Enhanced Loader Script -->
<script>
// Prevent scroll during loading
document.body.style.overflow = 'hidden';

// Smooth loader hide function
function hideLoader() {
    const loader = document.getElementById('loaderWrapper');
    if (loader) {
        loader.style.opacity = '0';
        setTimeout(() => {
            loader.style.display = 'none';
            document.body.style.overflow = 'auto';
        }, 600);
    }
}

// Hide loader when page loads completely
window.addEventListener('load', () => {
    setTimeout(hideLoader, 800); // Minimum show time
});

// Fallback timer (maximum 5 seconds)
setTimeout(hideLoader, 5000);

// Optional: Quick hide for fast connections
document.addEventListener('DOMContentLoaded', () => {
    setTimeout(() => {
        if (document.readyState === 'complete') {
            hideLoader();
        }
    }, 2000);
});
</script>
