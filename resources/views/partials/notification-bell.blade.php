@php
    $notificationBellUser = auth()->user();
    $notificationRole = strtolower((string) ($notificationBellUser?->role ?? ''));
    $showNotificationIcon = $notificationRole === 'principal';

    $bellUnreadCount = $notificationBellUser?->unreadNotifications()->count() ?? 0;
    $bellRecentNotifications = $notificationBellUser?->notifications()->latest()->take(15)->get() ?? collect();
@endphp

@if($showNotificationIcon)
<li class="nav-item interaction-item" data-interaction-item>
    <button
        class="interaction-icon-button"
        type="button"
        id="notificationBellToggle"
        data-panel-target="notificationPanel"
        aria-expanded="false"
        aria-label="Open notifications"
    >
        <svg viewBox="0 0 24 24" aria-hidden="true" focusable="false">
            <path d="M12 3a5 5 0 0 0-5 5v2.2c0 .7-.2 1.4-.6 2l-1.3 2a1 1 0 0 0 .8 1.5h12.2a1 1 0 0 0 .8-1.5l-1.3-2a3.7 3.7 0 0 1-.6-2V8a5 5 0 0 0-5-5Zm0 18a2.5 2.5 0 0 0 2.5-2.5h-5A2.5 2.5 0 0 0 12 21Z" />
        </svg>

        @if($bellUnreadCount > 0)
            <span class="interaction-badge">{{ $bellUnreadCount > 99 ? '99+' : $bellUnreadCount }}</span>
        @endif
    </button>

    <section class="interaction-panel panel-notifications" id="notificationPanel" aria-label="Notifications">
        <header class="panel-head">
            <strong>Notifications</strong>
            <div class="panel-head-actions">
                @if($bellUnreadCount > 0)
                    <form action="{{ route('notifications.read-all') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-link btn-sm p-0">Mark all read</button>
                    </form>
                @endif
                <a href="{{ route('notifications.index') }}" class="small text-decoration-none">View all</a>
            </div>
        </header>

        <div class="panel-list" id="notificationPanelList">
            @forelse($bellRecentNotifications as $notification)
                @php
                    $data = $notification->data ?? [];
                    $title = $data['title'] ?? 'Notification';
                    $message = $data['message'] ?? 'You have a new notification.';
                    $time = $data['happened_at'] ?? $notification->created_at;
                    $formattedTime = \Illuminate\Support\Carbon::parse($time)->format('d M Y, h:i A');
                @endphp

                <article class="panel-item {{ $notification->read_at === null ? 'is-unread' : '' }}">
                    <div class="panel-item-title">{{ $title }}</div>
                    <p class="panel-item-copy">{{ $message }}</p>
                    <time class="panel-item-time">{{ $formattedTime }}</time>

                    <div class="panel-item-row">
                        @if($notification->read_at === null)
                            <form action="{{ route('notifications.read', $notification->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-outline-dark btn-sm py-0 px-2">Mark read</button>
                            </form>
                        @else
                            <span class="small text-muted">Read</span>
                        @endif
                    </div>
                </article>
            @empty
                <div class="panel-empty">No notifications yet.</div>
            @endforelse
        </div>
    </section>
</li>
@endif
