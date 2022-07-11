<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\CreateAuthorRequest;
use App\Http\Requests\CreateOrUpdateBookRequest;
use App\Models\Author;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AuthorController extends Controller
{

    protected $model = Author::class;

    /**
     * Show all authors
     * @param Request $request
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all(Request $request)
    {
        $filters = (new Author())->handleFilters($request->query());

        return count($filters)
            ? Author::with('authors')->withCount('books')->where($filters)->get()
            : Author::withCount('books')->get();
    }

    /**
     * Show all authors with pagination
     * @param Request $request
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function paginate(Request $request)
    {
        $filters = (new Author())->handleFilters($request->query());

        return count($filters)
            ? Author::with('authors')->withCount('books')->where($filters)->paginate()
            : Author::withCount('books')->paginate();
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
        return $this->_create($request);
    }

    /**
     * Update author
     * @param CreateAuthorRequest $request
     * @param int $authorId
     * @return Response
     */
    public function update(CreateAuthorRequest $request, int $authorId)
    {
        return $this->_update($request, $authorId);
    }

    /**
     * Get books of author
     * @param int $authorId
     * @return Response
     */
    public function books(int $authorId)
    {
        $author = Author::find($authorId);

        if (!$author) {
            return response('Author not found', 404);
        }

        $books = $author->books()->get();

        return response($books, 200);
    }
}
