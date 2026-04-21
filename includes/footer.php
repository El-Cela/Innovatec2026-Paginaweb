<div id="chatbot-window" style="display: none; position: fixed; bottom: 90px; right: 20px; width: 310px; height: 430px; background: white; border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.2); z-index: 20000; flex-direction: column; overflow: hidden;">
    
    <div class="chat-header" style="background: #0056b3; color: white; padding: 12px 15px; display: flex; justify-content: space-between; align-items: center; flex-shrink: 0;">
        <strong style="font-size: 0.9rem;">Asistente TERVI</strong>
        <button type="button" onclick="toggleChat()" style="background: none; border: none; color: white; font-size: 22px; cursor: pointer; padding: 0 10px; line-height: 1;">✕</button>
    </div>
    
    <div id="chat-messages" class="chat-body" style="flex: 1; padding: 15px; background: #f8fafd; overflow-y: auto; display: flex; flex-direction: column; gap: 10px;">
        <div class="msg-bot">Hola, soy TERVI. ¿En qué puedo apoyarte hoy?</div>
    </div>

    <div class="chat-footer" style="padding: 12px; background: white; border-top: 1px solid #eee; flex-shrink: 0;">
        <div class="input-group" style="display: flex; gap: 8px;">
            <input type="text" id="chat-input" placeholder="Escribe aquí..." style="flex: 1; border: 1px solid #ddd; border-radius: 20px; padding: 8px 15px; outline: none; font-size: 0.9rem;">
            <button id="btn-send-chat" style="background: #0056b3; color: white; border: none; width: 35px; height: 35px; border-radius: 50%; cursor: pointer;">➤</button>
        </div>
    </div>
</div>

<div class="chat-bubble" onclick="toggleChat()" style="position: fixed; bottom: 20px; right: 20px; width: 60px; height: 60px; background: #28a745; border-radius: 50%; display: flex; justify-content: center; align-items: center; cursor: pointer; z-index: 20001; box-shadow: 0 5px 15px rgba(0,0,0,0.3);">
    <img src="https://cdn-icons-png.flaticon.com/512/3649/3649460.png" style="width: 30px;">
</div>

<footer class="main-footer">
    <div class="footer-container">
        <div class="footer-info"><strong>TER<span>VI</span></strong></div>
        <div class="footer-links">
            <a href="privacidad.php">Privacidad</a>
            <a href="terminos.php">Términos</a>
            <a href="sobre-nosotros.php">Contacto</a>
        </div>
    </div>
    <div class="footer-bottom">&copy; 2026 TERVI</div>
</footer>

<script src="assets/js/chatbot.js"></script>