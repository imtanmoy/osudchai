<?php

namespace App\Http\Controllers\Auth;

use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use GuzzleHttp\Client as GuzzleHttpClient;
use GuzzleHttp\Exception\RequestException;

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
     * AccountKitController constructor.
     */
    public function __construct()
    {
        $this->appId = config('account_kit.account_kit_id');
        $this->client = new GuzzleHttpClient();
        $this->appSecret = config('account_kit.account_kit_secret');
        $this->version = config('account_kit.account_kit_api_version');
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
            return $this->getData();
        } catch (GuzzleException $e) {
            dd($e);
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
            $userId = $data->id;
            $userAccessToken = $this->userAccessToken;
            $refreshInterval = $this->refreshInterval;
            $phone = isset($data->phone) ? $data->phone->number : '';
            $email = isset($data->email) ? $data->email->address : '';
            dd($userId, $userAccessToken, $refreshInterval, $phone, $email);
        } catch (GuzzleException $e) {
            throw $e;
        }
    }


}
