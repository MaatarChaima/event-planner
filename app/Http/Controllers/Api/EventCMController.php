<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;

class EventCMController extends Controller
{
    // GET /api/events
    public function index()
    {
        return response()->json(
            Event::with('category')->orderByDesc('created_at')->get()
        );
    }

    // POST /api/events
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
            'image' => ['nullable', 'string'],
        ]);

        if ($validated['is_free']) {
            $validated['price'] = null;
        }

        $validated['status'] = 'active';

        $event = Event::create($validated);

        return response()->json($event, 201);
        
    }

    // GET /api/events/{id}
    public function show(Event $event)
    {
        return response()->json($event->load('category'));
    }

    // PUT /api/events/{id}
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
            'image' => ['nullable', 'string'],
            'status' => ['in:active,archived'],
        ]);

        if ($validated['is_free']) {
            $validated['price'] = null;
        }

        $event->update($validated);

        return response()->json($event);
    }

    // DELETE /api/events/{id}
    public function destroy(Event $event)
    {
        $event->delete();
        return response()->json(['message' => 'Event deleted']);
    }

    // PATCH /api/events/{id}/archive
    public function archive(Event $event)
    {
        $event->update(['status' => 'archived']);
        return response()->json(['message' => 'Event archived']);
    }
}


