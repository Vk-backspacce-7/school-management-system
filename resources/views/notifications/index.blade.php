<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Notifications</title>
    <link rel="preconnect" href="https://cdn.jsdelivr.net" crossorigin>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/principal-dashboard.min.css') }}">
</head>
<body class="app-fixed-body notifications-page">
    @include('partials.flash-notifications')

    <div class="notifications-shell">
        <header class="notifications-topbar">
            <h4 class="mb-0">All Notifications</h4>
            <div class="d-flex align-items-center gap-2">
                @if(auth()->user()->unreadNotifications()->count() > 0)
                    <form action="{{ route('notifications.read-all') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-outline-dark btn-sm">Mark all read</button>
                    </form>
                @endif

                <form action="{{ route('notifications.clear-all') }}" method="POST" onsubmit="return confirm('Delete complete notification history?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-outline-dark btn-sm" title="Delete all history" aria-label="Delete all history">
                        <i class="bi bi-trash3"></i>
                    </button>
                </form>

                <a href="{{ url()->previous() }}" class="btn btn-dark btn-sm">
                    <i class="bi bi-arrow-left"></i> Back
                </a>
            </div>
        </header>

        <section class="notifications-scroll-area">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-0">
                    @forelse($notifications as $notification)
                        @php
                            $data = $notification->data ?? [];
                            $title = $data['title'] ?? 'Notification';
                            $message = $data['message'] ?? 'You have a new notification.';
                            $time = $data['happened_at'] ?? $notification->created_at;
                            $formattedTime = \Illuminate\Support\Carbon::parse($time)->format('d M Y, h:i A');
                        @endphp

                        <article class="notification-row {{ $notification->read_at === null ? 'is-unread' : '' }}">
                            <div class="fw-semibold">{{ $title }}</div>
                            <p class="text-muted small mb-1">{{ $message }}</p>
                            <time class="text-secondary small">{{ $formattedTime }}</time>

                            <div class="mt-2 d-flex gap-2 align-items-center">
                                @if($notification->read_at === null)
                                    <form action="{{ route('notifications.read', $notification->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-outline-dark">Mark read</button>
                                    </form>
                                @else
                                    <span class="badge mono-badge">Read</span>
                                @endif
                            </div>
                        </article>
                    @empty
                        <div class="p-3 text-muted">No notifications found.</div>
                    @endforelse
                </div>
            </div>

            <div class="mt-3">
                {{ $notifications->links() }}
            </div>
        </section>
    </div>

    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>