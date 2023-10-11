<?php

namespace OM30\EsusToolkit\Contracts;

interface BaseModelContract
{
    public function paginate($perPage = null, $columns = ['*'], $pageName = 'page', $page = null);
    
    public function getTable();
}