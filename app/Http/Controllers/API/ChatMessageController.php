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
        $pageToken = null;
        
        if (isset($params['pageToken'])) {
            Log::debug(print_r($params, true));
            $pageToken = $params['pageToken'];
        }

        $url = "https://www.googleapis.com/youtube/v3/liveChat/messages?part=id,snippet,authorDetails&liveChatId=". $liveChatId . "&maxResults=2000&hl=en";

        if ($pageToken !== null) {
            $url = $url . "&pageToken=" . $pageToken;
        } 
        
        $url = $url . "&key=" . env("GOOGLE_DEVELOPER_KEY");

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        $data = curl_exec($ch);
        curl_close($ch);

        Log::debug(print_r($data, true));

        return response()->json(array('success' => true, 'messages' => json_decode($data)));
    }

    public function storeMessages(Request $request) {
        $data = $request->post();

        $messages = array();
        foreach ($data as $chatMessage) {
            $messages[] = array(
                'id' => $chatMessage['id'],
                'chat_id' => $chatMessage['snippet']['liveChatId'],
                'channel_id' => $chatMessage['snippet']['authorChannelId'],
                'display_name' => $chatMessage['authorDetails']['displayName'],
                'published_at' => strtotime($chatMessage['snippet']['publishedAt']),
                'content' => $chatMessage['snippet']['textMessageDetails']['messageText']
            );
        }

        ChatMessage::insert($messages);

        return response()->json(array('success' => true, 'messages' => $messages));
    }
}