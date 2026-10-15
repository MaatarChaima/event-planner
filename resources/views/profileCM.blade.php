@php $title = 'My Profile'; @endphp
@extends('components.layouts.appCM')
@section('content')
@php $u = auth()->user(); @endphp
<h1>My Profile</h1>
<div style="display:flex;gap:16px;align-items:center;margin-bottom:16px;">
    <div style="width:48px;height:48px;border-radius:50%;background:#7c3aed;color:white;display:flex;align-items:center;justify-content:center;font-size:18px;">
        {{ strtoupper(substr($u->name ?? 'U',0,1)) }}
    </div>
    <div>
        <div style="font-size:18px;color:#111827;">{{ $u->name }}</div>
        <div style="color:#6b7280;">{{ $u->email }}</div>
        <div style="color:#6b7280;">Role: {{ $u->role }}</div>
        @if($u->phone)
            <div style="color:#6b7280;">Phone: {{ $u->phone }}</div>
        @endif
    </div>
</div>
@endsection
