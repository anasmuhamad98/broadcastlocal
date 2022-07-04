<?php

namespace App\Http\Controllers;

use App\Event\NewChatMessage;
use App\Events\NewChatMessage as EventsNewChatMessage;
use App\Events\RealTimeMessage;
use App\Models\ChatMessage;
use App\Models\ChatRoom;
use App\Models\Eksesais;
use App\Models\Grouper;
use App\Models\ListA;
use App\Models\ListB;
use App\Models\Tack;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ChatController extends Controller
{

    public function index($eksesaisId)
    {
        $eksesais = Eksesais::find($eksesaisId);
        return Inertia::render('Chat/container', [
            'eksesaisdetail' => $eksesais,
        ]);
        // return ChatMessage::where('eksesais_id', $eksesaisId)->where('chat_room_id', $roomId)->with('user')->orderBy('created_at', 'desc')->get();
    }

    public function rooms($eksesaisId)
    {
        return ChatRoom::where('eksesais_id', $eksesaisId)->get();
    }

    public function messages(Request $request,$eksesaisId, $roomId)
    {
        return ChatMessage::with('rooms')->where('eksesais_id', $eksesaisId)->where('chat_room_id', $roomId)->with('user')->orderBy('created_at', 'desc')->get();
    }

    public function newMessage(Request $request, $eksesaisId, $roomId)
    {
        $newMessage = new ChatMessage();
        $newMessage->user_id = Auth::id();
        $newMessage->eksesais_id = $eksesaisId;
        $newMessage->chat_room_id = $roomId;
        $newMessage->message = $request->message;
        $newMessage->action = $request->action;
        $newMessage->save();

        broadcast(new EventsNewChatMessage($newMessage))->toOthers();
        // return $newMessage;
        // event(new EventsNewChatMessage($newMessage));
        // event(new RealTimeMessage('Hello World'));
    }

    public function chatmeaning(Request $request)
    {
        $grouper = $request->message;
        $message = '';
        $patternlist = "/[-]/";
        $splittext = preg_split($patternlist, $grouper);
        $grouper = array_shift($splittext);
        $groupermeaning = Grouper::select('Meaning')->where('Grouper', $grouper)->first()->Meaning ?? null;
        $message .= ' ' . $groupermeaning;
        $checktack = Grouper::select('Tack')->where('Grouper', $grouper)->first()->Tack ?? false;
        $checkfreetexttack = Grouper::select('Free_Text_Tack')->where('Grouper', $grouper)->first()->Free_Text_Tack ?? false;
        $checklista = Grouper::select('List_A')->where('Grouper', $grouper)->first()->List_A ?? false;
        $checklistb = Grouper::select('List_B')->where('Grouper', $grouper)->first()->List_B ?? false;
        $checkfreetextlist = Grouper::select('Free_Text_List')->where('Grouper', $grouper)->first()->Free_Text_List ?? false;

        if($checktack){
            $tack = array_shift($splittext);
            $tackmeaning = Tack::select('Meaning')->where('Grouper', $grouper)->where('Tack', $tack)->first()->Meaning ?? null;
            $message .= ' ' . $tackmeaning;
        }
        if($checkfreetexttack){
            $freetexttack = array_shift($splittext);
            $message .= ' ' . $freetexttack;
        }
        if($checklista){
            $ista = array_shift($splittext);
            $istameaning = ListA::select('Meaning')->where('Grouper', $grouper)->where('List_A', $ista)->first()->Meaning ?? null;
            $message .= ' ' . $istameaning;
        }
        if($checklistb){
            $listb = array_shift($splittext);
            $listbmeaning = ListB::select('Meaning')->where('Grouper', $grouper)->where('List_B', $listb)->first()->Meaning ?? null;
            $message .= ' ' . $listbmeaning;
        }
        if($checkfreetextlist){
            $freetextlist = array_shift($splittext);
            $message .= ' ' . $freetextlist;
        }
        return $message;
    }
}
