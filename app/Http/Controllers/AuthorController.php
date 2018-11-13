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
     * Returns the list of authors
     * @return Illuminate\Http\Response
     */
    public function index()
    {
     $authors = Author::all();
     return $this->successResponse($authors);
 }

     /**
     * Store a new author in the database list
     * @return Illuminate\Http\Response
     */
     public function store(Request $request)
     {
        $rules = [
            'name' => 'required|max:255',
            'gender' => 'required|max:255|in:male,female',
            'country' => 'required|max:255',
        ];

        $this->validate($request, $rules);

        $author = Author::create($request->all());

        return $this->successResponse($author, Response::HTTP_CREATED);
    }

     /**
     * Returns one author from the list of authors
     * @return Illuminate\Http\Response
     */
     public function show($author)
     {
        $author = Author::findOrFail($author);
        return $this->successResponse($author);
    }

     /**
     * Updata the information of an author
     * @return Illuminate\Http\Response
     */
     public function update(Request $request, $author)
     {
          $rules = [
            'name' => 'max:255',
            'gender' => 'max:255|in:male,female',
            'country' => 'max:255',
        ];

        $this->validate($request, $rules);

        $author = Author::findOrFail($author);
        $author->fill($request->all());

        if ($author->isClean()) {
            return $this->errorResponse('At least one value must be different for you to perform an update', Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $author->save();

        return $this->successResponse($author);
    }

     /**
     * Delete an author from the list of authors
     * @return Illuminate\Http\Response
     */
     public function destroy($author)
     {
        $author = Author::findOrFail($author);
        $author->delete();

        return $this->successResponse($author);
     }
 }
