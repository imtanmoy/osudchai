<?php

namespace App\Http\Controllers\Api;

use App\Models\Prescription;
use App\Shop\Prescriptions\Repositories\PrescriptionRepositoryInterface;
use App\Shop\Prescriptions\Requests\CreatePrescriptionRequest;
use App\Shop\Prescriptions\Transformations\PrescriptionTransformable;
use App\Shop\Users\Repositories\UserRepository;
use App\Shop\Users\Repositories\UserRepositoryInterface;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Storage;
use File;

class PrescriptionController extends Controller
{
    use PrescriptionTransformable;
    /**
     * @var PrescriptionRepositoryInterface
     */
    private $prescriptionRepository;
    /**
     * @var UserRepositoryInterface
     */
    private $userRepository;

    /**
     * PrescriptionController constructor.
     * @param PrescriptionRepositoryInterface $prescriptionRepository
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(
        PrescriptionRepositoryInterface $prescriptionRepository,
        UserRepositoryInterface $userRepository
    )
    {
        $this->prescriptionRepository = $prescriptionRepository;
        $this->userRepository = $userRepository;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth('api')->user();
        $userRepo = new UserRepository($user);
        $list = $userRepo->getPrescriptions();

        $prescriptions = collect($list)->map(function ($prescription) {
            return $this->transformPrescription($prescription);
        });
        return response()->json($prescriptions);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreatePrescriptionRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreatePrescriptionRequest $request)
    {
        try {
            if ($request->hasFile('image')) {
                $image = $request->file('image');

                $imageFileName = $this->prescriptionRepository->savePrescriptionFile($image);

                $user = auth('api')->user();

                $prescription = $this->prescriptionRepository->createPrescription([
                    'title' => $request->input('title'),
                    'src' => $imageFileName,
                    'provider' => 'local',
                    'user_id' => $user->id
                ]);

                $prescription = $this->transformPrescription($prescription);


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

            if ($prescription->user_id != $user->id) {
                return response()->json(['message' => 'This Prescription does not belongs to you'], 403);
            }

            $prescription = $this->transformPrescription($prescription);

            return response()->json($prescription);
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

            $prescription->delete();

            return response()->json(['message' => 'Prescription Successfully Deleted'], 200);
        } catch (\Exception $exception) {
            return response()->json(['message' => $exception->getMessage()], 500);
        }
    }
}
