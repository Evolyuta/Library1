<?php

namespace App\Http\Controllers;

use App\Author;
use App\Book;
use App\Http\Resources\BookResource;
use http\Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class BookController extends Controller
{
    /**
     * @OA\Get(
     *     path="/books",
     *     operationId="book",
     *     tags={"Books"},
     *     summary="Display a listing of the books",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response="200",
     *         description="Success"
     *     ),
     *     @OA\Response(
     *         response="404",
     *         description="Empty set"
     *     )
     * )
     *
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $books = Book::get();
        if (count($books) == 0) {
            return response()->json(['message' => 'Empty set'], 404);
        }
        foreach ($books as $book) {
            $book['author'] = $this->getAuthor($book);
        }

        return response()->json($books, 200);
    }

    public function create()
    {
        //
    }

    /**
     * @OA\Post(
     *     path="/books",
     *     operationId="exampleCreate",
     *     tags={"Books"},
     *     summary="Create yet another example record",
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
     *         @OA\JsonContent(ref="#/components/schemas/BookStoreRequest")
     *     ),
     *     @OA\Response(
     *         response="404",
     *         description="Author not found"
     *     )
     * )
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'title' => 'required|string',
            'pagesAmount' => 'required|integer',
            'year' => 'required|integer',
            'publisher' => 'required|string',
            'cover' => 'required|string|in:soft,hard',
            'author_id' => 'required|integer',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        if (is_null($this->isAuthorExist($request))) {
            return response()->json(['message' => 'Author not found'], 404);
        }
        $book = Book::create($request->all());
        $book['author'] = $this->getAuthor($book);

        return response()->json($book, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $bookId = Book::find($id);
        if (is_null($bookId)) {
            return response()->json(['message' => 'Record not found'], 404);
        }

        $book = Book::find($id);

        $book['author'] = $this->getAuthor($book);

        return response()->json($book, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (is_null($this->isAuthorExist($request))) {
            return response()->json(['message' => 'Author not found'], 404);
        }
        $book = Book::find($id);
        if (is_null($book)) {
            return response()->json(['message' => 'Record not found'], 404);
        }
        $book->update($request->all());


        $book['author'] = $this->getAuthor($book);

        return response()->json($book, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $book = Book::find($id);
        if (is_null($book)) {
            return response()->json(['message' => 'Record not found'], 404);
        }
        $book->delete();
        return response()->json(null, 204);
    }

    private function getAuthor($book)
    {
        $book = $book->toArray();
        $authorId = Book::where('id', $book['id'])->pluck('author_id');
        $author = Author::find($authorId);
        $author = $author[0];

        return $author;
    }

    private function isAuthorExist($request)
    {
        $authorId = $request->toArray()['author_id'];
        $author = Author::find($authorId);
        return $author;

    }

}
