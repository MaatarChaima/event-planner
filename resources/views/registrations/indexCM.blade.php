@extends('components.layouts.appCM')
@section('content')
    <h1>My registrations</h1>
    <table style="width:100%;border-collapse:collapse;background:white;">
        <thead>
        <tr>
            <th style="text-align:left;padding:12px;border-bottom:1px solid #e5e7eb;">Event</th>
            <th style="padding:12px;border-bottom:1px solid #e5e7eb;">Start</th>
            <th style="padding:12px;border-bottom:1px solid #e5e7eb;"></th>
        </tr>
        </thead>
        <tbody>
        @foreach($registrations as $r)
            <tr>
                <td style="padding:12px;border-bottom:1px solid #f3f4f6;">{{ $r->event->title }}</td>
                <td style="padding:12px;border-bottom:1px solid #f3f4f6;">{{ $r->event->start_date->format('M d, Y, g:i a') }}</td>
                <td style="padding:12px;text-align:right;border-bottom:1px solid #f3f4f6;">
                    <a href="{{ route('eventDetail', $r->event) }}">View</a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <div style="margin-top:12px;">
        {{ $registrations->links() }}
    </div>
@endsection
