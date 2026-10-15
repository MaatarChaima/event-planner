@extends('components.layouts.adminCM')
@section('content')
    <h1 style="color:#111827;font-size:32px;font-weight:bold;text-align:center;margin:0 0 24px;">Edit Event</h1>
    <form method="POST" action="{{ route('admin.events.update', $event) }}" style="max-width:900px;margin:0 auto;">
        @csrf
        @method('PUT')
        <div style="display:grid;grid-template-columns:1fr 1fr;column-gap:24px;row-gap:24px;">
            <div style="grid-column:1 / -1;">
                <label style="display:block;margin-bottom:8px;">Event Title</label>
                <input type="text" name="title" value="{{ old('title', $event->title) }}" placeholder="Title" style="width:100%;padding:14px;border:1px solid #e5e7eb;border-radius:12px;">
            </div>
            <div style="grid-column:1 / -1;">
                <label style="display:block;margin-bottom:8px;">Category</label>
                <select name="category_id" style="width:100%;padding:14px;border:1px solid #e5e7eb;border-radius:12px;">
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" @selected(old('category_id', $event->category_id)==$category->id)>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label style="display:block;margin-bottom:8px;">Start date</label>
                <input type="datetime-local" name="start_date" value="{{ old('start_date', $event->start_date->format('Y-m-d\\TH:i')) }}" style="width:100%;padding:14px;border:1px solid #e5e7eb;border-radius:12px;">
            </div>
            <div>
                <label style="display:block;margin-bottom:8px;">End date</label>
                <input type="datetime-local" name="end_date" value="{{ old('end_date', optional($event->end_date)->format('Y-m-d\\TH:i')) }}" style="width:100%;padding:14px;border:1px solid #e5e7eb;border-radius:12px;">
            </div>
            <div>
                <label style="display:block;margin-bottom:8px;">Place</label>
                <input type="text" name="place" value="{{ old('place', $event->place) }}" placeholder="Place" style="width:100%;padding:14px;border:1px solid #e5e7eb;border-radius:12px;">
            </div>
            <div>
                <label style="display:block;margin-bottom:8px;">Capacity</label>
                <input type="number" name="capacity" value="{{ old('capacity', $event->capacity) }}" placeholder="Capacity" style="width:100%;padding:14px;border:1px solid #e5e7eb;border-radius:12px;">
            </div>
            <div>
                <label style="display:block;margin-bottom:8px;">Pricing</label>
                <select id="pricing-select-edit" name="is_free" style="width:100%;padding:14px;border:1px solid #e5e7eb;border-radius:12px;">
                    <option value="1" @selected(old('is_free', $event->is_free)==1)>Free Access</option>
                    <option value="0" @selected(old('is_free', $event->is_free)==0)>Paid</option>
                </select>
            </div>
            <div>
                <label style="display:block;margin-bottom:8px;">Amount</label>
                <input id="price-input-edit" type="number" step="0.01" name="price" value="{{ old('price', $event->price) }}" placeholder="Amount" @disabled(old('is_free', $event->is_free)==1) @required(old('is_free', $event->is_free)==0) style="width:100%;padding:14px;border:1px solid #e5e7eb;border-radius:12px;opacity:{{ old('is_free', $event->is_free)==1 ? '.5' : '1' }};background:{{ old('is_free', $event->is_free)==1 ? '#f3f4f6' : 'white' }};">
            </div>
        </div>
        <h2 style="margin-top:24px;color:#111827;font-size:24px;font-weight:700;text-align:center;">Event Description</h2>
        <div>
            <label>Event Image</label>
            <textarea rows="6" name="image" style="width:100%;height:220px;padding:12px;border:1px solid #e5e7eb;border-radius:12px;background:#f3f4f6;">{{ old('image', $event->image) }}</textarea>
        </div>
        <div style="margin-top:12px;">
            <label>Event Description</label>
            <textarea name="description" rows="6" placeholder="Type here..." style="width:100%;padding:12px;border:1px solid #e5e7eb;border-radius:12px;">{{ old('description', $event->description) }}</textarea>
        </div>
        <button type="submit" style="display:block;width:100%;background:#7c3aed;color:white;padding:12px 20px;border-radius:8px;margin-top:24px;">Save</button>
    </form>
@endsection
<script>
    const sE = document.getElementById('pricing-select-edit');
    const pE = document.getElementById('price-input-edit');
    function uE(){ if(sE && pE){ if(sE.value==='0'){ pE.disabled=false; pE.required=true; pE.style.opacity='1'; pE.style.background='white'; } else { pE.disabled=true; pE.required=false; pE.value=''; pE.style.opacity='.5'; pE.style.background='#f3f4f6'; } } }
    uE();
    if(sE){ sE.addEventListener('change', uE); }
</script>
