<?php

namespace App\Support;

class Collection
{
    /**
     * @codeCoverageIgnore
     */
    public function __construct(protected array $elements)
    {
    }

    public function all(): array
    {
        return $this->elements;
    }

    public function where(string $key, mixed $value): static
    {
        return new static(
            array_filter($this->elements, static fn(mixed $el) => $el[$key] === $value)
        );
    }

    public function push(mixed $value): void
    {
        $this->elements[] = $value;
    }

    public static function fromArray(array $array): static
    {
        return new static($array);
    }
}
