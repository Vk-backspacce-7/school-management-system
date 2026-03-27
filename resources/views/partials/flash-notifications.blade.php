@once
<style>
    .notification-container {
        position: fixed;
        top: 14px;
        left: 50%;
        transform: translateX(-50%);
        z-index: 2000;
        display: flex;
        flex-direction: column;
        gap: 8px;
        align-items: center;
        pointer-events: none;
    }

    .notification {
        min-width: min(92vw, 340px);
        max-width: min(92vw, 460px);
        padding: 10px 12px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        gap: 8px;
        color: #f7f7f8;
        background: rgba(24, 24, 26, 0.94);
        border: 1px solid rgba(255, 255, 255, 0.12);
        border-left: 3px solid #9d9da2 !important;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        animation: flashSlideIn 0.28s ease forwards;
        pointer-events: auto;
    }

    .notification.success,
    .notification.error,
    .notification.info {
        border-left-color: #9d9da2 !important;
    }

    .notification .icon {
        font-size: 14px;
    }

    .notification .message {
        flex: 1;
        font-size: 13px;
        line-height: 1.35;
    }

    .notification .close-btn {
        border: 0;
        background: transparent;
        color: #f7f7f8;
        font-size: 17px;
        line-height: 1;
        cursor: pointer;
    }

    .field-error {
        display: block;
        margin-top: 4px;
        color: #2b2b2f;
        font-size: 12px;
        font-weight: 500;
    }

    .is-invalid {
        border-color: #3d3d43 !important;
        box-shadow: 0 0 0 0.1rem rgba(0, 0, 0, 0.1) !important;
    }

    @keyframes flashSlideIn {
        from {
            opacity: 0;
            transform: translateY(-8px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes flashSlideOut {
        to {
            opacity: 0;
            transform: translateY(-6px);
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const notifications = document.querySelectorAll('.notification');

        notifications.forEach(function (notification) {
            const timeout = setTimeout(function () {
                removeNotification(notification);
            }, 4000);

            const closeBtn = notification.querySelector('.close-btn');

            if (closeBtn) {
                closeBtn.addEventListener('click', function () {
                    clearTimeout(timeout);
                    removeNotification(notification);
                });
            }
        });

        function removeNotification(notification) {
            notification.style.animation = 'flashSlideOut 0.28s ease forwards';
            setTimeout(function () {
                notification.remove();
            }, 280);
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