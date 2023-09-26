<?php

namespace OM30\EsusToolkit\Models;

use Illuminate\Database\Eloquent\Model;
use OM30\EsusToolkit\Traits\AttributesResourceModel;

abstract class AbstractModel extends Model
{
    use AttributesResourceModel;

    const PRIMARY_KEY = 'id';
}
