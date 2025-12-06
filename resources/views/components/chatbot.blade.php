<!-- Chatbot Flotante TuSabor -->
<div id="chatbot-container">
    <!-- Botón flotante -->
    <button id="chatbot-toggle" class="chatbot-toggle" aria-label="Abrir chat de ayuda">
        <i class="fas fa-comments"></i>
        <span class="chatbot-badge">¿Ayuda?</span>
    </button>

    <!-- Ventana del chat -->
    <div id="chatbot-window" class="chatbot-window">
        <!-- Header -->
        <div class="chatbot-header">
            <div class="chatbot-header-content">
                <i class="fas fa-robot"></i>
                <div>
                    <h4>Asistente TuSabor</h4>
                    <p class="chatbot-status">En línea</p>
                </div>
            </div>
            <button id="chatbot-close" class="chatbot-close-btn">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <!-- Mensajes -->
        <div id="chatbot-messages" class="chatbot-messages">
            <div class="chatbot-message bot-message">
                <div class="message-avatar">
                    <i class="fas fa-robot"></i>
                </div>
                <div class="message-content">
                    <p>¡Hola! 👋 Soy el asistente virtual de TuSabor.</p>
                    @guest
                    <p>Puedo ayudarte con información general sobre:</p>
                    <ul>
                        <li>🍽️ Nuestro menú y platos</li>
                        <li>💰 Precios</li>
                        <li>⏰ Horarios y ubicación</li>
                        <li>📞 Información de contacto</li>
                    </ul>
                    <p class="text-muted small mt-2">
                        <i class="fas fa-info-circle"></i> 
                        <a href="{{ route('login') }}" class="text-decoration-none">Inicia sesión</a> o 
                        <a href="{{ route('register') }}" class="text-decoration-none">regístrate</a> 
                        para recibir ayuda personalizada con pedidos y reservas.
                    </p>
                    @else
                    <p>Puedo ayudarte con:</p>
                    <ul>
                        <li>🍽️ Información sobre nuestro menú</li>
                        <li>🛒 Agregar productos al carrito</li>
                        <li>📅 Reservas de mesas</li>
                        <li>🚚 Seguimiento de pedidos</li>
                        <li>💳 Métodos de pago</li>
                    </ul>
                    @endguest
                    <p>¿En qué puedo ayudarte hoy?</p>
                </div>
            </div>
        </div>

        <!-- Input -->
        <div class="chatbot-input-container">
            <input 
                type="text" 
                id="chatbot-input" 
                class="chatbot-input" 
                placeholder="Escribe tu pregunta aquí..."
                autocomplete="off"
            >
            <button id="chatbot-send" class="chatbot-send-btn">
                <i class="fas fa-paper-plane"></i>
            </button>
        </div>

        <!-- Typing indicator -->
        <div id="chatbot-typing" class="chatbot-typing" style="display: none;">
            <div class="typing-indicator">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
    </div>
</div>

<style>
/* Chatbot Styles */
#chatbot-container {
    position: fixed;
    bottom: 20px;
    right: 20px;
    z-index: 9999;
    font-family: 'Inter', sans-serif;
}

.chatbot-toggle {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    background: linear-gradient(135deg, #8B1538 0%, #6B0F2A 100%);
    border: none;
    color: white;
    font-size: 24px;
    cursor: pointer;
    box-shadow: 0 4px 12px rgba(139, 21, 56, 0.4);
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
}

.chatbot-toggle:hover {
    transform: scale(1.1);
    box-shadow: 0 6px 20px rgba(139, 21, 56, 0.6);
}

.chatbot-badge {
    position: absolute;
    top: -5px;
    right: -5px;
    background: #D4AF37;
    color: #1A1A1A;
    padding: 4px 8px;
    border-radius: 12px;
    font-size: 11px;
    font-weight: 600;
    white-space: nowrap;
}

.chatbot-window {
    position: fixed;
    bottom: 90px;
    right: 20px;
    width: 380px;
    max-width: calc(100vw - 40px);
    height: 550px;
    max-height: calc(100vh - 120px);
    background: white;
    border-radius: 16px;
    box-shadow: 0 8px 32px rgba(0,0,0,0.2);
    display: none;
    flex-direction: column;
    overflow: hidden;
}

.chatbot-window.active {
    display: flex;
}

.chatbot-header {
    background: linear-gradient(135deg, #8B1538 0%, #6B0F2A 100%);
    color: white;
    padding: 16px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.chatbot-header-content {
    display: flex;
    align-items: center;
    gap: 12px;
}

.chatbot-header h4 {
    margin: 0;
    font-size: 16px;
    color: white;
}

.chatbot-status {
    margin: 0;
    font-size: 12px;
    color: #D4AF37;
}

.chatbot-close-btn {
    background: none;
    border: none;
    color: white;
    font-size: 20px;
    cursor: pointer;
}

.chatbot-messages {
    flex: 1;
    overflow-y: auto;
    padding: 16px;
    background: #F8F9FA;
}

.chatbot-message {
    display: flex;
    gap: 10px;
    margin-bottom: 16px;
}

.message-avatar {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.bot-message .message-avatar {
    background: linear-gradient(135deg, #8B1538 0%, #6B0F2A 100%);
    color: white;
}

.user-message {
    flex-direction: row-reverse;
}

.user-message .message-avatar {
    background: #D4AF37;
    color: #1A1A1A;
}

.message-content {
    background: white;
    padding: 12px 16px;
    border-radius: 12px;
    max-width: 75%;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.user-message .message-content {
    background: #8B1538;
    color: white;
}

.message-content p {
    margin: 0 0 8px 0;
}

.message-content p:last-child {
    margin-bottom: 0;
}

.message-content ul {
    margin: 8px 0 0 0;
    padding-left: 20px;
}

.message-content a {
    color: #8B1538;
    font-weight: 600;
}

.user-message .message-content a {
    color: #D4AF37;
}

.chatbot-input-container {
    display: flex;
    padding: 16px;
    background: white;
    border-top: 1px solid #E9ECEF;
    gap: 8px;
}

.chatbot-input {
    flex: 1;
    padding: 12px 16px;
    border: 2px solid #E9ECEF;
    border-radius: 24px;
    font-size: 14px;
    outline: none;
}

.chatbot-input:focus {
    border-color: #8B1538;
}

.chatbot-send-btn {
    width: 44px;
    height: 44px;
    border-radius: 50%;
    background: linear-gradient(135deg, #8B1538 0%, #6B0F2A 100%);
    border: none;
    color: white;
    cursor: pointer;
    transition: transform 0.2s;
}

.chatbot-send-btn:hover {
    transform: scale(1.1);
}

.chatbot-typing {
    padding: 8px 16px;
    background: #F8F9FA;
}

.typing-indicator {
    display: flex;
    gap: 4px;
    padding: 12px;
    background: white;
    border-radius: 12px;
    width: fit-content;
}

.typing-indicator span {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: #8B1538;
    animation: typing 1.4s infinite;
}

.typing-indicator span:nth-child(2) {
    animation-delay: 0.2s;
}

.typing-indicator span:nth-child(3) {
    animation-delay: 0.4s;
}

@keyframes typing {
    0%, 60%, 100% {
        transform: translateY(0);
        opacity: 0.5;
    }
    30% {
        transform: translateY(-10px);
        opacity: 1;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const toggleBtn = document.getElementById('chatbot-toggle');
    const closeBtn = document.getElementById('chatbot-close');
    const chatWindow = document.getElementById('chatbot-window');
    const messagesContainer = document.getElementById('chatbot-messages');
    const input = document.getElementById('chatbot-input');
    const sendBtn = document.getElementById('chatbot-send');
    const typingIndicator = document.getElementById('chatbot-typing');
    const isAuthenticated = {{ auth()->check() ? 'true' : 'false' }};

    toggleBtn.addEventListener('click', function() {
        chatWindow.classList.toggle('active');
        if (chatWindow.classList.contains('active')) {
            input.focus();
        }
    });

    closeBtn.addEventListener('click', function() {
        chatWindow.classList.remove('active');
    });

    function sendMessage() {
        const message = input.value.trim();
        if (!message) return;

        addMessage(message, 'user');
        input.value = '';
        typingIndicator.style.display = 'block';
        scrollToBottom();

        fetch('{{ route("chatbot.send") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ message: message })
        })
        .then(response => response.json())
        .then(data => {
            typingIndicator.style.display = 'none';
            if (data.response) {
                addMessage(data.response, 'bot');
                
                // Si el usuario no está autenticado y pregunta por funciones personalizadas
                if (!isAuthenticated && data.requires_auth) {
                    setTimeout(() => {
                        addMessage(
                            'Para ayudarte con esto necesito que <a href="{{ route("login") }}">inicies sesión</a> o <a href="{{ route("register") }}">te registres</a>. 😊',
                            'bot'
                        );
                    }, 1000);
                }
            } else {
                addMessage('Lo siento, hubo un error. Por favor intenta de nuevo.', 'bot');
            }
        })
        .catch(error => {
            typingIndicator.style.display = 'none';
            addMessage('Lo siento, no pude procesar tu mensaje. Verifica tu conexión.', 'bot');
        });
    }

    sendBtn.addEventListener('click', sendMessage);
    input.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') sendMessage();
    });

    function addMessage(text, type) {
        const messageDiv = document.createElement('div');
        messageDiv.className = `chatbot-message ${type}-message`;
        
        const avatar = document.createElement('div');
        avatar.className = 'message-avatar';
        avatar.innerHTML = type === 'bot' ? '<i class="fas fa-robot"></i>' : '<i class="fas fa-user"></i>';
        
        const content = document.createElement('div');
        content.className = 'message-content';
        content.innerHTML = `<p>${text}</p>`;
        
        messageDiv.appendChild(avatar);
        messageDiv.appendChild(content);
        messagesContainer.appendChild(messageDiv);
        scrollToBottom();
    }

    function scrollToBottom() {
        messagesContainer.scrollTop = messagesContainer.scrollHeight;
    }
});
</script>
