<?php

namespace OM30\EsusToolkit\Validators;

abstract class AbstractValidator
{
    private array $data;
    private string $method;
    protected array $errors = [];
    protected array $messages = [
        'id_invalid' => 'O ID é inválido',
        'row_not_found' => 'O registro não foi encontrado',
        'register_must_exists' => 'O registro em questão deve existir',
    ];

    public function setData(array $data)
    {
        $this->data = $data;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    public function hasErrors(): bool
    {
        return (!empty($this->getErrors()));
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function getData(): array
    {
        return $this->data;
    }

    public function validate(string $method)
    {
        if (!method_exists($this, $method)) {
            return null;
        }

        $this->setMethod($method);
        $this->{$method}();

        return (!$this->hasErrors());
    }

    protected function addError(string $key, array $data = [])
    {
        $this->errors[] = vsprintf($this->messages[$key], $data);
    }

    protected function setMethod(string $method)
    {
        $this->method = $method;
    }
}
