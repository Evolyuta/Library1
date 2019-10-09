<?php

namespace App\Http\Controllers;

use http\Env\Response;
use Illuminate\Http\Request;
use App\Author;
use Illuminate\Support\Facades\Validator;

class AuthorController extends Controller
{
    public function author()
    {
        return response()->json(Author::get(), 200);
    }

    public function authorByID($id)
    {
        $author = Author::find($id);
        if (is_null($author)) {
            return response()->json(['message' => 'Author not found!'], 404);
        }
        return response()->json(Author::find($id), 200);
    }

    /**
     * @OA\Post(
     *     path="/authors",
     *     operationId="authorCreate",
     *     tags={"Authors"},
     *     summary="Create yet another author record",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response="201",
     *         description="Created"
     *     ),
     *     @OA\Response(
     *         response="400",
     *         description="Invalid data"
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/AuthorStoreRequest")
     *     )
     * )
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function authorSave(Request $request)
    {
        $rules = [
            'name' => 'required|string',
            'surname' => 'required|string',
            'middlename' => 'required|string',
            'country' => 'required|string',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $author = Author::create($request->all());
        return response()->json($author, 201);
    }

    public function authorUpdate(Request $request, $id)
    {
        $author = Author::find($id);
        if (is_null($author)) {
            return response()->json(['message' => 'Author not found'], 404);
        }
        $author->update($request->all());
        return response()->json($author, 200);
    }

    public function authorDelete(Request $request, $id)
    {
        $author = Author::find($id);
        if (is_null($author)) {
            return response()->json(['message' => 'Author not found'], 404);
        }
        $author->delete();
        return response()->json(null, 204);
    }
}
