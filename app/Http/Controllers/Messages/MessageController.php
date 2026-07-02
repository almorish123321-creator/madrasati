<?php

namespace App\Http\Controllers\Messages;

use App\Http\Controllers\Controller;
use App\Repository\MessageRepositoryInterface;
use App\Http\Requests\StoreMessageRequest;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    protected $message;

    public function __construct(MessageRepositoryInterface $message)
    {
        $this->message = $message;
    }

    public function inbox()
    {
        return $this->message->inbox();
    }

    public function sent()
    {
        return $this->message->sent();
    }

    public function create()
    {
        return $this->message->create();
    }

    public function store(StoreMessageRequest $request)
    {
        return $this->message->store($request);
    }

    public function show($id)
    {
        return $this->message->show($id);
    }

    public function destroy(Request $request)
    {
        return $this->message->destroy($request);
    }
}