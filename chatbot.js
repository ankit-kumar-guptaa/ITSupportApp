// --- Chatbot Widget Logic ---
const ICON_ID = 'itsahayata-chat-icon';
const CHAT_ID = 'itsahayata-chatbot-root';

function renderChatbot(open) {
  if(open) {
    document.getElementById(CHAT_ID).innerHTML = `
      <div id="itsahayata-chatbot-box">
        <div id="itsahayata-chatbot-header">
          <span class="title">IT Sahayata <span style='font-size:13px;font-weight:400;opacity:.7;'>AI</span></span>
          <button class="close" title="Close Chat" onclick="window.closeItsaChatbot()">×</button>
        </div>
        <div id="itsahayata-chatbot-messages"></div>
        <form id="itsahayata-chatbot-inputform">
          <input id="itsahayata-chatbot-input" autocomplete="off" maxlength="420" placeholder="Describe your IT problem..." required />
          <button type="submit" id="itsahayata-chatbot-sendbtn">Send</button>
        </form>
        <div id="itsahayata-chatbot-brand">IT Sahayata • Ankit Kumar Gupta</div>
      </div>
    `;
    // Show friendly welcome
    setTimeout(()=>{
      appendMsg('bot', "👋 Welcome to IT Sahayata! Please describe your IT-related problem or question and I'll do my best to help you.");
      const box = document.getElementById('itsahayata-chatbot-box');
      if(box) box.focus();
    }, 11);
  } else {
    document.getElementById(CHAT_ID).innerHTML = '';
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
  if(itsaChatOpen) itsaInitEvents();
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
    inp.value = '';
    inp.disabled = true;
    document.getElementById('itsahayata-chatbot-sendbtn').disabled = true;
    appendThinking();
    const respTxt = await fetchGemini(userText);
    removeThinking();
    appendMsg('bot', respTxt || 'Sorry, I could not find a solution. Please try rephrasing your problem or provide more details.');
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