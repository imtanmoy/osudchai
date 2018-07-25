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
     * [$tokenExchangeUrl description]
     * @var [type]
     */
    protected $tokenExchangeUrl;
    /**
     * [$endPointUrl description]
     * @var [type]
     */
    protected $endPointUrl;
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

    /**
     * AccountKitController constructor.
     */
    public function __construct()
    {
        $this->appId = config('accountkit.account_kit_id');
        $this->client = new GuzzleHttpClient();
        $this->appSecret = config('accountkit.account_kit_secret');
        $this->endPointUrl = config('accountkit.account_kit_end_point');
        $this->tokenExchangeUrl = config('accountkit.account_kit_tokenExchangeUrl');
    }

    public function login(Request $request)
    {
//        dd($request, $this->appId);
//        $url = $this->tokenExchangeUrl . 'grant_type=authorization_code' .
//            '&code=' . $request->get('code') .
//            "&access_token=AA|.$this->appId.|.$this->appSecret";
//
//        dd($url);
////        try {
////            $apiRequest = $this->client->request('GET', $url);
////            $body = json_decode($apiRequest->getBody());
////            $this->userAccessToken = $body->access_token;
////            $this->refreshInterval = $body->token_refresh_interval_sec;
////            return $this->getData();
//////            dd($body);
////        } catch (GuzzleException $e) {
////            dd($e);
////        }
///
///
///
        $app_id = '206569199896807';
        $secret = '1b621efd74d110deef47cce1c8acf77';
        $version = 'v1.1'; // 'v1.1' for example

        $token_exchange_url = 'https://graph.accountkit.com/' . $version . '/access_token?' .
            'grant_type=authorization_code' .
            '&code=' . $request->get('code') .
            "&access_token=AA|$app_id|$secret";

        $data = $this->doCurl($token_exchange_url);

        print_r($data) ;
//        $user_id = $data['id'];
//        $user_access_token = $data['access_token'];
//        $refresh_interval = $data['token_refresh_interval_sec'];
//
//        $me_endpoint_url = 'https://graph.accountkit.com/' . $version . '/me?' .
//            'access_token=' . $user_access_token;
//        $data = $this->doCurl($me_endpoint_url);
//        $phone = isset($data['phone']) ? $data['phone']['number'] : '';
//        $email = isset($data['email']) ? $data['email']['address'] : '';
//
//        dd($user_access_token, $phone, $email, $user_id, $refresh_interval);
    }


    function doCurl($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $data = json_decode(curl_exec($ch), true);
        curl_close($ch);
        return $data;
    }


    /**
     * @throws GuzzleException
     */
    public function getData()
    {
        try {
            $request = $this->client->request('GET', $this->endPointUrl . $this->userAccessToken);
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
