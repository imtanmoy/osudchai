<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Shop\AccountKits\Repositories\AccountKitRepository;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use GuzzleHttp\Client as GuzzleHttpClient;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function credentials(Request $request)
    {
        if (is_numeric($request->get('email'))) {
            return ['phone' => $request->get('email'), 'password' => $request->get('password')];
        } elseif (filter_var($request->get('email'), FILTER_VALIDATE_EMAIL)) {
            return ['email' => $request->get('email'), 'password' => $request->get('password')];
        }
        return ['username' => $request->get('email'), 'password' => $request->get('password')];
    }

    public function authenticated(Request $request, $user)
    {
        if (!$user->is_verified) {
            auth()->logout();
            return back()->with('warning', 'You need to confirm your account. We have sent you an activation code, please check your email.');
        }
        return redirect()->intended($this->redirectPath());
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function logout(Request $request)
    {
        $user = auth('api')->user();
        if ($user->accountKit()->exists()) {
            $status = $this->logOutAccountKit($user->accountKit->access_token);
            $accountKit = new AccountKitRepository($user->accountKit);
            $status2 = $accountKit->deleteAccountKit();
        }
        $this->guard()->logout();

        $request->session()->invalidate();

        return $this->loggedOut($request) ?: redirect('/');
    }

    private function logOutAccountKit(string $userAccessToken)
    {
        $client = new GuzzleHttpClient();
        $version = config('account_kit.account_kit_api_version');

        $logout_endpoint_url = 'https://graph.accountkit.com/' . $version . '/logout?' .
            'access_token=' . $userAccessToken;
        try {
            $request = $client->request('GET', $logout_endpoint_url);
            $data = json_decode($request->getBody());
            return true;
        } catch (GuzzleException $e) {
            return false;
        }
    }
}
