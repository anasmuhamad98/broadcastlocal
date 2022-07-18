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
use App\Models\ListC;
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

    public function testets(Request $request)
    {
        $teadtasd = $request->message;

        $groupermeaning = Grouper::select('Grouper', 'Meaning')->where('Grouper','like', '%A%')->take(5)->get();
        return response()->json(['teadtasd' => $groupermeaning]);
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
        $patternlist = "/[-]/";
        $splittext = preg_split($patternlist, $grouper);
        while (count($splittext) > 0) {

            $grouper = array_shift($splittext);
            $groupermeaning = Grouper::select('Meaning')->where('Grouper', $grouper)->first()->Meaning ?? null;
            $message .= '' . $groupermeaning;
            $checktack = Grouper::select('Tack')->where('Grouper', $grouper)->first()->Tack ?? false;
            $checkfreetexttack = Grouper::select('Free_Text_Tack')->where('Grouper', $grouper)->first()->Free_Text_Tack ?? false;
            $checklista = Grouper::select('List_A')->where('Grouper', $grouper)->first()->List_A ?? false;
            $checklistb = Grouper::select('List_B')->where('Grouper', $grouper)->first()->List_B ?? false;
            $checklistc = Grouper::select('List_C')->where('Grouper', $grouper)->first()->List_C ?? false;
            $checkfreetextlist = Grouper::select('Free_Text_List')->where('Grouper', $grouper)->first()->Free_Text_List ?? false;

            $checkifnextitemisgrouper = Grouper::select('Meaning')->where('Grouper', $splittext[0] ?? null)->first() ? true : false;

            if ($checkifnextitemisgrouper) {
            } else {

                $checkfortablegrouper = TableGrouper::select('Table_Grouper', 'Meaning')->where('Table_Grouper', $splittext[0] ?? null)->first() ? true : false;
                if ($checkfortablegrouper) {
                    $tablegrouper = array_shift($splittext);
                    $tablegroupermeaning = TableGrouper::select('Meaning')->where('Table_Grouper', $tablegrouper)->first()->Meaning ?? null;
                    $message .= ' | ' . $tablegroupermeaning;
                } else {
                    if ($checktack) {
                        $tack = array_shift($splittext);
                        $splittack = explode(" ", $tack);
                        $tackmeaning = '';
                        while (count($splittack) > 0) {
                            $tackchar = array_shift($splittack);
                            $tackcharmeaning = Tack::select('Meaning')->where('Grouper', $grouper)->where('Tack', $tackchar)->first()->Meaning ?? null;
                            $tackmeaning .= ' ' . $tackcharmeaning;
                        }
                        $message .= ' | ' . $tackmeaning;
                    }
                    if ($checkfreetexttack) {
                        $checkifnextitemisgrouper = Grouper::select('Meaning')->where('Grouper', $splittext[0] ?? null)->first() ? true : false;
                        if ($checkifnextitemisgrouper) {
                        } else {
                            $freetexttack = array_shift($splittext);
                            $freetexttack = str_replace('DSG', '', $freetexttack);
                            $message .= ' | ' . $freetexttack;
                        }
                    }
                    if ($checklista) {
                        $ista = array_shift($splittext);
                        $istameaning = ListA::select('Meaning')->where('Grouper', $grouper)->where('List_A', $ista)->first()->Meaning ?? '(List A)';
                        // $message = str_replace('(List A)', $istameaning, $message);
                        $message .= ' | ' . $istameaning;
                    }
                    if ($checklistb) {
                        $listb = array_shift($splittext);
                        $splitcharlistb = str_split($listb);
                        $listbmeaning = '';
                        while (count($splitcharlistb) > 0) {
                            // return 'asdasd';
                            $listbchar = array_shift($splitcharlistb);
                            $listbcharmeaning = ListB::select('Meaning')->where('Grouper', $grouper)->where('List_B', $listbchar)->first()->Meaning ?? '(List B)';
                            $listbmeaning .= ' ' . $listbcharmeaning;
                        }
                        // $message = str_replace('(List B)', $listbmeaning, $message);
                        $message .= ' | ' . $listbmeaning;
                    }
                    if ($checklistc) {
                        $istc = array_shift($splittext);
                        $istcmeaning = ListC::select('Meaning')->where('Grouper', $grouper)->where('List_c', $istc)->first()->Meaning ?? '(List C)';
                        // $message = str_replace('(List C)', $istcmeaning, $message);
                        $message .= ' | ' . $istcmeaning;
                    }
                    if ($checkfreetextlist) {
                        $freetextlist = array_shift($splittext);
                        $message .= ' | ' . $freetextlist;
                    }

                    $checkfortablegrouper = TableGrouper::select('Table_Grouper', 'Meaning')->where('Table_Grouper', $splittext[0] ?? null)->first()->Table_Grouper ?? null;
                    if ($checkfortablegrouper) {
                        $tablegrouper = array_shift($splittext);
                        $tablegroupermeaning = TableGrouper::select('Meaning')->where('Table_Grouper', $tablegrouper)->first()->Meaning ?? null;
                        $message .= ' | ' . $tablegroupermeaning;
                    }
                }
            }


            $message .= '
';
        }
        return $message;
    }

    public function quickguide()
    {
    }
}
