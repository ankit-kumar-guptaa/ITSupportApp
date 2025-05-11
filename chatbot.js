// --- Chatbot Widget Logic ---
const ICON_ID = 'itsahayata-chat-icon';
const CHAT_ID = 'itsahayata-chatbot-root';
let currentQueryId = null;

// Get base URL for API calls
function getBaseUrl() {
  // Get the base URL (domain and path to root directory)
  const pathArray = window.location.pathname.split('/');
  const appDirIndex = pathArray.indexOf('ITSupportApp');
  
  if (appDirIndex !== -1) {
    // If we're in a subdirectory of ITSupportApp
    const basePath = pathArray.slice(0, appDirIndex + 1).join('/');
    return window.location.origin + basePath;
  }
  
  // Fallback to origin if we can't determine the app directory
  return window.location.origin;
}

// Check if user has already submitted the form
function hasUserSubmittedForm() {
  return localStorage.getItem('itsahayata_user_submitted') === 'true';
}

// Save user submission status
function saveUserSubmission() {
  localStorage.setItem('itsahayata_user_submitted', 'true');
  localStorage.setItem('itsahayata_last_session', new Date().toISOString());
}

// Check if we need to show the form again (after 24 hours)
function shouldResetForm() {
  const lastSession = localStorage.getItem('itsahayata_last_session');
  if (!lastSession) return true;
  
  const lastSessionDate = new Date(lastSession);
  const currentDate = new Date();
  const hoursDiff = (currentDate - lastSessionDate) / (1000 * 60 * 60);
  
  // Reset form after 24 hours
  return hoursDiff >= 24;
}

// Company services and promotions
const companyServices = [
  {
    name: "Free IT Consultation",
    description: "Get a free 15-minute consultation with our IT experts",
    link: getBaseUrl() + "/views/free-consultation.php#consultation-form"
  },
  {
    name: "Affordable PC Repair",
    description: "Complete PC diagnostics and repair starting at just ₹499",
    link: getBaseUrl() + "/views/contact.php"
  },
  {
    name: "Data Recovery",
    description: "Lost important data? We can help recover it at competitive rates",
    link: getBaseUrl() + "/views/contact.php"
  },
  {
    name: "Network Setup",
    description: "Professional network setup and troubleshooting for home and office",
    link: getBaseUrl() + "/views/contact.php"
  },
  {
    name: "Software Installation",
    description: "Software installation and configuration service at affordable prices",
    link: getBaseUrl() + "/views/contact.php"
  }
];

// Initialize chatbot when DOM is fully loaded
document.addEventListener('DOMContentLoaded', function() {
  // Find chat icon
  const chatIcon = document.getElementById(ICON_ID);
  if (chatIcon) {
    chatIcon.addEventListener('click', async () => {
      itsaChatOpen = !itsaChatOpen;
      renderChatbot(itsaChatOpen);
    });
  } else {
    console.error('Chat icon element not found with ID:', ICON_ID);
  }
});

function renderChatbot(open) {
  if(open) {
    // Check if form was submitted before
    const formSubmitted = hasUserSubmittedForm() && !shouldResetForm();
    
    document.getElementById(CHAT_ID).innerHTML = `
      <div id="itsahayata-chatbot-box">
        <div id="itsahayata-chatbot-header">
          <span class="title">IT Sahayata <span style='font-size:13px;font-weight:400;opacity:.7;'>AI</span></span>
          <button class="close" title="Close Chat" onclick="window.closeItsaChatbot()">×</button>
        </div>
        <div id="itsahayata-chatbot-messages" style="${formSubmitted ? 'display:flex;' : 'display:none;'}"></div>
        <div id="itsahayata-user-form" style="${formSubmitted ? 'display:none;' : 'display:block;'}">
          <h3>Please provide your information</h3>
          <p style="text-align:center;margin-bottom:15px;color:#666;font-size:13px;">
            Fill this form to start using the IT Support AI
          </p>
          <div class="form-group">
            <label for="itsahayata-name">Name</label>
            <input type="text" id="itsahayata-name" placeholder="Enter your name" required />
          </div>
          <div class="form-group">
            <label for="itsahayata-email">Email</label>
            <input type="email" id="itsahayata-email" placeholder="Enter your email" required />
          </div>
          <div class="form-group">
            <label for="itsahayata-phone">Phone Number</label>
            <input type="tel" id="itsahayata-phone" placeholder="Enter your phone number" required />
          </div>
          <div class="form-group">
            <label for="itsahayata-problem">Problem Description</label>
            <textarea id="itsahayata-problem" placeholder="Describe your IT issue" required></textarea>
          </div>
          <button type="button" id="itsahayata-submit-details">Start Chat</button>
        </div>
        <form id="itsahayata-chatbot-inputform" style="${formSubmitted ? 'display:flex;' : 'display:none;'}">
          <input id="itsahayata-chatbot-input" autocomplete="off" maxlength="420" placeholder="Describe your IT problem..." required />
          <button type="submit" id="itsahayata-chatbot-sendbtn">Send</button>
        </form>
        <div id="itsahayata-chatbot-brand">IT Sahayata • Ankit Kumar Gupta</div>
      </div>
    `;
    
    // Add event listener for user details form
    document.getElementById('itsahayata-submit-details').addEventListener('click', submitUserDetails);
    
    // If user already submitted form, initialize chat events
    if (formSubmitted) {
      itsaInitEvents();
      // Show welcome back message with typing animation
      typeMessage('bot', `👋 Welcome back to IT Sahayata! How can I help you today?`);
    }
    
  } else {
    document.getElementById(CHAT_ID).innerHTML = '';
  }
}

async function submitUserDetails() {
  const nameInput = document.getElementById('itsahayata-name');
  const emailInput = document.getElementById('itsahayata-email');
  const phoneInput = document.getElementById('itsahayata-phone');
  const problemInput = document.getElementById('itsahayata-problem');
  
  // Validate inputs
  if (!nameInput.value.trim() || !emailInput.value.trim() || 
      !phoneInput.value.trim() || !problemInput.value.trim()) {
    alert('Please fill in all fields');
    return;
  }
  
  // Email validation
  const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  if (!emailRegex.test(emailInput.value.trim())) {
    alert('Please enter a valid email format');
    return;
  }
  
  try {
    const response = await fetch(getBaseUrl() + '/submit_user_details.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({
        name: nameInput.value.trim(),
        email: emailInput.value.trim(),
        phone: phoneInput.value.trim(),
        problem: problemInput.value.trim()
      })
    });
    
    const data = await response.json();
    
    if (data.success) {
      // Save user submission to localStorage
      saveUserSubmission();
      
      // Hide form and show chat interface
      document.getElementById('itsahayata-user-form').style.display = 'none';
      document.getElementById('itsahayata-chatbot-messages').style.display = 'flex';
      document.getElementById('itsahayata-chatbot-inputform').style.display = 'flex';
      
      // Store query ID for future messages
      currentQueryId = data.queryId;
      
      // Show welcome message with typing animation
      typeMessage('bot', `👋 Hello ${nameInput.value.trim()}! Welcome to IT Sahayata! Please describe your IT-related problem or question, and I'll help you.`);
      
      // Initialize chat events
      itsaInitEvents();
      
      // Save the welcome message to database
      await saveChatMessage(currentQueryId, `👋 Hello ${nameInput.value.trim()}! Welcome to IT Sahayata! Please describe your IT-related problem or question, and I'll help you.`, false);
      
    } else {
      alert('An error occurred: ' + (data.message || 'Please try again'));
    }
  } catch (error) {
    console.error('Error:', error);
    alert('An error occurred. Please try again.');
  }
}

async function saveChatMessage(queryId, message, isUser) {
  try {
    await fetch(getBaseUrl() + '/save_chat_message.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({
        queryId: queryId,
        message: message,
        isUser: isUser
      })
    });
  } catch (error) {
    console.error('Error saving message:', error);
  }
}

let itsaChatOpen = false;
window.closeItsaChatbot = () => {
  itsaChatOpen = false;
  renderChatbot(false);
};

// Remove the direct event listener here since we're adding it in DOMContentLoaded
// const chatIcon = document.getElementById(ICON_ID);
// chatIcon.addEventListener('click',async()=>{
//   itsaChatOpen = !itsaChatOpen;
//   renderChatbot(itsaChatOpen);
// });

function itsaInitEvents() {
  const form = document.getElementById('itsahayata-chatbot-inputform');
  const inp = document.getElementById('itsahayata-chatbot-input');
  const msgBox = document.getElementById('itsahayata-chatbot-messages');

  form.addEventListener('submit', async function(e){
    e.preventDefault();
    const userText = inp.value.trim();
    if(!userText) return;
    appendMsg('user', userText);
    
    // Save user message to database
    await saveChatMessage(currentQueryId, userText, true);
    
    inp.value = '';
    inp.disabled = true;
    document.getElementById('itsahayata-chatbot-sendbtn').disabled = true;
    appendThinking();
    const respTxt = await fetchGemini(userText);
    removeThinking();
    
    // Use typing animation for bot response
    typeMessage('bot', respTxt || 'Sorry, I couldn\'t find a solution. Please describe your problem again or provide more details.');
    
    // Save bot response to database
    await saveChatMessage(currentQueryId, respTxt || 'Sorry, I couldn\'t find a solution. Please describe your problem again or provide more details.', false);
    
    inp.disabled = false;
    document.getElementById('itsahayata-chatbot-sendbtn').disabled = false;
    inp.focus();
    msgBox.scrollTop = msgBox.scrollHeight;
  });
}

function appendMsg(role, text) {
  const box = document.getElementById('itsahayata-chatbot-messages');
  const msgDiv = document.createElement('div');
  msgDiv.className = role==='user' ? 'itsahayata-msg-user' : 'itsahayata-msg-bot';
  msgDiv.innerText = text;
  box.appendChild(msgDiv);
  box.scrollTop = box.scrollHeight;
}

// Typing animation function
function typeMessage(role, text) {
  const box = document.getElementById('itsahayata-chatbot-messages');
  const msgDiv = document.createElement('div');
  msgDiv.className = role==='user' ? 'itsahayata-msg-user' : 'itsahayata-msg-bot';
  msgDiv.id = 'typing-message';
  box.appendChild(msgDiv);
  
  let i = 0;
  const speed = 20; // Typing speed (lower is faster)
  
  function typeWriter() {
    if (i < text.length) {
      msgDiv.textContent += text.charAt(i);
      i++;
      box.scrollTop = box.scrollHeight;
      setTimeout(typeWriter, speed);
    } else {
      msgDiv.removeAttribute('id');
      
      // Check if we should add a promotional message (20% chance)
      if (role === 'bot' && Math.random() < 0.2) {
        setTimeout(() => {
          addPromotionalMessage();
        }, 1000);
      }
    }
  }
  
  typeWriter();
}

// Add promotional message with service suggestion
function addPromotionalMessage() {
  // Select random service
  const randomService = companyServices[Math.floor(Math.random() * companyServices.length)];
  
  const box = document.getElementById('itsahayata-chatbot-messages');
  const msgDiv = document.createElement('div');
  msgDiv.className = 'itsahayata-msg-bot itsahayata-promo-msg';
  
  msgDiv.innerHTML = `
    <p><strong>💡 Did you know?</strong></p>
    <p>${randomService.description}</p>
    <a href="${randomService.link}" target="_blank" class="itsahayata-promo-link">Learn more about ${randomService.name} →</a>
  `;
  
  box.appendChild(msgDiv);
  box.scrollTop = box.scrollHeight;
  
  // Add CSS for promotional message if not already added
  if (!document.getElementById('itsahayata-promo-styles')) {
    const styleEl = document.createElement('style');
    styleEl.id = 'itsahayata-promo-styles';
    styleEl.textContent = `
      .itsahayata-promo-msg {
        background: linear-gradient(135deg, rgba(138, 73, 247, 0.05), rgba(43, 115, 230, 0.05));
        border: 1px dashed rgba(138, 73, 247, 0.3);
      }
      .itsahayata-promo-link {
        display: inline-block;
        margin-top: 8px;
        color: #8a49f7;
        font-weight: 500;
        text-decoration: none;
        transition: all 0.2s ease;
      }
      .itsahayata-promo-link:hover {
        color: #2b73e6;
        text-decoration: underline;
      }
    `;
    document.head.appendChild(styleEl);
  }
}

function appendThinking() {
  const box = document.getElementById('itsahayata-chatbot-messages');
  const div = document.createElement('div');
  div.className = 'itsahayata-msg-thinking';
  div.id = 'itsahayata-msg-thinking';
  div.innerText = 'Thinking...';
  box.appendChild(div);
  box.scrollTop = box.scrollHeight;
}

function removeThinking() {
  const e = document.getElementById('itsahayata-msg-thinking');
  if(e) e.remove();
}

async function fetchGemini(userInput) {
  try {
    // Enhanced prompt with service recommendations
    const enforcedPrompt = `
You are "IT Sahayata", a helpful AI support expert for IT (hardware, software, internet, devices, tech problems). 
Give friendly, practical, and clear solutions to any queries that are related to IT, computers, networks, devices, internet, digital services, software, hardware etc.

Important guidelines:
1. If a user is having a general conversation or greeting, respond naturally but always be helpful regarding IT support.
2. Never reply: "I help with IT problems only." Instead, always try to answer helpfully.
3. Respond in a positive and helpful human tone; your goal is to genuinely solve problems.
4. When appropriate, mention that IT Sahayata offers affordable professional services for complex issues.
5. For hardware problems that can't be solved remotely, suggest that the user might benefit from our affordable on-site repair services.
6. For data recovery or security issues, mention that we offer specialized services at competitive rates.
7. For network setup or troubleshooting, mention that our technicians can provide professional assistance.
8. Always prioritize solving the user's problem first, then subtly mention our services only if relevant.

User message:
${userInput}
    `.trim();
    const r = await fetch(getBaseUrl() + '/ask_gemini.php', {
      method:'POST',
      headers:{'Content-Type':'application/json'},
      body: JSON.stringify({ prompt: enforcedPrompt })
    });
    if(!r.ok) return '';
    const j = await r.json();
    return (j.result||'').replace(/^AI:/i,'').trim();
  } catch(e){ return ''; }
}