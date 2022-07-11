<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateAuthorRequest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use /*AuthorizesRequests, DispatchesJobs, */ValidatesRequests;

    protected $model;

    /**
     * Create new record
     * @param CreateAuthorRequest $request
     * @return Response
     */
    public function _create(FormRequest $request)
    {
        if(!$this->model) {
            return response('Internal Server Error. Bad controller configuration.', 500);
        }

        $data = $request->validated();

        //($this->model)::create($data)->push();
        $newRecordId = ($this->model)::create($data)->id;

        return response(['id' => $newRecordId], 201);
    }

    /**
     * Delete the record
     * @param int $recordId
     * @return Response
     */
    public function delete(int $recordId)
    {
        if(!$this->model) {
            return response('Internal Server Error. Bad controller configuration.', 500);
        }

        $book = ($this->model)::find($recordId);

        if (!$book) {
            return response('Record not found', 404);
        }

        $book->delete();

        //return response('Deleted',200);
        return response('Deleted', 204);
    }
}
