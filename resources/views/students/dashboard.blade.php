<!DOCTYPE html>
<html>
<head>
    <title>Student Dashboard</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/student-dashboard.css') }}">
 <style>

    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&display=swap');

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

.notification.success { border-left: 3px solid rgba(100,255,180,0.4); }
.notification.error { border-left: 3px solid rgba(255,100,100,0.4); }
.notification.info { border-left: 3px solid rgba(120,180,255,0.4); }

@keyframes slideFadeIn {
    to { opacity:1; transform:translateY(0) scale(1); }
}
@keyframes slideFadeOut {
    to { opacity:0; transform:translateY(-10px) scale(0.96); }
}
    </style>
</head>

<body>

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

    @if($errors->any())
        @foreach($errors->all() as $error)
            <div class="notification error">
                <span class="icon">⚠</span>
                <span class="message">{{ $error }}</span>
                <button class="close-btn">&times;</button>
            </div>
        @endforeach
    @endif
</div>
 
<div class="container-fluid">
             <div class="row">
                        <div class="col-md-3 sidebar text-center">
                                    <h4 class="mb-3">Student Dashboard</h4>

                                                @if($student->image)
                                                    <img src="{{ asset('storage/'.$student->image) }}" class="profile-img mb-3">
                                                @else
                                                    <img src="https://via.placeholder.com/100" class="profile-img mb-3">
                                                @endif
                                    <h5>{{ $student->name }}</h5>
                                    <p class="small">{{ $student->email }}</p>
                                    <hr>
                                    <p><strong>Mobile:</strong> {{ $student->mobile }}</p>
                                    <p><strong>Father:</strong> {{ $student->father_name }}</p>
                                    <p><strong>Gender:</strong> {{ ucfirst($student->gender) }}</p>
                                    <p><strong>DOB:</strong> {{ $student->dob }}</p>

                                    <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button class="btn btn-danger btn-sm mt-3">Logout</button>
                                    </form>
                        </div>
                     <div class="col-md-9 p-4">
                        <div class="card shadow mb-4">
                                <div class="card-header bg-primary text-white">
                                    <h5 class="mb-0"><i class="bi bi-mortarboard-fill me-2"></i>Academic Information</h5>
                                </div>
                                    <div class="card-body">
                                        <p>
                                            <strong>Class :</strong>
                                                {{ $student->student->class->class ?? 'N/A' }}
                                                    - {{ $student->student->class->section ?? '' }}
                                        </p>
                                            <p>
                                                <strong>Age :</strong>
                                                {{ $student->student->age ?? 'N/A' }} Years
                                            </p>

                                    </div>
                        </div>
                           <div class="card shadow mb-4">
                                <div class="card-header bg-success text-white">
                                    <h5 class="mb-0"><i class="bi bi-book-fill me-2"></i>Subjects</h5>
                                </div>
                                    <div class="card-body">

                                        <ul class="list-group">
                                             @forelse($student->student->class->subjects ?? [] as $subject)
                                                <li class="list-group-item">
                                                    <i class="bi bi-check-circle text-success me-2"></i>
                                                     {{ $subject->name }}
                                                </li>
                                            @empty
                                                <li class="list-group-item text-muted">
                                                  No Subjects Found
                                                </li>
                                            @endforelse
                                        </ul>

                                    </div>
                          </div>
                    <div class="card shadow">
                            <div class="card-header bg-dark text-white">
                                <h5 class="mb-0"><i class="bi bi-geo-alt-fill me-2"></i>Address</h5>
                                </div>
                                    <div class="card-body">
                                                {{ $student->address }}
                                </div>
                 </div>

        </div>
    </div>
</div>
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