<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Message;
use Illuminate\Http\RedirectResponse;

class MessageController extends Controller
{
    public function index(): View
    {
        $messages = Message::all();

        return view('message.index', compact('messages'));
    }

    public function store(Request $request): RedirectResponse
    {
        Message::create([
            'body' => $request->body
        ]);

        return redirect()->route('messages');
    }
}
