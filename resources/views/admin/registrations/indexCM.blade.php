@extends('components.layouts.adminCM')
@section('content')
    <h1 style="color:#7c3aed;font-size:32px;font-weight:bold;margin-bottom:24px;">List of registrations</h1>

    <div style="background:white;border-radius:12px;box-shadow:0 1px 3px rgba(0,0,0,0.1);border:1px solid #e5e7eb;overflow:hidden;">
        <div style="padding:20px 24px;border-bottom:1px solid #f3f4f6;">
            <h2 style="font-size:18px;font-weight:bold;color:#111827;margin:0;">Registrations</h2>
        </div>
        
        <table style="width:100%;border-collapse:collapse;text-align:left;">
            <thead>
                <tr>
                    <th style="padding:16px 24px;font-size:12px;font-weight:600;text-transform:uppercase;color:#6b7280;letter-spacing:0.05em;border-bottom:1px solid #f3f4f6;">Event title</th>
                    <th style="padding:16px 24px;font-size:12px;font-weight:600;text-transform:uppercase;color:#6b7280;letter-spacing:0.05em;border-bottom:1px solid #f3f4f6;">Start date</th>
                    <th style="padding:16px 24px;font-size:12px;font-weight:600;text-transform:uppercase;color:#6b7280;letter-spacing:0.05em;border-bottom:1px solid #f3f4f6;">User's email</th>
                </tr>
            </thead>
            <tbody>
            @foreach($registrations as $r)
                <tr style="border-bottom:1px solid #f3f4f6;">
                    <td style="padding:16px 24px;color:#111827;font-weight:600;font-size:14px;">{{ $r->event->title }}</td>
                    <td style="padding:16px 24px;color:#6b7280;font-size:14px;">{{ $r->event->start_date->format('M j, Y, g:ia') }}</td>
                    <td style="padding:16px 24px;color:#6b7280;font-size:14px;">{{ $r->user->email }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        @if($registrations->hasPages())
            <div style="padding:16px 24px;border-top:1px solid #f3f4f6;">
                {{ $registrations->links() }}
            </div>
        @endif
    </div>
@endsection
