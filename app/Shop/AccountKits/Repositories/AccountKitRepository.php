<?php
/**
 * Created by PhpStorm.
 * User: tanmoy
 * Date: 7/26/18
 * Time: 9:52 AM
 */

namespace App\Shop\AccountKits\Repositories;


use App\Models\AccountKit;
use App\Shop\AccountKits\Exceptions\PhoneVerifyErrorException;
use App\Shop\Base\BaseRepository;
use App\User;
use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;

use GuzzleHttp\Client as GuzzleHttpClient;


class AccountKitRepository extends BaseRepository implements AccountKitRepositoryInterface
{

    protected $model;

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
     * [$version description]
     * @var [type]
     */
    protected $version;

    /**
     * AccountKitRepository constructor.
     * @param AccountKit $accountKit
     */
    public function __construct(AccountKit $accountKit)
    {
        parent::__construct($accountKit);
        $this->model = $accountKit;
        $this->appId = config('account_kit.account_kit_id');
        $this->client = new GuzzleHttpClient();
        $this->appSecret = config('account_kit.account_kit_secret');
        $this->version = config('account_kit.account_kit_api_version');
    }

    /**
     * @param array $params
     * @return AccountKit
     */
    public function createAccountKit(array $params): AccountKit
    {
        try {
            $accountKit = new AccountKit($params);
            if (isset($params['user_id'])) {
                $accountKit->user()->associate($params['user_id']);
            }
            $accountKit->save();

            $accountKit->user()->update([
                'is_phone_verified' => 1,
                'is_verified' => 1,
            ]);

            return $accountKit;
        } catch (QueryException $e) {
            throw $e;
        }
    }

    /**
     * @param AccountKit $accountKit
     * @param User $user
     */
    public function attachToUser(AccountKit $accountKit, User $user)
    {
        $user->accountKit()->save($accountKit);
        $user->update([
            'is_phone_verified' => 1,
            'is_verified' => 1,
        ]);
    }

    /**
     * @param array $update
     * @return bool
     */
    public function updateAccountKit(array $update): bool
    {
        return $this->model->update($update);
    }

    /**
     * @return bool|null
     * @throws \Exception
     */
    public function deleteAccountKit()
    {
        $this->model->user()->dissociate();
        return $this->model->delete();
    }

    public function listAccountKit(string $order = 'id', string $sort = 'desc', array $columns = ['*']): Collection
    {
        return $this->all($columns, $order, $sort);
    }

    public function findAccountKitById(int $id): AccountKit
    {
        try {
            return $this->findOneOrFail($id);
        } catch (ModelNotFoundException $e) {
            throw $e;
        }
    }

    public function findUser(): User
    {
        return $this->model->user;
    }

    public function searchAccountKit(string $text): Collection
    {
//        return $this->model->search($text, [
//            'address1' => 10,
//            'address2' => 5,
//            'area.name' => 5,
//            'city.name' => 5
//        ])->get();
    }

    public function findAccountKitByNumber(string $number)
    {
        return $this->model->where('number', '=', $number)->first();
    }

    /**
     * @param string $code
     * @return AccountKit
     * @throws PhoneVerifyErrorException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function verify(string $code): AccountKit
    {
        $token_exchange_url = 'https://graph.accountkit.com/' . $this->version . '/access_token?' .
            'grant_type=authorization_code' .
            '&code=' . $code .
            "&access_token=AA|$this->appId|$this->appSecret";

        try {
            $apiRequest = $this->client->request('GET', $token_exchange_url);
            $body = json_decode($apiRequest->getBody());
            $userAccessToken = $body->access_token;
            $refreshInterval = $body->token_refresh_interval_sec;
            $data = $this->getData($userAccessToken);

            $userId = $data->id;
            $number = isset($data->phone) ? $data->phone->number : '';
            $country_prefix = isset($data->phone) ? $data->phone->country_prefix : '';
            $national_number = isset($data->phone) ? $data->phone->national_number : '';

            $user = User::where('phone', '=', '0' . $number)->first();

            if ($user != null) {
                if ($user->accountKit()->exists()) {
                    $user->accountKit()->delete();
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

                return $this->createAccountKit($params);
            } else {
                throw new PhoneVerifyErrorException('User not found with this phone number', 400);
            }

        } catch (ClientException $exception) {
            throw new PhoneVerifyErrorException($exception->getResponse()->getBody()->getContents(), $exception->getResponse()->getStatusCode());
        }
    }

    /**
     * @param string $userAccessToken
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public
    function getData(string $userAccessToken)
    {
        $me_endpoint_url = 'https://graph.accountkit.com/' . $this->version . '/me?' .
            'access_token=' . $userAccessToken;
        $request = $this->client->request('GET', $me_endpoint_url);
        $data = json_decode($request->getBody());
        return $data;
    }

    /**
     *
     */
    public function logOut()
    {
        $logout_endpoint_url = 'https://graph.accountkit.com/' . $this->version . '/logout?' .
            'access_token=' . $this->model->access_token;
        try {
            $request = $this->client->request('GET', $logout_endpoint_url);
            json_decode($request->getBody());
        } catch (GuzzleException $e) {
        } catch (\Exception $e) {
        }
    }
}
