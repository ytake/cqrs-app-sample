<?php
declare(strict_types=1);

namespace App\Transfer;

final class Keyword
{
    /**
     * @param string $word
     * @param int $count
     */
    public function __construct(
        private string $word,
        private int $count
    ) {
    }

    public function getWord(): string
    {
        return $this->word;
    }

    public function getCount(): int
    {
        return $this->count;
    }
}
