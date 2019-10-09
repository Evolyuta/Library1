<?php

namespace App\Http\Controllers;

use App\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DocumentController extends Controller
{

    public function documentActive()
    {
        $document = Document::where('active', '=', 1)->get()->toArray();
        return response()->json($document, 200);
    }

    public function documentInactive()
    {
        $document = Document::where('active', '=', 0)->get()->toArray();
        return response()->json($document, 200);
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|string',
            'object' => 'required|string',
            'entity' => 'required|string'
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $author = Document::create($request->all());
        return response()->json($author, 201);
    }

}
