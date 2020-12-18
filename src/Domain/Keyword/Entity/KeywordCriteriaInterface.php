<?php
declare(strict_types=1);

namespace SampleDomain\Keyword\Entity;

interface KeywordCriteriaInterface
{
    /**
     * キーワード登録
     * @param Keyword $word
     */
    public function add(
        Keyword $word
    ): void;
}
