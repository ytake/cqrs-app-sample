<?php
declare(strict_types=1);

namespace SampleDomain\Support\ValueObject;

use SampleDomain\Support\Exception\InvalidNativeArgumentException;

class IntegerIdentifier
{
    private int $id;

    public function __construct(
        int $id
    ) {
        $this->id = match($id) {
            0 => throw new InvalidNativeArgumentException(),
            default => $id
        };
    }

    /**
     * @return int
     */
    public function value(): int
    {
        return $this->id;
    }
}
