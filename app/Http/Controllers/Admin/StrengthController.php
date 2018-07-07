<?php

namespace App\Http\Controllers\Admin;

use App\Models\Strength;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StrengthController extends Controller
{
    public function autoComplete(Request $request)
    {
        $data = Strength::select("value AS name")->where("value","LIKE","%{$request->input('query')}%")->get();
        return response()->json($data);
    }
}
