@extends('components.layouts.appCM')
@section('content')
    @php
        $heroLocal = 'images/home-hero.png';
       
    @endphp
    <section style="position:relative;border-radius:12px;overflow:hidden;margin-bottom:20px;">
        <img src="{{ $heroLocal }}" alt="Hero" style="width:100%;height:260px;object-fit:cover;display:block;">
        <div style="position:absolute;inset:0;background:linear-gradient(to right, rgba(17,24,39,.85), rgba(17,24,39,.4));"></div>
        <div style="position:absolute;left:24px;top:24px;color:white;max-width:60%;">
            <h2 style="font-size:32px;margin:0 0 8px;">MADE FOR THOSE WHO DO</h2>
            <p style="opacity:.85;margin:0;">Discover and book events near you or online.</p>
        </div>

    </section>
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:24px;margin-top:32px;">
        <h1 style="margin:0;font-size:32px;font-weight:bold;color:#111827;">Upcoming <span style="color:#7c3aed;">Events</span></h1>
        
        <form method="GET" action="{{ route('home') }}" style="display:flex;gap:12px;">
            <div style="position:relative;">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Search" style="padding:10px 16px;padding-right:40px;border:none;border-radius:6px;background:#f3f4f6;color:#111827;width:260px;font-size:14px;outline:none;">
                <button type="submit" style="position:absolute;right:8px;top:50%;transform:translateY(-50%);background:transparent;border:none;cursor:pointer;color:#6b7280;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </button>
            </div>
            
            <div style="position:relative;">
                <select style="padding:10px 16px;padding-right:36px;border:none;border-radius:6px;background:#f3f4f6;color:#111827;font-size:14px;cursor:pointer;appearance:none;outline:none;min-width:120px;">
                    <option value="">Weekdays</option>
                </select>
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="#6b7280" style="position:absolute;right:12px;top:50%;transform:translateY(-50%);pointer-events:none;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </div>

            <div style="position:relative;">
                <select name="category_id" onchange="this.form.submit()" style="padding:10px 16px;padding-right:36px;border:none;border-radius:6px;background:#f3f4f6;color:#111827;font-size:14px;cursor:pointer;appearance:none;outline:none;min-width:140px;">
                    <option value="">Any category</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" @selected(request('category_id')==$cat->id)>{{ $cat->name }}</option>
                    @endforeach
                </select>
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="#6b7280" style="position:absolute;right:12px;top:50%;transform:translateY(-50%);pointer-events:none;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </div>
        </form>
    </div>
    <div id="events-container" style="display:grid;grid-template-columns:repeat(3,1fr);gap:24px;">
        @foreach($events as $event)
            @include('events.partials.event-cardCM')
        @endforeach
    </div>
    @if($events->hasMorePages())
        <div id="load-more-container" style="display:flex;justify-content:center;margin-top:40px;margin-bottom:20px;">
            <button id="load-more-btn" data-url="{{ $events->nextPageUrl() }}" style="background:#7c3aed;color:white;padding:12px 30px;border-radius:8px;border:none;cursor:pointer;font-weight:600;font-size:15px;box-shadow:0 4px 6px -1px rgba(124, 58, 237, 0.3);transition:all 0.2s;">
                Load more...
            </button>
        </div>
    @endif

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const loadMoreBtn = document.getElementById('load-more-btn');
            const container = document.getElementById('events-container');
            const loadMoreContainer = document.getElementById('load-more-container');

            if (loadMoreBtn) {
                loadMoreBtn.addEventListener('click', function() {
                    const url = this.getAttribute('data-url');
                    
                    // Disable button and show loading state
                    const originalText = this.innerText;
                    this.innerText = 'Loading...';
                    this.disabled = true;
                    this.style.opacity = '0.7';

                    fetch(url, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        // Append new events
                        container.insertAdjacentHTML('beforeend', data.html);

                        // Update button state
                        if (data.hasMorePages) {
                            loadMoreBtn.setAttribute('data-url', data.nextPageUrl);
                            loadMoreBtn.innerText = originalText;
                            loadMoreBtn.disabled = false;
                            loadMoreBtn.style.opacity = '1';
                        } else {
                            loadMoreContainer.style.display = 'none';
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        loadMoreBtn.innerText = originalText;
                        loadMoreBtn.disabled = false;
                        loadMoreBtn.style.opacity = '1';
                    });
                });
            }
        });
    </script>

@endsection
