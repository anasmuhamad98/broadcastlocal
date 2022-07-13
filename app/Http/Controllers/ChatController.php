<?php

namespace App\Http\Controllers;

use App\Events\NewChatMessage as EventsNewChatMessage;
use App\Events\NewMessageNotification;
use App\Events\RealTimeMessage;
use App\Models\ChatMessage;
use App\Models\ChatRoom;
use App\Models\ChatRoomUser;
use App\Models\Eksesais;
use App\Models\Grouper;
use App\Models\ListA;
use App\Models\ListB;
use App\Models\TableGrouper;
use App\Models\Tack;
use App\Models\User;
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
        $user = User::find(Auth::id());
        return $user->rooms()->where('eksesais_id', $eksesaisId)->get();
        // return ChatRoom::where('eksesais_id', $eksesaisId)->get();
    }

    public function newRoom(Request $request, $eksesaisId)
    {
        $senaraiKapalTerlibat = $request->senaraiKapalTerlibat;
        $newRoom = new ChatRoom();
        $newRoom->eksesais_id = $eksesaisId;
        $newRoom->name = $request->roomName;
        $newRoom->save();

        $newRoom->users()->attach($senaraiKapalTerlibat);
        // return response()->json([ 'test' => $senaraiKapalTerlibat ]);
    }

    public function messages(Request $request, $eksesaisId, $roomId)
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

        $users = ChatRoom::find($roomId)->users()->where('users.id', '!=', Auth::id())->pluck('users.id');
        $attributes = ['newMessage' => 1];
        ChatRoom::find($roomId)->users()->updateExistingPivot($users, $attributes);

        broadcast(new EventsNewChatMessage($newMessage))->toOthers();
        // return $newMessage;
        // event(new EventsNewChatMessage($newMessage));
        // event(new RealTimeMessage('Hello World'));
    }

    public function testets($eksesaisId, $roomId)
    {
        // return response()->json([ 'test' => 'asd?S' ]);
        // return ChatRoom::with('users')->where('eksesais_id', $eksesaisId)->get();

        $attributes = ['newMessage' => 1];
        return ChatRoom::find($roomId)->users()->where('users.id', '!=', Auth::id())->pluck('users.id');
        // ()->updateExistingPivot([1,2,3], $attributes);

    }

    public function updateseenmessage($eksesaisId, $roomId)
    {

        $seenmessage = User::find(Auth::id());

        $attributes = ['newMessage' => 0];
        $seenmessage->rooms()->where('eksesais_id', $eksesaisId)->updateExistingPivot($roomId, $attributes);

        // event(new NewMessageNotification($eksesaisId));
        // broadcast(new NewMessageNotification($eksesaisId))->toOthers();
        // $seenmessage->newMessage = 1;

        // $seenmessage->update();
    }


    public function chatmeaning(Request $request)
    {
        $grouper = $request->message;
        $message = '';
        $firstsplits = preg_split("#/#", $grouper);
        $patternlist = "/[-]/";
        foreach ($firstsplits as $firstsplit) {
            $splittext = preg_split($patternlist, $firstsplit);
            $grouper = array_shift($splittext);
            $groupermeaning = Grouper::select('Meaning')->where('Grouper', $grouper)->first()->Meaning ?? null;
            $message .= ' ' . $groupermeaning;
            $checktack = Grouper::select('Tack')->where('Grouper', $grouper)->first()->Tack ?? false;
            $checkfreetexttack = Grouper::select('Free_Text_Tack')->where('Grouper', $grouper)->first()->Free_Text_Tack ?? false;
            $checklista = Grouper::select('List_A')->where('Grouper', $grouper)->first()->List_A ?? false;
            $checklistb = Grouper::select('List_B')->where('Grouper', $grouper)->first()->List_B ?? false;
            $checkfreetextlist = Grouper::select('Free_Text_List')->where('Grouper', $grouper)->first()->Free_Text_List ?? false;

            if ($checktack) {
                $tack = array_shift($splittext);
                $tackmeaning = Tack::select('Meaning')->where('Grouper', $grouper)->where('Tack', $tack)->first()->Meaning ?? null;
                $message .= ' ' . $tackmeaning;
            }
            if ($checkfreetexttack) {
                $freetexttack = array_shift($splittext);
                $message .= ' ' . $freetexttack;
            }
            if ($checklista) {
                $ista = array_shift($splittext);
                $istameaning = ListA::select('Meaning')->where('Grouper', $grouper)->where('List_A', $ista)->first()->Meaning ?? null;
                $message .= ' ' . $istameaning;
            }
            if ($checklistb) {
                $listb = array_shift($splittext);
                $listbmeaning = ListB::select('Meaning')->where('Grouper', $grouper)->where('List_B', $listb)->first()->Meaning ?? null;
                $message .= ' ' . $listbmeaning;
            }
            if ($checkfreetextlist) {
                $freetextlist = array_shift($splittext);
                $message .= ' ' . $freetextlist;
            }

            $tablegrouper = array_shift($splittext);
            $tablegroupermeaning = TableGrouper::select('Meaning')->where('Table_Grouper', $tablegrouper)->first()->Meaning ?? null;
            $message .= ' ' . $tablegroupermeaning;
        }
        return $message;
    }
}
