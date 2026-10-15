<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Admin · Event Planner' }}</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body style="font-family: system-ui, -apple-system, Segoe UI, Roboto, Helvetica, Arial;background:#f9fafb;">
<header style="display:flex;justify-content:space-between;align-items:center;padding:16px 24px;background:#f9fafb;">
    <a href="{{ route('home') }}" style="text-decoration:none;font-weight:700;font-size:24px;">
        <span style="color:#111827;">Event</span> <span style="color:#7c3aed;">Planner</span>
    </a>
    <nav style="display:flex;gap:24px;align-items:center;">
        @php
            $isCat = request()->routeIs('admin.categories.*');
            $isEvt = request()->routeIs('admin.events.*');
        @endphp
        <a href="{{ route('admin.categories.index') }}" style="position:relative;text-decoration:none;color:#111827;font-weight:500;">
            Categories
            @if($isCat)
                <span style="position:absolute;left:0;bottom:-8px;height:2px;width:100%;background:#7c3aed;border-radius:2px;"></span>
            @endif
        </a>
        <a href="{{ route('admin.events.index') }}" style="position:relative;text-decoration:none;color:#111827;font-weight:500;">
            Events
            @if($isEvt)
                <span style="position:absolute;left:0;bottom:-8px;height:2px;width:100%;background:#7c3aed;border-radius:2px;"></span>
            @endif
        </a>
        @auth
            @php
                $u = auth()->user();
                $initial = strtoupper(substr($u->name ?? 'U', 0, 1));
            @endphp
            <div style="position:relative;">
                <button id="user-menu-toggle" style="display:flex;gap:8px;align-items:center;background:transparent;border:none;cursor:pointer;">
                    @if(!empty($u->avatar))
                        <img src="{{ $u->avatar }}" alt="{{ $u->name }}" style="width:28px;height:28px;border-radius:50%;object-fit:cover;">
                    @else
                        <div style="width:28px;height:28px;border-radius:50%;background:#7c3aed;color:white;display:flex;align-items:center;justify-content:center;font-size:14px;">{{ $initial }}</div>
                    @endif
                    <div style="text-align:left;">
                        <div style="font-size:14px;color:#111827;">{{ $u->name }}</div>
                        <div style="font-size:12px;color:#6b7280;">{{ $u->email }}</div>
                    </div>
                </button>
                <div id="user-menu" style="position:absolute;right:0;margin-top:8px;background:white;border:1px solid #e5e7eb;border-radius:12px;box-shadow:0 10px 20px rgba(0,0,0,.1);width:260px;display:none;z-index:100;">
                    <div style="display:flex;gap:10px;align-items:center;padding:12px;border-bottom:1px solid #f3f4f6;">
                        <div style="position:relative;">
                            @if(!empty($u->avatar))
                                <img src="{{ $u->avatar }}" alt="{{ $u->name }}" style="width:32px;height:32px;border-radius:50%;object-fit:cover;">
                            @else
                                <div style="width:32px;height:32px;border-radius:50%;background:#7c3aed;color:white;display:flex;align-items:center;justify-content:center;font-size:14px;">{{ $initial }}</div>
                            @endif
                            <span style="position:absolute;right:-2px;bottom:-2px;width:10px;height:10px;background:#10b981;border:2px solid white;border-radius:9999px;"></span>
                        </div>
                        <div style="line-height:1.2;">
                            <div style="font-size:14px;color:#111827;">{{ $u->name }}</div>
                            <div style="font-size:12px;color:#6b7280;">{{ $u->email }}</div>
                        </div>
                    </div>
                    <a href="{{ route('admin.profile') }}" style="display:block;padding:10px 12px;color:#111827;text-decoration:none;">View profile</a>
                    <a href="{{ route('admin.registrations.index') }}" style="display:block;padding:10px 12px;color:#111827;text-decoration:none;">Registrations</a>
                    <form method="POST" action="{{ route('logout') }}" style="margin:0;border-top:1px solid #f3f4f6;">
                        @csrf
                        <button id="logout-btn-admin" type="submit" style="display:block;width:100%;text-align:left;padding:10px 12px;border:none;background:white;color:#991b1b;">Log out</button>
                    </form>
                </div>
            </div>
        @endauth
    </nav>
</header>
<main style="padding:24px;">
    @if(session('success'))
        <div style="background:#d1fae5;color:#065f46;padding:12px;margin-bottom:12px;border-radius:8px;">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div style="background:#fee2e2;color:#991b1b;padding:12px;margin-bottom:12px;border-radius:8px;">
            {{ session('error') }}
        </div>
    @endif
    @if ($errors->any())
        <div style="background:#fee2e2;color:#991b1b;padding:12px;margin-bottom:12px;border-radius:8px;">
            <ul style="margin:0;padding-left:16px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @yield('content')
</main>
<script>
    const t = document.getElementById('user-menu-toggle');
    const m = document.getElementById('user-menu');
    const logoutBtnAdmin = document.getElementById('logout-btn-admin');
    if(t && m){
        t.addEventListener('click', function(e){ e.stopPropagation(); m.style.display = m.style.display === 'none' || m.style.display === '' ? 'block' : 'none'; });
        document.addEventListener('click', function(){ m.style.display = 'none'; });
    }
    if(logoutBtnAdmin){
        logoutBtnAdmin.addEventListener('click', function(e){ e.stopPropagation(); });
    }
</script>
</body>
</html>
