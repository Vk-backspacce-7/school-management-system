@php
    $notificationBellUser = auth()->user();
    $bellUnreadCount = $notificationBellUser?->unreadNotifications()->count() ?? 0;
    $bellRecentNotifications = $notificationBellUser?->notifications()->latest()->take(15)->get() ?? collect();
@endphp

<div class="notification-bell dropdown dropup">
    <button
        class="btn notification-bell-toggle"
        type="button"
        id="notificationBellToggle"
        data-bs-toggle="dropdown"
        data-bs-auto-close="outside"
        aria-expanded="false"
        aria-label="Open notifications"
    >
        <i class="bi bi-bell"></i>
        @if($bellUnreadCount > 0)
            <span class="notification-bell-count">{{ $bellUnreadCount > 99 ? '99+' : $bellUnreadCount }}</span>
        @endif
    </button>

    <div class="dropdown-menu dropdown-menu-end notification-bell-menu p-0" aria-labelledby="notificationBellToggle">
        <div class="notification-bell-head">
            <strong class="small mb-0">Notifications</strong>
            <div class="notification-bell-head-actions">
                @if($bellUnreadCount > 0)
                    <form action="{{ route('notifications.read-all') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-link btn-sm p-0">Mark all read</button>
                    </form>
                @endif
                <a href="{{ route('notifications.index') }}" class="small text-decoration-none">View all</a>
            </div>
        </div>

        <div class="notification-bell-list">
            @forelse($bellRecentNotifications as $notification)
                @php
                    $data = $notification->data ?? [];
                    $title = $data['title'] ?? 'Notification';
                    $message = $data['message'] ?? 'You have a new notification.';
                    $time = $data['happened_at'] ?? $notification->created_at;
                    $formattedTime = \Illuminate\Support\Carbon::parse($time)->format('d M Y, h:i A');
                @endphp

                <article class="notification-bell-item {{ $notification->read_at === null ? 'is-unread' : '' }}">
                    <div class="notification-bell-title">{{ $title }}</div>
                    <p class="notification-bell-message">{{ $message }}</p>
                    <time class="notification-bell-time">{{ $formattedTime }}</time>

                    <div class="notification-bell-row">
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
                <div class="px-3 py-3 small text-muted">No notifications yet.</div>
            @endforelse
        </div>
    </div>
</div>