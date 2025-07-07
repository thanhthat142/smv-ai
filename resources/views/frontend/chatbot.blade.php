@extends('frontend.layout')

@section('content')
    <main>
    <div id="chatbot-window">
        <div id="chatbot-header">
            <img src="{{ asset('frontend/assets/favicon.png') }}" alt="Unitel" class="chatbot-logo">
            <div class="chatbot-title">
                <div class="chatbot-name">Trợ lý ảo Unitel</div>
                <div class="chatbot-status"><span class="status-dot"></span> Online</div>
            </div>
        </div>
        <div id="chatbot-messages"></div>
        <div id="chatbot-welcome">
            <p>🤖 Unitel rất vui được đồng hành cùng bạn!</p>
        </div>
        <div id="chatbot-loading" class="loading-indicator" style="display: none;">
            <div class="spinner"></div>
            Trợ lý ảo Unitel đang trả lời... 
        </div>
        <div id="chatbot-input">
            <input type="text" id="user-input" placeholder="Nhập tin nhắn..." />
            <button onclick="sendMessage()">Gửi</button>
        </div>
    </div>

    <style>
        #chatbot-window {
            position: fixed;
            top: 80px;
            left: 0;
            right: 0;
            bottom: 0;
            width: 100vw;
            height: calc(100vh - 80px);
            display: flex;
            flex-direction: column;
            background: #fff;
            z-index: 9999;
            border: none;
            border-radius: 0;
        }
        #chatbot-header {
            background-color: #f44336;
            color: white;
            padding: 10px 20px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        #chatbot-header img {
            width: 20px;
            height: 20px;
            object-fit: contain;
        }
        .chatbot-title {
            display: flex;
            flex-direction: column;
            line-height: 1.2;
        }
        .chatbot-status {
            font-size: 12px;
            font-weight: normal;
            display: flex;
            align-items: center;
            color: #c8e6c9;
        }
        .status-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background-color: #4caf50;
            margin-right: 5px;
        }
        #chatbot-messages {
            flex: 1;
            padding: 20px;
            overflow-y: auto;
            width: calc(1000px); 
            margin: 0 auto;
            min-height: 300px;
            background-color: #f9f9f9;
            border-radius: 10px;
            box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.03);
        }
        #chatbot-welcome {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: #555;
            font-size: 18px;
            text-align: center;
            opacity: 0.6;
            pointer-events: none;
        }
        #chatbot-input {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
            margin: 20px auto 30px auto;
            padding: 20px;
            max-width: 1000px;
            width: 100%;
            background-color: #fff5f5;
            border-radius: 12px;
            box-shadow: 0 1px 6px rgba(0, 0, 0, 0.05);
        }
        #chatbot-input input {
            flex: 1;
            border: 1px solid #fc6464;
            background-color: #fff0f0;
            padding: 20px 22px;
            border-radius: 10px;
            font-size: 15px;
            min-width: 0;
            color: #333;
        }
        #chatbot-input input::placeholder {
            color: #b67c7c;
        }
        #chatbot-input button {
            background: #f44336;
            color: white;
            border: none;
            padding: 20px 30px;
            font-size: 15px;
            border-radius: 10px;
            cursor: pointer;
            white-space: nowrap;
        }

        .chat-message {
            margin: 12px 0;
            padding: 10px 14px;
            border-radius: 15px;
            max-width: 80%;
            font-size: 15px;
            line-height: 1.5;
            word-break: break-word;
            clear: both;
            display: inline-block;
            position: relative;
        }

        .chat-message.bot {
            background-color: #f1f1f1;
            color: #000;
            align-self: flex-start;
            margin-left: 20px;
            border-top-left-radius: 0;
            float: left;
        }

        .chat-message.user {
            background-color: #f44336;
            color: #fff;
            align-self: flex-end;
            margin-right: 20px;
            border-top-right-radius: 0;
            float: right;
        }
        .loading-indicator {
            display: flex;
            text-align: center;
            font-style: italic;
            padding: 10px;
            color: #999;
            float: left;
        }

        .spinner {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid #ccc;
            border-top: 3px solid #f44336;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin-right: 8px;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>

    <script>
        const userInput = document.getElementById("user-input");
        const messages = document.getElementById("chatbot-messages");

        const N8N_WEBHOOK_URL = "https://408b-14-231-188-210.ngrok-free.app/webhook/qs";

        function sendMessage() {
            const text = userInput.value.trim();
            if (text) {
                document.getElementById("chatbot-welcome").style.display = "none";
                appendMessage("Bạn", text);
                userInput.value = "";

                document.getElementById("chatbot-loading").style.display = "block";

                fetch(N8N_WEBHOOK_URL, {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "ngrok-skip-browser-warning": "true"
                    },
                    body: JSON.stringify({ message: text }),
                })
                .then(async response => {
                    const contentType = response.headers.get("content-type");
                    const raw = await response.text();
                    document.getElementById("chatbot-loading").style.display = "none";

                    if (contentType && contentType.includes("application/json")) {
                        const data = JSON.parse(raw);
                        const reply = data[0]?.response || data[0]?.text || data[0]?.message || "Không có phản hồi từ máy chủ.";
                        appendMessage("Trợ lý ảo Unitel", reply);
                    } else {
                        appendMessage("Trợ lý ảo Unitel", "Phản hồi không đúng định dạng JSON.");
                    }
                })
                .catch(error => {
                    document.getElementById("chatbot-loading").style.display = "none";
                    console.error("🔥 Lỗi:", error.message);
                    appendMessage("Trợ lý ảo Unitel", "Đã xảy ra lỗi kết nối.");
                });
            }
        }

        function detectLang(text) {
            if (/[ກ-ໝ]/.test(text)) return "lo";  // ký tự Lào Unicode
            if (/[a-zA-Z]/.test(text) && /you|how|help|please/i.test(text)) return "en";
            return "vi";
        }


        function appendMessage(sender, response) {
            const text = typeof response === 'string' ? response : response.text || '';
            let lang = typeof response === 'object' ? response.lang : null;

            if (!lang || lang === "vi") {
                lang = detectLang(text);
            }

            const msg = document.createElement("div");

            // Check nếu có link đăng ký để xử lý riêng
            const hasLink = text.includes("http://127.0.0.1:8088/register-package");

            // Tách phần link ra khỏi nội dung chính
            const cleanText = text
                .replace("http://127.0.0.1:8088/register-package", "")
                .replace(/\[\]\(http:\/\/127\.0\.0\.1:8088\/register-package\)/g, "")
                .replace(/\[.*?\]\(http:\/\/127\.0\.0\.1:8088\/register-package\)/g, "")
                .trim();

            const formattedText = cleanText
                .replace(/ - /g, "<br>")
                .replace(/\n/g, "<br>")
                .replace(/\*\*(.*?)\*\*/g, "<strong>$1</strong>");

            msg.classList.add("chat-message");
            msg.classList.add(sender === "Bạn" ? "user" : "bot");
            msg.innerHTML = `<span class="text">${formattedText}</span>`;
            messages.appendChild(msg);

             const buttonLabels = {
                vi: "Đăng ký ngay",
                lo: "ລົງທະບຽນດ່ວນ",
                en: "Register now"
            };
            const label = buttonLabels[lang] || buttonLabels.vi;


            // Nếu có link, thêm nút riêng bên dưới
            if (hasLink) {
                const buttonWrapper = document.createElement("div");
                buttonWrapper.classList.add("chat-message", "bot");
                buttonWrapper.innerHTML = `
                    <button onclick="window.open('http://127.0.0.1:8088/contact', '_blank')" 
                        style="margin: 10px 0 5px 0; padding: 8px 16px; background-color: #f44336; color: white; border: none; border-radius: 4px; cursor: pointer;">
                        🔗 ${label}
                    </button>`;
                messages.appendChild(buttonWrapper);
            }

            messages.scrollTop = messages.scrollHeight;
        }

        userInput.addEventListener("keydown", function(event) {
            if (event.key === "Enter") {
                sendMessage();
            }
        });
    </script>
    </main>
@endsection