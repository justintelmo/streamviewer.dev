<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Models\ChatMessage;


class ChatMessageController extends Controller {
    public function getMessages(Request $request) {
        $params = $request->route()->parameters();
        $liveChatId = $params['liveChatId'];
        $ch = curl_init(
            "https://www.googleapis.com/youtube/v3/liveChat/messages?part=id,snippet,authorDetails&liveChatId=". $liveChatId
            ."&maxResults=2000&hl=en&key=" . env("GOOGLE_DEVELOPER_KEY")
        );
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        $data = curl_exec($ch);
        curl_close($ch);

        return response()->json(array('success' => true, 'messages' => json_decode($data)));
    }

    public function storeMessages(Request $request) {
        $data = $request->post();

        $messages = array();
        foreach ($data['messages']['items'] as $chatMessage) {
            $messages[] = array(
                'id' => $chatMessage['id'],
                'chat_id' => $chatMessage['snippet']['liveChatId'],
                'channel_id' => $chatMessage['snippet']['authorChannelId'],
                'display_name' => $chatMessage['authorDetails']['displayName'],
                'published_at' => strtotime($chatMessage['snippet']['publishedAt']),
                'content' => $chatMessage['snippet']['textMessageDetails']['messageText']
            );
        }

        Log::debug(print_r($messages, true));

        ChatMessage::insert($messages);

        return response()->json(array('success' => true, 'messages' => $messages));
    }
}