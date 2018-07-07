<?php

namespace App\Http\Controllers\Admin;

use App\Models\GenericName;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GenericNameController extends Controller
{
    public function autoComplete(Request $request)
    {
        $data = GenericName::select("name")->where("name", "LIKE", "%{$request->input('query')}%")->get();
        return response()->json($data);
    }
}
