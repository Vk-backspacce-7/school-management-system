@php
    $chatUser = auth()->user();
    $chatRole = strtolower((string) ($chatUser->role ?? ''));
@endphp

<li class="nav-item interaction-item" data-interaction-item>
    <button
        type="button"
        id="chatToggleButton"
        class="interaction-icon-button"
        data-panel-target="chatPanel"
        aria-expanded="false"
        aria-label="Open chat"
    >
        <svg viewBox="0 0 24 24" aria-hidden="true" focusable="false">
            <path d="M6 5h12a3 3 0 0 1 3 3v7a3 3 0 0 1-3 3h-5.4l-3.4 2.7a1 1 0 0 1-1.6-.8V18H6a3 3 0 0 1-3-3V8a3 3 0 0 1 3-3Zm0 2a1 1 0 0 0-1 1v7a1 1 0 0 0 1 1h2.6a1 1 0 0 1 1 1v1.4l2.1-1.7a1 1 0 0 1 .6-.2H18a1 1 0 0 0 1-1V8a1 1 0 0 0-1-1H6Z" />
        </svg>
        <span id="chatUnreadBadge" class="interaction-badge d-none">0</span>
    </button>

    <section
        id="chatPanel"
        class="interaction-panel panel-chat"
        data-user-id="{{ $chatUser->id }}"
        data-user-role="{{ $chatRole }}"
        data-chat-endpoint="{{ route('chat.index') }}"
        data-send-endpoint="{{ route('chat.send') }}"
        data-reverb-key="{{ config('broadcasting.connections.reverb.key') }}"
        data-reverb-host="{{ config('broadcasting.connections.reverb.options.host', request()->getHost()) }}"
        data-reverb-port="{{ config('broadcasting.connections.reverb.options.port', 8080) }}"
        data-reverb-scheme="{{ config('broadcasting.connections.reverb.options.scheme', 'http') }}"
        data-popup-notifications="{{ $chatRole === 'principal' ? '1' : '0' }}"
        aria-label="Chat panel"
    >
        <header class="chat-panel-head" id="chatDragHandle">
            <div class="chat-head-copy">
                <h2 id="chatHeaderName">Messages</h2>
                <p id="chatPanelSubtitle">Teacher & Principal chat</p>
            </div>
            <button type="button" id="chatCloseButton" class="panel-close-button" aria-label="Close chat panel">
                <svg viewBox="0 0 24 24" aria-hidden="true" focusable="false">
                    <path d="M6.7 6.7a1 1 0 0 1 1.4 0L12 10.6l3.9-3.9a1 1 0 1 1 1.4 1.4L13.4 12l3.9 3.9a1 1 0 1 1-1.4 1.4L12 13.4l-3.9 3.9a1 1 0 1 1-1.4-1.4l3.9-3.9-3.9-3.9a1 1 0 0 1 0-1.4Z" />
                </svg>
            </button>
        </header>

        <div class="chat-panel-body">
            <aside class="chat-participants" id="chatParticipants" aria-label="Chat contacts"></aside>

            <div class="chat-conversation-shell">
                <div id="chatMessages" class="chat-messages" aria-label="Conversation messages"></div>

                <form id="chatForm" class="chat-form" autocomplete="off">
                    @csrf
                    <input type="hidden" id="chatReceiverId" name="receiver_id" value="">
                    <input
                        type="text"
                        id="chatMessageInput"
                        name="message"
                        maxlength="3000"
                        placeholder="Message"
                        required
                    >
                    <button type="submit" id="chatSendButton" class="chat-send-button" aria-label="Send message">
                        <svg viewBox="0 0 24 24" aria-hidden="true" focusable="false">
                            <path d="M20.7 3.3a1 1 0 0 0-1-.2L3.6 9.5a1 1 0 0 0 0 1.9l6.3 2 2 6.3a1 1 0 0 0 1.9 0L20.9 4.3a1 1 0 0 0-.2-1Zm-7.8 13.3-1.2-3.8 4.5-4.5-5.4 3.2-3.8-1.2 10.4-4.2-4.5 10.5Z" />
                        </svg>
                    </button>
                </form>
            </div>
        </div>

        <div id="chatToastContainer" class="chat-toast-container" aria-live="assertive" aria-atomic="true"></div>
    </section>
</li>
