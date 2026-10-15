@extends('components.layouts.adminCM')
@section('content')
    <h1 style="color:#7c3aed;font-size:32px;font-weight:bold;margin-bottom:24px;">List of categories</h1>

    <div style="background:white;border-radius:12px;box-shadow:0 1px 3px rgba(0,0,0,0.1);border:1px solid #e5e7eb;overflow:visible;">
        <div style="display:flex;justify-content:space-between;align-items:center;padding:20px 24px;border-bottom:1px solid #f3f4f6;">
            <h2 style="font-size:18px;font-weight:bold;color:#111827;margin:0;">Categories</h2>
            <button id="open-create-category" type="button" style="background:#7c3aed;color:white;padding:10px 20px;border-radius:8px;font-weight:500;font-size:14px;">Create category</button>
        </div>
        
        <table style="width:100%;border-collapse:collapse;text-align:left;">
            <thead>
                <tr>
                    <th style="padding:16px 24px;font-size:12px;font-weight:600;text-transform:uppercase;color:#6b7280;letter-spacing:0.05em;border-bottom:1px solid #f3f4f6;">Category</th>
                    <th style="padding:16px 24px;border-bottom:1px solid #f3f4f6;"></th>
                </tr>
            </thead>
            <tbody>
            @foreach($categories as $category)
                <tr style="border-bottom:1px solid #f3f4f6;">
                    <td style="padding:16px 24px;color:#111827;font-weight:600;font-size:14px;">{{ $category->name }}</td>
                    <td style="padding:16px 24px;text-align:right;position:relative;">
                        <button class="menu-toggle" data-menu="menu-cat-{{ $category->id }}" style="background:transparent;border:none;cursor:pointer;color:#9ca3af;padding:4px;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 8c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm0 2c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0 6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z"/>
                            </svg>
                        </button>
                        <div id="menu-cat-{{ $category->id }}" class="row-menu" style="position:absolute;right:24px;top:40px;background:white;border:1px solid #e5e7eb;border-radius:8px;box-shadow:0 10px 15px -3px rgba(0,0,0,0.1), 0 4px 6px -2px rgba(0,0,0,0.05);display:none;min-width:140px;z-index:999;text-align:left;overflow:hidden;">
                            <a href="{{ route('admin.categories.edit', $category) }}" style="display:block;padding:10px 16px;color:#374151;text-decoration:none;font-size:14px;transition:background 0.2s;">Edit</a>
                            <form method="POST" action="{{ route('admin.categories.destroy', $category) }}" style="margin:0;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="display:block;width:100%;text-align:left;padding:10px 16px;border:none;background:white;color:#ef4444;font-size:14px;cursor:pointer;transition:background 0.2s;">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        @if($categories->hasPages())
            <div style="padding:16px 24px;border-top:1px solid #f3f4f6;">
                {{ $categories->links() }}
            </div>
        @endif
    </div>
    <x-modalCM id="create-category-modal" title="Create category">
        <form method="POST" action="{{ route('admin.categories.store') }}" id="create-category-form">
            @csrf
            <div style="margin-bottom:12px;">
                <label>Category name</label>
                <input type="text" name="name" placeholder="Enter category name" style="width:100%;padding:12px;border:1px solid #e5e7eb;border-radius:12px;">
            </div>
            <div style="display:flex;gap:16px;justify-content:center;">
                <button type="button" id="cancel-create-category" style="padding:12px 24px;border:2px solid #7c3aed;border-radius:12px;color:#7c3aed;background:white;font-weight:600;min-width:140px;">Cancel</button>
                <button type="submit" style="padding:12px 24px;border-radius:12px;background:#7c3aed;color:white;font-weight:600;min-width:140px;">Create</button>
            </div>
        </form>
    </x-modalCM>
    <script>
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
    <script>
    const openBtnCat = document.getElementById('open-create-category');
    const overlayCat = document.getElementById('create-category-modal-overlay');
    const modalCat = document.getElementById('create-category-modal');
    const cancelBtnCat = document.getElementById('cancel-create-category');
    function openCat(){ overlayCat.style.display='block'; modalCat.style.display='block'; }
    function closeCat(){ overlayCat.style.display='none'; modalCat.style.display='none'; }
    if(openBtnCat){ openBtnCat.addEventListener('click', openCat); }
    if(overlayCat){ overlayCat.addEventListener('click', closeCat); }
    if(cancelBtnCat){ cancelBtnCat.addEventListener('click', closeCat); }
</script>
@endsection
