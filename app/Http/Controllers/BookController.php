<?php

namespace App\Http\Controllers;

use App\Author;
use App\Book;
use App\Http\Resources\BookResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $books = Book::get();

        foreach ($books as $book) {
            $book['author_id'] = $this->getAuthorName($book);
        }

        return response()->json($books, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'title'       => 'required',
            'pagesAmount' => 'required',
            'year'        => 'required',
            'publisher'   => 'required',
            'cover'       => 'required',
            'author_id'   => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $book = Book::create($request->all());

        $book['author_id'] = $this->getAuthorName($book);

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
            return response()->json(['message' => 'Record not found!'], 404);
        }

        $book = Book::find($id);

        $book['author_id'] = $this->getAuthorName($book);

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
        $book = Book::find($id);
        if (is_null($book)) {
            return response()->json(['message' => 'Record not found!'], 404);
        }
        $book->update($request->all());

        $book['author_id'] = $this->getAuthorName($book);

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
            return response()->json(['message' => 'Record not found!'], 404);
        }
        $book->delete();
        return response()->json(null, 204);
    }

    private function getAuthorName($book)
    {
        $authorId = Book::where('id', $book['id'])->pluck('author_id');
        $author = Author::find($authorId);
        $author = $author[0];

        $book['author_id'] = [
            'name'       => $author['name'],
            'surname'    => $author['surname'],
            'middlename' => $author['middlename'],
        ];

        return $book['author_id'];
    }

}
