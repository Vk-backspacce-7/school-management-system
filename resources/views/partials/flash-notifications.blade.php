@once
<style>
    .notification-container {
        position: fixed;
        top: 20px;
        left: 50%;
        transform: translateX(-50%);
        z-index: 9999;
        display: flex;
        flex-direction: column;
        gap: 10px;
        align-items: center;
    }

    .notification {
        min-width: 300px;
        max-width: 420px;
        padding: 12px 14px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        gap: 10px;
        color: #f3f3f3;
        background: rgba(20, 20, 20, 0.92);
        border: 1px solid rgba(255, 255, 255, 0.12);
        box-shadow: 0 10px 28px rgba(0, 0, 0, 0.25);
        animation: slideFadeIn 0.4s ease forwards;
    }

    .notification.success {
        border-left: 4px solid #22c55e !important;
    }

    .notification.error {
        border-left: 4px solid #ef4444 !important;
    }

    .notification.info {
        border-left: 4px solid #3b82f6 !important;
    }

    .notification .icon {
        font-size: 15px;
    }

    .notification .message {
        flex: 1;
        font-size: 14px;
        line-height: 1.4;
    }

    .notification .close-btn {
        border: 0;
        background: transparent;
        color: #f3f3f3;
        font-size: 18px;
        line-height: 1;
        cursor: pointer;
    }

    .field-error {
        display: block;
        margin-top: 4px;
        color: #dc2626;
        font-size: 12px;
        font-weight: 500;
    }

    .is-invalid {
        border-color: #dc2626 !important;
        box-shadow: 0 0 0 0.12rem rgba(220, 38, 38, 0.16) !important;
    }

    @keyframes slideFadeIn {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes slideFadeOut {
        to {
            opacity: 0;
            transform: translateY(-8px);
        }
    }

    @media (max-width: 768px) {
        .notification {
            min-width: 90vw;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const notifications = document.querySelectorAll('.notification');

        notifications.forEach((notification, index) => {
            notification.style.animationDelay = `${index * 0.08}s`;

            const timeout = setTimeout(() => removeNotification(notification), 4200);
            const closeBtn = notification.querySelector('.close-btn');

            if (closeBtn) {
                closeBtn.addEventListener('click', () => {
                    clearTimeout(timeout);
                    removeNotification(notification);
                });
            }
        });

        function removeNotification(notification) {
            notification.style.animation = 'slideFadeOut 0.35s ease forwards';
            setTimeout(() => notification.remove(), 350);
        }
    });
</script>
@endonce

<div class="notification-container" aria-live="polite">
    @if(session('success'))
        <div class="notification success">
            <span class="icon">&#10003;</span>
            <span class="message">{{ session('success') }}</span>
            <button class="close-btn" type="button" aria-label="Close">&times;</button>
        </div>
    @endif

    @if(session('error'))
        <div class="notification error">
            <span class="icon">&#9888;</span>
            <span class="message">{{ session('error') }}</span>
            <button class="close-btn" type="button" aria-label="Close">&times;</button>
        </div>
    @endif

    @if(session('info'))
        <div class="notification info">
            <span class="icon">&#9432;</span>
            <span class="message">{{ session('info') }}</span>
            <button class="close-btn" type="button" aria-label="Close">&times;</button>
        </div>
    @endif

    @if($errors->any())
        <div class="notification error">
            <span class="icon">&#9888;</span>
            <span class="message">Please fix the highlighted field errors.</span>
            <button class="close-btn" type="button" aria-label="Close">&times;</button>
        </div>
    @endif
</div>
