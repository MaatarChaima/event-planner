@php $title = 'Admin Profile'; @endphp
@extends('components.layouts.adminCM')
@section('content')
@php $u = auth()->user(); $initial = strtoupper(substr($u->name ?? 'U', 0, 1)); @endphp
<div style="background:white;border:1px solid #e5e7eb;border-radius:12px;padding:16px;max-width:640px;">
    <div style="display:flex;gap:16px;align-items:center;">
        @if(!empty($u->avatar))
            <img src="{{ $u->avatar }}" alt="{{ $u->name }}" style="width:64px;height:64px;border-radius:50%;object-fit:cover;">
        @else
            <div style="width:64px;height:64px;border-radius:50%;background:#7c3aed;color:white;display:flex;align-items:center;justify-content:center;font-size:24px;">
                {{ $initial }}
            </div>
        @endif
        <div>
            <div style="font-size:18px;color:#111827;">{{ $u->name }}</div>
            <div style="font-size:14px;color:#6b7280;">{{ $u->email }}</div>
            <div style="font-size:14px;color:#6b7280;">Role: {{ $u->role }}</div>
        </div>
    </div>
</div>
@endsection
