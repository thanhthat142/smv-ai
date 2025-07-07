@extends('frontend.layout')

@section('content')
    <main>
        <div id="chatbot-window">
            <div id="chatbot-header">
                <img src="{{ asset('frontend/assets/favicon.png') }}" alt="Unitel" class="chatbot-logo">
                <div class="chatbot-title">
                    <div class="chatbot-name">{{ trans('frontend.chatbot_name') }}</div>
                    <div class="chatbot-status"><span class="status-dot"></span> Online</div>
                </div>
            </div>
            <div id="chatbot-messages"></div>
            <div id="chatbot-welcome">
                <p>{{ trans('frontend.chatbot_induction') }}</p>
            </div>
            <div id="chatbot-loading" class="loading-indicator" style="display: none;">
                <div class="spinner"></div>
                {{ trans('frontend.chatbot_loading') }}
            </div>
            <div id="chatbot-input">
                <input type="text" id="user-input" placeholder="{{ trans('frontend.chatbot_placeholder') }}" />
                <button onclick="sendMessage()">{{ trans('frontend.chatbot_send') }}</button>
            </div>
        </div>

        <style>
            #chatbot-window {
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

            footer.footer {
                display: none !important;
            }

            @keyframes spin {
                0% { transform: rotate(0deg); }
                100% { transform: rotate(360deg); }
            }
        </style>

        <script>
            const userInput = document.getElementById("user-input");
            const messages = document.getElementById("chatbot-messages");
            const predefinedQuestions = [
                { question: "ສະບາຍດີ", answer: "ສະບາຍດີ, ທ່ານສາມາດບອກຄວາມຕ້ອງການຂອງທ່ານເພື່ອໃຫ້ພວກເຮົາຮູ້ໄດ້ບໍ່? ສູນບໍລິການລູກຄ້າ Unitel ຍິນດີຊ່ວຍເຫຼືອທ່ານ." },
                // Xin chào -> Xin chào, bạn có thể chia sẻ nhu cầu của mình để chúng tôi có thể hỗ trợ được không? Trung tâm chăm sóc khách hàng Unitel luôn đồng hành và sẵn sàng hỗ trợ bạn bất cứ lúc nào.
                { question: "ວິທີລົງທະບຽນ package", answer: "ທ່ານສາມາດລົງທະບຽນທີ່ນີ້. https://look.tnet.vn/register-package - ຖ້າທ່ານຕ້ອງການຄວາມຊ່ວຍເຫຼືອ ຫຼື ມີຄໍາຖາມອື່ນ, ພວກເຮົາພ້ອມໃຫ້ບໍລິການ." },
                // Cách đăng ký gói cước -> Bạn có thể đăng ký tại đây:  “🔗 Đăng ký” Nếu bạn cần thêm sự hỗ trợ hay có câu hỏi nào khác, mình luôn sẵn lòng giúp đỡ!
                { question: "ຂ້ອຍຢາກລົງທະບຽນ", answer: "ທ່ານສາມາດລົງທະບຽນທີ່ນີ້. https://look.tnet.vn/register-package - ຖ້າທ່ານຕ້ອງການຄວາມຊ່ວຍເຫຼືອ ຫຼື ມີຄໍາຖາມອື່ນ, ພວກເຮົາພ້ອມໃຫ້ບໍລິການ." },
                // Tôi muốn đăng ký -> Bạn có thể đăng ký tại đây:  “🔗 Đăng ký” Nếu bạn cần thêm sự hỗ trợ hay có câu hỏi nào khác, mình luôn sẵn lòng giúp đỡ!
                { question: "ເບີໂທລະສັບສູນກາງແມ່ນໝາຍເລກໃດ?", answer: "ເບີສູນກາງຊ່ວຍເຫຼືອຂອງ Unitel: 1098 ຫຼື 1221." },
                // Số tổng đài là gì? -> Tổng đài hỗ trợ Unitel: 1098 hoặc 1221.
                { question: "ສໍານັກງານໃຫຍ່ Unitel ຕັ້ງຢູ່ໃສ?", answer: "ສໍານັກງານໃຫຍ່: Star Telecom Co. Ltd - ສະຖານທີ່: ຖະໜົນໜອງບອນ, ບ້ານໂພນໄຊ, ເມືອງໄຊເສດຖາ, ນະຄອນຫຼວງວຽງຈັນ - ເບີໂທ: 021 990196" },
                //Địa chỉ trụ sở chính Unitel ở đâu -> Trụ sở chính: Star Telecom Co. Ltd - Địa chỉ: Nongbone Road, Phonxay Village, Saysettha District, Vientiane Capital, Laos - Số điện thoại: 021 990196
                { question: "ເບີໂທຕິດຕໍ່ຫາ ສູນບໍລິການລູກຄ້າ Unitel", answer: "Hotline: 109 - ເບີໂທສໍານັກງານ: 021 999 666 ຫຼື +856 21 999 666 (ໝາຍເຫດ: ລະຫັດປະເທດລາວແມ່ນ +856)" },
                //Số hotline là gì -> Hotline: 109 - Gọi từ điện thoại cố định: 021 999 666
                { question: "Package ຕິດຕັ້ງ Internet ໃນບ້ານລາຄາຕໍ່າສຸດແມ່ນເທົ່າໃດ?", answer: "Package Internet ລາຄາຕ່ໍາສຸດແມ່ນ package MAX35, ຄວາມໄວ 35Mbps, 1 MODEM, ລາຄາ 165,000 ກີບ/ເດືອນ. - Package Internet ລາຄາສູງສຸດແມ່ນ package MAX600, ຄວາມໄວ 600Mbps, 1 MODEM, ລາຄາ 4,000,000 ກີບ/ເດືອນ." },
                //Lắp mạng gói thấp nhất là bao nhiêu? -> Gói mạng thấp nhất là gói MAX35 với tốc độ 35Mbps, 1MODEM, giá 165,000KIP/Tháng.
                { question: "Package ຕິດຕັ້ງ Internet ໃນບ້ານລາຄາຕໍ່າສຸດແມ່ນເທົ່າໃດ?", answer: "Package Internet ລາຄາຕ່ໍາສຸດແມ່ນ package MAX35, ຄວາມໄວ 35Mbps, 1 MODEM, ລາຄາ 165,000 ກີບ/ເດືອນ. - Package Internet ລາຄາສູງສຸດແມ່ນ package MAX600, ຄວາມໄວ 600Mbps, 1 MODEM, ລາຄາ 4,000,000 ກີບ/ເດືອນ." },
                //Lắp mạng gói thấp nhất là bao nhiêu? -> Gói mạng thấp nhất là gói MAX35 với tốc độ 35Mbps, 1MODEM, giá 165,000KIP/Tháng.
                { question: "ສ່ວນ Package ລາຄາສູງສຸດແມ່ນເທົ່າໃດ", answer: "Package Internet ລາຄາສູງສຸດແມ່ນ package MAX600 ມີຄວາມໄວ 600Mbps, 1 MODEM, ລາຄາ 4,000,000 ກີບ/ເດືອນ." },
                //Lắp mạng gói cao nhất là bao nhiêu? ->  Gói mạng cao nhất là gói MAX600 với tốc độ 600Mbps, 1MODEM, giá 4,000,000KIP/Tháng.
                { question: "ວິທີຕິດຕໍ່ຫາສູນບໍລິການລູກຄ້າ", answer: "ລູກຄ້າສາມາດເຂົ້າມາທີ່ສໍານັກງານໃຫຍ່ Unitel ຫຼື ໂທເຂົ້າທີ່ເບີ hotline: 109 ຫຼື 021 999 666 ຫຼື +856 21 999 666 (ໝາຍເຫດ: ລະຫັດປະເທດລາວແມ່ນ +856)" },
                //Cách liên hệ với bộ phận hỗ trợ khách hàng -> Khách hàng có thể đến trụ sở chính gọi đến số ngắn tiện lợi: 109 - Gọi từ điện thoại cố định: 021 999 666
                { question: "ພາກສ່ວນບໍລິການລູກຄ້າ", answer: "ລູກຄ້າສາມາດເຂົ້າມາທີ່ສໍານັກງານໃຫຍ່ Unitel ຫຼື ໂທເຂົ້າທີ່ເບີ hotline: 109 ຫຼື 021 999 666 ຫຼື +856 21 999 666 (ໝາຍເຫດ: ລະຫັດປະເທດລາວແມ່ນ +856)" },
                //Bộ phận hỗ trợ khách hàng -> Khách hàng có thể đến trụ sở chính gọi đến số ngắn tiện lợi: 109 - Gọi từ điện thoại cố định: 021 999 666
                { question: "ບໍລິການທີ່ Unitel ກໍາລັງມີ", answer: "ພວກເຮົາມີຫຼາຍປະເພດການບໍລິການ, ລູກຄ້າສົນໃຈສອບຖາມກ່ຽວກັບ package ມືຖື, ຊື້ເບີ ຫຼື package Internet ?" },
                //Các dịch vụ Unitel hiện có -> Chúng tôi cung cấp nhiều loại dịch vụ, bạn đang muốn hỏi về gói cước di động, gói sim hay gói Internet
                { question: "ຂໍ້ມູນກ່ຽວກັບ package", answer: "ພວກເຮົາມີຫຼາຍປະເພດການບໍລິການ, ລູກຄ້າສົນໃຈສອບຖາມກ່ຽວກັບ package ມືຖື, ຊື້ເບີ ຫຼື package Internet ?" },
                //Thông tin về các gói -> Chúng tôi cung cấp nhiều loại dịch vụ, bạn đang muốn hỏi về gói cước di động, gói sim hay gói Internet?
                { question: "ຂໍ້ມູນ package ມືຖື 5G150", answer: "ນີ້ແມ່ນລາຍລະອຽດຂໍ້ມູນຂອງ package 5G150 ຂອງ Unitel: -  - ຊື່ແພັກເກດ: 5G150 - ລາຍລະອຽດ: 60GB/1ເດືອນ ໂທຟີຣພາຍໃນປະເທດ 150ນາທີ ບໍ່ຈຳກັດ Youtube + Facebook + LAOTV4K - ລາຄາ: 150,000 KIP/ເດືອນ -  - ຖ້າທ່ານສົນໃຈໃນບໍລິການ ຫຼື ມີຄໍາຖາມອື່ນຕື່ມ, ສາມາດສອບຖາມໄດ້ເດີ້" },
                //Thông tin gói cước di động 5G150 -> Đây là thông tin chi tiết gói 5G150 của Unitel: ...
                { question: "ຂໍ້ມູນ package Internet MAX35", answer: "ນີ້ແມ່ນລາຍລະອຽດຂໍ້ມູນຂອງ package MAX35 ຂອງ Unitel: -  - ຊື່ແພັກເກດ: MAX35 - ລາຍລະອຽດ: - ຈຳນວນ Modem: 1 ເຄື່ອງ, ຄວາມໄວ: 35Mbps - ຈ່າຍກ່ອນ 3 ເດືອນຟີຣ 1 ເດືອນ (ຟຣີ 100 ນາທີ ໂທພາຍໃນເຄືອຂ່າຍສຳລັບ 1 ເບີມືຖື, ຟຣີ 2 GB / 1 ເບີມືຖື / ເດືອນ, ຟຣີ 1 ເດືອນ ແພັກເກັດ) - ຈ່າຍກ່ອນ 6 ເດືອນຟີຣ 2 ເດືອນ (ຟຣີ 100 ນາທີ ໂທພາຍໃນເຄືອຂ່າຍສຳລັບ 1 ເບີມືຖື, ຟຣີ 3 GB / 1 ເບີມືຖື / ເດືອນ, ຟຣີ 2 ເດືອນ ແພັກເກັດ) - ຈ່າຍກ່ອນ 12 ເດືອນຟີຣ 4 ເດືອນ(ຟຣີ 100 ນາທີ ໂທພາຍໃນເຄືອຂ່າຍສຳລັບ 1 ເບີມືຖື, ຟຣີ 5GB / 1 ເບີ / ເດືອນ, ຟຣີ 4 ເດືອນ ແພັກເກັດ) - ລາຄາ: 165,000 KIP/ເດືອນ -  - ຖ້າທ່ານສົນໃຈໃນບໍລິການ ຫຼື ມີຄໍາຖາມອື່ນຕື່ມ, ສາມາດສອບຖາມໄດ້ເດີ້ " },
                //Thông tin gói cước Internet MAX35 -> Đây là thông tin chi tiết gói MAX35 của Unitel: ...
                { question: "ຂໍ້ມູນ package ມືຖື CN95", answer: "ນີ້ແມ່ນລາຍລະອຽດຂໍ້ມູນຂອງ package CN95 ຂອງ Unitel: -  - ຊື່ແພັກເກດ: CN95 - ລາຍລະອຽດ: 30GB/30ວັນ/95,000ກີບ/ບໍ່ຈຳກັດ Youtube+Wechat+Facebook+TikTok+Whatsapp - ລາຄາ: 95,000 KIP/ເດືອນ -  - ຖ້າທ່ານສົນໃຈໃນບໍລິການ ຫຼື ມີຄໍາຖາມອື່ນຕື່ມ, ສາມາດສອບຖາມໄດ້ເດີ້" },
                //Thông tin gói cước di động CN95 -> Đây là thông tin chi tiết gói CN95 của Unitel: ...
                { question: "ຂໍ້ມູນ package Internet MESH35", answer: "ນີ້ແມ່ນລາຍລະອຽດຂໍ້ມູນຂອງ package MESH35 ຂອງ Unitel: -  - ຊື່ແພັກເກດ: MESH35 - ຈຳນວນ Modem: 2 ເຄື່ອງ, ຄວາມໄວ: 35Mbps - ຈ່າຍກ່ອນ 3 ເດືອນຟີຣ 1 ເດືອນ (ຟຣີ 100 ນາທີ ໂທພາຍໃນເຄືອຂ່າຍສຳລັບ 1 ເບີມືຖື, ຟຣີ 2 GB / 1 ເບີມືຖື / ເດືອນ, ຟຣີ 1 ເດືອນ ແພັກເກັດ) - ຈ່າຍກ່ອນ 6 ເດືອນຟີຣ 2 ເດືອນ (ຟຣີ 100 ນາທີ ໂທພາຍໃນເຄືອຂ່າຍສຳລັບ 1 ເບີມືຖື, ຟຣີ 3 GB / 1 ເບີມືຖື / ເດືອນ, ຟຣີ 2 ເດືອນ ແພັກເກັດ) - ຈ່າຍກ່ອນ 12 ເດືອນຟີຣ 4 ເດືອນ(ຟຣີ 100 ນາທີ ໂທພາຍໃນເຄືອຂ່າຍສຳລັບ 1 ເບີມືຖື, ຟຣີ 5GB / 1 ເບີ / ເດືອນ, ຟຣີ 4 ເດືອນ ແພັກເກັດ) - ລາຄາ: 165,000 KIP/ເດືອນ -  - ຖ້າທ່ານສົນໃຈໃນບໍລິການ ຫຼື ມີຄໍາຖາມອື່ນຕື່ມ, ສາມາດສອບຖາມໄດ້ເດີ້" },
                //Thông tin gói cước Internet MESH35 -> Đây là thông tin chi tiết gói MESH35 của Unitel: ...

                //Gói di động
                { question: "ແພັກເກດມືຖື", answer: "ນີ້ແມ່ນລາຍລະອຽດຂອງ package ມືຖື ຂອງ Unitel: -  - 1. 5G150 - ລາຍລະອຽດ: 60GB/1ເດືອນ ໂທຟີຣພາຍໃນປະເທດ 150ນາທີ ບໍ່ຈຳກັດ Youtube+Facebook+ LAOTV4K - ລາຄາ: 150,000 KIP -  - 2. 5G200 - ລາຍລະອຽດ: 90GB/1ເດືອນ ໂທຟີຣພາຍໃນປະເທດ 200ນາທີ ບໍ່ຈຳກັດ Youtube+Facebook+Tiktok+ LAOTV4K - ລາຄາ: 200,000 KIP - " +
                        " - 3. 5G300 - ລາຍລະອຽດ: 140GB/1ເດືອນ ໂທຟີຣພາຍໃນປະເທດ 300ນາທີ ບໍ່ຈຳກັດ Youtube+Facebook+Tiktok+Whatsapp+ LAOTV4K - ລາຄາ: 300,000 KIP -  - 4. CN95 - ລາຍລະອຽດ: 30GB/30ວັນ/95,000ກີບ/ບໍ່ຈຳກັດ Youtube+Wechat+Facebook+TikTok+Whatsapp - ລາຄາ: 95,000 KIP -  - 5. 150K12M - ລາຍລະອຽດ: 70GB/ເດືອນ/12ເດືອນ/ຄ່າໂທ 300ກີບ/ນາທີ - ລາຄາ: 1,440,000 KIP -  - ທ່ານມີຄໍາຖາມກ່ຽວກັບ package ຕື່ມອີກບໍ່, ສາມາດສອບຖາມໄດ້ເດີ້ " },
                { question: "ແພັກເກດມືຖືມີຫຍັງແດ່?", answer: "ນີ້ແມ່ນລາຍລະອຽດຂອງ package ມືຖື ຂອງ Unitel: -  - 1. 5G150 - ລາຍລະອຽດ: 60GB/1ເດືອນ ໂທຟີຣພາຍໃນປະເທດ 150ນາທີ ບໍ່ຈຳກັດ Youtube+Facebook+ LAOTV4K - ລາຄາ: 150,000 KIP -  - 2. 5G200 - ລາຍລະອຽດ: 90GB/1ເດືອນ ໂທຟີຣພາຍໃນປະເທດ 200ນາທີ ບໍ່ຈຳກັດ Youtube+Facebook+Tiktok+ LAOTV4K - ລາຄາ: 200,000 KIP - " +
                        " - 3. 5G300 - ລາຍລະອຽດ: 140GB/1ເດືອນ ໂທຟີຣພາຍໃນປະເທດ 300ນາທີ ບໍ່ຈຳກັດ Youtube+Facebook+Tiktok+Whatsapp+ LAOTV4K - ລາຄາ: 300,000 KIP -  - 4. CN95 - ລາຍລະອຽດ: 30GB/30ວັນ/95,000ກີບ/ບໍ່ຈຳກັດ Youtube+Wechat+Facebook+TikTok+Whatsapp - ລາຄາ: 95,000 KIP -  - 5. 150K12M - ລາຍລະອຽດ: 70GB/ເດືອນ/12ເດືອນ/ຄ່າໂທ 300ກີບ/ນາທີ - ລາຄາ: 1,440,000 KIP -  - ທ່ານມີຄໍາຖາມກ່ຽວກັບ package ຕື່ມອີກບໍ່, ສາມາດສອບຖາມໄດ້ເດີ້ " },
                { question: "ແພັກເກດມືຖືມີລາຄາໃດແດ່", answer: "ນີ້ແມ່ນລາຍລະອຽດຂອງ package ມືຖື ຂອງ Unitel: -  - 1. 5G150 - ລາຍລະອຽດ: 60GB/1ເດືອນ ໂທຟີຣພາຍໃນປະເທດ 150ນາທີ ບໍ່ຈຳກັດ Youtube+Facebook+ LAOTV4K - ລາຄາ: 150,000 KIP -  - 2. 5G200 - ລາຍລະອຽດ: 90GB/1ເດືອນ ໂທຟີຣພາຍໃນປະເທດ 200ນາທີ ບໍ່ຈຳກັດ Youtube+Facebook+Tiktok+ LAOTV4K - ລາຄາ: 200,000 KIP - " +
                        " - 3. 5G300 - ລາຍລະອຽດ: 140GB/1ເດືອນ ໂທຟີຣພາຍໃນປະເທດ 300ນາທີ ບໍ່ຈຳກັດ Youtube+Facebook+Tiktok+Whatsapp+ LAOTV4K - ລາຄາ: 300,000 KIP -  - 4. CN95 - ລາຍລະອຽດ: 30GB/30ວັນ/95,000ກີບ/ບໍ່ຈຳກັດ Youtube+Wechat+Facebook+TikTok+Whatsapp - ລາຄາ: 95,000 KIP -  - 5. 150K12M - ລາຍລະອຽດ: 70GB/ເດືອນ/12ເດືອນ/ຄ່າໂທ 300ກີບ/ນາທີ - ລາຄາ: 1,440,000 KIP -  - ທ່ານມີຄໍາຖາມກ່ຽວກັບ package ຕື່ມອີກບໍ່, ສາມາດສອບຖາມໄດ້ເດີ້ " },
                { question: "ແພັກເກດມືຖືລາຄາຕໍ່າສຸດເທົ່າໃດ", answer: "Package ມືຖື ລາຄາຕໍ່າສຸດ ແມ່ນ package 50K - ລາຍລະອຽດ: 15GB ຄ່າໂທ 300ກີບ/ນາທີ/30ວັນ/50,000ກີບ - ລາຄາ: 50,000 KIP -  - Package ມືຖື ລາຄາສູງສຸດ ແມ່ນ package 1150K12M - ລາຍລະອຽດ: 70GB/ເດືອນ/12ເດືອນ/ຄ່າໂທ 300ກີບ/ນາທ - ລາຄາ: 1,440,000 KIP "},
                //Còn gói di động khác nữa không
                { question: "ມີ package ມືຖື ອື່ນອີກບໍ່ ?", answer: "ຂ້າງລຸ່ມນີ້ແມ່ນຂໍ້ມູນເພີ່ມເຕີມກ່ຽວກັບແພັກເກດ ອື່ນໆ ຂອງ Unitel: -  - 1. 25K - ລາຍລະອຽດ: 8GB ຄ່າໂທ 300ກີບ/ນາທີ/10ວັນ/25,000ກີບ - ລາຄາ: 25,000 KIP -  - 2. 40K - ລາຍລະອຽດ: 15GBຄ່າໂທ 300ກີບ/ນາທີ/15ວັນ/40,000ກີບ - ລາຄາ: 40,000 KIP - " +
                        " - 3. 50K - ລາຍລະອຽດ: 15GB ຄ່າໂທ 300ກີບ/ນາທີ/30ວັນ/50,000ກີບ - ລາຄາ: 50,000 KIP -  - 4. 60K - ລາຍລະອຽດ: 20GB ຄ່າໂທ 300ກີບ/ນາທີ/30ວັນ/60,000ກີບ - ລາຄາ: 60,000 KIP -  - 5. 75K - ລາຍລະອຽດ: 30GB ຄ່າໂທ 300ກີບ/ນາທີ/30ວັນ/75,000ກີບ - ລາຄາ: 75,000 KIP -  - ທ່ານມີຄໍາຖາມກ່ຽວກັບ package ຕື່ມອີກບໍ່, ສາມາດສອບຖາມໄດ້ເດີ້ "},

                //Gói Sim
                { question: "ຊື້ເບີ", answer: "ຂ້າງລຸ່ມນີ້ແມ່ນຂໍ້ມູນກ່ຽວກັບແພັກເກດ Unitel SIM: -  - 1. 209 549 2115 - ແພັກເກັດເບີເຕີມເງິນ, ແພັກເກັດເບີລາຍເດືອນ, ແພັກເກັດເບີເນັດ 020 - ລາຄາ: 60,000 ກີບ -  - 2. 209 552 0487 - ແພັກເກັດເບີເຕີມເງິນ, ແພັກເກັດເບີລາຍເດືອນ, ແພັກເກັດເບີເນັດ 020 - ລາຄາ: 60,000 ກີບ -  - 3. 209 552 0254 - ແພັກເກັດເບີເຕີມເງິນ, ແພັກເກັດເບີລາຍເດືອນ, ແພັກເກັດເບີເນັດ 020 - ລາຄາ: 60,000 ກີບ - " +
                        " - 4. 209 547 2177 - ແພັກເກັດເບີເຕີມເງິນ, ແພັກເກັດເບີລາຍເດືອນ, ແພັກເກັດເບີເນັດ 020 - ລາຄາ: 60,000 KIP -  - 5. 209 550 0432 - ແພັກເກັດເບີເຕີມເງິນ, ແພັກເກັດເບີລາຍເດືອນ, ແພັກເກັດເບີເນັດ 020 - ລາຄາ: 60,000 KIP -  - ທ່ານມີຄໍາຖາມກ່ຽວກັບ package ຕື່ມອີກບໍ່, ສາມາດສອບຖາມໄດ້ເດີ້" },
                { question: "ຊື້ເບີໂທ", answer: "ຂ້າງລຸ່ມນີ້ແມ່ນຂໍ້ມູນກ່ຽວກັບແພັກເກດ Unitel SIM: -  - 1. 209 549 2115 - ແພັກເກັດເບີເຕີມເງິນ, ແພັກເກັດເບີລາຍເດືອນ, ແພັກເກັດເບີເນັດ 020 - ລາຄາ: 60,000 ກີບ -  - 2. 209 552 0487 - ແພັກເກັດເບີເຕີມເງິນ, ແພັກເກັດເບີລາຍເດືອນ, ແພັກເກັດເບີເນັດ 020 - ລາຄາ: 60,000 ກີບ -  - 3. 209 552 0254 - ແພັກເກັດເບີເຕີມເງິນ, ແພັກເກັດເບີລາຍເດືອນ, ແພັກເກັດເບີເນັດ 020 - ລາຄາ: 60,000 ກີບ - " +
                        " - 4. 209 547 2177 - ແພັກເກັດເບີເຕີມເງິນ, ແພັກເກັດເບີລາຍເດືອນ, ແພັກເກັດເບີເນັດ 020 - ລາຄາ: 60,000 KIP -  - 5. 209 550 0432 - ແພັກເກັດເບີເຕີມເງິນ, ແພັກເກັດເບີລາຍເດືອນ, ແພັກເກັດເບີເນັດ 020 - ລາຄາ: 60,000 KIP -  - ທ່ານມີຄໍາຖາມກ່ຽວກັບ package ຕື່ມອີກບໍ່, ສາມາດສອບຖາມໄດ້ເດີ້" },
                { question: "ຊື້ເບີມືຖື", answer: "ຂ້າງລຸ່ມນີ້ແມ່ນຂໍ້ມູນກ່ຽວກັບແພັກເກດ Unitel SIM: -  - 1. 209 549 2115 - ແພັກເກັດເບີເຕີມເງິນ, ແພັກເກັດເບີລາຍເດືອນ, ແພັກເກັດເບີເນັດ 020 - ລາຄາ: 60,000 ກີບ -  - 2. 209 552 0487 - ແພັກເກັດເບີເຕີມເງິນ, ແພັກເກັດເບີລາຍເດືອນ, ແພັກເກັດເບີເນັດ 020 - ລາຄາ: 60,000 ກີບ -  - 3. 209 552 0254 - ແພັກເກັດເບີເຕີມເງິນ, ແພັກເກັດເບີລາຍເດືອນ, ແພັກເກັດເບີເນັດ 020 - ລາຄາ: 60,000 ກີບ - " +
                        " - 4. 209 547 2177 - ແພັກເກັດເບີເຕີມເງິນ, ແພັກເກັດເບີລາຍເດືອນ, ແພັກເກັດເບີເນັດ 020 - ລາຄາ: 60,000 KIP -  - 5. 209 550 0432 - ແພັກເກັດເບີເຕີມເງິນ, ແພັກເກັດເບີລາຍເດືອນ, ແພັກເກັດເບີເນັດ 020 - ລາຄາ: 60,000 KIP -  - ທ່ານມີຄໍາຖາມກ່ຽວກັບ package ຕື່ມອີກບໍ່, ສາມາດສອບຖາມໄດ້ເດີ້" },
                { question: "ຊື້ເບີໂທລະສັບ", answer: "ຂ້າງລຸ່ມນີ້ແມ່ນຂໍ້ມູນກ່ຽວກັບແພັກເກດ Unitel SIM: -  - 1. 209 549 2115 - ແພັກເກັດເບີເຕີມເງິນ, ແພັກເກັດເບີລາຍເດືອນ, ແພັກເກັດເບີເນັດ 020 - ລາຄາ: 60,000 ກີບ -  - 2. 209 552 0487 - ແພັກເກັດເບີເຕີມເງິນ, ແພັກເກັດເບີລາຍເດືອນ, ແພັກເກັດເບີເນັດ 020 - ລາຄາ: 60,000 ກີບ -  - 3. 209 552 0254 - ແພັກເກັດເບີເຕີມເງິນ, ແພັກເກັດເບີລາຍເດືອນ, ແພັກເກັດເບີເນັດ 020 - ລາຄາ: 60,000 ກີບ - " +
                        " - 4. 209 547 2177 - ແພັກເກັດເບີເຕີມເງິນ, ແພັກເກັດເບີລາຍເດືອນ, ແພັກເກັດເບີເນັດ 020 - ລາຄາ: 60,000 KIP -  - 5. 209 550 0432 - ແພັກເກັດເບີເຕີມເງິນ, ແພັກເກັດເບີລາຍເດືອນ, ແພັກເກັດເບີເນັດ 020 - ລາຄາ: 60,000 KIP -  - ທ່ານມີຄໍາຖາມກ່ຽວກັບ package ຕື່ມອີກບໍ່, ສາມາດສອບຖາມໄດ້ເດີ້" },
                { question: "ຊື້ຊິມ", answer: "ຂ້າງລຸ່ມນີ້ແມ່ນຂໍ້ມູນກ່ຽວກັບແພັກເກດ Unitel SIM: -  - 1. 209 549 2115 - ແພັກເກັດເບີເຕີມເງິນ, ແພັກເກັດເບີລາຍເດືອນ, ແພັກເກັດເບີເນັດ 020 - ລາຄາ: 60,000 ກີບ -  - 2. 209 552 0487 - ແພັກເກັດເບີເຕີມເງິນ, ແພັກເກັດເບີລາຍເດືອນ, ແພັກເກັດເບີເນັດ 020 - ລາຄາ: 60,000 ກີບ -  - 3. 209 552 0254 - ແພັກເກັດເບີເຕີມເງິນ, ແພັກເກັດເບີລາຍເດືອນ, ແພັກເກັດເບີເນັດ 020 - ລາຄາ: 60,000 ກີບ - " +
                        " - 4. 209 547 2177 - ແພັກເກັດເບີເຕີມເງິນ, ແພັກເກັດເບີລາຍເດືອນ, ແພັກເກັດເບີເນັດ 020 - ລາຄາ: 60,000 KIP -  - 5. 209 550 0432 - ແພັກເກັດເບີເຕີມເງິນ, ແພັກເກັດເບີລາຍເດືອນ, ແພັກເກັດເບີເນັດ 020 - ລາຄາ: 60,000 KIP -  - ທ່ານມີຄໍາຖາມກ່ຽວກັບ package ຕື່ມອີກບໍ່, ສາມາດສອບຖາມໄດ້ເດີ້" },
                { question: "ຊື້ຊິມໂທລະສັບ", answer: "ຂ້າງລຸ່ມນີ້ແມ່ນຂໍ້ມູນກ່ຽວກັບແພັກເກດ Unitel SIM: -  - 1. 209 549 2115 - ແພັກເກັດເບີເຕີມເງິນ, ແພັກເກັດເບີລາຍເດືອນ, ແພັກເກັດເບີເນັດ 020 - ລາຄາ: 60,000 ກີບ -  - 2. 209 552 0487 - ແພັກເກັດເບີເຕີມເງິນ, ແພັກເກັດເບີລາຍເດືອນ, ແພັກເກັດເບີເນັດ 020 - ລາຄາ: 60,000 ກີບ -  - 3. 209 552 0254 - ແພັກເກັດເບີເຕີມເງິນ, ແພັກເກັດເບີລາຍເດືອນ, ແພັກເກັດເບີເນັດ 020 - ລາຄາ: 60,000 ກີບ - " +
                        " - 4. 209 547 2177 - ແພັກເກັດເບີເຕີມເງິນ, ແພັກເກັດເບີລາຍເດືອນ, ແພັກເກັດເບີເນັດ 020 - ລາຄາ: 60,000 KIP -  - 5. 209 550 0432 - ແພັກເກັດເບີເຕີມເງິນ, ແພັກເກັດເບີລາຍເດືອນ, ແພັກເກັດເບີເນັດ 020 - ລາຄາ: 60,000 KIP -  - ທ່ານມີຄໍາຖາມກ່ຽວກັບ package ຕື່ມອີກບໍ່, ສາມາດສອບຖາມໄດ້ເດີ້" },
                //Còn gói Sim khác nữa không
                { question: "ມີ package ຊື້ເບີ ອື່ນອີກບໍ່ ?", answer: "ຂ້າງລຸ່ມນີ້ແມ່ນຂໍ້ມູນເພີ່ມເຕີມກ່ຽວກັບແພັກເກດ Unitel SIM: -  - 1. 209 550 1243 - ແພັກເກັດເບີເຕີມເງິນ, ແພັກເກັດເບີລາຍເດືອນ, ແພັກເກັດເບີເນັດ 020 - ລາຄາ: 60,000 ກີບ -  - 2. 209 547 8132 - ແພັກເກັດເບີເຕີມເງິນ, ແພັກເກັດເບີລາຍເດືອນ, ແພັກເກັດເບີເນັດ 020 - ລາຄາ: 60,000 ກີບ -  - 3. 209 562 8371 - ແພັກເກັດເບີເຕີມເງິນ, ແພັກເກັດເບີລາຍເດືອນ, ແພັກເກັດເບີເນັດ 020 - ລາຄາ: 60,000 ກີບ - " +
                        " - 4. 209 566 4271  - ແພັກເກັດເບີເຕີມເງິນ, ແພັກເກັດເບີລາຍເດືອນ, ແພັກເກັດເບີເນັດ 020 - ລາຄາ: 60,000 KIP -  - 5. 209 571 0326 - ແພັກເກັດເບີເຕີມເງິນ, ແພັກເກັດເບີລາຍເດືອນ, ແພັກເກັດເບີເນັດ 020 - ລາຄາ: 60,000 KIP -  - ທ່ານມີຄໍາຖາມກ່ຽວກັບ package ຕື່ມອີກບໍ່, ສາມາດສອບຖາມໄດ້ເດີ້" },

                //Gói Internet
                { question: "Package Internet", answer: "ນີ້ແມ່ນລາຍລະອຽດຂອງ package ອິນເຕີເນັດຂອງ Unitel: -  - 1. ຊື່ແພັກເກດ: MESH35 - ລາຍລະອຽດ: - ຈຳນວນ Modem: 2 ເຄື່ອງ, ຄວາມໄວ: 35 Mbps - ຈ່າຍກ່ອນ 3 ເດືອນຟີຣ 1 ເດືອນ (ຟຣີ 100 ນາທີ ໂທພາຍໃນເຄືອຂ່າຍ, ຟຣີ 2 GB) - ລາຄາ: 200,000 KIP/ເດືອນ -  - 2. ຊື່ແພັກເກດ: MESH50 - ລາຍລະອຽດ: - ຈຳນວນ Modem: 2 ເຄື່ອງ, ຄວາມໄວ: 50 Mbps - ຈ່າຍກ່ອນ 3 ເດືອນຟີຣ 1 ເດືອນ (ຟຣີ 100 ນາທີ ໂທພາຍໃນເຄືອຂ່າຍ, ຟຣີ 2 GB) - ລາຄາ: 250,000 KIP/ເດືອນ -  - 3. ຊື່ແພັກເກດ: MESH70 - ລາຍລະອຽດ: - ຈຳນວນ Modem: 2 ເຄື່ອງ, ຄວາມໄວ: 70 Mbps - ຈ່າຍກ່ອນ 3 ເດືອນຟີຣ 1 ເດືອນ (ຟຣີ 100 ນາທີ ໂທພາຍໃນເຄືອຂ່າຍ, ຟຣີ 2 GB) - ລາຄາ: 300,000 KIP/ເດືອນ" +
                        " -  - 4. ຊື່ແພັກເກດ: MESH100 - ລາຍລະອຽດ: - ຈຳນວນ Modem: 2 ເຄື່ອງ, ຄວາມໄວ: 100 Mbps - ຈ່າຍກ່ອນ 3 ເດືອນຟີຣ 1 ເດືອນ (ຟຣີ 100 ນາທີ) - ລາຄາ: 600,000 KIP/ເດືອນ -  - 5. ຊື່ແພັກເກດ: MAX35 - ລາຍລະອຽດ: - ຈຳນວນ Modem: 1 ເຄື່ອງ, ຄວາມໄວ: 35 Mbps - ລາຄາ: 165,000 KIP/ເດືອນ -  - ທ່ານມີຄໍາຖາມກ່ຽວກັບ package ຕື່ມອີກບໍ່, ສາມາດສອບຖາມໄດ້ເດີ້" },
                { question: "ຕິດຕັ້ງ Internet ບ້ານລາຄາເທົ່າໃດ?", answer: "ນີ້ແມ່ນລາຍລະອຽດຂອງ package ອິນເຕີເນັດຂອງ Unitel: -  - 1. ຊື່ແພັກເກດ: MESH35 - ລາຍລະອຽດ: - ຈຳນວນ Modem: 2 ເຄື່ອງ, ຄວາມໄວ: 35 Mbps - ຈ່າຍກ່ອນ 3 ເດືອນຟີຣ 1 ເດືອນ (ຟຣີ 100 ນາທີ ໂທພາຍໃນເຄືອຂ່າຍ, ຟຣີ 2 GB) - ລາຄາ: 200,000 KIP/ເດືອນ -  - 2. ຊື່ແພັກເກດ: MESH50 - ລາຍລະອຽດ: - ຈຳນວນ Modem: 2 ເຄື່ອງ, ຄວາມໄວ: 50 Mbps - ຈ່າຍກ່ອນ 3 ເດືອນຟີຣ 1 ເດືອນ (ຟຣີ 100 ນາທີ ໂທພາຍໃນເຄືອຂ່າຍ, ຟຣີ 2 GB) - ລາຄາ: 250,000 KIP/ເດືອນ -  - 3. ຊື່ແພັກເກດ: MESH70 - ລາຍລະອຽດ: - ຈຳນວນ Modem: 2 ເຄື່ອງ, ຄວາມໄວ: 70 Mbps - ຈ່າຍກ່ອນ 3 ເດືອນຟີຣ 1 ເດືອນ (ຟຣີ 100 ນາທີ ໂທພາຍໃນເຄືອຂ່າຍ, ຟຣີ 2 GB) - ລາຄາ: 300,000 KIP/ເດືອນ" +
                        " -  - 4. ຊື່ແພັກເກດ: MESH100 - ລາຍລະອຽດ: - ຈຳນວນ Modem: 2 ເຄື່ອງ, ຄວາມໄວ: 100 Mbps - ຈ່າຍກ່ອນ 3 ເດືອນຟີຣ 1 ເດືອນ (ຟຣີ 100 ນາທີ) - ລາຄາ: 600,000 KIP/ເດືອນ -  - 5. ຊື່ແພັກເກດ: MAX35 - ລາຍລະອຽດ: - ຈຳນວນ Modem: 1 ເຄື່ອງ, ຄວາມໄວ: 35 Mbps - ລາຄາ: 165,000 KIP/ເດືອນ -  - ທ່ານມີຄໍາຖາມກ່ຽວກັບ package ຕື່ມອີກບໍ່, ສາມາດສອບຖາມໄດ້ເດີ້" },
                { question: "ລາຄາຕິດຕັ້ງ Internet ບ້ານ", answer: "ນີ້ແມ່ນລາຍລະອຽດຂອງ package ອິນເຕີເນັດຂອງ Unitel: -  - 1. ຊື່ແພັກເກດ: MESH35 - ລາຍລະອຽດ: - ຈຳນວນ Modem: 2 ເຄື່ອງ, ຄວາມໄວ: 35 Mbps - ຈ່າຍກ່ອນ 3 ເດືອນຟີຣ 1 ເດືອນ (ຟຣີ 100 ນາທີ ໂທພາຍໃນເຄືອຂ່າຍ, ຟຣີ 2 GB) - ລາຄາ: 200,000 KIP/ເດືອນ -  - 2. ຊື່ແພັກເກດ: MESH50 - ລາຍລະອຽດ: - ຈຳນວນ Modem: 2 ເຄື່ອງ, ຄວາມໄວ: 50 Mbps - ຈ່າຍກ່ອນ 3 ເດືອນຟີຣ 1 ເດືອນ (ຟຣີ 100 ນາທີ ໂທພາຍໃນເຄືອຂ່າຍ, ຟຣີ 2 GB) - ລາຄາ: 250,000 KIP/ເດືອນ -  - 3. ຊື່ແພັກເກດ: MESH70 - ລາຍລະອຽດ: - ຈຳນວນ Modem: 2 ເຄື່ອງ, ຄວາມໄວ: 70 Mbps - ຈ່າຍກ່ອນ 3 ເດືອນຟີຣ 1 ເດືອນ (ຟຣີ 100 ນາທີ ໂທພາຍໃນເຄືອຂ່າຍ, ຟຣີ 2 GB) - ລາຄາ: 300,000 KIP/ເດືອນ" +
                        " -  - 4. ຊື່ແພັກເກດ: MESH100 - ລາຍລະອຽດ: - ຈຳນວນ Modem: 2 ເຄື່ອງ, ຄວາມໄວ: 100 Mbps - ຈ່າຍກ່ອນ 3 ເດືອນຟີຣ 1 ເດືອນ (ຟຣີ 100 ນາທີ) - ລາຄາ: 600,000 KIP/ເດືອນ -  - 5. ຊື່ແພັກເກດ: MAX35 - ລາຍລະອຽດ: - ຈຳນວນ Modem: 1 ເຄື່ອງ, ຄວາມໄວ: 35 Mbps - ລາຄາ: 165,000 KIP/ເດືອນ -  - ທ່ານມີຄໍາຖາມກ່ຽວກັບ package ຕື່ມອີກບໍ່, ສາມາດສອບຖາມໄດ້ເດີ້" },
                //Còn gói Internet khác nữa không
                { question: "ມີ package Internet ອື່ນອີກບໍ່ ?", answer: "ນີ້ແມ່ນລາຍລະອຽດຂອງ package ອິນເຕີເນັດຂອງ Unitel: -  - 1. ຊື່ແພັກເກດ: MAX50 - ລາຍລະອຽດ: - -ຈຳນວນ Modem: 1 ເຄື່ອງ, ຄວາມໄວ: 50Mbps - ຈ່າຍກ່ອນ 3 ເດືອນຟີຣ 1 ເດືອນ (ຟຣີ 100 ນາທີ ໂທພາຍໃນເຄືອຂ່າຍ, ຟຣີ 2 GB) - ລາຄາ: 200,000 KIP/ເດືອນ -  - 2. ຊື່ແພັກເກດ: MAX70 - ລາຍລະອຽດ: - ຈຳນວນ Modem: 1 ເຄື່ອງ, ຄວາມໄວ: 70 Mbps - ຈ່າຍກ່ອນ 3 ເດືອນຟີຣ 1 ເດືອນ (ຟຣີ 100 ນາທີ ໂທພາຍໃນເຄືອຂ່າຍ, ຟຣີ 2 GB) - ລາຄາ: 300,000 KIP/ເດືອນ -  - 3. ຊື່ແພັກເກດ: MAX100 - ລາຍລະອຽດ: - ຈຳນວນ Modem: 1 ເຄື່ອງ, ຄວາມໄວ: 100 Mbps - ຈ່າຍກ່ອນ 3 ເດືອນຟີຣ 1 ເດືອນ (ຟຣີ 100 ນາທີ ໂທພາຍໃນເຄືອຂ່າຍ, ຟຣີ 2 GB) - ລາຄາ: 500,000 KIP/ເດືອນ" +
                        " -  - 4. ຊື່ແພັກເກດ: MAX150 - ລາຍລະອຽດ: - ຈຳນວນ Modem: 1 ເຄື່ອງ, ຄວາມໄວ: 150 Mbps - ຈ່າຍກ່ອນ 3 ເດືອນຟີຣ 1 ເດືອນ (ຟຣີ 100 ນາທີ) - ລາຄາ: 1,000,000 KIP/ເດືອນ -  - 5. ຊື່ແພັກເກດ: MAX300 - ລາຍລະອຽດ: - ຈຳນວນ Modem: 1 ເຄື່ອງ, ຄວາມໄວ: 300 Mbps - ລາຄາ: 2,000,000 KIP/ເດືອນ -  - ທ່ານມີຄໍາຖາມກ່ຽວກັບ package ຕື່ມອີກບໍ່, ສາມາດສອບຖາມໄດ້ເດີ້" },

                //Cảm ơn -> Cảm ơn bạn đã liên hệ, nếu cần thêm thông tin, Unitel hân hạnh phục vụ khách hàng.
                { question: "ຂອບໃຈເດີ້", answer: "ຂອບໃຈລູກຄ້າທີ່ຕິດຕໍ່ສອບຖາມ, ຖ້າຕ້ອງການສອບຖາມຂໍ້ມູນເພີ່ມເຕີມ Unitel ຍິນດີຊ່ວຍເຫຼືອ. -  ສໍານັກງານໃຫຍ່: Star Telecom Co. Ltd ສະຖານທີ່: ຖະໜົນໜອງບອນ, ບ້ານໂພນໄຊ, ເມືອງໄຊເສດຖາ, ນະຄອນຫຼວງວຽງຈັນ ເບີໂທ: 021 990196, 021 999 666, Hotline: 109 " },
                { question: "ຂອບໃຈ", answer: "ຂອບໃຈລູກຄ້າທີ່ຕິດຕໍ່ສອບຖາມ, ຖ້າຕ້ອງການສອບຖາມຂໍ້ມູນເພີ່ມເຕີມ Unitel ຍິນດີຊ່ວຍເຫຼືອ. -  ສໍານັກງານໃຫຍ່: Star Telecom Co. Ltd ສະຖານທີ່: ຖະໜົນໜອງບອນ, ບ້ານໂພນໄຊ, ເມືອງໄຊເສດຖາ, ນະຄອນຫຼວງວຽງຈັນ ເບີໂທ: 021 990196, 021 999 666, Hotline: 109 " },
            ];

            function getSimilarity(a, b) {
                const longer = a.length > b.length ? a : b;
                const shorter = a.length > b.length ? b : a;
                const longerLength = longer.length;
                if (longerLength === 0) return 1.0;
                const distance = levenshtein(longer, shorter);
                return (longerLength - distance) / longerLength;
            }

            function levenshtein(a, b) {
                const matrix = [];
                for (let i = 0; i <= b.length; i++) {
                    matrix[i] = [i];
                }
                for (let j = 0; j <= a.length; j++) {
                    matrix[0][j] = j;
                }
                for (let i = 1; i <= b.length; i++) {
                    for (let j = 1; j <= a.length; j++) {
                        if (b.charAt(i - 1) === a.charAt(j - 1)) {
                            matrix[i][j] = matrix[i - 1][j - 1];
                        } else {
                            matrix[i][j] = Math.min(
                                matrix[i - 1][j - 1] + 1, // thay
                                matrix[i][j - 1] + 1,     // thêm
                                matrix[i - 1][j] + 1      // xóa
                            );
                        }
                    }
                }
                return matrix[b.length][a.length];
            }

            const N8N_WEBHOOK_URL = "https://408b-14-231-188-210.ngrok-free.app/webhook/get";

            function sendMessage() {
                const text = userInput.value.trim();
                if (text) {
                    document.getElementById("chatbot-welcome").style.display = "none";
                    appendMessage("Bạn", text);
                    userInput.value = "";

                    const threshold = 0.9; // Ngưỡng giống nhau: 90%
                    let matched = null;

                    for (const qa of predefinedQuestions) {
                        const similarity = getSimilarity(text, qa.question);
                        if (similarity >= threshold) {
                            matched = qa;
                            break;
                        }
                    }

                    if (matched) {
                        document.getElementById("chatbot-loading").style.display = "block";

                        setTimeout(() => {
                            document.getElementById("chatbot-loading").style.display = "none";
                            appendMessage("Trợ lý ảo Unitel", matched.answer);
                        }, 2500);
                        return;
                    }

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
                const hasLink = text.includes("https://look.tnet.vn/register-package");

                // Tách phần link ra khỏi nội dung chính
                const cleanText = text
                    .replace("https://look.tnet.vn/register-package", "")
                    .replace(/\[\]\(https:\/\/look\.tnet\.vn\/register-package\)/g, "")
                    .replace(/\[.*?\]\(https:\/\/look\.tnet\.vn\/register-package\)/g, "")
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
                    lo: "ລົງທະບຽນ",
                    en: "Register now"
                };
                const label = buttonLabels[lang] || buttonLabels.vi;


                // Nếu có link, thêm nút riêng bên dưới
                if (hasLink) {
                    const buttonWrapper = document.createElement("div");
                    buttonWrapper.classList.add("chat-message", "bot");
                    buttonWrapper.innerHTML = `
                    <button onclick="window.open('https://look.tnet.vn/register-package', '_blank')"
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


