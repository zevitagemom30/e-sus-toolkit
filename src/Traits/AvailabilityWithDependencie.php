<?php

namespace OM30\EsusToolkit\Traits;

trait AvailabilityWithDependencie
{
    protected $dependencies = [];

    public function setDependencie(string $key, $object)
    {
        $this->dependencies[$key] = $object;
    }

    public function getDependencie(string $key)
    {
        return (isset($this->dependencies[$key])) ? $this->dependencies[$key] : null;
    }

    public function setDependencies(array $data)
    {
        foreach ($data as $key => $value) {

            $this->dependencies[$key] = $value;

        }
    }
}
