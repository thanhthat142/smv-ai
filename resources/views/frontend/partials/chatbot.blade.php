<div id="chatbot-button">
    <div class="chatbot-tooltip">
        <strong>Trợ lý ảo Unitel</strong><br>
        Bạn cần trợ giúp? Chúng tôi luôn sẵn sàng hỗ trợ
    </div>            
    <img src="{{ asset('frontend/assets/chatbot-icon.jpg') }}" alt="Chatbot"/>
</div>

<div id="chatbot-window">
    <div id="chatbot-header">
        <img src="{{ asset('frontend/assets/favicon.png') }}" alt="Unitel" class="chatbot-logo">
        Trợ lý ảo Unitel
        <span id="chatbot-expand">🗖</span>
        <span id="chatbot-close">×</span>
    </div>
    <div id="chatbot-messages"></div>
    <div id="chatbot-input">
        <input type="text" id="user-input" placeholder="Nhập tin nhắn..." />
        <button onclick="sendMessage()">Gửi</button>
    </div>
</div>

<style>
    #chatbot-button {
        position: fixed;
        bottom: 80px;
        right: 25px;
        z-index: 9999;
        cursor: pointer;
    }
    #chatbot-button img {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        animation: pulse 2s infinite;
    }
    @keyframes pulse {
        0% {
            transform: scale(1);
        }
        50% {
            transform: scale(1.07);
        }
        100% {
            transform: scale(1);
        }
    }

    .chatbot-tooltip {
    position: absolute;
    right: 70px;
    bottom: 15px;
    background-color: #fff;
    color: #000;
    border: 1px solid #00aaff;
    padding: 8px 12px;
    border-radius: 10px;
    box-shadow: 0 2px 6px rgba(0,0,0,0.2);
    white-space: nowrap;
    display: none;
    font-size: 14px;
    }

    #chatbot-button:hover .chatbot-tooltip {
        display: block;
    }

    #chatbot-window {
        display: none;
        position: fixed;
        bottom: 85px;
        right: 25px;
        width: 400px;
        height: 500px;
        max-width: none;    
        background: #fff;
        border: 1px solid #ccc;
        border-radius: 10px;
        z-index: 9999;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
        overflow: hidden;
        flex-direction: column;
        transition: width 0.3s ease, height 0.3s ease;
    }

    #chatbot-header {
        background-color: #f44336;
        color: white;
        padding: 10px;
        font-weight: bold;
        align-items: center;
        display: flex;
        gap: 8px;
        position: relative;
    }
    #chatbot-header img {
        width: 20px;
        height: 20px;
        object-fit: contain
    }

    #chatbot-close {
    position: absolute;
    right: 10px;
    top: 5px;
    cursor: pointer;
    font-size: 20px;
    font-weight: bold;
    }

    #chatbot-close, #chatbot-expand {
        position: absolute;
        top: 8px;
        font-size: 16px;
        font-weight: bold;
        cursor: pointer;
        color: white;
    }
    #chatbot-close {
        right: 10px;
    }
    #chatbot-expand {
        right: 35px;
    }

    #chatbot-messages {
        flex: 1;
        padding: 10px;
        overflow-y: auto;
        height: 280px;
    }

    #chatbot-input {
        display: flex;
        border-top: 1px solid #ccc;
    }
    #chatbot-input input {
        flex: 1;
        border: none;
        padding: 10px;
        outline: none;
    }
    #chatbot-input button {
        background: #f44336;
        color: white;
        border: none;
        padding: 10px 15px;
        cursor: pointer;
    }

    .chat-message {
        margin: 8px 10px;
        padding: 10px 14px;
        border-radius: 15px;
        max-width: 80%;
        font-size: 14px;
        line-height: 1.4;
        display: inline-block;
        clear: both;

        word-break: break-word;
        white-space: normal;
        overflow-wrap: break-word;
    }
    .chat-message.bot {
        background-color: #f1f1f1;
        color: #000;
        float: left;
        border-top-left-radius: 0;
    }
    .chat-message.user {
        background-color: #f44336;
        color: #fff;
        float: right;
        border-top-right-radius: 0;
    }
</style>

<script>
    const chatbotButton = document.getElementById("chatbot-button");
    const chatbotWindow = document.getElementById("chatbot-window");
    const userInput = document.getElementById("user-input");
    const messages = document.getElementById("chatbot-messages");
    const expandButton = document.getElementById("chatbot-expand");
    let isExpanded = false;

    expandButton.addEventListener("click", () => {
        if (isExpanded) {
            chatbotWindow.style.width = "400px";
            chatbotWindow.style.height = "500px";
            expandButton.innerText = "🗖";
            isExpanded = false;
        } else {
            chatbotWindow.style.width = "700px";
            chatbotWindow.style.height = "600px";
            expandButton.innerText = "🗗"; 
            isExpanded = true;
        }
    });

    chatbotButton.addEventListener("click", () => {
        chatbotWindow.style.display =
            chatbotWindow.style.display === "none" ? "flex" : "none";
    });

    function sendMessage() {
        const text = userInput.value.trim();
        if (text) {
            appendMessage("Bạn", text);
            userInput.value = "";
            setTimeout(() => {
                appendMessage("Bot", "Đây là phản hồi mẫu.");
            }, 500);
        }
    }

    function appendMessage(sender, text) {
        const msg = document.createElement("div");
        msg.classList.add("chat-message");

        if (sender === "Bạn") {
            msg.classList.add("user");
        } else {
            msg.classList.add("bot");
        }

        msg.innerHTML = `
            <span class="sender">${sender}:</span>
            <span class="text">${text}</span>
        `;

        messages.appendChild(msg);
        messages.scrollTop = messages.scrollHeight;
    }

    userInput.addEventListener("keydown", function(event) {
        if (event.key === "Enter") {
            sendMessage();
        }
    });

    const chatbotClose = document.getElementById("chatbot-close");
    chatbotClose.addEventListener("click", () => {
        chatbotWindow.style.display = "none";
    });
</script>
