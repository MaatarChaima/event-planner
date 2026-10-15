<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Category;
use Illuminate\Http\Request;

class EventCMController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $events = Event::with('category')->orderByDesc('created_at')->paginate(15);
        
        if ($request->ajax()) {
            $html = '';
            foreach ($events as $event) {
                $html .= view('admin.events.partials.event-rowCM', compact('event'))->render();
            }
            return response()->json([
                'html' => $html,
                'nextPageUrl' => $events->nextPageUrl(),
                'hasMorePages' => $events->hasMorePages()
            ]);
        }

        return view('admin.events.indexCM', compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.events.createCM', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'category_id' => ['required', 'exists:categories,id'],
            'start_date' => ['required', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'place' => ['nullable', 'string', 'max:255'],
            'capacity' => ['required', 'integer', 'min:0'],
            'is_free' => ['required', 'boolean'],
            'price' => ['nullable', 'numeric', 'min:0', 'required_if:is_free,0'],
            'image' => ['nullable', 'string', 'max:1024'],
        ]);

        if ((int)$validated['is_free'] === 1) {
            $validated['price'] = null;
        }
        $validated['status'] = $validated['status'] ?? 'active';

        Event::create($validated);
        return redirect()->route('admin.events.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        return redirect()->route('admin.events.edit', $event);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Event $event)
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.events.editCM', compact('event', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Event $event)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'category_id' => ['required', 'exists:categories,id'],
            'start_date' => ['required', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'place' => ['nullable', 'string', 'max:255'],
            'capacity' => ['required', 'integer', 'min:0'],
            'is_free' => ['required', 'boolean'],
            'price' => ['nullable', 'numeric', 'min:0'],
            'image' => ['nullable', 'string', 'max:1024'],
        ]);
        if ((int)$validated['is_free'] === 1) {
            $validated['price'] = null;
        }
        $event->update($validated);
        return redirect()->route('admin.events.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        $event->delete();
        return redirect()->route('admin.events.index');
    }

    public function archive(Event $event)
    {
        $newStatus = $event->status === 'archived' ? 'active' : 'archived';
        $event->update(['status' => $newStatus]);
        return redirect()->route('admin.events.index');
    }
}
