<?php

namespace App\Http\Controllers;

use App\Models\chat;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ChatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('chat.dashboard', [
            'chats' => chat::with('user')->latest()->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'message' => 'required|string|max:255'
        ]);

        $request->user()->chats()->create($validated);
        return redirect(route('chat.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(chat $chat)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(chat $chat)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, chat $chat): RedirectResponse
    {
        $this->authorize('update', $chat);
 
        $validated = $request->validate([
            'message' => 'required|string|max:255',
        ]);
 
        $chat->update($validated);
 
        return redirect(route('chat.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(chat $chat): RedirectResponse
    {
        $this->authorize('delete', $chat);

        $chat->delete();

        return redirect(route('chat.index'));
    }
}
