<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\CreateAuthorRequest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;
use function response;

class Controller extends BaseController
{
    use /*AuthorizesRequests, DispatchesJobs, */ValidatesRequests;

    protected $model;

    /**
     * Create new record
     * @param FormRequest $request
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
     * Update record
     * @param FormRequest $request
     * @param int $recordId
     * @return Response
     */
    public function _update(FormRequest $request, int $recordId)
    {
        if(!$this->model) {
            return response('Internal Server Error. Bad controller configuration.', 500);
        }

        $data = $request->validated();

        $record = ($this->model)::find($recordId);

        if (!$record) {
            return response('Record not found', 404);
        }

        //$record->fill($data)->save();
        $record->update($data);

        return response('Updated', 204);
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

        $record = ($this->model)::find($recordId);

        if (!$record) {
            return response('Record not found', 404);
        }

        $record->delete();

        //return response('Deleted',200);
        return response('Deleted', 204);
    }
}
