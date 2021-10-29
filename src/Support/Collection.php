<?php

namespace Coozieki\Framework\Support;

class Collection
{
    /**
     * @codeCoverageIgnore
     */
    public function __construct(protected array $elements = [])
    {
    }

    public function all(): array
    {
        return $this->elements;
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
