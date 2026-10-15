<tr style="border-bottom:1px solid #f3f4f6;">
    <td style="padding:16px 24px;color:#111827;font-weight:600;font-size:14px;">{{ $event->title }}</td>
    <td style="padding:16px 24px;color:#6b7280;font-size:14px;">{{ $event->start_date->format('M j, Y, g:ia') }}</td>
    <td style="padding:16px 24px;color:#6b7280;font-size:14px;">{{ optional($event->end_date)->format('M j, Y, g:ia') }}</td>
    <td style="padding:16px 24px;color:#6b7280;font-size:14px;">{{ $event->is_free ? 'Free' : number_format($event->price, 0) . ' TND' }}</td>
    <td style="padding:16px 24px;color:#6b7280;font-size:14px;">{{ $event->capacity }}</td>
    <td style="padding:16px 24px;color:#6b7280;font-size:14px;">{{ $event->place }}</td>
    <td style="padding:16px 24px;text-align:right;position:relative;">
        <button class="menu-toggle" data-menu="menu-evt-{{ $event->id }}" style="background:transparent;border:none;cursor:pointer;color:#9ca3af;padding:4px;">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                <path d="M12 8c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm0 2c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0 6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z"/>
            </svg>
        </button>
        <div id="menu-evt-{{ $event->id }}" class="row-menu" style="position:absolute;right:24px;top:40px;background:white;border:1px solid #e5e7eb;border-radius:8px;box-shadow:0 10px 15px -3px rgba(0,0,0,0.1), 0 4px 6px -2px rgba(0,0,0,0.05);display:none;min-width:140px;z-index:999;text-align:left;overflow:hidden;">
            <a href="{{ route('admin.events.edit', $event) }}" style="display:block;padding:10px 16px;color:#374151;text-decoration:none;font-size:14px;transition:background 0.2s;">Edit</a>
            <form method="POST" action="{{ route('admin.events.archive', $event) }}" style="margin:0;">
                @csrf
                @method('PUT')
                <button type="submit" style="display:block;width:100%;text-align:left;padding:10px 16px;border:none;background:white;color:#374151;font-size:14px;cursor:pointer;transition:background 0.2s;">
                    {{ $event->status === 'archived' ? 'Unarchive' : 'Archive' }}
                </button>
            </form>
        </div>
    </td>
</tr>
