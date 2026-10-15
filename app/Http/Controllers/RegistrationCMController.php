<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegistrationCMController extends Controller
{
    public function index()
    {
        $registrations = Registration::with('event')
            ->where('user_id', Auth::id())
            ->orderByDesc('created_at')
            ->paginate(15);

        return view('registrations.indexCM', compact('registrations'));
    }

    public function store(Request $request, Event $event)
    {
        $userId = Auth::id();
        if (!$userId) {
            return redirect()->route('login');
        }

        $count = Registration::where('event_id', $event->id)->count();
        if ($count >= (int)$event->capacity) {
            return back()->withErrors(['capacity' => 'Event capacity reached']);
        }

        Registration::firstOrCreate([
            'event_id' => $event->id,
            'user_id' => $userId,
        ]);

        return redirect()->route('eventDetail', $event);
    }

    public function destroy(Event $event)
    {
        $userId = Auth::id();
        if ($userId) {
            Registration::where('event_id', $event->id)
                ->where('user_id', $userId)
                ->delete();
        }
        return redirect()->route('eventDetail', $event);
    }
}
