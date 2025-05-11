// --- Chatbot Widget Logic ---
const ICON_ID = 'itsahayata-chat-icon';
const CHAT_ID = 'itsahayata-chatbot-root';
let currentQueryId = null;

function renderChatbot(open) {
  if(open) {
    document.getElementById(CHAT_ID).innerHTML = `
      <div id="itsahayata-chatbot-box">
        <div id="itsahayata-chatbot-header">
          <span class="title">IT Sahayata <span style='font-size:13px;font-weight:400;opacity:.7;'>AI</span></span>
          <button class="close" title="Close Chat" onclick="window.closeItsaChatbot()">×</button>
        </div>
        <div id="itsahayata-chatbot-messages" style="display:none;"></div>
        <div id="itsahayata-user-form">
          <h3>कृपया अपनी जानकारी दें</h3>
          <div class="form-group">
            <label for="itsahayata-name">नाम</label>
            <input type="text" id="itsahayata-name" placeholder="अपना नाम दर्ज करें" required />
          </div>
          <div class="form-group">
            <label for="itsahayata-email">ईमेल</label>
            <input type="email" id="itsahayata-email" placeholder="अपना ईमेल दर्ज करें" required />
          </div>
          <div class="form-group">
            <label for="itsahayata-phone">फोन नंबर</label>
            <input type="tel" id="itsahayata-phone" placeholder="अपना फोन नंबर दर्ज करें" required />
          </div>
          <div class="form-group">
            <label for="itsahayata-problem">समस्या का विवरण</label>
            <textarea id="itsahayata-problem" placeholder="अपनी IT समस्या का विवरण दें" required></textarea>
          </div>
          <button type="button" id="itsahayata-submit-details">शुरू करें</button>
        </div>
        <form id="itsahayata-chatbot-inputform" style="display:none;">
          <input id="itsahayata-chatbot-input" autocomplete="off" maxlength="420" placeholder="अपनी IT समस्या बताएं..." required />
          <button type="submit" id="itsahayata-chatbot-sendbtn">भेजें</button>
        </form>
        <div id="itsahayata-chatbot-brand">IT Sahayata • Ankit Kumar Gupta</div>
      </div>
    `;
    
    // Add event listener for user details form
    document.getElementById('itsahayata-submit-details').addEventListener('click', submitUserDetails);
    
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
    alert('कृपया सभी फील्ड भरें');
    return;
  }
  
  // Email validation
  const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  if (!emailRegex.test(emailInput.value.trim())) {
    alert('कृपया सही ईमेल फॉर्मेट दर्ज करें');
    return;
  }
  
  try {
    const response = await fetch('submit_user_details.php', {
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
      // Hide form and show chat interface
      document.getElementById('itsahayata-user-form').style.display = 'none';
      document.getElementById('itsahayata-chatbot-messages').style.display = 'flex';
      document.getElementById('itsahayata-chatbot-inputform').style.display = 'flex';
      
      // Store query ID for future messages
      currentQueryId = data.queryId;
      
      // Show welcome message
      appendMsg('bot', `👋 नमस्ते ${nameInput.value.trim()}! IT Sahayata में आपका स्वागत है! कृपया अपनी IT संबंधित समस्या या प्रश्न का विवरण दें और मैं आपकी मदद करूंगा।`);
      
      // Initialize chat events
      itsaInitEvents();
      
      // Save the welcome message to database
      await saveChatMessage(currentQueryId, `👋 नमस्ते ${nameInput.value.trim()}! IT Sahayata में आपका स्वागत है! कृपया अपनी IT संबंधित समस्या या प्रश्न का विवरण दें और मैं आपकी मदद करूंगा।`, false);
      
    } else {
      alert('एक त्रुटि हुई: ' + (data.message || 'कृपया पुनः प्रयास करें'));
    }
  } catch (error) {
    console.error('Error:', error);
    alert('एक त्रुटि हुई। कृपया पुनः प्रयास करें।');
  }
}

async function saveChatMessage(queryId, message, isUser) {
  try {
    await fetch('save_chat_message.php', {
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

const chatIcon = document.getElementById(ICON_ID);
chatIcon.addEventListener('click',async()=>{
  itsaChatOpen = !itsaChatOpen;
  renderChatbot(itsaChatOpen);
});

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
    appendMsg('bot', respTxt || 'माफ़ करें, मुझे कोई समाधान नहीं मिला। कृपया अपनी समस्या को दोबारा बताएं या अधिक विवरण प्रदान करें।');
    
    // Save bot response to database
    await saveChatMessage(currentQueryId, respTxt || 'माफ़ करें, मुझे कोई समाधान नहीं मिला। कृपया अपनी समस्या को दोबारा बताएं या अधिक विवरण प्रदान करें।', false);
    
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

function appendThinking() {
  const box = document.getElementById('itsahayata-chatbot-messages');
  const div = document.createElement('div');
  div.className = 'itsahayata-msg-thinking';
  div.id = 'itsahayata-msg-thinking';
  div.innerText = 'सोच रहा हूँ...';
  box.appendChild(div);
  box.scrollTop = box.scrollHeight;
}

function removeThinking() {
  const e = document.getElementById('itsahayata-msg-thinking');
  if(e) e.remove();
}

async function fetchGemini(userInput) {
  try {
    // This prompt makes answers helpful and dynamic for IT support
    const enforcedPrompt = `
You are "IT Sahayata", a helpful AI support expert for IT (hardware, software, internet, devices, tech problems). 
Give friendly, practical, and clear solutions to any queries that are related to IT, computers, networks, devices, internet, digital services, software, hardware etc.
If a user is having a general conversation or greeting, you can respond naturally—but always be helpful regarding IT support, troubleshooting, and solution.
Never reply: "I help with IT problems only." Instead, always try to answer helpfully, even for unclear queries, and encourage user to give details if you need more information.
Respond in a positive and helpful human tone; your goal is to genuinely solve problems or answer questions about IT.

User message:
${userInput}
    `.trim();
    const r = await fetch('ask_gemini.php', {
      method:'POST',
      headers:{'Content-Type':'application/json'},
      body: JSON.stringify({ prompt: enforcedPrompt })
    });
    if(!r.ok) return '';
    const j = await r.json();
    return (j.result||'').replace(/^AI:/i,'').trim();
  } catch(e){ return ''; }
}