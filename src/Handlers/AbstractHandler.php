<?php

namespace OM30\EsusToolkit\Handlers;

abstract class AbstractHandler
{
    public function __construct(array $data = [])
    {
        $this->data = $data;
    }

    public function get(string $key)
    {
        return $this->data[$key] ?? null;
    }

    public function toArray(): array
    {
        return $this->data;
    }

    public function handle(array $data, string $method = '')
    {
        if (!method_exists($this, $method)) {
            return null;
        }

        $result = $this->{$method}($data);
        return new static($result);
    }
}
