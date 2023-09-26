<?php

namespace OM30\EsusToolkit\Strategies;

use OM30\EsusToolkit\Traits\AvailabilityWithDependencie;
use OM30\EsusToolkit\Traits\Configurable;

abstract class AbstractStrategy
{
    use Configurable;
    use AvailabilityWithDependencie;

    public function getState(string $key)
    {
        $state = $this->getConfigIndex('state');

        return $state[$key] ?? null;
    }
}
