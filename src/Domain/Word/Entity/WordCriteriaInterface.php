<?php
declare(strict_types=1);

namespace SampleDomain\Word\Entity;

interface WordCriteriaInterface
{
    /**
     * キーワード登録
     * @param Word $word
     */
    public function add(Word $word): void;
}
