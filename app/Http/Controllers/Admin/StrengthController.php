<?php

namespace App\Http\Controllers\Admin;

use App\Models\Strength;
use App\Shop\Strengths\Repositories\StrengthRepositoryInterface;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StrengthController extends Controller
{
    /**
     * @var StrengthRepositoryInterface
     */
    private $strengthRepository;


    /**
     * StrengthController constructor.
     * @param StrengthRepositoryInterface $strengthRepository
     */
    public function __construct(StrengthRepositoryInterface $strengthRepository)
    {
        $this->strengthRepository = $strengthRepository;
    }

    public function autoComplete(Request $request)
    {
        $data = Strength::select("value AS name")->where("value", "LIKE", "%{$request->input('query')}%")->get();
        return response()->json($data);
    }


    public function index(Request $request)
    {
        if ($request->has('query')) {
            $strengths = $this->strengthRepository->searchStrength($request->input('query'));
            $data = $strengths->map(function (Strength $strength) {
                return $strength->value;
            });
            return response()->json($data);
        }

        return $this->strengthRepository->listStrengths();

    }
}
