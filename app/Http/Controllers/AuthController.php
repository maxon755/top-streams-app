<?php

namespace App\Http\Controllers;

use stdClass;
use App\Models\User;
use Illuminate\Http\Request;
use romanzipp\Twitch\Twitch;
use Illuminate\Support\Facades\Auth;
use romanzipp\Twitch\Enums\GrantType;

class AuthController extends Controller
{
    public function __construct(private Twitch $twitchClient)
    {
    }

    public function login()
    {
        return view('login');
    }

    public function redirectToTwitchAuth()
    {
        $twitchAuthUrl = 'https://id.twitch.tv/oauth2/authorize?' . http_build_query([
                'client_id'     => 'm01e4hoc1qvkerlwsqhqg4vqrsvtyk',
                'redirect_uri'  => 'http://localhost/login-with-twitch',
                'response_type' => 'code',
                'scope'         => 'user:read:email',
            ]);

        return redirect($twitchAuthUrl);
    }

    public function loginWithTwitch(Request $request)
    {
        $authorizationCode = $request->get('code');
        $scopes = explode(' ', $request->get('scope'));

        $accessToken = $this->getTwitchAccessToken($authorizationCode, $scopes);

        if (!$accessToken) {
            return 'You should login via Twitch to use the app';
        }

        $userData = $this->getLoggedInUserData($accessToken);

        $user = User::updateOrCreate([
            'twitch_id' => $userData->id,
        ], [
            'username'            => $userData->display_name,
            'email'               => $userData->email,
            'twitch_access_token' => $accessToken,
        ]);

        Auth::login($user);

        return redirect(route('home'));
    }

    private function getTwitchAccessToken(string $authorizationCode, array $scopes): ?string
    {
        $tokenResponse = $this->twitchClient->getOAuthToken(
            $authorizationCode,
            GrantType::AUTHORIZATION_CODE,
            $scopes
        );

        if ($tokenResponse->getStatus() !== 200) {
            return 'You should login via Twitch to use the app';
        }

        return $tokenResponse->data()->access_token;
    }

    private function getLoggedInUserData(string $accessToken): stdClass
    {
        $response = $this->twitchClient->withToken($accessToken)->getUsers();

        return $response->data()[0];
    }
}
