<?php

namespace Om30\ESusToolkit\Traits;

use Om30\ESusToolkit\Services\AbstractService;

trait AvailabilityWithService
{
    private AbstractService $service;

    public function setService(AbstractService $service)
    {
        $this->service = $service;
    }

    public function getService(): AbstractService
    {
        return $this->service;
    }
}
