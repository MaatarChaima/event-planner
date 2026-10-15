@extends('components.layouts.adminCM')
@section('content')
    <h1 style="color:#7c3aed;font-size:32px;font-weight:bold;margin-bottom:24px;">List of Events</h1>

    <div style="background:white;border-radius:12px;box-shadow:0 1px 3px rgba(0,0,0,0.1);border:1px solid #e5e7eb;overflow:visible;">
        <div style="display:flex;justify-content:space-between;align-items:center;padding:20px 24px;border-bottom:1px solid #f3f4f6;">
            <h2 style="font-size:18px;font-weight:bold;color:#111827;margin:0;">Events</h2>
            <a href="{{ route('admin.events.create') }}" style="background:#7c3aed;color:white;padding:10px 20px;border-radius:8px;text-decoration:none;font-weight:500;font-size:14px;">Create event</a>
        </div>
        
        <table style="width:100%;border-collapse:collapse;text-align:left;">
            <thead>
                <tr>
                    <th style="padding:16px 24px;font-size:12px;font-weight:600;text-transform:uppercase;color:#6b7280;letter-spacing:0.05em;border-bottom:1px solid #f3f4f6;">Event name</th>
                    <th style="padding:16px 24px;font-size:12px;font-weight:600;text-transform:uppercase;color:#6b7280;letter-spacing:0.05em;border-bottom:1px solid #f3f4f6;">Start date</th>
                    <th style="padding:16px 24px;font-size:12px;font-weight:600;text-transform:uppercase;color:#6b7280;letter-spacing:0.05em;border-bottom:1px solid #f3f4f6;">End Date</th>
                    <th style="padding:16px 24px;font-size:12px;font-weight:600;text-transform:uppercase;color:#6b7280;letter-spacing:0.05em;border-bottom:1px solid #f3f4f6;">Pricing</th>
                    <th style="padding:16px 24px;font-size:12px;font-weight:600;text-transform:uppercase;color:#6b7280;letter-spacing:0.05em;border-bottom:1px solid #f3f4f6;">Capacity</th>
                    <th style="padding:16px 24px;font-size:12px;font-weight:600;text-transform:uppercase;color:#6b7280;letter-spacing:0.05em;border-bottom:1px solid #f3f4f6;">Place</th>
                    <th style="padding:16px 24px;border-bottom:1px solid #f3f4f6;"></th>
                </tr>
            </thead>
            <tbody id="events-table-body">
            @foreach($events as $event)
                @include('admin.events.partials.event-rowCM')
            @endforeach
            </tbody>
        </table>
        @if($events->hasMorePages())
            <div id="load-more-container" style="display:flex;justify-content:center;padding:16px 24px;border-top:1px solid #f3f4f6;">
                <button id="load-more-btn" data-url="{{ $events->nextPageUrl() }}" style="background:#7c3aed;color:white;padding:10px 24px;border-radius:8px;border:none;cursor:pointer;font-weight:600;font-size:14px;box-shadow:0 4px 6px -1px rgba(124, 58, 237, 0.3);transition:all 0.2s;">
                    Load more...
                </button>
            </div>
        @endif
    </div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const loadMoreBtn = document.getElementById('load-more-btn');
        const tableBody = document.getElementById('events-table-body');
        const loadMoreContainer = document.getElementById('load-more-container');

        if (loadMoreBtn) {
            loadMoreBtn.addEventListener('click', function() {
                const url = this.getAttribute('data-url');
                
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
                    // Append new rows
                    tableBody.insertAdjacentHTML('beforeend', data.html);

                    // Re-attach hover events for new rows
                    document.querySelectorAll('.row-menu a, .row-menu button').forEach(el => {
                        el.addEventListener('mouseenter', () => el.style.background = '#f3f4f6');
                        el.addEventListener('mouseleave', () => el.style.background = 'white');
                    });

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

    document.addEventListener('click', function (e) {
        const t = e.target.closest('.menu-toggle');
        // Close all menus
        const menus = document.querySelectorAll('.row-menu');
        
        if (!t) {
            menus.forEach(m => m.style.display = 'none');
            return;
        }

        const id = t.getAttribute('data-menu');
        const m = document.getElementById(id);
        
        // If clicking the same toggle, toggle it. If clicking another, close others and open this.
        menus.forEach(menu => {
            if (menu.id !== id) menu.style.display = 'none';
        });

        if (m) {
            m.style.display = (m.style.display === 'block') ? 'none' : 'block';
            e.stopPropagation();
        }
    });

    // Add hover effect via JS since inline styles are tricky for hover
    document.querySelectorAll('.row-menu a, .row-menu button').forEach(el => {
        el.addEventListener('mouseenter', () => el.style.background = '#f3f4f6');
        el.addEventListener('mouseleave', () => el.style.background = 'white');
    });
</script>
@endsection
