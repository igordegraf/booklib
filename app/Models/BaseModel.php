<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{

    /**
     * Фильтруем допустимые параметры модели из массива всех входных параметров
     * @param array $params
     * @return mixed
     */
    public function handleFilters(array $params)
    {
        $filter = [];
        foreach ($this->fillable as $field) {
            if(isset($params[$field])) {
                $filter[$field] = $params[$field];
            }
        }

        return array_filter($filter);
    }

}
