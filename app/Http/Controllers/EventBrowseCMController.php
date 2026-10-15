<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Event;
use Illuminate\Http\Request;

class EventBrowseCMController extends Controller
{
    public function index(Request $request)
    {
        $query = Event::with('category')
            ->where('status', 'active');

        if ($search = $request->input('q')) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('place', 'like', "%{$search}%");
            });
        }

        if ($categoryId = $request->input('category_id')) {
            $query->where('category_id', $categoryId);
        }

        $events = $query->orderBy('start_date', 'asc')->paginate(6);

        if ($request->ajax()) {
            $html = '';
            foreach ($events as $event) {
                $html .= view('events.partials.event-cardCM', compact('event'))->render();
            }
            return response()->json([
                'html' => $html,
                'nextPageUrl' => $events->nextPageUrl(),
                'hasMorePages' => $events->hasMorePages()
            ]);
        }

        $categories = Category::orderBy('name')->get();

        return view('events.indexCM', compact('events', 'categories'));
    }

    public function show(Event $event)
    {
        $event->load('category');
        
        $relatedEvents = Event::where('category_id', $event->category_id)
            ->where('id', '!=', $event->id)
            ->where('status', 'active')
            ->orderBy('start_date', 'asc')
            ->take(3)
            ->get();

        return view('events.showCM', compact('event', 'relatedEvents'));
    }
}
