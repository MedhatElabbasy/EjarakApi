<?php

namespace App\Http\Controllers\Api\Chat;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Chat\CreateChatRequest;
use App\Http\Requests\Api\Chat\SendTextMessageRequest;
use App\Http\Resources\Api\Chat\ChatResource;
use App\Http\Resources\Api\Chat\MassageResource;
use App\Models\Chat;
use App\Models\ChatMessages;
use App\Models\User;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function createChat(CreateChatRequest $request)
    {
        $users = $request->users;
        // check if they had a chat before
        $chat = $request->user()->chats()->whereHas('participants', function ($q) use ($users) {
            $q->where('user_id', $users[0]);
        })->first();
        // dd($request);


        //if not, create a new one
        if (empty($chat)) {
            array_push($users, $request->user()->id);
            $chat = Chat::create()->makePrivate($request->isPrivate);
            $chat->participants()->attach($users);
        }

        $success = true;
        return response()->json([
            'chat' => new ChatResource($chat),
            'success' => $success,
        ], 200);
    }

    // Let’s get all conversations of one user

    public function getChats(Request $request)
    {
        $user = $request->user();
        $chats = $user->chats()->with('participants')->get();
        $success = true;
        return response()->json([
            'chats' => $chats,
            'success' => $success,
        ], 200);
    }

    ///////////////Let’s create the function for sending a message, keep in mind that we should check if the sender is a participant in this conversation or not, then we create a new message with the status sen

    public function sendTextMessage(SendTextMessageRequest $request)
    {
        $chat = Chat::find($request->chat_id);
        if ($chat->isParticipant($request->user()->id)) {
            $message = ChatMessages::create([
                'message' => $request->message,
                'chat_id' => $request->chat_id,
                'user_id' => $request->user()->id,
                'data' => json_encode(['seenBy' => [], 'status' => 'sent']) //status = sent, delivered,seen
            ]);
            $success = true;
            $message = new MassageResource($message);
            return response()->json([
                "message" => $message,
                "success" => $success,
            ], 200);
        } else {
            return response()->json([
                'message' => 'not found',
            ], 404);
        }
    }

    // When the users receive the message, they will send a request to change the message status. so we can add them to seenBy array.

    public function messageStatus(Request $request, ChatMessages $message)
    {
        if ($message->chat->isParticipant($request->user()->id)) {
            $messageData = json_decode($message->data);
            array_push($messageData->seenBy, $request->user()->id);
            $messageData->seenBy = array_unique($messageData->seenBy);

            //Check if all participant have seen or not
            if (count($message->chat->participants) - 1 < count($messageData->seenBy)) {
                $messageData->status = 'delivered';
            } else {
                $messageData->status = 'seen';
            }
            $message->data = json_encode($messageData);
            $message->save();
            $message = new MassageResource($message);

            return response()->json([
                'message' => $message,
                'success' => true,
            ], 200);
        } else {
            return response()->json([
                'message' => 'Not found',
                'success' => false,
            ], 404);
        }
    }

    // ..
    public function getChatById(Chat $chat, Request $request)
    {
        if ($chat->isParticipant($request->user()->id)) {
            $messages = $chat->messages()->with('sender')->orderBy('created_at', 'asc')->paginate('150');
            return response()->json([
                'chat' => new ChatResource($chat),
                'messages' => MassageResource::collection($messages)->response()->getData(true),
            ], 200);
        } else {
            return response()->json([
                'message' => 'not found',
            ], 404);
        }
    }

    //
    public function searchUsers(Request $request)
    {
        $users = User::where('email', 'like', "%{$request->email}%")->limit(3)->get();
        return response()->json([
            'users' => $users,
        ], 200);
    }

}