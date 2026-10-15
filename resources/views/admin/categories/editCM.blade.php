@extends('components.layouts.adminCM')
@section('content')
    <h1>Edit category</h1>
    <form method="POST" action="{{ route('admin.categories.update', $category) }}" style="max-width:480px;">
        @csrf
        @method('PUT')
        <div style="margin-bottom:12px;">
            <label>Category name</label>
            <input type="text" name="name" value="{{ old('name', $category->name) }}" style="width:100%;padding:8px;border:1px solid #e5e7eb;border-radius:6px;">
        </div>
        <button type="submit" style="background:#7c3aed;color:white;padding:8px 12px;border-radius:6px;">Save</button>
        <a href="{{ route('admin.categories.index') }}" style="margin-left:8px;">Cancel</a>
    </form>
    <form method="POST" action="{{ route('admin.categories.destroy', $category) }}" style="margin-top:16px;">
        @csrf
        @method('DELETE')
        <button type="submit" style="color:#991b1b;">Delete</button>
    </form>
@endsection
