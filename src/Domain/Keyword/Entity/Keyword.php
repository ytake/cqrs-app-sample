<?php
declare(strict_types=1);

namespace SampleDomain\Keyword\Entity;

use SampleDomain\User\ValueObject\UserId;

final class Keyword
{
    /**
     * @param UserId $user
     * @param string $word
     */
    public function __construct(
        private UserId $user,
        private string $word
    ) {
    }

    public function getUserId(): UserId
    {
        return $this->user;
    }

    public function getWord(): string
    {
        return $this->word;
    }
}
