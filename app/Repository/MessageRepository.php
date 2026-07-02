<?php

namespace App\Repository;

use App\Models\Message;
use Illuminate\Support\Facades\Auth;

class MessageRepository implements MessageRepositoryInterface
{
    public function inbox()
    {
        $messages = Message::where('to_id', Auth::id())
            ->with('sender')
            ->orderBy('created_at', 'desc')
            ->paginate(15);
        return view('pages.Messages.inbox', compact('messages'));
    }

    public function sent()
    {
        $messages = Message::where('from_id', Auth::id())
            ->with('receiver')
            ->orderBy('created_at', 'desc')
            ->paginate(15);
        return view('pages.Messages.sent', compact('messages'));
    }

    public function create()
    {
        $users = \App\Models\User::where('id', '!=', Auth::id())->get();
        return view('pages.Messages.create', compact('users'));
    }

    public function store($request)
    {
        Message::create([
            'from_id' => Auth::id(),
            'to_id' => $request->to_id,
            'subject' => $request->subject,
            'body' => $request->body,
        ]);

        toastr()->success(trans('messages.success'));
        return redirect()->route('messages.inbox');
    }

    public function show($id)
    {
        $message = Message::findOrFail($id);
        if ($message->to_id == Auth::id() && !$message->is_read) {
            $message->markAsRead();
        }
        return view('pages.Messages.show', compact('message'));
    }

    public function destroy($id)
    {
        Message::destroy($id);
        toastr()->error(trans('messages.Delete'));
        return redirect()->back();
    }

    public function getUnreadCount()
    {
        return Message::where('to_id', Auth::id())->where('is_read', false)->count();
    }
}