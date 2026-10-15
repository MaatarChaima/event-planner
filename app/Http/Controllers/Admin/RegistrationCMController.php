<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Registration;
use Illuminate\Http\Request;

class RegistrationCMController extends Controller
{
    public function index()
    {
        $registrations = Registration::with(['event','user'])
            ->orderByDesc('created_at')
            ->paginate(20);
        return view('admin.registrations.indexCM', compact('registrations'));
    }
}
