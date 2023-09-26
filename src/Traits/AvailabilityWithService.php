<?php

namespace OM30\EsusToolkit\Traits;

use OM30\EsusToolkit\Services\AbstractService;

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
