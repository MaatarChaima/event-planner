@extends('components.layouts.appCM')
@section('content')
    {{-- Hero Section --}}
    <section style="position:relative;border-radius:12px;overflow:hidden;margin-bottom:40px;height:480px;">
        @if($event->image)
            <img src="{{ $event->image }}" alt="{{ $event->title }}" style="width:100%;height:100%;object-fit:cover;display:block;">
        @else
            <div style="width:100%;height:100%;background:#1f2937;"></div>
        @endif
        
        <div style="position:absolute;inset:0;background:rgba(0,0,0,0.4);"></div>

        <div style="position:absolute;inset:0;padding:40px;display:flex;flex-direction:column;justify-content:space-between;">
            <div>
                <a href="{{ route('home') }}" style="display:inline-flex;align-items:center;gap:8px;background:#7c3aed;color:white;padding:8px 16px;border-radius:8px;text-decoration:none;font-weight:500;font-size:14px;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    Back
                </a>
            </div>

            <div style="color:white;max-width:800px;">
                <h1 style="font-size:56px;font-weight:bold;margin:0 0 8px;line-height:1.1;">{{ $event->title }}</h1>
                <p style="font-size:24px;font-weight:600;margin:0 0 32px;opacity:0.9;">{{ $event->place }}</p>
                
                @auth
                    @if($event->registrations->contains('user_id', auth()->id()))
                        <form method="POST" action="{{ route('events.unregister', $event) }}" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="background:#ef4444;color:white;padding:12px 32px;border-radius:8px;border:none;font-size:16px;font-weight:600;cursor:pointer;">
                                Unregister
                            </button>
                        </form>
                    @else
                        <button type="button" id="open-booking-hero" style="background:#7c3aed;color:white;padding:12px 32px;border-radius:8px;border:none;font-size:16px;font-weight:600;cursor:pointer;" @disabled($event->remainingCapacity()<=0)>
                            {{ $event->remainingCapacity() > 0 ? 'Book now' : 'Sold Out' }}
                        </button>
                    @endif
                @else
                    <a href="{{ route('login') }}" style="display:inline-block;background:#7c3aed;color:white;padding:12px 32px;border-radius:8px;text-decoration:none;font-size:16px;font-weight:600;">
                        Login to Book
                    </a>
                @endauth
            </div>
        </div>
    </section>

    {{-- Details Section --}}
    <div style="display:grid;grid-template-columns:2fr 1fr;gap:60px;margin-bottom:80px;">
        <div>
            <h2 style="font-size:24px;font-weight:bold;margin-bottom:20px;color:#111827;">Description</h2>
            <div style="color:#6b7280;line-height:1.8;font-size:16px;">
                {{ $event->description }}
            </div>
        </div>
        <div>
            <h2 style="font-size:24px;font-weight:bold;margin-bottom:20px;color:#111827;">Hours</h2>
            <div style="margin-bottom:32px;">
                <div style="display:flex;gap:12px;margin-bottom:12px;align-items:center;">
                    <span style="color:#6b7280;min-width:100px;">Start:</span>
                    <span style="color:#7c3aed;font-weight:600;">{{ $event->start_date->format('g:i A') }} - {{ $event->start_date->format('M d, Y') }}</span>
                </div>
                @if($event->end_date)
                    <div style="display:flex;gap:12px;align-items:center;">
                        <span style="color:#6b7280;min-width:100px;">End:</span>
                        <span style="color:#7c3aed;font-weight:600;">{{ $event->end_date->format('g:i A') }} - {{ $event->end_date->format('M d, Y') }}</span>
                    </div>
                @endif
            </div>

            <h2 style="font-size:24px;font-weight:bold;margin-bottom:20px;color:#111827;">Capacity</h2>
            <div style="display:flex;gap:12px;align-items:center;">
                <span style="color:#6b7280;min-width:100px;">Seats number:</span>
                <span style="color:#7c3aed;font-weight:600;">{{ $event->capacity }} persons</span>
            </div>
             <div style="display:flex;gap:12px;align-items:center;margin-top:8px;">
                <span style="color:#6b7280;min-width:100px;">Remaining:</span>
                <span style="color:#7c3aed;font-weight:600;">{{ $event->remainingCapacity() }} persons</span>
            </div>
        </div>
    </div>

    {{-- Related Events --}}
    @if(isset($relatedEvents) && $relatedEvents->count() > 0)
        <h2 style="font-size:24px;font-weight:bold;margin-bottom:24px;color:#111827;">Other events you may like</h2>
        <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:24px;">
            @foreach($relatedEvents as $related)
                <a href="{{ route('eventDetail', $related) }}" style="text-decoration:none;color:inherit;display:block;">
                    <article style="background:transparent;border:none;overflow:hidden;">
                        <div style="position:relative;border-radius:8px;overflow:hidden;margin-bottom:12px;">
                            @if($related->image)
                                <img src="{{ $related->image }}" alt="{{ $related->title }}" style="width:100%;height:220px;object-fit:cover;display:block;">
                            @else
                                <div style="width:100%;height:220px;background:#f3f4f6;"></div>
                            @endif
                            <div style="position:absolute;top:12px;left:12px;background:white;color:#7c3aed;padding:4px 10px;border-radius:4px;font-size:12px;font-weight:700;text-transform:uppercase;">
                                {{ $related->is_free ? 'FREE' : number_format($related->price,0).' TND' }}
                            </div>
                        </div>
                        
                        <h3 style="font-size:16px;font-weight:700;margin:0 0 8px;line-height:1.4;color:#111827;">{{ $related->title }}</h3>
                        
                        <div style="color:#7c3aed;font-size:13px;font-weight:500;margin-bottom:4px;text-transform:uppercase;">
                            {{ $related->start_date->format('l, F d, g.iA') }}
                        </div>
                        
                        <div style="color:#6b7280;font-size:13px;">
                            ONLINE EVENT - Attend anywhere
                        </div>
                    </article>
                </a>
            @endforeach
        </div>
    @endif

    {{-- Booking Modal --}}
    @auth
        <form method="POST" action="{{ route('events.register', $event) }}" id="register-form">
            @csrf
        </form>
        <x-modalCM id="booking-modal">
            <div style="text-align:center;">
                <h2 style="font-size:32px;font-weight:bold;margin:0 0 40px;color:#111827;">Book Event</h2>
                
                <div style="display:flex;gap:20px;justify-content:center;">
                    <button type="button" id="cancel-booking" style="flex:1;padding:12px;border:1px solid #7c3aed;border-radius:8px;color:#7c3aed;background:white;font-size:16px;cursor:pointer;max-width:200px;">Cancel</button>
                    <button type="button" id="confirm-booking" style="flex:1;padding:12px;border-radius:8px;background:#7c3aed;color:white;border:none;font-size:16px;cursor:pointer;max-width:200px;">Book now</button>
                </div>
            </div>
        </x-modalCM>


        <script>
            const openBtn = document.getElementById('open-booking-hero');
            const overlay = document.getElementById('booking-modal-overlay');
            const modal = document.getElementById('booking-modal');
            const cancelBtn = document.getElementById('cancel-booking');
            const confirmBtn = document.getElementById('confirm-booking');
            const form = document.getElementById('register-form');
            
            function openModal(){ 
                if(overlay && modal) {
                    overlay.style.display='block'; 
                    modal.style.display='block'; 
                }
            }
            function closeModal(){ 
                if(overlay && modal) {
                    overlay.style.display='none'; 
                    modal.style.display='none'; 
                }
            }
            
            if(openBtn){ openBtn.addEventListener('click', openModal); }
            if(cancelBtn){ cancelBtn.addEventListener('click', closeModal); }
            if(overlay){ overlay.addEventListener('click', closeModal); }
            if(confirmBtn){ confirmBtn.addEventListener('click', ()=>{ form.submit(); }); }
        </script>
    @endauth

@endsection
