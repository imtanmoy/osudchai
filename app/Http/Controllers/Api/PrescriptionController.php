<?php

namespace App\Http\Controllers\Api;

use App\Models\Prescription;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Storage;
use File;

class PrescriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(auth('api')->user()->prescriptions);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $fileName = trim(time() . $image->getClientOriginalName());
                Storage::disk('public')->put($fileName, File::get($image));
                $url = Storage::disk('public')->url($fileName);

                $user = auth('api')->user();

                $prescription = $user->prescriptions()->create(['name' => $fileName, 'path' => $url]);

                return response()->json(['message' => 'Prescription Uploaded Successfully', 'data' => $prescription], 201);
            } else {
                return response()->json(['message' => 'No Image Attached'], 400);
            }
        } catch (\Exception $exception) {
            return response()->json(['message' => $exception->getMessage()], 500);
        }
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

            $prescription = Prescription::findOrFail($id);

            $temp = $prescription->toArray();

            if ($prescription->user_id != $user->id) {
                return response()->json(['message' => 'This Prescription does not belongs to you'], 403);
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

            $prescription = Prescription::findOrFail($id);

            if ($prescription->user_id != $user->id) {
                return response()->json(['message' => 'This Prescription does not belongs to you'], 403);
            }

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $fileName = trim(time() . $image->getClientOriginalName());
                Storage::disk('public')->put($fileName, File::get($image));
                $url = Storage::disk('public')->url($fileName);

                $prescription->name = $fileName;
                $prescription->path = $url;

                $prescription->save();

                return response()->json(['message' => 'Prescription Updated Successfully', 'data' => $prescription], 200);
            } else {
                return response()->json(['message' => 'No Image Attached'], 400);
            }
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

            $prescription = Prescription::findOrFail($id);

            if ($prescription->user_id != $user->id) {
                return response()->json(['message' => 'This Prescription does not belongs to you'], 403);
            }

//            Storage::delete($prescription->name);

            $prescription->delete();

            return response()->json(['message' => 'Prescription Successfully Deleted'], 200);
        } catch (\Exception $exception) {
            return response()->json(['message' => $exception->getMessage()], 500);
        }
    }
}
