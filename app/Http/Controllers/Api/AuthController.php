<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\RegisterRequest;
use App\Services\UserService\Facades\UserVerification;
use App\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Validator;

class AuthController extends Controller
{


    /**
     * AuthController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
        $this->middleware('isVerified', ['except' => ['login', 'register']]);
    }

    public function login(Request $request)
    {
        $token = null;
        $credentials = $request->only('email', 'password');

        $rules = [
            'email' => 'required|email',
            'password' => 'required',
        ];
        $validator = Validator::make($credentials, $rules);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'error' => $validator->messages()]);
        }

        if (!$token = auth('api')->attempt($credentials)) {
            return response()->json(['message' => 'Invalid email or password'], 401);
        }

        return $this->respondWithToken($token);
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ]);
    }

    public function getAuthUser(Request $request)
    {
        $user = JWTAuth::toUser($request->input('token'));
        return response()->json([$user]);
    }

    public function me()
    {
        return response()->json(auth('api')->user());
    }

    public function logout(Request $request)
    {
        auth('api')->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    public function refresh()
    {
        return $this->respondWithToken(auth('api')->refresh());
    }

    public function register(Request $request)
    {
        try {
            $errors = $this->validator($request->all())->errors();
            if (count($errors)) {
                return response()->json(['errors' => $errors], 401);
            }
            event(new Registered($user = $this->create($request->all())));
            UserVerification::generate($user);
            return response()->json($user, 201);
        } catch (\Exception $exception) {
            return response()->json(['message' => $exception->getMessage()], $exception->getCode());
        }
    }

    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'password' => bcrypt($data['password']),
        ]);
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|regex:/(01)[0-9]{9}/|max:14|min:11|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }
}
