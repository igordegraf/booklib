<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddBookAuthorRequest;
use App\Http\Requests\CreateBookRequest;
use App\Models\Author;
use App\Models\Book;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BookController extends Controller
{

    /**
     * Show all books
     * @param Request $request
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all(Request $request)
    {
        $filters = array_filter([
            'name' => $request->get('name'),
            'publish_date' => $request->get('publish_date'),
            'annotation' => $request->get('annotation')
        ]);

        return count($filters) ? Book::with('authors')->where($filters)->get() : Book::with('authors')->get();
    }

    /**
     * Show all books with pagination
     * @param Request $request
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function paginate(Request $request)
    {
        $filters = array_filter([
            'name' => $request->get('name'),
            'publish_date' => $request->get('publish_date'),
            'annotation' => $request->get('annotation')
        ]);

        return count($filters) ? Book::with('authors')->where($filters)->paginate() : Book::with('authors')->paginate();
        //return Book::query()->paginate();
    }

    /**
     * @param int $bookId
     * @return Response
     */
    public function get(int $bookId)
    {

        $book = Book::with('authors')->find($bookId);

        if (!$book) {
            return response('Book not found', 404);
        }

        //return response()
        //return new JsonResponse()
        //return new Response()

        return response($book, 200);
    }

    /**
     * Create new book
     * @param CreateBookRequest $request
     * @return Response
     */
    public function create(CreateBookRequest $request)
    {
        $data = $request->validated();

        //Book::create($data)->push();
        $bookId = Book::create($data)->id;

        return response(['id' => $bookId], 201);
    }

    /**
     * Delete the book
     * @param int $bookId
     * @return Response
     */
    public function delete(int $bookId)
    {

        $book = Book::find($bookId);

        if (!$book) {
            return response('Book not found', 404);
        }

        $book->delete();

        return response('Deleted',200);
        //return response('Deleted',204);
    }

    /**
     * Add new author to the book
     * @param AddBookAuthorRequest $request
     * @param int $bookId
     * @return Response
     */
    public function addAuthor(AddBookAuthorRequest $request, int $bookId)
    {
        $data = $request->validated();

        $book = Book::find($bookId);

        if (!$book) {
            return response('Book not found', 404);
        }

        $authorId = reset($data);

        $bookAuthor = $book->authors()->where(['author_id' => $authorId])->get();

        if(count($bookAuthor) > 0) {
            throw new \InvalidArgumentException("Author already added to the book");
        }

        $author = Author::find($authorId);
        if (!$author) {
            return response('Author not found', 404);
        }

        $book->authors()->attach($authorId);

        return response('Created', 201);
    }

    /**
     * Remove author from the book
     * @param int $bookId
     * @param int $authorId
     * @return Response
     */
    public function deleteAuthor(int $bookId, int $authorId)
    {

        $book = Book::find($bookId);

        if (!$book) {
            return response('Book not found', 404);
        }

        $bookAuthor = $book->authors()->where(['author_id' => $authorId])->get();
        if(count($bookAuthor) == 0) {
            throw new \InvalidArgumentException("Author not found in book");
        }

        $book->authors()->detach($authorId);

        return response('Deleted',200);
        //return response('Deleted', 204);
    }

    /**
     * Find books by author
     * @param int $authorId
     * @return Response
     */
    public function getByAuthor(int $authorId)
    {

        $author = Author::find($authorId);

        if (!$author) {
            return response('Author not found', 404);
        }

        $books = Book::with('authors')->whereRelation('authors', 'author_id', '=', $authorId)->get();

       return response($books);
    }
}
