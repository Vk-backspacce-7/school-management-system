<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Teacher Dashboard</title>

<!-- Bootstrap -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<style>

    /* Body */
body {
    background: #f5f6f8;
    font-family: 'Segoe UI', sans-serif;
}

/* Profile Card */
.profile {
    background: #ffffff;
    border-radius: 12px;
    transition: 0.3s;
}

.profile:hover {
    transform: translateY(-5px);
}

/* Profile Image */
.profile-img {
    width: 90px;
    height: 90px;
    border-radius: 50%;
    border: 3px solid #ddd;
}

/* Notification Container */
.notification-container {
    position: fixed;
    top: 20px;
    right: 20px;
    z-index: 9999;
}

/* Notification Box */
.notification {
    display: flex;
    align-items: center;
    gap: 10px;
    background: #fff;
    padding: 12px 15px;
    margin-bottom: 10px;
    border-radius: 8px;
    min-width: 250px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    animation: slideFadeIn 0.5s ease forwards;
}

/* Colors */
.notification.success {
    border-left: 4px solid #28a745;
}

.notification.error {
    border-left: 4px solid #dc3545;
}

.notification.info {
    border-left: 4px solid #0d6efd;
}

/* Close Button */
.close-btn {
    margin-left: auto;
    border: none;
    background: none;
    font-size: 18px;
    cursor: pointer;
}

/* Animations */
@keyframes slideFadeIn {
    from {
        transform: translateX(100%);
        opacity: 0;
    }
    to {
        transform: translateX(0);
        opacity: 1;
    }
}

@keyframes slideFadeOut {
    to {
        transform: translateX(100%);
        opacity: 0;
    }
}
</style>

</head>

<body>

<div class="container py-5">

    <!-- Notifications -->
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

    <!-- Profile Card -->
    <div class="row justify-content-center">
        <div class="col-md-6">

            <div class="profile card shadow-lg p-4">

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h3 class="mb-0">Teacher Dashboard</h3>

                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button class="btn btn-danger btn-sm">Logout</button>
                    </form>
                </div>

                <p><strong>Name:</strong> {{ auth()->user()->name }}</p>
                <p><strong>Email:</strong> {{ auth()->user()->email }}</p>
                <p><strong>Gender:</strong> {{ auth()->user()->gender }}</p>
                <p><strong>Mobile:</strong> {{ auth()->user()->mobile }}</p>
                <p><strong>DOB:</strong> {{ auth()->user()->dob }}</p>
                <p><strong>Father Name:</strong> {{ auth()->user()->father_name }}</p>
                <p><strong>Address:</strong> {{ auth()->user()->address }}</p>

                @if(auth()->user()->image)
                <div class="text-center mt-3">
                    <img src="{{ asset('storage/'.auth()->user()->image) }}" class="profile-img">
                </div>
                @endif

            </div>

        </div>
    </div>

</div>

<!-- JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const notifications = document.querySelectorAll('.notification');

    notifications.forEach((notification, index) => {
        notification.style.animationDelay = `${index * 0.1}s`;

        const timeout = setTimeout(() => removeNotification(notification), 4000);

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