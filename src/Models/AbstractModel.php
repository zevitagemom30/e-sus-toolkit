<?php

namespace Om30\ESusToolkit\Models;

use Illuminate\Database\Eloquent\Model;
use Om30\ESusToolkit\Traits\AttributesResourceModel;

abstract class AbstractModel extends Model
{
    const PRIMARY_KEY = 'id';

    use AttributesResourceModel;
}
