<?php

namespace App\Http\Controllers\Api;

use App\Models\Address;
use App\Shop\Addresses\Repositories\AddressRepository;
use App\Shop\Addresses\Repositories\AddressRepositoryInterface;
use App\Shop\Addresses\Requests\CreateAddressRequest;
use App\Shop\Addresses\Requests\UpdateAddressRequest;
use App\Shop\Addresses\Transformations\AddressTransformable;
use App\Shop\Users\Repositories\UserRepository;
use App\Shop\Users\Repositories\UserRepositoryInterface;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AddressController extends Controller
{

    use AddressTransformable;

    private $addressRepo;
    private $userRepo;

    /**
     * AddressController constructor.
     * @param AddressRepositoryInterface $addressRepo
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(
        AddressRepositoryInterface $addressRepo,
        UserRepositoryInterface $userRepository
    )
    {
        $this->addressRepo = $addressRepo;
        $this->userRepo = $userRepository;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth('api')->user();

        $user = $this->userRepo->findUserById($user->id);

        $user = new UserRepository($user);

        $addresses = $user->getAddresses();

        $addresses = $addresses->map(function ($address) {
            return $this->transformAddress($address);
        });

        return response()->json($addresses);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateAddressRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateAddressRequest $request)
    {

        $user = auth('api')->user();

        $user = $this->userRepo->findUserById($user->id);

        $address = new Address($request->except('_token', '_method'));

        $user = new UserRepository($user);

        $address = $user->attachAddress($address);


        return response()->json(['message' => 'Address Successfully Created', 'address' => $this->transformAddress($address)], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $user = auth('api')->user();


            $address = $this->addressRepo->findOneOrFail($id);


            if ($address->user_id != $user->id) {
                return response()->json(['message' => 'This address does not belongs to you'], 403);
            }


            return response()->json($this->transformAddress($address));
        } catch (\Exception $exception) {
            return response()->json(['message' => $exception->getMessage()], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateAddressRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAddressRequest $request, $id)
    {
        try {
            $user = auth('api')->user();

            $address = $this->addressRepo->findAddressById($id);

            if ($address->user_id != $user->id) {
                return response()->json(['message' => 'This address does not belongs to you'], 403);
            }

            $address['user_id'] = $user->id;

            $addressRepo = new AddressRepository($address);


            $addressRepo->updateAddress($request->except('_token', '_method'));


            $address = $this->addressRepo->findAddressById($id);
            return response()->json(['message' => 'Address Successfully Updated', 'address' => $this->transformAddress($address)], 200);


        } catch (\Exception $exception) {
            return response()->json(['message' => $exception->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $user = auth('api')->user();

            $address = Address::findOrFail($id);

            if ($address->user_id != $user->id) {
                return response()->json(['message' => 'This address does not belongs to you'], 403);
            }

            $address->delete();

            return response()->json(['message' => 'Address Successfully Deleted'], 200);
        } catch (\Exception $exception) {
            return response()->json(['message' => $exception->getMessage()], 500);
        }
    }
}
