<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Event Planner' }}</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body style="font-family: system-ui, -apple-system, Segoe UI, Roboto, Helvetica, Arial;background:#ffffff;">
<header style="display:flex;justify-content:space-between;align-items:center;padding:16px 24px;background:#ffffff;position:relative;z-index:50;">
    <a href="{{ route('home') }}" style="text-decoration:none;font-weight:700;font-size:24px;">
        <span style="color:#111827;">Event</span> <span style="color:#7c3aed;">Planner</span>
    </a>
    <nav style="display:flex;gap:16px;align-items:center;">
        <a href="{{ route('home') }}" style="text-decoration:none;color:#111827;">Events</a>
        @guest
            <a href="{{ route('login') }}" style="text-decoration:none;color:#111827;">Login</a>
            <a href="{{ route('register') }}" style="background:#7c3aed;color:white;padding:8px 12px;border-radius:8px;text-decoration:none;">Signup</a>
        @endguest
        @auth
            @php
                $u = auth()->user();
                $initial = strtoupper(substr($u->name ?? 'U', 0, 1));
            @endphp
            <div style="position:relative;">
                <button id="user-menu-toggle-app" style="display:flex;gap:8px;align-items:center;background:transparent;border:none;cursor:pointer;">
                    <div style="width:28px;height:28px;border-radius:50%;background:#7c3aed;color:white;display:flex;align-items:center;justify-content:center;font-size:14px;">{{ $initial }}</div>
                    <div style="text-align:left;">
                        <div style="font-size:14px;color:#111827;">{{ $u->name }}</div>
                        <div style="font-size:12px;color:#6b7280;">{{ $u->email }}</div>
                    </div>
                </button>
                <div id="user-menu-app" style="position:absolute;right:0;margin-top:8px;background:white;border:1px solid #e5e7eb;border-radius:12px;box-shadow:0 10px 20px rgba(0,0,0,.1);width:220px;display:none;">
                    <a href="{{ route('profile') }}" style="display:block;padding:10px 12px;color:#111827;text-decoration:none;">My Profile</a>
                    <a href="{{ route('my.registrations') }}" style="display:block;padding:10px 12px;color:#111827;text-decoration:none;">Registrations</a>
                    @if(auth()->user()->role === 'admin')
                        <a href="{{ route('admin.events.index') }}" style="display:block;padding:10px 12px;color:#111827;text-decoration:none;">Admin</a>
                    @endif
                    <form method="POST" action="{{ route('logout') }}" style="margin:0;">
                        @csrf
                        <button id="logout-btn-app" type="submit" style="display:block;width:100%;text-align:left;padding:10px 12px;border:none;background:white;color:#991b1b;">Log out</button>
                    </form>
                </div>
            </div>
        @endauth
    </nav>
</header>
<main style="padding:16px;">
    @if ($errors->any())
        <div style="background:#fee2e2;color:#991b1b;padding:12px;margin-bottom:12px;">
            <ul style="margin:0;padding-left:16px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @yield('content')
</main>
<footer style="background:#0f0f50;color:white;padding:48px 24px;text-align:center;">
    <h2 style="margin:0 0 24px;font-size:28px;font-weight:700;">Event <span style="color:#7c3aed;">Planner</span></h2>
    <form style="display:flex;justify-content:center;gap:12px;margin-bottom:32px;">
        <input type="email" placeholder="Enter your mail" style="padding:12px 16px;border-radius:6px;border:none;width:320px;font-size:14px;outline:none;color:#1f2937;">
        <button type="button" style="background:#7c3aed;color:white;border:none;padding:12px 24px;border-radius:6px;cursor:pointer;font-weight:600;font-size:14px;">Subscribe</button>
    </form>
    <div style="display:flex;justify-content:center;gap:32px;margin-bottom:40px;">
        <a href="{{ route('home') }}" style="color:white;text-decoration:none;font-size:14px;">Home</a>
        <a href="{{ route('register') }}" style="color:white;text-decoration:none;font-size:14px;">Sign UP</a>
        <a href="{{ route('login') }}" style="color:white;text-decoration:none;font-size:14px;">Sign in</a>
    </div>
    <div style="border-top:1px solid rgba(255,255,255,0.2);margin:0 auto 24px;width:100%;"></div>
    <p style="margin:0;opacity:0.6;font-size:14px;">Non Copyrighted © 2025 Event Planner</p>
</footer>
<script>
    const t2 = document.getElementById('user-menu-toggle-app');
    const m2 = document.getElementById('user-menu-app');
    const logoutBtnApp = document.getElementById('logout-btn-app');
    if(t2 && m2){
        t2.addEventListener('click', function(e){ e.stopPropagation(); m2.style.display = m2.style.display === 'none' || m2.style.display === '' ? 'block' : 'none'; });
        document.addEventListener('click', function(){ m2.style.display = 'none'; });
    }
    if(logoutBtnApp){
        logoutBtnApp.addEventListener('click', function(e){ e.stopPropagation(); });
    }
</script>
</body>
</html>
