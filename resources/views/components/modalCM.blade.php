@props(['id' => 'modal', 'title' => ''])
<div id="{{ $id }}-overlay" style="position:fixed;inset:0;background:rgba(0,0,0,.6);display:none;z-index:999;"></div>
<div id="{{ $id }}" style="position:fixed;left:50%;top:50%;transform:translate(-50%,-50%);background:white;border-radius:12px;box-shadow:0 10px 20px rgba(0,0,0,.2);width:420px;max-width:90%;padding:40px;display:none;z-index:1000;">
    @if($title)
        <h2 style="margin-top:0;margin-bottom:16px;text-align:center;">{{ $title }}</h2>
    @endif
    <div>
        {{ $slot }}
    </div>
</div>
