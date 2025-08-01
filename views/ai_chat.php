<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IT Sahayata - AI-Powered IT Support | 24/7 Tech Assistance</title>
    <meta name="description" content="Get instant IT solutions with our AI assistant. Hardware, software, network support & more. Contact: 7703823008">
    <?php include "assets.php" ?>
    
    <style>
        :root {
            --primary: #4f46e5;
            --primary-dark: #3730a3;
            --primary-light: #6366f1;
            --secondary: #06b6d4;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --dark: #1f2937;
            --light: #f8fafc;
            --gray: #6b7280;
            --gray-light: #e5e7eb;
            --white: #ffffff;
            --chat-bg: #f8fafc;
            --user-bubble: #4f46e5;
            --ai-bubble: #ffffff;
            --border: #e2e8f0;
            --shadow: rgba(0, 0, 0, 0.08);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: linear-gradient(135deg, #f0f9ff 0%, #e0e7ff 100%);
            color: var(--dark);
            line-height: 1.6;
            overflow-x: hidden;
        }

        /* Floating Background Particles */
        .bg-particles {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            pointer-events: none;
        }

        .particle {
            position: absolute;
            background: linear-gradient(45deg, rgba(79, 70, 229, 0.1), rgba(6, 182, 212, 0.1));
            border-radius: 50%;
            animation: floatUp 15s infinite linear;
        }

        @keyframes floatUp {
            0% {
                transform: translateY(100vh) rotate(0deg);
                opacity: 0;
            }
            10% {
                opacity: 1;
            }
            90% {
                opacity: 1;
            }
            100% {
                transform: translateY(-100px) rotate(360deg);
                opacity: 0;
            }
        }

        /* Enhanced Hero Section */
        .ai-hero-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
            padding: 100px 0 80px;
            position: relative;
            overflow: hidden;
            color: white;
        }

        .ai-hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: 
                radial-gradient(circle at 25% 25%, rgba(255, 255, 255, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 75% 75%, rgba(255, 255, 255, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 50% 50%, rgba(6, 182, 212, 0.1) 0%, transparent 50%);
            z-index: 1;
        }

        .hero-content {
            position: relative;
            z-index: 2;
            text-align: center;
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            padding: 12px 25px;
            border-radius: 50px;
            font-weight: 600;
            margin-bottom: 30px;
            border: 1px solid rgba(255, 255, 255, 0.3);
            animation: heroFloat 3s ease-in-out infinite;
        }

        @keyframes heroFloat {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }

        .hero-title {
            font-size: clamp(2.5rem, 5vw, 4.5rem);
            font-weight: 900;
            margin-bottom: 20px;
            line-height: 1.1;
            text-shadow: 3px 3px 6px rgba(0, 0, 0, 0.3);
            background: linear-gradient(45deg, #ffffff, #f0f9ff, #fafafa);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .hero-subtitle {
            font-size: clamp(1.1rem, 2.5vw, 1.4rem);
            margin-bottom: 40px;
            opacity: 0.95;
            max-width: 700px;
            margin-left: auto;
            margin-right: auto;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.2);
        }

        .hero-features {
            display: flex;
            justify-content: center;
            gap: 30px;
            flex-wrap: wrap;
            margin-bottom: 40px;
        }

        .hero-feature {
            display: flex;
            align-items: center;
            gap: 10px;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            padding: 12px 20px;
            border-radius: 25px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: all 0.3s ease;
        }

        .hero-feature:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: translateY(-5px);
        }

        .hero-feature i {
            color: #FFD700;
            font-size: 1.2rem;
        }

        .hero-cta {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: white;
            padding: 18px 35px;
            border-radius: 50px;
            font-weight: 700;
            font-size: 1.1rem;
            text-decoration: none;
            box-shadow: 0 12px 35px rgba(79, 70, 229, 0.4);
            transition: all 0.4s ease;
            position: relative;
            overflow: hidden;
        }

        .hero-cta:hover {
            transform: translateY(-5px);
            box-shadow: 0 18px 45px rgba(79, 70, 229, 0.5);
        }

        .hero-cta::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: 0.6s;
        }

        .hero-cta:hover::before {
            left: 100%;
        }

        /* Enhanced Hero Images */
        .hero-images {
            position: relative;
            margin-top: 50px;
        }

        .hero-main-image {
            max-width: 500px;
            width: 100%;
            border-radius: 20px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.2);
            animation: heroImageFloat 6s ease-in-out infinite;
        }

        @keyframes heroImageFloat {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            50% { transform: translateY(-15px) rotate(1deg); }
        }

        .floating-tech-icons {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
        }

        .tech-icon {
            position: absolute;
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            box-shadow: 0 8px 25px rgba(79, 70, 229, 0.3);
            animation: techIconFloat 8s ease-in-out infinite;
        }

        .tech-icon:nth-child(1) {
            top: 10%;
            left: 10%;
            animation-delay: 0s;
        }

        .tech-icon:nth-child(2) {
            top: 20%;
            right: 15%;
            animation-delay: 1s;
            background: linear-gradient(135deg, var(--success), var(--secondary));
        }

        .tech-icon:nth-child(3) {
            bottom: 30%;
            left: 5%;
            animation-delay: 2s;
            background: linear-gradient(135deg, var(--warning), var(--danger));
        }

        .tech-icon:nth-child(4) {
            bottom: 15%;
            right: 20%;
            animation-delay: 3s;
            background: linear-gradient(135deg, var(--danger), var(--primary));
        }

        @keyframes techIconFloat {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            25% { transform: translateY(-15px) rotate(10deg); }
            50% { transform: translateY(-5px) rotate(-5deg); }
            75% { transform: translateY(-20px) rotate(15deg); }
        }

        /* AI Chat Container */
        .ai-chat-container {
            max-width: 1200px;
            margin: -60px auto 0;
            position: relative;
            z-index: 10;
            padding: 0 20px;
        }

        .ai-chat-card {
            background: var(--white);
            border-radius: 30px;
            box-shadow: 0 30px 70px rgba(0, 0, 0, 0.15);
            overflow: hidden;
            transition: all 0.4s ease;
            border: 1px solid var(--border);
            animation: chatSlideUp 0.8s ease-out;
        }

        @keyframes chatSlideUp {
            from {
                opacity: 0;
                transform: translateY(50px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Enhanced Chat Header */
        .ai-chat-header {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: white;
            padding: 30px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: relative;
        }

        .ai-chat-header::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 3px;
            background: linear-gradient(90deg, rgba(255, 255, 255, 0.3), rgba(255, 255, 255, 0.1), rgba(255, 255, 255, 0.3));
        }

        .chat-header-content {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .ai-avatar {
            width: 60px;
            height: 60px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            border: 3px solid rgba(255, 255, 255, 0.3);
            animation: avatarGlow 3s ease-in-out infinite;
        }

        @keyframes avatarGlow {
            0%, 100% { 
                box-shadow: 0 0 20px rgba(255, 255, 255, 0.3);
                transform: scale(1);
            }
            50% { 
                box-shadow: 0 0 30px rgba(255, 255, 255, 0.5);
                transform: scale(1.05);
            }
        }

        .chat-info h2 {
            font-size: 1.5rem;
            font-weight: 800;
            margin-bottom: 5px;
        }

        .chat-status {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 1rem;
            font-weight: 500;
            opacity: 0.95;
        }

        .status-dot {
            width: 12px;
            height: 12px;
            background: var(--success);
            border-radius: 50%;
            animation: statusPulse 2s infinite;
        }

        @keyframes statusPulse {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.7; transform: scale(1.2); }
        }

        /* Enhanced Chat Messages */
        .ai-chat-messages {
            padding: 35px;
            height: 550px;
            overflow-y: auto;
            background: var(--chat-bg);
            display: flex;
            flex-direction: column;
            gap: 25px;
            scroll-behavior: smooth;
        }

        .ai-chat-messages::-webkit-scrollbar {
            width: 8px;
        }

        .ai-chat-messages::-webkit-scrollbar-track {
            background: transparent;
        }

        .ai-chat-messages::-webkit-scrollbar-thumb {
            background: var(--gray-light);
            border-radius: 10px;
        }

        .ai-chat-messages::-webkit-scrollbar-thumb:hover {
            background: var(--gray);
        }

        /* Enhanced Message Styles */
        .message {
            max-width: 85%;
            padding: 20px 25px;
            border-radius: 25px;
            position: relative;
            animation: messageAppear 0.5s ease-out;
            line-height: 1.7;
            font-size: 1rem;
            box-shadow: 0 5px 20px var(--shadow);
        }

        @keyframes messageAppear {
            from {
                opacity: 0;
                transform: translateY(30px) scale(0.9);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        .user-message {
            align-self: flex-end;
            background: linear-gradient(135deg, var(--user-bubble) 0%, var(--primary-dark) 100%);
            color: white;
            border-bottom-right-radius: 10px;
            margin-left: auto;
        }

        .ai-message {
            align-self: flex-start;
            background: var(--ai-bubble);
            color: var(--dark);
            border-bottom-left-radius: 10px;
            border: 2px solid var(--border);
            margin-right: auto;
            position: relative;
        }

        .ai-message::before {
            content: '';
            position: absolute;
            top: -2px;
            left: -2px;
            right: -2px;
            bottom: -2px;
            background: linear-gradient(135deg, rgba(79, 70, 229, 0.1), rgba(6, 182, 212, 0.1));
            border-radius: 25px;
            z-index: -1;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .ai-message:hover::before {
            opacity: 1;
        }

        /* Enhanced AI Message Content */
        .ai-message h1, .ai-message h2, .ai-message h3, .ai-message h4 {
            color: var(--primary);
            font-weight: 800;
            margin: 20px 0 15px 0;
        }

        .ai-message h1 { font-size: 1.6rem; }
        .ai-message h2 { font-size: 1.4rem; }
        .ai-message h3 { font-size: 1.3rem; }
        .ai-message h4 { font-size: 1.2rem; }

        .ai-message p {
            margin-bottom: 15px;
            line-height: 1.8;
        }

        .ai-message ul, .ai-message ol {
            margin: 20px 0;
            padding-left: 30px;
        }

        .ai-message li {
            margin-bottom: 10px;
        }

        .ai-message strong {
            color: var(--primary);
            font-weight: 700;
        }

        .ai-message em {
            color: var(--secondary);
            font-style: italic;
        }

        .ai-message code {
            background: linear-gradient(135deg, #f1f5f9, #e2e8f0);
            padding: 4px 10px;
            border-radius: 8px;
            font-family: 'JetBrains Mono', 'Fira Code', monospace;
            font-size: 0.9rem;
            color: var(--primary-dark);
            border: 1px solid var(--border);
        }

        /* Enhanced Code Canvas */
        .code-canvas {
            background: linear-gradient(135deg, #1e293b, #334155);
            border-radius: 18px;
            margin: 25px 0;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(30, 41, 59, 0.4);
            border: 1px solid #475569;
            position: relative;
        }

        .code-header {
            background: linear-gradient(135deg, #374151, #4b5563);
            padding: 15px 25px;
            border-bottom: 1px solid #6b7280;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .code-dots {
            display: flex;
            gap: 8px;
        }

        .code-dot {
            width: 14px;
            height: 14px;
            border-radius: 50%;
        }

        .code-dot.red { background: #ef4444; }
        .code-dot.yellow { background: #f59e0b; }
        .code-dot.green { background: #10b981; }

        .code-copy-btn {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: white;
            padding: 8px 16px;
            border-radius: 10px;
            font-size: 0.85rem;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 6px;
            font-weight: 600;
        }

        .code-copy-btn:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: scale(1.05);
        }

        .code-copy-btn.copied {
            background: var(--success);
            transform: scale(1.1);
        }

        .code-content {
            padding: 25px;
            font-family: 'JetBrains Mono', 'Fira Code', monospace;
            font-size: 0.95rem;
            color: #e2e8f0;
            overflow-x: auto;
            line-height: 1.6;
        }

        .code-content pre {
            margin: 0;
            background: none;
            color: inherit;
            padding: 0;
            border: none;
            white-space: pre-wrap;
            word-wrap: break-word;
        }

        /* Enhanced IT Sahayata Promotion */
        .it-sahayata-promo {
            background: linear-gradient(135deg, rgba(79, 70, 229, 0.08), rgba(16, 185, 129, 0.08));
            border: 2px solid rgba(79, 70, 229, 0.15);
            border-radius: 20px;
            padding: 25px;
            margin: 25px 0;
            transition: all 0.4s ease;
            position: relative;
            overflow: hidden;
        }

        .it-sahayata-promo::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(79, 70, 229, 0.1), transparent);
            transition: left 0.8s ease;
        }

        .it-sahayata-promo:hover::before {
            left: 100%;
        }

        .it-sahayata-promo:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(79, 70, 229, 0.2);
        }

        .promo-header {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 20px;
        }

        .promo-icon {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.3rem;
        }

        .promo-header h4 {
            color: var(--primary);
            font-weight: 800;
            font-size: 1.3rem;
            margin: 0;
        }

        .promo-content {
            color: var(--gray);
            margin-bottom: 20px;
            line-height: 1.7;
            font-size: 1rem;
        }

        .promo-contact {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: white;
            padding: 20px;
            border-radius: 15px;
            text-align: center;
            font-weight: 600;
            margin-bottom: 15px;
        }

        .promo-phone {
            font-size: 1.4rem;
            font-weight: 900;
            letter-spacing: 2px;
            margin: 8px 0;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.2);
        }

        .promo-availability {
            font-size: 0.9rem;
            opacity: 0.95;
        }

        .promo-cta {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: linear-gradient(135deg, var(--success), #059669);
            color: white;
            padding: 12px 25px;
            border-radius: 30px;
            text-decoration: none;
            font-weight: 700;
            transition: all 0.3s ease;
            box-shadow: 0 6px 20px rgba(16, 185, 129, 0.3);
        }

        .promo-cta:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(16, 185, 129, 0.4);
        }

        /* Enhanced Typing Indicator */
        .typing-indicator {
            align-self: flex-start;
            background: var(--ai-bubble);
            border: 2px solid var(--border);
            padding: 18px 25px;
            border-radius: 25px;
            border-bottom-left-radius: 10px;
            display: flex;
            align-items: center;
            gap: 15px;
            font-size: 1rem;
            color: var(--gray);
            max-width: 250px;
            box-shadow: 0 5px 20px var(--shadow);
        }

        .typing-text {
            font-weight: 600;
        }

        .typing-dots {
            display: flex;
            gap: 5px;
        }

        .typing-dot {
            width: 10px;
            height: 10px;
            background: var(--primary);
            border-radius: 50%;
            animation: typingBounce 1.4s infinite ease-in-out;
        }

        .typing-dot:nth-child(1) { animation-delay: -0.32s; }
        .typing-dot:nth-child(2) { animation-delay: -0.16s; }
        .typing-dot:nth-child(3) { animation-delay: 0s; }

        @keyframes typingBounce {
            0%, 80%, 100% {
                transform: scale(0.8) translateY(0);
                opacity: 0.5;
            }
            40% {
                transform: scale(1.3) translateY(-12px);
                opacity: 1;
            }
        }

        /* Enhanced Input Area */
        .ai-chat-input-container {
            padding: 30px;
            border-top: 3px solid var(--border);
            background: var(--white);
            display: flex;
            gap: 20px;
            align-items: flex-end;
            position: relative;
        }

        .ai-chat-input-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--primary), var(--secondary), var(--success));
        }

        .input-wrapper {
            flex: 1;
            position: relative;
        }

        .ai-chat-input {
            width: 100%;
            padding: 18px 25px;
            border: 2px solid var(--border);
            border-radius: 30px;
            font-family: inherit;
            font-size: 1rem;
            outline: none;
            transition: all 0.3s ease;
            background: var(--light);
            color: var(--dark);
            resize: none;
            min-height: 60px;
            max-height: 150px;
        }

        .ai-chat-input:focus {
            border-color: var(--primary);
            background: var(--white);
            box-shadow: 0 0 0 5px rgba(79, 70, 229, 0.1);
        }

        .ai-chat-input::placeholder {
            color: var(--gray);
            font-style: italic;
        }

        .ai-chat-send-btn, .ai-chat-stop-btn {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: white;
            border: none;
            border-radius: 50%;
            width: 60px;
            height: 60px;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
            box-shadow: 0 8px 25px rgba(79, 70, 229, 0.3);
            flex-shrink: 0;
        }

        .ai-chat-send-btn:hover, .ai-chat-stop-btn:hover {
            transform: translateY(-5px) scale(1.1);
            box-shadow: 0 12px 35px rgba(79, 70, 229, 0.4);
        }

        .ai-chat-stop-btn {
            background: linear-gradient(135deg, var(--danger), #dc2626);
            box-shadow: 0 8px 25px rgba(239, 68, 68, 0.3);
        }

        .ai-chat-stop-btn:hover {
            box-shadow: 0 12px 35px rgba(239, 68, 68, 0.4);
        }

        /* Enhanced Contact Float */
        .contact-float {
            position: fixed;
            bottom: 35px;
            right: 35px;
            z-index: 100;
            width: 70px;
            height: 70px;
            background: linear-gradient(135deg, var(--success), #059669);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 12px 35px rgba(16, 185, 129, 0.4);
            cursor: pointer;
            transition: all 0.4s ease;
            font-size: 1.8rem;
            animation: contactFloat 4s ease-in-out infinite;
        }

        @keyframes contactFloat {
            0%, 100% {
                transform: scale(1) translateY(0);
            }
            25% {
                transform: scale(1.05) translateY(-5px);
            }
            50% {
                transform: scale(1.1) translateY(-8px);
            }
            75% {
                transform: scale(1.05) translateY(-5px);
            }
        }

        .contact-float:hover {
            transform: scale(1.15);
            animation: none;
            box-shadow: 0 18px 45px rgba(16, 185, 129, 0.5);
        }

        .contact-card {
            position: absolute;
            bottom: 90px;
            right: 0;
            width: 350px;
            background: var(--white);
            border-radius: 25px;
            padding: 30px;
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.15);
            transform: scale(0);
            transform-origin: bottom right;
            transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
            opacity: 0;
            border: 2px solid var(--border);
        }

        .contact-card.show {
            transform: scale(1);
            opacity: 1;
        }

        .contact-card h3 {
            color: var(--primary);
            font-size: 1.4rem;
            font-weight: 800;
            margin-bottom: 18px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .contact-card p {
            color: var(--gray);
            margin-bottom: 18px;
            font-size: 1rem;
            line-height: 1.7;
        }

        .contact-number {
            display: flex;
            align-items: center;
            gap: 15px;
            font-size: 1.3rem;
            font-weight: 800;
            color: var(--dark);
            margin-bottom: 25px;
            padding: 18px;
            background: var(--light);
            border-radius: 18px;
            border: 2px solid var(--border);
        }

        .contact-number i {
            color: var(--primary);
            font-size: 1.5rem;
        }

        /* Responsive Design */
        @media (max-width: 992px) {
            .hero-features {
                gap: 20px;
            }

            .floating-tech-icons {
                display: none;
            }

            .ai-chat-container {
                margin-top: -40px;
            }
        }

        @media (max-width: 768px) {
            .ai-hero-section {
                padding: 80px 0 60px;
            }

            .hero-features {
                flex-direction: column;
                align-items: center;
                gap: 15px;
            }

            .ai-chat-container {
                margin-top: -30px;
                padding: 0 15px;
            }

            .ai-chat-card {
                border-radius: 25px 25px 0 0;
            }

            .ai-chat-header {
                padding: 25px;
            }

            .ai-avatar {
                width: 55px;
                height: 55px;
                font-size: 1.6rem;
            }

            .ai-chat-messages {
                height: 450px;
                padding: 30px 25px;
            }

            .message {
                max-width: 90%;
                padding: 18px 22px;
            }

            .ai-chat-input-container {
                padding: 25px;
            }

            .contact-float {
                width: 60px;
                height: 60px;
                bottom: 25px;
                right: 25px;
                font-size: 1.5rem;
            }

            .contact-card {
                width: 320px;
                bottom: 75px;
                right: -15px;
            }

            .code-canvas {
                margin: 20px -10px;
            }
        }

        @media (max-width: 480px) {
            .ai-chat-messages {
                height: 400px;
                padding: 25px 20px;
            }

            .message {
                max-width: 95%;
                padding: 16px 20px;
            }

            .contact-card {
                width: 300px;
                right: -25px;
                padding: 25px;
            }

            .code-canvas {
                margin: 15px -15px;
            }

            .code-header {
                padding: 12px 20px;
            }

            .code-content {
                padding: 20px;
                font-size: 0.9rem;
            }
        }
    </style>
</head>
<body>

<!-- Background Particles -->
<div class="bg-particles" id="bgParticles"></div>

<?php include 'header.php'; ?>

<!-- Enhanced AI Hero Section -->
<section class="ai-hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8 mx-auto">
                <div class="hero-content">
                    <div class="hero-badge">
                        <i class="fas fa-robot"></i>
                        <span>AI-Powered IT Support</span>
                    </div>
                    
                    <h1 class="hero-title">Smart IT Solutions के साथ</h1>
                    <p class="hero-subtitle">
                        Advanced AI technology के साथ instant IT support पाएं। हमारे AI assistant से chat करें 
                        और तुरंत solutions पाएं, जरूरत पड़ने पर expert technicians भी available हैं।
                    </p>
                    
                    <div class="hero-features">
                        <div class="hero-feature">
                            <i class="fas fa-bolt"></i>
                            <span>Instant Solutions</span>
                        </div>
                        <div class="hero-feature">
                            <i class="fas fa-shield-alt"></i>
                            <span>Secure Support</span>
                        </div>
                        <div class="hero-feature">
                            <i class="fas fa-clock"></i>
                            <span>24/7 Available</span>
                        </div>
                        <div class="hero-feature">
                            <i class="fas fa-user-tie"></i>
                            <span>Expert Backup</span>
                        </div>
                    </div>
                    
                    <a href="#ai-chat" class="hero-cta">
                        <i class="fas fa-comments"></i>
                        Start AI Chat Now
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Enhanced Hero Images -->
        <div class="hero-images">
            <div class="row justify-content-center">
                <div class="col-md-8 text-center">
                    <img src="../assets/it-ai.png" alt="AI Chat Interface" class="hero-main-image">
                    
                    <div class="floating-tech-icons">
                        <div class="tech-icon">
                            <i class="fas fa-robot"></i>
                        </div>
                        <div class="tech-icon">
                            <i class="fas fa-laptop"></i>
                        </div>
                        <div class="tech-icon">
                            <i class="fas fa-server"></i>
                        </div>
                        <div class="tech-icon">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- AI Chat Section -->
<section id="ai-chat" class="py-5">
    <div class="container ai-chat-container">
        <div class="ai-chat-card">
            <div class="ai-chat-header">
                <div class="chat-header-content">
                    <div class="ai-avatar">
                        <i class="fas fa-robot"></i>
                    </div>
                    <div class="chat-info">
                        <h2>IT Sahayata AI Assistant</h2>
                        <div class="chat-status">
                            <div class="status-dot"></div>
                            <span>Online & Ready to Help</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <div id="ai-chat-messages" class="ai-chat-messages">
                <!-- AI welcome message -->
                <div class="message ai-message">
                    <h2>🚀 Welcome to IT Sahayata AI!</h2>
                    <p>मैं आपका intelligent IT support assistant हूं! मैं आपकी सभी technology problems को instantly solve कर सकता हूं।</p>
                    
                    <h3>💡 मैं इन सभी में आपकी help कर सकता हूं:</h3>
                    <ul>
                        <li>🖥️ Computer & laptop troubleshooting और repairs</li>
                        <li>📱 Mobile device issues और setup problems</li>
                        <li>🌐 Internet & network connectivity solutions</li>
                        <li>🛡️ Security issues & virus removal</li>
                        <li>💾 Data recovery & backup solutions</li>
                        <li>⚙️ Software installation & configuration</li>
                        <li>🔧 Hardware diagnostics & repair guidance</li>
                        <li>📋 System optimization & performance tuning</li>
                    </ul>
                    
                    <p><strong>बस अपनी problem detail में बताएं और मैं step-by-step solution provide करूंगा!</strong></p>
                    
                    <div class="it-sahayata-promo">
                        <div class="promo-header">
                            <div class="promo-icon">
                                <i class="fas fa-tools"></i>
                            </div>
                            <h4>IT Sahayata Professional Services</h4>
                        </div>
                        <div class="promo-content">
                            Complex hardware issues या on-site support के लिए हमारे certified technicians available हैं! Professional IT services including computer repairs, network setup, data recovery, और emergency support.
                        </div>
                        <div class="promo-contact">
                            <div>📞 Expert Technicians Available</div>
                            <div class="promo-phone">7703823008</div>
                            <div class="promo-availability">24/7 On-site & Remote Support</div>
                        </div>
                        <a href="tel:7703823008" class="promo-cta">
                            <i class="fas fa-phone"></i>
                            Call IT Sahayata Now
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="ai-chat-input-container">
                <div class="input-wrapper">
                    <textarea 
                        id="ai-chat-input" 
                        class="ai-chat-input" 
                        placeholder="अपनी IT problem यहाँ detail में बताएं... जैसे कि computer hang हो रहा है, internet slow है, virus आ गया है आदि"
                        rows="1"
                    ></textarea>
                </div>
                <button id="ai-chat-send" class="ai-chat-send-btn">
                    <i class="fas fa-paper-plane"></i>
                </button>
                <button id="ai-chat-stop" class="ai-chat-stop-btn" style="display: none;">
                    <i class="fas fa-stop"></i>
                </button>
            </div>
        </div>
    </div>
</section>

<!-- Enhanced Contact Float -->
<div class="contact-float" id="contactFloat">
    <i class="fas fa-headset"></i>
    <div class="contact-card" id="contactCard">
        <h3><i class="fas fa-phone"></i> Expert IT Support</h3>
        <p>Need immediate professional assistance? हमारे certified technicians तुरंत help के लिए ready हैं!</p>
        <div class="contact-number">
            <i class="fas fa-phone"></i>
            <span>7703823008</span>
        </div>
        <p><strong>Available 24/7</strong><br>On-site & Remote Support Available</p>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const chatMessages = document.getElementById('ai-chat-messages');
    const chatInput = document.getElementById('ai-chat-input');
    const chatSendBtn = document.getElementById('ai-chat-send');
    const chatStopBtn = document.getElementById('ai-chat-stop');
    const contactFloat = document.getElementById('contactFloat');
    const contactCard = document.getElementById('contactCard');
    
    let isGenerating = false;
    let stopGeneration = false;
    let conversationHistory = [];

    // Create background particles
    function createBackgroundParticles() {
        const particlesContainer = document.getElementById('bgParticles');
        const particleCount = 30;
        
        for (let i = 0; i < particleCount; i++) {
            const particle = document.createElement('div');
            particle.classList.add('particle');
            
            const size = Math.random() * 10 + 5;
            particle.style.width = `${size}px`;
            particle.style.height = `${size}px`;
            particle.style.left = `${Math.random() * 100}%`;
            
            const duration = Math.random() * 10 + 20;
            particle.style.animationDuration = `${duration}s`;
            particle.style.animationDelay = `${Math.random() * 15}s`;
            
            particlesContainer.appendChild(particle);
        }
    }
    
    createBackgroundParticles();

    // Auto-resize textarea
    chatInput.addEventListener('input', function() {
        this.style.height = 'auto';
        this.style.height = Math.min(this.scrollHeight, 150) + 'px';
    });

    // Contact Float Toggle
    contactFloat.addEventListener('click', function(e) {
        e.stopPropagation();
        contactCard.classList.toggle('show');
    });

    document.addEventListener('click', function(e) {
        if (!contactFloat.contains(e.target)) {
            contactCard.classList.remove('show');
        }
    });

    // Enhanced markdown processing
    function processMarkdown(text) {
        // Code blocks
        text = text.replace(/``````/g, function(match, lang, code) {
            const codeId = 'code-' + Math.random().toString(36).substr(2, 9);
            const language = lang || 'code';
            return `
                <div class="code-canvas">
                    <div class="code-header">
                        <div class="code-dots">
                            <div class="code-dot red"></div>
                            <div class="code-dot yellow"></div>
                            <div class="code-dot green"></div>
                        </div>
                        <button class="code-copy-btn" onclick="copyCode('${codeId}')">
                            <i class="fas fa-copy"></i> Copy
                        </button>
                    </div>
                    <div class="code-content">
                        <pre id="${codeId}"><code>${escapeHtml(code.trim())}</code></pre>
                    </div>
                </div>
            `;
        });

        // Inline code
        text = text.replace(/`([^`]+)`/g, '<code>$1</code>');

        // Headers
        text = text.replace(/^### (.*$)/gim, '<h3>$1</h3>');
        text = text.replace(/^## (.*$)/gim, '<h2>$1</h2>');
        text = text.replace(/^# (.*$)/gim, '<h1>$1</h1>');

        // Bold and italic
        text = text.replace(/\*\*([^\*]+)\*\*/g, '<strong>$1</strong>');
        text = text.replace(/\*([^\*]+)\*/g, '<em>$1</em>');

        // Numbered lists
        text = text.replace(/((?:^\d+\..*(?:\n|$))+)/gm, function(match) {
            const items = match.trim().split(/\n/).filter(Boolean).map(line => {
                return line.replace(/^\d+\.\s*/, '');
            });
            return '<ol>' + items.map(item => `<li>${item}</li>`).join('') + '</ol>';
        });

        // Bullet lists
        text = text.replace(/((?:^[-*].*(?:\n|$))+)/gm, function(match) {
            const items = match.trim().split(/\n/).filter(Boolean).map(line => {
                return line.replace(/^[-*]\s*/, '');
            });
            return '<ul>' + items.map(item => `<li>${item}</li>`).join('') + '</ul>';
        });

        // Paragraphs
        text = text.replace(/\n{2,}/g, '</p><p>');
        text = '<p>' + text.replace(/\n/g, '<br>') + '</p>';

        // Clean up
        text = text.replace(/<p><\/p>/g, '');
        text = text.replace(/<p><br><\/p>/g, '');

        return text;
    }

    function escapeHtml(text) {
        const map = {
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#39;'
        };
        return text.replace(/[&<>"']/g, function(m) { return map[m]; });
    }

    // Copy code functionality
    window.copyCode = function(codeId) {
        const codeElement = document.getElementById(codeId);
        if (!codeElement) return;
        
        const text = codeElement.textContent;
        
        if (navigator.clipboard) {
            navigator.clipboard.writeText(text).then(function() {
                showCopySuccess(codeId);
            }).catch(function() {
                fallbackCopy(text, codeId);
            });
        } else {
            fallbackCopy(text, codeId);
        }
    };

    function fallbackCopy(text, codeId) {
        const textArea = document.createElement('textarea');
        textArea.value = text;
        textArea.style.position = 'fixed';
        textArea.style.left = '-999999px';
        textArea.style.top = '-999999px';
        document.body.appendChild(textArea);
        textArea.focus();
        textArea.select();
        
        try {
            document.execCommand('copy');
            showCopySuccess(codeId);
        } catch (err) {
            console.error('Copy failed:', err);
        }
        
        document.body.removeChild(textArea);
    }

    function showCopySuccess(codeId) {
        const codeElement = document.getElementById(codeId);
        const button = codeElement.parentElement.parentElement.querySelector('.code-copy-btn');
        
        if (button) {
            const originalText = button.innerHTML;
            button.innerHTML = '<i class="fas fa-check"></i> Copied!';
            button.classList.add('copied');
            
            setTimeout(function() {
                button.innerHTML = originalText;
                button.classList.remove('copied');
            }, 2000);
        }
    }

    // Add message
    function addMessage(text, isUser = false) {
        const messageDiv = document.createElement('div');
        messageDiv.className = isUser ? 'message user-message' : 'message ai-message';

        if (isUser) {
            messageDiv.textContent = text;
            conversationHistory.push({
                role: 'user',
                content: text
            });
        } else {
            const processedText = processMarkdown(text);
            messageDiv.innerHTML = processedText;
            
            conversationHistory.push({
                role: 'assistant',
                content: text
            });

            // Always add IT Sahayata promotion for every response
            addITSahayataPromo(messageDiv, text);
        }

        chatMessages.appendChild(messageDiv);
        scrollToBottom();
    }

    function addITSahayataPromo(messageDiv, problemText) {
        // Determine promo type based on problem category
        const promoCard = document.createElement('div');
        promoCard.className = 'it-sahayata-promo';
        
        let promoContent = getCustomPromoContent(problemText);
        
        promoCard.innerHTML = `
            <div class="promo-header">
                <div class="promo-icon">
                    <i class="${promoContent.icon}"></i>
                </div>
                <h4>${promoContent.title}</h4>
            </div>
            <div class="promo-content">
                ${promoContent.description}
            </div>
            <div class="promo-contact">
                <div>📞 IT Sahayata Expert Support</div>
                <div class="promo-phone">7703823008</div>
                <div class="promo-availability">24/7 Professional IT Services</div>
            </div>
            <a href="tel:7703823008" class="promo-cta">
                <i class="fas fa-phone"></i>
                ${promoContent.cta}
            </a>
        `;
        messageDiv.appendChild(promoCard);
    }

    function getCustomPromoContent(problemText) {
        const lowerText = problemText.toLowerCase();
        
        if (lowerText.includes('hardware') || lowerText.includes('repair') || lowerText.includes('broken') || lowerText.includes('damage')) {
            return {
                icon: 'fas fa-tools',
                title: 'Hardware Repair Services',
                description: 'Hardware problems के लिए IT Sahayata के certified technicians available हैं! Computer, laptop repairs, component replacement, और professional diagnosis services.',
                cta: 'Get Hardware Support'
            };
        } else if (lowerText.includes('network') || lowerText.includes('internet') || lowerText.includes('wifi') || lowerText.includes('connection')) {
            return {
                icon: 'fas fa-wifi',
                title: 'Network Solutions',
                description: 'Network issues के लिए IT Sahayata expert team ready है! Internet setup, WiFi configuration, network troubleshooting, और security implementation.',
                cta: 'Fix Network Issues'
            };
        } else if (lowerText.includes('virus') || lowerText.includes('malware') || lowerText.includes('security') || lowerText.includes('hacked')) {
            return {
                icon: 'fas fa-shield-alt',
                title: 'Cybersecurity Services',
                description: 'Security threats से protection के लिए IT Sahayata cybersecurity experts available हैं! Virus removal, malware cleaning, और complete system security.',
                cta: 'Secure My System'
            };
        } else if (lowerText.includes('data') || lowerText.includes('recovery') || lowerText.includes('backup') || lowerText.includes('lost')) {
            return {
                icon: 'fas fa-database',
                title: 'Data Recovery Services',
                description: 'Data loss problems के लिए IT Sahayata professional data recovery services provide करता है! File recovery, backup solutions, और data protection.',
                cta: 'Recover My Data'
            };
        } else if (lowerText.includes('software') || lowerText.includes('program') || lowerText.includes('application') || lowerText.includes('install')) {
            return {
                icon: 'fas fa-download',
                title: 'Software Solutions',
                description: 'Software issues के लिए IT Sahayata technical team ready है! Software installation, configuration, troubleshooting, और optimization services.',
                cta: 'Get Software Help'
            };
        } else {
            return {
                icon: 'fas fa-user-tie',
                title: 'Professional IT Support',
                description: 'किसी भी IT problem के लिए IT Sahayata comprehensive solutions provide करता है! Professional diagnosis, repair services, और 24/7 technical support.',
                cta: 'Get Expert Help'
            };
        }
    }

    function showTypingIndicator() {
        const typingDiv = document.createElement('div');
        typingDiv.className = 'typing-indicator';
        typingDiv.id = 'typing-indicator';
        typingDiv.innerHTML = `
            <span class="typing-text">IT Sahayata AI is thinking</span>
            <div class="typing-dots">
                <div class="typing-dot"></div>
                <div class="typing-dot"></div>
                <div class="typing-dot"></div>
            </div>
        `;
        chatMessages.appendChild(typingDiv);
        scrollToBottom();
    }

    function removeTypingIndicator() {
        const typingDiv = document.getElementById('typing-indicator');
        if (typingDiv) {
            typingDiv.remove();
        }
    }

    function scrollToBottom() {
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }

    // Enhanced AI interaction
    async function sendToAI(userInput) {
        try {
            const pathArray = window.location.pathname.split('/');
            const appDirIndex = pathArray.indexOf('ITSupportApp');
            let baseUrl = '';
            
            if (appDirIndex !== -1) {
                const basePath = pathArray.slice(0, appDirIndex + 1).join('/');
                baseUrl = window.location.origin + basePath;
            } else {
                baseUrl = window.location.origin;
            }

            const contextMessages = conversationHistory.slice(-10);
            const contextString = contextMessages.map(msg => 
                `${msg.role === 'user' ? 'User' : 'IT Sahayata AI'}: ${msg.content}`
            ).join('\n');

            const enforcedPrompt = `
You are "IT Sahayata AI", an expert IT support assistant specializing in solving all technology problems. You must ALWAYS promote IT Sahayata professional services at the end of every response.

CONVERSATION HISTORY:
${contextString}

CURRENT USER PROBLEM: ${userInput}

IMPORTANT INSTRUCTIONS:
1. **Context Awareness**: Remember previous conversation and reference it when relevant
2. **Comprehensive Solutions**: Provide detailed, step-by-step solutions with clear explanations
3. **Professional Tone**: Be helpful, patient, and expert while remaining friendly
4. **Format Responses**: Use proper markdown formatting (headers, lists, code blocks, emphasis)
5. **Code Solutions**: When providing code, always wrap in proper code blocks with language
6. **IT Sahayata Promotion**: ALWAYS end responses by mentioning IT Sahayata professional services
7. **Safety Warnings**: Include safety warnings for hardware work
8. **Follow-up**: Ask clarifying questions when needed

**Response Guidelines:**
- Start with acknowledging the problem
- Provide step-by-step solution
- Use emojis appropriately for better engagement
- Use markdown formatting: # headers, **bold**, *italic*, \`code\`, lists
- Always end with IT Sahayata service promotion

**IT Sahayata Services to Promote:**
- Hardware repairs & diagnostics
- Network setup & troubleshooting  
- Data recovery & backup
- Cybersecurity & virus removal
- Software installation & configuration
- On-site & remote support
- Emergency 24/7 services
- Contact: 7703823008

**Sample Ending (customize based on problem type):**
"अगर यह solution काम नहीं करे या आपको professional assistance चाहिए, तो IT Sahayata के certified technicians तुरंत help के लिए available हैं! Call करें: 7703823008"

Provide your detailed response with proper formatting and always include IT Sahayata promotion.
            `.trim();
            
            const response = await fetch(baseUrl + '/ask_gemini.php', {
                method: 'POST',
                headers: {'Content-Type': 'application/json'},
                body: JSON.stringify({ prompt: enforcedPrompt })
            });
            
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            
            const data = await response.json();
            return (data.result || '').replace(/^AI:/i, '').trim();
            
        } catch (error) {
            console.error('Error:', error);
            return '⚠️ **Connection Error**\n\nSorry, technical issue हो गया है। Please try again करें।\n\nImmediate assistance के लिए IT Sahayata experts को call करें: **7703823008** - 24/7 emergency support available!';
        }
    }

    // Handle send message
    async function handleSendMessage() {
        const userText = chatInput.value.trim();
        if (!userText || isGenerating) return;

        addMessage(userText, true);
        chatInput.value = '';
        chatInput.style.height = 'auto';
        
        chatInput.disabled = true;
        chatSendBtn.style.display = 'none';
        chatStopBtn.style.display = 'flex';
        isGenerating = true;
        stopGeneration = false;

        showTypingIndicator();

        try {
            const aiResponse = await sendToAI(userText);
            
            if (!stopGeneration) {
                removeTypingIndicator();
                addMessage(aiResponse);
            }
        } catch (error) {
            removeTypingIndicator();
            addMessage('⚠️ **Error**: कुछ technical issue हुआ है। Please try again करें या IT Sahayata को call करें: **7703823008**');
        }

        chatInput.disabled = false;
        chatStopBtn.style.display = 'none';
        chatSendBtn.style.display = 'flex';
        isGenerating = false;
        chatInput.focus();
    }

    // Event listeners
    chatSendBtn.addEventListener('click', handleSendMessage);
    
    chatStopBtn.addEventListener('click', function() {
        stopGeneration = true;
        removeTypingIndicator();
        
        chatInput.disabled = false;
        chatStopBtn.style.display = 'none';
        chatSendBtn.style.display = 'flex';
        isGenerating = false;
        chatInput.focus();
    });

    chatInput.addEventListener('keydown', function(e) {
        if (e.key === 'Enter' && !e.shiftKey && !isGenerating) {
            e.preventDefault();
            handleSendMessage();
        }
    });

    // Smooth scroll to chat section
    document.querySelectorAll('a[href="#ai-chat"]').forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            document.getElementById('ai-chat').scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        });
    });

    chatInput.focus();
});
</script>

<?php include 'footer.php'; ?>

</body>
</html>
