<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class KasirController extends Controller
{
    public function index(): View
    {
        return view('dashboard', [
            'user' => Auth::user(),
        ]);
    }
}
