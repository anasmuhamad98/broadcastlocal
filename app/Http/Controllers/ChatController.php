<?php

namespace App\Http\Controllers;

use App\Events\NewChatMessage as EventsNewChatMessage;
use App\Events\NewGroupChat;
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
use Carbon\Carbon;
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
        return $user->rooms()->where('eksesais_id', $eksesaisId)->where('isShow', 1)->get();
        // return ChatRoom::where('eksesais_id', $eksesaisId)->get();
    }

    public function users_room($roomId)
    {
        $usersOnRoom = ChatRoom::find($roomId)->users()->get();
        $pluckusersOnRoom = ChatRoom::find($roomId)->users()->pluck('shortform')->implode(',');
        return response()->json(['usersOnRoom' => $usersOnRoom, 'pluckusersOnRoom' => $pluckusersOnRoom]);
    }

    public function newRoom(Request $request, $eksesaisId)
    {
        $senaraiKapalTerlibat = $request->senaraiKapalTerlibat;
        $newRoom = new ChatRoom();
        $newRoom->eksesais_id = $eksesaisId;
        $newRoom->name = $request->roomName;
        $newRoom->isShow = 1;
        $newRoom->shortform = $request->shortform;
        $newRoom->save();

        $newRoom->users()->attach($senaraiKapalTerlibat);

        broadcast(new NewGroupChat($eksesaisId))->toOthers();
        // return response()->json([ 'test' => $senaraiKapalTerlibat ]);
    }

    public function messages(Request $request, $eksesaisId)
    {
        $user = User::find(Auth::id());
        $chatrooms = $user->rooms()->where('eksesais_id', $eksesaisId)->get();
        $chatrooms = $chatrooms->pluck('id');
        $mesejbawah = ChatMessage::with('rooms')->where('eksesais_id', $eksesaisId)
            ->where(function ($query) {
                $query->where('action', '!=', 'IX')
                    ->orWhereNull('action');
            })
            ->whereIn('chat_room_id', $chatrooms)->with('callsign')->orderBy('created_at', 'desc')->get();
        $mesejatas = ChatMessage::with('rooms')->where('eksesais_id', $eksesaisId)->where('action', 'IX')->whereIn('chat_room_id', $chatrooms)->with('callsign')->orderBy('created_at', 'desc')->get();
        return response()->json(['mesejbawah' => $mesejbawah, 'mesejatas' => $mesejatas]);
    }

    public function newMessage(Request $request, $eksesaisId, $roomId)
    {
        $sender = User::find(Auth::id());
        if ($request->individual == true) {
            $receiver = User::find($request->pluckusersOnRoom);
            $checkindividual = ChatRoom::where('eksesais_id', $eksesaisId)->where(function ($query) use ($sender, $receiver) {
                $query->where('name', $receiver->name . '-' . $sender->name)->orWhere('name', $sender->name . '-' . $receiver->name);
            })->first();

            if ($checkindividual) {
            } else {
                $newRoom = new ChatRoom;
                $newRoom->eksesais_id = $eksesaisId;
                $newRoom->name = $receiver->name . '-' . $sender->name;
                $newRoom->shortform = $receiver->shortform . '-' . $sender->shortform;
                $newRoom->isShow = 0;
                $newRoom->save();

                $newRoom->users()->attach([$request->pluckusersOnRoom, Auth::id()]);
                $roomId = $newRoom->id;
            }
            $request->pluckusersOnRoom = $receiver->callsign->callsign;
        }
        $newMessage = new ChatMessage();
        $newMessage->user_id = Auth::id();
        $newMessage->eksesais_id = $eksesaisId;
        $newMessage->chat_room_id = $roomId;
        $newMessage->message = $request->message;
        $newMessage->sender = $request->sendercallsign ?? $sender->callsign->callsign;
        $newMessage->receiver = $request->pluckusersOnRoom;
        $newMessage->action = $request->action;
        $newMessage->senddate = Carbon::now();
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
        // return $receiver = User::find(1)->with('callsign');
        // return ChatRoom::find(1)->users()->pluck('users.shortform');
        // $user = User::find(Auth::id());
        // $chatrooms =  $user->rooms()->where('eksesais_id', 1)->get();
        // return $chatrooms->pluck('id');
        // return $users = ChatRoom::find(1)->users()->where('users.id', '!=', Auth::id())->pluck('users.name');
        // $teadtasd = $request->message;

        // return $groupermeaning = Grouper::select('Grouper', 'Meaning')->where('Grouper', 'like', '%A%')->take(5)->get();
        // User::all();
        $user = User::all();
        return $user->toJson(JSON_PRETTY_PRINT);
        // return response()->json( User::all());
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

    public function updateIXMessage($eksesaisId, $roomId, $messageId)
    {
        $chatMessage = ChatMessage::find($messageId);
        $chatMessage->action = '-IX';
        $chatMessage->update();

        $newMessage = new ChatMessage();
        $newMessage->user_id = Auth::id();
        $newMessage->eksesais_id = $eksesaisId;
        $newMessage->chat_room_id = $roomId;
        $newMessage->message = $chatMessage->message . ' STANDBY EXEC';
        $newMessage->sender = $chatMessage->sender;
        $newMessage->receiver = $chatMessage->receiver;
        $newMessage->action = 'TIME';
        $newMessage->save();

        $users = ChatRoom::find($roomId)->users()->where('users.id', '!=', Auth::id())->pluck('users.id');
        $attributes = ['newMessage' => 1];
        ChatRoom::find($roomId)->users()->updateExistingPivot($users, $attributes);

        broadcast(new EventsNewChatMessage($newMessage))->toOthers();
        // $seenmessage->newMessage = 1;

        // $seenmessage->update();
    }


    public function chatmeaning(Request $request)
    {
        $grouper = $request->message;
        $message = "";
        $patternlist = "/[-]/";
        $splittext = preg_split($patternlist, $grouper);
        while (count($splittext) > 0) {

            $grouper = array_shift($splittext);
            $groupermeaning = Grouper::select('Meaning')->where('Grouper', $grouper)->first()->Meaning ?? null;
            $message .= '' . $groupermeaning;
            $checktack1 = Grouper::select('Tack_1')->where('Grouper', $grouper)->first()->Tack_1 ?? false;
            $checktack2 = Grouper::select('Tack_2')->where('Grouper', $grouper)->first()->Tack_2 ?? false;
            $checktack3 = Grouper::select('Tack_3')->where('Grouper', $grouper)->first()->Tack_3 ?? false;
            $checktack4 = Grouper::select('Tack_4')->where('Grouper', $grouper)->first()->Tack_4 ?? false;
            $checkfreetexttack1 = Grouper::select('Free_Text_Tack_1')->where('Grouper', $grouper)->first()->Free_Text_Tack_1 ?? false;
            $checkfreetexttack2 = Grouper::select('Free_Text_Tack_2')->where('Grouper', $grouper)->first()->Free_Text_Tack_2 ?? false;
            $checkfreetexttack3 = Grouper::select('Free_Text_Tack_3')->where('Grouper', $grouper)->first()->Free_Text_Tack_3 ?? false;
            $checkfreetexttack4 = Grouper::select('Free_Text_Tack_4')->where('Grouper', $grouper)->first()->Free_Text_Tack_4 ?? false;
            $checkfreetexttack5 = Grouper::select('Free_Text_Tack_5')->where('Grouper', $grouper)->first()->Free_Text_Tack_5 ?? false;
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
                    if (str_contains($message, 'Table_Group')) {
                        $message = str_replace('Table_Group', $tablegroupermeaning, $message);
                    } else {
                        $message .= " | " . $tablegroupermeaning;
                    }
                } else {
                    if ($checktack1) {
                        $tack = array_shift($splittext);
                        $splittack = explode(" ", $tack);
                        $tackmeaning = '';
                        while (count($splittack) > 0) {
                            $tackchar = array_shift($splittack);
                            $tackcharmeaning = Tack::select('Meaning')->where('Grouper', $grouper)->where('Tack', $tackchar)->first()->Meaning ?? 'asd';
                            $tackmeaning .= ' ' . $tackcharmeaning;
                        }
                        if (str_contains($message, 'Tack_1')) {
                            $message = str_replace('Tack_1', $tackmeaning, $message);
                        } else {
                            $message .= " | " . $tackmeaning;
                        }
                    }

                    if ($checkfreetexttack1) {
                        $checkifnextitemisgrouper = Grouper::select('Meaning')->where('Grouper', $splittext[0] ?? null)->first() ? true : false;
                        if ($checkifnextitemisgrouper) {
                        } else {
                            $freetexttack1 = array_shift($splittext) ?? 'Free_Text_Tack';
                            $freetexttack1 = str_replace('DSG', '', $freetexttack1);

                            if (str_contains($message, 'Free_Text_Tack_1')) {
                                $message = str_replace('Free_Text_Tack_1', $freetexttack1, $message);
                            } else {
                                $message .= " | " . $freetexttack1;
                            }
                        }
                    }
                    if ($checktack2) {
                        $tack = array_shift($splittext);
                        $splittack = explode(" ", $tack);
                        $tackmeaning = '';
                        while (count($splittack) > 0) {
                            $tackchar = array_shift($splittack);
                            $tackcharmeaning = Tack::select('Meaning')->where('Grouper', $grouper)->where('Tack', $tackchar)->first()->Meaning ?? null;
                            $tackmeaning .= ' ' . $tackcharmeaning;
                        }
                        if (str_contains($message, 'Tack_2')) {
                            $message = str_replace('Tack_2', $tackmeaning, $message);
                        } else {
                            $message .= " | " . $tackmeaning;
                        }
                    }

                    if ($checkfreetexttack2) {
                        $checkifnextitemisgrouper = Grouper::select('Meaning')->where('Grouper', $splittext[0] ?? null)->first() ? true : false;
                        if ($checkifnextitemisgrouper) {
                        } else {
                            $freetexttack2 = array_shift($splittext) ?? 'Free_Text_Tack';
                            $freetexttack2 = str_replace('DSG', '', $freetexttack2);
                            if (str_contains($message, 'Free_Text_Tack_2')) {
                                $message = str_replace('Free_Text_Tack_2', $freetexttack2, $message);
                            } else {
                                $message .= " | " . $freetexttack2;
                            }
                        }
                    }
                    if ($checktack3) {
                        $tack = array_shift($splittext);
                        $splittack = explode(" ", $tack);
                        $tackmeaning = '';
                        while (count($splittack) > 0) {
                            $tackchar = array_shift($splittack);
                            $tackcharmeaning = Tack::select('Meaning')->where('Grouper', $grouper)->where('Tack', $tackchar)->first()->Meaning ?? null;
                            $tackmeaning .= ' ' . $tackcharmeaning;
                        }
                        if (str_contains($message, 'Tack_3')) {
                            $message = str_replace('Tack_3', $tackmeaning, $message);
                        } else {
                            $message .= " | " . $tackmeaning;
                        }
                    }

                    if ($checkfreetexttack3) {
                        $checkifnextitemisgrouper = Grouper::select('Meaning')->where('Grouper', $splittext[0] ?? null)->first() ? true : false;
                        if ($checkifnextitemisgrouper) {
                        } else {
                            $freetexttack3 = array_shift($splittext) ?? 'Free_Text_Tack';
                            $freetexttack3 = str_replace('DSG', '', $freetexttack3);
                            if (str_contains($message, 'Free_Text_Tack_3')) {
                                $message = str_replace('Free_Text_Tack_3', $freetexttack3, $message);
                            } else {
                                $message .= " | " . $freetexttack3;
                            }
                        }
                    }
                    if ($checktack4) {
                        $tack = array_shift($splittext);
                        $splittack = explode(" ", $tack);
                        $tackmeaning = '';
                        while (count($splittack) > 0) {
                            $tackchar = array_shift($splittack);
                            $tackcharmeaning = Tack::select('Meaning')->where('Grouper', $grouper)->where('Tack', $tackchar)->first()->Meaning ?? null;
                            $tackmeaning .= ' ' . $tackcharmeaning;
                        }
                        if (str_contains($message, 'Tack_4')) {
                            $message = str_replace('Tack_4', $tackmeaning, $message);
                        } else {
                            $message .= " | " . $tackmeaning;
                        }
                    }
                    if ($checkfreetexttack4) {
                        $checkifnextitemisgrouper = Grouper::select('Meaning')->where('Grouper', $splittext[0] ?? null)->first() ? true : false;
                        if ($checkifnextitemisgrouper) {
                        } else {
                            $freetexttack4 = array_shift($splittext) ?? 'Free_Text_Tack';
                            $freetexttack4 = str_replace('DSG', '', $freetexttack4);
                            if (str_contains($message, 'Free_Text_Tack_4')) {
                                $message = str_replace('Free_Text_Tack_4', $freetexttack4, $message);
                            } else {
                                $message .= " | " . $freetexttack4;
                            }
                        }
                    }
                    // if ($checkfreetexttack5) {
                    //     $checkifnextitemisgrouper = Grouper::select('Meaning')->where('Grouper', $splittext[0] ?? null)->first() ? true : false;
                    //     if ($checkifnextitemisgrouper) {
                    //     } else {
                    //         $freetexttack5 = array_shift($splittext) ?? 'Free_Text_Tack';
                    //         $freetexttack5 = str_replace('DSG', '', $freetexttack5);
                    //         if (str_contains($message, 'Free_Text_Tack_5')) {
                    //             $message = str_replace('Free_Text_Tack_5', $freetexttack5, $message);
                    //         } else {
                    //             $message .= " | " . $freetexttack5;
                    //         }
                    //     }
                    // }
                    if ($checklista) {
                        $ista = array_shift($splittext);
                        $istameaning = ListA::select('Meaning')->where('Grouper', $grouper)->where('List_A', $ista)->first()->Meaning ?? '(List A)';
                        if (str_contains($message, 'List_A')) {
                            $message = str_replace('List_A', $istameaning, $message);
                        } else {
                            $message .= " | " . $istameaning;
                        }
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

                        if (str_contains($message, 'List_B')) {
                            $message = str_replace('List_B', $listbmeaning, $message);
                        } else {
                            $message .= " | " . $listbmeaning;
                        }
                    }
                    if ($checklistc) {
                        $istc = array_shift($splittext);
                        $istcmeaning = ListC::select('Meaning')->where('Grouper', $grouper)->where('List_c', $istc)->first()->Meaning ?? '(List C)';


                        if (str_contains($message, 'List_C')) {
                            $message = str_replace('List_C', $istcmeaning, $message);
                        } else {
                            $message .= " | " . $istcmeaning;
                        }
                    }
                    if ($checkfreetextlist) {
                        $freetextlist = array_shift($splittext);

                        if (str_contains($message, 'Free_Text_List')) {
                            $message = str_replace('Free_Text_List', $freetextlist, $message);
                        } else {
                            $message .= " | " . $freetextlist;
                        }
                    }

                    $checkfortablegrouper = TableGrouper::select('Table_Grouper', 'Meaning')->where('Table_Grouper', $splittext[0] ?? null)->first()->Table_Grouper ?? null;
                    if ($checkfortablegrouper) {
                        $tablegrouper = array_shift($splittext);
                        $tablegroupermeaning = TableGrouper::select('Meaning')->where('Table_Grouper', $tablegrouper)->first()->Meaning ?? null;
                        if (str_contains($message, 'Table_Group')) {
                            $message = str_replace('Table_Group', $tablegroupermeaning, $message);
                        } else {
                            $message .= " | " . $tablegroupermeaning;
                        }
                    }
                }
            }


            $message .= "\n";
        }
        return response()->json(['message' => $message]);
        // return $message;
    }

    public function quickguide()
    {
    }
}
