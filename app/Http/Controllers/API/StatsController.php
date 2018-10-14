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
        $chatId = $request->chatId;
        $sortBy = $request->sortBy;
        $sortDir = $request->sortDir;
        $search = strip_tags($request->search);

        Log::debug($request->fullUrl());

        /** \Illuminate\Database\Query\Builder $messagesTable  */
        $messages = ChatMessage::where('chat_id', '=', $chatId);
        
        if (isset($request->search)) {
            $messages = $messages->where('display_name', 'like', '%' . $search . '%');
        }

        if (isset($sortBy)) {
            if (isset($sortDir) && $sortDir == 'desc') {
                $messages = $messages->orderBy($sortBy, 'desc');
            } else {
                $messages = $messages->orderBy($sortBy);
            }
        }

        $messages = $messages->paginate(25);

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