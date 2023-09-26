<?php

namespace Om30\ESusToolkit\Strategies;

use Om30\ESusToolkit\Traits\AvailabilityWithDependencie;
use Om30\ESusToolkit\Traits\Configurable;

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
