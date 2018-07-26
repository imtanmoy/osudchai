<?php

namespace App\Http\Controllers\Api;

use App\Shop\AccountKits\Repositories\AccountKitRepository;
use App\Shop\AccountKits\Repositories\AccountKitRepositoryInterface;
use App\User;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use GuzzleHttp\Client as GuzzleHttpClient;

class AccountKitController extends Controller
{

    protected $client;
    /**
     * $appId
     * @var [int]
     */
    protected $appId;
    /**
     * [$appSecret description]
     * @var [string]
     */
    protected $appSecret;
    /**
     * [$userAccessToken description]
     * @var [type]
     */
    public $userAccessToken;
    /**
     * [$refreshInterval description]
     * @var [type]
     */
    protected $refreshInterval;

    protected $version;
    /**
     * @var AccountKitRepositoryInterface
     */
    private $accountKitRepository;

    /**
     * AccountKitController constructor.
     * @param AccountKitRepositoryInterface $accountKitRepository
     */
    public function __construct(AccountKitRepositoryInterface $accountKitRepository)
    {
        $this->middleware('guest')->except('logout');

        $this->appId = config('account_kit.account_kit_id');
        $this->client = new GuzzleHttpClient();
        $this->appSecret = config('account_kit.account_kit_secret');
        $this->version = config('account_kit.account_kit_api_version');
        $this->accountKitRepository = $accountKitRepository;
    }

    public function login(Request $request)
    {


        $token_exchange_url = 'https://graph.accountkit.com/' . $this->version . '/access_token?' .
            'grant_type=authorization_code' .
            '&code=' . $request->get('code') .
            "&access_token=AA|$this->appId|$this->appSecret";
        try {
            $apiRequest = $this->client->request('GET', $token_exchange_url);
            $body = json_decode($apiRequest->getBody());
            $this->userAccessToken = $body->access_token;
            $this->refreshInterval = $body->token_refresh_interval_sec;
            $data = $this->getData();

            $userId = $data->id;
            $userAccessToken = $this->userAccessToken;
            $refreshInterval = $this->refreshInterval;
            $number = isset($data->phone) ? $data->phone->number : '';
            $country_prefix = isset($data->phone) ? $data->phone->country_prefix : '';
            $national_number = isset($data->phone) ? $data->phone->national_number : '';
//            dd($data, $userId, $userAccessToken, $refreshInterval, $number);

            $accountKit = $this->accountKitRepository->findAccountKitByNumber($number);
            $user = User::where('phone', '0' . $national_number)->first();
            if ($accountKit == null) {
                if ($user == null) {
                    $user = new User();
                    $user->phone = '0' . $national_number;
                    $user->save();
                    event(new Registered($user));
                } else {
                    if ($user->accountKit()->exists()) {
                        $account = new AccountKitRepository($user->accountKit);
                        $account->deleteAccountKit();
                    }
                }

                $params = [
                    'account_kit_user_id' => $userId,
                    'access_token' => $userAccessToken,
                    'token_refresh_interval_sec' => $refreshInterval,
                    'number' => $number,
                    'country_prefix' => $country_prefix,
                    'national_number' => $national_number,
                    'user_id' => $user->id
                ];
                $this->accountKitRepository->createAccountKit($params);

                if (!$token = auth('api')->login($user)) {
                    return response()->json(['message' => 'Invalid credentials'], 401);
                }

            } else {
                if (!$token = auth('api')->login($user)) {
                    return response()->json(['message' => 'Invalid credentials'], 401);
                }
            }

            return $this->respondWithToken($token);

        } catch (GuzzleException $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }


    /**
     * @throws GuzzleException
     */
    public function getData()
    {
        try {
            $me_endpoint_url = 'https://graph.accountkit.com/' . $this->version . '/me?' .
                'access_token=' . $this->userAccessToken;
            $request = $this->client->request('GET', $me_endpoint_url);
            $data = json_decode($request->getBody());
            return $data;
        } catch (GuzzleException $e) {
            throw $e;
        }
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ]);
    }
}
