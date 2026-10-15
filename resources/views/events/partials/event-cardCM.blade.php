<a href="{{ route('eventDetail', $event) }}" style="text-decoration:none;color:inherit;display:block;">
    <article style="background:transparent;border:none;overflow:hidden;">
        <div style="position:relative;border-radius:8px;overflow:hidden;margin-bottom:12px;">
            @if($event->image)
                <img src="{{ $event->image }}" alt="{{ $event->title }}" style="width:100%;height:220px;object-fit:cover;display:block;">
            @else
                <div style="width:100%;height:220px;background:#f3f4f6;"></div>
            @endif
            <div style="position:absolute;top:12px;left:12px;background:white;color:#7c3aed;padding:4px 10px;border-radius:4px;font-size:12px;font-weight:700;text-transform:uppercase;">
                {{ $event->is_free ? 'FREE' : number_format($event->price,0).' TND' }}
            </div>
        </div>
        
        <h3 style="font-size:16px;font-weight:700;margin:0 0 8px;line-height:1.4;color:#111827;">{{ $event->title }}</h3>
        
        <div style="color:#7c3aed;font-size:13px;font-weight:500;margin-bottom:4px;text-transform:uppercase;">
            {{ $event->start_date->format('l, F d, g.iA') }}
        </div>
        
        <div style="color:#6b7280;font-size:13px;">
            ONLINE EVENT - Attend anywhere
        </div>
    </article>
</a>
