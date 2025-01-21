document.addEventListener('DOMContentLoaded', () => {
    const chatbotContainer = document.getElementById('chatbot-container');
    const openChatbotBtn = document.getElementById('open-chatbot');
    const closeChatbotBtn = document.getElementById('close-chatbot');
    const chatForm = document.getElementById('chat-form');
    const userInput = document.getElementById('user-input');
    const chatMessages = document.getElementById('chat-messages');
    let isWaitingForResponse = false;

    function toggleChatbot() {
        chatbotContainer.classList.toggle('chatbot-closed');
        openChatbotBtn.style.display = chatbotContainer.classList.contains('chatbot-closed') ? 'block' : 'none';
    }

    function addMessage(sender, message, isError = false) {
        const messageElement = document.createElement('div');
        messageElement.classList.add('message', `${sender}-message`);
        if (isError) messageElement.classList.add('error-message');
        
        // Sécuriser le contenu HTML et remplacer les **texte** par <strong>texte</strong>
        const sanitizedMessage = message
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;')
            .replace(/\n/g, '<br>')
            .replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>'); // Transformer **texte** en <strong>texte</strong>
        messageElement.innerHTML = sanitizedMessage;
        chatMessages.appendChild(messageElement);
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }
    

    async function sendMessageToServer(message) {
        if (isWaitingForResponse) return;
        
        try {
            isWaitingForResponse = true;
            userInput.disabled = true;
            chatForm.querySelector('button').disabled = true;
            
            addMessage('user', message);
            userInput.value = '';
            
            // Afficher un indicateur de chargement
            const loadingMessage = document.createElement('div');
            loadingMessage.classList.add('message', 'bot-message', 'loading');
            loadingMessage.textContent = 'En train d\'écrire...';
            chatMessages.appendChild(loadingMessage);

            const response = await fetch('/chatbot', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ message }),
            });

            // Supprimer l'indicateur de chargement
            loadingMessage.remove();

            const data = await response.json();
            
            if (!response.ok) {
                throw new Error(data.error || `Erreur HTTP: ${response.status}`);
            }
            
            if (data.error) {
                throw new Error(data.error);
            }

            // Vérifier si la réponse est une chaîne de caractères
            const botResponse = typeof data.response === 'string' 
                ? data.response 
                : 'Désolé, je n\'ai pas pu générer une réponse valide.';

            addMessage('bot', botResponse);

        } catch (error) {
            console.error('Erreur:', error);
            addMessage('bot', 'Désolé, une erreur s\'est produite ou vous n\'avez pas encore de notes disponibles. Veuillez réessayer.', true);
        } finally {
            isWaitingForResponse = false;
            userInput.disabled = false;
            chatForm.querySelector('button').disabled = false;
            userInput.focus();
        }
    }

    openChatbotBtn.addEventListener('click', toggleChatbot);
    closeChatbotBtn.addEventListener('click', toggleChatbot);

    chatForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        const message = userInput.value.trim();
        if (message && !isWaitingForResponse) {
            await sendMessageToServer(message);
        }
    });

    // Empêcher les soumissions multiples
    userInput.addEventListener('keypress', (e) => {
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            if (!isWaitingForResponse) {
                chatForm.dispatchEvent(new Event('submit'));
            }
        }
    });

    // Message de bienvenue
    setTimeout(() => {
        addMessage('bot', 'Bonjour ! Je suis votre assistant pédagogique. Je peux vous aider avec vos questions sur l\'orientation et vos études. Comment puis-je vous aider aujourd\'hui ?');
    }, 1000);
});