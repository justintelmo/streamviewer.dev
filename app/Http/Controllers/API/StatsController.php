<?php 

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\ChatMessage;

class StatsController extends Controller {
    public function getMessagesFromDB(Request $request) 
    {
        $params = $request->route()->parameters();
        $chatId = $params['liveChatId'];
        /** \Illuminate\Database\Query\Builder $messagesTable  */
        $messages = ChatMessage::where('chat_id', '=', $chatId)->paginate(15);

        $response = array(
            'pagination' => array(
                'total' => $messages->total(),
                'per_page' => $messages->perPage(),
                'current_page' => $messages->currentPage(),
                'last_page' => $messages->lastPage(),
                'from' => $messages->firstItem(),
                'to' => $messages->lastItem()
            ),
            'data' => $messages
        );
        
        return response()->json($response);
    }
}