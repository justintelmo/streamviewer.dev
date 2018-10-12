<?php 

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\ChatMessage;

class StatsController extends Controller {
    // Todo: Clean this up for pagination
    public function getMessagesFromDB(Request $request) 
    {
        $params = $request->route()->parameters();
        $chatId = $params['liveChatId'];
        Log::debug($chatId);
        /** \Illuminate\Database\Query\Builder $messagesTable  */
        $messages = ChatMessage::where('chat_id', '=', $chatId)->paginate(15);
        // $messages = ChatMessage::all();
        Log::debug(print_r($messages, true));

        
        return response()->json(array('success' => true, 'messages' => $messages));
    }
}