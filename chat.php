<style>


.chat-container {
    max-width: 800px;
    margin: 50px auto;
    background: #fff;
    border-radius: 5px;
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
}
.chat-header {
    padding: 10px;
    background: #007bff;
    color: #fff;
    border-top-left-radius: 5px;
    border-top-right-radius: 5px;
    text-align: center;
}
.chat-box {
    padding: 10px;
    height: 400px;
    overflow-y: scroll;
    border-bottom: 1px solid #ddd;
}
.chat-message {
    margin-bottom: 15px;
    padding: 10px;
    border-radius: 5px;
    background: #e9ecef;
    display: inline-block;
    max-width: 80%;
    clear: both;
}
.chat-message.customer {
    background: #cce5ff;
    float: left;
}
.chat-message.admin {
    background: #d4edda;
    float: right;
}
.chat-message .timestamp {
    display: block;
    font-size: 0.8em;
    color: #888;
    margin-top: 5px;
}
.chat-input {
    display: flex;
    padding: 10px;
    background: #f1f1f1;
    border-bottom-left-radius: 5px;
    border-bottom-right-radius: 5px;
    align-items: center;
}
.chat-input input {
    flex: 1;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 5px;
    margin-left: 10px;
}
.chat-input button {
    padding: 10px 20px;
    border: none;
    background: #007bff;
    color: #fff;
    border-radius: 5px;
    cursor: pointer;
}
.emoji-picker {
    position: absolute;
    bottom: 60px;
    left: 10px;
    background-color: #fff;
    border: 1px solid #ddd;
    padding: 10px;
    border-radius: 5px;
    display: none;
    z-index: 1000;
}
.emoji-picker button {
    border: none;
    background-color: transparent;
    font-size: 20px;
    cursor: pointer;
}
</style>
</head>
<body>
<div class="chat-container">
<div class="chat-header">
    <br>
    <h2>Chat Bengkel Bowo Motor</h2>
</div>
<div class="chat-box" id="chat-box">
    <!-- Chat messages will be displayed here -->
</div>
<div class="chat-input">
    <button id="emoji-button">😀</button>
    <input type="text" id="chat-input" placeholder="Tulis pesan kamu di sini...">
    <button id="send-button">kirim</button>
</div>
<div id="emoji-picker" class="emoji-picker">
    <!-- Emojis will be loaded here -->
</div>
</div>

<script>
let isAdmin = false; // Toggle between customer and admin
let chatHistory = ''; // Variable to store chat history

// Function to send a message
function sendMessage() {
    var input = document.getElementById('chat-input');
    var message = input.value.trim();

    if (message !== '') {
        var chatBox = document.getElementById('chat-box');
        var newMessage = document.createElement('div');
        newMessage.classList.add('chat-message');
        newMessage.classList.add(isAdmin ? 'admin' : 'customer');

        var role = isAdmin ? 'Admin' : 'Customer';
        var timestamp = new Date().toLocaleTimeString();

        newMessage.innerHTML = `<strong>${role}:</strong> ${message} <span class="timestamp">${timestamp}</span>`;

        chatBox.appendChild(newMessage);
        chatBox.scrollTop = chatBox.scrollHeight; // Scroll to the bottom

        // Append to chat history
        chatHistory += `${role}: ${message} [${timestamp}]\n`;

        input.value = ''; // Clear the input field

        isAdmin = !isAdmin; // Toggle the role for the next message
    }
}

// Event listener for the send button
document.getElementById('send-button').addEventListener('click', sendMessage);

// Event listener for the enter key
document.getElementById('chat-input').addEventListener('keypress', function(event) {
    if (event.key === 'Enter') {
        event.preventDefault();
        sendMessage();
    }
});

// Function to save chat history to file
function saveChatHistory() {
    var blob = new Blob([chatHistory], { type: 'text/plain' });
    var anchor = document.createElement('a');
    anchor.download = 'history.txt';
    anchor.href = window.URL.createObjectURL(blob);
    anchor.textContent = 'Download history';
    anchor.style.display = 'none';
    document.body.appendChild(anchor);
    anchor.click();
    document.body.removeChild(anchor);
}

// Add an event listener to save chat history when needed
// Example: You can save the chat history when a "Save History" button is clicked
// For demonstration, I'll use a download link that appears in the HTML
// You can trigger this function whenever you want to save the history

document.addEventListener('DOMContentLoaded', function() {
    var downloadButton = document.createElement('button');
    downloadButton.textContent = 'Save Chat History';
    downloadButton.addEventListener('click', saveChatHistory);
    document.body.appendChild(downloadButton);
});
</script>
</body>
</html>