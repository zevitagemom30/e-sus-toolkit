<?php

namespace OM30\EsusToolkit\Models;

use Illuminate\Database\Eloquent\Model;
use OM30\EsusToolkit\Traits\AttributesResourceModel;

abstract class AbstractModel extends Model
{
    use AttributesResourceModel;

    const PRIMARY_KEY = 'id';

    public function get()
    {
        return parent::get();
    }

    public function create(array $data)
    {
        return parent::create($data);
    }

    public function findOrFail(int $id)
    {
        return parent::findOrFail($id);
    }

    public function find(int $id)
    {
        return parent::find($id);
    }
    
    public function getTable()
    {
        return parent::getTable();
    }

    public function paginate($perPage = null, $columns = ['*'], $pageName = 'page', $page = null)
    {
        return parent::paginate($perPage, $columns, $pageName, $page);
    }

    public function join($table, $first, $operator = null, $second = null, $type = 'inner', $where = false)
    {
        return parent::join($table, $first, $operator, $second, $type, $where);
    }
}
