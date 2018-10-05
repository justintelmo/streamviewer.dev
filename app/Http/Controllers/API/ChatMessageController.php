<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use App\Models\ChatMessages;


class ChatMessageController extends Controller {
    public function getMessages() {
        $liveChatId = $_GET['liveChatId'];
        $ch = curl_init(
            "https://www.googleapis.com/youtube/v3/liveChat/messages?part=id,snippet&liveChatId=". $liveChatId
            ."&maxResults=2000&hl=en&key=" . env("GOOGLE_DEVELOPER_KEY")
        );
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        $data = curl_exec($ch);
        curl_close($ch);

        return response()->json(array('success' => true, 'messages' => $data));
    }

    public function storeMessages() {
        $messages = $_POST['messages'];
        
        return response()->json(array('success' => true));
    }
}