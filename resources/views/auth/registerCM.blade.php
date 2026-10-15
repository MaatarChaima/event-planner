@extends('components.layouts.appCM')
@section('content')
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:0;align-items:stretch;min-height:calc(100vh - 80px);">
        <div style="background:linear-gradient(rgba(0,0,0,0.3), rgba(0,0,0,0.3)), url('{{ asset('images/auth-signin.png') }}') center/cover;display:flex;flex-direction:column;justify-content:center;align-items:center;padding:24px;color:white;text-align:center;">
            <div>
                <h2 style="font-size:2rem;font-weight:bold;margin-bottom:8px;margin-top:0;">Welcome back</h2>
                <p style="margin-bottom:24px;opacity:0.9;">To keep connected with us provide us with your information</p>
                <a href="{{ route('login') }}" style="background:rgba(255, 255, 255, 0.2);backdrop-filter:blur(4px);border:1px solid rgba(255, 255, 255, 0.3);color:white;padding:10px 32px;border-radius:8px;display:inline-block;text-decoration:none;font-weight:600;transition:all 0.3s;">Signin</a>
            </div>
        </div>
        <div style="padding:48px;display:flex;flex-direction:column;justify-content:center;">
            <h1 style="margin-top:0;">Sign Up to Event <span style="color:#7c3aed;">Planner</span></h1>
            <form method="POST" action="{{ url('/register') }}" style="max-width:480px;">
                @csrf
                <div style="margin-bottom:12px;">
                    <label>YOUR NAME</label>
                    <input type="text" name="name" value="{{ old('name') }}" style="width:100%;padding:12px;border:1px solid #e5e7eb;border-radius:8px;">
                </div>
                <div style="margin-bottom:12px;">
                    <label>YOUR EMAIL</label>
                    <input type="email" name="email" value="{{ old('email') }}" style="width:100%;padding:12px;border:1px solid #e5e7eb;border-radius:8px;">
                </div>
                <div style="margin-bottom:12px;">
                    <label>PASSWORD</label>
                    <input type="password" name="password" style="width:100%;padding:12px;border:1px solid #e5e7eb;border-radius:8px;">
                </div>
                <div style="margin-bottom:12px;">
                    <label>CONFIRM PASSWORD</label>
                    <input type="password" name="password_confirmation" style="width:100%;padding:12px;border:1px solid #e5e7eb;border-radius:8px;">
                </div>
                <button type="submit" style="background:#7c3aed;color:white;padding:12px 16px;border-radius:8px;width:100%;">Sign Up</button>
            </form>
        </div>
    </div>
@endsection
