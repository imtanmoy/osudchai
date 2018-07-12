<?php

namespace App\Http\Controllers\Api;

use App\Models\Address;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AddressController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(auth('api')->user()->addresses);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $user = auth('api')->user();

        $user->addresses()->create($request->all());

        return response()->json($user->addresses);
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

            $address = Address::findOrFail($id);

            $temp = $address->toArray();
            $temp['city'] = $address->city->name;
            $temp['area'] = $address->area->name;

            if ($address->user_id != $user->id) {
                return response()->json(['message' => 'This address does not belongs to you'], 403);
            }

            return response()->json($temp);
        } catch (\Exception $exception) {
            return response()->json(['message' => $exception->getMessage()], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $user = auth('api')->user();

            $address = Address::findOrFail($id);

            if ($address->user_id != $user->id) {
                return response()->json(['message' => 'This address does not belongs to you'], 403);
            }

            foreach ($request->all() as $key => $value) {
                if (isset($request->$key)) {
                    $address->$key = $value;
                }
            }

            $address->save();

            return response()->json(['message' => 'Address Successfully Updated'], 200);
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
