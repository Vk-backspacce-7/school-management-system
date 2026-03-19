<!DOCTYPE html>
<html>
<head>
    <title>Login</title> 
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Premium Notification CSS -->
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&display=swap');
        body { font-family: 'Inter', sans-serif;     }

        /* Notification Container */
        .notification-container {
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 9999;
            display: flex;
            flex-direction: column;
            gap: 12px;
            align-items: center;
        }

        /* Base Notification */
        .notification {
            min-width: 320px;
            max-width: 420px;
            padding: 14px 18px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            gap: 12px;
            color: #e5e5e5;
            font-size: 14px;
            font-weight: 500;
            backdrop-filter: blur(14px);
            background: rgba(20, 20, 20, 0.75);
            border: 1px solid rgba(255,255,255,0.08);
            box-shadow: 0 8px 25px rgba(0,0,0,0.6), inset 0 1px 0 rgba(255,255,255,0.05);
            opacity: 0;
            transform: translateY(-20px) scale(0.98);
            animation: slideFadeIn 0.5s cubic-bezier(0.25, 0.8, 0.25, 1) forwards;
        }

        .notification .icon { font-size:16px; opacity:0.9; }
        .notification .message { flex:1; }
        .notification .close-btn {
            background: transparent; border: none; color: #aaa;
            font-size: 16px; cursor: pointer; transition: all 0.2s ease;
        }
        .notification .close-btn:hover { color:#fff; transform: scale(1.1); }

        /* State Colors */
        .notification.success { border-left: 3px solid rgba(100,255,180,0.4); }
        .notification.error { border-left: 3px solid rgba(255,100,100,0.4); }
        .notification.info { border-left: 3px solid rgba(120,180,255,0.4); }

        /* Animations */
        @keyframes slideFadeIn {
            to { opacity:1; transform:translateY(0) scale(1); }
        }
        @keyframes slideFadeOut {
            to { opacity:0; transform:translateY(-10px) scale(0.96); }
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <h2>Login</h2>

    <!-- Notification Container -->
    <div class="notification-container">
        @if(session('success'))
            <div class="notification success">
                <span class="icon">✔</span>
                <span class="message">{{ session('success') }}</span>
                <button class="close-btn">&times;</button>
            </div>
        @endif

        @if(session('error'))
            <div class="notification error">
                <span class="icon">⚠</span>
                <span class="message">{{ session('error') }}</span>
                <button class="close-btn">&times;</button>
            </div>
        @endif

        @if(session('info'))
            <div class="notification info">
                <span class="icon">ℹ</span>
                <span class="message">{{ session('info') }}</span>
                <button class="close-btn">&times;</button>
            </div>
        @endif
    </div>

    <!-- Validation Errors -->
    @if($errors->any())
        <ul class="alert alert-danger">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <!-- Login Form -->
    <form action="{{ route('login.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Email:</label>
            <input type="email" name="email" value="{{ old('email') }}" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Password:</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Login</button>
    </form>
</div>

<!-- Notification JS -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    const notifications = document.querySelectorAll('.notification');
    notifications.forEach((notification, index) => {
        notification.style.animationDelay = `${index * 0.1}s`;

        const timeout = setTimeout(() => removeNotification(notification), 3500);

        const closeBtn = notification.querySelector('.close-btn');
        closeBtn.addEventListener('click', () => {
            clearTimeout(timeout);
            removeNotification(notification);
        });
    });

    function removeNotification(notification) {
        notification.style.animation = 'slideFadeOut 0.4s ease forwards';
        setTimeout(() => notification.remove(), 400);
    }
});
</script>

</body>
</html>