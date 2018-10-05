<?php

namespace App\Http\Controllers\Web;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

use Socialite;
use Google_Client;
use Google_Service_People;
use Google_Service_YouTube;

class AuthenticationController extends Controller
{
    public function getSocialRedirect($account)
{
        try 
        {
            $googleClient = new Google_Client();
            $googleClient->setClientId(env("GOOGLE_CLIENT_ID"));
            $googleClient->setClientSecret(env("GOOGLE_CLIENT_SECRET"));
            $googleClient->setDeveloperKey(env("GOOGLE_DEVELOPER_KEY"));
            $googleClient->addScope(Google_Service_Youtube::YOUTUBE_READONLY);
            $googleClient->addScope(Google_Service_People::USERINFO_PROFILE);
            $googleClient->addScope(Google_Service_People::USERINFO_EMAIL);
            $googleClient->setIncludeGrantedScopes(true);
            $googleClient->setAccessType('offline');

            $googleClient->setRedirectUri('http://localhost:8000/login/google/callback');

            if ( isset ($_SESSION['access_token'] ) && $_SESSION['access_token'] ) 
            {
                $googleClient->setAccessToken($_SESSION['access_token']);
            } else 
            {
                $redirectUri = 'http://' . $_SERVER['HTTP_HOST'] . '/login/google/callback';
                header('Location: ' . filter_var($redirectUri, FILTER_SANITIZE_URL));
                die;
            }
        } 
        catch(\InvalidArgumentException $e) 
        {
            return redirect('/login');
        }
    }

    public function makeNewUser($googleClient) {
        $peopleService = new Google_Service_People($googleClient);
        $myDetails = $peopleService->people->get('people/me', array('personFields' => array('names','emailAddresses','photos')));
        $user = User::where('email', '=', $myDetails->emailAddresses[0]->getValue())->first();

        Log::debug(print_r($myDetails, true));
        $youtubeService = new Google_Service_YouTube($googleClient);
        $myChannels = $youtubeService->channels->listChannels(array('part' => 'id,snippet'), array('mine' => true));
        $myChannels = $myChannels->getItems();
        $myChannel = $myChannels[0];

        $accessToken = $googleClient->getAccessToken();
        $_SESSION['access_token'] = $accessToken;

        $infoPayload = array( 
            'name' => $myDetails['names'][0]->getDisplayName(),
            'email' => $myDetails['emailAddresses'][0]->getValue(),
            'avatar' => $myDetails['photos'][0]->getUrl(),
            'access_token' => $accessToken['access_token'],
            'expires_at' => $accessToken['expires_in'],
            'channel_id' => $myChannel->getId()
        );

        return User::findOrCreate($infoPayload);
    }

    public function getSocialCallback($account)
    {
        $googleClient = new Google_Client();
        $googleClient->setClientId(env("GOOGLE_CLIENT_ID"));
        $googleClient->setClientSecret(env("GOOGLE_CLIENT_SECRET"));
        $googleClient->setDeveloperKey(env("GOOGLE_DEVELOPER_KEY"));
        $googleClient->addScope(Google_Service_Youtube::YOUTUBE_READONLY);
        $googleClient->addScope(Google_Service_People::USERINFO_PROFILE);
        $googleClient->addScope(Google_Service_People::USERINFO_EMAIL);
        $googleClient->setAccessType('offline');
        $googleClient->setIncludeGrantedScopes(true);
        $googleClient->setRedirectUri('http://localhost:8000/login/google/callback');

        if ( ! isset( $_GET['code'] ) )
        {
            $authUrl = $googleClient->createAuthUrl();
            header( 'Location: ' . filter_var($authUrl, FILTER_SANITIZE_URL) );
            die;
        }
        else
        {
            $googleClient->authenticate($_GET['code']);
            $_SESSION['access_token'] = $googleClient->getAccessToken();
            $redirectUri = 'http://' . $_SERVER['HTTP_HOST'] . '/';
            $user = $this->makeNewUser($googleClient);
            Auth::login( $user );
        }
        return redirect('/');     
    }

    public function socialLogout(Request $request)
    {
        Auth::guard(null)->logout();
        $request->session()->flush();
        $request->session()->regenerate();

        return redirect('/');
    }
}