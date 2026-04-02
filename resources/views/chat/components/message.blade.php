@props([
    'message',
    'isSender' => false,
])

@php
    $messageText = is_array($message) ? ($message['message'] ?? '') : ($message->message ?? '');
    $messageTime = is_array($message)
        ? ($message['created_at_readable'] ?? '')
        : optional($message->created_at)->format('h:i A');
@endphp

<article class="chat-message {{ $isSender ? 'is-sender' : 'is-receiver' }}">
    <div class="chat-bubble">{{ $messageText }}</div>
    <time class="chat-message-time">{{ $messageTime }}</time>
</article>
