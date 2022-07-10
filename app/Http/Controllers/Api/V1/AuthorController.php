<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateAuthorRequest;
use App\Models\Author;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AuthorController extends Controller
{
    /**
     * Show all authors
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all()
    {
        return Author::withCount('books')->get();
    }

    /**
     * Show all authors with pagination
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function paginate()
    {
        return Author::withCount('books')->paginate();
    }

    /**
     * @param int $authorId
     * @return Response
     */
    public function get(int $authorId)
    {

        $author = Author::with('books')->withCount('books')->find($authorId);

        if (!$author) {
            return response('Author not found', 404);
        }

        //return response()
        //return new JsonResponse()
        //return new Response()

        return response($author, 200);
    }

    /**
     * Create new author
     * @param CreateAuthorRequest $request
     * @return Response
     */
    public function create(CreateAuthorRequest $request)
    {
        $data = $request->validated();

        //Author::create($data)->push();
        $authorId = Author::create($data)->id;

        return response(['id' => $authorId], 201);
    }


    /**
     * Delete author
     * @param int $authorId
     * @return Response
     */
    public function delete(int $authorId)
    {

        $author = Author::find($authorId);

        if (!$author) {
            return response('Author not found', 404);
        }

        $author->delete();

        return response('Deleted',200);
        //return response('Deleted',204);
    }

    /**
     * Get books of author
     * @param Request $request
     * @param int $authorId
     * @return Response
     */
    public function books(Request $request, int $authorId)
    {
        $author = Author::find($authorId);

        if (!$author) {
            return response('Author not found', 404);
        }

        $books = $author->books()->get();

        return response($books, 200);
    }
}
