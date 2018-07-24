<?php

namespace App\Http\Controllers\Admin;

use App\Models\GenericName;
use App\Shop\GenericNames\Repositories\GenericNameRepositoryInterface;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GenericNameController extends Controller
{
    /**
     * @var GenericNameRepositoryInterface
     */
    private $genericNameRepository;


    /**
     * GenericNameController constructor.
     * @param GenericNameRepositoryInterface $genericNameRepository
     */
    public function __construct(GenericNameRepositoryInterface $genericNameRepository)
    {
        $this->genericNameRepository = $genericNameRepository;
    }

    public function autoComplete(Request $request)
    {
        $data = GenericName::select("name")->where("name", "LIKE", "%{$request->input('query')}%")->get();
        return response()->json($data);
    }

    public function index(Request $request)
    {
        if ($request->has('query')) {
            $genericNames = $this->genericNameRepository->searchGenericName($request->input('query'));
            $data = $genericNames->map(function (GenericName $genericName) {
                return $genericName->name;
            });
            return response()->json($data);
        }

        return $this->genericNameRepository->listGenericNames();

    }
}
