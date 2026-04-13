// FUNCIÓN PARA ABRIR Y CERRAR
function toggleChat() {
    const chatWin = document.getElementById('chatbot-window');
    
    if (chatWin.style.display === 'none') {
        chatWin.style.display = 'flex';
    } else {
        chatWin.style.display = 'none';
        // Si estaba hablando, lo callamos al cerrar
        window.speechSynthesis.cancel();
    }
}

// ENVÍO DE MENSAJES
document.getElementById('btn-send-chat').addEventListener('click', function() {
    const input = document.getElementById('chat-input');
    const userText = input.value;
    if (userText === "") return;

    renderMessage(userText, 'user');
    input.value = "";

    fetch('procesos/chat_motor.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'texto=' + encodeURIComponent(userText)
    })
    .then(response => response.text()) // <--- ESTA LÍNEA ES LA QUE TE FALTABA
    .then(data => {
        // Ahora 'data' es el texto real (ej. "Lava tu muñón...") 
        // y ya no el objeto Response
        renderMessage(data, 'bot');
        
        // Limpiamos el HTML para que la voz solo lea el texto
        let textoLimpio = data.replace(/<[^>]*>?/gm, ''); 
        
        let utterance = new SpeechSynthesisUtterance(textoLimpio);
        utterance.lang = 'es-ES';
        window.speechSynthesis.speak(utterance);
    })
    .catch(error => console.error('Error en el fetch:', error)); // Siempre es bueno tener esto
});

// Enviar mensaje presionando ENTER
document.getElementById('chat-input').addEventListener('keypress', function (e) {
    if (e.key === 'Enter') {
        document.getElementById('btn-send-chat').click();
    }
});

// PINTAR GLOBOS
function renderMessage(text, sender) {
    const chatBody = document.getElementById('chat-messages');
    const msgDiv = document.createElement('div');
    
    msgDiv.className = sender === 'user' ? 'msg-user' : 'msg-bot';
    
    // --- CAMBIO CLAVE AQUÍ ---
    // Usamos innerHTML para que el navegador reconozca etiquetas <img> o <b>
    msgDiv.innerHTML = text; 
    
    chatBody.appendChild(msgDiv);
    chatBody.scrollTop = chatBody.scrollHeight;
}