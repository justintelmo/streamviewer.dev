<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Web\AuthenticationController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\Streams;

use Google_Client;
use Google_Service_YouTube;
use Google_Service_People;

use Request;

use Socialite;
use Exception;

define('CREDENTIALS_PATH', '~/Documents/GitHub/streamviewer.dev/php-yt-oauth2.json');
define('STDIN', fopen("php://stdin", "r"));

class StreamsController extends Controller
{
    public function getStreams()
    {
        $ch = curl_init(
            "https://www.googleapis.com/youtube/v3/search?part=id,snippet&eventType=live&type=video&videoCategoryId=20&regionCode=US&maxResults=40&key=" . env("GOOGLE_DEVELOPER_KEY")
        );
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        $data = curl_exec($ch);
        curl_close($ch);

        return response()->json( array('success' => true, 'streams' => json_decode($data) ) );
    }

    public function getStream( $id )
    {
        $ch = curl_init(
            "https://www.googleapis.com/youtube/v3/videos?part=snippet,liveStreamingDetails&id=" . $id . "&key=" . env("GOOGLE_DEVELOPER_KEY")
        );
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        $data = curl_exec($ch);
        curl_close($ch);

        return response()->json( array('success' => true, 'stream' => json_decode($data) ) );
    }
}