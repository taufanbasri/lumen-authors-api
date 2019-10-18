<?php

namespace App\Http\Controllers;

use App\Author;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AuthorController extends Controller
{
    use ApiResponser;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Return the list of authors
     * @return Illuminate\Http\Response
     */
    public function index()
    {
        $authors = Author::cursor();

        return $this->successResponse($authors);
    }

    /**
     * Create new author
     * @return Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $this->validate($request, [
            'name' => 'required',
            'gender' => 'required|in:male,female',
            'country' => 'required',
        ]);

        $author = Author::create($data);

        return $this->successResponse($author, Response::HTTP_CREATED);
    }

    /**
     * Show the author
     * @return Illuminate\Http\Response
     */
    public function show($author)
    {
        $author = Author::findOrFail($author);

        return $this->successResponse($author);
    }

    /**
     * Update the author
     * @return Illuminate\Http\Response
     */
    public function update(Request $request, $author)
    {
        $data = $this->validate($request, [
            'name' => '',
            'gender' => 'in:male,female',
            'country' => ''
        ]);

        $author = Author::findOrFail($author);

        $author->fill($data);

        if ($author->isClean()) {
            return $this->errorResponse('At least one value must change', Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $author->save();

        return $this->successResponse($author);
    }

    /**
     * Destroy the author
     * @return Illuminate\Http\Response
     */
    public function destroy($author)
    {
        $author = Author::findOrFail($author);
        $author->delete();

        return $this->successResponse($author);
    }
}
