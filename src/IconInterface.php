<?php

declare(strict_types=1);

namespace YiiRocks\SvgInline;

interface IconInterface
{
    public function get(string $key): mixed;
    public function getTitle(): string;
}
