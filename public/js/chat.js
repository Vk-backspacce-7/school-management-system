(function () {
    const panel = document.getElementById('chatPanel');

    if (!panel) {
        return;
    }

    const elements = {
        participants: document.getElementById('chatParticipants'),
        messages: document.getElementById('chatMessages'),
        subtitle: document.getElementById('chatPanelSubtitle'),
        headerName: document.getElementById('chatHeaderName'),
        form: document.getElementById('chatForm'),
        receiverId: document.getElementById('chatReceiverId'),
        input: document.getElementById('chatMessageInput'),
        sendButton: document.getElementById('chatSendButton'),
        unreadBadge: document.getElementById('chatUnreadBadge'),
        toastContainer: document.getElementById('chatToastContainer'),
        dragHandle: document.getElementById('chatDragHandle'),
    };

    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content
        || elements.form.querySelector('input[name="_token"]')?.value
        || '';

    const state = {
        userId: Number(panel.dataset.userId || 0),
        userRole: panel.dataset.userRole || '',
        chatEndpoint: panel.dataset.chatEndpoint || '/chat',
        sendEndpoint: panel.dataset.sendEndpoint || '/send-message',
        showPopupNotifications: panel.dataset.popupNotifications === '1',
        participants: [],
        activeReceiverId: null,
        unreadCount: 0,
        hydrated: false,
        dragging: false,
        dragOffsetX: 0,
        dragOffsetY: 0,
    };

    function isMobileViewport() {
        return window.innerWidth <= 767;
    }

    function clamp(value, min, max) {
        return Math.min(Math.max(value, min), max);
    }

    function formatCount(value) {
        if (value > 99) {
            return '99+';
        }

        return String(value);
    }

    function setUnreadBadge(count) {
        state.unreadCount = Number(count || 0);

        if (state.unreadCount <= 0) {
            elements.unreadBadge.classList.add('d-none');
            elements.unreadBadge.textContent = '0';
            return;
        }

        elements.unreadBadge.classList.remove('d-none');
        elements.unreadBadge.textContent = formatCount(state.unreadCount);
    }

    function activeContact() {
        return state.participants.find((contact) => Number(contact.id) === Number(state.activeReceiverId)) || null;
    }

    function updateHeaderCopy() {
        const contact = activeContact();

        if (!contact) {
            elements.headerName.textContent = 'Messages';
            elements.subtitle.textContent = 'Teacher & Principal chat';
            return;
        }

        elements.headerName.textContent = contact.name;
        elements.subtitle.textContent = `Conversation with ${contact.name}`;
    }

    function clearMessages() {
        elements.messages.innerHTML = '';
    }

    function messageElement(message) {
        const isSender = Number(message.sender_id) === state.userId;
        const article = document.createElement('article');
        article.className = `chat-message ${isSender ? 'is-sender' : 'is-receiver'}`;

        const bubble = document.createElement('div');
        bubble.className = 'chat-bubble';
        bubble.textContent = message.message || '';

        const time = document.createElement('time');
        time.className = 'chat-message-time';

        const seenCopy = isSender && message.is_seen ? ' • Seen' : '';
        const readableTime = message.created_at_readable || '';
        time.textContent = `${readableTime}${seenCopy}`.trim();

        article.appendChild(bubble);
        article.appendChild(time);

        return article;
    }

    function renderEmptyState(text) {
        clearMessages();

        const empty = document.createElement('div');
        empty.className = 'chat-empty-state';
        empty.textContent = text;

        elements.messages.appendChild(empty);
    }

    function scrollToBottom() {
        elements.messages.scrollTop = elements.messages.scrollHeight;
    }

    function renderMessages(messages) {
        clearMessages();

        if (!messages.length) {
            renderEmptyState('No messages yet.');
            return;
        }

        messages.forEach((message) => {
            elements.messages.appendChild(messageElement(message));
        });

        scrollToBottom();
    }

    function participantElement(contact) {
        const button = document.createElement('button');
        button.type = 'button';
        button.className = 'chat-participant-button';

        if (Number(contact.id) === Number(state.activeReceiverId)) {
            button.classList.add('active');
        }

        button.dataset.contactId = String(contact.id);

        const name = document.createElement('span');
        name.textContent = contact.name;

        const role = document.createElement('span');
        role.className = 'chat-participant-role';
        role.textContent = contact.role;

        button.appendChild(name);
        button.appendChild(role);

        if (Number(contact.unread_count || 0) > 0) {
            const unread = document.createElement('span');
            unread.className = 'chat-participant-unread';
            unread.textContent = formatCount(Number(contact.unread_count));
            button.appendChild(unread);
        }

        button.addEventListener('click', () => {
            loadChatState(Number(contact.id));
        });

        return button;
    }

    function renderParticipants(participants) {
        elements.participants.innerHTML = '';

        if (!participants.length) {
            const empty = document.createElement('div');
            empty.className = 'chat-empty-state';
            empty.textContent = 'No contacts';
            elements.participants.appendChild(empty);
            return;
        }

        participants.forEach((contact) => {
            elements.participants.appendChild(participantElement(contact));
        });
    }

    function setFormAvailability(enabled) {
        elements.input.disabled = !enabled;
        elements.sendButton.disabled = !enabled;

        if (!enabled) {
            elements.receiverId.value = '';
        }
    }

    async function loadChatState(receiverId = null) {
        const requestUrl = new URL(state.chatEndpoint, window.location.origin);

        if (receiverId) {
            requestUrl.searchParams.set('receiver_id', String(receiverId));
        }

        const response = await fetch(requestUrl.toString(), {
            headers: {
                Accept: 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
            },
            credentials: 'same-origin',
        });

        if (!response.ok) {
            throw new Error('Could not fetch chat state.');
        }

        const payload = await response.json();

        state.participants = Array.isArray(payload.participants) ? payload.participants : [];
        state.activeReceiverId = payload.active_receiver_id ? Number(payload.active_receiver_id) : null;

        renderParticipants(state.participants);
        updateHeaderCopy();
        setUnreadBadge(Number(payload.unread_count || 0));

        if (!state.activeReceiverId) {
            setFormAvailability(false);
            renderEmptyState('No participants available.');
            return;
        }

        setFormAvailability(true);
        elements.receiverId.value = String(state.activeReceiverId);

        const messages = Array.isArray(payload.messages) ? payload.messages : [];
        renderMessages(messages);
    }

    function appendMessage(message) {
        const empty = elements.messages.querySelector('.chat-empty-state');

        if (empty) {
            empty.remove();
        }

        elements.messages.appendChild(messageElement(message));
        scrollToBottom();
    }

    function showPrincipalToast(senderName, body) {
        if (!state.showPopupNotifications) {
            return;
        }

        const toast = document.createElement('article');
        toast.className = 'chat-toast';

        const title = document.createElement('strong');
        title.textContent = `Message from ${senderName || 'Teacher'}`;

        const copy = document.createElement('p');
        copy.textContent = body || 'New message';

        toast.appendChild(title);
        toast.appendChild(copy);

        elements.toastContainer.appendChild(toast);

        window.setTimeout(() => {
            toast.remove();
        }, 3800);
    }

    async function sendMessage(event) {
        event.preventDefault();

        if (!state.activeReceiverId) {
            return;
        }

        const content = elements.input.value.trim();

        if (!content) {
            return;
        }

        elements.sendButton.disabled = true;

        try {
            const response = await fetch(state.sendEndpoint, {
                method: 'POST',
                credentials: 'same-origin',
                headers: {
                    Accept: 'application/json',
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'X-Requested-With': 'XMLHttpRequest',
                },
                body: JSON.stringify({
                    receiver_id: state.activeReceiverId,
                    message: content,
                }),
            });

            if (!response.ok) {
                throw new Error('Unable to send message.');
            }

            const payload = await response.json();

            if (payload.message) {
                appendMessage(payload.message);
            }

            if (typeof payload.unread_count !== 'undefined') {
                setUnreadBadge(Number(payload.unread_count || 0));
            }

            elements.input.value = '';
            elements.input.focus();
        } catch (_error) {
            alert('Message could not be sent. Please retry.');
        } finally {
            elements.sendButton.disabled = false;
        }
    }

    function clampChatPanelToViewport() {
        if (isMobileViewport()) {
            panel.style.left = '';
            panel.style.right = '';
            panel.style.top = '';
            panel.style.bottom = '';
            panel.dataset.manualPosition = '0';
            return;
        }

        const panelRect = panel.getBoundingClientRect();
        const margin = 8;
        const minTop = 58;

        const currentLeft = Number.parseFloat(panel.style.left || panelRect.left);
        const currentTop = Number.parseFloat(panel.style.top || panelRect.top);

        const maxLeft = window.innerWidth - panelRect.width - margin;
        const maxTop = window.innerHeight - panelRect.height - margin;

        const nextLeft = clamp(currentLeft, margin, Math.max(margin, maxLeft));
        const nextTop = clamp(currentTop, minTop, Math.max(minTop, maxTop));

        panel.style.left = `${nextLeft}px`;
        panel.style.top = `${nextTop}px`;
        panel.style.right = 'auto';
        panel.style.bottom = 'auto';
    }

    function startDrag(event) {
        if (isMobileViewport()) {
            return;
        }

        if (!panel.classList.contains('is-open')) {
            return;
        }

        const panelRect = panel.getBoundingClientRect();

        state.dragging = true;
        state.dragOffsetX = event.clientX - panelRect.left;
        state.dragOffsetY = event.clientY - panelRect.top;

        panel.classList.add('is-dragging');
        panel.dataset.manualPosition = '1';

        event.preventDefault();
    }

    function onDrag(event) {
        if (!state.dragging || isMobileViewport()) {
            return;
        }

        const panelRect = panel.getBoundingClientRect();
        const margin = 8;
        const minTop = 58;

        const maxLeft = window.innerWidth - panelRect.width - margin;
        const maxTop = window.innerHeight - panelRect.height - margin;

        const proposedLeft = event.clientX - state.dragOffsetX;
        const proposedTop = event.clientY - state.dragOffsetY;

        const nextLeft = clamp(proposedLeft, margin, Math.max(margin, maxLeft));
        const nextTop = clamp(proposedTop, minTop, Math.max(minTop, maxTop));

        panel.style.left = `${nextLeft}px`;
        panel.style.top = `${nextTop}px`;
        panel.style.right = 'auto';
        panel.style.bottom = 'auto';
    }

    function stopDrag() {
        if (!state.dragging) {
            return;
        }

        state.dragging = false;
        panel.classList.remove('is-dragging');
        clampChatPanelToViewport();
    }

    function attachRealtime() {
        const EchoConstructor = window.Echo;

        if (!EchoConstructor || typeof EchoConstructor !== 'function' || !window.Pusher || !state.userId) {
            return;
        }

        const scheme = panel.dataset.reverbScheme === 'https' ? 'https' : 'http';
        const forceTLS = scheme === 'https';
        const socketPort = Number(panel.dataset.reverbPort || (forceTLS ? 443 : 80));

        const echo = new EchoConstructor({
            broadcaster: 'reverb',
            key: panel.dataset.reverbKey,
            wsHost: panel.dataset.reverbHost || window.location.hostname,
            wsPort: socketPort,
            wssPort: socketPort,
            forceTLS,
            enabledTransports: ['ws', 'wss'],
            authEndpoint: '/broadcasting/auth',
            auth: {
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                },
            },
        });

        echo.private(`chat.${state.userId}`).listen('.message.sent', (eventPayload) => {
            const senderId = Number(eventPayload.sender_id);
            const chatOpen = panel.classList.contains('is-open');
            const sameConversation = chatOpen && Number(state.activeReceiverId) === senderId;

            if (sameConversation) {
                loadChatState(state.activeReceiverId).catch(function () {
                    appendMessage(eventPayload);
                });
                return;
            }

            showPrincipalToast(eventPayload.sender_name, eventPayload.message);

            if (!chatOpen) {
                setUnreadBadge(state.unreadCount + 1);
            }

            if (chatOpen) {
                loadChatState(state.activeReceiverId).catch(function () {
                    // Keep interface usable if lightweight refresh fails.
                });
            }
        });
    }

    function bootstrap() {
        setFormAvailability(false);

        elements.form.addEventListener('submit', sendMessage);

        if (elements.dragHandle) {
            elements.dragHandle.addEventListener('mousedown', startDrag);
        }

        document.addEventListener('mousemove', onDrag);
        document.addEventListener('mouseup', stopDrag);

        window.addEventListener('resize', clampChatPanelToViewport);

        window.addEventListener('interaction:panel-toggle', (event) => {
            const detail = event.detail || {};

            if (detail.panelId !== 'chatPanel') {
                return;
            }

            if (detail.state === 'opened') {
                if (!state.hydrated) {
                    loadChatState().then(function () {
                        state.hydrated = true;
                    }).catch(function () {
                        renderEmptyState('Unable to load chat.');
                    });
                    return;
                }

                loadChatState(state.activeReceiverId).catch(function () {
                    // Leave current screen as-is when background refresh fails.
                });
            }
        });

        loadChatState().then(function () {
            state.hydrated = true;
        }).catch(function () {
            renderEmptyState('Unable to initialize chat.');
        });

        attachRealtime();
    }

    bootstrap();
})();
